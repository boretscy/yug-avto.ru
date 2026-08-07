var dealershipsMap;
if (typeof ymaps !== 'undefined') {
    ymaps.ready(firstInit);
}

function firstInit() {
    setTimeout(() => {
        dealershipsMapInit();
    }, 800);
}

function dealershipsMapInit() {
    if (typeof ymaps === 'undefined') return;

    if (typeof dealershipsMap !== 'undefined' && dealershipsMap) {
        dealershipsMap.destroy();
    }

    dealershipsMap = new ymaps.Map('dealershipsMap', {
        center: [45.348370, 39.393297],
        zoom: 6.2
    }, {
        searchControlProvider: 'yandex#search'
    });

    dealershipsMap.behaviors.disable('scrollZoom');

    if (window.YAPP && window.YAPP.DEALERSHIPS && window.YAPP.DEALERSHIPS.VIEW && window.YAPP.DEALERSHIPS.VIEW.length > 0) {
        window.YAPP.DEALERSHIPS.VIEW.forEach((i) => {
            dealershipsMap.geoObjects.add(
                new ymaps.Placemark(
                    [i.COORDS.LAT, i.COORDS.LON],
                    {
                        balloonContent: i.NAME,
                        hintContent: i.NAME,
                        balloonContentHeader: i.NAME,
                        balloonContentBody: i.BALLOON.CONTENT,
                        balloonContentFooter: i.BALLOON.FOOTER,
                        code: i.CODE
                    },
                    {
                        iconLayout: 'default#image',
                        iconImageHref: '/local/templates/yugavto.theme.2025/assets/images/svg/icon-placemark-map.svg',
                        iconImageSize: [32, 38],
                        iconImageOffset: [-16, -38]
                    }
                )
            );
        });

        dealershipsMap.setBounds(dealershipsMap.geoObjects.getBounds()).then(function() {
            window.YAPP.DEALERSHIPS.ZOOM = dealershipsMap.getZoom();
            if (window.YAPP.DEALERSHIPS.ZOOM >= 16) {
                window.YAPP.DEALERSHIPS.ZOOM = 16;
            } else {
                window.YAPP.DEALERSHIPS.ZOOM -= 1;
            }
            dealershipsMap.setZoom(window.YAPP.DEALERSHIPS.ZOOM);
            $('.ymaps-2-1-79-controls__control').css({ 'inset': '108px 10px auto auto' });
        });

        dealershipsMap.geoObjects.events.add('click', function(e) {
            let target = e.get('target');
            window.YAPP.DEALERSHIPS.ITEMS.forEach((i) => {
                if (i.CODE === target.properties.get('code')) {
                    window.YAPP.DEALERSHIPS.DATA.VIEW = i.VIEW;
                }
            });
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
        });
    }
}

if (!window.YAPP) window.YAPP = {};
if (!window.YAPP.DEALERSHIPS) window.YAPP.DEALERSHIPS = {};

window.YAPP.DEALERSHIPS.DATA = {
    TAGS: [],
    CITY: [],
    BRAND: [],
    DEALERSHIP: [],
    FIRST: false
};

window.YAPP.DEALERSHIPS.buildVew = function(__select = false) {
    const { TAGS, CITY, BRAND, DEALERSHIP } = window.YAPP.DEALERSHIPS.DATA;

    window.YAPP.DEALERSHIPS.VIEW = window.YAPP.DEALERSHIPS.ITEMS.filter(item => {
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

$(document).on('click', '.dealerships-on-main .form-dropcontainer .form-droplist-item', function() {
    const listKey = $(this).data('list');
    window.YAPP.DEALERSHIPS.DATA[listKey] = [];
    $(this).parent().find('.form-droplist-item').each(function(i, e) {
        if ($(e).hasClass('selected')) {
            window.YAPP.DEALERSHIPS.DATA[listKey].push($(e).data('value'));
        }
    });

    if (!window.YAPP.DEALERSHIPS.DATA.FIRST) window.YAPP.DEALERSHIPS.DATA.FIRST = true;
    window.YAPP.DEALERSHIPS.buildVew(listKey);
    dealershipsMapInit();
    return false;
});

$(document).on('click', '.dealerships-on-main-tabs-item', function() {
    $('.dealerships-on-main-tabs-item').removeClass('active');
    $(this).addClass('active');

    if ($(this).data('value') === 'all') {
        $('.dealerships-on-main .form-dropcontainer .form-droplist-item').removeClass('selected');
        window.YAPP.DEALERSHIPS.DATA.TAGS = [];
    } else {
        window.YAPP.DEALERSHIPS.DATA.TAGS = [$(this).data('value')];
    }
    window.YAPP.DEALERSHIPS.buildVew();
    dealershipsMapInit();
    return false;
});

$(document).on('click', '.dealerships-on-main .dealerships-on-main-view-image-close', function() {
    $('.dealerships-on-main-view-wrap').addClass('d-none');
    $('.dealerships-on-main-filter').removeClass('d-none');
    $('.dealerships-on-main .filter-dropcontainer .filter-droplist-item').removeClass('selected');
    dealershipsMapInit();
    return false;
});

$(document).on('click', '.form-dropcontainer .form-dropdown .before', function() {
    const listKey = $(this).parent().data('list');
    window.YAPP.DEALERSHIPS.DATA[listKey] = [];
    window.YAPP.DEALERSHIPS.DATA.FIRST = false;
    window.YAPP.DEALERSHIPS.buildVew();
    dealershipsMapInit();
});

function initDealershipsStoreListeners() {
    const store = window.YAppStore;
    if (!store) return;

    store.addEventListener('city:changed', (e) => {
        const selectedCities = e.detail.city || [];
        window.YAPP.DEALERSHIPS.DATA.CITY = [];

        $('.dealerships-on-main .form-dropcontainer[data-list="CITY"] .form-droplist-item')
            .removeClass('selected')
            .each(function(i, e) {
                if (selectedCities.includes($(e).text())) {
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
        dealershipsMapInit();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDealershipsStoreListeners);
} else {
    initDealershipsStoreListeners();
}
