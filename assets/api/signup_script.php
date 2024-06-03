<?php
    session_start();
    
    require_once "db_connect.php";
    require_once "mail_client_connect.php";
    
    $login=$_POST['login'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password_confirm=$_POST['password_confirm'];

    $recorded_user=false;
    //проверка на существование логина
    $check_login=mysqli_query($db, "SELECT * FROM `users` WHERE `login`='$login'");

    if(mysqli_num_rows($check_login)>0){
        $response=[
            "status"=>false,
            "type"=>1,
            "message"=>"Пользователь с таким логином уже существует.",
            "fields"=>['login']
        ];
        echo json_encode($response);
        die();
    }
    //проверка на существование почты
    $check_email=mysqli_query($db, "SELECT * FROM `users` WHERE `email`='$email'");

    if(mysqli_num_rows($check_email)>0){
        $check_other_data=mysqli_fetch_assoc($check_email);
        if($check_other_data['name']!=NULL && $check_other_data['login']!=NULL && $check_other_data['password']!=NULL){
            $response=[
                "status"=>false,
                "type"=>1,
                "message"=>"Пользователь с такой почтой уже зарегистрирован.",
                "fields"=>['email']
            ];
            echo json_encode($response);
            die();
        }else{
            $recorded_user_id=$check_other_data['id'];
            $recorded_user=true;
        }
    }
    //валидация
    $error_fields=[];
    if($name==='' || preg_match("/^[А-Яа-яЁё]+$/u", $name) == 0){
        $error_fields[]='name';
        $message = "Имя должно быть написанно на кириллице.";
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
    if ($login === '' || preg_match("/^[A-Za-z][A-Za-z._]*[A-Za-z]$/", $login) == 0) {
        $error_fields[] = 'signin_login';
        $message = "Логин может содержать _ и ., а также буквы латинского алфавита.";
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

    if($email==='' || !filter_var($email, FILTER_VALIDATE_EMAIL)||preg_match("/^[\w\.-]+@[a-z]+\.[a-z]+$/",$email)==0){
        $error_fields[]='email';
        $message = "Почта введена некорректно.";
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
    if($password_confirm===''){
        $error_fields[]='password_confirm';
        $message = "Введите пароль повторно.";
    }

    if(!empty($error_fields)){
        $response=[
            "status"=>false,
            "type"=>1,
            "message"=>$message,
            "fields"=>$error_fields
        ];

        echo json_encode($response);
        die();
    }

    
    if($password===$password_confirm){
        $password=md5($password);
        if($recorded_user==false){
            mysqli_query($db, "INSERT INTO `USERS` (`id`, `login`, `name`, `email`, `password`, `role`, `isVerified`) VALUES (NULL, '$login', '$name', '$email', '$password', 'client', 0)");
        }else if($recorded_user==true){
            mysqli_query($db, "UPDATE `users` SET `login`='$login', `name`='$login', `password`='$password' WHERE `id`=$recorded_user_id");
        }


        $hash=md5($login.$name.$email);
        $body="<h1>Пожалуйста, перейдите по <a href='autoace/pages/verify.php?hash=$hash' target='_blank'>ссылке</a>, если вы хотите подтвердить регистрацию!</h1>";
        send_mail($settings['mail_settings'], [$email], 'Подтвердите регистрацию!', $body);

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