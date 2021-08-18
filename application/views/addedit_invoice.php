<?= $header_start ?>
    <!-- Add aditional CSS script & Files -->
    <link rel="stylesheet" href="<?= $COMP_DIR ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= $COMP_DIR ?>select2/dist/css/select2.min.css">
    <style>
        td, th {
            padding: 5px;
        }
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
                            <div class="col-sm-6 p-0"><h2 class="box-title"><?= ($details)?"Edit":'Add' ?> <?= $heading ?></h2></div>
                            <div class="col-sm-6 text-right">
                                <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?= form_open_multipart('', 'class="myform fffform-horizontal" id="piform"'); ?>
                        <div class="box-body">
                            <div class="col-sm-6 m-b-10">
                                <?php $ID= (isset($details->ID))?$details->ID:""; ?>
                                <input type="hidden" name="ID" value="<?= $ID ?>">
                                <div class="form-group">
                                    <label for="invoiceid" class="col-sm-4 control-label">Invoice ID <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control required invoiceid" id="invoiceid" type="text" name="invoiceid" value="<?= (isset($details->invoiceid))?$details->invoiceid:''?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="pi_date" class="col-sm-4 control-label">Invoice date <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control required pi_date futuredatepicker1" id="pi_date" placeholder="mm/dd/yyyy" type="pi_date" name="pi_date" value="<?= (isset($details->pi_date))?date('m/d/Y', strtotime($details->pi_date)):date('m/d/Y')?>">
                                    </div>
                                </div>
                            </div>

                            <?php if($details && $details->porderid !=''){?>
                                <div class="col-sm-6 m-b-10">
                                    <div class="form-group">
                                        <input type="hidden" value="<?php echo $details->planningsheet_id;?>" name="planningsheet_id"  id="planningsheet_id">
                                        <label for="porderid" class="col-sm-4 control-label">Purchase Order <span class="req">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="porderid" id="porderid" class="form-control porderid required" readonly>
                                                <?php if(!empty($porders)) { ?>
                                                    <?php foreach($porders as $porder) {
                                                        // echo $porder->ID;
                                                        if($details->porderid==$porder->ID){
                                                            ?>

                                                            <option value="<?= $porder->ID;?>"><?= $porder->porderid;?></option>
                                                        <?php }  ?>
                                                    <?php }?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php } else{ ?>
                                <div class="col-sm-6 m-b-10">
                                    <div class="form-group">
                                        <?php
                                        $planningsheet_id=(isset($details->planningsheet_id))?$details->planningsheet_id:'';
                                        ?>
                                        <input type="hidden" value="<?=$planningsheet_id;?>" name="planningsheet_id"  id="planningsheet_id">
                                        <label for="porderid" class="col-sm-4 control-label">Purchase Order <span class="req">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="porderid" id="porderid" class="form-control porderid required select22">
                                                <option value="">Select Purchase Order</option>
                                                <?php if(!empty($porders)) { ?>
                                                    <?php foreach($porders as $porder) {?>

                                                        <option value="<?= $porder->ID;?>" <?= ($details && $details->porderid==$porder->ID)?'selected':'' ?>><?= $porder->porderid;?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>

                            <div class="col-sm-6 m-b-10" style="display:none">
                                <div class="form-group">
                                    <label for="manufacturer_id" class="col-sm-4 control-label">Manufacturer <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="manufacturer_id" id="manufacturer_id" class="form-control manufacturer_id " <?= ($details && $details->planningsheet_id==$porder->ID)?'readonly':'readonly' ?>>
                                            <?php if($details && $details->manufacturer_id){?>
                                                <?php if(!empty($manufacturer)) { ?>
                                                    <?php foreach($manufacturer as $manufact) {?>
                                                        <?php //if($details->manufacturer_id==$manufact->ID){?>
                                                        <option value="<?= $manufact->ID;?>" <?= ($details && $details->manufacturer_id==$manufact->ID)?'selected':'' ?>><?= $manufact->name;?></option>
                                                        <?php //}?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="">Select Manufacturer</option>
                                                <?php if(!empty($manufacturer)) { ?>
                                                    <?php foreach($manufacturer as $manufact) {?>

                                                        <option value="<?= $manufact->ID;?>" <?= ($details && $details->manufacturer_id==$manufact->ID)?'selected':'' ?>><?= $manufact->name;?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php }?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="shipping_date" class="col-sm-4 control-label">Estimated Ship Date <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input type='text' id="shipping_date" name="shipping_date" class="form-control futuredatepicker required" data-field="Date" placeholder="dd/mm/yyyy" value="<?= (isset($details->shipping_date))?date('m/d/Y', strtotime($details->shipping_date)):date('m/d/Y')?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="cbm_area_type" class="col-sm-4 control-label">Area Type <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="cbm_area_type" id="cbm_area_type" class="form-control cbm_area_type required">
                                            <option value="CBM" <?= (isset($details->cbm_area_type) && $details->cbm_area_type=="CBM")?'selected':'';?>>CBM</option>
                                            <option value="Cubic Feet" <?= (isset($details->cbm_area_type) && $details->cbm_area_type=="Cubic Feet")?'selected':'';?>>Cubic Feet</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="rows" class="col-sm-4 control-label">Rows</label>
                                    <div class="col-sm-6">
                                        <input class="form-control number rows" id="rows" type="text" name="rows" placeholder="Enter No. of Rows">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="button" class="btn btn-primary m-r-20 add_row">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <fieldset>
                                <div class="col-sm-12  p-tb-4 m-t-5">
                                    <div style="overflow-x:auto;">
                                        <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable" style="overflow-x:auto;">

                                            <thead style="background-color:#C0C0C0;">
                                            <tr>
                                                <th class="text-center" width="130">Item Number</th>
                                                <th class="text-center" width="100">Item Color</th>
                                                <th class="text-center">Item Image</th>
                                                <th class="text-center" <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>Price</th>
                                                <th class="text-center">MOQ</th>
                                                <th class="text-center">CS Pack</th>
                                                <th class="text-center area_type"><?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                                                <th class="text-center">Total Cases</th>
                                                <th class="text-center">Total PCS</th>
                                                <th class="text-center" <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>Total Cost</th>
                                                <th class="text-center total_area_type">Total <?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                                                <th class="addIcon"><i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i></th>
                                            </tr>
                                            </thead>
                                            <?php if(!empty($details)){?>
                                                <tbody id="addContClone"><tr></tr></tbody>
                                                <tbody id="addCont">
                                                <?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){$i= count($details->parts);
                                                    foreach ($details->parts as $partsData) {
                                                        ?>
                                                        <tr class="radius sResult">
                                                            <td>
                                                                <select name="parts_id[]" id="parts_id" class="form-control parts_id parts_<?= $partsData->parts_id ?> required">
                                                                    <option value="">Select Part</option>

                                                                    <?php if(!empty($partsList)){foreach($partsList as $value){?>
                                                                        <option value=<?= $value->ID ?> <?= ($partsData && $partsData->parts_id==$value->ID)?'selected':'' ?>><?= $value->name ?></option>
                                                                    <?php }} ?>
                                                                </select>
                                                                <span class="edit_parts">
                                 <a data-toggle="modal" data-target=".bs-example-modal-lg2" href="" data-target="#myModal" class="edit_row"><i class="fa fa-pencil-square icon edit " aria-hidden="true"></i></a>
                                </span>
                                                                <input class="form-control numbers text-center pID" id="pID" type="hidden" name="pID" value="<?= $partsData->parts_id ?>">

                                                            </td>
                                                            <td>
                                                                <select name="part_colors[]" class="form-control partsColorList">
                                                                    <option value="">Select Parts Color</option>
                                                                    <?php if(!empty($partsData->partColorsList)){
                                                                        foreach($partsData->partColorsList as $value){?>
                                                                            <option value="<?= $value->color_code ?>" <?= ($value->color_code==$partsData->part_colors)?"selected":""; ?> ><?= $value->color_code?></option>
                                                                        <?php } } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="parts_img text-center" >
                                                                    <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                                                </div>
                                                            </td>
                                                            <td  <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
                                                                <input class="form-control parts_price numbers text-center price_<?= $partsData->parts_id ?> required" id="parts_price" type="text" name="parts_price[]" value="<?= getFieldVal('parts_price',$partsData) ?>" placeholder="Price">
                                                            </td>
                                                            <td>
                                                                <input class="form-control moq numbers text-center moq_<?= $partsData->parts_id ?>" id="moq" type="text" name="moq[]" value="<?= getFieldVal('parts_moq',$partsData) ?>" placeholder="MOQ" readonly="">
                                                            </td>
                                                            <td>
                                                                <input class="form-control currentstock numbers text-center cspk_<?= $partsData->parts_id ?> required" id="currentstock" placeholder="CS Pack" type="text" name="currentstock[]" value="<?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):'' ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control cbm numbers text-center cbm_<?= $partsData->parts_id ?> required" id="cbm" type="text"  name="cbm[]" value="<?= (getFieldVal('cbm',$partsData)>0)?getFieldVal('cbm',$partsData):'' ?>"  placeholder="<?= (isset($details->cbm_area_type))?$details->cbm_area_type:'CBM' ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control total_cases number text-center cases_<?= $partsData->parts_id ?> required" id="total_cases" type="text" name="total_cases[]" value="<?= (getFieldVal('total_cases',$partsData)>0)?getFieldVal('total_cases',$partsData):'' ?>" placeholder="Total Cases">
                                                            </td>
                                                            <td>
                                                                <input class="form-control total_pcs number text-center pcs_<?= $partsData->parts_id ?> required" id="total_pcs" type="text" name="total_pcs[]" value="<?= (getFieldVal('total_pcs',$partsData)>0)?getFieldVal('total_pcs',$partsData):'' ?>" placeholder="Total PCS" readonly="">
                                                            </td>
                                                            <td <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
                                                                <input class="form-control total_cost text-center numbers tcost_<?= $partsData->parts_id ?> required" id="total_cost" type="text" name="total_cost[]" value="<?= ($partsData && $partsData->total_cost>0)?getFieldVal('total_cost',$partsData):0 ?>" placeholder="Total Cost" readonly>
                                                            </td>
                                                            <td>
                                                                <input class="form-control total_cbm text-center numbers tcbm_<?= $partsData->parts_id ?> required" id="total_cbm" type="text" name="total_cbm[]" value="<?= ($partsData && $partsData->total_cbm>0)?getFieldVal('total_cbm',$partsData):0 ?>" placeholder="Total <?= (isset($details->cbm_area_type))?$details->cbm_area_type:'CBM' ?>" readonly>
                                                            </td>
                                                            <td align="center" class="addIcon">
                                                                <?php if($i>0){?>
                                                                    <i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>
                                                                <?php } else{?>
                                                                    <i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php $i--;} } else { ?>
                                                    <tr class="radius sResult">
                                                        <td class="action">
                                                            <select name="parts_id[]" id="parts_id" class="form-control parts_id required">
                                                                <option value="">Select Part</option>
                                                                <?php if(!empty($partsList)){foreach($partsList as $value){?>
                                                                    <option value=<?= $value->ID ?>><?= $value->name ?></option>-->
                                                                <?php }} ?>
                                                            </select>
                                                            <span class="edit_parts"></span>
                                                            <input class="form-control pID numbers text-center" id="pID" type="hidden" name="pID" value="0">
                                                        </td>
                                                        <td>
                                                            <select name="part_colors[]" class="form-control partsColorList">
                                                                <option value="">Select Parts Color</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="parts_img text-center" ></div>
                                                        </td>
                                                        <td  <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
                                                            <input class="form-control parts_price text-center numbers required" id="parts_price" type="text" name="parts_price[]" placeholder="Price">
                                                        </td>
                                                        <td>
                                                            <input class="form-control moq numbers text-center" id="moq" type="text" name="moq[]" value="" placeholder="MOQ" readonly="">
                                                        </td>
                                                        <td>
                                                            <input class="form-control currentstock text-center numbers required" id="currentstock" placeholder="CS Pack" type="text" name="currentstock[]" value="">
                                                        </td>
                                                        <td>
                                                            <input class="form-control text-center cbm numbers required" id="cbm" type="text"  name="cbm[]" placeholder="CBM">
                                                        </td>
                                                        <td>
                                                            <input class="form-control total_cases  text-center number required" id="total_cases" type="text" name="total_cases[]" placeholder="Total Cases">
                                                        </td>
                                                        <td>
                                                            <input class="form-control total_pcs text-center number required" id="total_pcs" type="text" name="total_pcs[]" placeholder="Total PCS" readonly="">
                                                        </td>
                                                        <td <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
                                                            <input class="form-control total_cost text-center numbers required" id="total_cost" type="text" name="total_cost[]" value="" placeholder="Total Cost" readonly>
                                                        </td>
                                                        <td>
                                                            <input class="form-control total_cbm text-center numbers required" id="total_cbm" type="text" name="total_cbm[]" value="" placeholder="Total CBM" readonly>
                                                        </td>
                                                        <td align="center" class="addIcon"><i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i> </td>

                                                    </tr>
                                                <?php }?>
                                                </tbody>

                                                <tfoot>
                                                <tr>
                                                    <th <?= (!checkModulePermission(16,5))?'colspan="5"':'colspan="7"'?> style="text-align: right;padding-right: 45px;">Total</th>
													<th class="text-center">
														<input class="form-control total_cases_val_hidden text-center numbers" type="hidden" name="total_cases_val" id="total_cases_val" value="<?= ($details && $details->total_cases_val>0)?getFieldVal('total_cases_val',$details):0 ?>">
                                                        <span class="total_cases_val"><?= ($details && $details->total_cases_val>0)?getFieldVal('total_cases_val',$details):0 ?></span>
													</th>
													<th class="text-center">
														<input class="form-control total_pcs_val_hidden text-center numbers" type="hidden" name="total_pcs_val" id="total_pcs_val" value="<?= ($details && $details->total_pcs_val>0)?getFieldVal('total_pcs_val',$details):0 ?>">
                                                        <span class="total_pcs_val"><?= ($details && $details->total_pcs_val>0)?getFieldVal('total_pcs_val',$details):0 ?></span>
													</th>
                                                    <th class="text-center">
                                                        <input class="form-control total_cost_val_hidden text-center numbers" type="hidden" name="total_cost_val" id="total_cost_val" value="<?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?>">
                                                        <span class="total_cost_val"><?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?></span>
                                                    </th>
                                                    <th class="text-center">
                                                        <input class="form-control total_cbm_val_hidden text-center numbers" type="hidden" name="total_cbm_val" value="<?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?>">
                                                        <span class="total_cbm_val"><?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?></span>
                                                    </th>
                                                    <th class="text-center">&nbsp;</th>
                                                </tr>
                                                <tr>
                                                    <th <?= (!checkModulePermission(16,5))?'':'colspan="2"'?> style="text-align: right;padding-right: 45px;"></th>
                                                    <th class="text-center" <?= (!checkModulePermission(16,5))?'':'colspan="2"'?>>Confirmation No. </th>
													
													<th class="text-center" colspan="2">
                                                        <input class="form-control confirmation_no_hidden text-center" type="text" name="confirmation_no" value="<?= ($details && $details->confirmation_no!='')?getFieldVal('confirmation_no',$details):'' ?>">
                                                        <span class="confirmation_no" style="display: none"></span>
                                                    </th>
                                                    <th class="text-center">Deposit(%)</th>
                                                    <th class="text-center" >
                                                        <input class="form-control total_deposit_per_hidden text-center numbers" type="text" name="total_deposit_per" id="total_deposit_per" value="<?= ($details && $details->total_deposit_per>0)?getFieldVal('total_deposit_per',$details):0 ?>">
                                                        <span class="total_deposit_per" style="display: none"></span>
                                                    </th>
                                                    <th class="text-center">Deposit Amt</th>
                                                    <th class="text-center" >
                                                        <input class="form-control total_deposit_val_hidden text-center numbers" type="text" name="total_deposit_val" id="total_deposit_val" value="<?= ($details && $details->total_deposit_val>0)?getFieldVal('total_deposit_val',$details):0 ?>">
                                                        <span class="total_deposit_val" style="display: none"></span>
                                                    </th>
													<th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                </tr>
                                                </tfoot>
                                            <?php } else{ ?>
                                                <tbody id="addContClone"><tr></tr></tbody>
                                                <tbody id="addCont">
                                                <tr class="radius sResult">
                                                    <td class="action">
                                                        <select name="parts_id[]" id="parts_id" class="form-control parts_id required">
                                                            <option value="">Select Part</option>
                                                        </select>
                                                        <span class="edit_parts"></span>
                                                    </td>
                                                    <td>
                                                        <select name="part_colors[]" class="form-control partsColorList">

                                                            <option value="">Select Parts Color</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="parts_img text-center" ></div>
                                                    </td>
                                                    <td  <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
                                                        <input class="form-control parts_price text-center numbers required" id="parts_price" type="text" name="parts_price[]" placeholder="Price">
                                                    </td>
                                                    <td>
                                                        <input class="form-control moq numbers text-center" id="moq" type="text" name="moq[]" value="" placeholder="MOQ" readonly="">
                                                    </td>
                                                    <td>
                                                        <input class="form-control currentstock text-center numbers required" id="currentstock" placeholder="CS Pack" type="text" name="currentstock[]" value="">
                                                    </td>
                                                    <td>
                                                        <input class="form-control text-center cbm numbers required" id="cbm" type="text"  name="cbm[]" placeholder="CBM">
                                                    </td>
                                                    <td>
                                                        <input class="form-control total_cases  text-center number required" id="total_cases" type="text" name="total_cases[]" placeholder="Total Cases">
                                                    </td>
                                                    <td>
                                                        <input class="form-control total_pcs text-center number required" id="total_pcs" type="text" name="total_pcs[]" placeholder="Total PCS" readonly="">
                                                    </td>
                                                    <td <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
                                                        <input class="form-control total_cost text-center numbers required" id="total_cost" type="text" name="total_cost[]" value="" placeholder="Total Cost" readonly>
                                                    </td>
                                                    <td>
                                                        <input class="form-control total_cbm text-center numbers required" id="total_cbm" type="text" name="total_cbm[]" value="" placeholder="Total CBM" readonly>
                                                    </td>
                                                    <td align="center" class="addIcon"><i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i> </td>

                                                </tr>
                                                </tbody>
                                                <tbody id="addContTotals">
                                                <tr>
                                                    <th <?= (!checkModulePermission(16,5))?'colspan="5"':'colspan="7"'?> style="text-align: right;padding-right: 45px;">Total</th>
													<th class="text-center">
                                                        <input class="form-control total_cost_cases_hidden text-center numbers" type="hidden"  name="total_cases_val" id="total_cases_val" value="0">
                                                        <span class="total_cases_val">0.00</span>
                                                    </th>
                                                    <th class="text-center">
                                                        <input class="form-control total_pcs_val_hidden text-center numbers" type="hidden" name="total_pcs_val" value="10">
                                                        <span class="total_pcs_val">0.00</span>
                                                    </th>
                                                    <th class="text-center">
                                                        <input class="form-control total_cost_val_hidden text-center numbers" type="hidden"  name="total_cost_val" id="total_cost_val" value="0">
                                                        <span class="total_cost_val">0.00</span>
                                                    </th>
                                                    <th class="text-center">
                                                        <input class="form-control total_cbm_val_hidden text-center numbers" type="hidden" name="total_cbm_val" value="0">
                                                        <span class="total_cbm_val">0.00</span>
                                                    </th>
                                                    <th class="text-center">&nbsp;</th>
                                                </tr>
                                                </tbody>
                                                <tfoot class="deposit_details" style="display: none">
                                                <tr>
                                                    <th <?= (!checkModulePermission(16,5))?'':'colspan="2"'?> style="text-align: right;padding-right: 45px;"></th>
                                                    <th class="text-center" <?= (!checkModulePermission(16,5))?'':'colspan="2"'?>>Confirmation No.</th>
                                                    <th class="text-center" colspan="2">
                                                        <input class="form-control confirmation_no_hidden text-center" type="text" name="confirmation_no" value="">
                                                        <span class="confirmation_no" style="display: none"></span>
                                                    </th>
                                                    <th class="text-center">Deposit(%)</th>
                                                    <th class="text-center" >
                                                        <input class="form-control total_deposit_per_hidden text-center numbers" type="text" name="total_deposit_per" id="total_deposit_per" value="30">
                                                        <span class="total_deposit_per" style="display: none"></span>
                                                    </th>
                                                    <th class="text-center">Deposit Amt</th>
                                                    <th class="text-center" >
                                                        <input class="form-control total_deposit_val_hidden text-center numbers" type="text" name="total_deposit_val" id="total_deposit_val" value="">
                                                        <span class="total_deposit_val" style="display: none"></span>
                                                    </th>
                                                    <th class="text-center">&nbsp;</th>
                                                    <th class="text-center">&nbsp;</th>
                                                </tr>
                                                </tfoot>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                            </fieldset>

                        </div>
                        <div class="clearfix"></div><br>
                        <div class="box-footer text-center">
                            <div class="col-sm-8">
                                <button type="submit" id="saveinvoice" class="btn btn-primary m-r-20">Save Invoice</button>
                                <button type="submit" id="saveperforma" class="btn btn-primary m-r-20" formaction="<?php echo base_url()?>invoice/generateperforma">Generate Performa Invoice</button>
                                <a href="<?=$main_page; ?>" class="btn btn-danger m-r-20">Cancel</a>
                            </div>
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
    <div class="modal fade bs-example-modal-lg2" id="PartsModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" data-backdrop="static">

    </div>
<?= $footer_start ?>
    <!-- Add aditional js script & files -->
    <script src="<?= $COMP_DIR ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= $JS_DIR ?>performa.js" type="text/javascript"></script>
    <script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })

        $('.futuredatepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
        });
    </script>
    <script>
        var AJAX_URL='<?= base_url('ajax/') ?>';
        //validate_form();

    </script>
    <script>
        validate_form();
        $(function () {

            $('#pi_date').datepicker({
                autoclose: true
            })

        });

    </script>
    <script>
        $(document).on('input', '.number', function(event){
            var intRegex = /^\d+$/;

            var str = $(this).val();// alert(str);
            if(!intRegex.test(str)) { //alert(str);
                $(this).val(str.substring(0, str.length-1));
                //return false;
            }
            if(str==""){
                $(this).addClass('valid_error');

            }else{
                $(this).removeClass('valid_error');
            }
        });

    </script>
    <script>
        <?php if(isset($details->pi_date)){
        $datearr=explode('/',date('m/d/Y', strtotime($details->pi_date)));
        $year =$datearr[2];
        $month =$datearr[0];
        $day =$datearr[1];
        ?>
        var month = <?= $month?>;
        var day = <?= $day?>;
        var year = <?= $year?>;
        <?php } else{?>

        var date = $("#pi_date").val();
        var d = {"pi_date": date}
        var dt = new Date(d.pi_date);

        var month = dt.getMonth()+1;
        var day = dt.getDate();
        var year = dt.getFullYear();
        //alert(month+"/"+day+"/"+year);
        <?php   }
        ?>
        <?php if(isset($details->pi_date)){?>
        var start = new Date("<?= date('m/d/Y', strtotime($details->pi_date))?>");
        var end = new Date(new Date().setYear(start.getFullYear()+1));
        <?php } else{?>
        var start = new Date();
        var end = new Date(new Date().setYear(start.getFullYear()+1));
        <?php } ?>

        var start = new Date();
        var end = new Date(new Date().setYear(start.getFullYear()+1));

        $('.futuredatepicker1').datepicker({
            //startDate : start,
            // endDate   : end,
            autoclose: true,
            todayHighlight: true,
// update "fromDate" defaults whenever "toDate" changes
        });
    </script>
    <!-- End js script -->
<?= $footer_end ?>