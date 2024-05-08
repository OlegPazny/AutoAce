// Функция для загрузки списка услуг
function loadServices() {
    $.ajax({
        url: 'get_services.php', // Файл PHP для запроса списка услуг
        success: function (response) {
            $('#service').html(response);
            //getProcedureDuration();
        }
    });
}

// Функция для загрузки списка мастеров в зависимости от выбранной услуги
$('#service').change(function () {
    var serviceId = $(this).val();
    //getProcedureDuration();
    $.ajax({
        url: 'get_workers_by_service.php', // Файл PHP для запроса списка мастеров
        method: 'POST',
        data: { serviceId: serviceId },
        success: function (response) {
            $('#master').html(response);

            // Автоматически выбираем первого мастера из списка
            $('#master option:first').prop('selected', true);
            var firstDefaultMasterId = $('#master option:first').val();
            getBookingsByMaster(firstDefaultMasterId);
        }
    });
});

// Функция для получения длительности процедуры из выбранной услуги
function getProcedureDuration() {
    var durationHours = parseFloat($('#service option:selected').attr('data-duration')); // Длительность процедуры в часах
    var durationSlots = Math.ceil(durationHours * 60 / 30); // Количество слотов, из которых состоит процедура
    console.log("Выбранная в селекте процедура занимает слотов(шт по 30 минут): ", durationSlots);
    return durationSlots;
}

$('#master').change(function () {
    var masterId = $(this).val();
    console.log('Выбранный мастер: ' + masterId);
    getBookingsByMaster(masterId);
});


// var workingHoursStart = moment().set({ hour: 8, minute: 0, second: 0 }); // Устанавливаем начало рабочего дня на 8:00 утра
//var workingHoursEnd = moment().set({ hour: 18, minute: 0, second: 0 }); // Устанавливаем конец рабочего дня на 18:00

// Функция для получения занятых временных слотов мастера
function getBookingsByMaster(masterId) {
    $.ajax({
        url: 'get_bookings_by_master.php', // Файл PHP для запроса списка записей
        method: 'POST',
        data: { masterId: masterId },
        success: function (response) {
            // Обработка полученных записей
            var bookings = JSON.parse(response);
            var busySlots = [];
            console.log(bookings);
            // Проходимся по каждой записи и добавляем занятые слоты в массив
            for (var i = 0; i < bookings.length; i++) {

                var startTime = bookings[i].service_time;
                // Преобразуем время начала записи в формат, понятный FullCalendar
                var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');
                // Вычисляем время окончания записи
                var end;
                var endOnlyToCheck = moment(start).add(bookings[i].duration, 'hours'); 

                if (endOnlyToCheck.isAfter(start.clone().endOf('day').set({ hour: 18, minute: 0, second: 0 }))) {
                    // Получаем количество часов, которые влезают в день начала проведения услуги

                    var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');

                    var hoursInStartDay = Math.abs(moment(start).diff(start.set({ hour: 18, minute: 0, second: 0 }), 'hours'));

                    var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');

                    console.log(hoursInStartDay);
                    

                    // Вычисляем оставшееся количество часов после конца рабочего дня
                    var remainingHours = bookings[i].duration - hoursInStartDay;
                    console.log(remainingHours);

                    // Вычисляем количество дней, необходимых для выполнения оставшихся часов
                    var days = Math.floor(remainingHours / 10);
                    console.log(days);

                    // Вычисляем оставшиеся часы после полных днях
                    var remainingHoursInDay = remainingHours % 10;
                    console.log(remainingHoursInDay);

                    // вычислить end 
                    var end = moment(start).clone();
                    console.log(end.toString());

                    
                    end.add(days, 'days');
                    console.log(end.toString());

                    end.add(1, 'day').set({ hour: 8, minute: 0, second: 0 }); // Начинаем с 8 утра
                    console.log(end.toString());

                    end.add(remainingHoursInDay, 'hours');
                    console.log(end.toString());

                    
                    busySlots.push({ start: start.toString(), end: end.toString() });
                }
                // Добавляем оставшееся время, если оно не выходит за пределы рабочего дня
                else {
                    var end = moment(start).add(bookings[i].duration, 'hours');
                    busySlots.push({ start: start.toString(), end: end.toString() });
                }
            }
            console.log(busySlots);
            // Возвращаем массив занятых временных слотов
            defineWorkingHours(busySlots);
        }
    });
}

