// $(document).ready( function() {

//     let h = 0;
//     $('.container:not(.footer)').each( function(i,e) {
//         h += $(e).height();
//     })
//     if ( h + $('.footer').height() < $(document).height() ) $('.footer').css({'height':'calc(100vh - '+h+'px)'});
// });

$(document).on('click', '[role="qr"]', function() {
    $('.qr-cover').fadeIn(300);
    $('.qr-container').fadeIn(300);
    $('.qr-container').addClass('active');
    return false;
});
$(document).on('click', '[role="close"]', function() {
    $('.qr-cover').fadeOut(300);
    $('.qr-container').fadeOut(300);
    $('.qr-container').removeClass('active');
    return false;
});