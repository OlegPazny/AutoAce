<?php
    require_once "db_connect.php";

    $bookId = $_POST['book_id'];
    $delete_book=mysqli_query($db, "DELETE FROM `service_bookings` WHERE `id`=$bookId");
?>