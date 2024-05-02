<?php
    require_once "db_connect.php";
    require_once "mail_client_connect.php";

    function generateRandomPassword($length = 8) {
        // Строка символов, из которых будет состоять пароль
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
    
        // Генерируем случайный пароль
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomPassword;
    }

    $workerName = $_POST['worker_name'];

    $password = generateRandomPassword();
    $workerPassword=md5($password);

    $workerEmail = $_POST['worker_email'];
    $workerWorkshop = $_POST['worker_workshop'];
    $workerHours = $_POST['worker_hours'];

    $body="
        <p>Добро пожаловать в штат сотрудников AutoAce!</p>
        <p>Почта: ".$workerEmail."</p>
        <p>Пароль: ".$password."</p>
    ";

    $insert_worker=mysqli_query($db, "INSERT INTO `workers` (`id`, `name`, `workshop_id`, `max_hours`, `email`, `password`) VALUES (NULL, '$workerName', '$workerWorkshop', '$workerHours', '$workerEmail', '$workerPassword')");
    var_dump(send_mail($settings['mail_settings'], [$workerEmail], 'Вас зарегистрировали в системе AutoAce!', $body));
?>