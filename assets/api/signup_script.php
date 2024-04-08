<?php
    session_start();
    
    require_once "db_connect.php";
    require_once "mail_client_connect.php";
    
    $login=$_POST['login'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password_confirm=$_POST['password_confirm'];

    //проверка на существование логина
    $check_login=mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$login'");

    if(mysqli_num_rows($check_login)>0){
        $response=[
            "status"=>false,
            "type"=>1,
            "message"=>"Такой пользователь уже существует",
            "fields"=>['login']
        ];
        echo json_encode($response);
        die();
    }
    //валидация
    $error_fields=[];

    if($login===''){
        $error_fields[]='login';
    }

    if($name===''){
        $error_fields[]='name';
    }
    
    if($email==='' || !filter_var($email, FILTER_VALIDATE_EMAIL)||preg_match("/^[\w\.-]+@[a-z]+\.[a-z]+$/",$email)==0){
        $error_fields[]='email';
    }
    
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

        mysqli_query($db, "INSERT INTO `USERS` (`id`, `login`, `name`, `email`, `password`, `role`, `isVerified`) VALUES (NULL, '$login', '$name', '$email', '$password', 'client', 0)");

        $hash=md5($login.$name.$email);
        $body="<h1>Пожалуйста, перейдите по <a href='autoace/verify.php?hash=$hash' target='_blank'>ссылке</a>, если вы хотите подтвердить регистрацию!</h1>";
        var_dump(send_mail($settings['mail_settings'], [$email], 'Подтвердите регистрацию!', $body));

        $response=[
            "status"=>true,
            "message"=>"Регистрация успешна",
        ];
        echo json_encode($response);
    }else{
        $response=[
            "status"=>false,
            "message"=>"Регистрация неуспешна, пароли не совпадают",
        ];
        echo json_encode($response);
    }
?>