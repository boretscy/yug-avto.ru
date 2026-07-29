<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Просто оставьте ваше имя и номер телефона — администратор тест-драйва перезвонит и запишет вас на удобное время");
$APPLICATION->SetTitle("Тест-драйв | Юг-Авто");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.page.white", 
	[
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "12",
		"COMPONENT_TEMPLATE" => "form.page.white",
		"DEALERSHIP" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEALERSHIP_TAG" => "Автосалон",
		"STEPS" => "BRAND-DEALERSHIP,MODEL",
		"CHAINS" => "BRAND-DEALERSHIP,MODEL",
		"VARIABLE_ALIASES" => [
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		]
	],
	false
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>