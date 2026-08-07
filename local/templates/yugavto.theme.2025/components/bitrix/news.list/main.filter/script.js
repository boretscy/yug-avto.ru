if (!window.YAPP) window.YAPP = {};
if (!window.YAPP.MAIN_FILTER) window.YAPP.MAIN_FILTER = {};
if (!window.YAPP.CONNECTOR) window.YAPP.CONNECTOR = {};

window.YAPP.CONNECTOR.COUNTS = {};

window.YAPP.MAIN_FILTER.getCISCounts = function() {
    const store = window.YAppStore;
    const cityStr = store ? store.city.join() : '';
    let post = { data: { city: cityStr }, update: { data: true } };

    post.data.entity = 'new';
    fetch('/api/main-filter/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ query: JSON.stringify(post) })
    })
    .then(res => res.json())
    .then(data => {
        window.YAPP.CONNECTOR.COUNTS.new = data.totalCount;
        let count = new Intl.NumberFormat('ru', { currency: 'RUR' });
        $('[role="cis-value"][data-action="new"]').text(count.format(Number(data.totalCount)));
    })
    .catch(() => {});

    post.data.entity = 'used';
    fetch('/api/main-filter/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ query: JSON.stringify(post) })
    })
    .then(res => res.json())
    .then(data => {
        window.YAPP.CONNECTOR.COUNTS.used = data.totalCount;
        let count = new Intl.NumberFormat('ru', { currency: 'RUR' });
        $('[role="cis-value"][data-action="used"]').text(count.format(Number(data.totalCount)));
    })
    .catch(() => {});
};

window.YAPP.MAIN_FILTER.renderDropdowns = function() {
    const brandsCount = window.YAPP.MAIN_FILTER.brands?.length || 0;
    const modelsCount = window.YAPP.MAIN_FILTER.models?.length || 0;

    if (brandsCount > 0) {
        $('.form-dropdown[data-list="brands"] span span').text(' - ' + brandsCount + ' выбрано');
    } else {
        $('.form-dropdown[data-list="brands"] span span').text('(все)');
    }
    if (modelsCount > 0) {
        $('.form-dropdown[data-list="models"] span span').text(' - ' + modelsCount + ' выбрано');
    } else {
        $('.form-dropdown[data-list="models"] span span').text('(все)');
    }
};

window.YAPP.MAIN_FILTER.getData = function(post) {
    $('.main-filter [role="link"]').html('<a href="/cars/new/" class="d-block b-radius-yaradius15 bg-yayellow bg-h-yadarkyellow py-3 text-center c-yablack c-h-yablack text-decoration-none text-normal">...</a>');

    fetch('/api/main-filter/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ query: JSON.stringify(post) })
    })
    .then(res => res.json())
    .then(resp => {
        if (post.update.data) window.YAPP.MAIN_FILTER.DATA = resp;
        if (post.update.brands) {
            window.YAPP.MAIN_FILTER.DATA.dropLists.brands = resp.dropLists.brands;
            window.YAPP.MAIN_FILTER.renderSelect('brands');
            window.YAPP.MAIN_FILTER.renderSelect('models');
            window.YAPP.MAIN_FILTER.renderBrands();
        }
        if (post.update.models) {
            window.YAPP.MAIN_FILTER.DATA.dropLists.models = resp.dropLists.models;
            window.YAPP.MAIN_FILTER.renderSelect('models');
        }
        if (post.update.price) {
            window.YAPP.MAIN_FILTER.renderPrice(resp.ranges.price);
        }

        window.YAPP.MAIN_FILTER.renderDropdowns();
        window.YAPP.MAIN_FILTER.renderLink(resp.totalCount);
    })
    .catch(() => {});
};

window.YAPP.MAIN_FILTER.renderSelect = function(e) {
    fetch('/api/main-filter-select/render/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ items: JSON.stringify(window.YAPP.MAIN_FILTER.DATA.dropLists[e]), list: e })
    })
    .then(res => res.text())
    .then(resp => {
        $('.main-filter .form-droplist[data-list="' + e + '"]').html(resp);
    })
    .catch(() => {});
};

