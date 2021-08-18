<?= $header_start ?>
<!-- Add aditional CSS script & Files -->
 <link rel="stylesheet" href="<?= $COMP_DIR ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<!-- End css script -->

<?= $header_end ?>

<?= $menu ?>
<style>
    td, th {
	padding: 5px;
}
.mytable select { 
width:120px; }
</style>
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
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
              <div class="box-body">
                    <?php $ID= (isset($details->stockissue_id))?$details->stockissue_id:""; ?>
                    <input type="hidden" name="ID" value="<?= $ID ?>">
            <?php if(isset($details->stockissue_id)){?>
                 <div class="col-sm-12">
                <div class="form-group">
                  <label for="porderid" class="col-sm-2 control-label">Manufacture Planning Id</label>

                  <div class="col-sm-4">
                    <input class="form-control required stockissue_id" id="stockissue_id" type="text" name="stockissue_id" value="<?= (isset($details->stockissue_id))?$details->stockissue_id:''?>" readonly>
                  </div>
                </div>
                    </div>
                    <?php } ?>
			
				<div class="col-sm-6">
				<div class="form-group">
                  <label for="issue_date" class="col-sm-4 control-label">Date<span class="req">*</span></label>

                  <div class="col-sm-8">
                    <input class="form-control required" id="issue_date" type="text" name="issue_date" value="<?= date('m/d/Y') ?>" >
                  </div>
                </div>
              </div>
			
			<div class="col-sm-6">
                <div class="form-group">
                  <label for="assembly_line" class="col-sm-4 control-label">Assembly Line<span class="req">*</span></label>
                  
                  <div class="col-sm-8">
                      <select name="assembly_line" id="assembly_line" class="form-control assembly_line select2 required">
                        <option value="">Select Assembly Line</option>
                      <?php if($assemblyline_detail){
                                foreach($assemblyline_detail as $assemblyline) {?>
                                    <option value="<?= $assemblyline->ID;?>" <?= ($details && $details->assemblyline_id==$assemblyline->ID)?'selected':'' ?>><?= $assemblyline->title;?></option>
                        <?php }} ?>
					  </select>
                  </div>
                </div>
               </div>
			   
				<div class="col-sm-6">
                <div class="form-group">
                  <label for="product_id" class="col-sm-4 control-label">Product Name<span class="req">*</span></label>
                  
                  <div class="col-sm-8">
                      <select name="product_id" id="product_id" class="form-control product_id select2 required">
                        <option value="">Select Product Name</option>
						<?php if($product_detail){
                                foreach($product_detail as $product) {?>
                                    <option value="<?= $product->ID;?>" <?= ($details && $details->product_id==$product->ID)?'selected':'' ?>><?= $product->product_id;?></option>
                        <?php }} ?>
                      </select>
                  </div>
                </div>
               </div>   
			   
			   
			   	<div class="col-sm-6">
                <div class="form-group">
                  <label for="bom_id" class="col-sm-4 control-label">Bom Name<span class="req">*</span></label>
                  
                  <div class="col-sm-8">
                      <select name="bom_id" id="bom_id" class="form-control bom_id select2 required">
                        <option value="">Select Bom Name</option>
                      </select>
                  </div>
                </div>
               </div>
			   <div class="col-sm-6">
                <div class="form-group">
                  <label for="quantity" class="col-sm-4 control-label">Quantity<span class="req">*</span></label>
                  
                  <div class="col-sm-8">
                     <input class="form-control required quantity" id="quantity" type="text" name="quantity" value="<?= (isset($details->quantity))?$details->quantity:''?>">
                   </div>
                </div>
               </div>   
			 
		
			 <div class="col-sm-12">
                   
              <div class="col-sm-12  p-tb-4 m-t-5">
                <div style="overflow-x:auto;">
                <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable text-center" style="overflow-x:auto;width:100%">
				
                   <thead>
                            <tr>
                            <th>Manufacturer Name</th>
                            <th>Item Name</th>
                            <th>Item Color</th>
                            <th>Item Color Image</th>
                            <th>Unit</th>
                            <th>No. Of Quantity</th> 
                            <th>Item Price</th>                            
                            <th>Cost</th>
                          </tr>
                        </thead>
                        <tbody id="addCont">
                         
						  <tr class="radius sResult">
							 <td>
                                <input class="form-control manufacturer_name text-center numbers" id="manufacturer_name" type="text" name="manufacturer_name[]" placeholder="Manufacturer Name" readonly="readonly">
                            </td>
                            <td>
                                <input class="form-control part_name text-center" id="part_name" type="text" name="part_name[]" value="" placeholder="part Name" readonly="readonly">
                            </td>
                            <td>
                                <input class="form-control part_colors text-center numbers" id="part_colors" placeholder="Part Colors" type="text" name="part_colors[]" value="" readonly="readonly">
                            </td>
							<td style="height:150px;weight:150px;">
                                <div class="parts_img text-center" ></div>
                            </td>
                           
                            <td>
                              <input class="form-control text-center unit_title" id="unit_title" type="text"  name="unit_title[]" placeholder="Unit Title" readonly="readonly">
                            </td>
							<td>
                              <input class="form-control text-center quantity number" id="quantity" type="text"  name="quantity[]" placeholder="Quantity" readonly="readonly">
                            </td>
							<td>
                              <input class="form-control text-center price" id="price" type="text"  name="price[]" placeholder="Price" readonly="readonly">
                            </td>
						  <td>
                              <input class="form-control text-center cost number" id="cost" type="text"  name="cost[]" placeholder="Cost" readonly="readonly">
                          </td>
					</tr>
			    </tbody>
				<tfoot>
				<tr>
				<td colspan="7" class="text-center">Total </td>
				<td>
				<span class="totalcost_span">0.00</span>
				<input class="form-control text-center totalcost number" id="totalcost" type="hidden"  name="totalcost" placeholder="Total Cost" readonly="readonly">
                </td>
				</tr>
				</tfoot>
                </table>
                  </div>
                 </div>
			
                <div class="clearfix"></div><br>
                <div class="box-footer text-center">
                  <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary m-r-20">Stock Issue</button>
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
<script src="<?= $COMP_DIR ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= $JS_DIR ?>manufactureplanning.js" type="text/javascript"></script>
<script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>

<script>
var AJAX_URL='<?= base_url('ajax/') ?>';
validate_form();
$(function () {

  $('#issue_date').datepicker({
      autoclose: true
    })

});
</script>

<!-- End js script -->
<?= $footer_end ?>