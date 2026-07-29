var dealershipsMap;
if (typeof ymaps !== 'undefined') {
    ymaps.ready(firstInit);
}

function firstInit() {
    setTimeout(() => {
        dealershipsMapInit()
    }, 800);
}

function dealershipsMapInit() {
    if (typeof ymaps === 'undefined') return;

    if ( typeof dealershipsMap != 'undefined' ) dealershipsMap.destroy()

    dealershipsMap = new ymaps.Map('dealershipsMap', {

        center: [45.348370, 39.393297],
        zoom: 6.2
    }, {
        searchControlProvider: 'yandex#search'
    });

    dealershipsMap.behaviors.disable('scrollZoom');

    if ( YAPP.DEALERSHIPS.VIEW.length > 0 ) {
        YAPP.DEALERSHIPS.VIEW.forEach((i) => {
            dealershipsMap.geoObjects.add(
                new ymaps.Placemark(
                    [
                        i.COORDS.LAT,
                        i.COORDS.LON
                    ],
                    {
                        balloonContent: i.NAME,
                        // iconCaption: i.NAME,
                        hintContent: i.NAME,
                        balloonContentHeader: i.NAME,
                        balloonContentBody: i.BALLOON.CONTENT,
                        balloonContentFooter: i.BALLOON.FOOTER,
                        code: i.CODE
                    },
                    {
                        // preset: "islands#yellowDotIconWithCaption"
                        iconLayout: 'default#image',
                        iconImageHref: '/local/templates/yugavto.theme.2025/assets/images/svg/icon-placemark-map.svg',
                        iconImageSize: [32, 38],
                        iconImageOffset: [-16, -38]
                    }
                )
            )
        });
        dealershipsMap.setBounds(dealershipsMap.geoObjects.getBounds()).
            then( function() {
                YAPP.DEALERSHIPS.ZOOM = dealershipsMap.getZoom();
                if ( YAPP.DEALERSHIPS.ZOOM >= 16 ) {
                    YAPP.DEALERSHIPS.ZOOM = 16;
                } else {
                    YAPP.DEALERSHIPS.ZOOM -= 1;
                }
                dealershipsMap.setZoom( YAPP.DEALERSHIPS.ZOOM )
                $('.ymaps-2-1-79-controls__control').css({'inset': '108px 10px auto auto'})
            });
        dealershipsMap.geoObjects.events.add('click', function (e) {
            // Объект на котором произошло событие
            let target = e.get('target');
            YAPP.DEALERSHIPS.ITEMS.forEach((i) => {
                if (i.CODE == target.properties.get('code')) YAPP.DEALERSHIPS.DATA.VIEW = i.VIEW;
            });
            $.ajax({
                type: 'POST',
                url: '/api/main-dealership-view/render/',
                data: YAPP.DEALERSHIPS.DATA.VIEW,
                success: (resp) => {
                    $('.dealerships-on-main-view-wrap').html(resp).removeClass('d-none');
                    $('.dealerships-on-main-filter').addClass('d-none');
    
                },
                error: () => { 
                }
            });
        });
    }
    
}

YAPP.DEALERSHIPS.DATA = {};
YAPP.DEALERSHIPS.DATA.TAGS = [];
YAPP.DEALERSHIPS.DATA.CITY = [];
YAPP.DEALERSHIPS.DATA.BRAND = [];
YAPP.DEALERSHIPS.DATA.DEALERSHIP = [];

YAPP.DEALERSHIPS.DATA.FIRST = false;

