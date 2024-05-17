<?php
    require_once "db_connect.php";

    $vehicleId = $_POST['vehicle_id'];
    $delete_vehicle=mysqli_query($db, "DELETE FROM `vehicles` WHERE `id`=$vehicleId");
?>