<!DOCTYPE html>
<html>
        <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/submit_and_logout.css'></head>

<body>
    <div class="container"> 
       <div class="col-md-10">
           <h3 class="text-right"><?php echo "يومية: ".$_SESSION['user'];?></h3>
               <table id="tablebody" class="table table-bordered text-center">
              <thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">الشركة</th>
                  <th class="text-center" scope="col">السعر</th>
                  <th class="text-center" scope="col">الربح</th>
                  <th class="text-center" scope="col">الكمية</th>
                  <th class="text-center" scope="col">الوحدة</th>
                  <th class="text-center out_of_print" scope="col">المستخدم</th>
                  <th class="text-center" scope="col">زمن العملية</th>
                </tr>
              </thead>
              <tbody>
                   <?php foreach($data as $value):?>  
                <tr>
                      <td><?php echo $value->name; ?></td>
                      <td><?php echo $value->vendor; ?></td>
                      <td><?php echo $value->price; ?></td>
                      <td><?php echo $value->profit; ?></td>
                      <td><?php echo $value->portion_quantity;?></td>
                      <td><?php echo $value->portion_label;?></td>
                      <td class="out_of_print"><?php echo $value->user;?></td>
                      <td>
                          <?php $sell_date = $value->sell_date;
                          $selldate = date('Y.m.d h:i A',strtotime($sell_date));
                          $arrEn = array('AM', 'PM');
                          $arrAr = array('ص', 'م');
                          echo str_replace($arrEn,$arrAr,$selldate); 
                          ?></td>
                </tr>
                  <?php endforeach;?>
              </tbody>
            </table>
           <div class="col-md-9">
             <button class="btn btn-primary btn-lg btn-block out_of_print" onclick="exportTableToExcel('tablebody','<?php echo date('Y.m.d'); ?>')">تحميل كملف اكسل</button><br>
           </div>
           <div class="col-md-3">
           <button id="submit_print" class="btn btn-primary btn-lg btn-block out_of_print">طباعة</button><br>
           </div>
        </div>
    </div>
    <script>
        $('body').on('click','#submit_print',function(){
            window.print();
        });
 $(document).ready(function(){
     var total_price=[];
     var total_profit=[];
        var numrows = document.getElementById('tablebody').rows.length;
        for(x=1;x<numrows;x++){
            var price = document.getElementById('tablebody').rows[x].cells[2].innerHTML;
            var profit = document.getElementById('tablebody').rows[x].cells[3].innerHTML;
            price = parseInt(price);
            profit = parseInt(profit);
            var sum=0;
            var sum2=0;
            total_price.push(price);
            total_profit.push(profit);
        }
        for(i=0;i<total_price.length;i++){
            sum = sum + total_price[i];
        }        
       for(i=0;i<total_profit.length;i++){
            sum2 = sum2 + total_profit[i];
        }
        var total_price = sum;
        var total_profit = sum2;
     var tr = "<tr><td></td><td></td><td><div>المجموع:</div>"+total_price+"</td><td><div>المجموع:</div>"+total_profit+"</td><td></td><td></td><td></td></tr>";
      $("tbody").append(tr);
        total_price=[];

        });
        
  function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'data:application/vnd.ms-excel;UTF-8,%EF%BB%BF';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    filename = filename?filename+'.xls':'excel_data.xls';
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
}
    </script>
    </body>
</html>