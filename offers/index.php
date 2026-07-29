<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Спецпредложения от официального дилера");
$APPLICATION->SetPageProperty("description", "Спецпредложения на автомобили. Официальный дилер ЮГ-АВТО в Краснодаре, поселке Яблоновский республики Адыгея и Новороссийске.");
$APPLICATION->SetTitle("Спецпредложения от официального дилера");
?>
<style>
	body {background-color: var(--yawhite);}
</style>
<?php 

// $arFilterOffers['PROPERTY_IS_STORIES'] = false;

// if filter brands
if ( $_GET['brand'] ) {
    
    $rs = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
            'ACTIVE' => 'Y',
            'CODE' => explode(',', str_replace('`', '', $_GET['brand']))
        ],
        false, false,
        ['ID']  
    );
    while ( $ob = $rs->GetNextElement() ) {

		$brs = CIBlockElement::GetList(
			[],
			[
				'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
				'ACTIVE' => 'Y',
				'PROPERTY_BRAND' => $ob->GetFields()['ID']
			],
			false, false,
			['ID']  
		);
		while ( $bob = $brs->GetNextElement())  $arFilterOffers['PROPERTY_DEALERSHIP'][] = $bob->GetFields()['ID'];
    }
}


// if filter tags
if ( $_GET['tag'] ) {

    $rs = CIBlockPropertyEnum::GetList(
        ['sort'=>'asc'],
        [
            'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
            'CODE' => 'TAG'
        ]
    );
    while ( $ob = $rs->Fetch() ) if ( $_GET['tag'] == $ob['XML_ID'] ) $arFilterOffers['PROPERTY_TAG_VALUE'] = $ob['VALUE'];

}

// if filter dealerships
if ( $_GET['dealership'] ) {
    
    $rs = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
            'ACTIVE' => 'Y',
            'CODE' => explode(',', str_replace('`', '', $_GET['dealership']))
        ],
        false, false,
        ['ID']  
    );
    while ( $ob = $rs->GetNextElement() ) {

        $arFilterOffers['PROPERTY_DEALERSHIP'][] = $ob->GetFields()['ID'];
    }
}
YApp::sp($arFilterOffers, true);
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"offers", 
	[
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
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
		"COMPONENT_TEMPLATE" => "offers",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => [
			0 => "DATE_ACTIVE_TO",
			1 => "",
		],
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => [
			0 => "DEALERSHIP",
			1 => "BRAND",
			2 => "",
		],
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILTER_FIELD_CODE" => [
			0 => "",
			1 => "",
		],
		"FILTER_NAME" => "arFilterOffers",
		"FILTER_PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => [
			0 => "DATE_ACTIVE_TO",
			1 => "",
		],
		"LIST_PROPERTY_CODE" => [
			0 => "DEALERSHIP",
			1 => "TAG",
			2 => "BRAND",
			3 => "",
		],
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "12",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "pagen",
		"PAGER_TITLE" => "Спецпредложения",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/offers/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "Y",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"FILE_404" => "/404.php",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"SEF_URL_TEMPLATES" => [
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		]
	],
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>