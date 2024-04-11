<?php
    session_start();
    require_once "../assets/api/get_workshop_data_script.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автосервис</title>
</head>
<body>
    <?php
        echo("<ul>");
        foreach($services_arr as $service_type=>$services){
            echo("<li>".$service_type);
            echo("<ul>");
            foreach($services as $service){
                echo("<li>".$service."</li>");
            }
            echo("</ul>");
            echo("</li>");
        }
        echo("</ul>");
    ?>
</body>
</html>