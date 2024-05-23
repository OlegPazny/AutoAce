const holidaysList = (year) => {
    // Функция для получения даты Пасхи
    const getOrthodoxEaster = (year) => {
        const a = year % 19;
        const b = year % 7;
        const c = year % 4;
        const d = (19 * a + 15) % 30;
        const e = (2 * c + 4 * b + 6 * d + 6) % 7;
        const day = d + e;

        const date = new Date(year, 2, 21); // 21 марта по Юлианскому календарю
        date.setDate(date.getDate() + day + 13); // переводим в Григорианский календарь (+13 дней)
        return date;
    };

    // Получаем дату Радуницы
    const getRadunitsa = (easterDate) => {
        const radunitsa = new Date(easterDate);
        radunitsa.setDate(radunitsa.getDate() + 9); // Радуница через 9 дней после Пасхи
        return radunitsa;
    };

    const orthodoxEaster = getOrthodoxEaster(year);
    const radunitsa = getRadunitsa(orthodoxEaster);

    return [
        { name: "Новый год", date: `${year}-01-01` },
        { name: "Новый год", date: `${year}-01-02` },
        { name: "Рождество Христово (православное)", date: `${year}-01-07` },
        { name: "День женщин", date: `${year}-03-08` },
        { name: "Праздник труда", date: `${year}-05-01` },
        { name: "День Победы", date: `${year}-05-09` },
        { name: "Радуница (православная)", date: radunitsa.toISOString().split('T')[0] },
        { name: "День Независимости Республики Беларусь", date: `${year}-07-03` },
        { name: "День Октябрьской революции", date: `${year}-11-07` },
        { name: "Рождество Христово (католическое)", date: `${year}-12-25` }
    ];
};

// Пример использования
const year = 2024;
const holidays = holidaysList(year);

var serviceId;
var masterId;
var workshopId = $('.workshop_id').val();
// Функция для загрузки списка услуг
function loadServices() {
    $.ajax({
        url: '../assets/api/get_services.php', // Файл PHP для запроса списка услуг
        method: "POST",
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#service').html(response.options);
            //getProcedureDuration();
            $('#service option:eq(1)').prop('selected', true);
            var firstDefaultServiceId = $('#service option:eq(1)').val();
            serviceId = firstDefaultServiceId;
            loadMastersByService(firstDefaultServiceId);
        }
    });
}

function loadMastersByService(serviceId) {
    $.ajax({
        url: '../assets/api/get_workers_by_service.php', // Файл PHP для запроса списка мастеров
        method: 'POST',
        data: {
            serviceId: serviceId,
            workshopId: workshopId
        },
        success: function (response) {
            $('#master').html(response);

            // Автоматически выбираем первого мастера из списка
            $('#master option:first').prop('selected', true);
            var firstDefaultMasterId = $('#master option:first').val();
            masterId = firstDefaultMasterId;
            // Получение записей по первому выбранному мастеру
            getBookingsByMaster(firstDefaultMasterId);
        }
    });
}

// Функция для загрузки списка мастеров в зависимости от выбранной услуги
$('#service').change(function () {
    serviceId = $(this).val();
    loadMastersByService(serviceId);
});

// Функция для получения длительности процедуры из выбранной услуги
function getProcedureDuration() {
    var durationHours = parseFloat($('#service option:selected').attr('data-duration')); // Длительность процедуры в часах
    var durationSlots = Math.ceil(durationHours * 60 / 30); // Количество слотов, из которых состоит процедура
    //console.log("Выбранная в селекте процедура занимает слотов(шт по 30 минут): ", durationSlots);
    return durationSlots;
}

$('#master').change(function () {
    masterId = $(this).val();
    //console.log('Выбранный мастер: ' + masterId);
    getBookingsByMaster(masterId);
});

var workingDayHourStart = parseInt($('.start_hour').val());
var workingDayHourEnd = parseInt($('.end_hour').val());
console.log(workingDayHourStart);
console.log(workingDayHourEnd);

var workingDayPreHolidayHourEnd = workingDayHourEnd - 1;

var workingDayHourEndString = workingDayHourEnd + ":00";
var workingDayHourStartString = "0" + workingDayHourStart + ":00";

// var workingHoursStart = moment().set({ hour: 8, minute: 0, second: 0 }); // Устанавливаем начало рабочего дня на 8:00 утра
//var workingHoursEnd = moment().set({ hour: 18, minute: 0, second: 0 }); // Устанавливаем конец рабочего дня на 18:00

