<?php
declare(strict_types=1);

namespace Local\Project\Services;

class IndexNowService
{
    public const PROVIDER_BING = 'bing_webmaster';
    public const PROVIDER_INDEXNOW = 'indexnow';

    private static ?\mysqli $mysqli = null;

    /**
     * Получение mysqli-подключения к БД (автономно либо через Bitrix D7).
     */
    public static function getDb(): \mysqli
    {
        if (self::$mysqli instanceof \mysqli && @self::$mysqli->ping()) {
            return self::$mysqli;
        }

        // Если доступно ядро Битрикса
        if (class_exists('\\Bitrix\\Main\\Application')) {
            try {
                $conn = \Bitrix\Main\Application::getConnection();
                $res = $conn->getResource();
                if ($res instanceof \mysqli) {
                    self::$mysqli = $res;
                    return self::$mysqli;
                }
            } catch (\Throwable $e) {
                // Фоллбек на прямое подключение
            }
        }

        // Прямое чтение параметров из .settings.php или dbconn.php
        $docRoot = !empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : dirname(__DIR__, 6);
        $settingsFile = $docRoot . '/bitrix/.settings.php';
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = '';

        if (file_exists($settingsFile)) {
            $settings = include $settingsFile;
            $connConf = $settings['connections']['value']['default'] ?? [];
            $dbHost = $connConf['host'] ?? 'localhost';
            $dbUser = $connConf['login'] ?? '';
            $dbPass = $connConf['password'] ?? '';
            $dbName = $connConf['database'] ?? '';
        }

        if (empty($dbName)) {
            $dbconnFile = $docRoot . '/bitrix/php_interface/dbconn.php';
            if (file_exists($dbconnFile)) {
                $DBHost = $DBLogin = $DBPassword = $DBName = '';
                include $dbconnFile;
                $dbHost = $DBHost ?: $dbHost;
                $dbUser = $DBLogin ?: $dbUser;
                $dbPass = $DBPassword ?: $dbPass;
                $dbName = $DBName ?: $dbName;
            }
        }

        $mysqli = new \mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($mysqli->connect_errno) {
            throw new \RuntimeException('IndexNowService: DB connection failed: ' . $mysqli->connect_error);
        }
        $mysqli->set_charset('utf8mb4');
        self::$mysqli = $mysqli;

        return self::$mysqli;
    }

