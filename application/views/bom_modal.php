<div class="modal-dialog modal-lg" style="color: #000;">
    <div class="modal-content">
        <div  class="col-md-12 col-sm-12 col-xs-12 p-0">
        <div class="modal-header" style="background-color:#3c8dbc;">
           <h4 class="modal-title text-white" id="myModalLabel2"><?= $resultList->title;?></h4>             
        </div>
        <div class="modal-body">
        <!-- modal body starts -->
             <!-- 1st container -->
          
            <div class="row">
                <div class="form-group">
                  <label for="phone_no" class="col-sm-2 control-label text-right">Product :</label>
                  
                  <div class="col-sm-10">
                    <span><?= $resultList->product_name;?></span>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                  <label for="note" class="col-sm-2 control-label text-right">Note :</label>

                  <div class="col-sm-10">
                      <span><?= $resultList->note;?></span>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      
                      <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th>Manufacturer Name</th>
                            <th>Parts Name</th>
                            <th>Parts Color</th>
                            <th>Parts Color Image</th>
                            <th>Unit</th>
                            <th>No. Of Quantity</th> 
                            <?php if(checkModulePermission(8,5)){ ?>                           
                            <th>Parts Price</th>                            
                            <th>Cost</th>
                            <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                         <?php if(  isset($resultList->parts) && $resultList->parts && count($resultList->parts)>0){ $total_cost=0;
                        foreach ($resultList->parts as $partsData) {
                            ?>
                          <tr>
                            <td><?= $partsData->manufacturer_name?></td>
                            <td><?= $partsData->part_name?></td>
                            <td><?= $partsData->part_colors?></td>
                            <td><img src="<?= ($partsData->partColors_imgpath!='')?$partsData->partColors_imgpath:$this->config->item('PARTS_DATA_DISP').'not-available.jpg'; ?>" alt="Parts image" style="height: 30px;"></td>
                            <td><?= $partsData->unit_title?></td>
                            <td><?=  (float)$partsData->quantity?></td>
                            <?php if(checkModulePermission(8,5)){ ?>
                            <td><?= $partsData->price?></td>
                            <td><?= $partsData->part_cost?></td>
                            <?php } ?>
                          </tr>
                         <?php }

                         ?>
                          <?php if(checkModulePermission(8,5)){ ?>
                          <tr>
                              <th colspan="7" class="text-right">Total Cost: </th>
                              <td><?= (isset($resultList->total_cost))?$resultList->total_cost:0 ?></td>
                          </tr>
                          <?php } ?>
                         <?php

                         }else{?>

                          <tr><td colspan='8' class="t-c">No Record Found</td></tr>
                         <?php } ?>
                         

                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
            <div class="ln_solid"></div>
   
            <div class="modal-footer">
               
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
       
        </div>
        </div>
        <div class="clearfix"></div>
 <!-- modal body ends -->
   </div>
</div>
