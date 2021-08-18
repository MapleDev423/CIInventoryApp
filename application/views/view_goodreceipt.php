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
              <div class="col-sm-6 p-0"><h2 class="box-title"><span class="no-print">View </span><?= $heading ?></h2></div>
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
                        <input type="hidden" name="manufacturer_id" value="<?= $details->manufacturer_id ?>">
                        <div class="form-group">
                        <label for="" class="col-sm-4 control-label text-right">Good Receipt No. <span class="req">*</span></label>
                        <div class="col-sm-8">
                        <input class="form-control required " id="" type="text" name="" value="<?= (isset($details->goodreceipt_invoiceid))?$details->goodreceipt_invoiceid:''?>" readonly>
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
                        <label for="receipt_date" class="col-sm-4 control-label text-right">Against Shipments ID <span class="req">*</span></label>
                        <div class="col-sm-8">
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
		<th class="addIcon  no-print <?php //if($details->total_received_val==0){echo 'no-print';}?>" <?php if($details->total_received_val==0){echo 'style="display:none;"';}?>>Previous Received</th>
		<th class="addIcon">Pending CS Pack</th>
		<th class="addIcon">Received CS Pack</th>
                            </tr>
                    </thead>
                    <?php if(!empty($details)){?>
                    
                      <tbody id="addCont">
                        <?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){$i= count($details->parts);
                            foreach ($details->parts as $partsData) { 
                        ?>
                        <tr class="radius sResult">
                            <td><?=$partsData->manufacturer_name;?></td>
							<td><?=$partsData->part_name;?></td>
                            <td><?=$partsData->part_colors;?></td>
                            <td>
                                <div class="parts_img text-center" >
                                    <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                </div>
                            </td>
						<td class="no-print"><?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):0 ?></td>
                           <td class="no-print" <?php if($details->total_received_val==0){echo 'class="no-print"'; }?> <?php if($details->total_received_val==0){echo 'style="display:none;"'; }?>><?= (getFieldVal('total_received',$partsData)>0)?getFieldVal('total_received',$partsData):0 ?></td>
						   <td><?= (getFieldVal('total_pending',$partsData)>0)?getFieldVal('total_pending',$partsData):0 ?></td>
						   <td><?= ($partsData && $partsData->total_receipted>0)?getFieldVal('total_receipted',$partsData):0 ?></td>  
                        </tr>
                        <?php $i--;} }?>
                    </tbody>
                    <tfoot class="no-print">
                        <tr>
                            <th class="" colspan="4" style="text-align: right;padding-right: 45px;">Total</th>
                           <th class="text-center no-print">
                               <span class="total_currentstock_val "><?= ($details && $details->total_currentstock_val>0)?getFieldVal('total_currentstock_val',$details):0 ?></span>
                            </th>
							  <th class="text-center no-print <?php //if($details->total_received_val==0){echo 'no-print'; }?>" <?php if($details->total_received_val==0){echo 'style="display:none;"'; }?>>
                               <span class="total_received_val"><?= ($details && $details->total_received_val>0)?getFieldVal('total_received_val',$details):0 ?></span>
                            </th>
							  <th class="text-center">
                               <span class="total_pending_val"><?= ($details && $details->total_pending_val>0)?getFieldVal('total_pending_val',$details):0 ?></span>
                            </th>
                            <th class="text-center">
                                 <span class="total_receipt_val"><?= ($details && $details->total_receipted_val>0)?getFieldVal('total_receipted_val',$details):0 ?></span>
                            </th>
                          </tr>
                    </tfoot>
                    <?php } ?>   
                </table>
                  </div>
                 </div>
               
              <!-- /.box-body -->  
              
              
              
            </div> 
              
              </div>
              <!-- /.box-body -->
              
           
             </div> 
              
            <?= form_close() ?>
              
          </div>
            <!-- /.box-body --> 
             </section>
          </div>

          <!-- /.box -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
   
    <!-- /.content -->
  </div>

<?= $footer_start ?>
<!-- Add aditional js script & files -->
<script src="<?= $JS_DIR ?>goodreceipt.js" type="text/javascript"></script>

<!-- End js script -->
<?= $footer_end ?>