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
.mytable select { 
width:120px; }
</style>
  <div class="content-wrapper">
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="col-sm-6 p-0"><h2 class="box-title"><?= $heading ?></h2></div>
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
            <?php if(isset($details->stockissue_id)){?>
                 <div class="col-sm-12">
                <div class="form-group">
                  <label for="porderid" class="col-sm-2 control-label">stock Issue Id</label>

                  <div class="col-sm-4">
                    <input class="form-control required stockissue_id" id="stockissue_id" type="text" name="stockissue_id" value="<?= (isset($details->stockissue_id))?$details->stockissue_id:''?>" readonly>
                  </div>
                </div>
                    </div>
                    <?php } ?>
			
				<div class="col-sm-6">
				<div class="form-group">
                  <label for="issue_date" class="col-sm-4 control-label">Issue Date<span class="req">*</span></label>

                  <div class="col-sm-8">
                    <input class="form-control required" id="issue_date" type="text" name="issue_date" value="<?= date('m/d/Y') ?>" >
                  </div>
                </div>
              </div>
			   
				<div class="col-sm-6">
                <div class="form-group">
                  <label for="employee_id" class="col-sm-4 control-label">Employee Name<span class="req">*</span></label>
                  
                  <div class="col-sm-8">
                      <select name="employee_id" id="employee_id" class="form-control employee_id select2 required">
                        <option value="">Select Employee</option>
                        <?php if($employee_detail){
                                foreach($employee_detail as $employee) {?>
                                    <option value="<?= $employee->ID;?>" <?= ($details && $details->employee_id==$employee->ID)?'selected':'' ?>><?= $employee->first_name.' '.$employee->last_name;?></option>
                        <?php }} ?>
                      </select>
                  </div>
                </div>
               </div>
			
			  <div class="col-sm-6">
                <div class="form-group">
                  <label for="porderid" class="col-sm-4 control-label">Rows</label>

                  <div class="col-sm-6">
                      <input class="form-control number rows" id="rows" type="text" name="rows" placeholder="Enter No. of Rows">
                  </div>
                  <div class="col-sm-2">
                      <button type="button" class="btn btn-primary m-r-20 add_row">Add</button>
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
								<th class="addIcon">Current Stock</th>
								<th class="addIcon">Issue Stock</th>
								<th class="addIcon"><i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i></th>
                            </tr>
                    
					<tbody id="addCont">
                   
						 <tr class="radius sResult">
							<td>
							<select name="manufacturer_id[]" id="manufacturer_id" class="form-control manufacturer_id required" <?= ($details && $details->planningsheet_id!=0)?'readonly':'' ?> >
                                <option value="">Select Manufacturer</option>
                                <?php if(!empty($manufacturer)) { ?>
                                  <?php foreach($manufacturer as $manufact) {?>
									<option value="<?= $manufact->ID;?>"><?= $manufact->name;?></option>
                                  <?php } ?>
                                <?php } ?>
                          </select>
							</td>
							<td>
								<select name="parts_id[]" id="parts_id" class="form-control parts_id">
                                    <option value="">Select Part</option>
								</select>
							</td>
							<td>
                                <select name="part_colors[]" class="form-control partsColorList" >
                                    
                                    <option value="">Select Part Color</option> 
                                </select>
                            </td>
                            <td>
                                <div class="parts_img text-center" style="height: 150px; width: 150px;"></div>
                            </td>
							
							<td>
                               <input class="form-control currentstock text-center numbers" id="currentstock" type="text" name="currentstock[]" value="0" readonly>
                            </td>
							<td>
                                <input class="form-control issuestock text-center numbers" id="issuestock" type="text" name="issuestock[]" value="" placeholder="Stock Issue" readonly>
                            </td>
                            <td align="center" class="addIcon"><i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i> </td>
					    </tr>

				</tbody>
				</tfoot>
				<tr>
					<td colspan='4'>Total </td>
					<td>
                        <input class="form-control total_currentstock_hidden text-center numbers" id="total_currentstock" type="hidden" name="total_currentstock[]" value="0" readonly>
						<span class="total_currentstock">0.00</span>
				   </td>
					<td>
                        <input class="form-control total_issuestock_hidden  text-center numbers" id="total_issuestock" type="hidden" name="total_issuestock[]" value="0" readonly>
						<span class="total_issuestock">0.00</span>
					</td>
					<td></td>
				</tr>
				</tfoot>
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
<script src="<?= $JS_DIR ?>stock_issue.js" type="text/javascript"></script>
<script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>

<script>
var AJAX_URL='<?= base_url('ajax/') ?>';
validate_form();
$(function () {

  $('#issue_date').datepicker({
      autoclose: true
    })

});
</script>

<!-- End js script -->
<?= $footer_end ?>