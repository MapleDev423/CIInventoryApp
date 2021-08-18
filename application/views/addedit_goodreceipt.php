<?= $header_start ?>

<!-- Add aditional CSS script & Files -->
 <link rel="stylesheet" href="<?= $COMP_DIR ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

 <style>
    td, th {
	padding: 5px;
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
                <div class="col-sm-6 p-0"><h2 class="box-title"><span class="no-print"> </span><?= $heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="javascript:void(0)" class="btn btn-info Print_page no-print" onclick="window.print();" style="display:none">Print</a>
                  <a href="<?= $main_page ?>" class="btn btn-warning no-print">Back</a>
				   <input type="hidden" id="edit" name="edit" class="edit" value="">
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body" id="box-body">
                  <?= form_open_multipart('', 'class="myform ffform-horizontal" id="grform"'); ?>
		<div class="row">     
		  <div class="col-sm-12">
          <table class="table borderless" >        
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="shipment_id" class="col-sm-4 control-label">Shipments ID <span class="req">*</span></label>
                            <div class="col-sm-8">
                                <select name="shipment_id[]" id="shipment_id" class="shipment_id select2 required " multiple="multiple" data-placeholder="Select Shipments ID" style="width:100%; min-width: 100px; max-height: 30px">
                                    <?php if(!empty($shipmentDetails)) { ?>
                                        <?php foreach($shipmentDetails as $shipment) {?>
                                            <option value="<?= $shipment->ID;?>"><?= $shipment->shipment_id;?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>

                    </td>
                    <td>
                        <div class="form-group">
                         <label for="receipt_date" class="col-sm-3 control-label text-right">Receipt Date<span class="req">*</span></label>
                        <div class="col-sm-8">
							 <input class="form-control required receipt_date futuredatepicker1" id="receipt_date" placeholder="mm/dd/yyyy" type="text" name="receipt_date" value="<?= (isset($details->receipt_date))?date('m/d/Y', strtotime($details->receipt_date)):date('m/d/Y')?>" >
                        </div>
                        </div>  
                    </td>
                </tr>
		
            </table>
                
            </div>
                  
     
<div class="col-sm-12  p-tb-4 m-t-5">
<div style="overflow-x:auto;">
<table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable text-center" style="overflow-x:auto; width:100%">

<thead style="background-color:#C0C0C0;">
<tr>
<th class="text-center">Manufacturer</th>
<th class="text-center">Item Number</th>
<th class="text-center" >Item Color</th>
<th class="text-center">Item Image</th>
<th class="text-center  no-print">CS Pack</th>
<th class="addIcon receipted_td  no-print" style="display:none">Received CS Pack</th>
<th class="addIcon">Pending CS Pack</th>
<th class="addIcon">Receiving CS Pack</th>
</tr>
</thead>
<tbody id="load_goodreceipt"></tbody>
<tfoot>
<tr class="no-print">
<th class="" colspan="4" style="text-align: right;padding-right: 45px;">Total</th>
<th class="text-center">
<input class="form-control total_currentstock_val_hidden text-center numbers  no-print" type="hidden" name="total_currentstock_val" value="<?= ($details && $details->total_currentstock_val>0)?getFieldVal('total_currentstock_val',$details):0 ?>">
<span class="total_currentstock_val">0.00</span>
</th>
<th class="text-center receipted_td  no-print" style="display:none">
<input class="form-control total_receipted_val_hidden text-center numbers" type="hidden" name="total_receipted_val" value="0"> 
<span class="total_receipted_val">0.00</span>
</th>
<th class="text-center">
<input class="form-control total_pending_val_hidden text-center numbers" type="hidden" name="total_pending_val" value="0"> 
<span class="total_pending_val">0.00</span>
</th>
<th class="text-center">
<input class="form-control total_receipt_val_hidden text-center numbers" type="hidden" name="total_receipt_val" value="0">
<span class="total_receipt_val">0.00</span>
</th>

</tr>
</tfoot>
</table>
</div>
</div>

<div class="clearfix"></div><br>

<div class="box-footer text-center">
<div class="col-sm-2"></div> 
<div class="col-sm-8">
<button type="submit" id="savegr" name='savegr' value='savegr' class="btn btn-primary m-r-20 no-print">Save Good Receipt</button>
<button type="submit" id="approvegr" name='savegr' value='approvegr' class="btn btn-success m-r-20 no-print">Approve Good Receipt</button>
<a href="index" class="btn btn-danger  m-r-20 no-print">Cancel</a>
<!-- 
<button type="submit" id="savebackwardpo" class="btn btn-primary" formaction="<?php echo base_url()?>goodreceipt/addedit_backorder_purchaseorder">Create Back Order</button>
-->
</div>
<div class="col-sm-2"></div> 
</div>

			         
              <?= form_close() ?>
               </div> 
              <!-- /.box-body -->
              
           
             </div> 
             
             
             
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
<script src="<?= $JS_DIR ?>goodreceipt.js" type="text/javascript"></script>
<script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.3/select2.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.3/select2.css" rel="stylesheet" />

<script>
var AJAX_URL='<?= base_url('ajax/') ?>';
//validate_form();
 $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    })
	

</script>
<script>
validate_form();
$(function () {

  $('#receipt_date').datepicker({
      autoclose: true
    })

});

</script>
<script>

$(document).on('input', '.number', function(event){
  var intRegex = /^\d+$/;

  var str = $(this).val();// alert(str);
  if(!intRegex.test(str)) { //alert(str);
    $(this).val(str.substring(0, str.length-1));
    //return false;
  }
  if(str==""){
    $(this).addClass('valid_error');
    
  }else{
    $(this).removeClass('valid_error');
  }
});

</script>
<script>
<?php if(isset($details->receipt_date)){
$datearr=explode('/',date('m/d/Y', strtotime($details->receipt_date)));
$year =$datearr[2];
$month =$datearr[0];
$day =$datearr[1];
?>
var month = <?= $month?>;
var day = <?= $day?>;
var year = <?= $year?>;
<?php } else{?>

var date = $("#receipt_date").val();
var d = {"receipt_date": date}
var dt = new Date(d.receipt_date);

var month = dt.getMonth()+1;
var day = dt.getDate();
var year = dt.getFullYear();
//alert(month+"/"+day+"/"+year);
<?php   }
?>
<?php if(isset($details->receipt_date)){?>
var start = new Date("<?= date('m/d/Y', strtotime($details->receipt_date))?>");
var end = new Date(new Date().setYear(start.getFullYear()+1));
<?php } else{?>    
var start = new Date();
var end = new Date(new Date().setYear(start.getFullYear()+1));
<?php } ?>

var start = new Date();
var end = new Date(new Date().setYear(start.getFullYear()+1));   

$('.futuredatepicker1').datepicker({
//startDate : start,
// endDate   : end,
autoclose: true,
todayHighlight: true,
// update "fromDate" defaults whenever "toDate" changes
});
</script>
<style>
.select2-container{width:280px !important;}
</style>
<!-- End js script -->
<?= $footer_end ?>