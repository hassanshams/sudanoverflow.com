<!DOCTYPE html>
<html>
<head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/manage_users.css'></head>
<body>
    <div class="container">
      <div class="col-md-10"> 
          <table id="tablebody" class="table table-bordered text-center">
              <thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                   <?php foreach($users as $value):?>  
                <tr>
                      <td><?php echo $value->username; ?></td>
                    <td><button id="edit_user" value="<?php echo $value->id; ?>" type="button" class="btn btn-success">تعديل</button>
                    <button id="delete_user" value="<?php echo $value->id; ?>" type="button" class="btn btn-danger">حذف</button>
                    </td>
                </tr>
                  <?php endforeach;?>
              </tbody>
            </table>
        </div>
    </div>

<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
           <?php echo form_open('main/eidt_user'); ?>
              <div class="form-group">
                <input id="username" type="text" name="uername" class="form-control" placeholder="اسم الدخول">
              </div>
              <div class="form-group">
                <input id="password" type="password" name="password" class="form-control" placeholder="كلمة المرور">
              </div>
              <div class="form-group">
                <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="تاكيد كلمة المرور">
              </div>
              <div class="form-group">
              <button type="submit" id="save_edit_user" name="save_edit_user" class="btn btn-primary btn-lg btn-block" data-dismiss="modal">حفظ</button>     
              </div>
      </div>
    </div>
  </div>
</div>
    <script>
        $("body").on("click","#delete_user",function(){
            var id = $(this).val();
            $.ajax({
                url:"<?php echo base_url(); ?>main/delete_user",
                method:"POST",
                data:{id:id},
                dataType:'json',
                success:function(data){
                    if(data != ""){
                        location.reload();
                        alert('تم المسح!'); 
                    }
                }
            });
        });
        $("body").on("click","#edit_user",function(){
            $('#update_user_modal').modal('show');
            var id = $(this).val();
            $.ajax({
                url:"<?php echo base_url(); ?>main/list_edited_user",
                method:"POST",
                data:{id:id},
                dataType:'json',
                success:function(data){
                    $('#username').val(data[0]['username']);
                    $('#password').val(data[0]['password']);
                    $('#confirm_password').val(data[0]['password']);
                    $('#save_edit_user').val(data[0]['id']);
                }
            });
        });
        $("body").on("click","#save_edit_user",function(){
            var userdata = [];
            userdata.push($(this).val());
            userdata.push(document.getElementById('username').value);
            userdata.push(document.getElementById('password').value);
                $.ajax({
                url:"<?php echo base_url(); ?>main/edit_user",
                method:"POST",
                data:{userdata:userdata},
                dataType:'json',
                success:function(data){
                }
            });
                    location.reload();
        });
    </script>
    </body>
</html>