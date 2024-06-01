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
            <ul class="nav__list">
                <li class="nav__list__item info-btn">личные данные</li>
                <li class="nav__list__item works-btn">список работ</li>
            </ul>
        </div>
        <div class="account-info mechanic-info">
            <div class="account-info__data">
                <label class="account-info__data__label">Имя</label>
                <input class="account-info__data__input" type="text" name="mechan_name" value="<?php echo($mechanic['name']);?>">
            </div>
            <div class="account-info__data">
                <label class="account-info__data__label">Пароль</label>
                <input class="account-info__data__input" type="password" name="mechan_password">
            </div>
            <div class="account-info__data">
                <label class="account-info__data__label">Почта</label>
                <input class="account-info__data__input" type="email" name="mechan_email" value="<?php echo($mechanic['email']);?>">
            </div>
            <div class="account-info__data">
                <label class="account-info__data__label">Новый пароль</label>
                <input class="account-info__data__input" type="password" name="mechan_new_password">
            </div>
            <div class="account-info__btn-block">
                <div class="button account-info__button">
                    <input type="button" class="button__content account-info__submit" value="изменить данные">
                </div>
            </div>
        </div>
        <div class="account-services works">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Услуга</th>
                        <th>Клиент</th>
                        <th>Комментарий</th>
                        <th>Дата записи</th>
                        <th>Время записи</th>
                        <th>Статус</th>
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
                            echo ("<tr>
                                        <td>" . $work[0] . "</td>
                                        <td>" . $work[1] . "</td>
                                        <td>" . $work[2] . "</td>
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
                                </tr>");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </section>
</body>
<script src="../assets/js/mechanic.js"></script>
</html>