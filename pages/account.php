<?php
session_start();

if (!isset($_SESSION['user']['id'])) {
    header('Location: ../index.php');
}

require_once "../assets/api/account_info_script.php";
require_once "../assets/api/isAdmin.php";
if($isMechanic==true){
    header('Location: ../index.php'); 
}
// Функция для получения русского названия месяца
function russianMonth($monthNumber)
{
    $months = array(
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
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
    <!-- jQuery connection -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <!-- jQuery connection -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>Личный кабинет</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="account-section">
        <div class="nav">
            <div class="burger-menu-account">
                <span class="burger-menu-account__line"></span>
                <span class="burger-menu-account__line"></span>
                <span class="burger-menu-account__line"></span>
            </div>
            <ul class="nav__list">
                <li class="nav__list__item info-btn">Личные данные</li>
                <li class="nav__list__item orders-btn">Заказанные услуги</li>
                <li class="nav__list__item history-btn">История заказов</li>
                <li class="nav__list__item vehicles-btn">Мои автомобили</li>
            </ul>
        </div>
        <div class="account-info">
            <h2>Личные данные</h2>
            <div class="account-info__data-block">
                <div class="account-info__data">
                    <label class="account-info__data__label">Имя</label>
                    <input class="account-info__data__input" type="text" name="user_name"
                        value="<?php echo ($account_info['name']); ?>">
                </div>
                <div class="account-info__data">
                    <label class="account-info__data__label">Пароль</label>
                    <input class="account-info__data__input" type="password" name="user_password">
                </div>
                <div class="account-info__data">
                    <label class="account-info__data__label">Почта</label>
                    <input class="account-info__data__input" type="email" name="user_email"
                        value="<?php echo ($account_info['email']); ?>">
                </div>
                <div class="account-info__data">
                    <label class="account-info__data__label">Новый пароль</label>
                    <input class="account-info__data__input" type="password" name="user_new_password">
                </div>
            </div>
            <div class="account-info__btn-block">
                <?php
                if ($isWorker == true) {
                    echo ("<a href='../pages/moderator.php'>
                                <div class='button account-info__button'>
                                    <input type='button' class='button__content account-info__moderate' value='панель модератора'>
                                </div>
                            </a>");
                } else if ($isAdmin == true) {
                    echo ("<a href='../pages/admin.php'>
                                <div class='button account-info__button'>
                                    <input type='button' class='button__content account-info__moderate' value='панель администратора'>
                                </div>
                            </a>");
                }
                ?>
                <div class="button account-info__button">
                    <input type="button" class="button__content account-info__submit" value="изменить данные">
                </div>
            </div>
        </div>
        <div class="account-services orders account-orders">
            <h2>Мои записи</h2>
            <div class="order-cards-container">

                <?php
                foreach ($account_books as $account_book) {
                    $date = strtotime($account_book[4]); // Преобразование строки в дату
                    $day = date('j', $date);
                    $month = date('n', $date);
                    $date = $day . ' ' . russianMonth($month);
                    if ($account_book[6] == "pending") {
                        $status = "В обработке";
                    } else if ($account_book[6] == "confirmed") {
                        $status = "Принято в работу";
                    } else if ($account_book[6] == "completed") {
                        $status = "Выполнено";
                        continue;
                    }
                    
                    $price=$account_book[9]*$account_book[10];
                    if($account_book[11]!=NULL){
                        $price=$price*(100-$account_book[11])/100;
                    }
                    $car_row = "";
                    if ($account_book[7] != "") {
                        $car_row = "<p class='order-card__bottom-block__details__vehicle'>Автомобиль: " . $account_book[7] . "</p>";
                    }
                    echo ("
                        <div class='order-card'>
                            <svg class='order-card__delete' data-book-id='" . $account_book[8] . "' xmlns='http://www.w3.org/2000/svg' width='1.5em' height='1.5em'
                                viewBox='0 0 24 24'>
                                <path fill='none' stroke='#7e7e7e' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.1'
                                    d='m7 7l10 10M7 17L17 7' />
                            </svg>
                            <div class='order-card__head'>
                                <img class='order-card__head__img' src='../assets/images/location.png'>
                                <p class='order-card__head__workshop'>" . $account_book[1] . "</p>
                            </div>
                            <h2 class='order-card__service'>" . $account_book[0] . "</h2>
                            <h3 class='order-card__worker'>" . $account_book[2] . "</h3>
                            <div class='order-card__bottom-block'>
                                <div class='order-card__bottom-block__details'>
                                    " . $car_row . "
                                    <p class='order-card__bottom-block__details__status'>" . $status . "</p>
                                </div>
                                <div class='order-card__bottom-block__datetime'>
                                    <p class='order-card__bottom-block__datetime__value'>" . $date . ", " . substr($account_book[5], 0, 5) . "</p>
                                    <p class='order-card__bottom-block__datetime__price'>".$price." р.</p>
                                </div>
                            </div>
                        </div>
                    ");

                }
                ?>

            </div>
        </div>
        <div class="account-services history account-history">
            <h2>История заказов</h2>
            <table>
                <thead>
                    <tr>
                        <th>Автосервис</th>
                        <th>Работник</th>
                        <th>Автомобиль</th>
                        <th>Услуга</th>
                        <th>Комментарий<br>механика</th>
                        <th>Дата завершения</th>
                        <th>Время завершения</th>
                        <th>Конечная стоимость, р.</th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($account_history as $item) {
                            $date = strtotime($item[3]); // Преобразование строки в дату
                            $day = date('j', $date);
                            $month = date('n', $date);
                            $date = $day . ' ' . russianMonth($month);
                            echo ("<tr>
                                    <td>" . $item[7] . "</td>
                                    <td>" . $item[0] . "</td>
                                    <td>" . $item[8] . "</td>
                                    <td>" . $item[1] . "</td>
                                    <td>" . $item[10] . "</td>
                                    <td>" . $date . "</td>
                                    <td>" . substr($item[4], 0, 5) . "</td>
                                    <td>" . $item[9] . "</td>
                                </tr>");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <div class="account-services vehicles account-vehicles">
            <h2>Мои автомобили</h2>
            <table class="vehicles-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Марка</th>
                        <th>Гос. номер</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <tr id="new-vehicle-row">
                            <td></td>
                            <td><input type="text" class="add-vehicle-input user-input" name="vehicle_brand"
                                    id="vehicle_brand" placeholder="Audi"></td>
                            <td><input type="text" class="add-vehicle-input user-input" name="number_plate"
                                    id="number_plate" placeholder="1111 XX-1"></td>
                            <td>
                                <div class="add-vehicle-button">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em'
                                        viewBox='0 0 24 24'>
                                        <path fill='#232323'
                                            d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z' />
                                    </svg>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($vehicles as $vehicle) {
                            echo "
                                <tr>
                                    <td>" . $i . "</td>
                                    <td>" . $vehicle[1] . "</td>
                                    <td>" . $vehicle[2] . "</td>
                                    <td>
                                        <div class='delete-vehicle' data-vehicle-id='" . $vehicle[0] . "''>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                                <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                            ";
                            $i = $i + 1;
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </section>
    <?php require_once "../includes/footer.php"; ?>
    <?php require_once "../includes/popup.php"; ?>
</body>
<!-- <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="../assets/js/core/popper.min.js" type="text/javascript"></script> -->
<script src="../assets/js/account_navigation.js"></script>
<script src="../assets/js/change_user_data.js"></script>
<script src="../assets/js/delete_account_book.js"></script>
<script src="../assets/js/account_burger.js"></script>

</html>