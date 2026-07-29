
<div class="container">
	<div class="row">
		<div class="col">
			<div class="offers-filter-tabs d-flex w-100">
				<a
					href="<?= YApp::makeFilterUrl($_GET, []);?>"
					class="offers-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex justify-content-center align-items-center <?= (($_GET['tag'])?'':'active');?>">
					<span>Все</span>
				</a>
				<?php foreach ( $arResult['FILTER']['tag']['items'] as $item) { ?>
					<a 
						href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']], false);?>"
						class="offers-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-lg-flex justify-content-center align-items-center <?= (($item['selected'])?'active':'');?> ">
						<span><?= $item['name'];?></span>
					</a>
				<?php } ?>
				<a 
					href="<?= YApp::makeFilterUrl($_GET, ['tag'=>'sale,credit,insurance,tradein']);?>"
					class="offers-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex d-lg-none justify-content-center align-items-center">
					<span>Продажи</span>
				</a>
				<a 
					href="<?= YApp::makeFilterUrl($_GET, ['tag'=>'service']);?>"
					class="offers-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-flex d-lg-none justify-content-center align-items-center">
					<span>Сервис</span>
				</a>
			</div>
			<div class="offers-filter-tabs-content p-4 bg-yawhite d-flex flex-column justify-content-center align-items-start">
				<h1 class="fw-bold text-uppercase my-4"><?= $arResult['NAME'];?></h1>
				<?php if ( $arResult['FILTER']['TAGS'] ) { ?>
				<div class="text-minus-minus pb-4">
					<div class="row">
						<div class="col">
							<?php foreach ( $arResult['FILTER']['brand']['items'] as $item ) { ?>
								<?php if ( in_array($item['code'], explode(',', $_GET['brand'])) ) { ?>
									<a 
										href="<?= YApp::makeFilterUrl($_GET, ['brand'=>$item['code']]);?>" 
										class="d-inline-flex list-inline-item bg-yatag b-radius-yaradius-12 py-1 px-2 my-2 c-yablack c-h-yablack text-decoration-none" 
									>
										<?= $item['name'];?>
										<img class="ms-2" src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" />
									</a>
								<?php } ?>
							<?php } ?>
							<?php foreach ( $arResult['FILTER']['tag']['items'] as $item ) { ?>
								<?php if ( in_array($item['code'], explode(',', $_GET['tag'])) ) { ?>
									<a 
										href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']]);?>" 
										class="d-inline-flex list-inline-item bg-yatag b-radius-yaradius-12 py-1 px-2 my-2 c-yablack c-h-yablack text-decoration-none" 
									>
										<?= $item['name'];?>
										<img class="ms-2" src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" />
									</a>
								<?php } ?>
							<?php } ?>
							<a 
								href="<?= YApp::makeFilterUrl($_GET, []);?>" 
								class="d-inline-flex list-inline-item bg-yawhite b-radius-yaradius-12 py-1 px-2 my-2 c-yablack c-h-yablack text-decoration-none" 
							>
								Сбросить
								<img class="ms-2" src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/cross.svg" />
							</a>
						</div>
					</div>
				</div>
				<?php } ?>
				<form class="row w-100" data-sid="OFFERS_FILTER">
					<div class="col-lg-3 mb-2 mb-lg-0">
						<div class="form-dropcontainer position-relative <?= (($arResult['FILTER']['brand']['selected'])?'selected':'');?>" data-name="Бренд">
							<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="brands">
								<span><?= $arResult['FILTER']['brand']['title'];?></span>
								<a href="<?= YApp::makeFilterUrl($_GET, ['brand'=>false]);?>" class="before"></a>
								<div class="after"></div>
							</div>
							<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-link="true">
								<div class="form-droplist-container h-100">
									<?php foreach ( $arResult['FILTER']['brand']['items'] as $k => $item ) { ?>
									<a href="<?= YApp::makeFilterUrl($_GET, ['brand'=>$item['code']]);?>" 
										class="form-droplist-item py-1 ps-4 d-block text-decoration-none <?= (($item['selected'])?'selected':'');?>"
										><?= $item['name'];?></a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 mb-2 mb-lg-0">
						<div class="form-dropcontainer position-relative <?= (($arResult['FILTER']['dealership']['selected'])?'selected':'');?>" data-name="Город">
							<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="brands">
								<span><?= $arResult['FILTER']['dealership']['title'];?></span>
								<a href="<?= YApp::makeFilterUrl($_GET, ['dealership'=>false]);?>" class="before"></a>
								<div class="after"></div>
							</div>
							<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-link="true">
								<div class="form-droplist-container h-100">
									<?php foreach ( $arResult['FILTER']['dealership']['items'] as $k => $item ) { ?>
									<a href="<?= YApp::makeFilterUrl($_GET, ['dealership'=>$item['code']]);?>" 
										class="form-droplist-item py-1 ps-4 d-block text-decoration-none <?= (($item['selected'])?'selected':'');?>"
										><?= $item['name'];?></a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>