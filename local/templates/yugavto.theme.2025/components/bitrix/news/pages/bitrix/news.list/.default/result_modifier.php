<?php
foreach ( $arResult['ITEMS'] as $item ) $tmp[] = $item['IBLOCK_SECTION_ID'];
$arSections = array_unique($tmp);

if ( count($arSections) > 1) {

	$rs = CIBlockSection::GetList(
		['NAME'=>'ASC'],
		[
			'IBLOCK_ID' => YApp::IBLOCK_PAGES,
			'ACTIVE' => 'Y'
		],
		false,
		['ID', 'IBLOCK_ID', 'NAME', 'CODE', 'UF_*'],
		false
	);
	while ( $ob = $rs->GetNext() ) {

		$ob['LOGO'] = CIBlockElement::GetByID($ob['UF_PAGES_BRAND'])->GetNext()['PREVIEW_PICTURE'];
		$arResult['SECTIONS'][] = $ob;
	}

} else {

    $rs = CIBlockSection::GetList(
		['NAME'=>'ASC'],
		[
			'IBLOCK_ID' => YApp::IBLOCK_PAGES,
			'ID' => $arSections[0]
		],
		false,
		['ID', 'IBLOCK_ID', 'NAME', 'DESCRIPTION', 'CODE', 'UF_*'],
		false
	);
	while ( $ob = $rs->GetNext() ) {

		$ob['LOGO'] = CIBlockElement::GetByID($ob['UF_PAGES_BRAND'])->GetNext()['PREVIEW_PICTURE'];
		$arResult['SECTION'] = $ob;
	}

    foreach ( $arResult['ITEMS'] as $i ) $arModels[] = $i['CODE'];
	$APPLICATION->AddChainItem($arResult['SECTION']['NAME']);

    $goBase = 'https://apps.avatr-yugavto.ru/api/v1/cis';
    $token = 'ef6541490c8bb9d481d37020b6a1953e';
    $brandCode = $arResult['SECTION']['CODE'];

    $cacheTime = 300;

    $filterNew = json_decode(
        file_get_contents($goBase.'/filter?type=new&brand='.$brandCode.'&token='.$token),
        true
    );
    $arResult['NEW_COUNT'] = $filterNew['totalCount'] ?? 0;
    $arResult['VEHICLES_NEW'] = [];
    foreach ( $filterNew['dropLists']['models'] ?? [] as $m ) {
        $arResult['VEHICLES_NEW'][$m['code']] = ['vehicles' => $m['vehicles']];
    }

    $filterUsed = json_decode(
        file_get_contents($goBase.'/filter?type=used&brand='.$brandCode.'&token='.$token),
        true
    );
    $arResult['USED_COUNT'] = $filterUsed['totalCount'] ?? 0;
    $arResult['VEHICLES_USED'] = [];
    foreach ( $filterUsed['dropLists']['models'] ?? [] as $m ) {
        $arResult['VEHICLES_USED'][$m['code']] = ['vehicles' => $m['vehicles']];
    }

    $vehiclesUsed = json_decode(
        file_get_contents($goBase.'/vehicles?type=used&brand='.$brandCode.'&limit=12&token='.$token),
        true
    );
    $arResult['USED'] = $vehiclesUsed['items'] ?? [];

	// $arResult['DEALERSHIPS'] = null;
	// $arDealershipsNEW = json_decode(
    //     file_get_contents('https://apps.yug-avto.ru/API/get/cis/dealerships/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&brand='.$arResult['SECTION']['CODE']),
    //     true
    // );
	// $arDealershipsUSED = json_decode(
    //     file_get_contents('https://apps.yug-avto.ru/API/get/cis/dealerships/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&brand='.$arResult['SECTION']['CODE']),
    //     true
    // );
	// if ( $arDealershipsNEW ) foreach ( $arDealershipsNEW as $item ) $dealership_ext_ids[] = $item['id'];
	// if ( $arDealershipsUSED ) foreach ( $arDealershipsUSED as $item ) $dealership_ext_ids[] = $item['id'];
	// if ( $dealership_ext_ids ) {
	// 	$rs = CIBlockElement::GetList(
	// 		['NAME'=>'ASC'],
	// 		[
	// 			'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
	// 			'PROPERTY_EXTERNAL_CODE' => $dealership_ext_ids,
	// 			'ACTIVE' => 'Y'
	// 		],
	// 		false, false,
	// 		['ID', 'NAME', 'CODE', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_EXTERNAL_CODE' ]
	// 	);
	// 	while ( $ob = $rs->GetNextElement() ) $arResult['DEALERSHIPS'][] = $ob->GetFields();
	// }


	$rs = CIBlockElement::GetList(
		['NAME'=>'ASC'],
		[
			'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
			'PROPERTY_BRAND' => $arResult['SECTION']['UF_PAGES_BRAND'],
			'ACTIVE' => 'Y'
		],
		false, false,
		['ID', 'NAME', 'CODE', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_EXTERNAL_CODE', 'PROPERTY_CITY', 'PROPERTY_BRAND', 'PROPERTY_YANDEX_ID' ]
	);
	while ( $ob = $rs->GetNextElement() ) {
		
		$tmp = $ob->GetFields();
		// YApp::sp($tmp['ID'] );

		$arLinks = [];
		$b = CIBlockElement::GetProperty(
			YApp::IBLOCK_BRANDS,
			$arResult['SECTION']['UF_PAGES_BRAND'],
			[],
			['CODE'=>'LINK']
		);
		while ( $o = $b->GetNext() ) $arLinks[] = ['LINK'=>$o['VALUE'], 'CITY'=>$o['DESCRIPTION']];

		if ( is_countable($arLinks) && count($arLinks) == 1 ) $tmp['PROPERTY_BRAND_LINK'] = $arLinks[0];
		if ( is_countable($arLinks) && count($arLinks) > 1 ) 
			foreach ( $arLinks as $arLink ) 
				if ( $arLink['CITY'] == $tmp['PROPERTY_CITY_VALUE'] ) $tmp['PROPERTY_BRAND_LINK'] = $arLink;
	
		$b = CIBlockElement::GetProperty(
			YApp::IBLOCK_DEALERSHIPS,
			$tmp['ID'],
			[],
			['CODE'=>'TAG']
		);
		while ( $o = $b->GetNext() ) $tmp['PROPERTY_TAG'][] = $o['VALUE_XML_ID'];

		$b = CIBlockElement::GetProperty(
			YApp::IBLOCK_DEALERSHIPS,
			$tmp['ID'],
			[],
			['CODE'=>'WORK']
		);
		while ( $o = $b->GetNext() ) $tmp['PROPERTY_WORK'] = $o['VALUE'];

		if ( $tmp['PROPERTY_BRAND_VALUE'] ) {
			$tmp['PROPERTY_BRAND'] = CIBlockElement::GetByID($tmp['PROPERTY_BRAND_VALUE'])->GetNext();
			$arLinks = [];
			$b = CIBlockElement::GetProperty(
				YApp::IBLOCK_BRANDS,
				$tmp['PROPERTY_BRAND_VALUE'],
				[],
				['CODE'=>'LINK']
			);
			while ( $ob = $b->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

			if ( is_countable($arLinks) && count($arLinks) == 1 ) $tmp['PROPERTY_BRAND_LINK'] = $arLinks[0];
			if ( is_countable($arLinks) && count($arLinks) > 1 ) 
				foreach ( $arLinks as $arLink ) 
					if ( $arLink['CITY'] == $tmp['PROPERTY_CITY_VALUE'] ) $tmp['PROPERTY_BRAND_LINK'] = $arLink;
			
		}

		$arResult['DEALERSHIPS'][] = $tmp;
	}

	// YApp::sp($arResult['DEALERSHIPS'], true);
	// YApp::sp($arResult);
}

if (!empty($arResult['SECTIONS'])) {
    usort($arResult['SECTIONS'], function($a, $b) {
        $nameA = $a['NAME'] ?? '';
        $nameB = $b['NAME'] ?? '';
        $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
        $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
        if ($isRusA && !$isRusB) return -1;
        if (!$isRusA && $isRusB) return 1;
        return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
    });
}
?>