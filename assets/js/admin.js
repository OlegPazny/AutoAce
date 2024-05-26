$('#workshop_hours').mask('00:00-00:00', {
    placeholder: "чч:мм-чч:мм",
    translation: {
        '0': {
            pattern: /[0-9]/, optional: false
        }
    }
});
// Проверка времени
$('#workshop_hours').on('blur', function () {
    var value = $(this).val();
    var times = value.split('-');
    if (times.length === 2) {
        var startTime = times[0].split(':');
        var endTime = times[1].split(':');

        var startHour = parseInt(startTime[0], 10);
        var startMinute = parseInt(startTime[1], 10);
        var endHour = parseInt(endTime[0], 10);
        var endMinute = parseInt(endTime[1], 10);

        if (isNaN(startHour) || isNaN(startMinute) || isNaN(endHour) || isNaN(endMinute) ||
            startHour > 23 || startMinute > 59 || endHour > 23 || endMinute > 59) {
            alert('Неверное время. Убедитесь, что часы не превышают 23, а минуты не превышают 59.');
            $(this).val('');
            return;
        }

        var start = new Date();
        start.setHours(startHour, startMinute);

        var end = new Date();
        end.setHours(endHour, endMinute);

        if (start >= end) {
            alert('Левая часть времени не может быть больше или равна правой части.');
            $(this).val('');
        }
    } else {
        alert('Неверный формат времени. Пожалуйста, используйте формат чч:мм-чч:мм.');
        $(this).val('');
    }
});
$('#workshop_price').mask('000000', {
    placeholder: "0",
    translation: {
        '0': {
            pattern: /[0-9]/, optional: true
        }
    }
});

var map;
var marker;

function openModal() {
    document.getElementById('mapModal').style.display = "block";
    initializeMap();
}

function closeModal() {
    document.getElementById('mapModal').style.display = "none";
}

function initializeMap() {
    if (!map) {
        map = L.map('map').setView([53.9, 27.5667], 10); // Минск как начальная точка

        L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=zu81qp5yGvbAgHoNquf3', {
            tileSize: 512,
            zoomOffset: -1,
            crossOrigin: true,
            maxZoom: 18
        }).addTo(map);

        map.on('click', function (e) {
            if (marker) {
                map.removeLayer(marker);
            }
            var defaultIcon = L.icon({
                iconUrl: '../assets/images/location.png',
                iconSize: [32, 40],
                iconAnchor: [12, 41],
                popupAnchor: [5, -40],
                shadowUrl: '../assets/images/empty.png',
                shadowSize: [0, 0],
                shadowAnchor: [0, 0]
            });
            marker = L.marker(e.latlng, { icon: defaultIcon }).addTo(map);
            console.log('Latitude:', e.latlng.lat, 'Longitude:', e.latlng.lng);
        });
    } else {
        setTimeout(function () {
            map.invalidateSize();
        }, 100);
    }
}

