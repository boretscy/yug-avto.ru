
<div class="container">
	<div class="row">
		<div class="col">
			<div class="vacancies-filter-tabs d-flex w-100">
				<a
					href="<?= YApp::makeFilterUrl($_GET, []);?>"
					class="vacancies-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill d-none d-lg-flex justify-content-center align-items-center <?= (($_GET['tag'])?'':'active');?>">
					<span>Все</span>
				</a>
				<?php foreach ( $arResult['FILTER']['tag']['items'] as $item) { ?>
					<a 
						href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']], false);?>"
						class="vacancies-filter-tabs-item b-yawhite c-yablack c-h-yablack text-decoration-none flex-fill <?= (($item['code']=='showroom'||$item['code']=='buyout'||$item['code']=='service')?'d-flex':'d-none');?> d-lg-flex justify-content-center align-items-center <?= (($item['selected'])?'active':'');?> ">
						<span><?= $item['name'];?></span>
					</a>
				<?php } ?>
			</div>
			<div class="vacancies-filter-tabs-content p-4 bg-yawhite d-flex flex-column justify-content-center align-items-start">
				<h1 class="fw-bold text-uppercase my-4">Работа в Юг-Авто - <?= $GLOBALS['VACANCIES_COUNT'];?> <?=YApp::getWorld($GLOBALS['VACANCIES_COUNT'], 'v')?></h1>
				<form class="row w-100" data-sid="VACANCIES_FILTER">
					<div class="col-lg-3 d-lg-none mb-2 mb-lg-0">
						<div class="form-dropcontainer position-relative <?= (($arResult['FILTER']['tag']['selected'])?'selected':'');?>" data-name="Вакансии">
							<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="tags">
								<span><?= $arResult['FILTER']['tag']['title'];?></span>
								<a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>false]);?>" class="before"></a>
								<div class="after"></div>
							</div>
							<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-link="true">
								<div class="form-droplist-container h-100">
									<?php foreach ( $arResult['FILTER']['tag']['items'] as $item) { ?>
									<a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']]);?>" 
										class="form-droplist-item py-1 ps-4 d-block text-decoration-none <?= (($item['selected'])?'selected':'');?>"
										><?= $item['name'];?></a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 mb-2 mb-lg-0">
						<div class="form-dropcontainer position-relative <?= (($arResult['FILTER']['city']['selected'])?'selected':'');?>" data-name="Город">
							<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="cities">
								<span><?= $arResult['FILTER']['city']['title'];?></span>
								<a href="<?= YApp::makeFilterUrl($_GET, ['city'=>false]);?>" class="before"></a>
								<div class="after"></div>
							</div>
							<div class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16" data-link="true">
								<div class="form-droplist-container h-100">
									<?php foreach ( $arResult['FILTER']['city']['items'] as $k => $item ) { ?>
									<a href="<?= YApp::makeFilterUrl($_GET, ['city'=>$item['code']]);?>" 
										class="form-droplist-item py-1 ps-4 d-block text-decoration-none <?= (($item['selected'])?'selected':'');?>"
										><?= $item['name'];?></a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 mb-2 mb-lg-0">
						<div class="form-dropcontainer position-relative <?= (($arResult['FILTER']['dealership']['selected'])?'selected':'');?>" data-name="Автосалон">
							<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="dealerships">
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