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
<?php if ( $arResult['SECTIONS'] ) { ?>
	<style>
		body {
			background: var(--yalightbluegray) !important;
		}
	</style>
	<div class="container mb-3">
		<div class="row">
			<div class="col d-flex justify-content-start align-items-center">
				<h1 class="h2 text-uppercase">
					Автомобили 
				</h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<?php foreach ( $arResult['SECTIONS'] as $k => $arItem ) { ?>
			<div class="col-6 col-md-3 mt-3">
				<div class="bg-yawhite b-yagray b-radius-yaradius-16 p-2 p-xl-4 d-flex justify-content-center align-items-center text-center brand-logo-item">
					<a href="/brands/<?= $arItem['CODE'];?>/" alt="<?= $arItem['NAME'];?>" class="">
						<img src="<?= CFile::GetPath($arItem['LOGO']);?>" alt="<?= $arItem['NAME'];?>" class="w-50" />
					</a>
				</div>
			</div>
			<?php } // foreach SECTIONS ?>
		</div>
	</div>

<?php } else { ?>
	<div class="bg-yalightbluegray top-container pb-3 pb-lg-5">
		<div class="container mb-4">
			<div class="row">
				<div class="col-12">
					<div class="brand-title-wrap d-flex align-items-center justify-content-between">
						<div class="brand-title-logo d-flex align-items-center justify-content-center p-3 bg-yawhite b-radius-yaradius-16 me-3">
							<img src="<?= CFile::GetPath($arResult['SECTION']['LOGO']);?>" class="w-100" />
						</div>
						<div class="brand-title-content">
							<div class="row h-100">
								<div class="col">
									<div class="brand-title-tabs d-none d-lg-flex w-100">
										<a
											href="/dealerships/?brand=<?= $arResult['SECTION']['CODE'];?>"
											class="brand-title-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex justify-content-center align-items-center block-title-link ps-3">
											<div class="d-flex align-items-center">
												<div><?= count($arResult['DEALERSHIPS']);?> <?= YApp::getWorld(count($arResult['DEALERSHIPS']), 'dc');?></div>
												<div class="info-arrow d-inline-block ms-2"></div>
											</div>
										</a>
										<a
											href="/cars/new/<?= $arResult['SECTION']['CODE'];?>/"
											class="brand-title-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex justify-content-center align-items-center block-title-link ps-3">
											<div class="d-flex align-items-center">
												<div><?= $arResult['NEW_COUNT'];?> <?= YApp::getWorld($arResult['NEW_COUNT'], 'n');?> <?= YApp::getWorld($arResult['NEW_COUNT'], 'a');?> в наличии</div>
												<div class="info-arrow d-inline-block ms-2"></div>
											</div>
										</a>
										<a
											href="/cars/used/<?= $arResult['SECTION']['CODE'];?>/"
											class="brand-title-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex justify-content-center align-items-center block-title-link ps-3">
											<div class="d-flex align-items-center">
												<div><?= $arResult['USED_COUNT'];?> <?= YApp::getWorld($arResult['USED_COUNT'], 'a');?> с пробегом в наличии</div>
												<div class="info-arrow d-inline-block ms-2"></div>
											</div>
										</a>
									</div>
									<div class="brand-title-tabs-content px-4 bg-yawhite d-flex align-items-center">
										<div class="row">
											<div class="col">
												<h1 class="h2 fw-bold text-uppercase m-0">Автомобили <?= $arResult['SECTION']['NAME'];?></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row d-lg-none mt-3">
				<div class="col-12 mb-3">
					<a
						href="/dealerships/?brand=<?= $arResult['SECTION']['CODE'];?>"
						class="bg-yawhite c-yablack c-h-yablack text-decoration-none b-radius-yaradius-16 px-4 py-3 d-block block-title-link">
						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex align-items-center">
								<span class="tab-count c-yawhite c-h-yawhite fw-bold d-flex justify-content-center align-items-center me-3 bg-yadarkgray b-radius-yaradius-6"><?= count($arResult['DEALERSHIPS']);?></span>
								<?= YApp::getWorld(count($arResult['DEALERSHIPS']), 'dc');?>
							</div>
							<div class="info-arrow d-inline-block ms-2"></div>
						</div>
					</a>
				</div>
				<div class="col-12 mb-3">
					<a
						href="/cars/new/<?= $arResult['SECTION']['CODE'];?>/"
						class="bg-yawhite c-yablack c-h-yablack text-decoration-none b-radius-yaradius-16 px-4 py-3 d-block block-title-link">
						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex align-items-center">
								<span class="tab-count c-yawhite c-h-yawhite fw-bold d-flex justify-content-center align-items-center me-3 bg-yadarkgray b-radius-yaradius-6"><?= $arResult['NEW_COUNT'];?></span>
								<?= YApp::getWorld($arResult['NEW_COUNT'], 'a');?> в наличии
							</div>
							<div class="info-arrow d-inline-block ms-2"></div>
						</div>
					</a>
				</div>
				<div class="col-12">
					<a
						href="/cars/used/<?= $arResult['SECTION']['CODE'];?>/"
						class="bg-yawhite c-yablack c-h-yablack text-decoration-none b-radius-yaradius-16 px-4 py-3 d-block block-title-link">
						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex align-items-center">
								<span class="tab-count c-yawhite c-h-yawhite fw-bold d-flex justify-content-center align-items-center me-3 bg-yadarkgray b-radius-yaradius-6"><?= $arResult['USED_COUNT'];?></span>
								<?= YApp::getWorld($arResult['USED_COUNT'], 'a');?> с пробегом в наличии
							</div>
							<div class="info-arrow d-inline-block ms-2"></div>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
					<div class="col-lg-3 mb-4">
						<div class="model-wrap position-relative">
							<div class="model-content bg-yawhite">
								<?php if ($arItem['PREVIEW_PICTURE']['SRC']) {
									$bg = $arItem['PREVIEW_PICTURE']['SRC'];
								} elseif ($arItem['PROPERTIES']['EXTERNAL_PICTURE']['VALUE']) {
									$bg = $arItem['PROPERTIES']['EXTERNAL_PICTURE']['VALUE'];
								} else {
	$bodyCode = $arItem['PROPERTIES']['BODY']['VALUE_XML_ID'] ?: 'none';
	$bg = SITE_TEMPLATE_PATH.'/assets/images/bodies/'.$bodyCode.'.webp';
	$st = 'transform: scale(-1, 1);';
								} ?>
								<a 
									href="<?= $arItem['DETAIL_PAGE_URL'];?>"
									class="mb-4 d-block model-image p-4 d-flex align-items-center justify-content-center overflow-hidden">
									<img src="<?= $bg;?>" alt="<?= $arItem['NAME'];?>" class="w-100" style="object-fit: contain;<?= $st;?>">
								</a>
								<a href="<?= $arItem['DETAIL_PAGE_URL'];?>" class="c-yablack c-h-yablack text-decoration-none fw-bold h3 model-content-title d-block mb-4"><?= $arItem['NAME'];?></a>
								<?php if ( (int)$arResult['VEHICLES_NEW'][$arItem['CODE']]['vehicles'] ) { ?>
									<a 
										href="/cars/new/<?= $arResult['SECTION']['CODE'];?>/<?= $arItem['CODE'];?>" 
										class="model-content-count w-100 d-flex align-items-center justify-content-start c-yablack c-h-yablack text-decoration-none mb-2 text-minus">
										<span class="me-2 b-radius-yaradius-8 bg-yadarkgray c-yawhite c-h-yawhite d-flex align-items-center justify-content-center"><?= (int)$arResult['VEHICLES_NEW'][$arItem['CODE']]['vehicles'];?></span>
										<div>новых авто в наличии</div>
									</a>
								<?php } // if VEHICLES_NEW ?>
								<?php if ( (int)$arResult['VEHICLES_USED'][$arItem['CODE']]['vehicles'] ) { ?>
									<a 
										href="/cars/used/<?= $arResult['SECTION']['CODE'];?>/<?= $arItem['CODE'];?>" 
										class="model-content-count w-100 d-flex align-items-center justify-content-start c-yablack c-h-yablack text-decoration-none text-minus">
										<span class="me-2 b-radius-yaradius-8 bg-yadarkgray c-yawhite c-h-yawhite d-flex align-items-center justify-content-center"><?= (int)$arResult['VEHICLES_USED'][$arItem['CODE']]['vehicles'];?></span>
										<div>авто c пробегом в наличии</div>
									</a>
								<?php } // if VEHICLES_USED ?>
							</div>
							<div class="model-footer position-absolute d-flex">
								<div class="model-footer-left">
									<div class="model-footer-left-wrap bg-yalightbluegray h-100">
										<div class="model-footer-left-wrap-corner bg-yawhite h-100"></div>
									</div>
								</div>
								<div class="model-footer-right">
									<div class="model-footer-right-top w-100 bg-yalightbluegray">
										<div class="model-footer-right-top-wrap w-100 bg-yawhite"></div>
									</div>
									<div class="model-footer-right-bottom">
										<div class="model-footer-right-bottom-wrap">
											<div class="model-footer-right-bottom-wrap-content bg-yalightbluegray">
												<div class="model-footer-right-bottom-icon b-radius-yaradius-12"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>


	<?php if ( $arResult['USED'] ) { ?>
		<div class="container my-5">
			<div class="row mb-4">
				<div class="col-lg-9 d-flex justify-content-start align-items-center">
					<h2 class="fw-bold text-uppercase">Автомобили с пробегом</h2>
				</div>
				<div class="col-lg-3 d-flex justify-content-lg-end align-items-center">
					<a href="/cars/used/<?= $arResult['SECTION']['CODE'];?>/" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
						Смотреть все
						<div class="info-arrow d-inline-block ms-2"></div>
					</a>
				</div>
			</div>
			<div class="row position-relative">
				<div class="col">
					<div class="swiper-vehicles overflow-hidden">
						<div class="swiper-wrapper">
							<?php $vehicles = $arResult['USED'];?>
							<?php $vehicleMode = 'used'; ?>
							<?php foreach ( $vehicles as $item ) { ?>
								<?php include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/include/item_vehicle.php'; ?>
							<?php } ?>
						</div>
					</div>
					<div class="swiper-vehicles-button-prev">
						<div class="swiper-vehicles-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" class="position-absolute" />
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left-a.svg';?>" class="position-absolute" />
						</div>
					</div>
					<div class="swiper-vehicles-button-next">
						<div class="swiper-vehicles-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" class="position-absolute" />
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right-a.svg';?>" class="position-absolute" />
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	
	<?$APPLICATION->IncludeComponent("bitrix:news.list", "main.services", Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
			"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
			"AJAX_MODE" => "N",	// Включить режим AJAX
			"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
			"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
			"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
			"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
			"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
			"CACHE_GROUPS" => "N",	// Учитывать права доступа
			"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
			"CACHE_TYPE" => "A",	// Тип кеширования
			"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
			"COMPONENT_TEMPLATE" => "main.services",
			"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
			"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
			"DISPLAY_DATE" => "N",
			"DISPLAY_NAME" => "N",
			"DISPLAY_PICTURE" => "N",
			"DISPLAY_PREVIEW_TEXT" => "N",
			"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
			"FIELD_CODE" => array(	// Поля
				0 => "DETAIL_PICTURE",
				1 => "",
			),
			"FILTER_NAME" => "",	// Фильтр
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
			"IBLOCK_ID" => "9",	// Код информационного блока
			"IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
			"INCLUDE_SUBSECTIONS" => "N",	// Показывать элементы подразделов раздела
			"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
			"NEWS_COUNT" => "2",	// Количество новостей на странице
			"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
			"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
			"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
			"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
			"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
			"PAGER_TITLE" => "Новости",	// Название категорий
			"PARENT_SECTION" => "",	// ID раздела
			"PARENT_SECTION_CODE" => "",	// Код раздела
			"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
			"PROPERTY_CODE" => array(	// Свойства
				0 => "LINK",
				1 => "",
			),
			"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
			"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
			"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
			"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
			"SET_STATUS_404" => "N",	// Устанавливать статус 404
			"SET_TITLE" => "N",	// Устанавливать заголовок страницы
			"SHOW_404" => "N",	// Показ специальной страницы
			"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
			"SORT_BY2" => "TIMESTAMP_X",	// Поле для второй сортировки новостей
			"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
			"SORT_ORDER2" => "DESC",	// Направление для второй сортировки новостей
			"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
		),
		false
	);?>

	<?php if ($arResult['DEALERSHIPS']) { ?>
	<div class="container dealerships my-5">
		<div class="d-lg-flex align-items-start justify-content-between ">
			<div class="dealerships-mapview-items <?= ((count($arResult['DEALERSHIPS'])==1)?'single':'');?>   mb-3 mb-lg-0">
				<?php foreach ( $arResult['DEALERSHIPS'] as $arItem ) { ?>
				<div class="dealership-card mb-3 overflow-hidden">
					<div class="d-flex flex-column align-items-start justify-content-between dealership-card-view bg-yalightbluegray overflow-hidden">
						<div class="dealership-card-view-image position-relative b-radius-yaradius-16 w-100">
							<img class="w-100 h-100 b-radius-yaradius-16" src="<?= CFile::GetPath($arItem['PREVIEW_PICTURE']);?>" alt="<?= $arItem['NAME'];?>" style="object-fit: cover;">
							<div class="dealership-card-view-image-logo b-radius-yaradius-16 bg-yawhite p-2 d-flex align-items-center justify-content-center position-absolute">
								<img class="w-100" src="<?= CFile::GetPath($arItem['PROPERTY_BRAND']['PREVIEW_PICTURE']);?>" />
							</div>
						</div>
						<div class="dealership-card-view-info">
							<a class="h3 block-title d-flex align-items-top justify-content-start align-items-start text-decoration-none c-yablack c-h-yablack fw-bold mt-5 mb-4 mx-2" href="<?= $arItem['DETAIL_PAGE_URL'];?>">
								<?= $arItem['NAME'];?> <img class="dealership-card-view-info-title-image ms-3" src="/local/templates/yugavto.theme.2025/components/bitrix/news.list/main.dealerships/images/svg/icon-main-dealerships-corner-right.svg" />
							</a>
							<div class="row dealership-card-view-info-content text-minus mt-2 mx-0">
								<div class="col-12"><?= $arItem['PROPERTY_ADDRESS_VALUE'];?></div>
								<div class="col-12"><?= $arItem['PROPERTY_WORK'];?></div>
								<?php if ( $arItem['PROPERTY_PHONE_VALUE'] ) { ?>
								<div class="col-12 fw-bold my-2">
									<a href="tel:<?= YApp::phoneIn($arItem['PROPERTY_PHONE_VALUE']);?>" class="h3 fw-bold block-title c-yablack c-h-yablack text-decoration-none"><?= YApp::phoneOut($arItem['PROPERTY_PHONE_VALUE']);?></a>
								</div>
								<?php } ?>
								<?php if ( $arItem['PROPERTY_BRAND_LINK']['LINK'] ) { ?>
								<div class="col-12">
									<a href="<?= $arItem['PROPERTY_BRAND_LINK']['LINK'];?>" target="_blank" class="c-yablack c-h-yablack text-decoration-none"><?= parse_url($arItem['PROPERTY_BRAND_LINK']['LINK'])['host'];?></a>
								</div>
								<?php } ?>
							</div>
							<?php if ( $arItem['PROPERTY_YANDEX_ID_VALUE'] ) { ?>
							<div class="dealership-card-rating my-3" data-id="<?= $arItem['PROPERTY_YANDEX_ID_VALUE'];?>">
								<iframe src="https://yandex.ru/sprav/widget/rating-badge/<?= $arItem['PROPERTY_YANDEX_ID_VALUE'];?>?type=rating" width="150" height="50" frameborder="0"></iframe>
							</div>
							<?php } ?>
							<div class="row my-2 mx-0">
								<?php if ( !empty($arItem['PROPERTY_TAG']) && in_array('showroom', $arItem['PROPERTY_TAG']) ) { ?>
								<div class="col-6 pe-1">
									<a 
										href="/cars/new/?dealership=<?= $arItem['PROPERTY_EXTERNAL_CODE_VALUE'];?>"
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
									href="<?= $view['BUTTONS']['MAP'];?>" 
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
			<div class="dealerships-mapview-map <?= ((count($arResult['DEALERSHIPS'])==1)?'single':'');?>">
				<div id="dealershipsMap" class="dealerships-mapview-map <?= ((count($arResult['DEALERSHIPS'])==1)?'single':'');?> b-radius-yaradius-16 bg-yawhite w-100"></div>
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
				foreach ($arResult['DEALERSHIPS'] as $arItem) {
					if ($arItem['PROPERTY_COORDS_LAT_VALUE'] && $arItem['PROPERTY_COORDS_LON_VALUE']) {
						$geoStr .= '.add(new ymaps.Placemark(';
						$geoStr .= '['.(float)$arItem['PROPERTY_COORDS_LAT_VALUE'].', '.(float)$arItem['PROPERTY_COORDS_LON_VALUE'].'],';
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

<?php } ?>
<div class="bg-yalightbluegray bottom-container py-5">
	<?php $APPLICATION->IncludeComponent(
		"bitrix:form.result.new",
		"form.block.white",
		Array(
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"CHAIN_ITEM_LINK" => "",
			"CHAIN_ITEM_TEXT" => "",
			"EDIT_URL" => "result_edit.php",
			"IGNORE_CUSTOM_TEMPLATE" => "N",
			"LIST_URL" => "result_list.php",
			"SEF_MODE" => "N",
			"SUCCESS_URL" => "",
			"USE_EXTENDED_ERRORS" => "N",
			"VARIABLE_ALIASES" => array("RESULT_ID"=>"RESULT_ID","WEB_FORM_ID"=>"WEB_FORM_ID",),
			"WEB_FORM_ID" => "15"
		)
	);?>
</div>
