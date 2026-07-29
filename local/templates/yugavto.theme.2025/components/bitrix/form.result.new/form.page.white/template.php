<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<div class="container my-5" data-form="<?= $arResult['arForm']['SID'];?>">
	<div class="row">
		<div class="col">
			<div class="bg-yawhite b-radius-yaradius-16 p-4">
				<div class="row">
					<div class="col-lg-7 position-relative">
						<h1 class="text-uppercase"><?= (($arResult['SETTINGS']['NAME'])?:$arResult['arForm']['NAME']);?></h1>
						<?php if ( $arResult['SETTINGS']['PREVIEW_TEXT'] ) { ?>
						<p class="text-plus c-yadarkgray"><?= $arResult['SETTINGS']['PREVIEW_TEXT'];?></p>
						<?php } ?>
						<img class="form-page-white-image position-xl-absolute" src="<?= CFile::GetPath($arResult['SETTINGS']['PROPERTY_IMAGE_VALUE']);?>" />
					</div>
					<div class="col-lg-5">
							<form class="row text-minus position-relative z-index-1" data-sid="<?= $arResult['arForm']['SID'];?>">
								<input type="hidden" name="FORM_ID" value="<?= $arResult['arForm']['ID'];?>" />
								<input type="hidden" name="FORM" value="<?= $arResult['SETTINGS']['PROPERTY_TITLE_VALUE'];?>" />
								<input type="hidden" name="SSID" value="<?= $_SESSION['fixed_session_id'];?>" />
								<?php foreach ( $arResult['arQuestions'] as $arItem ) { ?>
									<?php switch ( $arItem['SID'] ) {

										case 'CAR':
											?>
											<input type="hidden" name="<?= $arItem['SID'];?>"  value="<?= $arParams['CAR'];?>" />
											<?php 
											break;
										case 'VIN':
											?>
											<input type="hidden" name="<?= $arItem['SID'];?>" value="<?= $arParams['VIN'];?>" />
											<?php 
											break;

										case 'NAME':
											?>
											<div class="col-12 mb-3">
												<div class="form-group">
													<input 
														type="text" 
														class="form-control bg-yalightbluegray w-100" 
														autocomplete="off"
														name="<?= $arItem['SID'];?>"
														id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
														<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
															required
														<?php } // if REQUIRED ?>
														placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
												</div>
											</div>
											<?php 
											break;
										
										case 'EMAIL':
											?>
											<div class="col-12 mb-3">
												<div class="form-group">
													<input 
														type="email" 
														class="form-control bg-yalightbluegray w-100" 
														autocomplete="off"
														name="<?= $arItem['SID'];?>"
														id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
														<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
															required
														<?php } // if REQUIRED ?>
														placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
												</div>
											</div>
											<?php 
											break;

										case 'PHONE':
											?>
											<div class="col-12 mb-3">
												<div class="form-group">
													<input 
														type="phone" 
														class="form-control bg-yalightbluegray w-100" 
														autocomplete="off"
														name="<?= $arItem['SID'];?>"
														id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
														<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
															required
														<?php } // if REQUIRED ?>
														placeholder="+7 ___ ___ __ __<?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>"
														data-phone-pattern = "+7 ___ ___ __ __"
														maxlength="16" />
												</div>
											</div>
											<?php 
											break;

										case 'DEALERSHIP':
											?>
											<div class="col-12 mb-3">
												<input 
													type="hidden" 
													<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
														required
													<?php } // if REQUIRED ?>
													name="<?= $arItem['SID'];?>"
													<?php if ( $arResult['DEALERSHIPS_SELECTED_COUNT'] ) { ?>
													value="<?= implode(',',$arResult['DEALERSHIPS_SELECTED']);?>"
													<?php } ?>
													/>
												<div class="form-group">
													<div 
														class="form-dropcontainer position-relative <?= (($arResult['DEALERSHIPS_SELECTED_COUNT'])?'selected':'');?>" 
														name="<?= $arItem['SID'];?>" 
														data-name="<?= $arItem['TITLE'];?>" 
														data-list="<?= $arItem['SID'];?>">
														<div class="form-dropdown d-flex justify-content-between align-items-center position-relative cursor-pointer" data-list="<?= $arItem['SID'];?>">
															<span>
																<noindex>
																	<?= $arResult['DEALERSHIPS_TITLE'];?>
																</noindex>
															</span>
															<div class="before"></div>
															<div class="after"></div>
														</div>
														<div 
															class="form-droplist bg-yalightgray w-100 position-absolute d-none px-2 py-3 b-radius-yaradius-16"
															data-list="<?= $arItem['SID'];?>"
															>
															<div class="form-droplist-container h-100">
																<?php foreach ( $arResult['DEALERSHIPS'] as $item ) { ?>
																	<?php if ( $item['code'] != 'none' ) { ?>
																	<a href="#" 
																		class="form-droplist-item py-1 ps-4 d-block text-decoration-none <?= (($item['selected'])?'selected':'');?>"
																		data-name="dealership"
																		data-text="<?= $item['name'];?>"
																		data-value="<?= $item['code'];?>"
																		rel=“nofollow”
																		><noindex><?= $item['name'];?><noindex></a>
																	<?php } else { ?>
																	<span class="form-droplist-item not-link py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"><?= $item['name'];?></span>
																	<?php } ?>
																<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php
											break;

										case 'COMMENT':
										?>
										<div class="col-12 mb-2">
											<div class="form-group">
												<textarea
													class="form-control bg-yalightbluegray w-100" 
													name="<?= $arItem['SID'];?>"
													id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
													rows="1"
													<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
														required
													<?php } // if REQUIRED ?>
													placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>"
													></textarea>
											</div>
										</div>
										<?php
										break;
									} ?>
								<?php } // QUESTIONS  ?>
								<div class="col-12 mb-4">
									<fieldset>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="AGRYY_<?= $arResult['arForm']['ID'];?>" name="AGRYY"  />
											<label class="form-check-label text-minus-minus c-yadarkgray" for="AGRYY_<?= $arResult['arForm']['ID'];?>">
												<noindex>Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy/" target="_blank" rel=“nofollow” class="c-yablack c-h-yablack">политикой обработки персональных данных</a> и даю согласие на их обработку</noindex>
											</label>
										</div>
									</fieldset>
								</div>
								<div class="col-12">
									<div class="form-group">
										<a 
											href="#" 
											rel=“nofollow” 
											class="d-block b-radius-yaradius-16 bg-yayellow bg-h-yadarkyellow py-3 text-center c-yablack c-h-yablack text-decoration-none text-normal" 
											role="sendForm"
											><noindex><?= $arResult['arForm']['BUTTON'];?></noindex></a>
									</div>
								</div>
							</form>
							<div class="row mb-3 d-none w-100" role="success">
								<div class="col">
									<div class="p-3 bg-yawhite c-yablack text-center b-radius-small">
										<noindex>Спасибо за вашу заявку!<br />
										Мы свяжемся с Вами в ближайшее время.</noindex>
									</div>
								</div>
							</div>
							<div class="row mb-3 mt-5 d-none w-100" role="error">
								<div class="col">
									<div class="p-3 bg-yalightgray c-yablack text-center b-radius-small">
										<noindex>Ой, что-то пошло не так.<br />
										Повторите попытку позднее.</noindex>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>