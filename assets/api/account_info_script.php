<?php
    session_start();
    require_once "db_connect.php";

    $user_id=$_SESSION['user']['id'];

    // $account_books=mysqli_query($db, "SELECT `services`.`service_name`, `workshops`.`name`, `workers`.`name`, `message`, `service_date`, `service_time`, `status` FROM `service_bookings`
    // inner join `services` on `service_bookings`.`service_id`=`services`.`id`
    // INNER JOIN `workers` ON `service_bookings`.`worker_id`=`workers`.`id`
    // INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    // WHERE `user_id`=$user_id;");
    // $account_books=mysqli_fetch_all($account_books);

    $account_books=mysqli_query($db, "SELECT `services`.`service_name`, `workshops`.`name`, `workers`.`name`, `message`, `service_date`, `service_time`, `status` FROM `service_bookings`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    inner join `services` on `worker_service_relationships`.`service_id`=`services`.`id`
    INNER JOIN `workers` ON `worker_service_relationships`.`worker_id`=`workers`.`id`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    WHERE `user_id`=$user_id;");
    $account_books=mysqli_fetch_all($account_books);

    $account_history=mysqli_query($db, "SELECT `workers`.`name`, `services`.`service_name`, `service_bookings`.`message`, `service_history`.`completion_date`, `service_history`.`completion_time`, `service_bookings`.`status`, `service_history`.`booking_id`, `workshops`.`name` FROM `service_history`
    INNER JOIN `service_bookings` ON `service_history`.`booking_id`=`service_bookings`.`id`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    inner join `services` on `worker_service_relationships`.`service_id`=`services`.`id`
    INNER JOIN `workers` ON `worker_service_relationships`.`worker_id`=`workers`.`id`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    INNER JOIN `users` ON `service_bookings`.`user_id` = `users`.`id`
    WHERE `service_bookings`.`user_id`=$user_id;");
    $account_history=mysqli_fetch_all($account_history);

    $account_info=mysqli_query($db, "SELECT `name`, `email` FROM `users` WHERE `id`=$user_id");
    $account_info=mysqli_fetch_assoc($account_info);

    $vehicles=mysqli_query($db, "SELECT * FROM `vehicles` WHERE `user_id`=$user_id");
    $vehicles=mysqli_fetch_all($vehicles);
    
?>