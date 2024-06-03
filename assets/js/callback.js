// Обработчик клика callback
$(document).ready(function () {
    //добавление услуги
    $('.callback-form').submit(function (e) {
        e.preventDefault();
        var name = $('input[name="callback_name"]').val();
        var email = $('input[name="callback_email"]').val();
        var message = $('textarea[name="callback_message"]').val();
        // Получаем значение чекбокса
        var checkboxChecked = $('.callback-form__checkbox').is(':checked');
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        function validateEmail(email) {
            return emailPattern.test(email);
        }
        if (email=="" || !validateEmail(email)){
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Почта введена некорректно.');
            return;
        }
        // Проверяем, был ли чекбокс отмечен
        if (!checkboxChecked) {
            // Если чекбокс не отмечен, выводим сообщение об ошибке
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Пожалуйста, отметьте чекбокс "Я даю согласие на обработку персональных данных".');
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
                $('.popup__bg__error-success').addClass('active');
                $('.popup__error-success').addClass('active');
                $('.popup__error-success .data-text').text('Письмо отправлено! В ближайшее время с Вами свяжется менеджер, чтобы помочь решить Ваш вопрос!');    
                // Очищаем поля ввода после успешной отправки
                $('input[name="callback_name"]').val('');
                $('input[name="callback_email"]').val('');
                $('textarea[name="callback_message"]').val('');
                $('.callback-form__checkbox').prop('checked', false);
            },
            error: function (xhr, status, error) {
                // Обработка ошибки AJAX-запроса
                console.error(xhr.responseText);
            }
        });
    });
});