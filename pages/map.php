<?php
require_once "../assets/api/get_services_script.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
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
        <div class="filter-block">
            <form id="filterForm">
                <?php
                echo ("<ul class='filter-block__headlist'>");
                foreach ($services_arr as $service_type => $services) {
                    echo ("<li class='filter-block__headlist__service-type'>" . $service_type);
                    echo ("<ul class='filter-block__list'>");
                    foreach ($services as $service) {
                        echo ("<li class='filter-block__list__service'><input type='checkbox' name='services' value='" . $service['id'] . "'>" . $service['name'] . "&nbsp<b>" . $service['price'] . "&nbspр.</b></li>");
                    }
                    echo ("</ul>");
                    echo ("</li>");
                }
                echo ("</ul>");
                ?>
            </form>
        </div>
        <div class="map-block">
            <div id="map"></div>
        </div>
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
<script src="../assets/js/map_init.js"></script>
<script src="../assets/js/workshops_filter.js"></script>
<script src="../assets/js/callback.js"></script>

</html>