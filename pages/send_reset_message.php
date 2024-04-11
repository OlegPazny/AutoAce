<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>восстановление пароля</title>
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
        <input type="text" name="email" class="email" placeholder="Введите Вашу почту">
        <button type="submit" class="send-btn">Подтвердить</button>
    </form>
    <p class="message none">error</p>
</body>
<script src="../assets/js/send_reset_message.js"></script>
</html>