// Функция для получения занятых временных слотов мастера
function getBookingsByMaster(masterId) {
    $.ajax({
        url: '../assets/api/get_bookings_by_master.php', // Файл PHP для запроса списка записей
        method: 'POST',
        data: { masterId: masterId },
        success: function (response) {
            // Обработка полученных записей
            var bookings = JSON.parse(response);
            var busySlots = [];
            //console.log(bookings);
            // Проходимся по каждой записи и добавляем занятые слоты в массив
            for (var i = 0; i < bookings.length; i++) {
                //console.log('i', i);
                var startTime = bookings[i].service_time;
                // Преобразуем время начала записи в формат, понятный FullCalendar
                var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');
                // Вычисляем время окончания записи
                var end;
                var endOnlyToCheck = moment(start).add(bookings[i].duration, 'hours');

                if (!isPreHoliday(start, holidays)) {
                    if (endOnlyToCheck.isAfter(start.clone().endOf('day').set({ hour: workingDayHourEnd, minute: 0, second: 0 }))) {
                        // Получаем количество часов, которые влезают в день начала проведения услуги

                        var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');

                        var hoursInStartDay = Math.abs(moment(start).diff(start.set({ hour: workingDayHourEnd, minute: 0, second: 0 }), 'hours', 'minutes'));

                        var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');

                        //console.log("Если процедура затрагивает не только 1 день, то остаток часов, которые еще влазят в этот день после начала процедуры:");
                        //console.log(hoursInStartDay);


                        // Вычисляем оставшееся количество часов после конца рабочего дня
                        var remainingHours = bookings[i].duration - hoursInStartDay;
                        //console.log("Часы которые переносятся на следующий день/дни:");
                        //console.log(remainingHours);

                        // Вычисляем количество дней, необходимых для выполнения оставшихся часов
                        var days = Math.floor(remainingHours / 10);
                        //console.log(days);

                        // Вычисляем оставшиеся часы после полных дней
                        var remainingHoursInDay = remainingHours % 10;
                        //console.log(remainingHoursInDay);

                        // вычислить end 
                        var end = moment(start).clone();
                        //console.log(end.toString());


                        end.add(days, 'days');
                        //console.log(end.toString());

                        end.add(1, 'day').set({ hour: workingDayHourStart, minute: 0, second: 0 }); // Начинаем с 8 утра
                        //console.log(end.toString());

                        end.add(remainingHoursInDay, 'hours');

                        let remainder = end.minutes() % 30;
                        if (remainder !== 0) {
                            end.add(30 - remainder, 'minutes');
                        }

                        //console.log(end.toString());


                        busySlots.push({ start: start.toString(), end: end.toString() });
                    }
                    // Добавляем оставшееся время, если оно не выходит за пределы рабочего дня
                    else {
                        var end = moment(start).add(bookings[i].duration, 'hours');
                        let remainder = end.minutes() % 30;
                        if (remainder !== 0) {
                            end.add(30 - remainder, 'minutes');
                        }
                        busySlots.push({ start: start.toString(), end: end.toString() });
                    }
                }

                else if (isPreHoliday(start, holidays)) {
                    if (endOnlyToCheck.isAfter(start.clone().endOf('day').set({ hour: workingDayPreHolidayHourEnd, minute: 0, second: 0 }))) {
                        // Получаем количество часов, которые влезают в день начала проведения услуги

                        var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');

                        var hoursInStartDay = Math.abs(moment(start).diff(start.set({ hour: workingDayPreHolidayHourEnd, minute: 0, second: 0 }), 'hours', 'minutes'));

                        var start = moment(bookings[i].service_date + ' ' + startTime, 'YYYY-MM-DD HH:mm:ss');

                        //console.log("Если процедура затрагивает не только 1 день, то остаток часов, которые еще влазят в этот день после начала процедуры:");
                        //console.log(hoursInStartDay);


                        // Вычисляем оставшееся количество часов после конца рабочего дня
                        var remainingHours = bookings[i].duration - hoursInStartDay;
                        //console.log("Часы которые переносятся на следующий день/дни:");
                        //console.log(remainingHours);

                        // Вычисляем количество дней, необходимых для выполнения оставшихся часов
                        var days = Math.floor(remainingHours / 10);
                        //console.log(days);

                        // Вычисляем оставшиеся часы после полных дней
                        var remainingHoursInDay = remainingHours % 10;
                        //console.log(remainingHoursInDay);

                        // вычислить end 
                        var end = moment(start).clone();
                        //console.log(end.toString());


                        end.add(days + 1, 'days');
                        //console.log(end.toString());

                        end.add(1, 'day').set({ hour: workingDayHourStart, minute: 0, second: 0 }); // Начинаем с 8 утра
                        //console.log(end.toString());

                        end.add(remainingHoursInDay, 'hours');

                        let remainder = end.minutes() % 30;
                        if (remainder !== 0) {
                            end.add(30 - remainder, 'minutes');
                        }

                        //console.log(end.toString());


                        busySlots.push({ start: start.toString(), end: end.toString() });
                    }
                    // Добавляем оставшееся время, если оно не выходит за пределы рабочего дня
                    else {
                        var end = moment(start).add(bookings[i].duration, 'hours');
                        let remainder = end.minutes() % 30;
                        if (remainder !== 0) {
                            end.add(30 - remainder, 'minutes');
                        }
                        busySlots.push({ start: start.toString(), end: end.toString() });
                    }
                }

            }
            //console.log('Занятые слоты');
            //console.log(busySlots);
            // Возвращаем массив занятых временных слотов
            defineWorkingHours(busySlots);
        }
    });
}
function removeSubArrays(mainArray) {
    var currentDate = moment();
    for (var i = mainArray.length - 1; i >= 0; i--) {
        var subArray = mainArray[i];
        var shouldRemove = false;
        for (var j = 0; j < subArray.length; j++) {
            var start = moment(subArray[j].start);
            var end = moment(subArray[j].end);
            if (currentDate.isAfter(start) || currentDate.isAfter(end)) {
                shouldRemove = true;
                break;
            }
        }
        if (shouldRemove) {
            mainArray.splice(i, 1);
        }
    }
}

