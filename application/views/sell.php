<!DOCTYPE html>
<html>
    <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/sell.css'></head>
<body>
    <div class="container">
      <div class="col-md-10">
        <input type="text" class="form-control out_of_print" id="barcode" placeholder="امسح المنتج" name="barcode"><br>
          <div class="print_area">
          <div class="datetime"><?php echo date('m/d/Y h:i:s', time()); ?></div>
          <div class="phar_name">صيدلية المقداد</div>
              <div id="bill_label">فاتورة رقم:</div>
              <div id="bill_num" class="out_of_print">0</div>
              <table id="tablebody" class="table table-bordered print_area">
                  <thead class="tablehead">
                      <th class="text-center" scope="col">الاسم</th>
                      <th class="text-center" scope="col">الشركة</th>
                      <th class="text-center" scope="col">السعر</th>
                      <th class="text-center" scope="col">الكمية</th>
                      <th class="text-center out_of_print" scope="col">تامين صحي</th>
                      <th class="text-center out_of_print" scope="col">مسح</th>
                  </thead>
                  <tbody id="table_body" class="print_area">
                  </tbody>
              </table><br>
                <div class="form-group row print_area">
                  <label class="col-sm-1 col-form-label price_label">المبلغ</label>
                      <div class="text-right print_area_price" id="total_price">
                    </div>
              <div class="revo_logo">®Powered By Revo Tech</div>
          </div>
          <button id="save_nd_print" type="submit" name="login" class="btn btn-primary btn-lg btn-block out_of_print">حفظ و طباعة</button>
    </div>
    </div>
    </div>
    <script>    
