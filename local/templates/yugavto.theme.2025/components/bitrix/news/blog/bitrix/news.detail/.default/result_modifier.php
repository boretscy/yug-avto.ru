<?php
$arResult['GALLERY'] = [];
if ( !empty($arResult['PROPERTIES']['GALLERY']['VALUE']) && is_array($arResult['PROPERTIES']['GALLERY']['VALUE']) ) {
    foreach ( $arResult['PROPERTIES']['GALLERY']['VALUE'] as $g ) {
        $path = CFile::GetPath($g);
        if ($path) {
            $arResult['GALLERY'][] = $path;
        }
    }
}

if (!empty($arResult['DETAIL_TEXT']) && is_string($arResult['DETAIL_TEXT'])) {
    $arResult['DETAIL_TEXT'] = str_replace('important="">', 'class="important fst-italic b-yayellow b-radius-yaradius-16 p-4 my-4">', $arResult['DETAIL_TEXT']);
    $arResult['DETAIL_TEXT'] = str_replace('<blockquote>', '<blockquote class="d-flex align-items-stretch c-yadarkgray bg-yalightgray b-radius-yaradius-16 p-4 my-4"><div class="blockquote-line me-4 bg-yayellow"></div>', $arResult['DETAIL_TEXT']);
    $arResult['DETAIL_TEXT'] = str_replace('summury="">', 'class="summury b-radius-yaradius-16 bg-yalightgray p-4 my-4">', $arResult['DETAIL_TEXT']);
}
?>