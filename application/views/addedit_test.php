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
              <div class="col-sm-6 p-0"><h2 class="box-title">Add <?= $heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input class="form-control" id="inputEmail3" placeholder="Email" type="email">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10">
                    <input class="form-control" id="inputPassword3" placeholder="Password" type="password">
                  </div>
                </div>
                
                <div class="box-footer text-center">
                  <button type="submit" class="btn btn-primary m-r-20">Submit</button>
                  <a href="<?= $main_page ?>" class="btn btn-danger">Cancel</a>
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

</script>

<!-- End js script -->
<?= $footer_end ?>