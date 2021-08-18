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
              <div class="col-sm-6 p-0"><h2 class="box-title"><?= $heading ?> Bom</h2></div>
              <div class="col-sm-6 text-right">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?= form_open('', 'class="tableForm form-horizontal" id="tableForm"'); ?>
              <div class="table-responsive">
              <table id="mytable" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Title</th>
                  <th>Total Parts</th>
                  <?php if(checkModulePermission(8,5)){ ?>
                  <th>Total Cost</th>
                  <?php } ?>
                  <th>Status</th>
                  <th>Creation Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                 if($bomList){
                  foreach ($bomList as  $value){
                    $ID=$value->ID;?>
                 <tr>
                  <td><a data-toggle="modal" data-target=".bs-example-modal-lg2" href=""  onclick="bom_modal(<?= $ID ?>);" data-toggle="modal" data-target="#myModal"><?= $value->title ?></a></td>
                  <td><?= $value->total_parts ?></td>
                  <?php if(checkModulePermission(8,5)){ ?>
                  <td><?= $value->total_cost ?></td>
                  <?php } ?>
                  <td><?= ($value->status==1)?'Active':'Deactive';?></td>
                  <td><?= dateFormate($value->creation_date,"m/d/Y") ?></td>
                </tr>
                 <?php }} ?>
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
     <!-- Modal -->
 <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="static">
                                 
 </div>
  </div>

<?= $footer_start ?>
<!-- Add aditional js script & files -->
    <script>
        $(document).ready(function() {
            $('#mytable').DataTable({
                "lengthMenu": [[50, -1], [50, "All"]]
            });
        });
    </script>

    <script>
$(document).ready(function() { 
  $(".modal").on("hidden.bs.modal", function() { 
    $(".bs-example-modal-lg2").html(""); 
  });
});

  function bom_modal(bom_id='') { //alert(case_id);
 
   $.ajax({
  type: "POST",
  url: "<?php  echo base_url('ajax/bom_modal') ?>",
  data:{bom_id:bom_id},
  
  success: function(data){ //alert(data);
    
    $(".bs-example-modal-lg2").html(data);
  
  }
  });
}
</script> 
<script src="<?= $COMP_DIR ?>datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= $COMP_DIR ?>datatables-bs/js/dataTables.bootstrap.min.js"></script>



<!-- End js script -->
<?= $footer_end ?>