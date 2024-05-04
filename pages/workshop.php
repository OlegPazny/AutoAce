<?php
session_start();
if (isset($_SESSION['workshop_id'])) {
    unset($_SESSION['workshop_id']);
}
$_SESSION['workshop_id'] = $_GET['id'];
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
                    <div class="about-workshop-section__container__img__secondary__img second">

                    </div>
                    <div class="about-workshop-section__container__img__secondary__img third">

                    </div>
                </div>
            </div>
            <div class="about-workshop-section__container__info">
                <h2 class="about-workshop-section__container__info__head"><?php echo ($workshop_data['name']); ?></h2>
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
                <h3 class="about-workshop-section__container__info__description-head">адрес</h3>
                <p class="about-workshop-section__container__info__description"><?php echo ($workshop_data['address']); ?>
                </p>
                <h3 class="about-workshop-section__container__info__description-head">время работы</h3>
                <p class="about-workshop-section__container__info__description">
                    <?php echo ($workshop_data['working_hours']); ?></p>
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
            <input type="hidden" value="<?php echo $_GET['id']; ?>" name="hash" class="hash">
            <div>
                <div class="callback-form__inputs-block">

                    <label class="callback-form__label">Станция технического обслуживания</label>
                    <h2 style="color:#fff" name="workshop" value="<?php echo ($_GET['id']); ?>">
                        <?php echo ($workshop_data['name']); ?></h2>


                    <label class="callback-form__label">Услуга</label>
                    <select id="service" name="service">
                        <option selected disabled>Выберите услугу</option>
                        <?php foreach ($services_arr as $service_type => $services) {
                            echo ("<option disabled class='disabled-option'>" . $service_type . "</option>");
                            foreach ($services as $service) {
                                echo ("<option class='service-option' data-service-price='" . $service['price'] . "' value='" . $service['id'] . "'>" . $service['name'] . "</option>");
                            }
                        } ?>
                    </select>
                    <label class="callback-form__label">Выберите сотрудника</label>
                    <select id="worker" name="worker"></select>
                </div>
                <div class="callback-form__textarea-block">
                    <label class="callback-form__label">Комментарий к заказу</label>
                    <textarea class="callback-form__textarea" id="message" name="message"></textarea>
                </div>
                <div class="calendar-block">
                <input type="hidden" id="currentMonth" value="<?php echo date('n'); ?>">
<input type="hidden" id="currentDay" value="<?php echo date('j'); ?>">
                <div class="controls">
        <select class="month-select" id="month">
            <option value="0">Январь</option>
            <option value="1">Февраль</option>
            <option value="2">Март</option>
            <option value="3">Апрель</option>
            <option value="4">Май</option>
            <option value="5">Июнь</option>
            <option value="6">Июль</option>
            <option value="7">Август</option>
            <option value="8">Сентябрь</option>
            <option value="9">Октябрь</option>
            <option value="10">Ноябрь</option>
            <option value="11">Декабрь</option>
        </select>
        <input type="number" id="year" min="1900" max="2100" step="1" value="2024">
    </div>

    <table id="calendar">
        <thead>
            <tr>
                <th colspan="7" id="month-year"></th>
            </tr>
            <tr>
                <th>Пн</th>
                <th>Вт</th>
                <th>Ср</th>
                <th>Чт</th>
                <th>Пт</th>
                <th>Сб</th>
                <th>Вс</th>
            </tr>
        </thead>
        <tbody id="calendar-body">
        </tbody>
    </table>
                </div>
            </div>
            <div class="callback-form__submit-check-block">
                <div class="callback-form__submit-block button">
                    <input type="submit" class="callback-form__submit button__content" value="Записаться" <?php if (!isset($_SESSION['user']['id'])) {
                        echo ("disabled");
                    } ?>>
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