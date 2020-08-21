<!DOCTYPE html>
<html>
        <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/bills.css'></head>
<body>
    <div class="container">
      <div class="col-md-10">
          <div class="form-group">
            <input type="text" id="bill_number" placeholder="رقم الفاتورة" class="form-control col-sm-8">
              <button id="delete_bill" type="submit" class="btn btn-danger btn-lg btn-block col-sm-3">مسح الفاتورة </button>
          </div>
         <table class="table table-bordered text-center">
              <thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">الشركة</th>
                  <th class="text-center" scope="col">السعر</th>
                  <th class="text-center" scope="col">الكمية</th>
                </tr>
              </thead>
              <tbody id="tablebody">
              </tbody>
            </table>
        </div>
    </div>
    </body>
    <script>
        $(document).ready(function(){
            var medicine=[];
            var medicinelist=[];
        $('#bill_number').focus();    
        $('#bill_number').keyup(function(){
            var bill_num = $(this).val();
            if(bill_num.length > 0){
                $.ajax({
                    url:"<?php echo base_url(); ?>main/get_bills",
                    method:"POST",
                    data:{bill_num:bill_num},
                    dataType:'json',
                    success:function(data){
                       var length = data.length;
                       for(i=0;i<length;i++){
                       medicine[0] = data[i]['name'];
                       medicine[1] = data[i]['vendor'];
                       medicine[2] = data[i]['portion_quantity'];
                       medicine[3] = data[i]['price'];
                       medicinelist.push(medicine);
                       medicine=[];
                       $('#bill_num').val('');
                       }
                        for(i=0;i<medicinelist.length;i++){
                            var tr = " <tr class='text-center'><td>" + medicinelist[i][0] + "</td><td>" + medicinelist[i][1] + "</td><td>" + medicinelist[i][3] + "</td><td>" + medicinelist[i][2] + "</td></tr>";
                            $("tbody").append(tr);
//                            medicinelist=[];
                        }
                     }
                });
            }
        });
            $("body").on("click","#delete_bill",function(){
                var bill_num = document.getElementById('bill_number').value;
                if(bill_num.length == 0){
                    alert('الرجاء ادخال رقم الفاتورة');
                }else{   
                $.ajax({
                    url:"<?php echo base_url(); ?>main/delete_bills",
                    method:"POST",
                    data:{bill_num:bill_num},
                    dataType:'json',
                    success:function(data){console.log(data);
                        if(data === 'ok'){
                            alert('تم مسح الفاتورة');
                            location.reload();
                        }else{
                            alert('لاتوجد فاتورة بهذا الرقم');
                        }
                     }
                });
                }
            });
        });

    </script>
</html>
    