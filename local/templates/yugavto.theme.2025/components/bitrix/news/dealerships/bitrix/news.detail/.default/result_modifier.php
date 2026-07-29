<?php

$GLOBALS['DEALERSHIP'] = $arResult['ID'];


$arLinks = [];
$rs = CIBlockElement::GetProperty(
    YApp::IBLOCK_BRANDS,
    $arResult['PROPERTIES']['BRAND']['VALUE'],
    [],
    ['CODE'=>'LINK']
);
while ( $ob = $rs->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

$arResult['PROPERTIES']['BRAND']['LINK'] = $arLinks[0]['LINK'];
foreach ( $arLinks as $arLink ) if ( $arLink['CITY'] == $arResult['PROPERTIES']['CITY']['VALUE'] )  $arResult['PROPERTIES']['BRAND']['LINK'] = $arLink['LINK'];

$arResult['PROPERTIES']['BRAND']['PICTURE'] = CFile::GetPath( $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['PREVIEW_PICTURE'] );

if (
    $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE'] == 'expert' || 
    $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE'] == 'expert-premium'
) {
    $arResult['PROPERTIES']['BRAND']['CIS_LINK'] = '/cars/used/?dealership='.$arResult['PROPERTIES']['EXTERNAL_CODE']['VALUE'];
} elseif ($arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE'] == 'volkswagen-c') { 
    $arResult['PROPERTIES']['BRAND']['CIS_LINK'] = '/cars/'.(($arResult['PROPERTIES']['IS_NEW']['VALUE']=='Да')?'new':'used').'/?dealership=1343';
} else {
    $arResult['PROPERTIES']['BRAND']['CIS_LINK'] = '/cars/'.(($arResult['PROPERTIES']['IS_NEW']['VALUE']=='Да')?'new':'used').'/'.str_replace('_','-',$arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE']).'/';
}

$rs = CIBlockElement::GetList(
    ['active_from' => 'desc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_NEWS,
        'ACTIVE' => 'Y',
        'PROPERTY_DEALERSHIP' => $arResult['ID'],
        'PROPERTY_BRAND' => $arResult['PROPERTIES']['BRAND']['VALUE']
    ],
    false,
    ['nTopCount' => 12],
    ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PREVIEW_TEXT', 'ACTIVE_FROM']
);
while ( $ob = $rs->GetNextElement() ) $arResult['NEWS'][] = $ob->GetFields();


$arResult['MODE'] = ( $arResult['PROPERTIES']['IS_NEW']['VALUE'] == 'Да' ) ? 'new' : 'used';

$goBase = 'https://apps.avatr-yugavto.ru/api/v1/cis';
$token = 'ef6541490c8bb9d481d37020b6a1953e';
$mode = $arResult['MODE'];
$dealershipExtId = $arResult['PROPERTIES']['EXTERNAL_CODE']['VALUE'];
$brandCode = $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE'];

$vehiclesUrl = $goBase.'/vehicles?type='.$mode.'&dealership='.$dealershipExtId.'&limit=12&token='.$token;
if ($mode == 'new' && $brandCode) {
    $vehiclesUrl .= '&brand='.$brandCode;
}

$vehiclesResp = json_decode(file_get_contents($vehiclesUrl), true);
$arResult['VEHICLES'] = $vehiclesResp['items'] ?? [];
$arResult['COUNT'] = $vehiclesResp['totalCount'] ?? 0;
if ( is_countable($arResult['PROPERTIES']['SERVICES']['VALUE']) ) {
    switch ( count($arResult['PROPERTIES']['SERVICES']['VALUE']) ) {
        case 1:
        case 2:
        case 3:
        case 4:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][3] = 'x1';
            break;
        case 5:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][3] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][4] = 'x2';
            break;
        case 6:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][3] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][4] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][5] = 'x1';
            break;
        case 7:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][3] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][4] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][5] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][6] = 'x1';
            break;
        case 7:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][3] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][4] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][5] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][5] = 'x1';
            break;
        case 8:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][3] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][4] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][5] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][6] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][7] = 'x1';
            break;
        case 9:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][3] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][4] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][5] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][6] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][7] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][8] = 'x1';
            break;
        case 10:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][3] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][4] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][5] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][6] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][7] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][8] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][9] = 'x1';
            break;
        case 11:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x2';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][3] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][4] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][5] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][6] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][7] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][8] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][9] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][10] = 'x1';
            break;
        case 11:
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][0] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][1] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][0][2] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][3] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][4] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][1][5] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][6] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][7] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][2][8] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][9] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][10] = 'x1';
            $arResult['PROPERTIES']['SERVICES']['STYLES'][3][11] = 'x1';
            break;
    }
}
?>