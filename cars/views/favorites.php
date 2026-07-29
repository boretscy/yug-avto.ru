<?php 
    $Asset = \Bitrix\Main\Page\Asset::getInstance();
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css'));
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/favorites.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/favorites.css'));
?>
<div class="bg-yalightbluegray top-container pb-3 pb-lg-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="bg-yawhite b-radius-yaradius-16 p-4">
                    <?php if ( !empty($data['items']) ) { ?>
                        <h1 class="h2 text-uppercase mb-3">Избранные автомобили</h1>
                        <div class="row my-3">
                            <div class="col-6 col-lg-2">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="fav-com-icon bg-yalightbluegray b-radius-yaradius-12 d-flex justify-content-center align-items-center me-3">
                                        <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-favorites.svg" />
                                    </div>
                                    <div>Избранное <span class="c-yayellow ms-2"><?= count($data['items']);?></span></div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2">
                                <a href="?action=clear" class="d-flex justify-content-start align-items-center c-yablack c-h-yablack text-decoration-none">
                                    <div class="fav-com-icon bg-yalightbluegray b-radius-yaradius-12 d-flex justify-content-center align-items-center me-3">
                                        <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-trash.svg" />
                                    </div>
                                    <div>Очистить</div>
                                </a>
                            </div>
                        </div>
                        <div class="row vehicle-list">
                            <?php foreach ($data['items'] as $item) { ?>
                            <div class="col-md-6 col-lg-4 col-xl-3 vehicle-list-item">
                                <?php if ( $item['type'] == 'vehicle' ) { ?>
                                    <?php include __DIR__.'/vehicles/favorites_vehicle.php'; ?>
                                <?php } elseif ( $item['type'] == 'random_cta' ) { ?>
                                    <?php include __DIR__.'/vehicles/item_cta.php'; ?>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="row no-fav-com">
                            <div class="col-lg-6 d-flex flex-column justify-content-between align-items-start">
                                <h1 class="h2 text-uppercase">Избранные автомобили</h1>
                                <div class="h3 c-yadarkgray">Вы еще не добавили в избранное ни одного автомобиля</div>
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