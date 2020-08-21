<div class="container">
    <?php 
    $questions_count=array();
    $answers_count=array();
    foreach($tag_questions as $tag){
        array_push($questions_count,explode(",",$tag->tags));
    }
    foreach($tag_answers as $tag){
        array_push($answers_count,explode(",",$tag->tags));
    }
    $questions_count = array_count_values(array_merge(...$questions_count));
    $answers_count = array_count_values(array_merge(...$answers_count));
    ?>
     <div class="row">
        <?php foreach($tags as $tag):?>
        <div class="col-md-3 text-center">
            <a href="<?php echo base_url('main/tag/');echo $tag->name;?>" class="tag"><?php echo $tag->name;?></a>
            <span class="d-block">
                <span><?php if(isset($questions_count[$tag->name])){echo $questions_count[$tag->name];}else{echo '0 ';}?></span><span> سؤال </span>
            </span>
            <span class="d-block">
                <span><?php if(isset($answers_count[$tag->name])){echo $answers_count[$tag->name];}else{echo '0 ';}?></span><span> اجابة </span>
            </span>
        </div>
        <?php endforeach;?>
    </div>
</div>