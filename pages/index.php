<?php
session_start();

require_once "../assets/api/isAdmin.php";
require_once "../assets/api/index_info_script.php";
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/favicon.svg" />
    <meta name="description"
        content="Добро пожаловать в AutoAce – сеть автомастерских, где качество и надежность на первом месте! Наши профессиональные механики обеспечат ваш автомобиль всем необходимым для безупречной работы. От обслуживания до ремонта, мы предлагаем полный спектр услуг по доступным ценам. Найдите ближайший к вам автосервис AutoAce и доверьте свой автомобиль в надежные руки!" />

    <!-- jQuery connection -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jQuery/3.3.1/jQuery.min.js"></script>
    <!-- jQuery connection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>Сеть AutoAce</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="offers-section">
        <div class="swiper mySwiper1">
            <div class="swiper-wrapper">
                <div class="swiper-slide offer-slide">
                    <div class="offers-slider-elem">
                        <div class="offers-slider-elem__info">
                            <h2 class="offers-slider-elem__head">техническое обслуживание автомобиля</h2>
                            <p class="offers-slider-elem__text">Плановое техническое обслуживание рекомендуется
                                проводить в соответствии с регламентом производителя автомобиля, что обычно указывается
                                в руководстве по эксплуатации. Это обеспечивает оптимальную работу всех систем
                                автомобиля и помогает сохранить гарантию на него.
                            </p>
                            <div class="button to-map">
                                <input type="button" class="button__content" value="Записаться на ремонт">
                            </div>
                        </div>
                        <img class="offer-slide__image" src="../assets/images/main_slider1.png">
                        <div class="slide-shadow1"></div>
                        <div class="slide-shadow2"></div>
                    </div>
                </div>
                <div class="swiper-slide offer-slide">
                    <div class="offers-slider-elem">
                        <div class="offers-slider-elem__info">
                            <h2 class="offers-slider-elem__head">ремонт тормозной системы</h2>
                            <p class="offers-slider-elem__text">Регулярный ремонт и обслуживание тормозной системы не
                                только продлевают срок службы автомобиля, но и обеспечивают вашу безопасность и
                                безопасность ваших пассажиров на дороге. Поэтому
                                своевременный ремонт тормозной системы — это залог надежной и безопасной эксплуатации
                                вашего автомобиля.
                            </p>
                            <div class="button to-map">
                                <input type="button" class="button__content" value="Записаться на ремонт">
                            </div>
                        </div>
                        <img class="offer-slide__image" src="../assets/images/main_slider2.png">
                        <div class="slide-shadow1"></div>
                        <div class="slide-shadow2"></div>
                    </div>
                </div>
                <div class="swiper-slide offer-slide">
                    <div class="offers-slider-elem">
                        <div class="offers-slider-elem__info">
                            <h2 class="offers-slider-elem__head">комплексный шиномонтаж</h2>
                            <p class="offers-slider-elem__text">Комплексный шиномонтаж также может включать проверку
                                состояния дисков и их очистку, что помогает предотвратить коррозию и улучшить внешний
                                вид колес. Специалисты могут порекомендовать наиболее подходящие шины для вашего
                                автомобиля, исходя из стиля вождения и условий эксплуатации.
                            </p>
                            <div class="button to-map">
                                <input type="button" class="button__content" value="Записаться на ремонт">
                            </div>
                        </div>
                        <img class="offer-slide__image" src="../assets/images/main_slider3.png">
                        <div class="slide-shadow1"></div>
                        <div class="slide-shadow2"></div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <section class="prons-section">
        <h2 class="prons-section__head">Мы это —</h2>
        <div class="prons-section__body">
            <div class="pron">
                <h5 class="pron__head">Профессиональные мастера</h5>
                <p class="pron__text">
                    Наши мастера осуществляют качественный ремонт и обслуживание вашего автомобиля с использованием
                    передовых технологий и лучших практик в автомобильной индустрии.
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
                        Мы используем передовое оборудование для точной диагностики и эффективного ремонта вашего
                        автомобиля.
                    </p>
                </div>
            </div>
        </div>
        <div class="prons-section__shadow1"></div>
        <div class="prons-section__shadow2"></div>
    </section>
    <section class="about-section">
        <div class="info">
            <h2 class="info__head">О сети AutoAce</h2>
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
            <div class="button to-map">
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
                        <?php
                        foreach ($discounts as $discount) {
                            echo "
                                    <div class='swiper-slide discount-card card'>
                                        <h5 class='card__head'>" . $discount[1] . "</h5>
                                        <h3 class='card__discount'>-" . $discount[2] . "%</h3>
                                        <a href='./map.php?discount_service_id=" . $discount[0] . "'>
                                            <div class='slider-button'>
                                                <input type='button' class='slider-button__content' value='Записаться'>
                                            </div>
                                        </a>
                                        <div class='slider__shadow'></div>
                                    </div>
                                ";
                        }
                        ?>
                    </div>
                </div>
            </section>
        </container>
    </section>
    <section class="callback-section">
        <h2 class="callback-section__head">
            Остались вопросы?
        </h2>
        <div class="callback-section__block">
            <form class="callback-form">
                <div>
                    <div class="callback-form__inputs-block">
                        <label class="callback-form__label">Имя</label>
                        <input class="callback-form__input" type="text" name="callback_name">
                        <label class="callback-form__label">Почта</label>
                        <input class="callback-form__input" type="email" name="callback_email">
                    </div>
                    <div class="callback-form__textarea-block">
                        <label class="callback-form__label">Текст сообщения</label>
                        <textarea class="callback-form__textarea" name="callback_message"></textarea>
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
        slidesPerView: 1,
        slidesPerGroup: 1,
        loop: true,
        grid: {
            rows: 1,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        spaceBetween: 1,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
    var swiper2 = new Swiper(".mySwiper2", {
        slidesPerView: 3.5,
        spaceBetween: 100,
        loop: false,
        grabCursor: false,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        effect: 'slide',
        centerInsufficientSlides: true,
        centeredSlidesBounds: true,
        breakpoints: {
            // when window width is >= 320px
            0: {
            slidesPerView: 1.8,
            spaceBetween: 5
            },
            414: {
            slidesPerView: 2.3,
            spaceBetween: 10
            },
            834: {
            slidesPerView: 2.2,
            spaceBetween: 20
            },
            // when window width is >= 480px
            1280: {
            slidesPerView: 2.5,
            spaceBetween: 50
            },
            // when window width is >= 640px
            1500: {
            slidesPerView: 3.5,
            spaceBetween: 100
            }
        }
    });
</script>
<script src="../assets/js/callback.js"></script>
<script src="../assets/js/index.js"></script>

</html>