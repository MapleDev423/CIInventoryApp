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
                            <div class="col-sm-6 p-0"><h2 class="box-title">Add <?= $heading ?></h2></div>
                            <div class="col-sm-6 text-right">
                                <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <?= form_open_multipart('', 'class="myform ffform-horizontal" id="myform"'); ?>
                        <div class="box-body">
                            <?php $ID= (isset($details->ID))?$details->ID:""; ?>
                            <input type="hidden" name="ID" value="<?= $ID ?>">
                            <div class="col-sm-12 m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Name<span class="req">*</span></label>

                                        <div class="col-sm-8">
                                            <input class="form-control required" id="name" placeholder="Enter name" type="text" name="name" value="<?= getFieldVal('name',$details) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 control-label">Short Name <span class="req">*</span></label>

                                        <div class="col-sm-8">
                                            <input class="form-control required" id="sname" placeholder="Enter Manufacturer Short Name" type="text" name="sname" value="<?= getFieldVal('sname',$details) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label">Email</label>

                                        <div class="col-sm-8">
                                            <input class="form-control" id="email" placeholder="Enter email" type="email" name="email" value="<?= getFieldVal('email',$details) ?>">
                                            <span class="error"><?= getFlashMsg('email_exist'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="representative" class="col-sm-4 control-label">Representative</label>

                                        <div class="col-sm-8">
                                            <input class="form-control" id="representative" placeholder="Enter representative" type="text" name="representative" value="<?= getFieldVal('representative',$details) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="owner" class="col-sm-4 control-label">Owner</label>

                                        <div class="col-sm-8">
                                            <input class="form-control" id="owner" placeholder="Enter owner" type="text" name="owner" value="<?= getFieldVal('owner',$details) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="notes" class="col-sm-4 control-label">Notes</label>

                                        <div class="col-sm-8">
                                            <textarea name="notes" class="form-control" id="notes" placeholder="Enter Notes"><?= getFieldVal('notes',$details) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="account_number" class="col-sm-4 control-label">Account Number </label>

                                        <div class="col-sm-8">
                                            <input class="form-control account_number" id="account_number" placeholder="Enter Account Number" type="text" name="account_number" value="<?= getFieldVal('account_number',$details) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="bank_name" class="col-sm-4 control-label">Bank Name </label>

                                        <div class="col-sm-8"><input class="form-control bank_name" id="bank_name" placeholder="Enter Bank Name" type="text" name="bank_name" value="<?= getFieldVal('bank_name',$details) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="bank_address" class="col-sm-4 control-label">Bank Address </label>

                                        <div class="col-sm-8">
                                            <textarea class="form-control bank_address " id="bank_address" placeholder="Enter Bank Address" name="bank_address"><?= getFieldVal('bank_address',$details) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="swift" class="col-sm-4 control-label">SWIFT </label>

                                        <div class="col-sm-8">
                                            <input class="form-control swift" id="swift" placeholder="Enter SWIFT" type="text" name="swift" value="<?= getFieldVal('swift',$details) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="telex" class="col-sm-4 control-label">TELEX </label>

                                        <div class="col-sm-8">
                                            <input class="form-control telex" id="telex" placeholder="Enter TELEX" type="text" name="telex" value="<?= getFieldVal('telex',$details) ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address" class="col-sm-4 control-label">Address </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control address" id="address" placeholder="Enter Address" name="address"><?= getFieldVal('address',$details) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 m-b-10">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="postal_code" class="col-sm-4 control-label">Postal Code </label>
                                        <div class="col-sm-8">
                                            <input class="form-control postal_code" id="postal_code" placeholder="Enter Postal Code" type="text" name="postal_code" value="<?= getFieldVal('postal_code',$details) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div><br>
                            <div class="box-footer text-center">
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-primary m-r-20">Submit</button>
                                    <a href="<?= $main_page ?>" class="btn btn-danger">Cancel</a>
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

<?= $footer_start ?>
    <!-- Add aditional js script & files -->

    <script>
        validate_form();

        $(document).on('click', '#addNew', function(event) {
            var parts=$(".sResult:first").find('.parts').val();
            var price=$(".sResult:first").find('.price').val();

            if(parts!='' && price!=''){
                $(".sResult:first").clone().prependTo('div#addCont');
                $('#addCont .sResult:first').find(".addIcon").html('');
                $('#addCont  .sResult:first').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');
                var parts=$(".sResult:first").find('.parts').val();
                $(".sResult:first").find('input').val('');
                $('.sResult:first').find('.parts').val('');
                $('#addCont .sResult:first').find('.parts').val(parts);
            }else{
                if(parts==''){
                    $(".sResult:first").find('.parts').addClass('error_field');
                }else{$(".sResult:first").find('.parts').removeClass('error_field');}
                if(price==''){
                    $(".sResult:first").find('.price').addClass('error_field');
                }else {
                    $(".sResult:first").find('.price').removeClass('error_field');
                }
            }

        });
        $(document).on('change','.parts',function(){
            if($(this).val()==''){
                $(this).addClass('error_field');
            }else{
                $(this).removeClass('error_field');
            }
        });
        $(document).on('input','.price',function(){
            if($(this).val()>0){
                $(this).removeClass('error_field');
            }else{
                $(this).addClass('error_field');
            }
        });
        $(document).on('click','.remove-row',function(){
            if(confirm("Are you sure want to remove?")){
                var ql_id=$(this).attr('rel');
                $(this).parent().parent().remove();
            }

        });
    </script>

    <!-- End js script -->
<?= $footer_end ?>