<?php
#!/usr/bin/php

$dd = '/var/www/admin/data/www/yug-avto.ru';
require_once $dd.'/local/php_interface/vendor/autoload.php';



/// NEW

$url = 'https://apps.yug-avto.ru/API/get/cis/vehicles/new?token=34b5ac8b71018c0bc7e5c050ed90b243';
$vehicles = json_decode( file_get_contents($url), true)['items'];
$google = []; $log = [];

if ( count($vehicles) ) {
    
    $ss = file_get_contents($dd.'/sitemap.xml');
    $arSS = explode('</sitemap><sitemap>', $ss);
    foreach ( $arSS as $k => $s ) {
        if ( mb_stripos($s, 'sitemap-cis-new.xml') !== false ) {
            unset( $arSS[$k] );
        }
    }
    file_put_contents($dd.'/sitemap.xml', implode('</sitemap><sitemap>', $arSS));

    $ss = file_get_contents($dd.'/sitemap.xml');
    if ( mb_stripos($ss, 'sitemap-cis-new.xml') === false ) {
        $arSS = explode('</sitemap><sitemap>', $ss);
        array_splice( $arSS, count($arSS)-1, 0, ['<loc>https://yug-avto.ru/sitemap-cis-new.xml</loc><lastmod>'.date('c').'</lastmod>'] );
        file_put_contents($dd.'/sitemap.xml', implode('</sitemap><sitemap>', $arSS));
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $xml .= '<sitemap><loc>https://yug-avto.ru/sitemap-brands-new.xml</loc><lastmod>'.date('c').'</lastmod></sitemap>';
    $xml .= '<sitemap><loc>https://yug-avto.ru/sitemap-vehicles-new.xml</loc><lastmod>'.date('c').'</lastmod></sitemap>';
    $xml .= '</sitemapindex>';

    $brands = [];
    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // yml
    /*
    $yml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.PHP_EOL;
    $yml .= '<yml_catalog date="'.date('Y-m-d H:s:i').'">'.PHP_EOL;
    $yml .= '<name>Юг-Авто</name>'.PHP_EOL;
    $yml .= '<company>ООО "Юг-Авто"</company>'.PHP_EOL;
    $yml .= '<currencies><currency rate="1" id="RUR"/></currencies>'.PHP_EOL;
    $yml .= '<categories><category id="1">Новые автомобили Юг-Авто</category></categories>'.PHP_EOL;
    $yml .= '<url>https://yug-avto.ru/cars/new/</url>'.PHP_EOL;
    $yml .= '<sets>'.PHP_EOL;
    $yml .= '<set id="premium"><name>Премиум</name><url>https://yug-avto.ru/cars/new/?price=4000000,100000000</url></set>'.PHP_EOL;
    $yml .= '<set id="business"><name>Для бизнеса</name><url>https://yug-avto.ru/cars/new/sollers/</url></set>'.PHP_EOL;
    $yml .= '<set id="bigfamily"><name>Для больших семей</name><url>https://yug-avto.ru/cars/new/?body=minivan</url></set>'.PHP_EOL;
    $yml .= '<set id="offroad"><name>Покорители бездорожья</name><url>https://yug-avto.ru/cars/new/?body=suv&amp;drive=full</url></set>'.PHP_EOL;
    $yml .= '<set id="city"><name>Для города</name><url>https://yug-avto.ru/cars/new/?body=sedan,hatchback,liftback</url></set>'.PHP_EOL;
    $yml .= '</sets>'.PHP_EOL;
    $yml .= '<offers>'.PHP_EOL;
    */

    foreach ( $vehicles as $v ) {
        $xml .= '<url><loc>';
        $xml .= 'https://yug-avto.ru/cars/new/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/';
        $xml .= '</loc><lastmod>'.date('c', (int)$v['created']).'</lastmod></url>';

        $brands[$v['brand']['ext_id']] = $v['brand'];

        // yml
        if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], [20,256,949,1227,1262,1268,1271,1309,1328,1331,1334,1340,1343,1346,1349,1355,1358,1361,1455,1458,1461,1650,1655,1670,1676,1679,1724,1725,1758]) ) {

            /*
            $yml .= '<offer id="'.$v['id'].'" available="true">'.PHP_EOL;
            $yml .= '<url>https://yug-avto.ru/cars/new/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>'.PHP_EOL;
            $yml .= '<picture>'.$v['image'].'</picture>'.PHP_EOL;
            $yml .= '<name>'.$v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?str_replace('&', '-', $v['equipment']):'').' '.(($v['_general'][2])?:'').'</name>'.PHP_EOL;
            $yml .= '<price>'.$v['min_price'].'</price>'.PHP_EOL;
            $yml .= '<vendor>'.$v['brand']['name'].'</vendor>'.PHP_EOL;
            $yml .= '<categoryId>1</categoryId>'.PHP_EOL;
            $yml .= '<currencyId>RUR</currencyId>'.PHP_EOL;
    
            $sets = [];
            if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
            if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
            if ( $v['body']['code'] == 'minivan' ) $sets[] = 'bi-family';
            if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'offroad';
            if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
            if ( !empty($sets) ) $yml .= '<set-ids>'.implode(', ', $sets).'</set-ids>'.PHP_EOL;
    
            $yml .= '<param name="Конверсия">'.(mt_rand(1000001,9999999)/1000000).'</param>';
    
            if ($v['_general'][3]) $yml .= '<param name="Двигатель">'.$v['_general'][2].'</param>'.PHP_EOL;
            if ($v['_general'][4]) $yml .= '<param name="Трансмиссия">'.$v['_general'][4].'</param>'.PHP_EOL;
            if ($v['_general'][5]) $yml .= '<param name="Привод">'.$v['_general'][5].'</param>'.PHP_EOL;
            if ($v['color']['code']!='none') $yml .= '<param name="Цвет">'.$v['color']['name'].'</param>'.PHP_EOL;
            if ($v['color']['body']!='none') $yml .= '<param name="Кузов">'.$v['body']['name'].'</param>'.PHP_EOL;
            if ($v['specifications'][0]['value']) $yml .= '<param name="Макс. скорость">'.$v['specifications'][0]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][5]['value']) $yml .= '<param name="Объем бака">'.$v['specifications'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][6]['value']) $yml .= '<param name="Объем багажника">'.$v['specifications'][6]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][7]['value']) $yml .= '<param name="Масса">'.$v['specifications'][7]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][8]['value']) $yml .= '<param name="Длина">'.$v['specifications'][8]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][9]['value']) $yml .= '<param name="Ширина">'.$v['specifications'][9]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][10]['value']) $yml .= '<param name="Высота">'.$v['specifications'][10]['value'].'</param>'.PHP_EOL;
            $yml .= '<description></description>'.PHP_EOL;
            $yml .= '<delivery>false</delivery>'.PHP_EOL;
            $yml .= '</offer>'.PHP_EOL;
            */

            // Google
            if ( (int)$v['created'] > time()-3600 ) $google[] = 'https://yug-avto.ru/cars/new/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>';
        }
    }
    $xml .= '</urlset>';
    file_put_contents($dd.'/sitemap-vehicles-new.xml', $xml);

    // yml
    /*
    $yml .= '</offers>'.PHP_EOL;
    $yml .= '</yml_catalog>';
    file_put_contents($dd.'/new-vehicles.xml', $yml);
    */

    foreach ( $vehicles as $v ) $brands[$v['brand']['ext_id']]['models'][$v['model']['ext_id']] = $v['model'];

    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ( $brands as $b ) {
        $xml .= '<url><loc>';
        $xml .= 'https://yug-avto.ru/cars/new/'.$b['code'];
        $xml .= '</loc><lastmod>'.date('c').'</lastmod></url>';
        foreach ( $b['models'] as $m ) {
            $xml .= '<url><loc>';
            $xml .= 'https://yug-avto.ru/cars/new/'.$b['code'].'/'.$m['code'].'/';
            $xml .= '</loc><lastmod>'.date('c').'</lastmod></url>';
        }
    }
    $xml .= '</urlset>';
    file_put_contents($dd.'/sitemap-brands-new.xml', $xml);

    if ( !empty($google) ) {
        $client = new Google_Client();
        // file-containing-secret-key.json - секретный ключ для доступа к API Google
        $client->setAuthConfig($dd.'/local/php_interface/yugavto-2198640fb47f.json');
        $client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        foreach ( $google as $indexURL ) {
            $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($indexURL));
            $log[] = [
                'url' => $indexURL,
                'response' => (string) $response->getBody()
            ];
        }
        if ( !empty($log) ) YApp::Log($log, __DIR__, 'IndexingLog', 'new_'.date('H-i'), 'txt');
    }

}





