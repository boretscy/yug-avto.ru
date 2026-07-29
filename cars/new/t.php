<?php if ( $_GET['mode'] ) {
	unset($_GET['mode']);
	$url = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	foreach ($_GET as $k=>$v) $G[] = $k.'='.$v;
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: ".$url['path'].((!empty($G)?'?'.implode('&',$G):''))); 
	exit();
} ?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;
$Asset = Asset::getInstance();

$APPLICATION->SetTitle("Title");
?>
<?php

$conf = require __DIR__.'/vendor/Config.php';
require __DIR__.'/../vendor/YApp.Showroom.class.php';
$app = new YAppShowroom($conf);

$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/libs/hint.min.css');
$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/libs/jquery.fancybox.min.css');
$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/app.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/app.css'));
$Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/libs/jquery.fancybox.min.js');
$Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/libs/share.js');
$Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/app.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/js/app.js'));

$filter = $app->makeFilter(CURRENT_URL, $_GET);
if ( !$filter['city'] ) $filter['city'] = $app->getCityCookie();
// YApp::sp($filter,true);

$data = json_decode( file_get_contents($app->makeApiUrl($filter, (($filter['vehicle'])?'vehicle':'vehicles'))), true );
// YApp::sp($app->makeApiUrl($filter, (($filter['vehicle'])?'vehicle':'vehicles')),true);

if ( $data['force_404'] ) {
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		die();
	}
}

$GLOBALS['META'] = $data['meta'];
if ( $data == NULL ) {
	if ( !$filter['vehicle'] && !$filter['model'] && $filter['brand'] ) {
		unset($filter['brand']);
	} elseif ( !$filter['vehicle'] && $filter['model'] ) {
		unset($filter['model']);
	} elseif ( $filter['vehicle'] ) {
		unset($filter['vehicle']);
	}
	header("HTTP/1.1 301 Moved Permanently"); 
	header("Location: ".$app->makeFilterUrl($filter));
	exit();
    // CHTTP::SetStatus("404 Not Found");
	// @define("ERROR_404","Y");
	// if ($APPLICATION->RestartWorkarea()) {
	// 	require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
	// 	die();
	// }
}

$data['FAVORITES'] = ( json_decode($_COOKIE['CIS_FAVORITES'], true) ) ?: [];
$data['COMPARE'] = ( json_decode($_COOKIE['CIS_COMPARE'], true) ) ?: [];

if ( !$filter['vehicle'] ) {    
    $data['filter'] = json_decode( file_get_contents($app->makeApiUrl($filter, 'filter')), true );
	// YApp::sp($app->makeApiUrl($filter, 'filter'), true);
    $data['filter']['dropLists']['brands'] = $data['brands'] = json_decode( file_get_contents($app->makeApiUrl($filter, 'brands')), true )['dropLists']['brands'];
    $data['current_page'] = ($_GET['page'] ) ? (int)$_GET['page'] : 1;
    array_multisort(array_column($data['brands'], 'vehicles'), SORT_DESC, SORT_NUMERIC, $data['brands']);
}

if ( $data['meta']['status'] === '404_vehicles' || $data['meta']['status'] === 404 || ( !$filter['vehicle'] && !$data['items'] ) ) {
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
<div class="YappsShowroom-forms-modal-cover w-100 h-100 position-fixed top-0"></div>
<div id="YappsShowroom" class="position-relative">
    <div class="cover bg-yawhite position-absolute w-100 h-100 d-none"></div>
    <?php 
        if ( $filter['vehicle'] ) {
            $APPLICATION->SetPageProperty("description", $data['meta']['meta']['description']);
            $APPLICATION->SetPageProperty('title', $data['meta']['meta']['title']);
            $APPLICATION->SetPageProperty('image', explode('?', $data['meta']['meta']['image'])[0]);
            $APPLICATION->SetPageProperty("canonical", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $Asset->addJs('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU');
            $data['_dealership'] = json_decode( file_get_contents('https://yug-avto.ru/api/dealership?code='.$data['dealership']['id'].'&brand='.$data['brand']['code']), true );
            foreach ( $app->makeVehicleBreadcrumbs($data) as $item ) $APPLICATION->AddChainItem($item['text'], $item['link']);
            include __DIR__.'/../views/vehicle.php';
        } else {
            $APPLICATION->SetPageProperty("description", $data['meta']['meta']['description']);
            $APPLICATION->SetPageProperty('title', $data['meta']['meta']['title']);
            $APPLICATION->SetPageProperty('image', explode('?', $data['meta']['meta']['image'])[0]);
            $APPLICATION->SetPageProperty("canonical", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
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


<?php $APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block.gray", 
	array(
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
		"WEB_FORM_ID" => ( $filter["vehicle"] ) ? 16 : 15,
		"COMPONENT_TEMPLATE" => "form.block.gray",
		"DEALERSHIP" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CAR" => $data['brand']['name'].' '.$data['model']['name'].' '.(($data['equipment'])?:'').' в '.$data['dealership']['name'],
		"VIN" => $data['vin'],
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

