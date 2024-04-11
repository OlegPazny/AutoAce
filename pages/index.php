<?php
    session_start();

    require_once "../assets/api/isAdmin.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>главная</title>
</head>
<body>
    <form action="assets/api/logout.php">
        <input type="submit" value="Выйти">
    </form>
</body>
</html>