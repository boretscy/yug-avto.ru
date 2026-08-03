<?php

	// Глобальный тумблер оптимизации фронтенда (set to false for rollback)
	if (!defined('ENABLE_FRONTEND_OPTIMIZATION')) {
		define('ENABLE_FRONTEND_OPTIMIZATION', true);
	}

	// 301-редирект index.php, index.html, index.htm на главную (Пункт 1 ТЗ)
	$requestUri = $_SERVER['REQUEST_URI'] ?? '';
	$cleanPath = parse_url($requestUri, PHP_URL_PATH);
	if ($cleanPath === '/index.php' || $cleanPath === '/index.html' || $cleanPath === '/index.htm') {
		$queryString = $_SERVER['QUERY_STRING'] ?? '';
		$targetUrl = '/' . ($queryString ? '?' . $queryString : '');
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $targetUrl);
		exit();
	}

	// 301-редирект множественных слэшей в URL (Пункт 3 ТЗ)
	if (!empty($requestUri) && preg_match('#/{2,}#', $requestUri)) {
		$cleanUri = preg_replace('#/{2,}#', '/', $requestUri);
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $cleanUri);
		exit();
	}

	// Глобальная обработка Last-Modified (Пункт 10 ТЗ)
	$isShowroom = (strpos($requestUri, '/cars/') === 0);
	$isAdmin = (strpos($requestUri, '/bitrix/') === 0);

	if (!$isShowroom && !$isAdmin) {
		$LastModified_unix = 0;
		$iblockId = null;

		$urlParts = explode('/', trim($requestUri, '/'));
		$section = $urlParts[0] ?? '';
		$elementCode = $urlParts[1] ?? '';
		
		if (($pos = strpos($elementCode, '?')) !== false) {
			$elementCode = substr($elementCode, 0, $pos);
		}

		if ($section === 'dealerships') {
			$iblockId = 4;
		} elseif ($section === 'news') {
			$iblockId = 11;
		}

		if ($iblockId > 0) {
			global $DB;
			if (isset($DB)) {
				if (!empty($elementCode)) {
					$dbRes = $DB->Query("SELECT TIMESTAMP_X FROM b_iblock_element WHERE CODE = '" . $DB->ForSql($elementCode) . "' AND IBLOCK_ID = " . (int)$iblockId . " AND ACTIVE = 'Y' LIMIT 1");
					if ($arRes = $dbRes->Fetch()) {
						$LastModified_unix = strtotime($arRes['TIMESTAMP_X']);
					}
				} else {
					$dbRes = $DB->Query("SELECT MAX(TIMESTAMP_X) as MAX_TS FROM b_iblock_element WHERE IBLOCK_ID = " . (int)$iblockId . " AND ACTIVE = 'Y'");
					if ($arRes = $dbRes->Fetch()) {
						$LastModified_unix = strtotime($arRes['MAX_TS']);
					}
				}
			}
		}

		if ($LastModified_unix <= 0 && !empty($_SERVER['SCRIPT_FILENAME']) && file_exists($_SERVER['SCRIPT_FILENAME'])) {
			if (strpos($_SERVER['SCRIPT_FILENAME'], 'urlrewrite.php') === false) {
				$LastModified_unix = filemtime($_SERVER['SCRIPT_FILENAME']);
			}
		}

		if ($LastModified_unix > 0) {
			$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
			$IfModifiedSince = false;
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
				$cleanDate = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
				if (($pos = strpos($cleanDate, ';')) !== false) {
					$cleanDate = substr($cleanDate, 0, $pos);
				}
				$IfModifiedSince = strtotime(trim($cleanDate));
			}

			if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
				header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
				exit();
			}
			header('Last-Modified: ' . $LastModified);
		}
	}

	require_once __DIR__.'/YApp/YApp.php';
    $yapp = new YApp();

function showArray($aRR){
    global $USER;
    if ($USER->IsAdmin()){
        echo '<pre style="text-align: left; word-wrap: break-word; background: #fff; color: #000; display: block; width: 100%; box-sizing: border-box; padding: 10px; border-radius: 3px;">';
        print_r($aRR);
        echo '</pre>';
    }
}
