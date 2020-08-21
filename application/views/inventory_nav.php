<!DOCTYPE html>
<html>
            <head><link rel='stylesheet' href='<?php echo base_url() ; ?>/style/inventory_nav.css'></head>

<body>
    <div class="container">
      <div class="col-md-10">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="inventory_nav">
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link navitem_inventory" href="<?php echo base_url('main/inventory') ?>">المخزن<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link navitem_newmed" href="<?php echo base_url('main/new_medicine') ?>">اضافة دواء جديد<span class=" sr-only">(current)</span></a>
                    </li>
              <li class="nav-item active navitem_editmed">
                <a class="nav-link" href="<?php echo base_url('main/edit_medicine') ?>">تعديل دواء <span class="  sr-only">(current)</span></a>
              </li>
              <li class="nav-item active navitem_removemed">
                <a class="nav-link" href="<?php echo base_url('main/delete_medicine') ?>">ازالة دواء <span class="  sr-only">(current)</span></a>
              </li>
            </ul>
          </div>
        </nav>
    </div>
    </div>
    </body>
</html> 













