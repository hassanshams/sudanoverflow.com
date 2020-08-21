<!DOCTYPE html>
<html>
                    <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/delete_med.css'></head>

<body>
    <div class="container">
      <div class="col-md-10">
          <div class="form-group">
            <input type="text" id="barcode" placeholder="الباركود " class="form-control col-sm-8">
              <button id="delete_medicine" type="submit" class="btn btn-danger btn-lg btn-block col-sm-3">مسح الدواء </button>
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
        $('#barcode').focus();    
 $('#barcode').keyup(function(e){
      if( e.which == 8 || e.which == 9 || e.which == 13 || e.which == 16 || e.which == 17 || e.which == 18 || e.which == 19 || e.which == 20 || e.which == 32 || e.which == 33 || e.which == 34 || e.which == 35 || e.which == 36 || e.which == 37 || e.which == 38 || e.which == 39 || e.which == 40 || e.which == 46 || e.which == 107 || e.which == 106 || e.which == 109 || e.which == 111 || e.which == 144 || e.which == 145 || e.which == 8){e.preventDefault(); return false;}
      var barcode = $(this).val();
            if(barcode.length > 0){
                $.ajax({
                    url:"<?php echo base_url(); ?>main/scan_medicine",
                    method:"POST",
                    data:{barcode:barcode},
                    dataType:'json',
                    success:function(data){
                       var length = data.length;
                       for(i=0;i<length;i++){
                       medicine[0] = data[i]['name'];
                       medicine[1] = data[i]['vendor'];
                       medicine[2] = data[i]['quantity'];
                       medicine[3] = data[i]['price'];
                       medicine[4] = data[i]['barcode'];
                       medicinelist.push(medicine);
                       medicine=[];
                       $('#bill_num').val('');
                       }
                        for(i=0;i<medicinelist.length;i++){
                            $("tbody tr").remove();
                            var tr = " <tr class='text-center'><td>" + medicinelist[i][0] + "</td><td>" + medicinelist[i][1] + "</td><td>" + medicinelist[i][3] + "</td><td>" + medicinelist[i][2] + "</td><td style='display:none' id='barcodevalue'>" + medicinelist[i][4] + "</td></tr>";
                            $("tbody").append(tr);
                            $('#barcode').val('');
                        }
                     }
                });
            }
        });
          $("body").on("click","#delete_medicine",function(){
                var barcode = document.getElementById('barcodevalue').innerHTML;
                $.ajax({
                    url:"<?php echo base_url(); ?>main/remove_medicine",
                    method:"POST",
                    data:{barcode:barcode},
                    dataType:'json',
                    success:function(data){console.log(data);
                        if(data === 'ok'){
                            location.reload();
                            alert('تم مسح الدواء');
                        }else{
                            alert('حدث خطا!');
                        }
                     }
                });
            });
  });
    </script>