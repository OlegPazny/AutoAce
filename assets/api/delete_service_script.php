<?php
    require_once "db_connect.php";

    $serviceId = $_POST['service_id'];
    $delete_service=mysqli_query($db, "DELETE FROM `services` WHERE `id`=$serviceId");
?>