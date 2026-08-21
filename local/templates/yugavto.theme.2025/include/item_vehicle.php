<?php
YApp::sp( $item, true );
$item['_general'] = (!empty($item['_general']) && is_array($item['_general'])) ? $item['_general'] : ((!empty($item['general']) && is_array($item['general'])) ? $item['general'] : []);
$item['_tags'] = (!empty($item['_tags']) && is_array($item['_tags'])) ? $item['_tags'] : [];
$item['id'] = $item['ext_id'] ?? $item['id'] ?? null;
$item['offer_link'] = true;
$data['FAVORITES'] = (!empty($data['FAVORITES']) && is_array($data['FAVORITES'])) ? $data['FAVORITES'] : [];
$data['COMPARE'] = (!empty($data['COMPARE']) && is_array($data['COMPARE'])) ? $data['COMPARE'] : [];
?>
<?php
$carBrand = $item['brand']['name'] ?? '';
$carModel = $item['model']['name'] ?? '';
$carYear = $item['year'] ?? '';
$carMileage = (!empty($item['mileage'])) ? number_format($item['mileage'], 0, '.', ' ') . ' км' : '';
$carEquipment = (($vehicleMode == 'new' && !empty($item['equipment'])) ? $item['equipment'] : '');
$carType = (($vehicleMode == 'used') ? 'с пробегом' : 'новый');

$carImgText = $carBrand . ' ' . $carModel;
?>
<div class="swiper-slide h-auto">
	<div class="vehicle-card bg-yalightbluegray text-start w-100">
		<div class="vehicle-card-images position-relative">
			<a href="/cars/<?= $vehicleMode;?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" role="vehicle-image">
				<?php 
					$validImages = array_values(array_filter($item['images'] ?? [], function($img) { 
						return $img['preview_small'] ?: $img['preview'] ?: $img['preview_large']; 
					}));
				?>
				<?php if ( $validImages ) { ?>
					<?php foreach ( $validImages as $k => $i ) { ?>
						<div 
							class="vehicle-card-images-item-container" 
							style="<?= (($k!=0)?'display:none;':'');?>" 
							data-index="<?= $k;?>">
							<img 
								src="<?= ($i['preview_small'] ?: $i['preview'] ?: $i['preview_large']);?>"
								class="vehicle-card-images-item-container-image"
								alt="<?= htmlspecialchars(YApp::getCleanAltText($carImgText . (($k > 0) ? ' - ракурс ' . ($k + 1) : '')));?>"
								title="<?= htmlspecialchars(YApp::getCleanAltText($carImgText . (($k > 0) ? ' - ракурс ' . ($k + 1) : '')));?>"
								loading="<?= ($k==0)?'eager':'lazy';?>"
								<?= ($k==0)?'fetchpriority="high"':'';?>
								decoding="async"
							>
						</div>
					<?php } ?>
				<?php } else if ($item['body']['code']) { ?>
					<img src="https://<?= YApp::GO_API_DOMAIN ?>/upload/Cis/bodies/<?= $item['body']['code'];?>_sm.webp" class="w-100" alt="<?= htmlspecialchars(YApp::getCleanAltText($carImgText));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($carImgText));?>" />
				<?php } ?>
			</a>
			<?php if ($validImages) { ?>
			<div class="m-3 vehicle-card-images-row position-absolute d-flex justify-content-between">
				<?php foreach ( $validImages as $k => $i ) { ?>
				<span class="vehicle-card-images-row-item <?= (($k==0)?'active':'');?>" data-index="<?=$k;?>"></span>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="vehicle-card-content py-3 px-2">
			<a 
				href="/cars/<?= $vehicleMode;?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" 
				class="c-yablack c-h-yablack text-decoration-none line-height-one d-block vehicle-card-content-title fw-bold"
				>
				<?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment'])?:'');?>
			</a>
			<div class="vehicle-card-futures">
				<?php foreach ( $item['_tags'] as $tag ) { ?>
					<a href="#" onclick="return false" class="hint--top-right" aria-label="<?= $tag['name'];?>" role="not-cover">
						<img src="<?= $tag['icon'];?>?2" />
					</a>
				<?php } ?>
			</div>
			<?php if ( !empty($item['_general']) && is_array($item['_general']) ) { ?>
			<div class="vehicle-card-specification my-3 c-yablack text-minus">
				<?php foreach (array_chunk($item['_general'], 3) as $s_row) { ?>
				<div>
					<?php foreach ( $s_row as $i ) { ?>
						<?php if ( $i ) { ?><span class="vehicle-card-specification-item pe-2 me-2"><?= $i;?></span><?php } ?>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
			<div class="vehicle-card-discount b-radius-yaradius-8 b-yayellow bg-yawhite pe-2 d-inline-block fw-bold">
				<div class="d-flex justify-content-between h-100">
					<span class="c-yawhite bg-yayellow b-radius-yaradius-8 text-uppercase me-2 fw-light h-100 px-1 d-flex justify-content-center align-items-center">Выгода</span>
					<span class="d-flex justify-content-center align-items-center">до <?= number_format($item['price']-$item['min_price'], 0, '.', ' ');?> ₽</span>
				</div>
			</div>
			<div class="vehicle-card-status text-uppercase my-2 c-yayellow fw-bold"><?= $item['status']['name'];?></div>
			<div class="vehicle-card-price my-2 d-flex justify-content-between align-items-end">
				<span class="price c-yablack fw-bold"><?= number_format($item['min_price'], 0, '.', ' ');?> ₽</span>
				<?php if ( $item['min_price'] < $item['price'] ) { ?>
				<span class="fw-light c-yadarkgray text-decoration-line-through mb-1"><?= number_format($item['price'], 0, '.', ' ');?> ₽</span>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="vehicle-card-footer d-flex justify-content-between">
		<div class="vehicle-card-footer-left bg-yawhite d-flex">
			<div class="vehicle-card-footer-left-content bg-yalightbluegray w-100">
				<a
					href="/cars/<?= $vehicleMode;?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/"
					class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow vehicle-card-button fw-bold"
					data-vehicle-name="<?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment'])?:'');?>"
					data-vehicle-id="<?= $item['id'];?>"
					data-action="set-vehicle"
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
					data-action="toggle-fav-com"
					data-target="CIS_FAVORITES" 
					data-vehicle="<?= $item['id'];?>"
					class="b-radius-yaradius-12 bg-yawhite me-2 <?= ((in_array($item['id'], $data['FAVORITES']))?'active':'');?> vehicle-card-discount-item position-relative">
					<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-favorites.svg';?>" />
					<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-favorites-a.svg';?>" />
				</a>
				<a 
					href="#" 
					data-action="toggle-fav-com"
					data-target="CIS_COMPARE" 
					data-vehicle="<?= $item['id'];?>"
					class="b-radius-yaradius-12 bg-yawhite <?= ((in_array($item['id'], $data['COMPARE']))?'active':'');?> vehicle-card-discount-item position-relative">
					<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-compare.svg';?>" />
					<img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-compare-a.svg';?>" />
				</a>
			</div>
		</div>
	</div>
</div>
<?php unset($validImages, $k, $i, $tag, $s_row); ?>
