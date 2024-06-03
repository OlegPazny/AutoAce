$(document).ready(function () {
    //удаление записи
    function deleteBookHandler() {
        var deleteButtons = document.querySelectorAll('.order-card__delete');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var bookId = this.getAttribute('data-book-id');
                deleteService(bookId, button); // Передаем ссылку на кнопку вместе с userId
            });
        });
        function deleteService(bookId, button) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        $('.popup__bg__error-success').addClass('active');
                        $('.popup__error-success').addClass('active');
                        $('.popup__error-success .data-text').text('Запись удалена.');
                        var bookCard = button.parentNode;
                        bookCard.parentNode.removeChild(bookCard);
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
});