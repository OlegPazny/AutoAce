<?php
    session_start();
    
    require_once "db_connect.php";
    require_once "mail_client_connect.php";

    $email=$_POST['email'];

    //проверка на существование логина
    $user_data=mysqli_query($db, "SELECT * FROM `users` WHERE `email`='$email'");

    if(!mysqli_num_rows($user_data)>0){
        $response=[
            "status"=>false,
            "type"=>1,
            "message"=>"Такого пользователя не существует",
            "fields"=>['login']
        ];
        echo json_encode($response);
        die();
    }else{
        $user_data=mysqli_fetch_assoc($user_data);
    }
    //валидация
    $error_fields=[];
    
    if($email==='' || !filter_var($email, FILTER_VALIDATE_EMAIL)||preg_match("/^[\w\.-]+@[a-z]+\.[a-z]+$/",$email)==0){
        $error_fields[]='email';
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
    }else{
        $hash=md5($user_data['login'].$user_data['name'].$user_data['email']);
        $body="<h1>Пожалуйста, перейдите по <a href='autoace/pages/reset_password.php?hash=$hash' target='_blank'>ссылке</a>, если вы хотите изменить пароль!</h1>";
        send_mail($settings['mail_settings'], [$email], 'Изменение пароля!', $body);

        $response=[
            "status"=>true,
            "message"=>"Сообщение отправлено на почту"
        ];
        echo json_encode($response);
    }
?>