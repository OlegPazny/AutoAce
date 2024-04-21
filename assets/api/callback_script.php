<?php
    require_once "mail_client_connect.php";

    $name=$_POST['name'];
    $user_email=htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $message=$_POST['message'];

    $email="autoaceworkshop@gmail.com";
    $body="
        <h3>Имя: </h3>".$name."<br>
        <h3>Почта: </h3>".$user_email."<br><br>
        <p>".$message."</p>
    ";
    var_dump(send_mail($settings['mail_settings'], [$email], 'У Вас вопрос от клиента!', $body));
?>