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
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
              <?php $ID= (isset($details->ID))?$details->ID:""; ?>
              <input type="hidden" name="ID" value="<?= $ID ?>">
              <div class="box-body">
                 <div class="form-group">
                  <label for="note" class="col-sm-2 control-label">Title<span class="req">*</span></label>

                  <div class="col-sm-6">
                       <input type="text" name="title" value="<?= getFieldVal('title',$details) ?>"  class="form-control required" placeholder="Title">
                  </div>
                </div>
                <div class="form-group">
                  <label for="phone_no" class="col-sm-2 control-label">Product</label>
                  <?php $product_id=getFieldVal('product_id',$details); ?>
                  <div class="col-sm-6">
                    <select name="product_id" id="product_id" class="form-control">
                      <option value="">Select Product</option>
                      <?php if(!empty($productsList)){foreach($productsList as $value){?>
                      <option value="<?= $value->ID ?>" <?= ($product_id==$value->ID)?'selected':''; ?> ><?= $value->product_id.' - '.$value->name?></option>
                      <?php } } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="note" class="col-sm-2 control-label">Note</label>

                  <div class="col-sm-6">
                      <textarea name="note" id="note" class="form-control" placeholder="Note"><?= getFieldVal('note',$details) ?></textarea>
                  </div>
                </div>
                
                
                <div class="col-sm-12">
                   <fieldset>
                    <legend>Parts Linking</legend>
                    <div class="col-sm-12  p-tb-4 m-t-5">
                        <div class="col-sm-3"> <strong>Manufacturer Name</strong> </div>
                        <div class="col-sm-2"> <strong>Parts Name</strong> </div>
                        <div class="col-sm-2 p-0"> <strong>Parts Color</strong> </div>
                        <div class="col-sm-2"> <strong>No.Of Quantity</strong> </div>
                        <div class="col-sm-2"> <strong>Unit</strong> </div>
                        <div class="col-sm-1 addIcon">
                        </div>
                    </div>

                    <div class="col-sm-12  p-tb-4 radius sResult m-t-5">

                        <div class="col-sm-3">
                          <select name="manufacturer_id[]" class="form-control manufacturer">
                            <option value="">Select Manufacturer</option>
                           <?php if(!empty($manufacturerList)){foreach($manufacturerList as $value){?>
                            <option value="<?= $value->ID ?>"><?= $value->name?></option>
                           <?php } } ?>
                          </select>
                        </div>
                        <div class="col-sm-2">
                          <select name="parts_id[]" class="form-control parts_id partsList">
                            <option value="">Select Parts</option>
                           
                          </select>
                          <input type="hidden" name="parts_price[]" value="0" class="parts_price">
                        </div>
                        <div class="col-sm-2 p-0">
                          <div class="col-sm-9 p-0">
                              <select name="part_colors[]" class="form-control part_colors partsColorList">
                                <option value="">Select Parts Color</option>
                               
                              </select>
                          </div>
                          <div class="col-sm-3 getPartsColorImg p-l-5">
                          
                        </div>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" name="quantity[]" value=""  class="form-control numbers quantity price" placeholder="Quantity"  maxlength="10"> 
                        </div>
                        <div class="col-sm-2">
                          <select name="unit_id[]" class="form-control unit_id unitList">
                            <option value="">Select Unit</option>
                            <?php if($unitList){
                                foreach ($unitList as $key => $value) { ?>
                                  <option value="<?= $value->ID ?>"><?= $value->title ?></option>
                            <?php }
                            } ?>
                               
                          </select> 
                        </div>
                      
                        <div class="col-sm-1 addIcon">
                          <i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div id="addCont">
                      
                      <?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){ $total_cost=0;
                        foreach ($details->parts as $partsData) {

                         

                        ?>
                          <div class="col-sm-12  p-tb-4 radius sResult m-t-5">
                            
                            <div class="col-sm-3">
                              <select name="manufacturer_id[]" class="form-control manufacturer">
                                <option value="">Select Manufacturer</option>
                               <?php if(!empty($manufacturerList)){foreach($manufacturerList as $value){?>
                                <option value="<?= $value->ID ?>" <?= ($value->ID==$partsData->manufacturer_id)?"selected":""; ?> ><?= $value->name?></option>
                               <?php } } ?>
                              </select>
                            </div>
                            <div class="col-sm-2">
                               <input type="hidden" name="parts_price[]" value="<?= $partsData->part_cost ?>" class="parts_price">
                              <select name="parts_id[]" class="form-control parts_id partsList">
                                <option value="">Select Parts</option>
                                <?php if(!empty($partsData->partsList)){
                                  foreach($partsData->partsList as $value){?>
                                  <option value="<?= $value->ID ?>" <?= ($value->ID==$partsData->parts_id)?"selected":""; ?> ><?= $value->name?></option>
                                 <?php } } ?>
                              </select>
                            </div>
                            <div class="col-sm-2 p-0">
                              <div class="col-sm-9 p-0">
                                  <select name="part_colors[]" class="form-control part_colors partsColorList">
                                    <option value="">Select Parts Color</option>
                                    <?php if(!empty($partsData->partColorsList)){
                                      foreach($partsData->partColorsList as $value){?>
                                      <option value="<?= $value->color_code ?>" <?= ($value->color_code==$partsData->part_colors)?"selected":""; ?> ><?= $value->color_code?></option>
                                    <?php } } ?>
                                  </select>
                              </div>
                              <div class="col-sm-3 getPartsColorImg p-l-5">
                                <img src="<?= $partsData->partColors_imgpath; ?>" alt="Part Color Image" style="height: 30px; width: 40px;">
                              </div>
                            </div>
                            
                            <div class="col-sm-2">
                              <input name="quantity[]" value="<?=  (float)$partsData->quantity?>" class="form-control numbers quantity " placeholder="Quantity"  type="text" maxlength="10"> 
                            </div>
                            <div class="col-sm-2">
                              <select name="unit_id[]" class="form-control unit_id unitList">
                                <option value="">Select Unit</option>
                                <?php if($unitList){
                                    foreach ($unitList as $key => $value) { ?>
                                      <option value="<?= $value->ID ?>" <?= ($value->ID==$partsData->unit_id)?"selected":""; ?> ><?= $value->title ?></option>
                                <?php }
                                } ?>
                                   
                              </select> 
                            </div>
                                <div class="col-sm-1"><i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i></div>
                            </div>
                        <?php
                        }
                      } ?>

                    </div>

                    <div class="clearfix"></div>
                    <?php if(checkModulePermission(8,5)){ ?>
                    <div class="col-sm-12 m-t-10 p-t-5 costBox" style="border-top: 1px solid #e5e5e5;">
                    <input type="hidden" name="total_cost" class="total_cost_val" value="<?= (isset($details->total_cost))?$details->total_cost:'' ?>">
                        <div class="col-sm-11">
                          <p class="t-r f-s-20"><strong>Total Cost:</strong> 
                          <span class="total_cost"><?= (isset($details->total_cost))?$details->total_cost:"0.00" ?></span> 
                          </p>
                        </div>
                    </div>
                    <?php } ?>
                  </fieldset>
                    
                </div>  
                <div class="clearfix"></div><br>
                <div class="box-footer text-center">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary submit m-r-20">Submit</button>
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

<script src="<?= $JS_DIR ?>bom.js" type="text/javascript"></script>

<script>
var AJAX_URL='<?= base_url('ajax/') ?>';
validate_form();

</script>
<!-- End js script -->
<?= $footer_end ?>