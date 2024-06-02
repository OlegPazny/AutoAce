//регистрация
$('.reset-btn').click(function(e){
    e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)

    $(`input`).removeClass('error');//очищение инпутов от класса error

    let hash=$('input[name="hash"]').val();
    let password=$('input[name="password"]').val();
    let password_confirm=$('input[name="password_confirm"]').val();
    
    let formData=new FormData();
    formData.append('hash', hash);
    formData.append('password', password);
    formData.append('password_confirm', password_confirm);

    $.ajax({
        url:'../assets/api/reset_pass_script.php',
        type:'POST',
        dataType:'json',
        data:formData,
        processData: false,
        contentType:false,
        cache:false,

        success:function(data){
            if(data.status){
                document.location.href='index.php';
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