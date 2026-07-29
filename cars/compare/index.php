<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;
$Asset = Asset::getInstance();

$APPLICATION->SetTitle("Сравнение автомобилей");
?>
<?php
define('ENTITY', 'CIS_COMPARE');
if ( isset($_GET['action']) && $_GET['action'] == 'clear' ) {
    unset($_COOKIE[ENTITY]);
    setcookie(ENTITY, json_encode([]), time()-3600, '/');
    $items = [];
}
if ( isset($_GET['action']) && $_GET['action'] == 'delete' ) {
    $items = ( !empty($_COOKIE[ENTITY]) && is_string($_COOKIE[ENTITY]) ) ? json_decode($_COOKIE[ENTITY], true) : [];
    if ( !is_array($items) ) $items = [];
    $indx = array_search( (int)$_GET['vehicle'], $items );
    if ( $indx !== false ) unset( $items[$indx] );
    $items = array_values($items);
    setcookie(ENTITY, json_encode($items), time()+3600*24*14, '/');
}

if ( empty($items) ) {
    $items = ( !empty($_COOKIE[ENTITY]) && is_string($_COOKIE[ENTITY]) ) ? json_decode($_COOKIE[ENTITY], true) : [];
    if ( !is_array($items) ) $items = [];
}

$conf = require __DIR__.'/../vendor/Config.php';
require __DIR__.'/../vendor/YApp.Showroom.class.php';
$app = new YAppShowroom($conf);

$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/libs/hint.min.css');
$Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/core.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/core.css'));
$Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/core.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/js/core.js'));

$filter = $app->makeFilter(CURRENT_URL, $_GET);
$filter['id'] = implode(',', array_map('intval', $items));
unset( $filter['action'], $filter['vehicle'] );

$data = [];
if ( !empty($items) ) {
    $api_url = $app->makeApiUrl($filter, 'vehicles');
    $data = json_decode( YAppShowroom::httpGet($api_url), true );
    
    // Синхронизация куки (очистка от проданных авто)
    $cur_items = [];
    if ( !empty($data['items']) && is_array($data['items']) ) {
        foreach ( $data['items'] as $item ) {
            if ( !empty($item['id']) ) {
                $cur_items[] = (int)$item['id'];
            }
        }
    }
    
    $valid_items = [];
    foreach ( $items as $item ) {
        if ( in_array( (int)$item, $cur_items ) ) {
            $valid_items[] = (int)$item;
        }
    }
    
    if ( count($items) !== count($valid_items) ) {
        $items = $valid_items;
        setcookie(ENTITY, json_encode($items), time()+3600*24*14, '/');
    }
}

$GLOBALS['META'] = $data['meta'] = json_decode( YAppShowroom::httpGet('https://apps.yug-avto.ru/API/get/cis/meta/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&site=yug-avto.ru&entity=new&brand=compare'), true );

if ( !empty($data) && is_array($data) ) {
    $data['COMPARE'] = $items;
    $data['FAVORITES'] = ( !empty($_COOKIE['CIS_FAVORITES']) && is_string($_COOKIE['CIS_FAVORITES']) ) ? json_decode($_COOKIE['CIS_FAVORITES'], true) : [];
    if ( !is_array($data['FAVORITES']) ) $data['FAVORITES'] = [];
}
?>
<script type='application/ld+json'>
    {
		<?php if ( !empty($data['meta']['level']) && $data['meta']['level'] == 'vehicle' ) { ?>
		"@context": "http://schema.org/",
		"@type": "Product",
        "name": "<?= !empty($data['meta']['meta']['title']) ? $data['meta']['meta']['title'] : '';?>",
        "image": "<?= (!empty($data['meta']['meta']['image']) ? $data['meta']['meta']['image'] : SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
        "description": "<?= !empty($data['meta']['meta']['description']) ? $data['meta']['meta']['description'] : '';?>",
		"brand": {
			"@type": "Brand",
			"name": "<?= !empty($data['meta']['meta']['brand']) ? $data['meta']['meta']['brand'] : '';?>"
		},
		"offers": {
			"@type": "Offer",
			"priceCurrency": "RUB",
			"price": "<?= !empty($data['meta']['meta']['price']) ? $data['meta']['meta']['price'] : '';?>",
			"url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
			"availability": "https://schema.org/InStock",
			"itemCondition": "https://schema.org/NewCondition"
		}
		<?php } else { ?>
		"@context": "http://www.schema.org",
        "@type": "Organization",
        "name": "<?= !empty($data['meta']['meta']['title']) ? $data['meta']['meta']['title'] : '';?>",
        "url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
        "image": "<?= (!empty($data['meta']['meta']['image']) ? $data['meta']['meta']['image'] : SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
        "description": "<?= !empty($data['meta']['meta']['description']) ? $data['meta']['meta']['description'] : '';?>"
		<?php } ?>
    }
</script>
<style>
	body {background-color: var(--yawhite);}
</style>
<div id="YappsShowroom">
    <div class="cover bg-yawhite position-absolute w-100 h-100 d-none"></div>
    <?php 
        
        $APPLICATION->SetPageProperty("description", !empty($data['meta']['meta']['description']) ? $data['meta']['meta']['description'] : '');
        $APPLICATION->SetPageProperty('title', !empty($data['meta']['meta']['title']) ? $data['meta']['meta']['title'] : '');
        $APPLICATION->SetPageProperty('image', !empty($data['meta']['meta']['image']) ? $data['meta']['meta']['image'] : '');
        $APPLICATION->SetPageProperty("canonical", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        
        include __DIR__.'/../views/compare.php';

        include __DIR__.'/../views/forms/offer-modal.php';
        include __DIR__.'/../views/forms/credit-modal.php';
        include __DIR__.'/../views/forms/trade-in-modal.php';
        include __DIR__.'/../views/forms/sell-modal.php';
    ?>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block.gray", 
	[
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
		"VARIABLE_ALIASES" => [
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		]
	],
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
