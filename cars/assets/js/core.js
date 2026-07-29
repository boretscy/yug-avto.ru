let makeUrl = function( url, params ) {
    url += ( url.indexOf('?') < 0 ) ? '?' : '&';
    let tmp = [];
    for ( let k in params ) tmp.push( k+'='+params[k] );
    url += tmp.join('&');
    return url;
}
let makeUrl_ = function( url, params ) {
    if ( params.url_flag == 'path' ) {
        url += params.code+'-'+params.value.split(',').join('-')+'/';
    } else {
        url += ( url.indexOf('?') < 0 ) ? '?' : '&';
        url += params.code+'='+params.value;
    }
    return url;
}
let formatNumber = function(q) {
    var Price = new Intl.NumberFormat('ru', { currency: 'RUR' })
    return Price.format(Number(q))
}

$(document).on('click', '[role="setDealership"]', function() {
    window['SELECTED_DEALERSHIP_CODE--_line'] = $(this).data('dealership')
    window['SELECTED_DEALERSHIP_CODE--_block'] = $(this).data('dealership')
    window['SELECTED_DEALERSHIP_CODE--_modal'] = $(this).data('dealership')
});

$(document).on('click', '[data-action="set-vehicle"]', function() {
    $('[data-remodal-id="offer-modal"]').find('input[name="vehicle"]').val($(this).data('vehicle-id'));
    $('[data-remodal-id="offer-modal"]').find('h4 span').text('на '+$(this).data('vehicle-name'));
});
$(document).on('click', 'a[data-form]', function() {
    $('.YappsShowroom-forms-modal-cover').addClass('active');
    $('#YappsShowroom forms-modal').removeClass('active');
    $('#YappsShowroom forms-modal[data-form="'+$(this).data('form')+'"]').addClass('active');

    return false;
});
$(document).on('click', 'a.forms-modal-close, .forms-modal-cover', function() {
    $('#YappsShowroom forms-modal-cover').removeClass('active');
    $('#YappsShowroom forms-modal').removeClass('active');

    return false;
});
$(document).on('click', '[action="sendShowroomForm"]', function() {
    
    let form, sendData = [], flag = true

    form = $(this).parent().parent().parent().parent()

    $(form).find('input, select, textarea').each( function( i, e ) {
        if ( $(e).attr('required') && !$(e).val() ) {
            flag = false
            $(e).addClass('is-invalid')
        }
    })
    if ( !$(form.find('input[name="aggry"]')).is(':checked') ) {
        flag = false
        $(form.find('input[name="aggry"]')).addClass('is-invalid')
    }

    if ( flag ) {

        sendData.push({name: 'src', value: window.location.href})
        sendData.push({name: 'AppName', value: 'Cis'})
        sendData.push({name: 'form', value: $(form).find('input[name="form"]').val()})
        sendData.push({name: 'mode', value: $(form).data('mode')})
        sendData.push({name: 'name', value: $(form).find('input[name="name"]').val()})
        sendData.push({name: 'phone', value: $(form).find('input[name="phone"]').val()})
        if ( typeof $(form).find('input[name="vehicle"]').val() !== 'undefined' ) sendData.push({name: 'vehicle', value: $(form).find('input[name="vehicle"]').val()})
        if ( typeof $(form).find('select[name="dealership"]').val() !== 'undefined' ) sendData.push({name: 'dealership', value: $(form).find('select[name="dealership"]').val()})
        if ( typeof $(form).find('input[name="car"]').val() !== 'undefined' ) sendData.push({name: 'car', value: $(form).find('input[name="car"]').val()})
        if ( typeof $(form).find('input[name="year"]').val() !== 'undefined' ) sendData.push({name: 'year', value: $(form).find('input[name="year"]').val()})
        if ( typeof $(form).find('input[name="condition"]').val() !== 'undefined' ) sendData.push({name: 'condition', value: $(form).find('input[name="condition"]').val()})
        
        $.ajax({
            type: 'POST',
            url: 'https://apps.yug-avto.ru/API/get/cis/send/?token=34b5ac8b71018c0bc7e5c050ed90b243',
            data: sendData,
            success: (data) => { 
                res = JSON.parse( data )

                console.log( sendData )
                
                if ( res.status  ) {

                    form.parent().find('[role="success"], [role="error"], [role="description"]').hide()
                    form.parent().find('[role="success"]').show()
                    form.hide()

                    $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')

                    var CallTouchURL = 'https://api.calltouch.ru/calls-service/RestAPI/requests/20621/register/';
					CallTouchURL += '?subject=Формы - '+sendData[2].value;
					CallTouchURL += '&sessionId='+window['call_value_78d47ede']
					CallTouchURL += '&fio='+sendData[4].value;
					CallTouchURL += '&phoneNumber='+sendData[5].value.replace(/[^\d;]/g, '');
                    
                    let request = new XMLHttpRequest();
                    request.open('GET', CallTouchURL, true);
                    request.send();

                } else {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="error"]').show()
                }

                setTimeout(() => {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="description"]').show()
                    form.show()

                }, 5000);

                $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')
            },
            error: () => { 
                console.log( 'error' ); 
                res = {status: 'error', description: 'Ошибка на сервере'}
                
                form.parent().find('[role="success"], [role="error"]').hide()
                form.parent().find('[role="error"]').show()

                $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')
            }
        });
    }

    return false;
})

