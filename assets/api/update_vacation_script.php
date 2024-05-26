<?php
    require_once "db_connect.php";
    require_once "mail_client_connect.php";

    $workerId = $_POST['worker_id'];
    $newStatus = $_POST['new_status'];

    $update_status=mysqli_query($db,"UPDATE `workers` SET `vacation`='$newStatus' WHERE `id`=$workerId");
?>