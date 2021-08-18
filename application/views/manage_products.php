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
                                <a href="javascript:void(0)" class="btn btn-info" onclick="location.reload();">Refresh</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-6 col-sm-offset-2"><?= getFlashMsg('success_message'); ?></div>
                            <div class="clearfix"></div>

                            <?= form_open('', 'class="tableForm form-horizontal" id="tableForm"'); ?>
                            <div class="table-responsive">
                                <table id="mytable" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th  class="nosort p-r-0">Product Image</th>
                                        <th>Product Id</th>
                                        <th>Product Name</th>
                                        <th  class="nosort p-r-0">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($resultList){
                                        foreach ($resultList as  $value) {
                                            $ID=$value->ID;
                                            ?>
                                            <tr>
                                                <?php if(checkModulePermission(8,1)){ ?>
                                                    <td>
                                                        <a href="<?= $main_page ?>/product_boms/<?= md5($ID); ?>"><img src="<?= 'https://www.flowersforcemeteries.com/'.$value->image; ?>" alt="Product Image" style="height: 50px;" ></a>
                                                    </td>
                                                    <td><?= $value->product_id; ?></td>
                                                    <td><a href="<?= $main_page ?>/product_boms/<?= md5($ID); ?>"><?= $value->name; ?></a>
                                                    </td>
                                                    <td class="action">
                                                        <?php if(checkModulePermission(7,2)){ ?>
                                                            <a href="<?= $main_page ?>/addedit/<?= md5($ID) ?>" title="Edit">
                                                                <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                <?php }else{ ?>
                                                    <td><img src="<?= 'https://www.flowersforcemeteries.com/'.$value->image; ?>" alt="Product Image" style="height: 50px;" ></td>
                                                    <td><?= $value->product_id; ?></td>
                                                    <td><?= $value->name; ?></td>
                                                    <td class="action">
                                                        <?php if(checkModulePermission(7,2)){ ?>
                                                            <a href="<?= $main_page ?>/addedit/<?= md5($ID) ?>" title="Edit">
                                                                <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>


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