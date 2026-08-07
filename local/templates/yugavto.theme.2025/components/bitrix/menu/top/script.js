const getStore = () => window.YAppStore;

$(document).on('mouseover', '[role="submenu"]', function(e) {
    $('.submenu').hide();
    $('.submenu[data-menu="'+$(this).data('menu')+'"]').show();
    return false;
});

jQuery(function($){
    $(document).mouseup( function(e){
        var el = $( '.submenu' );
        if ( !el.is(e.target) && el.has(e.target).length === 0 ) {
            el.hide();
        }
    });

    $(document).mouseup( function(e){
        var el = $( '.top-menu-cities, .top-menu-cities-list' );
        if ( !el.is(e.target) && el.has(e.target).length === 0 ) {
            $('.top-menu-cities-list').addClass('d-none');
        }
    });

    $(document).mouseover( function(e){
        var el = $( '.single_menu' );
        if (el.is(e.target)) {
            $('.submenu').hide();
        }
    });
});

$(document).on('click', '[role="submenu-mobile"]', function() {
    $('[role="submenu-mobile"]').removeClass('active');
    $(this).addClass('active');
    $('.submenu-mobile').addClass('d-none');
    $('.submenu-mobile[data-menu="'+$(this).data('menu')+'"]').removeClass('d-none');
    return false;
});

$(document).on('click', '[role="cities"]', function() {
    $('.city-wrap').toggleClass('d-none');
});

$(document).on('click', '.top-menu [role="menu"]', function() {
    $(this).find('img').toggleClass('d-none');
    $('.menu-tablet').toggleClass('d-none');
    $('.submenu-tablet').addClass('d-none');
    return false;
});

$(document).on('click', '.top-menu-cities-item', function() {
    $('.top-menu-cities-item[data-name="'+$(this).data('name')+'"]').toggleClass('selected');
    let cities = [];

    $('.top-menu-cities-item').each(function(i, e) {
        if ($(e).hasClass('selected')) cities.push($(e).data('name'));
    });

    if (cities.length === 0) {
        $('.top-menu-cities-item').addClass('selected');
        $('.top-menu-cities-item').each(function(i, e) {
            if ($(e).hasClass('selected')) cities.push($(e).data('name'));
        });
    }

    const uniqueCities = [...new Set(cities)];

    switch (uniqueCities.length) {
        case 4:
            $('.city-menu-title').text('Все города');
            break;
        case 1:
            $('.city-menu-title').text(uniqueCities[0]);
            break;
        default:
            $('.city-menu-title').text(uniqueCities.length + ' города');
            break;
    }

    if (getStore()) {
        getStore().setCity(uniqueCities);
    }
    return false;
});

jQuery(function($){
    $(document).mouseup( function(e){
        var el = $( '.city-wrap' );
        if ( !el.is(e.target) && el.has(e.target).length === 0 ) {
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

const search = function(query) {
    fetch('/api/search/render/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ query })
    })
    .then(res => res.text())
    .then(resp => {
        $('.search-wrap').html(resp).show();
    })
    .catch(() => {});
};

let debounceSearchTimer = null;
$('.top-menu input.search').on('input', function() {
    const val = $(this).val();
    clearTimeout(debounceSearchTimer);
    if (val.length > 2) {
        debounceSearchTimer = setTimeout(() => search(val), 250);
    } else {
        $('.search-wrap').html('').hide();
        $('.top-menu .search-clear').show();
    }
});

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
    if (!$(e.target).is('.submenu-item a')) {
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

// Реактивное обновление счетчиков Избранного и Сравнения через YAppStore
function initTopMenuStoreListeners() {
    const store = getStore();
    if (!store) return;

    store.addEventListener('favorites:updated', (e) => {
        const count = e.detail.count;
        const favIcons = document.querySelectorAll('.top-menu-icon[data="CIS_FAVORITES"]');
        favIcons.forEach(icon => {
            const countEl = icon.querySelector('.icon-count');
            if (count > 0) {
                icon.classList.add('active');
                if (countEl) countEl.textContent = count;
            } else {
                icon.classList.remove('active');
                if (countEl) countEl.textContent = '';
            }
        });
    });

    store.addEventListener('compare:updated', (e) => {
        const count = e.detail.count;
        const compareIcons = document.querySelectorAll('.top-menu-icon[data="CIS_COMPARE"]');
        compareIcons.forEach(icon => {
            const countEl = icon.querySelector('.icon-count');
            if (count > 0) {
                icon.classList.add('active');
                if (countEl) countEl.textContent = count;
            } else {
                icon.classList.remove('active');
                if (countEl) countEl.textContent = '';
            }
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTopMenuStoreListeners);
} else {
    initTopMenuStoreListeners();
}