<?php 

    use Bitrix\Main\Loader;
    use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    Loader::includeModule("iblock");
    Loader::includeModule("cfile");
    Loader::IncludeModule('form');


    class YAApi {

        public static function Route() {

            $url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $ar = explode('/', parse_url($url)['path']);

            return [
                'entity' => $ar['2'],
                'id' => $ar['3'],
                'data' => $_GET
            ];
	    }
        // optimized by Claude
        // public static function Route(): array
        // {
        //     $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
        //     $segments = explode('/', $path);

        //     return [
        //         'entity' => $segments[2] ?? null,
        //         'id'     => $segments[3] ?? null,
        //         'data'   => $_GET,
        //     ];
        // }


        public static function apiGetOffers( $GET = [] ) {

            $res = [];
            $arF = [
                'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                'ACTIVE' => 'Y',
                '=PROPERTY_EXTERNAL_CODE' => explode(',', $GET['dealership'])
            ];
            if ( $GET['brand'] ) {
                $rs = CIBlockElement::GetList(
                    [],
                    [
                        'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
                        'ACTIVE' => 'Y',
                        'CODE' => $GET['brand']
                    ],
                    false, false,
                    ['ID']
                );
                while ( $ob = $rs->GetNextElement() ) $arF['PROPERTY_BRAND'] = $ob->GetFields()['ID'];
            }

            $rs = CIBlockElement::GetList(
                [],
                $arF,
                false,
                false,
                ['ID', 'NAME', 'PROPERTY_EXTERNAL_CODE']
            );
            while ( $ob = $rs->GetNextElement() ) $d[] = $ob->GetFields()['ID'];

            $rs = CIBlockElement::GetList(
                ['ACTIVE_FROM' => 'DESC'],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
                    'ACTIVE' => 'Y',
                    '<=DATE_ACTIVE_TO ' => date('d.m.Y H:i:s'),
                    '=PROPERTY_DEALERSHIP' => $d
                ],
                false,
                ['nPageSize' => 9],
                ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'ACTIVE_TO', 'PROPERTY_DEALERSHIP']
            );
            while ( $ob = $rs->GetNextElement() ) {
                
                $tmp = $ob->GetFields();
                $tmp['ACTIVE_TO'] = ( $tmp['ACTIVE_TO'] ) ? date('d.m.Y', strtotime($tmp['ACTIVE_TO'])) : false; 
                $tmp['PREVIEW_PICTURE'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PREVIEW_PICTURE']);
                $tmp['DETAIL_PAGE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].$tmp['DETAIL_PAGE_URL'];
                foreach( $tmp as $k => $i ) if ( mb_strripos($k, '~') !== false ) unset($tmp[$k]);

                $prop_s = CIBlockElement::GetProperty(
                    YApp::IBLOCK_OFFERS,
                    $tmp['ID'],
                    'sort', 'asc',
                    ['CODE' => 'TAG']
                );
                while( $prop_o = $prop_s->GetNext() ) {
                    $tmp['TAG'][] = $prop_o['VALUE_ENUM'];
                }

                $res[] = $tmp;
            }
            
            return $res;
        }
        // optimized by Claude
        // public static function apiGetOffers(array $GET = []): array
        // {
        //     $dealershipCodes = $GET['dealership'] ?? '';
        //     $arF = [
        //         'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        //         'ACTIVE' => 'Y',
        //         '=PROPERTY_EXTERNAL_CODE' => explode(',', $dealershipCodes),
        //     ];

        //     if (!empty($GET['brand'])) {
        //         $rsBrand = CIBlockElement::GetList(
        //             [],
        //             [
        //                 'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
        //                 'ACTIVE' => 'Y',
        //                 'CODE' => $GET['brand'],
        //             ],
        //             false,
        //             ['nTopCount' => 1],
        //             ['ID']
        //         );
        //         if ($brand = $rsBrand->GetNext()) {
        //             $arF['PROPERTY_BRAND'] = $brand['ID'];
        //         }
        //     }

        //     $dealershipIds = [];
        //     $rsDealerships = CIBlockElement::GetList([], $arF, false, false, ['ID']);
        //     while ($d = $rsDealerships->GetNext()) {
        //         $dealershipIds[] = $d['ID'];
        //     }

        //     if (!$dealershipIds) {
        //         return [];
        //     }

        //     $rsOffers = CIBlockElement::GetList(
        //         ['ACTIVE_FROM' => 'DESC'],
        //         [
        //             'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
        //             'ACTIVE' => 'Y',
        //             '<=DATE_ACTIVE_TO ' => date('d.m.Y H:i:s'),
        //             '=PROPERTY_DEALERSHIP' => $dealershipIds,
        //         ],
        //         false,
        //         ['nPageSize' => 9],
        //         ['ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'ACTIVE_TO', 'PROPERTY_DEALERSHIP']
        //     );

        //     $host = $_SERVER['HTTP_HOST'];
        //     $res = [];
        //     while ($tmp = $rsOffers->GetNext()) {
        //         $tmp = array_filter($tmp, fn($k) => strpos($k, '~') === false, ARRAY_FILTER_USE_KEY);
        //         $tmp['ACTIVE_TO'] = $tmp['ACTIVE_TO'] ? date('d.m.Y', strtotime($tmp['ACTIVE_TO'])) : false;
        //         $tmp['PREVIEW_PICTURE'] = 'https://' . $host . CFile::GetPath($tmp['PREVIEW_PICTURE']);
        //         $tmp['DETAIL_PAGE_URL'] = 'https://' . $host . $tmp['DETAIL_PAGE_URL'];
        //         $res[$tmp['ID']] = $tmp;
        //     }

        //     if ($res) {
        //         $rsTags = CIBlockElement::GetProperty(
        //             YApp::IBLOCK_OFFERS,
        //             array_keys($res),
        //             'sort', 'asc',
        //             ['CODE' => 'TAG']
        //         );
        //         while ($tag = $rsTags->GetNext()) {
        //             $res[$tag['IBLOCK_ELEMENT_ID']]['TAG'][] = $tag['VALUE_ENUM'];
        //         }
        //     }

        //     return array_values($res);
        // }


        public static function apiGetDealership( $GET = [] ) {

            $res = [];
            $arF = [
                'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                'ACTIVE' => 'Y',
                'PROPERTY_EXTERNAL_CODE' => explode(',', $GET['code']),
            ];
            if ( $GET['brand'] ) {
                $rs = CIBlockElement::GetList(
                    [],
                    [
                        'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
                        'ACTIVE' => 'Y',
                        'CODE' => $GET['brand']
                    ],
                    false, false,
                    ['ID']
                );
                while ( $ob = $rs->GetNextElement() ) $arF['PROPERTY_BRAND'] = $ob->GetFields()['ID'];
            }

            $rs = CIBlockElement::GetList(
                [],
                $arF,
                false,
                false,
                [
                    'ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_PIC_TABLET_PREVIEW', 'PROPERTY_PIC_MOBILE_PREVIEW',
                    'PROPERTY_EXTERNAL_CODE', 'PROPERTY_CITY', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_BRAND', 'PROPERTY_YANDEX_ID'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {
                
                $res = $ob->GetFields();
                $prop_s = CIBlockElement::GetProperty(
                    YApp::IBLOCK_DEALERSHIPS,
                    $res['ID'],
                    'sort', 'asc',
                    ['CODE' => 'WORK']
                );
                while( $prop_o = $prop_s->GetNext() ) {
                    $res['WORK'][] = [
                        'VALUE' => $prop_o['VALUE'],
                        'DESCRIPTION' => $prop_o['DESCRIPTION']
                    ];
                }
            }

            $res['LOGO'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath( CIBlockElement::GetByID($res['PROPERTY_BRAND_VALUE'])->GetNext()['PREVIEW_PICTURE'] );
            $arLinks = [];
            $rs = CIBlockElement::GetProperty(
                YApp::IBLOCK_BRANDS,
                $res['PROPERTY_BRAND_VALUE'],
                [],
                ['CODE'=>'LINK']
            );
            while ( $ob = $rs->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

            $res['SITE'] = $arLinks[0]['LINK'];
            foreach ( $arLinks as $arLink ) if ( $arLink['CITY'] == $res['PROPERTY_CITY_VALUE'] )  $res['SITE'] = $arLink['LINK'];


            $res['DETAIL_PAGE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].$res['DETAIL_PAGE_URL'];
            $res['PIC_DESKTOP_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($res['PREVIEW_PICTURE']);
            $res['PIC_TABLET_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($res['PROPERTY_PIC_TABLET_PREVIEW_VALUE']);
            $res['PIC_MOBILE_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($res['PROPERTY_PIC_MOBILE_PREVIEW_VALUE']);
            foreach( $res as $k => $i ) if ( mb_strripos($k, '~') !== false ) unset($res[$k]);

            return $res;
        }
        // optimized by Claude
        // public static function apiGetDealership(array $GET = []): ?array
        // {
        //     $codes = $GET['code'] ?? '';
        //     $arF = [
        //         'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        //         'ACTIVE' => 'Y',
        //         '=PROPERTY_EXTERNAL_CODE' => explode(',', $codes),
        //     ];

        //     if (!empty($GET['brand'])) {
        //         $rsBrand = CIBlockElement::GetList(
        //             [],
        //             [
        //                 'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
        //                 'ACTIVE' => 'Y',
        //                 'CODE' => $GET['brand'],
        //             ],
        //             false,
        //             ['nTopCount' => 1],
        //             ['ID']
        //         );
        //         if ($brand = $rsBrand->GetNext()) {
        //             $arF['PROPERTY_BRAND'] = $brand['ID'];
        //         }
        //     }

        //     $rsDealership = CIBlockElement::GetList(
        //         [],
        //         $arF,
        //         false,
        //         ['nTopCount' => 1],
        //         [
        //             'ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_PIC_TABLET_PREVIEW', 'PROPERTY_PIC_MOBILE_PREVIEW',
        //             'PROPERTY_EXTERNAL_CODE', 'PROPERTY_CITY', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_BRAND', 'PROPERTY_YANDEX_ID',
        //         ]
        //     );

        //     $res = $rsDealership->GetNext();
        //     if (!$res) {
        //         return null;
        //     }

        //     $rsWork = CIBlockElement::GetProperty(
        //         YApp::IBLOCK_DEALERSHIPS,
        //         $res['ID'],
        //         'sort', 'asc',
        //         ['CODE' => 'WORK']
        //     );
        //     while ($prop = $rsWork->GetNext()) {
        //         $res['WORK'][] = [
        //             'VALUE' => $prop['VALUE'],
        //             'DESCRIPTION' => $prop['DESCRIPTION'],
        //         ];
        //     }

        //     $host = $_SERVER['HTTP_HOST'];

        //     $res['LOGO'] = null;
        //     if ($res['PROPERTY_BRAND_VALUE']) {
        //         $rsBrandPic = CIBlockElement::GetList(
        //             [],
        //             ['ID' => $res['PROPERTY_BRAND_VALUE']],
        //             false,
        //             false,
        //             ['ID', 'PREVIEW_PICTURE']
        //         );
        //         if ($brandPic = $rsBrandPic->GetNext()) {
        //             $res['LOGO'] = 'https://' . $host . CFile::GetPath($brandPic['PREVIEW_PICTURE']);
        //         }
        //     }

        //     $arLinks = [];
        //     $rsLinks = CIBlockElement::GetProperty(
        //         YApp::IBLOCK_BRANDS,
        //         $res['PROPERTY_BRAND_VALUE'],
        //         [],
        //         ['CODE' => 'LINK']
        //     );
        //     while ($link = $rsLinks->GetNext()) {
        //         $arLinks[] = ['LINK' => $link['VALUE'], 'CITY' => $link['DESCRIPTION']];
        //     }

        //     $res['SITE'] = $arLinks[0]['LINK'] ?? null;
        //     foreach ($arLinks as $link) {
        //         if ($link['CITY'] == $res['PROPERTY_CITY_VALUE']) {
        //             $res['SITE'] = $link['LINK'];
        //         }
        //     }

        //     $res['DETAIL_PAGE_URL'] = 'https://' . $host . $res['DETAIL_PAGE_URL'];
        //     $res['PIC_DESKTOP_PREVIEW'] = 'https://' . $host . CFile::GetPath($res['PREVIEW_PICTURE']);
        //     $res['PIC_TABLET_PREVIEW'] = 'https://' . $host . CFile::GetPath($res['PROPERTY_PIC_TABLET_PREVIEW_VALUE']);
        //     $res['PIC_MOBILE_PREVIEW'] = 'https://' . $host . CFile::GetPath($res['PROPERTY_PIC_MOBILE_PREVIEW_VALUE']);

        //     return array_filter($res, fn($k) => strpos($k, '~') === false, ARRAY_FILTER_USE_KEY);
        // }

        public static function apiGetDealerships( $GET = [] ) {

            $res = [];
            $arFilter = [
                'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                'ACTIVE' => 'Y',
            ];
            $arFilter['PROPERTY_INCOGNITO_VALUE'] = false;
            if ( $GET['mode'] == 'new' ) $arFilter['=PROPERTY_IS_NEW_VALUE'] = 'Да';
            if ( $GET['mode'] == 'used' ) $arFilter['=PROPERTY_IS_NEW_VALUE'] = 'Нет';

            // if ( $GET['city'] )  $arFilter['=PROPERTY_CITY_VALUE'] = $GET['city'];
            // YApp::sp(explode(',', $GET['city']));
            if ( $GET['city'] )  $arFilter['=PROPERTY_CITY_VALUE'] = explode(',', $GET['city']);
            if ( $GET['brand'] ) $arFilter['PROPERTY_BRAND.CODE'] = explode(',', $GET['brand']);

            if ( is_countable(explode(',', $GET['code'])) && count(explode(',', $GET['code'])) ) $arFilter['PROPERTY_EXTERNAL_CODE'] = explode(',', $GET['code']);
            if ( is_countable(explode(',', $GET['code'])) && !count(explode(',', $GET['code'])) ) $arFilter['!PROPERTY_EXTERNAL_CODE'] = false;

            // YApp::sp( $arFilter );

            $rs = CIBlockElement::GetList(
                ['NAME' => 'ASC'],
                $arFilter,
                false,
                false,
                [
                    'ID', 'NAME', 'PROPERTY_EXTERNAL_CODE', 'PROPERTY_BRAND', 'PROPERTY_CITY', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON',
                    'PREVIEW_PICTURE', 'PROPERTY_PIC_TABLET_PREVIEW', 'PROPERTY_PIC_MOBILE_PREVIEW', 'DETAIL_PAGE_URL', 'PROPERTY_ADDRESS'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {
                
                $tmp = $ob->GetFields();

                // YApp::sp( $tmp );
                
                if ( $tmp['PROPERTY_EXTERNAL_CODE_VALUE'] ) {
                    $t = [
                        'id' => $tmp['ID'],
                        'code' => $tmp['PROPERTY_EXTERNAL_CODE_VALUE'],
                        'name' => $tmp['NAME'],
                        'brand' => CIBlockElement::GetByID($tmp['PROPERTY_BRAND_VALUE'])->GetNext()['CODE'],
                        '_city' => $tmp['PROPERTY_CITY_VALUE'],
                        'coords' => [
                            'lat' => $tmp['PROPERTY_COORDS_LAT_VALUE'],
                            'lon' => $tmp['PROPERTY_COORDS_LON_VALUE']
                        ],
                        'address' => $tmp['PROPERTY_ADDRESS_VALUE']
                    ];
                    switch ($t['_city']) {
                        case 'Краснодар': $t['city'] = 'Краснодаре'; break;
                        case 'Яблоновский': $t['city'] = 'Яблоновском'; break;
                        case 'Новороссийск': $t['city'] = 'Новороссийске'; break;
                        case 'Майкоп': $t['city'] = 'Майкопе'; break;
                        case 'Сочи': $t['city'] = 'Сочи'; break;
                    }
                    if ( $GET['city'] ) {
                        $t['city'] = '';
                        $ccc = explode(',', $GET['city']);
                        foreach ( $ccc as $k => $c ) {
                            switch ($c) {
                                case 'Краснодар': 
                                    $t['city'] .= 'Краснодаре'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Яблоновский': 
                                    $t['city'] .= 'Яблоновском'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Новороссийск': 
                                    $t['city'] .= 'Новороссийске'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Майкоп': 
                                    $t['city'] .= 'Майкопе'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                                case 'Сочи': 
                                    $t['city'] .= 'Сочи'; 
                                    if ( $k<count($ccc)-1 && $k!=count($ccc)-2 ) {
                                        $t['city'] .= ', ';
                                    } elseif ( $k==count($ccc)-2 ) {
                                        $t['city'] .= ' и ';
                                    }
                                    break;
                            }
                        }
                        // switch ($GET['city']) {
                        //     case 'Краснодар,Яблоновский': $t['city'] = 'Краснодаре и Яблоновском'; break;
                        //     case 'Краснодар': $t['city'] = 'Краснодаре'; break;
                        //     case 'Яблоновский': $t['city'] = 'Яблоновском'; break;
                        //     case 'Новороссийск': $t['city'] = 'Новороссийске'; break;
                        //     case 'Майкоп': $t['city'] = 'Майкопе'; break;
                        // }
                    }
                    $t['DETAIL_PAGE_URL'] = 'https://'.$_SERVER['HTTP_HOST'].$tmp['DETAIL_PAGE_URL'];
                    $t['PIC_DESKTOP_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PREVIEW_PICTURE']);
                    $t['PIC_TABLET_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PROPERTY_PIC_TABLET_PREVIEW_VALUE']);
                    $t['PIC_MOBILE_PREVIEW'] = 'https://'.$_SERVER['HTTP_HOST'].CFile::GetPath($tmp['PROPERTY_PIC_MOBILE_PREVIEW_VALUE']);
                    $res[] = $t;
                }
                
            }

            return $res;
        }
        // optimized by Claude
        // private static function cityLocative(string $city): string
        // {
        //     static $map = [
        //         'Краснодар'    => 'Краснодаре',
        //         'Яблоновский'  => 'Яблоновском',
        //         'Новороссийск' => 'Новороссийске',
        //         'Майкоп'       => 'Майкопе',
        //         'Сочи'         => 'Сочи',
        //     ];
        //     return $map[$city] ?? $city;
        // }
        // private static function joinRussianList(array $items): string
        // {
        //     if (count($items) < 2) {
        //         return implode('', $items);
        //     }
        //     $last = array_pop($items);
        //     return implode(', ', $items) . ' и ' . $last;
        // }
        // public static function apiGetDealerships(array $GET = []): array
        // {
        //     $arFilter = [
        //         'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        //         'ACTIVE' => 'Y',
        //         'PROPERTY_INCOGNITO' => false,
        //     ];

        //     if (($GET['mode'] ?? null) === 'new') {
        //         $arFilter['=PROPERTY_IS_NEW_VALUE'] = 'Да';
        //     }
        //     if (($GET['mode'] ?? null) === 'used') {
        //         $arFilter['=PROPERTY_IS_NEW_VALUE'] = 'Нет';
        //     }
        //     if (!empty($GET['city'])) {
        //         $arFilter['=PROPERTY_CITY_VALUE'] = explode(',', $GET['city']);
        //     }
        //     if (!empty($GET['brand'])) {
        //         $arFilter['PROPERTY_BRAND.CODE'] = explode(',', $GET['brand']);
        //     }
        //     if (!empty($GET['code'])) {
        //         $arFilter['=PROPERTY_EXTERNAL_CODE'] = explode(',', $GET['code']);
        //     }

        //     $rs = CIBlockElement::GetList(
        //         ['NAME' => 'ASC'],
        //         $arFilter,
        //         false,
        //         false,
        //         [
        //             'ID', 'NAME', 'PROPERTY_EXTERNAL_CODE', 'PROPERTY_BRAND', 'PROPERTY_CITY', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON',
        //             'PREVIEW_PICTURE', 'PROPERTY_PIC_TABLET_PREVIEW', 'PROPERTY_PIC_MOBILE_PREVIEW', 'DETAIL_PAGE_URL', 'PROPERTY_ADDRESS',
        //         ]
        //     );

        //     $rows = [];
        //     while ($tmp = $rs->GetNext()) {
        //         if ($tmp['PROPERTY_EXTERNAL_CODE_VALUE']) {
        //             $rows[] = $tmp;
        //         }
        //     }

        //     $brandIds = array_unique(array_filter(array_column($rows, 'PROPERTY_BRAND_VALUE')));
        //     $brandCodes = [];
        //     if ($brandIds) {
        //         $rsBrands = CIBlockElement::GetList(
        //             [],
        //             ['IBLOCK_ID' => YApp::IBLOCK_BRANDS, 'ID' => $brandIds],
        //             false,
        //             false,
        //             ['ID', 'CODE']
        //         );
        //         while ($b = $rsBrands->GetNext()) {
        //             $brandCodes[$b['ID']] = $b['CODE'];
        //         }
        //     }

        //     $host = $_SERVER['HTTP_HOST'];
        //     $cityLabel = !empty($GET['city'])
        //         ? self::joinRussianList(array_map([self::class, 'cityLocative'], explode(',', $GET['city'])))
        //         : null;

        //     $res = [];
        //     foreach ($rows as $tmp) {
        //         $res[] = [
        //             'id' => $tmp['ID'],
        //             'code' => $tmp['PROPERTY_EXTERNAL_CODE_VALUE'],
        //             'name' => $tmp['NAME'],
        //             'brand' => $brandCodes[$tmp['PROPERTY_BRAND_VALUE']] ?? null,
        //             'coords' => [
        //                 'lat' => $tmp['PROPERTY_COORDS_LAT_VALUE'],
        //                 'lon' => $tmp['PROPERTY_COORDS_LON_VALUE'],
        //             ],
        //             'address' => $tmp['PROPERTY_ADDRESS_VALUE'],
        //             'city' => $cityLabel ?? self::cityLocative($tmp['PROPERTY_CITY_VALUE']),
        //             'DETAIL_PAGE_URL' => 'https://' . $host . $tmp['DETAIL_PAGE_URL'],
        //             'PIC_DESKTOP_PREVIEW' => 'https://' . $host . CFile::GetPath($tmp['PREVIEW_PICTURE']),
        //             'PIC_TABLET_PREVIEW' => 'https://' . $host . CFile::GetPath($tmp['PROPERTY_PIC_TABLET_PREVIEW_VALUE']),
        //             'PIC_MOBILE_PREVIEW' => 'https://' . $host . CFile::GetPath($tmp['PROPERTY_PIC_MOBILE_PREVIEW_VALUE']),
        //         ];
        //     }

        //     return $res;
        // }

        public static function apiGetBrands( $GET= [] ) {

            $res = [];

            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                    'ACTIVE' => 'Y',
                    'PROPERTY_EXTERNAL_CODE' => explode(',', $GET['dealership']),
                ],
                false,
                false,
                [
                    'ID', 'NAME', 'DETAIL_PAGE_URL', 'DETAIL_PICTURE', 
                    'PROPERTY_EXTERNAL_CODE', 'PROPERTY_CITY', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_BRAND'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {

                $d = $ob->GetFields();
                $brand = CIBlockElement::GetByID($d['PROPERTY_BRAND_VALUE'])->GetNext();
                $res[] = [
                    'code' => $brand['CODE'],
                    'name' => $brand['NAME']
                ];
            }

            return $res;
        }
        // optimized by Claude
        // public static function apiGetBrands(array $GET = []): array
        // {
        //     $dealershipCodes = $GET['dealership'] ?? '';

        //     $rs = CIBlockElement::GetList(
        //         [],
        //         [
        //             'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        //             'ACTIVE' => 'Y',
        //             '=PROPERTY_EXTERNAL_CODE' => explode(',', $dealershipCodes),
        //         ],
        //         false,
        //         false,
        //         ['ID', 'PROPERTY_BRAND']
        //     );

        //     $brandIds = [];
        //     while ($d = $rs->GetNext()) {
        //         if ($d['PROPERTY_BRAND_VALUE']) {
        //             $brandIds[$d['PROPERTY_BRAND_VALUE']] = true;
        //         }
        //     }

        //     if (!$brandIds) {
        //         return [];
        //     }

        //     $res = [];
        //     $rsBrands = CIBlockElement::GetList(
        //         [],
        //         ['IBLOCK_ID' => YApp::IBLOCK_BRANDS, 'ID' => array_keys($brandIds)],
        //         false,
        //         false,
        //         ['ID', 'CODE', 'NAME']
        //     );
        //     while ($brand = $rsBrands->GetNext()) {
        //         $res[] = [
        //             'code' => $brand['CODE'],
        //             'name' => $brand['NAME'],
        //         ];
        //     }

        //     return $res;
        // }

        public static function apiGetModels( $GET= [] ) {

            $res = [];

            $rs = CIBlockSection::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_PAGES,
                    'ACTIVE' => 'Y',
                    'CODE' => $GET['brand']
                ],
                false,
                ['ID'],
                false
            );
            while ( $ob = $rs->GetNext() ) $section_id = $ob['ID'];

            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_PAGES,
                    'IBLOCK_SECTION_ID' => $section_id,
                    'ACTIVE' => 'Y',
                    '=PROPERTY_TEST_DRIVE_VALUE' => 'Да'
                ],
                false,
                false,
                [
                    'ID', 'IBLOCK_ID', 'NAME', 'CODE'
                ]
            );
            while ( $ob = $rs->GetNextElement() ) {

                $m = $ob->GetFields();
                $res[] = [
                    'code' => $m['CODE'],
                    'name' => $m['NAME']
                ];
            }

            return $res;
        }

        public static function apiSendform( $POST ) {

            return ['status' => 'error'];

            $arForm = CForm::GetByID($POST['FORM_ID'])->Fetch();
            $rs = CFormField::GetList($arForm['ID'], 'N', $by = 's_id',  $order = 'ASC', [], $is_f);
            while ( $ob = $rs->Fetch() ) $arForm['QS'][$ob['SID']] = $ob;
            

            $rs = CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => YApp::IBLOCK_FORM_SETTINGS,
                    'CODE' => $arForm['SID']
                ],
                false, false,
                ['ID']
            );
            while ( $ob = $rs->GetNextElement() ) $arForm['RECIPIENTS_ID'] = $ob->GetFields()['ID'];
            $rs = CIBlockElement::GetProperty(
                YApp::IBLOCK_FORM_SETTINGS,
                $arForm['RECIPIENTS_ID'],
                "sort", "asc",
                ['CODE'=>'RECIPIENTS']
            );
            while ( $ob = $rs->GetNext() )  $arForm['RECIPIENTS'][] = $ob['VALUE'];

            require 'phpmailer/phpmailer/src/Exception.php';
            require 'phpmailer/phpmailer/src/PHPMailer.php';

            $mail = new PHPMailer(true);

            foreach ($arForm['QS'] as $q) {

                switch ( $q['SID'] ) {

                    case 'NAME':
                    case 'PHONE':
                    case 'DATE':
                    case 'EMAIL':
                    case 'BRAND':
                    case 'MODEL':
                    case 'TITLE':
                        $arIns['form_text_'.$q['ID']] = $POST[$q['SID']];
                        $mail->Body .= $q['TITLE'].': '.$POST[$q['SID']].'<br />';
                        break;
                    
                    case 'DEALERSHIP':
                    case 'DEALERSHIP_NEW':
                    case 'DEALERSHIP_USED':
                    case 'DEALERSHIP_CHUNK':
                        if ( $POST[$q['SID']] ) {
                            $rs = CIBlockElement::GetList(
                                [],
                                [
                                    'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                                    'ACTIVE' => 'Y',
                                    'PROPERTY_EXTERNAL_CODE' => $POST[$q['SID']]
                                ],
                                false,
                                false,
                                [
                                    'ID', 'NAME',
                                ]
                            );
                            while ( $ob = $rs->GetNextElement() ) {
                                $arIns['form_text_'.$q['ID']] = $POST[$q['SID']];
                                $mail->Body .= $q['TITLE'].': '.$ob->GetFields()['NAME'].'<br />';
                            }
                        }
                        
                        break;

                    default: 
                        $mail->Body .= $q['TITLE'].': '.$POST[$q['SID']].'<br />';
                        break;
                }
            }

            if ( $res = CFormResult::Add($arForm['ID'], $arIns, $check_rights = "N") ) {
                
                try {
                
                    //Recipients
                    $mail->setFrom('formsender@yug-avto.ru', 'Формы сайта yug-avto.ru');
                    $mail->isHTML(true);
                    $mail->CharSet = 'utf-8';
                    $mail->Subject = 'Заполнена форма '.$arForm['NAME'];
                    if ( $POST['NAME'] == 'testtesttest' ) {
                        $mail->addAddress('anton.boreckiy@yug-avto.ru');
                    } else {
                        foreach ( $arForm['RECIPIENTS'] as $item ) $mail->addAddress($item);
                    }

                    $mail->send();
                    
                    return ['status' => 'success'];

                } catch (Exception $e) {

                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else
            {
                global $strError;
                echo $strError;
            }
            
        }
        public static function apiSendformNew( $POST ) {

            // YApp::sp($POST);

            if ( $POST['SSID'] == $_SESSION['fixed_session_id'] ) {

                // YApp::sp($POST);

                $arForm = CForm::GetByID($POST['FORM_ID'])->Fetch();
                $rs = CFormField::GetList($arForm['ID'], 'N', $by = 's_id',  $order = 'ASC', [], $is_f);
                while ( $ob = $rs->Fetch() ) $arForm['QS'][$ob['SID']] = $ob;
                
                $flag = false;
                $rs = CIBlockElement::GetList(
                    [],
                    [
                        'IBLOCK_ID' => YApp::IBLOCK_FORMS,
                        'CODE' => $arForm['SID']
                    ],
                    false, false,
                    ['ID']
                );
                while ( $ob = $rs->GetNextElement() ) {
                    $arForm['RECIPIENTS_ID'] = $ob->GetFields()['ID'];
                    $flag = true;
                }
                if ( $flag ) {

                    // YApp::sp($POST);

                    $rs = CIBlockElement::GetProperty(
                        YApp::IBLOCK_FORMS,
                        $arForm['RECIPIENTS_ID'],
                        "sort", "asc",
                        ['CODE'=>'RECIPIENTS']
                    );
                    while ( $ob = $rs->GetNext() )  $arForm['RECIPIENTS'][] = $ob['VALUE'];
    
                    require 'phpmailer/phpmailer/src/Exception.php';
                    require 'phpmailer/phpmailer/src/PHPMailer.php';
                    // require 'phpmailer/phpmailer/src/SMTP.php';
    
                    $mail = new PHPMailer(true);
    
                    // YApp::sp($arForm['QS']);
    
                    foreach ($arForm['QS'] as $q) {
    
                        switch ( $q['SID'] ) {
    
                            case 'NAME':
                            case 'DATE':
                            case 'EMAIL':
                            case 'BRAND':
                            case 'MODEL':
                            case 'TITLE':
                                $arIns['form_text_'.$q['ID']] = $POST[$q['SID']];
                                $mail->Body .= $q['TITLE'].': '.$POST[$q['SID']].'<br />';
                                break;
    
                            case 'PHONE':
                                $arIns['form_text_'.$q['ID']] = YApp::phoneOut($POST[$q['SID']]);
                                $mail->Body .= $q['TITLE'].': '.YApp::phoneOut($POST[$q['SID']]).'<br />';
                                break;
                            
                            case 'DEALERSHIP':
                            case 'DEALERSHIP_NEW':
                            case 'DEALERSHIP_USED':
                            case 'DEALERSHIP_CHUNK':
                                if ( $POST[$q['SID']] ) {
                                    $rs = CIBlockElement::GetList(
                                        [],
                                        [
                                            'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                                            'ACTIVE' => 'Y',
                                            'CODE' => $POST[$q['SID']]
                                        ],
                                        false,
                                        false,
                                        [
                                            'ID', 'NAME',
                                        ]
                                    );
                                    while ( $ob = $rs->GetNextElement() ) {
                                        $arIns['form_text_'.$q['ID']] = $POST[$q['SID']];
                                        $mail->Body .= $q['TITLE'].': '.$ob->GetFields()['NAME'].'<br />';
                                    }
                                }
                                
                                break;
    
                            default: 
                                $arIns['form_text_'.$q['ID']] = $POST[$q['SID']];
                                $mail->Body .= $q['TITLE'].': '.$POST[$q['SID']].'<br />';
                                break;
                        }
    
                        if ( $q['REQUIRED'] == 'Y' && !$POST[$q['SID']] ) return ['status' => 'error'];
                    }
                    // YApp::sp($arIns);
                    if ( $res = CFormResult::Add($arForm['ID'], $arIns, $check_rights = "N") ) {
                        
                        try {
                            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                            // $mail->isSMTP();                                            //Send using SMTP
                            // $mail->Host       = 'mail.yug-avto.ru';                     //Set the SMTP server to send through
                            // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            // $mail->Username   = 'no-reply';                             //SMTP username
                            // $mail->Password   = 'Qaz12345!';                            //SMTP password
                            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                            // $mail->Port       = 25;
                            // $mail->SMTPSecure = false;
                            // $mail->SMTPAutoTLS = true;
                        
                            //Recipients
                            $mail->setFrom('formsender@yug-avto.ru', 'Формы сайта yug-avto.ru');
                            $mail->isHTML(true);
                            $mail->CharSet = 'utf-8';
                            $mail->Subject = 'Заполнена форма '.$arForm['NAME'];
                            if ( $POST['NAME'] == 'testtesttest' ) {
                                $mail->addAddress('anton.boreckiy@yug-avto.ru');
                            } else {
                                foreach ( $arForm['RECIPIENTS'] as $item ) $mail->addAddress($item);
                                // $mail->addAddress('callcenter@yug-avto.ru');
                            }
    
                            $mail->send();
                            
                            return ['status' => 'success'];
    
                        } catch (Exception $e) {
    
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    } else {
                        global $strError;
                        echo $strError;
                    }

                } else {
                    return ['status' => 'error'];
                }
                

            } else {
                return ['status' => 'error'];
            }

            
            
        }



        public static function apiMainFilter($query) {
            
            $POST = json_decode($query['query'], true);

            $url = 'https://'.YApp::GO_API_DOMAIN.'/api/v1/cis/filter?token=ef6541490c8bb9d481d37020b6a1953e';
            $url .= '&type='.(($POST['data']['entity']) ?: 'new');
            if ( $POST['data']['city'] ) $url .= '&city='.$POST['data']['city'];
            if ( !empty($POST['data']['brands']) ) {
                $tmp = [];
                foreach( $POST['data']['brands'] as $item ) $tmp[] = $item['value'];
                sort($tmp);
                $url .= '&brand='.implode(',', $tmp); 
            }
            if ( !empty($POST['data']['models']) ) {
                $tmp = [];
                foreach( $POST['data']['models'] as $item ) $tmp[] = $item['value'];
                sort($tmp);
                $url .= '&model='.implode(',', $tmp);
            }
            if ( !empty($POST['data']['price']) ) {
                $tmp = [];
                foreach( $POST['data']['price'] as $item ) $tmp[] = (int)$item;
                sort($tmp);
                $url .= '&price_from='.$tmp[0].'&price_to='.$tmp[1];
            }

            $res = null;
            while ( !$res ) {
                $resp = YApp::httpGet($url);
                $res = $resp ? json_decode($resp, true) : null;
                if (!$resp) break; // Защита от бесконечного цикла при сбое API
            }

            return $res;
        }
        public static function apiRenderMainFilterSelect( $POST ) {
            if (isset($POST['items']) && is_string($POST['items'])) {
                $POST['items'] = json_decode($POST['items'], true) ?: [];
            }
            if (!is_array($POST['items'] ?? null)) {
                $POST['items'] = [];
            }
            
            $res = '<div class="form-droplist-container h-100">';
            $tmp = [];

            if ( $POST['list'] == 'models' ) {
                foreach ( $POST['items'] as $item ) {
                    if ( !$tmp[$item['brand']['code']] ) $tmp[$item['brand']['code']] = $item['brand'];
                    $tmp[$item['brand']['code']]['items'][] = $item;
                }
                if ($tmp) {
                    array_multisort(array_column($tmp, 'name'), SORT_ASC, SORT_STRING, $tmp);
                    if ( count($tmp) > 1 ) {
                        foreach ( $tmp as $k => $brand ) {
                            array_multisort(array_column($brand['items'], 'name'), SORT_ASC, SORT_STRING, $brand['items']);
                            $res .= '<span class="fw-bold d-block filter-droplist-item pt-2">'.$brand['name'].'</span>';
                            foreach ( $brand['items'] as $k => $item ) {
                                $res .= '<a href="#" class="form-droplist-item py-1 ps-4 d-block text-decoration-none" data-list="'.$POST['list'].'" data-value="'.$item['code'].'" data-indx="'.$item['indx'].'">'.$item['name'].'</a>'; 
                            }
                        }
                    } else {
                        array_multisort(array_column($POST['items'], 'name'), SORT_ASC, SORT_STRING, $POST['items']);
                        foreach ( $POST['items'] as $k => $item ) {
                            $res .= '<a href="#" class="form-droplist-item py-1 ps-4 d-block text-decoration-none" data-list="'.$POST['list'].'" data-value="'.$item['code'].'" data-indx="'.$item['indx'].'">'.$item['name'].'</a>'; 
                        }
                    }
                }
            } else {
                foreach ( $POST['items'] as $k => $item ) {
                    $res .= '<a href="#" class="form-droplist-item py-1 ps-4 d-block text-decoration-none" data-list="'.$POST['list'].'" data-value="'.$item['code'].'" data-indx="'.$item['indx'].'">'.$item['name'].'</a>'; 
                }
            }

            $res .= '</div>';

            return $res;
        }
        public static function apiRenderMainFilterLink( $POST ) {
            foreach (['brands', 'models', 'price'] as $key) {
                if (isset($POST[$key]) && is_string($POST[$key])) {
                    $decoded = json_decode($POST[$key], true);
                    if (is_array($decoded)) {
                        $POST[$key] = $decoded;
                    }
                }
            }
            
            $link = '/cars/';
            $link .= ( $POST['entity'] ) ?: 'new'; $link .= '/';
            if ( $POST['city'] && count(explode(',',$POST['city'])) == 1 ) $link .= YApp::getCityAlias($POST['city']).'/';
            if ( is_countable($POST['brands']) && count($POST['brands']) == 1 ) $link .= $POST['brands'][0]['value'].'/';
            if ( (is_countable($POST['brands']) && count($POST['brands']) == 1) && (is_countable($POST['models']) && count($POST['models']) == 1) ) $link .= $POST['models'][0]['value'].'/';

            if ( (is_countable($POST['brands']) && count($POST['brands'])>1) || (is_countable($POST['models']) && count($POST['models'])>1) || !empty($POST['price']) ) $link .= '?';
            
            if ( is_countable($POST['brands']) && count($POST['brands'])>1 ) {
                $link .= 'brand=';
                $tmp = [];
                foreach ( $POST['brands'] as $item ) $tmp[] = $item['value'];
                $link .= implode(',', $tmp); 
            }
            if ( (is_countable($POST['models']) && count($POST['models'])>1) || (is_countable($POST['brands']) && count($POST['brands'])>1) ) {
                $link .= '&model=';
                $tmp = [];
                foreach ( $POST['models'] as $item ) $tmp[] = $item['value'];
                $link .= implode(',', $tmp); 
            }
            if (!empty($POST['price'])) $link .= '&price='.implode(',', $POST['price']);
            $link = str_ireplace(['?&'], '?', $link);

            $res = '<a href="'.$link.'" class="d-block b-radius-yaradius15 bg-yayellow bg-h-yadarkyellow py-3 text-center c-yablack c-h-yablack text-decoration-none text-normal">';
            $res .= 'Показать '.number_format((int)$POST['count'], 0, '.', ' ').' авто';
            $res .= '</a>';
           
            return $res;
        }
        public static function apiRenderMainFilterBrands( $POST ) {
            $rawBrands = $POST['brands'] ?? [];
            if (is_string($rawBrands)) {
                $rawBrands = json_decode($rawBrands, true) ?: [];
            }
            $brands = $s_brands = is_array($rawBrands) ? $rawBrands : [];

            if (!empty($brands)) {
                array_multisort(array_column($brands, 'vehicles'), SORT_DESC, SORT_NUMERIC, $brands);
                array_multisort(array_column($s_brands, 'name'), SORT_ASC, SORT_STRING, $s_brands);
            }
            ?>
            <div class="row mb-3">
				<div class="col">
					<div class="row brands-on-main-title">
						<div class="col-9">
							<div class="h3 block-title"><?= (($POST['entity']=='new')?'Новые автомобили':'Автомобили с пробегом');?> в наличии</div>
							<a href="#" role="top-menu-cities" class="c-yadarkgray c-h-yablack">в <?= $POST['in_city'];?></a>
						</div>
						<div class="col-3 d-flex justify-content-end align-items-center text-minus">
							<a href="/cars/<?= (($POST['entity'])?:'new');?>/" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
								Все марки
								<div class="info-arrow d-inline-block ms-2"></div>
							</a>
						</div>
					</div>
				</div>
			</div>
            <div class="row brands-on-main-items text-minus">
                <?php if ( !empty($s_brands) ) { ?>
                    <?php foreach ( array_chunk($brands, 14)[0] as $k => $item ) { ?>
                    <div>
                        <a href="<?= $item['path'];?>/" class="c-yablack c-h-yadarkgray text-uppercase d-flex justify-content-between align-items-center text-decoration-none ">
                            <span><?= $item['name'];?></span>
                            <span class="count me-2"><?= $item['vehicles'];?></span>
                        </a>
                    </div>
                    <?php } ?>
                    <div>
                        <a href="#brands" data-remodal-target="brands" class="c-yadarkgray c-h-yadarkgray text-decoration-none">
                            Все марки <span class="ms-3"><img src="/local/templates/yugavto.theme.2025/components/bitrix/news.list/main.filter/images/svg/icon-main-filter-triangle-down.svg" /></span>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="col text-center"><h4 class="block-title">К сожалению таких автомобилей не найдено</h4></div>
                <?php } ?>
			</div>
            <div class="remodal remodal-big text-start b-radius-yaradius-16" data-remodal-id="brands">
				<button data-remodal-action="close" class="remodal-close"></button>
				<div class="row mb-3">
					<div class="col">
						<div class="row brands-on-main-title">
							<div class="col-12">
								<div class="h3 block-title"><?= (($POST['entity']=='new')?'Новые автомобили':'Автомобили с пробегом');?> в наличии</div>
								<a href="#" role="top-menu-cities" class="c-yadarkgray c-h-yablack">в <?= $POST['in_city'];?></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row brands-on-main-items text-minus">
					<?php foreach ( $s_brands as $k => $item ) { ?>
					<div class="col-3 py-1">
						<a href="<?= $item['path'];?>/" class="c-yablack c-h-yadarkgray text-uppercase d-flex justify-content-between align-items-center text-decoration-none ">
							<span><?= $item['name'];?></span>
							<span class="count me-3"><?= $item['vehicles'];?></span>
						</a>
					</div>
					<?php } ?>
				</div>
				<div class="row mb-3">
					<div class="col">
						<div class="row brands-on-main-title">
							<div class="col-12 d-flex justify-content-end align-items-center text-minus">
								<a href="/cars/<?= (($POST['entity'])?:'new');?>/" class="c-yablack c-h-yadarkgray text-decoration-none block-title-link d-flex align-items-center">
									Все марки
									<div class="info-arrow d-inline-block ms-2"></div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
            <?php
        }

        public static function apiRenderMainDealershipView( $POST ) {

            $view = $POST;
            ?>
            <div class="flex-fill d-flex align-items-start justify-content-between dealerships-on-main-view bg-yalightbluegray overflow-hidden">
                <div class="dealerships-on-main-view-image position-relative b-radius-yaradius-16 w-100" style="background-image: url(<?= $view['PICTURE'];?>);">
                    <div class="dealerships-on-main-view-image-logo b-radius-yaradius-16 bg-yawhite p-2 d-flex align-items-center justify-content-center position-absolute">
                        <img class="w-100" src="<?= $view['BRAND'];?>" />
                    </div>
                    <div class="dealerships-on-main-view-image-close bg-yawhite b-radius-yaradius-8 d-flex align-items-center justify-content-center position-absolute">
                        <img src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-cross.svg" />
                    </div>
                </div>
                <div class="dealerships-on-main-view-info w-100">
                    <a class="h3 block-title d-flex align-items-top justify-content-start align-items-start text-decoration-none c-yablack c-h-yablack fw-bold mx-2" href="/dealerships/<?= $view['CODE'];?>/">
                        <?= $view['NAME'];?> 
                        <img class="dealerships-on-main-view-info-title-image ms-3" src="/local/templates/yugavto.theme.2025/components/bitrix/news.list/main.dealerships/images/svg/icon-main-dealerships-corner-right.svg" />
                    </a>
                    <div class="row dealerships-on-main-view-info-content text-minus my-2 mx-0">
                        <div class="col-12"><?= $view['ADDRESS'];?></div>
                        <div class="col-12"><?= $view['WORK'];?></div>
                        <?php if ( $view['PHONE'] ) { ?>
                        <div class="col-12 py-2">
                            <a href="tel:<?= YApp::phoneIn($view['PHONE']);?>" class="h3 fw-bold block-title c-yablack c-h-yablack text-decoration-none"><?= YApp::phoneOut($view['PHONE']);?></a>
                        </div>
                        <?php } ?>
                        <?php if ( $view['SITE']['LINK'] ) { ?>
                        <div class="col-12">
                            <a href="<?= $view['SITE']['LINK'];?>" target="_blank" class="c-yablack c-h-yablack text-decoration-none"><?= parse_url($view['SITE']['LINK'])['host'];?></a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ( $view['YANDEX_ID'] ) { ?>
				<div class="dealership-card-rating mb-3" data-id="<?= $view['YANDEX_ID'];?>"><iframe src="https://yandex.ru/sprav/widget/rating-badge/<?=  $view['YANDEX_ID'];?>?type=rating" width="150" height="50" frameborder="0"></iframe></div>
				<?php } ?>
                <div class="d-flex justify-content-between w-100 px-2">
                    <?php if ($view['BUTTONS']['CIS']) { ?>
                    <a 
                        href="/cars/<?= (($POST['ENTITY'])?:'new');?>/?dealership=<?= $view['CODE'];?>"
                        class="dealerships-on-main-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
                        <img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
                        <span>Авто в наличии</span>
                    </a>
                    <?php } ?>
                    <?php if ($view['BUTTONS']['SERVICE']) { ?>
                    <a 
                        href="/services/service/?dealership=<?= $view['CODE'];?>"
                        class="dealerships-on-main-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
                        <img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-service.svg" />
                        <span>Запись на сервис</span>
                    </a>
                    <?php } ?>
                </div>
                    
                    <?php /* 
                    <div class="row mx-0">
                        <div class="col-6 pe-1">
                            <a 
                                href="/cars/<?= (($POST['ENTITY'])?:'new');?>/?dealership=<?= $view['EXTERNAL_CODE'];?>"
                                class="dealerships-on-main-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
                                <img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
                                <span>Авто в наличии</span>
                            </a>
                        </div>
                        <div class="col-6 ps-1">
                            <a 
                                href="/cars/<?= (($POST['ENTITY'])?:'new');?>/?dealership=<?= $view['EXTERNAL_CODE'];?>"
                                class="dealerships-on-main-view-info-button b-radius-yaradius-8 px-2 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yawhite bg-h-yayellow">
                                <img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-service.svg" />
                                <span>Запись на сервис</span>
                            </a>
                        </div>
                    </div>
                    */ ?>
            </div>
            <div class="dealerships-on-main-view-footer d-flex justify-content-between">
				<div class="dealerships-on-main-view-footer-left bg-yawhite d-flex">
					<div class="dealerships-on-main-view-footer-left-content w-100 bg-yalightbluegray">
						<a 
                            href="#FORM_CALLBACK" 
                            class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow dealerships-on-main-view-button mx-2"
                            data-remodal-target="FORM_CALLBACK" 
                            data-dealership="<?= $view['CODE'];?>" 
                            role="setDealership"
                            >Обратный звонок</a>
					</div>
				</div>
				<div class="dealerships-on-main-view-footer-right bg-yalightbluegray d-flex">
					<div class="dealerships-on-main-view-footer-right-content bg-yawhite w-100 d-flex justify-content-end align-items-end">
						<a 
							href="<?= $view['BUTTONS']['MAP'];?>" 
							class="b-radius-yaradius-12 bg-yalightbluegray dealerships-on-main-view-item d-flex justify-content-center align-items-center position-relative">
                            <img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route.svg" />
                            <img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route-a.svg" />
                        </a>
					</div>
				</div>
			</div>
            
            <?php

            return '';
        }


        public static function transformImageUrl($url) {
            $parts = parse_url($url);
            if (!isset($parts['path'])) return $url;
            $path = $parts['path'];
            if (preg_match('#^/upload/Cis/vehicles/\d+/([^/]+)$#', $path, $m)
                && !str_contains($path, '/sm/')) {
                $path = dirname($path) . '/sm/' . $m[1];
            }
            if (preg_match('#^/upload/Cis/#', $path)) {
                $host = YApp::API_DOMAIN;
                $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                $url = $scheme . '://' . $host . $path;
                if (isset($parts['query'])) $url .= '?' . $parts['query'];
            }
            return $url;
        }

        public static function apiRenderMainCompilations($POST) {

            $type = ($POST['entity'] == 'used') ? '2' : '1';
            $url = 'https://'.YApp::GO_API_DOMAIN.'/api/v1/cis/random?token=ef6541490c8bb9d481d37020b6a1953e&type='.$type.'&limit=12';
            if ( $POST['query'] ) $url .= '&'.$POST['query'];
            if ( $POST['price'] ) $url .= '&price='.$POST['price'];
            if ( $POST['city'] ) {
                $cityVal = is_array($POST['city']) ? implode(',', $POST['city']) : $POST['city'];
                $url .= '&city=' . $cityVal;
            }

            $res = json_decode( YApp::httpGet($url), true);
            if (is_array($res['items'] ?? null)) {
                foreach ($res['items'] as &$item) {
                    if (!empty($item['image'])) {
                        $item['image'] = self::transformImageUrl($item['image']);
                    }
                    if (!empty($item['images'])) {
                        foreach ($item['images'] as &$img) {
                            if (!empty($img['preview'])) {
                                $img['preview'] = self::transformImageUrl($img['preview']);
                            }
                            if (!empty($img['preview_large'])) {
                                $img['preview_large'] = self::transformImageUrl($img['preview_large']);
                            }
                        }
                        unset($img);
                    }
                }
                unset($item);
            }
            ?>
            <?php if ( $res['totalCount'] ) { ?>
            <div 
                class="d-none main-compilations-data" 
                data-text="Показать <?= number_format((int)$res['totalCount'], 0, '.', ' ');?> <?= YApp::getWorld($res['totalCount'], 'a');?>"
                data-range='<?= json_encode($res['ranges']['price']);?>'
                data-query="<?= htmlspecialchars($POST['query']);?>"
                data-link="<?= htmlspecialchars($POST['link']);?>"
                ></div>
            <?php $vehicleMode = $POST['entity'] ?: 'new'; ?>
            <?php foreach ( $res['items'] as $item ) { ?>
                <?php include $_SERVER['DOCUMENT_ROOT'].'/local/templates/yugavto.theme.2025/include/item_vehicle.php'; ?>
            <?php } ?>
            <?php } else { ?>
                <div 
                    class="d-none compilations-on-main-data" 
                    data-text="Показать все автомобили"
                    data-range='<?= json_encode($res['ranges']['price']);?>'
                    data-query="<?= htmlspecialchars($POST['query']);?>"
                    data-link="/cars/<?= htmlspecialchars(($POST['entity'])?:'new');?>/"
                    ></div>
                <p class="my-5 text-center w-100">К сожалению таких автомобилей не найдено</p>
            <?php } ?>
            <?php 
            return '';
        }

        public static function apiGetCitiesByName( $POST ) {
            foreach ( explode(',', $POST['city']) as $item ) $res[] = YApp::getCityAlias($item);
            return $res;
        }

        public static function setCityCookie( $q ) {


        }

        public static function apiMainCardsLinks($POST) {
            
            $res = [
                'new' => '/cars/new/'.((count($POST['city'])==1)?YApp::getCityAlias($POST['city'][0]).'/':''),
                'used' => '/cars/used/'.((count($POST['city'])==1)?YApp::getCityAlias($POST['city'][0]).'/':'')
            ];
            return $res;
        }


        public static function apiRenderSearch($POST) {

            $query = trim($POST['query'] ?? '');
            if ( $query === '' ) return '';

            $url = 'https://'.YApp::GO_API_DOMAIN.'/api/v1/cis/search?q='.urlencode($query).'&token=ef6541490c8bb9d481d37020b6a1953e';

            $raw = json_decode( YApp::httpGet($url), true );
            if ( empty($raw) ) return '';

            $filter = $raw['filter'] ?? [];
            $pseudo = $raw['pseudo'] ?? [];
            $hasNew = !empty($raw['vehicles_new']);
            $hasUsed = !empty($raw['vehicles_used']);

            if ( !empty($pseudo) ) {
                ?><div class="text-minus mb-2"><?php
                foreach ( $pseudo as $item ) {
                    ?><span class="me-2"><?= htmlspecialchars($item['name']);?>: <strong><?= htmlspecialchars($item['value']);?></strong></span><?php
                }
                ?></div><?php
            }

            if ( $hasNew ) {
                ?><p class="mb-1">Найденные новые автомобили:</p>
                <ul class="list-unstyled mb-0"><?php
                foreach ( $raw['vehicles_new'] as $v ) {
                    $link = '/cars/new/'.rawurlencode($v['brand_code']).'/'.rawurlencode($v['model_code']).'/'.(int)$v['id'].'/';
                    $img = 'https://'.YApp::API_DOMAIN.'/upload/Cis/vehicles/'.(int)$v['id'].'/sm/00.webp';
                    $price = number_format((float)$v['price'], 0, '.', ' ');
                    ?><li class="my-1 d-flex justify-content-start align-items-center">
                        <img src="<?= $img;?>" alt="">
                        <a href="<?= $link;?>" target="_blank" class="ms-2 c-yablack c-h-yablack text-decoration-none"><?= htmlspecialchars($v['name']);?> от <?= $price;?> ₽</a>
                    </li><?php
                }
                ?></ul>
                <p class="mb-0"><a href="<?= self::buildSearchLink($filter, 'new');?>" target="_blank" class="c-yablack c-h-yablack">Все авто</a></p><?php
            }

            if ( $hasUsed ) {
                if ( $hasNew ) echo '<hr>';
                ?><p class="mb-1">Найденные автомобили с пробегом:</p>
                <ul class="list-unstyled mb-0"><?php
                foreach ( $raw['vehicles_used'] as $v ) {
                    $link = '/cars/used/'.rawurlencode($v['brand_code']).'/'.rawurlencode($v['model_code']).'/'.(int)$v['id'].'/';
                    $img = 'https://'.YApp::API_DOMAIN.'/upload/Cis/vehicles/'.(int)$v['id'].'/sm/00.webp';
                    $price = number_format((float)$v['price'], 0, '.', ' ');
                    $year = (int)$v['year'];
                    ?><li class="my-1 d-flex justify-content-start align-items-center">
                        <img src="<?= $img;?>" alt="">
                        <a href="<?= $link;?>" target="_blank" class="ms-2 c-yablack c-h-yablack text-decoration-none"><?= htmlspecialchars($v['name']);?><?= $year ? ' '.$year.' г.в.' : '';?> от <?= $price;?> ₽</a>
                    </li><?php
                }
                ?></ul>
                <p class="mb-0"><a href="<?= self::buildSearchLink($filter, 'used');?>" target="_blank" class="c-yablack c-h-yablack">Все авто</a></p><?php
            }

            if ( $hasNew || $hasUsed ) {
                if ( !empty($pseudo) ) {
                    ?><hr>
                    <div class="text-minus"><?php
                    foreach ( $pseudo as $item ) {
                        echo ' '.htmlspecialchars($item['name']).' - '.htmlspecialchars($item['value']).';';
                    }
                    ?></div><?php
                }
            } else {
                ?><p class="text-minus c-yadarkgray mb-0">Таких автомобилей не найдено</p>
                <hr><?php
            }

            return '';
        }

        private static function buildSearchLink($filter, $entity) {
            $path = '/cars/'.$entity.'/';
            $params = [];
            if ( !empty($filter['brand']) ) $params[] = 'brand='.implode(',', $filter['brand']);
            if ( !empty($filter['model']) ) $params[] = 'model='.implode(',', $filter['model']);
            if ( !empty($filter['price_from']) ) $params[] = 'price_from='.$filter['price_from'];
            if ( !empty($filter['price_to']) ) $params[] = 'price_to='.$filter['price_to'];
            if ( !empty($filter['year_from']) ) $params[] = 'year_from='.$filter['year_from'];
            if ( !empty($filter['year_to']) ) $params[] = 'year_to='.$filter['year_to'];
            if ( !empty($filter['body']) ) $params[] = 'body='.$filter['body'];
            if ( !empty($filter['color']) ) $params[] = 'color='.$filter['color'];
            if ( !empty($filter['transmission']) ) $params[] = 'transmission='.$filter['transmission'];
            if ( !empty($filter['engine']) ) $params[] = 'engine='.$filter['engine'];
            if ( !empty($filter['drive']) ) $params[] = 'drive='.$filter['drive'];
            return $path.(!empty($params) ? '?'.implode('&', $params) : '');
        }

        public static function apiStoriesReaction($POST) {

            // YApp::sp($POST);
            // YApp::sp(['COUNT_'.$POST['action'] => $POST['VALUE']]);

            CIBlockElement::SetPropertyValuesEx($POST['id'], 13, ['STORIES_COUNT_'.$POST['action'] => $POST['value']]);

            return ['result' => number_format($POST['value'], 0, '.', ' ')];
        }
    }

?>