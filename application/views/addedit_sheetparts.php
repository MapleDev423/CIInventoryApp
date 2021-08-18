
<style>
    #manufacturer-error{margin-left: 18%;}
    #color_ids-error{margin-left: 18%;}
    .bootstrap-tagsinput{width: 500px !important;}
    .twitter-typeahead {
        display: initial !important;
    }
</style> 
<!-- End css script -->
<div class="modal-dialog modal-lg" style="color: #000;">
    <?= form_open_multipart('', 'class="partform form-horizontal" id="partform"'); ?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Quick Edit</h4>
              </div>
              <div class="modal-body">
          
  
            
               <?php $ID= (isset($details->ID))?$details->ID:""; ?>
              <input type="hidden" name="ID" value="<?= $ID ?>">
              <input type="hidden" name="CID" value="<?= $CID ?>">
              <input type="hidden" name="ITEM" value="<?= $ITEM ?>">
             
                  <div class="row">
                  <div class="col-md-6">
                      
                      <div class="form-group">
                  <label for="part_type" class="col-sm-3 control-label">Parts Type</label>

                  <div class="col-sm-9">
                    <select name="part_type" id="part_type" class="form-control">
                      <option value="">Select Parts Type</option>
                      <?php if($partsTypeList){ 
                          foreach ($partsTypeList as $value) {
                            ?>
                              <option value="<?= $value->ID ?>" <?= (getFieldVal('part_type',$details)==$value->ID)?"selected":""; ?>><?= $value->title ?></option>
                            <?php
                          }
                        }
                        ?>     
                        <option value="10000" <?php // (getFieldVal('part_type')==10000 || (isset($details->other_part_type) && $details->other_part_type==1))?"selected":""; ?>>Other</option>                 
                    </select>
                     <input type="text" name="part_type_title" value="<?php //getFieldVal('part_type_title',$details) ?>" class="part_type_title form-control" placeholder="Enter Part Type Title" style="display:none;<?php //(getFieldVal('part_type')==10000 || (isset($details->other_part_type) && $details->other_part_type==1))?'block':'none';  ?> ; margin-top: 10px;">
                     <!--<input type="hidden" name="part_type_other_id" value="<?= getFieldVal('part_type_other_id',$details) ?>">-->
                      <span class="error"><?= getFlashMsg('part_type_title_exist'); ?></span>
                  </div>
                </div>
                       <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Item Number<span class="req">*</span></label>

                  <div class="col-sm-9">
                    <input class="form-control required" id="name" placeholder="Enter parts name" type="text" name="name" value="<?= getFieldVal('name',$details) ?>">
                  </div>
                </div>
                <?php if(checkModulePermission(5,5)){ ?>
                 <div class="form-group">
                  <label for="price" class="col-sm-3 control-label">Price<span class="req">*</span></label>

                  <div class="col-sm-9">
                    <input type="text" name="price" id="partprice" value="<?= getFieldVal('price',$details) ?>" placeholder="" class="form-control numbers required">
                  </div>
                </div>
                <?php }else{
                   $price= getFieldVal('price',$details);
                  ?> <input type="hidden" name="price" value="<?= ($price=='')?0:$price; ?>"> <?php } ?>
                <div class="form-group">
                  <label for="case_pack" class="col-sm-3 control-label">Case Pack</label>

                  <div class="col-sm-9">
                    <input type="text" name="case_pack" value="<?= getFieldVal('case_pack',$details) ?>" placeholder="" class="form-control digits">
                  </div>
                </div>
                  <div class="form-group">
                  <label for="case_pack" class="col-sm-3 control-label">CBM</label>

                  <div class="col-sm-9">
                    <input type="text" name="cbm" value="<?= getFieldVal('cbm',$details) ?>" placeholder="" class="form-control numbers">
                  </div>
                </div>
                
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                  <label for="MOQ" class="col-sm-3 control-label">Min. Order Quantity</label>

                  <div class="col-sm-9">
                    <input type="text" name="MOQ" value="<?= getFieldVal('MOQ',$details) ?>" placeholder="" class="form-control numbers MOQ" maxlength="10">
                  </div>
                </div>
                       <div class="form-group">
                  <label for="initial_stock" class="col-sm-3 control-label">Initial Stock</label>

                  <div class="col-sm-9">
                    <input type="text" name="initial_stock" value="<?= getFieldVal('initial_stock',$details) ?>" placeholder="" class="form-control numbers initial_stock" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label for="current_stock" class="col-sm-3 control-label">Current Stock</label>

                  <div class="col-sm-9">
                    <input type="text" name="current_stock" value="<?= getFieldVal('current_stock',$details) ?>" placeholder="" class="form-control numbers current_stock" readonly>
                  </div>
                </div>

                

                <!--<div class="form-group">
                  <label for="last_name" class="col-sm-3 control-label">Parts Image </label>

                  <div class="col-sm-6">
                    <input type="file" name="parts_image" id="parts_image"  onchange="ValidateImage(this);" class="">
                  </div>
                  <div class="col-sm-3">
                    <?php if(getFieldVal('parts_image',$details)){ ?>
                    <input type="hidden" name="parts_image" value="<?= getFieldVal('parts_image',$details) ?>">
                    <img src="<?= $this->config->item('PARTS_DATA_DISP').$details->parts_image ?>" alt="Parts image" class="m-t-5" style="height: 60px;width: 80px;">
                    <?php } ?>
                  </div>
                </div>-->
                 <div class="form-group">
                  <label for="description" class="col-sm-3 control-label">Name</label>

                  <div class="col-sm-9">
                  <textarea name="description" class="form-control" id="description" placeholder="Enter description"><?= getFieldVal('description',$details) ?></textarea>
                  </div>
                </div>
                <div class="form-group" style="display:none;">
                  <label for="name" class="col-sm-3 control-label">Manufacturer<span class="req">*</span></label>
                  <?php $manufacturer=($details && isset($details->manufacturer))?explode(',',$details->manufacturer):'';
                    //$manufacturer=($_POST)?getFieldVal('manufacturer'):$manufacturer;
                   ?>
                  <div class="col-sm-9 input-group p-l-15 p-r-15">
                   
                    <select class="form-control  required" name="manufacturer[]" id="manufacturer" multiple="multiple" data-placeholder="Select manufacturers">
                     <?php if(!empty($manufacturer_detail)){foreach($manufacturer_detail as $value){?>    
                        <option value="<?= $value->ID ?>" <?= (is_array($manufacturer) && in_array($value->ID,$manufacturer))?'selected':''; ?>><?= $value->name ?></option>
                     <?php }}?>  
                    </select>
                    
                  </div>
                </div>
                  </div>
              </div>
               
                  

               
                
                <!--<div class="col-sm-12">
                   <fieldset>
                    <legend>Colors</legend>
                     <?php if(empty($details)) {?>
                    <div class="col-sm-12  p-tb-4 m-t-5 m-t-5">
                        <div class="col-sm-4"> <strong>Color</strong> </div>
                        <div class="col-sm-5"> <strong>Image</strong> </div>
                        <div class="col-sm-3 addIconpart">
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="col-sm-12 p-tb-4 m-t-5 m-t-5">
                        <div class="col-sm-4"> <strong>Image</strong> </div>
                        <div class="col-sm-3"> <strong>Upload Image</strong> </div>
                        <div class="col-sm-3"> <strong>Color</strong> </div>
                        <div class="col-sm-2 addIconpart">
                        </div>
                    </div>
                     <?php }?>
                    <?php if(empty($details)) {?>
                    <div class="col-sm-12  p-tb-4 radius sResultpart m-t-5 border_bottom">
                        <input type="hidden" name="randon_token[]" value="" class="randon_token">
                        <div class="col-sm-4">
                          <select name="color_codes[]" class="form-control color_codes">
                            <option value="">Select Color</option>
                           <?php if(!empty($colorList)){foreach($colorList as $value){?>
                            <option value="<?= $value->name ?>"><?= $value->name?></option>
                           <?php } } ?>
                           <option value="1000">Other</option>
                          </select>
                          <br>
                          <div class="multi_color" style="display: none;">
                            
                             <input id="color_codes_multi" name="color_codes_multi[]" value="" placeholder="Please input colors" class="form-control color_codes_multi">
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <input type="file" name="color_image[]" value=""  class="form-control " onchange="ValidateImage(this);"> 
                        </div>
                        <div class="col-sm-1">
                           <input type="hidden" name="color_image[]" value="">
                        </div>
                        <div class="col-sm-2 addIconpart">
                          <i class="fa fa-plus-square fa-2x text-green" id="addNewpart" title="Add New" aria-hidden="true"></i>
                        </div>
                      <div class="clearfix"></div>
                    </div>
                    <?php } else {  $randnum=rand();?>
                    
                     <div class="col-sm-12  p-tb-4 radius sResultpart m-t-5 border_bottom m-t-5">
                        <input type="hidden" name="randon_token[]" value="<?php echo $randnum;?>" class="randon_token">
                        <div class="col-sm-4">
                           <input type="hidden" name="color_image[]" value="">
                        </div>
                        <div class="col-sm-3">
                          <input type="file" name="color_image[]" value=""  class="form-control " onchange="ValidateImage(this);"> 
                        </div>
                        
                        <div class="col-sm-3">
                          
                            <input type="hidden" name="color_codes[]" value="1000" class="form-control color_codes">
                          <div class="multi_color">
                            
                             <input id="color_codes_multi" name="color_codes_multi[<?php echo $randnum;?>]" value="" placeholder="Please input colors" class="form-control color_codes_multi">
                          </div>
                        </div>
                        <div class="col-sm-2 addIconpart">
                          <i class="fa fa-plus-square fa-2x text-green" id="addNewpart" title="Add New" aria-hidden="true"></i>
                        </div>
                      <div class="clearfix"></div>
                    </div>
                    <?php }?>
                    <div class="clearfix"></div>
                    <div id="addContpart">
                      
                      <?php if(  isset($details->color_codes_list) && $details->color_codes_list && count($details->color_codes_list)>0){
                        foreach ($details->color_codes_list as $partsData) {
                          $color_code_val=($partsData->is_multiple==1)?1000:$partsData->color_code;
                        ?>
                        <div class="col-sm-12  p-tb-4 radius sResultpart m-t-5 border_bottom m-t-5">
                          <input type="hidden" name="randon_token[]" value="<?= $partsData->ID ?>" class="randon_token">
                          <div class="col-sm-4">
                              <?php if($partsData->image!=""){ ?>
                                <img src="<?= $this->config->item('PARTS_DATA_DISP').'colors/'.$ID.'/'.$partsData->image ?>" alt="Color image" style="height: 200px; width: 200px;">
                            <?php } ?>
                            <input type="hidden" name="color_image[]" value="<?= $partsData->image ?>">
                           
                          </div>
                          <div class="col-sm-3">
                             <input type="file" name="color_image[]" value=""  class="form-control color_image" onchange="ValidateImage(this);"> 
                          </div>
                          <div class="col-sm-3">
                            
                             <input type="hidden" name="color_codes[]" value="1000" class="form-control color_codes">
                              
                            <div class="multi_color">
                              <?php $color_codesArr=explode(',', $partsData->color_code); ?>
                              <input id="color_codes_multi" name="color_codes_multi[<?= $partsData->ID ?>]" value="<?= $partsData->color_code ?>" placeholder="Please input colors" class="form-control color_codes_multi">
                            </div>
                          </div>
                          
                            <div class="col-sm-2 addIconpart"><i class="fa fa-minus-circle icon-remove remove-rowpart fa-2x mrg-4" aria-hidden="true"></i></div>
                        </div>
                        <?php
                        }
                      } ?>
                     
                    </div>
                    <div class="clearfix"></div>
                  </fieldset>
                    
                </div>-->
                
                
            
            
       
              </div>
                
                <div class="col-sm-12">
                    <div class="callout callout-info">
                    <p>If you want to edit other details, please go to Parts Master</p>
                    </div>
                </div>
                
              <div class="modal-footer m-t-5">
                <button type="button" class="btn btn-default pull-left" id="close_modal" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary m-r-20" id="savepart">Submit</button>
              </div>
            </div>
    <?= form_close() ?>
            <!-- /.modal-content -->
          </div>

   
 
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


