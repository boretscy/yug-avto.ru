<?php
header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); die;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

LocalRedirect ("/404.php");  
/*

$APPLICATION->SetTitle("Согласие на обработку персональных данных");
$APPLICATION->AddChainItem("Согласие на обработку персональных данных");
?><?$APPLICATION->IncludeComponent("bitrix:main.include", "include.text", Array(
	"AREA_FILE_SHOW" => "page",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",	// Суффикс имени файла включаемой области
		"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
	),
	false
);?>
<div class="container my-5">
	<div class="row mb-3">
		<div class="col">
			<h1 class="fw-normal"></h1>
		</div>
	</div>
</div>
 <br><?
 */
 require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>