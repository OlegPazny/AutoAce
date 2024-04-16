var map = L.map('map').setView([53.902292, 27.561821], 12.3);

L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=zu81qp5yGvbAgHoNquf3').addTo(map);
//первоначальное добавление маркеров на карту
$(function () {
    $.getJSON('assets/api/get_coords_script.php', function (data) {
        $(data).each(function (key, value) {
            var marker = L.marker([value['latitude'], value['longitude']]).addTo(map);
            marker.bindPopup("<a href='workshop.php?id=" + value['id'] + "' target='_blank'>" + value['name'] + "</a>");
        });
    });
});