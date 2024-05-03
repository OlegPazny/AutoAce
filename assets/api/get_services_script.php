<?php
    require_once "db_connect.php";

    $services_data=mysqli_query($db, "SELECT `services`.`id`, `services`.`service_name`, `service_type`.`type`, `services`.`discount`, `services`.`price` FROM `services` inner join `service_type` on `id_service_type`=`service_type`.`id`");
    $services_data=mysqli_fetch_all($services_data);

    $services_arr=array();
    foreach ($services_data as $row) {
        $service_type = $row[2];
        $service_id = $row[0];
        $service_name = $row[1];
        $service_price=$row[4];
        $service_discount=$row[3];

        if($service_discount!=NULL){
            $price=$service_price-$service_price*$service_discount/100;
        }else{
            $price=$service_price;
        }

        // Если тип услуги уже присутствует в массиве, добавляем услугу к существующему типу
        if (array_key_exists($service_type, $services_arr)) {
            $services_arr[$service_type][] = array('id' => $service_id, 'name' => $service_name);
        } else {
            // Если тип услуги новый, создаем новый элемент массива
            $services_arr[$service_type] = array(array('id' => $service_id, 'name' => $service_name));
        }
    }
?>