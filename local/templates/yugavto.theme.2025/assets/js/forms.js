if (!window.YAPP) window.YAPP = {};
window.YAPP.FORMS = window.YAPP.FORMS || {};

// Инициализация структуры дропдаунов и диапазонов
$('form').each(function(i, e) {
    const sid = $(e).data('sid');
    if (!sid) return;
    window.YAPP.FORMS[sid] = window.YAPP.FORMS[sid] || {};

    $(e).find('.form-dropcontainer').each(function(id, ed) {
        const listName = $(ed).children('.form-dropdown').data('list');
        if (!listName) return;

        window.YAPP.FORMS[sid][listName] = {
            MULTIPLE: !!$(ed).children('.form-droplist').data('multiple'),
            OPTIONS: [],
            VALUE: [],
            NAME: $(ed).data('name') || ''
        };

        $(ed).find('.form-droplist-item').each(function(io, eo) {
            const opt = {
                name: $(eo).text().trim(),
                value: $(eo).data('value'),
                indx: $(eo).data('indx')
            };
            window.YAPP.FORMS[sid][listName].OPTIONS.push(opt);
            if ($(eo).hasClass('selected')) {
                window.YAPP.FORMS[sid][listName].VALUE.push(opt);
            }
        });
    });

    $(e).find('.range').each(function(ir, er) {
        const rangeName = $(er).data('range');
        if (rangeName) {
            window.YAPP.FORMS[sid][rangeName] = [
                Number($(er).find('input[type="range"].min').val()),
                Number($(er).find('input[type="range"].max').val())
            ];
        }
    });
});

window.YAPP.FORMS.dropDownSelect = function(el) {
    let form = $(el).closest('form');
    let f = form.data('sid');
    let l = $(el).parent().parent().data('list');
    if (!f || !l || !window.YAPP.FORMS[f] || !window.YAPP.FORMS[f][l]) return;

    let dropcontainer = $(form).find('.form-dropcontainer[data-list="' + l + '"]');
    let input = $(form).find('input[name="' + l + '"]');

    $(el).toggleClass('selected');
    if (!$(dropcontainer).find('.form-droplist').attr('data-multiple')) {
        $(el).siblings('.form-droplist-item').removeClass('selected');
        $(dropcontainer).find('.form-droplist').removeClass('d-block').addClass('d-none');
        $(dropcontainer).find('.form-dropdown').removeClass('form-dropdown-opened');
    }

    window.YAPP.FORMS[f][l].VALUE = [];
    $(dropcontainer).find('.form-droplist-item').each(function(i, e) {
        if ($(e).hasClass('selected')) {
            window.YAPP.FORMS[f][l].VALUE.push({
                name: $(e).text().trim(),
                value: $(e).data('value'),
                indx: $(e).data('indx')
            });
        }
    });

    let val = window.YAPP.FORMS[f][l].VALUE.map(e => e.value);
    $(input).val(val.join(','));

    switch (window.YAPP.FORMS[f][l].VALUE.length) {
        case 0:
            $(dropcontainer).find('.form-dropdown span').text(window.YAPP.FORMS[f][l].NAME + ($(input).attr('required') ? ' *' : ''));
            $(dropcontainer).removeClass('selected');
            break;
        case 1:
            $(dropcontainer).find('.form-dropdown span').text(window.YAPP.FORMS[f][l].VALUE[0].name);
            $(dropcontainer).addClass('selected');
            break;
        default:
            $(dropcontainer).find('.form-dropdown span').text(window.YAPP.FORMS[f][l].NAME + ': ' + window.YAPP.FORMS[f][l].VALUE.length + ' выбрано');
            $(dropcontainer).addClass('selected');
            break;
    }
};

$(document).on('click', '.form-dropcontainer', function(e) {
    if (!$(e.target).is('.before') && !$(e.target).is('.after')) {
        $('.form-dropcontainer').not(this).find('.form-dropdown').removeClass('form-dropdown-opened');
        $(this).find('.form-dropdown').toggleClass('form-dropdown-opened');
        $(this).find('.form-droplist').toggleClass('d-none d-block');
    }
});

$(document).on('click', '.form-dropcontainer .form-droplist-item', function() {
    if (!$(this).parent().parent().attr('data-link')) {
        window.YAPP.FORMS.dropDownSelect($(this));
        return false;
    }
});

jQuery(function($) {
    $(document).mouseup(function(e) {
        var el = $('.form-droplist');
        var dropdown = $('.form-dropdown');
        if (!el.is(e.target) && el.has(e.target).length === 0 && !dropdown.is(e.target) && dropdown.has(e.target).length === 0) {
            $('.form-droplist').removeClass('d-block').addClass('d-none');
            $('.form-dropdown').removeClass('form-dropdown-opened');
        }
    });
});

$(document).on('click', '.form-dropcontainer .form-dropdown .after', function() {
    $(this).parent().toggleClass('form-dropdown-opened');
    $(this).parent().siblings('.form-droplist').toggleClass('d-block d-none');
    return false;
});

$(document).on('click', '.form-dropcontainer .form-dropdown div.before', function() {
    const formSid = $(this).closest('form').data('sid');
    const listName = $(this).parent().siblings('.form-droplist').data('list');

    $(this).parent().toggleClass('form-dropdown-opened');
    $(this).parent().siblings('.form-droplist').toggleClass('d-none d-block').find('.form-droplist-item').removeClass('selected');
    $(this).closest('.form-dropcontainer').removeClass('selected');

    if (formSid && listName && window.YAPP.FORMS[formSid] && window.YAPP.FORMS[formSid][listName]) {
        $(this).parent().find('span').text(window.YAPP.FORMS[formSid][listName].NAME);
    }
    return false;
});

$(document).on('click', '[role="setDealership"], [action="setDealership"]', function() {
    let modal = $(this).data('remodal-target'), code = $(this).data('dealership');
    $('[data-remodal-id="' + modal + '"] form input[name="DEALERSHIP"]').val(code);
    $('[data-remodal-id="' + modal + '"] form .form-dropcontainer[name="DEALERSHIP"]').addClass('selected');
    $('[data-remodal-id="' + modal + '"] form .form-dropcontainer[name="DEALERSHIP"] .form-droplist-item').each(function(i, e) {
        $(e).removeClass('selected');
        if ($(e).data('value') == code) {
            $('[data-remodal-id="' + modal + '"] form .form-dropcontainer[name="DEALERSHIP"] .form-dropdown span noindex').text($(e).data('text'));
            $(e).addClass('selected');
        }
    });
});

// Инициализация FormHandler без import/export
function initFormsHandler() {
    if (window.FormHandler && window.FormHandler.autoInit) {
        window.FormHandler.autoInit();
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initFormsHandler);
} else {
    initFormsHandler();
}