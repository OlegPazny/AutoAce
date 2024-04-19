<?php
    require_once "db_connect.php";

    $bookingId = $_POST['booking_id'];
    $newStatus = $_POST['new_status'];
    $date=date("Y-m-d");
    $time=date("H:i:s");

    if($newStatus=="completed"){
        $move_to_history=mysqli_query($db,"INSERT INTO `service_history` (`id`, `booking_id`, `completion_date`, `completion_time`) VALUES (NULL, '$bookingId', '$date', '$time')");
    }else if($newStatus=="pending"||$newStatus=="confirmed"){
        $delete_from_history=mysqli_query($db,"DELETE FROM `service_history` WHERE `booking_id`=$bookingId");
    }
    $update_status=mysqli_query($db,"UPDATE `service_bookings` SET `status`='$newStatus' WHERE `id`=$bookingId");
?>