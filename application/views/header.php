<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/bootstrap.min.css'>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/bootstrap-rtl.min.css'>
    <script src='<?php echo base_url() ; ?>/js/jquery-3.2.1.min.js'></script>
    <script src='<?php echo base_url() ; ?>/js/bootstrap.min.js'></script>
    <script src='<?php echo base_url() ; ?>/js/dropzone.js'></script>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/style.css'>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/dropzone.css'>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet"> 


	<meta charset="utf-8">
        <title></title>
    <div style="display:none" id="user"><?php echo $this->session->userdata('user');?></div>
    <div style="display:none" id="username"><?php echo $this->session->userdata('username');?></div>
 </head>


 <div id="not_logged_msg" style="display:none">
    <div>
      <h3>تلزمك عضوية سودان اوفرفلو</h3>
      <span>يمكنك</span>
      <form class="text-center" method="post" action="<?php echo base_url('main/login');?>">
      <input name="url" hidden value="<?php echo current_url();?>">
      <button type="submit"> تسجيل الدخول</button>
      </form>
      <span>او</span>
      <form class="text-center" method="post" action="<?php echo base_url('main/signup');?>">
      <input name="url" hidden value="<?php echo current_url();?>">
        <button type="submit">انشاء حساب</button>
        </form>
    </div>
 </div>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img id="logo" src="<?php echo base_url('images/logo.png');?>"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item">
      <a class="nav-item nav-link " id="home_top_nav" href="<?php echo base_url('main/home'); ?>">الرئيسية</a>  
      </li>
      <li class="nav-item ">
      <a class="nav-item nav-link check_login" id="ask_top_nav" href="<?php echo base_url('main/ask'); ?>">اسال</a>      
      </li>
      <li class="nav-item ">
      <a class="nav-item nav-link" href="<?php echo base_url('main/tags'); ?>" id="tags_top_nav">اقسام</a>      
      </li>
      <li class="nav-item ">
      <a class="nav-item nav-link" href="<?php echo base_url('main/users'); ?>" id="users_top_nav">مستخدمين</a>      
      </li>
      <li class="nav-item ">
      <a class="nav-item nav-link" href="<?php echo base_url('main/guide'); ?>" id="guide_top_nav">دليل الموقع</a>      
      </li>
      <li class="nav-item">
        <form id="header_search" class="form-inline my-2 my-lg-0" method="post" action="<?php echo base_url('main/search');?>">
        <input class="form-control mr-sm-2" type="search" name="text" id="text" placeholder="" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" id="" type="submit">بحث</button>
        </form>   
      </li>
    </ul>
    <ul class="navbar-nav" id="not_sign_header" style="display:none">
      <li class="nav-item">
        <a class="nav-item nav-link" id="login_nav" href="<?php echo base_url('main/login'); ?>">تسجيل دخول</a>
      </li>
          <li class="nav-item">
            <a class="nav-item nav-link" id="signup_nav" href="<?php echo base_url('main/signup'); ?>"> انشاء حساب</a>
          </li>
    </ul>
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-item nav-link" href="<?php echo base_url('main/user/').$this->session->userdata('user_id')*62488426;?>"><?php echo $this->session->userdata('username');?></a>
      </li>
      <li class="nav-item dropdown">
        <a id="notifi_box" class="nav-link dropdown-toggle" style="display:none" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">    
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php if(isset($nots)){foreach($nots as $not){ ?>
            <?php if($not->type=='accepted'){
            echo '<a class="dropdown-item" id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'> تم قبول اجابتك بواسطة'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
            }else if($not->type=='answered'){
            echo '<a class="dropdown-item" id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'> تمت الاجابة بواسطة  '.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
            }else if($not->type=='commented'){
              $not->section=$not->section*16;
            echo '<a class="dropdown-item" id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'> تم اضافة تعليع بواسطة'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
            }else if($not->type=='answer_commented'){
              $not->section=$not->section*17;
            echo '<a class="dropdown-item" id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'>تم اضافة تعليق علي اجابة بواسطة'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
            }else if($not->type=='question_voted'){
              $not->section=$not->section*17;
            echo '<a class="dropdown-item" id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'>تم التصويت علي سؤالك بواسطة'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
            }
          }
        }
          ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo base_url('main/user/').$this->session->userdata('user_id')*62488426;?>">عرض الكل </a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav" id="sign_out" style="display:none">
      <li class="nav-item">
        <a class="nav-item nav-link" href="<?php echo base_url('main/logout'); ?>">تسجيل خروج</a>
    </ul>
  </div>
</nav>

