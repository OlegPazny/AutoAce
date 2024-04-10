<?php
    require_once "assets/api/get_hash_script.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>сброс пароля</title>
</head>
<style>
    .message{
        color:red;
    }
    .none{
        display:none;
    }
</style>
<body>
    <form>
        <input type="hidden" value="<?php echo $hash;?>" name="hash" class="hash">
        <input type="password" name="password" class="password" placeholder="Введите новый пароль">
        <input type="password" name="password_confirm" class="password" placeholder="Повторите новый пароль">
        <button type="submit" class="reset-btn">Подтвердить</button>
    </form>
    <p class="message none">error</p>
</body>
<script src="assets/js/reset_pass.js"></script>
</html>