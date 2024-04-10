<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>регистрация</title>
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
    <h1>регистрация</h1>
    <form>
        <p><label>Ваше имя</label></p>
        <p><input type="text" name="name" class="name" placeholder="Введите своё имя"></p>
        <p><label>Логин</label></p>
        <p><input type="text" name="login" class="login" placeholder="Введите логин"></p>
        <p><label>Email</label></p>
        <p><input type="text" name="email" class="email" placeholder="Введите почту"></p>
        <p><label>Пароль</label></p>
        <p><input type="password" name="password" class="password" placeholder="Введите пароль"></p>
        <p><input type="password" name="password_confirm" class="password" placeholder="Повторите введенный пароль"></p>
        <p><button type="submit" class="register-btn">Зарегистрироваться</button></p>
        <p><a href="signin.php" class="have-acc">Уже есть аккаунт?</a></p>
        <p class="message none">error</p>
    </form>
</body>
<script src="assets/js/signup.js"></script>

</html>