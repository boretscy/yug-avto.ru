<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сбой оплаты - Юг-Авто");
?><div class="container p-5">
    <h1 class="text-center mb-5">Оплата прошла успешно</h1>
    <h2 class="text-center c-yamiddlegray mb-5" style="max-width: 400px;
    margin: 0 auto;">УВАЖАЕМЫЙ КЛИЕНТ. При обработке платежа произошла ошибка. Попробуйте оплатить снова, перейдя ещё раз по ссылке.</h2>
    <a href="/" class="text-center d-block text-decoration-none p-1">Перейти на главную</a>
    <a href="/cars/new/" class="text-center d-block text-decoration-none p-1">Купить автомобиль</a>
    <a href="/services/trade-in/" class="text-center d-block text-decoration-none p-1">Продать автомобиль</a>
    <a href="/services/credit/" class="text-center d-block text-decoration-none p-1">Кредит и страхование</a>
    <a href="/corporate/" class="text-center d-block text-decoration-none p-1">Корпоративным клиентам</a>
    <a href="/offers/" class="text-center d-block text-decoration-none p-1">Специальные предложения</a>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>