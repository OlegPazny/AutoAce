<?php
session_start();

require_once "db_connect.php";
require_once "mail_client_connect.php";

$current_user = $_SESSION['user']['id'];
$current_password = mysqli_query($db, "SELECT `password` FROM `users` WHERE `id`=$current_user");
$current_password = mysqli_fetch_assoc($current_password);
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$new_password = $_POST['new_password'];

//валидация
$error_fields = [];

if ($name != '') {
    $change_name = mysqli_query($db, "UPDATE `users` SET `name`='$name' WHERE `id`=$current_user");
}

if ($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[\w\.-]+@[a-z]+\.[a-z]+$/", $email) != 0) {
    //проверка на существование почты
    $check_email = mysqli_query($db, "SELECT `email` FROM `users` WHERE `email`='$email'");

    if (mysqli_num_rows($check_email) > 0) {
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "Пользователь с такой почтой уже зарегистрирован",
            "fields" => ['email']
        ];
        echo json_encode($response);
        die();
    }
    $change_email = mysqli_query($db, "UPDATE `users` SET `email`='$email' WHERE `id`=$current_user");
}

if (md5($password) === $current_password['password']) {
    echo("пароли совпали");
    if (preg_match("/^[a-zA-Z0-9]{8,}$/", $new_password) != 0) {
        $new_password=md5($new_password);
        $change_password = mysqli_query($db, "UPDATE `users` SET `password`='$new_password' WHERE `id`=$current_user");
    }

}
?>