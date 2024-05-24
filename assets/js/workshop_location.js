var map = L.map('map').setView([53.902292, 27.561821], 12.3);

L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=zu81qp5yGvbAgHoNquf3').addTo(map);

$(function () {
    var defaultIcon = L.icon({
        iconUrl: '../assets/images/location.png',
        iconSize: [32, 40],
        iconAnchor: [12, 41],
        popupAnchor: [5, -40],
        shadowUrl: '../assets/images/empty.png',
        shadowSize: [0, 0],
        shadowAnchor: [0, 0]
    });
    $.getJSON('../assets/api/get_workshop_coords_script.php', function (data) {
        $(data).each(function (key, value) {
            var marker = L.marker([value['latitude'], value['longitude']], { icon: defaultIcon }).addTo(map);
            marker.bindPopup(value['name']);
        });
    });
});