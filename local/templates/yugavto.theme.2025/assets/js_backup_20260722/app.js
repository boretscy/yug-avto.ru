YAPP.getWorld = function ( q = 1, f = 'a' ) {

    let res = {
        'c': ['цвет', 'цвета', 'цветов'],
        'a': ['автомобиль', 'автомобиля', 'автомобилей'],
        'n': ['новый', 'новых', 'новых']
    }
    let t = [
        [1],
        [2,3,4]
    ]
    for (let i=2; i<=300; i++) {
        t[0].push(i*10+1)
        t[1].push(i*10+2)
        t[1].push(i*10+3)
        t[1].push(i*10+4)
    }

    if ( t[0].indexOf(Number(q)) >= 0 ) return res[f][0]
    if ( t[1].indexOf(Number(q)) >= 0 ) return res[f][1]
    return res[f][2]
}
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

$(document).on('click', '[data-action="toggle-fav-com"]', function() {

    let vehicle = Number($(this).data('vehicle')), target = $(this).data('target');
    let indx = YAPP.CONNECTOR[target].indexOf(vehicle);
    if ( indx >= 0 ) {
        YAPP.CONNECTOR[target].splice(indx, 1);
    } else {
        YAPP.CONNECTOR[target].push(vehicle);
    }
    $(this).toggleClass('active');
    YAPP.setCookie(target, JSON.stringify(YAPP.CONNECTOR[target]), {'max-age': 3600*24*14});

    return false;
});