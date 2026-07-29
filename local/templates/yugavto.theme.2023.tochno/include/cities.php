<?php
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'CODE' => 'CITY'
    ]
);
while ( $ob = $rs->Fetch() ) $cities[] = ['code'=>$ob['XML_ID'],'name'=>$ob['VALUE']];
$c_cities = explode(',', YApp::setCityCookie());
unset(
    $cities[4],
    $cities[5],
    $cities[6],
);
?>
<div class="remodal remodal-small cities text-start" data-remodal-id="CITIES">
	<button data-remodal-action="close" class="remodal-close"></button>
    <ul class="list-unstyled">
        <li class="py-2 b-b-yagray cities-item" role="setCity" data-city="all">Все города</li>
        <?php foreach ( $cities as $item ) { ?>
        <li class="py-2 cities-item d-flex align-items-center justify-content-between" role="setCity" data-city="<?= $item['code'];?>">
            <span><?= $item['name'];?></span>
            <span><input class="form-check-input" type="checkbox" <?= ((in_array($item['name'],$c_cities))?'':'');?>checked /></span>
        </li>
        <?php } ?>
    </ul>
</div>
<script>
$(document).on('click', '.cities .cities-item', function() {
    
});
</script>