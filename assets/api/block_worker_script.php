<?php
    require_once "db_connect.php";

    $workerId = $_POST['worker_id'];
    $block_worker=mysqli_query($db, "DELETE FROM `workers` WHERE `id`=$workerId");
?>