<?= $header_start ?>
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
                            <div class="col-sm-6 text-right">
                                <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="col-sm-12  m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="porderid" class="col-sm-4 control-label">Purchase Order Id <span class="req">*</span></label>
                                        <div class="col-sm-8">
                                            <input class="form-control required porderid" id="porderid" type="text" name="porderid" value="<?= (isset($details->porderid))?$details->porderid:$details->porderid?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="po_date" class="col-sm-4 control-label">Order date <span class="req">*</span></label>
                                        <div class="col-sm-8">
                                            <input class="form-control required po_date futuredatepicker1" id="po_date" placeholder="mm/dd/yyyy" type="po_date" name="po_date" value="<?= (isset($details->po_date))?date('m/d/Y', strtotime($details->po_date)):date('m/d/Y')?>" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12  m-b-10">
                                <div class="col-sm-6">
                                    <?php if($details->planningsheet_id>0){?>
                                        <div class="form-group">
                                            <label for="planningsheet_id" class="col-sm-4 control-label">Planning Sheet <span class="req">*</span></label>
                                            <div class="col-sm-8">
                                                <select name="planningsheet_id" id="planningsheet_id" class="form-control planningsheet_id required" readonly>

                                                    <?php if(!empty($plannings)) { ?>
                                                        <?php foreach($plannings as $planning) {
                                                            // echo $planning->ID;
                                                            if($details->planningsheet_id==$planning->ID){
                                                                ?>

                                                                <option value="<?= $planning->ID;?>"><?= $planning->sheetsid;?></option>
                                                            <?php }  ?>
                                                        <?php }?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="manufacturer_id" class="col-sm-4 control-label">Manufacturer <span class="req">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="manufacturer_id" id="manufacturer_id" class="form-control manufacturer_id required" readonly>


                                                <?php if(!empty($manufacturer)) { ?>
                                                    <?php foreach($manufacturer as $manufact) {?>
                                                        <?php if($details->manufacturer_id==$manufact->ID){?>
                                                            <option value="<?= $manufact->ID;?>" <?= ($details && $details->manufacturer_id==$manufact->ID)?'selected':'' ?>><?= $manufact->name;?></option>
                                                        <?php }?>
                                                    <?php } ?>
                                                <?php } ?>


                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12  m-b-10">
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="shipping_date" class="col-sm-4 control-label">Requested Ship Date<span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input type='text' id="shipping_date" name="shipping_date" class="form-control futuredatepicker required" data-field="Date" placeholder="dd/mm/yyyy" value="<?= (isset($details->shipping_date))?date('m/d/Y', strtotime($details->shipping_date)):date('m/d/Y')?>" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <fieldset>
                                    <div class="col-sm-12  p-tb-4 m-t-5">
                                        <div style="overflow-x:auto;">
                                            <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable">

                                                <thead style="background-color:#C0C0C0;">
                                                <tr>
                                                    <th class="text-center" width="130">Item Number</th>
                                                    <th class="text-center" width="100">Item Color</th>
                                                    <th class="text-center">Item Image</th>
                                                    <th class="text-center" <?= (!checkModulePermission(10,5))?'style="display:none"':''?>>Price</th>
                                                    <th class="text-center">MOQ</th>
                                                    <th class="text-center" >CS Pack</th>
                                                    <th class="text-center"  area_type"><?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                                                    <th class="text-center">Total Cases</th>
                                                    <th class="text-center">Total PCS</th>
                                                    <th class="text-center" <?= (!checkModulePermission(10,5))?'style="display:none"':''?>>Total Cost</th>
                                                    <th class="text-center total_area_type">Total <?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                                                </tr>
                                                </thead>
                                                <?php if(!empty($details)){?>

                                                    <tbody id="addCont">
                                                    <?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){$i= count($details->parts);
                                                        foreach ($details->parts as $partsData) {
                                                            ?>
                                                            <tr class="radius sResult">
                                                                <td>
                                                                    <select name="parts_id[]" id="parts_id" class="form-control parts_id" readonly>

                                                                        <?php if(!empty($partsList)){foreach($partsList as $value){?>
                                                                            <?php if($partsData->parts_id==$value->ID){?>
                                                                                <option value=<?= $value->ID ?> <?= ($partsData && $partsData->parts_id==$value->ID)?'selected':'' ?>><?= $value->name ?></option>
                                                                            <?php } }} ?>
                                                                    </select>

                                                                </td>
                                                                <td>
                                                                    <select name="part_colors[]" class="form-control partsColorList" readonly>

                                                                        <?php if(!empty($partsData->partColorsList)){
                                                                            foreach($partsData->partColorsList as $value){?>
                                                                                <?php if($value->color_code==$partsData->part_colors){?>
                                                                                    <option value="<?= $value->color_code ?>" <?= ($value->color_code==$partsData->part_colors)?"selected":""; ?> ><?= $value->color_code?></option>
                                                                                <?php } } } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="parts_img text-center" >
                                                                        <img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
                                                                    </div>
                                                                </td>
                                                                <td <?= (!checkModulePermission(10,5))?'style="display:none"':''?>>
                                                                    <input class="form-control parts_price numbers text-center" id="parts_price" type="text" name="parts_price[]" value="<?= getFieldVal('parts_price',$partsData) ?>" placeholder="Price" readonly>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control moq numbers text-center" id="moq" type="text" name="moq[]" value="<?= getFieldVal('parts_moq',$partsData) ?>" placeholder="MOQ" readonly="">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control currentstock numbers text-center" id="currentstock" placeholder="CS Pack" type="text" name="currentstock[]" value="<?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):'' ?>" readonly>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control cbm numbers text-center" id="cbm" type="text"  name="cbm[]" value="<?= (getFieldVal('cbm',$partsData)>0)?getFieldVal('cbm',$partsData):'' ?>"  placeholder="<?= (isset($details->cbm_area_type))?$details->cbm_area_type:'CBM' ?>" readonly>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control total_cases number text-center" id="total_cases" type="text" name="total_cases[]" value="<?= (getFieldVal('total_cases',$partsData)>0)?getFieldVal('total_cases',$partsData):'' ?>" placeholder="Total Cases" readonly>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control total_pcs number text-center" id="total_pcs" type="text" name="total_pcs[]" value="<?= (getFieldVal('total_pcs',$partsData)>0)?getFieldVal('total_pcs',$partsData):'' ?>" placeholder="Total PCS" readonly="" >
                                                                </td>
                                                                <td <?= (!checkModulePermission(10,5))?'style="display:none"':''?>>
                                                                    <input class="form-control total_cost text-center numbers" id="total_cost" type="text" name="total_cost[]" value="<?= ($partsData && $partsData->total_cost>0)?getFieldVal('total_cost',$partsData):0 ?>" placeholder="Total Cost" readonly>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control total_cbm text-center numbers" id="total_cbm" type="text" name="total_cbm[]" value="<?= ($partsData && $partsData->total_cbm>0)?getFieldVal('total_cbm',$partsData):0 ?>" placeholder="Total <?= (isset($details->cbm_area_type))?$details->cbm_area_type:'CBM' ?>" readonly>
                                                                </td>

                                                            </tr>
                                                            <?php $i--;} }?>
                                                    </tbody>

                                                    <tbody>


                                                    <tr>
                                                        <th <?= (!checkModulePermission(10,5))?'colspan="8"':'colspan="9" '?>style="text-align: right;padding-right: 45px;">Total</th>
                                                        <th class="text-center" <?= (!checkModulePermission(10,5))?'style="display:none"':''?>>
                                                            <input class="form-control total_cost_val_hidden text-center numbers" type="hidden" name="total_cost_val" value="<?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?>">

                                                            <span class="total_cost_val"><?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?></span>
                                                        </th>
                                                        <th class="text-center">
                                                            <input class="form-control total_cbm_val_hidden text-center numbers" type="hidden" name="total_cbm_val" value="<?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?>">
                                                            <span class="total_cbm_val"><?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?></span>
                                                        </th>

                                                    </tr>
                                                    </tbody>
                                                <?php }
                                                ?>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                </fieldset>

                            </div>


                        </div>
                        <!-- /.box-body -->


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

    <!-- End js script -->

    <style>
        td, th {
            padding: 5px;
        }
    </style>
<?= $footer_end ?>