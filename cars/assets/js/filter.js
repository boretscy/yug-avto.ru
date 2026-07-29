$(document).mouseup( function(e){
    let div = $('.filter-droplist');
    let container = $('.filter-dropcontainer'); 
    if ( !div.is(e.target)
        && div.has(e.target).length === 0
        && !container.is(e.target)
        && container.has(e.target).length === 0) {
        div.addClass('d-none');
        $(container).find('.filter-dropdown').removeClass('filter-dropdown-opened');
    }
});
$(document).on('click', '[data-action="expandFilter"]', function() {
    $('.blue-cover').toggleClass('active');
    $('.filter .collapse').toggleClass('d-none d-flex');
    return false;
});
$(document).on('click', '#YappsShowroom .filter-dropcontainer', function() {
    $(this).find('.filter-dropdown').toggleClass('filter-dropdown-opened');
    $(this).find('.filter-droplist').toggleClass('d-none d-block');
    $(this).find('img').toggleClass('rotate-180');
});
$(document).on('click', '[data-action="expandBrands"]', function() {
    $('.brands-list-item.hidden').toggleClass('d-none');
    $(this).find('span').toggleClass('d-none');
    $(this).find('img').toggleClass('rotate-180');
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
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_price).data('url'), {code:'price',value:minRange+','+maxRange,url_flag:$(range_price).data('url-flag')});
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        if ( minRange != parseInt($(range_price).data('min')) || maxRange != parseInt($(range_price).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_price).data('url'), {code:'price',value:minRange+','+maxRange,url_flag:$(range_price).data('url-flag')});
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
        if ( minView != parseInt($(range_price).data('min')) || maxView != parseInt($(range_price).data('max')) ) window.location = makeUrl( $(range_price).data('url'), {'price': minView+','+maxView});
    });
});

const range_volume = $('[data-range="volume"] .range-selected');
const rangeInput_volume = $('[data-range="volume"][role="range"] .range-input input');
const rangeView_volume = $('[data-range="volume"][role="view"] .range-view input');
rangeInput_volume.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_volume[0].value);
        let maxRange = parseInt(rangeInput_volume[1].value);
        let min = parseInt(rangeInput_volume[0].min);
        let max = parseInt(rangeInput_volume[1].max);
        rangeView_volume[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_volume[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_volume).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_volume).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_volume[0].value);
        let maxRange = parseInt(rangeInput_volume[1].value);
        if ( minRange != parseInt($(range_volume).data('min')) || maxRange != parseInt($(range_volume).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_volume).data('url'), {code:'volume',value:minRange+','+maxRange,url_flag:$(range_volume).data('url-flag')});
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_volume[0].value);
        let maxRange = parseInt(rangeInput_volume[1].value);
        if ( minRange != parseInt($(range_volume).data('min')) || maxRange != parseInt($(range_volume).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_volume).data('url'), {code:'volume',value:minRange+','+maxRange,url_flag:$(range_volume).data('url-flag')});
        }
    });
});
rangeView_volume.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_volume[0].value = String(rangeView_volume[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_volume[1].value = String(rangeView_volume[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_volume[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_volume[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_volume[0].min);
        let max = parseInt(rangeInput_volume[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_volume[0].value = minView;
            rangeInput_volume[1].value = maxView;
            $(range_volume).css('left', (minView-min)/(max-min)*100+'%');
            $(range_volume).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_volume[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_volume[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_volume).data('min')) || maxView != parseInt($(range_volume).data('max')) ) window.location = makeUrl( $(range_volume).data('url'), {'volume': minView+','+maxView});
    });
});

const range_power = $('[data-range="power"] .range-selected');
const rangeInput_power = $('[data-range="power"][role="range"] .range-input input');
const rangeView_power = $('[data-range="power"][role="view"] .range-view input');
rangeInput_power.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_power[0].value);
        let maxRange = parseInt(rangeInput_power[1].value);
        let min = parseInt(rangeInput_power[0].min);
        let max = parseInt(rangeInput_power[1].max);
        rangeView_power[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_power[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_power).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_power).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_power[0].value);
        let maxRange = parseInt(rangeInput_power[1].value);
        if ( minRange != parseInt($(range_power).data('min')) || maxRange != parseInt($(range_power).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_power).data('url'), {code:'power',value:minRange+','+maxRange,url_flag:$(range_power).data('url-flag')});
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_power[0].value);
        let maxRange = parseInt(rangeInput_power[1].value);
        if ( minRange != parseInt($(range_power).data('min')) || maxRange != parseInt($(range_power).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_power).data('url'), {code:'power',value:minRange+','+maxRange,url_flag:$(range_power).data('url-flag')});
        }
    });
});
rangeView_power.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_power[0].value = String(rangeView_power[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_power[1].value = String(rangeView_power[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_power[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_power[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_power[0].min);
        let max = parseInt(rangeInput_power[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_power[0].value = minView;
            rangeInput_power[1].value = maxView;
            $(range_power).css('left', (minView-min)/(max-min)*100+'%');
            $(range_power).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_power[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_power[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_power).data('min')) || maxView != parseInt($(range_power).data('max')) ) window.location = makeUrl( $(range_power).data('url'), {'power': minView+','+maxView});
    });
});

const range_year = $('[data-range="year"] .range-selected');
const rangeInput_year = $('[data-range="year"][role="range"] .range-input input');
const rangeView_year = $('[data-range="year"][role="view"] .range-view input');
rangeInput_year.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_year[0].value);
        let maxRange = parseInt(rangeInput_year[1].value);
        let min = parseInt(rangeInput_year[0].min);
        let max = parseInt(rangeInput_year[1].max);
        rangeView_year[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_year[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_year).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_year).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_year[0].value);
        let maxRange = parseInt(rangeInput_year[1].value);
        if ( minRange != parseInt($(range_year).data('min')) || maxRange != parseInt($(range_year).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_year).data('url'), {code:'year',value:minRange+','+maxRange,url_flag:$(range_year).data('url-flag')});
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_year[0].value);
        let maxRange = parseInt(rangeInput_year[1].value);
        if ( minRange != parseInt($(range_year).data('min')) || maxRange != parseInt($(range_year).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl_( $(range_year).data('url'), {code:'year',value:minRange+','+maxRange,url_flag:$(range_year).data('url-flag')});
        }
    });
});
rangeView_year.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_year[0].value = String(rangeView_year[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_year[1].value = String(rangeView_year[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_year[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_year[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_year[0].min);
        let max = parseInt(rangeInput_year[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_year[0].value = minView;
            rangeInput_year[1].value = maxView;
            $(range_year).css('left', (minView-min)/(max-min)*100+'%');
            $(range_year).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_year[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_year[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_year).data('min')) || maxView != parseInt($(range_year).data('max')) ) window.location = makeUrl( $(range_year).data('url'), {'year': minView+','+maxView});
    });
});

$(document).on('click', '.vehicles-more-button', function () {
    let total = Number($(this).data('total')), current = Number($(this).attr('data-current'));
    let next = current + 1;
    let baseUrl = $(this).data('app-url');
    $.post(
        baseUrl + '/api/',
        {
            url: $(this).data('url'),
            next: next
        }
    ).done( (data) => {
        $('.vehicle-list').append(data);
        $(this).attr('data-current', next);
        if ( next == total ) $(this).parent().parent().addClass('d-none');
        $('.vehicles-pagination [role="pagination"][data-page="'+next+'"]').toggleClass('c-yayellow c-h-yayellow c-yablack c-h-yablack');
    })
    return false;
});
