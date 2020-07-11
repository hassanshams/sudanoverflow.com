
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src='<?php echo base_url() ; ?>/js/fb-init.js'></script>
    <meta name="google-signin-client_id" content="556018149305-39m21evvtgv424b1s14foth9du2dm3en.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js?onload=onLoadCallback" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<input hidden id="url" value="<?php echo @$_POST['url'];?>">
    <br><br>
    <div class="container">
    <div class="row justify-content-md-center">
                <div class="col-md-5">
                <div><img id="logo_on_login" src="<?php echo base_url('/images/logo.png');?>"></div>
                </div>
            </div>
            <br><br>
        <div class="row justify-content-md-center">
            <div class="col-md-5" id='login_box'>    
                <div class="justify-content-md-center row" id='social_login'>
                    <img id='fb_login' src="<?php echo base_url('images/fb.png');?>">
                    <img id='google_login_button' src="<?php echo base_url('images/go.png');?>">
                </div>
                  <div class="form-group">
                    <input type="text" id="email" class="form-control" placeholder="البريد الالكتروني">
                  </div>
                  <div class="form-group">
                    <input type="password" id="password" class="form-control" placeholder="كلمة المرور">
                  </div>
                  <button id="login_btn" class="btn btn-primary btn-lg btn-block">دخول</button>
                  <div style="margin-top:7px;color:red">
                    <div class="float-right" id="wrong_cred" style="display:none">خطأ في الايميل او كلمة المرور !</div>
                    <div class="float-right" id="social_error_f" style="display:none">لم تسجل بحساب فيسبوك !</div>
                    <div class="float-right" id="social_error_G" style="display:none">لم تسجل بحساب قوقل !</div>
                    <div class="float-right" id="empty_feild" style="display:none">الرجاء ملئ كل الحقول!</div>
                    <div class="float-right" id="not_activated_account" style="display:none">الحساب غير مفعل .. سوف تجد رابط التفعيل علي بريدك الالكتروني</div>
                  </div>
                  <br>
                  <div>
                    <a class="float-right" href="<?php echo base_url('main/forgot_password');?>">نسيت كلمة المرور ؟</a>
                    <a href="<?php echo base_url('main/signup');?>">ليس لديك حساب ؟</a>
                  </div>
                  <br>
                <div class="text-center">®Powered By Revo Tech</div>
                <br>
            <div>
        </div>
    </div>
</body>
</html>

<script> 
$(document).ready(function(){ 
    //normal login
$('body').on('click','#login_btn',function(e){
    var email = $('#email').val();
    var password = $('#password').val();
    var url = $('#url').val();
    var data =[];  data.push(email,password,url);
    //validate inputs here
    if(email == '' || password == ''){
        $('#empty_feild').css('display','block');
        $("#empty_feild").delay(3000).hide(0);
        return false;
    }
    $.ajax({
        url:"<?php echo base_url(); ?>main/validate_login",
        method:"POST",
        dataType:'json',
        async:false,
        data:{data:data},
        success:function(data){
            if(data == 'ok'){
                if(url){
                    window.location = url;
                }else{
                    window.location = '<?php echo base_url("main/home");?>';
                }
            }else{
                $('#wrong_cred').css('display','block');
                $("#wrong_cred").delay(3000).hide(0);
            }
        }
    });   
});
});

var userdata=[];
$("#fb_login").click(function(){
    facebookLogin(); 
});

function facebookLogin(){
    FB.login(function(response){
        if(response.status == 'connected'){
             FB.api('/me',{fields:'email,name'},function(data){
                 if(data){
                    console.log(data);
                    var email = data.email;
                    $.ajax({
                       url:"<?php echo base_url(); ?>main/check_login_email",
                       method:"POST",
                       dataType:'json',
                       async:false,
                       data:{data:data},
                       success:function(data){
                           if(data == 'not-activated'){
                            $('#not_activated_account').css('display','block');
                            $("#not_activated_account").delay(3000).hide(0);
                            return false;
                           }
                           if(data == 'activated'){
                               window.location = "<?php echo base_url('main/home');?>";
                           }
                           if(data == 'new_account_created'){
                            window.location = "<?php echo base_url('main/home');?>";
                           }
                        }
                   });
                 }
            });
        }else{
            $('#social_error_f').css('display','block');
            $("#social_error_f").delay(3000).hide(0);
            }
        });
    }

</script>

<!-- google login -->

<script>
function onLoadCallback() {
    gapi.load('auth2', function() {
        gapi.auth2.init({
            client_id: '556018149305-39m21evvtgv424b1s14foth9du2dm3en.apps.googleusercontent.com',
            fetch_basic_profile: true,
            scope: 'email'
        });        
      });     
    }
$('body').on('click',"#google_login_button",function() {
    auth2 = gapi.auth2.getAuthInstance();  
    auth2.signIn().then(function() {
          var profile = auth2.currentUser.get().getBasicProfile();
          var name = profile.getName();
          var email = profile.getEmail();
          var data ={};data.email=email;data.name=name;
          $.ajax({
                url:"<?php echo base_url(); ?>main/check_login_email",
                method:"POST",
                dataType:'json',
                async:false,
                data:{data:data},
                success:function(data){
                    if(data == 'not-activated'){
                        $('#not_activated_account').css('display','block');
                        $("#not_activated_account").delay(3000).hide(0);
                        return false;
                    }
                    if(data == 'activated'){
                        window.location = "<?php echo base_url('main/home');?>";
                    }
                    if(data == 'new_account_created'){
                        window.location = "<?php echo base_url('main/home');?>";
                    }
                    }
            });
        });    
});
</script>