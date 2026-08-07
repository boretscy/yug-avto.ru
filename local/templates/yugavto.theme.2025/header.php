<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\Loader::includeModule('iblock');
?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
    $GLOBALS['CIS_FAVORITES'] = ( !empty($_COOKIE['CIS_FAVORITES']) && is_string($_COOKIE['CIS_FAVORITES']) ) ? json_decode($_COOKIE['CIS_FAVORITES'], true) : [];
    $GLOBALS['CIS_COMPARE'] = ( !empty($_COOKIE['CIS_COMPARE']) && is_string($_COOKIE['CIS_COMPARE']) ) ? json_decode($_COOKIE['CIS_COMPARE'], true) : [];
    if (!is_array($GLOBALS['CIS_FAVORITES'])) $GLOBALS['CIS_FAVORITES'] = [];
    if (!is_array($GLOBALS['CIS_COMPARE'])) $GLOBALS['CIS_COMPARE'] = [];
?>
<!doctype html>
<html lang="ru">
    <head>

        <!-- Head.Start include area -->
        <?php $APPLICATION->IncludeFile( SITE_TEMPLATE_PATH.'/include/_head.start.php', [], []); ?>
        <!-- // Head.Start include area -->

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Preconnect & DNS-prefetch Optimization -->
        <link rel="preconnect" href="https://<?= YApp::GO_API_DOMAIN ?>" crossorigin>
        <link rel="dns-prefetch" href="https://<?= YApp::GO_API_DOMAIN ?>">

        <!-- Bitrix Head -->
        <?php $APPLICATION->ShowHead();?>
        <!-- // Bitrix Head -->

        <title><?php $APPLICATION->ShowTitle();?></title>

        <?php 
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/bootstrap.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/swiper-bundle.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/remodal.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/remodal-default-theme.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/hint.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/fonts/font.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/fonts/font.css'));
            
            if (defined('ENABLE_FRONTEND_OPTIMIZATION') && ENABLE_FRONTEND_OPTIMIZATION) {
                $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/bundle.app.min.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/bundle.app.min.css'));
            } else {
                $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/app.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/app.css'));
                $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/forms.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/forms.css'));
            }

            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/jquery.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/remodal.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/swiper-bundle.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/mask.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/lodash.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/modules/store.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/modules/form-handler.js');
            
            if (defined('ENABLE_FRONTEND_OPTIMIZATION') && ENABLE_FRONTEND_OPTIMIZATION) {
                $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/bundle.app.min.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/bundle.app.min.js'));
            } else {
                $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/app.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/app.js'));
                $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/forms.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/forms.js'));
            }
        ?>

        <!-- Favicon -->
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="57x57" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-57x57.png?2">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-60x60.png?2">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-72x72.png?2">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-76x76.png?2">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-114x114.png?2">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-120x120.png?2">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-144x144.png?2">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-152x152.png?2">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/apple-icon-180x180.png?2">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/android-icon-192x192.png?2">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/favicon-32x32.png?2">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/favicon-96x96.png?2">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/favicon-16x16.png?2">
        <link rel="manifest" href="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/manifest.json?2">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= SITE_TEMPLATE_PATH;?>/assets/images/icon/ms-icon-144x144.png?2">
        <meta name="theme-color" content="#ffffff">
        <!-- // Favicon -->

        <link rel="preload" href="<?= SITE_TEMPLATE_PATH;?>/assets/fonts/Roboto-Regular.woff2" as="font" type="font/woff2" crossorigin>

        <!-- Head.End include area -->
        <?php $APPLICATION->IncludeFile( SITE_TEMPLATE_PATH.'/include/_head.end.php', [], []); ?>
        <!-- // Head.End include area -->

        <script data-skip-moving="true">
            window.REMODAL_GLOBALS = {
                DEFAULTS: {
                    hashTracking: false
                }
            };
        </script>

        <script data-skip-moving="true">
            let YAPP = {};
            YAPP.CONNECTOR = {};
            YAPP.CONNECTOR.SELECTED_CITY = <?=json_encode( explode(',', YApp::setCityCookie()) ).PHP_EOL;?>
        </script>

        <meta property="og:title" content="<?= $APPLICATION->ShowProperty('title');?>"/>
        <meta property="og:description" content="<?= $APPLICATION->ShowProperty('description');?>"/>
        <meta property="og:site_name" content="Юг-Авто — официальный дилер новых и подержанных б/у автомобилей с пробегом в Краснодаре, Новороссийске и Республике Адыгея"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"/>
        <meta property="og:image" content="<?= $APPLICATION->ShowProperty('image', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].SITE_TEMPLATE_PATH.'/assets/images/svg/logo.2023.svg');?>">

        <?php 
            $canonicalUrl = $APPLICATION->GetProperty('canonical');
            if (empty($canonicalUrl)) {
                $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                $host = $_SERVER['HTTP_HOST'] ?? 'htest.yug-avto.ru';
                $requestUri = explode('?', $_SERVER['REQUEST_URI'])[0];
                $canonicalUrl = $protocol . '://' . $host . $requestUri;
            }
        ?>
        <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl);?>"/>

    </head>

    <body>
        <?php
            // Вывод телефонов из Highloadblock с кэшированием D7
            $contactPhones = \Local\Project\Services\PhoneService::getContacts();
        ?>

        <?php $APPLICATION->ShowPanel();?>
        <!-- Body.Start include area -->
        <?php $APPLICATION->IncludeFile( SITE_TEMPLATE_PATH.'/include/_body.start.php', [], []); ?>
        <!-- // Body.Start include area -->

        <!-- Top.Row include area -->
        <?php $APPLICATION->IncludeComponent("bitrix:menu", "top", Array(
            "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "MAX_LEVEL" => "1",	// Уровень вложенности меню
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
                "MENU_CACHE_TYPE" => "A",	// Тип кеширования
                "MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
                "ROOT_MENU_TYPE" => "top_menu",	// Тип меню для первого уровня
                "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "COMPONENT_TEMPLATE" => "top.vue"
            ),
            false
        );?>
        <!-- // Top.Row include area -->

        <?php if ( $APPLICATION->GetCurPage(false) !== '/' ) {
            $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb", 
                "breadcrumbs", 
                array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0",
                    "COMPONENT_TEMPLATE" => "breadcrumbs",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
        } ?>