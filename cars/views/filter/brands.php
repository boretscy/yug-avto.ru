<div class="container brands d-none d-lg-block">
    <div class="row">
        <div class="col px-4">
            <div class="brands-list my-2">
                <?php 
                    $hasSingleModel = !empty($filter['model']) && count(explode(',', $filter['model'])) == 1;
                    $hasEquipments = !empty($data['filter']['dropLists']['equipments']);

                    if ( $hasSingleModel && $hasEquipments ) {
                        $brands_items = $data['filter']['dropLists']['equipments'];
                        $f_key = 'equipment';
                        $entity_title = 'комплектации';
                    } elseif ( !empty($data['filter']['dropLists']['models']) ) {
                        $brands_items = $data['filter']['dropLists']['models'];
                        $f_key = 'model';
                        $entity_title = 'модели';
                    } else {
                        $brands_items = $data['brands'];
                        $f_key = 'brand';
                        $entity_title = 'марки';
                    }
                ?>
                <?php
                usort($brands_items, function($a, $b) use ($f_key) {
                    if ($f_key !== 'brand') {
                        $cntA = $a['vehicles'] ?? ($a['count'] ?? 0);
                        $cntB = $b['vehicles'] ?? ($b['count'] ?? 0);
                        if ($cntA != $cntB) return ($cntA > $cntB) ? -1 : 1;
                    }
                    $nameA = trim($a['name'] ?? '');
                    $nameB = trim($b['name'] ?? '');
                    $isRusA = preg_match('/^[А-Яа-яЁё]/u', $nameA);
                    $isRusB = preg_match('/^[А-Яа-яЁё]/u', $nameB);
                    if ($isRusA && !$isRusB) return -1;
                    if (!$isRusA && $isRusB) return 1;
                    return mb_strtolower($nameA, 'UTF-8') <=> mb_strtolower($nameB, 'UTF-8');
                });
                ?>
                <?php foreach ( $brands_items as $k => $item ) { 
                    $itemCount = $item['vehicles'] ?? ($item['count'] ?? 0);
                    $isActive = false;
                    if ( $f_key === 'equipment' ) {
                        $isActive = (!empty($filter['equipment']) && in_array($item['code'], explode(',', $filter['equipment'])));
                        $targetFilter = $filter;
                        if ( $isActive ) {
                            unset($targetFilter['equipment']);
                            $linkUrl = $app->makeFilterUrl($targetFilter);
                        } else {
                            $targetFilter['equipment'] = $item['code'];
                            $linkUrl = $app->makeFilterUrl($targetFilter);
                        }
                    } elseif ( $f_key === 'model' ) {
                        $itemBrand = (!empty($item['brand']['code'])) ? $item['brand']['code'] : ((!empty($item['brand_code'])) ? $item['brand_code'] : $filter['brand']);
                        $urlParams = (!empty($itemBrand)) ? ['brand' => $itemBrand, 'model' => $item['code']] : ['model' => $item['code']];
                        $linkUrl = $app->makeFilterUrl($filter, $urlParams);
                    } else {
                        $urlParams = ['brand' => $item['code']];
                        $linkUrl = $app->makeFilterUrl($filter, $urlParams);
                    }
                ?>
                <div class="brands-list-item <?= (($k>13&&count($brands_items)>15)?'hidden d-none':'');?>">
                    <a 
                        href="<?= $linkUrl;?>"
                        class="c-yablack c-h-yadarkgray text-decoration-none py-1 d-block text-uppercase <?= ($isActive ? 'fw-bold c-yayellow' : '');?>"
                        >
                        <div class="row">
                            <<?= ((in_array($item['code'], $app->Conf()['Filter']['BrandsList']['divtoh2'])||in_array($filter['brand'], $app->Conf()['Filter']['BrandsList']['divtoh2']))?'h2':'div');?> class="col-8 d-flex justify-content-start align-items-start <?= ((in_array($item['code'], $app->Conf()['Filter']['BrandsList']['divtoh2'])||in_array($filter['brand'], $app->Conf()['Filter']['BrandsList']['divtoh2']))?'h2-to-div':'');?>"><?= $item['name'];?></<?= ((in_array($item['code'], $app->Conf()['Filter']['BrandsList']['divtoh2'])||in_array($filter['brand'], $app->Conf()['Filter']['BrandsList']['divtoh2']))?'h2':'div');?>>
                            <div class="col d-flex justify-content-end align-items-start"><span class="d-block text-center b-radius-yaradius-3 bg-yalightgray bg-h-yayellow px-1 brands-list-item-count"><?= $itemCount;?></span></div>
                        </div>
                    </a>
                </div>
                <?php } ?>
                <?php if ( count($brands_items)>15 ) { ?>
                <div class="brands-list-item">
                    <a rel="nofollow" class="c-yablack c-h-yadarkgray text-decoration-noned-block py-1 d-block" href="#brands" data-remodal-target="brands" role="not-cover">
                        <div class="row">
                            <div class="col-8">
                                <span class="me-2">Все <?= $entity_title;?></span>
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
				$itemCount = $item['vehicles'] ?? ($item['count'] ?? 0);
				if ( $f_key === 'equipment' ) {
					$isActive = (!empty($filter['equipment']) && in_array($item['code'], explode(',', $filter['equipment'])));
					$targetFilter = $filter;
					if ( $isActive ) {
						unset($targetFilter['equipment']);
						$modalLink = $app->makeFilterUrl($targetFilter);
					} else {
						$targetFilter['equipment'] = $item['code'];
						$modalLink = $app->makeFilterUrl($targetFilter);
					}
				} elseif ( $f_key === 'model' ) {
					$itemBrand = (!empty($item['brand']['code'])) ? $item['brand']['code'] : ((!empty($item['brand_code'])) ? $item['brand_code'] : $filter['brand']);
					$urlParams = (!empty($itemBrand)) ? ['brand' => $itemBrand, 'model' => $item['code']] : ['model' => $item['code']];
					$modalLink = !empty($item['path']) ? $item['path'].'/' : $app->makeFilterUrl($filter, $urlParams);
				} else {
					$urlParams = ['brand' => $item['code']];
					$modalLink = !empty($item['path']) ? $item['path'].'/' : $app->makeFilterUrl($filter, $urlParams);
				}
			?>
			<div class="col-3 py-1 brands-list-item">
				<a href="<?= $modalLink;?>" class="c-yablack c-h-yadarkgray text-uppercase d-flex justify-content-between align-items-center text-decoration-none ">
					<span><?= $item['name'];?></span>
					<span class="brands-list-item-count me-3"><?= $itemCount;?></span>
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