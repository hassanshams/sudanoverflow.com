<!DOCTYPE html>
<html>
<head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/edit_med.css'></head>
<body>
    <div class="container">
      <div class="col-md-10">
          <div class="form-group">
            <input type="text" id="barcode" placeholder="الباركود" class="form-control">
          </div>
         <table class="table table-bordered text-center">
              <thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">الشركة</th>
                  <th class="text-center" scope="col">سعر الشراء</th>
                  <th class="text-center" scope="col">سعر البيع</th>
                  <th class="text-center" scope="col">الكمية</th>
                  <th class="text-center" scope="col">عدد الوحدات</th>
                  <th class="text-center" scope="col">اسم الوحدة</th>
                </tr>
              </thead>
              <tbody id="tablebody">
              </tbody>
            </table>
          <button id="save_edit" type="submit" class="btn btn-primary btn-lg btn-block">حفظ التعديل</button>
        </div>
    </div>
          <script>
               document.getElementById('barcode').focus();
              $('#barcode').keyup(function(e){
                  var barcode = $(this).val();
                var tbody = document.getElementById('tablebody');
                tbody.removeChild(tbody.childNodes[0]);
                if( e.which == 8 || e.which == 9 || e.which == 13 || e.which == 16 || e.which == 17 || e.which == 18 || e.which == 19 || e.which == 20 || e.which == 32 || e.which == 33 || e.which == 34 || e.which == 35 || e.which == 36 || e.which == 37 || e.which == 38 || e.which == 39 || e.which == 40 || e.which == 46 || e.which == 107 || e.which == 106 || e.which == 109 || e.which == 111 || e.which == 144 || e.which == 145 || e.which == 8){e.preventDefault(); return false;}
               $.ajax({
                url:"<?php echo base_url(); ?>main/scan_medicine",
                method:"POST",
                data:{barcode:barcode},
                dataType:'json',
                success:function(data){
                    var id = data[0]['id'];
                    var name = data[0]['name'];
                    var vendor = data[0]['vendor'];
                    var price = data[0]['price'];
                    var in_price = data[0]['in_price'];
                    var quantity = data[0]['quantity'];                
                    var portion = data[0]['portion'];                
                    var portion_label = data[0]['portion_label'];                               
                var row = "<tr><td style='display:none'><input id='id' value='"+id+"'></td><td><div class='form-group text-center'><input id='name' type='text' value='"+name+"' class='form-control text-center'></div><td><div class='form-group text-center'><input id='vendor' type='text' value='"+vendor+"' class='form-control text-center'></div></td><td><div class='form-group'><input id='in_price' type='text' value='"+in_price+"' class='form-control text-center'></div></td><td><div class='form-group'><input id='price' type='text' value='"+price+"' class='form-control text-center'></div></td><td><div class='form-group'><input id='quantity' type='text' value='"+quantity+"' class='form-control text-center'></div></td><td><div class='form-group text-center'><input id='portion' type='text' value='"+portion+"' class='form-control text-center'></div></td><td><div class='form-group'><input id='p_label' type='text' value='"+portion_label+"' class='form-control text-center'></div></td></tr>";
                $("tbody").append(row);
                $('#barcode').val('');
                }
               });                 
              });
              $("body").on("click","#save_edit",function(){
                  var data =[];
                  data.push(document.getElementById('id').value);
                  data.push(document.getElementById('name').value);
                  data.push(document.getElementById('vendor').value);
                  data.push(document.getElementById('in_price').value);
                  data.push(document.getElementById('price').value);
                  data.push(document.getElementById('quantity').value);
                  data.push(document.getElementById('portion').value);
                  data.push(document.getElementById('p_label').value);
                  $.ajax({
                    url:"<?php echo base_url(); ?>main/update_medicine",
                    method:"POST",
                    data:{data:data},
                    dataType:'json',
                    success:function(response){
                    if(response[0] == "n"){
                    }else if(response[0] == "k"){
                        alert('تم التعديل بنجاح !');
                        location.reload();
                    }
                    }
                  });
                  });  
          </script>
    </body>
</html>