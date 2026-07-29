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

<?php if ( empty($arResult['ITEMS']) ) { ?>
	<div class="container my-4 text-center">
		<div class="row">
			<div class="col">
				<p class="h2 fw-normal c-yamiddlegray">Ничего не найдено</p>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="container my-4">
		<div class="row">
			<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
			<?php
				$arItem['__NAME'] = str_replace("Юг-Авто", "<span style='white-space: nowrap;'>Юг-Авто</span>", $arItem['NAME']);
			?>
			<div class="col-md-6 col-xl-4 mb-4 news-item">
				<div class="bg-yalightbluegray b-radius-yaradius-16 overflow-hidden text-start w-100">
					<a 
						href="<?= $arItem['DETAIL_PAGE_URL'];?>"
						class="a-image d-block">
						<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?= $arItem['NAME'];?>" class="w-100">
					</a>
					<div class="p-4">
						<div class="row my-3 с-yadarkgray fw-normal">
							<div class="col">
								<?php if ( $arItem['DISPLAY_ACTIVE_FROM'] ) { ?>
								<span class="text-minus c-yadarkgray">
									<?= date('d.m.Y', strtotime($arItem['DISPLAY_ACTIVE_FROM']));?>
								</span>
								<?php } ?>
							</div>
						</div>
						<a 
							href="<?= $arItem['DETAIL_PAGE_URL'];?>" title="<?= $arItem['NAME'];?>"
							class="c-yablack c-h-yablack text-decoration-none news-item-title fw-bold d-flex justify-content-between align-items-start block-title-link"
							>
							<span class="title"><?= $arItem['__NAME'];?></span>
							<div class="info-arrow d-inline-block ms-3"></div>
						</a>
					</div>
				</div>
			</div>
			<?php } // foreach ITEMS ?>
		</div>
	</div>
	<?php if ( $arParams["DISPLAY_BOTTOM_PAGER"] ) { ?>
	<div class="container my-5 text-minus text-center">
		<div class="row">
			<div class="col"><?= $arResult["NAV_STRING"];?></div>
		</div>
	</div>
	<?php } // if PAGES >?>
<?php } // if ITEMS ?>