<?= $header_start ?>

<?= $header_end ?>
<style>
td, th {
	    text-align:center;
    }
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
@page {
		margin-top: 5mm; 
		margin-bottom: 5mm; 
		margin-left: 0mm; 
		margin-right: 0mm;
    size: landscape;
       }

 table.borderless td,table.borderless th{
     border: none !important;
}
</style>
<?= $menu ?>

  <div class="content-wrapper">
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="col-sm-6 p-0"><h2 class="box-title"><?= $heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="javascript:void(0)" class="btn btn-info no-print" onclick="window.print();">Print</a>&nbsp;
				  <a href="<?= $main_page ?>" class="btn btn-warning no-print">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
            <div class="col-sm-12 m-b-10">
                <div class="col-sm-6">
				<div class="form-group">
                  <label for="porderid" class="col-sm-4 control-label">Invoice ID<span class="req">*</span></label>
                  <div class="col-sm-8">
                    <input class="form-control required porderid" id="porderid" type="text" name="porderid" value="<?= (isset($details->invoiceid))?$details->invoiceid:$details->invoiceid?>" readonly>
                  </div>
                </div>
                </div>
                <div class="col-sm-6">
                <div class="form-group">
                  <label for="po_date" class="col-sm-4 control-label">Invoice Date<span class="req">*</span></label>
                  <div class="col-sm-8">
                      <input class="form-control required po_date futuredatepicker1" id="po_date" placeholder="mm/dd/yyyy" type="po_date" name="po_date" value="<?= (isset($details->po_date))?date('m/d/Y', strtotime($details->po_date)):date('m/d/Y')?>" readonly="">
                  </div>
                </div>
                </div>
            </div>

            <div class="col-sm-12 m-b-10">
                <div class="col-sm-6">
                    <div class="form-group">
					<?php if($details->porderid>0){?>
                  <label for="planningsheet_id" class="col-sm-4 control-label">Purchase Order<span class="req">*</span></label>
                  <div class="col-sm-8">
                      <?php if(!empty($porders)) { 
                            foreach($porders as $porder) {
                            if($details->porderid==$porder->ID){
                      ?>
                        <input class="form-control required" value="<?= $porder->porderid;?>" readonly>
                      <?php }}} ?>
                  </div>
				  <?php } ?>
                </div> 
                </div>
                <div class="col-sm-6">
                      <div class="form-group">
                  <label for="manufacturer_id" class="col-sm-4 control-label">Manufacturer<span class="req">*</span></label>
                  <div class="col-sm-8">
                      <?php if(!empty($manufacturer)) {
                            foreach($manufacturer as $manufact) {
                             if($details->manufacturer_id==$manufact->ID){?>
                        <input class="form-control required" value="<?= $manufact->name;?>" readonly>
                       <?php } } } ?>
                    
                  </div>
                </div>
                </div>
            </div>
                  <div class="col-sm-12 m-b-10">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label for="cbm_area_type" class="col-sm-4 control-label">Area Type<span class="req">*</span></label>
                            <div class="col-sm-8">
                                <select name="cbm_area_type" id="cbm_area_type" class="form-control cbm_area_type required" disabled>
                                    <option value="CBM" <?= (isset($details->cbm_area_type) && $details->cbm_area_type=="CBM")?'selected':'';?>>CBM</option>
                                    <option value="Cubic Feet" <?= (isset($details->cbm_area_type) && $details->cbm_area_type=="Cubic Feet")?'selected':'';?>>Cubic Feet</option>
                                </select>
                            </div>
                        </div>
                      </div>

                          <div class="col-sm-6">
                        <div class="form-group">
                            <label for="shipping_date" class="col-sm-4 control-label">Estimated Ship Date<span class="req">*</span></label>
                            <div class="col-sm-8">
                                <input type='text' id="shipping_date" name="shipping_date" class="form-control futuredatepicker required" data-field="Date" placeholder="dd/mm/yyyy" value="<?= (isset($details->shipping_date))?date('m/d/Y', strtotime($details->shipping_date)):date('m/d/Y')?>" readonly/>
                            </div>
                        </div>
                          </div>
                  </div>


            <div class="col-sm-12">
                                
                   <fieldset>
              <div class="col-sm-12  p-tb-4 m-t-5">
                <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable" width="100%" style="overflow-x:auto;">
				
                    <thead style="background-color:#C0C0C0;">
                            <tr>
                                <th class="text-center" width="130">Item Number</th>
                                <th class="text-center" width="100">Item Color</th>
                                <th class="text-center">Item Image</th>
            <th class="text-center"  <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>Price</th>
                                <th class="text-center">MOQ</th>
                                <th class="text-center">CS Pack</th>
                                <th class="text-center area_type"><?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                                <th class="text-center">Total Cases</th>
                                <th class="text-center">Total PCS</th>
            <th class="text-center"  <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>Total Cost</th>
                                <th class="text-center total_area_type">Total <?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                             </tr>
                    </thead>
                    <?php if(!empty($details)){?>
                    
                      <tbody id="addCont">
                        <?php
                        $total_cases_val=0.00;
                        $total_pcs_val=0.00;
                        if(  isset($details->parts) && $details->parts && count($details->parts)>0){$i= count($details->parts);
                            foreach ($details->parts as $partsData) { 
                        ?>
                        <tr class="radius sResult">
                            <td>
								<?php 
								if(!empty($partsList)){foreach($partsList as $value){
                                  if($partsData->parts_id==$value->ID){ 
								echo ($partsData && $partsData->parts_id==$value->ID)?$value->name:''; 
								  } }} 
								  ?>
                               
                                </td>
                            <td>
                              <?php 
							  if(!empty($partsData->partColorsList)){
                               foreach($partsData->partColorsList as $value){
								if($value->color_code==$partsData->part_colors){
								echo ($value->color_code==$partsData->part_colors)?$value->color_code:'';
								} } } ?>
							</td>
                            <td>
                                <div class="parts_img text-center" >
                                    <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                </div>
                            </td>
<td <?= (!checkModulePermission(16,5))?'style="display:none"':''?>><?= getFieldVal('parts_price',$partsData) ?></td>
                            <td><?= getFieldVal('parts_moq',$partsData) ?></td>
                            <td><?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):'' ?></td>
                            <td><?= (getFieldVal('cbm',$partsData)>0)?getFieldVal('cbm',$partsData):'' ?></td>
                            <td><?= (getFieldVal('total_cases',$partsData)>0)?getFieldVal('total_cases',$partsData):'' ?></td>
                            <td><?= (getFieldVal('total_pcs',$partsData)>0)?getFieldVal('total_pcs',$partsData):'' ?></td>
<td <?= (!checkModulePermission(16,5))?'style="display:none"':''?>><?= ($partsData && $partsData->total_cost>0)?getFieldVal('total_cost',$partsData):0 ?></td>
                            <td><?= ($partsData && $partsData->total_cbm>0)?getFieldVal('total_cbm',$partsData):0 ?></td>
                            
                        </tr>
                        <?php 
						$i--;
						 $total_cases_val+=getFieldVal('total_cases',$partsData);
						 $total_pcs_val+=getFieldVal('total_pcs',$partsData);
						 
						} }?>
                    </tbody>
                    
                    <tfoot>
                    <tr>
