<div class="container my-2">
    <div class="row vehicle-list" itemscope itemtype="https://schema.org/ItemList">
        <meta itemprop="numberOfItems" content="<?= count($data['items'] ?? []);?>" />
        <?php if (!empty($data['items']) && is_array($data['items'])) { ?>
        <?php foreach ($data['items'] as $item) { ?>
        <div class="col-md-6 col-lg-4 col-xl-3 vehicle-list-item">
            <?php if ( $item['type'] == 'vehicle' ) { ?>
                <?php include __DIR__.'/vehicles/item_vehicle.php'; ?>
            <?php } elseif ( $item['type'] == 'random_cta' ) { ?>
                <?php include __DIR__.'/vehicles/item_cta.php'; ?>
            <?php } ?>
        </div>
        <?php } ?>
        <?php } else { ?>
        <div class="col-12 text-center py-5">
            <p class="h4 text-muted">Автомобили по выбранным параметрам не найдены</p>
        </div>
        <?php } ?>
    </div>
    <?php if ( $data['filter']['totalCount'] > (($_GET['perpage'])?(int)$_GET['perpage']-1:$app->Conf()['ItemsPerPage']) ) { ?>
        <?php $pagination = $app->makePagination( $data['filter']['totalCount'], $filter['page'], (($_GET['perpage'])?(int)$_GET['perpage']-1:$app->Conf()['ItemsPerPage']));?>
        <?php  if ( $pagination['total'] > $pagination['current'] ) { ?>
        <div class="row my-5 vehicles-more">
            <div class="col-md"></div>
            <div class="col-md-4 col-lg-3">
                <noindex>
                <a 
                    href="#"
                    class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicles-more-button"
                    data-current="<?= $pagination['current'];?>"
                    data-total="<?= $pagination['total'];?>"
                    data-url="<?= $app->makeApiUrl($filter, (($filter['vehicle'])?'vehicle':'vehicles'));?>"
                    data-app-url="<?= $app->Conf()['assetsUrl'];?>"
                    role="not-cover"
                    rel="nofollow"
                    ><noindex>Показать еще</noindex></a>
                </noindex>
            </div>
            <div class="col-md"></div>
        </div>
        <?php } ?>
        <div class="row vehicles-pagination my-5">
            <div class="col text-center">
                <?php foreach ( $pagination['items'] as $item ) { ?>
                    <?php if ( (int)$item['text'] ) { ?>
                        <span class="c-yablack me-3">
                            <a 
                                href="<?= $app->makeFilterUrl($filter, ['page'=>$item['page']], $item['page']);?>" 
                                class="text-decoration-none <?= (($item['current'])?'c-yablack c-h-yablack':'c-yayellow c-h-yayellow');?>"
                                data-page="<?= $item['page'];?>"
                                role="pagination"
                                ><?= $item['text'];?></a>
                        </span>
                    <?php } else { ?>
                        <span class="c-yablack me-3">
                            <?php if ($item['page']) { ?>
                            <a href="<?= $app->makeFilterUrl($filter, ['page'=>$item['page']], $item['page']);?>" class="c-yayellow c-h-yayellow text-decoration-none"><?= $item['text'];?></a>
                            <?php } else { ?>
                            <?= $item['text'];?>
                            <?php } ?>
                        </span>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php // YApp::sp( $pagination );?>
<?php // include __DIR__.'/forms/consult.php'; ?>
