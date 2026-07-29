<?php 
foreach ( $arResult['ITEMS'] as $arItem ) {
    if ( $arItem['PROPERTIES']['CITY']['VALUE_XML_ID'] ) {
        $arResult['FILTER']['dropLists']['cities'][$arItem['PROPERTIES']['CITY']['VALUE_XML_ID']] = [
            'code' => $arItem['PROPERTIES']['CITY']['VALUE_XML_ID'],
            'name' => $arItem['PROPERTIES']['CITY']['VALUE']
        ];
    }
    $arResult['FILTER']['dropLists']['brands'][$arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['BRAND']['VALUE']]['CODE']] = [
        'code' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['BRAND']['VALUE']]['CODE'],
        'name' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['BRAND']['VALUE']]['NAME']
    ];
    $arResult['FILTER']['dropLists']['dealerships'][$arItem['CODE']] = [
        'code' => $arItem['CODE'],
        'name' => $arItem['NAME'],
        'brand' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['BRAND']['VALUE']]['CODE'],
        'city' => $arItem['PROPERTIES']['CITY']['VALUE_XML_ID']
    ];
}
array_multisort(array_column($arResult['FILTER']['dropLists']['cities'], 'name'), SORT_ASC, SORT_STRING, $arResult['FILTER']['dropLists']['cities']);

$compareFunc = function($a, $b) {
    $nameA = $a['name'] ?? '';
    $nameB = $b['name'] ?? '';
    $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
    $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
    if ($isRusA && !$isRusB) return -1;
    if (!$isRusA && $isRusB) return 1;
    return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
};
if ( !empty($arResult['FILTER']['dropLists']['brands']) ) {
    usort($arResult['FILTER']['dropLists']['brands'], $compareFunc);
}
if ( !empty($arResult['FILTER']['dropLists']['dealerships']) ) {
    usort($arResult['FILTER']['dropLists']['dealerships'], $compareFunc);
}

array_multisort(array_column($arResult['ITEMS'], 'NAME'), SORT_ASC, SORT_STRING, $arResult['ITEMS']);

