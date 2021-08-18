<?= $header_start ?>

<!-- Add aditional CSS script & Files -->
 <link rel="stylesheet" href="<?= $COMP_DIR ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- End css script -->

<?= $header_end ?>

<?= $menu ?>
<style>
    td, th {
	padding: 5px;
}
</style>
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
                    <?php $ID= (isset($details->stockissue_id))?$details->stockissue_id:""; ?>
                    <input type="hidden" name="ID" value="<?= $ID ?>">
            <?php if(isset($details->stockreceive_id)){?>
                  <div class="col-sm-12">
                <div class="form-group">
                  <label for="porderid" class="col-sm-2 control-label">stock Receive Id</label>

                  <div class="col-sm-4">
                    <input class="form-control required stockreceive_id" id="stockreceive_id" type="text" name="stockreceive_id" value="<?= (isset($details->stockreceive_id))?$details->stockreceive_id:$receive_no_new?>" readonly>
                  </div>
                </div>
                    </div>
                    <?php } else { ?>
                    <input type="hidden" name="stockreceive_id" value="<?= $receive_no_new ?>">
            <?php } ?>
			
				 <div class="col-sm-6">
                <div class="form-group">
                  <label for="porderid" class="col-sm-4 control-label">Stock Issue Id</label>

                  <div class="col-sm-8">
                    <select class="form-control required stockissue_id" id="stockissue_id" name="stockissue_id">
					<option value="">Select Stock Issue ID</option>
					<option value="">SR-SAT-Su18-01</option>
					</select>
				  </div>
                </div>
                    </div>
			
				<div class="col-sm-6">
				<div class="form-group">
                  <label for="issue_date" class="col-sm-4 control-label">Receive Date<span class="req">*</span></label>

                  <div class="col-sm-8">
                    <input class="form-control required" id="receive_date" type="text" name="receive_date" value="<?= date('m/d/Y') ?>" >
                  </div>
                </div>
              </div>
			  <div class="col-sm-6">
				<div class="form-group">
                  <label for="issue_date" class="col-sm-4 control-label">Issue Date<span class="req">*</span></label>

                  <div class="col-sm-8">
                    <input class="form-control required" id="issue_date" type="text" name="issue_date" value="<?= date('m/d/Y') ?>" readonly>
                  </div>
                </div>
              </div> 
		
			 <div class="col-sm-12">
                   
              <div class="col-sm-12  p-tb-4 m-t-5">
                <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable text-center" style="overflow-x:auto;width:100">
				
                    <thead style="background-color:#C0C0C0;">
                            <tr>
                                <th class="text-center">Manufacturer</th>
								<th class="text-center">Item Number</th>
                                <th class="text-center" >Item Color</th>
                                <th class="text-center">Item Image</th>
								<th class="addIcon">Issued Stock</th>
								<th class="addIcon">Received Stock</th>
								<th class="addIcon">Receive Stock</th>
								<th class="addIcon">Remark</th>
                                 
								</tr>
                    </thead>
                    <?php //if(!empty($details)){?>
                    
                      <tbody id="addCont">
                        <tr class="radius sResult">
							<td>Hangyang Flwr</td>
							<td>HY17091</td>
							<td>Dark Blue,Light Blue</td>
                            <td>
                                <div class="parts_img text-center" >
								
								<img src="http://localhost/flowersforcemeteries/data/parts/colors/134/1529075136_MD2072---Blue-Rose-with-Blue-Tiger-Lily.png" alt="Parts Color Image" style="height: 150px; width: 150px;">
								
								</div>
                            </td>
                            
                             
                             <td>
                                <input class="form-control stock_issue text-center numbers" id="stock_issue" type="text" name="stock_issue[]" value="40" placeholder="Stock Issue" readonly>
                            </td>
                         <td>
                                <input class="form-control total_receieved text-center numbers" id="total_receieved" type="text" name="total_receieved[]" value="10" placeholder="Total Received" readonly>
                            </td>
						<td>
                                <input class="form-control total_receieve text-center numbers" id="total_receieve" type="text" name="total_receieve[]" value="" placeholder="Total Receive" >
                            </td>	
							 <td>
                                <textarea class="form-control remark text-center" id="remark" type="text" name="remark[]" value="" placeholder="Remark"></textarea>
                            </td>
                            </tr>
                    </tbody>
                  
                    <?php //} ?>   
                </table>
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
<script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>

<script>
var AJAX_URL='<?= base_url('ajax/') ?>';
validate_form();
$(function () {

  $('#receive_date').datepicker({
      autoclose: true
    })

});
</script>

<!-- End js script -->
<?= $footer_end ?>