<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>Регистрация</title>
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
    <section class="signup-section">
        <form>
            <div class="signup">
                <img class="signup__img" src="../assets/images/logo_dark.png">
                <div class="signup__input-block">
                    <label>Ваше имя</label>
                    <input type="text" name="name" class="name" placeholder="Введите своё имя">
                </div>
                <div class="signup__input-block">
                    <label>Логин</label>
                    <input type="text" name="login" class="login" placeholder="Введите логин">
                </div>
                <div class="signup__input-block">
                    <label>Email</label>
                    <input type="email" name="email" class="email" placeholder="Введите свою почту">
                </div>
                <div class="signup__input-block">
                    <label>Пароль</label>
                    <input type="password" name="password" class="password" placeholder="Введите пароль">
                </div>
                <div class="signup__input-block">
                    <input type="password" name="password_confirm" class="password" placeholder="Повторите пароль">
                </div>
                <div class="signup__submit-block button">
                    <input type="submit" class="register-btn button__content" value="Зарегистрироваться">
                </div>
                <a href="signin.php" class="have-acc">Уже есть аккаунт?</a>
                <p class="message none">error</p>
            </div>
        </form>
    </section>
</body>
<script src="../assets/js/signup.js"></script>

</html>