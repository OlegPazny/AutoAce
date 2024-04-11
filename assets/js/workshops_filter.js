$(function() {
    function clearMarkers() {
        map.eachLayer(function(layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });
    }

    function addMarkers(data) {
        $(data).each(function(key, value) {
            var marker = L.marker([value['latitude'], value['longitude']]).addTo(map);
            marker.bindPopup("<a href='workshop.php?id="+value['id']+"' target='_blank'>"+value['name']+"</a>");
        });
    }

    $('#filterForm').submit(function(event) {
        event.preventDefault();

        var selectedServices = [];
        var checkboxes = document.querySelectorAll('input[name="services"]:checked');
        checkboxes.forEach(function(checkbox) {
            selectedServices.push(checkbox.value);
        });

        if (selectedServices.length === 0) {
            // Если услуги не выбраны, отправляем запрос без параметров
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../assets/api/get_all_workshops.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        clearMarkers();
                        var response = JSON.parse(xhr.responseText);
                        addMarkers(response);
                    } else {
                        console.error('Ошибка запроса');
                    }
                }
            };
            xhr.send();
        } else {
            // Если услуги выбраны, отправляем запрос с выбранными услугами
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../assets/api/filter_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        clearMarkers();
                        var response = JSON.parse(xhr.responseText);
                        addMarkers(response);
                    } else {
                        console.error('Ошибка запроса');
                    }
                }
            };
            xhr.send(JSON.stringify({ services: selectedServices }));
        }
    });
});
