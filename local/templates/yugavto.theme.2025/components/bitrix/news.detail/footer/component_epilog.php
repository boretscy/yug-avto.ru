<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Data\Cache;

$seoPath = YApp::getSEOPath($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
$cache = Cache::createInstance();
$cacheId = 'footer_seo_text_' . md5($seoPath);
$cacheDir = '/footer_seo_text';

if ($cache->initCache(3600, $cacheId, $cacheDir)) {
    $seoText = $cache->getVars();
} else {
    $seoText = '';
    $rs = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => YApp::IBLOCK_SEO,
            'PROPERTY_PATH' => $seoPath
        ],
        false, false,
        ['ID', 'DETAIL_TEXT']
    );
    if ($ob = $rs->GetNextElement()) {
        $fields = $ob->GetFields();
        $seoText = $fields['DETAIL_TEXT'] ?? '';
    }

    if (!empty($seoText)) {
        $cache->startDataCache();
        $cache->endDataCache($seoText);
    }
}

if (empty($seoText) && !empty($GLOBALS['META']['meta']['seo_text'])) {
    $seoTitle = $GLOBALS['META']['meta']['seo_title'] ?? '';
    $seoText = (!empty($seoTitle) ? '<h2 class="fw-normal">' . $seoTitle . '</h2>' : '') . '<p>' . $GLOBALS['META']['meta']['seo_text'] . '</p>';
}

if (!empty($seoText)) {
    ob_start();
    ?>
		<div class="row">
			<div class="col footer-seo">
				<div class="footer-seo-text mb-3">
					<?= $seoText;?>
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
    <?php
    $APPLICATION->AddViewContent('footer_seo', ob_get_clean());
}
