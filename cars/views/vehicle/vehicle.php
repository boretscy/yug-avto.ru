<div class="col-xl-6 mb-4 mb-lg-0">
    <?php
    $dCarBrand = $data['brand']['name'] ?? '';
    $dCarModel = $data['model']['name'] ?? '';
    $dCarYear = $data['year'] ?? '';
    $dCarMileage = (!empty($data['mileage'])) ? number_format($data['mileage'], 0, '.', ' ') . ' км' : '';
    $dCarEquipment = ($data['is_used'] ? '' : ($data['equipment'] ?? ''));
    $dCarType = ($data['is_used'] ? 'с пробегом' : 'новый');

    $dImgText = $dCarBrand . ' ' . $dCarModel . ' ' . $dCarYear . ' года с пробегом ' . $dCarMileage;
    ?>
    <div class="sticky-top" style="top: 9rem;">
        <div class="swiper vehicle-swiper position-relative">
            <div class="swiper-wrapper">
                <?php foreach ( $data['_images'] as $k => $item ) { ?>
                <div class="swiper-slide">
                    <a 
                        data-fancybox="gallery-<?= $data['id'];?>"
                        data-src="<?= $item['detail'];?>"
                        data-width="1522"
                        data-height="1200"
                        role="not-cover"
                        class="vehicle-full-image w-100"
                        ><img src="<?= $item['detail'];?>" class="b-radius-yaradius-25" alt="<?= htmlspecialchars(YApp::getCleanAltText($dImgText . ' - фото ' . ($k + 1)));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($dImgText . ' - фото ' . ($k + 1)));?>" <?= (($k==0)?'itemprop="image"':'');?> /></a>
                </div>
                <?php } ?>
            </div>
            <div class="vehicle-swiper-next b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/arrow-white.svg?2" /></div>
            <div class="vehicle-swiper-prev b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/arrow-white.svg?2" class="rotate-180" /></div>
            <div class="vehicle-swiper-buttons-row position-absolute d-flex">
                <a 
                    href="#" rel="nofollow" 
                    data-action="toggle-fav-com" role="not-cover"
                    data-target="CIS_FAVORITES" 
                    data-vehicle="<?= $data['id'];?>"
                    aria-label="Избранное"
                    class="ms-1 b-radius-yaradius-12 hint--bottom-left bg-yawhite vehicle-swiper-buttons-row-item vehicle-card-discount-item d-flex justify-content-center align-items-center <?= ((in_array($data['id'], $data['FAVORITES']))?'active':'');?> position-relative"
                    >
                    <img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-favorites.svg';?>" />
                    <img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-favorites-a.svg';?>" />
                </a>
                <a 
                    href="#" rel="nofollow" 
                    data-action="toggle-fav-com" role="not-cover"
                    data-target="CIS_COMPARE" 
                    data-vehicle="<?= $data['id'];?>"
                    aria-label="Сравнение"
                    class="ms-1 b-radius-yaradius-12 hint--bottom-left bg-yawhite vehicle-swiper-buttons-row-item vehicle-card-discount-item d-flex justify-content-center align-items-center <?= ((in_array($data['id'], $data['COMPARE']))?'active':'');?> position-relative"
                    >
                    <img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-compare.svg';?>" />
                    <img class="position-absolute" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/icon-compare-a.svg';?>" />
                </a>
                <div class="ms-1 b-radius-yaradius-12 vehicle-swiper-buttons-row-item bg-yawhite d-flex justify-content-center align-items-center ya-share2" data-curtain data-shape="round" data-color-scheme="whiteblack" data-limit="0" data-more-button-type="short" data-services="messenger,vkontakte,odnoklassniki,telegram,twitter,viber,whatsapp,skype"></div>
            </div>
        </div>
        <div class="swiper vehicle-swiper-thumbs mt-2">
            <div class="swiper-wrapper">
                <?php foreach ( $data['_images'] as $k => $item ) { ?>
                <div class="swiper-slide">
                    <img src="<?= $item['preview'];?>" class="b-radius-yaradius-15" alt="<?= htmlspecialchars(YApp::getCleanAltText($dImgText . ' - миниатюра ' . ($k + 1)));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($dImgText . ' - миниатюра ' . ($k + 1)));?>" />
                </div>
                <?php } ?>
                <?php /*
                <div class="vehicle-swiper-thumds-photo b-radius-yaradius-15 d-flex justify-content-center align-items-center c-yawhite fw-bold">
                    <span>+ <?= count($data['_images'])-4;?><br />фото</span>
                </div>
                */?>
            </div>
            <div class="vehicle-swiper-thumbs-next"></div>
            <div class="vehicle-swiper-thumbs-prev"></div>
        </div>
    </div>
