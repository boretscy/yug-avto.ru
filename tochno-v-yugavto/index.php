<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Официальный сервис Юг-Авто в Краснодаре");
?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
?>
<style>
    .privet .code {font-size: 32px;}
    .privet .title {font-size: 48px;}
    .privet .phone {font-size: 40px;}
    .privet .position {font-size: 16px;}
    .privet .name {font-size: 20px;}

    .dealerships-mapview-map .ymaps-2-1-79-map {border-radius: var(--yaradius25);}
    .dealerships-mapview-map .ymaps-2-1-79-inner-panes {border-radius: var(--yaradius25);}
    .dealerships-mapview-map {height: 340px;}

    @media (max-width: 1399.98px) {
        .privet .phone {font-size: 30px;}
    }
    @media (max-width: 1199.98px) {
        .privet .title {font-size: 40px;}
        .privet .phone {font-size: 24px;}
        .block-43 {width: 24px;height: 24px;}
    }
    @media (max-width: 991.98px) {}
    @media (max-width: 767.98px) {
        .text-plus-plus {font-size: 84px;}
    }
    @media (max-width: 575.98px) {
    }
    @media (max-width: 413.98px) {
        .privet .phone {font-size: 20px;}
    }


</style>
<div class="bg-yalightbluegray py-4 py-md-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img src="images/title.jpg?2" class="w-100 d-none d-md-block" />
                <img src="images/title-m.jpg" class="w-100 d-md-none" />
            </div>
        </div>
    </div>
