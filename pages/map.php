<?php
session_start();
require_once "../assets/api/get_services_script.php";
$working_hours = mysqli_query($db, "SELECT
MIN(TIME(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', 1), '%H:%i'))) AS min_opening_time, 
MAX(TIME(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', -1), '%H:%i'))) AS max_closing_time, 
MAX(TIME(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', 1), '%H:%i'))) AS max_opening_time, 
MIN(TIME(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', -1), '%H:%i'))) AS min_closing_time
FROM workshops;");
$working_hours = mysqli_fetch_assoc($working_hours);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/favicon.svg" />
    <meta name="description"
        content="Добро пожаловать в AutoAce – сеть автомастерских, где качество и надежность на первом месте! Наши профессиональные механики обеспечат ваш автомобиль всем необходимым для безупречной работы. От обслуживания до ремонта, мы предлагаем полный спектр услуг по доступным ценам. Найдите ближайший к вам автосервис AutoAce и доверьте свой автомобиль в надежные руки!" />
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.2/nouislider.css" rel="stylesheet">
    <!-- jQuery connection -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jQuery/3.3.1/jQuery.min.js"></script>
    <!-- jQuery connection -->
    <!-- leaflet connection -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- leaflet connection -->

    <title>Выбор автосервиса</title>
</head>
<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="search-section">
    <div class="burger-menu">
    <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 16 16"><path fill="#232323" d="M6 9.5A2 2 0 0 1 7.937 11H13.5a.5.5 0 0 1 .09.992L13.5 12l-5.563.001a2 2 0 0 1-3.874 0L2.5 12a.5.5 0 0 1-.09-.992L2.5 11h1.563A2 2 0 0 1 6 9.5m4-7A2 2 0 0 1 11.937 4H13.5a.5.5 0 0 1 .09.992L13.5 5l-1.563.001a2 2 0 0 1-3.874 0L2.5 5a.5.5 0 0 1-.09-.992L2.5 4h5.563A2 2 0 0 1 10 2.5"/></svg>
    </div>
        <div class="filter-block">
            <form id="filterForm" class="filterForm">
                <ul class='filter-block__headlist'>
                    <?php
                    foreach ($services_arr as $service_type => $services) {
                        echo "<li class='filter-block__headlist__service-type'>";
                        echo "<span class='accordion'>" . $service_type . "</span>"; // Используем span вместо кнопки
                        echo "<ul class='filter-block__list' style='display:none'>";
                        foreach ($services as $service) {
                            echo "<li class='filter-block__list__service'>";
                            echo "<label><input type='checkbox' name='services' value='" . $service['id'] . "'>" . $service['name']."</label>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</li>";
                    }
                    ?>
                </ul>
                <div class="filterForm__time-filter">
                    <div id="working-hours-slider"></div>
                    <div class="filterForm__time-filter__block">
                        <input type="text" id="start-time" readonly>
                        <input type="text" id="end-time" readonly>
                    </div>
                </div>

            </form>
        </div>
        <div class="map-block">
            <div id="map"></div>
        </div>
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
    <?php require_once "../includes/popup.php"; ?>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.2/nouislider.js"></script>
<script src="../assets/js/workshops_filter.js"></script>
<script src="../assets/js/callback.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var burgerMenu = document.querySelector('.burger-menu');
    var filterBlock = document.querySelector('.filter-block');

    burgerMenu.addEventListener('click', function() {
        filterBlock.classList.toggle('open');
        burgerMenu.classList.toggle('open');
    });
});
</script>
</html>