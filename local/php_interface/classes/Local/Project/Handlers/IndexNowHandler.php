<?php
declare(strict_types=1);

namespace Local\Project\Handlers;

use Local\Project\Services\IndexNowService;

class IndexNowHandler
{
    /**
     * Список ID инфоблоков, изменение которых должно отслеживаться для отправки в поисковики.
     */
    private const TRACKED_IBLOCKS = [
        4,  // Дилерские центры
        11, // Новости
        12, // История
        13, // Спецпредложения и акции
        14, // Вакансии
        17, // Страницы моделей/брендов
    ];

    /**
     * Обработчик события OnAfterIBlockElementAdd.
     */
    public static function onAfterIBlockElementAdd(array &$fields): void
    {
        self::handleElementChange($fields, 'add');
    }

    /**
     * Обработчик события OnAfterIBlockElementUpdate.
     */
    public static function onAfterIBlockElementUpdate(array &$fields): void
    {
        self::handleElementChange($fields, 'update');
    }

    /**
     * Обработчик события OnAfterIBlockSectionAdd.
     */
    public static function onAfterIBlockSectionAdd(array &$fields): void
    {
        if (empty($fields['ID']) || empty($fields['IBLOCK_ID'])) {
            return;
        }

        $iblockId = (int)$fields['IBLOCK_ID'];
        if (!in_array($iblockId, self::TRACKED_IBLOCKS, true)) {
            return;
        }

        if (isset($fields['ACTIVE']) && $fields['ACTIVE'] !== 'Y') {
            return;
        }

        $sectionUrl = self::getSectionUrl((int)$fields['ID'], $iblockId);
        if (!empty($sectionUrl)) {
            IndexNowService::enqueueUrl($sectionUrl, 2, 'iblock_sec_' . $iblockId);
        }
    }

    /**
     * Универсальная обработка изменения элемента инфоблока.
     */
    private static function handleElementChange(array &$fields, string $action): void
    {
        if (empty($fields['ID']) || empty($fields['IBLOCK_ID'])) {
            return;
        }

        $iblockId = (int)$fields['IBLOCK_ID'];
        if (!in_array($iblockId, self::TRACKED_IBLOCKS, true)) {
            return;
        }

        // Проверяем активность
        if (isset($fields['ACTIVE']) && $fields['ACTIVE'] !== 'Y') {
            return;
        }

        // Игнорируем если результат сохранения неуспешный
        if (isset($fields['RESULT']) && $fields['RESULT'] === false) {
            return;
        }

        $elementUrl = self::getElementUrl((int)$fields['ID'], $iblockId);
        if (!empty($elementUrl)) {
            IndexNowService::enqueueUrl($elementUrl, 2, 'iblock_' . $iblockId);
        }
    }

    /**
     * Определение канонического URL элемента инфоблока.
     */
    private static function getElementUrl(int $elementId, int $iblockId): string
    {
        if (!class_exists('\\CIBlockElement') || !class_exists('\\CIBlock')) {
            return '';
        }

        try {
            $dbEl = \CIBlockElement::GetList(
                [],
                ['ID' => $elementId, 'IBLOCK_ID' => $iblockId],
                false,
                false,
                ['ID', 'IBLOCK_ID', 'CODE', 'DETAIL_PAGE_URL', 'ACTIVE', 'IBLOCK_SECTION_ID']
            );

            if ($el = $dbEl->GetNext()) {
                if (($el['ACTIVE'] ?? '') !== 'Y') {
                    return '';
                }

                if (!empty($el['DETAIL_PAGE_URL'])) {
                    return (string)$el['DETAIL_PAGE_URL'];
                }
            }
        } catch (\Throwable $e) {
            // Suppress bitrix errors
        }

        return '';
    }

    /**
     * Определение канонического URL раздела инфоблока.
     */
    private static function getSectionUrl(int $sectionId, int $iblockId): string
    {
        if (!class_exists('\\CIBlockSection')) {
            return '';
        }

        try {
            $dbSec = \CIBlockSection::GetList(
                [],
                ['ID' => $sectionId, 'IBLOCK_ID' => $iblockId],
                false,
                ['ID', 'IBLOCK_ID', 'CODE', 'SECTION_PAGE_URL', 'ACTIVE']
            );

            if ($sec = $dbSec->GetNext()) {
                if (($sec['ACTIVE'] ?? '') !== 'Y') {
                    return '';
                }

                if (!empty($sec['SECTION_PAGE_URL'])) {
                    return (string)$sec['SECTION_PAGE_URL'];
                }
            }
        } catch (\Throwable $e) {
            // Suppress bitrix errors
        }

        return '';
    }
}
