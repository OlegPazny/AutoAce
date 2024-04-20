<?php
    require_once "db_connect.php";

    $userId = $_POST['user_id'];
    $newRole = $_POST['new_role'];


    $update_role=mysqli_query($db,"UPDATE `users` SET `role`='$newRole' WHERE `id`=$userId");
?>