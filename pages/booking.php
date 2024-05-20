<?php
    require_once "../assets/api/db_connect.php";
    $workshopId=$_GET['id'];
    $working_hours=mysqli_query($db, "SELECT `working_hours` FROM `workshops` WHERE `id`=$workshopId");
    $working_hours=mysqli_fetch_assoc($working_hours);

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
        .fc-content{
            display: flex;
        }
    </style>
</head>

<body>
<section class="book-section">
        <form class="callback-form" id="bookingForm">
            <input type="hidden" value="<?php echo $start_hour; ?>" name="start_hour" class="start_hour">
            <input type="hidden" value="<?php echo $end_hour; ?>" name="end_hour" class="end_hour">
            <div>
                <div class="callback-form__inputs-block">

                    <label class="callback-form__label">Станция технического обслуживания</label>
                    <h2 style="color:#fff" name="workshop" value="<?php echo ($_GET['id']); ?>">
                        <?php echo ($workshop_data['name']); ?></h2>


                    <label class="callback-form__label">Услуга</label>



                    <select id="service" name="service"></select>



                    <label class="callback-form__label">Выберите сотрудника</label>



                    <select id="master" name="master"></select>



                </div>
                <div class="callback-form__textarea-block">
                    <label class="callback-form__label">Комментарий к заказу</label>
                    <textarea class="callback-form__textarea" id="message" name="message"></textarea>
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

            <a href="#openModal" class="openModal-btn">
                <div class="callback-form__submit-block button">
                    <p class="callback-form__submit button__content">Выбрать дату и время</p>
                </div>
            </a>

            <div class="callback-form__calendar">
                
            </div>
            <div class="callback-form__submit-check-block">
                <div id="book" class="callback-form__submit-block button">
                    <button id="book" class="callback-form__submit button__content" <?php if (!isset($_SESSION['user']['id'])) {
                        echo ("disabled");
                    } ?>>Записаться</button>
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
    <script src="../assets/js/calendar.js"></script>
</body>

</html>