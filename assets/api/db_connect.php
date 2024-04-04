<?php
    $host="localhost";
    $database="AutoAce";
    $user="root";
    $password="";
    $db=mysqli_connect($host, $user, $password, $database) or die("Ошибка ".mysqli_error($db));
    $db->set_charset("utf8mb4");
?>