// Функция для проверки вмещения промежутков времени в свободные слоты с учетом продолжения на следующие дни
function checkSlotAvailability(freeSlots, durationSlots) {
    var availableSlots = []; // Массив для хранения доступных временных слотов

    for (var i = 0; i < freeSlots.length; i++) {
        var startOfDay = moment(freeSlots[i].start);
        var endOfDay = moment(freeSlots[i].end);

        // Проверяем, вмещаются ли в текущий свободный промежуток времени все промежутки процедуры
        if (endOfDay.diff(startOfDay, 'minutes') >= durationSlots * 30) {
            // Если да, добавляем текущий свободный промежуток в список доступных временных слотов
            availableSlots.push({ start: startOfDay.toString(), end: endOfDay.toString() });
        } else {
            // Если нет, проверяем доступность следующих дней
            var remainingDurationSlots = durationSlots - 1; // Уменьшаем количество промежутков на 1, так как текущий день уже учтен
            var nextDay = moment(startOfDay).add(1, 'day').set({ hour: 8, minute: 0, second: 0 }); // Начало следующего дня

            // Пока остались неучтенные промежутки процедуры и есть доступные дни
            while (remainingDurationSlots > 0 && nextDay.isBefore(endOfDay)) {
                var nextDayEnd = moment(nextDay).set({ hour: 18, minute: 0, second: 0 }); // Конец текущего дня

                // Проверяем, вмещаются ли все оставшиеся промежутки процедуры в текущий день
                if (nextDayEnd.diff(nextDay, 'minutes') >= remainingDurationSlots * 30) {
                    // Если да, добавляем текущий день в список доступных временных слотов
                    availableSlots.push({ start: nextDay.toString(), end: nextDayEnd.toString() });

                    // Уменьшаем количество оставшихся промежутков
                    remainingDurationSlots -= nextDayEnd.diff(nextDay, 'minutes') / 30;
                }

                // Переходим к следующему дню
                nextDay = moment(nextDay).add(1, 'day').set({ hour: 8, minute: 0, second: 0 });
            }
        }
    }

    // Возвращаем список доступных временных слотов
    return availableSlots;
}

//чтобы убирать те слоты, где промежуток времени равен 0 минут
function isSlotEmpty(slot) {
    return slot.start !== slot.end;
}

//получаем все свободные слтоты по 30 минут с текущего дня до конца текущего  месяца, учли занятые слоты 
function defineWorkingHours(busySlots) {
     // Шаг 1.1: Определение свободных промежутков времени с учетом всех занятых слотов
     var currentDate = moment(); // Текущая дата
     console.log("Текущая дата:", currentDate.format('YYYY-MM-DD HH:mm:ss'));
 
     // var endDate = moment().endOf('year'); // Конечная дата (конец года)
     // var endDate = moment(currentDate).endOf('month').add(1, 'month'); // Конец следующего месяца
     
     var endDate = moment(currentDate).endOf('month');  // Конец этого месяца
     console.log("Конец следующего месяца:", endDate.format('YYYY-MM-DD HH:mm:ss'));
     
     var freeSlots = []; // Массив для хранения свободных промежутков времени
 
     // Итерация по дням с текущего дня до конца года
     while (currentDate.isBefore(endDate)) {
         // Создаем начальное и конечное время для текущего дня
         var startOfDay = moment(currentDate).set({ hour: 8, minute: 0, second: 0 });
         var endOfDay = moment(currentDate).set({ hour: 18, minute: 0, second: 0 });
 
         // Перебираем занятые слоты и исключаем их из общего временного диапазона
         for (var i = 0; i < busySlots.length; i++) {
             var busyStart = moment(busySlots[i].start);
             var busyEnd = moment(busySlots[i].end);
 
             // Исключаем занятые слоты из текущего дня
             if (busyStart.isSameOrBefore(endOfDay) && busyEnd.isSameOrAfter(startOfDay)) {
                 if (busyStart.isBefore(startOfDay)) {
                     startOfDay = moment(busyEnd);
                 }
                 if (busyEnd.isAfter(endOfDay)) {
                     endOfDay = moment(busyStart);
                 }
             }
         }
 
         // Проверяем, остались ли свободные промежутки времени в текущем дне
         while (startOfDay.isBefore(endOfDay)) {
            var nextSlot = moment.min(endOfDay, moment(startOfDay).add(30, 'minutes')); // Находим следующий свободный промежуток или конец дня
            if (isSlotEmpty({ start: startOfDay.toString(), end: nextSlot.toString() })) {
                freeSlots.push({ start: startOfDay.toString(), end: nextSlot.toString() }); // Добавляем свободный промежуток в массив
            }
            startOfDay = nextSlot; // Переходим к следующему свободному промежутку
        }
 
         // Переходим к следующему дню
         currentDate.add(1, 'day');
     }
 
     // Выводим результаты
     console.log("Свободные промежутки времени с учетом занятых слотов:");
     console.log(freeSlots);

    // Шаг 4: Проверка вмещения полученных промежутков времени в свободные слоты работы мастера с учетом продолжения на следующие дни
    var durationSlots = getProcedureDuration(); // Получаем количество слотов, которые занимает процедура
    var availableSlots = checkSlotAvailability(freeSlots, durationSlots); // Проверяем доступность свободных слотов

    // Выводим результаты
    console.log("Доступные промежутки времени для записи:");
    console.log(availableSlots);
}


// Функция для загрузки календаря
function loadCalendar(workingHours, busySlots) {
    $('#calendar').fullCalendar('destroy'); // Уничтожаем текущий календарь
    $('#calendar').fullCalendar({
        // Настройки календаря
        defaultView: 'month', // Отображение по дням
        editable: false,
        eventLimit: true, // Показывать "плюс" при слишком многих событиях
        // Передаем массив рабочих часов и занятых слотов в параметрах
        workingHours: workingHours,
        busySlots: busySlots
    });
}

// Загружаем список услуг при загрузке страницы
$(document).ready(function () {
    loadServices();
});