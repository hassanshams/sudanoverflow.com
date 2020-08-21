<div class="container">
    <div class="row">
        <div class="col-md-8" style="border-bottom:1px solid #e8e8e8;">
            <div id="home_nav" class="text-center" >
                <a class="top_nav_link" id="recent" href="<?php echo base_url('main/home/recent');?>">مؤخرا</a>
                <a class="top_nav_link" id="most_votes" href="<?php echo base_url('main/home/most-votes');?>">اكثر تصويت</a>
                <a class="top_nav_link" id="most_answers" href="<?php echo base_url('main/home/most-answers');?>">اكثر اجابات</a>
                <a class="top_nav_link" id="no_answers" href="<?php echo base_url('main/home/not-answered');?>">بدون اجابات</a>
            </div>
            <div id="tagged_nav" class="text-center" >
                <a class="top_nav_link" id="recent_tag" href="<?php if(isset($tag)){echo base_url('main/tag/').$tag.'/recent';}?>">مؤخرا</a>
                <a class="top_nav_link" id="most_votes_tag" href="<?php if(isset($tag)){echo base_url('main/tag/').$tag.'/most-votes';}?>">اكثر تصويت</a>
                <a class="top_nav_link" id="most_answers_tag" href="<?php if(isset($tag)){echo base_url('main/tag/').$tag.'/most-answers';}?>">اكثر اجابات</a>
                <a class="top_nav_link" id="no_answers_tag" href="<?php if(isset($tag)){echo base_url('main/tag/').$tag.'/not-answered';}?>">بدون اجابات</a>
            </div>
            <br>
            <br>
            <h4 id="tagged_head" class="text-right">قسم: <span><?php echo @$tag;?></span></h4>
            <?php if(isset($searched_text)){
                echo "<h4 id='serached_head' class='text-right'>نتائج البحث عن: <span>"."'".$searched_text."'"."</span></h4>";
            }
            ?>
            <br>
            <?php if(sizeof($questions) == 0){echo "<div class='text-center'>"."لا توجد نتائج"."</div>";}?>        
            <?php foreach($questions as $question):?>
            <div class="row question">
                <div class="col-md-2 col-xs-2">
                    <div class="row">
                        <div class="col-md-4 col-xs-4 text-center"><?php echo $question->votes;?></div>
                        <div class="col-md-8 col-xs-8 text-right">صوت</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 text-center"><?php echo $question->views;?></div>
                        <div class="col-md-8 col-xs-8 text-right">مشاهدة</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-4 text-center"><?php echo $question->answers;?></div>
                        <div class="col-md-8 col-xs-8 text-right">جواب</div>
                    </div>
                </div>
                <div class="col-md-10 col-xs-10 text-right">
                    <div style="margin-bottom: 10px;">
                        <a id="q_title_style" href='<?php echo base_url('main/question/') ?><?php echo $question->id*62488426;?>'><?php echo $question->title;?></a>
                    </div>
                    <div>
                    <?php $tags=explode(',',$question->tags);
                    $url=base_url('main/tag/');
                    foreach($tags as $tag){
                        echo "<a class='tag' href='$url$tag'> $tag</a>"." ";
                    }?>
                    </div>
                    <div style="display:inline-block"><a href="<?php echo base_url('main/user/') ?><?php echo $question->asker_id*62488426;?>"><?php echo $question->asker_username;?></a></div>
                    <div style="display:inline-block"><span>- <?php echo "قبل ".posted_since($question->at);?></span></div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>






<br>
<br>
<br>
<br>
<br>



<!-- 
<div class="container">
    <div class="col-md-8">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item ">
                <a class="nav-link" href="<?php echo base_url('main/home/recent');?>">مؤخرا</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('main/home/most-votes');?>">أكثر أصواتا</a>
              </li>
            </ul>
          </div>
        </nav>
            <?php foreach($questions as $question):?>
        <div id="questions_view" class="row">
            <div class="col-sm-2" id="votes_and_stuff">
                <div class="row" id="votes">
                    <span id="votes_count"><?php echo $question->votes;?></span>
                    <span id="votes_label">صوت</span>
                </div>
                <div class="row" id="views">
                    <span id="views_count"><?php echo $question->views;?></span>
                    <span id="views_label">مشاهدة</span>
                </div>
                <div class="row" id="answers">
                    <input type="hidden" value="<?php echo $question->id;?>">
                    <span class="answers_count"></span>
                    <span id="answers_label">جواب</span>
                </div>
            </div>
            <div class="col-sm-10" id="question_view">
                <div id="question_view_title" class="row"><a id="q_title_style" href='<?php echo base_url('main/question/') ?><?php echo $question->id*62488426;?>'><?php echo $question->title;?></a></div>
<!--            <div id="q_body" class="row"><div id="question_view_content"><?php echo $question->body;?></div></div>-->
    <!--       <div id="question_view_tag" class="row">
               <?php $tags=explode(',',$question->tags);
                $url=base_url('main/tag/');
                foreach($tags as $tag){
                    echo "<a class='tag_style' href='$url$tag'> $tag</a>";
                }?>
                </div>
                <div class="row">
                <a id="q_question_tags" href="<?php echo base_url('main/user/') ?><?php echo $question->asker_id*62488426;?>"><?php echo $question->asker;?></a>
                </div>
            </div>
        </div>
            <?php endforeach;?>
    </div>
</div> -->
<script>
$(document).ready(function(){
    var answers_count=0;
    $('.answers_count').each(function(){
        var id = $(this).prev().val();
        var count = get_answers_count(id);
        $(this).text(count);
    });
function get_answers_count(id){
 $.ajax({
    url:"<?php echo base_url();?>main/get_answers_count",
    method:'POST',
    dataType:'json',
    data:{id:id},
    async:false,
    success:function(response){
        answers_count = response;
    }
 });
     return answers_count;
}
var tag_url = "https://localhost/sudanoverflow.com/main/tag/";
if(window.location.href.match(tag_url,/.+/)){
    $('#home_nav').css('display','none');
}else{
    $('#tagged_nav').css('display','none');
    $('#tagged_head').css('display','none');
}
});
</script>




