<!DOCTYPE html>
<html>
<body>
  <input hidden id="url" value="<?php echo @$_POST['url'];?>">
    <div class="container">
        <br>
      <div class="row justify-content-md-center">
        <div class="col-md-8" id="signup_box">
          <br>
          <br>
          <img id='logo_on_login' src="<?php echo base_url('images/logo.png');?>">
          <br>
          <div class="form-group">
            <input type="text" id="u" class="form-control" placeholder="اسم المستخدم ">
          </div>
          <div class="form-group">
            <input type="text" id="email" class="form-control" placeholder="البريد الالكتروني">
          </div>
          <div class="form-group">
            <input type="password" id="password" class="form-control" placeholder="كلمة المرور">
          </div>
          <div class="form-group">
            <input type="password" id="confirm_password" class="form-control" placeholder="تأكيد كلمة المرور">
          </div>
          <div class="float-right" id="empty_feild" style="display:none;color:red;">الرجاء ملئ كل الحقول!</div>
          <div class="float-right" id="used_email" style="display:none;color:red;">البريد مستخدم مسبقا!</div>
          <div class="float-right" id="password_not_match" style="display:none;color:red;">كلمة المرور غير مطابقة</div>
          <div class="float-right" id="good_to_go" style="display:none;color:red;">تم انشاء حسابك بنجاح .. قمنا بارسال رابط تنشيط الي بريدك</div>
          <div class="float-right" id="db_error" style="display:none;color:red;">حدث خطا ما الرجاء المحاولة مرة اخري !</div>
          <div class="float-right" id="emai_error" style="display:none;color:red;">لم يتم التعرف علي عنوان يريدك ! الرجاء التاكد و المحاولة مرة اخري </div>
          <div class="form-group">
            <button id="signup" class="btn btn-primary btn-lg btn-block">حفظ</button>
          </div>
          <div class="text-center">®Powered By Revo Tech</div>
        </div>
       </div>
    </div>
</body>
</html>
<script>
$(document).ready(function(){
  $('body').on('click','#signup',function(){    
    var url = $('#url').val();
    var u = $('#u').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();
    if(u == "" || email == "" || password == "" || confirm_password == ""){
      $('#empty_feild').css({'display':'block','margin-bottom':'10px'});
      $("#empty_feild").delay(3000).hide(0);
      return;
    }
        if($('#password').val() !== $('#confirm_password').val()){
          $('#password_not_match').css({'display':'block','margin-bottom':'10px'});
          $("#password_not_match").delay(3000).hide(0);
          return;
        }
        var user_data=[];
        user_data.push(u);
        user_data.push(password);
        user_data.push(email);
        user_data.push(confirm_password);
        var mail_used = false;
        $.ajax({
          url:"<?php echo base_url(); ?>main/check_email",
          method:"POST",
          dataType:'json',
          data:{email:email},
          async:false,
          success:function(data){
            console.log(data);
            if(data=='used'){
              $('#used_email').css({'display':'block','margin-bottom':'10px'});
              mail_used=true;
            }
          }
        }); 
        if(mail_used){return;}   
        $.ajax({
          url:"<?php echo base_url(); ?>main/unverified_signup",
           method:"POST",
           dataType:'json',
           async:false,
           data:{user_data:user_data},
           success:function(data){
             console.log(data);
             if(data == 'ok'){
               $('#good_to_go').css({'display':'block','margin-bottom':'10px'});
               return;
             }
             if(data == 'not-inserted-to-db'){
               $('#db_error').css({'display':'block','margin-bottom':'10px'});
               return;
             }
             if(data.includes('is not a valid RFC-5321 address')){
               $('#emai_error').css({'display':'block','margin-bottom':'10px'});
             }
          }
       });
    });
});
</script>