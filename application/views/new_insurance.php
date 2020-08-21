<!DOCTYPE html>
<html>
<head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/new_insurance.css'></head>
<body>
    <div class="container">
      <div class="col-md-10">
                   <?php echo form_open('main/new_insurance'); ?>
                  <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="اسم التامين">
                    <?php echo form_error('name'); ?>
                  </div>
                 <div class="form-group">
                    <input type="text" name="value" class="form-control" placeholder="القيمة ">
                    <?php echo form_error('value'); ?>
                </div>
                  <div class="form-group">
                  <button type="submit" name="save_new_ins" class="btn btn-primary btn-lg btn-block">حفظ</button> 
                  </div>
        </div>
    </div>
    </body>
</html>