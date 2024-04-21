// Обработчик клика callback
$(document).ready(function () {
    //добавление услуги
    $('.callback-form').submit(function (e) {
        e.preventDefault();
        var name = $('input[name="name"]').val();
        var email = $('input[name="email"]').val();
        var message = $('textarea[name="message"]').val();
        console.log(email);
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