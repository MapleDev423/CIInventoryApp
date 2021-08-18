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
                                <?php if(checkModulePermission(10,2)){ ?>
                                    <a href="<?= $main_page ?>/addedit" class="btn btn-primary">Add <?= $heading ?></a>
                                <?php } ?>
                                <?php if(checkModulePermission(10,4)){ ?>
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
                                        <?php if(checkModulePermission(10,4)){ ?>
                                            <th  class="nosort width-20 p-r-0"><input type="checkbox" id="checkAll"> </th>
                                        <?php } ?>
                                        <th>Purchase Order ID.</th>
                                        <th>Purchase Order Date</th>
                                        <th>Manufacturer</th>
                                        <?php if(checkModulePermission(10,5)){ ?>
                                            <th>Total Cost</th>
                                        <?php }?>
                                        <th>Total Area</th>
                                        <th nowrap>Requested Ship Date</th>
                                        <th nowrap>Creation Date</th>
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
                                            <tr <?php if(checkModulePermission(10,2)){ ?> class='clickable-row' <?php if($value->is_final==1 ){?>data-href="<?= $main_page ?>/view/<?= md5($ID) ?>" <?php } else { ?>data-href="<?= $main_page ?>/addedit/<?= md5($ID) ?>"<?php } }?> style="cursor: pointer;" >
                                                <?php if(checkModulePermission(10,4)){ ?>
                                                    <td><input type="checkbox" class="checkboxitem" value="<?= $ID ?>" name="item_ids[]"> </td>
                                                <?php } ?>
                                                <td><?= $value->porderid ?></td>
                                                <td><?= dateFormate($value->po_date,"m/d/Y") ?></td>
                                                <td><?= $value->manufact ?></td>
                                                <?php if(checkModulePermission(10,5)){ ?>
                                                    <td><?= $value->total_cost_val ?></td>
                                                <?php }?>
                                                <td><?= $value->total_cbm_val ?> <?= $value->cbm_area_type; ?></td>
                                                <td><?= dateFormate($value->shipping_date,"m/d/Y") ?></td>
                                                <td><?= dateFormate($value->creation_date,"m/d/Y") ?></td>
                                                <td>
                                                    <a href="Purchaseorder/generate_excel_file/<?=md5($ID)?>" class="btn btn-info m-r-10" title="Generate Excel">
                                                        <i class="fa fa-file-excel-o" style="font-size:18px;color:red"></i>
                                                    </a>
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

        $('.clickable-row').each(function () {
            $(this).children('td:not(:first):not(:last)').click(function () {
                window.location = $(this).closest('tr').data('href');
                return false;
            });


        });
    </script>

    <!-- End js script -->
<?= $footer_end ?>