<!-- Slimscroll -->
<script src="<?php echo base_url();?>assets/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/js/adminlte.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/js/demo.js"></script>


<script src="<?php echo base_url();?>assets/js/php.default.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/js/common.js"></script>
              

<script>
var AJAX_URL='<?= base_url('ajax/') ?>';
//validate_form();

</script>
<script>
   $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    })
</script>

<script>

$(document).on('click', '#addNewpart', function(event) {
  var color_codes=$(".sResultpart:first").find('.color_codes').val();
  var parts_color_id=$(".sResultpart:first").find('.parts_color_id').val();
  var quantity=$(".sResultpart:first").find('.quantity').val();
  var color_codes_multi=$(".sResultpart:first").find('.color_codes_multi').val();
  //alert(color_codes_multi);
  if(color_codes_multi!=''){
    $(".sResultpart:first").clone().prependTo('div#addContpart');
    $('#addContpart .sResultpart:first').find(".addIconpart").html('');
    $('#addContpart  .sResultpart:first').find(".addIconpart").html('<i class="fa fa-minus-circle icon-remove remove-rowpart fa-2x mrg-4" aria-hidden="true"></i>');  
    var color_codes=$(".sResultpart:first").find('.color_codes').val();
    $(".sResultpart:first").find('input').val('');
     <?php if(empty($details)) {?>
    $('.sResultpart:first').find('.color_codes').val('');
     <?php } else { ?>
        $('.sResultpart:first').find('.color_codes').val(1000);
    <?php }?>
    $('#addContpart .sResultpart:first').find('.color_codes').val(color_codes);

    var obj=$('#addContpart .sResultpart:first');   
    var obj2=$(".sResultpart:first").find('.color_codes_multi');
    obj.find(".tagator_element").remove();
    obj2.val('');
    obj2.tagator('refresh');
    <?php if(empty($details)) {?>
     $(".sResultpart:first").find('.multi_color').hide();
      <?php } else { ?>
       $(".sResultpart:first").find('.multi_color').show();   
          <?php }?>
     tags(obj,color_codes_multi );

  }else{
    if(color_codes_multi==''){
      $(".sResultpart:first").find('.tagator_element').addClass('error_field');
    }else{$(".sResultpart:first").find('.tagator_element').removeClass('error_field');}
    
  }
  
});
$(document).on('change','.color_codes',function(){
    if($(this).val()==''){
      $(this).addClass('error_field');
    }else{
      $(this).removeClass('error_field');
    }
    var color_codes= $(this).val();
    var obj=$(this).parent().parent();
    var random_num= Math.floor((Math.random() * 1000000) + 1);
    

    if(color_codes==1000){

       obj.find('.multi_color').show(); 
       obj.find('.select2-container').css('width', '230px');
       obj.find('.randon_token').val(random_num);
       obj.find('.color_codes_multi').attr('name', 'color_codes_multi['+random_num+']');;
    }
    else{
      obj.find('.multi_color').hide();
      obj.find('.color_codes_multi').select2('destroy').select2().val(null).trigger('change.select2');
      obj.find('.randon_token').val('');
       obj.find('.color_codes_multi').attr('name', 'color_codes_multi[]');;
    }
  });

