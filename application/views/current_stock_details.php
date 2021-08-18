<!--
<style>

.modal-body, #table_data tbody {
display:block;
max-height:330px;
overflow-y:scroll;
}
.modal-body, #table_data thead, tbody tr {
display:table !important;
width:100%;
table-layout:fixed;
}
.modal-body, #table_data thead, tfoot tr {
display:table !important;
width:100%;
table-layout:fixed;
}
</style>
-->

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:80%">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #3c8dbc;color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" ><?= $heading;?></h4> <!--Modal Header-->
        </div>
        <div class="modal-body">
		<div class="row"> 
		<div class="col-sm-12 col-md-12 col-xl-12">
		 <div class="form-group">
		  <label for="item_no" class="col-sm-2 control-label text-right">Item Number :</label>
          <div class="col-md-8"><span><?=$name;?></span></div>
		  </div>
		</div>

		<div class="col-sm-12 col-md-12 col-xl-12">
			<div class="form-group">
			<label for="item_no" class="col-sm-2 control-label text-right">Manufacturer :</label>
			<div class="col-md-8"><span><?=$manufact;?></span></div>
		</div>
	
	<table class="table table-border text-center" id="table_data">     
		<thead style="display:table !important;width:100%;table-layout:fixed;">
                <tr>        
					<th>Color</th>
					<th>Image</th>
					<th>Case Pack</th>
                </tr>
        </thead>
                
        <tbody style="display:block;max-height:330px;overflow-y:scroll;">
                <?php
					$grand_total=0.00;
					if($resultList){
					foreach ($resultList as  $value) {
                ?>                       
				<tr style="display:table !important;width:100%;table-layout:fixed;">
					<td><?= $value->part_colors; ?></td>
					<td>
					 <div class="parts_img text-center" >
                        <img src="<?= $value->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                     </div>
					</td>
					<td><?=  ($value->issuestock!='')?$total=number_format((float)($value->total_receipted-$value->issuestock), 2, '.', ''):$total=$value->total_receipted; ?></td>
				</tr>
	
                <?php
				$grand_total+=$total;
                  }}
                ?>
        </tbody>
		<tfoot style="display:table !important;width:100%;table-layout:fixed;">
				<tr>
				<td></td>
				<td><b>Total Case Pack</b> </td>
				<td><?=$grand_total;?></td>
				</tr>
		</tfoot>
        </table>        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
		
		</div>
      </div>
      
    </div>
  </div>
  </div>
   <!-- Modal Close--> 
  

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/components/bootstrap/dist/js/bootstrap.min.js"></script>


<style>
.addIconpart{text-align: center;}.error_field {
	border: 1px solid #FF3F3F !important;
}
</style>

