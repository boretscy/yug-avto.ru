<?php

// ini_set('error_reporting', E_ALL & ~E_NOTICE);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

CModule::IncludeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

require __DIR__.'/../local/php_interface/Employees/Employees.php';
$user = Employees::getUser( explode('/', $_SERVER['REQUEST_URI'])[2] );
$user = Employees::makeSite( $user );
$user = Employees::makeSocial( $user );
$user = Employees::selectDesign( $user );

if ( $user['status'] ) Employees::makeVCard( $user, $user['UF_FULL_NAME'].'.vcf' );

$APPLICATION->SetTitle('Сотрудники');
if ( $user['status'] ) {
    $APPLICATION->SetTitle($user['LAST_NAME'].' '.$user['NAME'].', '.$user['WORK_POSITION'].', '.$user['WORK_COMPANY']);
    $APPLICATION->AddChainItem($user['LAST_NAME'].' '.$user['NAME'], '');
}

use Bitrix\Main\Page\Asset;
$Asset = Asset::getInstance();
$Asset->addCss(SITE_TEMPLATE_PATH.'/assets/css/design/'.$user['DESIGN'].'.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/css/design/'.$user['DESIGN'].'.css'));

$Asset->addJs(SITE_TEMPLATE_PATH.'/assets/js/app.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/js/app.js'));

