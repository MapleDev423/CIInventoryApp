<?= $header_start ?>

<!-- Add aditional CSS script & Files -->
 <link rel="stylesheet" href="<?= $COMP_DIR ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= $COMP_DIR ?>datatables-bs/css/dataTables.bootstrap.min.css">

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
              <div class="col-sm-6 p-0"><h2 class="box-title"> <?= $heading ?></h2></div>
              <div class="col-sm-6 text-right"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="col-sm-6 col-sm-offset-2"></div>
                <div class="clearfix"></div>
                
              <?= form_open('', 'class="tableForm form-horizontal" id="tableForm"'); ?>
			<div class="row">
			<div class="col-sm-12">    
			
			<div class="col-md-3 col-sm-3 col-xs-6  text-center">
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
			
			<div class="col-md-3 col-sm-3 col-xs-6  text-center">
				<label for="parts_id" >Part Name</label>
				<select name="parts_id" id="parts_id" class="form-control parts_id">
						<option value="">Select Part Name</option>
						<?php if(!empty($part_details)) { ?>
						  <?php foreach($part_details as $part_detail) {?>
							<option value="<?= $part_detail->parts_id;?>"  <?=(set_value('parts_id')==$part_detail->parts_id)?'selected':''?>><?= $part_detail->name;?></option>
						  <?php } ?>
						<?php } ?>
				</select>  
			</div>
			
			<div class="col-md-3 col-sm-3 col-xs-6  text-center">
				<label>From Date</label>
				<input type="text" id="from_date" name="from_date" class="form-control from_date" data-field="Date" placeholder="dd/mm/yyyy" value="<?=  set_value('from_date');?>" aria-invalid="false" autocomplete="off">
			</div>
			
			<div class="col-md-3 col-sm-3 col-xs-6  text-center">
				<label>To Date</label>
				<input type="text" id="to_date" name="to_date" class="form-control to_date" data-field="Date" placeholder="dd/mm/yyyy" value="<?=  set_value('to_date');?>" aria-invalid="false" autocomplete="off">
			</div>
				
		</div>
		
		<div class="col-sm-12">
		<div class="col-sm-6 col-sm-6 col-xs-12">
				<label>&nbsp;</label>
				<div>
				<input type="button" id="search" name="search" class=" btn btn-info" value="Search">
				<input type="button" id="reset_text" name="reset_text" class=" btn btn-danger" value="Reset">
				</div>
			</div>
		</div>	
			<div class="clearfix"></div>
			
			<div class="col-md-12" style="overflow-x:auto;margin-top:20px;">
              <table id="mytable" class="table table-bordered table-hover" >
               <thead>
                            <tr>
								<th class="addIcon">Goods Receipt Date</th>
								<th class="text-center">Manufacturer</th>
                                <th class="text-center">Item Number</th>
                                <th class="text-center">Item Color</th>
                                <th class="text-center">Item Image</th>
                                <th class="text-center">CS Pack</th>
								<!--
								<th class="addIcon">Previous Received</th>
								<th class="addIcon">Pending CS Pack</th>
								-->
                                <th class="addIcon">Received CS Pack</th>
							</tr>
                    </thead>
                    <?php if(!empty($details)){?>
                    
                      <tbody id="addCont">
                        <?php if(  isset($details) && count($details)>0){$i= count($details);
                            foreach ($details as $partsData) { 
                        ?>
                        <tr class="radius sResult<?= $pi_no; ?>">
							<td><?= dateFormate($partsData->receipt_date,"m/d/Y");?></td>
                            <td><?=$partsData->manufacturer;?></td>
							<td><?=$partsData->part_name;?></td>
                            <td><?=$partsData->part_colors;?></td>
                            <td>
                                <div class="parts_img text-center" >
                                    <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                </div>
                            </td>
							<td><?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):0 ?></td>
                           <!--
						   <td><?= (getFieldVal('total_received',$partsData)>0)?getFieldVal('total_received',$partsData):0 ?></td>
						   <td><?= (getFieldVal('total_pending',$partsData)>0)?getFieldVal('total_pending',$partsData):0 ?></td>
						   -->
						   <td><?= ($partsData && $partsData->total_receipted>0)?getFieldVal('total_receipted',$partsData):0 ?></td>  
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
});
  
$('.clickable-row').each(function () {
    $(this).children('td:not(:first),td:not(:last)').click(function () {
        window.location = $(this).closest('tr').data('href');
        return false;
    });
   
});
</script>



<script> 
    $('#datatable').DataTable({
   'aoColumnDefs': [{
         "orderable": false,
        'bSortable': false,
        'aTargets': ['nosort']
    }]
});
</script>
<script>
$(document).ready(function() {
	$('.from_date').datepicker('setEndDate',  $('.to_date').val());
	$('.to_date').datepicker('setStartDate',  $('.from_date').val());
});
$(".from_date").datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
}).on('changeDate', function (selected) {
    var startDate = new Date(selected.date.valueOf());
    $('.to_date').datepicker('setStartDate', startDate);
}).on('clearDate', function (selected) {
    $('.to_date').datepicker('setStartDate', null);
});

$(".to_date").datepicker({
    format: 'dd-mm-yyyy',
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
	$("#manufacturer_id").val("").change();	
	$("#parts_id").val("").change();	
	$('.from_date').val("");
	$('.to_date').val("");
	tableForm.submit();
});
</script>

<script>

$(document).on('change','.manufacturer_id',function(){
    var manufacturer_id =$(this).val();
     $(".parts_id option").remove();
	 $(".parts_id").append("<option value=''>Select Part Name</option>");
		 
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsnameByManufacturer_for_goodreceiptreport",
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
   
});
</script>




<script>
$("#search").on("click", function(){ 
   var url='<?= base_url() ?>';
   tableForm.submit();
});
</script>




<!-- End js script -->
<?= $footer_end ?>