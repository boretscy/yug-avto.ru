$(document).on( 'click', '.faq-q-item', function() {
    $('.faq-q-item').removeClass('active');
    $(this).addClass('active');
    $('.faq-a-item').addClass('d-none').removeClass('m-active');
    $('.faq-a-item[data-indx="'+$(this).data('indx')+'"]').removeClass('d-none').addClass('m-active');
})