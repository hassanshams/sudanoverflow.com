<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE HTML>
<html>
  <head>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/skin.min.css'>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/content.min.css'>
    <script src='<?= base_url() ?>js/tinymce.min.js'></script>
    <script src='<?= base_url() ?>js/theme.min.js'></script>
  </head>
<body>
<div style="display:none" id="q_id"><?php echo $q_id;?></div>
<div class="container">
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
            <textarea id='question_editor' name="question_editor"></textarea>
        <br><div id="preview"></div><br>
            <button type="submit" id="add_question" name="add_question" class="btn btn-primary btn-lg btn-block">تعديل</button> <br>
        <button type="submit" id="cancel_edit" name="cancel_edit" class="btn btn-primary btn-lg btn-block">الغاء</button><br>
    </div>
    </div>
<script>
$(document).ready(function(){
    var tmp_tags=[];
    var q_id = $('#q_id').text();
    var insert_id = '';
    get_pre_edit_question();
            console.log(tmp_tags);
$('#question_tags').keyup(function(e){
    if(e.which == 46 || e.which == 8 || e.which == 13){e.preventDefault();return false;}
    var tag = $(this).val().toUpperCase();
$.ajax({
    url:"<?php echo base_url(); ?>main/get_tags",
    method:"POST",
    data:{tag:tag},
    dataType: 'json',
    success:function(data){
        if(data.length>0){
            $('#tags').show();
            for(i=0;i<data.length;i++){   
                if(tmp_tags.includes(data[i]['name'])){alert('already choosen');return;}
                $('#tags').append("<span class='live_tag' id='"+data[i]['name']+"'>"+data[i]['name']+"</span><br>");
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
    });
    
  $('body').on('click','#add_question',function(){
      var question_data =[];
      var question_tags = [];
      var question_content = tinyMCE.activeEditor.getContent();
      var question_title = $('#question_title').val();
      var question_id = $('#q_id').text();
      $('.added_tag').each(function(){
          var str = $(this).text();
          var tag = str.substring(0, str.length - 1);
          question_tags.push(tag); 
      });
      question_data.push(question_title,question_tags,question_content,question_id);
      if(!question_title || question_tags.length==0 || !question_content){alert('fill all required felids bitch');return;}
      $.ajax({
          url:"<?php echo base_url();?>main/add_edited_question",
          method:'POST',
          dataType:'json',
          async:false,
          data:{question_data:question_data},
          success:function(reply){
              window.location="<?php echo base_url('main/question/');?>"+reply*62488426;
          }
      });
  });  
$('body').on('click','#cancel_edit',function(){
    window.location="<?php echo base_url('main/question/');?>"+q_id*62488426;
});
function get_pre_edit_question(){
    var tags ='';
   $.ajax({
    url:"<?php echo base_url(); ?>main/get_pre_edit_question",
    method:"POST",
    data:{q_id:q_id},
    dataType:'json',
    success:function(data){
        tags = data['tags'].split(" ");
        for(var i = 0; i < tags.length; i++){
            tag = "<span class='added_tag'><span>"+tags[i]+"</span><span id='remove_tag_x'>x</span></span>";
            $('#tag').append(tag);
            tmp_tags.push(tags[i]);
        }
        var title = data['title'];
        $('#question_title').val(title);
        var body = data['body'] ;
        tinymce.activeEditor.execCommand('mceInsertContent', false,body);
        
    }
});   
}    
    
    
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
</body>
</html>