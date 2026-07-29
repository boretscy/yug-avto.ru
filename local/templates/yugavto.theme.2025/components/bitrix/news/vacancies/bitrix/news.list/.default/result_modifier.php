<?php
// 404
if ( empty($arResult['ITEMS']) ) {

    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
}

// $arResult['COUNT'] = CIBlockElement::GetList([],['IBLOCK_ID'=>YApp::IBLOCK_VACANCIES,'ACTIVE'=>'Y'],[],false,[]);

// get TAGS for FILTER
// $arResult['FILTER']['tag']['title'] = 'Теги';
// $rs = CIBlockPropertyEnum::GetList(
//     ['sort'=>'asc'],
//     [
//         'IBLOCK_ID' => YApp::IBLOCK_VACANCIES,
//         'CODE' => 'SCOPE'
//     ]
// );
// while ( $ob = $rs->Fetch() ) {

//     $arResult['FILTER']['tag']['items'][] = [
//         'code' => $ob['XML_ID'], 
//         'name' => $ob['VALUE'], 
//         'selected' => ( in_array($ob['XML_ID'], explode(',', str_replace('`', '', $_GET['tag']))) ) ? true : false
//     ];
// }

// get TAGS for FILTER
$arResult['FILTER']['tag']['title'] = 'Тип вакансии';
$arResult['FILTER']['tag']['selected'] = 0;
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_VACANCIES,
        'CODE' => 'SCOPE'
    ]
);
while ( $ob = $rs->Fetch() ) {

    $arResult['FILTER']['tag']['items'][] = [
        'code' => $ob['XML_ID'], 
        'name' => $ob['VALUE'], 
        'selected' => ( in_array($ob['XML_ID'], explode(',', str_replace('`', '', $_GET['tag']))) ) ? true : false
    ];
    if ( in_array($ob['XML_ID'], explode(',', str_replace('`', '', $_GET['tag']))) ) $arResult['FILTER']['tag']['selected']++;
}
if ( $arResult['FILTER']['tag']['selected'] != 1 ) {
    $arResult['FILTER']['tag']['title'] = 'Тип вакансии';
    if ( $arResult['FILTER']['tag']['selected'] > 1 ) $arResult['FILTER']['tag']['title'] .= ': '.$arResult['FILTER']['tag']['selected'].' выбрано';
} else {
    foreach ( $arResult['FILTER']['tag']['items'] as $item ) if ( $item['selected'] ) $arResult['FILTER']['tag']['title'] = $item['name'];
}

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
    $arResult['FILTER']['city']['items'][6],
    $arResult['FILTER']['city']['items'][4],
    // $arResult['FILTER']['city']['items'][6]
);
sort($arResult['FILTER']['city']['items']);

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
                'IBLOCK_ID' => YApp::IBLOCK_VACANCIES,
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


?>