<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("К сожалению, автомобилей данной марки сейчас нет в наличии.");


$vehicles = json_decode(file_get_contents('https://apps.yug-avto.ru/API/get/cis/random/'.(($GLOBALS['SHOWROOM_MODE'])?:'new').'/?token=34b5ac8b71018c0bc7e5c050ed90b243'), true);
// YApp::sp('https://apps.yug-avto.ru/API/get/cis/random/'.(($GLOBALS['SHOWROOM_MODE'])?:'new').'/?token=34b5ac8b71018c0bc7e5c050ed90b243');
?>

<style>
    .title svg {
        fill: var(--yayellow);
        width: 30px;
        height: 30px;
        margin-left: 15px;
        top: 0;
        right: 0;
    }

    .swiper-cis-new, .swiper-brands {
        width: 100%;
        height: auto;
        overflow-x: hidden;
        position: relative;
    }
    .swiper-cis-new .swiper-slide, .swiper-brands .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-brands .swiper-slide img {
        width: 180px;
    }

    .swiper-cis-new .swiper-button-next, .swiper-cis-new .swiper-button-prev, .swiper-brands .swiper-button-next, .swiper-brands .swiper-button-prev {
        color: var(--yablue);
    }

    .swiper-cis-new-button-prev, .swiper-cis-new-button-next, .swiper-brands-button-prev, .swiper-brands-button-next {
        width: 50px;
        height: 50px;
        position: absolute;
        background-color: var(--yawhite);
        padding: 3px;
        border-radius: 50%;
        cursor: pointer;
        top: calc(50% - 25px);
    }
    .swiper-button-inner-circle {
        padding: 3px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
    }
    .swiper-cis-new-button-prev svg, .swiper-cis-new-button-next svg, .swiper-brands-button-prev svg, .swiper-brands-button-next svg {
        width: 35px;
        height: 35px;
        margin-left: 0;
        fill: var(--yablue);
    }
    .swiper-cis-new-button-prev, .swiper-brands-button-prev {
        left: -75px;
    }
    .swiper-cis-new-button-next, .swiper-brands-button-next {
        right: -75px;
    }

    .swiper-cis-new .swiper-pagination, .swiper-brands .swiper-pagination {
        bottom: 0;
        font-size: .8rem;
    }
    .swiper-cis-new .swiper-pagination-current, .swiper-brands .swiper-pagination-current {
        color: var(--yablue);
        font-size: 1rem;
    }
    .cis-new-item-image {
        height: 230px;
        overflow: hidden;
    }
    .new-item-title {
        height: 60px;
    }
    .webkit_box {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media (max-width: 1024px) {
        .swiper-cis-new-button-next, .swiper-brands-button-next {
            right: -15px;
            z-index: 50;
        }
        .swiper-cis-new-button-prev, .swiper-brands-button-prev {
            left: -15px;
            z-index: 50;
        }
    }
    @media (max-width: 768px) {
        .swiper-cis-new-button-next, .swiper-brands-button-next {
            right: -10px;
            z-index: 50;
        }
        .swiper-cis-new-button-prev, .swiper-brands-button-prev {
            left: -10px;
            z-index: 50;
        }
    }
    @media (max-width: 650px) {
        .swiper-cis-new-button-next, .swiper-brands-button-next {
            right: 0px;
            z-index: 50;
        }
        .swiper-cis-new-button-prev, .swiper-brands-button-prev {
            left: 0px;
            z-index: 50;
        }
    }
    /*card cards available__grid-item*/
    .available__grid-item {
        text-decoration: none;
        border: solid 1px var(--yagray);
        display: block;
        padding: 0 0;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        transition: 200ms;
        overflow: hidden;
        border-radius: 3px;
    }
    .available__grid-item:hover {
        color: var(--yablack);
        border: solid 1px var(--yayellow);
    }
    .available__grid-item:hover .button::before {
        bottom: -199px;
        left: -240px;
    }
    .liner_model .available__grid-item {
        padding: 0 0;
    }
    .grid-item__head {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 1em;
    }
    .grid-item__head-img {
        --heigth: 200px;
        background: var(--yawhite);
        min-height: var(--heigth);
        height: 100%;
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-around;
    }
    .grid-item__head-img img {
        max-height: var(--heigth);
        object-fit: cover !important;
        width: 100%;
    }
    .head_items-box {
        padding: 1em 1em;
        text-align: left;
    }
    .grid-item__title {
        text-decoration: none;
        font-size: 18px;
        font-weight: 600;
        line-height: 1em;
        margin-bottom: 1em;
        display: block;
        min-height: 35px;
        max-height: 40px;
        text-transform: uppercase;
        color: var(--yablack) !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        color: var(--yadarkgray);
    }
    .model__grid-card__content--list_box {
        --margin-bottom: 2em;
        margin-bottom: var(--margin-bottom);
    }
    .model__grid-card__content--list {
        --margin-bottom: 2em;
        margin-bottom: 0;
        word-break: break-all;
        min-height: revert;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4rem;
    }
    .model__grid-card__content--list-item {
        font-size: 13px;
        font-weight: 300;
        line-height: 1em;
        color: var(--yadarkgray);
        display: inline-block;
    }
    .model__grid-card__content--list-item::before {
        content: '\2022';
        color: var(--yadarkblue);
        margin-right: 0.3rem;
        margin-left: 0.3rem;
        font-size: 20px;
        vertical-align: middle;
    }
    .model__grid-card__content--list-item:nth-child(1)::before {
        content: '';
        margin-left: 0;
        margin-right: 0;
    }
    .model__grid-card__footer {
        padding: var(--padding);
        padding-top: 0;
    }
    .model__grid-card__content--price {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .model__grid-card__content--price_curent {
        font-size: 16px;
        font-weight: 400;
        line-height: 1em;
    }
    .button {
        --ui-color: var(--yadarkblue);
        --border-color: var(--ui-color);
        --background: transparent;
        --color: var(--ui-color);
        --font-size: 14px;
        --padding-top-bottom: 12px;
        --padding-left-right: 40px;
        --margin-inner: 15px;
        --icon-size: calc(1em * 1.2);
        --transition: 100ms;
        line-height: calc(1em * 1);
        display: inline-flex;
        border: 1px solid var(--yadarkblue);
        color: var(--yawhite);
        background: var(--color);
        font-size: var(--font-size);
        padding: var(--padding-top-bottom) var(--padding-left-right);
        border-radius: 3px;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        /*margin-bottom: 10px;*/
        align-content: space-between;
        transition: var(--transition);
        text-decoration: none;
        /*box-shadow: inset 0 0 1px 1px var(--yablack)00038, 0px 1px 0px 0px var(--yablack)0002b;*/
    }
    .button:active {
        box-shadow: inset 0 0 3px 2px var(--yablack)00020;
    }
    .button:hover {
        --ui-color: var(--yayellow);
        color: var(--yablack);
        background: var( --ui-color);
        border: solid 1px var(--yadarkblue);
        /*
        Создать медиа запрос на кастомный скрин вот так
        */
    }
    .button span {
        z-index: 50;
    }
    .transparent{
        --ui-color: var(--yadarkblue);
        position: relative;
        overflow: hidden;
        transition: 300ms;
        background: var(--yawhite);
        color: var(--ui-color);
    }
    .transparent:hover {
        --ui-color: var(--yadarkblue);
        background: var(--yawhite);
        color: var(--ui-color);
        border: solid 1px var(--ui-color);
    }
    .transparent::before {
        content: "";
        background-color: var(--yayellow);
        border-radius: 50%;
        width: 300px;
        height: 300px;
        position: absolute;
        bottom: -300px;
        left: -300px;
        transition: .2s;
        z-index: 0;
    }
    .transparent:hover::before{
        bottom: -199px;
        left: -240px;
    }
</style>

<div class="container text-center">
    <div class="row my-5">
        <div class="col-md"></div>
        <div class="col-md-5"><img src="/upload/img/404-page.png" alt="404" class="w-100"></div>
        <div class="col-md"></div>
    </div>
    <div class="row my-5">
        <div class="col"><div class="h2">К сожалению, автомобилей данной <?= (($GLOBALS['SHOWROOM_LEVEL']=='model')?'модели':'марки');?> сейчас нет в наличии.</div></div>
    </div>
    <div class="row my-5">
        <div class="col text-center">
            <a href="/" class="text-center c-yablack c-h-yablack b-yablue text-decoration-none b-radius-small py-2 px-4 bg-circle d-inline-block me-3"><span>На главную</span></a>
            <?php if ( CSite::InDir('/cars/') ) { ?>
            <a href="/cars/<?= (($GLOBALS['SHOWROOM_MODE'])?:'new');?>/" class="text-center c-yablack c-h-yablack b-yablue text-decoration-none b-radius-small py-2 px-4 bg-circle d-inline-block me-3"><span>Выбрать другое авто</span></a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="container my-5">
    <hr />
    <div class="row title mb-5">
        <div class="col-md-8"><h2 class="fw-normal">Другие авто в наличии</h2></div>
        <div class="col-md-4 text-md-end pt-2">
            <a href="/cars/<?= (($GLOBALS['SHOWROOM_MODE'])?:'new');?>/" class="c-yablack c-h-yablack text-decoration-none">
                Все автомобили
                <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
            </a>
        </div>
    </div>
                
    <div class="row cis-new" role="cis">
        <div class="col position-relative">
            
            <div class="swiper-cis-new pb-5">
                <div class="swiper-wrapper" role="cis-new-swiper">
                    <?php foreach ( $vehicles as $item ) { ?>
                    <div class="swiper-slide">
                        <div class="available__grid-item">
                            <div class="grid-item__head">
                                <a href="<?= $item['link'];?>" class="grid-item__head-img"><img src="<?= $item['image'];?>" alt="<?= $item['name'];?>"></a>
                            </div>
                            <div  class="head_items-box">
                                <div class="head_items">
                                    <a href="<?= $item['link'];?>" class="grid-item__title"><?= $item['name'];?></a>
                                </div>
                                <div class="model__grid-card__content--list_box">
                                    <div class="model__grid-card__content--list">
                                        <?php foreach ( array_chunk($item['general'], 3)[0] as $g ) { ?>
                                            <?php if ($g) { ?>
                                                <span  class="model__grid-card__content--list-item"><?= $g?></span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="model__grid-card__content--list">
                                        <?php foreach ( array_chunk($item['general'], 3)[1] as $g ) { ?>
                                            <?php if ($g) { ?>
                                                <span  class="model__grid-card__content--list-item"><?= $g?></span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div  class="model__grid-card__footer">
                                    <div  class="model__grid-card__content--price">
                                        <div  class="model__grid-card__content--price_curent"><?= YApp::formatNumber($item['price']);?> <span  class="rub">₽</span></div>
                                    </div>
                                    <a href="<?= $item['link'];?>" class="button transparent w100"><span >ПОЛУЧИТЬ ПРЕДЛОЖЕНИЕ</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } // foreach USED ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
                    
            <div class="swiper-cis-new-button-prev b-yablue">
                <div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
            </div>
            <div class="swiper-cis-new-button-next b-yablue">
                <div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
            </div>

        </div>
    </div>
        
</div>


<script>
const swiper_cis_new = new Swiper('.swiper-cis-new', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-cis-new-button-next',
        prevEl: '.swiper-cis-new-button-prev',
    },
    slidesPerView: 4,
    spaceBetween: 25,
    
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        750: {
            slidesPerView: 2,
            spaceBetween: 25
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 25
        },
    }
})
</script>



<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>