function saveLocation() {
    if (marker) {
        var latlng = marker.getLatLng();
        console.log('Saved Latitude:', latlng.lat, 'Saved Longitude:', latlng.lng);
    }
    closeModal();
}
$(document).ready(function () {
    //изменение роли юзера

    var roleSelects = document.querySelectorAll('.role-select');
    roleSelects.forEach(function (select) {
        select.addEventListener('change', function () {
            var userId = this.getAttribute('data-user-id');
            var newRole = this.value;
            updateRole(userId, newRole);
        });
    });

    function updateRole(userId, newRole) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Обработка успешного ответа
                } else {
                    console.error('Произошла ошибка при обновлении роли заказа');
                }
            }
        };
        xhr.open('POST', '../assets/api/update_role_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('user_id=' + userId + '&new_role=' + newRole);
    }
    var workshopTable = document.querySelector('.relations-table');

    function deleteWorkshopHandler() {
        var deleteButtons = document.querySelectorAll('.delete-workshop');

        deleteButtons.forEach(function (button) {
            // Удаляем существующий обработчик, если он есть
            button.removeEventListener('click', handleDeleteButtonClick);

            // Добавляем новый обработчик
            button.addEventListener('click', handleDeleteButtonClick);
        });
    }

    function handleDeleteButtonClick(event) {
        event.stopPropagation(); // Останавливаем распространение события
        var workshopId = this.getAttribute('data-workshop-id');
        if (confirm("Вы уверены, что хотите удалить этот автосервис?")) {
            deleteWorkshop(workshopId, this);
        }
    }

    function deleteWorkshop(workshopId, button) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var workshopRow = button.closest('tr'); // Используем closest для нахождения ближайшего <tr>
                    workshopRow.parentNode.removeChild(workshopRow);
                    alert("Автосервис удален!");
                } else {
                    console.error('Произошла ошибка при удалении автосервиса');
                }
            }
        };
        xhr.open('POST', '../assets/api/delete_workshop_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('workshop_id=' + workshopId);
    }

    // Вызов функции для инициализации обработчиков
    deleteWorkshopHandler();
    //добавление автосервиса
    $('.add-workshop-button').click(function () {
        var photoInput = document.getElementById('workshop_photo');
        var file = photoInput.files[0];

        if (file) {
            // Проверки на размер и тип файла...

            var reader = new FileReader();
            reader.onload = function (e) {
                var base64Image = e.target.result.split(',')[1];
                var mimeType = file.type;
                var name = $('#workshop_name').val();
                var address = $('#workshop_address').val();
                var hours = $('#workshop_hours').val();
                var price = $('#workshop_price').val();
                var latitude = null;
                var longitude = null;
                if (marker) {
                    var latlng = marker.getLatLng();
                    latitude = latlng.lat;
                    longitude = latlng.lng;
                }
                if (!name || !address || !hours || !price || !latitude || !longitude || !base64Image) {
                    alert("Заполните все поля!");
                    return;
                }

                // Отправка данных на сервер...
                $.ajax({
                    type: 'POST',
                    url: '../assets/api/add_workshop_script.php',
                    dataType: 'json',
                    data: {
                        workshop_name: name,
                        workshop_address: address,
                        workshop_hours: hours,
                        workshop_price: price,
                        latitude: latitude,
                        longitude: longitude,
                        photo: 'data:' + mimeType + ';base64,' + base64Image
                    },
                    success: function (response) {
                        alert('Автосервис успешно добавлен!');

                        // Добавляем новую запись в таблицу
                        var newWorkshop = response.workshop;
                        var tableBody = $('.workshops-table').find('tbody');
                        var newRow = $('<tr id="' + newWorkshop.id + '"></tr>');
                        newRow.append('<td><input type="text" name="workshop_name" class="admin-input" value="' + newWorkshop.workshop_name + '"/></td>');
                        newRow.append('<td><input type="text" name="workshop_address" class="admin-input" value="' + newWorkshop.workshop_address + '"/></td>');
                        newRow.append('<td><input type="text" name="workshop_time" class="admin-input" value="' + newWorkshop.workshop_hours + '"/></td>');
                        newRow.append('<td><input type="text" name="workshop_price" class="admin-input" value="' + newWorkshop.workshop_price + '"/></td>');
                        newRow.append('<td><img src="' + newWorkshop.photo + '" class="workshop-photo" style="width:150px; height:auto; cursor:pointer"><input type="hidden" name="workshop_photo" class="workshop-photo-hidden"></td>');
                        newRow.append("<td></td>");
                        newRow.append('<td><div class="update-workshop" data-workshop-id="' + newWorkshop.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="#232323" stroke-width="2" d="M1.75 16.002C3.353 20.098 7.338 23 12 23c6.075 0 11-4.925 11-11m-.75-4.002C20.649 3.901 16.663 1 12 1C5.925 1 1 5.925 1 12m8 4H1v8M23 0v8h-8"/></svg></div><div class="delete-workshop" data-workshop-id="' + newWorkshop.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20"><path fill="#232323" d="M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z"/></svg></div></td>');

                        tableBody.append(newRow);
                        deleteWorkshopHandler();
                        updateWorkshopHandler();
                        // Удаляем маркер с карты
                        if (marker) {
                            marker.remove();
                            marker = null;
                        }
                        // Очищаем поля ввода после успешной отправки
                        $('#workshop_name').val('');
                        $('#workshop_address').val('');
                        $('#workshop_hours').val('');
                        $('#workshop_price').val('');
                        $('#workshop_photo').val(''); // Очищаем поле загрузки фотографии
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Ошибка при добавлении автосервиса!");
                    }
                });
            };
            reader.readAsDataURL(file); // Чтение файла и преобразование в base64
        } else {
            alert("Выберите файл для загрузки!");
        }
    });

    function updateWorkshopHandler() {
        let currentPhotoInput = null;

        // Обработчик клика на фотографию
        $(document).on('click', '.workshop-photo', function () {
            currentPhotoInput = $(this).siblings('.workshop-photo-hidden');
            $('#hidden_file_input').click();
        });

        // Обработчик изменения файла фотографии
        $('#hidden_file_input').change(function () {
            const file = this.files[0];

            if (file) {
                if (file.size > 2 * 1024 * 1024) { // Проверка размера файла
                    alert("Размер файла не должен превышать 2 МБ");
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    const base64Image = e.target.result;
                    currentPhotoInput.val(base64Image);
                    currentPhotoInput.siblings('.workshop-photo').attr('src', base64Image);
                };
                reader.readAsDataURL(file); // Чтение файла и преобразование в base64
            }
        });

        // Обработчик клика на кнопку обновить данные автосервиса
        $(document).on('click', '.update-workshop', function () {
            const workshopId = $(this).data('workshop-id');
            const row = $('#' + workshopId);
            const name = row.find("input[name='workshop_name']").val();
            const address = row.find("input[name='workshop_address']").val();
            const hours = row.find("input[name='workshop_time']").val();
            const price = row.find("input[name='workshop_price']").val();
            const photo = row.find("input[name='workshop_photo']").val();

            // Отправляем данные на сервер...
            const data = {
                workshop_id: workshopId,
                workshop_name: name,
                workshop_address: address,
                workshop_hours: hours,
                workshop_price: price,
                photo: photo
            };

            fetch('../assets/api/update_workshop_script.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Автомастерская обновлена успешно!");
                    } else {
                        alert("Ошибка при обновлении!");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Error updating workshop!");
                });
        });
    }
    updateWorkshopHandler();
});