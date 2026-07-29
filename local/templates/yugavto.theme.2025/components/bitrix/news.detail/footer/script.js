$(document).on('click', '[role="footer-seo-expand"]', function() {
    $('.footer-seo-text').addClass('full');
    $(this).hide();
    $('[role="footer-seo-collapse"]').show();

    return false;
});
$(document).on('click', '[role="footer-seo-collapse"]', function() {
    $('.footer-seo-text').removeClass('full');
    $(this).hide();
    $('[role="footer-seo-expand"]').show();

    return false;
});

$(document).on('click', '[role="footer-disclamer-expand"]', function() {
    $('.footer-disclamer-text').addClass('full');
    $(this).hide();
    $('[role="footer-disclamer-collapse"]').show();

    return false;
});
$(document).on('click', '[role="footer-disclamer-collapse"]', function() {
    $('.footer-disclamer-text').removeClass('full');
    $(this).hide();
    $('[role="footer-disclamer-expand"]').show();

    return false;
});

setTimeout(() => {
    if ( YAPP.getCookie('COOKIE_AGRY') != 'Y' ) {
        $('.cookie').show()
    }
}, 500);
$(document).on('click', '[role="close-cookie"]', function() {
    YAPP.setCookie('COOKIE_AGRY', 'Y');
    $('.cookie').hide()
    return false;
});

$(document).on('click', '.up-button', function() {

    $('html, body').animate({
        scrollTop: $('body').offset().top
    }, 300);
    return false;
});
$(window).scroll(function() {
    if ( $(this).scrollTop() >= 100 ) {
        $('.up-button').removeClass('d-none')
    } else {
        $('.up-button').addClass('d-none')
    }
});