<?php
    $expand = true;
    if ( $filter['filter']!='expand' && $range['code']=='price') $expand = false;
?>
<div class="b-radius-yaradius-15 bg-yalightbluegray range-row c-yadarkgray position-relative" data-range="<?= $range['code'];?>" role="view">
    <span class="range-title-from text-minus-minus position-absolute"><?= $range['name'];?> от</span>
    <span class="range-title-to text-minus-minus position-absolute">до</span>
    <?php if ( $range['unit'] ) { ?>
    <span class="range-title-param text-minus-minus position-absolute"><?= $range['unit'];?></span>
    <?php } ?>
    <div class="range-view">
        <input 
            type="text" 
            name="min" 
            value="<?= (($range['format'])?number_format($range['value'][0], 0, '.', ' '):$range['value'][0]);?>"
            /> 
        <input 
            type="text" 
            name="max" 
            value="<?= (($range['format'])?number_format($range['value'][1], 0, '.', ' '):$range['value'][1]);?>"
            class="ps-2 b-l-yagray text-end"
            />
    </div>
</div>
<div class="range" data-range="<?= $range['code'];?>" role="range">
    <div class="range-slider">
        <span 
            class="range-selected"
            data-url="<?= $app->makeFilterUrl($filter, [$range['code']=>false], false, $expand);?>"
            data-min="<?= $range['value'][0];?>"
            data-max="<?= $range['value'][1];?>"
            data-url-flag="<?= $range['url_flag'];?>"
            style="
                left: <?= ($range['value'][0]-$range['min'])/($range['range'])*100;?>%;
                right: <?= ($range['max']-$range['value'][1])/($range['range'])*100;?>%;
            "
            ></span>
    </div>
    <div class="range-input">
        <input 
            type="range" 
            class="min" 
            min="<?= $range['min'];?>" 
            max="<?= $range['max'];?>" 
            value="<?= $range['value'][0];?>" 
            step="1"
            />
        <input 
            type="range" 
            class="max" 
            min="<?= $range['min'];?>" 
            max="<?= $range['max'];?>" 
            value="<?= $range['value'][1];?>" 
            step="1"
            />
    </div>
</div>