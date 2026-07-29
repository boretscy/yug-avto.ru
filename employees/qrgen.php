<?php

		
ini_set('error_reporting', E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$dd = '/var/www/admin/data/www/yug-avto.ru';
require_once $dd.'/local/php_interface/vendor/autoload.php';


use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

if ( $_GET['id'] ) {

    $arConf = require __DIR__.'/Conf/'.$_GET['design'].'.php';

    $writer = new PngWriter();
    $url = 'https://yug-avto.ru/employees/'.$_GET['name'].' ('.$_GET['id'].')/';

    // Create QR code
    $qrCode = QrCode::create(str_replace(' ', '%20', $url))
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
        ->setSize(250)
        ->setMargin(0)
        ->setRoundBlockSizeMode(RoundBlockSizeMode::Shrink)
        ->setForegroundColor(new Color($arConf['qr']['pixelColor']['r'], $arConf['qr']['pixelColor']['g'], $arConf['qr']['pixelColor']['b']))
        ->setBackgroundColor(new Color(255, 255, 255));


    $result = $writer->write($qrCode);

    header('Content-Type: '.$result->getMimeType());
    echo $result->getString();
}


