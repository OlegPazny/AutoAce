window.scrollTo(0, 0);

var openModalLink = document.querySelector('a[href="#openModal"]');
var closeModalLink = document.querySelector('.modalpopup .close');
var modal = document.getElementById('openModal');

// Получаем высоту прокрутки страницы перед открытием модального окна
var scrollTopPos = 0;

openModalLink.addEventListener('click', function (e) {
    // Запоминаем текущую позицию прокрутки страницы
    scrollTopPos = window.pageYOffset || document.documentElement.scrollTop;
    window.scrollTo(0, 0);
    document.body.style.overflowY = "hidden";
});

closeModalLink.addEventListener('click', function () {
    window.scrollTo(0, scrollTopPos);
    document.body.style.overflowY = "auto";
});

modal.addEventListener('click', function (e) {
    if (e.target === modal) {
        window.scrollTo(0, scrollTopPos);
    }
});