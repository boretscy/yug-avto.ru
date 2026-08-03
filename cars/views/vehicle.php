<?php 
    $Asset = \Bitrix\Main\Page\Asset::getInstance();
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css'));
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/vehicle.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/vehicle.css'));
    $Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/vehicle.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/js/vehicle.js'));
?>
<div class="bg-yalightbluegray c-yablack vehicle-title py-1">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="bg-yawhite px-3 py-4 b-radius-yaradius-16">
                    <div class="row">
                        <div class="col-md-7 col-xl-7">
                            <h1 class="h3 fw-bold"><?= $data['brand']['name'];?> <?= $data['model']['name'];?> <?= (($data['equipment'])?:'');?></h1>
                            <ul class="list-inline my-1 d-md-block">
                                <li class="list-inline-item position-relative me-3 text-uppercase"><?= $data['status']['name'];?></li>
                                <li class="list-inline-item position-relative me-3"><?= $data['dealership']['name'];?></li>
                                <li class="list-inline-item position-relative me-3">
                                    <a href="tel:+<?= $app->phoneIn($data['dealership']['phone']);?>" class="c-yablack c-h-yablack" role="not-cover"><?= $app->phoneOut($data['dealership']['phone']);?></a>
                                </li>
                                <li class="list-inline-item position-relative me-3">Обновлено <?= $data['_updated'];?></li>
                            </ul>
                        </div>
                        <div class="col-md-5 col-xl-2 text-md-end">
                            <div class="h3 fw-bold my-1 <?= (($data['price']-$data['min_price']==0)?'vehicle-title-price':'');?>" role="min-price">
                                <?= number_format($data['min_price'], 0, '.', ' ');?> ₽
                            </div>
                            <?php if ( $data['price'] - $data['min_price'] > 0 ) { ?>
                            <div class="text-decoration-line-through">
                                <?= number_format($data['price'], 0, '.', ' ');?> ₽
                            </div>
                            <?php } ?>
                            <a
                                href="#" rel="nofollow"
                                class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase text-center b-radius-yaradius-16 bg-yayellow vehicle-title-button d-block d-xl-none mt-3 mt-xl-0"
                                data-remodal-target="offer-modal"
                                role="not-cover"
                                >Получить предложение</a>
                        </div>
                        <div class="col-xl-3 d-none d-xl-block">
                            <a
                                href="#" rel="nofollow"
                                class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-16 bg-yayellow vehicle-title-button <?= (($data['price']-$data['min_price']==0)?'without-discount':'');?>"
                                data-remodal-target="offer-modal"
                                role="not-cover"
                                >Получить предложение</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="py-4 bg-yalightbluegray top-container">
    <div class="container vehicle">
        <div class="row">
            <div class="col">
                <div class="row vehicle">
                    <?php include __DIR__.'/vehicle/vehicle.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ( !empty($data['recomended']) ) include __DIR__.'/vehicle/recomended.php'; ?>
<?php include __DIR__.'/vehicle/dealership.php'; ?>
<?php if ( !empty($data['others']) ) include __DIR__.'/vehicle/other.php'; ?>

<?php // include __DIR__.'/forms/reserv.php'; ?>



<script>
var vehicleMap;
function initVehicleMap() {
    if (typeof ymaps !== 'undefined') {
        ymaps.ready(vehicleMapInit);
    } else {
        setTimeout(initVehicleMap, 100);
    }
}
initVehicleMap();

function vehicleMapInit () {
	
    vehicleMap = new ymaps.Map('vehicleMap', {

        center: [<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>, <?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>],
        zoom: 15
    }, {
        searchControlProvider: 'yandex#search'
    });
	vehicleMap.behaviors.disable('scrollZoom');
	vehicleMap.geoObjects.add(new ymaps.Placemark(
		[<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>, <?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>],
		{balloonContent: "<?= $data['_dealership']['NAME'];?>", iconCaption: "<?= $data['_dealership']['NAME'];?>"},
		{preset: "islands#darkBlueDotIconWithCaption"}
	))
}
</script>
