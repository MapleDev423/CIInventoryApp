<?= $header_start ?>
<!-- Add aditional CSS script & Files -->
 <style>
    td, th {
	padding: 5px;
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
		margin-left: 35mm; 
		margin-right: 35mm;
                size: landscape;
       }
table.borderless td,table.borderless th{
     border: none !important;
}
</style>
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
              <div class="col-sm-6 p-0"><h2 class="box-title"><span class="no-print">Edit </span><?= $heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a  href="javascript:void(0)" class="btn btn-info no-print" id="Print" onclick="window.print()">Print</a>&nbsp;
                  <a href="<?= $main_page ?>" class="btn btn-warning no-print">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform form-horizontal" id="grform"'); ?>
              <div class="box-body" id="box-body">
             <div class="col-sm-12">
               <table class="table borderless">
				<tr class="print_invoiceid_tr" style="display:none"></tr>
				<tr>    
                    <td>
						<input type="hidden" name="ID" value="<?= $details->ID; ?>">					
                       <input type="hidden" id="edit" name="edit" class="edit" value="yes">
                        <div class="form-group">
                        <label for="" class="col-sm-4 control-label text-right">Good Receipt No. <span class="req">*</span></label>
                        <div class="col-sm-8">
                        <input class="form-control required " id="" type="text" name="goodreceipt_invoiceid" value="<?= (isset($details->goodreceipt_invoiceid))?$details->goodreceipt_invoiceid:''?>" readonly>
                        </div>
                        </div>  
                    </td>
                    <td>
                        <div class="form-group">
                        <label for="receipt_date" class="col-sm-3 control-label text-right">Receipt Date <span class="req">*</span></label>
                        <div class="col-sm-8">
                        <input class="form-control required receipt_date futuredatepicker1" id="receipt_date" placeholder="mm/dd/yyyy" type="text" name="receipt_date" value="<?= (isset($details->receipt_date))?date('m/d/Y', strtotime($details->receipt_date)):date('m/d/Y')?>" readonly>
                        </div>
                        </div>
                    </td>
					
				</tr>
				<tr>
				 <td>
                        <div class="form-group">
                        <label for="shipment_id" class="col-sm-4 control-label text-right">Against Shipments ID <span class="req">*</span></label>
                        <div class="col-sm-8">
                            <input class="form-control shipment_id required " id="shipment_id" type="hidden" name="shipment_id" value="<?= $details->shipment_ids ?>" readonly>
                        <input class="form-control required " id="" type="text" name="" value="<?= $details->shipment_id ?>" readonly>
                        </div>
                        </div>
                 </td>
				  <td>
                        <div class="form-group">
                        <label for="receipt_date" class="col-sm-3 control-label text-right"></label>
                        <div class="col-sm-8"></div>
                        </div>
                    </td>
				</tr>
            </table>       
            </div>
                    
                            
              <div class="col-sm-12">
                <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable  text-center" width="100%" style="overflow-x:auto;">
				
                    <thead style="background-color:#C0C0C0;">
                            <tr>
								<th class="text-center">Manufacturer</th>
                                <th class="text-center">Item Number</th>
                                <th class="text-center">Item Color</th>
                                <th class="text-center">Item Image</th>
                                <th class="text-center no-print">CS Pack</th>
<th class="addIcon no-print <?php //if($details->total_received_val==0){echo 'no-print'; }?>" <?php if($details->total_received_val==0){echo 'style="display:none;"';}?>>Previous Received</th>
								<th class="addIcon">Pending CS Pack</th>
                                <th class="addIcon">Received CS Pack</th>
                            </tr>
                    </thead>
