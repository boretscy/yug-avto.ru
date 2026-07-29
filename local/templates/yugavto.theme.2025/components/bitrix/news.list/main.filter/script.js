YAPP.CONNECTOR.COUNTS = {};
YAPP.MAIN_FILTER.getCISCounts = function() {
    let post = {data: {city: YAPP.CONNECTOR.SELECTED_CITY.join()}, update: {data: true}};

    post.data.entity = 'new';
    $.ajax({
        type: 'POST',
        url: '/api/main-filter/',
        data: {query: JSON.stringify(post)},
        success: (resp) => {
            let data = JSON.parse(resp);
            YAPP.CONNECTOR.COUNTS.new = data.totalCount;
            let count = new Intl.NumberFormat('ru', { currency: 'RUR' });
            $('[role="cis-value"][data-action="new"]').text(count.format(Number(YAPP.CONNECTOR.COUNTS.new)));
        }
    });

    post.data.entity = 'used';
    $.ajax({
        type: 'POST',
        url: '/api/main-filter/',
        data: {query: JSON.stringify(post)},
        success: (resp) => {
            let data = JSON.parse(resp);
            YAPP.CONNECTOR.COUNTS.used = data.totalCount;
            let count = new Intl.NumberFormat('ru', { currency: 'RUR' });
            $('[role="cis-value"][data-action="used"]').text(count.format(Number(YAPP.CONNECTOR.COUNTS.used)));
        }
    });
}




