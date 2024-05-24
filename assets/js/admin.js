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
            attribution: '© MapTiler © OpenStreetMap contributors',
            tileSize: 512,
            zoomOffset: -1,
            crossOrigin: true,
            maxZoom: 18
        }).addTo(map);

        map.on('click', function (e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
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
    function deleteWorkshopHandler() {
        var deleteButtons = document.querySelectorAll('.delete-workshop');

        deleteButtons.forEach(function (button) {
            // Удаляем существующий обработчик, если он есть
            button.removeEventListener('click', handleDeleteButtonClick);

            // Добавляем новый обработчик
            button.addEventListener('click', handleDeleteButtonClick);
        });

        function handleDeleteButtonClick() {
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
                        var workshopRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
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
    }

    // Вызов функции для инициализации обработчиков
    deleteWorkshopHandler();
    //добавление автосервиса
    $('.add-workshop-button').click(function () {
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
        if (!name || !address || !hours || !price || !latitude || !longitude) {
            alert("Заполните все поля!");

            return 0;
        }
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
                longitude: longitude
            },
            success: function (response) {
                alert('Автосервис успешно добавлен!');

                var newWorkshop = response.workshop;
                var tableBody = $('.workshops-table').find('tbody');

                var newRow = $('<tr id="' + newWorkshop.id + '"></tr>');
                newRow.append('<td><input type="text" name="workshop_name" class="admin-input" value="' + newWorkshop.workshop_name + '"/></td>');
                newRow.append('<td><input type="text" name="workshop_address" class="admin-input" value="' + newWorkshop.workshop_address + '"/></td>');
                newRow.append('<td><input type="text" name="workshop_time" class="admin-input" value="' + newWorkshop.workshop_hours + '"/></td>');
                newRow.append('<td><input type="text" name="workshop_price" class="admin-input" value="' + newWorkshop.workshop_price + '"/></td>');
                newRow.append('<td></td>');
                newRow.append('<td><div class="update-workshop" data-workshop-id="' + newWorkshop.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="#232323" stroke-width="2" d="M1.75 16.002C3.353 20.098 7.338 23 12 23c6.075 0 11-4.925 11-11m-.75-4.002C20.649 3.901 16.663 1 12 1C5.925 1 1 5.925 1 12m8 4H1v8M23 0v8h-8"/></svg></div><div class="delete-workshop" data-workshop-id="' + newWorkshop.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20"><path fill="#232323" d="M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z"/></svg></div></td>');

                tableBody.append(newRow);
                deleteWorkshopHandler();
                updateWorkshopHandler();
                // Очищаем поля ввода после успешной отправки
                $('#workshop_name').val('');
                $('#workshop_address').val('');
                $('#workshop_hours').val('');
                $('#workshop_price').val('');
            },
            error: function (xhr, status, error) {
                // Обработка ошибки AJAX-запроса
                console.error(xhr.responseText);
            }
        });
    });
    function updateWorkshopHandler() {
        document.querySelectorAll(".update-workshop").forEach(button => {
            button.addEventListener("click", function () {
                const workshopId = this.getAttribute("data-workshop-id");
                const row = document.getElementById(workshopId);
                const name = row.querySelector("input[name='workshop_name']").value;
                const address = row.querySelector("input[name='workshop_address']").value;
                const hours = row.querySelector("input[name='workshop_time']").value;
                const price = row.querySelector("input[name='workshop_price']").value;

                const data = {
                    workshop_id: workshopId,
                    workshop_name: name,
                    workshop_address: address,
                    workshop_hours: hours,
                    workshop_price: price
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
        });
    }
    updateWorkshopHandler();
});