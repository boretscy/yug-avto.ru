<?php
header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); die;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Политика обработки персональных данных - О компании -  Юг-Авто");
$APPLICATION->AddChainItem("Политика обработки персональных данных");
?>
<?php // YApp::LogRequest(__DIR__, $ip = true, $request = true, $server = true); ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"include.text", 
	array(
		"COMPONENT_TEMPLATE" => "include.text",
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>