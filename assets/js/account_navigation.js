// Обработчик клика на кнопке информации
$(document).ready(function () {
        // Функция для скрытия всех контейнеров, кроме переданного
        function hideContainers(exceptContainer) {
            $('.account-info, .orders, .history, .vehicles').not(exceptContainer).hide();
        }
    
        // Функция для установки стилей кнопок
        function setButtonStyles(activeButton) {
            $('.info-btn, .orders-btn, .history-btn, .vehicles-btn').css({
                'background': '#232323',
                'color': '#fff'
            });
            activeButton.css({
                'background': '#fff',
                'color': '#232323'
            });
        }
        // Обработчики кликов
    $('.info-btn').on('click', function () {
        hideContainers('.account-info');
        $('.account-info').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.orders-btn').on('click', function () {
        hideContainers('.orders');
        $('.orders').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.history-btn').on('click', function () {
        hideContainers('.history');
        $('.history').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.vehicles-btn').on('click', function () {
        hideContainers('.vehicles');
        $('.vehicles').fadeIn('slow');
        setButtonStyles($(this));
    });
});