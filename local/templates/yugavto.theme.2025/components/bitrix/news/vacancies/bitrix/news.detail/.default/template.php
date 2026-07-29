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
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="p-4 bg-yawhite b-radius-yaradius-16 h-100 vacancy-title d-flex flex-column justify-content-between align-items-start">
                    <h1 class="h2 text-uppercase mb-4"><?=$arResult['NAME'];?></h1>
                    <div><?= $arResult['PREVIEW_TEXT'];?></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 pb-2 bg-yawhite d-flex flex-column justify-content-between align-items-start w-100 h-100 vacancy-address position-relative">
                    <div>
                        <div class="h3 fw-bold"><?= $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['DEALERSHIP']['VALUE']]['NAME'];?></div>
                        <p class="c-yadarkgray text-minus"><?= (($arResult['DEALERSHIP']['~PROPERTY_ADDRESS_VALUE'])?:trim($arResult['PROPERTIES']['TERRITORY']['~VALUE']));?></p>
                    </div>
                    <div class="pay">
                        <div class="h3  fw-bold">
                            <?php
                                $pay = '';
                                if (!empty($arResult['PROPERTIES']['PAY']['~VALUE'] || $arResult['PROPERTIES']['PAY_FROM']['~VALUE'] || $arResult['PROPERTIES']['PAY_TO']['~VALUE'])) {
                                    if ( !empty($arResult['PROPERTIES']['PAY']['~VALUE']) ) {
                                        $pay .= trim(number_format((float)preg_replace('/\D/', '', $arResult['PROPERTIES']['PAY']['~VALUE']), 0, '.', ' ')).' ₽';
                                    } elseif ( !empty($arResult['PROPERTIES']['PAY_FROM']['~VALUE']) && empty($arResult['PROPERTIES']['PAY_TO']['~VALUE']) ) {
                                        $pay .= 'от '.trim(number_format((float)preg_replace('/\D/', '', $arResult['PROPERTIES']['PAY_FROM']['~VALUE']), 0, '.', ' ')).' ₽';
                                    } elseif ( empty($arResult['PROPERTIES']['PAY_FROM']['~VALUE']) && !empty($arResult['PROPERTIES']['PAY_TO']['~VALUE']) ) {
                                        $pay .= 'до '.trim(number_format((float)preg_replace('/\D/', '', $arResult['PROPERTIES']['PAY_FROM']['~VALUE']), 0, '.', ' ')).' ₽';
                                    } elseif ( !empty($arResult['PROPERTIES']['PAY_FROM']['~VALUE']) && !empty($arResult['PROPERTIES']['PAY_TO']['~VALUE']) ) {
                                        $pay .= 'от '.trim(number_format((float)preg_replace('/\D/', '', $arResult['PROPERTIES']['PAY_FROM']['~VALUE']), 0, '.', ' ')).' ₽<br />до '.trim(number_format((float)preg_replace('/\D/', '', $arResult['PROPERTIES']['PAY_TO']['~VALUE']), 0, '.', ' ')).' ₽';
                                    }
                                } else {
                                    $pay .= 'Не указано';
                                }
                            ?>
                            <?= $pay;?>
                        </div>
                        <a
							href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>"
							class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yalightbluegray bg-h-yayellow vacancy-address-button"
						><?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?></a>
                    </div>
                    
                    <div class="vacancy-address-footer position-absolute d-flex">
                        <div class="vacancy-address-footer-left">
                            <div class="vacancy-address-footer-left-wrap bg-yalightbluegray h-100">
                                <div class="vacancy-address-footer-left-wrap-corner bg-yawhite h-100"></div>
                            </div>
                        </div>
                        <div class="vacancy-address-footer-right">
                            <div class="vacancy-address-footer-right-top w-100 bg-yalightbluegray">
                                <div class="vacancy-address-footer-right-top-wrap w-100 bg-yawhite"></div>
                            </div>
                            <div class="vacancy-address-footer-right-bottom">
                                <div class="vacancy-address-footer-right-bottom-wrap">
                                    <div class="vacancy-address-footer-right-bottom-wrap-content bg-yalightbluegray">
                                        <div class="vacancy-address-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if ( !empty($arResult['PROPERTIES']['WATING_ITEMS']['~VALUE']['TEXT']) ) { ?>
            <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="p-4 bg-yawhite h-100 vacancy-future position-relative h-100">
                    <div class="h3 fw-bold text-uppercase vacancy-future-title"><?= ((!empty($arResult['PROPERTIES']['WAITING_TITLE']['VALUE']))?$arResult['PROPERTIES']['WAITING_TITLE']['VALUE']:'ВАС ЖДЕТ:');?></div>
                    <div class="c-yadarkgray text-minus"><?= $arResult['PROPERTIES']['WATING_ITEMS']['~VALUE']['TEXT'];?></div>
                    <div class="vacancy-future-footer position-absolute d-flex">
                        <div class="vacancy-future-footer-left">
                            <div class="vacancy-future-footer-left-wrap bg-yalightbluegray h-100">
                                <div class="vacancy-future-footer-left-wrap-corner bg-yawhite h-100"></div>
                            </div>
                        </div>
                        <div class="vacancy-future-footer-right">
                            <div class="vacancy-future-footer-right-bottom">
                                <div class="vacancy-future-footer-right-bottom-wrap">
                                    <div class="vacancy-future-footer-right-bottom-wrap-content bg-yalightbluegray">
                                        <div class="vacancy-future-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                            1
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vacancy-future-footer-right-top w-100 bg-yalightbluegray">
                                <div class="vacancy-future-footer-right-top-wrap w-100 bg-yawhite"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if ( !empty($arResult['PROPERTIES']['NEED_ITEMS']['~VALUE']['TEXT']) ) { ?>
            <div class="col-lg-4 mb-3 mb-lg-0">
                <div class="p-4 bg-yawhite h-100 vacancy-future position-relative h-100">
                    <div class="h3 fw-bold text-uppercase vacancy-future-title"><?= ((!empty($arResult['PROPERTIES']['NEED_TITLE']['VALUE']))?$arResult['PROPERTIES']['NEED_TITLE']['VALUE']:'Вам <br class="d-xl-none" />потребуется:');?></div>
                    <div class="c-yadarkgray text-minus"><?= $arResult['PROPERTIES']['NEED_ITEMS']['~VALUE']['TEXT'];?></div>
                    <div class="vacancy-future-footer position-absolute d-flex">
                        <div class="vacancy-future-footer-left">
                            <div class="vacancy-future-footer-left-wrap bg-yalightbluegray h-100">
                                <div class="vacancy-future-footer-left-wrap-corner bg-yawhite h-100"></div>
                            </div>
                        </div>
                        <div class="vacancy-future-footer-right">
                            <div class="vacancy-future-footer-right-bottom">
                                <div class="vacancy-future-footer-right-bottom-wrap">
                                    <div class="vacancy-future-footer-right-bottom-wrap-content bg-yalightbluegray">
                                        <div class="vacancy-future-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                            2
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vacancy-future-footer-right-top w-100 bg-yalightbluegray">
                                <div class="vacancy-future-footer-right-top-wrap w-100 bg-yawhite"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if ( !empty($arResult['PROPERTIES']['OFFER_ITEMS']['~VALUE']['TEXT']) ) { ?>
            <div class="col-lg-4">
                <div class="p-4 bg-yawhite h-100 vacancy-future position-relative h-100">
                    <div class="h3 fw-bold text-uppercase vacancy-future-title"><?= ((!empty($arResult['PROPERTIES']['OFFER_TITLE']['VALUE']))?$arResult['PROPERTIES']['OFFER_TITLE']['VALUE']:'Мы <br class="d-xl-none" />предлагаем:');?></div>
                    <div class="c-yadarkgray text-minus"><?= $arResult['PROPERTIES']['OFFER_ITEMS']['~VALUE']['TEXT'];?></div>
                    <div class="vacancy-future-footer position-absolute d-flex">
                        <div class="vacancy-future-footer-left">
                            <div class="vacancy-future-footer-left-wrap bg-yalightbluegray h-100">
                                <div class="vacancy-future-footer-left-wrap-corner bg-yawhite h-100"></div>
                            </div>
                        </div>
                        <div class="vacancy-future-footer-right">
                            <div class="vacancy-future-footer-right-bottom">
                                <div class="vacancy-future-footer-right-bottom-wrap">
                                    <div class="vacancy-future-footer-right-bottom-wrap-content bg-yalightbluegray">
                                        <div class="vacancy-future-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                            3
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vacancy-future-footer-right-top w-100 bg-yalightbluegray">
                                <div class="vacancy-future-footer-right-top-wrap w-100 bg-yawhite"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 mb-3 mb-lg-0">
            <div class="p-4 bg-yalightbluegray h-100 vacancy-description b-radius-yaradius-16">
                <h3 class="fw-bold text-uppercase mb-4"><?= $arResult['IBLOCK']['NAME'];?></h3>
                <div>
                    <?= $arResult['IBLOCK']['~DESCRIPTION'];?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="p-4 bg-yalightbluegray h-100 vacancy-description b-radius-yaradius-16 d-flex flex-column justify-content-between align-items-cente">
                <div>
                    <div class="h4 c-yadarkgray text-uppercase">ТЕРРИТОРИАЛЬНО:</div>
                    <p>
                        <?php if ( $arResult['PROPERTIES']['TERRITORY']['VALUE'] ) { ?>
                            <?= $arResult['PROPERTIES']['TERRITORY']['VALUE'];?>
                        <?php } else { ?>
                            <a href="https://yandex.ru/maps/?ll=<?= $arResult['DEALERSHIP']['PROPERTY_COORDS_LON'];?>,<?= $arResult['DEALERSHIP']['PROPERTY_COORDS_LAT'];?>&z=15&mode=routes&rtext=~<?= $arResult['DEALERSHIP']['PROPERTY_COORDS_LAT'];?>,<?= $arResult['DEALERSHIP']['PROPERTY_COORDS_LON'];?>&rtt=auto&ruri=~" target="_blank" class="c-yablack c-h-yablack text-decoration-none"><?= $arResult['DEALERSHIP']['~PROPERTY_ADDRESS_VALUE'];?></a>
                        <?php } ?>
                    </p>
                </div>
                <div>
                    <div class="h4 c-yadarkgray text-uppercase">ДИЛЕРСКИЙ ЦЕНТР:</div>
                    <p><a href="/dealerships/<?= $arResult['DEALERSHIP']['CODE'];?>/" class="c-yablack c-h-yablack text-decoration-none"><?= $arResult['DEALERSHIP']['NAME'];?></a></p>
                </div>
                <div>
                    <p class="c-yadarkgray">Уважаемые соискатели, мы приглашаем кандидатов на собеседование после рассмотрения резюме. В случае положительного его рассмотрения, сотрудники нашего отдела обязательно с Вами свяжутся.</p>
                </div>
                <div>
                    <p class="">Ждём Ваши отклики!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-yalightbluegray bottom-container py-3 py-lg-5">
    <div class="container sendmail">
        <div class="row">
            <div class="col">
                <div class="p-4 bg-yawhite b-radius-yaradius-16">
                    <div class="row">
                        <div class="col-lg-5 order-1 order-lg-0">
                            <div class="sendmail-title text-uppercase fw-bolder mb-4">Не нашли подходящей вакансии?</div>
                            <div class="sendmail-description c-yadarkgray mb-3">Отправьте нам письмо и мы обязательно его рассмотрим и при актуальности свяжемcя с вами.</div>
                            <a
                                href="mailto:HR@yug-avto.ru"
                                class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yayellow bg-h-yadarkyellow sendmail-button w-75"
                            >Отправить резюме</a>
                        </div>
                        <div class="col-lg-7">
                            <img class="sendmail-img w-100" src="<?= $templateFolder.'/images/sendmail.png';?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>