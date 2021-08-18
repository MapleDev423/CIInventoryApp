<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
$porderid=(isset($details->porderid))?$details->porderid:$order_no_new;
$file_name="FFC-".$porderid.".xls";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$file_name");
header("Pragma: no-cache");
header("Expires: 0");
?>
          
                    
           
                <table cellpadding="0" cellspacing="0" border="1" id="table-1" class="display mytable">
				
                    <thead>
						<tr><td colspan="10" align="center" style="font-size: large; ">Flowers For Cemeteries Purchase Order</td></tr>
						<tr>
						<th align="left">PO #</th>
						<th colspan="5" align="left"><?=$porderid?></th>
						<th colspan="3" align="left">PO Date:</th>
						<th align="right"><?=$details->po_date?></th>
						</tr>
						<tr>
						<th>Manufacturer</th>
						<th colspan="5" align="left"><? 
							foreach ($manufacturer as $company){
								//print_r($company);
								//echo "<br>";
							 if($company->ID == $details->manufacturer_id)
								echo $company->name;
							}
							?></th>
						<th colspan="3" align="left">Requested Ship Date:</th>
						<th align="right"><?=$details->shipping_date?></th>
						</tr>
						<tr><th colspan="10"> </th></tr>
                            <tr>
                                <th>Item Number</th>
                                <th>Item Color</th>
                                <th>Price</th>
                                <th>MOQ</th>
                                <th>CS Pack</th>
                                <th class="area_type"><?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                                <th>Cases</th>
                                <th>PCS</th>
                                <th>Cost</th>
                                <th class="total_area_type">Total <?=(isset($details->cbm_area_type))?$details->cbm_area_type:"CBM";?></th>
                            </tr>
                    </thead>
                  
                        <?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){$i= count($details->parts);
                            foreach ($details->parts as $partsData) { 
                        ?>
                        <tr>
                            <td align="left"> <?php 
                               if(!empty($partsList)){foreach($partsList as $value){
                                   if($partsData && $partsData->parts_id==$value->ID)echo $value->name;
                                  }} 
                                  ?>
                            </td>
                            <td>
                                    <?php if(!empty($partsData->partColorsList)){
                                      foreach($partsData->partColorsList as $value){
                                          if($value->color_code==$partsData->part_colors)echo $value->color_code;
                                              } } 
                                    ?>
                            </td>
                            <td><? echo number_format((float)getFieldVal('parts_price',$partsData),2,".",",") ?></td>
                            <td align="center"><?= getFieldVal('parts_moq',$partsData) ?></td>
                            <td><?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):'' ?></td>
                            <td><?= (getFieldVal('cbm',$partsData)>0)?number_format(getFieldVal('cbm',$partsData),2,".",","):"*"?></td>
                            <td align="center"><?= (getFieldVal('total_cases',$partsData)>0)?getFieldVal('total_cases',$partsData):'' ?></td>
                            <td><?= (getFieldVal('total_pcs',$partsData)>0)?number_format(getFieldVal('total_pcs',$partsData),0,".",","):'' ?></td>
                            <td><?= ($partsData && $partsData->total_cost>0)?number_format(getFieldVal('total_cost',$partsData),2,".",","):"0.00" ?></td>
                            <td><? if($partsData && $partsData->total_cbm>0)
										echo number_format(getFieldVal('total_cbm',$partsData),2,".",",");
									else 
										echo "*"; ?></td>
                            
                        </tr>
                        <?php $i--;} } ?>
                       
                   
                     
                        <tr>
                            <th colspan="8" align="right">Total:  </th>
                            <th><? if($details && $details->total_cost_val>0)
										echo "$ ".number_format(getFieldVal('total_cost_val',$details),2,".",",");
									else
										echo "*";
										
									?></th>
                            <th><? if($details && $details->total_cbm_val>0)
										echo number_format(getFieldVal('total_cbm_val',$details),2,".",",");
									else
										echo "*"; 
								?></th>
                        </tr>
                    
                </table>
