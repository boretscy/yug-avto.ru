<?php	
	// Search API proxy — handle before any output
	$requestUri = $_SERVER['REQUEST_URI'] ?? '';
	if (preg_match('#^/api/search/render/?$#', $requestUri) && $_SERVER['REQUEST_METHOD'] === 'POST') {
		$query = $_POST['query'] ?? '';
		if (!$query) {
			$input = json_decode(file_get_contents('php://input'), true);
			$query = $input['query'] ?? '';
		}
		if ($query) {
			$goUrl = 'http://127.0.0.1:8080/api/v1/cis/search';
			$ch = curl_init($goUrl);
			curl_setopt_array($ch, [
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => json_encode(['query' => $query]),
				CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 10,
			]);
			$resp = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpCode == 200) {
				echo $resp;
			} else {
				http_response_code(502);
				echo json_encode(['error' => 'search backend error', 'code' => $httpCode]);
			}
		} else {
			http_response_code(400);
			echo json_encode(['error' => 'empty query']);
		}
		exit;
	}

	// Main compilations render API proxy
	if (preg_match('#^/api/main-compilations/render/?$#', $requestUri) && $_SERVER['REQUEST_METHOD'] === 'POST') {
		$entity = $_POST['entity'] ?? 'new';
		if ($entity !== 'new' && $entity !== 'used') $entity = 'new';
		
		$favorites = json_decode($_COOKIE['CIS_FAVORITES'] ?? '[]', true) ?: [];
		$compare = json_decode($_COOKIE['CIS_COMPARE'] ?? '[]', true) ?: [];
		
		$query = $_POST['query'] ?? [];
		$price = $_POST['price'] ?? '';
		
		$goUrl = 'http://127.0.0.1:8080/api/v1/cis/random';
		$params = ['type' => $entity, 'limit' => 12];
		
		if ($price && preg_match('#^(\d+),(\d+)$#', $price, $m)) {
			$params['price_min'] = $m[1];
			$params['price_max'] = $m[2];
		}
		
		if (is_array($query)) {
			if (!empty($query['brand_alias'])) $params['brand_alias'] = $query['brand_alias'];
			if (!empty($query['model_alias'])) $params['model_alias'] = $query['model_alias'];
		}
		
		$goUrl .= '?' . http_build_query($params);
		
		$ch = curl_init($goUrl);
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT => 10,
		]);
		$resp = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		header('Content-Type: text/html; charset=utf-8');
		
		if ($httpCode != 200) {
			echo '<!-- error -->';
			exit;
		}
		
		$data = json_decode($resp, true);
		$vehicles = $data['items'] ?? [];
		
		ob_start();
		foreach ($vehicles as $item) {
			$id = $item['ext_id'];
			$brandCode = $item['brand']['code'] ?? '';
			$modelCode = $item['model']['code'] ?? '';
			$brandName = $item['brand']['name'] ?? '';
			$modelName = $item['model']['name'] ?? '';
			$equipment = $item['equipment'] ?? '';
			$images = $item['images'] ?? [];
			$tags = $item['_tags'] ?? [];
			$general = $item['_general'] ?? [];
			$bodyCode = $item['body']['code'] ?? '';
			$price = $item['price'] ?? 0;
			$minPrice = $item['min_price'] ?? $price;
			$statusName = $item['status']['name'] ?? '';
			?>
			<div class="swiper-slide h-auto">
				<div class="vehicle-card bg-yalightbluegray text-start w-100">
					<div class="vehicle-card-images position-relative">
						<a href="/cars/<?= $entity ?>/<?= $brandCode ?>/<?= $modelCode ?>/<?= $id ?>/" role="vehicle-image">
							<?php if (!empty($images)) { ?>
								<?php foreach ($images as $k => $i) { ?>
									<div class="vehicle-card-images-item-container" style="<?= ($k != 0) ? 'display:none;' : '' ?>" data-index="<?= $k ?>">
										<img src="<?= htmlspecialchars($i['preview'] ?: $i['preview_large']) ?>" class="vehicle-card-images-item-container-image" alt="<?= htmlspecialchars($brandName . ' ' . $modelName) ?>" loading="<?= ($k == 0) ? 'eager' : 'lazy' ?>">
									</div>
								<?php } ?>
							<?php } else if ($bodyCode) { ?>
								<img src="https://<?= YApp::GO_API_DOMAIN ?>/upload/Cis/bodies/<?= $bodyCode ?>_sm.webp" class="w-100" />
							<?php } ?>
						</a>
						<?php if (!empty($images)) { ?>
						<div class="m-3 vehicle-card-images-row position-absolute d-flex justify-content-between">
							<?php foreach ($images as $k => $i) { ?>
							<span class="vehicle-card-images-row-item <?= ($k == 0) ? 'active' : '' ?>" data-index="<?= $k ?>"></span>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<div class="vehicle-card-content py-3 px-2">
						<a href="/cars/<?= $entity ?>/<?= $brandCode ?>/<?= $modelCode ?>/<?= $id ?>/" class="c-yablack c-h-yablack text-decoration-none line-height-one d-block vehicle-card-content-title fw-bold">
							<?= htmlspecialchars($brandName . ' ' . $modelName . ($equipment ? ' ' . $equipment : '')) ?>
						</a>
						<div class="vehicle-card-futures">
							<?php foreach ($tags as $tag) { ?>
								<a href="#" onclick="return false" class="hint--top-right" aria-label="<?= htmlspecialchars($tag['name']) ?>" role="not-cover">
									<img src="<?= htmlspecialchars($tag['icon']) ?>?2" />
								</a>
							<?php } ?>
						</div>
						<div class="vehicle-card-specification my-3 c-yablack text-minus">
							<?php foreach (array_chunk($general, 3) as $s_row) { ?>
							<div>
								<?php foreach ($s_row as $i) { ?>
									<?php if ($i) { ?><span class="vehicle-card-specification-item pe-2 me-2"><?= htmlspecialchars($i) ?></span><?php } ?>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
						<?php if ($minPrice < $price) { ?>
						<div class="vehicle-card-discount b-radius-yaradius-8 b-yayellow bg-yawhite pe-2 d-inline-block fw-bold">
							<div class="d-flex justify-content-between h-100">
								<span class="c-yawhite bg-yayellow b-radius-yaradius-8 text-uppercase me-2 fw-light h-100 px-1 d-flex justify-content-center align-items-center">Выгода</span>
								<span class="d-flex justify-content-center align-items-center">до <?= number_format($price - $minPrice, 0, '.', ' ') ?> ₽</span>
							</div>
						</div>
						<?php } ?>
						<div class="vehicle-card-status text-uppercase my-2 c-yayellow fw-bold"><?= htmlspecialchars($statusName) ?></div>
						<div class="vehicle-card-price my-2 d-flex justify-content-between align-items-end">
							<span class="price c-yablack fw-bold"><?= number_format($minPrice, 0, '.', ' ') ?> ₽</span>
							<?php if ($minPrice < $price) { ?>
							<span class="fw-light c-yadarkgray text-decoration-line-through mb-1"><?= number_format($price, 0, '.', ' ') ?> ₽</span>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="vehicle-card-footer d-flex justify-content-between">
					<div class="vehicle-card-footer-left bg-yawhite d-flex">
						<div class="vehicle-card-footer-left-content bg-yalightbluegray w-100">
							<a href="/cars/<?= $entity ?>/<?= $brandCode ?>/<?= $modelCode ?>/<?= $id ?>/" class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow vehicle-card-button fw-bold" data-vehicle-name="<?= htmlspecialchars($brandName . ' ' . $modelName . ($equipment ? ' ' . $equipment : '')) ?>" data-vehicle-id="<?= $id ?>" data-action="set-vehicle">Получить предложение</a>
						</div>
					</div>
					<div class="vehicle-card-footer-right bg-yalightbluegray d-flex">
						<div class="vehicle-card-footer-right-content bg-yawhite w-100 d-flex justify-content-end align-items-end">
							<a href="#" data-action="toggle-fav-com" data-target="CIS_FAVORITES" data-vehicle="<?= $id ?>" class="b-radius-yaradius-12 bg-yawhite me-2 <?= (in_array($id, $favorites) ? 'active' : '') ?> vehicle-card-discount-item position-relative">
								<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-favorites.svg" />
								<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-favorites-a.svg" />
							</a>
							<a href="#" data-action="toggle-fav-com" data-target="CIS_COMPARE" data-vehicle="<?= $id ?>" class="b-radius-yaradius-12 bg-yawhite <?= (in_array($id, $compare) ? 'active' : '') ?> vehicle-card-discount-item position-relative">
								<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-compare.svg" />
								<img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-compare-a.svg" />
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		echo ob_get_clean();
		exit;
	}
?><?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Продажа новых и подержанных автомобилей с пробегом в Краснодаре, поселке Яблоновский республики Адыгея и Новороссийске у официального дилера — Юг-Авто. *Все марки и модели в наличии *Выгодные цены");
$APPLICATION->SetPageProperty("title", "Юг-Авто — официальный дилер новых и подержанных б/у автомобилей с пробегом в Краснодаре, Новороссийске и Республике Адыгея");
$APPLICATION->SetPageProperty("canonical", "https://yug-avto.ru");
$APPLICATION->SetTitle("Юг-Авто — официальный дилер новых и подержанных б/у автомобилей с пробегом в Краснодаре, Новороссийске и Республике Адыгея");
?>


<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main.filter", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "main.filter",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "21",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "4",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "",
		"STRICT_SECTION_CHECK" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"ALL_LINK" => ""
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main.compilations", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "main.compilations",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
			2 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "23",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "6",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "LINK",
			2 => "QUERY",
			3 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "TIMESTAMP_X",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_TITLE" => "Подборки",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"ALL_LINK" => "Все автомобили"
	),
	false
);?>
<?php $arFilterDealerships = [
	// '!PROPERTY_ON_MAIN' => false,
	'!ID' => 917,
	'PROPERTY_INCOGNITO_VALUE' => false
];?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main.dealerships", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "main.dealerships",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "DETAIL_PICTURE",
			1 => "",
		),
		"FILTER_NAME" => "arFilterDealerships",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "200",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "EMAIL",
			1 => "ADDRESS",
			2 => "EXTERNAL_CODE",
			3 => "ON_MAIN",
			4 => "CITY",
			5 => "INCOGNITO",
			6 => "COORDS_LON",
			7 => "COORDS_LAT",
			8 => "IS_NEW",
			9 => "WORK",
			10 => "TAG",
			11 => "PHONE",
			12 => "SERVICES",
			13 => "BRAND",
			14 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_TITLE" => "Наши адреса",
		"ALL_LINK" => "Автосалоны",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
<?php $arFilterNews = ['PROPERTY_VIDEO' => false]; ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main.news", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "main.news",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "DETAIL_PICTURE",
			1 => "",
		),
		"FILTER_NAME" => "arFilterNews",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "11",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_TITLE" => "Новости",
		"ALL_LINK" => "Все новости",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main.news", 
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "main.news",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => [
			0 => "DETAIL_PICTURE",
			1 => "DATE_ACTIVE_FROM",
			2 => "",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "26",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_TITLE" => "Блог",
		"ALL_LINK" => "Все статьи",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	],
	false
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block.white", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "form.block.white",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "15",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEALERSHIP" => "",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>


<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "WebSite",
      "@id": "https://yug-avto.ru/#website",
      "url": "https://yug-avto.ru/",
      "name": "Юг-Авто",
      "alternateName": "Автохолдинг Юг-Авто",
      "description": "Официальный дилер новых и подержанных автомобилей в Краснодаре, Новороссийске и Республике Адыгея",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://yug-avto.ru/cars/new/?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    },
    {
      "@type": "AutoDealer",
      "@id": "https://yug-avto.ru/#autodealer",
      "name": "Юг-Авто",
      "legalName": "ООО «Юг-Авто»",
      "url": "https://yug-avto.ru/",
      "logo": "https://yug-avto.ru/local/templates/yugavto.theme.2025/assets/images/svg/logo.2023.svg",
      "image": "https://yug-avto.ru/local/templates/yugavto.theme.2025/assets/images/svg/logo.2023.svg",
      "telephone": "+7 (861) 203-22-22",
      "priceRange": "₽₽₽",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Уральская, 214",
        "addressLocality": "Краснодар",
        "addressRegion": "Краснодарский край",
        "postalCode": "350080",
        "addressCountry": "RU"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": "45.0355",
        "longitude": "39.0538"
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
          ],
          "opens": "08:00",
          "closes": "20:00"
        }
      ],
      "sameAs": [
        "https://vk.com/yugavto",
        "https://t.me/yugavto"
      ]
    }
  ]
}
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>