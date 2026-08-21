<?php 
	if ( preg_match('#/page-1/?($|\?)#', $_SERVER['REQUEST_URI']) ) {
		$cleanUri = preg_replace('#/page-1/?($|\?)#', '/$1', $_SERVER['REQUEST_URI']);
		$cleanUri = preg_replace('#//+#', '/', $cleanUri);
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".$cleanUri); 
		exit();
	}
	$p = explode('/', $_SERVER['REQUEST_URI']);
	if ( !empty($p[4]) && !empty($p[3]) && $p[3] == $p[4] ) {
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".implode('/', array_slice($p, 0, 4))); 
	}
?>
<?php if ( !empty($_GET['mode']) ) {
	unset($_GET['mode']);
	$G = [];
	$url = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	foreach ($_GET as $k=>$v) $G[] = $k.'='.$v;
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: ".$url['path'].((!empty($G)?'?'.implode('&',$G):''))); 
	exit();
} ?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Page\Asset;
$Asset = Asset::getInstance();

$APPLICATION->SetTitle("Title");
?>
<?php

$conf = require __DIR__.'/vendor/Config.php';
require __DIR__.'/../vendor/YApp.Showroom.class.php';
$app = new YAppShowroom($conf);

$filter = $app->makeFilter(CURRENT_URL, $_GET);
if ( !$filter['city'] ) $filter['city'] = $app->getCityCookie();

$data = json_decode( YAppShowroom::httpGet($app->makeApiUrl($filter, (($filter['vehicle'])?'vehicle':'vehicles'))), true );

// === Ранняя валидация и 404 / 301 (ДО отправки HTML и prolog_after.php) ===
if ( $filter['vehicle'] && (!isset($data['id']) || isset($data['error']) || (isset($data['code']) && $data['code'] == 404)) ) {
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
	die();
}

if ( !empty($data['force_404']) || (isset($data['code']) && $data['code'] == 404) ) {
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
	die();
}

if ( $data == NULL ) {
	if ( !$filter['vehicle'] && !$filter['model'] && $filter['brand'] ) {
		unset($filter['brand']);
	} elseif ( !$filter['vehicle'] && $filter['model'] ) {
		unset($filter['model']);
	} elseif ( $filter['vehicle'] ) {
		unset($filter['vehicle']);
	}
    unset($filter['price'], $filter['dealership'], $filter['transmission'], $filter['engine'], $filter['drive'], $filter['body'], $filter['color'], $filter['volume'], $filter['power'], $filter['year']);
	$targetUrl = $app->makeFilterUrl($filter);
	if ( !empty($targetUrl) && $targetUrl !== CURRENT_URL ) {
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".$targetUrl); 
		exit();
	} else {
		CHTTP::SetStatus("404 Not Found");
		@define("ERROR_404","Y");
		require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		die();
	}
}

$GLOBALS['META'] = $data['meta'] ?? [];

// === Last-Modified & If-Modified-Since (Пункт 10 ТЗ) ===
$LastModified_unix = 0;
if ( $filter['vehicle'] ) {
	if ( !empty($data['created']) ) {
		$LastModified_unix = (int)$data['created'];
	}
} else {
	if ( !empty($data['items']) && is_array($data['items']) ) {
		foreach ( $data['items'] as $item ) {
			if ( !empty($item['created']) && (int)$item['created'] > $LastModified_unix ) {
				$LastModified_unix = (int)$item['created'];
			}
		}
	}
}

if ( $LastModified_unix <= 0 ) {
	$LastModified_unix = filectime($_SERVER['SCRIPT_FILENAME']);
}

$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
$IfModifiedSince = false;
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
	$IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
}

if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
	exit();
}
header('Last-Modified: ' . $LastModified);
// ==========================================

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");

$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/libs/hint.min.css');
$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/libs/jquery.fancybox.min.css');
$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/core.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/core.css'));
$Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/libs/jquery.fancybox.min.js');
$Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/libs/share.js');
$Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/core.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/js/core.js'));

