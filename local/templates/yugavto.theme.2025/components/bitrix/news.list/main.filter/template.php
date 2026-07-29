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

<?php if ( $arResult['STORIES']  ) { ?>
<div class="container my-3 d-xl-none">
	<div class="row">	
		<div class="col">
			<div class="main-stories-preview">
				<div class="d-flex flex-nowrap" style="width: <?= 87*count($arResult['STORIES']);?>px;">
					<?php foreach ( $arResult['STORIES'] as $k => $item ) { ?>
						<a 
							href="#stories<?= $k;?>" 
							data-remodal-target="stories"
							data-indx="<?= $k;?>"
							class="d-block stories-item me-3" data-hash="<?= md5($item['ID'].'-'.$item['NAME'].'-'.$item['ACTIVE_FROM_X'].'-'.$item['PROPERTY_STORIES_LINK_VALUE']);?>">
							<img src="<?= CFile::GetPath($item['PROPERTY_STORIES_MOBILE_PREVIEW_PICTURE_VALUE']);?>" alt="<?= $item['NAME'];?>" class="w-100 h-100" style="object-fit: cover;">
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="remodal p-0 b-radius-yaradius-16" role="stories" data-remodal-id="stories">
	<div  class="modal-close cursor-pointer position-absolute d-flex justify-content-center align-items-center" data-remodal-action="close">
		<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-modal-cross.svg';?>" />
	</div>
	<div class="position-relative">
		<div class="swiper-main-stories swiper-main-stories-mobile">
			<div class="swiper-wrapper">
				<?php foreach ( $arResult['STORIES'] as $item ) { ?>
				<link id="bgpreload" rel="preload" as="image" href="<?= CFile::GetPath($item['PROPERTY_STORIES_MOBILE_DETAIL_PICTURE_VALUE']);?>" />
				<div class="swiper-slide b-radius-yaradius-16">
					<div class="position-relative swiper-slide-img b-radius-yaradius-16 h-100 w-100">
						<img class="h-100 w-100" src="<?= CFile::GetPath($item['PROPERTY_STORIES_MOBILE_DETAIL_PICTURE_VALUE']);?>" alt="<?= $item['NAME'];?>" style="object-fit: cover;">
						<div class="swiper-main-stories-m-footer position-absolute bottom-0 w-100">
							<div class="mb-3 d-flex justify-content-center">
								<a 
									href="<?= (($item['PROPERTY_STORIES_LINK_VALUE'])?:'/offers/'.$item['CODE'].'/');?>"
									class="d-flex justify-content-center align-items-center c-yablack c-ah-yablack text-decoration-none bg-yayellow bg-h-darkyellow b-radius-yaradius-16 swiper-main-stories-m-button"
									>Подробнее</a>
							</div>
							<div class="swiper-main-stories-m-footer-content d-flex justify-content-center align-items-center py-3">
								<div 
									class="reaction c-yawhite cursor-pointer d-flex justify-content-center align-items-center px-1 mx-3" 
									role="reaction" 
									data-hash="<?= md5($item['ID'].'-'.$item['NAME'].'-'.$item['ACTIVE_FROM_X'].'-'.$item['PROPERTY_STORIES_LINK_VALUE']);?>_HEART"
									data-reaction="<?= (int)$item['PROPERTY_STORIES_COUNT_HEART_VALUE'];?>"
									data-action="HEART"
									data-id="<?= $item['ID'];?>">
									<span class="me-2">❤️</span>
									<span role="value"><?= number_format($item['PROPERTY_STORIES_COUNT_HEART_VALUE'], 0, '.', ' ');?></span>
								</div>
								<div 
									class="reaction c-yawhite cursor-pointer d-flex justify-content-center align-items-center px-1 mx-3" 
									role="reaction" 
									data-hash="<?= md5($item['ID'].'-'.$item['NAME'].'-'.$item['ACTIVE_FROM_X'].'-'.$item['PROPERTY_STORIES_LINK_VALUE']);?>_FIRE"
									data-reaction="<?= (int)$item['PROPERTY_STORIES_COUNT_FIRE_VALUE'];?>"
									data-action="FIRE"
									data-id="<?= $item['ID'];?>">
									<span class="me-2">🔥</span>
									<span role="value"><?= number_format($item['PROPERTY_STORIES_COUNT_FIRE_VALUE'], 0, '.', ' ');?></span>
								</div>
								<div 
									class="reaction c-yawhite cursor-pointer d-flex justify-content-center align-items-center px-1 mx-3" 
									role="reaction" 
									data-hash="<?= md5($item['ID'].'-'.$item['NAME'].'-'.$item['ACTIVE_FROM_X'].'-'.$item['PROPERTY_STORIES_LINK_VALUE']);?>_LIKE"
									data-reaction="<?= (int)$item['PROPERTY_STORIES_COUNT_LIKE_VALUE'];?>"
									data-action="LIKE"
									data-id="<?= $item['ID'];?>">
									<span class="me-2">👍</span>
									<span role="value"><?= number_format($item['PROPERTY_STORIES_COUNT_LIKE_VALUE'], 0, '.', ' ');?></span>
								</div>
								<div 
									class="reaction c-yawhite cursor-pointer d-flex justify-content-center align-items-center px-1 mx-3" 
									role="reaction" 
									data-hash="<?= md5($item['ID'].'-'.$item['NAME'].'-'.$item['ACTIVE_FROM_X'].'-'.$item['PROPERTY_STORIES_LINK_VALUE']);?>_DISLIKE"
									data-reaction="<?= (int)$item['PROPERTY_STORIES_COUNT_DISLIKE_VALUE'];?>"
									data-action="DISLIKE"
									data-id="<?= $item['ID'];?>">
									<span class="me-2">👎</span>
									<span role="value"><?= number_format($item['PROPERTY_STORIES_COUNT_DISLIKE_VALUE'], 0, '.', ' ');?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>
		<div class="swiper-main-stories-button-prev swiper-main-stories-button-prev-mobile  b-radius-yaradius-6">
			<div class="swiper-main-stories-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-6">
				<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" class="position-absolute" />
				<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left-a.svg';?>" class="position-absolute" />
			</div>
		</div>
		<div class="swiper-main-stories-button-next swiper-main-stories-button-next-mobile  b-radius-yaradius-6">
			<div class="swiper-main-stories-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-6">
				<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" class="position-absolute" />
				<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right-a.svg';?>" class="position-absolute" />
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="my-5 mt-3 mt-lg-5 main-filter">
	<div class="container">
		<div class="row mb-3">
			<div class="col-12 col-lg-9 pe-lg-3 main-filter-left">
				<div class="main-filter-tabs d-flex w-100">
					<div class="main-filter-tabs-item b-yawhite cursor-pointer flex-fill active d-none d-lg-flex justify-content-center align-items-center" role="toggleEntity" data-action="cis" data-entity="new">
						<span>Новые авто</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1" role="cis-value" data-action="new"><?=  number_format((int)$arResult['COUNTS']['NEW'], 0, '.', ' ');?></span>
					</div>
					<div class="main-filter-tabs-item b-yawhite cursor-pointer flex-fill d-none d-lg-flex justify-content-center align-items-center" role="toggleEntity" data-action="cis" data-entity="used">
						<span>Авто с пробегом</span>
						<span class="ms-3 b-radius-yaradius-5 bg-yadarkgray c-yawhite fw-bold px-1" role="cis-value" data-action="used"><?=  number_format((int)$arResult['COUNTS']['USED'], 0, '.', ' ');?></span>
					</div>
					<div class="main-filter-tabs-item b-yawhite cursor-pointer flex-fill d-flex d-lg-none justify-content-center align-items-center active" data-action="cis">
						<span>Купить</span>
					</div>
					<div class="main-filter-tabs-item b-yawhite cursor-pointer flex-fill d-flex justify-content-center align-items-center" data-action="trade-in">
						<span class="d-none d-lg-inline-block">Продать авто</span>
						<span class="d-lg-none">Продать</span>
					</div>
					<div class="main-filter-tabs-item b-yawhite cursor-pointer flex-fill d-flex justify-content-center align-items-center" data-action="service">
						<span class="d-none d-lg-inline-block">Запись на сервис</span>
						<span class="d-lg-none">Сервис</span>
					</div>
				</div>
				<div class="main-filter-tabs-content p-4 bg-yawhite d-flex flex-column justify-content-center align-items-start mb-lg-3">
					<div class="main-filter-tabs-content-wrap w-100" role="main-filter-tab-content" data-action="cis">
						<form class="row" data-sid="MAIN_FILTER">
							<div class="col-12 my-3">
								<h2 class="fw-bold text-uppercase">Найти автомобиль</h2>
							</div>
							<div class="col-lg-4 d-lg-none mb-2 mb-lg-0">
								<div class="form-dropcontainer position-relative" data-name="Авто" data-list="mode">
									<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="mode">
										<span>Новые авто</span>
										<div class="before"></div>
										<div class="after"></div>
									</div>
									<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-list="mode">
										<div class="form-droplist-container h-100">
											<a href="#" 
												class="form-droplist-item py-1 ps-4 d-block text-decoration-none"
												data-action="cis" 
												data-entity="new"
												role="toggleEntity"
												>Новые авто</a>
											<a href="#" 
												class="form-droplist-item py-1 ps-4 d-block text-decoration-none"
												data-action="cis" 
												data-entity="used"
												role="toggleEntity"
												>Авто с пробегом</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 mb-2 mb-lg-0">
								<div class="form-dropcontainer position-relative" data-name="Марка" data-list="brands">
									<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="brands">
										<span>Марка</span>
										<div class="before"></div>
										<div class="after"></div>
									</div>
									<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-list="brands" data-children="models" data-multiple="true">
										<div class="form-droplist-container h-100">
											<?php foreach ( ($arResult['FILTER']['dropLists']['brands'] ?? []) as $k => $item ) { ?>
												<?php if ( $item['code'] != 'none' ) { ?>
												<a href="#" 
													class="form-droplist-item py-1 ps-4 d-block text-decoration-none text-uppercase"
													data-name="brand"
													data-list="brands"
													data-value="<?= $item['code'];?>"
													data-indx="<?= $k;?>"
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
								<div class="form-dropcontainer position-relative" data-name="Модель" data-list="models">
									<div class="bg-yalightgray form-dropdown d-flex justify-content-between position-relative cursor-pointer" data-list="models">
										<span>Модель</span>
										<div class="before"></div>
										<div class="after"></div>
									</div>
									<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-list="models" data-multiple="true">
										<div class="form-droplist-container h-100"></div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 mb-2 mb-lg-0">
								<?php 
									$range = $arResult['FILTER']['ranges']['price'] ?? []; 
									$range['code'] = 'price';
									$range['name'] = 'Цена';
									$range['unit'] = '₽';
									$range['format'] = true;
									$range['range'] = ( $range['max']-$range['min'] ) ?: 1;
								?>
								<div class="bg-yalightbluegray range-row position-relative" data-range="<?= $range['code'];?>" role="view">
									<span class="range-title-from position-absolute c-yadarkgray"><?= $range['name'];?> от</span>
									<span class="range-title-to position-absolute c-yadarkgray">до</span>
									<?php if ( $range['unit'] ) { ?>
									<span class="range-title-param position-absolute c-yadarkgray"><?= $range['unit'];?></span>
									<?php } ?>
									<div class="range-view">
										<input 
											type="text" 
											name="min" 
											value="<?= (($range['format'])?number_format($range['value'][0], 0, '.', ' '):$range['value'][0]);?>"
											/> 
										<input 
											type="text" 
											name="max" 
											value="<?= (($range['format'])?number_format($range['value'][1], 0, '.', ' '):$range['value'][1]);?>"
											class="ps-2 b-l-yagray text-end"
											/>
									</div>
								</div>
								<div class="range" data-range="<?= $range['code'];?>" role="range">
									<div class="range-slider">
										<span 
											class="range-selected"
											data-min="<?= $range['value'][0];?>"
											data-max="<?= $range['value'][1];?>"
											data-url-flag="<?= $range['url_flag'];?>"
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
							<div class="col-lg-4 mt-4 mt-lg-5" role="link">
								<a href="/cars/new/" class="d-block b-radius-yaradius15 bg-yayellow bg-h-yadarkyellow py-3 text-center c-yablack c-h-yablack text-decoration-none text-normal">
									Показать <span><?= number_format((int)$arResult['COUNTS']['NEW'], 0, '.', ' ');?></span> авто
								</a>
							</div>
						</form>
					</div>
					<div class="main-filter-tabs-content-wrap w-100 d-none" role="main-filter-tab-content" data-action="trade-in">
						<?$APPLICATION->IncludeComponent(
							"bitrix:form.result.new", 
							"form.main.filter", 
							array(
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"CHAIN_ITEM_LINK" => "",
								"CHAIN_ITEM_TEXT" => "",
								"COMPONENT_TEMPLATE" => "form.main.filter",
								"EDIT_URL" => "result_edit.php",
								"IGNORE_CUSTOM_TEMPLATE" => "N",
								"LIST_URL" => "result_list.php",
								"SEF_MODE" => "N",
								"SUCCESS_URL" => "",
								"USE_EXTENDED_ERRORS" => "N",
								"WEB_FORM_ID" => "19",
								"COMPOSITE_FRAME_MODE" => "A",
								"COMPOSITE_FRAME_TYPE" => "AUTO",
								"DEALERSHIP" => "",
								"TITLE" => "Оценить автомобиль",
								"VARIABLE_ALIASES" => array(
									"WEB_FORM_ID" => "WEB_FORM_ID",
									"RESULT_ID" => "RESULT_ID",
								)
							),
							false
						);?>
					</div>
					<div class="main-filter-tabs-content-wrap w-100 d-none" role="main-filter-tab-content" data-action="service">
						<?$APPLICATION->IncludeComponent(
							"bitrix:form.result.new", 
							"form.main.filter", 
							array(
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"CHAIN_ITEM_LINK" => "",
								"CHAIN_ITEM_TEXT" => "",
								"COMPONENT_TEMPLATE" => "form.main.filter",
								"EDIT_URL" => "result_edit.php",
								"IGNORE_CUSTOM_TEMPLATE" => "N",
								"LIST_URL" => "result_list.php",
								"SEF_MODE" => "N",
								"SUCCESS_URL" => "",
								"USE_EXTENDED_ERRORS" => "N",
								"WEB_FORM_ID" => "18",
								"COMPOSITE_FRAME_MODE" => "A",
								"COMPOSITE_FRAME_TYPE" => "AUTO",
								"DEALERSHIP" => "",
								"TITLE" => "Запись на ТО",
								"VARIABLE_ALIASES" => array(
									"WEB_FORM_ID" => "WEB_FORM_ID",
									"RESULT_ID" => "RESULT_ID",
								)
							),
							false
						);?>
					</div>
				</div>
				<div class="d-none d-lg-block main-filter brands-on-main b-radius-yaradius-16 bg-yawhite px-4 py-3">
					<div class="row mb-3">
						<div class="col">
							<div class="row brands-on-main-title">
								<div class="col-9">
									<div class="h3 block-title">Новые автомобили в наличии</div>
									<a href="#" role="top-menu-cities" class="c-yadarkgray c-h-yablack">в <?= ($arResult['FILTER']['in_city'] ?? '');?></a>
								</div>
								<div class="col-3 d-flex justify-content-end align-items-center text-minus">
									<a href="/cars/new/" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
										Все марки
										<div class="info-arrow d-inline-block ms-2"></div>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class=" brands-on-main-items text-minus">
						<?php $brands = $arResult['FILTER']['dropLists']['brands'] ?? []; ?>
						<?php foreach ( (array_chunk($brands, 14)[0] ?? []) as $k => $item ) { ?>
						<div class="">
							<a href="<?= $item['path'];?>/" class="c-yablack c-h-yadarkgray text-uppercase d-flex justify-content-between align-items-center text-decoration-none ">
								<span><?= $item['name'];?></span>
								<span class="count me-2"><?= $item['vehicles'];?></span>
							</a>
						</div>
						<?php } ?>
						<div class="">
							<a 
								href="#brands" 
								data-remodal-target="brands"
								class="c-yadarkgray c-h-yadarkgray text-decoration-none"
								>
								Все марки <span class="ms-3"><img src="<?= $templateFolder;?>/images/svg/icon-main-filter-triangle-down.svg?<?= md5_file($templateFolder.'/images/svg/icon-main-filter-triangle-down.svg');?>" /></span>
							</a>
						</div>
					</div>
					<div class="remodal remodal-big p-5 text-start b-radius-yaradius-16" data-remodal-id="brands">
						<button data-remodal-action="close" class="remodal-close"></button>
						<div class="row mb-3">
							<div class="col">
								<div class="row brands-on-main-title">
									<div class="col-12">
										<div class="h3 block-title">Новые автомобили в наличии</div>
										<a href="#" role="top-menu-cities" class="c-yadarkgray c-h-yablack">в <?= ($arResult['FILTER']['in_city'] ?? '');?></a>
									</div>
								</div>
							</div>
						</div>
						<div class="row brands-on-main-items text-minus mb-5">
							<?php $brands = $arResult['FILTER']['dropLists']['brands'] ?? []; ?>
							<?php foreach ( $brands as $k => $item ) { ?>
							<div class="col-3 py-1">
								<a href="<?= $item['path'];?>/" class="c-yablack c-h-yadarkgray text-uppercase d-flex justify-content-between align-items-center text-decoration-none ">
									<span><?= $item['name'];?></span>
									<span class="count me-3"><?= $item['vehicles'];?></span>
								</a>
							</div>
							<?php } ?>
						</div>
						<div class="row">
							<div class="col">
								<div class="row brands-on-main-title">
									<div class="col-12 d-flex justify-content-end align-items-center text-minus">
										<a href="/cars/new/" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
											Витрина
											<div class="info-arrow d-inline-block ms-2"></div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-3 ps-0 d-none d-xl-block main-filter-right">
				<div class="position-relative">
					<div class="swiper-main-stories b-radius-yaradius-16 overflow-hidden">
						<div class="swiper-wrapper">
							<?php foreach ( $arResult['STORIES'] as $item ) { ?>
							<div class="swiper-slide b-radius-yaradius-16 overflow-hidden">
								<a href="<?= (($item['PROPERTY_STORIES_LINK_VALUE'])?:'/offers/'.$item['CODE'].'/');?>">
									<img src="<?= CFile::GetPath($item['PROPERTY_STORIES_DESKTOP_DETAIL_PICTURE_VALUE']);?>" class="w-100" />
								</a>
							</div>
							<?php } ?>
						</div>
						<div class="swiper-pagination"></div>
					</div>
					<div class="swiper-main-stories-button-prev">
						<div class="swiper-main-stories-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-6">
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" class="position-absolute" />
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left-a.svg';?>" class="position-absolute" />
						</div>
					</div>
					<div class="swiper-main-stories-button-next">
						<div class="swiper-main-stories-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-6">
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" class="position-absolute" />
							<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right-a.svg';?>" class="position-absolute" />
						</div>
					</div>
				</div>
			</div>
	</div>
</div>


<script data-skip-moving="true">
	YAPP.MAIN_FILTER = {};
	YAPP.MAIN_FILTER.TAGS = {};
	YAPP.MAIN_FILTER.TAGS.brands = [];
	YAPP.MAIN_FILTER.TAGS.models = [];
	YAPP.MAIN_FILTER.TAGS.price = [];
	YAPP.MAIN_FILTER.brands = [];
	YAPP.MAIN_FILTER.models = [];
	YAPP.MAIN_FILTER.price = [];
	YAPP.MAIN_FILTER.DATA = <?= json_encode($arResult['FILTER'] ?: new stdClass()); ?>
</script>
