var dealershipsMap = null;

if (!window.YAPP) window.YAPP = {};
if (!window.YAPP.DEALERSHIPS) window.YAPP.DEALERSHIPS = {};

window.YAPP.DEALERSHIPS.DATA = {
    TAGS: [],
    CITY: [],
    BRAND: [],
    DEALERSHIP: [],
    FIRST: false
};

// Функция надежного ожидания готовности Яндекс Карт
function waitYmapsReady(callback, maxAttempts = 50) {
    let attempts = 0;
    const interval = setInterval(() => {
        attempts++;
        if (typeof ymaps !== 'undefined' && typeof ymaps.Map === 'function') {
            clearInterval(interval);
            ymaps.ready(callback);
        } else if (attempts >= maxAttempts) {
            clearInterval(interval);
            console.warn('Yandex Maps API did not load in time.');
        }
    }, 100);
}

function initMainDealershipsMap() {
    const mapContainer = document.getElementById('dealershipsMap');
    if (!mapContainer || typeof ymaps === 'undefined') return;

    if (!dealershipsMap) {
        dealershipsMap = new ymaps.Map('dealershipsMap', {
            center: [45.348370, 39.393297],
            zoom: 7,
            controls: ['zoomControl']
        }, {
            searchControlProvider: 'yandex#search'
        });
        dealershipsMap.behaviors.disable('scrollZoom');

        dealershipsMap.geoObjects.events.add('click', function(e) {
            let target = e.get('target');
            let placemarkCode = target.properties.get('code');
            const items = window.YAPP.DEALERSHIPS.ITEMS || [];
            items.forEach((i) => {
                if (i.CODE === placemarkCode) {
                    window.YAPP.DEALERSHIPS.DATA.VIEW = i.VIEW;
                }
            });

            if (window.YAPP.DEALERSHIPS.DATA.VIEW) {
                fetch('/api/main-dealership-view/render/', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams(window.YAPP.DEALERSHIPS.DATA.VIEW)
                })
                .then(res => res.text())
                .then(resp => {
                    $('.dealerships-on-main-view-wrap').html(resp).removeClass('d-none');
                    $('.dealerships-on-main-filter').addClass('d-none');
                })
                .catch(() => {});
            }
        });
    }

    renderDealershipsPlacemarks();
}

function renderDealershipsPlacemarks() {
    if (!dealershipsMap || typeof ymaps === 'undefined') return;

    dealershipsMap.geoObjects.removeAll();

    const viewItems = window.YAPP.DEALERSHIPS.VIEW || [];
    if (viewItems.length === 0) return;

    viewItems.forEach((i) => {
        if (!i.COORDS || !i.COORDS.LAT || !i.COORDS.LON) return;
        const placemark = new ymaps.Placemark(
            [Number(i.COORDS.LAT), Number(i.COORDS.LON)],
            {
                balloonContent: i.NAME,
                hintContent: i.NAME,
                balloonContentHeader: i.NAME,
                balloonContentBody: (i.BALLOON && i.BALLOON.CONTENT) ? i.BALLOON.CONTENT : '',
                balloonContentFooter: (i.BALLOON && i.BALLOON.FOOTER) ? i.BALLOON.FOOTER : '',
                code: i.CODE
            },
            {
                iconLayout: 'default#image',
                iconImageHref: '/local/templates/yugavto.theme.2025/assets/images/svg/icon-placemark-map.svg',
                iconImageSize: [32, 38],
                iconImageOffset: [-16, -38]
            }
        );
        dealershipsMap.geoObjects.add(placemark);
    });

    const bounds = dealershipsMap.geoObjects.getBounds();
    if (bounds) {
        dealershipsMap.setBounds(bounds, {
            checkZoomRange: true,
            zoomMargin: 40
        }).then(function() {
            let currentZoom = dealershipsMap.getZoom();
            if (currentZoom >= 16) {
                dealershipsMap.setZoom(16);
            } else if (currentZoom > 7) {
                dealershipsMap.setZoom(currentZoom - 0.5);
            }
        });
    }
}

