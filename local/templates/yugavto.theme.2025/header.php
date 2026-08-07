
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
[MATCHING_CONTENT_MARKER]
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