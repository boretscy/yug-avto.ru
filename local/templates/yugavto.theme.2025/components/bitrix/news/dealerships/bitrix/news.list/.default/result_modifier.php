<?php
if ( (!$_GET['mode'] && !$_COOKIE['MODE']) || (!$_GET['mode'] && $_COOKIE['MODE'] == 'list') ) {

    setcookie('MODE', 'list', 0, '/');
    $arResult['MODE'] = 'list';

} elseif ( !$_GET['mode'] && $_COOKIE['MODE'] == 'map' ) {

    setcookie('MODE', 'map', 0, '/');
    $arResult['MODE'] = 'map';

} elseif ( $_GET['mode'] == 'list' ) {
    
    setcookie('MODE', 'list', 0, '/');
    $arResult['MODE'] = 'list';

} elseif ( $_GET['mode'] == 'map' ) {

    setcookie('MODE', 'map', 0, '/');
    $arResult['MODE'] = 'map';
}

$brands = [];
foreach ( $arResult['ITEMS'] as $k => $arItem ) {

    $arLinks = [];
    $rs = CIBlockElement::GetProperty(
        YApp::IBLOCK_BRANDS,
        $arItem['PROPERTIES']['BRAND']['VALUE'],
        [],
        ['CODE'=>'LINK']
    );
    while ( $ob = $rs->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

    $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['LINK'] = $arLinks[0]['LINK'];
    foreach ( $arLinks as $arLink ) if ( $arLink['CITY'] == $arItem['PROPERTIES']['CITY']['VALUE'] )  $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['LINK'] = $arLink['LINK'];

    $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['PICTURE'] = CFile::GetPath( $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['PREVIEW_PICTURE'] );
    $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['TITLE'] = $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['NAME'];

    if ($arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE'] == 'expert' || $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE'] == 'expert-premium') {
        $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['CIS_LINK'] = '/cars/used/?dealership='.$arItem['CODE'];
    } elseif ($arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE'] == 'volkswagen-c') { 
        $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['CIS_LINK'] = '/cars/'.(($arItem['PROPERTIES']['IS_NEW']['VALUE']=='Да')?'new':'used').'/?dealership=1343';
    } else {
        $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['CIS_LINK'] = '/cars/'.(($arItem['PROPERTIES']['IS_NEW']['VALUE']=='Да')?'new':'used');
        if ( $arItem['CODE'] ) {
            $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['CIS_LINK'] .= '/?dealership='.$arItem['CODE'];
        } else {
            $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['CIS_LINK'] .= '/'.str_replace('_','-',$arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE']);
        }
    }

    if ( !array_key_exists($arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE'], $brands) ) {
        
        $brands[$arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE']] = [
            'CODE' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE'],
            'NAME' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['NAME']
        ];
    }
        

    $rs = CIBlockElement::GetList(
        ['IBLOCK_SECTION_ID' => 'DESC'],
        [
            'IBLOCK_ID' => YApp::IBLOCK_HISTORY,
            'ACTIVE' => 'Y',
            'PROPERTY_DEALERSHIP' => $arItem['ID']
        ],
        false, ['nTopCount' => 4],
        ['ID', 'IBLOCK_ID', 'NAME', 'SECTION_ID']
    );
    while ( $ob = $rs->GetNextElement() ) {
        
        $tmp = $ob->GetFields();
        $tmp['SECTION'] = CIBlockSection::GetByID($tmp['IBLOCK_SECTION_ID'])->GetNext()['NAME'];
        // $s = CIBlockPropertyEnum::GetList(
        //     ['sort'=>'asc'],
        //     [
        //         'IBLOCK_ID' => YApp::IBLOCK_HISTORY,
        //         'CODE' => 'ICON'
        //     ]
        // );
        // while ( $os = $s->Fetch() ) $tmp['ICON'][] = $os['XML_ID'];
        $tmp['ICON'] = CIBlockElement::GetProperty(YApp::IBLOCK_HISTORY, $tmp['ID'], ['sort'=>'asc'], ['CODE' => 'ICON'])->Fetch();
        $arResult['ITEMS'][$k]['HISTORY'][] = $tmp;
    }
}
foreach ( $arResult['ITEMS'] as $arItem ) $brands[$arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE']]['RELATION'][] = $arItem['PROPERTIES']['CITY']['VALUE_XML_ID'];

// get CITIES for FILTER
$arResult['FILTER']['city']['selected'] = 0;
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'CODE' => 'CITY'
    ]
);
while ( $ob = $rs->Fetch() ) {

    $arResult['FILTER']['city']['items'][] = [
        'code' => $ob['VALUE'], 
        'name' => $ob['VALUE'], 
        'selected' => ( in_array($ob['VALUE'], explode(',', str_replace('`', '', $_GET['city']))) ) ? true : false
    ];
    if ( in_array($ob['VALUE'], explode(',', str_replace('`', '', $_GET['city']))) ) $arResult['FILTER']['city']['selected']++;

}
if ( $arResult['FILTER']['city']['selected'] != 1 ) {
    $arResult['FILTER']['city']['title'] = 'Город';
    if ( $arResult['FILTER']['city']['selected'] > 1 ) $arResult['FILTER']['city']['title'] .= ': '.$arResult['FILTER']['city']['selected'].' выбрано';
} else {
    foreach ( $arResult['FILTER']['city']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['city']['title'] = $item['name'];
}
unset(
    $arResult['FILTER']['city']['items'][4],
    $arResult['FILTER']['city']['items'][5],
    $arResult['FILTER']['city']['items'][6]
);
sort( $arResult['FILTER']['city']['items']);

// get TAGS for FILTER
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
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
// unset($arResult['FILTER']['tag']['items'][2]);

// get BRANDS for FILTER
$arResult['FILTER']['brand']['selected'] = 0;
foreach ( $brands as $item ) {

    $arResult['FILTER']['brand']['items'][] = [
        'code' => $item['CODE'], 
        'name' => $item['NAME'],
        'relation' => array_unique($item['RELATION']),
        'selected' => ( in_array($item['CODE'], explode(',', str_replace('`', '', $_GET['brand']))) ) ? true : false
    ];
    if ( in_array($item['CODE'], explode(',', str_replace('`', '', $_GET['brand']))) ) $arResult['FILTER']['brand']['selected']++;
}
if ( $arResult['FILTER']['brand']['selected'] != 1 ) {
    $arResult['FILTER']['brand']['title'] = 'Марка';
    if ( $arResult['FILTER']['brand']['selected'] > 1 ) $arResult['FILTER']['brand']['title'] .= ': '.$arResult['FILTER']['brand']['selected'].' выбрано';
} else {
    foreach ( $arResult['FILTER']['brand']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['brand']['title'] = $item['name'];
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

// get MODES for FILTER
$arResult['FILTER']['mode']['items'][] = [
    'code' => 'map', 
    'name' => 'На карте',
    'selected' => (  $arResult['MODE'] == 'map') ? true : false
];
$arResult['FILTER']['mode']['items'][] = [
    'code' => 'list', 
    'name' => 'Списком',
    'selected' => (  $arResult['MODE'] == 'list') ? true : false
];

$arResult['FILTER']['TAGS'] = false;
foreach ( $arResult['FILTER']['city']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['TAGS'] = true;
foreach ( $arResult['FILTER']['brand']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['TAGS'] = true;
foreach ( $arResult['FILTER']['tag']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['TAGS'] = true;

// YApp::sp($arResult['MODE']);
?>