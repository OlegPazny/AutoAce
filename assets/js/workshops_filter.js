$(function () {
    // Обработчик события DOMContentLoaded для установки чекбоксов
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const discountServiceId = urlParams.get('discount_service_id');
        if (discountServiceId) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="services"]');
            checkboxes.forEach(checkbox => {
                if (checkbox.value === discountServiceId) {
                    checkbox.checked = true;
                }
            });
        }
        // Вызвать функцию фильтрации после установки чекбоксов
        filterMarkers();
    });

    var map = L.map('map').setView([53.902292, 27.561821], 12.3);
    L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=zu81qp5yGvbAgHoNquf3').addTo(map);

    // Функция для очистки маркеров
    function clearMarkers() {
        map.eachLayer(function (layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });
    }

    // Функция для добавления маркеров
    function addMarkers(data) {
        $(data).each(function (key, value) {
            var marker = L.marker([value['latitude'], value['longitude']]).addTo(map);
            marker.bindPopup("<a href='workshop.php?id=" + value['id'] + "' target='_blank'>" + value['name'] + "</a>");
        });
    }

    // Функция для фильтрации маркеров
    function filterMarkers() {
        var selectedServices = [];
        var checkboxes = document.querySelectorAll('input[name="services"]:checked');
        checkboxes.forEach(function (checkbox) {
            selectedServices.push(checkbox.value);
        });

        if (selectedServices.length === 0) {
            // Если услуги не выбраны, отправляем запрос без параметров
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
            // Если услуги выбраны, отправляем запрос с выбранными услугами
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

    // Обработчик события изменения для чекбоксов услуг
    document.querySelectorAll('input[name="services"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', filterMarkers);
    });

    // Инициализация первоначальных маркеров на карте
    $(function () {
        $.getJSON('../assets/api/get_coords_script.php', function (data) {
            addMarkers(data);
        });
    });
});
