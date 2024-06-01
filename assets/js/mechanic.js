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
    $('.account-info__submit').click(function (e) {
        e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)
    
        $(`input`).removeClass('error');//очищение инпутов от класса error
    
        let mechan_name = $('input[name="mechan_name"]').val();
        let mechan_email = $('input[name="mechan_email"]').val();
        let mechan_password = $('input[name="mechan_password"]').val();
        let mechan_new_password = $('input[name="mechan_new_password"]').val();
        console.log(mechan_name);
        console.log(mechan_email);
        console.log(mechan_password);
        console.log(mechan_new_password);
        $.ajax({
            url: '../assets/api/change_mechanic_data_script.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mechan_name: mechan_name,
                mechan_email: mechan_email,
                mechan_password: mechan_password,
                mechan_new_password: mechan_new_password
            },
    
            success: function (data) {
                if (data.status) {
                    alert("Данные изменены!");
                    $('input[name="mechan_password"]').val('');
                    $('input[name="mechan_new_password"]').val('');
                } else {
                    if (data.type === 1) {
                        data.fields.forEach(function (field) {
                            $(`input[name="${field}"]`).addClass('error');
                        });
                    }
                    $('.message').removeClass('none').text(data.message);
                }
            }
        })
    });
})