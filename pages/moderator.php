<?php
require_once "../assets/api/isAdmin.php";
if ($isClient == true) {
    header("Location: ../index.php");
}
require_once "../assets/api/moderator_info_script.php";
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
    <title>Модерирование заказов</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="moderator-section">
        <div class="nav">
            <ul class="nav__list">
                <li class="nav__list__item info-btn">пользователи</li>
                <li class="nav__list__item orders-btn">заказанные услуги</li>
                <li class="nav__list__item history-btn">архив заказов</li>
                <li class="nav__list__item services-btn">услуги</li>
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
                            } else if ($user[6] == "confirmed") {
                                $isVerified = "Не подтвержден";
                            }

                            if ($user[5] == "admin") {
                                $role = "Администратор";
                                continue;
                            } else if ($user[5] == "client") {
                                $role = "Клиент";
                            } else if ($user[5] == "worker") {
                                $role = "Работник";
                            }

                            echo ("<tr>
                                    <td>" . $user[0] . "</td>
                                    <td>" . $user[1] . "</td>
                                    <td>" . $user[2] . "</td>
                                    <td>" . $user[3] . "</td>
                                    <td>" . $role . "</td>
                                    <td>" . $isVerified . "</td>
                                    <td>
                                        <div class='block-user' data-user-id='" . $user[0] . "''>
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
                        <th>Комментарий</th>
                        <th>Дата записи</th>
                        <th>Время записи</th>
                        <th>Статус</th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($accounts_books as $account_book) {
                            if ($account_book[6] == "completed") {
                                continue;
                            }

                            echo ("<tr>
                                    <td>" . $account_book[1] . "</td>
                                    <td>" . $account_book[2] . "</td>
                                    <td>" . (int) $account_book[7] . " р.</td>
                                    <td>" . $account_book[3] . "</td>
                                    <td>" . $account_book[4] . "</td>
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
                            echo ("<tr>
                                <td>" . $account_history[0] . "</td>
                                <td>" . $account_history[1] . "</td>
                                <td>" . $account_history[2] . "</td>
                                <td>" . $account_history[3] . "</td>
                                <td>" . $account_history[4] . "</td>
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
        <div class="account-services services">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Стоимость</th>
                        <th>Тип услуги</th>
                        <th></th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        foreach ($services as $service) {
                            echo ("<tr>
                                <td>" . $service[0] . "</td>
                                <td>" . $service[1] . "</td>
                                <td>" . $service[2] . "</td>
                                <td>" . (int) $service[3] . " р.</td>
                                <td>" . $service[4] . "</td>
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
                        <tr id="new-service-row">
                            <td></td>
                            <td><input type="text" class="add-service-input" name="service_name" id="service_name"></td>
                            <td><input type="text" class="add-service-input" name="service_description"
                                    id="service_description"></td>
                            <td><input type="text" class="add-service-input" name="service_price" id="service_price">
                            </td>
                            <td>
                                <select class="add-service-input" name="service_type" id="service_type">
                                <?php
                                    foreach($services_types as $services_type){
                                        echo("<option value='".$services_type[0]."'>".$services_type[1]."</option>");
                                    }
                                ?>
                                    
                                </select>
                            </td>
                            <td>
                                <div class="add-service-button">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24'><path fill='#232323' d='M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z'/></svg>
                                </div>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
    </section>
    <?php require_once "../includes/footer.php"; ?>
</body>
<script src="../assets/js/moderator.js"></script>

</html>