// Обработчик клика на кнопке информации
$(document).ready(function () {
    var info_btn = $('.info-btn');
    var orders_btn = $('.orders-btn');
    var history_btn = $('.history-btn');
    var services_btn = $('.services-btn');
    var relations_btn = $('.relations-btn');
    var infoContainer = $('.accounts');
    var ordersContainer = $('.orders');
    var historyContainer = $('.history');
    var servicesContainer = $('.services');
    var relationsContainer = $('.relations');
    $('.info-btn').on('click', function () {
        ordersContainer.fadeOut();
        historyContainer.fadeOut();
        servicesContainer.fadeOut();
        relationsContainer.fadeOut();

        info_btn.css("background", "#fff");
        info_btn.css("color", "#232323");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");
        services_btn.css("background", "#232323");
        services_btn.css("color", "#fff");
        relations_btn.css("background", "#232323");
        relations_btn.css("color", "#fff");

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
        if (relationsContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            relationsContainer.hide();
        }

        infoContainer.fadeIn('slow'); // Показываем блок #answers-container
    })

    // Обработчик клика на кнопке заказов

    $('.orders-btn').on('click', function () {
        infoContainer.fadeOut();
        historyContainer.fadeOut();
        servicesContainer.fadeOut();
        relationsContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#fff");
        orders_btn.css("color", "#232323");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");
        services_btn.css("background", "#232323");
        services_btn.css("color", "#fff");
        relations_btn.css("background", "#232323");
        relations_btn.css("color", "#fff");

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
        if (relationsContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            relationsContainer.hide();
        }

        ordersContainer.fadeIn('slow'); // Показываем блок #answers-container

    })

    // Обработчик клика на кнопке истории

    $('.history-btn').on('click', function () {
        infoContainer.fadeOut();
        ordersContainer.fadeOut();
        servicesContainer.fadeOut();
        relationsContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#fff");
        history_btn.css("color", "#232323");
        services_btn.css("background", "#232323");
        services_btn.css("color", "#fff");
        relations_btn.css("background", "#232323");
        relations_btn.css("color", "#fff");

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
        if (relationsContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            relationsContainer.hide();
        }

        historyContainer.fadeIn('slow'); // Показываем блок #answers-container

    })
    // Обработчик клика на кнопке добавления услуги

    $('.services-btn').on('click', function () {
        infoContainer.fadeOut();
        ordersContainer.fadeOut();
        historyContainer.fadeOut();
        relationsContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");
        services_btn.css("background", "#fff");
        services_btn.css("color", "#232323");
        relations_btn.css("background", "#232323");
        relations_btn.css("color", "#fff");

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
        if (relationsContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            relationsContainer.hide();
        }

        servicesContainer.fadeIn('slow'); // Показываем блок #answers-container

    })
    //блок отношений
    $('.relations-btn').on('click', function () {
        infoContainer.fadeOut();
        ordersContainer.fadeOut();
        historyContainer.fadeOut();
        servicesContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");
        services_btn.css("background", "#232323");
        services_btn.css("color", "#fff");
        relations_btn.css("background", "#fff");
        relations_btn.css("color", "#232323");

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
        if (servicesContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            servicesContainer.hide();
        }

        relationsContainer.fadeIn('slow'); // Показываем блок #answers-container

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
        var serviceDiscount = $('#service_discount').val();

        $.ajax({
            type: 'POST',
            url: '../assets/api/add_service_script.php',
            data: {
                service_name: serviceName,
                service_description: serviceDescription,
                service_price: servicePrice,
                service_type: serviceType,
                service_discount: serviceDiscount
            },
            success: function (response) {
                console.log('Услуга успешно добавлена!');
                // Очищаем поля ввода после успешной отправки
                $('#service_name').val('');
                $('#service_description').val('');
                $('#service_price').val('');
                $('#service_discount').val('');
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
    //добавление отношения
    $('.add-relation-button').click(function () {
        var serviceNameRelation = $('#relation_service_name').val();
        var workshopNameRelation = $('#relation_workshop_name').val();
        var serviceNameRelationValue = $('#relation_service_name option:selected').text(); // Получаем текст выбранной опции (название услуги)
        var workshopNameRelationValue = $('#relation_workshop_name option:selected').text(); // Получаем текст выбранной опции (название автосервиса)
        $.ajax({
            type: 'POST',
            url: '../assets/api/add_relation_script.php',
            data: {
                service_name_relation: serviceNameRelation,
                workshop_name_relation: workshopNameRelation,
            },
            success: function (response) {
                console.log('Услуга успешно добавлена!');
                // Создаем новую строку таблицы на основе полученных данных
                var newRow = "<tr>" +
                    "<td>" + workshopNameRelationValue + "</td>" +
                    "<td>" + serviceNameRelationValue + "</td>" +
                    "<td>" +
                    "<div class='delete-relation' data-service-id='" + serviceNameRelation + "''>" +
                    "<svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>" +
                    "<path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>" +
                    "</svg>" +
                    "</div>" +
                    "</td>" +
                    "</tr>";
                    var inputRow = $('.add-relation-row');
                    // Вставляем новую строку перед найденным элементом
                    inputRow.before(newRow);
            },
            error: function (xhr, status, error) {
                // Обработка ошибки AJAX-запроса
                console.error(xhr.responseText);
            }
        });
    });
    //удаление отношения
    var deleteRelationButtons = document.querySelectorAll('.delete-relation');
    deleteRelationButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var relationId = this.getAttribute('data-relation-id');
            deleteRelation(relationId, button); // Передаем ссылку на кнопку вместе с userId
        });
    });
    function deleteRelation(relationId, button) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var relationRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                    relationRow.parentNode.removeChild(relationRow);
                } else {
                    console.error('Произошла ошибка при удалении отношения');
                }
            }
        };
        xhr.open('POST', '../assets/api/delete_relation_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('relation_id=' + relationId);
    }
});