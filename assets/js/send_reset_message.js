//смена пароля
$('.reset-pass-btn').click(function(e){
    e.preventDefault();//не обновляет страницу при клике(отключение стандартного поведения)

    $(`input`).removeClass('error');//очищение инпутов от класса error

    let email=$('input[name="reset_email"]').val();
    
    let formData=new FormData();
    formData.append('email', email);
    
    $.ajax({
        url:'../assets/api/send_reset_message_script.php',
        type:'POST',
        dataType:'json',
        data:formData,
        processData: false,
        contentType:false,
        cache:false,

        success:function(data){
            if(data.status){
                $('.reset-pass-message').removeClass('none').text(data.message);
            }else{
                if(data.type===1){
                    data.fields.forEach(function(field){
                        $(`input[name="${field}"]`).addClass('error');
                    });
                }
                $('.reset-pass-message').removeClass('none').text(data.message);
            }
        }
    })
});