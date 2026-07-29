<div class="bg-yalightbluegray vehicle-card">
    <div class="vehicle-card-images position-relative">
        <a href="<?= $app->Conf()['assetsUrl'];?>/<?= $item['entity'];?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" role="vehicle-image">
			<?php if ( !empty($item['images']) ) { ?>
				<?php foreach ( $item['images'] as $k => $i ) { ?>
					<div 
						class="vehicle-card-images-item-container" 
						style="<?= (($k!=0)?'display:none;':'');?>" 
						data-index="<?= $k;?>">
						<img 
							src="<?= (($i['preview'])?:$i['preview_large']);?>"
							class="vehicle-card-images-item-container-image"
							alt="<?= $item['brand']['name'];?> <?= $item['model']['name'];?>"
							loading="<?= ($k==0)?'eager':'lazy';?>"
						>
					</div>
				<?php } ?>
			<?php } else { ?>
				<img src="https://<?= YApp::GO_API_DOMAIN ?>/upload/Cis/bodies/<?= $item['body']['code'];?>_sm.webp" class="w-100" />
			<?php } ?>
		</a>
        <div class="m-3 vehicle-card-images-row position-absolute d-flex justify-content-between">
            <?php if ( !empty($item['images']) ) { ?>
                <?php foreach ( $item['images'] as $k => $i ) { ?>
                <span class="vehicle-card-images-row-item <?= (($k==0)?'active':'');?>" data-index="<?=$k;?>"></span>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="vehicle-card-content p-3 px-2">
        <a 
            href="<?= $app->Conf()['baseUrl'];?>/<?= (($filter['city']&&count(explode(',',$filter['city']))==1)?$app->getCityAlias($filter['city']).'/':'');?><?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" 
            class="c-yalightblack c-h-yalightblack text-decoration-none h5 line-height-one d-block fw-bold vehicle-card-content-title"
            ><?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment']&&$item['entity']=='new')?$item['equipment']:'');?></a>
        <div class="vehicle-card-price mt-2 d-flex justify-content-between">
            <span class="text-plus c-yalightblack fw-bold"><?= number_format($item['min_price'], 0, '.', ' ');?> ₽</span>
            <?php if ( $item['min_price'] < $item['price'] ) { ?>
            <span class="text-plus c-yadarkgray text-decoration-line-through"><?= number_format($item['price'], 0, '.', ' ');?> ₽</span>
            <?php } ?>
        </div>
        <hr class="opacity-100" />
        <div class="d-flex justify-content-between align-items-center text-plus" data-index="0">
            <span>Технические параметры</span>
        </div>
        <ul class="list-unstyled compare-body-items c-yadarkgray" data-index="0">
            <li class="py-2"><?= $item['body']['name'];?>&nbsp;</li>
            <li class="py-2"><?= $item['general'][2]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][7]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['power'];?>&nbsp;</li>
            <li class="py-2"><?= $item['engine']['name'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][2]['value'];?> - <?= $item['specifications'][4]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][0]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['_general'][0];?>&nbsp;</li>
        </ul>
        <hr class="opacity-100" />
        <div class="justify-content-between align-items-center text-plus" data-index="1">
            <span>Размеры</span>
        </div>
        <ul class="list-unstyled compare-body-items c-yadarkgray" data-index="1">
            <li class="py-2"><?= $item['specifications'][8]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][9]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][10]['value'];?>&nbsp;</li>
        </ul>
        <hr class="opacity-100" />
    </div>
</div>
<div class="vehicle-card-footer vehicle-card-footer-compare w-100 d-flex justify-content-between">
	<div class="vehicle-card-footer-left bg-yawhite d-flex">
		<div class="vehicle-card-footer-left-content bg-yalightbluegray w-100">
			<a
				href="<?= $app->Conf()['baseUrl'];?>/<?= (($filter['city']&&count(explode(',',$filter['city']))==1)?$app->getCityAlias($filter['city']).'/':'');?><?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/"
				class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow vehicle-card-button fw-bold"
			>Подробнее</a>
		</div>
	</div>
	<div class="vehicle-card-footer-right bg-yalightbluegray d-flex">
		<div class="vehicle-card-footer-right-content bg-yawhite w-100 d-flex justify-content-end align-items-end">
			<a 
				href="?action=delete&vehicle=<?= $item['id'];?>" 
				role="not-cover"
				class="b-radius-yaradius-12 bg-yalightbluegray vehicle-card-discount-item position-relative">
				<img class="position-absolute" src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-trash-full.svg" />
				<img class="position-absolute" src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-trash-full-a.svg" />
			</a>
		</div>
	</div>
</div>