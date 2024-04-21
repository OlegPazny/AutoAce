<?php
session_start();

require_once "../assets/api/isAdmin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery connection -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jQuery/3.3.1/jQuery.min.js"></script>
    <!-- jQuery connection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>главная</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="offers-section">
        <div class="swiper mySwiper1">
            <div class="swiper-wrapper">
                <div class="swiper-slide car-maintenance-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">техническое обслуживание автомобиля</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?
                            Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев?
                        </p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="car-maintenance-slide__image" src="../assets/images/main_slider1.png">
                        <div class="slide-shadow1"></div>
                        <div class="slide-shadow2"></div>
                    </div>
                </div>
                <div class="swiper-slide brake-system-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">ремонт тормозной системы</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?</p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="brake-system-slide__image" src="../assets/images/main_slider2.png">
                        <div class="slide-shadow3"></div>
                    </div>
                </div>
                <div class="swiper-slide car-maintenance-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">техническое обслуживание автомобиля</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?
                            Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев?
                        </p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="car-maintenance-slide__image" src="../assets/images/main_slider1.png">
                        <div class="slide-shadow1"></div>
                        <div class="slide-shadow2"></div>
                    </div>
                </div>
                <div class="swiper-slide brake-system-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">ремонт тормозной системы</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?</p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="brake-system-slide__image" src="../assets/images/main_slider2.png">
                        <div class="slide-shadow3"></div>
                    </div>
                </div>
                <div class="swiper-slide car-maintenance-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">техническое обслуживание автомобиля</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?
                            Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев?
                        </p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="car-maintenance-slide__image" src="../assets/images/main_slider1.png">
                        <div class="slide-shadow1"></div>
                        <div class="slide-shadow2"></div>
                    </div>
                </div>
                <div class="swiper-slide brake-system-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">ремонт тормозной системы</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?</p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="brake-system-slide__image" src="../assets/images/main_slider2.png">
                        <div class="slide-shadow3"></div>
                    </div>
                </div>
                <div class="swiper-slide car-maintenance-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">техническое обслуживание автомобиля</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?
                            Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев?
                        </p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="car-maintenance-slide__image" src="../assets/images/main_slider1.png">
                        <div class="slide-shadow1"></div>
                        <div class="slide-shadow2"></div>
                    </div>
                </div>
                <div class="swiper-slide brake-system-slide">
                    <div class="offers-slider-elem">
                        <h2 class="offers-slider-elem__head">ремонт тормозной системы</h2>
                        <p class="offers-slider-elem__text">Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру
                            сгенерировать несколько абзацев?</p>
                        <div class="button">
                            <input type="button" class="button__content" value="Записаться на ремонт">
                        </div>
                        <img class="brake-system-slide__image" src="../assets/images/main_slider2.png">
                        <div class="slide-shadow3"></div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <section class="prons-section">
        <h2 class="prons-section__head"> мы это —</h2>
        <div class="prons-section__body">
            <div class="pron">
                <h5 class="pron__head">Профессиональные мастера</h5>
                <p class="pron__text">
                    Наши мастера осуществляют качественный ремонт и обслуживание вашего автомобиля с использованием передовых технологий и лучших практик в автомобильной индустрии.
                </p>
                <img class="pron__img" src="../assets/images/pron_arrow.png">
            </div>
            <img class="prons-section__img" src="../assets/images/wrench.png">
            <div class="bottom-prons">
                <div class="pron">
                    <img class="pron__img up" src="../assets/images/pron_arrow.png">
                    <h5 class="pron__head">Индивидуальный подход</h5>
                    <p class="pron__text">
                    Мы работаем с каждым клиентом индивидуально, чтобы полностью удовлетворить его потребности.
                    </p>
                </div>
                <div class="pron">
                    <img class="pron__img up" src="../assets/images/pron_arrow.png">
                    <h5 class="pron__head">Современное оборудование</h5>
                    <p class="pron__text">
                    Мы используем передовое оборудование для точной диагностики и эффективного ремонта вашего автомобиля.
                    </p>
                </div>
            </div>
        </div>
        <div class="prons-section__shadow1"></div>
        <div class="prons-section__shadow2"></div>
    </section>
    <section class="about-section">
        <div class="info">
            <h2 class="info__head">о сети AutoAce</h2>
            <p class="info__text">
                Добро пожаловать в AutoAce – ваш надежный партнер в мире автомобильного обслуживания и ремонта. Мы
                являемся престижным автосервисом, где каждый клиент может рассчитывать на высокое качество услуг и
                профессиональный подход к решению любых задач. Наша команда специалистов обладает богатым опытом работы
                с автомобилями всех марок и моделей, готовых воплотить в жизнь любые задумки по уходу за вашим
                транспортным средством. Независимо от того, нужен ли вам технический осмотр, регулярное техобслуживание
                или качественный ремонт – AutoAce всегда готов предложить вам исключительный сервис и индивидуальный
                подход к вашему автомобилю. Доверьте нам заботу о вашем авто, и мы сделаем все возможное, чтобы ваши
                дорогие вам машины всегда оставались в идеальном состоянии.
            </p>
            <div class="button">
                <input type="button" class="button__content" value="Перейти к услугам">
            </div>
        </div>
        <div class="slider">
            <swiper-container class="mySwiper" effect="cards" grab-cursor="true">
                <swiper-slide><img class="swiper-img" src="../assets/images/slider1.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider2.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider3.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider4.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider5.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider6.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider7.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider8.jpg"></swiper-slide>
                <swiper-slide><img class="swiper-img" src="../assets/images/slider9.jpg"></swiper-slide>
            </swiper-container>
            <div class="slider__shadow"></div>
        </div>
    </section>
    <section class="discount-offers-section">
        <h2 class="discount-offers-section__head">Выгодные<br>предложения</h2>
        <container class="discount-offers-section__slider">
            <section class="discount-offers-section__slider__scetion">
                <div class="swiper2 mySwiper2 container">
                    <div class="swiper-wrapper content">
                        <div class="swiper-slide card">
                            <h5 class="card__head">скидка</h5>
                            <h3 class="card__discount">10%</h3>
                            <p class="card__description">Замена банки выхлопа</p>
                            <div class="slider-button">
                                <input type="button" class="slider-button__content" value="Записаться">
                            </div>
                            <div class="slider__shadow"></div>
                        </div>
                        <div class="swiper-slide card">
                            <h5 class="card__head">скидка</h5>
                            <h3 class="card__discount">30%</h3>
                            <p class="card__description">Замена сцепления</p>
                            <div class="slider-button">
                                <input type="button" class="slider-button__content" value="Записаться">
                            </div>
                            <div class="slider__shadow"></div>
                        </div>
                        <div class="swiper-slide card">
                            <h5 class="card__head">скидка</h5>
                            <h3 class="card__discount">30%</h3>
                            <p class="card__description">Озонирование салона</p>
                            <div class="slider-button">
                                <input type="button" class="slider-button__content" value="Записаться">
                            </div>
                            <div class="slider__shadow"></div>
                        </div>
                        <div class="swiper-slide card">
                            <h5 class="card__head">скидка</h5>
                            <h3 class="card__discount">50%</h3>
                            <p class="card__description">Диагностика подвески</p>
                            <div class="slider-button">
                                <input type="button" class="slider-button__content" value="Записаться">
                            </div>
                            <div class="slider__shadow"></div>
                        </div>
                        <div class="swiper-slide card">
                            <h5 class="card__head">скидка</h5>
                            <h3 class="card__discount">15%</h3>
                            <p class="card__description">Реставрация дисков</p>
                            <div class="slider-button">
                                <input type="button" class="slider-button__content" value="Записаться">
                            </div>
                            <div class="slider__shadow"></div>
                        </div>
                        <div class="swiper-slide card">
                            <h5 class="card__head">скидка</h5>
                            <h3 class="card__discount">25%</h3>
                            <p class="card__description">Комплексный шиномонтаж</p>
                            <div class="slider-button">
                                <input type="button" class="slider-button__content" value="Записаться">
                            </div>
                            <div class="slider__shadow"></div>
                        </div>
                        <div class="swiper-slide card">
                            <h5 class="card__head">скидка</h5>
                            <h3 class="card__discount">5%</h3>
                            <p class="card__description">Ремонт<br>шин</p>
                            <div class="slider-button">
                                <input type="button" class="slider-button__content" value="Записаться">
                            </div>
                            <div class="slider__shadow"></div>
                        </div>
                    </div>
                </div>
            </section>
        </container>
    </section>
    <section class="callback-section">
        <h2 class="callback-section__head">
            остались вопросы?
        </h2>
        <div class="callback-section__block">
            <form class="callback-form">
                <div>
                    <div class="callback-form__inputs-block">
                        <label class="callback-form__label">Имя</label>
                        <input class="callback-form__input" type="text" name="name">
                        <label class="callback-form__label">Почта</label>
                        <input class="callback-form__input" type="email" name="email">
                    </div>
                    <div class="callback-form__textarea-block">
                        <label class="callback-form__label">Текст сообщения</label>
                        <textarea class="callback-form__textarea" name="message"></textarea>
                    </div>
                </div>
                <div class="callback-form__submit-check-block">
                    <div class="callback-form__submit-block button">
                        <input type="submit" class="callback-form__submit button__content" value="отправить">
                    </div>
                    <div class="callback-form__checkbox-block">
                        <input type="checkbox" class="callback-form__checkbox">
                        <label class="callback-form__checkbox-label">Я даю согласие на обработку персональных
                            данных</label>
                    </div>
                </div>

            </form>
            <div class="form-shadow1"></div>
            <div class="form-shadow2"></div>
        </div>
    </section>
    <?php require_once "../includes/footer.php"; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper1 = new Swiper(".mySwiper1", {
        slidesPerView: 2,
        slidesPerGroup: 2,
        grid: {
            rows: 1,
        },
        spaceBetween: 1,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
    var swiper2 = new Swiper(".mySwiper2", {
        slidesPerView: 3,
        spaceBetween: 135,
        slidesPerGroup: 3,
        loop: false,
        grabCursor: false,
        loopFillGroupWithBlank: true,
    });
</script>
<script src="../assets/js/callback.js"></script>
<script src="../assets/js/index.js"></script>

</html>