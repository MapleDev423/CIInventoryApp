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
                            <div class="col-sm-6 p-0"><h2 class="box-title"><?= $mode ?> <?= $heading ?></h2></div>
                            <div class="col-sm-6 text-right">
                                <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?= form_open_multipart('', 'class="myform fffform-horizontal" id="shform"'); ?>
                        <div class="box-body">
                            <div class="col-sm-6 m-b-10">
                                <?php $ID= (isset($details->ID))?$details->ID:""; ?>
                                <input type="hidden" name="ID" value="<?= $ID ?>">
                                <div class="form-group">
                                    <label for="shipment_id" class="col-sm-4 control-label">Shipment ID <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control required shipment_id" id="shipment_id" type="text" name="shipment_id" value="<?= (isset($details->shipment_id))?$details->shipment_id:''?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="shipping_date" class="col-sm-4 control-label">Real Ship Date <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control required shipping_date futuredatepicker" id="shipping_date" placeholder="mm/dd/yyyy" type="text" name="shipping_date" value="<?= (isset($details->shipping_date))?date('m/d/Y', strtotime($details->shipping_date)):date('m/d/Y')?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                    <div class="form-group">
                                        <label for="pi_id" class="col-sm-4 control-label">PI No. <span class="req">*</span></label>
                                        <div class="col-sm-8">
                                            <?php if($details && $details->pi_id!=''){ ?>
                                              <select class="form-control pi_id required" name="pi_id" id="pi_id"  readonly>
                                                    <option value="<?= $details->pi_id;?>" selected><?= $details->invoiceid;?></option>
                                                </select>
                                            <?php }else{?>
                                                <select name="pi_id" id="pi_id" class="form-control pi_id required select22">
                                                    <option value="">Select PI No.</option>
                                                    <?php if(!empty($proformaDetails)) { ?>
                                                        <?php foreach($proformaDetails as $proforma) {?>
                                                            <option value="<?= $proforma->ID;?>" ><?= $proforma->invoiceid;?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="estimated_shipping_date" class="col-sm-4 control-label">Estimated Ship Date <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input type='text' id="estimated_shipping_date" name="estimated_shipping_date" class="form-control estimated_shipping_date futuredatepicker1 required" data-field="Date" placeholder="dd/mm/yyyy" value="<?= (isset($details->estimated_shipping_date))?date('m/d/Y', strtotime($details->estimated_shipping_date)):''?>" readonly title=""/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="confirmation_no" class="col-sm-4 control-label">Confirmation No.</label>
                                    <div class="col-sm-8">
                                        <input type='text' id="confirmation_no" name="confirmation_no" class="form-control confirmation_no" placeholder="confirmation No" value="<?= (isset($details->confirmation_no))?$details->confirmation_no:'None'?>" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="deposit_balance" class="col-sm-4 control-label">Deposit Balance </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="deposit_balance" name="deposit_balance" class="form-control deposit_balance" placeholder="Deposit Balance" value="<?= (isset($details->deposit_balance))?$details->deposit_balance:'0.00'?>" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="due_balance" class="col-sm-4 control-label">Due Balance </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="due_balance" name="due_balance" class="form-control due_balance" placeholder="Due Balance" value="<?= (isset($details->due_balance))?$details->due_balance:'0.00'?>" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="container_size" class="col-sm-4 control-label">Container Size <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <select type='text' id="container_size" name="container_size" class="form-control container_size required" >
                                            <option value="">Select Container Size</option>
                                            <option value="20" <?= (isset($details->container_size) && $details->container_size=='20')?'selected':''?>>20'</option>
                                            <option value="40" <?= (isset($details->container_size) && $details->container_size=='40')?'selected':''?>> 40'</option>
                                            <option value="40 HQ" <?= (isset($details->container_size) && $details->container_size=='40 HQ')?'selected':''?>>40'HQ</option>
                                            <option value="45" <?= (isset($details->container_size) && $details->container_size=='45')?'selected':''?>>45'</option>
                                            <option value="55" <?= (isset($details->container_size) && $details->container_size=='55')?'selected':''?>>53'</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="shipping_company" class="col-sm-4 control-label">Shipping Company </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="shipping_company" name="shipping_company" class="form-control shipping_company" placeholder="Please input Shipping Company" value="<?= (isset($details->shipping_company))?$details->shipping_company:'None'?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="shipping_company_rn" class="col-sm-4 control-label">Shipping Company Reference No. </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="shipping_company_rn" name="shipping_company_rn" class="form-control shipping_company_rn" placeholder="Please input Shipping Company Reference No" value="<?= (isset($details->shipping_company_rn))?$details->shipping_company_rn:'None'?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="bill_lading_number" class="col-sm-4 control-label">Bill of Lading Number</label>
                                    <div class="col-sm-8">
                                        <input type='text' id="bill_lading_number" name="bill_lading_number" class="form-control bill_lading_number" placeholder="Please input Bill of Lading Number" value="<?= (isset($details->bill_lading_number))?$details->bill_lading_number:'None'?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="loading_place" class="col-sm-4 control-label">Loading Place </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="loading_place" name="loading_place" class="form-control loading_place " placeholder="Please input Loading Place" value="<?= (isset($details->loading_place))?$details->loading_place:'None'?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="shipping_company_rn" class="col-sm-4 control-label">Shipping Vessel </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="shipping_vessel" name="shipping_vessel" class="form-control shipping_vessel " placeholder="Please input Shipping Vessel" value="<?= (isset($details->shipping_vessel))?$details->shipping_vessel:'None'?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="estimated_arrival_date" class="col-sm-4 control-label">Estimated Arrival Date <span class="req">*</span></label>
                                    <div class="col-sm-8">
                                        <input type='text' id="estimated_arrival_date" name="estimated_arrival_date" class="form-control estimated_arrival_date futuredatepicker required" data-field="Date" placeholder="dd/mm/yyyy" value="<?= (isset($details->estimated_arrival_date))?date('m/d/Y', strtotime($details->estimated_arrival_date)):''?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="container_number" class="col-sm-4 control-label">Container Number </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="container_number" name="container_number" class="form-control container_number" placeholder="Please input Container Number" value="<?= (isset($details->container_number))?$details->container_number:'None'?>" />
                                    </div>
                                </div>
                            </div>
							<div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="container_number" class="col-sm-4 control-label">Freight Cost </label>
                                    <div class="col-sm-8">
                                        <input type='text' id="freight" name="freight" class="form-control freight" placeholder="Please input freight cost" value="<?= (isset($details->freight))?$details->freight:'0.00'?>" />
                                    </div>
                                </div>
                            </div>
							 <div class="col-sm-6 m-b-10">
                                <div class="form-group">
                                    <label for="cbm_area_type" class="col-sm-4 control-label">Taxes</label>
                                    <div class="col-sm-8">
                                        <select name="is_festive" id="is_festive" class="form-control is_festive">
                                            <option value="0" <?= ((!empty($details)) && $details->is_festive==0)?'selected':'';?>>Normal</option>
											<option value="1" <?= ((!empty($details)) && $details->is_festive==1)?'selected':'';?>>Festive (Tax Free)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="clearfix"></div><br>
                        <div class="box-footer text-center">
                            <div class="col-sm-8">
                                <input type="submit" name="saveShipment" id="saveShipment" class="btn btn-primary m-r-20" value='Save Shipment' />
                                <input type="submit" name="generateShipment" id="generateShipment" class="btn btn-primary m-r-20" value="Generate Shipment" />
                                <a href="<?=$main_page; ?>" class="btn btn-danger  m-r-20">Cancel</a>
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

    </div>
<?= $footer_start ?>
    <!-- Add aditional js script & files -->
    <script src="<?= $COMP_DIR ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= $JS_DIR ?>shipments.js" type="text/javascript"></script>
    <script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>
    <script>
        $('.futuredatepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
        });

        var AJAX_URL='<?= base_url('ajax/') ?>';

        validate_form();

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
    <!-- End js script -->
<?= $footer_end ?>