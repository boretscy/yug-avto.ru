<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Обменяйте свой старый автомобиль на новый или подержанный в Юг-Авто. Честная оценка авто и выгодные условия обмена по программе Трейд-ин");
$APPLICATION->SetTitle("Обмен автомобилей по программе Трейд-ин в Юг-Авто");
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
            <div class="col"><h1 class="h2 text-uppercase">Выкуп и оценка автомобиля</h1></div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="bg-yawhite b-radius-yaradius-16 p-4 title-block">
                    <div class="row">
                        <div class="col-lg-6 position-relative">
                            <?php $h1 = $APPLICATION->GetTitle(false); ?>
                            <img src="./assets/images/title-image.png" class="title-image" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                        </div>
                        <div class="col-lg-6">
                            <h3 class="fw-bold text-uppercase mb-4">
                                Время пришло…
                            </h3>
                            <p>Ваш автомобиль служил вам верой и правдой, но появились причины с ним расстаться. </p>
                            <p class="fw-bold">Юг-Авто выкупит Ваш автомобиль по рыночной стоимости за 2 часа!</p>
                            <p>Наши специалисты проведут объективную оценку транспортного средства с учетом его состояния, года выпуска, пробега и предложат вам ценовое предложение, превышающее рыночный минимум на 10%.</p>
                            <p>Мы рассчитаем реальную рыночную стоимость и предоставим ее в виде отчета, со всеми необходимыми параметрами для понимания текущей рыночной конъюнктуры. </p>
                            <p>Если цена вас устроит, заключается договор и производится выкуп автомобиля.</p>
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
            <h2 class="text-uppercase mb-3 ps-2 ps-lg-0">Всего 3 шага,чтобы получить деньги за свой автомобиль:</h2>
            <div class="row">
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="p-4 bg-yalightbluegray h-100 trade-in-future position-relative h-100">
                        <div class="h3 fw-bold text-uppercase trade-in-future-title">Свяжитесь с нами</div>
                        <div class="c-yadarkgray text-minus">Мы уточним данные об авто и желаемую Вами сумму оценки. Согласуем с Вами время и место осмотра автомобиля.</div>
                        <div class="trade-in-future-footer position-absolute d-flex">
                            <div class="trade-in-future-footer-left">
                                <div class="trade-in-future-footer-left-wrap bg-yawhite h-100">
                                    <div class="trade-in-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                </div>
                            </div>
                            <div class="trade-in-future-footer-right">
                                <div class="trade-in-future-footer-right-bottom">
                                    <div class="trade-in-future-footer-right-bottom-wrap">
                                        <div class="trade-in-future-footer-right-bottom-wrap-content bg-yawhite">
                                            <div class="trade-in-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                1
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="trade-in-future-footer-right-top w-100 bg-yawhite">
                                    <div class="trade-in-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="p-4 bg-yalightbluegray h-100 trade-in-future position-relative h-100">
                        <div class="h3 fw-bold text-uppercase trade-in-future-title">Оценка автомобиля</div>
                        <div class="c-yadarkgray text-minus">Мы проведем осмотр Вашего авто там, где удобно Вам и предложим оценочную стоимость автомобиля.</div>
                        <div class="trade-in-future-footer position-absolute d-flex">
                            <div class="trade-in-future-footer-left">
                                <div class="trade-in-future-footer-left-wrap bg-yawhite h-100">
                                    <div class="trade-in-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                </div>
                            </div>
                            <div class="trade-in-future-footer-right">
                                <div class="trade-in-future-footer-right-bottom">
                                    <div class="trade-in-future-footer-right-bottom-wrap">
                                        <div class="trade-in-future-footer-right-bottom-wrap-content bg-yawhite">
                                            <div class="trade-in-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                2
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="trade-in-future-footer-right-top w-100 bg-yawhite">
                                    <div class="trade-in-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="p-4 bg-yalightbluegray h-100 trade-in-future position-relative h-100">
                        <div class="h3 fw-bold text-uppercase trade-in-future-title">Сделка и выплата</div>
                        <div class="c-yadarkgray text-minus">При Вашем положительном решении, оформим документы и выплатим полную стоимость в течении 15 минут.</div>
                        <div class="trade-in-future-footer position-absolute d-flex">
                            <div class="trade-in-future-footer-left">
                                <div class="trade-in-future-footer-left-wrap bg-yawhite h-100">
                                    <div class="trade-in-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                </div>
                            </div>
                            <div class="trade-in-future-footer-right">
                                <div class="trade-in-future-footer-right-bottom">
                                    <div class="trade-in-future-footer-right-bottom-wrap">
                                        <div class="trade-in-future-footer-right-bottom-wrap-content bg-yawhite">
                                            <div class="trade-in-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="trade-in-future-footer-right-top w-100 bg-yawhite">
                                    <div class="trade-in-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
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
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="bg-yawhite b-radius-yaradius-16 p-4">
                    <h2 class="text-uppercase mb-3">Почему стоит обращаться к нам?</h2>
                    <div class="row">
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <div 
                                class="bg-yalightbluegray c-yablack c-h-yablack trade-in-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                                <div>
                                    <div class="h3 block-title text-uppercase fw-bold">Быстро</div>
                                    <p class="c-yadarkgray">Выкуп авто за день</p>
                                </div>
                                <div class="trade-in-item-footer position-absolute d-flex">
                                    <div class="trade-in-item-footer-left">
                                        <div class="trade-in-item-footer-left-wrap bg-yawhite h-100">
                                            <div class="trade-in-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                        </div>
                                    </div>
                                    <div class="trade-in-item-footer-right">
                                        <div class="trade-in-item-footer-right-top w-100 bg-yawhite">
                                            <div class="trade-in-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                        </div>
                                        <div class="trade-in-item-footer-right-bottom">
                                            <div class="trade-in-item-footer-right-bottom-wrap">
                                                <div class="trade-in-item-footer-right-bottom-wrap-content bg-yawhite">
                                                    <div class="trade-in-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                        <img src="./assets/images/svg/icon-trade-in-clock.svg" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <div 
                                class="bg-yalightbluegray c-yablack c-h-yablack trade-in-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                                <div>
                                    <div class="h3 block-title text-uppercase fw-bold">Выгодно</div>
                                    <p class="c-yadarkgray">Оценка авто по рыночной цене</p>
                                </div>
                                <div class="trade-in-item-footer position-absolute d-flex">
                                    <div class="trade-in-item-footer-left">
                                        <div class="trade-in-item-footer-left-wrap bg-yawhite h-100">
                                            <div class="trade-in-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                        </div>
                                    </div>
                                    <div class="trade-in-item-footer-right">
                                        <div class="trade-in-item-footer-right-top w-100 bg-yawhite">
                                            <div class="trade-in-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                        </div>
                                        <div class="trade-in-item-footer-right-bottom">
                                            <div class="trade-in-item-footer-right-bottom-wrap">
                                                <div class="trade-in-item-footer-right-bottom-wrap-content bg-yawhite">
                                                    <div class="trade-in-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                        <img src="./assets/images/svg/icon-trade-in-wallet.svg" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <div 
                                class="bg-yalightbluegray c-yablack c-h-yablack trade-in-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                                <div>
                                    <div class="h3 block-title text-uppercase fw-bold">Удобно</div>
                                    <p class="c-yadarkgray">Все документы оформляются нашими специалистами</p>
                                </div>
                                <div class="trade-in-item-footer position-absolute d-flex">
                                    <div class="trade-in-item-footer-left">
                                        <div class="trade-in-item-footer-left-wrap bg-yawhite h-100">
                                            <div class="trade-in-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                        </div>
                                    </div>
                                    <div class="trade-in-item-footer-right">
                                        <div class="trade-in-item-footer-right-top w-100 bg-yawhite">
                                            <div class="trade-in-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                        </div>
                                        <div class="trade-in-item-footer-right-bottom">
                                            <div class="trade-in-item-footer-right-bottom-wrap">
                                                <div class="trade-in-item-footer-right-bottom-wrap-content bg-yawhite">
                                                    <div class="trade-in-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                        <img src="./assets/images/svg/icon-trade-in-like.svg" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <div 
                                class="bg-yalightbluegray c-yablack c-h-yablack trade-in-item text-decoration-none overflow-hidden p-4 pb-3 w-100 position-relative">
                                <div>
                                    <div class="h3 block-title text-uppercase fw-bold">Надежно</div>
                                    <p class="c-yadarkgray">Сделка осуществляется согласно всем требованиям законодательства РФ</p>
                                </div>
                                <div class="trade-in-item-footer position-absolute d-flex">
                                    <div class="trade-in-item-footer-left">
                                        <div class="trade-in-item-footer-left-wrap bg-yawhite h-100">
                                            <div class="trade-in-item-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                        </div>
                                    </div>
                                    <div class="trade-in-item-footer-right">
                                        <div class="trade-in-item-footer-right-top w-100 bg-yawhite">
                                            <div class="trade-in-item-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                        </div>
                                        <div class="trade-in-item-footer-right-bottom">
                                            <div class="trade-in-item-footer-right-bottom-wrap">
                                                <div class="trade-in-item-footer-right-bottom-wrap-content bg-yawhite">
                                                    <div class="trade-in-item-footer-right-bottom-icon b-radius-yaradius-12 d-flex justify-content-center align-items-center bg-yalightbluegray">
                                                        <img src="./assets/images/svg/icon-trade-in-warranty.svg" />
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
    </div>
    <?$APPLICATION->IncludeComponent(
        "bitrix:form.result.new", 
        "form.block.white", 
        array(
            "CACHE_TIME" => "3600",
            "CACHE_TYPE" => "A",
            "CHAIN_ITEM_LINK" => "",
            "CHAIN_ITEM_TEXT" => "",
            "COMPONENT_TEMPLATE" => "form.block.white",
            "EDIT_URL" => "result_edit.php",
            "IGNORE_CUSTOM_TEMPLATE" => "N",
            "LIST_URL" => "result_list.php",
            "SEF_MODE" => "N",
            "SUCCESS_URL" => "",
            "USE_EXTENDED_ERRORS" => "N",
            "WEB_FORM_ID" => "11",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "DEALERSHIP" => "",
            "DEALERSHIP_CODE" => "",
            "DEALERSHIP_NAME" => "",
            "LOGO" => "",
            "VARIABLE_ALIASES" => array(
                "WEB_FORM_ID" => "WEB_FORM_ID",
                "RESULT_ID" => "RESULT_ID",
            )
        ),
        false
    );?>
</div>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>