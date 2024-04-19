<?php
    session_start();
    require_once "db_connect.php";

    $user_id=$_SESSION['user']['id'];

    $account_books=mysqli_query($db, "SELECT `workshops`.`name`, `services`.`service_name`, `message`, `service_date`, `service_time`, `status` FROM `service_bookings` INNER JOIN `workshops` ON `service_bookings`.`workshop_id`=`workshops`.`id` inner join `services` on `service_bookings`.`service_id`=`services`.`id` WHERE `user_id`=$user_id;");
    $account_books=mysqli_fetch_all($account_books);

    
?>