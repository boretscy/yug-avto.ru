var swiperCompare = new Swiper(".swiper-compare", {
    freeMode: true,
    scrollbar: {
        el: ".swiper-scrollbar",
        hide: true,
    },
    navigation: {
        nextEl: ".compare-nav-next",
        prevEl: ".compare-nav-prev",
    },
    breakpoints: {
        320: {
            slidesPerView: 1.1,
            spaceBetween: 10,
        },
        768: {
            slidesPerView: 1.3,
            spaceBetween: 24,
        },
        1024: {
            slidesPerView: 1.8,
            spaceBetween: 24,
        },
        1200: {
            slidesPerView: 2.9,
            spaceBetween: 24,
        }
    },
});
$(document).on('click', '.compare-body-title', function() {
    $('.compare-body-items[data-index="'+$(this).data('index')+'"]').toggleClass('d-none')
    $(this).find('img').toggleClass('rotate-180')
});
