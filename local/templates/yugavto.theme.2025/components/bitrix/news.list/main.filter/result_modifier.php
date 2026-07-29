<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$cache = \Bitrix\Main\Data\Cache::createInstance();
$cacheTime = 300; // 5 минут
$cacheId = 'main_filter_api_data';
$cacheDir = '/main_filter_api';

if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
    $vars = $cache->getVars();
    $arResult['FILTER'] = $vars['FILTER'];
    $arResult['COUNTS'] = $vars['COUNTS'];
} else {
    $goApi = 'https://'.YApp::GO_API_DOMAIN.'/api/v1/cis/filter?token=ef6541490c8bb9d481d37020b6a1953e';

    $filterResp = YApp::httpGet($goApi.'&type=new');
    $filterData = $filterResp ? json_decode($filterResp, true) : [];
    if (!is_array($filterData)) $filterData = [];

    $usedResp = YApp::httpGet($goApi.'&type=used');
    $usedFilter = $usedResp ? json_decode($usedResp, true) : [];
    if (!is_array($usedFilter)) $usedFilter = [];

    $arResult['FILTER'] = $filterData;
    $arResult['COUNTS'] = [
        'NEW' => $filterData['totalCount'] ?? 0,
        'USED' => $usedFilter['totalCount'] ?? 0
    ];

    if (!empty($arResult['FILTER'])) {
        $cache->startDataCache();
        $cache->endDataCache([
            'FILTER' => $arResult['FILTER'],
            'COUNTS' => $arResult['COUNTS']
        ]);
    }
}

$arResult['BRANDS'] = $arResult['FILTER']['dropLists']['brands'] ?? [];
if ( $arResult['FILTER'] && isset($arResult['FILTER']['dropLists']['brands']) ) {
    usort($arResult['FILTER']['dropLists']['brands'], function($a, $b) {
        $nameA = $a['name'] ?? '';
        $nameB = $b['name'] ?? '';
        $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
        $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
        if ($isRusA && !$isRusB) return -1;
        if (!$isRusA && $isRusB) return 1;
        return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
    });
}
if ( $arResult['BRANDS'] ) array_multisort(array_column($arResult['BRANDS'], 'vehicles'), SORT_DESC, SORT_NUMERIC, $arResult['BRANDS']);


$rs = CIBlockElement::GetList(
    ['SORT'=>'ASC'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
        'ACTIVE' => 'Y',
        'ACTIVE_DATE' => 'Y',
        '!PROPERTY_IS_STORIES' => false
    ],
    false, false,
    [
        'ID', 
        'NAME', 
        'CODE',
        'ACTIVE_FROM', 
        'PROPERTY_STORIES_MOBILE_PREVIEW_PICTURE', 
        'PROPERTY_STORIES_MOBILE_DETAIL_PICTURE', 
        'PROPERTY_STORIES_DESKTOP_DETAIL_PICTURE', 
        'PROPERTY_STORIES_LINK', 
        'PROPERTY_STORIES_COUNT_LIKE', 
        'PROPERTY_STORIES_COUNT_DISLIKE', 
        'PROPERTY_STORIES_COUNT_HEART', 
        'PROPERTY_STORIES_COUNT_FIRE']
);
while ( $ob = $rs->GetNextElement() ) {
    $arResult['STORIES'][] = $ob->GetFields();
}
    // YApp::sp($arResult['STORIES'][0]);
?>