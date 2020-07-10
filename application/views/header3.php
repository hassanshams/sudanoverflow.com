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
    <script src="https://kit.fontawesome.com/1b58859525.js" crossorigin="anonymous"></script>
	<meta charset="utf-8">
        <title></title>
    <div style="display:none" id="user"><?php echo $this->session->userdata('user');?></div>
 </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img id="logo" src="<?php echo base_url('images/logo.png');?>"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="<?php echo base_url('main/home'); ?>" id="bord_bott">الرئيسية</a>
      <a class="nav-item nav-link" href="<?php echo base_url('main/ask'); ?>">اسال</a>
      <img id="inbox_img" class="user_lnks" src="<?php echo base_url('images/inbox.png'); ?>">
      <a class="nav-item nav-link" href="<?php echo base_url('main/profile'); ?>"><?php echo $this->session->userdata('user');?></a>
      <a class="nav-item nav-link" href="<?php echo base_url('main/signout'); ?>">تسجيل خروج</a>
    </div>
  </div>
</nav>
    
<div id="not_logged_in">عفوا! يرجي تسجبل الدخول او انشء حساب</div>
<div id="inbox" style="display:none">
    <?php foreach($nots as $not): ?>
    <?php if($not->type=='accepted'){
     echo '<a id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'>accepted by'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
    }if($not->type=='answered'){
     echo '<a id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'>answered by'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
    }else if($not->type=='commented'){$not->section=$not->section*16;
     echo '<a id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'>comment by'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
    }else if($not->type=='answer_commented'){$not->section=$not->section*17;
     echo '<a id="link" href='.base_url('main/question/').$not->link_.'#'.$not->section.'>answer comment by'.' '.$not->from_.'</a>'.'<input type="hidden" value='.$not->id.'>';
    }
    ?>
    <?php endforeach;?>
</div>
<script>
$(document).ready(function(){        
$('body').on('click','#inbox_img',function(){
   $('#inbox').toggle();
 });
$('body').on('click','#link',function(){
    var id = $(this).next().val();
   $.ajax({
       url:"<?php echo base_url();?>main/seen_link",
       method:"POST",
       dataType:"json",
       data:{id:id},
       success:function(response){
//           if(response){location.reload();}
       }
   });
 }); 
});
</script>
    </body>
</html>



