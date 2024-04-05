<?php
    require_once "db_connect.php";

    $services=mysqli_query($db, "SELECT * FROM `services`");
    $services=mysqli_fetch_all($services);
?>