// Обработчик клика на кнопке информации
$(document).ready(function () {
    var info_btn = $('.info-btn');
    var orders_btn = $('.orders-btn');
    var history_btn = $('.history-btn');
    var services_btn = $('.services-btn');
    var infoContainer = $('.accounts');
    var ordersContainer = $('.orders');
    var historyContainer = $('.history');
    var servicesContainer = $('.services');
    $('.info-btn').on('click', function () {
        ordersContainer.fadeOut();
        historyContainer.fadeOut();
        servicesContainer.fadeOut();

        info_btn.css("background", "#fff");
        info_btn.css("color", "#232323");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");
        services_btn.css("background", "#232323");
        services_btn.css("color", "#fff");

        // Проверяем, видим ли блок #answers-container
        if (ordersContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            ordersContainer.hide();

        }
        if (historyContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            historyContainer.hide();
        }
        if (servicesContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            servicesContainer.hide();
        }

        infoContainer.fadeIn('slow'); // Показываем блок #answers-container
    })

    // Обработчик клика на кнопке заказов

    $('.orders-btn').on('click', function () {
        infoContainer.fadeOut();
        historyContainer.fadeOut();
        servicesContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#fff");
        orders_btn.css("color", "#232323");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");
        services_btn.css("background", "#232323");
        services_btn.css("color", "#fff");

        // Проверяем, видим ли блок #answers-container
        if (infoContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            infoContainer.hide();

        }
        if (historyContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            historyContainer.hide();
        }
        if (servicesContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            servicesContainer.hide();
        }

        ordersContainer.fadeIn('slow'); // Показываем блок #answers-container

    })

    // Обработчик клика на кнопке истории

    $('.history-btn').on('click', function () {
        infoContainer.fadeOut();
        ordersContainer.fadeOut();
        servicesContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#fff");
        history_btn.css("color", "#232323");
        services_btn.css("background", "#232323");
        services_btn.css("color", "#fff");

        // Проверяем, видим ли блок #answers-container
        if (infoContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            infoContainer.hide();

        }
        if (ordersContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            ordersContainer.hide();
        }
        if (servicesContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            servicesContainer.hide();
        }

        historyContainer.fadeIn('slow'); // Показываем блок #answers-container

    })
    // Обработчик клика на кнопке добавления услуги

    $('.services-btn').on('click', function () {
        infoContainer.fadeOut();
        ordersContainer.fadeOut();
        historyContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");
        services_btn.css("background", "#fff");
        services_btn.css("color", "#232323");

        // Проверяем, видим ли блок #answers-container
        if (infoContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            infoContainer.hide();

        }
        if (ordersContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            ordersContainer.hide();
        }
        if (historyContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            historyContainer.hide();
        }

        servicesContainer.fadeIn('slow'); // Показываем блок #answers-container

    })
    //блокировка пользователя
    var blockButtons = document.querySelectorAll('.block-user');
    blockButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var userId = this.getAttribute('data-user-id');
            deleteUser(userId, button); // Передаем ссылку на кнопку вместе с userId
        });
    });
    function deleteUser(userId, button) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var userRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                    userRow.parentNode.removeChild(userRow);
                } else {
                    console.error('Произошла ошибка при удалении пользователя');
                }
            }
        };
        xhr.open('POST', '../assets/api/block_user_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('user_id=' + userId);
    }
    //изменение статуса заказа 

    var statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(function (select) {
        select.addEventListener('change', function () {
            var bookingId = this.getAttribute('data-booking-id');
            var newStatus = this.value;
            updateStatus(bookingId, newStatus);
        });
    });

    function updateStatus(bookingId, newStatus) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Обработка успешного ответа
                } else {
                    console.error('Произошла ошибка при обновлении статуса заказа');
                }
            }
        };
        xhr.open('POST', '../assets/api/update_status_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('booking_id=' + bookingId + '&new_status=' + newStatus);
    }
    //изменение статуса заказа из истории заказов

    var statusSelects = document.querySelectorAll('.history-status-select');
    statusSelects.forEach(function (select) {
        select.addEventListener('change', function () {
            var bookingId = this.getAttribute('data-booking-id');
            var newStatus = this.value;
            updateStatus(bookingId, newStatus);
        });
    });

    function updateStatus(bookingId, newStatus) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Обработка успешного ответа
                } else {
                    console.error('Произошла ошибка при обновлении статуса заказа');
                }
            }
        };
        xhr.open('POST', '../assets/api/update_status_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('booking_id=' + bookingId + '&new_status=' + newStatus);
    }
    //добавление услуги
    $('.add-service-button').click(function () {
        var serviceName = $('#service_name').val();
        var serviceDescription = $('#service_description').val();
        var servicePrice = $('#service_price').val();
        var serviceType = $('#service_type').val();

        $.ajax({
            type: 'POST',
            url: '../assets/api/add_service_script.php',
            data: {
                service_name: serviceName,
                service_description: serviceDescription,
                service_price: servicePrice,
                service_type: serviceType
            },
            success: function (response) {
                console.log('Услуга успешно добавлена!');
                // Очищаем поля ввода после успешной отправки
                $('#service_name').val('');
                $('#service_description').val('');
                $('#service_price').val('');
            },
            error: function (xhr, status, error) {
                // Обработка ошибки AJAX-запроса
                console.error(xhr.responseText);
            }
        });
    });
    //удаление услуги
    var deleteButtons = document.querySelectorAll('.delete-service');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var serviceId = this.getAttribute('data-service-id');
            deleteService(serviceId, button); // Передаем ссылку на кнопку вместе с userId
        });
    });
    function deleteService(serviceId, button) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var serviceRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                    serviceRow.parentNode.removeChild(serviceRow);
                } else {
                    console.error('Произошла ошибка при удалении услуги');
                }
            }
        };
        xhr.open('POST', '../assets/api/delete_service_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('service_id=' + serviceId);
    }
});