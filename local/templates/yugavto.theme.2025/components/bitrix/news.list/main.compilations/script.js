const CompilationsOnMain_range_price = $('.main-compilations [data-range="price"] .range-selected');
const CompilationsOnMain_rangeInput_price = $('.main-compilations [data-range="price"][role="range"] .range-input input');
const CompilationsOnMain_rangeView_price = $('.main-compilations [data-range="price"][role="view"] .range-view .range-view-item');
CompilationsOnMain_rangeInput_price.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(CompilationsOnMain_rangeInput_price[0].value);
        let maxRange = parseInt(CompilationsOnMain_rangeInput_price[1].value);
        let min = parseInt(CompilationsOnMain_rangeInput_price[0].min);
        let max = parseInt(CompilationsOnMain_rangeInput_price[1].max);
        let stopVal = 120/$(CompilationsOnMain_rangeInput_price[0]).parent().parent().width();

        if ( minRange < maxRange) {
            $(CompilationsOnMain_rangeInput_price[0]).attr('stop', minRange);
            $(CompilationsOnMain_rangeInput_price[1]).attr('stop', maxRange);

            let perLeft = (minRange-min)/(max-min), perRight = (max-maxRange)/(max-min);
            $(CompilationsOnMain_rangeView_price[0]).find('span').text( String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );
            $(CompilationsOnMain_rangeView_price[1]).find('span').text(String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );
            $(CompilationsOnMain_range_price).css('left',  'calc('+perLeft*100+'%)');
            $(CompilationsOnMain_range_price).css('right', 'calc('+perRight*100+'%)');
            if ( 1-perRight-perLeft > stopVal) {
                $(CompilationsOnMain_rangeView_price[0]).css({
                    'left': 'calc('+perLeft*100+'% - (47px + '+perLeft*16+'px)',
                    // 'left': 'calc('+perLeft*100+'% - (47px + '+perLeft*16+'px)',
                    'right': 'unset',

                });
                $(CompilationsOnMain_rangeView_price[1]).css({
                    'right': 'calc('+perRight*100+'% - (47px + '+perRight*16+'px)',
                    'left': 'unset'
                });
                $(CompilationsOnMain_rangeView_price[0]).removeClass('text-end').addClass('text-start');
                $(CompilationsOnMain_rangeView_price[1]).removeClass('text-start').addClass('text-end');
            } else {
                $(CompilationsOnMain_rangeView_price[0]).removeClass('text-start').addClass('text-end');
                $(CompilationsOnMain_rangeView_price[1]).removeClass('text-end').addClass('text-start');
            }
        } else {
            let minStop = parseInt($(CompilationsOnMain_rangeInput_price[0]).attr('stop'));
            let maxStop = parseInt($(CompilationsOnMain_rangeInput_price[1]).attr('stop'));
            $(CompilationsOnMain_rangeInput_price[0]).val(minStop);
            $(CompilationsOnMain_rangeInput_price[1]).val(maxStop);
            e.stopPropagation()
            return false;
        }
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(CompilationsOnMain_rangeInput_price[0].value);
        let maxRange = parseInt(CompilationsOnMain_rangeInput_price[1].value);
        if ( minRange+1 < maxRange) {
            let data = {
                query: $('.main-compilations-data').data('query'),
                link: $('.main-compilations-data').data('link'),
                price: minRange+','+maxRange,
                city: YAPP.CONNECTOR.SELECTED_CITY || null,
                entity: YAPP.CONNECTOR.ENTITY || null
            }
            YAPP.COMPILATIONS.render(data);
        } else {
            e.stopPropagation()
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(CompilationsOnMain_rangeInput_price[0].value);
        let maxRange = parseInt(CompilationsOnMain_rangeInput_price[1].value);
        if ( minRange+1 < maxRange) {
            let data = {
                query: $('.main-compilations-data').data('query'),
                link: $('.main-compilations-data').data('link'),
                price: minRange+','+maxRange,
                city: YAPP.CONNECTOR.SELECTED_CITY || null,
                entity: YAPP.CONNECTOR.ENTITY || null
            }
            YAPP.COMPILATIONS.render(data);
        } else {
            e.stopPropagation()
        }
    });
});

