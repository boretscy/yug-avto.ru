<div class="position-relative">
    <div class="position-absolute bg-yablue blue-form-cover transition-none w-100"></div>
    <div class="container b-radius-yaradius-50 bg-yawhite p-3 p-md-4 p-lg-5">
        <div class="row">
            <div class="col-md-6 col-xl-4">
                <div class="position-relative b-radius-yaradius-25 b-yayellow b-border-2 p-4 h-100">
                    <div class="text-uppercase fw-bold h2" style="position:relative; z-index:10;"><?= $app->Conf()['Forms']['Reserv']['title'];?></div>
                    <div class="w-50 text-uppercase c-yadarkgray mt-4" style="position:relative; z-index:10;"><?= $app->Conf()['Forms']['Reserv']['text'];?></div>
                    <img class="form-img position-absolute" src="<?= $app->Conf()['assetsUrl'];?>/assets/images/forms/reserv-car.jpg?2" />
                </div>
            </div>
            <div class="col-md-6 col-xl-8 ps-md-5 mt-5 mt-md-0">
                <div class="row mt-3 ps-3" style="margin-top: -40px; display: none" role="success"> 
                    <div class="col">
                        <div class="p-3 bg-yalightyellow c-yablack text-center b-radius-small">
                            Спасибо за вашу заявку!<br>
                            Мы свяжемся с Вами в ближайшее время.
                        </div>
                    </div>
                </div>
                <div class="row my-3 ps-3" style="margin-top: -40px; display: none" role="error">
                    <div class="col">
                        <div class="p-3 bg-yalightred c-yablack text-center b-radius-small">
                            Ой, что-то пошло не так.<br>
                            Повторите попытку позднее.
                        </div>
                    </div>
                </div>
                <form class="ps-xl-3" data-mode="<?= $app->Conf()['Api']['mode'];?>">
                    <input type="hidden" name="form" value="Забронировать автомобиль" />
                    <input type="hidden" name="vehicle" value="<?= $data['id'];?>" />
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control b-radius-yaradius-15 px-3" placeholder="Имя *" name="name" required />
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <input type="phone" class="form-control b-radius-yaradius-15 px-3" name="phone"required placeholder="+7 ___ ___ __ __" data-phone-pattern="+7 ___ ___ __ __" maxlength="16">
                            </div>
                        </div>
                        <div class="col-xl-5 mb-3">
                            <div class="form-group">
                                <a 
                                    href="#" rel="nofollow" 
                                    role="not-cover"
                                    class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow form-button"
                                    data-url="<?= $app->Conf()['assetsUrl'];?>/api/"
                                    action="sendShowroomForm"
                                    ><span>Подтвердить бронь</span></a>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="offer-aggry" name="aggry" />
                                <label class="form-check-label text-minus" for="offer-aggry">
                                    Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy/" target="_blank" rel=“nofollow” class="c-yablack c-h-yablack">политикой обработки персональных данных</a> и даю согласие на их обработку
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>