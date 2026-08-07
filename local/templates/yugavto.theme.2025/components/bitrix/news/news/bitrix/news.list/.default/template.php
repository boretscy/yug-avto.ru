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
	<div class="container my-4" itemscope itemtype="http://schema.org/Blog">
		<meta itemprop="description" content="Новости Юг-Авто — свежие новости компании и автосалонов в Краснодаре">
		<div class="row">
			<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
			<?php
				$arItem['__NAME'] = str_replace("Юг-Авто", "<span style='white-space: nowrap;'>Юг-Авто</span>", $arItem['NAME']);
				$detailUrl = (strpos($arItem['DETAIL_PAGE_URL'], 'http') === 0) ? $arItem['DETAIL_PAGE_URL'] : $host . $arItem['DETAIL_PAGE_URL'];
				$pictureUrl = !empty($arItem['PREVIEW_PICTURE']['SRC']) ? ((strpos($arItem['PREVIEW_PICTURE']['SRC'], 'http') === 0) ? $arItem['PREVIEW_PICTURE']['SRC'] : $host . $arItem['PREVIEW_PICTURE']['SRC']) : '';
				$dateIso = !empty($arItem['DISPLAY_ACTIVE_FROM']) ? date('c', strtotime($arItem['DISPLAY_ACTIVE_FROM'])) : date('c');
				$dateYmd = !empty($arItem['DISPLAY_ACTIVE_FROM']) ? date('Y-m-d', strtotime($arItem['DISPLAY_ACTIVE_FROM'])) : date('Y-m-d');
				$previewText = !empty($arItem['PREVIEW_TEXT']) ? strip_tags($arItem['PREVIEW_TEXT']) : htmlspecialchars($arItem['NAME']);
			?>
			<div class="col-md-6 col-xl-4 mb-4 news-item" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">
				<div class="bg-yalightbluegray b-radius-yaradius-16 overflow-hidden text-start w-100">
					<a 
						href="<?= $arItem['DETAIL_PAGE_URL'];?>"
						class="a-image d-block">
						<img itemprop="image" src="<?= !empty($pictureUrl) ? $pictureUrl : $logoUrl;?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" class="w-100">
					</a>
					<div class="p-4">
						<div class="row my-3 с-yadarkgray fw-normal">
							<div class="col">
								<?php if ( $arItem['DISPLAY_ACTIVE_FROM'] ) { ?>
								<time itemprop="datePublished" datetime="<?= $dateYmd;?>" class="text-minus c-yadarkgray">
									<?= date('d.m.Y', strtotime($arItem['DISPLAY_ACTIVE_FROM']));?>
								</time>
								<?php } ?>
							</div>
						</div>
						<a 
							href="<?= $arItem['DETAIL_PAGE_URL'];?>" title="<?= htmlspecialchars($arItem['NAME']);?>"
							class="c-yablack c-h-yablack text-decoration-none news-item-title fw-bold d-flex justify-content-between align-items-start block-title-link"
							>
							<h2 itemprop="headline" class="title h6 m-0 fw-bold"><?= $arItem['__NAME'];?></h2>
							<div class="info-arrow d-inline-block ms-3"></div>
						</a>
						<p itemprop="description" class="d-none"><?= htmlspecialchars($previewText);?></p>
						<p itemprop="articleBody" class="d-none"><?= htmlspecialchars($previewText);?></p>
						<div itemprop="author" itemscope itemtype="https://schema.org/Organization" class="d-none"><meta itemprop="name" content="Юг-Авто"></div>
						<meta itemprop="dateModified" content="<?= $dateIso;?>">
						<meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?= $detailUrl;?>"/>
						<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" class="d-none">
							<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
								<img itemprop="url" src="<?= $logoUrl;?>" alt="Юг-Авто" />
							</div>
							<link itemprop="url" href="<?= $host;?>/">
							<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
								<span itemprop="postalCode">350000</span>,
								<span itemprop="addressCountry">Россия</span>, 
								<span itemprop="addressRegion">Краснодарский край</span>, 
								<span itemprop="addressLocality">Краснодар</span>, 
								<span itemprop="streetAddress">ул. Уральская, 98/11</span>
							</div>
							<div>Телефон: <a href="tel:+78612031405"><span itemprop="telephone">+7 (861) 203-14-05</span></a></div>
							<div>Почта: <a href="mailto:info@yug-avto.ru"><span itemprop="email">info@yug-avto.ru</span></a></div>
							<meta itemprop="name" content="Юг-Авто">
						</div>
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