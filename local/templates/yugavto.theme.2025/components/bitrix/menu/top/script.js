$(document).on('mouseover', '[role="submenu"]', function(e) {
    $('.submenu').hide();
    $('.submenu[data-menu="'+$(this).data('menu')+'"]').show();
    return false
})
jQuery(function($){
	$(document).mouseup( function(e){ // событие клика по веб-документу
		var el = $( '.submenu' ); // тут указываем ID элемента
		if ( !el.is(e.target) // если клик был не по нашему блоку
		    && el.has(e.target).length === 0 ) { // и не по его дочерним элементам
		el.hide(); // скрываем его
		}
	});
});
jQuery(function($){
	$(document).mouseup( function(e){ // событие клика по веб-документу
		var el = $( '.top-menu-cities, .top-menu-cities-list' ); // тут указываем ID элемента
		if ( !el.is(e.target) // если клик был не по нашему блоку
		    && el.has(e.target).length === 0 ) { // и не по его дочерним элементам
		$('.top-menu-cities-list').addClass('d-none'); // скрываем его
		}
	});
});

jQuery(function($){
    $(document).mouseover( function(e){ // событие клика по веб-документу
        var el = $( '.single_menu' ); // тут указываем ID элемента
        if (el.is(e.target)) // если наведение было не по нашему блоку
        {
            $('.submenu').hide() // скрываем его
        }
    });
});

$(document).on('click', '[role="submenu-mobile"]', function() {
    
    $('[role="submenu-mobile"').removeClass('active');
    $(this).addClass('active');
    $('.submenu-mobile').addClass('d-none');
    $('.submenu-mobile[data-menu="'+$(this).data('menu')+'"]').removeClass('d-none');

    return false;
});
$(document).on('click', '[role="cities"]', function() {
    $('.city-wrap').toggleClass('d-none');
})




$(document).on('click', '.top-menu [role="menu"]', function() {
    $(this).find('img').toggleClass('d-none');
    $('.menu-tablet').toggleClass('d-none');
    $('.submenu-tablet').addClass('d-none');
    return false;
});


$(document).on('click', '.top-menu-cities-item', function() {
    
    $('.top-menu-cities-item[data-name="'+$(this).data('name')+'"]').toggleClass('selected');
    let cities = [];

    YAPP.CONNECTOR.CITIES = [];
    $('.top-menu-cities-item').each(function(i,e) {
        if ( $(e).hasClass('selected') ) cities.push( $(e).data('name') );
    })
    if ( cities.length == 0 ) {
        $('.top-menu-cities-item').addClass('selected');
        $('.top-menu-cities-item').each(function(i,e) {
            if ( $(e).hasClass('selected') ) cities.push( $(e).data('name') );
        })
    }

    YAPP.CONNECTOR.CITIES = [...new Set(cities)];

    $('.top-menu-cities span').text( ((YAPP.CONNECTOR.CITIES.length>1)?YAPP.CITIES.TITLE[YAPP.CONNECTOR.CITIES.length]:YAPP.CONNECTOR.CITIES[0]) );
    switch ( YAPP.CONNECTOR.CITIES.length ) {
        case 4:
            $('.city-menu-title').text('Все города');
            break;
        case 1:
            $('.city-menu-title').text(YAPP.CONNECTOR.CITIES[0]);
            break;
        default:
             $('.city-menu-title').text(YAPP.CONNECTOR.CITIES.length + ' города');
            break;
    }

    YAPP.CONNECTOR.SELECTED_CITY = [... YAPP.CONNECTOR.CITIES];
    let now = new Date();
    let time = now.getTime();
    let expireTime = time+3600;
    now.setTime(expireTime);
    YAPP.setCookie('SELECTED_CITY', JSON.stringify(YAPP.CONNECTOR.SELECTED_CITY), {
        'max-age': now.toUTCString()
    });

    return false;
});
jQuery(function($){
	$(document).mouseup( function(e){ // событие клика по веб-документу
		var el = $( '.city-wrap' ); // тут указываем ID элемента
		if ( !el.is(e.target) // если клик был не по нашему блоку
		    && el.has(e.target).length === 0 ) { // и не по его дочерним элементам
            $('.city-wrap').addClass('d-none');
		}
	});
});
$(document).on('click', '[role="top-menu-cities"], #YappsShowroom .top-menu-cities', function() {
    $('.top-menu-cities-list').toggleClass('d-none');
    $('html, body').animate({
        scrollTop: $('body').offset().top
    }, 300);
    return false;
});


search = function( query ) {
    $.ajax({
        type: 'POST',
        url: '/api/search/render/',
        data: {query: query},
        success: (resp) => {
            $('.search-wrap').html(resp).show();
        },
        error: () => {
        }
    });
}

