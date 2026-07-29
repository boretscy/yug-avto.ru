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
?>
<div class="bg-yalightbluegray top-container pb-3 pb-lg-5">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h2 block-title"><?= $arResult['~NAME'];?></h1></div>
		</div>
		<div class="row my-5 offer-image">
			<div class="col">
				<picture class="w-100 b-radius-yaradius-16">
					<img src="<?= $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?= htmlspecialchars(YApp::getCleanAltText(preg_replace('/<sup>.*?<\/sup>/i', '', $arResult['~NAME'])));?>" title="<?= htmlspecialchars(YApp::getCleanAltText(preg_replace('/<sup>.*?<\/sup>/i', '', $arResult['~NAME'])));?>" class="w-100 b-radius-yaradius-25">
				</picture>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col">
				<div class="offer-content bg-yawhite b-radius-yaradius-16 p-4">
					<?= $arResult['DETAIL_TEXT'];?>
				</div>
			</div>
		</div>
		<?php if ( $arResult['PROPERTIES']['DISCLAMER']['~VALUE'] ) { ?>
		<div class="row">
			<div class="col">
				<div class="offer-disclamer c-yadarkgray text-minus bg-yawhite b-radius-yaradius-16 p-4">
					<?= $arResult['PROPERTIES']['DISCLAMER']['~VALUE']['TEXT'];?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>

<?php if ($arResult['DISPLAY_PROPERTIES']['DEALERSHIP']) { ?>
<div class="container dealerships my-5">
		<div class="d-lg-flex align-items-start justify-content-between mb-3 mb-lg-0">
			<div class="dealerships-mapview-items <?= ((count($arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'])==1)?'single':'');?>  mb-3 mb-lg-0">
				<?php foreach ( $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $arItem ) { ?>
				<div class="dealership-card mb-3 overflow-hidden">
					<div class="d-flex flex-column align-items-start justify-content-between dealership-card-view bg-yalightbluegray overflow-hidden">
						<div class="dealership-card-view-image position-relative b-radius-yaradius-16 w-100">
							<img class="w-100 h-100 b-radius-yaradius-16" src="<?= CFile::GetPath($arItem['PREVIEW_PICTURE']);?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" style="object-fit: cover;">
							<div class="dealership-card-view-image-logo b-radius-yaradius-16 bg-yawhite p-2 d-flex align-items-center justify-content-center position-absolute">
								<img class="w-100" src="<?= CFile::GetPath($arItem['PROPERTY_BRAND']['PREVIEW_PICTURE']);?>" />
							</div>
						</div>
						<div class="dealership-card-view-info">
							<a class="h3 block-title d-flex align-items-top justify-content-start align-items-start text-decoration-none c-yablack c-h-yablack fw-bold mt-5 mb-4 mx-2" href="<?= $arItem['DETAIL_PAGE_URL'];?>">
								<?= $arItem['NAME'];?> <img class="dealership-card-view-info-title-image ms-3" src="/local/templates/yugavto.theme.2025/components/bitrix/news.list/main.dealerships/images/svg/icon-main-dealerships-corner-right.svg" />
							</a>
							<div class="row dealership-card-view-info-content text-minus my-2 mx-0">
								<div class="col-12"><?= $arItem['PROPERTY_ADDRESS'];?></div>
								<div class="col-12"><?= $arItem['PROPERTY_WORK'];?></div>
								<?php if ( $arItem['PROPERTY_PHONE'] ) { ?>
								<div class="col-12 fw-bold my-2">
									<a href="tel:<?= YApp::phoneIn($arItem['PROPERTY_PHONE']);?>" class="h3 block-title fw-bold c-yablack c-h-yablack text-decoration-none"><?= YApp::phoneOut($arItem['PROPERTY_PHONE']);?></a>
								</div>
								<?php } ?>
								<?php if ( $arItem['PROPERTY_BRAND_LINK']['LINK'] ) { ?>
								<div class="col-12">
									<a href="<?= $arItem['PROPERTY_BRAND_LINK']['LINK'];?>" target="_blank" class="c-yablack c-h-yablack text-decoration-none"><?= parse_url($arItem['PROPERTY_BRAND_LINK']['LINK'])['host'];?>
								</div>
								<?php } ?>
							</div>
							<?php if ( $arItem['PROPERTY_YANDEX_ID'] ) { ?>
							<div class="dealership-card-rating my-3" data-id="<?= $arItem['PROPERTY_YANDEX_ID'];?>">
								<iframe src="https://yandex.ru/sprav/widget/rating-badge/<?= $arItem['PROPERTY_YANDEX_ID'];?>?type=rating" width="150" height="50" frameborder="0"></iframe>
							</div>
							<?php } ?>
							<div class="row my-2 mx-0">
								<?php if ( !empty($arItem['PROPERTY_TAG']) && in_array('showroom', $arItem['PROPERTY_TAG']) ) { ?>
								<div class="col-6 pe-1">
									<a 
										href="/cars/new/?dealership=<?= $arItem['CODE'];?>"
										class="dealership-card-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
										<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
										<span>Авто в наличии</span>
									</a>
								</div>
								<?php } ?>
								<?php if ( !empty($arItem['PROPERTY_TAG']) && in_array('service', $arItem['PROPERTY_TAG']) ) { ?>
								<div class="col-6 ps-1">
									<a 
										href="/services/service/?dealership=<?= $arItem['CODE'];?>"
										class="dealership-card-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
										<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-service.svg" />
										<span>Запись на сервис</span>
									</a>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="dealership-card-view-footer d-flex justify-content-between">
						<div class="dealership-card-view-footer-left bg-yawhite d-flex">
							<div class="dealership-card-view-footer-left-content w-100 bg-yalightbluegray">
								<a 
									href="#FORM_CALLBACK" 
									class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow dealership-card-view-button mx-2"
									data-remodal-target="FORM_CALLBACK" 
									data-dealership="<?= $arItem['CODE'];?>" 
									role="setDealership"
									>Обратный звонок</a>
							</div>
						</div>
						<div class="dealership-card-view-footer-right bg-yalightbluegray d-flex">
							<div class="dealership-card-view-footer-right-content bg-yawhite w-100 d-flex justify-content-end align-items-end">
								<a 
									href="https://yandex.ru/maps/?ll=<?= $arItem['PROPERTY_COORDS_LON'];?>,<?= $arItem['PROPERTY_COORDS_LAT'];?>&z=15&mode=routes&rtext=~<?= $arItem['PROPERTY_COORDS_LAT'];?>,<?= $arItem['PROPERTY_COORDS_LON'];?>&rtt=auto&ruri=~"
									target="_blank" 
									class="b-radius-yaradius-12 bg-yalightbluegray dealership-card-view-item d-flex justify-content-center align-items-center position-relative">
									<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route.svg" />
									<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route-a.svg" />
								</a>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="dealerships-mapview-map <?= ((count($arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'])==1)?'single':'');?>">
				<div id="dealershipsMap" class="dealerships-mapview-map <?= ((count($arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'])==1)?'single':'');?> b-radius-yaradius-16 bg-yawhite w-100"></div>
			</div>
		</div>
	</div>
</div>
<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script>
var dealershipsMap;
ymaps.ready(dealershipsMapInit);

function dealershipsMapInit () {
	
    dealershipsMap = new ymaps.Map('dealershipsMap', {

        center: [44.470096, 39.514147],
        zoom: 6
    }, {
        searchControlProvider: 'yandex#search'
    });
	dealershipsMap.behaviors.disable('scrollZoom');
	<?php 
		$geoStr = 'dealershipsMap.geoObjects';
		foreach ($arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $arItem) {
			if ($arItem['PROPERTY_COORDS_LAT'] && $arItem['PROPERTY_COORDS_LON']) {
				$geoStr .= '.add(new ymaps.Placemark(';
				$geoStr .= '['.(float)$arItem['PROPERTY_COORDS_LAT'].', '.(float)$arItem['PROPERTY_COORDS_LON'].'],';
				$geoStr .= '{balloonContent: "'.$arItem['NAME'].'", iconCaption: "'.$arItem['NAME'].'"},';
				$geoStr .= "{iconLayout: 'default#image',iconImageHref: '/local/templates/yugavto.theme.2023/assets/images/svg/placemark-map.svg',iconImageSize: [32, 38],iconImageOffset: [-16, -38]}";
				$geoStr .= '))';
			}
		}
		echo PHP_EOL.$geoStr.PHP_EOL;

	?>
	dealershipsMap.setBounds(dealershipsMap.geoObjects.getBounds()).
		then( function() {
			let zoom = dealershipsMap.getZoom();
            if ( zoom >= 16 ) {
                zoom = 16;
            } else {
                zoom -= 0.5;
            }
            dealershipsMap.setZoom( zoom )
		});
	
}
</script>
<?php } ?>


<div class="bg-yalightbluegray bottom-container py-3 py-lg-5">
<?$APPLICATION->IncludeComponent(
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
		"WEB_FORM_ID" => "4",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		'DEALERSHIP' => (($arResult['DCs'])?implode(',', $arResult['DCs']):''),
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>

<?php global $arFilterNews;
$arFilterNews = [
    '!ID' => $arResult['ID'],
    'PROPERTY_BRAND' => $arResult['PROPERTIES']['BRAND']['VALUE'],
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
		"IBLOCK_ID" => "13",
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
		"ALL_LINK" => "Все акции",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
</div>