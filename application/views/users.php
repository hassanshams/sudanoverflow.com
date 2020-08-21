<div class="container"> 
    <div class="row">
        <div class="col-md-8">
            <div id="users_navs" class="text-center">
                <a class="top_nav_link" id="recent_tag" href="<?php echo base_url('main/users/recent');?>">مؤخرا</a>
                <a class="top_nav_link" id="most_votes_tag" href="<?php echo base_url('main/users/most-votes');?>">اكثر نقاطا</a>
            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
     <div class="row">
        <?php foreach($users as $user):?>
        <div class="col-md-3 col-xs-4 text-center">
            <img class="users_pics" src="<?php echo base_url('images/profiles/').$user->profile_pic;?>">
            <a class="users_names" href="<?php echo base_url('main/user/');echo $user->id*62488426;?>"><?php echo $user->username;?></a>
            <span class="d-block">
                <span class="users_points"><?php echo $user->points?></span><span> نقطة </span>
        </span>
        </div>
        <?php endforeach;?>
    </div>
</div>