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
              <input type="hidden" name="bulk_action" value="1">
              <div class="table-responsive">
              <table id="mytable" class="table table-bordered table-hover text-center" >
                  
                <thead>
                <tr>        
                  <th>Item Number</th>
				  <th>Item Name</th>
				  <th>Manufacturer</th>
				  <th>Total Case Pack</th>
                </tr>
                </thead>
                
                <tbody>
                <?php
					if($resultList){
					foreach ($resultList as  $value) { //data-toggle="modal" data-target="#myModal"
                ?>
			       <tr  class="edit_rows" style="cursor: pointer;" >
					<input type="hidden" class="part_id" value="<?= $value->part_id; ?>">
					<td class="name"><?= $value->name; ?></td> 
					<td><?= $value->description; ?></td> 
					<td class="manufact"><?= $value->manufact; ?></td>
					<td><?=($value->issuestock!='')?$total=number_format((float)($value->total_receipted-$value->issuestock), 2, '.', ''):$total=$value->total_receipted; ?></td>
				</tr>
			
                <?php
                  }}
                ?>
               </tbody>
               
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
  <div class="fetch_modal"></div>
<?= $footer_start ?>
<!-- Add aditional js script & files -->
<script src="<?= $COMP_DIR ?>datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= $COMP_DIR ?>datatables-bs/js/dataTables.bootstrap.min.js"></script>
<script>
var AJAX_URL='<?= base_url('ajax/') ?>';
</script>
<script>
  //dataTable();
$(document).on('click','.edit_rows',function(){
    var obj = $(this);
    var part_id =obj.find('.part_id').val();
    var name =obj.find('.name').html();
	var manufact =obj.find('.manufact').html();
	$(".fetch_modal").html('');
        $.ajax({
            type: "POST",
            url: AJAX_URL+"openPartStockDetails",
            data:{part_id:part_id,name:name,manufact:manufact},
             success: function(data){ 	//alert(data);
			$(".fetch_modal").html(data);
			$('#myModal').modal();
            }
         }); 
  
});

  $(document).ready(function() {
      $('#mytable').DataTable({
          "dom": 'l<"toolbar">frtip',
          "lengthMenu": [[50, -1], [50, "All"]]
      });
  });
</script>

<!-- End js script -->
<?= $footer_end ?>