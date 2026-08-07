const getStore = () => window.YAppStore;

const CompilationsOnMain_range_price = $('.main-compilations [data-range="price"] .range-selected');
const CompilationsOnMain_rangeInput_price = $('.main-compilations [data-range="price"][role="range"] .range-input input');
const CompilationsOnMain_rangeView_price = $('.main-compilations [data-range="price"][role="view"] .range-view .range-view-item');

CompilationsOnMain_rangeInput_price.each(function(i, e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(CompilationsOnMain_rangeInput_price[0].value);
        let maxRange = parseInt(CompilationsOnMain_rangeInput_price[1].value);
        let min = parseInt(CompilationsOnMain_rangeInput_price[0].min);
        let max = parseInt(CompilationsOnMain_rangeInput_price[1].max);
        let stopVal = 120 / $(CompilationsOnMain_rangeInput_price[0]).parent().parent().width();

        if (minRange < maxRange) {
            $(CompilationsOnMain_rangeInput_price[0]).attr('stop', minRange);
            $(CompilationsOnMain_rangeInput_price[1]).attr('stop', maxRange);

            let perLeft = (minRange - min) / (max - min), perRight = (max - maxRange) / (max - min);
            $(CompilationsOnMain_rangeView_price[0]).find('span').text(String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " "));
            $(CompilationsOnMain_rangeView_price[1]).find('span').text(String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " "));
            $(CompilationsOnMain_range_price).css('left', 'calc(' + perLeft * 100 + '%)');
            $(CompilationsOnMain_range_price).css('right', 'calc(' + perRight * 100 + '%)');
            if (1 - perRight - perLeft > stopVal) {
                $(CompilationsOnMain_rangeView_price[0]).css({
                    'left': 'calc(' + perLeft * 100 + '% - (47px + ' + perLeft * 16 + 'px)',
                    'right': 'unset',
                });
                $(CompilationsOnMain_rangeView_price[1]).css({
                    'right': 'calc(' + perRight * 100 + '% - (47px + ' + perRight * 16 + 'px)',
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
            e.stopPropagation();
            return false;
        }
    });

    const triggerRender = (e) => {
        let minRange = parseInt(CompilationsOnMain_rangeInput_price[0].value);
        let maxRange = parseInt(CompilationsOnMain_rangeInput_price[1].value);
        const store = getStore();
        if (minRange + 1 < maxRange) {
            let data = {
                query: $('.main-compilations-data').data('query'),
                link: $('.main-compilations-data').data('link'),
                price: minRange + ',' + maxRange,
                city: store ? store.city : null,
                entity: store ? store.entity : null
            };
            renderCompilations(data);
        } else {
            e.stopPropagation();
        }
    };

    e.addEventListener('mouseup', triggerRender);
    e.addEventListener('touchend', triggerRender);
});

let compilationsAbortController = null;

function renderCompilations(data) {
    if (compilationsAbortController) {
        compilationsAbortController.abort();
    }
    compilationsAbortController = new AbortController();

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
        if (window.YAPP && window.YAPP.SwiperCompilationsOnMain) {
            window.YAPP.SwiperCompilationsOnMain.update();
        }
    }

    const payload = new URLSearchParams();
    for (const key in data) {
        if (data[key] !== null && data[key] !== undefined) {
            payload.append(key, typeof data[key] === 'object' ? JSON.stringify(data[key]) : data[key]);
        }
    }

    fetch('/api/main-compilations/render/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: payload.toString(),
        signal: compilationsAbortController.signal
    })
    .then(res => res.text())
    .then(resp => {
        compilationsAbortController = null;
        $container.removeClass('opacity-50');
        $wrapper.html(resp);
        if (window.YAPP && window.YAPP.SwiperCompilationsOnMain) {
            window.YAPP.SwiperCompilationsOnMain.update();
        }

        const compilationsData = $('.main-compilations-data');
        if (compilationsData.length) {
            $('.main-compilations-content a.block-title-link span').text(compilationsData.data('text'));
            $('.main-compilations-content a.block-title-link').attr('href', data.link);

            let range = compilationsData.data('range');
            if (range && range.min !== undefined) {
                $(CompilationsOnMain_rangeInput_price[0]).attr('min', range.min).attr('max', range.max).val(range.value.min);
                $(CompilationsOnMain_rangeInput_price[1]).attr('min', range.min).attr('max', range.max).val(range.value.max);

                let perLeft = (range.value.min - range.min) / (range.max - range.min), perRight = (range.max - range.value.max) / (range.max - range.min);
                let stopVal = 120 / $(CompilationsOnMain_rangeInput_price[0]).parent().parent().width();
                $(CompilationsOnMain_rangeView_price[0]).find('span').text(String(range.value.min).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                $(CompilationsOnMain_rangeView_price[1]).find('span').text(String(range.value.max).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " "));
                $(CompilationsOnMain_range_price).css('left', 'calc(' + perLeft * 100 + '%)');
                $(CompilationsOnMain_range_price).css('right', 'calc(' + perRight * 100 + '%)');
                if (1 - perRight - perLeft > stopVal) {
                    $(CompilationsOnMain_rangeView_price[0]).css({
                        'left': 'calc(' + perLeft * 100 + '% - (47px + ' + perLeft * 16 + 'px)',
                        'right': 'unset',
                    });
                    $(CompilationsOnMain_rangeView_price[1]).css({
                        'right': 'calc(' + perRight * 100 + '% - (47px - ' + perRight * 16 + 'px)',
                        'left': 'unset'
                    });
                    $(CompilationsOnMain_rangeView_price[0]).removeClass('text-end').addClass('text-start');
                    $(CompilationsOnMain_rangeView_price[1]).removeClass('text-start').addClass('text-end');
                } else {
                    $(CompilationsOnMain_rangeView_price[0]).css({
                        'left': 'calc(' + perLeft * 100 + '% - (67px + ' + perLeft * 16 + 'px)',
                        'right': 'unset',
                    });
                    $(CompilationsOnMain_rangeView_price[1]).css({
                        'right': 'calc(' + perRight * 100 + '% - (67px - ' + perRight * 16 + 'px)',
                        'left': 'unset'
                    });
                    $(CompilationsOnMain_rangeView_price[0]).removeClass('text-end').addClass('text-start');
                    $(CompilationsOnMain_rangeView_price[1]).removeClass('text-start').addClass('text-end');
                }
            }
        }
    })
    .catch(err => {
        if (err.name === 'AbortError') return;
        compilationsAbortController = null;
        $container.removeClass('opacity-50');
    });
}