YAPP.MAIN_FILTER.renderDropdowns = function() {

    if ( YAPP.MAIN_FILTER.brands.length > 0 ) {
        $('.form-dropdown[data-list="brands"] span span').text(' - '+YAPP.MAIN_FILTER.brands.length+' выбрано');
    } else {
        $('.form-dropdown[data-list="brands"] span span').text('(все)');
    }
    if ( YAPP.MAIN_FILTER.models.length > 0 ) {
        $('.form-dropdown[data-list="models"] span span').text(' - '+YAPP.MAIN_FILTER.models.length+' выбрано');
    } else {
        $('.form-dropdown[data-list="models"] span span').text('(все)');
    }
}
YAPP.MAIN_FILTER.getData = function(post) {

    $('.main-filter [role="link"]').html('<a href="/cars/new/" class="d-block b-radius-yaradius15 bg-yayellow bg-h-yadarkyellow py-3 text-center c-yablack c-h-yablack text-decoration-none text-normal">...</a>');

    let url = '/api/main-filter/';
    $.ajax({
        type: 'POST',
        url: url,
        data: {query: JSON.stringify(post)},
        success: (resp) => {
            if ( post.update.data ) YAPP.MAIN_FILTER.DATA = JSON.parse(resp);
            if ( post.update.brands ) {
                YAPP.MAIN_FILTER.DATA.dropLists.brands = JSON.parse(resp).dropLists.brands;
                YAPP.MAIN_FILTER.renderSelect('brands');
                YAPP.MAIN_FILTER.renderSelect('models');
                YAPP.MAIN_FILTER.renderBrands();
            }
            if ( post.update.models ) {
                YAPP.MAIN_FILTER.DATA.dropLists.models = JSON.parse(resp).dropLists.models;
                YAPP.MAIN_FILTER.renderSelect('models');
            }
            if ( post.update.price ) {
                YAPP.MAIN_FILTER.renderPrice( JSON.parse(resp).ranges.price )
            }

            YAPP.MAIN_FILTER.renderDropdowns();
            YAPP.MAIN_FILTER.renderLink(JSON.parse(resp).totalCount);
            
        },
        error: () => { 
        }
    });
}
YAPP.MAIN_FILTER.renderSelect = function(e) {

    let url = '/api/main-filter-select/render/';
    $.ajax({
        type: 'POST',
        url: url,
        data: {items: YAPP.MAIN_FILTER.DATA.dropLists[e], list: e},
        success: (resp) => {
            $('.main-filter .form-droplist[data-list="'+e+'"]').html(resp);
        },
        error: () => { 
        }
    });
}
YAPP.MAIN_FILTER.renderLink = function() {

    let url = '/api/main-filter-button/render/';
    let data = {};
    data.brands = YAPP.FORMS.MAIN_FILTER.brands.VALUE;
    data.models = YAPP.FORMS.MAIN_FILTER.models.VALUE;
    if ( YAPP.MAIN_FILTER.price.length > 0 ) data.price = YAPP.MAIN_FILTER.price
    data.count = YAPP.MAIN_FILTER.DATA.totalCount;
    data.city = YAPP.CONNECTOR.SELECTED_CITY.join();
    data.entity = YAPP.CONNECTOR.ENTITY;
    data.price = YAPP.FORMS.MAIN_FILTER.price;

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: (resp) => {
            $('.main-filter-tabs-content [role="link"]').html(resp);
        },
        error: () => { 
        }
    });
}
YAPP.MAIN_FILTER.renderBrands = function() {

    let url = '/api/main-filter-brands/render/';

    $.ajax({
        type: 'POST',
        url: url,
        data: {brands: YAPP.MAIN_FILTER.DATA.dropLists.brands, entity: YAPP.CONNECTOR.ENTITY, city: YAPP.CONNECTOR.SELECTED_CITY.join(), in_city: YAPP.MAIN_FILTER.DATA.in_city},
        success: (resp) => {
            $('.brands-on-main').html(resp);
            var inst = $('[data-remodal-id="brands"]').remodal();
            inst.destroy();
            $('[data-remodal-id="brands"]').remodal();
        },
        error: () => { 
        }
    });
}
YAPP.MAIN_FILTER.renderPrice = function(range) {

    const CisOnMain_range_price = $('.main-filter [data-range="price"] .range-selected');
    const CisOnMain_rangeInput_price = $('.main-filter [data-range="price"][role="range"] .range-input input');
    const CisOnMain_rangeView_price = $('.main-filter [data-range="price"][role="view"] .range-view input');

    $(CisOnMain_rangeInput_price[0]).attr('min', range.min).attr('max', range.max).val(range.value[0]);
    $(CisOnMain_rangeInput_price[1]).attr('min', range.min).attr('max', range.max).val(range.value[1]);

    let perLeft = (range.value[0]-range.min)/(range.max-range.min), perRight = (range.max-range.value[1])/(range.max-range.min);
    $(CisOnMain_range_price).css({'left': perLeft*100+'%', 'right': perRight*100+'%'});
    $(CisOnMain_rangeView_price[0]).val( String(range.value[0]).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );
    $(CisOnMain_rangeView_price[1]).val( String(range.value[1]).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );

    $(CisOnMain_range_price).data('min', range.value[0]).data('max', range.value[1]);
    
    // Обновляем глобальные выбранные цены при авто-смене диапазона
    YAPP.FORMS.MAIN_FILTER.price = [range.value[0], range.value[1]];
}
$(document).on('click', '.main-filter-tabs-item', function() {
    $('.main-filter-tabs-item').removeClass('active');
    $(this).addClass('active');
    $('.main-filter-tabs-content-wrap').addClass('d-none');
    $('.main-filter-tabs-content-wrap[data-action="'+$(this).data('action')+'"]').removeClass('d-none');
});
$(document).on('click', '.main-filter-tabs-item[role="toggleEntity"]', function() {
    YAPP.CONNECTOR.ENTITY = $(this).data('entity');

    let post = {};
    post.update = {};
    post.data = {};

    post.update.price = true;
    post.update.models = true;
    post.update.brands = true;
    post.update.data = true;

    post.data.entity = $(this).data('entity');
    post.data.price = [];
    post.data.brans = [];
    post.data.models = [];
    post.data.city = YAPP.CONNECTOR.SELECTED_CITY.join();

    YAPP.MAIN_FILTER.getData(post);

    // var inst = $('[data-remodal-id=brands]').remodal();
    // 
})
$(document).on('click', '[role="toggleBrands"]', function() {
    $('.brands-on-main-items [role="hidden"]').toggleClass('d-none');
    $('[role="toggleBrands"]').parent().toggleClass('d-none');
    return false;
});
$(document).on('click', '[data-sid="MAIN_FILTER"] .form-dropcontainer .form-droplist-item', function() {

    if ($(this).attr('role') === 'toggleEntity') {
        YAPP.CONNECTOR.ENTITY = $(this).data('entity');
        YAPP.FORMS.dropDownSelect($(this));
        return false;
    }

    let post = {};
    post.update = {};
    post.data = {};

    post.update.price = true;
    post.update.models = ( typeof $(this).parent().parent().data('children') != 'undefined' && $(this).parent().parent().data('children') == 'models' );
    post.update.brands = false;
    post.update.data = true;

    post.data.entity = YAPP.CONNECTOR.ENTITY;
    post.data.price = [];
    post.data.brands = YAPP.FORMS.MAIN_FILTER.brands.VALUE;
    post.data.models = YAPP.FORMS.MAIN_FILTER.models.VALUE;
    post.data.city = YAPP.CONNECTOR.SELECTED_CITY.join();

    YAPP.MAIN_FILTER.getData(post);
    YAPP.MAIN_FILTER.renderLink();

    return false;
});

