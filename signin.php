<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>авторизация</title>
</head>

<body>
    <h1>авторизация</h1>
    <form class="form">
        <input type="text" class="form-control" id="text" aria-describedby="emailHelp" name="login"
            placeholder="Логин...">
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль...">
        <input type="submit" class=" login-btn btn btn-info btn-link btn-wd btn-lg" value="Войти" />
        <a href="signup.php">Регистрация</a>
    </form>
</body>
<script src="assets/js/auth.js"></script>
</html>