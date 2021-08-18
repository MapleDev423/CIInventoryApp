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
            <div class="col-sm-12">
				 <div class="col-sm-6">
                <div class="form-group">
                  <label for="porderid" class="col-sm-4 control-label">Stock Issue Id</label>

                  <div class="col-sm-8">
                    <input class="form-control required stockissue_id" id="stockissue_id" type="text" name="stockissue_id" value="<?= (isset($details->stockissue_id))?$details->stockissue_id:''?>" readonly>
                  </div>
                </div>
                </div>
			
				<div class="col-sm-6">
				<div class="form-group">
                  <label for="issue_date" class="col-sm-4 control-label">Issue Date</label>

                  <div class="col-sm-8">
                    <input class="form-control required" id="issue_date" type="text" name="issue_date" value="<?= (isset($details->issue_date))?$details->issue_date:''?>" readonly>
                  </div>
                </div>
              </div>
			</div>
			 <div class="col-sm-12">
			<div class="col-sm-6">
                <div class="form-group">
                  <label for="employee_id" class="col-sm-4 control-label">Employee Name</label>
                  <div class="col-sm-8">
					<input class="form-control required" id="employee_name" type="text" name="employee_name" value="<?= (isset($details->employee_name))?$details->employee_name:''?>" readonly>
                  </div>
                </div>
               </div>
			  <div class="col-sm-6">
                <div class="form-group">
                  <label for="" class="col-sm-4 control-label"></label>
                  <div class="col-sm-8"></div>
                </div>
               </div> 
		 </div>
			 <div class="col-sm-12">
                   
              <div class="col-sm-12  p-tb-4 m-t-5">
                <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable text-center" align="center" style="overflow-x:auto;width:100;">
				
                    <thead style="background-color:#C0C0C0;">
                            <tr>
                                <th class="text-center">Manufacturer</th>
								<th class="text-center">Item Number</th>
                                <th class="text-center" >Item Color</th>
                                <th class="text-center">Item Image</th>
								<th class="addIcon">Current Stock</th>
								<th class="addIcon">Issued Stock</th>
							</tr>
                    
					<tbody id="addCont">
                    
					<?php if(!empty($details) && isset($details->parts) && $details->parts && count($details->parts)>0){
                            foreach ($details->parts as $partsData) { 
                        ?>
                       <tr class="radius sResult">
							<td><?=$partsData->manufacturer_name;?></td>
							<td><?=$partsData->part_name;?></td>
							<td><?=$partsData->part_colors;?></td>
                            <td>
							 <div class="parts_img text-center">
                                    <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                </div>
							</td>
						<td>
                               <input class="form-control currentstock text-center numbers" id="currentstock" type="text" name="currentstock[]" value="<?=$partsData->currentstock;?>" readonly>
                        </td>
						<td>
                               <input class="form-control issuedstock text-center numbers" id="issuedstock" type="text" name="issuedstock[]" value="<?=$partsData->issuestock;?>" readonly>
                        </td>
						
					</tr>
					
                    <?php }}?> 
				</tbody>
				</tfoot>
				<tr>
					<td colspan='4'>Total </td>
					<td><span class="total_currentstock"><?= (isset($details->total_currentstock))?$details->total_currentstock:''?></span></td>
					<td><span class="total_issuedstock"><?= (isset($details->total_issuestock))?$details->total_issuestock:''?></span></td>
				</tr>
				</tfoot>
                </table>
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

<!-- End js script -->
<?= $footer_end ?>