<?php
    require_once "db_connect.php";

    $users=mysqli_query($db, "SELECT * FROM `users`");
    $users=mysqli_fetch_all($users);

    $accounts_books=mysqli_query($db, "SELECT `service_bookings`.`id`, `workshops`.`name`, `services`.`service_name`, `message`, `service_date`, `service_time`, `status`, `services`.`price` FROM `service_bookings`
    INNER JOIN `workshops` ON `service_bookings`.`workshop_id`=`workshops`.`id`
    inner join `services` on `service_bookings`.`service_id`=`services`.`id`
    ORDER BY `service_date` ASC, `service_time` ASC");
    $accounts_books=mysqli_fetch_all($accounts_books);

    $accounts_history=mysqli_query($db, "SELECT `workshops`.`name`, `services`.`service_name`, `service_bookings`.`message`, `service_history`.`completion_date`, `service_history`.`completion_time`, `service_bookings`.`status`, `service_history`.`booking_id` FROM `service_history`
    INNER JOIN `service_bookings` ON `service_history`.`booking_id` = `service_bookings`.`id`
    INNER JOIN `services` ON `service_bookings`.`service_id` = `services`.`id`
    INNER JOIN `users` ON `service_bookings`.`user_id` = `users`.`id`
    INNER JOIN `workshops` ON `service_bookings`.`workshop_id`=`workshops`.`id`;");
    $accounts_history=mysqli_fetch_all($accounts_history);
?>