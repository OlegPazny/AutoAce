<?php
session_start();
require_once "db_connect.php";
// Получаем данные из POST запроса
$workshop_id = $_POST['workshop'];
$service_id = $_POST['service'];
$message = $_POST['message'];
$user_id=$_SESSION["user"]["id"];
$date=date("Y-m-d");
$time=date("H:i:s");

$insert_book_data=mysqli_query($db, "INSERT INTO `service_bookings` VALUES (NULL, '$workshop_id', '$service_id', '$user_id', '$message', '$date', '$time', 'pending')");


?>
