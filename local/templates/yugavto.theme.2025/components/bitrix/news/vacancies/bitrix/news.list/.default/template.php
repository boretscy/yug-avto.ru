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
<div class="bg-yalightbluegray top-container pb-5">
	<?php include __DIR__.'/filter.php';?>
</div>

<?php if ( empty($arResult['ITEMS']) ) { ?>
<div class="container my-4 text-center">
    <div class="row">
        <div class="col">
            <p class="h2 fw-normal">Ничего не найдено</p>
        </div>
    </div>
</div>
<?php } else { ?>

<div class="container my-4 vacansies">
    <div class="row">
        <?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
        <div class="col-lg-4 mb-4">
            <a 
                href="<?=$arItem['DETAIL_PAGE_URL']?>" 
                class="bg-yalightbluegray c-yablack c-h-yablack vacancies-item text-decoration-none overflow-hidden p-4 pb-3 d-flex flex-column justify-content-between align-items-start w-100 position-relative">
                <div>
                    <div class="h3 block-title"><?=$arItem['NAME']?></div>
                    <p class="c-yadarkgray"><?= $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['DEALERSHIP']['VALUE']]['NAME'];?></p>
                </div>
                <div class="h3 m-0 pay">
                    <?php 
                        $pay = '';
                        if (!empty($arItem['PROPERTIES']['PAY']['~VALUE'] || $arItem['PROPERTIES']['PAY_FROM']['~VALUE'])) {
                            if ( !empty($arItem['PROPERTIES']['PAY']['~VALUE']) ) {
                                $pay .= trim(number_format((float)preg_replace('/\D/', '', $arItem['PROPERTIES']['PAY']['~VALUE']), 0, '.', ' ')).' ₽';
                            } elseif ( !empty($arItem['PROPERTIES']['PAY_FROM']['~VALUE']) ) {
                                $pay .= 'от '.trim(number_format((float)preg_replace('/\D/', '', $arItem['PROPERTIES']['PAY_FROM']['~VALUE']), 0, '.', ' ')).' ₽';
                                if ( !empty($arItem['PROPERTIES']['PAY_TO']['~VALUE']) ) $res .= ' - до '.trim(number_format((float)preg_replace('/\D/', '', $arItem['PROPERTIES']['PAY']['~PAY_FROM']), 0, '.', ' ')).' ₽';
                            }
                        } elseif ( !empty($arItem['PROPERTIES']['PAY_TO']['~VALUE']) ) {
                            $pay .= 'до '.trim(number_format((float)preg_replace('/\D/', '', $arItem['PROPERTIES']['PAY_TO']['~PAY_FROM']), 0, '.', ' ')).' ₽';
                        } else {
                            $pay .= 'Не указано';
                        }
                    ?>
                    <?= $pay;?>
                </div>
                <div class="vacansies-item-footer position-absolute d-flex">
                    <div class="vacansies-item-footer-left">
                        <div class="vacansies-item-footer-left-wrap bg-yawhite h-100">
                            <div class="vacansies-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="vacansies-item-footer-right">
                        <div class="vacansies-item-footer-right-top w-100 bg-yawhite">
                            <div class="vacansies-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="vacansies-item-footer-right-bottom">
                            <div class="vacansies-item-footer-right-bottom-wrap">
                                <div class="vacansies-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="vacansies-item-footer-right-bottom-icon b-radius-yaradius-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>



<?php if ( $arParams["DISPLAY_BOTTOM_PAGER"] ) { ?>
<div class="container my-5 text-minus text-center">
	<div class="row">
		<div class="col"><?= $arResult["NAV_STRING"];?></div>
	</div>
</div>
<?php } // if PAGES ?>

<?php } ?>


