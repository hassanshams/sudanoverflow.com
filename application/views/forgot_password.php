<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-5">
            <div class="text-center">ادخل عنوان بريدك الالكتروني و سوف نرسل لك رمز تاكيد لاستعادة حسابك.</div> <br>
            <div class="form-group">
                <input type="text" id="email" class="form-control" placeholder="البريد الالكتروني"><br>
                <button id="recover" class="btn btn-primary btn-lg btn-block">ارسال</button>
                <div class="float-right" id="email_error" style="display:none;color:red;">لم يتم التعرف علي عنوان يريدك ! الرجاء التاكد و المحاولة مرة اخري </div>
                <div class="float-right" id="empty" style="display:none;color:red;">الرجاء ادخال بريدك</div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('body').on('click','#recover',function(){
            var email = $('#email').val();
            //validate inputs here then
            if(email == ""){
                $('#empty').css({'display':'block','margin-top':'10px'});
                $("#empty").delay(3000).hide(0);
                return false;
            }
            $.ajax({
                url:"<?php echo base_url(); ?>main/check_email",
                method:"POST",
                dataType:'json',
                data:{email:email},
                async:false,
                success:function(data){
                    if(data == 'used'){
                        $.ajax({
                            url:"<?php echo base_url(); ?>main/send_recovery_mail",
                            method:"POST",
                            dataType:'json',
                            data:{email:email},
                            async:false,
                            success:function(data){
                                console.log(data);
                                if(data.includes('is not a valid RFC-5321 address')){
                                    $('#email_error').css({'display':'block','margin-top':'10px'});
                                    $("#email_error").delay(3000).hide(0);
                                } 
                                if(data=='ok'){
                                    window.location = '<?php echo base_url("main/account_recovery");?>'+'?email='+email;
                                }  
                            }
                        });
                    }else{
                        $('#email_error').css({'display':'block','margin-top':'10px'});
                        $("#email_error").delay(3000).hide(0);
                    }
                }
            });
        });
    });
</script>