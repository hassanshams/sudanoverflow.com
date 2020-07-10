<!DOCTYPE html>
<html>
            <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/new_user.css'></head>

<body>
    <div class="container">
      <div class="col-md-10"> 
          <div id="manage_users">
          </div>
          <div id="new_user">
              <h3 class="text-right">اضافة مستخدم:</h3>
             <?php echo form_open('main/new_user'); ?>
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="اسم الدخول">
                <?php echo form_error('name'); ?>
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
                  <?php echo form_error('password'); ?>
              </div> 
              <div class="form-group">
                <input type="password" name="confirm_password" class="form-control" placeholder="تاكيد كلمة المرور">
                  <?php echo form_error('confirm_password'); ?>
              </div>  
              <div class="form-group">
              <button type="submit" name="save_new_user" class="btn btn-primary btn-lg btn-block">انشاء</button>     
              </div>
          </div>
        </div>
    </div>
    </body>
</html>