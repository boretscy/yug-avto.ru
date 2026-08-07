<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $protocol . "://" . ($_SERVER['HTTP_HOST'] ?? 'htest.yug-avto.ru');
$logoUrl = $host . '/local/templates/yugavto.theme.2025/assets/images/svg/logo.svg';
$detailPicUrl = !empty($arResult['DETAIL_PICTURE']['SRC']) ? ((strpos($arResult['DETAIL_PICTURE']['SRC'], 'http') === 0) ? $arResult['DETAIL_PICTURE']['SRC'] : $host . $arResult['DETAIL_PICTURE']['SRC']) : $logoUrl;
$pageUrl = $host . $_SERVER['REQUEST_URI'];
$previewText = !empty($arResult['PREVIEW_TEXT']) ? strip_tags($arResult['PREVIEW_TEXT']) : htmlspecialchars($arResult['NAME']);
$keywords = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS']) ? $arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS'] : 'новости, юг-авто, автоновости, краснодар';
$sectionName = !empty($arResult['SECTION']['NAME']) ? $arResult['SECTION']['NAME'] : 'Новости';
$articleType = (!empty($arResult['PROPERTIES']['IS_ARTICLE']['VALUE']) && $arResult['PROPERTIES']['IS_ARTICLE']['VALUE'] == 'Y') ? 'Article' : 'NewsArticle';
?>
<div class="bg-yalightbluegray pb-4" itemscope itemtype="http://schema.org/<?= $articleType;?>">
	<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?= $pageUrl;?>"/>
	<time itemprop="datePublished" datetime="<?= date('c', strtotime($arResult['ACTIVE_FROM'] ?? 'now'));?>" class="d-none"><?= date('Y-m-d', strtotime($arResult['ACTIVE_FROM'] ?? 'now'));?></time>
	<meta itemprop="dateModified" content="<?= date('c', strtotime($arResult['TIMESTAMP_X'] ?? 'now'));?>">
	<meta itemprop="description" content="<?= htmlspecialchars($previewText);?>">
	<meta itemprop="inLanguage" content="ru-RU">
	<meta itemprop="articleSection" content="<?= htmlspecialchars($sectionName);?>">
	<meta itemprop="keywords" content="<?= htmlspecialchars($keywords);?>">
	<div itemprop="author" itemscope itemtype="https://schema.org/Organization" class="d-none"><meta itemprop="name" content="Юг-Авто"></div>
	<meta itemprop="image" content="<?= $detailPicUrl;?>">

	<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" class="d-none">
		<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
			<img itemprop="url" src="<?= $logoUrl;?>" alt="Юг-Авто" />
		</div>
		<link itemprop="url" href="<?= $host;?>/">
		<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
			<span itemprop="postalCode">350000</span>,
			<span itemprop="addressCountry">Россия</span>, 
			<span itemprop="addressRegion">Краснодарский край</span>, 
			<span itemprop="addressLocality">Краснодар</span>, 
			<span itemprop="streetAddress">ул. Уральская, 98/11</span>
		</div>
		<div>Телефон: <a href="tel:+78612031405"><span itemprop="telephone">+7 (861) 203-14-05</span></a></div>
		<div>Почта: <a href="mailto:info@yug-avto.ru"><span itemprop="email">info@yug-avto.ru</span></a></div>
		<meta itemprop="name" content="Юг-Авто"> 
	</div>
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h2 block-title" itemprop="headline"><?= $arResult['NAME'];?></h1></div>
		</div>
		<div class="row my-3 my-lg-5 offer-image">
			<div class="col">
				<picture class="w-100 b-radius-yaradius-16">
					<img src="<?= $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arResult['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arResult['NAME']));?>" class="w-100 b-radius-yaradius-25" itemprop="image">
				</picture>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col">
				<div class="offer-content bg-yawhite b-radius-yaradius-16 p-4" itemprop="articleBody">
					<?= $arResult['DETAIL_TEXT'];?>
				</div>
			</div>
		</div>
		<?php if ( $arResult['PROPERTIES']['DISCLAMER']['~VALUE'] ) { ?>
		<div class="row mb-4">
			<div class="col">
				<div class="offer-disclamer c-yadarkgray text-minus bg-yawhite b-radius-yaradius-16 p-4">
					<?= $arResult['PROPERTIES']['DISCLAMER']['~VALUE']['TEXT'];?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>

	<?php global $arFilterNews;
	$arFilterNews = [
		'!ID' => $arResult['ID'],
		'PROPERTY_VIDEO' => false
	];?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list", 
		"main.news", 
		array(
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "N",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "N",
			"CHECK_DATES" => "Y",
			"COMPONENT_TEMPLATE" => "main.news",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_DATE" => "N",
			"DISPLAY_NAME" => "N",
			"DISPLAY_PICTURE" => "N",
			"DISPLAY_PREVIEW_TEXT" => "N",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array(
				0 => "DETAIL_PICTURE",
				1 => "",
			),
			"FILTER_NAME" => "arFilterNews",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"IBLOCK_ID" => "11",
			"IBLOCK_TYPE" => "content",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"INCLUDE_SUBSECTIONS" => "N",
			"MESSAGE_404" => "",
			"NEWS_COUNT" => "20",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => ".default",
			"PAGER_TITLE" => "Новости",
			"PARENT_SECTION" => "",
			"PARENT_SECTION_CODE" => "",
			"PREVIEW_TRUNCATE_LEN" => "",
			"PROPERTY_CODE" => array(
				0 => "",
				1 => "",
			),
			"SET_BROWSER_TITLE" => "N",
			"SET_LAST_MODIFIED" => "N",
			"SET_META_DESCRIPTION" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "N",
			"SHOW_404" => "N",
			"SORT_BY1" => "ACTIVE_FROM",
			"SORT_BY2" => "SORT",
			"SORT_ORDER1" => "DESC",
			"SORT_ORDER2" => "ASC",
			"STRICT_SECTION_CHECK" => "N",
			"DISPLAY_TITLE" => "Читайте также:",
			"ALL_LINK" => "Все новости",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO"
		),
		false
	);?>

	<?php 
	if ( $arResult['PROPERTIES']['FORM_CALLBACK']['VALUE_XML_ID'] == 'ON' ) {
		$APPLICATION->IncludeComponent(
			"bitrix:form.result.new", 
			"form.line.white", 
			array(
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"CHAIN_ITEM_LINK" => "",
				"CHAIN_ITEM_TEXT" => "",
				"COMPONENT_TEMPLATE" => "form.line.white",
				"EDIT_URL" => "result_edit.php",
				"IGNORE_CUSTOM_TEMPLATE" => "N",
				"LIST_URL" => "result_list.php",
				"SEF_MODE" => "N",
				"SUCCESS_URL" => "",
				"USE_EXTENDED_ERRORS" => "N",
				"WEB_FORM_ID" => "3",
				"COMPOSITE_FRAME_MODE" => "A",
				"COMPOSITE_FRAME_TYPE" => "AUTO",
				'DEALERSHIP' => ( !empty($arResult['PROPERTIES']['DEALERSHIP']['VALUE']) ) ? implode(',', $arResult['PROPERTIES']['DEALERSHIP']['VALUE']) : '',
				'FORM_TITLE' => ( $arResult['PROPERTIES']['FORM_TITLE']['VALUE'] ) ?: 'Заказать обратный звонок',
				'FORM_TEXT' => ( $arResult['PROPERTIES']['FORM_TEXT']['VALUE'] ) ?: 'Оставьте свои контакты и наш менеджер проконсультирует вас по модельному ряду',
				"VARIABLE_ALIASES" => array(
					"WEB_FORM_ID" => "WEB_FORM_ID",
					"RESULT_ID" => "RESULT_ID",
				)
			),
			false
		);
	} 
	?>

</div>