YAPP.DEALERSHIPS.buildVew = function( __select = false ) {
    let add = false;
    YAPP.DEALERSHIPS.VIEW = [];
    YAPP.DEALERSHIPS.ITEMS.forEach((item) => {
        add = true;
        if ( YAPP.DEALERSHIPS.DATA.TAGS.length > 0 ) {
            add = false;
            for( let i in item.TAGS ) {
                if ( YAPP.DEALERSHIPS.DATA.TAGS.indexOf(item.TAGS[i].code) >= 0 ) {
                    add = true;
                    if ( YAPP.DEALERSHIPS.DATA.CITY.length > 0 ) {
                        add = false;
                        for( let i in item.CITY ) {
                            if ( YAPP.DEALERSHIPS.DATA.CITY.indexOf(item.CITY[i].code) >= 0 ) {
                                add = true;
                                if ( YAPP.DEALERSHIPS.DATA.BRAND.length > 0 ) {
                                    add = false
                                    for( let i in item.BRAND ) {
                                        if ( YAPP.DEALERSHIPS.DATA.BRAND.indexOf(item.BRAND[i].code) >= 0 ) {
                                            add = true;
                                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                                                add = false
                                                for( let i in item.DEALERSHIP ) {
                                                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                                        add = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            break;
                                        }
                                    }
                                } else {
                                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                                        add = false
                                        for( let i in item.DEALERSHIP ) {
                                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                                add = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                                break;
                            }
                        }
                    } else {
                        if ( YAPP.DEALERSHIPS.DATA.BRAND.length > 0 ) {
                            add = false
                            for( let i in item.BRAND ) {
                                if ( YAPP.DEALERSHIPS.DATA.BRAND.indexOf(item.BRAND[i].code) >= 0 ) {
                                    add = true;
                                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                                        add = false
                                        for( let i in item.DEALERSHIP ) {
                                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                                add = true;
                                                break;
                                            }
                                        }
                                    }
                                    break;
                                }
                            }
                        } else {
                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                                add = false
                                for( let i in item.DEALERSHIP ) {
                                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                        add = true;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    break;
                }
            }
        } else {
            if ( YAPP.DEALERSHIPS.DATA.CITY.length > 0 ) {
                add = false;
                for( let i in item.CITY ) {
                    if ( YAPP.DEALERSHIPS.DATA.CITY.indexOf(item.CITY[i].code) >= 0 ) {
                        add = true;
                        if ( YAPP.DEALERSHIPS.DATA.BRAND.length > 0 ) {
                            add = false
                            for( let i in item.BRAND ) {
                                if ( YAPP.DEALERSHIPS.DATA.BRAND.indexOf(item.BRAND[i].code) >= 0 ) {
                                    add = true;
                                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                                        add = false
                                        for( let i in item.DEALERSHIP ) {
                                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                                add = true;
                                                break;
                                            }
                                        }
                                    }
                                    break;
                                }
                            }
                        } else {
                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                                add = false
                                for( let i in item.DEALERSHIP ) {
                                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                        add = true;
                                        break;
                                    }
                                }
                            }
                        }
                        break;
                    }
                }
            } else {
                if ( YAPP.DEALERSHIPS.DATA.BRAND.length > 0 ) {
                    add = false
                    for( let i in item.BRAND ) {
                        if ( YAPP.DEALERSHIPS.DATA.BRAND.indexOf(item.BRAND[i].code) >= 0 ) {
                            add = true;
                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                                add = false
                                for( let i in item.DEALERSHIP ) {
                                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                        add = true;
                                        break;
                                    }
                                }
                            }
                            break;
                        }
                    }
                } else {
                    if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.length > 0 ) {
                        add = false
                        for( let i in item.DEALERSHIP ) {
                            if ( YAPP.DEALERSHIPS.DATA.DEALERSHIP.indexOf(item.DEALERSHIP[i].code) >= 0 ) {
                                add = true;
                                break;
                            }
                        }
                    }
                }
            }
        }
        if ( add ) YAPP.DEALERSHIPS.VIEW.push(item);
    });
    
    let tags = [], city = [], brand = [], dealership = [];
    YAPP.DEALERSHIPS.VIEW.forEach((item) => {
        for( let i in item.CITY ) {
            if ( city.indexOf(item.CITY[i].code) < 0 ) {
                city.push(item.CITY[i].code);
            }
        }
        for( let i in item.BRAND ) {
            if ( brand.indexOf(item.BRAND[i].code) < 0 ) {
                brand.push(item.BRAND[i].code);
            }
        }
        for( let i in item.DEALERSHIP ) {
            if ( dealership.indexOf(item.DEALERSHIP[i].code) < 0 ) {
                dealership.push(item.DEALERSHIP[i].code);
            }
        }
    });

    console.log(city, brand, dealership)
    

    if ( YAPP.DEALERSHIPS.DATA.FIRST ) {
        
        if ( __select == 'CITY' ) {
            $('.dealerships-on-main .form-droplist[data-list="BRAND"] .form-droplist-item').each(function(i, e) {
                if ( brand.indexOf($(e).data('value')) < 0 ) {
                    $(e).addClass('d-none');
                } else {
                    $(e).removeClass('d-none');
                }
            });
            $('.dealerships-on-main .form-droplist[data-list="DEALERSHIP"] .form-droplist-item').each(function(i, e) {
                if ( dealership.indexOf($(e).data('value')) < 0 ) {
                    $(e).addClass('d-none');
                } else {
                    $(e).removeClass('d-none');
                }
            });
        }
        if ( __select == 'BRAND' ) {
            // $('.dealerships-on-main .filter-dropcontainer[data-list="BRAND"] .filter-droplist-item').each(function(i, e) {
            //     if ( brand.indexOf($(e).data('value')) < 0 ) {
            //         $(e).addClass('d-none');
            //     } else {
            //         $(e).removeClass('d-none');
            //     }
            // });
            console.log(__select);
        }
        if ( __select == 'DEALERSHIP' ) {
            // $('.dealerships-on-main .filter-dropcontainer[data-list="DEALERSHIP"] .filter-droplist-item').each(function(i, e) {
            //     if ( dealership.indexOf($(e).data('value')) < 0 ) {
            //         $(e).addClass('d-none');
            //     } else {
            //         $(e).removeClass('d-none');
            //     }
            // });
            console.log(__select);
        }
    } else {
        $('.dealerships-on-main .form-droplist .form-droplist-item').each(function(i, e) {
            $(e).removeClass('d-none');
        });
        console.log(YAPP.DEALERSHIPS.DATA.FIRST);
    }

    return true;
}
YAPP.DEALERSHIPS.renderTags = function () {
}
YAPP.DEALERSHIPS.renderDropdowns = function( list ) {
}



