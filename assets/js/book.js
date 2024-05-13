$(document).ready(function () {
    $('#bookingForm').submit(function (e) {
        e.preventDefault();

        var checkboxChecked = $('.callback-form__checkbox').is(':checked');

        if (!checkboxChecked) {
            // Если чекбокс не отмечен, выводим сообщение об ошибке
            alert('Пожалуйста, отметьте чекбокс "Я даю согласие на обработку персональных данных".');
            return;
        }
        // Получаем цену выбранной услуги
        var servicePrice = $('#service option:selected').data('service-price');

        // Собираем данные формы, включая цену услуги
        var formData = $(this).serialize() + '&service_price=' + servicePrice;

        // Отправляем AJAX запрос на сервер
        $.ajax({
            type: 'POST',
            url: '../assets/api/book_script.php',
            data: formData,
            success: function (response) {
                // Обработка успешного ответа от сервера
                console.log('Данные успешно отправлены!');
                $('textarea[name="message"]').val('');
                $('.callback-form__checkbox').prop('checked', false);
            },
            error: function (xhr, status, error) {
                // Обработка ошибок при отправке запроса
                console.error(xhr.responseText);
                console.log("ошибка");
            }
        });
    

    });
    
    // // Получаем ссылку на элемент <select> для услуги и работника
    // const serviceSelect = document.getElementById("service");
    // const workerSelect = document.getElementById("worker");

    // // Слушаем изменения в выборе услуги
    // serviceSelect.addEventListener("change", async function() {
    //     // Получаем выбранное значение услуги
    //     const selectedServiceId = serviceSelect.value;
        
    //     // Очищаем список работников
    //     workerSelect.innerHTML = '<option selected disabled>Выберите работника</option>';
        
    //     if (selectedServiceId) {
    //         try {
    //             // Отправляем асинхронный запрос на сервер для получения работников, предоставляющих выбранную услугу
    //             const response = await fetch(`../assets/api/get_worker_data_script.php?service_id=${selectedServiceId}`);
    //             const workers = await response.json();
    //             // Обновляем список работников в <select>
    //             workers.forEach(worker => {
    //                 console.log(worker);
    //                 const option = document.createElement('option');
    //                 option.value = worker[1];
    //                 option.textContent = worker[0];
    //                 workerSelect.appendChild(option);
    //             });
    //         } catch (error) {
    //             console.error('Ошибка при получении данных о работниках:', error);
    //         }
    //     }
    // });
    // //календарь
    // function updateCalendar() {
    //     const monthSelect = document.getElementById('month');
    //     const yearInput = document.getElementById('year');
    //     const monthYear = document.getElementById('month-year');
    //     const calendarBody = document.getElementById('calendar-body');

    //     const monthIndex = parseInt(monthSelect.value);
    //     const year = parseInt(yearInput.value);

    //     const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();
    //     const firstDayOfMonth = new Date(year, monthIndex, 1).getDay();

    //     calendarBody.innerHTML = '';
    //     monthYear.textContent = `${monthSelect.options[monthIndex].text} ${year}`;

    //     let date = 1;
    //     let row = document.createElement('tr');

    //     // Устанавливаем начальное значение дня недели
    //     let currentDay = firstDayOfMonth === 0 ? 7 : firstDayOfMonth;

    //     for (let i = 1; i < currentDay; i++) {
    //         const cell = document.createElement('td');
    //         cell.textContent = '';
    //         row.appendChild(cell);
    //     }

    //     for (let i = 0; i < daysInMonth; i++) {
    //         const cell = document.createElement('td');
    //         cell.textContent = date;
    //         row.appendChild(cell);

    //         currentDay++;

    //         if (currentDay > 7) {
    //             calendarBody.appendChild(row);
    //             row = document.createElement('tr');
    //             currentDay = 1;
    //         }

    //         date++;
    //     }

    //     // Завершаем последний ряд
    //     if (currentDay !== 1) {
    //         for (let i = currentDay; i <= 7; i++) {
    //             const cell = document.createElement('td');
    //             cell.textContent = '';
    //             row.appendChild(cell);
    //         }
    //         calendarBody.appendChild(row);
    //     }
    // }

    // document.getElementById('month').addEventListener('change', updateCalendar);
    // document.getElementById('year').addEventListener('change', updateCalendar);
    // updateCalendar();
});
