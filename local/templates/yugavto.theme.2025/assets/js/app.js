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

try {
    YAPP.CONNECTOR.CIS_FAVORITES = JSON.parse(YAPP.getCookie('CIS_FAVORITES') || '[]');
} catch(e) {}
try {
    YAPP.CONNECTOR.CIS_COMPARE = JSON.parse(YAPP.getCookie('CIS_COMPARE') || '[]');
} catch(e) {}
if (!Array.isArray(YAPP.CONNECTOR.CIS_FAVORITES)) YAPP.CONNECTOR.CIS_FAVORITES = [];
if (!Array.isArray(YAPP.CONNECTOR.CIS_COMPARE)) YAPP.CONNECTOR.CIS_COMPARE = [];

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
    YAPP.highlightActiveCards();
});

// Клик-обработчик для добавления/удаления (сердечки и весы)
$(document).on('click', '[data-action="toggle-fav-com"]', function() {
    let vehicle = Number($(this).data('vehicle')), target = $(this).data('target');
    let indx = YAPP.CONNECTOR[target].indexOf(vehicle);
    let removed = false;
    if ( indx >= 0 ) {
        YAPP.CONNECTOR[target].splice(indx, 1);
        removed = true;
    } else {
        YAPP.CONNECTOR[target].push(vehicle);
    }
    $(this).toggleClass('active');
    
    YAPP.setCookie(target, JSON.stringify(YAPP.CONNECTOR[target]), {'max-age': 3600*24*14});

    // Если мы находимся на странице избранного (/cars/favorites/) и удалили из избранного
    if (window.location.pathname.indexOf('/favorites/') >= 0 && target === 'CIS_FAVORITES' && removed) {
        let $item = $(this).closest('.vehicle-list-item');
        if ($item.length) {
            $item.remove();
        }
        if (YAPP.CONNECTOR.CIS_FAVORITES.length === 0) {
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
            
            let indx = YAPP.CONNECTOR[target].indexOf(vehicle);
            if (indx >= 0) {
                YAPP.CONNECTOR[target].splice(indx, 1);
                YAPP.setCookie(target, JSON.stringify(YAPP.CONNECTOR[target]), {'max-age': 3600*24*14});
            }

            if (YAPP.CONNECTOR[target].length === 0) {
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