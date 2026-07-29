<?php

$rs = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => YApp::IBLOCK_FORMS,
        'CODE' => $arResult['WEB_FORM_NAME']
    ],
    false, false,
    ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_TEXT', 'PROPERTY_TITLE']
);
while ( $ob = $rs->GetNextElement() ) $arResult['SETTINGS'] = $ob->GetFields();

if ( array_key_exists('DEALERSHIP', $arResult['arQuestions']) ) {
    
    $dsFilter = [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'ACTIVE' => 'Y',
        'PROPERTY_INCOGNITO_VALUE' => false,
        '!ID' => 917
    ];
    if ( $_GET['dealership'] ) $dsFilter['CODE'] = $_GET['dealership']; 
    $rs = CIBlockElement::GetList(
        [],
        $dsFilter,
        false, false,
        ['ID', 'NAME', 'CODE']
    );
    while ( $ob = $rs->GetNextElement() ) {
        $tmp = $ob->GetFields();
        $arResult['DEALERSHIPS'][] = [
            'code' => $tmp['CODE'],
            'name' => $tmp['NAME']
        ];
    }
    if ( $arResult['DEALERSHIPS'] ) array_multisort(array_column($arResult['DEALERSHIPS'], 'name'), SORT_ASC, SORT_STRING, $arResult['DEALERSHIPS']);
}
?>