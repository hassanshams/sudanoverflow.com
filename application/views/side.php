<!DOCTYPE html>
<html>
<body>
    <div class="container">
      <div class="col-md-2 side">
        <div class="list-group">
          <a href="<?php echo base_url('main/inventory') ?>" class="navitem naviteminv list-group-item list-group-item-action  text-right out_of_print">
            المخزن
          </a>
          <a href="<?php echo base_url('main/sell') ?>" class="navitem navitemsell list-group-item list-group-item-action text-right out_of_print">بيع</a>
          <a href="<?php echo base_url('main/manage'); ?>" class="navitem navitemmanage list-group-item list-group-item-action text-right out_of_print">ادارة</a>
            <a href="<?php echo base_url('main/submit_and_logout'); ?>" class="navitem navitemdloseday list-group-item list-group-item-action text-right out_of_print">تقفيل اليوم</a>
            <a href="<?php echo base_url('main/logout'); ?>" class="navitem list-group-item list-group-item-action text-right out_of_print">تسجيل خروج</a>
        </div>
    </div>
    </div>
    </body>
</html>