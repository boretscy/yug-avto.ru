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
<div class="container mb-4">
	<div class="row">
		<div class="col">
			<div class="bg-yawhite b-radius-yaradius-16 p-4">
				<h1 class="h2 text-uppercase mb-3">Контактная информация</h1>
				<div class="row">
					<div class="col-lg-5 col-xxl-4 mb-3 mb-lg-0">
						<div 
                            class="bg-yalightbluegray c-yablack c-h-yablack contacts-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative d-flex flex-column justify-content-between align-items-start">
                            <h3 class="fw-bold w-100">Возникли вопросы?<br />Мы будем рады ответить.</h3>
							<p class="text-minus mb-3 w-100">пос. Яблоновский, г. Краснодар,<br />г. Новороссийск, г. Майкоп</p>
							<div class="w-100">
								<a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>" class="h3 fw-bold d-block c-yablack c-h-yablack text-decoration-none">
									<?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?>
								</a>
								<a href="mailto:callcenter@yug-avto.ru" class="d-block c-yablack c-h-yablack text-decoration-none text-minus">callcenter@yug-avto.ru</a>
							</div>
							<div class="dealership-card-view-info-buttons w-100">
								<a 
									href="/cars/new/"
									class="dealership-card-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
									<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
									<span>Авто в наличии</span>
								</a>
								<a 
									href="/services/service/"
									class="dealership-card-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
									<img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-service.svg" />
									<span>Запись на сервис</span>
								</a>
							</div>
							<a 
								href="#FORM_CALLBACK" 
								class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow dealership-card-view-button"
								data-remodal-target="FORM_CALLBACK"
								role="setDealership"
								>Обратный звонок</a>
                            <div class="contacts-item-footer position-absolute d-flex">
                                <div class="contacts-item-footer-left">
                                    <div class="contacts-item-footer-left-wrap bg-yawhite h-100">
                                        <div class="contacts-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                    </div>
                                </div>
                                <div class="contacts-item-footer-right">
                                    <div class="contacts-item-footer-right-top w-100 bg-yawhite">
                                        <div class="contacts-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                    </div>
                                    <div class="contacts-item-footer-right-bottom">
                                        <div class="contacts-item-footer-right-bottom-wrap">
                                            <div class="contacts-item-footer-right-bottom-wrap-content bg-yawhite">
                                                <div class="contacts-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                    <img src="<?= $templateFolder;?>/images/svg/icon-contacts.svg" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="col-lg-7 col-xxl-8">
						<div id="dealershipsMap" class="dealerships-mapview-map b-radius-yaradius25 bg-yawhite b-yagray"></div>
					</div>
				</div>
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