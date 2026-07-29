<?php
$res = [];
foreach ( $arResult['ITEMS'] as $arItem ) {

    if ( !array_key_exists($arItem['IBLOCK_SECTION_ID'], $res) ) $res[$arItem['IBLOCK_SECTION_ID']] = CIBlockSection::GetByID($arItem['IBLOCK_SECTION_ID'])->GetNext();
    $res[$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = $arItem;
}
$arResult['ITEMS'] = $res;

// array_multisort(array_column($arResult['ITEMS'], 'ID'), SORT_ASC, SORT_NUMERIC, $arResult['ITEMS']);
array_multisort(array_column($arResult['ITEMS'], 'NAME'), SORT_ASC, SORT_STRING, $arResult['ITEMS']);

// YApp::sp($res, true);

?>