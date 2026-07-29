<?php

$rs = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => YApp::IBLOCK_FORMS,
        'CODE' => $arResult['WEB_FORM_NAME']
    ],
    false, false,
    ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'PROPERTY_TITLE']
);
while ( $ob = $rs->GetNextElement() ) $arResult['SETTINGS'] = $ob->GetFields();

if ( array_key_exists('DEALERSHIP', $arResult['arQuestions']) ) {
    
    $arResult['DEALERSHIPS_SELECTED_COUNT'] = 0;
    $arResult['DEALERSHIPS_SELECTED'] = [];
    $arResult['DEALERSHIPS_TITLE'] = 'Дилерский центр'.(($arResult['arQuestions']['DEALERSHIP']['REQUIRED']=='Y')?' *':'');

    $dsFilter = [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'ACTIVE' => 'Y',
        'PROPERTY_INCOGNITO_VALUE' => false,
        '!ID' => 917
    ];
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
            'name' => $tmp['NAME'],
            'selected' => ( $_GET['dealership'] && in_array($tmp['CODE'], explode(',', $_GET['dealership'])) ) ? true : false
        ];
        if ( $_GET['dealership'] && in_array($tmp['CODE'], explode(',', $_GET['dealership'])) ) {
            $arResult['DEALERSHIPS_TITLE'] = $tmp['NAME'];
            $arResult['DEALERSHIPS_SELECTED'][] = $tmp['CODE'];
            $arResult['DEALERSHIPS_SELECTED_COUNT']++;
        }
    }
    if ( $arResult['DEALERSHIPS'] ) {
        usort($arResult['DEALERSHIPS'], function($a, $b) {
            $nameA = $a['name'] ?? '';
            $nameB = $b['name'] ?? '';
            $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
            $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
            if ($isRusA && !$isRusB) return -1;
            if (!$isRusA && $isRusB) return 1;
            return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
        });
        if ( $arResult['DEALERSHIPS_SELECTED_COUNT'] > 1 ) $arResult['DEALERSHIPS_TITLE'] = 'Дилерский центр: '.$arResult['DEALERSHIPS_SELECTED_COUNT'].' выбрано';
    }
}

// CIBlockElement::SubQuery('ID', ["IBLOCK_ID" => YApp::IBLOCK_DEALERSHIPS, "PROPERTY_PKE" => 7405])
?>