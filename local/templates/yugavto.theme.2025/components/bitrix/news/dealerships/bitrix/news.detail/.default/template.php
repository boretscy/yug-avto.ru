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
<div class="bg-yalightbluegray top-container pb-5"  itemscope itemtype="http://schema.org/Organization">
	<div class="container">
		<div class="row dealership-image mb-3 mb-lg-5">
			<div class="col">
				<picture class="w-100 b-radius-yaradius-16">
					<source srcset="<?= CFile::GetPath($arResult['PROPERTIES']['PIC_MOBILE_DETAIL']['VALUE']);?>" media="(max-width:500px)">
					<source srcset="<?= CFile::GetPath($arResult['PROPERTIES']['PIC_TABLET_DETAIL']['VALUE']);?>" media="(max-width:768px)">
					<img src="<?= $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arResult['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arResult['NAME']));?>" class="w-100 b-radius-yaradius-25">
				</picture>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column flex-md-row justify-content-between">
					<div class="dealership-card mb-4 mb-lg-0">
						<div class="dealership-card-content bg-yawhite">
							<h1 class="h3 block-title fw-bold" itemprop="name"><?= $arResult['NAME'];?></h1>
							<div class="row text-minus m-0">
								<div class="col-1 my-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-address.svg';?>" />
									</span>
								</div>
								<div class="col-11 my-1 d-flex align-items-center "><?= $arResult['PROPERTIES']['ADDRESS']['VALUE'];?></div>
								<div class="col-1 my-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-clock.svg';?>" />
									</span>
								</div>
								<div class="col-11 my-1 d-flex align-items-center "><?= $arResult['PROPERTIES']['WORK']['VALUE'][0];?></div>
								<?php if ( $arResult['PROPERTIES']['PHONE']['VALUE'] ) { ?>
								<div class="col-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-phone.svg';?>" />
									</span>
								</div>
								<div class="col-11 d-flex align-items-center">
									<a 
										href="tel:<?= YApp::phoneIn($arResult['PROPERTIES']['PHONE']['VALUE']);?>" 
										class="h3 m-0 block-title c-yablack c-h-yablack text-decoration-none fw-bold">
										<?= YApp::phoneOut($arResult['PROPERTIES']['PHONE']['VALUE']);?></a>
								</div>
								<?php } ?>
								<?php if ( $arResult['PROPERTIES']['BRAND']['LINK'] ) { ?>
								<div class="col-1 my-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-globe.svg';?>" />
									</span>
								</div>
								<div class="col-11 mt-1 d-flex align-items-center ">
									<a 
										href="<?= $arResult['PROPERTIES']['BRAND']['LINK'];?>" 
										target="_blank"
										class="c-yablack c-h-yablack text-decoration-none">
										<?= parse_url($arResult['PROPERTIES']['BRAND']['LINK'])['host'];?>
									</a>
								</div>
								<?php } ?>
							</div>
							<?php if ( $arResult['PROPERTIES']['YANDEX_ID']['VALUE'] ) { ?>
							<div class="dealership-card-rating my-3" data-id="<?= $arResult['PROPERTIES']['YANDEX_ID']['VALUE'];?>">
								<iframe src="https://yandex.ru/sprav/widget/rating-badge/<?=  $arResult['PROPERTIES']['YANDEX_ID']['VALUE'];?>?type=rating" width="150" height="50" frameborder="0"></iframe>
							</div>
							<?php } ?>
							<div class="row my-2 text-minus">
								<div class="col-6 pe-1">
									<?php if ( !empty($arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('showroom', $arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
									<a 
										href="<?= $arResult['PROPERTIES']['BRAND']['CIS_LINK'];?>"
										class="dealership-card-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yalightbluegray bg-h-yayellow">
										<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
										Авто в наличии
									</a>
									<?php } ?>
								</div>
								<div class="col-6 ps-1">
									<?php if ( !empty($arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('service', $arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
									<a 
										href="/services/service/?dealership=<?= $arResult['CODE'];?>"
										class="dealership-card-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yalightbluegray bg-h-yayellow">
										<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-service.svg" />
										Запись на сервис
									</a>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="dealership-card-footer d-flex justify-content-between">
							<div class="dealership-card-footer-left bg-yalightbluegray d-flex">
								<div class="dealership-card-footer-left-content w-100 bg-yawhite">
									<a 
										href="#FORM_CALLBACK" 
										class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yayellow bg-h-yalightbluegray dealership-card-button"
										data-remodal-target="FORM_CALLBACK" 
										data-dealership="<?= $arItem['CODE'];?>" 
										role="setDealership"
										>Обратный звонок</a>
								</div>
							</div>
							<div class="dealership-card-footer-right bg-yawhite d-flex">
								<div class="dealership-card-footer-right-content bg-yalightbluegray w-100 d-flex justify-content-end align-items-end">
									<a 
										href="https://yandex.ru/maps/?ll=<?= $arResult['PROPERTIES']['COORDS_LON']['VALUE'];?>,<?= $arResult['PROPERTIES']['COORDS_LAT']['VALUE'];?>&z=15&mode=routes&rtext=~<?= $arResult['PROPERTIES']['COORDS_LAT']['VALUE'];?>,<?= $arResult['PROPERTIES']['COORDS_LON']['VALUE'];?>&rtt=auto&ruri=~"
										target="_blank" 
										class="b-radius-yaradius-12 bg-yawhite dealership-card-item d-flex justify-content-center align-items-center position-relative">
										<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route.svg" />
										<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route-a.svg" />
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="dealership-map" id="dealershipMap" class="h-100"></div>
				</div>
			</div>
		</div>
	</div>
	<?php if ( $arResult['PROPERTIES']['SERVICES']['VALUE'] ) { ?>
	<div class="container my-5">
		<div class="row">
			<div class="col">
				<h2 class="h2 text-uppercase ps-2 ps-lg-0">Услуги автосалона</h2>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php foreach ( array_chunk( $arResult['PROPERTIES']['SERVICES']['VALUE'], 6 ) as $c => $items ) { ?>
				<div class="dealership-services dealership-services-<?= count($items);?> <?= ((count($arResult['PROPERTIES']['SERVICES']['VALUE'])>6)?'mb-3':'');?>">
					<?php foreach ( $items as $k => $item) { ?>
					<div class="dealership-service-<?= $k+1;?> bg-yawhite b-radius-yaradius-16 p-4">
						<img src="<?= $templateFolder.'/images/services-'.array_chunk($arResult['PROPERTIES']['SERVICES']['VALUE_XML_ID'], 6)[$c][$k].'.png?2';?>" class="" />
						<p class=""><?= $items[$k];?></p>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<div class="container my-5">
	<?php if ( $arResult['COUNT'] ) { ?>
	<div class="row mb-4">
		<div class="col-lg-9 d-flex justify-content-start align-items-center">
			<h2 class="fw-bold text-uppercase ps-2 ps-lg-0"><?= $arResult['COUNT'];?> <?= YApp::getWorld($arResult['COUNT'], 'a');?> в наличии</h2>
		</div>
		<div class="col-lg-3 d-flex justify-content-lg-end align-items-center text-minus">
			<a href="/cars/<?= $arResult['MODE'];?>/<?= $arResult['SECTION']['CODE'];?>/?&dealership=<?= $arResult['CODE'];?>" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center  ps-2 ps-lg-0">
				Смотреть все
				<div class="info-arrow d-inline-block ms-2"></div>
			</a>
		</div>
	</div>
	<div class="row pb-5">
		<div class="col position-relative">
			<div class="swiper-dealership-cis swiper-dealership-cis-<?= $arResult['MODE'];?> overflow-hidden">
				<div class="swiper-wrapper">
				<?php $vehicles = $arResult['VEHICLES'];?>
				<?php $vehicleMode = $arResult['MODE']; ?>
				<?php foreach ( $vehicles as $item ) { ?>
					<?php include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/include/item_vehicle.php'; ?>
				<?php } ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<div class="swiper-dealership-cis-button-prev swiper-dealership-cis-button-prev-<?= $arResult['MODE'];?>">
				<div class="swiper-dealership-cis-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
					<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" class="position-absolute" />
					<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left-a.svg';?>" class="position-absolute" />
				</div>
			</div>
			<div class="swiper-dealership-cis-button-next swiper-dealership-cis-button-next-<?= $arResult['MODE'];?>">
				<div class="swiper-dealership-cis-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
					<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" class="position-absolute" />
					<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right-a.svg';?>" class="position-absolute" />
				</div>
			</div>
			<script>
				YAPP.SwiperVehicles_<?= $arResult['MODE'];?> = new Swiper('.swiper-dealership-cis-<?= $arResult['MODE'];?>', {
					pagination: {
						el: ".swiper-pagination",
						type: "fraction",
					},
					navigation: {
						nextEl: '.swiper-dealership-cis-button-next-<?= $arResult['MODE'];?>',
						prevEl: '.swiper-dealership-cis-button-prev-<?= $arResult['MODE'];?>',
					},
					slidesPerView: 4,
					spaceBetween: 24,

					breakpoints: {
						320: {
							slidesPerView: 1,
							spaceBetween: 10
						},
						768: {
							slidesPerView: 2,
							spaceBetween: 24
						},
						1024: {
							slidesPerView: 4,
							spaceBetween: 24
						},
					}
				});
			</script>
		</div>
	</div>
	<?php } ?>
</div>

<?php if ( !empty($arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('service', $arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) ) {
	$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"main.services",
		Array(
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
			"CACHE_TYPE" => "A",
			"CHECK_DATES" => "Y",
			"COMPONENT_TEMPLATE" => "main.services",
			"DETAIL_URL" => "",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_DATE" => "N",
			"DISPLAY_NAME" => "N",
			"DISPLAY_PICTURE" => "N",
			"DISPLAY_PREVIEW_TEXT" => "N",
			"DISPLAY_TOP_PAGER" => "N",
			"FIELD_CODE" => array(0=>"DETAIL_PICTURE",1=>"",),
			"FILTER_NAME" => "",
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",
			"IBLOCK_ID" => "9",
			"IBLOCK_TYPE" => "content",
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
			"INCLUDE_SUBSECTIONS" => "N",
			"MESSAGE_404" => "",
			"NEWS_COUNT" => "2",
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
			"PROPERTY_CODE" => array(0=>"LINK",1=>"IMAGE",),
			"SET_BROWSER_TITLE" => "N",
			"SET_LAST_MODIFIED" => "N",
			"SET_META_DESCRIPTION" => "N",
			"SET_META_KEYWORDS" => "N",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "N",
			"SHOW_404" => "N",
			"SORT_BY1" => "SORT",
			"SORT_BY2" => "TIMESTAMP_X",
			"SORT_ORDER1" => "ASC",
			"SORT_ORDER2" => "DESC",
			"STRICT_SECTION_CHECK" => "N"
		)
	);
}?>

<div class="bg-yalightbluegray bottom-container py-5">
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block.white", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "form.block.gray",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "15",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEALERSHIP_CODE" => $arResult['CODE'],
		"DEALERSHIP_NAME" => $arResult['NAME'],
		"BRAND_LOGO" => CFile::GetPath( $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['PREVIEW_PICTURE'] ),
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>


<?php global $arFilterNews;
$arFilterNews = [
    'PROPERTY_DEALERSHIP' => $arResult['ID'],
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
</div>



<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<?php if ($arResult['PROPERTIES']['CANONICAL']['VALUE']) $APPLICATION->SetPageProperty('canonical', $arResult['PROPERTIES']['CANONICAL']['VALUE']); ?>

<script>
var dealershipMap;
ymaps.ready(dealershipMapInit);

function dealershipMapInit () {
	
    dealershipMap = new ymaps.Map('dealershipMap', {

        center: [<?= $arResult['PROPERTIES']['COORDS_LAT']['VALUE'];?>, <?= $arResult['PROPERTIES']['COORDS_LON']['VALUE'];?>],
        zoom: 15
    }, {
        searchControlProvider: 'yandex#search'
    });
	dealershipMap.behaviors.disable('scrollZoom');
	dealershipMap.geoObjects.add(new ymaps.Placemark(
		[<?= $arResult['PROPERTIES']['COORDS_LAT']['VALUE'];?>, <?= $arResult['PROPERTIES']['COORDS_LON']['VALUE'];?>],
		{balloonContent: "<?= $arResult['NAME'];?>", iconCaption: "<?= $arResult['NAME'];?>"},
		{iconLayout: 'default#image',iconImageHref: '/local/templates/yugavto.theme.2023/assets/images/svg/placemark-map.svg',iconImageSize: [32, 38],iconImageOffset: [-16, -38]}
	))
}
</script>