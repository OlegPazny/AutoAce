<?php
    session_start();
    require_once "db_connect.php";

    $mechanicId=$_SESSION['user']['id'];

    $mechanic=mysqli_query($db, "SELECT `name`, `email` FROM `workers` WHERE `id`=$mechanicId");
    $mechanic=mysqli_fetch_assoc($mechanic);

    $works=mysqli_query($db, "SELECT `service_bookings`.`id`, `services`.`service_name`, `users`.`name`, `service_bookings`.`message`, `service_bookings`.`service_date`, `service_bookings`.`service_time`, `service_bookings`.`status`, `vehicles`.`brand`, `vehicles`.`vin`, `service_bookings`.`comment`
    FROM `service_bookings`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    INNER JOIN `services` ON `worker_service_relationships`.`service_id`=`services`.`id`
    LEFT JOIN `users` ON `service_bookings`.`user_id`=`users`.`id`
    LEFT JOIN `vehicles` ON `service_bookings`.`vehicle_id`=`vehicles`.`id`
    WHERE `worker_service_relationships`.`worker_id`=$mechanicId;");
    $works=mysqli_fetch_all($works);
?>