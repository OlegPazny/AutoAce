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
                document.location.href='/signin.php';
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