YAPP.COMPILATIONS = {};
YAPP.COMPILATIONS.currentAjax = null;

YAPP.COMPILATIONS.render = function (data) {
    if (YAPP.COMPILATIONS.currentAjax) {
        YAPP.COMPILATIONS.currentAjax.abort();
    }

    const $wrapper = $('.main-compilations .swiper-main-compilations .swiper-wrapper');
    const $container = $('.main-compilations .swiper-main-compilations');
    $container.addClass('opacity-50').css('transition', 'opacity 0.2s ease-in-out');

    if ($wrapper.text().includes('не найдено') || !$wrapper.children().length) {
        $wrapper.html(
            '<div class="swiper-slide text-center w-100 py-5 text-muted">' +
            '<span class="h3 d-block mb-2">...</span>' +
            '<span>Загрузка автомобилей...</span>' +
            '</div>'
        );
        if (YAPP.SwiperCompilationsOnMain) {
            YAPP.SwiperCompilationsOnMain.update();
        }
    }
    
    YAPP.COMPILATIONS.currentAjax = $.ajax({
        type: 'POST',
        url: '/api/main-compilations/render/',
        data: data,
        success: (resp) => {
            YAPP.COMPILATIONS.currentAjax = null;
            $container.removeClass('opacity-50');
            $wrapper.html(resp);
            YAPP.SwiperCompilationsOnMain.update();
            $('.main-compilations-content a.block-title-link span').text( $('.main-compilations-data').data('text') );
            $('.main-compilations-content a.block-title-link').attr('href', data.link);

            let range = $('.main-compilations-data').data('range');
            $(CompilationsOnMain_rangeInput_price[0]).attr('min', range.min).attr('max', range.max).val(range.value.min);
            $(CompilationsOnMain_rangeInput_price[1]).attr('min', range.min).attr('max', range.max).val(range.value.max);

            let perLeft = (range.value.min-range.min)/(range.max-range.min), perRight = (range.max-range.value.max)/(range.max-range.min);
            let stopVal = 120/$(CompilationsOnMain_rangeInput_price[0]).parent().parent().width();
            $(CompilationsOnMain_rangeView_price[0]).find('span').text( String(range.value.min).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );
            $(CompilationsOnMain_rangeView_price[1]).find('span').text(String(range.value.max).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );
            $(CompilationsOnMain_range_price).css('left',  'calc('+perLeft*100+'%)');
            $(CompilationsOnMain_range_price).css('right', 'calc('+perRight*100+'%)');
            if ( 1-perRight-perLeft > stopVal) {
                $(CompilationsOnMain_rangeView_price[0]).css({
                    'left': 'calc('+perLeft*100+'% - (47px + '+perLeft*16+'px)',
                    'right': 'unset',

                });
                $(CompilationsOnMain_rangeView_price[1]).css({
                    'right': 'calc('+perRight*100+'% - (47px - '+perRight*16+'px)',
                    'left': 'unset'
                });
                $(CompilationsOnMain_rangeView_price[0]).removeClass('text-end').addClass('text-start');
                $(CompilationsOnMain_rangeView_price[1]).removeClass('text-start').addClass('text-end');
            } else {
                $(CompilationsOnMain_rangeView_price[0]).css({
                    'left': 'calc('+perLeft*100+'% - (67px + '+perLeft*16+'px)',
                    'right': 'unset',

                });
                $(CompilationsOnMain_rangeView_price[1]).css({
                    'right': 'calc('+perRight*100+'% - (67px - '+perRight*16+'px)',
                    'left': 'unset'
                });
                $(CompilationsOnMain_rangeView_price[0]).removeClass('text-end').addClass('text-start');
                $(CompilationsOnMain_rangeView_price[1]).removeClass('text-start').addClass('text-end');
                console.log(perLeft, perRight, stopVal, 1-perRight-perLeft)
            }
        },
        error: (xhr, status, error) => { 
            if (status === 'abort') return;
            YAPP.COMPILATIONS.currentAjax = null;
            $container.removeClass('opacity-50');
        }
    });

    return true;
}

