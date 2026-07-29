YAPP.FORMS = {};
$('form').each( function(i, e) {
    YAPP.FORMS[$(e).data('sid')] = {}
    $(e).find('.form-dropcontainer').each( function(id, ed) {
        YAPP.FORMS[$(e).data('sid')][$(ed).children('.form-dropdown').data('list')] = {};
        YAPP.FORMS[$(e).data('sid')][$(ed).children('.form-dropdown').data('list')].MULTIPLE = ( $(ed).children('.form-droplist').data('multiple') ) ? true : false;
        YAPP.FORMS[$(e).data('sid')][$(ed).children('.form-dropdown').data('list')].OPTIONS = [];
        YAPP.FORMS[$(e).data('sid')][$(ed).children('.form-dropdown').data('list')].VALUE = [];
        YAPP.FORMS[$(e).data('sid')][$(ed).children('.form-dropdown').data('list')].NAME = $(ed).data('name');
        $(ed).find('.form-droplist-item').each( function(io, eo) {
            YAPP.FORMS[$(e).data('sid')][$(ed).children('.form-dropdown').data('list')].OPTIONS.push({
                name: $(eo).text(),
                value: $(eo).data('value'),
                indx: $(eo).data('indx')
            });
            if ( $(eo).hasClass('selected') ) {
                YAPP.FORMS[$(e).data('sid')][$(ed).children('.form-dropdown').data('list')].VALUE.push({
                    name: $(eo).text(),
                    value: $(eo).data('value'),
                    indx: $(eo).data('indx')
                });
            }
        });
    });
    $(e).find('.range').each( function(ir, er) {
        YAPP.FORMS[$(e).data('sid')][$(er).data('range')] = [
            Number($(er).find('input[type="range"].min').val()),
            Number($(er).find('input[type="range"].max').val())
        ];
    })
});

YAPP.FORMS.dropDownSelect = function( el ) {
    
    let f = $(el).closest('form').data('sid');
    let l = $(el).parent().parent().data('list');
    let v = {
        name: $(el).text(),
        value: $(el).data('value'),
        indx: $(el).data('indx')
    };

    let form = $(el).closest('form');
    let dropcontainer = $(form).find('.form-dropcontainer[data-list="'+l+'"]');
    let input = $(form).find('input[name="'+l+'"]');

    $(el).toggleClass('selected');
    if ( !$(dropcontainer).find('.form-droplist').attr('data-multiple')  ) {
        $(el).siblings('.form-droplist-item').removeClass('selected');
        $(dropcontainer).find('.form-droplist').removeClass('d-block').addClass('d-none');
        $(dropcontainer).find('.form-dropdown').removeClass('form-dropdown-opened');
    }

   
    YAPP.FORMS[f][l].VALUE = [];
    $(dropcontainer).find('.form-droplist-item').each( function(i, e) {
        if ( $(e).hasClass('selected') ) {
            YAPP.FORMS[f][l].VALUE.push({
                name: $(e).text(),
                value: $(e).data('value'),
                indx: $(e).data('indx')
            })
        }
    });
    let val = [];
    YAPP.FORMS[f][l].VALUE.forEach(e => {
        val.push(e.value);
    });
    $(input).val( val.join(',') );
    switch ( YAPP.FORMS[f][l].VALUE.length ) {
        case 0:
            $(dropcontainer).find('.form-dropdown span').text(YAPP.FORMS[f][l].NAME+(($(input).attr('required'))?' *':''));
            $(dropcontainer).removeClass('selected');
            break;
        case 1:
            $(dropcontainer).find('.form-dropdown span').text(YAPP.FORMS[f][l].VALUE[0].name);
            $(dropcontainer).addClass('selected');
            break;
        default:
            $(dropcontainer).find('.form-dropdown span').text(YAPP.FORMS[f][l].NAME+': '+YAPP.FORMS[f][l].VALUE.length+' выбрано');
            $(dropcontainer).addClass('selected');
            break;
    }
}