</div>

<div class="col-xl-6">
    <div class="bg-yawhite p-4 b-radius-yaradius-16">
        <div class="row mb-3 mt-4 mt-xl-0">
            <div class="col-md-6">
                <?php if ( !$data['is_used'] ) { ?>
                <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus pb-2"><span>Комплектация:</span><span class="h5 fw-bold c-yablack"><?= (($data['equipment'])?:'&nbsp;');?></span></div>
                <?php } ?>
                <div class="">
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Цвет кузова:</span><span class="c-yablack"><?= $data['general'][2]['value'];?></span></div><hr class="m-0" />
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Год выпуска:</span><span class="c-yablack"><?= $data['general'][4]['value'];?></span></div><hr class="m-0" />
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Кузов:</span><span class="c-yablack"><?= ((is_array($data['body']))?$data['body']['name']:'');?></span></div><hr class="m-0" />
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Коробка:</span><span class="c-yablack"><?= ((is_array($data['transmission']))?$data['transmission']['name']:'');?></span></div><hr class="m-0" />
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Топливо:</span><span class="c-yablack"><?= ((is_array($data['engine']))?$data['engine']['name']:'');?></span></div><hr class="m-0" />
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Привод:</span><span class="c-yablack"><?= ((is_array($data['drive']))?$data['drive']['name']:'');?></span></div><hr class="m-0" />
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Двигатель:</span><span class="c-yablack"><?= $data['general'][(($app->Conf['Api']['mode']=='new')?5:8)]['value'];?></span></div>
                    <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2">
                        <span>Расход л/100км:</span><span class="c-yablack"><?= $data['specifications'][3]['value'];?> - <?= $data['specifications'][2]['value'];?></span>
                    </div>
                    <?php if ( $app->Conf['Api']['mode']=='used' ) { ?>
                        <div class="d-flex justify-content-between align-items-center c-yadarkgray text-minus py-2"><span>Пробег:</span><span class="c-yablack"><?= number_format($data['general'][5]['value'], 0, '.', ' ');?></span></div>
                    <?php } ?>
                </div>
                
            </div>
            <div class="col-md-6">
                <?php if ( $data['price']-$data['min_price'] > 0 ) { ?>
                <div class="h5 fw-bold">Выгода на авто</div>
                <div class="text-minus c-yadarkgray vehicle-discounts position-relative">
                    Максимальная сумма выгод - <?= number_format($data['price']-$data['min_price'], 0, '.', ' ');?> ₽  <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/question.svg" />
                    <div class="vehicle-discounts-disclamer bg-yawhite p-3 position-absolute">
                        Данная выгода действительна в случае приобретения автомобиля клиентом при условии использования специальных программ Производителя и/или ДЦ, а именно:<br />
                        <ul>
                            <?php foreach ( $data['discounts'] as $item ) { ?>
                            <li><?= $item['name'];?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <ul class="list-unstyled my-3">
                    <?php foreach ( $data['discounts'] as $item) { ?>
                    <li>
                        <div class="row vehicle-discounts-item active cursor-pointer" data-sum="<?= $item['sum'];?>" data-price="<?= $data['price'];?>" data-min="<?= $data['min_price'];?>">
                            <div class="col-8 text-minus d-flex justify-content-start align-items-center py-2">
                                <span class=" me-2 d-inline-block check d-flex justify-content-center align-items-center vehicle-discounts-item-check">
                                    <?php if ( $item['active'] ) { ?>
                                    <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/icon-check.svg" />
                                    <?php } ?>
                                </span>
                                <span><?= !empty($item['description']) ? $item['description'] : $item['name'];?></span>
                            </div>
                            <div class="col-4 fw-bold d-flex justify-content-end align-items-center vehicle-discounts-item-value"><?= number_format($item['sum'], 0, '.', ' ');?> ₽</div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
                    <?php /* if ( $data['additional_equipment_price'] ) { ?>
                    <div class="row py-1">
                        <div class="col-8">Доп. оборудование</div>
                        <div class="col-4 text-end">+ <?= number_format($data['additional_equipment_price'], 0, '.', ' ');?> ₽</div>
                    </div>
                    <?php } */ ?>
                <div class="row py-1 discount-price">
                    <div class="col-8 c-yadarkgray">Цена без учета выгод</div>
                    <div class="col-4 ps-0 text-end" role="max-price"><?= number_format($data['price'], 0, '.', ' ');?> ₽</div>
                </div>
                <div class="row py-1 mb-5 discount-price">
                    <div class="col-8 c-yadarkgray">Цена с учетом выгод</div>
                    <div class="col-4 ps-0 text-end fw-bold" role="min-price"><?= number_format($data['min_price'], 0, '.', ' ');?> ₽</div>
                </div>
                <?php } ?>
                <a
                    href="#" rel="nofollow" role="not-cover"
                    class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yawhite bg-h-yayellow b-yayellow vehicle-button mb-3"
                    data-remodal-target="trade-in-modal"
                    >Оценить автомобиль</a>
                <a
                    href="#" rel="nofollow" role="not-cover"
                    class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow bg-h-yadarkyellow b-yayellow b-h-yadarkyellow vehicle-button"
                    data-remodal-target="credit-modal"
                    >Рассчитать кредит</a>
            </div>
        </div>
    </div>
    
    <div class="d-flex overflow-auto my-3 gap-3 pb-2 vehicle-futures">
        <?php foreach ( $data['_tags'] as $tag ) { ?>
            <div class="flex-shrink-0 text-center text-minus c-yadarkgray" style="min-width: 95px;">
                <img src="<?= $tag['icon'];?>?2" />
                <p class="mt-2"><?= $tag['name'];?></p>
            </div>
        <?php } ?>  
    </div>

     <div class="d-flex vehicle-tabs">
		<div class="vehicle-tabs-item b-yawhite cursor-pointer flex-fill active d-flex justify-content-center align-items-center" role="vehicle-tab" data-action="0">
			<span>Характеристики и комплектация</span>
		</div>
        <?php if ( !empty($data['_additional']) ) { ?>
		<div class="vehicle-tabs-item b-yawhite cursor-pointer flex-fill d-flex justify-content-center align-items-center" role="vehicle-tab" data-action="1">
			<span>Дополнительно</span>
		</div>
        <?php } ?> 
	</div>
    <div class="vehicle-tabs-content p-3 bg-yawhite">
        <div class="vehicle-tabs-content-wrap w-100" role="vehicle-tab-content" data-action="0">
            <div class="row mb-3">
                <?php foreach ( $data['_specifications'] as $group ) { ?>
                    <div class="col-md-6 d-none d-lg-block">
                        <ul class="sepcifications list-unstyled m-0 p-0 b-radius-yaradius-16 b-yagray overflow-hidden">
                            <?php foreach ( $group as $item ) { ?>
                            <li class="d-flex justify-content-between align-items-center p-2">
                                <div class="text-minus c-yadarkgray"><?= $item['name'];?></div>
                                <div class=""><?= (($item['value'])?:'&nbsp;');?></div>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class="col-12 d-lg-none">
                    <ul class="sepcifications list-unstyled m-0 p-0 b-radius-yaradius-16 b-yagray overflow-hidden">
                        <?php foreach ( $data['_specifications'] as $group ) { ?>
                            <?php foreach ( $group as $item ) { ?>
                            <li class="d-flex justify-content-between align-items-center p-2">
                                <div class="text-minus c-yadarkgray"><?= $item['name'];?></div>
                                <div class=""><?= (($item['value'])?:'&nbsp;');?></div>
                            </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php if ( $data['options'] ) { ?>
            <div class="row px-2">
                <?php foreach ( $data['options'] as $k => $group ) { ?>
                <div class="col-12 vehicle-tabs-content-accordeon-title" data-index="<?= $k;?>">
                    <div class="row">
                        <div class="col-8"><?= $group['group'];?></div>
                        <div class="col-4 d-flex align-items-center justify-content-end text-minus c-yadarkgray">
                            <?= count($group['options']);?> <?= $app::getWorld(count($group['options']), 'option');?>
                            <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/svg/drop-corner.svg" class="ms-2">
                        </div>
                    </div>
                    <ul class="list-unstyled vehicle-options"  data-index="<?= $k;?>">
                        <?php foreach ( $group['options'] as $item ) { ?>
                        <li class="py-1 c-yadarkgray text-minus"><?= $item;?></li>
                        <?php } ?>
                    </ul>
                    <hr />
                </div>
                <?php } ?>
                <div class="col-12 toggle-vehicle-options text-decoration-underline text-minus c-yadarkgray" role="open">Посмотреть все опции</div>
                <div class="col-12 toggle-vehicle-options text-decoration-underline text-minus c-yadarkgray d-none" role="hide">Скрыть</div>
            </div>
            <?php } ?>
        </div>
        <?php if ( !empty($data['_additional']) ) { ?>
            <div class="vehicle-tabs-content-wrap w-100 d-none" role="vehicle-tab-content" data-action="1">
                <div class="row my-3">
                    <div class="col">
                        <ul class="list-unstyled">
                            <?php foreach ( $data['_additional'] as $item ) { ?>
                            <li class="py-1 c-yadarkgray text-minus"><?= $item;?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
</div>