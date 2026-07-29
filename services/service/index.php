<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Услуги автосервиса в Краснодаре. Онлайн запись на ТО в \"Юг-Авто\". Техническое обслуживание автомобиля по доступным ценам. Узнать подробности Вы можете по телефону указанному на сайте");
$APPLICATION->SetTitle("Сервисное обслуживание, запись на ТО, ремонт авто в Краснодаре в автосалонах Юг-Авто");
?>
<? $APPLICATION->IncludeComponent(
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
		"WEB_FORM_ID" => "7",
		"COMPONENT_TEMPLATE" => "form.block.white",
		"DEALERSHIP" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DEALERSHIP_CODE" => "",
		"DEALERSHIP_NAME" => "",
		"LOGO" => "",
		"DEALERSHIP_TAG" => "Сервис",
		"CAR" => "",
		"VIN" => "",
		"VARIABLE_ALIASES" => [
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		]
	],
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>