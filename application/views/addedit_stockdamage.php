<?= $header_start ?>

<!-- Add aditional CSS script & Files -->
 <link rel="stylesheet" href="<?= $COMP_DIR ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
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
                    <?php $ID= (isset($details->ID))?$details->ID:""; ?>
                    <input type="hidden" name="ID" value="<?= $ID ?>">
                <div class="form-group">
                  <label for="stock_damage_no" class="col-sm-2 control-label">Stock Damage No.</label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="stock_damage_no" type="text" name="stock_damage_no" value="<?= $stock_damage_no ?>" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="date" class="col-sm-2 control-label">Date</label>
                  
                  <div class="col-sm-6">
                    <input class="form-control date required" id="date" type="text" name="date" value="<?= date('m/d/Y') ?>" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="manufacturer_id" class="col-sm-2 control-label">Manufacturer<span class="req">*</span></label>
                  
                  <div class="col-sm-6">
                      <select name="manufacturer_id" id="manufacturer_id" class="form-control manufacturer_id required">
                        <option value="">Select Manufacturer</option>
                        <option value="1">Manufacturer1</option>
                        <option value="2">Manufacturer2</option>
                      </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="part_id" class="col-sm-2 control-label">Part<span class="req">*</span></label>
                  
                  <div class="col-sm-6">
                      <select name="part_id" id="part_id" class="form-control part_id required">
                        <option value="">Select Part</option>
                        <option value="1">Part1</option>
                        <option value="2">Part2</option>
                      </select>
                  </div>
                </div>
                

                <div class="form-group">
                  <label for="currentstock" class="col-sm-2 control-label">Current stock</label>
                  
                  <div class="col-sm-6">
                    <input class="form-control currentstock" id="currentstock"  type="text" name="currentstock" value="" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="issued_quantity" class="col-sm-2 control-label">Damage Quantity</label>
                  
                  <div class="col-sm-6">
                    <input class="form-control issued_quantity" id="issued_quantity" type="text" name="issued_quantity" value="" >
                  </div>
                </div>
                
                <div class="form-group">
                    <label for="remarks" class="col-sm-2 control-label">Remarks</label>
                    
                    <div class="col-sm-6">
                        <textarea name="remarks" id="remarks" class="form-control"></textarea>
                    </div>
                  </div>
                
                <div class="clearfix"></div><br>
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
<script src="<?= $COMP_DIR ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
validate_form();
$(function () {

  $('#date').datepicker({
      autoclose: true
    })

});

$(document).on('change', '.part_id', function(event) {
  var part_id=$(this).val();
  if(part_id>0){
      $(".currentstock").val(100);
  }else{
    $(".currentstock").val('');
  }
  
});


</script>

<!-- End js script -->
<?= $footer_end ?>