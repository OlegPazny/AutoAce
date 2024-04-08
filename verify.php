<?php
    session_start();

    require_once "assets/api/verification_script.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>verify</title>
</head>
<body>
    <?php
        if($isVerified===true){
            echo("подтверждено");
        }else{
            echo("не подтверждено");
        }
    ?>
</body>
</html>