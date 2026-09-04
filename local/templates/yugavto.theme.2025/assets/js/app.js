YAPP.getWorld = function ( q = 1, f = 'a' ) {

    let res = {
        'c': ['цвет', 'цвета', 'цветов'],
        'a': ['автомобиль', 'автомобиля', 'автомобилей'],
        'n': ['новый', 'новых', 'новых']
    }
    let t = [
        [1],
        [2,3,4]
    ]
    for (let i=2; i<=300; i++) {
        t[0].push(i*10+1)
        t[1].push(i*10+2)
        t[1].push(i*10+3)
        t[1].push(i*10+4)
    }

    if ( t[0].indexOf(Number(q)) >= 0 ) return res[f][0]
    if ( t[1].indexOf(Number(q)) >= 0 ) return res[f][1]
    return res[f][2]
}
YAPP.getCookie = function(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
YAPP.setCookie = function(name, value, options = {}) {

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
        ...options
    };
  
    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }
  
    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);
  
    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }
  
    document.cookie = updatedCookie;
}
YAPP.deleteCookie = function(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}

// Инициализируем коннекторы на основе кук без перезаписи всего объекта
if (!YAPP.CONNECTOR) {
    YAPP.CONNECTOR = {};
}

// Инициализируем коннекторы на основе стора / кук
function syncConnectorFromStore() {
    if (window.YAppStore) {
        YAPP.CONNECTOR.CIS_FAVORITES = window.YAppStore.favorites;
        YAPP.CONNECTOR.CIS_COMPARE = window.YAppStore.compare;
    } else {
        try {
            YAPP.CONNECTOR.CIS_FAVORITES = JSON.parse(YAPP.getCookie('CIS_FAVORITES') || '[]');
        } catch(e) { YAPP.CONNECTOR.CIS_FAVORITES = []; }
        try {
            YAPP.CONNECTOR.CIS_COMPARE = JSON.parse(YAPP.getCookie('CIS_COMPARE') || '[]');
        } catch(e) { YAPP.CONNECTOR.CIS_COMPARE = []; }
    }
    if (!Array.isArray(YAPP.CONNECTOR.CIS_FAVORITES)) YAPP.CONNECTOR.CIS_FAVORITES = [];
    if (!Array.isArray(YAPP.CONNECTOR.CIS_COMPARE)) YAPP.CONNECTOR.CIS_COMPARE = [];
}
syncConnectorFromStore();

// Реактивная синхронизация карточек авто с событиями стора
if (window.YAppStore) {
    window.YAppStore.addEventListener('favorites:updated', function(e) {
        if (YAPP.CONNECTOR) YAPP.CONNECTOR.CIS_FAVORITES = e.detail.favorites;
        $('[data-action="toggle-fav-com"][data-target="CIS_FAVORITES"][data-vehicle="' + e.detail.id + '"]')
            .toggleClass('active', e.detail.action === 'added');
    });
    window.YAppStore.addEventListener('compare:updated', function(e) {
        if (YAPP.CONNECTOR) YAPP.CONNECTOR.CIS_COMPARE = e.detail.compare;
        $('[data-action="toggle-fav-com"][data-target="CIS_COMPARE"][data-vehicle="' + e.detail.id + '"]')
            .toggleClass('active', e.detail.action === 'added');
    });
}

