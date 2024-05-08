<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на услугу</title>
    <!-- Подключаем библиотеку jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Подключаем FullCalendar -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
</head>

<body>
    <h1>Запись на услугу</h1>
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
    </form>

    <script src="calendarLera.js"></script>
    <!-- Скрипт для получения длительности услуги и списка мастеров -->
</body>

</html>