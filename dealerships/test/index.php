<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Дилерские центры - Юг-Авто");
$APPLICATION->SetPageProperty("description", "Адреса дилерских центров ЮГ-Авто, контакты отдела продаж и отдела сервиса");
$APPLICATION->SetTitle("Дилерские центры - Юг-Авто");
?>
<style>
	body {background-color: var(--yawhite);}
</style>
<?php if ( $APPLICATION->GetCurPage(false) !== '/' ) {
            $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb", 
                "breadcrumbs", 
                array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0",
                    "COMPONENT_TEMPLATE" => "breadcrumbs",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
        } ?>
<?php 

// if filter brands
if ( $_GET['brand'] ) {
    
    $rs = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
            'ACTIVE' => 'Y',
            'CODE' => $_GET['brand']
        ],
        false, false,
        ['ID']  
    );
    if ( $ob = $rs->GetNextElement() ) {

        $arFilterDealerships['PROPERTY_BRAND'] = $ob->GetFields()['ID'];
    }
}

// if filter tags
if ( $_GET['tag'] ) {

    $rs = CIBlockPropertyEnum::GetList(
        ['sort'=>'asc'],
        [
            'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
            'CODE' => 'TAG'
        ]
    );
    while ( $ob = $rs->Fetch() ) if ( in_array($ob['XML_ID'], explode(',', $_GET['tag'])) ) $arFilterDealerships['PROPERTY_TAG_VALUE'][] = $ob['VALUE'];

}
// if filter city
if ( $_GET['city'] ) {

    $rs = CIBlockPropertyEnum::GetList(
        ['sort'=>'asc'],
        [
            'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
            'CODE' => 'CITY'
        ]
    );
    while ( $ob = $rs->Fetch() ) if ( $_GET['city'] == $ob['VALUE'] ) $arFilterDealerships['PROPERTY_CITY_VALUE'] = $ob['VALUE'];
} else {
	$arFilterDealerships['!PROPERTY_CITY_VALUE'] = ['Ставрополь'];
}
?>
<?php $arFilterDealerships['PROPERTY_INCOGNITO_VALUE'] = false; ?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"dealerships", 
	[
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"DETAIL_PAGER_SHOW_ALL" => "N",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => [
			0 => "BRAND",
			1 => "",
		],
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => [
			0 => "DETAIL_PICTURE",
			1 => "",
		],
		"LIST_PROPERTY_CODE" => [
			0 => "BRAND",
			1 => "",
		],
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "1000",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/dealerships/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "NAME",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "Y",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "dealerships",
		"FILTER_NAME" => "arFilterDealerships",
		"FILTER_FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"FILTER_PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FILE_404" => "",
		"SEF_URL_TEMPLATES" => [
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		]
	],
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>