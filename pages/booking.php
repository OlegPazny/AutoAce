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
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/ru.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <style>
        .fc-content{
            display: flex;
        }
    </style>
</head>

<body>
<section class="book-section">
        <form class="callback-form" id="bookingForm">
            <input type="hidden" value="<?php echo $_GET['id']; ?>" name="hash" class="hash">
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
            <div id="openModal" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Выбор времени и даты</h3>
                        <a href="#close" title="Close" class="close">×</a>
                    </div>
                    <div class="modal-body">    
                        <div id="calendar"></div>
                    </div>
                    </div>
                </div>
            </div>
            <a href="#openModal">Выбрать дату и время</a>
            <div class="callback-form__calendar">
                
            </div>
            <div class="callback-form__submit-check-block">
                <div id="book" class="callback-form__submit-block button">
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
    <!-- <form id="bookingForm">
            <div id="calendar"></div>
            <a id="book">Записаться</a>
    </form> -->

    <script src="../assets/js/calendar.js"></script>
</body>

</html>