<?php

    $rs = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
            'ID' => $arResult['PROPERTIES']['DEALERSHIP']['VALUE'],
            'ACTIVE' => 'Y'
        ],
        false, false,
        ['ID', 'NAME', 'CODE', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_EXTERNAL_CODE', 'PROPERTY_BRAND' ]
    );
    while ( $ob = $rs->GetNextElement() ) {

        $arResult['DEALERSHIP'] = $ob->GetFields();
        $arResult['DEALERSHIP']['LOGO'] = CFile::GetPath( CIBlockElement::GetByID( $arResult['DEALERSHIP']['PROPERTY_BRAND_VALUE'] )->GetNext()['PREVIEW_PICTURE'] );
    }

    // YApp::sp($arResult);
?>