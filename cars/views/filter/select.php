<?php
    $expand = true;
    if ( $filter['filter']!='expand' && ($select['code']=='brand'||$select['code']=='model'||$select['code']=='dealership')) $expand = false;
    foreach ( $data['filter']['dropLists'][$select['list']] as $k => $item ) {
        foreach ( $select['select_fields'] as $field ) {
            if ( in_array($item[$field], explode(',', $filter[$select['code']])) ) $data['filter']['dropLists'][$select['list']][$k]['selected'] = true;
        }
    }
?>
<div class="form-dropcontainer position-relative cursor-pointer">
    <div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer">
        <?php if ( $select['code'] == 'mode' ) { ?>
            <?= $app->Conf()['Api']['name'];?>
        <?php } else { ?>
            <?php if ( $filter[$select['code']] && count(explode(',', $filter[$select['code']])) != 0 ) { ?>
            <span>Выбрано: <?= count(explode(',', $filter[$select['code']]));?></span>
            <?php } else { ?>
            <span><?= $select['name'];?></span>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="form-droplist bg-yalightgray w-100 position-absolute d-none b-radius-yaradius-16 px-2 py-3" data-link="true">
        <div class="form-droplist-container h-100">
            <?php foreach ( $data['filter']['dropLists'][$select['list']] as $item ) { ?>
                <?php if ( $item['code'] != 'none' ) { ?>
                <?php
                    $urlParams = [$select['code'] => $item[(($select['url_field'])?:'code')]];
                    if ($select['code'] == 'model') {
                        $itemBrand = (!empty($item['brand']['code'])) ? $item['brand']['code'] : ((!empty($item['brand_code'])) ? $item['brand_code'] : $filter['brand']);
                        if (!empty($itemBrand)) {
                            $urlParams['brand'] = $itemBrand;
                        }
                    }
                ?>
                <a href="<?= $app->makeFilterUrl($filter, $urlParams, false, $expand);?>" 
                    class="form-droplist-item py-1 ps-4 d-block text-decoration-none <?= (($item['selected'])?'selected':'');?>"
                    data-name="<?= $select['list'];?>"
                    data-value="<?= $item['code'];?>"
                    ><?= $item['name'];?></a>
                <?php } else { ?>
                <span class="form-droplist-item py-1 ps-4 d-block text-decoration-none"><?= $item['name'];?></span>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>