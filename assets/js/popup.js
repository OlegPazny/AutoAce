let popupBgES = document.querySelector('.popup__bg__error-success'); // Фон попап окна
let popupES = document.querySelector('.popup__error-success'); // Само окно
// let openPopupButtons = document.querySelectorAll('.specialists-button'); // Кнопки для показа окна
let closePopupButtonES = document.querySelector('.close-popup__error-success'); // Кнопка для скрытия окна
// openPopupButtons.forEach((button) => { // Перебираем все кнопки
//     button.addEventListener('click', (e) => { // Для каждой вешаем обработчик событий на клик
//         e.preventDefault(); // Предотвращаем дефолтное поведение браузера
//         popupBgES.classList.add('active'); // Добавляем класс 'active' для фона
//         popupES.classList.add('active'); // И для самого окна
//     })
// });
closePopupButtonES.addEventListener('click',() => { // Вешаем обработчик на крестик
    popupBgES.classList.remove('active'); // Убираем активный класс с фона
    popupES.classList.remove('active'); // И с окна
});

document.addEventListener('click', (e) => { // Вешаем обработчик на весь документ
    if(e.target === popupBgES) { // Если цель клика - фот, то:
        popupBgES.classList.remove('active'); // Убираем активный класс с фона
        popupES.classList.remove('active'); // И с окна
    }
});