document.addEventListener("DOMContentLoaded", function() {

    function setCheckboxesFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const discountServiceId = urlParams.get('discount_service_id');
        const services = urlParams.getAll('services');

        if (discountServiceId) {
            console.log("Установка чекбокса для discountServiceId:", discountServiceId);
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="services"]');
            checkboxes.forEach(checkbox => {
                if (checkbox.value === discountServiceId) {
                    checkbox.checked = true;
                }
            });
        }

        if (services.length > 0) {
            console.log("Установка чекбоксов для services:", services);
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="services"]');
            checkboxes.forEach(checkbox => {
                if (services.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
        }
    }

    function filterMarkers() {
        var selectedServices = [];
        var checkboxes = document.querySelectorAll('input[name="services"]:checked');
        console.log("Выбранные чекбоксы:", checkboxes);
        checkboxes.forEach(function (checkbox) {
            selectedServices.push(checkbox.value);
        });

        console.log("Выбранные услуги:", selectedServices);

        if (selectedServices.length === 0) {
            console.log("Запрос без параметров...");
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../assets/api/get_coords_script.php', true);
            xhr.onreadystatechange = function () {
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
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../assets/api/filter_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function () {
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
    }

    setCheckboxesFromURL();

    function clearMarkers() {
        map.eachLayer(function (layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });
    }

    function addMarkers(data) {
        $(data).each(function (key, value) {
            var marker = L.marker([value['latitude'], value['longitude']]).addTo(map);
            marker.bindPopup("<a href='workshop.php?id=" + value['id'] + "' target='_blank'>" + value['name'] + "</a>");
        });
    }

    var map = L.map('map').setView([53.902292, 27.561821], 12.3);
    L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=zu81qp5yGvbAgHoNquf3').addTo(map);

    document.querySelectorAll('input[name="services"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function() {
            filterMarkers();
        });
    });

    // Инициализация первоначальных маркеров на карте
    $.getJSON('../assets/api/get_coords_script.php', function (data) {
        console.log("Первоначальные данные маркеров:", data);
        addMarkers(data);
    });

    filterMarkers();
});
