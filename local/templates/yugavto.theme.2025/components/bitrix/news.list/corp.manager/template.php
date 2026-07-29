<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="row">
    <div class="col">
        <div class="h2 text-uppercase"><?= $arParams['DISPLAY_TITLE'];?></div>
    </div>
</div>
<div class="row my-4 brands">
    <?php foreach ( $arResult['ITEMS'] as $k => $arSection ) { ?>
    <div class="col-lg-4 mb-3">
        <a 
            href="#CORP_<?= $arSection['CODE'];?>"
            data-remodal-target="CORP_<?= $arSection['CODE'];?>"
            role="brand" 
            <?php /*  data-target="CORP_<?= $arSection['CODE'];?>" */ ?>
            class="bg-yalightbluegray b-radius-yaradius-16 c-yablack c-h-yadarkgray p-4 d-flex justify-content-between align-items-center block-title-link brands-item">
            <span><?= $arSection['NAME'];?></span>
            <span class="brands-item-icon info-arrow"></span>
        </a>
    </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col text-minus">
        * Корпоративными клиентами считаются юридические лица; лица, зарегистрированные как индивидуальные предприниматели; государственные учреждения; органы государственной власти и местного самоуправления; дипломатические службы; посольства.
    </div>
</div>

<?php foreach ( $arResult['ITEMS'] as $arSection ) { ?>
<div class="remodal remodal-big p-5 text-start b-radius-yaradius-16" data-remodal-id="CORP_<?= $arSection['CODE'];?>">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="row mb-3">
		<div class="col">
			<div class="row">
				<div class="col-12">
					<div class="h3 block-title">Корпоративные менеджеры бренда <?= $arSection['NAME'];?></div>
				</div>
			</div>
            <div class="row mb-4">
				<div class="col-12">
                    <?php foreach ( $arSection['ITEMS'] as $arItem ) { ?>
                    <div class="text-plus"><?= $arItem['NAME'];?></div>
                    <div class="c-yadarkgray mb-3"><?= $arItem['PROPERTIES']['POSITION']['VALUE'];?></div>
                    <div class="text-plus">
                        <a href="tel:<?= YApp::phoneIn($arItem['PROPERTIES']['PHONE']['VALUE']);?>" class="c-yablack c-h-yablack text-decoration-none"><?= YApp::phoneOut($arItem['PROPERTIES']['PHONE']['VALUE']);?></a> 
                        <?= (($arItem['PROPERTIES']['PHONE_CODE']['VALUE'])?'доб. ('.$arItem['PROPERTIES']['PHONE_CODE']['VALUE'].')':'');?>
                    </div>
                    <div class="c-yadarkgray mb-4">
                        <a class="c-yadarkgray c-h-yadarkgray" 
                        href="mailto:<?= $arItem['PROPERTIES']['EMAIL']['VALUE'];?>"
                        >
                            <?= $arItem['PROPERTIES']['EMAIL']['VALUE'];?>
                        </a>
                    </div>
                    <?php } ?>
                </div>
			</div>
            <div class="row">
				<?php foreach ( $arResult['ITEMS'] as $k => $arSection ) { ?>
                <div class="col-lg-4 mb-3">
                    <a 
                        href="#"
                        data-remodal-target="CORP_<?= $arSection['CODE'];?>"
                        role="brand" 
                        <?php /* data-target="CORP_<?= $arSection['CODE'];?>" */ ?>
                        class="bg-yalightbluegray b-radius-yaradius-16 c-yablack c-h-yadarkgray p-2 d-flex justify-content-between align-items-center block-title-link modal-brands-item">
                        <span><?= $arSection['NAME'];?></span>
                        <span class="brands-item-icon info-arrow"></span>
                    </a>
                </div>
                <?php } ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php /*
<div class="corp-modal-cover w-100 h-100 position-fixed top-0"></div>
<?php foreach ( $arResult['ITEMS'] as $arSection ) { ?>
<div class="position-fixed p-4 corp-modal bg-yawhite h-100 top-0" data-target="CORP_<?= $arSection['CODE'];?>">
    <div class="d-flex justify-content-end">
        <a href="#" class="corp-modal-close">
            <img class="" src="<?= $templateFolder.'/images/cross.svg';?>" />
        </a>
    </div>
    <div class="corp-modal-content">
        <div class="h2 my-4">Корпоративные менеджеры<br />бренда <?= $arSection['NAME'];?></div>
        <?php foreach ( $arSection['ITEMS'] as $arItem ) { ?>
        <div class="text-plus"><?= $arItem['NAME'];?></div>
        <div class="c-yadarkgray mb-3"><?= $arItem['PROPERTIES']['POSITION']['VALUE'];?></div>
        <div class="text-plus">
            <a href="tel:<?= YApp::phoneIn($arItem['PROPERTIES']['PHONE']['VALUE']);?>" class="c-yablack c-h-yablack text-decoration-none"><?= YApp::phoneOut($arItem['PROPERTIES']['PHONE']['VALUE']);?></a> 
            <?= (($arItem['PROPERTIES']['PHONE_CODE']['VALUE'])?'доб. ('.$arItem['PROPERTIES']['PHONE_CODE']['VALUE'].')':'');?>
        </div>
        <div class="c-yadarkgray mb-4">
            <a class="c-yadarkgray c-h-yadarkgray" 
            href="mailto:<?= $arItem['PROPERTIES']['EMAIL']['VALUE'];?>"
            >
                <?= $arItem['PROPERTIES']['EMAIL']['VALUE'];?>
            </a>
        </div>
        <?php } ?>
        <div class="row">
            <?php foreach ( $arResult['ITEMS'] as $k => $arSection ) { ?>
            <div class="col-lg-4 <?= (($k+1<count($arResult['ITEMS'])-3)?'mb-3':'');?>">
                <a 
                    href="#"
                    <?php /*data-remodal-target="CORP_<?= $arSection['CODE'];?>" */ /* ?>
                    role="brand" 
                    data-target="CORP_<?= $arSection['CODE'];?>"
                    class="bg-yalightbluegray b-radius-yaradius-16 c-yablack c-h-yadarkgray p-2 d-flex justify-content-between align-items-center block-title-link modal-brands-item">
                    <span><?= $arSection['NAME'];?></span>
                    <span class="brands-item-icon info-arrow"></span>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } */ ?>

