<div class="container my-5 vehicle-recomended">
    <div class="row mb-3">
        <div class="col">
            <h2 class="h1 text-uppercase ps-2 ps-lg-0"><?= ((!$data['is_used'])?'Автомобили с пробегом':'Новые автомобили');?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col position-relative">
            <div class="swiper vehicle-recomended-swiper text-start">
                <div class="swiper-wrapper">
                    <?php foreach ($data['others'] as $item) { ?>
                    <?php $item['id'] = $item['ext_id']; ?>
                    <?php $item['offer_link'] = true; ?>
                    <div class="swiper-slide">
                        <?php include __DIR__.'/../vehicles/others_vehicle.php'; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="vehicle-recomended-swiper-prev">
				<div class="vehicle-recomended-swiper-wrap d-flex justify-content-center align-items-center b-radius-yaradius-12">
					<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-left.svg';?>" />
				</div>
			</div>
			<div class="vehicle-recomended-swiper-next">
				<div class="vehicle-recomended-swiper-wrap d-flex justify-content-center align-items-center b-radius-yaradius-12">
					<img src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-swiper-arrow-right.svg';?>" />
				</div>
			</div>
        </div>
    </div>
</div>