$data['FAVORITES'] = ( json_decode($_COOKIE['CIS_FAVORITES'] ?? '', true) ) ?: [];
$data['COMPARE'] = ( json_decode($_COOKIE['CIS_COMPARE'] ?? '', true) ) ?: [];

if ( !$filter['vehicle'] ) {    
    $cache = \Bitrix\Main\Data\Cache::createInstance();
    $cacheId = "cis_filter_" . $app->Conf()['Api']['mode'] . "_" . md5(serialize($filter));
    $cacheDir = "/cis_showroom";
    if ($cache->initCache(3600, $cacheId, $cacheDir)) {
        $data['filter'] = $cache->getVars();
    } elseif ($cache->startDataCache()) {
        $filterData = json_decode(YAppShowroom::httpGet($app->makeApiUrl($filter, 'filter')), true);
        if (!empty($filterData)) {
            $cache->endDataCache($filterData);
        } else {
            $cache->abortDataCache();
        }
        $data['filter'] = $filterData;
    }

    $brandsData = json_decode(YAppShowroom::httpGet($app->makeApiUrl($filter, 'brands')), true)['dropLists']['brands'] ?? null;
    $data['filter']['dropLists']['brands'] = $data['brands'] = $brandsData;
    $data['current_page'] = ($_GET['page'] ) ? (int)$_GET['page'] : 1;
    $data['filter']['totalCount'] = $data['totalCount'] ?? 0;
    array_multisort(array_column($data['brands'], 'vehicles'), SORT_DESC, SORT_NUMERIC, $data['brands']);

    $compareFunc = function($a, $b) {
        $nameA = $a['name'] ?? '';
        $nameB = $b['name'] ?? '';
        $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
        $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
        if ($isRusA && !$isRusB) return -1;
        if (!$isRusA && $isRusB) return 1;
        return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
    };
    if ( !empty($data['filter']['dropLists']['brands']) ) {
        usort($data['filter']['dropLists']['brands'], $compareFunc);
    }
    if ( !empty($data['filter']['dropLists']['dealerships']) ) {
        usort($data['filter']['dropLists']['dealerships'], $compareFunc);
    }
} 

if ( $data['meta']['status'] === '404_vehicles' || $data['meta']['status'] === 404 || ( !$filter['vehicle'] && !$data['items'] ) ) {
	if ( !empty($filter['brand']) && !empty($filter['model']) ) {
		$checkData = json_decode( YAppShowroom::httpGet($app->makeApiUrl(['model' => $filter['model']], 'filter')), true );
		$realBrandCode = null;
		if ( !empty($checkData['dropLists']['models']) ) {
			foreach ( $checkData['dropLists']['models'] as $mItem ) {
				if ( $mItem['code'] === $filter['model'] && !empty($mItem['brand']['code']) ) {
					$realBrandCode = $mItem['brand']['code'];
					break;
				}
			}
		}
		if ( $realBrandCode && $realBrandCode !== $filter['brand'] ) {
			$rFilter = $filter;
			$rFilter['brand'] = $realBrandCode;
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: " . $app->makeFilterUrl($rFilter));
			exit();
		}
	}

	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		die();
	}
}
?>
<script type='application/ld+json'>
    {
		"@context": "http://schema.org/",
        "name": "<?= $data['meta']['meta']['title'];?>",
        "description": "<?= $data['meta']['meta']['description'];?>",
        "image": "<?= (($data['meta']['meta']['image'])?explode('?', $data['meta']['meta']['image'])[0]:$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",

        "speakable": {
            "@type": "SpeakableSpecification",
            "xpath": [
                "/html/head/title",
                "/html/head/meta[@name='description_page']/@content"
                ]
        },

		<?php if ( $data['meta']['meta']['level'] == 'vehicle' ) { ?>
		"@type": "Product",
		"brand": {
			"@type": "Brand",
			"name": "<?= $data['meta']['meta']['brand'];?>"
		},
		"offers": {
			"@type": "Offer",
			"priceCurrency": "RUB",
			"price": "<?= $data['meta']['meta']['price'];?>",
			"url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
			"availability": "https://schema.org/InStock",
			"itemCondition": "https://schema.org/NewCondition"
		}
		<?php } else { ?>
        "@type": "Organization",
        "url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
		<?php } ?>
    }
