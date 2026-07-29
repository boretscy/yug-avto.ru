
<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); CModule::IncludeModule('iblock'); ?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
?>
<?php // include $_SERVER['DOCUMENT_ROOT'].'/local/templates/yugavto.theme.2023/include/_ban.php';?>
<!doctype html>
<html lang="ru">
    <head>

        <!-- Head.Start include area -->
        <?php $APPLICATION->IncludeFile( SITE_TEMPLATE_PATH.'/include/_head.start.php', [], []); ?>
        <!-- // Head.Start include area -->

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bitrix Head -->
        <?php $APPLICATION->ShowHead();?>
        <?php /* if ( CSite::InDir('/cars/new/') || CSite::InDir('/cars/used/') ) { ?>
        <link rel="canonical" href="<?=$APPLICATION->GetProperty("canonical")?>"/>
        <?php } */?>
        <!-- // Bitrix Head -->

        <title><?php $APPLICATION->ShowTitle();?></title>

        <?php 
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/lib/bootstrap.min.css');
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/fonts/font.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/fonts/font.css'));
            $Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/app.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/app.css'));

            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/jquery.min.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/lib/share.js');
            $Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/app.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/app.js'));
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

        <meta property="og:title" content="<?= $APPLICATION->ShowProperty('title');?>"/>
        <meta property="og:description" content="<?= $APPLICATION->ShowProperty('description');?>"/>
        <meta property="og:site_name" content="Юг-Авто — официальный дилер новых и подержанных б/у автомобилей с пробегом в Краснодаре, Новороссийске и Республике Адыгея"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"/>
        <meta property="og:image" content="<?= $APPLICATION->ShowProperty('image', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].SITE_TEMPLATE_PATH.'/assets/images/logo.2023.svg');?>">

    </head>

    <body class="position-relative">

        <?php $APPLICATION->ShowPanel();?>