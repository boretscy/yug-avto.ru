
<div class="container">
	<div class="row">
		<div class="col">
			<div class="blog-filter-tabs-content p-4 bg-yawhite d-flex flex-column justify-content-center align-items-start">
				<h1 class="fw-bold text-uppercase mt-4"><?= $arResult['NAME'];?></h1>
				<div class="blog-title-description"><?= $arResult['DESCRIPTION'];?></div>
				<?php if ( $arResult['FILTER']['TAGS'] ) { ?>
				<div class="text-minus py-4">
					<div class="row">
						<div class="col">
							<a 
								href="<?= YApp::makeFilterUrl($_GET, []);?>" 
								class="d-inline-flex list-inline-item bg-<?= ((!$_GET['tag'])?'yatag':'yalightbluegray');?> b-radius-yaradius-16 py-2 px-3 my-2 c-<?= ((!$_GET['tag'])?'yablack':'yadarkgray');?> c-h-yablack text-decoration-none" 
							>
								Все статьи
							</a>
							<?php foreach ( $arResult['FILTER']['TAGS']['items'] as $item ) { ?>
								<a 
									href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']]);?>" 
									class="d-inline-flex list-inline-item bg-<?= (($item['selected'])?'yatag':'yalightbluegray');?> b-radius-yaradius-16 py-2 px-3 my-2 c-<?= (($item['selected'])?'yablack':'yadarkgray');?> c-h-yablack text-decoration-none" 
								>
									<?= $item['name'];?>
								</a>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>





