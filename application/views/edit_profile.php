<!-- <div class="container">
    <div class="row">
        <div class="col-md-4">
            <form id="myDropzone" class="dropzone" action="<?php echo base_url('main/upload_profile_pic');?>">
            </form>
        </div>
        <div class="col-md-8"></div>
    </div>
</div>
<script type="text/javascript">
Dropzone.options.myDropzone={
    this.on("addedfile", function(file) { 
   // you code, maybe like below
   var files = myDropzone.getFilesWithStatus('success');
   if(files.length > 0 ){
      for(int i = 0; i < files.length ; i++){
           myDropzone.removeFile(files[i]);
      }
    }
 });
    accept: function(file, done) {
    done();
    alert("uploaded");
  },
init: function() {
    this.on("addedfile", function() {
      if (this.files[1]!=null){
        this.removeFile(this.files[1]);
        alert("one image allowed !");
      }
    });
  }
};
</script> -->

<div class="container">
    <div class="col-md-10">
    <div class="row">
        <div class="col-md-8 order-md-first order-last">
            <h5 class="text-right">معلوماتي الشخصية:</h5>
            <div class="form-group">
                <input type="text" id="location" value="<?php echo $user_info[0]->location; ?>"class="form-control" placeholder="السكن">
            </div>
            <div class="form-group">
                <input type="text" id="job" value="<?php echo $user_info[0]->job; ?>" class="form-control" placeholder="المهنة">
            </div>
            <div class="form-group">
                <input type="text" id="college" value="<?php echo $user_info[0]->college; ?>" class="form-control" placeholder="الجامعة">
            </div>
            <div class="form-group">
                <textarea class="form-control" id="bio" rows="4" placeholder="عن نفسي"><?php echo $user_info[0]->bio;?></textarea>
            </div>
            <div class="form-group">
                 <button id="save_profile_data" class="btn btn-lg btn-block official_color">حفظ</button>
            </div>
        </div>
        <div class="col-md-4">
            <form enctype="multipart/form-data" method="post" id="profile_pic_form">
                <div class="form-group">
                    <img id="loaded_pic" src="<?php echo base_url('images/profiles/');echo $user_info[0]->profile_pic;?>">
                    <input type="hidden" id="profile_pic_name">
                </div>
                <div class="form-group">
                    <input type="file" name="profile_pic" id="profile_pic" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <input type="submit" name="" id="" value="تحميل" class="form-control official_color" placeholder="">
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<script>
$(document).ready(function(){
$('body').on('click','#save_profile_data',function(){
    var _location = $('#location').val();
    var job = $('#job').val();
    var college = $('#college').val();
    var bio = $('#bio').val();
    // if(_location == '' || college=='' || job==''){alert('fill all feilds');return;}
    var data=[];
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
                if(response == "ok"){
                    location.reload();
                }else{alert('something went wrong');}
        }
    });
});



$('#profile_pic_form').on('submit',function(e){
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
            success:function(response){console.log(response);
                response = eval(response);
                console.log(response);
                var d =new Date();
                $('#loaded_pic').attr('src','<?php echo base_url('images/profiles/');?>'+response+'?'+d.getTime()+'');
                $('#profile_pic_name').val(response);
            }
        });
    }
});
});
</script>



