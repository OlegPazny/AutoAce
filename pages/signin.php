<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>авторизация</title>
</head>
<style>
    .message {
        color: red;
    }

    .none {
        display: none;
    }
</style>

<body>
    <section class="signup-section">
        <form>
            <div class="signup">
                <img class="signup__img" src="../assets/images/logo_dark.png">
                <div class="signup__input-block">
                    <label>Логин</label>
                    <input type="text" name="login" class="login" placeholder="Введите логин">
                </div>
                <div class="signup__input-block">
                    <label>Пароль</label>
                    <input type="password" name="password" class="password" placeholder="Введите пароль">
                </div>
                <div class="signup__submit-block button">
                    <input type="submit" class="login-btn button__content" value="Войти">
                </div>
                <a href="signup.php" class="have-acc">Регистрация</a>
                <a href="send_reset_message.php" class="have-acc">Забыли пароль?</a>
                <p class="message none">error</p>
            </div>
        </form>
    </section>
    <!-- <h1>авторизация</h1>
    <form class="form">
        <input type="text" class="form-control" id="text" aria-describedby="emailHelp" name="login"
            placeholder="Логин...">
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль...">
        <input type="submit" class=" login-btn btn btn-info btn-link btn-wd btn-lg" value="Войти" />
        <a href="signup.php">Регистрация</a>
        <a href="send_reset_message.php">Забыли пароль?</a>
    </form>
    <div class="message none">Ошибка авторизации</div> -->
</body>
<script src="../assets/js/auth.js"></script>

</html>