<?php
    require_once "db_connect.php";

    $userId = $_POST['user_id'];
    $block_user=mysqli_query($db, "DELETE FROM `users` WHERE `id`=$userId");
?>