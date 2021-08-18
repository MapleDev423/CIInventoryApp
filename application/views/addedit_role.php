<?= $header_start ?>

<!-- Add aditional CSS script & Files -->

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
              <div class="col-sm-6 p-0"><h2 class="box-title"> <?= $mode.' '.$heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
              <div class="box-body">
              <?php $ID= (isset($details->ID))?$details->ID:""; ?>
              <input type="hidden" name="ID" value="<?= $ID ?>">
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title<span class="req">*</span></label>

                  <div class="col-sm-6">
                    <input class="form-control required" id="title" placeholder="Enter title" type="text" name="title" value="<?= getFieldVal('title',$details) ?>">
                    <span class="error"><?= getFlashMsg('title_exist'); ?></span>
                  </div>
                </div>
                <div class="col-sm-11 ">


                <?php 
                    $event_ids_arr=getFieldVal('event_ids',$details);
                    // print_r($event_ids_arr); die;
                ?>
                    <a href="../models/Role_model.php"></a>
                    <a href="../controllers/Role.php"></a>

                  <h4> <strong>Module Permission</strong> </h4>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Module Name</th>
                          <th>
                            <div class="checkbox">
                              <label><input type="checkbox" id="checkAll" value=""> <strong>All</strong> </label>
                            </div>
                          </th>
                          <th>View</th>
                          <th>Add/Edit</th>
                          <th>Status Change</th>
                          <th>Delete</th>
                          <th>Show Price</th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php 
                     $childarray=array();
					 if(count($MODULE_LIST)>0){
                     foreach ($MODULE_LIST as  $value) { 
                    if($value->childlist && count($value->childlist)>0){
                    foreach($value->childlist as $key => $values){
                        $childarray[]=$values->parent_id;
                    }}
                 
                  if(!in_array($value->ID,$childarray)){ ?>
                                
                        <tr>
                          <td><?= $value->title ?></td>
                          <td><input type="checkbox" class="events checkAllSub" value="<?= $value->ID ?>"></td>
                          <td><input type="checkbox" class="events action action_<?= $value->ID ?>" data-id="<?= $value->ID ?>" value="1" name='event_ids[<?= $value->ID ?>][]'  <?= (isset($event_ids_arr[$value->ID]) && in_array(1, $event_ids_arr[$value->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $value->ID ?>"  data-id="<?= $value->ID ?>" value="2" name='event_ids[<?= $value->ID ?>][]' <?= (isset($event_ids_arr[$value->ID]) && in_array(2, $event_ids_arr[$value->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $value->ID ?>"  data-id="<?= $value->ID ?>" value="3" name='event_ids[<?= $value->ID ?>][]' <?= (isset($event_ids_arr[$value->ID]) && in_array(3, $event_ids_arr[$value->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $value->ID ?>"  data-id="<?= $value->ID ?>" value="4" name='event_ids[<?= $value->ID ?>][]' <?= (isset($event_ids_arr[$value->ID]) && in_array(4, $event_ids_arr[$value->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $value->ID ?>"  data-id="<?= $value->ID ?>" value="5" name='event_ids[<?= $value->ID ?>][]' <?= (isset($event_ids_arr[$value->ID]) && in_array(5, $event_ids_arr[$value->ID]))?'checked':''; ?> ></td>
                        </tr>

                  <?php  }else{?>
                          <tr>
                              <td colspan="7"><b><?= $value->title ?></b></td>
                          </tr>      
                        <?php        
                    }
                            foreach($value->childlist as $key => $SubValue){ ?>
                            <tr>
                          <td><?= $SubValue->title ?></td>
                          <td><input type="checkbox" class="events checkAllSub" value="<?= $SubValue->ID ?>"></td>
                          <td><input type="checkbox" class="events action action_<?= $SubValue->ID ?>" data-id="<?= $SubValue->ID ?>" value="1" name='event_ids[<?= $SubValue->ID ?>][]'  <?= (isset($event_ids_arr[$SubValue->ID]) && in_array(1, $event_ids_arr[$SubValue->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $SubValue->ID ?>"  data-id="<?= $SubValue->ID ?>" value="2" name='event_ids[<?= $SubValue->ID ?>][]' <?= (isset($event_ids_arr[$SubValue->ID]) && in_array(2, $event_ids_arr[$SubValue->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $SubValue->ID ?>"  data-id="<?= $SubValue->ID ?>" value="3" name='event_ids[<?= $SubValue->ID ?>][]' <?= (isset($event_ids_arr[$SubValue->ID]) && in_array(3, $event_ids_arr[$SubValue->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $SubValue->ID ?>"  data-id="<?= $SubValue->ID ?>" value="4" name='event_ids[<?= $SubValue->ID ?>][]' <?= (isset($event_ids_arr[$SubValue->ID]) && in_array(4, $event_ids_arr[$SubValue->ID]))?'checked':''; ?> ></td>
                          <td><input type="checkbox" class="events action action_<?= $SubValue->ID ?>"  data-id="<?= $SubValue->ID ?>" value="5" name='event_ids[<?= $SubValue->ID ?>][]' <?= (isset($event_ids_arr[$SubValue->ID]) && in_array(5, $event_ids_arr[$SubValue->ID]))?'checked':''; ?> ></td>
                        </tr> 
                            
                        <?php }?>
                        
                        <?php } } ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="box-footer text-center">
                  <button type="submit" class="btn btn-primary m-r-20">Submit</button>
                  <a href="<?= $main_page ?>" class="btn btn-danger">Cancel</a>
                </div>
              </div>
              <!-- /.box-body -->
            <?= form_close() ?>
              
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<?= $footer_start ?>
<!-- Add aditional js script & files -->

<script>
validate_form();
$("#checkAll").click(function(){
      $('.events').not(this).prop('checked', this.checked);
  });
$(".checkAllSub").click(function(){
    var obj = $(this).parent().parent();
      obj.find('.action').not(this).prop('checked', this.checked);
      $("#checkAll").prop('checked',false);
      checkall();
  });

$(".action").click(function(){
      var obj = $(this).parent().parent(); 
      var data_id=$(this).attr('data-id');
      obj.find('.checkAllSub').prop('checked',false);
      $("#checkAll").prop('checked',false);
       checkallSub(data_id,obj);
      checkall();
  });
  
  function checkallSub(data_id,obj) {
   if ($('.action_'+data_id+':checked').length == $('.action_'+data_id).length) {
        obj.find('.checkAllSub').prop('checked',true);
      }
  }

  function checkall() {
   if ($('.action:checked').length == $('.action').length) {
       $("#checkAll").prop('checked',true);
    }
  }


  <?php if($_POST || $ID!=''){ ?>
  $( ".action" ).each(function() { 
      var obj = $(this).parent().parent(); 
      var data_id=$(this).attr('data-id'); //alert(data_id);
      obj.find('.checkAllSub').prop('checked',false);
      $("#checkAll").prop('checked',false);
       checkallSub(data_id,obj);
      checkall();
  });
  <?php } ?>
</script>

<!-- End js script -->
<?= $footer_end ?>