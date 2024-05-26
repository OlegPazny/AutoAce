<?php
    session_start();

    require_once "../assets/api/verification_script.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/favicon.svg" />
    <title>Верификация</title>
</head>
<body>
    <?php
        if($isVerified==true){
            echo("<input id='accountStatus' type='hidden' value='1'>");
        }else{
            echo("<input id='accountStatus' type='hidden' value='0'>");
        }
    ?>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var accountStatus = document.getElementById('accountStatus').value;

    if (accountStatus === '1') {
        alert('Аккаунт подтвержден!');
        window.location.href = '../index.php';
    }else{
        alert('Аккаунт не подтвержден!');
        window.location.href = '../index.php';
    }
});
</script>
</html>