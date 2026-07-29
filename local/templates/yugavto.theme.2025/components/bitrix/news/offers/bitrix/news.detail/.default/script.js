$('a[role="scroll"]').click(function() {

    console.log($('.offer-cis'))

    $('html, body').animate({ scrollTop: $('.offer-cis').offset().top }, 200);
    return false;
});

const swiper_cis_new = new Swiper('.swiper-cis-new', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-cis-new-button-next',
        prevEl: '.swiper-cis-new-button-prev',
    },
    slidesPerView: 4,
    spaceBetween: 25,
    
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        750: {
            slidesPerView: 2,
            spaceBetween: 25
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 25
        },
    }
})

$(document).on('click', '[role="setDealership"]', function() {
    window['SELECTED_DEALERSHIP_CODE--_line'] = $(this).data('dealership')
    window['SELECTED_DEALERSHIP_CODE--_block'] = $(this).data('dealership')
    window['SELECTED_DEALERSHIP_CODE--_modal'] = $(this).data('dealership')

    console.log(window['SELECTED_DEALERSHIP_CODE--_line'],window['SELECTED_DEALERSHIP_CODE--_block'], window['SELECTED_DEALERSHIP_CODE--_modal']);
})