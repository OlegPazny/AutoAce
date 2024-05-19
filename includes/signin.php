<div class="popup__bg__sign-in">
    <section class="signup-section signin">
        <form>
        <svg class="close-popup__sign-in" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
            <path fill="none" stroke="#3b3b3b" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1" d="m7 7l10 10M7 17L17 7"/>
        </svg>
        <h1>Авторизация</h1>
            <div class="signup">
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
                <a href="signup.php" id="sign-up__link" class="have-acc">Нет аккаунта?</a>
                <a href="send_reset_message.php" class="have-acc">Забыли пароль?</a>
                <p class="message none">error</p>
            </div>
        </form>
    </section>
</div>
<script src="../assets/js/auth.js"></script>