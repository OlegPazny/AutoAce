<?php
    require_once "../assets/api/get_services_script.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery connection -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- jQuery connection -->
    <!-- leaflet connection -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- leaflet connection -->
    <title>Document</title>
</head>
<style>
    #map{
        position: absolute;
        top:100px;
        bottom:0;
        left:0;
        right:0
    }
</style>
<body>
    <form id="filterForm">
        <?php
            foreach($services as $service){
                echo("<input type='checkbox' name='services' value='".$service[0]."'>".$service[1]."</input>");
            }
        ?>
        <button type="submit">Применить фильтр</button>
    </form>
    <div id="map"></div>
    <script>
        var map=L.map('map').setView([53.902292, 27.561821], 12.3);

        L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=zu81qp5yGvbAgHoNquf3').addTo(map);
        //первоначальное добавление маркеров на карту
        $(function() {
            $.getJSON('assets/api/get_coords_script.php', function(data) {
                $(data).each(function(key, value) {
                    var marker = L.marker([value['latitude'], value['longitude']]).addTo(map);
                    marker.bindPopup("<a href='workshop.php?id="+value['id']+"' target='_blank'>"+value['name']+"</a>");
                });
            });
        });
    </script>
</body>
<script src="../assets/js/workshops_filter.js"></script>
</html>