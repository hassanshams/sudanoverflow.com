<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-5">
            <div class="text-center">ادخل رمز التاكيد  </div> <br>
            <div class="form-group">
                <input type="text" id="code" class="form-control" placeholder="رمز التاكيد"><br>
                <button id="recover" class="btn btn-primary btn-lg btn-block">ارسال</button>
                <div class="float-right" id="empty" style="display:none;color:red;">الرجاء ادخال رمز التاكيد</div>
                <div class="float-right" id="wrong_code" style="display:none;color:red;">رمز التاكيد خاطيء</div>

            </div>
        </div>
    </div>
</div>
<input type='hidden' id='email' value='<?php echo $_GET['email'];?>'>
<script>
    $(document).ready(function(){
        $('body').on('click','#recover',function(){
            //validate inputs here
            var email = $('#email').val();
            var code =  $('#code').val();
            if(code == ""){
                $('#empty').css({'display':'block','margin-top':'10px'});
                $("#empty").delay(3000).hide(0);
                return;                      
            }
            var data = [];   
            data.push(email);  
            data.push(code);
            $.ajax({
                url:"<?php echo base_url(); ?>main/check_recovery_token",
                method:"POST",
                dataType:'json',
                data:{data:data},
                async:false,
                success:function(data){
                    if(data == 'ok'){
                        //show success message here
                        window.location = '<?php echo base_url("main/new_password");?>'+'?email='+email;
                    }else{
                        $('#wrong_code').css({'display':'block','margin-top':'10px'});
                        $("#wrong_code").delay(3000).hide(0);
                    }                    
                }
            });
        });
    });
</script>