window.YAPP.MAIN_FILTER.renderLink = function() {
    let data = {};
    const store = window.YAppStore;
    if (window.YAPP.FORMS && window.YAPP.FORMS.MAIN_FILTER) {
        data.brands = window.YAPP.FORMS.MAIN_FILTER.brands.VALUE;
        data.models = window.YAPP.FORMS.MAIN_FILTER.models.VALUE;
        data.price = window.YAPP.FORMS.MAIN_FILTER.price;
    }
    data.count = window.YAPP.MAIN_FILTER.DATA?.totalCount || 0;
    data.city = store ? store.city.join() : '';
    data.entity = store ? store.entity : 'new';

    fetch('/api/main-filter-button/render/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(data)
    })
    .then(res => res.text())
    .then(resp => {
        $('.main-filter-tabs-content [role="link"]').html(resp);
    })
    .catch(() => {});
};

window.YAPP.MAIN_FILTER.renderBrands = function() {
    const store = window.YAppStore;
    fetch('/api/main-filter-brands/render/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            brands: JSON.stringify(window.YAPP.MAIN_FILTER.DATA.dropLists.brands),
            entity: store ? store.entity : 'new',
            city: store ? store.city.join() : '',
            in_city: window.YAPP.MAIN_FILTER.DATA.in_city
        })
    })
    .then(res => res.text())
    .then(resp => {
        $('.brands-on-main').html(resp);
        if ($.fn.remodal) {
            var inst = $('[data-remodal-id="brands"]').remodal();
            if (inst) inst.destroy();
            $('[data-remodal-id="brands"]').remodal();
        }
    })
    .catch(() => {});
};

window.YAPP.MAIN_FILTER.renderPrice = function(range) {
    const CisOnMain_range_price = $('.main-filter [data-range="price"] .range-selected');
    const CisOnMain_rangeInput_price = $('.main-filter [data-range="price"][role="range"] .range-input input');
    const CisOnMain_rangeView_price = $('.main-filter [data-range="price"][role="view"] .range-view input');

    $(CisOnMain_rangeInput_price[0]).attr('min', range.min).attr('max', range.max).val(range.value[0]);
    $(CisOnMain_rangeInput_price[1]).attr('min', range.min).attr('max', range.max).val(range.value[1]);

    let perLeft = (range.value[0] - range.min) / (range.max - range.min), perRight = (range.max - range.value[1]) / (range.max - range.min);
    $(CisOnMain_range_price).css({ 'left': perLeft * 100 + '%', 'right': perRight * 100 + '%' });
    $(CisOnMain_rangeView_price[0]).val(String(range.value[0]).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " "));
    $(CisOnMain_rangeView_price[1]).val(String(range.value[1]).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " "));

    $(CisOnMain_range_price).data('min', range.value[0]).data('max', range.value[1]);

    if (window.YAPP.FORMS && window.YAPP.FORMS.MAIN_FILTER) {
        window.YAPP.FORMS.MAIN_FILTER.price = [range.value[0], range.value[1]];
    }
};

$(document).on('click', '.main-filter-tabs-item', function() {
    $('.main-filter-tabs-item').removeClass('active');
    $(this).addClass('active');
    $('.main-filter-tabs-content-wrap').addClass('d-none');
    $('.main-filter-tabs-content-wrap[data-action="' + $(this).data('action') + '"]').removeClass('d-none');
});

$(document).on('click', '.main-filter-tabs-item[role="toggleEntity"]', function() {
    const entity = $(this).data('entity');
    const store = window.YAppStore;
    if (store) store.setEntity(entity);
});

$(document).on('click', '[role="toggleBrands"]', function() {
    $('.brands-on-main-items [role="hidden"]').toggleClass('d-none');
    $('[role="toggleBrands"]').parent().toggleClass('d-none');
    return false;
});

$(document).on('click', '[data-sid="MAIN_FILTER"] .form-dropcontainer .form-droplist-item', function() {
    const store = window.YAppStore;
    if ($(this).attr('role') === 'toggleEntity') {
        const entity = $(this).data('entity');
        if (store) store.setEntity(entity);
        if (window.YAPP.FORMS && window.YAPP.FORMS.dropDownSelect) {
            window.YAPP.FORMS.dropDownSelect($(this));
        }
        return false;
    }

    let post = {
        update: {
            price: true,
            models: typeof $(this).parent().parent().data('children') !== 'undefined' && $(this).parent().parent().data('children') === 'models',
            brands: false,
            data: true
        },
        data: {
            entity: store ? store.entity : 'new',
            price: [],
            brands: window.YAPP.FORMS?.MAIN_FILTER?.brands?.VALUE || [],
            models: window.YAPP.FORMS?.MAIN_FILTER?.models?.VALUE || [],
            city: store ? store.city.join() : ''
        }
    };

    window.YAPP.MAIN_FILTER.getData(post);
    window.YAPP.MAIN_FILTER.renderLink();
    return false;
});

