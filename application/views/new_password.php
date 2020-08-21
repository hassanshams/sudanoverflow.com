<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-5">
            <div class="text-center">ادخل كلمة المرور الجديدة</div> <br>
            <div class="form-group">
                <input type="password" id="password" class="form-control" placeholder="كلمة المرور"><br>
                <input type="password" id="confirm_password" class="form-control" placeholder="تاكيد كلمة المرور"><br>
                <button id="change" class="btn btn-primary btn-lg btn-block">ارسال</button>
                <div class="float-right" id="empty" style="display:none;color:red;">الرجاء ادخال كلمة المرور </div>
                <div class="float-right" id="password_not_match" style="display:none;color:red;">كلمتي المرور غير متطابقتين</div>
                <div class="float-right" id="try_again" style="display:none;color:red;">حدث خطأ ما حاول مرة اخري</div>
            </div>
        </div>
    </div>
</div>
<input hidden id="email" value="<?php echo $_GET['email']; ?>" >
<script>
      $('body').on('click','#change',function(){    
    var email = $('#email').val();
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();
    if(password == "" || confirm_password == ""){
      $('#empty').css({'display':'block','margin-top':'10px'});
      $("#empty").delay(3000).hide(0);
      return;
    }
        if($('#password').val() !== $('#confirm_password').val()){
          $('#password_not_match').css({'display':'block','margin-top':'10px'});
          $("#password_not_match").delay(3000).hide(0);
          return;
        }
        var data = [];
        data.push(password,email);
        $.ajax({
          url:"<?php echo base_url(); ?>main/change_password",
          method:"POST",
          dataType:'json',
          data:{data:data},
          async:false,
          success:function(data){
            if(data == 'ok'){
                window.location = '<?php echo base_url("main/login");?>';
            }else{
                $('#try_again').css({'display':'block','margin-top':'10px'});
                $("#try_again").delay(3000).hide(0);
            }
          }
        }); 
    });
</script>