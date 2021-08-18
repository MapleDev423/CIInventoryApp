<?php if(!empty($details)){?>
<?php if(  isset($details->parts) && $details->parts && count($details->parts)>0){ 
$i= 0;
$sub_alltotal_currentstock=0.00;
$sub_total_received=0.00;
foreach ($details->parts as $partsData) { 
//if($partsData->total_cases!=$partsData->total_receipted){    
?>
<tr class="radius sResult<?= $pi_no; ?> <?php if($partsData->total_cases==$partsData->total_receipted){echo 'no-print';}?>">
<td>
<input type="hidden" class="pi_id" name="pi_id[]" value="<?= $pi_no; ?>">
<input type="hidden" name="pi_parts_id[]" value="<?= $partsData->ID; ?>">
<input type="hidden" name="parts_id[]" value="<?= $partsData->parts_id; ?>">
<input type="hidden" name="manufacturer[]" value="<?= $partsData->manufacturer_id; ?>" readonly>
<?=$partsData->manufacturer_name;?>
</td>  
<td><?=$partsData->part_name;?></td>
<td><?=$partsData->part_colors;?>
<input type="hidden" name="part_colors[]" value="<?=$partsData->part_colors;?>">
</td>
<td>
<div class="parts_img text-center" >
<img src="<?= $partsData->part_img ?>" alt="Parts Color Image" style="height: 150px; width: 150px;">
</div>
</td>

<td class="no-print">
<input class="form-control currentstock numbers text-center currentstock<?= $pi_no.'_'.$i; ?>" id="currentstock" placeholder="CS Pack" type="text" name="currentstock[]" value="<?= (getFieldVal('total_cases',$partsData)>0)?getFieldVal('total_cases',$partsData):'' ?>" readonly>
</td>
<td class="receipted_td  no-print" style="display:none">
<input class="form-control total_receipted text-center numbers total_receipted<?= $pi_no.'_'.$i; ?>" id="total_receipted" type="text" name="total_receipted[]" value="<?= ($partsData && $partsData->total_receipted>0)?getFieldVal('total_receipted',$partsData):0 ?>" placeholder="Total Receipted" readonly>
</td>  
<td>
<input class="form-control total_pending text-center numbers total_pending<?= $pi_no.'_'.$i; ?>" id="total_pending" type="text" name="total_pending[]" value="<?= ($partsData && $partsData->total_cases>0)?$partsData->total_cases-$partsData->total_receipted:0 ?>" placeholder="Total Pending" readonly>
</td>
<td>
<input class="form-control total_receipt text-center numbers no-print total_receipt<?= $pi_no; ?>" id="total_receipt" type="text" name="total_receipt[]" <?php if($partsData->total_cases==$partsData->total_receipted){echo "value='0' readonly";}?>>
</td> 
</tr>
<?php 
$sub_alltotal_currentstock+=$partsData->total_cases;
$sub_total_received+=$partsData->total_receipted;
$i++;
}}
?>
<tr class="no-print sResult<?= $pi_no; ?>" style="display:none">
<td colspan="4">
<span class="span_sub_pi_id span_sub_pi_id<?= $pi_no; ?>"><?= $pi_no; ?></span>
<input class="form-control number sub_pi_id sub_pi_id<?= $pi_no; ?>" type="text" name="sub_pi_id[]" value="<?= $pi_no; ?>" readonly>				<!--if want check condition receipt not null then save empty this valur-->
</td>
<td>
<input class="form-control number sub_alltotal_currentstock" id="sub_alltotal_currentstock" type="text" name="sub_alltotal_currentstock[]" value="<?=$sub_alltotal_currentstock;?>" readonly>
<input class="form-control number sub_total_currentstock sub_total_currentstock<?= $pi_no; ?>" id="sub_total_currentstock" type="text" name="sub_total_currentstock[]" value="0" readonly>
</td>
<td>
<input class="form-control number sub_alltotal_received sub_alltotal_received<?= $pi_no; ?>" id="sub_alltotal_received" type="text" name="sub_alltotal_received[]" value="<?=$sub_total_received;?>" readonly>
<input class="form-control number sub_total_received sub_total_received<?= $pi_no; ?>" id="sub_total_received" type="text" name="sub_total_received[]" value="0" readonly>
</td>
<td>
<input class="form-control number sub_total_pending sub_total_pending<?= $pi_no; ?>" id="sub_total_pending" type="text" name="sub_total_pending[]" value="0" readonly>
</td>
<td>
<input class="form-control number sub_total_receiving sub_total_receiving<?= $pi_no; ?>" id="sub_total_receiving<?= $pi_no; ?>" type="text" name="sub_total_receiving[]" value='0' readonly>
</td>
</td>
</tr>
<?php } ?>   
