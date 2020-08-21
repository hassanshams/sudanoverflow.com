<div>
</div>
<!DOCTYPE HTML>
<html>  
<head>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/skin.min.css'>
    <link rel='stylesheet' href='<?php echo base_url() ; ?>/style/content.min.css'>
    <script src='<?= base_url() ?>js/tinymce.min.js'></script>
    <script src='<?= base_url() ?>js/theme.min.js'></script>
  </head>
<body style="margin:0">
<div style="display:none" id="q_id"><?php echo $question->id;?></div> 
<div style="display:none" id="q_tags"><?php echo $question->tags;?></div>
<div class="container">
    <div style="display:none" id="q_id"><?php echo $question->id;?></div> 
    <div style="display:none" id="q_tags"><?php echo $question->tags;?></div>
    <div class="row">
        <div class="col-md-1 col-xs-1">
            <div>
                <img id="vote_up_arrow" class="check_login" src="<?php echo base_url('images/angle-up.svg');?>">
                <span id="q_votes_counter"><?php echo $question->votes; ?></span>
                <img id="vote_down_arrow" class="check_login" src="<?php echo base_url('images/angle-down-solid.svg');?>">
            </div>
        </div>
        <div class="col-md-11 col-xs-11">
            <h3 class="text-right"><?php echo $question->title;?></h3> 
            <br>
            <div style="direction: ltr;"><?php echo $question->body;?></div>
            <div id="q_question_tags" class="text-right">
                    <?php $tags=explode(',',$question->tags);
                    $url=base_url('main/tag/');
                    foreach($tags as $tag){
                        echo "<a class='tag' href='$url$tag'> $tag</a>";
                    }?>
            </div>
            <div class="row">
                    <div class="col-md-12 text-right" style="margin-bottom: 15px;">
                    بواسطة <a href="<?php echo base_url('main/user/').$question->asker_id*62488426;?>"><?php echo $question->asker_username;?></a>
                    <span style="display:inline-block">- <?php echo "قبل ".posted_since($question->at);?></span>
                        <div id="edit_and_delete" style="display:none;">
                            <span><input type="hidden" value="<?php echo $question->asker;?>">
                            <a class="check_login" id="edit_question" href="<?php echo base_url('main/edit_question/') ?><?php echo $question->id*62488426;?>"> - تعديل</a></span>
                            <input type="hidden" id="q_owner" value="<?php echo $question->asker;?>">
                            <span id="delete_question" class="on_hover check_login">مسح</span>
                        </div>
                        <!-- <span id="edited_at"><?php echo $question->edited_at;?></span> -->
                    </div>
                    <div class="col-md-12 text-right">
                        <div id="comment_and_answer">
                            <span id="comment" class="on_hover check_login">اضف تعليق</span>
                            <input type="hidden" id="qu_owner" value="<?php echo $question->asker;?>">
                        </div>
                        <div id="add_comment_area" style="margin-top:10px">
                            <input class="form-control col-md-3" type="text" id="comment_input">
                            <button class="btn btn-primary col-md-1 check_login" id="submit_comment">اضف</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php foreach($comments as $comment):?>
                        <div id="<?php echo $comment->id*16;?>" class="text-right comment_row">
                            <a id="commenter" href="<?php echo base_url('main/user/');echo $comment->commentor_id;?>"><?php echo $comment->commentor_username;?></a> -
                            <span id="comment_body"><?php echo $comment->comment;?></span>
                            <span id="comment_time" style="display:inline-block">- <?php echo "قبل ".posted_since($comment->at);?></span>
                            <input type="hidden" value="<?php echo $comment->commentor;?>">
                            <span id="delete_comment" style="display:none" class="on_hover check_login">مسح</span>
                            <input type="hidden" class="comment_id" value="<?php echo $comment->id;?>">
                            <input type="hidden" value="<?php echo $comment->commentor;?>">
                            <div class="" id="delete_comment_went_wrong" style="display:none;margin-right: 10px;color:red">حدث خطأ ما حاول مرة اخري!</div> 
                        </div>
                        <?php endforeach; ?>
                    </div>
            </div>
       </div>
    </div>
    <br><br>
        <h3 class="text-right">اجوبة: <span><?php echo sizeof($answers);?></span></h3>
        <?php foreach($answers as $answer):?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1 col-xs-1">
                <input type="hidden" value="<?php echo $answer->answerer;?>">
                   <img id="answer_vote_up_arrow" class="check_login" src="<?php echo base_url('images/angle-up.svg');?>">
                   <span id="answer_votes_counter"><?php echo $answer->votes;?></span>
                   <input type="hidden" value="<?php echo $answer->id;?>">
                   <img id="answer_vote_down_arrow" class="check_login" src="<?php echo base_url('images/angle-down-solid.svg');?>">
                   <input type="hidden" value="<?php echo $question->asker;?>">
                   <img class="accept_answer_check check_login" style="display:none" src="<?php echo base_url('images/check.svg');?>">
                   <?php $answered = $answer->accepted;
                   if($answered == 1){echo "<input type='hidden' class='accepted_answer' value='".$answered."'>";}
                   ?>  
            </div>
            <div class="col-md-9 col-xs-8">
                <div><?php echo $answer->body;?></div>
                <div class="row text-right" style="margin-bottom: 15px;">
                    بواسطة <a class="mr-md-2 ml-md-2" href="<?php echo base_url('main/user/').$answer->answerer_id*62488426;?>"><?php echo $answer->answerer_username;?></a> - 
                    <span class="mr-md-2"><?php echo " قبل ".posted_since($answer->at);?></span> 
                    <input type="hidden" value="<?php echo $answer->answerer;?>">  
                    <span class="delete_answer mr-md-2 on_hover check_login" style="display:none"> - مسح</span> 
                    <input type="hidden" value="<?php echo $answer->id;?>">
                    <div class="float-right" id="delete_answer_went_wrong" style="display:none;margin-right: 10px;color:red">حدث خطأ ما حاول مرة اخري!</div> 
                </div>
                <div class="row text-right">
                    <span class="on_hover check_login" id="answer_comment_button">اضف تعليق</span>
                </div>   
                <div class="row" id="answer_comment_area" style="display:none">
                    <input type="hidden" value="<?php echo $answer->answerer;?>">
                    <input type="text" id="answer_comment_text">
                    <input class="form-control col-md-3" type="hidden" value="<?php echo $answer->id;?>">
                    <button class="btn btn-primary col-md-1 check_login" id="submit_answer_comment">اضف</button>
                </div>
            <input type="hidden" value="<?php echo $answer->id;?>">
            <div id="" class="text-right answer_comments">
                <?php foreach($answer_comments as $comment):?>
                <div id="<?php echo $comment->id*16;?>" class="text-right comment_row">
                    <a id="answer_commenter" href="<?php echo base_url('main/user/');echo $comment->commentor_id;?>"><?php echo $comment->commentor_username;?></a> -
                    <span id="answer_comment_body"><?php echo $comment->comment;?></span>
                    <span id="answer_comment_time" style="display:inline-block">- <?php echo "قبل ".posted_since($comment->at);?></span>
                    <input type="hidden" value="<?php echo $comment->commentor;?>">
                    <span class="delete_answer_comment on_hover check_login" style="display:none">مسح</span>
                    <input type="hidden" class="comment_id" value="<?php echo $comment->id;?>">
                    <input type="hidden" value="<?php echo $comment->commentor;?>">
                    <input type="hidden" value="<?php echo $comment->answer_id;?>">
                    <div class="" id="delete_answer_comment_went_wrong" style="display:none;margin-right: 10px;color:red">حدث خطأ ما حاول مرة اخري!</div> 
                </div>
                <?php endforeach; ?>
            </div>
            <br><br>
        </div>
    </div>
    <?php endforeach;?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-9">
            <textarea id="answer_textarea"></textarea><br>
            <button id="answer_button" class="btn btn-primary btn-lg btn-block check_login">جاوب</button>
            <div class="float-right" id="went_wrong" style="display:none;margin-top: 10px;">حدث خطأ ما حاول مرة اخري!</div>
            <div class="float-right" id="empty_feild" style="display:none;margin-top: 10px;">الرجاء اضافة اجابة</div>
        </div>
    </div>
