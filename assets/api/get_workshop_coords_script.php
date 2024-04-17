<?php
session_start();
require_once "db_connect.php";
$workshop_id=$_SESSION['workshop_id'];
$workshop = array();
$workshop_location = mysqli_query($db, "SELECT * FROM `workshops` WHERE `id`=$workshop_id");
while ($row = mysqli_fetch_assoc($workshop_location)) {
    $workshop[] = $row;
}

echo(json_encode($workshop));
?>