$(document).on('click','.remove-rowpart',function(){
  if(confirm("Are you sure want to remove?")){
    var ql_id=$(this).attr('rel');
    $(this).parent().parent().remove(); 
  }
  
});




</script>

 <?php 
$colors_multi=[];
 if(!empty($colorList)){foreach($colorList as $value){
    $colors_multi[]=$value->name;
 } }
?>
<script>
  var colors_multi=<?= json_encode($colors_multi); ?>
</script>
<script>


function tags(obj,color_codes_multi) {
<?php if(!empty($details)) {?>
var random_num= Math.floor((Math.random() * 1000000) + 1);
    //alert(random_num);
    obj.find('.randon_token').val(random_num);
    obj.find('.color_codes_multi').attr('name', 'color_codes_multi['+random_num+']');
<?php }?>
  obj.find(".color_codes_multi").val(color_codes_multi);
  obj.find('.color_codes_multi').tagator({
    autocomplete: colors_multi
  });
}

  $('.color_codes_multi').tagator({
    autocomplete: colors_multi
  });
  </script>
<script>
  
  $(document).on('change', '#part_type', function() {    
    var val=$(this).val();
    
    if(val==10000){
      $(".part_type_title").show();
    }else{
      $(".part_type_title").hide().val("");
    }
  });

