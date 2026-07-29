<?php 

$res['MENU'] = $arResult;

$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'CODE' => 'CITY'
    ]
);
while ( $ob = $rs->Fetch() ) $res['CITIES'][] = ['code'=>$ob['XML_ID'],'name'=>$ob['VALUE']];
$res['COOKIE_CITIES'] = explode(',', YApp::setCityCookie());
unset(
    $res['CITIES'][4],
    $res['CITIES'][5],
    $res['CITIES'][6]
);

foreach ( $res['MENU'] as $k => $item ) {

    if ( file_exists($_SERVER['DOCUMENT_ROOT'].$item['LINK'].'.top_menu_items.menu.php') ) {
        
        include $_SERVER['DOCUMENT_ROOT'].$item['LINK'].'.top_menu_items.menu.php';
        $res['MENU'][$k]['SUBMENU'] = $aMenuLinks;
    }
    if ( $item['LINK'] == '/cars/' ) $res['MENU'][$k]['LINK'] = '/cars/new/';
}
for ( $i = 0; $i <= count($res['CITIES']); $i++ ) {
    if ( $i == 1 ) {
        $res['TITLE'][] = (count($res['COOKIE_CITIES'])==1)? $res['COOKIE_CITIES'][0] : $i.' '.YApp::getWorld($i, 'c');
    } elseif ( $i == count($res['CITIES']) ) {
        $res['TITLE'][] = 'Все города';
    } else {
        $res['TITLE'][] = $i.' '.YApp::getWorld($i, 'c');
    }
}

$arResult = $res;

?>