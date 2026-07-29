<div class="container brands d-none d-lg-block">
    <div class="row">
        <div class="col px-4">
            <div class="brands-list my-2">
                <?php $brands_items = ( !empty($data['filter']['dropLists']['models']) ) ? $data['filter']['dropLists']['models'] : $data['brands']; ?>
                <?php $f_key = ( !empty($data['filter']['dropLists']['models']) ) ? 'model' : 'brand'; ?>
                <?php array_multisort(array_column($brands_items, 'vehicles'), SORT_DESC, SORT_NUMERIC, $brands_items); ?>
                <?php
                usort($brands_items, function($a, $b) {
                    $nameA = $a['name'] ?? '';
                    $nameB = $b['name'] ?? '';
                    $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
                    $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
                    if ($isRusA && !$isRusB) return -1;
                    if (!$isRusA && $isRusB) return 1;
                    return strcmp(mb_strtolower($nameA, 'UTF-8'), mb_strtolower($nameB, 'UTF-8'));
                });
                ?>
                <?php foreach ( $brands_items as $k => $item ) { 
                    $itemBrand = (!empty($item['brand']['code'])) ? $item['brand']['code'] : ((!empty($item['brand_code'])) ? $item['brand_code'] : $filter['brand']);
                    $urlParams = ($f_key === 'model' && !empty($itemBrand)) ? ['brand' => $itemBrand, 'model' => $item['code']] : [$f_key => $item['code']];
                ?>
                <div class="brands-list-item <?= (($k>13&&count($brands_items)>15)?'hidden d-none':'');?>">
                    <a 
                        href="<?= $app->makeFilterUrl($filter, $urlParams);?>"
                        class="c-yablack c-h-yadarkgray text-decoration-none py-1 d-block text-uppercase"
                        >
                        <div class="row">
                            <<?= ((in_array($item['code'], $app->Conf()['Filter']['BrandsList']['divtoh2'])||in_array($filter['brand'], $app->Conf()['Filter']['BrandsList']['divtoh2']))?'h2':'div');?> class="col-8 d-flex justify-content-start align-items-start <?= ((in_array($item['code'], $app->Conf()['Filter']['BrandsList']['divtoh2'])||in_array($filter['brand'], $app->Conf()['Filter']['BrandsList']['divtoh2']))?'h2-to-div':'');?>"><?= $item['name'];?></<?= ((in_array($item['code'], $app->Conf()['Filter']['BrandsList']['divtoh2'])||in_array($filter['brand'], $app->Conf()['Filter']['BrandsList']['divtoh2']))?'h2':'div');?>>
                            <div class="col d-flex justify-content-end align-items-start"><span class="d-block text-center b-radius-yaradius-3 bg-yalightgray bg-h-yayellow px-1 brands-list-item-count"><?= $item['vehicles'];?></span></div>
                        </div>
                    </a>
                </div>
                <?php } ?>
                <?php if ( count($brands_items)>15 ) { ?>
                <div class="brands-list-item">
                    <a rel="nofollow" class="c-yablack c-h-yadarkgray text-decoration-noned-block py-1 d-block" href="#brands" data-remodal-target="brands" role="not-cover">
                        <div class="row">
                            <div class="col-8">
                                <span class="me-2">Все <?= ((!empty($data['filter']['dropLists']['models']))?'модели':'марки');?></span>
                                <span class="me-2 d-none">Скрыть</span>
                            </div>
                            <div class="col text-end"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/drop-corner.svg" class="" /></div>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

	<div class="remodal remodal-big text-start b-radius-yaradius-16 p-5" data-remodal-id="brands">
		<button data-remodal-action="close" class="remodal-close"></button>
		<div class="row mb-3">
			<div class="col">
				<div class="row brands-on-main-title">
					<div class="col-12">
						<div class="h3 block-title"><?= ($app->Conf()['Api']['mode'] === 'used') ? 'Автомобили с пробегом в наличии' : 'Новые автомобили в наличии'; ?></div>
						<a href="#" role="top-menu-cities" class="c-yadarkgray c-h-yablack">в <?= $data['meta']['in_city'];?></a>
					</div>
				</div>
			</div>
		</div>
		<div class="row brands-list-items text-minus mb-5">
			<?php foreach ( $brands_items as $k => $item ) { 
				$itemBrand = (!empty($item['brand']['code'])) ? $item['brand']['code'] : ((!empty($item['brand_code'])) ? $item['brand_code'] : $filter['brand']);
				$urlParams = ($f_key === 'model' && !empty($itemBrand)) ? ['brand' => $itemBrand, 'model' => $item['code']] : [$f_key => $item['code']];
			?>
			<div class="col-3 py-1 brands-list-item">
				<a href="<?= !empty($item['path']) ? $item['path'].'/' : $app->makeFilterUrl($filter, $urlParams);?>" class="c-yablack c-h-yadarkgray text-uppercase d-flex justify-content-between align-items-center text-decoration-none ">
					<span><?= $item['name'];?></span>
					<span class="brands-list-item-count me-3"><?= $item['vehicles'];?></span>
				</a>
			</div>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col">
				<div class="row brands-on-main-title">
					<div class="col-12 d-flex justify-content-end align-items-center text-minus">
						<a href="<?= $app->Conf()['baseUrl']; ?>/" class="c-yadarkgray c-h-yayellow text-decoration-none">
							Все марки
							<img class="ms-3" src="/local/templates/yugavto.theme.2025/components/bitrix/news.list/main.filter/images/svg/icon-main-filter-corner-right-s.svg" />
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>