/// USED

$url = 'https://apps.yug-avto.ru/API/get/cis/vehicles/used?token=34b5ac8b71018c0bc7e5c050ed90b243';
$vehicles = json_decode( file_get_contents($url), true)['items'];
$google = []; $log = [];

if ( count($vehicles) ) {

    $ss = file_get_contents($dd.'/sitemap.xml');
    $arSS = explode('</sitemap><sitemap>', $ss);
    foreach ( $arSS as $k => $s ) {
        if ( mb_stripos($s, 'sitemap-cis-used.xml') !== false ) {
            unset( $arSS[$k] );
        }
    }
    file_put_contents($dd.'/sitemap.xml', implode('</sitemap><sitemap>', $arSS));

    $ss = file_get_contents($dd.'/sitemap.xml');
    if ( mb_stripos($ss, 'sitemap-cis-used.xml') === false ) {
        $arSS = explode('</sitemap><sitemap>', $ss);
        array_splice( $arSS, count($arSS)-1, 0, ['<loc>https://yug-avto.ru/sitemap-cis-used.xml</loc><lastmod>'.date('c').'</lastmod>'] );
        file_put_contents($dd.'/sitemap.xml', implode('</sitemap><sitemap>', $arSS));
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $xml .= '<sitemap><loc>https://yug-avto.ru/sitemap-brands-used.xml</loc><lastmod>'.date('c').'</lastmod></sitemap>';
    $xml .= '<sitemap><loc>https://yug-avto.ru/sitemap-vehicles-used.xml</loc><lastmod>'.date('c').'</lastmod></sitemap>';
    $xml .= '</sitemapindex>';
    file_put_contents($dd.'/sitemap-cis-used.xml', $xml);

    $brands = [];
    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // yml
    /*
    $yml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.PHP_EOL;
    $yml .= '<yml_catalog date="'.date('Y-m-d H:s:i').'">'.PHP_EOL;
    $yml .= '<name>Юг-Авто</name>'.PHP_EOL;
    $yml .= '<company>ООО "Юг-Авто"</company>'.PHP_EOL;
    $yml .= '<currencies><currency rate="1" id="RUR"/></currencies>'.PHP_EOL;
    $yml .= '<categories><category id="2">Автомобили с пробегом Юг-Авто</category></categories>'.PHP_EOL;
    $yml .= '<url>https://yug-avto.ru/cars/used/</url>'.PHP_EOL;
    $yml .= '<sets>'.PHP_EOL;
    $yml .= '<set id="premium"><name>Премиум</name><url>https://yug-avto.ru/cars/used/?dealership=1502</url></set>'.PHP_EOL;
    $yml .= '<set id="business"><name>Для бизнеса</name><url>https://yug-avto.ru/cars/used/?dealership=1489</url></set>'.PHP_EOL;
    $yml .= '<set id="bigfamily"><name>Для больших семей</name><url>https://yug-avto.ru/cars/used/?body=minivan</url></set>'.PHP_EOL;
    $yml .= '<set id="offroad"><name>Покорители бездорожья</name><url>https://yug-avto.ru/cars/used/?body=suv&amp;drive=full</url></set>'.PHP_EOL;
    $yml .= '<set id="city"><name>Для города</name><url>https://yug-avto.ru/cars/used/?body=sedan,hatchback,liftback</url></set>'.PHP_EOL;
    $yml .= '</sets>'.PHP_EOL;
    $yml .= '<offers>'.PHP_EOL;
    */

    foreach ( $vehicles as $v ) {
        $xml .= '<url><loc>';
        $xml .= 'https://yug-avto.ru/cars/used/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/';
        $xml .= '</loc><lastmod>'.date('c', (int)$v['created']).'</lastmod></url>';

        $brands[$v['brand']['ext_id']] = $v['brand'];

        // yml
        if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], [1364,1367,1489,1492,1499,1502,1533]) ) {

            /*
            $yml .= '<offer id="'.$v['id'].'" available="true">'.PHP_EOL;
            $yml .= '<url>https://yug-avto.ru/cars/used/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>'.PHP_EOL;
            $yml .= '<picture>'.$v['image'].'</picture>'.PHP_EOL;
            $yml .= '<name>'.$v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?str_replace('&', '-', $v['equipment']):'').' '.(($v['_general'][2])?:'').'</name>'.PHP_EOL;
            $yml .= '<price>'.$v['min_price'].'</price>'.PHP_EOL;
            $yml .= '<vendor>'.$v['brand']['name'].'</vendor>'.PHP_EOL;
            $yml .= '<categoryId>2</categoryId>'.PHP_EOL;
            $yml .= '<currencyId>RUR</currencyId>'.PHP_EOL;
    
            $sets = [];
            if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
            if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
            if ( $v['body']['code'] == 'minivan' ) $sets[] = 'bi-family';
            if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'offroad';
            if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
            if ( !empty($sets) ) $yml .= '<set-ids>'.implode(', ', $sets).'</set-ids>'.PHP_EOL;
    
            $yml .= '<param name="Конверсия">'.(mt_rand(1000001,9999999)/1000000).'</param>';
    
            if ($v['_general'][3]) $yml .= '<param name="Двигатель">'.$v['_general'][3].'</param>'.PHP_EOL;
            if ($v['_general'][4]) $yml .= '<param name="Трансмиссия">'.$v['_general'][4].'</param>'.PHP_EOL;
            if ($v['_general'][5]) $yml .= '<param name="Привод">'.$v['_general'][5].'</param>'.PHP_EOL;
            if ($v['color']['code']!='none') $yml .= '<param name="Цвет">'.$v['color']['name'].'</param>'.PHP_EOL;
            if ($v['color']['body']!='none') $yml .= '<param name="Кузов">'.$v['body']['name'].'</param>'.PHP_EOL;
            if ($v['_general'][0]) $yml .= '<param name="Год выпуска">'.$v['_general'][0].'</param>'.PHP_EOL;
            if ($v['general'][5]['value']) $yml .= '<param name="Пробег">'.$v['general'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][0]['value']) $yml .= '<param name="Макс. скорость">'.$v['specifications'][0]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][5]['value']) $yml .= '<param name="Объем бака">'.$v['specifications'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][6]['value']) $yml .= '<param name="Объем багажника">'.$v['specifications'][6]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][7]['value']) $yml .= '<param name="Масса">'.$v['specifications'][7]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][8]['value']) $yml .= '<param name="Длина">'.$v['specifications'][8]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][9]['value']) $yml .= '<param name="Ширина">'.$v['specifications'][9]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][10]['value']) $yml .= '<param name="Высота">'.$v['specifications'][10]['value'].'</param>'.PHP_EOL;
            $yml .= '<description></description>'.PHP_EOL;
            $yml .= '<delivery>false</delivery>'.PHP_EOL;
            $yml .= '</offer>'.PHP_EOL;
            */

            // Google
            if ( (int)$v['created'] > time()-3600 ) $google[] = 'https://yug-avto.ru/cars/used/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>';
        }
    }
    $xml .= '</urlset>';
    file_put_contents($dd.'/sitemap-vehicles-used.xml', $xml);

    // yml
    /*
    $yml .= '</offers>'.PHP_EOL;
    $yml .= '</yml_catalog>';
    file_put_contents($dd.'/used-vehicles.xml', $yml);
    */

    foreach ( $vehicles as $v ) $brands[$v['brand']['ext_id']]['models'][$v['model']['ext_id']] = $v['model'];

    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ( $brands as $b ) {
        $xml .= '<url><loc>';
        $xml .= 'https://yug-avto.ru/cars/used/'.$b['code'];
        $xml .= '</loc><lastmod>'.date('c').'</lastmod></url>';
        foreach ( $b['models'] as $m ) {
            $xml .= '<url><loc>';
            $xml .= 'https://yug-avto.ru/cars/used/'.$b['code'].'/'.$m['code'].'/';
            $xml .= '</loc><lastmod>'.date('c').'</lastmod></url>';
        }
    }
    $xml .= '</urlset>';
    file_put_contents($dd.'/sitemap-brands-used.xml', $xml);

    if ( !empty($google) ) {
        $client = new Google_Client();
        // file-containing-secret-key.json - секретный ключ для доступа к API Google
        $client->setAuthConfig($dd.'/local/php_interface/yugavto-2198640fb47f.json');
        $client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        foreach ( $google as $indexURL ) {
            $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($indexURL));
            $log[] = [
                'url' => $indexURL,
                'response' => (string) $response->getBody()
            ];
        }
        if ( !empty($log) ) YApp::Log($log, __DIR__, 'IndexingLog', 'used_'.date('H-i'), 'txt');
    }

}