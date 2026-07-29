<?php 
    $Asset = \Bitrix\Main\Page\Asset::getInstance();
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css'));
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/compare.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/compare.css'));
    $Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/compare.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/js/compare.js'));
?>
<div class="bg-yalightbluegray top-container pb-3 pb-lg-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="bg-yawhite b-radius-yaradius-16 p-4">
                    <?php if ( !empty($data['items']) ) { ?>
                        <h1 class="h2 text-uppercase mb-3">Сравнение автомобилей</h1>
                        <div class="row my-3">
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="fav-com-icon bg-yalightbluegray b-radius-yaradius-12 d-flex justify-content-center align-items-center me-3">
                                        <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-compare.svg" />
                                    </div>
                                    <div>Сравнение <span class="c-yayellow ms-2"><?= count($data['items']);?></span></div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2">
                                <a href="?action=clear" class="d-flex justify-content-start align-items-center c-yablack c-h-yablack text-decoration-none">
                                    <div class="fav-com-icon bg-yalightbluegray b-radius-yaradius-12 d-flex justify-content-center align-items-center me-3">
                                        <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-trash.svg" />
                                    </div>
                                    <div>Очистить</div>
                                </a>
                            </div>
                            <div class="col d-none d-md-flex justify-content-end align-items-center">
                                <span class="compare-nav compare-nav-prev b-radius-yaradius-12 ms-2 d-flex justify-content-center align-items-center"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-compare-arrow.svg" class="w-auto rotate-180" /></span>
                                <span class="compare-nav compare-nav-next b-radius-yaradius-12 ms-2 d-flex justify-content-center align-items-center"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-compare-arrow.svg" class="w-auto" /></span>
                            </div>
                        </div>

                        <div class="row vehicle-list">
                            <div class="col-md-5 col-lg-4 col-xl-3 d-none d-md-block">
                                <div class="bg-yalightbluegray b-radius-yaradius-16 p-2 h-100">
                                    <div class="compare-head b-radius-yaradius-16 bg-yawhite text-center d-flex justify-content-center align-items-center mb-3">
                                        <a href="<?= $app->Conf()['baseUrl'];?>/" class="c-yadarkgray c-h-yadarkgray text-decoration-none">
                                            <div class="add">+</div>
                                            Добавить авто
                                        </a>
                                    </div>
                                    <div class="h5 d-block fw-bold vehicle-card-content-title">Бренд, модель, комплектация</div>
                                    <div class="vehicle-card-price text-plus fw-bold">Стоимость</div>
                                    <hr class="opacity-100" />
                                    <div class="compare-body mb-4 pb-3">
                                        <div class="compare-body-title text-plus d-flex justify-content-between align-items-center" data-index="0">
                                            <span>Технические параметры</span>
                                            <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/corner.svg" class="rotate-180" />
                                        </div>
                                        <ul class="list-unstyled compare-body-items c-yadarkgray" data-index="0">
                                            <li class="py-2">Кузов</li>
                                            <li class="py-2">Цвет кузова</li>
                                            <li class="py-2">Масса</li>
                                            <li class="py-2">Мощность</li>
                                            <li class="py-2">Тип двигателя</li>
                                            <li class="py-2">Расход топлива</li>
                                            <li class="py-2">Максимальная скорость</li>
                                            <li class="py-2">Год выпуска</li>
                                        </ul>
                                        <hr class="opacity-100" />
                                        <div class="compare-body-title text-plus d-flex justify-content-between align-items-center" data-index="1">
                                            <span>Размеры</span>
                                            <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/corner.svg" class="rotate-180"/>
                                        </div>
                                        <ul class="list-unstyled compare-body-items c-yadarkgray" data-index="1">
                                            <li class="py-2">Длина</li>
                                            <li class="py-2">Ширина</li>
                                            <li class="py-2">Высота</li>
                                        </ul>
                                        <hr class="opacity-100" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-8 col-xl-9 position-relative mb-3 mb-lg-0">
                                <div class="swiper-compare overflow-hidden position-relative" style="cursor: ew-resize;">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($data['items'] as $item) { ?>
                                        <div class="swiper-slide vehicle-list-item">
                                            <?php if ( $item['type'] == 'vehicle' ) { ?>
                                                <?php include __DIR__.'/vehicles/compare_vehicle.php'; ?>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                                <div class="compare-nav compare-nav-mobile compare-nav-prev d-md-none">
                                    <div class="compare-nav-wrap d-flex justify-content-center align-items-center b-radius-yaradius-12">
                                        <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" />
                                    </div>
                                </div>
                                <div class="compare-nav compare-nav-mobile compare-nav-next d-md-none">
                                    <div class="compare-nav-wrap d-flex justify-content-center align-items-center b-radius-yaradius-12">
                                        <img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-md-none">
                                <div class="bg-yalightgray b-radius-yaradius-16 p-3">
                                    <div class="compare-head text-center d-flex justify-content-center align-items-center">
                                        <a href="<?= $app->Conf()['baseUrl'];?>/" class="c-yadarkgray c-h-yadarkgray text-decoration-none">
                                            <div class="add">+</div>
                                            Добавить авто
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php } else { ?>
                        <div class="row no-fav-com">
                            <div class="col-lg-6 d-flex flex-column justify-content-between align-items-start">
                                <h1 class="h2 text-uppercase">Сравнение автомобилей</h1>
                                <div class="h3 c-yadarkgray">Вы еще не добавили к сравнению ни одного автомобиля</div>
                                <a 
									href="/cars/new/" 
									class="b-radius-yaradius-16 bg-yayellow bg-h-yadarkyellow py-3 px-5 text-center c-yablack c-h-yablack text-decoration-none text-normal" 
									>К списку моделей</a>
                            </div>
                            <div class="col-lg-6 position-relative">
                                <img class="position-xl-absolute w-100 mt-5 mt-lg-0" src="<?= $app->Conf()['assetsUrl'];?>/assets/images/no-fav.png" />
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>