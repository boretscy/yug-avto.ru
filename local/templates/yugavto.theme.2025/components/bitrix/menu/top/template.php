<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="bg-yablack py-4 top-menu c-yawhite position-relative" itemscope itemtype="https://schema.org/WPHeader">
    <div class="container d-none d-lg-block">
        <div class="row">
            <div class="col-5 col-lg-2 d-none d-lg-flex justify-content-center justify-content-lg-start  align-items-center position-relative">
                <div class="d-flex justify-content-start align-items-center cursor-pointer c-h-yayellow position-relative ps-4 icon-link" role="cities">
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-map.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-map.svg');?>" class="me-2" />
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-map-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-map-a.svg');?>" class="me-2" />
                    <span class="city-menu-title"><?= $arResult['TITLE'][count($arResult['COOKIE_CITIES'])];?></span>
                </div>
                <div class="city-wrap p-3 bg-yawhite bg-yawhite b-yalightbluegray position-absolute b-radius-yaradius-16 c-yablack d-none"> <!-- lg cities -->
                    <ul class="list-unstyled mb-0">
                        <?php /* <li class="submenu-item py-1 c-yadarkgray c-h-yadarkgray city-dropdown-title">Все города</li> */ ?>
                        <?php foreach ( $arResult['CITIES'] as $item ) { ?>
                        <li class="submenu-item py-1 top-menu-cities-item <?= ((in_array($item['name'],$arResult['COOKIE_CITIES']))?'selected':'');?>" role="setCity" data-city="<?= $item['code'];?>" data-name="<?= $item['name'];?>">
                            <a href="#" class="text-decoration-none c-yablack c-h-yadarkgray d-flex justify-content-between align-items-center">
                                <?= $item['name'];?>
                                <img src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-form-dropdown-item.svg" role="unselected" />
                                <img src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-form-dropdown-item-selected.svg" role="selected" />
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-6 col-xl-7 d-none d-lg-block position-relative"> <!-- lg search -->
                <input type="text" id="search" class="form-control p-2 search b-radius-yaradius-16 bg-yablack px-5" placeholder="Поиск автомобиля" />
                <div class="search-clear cursor-pointer position-absolute">
                    <img src="<?= $templateFolder;?>/images/svg/icon-menu-input-search-clear.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-input-search-clear.svg');?>" />
                </div>
                <div class="b-radius-yaradius-16 p-4 bg-yawhite b-yalightbluegray position-absolute search-wrap c-yablack">
                    
                </div>
            </div>
            <div class="col-4 col-xl-3 d-none d-lg-flex justify-content-end align-items-center"> <!-- lg icons -->
                <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>" class="d-flex justify-content-center align-items-center c-yawhite c-h-yayellow text-decoration-none fw-bold me-3 phone position-relative ps-4 icon-link">
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-button-phone.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-button-phone.svg');?>" class="me-2" />
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-button-phone-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-button-phone-a.svg');?>" class="me-2" />
                    <span><?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?></span>
                </a>
                <a 
                    href="/cars/favorites/" 
                    class="position-relative text-decoration-none top-menu-icon position-relative icon-link <?= ((is_countable($GLOBALS['CIS_FAVORITES'])&&count($GLOBALS['CIS_FAVORITES'])>0)?'active':'');?>" 
                    data="CIS_FAVORITES"
                    >
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-favorites.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-favorites.svg');?>" class="" />
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-favorites-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-favorites-a.svg');?>" class="" />
                    <div class="icon-count b-yawhite c-yayellow c-h-yayellow bg-yablack fw-bold position-absolute justify-content-center align-items-center">
                        <?php if ( is_countable($GLOBALS['CIS_FAVORITES']) ) { ?>
                            <?= count($GLOBALS['CIS_FAVORITES']);?>
                        <?php } ?>
                    </div>
                </a>
                <a 
                    href="/cars/compare/" 
                    class="text-decoration-none top-menu-icon position-relative icon-link <?= ((is_countable($GLOBALS['CIS_COMPARE'])&&count($GLOBALS['CIS_COMPARE'])>0)?'active':'');?>" 
                    data="CIS_COMPARE" 
                    >
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-compare.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-compare.svg');?>" class="" />
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-compare-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-compare-a.svg');?>" class="" />
                    <div class="icon-count b-yawhite c-yayellow c-h-yayellow bg-yablack fw-bold position-absolute justify-content-center align-items-center">
                        <?php if ( is_countable($GLOBALS['CIS_COMPARE']) ) { ?>
                            <?= count($GLOBALS['CIS_COMPARE']);?>
                        <?php } ?>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="container d-lg-none">
        <div class="row">
            <div class="col">
                <a href="#" class="top-menu-mobile-burger d-flex justify-content-center justify-content-center" role="menu-mobile">
                    <img src="<?= $templateFolder;?>/images/svg/icon-menu-m-burger.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-burger.svg');?>" />
                    <img src="<?= $templateFolder;?>/images/svg/icon-menu-m-cross.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-cross.svg');?>" class="d-none" />
                </a>
            </div>
            <div class="col d-flex d-lg-none justify-content-end align-items-center">
                <a href="/cars/favorites/" class="position-relative text-decoration-none top-menu-icon position-relative icon-link <?= ((is_countable($GLOBALS['CIS_FAVORITES'])&&count($GLOBALS['CIS_FAVORITES'])>0)?'active':'');?>" data="CIS_FAVORITES" >
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-m-favorites.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-favorites.svg');?>" />
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-m-favorites-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-favorites-a.svg');?>" />
                    <div class="icon-count b-yawhite c-yayellow c-h-yayellow bg-yablack fw-bold position-absolute justify-content-center align-items-center">
                        <?php if ( is_countable($GLOBALS['CIS_FAVORITES']) ) { ?>
                            <?= count($GLOBALS['CIS_FAVORITES']);?>
                        <?php } ?>
                    </div>
                </a>
                <a href="/cars/compare/" class="text-decoration-none top-menu-icon position-relative icon-link me-3 <?= ((is_countable($GLOBALS['CIS_COMPARE'])&&count($GLOBALS['CIS_COMPARE'])>0)?'active':'');?>" data="CIS_COMPARE" >
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-m-compare.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-compare.svg');?>" />
                    <img class="position-absolute start-0" src="<?= $templateFolder;?>/images/svg/icon-menu-m-compare-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-compare-a.svg');?>" />
                    <div class="icon-count b-yawhite c-yayellow c-h-yayellow bg-yablack fw-bold position-absolute justify-content-center align-items-center">
                        <?php if ( is_countable($GLOBALS['CIS_FAVORITES']) ) { ?>
                            <?= count($GLOBALS['CIS_FAVORITES']);?>
                        <?php } ?>
                    </div>
                </a>
                <a href="#menu-search" class="position-relative text-decoration-none top-menu-icon position-relative icon-link d-flex justify-content-center align-items-center me-1 menu-search icon-link-iphone" >
                    <img class="position-absolute start-0 cursor-pointer" src="<?= $templateFolder;?>/images/svg/icon-menu-m-search.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-search.svg');?>" />
                    <img class="position-absolute start-0 cursor-pointer d-none" src="<?= $templateFolder;?>/images/svg/icon-menu-m-search-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-search-a.svg');?>" />
                </a>
                <a href="#menu-cities" class="position-relative text-decoration-none top-menu-icon position-relative icon-link d-flex justify-content-center align-items-center me-1 menu-cities icon-link-iphone" >
                    <img class="position-absolute start-0 cursor-pointer" src="<?= $templateFolder;?>/images/svg/icon-menu-m-map.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-map.svg');?>" />
                    <img class="position-absolute start-0 cursor-pointer d-none" src="<?= $templateFolder;?>/images/svg/icon-menu-m-map-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-map-a.svg');?>"/>
                </a>
                <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>" class="position-relative text-decoration-none top-menu-icon position-relative icon-link d-flex justify-content-center align-items-center icon-link-iphone" >
                    <img class="position-absolute start-0 cursor-pointer" src="<?= $templateFolder;?>/images/svg/icon-menu-m-phone.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-phone.svg');?>" />
                    <img class="position-absolute start-0 cursor-pointer d-none" src="<?= $templateFolder;?>/images/svg/icon-menu-m-phone-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-phone-a.svg');?>"/>
                </a>
            </div>
        </div>
    </div>


    <div class="bg-yawhite top-menu-mobile position-absolute w-100 b-b-yalightbluegray d-none d-lg-none">
        <div class="top-menu-mobile-wrap p-4 pt-0 w-100 d-flex flex-column justify-content-start align-items-start">
            <div class="w-100" role="screen" data-screen="1">
                <div class="text-minus d-flex justify-content-between align-items-center pb-2 b-b-yalightbluegray">
                    <div class="c-yadarkgray city-menu-title"><?= $arResult['TITLE'][count($arResult['COOKIE_CITIES'])];?></div>
                    <div class="c-yadarkgray d-flex align-items-center cursor-pointer" role="change-screen" data-screen="2">
                        Другой город
                        <img src="<?= $templateFolder;?>/images/svg/icon-menu-m-arr.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-arr.svg');?>" class="ms-2" />
                    </div>
                </div>
                <div class="position-relative my-2 mt-3"> <!-- lg search -->
                    <input type="text" id="search" class="form-control p-2 search b-radius-yaradius-16 bg-yablack px-5" placeholder="Поиск автомобиля" />
                    <div class="search-clear cursor-pointer position-absolute">
                        <img src="<?= $templateFolder;?>/images/svg/icon-menu-m-input-search-clear.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-input-search-clear.svg');?>" />
                    </div>
                    <div class="b-radius-yaradius-16 p-4 bg-yawhite b-yalightbluegray position-absolute search-wrap c-yablack w-100">
                        
                    </div>
                </div>
                <ul class="list-unstyled m-0 menu-mobile">
                    <?php foreach ( $arResult['MENU'] as $k => $arItem ) { ?>
                    <li 
                        class="py-2 menu-item <?= (($arItem['SUBMENU'])?'is_submenu':'is_singlemenu');?> position-relative"
                        itemscope itemtype="https://schema.org/SiteNavigationElement"
                        <?php if ($arItem['SUBMENU']) { ?>
                        role="submenu-mobile"
                        data-menu="<?= 'submenu-'.$k;?>"
                        <?php } // if SUBMENU ?>
                        >
                        <a 
                            href="<?= $arItem['LINK'];?>"
                            itemprop="url"
                            class="text-decoration-none c-yablack c-h-yablack w-100 d-flex justify-content-start align-items-center">
                            <span itemprop="name"><?= $arItem['TEXT'];?></span>
                            <?php if ($arItem['SUBMENU']) { ?>
                            <img src="<?= $templateFolder;?>/images/svg/icon-menu-m-bullet.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-bullet.svg');?>" class="ms-2" />
                            <img src="<?= $templateFolder;?>/images/svg/icon-menu-m-bullet-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-bullet-a.svg');?>" class="ms-2 d-none" />
                            <?php } // if SUBMENU ?>
                        </a>
                    </li>
                    <?php if ($arItem['SUBMENU']) { ?>
                        <li 
                            class="submenu-mobile p-2 fw-normal"
                            data-menu="<?= 'submenu-'.$k;?>"
                            >
                            <ul class="list-unstyled">
                                <?php foreach ($arItem['SUBMENU'] as $item) { ?>
                                <li class="submenu-item py-1" itemscope itemtype="https://schema.org/SiteNavigationElement">
                                    <a href="<?= $item[1];?>" itemprop="url" class="text-decoration-none c-yadarkgray c-h-yadarkgray"><span itemprop="name"><?= $item[0];?></span></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </div>
            <div class="w-100 d-none" role="screen" data-screen="2">
                <div class="d-flex justify-content-start align-items-center pb-2 b-b-yalightbluegray">
                    <a href="#" role="change-screen" data-screen="1"><img src="<?= $templateFolder;?>/images/svg/icon-menu-m-arr-a.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-arr-a.svg');?>" class="me-3" /></a>
                    <div class="text-uppercase c-yablack fw-bold top-menu-mobile-city-title">Выберите город</div>
                </div>
                <ul class="list-unstyled m-0 mt-3 menu-mobile">
                    <?php foreach ( $arResult['CITIES'] as $item ) { ?>
                    <li class="submenu-item py-1 top-menu-cities-item <?= ((in_array($item['name'],$arResult['COOKIE_CITIES']))?'selected':'');?>" role="setCity" data-city="<?= $item['code'];?>" data-name="<?= $item['name'];?>">
                        <a href="#" class="text-decoration-none c-yablack c-h-yadarkgray d-flex justify-content-between align-items-center">
                            <?= $item['name'];?>
                            <img src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-form-dropdown-item.svg" role="unselected" />
                            <img src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-form-dropdown-item-selected.svg" role="selected" />
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="w-100 mt-4">
                <a 
                    href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>" 
                    class="d-block c-yablack c-h-yablack text-decoration-none bg-yalightbluegray b-yalightbluegray b-radius-yaradius-16 fw-bold d-flex justify-content-center align-items-center top-menu-mobile-button mb-3">
                    <img class="me-2" src="<?= $templateFolder;?>/images/svg/icon-menu-m-button-phone.svg?<?= md5_file(__DIR__.'/images/svg/icon-menu-m-button-phone.svg');?>"  />
                    <span><?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?></span>
                </a>
                <a 
                    href="#FORM_CALLBACK" 
                    data-form="FORM_CALLBACK"
                    class="d-block c-yadarkgray c-h-yadarkgray text-decoration-none bg-yawhite b-yalightbluegray b-radius-yaradius-16 d-flex justify-content-center align-items-center top-menu-mobile-button">
                    <span>Заказать звонок</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="bg-yawhite py-4 top-menu">
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-2">
                <a href="/">
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.svg" alt="Юг-Авто">
                </a>
            </div>
            <div class="col-8 px-0 d-none d-lg-flex justify-content-center align-items-center">
                <ul class="list-inline m-0 menu">
                    <?php foreach ( $arResult['MENU'] as $k => $arItem ) { ?>
                    <li 
                        class="list-inline-item mx-0 px-2 pe-3 px-xl-3 text-start menu-item <?= (($arItem['SUBMENU'])?'is_submenu':'is_singlemenu');?> position-relative"
                        itemscope itemtype="https://schema.org/SiteNavigationElement"
                        <?php if ($arItem['SUBMENU']) { ?>
                        role="submenu"
                        data-menu="<?= 'submenu-'.$k;?>"
                        <?php } // if SUBMENU ?>
                        >
                        <a 
                            href="<?= $arItem['LINK'];?>"
                            itemprop="url"
                            class="text-decoration-none c-yablack c-h-yadarkgray"
                            ><span itemprop="name"><?= $arItem['TEXT'];?></span></a>
                        <?php if ($arItem['SUBMENU']) { ?>
                            <div 
                                class="submenu position-absolute p-3 b-radius-yaradius-16 bg-yawhite b-yagray"
                                data-menu="<?= 'submenu-'.$k;?>"
                                >
                                <div class="triangle position-absolute"></div>
                                <ul class="list-unstyled">
                                    <?php foreach ($arItem['SUBMENU'] as $item) { ?>
                                    <li class="submenu-item py-1" itemscope itemtype="https://schema.org/SiteNavigationElement">
                                        <a href="<?= $item[1];?>" itemprop="url" class="text-decoration-none c-yablack c-h-yadarkgray"><span itemprop="name"><?= $item[0];?></span></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </li>
                    
                    <?php } // foreact ITEMS ?>
                </ul>
            </div>
            <div class="col-6 col-lg-2 d-flex justify-content-end align-items-center">
                <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/reward.png" class="reward">
            </div>
        </div>
    </div>
</div>

 
<script>
    YAPP.CITIES = {};
    YAPP.CITIES.TITLE = <?= json_encode($arResult['TITLE']);?>;
    YAPP.API_DOMAIN = '<?= YApp::API_DOMAIN;?>';
</script>