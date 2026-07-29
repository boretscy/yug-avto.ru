<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "О компании | Юг-Авто");
$APPLICATION->SetPageProperty("description", "О компании ЮГ-АВТО. Официальный дилер автомобилей в Краснодаре, поселке Яблоновский республики Адыгея и Новороссийске.");
$APPLICATION->SetTitle("О Компании");
?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
    $Asset->addCss($APPLICATION->GetCurPage().'assets/css/style.css');
    $Asset->addJs($APPLICATION->GetCurPage().'assets/js/script.js');
?>
<div class="container mb-5">
    <div class="row">
        <div class="col">
            <div class="bg-yawhite b-radius-yaradius-16 p-4">
				<div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-between align-items-start">
                        <?php $h1 = $APPLICATION->GetTitle(false); ?>
                        <div class="w-100">
                            <div class="h3 text-uppercase fw-bold">Группа компаний</div>
                            <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.svg" class="logo">
                        </div>
                        <div class="d-lg-none"><img src="./assets/images/about.png" class="w-100" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" /></div>
                        <div class="title text-uppercase fw-bolder position-relative pe-4">
                            Ваш проводник в мире автомобилей
                            <img src="./assets/images/svg/icon-about-corner.svg" />
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block"><img src="./assets/images/about.png" class="w-100" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" /></div>
                </div>
			</div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="bg-yawhite b-radius-yaradius-16 p-4">
                <p>Юг-Авто осуществляет продажу и сервисное обслуживание автомобилей в Краснодарском крае и Республике Адыгея от ведущих мировых производителей с сентября 1997 года. Нашим дилерским центрам многократно присуждалось звание «Лучший региональный дилер». И это не удивительно, ведь главный принцип компании Юг-Авто — сделать все, чтобы вы смогли выбрать «свой» автомобиль и в дальнейшем наслаждаться его владением и качественным обслуживанием.</p>
                <p>С нами это сделать просто, так как Юг-Авто официальный дилер 47 мировых автомобильных брендов: <span class="text-uppercase">AVATR, BAIC, BELGEE, CADILLAC, CHANGAN, CHERY, CHEVROLET, CITROEN, DEEPAL, EONYX, FORD, GAC, GEELY, GENESIS, HAVAL, HAVAL PRO, HONDA, HYUNDAI, JAC, JAECOO, JAGUAR, JETOUR, KGM, KIA, KAIYI, KNEWSTAR, LADA, LAND ROVER, LI AUTO, LIVAN, MITSUBISHI, NORDCROSS, OPEL, ORA, OMODA, PEUGEOT, ROX, SKODA, SOLARIS, SUZUKI, SOLLERS, TANK, TENET, VOLKSWAGEN, WEY, XCITE, АМБЕРАВТО, МОСКВИЧ</span>.</p>
                <p class="m-0">В наших шоу-румах вы найдете и купите автомобиль последнего поколения: легковой, спортивный и коммерческий, всех комплектаций и цветов. В Юг-Авто всегда действуют выгодные условия покупки авто, доступные программы кредитования и страхования. Получить одобрение кредита можно в т.ч. онлайн.</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="bg-yawhite b-radius-yaradius-16 p-4 mb-4">
                <p>Если вы хотите приобрести автомобиль с пробегом, то наше направление автомобилей с пробегом Юг-Авто Эксперт, предложит вам большой выбор. В гипермаркете по продаже автомобилей с пробегом представлены премиальные, коммерческие и авто с пробегом массового сегмента – вы точно найдете автомобиль, соответствующий вашим условиям. Или можете сдать свой текущий автомобиль в любой из 4 центров выкупа Юг-Авто Эксперт по справедливой цене.</p>
                <p>Развитие отношений с корпоративными клиентами является одним из ключевых направлений деятельности компании Юг-Авто. Мы поможем обновить и обслуживать ваш корпоративный парк быстро и выгодно.</p>
                <p>Сервисные центры Юг-Авто владеют всем необходимым, чтобы сделать прохождение сервисного обслуживания вашего автомобиля максимально комфортным, качественным и по приемлемой цене.</p>
            </div>
            <div class="bg-yawhite b-radius-yaradius-16 p-4">
                <p class="c-yadarkgray fst-italic p-0 m-0">Рады вам в наших дилерских центрах!</p>
            </div>
        </div>
    </div>
    <div class="row d-flex">
		<div class="col">
			<div class="b-radius-yaradius-16 bg-yawhite p-3 p-lg-5 text-uppercase d-flex flex-column flex-lg-row justify-content-between align-items-lg-center main-filter-futures text-uppercase">
				<h2 class="d-lg-none fw-bold text-uppercase">ЮГ-АВТО ЭТО</h2>
				<div class="main-filter-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center my-2 my-lg-0">
					<div class="title fw-light me-3 me-lg-0">28</div>
					<div class="text c-yadarkgray fw-light">лет</div>
				</div>
				<div class="separator mx-2 bg-yayellow"></div>
				<div class="main-filter-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center my-2 my-lg-0">
					<div class="title fw-light me-3 me-lg-0">48</div>
					<div class="text c-yadarkgray fw-light">брендов</div>
				</div>
				<div class="separator mx-2 bg-yayellow"></div>
				<div class="main-filter-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center my-2 my-lg-0">
					<div class="title fw-light me-3 me-lg-0">5</div>
					<div class="text c-yadarkgray fw-light">городов</div>
				</div>
                <?php /*
				<div class="separator mx-2 bg-yayellow"></div>
				<div class="main-filter-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center my-2 my-lg-0">
					<div class="title fw-light me-3 me-lg-0">48</div>
					<div class="text c-yadarkgray fw-light">шоу-румов</div>
				</div>
                */?>
				<div class="separator mx-2 bg-yayellow"></div>
				<div class="main-filter-futures-item text-lg-center ms-2 d-flex d-lg-block justify-content-start align-items-center me-0 me-lg-2 my-2 my-lg-0">
					<div class="title fw-light me-3 me-lg-0">1 000 000 +</div>
					<div class="text c-yadarkgray fw-light">клиентов</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>