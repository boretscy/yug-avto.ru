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
	<?php include __DIR__.'/filter.php';?>
</div>

<?php if ( $arResult['MODE'] == 'map' ) { ?>

<div class="container dealerships my-5">
	<div class="d-flex align-items-start justify-content-between ">
		<div class="dealerships-mapview-items">
			<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
			<div class="dealership-card mb-3 overflow-hidden">
				<div class="d-flex flex-column align-items-start justify-content-between dealership-card-view bg-yalightbluegray overflow-hidden">
					<div class="dealership-card-view-image position-relative b-radius-yaradius-16 w-100">
						<img class="w-100 h-100 b-radius-yaradius-16" src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?= $arItem['NAME'];?>" style="object-fit: cover;">
						<div class="dealership-card-view-image-logo b-radius-yaradius-16 bg-yawhite p-2 d-flex align-items-center justify-content-center position-absolute">
							<img class="w-100" src="<?= $arItem['PROPERTIES']['BRAND']['PICTURE'];?>" />
						</div>
					</div>
					<div class="dealership-card-view-info">
						<a class="h3 block-title d-flex align-items-top justify-content-start align-items-start text-decoration-none c-yablack c-h-yablack fw-bold mt-5 ms-2 block-title-link" href="<?= $arItem['DETAIL_PAGE_URL'];?>">
							<span><?= $arItem['NAME'];?> </span>
							<div class="info-arrow d-inline-block ms-3"></div>
						</a>
						<div class="row dealership-card-view-info-content text-minus my-3 mx-0">
							<div class="col-12"><?= $arItem['PROPERTIES']['ADDRESS']['VALUE'];?></div>
							<div class="col-12"><?= $arItem['PROPERTIES']['WORK']['VALUE'][0];?></div>
							<?php if ( $arItem['PROPERTIES']['PHONE']['VALUE'] ) { ?>
							<div class="col-12 my-2">
								<a href="tel:<?= YApp::phoneIn($arItem['PROPERTIES']['PHONE']['VALUE']);?>" class="h3 fw-bold block-title c-yablack c-h-yablack text-decoration-none"><?= YApp::phoneOut($arItem['PROPERTIES']['PHONE']['VALUE']);?></a>
							</div>
							<?php } ?>
							<?php if ( $arItem['PROPERTIES']['BRAND']['LINK'] ) { ?>
							<div class="col-12">
								<a href="<?= $arItem['PROPERTIES']['BRAND']['LINK'];?>" target="_blank" class="c-yablack c-h-yablack text-decoration-none lineheight-1"><?= parse_url($arItem['PROPERTIES']['BRAND']['LINK'])['host'];?></a>
							</div>
							<?php } ?>
						</div>
						<?php if ( $arItem['PROPERTIES']['YANDEX_ID']['VALUE'] ) { ?>
						<div class="dealership-card-rating" data-id="<?= $arItem['PROPERTIES']['YANDEX_ID']['VALUE'];?>"></div>
						<?php } ?>
						<div class="row my-3 mx-0">
							<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('showroom', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
							<div class="col-6 pe-1">
								<a 
									href="<?= $arItem['PROPERTIES']['BRAND']['CIS_LINK'];?>"
									class="dealership-card-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
									<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
									<span>Авто в наличии</span>
								</a>
							</div>
							<?php } ?>
							<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('service', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
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
								data-remodal-target="FORM_CALLBACK"
								class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow dealership-card-view-button mx-2"
								data-dealership="<?= $arItem['CODE'];?>" 
								role="setDealership"
								>Обратный звонок</a>
						</div>
					</div>
					<div class="dealership-card-view-footer-right bg-yalightbluegray d-flex">
						<div class="dealership-card-view-footer-right-content bg-yawhite w-100 d-flex justify-content-end align-items-end">
							<a 
								href="https://yandex.ru/maps/?ll=<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>&z=15&mode=routes&rtext=~<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>&rtt=auto&ruri=~"
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
		<div class="dealerships-mapview-map">
			<div id="dealershipsMap" class="dealerships-mapview-map b-radius-yaradius-16 bg-yawhite w-100"></div>
		</div>
	</div>
</div>
<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script>
	var dealershipsMap;
	function initDealershipsMap() {
		if (typeof ymaps !== 'undefined') {
			ymaps.ready(dealershipsMapInit);
		} else {
			setTimeout(initDealershipsMap, 100);
		}
	}
	initDealershipsMap();

	function dealershipsMapInit () {
		
		dealershipsMap = new ymaps.Map('dealershipsMap', {

			center: [44.470096, 39.514147],
			zoom: 8
		}, {
			searchControlProvider: 'yandex#search'
		});
		dealershipsMap.behaviors.disable('scrollZoom');
		<?php 
			$geoStr = 'dealershipsMap.geoObjects';
			foreach ($arResult['ITEMS'] as $arItem) {
				if ($arItem['PROPERTIES']['COORDS_LAT']['VALUE'] && $arItem['PROPERTIES']['COORDS_LON']['VALUE']) {
					$geoStr .= '.add(new ymaps.Placemark(';
					$geoStr .= '['.(float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].', '.(float)$arItem['PROPERTIES']['COORDS_LON']['VALUE'].'],';
					$geoStr .= '{balloonContent: "'.$arItem['NAME'].'", ';
					$geoStr .= 'hintContent: "'.$arItem['NAME'].'", ';
					$geoStr .= 'balloonContentHeader: "'.$arItem['NAME'].'", ';
					$geoStr .= 'balloonContentBody: "<p>Адрес: '.$arItem['PROPERTIES']['ADDRESS']['VALUE'].'</p>';
					$geoStr .= '<ul><li>'.((is_countable($arItem['PROPERTIES']['SERVICES']['VALUE']))?implode('</li><li>', $arItem['PROPERTIES']['SERVICES']['VALUE']):$arItem['PROPERTIES']['SERVICES']['VALUE']).'</li></ul>", ';
					$geoStr .= 'balloonContentFooter: "<a href=\"https://yandex.ru/maps/?ll='.$arItem['PROPERTIES']['COORDS_LON']['VALUE'].','.$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].'&z=15&mode=routes&rtext=~'.$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].','.$arItem['PROPERTIES']['COORDS_LON']['VALUE'].'&rtt=auto&ruri=~\" target=\"_blank\" alt=\"'.$arResult['NAME'].'\" class=\"d-block mb-3\">Построить маршрут</a>"},';
					$geoStr .= "{iconLayout: 'default#image',iconImageHref: '/local/templates/yugavto.theme.2023/assets/images/svg/placemark-map.svg',iconImageSize: [32, 38],iconImageOffset: [-16, -38]}";
					$geoStr .= '))';
				}
			}
			echo PHP_EOL.$geoStr.PHP_EOL;
		?>
	}
