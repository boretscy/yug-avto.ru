<?php
// get TAGS for FILTER (только реально используемые в активных статьях)
$arResult['FILTER']['TAGS']['title'] = 'Теги';
$arResult['FILTER']['TAGS']['items'] = [];

$currentTags = array_filter(explode(',', (string)($_GET['tag'] ?? '')));

$usedEnumIds = [];
$res = CIBlockElement::GetList(
    [],
    [
        "IBLOCK_ID" => YApp::IBLOCK_BLOG,
        "ACTIVE" => "Y",
        "!PROPERTY_TAGS" => false
    ],
    ["PROPERTY_TAGS"],
    false,
    ["ID", "PROPERTY_TAGS"]
);
while ($arRes = $res->Fetch()) {
    if (!empty($arRes['PROPERTY_TAGS_ENUM_ID'])) {
        $usedEnumIds[] = (int)$arRes['PROPERTY_TAGS_ENUM_ID'];
    }
}

if (!empty($usedEnumIds)) {
    $enumRes = CIBlockPropertyEnum::GetList(
        ["SORT" => "ASC", "VALUE" => "ASC"], 
        [
            "IBLOCK_ID" => YApp::IBLOCK_BLOG, 
            "CODE" => 'TAGS',
            "ID" => array_unique($usedEnumIds)
        ]
    );
    while ($arEnum = $enumRes->GetNext()) {
        $code = !empty($arEnum['XML_ID']) ? $arEnum['XML_ID'] : $arEnum['VALUE'];
        $arResult['FILTER']['TAGS']['items'][] = [
            'id' => $arEnum['ID'],
            'code' => $code, 
            'name' => $arEnum['VALUE'], 
            'selected' => in_array($code, $currentTags, true) || in_array($arEnum['VALUE'], $currentTags, true)
        ];
    }
}
?>