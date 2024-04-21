$(document).ready(function () {
    $('#bookingForm').submit(function (e) {
        e.preventDefault();

        var checkboxChecked = $('.callback-form__checkbox').is(':checked');

        if (!checkboxChecked) {
            // Если чекбокс не отмечен, выводим сообщение об ошибке
            alert('Пожалуйста, отметьте чекбокс "Я даю согласие на обработку персональных данных".');
            return;
        }
        var formData = $(this).serialize();

            // Отправляем AJAX запрос на сервер
            $.ajax({
                type: 'POST',
                url: '../assets/api/book_script.php',
                data: formData,
                success: function (response) {
                    // Обработка успешного ответа от сервера
                    console.log('Данные успешно отправлены!');
                    $('textarea[name="message"]').val('');
                    $('.callback-form__checkbox').prop('checked', false);
                },
                error: function (xhr, status, error) {
                    // Обработка ошибок при отправке запроса
                    console.error(xhr.responseText);
                    console.log("ошибка");
                }
            });
        

    });
});
