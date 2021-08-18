<?= $header_start ?>

<!-- Add aditional CSS script & Files -->
 <link rel="stylesheet" href="<?= $COMP_DIR ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= $COMP_DIR ?>datatables-bs/css/dataTables.bootstrap.min.css">

<!-- End css script -->

<?= $header_end ?>
<?= $menu ?>

<style>
@media print
{    
    .print_div {
      display: block !important;
    }  
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
<div class="content-wrapper">
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="col-sm-6 p-0"><h2 class="box-title"> <?= $heading ?></h2></div>
              <div class="col-sm-6 text-right"> 
			  <a  href="javascript:void(0)" class="btn btn-info no-print" id="Print" onclick="window.print()">Print</a></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="col-sm-6 col-sm-offset-2"></div>
                <div class="clearfix"></div>
                
              <?= form_open('', 'class="tableForm form-horizontal" id="tableForm"'); ?>
			<div class="row">
			<div class="col-sm-12 no-print">    
			
			<div class="col-md-2 col-sm-2 col-xs-6">
				<label>From Date</label>
				<input type="text" id="from_date" name="from_date" class="form-control from_date" data-field="Date" placeholder="mm/dd/yyyy" value="<?=  set_value('from_date');?>" aria-invalid="false" autocomplete="off">
			</div>
			
			<div class="col-md-2 col-sm-2 col-xs-6">
				<label>To Date</label>
				<input type="text" id="to_date" name="to_date" class="form-control to_date" data-field="Date" placeholder="mm/dd/yyyy" value="<?=  set_value('to_date');?>" aria-invalid="false" autocomplete="off">
			</div>
			
			<div class="col-md-2 col-sm-2 col-xs-6">
				<label for="parts_id" >Transaction Type</label>
				<select name="process" id="process" class="form-control process">
				<option value="">Select Transaction Type</option>
				<option value="Goods Receipt" <?=(set_value('process')=='Goods Receipt')?'selected':''?>>Goods Receipt</option>
				<option value="Stock Issue" <?=(set_value('process')=='Stock Issue')?'selected':''?>>Stock Issue</option>
				</select>  
			</div>
				
			<div class="col-md-2 col-sm-2 col-xs-6">
				<label for="manufacturer_id" >Manufacturer</label>
				<select name="manufacturer_id" id="manufacturer_id" class="form-control manufacturer_id">
						<option value="">Select Manufacturer</option>
						<?php if(!empty($manufacturer)) { ?>
						  <?php foreach($manufacturer as $manufact) {?>
							<option value="<?= $manufact->ID;?>"  <?=(set_value('manufacturer_id')==$manufact->ID)?'selected':''?>><?= $manufact->name;?></option>
						  <?php } ?>
						<?php } ?>
				</select>  
			</div>
			
			<div class="col-md-2 col-sm-2 col-xs-6">
				<label for="parts_id" >Item Number</label>
				<select name="parts_id" id="parts_id" class="form-control parts_id">
						<option value="">Select Item Number</option>
						<?php //if(!empty($part_details)) { ?>
						  <?php //foreach($part_details as $part_detail) {$part_detail->parts_id;$part_detail->name;?>
						  <?php //} ?>
						<?php //} ?>
				</select>  
			</div>
				
		<div class="col-sm-2 col-sm-2 col-xs-12">
				<label>&nbsp;</label>
				<div>
				<input type="button" id="search" name="search" class="btn btn-success no-print" value="Search">
				<input type="button" id="reset_text" name="reset_text" class="btn btn-danger no-print" value="Reset">
				</div>
			</div>
		</div>	
		</div>	
			<div class="clearfix"></div>
			
			<div class="col-md-12 no-print" style="overflow-x:auto;margin-top:20px;">
              <table id="mytable" class="table table-bordered table-hover" >
               <thead>
                            <tr>
								<th class="addIcon">Date</th>
								<th class="text-center">Type</th>
								<th class="text-center">Reference No</th>
								<th class="text-center">PI No.</th>
								<th class="text-center">Employee Name</th>
								<th class="text-center">Manufacturer</th>
                                <th class="text-center">Item Number</th>
                                <th class="text-center">Item Color</th>
                                <th class="text-center">Item Image</th>
								<th class="text-center">Case Stock</th>
                                <th class="text-center">Net Stock</th>
								
                            </tr>
                    </thead>
                    <?php if(!empty($details)){?>
                    
                      <tbody id="addCont">
                        <?php if(  isset($details) && count($details)>0){$i= count($details);
                            foreach ($details as $partsData) { 
                        ?>
                        <tr class="radius sResult">
							<td><?= $partsData->ledger_date;?></td>
							<td><?=$partsData->process;?></td>
                            <td><?=$partsData->reference_no;?></td>
							<td><?=$partsData->invoiceid;?></td>
							<td><?=$partsData->employee_name;?></td>
							<td><?=$partsData->manufacturer;?></td>
							<td><?=$partsData->part_name;?></td>
                            <td><?=$partsData->part_colors;?></td>
                            <td>
                                <div class="parts_img text-center" >
                                    <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                </div>
                            </td>
							<td><?=($partsData->process=='Goods Receipt')?'+'.$partsData->effected_stock:'-'.$partsData->effected_stock;?></td>  
							<td><?=$partsData->current_stock;?></td>
						</tr>	
					<?php $i--;} }}?>
                    </tbody>
              </table>
              </div>
	  
			  
			  <div class="col-md-12" style="overflow-x:auto;margin-top:20px;">
              <table id="datatable" class="table table-bordered table-hover print_div" style="display:none">
               <thead>
                            <tr>
								<th class="addIcon">Date</th>
								<th class="text-center">Type</th>
								<th class="text-center">Reference No</th>
								<th class="text-center">PI No.</th>
								<th class="text-center">Employee Name</th>
								<th class="text-center">Manufacturer</th>
                                <th class="text-center">Item Number</th>
                                <th class="text-center">Item Color</th>
                                <th class="text-center">Item Image</th>
								<th class="text-center">Case Stock</th>
                                <th class="text-center">Net Stock</th>
								
                            </tr>
                    </thead>
                    <?php if(!empty($details)){?>
                    
                      <tbody id="addCont">
                        <?php if(  isset($details) && count($details)>0){$i= count($details);
                            foreach ($details as $partsData) { 
                        ?>
                        <tr class="radius sResult">
							<td><?= dateFormate($partsData->ledger_date,"m/d/Y");?></td>
							<td><?=$partsData->process;?></td>
                            <td><?=$partsData->reference_no;?></td>
							<td><?=$partsData->invoiceid;?></td>
							<td><?=$partsData->employee_name;?></td>
							<td><?=$partsData->manufacturer;?></td>
							<td><?=$partsData->part_name;?></td>
                            <td><?=$partsData->part_colors;?></td>
                            <td>
                                <div class="parts_img text-center" >
                                    <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                </div>
                            </td>
							<td><?=($partsData->process=='Goods Receipt')?'+'.$partsData->effected_stock:'-'.$partsData->effected_stock;?></td>  
							<td><?=$partsData->current_stock;?></td>
						</tr>	
					<?php $i--;} }}?>
                    </tbody>
              </table>
              </div>
			  
			  
			  
			  
			</div>  
              <?= form_close() ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<?= $footer_start ?>
<!-- Add aditional js script & files -->
<script src="<?= $COMP_DIR ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $COMP_DIR ?>datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= $COMP_DIR ?>datatables-bs/js/dataTables.bootstrap.min.js"></script>
<script>
var AJAX_URL='<?= base_url('ajax/') ?>';

$(document).ready(function() {
        $('#mytable').DataTable({
            "lengthMenu": [[50, -1], [50, "All"]]
        });

	$('.from_date').datepicker('setEndDate',  $('.to_date').val());
	$('.to_date').datepicker('setStartDate',  $('.from_date').val());
});

$(".from_date").datepicker({
    format: 'mm/dd/yyyy',
    autoclose: true,
}).on('changeDate', function (selected) {
    var startDate = new Date(selected.date.valueOf());
    $('.to_date').datepicker('setStartDate', startDate);
}).on('clearDate', function (selected) {
    $('.to_date').datepicker('setStartDate', null);
});

$(".to_date").datepicker({
    format: 'mm/dd/yyyy',
    autoclose: true,
}).on('changeDate', function (selected) {
    var endDate = new Date(selected.date.valueOf());
    $('.from_date').datepicker('setEndDate', endDate);
}).on('clearDate', function (selected) {
    $('.from_date').datepicker('setEndDate', null);
});

</script> 

<script>
$("#reset_text").on("click", function(){ 
	$("#process").val("").change();	
	$("#manufacturer_id").val("").change();	
	$("#parts_id").val("").change();	
	$('.from_date').val("");
	$('.to_date').val("");
	tableForm.submit();
});
</script>

<script>

$(document).on('change','.manufacturer_id',function(){
	getparts_name($(this).val());
});	

function getparts_name(manufacturer_id){
    //var manufacturer_id =$(this).val();
     $(".parts_id option").remove();
	 $(".parts_id").append("<option value=''>Select Part Name</option>");
		 
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsnameByManufacturer_for_stockledgerreport",
            data:{manufacturer_id:manufacturer_id},
            success: function(response){ //alert(response);
                var resultData = JSON.parse(response);
                var partDetails = resultData;
                var reslen=0;
               
                var i=0;

                if(partDetails!=null){
                    reslen= partDetails.length;
                if(reslen>0){

                    for(i=0;i<reslen;i++){ 
                        $(".parts_id").append("<option value='"+partDetails[i].parts_id+"'>"+partDetails[i].name+"</option>");
					}
                }
				}
            }
         }); 
  return; 
}
</script>




<script>
$("#search").on("click", function(){ 
   var url='<?= base_url() ?>';
   tableForm.submit();
});

$(document).ready(function(){
	 getparts_name($('.manufacturer_id').val());
	var partselected="<?php echo set_value('parts_id')?>";
	setTimeout(function(){
	$("#parts_id").val(partselected).change();	
	},500);
	});
</script>




<!-- End js script -->
<?= $footer_end ?>