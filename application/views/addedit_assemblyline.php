<?= $header_start ?>

<!-- Add aditional CSS script & Files -->
<link rel="stylesheet" href="<?= $COMP_DIR ?>select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?= $COMP_DIR ?>tags/fm.tagator.jquery.min.css">

<!-- End css script -->

<?= $header_end ?>

<?= $menu 	 ?>

  <div class="content-wrapper">
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="col-sm-6 p-0"><h2 class="box-title"><?= $mode.' '.$heading ?></h2></div>
              <div class="col-sm-6 text-right">
                  <a href="<?= $main_page ?>" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= form_open_multipart('', 'class="myform form-horizontal" id="myform"'); ?>
               <?php $ID= (isset($details->ID))?$details->ID:""; ?>
				<input type="hidden" name="ID" value="<?= $ID ?>">
				<input type="hidden" id="count" value="1">
				<div class="box-body">
                  
                  <?php if(empty($details)) {?>
                <div class="col-sm-12">
                   <fieldset>
                    <div class="col-sm-12  p-tb-4 m-t-5">
                        <div class="col-sm-4"> <strong>Name</strong> </div>
                        <div class="col-sm-5"> <strong>Description</strong> </div>
                        <div class="col-sm-3 addIcon">
                            <i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i>
                        </div>
                    </div>
                    
                     
                  <div class="clearfix"></div>
				
				<div id="addCont">
                    <div class="col-sm-12  p-tb-4 radius sResult m-t-5 border_bottom">
                       <div class="col-sm-4">
                          <input id="title" name="title[]" class="form-control title"  type="text" >
                         </div>
                        <div class="col-sm-5">
                          <textarea id="note[]" name="note[]" value=""  class="form-control "> </textarea>
                        </div>
                        <div class="col-sm-3 addIcon">
                          <i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>
                        </div>
                      <div class="clearfix"></div>
                    </div>
                    </div>
                  </fieldset>
                    <div class="clearfix"></div>
                </div>
                  <?php } else {?>
                <div class="col-sm-12">
                   <fieldset>
                        <div class="col-sm-3"> <strong>Name</strong> </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-4"> <strong>Description</strong> </div>
                        <div class="col-sm-2 addIcon" style="display:none">
                            <i class="fa fa-plus-square fa-2x text-green" id="addNew" title="Add New" aria-hidden="true"></i>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
					
                      <div id="addCont">
                      <?php if(isset($details)){?>
                        <div class="col-sm-12  p-tb-4 radius sResult m-t-5 border_bottom">
                          <div class="col-sm-4">
                             <input id="title" name="title[]" class="form-control title"  type="text" value="<?= (getFieldVal('title',$details)>0)?getFieldVal('title',$details):'' ?>">
						</div>
                        <div class="col-sm-5">
						  <textarea id="note[]" name="note[]" value=""  class="form-control "><?= $details->note; ?></textarea>
                        </div>
                            <div class="col-sm-3 addIcon">
							<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true" style="display:none"></i>
							</div>
                        </div>
                        <?php }?>
                </div>
                </fieldset>
                <div class="clearfix"></div>
                </div>
               
                <?php }?>  
                 
                <div class="clearfix"></div>
                <div class="box-footer text-center">
                  <div class="col-sm-9">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary m-r-20">Submit</button>
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
<script src="<?= $COMP_DIR ?>select2/dist/js/select2.full.min.js"></script>
<script src="<?= $COMP_DIR ?>tags/fm.tagator.jquery.js"></script>
<script>
   $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    })
</script>

<script>
validate_form();

</script>
<script>

$(document).on('click', '#addNew', function(event) {
    $("#addCont .sResult:first").clone().insertAfter($('#addCont .sResult:last'));
    $('#addCont .sResult:last').find(".title").removeClass('error_field');
	$('#addCont .sResult:last').find(".addIcon").html('');
    $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>'); 
	$("#addCont .sResult:last").find('input').val('');
	$("#addCont .sResult:last").find('textarea').val('');
	var count=parseInt($('#count').val())+1;
	$('#count').val(count);
});


$(document).on('click','.remove-row',function(){
  var count=$('#count').val();
   if(count>1){
  if(confirm("Are you sure want to remove?")){
    var ql_id=$(this).attr('rel');
    $(this).parent().parent().remove();
	var count=parseInt($('#count').val())-1;
	$('#count').val(count);	
  }
  }else{
	alert('Not delete last row');  
  }
});

$(document).on('click', '#submit', function(event) {
 if(checkrequied()>0){return false;}else{	$("#grform").submit();}
});

function checkrequied() {

    var validate_error=0;
	$( ".title" ).each(function(index){ 
	var title =$(this).val(); ;
	if(title==''){
        $(this).addClass('error_field');
          validate_error++;
    }
            
    });
    return validate_error;
}

$(document).on('keyup', '.title', function(event) {
	if($(this).val()!=''){
	$(this).removeClass('error_field');
	}
}); 
 
</script>
<style>.addIcon{text-align: center;}</style>

<!-- End js script -->
<?= $footer_end ?>
