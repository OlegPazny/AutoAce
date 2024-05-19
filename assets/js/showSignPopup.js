/*для sign-up */
let popUpSignUpBGSignUp = document.querySelector('.popup__bg__sign-up'); // Фон попап окна

let popupSignUp = document.querySelector('.signup-section.signup'); // Само окно

let openPopupSignUpButtons = document.querySelectorAll('#sign-up__link'); // Кнопки для показа окна

let closePopupSignUpButton = document.querySelector('.close-popup__sign-up'); // Кнопка для скрытия окна
// /*для sign-in */
let popUpSignInBGSignIn = document.querySelector('.popup__bg__sign-in'); // Фон попап окна

let popupSignIn = document.querySelector('.signup-section.signin'); // Само окно

let openPopupSignInButtons = document.querySelectorAll('#sign-in__link'); // Кнопки для показа окна

let closePopupSignInButton = document.querySelector('.close-popup__sign-in'); // Кнопка для скрыти
// /*sign-in */
openPopupSignInButtons.forEach((button) => { // Перебираем все кнопки
    button.addEventListener('click', (e) => { // Для каждой вешаем обработчик событий на клик
        // clear();
        e.preventDefault(); // Предотвращаем дефолтное поведение браузера
        popUpSignInBGSignIn.classList.add('active'); // Добавляем класс 'active' для фона
        popupSignIn.classList.add('active'); // И для самого окна

        if(popUpSignUpBGSignUp.classList.contains('active')){
            popUpSignUpBGSignUp.classList.remove('active'); // Убираем активный класс с фона
        }
        if(popupSignUp.classList.contains('active')){
            popupSignUp.classList.remove('active'); // И с окна
        }   
    })
});

closePopupSignInButton.addEventListener('click',() => { // Вешаем обработчик на крестик
    // clear();
    popUpSignInBGSignIn.classList.remove('active'); // Убираем активный класс с фона
    popupSignIn.classList.remove('active'); // И с окна

    if(popUpSignUpBGSignUp.classList.contains('active')){
        popUpSignUpBGSignUp.classList.remove('active'); // Убираем активный класс с фона
    }
    if(popupSignUp.classList.contains('active')){
        popupSignUp.classList.remove('active'); // И с окна
    } 
});

document.addEventListener('click', (e) => { // Вешаем обработчик на весь документ
    if(e.target === popUpSignInBGSignIn) { // Если цель клика - фон, то:
        // clear();
        if(popUpSignInBGSignIn.classList.contains('active')){
            popUpSignInBGSignIn.classList.remove('active'); // Убираем активный класс с фона
        }
        if(popupSignIn.classList.contains('active')){
            popupSignIn.classList.remove('active'); // И с окна
        } 

        if(popUpSignUpBGSignUp.classList.contains('active')){
            popUpSignUpBGSignUp.classList.remove('active'); // Убираем активный класс с фона
        }
        if(popupSignUp.classList.contains('active')){
            popupSignUp.classList.remove('active'); // И с окна
        } 
    }
});
/*sign-up */

openPopupSignUpButtons.forEach((button) => { // Перебираем все кнопки
    button.addEventListener('click', (e) => { // Для каждой вешаем обработчик событий на клик
        e.preventDefault(); // Предотвращаем дефолтное поведение браузера
        // clear();
        if(popUpSignInBGSignIn.classList.contains('active')){
            popUpSignInBGSignIn.classList.remove('active'); // Убираем активный класс с фона
        }
        if(popupSignIn.classList.contains('active')){
            popupSignIn.classList.remove('active'); // И с окна
        } 

        popUpSignUpBGSignUp.classList.add('active'); // Добавляем класс 'active' для фона
        popupSignUp.classList.add('active'); // И для самого окна
    })
});

closePopupSignUpButton.addEventListener('click',() => { // Вешаем обработчик на крестик
    // clear();
    if(popUpSignUpBGSignUp.classList.contains('active')){
        popUpSignUpBGSignUp.classList.remove('active'); // Убираем активный класс с фона
    }
    if(popupSignUp.classList.contains('active')){
        popupSignUp.classList.remove('active'); // И с окна
    } 

    if(popUpSignInBGSignIn.classList.contains('active')){
        popUpSignInBGSignIn.classList.remove('active'); // Убираем активный класс с фона
    }
    if(popupSignIn.classList.contains('active')){
        popupSignIn.classList.remove('active'); // И с окна
    } 
});

document.addEventListener('click', (e) => { // Вешаем обработчик на весь документ
    if(e.target === popUpSignUpBGSignUp) { // Если цель клика - фон, то:
        // // clear();
        // if(popUpSignUpBGSignIn.classList.contains('active')){
        //     popUpSignInBGSignIn.classList.remove('active'); // Убираем активный класс с фона
        // }
        // if(popupSignIn.classList.contains('active')){
        //     popupSignIn.classList.remove('active'); // И с окна
        // } 

        if(popUpSignUpBGSignUp.classList.contains('active')){
            popUpSignUpBGSignUp.classList.remove('active'); // Убираем активный класс с фона
        }
        if(popupSignUp.classList.contains('active')){
            popupSignUp.classList.remove('active'); // И с окна
        } 
    }
});