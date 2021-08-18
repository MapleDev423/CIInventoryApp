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
                 <?php if(checkModulePermission(5,2)){ ?>
                  <a href="<?= $main_page ?>/addedit" class="btn btn-primary">Add <?= $heading ?></a>
                  <?php } ?>
                   <?php if(checkModulePermission(5,4)){ ?>
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
                  <?php if(checkModulePermission(5,4)){ ?>
                  <th  class="nosort width-20 p-r-0"><input type="checkbox" id="checkAll"> </th>
                  <?php } ?>
                  <th>Image</th>
                  <th>Item Number</th>
                  <th>Name</th>
                  <th>Manufacturer</th>
                  <!--<?php if(checkModulePermission(5,5)){ ?>
                  <th>Price</th>
                  <?php } ?>
                  <th>Creation Date</th>
                  <th  class="nosort p-r-0">Action</th>-->
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
               <tr <?php if(checkModulePermission(5,2)){ ?> class='clickable-row' data-href="<?= $main_page ?>/addedit/<?= md5($ID) ?>" <?php }?> style="cursor:pointer;">
                <?php if(checkModulePermission(5,4)){ ?>
                  <td><input type="checkbox" class="checkboxitem" value="<?= $ID ?>" name="item_ids[]"> </td>
                  <?php } ?>
                  <td><img src="<?= ($value->parts_image!='')?'https://'.$this->config->item('BUCKETNAME').'.'.$this->config->item('REGION').'.'.$this->config->item('HOST').'/'.$value->parts_image:$this->config->item('PARTS_DATA_DISP').'not-available.jpg'; ?>" alt="Parts image" style="height: 100px;width:100px"></td>
                  <td><?= $value->name; ?></td>
                  <td><?= $value->description; ?></td>
                  <td><?= $value->manufact; ?></td>
                  
                     <!-- <?php if(checkModulePermission(5,5)){ ?>
                  <td><?= $value->price ?></td>
                  <?php } ?>
                  <td><?= dateFormate($value->creation_date,"m/d/Y") ?></td>
                  <td class="action">
                        <?php if(checkModulePermission(5,2)){ ?>
                          <a href="<?= $main_page ?>/addedit/<?= md5($ID) ?>" title="Edit">
                              <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                            </a>
                        <?php } ?>
                        <?php if(checkModulePermission(5,3)){ ?>
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
                         <?php if(checkModulePermission(5,4)){ ?>   
                            <a href="javascript:;" title="Delete" onclick="singleAction(<?= $delete ?>)">
                              <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                            </a>
                          <?php } ?>
                     
                  </td>-->
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
  //dataTable();
$(document).ready(function() {
    $('#mytable').DataTable( {
        "dom": 'l<"toolbar">frtip',
        "lengthMenu": [[50, -1], [50, "All"]]
    } );
    
    var manufact='<select class="form-control column_filter" name="manufacturer" id="manufacturer" data-placeholder="Select manufacturers"><option value="">Filter By Manufacturer</option>';
    var option = '';
                     <?php if(!empty($manufacturer)){foreach($manufacturer as $value){?>    
                        option +='<option value="<?= $value->name ?>"><?= $value->name ?></option>'
                     <?php }}?>  
                    var lastselect= '</select>';
 
    $("div.toolbar").html(manufact+option+lastselect);
    
    $('select.column_filter').on('change', function () {
        filterColumn(4);
    } );
    
} );

    

$('.clickable-row').each(function () {
    $(this).children('td:not(:first)').click(function () {
        window.location = $(this).closest('tr').data('href');
        return false;
    });
});

function filterColumn ( i ) {
   // alert(i);
    $('#mytable').DataTable().column( i ).search(
        $('#manufacturer').val()
    ).draw();
}

</script>
<style>.toolbar{float: right; margin-left: 5px;margin-top: -35px;} #mytable_filter{margin-right: 200px;margin-top: -32px;} #mytable_filter label{float: none;}</style>

<!-- End js script -->
<?= $footer_end ?>