$(document).on('click', '.main-compilations .main-compilations-item', function() {

    if ( $(this).hasClass('active') ) {

        $(this).toggleClass('active');
        let data = {
            query: {},
            link: '/cars/'+((YAPP.CONNECTOR.ENTITY)?YAPP.CONNECTOR.ENTITY:'new')+'/',
            city: YAPP.CONNECTOR.SELECTED_CITY || null,
            entity: YAPP.CONNECTOR.ENTITY || null
        }
        YAPP.COMPILATIONS.render(data);

    } else {

        $('.main-compilations .main-compilations-item').removeClass('active');
        $(this).toggleClass('active');

        let data = {
            query: ( $(this).hasClass('active') ) ? $(this).data('query-'+((YAPP.CONNECTOR.ENTITY)?YAPP.CONNECTOR.ENTITY:'new')) : {},
            link: ( $(this).hasClass('active') ) ? $(this).data('link-'+((YAPP.CONNECTOR.ENTITY)?YAPP.CONNECTOR.ENTITY:'new')) : '/cars/'+((YAPP.CONNECTOR.ENTITY)?YAPP.CONNECTOR.ENTITY:'new')+'/',
            city: YAPP.CONNECTOR.SELECTED_CITY || null,
            entity: YAPP.CONNECTOR.ENTITY || null
        }
        YAPP.COMPILATIONS.render(data);
    }

    

    return false;
});
$(document).on('click', '.main-compilations-filter-entity .main-compilations-filter-entity-item', function() {
    
    YAPP.CONNECTOR.ENTITY = $(this).data('entity');
});
$(document).on('click', '.main-compilations-tabs-item', function() {
    $('.main-compilations-tabs-item').removeClass('active');
    $(this).addClass('active');
    YAPP.CONNECTOR.ENTITY = $(this).data('action');
});

YAPP.COMPILATIONS.ENTITY = YAPP.CONNECTOR.ENTITY;
YAPP.COMPILATIONS.CITY = YAPP.CONNECTOR.SELECTED_CITY.join();
setInterval(() => {
    if (YAPP.COMPILATIONS.ENTITY != YAPP.CONNECTOR.ENTITY) {
        YAPP.COMPILATIONS.ENTITY = YAPP.CONNECTOR.ENTITY;
        $('.main-compilations-tabs-item').removeClass('active');
        $('.main-compilations-tabs-item[data-action="'+YAPP.CONNECTOR.ENTITY+'"]').addClass('active');
        let data = {
            query: $('.main-compilations .main-compilations-item.active').data('query-'+YAPP.CONNECTOR.ENTITY),
            link: $('.main-compilations .main-compilations-item.active').data('link-'+YAPP.CONNECTOR.ENTITY),
            city: YAPP.CONNECTOR.SELECTED_CITY || null,
            entity: YAPP.CONNECTOR.ENTITY || null
        }
        YAPP.COMPILATIONS.render(data);
    }
    if (YAPP.COMPILATIONS.CITY != YAPP.CONNECTOR.SELECTED_CITY.join()) {
        YAPP.COMPILATIONS.CITY = YAPP.CONNECTOR.SELECTED_CITY.join()
        $('.main-compilations-tabs-item').removeClass('active');
        $('.main-compilations-tabs-item[data-action="'+YAPP.CONNECTOR.ENTITY+'"]').addClass('active');
        let data = {
            query: $('.main-compilations .main-compilations-item.active').data('query-'+YAPP.CONNECTOR.ENTITY),
            link: $('.main-compilations .main-compilations-item.active').data('link-'+YAPP.CONNECTOR.ENTITY),
            city: YAPP.CONNECTOR.SELECTED_CITY || null,
            entity: YAPP.CONNECTOR.ENTITY || null
        }
        YAPP.COMPILATIONS.render(data);
    }
}, 100);


YAPP.SwiperCompilationsOnMain = new Swiper('.swiper-main-compilations', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-main-compilations-button-next',
        prevEl: '.swiper-main-compilations-button-prev',
    },
    slidesPerView: 4,
    spaceBetween: 16,

    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 12
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 12
        },
        1280.02: {
            slidesPerView: 3.4,
            spaceBetween: 12
        },
        1366.02: {
            slidesPerView: 4,
            spaceBetween: 12
        },
    }
});

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