// Функция подсветки активных сердечек / сравнений на странице (для подборок и каталога)
YAPP.highlightActiveCards = function() {
    for (let target of ['CIS_FAVORITES', 'CIS_COMPARE']) {
        let arr = YAPP.CONNECTOR[target] || [];
        $('[data-target="' + target + '"]').each(function() {
            let vehicle = Number($(this).data('vehicle'));
            if (arr.indexOf(vehicle) >= 0) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
    }
};

// Выполняем инициализацию и подсветку при загрузке
$(function() {
    syncConnectorFromStore();
    YAPP.highlightActiveCards();
});

// Клик-обработчик для добавления/удаления (сердечки и весы)
$(document).on('click', '[data-action="toggle-fav-com"]', function(e) {
    e.preventDefault();
    let vehicle = Number($(this).data('vehicle')), target = $(this).data('target');
    if (!vehicle || !target) return false;

    let removed = false;
    if (window.YAppStore) {
        if (target === 'CIS_FAVORITES') {
            const exists = window.YAppStore.favorites.indexOf(vehicle) >= 0;
            window.YAppStore.toggleFavorite(vehicle);
            removed = exists;
        } else if (target === 'CIS_COMPARE') {
            const exists = window.YAppStore.compare.indexOf(vehicle) >= 0;
            window.YAppStore.toggleCompare(vehicle);
            removed = exists;
        }
        if (YAPP.CONNECTOR) {
            YAPP.CONNECTOR.CIS_FAVORITES = window.YAppStore.favorites;
            YAPP.CONNECTOR.CIS_COMPARE = window.YAppStore.compare;
        }
    } else {
        let indx = YAPP.CONNECTOR[target].indexOf(vehicle);
        if ( indx >= 0 ) {
            YAPP.CONNECTOR[target].splice(indx, 1);
            removed = true;
        } else {
            YAPP.CONNECTOR[target].push(vehicle);
        }
        YAPP.setCookie(target, JSON.stringify(YAPP.CONNECTOR[target]), {'max-age': 3600*24*14});
        $('[data-action="toggle-fav-com"][data-target="' + target + '"][data-vehicle="' + vehicle + '"]')
            .toggleClass('active', !removed);
    }

    // Если мы находимся на странице избранного (/cars/favorites/) и удалили из избранного
    if (window.location.pathname.indexOf('/favorites/') >= 0 && target === 'CIS_FAVORITES' && removed) {
        let $item = $(this).closest('.vehicle-list-item');
        if ($item.length) {
            $item.remove();
        }
        const remaining = window.YAppStore ? window.YAppStore.favorites.length : (YAPP.CONNECTOR.CIS_FAVORITES || []).length;
        if (remaining === 0) {
            window.location.reload();
        }
    }

    return false;
});

// Клик-обработчик для "Удалить" конкретную карточку (используется в Сравнении)
$(document).on('click', 'a[href*="action=delete"]', function(e) {
    let urlStr = $(this).attr('href');
    if (urlStr) {
        let action = '';
        let vehicle = 0;
        let searchPart = urlStr.split('?')[1];
        if (searchPart) {
            let params = searchPart.split('&');
            for (let p of params) {
                let pair = p.split('=');
                if (pair[0] === 'action') action = pair[1];
                if (pair[0] === 'vehicle') vehicle = Number(pair[1]);
            }
        }
        if (action === 'delete' && vehicle) {
            e.preventDefault();
            let isCompare = window.location.pathname.indexOf('/compare/') >= 0;
            let target = isCompare ? 'CIS_COMPARE' : 'CIS_FAVORITES';
            
            if (window.YAppStore) {
                if (isCompare) {
                    window.YAppStore.removeCompare(vehicle);
                } else {
                    window.YAppStore.removeFavorite(vehicle);
                }
                if (YAPP.CONNECTOR) {
                    YAPP.CONNECTOR.CIS_FAVORITES = window.YAppStore.favorites;
                    YAPP.CONNECTOR.CIS_COMPARE = window.YAppStore.compare;
                }
            } else {
                let indx = YAPP.CONNECTOR[target].indexOf(vehicle);
                if (indx >= 0) {
                    YAPP.CONNECTOR[target].splice(indx, 1);
                    YAPP.setCookie(target, JSON.stringify(YAPP.CONNECTOR[target]), {'max-age': 3600*24*14});
                }
            }

            const currentLength = window.YAppStore 
                ? (isCompare ? window.YAppStore.compare.length : window.YAppStore.favorites.length)
                : (YAPP.CONNECTOR[target] || []).length;

            if (currentLength === 0) {
                window.location.reload();
            } else {
                let $item = $(this).closest('.vehicle-list-item');
                if ($item.length) {
                    $item.remove();
                } else {
                    $(this).closest('td, th, .vehicle-compare-col, .col-md-6').remove();
                }
                
                if (isCompare) {
                    if (typeof swiperCompare !== 'undefined' && swiperCompare && typeof swiperCompare.update === 'function') {
                        swiperCompare.update();
                    } else {
                        window.location.reload();
                    }
                }
            }
        }
    }
});

// Клик-обработчик для "Очистить" (Избранное / Сравнение)
$(document).on('click', 'a[href*="action=clear"]', function(e) {
    e.preventDefault();
    let isCompare = window.location.pathname.indexOf('/compare/') >= 0;
    let target = isCompare ? 'CIS_COMPARE' : 'CIS_FAVORITES';

    if (window.YAppStore) {
        if (isCompare) {
            window.YAppStore.clearCompare();
        } else {
            window.YAppStore.clearFavorites();
        }
        if (YAPP.CONNECTOR) {
            YAPP.CONNECTOR.CIS_FAVORITES = window.YAppStore.favorites;
            YAPP.CONNECTOR.CIS_COMPARE = window.YAppStore.compare;
        }
    } else {
        YAPP.setCookie(target, JSON.stringify([]), {'max-age': -1});
        if (YAPP.CONNECTOR) YAPP.CONNECTOR[target] = [];
    }

    window.location.href = window.location.pathname;
});