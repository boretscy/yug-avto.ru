<div class="forms-modal-cover w-100 h-100 position-fixed top-0"></div>
<?php
use Bitrix\Main\Loader;
Loader::includeModule('form');

$APPLICATION->IncludeComponent(
    "bitrix:form.result.new", 
    "form.modal.left", 
    array(
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
        "WEB_FORM_ID" => 3,
        "COMPONENT_TEMPLATE" => "form.modal.left",
        "VARIABLE_ALIASES" => array(
            "WEB_FORM_ID" => "WEB_FORM_ID",
            "RESULT_ID" => "RESULT_ID",
        )
    ),
    false
);
?>
