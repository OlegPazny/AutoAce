<?php
// Запускаем сессию
session_start();

require_once "db_connect.php";

$login = $_POST['login'];
$password = $_POST['password'];

if ($login === '' || preg_match("/^[A-Za-z][A-Za-z._]*[A-Za-z]$/", $login) == 0) {
    $error_fields[] = 'signin_login';
    $message = "Логин может содержать _ и ., а также буквы латинского алфавита";
}
if (!empty($error_fields)) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => $message,
        "fields" => $error_fields
    ];
    echo json_encode($response);
    die();
}
if ($password === '' || preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/", $password) == 0) {
    $error_fields[] = 'signin_password';
    $message = "Пароль должен состоять из минимум 8 символов и содержать заглавные, строчные буквы и цифры.";
}

if (!empty($error_fields)) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => $message,
        "fields" => $error_fields
    ];
    echo json_encode($response);
    die();
}

$password = md5($password);//хеш пассворда

$check_user = mysqli_query($db, "SELECT 'user' AS source, id FROM users
                                WHERE login = '$login' AND password = '$password' AND isVerified=1
                                UNION
                                SELECT 'worker' AS source, id FROM workers
                                WHERE login = '$login' AND password = '$password'
                            ");

if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);
    if ($user['source'] == "user") {
        $userId = $user['id'];
        $user_data = mysqli_query($db, "SELECT * FROM `users` WHERE `id`=$userId");
        $user_data = mysqli_fetch_assoc($user_data);

        $_SESSION['user'] = [
            "id" => $user_data['id'],
            "UserName" => $user_data['login'],
            "role" => $user_data['role'],
            "email" => $user_data['email'],
        ];
    } else if ($user['source'] == "worker") {
        $userId = $user['id'];
        $user_data = mysqli_query($db, "SELECT * FROM `workers` WHERE `id`=$userId");
        $user_data = mysqli_fetch_assoc($user_data);

        $_SESSION['user'] = [
            "id" => $user_data['id'],
            "UserName" => $user_data['login'],
            "role" => "mechanic",
            "email" => $user_data['email'],
        ];

    }
    $response = [
        "status" => true,
    ];

    echo json_encode($response);

    $_SESSION['loggedin'] = true;
} else {
    $response = [
        "status" => false,
        "message" => 'Неверный логин или пароль.',
    ];

    echo json_encode($response);
}
?>