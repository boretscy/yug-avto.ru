<?php

$rs = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => YApp::IBLOCK_SEO,
        'PROPERTY_PATH' => Yapp::getSEOPath($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])
    ],
    false, false,
    ['ID', 'DETAIL_TEXT']
);
while ( $ob = $rs->GetNextElement() ) $arResult['SEO_TEXT'] = $ob->GetFields()['DETAIL_TEXT'];
if ( !$arResult['SEO_TEXT'] && $GLOBALS['META']['meta']['seo_text'] )  $arResult['SEO_TEXT'] = '<h2 class="fw-normal">'.$GLOBALS['META']['meta']['seo_title'].'</h2><p>'.$GLOBALS['META']['meta']['seo_text'].'</p>';

array_multisort(array_column($arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE'], 'NAME'), SORT_ASC, SORT_STRING, $arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE']);

// YApp::sp( $arResult['DISPLAY_PROPERTIES']['BRANDS']['LINK_ELEMENT_VALUE'], true );
?>