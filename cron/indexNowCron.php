<?php
#!/usr/bin/php
declare(strict_types=1);

/**
 * Консольный скрипт управления очередью и отправки страниц в Bing / IndexNow.
 * 
 * Использование в crontab:
 * 0 4 * * * /usr/bin/php /var/www/admin/data/www/yug-avto.ru/cron/indexNowCron.php --send >/dev/null 2>&1
 * 
 * Параметры командной строки:
 *   --status     Вывести статистику очереди и суточных лимитов
 *   --populate   Наполнить очередь из всех существующих карт сайта (sitemap*.xml)
 *   --send       Выполнить отправку очередной пачки URL (до 100 URL/день)
 *   --dry-run    Выполнить отправку в режиме симуляции (без обращения к сети)
 *   --limit=N    Ограничить размер пачки числом N (по умолчанию из конфига)
 *   --force      Игнорировать проверку активности INDEXNOW_ENABLED
 *   --debug      Выводить подробные ошибки PHP
 */

$isCli = (php_sapi_name() === 'cli');
$options = [];
if ($isCli) {
    $longopts = ['status', 'populate', 'send', 'dry-run', 'force', 'debug', 'limit:', 'help'];
    $options = getopt('', $longopts) ?: [];
} else {
    $options = $_GET;
}

if (isset($options['debug']) || (int)($_GET['debug'] ?? 0) === 1) {
    error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    error_reporting(0);
    ini_set('log_errors', '0');
}

$docRoot = dirname(__DIR__);
if (file_exists($docRoot . '/local/php_interface/vendor/autoload.php')) {
    require_once $docRoot . '/local/php_interface/vendor/autoload.php';
}
if (file_exists($docRoot . '/local/php_interface/yapps_config.php')) {
    require_once $docRoot . '/local/php_interface/yapps_config.php';
}
if (file_exists($docRoot . '/local/php_interface/classes/Local/Project/Services/IndexNowService.php')) {
    require_once $docRoot . '/local/php_interface/classes/Local/Project/Services/IndexNowService.php';
}

use Local\Project\Services\IndexNowService;

function printLine(string $message): void {
    echo date('[Y-m-d H:i:s] ') . $message . PHP_EOL;
}

if (isset($options['help'])) {
    echo "Использование: php cron/indexNowCron.php [ОПЦИИ]\n";
    echo "  --status     Вывести текущую статистику очереди и лимитов\n";
    echo "  --populate   Импортировать все URL из sitemap*.xml в очередь\n";
    echo "  --send       Выполнить отправку пачки URL в Bing (до 100 URL/день)\n";
    echo "  --dry-run    Симуляция отправки (без запросов к Bing)\n";
    echo "  --limit=N    Размер пачки (по умолчанию из суточного лимита)\n";
    echo "  --force      Принудительная отправка даже при INDEXNOW_ENABLED=false\n";
    echo "  --debug      Включить подробный вывод ошибок PHP\n";
    exit(0);
}

// 1. Вывод статуса очереди
if (isset($options['status'])) {
    $st = IndexNowService::getStatus();
    printLine("=== СТАТИСТИКА BING INDEXNOW ===");
    printLine("Провайдер:        " . ($st['provider'] ?? 'bing_webmaster'));
    printLine("Включен в конфиге:" . ($st['enabled'] ? ' ДА' : ' НЕТ'));
    printLine("Режим Dry-Run:    " . ($st['dry_run'] ? ' ВКЛЮЧЕН (симуляция)' : ' ВЫКЛЮЧЕН (боевой)'));
    printLine("Суточный лимит:   " . $st['daily_limit'] . " URL/день");
    printLine("Отправлено сегодня: " . $st['sent_today'] . " URL");
    printLine("Остаток лимита:   " . $st['remaining_today'] . " URL");
    printLine("--------------------------------");
    printLine("Всего в базе:     " . $st['total'] . " URL");
    printLine("В очереди (pending): " . ($st['pending'] ?? 0) . " URL");
    printLine("Отправлено (sent):   " . ($st['sent'] ?? 0) . " URL");
    printLine("Ошибок (failed):     " . ($st['failed'] ?? 0) . " URL");
    printLine("================================");
    exit(0);
}

// 2. Первоначальное наполнение очереди из sitemap
if (isset($options['populate'])) {
    printLine("Начало импорта страниц из sitemap*.xml...");
    $res = IndexNowService::populateFromSitemaps($docRoot);
    if (($res['status'] ?? '') === 'success') {
        printLine("Импорт успешно завершен!");
        printLine("Всего найдено в sitemap: " . ($res['total_found'] ?? 0));
        printLine("Добавлено новых в очередь: " . ($res['total_added'] ?? 0));
        if (!empty($res['details'])) {
            foreach ($res['details'] as $file => $info) {
                printLine("  - {$file}: найдено {$info['found']}, добавлено {$info['added']}");
            }
        }
    } else {
        printLine("Ошибка импорта: " . ($res['message'] ?? 'Неизвестная ошибка'));
    }
    exit(0);
}

// 3. Отправка очереди
$limit = isset($options['limit']) ? (int)$options['limit'] : 100;
$force = isset($options['force']);
$isDryRunFlag = isset($options['dry-run']);

if ($isDryRunFlag) {
    if (!defined('YAppConfig::INDEXNOW_DRY_RUN')) {
        define('YAppConfig::INDEXNOW_DRY_RUN', true);
    }
}

printLine("Запуск обработки очереди IndexNow (лимит пачки: {$limit})...");
$res = IndexNowService::processQueue($limit, $force);

printLine("Результат: " . ($res['status'] ?? 'unknown'));
if (isset($res['message'])) {
    printLine("Сообщение: " . $res['message']);
}
printLine("Отправлено страниц: " . ($res['sent_count'] ?? 0));
if (!empty($res['urls'])) {
    printLine("Список отправленных URL (" . count($res['urls']) . " шт.):");
    foreach (array_slice($res['urls'], 0, 10) as $u) {
        printLine("  - " . $u);
    }
    if (count($res['urls']) > 10) {
        printLine("  ... и еще " . (count($res['urls']) - 10) . " URL");
    }
}
if (!empty($res['response'])) {
    printLine("Ответ Bing API: " . mb_substr((string)$res['response'], 0, 200));
}

exit(0);