<?Php
function posted_since($time){
  $current = date('Y-m-d H:i:s', time());
  $new = strtotime($current) - strtotime($time);
  if($new < 60){
    if($new <= 10){
      $new.=" ثواني"; 
    }else{
      $new.=" ثانية";
    } 
  }

  else if($new < 3600){
     $new=(int)floor($new/60);
     if($new < 2){
      $new =" دقيقة";
     }
     else if($new <= 10){
      $new.=" دقايق"; 
   }else{
     $new.=" دقيقة";
   } 
  }

  else if($new < 86400){
     $new=(int)floor($new/3600);
     if($new < 2){
       $new =" ساعة";
      }
     else if($new <= 10 && $new > 1){
      $new.=" ساعات"; 
   }else{$new.=" ساعة";
   } 
  }

  else if($new < 2592000){
     $new=(int)floor($new/86400);
     if($new < 2){
      $new =" يوم";
     }
     else if($new <= 10){
      $new.=" ايام"; 
   }else{
     $new.=" يوم ";
   } 
  }

  else if($new < 3110400){
     $new=(int)floor($new/2592000);
     if($new < 2){
      $new =" شهر";
     }
     else if($new <= 10){
      $new.=" شهور"; 
   }else{
     $new.=" شهر"; 
   }
  }

  return $new;
}
?>
<script>
$(document).ready(function(){

  

  var usr = $('#user').text();
  if(usr == ""){
    $('#not_sign_header').css('display','block');
  }else{
    $('#sign_out').css('display','block');
  }
  $('#header_search').on('submit',function(e){
    if($('#text').val() < 1){
      alert('type something');
      return false;
    }

});


  $('.check_login').on('click',function(e){
    var usr = $('#user').text();
    if(usr == ""){
      $('#not_logged_msg').css('display','block');
      return false;
    }
  });
  $('.check_login').on('dblclick',function(e){
    var usr = $('#user').text();
    if(usr == ""){
      $('#not_logged_msg').css('display','block');
      return false;
    }
  });

  $('#close_not_logged_msg').on('click',function(e){
    $('#not_logged_msg').css('display','none');
  });

  var usrname = $("#username").text();
  if(usrname  != ""){
    $('#notifi_box').css('display','block');
  }
  $(document).mouseup(function(e) {
    var container = $("#not_logged_msg");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
       container.hide();
    }
});




if(window.location.href == "https://localhost/sudanoverflow.com/main/login"){
  $('#login_nav').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/signup"){
  $('#signup_nav').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/signup"){
  $('#signup_nav').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/ask"){
  $('#ask_top_nav').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/tags"){
  $('#tags_top_nav').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/users"){
  $('#users_top_nav').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/guide"){
  $('#guide_top_nav').css('color','#009bff');
}
if(window.location.href.match("https://localhost/sudanoverflow.com/main/tag",/\+./)){
  $('#tags_top_nav').css('color','#009bff');
}
if(window.location.href.match("https://localhost/sudanoverflow.com/main/home",/\+./)){
  $('#home_top_nav').css('color','#009bff');
}
if(window.location.href.match("https://localhost/sudanoverflow.com/main/user",/\+./)){
  $('#users_top_nav').css('color','#009bff');
}





if(window.location.href == "https://localhost/sudanoverflow.com/main/home/recent"){
  $('#recent').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/home"){
  $('#recent').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/home/most-votes"){
  $('#most_votes').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/home/most-answers"){
  $('#most_answers').css('color','#009bff');
}
if(window.location.href == "https://localhost/sudanoverflow.com/main/home/not-answered"){
  $('#no_answers').css('color','#009bff');;
}


if(window.location.href.match("/recent",/\+./)){
  $('#recent_tag').css('color','#009bff');
}
if(window.location.href.match("/most-votes",/\+./)){
  $('#most_votes_tag').css('color','#009bff');
}
if(window.location.href.match("/most-answers",/\+./)){
  $('#most_answers_tag').css('color','#009bff');
}
if(window.location.href.match("/not-answered",/\+./)){
  $('#no_answers_tag').css('color','#009bff');
}


if(window.location.href == "https://localhost/sudanoverflow.com/main/search"){
  $('#home_nav').css('display','none'); 
  $('#tag_nav').css('display','none'); 
}



$('body').on('click','#link',function(){
    var id = $(this).next().val();
    var url = $(this).attr('href');
   $.ajax({
       url:"<?php echo base_url();?>main/seen_link",
       method:"POST",
       dataType:"json",
       data:{id:id},
       async:false,
       success:function(response){
          if(response == "seen"){
            window.location = url;
            }
       }
   });
 }); 



});
</script>