</div> 
</body>
</html>
<script>
$(document).ready(function(){
var qu_owner = $('#qu_owner').val();
var user  = $('#user').text(); 
var q_id  = $('#q_id').text();
var voted = '';
var answered = '';
var owner = '';
var data  = [];
var views_count=0;
var a_insert_id = 0;
// load_votes();
show_q_edit_delete();
show_accepted_check_icon();
//////////////////////comment start
$("body").on("click","#comment",function(){
    $('#add_comment_area').toggle();
});
$("body").on("click","#submit_comment",function(){
    if($('#comment_input').val().length!=""){
        var data=[];
        var comment = $('#comment_input').val()
        data.push(q_id);
        data.push(comment);
        data.push(qu_owner);
        $.ajax({
            url:"<?php echo base_url();?>main/add_comment",
            method:'POST',
            dataType:'json',
            async:false,
            data:{data:data},
            success:function(result){
             if(result == "commented"){
                 location.reload();
                 }else{
                     alert('something went wrong');
                 }
            }
         });
        }
        else{alert('something went wrong!');}
    });
    function check_comment_owner(comment_id){
    $.ajax({
        url:"<?php echo base_url();?>main/check_comment_owner",
        method:'POST',
        dataType:'json',
        data:{comment_id:comment_id},
        async:false,
        success:function(response){
            owner = response;
        }
 }); 
    return owner;
 }   
$('.comment_id').each(function(){
        var c_owner = $(this).next().val();
        if(c_owner == user){
            $(this).prev().css('display','inline-block');
        }
    });
    function delete_comment(comment_id,q_id){
       $.ajax({
            url:"<?php echo base_url();?>main/delete_comment",
            method:'POST',
            dataType:'json',
            data:{comment_id:comment_id},
            async:false,
            success:function(response){
                if(response == 'not'){
                    $('#delete_comment_went_wrong').css('display','block');
                    $("#delete_comment_went_wrong").delay(4000).hide(0);
                }else{
                    location.reload();
                }
            }
        });  
    }
    $('body').on('dblclick','#delete_comment',function(){
        var id = $(this).next().val();
        var q_id = $('#q_id');
        var c_owner = $(this).prev().val();
        if(c_owner != user){alert('not urs to delete');return;}
        delete_comment(id,q_id);
        // location.reload();
        owner = '';
    });
//////////////////////comment end
    
///////////////////////question start
$('body').on("dblclick","#delete_question",function(){
    var q_owner = $(this).prev().val();
    if(q_owner != user){alert('not urs to delete');return;}
    delete_question();
    // alert('deleted');
    // window.location="<?php echo base_url('main/home');?>";
});
$('body').on('click','#edit_question',function(e){
     var q_owner = $(this).prev().val();
    if(q_owner != user){alert('not urs to edit');e.preventDefault();}
    owner='';
});
function show_q_edit_delete(){
    var q_owner = $('#q_owner').val();
    if(q_owner == user){ 
        $('#add_answer').hide();
        $('#edit_and_delete').show();$('#edit_and_delete').css('display','inline-block');
        $('#answer_textarea').hide();
        $('#answer_button').hide();
        show_accept_check_icon();
    }
    else if(owner == 'not'){
        $('#add_answer').show();
        $('#edit_and_delete').hide();
    }
    owner='';
}
function check_if_owner(){
 $.ajax({
    url:"<?php echo base_url();?>main/if_q_owner",
    method:'POST',
    dataType:'json',
    data:{q_id:q_id},
    async:false,
    success:function(response){
        owner = response;
    }
});    
     return owner;
} 

function delete_question(){
 $.ajax({
    url:"<?php echo base_url();?>main/delete_question",
    method:'POST',
    dataType:'json',
    data:{q_id:q_id},
    async:false,
    success:function(response){console.log(response);
        if(response = 'deleted'){
            window.location = '<?php echo base_url("main/home");?>';
        }else{
            alert('something went wrong');
        }
    }
});
}   
///////////////////////question end    
    
        
////////   voting strat
$('body').on("click",'#vote_up_arrow',function(){   
    check_if_owner();
    if(owner == 'owner'){alert('cant vote ur own question');return;}
    owner='';
    has_voted();
    if(voted == 'voted'){alert('already voted!');return;}
    else if(voted == 'not voted'){
        add_vote(1);
        // load_votes();
    }  
});
$('body').on("click",'#vote_down_arrow',function(){
    check_if_owner();
    if(owner == 'owner'){alert('cant vote ur own question');return;}
    owner='';
    has_voted();
    if(voted == 'voted'){alert('already voted!');return;}
    else if(voted == 'not voted'){
        add_vote(-1,);
        // load_votes();
    }  
});
////////      voting end
  
    
    
    
//VOTING FUNCTIONS START
// function load_votes(){
//  $.ajax({
//     url:"<?php echo base_url();?>main/load_votes",
//     method:'POST',
//     dataType:'json',
//     data:{q_id:q_id},
//     success:function(response){
//         document.getElementById('q_votes_counter').innerHTML=response['votes'];
//     }
// });
// }
    
function has_voted(){
 $.ajax({
    url:"<?php echo base_url();?>main/has_voted",
    method:'POST',
    dataType:'json',
    data:{q_id:q_id},
    async:false,
    success:function(response){
        voted=response;
    }
});
    return voted;
}
function add_vote(x){
    data.push(q_id);
    data.push(x);
    data.push(qu_owner);
 $.ajax({
    url:"<?php echo base_url();?>main/add_vote",
    method:'POST',
    dataType:'json',
    data:{data:data},
    async:false,
    success:function(response){
        if(response == "not"){
            alert("something went wrong");
        }
    }
});
}
//VOTING FUNCTIONS END
 

/////////////////ADD ANSWER START
$('.delete_answer').each(function(){
    var a_owner = $(this).prev().val();
    if(a_owner == user){$(this).css('display','block');}
});
function check_user_answered(){
 $.ajax({
    url:"<?php echo base_url();?>main/check_user_answered",
    method:'POST',
    dataType:'json',
    data:{q_id:q_id},
    async:false,
    success:function(response){
        answered = response;
    }
});    
     return answered;    
}    
function add_answer(){
    var answer_data=[];
    var tags = $('#q_tags').text();
    var answer_body = tinyMCE.get('answer_textarea').getContent();
    answer_data.push(q_id);
    answer_data.push(answer_body);
    answer_data.push(tags);
    answer_data.push(qu_owner);
    $.ajax({
        url:"<?php echo base_url();?>main/add_answer",
        method:'POST',
        dataType:'json',
        data:{answer_data:answer_data},
        async:false,
        success:function(response){
            if(response = 'true'){
                location.reload();
            }else{
                $('#went_wrong').css('display','block');
                $("#went_wrong").delay(4000).hide(0);
            }
        }
});
}    
function delete_answer(id,q_id){
    data.push(id);
    data.push(q_id);
 $.ajax({
    url:"<?php echo base_url();?>main/delete_answer",
    method:'POST',
    dataType:'json',
    data:{data:data},
    async:false,
    success:function(response){
        if(response == 'deleted'){
                location.reload();
            }else{
                $('#delete_answer_went_wrong').css('display','block');
                $("#delete_answer_went_wrong").delay(4000).hide(0);
            }
    }
});    
}
$('body').on("click","#answer_button",function(){    
if(!tinyMCE.get('answer_textarea').getContent()){
    $('#empty_feild').css('display','block');
    $("#empty_feild").delay(4000).hide(0);
    return;
    }
check_user_answered();
if(answered == 'answered'){alert('already answered');return;}
answered='';
add_answer();
}); 
$('body').on('dblclick','.delete_answer',function(){
    var id = $(this).next().val();
    if(user == ""){
        not_logged_in();
        return;
    }
    var a_owner = $(this).prev().val();
    if(a_owner != user){alert('not ur answer');return;}
    owner='';
    delete_answer(id,q_id);
//    location.reload();
});
/////////////////ADD ANSWER END
    
/////////////////////////answer comment start
$('body').on('click','#answer_comment_button',function(){
    $('#answer_comment_area').toggle();
});
$("body").on("click","#submit_answer_comment",function(){
    var comment = $(this).prev().prev().val(); 
    var a_owner = $(this).prev().prev().prev().val(); 
    if(comment.length!=""){
        var answer_id = $(this).prev().val();
        var comment_and_id=[];
        data.push(q_id);
        data.push(comment);
        data.push(answer_id);
        data.push(a_owner);
        data.push(qu_owner);
        $.ajax({
            url:"<?php echo base_url();?>main/add_answer_comment",
            method:'POST',
            dataType:'json',
            async:false,
            data:{data:data},
            success:function(data){console.log(data);
            //  if(data == "added"){
            //      location.reload();
            //     }else{
            //         alert('something went wrong');
            //     }
            }
        });
    }
    else{alert('write something!');}
});
$('body').on('dblclick','.delete_answer_comment',function(){
    var comment_id = $(this).next().val();
    var c_owner = $(this).next().next().val();
    var answer_id = $(this).next().next().next().val();
    if(c_owner != user){alert('not ur comment');return;}
    delete_answer_comment(comment_id,answer_id);
});
    function delete_answer_comment(comment_id,answer_id){
    data.push(answer_id);
    data.push(comment_id);
 $.ajax({
    url:"<?php echo base_url();?>main/delete_answer_comment",
    method:'POST',
    dataType:'json',
    data:{data:data},
    async:false,
    success:function(response){
        if(response == "deleted"){
            location.reload();
            }else{
                $('#delete_answer_comment_went_wrong').css('display','block');
                $("#delete_answer_comment_went_wrong").delay(4000).hide(0);      
            }
        }
});    
}
var comment = [];
// function load_answer_comments(answer_id){
//         $.ajax({
//             url:"<?php echo base_url();?>main/get_answer_comments",
//             method:'POST',
//             dataType:'json',
//             async:false,
//             data:{answer_id:answer_id},
//             success:function(data){
//                  comment = data;
//             }
//         });
//     return comment;
// }
function check_answer_comment_owner(comment_id){
 $.ajax({
    url:"<?php echo base_url();?>main/if_answer_comment_owner",
    method:'POST',
    dataType:'json',
    data:{comment_id:comment_id},
    async:false,
    success:function(response){
        owner = response;
    }
});    
     return owner;
}
// $('.answer_comments').each(function(){
//     var id = $(this).prev().val();
//     var comment = load_answer_comments(id);
//     for(x=0;x<comment.length;x++){
//        $(this).append("<div id='"+comment[x]['id']*17+"'><span>"+comment[x]['at']+"</span><span>"+comment[x]['commentor']+"</span><span>"+comment[x]['comment']+"</span><span class='delete_answer_comment' style='display:none'>مسح</span><input type='hidden' value='"+comment[x]['id']+"'><input type='hidden' value='"+comment[x]['answer_id']+"'></div><br>");
//     }
// });
$('.delete_answer_comment').each(function(){
    var c_owner = $(this).prev().prev().text();
    if(c_owner == user){$(this).css('display','inline-block');}
});

/////////////////////////answer comment end

    
///////////////////answer voting functions start
function check_answer_owner(answer_id){
 $.ajax({
    url:"<?php echo base_url();?>main/if_answer_owner",
    method:'POST',
    dataType:'json',
    data:{answer_id:answer_id},
    async:false,
    success:function(response){
        owner = response;
    }
});    
     return owner;
}
function check_user_voted_answer(answer_id){
 $.ajax({
    url:"<?php echo base_url();?>main/check_user_voted_answer",
    method:'POST',
    dataType:'json',
    data:{answer_id:answer_id},
    async:false,
    success:function(response){
        voted = response;
    }
});    
     return voted;    
}
function answer_update_votes(answer_data){
 $.ajax({
    url:"<?php echo base_url();?>main/answer_update_votes",
    method:'POST',
    dataType:'json',
    data:{answer_data:answer_data},
    async:false,
    success:function(response){
        if(response == 'ok'){
            location.reload();
        }else{
            alert('something went wrong');
        }

    }
});
}
///////////////////answer voting functions end   
    
    
////////////////////answer voting start
$('body').on('click','#answer_vote_up_arrow',function(){
    var answer_id = $(this).next().next().val();
    var answerer= $(this).prev().val();
    check_answer_owner(answer_id);
    if(owner == 'owner'){alert('cant vote ur own answer');return;}
    owner='';
    check_user_voted_answer(answer_id);
    if(voted == 'voted'){alert('already voted!');return;}
    var answer_data=[];
    var vote = 1;
    answer_data.push(answer_id);
    answer_data.push(1);
    answer_data.push(q_id);
    answer_data.push(answerer);
    answer_update_votes(answer_data);
    // location.reload();
});
$('body').on('click','#answer_vote_down_arrow',function(){
    var answer_id = $(this).prev().val();
    var answerer = $(this).prev().prev().val();
    if(user == ""){
        not_logged_in();
        return;
    }
    check_answer_owner(answer_id);
    if(owner == 'owner'){alert('cant vote ur own answer');return;}
    owner='';
    check_user_voted_answer(answer_id);
    if(voted == 'voted'){alert('already voted!');return;}
    var answer_data=[];
    var vote = -1;
    answer_data.push(answer_id);
    answer_data.push(-1);
    answer_data.push(q_id);
    answer_data.push(answerer);
    answer_update_votes(answer_data);
    // location.reload();
});
////////////////////answer voting end 
    
    
    
////////////////////accept answer start
function show_accept_check_icon(){
    $('.accept_answer_check').each(function(){
        $(this).css('display','block');
    });
}
function show_accepted_check_icon(){
    $('.accepted_answer').each(function(){
        $(this).prev().css('display','block');
        $(this).prev().attr("src","<?php echo base_url('images/checked.svg');?>");
        $(this).prev().attr("class","accepted_answer_check");
    });
}
function accept_answer(data){
 $.ajax({
    url:"<?php echo base_url();?>main/accept_answer",
    method:'POST',
    dataType:'json',
    async:false,
    data:{data:data},
    success:function(response){
    }
});
}
$('body').on('click','.accept_answer_check',function(){
    var q_owner = $(this).prev().val()
    if(q_owner != user){alert('not urs to accept');return;}
    var answer_id = $(this).prev().prev().prev().val();
    var answerer = $(this).prev().prev().prev().prev().val();
    var data=[];
    data.push(answer_id);
    data.push(answerer);
    data.push(q_id);
    accept_answer(data);
    location.reload();
});
$('.accepted_answer').each(function(){
    $(this).prev().css('color','red');
});
////////////////////accept answer end
tinymce.init({
  selector: '#answer_textarea',
  plugins: "codesample", 
  toolbar: "codesample",
  width: '100%'
});    
    
});
</script>