<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Автомобили для корпоративных клиентов");
$APPLICATION->SetPageProperty("description", "Условия корпоративных продаж автомобилей для юридических лиц от официального дилера ЮГ-АВТО.");
$APPLICATION->SetTitle("Автомобили для корпоративных клиентов");
?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
    $Asset->addCss($APPLICATION->GetCurPage().'assets/css/style.css');
    $Asset->addJs($APPLICATION->GetCurPage().'assets/js/script.js');
?>
<style>
	body {background-color: var(--yawhite);}
</style>
<div class="bg-yalightbluegray top-container pb-3 pb-lg-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="p-4 bg-yawhite b-radius-yaradius-16">
                    <h1 class="h2 text-uppercase">Корпоративным клиентам</h1>
                    <div class="h3">Мы с удовольствием сделаем индивидуальное предложение для Вас и Вашего бизнеса.</div>
                    <div class="row">
                        <div class="col-lg-6 position-relative">
                            <?php $h1 = $APPLICATION->GetTitle(false); ?>
                            <img class="title-image position-xl-absolute" src="./assets/images/corp.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                        </div>
                        <div class="col-lg-6 py-4 form-blank">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:form.result.new", 
                                "form.blank", 
                                array(
                                    "CACHE_TIME" => "3600",
                                    "CACHE_TYPE" => "A",
                                    "CHAIN_ITEM_LINK" => "",
                                    "CHAIN_ITEM_TEXT" => "",
                                    "COMPONENT_TEMPLATE" => "form.blank",
                                    "EDIT_URL" => "result_edit.php",
                                    "IGNORE_CUSTOM_TEMPLATE" => "N",
                                    "LIST_URL" => "result_list.php",
                                    "SEF_MODE" => "N",
                                    "SUCCESS_URL" => "",
                                    "USE_EXTENDED_ERRORS" => "N",
                                    "WEB_FORM_ID" => "6",
                                    "DEALERSHIP_CODE" => "",
                                    "DEALERSHIP_NAME" => "",
                                    "LOGO" => "",
                                    "COMPOSITE_FRAME_MODE" => "A",
                                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                                    "VARIABLE_ALIASES" => array(
                                        "WEB_FORM_ID" => "WEB_FORM_ID",
                                        "RESULT_ID" => "RESULT_ID",
                                    )
                                ),
                                false
                            );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container futures my-5">
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Мультибрендовое предложение (15 мировых брендов — от автомобилей бизнес-класса до коммерческих фургонов)</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-car.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Помощь в выборе нового автомобиля с максимальной выгодой и разработка программ технического обслуживания, обмен автомобилей на новые (Трейд-ин) или их выкуп</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-trade-in.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Тест-драйв всех моделей, в том числе возможность проведения выездного тест-драйва</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-steering.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Поддержка государственных программ льготного лизинга, кредитования и утилизации</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-calc.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Льготные тарифы страхования с дополнительной выгодой для вашей компании</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-tarifs.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Выгодные тарифы на техническое обслуживание, выполнение ремонта любой сложности</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-cog.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Широкий спектр дополнительного оборудования и аксессуаров</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-message.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Обслуживание мультибрендового автопарка, удаленное урегулирование убытков и лизинг</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-cog.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div 
                class="bg-yalightbluegray c-yablack c-h-yablack futures-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                <div>Постоянное наличие большого ассортимента запчастей и расходных материалов для обеспечения оперативного сервиса</div>
                <div class="futures-item-footer position-absolute d-flex">
                    <div class="futures-item-footer-left">
                        <div class="futures-item-footer-left-wrap bg-yawhite h-100">
                            <div class="futures-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                        </div>
                    </div>
                    <div class="futures-item-footer-right">
                        <div class="futures-item-footer-right-top w-100 bg-yawhite">
                            <div class="futures-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                        </div>
                        <div class="futures-item-footer-right-bottom">
                            <div class="futures-item-footer-right-bottom-wrap">
                                <div class="futures-item-footer-right-bottom-wrap-content bg-yawhite">
                                    <div class="futures-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                        <img src="./assets/images/svg/icon-corporate-futures-brake.svg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="bg-yalightbluegray bottom-container py-3 py-lg-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col">
                <div class="p-4 bg-yawhite b-radius-yaradius-16">
                    <h2 class="text-uppercase">Готовы обсудить наше<br />взаимовыгодное сотрудничество:</h2>
                    <div class="row">
                        <div class="col-lg-4 mb-3 mb-lg-0">
                            <div 
                                class="bg-yalightbluegray c-yablack c-h-yablack managers-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative d-flex flex-column justify-content-start align-items-start">
                                <div>
                                    <h3>Артур Белимготов</h3>
                                    <div class="c-yadarkgray">Руководитель подразделения корпоративных продаж</div>
                                </div>
                                <div>
                                    <a href="tel:+78612031866" class="c-yablack c-h-yablack d-block text-decoration-none">
                                        +7 (861) 203-18-66 доб. (1081)
                                    </a> 
                                    <a href="mailto:Artur.belimgotov@yug-avto.ru" 
                                        class="c-yadarkgray c-h-yadarkgray d-block text-minus text-decoration-none"
                                        >Artur.belimgotov@yug-avto.ru
                                    </a>
                                </div>
                                <div class="managers-item-footer position-absolute d-flex">
                                    <div class="managers-item-footer-left">
                                        <div class="managers-item-footer-left-wrap bg-yawhite h-100">
                                            <div class="managers-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                        </div>
                                    </div>
                                    <div class="managers-item-footer-right">
                                        <div class="managers-item-footer-right-top w-100 bg-yawhite">
                                            <div class="managers-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                        </div>
                                        <div class="managers-item-footer-right-bottom">
                                            <div class="managers-item-footer-right-bottom-wrap">
                                                <div class="managers-item-footer-right-bottom-wrap-content bg-yawhite">
                                                    <div class="managers-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                        <img src="./assets/images/svg/icon-corporate-managers-contacts.svg?2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3 mb-lg-0">
                            <div 
                                class="bg-yalightbluegray c-yablack c-h-yablack managers-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative d-flex flex-column justify-content-start align-items-start">
                                <div>
                                    <h3>Софья Белоусова</h3>
                                    <div class="c-yadarkgray">Специалист по взаимодействию с лизинговыми компаниями</div>
                                </div>
                                <div>
                                    <a href="tel:+78612031866" class="c-yablack c-h-yablack d-block text-decoration-none">
                                        +7 (861) 210 00 44
                                    </a> 
                                    <a href="mailto:sofya.belousova@yug-avto.ru" 
                                        class="c-yadarkgray c-h-yadarkgray d-block text-minus text-decoration-none"
                                        >sofya.belousova@yug-avto.ru
                                    </a>
                                </div>
                                <div class="managers-item-footer position-absolute d-flex">
                                    <div class="managers-item-footer-left">
                                        <div class="managers-item-footer-left-wrap bg-yawhite h-100">
                                            <div class="managers-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                        </div>
                                    </div>
                                    <div class="managers-item-footer-right">
                                        <div class="managers-item-footer-right-top w-100 bg-yawhite">
                                            <div class="managers-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                        </div>
                                        <div class="managers-item-footer-right-bottom">
                                            <div class="managers-item-footer-right-bottom-wrap">
                                                <div class="managers-item-footer-right-bottom-wrap-content bg-yawhite">
                                                    <div class="managers-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                        <img src="./assets/images/svg/icon-corporate-managers-contacts.svg?2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div 
                                class="bg-yalightbluegray c-yablack c-h-yablack managers-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative d-flex flex-column justify-content-start align-items-start">
                                <div>
                                    <h3>Игорь Ларин</h3>
                                    <div class="c-yadarkgray">Специалист по тендерам</div>
                                </div>
                                <div>
                                    <a href="tel:+78612031866" class="c-yablack c-h-yablack d-block text-decoration-none">
                                        +7 (861) 203-18-66 доб. (51067)
                                    </a> 
                                    <a href="mailto:igor.larin@yug-avto.ru" 
                                        class="c-yadarkgray c-h-yadarkgray d-block text-minus text-decoration-none"
                                        >igor.larin@yug-avto.ru
                                    </a>
                                </div>
                                <div class="managers-item-footer position-absolute d-flex">
                                    <div class="managers-item-footer-left">
                                        <div class="managers-item-footer-left-wrap bg-yawhite h-100">
                                            <div class="managers-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                        </div>
                                    </div>
                                    <div class="managers-item-footer-right">
                                        <div class="managers-item-footer-right-top w-100 bg-yawhite">
                                            <div class="managers-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                        </div>
                                        <div class="managers-item-footer-right-bottom">
                                            <div class="managers-item-footer-right-bottom-wrap">
                                                <div class="managers-item-footer-right-bottom-wrap-content bg-yawhite">
                                                    <div class="managers-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                        <img src="./assets/images/svg/icon-corporate-managers-contacts.svg?2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="p-4 bg-yawhite b-radius-yaradius-16">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:news.list", 
                        "corp.manager", 
                        [
                            "COMPONENT_TEMPLATE" => "corp.manager",
                            "IBLOCK_TYPE" => "content",
                            "IBLOCK_ID" => "16",
                            "NEWS_COUNT" => "65",
                            "SORT_BY1" => "SORT",
                            "SORT_ORDER1" => "ASC",
                            "SORT_BY2" => "",
                            "SORT_ORDER2" => "",
                            "FILTER_NAME" => "",
                            "FIELD_CODE" => [
                                0 => "",
                                1 => "",
                            ],
                            "PROPERTY_CODE" => [
                                0 => "POSITION",
                                1 => "PHONE",
                                2 => "PHONE_CODE",
                                3 => "EMAIL",
                                4 => "",
                            ],
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "SET_TITLE" => "Y",
                            "SET_BROWSER_TITLE" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_LAST_MODIFIED" => "N",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "STRICT_SECTION_CHECK" => "N",
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "PAGER_TEMPLATE" => ".default",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "PAGER_TITLE" => "Новости",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "SET_STATUS_404" => "N",
                            "SHOW_404" => "N",
                            "MESSAGE_404" => "",
                            "DISPLAY_TITLE" => "Корпоративные менеджеры брендов",
                            "DISPLAY_DISCLAMER" => "*Корпоративными клиентами считаются юридические лица; лица, зарегистрированные как индивидуальные предприниматели; государственные учреждения; органы государственной власти и местного самоуправления; дипломатические службы; посольства.",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO"
                        ],
                        false
                    );?>
                </div>
            </div>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>