</script>

<style>
	body {background-color: var(--yawhite);}
</style>
<div class="YappsShowroom-forms-modal-cover w-100 h-100 position-fixed top-0"></div>
<div id="YappsShowroom" class="position-relative">
    <div class="cover bg-yawhite position-absolute w-100 h-100 d-none"></div>
    <?php 
        if ( $filter['vehicle'] ) {
            $APPLICATION->SetPageProperty("description", $data['meta']['meta']['description']);
            $APPLICATION->SetPageProperty('title', $data['meta']['meta']['title']);
            $APPLICATION->SetPageProperty('image', explode('?', $data['meta']['meta']['image'])[0]);
            $APPLICATION->SetPageProperty("canonical", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].explode('?', $_SERVER['REQUEST_URI'])[0]);
            $Asset->addJs('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU');
            $data['_dealership'] = json_decode( YAppShowroom::httpGet('https://yug-avto.ru/api/dealership?code='.$data['dealership']['id']), true );
            foreach ( $app->makeVehicleBreadcrumbs($data) as $item ) $APPLICATION->AddChainItem($item['text'], $item['link']);
            include __DIR__.'/../views/vehicle.php';
        } else {
            $APPLICATION->SetPageProperty("description", $data['meta']['meta']['description']);
            $APPLICATION->SetPageProperty('title', $data['meta']['meta']['title']);
            $APPLICATION->SetPageProperty('image', explode('?', $data['meta']['meta']['image'])[0]);
            if ( $filter['page'] ) {
                $pfilter = $filter;
                unset($pfilter['page']);
                $canonical = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$app->makeFilterUrl($pfilter, []);
            } else {
                $canonical = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            }
            $APPLICATION->SetPageProperty("canonical", $canonical);
            foreach ( $app->makeFilterBreadcrumbs($filter, $data['filter']) as $item ) $APPLICATION->AddChainItem($item['text'], $item['link']);
            include __DIR__.'/../views/filter.php';
            include __DIR__.'/../views/vehicles.php';

        }

        include __DIR__.'/../views/forms/offer-modal.php';
        include __DIR__.'/../views/forms/credit-modal.php';
        include __DIR__.'/../views/forms/trade-in-modal.php';
        include __DIR__.'/../views/forms/sell-modal.php';
    ?>
</div>

<?php
if ( $filter["vehicle"] ) {
	?>
	<div class="pt-3 pt-lg-5 bg-yalightbluegray bottom-container">
	<?php
	$APPLICATION->IncludeComponent(
		"bitrix:form.result.new", 
		"form.block.white.vehicle", 
		[
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
			"WEB_FORM_ID" => 16,
			"COMPONENT_TEMPLATE" => "form.block.white.vehicle",
			"DEALERSHIP" => "",
			"COMPOSITE_FRAME_MODE" => "A",
			"COMPOSITE_FRAME_TYPE" => "AUTO",
			"PARAM_VEHICLE" => $data["brand"]["name"]." ".$data["model"]["name"]." ".(($data["equipment"])?:""),
			"PARAM_PRICE" => $data["price"],
			"PARAM_MIN_PRICE" => $data["min_price"],
			"PARAM_DEALERSHIP" => $data['_dealership']['CODE'],
			"PARAM_VIN" => $data['vin'],
			"PARAM_IMAGE" => $data['_images'][0]['detail'],
			"VARIABLE_ALIASES" => [
				"WEB_FORM_ID" => "WEB_FORM_ID",
				"RESULT_ID" => "RESULT_ID",
			]
		],
		false
	);
	?>
	</div>

    <div class="bg-yalightbluegray py-3">
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
    </div>
	<?php
}
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


