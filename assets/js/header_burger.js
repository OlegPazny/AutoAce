document.addEventListener('DOMContentLoaded', function () {
    const burgerMenu = document.querySelector('.header__burger-menu');
    const navMenu = document.querySelector('.header__nav');

    burgerMenu.addEventListener('click', function () {
        if (document.querySelector('.burger-menu') && document.querySelector('.filter-block')) {
            if (document.querySelector('.burger-menu').classList.contains('open') && document.querySelector('.filter-block').classList.contains('open')) {
                document.querySelector('.burger-menu').classList.remove('open');
                document.querySelector('.filter-block').classList.remove('open');
            }
        }
        if (document.querySelector('.burger-menu-account') && document.querySelector('.nav__list')) {
            if (document.querySelector('.burger-menu-account').classList.contains('active') && document.querySelector('.nav__list').classList.contains('active')) {
                document.querySelector('.burger-menu-account').classList.remove('active');
                document.querySelector('.nav__list').classList.remove('active');
                const burger = document.querySelector('.burger-menu-account');
                const navList = document.querySelector('.nav__list');
                if (navList.classList.contains('active')) {
                    const navWidth = navList.getBoundingClientRect().width;
                    burger.style.left = `${navWidth + 10}px`; // Установить новое значение left для бургер-кнопки
                } else {
                    burger.style.left = '1rem'; // Восстановить начальное значение left для бургер-кнопки
                }
            }
        }
        if (document.querySelector('.modalpopup')) {
            if (getComputedStyle(document.querySelector('.modalpopup')).opacity == 0) {
                navMenu.classList.toggle('active');
            }
        } else {
            navMenu.classList.toggle('active');
        }

    });
});