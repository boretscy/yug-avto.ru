<div class="bg-yalightbluegray dealership py-4 py-lg-5 middle-container">
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h2 class="h1 text-uppercase ps-2 ps-lg-0">Автомобиль в наличии</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="dealership-wrap bg-yawhite p-3 position-relative">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="image w-100 h-100 b-radius-yaradius-16" style="background-image: url(<?= $data['_dealership']['PIC_DESKTOP_PREVIEW'];?>);"></div>
                                </div>
                                <div class="col-lg-6">
                                    <a class="h4 fw-bold c-yablack c-h-yablack text-decoration-none mt-1 mb-3 block-title-link d-flex justify-content-start align-items-center" href="<?= $data['_dealership']['DETAIL_PAGE_URL'];?>">
                                        <?= $data['_dealership']['NAME'];?>
                                        <div class="info-arrow d-inline-block ms-3"></div>
                                    </a>
                                    <div class="row text-minus dealership-content mb-3 mx-0">
                                        <div class="col-1 my-1 d-flex align-items-center px-0">
                                            <span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
                                                <img src="<?= $app->Conf()['assetsUrl'].'/assets/images/svg/icon-dealerships-address.svg';?>" />
                                            </span>
                                        </div>
                                        <div class="col-11 my-1 d-flex align-items-center"><?= $data['_dealership']['PROPERTY_ADDRESS_VALUE'];?></div>
                                        <div class="col-1 my-1 d-flex align-items-center px-0">
                                            <span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
                                                <img src="<?= $app->Conf()['assetsUrl'].'/assets/images/svg/icon-dealerships-clock.svg';?>" />
                                            </span>
                                        </div>
                                        <div class="col-11 my-1 d-flex align-items-center"><?= $data['_dealership']['WORK'][0]['VALUE'];?></div>
                                        <div class="col-1 d-flex align-items-center px-0">
                                            <span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
                                                <img src="<?= $app->Conf()['assetsUrl'].'/assets/images/svg/icon-dealerships-phone.svg';?>" />
                                            </span>
                                        </div>
                                        <div class="col-11 d-flex align-items-center">
                                            <a 
                                                href="tel:<?= $app->phoneIn($data['_dealership']['PROPERTY_PHONE_VALUE']);?>" 
                                                class="h3 block-title c-yablack c-h-yablack text-decoration-none fw-bold">
                                                <?= $app->phoneOut($data['_dealership']['PROPERTY_PHONE_VALUE']);?></a>
                                        </div>
                                        <div class="col-1 mt-1 d-flex align-items-center px-0">
                                            <span class="b-radius-yaradius-8 bg-yadarkgray d-flex align-items-center justify-content-center">
                                                <img src="<?= $app->Conf()['assetsUrl'].'/assets/images/svg/icon-dealerships-globe.svg';?>" />
                                            </span>
                                        </div>
                                        <div class="col-11 mt-1 d-flex align-items-center">
                                            <a 
                                                href="<?= $data['_dealership']['SITE'];?>" 
                                                target="_blank"
                                                class="c-yablack c-h-yablack text-decoration-none">
                                                <?= parse_url($data['_dealership']['SITE'])['host'];?>
                                            </a>
                                        </div>
                                    </div>
                                    <?php if ( $data['_dealership']['PROPERTY_YANDEX_ID_VALUE'] ) { ?>
                                    <div class="dealership-card-rating mb-3" data-id="<?= $data['_dealership']['PROPERTY_YANDEX_ID_VALUE'];?>">
                                        <iframe src="https://yandex.ru/sprav/widget/rating-badge/<?=  $data['_dealership']['PROPERTY_YANDEX_ID_VALUE'];?>?type=rating" width="150" height="50" frameborder="0"></iframe>
                                    </div>
                                    <?php } ?>
                                    <div class="row text-minus mb-4">
                                        <div class="col-6 pe-1">
                                            <a 
                                                href="/cars/<?= (($POST['ENTITY'])?:'new');?>/?dealership=<?= $data['_dealership']['CODE'];?>"
                                                class="dealerships-on-main-view-info-button b-radius-yaradius-8 px-2 py-1 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yalightbluegray bg-h-yayellow">
                                                <img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-cis.svg" />
                                                <span>Авто в наличии</span>
                                            </a>
                                        </div>
                                        <div class="col-6 ps-1">
                                            <a 
                                                href="/services/service/?dealership=<?= $data['_dealership']['CODE'];?>"
                                                class="dealerships-on-main-view-info-button b-radius-yaradius-8 px-2 py-1 d-flex align-items-center justify-content-center d-block c-yablack c-h-yablack text-decoration-none bg-yalightbluegray bg-h-yayellow">
                                                <img class="me-2" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-service.svg" />
                                                <span>Запись на сервис</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a 
                                                href="#FORM_CALLBACK" 
                                                class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yayellow bg-h-yadarkyellow dealerships-button d-flex justify-content-center align-items-center"
                                                data-remodal-target="FORM_CALLBACK" 
                                                data-dealership="<?= $data['_dealership']['CODE'];?>" 
                                                role="not-cover"
                                                action="setDealership"
                                                >Обратный звонок</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dealership-footer-button-wrap position-absolute end-0 bottom-0 bg-yalightbluegray">
                        <div class="top bg-yawhite"></div>
                        <div class="bottom d-flex bg-yawhite">
                            <div class="left bg-yalightbluegray">
                                <div class="left-wrap bg-yawhite"></div>
                            </div>
                            <div class="right">
                                <div class="right-wrap bg-yalightbluegray">
                                    <a 
                                        href="https://yandex.ru/maps/?ll=<?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>,<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>&z=15&mode=routes&rtext=~<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>,<?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>&rtt=auto&ruri=~" 
                                        class="dealership-footer-button b-radius-yaradius-12 bg-yawhite d-flex justify-content-center align-items-center position-relative"
                                        role="not-cover"
                                        target="_blank" 
                                        >
                                        <img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route.svg">
                                        <img class="position-absolute" src="/local/templates/yugavto.theme.2025/assets/images/svg/icon-dealerships-route-a.svg">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="vehicle-map b-radius-yaradius-16 h-100" id="vehicleMap"></div>
            </div>
        </div>
    </div>
</div>