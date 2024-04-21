<?php
session_start();
require_once "db_connect.php";
require_once "mail_client_connect.php";
// Получаем данные из POST запроса
$workshop_id = $_POST['hash'];
$service_id = $_POST['service'];
$message = $_POST['message'];
$user_id=$_SESSION["user"]["id"];

$date=date("Y-m-d");
$time=date("H:i:s");

$get_service_name=mysqli_query($db, "SELECT `service_name` FROM `services` WHERE `id`=$service_id");
$service_name=mysqli_fetch_assoc($get_service_name);

$get_workshop_name=mysqli_query($db, "SELECT `address` FROM `workshops` WHERE `id`=$workshop_id");
$workshop_name=mysqli_fetch_assoc($get_workshop_name);
var_dump($workshop_name);
$get_user_data=mysqli_query($db, "SELECT `name`, `email` FROM `users` WHERE `id`=$user_id");
$user_data=mysqli_fetch_assoc($get_user_data);
$body="
    <p>Здравствуйте, ".$user_data['name']."</p>
    <p>Вы записались на услугу ".$service_name['service_name']." по адресу ".$workshop_name['address']."</p>
    <p>Спасибо за выбор автосервиса!</p>
    <p>С уважением AutoAce!</p>
";

$insert_book_data=mysqli_query($db, "INSERT INTO `service_bookings` VALUES (NULL, '$workshop_id', '$service_id', '$user_id', '$message', '$date', '$time', 'pending')");
var_dump(send_mail($settings['mail_settings'], [$user_data['email']], 'Вы записались на услугу!', $body));

?>
