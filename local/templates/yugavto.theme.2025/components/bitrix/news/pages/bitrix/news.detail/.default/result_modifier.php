<?php
    $apiToken = '34b5ac8b71018c0bc7e5c050ed90b243';
    $apiBase = 'https://' . (class_exists('YApp') ? YApp::API_DOMAIN : 'apps.yug-avto.ru') . '/API/get/cis';
    $modelCode = urlencode((string)$arResult['CODE']);

    $arResult['NEW_COUNT'] = YApp::safeJsonGet($apiBase . '/count/new/?token=' . $apiToken . '&model=' . $modelCode, []);
    $arResult['USED_COUNT'] = YApp::safeJsonGet($apiBase . '/count/used/?token=' . $apiToken . '&model=' . $modelCode, []);

    $arResult['NEW'] = YApp::safeJsonGet($apiBase . '/limit/new/?token=' . $apiToken . '&model=' . $modelCode . '&limit=12', []);
    $arResult['USED'] = YApp::safeJsonGet($apiBase . '/limit/used/?token=' . $apiToken . '&model=' . $modelCode . '&limit=12', []);

    $arResult['DEALERSHIPS'] = null;
    $arDealershipsNEW = YApp::safeJsonGet($apiBase . '/dealerships/new/?token=' . $apiToken . '&model=' . $modelCode, []);
    $arDealershipsUSED = YApp::safeJsonGet($apiBase . '/dealerships/used/?token=' . $apiToken . '&model=' . $modelCode, []);
	if ( $arDealershipsNEW && is_array($arDealershipsNEW) ) foreach ( $arDealershipsNEW as $item ) $dealership_ext_ids[] = $item['id'];
	if ( $arDealershipsUSED && is_array($arDealershipsUSED) ) foreach ( $arDealershipsUSED as $item ) $dealership_ext_ids[] = $item['id'];
    
    $rs = CIBlockSection::GetList(
		['NAME'=>'ASC'],
		[
            'ID' => $arResult['IBLOCK_SECTION_ID'],
			'IBLOCK_ID' => YApp::IBLOCK_PAGES,
			'ACTIVE' => 'Y'
		],
		false,
		['ID', 'IBLOCK_ID', 'NAME', 'CODE', 'UF_*'],
		false
	);
	while ( $ob = $rs->GetNext() ) {

		$ob['LOGO'] = CIBlockElement::GetByID($ob['UF_PAGES_BRAND'])->GetNext()['PREVIEW_PICTURE'];
		$arResult['SECTION'] = $ob;
	}
	if ( $dealership_ext_ids ) {
		$rs = CIBlockElement::GetList(
			['NAME'=>'ASC'],
			[
				'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
				'PROPERTY_EXTERNAL_CODE' => $dealership_ext_ids,
				'ACTIVE' => 'Y'
			],
			false, false,
			['ID', 'NAME', 'CODE', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_EXTERNAL_CODE' ]
		);
		while ( $ob = $rs->GetNextElement() ) $arResult['DEALERSHIPS'][] = $ob->GetFields();
	}

    
    $APPLICATION->AddChainItem($arResult['SECTION']['NAME'], $arResult['SECTION']['SECTION_PAGE_URL']);
    $APPLICATION->AddChainItem($arResult['NAME']);
?>