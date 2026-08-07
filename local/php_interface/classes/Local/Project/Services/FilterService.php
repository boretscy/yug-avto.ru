<?php
declare(strict_types=1);

namespace Local\Project\Services;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Loader;
use YApp;

class FilterService
{
    /**
     * Подготовка фильтра для страницы автосалонов (/dealerships/)
     */
    public static function getDealershipsFilter(array $queryParams): array
    {
        $arFilter = ['PROPERTY_INCOGNITO_VALUE' => false];

        if (!Loader::includeModule('iblock')) {
            return $arFilter;
        }

        // 1. Фильтр по брендам
        if (!empty($queryParams['brand']) && is_string($queryParams['brand'])) {
            $brandCodes = array_filter(array_map('trim', explode(',', $queryParams['brand'])));
            if (!empty($brandCodes)) {
                $cache = Cache::createInstance();
                $cacheId = 'dl_filter_brands_v2_' . md5(implode(',', $brandCodes));
                $cacheDir = '/dealerships_filter';

                if ($cache->initCache(3600, $cacheId, $cacheDir)) {
                    $brandIds = $cache->getVars();
                } else {
                    $brandIds = [];
                    $elements = ElementTable::getList([
                        'select' => ['ID'],
                        'filter' => [
                            '=IBLOCK_ID' => YApp::IBLOCK_BRANDS, // IBLOCK_ID = 5
                            '=ACTIVE' => 'Y',
                            '=CODE' => $brandCodes
                        ],
                        'cache' => ['ttl' => 3600]
                    ])->fetchAll();

                    foreach ($elements as $el) {
                        $brandIds[] = (int)$el['ID'];
                    }

                    $cache->startDataCache();
                    $cache->endDataCache($brandIds);
                }

                if (!empty($brandIds)) {
                    $arFilter['PROPERTY_BRAND'] = $brandIds;
                } else {
                    $arFilter['PROPERTY_BRAND'] = -1; // Если бренд не найден, не выводим ничего
                }
            }
        }

        // 2. Фильтр по тегам
        if (!empty($queryParams['tag']) && is_string($queryParams['tag'])) {
            $tagXmlIds = array_filter(array_map('trim', explode(',', $queryParams['tag'])));
            if (!empty($tagXmlIds)) {
                $enums = PropertyEnumerationTable::getList([
                    'select' => ['VALUE', 'XML_ID'],
                    'filter' => [
                        '=PROPERTY.IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                        '=PROPERTY.CODE' => 'TAG'
                    ],
                    'cache' => ['ttl' => 86400]
                ])->fetchAll();

                foreach ($enums as $enum) {
                    if (in_array($enum['XML_ID'], $tagXmlIds, true)) {
                        $arFilter['PROPERTY_TAG_VALUE'][] = $enum['VALUE'];
                    }
                }
            }
        }

        // 3. Фильтр по городу
        if (!empty($queryParams['city']) && is_string($queryParams['city'])) {
            $enums = PropertyEnumerationTable::getList([
                'select' => ['VALUE'],
                'filter' => [
                    '=PROPERTY.IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                    '=PROPERTY.CODE' => 'CITY'
                ],
                'cache' => ['ttl' => 86400]
            ])->fetchAll();

            foreach ($enums as $enum) {
                if ($queryParams['city'] === $enum['VALUE']) {
                    $arFilter['PROPERTY_CITY_VALUE'] = $enum['VALUE'];
                    break;
                }
            }
        } else {
            $arFilter['!PROPERTY_CITY_VALUE'] = ['Ставрополь'];
        }

        return $arFilter;
    }

    /**
     * Подготовка фильтра для страницы новостей (/news/)
     */
    public static function getNewsFilter(array $queryParams): array
    {
        $arFilter = [];

        if (!Loader::includeModule('iblock')) {
            return $arFilter;
        }

        // 1. Фильтр по брендам
        if (!empty($queryParams['brand']) && is_string($queryParams['brand'])) {
            $brandCodes = array_filter(array_map('trim', explode(',', $queryParams['brand'])));
            if (!empty($brandCodes)) {
                $elements = ElementTable::getList([
                    'select' => ['ID'],
                    'filter' => [
                        '=IBLOCK_ID' => YApp::IBLOCK_BRANDS, // IBLOCK_ID = 5
                        '=ACTIVE' => 'Y',
                        '=CODE' => $brandCodes
                    ],
                    'cache' => ['ttl' => 3600]
                ])->fetchAll();

                foreach ($elements as $el) {
                    $arFilter['PROPERTY_BRAND'][] = (int)$el['ID'];
                }
                if (empty($arFilter['PROPERTY_BRAND'])) {
                    $arFilter['PROPERTY_BRAND'] = -1;
                }
            }
        }

        // 2. Фильтр по тегам (видеообзоры / новости)
        if (!empty($queryParams['tag'])) {
            if ($queryParams['tag'] === 'news') {
                $arFilter['PROPERTY_VIDEO'] = false;
            } elseif ($queryParams['tag'] === 'videoreviews') {
                $arFilter['!PROPERTY_VIDEO'] = false;
            }
        }

        // 3. Фильтр по автосалонам
        if (!empty($queryParams['dealership']) && is_string($queryParams['dealership'])) {
            $dealershipCodes = array_filter(array_map('trim', explode(',', $queryParams['dealership'])));
            if (!empty($dealershipCodes)) {
                $elements = ElementTable::getList([
                    'select' => ['ID'],
                    'filter' => [
                        '=IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                        '=ACTIVE' => 'Y',
                        '=CODE' => $dealershipCodes
                    ],
                    'cache' => ['ttl' => 3600]
                ])->fetchAll();

                foreach ($elements as $el) {
                    $arFilter['PROPERTY_DEALERSHIP'][] = (int)$el['ID'];
                }
                if (empty($arFilter['PROPERTY_DEALERSHIP'])) {
                    $arFilter['PROPERTY_DEALERSHIP'] = -1;
                }
            }
        }

        return $arFilter;
    }
}
