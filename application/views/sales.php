<!DOCTYPE html>
<html>
        <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/sales.css'></head>
<body>
    <div class="container"> 
       <div class="col-sm-10">
        <div class="row border border-primary rounded" style="padding-top:20px;">
          <div class="col-md-4">
              <div class="form-group">
                  <select class="form-control" id="select_user">
                    <option value='empty'>مستخدم</option>            
                    <?php foreach($users as $value):?>
                    <option value='<?php echo $value->username; ?>'><?php echo $value->username; ?></option>
                    <?php endforeach;?>
                  </select>
             </div>
            </div> 
            <div class="col-md-4">
              <div class="form-group">
                   <select class="form-control" id="select_min_max">
                    <option value='empty'>احصائيات</option>            
                    <option value='max'>الاكثر مبيعا</option>            
                    <option value='min'>الاقل مبيعا</option>            
                  </select>
             </div>
            </div> 
        <div class="col-md-4">
              <div class="form-group">
                  <select class="form-control" id="select_filter">
                    <option value='empty'> معدل البيع</option>            
                    <option value='daily'>يومي</option>            
                    <option value='weekly'>اسبوعي</option>            
                    <option value='monthly'>شهري</option>            
                  </select>
             </div>
            </div>
           <div class="col-md-4">
             <div class="form-group row">
              <label for="example-date-input" class="col-2 col-form-label">من:</label>
              <div class="col-10">
                <input class="form-control" type="date" value="" id="start_date">
              </div>
            </div>
           </div>
            <div class="col-md-4">
             <div class="form-group row">
              <label for="example-date-input" class="col-2 col-form-label">الي:</label>
              <div class="col-10">
                <input class="form-control" type="date" value="" id="end_date">
              </div>
            </div>
           </div>
           </div><br>
           <div id="result">
               <div id="result_div"></div>
           </div>
           <table id="sales_stats" class="table table-bordered text-center">
              <br><thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">الشركة</th>
                  <th class="text-center" scope="col">السعر</th>
                  <th class="text-center" scope="col">الربح</th>
                  <th class="text-center" scope="col">الكمية</th>
                  <th class="text-center" scope="col">الوحدة</th>
                  <th class="text-center" scope="col">المستخدم</th>
                  <th class="text-center" scope="col">زمن العملية</th>
                </tr>
              </thead>
              <tbody id="sales_stats_body">
                  <!--statistics results goes here-->
              </tbody>
            </table>       
           <br>
           <button id="sales_stats_button" class="btn btn-primary btn-lg btn-block" onclick="exportTableToExcel('sales_stats','<?php echo date('Y.m.d'); ?>')">تحميل كملف اكسل</button><br>           
           <br>
           <h3 class="text-right">كل المبيعات:</h3>
           <div id="sales_table">
               <table id="tablebody" class="table table-bordered text-center">
              <thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">الشركة</th>
                  <th class="text-center" scope="col">السعر</th>
                  <th class="text-center" scope="col">الربح</th>
                  <th class="text-center" scope="col">الكمية</th>
                  <th class="text-center" scope="col">الوحدة</th>
                  <th class="text-center" scope="col">المستخدم</th>
                  <th class="text-center" scope="col">زمن العملية</th>
                </tr>
              </thead>
              <tbody id="all_sales_body">
                  <?php $total_profit=$total_sales=0;?>
                   <?php foreach($data as $value):?>  
                <tr>
                      <td><?php echo $value->name; ?></td> 
                      <td><?php echo $value->vendor; ?></td>
                      <td><?php echo $value->price; ?></td>
                      <td><?php echo $value->profit; ?></td>
                      <td><?php echo $value->portion_quantity;?></td>
                      <td><?php echo $value->portion_label;?></td>
                      <td><?php echo $value->user;?></td>
                      <td style="display:none"> 
                          <?php $profit = $value->profit;
                          $total_profit=$total_profit+$profit;
                          ?>
                      </td>
                      <td style="display:none"> 
                          <?php $sale = $value->price;
                          $total_sales=$total_sales+$sale;
                          ?>
                      </td>
                      <td>
                          <?php $sell_date = $value->sell_date;
                          $selldate = date('Y.m.d h:i A',strtotime($sell_date));
                          $arrEn = array('AM', 'PM');
                          $arrAr = array('ص', 'م');
                          echo str_replace($arrEn,$arrAr,$selldate); 
                          ?></td>
                </tr>
                  <?php endforeach;?>
                  <tr><td></td><td></td><td>المجموع:<?php echo $total_sales;?></td><td>المجموع:<?php echo $total_profit;?></td></tr>
              </tbody>
            </table>
           </div><br>
            <button class="btn btn-primary btn-lg btn-block" onclick="exportTableToExcel('tablebody','<?php echo date('Y.m.d'); ?>')">تحميل كملف اكسل</button><br>
    </div>
    </div>
    <script>
    var total_price=[];
    var total_profit=[];
     // filter using user
    $("#select_user").change(function() {
    var user = $(this).val();
        if(user === 'empty'){
            $('#sales_stats_button').hide();
            $("#sales_stats tbody tr").remove();
            }else{
            $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_user",
                method:"POST",
                data:{user:user},
                dataType:'json',
                success:function(data){
                    $("#result_div").remove();
                    var div ="<div id='result_div'></div>";
                    $('#result').append(div);
                    $("#sales_stats tbody tr").remove();
                    $('#sales_stats_button').hide();
                    $('#sales_stats_button').show();
                    for(i=0;i<data.length;i++){
                    var tr ="<tr id='sales_tr'><td>"+data[i]['name']+"</td><td>"+data[i]['vendor']+"</td><td>"+data[i]['price']+"</td><td>"+data[i]['profit']+"</td><td>"+data[i]['portion_quantity']+"</td><td>"+data[i]['portion_label']+"</td><td>"+data[i]['user']+"</td><td>"+data[i]['sell_date']+"</td></tr>";
                     $('#sales_stats').append(tr);
                    var profit = data[i]['profit'];
                    var price = data[i]['price'];
                    profit=parseInt(profit);
                    price=parseInt(price);
                    total_profit.push(profit);
                    total_price.push(price);
                }
                var sum=0;
                var sum2=0;
            for(i=0;i<total_profit.length;i++){
                sum = sum + total_profit[i];
            }
            for(i=0;i<total_price.length;i++){
                sum2 = sum2 + total_price[i];
            }
     var tr = "<tr id='sales_tr'><td></td><td></td><td><div>المجموع:</div>"+sum2+"</td><td><div>المجموع:</div>"+sum+"</td><td></td><td></td><td></td><td></td></tr>";
      $("#sales_stats").append(tr);
            total_profit=[];
            total_price=[];
                }
            });
            }
});
        //filter using start and end dates