$(document).on('click', '.dealerships-on-main .form-dropcontainer .form-droplist-item', function() {

    YAPP.DEALERSHIPS.DATA[$(this).data('list')] = [];
    $(this).parent().find('.form-droplist-item').each( function(i,e) {
        if ( $(e).hasClass('selected') ) {
            YAPP.DEALERSHIPS.DATA[$(this).data('list')].push( $(this).data('value') );
        }
    });
    
    if ( !YAPP.DEALERSHIPS.DATA.FIRST ) YAPP.DEALERSHIPS.DATA.FIRST = true;
    YAPP.DEALERSHIPS.buildVew($(this).data('list'));
    dealershipsMapInit();

    return false;
});
$(document).on('click', '.dealerships-on-main-tabs-item', function() {

    $('.dealerships-on-main-tabs-item').removeClass('active');
    $(this).toggleClass('active');

    if ( $(this).data('value') == 'all' ) {
        $('.dealerships-on-main .form-dropcontainer .form-droplist-item').removeClass('selected');
        YAPP.DEALERSHIPS.DATA.TAGS = [];
    } else {
        YAPP.DEALERSHIPS.DATA.TAGS = [$(this).data('value')];
    }
    YAPP.DEALERSHIPS.buildVew();
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
    
    YAPP.DEALERSHIPS.DATA[$(this).parent().data('list')] = [];
    YAPP.DEALERSHIPS.DATA.FIRST = false;
    YAPP.DEALERSHIPS.buildVew();
    dealershipsMapInit();
});


YAPP.DEALERSHIPS.CITY = YAPP.CONNECTOR.SELECTED_CITY.join();
setInterval(() => {
    if (YAPP.DEALERSHIPS.CITY != YAPP.CONNECTOR.SELECTED_CITY.join()) {
        YAPP.DEALERSHIPS.CITY = YAPP.CONNECTOR.SELECTED_CITY.join();

        YAPP.DEALERSHIPS.DATA.CITY = [];
        $('.dealerships-on-main .form-dropcontainer[data-list="CITY"] .form-droplist-item').removeClass('selected').each( function(i,e) {
            if ( YAPP.CONNECTOR.SELECTED_CITY.indexOf($(e).text()) >= 0 ) {
                YAPP.FORMS.dropDownSelect( $(e) );
            }
        });
        $('.dealerships-on-main .form-dropcontainer[data-list="CITY"] .form-droplist-item').each( function(i,e) {
            if ( $(e).hasClass('selected') ) {
                YAPP.DEALERSHIPS.DATA.CITY.push( $(e).data('value') );
            }
        });
        YAPP.DEALERSHIPS.buildVew();
        dealershipsMapInit();
    }
}, 100);
