<!DOCTYPE html>
<html>
                <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/inventory.css'></head>

<body>
    <div class="container">
      <div class="col-md-10">
         <table id="tablebody" class="table table-bordered text-center inventory_table">
              <thead class="tablehead">
                <tr>
                  <th class="text-center" scope="col">الاسم</th>
                  <th class="text-center" scope="col">الشركة</th>
                  <th class="text-center" scope="col">سعر الشراء</th>
                  <th class="text-center" scope="col">سعر البيع</th>
                  <th class="text-center" scope="col">الكمية</th>
                  <th class="text-center" scope="col">عدد الوحدات</th>
                  <th class="text-center" scope="col">اسم الوحدة</th>
                  <th class="text-center" scope="col">المستخدم</th>
                  <th class="text-center" scope="col">تاريخ الاضافة</th>
                </tr>
              </thead>
              <tbody>
                   <?php foreach($data as $value):?>  
                <tr>
                      <td><?php echo $value->name; ?></td>
                      <td><?php echo $value->vendor; ?></td>
                      <td><?php echo $value->in_price; ?></td>
                      <td><?php echo $value->price; ?></td>
                      <td><?php echo $value->quantity; ?></td>
                      <td><?php echo $value->portion; ?></td>
                      <td><?php echo $value->portion_label; ?></td>
                      <td><?php echo $value->user; ?></td>
                      <td><?php echo $value->purchase_date; ?></td>
                </tr>
                  <?php endforeach;?>
              </tbody>
            </table>
           <button class="btn btn-primary btn-lg btn-block" onclick="exportTableToExcel('tablebody','<?php echo date('Y.m.d'); ?>')">تحميل كملف اكسل</button><br>
        </div>
    </div>
<script>
    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'data:application/vnd.ms-excel;UTF-8,%EF%BB%BF';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
    </script>
    </body>
</html>