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
    // Применение маски для номера
    // Применение маски для всех полей номерных знаков
    $('input[name="plate"]').mask('0000 AA-0', {
        translation: {
            'A': { pattern: /[A-Za-z]/ },
            '0': { pattern: /[0-9]/ }
        },
        onComplete: function (value, event, currentField, options) {
            const region = parseInt(value.slice(-1), 10);
            if (region < 1 || region > 7) {
                $('.popup__bg__error-success').addClass('active');
                $('.popup__error-success').addClass('active');
                $('.popup__error-success .data-text').text('Регион должен быть числом от 1 до 7.');
                currentField.val(value.slice(0, -1)); // Стираем неправильный регион
            }
        }
    });

    // Автоматическое преобразование строчных букв в заглавные для всех полей номерных знаков
    $(document).on('input', 'input[name="plate"]', function () {
        var value = $(this).val();
        // Преобразование строчных букв в заглавные
        var uppercasedValue = value.toUpperCase();
        // Обновление значения инпута
        $(this).val(uppercasedValue);
    });

    // Обработка ввода для всех полей марок автомобилей
    $(document).on('input', 'input[name="car"]', function () {
        var value = $(this).val();

        // Удаление всех символов, кроме латинских и кириллических букв, дефисов и пробелов
        value = value.replace(/[^A-Za-zА-Яа-яЁё \-]/g, '');

        // Преобразование первой буквы в каждом слове в заглавную
        var words = value.split(' ');
        for (var i = 0; i < words.length; i++) {
            if (words[i].length > 0) {
                words[i] = words[i][0].toUpperCase() + words[i].substr(1);
            }
        }
        var newValue = words.join(' ');
        $(this).val(newValue);
    });
    $('input[name="total_price"]').mask('0000000.00', { reverse: true });
    function updateRecordHandler() {
        $('.update-book-button').click(function (e) {
            e.preventDefault;
            try {
                const bookId = $(this).data('book-id');
                const row = $(this).closest('tr');
                const vehicle = row.find("input[name='car']").val();
                const plate = row.find("input[name='plate']").val();
                const vin = row.find("input[name='vin']").val();
                const total_price = row.find("input[name='total_price']").val();
                const mechan_comment = row.find("textarea[name='mechan_comment']").val();
                const status = row.find(".status-select").val();

                if(status=="completed"&&total_price==""){
                    $('.popup__bg__error-success').addClass('active');
                    $('.popup__error-success').addClass('active');
                    $('.popup__error-success .data-text').text('Перед завершением работ введите стоимость ремонта.');
                    return;
                }
                if (vin != "") {
                    if (plate == "" || vehicle == "") {
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('Укажите все данные автомобиля.');
                        return;
                    } else if (plate == "" && vehicle == "") {
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('Укажите все данные автомобиля.');
                        return;
                    }
                }
                if (vehicle != "") {
                    if (plate == "" || plate.length != 9) {
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('Введите корректно гос. номер!');
                        return;
                    }
                }

                if (vin != "" && vin.length != 17) {
                    $('.popup__bg__error-success').addClass('active');
                    $('.popup__error-success').addClass('active');
                    $('.popup__error-success .data-text').text('Длина VIN-кода должна состоять из 17 символов.');
                    return;
                }
                // Отправляем данные на сервер...
                const data = {
                    book_id: bookId,
                    vehicle: vehicle,
                    plate: plate,
                    vin: vin,
                    mechan_comment: mechan_comment,
                    total_price: total_price,
                    status: status
                };

                fetch('../assets/api/update_mechan_book_script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            $('.popup__bg__error-success').addClass('active');
                            $('.popup__error-success').addClass('active');
                            $('.popup__error-success .data-text').text('Запись обновлена успешно.');
                        } else {
                            $('.popup__bg__error-success').addClass('active');
                            $('.popup__error-success').addClass('active');
                            $('.popup__error-success .data-text').text(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text(error);
                    });
            } catch (error) {
                console.error(error);
            }

        })
    };
    updateRecordHandler();
    $('.account-info__submit').click(function (e) {
        e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)

        $(`input`).removeClass('error');//очищение инпутов от класса error

        let mechan_name = $('input[name="mechan_name"]').val();
        let mechan_email = $('input[name="mechan_email"]').val();
        let mechan_password = $('input[name="mechan_password"]').val();
        let mechan_new_password = $('input[name="mechan_new_password"]').val();

        if (mechan_name == "") {
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Имя не может быть пустым.');
            return;
        }
        if (mechan_email == "") {
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Почта не может быть пустой.');
            return;
        }
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
                    $('.popup__bg__error-success').addClass('active');
                    $('.popup__error-success').addClass('active');
                    $('.popup__error-success .data-text').text('Данные изменены.');

                    $('input[name="mechan_password"]').val('');
                    $('input[name="mechan_new_password"]').val('');
                } else {
                    if (data.type === 1) {
                        data.fields.forEach(function (field) {
                            $(`input[name="${field}"]`).addClass('error');
                        });
                    }
                    $('.popup__bg__error-success').addClass('active');
                    $('.popup__error-success').addClass('active');
                    $('.popup__error-success .data-text').text(data.message);
                }
            }
        })
    });
})