// Обработчик клика callback
$(document).ready(function () {
    //добавление услуги
    $('.callback-form').submit(function (e) {
        e.preventDefault();
        var name = $('input[name="name"]').val();
        var email = $('input[name="email"]').val();
        var message = $('textarea[name="message"]').val();
        // Получаем значение чекбокса
        var checkboxChecked = $('.callback-form__checkbox').is(':checked');

        // Проверяем, был ли чекбокс отмечен
        if (!checkboxChecked) {
            // Если чекбокс не отмечен, выводим сообщение об ошибке
            alert('Пожалуйста, отметьте чекбокс "Я даю согласие на обработку персональных данных".');
            return; // Прерываем выполнение обработчика
        }
        $.ajax({
            type: 'POST',
            url: '../assets/api/callback_script.php',
            data: {
                name: name,
                email: email,
                message: message
            },
            success: function (response) {
                console.log('Письмо отправлено!');
                // Очищаем поля ввода после успешной отправки
                $('input[name="name"]').val('');
                $('input[name="email"]').val('');
                $('textarea[name="message"]').val('');
            },
            error: function (xhr, status, error) {
                // Обработка ошибки AJAX-запроса
                console.error(xhr.responseText);
            }
        });
    });
});