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
              <div class="col-sm-6 p-0"><h2 class="box-title"> <?= $mode.' '.$heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
            <?php $ID= (isset($details->ID))?$details->ID:""; ?>
              <input type="hidden" name="ID" value="<?= $ID ?>">

              <div class="box-body">
                <div class="form-group">
                  <label for="first_name" class="col-sm-2 control-label">First Name<span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="first_name" placeholder="Enter first name" type="text" name="first_name" value="<?= getFieldVal('first_name',$details) ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-6">
                    <input class="form-control" id="last_name" placeholder="Enter last name" type="text" name="last_name" value="<?= getFieldVal('last_name',$details) ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="role_id" class="col-sm-2 control-label">Assign Role<span class="req">*</span></label>
                  <?php $role_id=getFieldVal('role_id',$details); ?>
                  <div class="col-sm-6">
                    <select name="role_id" id="role_id" class="form-control required">
                      <option value="">Select Role</option>
                      <?php if($roleList  && count($roleList)>0){
                        foreach ($roleList as $value) { ?>
                           <option value="<?= $value->ID ?>" <?= ($role_id==$value->ID)?'selected':''; ?>><?= $value->title ?></option>
                      <?php  }
                      } ?>
                     
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_pic" class="col-sm-2 control-label">Profile Pic</label>

                  <div class="col-sm-6">
                    <input type="file" name="profile_pic" value="" placeholder="" onchange="ValidateImage(this);">
                    <?php if(getFieldVal('profile_pic',$details)){ ?>
                    <input type="hidden" name="profile_pic" value="<?= getFieldVal('profile_pic',$details) ?>">
                    <img src="<?= 'https://'.$this->config->item('BUCKETNAME').'.'.$this->config->item('REGION').'.'.$this->config->item('HOST').'/'.$details->profile_pic ?>" alt="Profile Pic" style="height: 100px;">
                    <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone_no" class="col-sm-2 control-label">Phone No.<span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="phone_no" placeholder="Enter phone no" type="text" name="phone_no" value="<?= getFieldVal('phone_no',$details) ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Address</label>

                  <div class="col-sm-6">
                  <textarea name="address" class="form-control" id="address" placeholder="Enter address"><?= getFieldVal('address',$details) ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email<span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control email required" id="email" placeholder="Enter email" type="email" name="email" value="<?= getFieldVal('email',$details) ?>">
                    <span class="error"><?= getFlashMsg('email_exist'); ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label">Password<?php if($ID==''){?><span class="req">*</span><?php } ?></label>

                  <div class="col-sm-4">
                    <input class="form-control alphanumeric  <?= ($ID=='')?'required':''; ?>" id="password" placeholder="Enter password" type="password" name="password" minimum="6">
                  </div>
                </div>
                <div class="form-group">
                  <label for="conf_password" class="col-sm-2 control-label">Confirm Password<?php if($ID==''){?><span class="req">*</span><?php } ?></label>

                  <div class="col-sm-4">
                    <input class="form-control <?= ($ID=='')?'required':''; ?>" id="conf_password" placeholder="Enter confirm password" data-not-matched="The Confirm password field does not match from the password field." type="password" name="conf_password">
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


$(function() {

  <?php if($ID==''){?>
  jQuery.validator.addMethod("alphanumeric", function(value, element) {
    if (!password_strength(value,5)){return false;}
    return true;
}, "Please enter minimum 6 characters, at least one letter, one number and one special character.");
<?php } ?>

  $("#myform").validate({
    // Specify validation rules
    rules: {
    conf_password:{equalTo: "#password"}
    }
    // Specify validation error messages
   
  });
});
</script>

<!-- End js script -->
<?= $footer_end ?>