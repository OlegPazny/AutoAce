// Обработчик клика на кнопке информации
$(document).ready(function () {
    $('.info-btn').on('click', function () {
        var info_btn = $('.info-btn');
        var orders_btn = $('.orders-btn');
        var history_btn = $('.history-btn');
        var infoContainer = $('.accounts');
        var ordersContainer = $('.orders');
        var historyContainer = $('.history');
        ordersContainer.fadeOut();
        historyContainer.fadeOut();

        info_btn.css("background", "#fff");
        info_btn.css("color", "#232323");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");

        // Проверяем, видим ли блок #answers-container
        if (ordersContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            ordersContainer.hide();

        }
        if (historyContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            historyContainer.hide();
        }

        infoContainer.fadeIn('slow'); // Показываем блок #answers-container
    })

    // Обработчик клика на кнопке заказов

    $('.orders-btn').on('click', function () {
        var info_btn = $('.info-btn');
        var orders_btn = $('.orders-btn');
        var history_btn = $('.history-btn');
        var infoContainer = $('.accounts');
        var ordersContainer = $('.orders');
        var historyContainer = $('.history');
        infoContainer.fadeOut();
        historyContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#fff");
        orders_btn.css("color", "#232323");
        history_btn.css("background", "#232323");
        history_btn.css("color", "#fff");

        // Проверяем, видим ли блок #answers-container
        if (infoContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            infoContainer.hide();

        }
        if (historyContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            historyContainer.hide();
        }

        ordersContainer.fadeIn('slow'); // Показываем блок #answers-container

    })

    // Обработчик клика на кнопке истории

    $('.history-btn').on('click', function () {
        var info_btn = $('.info-btn');
        var orders_btn = $('.orders-btn');
        var history_btn = $('.history-btn');
        var infoContainer = $('.accounts');
        var ordersContainer = $('.orders');
        var historyContainer = $('.history');
        infoContainer.fadeOut();
        ordersContainer.fadeOut();

        info_btn.css("background", "#232323");
        info_btn.css("color", "#fff");
        orders_btn.css("background", "#232323");
        orders_btn.css("color", "#fff");
        history_btn.css("background", "#fff");
        history_btn.css("color", "#232323");

        // Проверяем, видим ли блок #answers-container
        if (infoContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            infoContainer.hide();

        }
        if (ordersContainer.css('display') != 'none') {
            // Если блок видим, скрываем его
            ordersContainer.hide();
        }

        historyContainer.fadeIn('slow'); // Показываем блок #answers-container

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
                    // Обработка успешного ответа от сервера (если нужно)
                    // Например, удаление строки из таблицы
                    var userRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                    userRow.parentNode.removeChild(userRow);
                } else {
                    // Обработка ошибки
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
        statusSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                var bookingId = this.getAttribute('data-booking-id');
                var newStatus = this.value;
                updateStatus(bookingId, newStatus);
            });
        });
    
        function updateStatus(bookingId, newStatus) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Обработка успешного ответа от сервера (если нужно)
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
    statusSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            var bookingId = this.getAttribute('data-booking-id');
            var newStatus = this.value;
            updateStatus(bookingId, newStatus);
        });
    });

    function updateStatus(bookingId, newStatus) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Обработка успешного ответа от сервера (если нужно)
                } else {
                    console.error('Произошла ошибка при обновлении статуса заказа');
                }
            }
        };
        xhr.open('POST', '../assets/api/update_status_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('booking_id=' + bookingId + '&new_status=' + newStatus);
    }
});