// Функция для проверки вмещения промежутков времени в свободные слоты с учетом продолжения на следующие дни 
function findProcedureSlots(freeSlots, durationSlots) {
    let procedureCombinations = []; // Здесь будем хранить все найденные комбинации
    var workingDayPreHolidayHourEndString = workingDayPreHolidayHourEnd + ":00";
    for (let i = 0; i < freeSlots.length; i++) {
        let currentCombination = []; // Текущая комбинация слотов
        // Проверка продолжительности процедуры
        if (i + durationSlots <= freeSlots.length) {
            var k = 0;
            // Проверяем последовательные слоты
            for (let j = i; j < i + durationSlots - 1; j++) {
                k = k + 1;
                let currentSlotStart = freeSlots[j];
                let nextSlot = freeSlots[j + 1];
                // Проверяем условия для последовательных слотов
                // Условие 1: конец текущего слота совпадает с началом следующего слота
                if ((nextSlot && moment(currentSlotStart.end).isSame(nextSlot.start))) {
                    if (k == durationSlots - 1) {
                        currentCombination.push(currentSlotStart);
                        currentCombination.push(nextSlot);
                        continue;
                    }
                    else {
                        currentCombination.push(currentSlotStart);
                    }
                }
                // Условие 2: конец текущего слота равен 18:00, а начало следующего равно 8:00,  
                // и дата конца текущего слота на один день меньше даты начала следующего слота
                else if ((moment(currentSlotStart.end).format('HH:mm') === workingDayHourEndString && nextSlot && moment(nextSlot.start).format('HH:mm') === workingDayHourStartString && moment(currentSlotStart.end).add(1, 'day').isSame(nextSlot.start, 'day')) ||
                    (moment(currentSlotStart.end).format('HH:mm') === workingDayPreHolidayHourEndString && nextSlot && moment(nextSlot.start).format('HH:mm') === workingDayHourStartString && moment(currentSlotStart.end).add(2, 'day').isSame(nextSlot.start, 'day'))) {
                    if (k == durationSlots - 1) {
                        currentCombination.push(currentSlotStart);
                        currentCombination.push(nextSlot);
                        continue;
                    }
                    else {
                        currentCombination.push(currentSlotStart);
                    }
                }
                else {
                    break; // Прерываем цикл, если условия не выполнены
                }
            }
            // Если длительность процедуры вмещается в найденные последовательные слоты, добавляем комбинацию
            if (currentCombination.length === durationSlots) {
                procedureCombinations.push(currentCombination);
            }
        }
    }
    removeSubArrays(procedureCombinations);
    return procedureCombinations;
}

//чтобы убирать те слоты, где промежуток времени равен 0 минут
function isSlotEmpty(slot) {
    return slot.start !== slot.end;
}

function isHoliday(date, holidays) {
    // Преобразуем дату в формат, который сравнивается с датами праздников в массиве
    const dateString = date.format('YYYY-MM-DD');
    // Проверяем, есть ли дата в списке праздников
    return holidays.some(holiday => holiday.date === dateString);
}

