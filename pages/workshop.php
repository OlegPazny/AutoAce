<?php
require_once "../assets/api/db_connect.php";
session_start();
// Проверка, если параметр не передался или содержит некорректные символы
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: ./map.php');
    exit;
} else {
    $current_workshop_id = (int)$_GET['id']; // Преобразование параметра к целому числу для дополнительной безопасности
}

// Проверка, если не существует такого id
$query = "SELECT * FROM `workshops` WHERE id = $current_workshop_id";
$result = mysqli_query($db, $query);

if (mysqli_num_rows($result) > 0) {
    if (isset($_SESSION['workshop_id'])) {
        unset($_SESSION['workshop_id']);
    }
    $_SESSION['workshop_id'] = $current_workshop_id;
} else {
    header('Location: ./map.php');
    exit;
}

require_once "../assets/api/get_workshop_data_script.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/favicon.svg" />
    <meta name="description"
        content="Добро пожаловать в AutoAce – сеть автомастерских, где качество и надежность на первом месте! Наши профессиональные механики обеспечат ваш автомобиль всем необходимым для безупречной работы. От обслуживания до ремонта, мы предлагаем полный спектр услуг по доступным ценам. Найдите ближайший к вам автосервис AutoAce и доверьте свой автомобиль в надежные руки!" />
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
                <div class="about-workshop-section__container__img responsive-workshop-img">
                    <div class="about-workshop-section__container__img__main" style="background-image: url(<?php echo $workshop_data['photo'];?>)">
                    </div>
                </div>
                <div class="about-workshop-section__container__info__services-block">
                    <?php foreach ($services_arr as $service_type => $services) {
                        echo ("<div class='list-container'>");
                        echo ("<h3 class='list-container__head'>" . $service_type . "</h3>");
                        echo ("<ul>");
                        foreach ($services as $service) {
                            echo ("<li title='".$service['description']."'>" . $service['name'] . "</li>");
                        }
                        echo ("</ul>");
                        echo ("</div>");
                    } ?>
                </div>
                <h3 class="about-workshop-section__container__info__description-head">Адрес</h3>
                <p class="about-workshop-section__container__info__description"><?php echo ($workshop_data['address']); ?>
                </p>
                <h3 class="about-workshop-section__container__info__description-head">Время работы</h3>
                <p class="about-workshop-section__container__info__description">
                    <?php echo ($workshop_data['working_hours']); ?></p>
            </div>
        </div>
    </section>
    <section class="map-section">
        <h2 class="map-section__head">Мы на карте</h2>
        <div class="map-block">
            <div id="map"></div>
        </div>
    </section>
    <?php require_once "booking.php"?>
    <?php require_once "../includes/footer.php"; ?>
</body>
<script src="../assets/js/workshop_location.js"></script>
<script src="../assets/js/calendar_modal.js"></script>

</html>