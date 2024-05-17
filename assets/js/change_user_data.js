$('.account-info__submit').click(function (e) {
    e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)

    $(`input`).removeClass('error');//очищение инпутов от класса error

    let name = $('input[name="name"]').val();
    let email = $('input[name="email"]').val();
    let password = $('input[name="password"]').val();
    let new_password = $('input[name="new_password"]').val();

    let formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('new_password', new_password);

    $.ajax({
        url: '../assets/api/change_user_data_script.php',
        type: 'POST',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,

        success: function (data) {
            if (data.status) {
                document.location.href = 'account.php';
            } else {
                if (data.type === 1) {
                    data.fields.forEach(function (field) {
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.message').removeClass('none').text(data.message);
            }
        }
    })
});

//удаление автомобиля
function deleteVehicleHandler() {
    var blockButtons = document.querySelectorAll('.delete-vehicle');
    blockButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var vehicleId = this.getAttribute('data-vehicle-id');
            deleteVehicle(vehicleId, button);
        });
    });
    function deleteVehicle(vehicleId, button) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var vehicleRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                    vehicleRow.parentNode.removeChild(vehicleRow);
                } else {
                    console.error('Произошла ошибка при удалении автомобиля');
                }
            }
        };
        xhr.open('POST', '../assets/api/delete_vehicle_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('vehicle_id=' + vehicleId);
    }
}
deleteVehicleHandler();

// Применение маски для номера
$('#number_plate').mask('0000 AA-0', {
    translation: {
        'A': { pattern: /[A-Za-z]/ }
    }
});

// Автоматическое преобразование строчных букв в заглавные
$('#number_plate').on('input', function () {
    var value = $(this).val();
    // Преобразование строчных букв в заглавные
    var uppercasedValue = value.toUpperCase();
    // Обновление значения инпута
    $(this).val(uppercasedValue);
});

//маска для марки
$('#vehicle_brand').on('input', function() {
    var value = $(this).val();
                
    // Удаление всех символов, кроме латинских и кириллических букв, дефисов и пробелов
    value = value.replace(/[^A-Za-zА-Яа-яЁё \-]/g, '');
    
    // Преобразование первой буквы в каждом слове в заглавную
    var words = value.split(' ');
    for (var i = 0; i < words.length; i++) {
        if (words[i].length > 0) {
            words[i] = words[i][0].toUpperCase() + words[i].substr(1);
        }
    }
    var newValue = words.join(' ');
    $(this).val(newValue);
});
//добавление автомобиля
$('.add-vehicle-button').click(function () {
    var vehicleBrand = $('#vehicle_brand').val();
    var numberPlate = $('#number_plate').val();

    $.ajax({
        type: 'POST',
        url: '../assets/api/add_vehicle_script.php',
        dataType: 'json',
        data: {
            vehicleBrand: vehicleBrand,
            numberPlate: numberPlate
        },
        success: function (response) {
            console.log('Автомобиль добавлен!');
            //получаем значение последнего индекса
            var newVehicle = response.vehicle;
            var tableBody = $('.vehicles-table').find('tbody'); // находим tbody во второй таблице
            // Находим последнюю строку таблицы
            var lastRow = $('.vehicles-table tr').last();
            // Получаем значение ячейки нужного столбца в последней строке
            var cellValue = lastRow.find('td').eq(0).text();
            currentIndex = parseInt(cellValue) + 1;

            // Создаем новую строку для мастера
            var newRow = $('<tr></tr>');

            // Создаем ячейки для новой строки
            newRow.append('<td>' + currentIndex + '</td>');
            newRow.append('<td>' + newVehicle.brand + '</td>');
            newRow.append('<td>' + newVehicle.number_plate + '</td>');
            newRow.append('<td><div class="delete-vehicle" data-vehicle-id="' + newVehicle.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20"><path fill="#232323" d="M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z"/></svg></div></td>');

            // Добавляем новую строку в таблицу
            tableBody.append(newRow);
            deleteVehicleHandler();
            // Очищаем поля ввода после успешной отправки
            $('#vehicle_brand').val('');
            $('#number_plate').val('');
        },
        error: function (xhr, status, error) {
            // Обработка ошибки AJAX-запроса
            console.error(xhr.responseText);
        }
    });
});