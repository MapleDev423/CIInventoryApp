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
                  <label for="stock_issue" class="col-sm-2 control-label">Stock Issue<span class="req">*</span></label>

                  <div class="col-sm-6">
                    <select name="stock_issue" id="stock_issue" class="form-control stock_issue required">
                        <option value="">Select Stock Issue</option>
                        <option value="1">05122018-258746</option>
                        <option value="2">05122018-233346</option>
                      </select>
                    
                  </div>
                </div>
              
                <div class="form-group">
                  <label for="return_date" class="col-sm-2 control-label">Return Date</label>
                  
                  <div class="col-sm-6">
                    <input class="form-control required" id="return_date" type="text" name="return_date" value="<?= date('m/d/Y') ?>" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="employee_id" class="col-sm-2 control-label">Employee Name<span class="req">*</span></label>
                  
                  <div class="col-sm-6">
                      <select name="employee_id" id="employee_id" class="form-control employee_id required">
                        <option value="">Select Employee</option>
                        <option value="1">Skyler</option>
                        <option value="2">Matt</option>
                      </select>
                  </div>
                </div>
                <div class="stockissue_details" style="display: none">
                  <div class="form-group">
                    <label for="part_id" class="col-sm-2 control-label">Part</label>
                    
                    <div class="col-sm-6">
                        <input class="form-control part_id" id="part_id" placeholder="Enter current stock" type="text" name="part_id" value="HY17040" readonly>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="currentstock" class="col-sm-2 control-label">Current stock</label>
                    
                    <div class="col-sm-6">
                      <input class="form-control currentstock" id="currentstock" placeholder="Enter current stock" type="text" name="currentstock" value="20" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="issued_quantity" class="col-sm-2 control-label">Issued Quantity</label>
                    
                    <div class="col-sm-6">
                      <input class="form-control issued_quantity" id="issued_quantity" type="text" name="issued_quantity" value="10" readonly>
                    </div>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label for="return_quantity" class="col-sm-2 control-label">Return Quantity<span class="req">*</span></label>
                  
                  <div class="col-sm-6">
                    <input class="form-control required return_quantity" id="return_quantity" type="text" name="return_quantity" value="">
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

  $('#return_date').datepicker({
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



$(document).on('input', '.issued_quantity', function(event) {
      var issued_quantity= parseInt($(this).val());
      var currentstock= parseInt($(".currentstock").val());
      issued_quantity=(issued_quantity>0)?issued_quantity:0;
      //alert(issued_quantity);
      if(issued_quantity<=currentstock){
        var remaining= currentstock-issued_quantity;
        $(".remaining").val(remaining);
      }
      
  });


$(document).on('change', '.stock_issue', function(event) {
  var stock_issue=$(this).val();
  if(stock_issue!=''){
      $(".stockissue_details").show(100);
  }else{
    $(".stockissue_details").hide(100);
  }
  
});



</script>

<!-- End js script -->
<?= $footer_end ?>