<?php 
    $Asset = \Bitrix\Main\Page\Asset::getInstance();
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/vehicle-card.css'));
    $Asset->addCss($app->Conf()['assetsUrl'].'/assets/css/filter.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/css/filter.css'));
    $Asset->addJs($app->Conf()['assetsUrl'].'/assets/js/filter.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/js/filter.js'));

    $mr_filter = $filter;
    unset($mr_filter['page'], $mr_filter['site'], $mr_filter['city'], $mr_filter['brand'], $mr_filter['model'], $mr_filter['filter']);
    $mr_url_flag = 'get';
    if ( 
        empty($mr_filter) ||
        ($filter['brand'] && count(explode(',',$filter['brand']))==1 && !$filter['model']) ||
        ( ($filter['brand'] && count(explode(',',$filter['brand']))==1) && ($filter['model'] && count(explode(',',$filter['model']))==1) ) ||
        (
            !$filter['brand'] &&
            !$filter['model'] &&
            count($mr_filter) == 1 &&
            in_array(
                array_keys($mr_filter)[0],
                ['price', 'volume', 'power', 'year']
            )
        )
    ) {
        $mr_url_flag = 'path';
    }
?>

<div class="bg-yalightbluegray top-container pb-5">
    <div class="container">
        <div class="row">
            <div class="col c-yablack">
                <h1 class="">
                    <span class="text-uppercase"><?= $data['meta']['meta']['h1'];?></span>
                    <span class="h3 d-block mb-0 mt-1 c-yadarkgray">в <a href="#" rel="nofollow" class="c-yadarkgray c-h-yadarkgray text-decoration-none top-menu-cities" role="not-cover"><?= $data['meta']['in_city'];?></a></span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container mt-4 filter bg-yawhite p-4 b-radius-yaradius-16">
        <div class="row mb-xl-3">
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $select = [
                        'name' => 'Тип',
                        'code' => 'mode',
                        'list' => 'mode',
                    ];
                    $filter['mode'] = $app->Conf()['Api']['mode'];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $select = [
                        'name' => 'Марка',
                        'code' => 'brand',
                        'list' => 'brands',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $select = [
                        'name' => 'Модель',
                        'code' => 'model',
                        'list' => 'models',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $range = $data['filter']['ranges']['price']; 
                    $range['code'] = 'price';
                    $range['name'] = 'Цена';
                    $range['unit'] = '₽';
                    $range['format'] = true;
                    $range['range'] = ( $range['max']-$range['min'] ) ?: 1;
                    $range['url_flag'] = $mr_url_flag;
                    if ( count($mr_filter) == 1 && !$mr_filter[$range['code']] ) $range['url_flag'] = 'get';
                ?>
                <?php include __DIR__.'/filter/multirange.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <a
                    href="#" rel="nofollow"
                    class="c-yalightblack c-h-yalightblack text-decoration-none d-block text-center b-radius-yaradius-16 bg-yayellow filter-button"
                    data-action="expandFilter"
                    role="not-cover"
                    >
                    <div class="row text-center h-100 align-items-center">
                        <div class="col-9 c-yalightblack">Все параметры</div>
                        <div class="col-3"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-params.svg" /></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mb-xl-3 collapse <?= (($filter['filter']!='expand')?'d-none':'d-flex');?>">
            <div class="col-md-6 col-xl mb-3 mb-xl-0 d-xl-none">
                <?php 
                    $select = [
                        'name' => 'Автосалон',
                        'code' => 'dealership',
                        'list' => 'dealerships',
                        'url_field' => 'url',
                        'select_fields' => [
                            'code', 'url'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $select = [
                        'name' => 'КПП',
                        'code' => 'transmission',
                        'list' => 'transmissions',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $select = [
                        'name' => 'Двигатель',
                        'code' => 'engine',
                        'list' => 'engines',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $select = [
                        'name' => 'Привод',
                        'code' => 'drive',
                        'list' => 'drives',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $select = [
                        'name' => 'Кузов',
                        'code' => 'body',
                        'list' => 'bodies',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0 d-none d-sm-block d-md-none d-xl-block">
                <a
                    href="<?= $app->Conf()['baseUrl'];?>/<?= (($app->getCityAlias($filter['city']))?$app->getCityAlias($filter['city']).'/':'');?>"
                    class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-15 bg-yabluegray bg-h-yagray filter-button"
                    >
                    <div class="row text-center h-100 align-items-center">
                        <div class="col-9 c-yablack">Сбросить все</div>
                        <div class="col-3 b-l-yadarkgray"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/cross.svg" /></div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0 d-xl-none">
                <?php 
                    $select = [
                        'name' => 'Цвет',
                        'code' => 'color',
                        'list' => 'colors',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
        </div>
        <div class="row mb-xl-3 collapse <?= (($filter['filter']!='expand')?'d-none':'d-flex');?>">
            <div class="col-xl mb-3 mb-xl-0 d-md-none d-xl-block">
                <?php 
                    $select = [
                        'name' => 'Цвет',
                        'code' => 'color',
                        'list' => 'colors',
                        'select_fields' => [
                            'code'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $range = $data['filter']['ranges']['volume']; 
                    $range['code'] = 'volume';
                    $range['name'] = 'Объем';
                    $range['unit'] = 'см<sup>3</sup>';
                    $range['format'] = true;
                    $range['range'] = ( $range['max']-$range['min'] ) ?: 1;
                    $range['url_flag'] = $mr_url_flag;
                    if ( count($mr_filter) == 1 && !$mr_filter[$range['code']] ) $range['url_flag'] = 'get';
                ?>
                <?php include __DIR__.'/filter/multirange.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $range = $data['filter']['ranges']['power']; 
                    $range['code'] = 'power';
                    $range['name'] = 'Мощность';
                    $range['unit'] = 'л.с.';
                    $range['format'] = true;
                    $range['range'] = ( $range['max']-$range['min'] ) ?: 1;
                    $range['url_flag'] = $mr_url_flag;
                    if ( count($mr_filter) == 1 && !$mr_filter[$range['code']] ) $range['url_flag'] = 'get';
                ?>
                <?php include __DIR__.'/filter/multirange.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0">
                <?php 
                    $range = $data['filter']['ranges']['year']; 
                    $range['code'] = 'year';
                    $range['name'] = 'Год выпуска';
                    $range['format'] = false;
                    $range['range'] = ( $range['max']-$range['min'] ) ?: 1;
                    $range['url_flag'] = $mr_url_flag;
                    if ( count($mr_filter) == 1 && !$mr_filter[$range['code']] ) $range['url_flag'] = 'get';
                ?>
                <?php include __DIR__.'/filter/multirange.php'; ?>
            </div>
            <div class="col-xl mb-3 mb-xl-0 d-none d-xl-block">
                <?php 
                    $select = [
                        'name' => 'Автосалон',
                        'code' => 'dealership',
                        'list' => 'dealerships',
                        'url_field' => 'url',
                        'select_fields' => [
                            'code', 'url'
                        ]
                    ];
                ?>
                <?php include __DIR__.'/filter/select.php'; ?>
            </div>
            <div class="col-md-6 col-xl mb-3 mb-xl-0 d-xl-none">
                <a
                    href="<?= $app->Conf()['baseUrl'];?>/<?= (($filter['city'])?$app->getCityAlias($filter['city']).'/':'');?>"
                    class="c-yalightblack c-h-yalightblack text-decoration-none d-block text-center b-radius-yaradius-15 bg-yagray filter-button"
                    >
                    <div class="row text-center">
                        <div class="col-9 c-yadarkgray">Сбросить все</div>
                        <div class="col-3 b-l-yadarkgray"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/cross.svg" /></div>
                    </div>
                </a>
            </div>
            
        </div>
        <?php include __DIR__.'/filter/brands.php'; ?>
        <?php include __DIR__.'/filter/tags.php'; ?>
    </div>
</div>

<?php // include __DIR__.'/filter/tags.php'; ?>
<?php // include __DIR__.'/filter/brands.php'; ?>
<?php include __DIR__.'/filter/sort.php'; ?>

