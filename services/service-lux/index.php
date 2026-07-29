<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Кузовной ремонт и покраска авто в автосервисе Сервис-Люкс в Краснодаре: гарантия на работы, склады запасных частей, новейшее оборудование");
$APPLICATION->SetTitle("Кузовной ремонт и покраска авто в автосервисе Сервис-Люкс в Краснодаре");
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
<div class="bg-yalightbluegray top-container pb-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col">
                <div class="bg-yawhite b-radius-yaradius-24 p-4 title-block">
                    <div class="row">
                        <div class="col-lg-6 position--relative">
                            <?php $h1 = $APPLICATION->GetTitle(false); ?>
                            <img class="title-image position-xl-absolute" src="./assets/images/sl.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                        </div>
                        <div class="col-lg-6 d-flex flex-column justify-content-around align-items-start">
                            <h1 class="h2 text-uppercase">
                                <span class="h3 text-uppercase fw-bold">Центр кузовного ремонта </span><br>
                                «Сервис-Люкс»
                            </h1>
                            <p >
                                активно развивающаяся компания, специализирующаяся на кузовном ремонте и покраске автомобилей.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="bg-yawhite b-radius-yaradius-24 p-4">
                    <h2 class="fw-bold text-uppercase mb-4">Основные преимущества:</h2>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="ps-3 ms-1 me-lg-3">
                                <li class="text-plus h4">Два кузовных центра, размещенные в разных частях города.</li>
                                <li class="text-plus h4">Новейшее оборудование, соответствующее мировым стандартам.</li>
                                <li class="text-plus h4">Замкнутый цикл работ: от мойки и заказа запасных частей до выдачи автомобиля клиенту.</li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="ps-3 ms-1 me-lg-3">
                                <li class="text-plus h4">Охраняемая стоянка, в том числе для автомобилей, ожидающих запасные части.</li>
                                <li class="text-plus h4">Гарантия на выполненные работы — 12 месяцев.</li>
                                <li class="text-plus h4">Возможность записи и предварительный расчёт в онлайн режиме.</li>
                                <li class="text-plus h4">Склад запасных частей в наличии.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col">
            <div class="bg-yalightbluegray b-radius-yaradius-16 p-4">
                <h2 class="fw-bold text-uppercase mb-3">Услуги «Сервис-Люкс»</h2>
                <div class="row">
                    <div class="col-6 col-lg-4 mb-4">
                        <div class="p-4 bg-yawhite sl-service position-relative d-flex align-items-end">
                            <div class="c-yadarkgray text-uppercase fw-bold">Кузовной ремонт</div>
                            <div class="sl-service-footer position-absolute d-flex">
                                <div class="sl-service-footer-right">
                                    <div class="sl-service-footer-right-bottom">
                                        <div class="sl-service-footer-right-bottom-wrap">
                                            <div class="sl-service-footer-right-bottom-wrap-content bg-yalightbluegray">
                                                <div class="sl-service-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    1
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sl-service-footer-right-top w-100 bg-yalightbluegray">
                                        <div class="sl-service-footer-right-top-wrap w-100 bg-yawhite"></div>
                                    </div>
                                </div>
                                <div class="sl-service-footer-left">
                                    <div class="sl-service-footer-left-wrap bg-yalightbluegray h-100">
                                        <div class="sl-service-footer-left-wrap-corner bg-yawhite h-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 mb-4">
                        <div class="p-4 bg-yawhite sl-service position-relative d-flex align-items-end">
                            <div class="c-yadarkgray text-uppercase fw-bold">Покраска</div>
                            <div class="sl-service-footer position-absolute d-flex">
                                <div class="sl-service-footer-right">
                                    <div class="sl-service-footer-right-bottom">
                                        <div class="sl-service-footer-right-bottom-wrap">
                                            <div class="sl-service-footer-right-bottom-wrap-content bg-yalightbluegray">
                                                <div class="sl-service-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    2
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sl-service-footer-right-top w-100 bg-yalightbluegray">
                                        <div class="sl-service-footer-right-top-wrap w-100 bg-yawhite"></div>
                                    </div>
                                </div>
                                <div class="sl-service-footer-left">
                                    <div class="sl-service-footer-left-wrap bg-yalightbluegray h-100">
                                        <div class="sl-service-footer-left-wrap-corner bg-yawhite h-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 mb-4">
                        <div class="p-4 bg-yawhite sl-service position-relative d-flex align-items-end">
                            <div class="c-yadarkgray text-uppercase fw-bold">Ремонт сколов и царапин</div>
                            <div class="sl-service-footer position-absolute d-flex">
                                <div class="sl-service-footer-right">
                                    <div class="sl-service-footer-right-bottom">
                                        <div class="sl-service-footer-right-bottom-wrap">
                                            <div class="sl-service-footer-right-bottom-wrap-content bg-yalightbluegray">
                                                <div class="sl-service-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    3
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sl-service-footer-right-top w-100 bg-yalightbluegray">
                                        <div class="sl-service-footer-right-top-wrap w-100 bg-yawhite"></div>
                                    </div>
                                </div>
                                <div class="sl-service-footer-left">
                                    <div class="sl-service-footer-left-wrap bg-yalightbluegray h-100">
                                        <div class="sl-service-footer-left-wrap-corner bg-yawhite h-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="p-4 bg-yawhite sl-service position-relative d-flex align-items-end">
                            <div class="c-yadarkgray text-uppercase fw-bold">Замена стекол</div>
                            <div class="sl-service-footer position-absolute d-flex">
                                <div class="sl-service-footer-right">
                                    <div class="sl-service-footer-right-bottom">
                                        <div class="sl-service-footer-right-bottom-wrap">
                                            <div class="sl-service-footer-right-bottom-wrap-content bg-yalightbluegray">
                                                <div class="sl-service-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    4
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sl-service-footer-right-top w-100 bg-yalightbluegray">
                                        <div class="sl-service-footer-right-top-wrap w-100 bg-yawhite"></div>
                                    </div>
                                </div>
                                <div class="sl-service-footer-left">
                                    <div class="sl-service-footer-left-wrap bg-yalightbluegray h-100">
                                        <div class="sl-service-footer-left-wrap-corner bg-yawhite h-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="p-4 bg-yawhite sl-service position-relative d-flex align-items-end">
                            <div class="c-yadarkgray text-uppercase fw-bold">Ремонт вмятин без покраски</div>
                            <div class="sl-service-footer position-absolute d-flex">
                                <div class="sl-service-footer-right">
                                    <div class="sl-service-footer-right-bottom">
                                        <div class="sl-service-footer-right-bottom-wrap">
                                            <div class="sl-service-footer-right-bottom-wrap-content bg-yalightbluegray">
                                                <div class="sl-service-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    5
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sl-service-footer-right-top w-100 bg-yalightbluegray">
                                        <div class="sl-service-footer-right-top-wrap w-100 bg-yawhite"></div>
                                    </div>
                                </div>
                                <div class="sl-service-footer-left">
                                    <div class="sl-service-footer-left-wrap bg-yalightbluegray h-100">
                                        <div class="sl-service-footer-left-wrap-corner bg-yawhite h-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="p-4 bg-yawhite sl-service position-relative d-flex align-items-end">
                            <div class="c-yadarkgray text-uppercase fw-bold">Полировка кузова</div>
                            <div class="sl-service-footer position-absolute d-flex">
                                <div class="sl-service-footer-right">
                                    <div class="sl-service-footer-right-bottom">
                                        <div class="sl-service-footer-right-bottom-wrap">
                                            <div class="sl-service-footer-right-bottom-wrap-content bg-yalightbluegray">
                                                <div class="sl-service-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    6
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sl-service-footer-right-top w-100 bg-yalightbluegray">
                                        <div class="sl-service-footer-right-top-wrap w-100 bg-yawhite"></div>
                                    </div>
                                </div>
                                <div class="sl-service-footer-left">
                                    <div class="sl-service-footer-left-wrap bg-yalightbluegray h-100">
                                        <div class="sl-service-footer-left-wrap-corner bg-yawhite h-100"></div>
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
    
<div class="bg-yalightbluegray bottom-container py-5">
    <?$APPLICATION->IncludeComponent(
        "bitrix:form.result.new", 
        "form.block.white", 
        array(
            "CACHE_TIME" => "3600",
            "CACHE_TYPE" => "A",
            "CHAIN_ITEM_LINK" => "",
            "CHAIN_ITEM_TEXT" => "",
            "EDIT_URL" => "result_edit.php",
            "IGNORE_CUSTOM_TEMPLATE" => "N",
            "LIST_URL" => "result_list.php",
            "SEF_MODE" => "N",
            "SUCCESS_URL" => "",
            "USE_EXTENDED_ERRORS" => "N",
            "WEB_FORM_ID" => "17",
            "COMPONENT_TEMPLATE" => "form.block.white",
            "DEALERSHIP" => "",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "DEALERSHIP_CODE" => "",
            "DEALERSHIP_NAME" => "",
            "LOGO" => "",
            "DEALERSHIPS" => "service-lux-krasnodar-dzerzhinskogo,service-lux-yablonovskiy",
            "VARIABLE_ALIASES" => array(
                "WEB_FORM_ID" => "WEB_FORM_ID",
                "RESULT_ID" => "RESULT_ID",
            )
        ),
        false
    );?>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>