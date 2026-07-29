<?php
use Bitrix\Main\Loader;


define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);
define('NOT_CHECK_PERMISSIONS', true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$conf = require __DIR__.'/../vendor/Config.php';
require __DIR__.'/../vendor/YApp.Showroom.class.php';
$app = new YAppShowroom($conf);

if ( $_POST ) {
    $url = $_POST['url'];
    $parsed = parse_url($url);
    $params = [];
    if (isset($parsed['query'])) {
        parse_str($parsed['query'], $params);
    }
    $params['page'] = (int)$_POST['next'];
    $newQuery = http_build_query($params);
    
    $apiUrl = (isset($parsed['scheme']) ? $parsed['scheme'] . '://' : '') .
              (isset($parsed['host']) ? $parsed['host'] : '') .
              (isset($parsed['path']) ? $parsed['path'] : '') .
              '?' . $newQuery;

    $data = json_decode(YAppShowroom::httpGet($apiUrl), true);
    $data['FAVORITES'] = ( json_decode($_COOKIE['CIS_FAVORITES'], true) ) ?: [];
    $data['COMPARE'] = ( json_decode($_COOKIE['CIS_COMPARE'], true) ) ?: [];
    ?>
        <?php foreach ($data['items'] as $item) { ?>
        <div class="col-md-6 col-lg-4 col-xl-3 vehicle-list-item">
            <?php if ( $item['type'] == 'vehicle' ) { ?>
                <?php include __DIR__.'/../views/vehicles/item_vehicle.php'; ?>
            <?php } elseif ( $item['type'] == 'random_cta' ) { ?>
                <?php include __DIR__.'/../views/vehicles/item_cta.php'; ?>
            <?php } ?>
        </div>
        <?php } ?>
    <?php
} 