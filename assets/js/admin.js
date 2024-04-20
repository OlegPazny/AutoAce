// Обработчик клика на кнопке информации
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
});