const range_price = $('[data-range="price"] .range-selected');
const rangeInput_price = $('[data-range="price"][role="range"] .range-input input');
const rangeView_price = $('[data-range="price"][role="view"] .range-view input');
rangeInput_price.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        let min = parseInt(rangeInput_price[0].min);
        let max = parseInt(rangeInput_price[1].max);
        rangeView_price[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_price[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_price).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_price).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        if ( minRange != parseInt($(range_price).data('min')) || maxRange != parseInt($(range_price).data('max')) ) {
            YAPP.FORMS.MAIN_FILTER.price = [minRange, maxRange];
            let post = {};
            post.update = {};
            post.data = {};

            post.update.price = true;
            post.update.models = false;
            post.update.brands = false;
            post.update.data = true;

            post.data.entity = YAPP.CONNECTOR.ENTITY;
            post.data.price = YAPP.FORMS.MAIN_FILTER.price;
            post.data.brands = YAPP.FORMS.MAIN_FILTER.brands.VALUE;
            post.data.models = YAPP.FORMS.MAIN_FILTER.models.VALUE;
            post.data.city = YAPP.CONNECTOR.SELECTED_CITY.join();

            YAPP.MAIN_FILTER.getData(post);
            YAPP.MAIN_FILTER.renderLink();
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        if ( minRange != parseInt($(range_price).data('min')) || maxRange != parseInt($(range_price).data('max')) ) {
            YAPP.FORMS.MAIN_FILTER.price = [minRange, maxRange];

            let post = {};
            post.update = {};
            post.data = {};

            post.update.price = true;
            post.update.models = false;
            post.update.brands = false;
            post.update.data = true;

            post.data.entity = YAPP.CONNECTOR.ENTITY;
            post.data.price = YAPP.FORMS.MAIN_FILTER.price;
            post.data.brands = YAPP.FORMS.MAIN_FILTER.brands.VALUE;
            post.data.models = YAPP.FORMS.MAIN_FILTER.models.VALUE;
            post.data.city = YAPP.CONNECTOR.SELECTED_CITY.join();

            YAPP.MAIN_FILTER.getData(post);
            YAPP.MAIN_FILTER.renderLink();
        }
    });
});
rangeView_price.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_price[0].value = String(rangeView_price[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_price[1].value = String(rangeView_price[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_price[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_price[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_price[0].min);
        let max = parseInt(rangeInput_price[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_price[0].value = minView;
            rangeInput_price[1].value = maxView;
            $(range_price).css('left', (minView-min)/(max-min)*100+'%');
            $(range_price).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_price[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_price[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_price).data('min')) || maxView != parseInt($(range_price).data('max')) ) {
            YAPP.FORMS.MAIN_FILTER.price = [minView, maxView];

            let post = {};
            post.update = {};
            post.data = {};

            post.update.price = true;
            post.update.models = false;
            post.update.brands = false;
            post.update.data = true;

            post.data.entity = YAPP.CONNECTOR.ENTITY;
            post.data.price = YAPP.FORMS.MAIN_FILTER.price;
            post.data.brands = YAPP.FORMS.MAIN_FILTER.brands.VALUE;
            post.data.models = YAPP.FORMS.MAIN_FILTER.models.VALUE;
            post.data.city = YAPP.CONNECTOR.SELECTED_CITY.join();

            YAPP.MAIN_FILTER.getData(post);
            YAPP.MAIN_FILTER.renderLink();
        }
    });
});


YAPP.SwiperMainStories = new Swiper('.swiper-main-stories', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-main-stories-button-next',
        prevEl: '.swiper-main-stories-button-prev',
    },
    slidesPerView: 1,
    spaceBetween: 24,
    autoplay: {
        delay: 5000,
    },
    loop: true
});
YAPP.SwiperMainStoriesM = new Swiper('.swiper-main-stories-mobile', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-main-stories-button-next-mobile',
        prevEl: '.swiper-main-stories-button-prev-mobile',
    },
    slidesPerView: 1,
    spaceBetween: 24,
    autoplay: {
        delay: 5000,
    }
});


