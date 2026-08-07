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

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $protocol . "://" . ($_SERVER['HTTP_HOST'] ?? 'htest.yug-avto.ru');
$logoUrl = $host . '/local/templates/yugavto.theme.2025/assets/images/svg/logo.svg';
?>
<?php if ( $arResult['ITEMS'] ) { ?>

<div class="container main-news my-5" itemscope itemtype="http://schema.org/Blog">
	<meta itemprop="description" content="<?= htmlspecialchars($arParams['DISPLAY_TITLE'] ?: 'Новости Юг-Авто');?>">
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
										$detailUrl = (strpos($arItem['DETAIL_PAGE_URL'], 'http') === 0) ? $arItem['DETAIL_PAGE_URL'] : $host . $arItem['DETAIL_PAGE_URL'];
										$pictureUrl = !empty($arItem['PREVIEW_PICTURE']['SRC']) ? ((strpos($arItem['PREVIEW_PICTURE']['SRC'], 'http') === 0) ? $arItem['PREVIEW_PICTURE']['SRC'] : $host . $arItem['PREVIEW_PICTURE']['SRC']) : $logoUrl;
										$dateIso = !empty($arItem['DISPLAY_ACTIVE_FROM']) ? date('c', strtotime($arItem['DISPLAY_ACTIVE_FROM'])) : date('c');
										$dateYmd = !empty($arItem['DISPLAY_ACTIVE_FROM']) ? date('Y-m-d', strtotime($arItem['DISPLAY_ACTIVE_FROM'])) : date('Y-m-d');
										$previewText = !empty($arItem['PREVIEW_TEXT']) ? strip_tags($arItem['PREVIEW_TEXT']) : htmlspecialchars($arItem['NAME']);
									?>
								<div class="swiper-slide d-flex" data-tag='<?= json_encode($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']);?>' itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">
									<div class="bg-yalightbluegray b-radius-yaradius-16 overflow-hidden text-start w-100">
										<a 
											href="<?= $arItem['DETAIL_PAGE_URL'];?>"
											class="a-image d-block">
											<img itemprop="image" src="<?= $pictureUrl;?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" class="w-100">
										</a>
										<div class="p-4">
											<p class="text-minus c-yadarkgray text-start">
												<?php if ($arItem['DISPLAY_ACTIVE_FROM']) { ?>
												<time itemprop="datePublished" datetime="<?= $dateYmd;?>"><?= $arItem['DISPLAY_ACTIVE_FROM'];?></time>
												<?php } ?>
											</p>
											<a 
												href="<?= $arItem['DETAIL_PAGE_URL'];?>" title="<?= htmlspecialchars($arItem['NAME']);?>"
												class="c-yablack c-h-yablack text-decoration-none swiper-news-on-main-item-title fw-bold d-flex justify-content-between align-items-start block-title-link"
												>
												<h3 itemprop="headline" class="title h6 m-0 fw-bold"><?= $arItem['__NAME'];?></h3>
												<div class="info-arrow d-inline-block ms-3"></div>
											</a>
											<p itemprop="description" class="d-none"><?= htmlspecialchars($previewText);?></p>
											<p itemprop="articleBody" class="d-none"><?= htmlspecialchars($previewText);?></p>
											<meta itemprop="author" content="Юг-Авто">
											<meta itemprop="dateModified" content="<?= $dateIso;?>">
											<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?= $detailUrl;?>"/>
											<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" class="d-none">
												<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
													<img itemprop="url image" src="<?= $logoUrl;?>" alt="Юг-Авто" />
												</div>
												<link itemprop="url" href="<?= $host;?>/">
												<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
													<span itemprop="postalCode">350000</span>,
													<span itemprop="addressCountry">Россия</span>, 
													<span itemprop="addressRegion">Краснодарский край</span>, 
													<span itemprop="addressLocality">Краснодар</span>, 
													<span itemprop="streetAddress">ул. Уральская, 98/11</span>
												</div>
												<div>Телефон: <a itemprop="telephone" href="tel:+78612031405">+7 (861) 203-14-05</a></div>
												<div>Почта: <a href="mailto:info@yug-avto.ru"><span itemprop="email">info@yug-avto.ru</span></a></div>
												<meta itemprop="name" content="Юг-Авто">
											</div>
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