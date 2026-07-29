<?php
header("HTTP/1.1 301 Moved Permanently");
header("Location: /about/");
exit();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Информация для партнеров компании Юг-Авто");
$APPLICATION->SetTitle("Партнерам - Юг-Авто");
?>
<div class="container my-4">
	<div class="row">
		<div class="col">
            <h1 class="h2 block-title">Партнерам</h1>
        </div>
	</div>
</div>
<div class="container my-4">
	<div class="row">
		<div class="col-12 col-md-5 mb-3 mb-md-0">
            <div class="b-radius-yaradius-25 overflow-hidden">
                <?php $h1 = $APPLICATION->GetTitle(false); ?>
                <img src="/upload/img/partners-1.jpg" alt="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" title="<?= htmlspecialchars(YApp::getCleanAltText($h1)); ?>" class="w-100" />
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="b-radius-yaradius-25 b-yagray px-3 py-4 px-md-4 py-md-5 h-100">
                <p class="text-plus">
                    Принцип нашей компании: «Профессиональный подход во всем».<br />
                    Мы всегда открыты к партнерским отношениям для взаимовыгодного развития бизнеса.
                </p>
                <p class="text-plus c-yadarkgray fst-italic">
                    Сафронов А.А.<br />
                    Генеральный директор Юг-Авто Холдинг
                </p>
                <p class="c-yadarkgray mb-5">
                    Если по специфике вашей работы наши компании могут стать надежными партнерами, 
                    предлагаем Вам заполнить форму обратной связи.
                </p>
                <a href="#FORM_PARTNERS" 
                   data-form="FORM_PARTNERS" 
                   class="b-radius-yaradius-15 py-3 px-5 text-center c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none"
                >
                   Оставить заявку
                </a>
            </div>
        </div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>