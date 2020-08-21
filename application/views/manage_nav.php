<!DOCTYPE html>
<html>
<body>
    <div class="container">
      <div class="col-md-10">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="manage_nav">
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link nav_sales" href="<?php echo base_url('main/manage') ?>">المبيعات<span class="sr-only">(current)</span></a>
              </li>
                <li class="nav-item active newuser">
                <a class="nav-link" href="<?php echo base_url('main/new_user') ?>">اضافة مستخدم<span class="sr-only">(current)</span></a>
              </li>
                <li  class="nav-item active manageusers">
                    <a class="nav-link" href="<?php echo base_url('main/manage_users') ?>">ادارة المستخدمين<span class="sr-only">(current)</span></a>
                </li>
                <li  class="nav-item active newinsurance">
                    <a class="nav-link" href="<?php echo base_url('main/new_insurance') ?>"> اضافة تامين صحي<span class="sr-only">(current)</span></a>
                </li>
                <li  class="nav-item active editinsurance">
                    <a class="nav-link" href="<?php echo base_url('main/edit_insurance') ?>"> تعديل تامين صحي<span class="sr-only">(current)</span></a>
                </li>
                <li  class="nav-item active bills">
                    <a class="nav-link" href="<?php echo base_url('main/manage_bills') ?>"> فواتير<span class="sr-only">(current)</span></a>
                </li>
            </ul>
          </div>
        </nav>
    </div>
    </div>
    </body>
</html> 