$(document).ready(function(){
    document.getElementById('barcode').focus();
    var x=0;
    var medicine = [];
    var medicinelist =[];
    var total_price = [];
    $("body").on("change","#select_insurance",function(){
        var ins = $(this).val();
        var row = this.parentNode.parentNode;
        med_price = $(row).find("#initial_price").val();
        if(ins !== 'empty'){
            $.ajax({
                url:"<?php echo base_url();?>main/insurance",
                method:"POST",
                data:{ins:ins},
                dataType:'json',
                success:function(data){
                    var ins_value = data[0]['value'];
                    ins_value=ins_value/100*med_price;
                    $(row).find("#price").val(med_price-ins_value);
                    get_total_price();
                }
            });
        }else{$(row).find("#price").val(med_price); get_total_price();}
    });
    document.getElementById('total_price').innerHTML =" جنيه";
        $("body").on("change","#portion_quantity",function(){
            var row = this.parentNode.parentNode;
            pq = $(row).find("#portion_quantity");
            pl = $(row).find("#portion_label");
            if($(pq).val() > 0){
            $(pl).show();
            }
    });
    //return total medicine price  
    function get_total_price(ins=0){
        document.getElementById('total_price').innerHTML = " جنيه";
        var numrows = document.getElementById('table_body').rows.length;
        for(x=0;x<numrows;x++){
            var col = document.getElementById('table_body').rows[x].cells[2];
            var price = $(col).find("#price").val();          
            price = parseInt(price)-ins;
            var sum=0;
            total_price.push(price);
            price = 0;
        }
        for(i=0;i<total_price.length;i++){
            sum = sum + total_price[i];
        }
        document.getElementById('total_price').innerHTML = sum+" جنيه";
        total_price=[];
    }
    //end
    //total medicine price after user delete medicine  
     function update_total_after_del(sum=0){
            var numrows = document.getElementById('table_body').rows.length;
            for(x=0;x<numrows;x++){
                var price = document.getElementById('table_body').rows[x].cells[2].innerHTML;
                price = parseInt(price);
                var sum=0;
                total_price.push(price);
                price = 0;
            }
            for(i=0;i<total_price.length;i++){
                sum = sum + total_price[i];
            }
            document.getElementById('total_price').innerHTML = sum+" جنيه";
            total_price=[];    
    }
    //end
    $("body").on("change","#price",function(){get_total_price();});
    //remove medicine
    $("body").on("click","#remove",function(){
        this.parentElement.remove();
        get_total_price();
    });
    //end
    //update medicine table by minus the medicine from the inventory table and print the result
    $("body").on("click","#save_nd_print",function(){
        var elements = [];
        var elements_list = [];
        var quantity_sum =0;
        var numrows = document.getElementById('tablebody').rows.length;
        if(numrows > 1){
            var bill_num = Math.floor((Math.random() * 1000000) + 1);
        for(x=1;x < numrows;x++){var table = document.getElementById('tablebody');
            var id = document.getElementById('tablebody').rows[x].cells[7].innerHTML;
            var quantity = document.getElementById('tablebody').rows[x].cells[4].innerHTML;
            var name = document.getElementById('tablebody').rows[x].cells[0].innerHTML;
            var vendor = document.getElementById('tablebody').rows[x].cells[1].innerHTML;
            var price = document.getElementById('price').value;
            var in_price = document.getElementById('tablebody').rows[x].cells[8].innerHTML;
            var portion = document.getElementById('tablebody').rows[x].cells[9].innerHTML;
            var col = document.getElementById('tablebody').rows[x].cells[3];
            var portion_quantity = $(col).find("input").val();
            var portion_label = $(col).find("#portion_label").text();                     
            quantity = parseInt(quantity);
            quantity_sum = quantity_sum + quantity; 
            elements.push(id);
            elements.push(quantity);
            elements.push(name);
            elements.push(vendor);
            elements.push(price);
            elements.push(bill_num);
            elements.push(in_price);
            elements.push(portion);
            elements.push(portion_quantity);
            elements.push(portion_label);
            elements_list.push(elements);
            elements = [];
            }
            $.ajax({
                url:"<?php echo base_url(); ?>main/update_inventroy",
                method:"POST",
                data:{elements_list:elements_list},
                dataType:'json',
                success:function(data){
                    if(data != ""){
                        alert("عذرا لا يوجد كمية كافية من "+data[0]);
                        location.reload();
                    }
                    else{
                        document.getElementById('bill_num').innerHTML=bill_num;
                        window.print();
                        location.reload();
                    }
                }
            });
        }else{alert('الرجاء مسح دواء !');}
    });
    //end
    //search for medicine by barcode and append the result to the table as rows 
 $('#barcode').keyup(function(e){
      if( e.which == 8 || e.which == 9 || e.which == 13 || e.which == 16 || e.which == 17 || e.which == 18 || e.which == 19 || e.which == 20 || e.which == 32 || e.which == 33 || e.which == 34 || e.which == 35 || e.which == 36 || e.which == 37 || e.which == 38 || e.which == 39 || e.which == 40 || e.which == 46 || e.which == 107 || e.which == 106 || e.which == 109 || e.which == 111 || e.which == 144 || e.which == 145 || e.which == 8){e.preventDefault(); return false;}
      var barcode = $(this).val();
        $.ajax({
       url:"<?php echo base_url(); ?>main/scan_medicine",
       method:"POST",
       data:{barcode:barcode},
       dataType: 'json',
       success:function(data){
       var length = data.length;
       if(length > 0){
           medicine[0] = data[0]['id'];
           medicine[1] = data[0]['name'];
           medicine[2] = data[0]['vendor'];
           medicine[3] = data[0]['quantity'];
           medicine[4] = data[0]['price'];
           medicine[5] = data[0]['in_price'];
           medicine[6] = data[0]['portion'];
           medicine[7] = data[0]['portion_label'];
           medicinelist.push(medicine);
           $('#barcode').val('');
       }
    for(i=0;i<medicinelist.length;i++){
        var numrows = document.getElementById('tablebody').rows.length;
        if(numrows > 1){
        for(x=1;x < numrows;x++){
            var id = document.getElementById('tablebody').rows[x].cells[5].innerHTML;
        }
        }
        var tr = " <tr class='text-center'> <td>" + medicinelist[i][1] + "</td><td>" + medicinelist[i][2] + "</td><td id='price_td' ><input type='text' class='form-control text-center input_sell' id='price' value='" + medicinelist[i][4] + "'><input style='display:none' type='text' id='initial_price' value='" + medicinelist[i][4] + "'></td><td id='pq_td'><input type='text' id='portion_quantity' value='0' class='form-control text-center input_sell'> <label id='portion_label'>" + medicinelist[i][7] + "</label> </td><td style='display:none'>1</td><td id='ins_td' class='out_of_print'><select class='form-control' id='select_insurance'><option value='empty'>تامين صحي</option><?php foreach($ins as $value):?><option value='<?php echo $value->id; ?>'><?php echo $value->name; ?></option><?php endforeach;?></select></td><td id='remove' style='color:red' class='out_of_print'> X </td><td id='id' style='display:none'>" + medicinelist[i][0] + "</td><td id='in_price' style='display:none'>" + medicinelist[i][5] + "</td><td id='portion' style='display:none'>" + medicinelist[i][6] + "</td></tr>";
        $("tbody").append(tr);
        get_total_price();
        medicinelist=[];
        }
   }
  });
 });
    //end
});
</script>
   </body>
 </html>








