<?php
#!/usr/bin/php
$dd = '/var/www/admin/data/www/yug-avto.ru';

ini_set('error_reporting', E_ALL & ~E_NOTICE);
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);

function sp( $q, $hide = false, $title = false ) {
			
    echo '<pre '.(($hide)?'style="display:none;"':'').'>';
    if ( $title ) echo $title.'<br />-------------------------------<br />';
    print_r( $q );
    echo '</pre>';
}


/// NEW

$url = 'https://' . YApp::GO_API_DOMAIN . '/API/get/cis/vehicles/new?token=34b5ac8b71018c0bc7e5c050ed90b243';
$vehicles = json_decode( file_get_contents($url), true)['items'];

if ( count($vehicles) ) {
    
}

/*
if ( count($vehicles) ) {

    $krd = [20,1322,1331,1340,1346,1670,1676,1679];
    $yabl = [256,949,1227,1262,1268,1271,1309,1328,1334,1343,1349,1355,1358,1361,1455,1458,1461,1650,1655,1724,1725,1758,1761];
    $nvr = [1265,1337,1755];  

    // yml krd
    $yml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.PHP_EOL;
    $yml .= '<yml_catalog date="'.date('Y-m-d H:s').'">'.PHP_EOL;
    $yml .= '<shop>'.PHP_EOL;
    $yml .= '<name>Юг-Авто</name>'.PHP_EOL;
    $yml .= '<company>ООО "Юг-Авто"</company>'.PHP_EOL;
    $yml .= '<url>https://yug-avto.ru/</url>'.PHP_EOL;
    $yml .= '<currencies><currency rate="1" id="RUR"/></currencies>'.PHP_EOL;
    $yml .= '<categories>'.PHP_EOL;
    $yml .= '<category id="9999999996">Новые автомобили Юг-Авто</category>'.PHP_EOL;

    $cats = [];
    foreach ( $vehicles as $v ) {
        if ( $v['type'] == 'vehicle' && ( in_array($v['dealership']['id'], $krd) || in_array($v['dealership']['id'], $yabl) ) ) {
            if ( $v['brand']['code'] && $v['model']['code'] ) {
                if ( !in_array($v['brand']['code'], array_keys($cats)) ) {
                    $cats[$v['brand']['code']] = [
                        'name' => $v['brand']['name'],
                        'id' => $v['brand']['ext_id'],
                        'cats' => []
                    ];
                }
                if ( !in_array($v['model']['code'],  array_keys($cats[$v['brand']['code']]['cats'])) ) {
                    $cats[$v['brand']['code']]['cats'][$v['model']['code']] = [
                        'name' => $v['model']['name'],
                        'id' => $v['model']['ext_id'],
                    ];
                }
            }
        }
    }
    foreach ( $cats as $b) {
        $yml .= '<category id="'.$b['id'].'" parentId="9999999996">'.$b['name'].'</category>'.PHP_EOL;
        foreach ( $b['cats'] as $m ) {
            $yml .= '<category id="'.$m['id'].'" parentId="'.$b['id'].'">'.$m['name'].'</category>'.PHP_EOL;
        }
    }
    $yml .= '</categories>'.PHP_EOL;

    $yml .= '<sets>'.PHP_EOL; $sets = [];
    foreach ( $vehicles as $k => $v ) {
        if ( $v['type'] == 'vehicle' ) {
            if ( in_array($v['dealership']['id'], $krd) ) {
                $sets['auto_krd'] = [
                    'name' => 'Новые автомобили в Краснодаре',
                    'link' => 'https://yug-avto.ru/cars/new/krasnodar/'
                ];
                $sets[$v['brand']['code'].'_krd'] = [
                    'name' => 'Новые '.$v['brand']['name'].' в Краснодаре',
                    'link' => 'https://yug-avto.ru/cars/new/krasnodar/'.$v['brand']['code'].'/'
                ];
                $sets[$v['brand']['code'].'_'.$v['model']['code'].'_krd'] = [
                    'name' => 'Новый автомобиль '.$v['brand']['name'].' '.$v['model']['name'].' в Краснодаре',
                    'link' => 'https://yug-avto.ru/cars/new/krasnodar/'.$v['brand']['code'].'/'.$v['model']['code'].'/'
                ];
            }
            if ( in_array($v['dealership']['id'], $yabl) ) {
                $sets['auto_yabl'] = [
                    'name' => 'Новые автомобили в Яблоновском',
                    'link' => 'https://yug-avto.ru/cars/new/yablonovskiy/'
                ];
                $sets[$v['brand']['code'].'_yabl'] = [
                    'name' => 'Новые '.$v['brand']['name'].' в Яблоновском',
                    'link' => 'https://yug-avto.ru/cars/new/yablonovskiy/'.$v['brand']['code'].'/'
                ];
                $sets[$v['brand']['code'].'_'.$v['model']['code'].'_yabl'] = [
                    'name' => 'Новый автомобиль '.$v['brand']['name'].' '.$v['model']['name'].' в Яблоновском',
                    'link' => 'https://yug-avto.ru/cars/new/yablonovskiy/'.$v['brand']['code'].'/'.$v['model']['code'].'/'
                ];
            }
        }
    }
    foreach ( $sets as $k => $set ) {
        $yml .= '<set id="'.$k.'"><name>'.$set['name'].'</name><url>'.$set['link'].'</url></set>'.PHP_EOL;
    }
    $yml .= '</sets>'.PHP_EOL;

    $yml .= '<offers>'.PHP_EOL;
    foreach ( $vehicles as $v ) {

        if ( $v['type'] == 'vehicle' && ( in_array($v['dealership']['id'], $krd) || in_array($v['dealership']['id'], $yabl) ) ) {

            $yml .= '<offer id="'.$v['id'].'" available="true">'.PHP_EOL;
            $yml .= '<url>https://yug-avto.ru/cars/new/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>'.PHP_EOL;
            $yml .= '<picture>'.$v['images'][0]['preview'].'</picture>'.PHP_EOL;
            if ( $v['images'][1]['preview'] && $v['images'][1]['preview'] != $v['images'][0]['preview'] ) $yml .= '<picture>'.$v['images'][1]['preview'].'</picture>'.PHP_EOL;
            if ( $v['images'][2]['preview'] && $v['images'][2]['preview'] != $v['images'][0]['preview'] ) $yml .= '<picture>'.$v['images'][2]['preview'].'</picture>'.PHP_EOL;
            $yml .= '<name>'.$v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?str_replace('&', '-', $v['equipment']):'').' '.(($v['_general'][2])?:'').'</name>'.PHP_EOL;
            $yml .= '<price>'.$v['min_price'].'</price>'.PHP_EOL;
            $yml .= '<vendor>'.$v['brand']['name'].'</vendor>'.PHP_EOL;
            $yml .= '<categoryId>'.$v['model']['ext_id'].'</categoryId>'.PHP_EOL;
            $yml .= '<currencyId>RUR</currencyId>'.PHP_EOL;
    
            $sets = [];
            $yml .= '<set-ids>auto_'.((in_array($v['dealership']['id'], $krd))?'krd':'yabl').','.$v['brand']['code'].'_'.((in_array($v['dealership']['id'], $krd))?'krd':'yabl').','.$v['brand']['code'].'_'.$v['model']['code'].'_'.((in_array($v['dealership']['id'], $krd))?'krd':'yabl').'</set-ids>'.PHP_EOL;
    
            $yml .= '<param name="Конверсия">'.(mt_rand(1000001,9999999)/1000000).'</param>';
    
            if ($v['_general'][3]) $yml .= '<param name="Двигатель">'.$v['_general'][2].'</param>'.PHP_EOL;
            if ($v['_general'][4]) $yml .= '<param name="Трансмиссия">'.$v['_general'][4].'</param>'.PHP_EOL;
            if ($v['_general'][5]) $yml .= '<param name="Привод">'.$v['_general'][5].'</param>'.PHP_EOL;
            if ($v['color']['code']!='none') $yml .= '<param name="Цвет">'.$v['color']['name'].'</param>'.PHP_EOL;
            if ($v['body']['code']!='none') $yml .= '<param name="Кузов">'.$v['body']['name'].'</param>'.PHP_EOL;
            if ($v['specifications'][0]['value']) $yml .= '<param name="Макс. скорость">'.$v['specifications'][0]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][5]['value']) $yml .= '<param name="Объем бака">'.$v['specifications'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][6]['value']) $yml .= '<param name="Объем багажника">'.$v['specifications'][6]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][7]['value']) $yml .= '<param name="Масса">'.$v['specifications'][7]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][8]['value']) $yml .= '<param name="Длина">'.$v['specifications'][8]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][9]['value']) $yml .= '<param name="Ширина">'.$v['specifications'][9]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][10]['value']) $yml .= '<param name="Высота">'.$v['specifications'][10]['value'].'</param>'.PHP_EOL;
            $yml .= '<delivery>false</delivery>'.PHP_EOL;
            $yml .= '</offer>'.PHP_EOL;
        }
    }

    $yml .= '</offers>'.PHP_EOL;
    $yml .= '</shop>'.PHP_EOL;
    $yml .= '</yml_catalog>';
    file_put_contents($dd.'/vehicles-new.xml', $yml);
}
*/