YAPP.SwiperMainStoriesM.VIEWED = JSON.parse(localStorage.getItem('STORIES')) || [];
$('.stories-item').each( function(i, e) {
    if ( YAPP.SwiperMainStoriesM.VIEWED.indexOf($(e).data('hash')) >= 0 ) $(e).addClass('viewed')
});
$(document).on('click', '.stories-item', function() {
    if ( YAPP.SwiperMainStoriesM.VIEWED.indexOf($(this).data('hash')) < 0 ) {
        $(this).addClass('viewed');
        YAPP.SwiperMainStoriesM.VIEWED.push($(this).data('hash'));
        localStorage.setItem('STORIES', JSON.stringify(YAPP.SwiperMainStoriesM.VIEWED));
    }
    YAPP.SwiperMainStoriesM.slideTo($(this).data('indx'));
});
YAPP.SwiperMainStoriesM.on('slideChange', function () {
    if ( YAPP.SwiperMainStoriesM.VIEWED.indexOf($('.stories-item[data-indx="'+YAPP.SwiperMainStoriesM.activeIndex+'"]').data('hash')) < 0 ) {
        $('.stories-item[data-indx="'+YAPP.SwiperMainStoriesM.activeIndex+'"]').addClass('viewed');
        YAPP.SwiperMainStoriesM.VIEWED.push($('.stories-item[data-indx="'+YAPP.SwiperMainStoriesM.activeIndex+'"]').data('hash'));
        localStorage.setItem('STORIES', JSON.stringify(YAPP.SwiperMainStoriesM.VIEWED));
    }
});

$('.remodal[role="stories"]').each( function(i, e) {
    $(this).find('[role="reaction"]').each( function(ir, er) {
        if ( localStorage.getItem( $(er).data('hash') ) ) {
            $(er).addClass('my-reaction')
        }
    });
});
$(document).on('click', '[role="reaction"]', function() {
    let reaction = Number($(this).data('reaction'));
    if ( localStorage.getItem($(this).data('hash')) ) {
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
    let url = '/api/stories-reaction/';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            id: $(this).data('id'),
            action: $(this).data('action'),
            value: reaction
        },
        success: (resp) => {
            $(this).find('span[role="value"]').text(JSON.parse(resp).result);
        },
        error: () => { 
        }
    });
});

YAPP.MAIN_FILTER.ENTITY = YAPP.CONNECTOR.ENTITY;
setInterval(() => {
    if ( YAPP.MAIN_FILTER.ENTITY != YAPP.CONNECTOR.ENTITY ) {
        YAPP.MAIN_FILTER.ENTITY = YAPP.CONNECTOR.ENTITY;
        let post = {};
        post.update = {};
        post.data = {};

        post.update.price = true;
        post.update.models = true;
        post.update.brands = true;
        post.update.data = true;

        post.data.entity = YAPP.CONNECTOR.ENTITY;
        post.data.price = [];
        post.data.brans = [];
        post.data.models = [];
        post.data.city = YAPP.CONNECTOR.SELECTED_CITY.join();

        YAPP.MAIN_FILTER.getData(post);

        $('.main-filter-tabs-item').removeClass('active');
        $('.main-filter-tabs-item[data-action="cis"][data-entity="'+YAPP.CONNECTOR.ENTITY+'"]').addClass('active');
        $('.main-filter-tabs-content-wrap').addClass('d-none');
        $('.main-filter-tabs-content-wrap[data-action="cis"]').removeClass('d-none');
    }
}, 100);

YAPP.MAIN_FILTER.CITY = YAPP.CONNECTOR.SELECTED_CITY.join();
setInterval(() => {
    if ( YAPP.MAIN_FILTER.CITY != YAPP.CONNECTOR.SELECTED_CITY.join() ) {
        YAPP.MAIN_FILTER.CITY = YAPP.CONNECTOR.SELECTED_CITY.join();
        YAPP.MAIN_FILTER.getCISCounts()
        YAPP.MAIN_FILTER.brands = [];
        YAPP.MAIN_FILTER.models = [];
        YAPP.MAIN_FILTER.price = [];


        let post = {};
        post.update = {};
        post.data = {};

        post.update.price = true;
        post.update.models = true;
        post.update.brands = true;
        post.update.data = true;

        post.data.entity = YAPP.CONNECTOR.ENTITY;
        post.data.price = [];
        post.data.brands = YAPP.FORMS.MAIN_FILTER.brands.VALUE;
        post.data.models = YAPP.FORMS.MAIN_FILTER.models.VALUE;
        post.data.city = YAPP.CONNECTOR.SELECTED_CITY.join();

        YAPP.MAIN_FILTER.getData(post);
    }
        
}, 100);