function isPreHoliday(date, holidays) {
    const nextDayisHoliday = moment(date).add(1, 'day').format('YYYY-MM-DD');
    return holidays.some(holiday => holiday.date === nextDayisHoliday);
}

//получаем все свободные слтоты по 30 минут с текущего дня до конца текущего  месяца
function defineWorkingHours(busySlots) {
    busySlots.sort((a, b) => new Date(a.start) - new Date(b.start));
    var currentDate = moment(); // Текущая дата
    var endDate = moment(currentDate).endOf('year');  // Конец этого месяца
    const slotDuration = 30;
    var freeSlots = []; // Массив для хранения свободных промежутков времени
    // Итерация по дням с текущего дня до конца года
    while (currentDate.isBefore(endDate)) {
        var isDayPreHoliday = isPreHoliday(currentDate, holidays);
        if (!isHoliday(currentDate, holidays)) {
            var workDayStartTime = moment(currentDate).set({ hour: workingDayHourStart, minute: 0, second: 0 });
            var workDayEndTime = moment(currentDate).set({ hour: workingDayHourEnd, minute: 0, second: 0 });
            if (isDayPreHoliday) {
                workDayEndTime = moment(currentDate).set({ hour: workingDayPreHolidayHourEnd, minute: 0, second: 0 });
            }
            let currentSlotStart = moment(workDayStartTime);
            while (currentSlotStart.isBefore(workDayEndTime)) {
                let currentSlotEnd = moment(currentSlotStart).add(slotDuration, 'minutes');
                let isSlotFree = true;
                // Перебираем занятые слоты и исключаем их из общего временного диапазона
                for (var i = 0; i < busySlots.length; i++) {
                    var busySlotStart = moment(busySlots[i].start);
                    var busySlotEnd = moment(busySlots[i].end);

                    if (moment(currentSlotEnd).toString() === moment(busySlotStart).toString()) {
                        isSlotFree = true;
                        continue;
                    }
                    // Исключаем занятые слоты из текущего дня
                    else if (
                        (currentSlotStart.isBetween(busySlotStart, busySlotEnd, null, '[)')) ||
                        (currentSlotEnd.isBetween(busySlotStart, busySlotEnd, null, '(]'))
                    ) {
                        isSlotFree = false;
                        break;
                    }
                }
                // Проверяем и добавляем
                if (isSlotFree) {
                    freeSlots.push({
                        start: currentSlotStart.toString(),
                        end: currentSlotEnd.toString()
                    });
                }
                currentSlotStart.add(slotDuration, 'minutes');
            }
        }
        currentDate.add(1, 'day');
    }

    // Шаг 4: Проверка вмещения полученных промежутков времени в свободные слоты работы мастера с учетом продолжения на следующие дни
    var durationSlots = getProcedureDuration(); // Получаем количество слотов, которые занимает процедура
    var procedureCombinations = findProcedureSlots(freeSlots, durationSlots); // Проверяем доступность свободных слотов
    loadCalendar(procedureCombinations);
}

var bookServiceDate;
var bookServiceTime;

