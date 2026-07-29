<div class="container tags mt-2">
    <div class="row">
        <div class="col tags-list px-4">
            <?php if ( $filter['brand'] ) {
                foreach ( explode(',', $filter['brand']) as $item) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['brand'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['brands'], $item);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['model'] ) {
                foreach ( explode(',', $filter['model']) as $item) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['model'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['models'], $item);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['price'] ) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['price'=>false]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= number_format((int)explode(',',$filter['price'])[0], 0, '.', ' ');?> ₽ - <?= number_format((int)explode(',',$filter['price'])[1], 0, '.', ' ');?> ₽
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
            <?php } ?>
            <?php if ( $filter['body'] ) {
                foreach ( explode(',', $filter['body']) as $item) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['body'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['bodies'], $item);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['transmission'] ) {
                foreach ( explode(',', $filter['transmission']) as $item) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['transmission'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['transmissions'], $item);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['engine'] ) {
                foreach ( explode(',', $filter['engine']) as $item) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['engine'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['engines'], $item);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['drive'] ) {
                foreach ( explode(',', $filter['drive']) as $item) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['drive'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['drives'], $item);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['color'] ) {
                foreach ( explode(',', $filter['color']) as $item) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['color'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['colors'], $item);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['dealership'] ) {
                foreach ( explode(',', $filter['dealership']) as $item) {
                ?>
                <a href="<?= $app->makeFilterUrl($filter, ['dealership'=>$item]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= $app->getTagName($data['filter']['dropLists']['dealerships'], $item, ['select_fields'=>['code', 'url']]);?>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
                <?php }
            } ?>
            <?php if ( $filter['volume'] ) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['volume'=>false]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= number_format((int)explode(',',$filter['volume'])[0], 0, '.', ' ');?> - <?= number_format((int)explode(',',$filter['volume'])[1], 0, '.', ' ');?> см<sup>3</sup>
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
            <?php } ?>
            <?php if ( $filter['power'] ) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['power'=>false]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= number_format((int)explode(',',$filter['power'])[0], 0, '.', ' ');?> - <?= number_format((int)explode(',',$filter['power'])[1], 0, '.', ' ');?> л.с.
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
            <?php } ?>
            <?php if ( $filter['year'] ) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['year'=>false]);?>" class="px-2 py-1 bg-yabluegray c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    <?= explode(',',$filter['year'])[0]?> - <?= explode(',',$filter['year'])[1];?> г.в.
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" class="ms-2" />
                </a>
            <?php } ?>
            <?php if (
                $filter['brand'] || $filter['model'] || $filter['price'] || $filter['body'] || $filter['transmission'] || $filter['engine'] || $filter['drive'] || $filter['color'] || $filter['dealership'] || $filter['volume'] || $filter['power'] || $filter['year']
            ) { ?>
                <a href="<?= $app->makeFilterUrl($filter, ['clear'=>true]);?>" class="px-2 py-1 bg-yawhite c-yablack c-h-yablack text-decoration-none b-radius-yaradius-7 me-2 tags-list-item mb-2 d-inline-block">
                    Сбросить
                    <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/tag-cross.svg" class="ms-2" />
                </a>
            <?php } ?>
        </div>
    </div>
</div>