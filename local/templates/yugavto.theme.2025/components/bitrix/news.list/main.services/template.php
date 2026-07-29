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

<div class="container my-5">
	<div class="row mb-4">
		<div class="col">
			<h2 class="h2 fw-bold text-uppercase ps-2 ps-lg-0">Сервисы Юг-Авто</h2>
		</div>
	</div>
	<div class="row">
		<?php foreach ( $arResult['ITEMS'] as $k => $arItem ) { ?>	
		<a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>" 
		   class="col-md-6 mb-3 mb-md-0 d-block text-decoration-none services-item"
		>
			<div class="bg-yalightbluegray p-4 b-radius-yaradius-16 h-100">
				<div class="row h-100">
					<div class="col-lg-5 d-flex align-items-center">
						<img src="<?= CFile::GetPath($arItem['PROPERTIES']['IMAGE']['VALUE']);?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" class="w-100" />
					</div>
					<div class="col-lg-7 d-flex flex-column justify-content-between services-item-info">
						<h3 class="c-yablack c-h-yablack fw-bold"><?= $arItem['NAME'];?></h3>
						<div class="services-yug-avto-list c-yadarkgray c-h-yadarkgray"><?= $arItem['DETAIL_TEXT'];?></div>
						<div class="d-flex justify-content-between align-items-center block-title-link w-100">
							<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" />
							<div class="info-arrow d-inline-block ms-2"></div>
						</div>
					</div>
				</div>
			</div>
		</a>
		<?php } ?>
	</div>
</div>