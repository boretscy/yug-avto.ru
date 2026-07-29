<div class="cta-card d-flex flex-column justify-content-end">
    <div class="cta-card-img w-100 d-flex justify-content-center">
        <img src="<?= $app->Conf()['assetsUrl'];?>/assets/images/cta_<?= $item['code'];?>.png?2" />
    </div>
    <div class="cta-card-content b-radius-yaradius-16 bg-yalightbluegray px-3 pt-5 pb-2 text-start">
        <div class="fw-bolder text-uppercase lineheight-1" style="font-size:<?= $item['sizes_2025'][0];?>px;"><?= $item['title1'];?></div>
        <div class="text-uppercase lineheight-1" style="font-size:<?= $item['sizes_2025'][1];?>px;"><?= $item['title2'];?></div>
        <div class="fw-bolder text-uppercase lineheight-1" style="font-size:<?= $item['sizes_2025'][2];?>px;"><?= $item['title3'];?></div>
        <div class="cta-card-text c-yadarkgray my-4"><?= $item['text'];?></div>
        <a
			href="#" rel="nofollow"
            role="not-cover"
			class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-12 bg-yawhite bg-h-yayellow vehicle-card-button fw-bold mt-5"
			data-remodal-target="<?= $item['code'];?>-modal"
		><?= $item['button'];?></a>
    </div>

</div>