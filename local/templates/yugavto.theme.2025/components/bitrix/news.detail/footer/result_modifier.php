<?php

$rs = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => YApp::IBLOCK_SEO,
        'PROPERTY_PATH' => Yapp::getSEOPath($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])
    ],
    false, false,
    ['ID', 'DETAIL_TEXT']
);
while ( $ob = $rs->GetNextElement() ) $arResult['SEO_TEXT'] = $ob->GetFields()['DETAIL_TEXT'];
if ( !$arResult['SEO_TEXT'] && $GLOBALS['META']['meta']['seo_text'] )  $arResult['SEO_TEXT'] = '<h2 class="fw-normal">'.$GLOBALS['META']['meta']['seo_title'].'</h2><p>'.$GLOBALS['META']['meta']['seo_text'].'</p>';

if ( !empty($arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE']) ) {
    usort($arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE'], function($a, $b) {
        $nameA = $a['NAME'] ?? '';
        $nameB = $b['NAME'] ?? '';
        $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
        $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
        if ($isRusA && !$isRusB) return -1;
        if (!$isRusA && $isRusB) return 1;
        return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
    });
}

// YApp::sp( $arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE'], true );
?>