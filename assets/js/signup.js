//регистрация
$('.register-btn').click(function(e){
    e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)

    $(`input`).removeClass('error');//очищение инпутов от класса error

    let name=$('input[name="name"]').val();
    let login=$('input[name="login"]').val();
    let password=$('input[name="password"]').val();
    let email=$('input[name="email"]').val();
    let password_confirm=$('input[name="password_confirm"]').val();
    
    let formData=new FormData();
    formData.append('name', name);
    formData.append('login', login);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('password_confirm', password_confirm);

    $.ajax({
        url:'../assets/api/signup_script.php',
        type:'POST',
        dataType:'json',
        data:formData,
        processData: false,
        contentType:false,
        cache:false,

        success:function(data){
            if(data.status){
                $('input[name="name"]').val('');
                $('input[name="login"]').val('');
                $('input[name="password"]').val('');
                $('input[name="email"]').val('');
                $('input[name="password_confirm"]').val('');
                $('.popup__bg__error-success').addClass('active');
                $('.popup__error-success').addClass('active');
                $('.popup__error-success .data-text').text('Для подтверждения аккаунта проверьте свою почту.');
                document.querySelector('.popup__bg__sign-in').classList.add('active'); // Добавляем класс 'active' для фона
                document.querySelector('.signup-section.signin').classList.add('active'); // И для самого окна

                if(document.querySelector('.popup__bg__sign-up').classList.contains('active')){
                    document.querySelector('.popup__bg__sign-up').classList.remove('active'); // Убираем активный класс с фона
                }
                if(document.querySelector('.signup-section.signup').classList.contains('active')){
                    document.querySelector('.signup-section.signup').classList.remove('active'); // И с окна
                }  

            }else{
                if(data.type===1){
                    data.fields.forEach(function(field){
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.message').removeClass('none').text(data.message);
            }
        }
    })
});