$("#end_date").change(function() {
    var end_date = $(this).val(); 
    var start_date = $('#start_date').val();
    var user = $('#select_user').val();
        var dates = [];
        dates.push(start_date);
        dates.push(end_date);
    if(user === 'empty'){
        $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_date",
                method:"POST",
                data:{dates:dates},
                dataType:'json',
                success:function(data){
                    $("#sales_stats tbody tr").remove();
                    $("#result_div").remove();
                    var div ="<div id='result_div'></div>";
                    $('#result').append(div);
                    $('#sales_stats_button').hide();
                    $('#sales_stats_button').show();
                    for(i=0;i<data.length;i++){
                    var tr ="<tr id='sales_tr'><td>"+data[i]['name']+"</td><td>"+data[i]['vendor']+"</td><td>"+data[i]['price']+"</td><td>"+data[i]['profit']+"</td><td>"+data[i]['portion_quantity']+"</td><td>"+data[i]['portion_label']+"</td><td>"+data[i]['user']+"</td><td>"+data[i]['sell_date']+"</td></tr>";
                     $('#sales_stats').append(tr);
                    var profit = data[i]['profit'];
                    var price = data[i]['price'];
                    profit=parseInt(profit);
                    price=parseInt(price);
                    total_profit.push(profit);
                    total_price.push(price);                   
                    }
                var sum=0;
                var sum2=0;
            for(i=0;i<total_profit.length;i++){
                sum = sum + total_profit[i];
            }
            for(i=0;i<total_price.length;i++){
                sum2 = sum2 + total_price[i];
            }
     var tr = "<tr id='sales_tr'><td></td><td></td><td><div>المجموع:</div>"+sum2+"</td><td><div>المجموع:</div>"+sum+"</td><td></td><td></td><td></td><td></td></tr>";
      $("#sales_stats").append(tr);
            total_profit=[];
            total_price=[];
                }
        });        
    }else{
        dates.push(user);
        $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_date_and_user",
                method:"POST",
                data:{dates:dates},
                dataType:'json',
                success:function(data){
                    $("#sales_stats tbody tr").remove();
                    $("#result_div").remove();
                    var div ="<div id='result_div'></div>";
                    $('#result').append(div);
                    for(i=0;i<data.length;i++){
                    var tr ="<tr id='sales_tr'><td>"+data[i]['name']+"</td><td>"+data[i]['vendor']+"</td><td>"+data[i]['price']+"</td><td>"+data[i]['profit']+"</td><td>"+data[i]['portion_quantity']+"</td><td>"+data[i]['portion_label']+"</td><td>"+data[i]['user']+"</td><td>"+data[i]['sell_date']+"</td></tr>";
                     $('#sales_stats').append(tr);
                var profit = data[i]['profit'];
                    var price = data[i]['price'];
                    profit=parseInt(profit);
                    price=parseInt(price);
                    total_profit.push(profit);
                    total_price.push(price);                   
                    }
                var sum=0;
                var sum2=0;
            for(i=0;i<total_profit.length;i++){
                sum = sum + total_profit[i];
            }
            for(i=0;i<total_price.length;i++){
                sum2 = sum2 + total_price[i];
            }
     var tr = "<tr id='sales_tr'><td></td><td></td><td><div>المجموع:</div>"+sum2+"</td><td><div>المجموع:</div>"+sum+"</td><td></td><td></td><td></td><td></td></tr>";
      $("#sales_stats").append(tr);
            total_profit=[];
            total_price=[];              
                }
        }); 
    }
    });
   $("#select_min_max").change(function() {
    var stats = $(this).val(); 
       if(stats === 'max'){         
        $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_max",
                method:"POST",
                data:{stats:stats},
                dataType:'json',
                success:function(data){
                    $("#sales_stats tbody tr").remove();
                    $('#sales_stats_button').hide();
                    $("#result_div").remove();
                    var div ="<div id='result_div'></div>";
                    $('#result').append(div);
                    var tr ="<br><div class='col-md-6'><div class='form-control text-right'>المنتج: "+data[0]['name']+"</div></div><div class='col-md-6'><div class='form-control  text-right'>عدد المبيعات: "+data[0]['count']+"</div></div><br><br>";
                     $('#result_div').append(tr);
                }
        });
       }else if(stats === 'min'){
                 $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_min",
                method:"POST",
                data:{stats:stats},
                dataType:'json',
                success:function(data){
                    $("#sales_stats tbody tr").remove();
                    $('#sales_stats_button').hide();
                    $("#result_div").remove();
                    var div ="<div id='result_div'></div>";
                    $('#result').append(div);
                    var tr ="<br><div class='col-md-6'><div class='form-control text-right'>المنتج: "+data[0]['name']+"</div></div><div class='col-md-6'><div class='form-control  text-right'>عدد المبيعات: "+data[0]['count']+"</div></div><br><br>";
                     $('#result_div').append(tr);
                }
        });       
        }
            });   
        //daily weekly monthly rates 
 $("#select_filter").change(function() {
     var filter = $(this).val();
     if(filter === 'daily'){
     $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_daily_rate",
                method:"POST",
                dataType:'json',
                success:function(data){
                    console.log(data);
                    $('#sales_stats_button').hide();
                    $("#sales_stats tbody tr").remove();
                    $("#sales_stats tbody tr").remove();
                    $("#result_div").remove();
                    var tr ="<div id='result_div'></div>";
                    $('#result').append(tr);
                    var tr ="<br><div class='form-control text-right'>عدد المبيعات : "+''+''+data.length+' '+'دواء/ادوية في اليوم'+"</div><br>";
                     $("#result_div").append(tr);
                }
        });
     }else if(filter === 'weekly'){
     $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_weekly_rate",
                method:"POST",
                dataType:'json',
                success:function(data){
                    $('#sales_stats_button').hide();
                    $("#sales_stats tbody tr").remove();
                    $("#result_div").remove();
                    var tr ="<div id='result_div'></div>";
                    $('#result').append(tr);                    
                    $("#sales_stats tbody tr").remove();
                    var tr ="<br><div class='form-control text-right'>عدد المبيعات : "+''+''+data.length+' '+'دواء/ادوية في الاسبوع'+"</div><br>";
                     $("#result_div").append(tr);
                }
        });             
 }else if(filter === 'monthly'){
     $.ajax({
                url:"<?php echo base_url(); ?>main/sales_by_monthly_rate",
                method:"POST",
                dataType:'json',
                success:function(data){
                    $('#sales_stats_button').hide();
                    $("#sales_stats tbody tr").remove();
                    $("#result_div").remove();
                    var tr ="<div id='result_div'></div>";
                    $('#result').append(tr);                   
                    $("#sales_stats tbody tr").remove();
                    var tr ="<br><div class='form-control text-right'>عدد المبيعات : "+''+''+data.length+' '+'دواء/ادوية في الشهر'+"</div><br>";
                     $("#result_div").append(tr);  
                }
        });        
     }
    });
        
        
//        DOWNLOAD TABLE AS EXCEL SHEET
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