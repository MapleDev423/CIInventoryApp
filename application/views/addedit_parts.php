<?= $header_start ?>
<!-- Add aditional CSS script & Files -->
<link rel="stylesheet" href="<?= $COMP_DIR ?>select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?= $COMP_DIR ?>tags/fm.tagator.jquery.min.css">

<style>
    #manufacturer-error{margin-left: 18%;}
    #color_ids-error{margin-left: 18%;}
    .bootstrap-tagsinput{width: 500px !important;}
    .twitter-typeahead {
        display: initial !important;
    }
    .addIcon{text-align: center;}
</style>
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
                        <div class="col-sm-6 p-0"><h2 class="box-title"><?= $mode.' '.$heading ?></h2></div>
                        <div class="col-sm-6 text-right">
                            <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
                    <?php $ID= (isset($details->ID))?$details->ID:""; ?>
                    <input type="hidden" name="ID" value="<?= $ID ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="part_type" class="col-sm-2 control-label">Parts Type</label>

                            <div class="col-sm-6">
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
                            <label for="name" class="col-sm-2 control-label">Item Number<span class="req">*</span></label>

                            <div class="col-sm-6">
                                <input class="form-control required" id="name" placeholder="Enter Item Number" type="text" name="name" value="<?= getFieldVal('name',$details) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-6">
                                <textarea name="description" class="form-control" id="description" placeholder="Enter Name"><?= getFieldVal('description',$details) ?></textarea>
                            </div>
                        </div>
                        <?php if(checkModulePermission(5,5)){ ?>
                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">Price<span class="req">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" name="price" value="<?= getFieldVal('price',$details) ?>" placeholder="" class="form-control numbers required">
                                </div>
                            </div>
                        <?php }else{
                            $price= getFieldVal('price',$details);
                            ?> <input type="hidden" name="price" value="<?= ($price=='')?0:$price; ?>"> <?php } ?>
                        <div class="form-group">
                            <label for="case_pack" class="col-sm-2 control-label">Case Pack</label>

                            <div class="col-sm-6">
                                <input type="text" name="case_pack" value="<?= getFieldVal('case_pack',$details) ?>" placeholder="" class="form-control digits">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="case_pack" class="col-sm-2 control-label">CBM</label>

                            <div class="col-sm-6">
                                <input type="text" name="cbm" value="<?= getFieldVal('cbm',$details) ?>" placeholder="" class="form-control numbers">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="MOQ" class="col-sm-2 control-label">Min. Order Quantity</label>

                            <div class="col-sm-6">
                                <input type="text" name="MOQ" value="<?= getFieldVal('MOQ',$details) ?>" placeholder="" class="form-control numbers MOQ" maxlength="10">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="initial_stock" class="col-sm-2 control-label">Initial Stock</label>

                            <div class="col-sm-6">
                                <input type="text" name="initial_stock" value="<?= getFieldVal('initial_stock',$details) ?>" placeholder="" class="form-control numbers initial_stock" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="current_stock" class="col-sm-2 control-label">Current Stock</label>

                            <div class="col-sm-6">
                                <input type="text" name="current_stock" value="<?= getFieldVal('current_stock',$details) ?>" placeholder="" class="form-control numbers current_stock" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="col-sm-2 control-label">Parts Image </label>

                            <div class="col-sm-6">
                                <input type="file" name="parts_image" id="parts_image"  onchange="ValidateImage(this);" class="form-control">
                                <?php if(getFieldVal('parts_image',$details)){ ?>
                                    <input type="hidden" name="parts_image" value="<?= getFieldVal('parts_image',$details) ?>">
                                    <img src="<?= 'https://'.$this->config->item('BUCKETNAME').'.'.$this->config->item('REGION').'.'.$this->config->item('HOST').'/'.$details->parts_image ?>" alt="Parts image" class="m-t-5" style="height: 60px;">
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Manufacturer<span class="req">*</span></label>
                            <?php $manufacturer=($details && isset($details->manufacturer))?explode(',',$details->manufacturer):'';
                            $manufacturer=($_POST)?getFieldVal('manufacturer'):$manufacturer;
                            ?>
                            <div class="col-sm-6 input-group p-l-15 p-r-15">

                                <select class="form-control select2 required" name="manufacturer[]" id="manufacturer" multiple="multiple" data-placeholder="Select manufacturers">
                                    <?php if(!empty($manufacturer_detail)){foreach($manufacturer_detail as $value){?>
                                        <option value="<?= $value->ID ?>" <?= (is_array($manufacturer) && in_array($value->ID,$manufacturer))?'selected':''; ?>><?= $value->name ?></option>
                                    <?php }}?>
                                </select>

                            </div>
                        </div>

                        <div class="col-sm-12">
                            <fieldset>
                                <legend>Colors</legend>

                                <div class="col-sm-12  p-tb-4 m-t-5">
                                    <div class="col-sm-3"> <strong>Image</strong> </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-4"> <strong>Color</strong> </div>
                                    <div class="col-sm-2 addIcon">
                                        <i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-2"></div>
                                </div>
                                <div id="">
                                    <?php if(  isset($details->color_codes_list) && $details->color_codes_list && count($details->color_codes_list)>0){
                                        foreach ($details->color_codes_list as $partsData) {
                                            $color_code_val=($partsData->is_multiple==1)?1000:$partsData->color_code;
                                            ?>
                                            <div class="col-sm-12  p-tb-4 radius  m-t-5 border_bottom">
                                                <input type="hidden" name="randon_token[]" value="<?= $partsData->ID ?>" class="randon_token">
                                                <div class="col-sm-3">
                                                    <?php if($partsData->image!=""){ ?>
                                                        <img src="<?= $this->config->item('PARTS_DATA_DISP').'colors/'.$ID.'/'.$partsData->image ?>" alt="Color image" class="color_partimg" style="height: 200px; width: 200px;">
                                                    <?php } ?>
                                                    <input type="hidden" name="color_image[]" value="<?= $partsData->image ?>" class="color_imageval">
                                                    <input type="file" name="color_image[]" class="color_image" value="" <?php if($partsData->image!=""){ echo 'style="display: none;"'; }?> onchange="ValidateImage(this);">
                                                </div>
                                                <div class="col-sm-1">
                                                    <?php if($partsData->image!=""){ ?>
                                                        <i class="fa fa-times icon-remove remove-img fa-2x mrg-4" aria-hidden="true" title="Remove Image"></i>
                                                    <?php } ?>
                                                </div>

                                                <div class="col-sm-4">
                                                    <input type="hidden" name="color_codes[]" value="1000" class="form-control color_codes">
                                                    <div class="multi_color">
                                                        <?php $color_codesArr=explode(',', $partsData->color_code); ?>
                                                        <input type="text" class="form-control color_codes_multi" id="color_codes_multi" name="color_codes_multi[<?= $partsData->ID ?>]" value="<?= $partsData->color_code ?>" placeholder="Please input colors">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 addIcon"><i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i></div>
                                                <div class="col-sm-2"></div>
                                            </div>
                                            <?php
                                        }
                                    } ?>

                                </div>
                                <div class="clearfix"></div>
                                <?php
                                $randnum=rand();
                                ?>
                                <div id="addCont">
                                    <div class="sResult"></div>
                                </div>
                                <div class="clearfix"></div>

                                <div id="addContclone" >
                                    <div class="col-sm-12  p-tb-4 radius sResult m-t-5 border_bottom">
                                        <input type="hidden" name="randon_token[]" value="<?php echo $randnum;?>" class="randon_token">
                                        <div class="col-sm-3">
                                            <input type="hidden" name="color_image[]" value="">
                                            <input type="file" name="color_image[]" value=""  class="color_imagenew" onchange="ValidateImage(this);">
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="color_codes[]" value="1000" class="form-control color_codes">
                                            <div class="multi_color">
                                                <input type="text" class="form-control color_codes_multi" id="color_codes_multi" name="color_codes_multi[<?php echo $randnum;?>]" value="" placeholder="Please input colors" >
                                            </div>
                                        </div>
                                        <div class="col-sm-2 addIcon">
                                            <i class="fa fa-minus-circle icon-remove remove-row-clone fa-2x mrg-4" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-sm-2"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="clearfix"></div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="box-footer text-center">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary m-r-20">Submit</button>
                                <a href="<?= $main_page ?>" class="btn btn-danger">Cancel</a>
                            </div>
							
                        </div>
						<? if(isset($historical) || isset($future))
							{?>
						 <div class="col-sm-12">
                            <fieldset>
                                <legend>Historical Prices</legend>
								<div class="table-responsive" style="overflow-x:auto;margin-top:20px;">
              						<table id="mytable" class="table table-bordered table-hover text-center" >
               						 <thead>
										<tr>        
											<th>Order Date</th>
											<th>Invoice #</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Freight</th>
											<th>Taxes</th>
											<th>Effective Price</th>
										</tr>
										</thead>
										<tbody>
											<?php
											if(isset($historical))
											{
											?>
											<tr><td colspan="7" style="text-align:center"><strong>Historical Prices</strong></td></tr>
											<?php
											 foreach($historical as $prow){ 
                                            ?>
										<tr>
											<td><?=$prow->order_date ?></td>
											<td><?=$prow->invoiceid ?></td>
											<td><?=$prow->qty?></td>
											<td><?=$prow->price ?></td>
											<td><?=$prow->freight?></td>
											<td><?=$prow->taxes ?></td>
											<td><?=$prow->effprice ?></td>	
											
										</tr>
										<?php 
                                            }
											}
                                            ?>	
										<?php
											if(isset($future))
											{
											?>
											<tr><td colspan="7" style="text-align:center"><strong>Future Prices, est $16,000 Freight</strong></td></tr>
											<?php
											 foreach($future as $frow){ 
                                            ?>
										<tr>
											<td><?=$frow->order_date ?></td>
											<td><?=$frow->invoiceid ?></td>
											<td><?=$frow->qty?></td>
											<td><?=$frow->price ?></td>
											<td><?=$frow->freight?></td>
											<td><?=$frow->taxes ?></td>
											<td><?=$frow->effprice ?></td>	
											
										</tr>
										<?php }
											}?>		
										
										</tbody>
								
									</table>
							</div>
						 </fieldset>
                    </div>
						<? } ?>
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
<script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>
<script src="<?= $COMP_DIR ?>tags/fm.tagator.jquery.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>

<script>
    validate_form();
    $(document).on('click', '#addNew', function(event) {
        var color_codes_multi=$("#addContclone .sResult:first").find('.color_codes_multi').val();

        $("#addContclone .sResult:first").clone().insertAfter($('#addCont .sResult:last'));
        $('#addCont .sResult:last').find(".addIcon").html('');
        $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');
        $("#addCont .sResult:last").find('.tagator_element').removeClass('error_field');
        $("#addContclone .sResult:first").find('.tagator_element').removeClass('error_field');
        var color_codes=$("#addContclone .sResult:first").find('.color_codes').val();

        $("#addContclone .sResult:first").find('.color_imagenew').val('');
        $('#addContclone .sResult:first').find('.color_codes').val(1000);
        $('#addCont .sResult:last').find('.color_codes').val(color_codes);

        var obj=$('#addCont .sResult:last');
        var obj2=$("#addContclone .sResult:first").find('.color_codes_multi');
        obj.find(".tagator_element").remove();
        obj2.val('');
        obj2.tagator('refresh');
        $("#addContclone .sResult:first").find('.multi_color').show();
        tags(obj,color_codes_multi );
    });


    $(document).on('click','.remove-row',function(){
        if(confirm("Are you sure want to remove?")){
            var ql_id=$(this).attr('rel');
            $(this).parent().parent().remove();
        }

    });

    $(document).on('click','.remove-row-clone',function(){
        if(confirm("Are you sure want to remove?")){
            $("#addContclone").hide();
        }

    });

    $(document).on('click','.remove-img',function(){
        if(confirm("Are you sure want to remove this image?")){
            var obj=$(this).parent().parent();
            obj.find('.color_partimg').hide();
            obj.find('.color_image').show();
            obj.find('.remove-img').hide();
            obj.find('.color_imageval').val('');
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
        var random_num= Math.floor((Math.random() * 1000000) + 1);
        obj.find('.randon_token').val(random_num);
        obj.find('.color_codes_multi').attr('name', 'color_codes_multi['+random_num+']');
        obj.find("color_codes_multi").val(color_codes_multi);
        obj.find('.color_codes_multi').tagator({
            autocomplete: colors_multi
        });
    }

    $('.color_codes_multi').tagator({
        autocomplete: colors_multi
    });

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
</script>


<!-- End js script -->
<?= $footer_end ?>
