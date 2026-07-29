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
<?php if ( $arResult['ITEMS'] ) { ?>

<div class="container main-news my-5">
	<div class="row">
		<div class="col">
			<div class="bg-yawhite b-radius-yaradius-16 p-4">
				<div class="row mb-4">
					<div class="col-lg-9 d-flex justify-content-start align-items-center mb-2 mb-lg-0">
						<h2 class="fw-bold text-uppercase"><?= $arParams['DISPLAY_TITLE'];?></h2>
					</div>
					<div class="col-lg-3 d-flex justify-content-lg-end align-items-center">
						<a href="<?= $arResult['LIST_PAGE_URL'];?>" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
							<?= $arParams['ALL_LINK'];?>
							<div class="info-arrow d-inline-block ms-2"></div>
						</a>
					</div>
				</div>
				<div class="row position-relative">
					<div class="col">
						<div class="swiper-news-on-main pb-5 overflow-hidden">
							<div class="swiper-wrapper">
								<!-- Slides -->
								<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
									<?php
										$arItem['__NAME'] = str_replace("Юг-Авто", "<span style='white-space: nowrap;'>Юг-Авто</span>", $arItem['NAME']);
									?>
								<div class="swiper-slide d-flex" data-tag='<?= json_encode($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']);?>'>
									<div class="bg-yalightbluegray b-radius-yaradius-16 overflow-hidden text-start w-100">
										<a 
											href="<?= $arItem['DETAIL_PAGE_URL'];?>"
											class="a-image d-block">
											<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" class="w-100">
										</a>
										<div class="p-4">
											<p class="text-minus c-yadarkgray text-start">
												<?php if ($arItem['DISPLAY_ACTIVE_FROM']) { ?>
												<?= $arItem['DISPLAY_ACTIVE_FROM'];?>
												<?php } ?>
											</p>
											<a 
												href="<?= $arItem['DETAIL_PAGE_URL'];?>" title="<?= $arItem['NAME'];?>"
												class="c-yablack c-h-yablack text-decoration-none swiper-news-on-main-item-title fw-bold d-flex justify-content-between align-items-start block-title-link"
												>
												<span class="title"><?= $arItem['__NAME'];?></span>
												<div class="info-arrow d-inline-block ms-3"></div>
											</a>
										</div>
									</div>
								</div>
								<?php } // foreasch ITEMS ?>
							</div>
							<div class="swiper-pagination"></div>
						</div>
						
						<div class="swiper-news-on-main-button-prev">
							<div class="swiper-news-on-main-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
								<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" class="position-absolute" />
								<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left-a.svg';?>" class="position-absolute" />
							</div>
						</div>
						<div class="swiper-news-on-main-button-next">
							<div class="swiper-news-on-main-button-wrap position-relative d-flex justify-content-center align-items-center b-radius-yaradius-12">
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


<?php } ?>