<?php
session_start();
if(isset($_SESSION['workshop_id'])){
    unset($_SESSION['workshop_id']);
}
$_SESSION['workshop_id']=$_GET['id'];
require_once "../assets/api/get_workshop_data_script.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery connection -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- jQuery connection -->
    <!-- leaflet connection -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- leaflet connection -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>Автосервис</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="about-workshop-section">
        <div class="about-workshop-section__container">
            <div class="about-workshop-section__container__img">
                <div class="about-workshop-section__container__img__main">

                </div>
                <div class="about-workshop-section__container__img__secondary">
                    <div class="about-workshop-section__container__img__secondary__img">

                    </div>
                    <div class="about-workshop-section__container__img__secondary__img">

                    </div>
                </div>
            </div>
            <div class="about-workshop-section__container__info">
                <h2 class="about-workshop-section__container__info__head">Название станции</h2>
                <div class="about-workshop-section__container__info__services-block">
                    <?php foreach ($services_arr as $service_type => $services) {
                        echo ("<div class='list-container'>");
                        echo ("<h3 class='list-container__head'>" . $service_type . "</h3>");
                        echo ("<ul>");
                        foreach ($services as $service) {
                            echo ("<li>" . $service['name'] . "</li>");
                        }
                        echo ("</ul>");
                        echo ("</div>");
                    } ?>
                </div>
                <h3 class="about-workshop-section__container__info__description-head">описание</h3>
                <p class="about-workshop-section__container__info__description">Сайт рыбатекст поможет дизайнеру, верстальщику,
                    вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а
                    начинающему оратору отточить навык публичных выступлений в домашних условиях. При создании
                    генератора мы использовали небезизвестный универсальный код речей.</p>
            </div>
        </div>
    </section>
    <section class="map-section">
        <h2 class="map-section__head">мы на карте</h2>
        <div class="map-block">
            <div id="map"></div>
        </div>
    </section>
    <section class="book-section">
        <form class="callback-form" id="bookingForm">
            <input type="hidden" value="<?php echo $_GET['id'];?>" name="hash" class="hash">
            <div>
                <div class="callback-form__inputs-block">

                    <label class="callback-form__label">Станция технического обслуживания</label>
                    <select id="workshop" name="workshop">
                        <option name="workshop" value="<?php echo($_GET['id']);?>">мастерская</option>
                    </select>

                    <label class="callback-form__label">Услуга</label>
                    <select id="service" name="service">
                        <option selected disabled>Выберите услугу</option>
                        <?php foreach ($services_arr as $service_type => $services) {
                            echo ("<option disabled>" . $service_type . "</option>");
                            foreach ($services as $service) {
                                echo ("<option value='".$service['id']."'>" . $service['name'] . "</option>");
                            }
                        } ?>
                    </select>
                </div>
                <div class="callback-form__textarea-block">
                    <label class="callback-form__label">Комментарий к заказу</label>
                    <textarea class="callback-form__textarea" id="message" name="message"></textarea>
                </div>
            </div>
            <div class="callback-form__submit-check-block">
                <div class="callback-form__submit-block button">
                    <input type="submit" class="callback-form__submit button__content" value="Записаться">
                </div>
                <div class="callback-form__checkbox-block">
                    <input type="checkbox" class="callback-form__checkbox" id="book_submit">
                    <label class="callback-form__checkbox-label">Я даю согласие на обработку персональных
                        данных</label>
                </div>
            </div>

        </form>
        <div class="form-shadow1"></div>
        <div class="form-shadow2"></div>
    </section>
    <?php require_once "../includes/footer.php"; ?>
</body>
<script src="../assets/js/workshop_location.js"></script>
<script src="../assets/js/book.js"></script>
</html>