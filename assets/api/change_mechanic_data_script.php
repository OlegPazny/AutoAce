<?php
session_start();

require_once "db_connect.php";
require_once "mail_client_connect.php";

$current_user = $_SESSION['user']['id'];
$current_password = mysqli_query($db, "SELECT `password` FROM `workers` WHERE `id`=$current_user");
$current_password = mysqli_fetch_assoc($current_password);
$current_email = mysqli_query($db, "SELECT `email` FROM `workers` WHERE `id`=$current_user");
$current_email = mysqli_fetch_assoc($current_email);
$name = $_POST['mechan_name'];
$email = $_POST['mechan_email'];
$password = $_POST['mechan_password'];
$new_password = $_POST['mechan_new_password'];

//валидация
$error_fields = [];

if ($name != '' || preg_match("/^[А-Яа-яЁё]+$/u", $name) == 0) {
    $change_name = mysqli_query($db, "UPDATE `workers` SET `name`='$name' WHERE `id`=$current_user");
} else {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Имя не может быть пустым и должно быть написано кириллицей.",
        "fields" => ['mechan_name']
    ];
    echo json_encode($response);
    die();
}
if ($current_email['email'] != $email) {
    if ($email != '' && filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[\w\.-]+@[a-z]+\.[a-z]+$/", $email) != 0) {
        //проверка на существование почты
        $check_email = mysqli_query($db, "SELECT `email` FROM `workers` WHERE `email`='$email'");

        if (mysqli_num_rows($check_email) > 0) {
            $response = [
                "status" => false,
                "type" => 1,
                "message" => "Механик с такой почтой уже зарегистрирован.",
                "fields" => ['mechan_email']
            ];
            echo json_encode($response);
            die();
        }
        $change_email = mysqli_query($db, "UPDATE `workers` SET `email`='$email' WHERE `id`=$current_user");
    }else{
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "Введите почту корректно.",
            "fields" => ['mechan_email']
        ];
        echo json_encode($response);
        die();
    }   
}
if ($password != "" && $new_password != "") {
    if (md5($password) === $current_password['password']) {
        if (preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $new_password) != 0) {
            $new_password = md5($new_password);
            $change_password = mysqli_query($db, "UPDATE `workers` SET `password`='$new_password' WHERE `id`=$current_user");
        } else {
            $response = [
                "status" => false,
                "type" => 1,
                "message" => "Пароль должен состоять из 8 символов, а также содержать прописную и строчные буквы и цифры.",
                "fields" => ['mechan_new_password']
            ];
            echo json_encode($response);
            die();
        }

    } else {
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "Неверно введен текущий пароль",
            "fields" => ['mechan_password']
        ];
        echo json_encode($response);
        die();
    }
}
$response = [
    "status" => true
];
echo json_encode($response);
?>