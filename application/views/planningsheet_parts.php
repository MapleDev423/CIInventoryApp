<?php if(!empty($details)){?>
<?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){$i= count($details->parts);
foreach ($details->parts as $partsData) { 
?>
<tr class="radius sResult">

<td>  
<input class="form-control pID numbers text-center" id="pID" type="hidden" name="pID" value="<?= getFieldVal('parts_id',$partsData) ?>">
<select name="parts_id[]" id="parts_id" class="form-control parts_id  parts_<?= $partsData->parts_id ?> required">
<option value="">Select Part</option>
<?php if(!empty($partsList)){foreach($partsList as $value){?>
<option value=<?= $value->ID ?> <?= ($partsData && $partsData->parts_id==$value->ID)?'selected':'' ?>><?= $value->name ?></option>
<?php }} ?>
</select>
<span class="edit_parts">
<a data-toggle="modal" data-target=".bs-example-modal-lg2" href="" data-target="#myModal" class="edit_row"><i class="fa fa-pencil-square icon edit " aria-hidden="true"></i></a>
</span>
</td>
<td>
<select name="part_colors[]" class="form-control partsColorList">
<option value="">Select Parts Color</option>
<?php if(!empty($partsData->partColorsList)){
foreach($partsData->partColorsList as $value){?>
<option value="<?= $value->color_code ?>" <?= ($value->color_code==$partsData->part_colors)?"selected":""; ?> ><?= $value->color_code?></option>
<?php } } ?>
</select>
</td>
<td>
<div class="parts_img text-center" >
<img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
</div>
</td>
<td  <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
<input class="form-control parts_price numbers text-center price_<?= $partsData->parts_id ?> required" id="parts_price" type="text" name="parts_price[]" value="<?= getFieldVal('parts_price',$partsData) ?>" placeholder="Price">
</td>
<td>
<input class="form-control moq numbers text-center moq_<?= $partsData->parts_id ?>" id="moq" type="text" name="moq[]" value="<?= getFieldVal('parts_moq',$partsData) ?>" placeholder="MOQ" readonly="">
</td>
<td>
<input class="form-control currentstock numbers text-center cspk_<?= $partsData->parts_id ?> required" id="currentstock" placeholder="CS Pack" type="text" name="currentstock[]" value="<?= (getFieldVal('currentstock',$partsData)>0)?getFieldVal('currentstock',$partsData):'' ?>">
</td>
<td>
<input class="form-control cbm numbers text-center cbm_<?= $partsData->parts_id ?> required" id="cbm" type="text"  name="cbm[]" value="<?= (getFieldVal('cbm',$partsData)>0)?getFieldVal('cbm',$partsData):'' ?>"  placeholder="<?= (isset($details->cbm_area_type))?$details->cbm_area_type:'CBM' ?>">
</td>
<td>
<input class="form-control total_cases number text-center cases_<?= $partsData->parts_id ?> required" id="total_cases" type="text" name="total_cases[]" value="<?= (getFieldVal('total_cases',$partsData)>0)?getFieldVal('total_cases',$partsData):'' ?>" placeholder="Total Cases">
</td>
<td>
<input class="form-control total_pcs number text-center pcs_<?= $partsData->parts_id ?> required" id="total_pcs" type="text" name="total_pcs[]" value="<?= (getFieldVal('total_pcs',$partsData)>0)?getFieldVal('total_pcs',$partsData):'' ?>" placeholder="Total PCS" readonly="">
</td>
<td   <?= (!checkModulePermission(16,5))?'style="display:none"':''?>>
<input class="form-control total_cost text-center numbers tcost_<?= $partsData->parts_id ?> required" id="total_cost" type="text" name="total_cost[]" value="<?= ($partsData && $partsData->total_cost>0)?getFieldVal('total_cost',$partsData):0 ?>" placeholder="Total Cost" readonly>
</td>
<td>
<input class="form-control total_cbm text-center numbers tcbm_<?= $partsData->parts_id ?> required" id="total_cbm" type="text" name="total_cbm[]" value="<?= ($partsData && $partsData->total_cbm>0)?getFieldVal('total_cbm',$partsData):0 ?>" placeholder="Total <?= (isset($details->cbm_area_type))?$details->cbm_area_type:'CBM' ?>" readonly>
</td>
<td align="center" class="addIcon">
<?php if($i>0){?>
<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i> 
<?php }
else{?>
<i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i> 
<?php } ?>
</td>
</tr>
<?php $i--;} } else {?>
<tr></tr>
<?php }?>

<?php }
?>

