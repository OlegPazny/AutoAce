<?php
require_once "../assets/api/db_connect.php";
session_start();
if(isset($_SESSION['user'])){
    $userId = $_SESSION['user']['id'];
    $user_vehicles = mysqli_query($db, "SELECT `id`, `brand`, `num_plate` FROM `vehicles` WHERE `user_id`=$userId");
}
$workshopId = $_GET['id'];



$working_hours = mysqli_query($db, "SELECT `working_hours` FROM `workshops` WHERE `id`=$workshopId");
$working_hours = mysqli_fetch_assoc($working_hours);

// Разделяем строку по тире
list($start_time, $end_time) = explode("-", $working_hours['working_hours']);

// Разделяем время начала и окончания по двоеточию и берем только часы
$start_hour = explode(":", $start_time)[0];
$end_hour = explode(":", $end_time)[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Подключаем библиотеку jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Подключаем FullCalendar -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Подключаем FullCalendar -->

    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/ru.js"></script>
    <style>
        .fc-content {
            display: flex;
        }
    </style>
</head>

<body>
    <section class="book-section">
        <form id="bookingForm" class="booking-form">
            <input type="hidden" value="<?php echo $_GET['id'];?>" name="workshop_id" class="workshop_id">
            <input type="hidden" value="<?php echo $start_hour; ?>" name="start_hour" class="start_hour">
            <input type="hidden" value="<?php echo $end_hour; ?>" name="end_hour" class="end_hour">
            <div class="booking-form__data-block">
                <div class="booking-form__data-block__selects">
                    <label>Услуга</label>
                    <select id="service" name="service"></select>

                    <label>Выберите сотрудника</label>
                    <select id="master" name="master"></select>

                    <?php if (isset($user_vehicles) && mysqli_num_rows($user_vehicles) > 0) {
                        $user_vehicles = mysqli_fetch_all($user_vehicles); ?>
                        <label>Выберите автомобиль</label>
                        <select id="vehicle" name="vehicle">
                            <?php
                            foreach ($user_vehicles as $vehicle) {
                                echo ("<option value='" . $vehicle[0] . "'>" . $vehicle[1] . " " . $vehicle[2] . "</option>");
                            }
                            ?>
                        </select>
                    <?php }else if(!isset($userId)){ ?>
                        <label>Почта</label>
                        <input type="email" id="record_email" class="record_email">
                    <?php } ?>
                </div>
                <div class="booking-form__data-block__comment">
                    <label>Комментарий к заказу</label>
                    <textarea id="message" name="message"></textarea>
                </div>
            </div>
            <div id="openModal" class="modalpopup">
                <div class="modalpopup-dialog">
                    <div class="modalpopup-content">
                        <div class="modalpopup-header">
                            <h3 class="modalpopup-title">Выбор времени и даты</h3>
                            <a href="#close" title="Close" class="close">×</a>
                        </div>
                        <div class="modalpopup-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-form__controls-block">
                <div class="booking-form__controls-block__btns-block">
                    <a href="#openModal" class="openModal-btn">
                        <div class="callback-form__submit-block button">
                            <p class="callback-form__submit button__content">Дата</p>
                        </div>
                    </a>

                    <div id="book" class="callback-form__submit-block button">
                        <p id="book" class="callback-form__submit button__content">Записаться</p>
                    </div>
                </div>
                <div class="booking-form__submit-check-block">
                    <div class="booking-form__checkbox-block">
                        <input type="checkbox" class="booking-form__checkbox" id="book_submit">
                        <label class="booking-form__checkbox-label">Я даю согласие на обработку персональных
                            данных</label>
                    </div>
                </div>
            </div>

        </form>
        <div class="form-shadow1"></div>
        <div class="form-shadow2"></div>
    </section>
    
    <?php require_once "../includes/popup.php"; ?>
    <script src="../assets/js/calendar.js"></script>
    <script>

    </script>
</body>

</html>