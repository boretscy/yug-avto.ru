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
<div class="container mt-4">
	<div class="row">
		<div class="col">
			<h1 class="h2 text-uppercase block-title"><?= $arResult['NAME'];?></h1>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col">
			<div class="history bg-yawhite b-radius-yaradius-16 p-4 pe-lg-5">
				<div class="header position-relative"><div class="triangle position-absolute"></div></div>
				<div class="delimiter position-relative"><div class="delimiter-bg position-absolute bg-yayellow h-100"></div></div>

				<?php  $i = 1; foreach ( $arResult['ITEMS'] as $arSection ) {?>
					<div class="title">
						<div class="title-wrap <?= (($i<=2||$i==count($arResult['ITEMS']))?'active':'');?> d-flex justify-content-between align-items-center b-radius-yaradius-12 cursor-pointer" data-group="<?= $arSection['NAME'];?>" role="historyGroup">
							<div class="title-icon b-radius-yaradius-10"></div>
							<div class="title-content fw-bold"><?= $arSection['NAME'];?></div>
						</div>
					</div>
					<?php foreach ( $arSection['ITEMS'] as $k => $arItem ) { ?>
					<div class="item-wrap <?= (($i<=2||$i==count($arResult['ITEMS']))?'':'d-none');?>" data-group="<?= $arSection['NAME'];?>" role="historyItem" data-indx="<?= $k;?>">
						<div class="delimiter position-relative"><div class="delimiter-bg position-absolute bg-yayellow"></div></div>
						<div class="item d-flex justify-content-between">
							<div class="item-left position-relative d-flex justify-content-center align-items-center <?= (($i==count($arResult['ITEMS'])&&$k+1==count($arSection['ITEMS']))?'item-end':'');?>">
								<div class="delimiter-bg position-absolute <?= (($i==count($arResult['ITEMS'])&&$k+1==count($arSection['ITEMS']))?'bg-yahalfyellow':'bg-yayellow');?>"></div>
								<img src="<?= $templateFolder.'/images/svg/icon-'.(($arItem['PROPERTIES']['ICON']['VALUE_XML_ID'])?:'point').'.svg?2';?>" alt="" title="" />
							</div>
							<div class="item-right position-relative bg-yalightbluegray d-flex flex-column flex-lg-row justify-content-between justify-content-lg-start align-items-start">
								<div class="flex-fill d-flex justify-content-start align-items-center mb-3 mb-lg-0">
									<?php foreach ( $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'] as $arBrand ) { ?>
									<img class="b-radius-yaradius-16 me-4" src="<?= CFile::GetPath($arBrand['PREVIEW_PICTURE']);?>" alt="Логотип <?= htmlspecialchars(YApp::getCleanAltText($arBrand['NAME']));?>" title="Логотип <?= htmlspecialchars(YApp::getCleanAltText($arBrand['NAME']));?>" />
									<?php } // foreach BRANDS ?>
									<?php foreach ( $arItem['PROPERTIES']['OLD_BRAND']['VALUE'] as $item ) { ?>
									<img class="b-radius-yaradius-16 me-4" src="<?= CFile::GetPath($item);?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" />
									<?php } // if OLD LOGO ?>
									<div class="item-right-content d-flex justify-content-start align-items-center"><?= $arItem['~NAME'];?></div>
								</div>
								<a 
									href="tel:+78612032729" 
									class="item-right-button b-radius-yaradius-16 bg-yawhite bg-h-yayellow c-yablack c-h-yawhite d-none d-xl-flex justify-content-center align-items-center px-4 text-decoration-none fw-bold"
									>+7 (861) 203-27-29</a>
								<div class="item-right-footer position-absolute d-flex">
									<div class="item-right-footer-left">
										<div class="item-right-footer-left-wrap bg-yawhite h-100">
											<div class="item-right-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
										</div>
									</div>
									<div class="item-right-footer-right">
										<div class="item-right-footer-right-top w-100 bg-yawhite">
											<div class="item-right-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
										</div>
										<div class="item-right-footer-right-bottom">
											<div class="item-right-footer-right-bottom-wrap">
												<div class="item-right-footer-right-bottom-wrap-content d-flex bg-yawhite">
													<a 
														href="tel:+78612032729" 
														target="_blank"
														class="item-right-footer-right-bottom-icon b-radius-yaradius-12 bg-yalightbluegray d-xl-none phone-link"></a>
													<?php foreach ( $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $dc) { ?>
													<a 
														href="https://yandex.ru/maps/?ll=<?= $dc['COORDS']['LON'];?>,<?= $dc['COORDS']['LAT'];?>&z=15&mode=routes&rtext=~<?= $dc['COORDS']['LAT'];?>,<?= $dc['COORDS']['LON'];?>&rtt=auto&ruri=~" 
														target="_blank"
														class="item-right-footer-right-bottom-icon b-radius-yaradius-12 bg-yalightbluegray d-block route-link"></a>
													<?php } ?>
													<?php 
														if ( is_countable($arItem['SITES']) && count($arItem['SITES']) > 1 ) {
															$link = '#site-'.$arItem['ID'].'_'.$arSection['NAME'];
														} else {
															$link = $arItem['SITES'][0];
														}
													?>
													<?php if ( $link ) { ?>
													<a 
														href="<?= $link;?>" 
														target="_blank"
														class="item-right-footer-right-bottom-icon b-radius-yaradius-12 bg-yalightbluegray d-block site-link"></a>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if ( $arSection['NAME'] != '1997') { ?>
						<div class="delimiter position-relative"><div class="delimiter-bg position-absolute bg-yayellow"></div></div>
						<?php } ?>
					</div>
					<?php } ?>
					<div class=" delimiter-sm position-relative <?= (($i<=2||$i==count($arResult['ITEMS']))?'d-none':'');?>" data-group="<?= $arSection['NAME'];?>" role="historyItem"><div class="delimiter-bg position-absolute bg-yayellow"></div></div>
				<?php $i++; } ?>
			</div>
		</div>
	</div>
</div>