$(document).on('click', '.form-dropcontainer', function(e) {

    if ( !$(e.target).is('.before') && !$(e.target).is('.after') ) {
        $('.form-dropcontainer').not(this).find('.form-dropdown').removeClass('form-dropdown-opened');
        $(this).find('.form-dropdown').toggleClass('form-dropdown-opened');
        $(this).find('.form-droplist').toggleClass('d-none d-block');
    }
});
$(document).on('click', '.form-dropcontainer .form-droplist-item', function() {

    let form = $(this).closest('form').data('sid');
    let list = $(this).parent().parent().data('list');
    let value = {
        name: $(this).text(),
        value: $(this).data('value'),
        indx: $(this).data('indx')
    };
    
    if ( !$(this).parent().parent().attr('data-link') ) {
        
        YAPP.FORMS.dropDownSelect( $(this) );
        return false;
    }
});
jQuery(function($){
	$(document).mouseup( function(e){ // событие клика по веб-документу
		var el = $( '.form-droplist' ); // тут указываем ID элемента
		if ( !el.is(e.target) // если клик был не по нашему блоку
		    && el.has(e.target).length === 0 ) { // и не по его дочерним элементам
            $('.form-droplist').removeClass('d-block').addClass('d-none');
            $('.form-dropdown').removeClass('form-dropdown-opened');
		}
	});
});
$(document).on('click', '.form-dropcontainer .form-dropdown .after', function() {
    $(this).parent().toggleClass('form-dropdown-opened');
    $(this).parent().siblings('.form-droplist').toggleClass('d-block d-none');
});
$(document).on('click', '.form-dropcontainer .form-dropdown div.before', function() {
    $(this).parent().toggleClass('form-dropdown-opened');
    $(this).parent().siblings('.form-droplist').toggleClass('d-none d-block').find('.form-droplist-item').removeClass('selected');
    $(this).closest('.form-dropcontainer').removeClass('selected');
    $(this).parent().find('span').text(YAPP.FORMS[$(this).closest('form').data('sid')][$(this).parent().siblings('.form-droplist').data('list')].NAME);
});
$(document).on('click', '[role="setDealership"], [action="setDealership"]', function() {
    let modal = $(this).data('remodal-target'), code = $(this).data('dealership');
    $('[data-remodal-id="'+modal+'"] form input[name="DEALERSHIP"]').val( code );
    $('[data-remodal-id="'+modal+'"] form .form-dropcontainer[name="DEALERSHIP"]').addClass('selected');
    $('[data-remodal-id="'+modal+'"] form .form-dropcontainer[name="DEALERSHIP"] .form-droplist-item').each( function(i, e) {
        $(e).removeClass('selected');
        if ( $(e).data('value') == code ) {
            $('[data-remodal-id="'+modal+'"] form .form-dropcontainer[name="DEALERSHIP"] .form-dropdown span noindex').text( $(e).data('text') );
            $(e).addClass('selected');
        }
    });
});

let form, sendData = {}, flag = true
$(document).on('click', '[role="sendForm"]', function() {

    flag = true;

    $(form).find('input, select, textarea, .form-dropdown').removeClass('is-invalid')
    
    form = $(this).parent().parent().parent();
    form.parent().find('[role="success"], [role="error"], [role="description"]').height( form.height() );

    $(form).find('input, select, textarea').each( function( i, e ) {
        if ( $(e).attr('required') && !$(e).val() ) {
            flag = false;
            $(e).addClass('is-invalid');
            $(e).siblings('.form-group').find('.form-dropdown').addClass('is-invalid');
        }
        sendData[$(e).attr('name')] = $(e).val()
    })
    if ( !$(form.find('input[name="AGRYY"]')).is(':checked') ) {
        flag = false;
        $(form.find('input[name="AGRYY"]')).addClass('is-invalid');
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
});