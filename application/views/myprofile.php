<?= $header_start ?>

<!-- Add aditional CSS script & Files -->

<!-- End css script -->

<?= $header_end ?>

<?= $menu ?>

  <div class="content-wrapper">
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="col-sm-6 p-0"><h2 class="box-title">Update <?= $heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
              <div class="box-body">
                  <div class="col-sm-6 col-sm-offset-2"><?= getFlashMsg('success_message'); ?></div>
                <div class="clearfix"></div> 
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">First Name<span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="first_name" placeholder="Enter first name" type="text" name="first_name" value="<?= getFieldVal('first_name',$employee_detail); ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="last_name" placeholder="Enter last name" type="text" name="last_name" value="<?= getFieldVal('last_name',$employee_detail); ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Assign Role</label>

                  <div class="col-sm-6">
                      <input class="form-control " type="text"  value="<?= getFieldVal('role_name',$employee_detail); ?>" disabled>
                 
                  </div>
                </div>
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Profile Pic</label>

                  <div class="col-sm-6">
                    <input type="file" name="profile_pic" value="" placeholder="" onchange="ValidateImage(this);">
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone_no" class="col-sm-2 control-label">Phone No.<span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="phone_no" placeholder="Enter Phone No." type="text" name="phone_no" value="<?= getFieldVal('phone_no',$employee_detail); ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-6">
                      <input class="form-control required" id="email" placeholder="Enter email" type="email" name="email" value="<?= getFieldVal('email',$employee_detail); ?>" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Address</label>

                  <div class="col-sm-6">
                  <textarea name="address" class="form-control" id="address" placeholder="Enter address"><?= getFieldVal('address',$employee_detail) ?></textarea>
                  </div>
                </div>
        
                <div class="box-footer text-center">
                  <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary m-r-20">Submit</button>
                    <a href="<?= $main_page ?>" class="btn btn-danger">Cancel</a>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            <?= form_close() ?>
              
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<?= $footer_start ?>
<!-- Add aditional js script & files -->

<script>
validate_form();
</script>

<!-- End js script -->
<?= $footer_end ?>