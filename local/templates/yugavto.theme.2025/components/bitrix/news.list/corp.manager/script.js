$(document).on('click', 'a[role="brand"]', function() {
    $('.corp-modal-cover').addClass('active');
    $('.corp-modal').removeClass('active');
    $('.corp-modal[data-target="'+$(this).data('target')+'"]').addClass('active');

    return false;
});
$(document).on('click', 'a.corp-modal-close, .corp-modal-cover', function() {
    $('.corp-modal-cover').removeClass('active');
    $('.corp-modal').removeClass('active');

    return false;
});