window.YAPP.DEALERSHIPS.buildVew = function(__select = false) {
    const { TAGS, CITY, BRAND, DEALERSHIP } = window.YAPP.DEALERSHIPS.DATA;
    const allItems = window.YAPP.DEALERSHIPS.ITEMS || [];

    window.YAPP.DEALERSHIPS.VIEW = allItems.filter(item => {
        if (TAGS.length && !item.TAGS?.some(t => TAGS.includes(t.code))) return false;
        if (CITY.length && !item.CITY?.some(c => CITY.includes(c.code))) return false;
        if (BRAND.length && !item.BRAND?.some(b => BRAND.includes(b.code))) return false;
        if (DEALERSHIP.length && !item.DEALERSHIP?.some(d => DEALERSHIP.includes(d.code))) return false;
        return true;
    });

    let brand = [], dealership = [];
    window.YAPP.DEALERSHIPS.VIEW.forEach((item) => {
        if (item.BRAND) {
            item.BRAND.forEach(b => { if (!brand.includes(b.code)) brand.push(b.code); });
        }
        if (item.DEALERSHIP) {
            item.DEALERSHIP.forEach(d => { if (!dealership.includes(d.code)) dealership.push(d.code); });
        }
    });

    if (window.YAPP.DEALERSHIPS.DATA.FIRST) {
        if (__select === 'CITY') {
            $('.dealerships-on-main .form-droplist[data-list="BRAND"] .form-droplist-item').each(function(i, e) {
                $(e).toggleClass('d-none', !brand.includes($(e).data('value')));
            });
            $('.dealerships-on-main .form-droplist[data-list="DEALERSHIP"] .form-droplist-item').each(function(i, e) {
                $(e).toggleClass('d-none', !dealership.includes($(e).data('value')));
            });
        }
    } else {
        $('.dealerships-on-main .form-droplist .form-droplist-item').removeClass('d-none');
    }

    return true;
};

// Запуск инициализации при загрузке DOM
$(function() {
    waitYmapsReady(function() {
        initMainDealershipsMap();
    });
});

// Клик по дропдаунам фильтра
$(document).on('click', '.dealerships-on-main .form-dropcontainer .form-droplist-item', function() {
    const listKey = $(this).data('list');
    if (!listKey) return;

    window.YAPP.DEALERSHIPS.DATA[listKey] = [];
    $(this).parent().find('.form-droplist-item').each(function(i, e) {
        if ($(e).hasClass('selected')) {
            window.YAPP.DEALERSHIPS.DATA[listKey].push($(e).data('value'));
        }
    });

    if (!window.YAPP.DEALERSHIPS.DATA.FIRST) window.YAPP.DEALERSHIPS.DATA.FIRST = true;
    window.YAPP.DEALERSHIPS.buildVew(listKey);
    renderDealershipsPlacemarks();
});

// Клик по табам («Все», «Новые», «С пробегом» и т.д.)
$(document).on('click', '.dealerships-on-main-tabs-item', function() {
    $('.dealerships-on-main-tabs-item').removeClass('active');
    $(this).addClass('active');

    const tabVal = $(this).data('value');
    if (tabVal === 'all') {
        $('.dealerships-on-main .form-dropcontainer .form-droplist-item').removeClass('selected');
        window.YAPP.DEALERSHIPS.DATA.TAGS = [];
    } else {
        window.YAPP.DEALERSHIPS.DATA.TAGS = [tabVal];
    }
    window.YAPP.DEALERSHIPS.buildVew();
    renderDealershipsPlacemarks();
    return false;
});

// Закрытие детальной карточки ДЦ
$(document).on('click', '.dealerships-on-main .dealerships-on-main-view-image-close', function() {
    $('.dealerships-on-main-view-wrap').addClass('d-none');
    $('.dealerships-on-main-filter').removeClass('d-none');
    $('.dealerships-on-main .filter-dropcontainer .filter-droplist-item').removeClass('selected');
    renderDealershipsPlacemarks();
    return false;
});

// Сброс фильтра через крестик .before в дропдауне
$(document).on('click', '.dealerships-on-main .form-dropcontainer .form-dropdown .before', function() {
    const listKey = $(this).parent().data('list');
    if (listKey && window.YAPP.DEALERSHIPS.DATA[listKey]) {
        window.YAPP.DEALERSHIPS.DATA[listKey] = [];
    }
    window.YAPP.DEALERSHIPS.DATA.FIRST = false;
    window.YAPP.DEALERSHIPS.buildVew();
    renderDealershipsPlacemarks();
});

// Синхронизация с глобальным стором выбора города в шапке
function initDealershipsStoreListeners() {
    const store = window.YAppStore;
    if (!store) return;

    store.addEventListener('city:changed', (e) => {
        const selectedCities = e.detail.city || [];
        window.YAPP.DEALERSHIPS.DATA.CITY = [];

        $('.dealerships-on-main .form-dropcontainer[data-list="CITY"] .form-droplist-item')
            .removeClass('selected')
            .each(function(i, e) {
                if (selectedCities.includes($(e).text().trim())) {
                    if (window.YAPP && window.YAPP.FORMS && window.YAPP.FORMS.dropDownSelect) {
                        window.YAPP.FORMS.dropDownSelect($(e));
                    }
                }
            });

        $('.dealerships-on-main .form-dropcontainer[data-list="CITY"] .form-droplist-item').each(function(i, e) {
            if ($(e).hasClass('selected')) {
                window.YAPP.DEALERSHIPS.DATA.CITY.push($(e).data('value'));
            }
        });

        window.YAPP.DEALERSHIPS.buildVew();
        renderDealershipsPlacemarks();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDealershipsStoreListeners);
} else {
    initDealershipsStoreListeners();
}