let f = _.debounce(search, 250);
$('.top-menu input.search').on('input', function() {
    if ( $(this).val().length > 2 ) {
        f($(this).val());
    } else {
        $('.search-wrap').html('').hide();
        $('.top-menu .search-clear').show();
    }
})
$(document).on('click', '.top-menu .search-clear', function() {
    $('.top-menu input.search').val('');
    $(this).hide();
    $('.search-wrap').html('').hide();
});


$(document).on('click', '[role="menu-mobile"]', function() {
    $('.top-menu-mobile').toggleClass('d-flex d-none');
    $('[role="screen"][data-screen="1"]').removeClass('d-none');
    $('[role="screen"][data-screen="2"]').addClass('d-none');
    $(this).find('img').toggleClass('d-none');
    $('.menu-search, .menu-cities').find('img:first-child').removeClass('d-none');
    $('.menu-search, .menu-cities').find('img:last-child').addClass('d-none');
    return false;
});
$(document).on('click', '[role="submenu-mobile"]', function(e) {
    if ( !$(e.target).is('.submenu-item a') ) {
        $('.submenu-mobile[data-menu="'+$(this).data('menu')+'"]').toggle();
        $(this).toggleClass('fw-bold');
        $(this).siblings('.is_submenu').removeClass('fw-bold');
        $(this).siblings('.is_submenu').find('img:first-child').removeClass('d-none');
        $(this).siblings('.is_submenu').find('img:last-child').addClass('d-none');
        $(this).siblings('.is_submenu').find('.submenu-mobile').hide();
        $(this).find('img').toggleClass('d-none');
        return false;
    }
});
$(document).on('click', '[role="change-screen"]', function() {
    $('[role="screen"]').toggleClass('d-none');
    return false;
});

$(document).on('click', '.menu-cities', function() {
    $(this).find('img').toggleClass('d-none');
    $('.menu-search').find('img:first-child').removeClass('d-none');
    $('.menu-search').find('img:last-child').addClass('d-none');
    $('.top-menu-mobile').removeClass('d-none').addClass('d-flex');
    $('[role="screen"][data-screen="2"]').removeClass('d-none');
    $('[role="screen"][data-screen="1"]').addClass('d-none');
    $('[role="menu-mobile"]').find('img:nth-child(1)').addClass('d-none');
    $('[role="menu-mobile"]').find('img:nth-child(2)').removeClass('d-none');
});
$(document).on('click', '.menu-search', function() {
    $(this).find('img').toggleClass('d-none');
    $('.menu-cities').find('img:first-child').removeClass('d-none');
    $('.menu-cities').find('img:last-child').addClass('d-none');
    $('.top-menu-mobile').removeClass('d-none').addClass('d-flex');
    $('[role="screen"][data-screen="1"]').removeClass('d-none');
    $('[role="screen"][data-screen="2"]').addClass('d-none');
    $('[role="menu-mobile"]').find('img:nth-child(1)').addClass('d-none');
    $('[role="menu-mobile"]').find('img:nth-child(2)').removeClass('d-none');
});


YAPP.CIS_FAVORITES = [-1];
YAPP.CIS_COMPARE = [-1];
setInterval(() => {
    if ( YAPP.CIS_FAVORITES.length != YAPP.CONNECTOR.CIS_FAVORITES.length ) {
        YAPP.CIS_FAVORITES = [...YAPP.CONNECTOR.CIS_FAVORITES];
        if ( YAPP.CONNECTOR.CIS_FAVORITES.length > 0 ) {
            $('.top-menu-icon[data="CIS_FAVORITES"]').addClass('active');
            $('.top-menu-icon[data="CIS_FAVORITES"] .icon-count').text(YAPP.CONNECTOR.CIS_FAVORITES.length);
        } else {
            $('.top-menu-icon[data="CIS_FAVORITES"]').removeClass('active');
            $('.top-menu-icon[data="CIS_FAVORITES"] .icon-count').text('');
        }
    }
    if ( YAPP.CIS_COMPARE.length != YAPP.CONNECTOR.CIS_COMPARE.length ) {
        YAPP.CIS_COMPARE = [...YAPP.CONNECTOR.CIS_COMPARE];
        if ( YAPP.CONNECTOR.CIS_COMPARE.length > 0 ) {
            $('.top-menu-icon[data="CIS_COMPARE"]').addClass('active');
            $('.top-menu-icon[data="CIS_COMPARE"] .icon-count').text(YAPP.CONNECTOR.CIS_COMPARE.length);
        } else {
            $('.top-menu-icon[data="CIS_COMPARE"]').removeClass('active');
            $('.top-menu-icon[data="CIS_COMPARE"] .icon-count').text('');
        }
    }
}, 100);