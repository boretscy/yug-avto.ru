<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Оформите автокредит на выгодных условиях в автосалоне Юг-Авто. Мы предлагаем различные кредитные программы с минимальными процентными ставками. Профессиональная помощь в подборе условий и быстром оформлении кредита в тот же день");
$APPLICATION->SetTitle("Автокредит в Юг-Авто – Удобные условия покупки нового авто в кредит");
?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
    $Asset->addCss($APPLICATION->GetCurPage().'assets/css/style.css');
    $Asset->addJs($APPLICATION->GetCurPage().'assets/js/script.js');
?>
<div class="container">
    <div class="row">
		<div class="col"><h1 class="h2 text-uppercase">Кредит и страхование</h1></div>
	</div>
    <div class="row mt-4 mb-5">
        <div class="col">
            <div class="bg-yawhite b-radius-yaradius-24 p-4 title-block">
                <div class="row">
                    <div class="col-lg-6 position-lg-relative">
                        <?php $h1 = $APPLICATION->GetTitle(false); ?>
                        <img class="title-image position-xl-absolute" src="./assets/images/credit.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                    </div>
                    <div class="col-lg-6">
                        <h3 class="fw-bold text-uppercase mb-4">
                            Выбирайте автомобиль в Юг-Авто, покупайте в кредит без препятствий и ограничений!
                        </h3>
                        <p>Максимально комфортные и привлекательные условия покупки новых машин и с пробегом.</p>
                        <p class=" mb-5">
                            Выбирайте понравившуюся модель и получайте большое количество кредитных продуктов с 
                            уникальными предложениями: оформление субсидий, упрощенная схема рассмотрения заявки, 
                            займ на первоначальный взнос, беспроцентная рассрочка.
                        </p>
                        <a 
							href="#FORM_CREDIT" 
                            data-remodal-target="FORM_CREDIT"
							rel=“nofollow” 
							class="b-radius-yaradius-16 bg-yayellow bg-h-yadarkyellow py-3 px-5 text-center c-yablack c-h-yablack text-decoration-none text-normal" 
							>Оставить заявку на кредит</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-lg-6">
            <div class="bg-yawhite b-radius-yaradius-24 p-4 content-block h-100">
                <p>
                    Компания Юг-Авто предлагает выгодные программы кредитования автомобилей, простую процедуру согласования документов, 
                    быстрое оформление договора.
                </p>
                <p>
                    Уникальные партнерские программы ведущих финансовых организаций и банков предоставляют клиентам возможность купить
                    новый или подержанный автомобиль в кредит без первоначального взноса, получить сниженную процентную ставку, 
                    заключить договор с обратным выкупом. Если по условиям приобретения предполагается внесение первоначального взноса, 
                    на эту сумму также можно оформить кредит.
                </p>
                <p class="m-0">
                    Юг-Авто — официальный дилер знаменитых российских и зарубежных производителей. Десятки салонов дилерской сети
                    расположены в Краснодарском крае и республике Адыгея (г. Краснодар, г. Новороссийск, г. Майкоп, п. Яблоновский). Для оформления 
                    кредита вы можете обратиться непосредственно в наши автосалоны и заключить договор на месте, не выезжая в офис банка.
                </p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-yawhite b-radius-yaradius-24 p-4 content-block h-100">
                <p>
                    Специальные кредитные программы от производителей — еще один удобный путь приобретения автомобиля. Оформить
                    беспроцентную рассрочку, получить субсидию, воспользоваться индивидуальной схемой выплаты — каждая 
                    из программ направлена на создание простых условий покупки транспортного средства.
                </p>
                <p class="m-0">
                    Автосалоны Юг-Авто предлагают большой выбор машин с пробегом. Благодаря строгим условиям приемки подержанного
                    транспорта мы гарантируем клиентам приобретение техники проверенного качества по справедливой цене. 
                    Продажа б/у автомобилей в кредит входит в состав специальных программ производителей и уникальных 
                    предложений банков-партнеров.
                </p>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col">
            <div class="bg-yawhite b-radius-yaradius-24 p-4">
                <h2 class="text-uppercase mb-3">Стандартные требования к заемщику:</h2>
                <div class="row credit-futures">
                    <div class="col-6 col-xl mb-3 mb-lxl-0">
                        <div class="p-4 bg-yalightbluegray credit-future position-relative d-flex align-items-end">
                            <div class="">Гражданство РФ</div>
                            <div class="credit-future-footer position-absolute d-flex">
                                
                                <div class="credit-future-footer-right">
                                    <div class="credit-future-footer-right-bottom">
                                        <div class="credit-future-footer-right-bottom-wrap">
                                            <div class="credit-future-footer-right-bottom-wrap-content bg-yawhite">
                                                <div class="credit-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    1
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="credit-future-footer-right-top w-100 bg-yawhite">
                                        <div class="credit-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                    </div>
                                </div>

                                <div class="credit-future-footer-left">
                                    <div class="credit-future-footer-left-wrap bg-yawhite h-100">
                                        <div class="credit-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl mb-3 mb-xl-0">
                        <div class="p-4 bg-yalightbluegray credit-future position-relative d-flex align-items-end">
                            <div class="">Возраст 18 лет и старше</div>
                            <div class="credit-future-footer position-absolute d-flex">
                                
                                <div class="credit-future-footer-right">
                                    <div class="credit-future-footer-right-bottom">
                                        <div class="credit-future-footer-right-bottom-wrap">
                                            <div class="credit-future-footer-right-bottom-wrap-content bg-yawhite">
                                                <div class="credit-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    2
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="credit-future-footer-right-top w-100 bg-yawhite">
                                        <div class="credit-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                    </div>
                                </div>

                                <div class="credit-future-footer-left">
                                    <div class="credit-future-footer-left-wrap bg-yawhite h-100">
                                        <div class="credit-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl mb-3 mb-xl-0">
                        <div class="p-4 bg-yalightbluegray credit-future position-relative d-flex align-items-end">
                            <div class="">Возраст на момент окончания договора не более 85 лет</div>
                            <div class="credit-future-footer position-absolute d-flex">
                                
                                <div class="credit-future-footer-right">
                                    <div class="credit-future-footer-right-bottom">
                                        <div class="credit-future-footer-right-bottom-wrap">
                                            <div class="credit-future-footer-right-bottom-wrap-content bg-yawhite">
                                                <div class="credit-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    3
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="credit-future-footer-right-top w-100 bg-yawhite">
                                        <div class="credit-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                    </div>
                                </div>

                                <div class="credit-future-footer-left">
                                    <div class="credit-future-footer-left-wrap bg-yawhite h-100">
                                        <div class="credit-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl">
                        <div class="p-4 bg-yalightbluegray credit-future position-relative d-flex align-items-end">
                            <div class="">Стаж на последнем месте работы не менее 3 месяцев</div>
                            <div class="credit-future-footer position-absolute d-flex">
                                
                                <div class="credit-future-footer-right">
                                    <div class="credit-future-footer-right-bottom">
                                        <div class="credit-future-footer-right-bottom-wrap">
                                            <div class="credit-future-footer-right-bottom-wrap-content bg-yawhite">
                                                <div class="credit-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    4
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="credit-future-footer-right-top w-100 bg-yawhite">
                                        <div class="credit-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                    </div>
                                </div>

                                <div class="credit-future-footer-left">
                                    <div class="credit-future-footer-left-wrap bg-yawhite h-100">
                                        <div class="credit-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl">
                        <div class="p-4 bg-yalightbluegray credit-future position-relative d-flex align-items-end">
                            <div class="">Неучастие в процедурах банкротства</div>
                            <div class="credit-future-footer position-absolute d-flex">
                                
                                <div class="credit-future-footer-right">
                                    <div class="credit-future-footer-right-bottom">
                                        <div class="credit-future-footer-right-bottom-wrap">
                                            <div class="credit-future-footer-right-bottom-wrap-content bg-yawhite">
                                                <div class="credit-future-footer-right-bottom-icon bg-yalightbluegray b-radius-yaradius-12 c-yadarkgray fw-bold d-flex justify-content-center align-items-center">
                                                    5
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="credit-future-footer-right-top w-100 bg-yawhite">
                                        <div class="credit-future-footer-right-top-wrap w-100 bg-yalightbluegray"></div>
                                    </div>
                                </div>

                                <div class="credit-future-footer-left">
                                    <div class="credit-future-footer-left-wrap bg-yawhite h-100">
                                        <div class="credit-future-footer-left-wrap-corner bg-yalightbluegray h-100"></div>
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

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>