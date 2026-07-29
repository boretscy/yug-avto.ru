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
		<div class="row my-5">
			<div class="col d-none d-lg-block">
				<div class="links b-radius-yaradius-16 bg-yawhite text-uppercase d-flex justify-content-between align-items-center">
					<div class="row w-100 m-0">
						<a href="/cars/new/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgray bg-h-yalightbluegray b-yawhite text-decoration-none py-3 d-flex justify-content-center align-items-center">
							<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-new.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-new.svg');?>" />
							<span>Новые</span>
						</a>
						<a href="/cars/used/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgray bg-h-yalightbluegray b-yawhite text-decoration-none py-3 d-flex justify-content-center align-items-center">
							<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-used.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-used.svg');?>" />
							<span>С пробегом</span>
						</a>
						<a href="/services/service/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgray bg-h-yalightbluegray b-yawhite text-decoration-none py-3 d-flex justify-content-center align-items-center">
							<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-service.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-service.svg');?>" />
							<span>Сервис</span>
						</a>
						<a href="/services/credit/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgra bg-h-yalightbluegray b-yawhite text-decoration-none py-3 d-flex justify-content-center align-items-center">
							<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-credit.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-credit.svg');?>" />
							<span>Кредит</span>
						</a>
						<a href="/services/trade-in/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgray bg-h-yalightbluegray b-yawhite text-decoration-none py-3 d-flex justify-content-center align-items-center">
							<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-buyout.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-buyout.svg');?>" />
							<span>Выкуп</span>
						</a>
					</div>
				</div>
			</div>
			<div class="col-6 d-lg-none mb-2 pe-1">
				<a href="/cars/new/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgray bg-yawhite bg-h-yawhite text-decoration-none text-uppercase py-2 ps-2 d-flex justify-content-start align-items-center">
					<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-new.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-new.svg');?>" />
					<span>Автомобили</span>
				</a>
			</div>
			<div class="col-6 d-lg-none mb-2 ps-1">
				<a href="/services/service/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgray bg-yawhite bg-h-yawhite text-decoration-none text-uppercase py-2 ps-2 d-flex justify-content-start align-items-center">
					<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-service.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-service.svg');?>" />
					<span>Сервис</span>
				</a>
			</div>
			<div class="col-6 d-lg-none pe-1">
				<a href="/services/credit/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgra bg-yawhite bg-h-yawhite text-decoration-none text-uppercase py-2 ps-2 d-flex justify-content-start align-items-center">
					<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-credit.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-credit.svg');?>" />
					<span>Кредит</span>
				</a>
			</div>
			<div class="col-6 d-lg-none ps-1">
				<a href="/services/trade-in/" class="col links-item b-radius-yaradius-16 c-yadarkgray c-h-yadarkgray bg-yawhite bg-h-yawhite text-decoration-none text-uppercase py-2 ps-2 d-flex justify-content-start align-items-center">
					<img class="me-3" src="<?= $templateFolder;?>/images/svg/icon-main-filter-buyout.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/images/svg/icon-main-filter-buyout.svg');?>" />
					<span>Выкуп</span>
				</a>
			</div>
		</div>
		<div class="row d-flex mb-5">
			<div class="col">
				<div class="b-radius-yaradius-16 bg-yawhite p-3 p-lg-5 text-uppercase d-flex flex-column flex-lg-row justify-content-between align-items-lg-center main-compilations-futures text-uppercase">
					<h2 class="d-lg-none fw-bold text-uppercase">ЮГ-АВТО ЭТО</h2>
					<div class="main-compilations-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center my-2 my-lg-0">
						<div class="title fw-light me-3 me-lg-0">28</div>
						<div class="text c-yadarkgray fw-light">лет</div>
					</div>
					<div class="separator mx-2 bg-yayellow"></div>
					<div class="main-compilations-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center my-2 my-lg-0">
						<div class="title fw-light me-3 me-lg-0">48</div>
						<div class="text c-yadarkgray fw-light">брендов</div>
					</div>
					<div class="separator mx-2 bg-yayellow"></div>
					<div class="main-compilations-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center my-2 my-lg-0">
						<div class="title fw-light me-3 me-lg-0">5</div>
						<div class="text c-yadarkgray fw-light">городов</div>
					</div>
					<div class="separator mx-2 bg-yayellow"></div>
					<div class="main-compilations-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center me-0 me-lg-2 mt-2 mt-lg-0">
						<div class="title fw-light li me-3 me-lg-0">1 000 000 +</div>
						<div class="text c-yadarkgray fw-light">клиентов</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