<tbody>					
 <?php if(!empty($details)){?>
<?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){ 

foreach ($details->parts as $partsData) { 
$pi_no=$partsData->pi_id; 
?>
<tr class="radius sResult">
<td>
<input type="hidden" name="grp_id[]" value="<?= $partsData->ID; ?>" readonly>
<input type="hidden" class="pi_id" name="pi_id[]" value="<?= $pi_no; ?>" readonly>
<input type="hidden" name="parts_id[]" value="<?= $partsData->parts_id; ?>" readonly>
<input type="hidden" name="manufacturer[]" value="<?= $partsData->manufacturer_id; ?>" readonly>
<?=$partsData->manufacturer_name;?>
</td>  
<td><?=$partsData->part_name;?></td>
<td><?=$partsData->part_colors;?>
<input type="hidden" name="part_colors[]" value="<?=$partsData->part_colors;?>">
</td>
<td>
<div class="parts_img text-center" >
<img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
</div>
</td>

<td class="no-print">
<input class="form-control currentstock numbers text-center" id="currentstock" placeholder="CS Pack" type="text" name="currentstock[]" value="<?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):'' ?>" readonly>
</td>
<td class="no-print" <?php //if($details->total_received_val==0){echo 'class="no-print"';}?> <?php if($details->total_received_val==0){echo 'style="display:none;"';}?>>
<input class="form-control total_receipted text-center numbers" id="total_receipted" type="text" name="total_receipted[]" value="<?= ($partsData && $partsData->total_received>0)?getFieldVal('total_received',$partsData):0 ?>" placeholder="Total Receipted" readonly>
</td> 
<td>
<input class="form-control total_pending text-center numbers" id="total_pending" type="text" name="total_pending[]" value="<?= ($partsData && $partsData->total_pending>0)?$partsData->total_pending:0 ?>" placeholder="Total Pending" readonly>
</td>
<td>
<input class="form-control previous_total_receipt text-center numbers no-print" id="previous_total_receipt" type="hidden" name="previous_total_receipt[]" value='<?= ($partsData && $partsData->total_receipted>0)?$partsData->total_receipted:0 ?>' >

<input class="form-control total_receipt text-center numbers" id="total_receipt" type="text" name="total_receipt[]" value='<?= ($partsData && $partsData->total_receipted>0)?$partsData->total_receipted:'' ?>' >
</td> 
</tr>
<?php }}?>


</tbody>
<tfoot class="no-print">
<tr>
<th class="" colspan="4" style="text-align: right;padding-right: 45px;">Total</th>

<th class="text-center  no-print">
<input class="form-control total_currentstock_val_hidden text-center numbers" type="hidden" name="total_currentstock_val" value="<?= ($details && $details->total_currentstock_val>0)?getFieldVal('total_currentstock_val',$details):0 ?>">
<span class="total_currentstock_val"><?= ($details && $details->total_currentstock_val>0)?getFieldVal('total_currentstock_val',$details):0 ?></span>
</th>
<th class="text-center  no-print <?php //if($details->total_received_val==0){echo 'no-print'; }?>" <?php if($details->total_received_val==0){echo 'style="display:none;"'; }?>>
<input class="form-control total_receipted_val_hidden text-center numbers" type="hidden" name="total_receipted_val" value="0"> 
<span class="total_receipted_val"><?= ($details && $details->total_received_val>0)?getFieldVal('total_received_val',$details):0.00 ?></span>
</th>
<th class="text-center">
<input class="form-control total_pending_val_hidden text-center numbers" type="hidden" name="total_pending_val" value="<?= ($details && $details->total_pending_val>0)?getFieldVal('total_pending_val',$details):0.00 ?>"> 
<span class="total_pending_val"><?= ($details && $details->total_pending_val>0)?getFieldVal('total_pending_val',$details):0.00 ?></span>
</th>
<th class="text-center">
<input class="form-control total_receipt_val_hidden text-center numbers" type="hidden" name="total_receipt_val" value="<?= ($details && $details->total_receipted_val>0)?getFieldVal('total_receipted_val',$details):0.00 ?>">
<span class="total_receipt_val"><?= ($details && $details->total_receipted_val>0)?getFieldVal('total_receipted_val',$details):0.00 ?></span>
</th>
</tr>
</tfoot>
<?php } ?>   
</table>
</div>
</div>
               
<div class="clearfix"></div><br>

<div class="box-footer text-center">
<div class="col-sm-2"></div> 
<div class="col-sm-8">
<button type="submit" id="savegr" name='savegr' value='savegr' class="btn btn-primary m-r-20 no-print">Save Good Receipt</button>
<button type="submit" id="approvegr" name='savegr' value='approvegr' class="btn btn-success m-r-20 no-print">Approve Good Receipt</button>
<a href="<?= $main_page ?>" class="btn btn-danger no-print">Cancel</a>
<!-- 
<button type="submit" id="savebackwardpo" class="btn btn-primary" formaction="<?php echo base_url()?>goodreceipt/addedit_backorder_purchaseorder">Create Back Order</button>
-->
</div>
<div class="col-sm-2"></div> 
</div>

            <?= form_close() ?>
              
          </div>
		 </div>
		</div>
		</div>
		</section>
		</div>

<?= $footer_start ?>
<!-- Add aditional js script & files -->
<script src="<?= $JS_DIR ?>goodreceipt.js" type="text/javascript"></script>

<!-- End js script -->
<?= $footer_end ?>