const range_price = $('[data-range="price"] .range-selected');
const rangeInput_price = $('[data-range="price"][role="range"] .range-input input');
const rangeView_price = $('[data-range="price"][role="view"] .range-view input');

rangeInput_price.each(function(i, e) {
    e.addEventListener('input', () => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        let min = parseInt(rangeInput_price[0].min);
        let max = parseInt(rangeInput_price[1].max);
        rangeView_price[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_price[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_price).css('left', (minRange - min) / (max - min) * 100 + '%');
        $(range_price).css('right', (max - maxRange) / (max - min) * 100 + '%');
    });

    const triggerPriceChange = () => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        const store = window.YAppStore;
        if (minRange !== parseInt($(range_price).data('min')) || maxRange !== parseInt($(range_price).data('max'))) {
            if (window.YAPP.FORMS && window.YAPP.FORMS.MAIN_FILTER) {
                window.YAPP.FORMS.MAIN_FILTER.price = [minRange, maxRange];
            }
            let post = {
                update: { price: true, models: false, brands: false, data: true },
                data: {
                    entity: store ? store.entity : 'new',
                    price: [minRange, maxRange],
                    brands: window.YAPP.FORMS?.MAIN_FILTER?.brands?.VALUE || [],
                    models: window.YAPP.FORMS?.MAIN_FILTER?.models?.VALUE || [],
                    city: store ? store.city.join() : ''
                }
            };
            window.YAPP.MAIN_FILTER.getData(post);
            window.YAPP.MAIN_FILTER.renderLink();
        }
    };

    e.addEventListener('mouseup', triggerPriceChange);
    e.addEventListener('touchend', triggerPriceChange);
});

