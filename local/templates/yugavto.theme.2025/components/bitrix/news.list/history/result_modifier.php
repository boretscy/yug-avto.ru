<?php
$res = [];
foreach ( $arResult['ITEMS'] as $arItem ) {
    
    if ( !array_key_exists((int)$arItem['IBLOCK_SECTION_ID'], $res) ) $res[(int)$arItem['IBLOCK_SECTION_ID']]['NAME'] = CIBlockSection::GetByID($arItem['IBLOCK_SECTION_ID'])->GetNext()['NAME'];
    if ( $arItem['PROPERTIES']['LINKS']['VALUE'] ) {

        $arItem['SITES'] = $arItem['PROPERTIES']['LINKS']['VALUE'];

    } else {

        foreach ( $arItem['PROPERTIES']['BRAND']['VALUE'] as $brand_id ) {
            $rs = CIBlockElement::GetProperty(YApp::IBLOCK_BRANDS, $brand_id, [], ['CODE'=>'LINK']);
            while ( $ob = $rs->GetNext() ) $arItem['SITES'][] = $ob['VALUE'];
        }
    }

    if ( $arItem['PROPERTIES']['PHONE']['VALUE'] ) {

        $arItem['PHONE'] = $arItem['PROPERTIES']['PHONE']['VALUE'];

    } else {

        foreach ( $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $k => $dealership ) {
            $rs = CIBlockElement::GetProperty(YApp::IBLOCK_DEALERSHIPS, $dealership['ID'], [], ['CODE'=>'PHONE']);
            while ( $ob = $rs->GetNext() ) $arItem['PHONE'] = $ob['VALUE'];
        }
    }
    
    foreach ( $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $k => $dealership ) {

        $rs = CIBlockElement::GetProperty(YApp::IBLOCK_DEALERSHIPS, $dealership['ID'], [], ['CODE'=>'COORDS_LAT']);
        while ( $ob = $rs->GetNext() ) $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$k]['COORDS']['LAT'] = $ob['VALUE'];

        $rs = CIBlockElement::GetProperty(YApp::IBLOCK_DEALERSHIPS, $dealership['ID'], [], ['CODE'=>'COORDS_LON']);
        while ( $ob = $rs->GetNext() ) $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$k]['COORDS']['LON'] = $ob['VALUE'];
    }
    $res[(int)$arItem['IBLOCK_SECTION_ID']]['ITEMS'][] = $arItem;
}
krsort($res);
$arResult['ITEMS'] = array_values($res);

// YApp::sp($arResult['ITEMS'][0]['ITEMS'][1], true);

?>