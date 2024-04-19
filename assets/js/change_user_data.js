//регистрация
$('.account-info__submit').click(function(e){
    e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)

    $(`input`).removeClass('error');//очищение инпутов от класса error

    let name=$('input[name="name"]').val();
    let email=$('input[name="email"]').val();
    let password=$('input[name="password"]').val();
    let new_password=$('input[name="new_password"]').val();
    
    let formData=new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('new_password', new_password);

    $.ajax({
        url:'../assets/api/change_user_data_script.php',
        type:'POST',
        dataType:'json',
        data:formData,
        processData: false,
        contentType:false,
        cache:false,

        success:function(data){
            if(data.status){
                document.location.href='account.php';
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