$(document).on('click', '.main-compilations .main-compilations-item', function() {
    const isAlreadyActive = $(this).hasClass('active');
    const store = getStore();
    const currentEntity = store ? store.entity : 'new';

    if (isAlreadyActive) {
        $(this).removeClass('active');
        renderCompilations({
            query: {},
            link: '/cars/' + currentEntity + '/',
            city: store ? store.city : null,
            entity: currentEntity
        });
    } else {
        $('.main-compilations .main-compilations-item').removeClass('active');
        $(this).addClass('active');

        renderCompilations({
            query: $(this).data('query-' + currentEntity),
            link: $(this).data('link-' + currentEntity) || ('/cars/' + currentEntity + '/'),
            city: store ? store.city : null,
            entity: currentEntity
        });
    }
    return false;
});

$(document).on('click', '.main-compilations-tabs-item', function() {
    $('.main-compilations-tabs-item').removeClass('active');
    $(this).addClass('active');
    const action = $(this).data('action');
    const store = getStore();
    if (store) store.setEntity(action);
});

function initCompilationsStoreListeners() {
    const store = getStore();
    if (!store) return;

    const updateCompilationsFromStore = () => {
        const currentEntity = store.entity || 'new';
        $('.main-compilations-tabs-item').removeClass('active');
        $('.main-compilations-tabs-item[data-action="' + currentEntity + '"]').addClass('active');

        const activeItem = $('.main-compilations .main-compilations-item.active');
        const data = {
            query: activeItem.length ? activeItem.data('query-' + currentEntity) : {},
            link: activeItem.length ? activeItem.data('link-' + currentEntity) : ('/cars/' + currentEntity + '/'),
            city: store.city || null,
            entity: currentEntity
        };
        renderCompilations(data);
    };

    store.addEventListener('entity:changed', updateCompilationsFromStore);
    store.addEventListener('city:changed', updateCompilationsFromStore);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCompilationsStoreListeners);
} else {
    initCompilationsStoreListeners();
}

if (typeof window !== 'undefined') {
    if (!window.YAPP) window.YAPP = {};
    window.YAPP.SwiperCompilationsOnMain = new Swiper('.swiper-main-compilations', {
        pagination: { el: ".swiper-pagination", type: "fraction" },
        navigation: { nextEl: '.swiper-main-compilations-button-next', prevEl: '.swiper-main-compilations-button-prev' },
        slidesPerView: 4,
        spaceBetween: 16,
        breakpoints: {
            320: { slidesPerView: 1, spaceBetween: 10 },
            768: { slidesPerView: 2, spaceBetween: 12 },
            1024: { slidesPerView: 3, spaceBetween: 12 },
            1280.02: { slidesPerView: 3.4, spaceBetween: 12 },
            1366.02: { slidesPerView: 4, spaceBetween: 12 },
        }
    });
}

// Карточка авто - просмотр галереи при наведении
$(document).on('mousemove', '.vehicle-card-images', function(e) {
    let el = e.currentTarget.getBoundingClientRect();
    let indx = 0;
    let w = el.width / 4;

    if (e.clientX >= el.left && e.clientX < el.left + w) {
        indx = 0;
    } else if (e.clientX >= el.left + w && e.clientX < el.left + w + w) {
        indx = 1;
    } else if (e.clientX >= el.left + w + w && e.clientX < el.left + w + w + w) {
        indx = 2;
    } else if (e.clientX >= el.left + w + w + w && e.clientX <= el.right) {
        indx = 3;
    }

    $(this).find('.vehicle-card-images-item-container').hide();
    $(this).find('.vehicle-card-images-item-container[data-index="' + indx + '"]').show();
    $(this).find('.vehicle-card-images-row-item').removeClass('active');
    $(this).find('.vehicle-card-images-row-item[data-index="' + indx + '"]').addClass('active');
});

document.querySelectorAll('.vehicle-card-images').forEach((item) => {
    item.addEventListener('touchmove', (e) => {
        e.preventDefault();
        let el = e.currentTarget.getBoundingClientRect();
        let indx = 0;
        let w = el.width / 4;

        if (e.touches[0].clientX >= el.left && e.touches[0].clientX < el.left + w) {
            indx = 0;
        } else if (e.touches[0].clientX >= el.left + w && e.touches[0].clientX < el.left + w + w) {
            indx = 1;
        } else if (e.touches[0].clientX >= el.left + w + w && e.touches[0].clientX < el.left + w + w + w) {
            indx = 2;
        } else if (e.touches[0].clientX >= el.left + w + w + w && e.touches[0].clientX <= el.right) {
            indx = 3;
        }

        $(item).find('.vehicle-card-images-item-container').hide();
        $(item).find('.vehicle-card-images-item-container[data-index="' + indx + '"]').show();
        $(item).find('.vehicle-card-images-row-item').removeClass('active');
        $(item).find('.vehicle-card-images-row-item[data-index="' + indx + '"]').addClass('active');
    });
});
