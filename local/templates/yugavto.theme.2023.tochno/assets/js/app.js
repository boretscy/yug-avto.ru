function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function setCookie(name, value, options = {}) {

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
        ...options
    };
  
    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }
  
    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);
  
    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }
  
    document.cookie = updatedCookie;
}
function deleteCookie(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}



/* 2023 */ 
YAPP.getCookie = function(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
YAPP.setCookie = function(name, value, options = {}) {

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
        ...options
    };
  
    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }
  
    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);
  
    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }
  
    document.cookie = updatedCookie;
}
YAPP.deleteCookie = function(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}

YAPP.CONNECTOR.CIS_FAVORITES = JSON.parse(YAPP.getCookie('CIS_FAVORITES') || '[]');
YAPP.CONNECTOR.CIS_COMPARE = JSON.parse(YAPP.getCookie('CIS_COMPARE') || '[]');
YAPP.CONNECTOR.ENTITY = YAPP.getCookie('ENTITY') || 'new';
YAPP.CONNECTOR.COUNTS = {new: 0, used: 0};

$(document).on('click', '[role="toggle-fav-com"], [action="toggle-fav-com"]', function() {

    let vehicle = Number($(this).data('vehicle')), target = $(this).data('target');
    let indx = YAPP.CONNECTOR[target].indexOf(vehicle);
    if ( indx >= 0 ) {
        YAPP.CONNECTOR[target].splice(indx, 1);
    } else {
        YAPP.CONNECTOR[target].push(vehicle);
    }
    $(this).toggleClass('bg-yawhite bg-yayellow');
    setCookie(target, JSON.stringify(YAPP.CONNECTOR[target]), {'max-age': 3600*24*14});

    return false;
});

$(document).mouseup( function(e){ // событие клика по веб-документу
    let div = $('.filter-droplist'); // тут указываем ID элемента
    let container = $('.filter-dropcontainer'); 
    if ( !div.is(e.target)
        && div.has(e.target).length === 0
        && !container.is(e.target)
        && container.has(e.target).length === 0) { // и не по его дочерним элементам
        div.addClass('d-none'); // скрываем его
        $(container).find('.filter-dropdown').removeClass('filter-dropdown-opened');
    }
});
$(document).on('click', '.form .form-card .filter-dropcontainer', function() {
    $(this).find('.filter-dropdown').toggleClass('filter-dropdown-opened');
    $(this).find('.filter-droplist').toggleClass('d-none d-block');
    $(this).find('img').toggleClass('rotate-180');
});
$(document).on('click', '.form .form-card .filter-dropcontainer .filter-droplist-item', function() {

    $(this).siblings().removeClass('bg-yalightgray selected fw-bold');
    $(this).toggleClass('bg-yalightgray selected fw-bold');
    $(this).parent().parent().parent().siblings('input').val($(this).data('value'));
    $($(this).parent().siblings().find('span')[0]).text( (($(this).hasClass('selected'))?$(this).data('text'):$(this).data('title')+'(все)'));
    $(this).parent().addClass('d-none');


    return false;
});
setInterval(() => {
    if ( JSON.stringify(YAPP.CONNECTOR.SELECTED_CITY) != YAPP.getCookie('SELECTED_CITY') ) YAPP.CONNECTOR.SELECTED_CITY = JSON.parse(YAPP.getCookie('SELECTED_CITY'));
}, 100);
$(document).on('click', 'a[href^="tel"], a[href^="phone"]', function() {
    ym(6251896,'reachGoal','PHONE_CLICK')
});
let form, sendData = {}, flag = true
$(document).on('click', '[role="sendForm"]', function() {

    flag = true;

    $(form).find('input, select, textarea, .filter-dropdown').removeClass('is-invalid')
    
    form = $(this).parent().parent().parent()
    $(form).find('input, select, textarea').each( function( i, e ) {
        if ( $(e).attr('required') && !$(e).val() ) {
            flag = false
            $(e).addClass('is-invalid')
            $(e).siblings('.form-group').find('.filter-dropdown').addClass('is-invalid');
        }
        sendData[$(e).attr('name')] = $(e).val()
    })
    if ( !$(form.find('input[name="AGRYY"]')).is(':checked') ) {
        flag = false
        $(form.find('input[name="AGRYY"]')).addClass('is-invalid')
    } else {
        sendData.AGRYY = 'on';
    }

    if ( flag ) {

        $.ajax({
            type: 'POST',
            url: '/api/send_new/',
            data: sendData,
            success: (data) => { 
                res = JSON.parse( data )
                
                if ( res.status == 'success'  ) {

                    form.parent().find('[role="success"], [role="error"], [role="description"]').addClass('d-none')
                    form.parent().find('[role="success"]').removeClass('d-none')
                    form.addClass('d-none')

                    $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')

                    let CallTouchURL = 'https://api.calltouch.ru/calls-service/RestAPI/requests/20621/register/';
					CallTouchURL += '?subject=Формы - '+sendData.FORM;
					CallTouchURL += '&sessionId='+window['call_value_78d47ede']
					CallTouchURL += '&fio='+sendData.NAME;
					CallTouchURL += '&phoneNumber='+sendData.PHONE.replace(/[^\d;]/g, '');

                    let request = new XMLHttpRequest();
                    request.open('GET', CallTouchURL, true);
                    request.send();

                    ym(6251896,'reachGoal',$(form).data('sid'))

                } else {
                    
                    form.parent().find('[role="success"], [role="error"]').addClass('d-none')
                    form.parent().find('[role="error"]').removeClass('d-none')
                }

                setTimeout(() => {
                    
                    form.parent().find('[role="success"], [role="error"]').addClass('d-none')
                    form.removeClass('d-none')

                }, 5000);
            },
            error: () => { 
                console.log( 'error' ); 
                res = {status: 'error', description: 'Ошибка на сервере'}
                
                form.parent().find('[role="success"], [role="error"]').addClass('d-none')
                form.parent().find('[role="error"]').removeClass('d-none')
            }
        });
    }

    return false;
})


$(document).on('click', '[role="setDealership"]', function() {
    $('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer .filter-droplist-item').removeClass('bg-yalightgray selected fw-bold');
    $('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer .filter-droplist-item[data-value="'+$(this).data('dealership')+'"]').addClass('bg-yalightgray selected fw-bold');
    $($('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer').find('span')[0]).text($('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer .filter-droplist-item[data-value="'+$(this).data('dealership')+'"]').data('text'))
    $('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card input[name="DEALERSHIP"]').val($(this).data('dealership'));
});
$(document).on('click', 'a[data-form]', function() {
    $('.forms-modal-cover').addClass('active');
    $('.forms-modal').removeClass('active');
    $('.forms-modal[data-form="'+$(this).data('form')+'"]').addClass('active');

    return false;
});
$(document).on('click', 'a.forms-modal-close, .forms-modal-cover', function() {
    $('.forms-modal-cover').removeClass('active');
    $('.forms-modal').removeClass('active');

    return false;
});
