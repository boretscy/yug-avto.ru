<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Карьера в компании ЮГ-Авто, вакансии, заполнить анкету, отправить резюме");
$APPLICATION->SetTitle("Карьера в Юг-Авто!");
?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
    $Asset->addCss($APPLICATION->GetCurPage().'assets/css/style.css');
    $Asset->addJs($APPLICATION->GetCurPage().'assets/js/script.js');

    $arResult['COUNT'] = 0;
    $rs = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
            'ACTIVE' => 'Y',
            'PROPERTY_INCOGNITO' => false,
            '!PROPERTY_EXTERNAL_CODE' => false,
        ],
        false, false,
        ['ID', 'CODE', 'PROPERTY_CITY']
    );
    while ( $ob = $rs->GetNextElement() ) {
        $arResult['COUNT']++;
        $arResult['CITIES'][] = $ob->GetFields()['PROPERTY_CITY_VALUE'];
    }
?>

<style>
	body {background-color: var(--yawhite);}
</style>
<div class="bg-yalightbluegray top-container pb-3 pb-lg-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="career-filter-tabs d-flex w-100">
                    <a
                        href="mailto:HR@yug-avto.ru"
                        class="career-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-lg-flex justify-content-center align-items-center active">
                        <span>Отправить резюме</span>
                    </a>
                    <a
                        href="/about/career/vacancies/"
                        class="career-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-lg-flex justify-content-center align-items-center">
                        <span>Вакансии</span>
                    </a>
                    <a
                        href="https://krasnodar.hh.ru/employer/704903"
                        target="_blank"
                        class="career-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-lg-flex justify-content-center align-items-center">
                        <span>Мы на сайте HH.RU</span>
                    </a>
                    <a
                        href="/about/career/contacts/"
                        class="career-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-lg-flex justify-content-center align-items-center">
                        <span>Контакты</span>
                    </a>
                </div>
                <div class="career-filter-tabs-content p-4 pb-5 bg-yawhite">
                    <h1 class="h2 fw-bold text-uppercase my-4">Карьера</h1>
                    <div class="row">
                        <div class="col-lg-6 position-lg-relative">
                            <?php $h1 = $APPLICATION->GetTitle(false); ?>
                            <img class="title-image position-xl-absolute" src="./assets/images/career.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                        </div>
                        <div class="col-lg-6">
                            <div class="title text-uppercase fw-bolder lineheight-1 mb-3">Наш главный актив - наша команда.</div>
                            <div class="text c-yadarkgray text-uppercase mb-3">Секрет нашего успеха прост: мы верим в людей, а люди верят в компанию!</div>
                            <div class="sign c-yadarkgray fst-italic mb-5">Елена Волынская, HR-директор</div>
                            <a 
                                href="mailto:HR@yug-avto.ru" 
                                rel=“nofollow” 
                                class="b-radius-yaradius-16 bg-yayellow bg-h-yadarkyellow py-3 px-5 text-center c-yablack c-h-yablack text-decoration-none text-normal" 
                                >Отправить резюме</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-xl-8">
            <div class="bg-yalightbluegray b-radius-yaradius-16 p-4 position-relative future">
                <img class="position-xl-absolute d-lg-none" src="./assets/images/career1.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                <h3 class="h2 fw-bold text-uppercase mb-4">Юг-Авто — это трамплин для вашей головокружительной карьеры</h3>
                <div class="h5">уникальный шанс реализоваться в профессии и работать, без преувеличения, с лучшим изобретением человечества — автомобилями.</div>
                <img class="position-xl-absolute d-none d-lg-block" src="./assets/images/career1.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col">
            <div class="b-radius-yaradius-16 map position-relative">
                <div class="row">
                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <div 
                            class="b-radius-yaradius-16 bg-yawhite py-3 px-5 text-center c-yablack fw-bold h3 mb-3 mb-lg-5" 
                            >5 городов</div>
                        <div 
                            class="b-radius-yaradius-16 bg-yawhite py-3 px-5 text-center c-yablack fw-bold h3" 
                            >39 шоу-румов</div>
                    </div>
                    <div class="col-lg-8 position-relative">
                        <img class="position-absolute map-img" src="./assets/images/map.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-yalightbluegray bottom-container py-3 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="career-filter-tabs d-flex w-100">
                    <a
                        href="/about/career/vacancies/?tag=SELL"
                        class="career-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-md-flex justify-content-center align-items-center">
                        <span>Продажи</span>
                    </a>
                    <a
                        href="/about/career/vacancies/?tag=SERVICE"
                        class="career-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-md-flex justify-content-center align-items-center">
                        <span>Сервис</span>
                    </a>
                    <a
                        href="/about/career/vacancies/?tag=STAFF"
                        class="career-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-md-flex justify-content-center align-items-center">
                        <span>Административный персонал</span>
                    </a>
                </div>
                <div class="career-footer-tabs-content p-4 pb-5 bg-yawhite">
                    <div class="row">
                        <div class="col-lg-7">
                            <h2 class="h2 fw-bold text-uppercase my-4">Наша команда</h2>
                            <p>Наша команда  – это люди, объединённые общей миссией и ценностями, готовые покорять новые вершины вместе. В нашей команде каждый — эксперт в своей области.</p>
                            <p>Мы гордимся нашей сплочённой командой, где каждый сотрудник не просто выполняет свою работу, а вкладывает душу в общее дело, стремясь к лучшим результатам. Мы регулярно анализируем процессы, внедряем инновации и повышаем планку качества нашей работы. Мы заряжаем друг друга энергией. У нас  нет места равнодушию. Но главное — у нас есть то, чего не купишь: доверие наших многочисленных клиентов.</p>
                            <p>Присоединяйтесь к нашей команде: Мы инвестируем в обучение, даём свободу в принятии решений и отмечаем достижения. Станьте частью коллектива, где ваш талант получит признание! Давайте вместе: смело мечтать, упорно работать и праздновать победы вместе!</p>
                            <p class="text-minus-minus c-yadarkgray">Все материалы размещены в соответствии с законодательством РФ.</p>
                        </div>
                        <div class="col-lg-5">
                            <a href="/about/career/vacancies/"><img class="w-100" src="./assets/images/start.png" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>