/// USED
/*
$url = 'https://' . YApp::GO_API_DOMAIN . '/API/get/cis/vehicles/used?token=34b5ac8b71018c0bc7e5c050ed90b243';
$vehicles = json_decode( file_get_contents($url), true)['items'];
$google = []; $log = [];

if ( count($vehicles) ) {

    $krd = [1364,1367,1489,1492,1499,1502,1533];
    $nvr = [1373];

    $yml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.PHP_EOL;
    $yml .= '<yml_catalog date="'.date('Y-m-d H:s').'">'.PHP_EOL;
    $yml .= '<shop>'.PHP_EOL;
    $yml .= '<name>Юг-Авто</name>'.PHP_EOL;
    $yml .= '<company>ООО "Юг-Авто"</company>'.PHP_EOL;
    $yml .= '<url>https://yug-avto.ru/</url>'.PHP_EOL;
    $yml .= '<currencies><currency rate="1" id="RUR"/></currencies>'.PHP_EOL;
    $yml .= '<categories>'.PHP_EOL;
    $yml .= '<category id="9999999997">Автомобили с пробегом Юг-Авто</category>'.PHP_EOL;

    $cats = []; $sets = ['auto'];
    foreach ( $vehicles as $v ) {
        if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], $krd) ) {
            if ( $v['brand']['code'] && $v['model']['code'] ) {
                if ( !in_array($v['brand']['code'], array_keys($cats)) ) {
                    $cats[$v['brand']['code']] = [
                        'name' => $v['brand']['name'],
                        'id' => $v['brand']['ext_id'],
                        'cats' => []
                    ];
                }
                if ( !in_array($v['model']['code'],  array_keys($cats[$v['brand']['code']]['cats'])) ) {
                    $cats[$v['brand']['code']]['cats'][$v['model']['code']] = [
                        'name' => $v['model']['name'],
                        'id' => $v['model']['ext_id'],
                    ];
                }
                if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
                if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
                if ( $v['body']['code'] == 'minivan' ) $sets[] = 'bigfamily';
                if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'offroad';
                if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
            }  
        }
    }
    foreach ( $cats as $b) {
        $yml .= '<category id="'.$b['id'].'" parentId="9999999997">'.$b['name'].'</category>'.PHP_EOL;
        foreach ( $b['cats'] as $m ) {
            $yml .= '<category id="'.$m['id'].'" parentId="'.$b['id'].'">'.$m['name'].'</category>'.PHP_EOL;
        }
    }

    $yml .= '</categories>'.PHP_EOL;
    $yml .= '<sets>'.PHP_EOL;
    $sets = array_unique($sets);
    foreach ( $sets as $set ) {
        if ( $set == 'premium' ) $yml .= '<set id="premium"><name>Премиум</name><url>https://yug-avto.ru/cars/used/?dealership=1502</url></set>'.PHP_EOL;
        if ( $set == 'business' ) $yml .= '<set id="business"><name>Для бизнеса</name><url>https://yug-avto.ru/cars/used/?dealership=1489</url></set>'.PHP_EOL;
        if ( $set == 'bigfamily' ) $yml .= '<set id="bigfamily"><name>Для больших семей</name><url>https://yug-avto.ru/cars/used/?body=minivan</url></set>'.PHP_EOL;
        if ( $set == 'offroad' ) $yml .= '<set id="offroad"><name>Покорители бездорожья</name><url>https://yug-avto.ru/cars/used/?body=suv&amp;drive=full</url></set>'.PHP_EOL;
        if ( $set == 'city' ) $yml .= '<set id="city"><name>Для города</name><url>https://yug-avto.ru/cars/used/?body=sedan,hatchback,liftback</url></set>'.PHP_EOL;
        if ( $set == 'auto' ) $yml .= '<set id="auto"><name>Автомобили с пробегом в Краснодаре</name><url>https://yug-avto.ru/cars/used/krasnodar/</url></set>'.PHP_EOL;
    }
    $yml .= '</sets>'.PHP_EOL;
    $yml .= '<offers>'.PHP_EOL;

    foreach ( $vehicles as $v ) {

        if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], $krd) ) {

            $yml .= '<offer id="'.$v['id'].'" available="true">'.PHP_EOL;
            $yml .= '<url>https://yug-avto.ru/cars/used/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>'.PHP_EOL;
            $yml .= '<picture>'.$v['images'][0]['preview'].'</picture>'.PHP_EOL;
            if ( $v['images'][1]['preview'] && $v['images'][1]['preview'] != $v['images'][0]['preview'] ) $yml .= '<picture>'.$v['images'][1]['preview'].'</picture>'.PHP_EOL;
            if ( $v['images'][2]['preview'] && $v['images'][2]['preview'] != $v['images'][0]['preview'] ) $yml .= '<picture>'.$v['images'][2]['preview'].'</picture>'.PHP_EOL;
            $yml .= '<name>'.$v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?str_replace('&', '-', $v['equipment']):'').' '.(($v['_general'][2])?:'').'</name>'.PHP_EOL;
            $yml .= '<price>'.$v['min_price'].'</price>'.PHP_EOL;
            $yml .= '<vendor>'.$v['brand']['name'].'</vendor>'.PHP_EOL;
            $yml .= '<categoryId>'.$v['model']['ext_id'].'</categoryId>'.PHP_EOL;
            $yml .= '<currencyId>RUR</currencyId>'.PHP_EOL;
    
            $sets = [];
            if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
            if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
            if ( $v['body']['code'] == 'minivan' ) $sets[] = 'bigfamily';
            if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'offroad';
            if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
            if ( empty($sets) ) $sets[] = 'auto';
            $yml .= '<set-ids>'.implode(', ', $sets).'</set-ids>'.PHP_EOL;
    
            $yml .= '<param name="Конверсия">'.(mt_rand(1000001,9999999)/1000000).'</param>';
    
            if ($v['_general'][3]) $yml .= '<param name="Двигатель">'.$v['_general'][3].'</param>'.PHP_EOL;
            if ($v['_general'][4]) $yml .= '<param name="Трансмиссия">'.$v['_general'][4].'</param>'.PHP_EOL;
            if ($v['_general'][5]) $yml .= '<param name="Привод">'.$v['_general'][5].'</param>'.PHP_EOL;
            if ($v['color']['code']!='none') $yml .= '<param name="Цвет">'.$v['color']['name'].'</param>'.PHP_EOL;
            if ($v['body']['code']!='none') $yml .= '<param name="Кузов">'.$v['body']['name'].'</param>'.PHP_EOL;
            if ($v['_general'][0]) $yml .= '<param name="Год выпуска">'.$v['_general'][0].'</param>'.PHP_EOL;
            if ($v['general'][5]['value']) $yml .= '<param name="Пробег">'.$v['general'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][0]['value']) $yml .= '<param name="Макс. скорость">'.$v['specifications'][0]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][5]['value']) $yml .= '<param name="Объем бака">'.$v['specifications'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][6]['value']) $yml .= '<param name="Объем багажника">'.$v['specifications'][6]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][7]['value']) $yml .= '<param name="Масса">'.$v['specifications'][7]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][8]['value']) $yml .= '<param name="Длина">'.$v['specifications'][8]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][9]['value']) $yml .= '<param name="Ширина">'.$v['specifications'][9]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][10]['value']) $yml .= '<param name="Высота">'.$v['specifications'][10]['value'].'</param>'.PHP_EOL;
            $yml .= '<delivery>false</delivery>'.PHP_EOL;
            $yml .= '</offer>'.PHP_EOL;
        }
    }

    // yml
    $yml .= '</offers>'.PHP_EOL;
    $yml .= '</shop>'.PHP_EOL;
    $yml .= '</yml_catalog>';
    file_put_contents($dd.'/vehicles-used-krd.xml', $yml);



    $yml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.PHP_EOL;
    $yml .= '<yml_catalog date="'.date('Y-m-d H:s').'">'.PHP_EOL;
    $yml .= '<shop>'.PHP_EOL;
    $yml .= '<name>Юг-Авто</name>'.PHP_EOL;
    $yml .= '<company>ООО "Юг-Авто"</company>'.PHP_EOL;
    $yml .= '<url>https://yug-avto.ru/</url>'.PHP_EOL;
    $yml .= '<currencies><currency rate="1" id="RUR"/></currencies>'.PHP_EOL;
    $yml .= '<categories>'.PHP_EOL;
    $yml .= '<category id="9999999997">Автомобили с пробегом Юг-Авто</category>'.PHP_EOL;

    $cats = []; $sets = ['auto'];
    foreach ( $vehicles as $v ) {
        if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], $nvr) ) {
            if ( $v['brand']['code'] && $v['model']['code'] ) {
                if ( !in_array($v['brand']['code'], array_keys($cats)) ) {
                    $cats[$v['brand']['code']] = [
                        'name' => $v['brand']['name'],
                        'id' => $v['brand']['ext_id'],
                        'cats' => []
                    ];
                }
                if ( !in_array($v['model']['code'],  array_keys($cats[$v['brand']['code']]['cats'])) ) {
                    $cats[$v['brand']['code']]['cats'][$v['model']['code']] = [
                        'name' => $v['model']['name'],
                        'id' => $v['model']['ext_id'],
                    ];
                }
                if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
                if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
                if ( $v['body']['code'] == 'minivan' ) $sets[] = 'bigfamily';
                if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'offroad';
                if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
            }
        }
    }
    foreach ( $cats as $b) {
        $yml .= '<category id="'.$b['id'].'" parentId="9999999997">'.$b['name'].'</category>'.PHP_EOL;
        foreach ( $b['cats'] as $m ) {
            $yml .= '<category id="'.$m['id'].'" parentId="'.$b['id'].'">'.$m['name'].'</category>'.PHP_EOL;
        }
    }

    $yml .= '</categories>'.PHP_EOL;
    $yml .= '<sets>'.PHP_EOL;
    $sets = array_unique($sets);
    sp($sets);
    foreach ( $sets as $set ) {
        if ( $set == 'premium' ) $yml .= '<set id="premium"><name>Премиум</name><url>https://yug-avto.ru/cars/used/?dealership=1502</url></set>'.PHP_EOL;
        if ( $set == 'business' ) $yml .= '<set id="business"><name>Для бизнеса</name><url>https://yug-avto.ru/cars/used/?dealership=1489</url></set>'.PHP_EOL;
        if ( $set == 'bigfamily' ) $yml .= '<set id="bigfamily"><name>Для больших семей</name><url>https://yug-avto.ru/cars/used/?body=minivan</url></set>'.PHP_EOL;
        if ( $set == 'offroad' ) $yml .= '<set id="offroad"><name>Покорители бездорожья</name><url>https://yug-avto.ru/cars/used/?body=suv&amp;drive=full</url></set>'.PHP_EOL;
        if ( $set == 'city' ) $yml .= '<set id="city"><name>Для города</name><url>https://yug-avto.ru/cars/used/?body=sedan,hatchback,liftback</url></set>'.PHP_EOL;
        if ( $set == 'auto' ) $yml .= '<set id="auto"><name>Автомобили с пробегом в Новороссийске</name><url>https://yug-avto.ru/cars/used/novorossiysk/</url></set>'.PHP_EOL;
    }
    $yml .= '</sets>'.PHP_EOL;
    $yml .= '<offers>'.PHP_EOL;

    foreach ( $vehicles as $v ) {

        if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], $nvr) ) {

            $yml .= '<offer id="'.$v['id'].'" available="true">'.PHP_EOL;
            $yml .= '<url>https://yug-avto.ru/cars/used/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>'.PHP_EOL;
            $yml .= '<picture>'.$v['images'][0]['preview'].'</picture>'.PHP_EOL;
            if ( $v['images'][1]['preview'] && $v['images'][1]['preview'] != $v['images'][0]['preview'] ) $yml .= '<picture>'.$v['images'][1]['preview'].'</picture>'.PHP_EOL;
            if ( $v['images'][2]['preview'] && $v['images'][2]['preview'] != $v['images'][0]['preview'] ) $yml .= '<picture>'.$v['images'][2]['preview'].'</picture>'.PHP_EOL;
            $yml .= '<name>'.$v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?str_replace('&', '-', $v['equipment']):'').' '.(($v['_general'][2])?:'').'</name>'.PHP_EOL;
            $yml .= '<price>'.$v['min_price'].'</price>'.PHP_EOL;
            $yml .= '<vendor>'.$v['brand']['name'].'</vendor>'.PHP_EOL;
            $yml .= '<categoryId>'.$v['model']['ext_id'].'</categoryId>'.PHP_EOL;
            $yml .= '<currencyId>RUR</currencyId>'.PHP_EOL;
    
            $sets = [];
            if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
            if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
            if ( $v['body']['code'] == 'minivan' ) $sets[] = 'bigfamily';
            if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'offroad';
            if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
            if ( empty($sets) ) $sets[] = 'auto';
            $yml .= '<set-ids>'.implode(', ', $sets).'</set-ids>'.PHP_EOL;
    
            $yml .= '<param name="Конверсия">'.(mt_rand(1000001,9999999)/1000000).'</param>';
    
            if ($v['_general'][3]) $yml .= '<param name="Двигатель">'.$v['_general'][3].'</param>'.PHP_EOL;
            if ($v['_general'][4]) $yml .= '<param name="Трансмиссия">'.$v['_general'][4].'</param>'.PHP_EOL;
            if ($v['_general'][5]) $yml .= '<param name="Привод">'.$v['_general'][5].'</param>'.PHP_EOL;
            if ($v['color']['code']!='none') $yml .= '<param name="Цвет">'.$v['color']['name'].'</param>'.PHP_EOL;
            if ($v['body']['code']!='none') $yml .= '<param name="Кузов">'.$v['body']['name'].'</param>'.PHP_EOL;
            if ($v['_general'][0]) $yml .= '<param name="Год выпуска">'.$v['_general'][0].'</param>'.PHP_EOL;
            if ($v['general'][5]['value']) $yml .= '<param name="Пробег">'.$v['general'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][0]['value']) $yml .= '<param name="Макс. скорость">'.$v['specifications'][0]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][5]['value']) $yml .= '<param name="Объем бака">'.$v['specifications'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][6]['value']) $yml .= '<param name="Объем багажника">'.$v['specifications'][6]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][7]['value']) $yml .= '<param name="Масса">'.$v['specifications'][7]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][8]['value']) $yml .= '<param name="Длина">'.$v['specifications'][8]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][9]['value']) $yml .= '<param name="Ширина">'.$v['specifications'][9]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][10]['value']) $yml .= '<param name="Высота">'.$v['specifications'][10]['value'].'</param>'.PHP_EOL;
            $yml .= '<delivery>false</delivery>'.PHP_EOL;
            $yml .= '</offer>'.PHP_EOL;
        }
    }

    // yml
    $yml .= '</offers>'.PHP_EOL;
    $yml .= '</shop>'.PHP_EOL;
    $yml .= '</yml_catalog>';
    file_put_contents($dd.'/vehicles-used-nvr.xml', $yml);
}
*/