$(document).on('input', '.MOQ', function() {  
  var MOQ=$(this).val();
  $(".initial_stock").val(MOQ);
  $(".current_stock").val(MOQ);
});


$(document).on('click','#savepart',function(){ 
    if(checkrequied()>0){
          return false;
    }else{ 
         $( "#close_modal" ).trigger( "click" );
            formData = $("#partform").serialize();
            //formData = new FormData;
            $.ajax({
            type: "POST",
            url: AJAX_URL+"savepartdetails",
            data:formData,
             success: function(data){ 
              //alert(data);
                 var detail = JSON.parse(data);
                 //alert(detail.name);
                 $(".part_"+detail.ID).val(detail.ID);
                 //$(".part_"+detail.ID).attr('name', detail.name);
         
                 $(".parts_"+detail.ID+" option:selected" ).text(detail.name);
                 $(".price_"+detail.ID).val(detail.price);
                 $(".cspk_"+detail.ID).val(detail.case_pack);
                 $(".cbm_"+detail.ID).val(detail.cbm);
                 $(".moq_"+detail.ID).val(detail.MOQ);
                 calculate_total_pcs_parts(detail.ID);
                 calculate_total_cbm_parts(detail.ID);
                 calculate_total_cost_parts(detail.ID);
                
            }
         });
          
        }
});