</div>
<div class="position-relative mb-2 mb-md-5">
	<div class="bg-yalightbluegray position-absolute top-0 w-100 h-25"></div>
	<div class="container bg-yawhite b-radius-yaradius25 pt-md-5 px-3 px-md-5 position-inherit">
		<div class="row">
			<div class="col-xl-4 col-xxl-3 mb-4 mb-xxl-0">
                <div class="d-none d-xxl-flex justify-content-center card-v-flex bg-yawhite b-radius-yaradius-25 b-yagray px-3 py-4 px-md-5 py-md-5 h-100">
                    <div class="c-yayellow fw-bold text-plus-plus">50%</div>
                    <div class="c-yablack text-plus">Выгода на сервисные работы при 1-ом визите</div>
                </div>
                <div class="d-flex d-xxl-none justify-content-between bg-yawhite b-radius-yaradius-25 b-yagray px-3 py-4 px-md-5 py-md-5 h-100">
                    <div class="c-yayellow fw-bold text-plus-plus">50%</div>
                    <div class="c-yablack text-plus d-flex align-items-center w-50">Выгода на сервисные работы при 1-ом визите</div>
                </div>
			</div>
            <div class="col-xl-8 col-xxl-9">
                <div class="row mb-4">
                    <div class="col-6">
                        <div class="bg-yawhite b-radius-yaradius-25 b-yagray px-3 py-4 px-md-5 py-md-5 h-100">
                            <img src="images/01.svg?2" />
                            <div class="c-yablack text-plus mt-3">Сервисное обслуживание всех марок и моделей</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-yawhite b-radius-yaradius-25 b-yagray px-3 py-4 px-md-5 py-md-5 h-100">
                            <img src="images/02.svg?2" />
                            <div class="c-yablack text-plus mt-3">Качественный сервис с гарантией у официального дилера по цене сервиса у дома</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="bg-yawhite b-radius-yaradius-25 b-yagray px-3 py-4 px-md-5 py-md-5 h-100">
                            <img src="images/03.svg?2" />
                            <div class="c-yablack text-plus mt-3">Широкий спектр работ - от химчистки до сложных ремонтов</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-yawhite b-radius-yaradius-25 b-yagray px-3 py-4 px-md-5 py-md-5 h-100">
                            <img src="images/04.svg?2" />
                            <div class="c-yablack text-plus mt-3">Учтем все Ваши пожелания и подберем оптимальные решения</div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<div class="bg-yalightbluegray py-4 py-md-5 privet">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 px-5">
                <img src="images/privet.png" class="w-100" />
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-center card-v-flex bg-yawhite b-radius-yaradius-25 b-yagray px-3 py-4 px-md-5 py-md-5 h-100">
                    <div class="code c-yadarkgray">Кодовая фраза:</div>
                    <div class="title fw-bold mb-5">Привет, Андрей!</div>
                    <a href="tel:<?= YApp::phoneIn('+7 918 46 98 378');?>" class="b-radius-yaradius25 bg-yayellow c-yablack c-h-yablack text-decoration-none text-center py-3 px-5 d-block phone">
                        <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/top-phone.svg" class="me-2 block-43" />
                        <?= YApp::phoneOut('+7 918 46 98 378');?>
                    </a>
                    <div class="name c-yadarkgray mt-5 mb-3">Давайте знакомиться!</div>
                    <div class="position c-yadarkgray">Руководитель сервиса Юг-Авто</div>
                    <div class="name c-yadarkgray">Андрей Клищ</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-6">
            <img src="images/friend.svg?2" class="w-100" />
        </div>
        <div class="col-lg-6">
            <img src="images/friend.png?3" class="w-100 d-none d-md-block" />
            <img src="images/friend-m.png" class="w-100 d-md-none" />
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-5 col-xl-4 d-flex justify-content-center card-v-flex mb-4 mb-lg-0">
            <div class="h3 block-title d-flex align-items-center c-yablack c-h-yablack text-decoration-none justify-content-start">
                Сервис Юг-Авто 
				<img 
					class="ms-3" 
					src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/arrow-right-yellow.svg';?>" 
				/>
			</div>
            <div class="row my-3">
				<div class="col-1 d-flex align-items-center">
					<span class="b-radius-yaradius-8 bg-yalightgray d-flex align-items-center justify-content-center">
						<img src="images/address.svg" />
					</span>
				</div>
				<div class="col-11 my-1">п. Яблоновский, ул. Краснодарская, 1/2</div>
				<div class="col-1 d-flex align-items-center">
					<span class="b-radius-yaradius-8 bg-yalightgray d-flex align-items-center justify-content-center">
						<img src="images/work.svg" />
					</span>
				</div>
				<div class="col-11 my-1">Пн. - Вс.: 08:00 - 20:00</div>
				<div class="col-1 d-flex align-items-center">
					<span class="b-radius-yaradius-8 bg-yalightgray d-flex align-items-center justify-content-center">
						<img src="images/phone.svg" />
					</span>
				</div>
				<div class="col-11">
					<a href="tel:<?= YApp::phoneIn('+7 918 46 98 378');?>" class="h3 block-title c-yablack c-h-yablack text-decoration-none"><?= YApp::phoneOut('+7 918 46 98 378');?></a>
				</div>
			</div>
            <a href="https://yandex.ru/maps/35/krasnodar/?ll=38.945806%2C44.975867&mode=routes&rtext=~44.975867%2C38.945806&rtt=auto&ruri=~&z=13" class="text-uppercase fw-500 c-yablack c-h-yablack d-block mb-2 mt-5" target="_blank">Построить маршрут ></a>
            <div class="c-yadarkgray">В пути 20 мин - Яблоновский мост открыт!</div>
        </div>
        <div class="col-lg-7 col-xl-8">
            <div id="dealershipsMap" class="dealerships-mapview-map b-radius-yaradius25 bg-yawhite"></div>
        </div>
    </div>
</div>


<?php $Asset->addJs('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script>
var dealershipsMap;
if (typeof ymaps !== 'undefined') {
    ymaps.ready(dealershipsMapInit);
}

function dealershipsMapInit () {
    if (typeof ymaps === 'undefined') return;
	
    dealershipsMap = new ymaps.Map('dealershipsMap', {

        center: [44.975867, 38.945806],
        zoom: 13
    }, {
        searchControlProvider: 'yandex#search'
    });
	dealershipsMap.behaviors.disable('scrollZoom');
    dealershipsMap.geoObjects.add(new ymaps.Placemark(
        [44.975867, 38.945806],
        {balloonContent: "Сервис Юг-Авто ", iconCaption: "Сервис Юг-Авто"},
        {iconLayout: 'default#image',iconImageHref: '/local/templates/yugavto.theme.2023.tochno/assets/images/svg/placemark-map.svg',iconImageSize: [32, 38],iconImageOffset: [-16, -38]}
    ))
}
</script>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>