$arResult['TABS'] = [
    'ALL' => count($arResult['ITEMS']),
    'NEW' => 0,
    'USED' => 0,
    'SERVICE' => 0,
    'BUYOUT' => 0,
    'EXIT_BUYOUT' => 0,
    'SALE' => 0,
];
foreach ( $arResult['ITEMS'] as $arItem ) {

    if ( $arItem['PROPERTIES']['IS_NEW']['VALUE_XML_ID'] == 'ON' ) {
        $arResult['TABS']['NEW']++;
        $arResult['TABS']['SALE']++;
    }
    if ( is_array($arItem['PROPERTIES']['TAG']['VALUE']) && in_array('Автосалон', $arItem['PROPERTIES']['TAG']['VALUE']) && $arItem['PROPERTIES']['IS_NEW']['VALUE_XML_ID'] != 'ON'  ) {
        $arResult['TABS']['USED']++;
        $arResult['TABS']['SALE']++;
    }
    if ( is_array($arItem['PROPERTIES']['TAG']['VALUE']) && in_array('Сервис', $arItem['PROPERTIES']['TAG']['VALUE'])  ) $arResult['TABS']['SERVICE']++;
    if ( is_array($arItem['PROPERTIES']['TAG']['VALUE']) && in_array('Выкуп', $arItem['PROPERTIES']['TAG']['VALUE'])  ) $arResult['TABS']['BUYOUT']++;
    if ( is_array($arItem['PROPERTIES']['TAG']['VALUE']) && in_array('Выездной выкуп', $arItem['PROPERTIES']['TAG']['VALUE'])  ) $arResult['TABS']['EXIT_BUYOUT']++;

    $tmp = [
        'NAME' => $arItem['NAME'],
        'CODE' => $arItem['CODE'],
        'COORDS' => [
            'LAT' => (float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'],
            'LON' => (float)$arItem['PROPERTIES']['COORDS_LON']['VALUE']
        ],
        'BALLOON' => [
            'TITLE' => $arItem['NAME'],
            'CONTENT' => '<p>Адрес: '.$arItem['PROPERTIES']['ADDRESS']['VALUE'].'</p><ul><li>'.((is_countable($arItem['PROPERTIES']['SERVICES']['VALUE']))?implode('</li><li>', $arItem['PROPERTIES']['SERVICES']['VALUE']):$arItem['PROPERTIES']['SERVICES']['VALUE']).'</li></ul>',
            'FOOTER' => '<a href="https://yandex.ru/maps/?ll='.$arItem['PROPERTIES']['COORDS_LON']['VALUE'].','.$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].'&z=15&mode=routes&rtext=~'.$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].','.$arItem['PROPERTIES']['COORDS_LON']['VALUE'].'&rtt=auto&ruri=~" target="_blank" alt="'.$arResult['NAME'].'" class="d-block mb-3">Построить маршрут</a>'
        ],
    ];
    foreach ( $arItem['DISPLAY_PROPERTIES']['TAG']['VALUE_XML_ID'] as $k => $i ) {
        $tmp['TAGS'][] = [
            'code' => $i,
            'name' => $arItem['DISPLAY_PROPERTIES']['TAG']['VALUE'][$k]
        ];
    }
    if ( $arItem['PROPERTIES']['IS_NEW']['VALUE_XML_ID'] == 'ON' ) {
        $tmp['TAGS'][] = [
            'code' => 'new',
            'name' => 'Новые'
        ];
    }
    if ( $arItem['PROPERTIES']['IS_NEW']['VALUE_XML_ID'] == 'NO' ) {
        $tmp['TAGS'][] = [
            'code' => 'used',
            'name' => 'С пробегом'
        ];
    }
    $tmp['TAGS'][] = [
        'code' => 'all',
        'name' => 'Все'
    ];
    $tmp['CITY'][] = [
        'code' => $arItem['DISPLAY_PROPERTIES']['CITY']['VALUE_XML_ID'],
        'name' => $arItem['DISPLAY_PROPERTIES']['CITY']['VALUE'],
    ];
    $tmp['BRAND'][] = [
        'code' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['BRAND']['VALUE']]['CODE'],
        'name' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['DISPLAY_PROPERTIES']['BRAND']['VALUE']]['NAME']
    ];
    $tmp['DEALERSHIP'][] = [
        'code' => $arItem['CODE'],
        'name' => $arItem['NAME']
    ];

    $tmp['VIEW']['ID'] = $arItem['ID'];
    $tmp['VIEW']['NAME'] = $arItem['NAME'];
    $tmp['VIEW']['CODE'] = $arItem['CODE'];
    $tmp['VIEW']['PICTURE'] = $arItem['PREVIEW_PICTURE']['SRC'];
    $tmp['VIEW']['ADDRESS'] = $arItem['PROPERTIES']['ADDRESS']['VALUE'];
    $tmp['VIEW']['WORK'] = $arItem['PROPERTIES']['WORK']['VALUE'][0];
    $tmp['VIEW']['PHONE'] = $arItem['PROPERTIES']['PHONE']['VALUE'];
    $tmp['VIEW']['BRAND'] = CFile::GetPath($arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['PREVIEW_PICTURE']);
    $tmp['VIEW']['ENTITY'] = ( $arItem['PROPERTIES']['IS_NEW']['VALUE_XML_ID'] == 'ON' ) ? 'new' : 'used';
    $tmp['VIEW']['EXTERNAL_CODE'] = $arItem['PROPERTIES']['EXTERNAL_CODE']['VALUE'];
    $tmp['VIEW']['YANDEX_ID'] = $arItem['PROPERTIES']['YANDEX_ID']['VALUE'];

    $arLinks = [];
    $rs = CIBlockElement::GetProperty(
        YApp::IBLOCK_BRANDS,
        $arItem['PROPERTIES']['BRAND']['VALUE'],
        [],
        ['CODE'=>'LINK']
    );
    while ( $ob = $rs->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

    if ( is_countable($arLinks) && count($arLinks) == 1 ) $tmp['VIEW']['SITE'] = $arLinks[0];
    if ( is_countable($arLinks) && count($arLinks) > 1 ) foreach ( $arLinks as $arLink ) if ( $arLink['CITY'] == $arItem['PROPERTIES']['CITY']['VALUE'] ) $tmp['VIEW']['SITE'] = $arLink;

    $tmp['VIEW']['BUTTONS']['CIS'] = ( in_array('showroom', (array)$arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) ? 1 : 0;
    $tmp['VIEW']['BUTTONS']['SERVICE'] = ( in_array('service', (array)$arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) ? 1 : 0;
    $tmp['VIEW']['BUTTONS']['MAP'] = 'https://yandex.ru/maps/?ll='.$arItem['PROPERTIES']['COORDS_LON']['VALUE'].','.$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].'&z=15&mode=routes&rtext=~'.$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].','.$arItem['PROPERTIES']['COORDS_LON']['VALUE'].'&rtt=auto&ruri=~';

    $arResult['MAP']['ITEMS'][] = $arResult['MAP']['VIEW'][] = $tmp;
    
}
$arResult['COOKIE_CITIES'] = explode(',', YApp::setCityCookie());

?>
