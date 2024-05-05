<?php
$worker_id = 1;
$service_id = 5;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календарь</title>
    <style>
        table {
            width: 300px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        th[colspan="7"] {
            background-color: #ddd;
        }

        .controls {
            margin-bottom: 10px;
        }

        .month-select {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="calendar-block">
        <div class="controls">
            <select class="month-select" id="month">
                <option value="0">Январь</option>
                <option value="1">Февраль</option>
                <option value="2">Март</option>
                <option value="3">Апрель</option>
                <option value="4">Май</option>
                <option value="5">Июнь</option>
                <option value="6">Июль</option>
                <option value="7">Август</option>
                <option value="8">Сентябрь</option>
                <option value="9">Октябрь</option>
                <option value="10">Ноябрь</option>
                <option value="11">Декабрь</option>
            </select>
            <input type="number" id="year" min="1900" max="2100" step="1" value="<?php echo date('Y'); ?>">
        </div>

        <table id="calendar">
            <thead>
                <tr>
                    <th colspan="7" id="month-year"></th>
                </tr>
                <tr>
                    <th>Пн</th>
                    <th>Вт</th>
                    <th>Ср</th>
                    <th>Чт</th>
                    <th>Пт</th>
                    <th>Сб</th>
                    <th>Вс</th>
                </tr>
            </thead>
            <tbody id="calendar-body">
            </tbody>
        </table>
    </div>
    <div id="available-slots"></div>
    <script>
        function updateCalendar() {
            const monthSelect = document.getElementById('month');
            const yearInput = document.getElementById('year');
            const monthYear = document.getElementById('month-year');
            const calendarBody = document.getElementById('calendar-body');

            const currentDate = new Date();
            const currentMonth = currentDate.getMonth();
            const currentYear = currentDate.getFullYear();

            const monthIndex = parseInt(monthSelect.value) || currentMonth;
            const year = parseInt(yearInput.value) || currentYear;

            const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();
            const firstDayOfMonth = new Date(year, monthIndex, 1).getDay();

            calendarBody.innerHTML = '';
            monthYear.textContent = `${monthSelect.options[monthIndex].text} ${year}`;

            let date = 1;
            let row = document.createElement('tr');

            // Устанавливаем начальное значение дня недели
            let currentDay = firstDayOfMonth === 0 ? 7 : firstDayOfMonth;

            for (let i = 1; i < currentDay; i++) {
                const cell = document.createElement('td');
                cell.textContent = '';
                row.appendChild(cell);
            }

            for (let i = 0; i < daysInMonth; i++) {
                const cell = document.createElement('td');
                cell.textContent = date;

                // Добавляем обработчик клика на дату
                cell.addEventListener('click', handleDateClick);

                row.appendChild(cell);

                currentDay++;

                if (currentDay > 7) {
                    calendarBody.appendChild(row);
                    row = document.createElement('tr');
                    currentDay = 1;
                }

                date++;
            }

            // Завершаем последний ряд
            if (currentDay !== 1) {
                for (let i = currentDay; i <= 7; i++) {
                    const cell = document.createElement('td');
                    cell.textContent = '';
                    row.appendChild(cell);
                }
                calendarBody.appendChild(row);
            }
        }

        document.getElementById('month').addEventListener('change', updateCalendar);
        document.getElementById('year').addEventListener('change', updateCalendar);
        updateCalendar();

        // Устанавливаем выбранный месяц по умолчанию
        const currentMonth = new Date().getMonth();
        document.getElementById('month').value = currentMonth;

        function handleDateClick(event) {
            const selectedDay = parseInt(event.target.textContent) + 1;
            const selectedMonth = parseInt(document.getElementById('month').value) + 1; // Увеличиваем месяц на 1, так как в JavaScript месяцы начинаются с 0
            const selectedYear = document.getElementById('year').value;

            // Создаем объект Date с выбранной датой
            const selectedDate = new Date(selectedYear, selectedMonth - 1, selectedDay);

            // Форматируем дату в строку YYYY-MM-DD
            const formattedDate = selectedDate.toISOString().split('T')[0];
            console.log('Выбранная дата:', formattedDate); // Выводим выбранную дату для отладки

            const timestamp = Date.now();
            fetch(`../assets/api/get_available_slots.php?date=${formattedDate}&timestamp=${timestamp}`)
                .then(response => response.json())
                .then(slots => {
                    console.log('Доступные слоты времени:', slots); // Выводим доступные слоты времени для отладки
                    // Обновляем интерфейс, отображая доступные слоты времени
                    displayAvailableSlots(selectedDate, slots); // Передаем выбранную дату и доступные слоты времени
                })
                .catch(error => {
                    console.error('Ошибка при получении доступных слотов времени:', error);
                });
        }



        function displayAvailableSlots(selectedDate, slots) {
            // Используйте selectedDate для получения года, месяца и дня, если это необходимо
            const year = selectedDate.getFullYear();
            const month = selectedDate.getMonth() + 1;
            const day = selectedDate.getDate();
            // Получаем уже занятые слоты времени для выбранной даты
            fetch(`../assets/api/get_booked_slots.php?date=${year}-${month}-${day}`)
                .then(response => response.json())
                .then(bookedSlots => {
                    // Формируем занятые временные диапазоны
                    const busyRanges = bookedSlots.map(slot => {
                        const start = new Date(slot.start_time);
                        const end = new Date(slot.end_time);
                        return [start, end];
                    });

                    // Отображаем доступные слоты времени
                    const slotsContainer = document.getElementById('available-slots');
                    slotsContainer.innerHTML = '';

                    const slotsList = document.createElement('ul');

                    // Создаем доступные временные слоты (например, каждые 30 минут)
                    const startTime = new Date(year, month - 1, day, 9, 0); // Начало рабочего дня
                    const endTime = new Date(year, month - 1, day, 17, 0); // Конец рабочего дня
                    const timeIncrement = 30 * 60 * 1000; // 30 минут в миллисекундах

                    for (let time = startTime; time < endTime; time.setTime(time.getTime() + timeIncrement)) {
                        const slotStart = new Date(time);
                        const slotEnd = new Date(time.getTime() + timeIncrement);

                        // Проверяем, свободен ли текущий слот времени
                        const isSlotAvailable = !busyRanges.some(range => {
                            const [start, end] = range;
                            return slotStart < end && slotEnd > start;
                        });

                        if (isSlotAvailable) {
                            const slotItem = document.createElement('li');
                            slotItem.textContent = `${slotStart.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} - ${slotEnd.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                            slotsList.appendChild(slotItem);
                        }
                    }

                    // Если есть доступные слоты времени, добавляем их в контейнер
                    if (slotsList.childElementCount > 0) {
                        slotsContainer.appendChild(slotsList);
                    } else {
                        slotsContainer.textContent = 'Нет доступных слотов времени';
                    }
                })
                .catch(error => {
                    console.error('Ошибка при получении занятых слотов времени:', error);
                });
        }

    </script>
</body>

</html>