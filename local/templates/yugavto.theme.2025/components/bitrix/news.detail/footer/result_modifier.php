<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;

if (Loader::includeModule('iblock')) {
    $seoPath = YApp::getSEOPath($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    $seoElement = ElementTable::getList([
        'select' => ['ID', 'DETAIL_TEXT'],
        'filter' => [
            '=IBLOCK_ID' => YApp::IBLOCK_SEO,
            '=PROPERTY_PATH.VALUE' => $seoPath
        ],
        'limit' => 1,
        'cache' => ['ttl' => 3600]
    ])->fetch();

    if ($seoElement && !empty($seoElement['DETAIL_TEXT'])) {
        $arResult['SEO_TEXT'] = $seoElement['DETAIL_TEXT'];
    }
}

if (empty($arResult['SEO_TEXT']) && !empty($GLOBALS['META']['meta']['seo_text'])) {
    $arResult['SEO_TEXT'] = '<h2 class="fw-normal">' . ($GLOBALS['META']['meta']['seo_title'] ?? '') . '</h2><p>' . $GLOBALS['META']['meta']['seo_text'] . '</p>';
}

if (!empty($arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE']) && is_array($arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE'])) {
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
?>