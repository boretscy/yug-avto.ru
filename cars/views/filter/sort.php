<div class="container sorting my-3">
    <div class="row">
        <div class="col-6 col-sm col-md-3 col-xl-2 position-relative filter-dropcontainer my-2 d-flex align-items-center">
            <div class="icon-wrap bg-yalightbluegray b-radius-yaradius-8 me-2 d-flex justify-content-center align-items-center">
                <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-sort.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/images/svg/icon-sort.svg');?>" />
            </div>
            <div class="filter-dropdown d-inline-block c-yablack cursor-pointer">
                <span>
                    <?php if ($_GET['sort']=='price_up') { ?>
                    По возрастанию цены
                    <?php } elseif ($_GET['sort']=='price_down') { ?>
                    По убыванию цены
                    <?php } elseif ($_GET['sort']=='datetime_up') { ?>
                    По дате: новые
                    <?php } elseif ($_GET['sort']=='datetime_down') { ?>
                    По дате: старые
                    <?php } elseif ($_GET['sort']=='year_down') { ?>
                    По году: новее
                    <?php } elseif ($_GET['sort']=='year_up') { ?>
                    По году: старше
                    <?php } elseif ($_GET['sort']=='mileage_up') { ?>
                    По пробегу: меньше
                    <?php } elseif ($_GET['sort']=='mileage_down') { ?>
                    По пробегу: больше
                    <?php } else { ?>
                    Сортировка
                    <?php } ?>
                </span>
            </div>
            <div class="filter-droplist bg-yawhite w-100 position-absolute d-none b-radius-yaradius-6 b-yagray">
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'price_up']);?>" 
                    class="filter-droplist-item py-2 pt-3 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('price_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По возрастанию цены</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'price_down']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('price_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По убыванию цены</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'datetime_up']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('datetime_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По дате: новые</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'datetime_down']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('datetime_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По дате: старые</a>
                <?php if ( $app->Conf()['Api']['mode'] == 'used' ) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'year_down']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('year_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По году: новее</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'year_up']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('year_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По году: старше</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'mileage_up']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('mileage_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По пробегу: меньше</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'mileage_down']);?>" 
                    class="filter-droplist-item py-2 pb-3 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('mileage_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По пробегу: больше</a>
                <?php } ?>
            </div>
        </div>
        <?php if ( $data['Discount'] || ($data['InStock']&&$data['OnWay']) ) { ?>
        <div class="col-6 col-sm col-md-3 col-xl-2 position-relative filter-dropcontainer text-end text-md-start my-2 d-flex align-items-center">
            <div class="icon-wrap bg-yalightbluegray b-radius-yaradius-8 me-2 d-flex justify-content-center align-items-center">
                <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-perpage.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/images/svg/icon-perpage.svg');?>" />
            </div>
            <div class="filter-dropdown d-inline-block c-yablack cursor-pointer">
                <span>
                    <?php if ($_GET['perpage']=='16') { ?>
                    Показывать по 16
                    <?php } elseif ($_GET['perpage']=='24') { ?>
                    Показывать по 24
                    <?php } elseif ($_GET['perpage']=='32') { ?>
                    Показывать по 32
                    <?php } elseif ($_GET['perpage']=='48') { ?>
                    Показывать по 48
                    <?php } elseif ($_GET['perpage']=='64') { ?>
                    Показывать по 64
                    <?php } else { ?>
                    Показывать по 32
                    <?php } ?>
                </span>
            </div>
            <div class="filter-droplist bg-yawhite w-100 position-absolute d-none b-radius-yaradius-6 b-yagray">
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'16']);?>" 
                    class="filter-droplist-item py-2 pt-3 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('16', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 16</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'24']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('24', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 24</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'32']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('32', explode(',', $_GET['perpage']))||!$_GET['perpage'])?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 32</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'48']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('48', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 48</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'64']);?>" 
                    class="filter-droplist-item py-2 pb-3 px-3  d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('64', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 64</a>
            </div>
        </div>
        <?php } ?>

        <?php if ( $data['Discount'] || ($data['InStock']&&$data['OnWay']) ) { ?>
        <div class="col-md-6 col-xl-8 text-end d-flex justify-content-between justify-content-md-end align-items-center my-2">
            

            <?php if (
                $data['Discount'] ||
                (
                    $data['InStock'] && $data['OnWay']
                )
                ) { ?> 
            <span class="b-radius-yaradius-7 me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <a href="<?= $app->makeFilterUrl($filter, ['tag'=>null]);?>">
                <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-<?= (($filter['tag'])?'un':'');?>check.svg" />
                </a>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>null]);?>" class="c-yablack c-h-yadarkgray text-decoration-none">Всe</a></span>
            <?php } ?>
            
            <?php if ( $data['Discount'] ) { ?>
            <span class="b-radius-yaradius-7 ms-3 me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <a href="<?= $app->makeFilterUrl($filter, ['tag'=>'discount']);?>">
                <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-<?= ((!in_array('discount',explode(',',$filter['tag'])))?'un':'');?>check.svg" />
                </a>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>'discount']);?>" class="c-yablack c-h-yadarkgray text-decoration-none">Выгода</a></span>
            <?php } ?>

            <?php if ( $data['InStock'] && $data['OnWay']) { ?>
            <span class="b-radius-yaradius-7 ms-3 me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <a href="<?= $app->makeFilterUrl($filter, ['tag'=>'instock']);?>">
                <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-<?= ((!in_array('instock',explode(',',$filter['tag'])))?'un':'');?>check.svg" />
                </a>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>'instock']);?>" class="c-yablack c-h-yadarkgray text-decoration-none">В наличии</a></span>
            <span class="b-radius-yaradius-7 ms-3 me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <a href="<?= $app->makeFilterUrl($filter, ['tag'=>'onway']);?>">
                <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-<?= ((!in_array('onway',explode(',',$filter['tag'])))?'un':'');?>check.svg" />
                </a>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>'onway']);?>" class="c-yablack c-h-yadarkgray text-decoration-none">В пути</a></span>
            <?php } ?>


        </div>
        <?php } else { ?>
        <div class="col-md-5 col-xl-8 d-none d-md-block"></div>
        <div class="col-6 col-sm col-md-3 col-xl-2 position-relative filter-dropcontainer text-end text-md-start my-2 d-flex align-items-center">
            <div class="icon-wrap bg-yalightbluegray b-radius-yaradius-8 me-2 d-flex justify-content-center align-items-center">
                <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-perpage.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['assetsUrl'].'/assets/images/svg/icon-perpage.svg');?>" />
            </div>
            <div class="filter-dropdown d-inline-block c-yablack cursor-pointer">
                <span>
                    <?php if ($_GET['perpage']=='16') { ?>
                    Показывать по 16
                    <?php } elseif ($_GET['perpage']=='24') { ?>
                    Показывать по 24
                    <?php } elseif ($_GET['perpage']=='32') { ?>
                    Показывать по 32
                    <?php } elseif ($_GET['perpage']=='48') { ?>
                    Показывать по 48
                    <?php } elseif ($_GET['perpage']=='64') { ?>
                    Показывать по 64
                    <?php } else { ?>
                    Показывать по 32
                    <?php } ?>
                </span>
            </div>
            <div class="filter-droplist bg-yawhite w-100 position-absolute d-none b-radius-yaradius-6 b-yagray">
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'16']);?>" 
                    class="filter-droplist-item py-2 pt-3 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('16', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 16</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'24']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('24', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 24</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'32']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('32', explode(',', $_GET['perpage']))||!$_GET['perpage'])?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 32</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'48']);?>" 
                    class="filter-droplist-item py-2 px-3 d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('48', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 48</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'64']);?>" 
                    class="filter-droplist-item py-2 pb-3 px-3  d-block c-yablack c-h-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('64', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 64</a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>