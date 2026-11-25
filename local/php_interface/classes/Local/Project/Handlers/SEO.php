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

        // 3. 301-редиректы устаревших слагов моделей (novaya-* -> *-new)
        if (is_string($cleanPath) && str_starts_with($cleanPath, '/cars/new/')) {
            $slugMap = [
                'novaya-granta-sedan'     => 'granta-sedan-new',
                'novaya-granta-liftbek'   => 'granta-liftbek-new',
                'novaya-granta-khetchbek' => 'granta-khetchbek-new',
                'novaya-granta-wagon'     => 'granta-wagon-new',
                'novaya-granta-cross'     => 'granta-cross-new',
                'novaya-vesta'            => 'vesta-new',
                'novaya-vesta-sw'         => 'vesta-sw-new',
                'novaya-vesta-cross'      => 'vesta-cross-new',
                'novaya-vesta-sw-cross'   => 'vesta-sw-cross-new',
                'novaya-elantra'          => 'elantra-new',
                'novaya-creta'            => 'creta-new',
            ];
            if (preg_match('#^(/cars/new/[^/]+/)([^/]+)(/.*)?$#', $cleanPath, $m)) {
                $oldSlug = $m[2];
                if (isset($slugMap[$oldSlug])) {
                    $queryString = $_SERVER['QUERY_STRING'] ?? '';
                    $targetUrl = $m[1] . $slugMap[$oldSlug] . ($m[3] ?? '/') . ($queryString !== '' ? '?' . $queryString : '');
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: ' . $targetUrl);
                    exit();
                }
            }
        }
    }
}
