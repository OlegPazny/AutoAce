<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на услугу</title>
    <!-- Подключаем библиотеку jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Подключаем FullCalendar -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Подключаем FullCalendar -->
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
    <form id="bookingForm">
        <label for="service">Выберите услугу:</label>
        <select name="service" id="service">
            <!-- Здесь будут варианты услуг -->
        </select><br><br>

        <label for="master">Выберите мастера:</label>
        <select name="master" id="master">
            <!-- Здесь будут варианты мастеров -->
        </select><br><br>

            <!-- Добавляем элемент для календаря -->
            <div id="calendar"></div>
            <a id="book">Записаться</a>
    </form>

    <script src="../assets/js/calendar.js"></script>
</body>

</html>