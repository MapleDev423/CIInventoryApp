<?= $header_start ?>

<!-- Add aditional CSS script & Files -->



<!-- End css script -->

<?= $header_end ?>

<?= $menu ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $total_manufacturer ?></h3>

              <p>Active Manufacturer</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="<?= $BASE_URL ?>manufacturer" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?=  $total_parts ?></h3>

              <p>Active Parts</p>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
            <a href="<?= $BASE_URL ?>parts" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $total_products ?></h3>

              <p>Active Products</p>
            </div>
            <div class="icon">
              <i class="fa fa-certificate"></i>
            </div>
            <a href="<?= $BASE_URL ?>products" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= $total_bom ?></h3>

              <p>Active BOM</p>
            </div>
            <div class="icon">
              <i class="fa fa-life-ring"></i>
            </div>
            <a href="<?= $BASE_URL ?>bom" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
 

<?= $footer_start ?>
<!-- Add aditional js script & files -->

<!-- Morris.js charts -->
<script src="<?= $COMP_DIR ?>raphael/raphael.min.js"></script>
<script src="<?= $COMP_DIR ?>morris.js/morris.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= $JS_DIR ?>pages/dashboard.js"></script>

<!-- End js script -->
<?= $footer_end ?>