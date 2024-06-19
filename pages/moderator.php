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
    <link rel="icon" href="../assets/images/favicon.svg" />
    <!-- jQuery connection -->
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="../assets/js/core/popper.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> -->
    <!-- jQuery connection -->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>Модерирование заказов</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="account-section moder-section">
        <div class="nav">
            <div class="burger-menu-account moder-menu-account"></div>
            <ul class="nav__list moder-nav">
                <li class="nav__list__item info-btn">Пользователи</li>
                <li class="nav__list__item workers-btn">Работники</li>
                <li class="nav__list__item orders-btn">Заказанные услуги</li>
                <li class="nav__list__item history-btn">Архив заказов</li>
                <li class="nav__list__item service-types-btn">Типы услуг</li>
                <li class="nav__list__item services-btn">Услуги</li>
                <li class="nav__list__item relations-btn">Назначить услуги</li>
            </ul>
        </div>
        <div class="account-services accounts">
            <h2>Аккаунты пользователей</h2>
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

                            $name = "Клиент";
                            if ($user[2] != NULL) {
                                $name = $user[2];
                            }
                            $login = "Client";
                            if ($user[1] != NULL) {
                                $login = $user[1];
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
            <h2>Работники</h2>
            <table class="workers-table">
                <thead>
                    <tr>
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
                            <td><input type="text" class="add-worker-name-input admin-input" name="worker_name"
                                    id="worker_name"></td>
                            <td><input type="email" class="add-worker-email-input admin-input" name="worker_email"
                                    id="worker_email"></td>
                            <td>
                                <select class="worker-workshops-insert" name="worker_workshops_insert"
                                    id="worker_workshops_insert">
                                    <option selected disabled>Выберите автосервис</option>
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
            <h2>Заказанные услуги</h2>
            <table>
                <thead>
                    <tr>
                        <th>Автосервис</th>
                        <th>Услуга</th>
                        <th>Стоимость</th>
                        <th>Клиент</th>
                        <th>Автомобиль<br>VIN</th>
                        <th>Комментарий</th>
                        <th>Дата&nbspзаписи</th>
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
                            $name = "Клиент";
                            if ($account_book[10] != NULL) {
                                $name = $account_book[10];
                            }
                            $dateTime = new DateTime($account_book[4]);
                            // Преобразуем дату в нужный формат
                            $date = $dateTime->format('d-m-Y');

                            $price = (int) $account_book[7] * (int) $account_book[11];
                            if ($account_book[9] != NULL) {
                                $price = $price * (100 - (int) $account_book[9]) / 100;
                            }
                            $vin_data="";
                            if($account_book[12]!=NULL){
                                $vin_data=$account_book[12] . "<br>".$account_book[14]."<br><input class='admin-input admin_vin' type='text' value='".$account_book[13]."' name='admin_vin'>";
                            }
                            echo ("<tr>
                                    <td>" . $account_book[1] . "</td>
                                    <td>" . $account_book[2] . "</td>
                                    <td>" . $price . " р.</td>
                                    <td>" . $name . "</td>
                                    <td class='vehicle-data'>" . $vin_data ."</td>
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
                                        <div class='update-book-button' data-book-id='".$account_book[0]."'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em'
                                                    viewBox='0 0 24 24'>
                                                    <path fill='#232323'
                                                        d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z' />
                                                </svg>
                                        </div>
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
            <h2>Архив заказов</h2>
            <table>
                <thead>
                    <tr>
                        <th>Механик</th>
                        <th>Автомобиль</th>
                        <th>Клиент</th>
                        <th>Комментарий механика</th>
                        <th>Дата выполнения</th>
                        <th>Время выполнения</th>
                        <th>Конечная стоимость</th>
                        <th>Статус</th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($accounts_history as $account_history) {
                            $dateTime = new DateTime($account_history[3]);
                            // Преобразуем дату в нужный формат
                            $date = $dateTime->format('d-m-Y');
                            $price = $account_history[8] * $account_history[9];
                            if ($account_history[10] != NULL) {
                                $price = $price * (100 - $account_history[10]) / 100;
                            }
                            echo ("<tr>
                                <td>" . $account_history[0] . "</td>
                                <td>".$account_history[13]."<br>".$account_history[14]."</td>
                                <td>" . $account_history[11] . "</td>
                                <td>" . $account_history[2] . "</td>
                                <td>" . $date . "</td>
                                <td>" . substr($account_history[4], 0, 5) . "</td>
                                <td>" . $account_history[12] . " р.</td>
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
            <h2>Типы услуг</h2>
            <table class="service-types-table">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <tr id="new-service-type-row">
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
            <h2>Услуги</h2>
            <table class="services-table">
                <thead>
                    <tr>
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
                            <td><input type="text" class="add-service-input admin-input" name="service_name"
                                    id="service_name"></td>
                            <td><input type="text" class="add-service-input admin-input" name="service_description"
                                    id="service_description"></td>
                            <td><input type="text" class="add-service-input admin-input" name="service_price"
                                    id="service_price">
                            </td>
                            <td>
                                <select class="add-service-input" name="service_type" id="service_type">
                                    <option selected disabled>Выберите тип услуги</option>
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
                                <td>" . $service[1] . "</td>
                                <td>" . $service[2] . "</td>
                                <td>" . $service[3] . " н/ч</td>
                                <td>" . $service[4] . "</td>
                                <td><input class='admin-input' type='text' name='service_discount' value='" . $service[5] . "'></td>
                                <td>
                                    <div class='update-service' data-service-id='" . $service[0] . "''>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24'>
                                            <path fill='none' stroke='#232323' stroke-width='2' d='M1.75 16.002C3.353 20.098 7.338 23 12 23c6.075 0 11-4.925 11-11m-.75-4.002C20.649 3.901 16.663 1 12 1C5.925 1 1 5.925 1 12m8 4H1v8M23 0v8h-8'/>
                                        </svg>
                                    </div>
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
            <h2>Назначить услуги</h2>
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
                                    <option selected disabled>Выберите механика</option>
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
    <?php require_once "../includes/popup.php"; ?>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>

<script src="../assets/js/moderator.js"></script>
<script src="../assets/js/account_burger.js"></script>

</html>