(function() {
    function initSwiperNews() {
        if (typeof Swiper === 'undefined') {
            setTimeout(initSwiperNews, 100);
            return;
        }
        var containers = document.querySelectorAll('.swiper-news-on-main');
        containers.forEach(function(sliderEl) {
            if (sliderEl.swiper) return;
            var wrap = sliderEl.closest('.container') || sliderEl.parentElement;
            var instance = new Swiper(sliderEl, {
                pagination: {
                    el: wrap ? wrap.querySelector('.swiper-pagination') : '.swiper-pagination',
                    type: "fraction",
                },
                navigation: {
                    nextEl: wrap ? wrap.querySelector('.swiper-news-on-main-button-next') : '.swiper-news-on-main-button-next',
                    prevEl: wrap ? wrap.querySelector('.swiper-news-on-main-button-prev') : '.swiper-news-on-main-button-prev',
                },
                slidesPerView: 3,
                spaceBetween: 24,
                slidesPerGroup: 1,
                watchOverflow: true,
                observer: true,
                observeParents: true,
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    750: {
                        slidesPerView: 2,
                        spaceBetween: 12
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 12
                    },
                }
            });
            if (window.YAPP) {
                window.YAPP.SwiperNewsOnMain = instance;
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSwiperNews);
    } else {
        initSwiperNews();
    }
})();