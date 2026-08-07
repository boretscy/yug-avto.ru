<?php
declare(strict_types=1);

namespace Local\Project\Services;

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;

class LastModified
{
    /**
     * Вычисление и отдача заголовков Last-Modified / 304 Not Modified через D7 ORM
     */
    public static function process(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $isShowroom = (strpos($requestUri, '/cars/') === 0);
        $isAdmin = (strpos($requestUri, '/bitrix/') === 0);

        if ($isShowroom || $isAdmin) {
            return;
        }

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

        if ($iblockId > 0 && Loader::includeModule('iblock')) {
            if (!empty($elementCode)) {
                $element = ElementTable::getList([
                    'select' => ['TIMESTAMP_X'],
                    'filter' => [
                        '=CODE' => $elementCode,
                        '=IBLOCK_ID' => (int)$iblockId,
                        '=ACTIVE' => 'Y'
                    ],
                    'limit' => 1,
                    'cache' => ['ttl' => 3600]
                ])->fetch();

                if ($element && !empty($element['TIMESTAMP_X'])) {
                    if ($element['TIMESTAMP_X'] instanceof DateTime) {
                        $LastModified_unix = $element['TIMESTAMP_X']->getTimestamp();
                    } else {
                        $LastModified_unix = strtotime((string)$element['TIMESTAMP_X']);
                    }
                }
            } else {
                // Выборка последнего измененного элемента через D7 ORM
                $element = ElementTable::getList([
                    'select' => ['TIMESTAMP_X'],
                    'filter' => [
                        '=IBLOCK_ID' => (int)$iblockId,
                        '=ACTIVE' => 'Y'
                    ],
                    'order' => ['TIMESTAMP_X' => 'DESC'],
                    'limit' => 1,
                    'cache' => ['ttl' => 3600]
                ])->fetch();

                if ($element && !empty($element['TIMESTAMP_X'])) {
                    if ($element['TIMESTAMP_X'] instanceof DateTime) {
                        $LastModified_unix = $element['TIMESTAMP_X']->getTimestamp();
                    } else {
                        $LastModified_unix = strtotime((string)$element['TIMESTAMP_X']);
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
}
