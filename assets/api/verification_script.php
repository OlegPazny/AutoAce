<?php
    require_once "db_connect.php";

    $hash=$_GET['hash'];

    $users_data=mysqli_query($db, "SELECT * FROM `users` WHERE `isVerified`=0");
    $users_data=mysqli_fetch_all($users_data);

    $isVerified=false;
    foreach($users_data as $user_data){
        $toVerify=md5($user_data[1].$user_data[2].$user_data[3]);
        if($hash===$toVerify){
            $isVerified=true;
            $verification=mysqli_query($db, "UPDATE `users` SET `isVerified`=1 WHERE `id`=$user_data[0]");
        }else{
            $isVerified=false;
        }
    }
?>