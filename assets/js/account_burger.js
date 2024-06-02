document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.burger-menu-account');
    const navList = document.querySelector('.nav__list');
    const mediaQuery = window.matchMedia('(max-width: 736px)'); // Создать медиа-запрос для ширины экрана до 736px
    const navItems = document.querySelectorAll('.nav__list__item');

    function updateBurgerPosition() {
        if (navList.classList.contains('active')) {
            const navWidth = navList.getBoundingClientRect().width;
            burger.style.left = `${navWidth + 10}px`; // Установить новое значение left для бургер-кнопки
        } else {
            burger.style.left = '1rem'; // Восстановить начальное значение left для бургер-кнопки
        }
    }

    burger.addEventListener('click', function () {
        navList.classList.toggle('active');
        burger.classList.toggle('active');
        updateBurgerPosition();
    });

    navItems.forEach(item => {
        item.addEventListener('click', function () {
            navList.classList.remove('active');
            burger.style.left = '1rem'; // Восстановить начальное значение left для бургер-кнопки
            burger.classList.toggle('active');
        });
    });

    mediaQuery.addEventListener(function (e) {
        if (!e.matches) {
            navList.classList.remove('active'); // Удалить класс active для списка на больших экранах
            burger.style.left = '1rem'; // Восстановить начальное значение left для бургер-кнопки
        }
    });
});