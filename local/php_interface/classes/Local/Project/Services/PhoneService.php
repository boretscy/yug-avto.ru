<?php
declare(strict_types=1);

namespace Local\Project\Services;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Loader;

class PhoneService
{
    private const HLBLOCK_ID = 1;
    private const CACHE_TTL = 86400; // 24 часа
    private const CACHE_DIR = '/phone_service_contacts';

    /**
     * Получить список телефонов и контактов из Highloadblock с кэшированием D7
     */
    public static function getContacts(): array
    {
        $cache = Cache::createInstance();
        $cacheId = 'hl_phone_contacts_' . self::HLBLOCK_ID;

        if ($cache->initCache(self::CACHE_TTL, $cacheId, self::CACHE_DIR)) {
            return $cache->getVars();
        }

        $result = [];
        if (Loader::includeModule('highloadblock')) {
            $hlblock = HighloadBlockTable::getById(self::HLBLOCK_ID)->fetch();
            if ($hlblock) {
                $entity = HighloadBlockTable::compileEntity($hlblock);
                $entityDataClass = $entity->getDataClass();

                $res = $entityDataClass::getList([
                    'select' => ['*']
                ]);

                foreach ($res->fetchAll() as $itemHl) {
                    $item = $itemHl;
                    if (!empty($itemHl['UF_VALUE']) && is_countable($itemHl['UF_VALUE']) && count($itemHl['UF_VALUE']) === 1) {
                        $item['VALUE'] = $itemHl['UF_VALUE'][0];
                    }
                    if (!empty($itemHl['UF_CODE'])) {
                        $result[$itemHl['UF_CODE']] = $item;
                    }
                }
            }
        }

        if (!empty($result)) {
            $cache->startDataCache();
            $cache->endDataCache($result);
        }

        return $result;
    }
}
