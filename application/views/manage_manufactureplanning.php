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
              <div class="col-sm-6 p-0"><h2 class="box-title">Manage <?= $heading ?></h2></div>
              <div class="col-sm-6 text-right">
                <?php if(checkModulePermission(22,2)){ ?>
                  <a href="<?= $main_page ?>/addedit" class="btn btn-primary">Add <?= $heading ?></a>
                <?php } ?>
                <?php if(checkModulePermission(22,4)){ ?>
                  <a href="javascript:;" class="btn btn-danger" onclick="return deleterecord();">Delete</a>
                <?php } ?>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             <div class="col-sm-6 col-sm-offset-2"><?= getFlashMsg('success_message'); ?></div>
                <div class="clearfix"></div>
                
              <?= form_open('', 'class="tableForm form-horizontal" id="tableForm"'); ?>
              <input type="hidden" name="bulk_action" value="1">
              <div class="table-responsive">
              <table id="mytable" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <?php if(checkModulePermission(22,4)){ ?>
                    <th  class="nosort width-20 p-r-0"><input type="checkbox" id="checkAll"> </th>
                  <?php } ?>
					<th>Date</th>
					<th>Manufacture Planning ID</th>
					<th>Product Name</th>
					<th>Total Stock</th>
					<th>Issued Stock</th>
					<th  class="nosort p-r-0 t-c" style="display:none">Action</th>
                </tr>
                </thead>
                <tbody></tbody>
               
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
<script src="<?= $COMP_DIR ?>datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= $COMP_DIR ?>datatables-bs/js/dataTables.bootstrap.min.js"></script>


    <script>
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

<!-- End js script -->
<?= $footer_end ?>