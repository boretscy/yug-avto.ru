$(document).on('click', '.vehicle-tabs-title-item', function() {
    if ( $(this).hasClass('b-b-yalightgray') ) {
        $('.vehicle-tabs-title-item').toggleClass('c-yadarkgray b-b-yalightgray b-b-yayellow');
        $('.vehicle-tabs-content').toggleClass('active');
    }
    return false;
});
$(document).on('click', '.vehicle-tabs-content-accordeon-title', function() {
    $(this).find('img').toggleClass('rotate-180');
    $('.vehicle-options').each( (i,e) => {
        if ( $(e).data('index') == $(this).data('index') ) {
            $(e).slideToggle(200);
        } else {
            $(e).slideUp(200);
            $('.vehicle-tabs-content-accordeon-title[data-index="'+$(e).data('index')+'"]').find('img').removeClass('rotate-180');
        }
    });
});
$(document).on('click', '.toggle-vehicle-options[role="open"]', () => {
    $('.vehicle-tabs-content-accordeon-title').find('img').addClass('rotate-180');
    $('.vehicle-options').each( function(i,e) {
        $(e).slideDown(200);
    });
    $('.toggle-vehicle-options').toggleClass('d-none');
});
$(document).on('click', '.toggle-vehicle-options[role="hide"]', () => {
    $('.vehicle-tabs-content-accordeon-title').find('img').removeClass('rotate-180');
    $('.vehicle-options').each( function(i,e) {
        $(e).slideUp(200);
    });
    $('.toggle-vehicle-options').toggleClass('d-none');
});

$(document).on('click', '.vehicle-discounts-item', function() {
    
    $(this).toggleClass('active');
    $(this).find('.vehicle-discounts-item-check').toggleClass('b-yalightgray');
    $(this).find('.vehicle-discounts-item-check img').toggleClass('d-none');

    let minPrice = parseInt( String($(this).data('min')).replace(/\D/g, "") );
    let price = parseInt( String($(this).data('price')).replace(/\D/g, "") );
    let discount = 0;

    $('.vehicle-discounts-item.active').each( function(i,e) {
        discount += parseInt( String($(this).data('sum')).replace(/\D/g, "") );
    });
    if ( price - discount < minPrice ) discount = price - minPrice;

    $('[role="min-price"]').text( formatNumber(price-discount)+' ₽' );
});

var swiperVehicleThumbs = new Swiper(".vehicle-swiper-thumbs", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
});
var swiperVehicle = new Swiper(".vehicle-swiper", {
    spaceBetween: 10,
    navigation: {
        nextEl: ".vehicle-swiper-next",
        prevEl: ".vehicle-swiper-prev",
    },
    thumbs: {
      swiper: swiperVehicleThumbs,
    },
});
var swiperVehicleRecomended = new Swiper(".vehicle-recomended-swiper", {
    spaceBetween: 24,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    navigation: {
        nextEl: ".vehicle-recomended-swiper-next",
        prevEl: ".vehicle-recomended-swiper-prev",
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
            slidesPerGroup: 1,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 24,
            slidesPerGroup: 6,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 24,
            slidesPerGroup: 4,
        },
        1440: {
            slidesPerView: 4,
            spaceBetween: 24,
            slidesPerGroup: 6,
        }
    },
});
var swiperVehicleOthers = new Swiper(".vehicle-others-swiper", {
    spaceBetween: 24,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    navigation: {
        nextEl: ".vehicle-others-swiper-next",
        prevEl: ".vehicle-others-swiper-prev",
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
            slidesPerGroup: 1,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 24,
            slidesPerGroup: 6,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 24,
            slidesPerGroup: 4,
        },
        1440: {
            slidesPerView: 4,
            spaceBetween: 24,
            slidesPerGroup: 6,
        }
    },
});



$(document).on('click', '.vehicle-tabs-item', function() {
    $('.vehicle-tabs-item').removeClass('active');
    $(this).addClass('active');
    $('.vehicle-tabs-content-wrap').addClass('d-none');
    $('.vehicle-tabs-content-wrap[data-action="'+$(this).data('action')+'"]').removeClass('d-none');
});
