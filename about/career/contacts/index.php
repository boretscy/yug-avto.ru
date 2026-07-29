<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Контакты Юг-Авто");
$APPLICATION->SetTitle("Контакты Юг-Авто");
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
        <div class="row">
            <div class="col-lg-6 mb-3 mb-lg-0">
                <div class="p-4 bg-yawhite h-100 d-flex flex-column justify-content-between align-items-start position-relative contacts contacts-left">
                    <div class="mb-4">
                        <h1 class="h2 text-uppercase mb-4">Возникли вопросы?</h1>
                        <p class="text-plus">Сотрудники отдела подбора персонала будут рады ответить.</p>
                    </div>
                    <div class="c-yadarkgray text-plus fst-italic py-4 desc">Менеджер по подбору персонала<br />Ступникова Юлия</div>
                    <div class="contacts-left-footer position-absolute d-flex">
                        <div class="contacts-left-footer-right">
                            <div class="contacts-left-footer-right-top w-100 bg-yalightbluegray">
                                <div class="contacts-left-footer-right-top-wrap w-100 bg-yawhite"></div>
                            </div>
                            <div class="contacts-left-footer-right-bottom">
                                <div class="contacts-left-footer-right-bottom-wrap">
                                    <div class="contacts-left-footer-right-bottom-wrap-content bg-yalightbluegray">
                                        <div class="contacts-left-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 d-flex justify-content-center align-items-center overflow-hidden">
                                            <?php $h1 = $APPLICATION->GetTitle(false); ?>
                                            <img src="./assets/images/stupnikova.jpg" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" />
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="contacts-left-footer-left">
                            <div class="contacts-left-footer-left-wrap bg-yalightbluegray h-100">
                                <div class="contacts-left-footer-left-wrap-corner bg-yawhite h-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="p-4 pb-3 bg-yawhite h-100 d-flex flex-column justify-content-between align-items-start position-relative contacts contacts-right">
                    <div class="contacts-item d-flex justify-content-start align-items-center mb-2">
                        <span class="contacts-item-icon b-radius-yaradius-8 bg-yadarkgray d-flex justify-content-center align-items-center me-3"><img src="./assets/images/svg/icon-career-route.svg" /></span>
                        <div class="contacts-item-content">г. Краснодар, г. Новороссийск, г. Майкоп</div>
                    </div>
                    <div class="contacts-item d-flex justify-content-start align-items-center mb-2">
                        <span class="contacts-item-icon b-radius-yaradius-8 bg-yadarkgray d-flex justify-content-center align-items-center me-3"><img src="./assets/images/svg/icon-career-phone.svg" /></span>
                        <a href="tel:<?= YApp::phoneIn('+7 (861) 212-72-00');?>" class="h3 contacts-item-content m-0 c-yablack c-h-yablack text-decoration-none fw-bold">
                            <?= YApp::phoneOut('+7 (861) 212-72-00');?>
                            <span class="c-yadarkgray fw-normal h5">(доб. 1072, 1073, 1074)</span>
                        </a> 
                    </div>
                    <div class="contacts-item d-flex justify-content-start align-items-center mb-2">
                        <span class="contacts-item-icon b-radius-yaradius-8 bg-yadarkgray d-flex justify-content-center align-items-center me-3"><img src="./assets/images/svg/icon-career-mobile.svg" /></span>
                        <a href="tel:<?= YApp::phoneIn('+7 (989) 275-41-41');?>" class="h3 contacts-item-content m-0 c-yablack c-h-yablack text-decoration-none fw-bold">
                            <?= YApp::phoneOut('+7 (989) 275-41-41');?>
                        </a> 
                    </div>
                    <div class="contacts-item d-flex justify-content-start align-items-center mb-4">
                        <span class="contacts-item-icon b-radius-yaradius-8 bg-yadarkgray d-flex justify-content-center align-items-center me-3"><img src="./assets/images/svg/icon-career-globe.svg" /></span>
                        <a href="https://yug-avto.ru" class="contacts-item-content c-yablack c-h-yablack text-decoration-none">yug-avto.ru</a>
                    </div>
                    <a
						href="mailto:hr@yug-avto.ru"
						class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yayellow bg-h-yadarkyellow d-flex justify-content-center align-items-center contacts-right-button"
					>HR@yug-avto.ru</a>
                    <div class="contacts-right-footer position-absolute d-flex">
                        <div class="contacts-right-footer-left">
                            <div class="contacts-right-footer-left-wrap bg-yalightbluegray h-100">
                                <div class="contacts-right-footer-left-wrap-corner bg-yawhite h-100"></div>
                            </div>
                        </div>
                        <div class="contacts-right-footer-right">
                            <div class="contacts-right-footer-right-top w-100 bg-yalightbluegray">
                                <div class="contacts-right-footer-right-top-wrap w-100 bg-yawhite"></div>
                            </div>
                            <div class="contacts-right-footer-right-bottom">
                                <div class="contacts-right-footer-right-bottom-wrap">
                                    <div class="contacts-right-footer-right-bottom-wrap-content bg-yalightbluegray">
                                        <div class="contacts-right-footer-right-bottom-icon bg-yawhite b-radius-yaradius-12 d-flex justify-content-center align-items-center">
                                            <img src="./assets/images/svg/icon-career-mail.svg" />
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

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h2 class="h2 text-uppercase mb-4 ps-2 ps-lg-0">Часто задаваемые вопросы</h2>
            
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="faq-wrap position-relative">
                <div class="faq-left b-radius-yaradius-16 b-yagray bg-yawhite py-4">
                    <div class="faq-q-item px-5 my-3 position-relative cursor-pointer" role="question" data-indx="1">Когда я смогу получить обратную связь после рассмотрения моего резюме?</div>
                    <div class="faq-a-item p-4 bg-yalightbluegray d-lg-none" role="answer" data-indx="1">
                        <?php /* <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">На рассмотрение резюме и принятие решения о приглашении Вас на первый этап собеседования требуется до 5-ти рабочих дней с момента Вашего отклика. В случае положительного решения по Вашей кандидатуре менеджер по подбору персонала обязательно свяжется с Вами.</p>
                        <p class="c-yadarkgray">Если Ваше резюме было просмотрено, но в течение 5 рабочих дней звонок не поступил, значит на данный момент Компания не готова предложить Вам сотрудничество.</p>
                    </div>
                    <hr />
                    <div class="faq-q-item px-5 my-3 position-relative cursor-pointer active" role="question" data-indx="2">Вы сообщите об итогах собеседования, даже если для меня оно прошло безуспешно?</div>
                    <div class="faq-a-item p-4 bg-yalightbluegray m-active d-lg-none" role="answer" data-indx="2">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                    </div>
                    <hr />
                    <div class="faq-q-item px-5 my-3 position-relative cursor-pointer" role="question" data-indx="3">Могу ли я приехать на собеседование без приглашения сотрудника компании?</div>
                    <div class="faq-a-item p-4 bg-yalightbluegray d-lg-none" role="answer" data-indx="3">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                    </div>
                    <hr />
                    <div class="faq-q-item px-5 my-3 position-relative cursor-pointer" role="question" data-indx="4">Сколько длится испытательный срок?</div>
                    <div class="faq-a-item p-4 bg-yalightbluegray d-lg-none" role="answer" data-indx="4">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">Испытательный срок для новых сотрудников устанавливается в соответствии с трудовым кодексом РФ. Длительность испытательного срока не превышает трех месяцев для линейных сотрудников и шести — для руководящих должностей. Испытательный срок может быть сокращен в индивидуальном порядке по результатам работы.</p>
                    </div>
                    <hr />
                    <div class="faq-q-item px-5 my-3 position-relative cursor-pointer" role="question" data-indx="5">Есть ли в компании возможности карьерного и профессионального роста?</div>
                    <div class="faq-a-item p-4 bg-yalightbluegray d-lg-none" role="answer" data-indx="5">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">Конечно, структура холдинга подразумевает карьерный рост сотрудника в каждом департаменте или отделе. Большинство действующих руководителей начинали свою работу с линейных позиций.</p>
                        <p class="c-yadarkgray">Группа Компаний Юг-Авто предоставляет возможность корпоративного обучения, повышения квалификаций, специализированных тренингов, что способствует профессиональному росту сотрудника, а значит, благоприятно сказывается на его результатах работы.</p>
                    </div>
                    <hr />
                    <div class="faq-q-item px-5 my-3 position-relative cursor-pointer" role="question" data-indx="6"> Где находится отдел персонала?</div>
                    <div class="faq-a-item p-4 bg-yalightbluegray d-lg-none" role="answer" data-indx="6">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">Отдел персонала находится в дилерском центре «KIA / GEELY» на территории Автомобильной Деревни «Юг-Авто», п. Яблоновский</p>
                        <p class="c-yadarkgray">Если Вы планируете приехать на автомобиле:</p>
                        <ul class="c-yadarkgray">
                            <li>воспользуйтесь навигатором, введя в строке поиска «KIA Юг-Авто» и придерживайтесь его рекомендациям;</li>
                            <li>обращайте внимание на следующие ориентиры: проезжайте ТРК «Сити-Центр», переезжайте Яблоновский мост, двигайтесь прямо до развилки и держитесь левого поворота дороги, которая уходит под мост (трасса Краснодар-Новороссийск). Двигаясь прямо в сторону Новороссийска, слева Вы увидите наши автосалоны.</li>
                        </ul>
                        <p class="c-yadarkgray">Если Вы планируете приехать на общественном транспорте/пешком:</p>
                        <ul class="c-yadarkgray">
                            <li>воспользуйтесь программой 2GIS, введя в строке поиска «Юг-Авто автосалон». Выберите вкладку «Общественный транспорт» / «Пеший маршрут» — Вы увидите список маршрутных такси/автобусов, которые ведут в Автомобильную деревню от Вашего дома, и придерживайтесь рекомендованного маршрута;</li>
                            <li>воспользуйтесь общественным транспортом — до Автомобильной деревни «Юг-Авто» ходит большое количество маршрутных такси и автобусов:</li>
                        </ul>
                        <p class="c-yadarkgray">* маршрутные такси/автобусы от ТЦ Мега Адыгея: 107а, 183, 7а, 129, 177, 1353 (остановка «Привольная»), двигайтесь в сторону трассы «Краснодар-Новороссийск» под мост до пешеходного перехода. Перейдите дорогу и направляйтесь прямо. Слева Вы увидите дилерский центр «KIA / Geely»;</p>
                        <p class="c-yadarkgray">* маршрутные такси/автобусы от п. Энем: 183, 107а (остановка «Ивушка»), далее перейдите на противоположную сторону и двигайтесь вдоль трассы до дилерского центра «KIA / Geely».</p>
                    </div>
                </div>
                <div class="faq-right b-radius-yaradius-16 bg-yalightbluegray position-absolute d-none d-lg-block">
                    <div class="faq-a-item d-none" role="answer" data-indx="1">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">На рассмотрение резюме и принятие решения о приглашении Вас на первый этап собеседования требуется до 5-ти рабочих дней с момента Вашего отклика. В случае положительного решения по Вашей кандидатуре менеджер по подбору персонала обязательно свяжется с Вами.</p>
                        <p class="c-yadarkgray">Если Ваше резюме было просмотрено, но в течение 5 рабочих дней звонок не поступил, значит на данный момент Компания не готова предложить Вам сотрудничество.</p>
                    </div>
                    <div class="faq-a-item" role="answer" data-indx="2">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                    </div>
                    <div class="faq-a-item d-none" role="answer" data-indx="3">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                    </div>
                    <div class="faq-a-item d-none" role="answer" data-indx="4">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">Испытательный срок для новых сотрудников устанавливается в соответствии с трудовым кодексом РФ. Длительность испытательного срока не превышает трех месяцев для линейных сотрудников и шести — для руководящих должностей. Испытательный срок может быть сокращен в индивидуальном порядке по результатам работы.</p>
                    </div>
                    <div class="faq-a-item d-none" role="answer" data-indx="5">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">Конечно, структура холдинга подразумевает карьерный рост сотрудника в каждом департаменте или отделе. Большинство действующих руководителей начинали свою работу с линейных позиций.</p>
                        <p class="c-yadarkgray">Группа Компаний Юг-Авто предоставляет возможность корпоративного обучения, повышения квалификаций, специализированных тренингов, что способствует профессиональному росту сотрудника, а значит, благоприятно сказывается на его результатах работы.</p>
                    </div>
                    <div class="faq-a-item d-none" role="answer" data-indx="6">
                        <?php /* <h3 class="text-uppercase fw-bold mb-3">Сроки рассмотрения резюме</h3> */ ?>
                        <p class="c-yadarkgray">Отдел персонала находится в дилерском центре «KIA / GEELY» на территории Автомобильной Деревни «Юг-Авто», п. Яблоновский</p>
                        <p class="c-yadarkgray">Если Вы планируете приехать на автомобиле:</p>
                        <ul class="c-yadarkgray">
                            <li>воспользуйтесь навигатором, введя в строке поиска «KIA Юг-Авто» и придерживайтесь его рекомендациям;</li>
                            <li>обращайте внимание на следующие ориентиры: проезжайте ТРК «Сити-Центр», переезжайте Яблоновский мост, двигайтесь прямо до развилки и держитесь левого поворота дороги, которая уходит под мост (трасса Краснодар-Новороссийск). Двигаясь прямо в сторону Новороссийска, слева Вы увидите наши автосалоны.</li>
                        </ul>
                        <p class="c-yadarkgray">Если Вы планируете приехать на общественном транспорте/пешком:</p>
                        <ul class="c-yadarkgray">
                            <li>воспользуйтесь программой 2GIS, введя в строке поиска «Юг-Авто автосалон». Выберите вкладку «Общественный транспорт» / «Пеший маршрут» — Вы увидите список маршрутных такси/автобусов, которые ведут в Автомобильную деревню от Вашего дома, и придерживайтесь рекомендованного маршрута;</li>
                            <li>воспользуйтесь общественным транспортом — до Автомобильной деревни «Юг-Авто» ходит большое количество маршрутных такси и автобусов:</li>
                        </ul>
                        <p class="c-yadarkgray">* маршрутные такси/автобусы от ТЦ Мега Адыгея: 107а, 183, 7а, 129, 177, 1353 (остановка «Привольная»), двигайтесь в сторону трассы «Краснодар-Новороссийск» под мост до пешеходного перехода. Перейдите дорогу и направляйтесь прямо. Слева Вы увидите дилерский центр «KIA / Geely»;</p>
                        <p class="c-yadarkgray">* маршрутные такси/автобусы от п. Энем: 183, 107а (остановка «Ивушка»), далее перейдите на противоположную сторону и двигайтесь вдоль трассы до дилерского центра «KIA / Geely».</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php /*
<style>
    .faq-item {
        cursor: pointer;
        color: var(--yadarkgray);
        transition: .3s;
    }
    .faq-item.active {
        color: var(--yablack);
        transition: .3s;
    }
    .faq-item::before {
        content: '';
        border-radius: 50%;
        background-color: var(--yagray);
        width: 8px;
        height: 8px;
        position: absolute;
        left: 0;
        top: calc(50% - 4px);
        transition: .3s;
    }
    .faq-item.active::before {
        background-color: var(--yayellow);
        transition: .3s;
    }
    .faq-item::after {
        content: '';
        width: 8px;
        height: 100%;
        position: absolute;
        right: 0;
        top: 0;
        transition: .3s;
        background-image: url(<?= SITE_TEMPLATE_PATH.'/assets/images/svg/arrow-right-lightgray.svg';?>);
        background-position: center center;
        background-repeat: no-repeat;
    }
    .faq-item.active::after {
        transition: .3s;
        background-image: url(<?= SITE_TEMPLATE_PATH.'/assets/images/svg/arrow-right-yellow.svg';?>);
    }
    .faq-answers {
        top: -30px;
        right: 0;
        z-index: 0;
        width: calc(50% + 60px);
    }
    .faq-answer {
        overflow-y: scroll;
        height: 100%;
    }
    .faq-answer::-webkit-scrollbar {
        width: 5px;
        background-color: var(--yalightgray);
    }
    .faq-answer::-webkit-scrollbar-thumb {
        background-color: var(--yadarkgray);
        border-radius: 2.5px;
    }
    @media (max-width: 575.98px) {
        .faq-answer {
            overflow-y: auto;
            height: auto;
        }
    }
</style>
<div class="container my-5">
	<div class="row">
		<div class="col"><h2 class="h2 fw-500">Часто задаваемые вопросы</h2></div>
	</div>
    <div class="row mt-5">
        <div class="col position-relative">
            <div class="bg-yalightgray b-radius-yaradius-25 h-100 p-5 faq-answers position-absolute d-none d-md-block">
                <div class="ps-5 pe-2 faq-answer" role="answer" data-indx="0">
                    <p>На рассмотрение резюме и принятие решения о приглашении Вас на первый этап собеседования требуется до 5-ти рабочих дней с момента Вашего отклика. В случае положительного решения по Вашей кандидатуре менеджер по подбору персонала обязательно свяжется с Вами.</p>
                    <p>Если Ваше резюме было просмотрено, но в течение 5 рабочих дней звонок не поступил, значит на данный момент Компания не готова предложить Вам сотрудничество.</p>
                </div>
                <div class="ps-5 pe-2 faq-answer d-none" role="answer" data-indx="1">
                    <p>В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                </div>
                <div class="ps-5 pe-2 faq-answer d-none" role="answer" data-indx="2">
                    <p>В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                </div>
                <div class="ps-5 pe-2 faq-answer d-none" role="answer" data-indx="3">
                    <p>Испытательный срок для новых сотрудников устанавливается в соответствии с трудовым кодексом РФ. Длительность испытательного срока не превышает трех месяцев для линейных сотрудников и шести — для руководящих должностей. Испытательный срок может быть сокращен в индивидуальном порядке по результатам работы.</p>
                </div>
                <div class="ps-5 pe-2 faq-answer d-none" role="answer" data-indx="4">
                    <p>Конечно, структура холдинга подразумевает карьерный рост сотрудника в каждом департаменте или отделе. Большинство действующих руководителей начинали свою работу с линейных позиций.</p>
                    <p>Группа Компаний Юг-Авто предоставляет возможность корпоративного обучения, повышения квалификаций, специализированных тренингов, что способствует профессиональному росту сотрудника, а значит, благоприятно сказывается на его результатах работы.</p>
                </div>
                <div class="ps-5 pe-2 faq-answer d-none" role="answer" data-indx="5">
                    <p>Отдел персонала находится в дилерском центре «KIA / GEELY» на территории Автомобильной Деревни «Юг-Авто», п. Яблоновский</p>
                    <p>Если Вы планируете приехать на автомобиле:</p>
                    <ul>
                        <li>воспользуйтесь навигатором, введя в строке поиска «KIA Юг-Авто» и придерживайтесь его рекомендациям;</li>
                        <li>обращайте внимание на следующие ориентиры: проезжайте ТРК «Сити-Центр», переезжайте Яблоновский мост, двигайтесь прямо до развилки и держитесь левого поворота дороги, которая уходит под мост (трасса Краснодар-Новороссийск). Двигаясь прямо в сторону Новороссийска, слева Вы увидите наши автосалоны.</li>
                    </ul>
                    <p>Если Вы планируете приехать на общественном транспорте/пешком:</p>
                    <ul>
                        <li>воспользуйтесь программой 2GIS, введя в строке поиска «Юг-Авто автосалон». Выберите вкладку «Общественный транспорт» / «Пеший маршрут» — Вы увидите список маршрутных такси/автобусов, которые ведут в Автомобильную деревню от Вашего дома, и придерживайтесь рекомендованного маршрута;</li>
                        <li>воспользуйтесь общественным транспортом — до Автомобильной деревни «Юг-Авто» ходит большое количество маршрутных такси и автобусов:</li>
                    </ul>
                    <p>*маршрутные такси/автобусы от ТЦ Мега Адыгея: 107а, 183, 7а, 129, 177, 1353 (остановка «Привольная»), двигайтесь в сторону трассы «Краснодар-Новороссийск» под мост до пешеходного перехода. Перейдите дорогу и направляйтесь прямо. Слева Вы увидите дилерский центр «KIA / Geely»;</p>
                    <p>*маршрутные такси/автобусы от п. Энем: 183, 107а (остановка «Ивушка»), далее перейдите на противоположную сторону и двигайтесь вдоль трассы до дилерского центра «KIA / Geely».</p>
                </div>
            </div>
            <div class="d-none d-md-flex justify-content-between card-v-flex bg-yawhite b-radius-yaradius-25 b-yagray h-100 w-50 p-4 faq-items position-inherit">
                <div class="faq-item px-4 position-relative active" role="faq" data-indx="0">
                    1. Когда я смогу получить обратную связь после рассмотрения моего резюме?
                </div>
                <hr />
                <div class="faq-item px-4 position-relative" role="faq" data-indx="1">
                    2. Вы сообщите об итогах собеседования, даже если для меня оно прошло безуспешно?
                </div>
                <hr />
                <div class="faq-item px-4 position-relative" role="faq" data-indx="2">
                    3. Могу ли я приехать на собеседование без приглашения сотрудника компании
                </div>
                <hr />
                <div class="faq-item px-4 position-relative" role="faq" data-indx="3">
                    4. Сколько длится испытательный срок?
                </div>
                <hr />
                <div class="faq-item px-4 position-relative" role="faq" data-indx="4">
                    5. Есть ли в компании возможности карьерного и профессионального роста?
                </div>
                <hr />
                <div class="faq-item px-4 position-relative" role="faq" data-indx="5">
                    6. Где находится отдел персонала?
                </div>
            </div>


            <div class="d-md-none justify-content-between card-v-flex bg-yawhite b-radius-yaradius-25 b-yagray h-100 w-100 py-4 faq-items position-inherit text-minus">
                <div class="faq-item px-4 position-relative px-4 mx-4 mb-4 active" role="faq" data-indx="0">
                    1. Когда я смогу получить обратную связь после рассмотрения моего резюме?
                </div>
                <div class="bg-yalightgray faq-answer p-4 my-4 " role="faq" data-indx="0">
                    <p>На рассмотрение резюме и принятие решения о приглашении Вас на первый этап собеседования требуется до 5-ти рабочих дней с момента Вашего отклика. В случае положительного решения по Вашей кандидатуре менеджер по подбору персонала обязательно свяжется с Вами.</p>
                    <p>Если Ваше резюме было просмотрено, но в течение 5 рабочих дней звонок не поступил, значит на данный момент Компания не готова предложить Вам сотрудничество.</p>
                </div>
                <div class="faq-item px-4 position-relative px-4 mx-4 my-4" role="faq" data-indx="1">
                    2. Вы сообщите об итогах собеседования, даже если для меня оно прошло безуспешно?
                </div>
                <div class="bg-yalightgray faq-answer p-4 my-4 d-none" role="faq" data-indx="1">
                    <p>В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                </div>
                <div class="faq-item px-4 position-relative px-4 mx-4 my-4" role="faq" data-indx="2">
                    3. Могу ли я приехать на собеседование без приглашения сотрудника компании
                </div>
                <div class="bg-yalightgray faq-answer p-4 my-4 d-none" role="faq" data-indx="2">
                    <p>В Компании утвержден регламент отдела по работе с персоналом, согласно которому сотрудники отдела после рассмотрения резюме или анкеты приглашают соискателей на собеседование в назначенную дату и время.</p>
                </div>
                <div class="faq-item px-4 position-relative px-4 mx-4 my-4" role="faq" data-indx="3">
                    4. Сколько длится испытательный срок?
                </div>
                <div class="bg-yalightgray faq-answer p-4 my-4 d-none" role="faq" data-indx="3">
                    <p>Испытательный срок для новых сотрудников устанавливается в соответствии с трудовым кодексом РФ. Длительность испытательного срока не превышает трех месяцев для линейных сотрудников и шести — для руководящих должностей. Испытательный срок может быть сокращен в индивидуальном порядке по результатам работы.</p></div>
                <div class="faq-item px-4 position-relative px-4 mx-4 my-4" role="faq" data-indx="4">
                    5. Есть ли в компании возможности карьерного и профессионального роста?
                </div>
                <div class="bg-yalightgray faq-answer p-4 my-4 d-none" role="faq" data-indx="4">
                    <p>Конечно, структура холдинга подразумевает карьерный рост сотрудника в каждом департаменте или отделе. Большинство действующих руководителей начинали свою работу с линейных позиций.</p>
                    <p>Группа Компаний Юг-Авто предоставляет возможность корпоративного обучения, повышения квалификаций, специализированных тренингов, что способствует профессиональному росту сотрудника, а значит, благоприятно сказывается на его результатах работы.</p>
                </div>
                <div class="faq-item px-4 position-relative px-4 mx-4 my-4" role="faq" data-indx="5">
                    6. Где находится отдел персонала?
                </div>
                <div class="bg-yalightgray faq-answer p-4 my-4 d-none" role="faq" data-indx="5">
                    <p>Отдел персонала находится в дилерском центре «KIA / Geely» на территории Автомобильной Деревни «Юг-Авто», п. Яблоновский</p>
                    <p>Если Вы планируете приехать на автомобиле:</p>
                    <ul>
                        <li>воспользуйтесь навигатором, введя в строке поиска «KIA Юг-Авто» и придерживайтесь его рекомендациям;</li>
                        <li>обращайте внимание на следующие ориентиры: проезжайте ТРК «Сити-Центр», переезжайте Яблоновский мост, двигайтесь прямо до развилки и держитесь левого поворота дороги, которая уходит под мост (трасса Краснодар-Новороссийск). Двигаясь прямо в сторону Новороссийска, слева Вы увидите наши автосалоны.</li>
                    </ul>
                    <p>Если Вы планируете приехать на общественном транспорте/пешком:</p>
                    <ul>
                        <li>воспользуйтесь программой 2GIS, введя в строке поиска «Юг-Авто автосалон». Выберите вкладку «Общественный транспорт» / «Пеший маршрут» — Вы увидите список маршрутных такси/автобусов, которые ведут в Автомобильную деревню от Вашего дома, и придерживайтесь рекомендованного маршрута;</li>
                        <li>воспользуйтесь общественным транспортом — до Автомобильной деревни «Юг-Авто» ходит большое количество маршрутных такси и автобусов:</li>
                    </ul>
                    <p>*маршрутные такси/автобусы от ТЦ Мега Адыгея: 107а, 183, 7а, 129, 177, 1353 (остановка «Привольная»), двигайтесь в сторону трассы «Краснодар-Новороссийск» под мост до пешеходного перехода. Перейдите дорогу и направляйтесь прямо. Слева Вы увидите дилерский центр «KIA / Geely»;</p>
                    <p>*маршрутные такси/автобусы от п. Энем: 183, 107а (остановка «Ивушка»), далее перейдите на противоположную сторону и двигайтесь вдоль трассы до дилерского центра «KIA / Geely».</p>
                </div>
            </div>




        </div>
    </div>
</div>
<script>
$(document).on('click', '.faq-item', function() {

    $(this).addClass('active');
    $(this).siblings().removeClass('active');

    $('.faq-answer').addClass('d-none');
    $('.faq-answer[data-indx="'+$(this).data('indx')+'"]').removeClass('d-none');

    return false;
});
</script>
*/ ?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>