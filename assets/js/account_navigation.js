// Обработчик клика на кнопке информации
$(document).ready(function () {
    $('.info-btn').on('click', function () {
        var info_btn = $('.info-btn');
        var orders_btn = $('.orders-btn');
        var history_btn = $('.history-btn');
        var infoContainer = $('.account-info');
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
});
// Обработчик клика на кнопке заказов
$(document).ready(function () {
    $('.orders-btn').on('click', function () {
        var info_btn = $('.info-btn');
        var orders_btn = $('.orders-btn');
        var history_btn = $('.history-btn');
        var infoContainer = $('.account-info');
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
});
// Обработчик клика на кнопке истории
$(document).ready(function () {
    $('.history-btn').on('click', function () {
        var info_btn = $('.info-btn');
        var orders_btn = $('.orders-btn');
        var history_btn = $('.history-btn');
        var infoContainer = $('.account-info');
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
});