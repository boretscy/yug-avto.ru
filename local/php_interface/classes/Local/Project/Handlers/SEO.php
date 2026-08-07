<?php
declare(strict_types=1);

namespace Local\Project\Handlers;

class SEO
{
    /**
     * Обработчик события OnBeforeProlog для 301-редиректов.
     */
    public static function handleRedirects(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        if (empty($requestUri)) {
            return;
        }

        // 1. Редирект index.php, index.html, index.htm на /
        $cleanPath = parse_url($requestUri, PHP_URL_PATH);
        if ($cleanPath === '/index.php' || $cleanPath === '/index.html' || $cleanPath === '/index.htm') {
            $queryString = $_SERVER['QUERY_STRING'] ?? '';
            $targetUrl = '/' . ($queryString ? '?' . $queryString : '');
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $targetUrl);
            exit();
        }

        // 2. Редирект множественных слэшей в URL на один слэш
        if (preg_match('#/{2,}#', $requestUri)) {
            $cleanUri = preg_replace('#/{2,}#', '/', $requestUri);
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $cleanUri);
            exit();
        }
    }
}
