<?php
    require_once "db_connect.php";

    $serviceName = $_POST['service_name'];
    $serviceDescription = $_POST['service_description'];
    $servicePrice = $_POST['service_price'];
    $serviceType = $_POST['service_type'];
    $serviceDiscount = $_POST['service_discount'];

    $add_service=mysqli_query($db, "INSERT INTO `services` (`id`, `service_name`, `description`, `price`, `id_service_type`, `discount`) VALUES (NULL, '$serviceName', '$serviceDescription', $servicePrice, $serviceType, $serviceDiscount)");
?>