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
    
    // Получаем ссылку на элемент <select> для услуги и работника
    const serviceSelect = document.getElementById("service");
    const workerSelect = document.getElementById("worker");

    // Слушаем изменения в выборе услуги
    serviceSelect.addEventListener("change", async function() {
        // Получаем выбранное значение услуги
        const selectedServiceId = serviceSelect.value;
        
        // Очищаем список работников
        workerSelect.innerHTML = '<option selected disabled>Выберите работника</option>';
        
        if (selectedServiceId) {
            try {
                // Отправляем асинхронный запрос на сервер для получения работников, предоставляющих выбранную услугу
                const response = await fetch(`../assets/api/get_worker_data_script.php?service_id=${selectedServiceId}`);
                const workers = await response.json();
                // Обновляем список работников в <select>
                workers.forEach(worker => {
                    console.log(worker);
                    const option = document.createElement('option');
                    option.value = worker[1];
                    option.textContent = worker[0];
                    workerSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Ошибка при получении данных о работниках:', error);
            }
        }
    });
});
