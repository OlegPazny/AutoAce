<?php
require_once "../assets/api/isAdmin.php";
if (!isset($_SESSION['user'])) {
    $account_href = "../pages/signin.php";
    $account_icon = "<img alt='Иконка аккаунта' src='../assets/images/login_icon.svg' style='width: 1.5em; height:1.5em'>";
    $header_list = "<li id='sign-in__link'>Войти</li>";
} else if (isset($_SESSION['user']) && $isMechanic == false) {
    $account_href = "../pages/account.php";
    $account_icon = "<svg xmlns='http://www.w3.org/2000/svg' width='1.5em' height='1.5em' viewBox='0 0 24 24'><g fill='none' stroke='#fff' stroke-dasharray='28' stroke-dashoffset='28' stroke-linecap='round' stroke-width='2'><path d='M4 21V20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20V21'><animate fill='freeze' attributeName='stroke-dashoffset' dur='0.4s' values='28;0'/></path><path d='M12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7C16 9.20914 14.2091 11 12 11Z'><animate fill='freeze' attributeName='stroke-dashoffset' begin='0.5s' dur='0.4s' values='28;0'/></path></g></svg>";
    $header_list = "
        <li class=\"header__menu__sub-link\"><a href='../pages/account.php'>Личный кабинет</a></li>     
        <li class=\"header__menu__sub-link\">
            <form action='../assets/api/logout.php'>
                    <input class='logout-btn' type='submit' value='Выйти'>
            </form>
        </li>";
} else if (isset($_SESSION['user']) && $isMechanic == true) {
    $account_icon = "<svg xmlns='http://www.w3.org/2000/svg' width='1.5em' height='1.5em' viewBox='0 0 24 24'><g fill='none' stroke='#fff' stroke-dasharray='28' stroke-dashoffset='28' stroke-linecap='round' stroke-width='2'><path d='M4 21V20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20V21'><animate fill='freeze' attributeName='stroke-dashoffset' dur='0.4s' values='28;0'/></path><path d='M12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7C16 9.20914 14.2091 11 12 11Z'><animate fill='freeze' attributeName='stroke-dashoffset' begin='0.5s' dur='0.4s' values='28;0'/></path></g></svg>";
    $header_list = " 
        <li class=\"header__menu__sub-link\">
            <form action='../assets/api/logout.php'>
                    <input class='logout-btn' type='submit' value='Выйти'>
            </form>
        </li>";
}
?>
<header class="header">
    <div class="header__logo">
        <?php if ($isMechanic == true || $isAdmin == true || $isWorker == true) { ?>
            <a href="../index.php">
            <?php } else { ?>
                <a href="../pages/index.php">
                <?php } ?>
                <div class="header__logo__block">
                    <img alt="Иконка логотипа светлая" src="../assets/images/gear_icon.svg">
                    <img alt="Текст логотипа светлый" src="../assets/images/logo_text.svg">
                </div>
            </a>
    </div>
    <?php if ($isMechanic == true || $isAdmin == true || $isWorker == true) {

    } else { ?>
        <div class="header__search">
            <p><a href="../pages/map.php">Поиск автосервиса</a></p>
        </div>
    <?php } ?>
    <div class="header__contact-info">
        <div class="phone-number"><a href="tel:+375298657968">+375 (29) 865-79-68</a></div>

        <div class="account-icon">
            <?php echo ($account_icon); ?>
            <ul class="header__menu__sub-list">
                <!-- Список элементов меню -->
                <?php echo $header_list; ?>
            </ul>
        </div>


    </div>
    <button class="header__burger-menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <nav class="header__nav">
        <ul>
            <li><a href="../pages/map.php">Поиск автосервиса</a></li>
            <?php echo $header_list;?>
        </ul>
    </nav>
</header>
<?php require_once "signup.php"; ?>
<?php require_once "signin.php"; ?>
<script src="../assets/js/showSignPopup.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const burgerMenu = document.querySelector('.header__burger-menu');
  const navMenu = document.querySelector('.header__nav');

  burgerMenu.addEventListener('click', function() {
    if(document.querySelector('.burger-menu')&&document.querySelector('.filter-block')){
        if(document.querySelector('.burger-menu').classList.contains('open')&&document.querySelector('.filter-block').classList.contains('open')){
            document.querySelector('.burger-menu').classList.remove('open');
            document.querySelector('.filter-block').classList.remove('open');
        }
    }
    if(document.querySelector('.modalpopup')){
        if(getComputedStyle(document.querySelector('.modalpopup')).opacity==0){
            navMenu.classList.toggle('active');
        }
    }else{
        navMenu.classList.toggle('active');
    }
    
  });
});
</script>