function checkrequied() {
    var validate_error=0;
    if($("#name" ).val()==''){
       
        $("#name").addClass('error_field');
          validate_error++;
          }
    /*if($("#manufacturer" ).val()==''){
       
        $(".select2").addClass('error_field');
          validate_error++;
    }*/
    if($("#partprice" ).val()==''){
       
        $("#partprice").addClass('error_field');
          validate_error++;
    }
   
    
    return validate_error;
}




function calculate_total_pcs_parts(CID){
    var total_cbm=0;
    var cs_pack = $(".cspk_"+CID).val();
    var total_cbm = $(".cases_"+CID).val();
  
    if(cs_pack>0 && total_cbm>0){
        
        var total_pcsval = parseFloat(cs_pack * total_cbm); 
    }
   // alert(total_pcsval);
    $('.pcs_'+CID).val(total_pcsval);
    calculate_total_cost_parts(CID);
    //total_cost_value_parts();
    
}
 
function calculate_total_cost_parts(CID){
    var total_cost=0;
    var parts_price = $(".price_"+CID).val();
    var total_pcs = $(".pcs_"+CID).val();
  
    if(parts_price>0 && total_pcs>0){
        
        var total_cost = parseFloat(parts_price * total_pcs); 
    }

    $('.tcost_'+CID).val(total_cost.toFixed(2));
    total_cost_value_parts();
    
}



function total_cost_value_parts(){
  var total_cost_val=0;
  $( ".total_cost" ).each(function(index) {
      var total_cost =$(this).val();
     
      if(total_cost>0){
         total_cost_val+=parseFloat($(this).val());
      }
    });
  total_cost_val=total_cost_val.toFixed(2);
  $('.total_cost_val_hidden').val(total_cost_val);
  $(".total_cost_val").text(total_cost_val);
 
}
function calculate_total_cbm_parts(CID){
   
    var total_cbm=0;
   
    var cbm = $(".cbm_"+CID).val();
    var total_cases = $(".cases_"+CID).val();
   //alert(cbm);alert(total_cases);
    if(cbm>0 && total_cases>0){
        
         total_cbm = parseFloat(cbm * total_cases); 
    }

    $('.tcbm_'+CID).val(total_cbm.toFixed(2));
    total_cbm_val_parts();
    
}
function total_cbm_val_parts(){
    var total_cbm_val_parts=0;
   
    $( ".total_cbm" ).each(function(index){ 
        
        var total_cbm =$(this).val();
        if(total_cbm>0){
             
            total_cbm_val_parts+=parseFloat($(this).val());
        }
            
    });  
    total_cbm_val_parts=total_cbm_val_parts.toFixed(2);
    $('.total_cbm_val_parts_hidden').val(total_cbm_val_parts);
    $('.total_cbm_val_parts').text(total_cbm_val_parts);
 }
</script>
<style>.addIconpart{text-align: center;}.error_field {
	border: 1px solid #FF3F3F !important;
}</style>
