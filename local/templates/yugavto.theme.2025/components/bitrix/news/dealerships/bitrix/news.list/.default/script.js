$(document).on('click', '.dealerships-filter .filter-dropcontainer', function() {
    $(this).find('.filter-dropdown').toggleClass('filter-dropdown-opened');
    $(this).find('.filter-droplist').toggleClass('d-none d-block');
    $(this).find('img').toggleClass('rotate-180');
});
document.addEventListener("DOMContentLoaded", () => {
    $('.dealership-card-rating').each( function(i, e) {
        $(e).html('<iframe src="https://yandex.ru/sprav/widget/rating-badge/'+$(e).data('id')+'?type=rating" width="150" height="50" frameborder="0"></iframe>');
    });
});