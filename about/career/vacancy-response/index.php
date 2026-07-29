<?/*
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отклик на вакансию");
?>
<?php if ( $_GET['VACANCY'] ) {
	
	$vac = CIBlockElement::GetByID($_GET['VACANCY'])->GetNext()['NAME'];
	$GLOBALS['FORMS']['FORM_HRRESPONCE']['ADDITIONAL_TITLE'] = '"'.$vac.'"';
	$tmp = CIBlockElement::GetByID($_GET['DEALSERSHIP'])->GetNext();
	$GLOBALS['FORMS']['FORM_HRRESPONCE']['ADDITIONAL_TITLE'] .= ' в <a href="'.$tmp['DETAIL_PAGE_URL'].'" alt="'.$tmp['NAME'].'">'.$tmp['NAME'].'</a>';
	$GLOBALS['FORMS']['FORM_HRRESPONCE']['TITLE'] = $vac.' в '.$tmp['NAME'];



} ?>
<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "form.vacancy.line", Array(
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
		"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
		"EDIT_URL" => "result_edit.php",	// Страница редактирования результата
		"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
		"LIST_URL" => "result_list.php",	// Страница со списком результатов
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
		"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
		"WEB_FORM_ID" => "10",	// ID веб-формы
		"COMPONENT_TEMPLATE" => "form.block.gray",
		"DEALERSHIP" => "",	// Автосалон (символьный код)
		"COMPOSITE_FRAME_MODE" => "A",	// Голосование шаблона компонента по умолчанию
		"COMPOSITE_FRAME_TYPE" => "AUTO",	// Содержимое компонента
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>