<?php
require_once "../assets/api/account_info_script.php";
require_once "../assets/api/isAdmin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery connection -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- jQuery connection -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>Личный кабинет</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="account-section">
        <div class="nav">
            <ul class="nav__list">
                <li class="nav__list__item info-btn">личные данные</li>
                <li class="nav__list__item orders-btn">заказанные услуги</li>
                <li class="nav__list__item history-btn">история заказов</li>
            </ul>
        </div>
        <div class="account-info">
            <div class="account-info__data">
                <label class="account-info__data__label">Имя</label>
                <input class="account-info__data__input" type="text" name="name">
            </div>
            <div class="account-info__data">
                <label class="account-info__data__label">Пароль</label>
                <input class="account-info__data__input" type="password" name="password">
            </div>
            <div class="account-info__data">
                <label class="account-info__data__label">Почта</label>
                <input class="account-info__data__input" type="email" name="email">
            </div>
            <div class="account-info__data">
                <label class="account-info__data__label">Новый пароль</label>
                <input class="account-info__data__input" type="password" name="new_password">
            </div>
            <div class="account-info__btn-block">
                <?php
                    if($isWorker==true){
                        echo("<a href='../pages/moderator.php'>
                                <div class='button account-info__button'>
                                    <input type='button' class='button__content account-info__moderate' value='панель модератора'>
                                </div>
                            </a>");
                    }else if($isAdmin==true){
                        echo("<a href='../pages/admin.php'>
                                <div class='button account-info__button'>
                                    <input type='button' class='button__content account-info__moderate' value='панель администратора'>
                                </div>
                            </a>");
                    }
                ?>
                <form action="../assets/api/logout.php">
                    <div class="button logout-button">
                        <input type="submit" class="button__content logout-button__content" value="Выйти">
                    </div>
                </form>
                <div class="button account-info__button">
                    <input type="button" class="button__content account-info__submit" value="изменить данные">
                </div>
            </div>
        </div>
        <div class="account-services orders">
            <table>
                <thead>
                    <tr>
                        <th>Автосервис</th>
                        <th>Услуга</th>
                        <th>Комментарий</th>
                        <th>Дата записи</th>
                        <th>Время записи</th>
                        <th>Статус</th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($account_books as $account_book) {
                            if ($account_book[5] == "pending") {
                                $status = "В обработке";
                            } else if ($account_book[5] == "confirmed") {
                                $status = "Принято в работу";
                            } else if ($account_book[5] == "completed") {
                                $status = "Выполнено";
                            }

                            echo ("<tr>
                                <td>" . $account_book[0] . "</td>
                                <td>" . $account_book[1] . "</td>
                                <td>" . $account_book[2] . "</td>
                                <td>" . $account_book[3] . "</td>
                                <td>" . $account_book[4] . "</td>
                                <td>" . $status . "</td></tr>");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <div class="account-services history">
            <table>
                <thead>
                    <tr>
                        <th>Автосервис</th>
                        <th>Услуга</th>
                        <th>Комментарий</th>
                        <th>Дата записи</th>
                        <th>Время записи</th>
                        <th>Статус</th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($account_books as $account_book) {
                            if ($account_book[5] == "pending") {
                                $status = "В обработке";
                            } else if ($account_book[5] == "confirmed") {
                                $status = "Принято в работу";
                            } else if ($account_book[5] == "completed") {
                                $status = "Выполнено";
                            }

                            echo ("<tr>
                                <td>" . $account_book[0] . "</td>
                                <td>" . $account_book[1] . "</td>
                                <td>" . $account_book[2] . "</td>
                                <td>" . $account_book[3] . "</td>
                                <td>" . $account_book[4] . "</td>
                                <td>" . $status . "</td></tr>");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </section>
    <?php require_once "../includes/footer.php"; ?>
</body>
<!-- <script src="../assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="../assets/js/core/popper.min.js" type="text/javascript"></script> -->
<script src="../assets/js/account_navigation.js"></script>
<script src="../assets/js/change_user_data.js"></script>

</html>