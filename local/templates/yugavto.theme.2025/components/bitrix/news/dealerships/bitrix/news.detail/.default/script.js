
YAPP.SwiperVehicles = new Swiper('.swiper-vehicles', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-vehicles-button-next',
        prevEl: '.swiper-vehicles-button-prev',
    },
    slidesPerView: 4,
    spaceBetween: 24,

    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 24
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 24
        },
    }
});
///////////// Vehicle card
///////////// Vehicle card
$(document).on('mousemove', '.vehicle-card-images', function(e) {
    let el = e.currentTarget.getBoundingClientRect();
    let indx = 0;
    let w = el.width / 4;

    if ( e.clientX >= el.left && e.clientX < el.left + w) {
        indx = 0;
    } else if ( e.clientX >= el.left+w && e.clientX < el.left+w+w ) {
        indx = 1;
    } else if ( e.clientX >= el.left+w+w && e.clientX < el.left+w+w+w ) {
        indx = 2;
    } else if ( e.clientX >= el.left+w+w+w && e.clientX <= el.right) {
        indx = 3;
    }
    
    $(this).find('.vehicle-card-images-item-container').hide()
    $(this).find('.vehicle-card-images-item-container[data-index="'+indx+'"]').show()
    $(this).find('.vehicle-card-images-row-item').removeClass('active')
    $(this).find('.vehicle-card-images-row-item[data-index="'+indx+'"]').addClass('active')
});
document.querySelectorAll('.vehicle-card-images').forEach( (item) => {
    item.addEventListener('touchmove', (e) => {
        e.preventDefault();
        let el = e.currentTarget.getBoundingClientRect();
        let indx = 0;
        let w = el.width / 4;

        if ( e.touches[0].clientX >= el.left && e.touches[0].clientX < el.left + w) {
            indx = 0;
        } else if ( e.touches[0].clientX >= el.left+w && e.touches[0].clientX < el.left+w+w ) {
            indx = 1;
        } else if ( e.touches[0].clientX >= el.left+w+w && e.touches[0].clientX < el.left+w+w+w ) {
            indx = 2;
        } else if ( e.touches[0].clientX >= el.left+w+w+w && e.touches[0].clientX <= el.right) {
            indx = 3;
        }
        
        $(item).find('.vehicle-card-images-item-container').hide()
        $(item).find('.vehicle-card-images-item-container[data-index="'+indx+'"]').show()
        $(item).find('.vehicle-card-images-row-item').removeClass('active')
        $(item).find('.vehicle-card-images-row-item[data-index="'+indx+'"]').addClass('active')
    })
});

YAPP.SwiperNews = new Swiper('.swiper-news-on-main', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-news-on-main-button-next',
        prevEl: '.swiper-news-on-main-button-prev',
    },
    slidesPerView: 3,
    spaceBetween: 30,
    slidesPerGroup: 3,

    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        750: {
            slidesPerView: 2,
            spaceBetween: 30
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 30
        },
    }
});