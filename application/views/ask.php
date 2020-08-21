 <body style="margin: 0;"></body>
 <head>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/skin.min.css'>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/content.min.css'>
    <script src='<?= base_url() ?>js/tinymce.min.js'></script>
    <script src='<?= base_url() ?>js/theme.min.js'></script>
  </head>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <div class="form-group">
        <input type="text" name="question_title" id="question_title" class="form-control" placeholder="العنوان">
      </div>         
      <div class="form-group col-sm-3">
        <input type="text" id="question_tags" name="question_tags" class="form-control" placeholder="الاقسام">
        <div id="tags" style="background-color:whitesmoke"></div>
      </div>
      <div class="form-group col-sm-9">
        <div id="tag" name="tag" class="form-control"></div> 
      </div>
      <textarea id='question_editor' name="question_editor">محتوي السوال</textarea>
      <br><div id="preview"></div><br>
      <button id="add_question" name="add_question" class="btn btn-primary btn-lg btn-block check_login">اسال</button> <br>
      <div class="float-right" id="went_wrong" style="display:none">حدث خطأ ما حاول مرة اخري!</div>
      <div class="float-right" id="empty_feild" style="display:none">الرجاء ملئ كل الحقول!</div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    var insert_id = '';
    var tmp_tags = [];
$('#question_tags').keyup(function(e){
    if(e.which == 46 || e.which == 8 || e.which == 13){e.preventDefault();return false;}
    var tag = $(this).val().toUpperCase();
$.ajax({
    url:"<?php echo base_url(); ?>main/get_tags",
    method:"POST",
    data:{tag:tag},
    dataType: 'json',
    async:false,
    success:function(data){
        if(data.length>0){
            $('#tags').show();
            for(i=0;i<data.length;i++){  
                if(tmp_tags.includes(tag)){alert('already choosen');return}
                tmp_tags.push(tag);
                $('#tags').append("<span class='live_tag' id='"+data[i]['name']+"'>"+data[i]['name']+"</span><br>");
            console.log(tmp_tags);
            }
        }
    }
});
});
document.getElementById('tags').addEventListener('click', function(e) {
     if(e.target && e.target.nodeName == 'SPAN'){
         var tag = e.target.id;
        tag = "<span class='added_tag'><span>"+tag+"</span><span id='remove_tag_x'>x</span></span>";
        $('#tag').append(tag);
        $('#question_tags').val('');
        $('#tags').empty();
        $('#tags').hide();
        }}, false);
    $('body').on('click','#remove_tag_x',function(){
        this.parentElement.remove();
        var tag = $(this).parent().text();
        tag=tag.substring(0,tag.length -1);
        if(tmp_tags.includes(tag)){
            tmp_tags.splice(tmp_tags.indexOf(tag),1);
        }
        console.log(tmp_tags);
        console.log(tag);
    });
    
  $('body').on('click','#add_question',function(){
      var question_data =[];
      var question_tags = [];
      var question_content = tinyMCE.activeEditor.getContent();
      var question_title = $('#question_title').val();
      $('.added_tag').each(function(){
          var str = $(this).text();
          var tag = str.substring(0, str.length - 1);
          question_tags.push(tag); 
      });
      question_data.push(question_title,question_tags,question_content);
      if(!question_title || question_tags.length==0 || !question_content){
        $('#empty_feild').css('display','block');
        $("#empty_feild").delay(4000).hide(0);      
        return false;
        }
      $.ajax({
          url:"<?php echo base_url();?>main/add_question",
          method:'POST',
          dataType:'json',
          async:false,
          data:{question_data:question_data},
          success:function(reply){
             console.log(reply);
            if(reply != 'not'){
              window.location="<?php echo base_url('main/question/');?>"+reply*62488426;
            }else{
              $('#went_wrong').css('display','block');
              $("#went_wrong").delay(4000).hide(0);      
            }
          }
      });
  });  
    
  tinymce.init({
    selector: '#question_editor',
     setup:function(ed) {
       ed.on('keyup', function(e) {
           $('#preview').html(tinymce.activeEditor.getContent());
       });
   },
  plugins: "codesample", 
  toolbar: "codesample"
  });
});
  </script>
