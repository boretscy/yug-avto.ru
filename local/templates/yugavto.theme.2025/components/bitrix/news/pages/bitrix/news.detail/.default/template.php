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
<div class="bg-yalightbluegray">
	<div class="container mb-5">
		<div class="row">
			<div class="col-lg-8 d-lg-none mb-3">
				<div class="brand-title-wrap d-flex align-items-center justify-content-between">
					<div class="brand-title-logo d-flex align-items-center justify-content-center p-3 bg-yawhite b-radius-yaradius-16 me-3">
						<img src="<?= CFile::GetPath($arResult['SECTION']['LOGO']);?>" class="w-100" />
					</div>
					<div class="brand-title-content bg-yawhite b-radius-yaradius-16 px-4 bg-yawhite d-flex align-items-center">
						<div>
							<div class="h2 brand"><?= $arResult['SECTION']['NAME'];?></div>
							<div class="h2 model"><?= $arResult['NAME'];?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-8 d-none d-lg-block">
				<div class="p-4 bg-yawhite h-100 d-flex flex-column justify-content-between align-items-start position-relative model model-left">
                    <div class="model-title-content bg-yawhite w-100 d-flex justify-content-between align-items-end p-3">
						<div class="model-title-content-wrap">
							<h1 class="h2 brand"><?= $arResult['SECTION']['NAME'];?></h1>
							<div class="h3 model"><?= $arResult['NAME'];?></div>
						</div>
						<div class="model-title-img-wrap">
							<?php if ($arResult['DETAIL_PICTURE']['SRC']) { ?>
							<img src="<?= $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?>" class="w-100" />
							<?php } elseif ($arResult['PROPERTIES']['EXTERNAL_PICTURE']['VALUE']) { ?>
							<img src="<?= $arResult['PROPERTIES']['EXTERNAL_PICTURE']['VALUE'];?>" alt="<?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?>" class="w-100" />
							<?php } else { ?>
							<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/bodies/<?= ($arResult['PROPERTIES']['BODY']['VALUE_XML_ID'] ?: 'none');?>.webp" alt="<?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?>" class="w-100" />
							<?php } ?>
						</div>
					</div>
                    <div class="model-left-footer position-absolute d-flex">
                        <div class="model-left-footer-right">
                            <div class="model-left-footer-right-bottom">
                                <div class="model-left-footer-right-bottom-wrap">
                                    <div class="model-left-footer-right-bottom-wrap-content bg-yalightbluegray">
                                        <div class="model-left-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 d-flex justify-content-center align-items-center overflow-hidden">
                                            <img src="<?= CFile::GetPath($arResult['SECTION']['LOGO']);?>" alt="" class="w-100" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="model-left-footer-right-top w-100 bg-yalightbluegray">
                                <div class="model-left-footer-right-top-wrap w-100 bg-yawhite"></div>
                            </div>
                        </div>
                        <div class="model-left-footer-left">
                            <div class="model-left-footer-left-wrap bg-yalightbluegray h-100">
                                <div class="model-left-footer-left-wrap-corner bg-yawhite h-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-lg-4 d-flex flex-column align-items-center justify-content-between">
				<?php if ( is_countable($arResult['NEW']) && count($arResult['NEW']) > 0 ) { ?>
				<div class="cis-card-wrap mb-3 w-100 position-relative">
					<div class="cis-card-content bg-yawhite">
						<div class="h3 fw-bold">Новый <?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?></div>
						<a 
							href="/cars/new/<?= $arResult['SECTION']['CODE'];?>/<?= $arItem['CODE'];?>" 
							class="cis-card-content-count w-100 d-flex align-items-center justify-content-start c-yablack c-h-yablack text-decoration-none mb-4">
							<span class="me-2 b-radius-yaradius-8 bg-yadarkgray c-yawhite c-h-yawhite d-flex align-items-center justify-content-center"><?= count($arResult['NEW']);?></span>
							<div>авто в наличии</div>
						</a>
						<a 
							href="#FORM_CREDIT"
							data-remodal-target="FORM_CREDIT"
							alt="<?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?>"
							class="d-block text-decoration-none text-center bg-yalightbluegray bg-h-yayellow c-yablack c-h-yablack text-decoration-none b-radius-yaradius-12 cis-card-button d-flex align-items-center justify-content-center">
							В кредит
						</a>
					</div>
					<div class="cis-card-footer position-absolute d-flex">
						<div class="cis-card-footer-left">
							<div class="cis-card-footer-left-wrap bg-yalightbluegray h-100">
								<div class="cis-card-footer-left-wrap-corner bg-yawhite h-100"></div>
							</div>
						</div>
						<div class="cis-card-footer-right">
							<div class="cis-card-footer-right-top w-100 bg-yalightbluegray">
								<div class="cis-card-footer-right-top-wrap w-100 bg-yawhite"></div>
							</div>
							<div class="cis-card-footer-right-bottom">
								<div class="cis-card-footer-right-bottom-wrap">
									<div class="cis-card-footer-right-bottom-wrap-content bg-yalightbluegray">
										<div class="cis-card-footer-right-bottom-icon b-radius-yaradius-12"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if ( is_countable($arResult['USED']) && count($arResult['USED']) > 0 ) { ?>
				<div class="cis-card-wrap mb-3 w-100 position-relative">
					<div class="cis-card-content bg-yawhite">
						<div class="h3 fw-bold"><?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?> с пробегом</div>
						<a 
							href="/cars/new/<?= $arResult['SECTION']['CODE'];?>/<?= $arItem['CODE'];?>" 
							class="cis-card-content-count w-100 d-flex align-items-center justify-content-start c-yablack c-h-yablack text-decoration-none mb-4">
							<span class="me-2 b-radius-yaradius-8 bg-yadarkgray c-yawhite c-h-yawhite d-flex align-items-center justify-content-center"><?= count($arResult['USED']);?></span>
							<div>авто в наличии</div>
						</a>
						<a 
							href="#FORM_CREDIT"
							data-remodal-target="FORM_CREDIT"
							alt="<?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?>"
							class="d-block text-decoration-none text-center bg-yalightbluegray bg-h-yayellow c-yablack c-h-yablack text-decoration-none b-radius-yaradius-12 cis-card-button d-flex align-items-center justify-content-center">
							В кредит
						</a>
					</div>
					<div class="cis-card-footer position-absolute d-flex">
						<div class="cis-card-footer-left">
							<div class="cis-card-footer-left-wrap bg-yalightbluegray h-100">
								<div class="cis-card-footer-left-wrap-corner bg-yawhite h-100"></div>
							</div>
						</div>
						<div class="cis-card-footer-right">
							<div class="cis-card-footer-right-top w-100 bg-yalightbluegray">
								<div class="cis-card-footer-right-top-wrap w-100 bg-yawhite"></div>
							</div>
							<div class="cis-card-footer-right-bottom">
								<div class="cis-card-footer-right-bottom-wrap">
									<div class="cis-card-footer-right-bottom-wrap-content bg-yalightbluegray">
										<div class="cis-card-footer-right-bottom-icon b-radius-yaradius-12"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if ( $arResult['DEALERSHIPS'] ) { ?>
				<div class="form-group w-100">
					<a 
						href="/dealerships/?brand=<?= $arResult['SECTION']['NAME'];?>" 
						class="d-block b-radius-yaradius-16 bg-yayellow bg-h-yadarkyellow py-3 text-center c-yablack c-h-yablack text-decoration-none text-normal" 
						>Есть в <?= count($arResult['DEALERSHIPS']);?> <?= Yapp::getWorld(count($arResult['DEALERSHIPS']), 'dealership_pr');?></a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>


<?php if ( !empty($arResult['NEW']) || !empty($arResult['USED']) ) { ?>
<div class="my-5 model-cis">
	<div class="container">
		<div class="row">
			<div class="col-lg-5">
				<div class="d-flex model-cis-tabs">
					<?php if ($arResult['NEW']) { ?>
					<div class="model-cis-tabs-item b-yawhite cursor-pointer flex-fill active d-flex justify-content-center align-items-center" role="model-cis-tab" data-action="new">
						<span>Новые авто</span>
					</div>
					<?php } ?>
					<?php if ($arResult['USED']) { ?>
					<div class="model-cis-tabs-item b-yawhite cursor-pointer flex-fill <?= ((!$arResult['NEW'])?'active':'');?> d-flex justify-content-center align-items-center" role="model-cis-tab" data-action="used">
						<span>Авто с пробегом</span>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="model-cis-content bg-yawhite p-4">
					<?php if ( !empty($arResult['NEW']) ) $v['new'] = $arResult['NEW'];?>
					<?php if ( !empty($arResult['USED']) ) $v['used'] = $arResult['USED'];?>
					<?php foreach ( $v as $entity => $vehicles ) { ?>
					
					<div class="model-cis-content-wrap row position-relative <?= ((count($v)>1&&$entity=='used')?'d-none':'');?> pb-5" data-action="<?= $entity;?>">
						<div class="row mb-4">
							<div class="col-lg-9 d-flex justify-content-start align-items-center">
								<h2 class="fw-bold text-uppercase ps-2 ps-lg-0">Автомобили <?= $arResult['SECTION']['NAME'];?> <?= $arResult['NAME'];?> в наличии</h2>
							</div>
							<div class="col-lg-3 d-flex justify-content-lg-end align-items-center text-minus">
								<a href="/cars/<?= $entity;?>/<?= $arResult['SECTION']['CODE'];?>/<?= $arItem['CODE'];?>" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
									Смотреть все
									<div class="info-arrow d-inline-block ms-2"></div>
								</a>
							</div>
						</div>
						
						<div class="col">
							<div class="swiper-model-cis swiper-model-cis-<?= $entity;?> overflow-hidden">
								<div class="swiper-wrapper">
								
								<?php $vehicleMode = $entity; ?>
								<?php foreach ( $vehicles as $k => $item ) { ?>
									<?php include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/include/item_vehicle.php'; ?>
								<?php } ?>
								</div>
								<div class="swiper-pagination"></div>
							</div>
							<div class="swiper-model-cis-button-prev swiper-model-cis-button-prev-<?= $entity;?>">
								<div class="swiper-model-cis-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" class="position-absolute" />
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left-a.svg';?>" class="position-absolute" />
								</div>
							</div>
							<div class="swiper-model-cis-button-next swiper-model-cis-button-next-<?= $entity;?>">
								<div class="swiper-model-cis-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" class="position-absolute" />
									<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right-a.svg';?>" class="position-absolute" />
								</div>
							</div>
						</div>
					</div>
					<script>
						YAPP.SwiperVehicles_<?= $entity;?> = new Swiper('.swiper-model-cis-<?= $entity;?>', {
							pagination: {
								el: ".swiper-pagination",
								type: "fraction",
							},
							navigation: {
								nextEl: '.swiper-model-cis-button-next-<?= $entity;?>',
								prevEl: '.swiper-model-cis-button-prev-<?= $entity;?>',
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
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

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