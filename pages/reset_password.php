<?php
require_once "../assets/api/get_hash_script.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/favicon.svg" />
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>Сброс пароля</title>
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
    <section class="reset-pass-section">
        <form>
            <input type="hidden" value="<?php echo $hash; ?>" name="hash" class="hash">
            <h1>Восстановление пароля</h1>
            <div class="signup">
                <div class="signup__input-block">
                    <label>Новый пароль</label>
                    <input type="password" name="password" class="password" placeholder="Введите новый пароль">
                </div>
                <div class="signup__input-block">
                    <input type="password" name="password_confirm" class="password"
                        placeholder="Повторите новый пароль">
                </div>
                <div class="signup__submit-block button reset-btn-block">
                    <input type="button" class="reset-btn button__content" value="Подтвердить">
                </div>
                <p class="message none">error</p>
            </div>
        </form>
    </section>
</body>
<script src="../assets/js/reset_pass.js"></script>

</html>