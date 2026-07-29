<?php 

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,HEAD,OPTIONS");
header("Access-Control-Allow-Headers: Origin,Content-Type,Accept,Authorization");  

use Bitrix\Main\Loader;


define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);
define('NOT_CHECK_PERMISSIONS', true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

include __DIR__.'/vendor/YAApi.php';

// CIS API proxy — forward /api/v1/cis/* to Go API
$route = YAApi::Route();
if ($route['entity'] === 'v1' && $route['id'] === 'cis') {
    $path = $_SERVER['REQUEST_URI'];
    $goUrl = 'https://' . YApp::GO_API_DOMAIN . $path;
    $ch = curl_init($goUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
    }
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    http_response_code($httpCode);
    echo $resp !== false ? $resp : '{"error":"proxy error"}';
    return;
}

$POST = ( $_POST ) ?: json_decode(file_get_contents('php://input'), true);

switch ( YAApi::Route()['entity'] ) {
    // Render methods (POST, return HTML)
    case 'main-filter-select': echo YAApi::apiRenderMainFilterSelect( $POST ); break;
    case 'main-filter-button': echo YAApi::apiRenderMainFilterLink( $POST ); break;
    case 'main-filter-brands': echo YAApi::apiRenderMainFilterBrands( $POST ); break;
    case 'main-dealership-view': echo YAApi::apiRenderMainDealershipView( $POST ); break;
    case 'main-compilations': echo YAApi::apiRenderMainCompilations( $POST ); break;
    case 'search': echo YAApi::apiRenderSearch( $POST ); break;

    // JSON API methods
    case 'main-filter': echo json_encode(YAApi::apiMainFilter( $POST )); break;
    case 'main_cards_links': echo json_encode(YAApi::apiMainCardsLinks( $POST )); break;
    case 'stories-reaction': echo json_encode(YAApi::apiStoriesReaction( $POST )); break;
    case 'offers': echo json_encode(YAApi::apiGetOffers( YAApi::Route()['data'] )); break;
    case 'dealership': echo json_encode(YAApi::apiGetDealership( YAApi::Route()['data'] )); break;
    case 'dealerships': echo json_encode(YAApi::apiGetDealerships( YAApi::Route()['data'] )); break;
    case 'brands': echo json_encode(YAApi::apiGetBrands( YAApi::Route()['data'] )); break;
    case 'models': echo json_encode(YAApi::apiGetModels( YAApi::Route()['data'] )); break;
    case 'send': echo json_encode(YAApi::apiSendform( $POST )); break;
    case 'send_new': echo json_encode(YAApi::apiSendformNEW( $POST )); break;
    case 'cities_code': echo json_encode(YAApi::apiGetCitiesByName( $POST )); break;

    default: echo json_encode(['error' => 404, 'description' => 'Неверный запрос']);
}
?>
