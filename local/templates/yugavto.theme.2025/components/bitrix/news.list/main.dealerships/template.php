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

	
<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script data-skip-moving="true">
	window.YAPP = window.YAPP || {};
	window.YAPP.DEALERSHIPS = <?= json_encode( $arResult['MAP'] );?>;
</script>


<div class="dealerships-on-main my-5">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex dealerships-on-main-tabs">
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill active d-none d-xl-flex justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="all"
						role="map" 
						data-list="TAGS" 
						>
						<span>Все</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['ALL'];?></span>
					</a>
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-xl-flex justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="new"
						role="map" 
						data-list="TAGS" 
						><span>Новые</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['NEW'];?></span>
					</a>
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-xl-flex justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="used"
						role="map" 
						data-list="TAGS" 
						><span>С пробегом</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['USED'];?></span>
					</a>
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill active d-flex d-xl-none justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="all"
						role="map" 
						data-list="TAGS" 
						><span>Купить</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['SALE'];?></span>
					</a>
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex d-xl-none justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="buyout"
						role="map" 
						data-list="TAGS" 
						><span>Продать</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['BUYOUT'];?></span>
					</a>
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="service"
						role="map" 
						data-list="TAGS" 
						><span>Сервис</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['SERVICE'];?></span>
					</a>
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-xl-flex justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="buyout"
						role="map" 
						data-list="TAGS" 
						><span>Центры выкупа</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['BUYOUT'];?></span>
					</a>
					<a href="#"
						class="dealerships-on-main-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-xl-flex justify-content-center align-items-center" 
						role="dealerships-on-main-tab" 
						data-value="exitbuyout"
						role="map" 
						data-list="TAGS" 
						><span>Выездной выкуп</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1"><?= $arResult['TABS']['EXIT_BUYOUT'];?></span>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="dealerships-on-main-content bg-yawhite p-4">
					<div class="row mb-4">
						<div class="col-lg-9 d-flex justify-content-start align-items-center mb-2 mb-lg-0">
							<h2 class="fw-bold text-uppercase"><?= $arParams['DISPLAY_TITLE'];?></h2>
						</div>
						<div class="col-lg-3 d-flex justify-content-lg-end align-items-center text-minus">
							<a href="<?= $arResult['LIST_PAGE_URL'];?>" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
								<?= $arParams['ALL_LINK'];?>
								<div class="info-arrow d-inline-block ms-2"></div>
							</a>
						</div>
					</div>

					<form class="row dealerships-on-main-filter-form text-minus" data-sid="MAIN_DEALERSHIPS">
						<div class="col-lg-4 mb-2 mb-lg-0 d-lg-none">
							<div class="form-dropcontainer position-relative" data-name="Марка">
								<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="mode">
									<span>Новые авто</span>
									<div class="before"></div>
									<div class="after"></div>
								</div>
								<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-list="mode">
									<div class="form-droplist-container h-100">
										<a href="#" 
											class="form-droplist-item py-1 ps-4 d-block text-decoration-none"
											data-name=""
											data-list=""
											data-value=""
											data-indx=""
											>Новые авто</a>
										<a href="#" 
											class="form-droplist-item py-1 ps-4 d-block text-decoration-none"
											data-name=""
											data-list=""
											data-value=""
											data-indx=""
											>Авто с пробегом</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-2 mb-lg-0">
							<div class="form-dropcontainer position-relative" data-name="Город" data-list="CITY">
								<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="CITY">
									<span>Город</span>
									<div class="before"></div>
									<div class="after"></div>
								</div>
								<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3" data-multiple="true" data-list="CITY">
									<div class="form-droplist-container h-100">
										<?php foreach ( $arResult['FILTER']['dropLists']['cities'] as $item ) { ?>
											<?php if ( $item['code'] != 'none' ) { ?>
											<a href="#" 
												class="form-droplist-item py-1 ps-4 d-block text-decoration-none"
												data-value="<?= $item['code'];?>"
												role="map"
												data-list="CITY"
												><?= $item['name'];?></a>
											<?php } else { ?>
											<span class="form-droplist-item not-link py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray">
												<?= $item['name'];?>
											</span>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-2 mb-lg-0">
							<div class="form-dropcontainer position-relative" data-name="Марка" data-list="BRAND">
								<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="BRAND">
									<span>Марка</span>
									<div class="before"></div>
									<div class="after"></div>
								</div>
								<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3" data-multiple="true" data-list="BRAND">
									<div class="form-droplist-container h-100">
										<?php foreach ( $arResult['FILTER']['dropLists']['brands'] as $item ) { ?>
											<?php if ( $item['code'] != 'none' ) { ?>
											<a href="#" 
												class="form-droplist-item py-1 ps-4 d-block text-decoration-none text-uppercase"
												data-value="<?= $item['code'];?>"
												role="map"
												data-list="BRAND"
												><?= $item['name'];?></a>
											<?php } else { ?>
											<span class="form-droplist-item not-link py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"><?= $item['name'];?></span>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 mb-2 mb-lg-0">
							<div class="form-dropcontainer position-relative" data-name="Дилерский центр" data-list="DEALERSHIP">
								<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="DEALERSHIP">
									<span>Дилерский центр</span>
									<div class="before"></div>
									<div class="after"></div>
								</div>
								<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3" data-multiple="true" data-list="DEALERSHIP">
									<div class="form-droplist-container h-100">
										<?php foreach ( $arResult['FILTER']['dropLists']['dealerships'] as $item ) { ?>
											<?php if ( $item['code'] != 'none' ) { ?>
											<a href="#" 
												class="form-droplist-item py-1 ps-4 d-block text-decoration-none"
												data-value="<?= $item['code'];?>"
												data-city="<?= $item['city'];?>"
												data-brand="<?= $item['brand'];?>"
												role="map"
												data-list="DEALERSHIP"
												><?= $item['name'];?></a>
											<?php } else { ?>
											<span class="form-droplist-item not-link py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"><?= $item['name'];?></span>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</form>
					
					<div class="row mt-4">
						<div class="col-12 position-relative b-radius-yaradius-16 overflow-hidden">
							
							<div id="dealershipsMap" class="dealerships-on-main-map b-radius-yaradius-16 bg-yawhite"></div>
							
							<div class="d-flex flex-column dealerships-on-main-view-wrap d-none bg-yawhite position-absolute top-0 left-0 h-100" role="view">
								
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

