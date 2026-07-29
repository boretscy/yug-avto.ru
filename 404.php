<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');


CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Такой страницы не существует, перейдите на главную");
?>

<div class="container my-4">
    <div class="row">
        <div class="col">
            <div class="bg-yawhite b-radius-yaradius-16 p-4 pb-5 text-center">
                <img src="/404_2025.png" class="img-fluid mb-4" />
                <h1 class="h2 mb-5">К сожалению, запрашиваемая Вами страница не найдена...</h1>
                <a href="/" class="c-yablack c-h-yablack text-decoration-none bg-yayellow bg-h-yadarkyellow b-radius-yaradius-15 px-5 py-3">На главную</a>
            </div>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>