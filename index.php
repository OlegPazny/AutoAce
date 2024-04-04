<?php
    session_start();

    if(!isset($_SESSION['user'])){
        header('Location: signin.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>главная</title>
</head>
<body>
    <h1>Это главная</h1>
    <h1><?php echo($_SESSION['user']['UserName']);?></h1>
    <form action="assets/api/logout.php">
        <input type="submit" value="Выйти">
    </form>
</body>
</html>