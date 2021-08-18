
<?php if(!empty($details)){?>

<tr>
<th <?= (!checkModulePermission(16,5))?'colspan="7"':'colspan="9"'?> style="text-align: right;padding-right: 45px;">Total</th>
<th class="text-center">
<input class="form-control total_cost_val_hidden text-center numbers" type="hidden" name="total_cost_val" id="total_cost_val" value="<?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?>">

<span class="total_cost_val"><?= ($details && $details->total_cost_val>0)?getFieldVal('total_cost_val',$details):0 ?></span>
</th>
<th class="text-center">
<input class="form-control total_cbm_val_hidden text-center numbers" type="hidden" name="total_cbm_val" value="<?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?>">
<span class="total_cbm_val"><?= ($details && $details->total_cbm_val>0)?getFieldVal('total_cbm_val',$details):0 ?></span>
</th>
<th class="text-center">&nbsp;</th>
</tr>

<?php }
?>