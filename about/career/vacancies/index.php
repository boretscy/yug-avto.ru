<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Работа В Юг-Авто");
$APPLICATION->SetPageProperty("description", "Вся информация о вакансиях компании ЮГ-Авто.");
$APPLICATION->SetTitle("Работа в Юг-Авто");
?>
<style>
	body {background-color: var(--yawhite);}
</style>
<?php
// if filter tags
if ( $_GET['tag'] ) {

    $rs = CIBlockPropertyEnum::GetList(
        ['sort'=>'asc'],
        [
            'IBLOCK_ID' => YApp::IBLOCK_VACANCIES,
            'CODE' => 'SCOPE'
        ]
    );
    while ( $ob = $rs->Fetch() ) if ( in_array($ob['XML_ID'], explode(',', $_GET['tag'])) ) $arFilterVacancies['PROPERTY_SCOPE_VALUE'][] = $ob['VALUE'];

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
    if ( $ob = $rs->GetNextElement() ) {

        $arFilterVacancies['PROPERTY_DEALERSHIP'] = $ob->GetFields()['ID'];
    }

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
    while ( $ob = $rs->Fetch() ) if ( $_GET['city'] == $ob['VALUE'] ) $arFilterVacancies['PROPERTY_CITY_VALUE'] = $ob['VALUE'];
}
?>

<?php 
	$GLOBALS['VACANCIES_COUNT'] = 0;
	$rs = CIBlockElement::GetList(
		[],
		array_merge(
			[
				'IBLOCK_ID' => YApp::IBLOCK_VACANCIES,
				'ACTIVE' => 'Y',
			],
			( $arFilterVacancies ) ?: []
		),
		false, false,
		['ID']
	);
	while ( $ob = $rs->GetNextElement() ) $GLOBALS['VACANCIES_COUNT']++;

	// YApp::sp( $arF, true );
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"vacancies", 
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
		"COMPONENT_TEMPLATE" => "vacancies",
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
			0 => "BRAND",
			1 => "DEALERSHIP",
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
		"FILTER_NAME" => "arFilterVacancies",
		"FILTER_PROPERTY_CODE" => [
			0 => "BRAND",
			1 => "CITY",
			2 => "DEALERSHIP",
			3 => "SCOPE",
			4 => "PAY",
			5 => "PAY_FROM",
			6 => "PAY_TO",
			7 => "",
		],
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "14",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => [
			0 => "DATE_ACTIVE_TO",
			1 => "",
		],
		"LIST_PROPERTY_CODE" => [
			0 => "BRAND",
			1 => "DEALERSHIP",
			2 => "SCOPE",
			3 => "PAY",
			4 => "PAY_FROM",
			5 => "PAY_TO",
			6 => "",
		],
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "12",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "modern",
		"PAGER_TITLE" => "Вакансии",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/about/career/vacancies/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "TIMESTAMP_X",
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
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FILE_404" => "/404.php",
		"SEF_URL_TEMPLATES" => [
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
		]
	],
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>