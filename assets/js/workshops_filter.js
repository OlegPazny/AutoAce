document.addEventListener("DOMContentLoaded", function() {
    var slider = document.getElementById('working-hours-slider');

    noUiSlider.create(slider, {
        start: [9, 18], // Default working hours
        connect: true,
        range: {
            'min': 0,
            'max': 24
        },
        step: 0.5,
        format: {
            to: function(value) {
                return Math.floor(value) + ':' + (value % 1 === 0 ? '00' : '30');
            },
            from: function(value) {
                var parts = value.split(':');
                return parseInt(parts[0], 10) + (parts[1] === '30' ? 0.5 : 0);
            }
        }
    });
    
    var startTime = document.getElementById('start-time');
    var endTime = document.getElementById('end-time');
    
    slider.noUiSlider.on('update', function(values, handle) {
        if (handle === 0) {
            startTime.value = values[0];
        } else {
            endTime.value = values[1];
        }
    });
    
    // Call filterMarkers function when slider value changes
    slider.noUiSlider.on('change', function() {
        filterMarkers();
    });
    
    $('.filter-block__headlist__service-type').click(function(){
        $(this).toggleClass('active');
        $(this).find('.filter-block__list').slideToggle('fast');
    });
    
    // Предотвращаем сворачивание аккордеона при клике на элемент внутри него
    $('.filter-block__list').click(function(event){
        event.stopPropagation(); // Остановить всплытие события
    });
    
    // Сворачиваем все блоки с услугами при загрузке страницы
    $('.filter-block__list').hide();
    
    // Если передан id чекбокса, открываем соответствующий аккордеон
    const urlParams = new URLSearchParams(window.location.search);
    const discountServiceId = urlParams.get('discount_service_id');
    if (discountServiceId) {
        var checkboxParent = $('[value="' + discountServiceId + '"]').closest('.filter-block__headlist__service-type');
        checkboxParent.addClass('active');
        checkboxParent.find('.filter-block__list').slideDown('fast');
    }
    
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

     // Функция для фильтрации меток
     function filterMarkers() {
        console.log("Фильтрация маркеров...");

        var selectedServices = [];
        var checkboxes = document.querySelectorAll('input[name="services"]:checked');
        console.log("Выбранные чекбоксы:", checkboxes);
        checkboxes.forEach(function (checkbox) {
            selectedServices.push(checkbox.value);
        });

        var startTime = document.getElementById('start-time').value;
        var endTime = document.getElementById('end-time').value;
        console.log("Выбранное время работы:", startTime, endTime);

        var filterData = {
            services: selectedServices,
            workingHours: {
                start: startTime,
                end: endTime
            }
        };

        if (selectedServices.length === 0 && startTime === "" && endTime === "") {
            console.log("Запрос без параметров...");
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../assets/api/get_coords_script.php', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        clearMarkers();
                        var response = JSON.parse(xhr.responseText);
                        console.log("Ответ сервера без параметров:", response);
                        addMarkers(response);
                    } else {
                        console.error('Ошибка запроса');
                    }
                }
            };
            xhr.send();
        } else {
            console.log("Запрос с параметрами...");
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../assets/api/filter_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        clearMarkers();
                        var response = JSON.parse(xhr.responseText);
                        console.log("Ответ сервера с параметрами:", response);
                        addMarkers(response);
                    } else {
                        console.error('Ошибка запроса');
                    }
                }
            };
            xhr.send(JSON.stringify(filterData));
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
        var defaultIcon = L.icon({
            iconUrl: '../assets/images/location.png',
            iconSize: [32, 40], // Размер иконки
            iconAnchor: [12, 41], // Точка привязки иконки
            popupAnchor: [5, -40], // Точка привязки всплывающего окна
            // Устанавливаем тень в виде пустой картинки, чтобы скрыть ее
            shadowUrl: '../assets/images/empty.png', // Пустая картинка без тени
            shadowSize: [0, 0], // Устанавливаем размер тени в ноль
            shadowAnchor: [0, 0] // Устанавливаем точку привязки тени в ноль
        });
        $(data).each(function (key, value) {
            var marker = L.marker([value['latitude'], value['longitude']], { icon: defaultIcon }).addTo(map);
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