</script>


<?php } else { ?>

<div class="container dealerships my-5">
	<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
	<div class="row my-4">
		<div class="col">
			<div class="dealership-wrap d-flex">
				<div class="dealership-card-content flex-grow-1 bg-yalightbluegray p-3 position-relative">
					<div class="row h-100">
						<div class="col-lg-6 mb-3 mb-lg-0">
							<style>
								.dealerships-image-<?= $arItem['CODE'];?> {
									background-image: url(<?= $arItem['PREVIEW_PICTURE']['SRC'];?>);
								}
							</style>
							<div class="b-radius-yaradius-16 overflow-hidden w-100 dealership-image dealerships-image-<?= $arItem['CODE'];?>"></div>
						</div>
						<div class="col-lg-6 d-flex flex-column justify-content-between align-items-start">
							<a 
								href="<?= $arItem['DETAIL_PAGE_URL'];?>" 
								class="h3 fw-bold c-yablack c-h-yablack text-decoration-none d-flex justify-content-between align-items-start block-title-link mb-3" 
								alt="<?= $arItem['NAME'];?>"
								>
								<span><?= $arItem['NAME'];?></span>
								<div class="info-arrow d-inline-block ms-3"></div>
							</a>
							<div class="row text-minus mx-0 dealership-card-content-futures w-100 me-3">
								<div class="col-1 my-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-address.svg';?>" />
									</span>
								</div>
								<div class="col-11 my-1"><?= $arItem['PROPERTIES']['ADDRESS']['VALUE'];?></div>
								<div class="col-1 my-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-clock.svg';?>" />
									</span>
								</div>
								<div class="col-11 my-1"><?= $arItem['PROPERTIES']['WORK']['VALUE'][0];?></div>
								<?php if ( $arItem['PROPERTIES']['PHONE']['VALUE'] ) { ?>
								<div class="col-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-phone.svg';?>" />
									</span>
								</div>
								<div class="col-11">
									<a 
										href="tel:<?= YApp::phoneIn($arItem['PROPERTIES']['PHONE']['VALUE']);?>" 
										class="h3 block-title c-yablack c-h-yablack text-decoration-none fw-bold">
										<?= YApp::phoneOut($arItem['PROPERTIES']['PHONE']['VALUE']);?></a>
								</div>
								<?php } ?>
								<?php if ( $arItem['PROPERTIES']['BRAND']['LINK'] ) { ?>
								<div class="col-1 my-1 d-flex align-items-center px-0">
									<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
										<img src="<?= $templateFolder.'/images/svg/icon-dealerships-globe.svg';?>" />
									</span>
								</div>
								<div class="col-11 my-1">
									<a 
										href="<?= $arItem['PROPERTIES']['BRAND']['LINK'];?>" 
										target="_blank"
										class="c-yablack c-h-yablack text-decoration-none">
										<?= parse_url($arItem['PROPERTIES']['BRAND']['LINK'])['host'];?>
									</a>
								</div>
								<?php } ?>
							</div>
							<?php if ( $arItem['PROPERTIES']['YANDEX_ID']['VALUE'] ) { ?>
							<div class="dealership-card-rating d-lg-none mt-3" data-id="<?= $arItem['PROPERTIES']['YANDEX_ID']['VALUE'];?>"></div>
							<?php } ?>
							<div class="row w-100 my-3 my-lg-3 mx-0">
								<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('showroom', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
								<div class="col-6 pe-1 ps-0">
									<a 
										href="<?= $arItem['PROPERTIES']['BRAND']['CIS_LINK'];?>"
										class="dealership-card-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
										<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
										<span>Авто в наличии</span>
									</a>
								</div>
								<?php } ?>
								<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('service', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
								<div class="col-6 ps-1 pe-0">
									<a 
										href="/services/service/?dealership=<?= $arItem['CODE'];?>"
										class="dealership-card-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
										<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-service.svg" />
										<span>Запись на сервис</span>
									</a>
								</div>
								<?php } ?>
							</div>
							<a 
								href="#FORM_CALLBACK" 
								class="c-yablack c-h-yablack text-decoration-none d-flex align-items-center justify-content-center text-center b-radius-yaradius-12 bg-yayellow bg-h-yadarkyellow dealership-card-content-button"
								data-remodal-target="FORM_CALLBACK" 
								data-dealership="<?= $arItem['CODE'];?>" 
								role="setDealership"
								>Обратный звонок</a>
						</div>
					</div>
					<div class="dealership-card-content-footer position-absolute d-flex">
						<div class="dealership-card-content-footer-left">
							<div class="dealership-card-content-footer-left-wrap bg-yawhite h-100">
								<div class="dealership-card-content-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
							</div>
						</div>
						<div class="dealership-card-content-footer-right">
							<div class="dealership-card-content-footer-right-top w-100 bg-yawhite">
								<div class="dealership-card-content-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
							</div>
							<div class="dealership-card-content-footer-right-bottom">
								<div class="dealership-card-content-footer-right-bottom-wrap">
									<div class="dealership-card-content-footer-right-bottom-wrap-content bg-yawhite">
										<a 
											href="https://yandex.ru/maps/?ll=<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>&z=15&mode=routes&rtext=~<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>&rtt=auto&ruri=~" 
											target="_blank"
											class="dealership-card-content-footer-right-bottom-icon b-radius-yaradius-12 bg-yalightbluegray d-block"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="dealership-card-services bg-yalightbluegray b-radius-yaradius-16 mx-3 p-3 d-none d-lg-flex flex-column justify-content-between">
					<div class="mb-2">
						<div class="w-100 mb-2"><div class="h3 fw-bold w-100">Услуги автосалона</div></div>
						<div class="w-100 text-minus">
							<?php foreach ( $arItem['PROPERTIES']['SERVICES']['VALUE'] as $item ) { ?>
							<span class="d-flex justify-content-start align-items-start my-1 me-2">
								<img src="<?= $templateFolder.'/images/svg/icon-dealerships-service-corner.svg';?>" class="me-2" />
								<span><?= $item;?></span>
							</span>
							<?php } ?>
						</div>
					</div>
					<?php if ( $arItem['PROPERTIES']['YANDEX_ID']['VALUE'] ) { ?>
					<div class="dealership-card-rating" data-id="<?= $arItem['PROPERTIES']['YANDEX_ID']['VALUE'];?>"></div>
					<?php } ?>
				</div>
				<div class="dealership-card-history d-none d-lg-block text-minus-minus bg-yalightbluegray b-radius-yaradius-16 p-3">
					<div class="dealerships-item-history-title w-100 mb-3 d-flex justify-content-start align-items-center">
						<span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center me-2"><img src="<?= $templateFolder.'/images/svg/icon-dealerships-history.svg';?>" /></span>
						<div class="text-minus"><a href="/about/history/" class="c-yadarkgray c-h-yadarkgray">История компании</a></div>
					</div>
					<?php if ( $arItem['HISTORY'] ) { ?>
					<div class="dealerships-item-history-block">
						<div class="row dealerships-item-history-content w-100 ">
							<div class="col px-0"></div>
							<div class="col-1 px-0 d-flex align-items-center justify-content-start dealerships-item-history-content-icon dealerships-item-history-content-icon-arrow">
								<img src="<?= $templateFolder.'/images/arrow-yellow.svg';?>" />
								<div class="dealerships-item-history-content-icon-line bg-yayellow"></div>
							</div>
							<div class="col-8 col-xl-7 col-xxl-8 pe-0"></div>
						</div>
						<?php foreach ( $arItem['HISTORY'] as $k => $item ) { ?>
						<div class="row dealerships-item-history-content w-100 <?= (($k==count($arItem['HISTORY'])-1)?'h-100':'');?>">
							<div class="col px-0 text-center"><?= $item['SECTION'];?></div>
							<div class="col-1 px-0 d-flex align-items-center justify-content-between dealerships-item-history-content-icon">
								<img src="<?= $templateFolder.'/images/history-'.$item['ICON']['VALUE_XML_ID'].'.svg';?>" />
								<div class="dealerships-item-history-content-icon-line bg-yayellow"></div>
							</div>
							<div class="col-8 col-xl-7 col-xxl-8 pe-0"><?= $item['~NAME'];?></div>
						</div>
						<?php } // foreach HISTORY ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

<?php } ?>

<?php if ( $arResult['PROPERTIES']['CANONICAL']['VALUE'] ) $APPLICATION->SetPageProperty('canonical', $arResult['PROPERTIES']['CANONICAL']['VALUE']); ?>