rangeView_price.each(function(i, e) {
    e.addEventListener('input', () => {
        rangeView_price[0].value = String(rangeView_price[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_price[1].value = String(rangeView_price[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt(String(rangeView_price[0].value).replace(/\D/g, ""));
        let maxView = parseInt(String(rangeView_price[1].value).replace(/\D/g, ""));
        let min = parseInt(rangeInput_price[0].min);
        let max = parseInt(rangeInput_price[1].max);
        if (minView >= min && maxView <= max) {
            rangeInput_price[0].value = minView;
            rangeInput_price[1].value = maxView;
            $(range_price).css('left', (minView - min) / (max - min) * 100 + '%');
            $(range_price).css('right', (max - maxView) / (max - min) * 100 + '%');
        }
    });

    e.addEventListener('blur', () => {
        let minView = parseInt(String(rangeView_price[0].value).replace(/\D/g, ""));
        let maxView = parseInt(String(rangeView_price[1].value).replace(/\D/g, ""));
        const store = window.YAppStore;
        if (minView !== parseInt($(range_price).data('min')) || maxView !== parseInt($(range_price).data('max'))) {
            if (window.YAPP.FORMS && window.YAPP.FORMS.MAIN_FILTER) {
                window.YAPP.FORMS.MAIN_FILTER.price = [minView, maxView];
            }
            let post = {
                update: { price: true, models: false, brands: false, data: true },
                data: {
                    entity: store ? store.entity : 'new',
                    price: [minView, maxView],
                    brands: window.YAPP.FORMS?.MAIN_FILTER?.brands?.VALUE || [],
                    models: window.YAPP.FORMS?.MAIN_FILTER?.models?.VALUE || [],
                    city: store ? store.city.join() : ''
                }
            };
            window.YAPP.MAIN_FILTER.getData(post);
            window.YAPP.MAIN_FILTER.renderLink();
        }
    });
});

if (typeof window !== 'undefined') {
    window.YAPP.SwiperMainStories = new Swiper('.swiper-main-stories', {
        pagination: { el: ".swiper-pagination", type: "fraction" },
        navigation: { nextEl: '.swiper-main-stories-button-next', prevEl: '.swiper-main-stories-button-prev' },
        slidesPerView: 1,
        spaceBetween: 24,
        autoplay: { delay: 5000 },
        loop: true
    });

    window.YAPP.SwiperMainStoriesM = new Swiper('.swiper-main-stories-mobile', {
        pagination: { el: ".swiper-pagination", type: "fraction" },
        navigation: { nextEl: '.swiper-main-stories-button-next-mobile', prevEl: '.swiper-main-stories-button-prev-mobile' },
        slidesPerView: 1,
        spaceBetween: 24,
        autoplay: { delay: 5000 }
    });

    window.YAPP.SwiperMainStoriesM.VIEWED = JSON.parse(localStorage.getItem('STORIES') || '[]');
    $('.stories-item').each(function(i, e) {
        if (window.YAPP.SwiperMainStoriesM.VIEWED.indexOf($(e).data('hash')) >= 0) $(e).addClass('viewed');
    });

    $(document).on('click', '.stories-item', function() {
        if (window.YAPP.SwiperMainStoriesM.VIEWED.indexOf($(this).data('hash')) < 0) {
            $(this).addClass('viewed');
            window.YAPP.SwiperMainStoriesM.VIEWED.push($(this).data('hash'));
            localStorage.setItem('STORIES', JSON.stringify(window.YAPP.SwiperMainStoriesM.VIEWED));
        }
        window.YAPP.SwiperMainStoriesM.slideTo($(this).data('indx'));
    });

    window.YAPP.SwiperMainStoriesM.on('slideChange', function() {
        const activeHash = $('.stories-item[data-indx="' + window.YAPP.SwiperMainStoriesM.activeIndex + '"]').data('hash');
        if (activeHash && window.YAPP.SwiperMainStoriesM.VIEWED.indexOf(activeHash) < 0) {
            $('.stories-item[data-indx="' + window.YAPP.SwiperMainStoriesM.activeIndex + '"]').addClass('viewed');
            window.YAPP.SwiperMainStoriesM.VIEWED.push(activeHash);
            localStorage.setItem('STORIES', JSON.stringify(window.YAPP.SwiperMainStoriesM.VIEWED));
        }
    });

    $('.remodal[role="stories"]').each(function(i, e) {
        $(this).find('[role="reaction"]').each(function(ir, er) {
            if (localStorage.getItem($(er).data('hash'))) {
                $(er).addClass('my-reaction');
            }
        });
    });

    $(document).on('click', '[role="reaction"]', function() {
        let reaction = Number($(this).data('reaction'));
        if (localStorage.getItem($(this).data('hash'))) {
            reaction--;
            $(this).data('reaction', reaction);
            $(this).removeClass('my-reaction');
            localStorage.removeItem($(this).data('hash'));
        } else {
            reaction++;
            $(this).data('reaction', reaction);
            $(this).addClass('my-reaction');
            localStorage.setItem($(this).data('hash'), 'Y');
        }

        fetch('/api/stories-reaction/', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                id: $(this).data('id'),
                action: $(this).data('action'),
                value: reaction
            })
        })
        .then(res => res.json())
        .then(resp => {
            $(this).find('span[role="value"]').text(resp.result);
        })
        .catch(() => {});
    });
}

function initMainFilterStoreListeners() {
    const store = window.YAppStore;
    if (!store) return;

    store.addEventListener('entity:changed', (e) => {
        let post = {
            update: { price: true, models: true, brands: true, data: true },
            data: {
                entity: e.detail.entity,
                price: [],
                brands: [],
                models: [],
                city: store.city.join()
            }
        };
        window.YAPP.MAIN_FILTER.getData(post);

        $('.main-filter-tabs-item').removeClass('active');
        $('.main-filter-tabs-item[data-action="cis"][data-entity="' + e.detail.entity + '"]').addClass('active');
        $('.main-filter-tabs-content-wrap').addClass('d-none');
        $('.main-filter-tabs-content-wrap[data-action="cis"]').removeClass('d-none');
    });

    store.addEventListener('city:changed', (e) => {
        window.YAPP.MAIN_FILTER.getCISCounts();
        window.YAPP.MAIN_FILTER.brands = [];
        window.YAPP.MAIN_FILTER.models = [];
        window.YAPP.MAIN_FILTER.price = [];

        let post = {
            update: { price: true, models: true, brands: true, data: true },
            data: {
                entity: store.entity,
                price: [],
                brands: window.YAPP.FORMS?.MAIN_FILTER?.brands?.VALUE || [],
                models: window.YAPP.FORMS?.MAIN_FILTER?.models?.VALUE || [],
                city: e.detail.city.join()
            }
        };
        window.YAPP.MAIN_FILTER.getData(post);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMainFilterStoreListeners);
} else {
    initMainFilterStoreListeners();
}
