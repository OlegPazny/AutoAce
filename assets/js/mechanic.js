$(document).ready(function () {
    // Функция для скрытия всех контейнеров, кроме переданного
    function hideContainers(exceptContainer) {
        $('.account-info, .works').not(exceptContainer).hide();
    }
    // Функция для установки стилей кнопок
    function setButtonStyles(activeButton) {
        $('.info-btn, .works-btn').css({
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

    $('.works-btn').on('click', function () {
        hideContainers('.orders');
        $('.works').fadeIn('slow');
        setButtonStyles($(this));
    });
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
})