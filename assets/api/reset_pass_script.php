<?php
    session_start();
    
    require_once "db_connect.php";
    require_once "mail_client_connect.php";

    $hash=$_POST['hash'];
    $password=$_POST['password'];
    $password_confirm=$_POST['password_confirm'];

    $users_data=mysqli_query($db, "SELECT * FROM `users`");
    $users_data=mysqli_fetch_all($users_data);
   
    $isTrusted=false;
    foreach($users_data as $user_data){
        $current_user=md5($user_data[1].$user_data[2].$user_data[3]);

        if($hash===$current_user){
            $trusted_id=$user_data[0];
            $trusted_name=$user_data[2];
            $trusted_email=$user_data[3];
            $isTrusted=true;
        }else{
            $isTrusted=false;
        }
    }
//если не найдено пользователей отключаемся
    if(!isset($trusted_id)){
        die();
    }

    //валидация
    $error_fields=[];
    
    if($password===''||preg_match("/^[a-zA-Z0-9]{8,}$/",$password)==0){
        $error_fields[]='password';
    }
    
    if($password_confirm===''){
        $error_fields[]='password_confirm';
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

    
    if($password===$password_confirm){
        $password=md5($password);

        mysqli_query($db, "UPDATE `users` SET `password`='$password' WHERE `id`=$trusted_id");

        $body="<h1>Уважаемый ".$trusted_name.", пароль Вашей учетной записи был успешно изменен!</h1>";
        send_mail($settings['mail_settings'], [$trusted_email], 'Смена пароля', $body);

        $response=[
            "status"=>true,
            "message"=>"Пароль обновлен",
        ];
        echo json_encode($response);
    }else{
        $response=[
            "status"=>false,
            "message"=>"Пароли не совпадают",
        ];
        echo json_encode($response);
    }
?>