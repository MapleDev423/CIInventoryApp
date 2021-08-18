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
                  <a href="<?= $main_page ?>/addedit" class="btn btn-primary">Add</a>
                  <a href="javascript:;" class="btn btn-danger" onclick="return deleterecord();">Delete</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?= form_open('', 'class="tableForm form-horizontal" id="tableForm"'); ?>
              <div class="table-responsive">
              <table id="mytable" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th  class="nosort width-20 p-r-0"><input type="checkbox" id="checkAll"> </th>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th  class="nosort p-r-0">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                 $status=singleAction('deactive','',1);
                 $delete=singleAction('delete','',1);
                 ?>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td class="action">
                      <a href="<?= $main_page ?>/addedit" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="javascript:;" title="Active" onclick="singleAction(<?= $status ?>)">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="javascript:;" title="Delete" onclick="singleAction(<?= $delete ?>)">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 5.0
                  </td>
                  <td>Win 95+</td>
                  <td>5</td>
                  <td class="action">
                      <a href="<?= $main_page ?>/addedit" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Dective">
                        <i class="fa fa-ban icon deactive" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 5.5
                  </td>
                  <td>Win 95+</td>
                  <td>5.5</td>
                  <td class="action">
                      <a href="<?= $main_page ?>/addedit" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 6
                  </td>
                  <td>Win 98+</td>
                  <td>6</td>
                  <td class="action">
                      <a href="<?= $main_page ?>/addedit" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active" onclick="singleAction(<?= $status ?>)">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Trident</td>
                  <td>Internet Explorer 7</td>
                  <td>Win XP SP2+</td>
                  <td>7</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Trident</td>
                  <td>AOL browser (AOL desktop)</td>
                  <td>Win XP</td>
                  <td>6</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Firefox 1.0</td>
                  <td>Win 98+ / OSX.2+</td>
                  <td>1.7</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Firefox 1.5</td>
                  <td>Win 98+ / OSX.2+</td>
                  <td>1.8</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Firefox 2.0</td>
                  <td>Win 98+ / OSX.2+</td>
                  <td>1.8</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Firefox 3.0</td>
                  <td>Win 2k+ / OSX.3+</td>
                  <td>1.9</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Camino 1.0</td>
                  <td>OSX.2+</td>
                  <td>1.8</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Camino 1.5</td>
                  <td>OSX.3+</td>
                  <td>1.8</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Netscape 7.2</td>
                  <td>Win 95+ / Mac OS 8.6-9.2</td>
                  <td>1.7</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Netscape Browser 8</td>
                  <td>Win 98SE+</td>
                  <td>1.7</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Netscape Navigator 9</td>
                  <td>Win 98+ / OSX.2+</td>
                  <td>1.8</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                <tr>
                  <th><input type="checkbox" class="checkboxitem" value="" name="item_ids[]"> </th>
                  <td>Gecko</td>
                  <td>Mozilla 1.0</td>
                  <td>Win 95+ / OSX.1+</td>
                  <td>1</td>
                  <td class="action">
                      <a href="" title="Edit">
                        <i class="fa fa-pencil-square icon edit" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Active" onclick="singleAction(<?= $status ?>)">
                        <i class="fa fa-check-circle icon active" aria-hidden="true"></i>
                      </a>
                      <a href="" title="Delete"  onclick="singleAction(<?= $delete ?>)">
                        <i class="fa fa-trash icon delete" aria-hidden="true"></i>
                      </a>
                     
                  </td>
                </tr>
                
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
  dataTable();
</script>

<!-- End js script -->
<?= $footer_end ?>