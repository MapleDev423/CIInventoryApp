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
                <?php if(checkModulePermission(8,2)){ ?>
                  <a href="<?= $main_page ?>/addedit" class="btn btn-primary">Add <?= $heading ?></a>
                <?php } ?>
                <?php if(checkModulePermission(8,4)){ ?>
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
                <?php if(checkModulePermission(8,4)){ ?>
                  <th  class="nosort width-20 p-r-0"><input type="checkbox" id="checkAll"> </th>
                <?php } ?>
                  <th>Title</th>
                  <th>Product</th>
                  <th>Total Parts</th>
                  <?php if(checkModulePermission(8,5)){ ?>
                  <th>Total Cost</th>
                  <?php } ?>
                  <th>Creation Date</th>
                  <th  class="nosort p-r-0">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if($resultList){
                  foreach ($resultList as  $value) {
                    $ID=$value->ID;
                    $status_val=$value->status;
                    if($status_val==1){
                      $status=singleAction('deactive','',$ID);                       
                    }else{
                      $status=singleAction('active','',$ID);                     
                    }
                    
                    $delete=singleAction('delete','',$ID); 
                    ?>

                <tr>
                <?php if(checkModulePermission(8,4)){ ?>
                  <th><input type="checkbox" class="checkboxitem" value="<?= $ID ?>" name="item_ids[]"> </th>
                  <?php } ?>
                  <td><a data-toggle="modal" data-target=".bs-example-modal-lg2" href=""  onclick="bom_modal(<?= $ID ?>);" data-toggle="modal" data-target="#myModal"><?= $value->title; ?></a></td>
                  <td><?= $value->product_id_val.' - '.$value->product_name ?></td>
                  <td><?= $value->total_parts ?></td>
                  <?php if(checkModulePermission(8,5)){ ?>
                  <td><?= $value->total_cost ?></td>
                  <?php } ?>
                  <td><?= dateFormate($value->creation_date,"m/d/Y") ?></td>
                  <td class="action">
                          <?php if(checkModulePermission(8,2)){ ?>
                            <a href="<?= $main_page ?>/addedit/<?= md5($ID) ?>" title="Edit">
                              <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                            </a>
                            <?php } ?>

                            <?php if(checkModulePermission(8,3)){ ?>
                              <?php if($status_val==1){?>
                              <a href="javascript:;" title="Active" onclick="singleAction(<?= $status ?>)">
                                <i class="fa fa-check-circle icon active " aria-hidden="true"></i>
                              </a>
                              <?php }else{ ?>
                                <a href="javascript:;" title="Deactive" onclick="singleAction(<?= $status ?>)">
                                <i class="fa fa-ban icon deactive" aria-hidden="true"></i>
                              </a>
                              <?php } ?>
                            <?php } ?>
                            <?php if(checkModulePermission(8,4)){ ?>
                              <a href="javascript:;" title="Delete" onclick="singleAction(<?= $delete ?>)">
                                <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                              </a>
                            <?php } ?>
                     
                  </td>
                </tr>
                <?php
                  }
                }
                  
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
 <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="static">
                                 
 </div>
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



<!-- End js script -->
<?= $footer_end ?>