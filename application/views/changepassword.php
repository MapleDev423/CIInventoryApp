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
              <div class="col-sm-6 p-0"><h2 class="box-title"><?= $heading; ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="<?= $BASE_URL ?>dashboard" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
              <div class="box-body">

                <div class="col-sm-6 col-sm-offset-2"><?= getFlashMsg('success_message'); ?></div>
                <div class="clearfix"></div>
                <div class="form-group">
                  <label for="website_name" class="col-sm-3 control-label">Current Password<span class="req">*</span></label>

                  <div class="col-sm-6">
                      <input type="password" id="oldpwd" name="oldpwd" class="form-control required"   placeholder="Enter Current Password" value="<?= getFieldVal('oldpwd') ?>">
                  </div>
                </div>
                <div class="form-group">
                <label for="website_name" class="col-sm-3 control-label">New Password<span class="req">*</span></label>

                <div class="col-sm-6">
                  <input type="password" id="newpwd" name="newpwd" class="form-control required alphanumeric"  placeholder="Enter New password" value="<?= getFieldVal('newpwd') ?>">
               
                </div>
              </div>
                <div class="form-group">
                <label for="website_name" class="col-sm-3 control-label">Confirm New Password<span class="req">*</span></label>

                <div class="col-sm-6">
                  <input type="password" id="confirmnewpwd" name="confirmnewpwd" class="form-control required"  data-not-matched="The Confirm password field does not match from the New password field."  placeholder="Enter Confirm new password" value="<?= getFieldVal('confirmnewpwd') ?>">
                </div>
              </div>
               <div class="box-footer text-center">
                  <button type="submit" class="btn btn-primary m-r-20">Submit</button>
                  <a href="<?= $BASE_URL ?>dashboard" class="btn btn-danger">Cancel</a>
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
    jQuery.validator.addMethod("alphanumeric", function(value, element) {
    if (!password_strength(value,5)){return false;}
    return true;
}, "Please enter minimum 6 characters, at least one letter, one number and one special character.");

$(function() {
  
  $("#myform").validate({
    // Specify validation rules
    rules: {
    confirmnewpwd:{required: true,equalTo: "#newpwd"}
    }
    // Specify validation error messages
   
  });
});

</script>

<!-- End js script -->
<?= $footer_end ?>