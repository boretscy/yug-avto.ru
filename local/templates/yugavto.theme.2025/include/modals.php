<?php
use Bitrix\Main\Loader;
Loader::includeModule('form');

$rs = CIBlockElement::GetList(
    [],
    ['IBLOCK_ID'=>YApp::IBLOCK_FORMS, 'ACTIVE'=>'Y', 'PROPERTY_MODAL_VALUE'=>'Да'],
    false, false,
    ['CODE']
);
while ( $ob = $rs->GetNextElement() ) {
    $code = $ob->GetFields()['CODE'];
    $arForms[] = [
        'CODE' => $code,
        'ID' => CForm::GetBySID($code)->Fetch()['ID']
    ];
}

foreach ( $arForms as $item ) {?>
<div class="remodal text-start p-4 position-relative" data-remodal-id="<?= $item['CODE'];?>">
    <button data-remodal-action="close" class="remodal-close"></button>
    <?php 
        $APPLICATION->IncludeComponent(
            "bitrix:form.result.new", 
            "form.blank", 
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
                "WEB_FORM_ID" => $item['ID'],
                "COMPONENT_TEMPLATE" => "form.blank",
                "VARIABLE_ALIASES" => array(
                    "WEB_FORM_ID" => "WEB_FORM_ID",
                    "RESULT_ID" => "RESULT_ID",
                )
            ),
            false
        );
    ?>
</div>
<?php } ?>
