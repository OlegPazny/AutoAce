<?php
// Запускаем сессию
session_start();

$_SESSION['last_activity'] = time(); // Обновляем время последней активности
    //подключение к БД
    require_once "db_connect.php";
    
    $login=$_POST['login'];
    $password=$_POST['password'];

    if($login===''||preg_match("/^[A-Za-z]+$/",$login)==0){
        $error_fields[]='login';
    }

    if($password===''){
        $error_fields[]='password';
    }

    if(!empty($error_fields)){
        $response=[
            "status"=>false,
            "type"=>1,
            "message"=>"Проверьте правильность полей",
            "fields"=>$error_fields
        ];
        echo json_encode($response);
        die();
    }

    $password=md5($password);//хеш пассворда

    $check_user=mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password'");

    if(mysqli_num_rows($check_user)>0){
        $user=mysqli_fetch_assoc($check_user);

            $_SESSION['user']=[
                "id"=>$user['id'],
                "UserName"=>$user['login'],
            ];

            $response=[//ответ авторизации
                "status"=>true,
            ];

            echo json_encode($response);

            $_SESSION['loggedin'] = true;
    }else{
        $response=[//ответ авторизации
            "status"=>false,
            "message"=>'Авторизация неуспешна',
        ];

        echo json_encode($response);
    }
?>