function getCityName( q ) {

    switch ( q ) {
        case 'krasnodar': return 'Краснодар'; break;
        case 'maykop': return 'Майкоп'; break;
        case 'novorossiysk': return 'Новороссийск'; break;
        case 'yablonovskiy': return 'Яблоновский'; break;
        default: return '';
    }
}
function getCityAlias( q ) {

    switch ( q ) {
        case 'Краснодар': return 'krasnodar'; break;
        case 'Майкоп': return 'maykop'; break;
        case 'Новороссийск': return 'novorossiysk'; break;
        case 'Яблоновский': return 'yablonovskiy'; break;
        default: return '';
    }
}
function buildQuery( o ) {

    let res = [];
    for ( let i in o ) res.push( i+'='+o[i] );

    return res.join('&');
}

function buildCityLink( c ) {
    
    let path = location.pathname.split('/'), t = [];

    let parts = window.location.search.substr(1).split("&");
    let $_GET = {};
    for (let i = 0; i < parts.length; i++) {
        let temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }
    for ( let i in $_GET ) {
        if ( !i.length || !$_GET[i].length ) delete $_GET[i];
    }
    
    switch( c.length ) {
        case 0:
            path.splice(3, 1);
            if ( typeof $_GET.city != 'undefined' ) delete $_GET.city;
            break;
        case 1:
            temp = path[3].split("-");
            if ( getCityName(temp[1]) != '' ) path[3] = temp[0];
            path.splice(3, 0, getCityAlias(c[0]));
            if ( typeof $_GET.city != 'undefined' ) delete $_GET.city;
            break;
        default:
            switch ( path[3] ) {
                case 'krasnodar':
                case 'maykop':
                case 'novorossiysk':
                case 'yablonovskiy':
                    path.splice(3, 1);
                    break;
                default:

            }
            c.forEach(e => {
                t.push( e );
            });
            $_GET.city = t.join(',');
            break;
    }
    return path.join('/')+((Object.keys($_GET).length!=0)?'?'+buildQuery($_GET):'');
}

YAPP.CIS = {};
YAPP.CIS.CITY = YAPP.CONNECTOR.SELECTED_CITY.join();
YAPP.CONNECTOR.RELOAD = setInterval(() => {
    if ( YAPP.CIS.CITY != YAPP.CONNECTOR.SELECTED_CITY.join() ) {
        $('#YappsShowroom .cover').removeClass('d-none');
        window.location.href = buildCityLink(YAPP.CONNECTOR.SELECTED_CITY);
        clearInterval(YAPP.CONNECTOR.RELOAD);
    }
}, 100);
$(document).on('click', '#YappsShowroom a:not([role="not-cover"])', (e) => {
    if ( !e.ctrlKey && !e.metaKey ) {
        $('#YappsShowroom .cover').removeClass('d-none');
    }
});

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
    
    $(this).find('.vehicle-card-images-item-container').hide();
    $(this).find('.vehicle-card-images-item-container[data-index="'+indx+'"]').show();
    $(this).find('.vehicle-card-images-row-item').removeClass('active');
    $(this).find('.vehicle-card-images-row-item[data-index="'+indx+'"]').addClass('active');
});

$(document).on('touchmove', '.vehicle-card-images', function(e) {
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
    
    $(this).find('.vehicle-card-images-item-container').hide();
    $(this).find('.vehicle-card-images-item-container[data-index="'+indx+'"]').show();
    $(this).find('.vehicle-card-images-row-item').removeClass('active');
    $(this).find('.vehicle-card-images-row-item[data-index="'+indx+'"]').addClass('active');
});
