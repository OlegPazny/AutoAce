<?php
    session_start();
    require_once "db_connect.php";

    $user_id=$_SESSION['user']['id'];

    $account_books=mysqli_query($db, "SELECT `services`.`service_name`, `message`, `service_date`, `service_time`, `status` FROM `service_bookings` inner join `services` on `service_bookings`.`service_id`=`services`.`id` WHERE `user_id`=$user_id;");
    $account_books=mysqli_fetch_all($account_books);

    // $account_history=mysqli_query($db, "SELECT `workshops`.`name`, `services`.`service_name`, `service_bookings`.`message`, `service_history`.`completion_date`, `service_history`.`completion_time`, `service_bookings`.`status`, `service_history`.`booking_id` FROM `service_history`
    // INNER JOIN `service_bookings` ON `service_history`.`booking_id` = `service_bookings`.`id`
    // INNER JOIN `services` ON `service_bookings`.`service_id` = `services`.`id`
    // INNER JOIN `users` ON `service_bookings`.`user_id` = `users`.`id`
    // INNER JOIN `workshops` ON `service_bookings`.`workshop_id`=`workshops`.`id` WHERE `service_bookings`.`user_id`=$user_id");
    // $account_history=mysqli_fetch_all($account_history);

    $account_info=mysqli_query($db, "SELECT `name`, `email` FROM `users` WHERE `id`=$user_id");
    $account_info=mysqli_fetch_assoc($account_info);
    
?>