$('#book').click(function (event) {
    event.preventDefault();

    if ($('#vehicle')) {
        var vehicle = $('#vehicle').val();
    }

    var booking_message = $('#message').val();
    // Проверяем, был ли отмечен чекбокс
    var checkBoxChecked = $('#book_submit').is(':checked');
    if (!checkBoxChecked) {
        alert('Пожалуйста, дайте согласие на обработку персональных данных');
        return;
    }
    if (!bookServiceDate || !bookServiceTime) {
        alert("Пожалуйста, выберите дату и время записи");
        return;
    }
    if (masterId && serviceId && bookServiceDate && bookServiceTime && vehicle) {

        $.ajax({
            url: '../assets/api/search_worker_service_id.php',
            method: 'POST',
            data: {
                workerId: masterId,
                serviceId: serviceId
            },
            success: function (workerServiceId) {
                //console.log('Найден worker_service_id:', workerServiceId);

                // Вставка записи в таблицу service_bookings
                $.ajax({
                    url: '../assets/api/insert_booking.php',
                    method: 'POST',
                    data: {
                        workerServiceId: workerServiceId,
                        serviceDate: bookServiceDate,
                        serviceTime: bookServiceTime,
                        message: booking_message,
                        vehicleId: vehicle,
                        status: 'pending'
                    },
                    success: function (response) {
                        alert('Запись успешно добавлена');
                        getBookingsByMaster(masterId);

                        $('#message').val('');
                        $('#book_submit').prop('checked', false);
                    },
                    error: function (xhr, status, error) {
                        console.error('Произошла ошибка при записи: ', error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка при поиске механика или услуги: ', error);
            }
        });
    } else if (masterId && serviceId && bookServiceDate && bookServiceTime) {

        $.ajax({
            url: '../assets/api/search_worker_service_id.php',
            method: 'POST',
            data: {
                workerId: masterId,
                serviceId: serviceId
            },
            success: function (workerServiceId) {
                //console.log('Найден worker_service_id:', workerServiceId);

                // Вставка записи в таблицу service_bookings
                $.ajax({
                    url: '../assets/api/insert_booking.php',
                    method: 'POST',
                    data: {
                        workerServiceId: workerServiceId,
                        serviceDate: bookServiceDate,
                        serviceTime: bookServiceTime,
                        message: booking_message,
                        status: 'pending'
                    },
                    success: function (response) {
                        alert('Запись успешно добавлена');
                        getBookingsByMaster(masterId);

                        $('#message').val('');
                        $('#book_submit').prop('checked', false);
                    },
                    error: function (xhr, status, error) {
                        console.error('Произошла ошибка при записи: ', error);
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Произошла ошибка при поиске механика или услуги: ', error);
            }
        });
    }
});

// Функция для загрузки календаря
function loadCalendar(freeSlots) {
    $('#calendar').fullCalendar('destroy'); // Уничтожаем текущий календарь
    $('#calendar').fullCalendar({
        // Настройки календаря
        defaultView: 'month', // Отображение по месяцам
        locale: 'ru', // Устанавливаем русскую локаль
        editable: false,
        eventLimit: true, // Показывать "плюс" при слишком многих событиях
        timezone: 'Europe/Moscow',
        eventClick: function (event, jsEvent, view) {
            // Здесь можно обработать клик по событию в календаре
            // Например, вывести информацию о выбранном событии или открыть модальное окно для записи на услугу
            //console.log('Кликнуто на событие c началом:', event.start.format('YYYY-MM-DD HH:mm'));
            bookServiceDate = event.start.format('YYYY-MM-DD');
            bookServiceTime = event.start.format('HH:mm:00');
            //console.log('bookServiceDate loadCalendar', bookServiceDate);
            //console.log('bookServiceTime loadCalendar', bookServiceTime);

        },
        eventBackgroundColor: "green",
        eventBorderColor: "green",
        timeFormat: 'HH:mm', // Формат времени для событий
        events: function (start, end, timezone, callback) {
            var events = [];
            var monthNames = [
                "января", "февраля", "марта",
                "апреля", "мая", "июня", "июля",
                "августа", "сентября", "октября",
                "ноября", "декабря"
            ];
            freeSlots.forEach(function (slotArray) {
                var slotStart = null;
                var slotEnd = null;
                slotArray.forEach(function (slot, index) {
                    if (index === 0) {
                        slotStart = slot.start;
                    }
                    if (index === slotArray.length - 1) {
                        slotEnd = slot.end;
                    }
                });
                if (slotStart && slotEnd) {
                    var startMoment = moment.utc(slotStart).utcOffset('0000');
                    var endMoment = moment.utc(slotEnd).utcOffset('0000');
                    var formattedSlotEndTitle;
                    if (startMoment.date() !== endMoment.date()) {
                        formattedSlotEndTitle = '- ' + endMoment.format('HH:mm DD') + ' ' + monthNames[endMoment.month()];
                    } else {
                        formattedSlotEndTitle = '- ' + endMoment.format('HH:mm');
                    }
                    events.push({
                        title: formattedSlotEndTitle,
                        start: startMoment,
                        // end: slotEnd,
                    });
                }
            });
            callback(events);
        }
    });

    // Функция для сброса стилей у всех кнопок
    eventClickStyles();
}


function eventClickStyles() {
    function resetStyles() {
        const buttons = document.querySelectorAll('.fc-day-grid-event');
        buttons.forEach(button => {
            button.style.backgroundColor = 'green';
        });
    }

    // Функция для применения стилей к нажатой кнопке
    function applyStylesToClickedButton(button) {
        button.style.backgroundColor = 'gray';
    }

    // Получаем все кнопки с классом 'fc-day-grid-event'
    const buttons = document.querySelectorAll('.fc-day-grid-event');

    // Добавляем обработчик клика для каждой кнопки
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            // Сбрасываем стили у всех кнопок
            resetStyles();
            // Применяем стили к нажатой кнопке
            applyStylesToClickedButton(button);
        });
    });
}

$(document).ready(function () {
    loadServices();

});

$(document).click(function () {
    eventClickStyles();
})