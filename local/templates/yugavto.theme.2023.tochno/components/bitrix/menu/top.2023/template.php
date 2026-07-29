<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="position-relative my-4">
    <div class="container top-menu">
        <div class="row align-items-center">
            <div class="col-6 text-center text-md-start">
                <a href="/" class="text-decoration-none d-inline-block w-100">
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.2023.svg">
                </a>
            </div>
            <div class="col-6 text-end position-relative d-none d-md-flex justify-content-end align-items-center">
                <a href="tel:<?= YApp::phoneIn('+7 918 46 98 378');?>" class="b-radius-yaradius15 bg-yagray c-yablack c-h-yablack text-decoration-none py-2 px-3 me-4 fw-500 d-none d-lg-inline-block">
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/top-phone.svg" class="me-2" />
                    <?= YApp::phoneOut('+7 918 46 98 378');?>
                </a>
            </div>
        </div>
    </div>
</div>