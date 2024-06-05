<?php
session_start();
if (!isset($_SESSION['user']['id'])) {
    header('Location: ../index.php');
}
require_once "../assets/api/isAdmin.php";
if ($isMechanic == false) {
    header("Location: ../index.php");
}
require_once "../assets/api/get_mechanic_data_script.php";
// Функция для получения русского названия месяца
function russianMonth($monthNumber) {
    $months = array(
        'января', 'февраля', 'марта',
        'апреля', 'мая', 'июня',
        'июля', 'августа', 'сентября',
        'октября', 'ноября', 'декабря'
    );
    return $months[$monthNumber - 1];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/favicon.svg" />
    <title>Страница механика</title>
    <!-- jQuery connection -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <!-- jQuery connection -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
</head>

<body>
    <?php require_once "../includes/header.php";?>
    <section class="account-section">
        <div class="nav">
            <div class="burger-menu-account"></div>

            <ul class="nav__list">
                <li class="nav__list__item info-btn">Личные данные</li>
                <li class="nav__list__item works-btn">Список работ</li>
            </ul>
        </div>
        <div class="account-info">
            <h2>Личные данные</h2>
            <div class="account-info__data-block">
                <div class="account-info__data">
                    <label class="account-info__data__label">Имя</label>
                    <input class="account-info__data__input" type="text" name="mechan_name"
                        value="<?php echo ($mechanic['name']); ?>">
                </div>
                <div class="account-info__data">
                    <label class="account-info__data__label">Пароль</label>
                    <input class="account-info__data__input" type="password" name="mechan_password">
                </div>
                <div class="account-info__data">
                    <label class="account-info__data__label">Почта</label>
                    <input class="account-info__data__input" type="email" name="mechan_email"
                        value="<?php echo ($mechanic['email']); ?>">
                </div>
                <div class="account-info__data">
                    <label class="account-info__data__label">Новый пароль</label>
                    <input class="account-info__data__input" type="password" name="mechan_new_password">
                </div>
            </div>
            <div class="account-info__btn-block">
                <div class="button account-info__button">
                    <input type="button" class="button__content account-info__submit" value="изменить данные">
                </div>
            </div>
        </div>
        <div class="account-services works">
            <h2>Список работ</h2>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Услуга</th>
                        <th>Клиент</th>
                        <th>Автомобиль</th>
                        <th>VIN</th>
                        <th>Комментарий</th>
                        <th>Дата записи</th>
                        <th>Время записи</th>
                        <th>Статус</th>
                        <th>Выполненные работы</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($works as $work) {
                            if($work[6]=="completed"){
                                continue;
                            }
                            $date = strtotime($work[4]); // Преобразование строки в дату
                            $day = date('j', $date);
                            $month = date('n', $date);
                            $date = $day . ' ' . russianMonth($month);
                            $vin_input="";
                            if($work[7]!=NULL){
                                $vin_input="<input type='text' class='admin-input' name='vin' value='" . $work[8] . "'>";
                            }
                            $client_name="Клиент";
                            if($work[2]!=NULL){
                                $client_name=$work[2];
                            }
                            echo ("<tr>
                                        <td>" . $work[0] . "</td>
                                        <td>" . $work[1] . "</td>
                                        <td>" . $client_name . "</td>
                                        <td>" . $work[7] . "</td>
                                        <td>". $vin_input . "</td>
                                        <td>" . $work[3] . "</td>
                                        <td>" . $date . "</td>
                                        <td>" . substr($work[5], 0, 5) . "</td>
                                        <td>");
                                ?>
                                <select class='status-select' data-booking-id="<?php echo $work[0]; ?>">
                                    <option value='pending' <?php if ($work[6] == "pending")
                                        echo "selected"; ?>>В
                                        обработке</option>
                                    <option value='confirmed' <?php if ($work[6] == "confirmed")
                                        echo "selected"; ?>>
                                        Принято в работу</option>
                                    <option value='completed' <?php if ($work[6] == "completed")
                                        echo "selected"; ?>>
                                        Выполнено</option>
                                </select>
                                <?php echo ("</td>
                                        <td><textarea class='admin-input' name='mechan_comment'>".$work[9]."</textarea></td>
                                        <td>
                                            <div class='update-book-button' data-book-id='".$work[0]."'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em'
                                                        viewBox='0 0 24 24'>
                                                        <path fill='#232323'
                                                            d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z' />
                                                    </svg>
                                            </div>
                                        </td>
                                </tr>");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </section>
</body>
<script src="../assets/js/mechanic.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const burger = document.querySelector('.burger-menu-account'); // Получить элемент бургер-кнопки
    const navList = document.querySelector('.nav__list'); // Получить элемент списка навигации
    const mediaQuery = window.matchMedia('(max-width: 736px)'); // Создать медиа-запрос для ширины экрана до 736px
    const navItems = document.querySelectorAll('.nav__list__item'); // Получить все элементы списка навигации

    function updateBurgerPosition() {
        if (navList.classList.contains('active')) {
            const navWidth = navList.getBoundingClientRect().width; // Получить ширину списка навигации
            burger.style.left = `${navWidth+10}px`; // Установить новое значение left для бургер-кнопки
        } else {
            burger.style.left = '1rem'; // Восстановить начальное значение left для бургер-кнопки
        }
    }

    burger.addEventListener('click', function() {
        navList.classList.toggle('active'); // Переключить класс active для списка
        burger.classList.toggle('active'); // Переключить класс active для бургер-кнопки
        updateBurgerPosition(); // Обновить позицию бургер-кнопки
    });

    navItems.forEach(item => {
        item.addEventListener('click', function() {
            navList.classList.remove('active'); // Удалить класс active для списка при клике на элемент меню
            burger.style.left = '1rem'; // Восстановить начальное значение left для бургер-кнопки
            burger.classList.toggle('active'); // Переключить класс active для бургер-кнопки
        });
    });

    mediaQuery.addListener(function(e) {
        if (!e.matches) {
            navList.classList.remove('active'); // Удалить класс active для списка на больших экранах
            burger.style.left = '1rem'; // Восстановить начальное значение left для бургер-кнопки
        }
    });
});
</script>
</html>