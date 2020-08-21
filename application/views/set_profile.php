<div class="container">
    <div class="col-md-10">
        <form enctype="multipart/form-data" method="post" id="profile_form">
        <div class="form-group col-sm-7">
        <input type="file" name="profile_pic" id="profile_pic" class="form-control" placeholder="">
        <input type="hidden" id="profile_pic_name">
        </div>
        <div class="form-group col-sm-5"><img id="loaded_pic"></div>
        <div class="form-group col-sm-7">
        <input type="submit" name="" id="" value="تحميل" class="form-control" placeholder="">
        </div>
        </form>
        <div>
            <div class="form-group">
            <input type="text" name="location" id="location" class="form-control" placeholder="السكن">
            </div>
            <div class="form-group">
            <input type="text" name="job" id="job" class="form-control" placeholder="المهنة">
            </div>
            <div class="form-group">
            <input type="text" name="college" id="college" class="form-control" placeholder="الجامعة">
            </div>
            <div class="form-group">
            <input type="text" name="bio" id="bio" class="form-control" placeholder="عن نفسك">
            </div>
            <div class="form-group">
            <button type="submit" id="submit_profile" name="submit_profile" class="btn btn-primary btn-lg btn-block">حفظ</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('body').on('click','#submit_profile',function(){
        var pic = $('#profile_pic_name').val();
        var _location = $('#location').val();
        var job = $('#job').val();
        var college = $('#college').val();
        var bio = $('#bio').val();
        if(_location == '' || college=='' || job==''){alert('fill all feilds');return;}
        if(pic == ''){alert('select an image');return;}
        var data=[];
        data.push(pic);
        data.push(_location);
        data.push(job);
        data.push(college);
        data.push(bio);
        $.ajax({
            url:"<?php echo base_url();?>main/insert_profile_data",
            method:"POST",
            dataType:'json',
            data:{data:data},
            success:function(response){
            }
         });
        });
        $('#profile_form').on('submit',function(e){
            e.preventDefault();
            if($('#profile_pic').val() == ''){alert('select image!');}
            else{
                $.ajax({
                    url:"<?php echo base_url();?>main/upload_profile_pic",
                    method:"POST",
                    data:new FormData(this),
                    contentType:false,
                    cashe:false,
                    processData:false,
                    success:function(response){
                        response = response.replace(' ','');
                        $('#profile_pic_name').val(response);
                        $('#loaded_pic').attr('src','<?php echo base_url('images/profiles/');?>'+response+'');
                    }
                });
            }
        });
    });
</script>