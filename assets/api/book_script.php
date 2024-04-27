<?php
session_start();
require_once "db_connect.php";
require_once "mail_client_connect.php";
// Получаем данные из POST запроса
$workshop_id = $_POST['hash'];
$service_id = $_POST['service'];
$message = $_POST['message'];
$worker_id=$_POST['worker'];
$price=$_POST['service_price'];
$user_id=$_SESSION["user"]["id"];

$date=date("Y-m-d");
$time=date("H:i:s");

$get_service_data=mysqli_query($db, "SELECT `service_name`, `price`, `discount` FROM `services` WHERE `id`=$service_id");
$service_data=mysqli_fetch_assoc($get_service_data);

$get_workshop_data=mysqli_query($db, "SELECT `address`, `standart_hour` FROM `workshops`WHERE `id`=$workshop_id");
$workshop_data=mysqli_fetch_assoc($get_workshop_data);

$get_user_data=mysqli_query($db, "SELECT `name`, `email` FROM `users` WHERE `id`=$user_id");
$user_data=mysqli_fetch_assoc($get_user_data);

$get_worker_name=mysqli_query($db, "SELECT `name` FROM `workers` WHERE `id`=$worker_id");
$worker_name=mysqli_fetch_assoc($get_worker_name);

if($service_data['discount']==NULL){
    $price=$workshop_data['standart_hour']*$service_data['price'];
    $body="
    <p>Здравствуйте, ".$user_data['name']."</p>
    <p>Вы записались на услугу ".$service_data['service_name']." по адресу ".$workshop_data['address']."</p>
    <p>Работы по Вашему автомобилю выполнит ".$worker_name['name'].".</p>
    <p>Стоимость выполнения работ: ".$price." рублей.</p>
    <p>Спасибо за выбор автосервиса!</p>
    <p>С уважением AutoAce!</p>
";
}else{
    $price=$workshop_data['standart_hour']*$service_data['price']*(100-$service_data['discount'])/100;
    $body="
    <p>Здравствуйте, ".$user_data['name']."</p>
    <p>Вы записались на услугу ".$service_data['service_name']." по адресу ".$workshop_data['address']."</p>
    <p>Работы по Вашему автомобилю выполнит ".$worker_name['name'].".</p>
    <p>Стоимость выполнения работ: ".$price." рублей.</p>
    <p>Спасибо за выбор автосервиса!</p>
    <p>С уважением AutoAce!</p>
";
}


$insert_book_data=mysqli_query($db, "INSERT INTO `service_bookings` VALUES (NULL, '$service_id', '$user_id', '$message', '$date', '$time', 'pending', '$worker_id')");
var_dump(send_mail($settings['mail_settings'], [$user_data['email']], 'Вы записались на услугу!', $body));

?>
