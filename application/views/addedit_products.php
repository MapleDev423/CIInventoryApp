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
              <div class="col-sm-6 p-0"><h2 class="box-title"><?= $mode ?> <?= $heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform ffform-horizontal" id="myform"'); ?>
              <div class="box-body">
                  <div class="col-sm-12 m-b-10">
                      <?php $ID= (isset($details->ID))?$details->ID:""; ?>
                      <input type="hidden" name="ID" value="<?= $ID ?>">
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name <span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="name" placeholder="Enter Product name" type="text" name="name" value="<?= (isset($details->name))?$details->name:''?>">
                  </div>
                </div>
                  </div>

                  <div class="col-sm-12 m-b-10">
                  <div class="form-group">
                  <label for="product_id" class="col-sm-2 control-label">Product ID <span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="product_id" placeholder="Enter Product ID" type="text" name="product_id" value="<?= (isset($details->product_id))?$details->product_id:''?>">
                  </div>
                </div>
                  </div>
             <!--
                <div class="form-group">
                  <label for="phone_no" class="col-sm-2 control-label">Quantity <span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required digits" id="quantity" placeholder="Enter Quantity" type="text" name="quantity" value="">
                  </div>
                </div>
                  
                <div class="form-group">
                  <label for="phone_no" class="col-sm-2 control-label">Price <span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required numbers" id="price" placeholder="Enter Price" type="text" name="price" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Description</label>

                  <div class="col-sm-6">
                  <textarea name="description" class="form-control" id="description" placeholder="Enter Product Description"></textarea>
                  </div>
                </div>
              
                <div class="form-group">
                  <label for="last_name" class="col-sm-2 control-label">Product Image </label>

                  <div class="col-sm-6">
                    <input type="file" name="product_img" value="" placeholder="">
                  </div>
                </div>
                 -->
                
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