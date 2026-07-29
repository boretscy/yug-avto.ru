<div class="remodal text-start" data-remodal-id="credit-modal">
	<button data-remodal-action="close" class="remodal-close"></button>
    <div class="row mt-3" style="margin-top: -40px; display: none" role="success"> 
		<div class="col">
			<div class="p-3 bg-yalightyellow c-yablack text-center  b-radius-yaradius-15">
				Спасибо за вашу заявку!<br>
				Мы свяжемся с Вами в ближайшее время.
			</div>
		</div>
	</div>
    <div class="row my-3" style="margin-top: -40px; display: none" role="error">
		<div class="col">
			<div class="p-3 bg-yalightred c-yablack text-center  b-radius-yaradius-15">
				Ой, что-то пошло не так.<br>
				Повторите попытку позднее.
			</div>
		</div>
	</div>
    <form data-mode="<?= $app->Conf()['Api']['mode'];?>">
        <input type="hidden" name="form" value="Заявка на кредит" />
        <input type="hidden" name="vehicle" value="<?= $data['id'];?>" />
        <div class="row">
            <div class="col-12 mb-3">
                <h2 class="fw-bold">
                    Заявка на кредит 
                    <span>
                        <?php if ( $filter['vehicle'] ) { ?>
                        на <?= $data['brand']['name'];?> <?= $data['model']['name'];?> <?= (($data['equipment'])?:'');?>
                        <?php } ?>
                    </span>
                </h2>
            </div>
            <div class="col-12 mb-3">
                <p>Рассчитаем персональное предложение по кредиту.</p>
            </div>
            <div class="col-12 mb-3">
                <div class="form-group">
                    <input type="text" class="form-control bg-yalightbluegray" placeholder="Имя *" name="name" required />
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-group">
                    <input type="phone" class="form-control bg-yalightbluegray" name="phone"required placeholder="+7 ___ ___ __ __" data-phone-pattern="+7 ___ ___ __ __" maxlength="16">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <a 
                        href="#" rel="nofollow" 
                        role="not-cover"
                        class="d-block b-radius-yaradius-16 bg-yayellow bg-h-yadarkyellow py-3 text-center c-yablack c-h-yablack text-decoration-none text-normal" 
                        data-url="<?= $app->Conf()['assetsUrl'];?>/api/"
                        action="sendShowroomForm"
                        >Отправить</a>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="showroom-credit-aggry" name="aggry" />
                    <label class="form-check-label text-minus-minus" for="showroom-credit-aggry">
                        Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy/" target="_blank" rel=“nofollow” class="c-yablack c-h-yablack">политикой обработки персональных данных</a> и даю согласие на их обработку
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>