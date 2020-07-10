<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-5">
            <div class="text-center">ادخل رمز التاكيد  </div> <br>
            <div class="form-group">
                <input type="text" id="code" class="form-control" placeholder="رمز التاكيد"><br>
                <button id="recover" class="btn btn-primary btn-lg btn-block">ارسال</button>
            </div>
        </div>
    </div>
</div>
<input type='hidden' id='email' value='<?php echo $_GET['email'];?>'>
<script>
    $(document).ready(function(){
        $('body').on('click','#recover',function(){
            //validate inputs here
            var email = $('#email').val();
            var code =  $('#code').val();
            var data = [];   
            data.push(email);  
            data.push(code);
            $.ajax({
                url:"<?php echo base_url(); ?>main/check_recovery_token",
                method:"POST",
                dataType:'json',
                data:{data:data},
                async:false,
                success:function(data){
                    if(data == 'ok'){
                        //show success message here
                        window.location = '<?php echo base_url("main/login");?>';
                    }else{
                        alert('code not right');
                    }
                }
            });
        });
    });
</script>