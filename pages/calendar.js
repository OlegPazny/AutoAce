$(document).ready(function() {
    var calendarEl = $('#calendar');
    var selectedService = $('#service').val(); // Получаем начальное значение услуги
    var selectedWorker = $('#worker').val(); // Получаем начальное значение работника

    // Функция для обновления календаря с учетом выбранной услуги и работника
    function updateCalendar() {
        // Проверяем, выбраны ли услуга и работник
        if (selectedService && selectedWorker) {
            // Отправляем AJAX-запрос на сервер для получения доступных слотов времени
            $.ajax({
                type: 'POST',
                url: 'calendar_script.php',
                data: {
                    service: selectedService,
                    worker: selectedWorker
                },
                success: function(response) {
                    // Преобразуем полученный ответ в объект JavaScript
                    var availableSlots = JSON.parse(response);
                    // Удаляем все источники событий из календаря
                    calendar.removeAllEventSources();
                    // Добавляем новый источник событий с доступными слотами времени в календарь
                    calendar.addEventSource(availableSlots);
                },
                error: function(xhr, status, error) {
                    alert('Произошла ошибка при получении доступных слотов: ' + error);
                }
            });
        }
    }

    var calendar = new FullCalendar.Calendar(calendarEl[0], {
        // Настройки календаря...

        // Обработчик выбора временного слота
        select: function(info) {
            // Функция обновления календаря при выборе временного слота
            updateCalendar();
        }
    });

    calendar.render();

    // Обработчик изменения значения в поле услуги
    $('#service').change(function() {
        // Обновляем выбранную услугу
        selectedService = $(this).val();
        // Вызываем функцию обновления календаря
        updateCalendar();
    });

    // Обработчик изменения значения в поле работника
    $('#worker').change(function() {
        // Обновляем выбранного работника
        selectedWorker = $(this).val();
        // Вызываем функцию обновления календаря
        updateCalendar();
    });
});
