<?php 
$carImgText = ($item['brand']['name'] ?? '') . ' ' . ($item['model']['name'] ?? '');
?>
<div class="bg-yalightbluegray vehicle-card" itemscope itemtype="https://schema.org/Product">
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
							alt="<?= htmlspecialchars(YApp::getCleanAltText($carImgText . (($k > 0) ? ' - ракурс ' . ($k + 1) : '')));?>"
							title="<?= htmlspecialchars(YApp::getCleanAltText($carImgText . (($k > 0) ? ' - ракурс ' . ($k + 1) : '')));?>"
							loading="<?= ($k==0)?'eager':'lazy';?>"
						>
					</div>
				<?php } ?>
			<?php } else { ?>
				<img src="https://<?= YApp::GO_API_DOMAIN ?>/upload/Cis/bodies/<?= $item['body']['code'];?>_sm.webp" class="w-100" alt="<?= htmlspecialchars(YApp::getCleanAltText($carImgText));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($carImgText));?>" />
			<?php } ?>
		</a>
		<div class="m-3 vehicle-card-images-row position-absolute d-flex justify-content-between">
			<?php foreach ( $item['images'] as $k => $i ) { ?>
			<span class="vehicle-card-images-row-item <?= (($k==0)?'active':'');?>" data-index="<?=$k;?>"></span>
			<?php } ?>
		</div>
	</div>
    <div class="vehicle-card-content py-3 px-2">
		<a 
			href="<?= $app->Conf()['assetsUrl'];?>/<?= $item['entity'];?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" 
			class="c-yalightblack c-h-yalightblack text-decoration-none h5 line-height-one d-block fw-bold vehicle-card-content-title" itemprop="name"
            ><div><?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment']&&$item['entity']=='new')?$item['equipment']:'');?></div></a>
        <div class="vehicle-card-futures">
            <?php foreach ( $item['_tags'] as $tag ) { ?>
                <a href="#" rel="nofollow" onclick="return false" class="hint--top-right hint--medium" aria-label="<?= $tag['name'];?>" role="not-cover">
                    <img src="<?= $tag['icon'];?>?2" />
                </a>
            <?php } ?>
        </div>
        <div class="vehicle-card-specification my-3 c-yablack text-minus" itemprop="description">
            <?php foreach (array_chunk($item['_general'], 3) as $s_row) { ?>
            <div>
                <?php foreach ( $s_row as $k => $i ) { ?>
                    <?php if ( $i ) { ?><span class="vehicle-card-specification-item me-1"><?= $i;?>
                        <?php if ( $k < count($s_row)-1 ) { ?>
                        <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/card_bullet.svg?3" class="ms-1" title="<?= $i;?>" />
                        <?php } ?>
                    </span>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
		<div class="vehicle-card-discount-status d-flex flex-column justify-content-around align-items-start">
			<?php if ( $item['price']-$item['min_price'] > 0 ) { ?>
			<div class="vehicle-card-discount b-radius-yaradius-8 b-yayellow bg-yawhite pe-2 d-inline-block fw-bold">
				<div class="d-flex justify-content-between h-100">
					<span class="c-yawhite bg-yayellow b-radius-yaradius-8 text-uppercase me-2 fw-light h-100 px-1 d-flex justify-content-center align-items-center">Выгода</span>
					<span class="d-flex justify-content-center align-items-center">до <?= number_format($item['price']-$item['min_price'], 0, '.', ' ');?> ₽</span>
				</div>
			</div>
			<?php } ?>
			<div class="vehicle-card-status text-uppercase my-2 <?= (($item['status']['id']==1)?'c-yayellow':'c-yadarkgray');?> fw-bold"><?= $item['status']['name'];?></div>
		</div>
		<div class="vehicle-card-price my-2 d-flex justify-content-between align-items-end">
			<span class="price c-yablack fw-bold"><?= number_format($item['min_price'], 0, '.', ' ');?> ₽</span>
			<?php if ( $item['min_price'] < $item['price'] ) { ?>
			<span class="fw-light c-yadarkgray text-decoration-line-through mb-1"><?= number_format($item['price'], 0, '.', ' ');?> ₽</span>
			<?php } ?>
		</div>
	</div>
</div>
<div class="vehicle-card-footer d-flex justify-content-between mb-3">
	<div class="vehicle-card-footer-left bg-yawhite d-flex">
		<div class="vehicle-card-footer-left-content bg-yalightbluegray w-100">
			<a
				href="<?= $app->Conf()['assetsUrl'];?>/<?= $item['entity'];?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/"
				class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow vehicle-card-button fw-bold"
				data-vehicle-name="<?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment'])?:'');?>"
				data-vehicle-id="<?= $item['id'];?>"
				data-action="set-vehicle"
				role="not-cover"
				<?php if ( !$item['offer_link'] ) { ?>
				data-remodal-target="offer-modal"
				<?php } ?>
			>Получить предложение</a>
		</div>
	</div>
	<div class="vehicle-card-footer-right bg-yalightbluegray d-flex">
		<div class="vehicle-card-footer-right-content bg-yawhite w-100 d-flex justify-content-end align-items-end">
			<a 
				href="#" 
				role="not-cover"
				data-action="toggle-fav-com"
				data-target="CIS_FAVORITES" 
				data-vehicle="<?= $item['id'];?>"
				class="b-radius-yaradius-12 bg-yalightbluegray me-2 vehicle-card-discount-item <?= ((in_array($item['id'], $data['FAVORITES']))?'active':'');?> position-relative">
				<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-favorites.svg';?>" />
				<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-favorites-a.svg';?>" />
			</a>
			<a 
				href="#" 
				role="not-cover"
				data-action="toggle-fav-com"
				data-target="CIS_COMPARE" 
				data-vehicle="<?= $item['id'];?>"
				class="b-radius-yaradius-12 bg-yalightbluegray vehicle-card-discount-item <?= ((in_array($item['id'], $data['COMPARE']))?'active':'');?> position-relative">
				<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-compare.svg';?>" />
				<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-compare-a.svg';?>" />
			</a>
		</div>
	</div>
</div>