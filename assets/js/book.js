$(document).ready(function() {
    $('#bookingForm').submit(function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение отправки формы

        // Получаем данные формы
        var formData = $(this).serialize();

        // Отправляем AJAX запрос на сервер
        $.ajax({
            type: 'POST',
            url: '../assets/api/book_script.php', // Укажите путь к файлу обработчика на вашем сервере
            data: formData,
            success: function(response) {
                // Обработка успешного ответа от сервера
                alert('Данные успешно отправлены!');
            },
            error: function(xhr, status, error) {
                // Обработка ошибок при отправке запроса
                console.error(xhr.responseText);
            }
        });
    });
});
