    // авторизация
$('.login-btn').click(function(e){
    e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)

    $(`input`).removeClass('error');//очищение инпутов от класса error

    let login=$('input[name="login"]').val();
    let password=$('input[name="password"]').val();

    $.ajax({
        url:'../assets/api/signin_script.php',
        type:'POST',
        dataType:'json',
        data:{
            login:login,
            password:password,
        },
        success:function(data){
            if(data.status){
                var target_url="../index.php";
                document.location.href= target_url;
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