<?php
    if(!isset($_SESSION['user'])){
        $account_href="../pages/signin.php";
    }else{
        $account_href="../pages/account.php";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <header class="header">
    <div class="header__logo">
        <a href="../pages/index.php">
            <img src="../assets/images/logo_light.png">
        </a>
    </div>
    <div class="header__search">
        <p><a href="../pages/map.php">Поиск автосервиса</a></p>
    </div>
    <div class="header__contact-info">
        <div class="phone-number">+375 (29) 865-79-68</div>
        <div class="account-icon">
            <a href="<?php echo $account_href;?>"><img src="../assets/images/account_icon.png"></a>
        </div>
    </div>
    </header>
</body>
</html>