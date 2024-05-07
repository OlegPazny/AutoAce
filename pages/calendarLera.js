  // Функция для загрузки списка услуг
  function loadServices() {
    $.ajax({
        url: 'get_services.php', // Файл PHP для запроса списка услуг
        success: function (response) {
            $('#service').html(response);
        }
    });
}

// Функция для загрузки списка мастеров в зависимости от выбранной услуги
$('#service').change(function () {
    var serviceId = $(this).val();
    $.ajax({
        url: 'get_workers_by_service.php', // Файл PHP для запроса списка мастеров
        method: 'POST',
        data: { serviceId: serviceId },
        success: function (response) {
            $('#master').html(response);

            // Автоматически выбираем первого мастера из списка
            $('#master option:first').prop('selected', true);

            loadCalendar();

        }
    });
});

$('#master').change(function () {

    loadCalendar();
});

// Функция для получения занятых временных слотов мастера
function getBookingsByMaster(masterId) {
    $.ajax({
        url: 'get_bookings_by_master.php', // Файл PHP для запроса списка записей
        method: 'POST',
        data: { masterId: masterId },
        success: function(response) {
            // Обработка полученных записей
            var bookings = JSON.parse(response);
            var busySlots = [];
            // Проходимся по каждой записи и добавляем занятые слоты в массив
            for (var i = 0; i < bookings.length; i++) {
                var startTime = bookings[i].service_time;
                // Преобразуем время начала записи в формат, понятный FullCalendar
                var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss').toISOString();
                // Вычисляем время окончания записи
                var end = moment(start).add(bookings[i].duration, 'minutes').toISOString();
                // Добавляем занятый временной слот в массив
                busySlots.push({ start: start, end: end });
            }
            // Возвращаем массив занятых временных слотов
            return busySlots;
        }
    });
}

// Функция для загрузки календаря
function loadCalendar() {
    var masterId = $('#master').val();
    getBookingsByMaster(masterId);
    $('#calendar').fullCalendar('destroy'); // Уничтожаем текущий календарь
    $('#calendar').fullCalendar({
        // Настройки календаря
        defaultView: 'month', // Отображение по дням
        editable: false,
        eventLimit: true, // Показывать "плюс" при слишком многих событиях
        events: function(start, end, timezone, callback) {
            // Получаем id выбранного мастера
            var masterId = $('#master').val();
            $.ajax({
                url: 'get_bookings_by_master.php', // Файл PHP для запроса списка записей
                method: 'POST',
                data: {masterId: masterId},
                success: function(response) {
                    // Обработка полученных записей
                    var bookings = JSON.parse(response);
                    console.log(bookings);
                    // var events = [];
                    // // Преобразуем записи в формат, понятный FullCalendar
                    // for (var i = 0; i < bookings.length; i++) {
                    //     events.push({
                    //         id: bookings[i].id,
                    //         title: 'Запись на услугу',
                    //         start: bookings[i].service_date + 'T' + bookings[i].service_time, // Формат: 2024-05-07T09:00:00
                    //         end: bookings[i].service_date + 'T' + bookings[i].service_time, // Для простоты, конец события совпадает с началом
                    //         color: '#378006' // Цвет события
                    //     });
                    // }
                    // callback(events);
                }
            });
        }
    });
}
// Загружаем список услуг при загрузке страницы
$(document).ready(function () {
    loadServices();
});