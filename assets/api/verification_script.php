<?php
    require_once "db_connect.php";
    
    $isVerified=false;
    if(isset($_GET['hash'])){
        $hash=$_GET['hash'];

        $users_data=mysqli_query($db, "SELECT * FROM `users` WHERE `isVerified`=0");
        $users_data=mysqli_fetch_all($users_data);
    

        foreach($users_data as $user_data){
            $toVerify=md5($user_data[1].$user_data[2].$user_data[3]);
            if($hash===$toVerify){
                echo("<input id='accountStatus' type='hidden' value='1'>");
                $isVerified=true;
                $verification=mysqli_query($db, "UPDATE `users` SET `isVerified`=1 WHERE `id`=$user_data[0]");
                break;
            }else{
                echo("<input id='accountStatus' type='hidden' value='0'>");
                $isVerified=false;
            }
        }
    }
    
?>