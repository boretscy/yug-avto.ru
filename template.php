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

<div class="my-5 main-compilations">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
				<div class="d-flex main-compilations-tabs">
					<div class="main-compilations-tabs-item b-yawhite cursor-pointer flex-fill active d-flex justify-content-center align-items-center" role="main-compilations-tab" data-action="new">
						<span>Новые авто</span>
					</div>
					<div class="main-compilations-tabs-item b-yawhite cursor-pointer flex-fill d-flex justify-content-center align-items-center" role="main-compilations-tab" data-action="used">
						<span>Авто с пробегом</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="main-compilations-content bg-yawhite p-4 pb-3">
					<div class="row mb-4 mt-lg-4">
						<div class="col-lg-3 d-flex justify-content-start align-items-center mb-2 mb-lg-0">
							<h2 class="fw-bold text-uppercase"><?= $arParams['DISPLAY_TITLE'];?></h2>
						</div>
						<div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center mt-5 mt-lg-0 range-wrap">
							<?php 
								$range = $arResult['FILTER']['ranges']['price']; 
								$range['code'] = 'price';
								$range['name'] = 'Цена';
								$range['unit'] = '₽';
								$range['format'] = true;
								$range['range'] = ( $range['max']-$range['min'] ) ?: 1;
							?>
							<div class="range-row c-yawhite w-100 position-relative" data-range="<?= $range['code'];?>" role="view">
								<div class="range-view">
									<div class="range-view-item range-view-item-min position-absolute fw-light c-yawhite c-h-yawhite bg-yayellow b-radius-yaradius-8 py-1 position-relative d-flex justify-content-center align-items-center cursor-pointer">
										<span class="me-1 c-yawhite c-h-yawhite"><?= (($range['format'])?number_format($range['value'][0], 0, '.', ' '):$range['value'][0]);?></span> ₽
									</div>
									<div class="range-view-item range-view-item-max position-absolute fw-light c-yawhite c-h-yawhite bg-yayellow b-radius-yaradius-8 py-1 position-relative d-flex justify-content-center align-items-center cursor-pointer">
										<span class="me-1 c-yawhite c-h-yawhite"><?= (($range['format'])?number_format($range['value'][1], 0, '.', ' '):$range['value'][1]);?></span> ₽
									</div>
								</div>
							</div>
							<div class="range w-100" data-range="<?= $range['code'];?>" role="range">
								<div class="range-slider">
									<span 
										class="range-selected"
										data-url="#"
										data-min="<?= $range['value'][0];?>"
										data-max="<?= $range['value'][1];?>"
										style="
											left: <?= ($range['value'][0]-$range['min'])/($range['range'])*100;?>%;
											right: <?= ($range['max']-$range['value'][1])/($range['range'])*100;?>%;
										"
										></span>
								</div>
								<div class="range-input">
									<input 
										type="range" 
										class="min" 
										min="<?= $range['min'];?>" 
										max="<?= $range['max'];?>" 
										value="<?= $range['value'][0];?>" 
										step="1"
										/>
									<input 
										type="range" 
										class="max" 
										min="<?= $range['min'];?>" 
										max="<?= $range['max'];?>" 
										value="<?= $range['value'][1];?>" 
										step="1"
										/>
								</div>
							</div>
						</div>
						<div class="col-lg-3 order-1 order-lg-2 d-flex justify-content-lg-end align-items-center text-minus mb-4 mb-lg-0">
							<a href="/cars/new/" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
								<span class="fw-normal"><?= $arParams['ALL_LINK'];?></span> 
								<div class="info-arrow d-inline-block ms-2"></div>
							</a>
						</div>
					</div>
					<div class="row mb-5 main-compilations-collections">
						<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
						<div class="col px-0">
							<div 
								href="#" 
								class="main-compilations-item d-flex flex-column justify-content-center align-items-center overflow-hidden p-1 text-decoration-none cursor-pointer"
								data-query-new="<?= $arItem['PROPERTIES']['QUERY_NEW']['VALUE'];?>"
								data-query-used="<?= $arItem['PROPERTIES']['QUERY_USED']['VALUE'];?>"
								data-link-new="<?= $arItem['PROPERTIES']['LINK_NEW']['VALUE'];?>"
								data-link-used="<?= $arItem['PROPERTIES']['LINK_USED']['VALUE'];?>"
							>
								<div class="main-compilations-img d-flex justify-content-center align-items-center overflow-hidden mb-2">
									<img src="<?= CFile::GetPath($arItem['PROPERTIES']['IMAGE']['VALUE']);?>">
								</div>
								<div class="main-compilations-info text-uppercase w-100 d-flex justify-content-center align-items-center">
									<?= $arItem['NAME'];?>
									<div class="main-compilations-info-arrow d-inline-block ms-2"></div>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="row position-relative">
						<div class="col">
							<div class="swiper-main-compilations overflow-hidden">
								<div class="swiper-wrapper">
								<div 
									class="d-none main-compilations-data" 
									data-query=""
									data-link=""></div>
								<?php $vehicles = $arResult['VEHICLES']['items'];?>
								<?php $vehicleMode = 'new'; ?>
								<?php foreach ( $vehicles as $item ) { ?>
									<?php include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/include/item_vehicle.php'; ?>
								<?php } // foreach new ?>
								</div>
							</div>
							<div class="swiper-main-compilations-button-prev">
								<div class="swiper-main-compilations-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" class="position-absolute" />
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left-a.svg';?>" class="position-absolute" />
								</div>
							</div>
							<div class="swiper-main-compilations-button-next">
								<div class="swiper-main-compilations-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" class="position-absolute" />
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right-a.svg';?>" class="position-absolute" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
