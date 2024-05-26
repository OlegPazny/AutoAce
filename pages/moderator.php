<?php
session_start();
if (!isset($_SESSION['user']['id'])) {
    header('Location: ../index.php');
}
require_once "../assets/api/isAdmin.php";
if ($isClient == true) {
    header("Location: ../index.php");
}
require_once "../assets/api/moderator_info_script.php";
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
    <!-- jQuery connection -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/pooper.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <!-- jQuery connection -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>Модерирование заказов</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="moderator-section">
        <div class="nav">
            <ul class="nav__list">
                <li class="nav__list__item info-btn">пользователи</li>
                <li class="nav__list__item workers-btn">работники</li>
                <li class="nav__list__item orders-btn">заказанные услуги</li>
                <li class="nav__list__item history-btn">архив заказов</li>
                <li class="nav__list__item service-types-btn">тип услуги</li>
                <li class="nav__list__item services-btn">услуги</li>
                <li class="nav__list__item relations-btn">назначить услуги</li>
            </ul>
        </div>
        <div class="account-services accounts">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Логин</th>
                        <th>Имя</th>
                        <th>Почта</th>
                        <th>Роль</th>
                        <th>Подтвержден</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($users as $user) {
                            if ($user[6] == "1") {
                                $isVerified = "Подтвержден";
                            } else if ($user[6] == "0") {
                                $isVerified = "Не подтвержден";
                            }

                            if ($user[5] == "admin") {
                                $role = "Администратор";
                            } else if ($user[5] == "client") {
                                $role = "Клиент";
                            } else if ($user[5] == "worker") {
                                $role = "Работник";
                            }

                            $name="Клиент";
                            if($user[2]!=NULL){
                                $name=$user[2];
                            }
                            $login="Client";
                            if($user[1]!=NULL){
                                $login=$user[1];
                            }

                            echo ("<tr>
                                    <td>" . $user[0] . "</td>
                                    <td>" . $login . "</td>
                                    <td>" . $name . "</td>
                                    <td>" . $user[3] . "</td>
                                    <td>");
                            if ($user[5] != "admin") { ?>
                                <select class='role-select' data-user-id="<?php echo $user[0]; ?>">
                                    <option value='client' <?php if ($user[5] == "client")
                                        echo "selected"; ?>>
                                        Клиент</option>
                                    <option value='worker' <?php if ($user[5] == "worker")
                                        echo "selected"; ?>>
                                        Работник</option>
                                </select>
                            <?php } else {
                                echo ("Администратор");
                            }
                            echo ("
                                    </td>
                                    <td>" . $isVerified . "</td>
                                    <td>");
                            if ($user[5] != "admin") {
                                echo ("
                                    <div class='block-user' data-user-id='" . $user[0] . "''>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                            <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                                        </svg>
                                    </div>
                                    ");
                            }
                            echo (" 
                                    </td>
                                </tr>");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <div class="account-services workers">
            <table class="workers-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Логин</th>
                        <th>Имя</th>
                        <th>Почта</th>
                        <th>Автосервис</th>
                        <th>Отпуск</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <tr class="add-worker-row">
                            <td></td>
                            <td></td>
                            <td><input type="text" class="add-worker-name-input admin-input" name="worker_name"
                                    id="worker_name"></td>
                            <td><input type="email" class="add-worker-email-input admin-input" name="worker_email"
                                    id="worker_email"></td>
                            <td>
                                <select class="worker-workshops-insert" name="worker_workshops_insert"
                                    id="worker_workshops_insert">
                                    <?php
                                    foreach ($workshops as $workshop) {
                                        echo ("<option value='" . $workshop[0] . "'>" . $workshop[1] . "</option>");
                                    }
                                    ?>
                                </select>
                            </td>
                            <td></td>
                            <td>
                                <div class="add-worker-button">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em'
                                        viewBox='0 0 24 24'>
                                        <path fill='#232323'
                                            d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z' />
                                    </svg>
                                </div>
                            </td>
                        </tr>
                        <?php
                        foreach ($workers as $worker) {
                            echo ("<tr>
                                    <td>" . $worker[0] . "</td>
                                    <td>" . $worker[3] . "</td>
                                    <td>" . $worker[1] . "</td>
                                    <td>" . $worker[4] . "</td>
                                    <td>" . $worker[2] . "</td>
                                    <td>");
                                    ?>
                                        <select class='vacation-select' data-worker-id="<?php echo $worker[0]; ?>">
                                            <option value='0' <?php if ($worker[5] == "0")
                                                echo "selected"; ?>>Работает</option>
                                            <option value='1' <?php if ($worker[5] == "1")
                                                echo "selected"; ?>>
                                                В отпуске</option>
                                        </select>
                        <?php echo ("</td>
                                    <td>
                                        <div class='block-worker' data-worker-id='" . $worker[0] . "''>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                                <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                                            </svg>
                                        </div>
                                    </td>
                                </tr>");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <div class="account-services orders">
            <table>
                <thead>
                    <tr>
                        <th>Автосервис</th>
                        <th>Услуга</th>
                        <th>Стоимость</th>
                        <th>Клиент</th>
                        <th>Автомобиль</th>
                        <th>Комментарий</th>
                        <th>Дата записи</th>
                        <th>Время записи</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($accounts_books as $account_book) {
                            if ($account_book[6] == "completed") {
                                continue;
                            }
                            $name="Клиент";
                            if($account_book[10]!=NULL){
                                $name=$account_book[10];
                            }
                            $date = strtotime($account_book[4]); // Преобразование строки в дату
                            $day = date('j', $date);
                            $month = date('n', $date);
                            $date = $day . ' ' . russianMonth($month);

                            $price=(int) $account_book[7]*(int)$account_book[11];
                            if($account_book[9]!=NULL){
                                $price=$price*(100-(int)$account_book[9])/100;
                            }
                            echo ("<tr>
                                    <td>" . $account_book[1] . "</td>
                                    <td>" . $account_book[2] . "</td>
                                    <td>" . $price . " р.</td>
                                    <td>" . $name . "</td>
                                    <td>" . $account_book[12] . "</td>
                                    <td>" . $account_book[3] . "</td>
                                    <td>" . $date . "</td>
                                    <td>" . substr($account_book[5], 0, 5) . "</td>
                                    <td>");
                            ?>
                            <select class='status-select' data-booking-id="<?php echo $account_book[0]; ?>">
                                <option value='pending' <?php if ($account_book[6] == "pending")
                                    echo "selected"; ?>>В
                                    обработке</option>
                                <option value='confirmed' <?php if ($account_book[6] == "confirmed")
                                    echo "selected"; ?>>
                                    Принято в работу</option>
                                <option value='completed' <?php if ($account_book[6] == "completed")
                                    echo "selected"; ?>>
                                    Выполнено</option>
                            </select>
                            <?php echo ("</td>
                                    <td>
                                        <div class='delete-book' data-book-id='" . $account_book[0] . "''>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                                <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                                            </svg>
                                        </div>
                                    </td>
                            </tr>");
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
                        <th>Работник</th>
                        <th>Услуга</th>
                        <th>Комментарий</th>
                        <th>Дата записи</th>
                        <th>Время записи</th>
                        <th>Статус</th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($accounts_history as $account_history) {
                            $date = strtotime($account_history[3]); // Преобразование строки в дату
                            $day = date('j', $date);
                            $month = date('n', $date);
                            $date = $day . ' ' . russianMonth($month);
                            echo ("<tr>
                                <td>" . $account_history[7] . "</td>
                                <td>" . $account_history[0] . "</td>
                                <td>" . $account_history[1] . "</td>
                                <td>" . $account_history[2] . "</td>
                                <td>" . $date . "</td>
                                <td>" . substr($account_history[4], 0, 5) . "</td>
                                <td>");
                            ?>
                            <select class='history-status-select' data-booking-id="<?php echo $account_history[6]; ?>">
                                <option value='pending' <?php if ($account_history[5] == "pending")
                                    echo "selected"; ?>>В
                                    обработке</option>
                                <option value='confirmed' <?php if ($account_history[5] == "confirmed")
                                    echo "selected"; ?>>
                                    Принято в работу</option>
                                <option value='completed' <?php if ($account_history[5] == "completed")
                                    echo "selected"; ?>>
                                    Выполнено</option>
                            </select>
                            <?php echo ("</td>
                                </tr>
                                ");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <div class="account-services service-types">
            <table class="service-types-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Название</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <tr id="new-service-type-row">
                            <td></td>
                            <td><input type="text" class="add-service-input admin-input" name="service-type_name"
                                    id="service-type_name"></td>
                            </td>
                            <td>
                                <div class="add-service-type-button">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em'
                                        viewBox='0 0 24 24'>
                                        <path fill='#232323'
                                            d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z' />
                                    </svg>
                                </div>
                            </td>
                        </tr>
                        <?php
                        foreach ($services_types as $service_type) {
                            echo ("<tr>
                                    <td>" . $service_type[0] . "</td>
                                    <td>" . $service_type[1] . "</td>
                                    <td>
                                        <div class='delete-service-type' data-service-type-id='" . $service_type[0] . "''>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                                <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                                ");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <div class="account-services services">
            <table class="services-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Нормочас</th>
                        <th>Тип услуги</th>
                        <th>Скидка, %</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <tr id="new-service-row">
                            <td></td>
                            <td><input type="text" class="add-service-input admin-input" name="service_name"
                                    id="service_name"></td>
                            <td><input type="text" class="add-service-input admin-input" name="service_description"
                                    id="service_description"></td>
                            <td><input type="text" class="add-service-input admin-input" name="service_price"
                                    id="service_price">
                            </td>
                            <td>
                                <select class="add-service-input" name="service_type" id="service_type">
                                    <?php
                                    foreach ($services_types as $services_type) {
                                        echo ("<option value='" . $services_type[0] . "'>" . $services_type[1] . "</option>");
                                    }
                                    ?>

                                </select>
                            </td>
                            <td><input type="text" class="add-service-input admin-input" name="service_discount"
                                    id="service_discount"></td>
                            <td>
                                <div class="add-service-button">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em'
                                        viewBox='0 0 24 24'>
                                        <path fill='#232323'
                                            d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z' />
                                    </svg>
                                </div>
                            </td>
                        </tr>
                        <?php
                        foreach ($services as $service) {
                            echo ("<tr>
                                <td>" . $service[0] . "</td>
                                <td>" . $service[1] . "</td>
                                <td>" . $service[2] . "</td>
                                <td>" . $service[3] . " н/ч</td>
                                <td>" . $service[4] . "</td>
                                <td>" . $service[5] . "</td>
                                <td>
                                    <div class='delete-service' data-service-id='" . $service[0] . "''>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                            <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                                        </svg>
                                    </div>
                                </td>
                                </tr>
                                ");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
        <div class="account-services relations">
            <table class="relations-table">
                <thead>
                    <tr>
                        <th>Работник</th>
                        <th>Автосервис</th>
                        <th>Услуга</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody class="relations-table-body">
                    <tr class="add-relation-row">
                            <td>
                                <select class="workers-input" name="relation_worker_name" id="relation_worker_name">
                                    <?php
                                    foreach ($workers as $worker) {
                                        echo ("<option value='" . $worker[0] . "'>" . $worker[1] . "</option>");
                                    }
                                    ?>

                                </select>
                            </td>
                            <td id="worker-workshop"></td>
                            <td>
                                <select class="services-input" name="relation_service_name" id="relation_service_name">
                                    <?php
                                    foreach ($new_services as $new_service) {
                                        echo ("<option value='" . $new_service[0] . "'>" . $new_service[1] . "</option>");
                                    }
                                    ?>

                                </select>
                            </td>
                            <td>
                                <div class="add-relation-button">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em'
                                        viewBox='0 0 24 24'>
                                        <path fill='#232323'
                                            d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z' />
                                    </svg>
                                </div>
                            </td>
                        </tr>
                        <?php
                        foreach ($worker_services as $worker_service) {
                            echo ("<tr>
                                <td>" . $worker_service[1] . "</td>
                                <td>" . $worker_service[3] . "</td>
                                <td>" . $worker_service[2] . "</td>
                                <td>
                                    <div class='delete-relation' data-relation-id='" . $worker_service[0] . "''>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                            <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                                        </svg>
                                    </div>
                                </td>
                                </tr>
                                ");
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </section>
    <?php require_once "../includes/footer.php"; ?>
</body>
<script src="../assets/js/moderator.js"></script>

</html>