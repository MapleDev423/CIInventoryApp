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
                <?php if(checkModulePermission(3,2)){ ?>
                  <a href="<?= $main_page ?>/addedit" class="btn btn-primary">Add Role</a>
                <?php } ?>
                <?php if(checkModulePermission(3,4)){ ?>
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
                <?php if(checkModulePermission(3,4)){ ?>
                  <th  class="nosort width-20 p-r-0"><input type="checkbox" id="checkAll"> </th>
                <?php } ?>
                  <th>Title</th>
                  <th>Creation Date</th>
                  <th  class="nosort p-r-0 t-c">Action</th>
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
                      <?php if(checkModulePermission(3,4)){ ?>
                        <th><input type="checkbox" class="checkboxitem" value="<?= ($value->can_delete==1)?$ID:'' ?>" name="item_ids[]"> </th>
                      <?php } ?>
                        <td><?= $value->title ?></td>
                        <td><?= dateFormate($value->creation_date,"m/d/Y") ?></td>
                        <td class="action  t-c">
                          <?php if(checkModulePermission(3,2)){ ?>
                            <a href="<?= $main_page ?>/addedit/<?= md5($ID) ?>" title="Edit">
                              <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                            </a>
                          <?php } ?>
                          <?php if(checkModulePermission(3,3)){ ?>
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
                          <?php if(checkModulePermission(3,4)){ ?>
  
                            <?php if($value->can_delete==0){ ?>
                                <a href="javascript:;" title="Delete" onclick=" alert('You can\'t able to delete the selected role, because this role is assigned to employees, so please first change the employees role then you will able to delete the selected role.') ;">
                                  <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                                </a>
                            <?php }else{ ?>
                                <a href="javascript:;" title="Delete" onclick="singleAction(<?= $delete ?>)">
                                  <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                                </a>
                            <?php }  ?>
                            
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

<!-- End js script -->
<?= $footer_end ?>