    /**
     * Создание необходимых таблиц в БД, если они еще не созданы.
     */
    public static function createTablesIfNotExists(): void
    {
        $db = self::getDb();

        $sqlQueue = "CREATE TABLE IF NOT EXISTS `ya_indexnow_queue` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `url` VARCHAR(1000) NOT NULL,
            `url_hash` CHAR(32) NOT NULL,
            `status` ENUM('pending', 'sent', 'failed', 'ignored') NOT NULL DEFAULT 'pending',
            `priority` TINYINT UNSIGNED NOT NULL DEFAULT 5,
            `source` VARCHAR(50) NOT NULL DEFAULT 'sitemap',
            `created_at` DATETIME NOT NULL,
            `sent_at` DATETIME NULL,
            `attempts` TINYINT UNSIGNED NOT NULL DEFAULT 0,
            `last_error` TEXT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `ux_url_hash` (`url_hash`),
            KEY `ix_status_priority` (`status`, `priority`, `id`),
            KEY `ix_sent_at` (`sent_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $sqlLog = "CREATE TABLE IF NOT EXISTS `ya_indexnow_log` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `date` DATE NOT NULL,
            `urls_count` INT UNSIGNED NOT NULL DEFAULT 0,
            `response_code` INT NOT NULL,
            `response_body` TEXT NULL,
            `provider` VARCHAR(50) NOT NULL DEFAULT 'bing_webmaster',
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY (`id`),
            KEY `ix_date` (`date`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $db->query($sqlQueue);
        $db->query($sqlLog);
    }

    /**
     * Получить хост сайта (без протокола).
     */
    public static function getHost(): string
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }
        return 'yug-avto.ru';
    }

    /**
     * Нормализация URL в абсолютный канонический вид.
     */
    public static function normalizeUrl(string $url): string
    {
        $url = trim($url);
        if (empty($url)) {
            return '';
        }

        if (str_starts_with($url, '//')) {
            $url = 'https:' . $url;
        } elseif (str_starts_with($url, '/')) {
            $url = 'https://' . self::getHost() . $url;
        } elseif (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = 'https://' . self::getHost() . '/' . ltrim($url, '/');
        }

        return $url;
    }

    /**
     * Добавление одиночного URL в очередь.
     */
    public static function enqueueUrl(string $url, int $priority = 5, string $source = 'manual'): bool
    {
        $url = self::normalizeUrl($url);
        if (empty($url)) {
            return false;
        }

        self::createTablesIfNotExists();
        $db = self::getDb();

        $hash = md5($url);
        $escapedUrl = $db->real_escape_string($url);
        $escapedSource = $db->real_escape_string($source);
        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `ya_indexnow_queue` (`url`, `url_hash`, `status`, `priority`, `source`, `created_at`)
                VALUES ('{$escapedUrl}', '{$hash}', 'pending', {$priority}, '{$escapedSource}', '{$now}')
                ON DUPLICATE KEY UPDATE 
                    `priority` = LEAST(`priority`, VALUES(`priority`));";

        return (bool)$db->query($sql);
    }

    /**
     * Пакетное добавление массива URL в очередь (быстрый массовый INSERT IGNORE).
     */
    public static function enqueueBatch(array $urls, int $priority = 5, string $source = 'sitemap'): int
    {
        if (empty($urls)) {
            return 0;
        }

        self::createTablesIfNotExists();
        $db = self::getDb();

        $now = date('Y-m-d H:i:s');
        $escapedSource = $db->real_escape_string($source);
        $insertedCount = 0;
        $chunks = array_chunk($urls, 250);

        foreach ($chunks as $chunk) {
            $values = [];
            foreach ($chunk as $url) {
                $url = self::normalizeUrl((string)$url);
                if (empty($url)) {
                    continue;
                }
                $hash = md5($url);
                $escapedUrl = $db->real_escape_string($url);
                $values[] = "('{$escapedUrl}', '{$hash}', 'pending', {$priority}, '{$escapedSource}', '{$now}')";
            }

            if (!empty($values)) {
                $sql = "INSERT IGNORE INTO `ya_indexnow_queue` (`url`, `url_hash`, `status`, `priority`, `source`, `created_at`)
                        VALUES " . implode(',', $values);
                if ($db->query($sql)) {
                    $insertedCount += $db->affected_rows;
                }
            }
        }

        return $insertedCount;
    }

    /**
     * Подсчет количества успешно отправленных страниц за указанную дату (по умолчанию сегодня).
     */
    public static function getDailySentCount(?string $date = null): int
    {
        self::createTablesIfNotExists();
        $db = self::getDb();
        $targetDate = $date ?: date('Y-m-d');
        $escapedDate = $db->real_escape_string($targetDate);

        $sql = "SELECT SUM(`urls_count`) as `total` FROM `ya_indexnow_log` WHERE `date` = '{$escapedDate}' AND `response_code` IN (200, 202)";
        $res = $db->query($sql);
        if ($res && $row = $res->fetch_assoc()) {
            return (int)($row['total'] ?? 0);
        }

        return 0;
    }

    /**
     * Получить оставшийся лимит отправки на сегодня.
     */
    public static function getRemainingDailyLimit(): int
    {
        $dailyLimit = defined('\\YAppConfig::INDEXNOW_DAILY_LIMIT') ? (int)\YAppConfig::INDEXNOW_DAILY_LIMIT : 100;
        $sentToday = self::getDailySentCount();
        return max(0, $dailyLimit - $sentToday);
    }

    /**
     * Обработка очереди: выборка ожидающих страниц и отправка в Bing.
     */
    public static function processQueue(int $maxBatch = 100, bool $force = false): array
    {
        self::createTablesIfNotExists();
        $db = self::getDb();

        $isEnabled = defined('\\YAppConfig::INDEXNOW_ENABLED') ? (bool)\YAppConfig::INDEXNOW_ENABLED : true;
        if (!$isEnabled && !$force) {
            return [
                'status' => 'disabled',
                'message' => 'IndexNowService is disabled in configuration.',
                'sent_count' => 0
            ];
        }

        $remainingLimit = self::getRemainingDailyLimit();
        if ($remainingLimit <= 0 && !$force) {
            return [
                'status' => 'limit_reached',
                'message' => 'Daily limit of 100 URLs reached for today.',
                'sent_count' => 0
            ];
        }

        $batchSize = min($maxBatch, $remainingLimit);
        if ($batchSize <= 0) {
            $batchSize = $maxBatch;
        }

        // Выбираем URL со статусом pending по приоритету
        $sql = "SELECT `id`, `url` FROM `ya_indexnow_queue` 
                WHERE `status` = 'pending' 
                ORDER BY `priority` ASC, `id` ASC 
                LIMIT {$batchSize}";

        $res = $db->query($sql);
        $items = [];
        $ids = [];
        $urls = [];

        while ($res && $row = $res->fetch_assoc()) {
            $items[] = $row;
            $ids[] = (int)$row['id'];
            $urls[] = $row['url'];
        }

        if (empty($urls)) {
            return [
                'status' => 'queue_empty',
                'message' => 'No pending URLs in queue.',
                'sent_count' => 0
            ];
        }

        $isDryRun = defined('\\YAppConfig::INDEXNOW_DRY_RUN') ? (bool)\YAppConfig::INDEXNOW_DRY_RUN : false;

        $sendResult = self::sendDirect($urls, $isDryRun);
        $httpCode = $sendResult['http_code'] ?? 0;
        $now = date('Y-m-d H:i:s');
        $idList = implode(',', $ids);

        if ($httpCode === 200 || $httpCode === 202 || $isDryRun) {
            $db->query("UPDATE `ya_indexnow_queue` SET `status` = 'sent', `sent_at` = '{$now}', `attempts` = `attempts` + 1 WHERE `id` IN ({$idList})");
        } else {
            $err = $db->real_escape_string($sendResult['body'] ?? 'HTTP ' . $httpCode);
            $db->query("UPDATE `ya_indexnow_queue` SET `status` = 'failed', `attempts` = `attempts` + 1, `last_error` = '{$err}' WHERE `id` IN ({$idList})");
        }

        return [
            'status' => ($httpCode === 200 || $httpCode === 202 || $isDryRun) ? 'success' : 'failed',
            'http_code' => $httpCode,
            'sent_count' => count($urls),
            'urls' => $urls,
            'dry_run' => $isDryRun,
            'response' => $sendResult['body'] ?? ''
        ];
    }

    /**
     * Отправка запроса в Bing Webmaster Submission API (или IndexNow).
     */
    public static function sendDirect(array $urls, bool $isDryRun = false): array
    {
        if (empty($urls)) {
            return ['http_code' => 0, 'body' => 'No URLs to send'];
        }

        $provider = defined('\\YAppConfig::INDEXNOW_PROVIDER') ? \YAppConfig::INDEXNOW_PROVIDER : self::PROVIDER_BING;
        $apiKey = defined('\\YAppConfig::INDEXNOW_KEY') ? \YAppConfig::INDEXNOW_KEY : '';
        $host = self::getHost();
        $siteUrl = 'https://' . $host;

        if ($isDryRun) {
            // Режим симуляции: логируем без отправки в интернет
            self::logApiCall(date('Y-m-d'), count($urls), 200, json_encode(['dry_run' => true, 'count' => count($urls), 'urls' => array_slice($urls, 0, 5)]), $provider);
            return [
                'http_code' => 200,
                'body' => json_encode(['d' => null, 'status' => 'Dry-run success']),
                'dry_run' => true
            ];
        }

        $postData = [];
        $apiUrl = '';

        if ($provider === self::PROVIDER_BING) {
            $apiUrl = 'https://ssl.bing.com/webmaster/api.svc/json/SubmitUrlbatch?apikey=' . urlencode($apiKey);
            $postData = [
                'siteUrl' => $siteUrl,
                'urlList' => array_values($urls),
            ];
        } else {
            $apiUrl = 'https://api.indexnow.org/indexnow';
            $postData = [
                'host' => $host,
                'key' => $apiKey,
                'keyLocation' => $siteUrl . '/api/indexnow-auth.php',
                'urlList' => array_values($urls),
            ];
        }

        $jsonPayload = json_encode($postData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsonPayload),
            ],
            CURLOPT_TIMEOUT => 20,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        $responseBody = curl_exec($ch);
        $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($responseBody === false) {
            $responseBody = 'cURL Error: ' . $curlError;
            $httpCode = 500;
        }

        self::logApiCall(date('Y-m-d'), count($urls), $httpCode, (string)$responseBody, $provider);

        return [
            'http_code' => $httpCode,
            'body' => $responseBody,
            'dry_run' => false
        ];
    }

    /**
     * Запись информации о вызове API в журнал ya_indexnow_log.
     */
    private static function logApiCall(string $date, int $count, int $httpCode, string $body, string $provider): void
    {
        $db = self::getDb();
        $escapedDate = $db->real_escape_string($date);
        $escapedBody = $db->real_escape_string($body);
        $escapedProvider = $db->real_escape_string($provider);
        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `ya_indexnow_log` (`date`, `urls_count`, `response_code`, `response_body`, `provider`, `created_at`)
                VALUES ('{$escapedDate}', {$count}, {$httpCode}, '{$escapedBody}', '{$escapedProvider}', '{$now}')";
        $db->query($sql);
    }

    /**
     * Первоначальное наполнение очереди из существующих sitemap-файлов.
     */
    public static function populateFromSitemaps(?string $documentRoot = null): array
    {
        $docRoot = $documentRoot ?: (!empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : dirname(__DIR__, 6));
        $sitemapIndex = $docRoot . '/sitemap.xml';

        if (!file_exists($sitemapIndex)) {
            return ['status' => 'error', 'message' => 'sitemap.xml not found in ' . $docRoot];
        }

        $filesToParse = [];
        $xmlContent = file_get_contents($sitemapIndex);
        if (preg_match_all('/<loc>(https?:\/\/[^<]+)<\/loc>/i', $xmlContent, $matches)) {
            foreach ($matches[1] as $subSitemapUrl) {
                $filename = basename(parse_url($subSitemapUrl, PHP_URL_PATH));
                if (file_exists($docRoot . '/' . $filename)) {
                    $filesToParse[$filename] = $docRoot . '/' . $filename;
                }
            }
        }

        // Также проверяем стандартные файлы
        $defaults = [
            'sitemap-files.xml',
            'sitemap-iblock-4.xml',
            'sitemap-iblock-11.xml',
            'sitemap-iblock-13.xml',
            'sitemap-brands-new.xml',
            'sitemap-brands-used.xml',
            'sitemap-vehicles-new.xml',
            'sitemap-vehicles-used.xml',
        ];
        foreach ($defaults as $def) {
            if (file_exists($docRoot . '/' . $def) && !isset($filesToParse[$def])) {
                $filesToParse[$def] = $docRoot . '/' . $def;
            }
        }

        $totalFound = 0;
        $totalAdded = 0;
        $bySource = [];

        foreach ($filesToParse as $name => $filePath) {
            $content = file_get_contents($filePath);
            if (!$content) {
                continue;
            }

            $priority = 5;
            if (str_contains($name, 'files')) {
                $priority = 1;
            } elseif (str_contains($name, 'brands') || str_contains($name, 'iblock')) {
                $priority = 2;
            }

            if (preg_match_all('/<loc>(https?:\/\/[^<]+)<\/loc>/i', $content, $m)) {
                $urls = array_unique($m[1]);
                $count = count($urls);
                $totalFound += $count;
                $added = self::enqueueBatch($urls, $priority, $name);
                $totalAdded += $added;
                $bySource[$name] = ['found' => $count, 'added' => $added];
            }
        }

        return [
            'status' => 'success',
            'total_found' => $totalFound,
            'total_added' => $totalAdded,
            'details' => $bySource
        ];
    }

    /**
     * Получить сводную статистику по очереди.
     */
    public static function getStatus(): array
    {
        self::createTablesIfNotExists();
        $db = self::getDb();

        $stats = [
            'total' => 0,
            'pending' => 0,
            'sent' => 0,
            'failed' => 0,
            'sent_today' => self::getDailySentCount(),
            'remaining_today' => self::getRemainingDailyLimit(),
            'daily_limit' => defined('\\YAppConfig::INDEXNOW_DAILY_LIMIT') ? (int)\YAppConfig::INDEXNOW_DAILY_LIMIT : 100,
            'enabled' => defined('\\YAppConfig::INDEXNOW_ENABLED') ? (bool)\YAppConfig::INDEXNOW_ENABLED : true,
            'dry_run' => defined('\\YAppConfig::INDEXNOW_DRY_RUN') ? (bool)\YAppConfig::INDEXNOW_DRY_RUN : false,
            'provider' => defined('\\YAppConfig::INDEXNOW_PROVIDER') ? \YAppConfig::INDEXNOW_PROVIDER : self::PROVIDER_BING,
        ];

        $res = $db->query("SELECT `status`, COUNT(*) as `cnt` FROM `ya_indexnow_queue` GROUP BY `status`");
        while ($res && $row = $res->fetch_assoc()) {
            $st = $row['status'];
            $cnt = (int)$row['cnt'];
            $stats[$st] = $cnt;
            $stats['total'] += $cnt;
        }

        return $stats;
    }
}
