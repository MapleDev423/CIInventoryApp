<?= $header_start ?>

<!-- Add aditional CSS script & Files -->
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
              <div class="col-sm-6 p-0"><h2 class="box-title"><?= $heading ?></h2></div>
              <div class="col-sm-6 text-right"> </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <div class="col-sm-6 col-sm-offset-2"><?= getFlashMsg('success_message'); ?></div>
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
		
		<div class="col-sm-2 col-sm-2 col-xs-12">
				<label>&nbsp;</label>
				<div>
				<input type="button" id="excel" name="excel" class="btn btn-info no-print" value="Genrate excel">
				</div>
		</div>	
		</div>	
		</div>	
		<div class="clearfix"></div>
			  
		  <div class="table-responsive" style="overflow-x:auto;margin-top:20px;">
              <table id="mytable" class="table table-bordered table-hover text-center" >
                  
                <thead>
                <tr>        
					<th>Item Number</th>
					<th>Item Name</th>
					<th>Manufacturer</th>
					<th>Color</th>
					<th>Current Stock</th>
                </tr>
                </thead>
                
                <tbody>
                <?php
					if($resultList){
					foreach ($resultList as  $value) {
                ?>
			       <tr>
					<td class="name"><?= $value->name; ?></td> 
					<td><?= ($value->description!='')?$value->description:"N/A"; ?></td> 
					<td class="manufact"><?= $value->manufact; ?></td>
					<td><?= $value->part_colors; ?></td>
					<td><?=$total=($value->issuestock!='')?number_format((float)($value->total_receipted-$value->issuestock), 2, '.', ''):$value->total_receipted; ?></td>
				</tr>
			
                <?php
                  }}
                ?>
               </tbody>
                   <tfoot style="font-weight:bold;">
			            <tr>
							<td colspan="4" style="text-align:right">Page Total :</td>
							<td><span></span><span id="page_total"></span></td>
			            </tr>
						 <tr>
							<td colspan="4" style="text-align:right">Grand Total :</td>
							<td><span></span><span id="grand_total"></span></td>
			            </tr>
		        	</tfoot>
              </table>
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
</script>


<script>
$('#mytable').DataTable( {
		"paging":true,
        "lengthMenu": [[50, -1], [50, "All"]],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };		
			// Pending Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Pending Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
			// Update footer
			
			$('#page_total').html(pageTotal.toFixed(2));	
			$('#grand_total').html(total.toFixed(2));
        }
    } );
</script>



<script>
$(document).ready(function() {
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
	tableForm.submit();
});

$("#excel").on("click", function(){ 
	$("#tableForm").attr('action', 'csv_for_current_stock_report');
	tableForm.submit();
});

$(document).on('click','.from_date,.to_date,.manufacturer_id,.parts_id',function(){
		$("#excel").css("display","none");
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
