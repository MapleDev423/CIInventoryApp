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
                  <label for="website_name" class="col-sm-2 control-label">Web Site Name<span class="req">*</span></label>

                  <div class="col-sm-9">
                    <input class="form-control required" id="website_name" placeholder="Enter website name" type="text" name="website_name" value="<?= getFieldVal('website_name',$details) ?>">
                  </div>
                </div>
                <div class="form-group" style="display: none">
                  <label for="pagination" class="col-sm-2 control-label">Pagination <span class="req">*</span></label>

                  <div class="col-sm-2">
                    <input class="form-control" id="pagination" placeholder="Enter pagination " name="pagination" type="text" value="<?= getFieldVal('pagination',$details) ?>">
                  </div>
                </div>
                 <div class="form-group">
                  <label for="logo" class="col-sm-2 control-label">Website Logo <span class="req">*</span></label>

                  <div class="col-sm-4">
                      <input type="file" name="logo" onchange="ValidateImage(this);">
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="smtpmail_host" class="col-sm-4 control-label">SMTP Host <span class="req">*</span></label>

                      <div class="col-sm-8">
                        <input class="form-control required" id="smtpmail_host" placeholder="Enter SMTP mail host " name="smtpmail_host" type="text" value="<?= getFieldVal('smtpmail_host',$details) ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="form-group">
                        <label for="smtpmail_port" class="col-sm-4 control-label">SMTP Port <span class="req">*</span></label>

                        <div class="col-sm-3">
                          <input class="form-control required" id="smtpmail_port" placeholder="Enter Port " name="smtpmail_port" type="text"  value="<?= getFieldVal('smtpmail_port',$details) ?>">
                        </div>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="smtpmail_mail" class="col-sm-4 control-label">SMTP Email <span class="req">*</span></label>

                      <div class="col-sm-8">
                        <input class="form-control required" id="smtpmail_mail" placeholder="Enter SMTP mail host " name="smtpmail_mail" type="text"  value="<?= getFieldVal('smtpmail_mail',$details) ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="form-group">
                        <label for="smtpmail_password" class="col-sm-4 control-label">SMTP Password <span class="req">*</span></label>

                        <div class="col-sm-6">
                          <input class="form-control required" id="smtpmail_password" placeholder="Enter Port " name="smtpmail_password" type="text"  value="<?= getFieldVal('smtpmail_password',$details) ?>">
                        </div>
                      </div>
                  </div>
                </div>

                <?php if(checkModulePermission(2,2)){ ?>
                <div class="box-footer text-center">
                  <button type="submit" class="btn btn-primary m-r-20">Submit</button>
                  <a href="<?= $BASE_URL ?>dashboard" class="btn btn-danger">Cancel</a>
                </div>
                <?php } ?>
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