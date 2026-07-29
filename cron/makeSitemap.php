<?php
#!/usr/bin/php

$dd = dirname(__DIR__);
$domain = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'yug-avto.ru';
require_once $dd.'/local/php_interface/vendor/autoload.php';

function processSitemapSection($dd, $domain, $apiUrl, $section, $dealershipIds)
{
    $sitemapName = "sitemap-cis-{$section}.xml";
    $brandsFile = "sitemap-brands-{$section}.xml";
    $vehiclesFile = "sitemap-vehicles-{$section}.xml";
    $urlPath = "cars/{$section}/";

    $vehicles = json_decode(file_get_contents($apiUrl), true)['items'];
    $google = [];

    if (!count($vehicles)) return;

    $vehicles = array_filter($vehicles, fn($v) => !empty($v['brand']['code']) && !empty($v['id']));
    if (!count($vehicles)) return;

    $ss = file_get_contents($dd.'/sitemap.xml');
    $arSS = explode('</sitemap><sitemap>', $ss);
    foreach ($arSS as $k => $s) {
        if (mb_stripos($s, $sitemapName) !== false) {
            unset($arSS[$k]);
        }
    }
    file_put_contents($dd.'/sitemap.xml', implode('</sitemap><sitemap>', $arSS));

    $ss = file_get_contents($dd.'/sitemap.xml');
    if (mb_stripos($ss, $sitemapName) === false) {
        $arSS = explode('</sitemap><sitemap>', $ss);
        array_splice($arSS, count($arSS) - 1, 0, [
            '<loc>https://'.$domain.'/'.$sitemapName.'</loc><lastmod>'.date('c').'</lastmod>',
        ]);
        file_put_contents($dd.'/sitemap.xml', implode('</sitemap><sitemap>', $arSS));
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $xml .= '<sitemap><loc>https://'.$domain.'/'.$brandsFile.'</loc><lastmod>'.date('c').'</lastmod></sitemap>';
    $xml .= '<sitemap><loc>https://'.$domain.'/'.$vehiclesFile.'</loc><lastmod>'.date('c').'</lastmod></sitemap>';
    $xml .= '</sitemapindex>';
    file_put_contents($dd.'/'.$sitemapName, $xml);

    $brands = [];
    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($vehicles as $v) {
        $xml .= '<url><loc>';
        $xml .= 'https://'.$domain.'/'.$urlPath.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/';
        $xml .= '</loc><lastmod>'.date('c', !empty($v['created']) ? (int)$v['created'] : time()).'</lastmod></url>';

        $brands[$v['brand']['ext_id']] = $v['brand'];

        if ($v['type'] == 'vehicle' && in_array($v['dealership']['id'], $dealershipIds)) {
            if ((int)$v['created'] > time() - 3600) {
                $google[] = 'https://'.$domain.'/'.$urlPath.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>';
            }
        }
    }
    $xml .= '</urlset>';
    file_put_contents($dd.'/'.$vehiclesFile, $xml);

    foreach ($vehicles as $v) {
        if (!empty($v['brand']['ext_id']) && !empty($v['model']['ext_id'])) {
            $brands[$v['brand']['ext_id']]['models'][$v['model']['ext_id']] = $v['model'];
        }
    }

    $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($brands as $b) {
        $xml .= '<url><loc>';
        $xml .= 'https://'.$domain.'/'.$urlPath.$b['code'];
        $xml .= '</loc><lastmod>'.date('c').'</lastmod></url>';
        foreach ($b['models'] as $m) {
            $xml .= '<url><loc>';
            $xml .= 'https://'.$domain.'/'.$urlPath.$b['code'].'/'.$m['code'].'/';
            $xml .= '</loc><lastmod>'.date('c').'</lastmod></url>';
        }
    }
    $xml .= '</urlset>';
    file_put_contents($dd.'/'.$brandsFile, $xml);

    if (!empty($google)) {
        $client = new Google_Client();
        $client->setAuthConfig($dd.'/local/php_interface/yugavto-2198640fb47f.json');
        $client->addScope('https://www.googleapis.com/auth/indexing');
        $httpClient = $client->authorize();
        $logDir = __DIR__.'/IndexingLog/'.date('Y/m/d');
        if (!is_dir($logDir)) mkdir($logDir, 0755, true);
        foreach ($google as $indexURL) {
            $response = $httpClient->get('https://indexing.googleapis.com/v3/urlNotifications/metadata?url=' . urlencode($indexURL));
            file_put_contents(
                $logDir.'/'.$section.'_'.date('H-i').'.txt',
                print_r(['url' => $indexURL, 'response' => (string) $response->getBody()], true).PHP_EOL,
                FILE_APPEND
            );
        }
    }
}

processSitemapSection(
    $dd,
    $domain,
    'https://' . YApp::GO_API_DOMAIN . '/API/get/cis/vehicles/new?token=34b5ac8b71018c0bc7e5c050ed90b243',
    'new',
    [20, 256, 949, 1227, 1262, 1268, 1271, 1309, 1328, 1331, 1334, 1340, 1343, 1346, 1349, 1355, 1358, 1361, 1455, 1458, 1461, 1650, 1655, 1670, 1676, 1679, 1724, 1725, 1758]
);

processSitemapSection(
    $dd,
    $domain,
    'https://' . YApp::GO_API_DOMAIN . '/API/get/cis/vehicles/used?token=34b5ac8b71018c0bc7e5c050ed90b243',
    'used',
    [1364, 1367, 1489, 1492, 1499, 1502, 1533]
);
