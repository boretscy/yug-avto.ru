<?php

$arResult['GALLERY'] = [];
if (!empty($arResult['PROPERTIES']['GALLERY']['VALUE']) && is_array($arResult['PROPERTIES']['GALLERY']['VALUE'])) {
    foreach ($arResult['PROPERTIES']['GALLERY']['VALUE'] as $g) {
        $path = CFile::GetPath($g);
        if ($path) {
            $arResult['GALLERY'][] = $path;
        }
    }
}

if (!empty($arResult['PROPERTIES']['VIDEO']['VALUE'])) {
    $videoUrl = parse_url($arResult['PROPERTIES']['VIDEO']['VALUE']);
    if (!empty($videoUrl['query'])) {
        foreach (explode('&', $videoUrl['query']) as $item) {
            $tmp = explode('=', $item);
            if (isset($tmp[0]) && $tmp[0] === 'v' && isset($tmp[1])) {
                $arResult['VIDEO_REVIEW_CODE'] = $tmp[1];
            }
        }
    }
}
$GLOBALS['NEWS_FILTER'] = [
    '!ID' => $arResult['ID'],
    'PROPERTY_VIDEO' => false
];

// YApp::sp(implode(',', $arResult['PROPERTIES']['DEALERSHIP']['VALUE']), true);
?>