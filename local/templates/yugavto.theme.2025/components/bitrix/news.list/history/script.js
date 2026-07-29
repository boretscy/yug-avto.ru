$(document).on('click', '[role="historyGroup"]', function() {

    if ( $(this).data('group') != 1997 ) {
        $(this).toggleClass('active');
        $('[role="historyItem"][data-group="'+$(this).data('group')+'"]').toggleClass('d-none');
    }

    return false;
});