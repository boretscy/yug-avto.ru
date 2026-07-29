<?php
    if ( $arResult['PROPERTIES']['DEALERSHIP']['VALUE'] ) {

        $arResult['MODE'] = 'used';
        $rs = CIBlockElement::GetList(
            ['NAME'=>'ASC'],
            [
                'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                'ID' => $arResult['PROPERTIES']['DEALERSHIP']['VALUE'],
                'ACTIVE' => 'Y'
            ],
            false, false,
            ['ID', 'NAME', 'CODE', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_IS_NEW', 'PROPERTY_EXTERNAL_CODE', 'PROPERTY_BRAND', 'PROPERTY_WORK', 'PROPERTY_CITY', 'PROPERTY_YANDEX_ID' ]
        );
        while ( $ob = $rs->GetNextElement() ) {

            $tmp = $ob->GetFields();
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_ADDRESS'] = $tmp['PROPERTY_ADDRESS_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_PHONE'] = $tmp['PROPERTY_PHONE_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_COORDS_LAT'] = $tmp['PROPERTY_COORDS_LAT_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_COORDS_LON'] = $tmp['PROPERTY_COORDS_LON_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_EXTERNAL_CODE'] = $tmp['PROPERTY_EXTERNAL_CODE_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_IS_NEW'] = $tmp['PROPERTY_IS_NEW_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_WORK'] = $tmp['PROPERTY_WORK_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_YANDEX_ID'] = $tmp['PROPERTY_YANDEX_ID_VALUE'];

            if ( $tmp['PROPERTY_BRAND_VALUE'] ) {
                $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_BRAND'] = CIBlockElement::GetByID($tmp['PROPERTY_BRAND_VALUE'])->GetNext();
                $arLinks = [];
                $b = CIBlockElement::GetProperty(
                    YApp::IBLOCK_BRANDS,
                    $tmp['PROPERTY_BRAND_VALUE'],
                    [],
                    ['CODE'=>'LINK']
                );
                while ( $ob = $b->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

                if ( is_countable($arLinks) && count($arLinks) == 1 ) $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_BRAND_LINK'] = $arLinks[0];
                if ( is_countable($arLinks) && count($arLinks) > 1 ) 
                    foreach ( $arLinks as $arLink ) 
                        if ( $arLink['CITY'] == $tmp['PROPERTY_CITY_VALUE'] ) $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_BRAND_LINK'] = $arLink;
                
            }
            $b = CIBlockElement::GetProperty(
                YApp::IBLOCK_DEALERSHIPS,
                $tmp['ID'],
                [],
                ['CODE'=>'TAG']
            );
            while ( $ob = $b->GetNext() ) $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_TAG'][] = $ob['VALUE_XML_ID'];

            $arResult['DCs'][] = $tmp['ID'];
            if ( $tmp['PROPERTY_IS_NEW_VALUE'] ) $arResult['MODE'] = 'new';
        }
    }

    $arResult['MODE'] = ( !in_array('service', $arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) ) ? 'new' : 'used';
    if ( !in_array('service', $arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) ) {

        $arResult['VEHICLES'] = json_decode(
            file_get_contents('https://apps.yug-avto.ru/API/get/cis/limit/'.$arResult['MODE'].'/?token=34b5ac8b71018c0bc7e5c050ed90b243&limit=12'.(($arResult['DCs'])?'&dealership='.implode(',', $arResult['DCs']):'')),
            true
        );
    }
    YApp::sp($arResult['DISPLAY_PROPERTIES']['DEALERSHIP'], true);
?>