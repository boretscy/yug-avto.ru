<?php
declare(strict_types=1);

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;

// Глобальный тумблер оптимизации фронтенда
if (!defined('ENABLE_FRONTEND_OPTIMIZATION')) {
    define('ENABLE_FRONTEND_OPTIMIZATION', true);
}

// Инициализация объекта сайта и Culture в контексте D7 при AJAX / неполных точках входа
if (defined('SITE_ID')) {
    $context = \Bitrix\Main\Context::getCurrent();
    if (!$context->getSite()) {
        $site = \Bitrix\Main\SiteTable::getById(SITE_ID)->fetchObject();
        if ($site) {
            $context->setSite($site);
        }
    }
    if (!$context->getCulture()) {
        $culture = \Bitrix\Main\Localization\CultureTable::getById(1)->fetchObject();
        if ($culture) {
            $context->setCulture(new \Bitrix\Main\Context\Culture($culture));
        }
    }
}

// Регистрация автозагрузки классов пространств имен Local\Project
Loader::registerAutoLoadClasses(null, [
    'Local\Project\Handlers\SEO' => '/local/php_interface/classes/Local/Project/Handlers/SEO.php',
    'Local\Project\Services\LastModified' => '/local/php_interface/classes/Local/Project/Services/LastModified.php',
    'Local\Project\Services\PhoneService' => '/local/php_interface/classes/Local/Project/Services/PhoneService.php',
    'Local\Project\Services\FilterService' => '/local/php_interface/classes/Local/Project/Services/FilterService.php',
]);

// 1. Регистрация событийно-управляемых 301-редиректов (D7)
EventManager::getInstance()->addEventHandler(
    'main',
    'OnBeforeProlog',
    ['\Local\Project\Handlers\SEO', 'handleRedirects']
);

// 2. Обработка заголовков Last-Modified через D7 ORM
\Local\Project\Services\LastModified::process();

// 3. Загрузка вспомогательного приложения YApp
require_once __DIR__ . '/YApp/YApp.php';
$yapp = new YApp();

/**
 * Вспомогательный дамп массива для администраторов
 */
function showArray($aRR): void
{
    global $USER;
    if (isset($USER) && is_object($USER) && $USER->IsAdmin()) {
        echo '<pre style="text-align: left; word-wrap: break-word; background: #fff; color: #000; display: block; width: 100%; box-sizing: border-box; padding: 10px; border-radius: 3px;">';
        print_r($aRR);
        echo '</pre>';
    }
}
