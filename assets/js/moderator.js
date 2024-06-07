// Обработчик клика на кнопке информации
$(document).ready(function () {
    // Функция для скрытия всех контейнеров, кроме переданного
    function hideContainers(exceptContainer) {
        $('.accounts, .orders, .history, .services, .service-types, .relations, .workers, .workshops').not(exceptContainer).hide();
    }

    // Функция для установки стилей кнопок
    function setButtonStyles(activeButton) {
        $('.info-btn, .orders-btn, .history-btn, .services-btn, .service-types-btn, .relations-btn, .workers-btn, .workshops-btn').css({
            'background': '#232323',
            'color': '#fff'
        });
        activeButton.css({
            'background': '#fff',
            'color': '#232323'
        });
    }

    // Обработчики кликов
    $('.info-btn').on('click', function () {
        hideContainers('.accounts');
        $('.accounts').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.orders-btn').on('click', function () {
        hideContainers('.orders');
        $('.orders').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.history-btn').on('click', function () {
        hideContainers('.history');
        $('.history').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.services-btn').on('click', function () {
        hideContainers('.services');
        $('.services').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.service-types-btn').on('click', function () {
        hideContainers('.service-types');
        $('.service-types').fadeIn('slow');
        setButtonStyles($(this));
    });

    $('.relations-btn').on('click', function () {
        hideContainers('.relations');
        $('.relations').fadeIn('slow');
        setButtonStyles($(this));
    });
    $('.workers-btn').on('click', function () {
        hideContainers('.workers');
        $('.workers').fadeIn('slow');
        setButtonStyles($(this));
    });
    $('.workshops-btn').on('click', function () {
        hideContainers('.workshops');
        $('.workshops').fadeIn('slow');
        setButtonStyles($(this));
    });

    //блокировка пользователя
    var blockButtons = document.querySelectorAll('.block-user');
    blockButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var userId = this.getAttribute('data-user-id');
            deleteUser(userId, button); // Передаем ссылку на кнопку вместе с userId
        });
    });
    function deleteUser(userId, button) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var userRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                    userRow.parentNode.removeChild(userRow);
                } else {
                    console.error('Произошла ошибка при удалении пользователя');
                }
            }
        };
        xhr.open('POST', '../assets/api/block_user_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('user_id=' + userId);
    }
    //изменение статуса заказа 

    var statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(function (select) {
        select.addEventListener('change', function () {
            var bookingId = this.getAttribute('data-booking-id');
            var newStatus = this.value;
            updateStatus(bookingId, newStatus);
        });
    });

    function updateStatus(bookingId, newStatus) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Обработка успешного ответа
                } else {
                    console.error('Произошла ошибка при обновлении статуса заказа');
                }
            }
        };
        xhr.open('POST', '../assets/api/update_status_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('booking_id=' + bookingId + '&new_status=' + newStatus);
    }
    //удаление записи
    function deleteBookHandler() {
        var deleteButtons = document.querySelectorAll('.delete-book');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var bookId = this.getAttribute('data-book-id');
                deleteBook(bookId, button); // Передаем ссылку на кнопку вместе с userId
            });
        });
        function deleteBook(bookId, button) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('запись удалена.');
                        var bookRow = button.parentNode.parentNode;
                        bookRow.parentNode.removeChild(bookRow);
                    } else {
                        console.error('Произошла ошибка при удалении записи');
                    }
                }
            };
            xhr.open('POST', '../assets/api/delete_book_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('book_id=' + bookId);
        }
    }

    deleteBookHandler();
    //изменение статуса заказа из истории заказов

    var statusSelects = document.querySelectorAll('.history-status-select');
    statusSelects.forEach(function (select) {
        select.addEventListener('change', function () {
            var bookingId = this.getAttribute('data-booking-id');
            var newStatus = this.value;
            updateStatus(bookingId, newStatus);
        });
    });

    function updateStatus(bookingId, newStatus) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Обработка успешного ответа
                } else {
                    console.error('Произошла ошибка при обновлении статуса заказа');
                }
            }
        };
        xhr.open('POST', '../assets/api/update_status_script.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('booking_id=' + bookingId + '&new_status=' + newStatus);
    }
    //добавление работника
    $('.add-worker-button').click(function () {
        var workerName = $('#worker_name').val();
        var workerEmail = $('#worker_email').val();
        var workerWorkshop = $('#worker_workshops_insert').val();

        if(workerEmail==""||workerName==""||!workerWorkshop){
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Заполните все поля формы.');
            return;
        }
        //проверка почты
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test(workerEmail)) {
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Почта введена некорректно');
            return;
        }

        const namePattern = /^[А-ЯЁа-яё]+ [А-ЯЁа-яё]+$/;

        if (!namePattern.test(workerName)) {
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Имя и фамилия введены некорректно');
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../assets/api/add_worker_script.php',
            dataType: 'json',
            data: {
                worker_name: workerName,
                worker_email: workerEmail,
                worker_workshop: workerWorkshop,
            },
            success: function (response) {
                $('.popup__bg__error-success').addClass('active');
                $('.popup__error-success').addClass('active');
                $('.popup__error-success .data-text').text('Работник добавлен.');

                var newWorker = response.worker;
                var tableBody = $('.workers-table').find('tbody'); // находим tbody во второй таблице

                // Создаем новую строку для мастера
                var newRow = $('<tr></tr>');

                // Создаем ячейки для новой строки
                newRow.append('<td>' + newWorker.worker_login + '</td>');
                newRow.append('<td>' + newWorker.worker_name + '</td>');
                newRow.append('<td>' + newWorker.worker_email + '</td>');
                newRow.append('<td>' + newWorker.worker_workshop + '</td>');
                newRow.append('<td>' + newWorker.select + '</td>');
                newRow.append('<td><div class="block-worker" data-worker-id="' + newWorker.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20"><path fill="#232323" d="M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z"/></svg></div></td>');

                // Добавляем новую строку в таблицу
                tableBody.find('tr').eq(1).before(newRow);
                deleteWorkerHandler();
                updateVacationHandler();
                // Очищаем поля ввода после успешной отправки
                $('#worker_name').val('');
                $('#worker_email').val('');
                $('#worker_workshops_insert:eq(0)').prop('selected', true);
            },
            error: function (xhr, status, error) {
                // Обработка ошибки AJAX-запроса
                console.error(xhr.responseText);
            }
        });
    });
    //блокировка работника
    function deleteWorkerHandler() {
        var blockButtons = document.querySelectorAll('.block-worker');
        blockButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var workerId = this.getAttribute('data-worker-id');
                deleteWorker(workerId, button); // Передаем ссылку на кнопку вместе с userId
            });
        });
        function deleteWorker(workerId, button) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('Работник удален.');
                        var workerRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                        workerRow.parentNode.removeChild(workerRow);
                    } else {
                        console.error('Произошла ошибка при удалении работника');
                    }
                }
            };
            xhr.open('POST', '../assets/api/block_worker_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('worker_id=' + workerId);
        }
    }
    deleteWorkerHandler();
    //изменение отпуска работника 
    function updateVacationHandler() {
        var vacationSelects = document.querySelectorAll('.vacation-select');
        vacationSelects.forEach(function (select) {
            select.addEventListener('change', function () {
                var workerId = this.getAttribute('data-worker-id');
                var newStatus = this.value;
                updateVacation(workerId, newStatus);
            });
        });

        function updateVacation(workerId, newStatus) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Обработка успешного ответа
                    } else {
                        console.error('Произошла ошибка при обновлении статуса работника');
                    }
                }
            };
            xhr.open('POST', '../assets/api/update_vacation_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('worker_id=' + workerId + '&new_status=' + newStatus);
        }
    }
    updateVacationHandler();
    //проверка скидки
    function validateDiscountInput(inputElement) {
        let discount = inputElement.val().trim(); // Получаем значение поля и удаляем лишние пробелы
        if (!/^(?:[1-9]?[0-9])$/.test(discount)&&discount!=="") {
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Некорректное значение скидки. Введите число от 1 до 99.');
            inputElement.val(''); // Очищаем поле ввода
            throw new Error("Некорректное значение скидки"); // Останавливаем выполнение скрипта
        }
    }
    //добавление услуги
    $('.add-service-button').click(function () {
        try {
            validateDiscountInput($('#service_discount')); // Проверяем корректность скидки
            var serviceName = $('#service_name').val();
            var serviceDescription = $('#service_description').val();
            var servicePrice = $('#service_price').val();
            var serviceType = $('#service_type').val();
            var serviceDiscount = $('#service_discount').val();

            if(serviceName==""||servicePrice==""||!serviceType){
                $('.popup__bg__error-success').addClass('active');
                $('.popup__error-success').addClass('active');
                $('.popup__error-success .data-text').text('Заполните все поля формы.');
                return;
            }
            // Регулярное выражение для проверки целого или дробного числа с десятыми
            const numberPattern = /^-?\d+(\.\d{1})?$/;

            if (!numberPattern.test(servicePrice)) {
                $('.popup__bg__error-success').addClass('active');
                $('.popup__error-success').addClass('active');
                $('.popup__error-success .data-text').text('Значение нормочаса введено некорректно.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '../assets/api/add_service_script.php',
                dataType: 'json',
                data: {
                    service_name: serviceName,
                    service_description: serviceDescription,
                    service_price: servicePrice,
                    service_type: serviceType,
                    service_discount: serviceDiscount
                },
                success: function (response) {
                    $('.popup__bg__error-success').addClass('active');
                    $('.popup__error-success').addClass('active');
                    $('.popup__error-success .data-text').text('Услуга успешно добавлена.');

                    var newService = response.service;
                    var tableBody = $('.services-table').find('tbody'); // находим tbody во второй таблице

                    // Создаем новую строку для услуги
                    var newRow = $('<tr></tr>');

                    // Создаем ячейки для новой строки
                    newRow.append('<td>' + newService.service_name + '</td>');
                    newRow.append('<td>' + newService.service_description + '</td>');
                    newRow.append('<td>' + newService.service_hours + ' н/ч</td>');
                    newRow.append('<td>' + newService.service_type + '</td>');
                    newRow.append('<td><input type="text" name="service_discount" class="admin-input" value="' + newService.service_discount + '"/></td>');
                    newRow.append('<td><div class="update-service" data-service-id="' + newService.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="none" stroke="#232323" stroke-width="2" d="M1.75 16.002C3.353 20.098 7.338 23 12 23c6.075 0 11-4.925 11-11m-.75-4.002C20.649 3.901 16.663 1 12 1C5.925 1 1 5.925 1 12m8 4H1v8M23 0v8h-8"/></svg></div><div class="delete-service" data-service-id="' + newService.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20"><path fill="#232323" d="M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z"/></svg></div></td>');

                    // Добавляем новую строку в таблицу
                    tableBody.find('tr').eq(1).before(newRow);
                    deleteServiceHandler();
                    updateServiceHandler();
                    // Очищаем поля ввода после успешной отправки
                    $('#service_name').val('');
                    $('#service_description').val('');
                    $('#service_type:eq(0)').prop('selected', true);
                    $('#service_price').val('');
                    $('#service_discount').val('');
                },
                error: function (xhr, status, error) {
                    // Обработка ошибки AJAX-запроса
                    console.error(xhr.responseText);
                }
            });
        } catch (error) {
            console.error(error);
        }

    });
    //обновление услуги
    function updateServiceHandler() {
        // Сначала удаляем все существующие обработчики
        $(document).off('click', '.update-service');
        // Обработчик клика на кнопку обновить данные автосервиса
        $(document).on('click', '.update-service', function () {
            try {
                const serviceId = $(this).data('service-id');
                const row = $(this).closest('tr');
                const discount = row.find("input[name='service_discount']").val();
                let discountInput = row.find("input[name='service_discount']");
                validateDiscountInput(discountInput); // Проверяем корректность скидки
                // Отправляем данные на сервер...
                const data = {
                    service_id: serviceId,
                    discount: discount
                };

                fetch('../assets/api/update_service_script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            $('.popup__bg__error-success').addClass('active');
                            $('.popup__error-success').addClass('active');
                            $('.popup__error-success .data-text').text('Услуга обновлена успешно.');
                        } else {
                            $('.popup__bg__error-success').addClass('active');
                            $('.popup__error-success').addClass('active');
                            $('.popup__error-success .data-text').text('Ошибка при обновлении услуги.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('Ошибка при обновлении услуги.');
                    });
            } catch (error) {
                console.error(error);
            }

        });
    }
    updateServiceHandler();
    //удаление услуги
    function deleteServiceHandler() {
        // Сначала удаляем все существующие обработчики
        $(document).off('click', '.delete-service');

        var deleteButtons = document.querySelectorAll('.delete-service');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var serviceId = this.getAttribute('data-service-id');
                deleteService(serviceId, button); // Передаем ссылку на кнопку вместе с userId
            });
        });
        function deleteService(serviceId, button) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var serviceRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                        serviceRow.parentNode.removeChild(serviceRow);
                    } else {
                        console.error('Произошла ошибка при удалении услуги');
                    }
                }
            };
            xhr.open('POST', '../assets/api/delete_service_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('service_id=' + serviceId);
        }
    }

    deleteServiceHandler();
    //добавление типа услуги
    $('.add-service-type-button').click(function () {
        var serviceTypeName = $('#service-type_name').val();

        $.ajax({
            type: 'POST',
            url: '../assets/api/add_service-type_script.php',
            dataType: 'json',
            data: {
                service_type_name: serviceTypeName,
            },
            success: function (response) {
                $('.popup__bg__error-success').addClass('active');
                $('.popup__error-success').addClass('active');
                $('.popup__error-success .data-text').text('Тип услуги успешно добавлен.');

                var newServiceType = response.serviceType;
                var tableBody = $('.service-types-table').find('tbody'); // находим tbody во второй таблице

                // Создаем новую строку для услуги
                var newRow = $('<tr></tr>');

                // Создаем ячейки для новой строки
                newRow.append('<td>' + newServiceType.type + '</td>');
                newRow.append('<td><div class="delete-service-type" data-service-type-id="' + newServiceType.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20"><path fill="#232323" d="M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z"/></svg></div></td>');

                // Добавляем новую строку в таблицу
                tableBody.find('tr').eq(1).before(newRow);
                deleteServiceTypeHandler();
                // Очищаем поля ввода после успешной отправки
                $('#service-type_name').val('');
            },
            error: function (xhr, status, error) {
                // Обработка ошибки AJAX-запроса
                console.error(xhr.responseText);
            }
        });
    });
    //удаление типа услуги
    function deleteServiceTypeHandler() {
        var deleteButtons = document.querySelectorAll('.delete-service-type');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var serviceTypeId = this.getAttribute('data-service-type-id');
                deleteServiceType(serviceTypeId, button); // Передаем ссылку на кнопку вместе с userId
            });
        });
        function deleteServiceType(serviceTypeId, button) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('Тип услуги успешно удален.');
                        var serviceTypeRow = button.parentNode.parentNode; // Используем parentNode для доступа к <td>, а затем к <tr>
                        serviceTypeRow.parentNode.removeChild(serviceTypeRow);
                    } else {
                        console.error('Произошла ошибка при удалении типа услуги');
                    }
                }
            };
            xhr.open('POST', '../assets/api/delete_service-type_script.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('service_type_id=' + serviceTypeId);
        }
    }

    deleteServiceTypeHandler();
    // Обработчик добавления отношения
    $('.add-relation-button').click(async function () {
        var workerNameRelation = $('#relation_worker_name').val();
        var serviceNameRelation = $('#relation_service_name').val();

        if (!workerNameRelation || !serviceNameRelation) {
            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Выберите услугу и работника.');
            return;
        }

        try {
            const response = await $.ajax({
                type: 'POST',
                url: '../assets/api/add_relation_script.php',
                dataType: 'json',
                data: {
                    service_name_relation: serviceNameRelation,
                    worker_name_relation: workerNameRelation,
                }
            });

            $('.popup__bg__error-success').addClass('active');
            $('.popup__error-success').addClass('active');
            $('.popup__error-success .data-text').text('Услуга успешно назначена.');
            var newRelation = response.relation;
            var addRelationRow = $('.add-relation-row');

            // Создаем новую строку таблицы на основе полученных данных
            var newRow = `
                <tr>
                    <td>${newRelation.worker_name}</td>
                    <td>${newRelation.workshop_name}</td>
                    <td>${newRelation.service_name}</td>
                    <td>
                        <div class='delete-relation' data-relation-id='${newRelation.id}'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 20 20'>
                                <path fill='#232323' d='M10 1a9 9 0 1 0 9 9a9 9 0 0 0-9-9m5 10H5V9h10z'/>
                            </svg>
                        </div>
                    </td>
                </tr>
            `;
            // Вставляем новую строку после строки ввода
            addRelationRow.after(newRow);
            // Привязываем обработчик удаления к новой строке
            deleteRelationHandler();

            // Сбрасываем выбранные значения в селектах
            $('#relation_worker_name').prop('selectedIndex', 0);
            $('#relation_service_name').prop('selectedIndex', 0);

            // Обновляем список услуг для выбранного работника
            await loadServices(workerNameRelation);

        } catch (error) {
            console.error('Ошибка при добавлении услуги:', error);
        }
    });
    // Функция привязки обработчиков удаления
    function deleteRelationHandler() {
        $('.delete-relation').off('click').on('click', async function () {
            var relationId = $(this).data('relation-id');

            try {
                const response = await $.ajax({
                    type: 'POST',
                    url: '../assets/api/delete_relation_script.php',
                    dataType: 'json',
                    data: { relation_id: relationId }
                });

                if (response.success) {
                    $('.popup__bg__error-success').addClass('active');
                    $('.popup__error-success').addClass('active');
                    $('.popup__error-success .data-text').text('Связь успешно удалена.');
                    $(this).closest('tr').remove();
                } else {
                    $('.popup__bg__error-success').addClass('active');
                    $('.popup__error-success').addClass('active');
                    $('.popup__error-success .data-text').text('Ошибка при удалении связи.');
                }
            } catch (error) {
                console.error('Ошибка при удалении услуги:', error);
            }
        });
    }

    // Привязываем обработчики к существующим элементам при загрузке страницы
    deleteRelationHandler();
    // Получаем ссылку на элемент <select> для услуги и работника
    var workerSelect = $(".workers-input");
    var serviceSelect = $(".services-input");
    var workshop_block = $("#worker-workshop");

    /// Функция для загрузки услуг по выбранному работнику
    async function loadServices(workerId) {
        try {
            const servicesResponse = await fetch(`../assets/api/get_new_worker_service_script.php?worker_id=${workerId}`);
            const services = await servicesResponse.json();
            // Очищаем список услуг и добавляем опцию по умолчанию
            serviceSelect.html('<option selected disabled>Выберите услугу</option>');
            // Заполняем список услуг
            services.forEach(service => {
                serviceSelect.append(new Option(service[1], service[0]));
            });
        } catch (error) {
            console.error('Ошибка при получении данных об услугах:', error);
        }
    }

    // Слушаем изменения в выборе работника
    workerSelect.on("change", async function () {
        var selectedWorkerId = $(this).val();

        // Очищаем список автосервисов
        workshop_block.text('');

        if (selectedWorkerId) {
            try {
                // Запрос на сервер для получения автосервиса
                const workshopResponse = await fetch(`../assets/api/get_worker_workshop_script.php?worker_id=${selectedWorkerId}`);
                const workshop = await workshopResponse.json();
                // Обновляем блок автосервиса
                workshop_block.text(workshop);
            } catch (error) {
                console.error('Ошибка при получении данных об автосервисе:', error);
            }

            // Загружаем услуги для выбранного работника
            await loadServices(selectedWorkerId);
        }
    });
    //наполнение селекта автосервисов
    function loadWorkshopSelect() {
        const workshopSelect = $('#worker_workshops_insert');

        // Функция для заполнения select
        function fillSelect(options) {
            workshopSelect.empty(); // Очищаем текущие опции

            // Создаем и добавляем опцию "Выберите автосервис"
            const defaultOption = $('<option></option>').text('Выберите автосервис').prop('disabled', true).prop('selected', true);
            workshopSelect.append(defaultOption);

            // Заполняем select остальными опциями
            options.forEach(option => {
                const newOption = $('<option></option>').val(option.value).text(option.text);
                workshopSelect.append(newOption);
            });
        }

        // Обработчик клика на select
        workshopSelect.on('mousedown', async (event) => {
            if (event.target.tagName.toLowerCase() === 'option') {
                event.stopPropagation(); // Останавливаем распространение события
            } else {
                try {
                    const response = await fetch('../assets/api/get_workshops_script.php');
                    const options = await response.json();
                    fillSelect(options);
                } catch (error) {
                    console.error('Ошибка при загрузке данных:', error);
                }
            }
        });
    }
    loadWorkshopSelect();
    //наполнение селекта типа услуги
    function loadServiceTypesSelect() {
        const serviceTypeSelect = $('#service_type');

        // Функция для заполнения select
        function fillSelect(options) {
            serviceTypeSelect.empty(); // Очищаем текущие опции

            // Создаем и добавляем опцию "Выберите тип услуги"
            const defaultOption = $('<option></option>').text('Выберите тип услуги').prop('disabled', true).prop('selected', true);
            serviceTypeSelect.append(defaultOption);

            // Заполняем select остальными опциями
            options.forEach(option => {
                const newOption = $('<option></option>').val(option.value).text(option.text);
                serviceTypeSelect.append(newOption);
            });
        }

        // Обработчик клика на select
        serviceTypeSelect.on('mousedown', async (event) => {
            if (event.target.tagName.toLowerCase() === 'option') {
                event.stopPropagation(); // Останавливаем распространение события
            } else {
                try {
                    const response = await fetch('../assets/api/get_service_types_script.php');
                    const options = await response.json();
                    fillSelect(options);
                } catch (error) {
                    console.error('Ошибка при загрузке данных:', error);
                }
            }
        });
    }
    loadServiceTypesSelect();
    //наполнение селекта работников
    function loadWorkersSelect() {
        const workerSelect = $('#relation_worker_name');

        // Функция для заполнения select
        function fillSelect(options) {
            workerSelect.empty(); // Очищаем текущие опции

            // Создаем и добавляем опцию "Выберите работника"
            const defaultOption = $('<option></option>').text('Выберите механика').prop('disabled', true).prop('selected', true);
            workerSelect.append(defaultOption);

            // Заполняем select остальными опциями
            options.forEach(option => {
                const newOption = $('<option></option>').val(option.value).text(option.text);
                workerSelect.append(newOption);
            });
        }

        // Обработчик клика на select
        workerSelect.on('mousedown', async (event) => {
            if (event.target.tagName.toLowerCase() === 'option') {
                event.stopPropagation(); // Останавливаем распространение события
            } else {
                try {
                    const response = await fetch('../assets/api/get_workers_script.php');
                    const options = await response.json();
                    fillSelect(options);
                } catch (error) {
                    console.error('Ошибка при загрузке данных:', error);
                }
            }
        });
    }
    loadWorkersSelect();
});