<th <?= (!checkModulePermission(16,5))?'colspan="7"':'colspan="9"'?> style="text-align: right;padding-right: 45px;">Total</th>
<th class="text-center">
<input class="form-control total_cost_val_hidden text-center numbers" type="hidden" name="total_cost_val" value="<?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?>">
<span class="total_cost_val"><?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?></span>
</th>
<th class="text-center">
<input class="form-control total_cbm_val_hidden text-center numbers" type="hidden" name="total_cbm_val" value="<?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?>">
<span class="total_cbm_val"><?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?></span>
</th>
</tr>
                    <tr>
                        <th <?= (!checkModulePermission(16,5))?'':'colspan="2"'?> style="text-align: right;padding-right: 45px;"></th>
                        <th class="text-center" <?= (!checkModulePermission(16,5))?'':'colspan="2"'?>>Confirmation No. <span class="req">*</span></th>
                        <th class="text-center" colspan="2">
                            <input class="form-control confirmation_no_hidden text-center" type="hidden" name="confirmation_no" value="<?= ($details && $details->confirmation_no!='')?getFieldVal('confirmation_no',$details):"" ?>">
                            <span class="confirmation_no"><?= ($details && $details->confirmation_no!='')?getFieldVal('confirmation_no',$details):"" ?></span>
                        </th>
                        <th class="text-center">Deposit(%)<span class="req">*</span></th>
                        <th class="text-center" >
                            <input class="form-control total_deposit_per_hidden text-center numbers" type="hidden" name="total_deposit_per" value="<?= ($details && $details->total_deposit_per>0)?getFieldVal('total_deposit_per',$details):0 ?>">
                            <span class="total_deposit_per"><?= ($details && $details->total_deposit_per>0)?getFieldVal('total_deposit_per',$details):0 ?></span>
                        </th>
                        <th class="text-center">Deposit Amt <span class="req">*</span></th>
                        <th class="text-center" >
                            <input class="form-control total_deposit_val_hidden text-center numbers" type="hidden" name="total_deposit_val" value="<?= ($details && $details->total_deposit_val>0)?getFieldVal('total_deposit_val',$details):"0.00" ?>">
                            <span class="total_deposit_val"><?= ($details && $details->total_deposit_val>0)?getFieldVal('total_deposit_val',$details):"0.00" ?></span>
                        </th>
                        <th class="text-center">&nbsp;</th>
                    </tr>
</tfoot>
<?php } ?>   
                </table>
                  </div>
                 </div>
                    <div class="clearfix"></div>
                  </fieldset>
                </div>
              </div>
              <!-- /.box-body -->
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

<!-- End js script -->
<style>
    td, th {
	padding: 5px;
}
</style>
<?= $footer_end ?>