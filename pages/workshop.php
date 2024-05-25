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
                <div class="about-workshop-section__container__img__main" style="background-image: url(<?php echo $workshop_data['photo'];?>)">
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
    <?php require_once "booking.php"?>
    <?php require_once "../includes/footer.php"; ?>
</body>
<script src="../assets/js/workshop_location.js"></script>
<script src="../assets/js/book.js"></script>
<script>
    window.scrollTo(0, 0);
            //Получаем ссылку для открытия модального окна
    var openModalLink = document.querySelector('a[href="#openModal"]');

    // Получаем ссылку для закрытия модального окна
    var closeModalLink = document.querySelector('.modalpopup .close');

    // Получаем модальное окно
    var modal = document.getElementById('openModal');

    // Получаем высоту прокрутки страницы перед открытием модального окна
    var scrollTopPos = 0;

    // Обработчик клика по ссылке для открытия модального окна
    openModalLink.addEventListener('click', function(e) {
        // Запоминаем текущую позицию прокрутки страницы
        scrollTopPos = window.pageYOffset || document.documentElement.scrollTop;
        // Прокручиваем страницу вверх
        window.scrollTo(0, 0);
        document.body.style.overflowY = "hidden";
        // // Добавляем класс, чтобы показать модальное окно
    });

    // // Обработчик клика по ссылке для закрытия модального окна
    closeModalLink.addEventListener('click', function() {
        // Прокручиваем страницу к позиции, которая была до открытия модального окна
        window.scrollTo(0, scrollTopPos);
        document.body.style.overflowY = "auto";
    });

    // Обработчик клика по фону модального окна для его закрытия
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            // Прокручиваем страницу к позиции, которая была до открытия модального окна
            window.scrollTo(0, scrollTopPos);
        }
    });
    </script>

</html>