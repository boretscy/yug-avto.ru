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
<footer class="c-yalightgray bg-yadarkbluegray py-5 text-minus" itemscope itemtype="https://schema.org/WPFooter">
	<div class="container">
		
		<!-- Footer SEO -->
		<?php if ( $arResult['SEO_TEXT'] ) { ?>
		<div class="row">
			<div class="col footer-seo">
				<div class="footer-seo-text mb-3">
					<?= $arResult['SEO_TEXT'];?>
				</div>
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" role="footer-seo-expand">
					Читать далее
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" style="display: none;" role="footer-seo-collapse">
					Свернуть
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-up"></use></svg>
				</a>
			</div>
		</div>
		<div class="row py-3"><div class="col"><hr /></div></div>
		<!-- // Footer SEO -->
		<?php } ?>

		<!-- Footer BRANDS -->
		<div class="row">
			<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Автомобили</div>
			<?php foreach ( $arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE'] as $arItem ) { ?>
			<div class="col-6 col-lg-3 my-1">
				<a href="/brands/<?= $arItem['CODE'];?>/" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $arItem['NAME'];?></a>
			</div>
			<?php } // foerach BRANDS ?>
		</div>
		<!-- // Footer BRANDS -->

		<div class="row py-3"><div class="col"><hr /></div></div>

		<div class="row py-3">
			<div class="col-12 col-lg-6">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Услуги</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_SERVICES']['VALUE'] as $k => $item ) { ?>
						<div class="col-6 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_SERVICES']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICES ?>
				</div>
			</div>
			<div class="col-12 py-3 mobile"><hr /></div>
			<div class="col-12 col-lg-6">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Сервис</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_SERVICE']['VALUE'] as $k => $item ) { ?>
						<div class="col-6 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_SERVICE']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICE ?>
				</div>
			</div>
		</div>
		
		<div class="row py-3"><div class="col"><hr /></div></div>

		<div class="row py-3">
			<div class="col-12 col-lg-6">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Компания</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_COMPANY']['VALUE'] as $k => $item ) { ?>
						<div class="col-6 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_COMPANY']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICES ?>
				</div>
			</div>
			<div class="col-12 py-3 mobile"><hr /></div>
			<div class="col-12 col-lg-6">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Информация</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_INFO']['VALUE'] as $k => $item ) { ?>
						<div class="col-12 col-md-6 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_INFO']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICE ?>
				</div>
			</div>
		</div>

		<div class="row py-3"><div class="col"><hr /></div></div>

		<div class="row py-3">
			<div class="col-lg-3 col-md-3 mb-3 mb-md-0 pt-2 text-center text-md-start">
				<a href="/" class="text-decoration-none">
					<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/footer-logo.2023.svg" alt="Юг-Авто">
				</a>
				<p class="mt-3">&copy; <span itemprop="copyrightHolder" itemscope itemtype="https://schema.org/Organization"><span itemprop="name">Юг-Авто</span></span> <span itemprop="copyrightYear"><?= date('Y');?></span><br />Все права защищены</p>
			</div>
			<?php /*
			<!-- <div class="col-lg-3 col-md-3 mb-3 mb-md-0 text-center">
				<a href="#FORM_QUESTIONBACK" data-form="FORM_QUESTIONBACK" class="d-block text-center c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius15 py-3 px-4 ">Написать письмо</a>
			</div> -->
			*/ ?>
			<div class="col-lg footer-social mb-3 mb-md-0 pt-1 text-center">
				<?php foreach ( $arResult['PROPERTIES']['SOCIAL']['VALUE'] as $k => $item ) { ?>
				<a href="<?= $item;?>" class="text-decoration-none d-inline-block bg-yalightgray bg-h-yawhite me-3 text-center" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?= $arResult['PROPERTIES']['SOCIAL']['DESCRIPTION'][$k];?>"></use></svg>
				</a>
				<?php } // foreach SOCIAL ?>
			</div>
		</div>

		<div class="row py-3">
			<div class="col footer-disclamer">
				<div class="footer-disclamer-text mb-3">	
					<?= $arResult['PREVIEW_TEXT'];?>
				</div>
				<?php /*
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" role="footer-disclamer-expand">
					Читать далее
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" style="display: none;" role="footer-disclamer-collapse">
					Свернуть
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-up"></use></svg>
				</a>
				*/ ?>
			</div>
		</div>

	</div>
</footer>

<div class="cookie bg-yablack c-yagray p-3 position-fixed w-100 bottom-0 text-minus-minus">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-9 text-center text-md-start"><?= $arResult['PROPERTIES']['COOKIE']['~VALUE']['TEXT'];?></div>
			<div class="col-12 col-md-3 d-flex justify-content-center justify-content-md-end align-items-center pt-3 pt-md-0">
				<a href="#" role="close-cookie" class="text-center c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius15 py-2 px-4">Я согласен</a>
			</div>
		</div>
	</div>
</div>
<?php /*
<!-- 
<div class="up-button d-none d-xl-flex justify-content-center align-items-center position-fixed b-radius-yaradius-8 cursor-pointer">
	<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/arrow-top-white.svg';?>" />
</div> -->
*/ ?>