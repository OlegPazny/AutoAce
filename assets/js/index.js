document.addEventListener('DOMContentLoaded', function() {
    // Получаем все кнопки с классом .slider-button__content
    var buttons = document.querySelectorAll('.slider-button__content');

    // URL страницы, на которую нужно перенаправить пользователя
    var redirectTo = 'map.php';

    // Итерируем по всем кнопкам и добавляем обработчик клика
    buttons.forEach(function(button) {
        // Привязываем контекст обработчика события к текущей кнопке
        var clickHandler = function() {
            window.location.href = redirectTo;
        };
        button.addEventListener('click', clickHandler.bind(button));
    });
});
