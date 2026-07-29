<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$cache = \Bitrix\Main\Data\Cache::createInstance();
$cacheTime = 300; // 5 минут
$cacheId = 'main_compilations_api_data';
$cacheDir = '/main_compilations_api';

if ($cache->initCache($cacheTime, $cacheId, $cacheDir)) {
    $vars = $cache->getVars();
    $arResult["FILTER"] = $vars["FILTER"];
    $arResult["VEHICLES"] = $vars["VEHICLES"];
    $arResult["VEHICLES_COUNT"] = $vars["VEHICLES_COUNT"];
    $arResult["ERRORS"] = $vars["ERRORS"];
} else {
    $goApiBase = defined("YApp::GO_API_DOMAIN")
        ? "https://" . YApp::GO_API_DOMAIN . "/api/v1/cis"
        : "https://apps.avatr-yugavto.ru/api/v1/cis";
    $token = "ef6541490c8bb9d481d37020b6a1953e";

    $filterResp = YApp::httpGet($goApiBase . "/filter?token=" . $token . "&type=new");
    $arResult["FILTER"] = $filterResp ? json_decode($filterResp, true) : [];
    if (!is_array($arResult["FILTER"])) $arResult["FILTER"] = [];

    $vehiclesResp = YApp::httpGet($goApiBase . "/random?token=" . $token . "&type=new&limit=12");
    $vehicles = $vehiclesResp ? json_decode($vehiclesResp, true) : [];
    $vehicles = is_array($vehicles) ? $vehicles : [];

    $items = $vehicles["items"] ?? [];
    if (is_array($items)) {
        foreach ($items as &$v) {
            if (!is_array($v)) continue;
            $v["equipment"] ??= "";
            $v["_general"] = $v["_general"] ?? $v["general"] ?? "";
            unset($v["general"]);
            $v["_tags"] = $v["_tags"] ?? $v["tags"] ?? [];
            unset($v["tags"]);
        }
        unset($v);
    }
    $arResult["VEHICLES"] = ["items" => $items];
    $arResult["VEHICLES_COUNT"] = $vehicles["totalCount"] ?? 0;
    $arResult["ERRORS"] = $vehicles["errors"] ?? [];

    if (!empty($arResult["FILTER"]) && !empty($items)) {
        $cache->startDataCache();
        $cache->endDataCache([
            "FILTER" => $arResult["FILTER"],
            "VEHICLES" => $arResult["VEHICLES"],
            "VEHICLES_COUNT" => $arResult["VEHICLES_COUNT"],
            "ERRORS" => $arResult["ERRORS"]
        ]);
    }
}
