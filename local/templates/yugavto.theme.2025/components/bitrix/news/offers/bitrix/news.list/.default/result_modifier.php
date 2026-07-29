<?php
// 404
if ( empty($arResult['ITEMS']) ) {

    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
}


// get TAGS for FILTER
$arResult['FILTER']['tag']['title'] = 'Теги';
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
        'CODE' => 'TAG'
    ]
);
while ( $ob = $rs->Fetch() ) {

    $arResult['FILTER']['tag']['items'][] = [
        'code' => $ob['XML_ID'], 
        'name' => $ob['VALUE'], 
        'selected' => ( in_array($ob['XML_ID'], explode(',', $_GET['tag'])) ) ? true : false
    ];
}

// get BRANDS for FILTER
$arResult['FILTER']['brand']['selected'] = 0;
$rs = CIBlockElement::GetList(
    ['name'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
        'ACTIVE' => 'Y'
    ],
    false, false,
    ['ID', 'NAME', 'CODE', 'PREVIEW_PICTURE']  
);
while ( $ob = $rs->GetNextElement() ) {

    $tmp = $ob->GetFields();
    if ( $tmp['CODE'] != 'greatwall') {
        
        $arResult['FILTER']['brand']['items'][]  = [
            'id' => $tmp['ID'],
            'code' => $tmp['CODE'], 
            'name' => $tmp['NAME'],
            'selected' => ( in_array($tmp['CODE'], explode(',', str_replace('`', '', $_GET['brand']))) ) ? true : false
        ];
        if ( in_array($tmp['CODE'], explode(',', str_replace('`', '', $_GET['brand']))) ) $arResult['FILTER']['brand']['selected']++;
    }
}
if ( $arResult['FILTER']['brand']['selected'] != 1 ) {
    $arResult['FILTER']['brand']['title'] = 'Марка';
    if ( $arResult['FILTER']['brand']['selected'] > 1 ) $arResult['FILTER']['brand']['title'] .= ': '.$arResult['FILTER']['brand']['selected'].' выбрано';
} else {
    foreach ( $arResult['FILTER']['brand']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['brand']['title'] = $item['name'];
}

// get DEALERSHIPS for FILTER
$arResult['FILTER']['dealership']['selected'] = 0;
$rs = CIBlockElement::GetList(
    ['name'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'ACTIVE' => 'Y',
        '!PROPERTY_CITY_VALUE' => ['Сочи', 'Ставрополь', 'Ростов-на-Дону'],
        'ID' => CIBlockElement::SubQuery(
            'PROPERTY_DEALERSHIP',
            [
                'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
                'ACTIVE' => 'Y',
                '!PROPERTY_DEALERSHIP_VALUE' => false
            ]
        )
    ],
    false, false,
    ['ID', 'NAME', 'CODE', 'PROPERTY_BRAND', 'PROPERTY_EXTERNAL_CODE']  
);
$bcodes = [];
while ( $ob = $rs->GetNextElement() ) {

    $relation = '';
    $tmp = $ob->GetFields();
    foreach ( $brands as $item ) {
        if ( (string)$tmp['PROPERTY_BRAND_VALUE'] == $item['id'] && !in_array($item['code'], $bcodes) ) {
            $relation = $item['code'];
            $arResult['FILTER']['brand']['items'][] = $item;
            $bcodes[] = $item['code'];
        }
    }
    $arResult['FILTER']['dealership']['items'][] = [
        'code' => $tmp['CODE'], 
        'name' => $tmp['NAME'], 
        'relation' => $relation,
        'selected' => ( in_array($tmp['CODE'], explode(',', str_replace('`', '', $_GET['dealership']))) ) ? true : false
    ];
    if ( in_array($tmp['CODE'], explode(',', str_replace('`', '', $_GET['dealership']))) ) $arResult['FILTER']['dealership']['selected']++;
}
if ( $arResult['FILTER']['dealership']['selected'] != 1 ) {
    $arResult['FILTER']['dealership']['title'] = 'Автосалон';
    if ( $arResult['FILTER']['dealership']['selected'] > 1 ) $arResult['FILTER']['dealership']['title'] .= ': '.$arResult['FILTER']['dealership']['selected'].' выбрано';
} else {
    foreach ( $arResult['FILTER']['dealership']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['dealership']['title'] = $item['name'];
}

if (!empty($arResult['FILTER']['brand']['items'])) {
    usort($arResult['FILTER']['brand']['items'], function($a, $b) {
        $nameA = $a['name'] ?? '';
        $nameB = $b['name'] ?? '';
        $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
        $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
        if ($isRusA && !$isRusB) return -1;
        if (!$isRusA && $isRusB) return 1;
        return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
    });
}
?>