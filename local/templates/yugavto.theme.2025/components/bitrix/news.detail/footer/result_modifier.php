<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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
