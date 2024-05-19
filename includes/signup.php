<div class="popup__bg__sign-up">
    <section class="signup-section signup">
        <form>
        <svg class="close-popup__sign-up" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
            <path fill="none" stroke="#3b3b3b" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1" d="m7 7l10 10M7 17L17 7"/>
        </svg>
            <h1>Регистрация</h1>
            <div class="signup">
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
                <div class="signup__submit-block button register-btn-block">
                    <input type="submit" class="register-btn button__content" value="Зарегистрироваться">
                </div>
                <a href="signin.php" id="sign-in__link" class="have-acc">Уже есть аккаунт?</a>
                <p class="message none">error</p>
            </div>
        </form>
    </section>
</div>
<script src="../assets/js/signup.js"></script>