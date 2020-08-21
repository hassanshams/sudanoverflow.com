<!DOCTYPE html>
<html>
    <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/edit_insurance.css'></head>
<body>
    <div class="container">
      <div class="col-md-10"> 
          <table id="tablebody" class="table table-bordered text-center">
              <thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">القيمة</th>
                  <th class="text-center" scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                   <?php foreach($ins as $value):?>  
                <tr>
                    <td><?php echo $value->name; ?></td>
                    <td><?php echo $value->value; ?>%</td>
                    <td><button id="edit_insurance" value="<?php echo $value->id; ?>" type="button" class="btn btn-success">تعديل</button>
                    <button id="delete_insurance" value="<?php echo $value->id; ?>" type="button" class="btn btn-danger">حذف</button>
                    </td>
                </tr>
                  <?php endforeach;?>
              </tbody>
            </table>
        </div>
    </div>

<div class="modal fade" id="update_insurance_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
           <?php echo form_open('main/eidt_insurance'); ?>
              <div class="form-group">
                <input id="name" type="text" name="name" class="form-control" placeholder="اسم التامين">
              </div>
              <div class="form-group">
                <input id="value" type="text" name="value" class="form-control" placeholder="القيمة ">
              </div>
              <div class="form-group">
              <button type="submit" id="save_edit_insurance" name="save_edit_insurance" class="btn btn-primary btn-lg btn-block" data-dismiss="modal">حفظ</button>     
              </div>
      </div>
    </div>
  </div>
</div>
    <script>
        $("body").on("click","#delete_insurance",function(){
            var id = $(this).val();
            $.ajax({
                url:"<?php echo base_url(); ?>main/delete_insurance",
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
        $("body").on("click","#edit_insurance",function(){
            $('#update_insurance_modal').modal('show');
            var id = $(this).val();
            $.ajax({
                url:"<?php echo base_url(); ?>main/get_edited_insurance",
                method:"POST",
                data:{id:id},
                dataType:'json',
                success:function(data){
                    $('#save_edit_insurance').val(data[0]['id']);
                    $('#name').val(data[0]['name']);
                    $('#value').val(data[0]['value']);
                }
            });
        });
        $("body").on("click","#save_edit_insurance",function(){
            var ins_data = [];
            var id = $(this).val();
            ins_data.push($(this).val());
            ins_data.push(document.getElementById('name').value);
            ins_data.push(document.getElementById('value').value);
                $.ajax({
                url:"<?php echo base_url(); ?>main/update_insurance",
                method:"POST",
                data:{ins_data:ins_data},
                dataType:'json',
                success:function(data){
                    alert(data);
                }
            });
                    location.reload();
        });
    </script>
    </body>
</html>