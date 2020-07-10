<div class="container text-right">
    <div class="row">
        <div class="col-sm-10">
            <div class="col-sm-4">
                <img id="p_profile_pic" src="<?php echo base_url('images/profiles/').$user_info[0]->profile_pic;?>"> 
                <div style="text-align:center;margin-top:10px;">
                <span style="border: 1px solid #13878e;padding:4px;border-radius: 4px;">
                    <img id="p_points_icon" src="<?php echo base_url('images/point.svg');?>">
                    <div class="" id="p_points"><?php echo $user_info[0]->points;?></div>
                </span>
                </div>
            </div>
            <div class="col-sm-8">
                <h2 id="p_username"><?php echo $user_info[0]->full_name; ?></h2>
                <div>
                <img id="p_location_icon" src="<?php echo base_url('images/pin.svg');?>"><h5 id="p_location"><?php echo $user_info[0]->location; ?></h5>
                </div>
                <div>
                <img id="p_work_icon" src="<?php echo base_url('images/work.png');?>"><h5 id="p_job"><?php echo $user_info[0]->job; ?></h5>
                </div>
                <div>
                <img id="p_college_icon" src="<?php echo base_url('images/interface.png');?>"><h5 id="p_college"><?php echo $user_info[0]->college; ?></h5>
                </div>
                <br>
                <div id="p_bio" class="text-justify"><?php echo $user_info[0]->bio; ?></div>
                <div><a class="check_login" id="p_edit_profile" href="<?php echo base_url('main/edit_profile'); ?>">تعديل</a></div>
            </div>
        </div>
    </div>
    <!-- <?php echo "<pre>";print_r($user_activity);echo "<pre>";?> -->
    <br>
    <h5>اسئلة:</h5>
    <div class="row">
        <?php foreach($user_activity[0] as $question):?>
        <div class="col-md-10 p_activity_container">
            <span>
                <span class="votes_p_questions"><?php echo $question->votes;?></span>
                <a href="<?php echo base_url('main/question/').$question->id*62488426;?>"><?php echo $question->title;?></a> -
                <span class="votes_p_at"><?php echo "قبل ".posted_since($question->at);?></span>
            </span>
        </div>
        <?php endforeach;?>
    </div>
    <br>
    <h5>تعليقات علي اسئلة:</h5>
    <div class="row">
        <?php foreach($user_activity[1] as $question):?>
        <div class="col-md-10 p_activity_container">
            <span>
                <span class="votes_p_questions"><?php echo $question->votes;?></span>
                <a href="<?php echo base_url('main/question/').$question->id*62488426;echo "#".$question->comment_id*16;?>"><?php echo $question->title;?></a> -
                <span class="votes_p_at"><?php echo "قبل ".posted_since($question->at);?></span>
            </span>
        </div>
        <?php endforeach;?>
    </div>
    <br>
    <h5>تصويت علي اسئلة:</h5>
    <div class="row">
        <?php foreach($user_activity[2] as $question):?>
        <div class="col-md-10 p_activity_container">
            <span>
                <span class="votes_p_questions"><?php echo $question->votes;?></span>
                <a href="<?php echo base_url('main/question/').$question->id*62488426;?>"><?php echo $question->title;?></a> -
                <span class="votes_p_at"><?php echo "قبل ".posted_since($question->at);?></span>
            </span>
        </div>
        <?php endforeach;?>
    </div>
    <br>
    <h5>اجوبة:</h5>
    <div class="row">
        <?php foreach($user_activity[3] as $question):?>
        <div class="col-md-10 p_activity_container">
            <span>
                <span class="votes_p_questions"><?php echo $question->votes;?></span>
                <a href="<?php echo base_url('main/question/').$question->id*62488426;?>"><?php echo $question->title;?></a> -
                <span class="votes_p_at"><?php echo "قبل ".posted_since($question->at);?></span>
            </span>
        </div>
        <?php endforeach;?>
    </div>
    <br>
    <h5>تعليقات علي اجوبة:</h5>
    <div class="row">
        <?php foreach($user_activity[4] as $question):?>
        <div class="col-md-10 p_activity_container">
            <span>
                <span class="votes_p_questions"><?php echo $question->votes;?></span>
                <a href="<?php echo base_url('main/question/').$question->id*62488426;echo "#".$question->comment_id*17;?>"><?php echo $question->title;?></a> -
                <span class="votes_p_at"><?php echo "قبل ".posted_since($question->at);?></span>
            </span>
        </div>
        <?php endforeach;?>
    </div>
    <br>
    <h5>تصويت علي اجوبة:</h5>
    <div class="row">
        <?php foreach($user_activity[5] as $question):?>
        <div class="col-md-10 p_activity_container">
            <span>
                <span class="votes_p_questions"><?php echo $question->votes;?></span>
                <a href="<?php echo base_url('main/question/').$question->id*62488426;?>"><?php echo $question->title;?></a> -
                <span class="votes_p_at"><?php echo "قبل ".posted_since($question->at);?></span>
            </span>
        </div>
        <?php endforeach;?>
    </div>
</div>