if ( $_GET['photo'] == 'no' ) $user['PERSONAL_PHOTO'] = false;
?>
<?php if ( $user['status'] ) { ?>
<div class="container py-4">
    <div class="row">
        <div class="col-6 d-flex justify-content-start align-items-center">
            <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/logo.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/logo.svg');?>" class="logo" />
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <!-- <div class="ya-share2 " data-curtain data-shape="round" data-color-scheme="whiteblack" data-limit="0" data-more-button-type="short" data-services="vkontakte,telegram,whatsapp,skype"></div>   -->

            <a href="../vcards/<?= $user['UF_FULL_NAME'].'.vcf';?>" target="_blank" download class="social bg-yasocial d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton">
                <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-download.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-download.svg');?>" />
            </a>
        </div>
    </div>
</div>
<div class="container mt-4 bg-yatopbg pt-4">
    <?php if ( $user['PERSONAL_PHOTO'] ) { ?>
    <div class="row whisphoto position-relative">
        <div class="col text-center">
            <img src="<?= $user['PHOTO'];?>" class="b-yacircle b-radius-circle photo" />
        </div>
    </div>  
    <div class="row bg-yabottombg b-radius-top-yabigbg pt-5 text-center">
        <div class="col pt-5">
            <h1 class="fw-bold s-yasmalltitle c-yatitle"><?= $user['UF_FULL_NAME'];?></h1>
            <div class="s-yasmallbutton c-yatextphoto mt-4"><?= $user['WORK_POSITION'];?><br /><?= $user['WORK_COMPANY'];?></div>
        </div>
    </div>
    <?php } else { ?>
    <div class="row text-center mb-3">
        <div class="col">
            <h1 class="fw-bold s-yabigtitle c-yatitlephoto"><?= $user['UF_FULL_NAME'];?></h1>
            <div class="s-yatext c-yatextnophoto mt-4"><?= $user['WORK_POSITION'];?><br /><?= $user['WORK_COMPANY'];?></div>
        </div>
    </div>
    <div class="row bg-yabottombg b-radius-top-yasmallbg pt-3 text-center">
        <div class="col">
        </div>
    </div>
    <?php } ?>
    <div class="row bg-yabottombg pt-4">
        <div class="col">
            <?php if ( $user['PERSONAL_MOBILE'] ) { ?>    
            <a href="tel:+<?= YApp::phoneIn($user['PERSONAL_MOBILE']);?>" class="button s-yabigbutton bg-yalink c-yatext d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton mb-2 fw-medium">
                <span class="icon d-flex justify-content-center align-items-center b-radius-yabuttonicon bg-yalink me-2">
                    <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-phone-b.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-phone-b.svg');?>" />
                </span>
                <span><?= YApp::phoneOut($user['PERSONAL_MOBILE']);?></span>
            </a>
            <?php } ?>
            <?php if ( $user['WORK_PHONE'] ) { ?>   
            <a href="tel:+<?= YApp::phoneIn($user['WORK_PHONE']);?>" class="button s-yabigbutton bg-yasecondbutton c-yatext d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton mb-2 fw-medium">
                <span class="icon d-flex justify-content-center align-items-center b-radius-yabuttonicon bg-yabottombg me-2">
                    <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-phone.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-phone.svg');?>" />
                </span>
                <span><?= YApp::phoneOut($user['WORK_PHONE']);?></span>
            </a>
            <?php } ?>
            <?php if ( $user['PERSONAL_CITY'] && $user['PERSONAL_STREET'] ) { ?>
            <a href="https://yandex.ru/maps/?text=<?= $user['PERSONAL_CITY'];?>, <?= $user['PERSONAL_STREET'];?>" target="_blank" class="button s-yasmallbutton bg-yasecondbutton c-yatext d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton mb-2">
                <span class="icon d-flex justify-content-center align-items-center b-radius-yabuttonicon bg-yabottombg me-2">
                    <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-navi.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-navi.svg');?>" />
                </span>
                <span><?= $user['PERSONAL_CITY'];?>, <?= $user['PERSONAL_STREET'];?></span>
            </a>
            <?php } ?>
            <?php if ( $user['EMAIL'] ) { ?>   
            <a href="mailto:<?= $user['EMAIL'];?>" class="button s-yasmallbutton bg-yasecondbutton c-yatext d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton mb-2">
                <span class="icon d-flex justify-content-center align-items-center b-radius-yabuttonicon bg-yabottombg me-2">
                    <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-email.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-email.svg');?>" />
                </span>
                <span><?= $user['EMAIL'];?></span>
            </a>
            <?php } ?>
            <?php if ( $user['SITE'] ) { ?>   
            <a href="<?= $user['SITE'];?>" target="_blank" class="button s-yasmallbutton bg-yasecondbutton c-yatext d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton">
                <span class="icon d-flex justify-content-center align-items-center b-radius-yabuttonicon bg-yabottombg me-2">
                    <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-globe.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-globe.svg');?>" />
                </span>
                <span><?= $user['SITE'];?></span>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
<div class="container footer bg-yabottombg">
    <div class="row py-3 pb-5">
        <div class="col d-flex justify-content-center align-items-top">
            <a href="<?= $user['WHATSAPP'];?>" target="_blank" class="social bg-yasocial d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton">
                <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-whatsapp.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-whatsapp.svg');?>" />
            </a>
            <a href="<?= $user['TELEGRAM'];?>" target="_blank" class="social bg-yasocial d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton mx-4">
                <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-telegram.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-telegram.svg');?>" />
            </a>
            <!-- <a href="../vcards/<?= $user['UF_FULL_NAME'].'.vcf';?>" target="_blank" download class="social bg-yasocial d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton me-4">
                <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-download.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-download.svg');?>" />
            </a> -->
            <a href="#" class="social bg-yasocial d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton" role="qr">
                <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-qr.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-qr.svg');?>" />
            </a>
        </div>
    </div>
</div>

<div class="qr-cover position-absolute top-0 left-0 w-100 h-100"></div>
<div class="qr-container b-radius-top-yabigbg position-absolute w-100 bg-yawhite p-4" role="close">
    <div class="close position-absolute cursor-pointer"><img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-cross.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon- .svg');?>" /></div>
    <div class="h-100 w-100 d-flex justify-content-center align-items-center">
        <img src="/employees/qrgen.php?id=<?= $user['ID'];?>&name=<?= $user['UF_FULL_NAME'];?>&design=<?= $user['DESIGN'];?>" />
    </div>
</div>
<?php } else { ?>
<?php
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");

// Вывод телефона из highloadblock
$hlbl = 1;
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$res = $entity_data_class::getList(['select'=>['*']]);
foreach ( $res->fetchAll() as $itemHl ) $user['PHONE'] = $itemHl['UF_VALUE'];
?>
<div class="container py-4">
    <div class="row">
        <div class="col-6 d-flex justify-content-start align-items-center">
            <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/all/logo.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/all/logo.svg');?>" class="logo" />
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <!-- <div class="ya-share2 " data-curtain data-shape="round" data-color-scheme="whiteblack" data-limit="0" data-more-button-type="short" data-services="vkontakte,telegram,whatsapp,skype"></div>   -->
        </div>
    </div>
</div>
<div class="container mt-4 bg-yatopbg pt-4">
    <div class="row whisphoto position-relative">
        <div class="col text-center">
            <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/user.404.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/user.404.svg');?>" class="b-radius-circle photo" />
        </div>
    </div>
    <div class="row bg-yabottombg b-radius-top-yabigbg pt-5 text-center">
        <div class="col pt-5">
            <h1 class="fw-bold s-yasmalltitle c-yatitle _404">404</h1>
            <div class="s-yasmallbutton c-yatextphoto mt-4 text-uppercase _404">ТАКОЙ СОТРУДНИК<br />НЕ НАЙДЕН</div>
        </div>
    </div>
    <div class="row bg-yabottombg pt-4 pb-5">
        <div class="col"> 
            <a href="tel:+<?= YApp::phoneIn($user['PHONE']);?>" class="button s-yabigbutton bg-yalink c-yatext d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton mb-2 fw-medium">
                <span class="icon d-flex justify-content-center align-items-center b-radius-yabuttonicon bg-yalink me-2">
                    <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-phone-b.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-phone-b.svg');?>" />
                </span>
                <span><?= YApp::phoneOut($user['PHONE']);?></span>
            </a>
            <a href="https://yug-avto.ru" target="_blank" class="button s-yasmallbutton bg-yasecondbutton c-yatext d-flex justify-content-center align-items-center text-decoration-none b-radius-yabutton">
                <span class="icon d-flex justify-content-center align-items-center b-radius-yabuttonicon bg-yabottombg me-2">
                    <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-globe.svg?'.md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/'.$user['DESIGN'].'/icon-globe.svg');?>" />
                </span>
                <span>yug-avto.ru</span>
            </a>
        </div>
    </div>
    <div class="row bg-yabottombg pt-4 pb-5"></div>
</div>
<?php } ?> 

<?php // Yapp::sp( $user ); ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>