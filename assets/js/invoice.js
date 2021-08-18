$(document).on('click', '#addNew', function(event) {
  var porderid=$(".sResult:first").find('.porderid').val();
  var parts_id=$(".sResult:first").find('.parts_id').val();
  var currentstock=$(".sResult:first").find('.currentstock').val();
  var cbm=$(".sResult:first").find('.cbm').val();
  var total_cases=$(".sResult:first").find('.total_cases').val();
  var total_pcs=$(".sResult:first").find('.total_pcs').val();
  var total_cost=$(".sResult:first").find('.total_cost').val();
  var total_cbm=$(".sResult:first").find('.total_cbm').val();
 
  if(porderid!=''){
      //$(".sResult:first").clone().prependTo('#addCont');
    
    var trNew = $(".sResult:last").clone();
    var trLast = $('#addCont').find("tr:last")
        trLast.after(trNew);
    $('#addCont .sResult:last').find(".addIcon").html('');
    $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
    var porderid=$(".sResult:last").find('.porderid').val();
    var parts_id=$(".sResult:last").find('.parts_id').val();
    $(".sResult:last").find('input').val('');
    $(".sResult:last").find('select').val('');
    $(".sResult:last").find('.parts_img').html('');


    $('.sResult:last').find('.porderid').val(porderid);
    
    $(".sResult:last").find('input').val('');
    $('.sResult:last').find('.parts_id').val('');
    $(".sResult:last").find('.parts_img').html('');
    $('.sResult:last').find(".edit_row").html("");
    $('.sResult:last').find('.parts_id').val('');


 
  }else{


    if(porderid==''){
      $(".sResult:last").find('.porderid').addClass('error_field');
    }else{$(".sResult:last").find('.porderid').removeClass('error_field');}

  }
  
});
$(document).on('click','.remove-row',function(){
  if(confirm("Are you sure want to remove?")){
    var ql_id=$(this).attr('rel');
    $(this).parent().parent().remove(); 
  }
 var obj = $(this).parent().parent();
 calculate_total_cost(obj);
 calculate_total_cbm(obj);
  
});

$(document).on('change','.parts_id',function(){
    if($(this).val()==''){
      $(this).addClass('error_field');
    }else{
      $(this).removeClass('error_field');
    }
  });
/*$(document).on('change', '.partsColorList', function(event){
  var str = $(this).val();
   if(str==""){
      $(this).addClass('error_field');
      
    }else{
      $(this).removeClass('error_field');
    }
});

$(document).on('input', '.cbm', function(event){
  var str = $(this).val();
   if(str==""){
      $(this).addClass('error_field');
      
    }else{
      $(this).removeClass('error_field');
    }
});
$(document).on('input', '.total_cases', function(event){
  var str = $(this).val();
   if(str==""){
      $(this).addClass('error_field');
      
    }else{
      $(this).removeClass('error_field');
    }
});
$(document).on('input', '.total_pcs', function(event){
  var str = $(this).val();
   if(str==""){
      $(this).addClass('error_field');
      
    }else{
      $(this).removeClass('error_field');
    }
});
$(document).on('input', '.total_cost', function(event){
  var str = $(this).val();
   if(str==""){
      $(this).addClass('error_field');
      
    }else{
      $(this).removeClass('error_field');
    }
});
$(document).on('input', '.total_cbm', function(event){
  var str = $(this).val();
   if(str==""){
      $(this).addClass('error_field');
      
    }else{
      $(this).removeClass('error_field');
    }
});*/

$(document).on('submit', '.myform', function(event) {
    if(checkrequied()>0){
          return false;
        }else{  
          $("#myform").submit();
        }
});

function checkrequied() {

    var validate_error=0;
    if($("#po_date" ).val()==''){
        $("#po_date").addClass('error_field');
          validate_error++;
    }
    if($("#manufacturer_id" ).val()==''){
        $("#manufacturer_id").addClass('error_field');
          validate_error++;
    }
    /*$( ".parts_id" ).each(function( index ) {
        if($( this ).val()==''){
          $(this).addClass('error_field');
          validate_error++;
        }
    });
    $( ".partsColorList" ).each(function( index ) {
        if($( this ).val()==''){
          $(this).addClass('error_field')
          validate_error++;
        }
    });
  
    $( ".cbm" ).each(function( index ) {
       if($( this ).val()==''){
          $(this).addClass('error_field')
          validate_error++;
        }
    });
    $( ".total_cases" ).each(function( index ) {
       if($( this ).val()==''){
          $(this).addClass('error_field')
          validate_error++;
        }
    });
    $( ".total_pcs" ).each(function( index ) {
       if($( this ).val()==''){
          $(this).addClass('error_field')
          validate_error++;
        }
    });
    $( ".total_cost" ).each(function( index ) {
       if($( this ).val()==''){
          $(this).addClass('error_field')
          validate_error++;
        }
    });
    $( ".total_cbm" ).each(function( index ) {
       if($( this ).val()==''){
          $(this).addClass('error_field')
          validate_error++;
        }
    });*/
    
    return validate_error;
}


$(document).on('change','.porderid',function(){
    var porderid =$(this).val();
    //var obj = $(this).parent().parent();
    $("#manufacturer_id" ).val(11);
    $("#pod_date" ).val('06/13/2018');
  for(i=0;i<3;i++){  
                        var trNew = $(".sResult:last").clone();
                        var trLast = $('#addCont').find("tr:last");
                        //trLast.hide();
                        trLast.after(trNew);
                        $('#addCont .sResult:last').find(".addIcon").html('');
                        $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
                        var parts_id=$(".sResult:last").find('.parts_id').val();
                        $(".sResult:last").find('input').val(100);
                        $(".sResult:last").find('select').val(1);    
                        $(".sResult:last").find('input').val(100);
                        $('.sResult:last').find('.parts_id').val(1);
                        $('.sResult:last').find(".parts_img").html('<img src="http://erozgaar.com/flowersforcemeteries/data/parts/colors/134/1528963167_1527696872_1527690503_image.jpg" alt="Parts Color Image" style="height: 150px; width: 150px;">');
                        $('.sResult:last').find(".edit_row").html("");
                        $('#addCont .sResult:last').find('.parts_id').val(1);
                        
                    }
   // getPartsByPlanning(planningsheet_id);
   var trfirst = $('#addCont').find("tr:first");
   trfirst.remove();
   
    
});

/*function getPartsByPlanning(p_id){       
   //alert(obj.attr('class'));
     $(".parts_id option").remove();
     $(".parts_id").append("<option value=''>Select Parts</option>");
     
     if(p_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByPlanning",
            data:{plannning_id:p_id},
            success: function(response){ //alert(response);
                var resultData = JSON.parse(response);
                var sheetDetails = resultData;
                var reslen=0;
               
                var i=0;

                if(partDetails!=null){
                    reslen= partDetails.length;
                }

                if(reslen>0){

                    for(i=0;i<reslen;i++){  
                        var trNew = $(".sResult:last").clone();
                        var trLast = $('#addCont').find("tr:last")
                        trLast.after(trNew);
                        $('#addCont .sResult:last').find(".addIcon").html('');
                        $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
                        var parts_id=$(".sResult:last").find('.parts_id').val();
                        $(".sResult:last").find('input').val('');
                        $(".sResult:last").find('select').val('');    
                        $(".sResult:last").find('input').val('');
                        $('.sResult:last').find('.parts_id').val('');
                        $('.sResult:last').find(".parts_img").html("");
                        $('.sResult:last').find(".edit_row").html("");
                        $('#addCont .sResult:last').find('.parts_id').val('');
                    }
                }

            }
         }); 
     }
   
}*/

$(document).on('change','.manufacturer_id',function(){
    var manufacturer_id =$(this).val();
    //var obj = $(this).parent().parent();
  
    getPartsByManufacturer(manufacturer_id);
    
});

function getPartsByManufacturer(p_id){       
   //alert(obj.attr('class'));
     $(".parts_id option").remove();
     $(".parts_id").append("<option value=''>Select Parts</option>");
     
     if(p_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByManufacturer",
            data:{manufacturer_id:p_id},
            success: function(response){ //alert(response);
                var resultData = JSON.parse(response);
                var partDetails = resultData;
                var reslen=0;
               
                var i=0;

                if(partDetails!=null){
                    reslen= partDetails.length;
                    $(".partsColorList option").remove();
                    $(".partsColorList").append("<option value=''>Select Parts Color</option>");
                    $('.currentstock').val('');
                    $('.cbm').val('');
                    $('.total_cases').val('');
                    $('.total_pcs').val('');
                    $('.total_cost').val('');
                    $('.total_cbm').val('');
                    $('.parts_price').val('');
                    $('.total_cbm_val').val('');
                    $('.total_cbm_val_hidden').val('');
                    $(".parts_img").html('');
                    $(".moq").val('');
                }

                if(reslen>0){

                    for(i=0;i<reslen;i++){ 
                        $(".parts_id").append("<option value='"+partDetails[i].ID+"'>"+partDetails[i].name+"</option>");
                    }
                }

            }
         }); 
     }
   
}

$(document).on('change','.parts_id',function(){
    var parts_id =$(this).val();
    var obj = $(this).parent().parent();
    if(parts_id>0){
    obj.find(".edit_parts").html('<a data-toggle="modal" data-target=".bs-example-modal-lg2" href="" data-toggle="modal" data-target="#myModal" class="edit_row"><i class="fa fa-pencil-square icon edit " aria-hidden="true"></i></a>');
    }
    else{
        obj.find(".edit_parts").html('')
    }
        getPartsColorByPartsId(obj,parts_id);
    
    calculate_total_cost(obj);
    
    
});



function getPartsColorByPartsId(obj,p_id){       
   //alert(obj.attr('class'));
     obj.find(".partsColorList option").remove();
     obj.find(".partsColorList").append("<option value=''>Select Parts Color</option>");
     obj.find(".parts_price").val('');
     obj.find(".currentstock").val('');
     obj.find(".cbm").val('');
     obj.find(".moq").val('');
     obj.find(".parts_img").html("");
     if(p_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsColorByPartsId",
            data:{parts_id:p_id},
            success: function(response){ //alert(response);
                var resultData = JSON.parse(response);
                var partsColorList = resultData['colorList'];
                var partDetails = resultData['partDetails'];
                var reslen=0;
               
                var i=0;

                if(partsColorList!=null){
                    reslen= partsColorList.length;
                }

                if(reslen>0){

                    for(i=0;i<reslen;i++){ 
                        obj.find(".partsColorList").append("<option value='"+partsColorList[i].color_code+"'>"+partsColorList[i].color_code+"</option>");
                    }
                }

                 obj.find(".parts_price").val(partDetails.price);
                 obj.find(".currentstock").val(partDetails.case_pack);
                 obj.find(".cbm").val(partDetails.cbm);
                 obj.find(".moq").val(partDetails.MOQ);
                 calculate_total_pcs(obj);
                 calculate_total_cbm(obj);
                
            }
         }); 
     }
   
}


$(document).on('change','.partsColorList',function(){
    var part_colors =$(this).val();
    var obj = $(this).parent().parent();
    //alert(parts_id);
    var parts_id =obj.find('.parts_id').val();
    getPartsColorImg(obj,parts_id,part_colors);
});

function getPartsColorImg(obj,p_id,pcolor){       
    // alert(obj.attr('class'));
     obj.find(".parts_img").html("");
     if(p_id>0 && pcolor!=''){         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsColorImg",
            data:{parts_id:p_id,parts_color:pcolor},
            success: function(response){
                var partsColorImg = JSON.parse(response);
                obj.find(".parts_img").html('<img src="'+partsColorImg.image_fullpath+'" alt="Parts Color Image" style="height: 150px; width: 150px;">');
            }
         }); 
     }
}




$(document).on('click','.add_row',function(){
    var rows =$('.rows').val();
  if(rows>0){
       if(confirm("Are you sure want to add "+rows+" rows?")){
        for(i=0;i<rows;i++){    
            //$(".sResult:first").clone().prependTo('#addCont');
            var trNew = $(".sResult:last").clone();
            var trLast = $('#addCont').find("tr:last")
            trLast.after(trNew);
            $('#addCont .sResult:last').find(".addIcon").html('');
            $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
            var parts_id=$(".sResult:last").find('.parts_id').val();
    $(".sResult:last").find('input').val('');
    $(".sResult:last").find('select').val('');    
    $(".sResult:last").find('input').val('');
    $('.sResult:last').find('.parts_id').val('');
    $('.sResult:last').find(".parts_img").html("");
    $('.sResult:last').find(".edit_row").html("");
    $('#addCont .sResult:last').find('.parts_id').val('');
       }
       $('.rows').val('');
    }
  }
  else{
      alert("Please enter no. of rows as you want to add.")
      return false;
  }
  
});

$(document).on('click','.edit_row',function(){
    var obj = $(this).parent().parent();
    var random_num= Math.floor((Math.random() * 1000000) + 1);
    obj.find("#parts_id").addClass("part_"+random_num+"");
    $(this).parent().parent().parent().find("#parts_price").addClass("price_"+random_num+"");
    $(this).parent().parent().parent().find("#currentstock").addClass("cspk_"+random_num+"");
    $(this).parent().parent().parent().find("#moq").addClass("moq_"+random_num+"");
    $(this).parent().parent().parent().find("#cbm").addClass("cbm_"+random_num+"");
    $(this).parent().parent().parent().find("#total_cases").addClass("cases_"+random_num+"");
    $(this).parent().parent().parent().find("#total_pcs").addClass("pcs_"+random_num+"");
    $(this).parent().parent().parent().find("#total_cost").addClass("tcost_"+random_num+"");
    $(this).parent().parent().parent().find("#total_cbm").addClass("tcbm_"+random_num+"");
    
    var parts_id =obj.find('.parts_id').val();
    
    if(parts_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"editsheetparts",
            data:{parts_id:parts_id,colid:random_num},
             success: function(data){ //alert(data);
    
                $(".bs-example-modal-lg2").html(data);
  
            }
         }); 
     }
  
});

$(document).on('blur','.cbm',function(){
    var obj = $(this).parent().parent();
    calculate_total_cbm(obj);
});
$(document).on('blur','.total_cases',function(){
    var obj = $(this).parent().parent();
    calculate_total_pcs(obj);
    calculate_total_cbm(obj);
});
$(document).on('blur','.total_pcs',function(){
    var obj = $(this).parent().parent();
    calculate_total_cost(obj);
});
$(document).on('blur','.parts_price',function(){
    var obj = $(this).parent().parent();
    calculate_total_cost(obj);
});
$(document).on('blur','.currentstock',function(){
    var obj = $(this).parent().parent();
    calculate_total_pcs(obj);
});



function calculate_total_pcs(obj){
    var total_cbm=0;
    var cs_pack = obj.find(".currentstock").val();
    var total_cbm = obj.find(".total_cases").val();
  
    if(cs_pack>0 && total_cbm>0){
        
        var total_pcsval = parseFloat(cs_pack * total_cbm); 
    }
   // alert(total_pcsval);
    obj.find('.total_pcs').val(total_pcsval);
    calculate_total_cost(obj);
    //total_cost_value();
    
}
 
function calculate_total_cost(obj){
    var total_cost=0;
    var parts_price = obj.find(".parts_price").val();
    var total_pcs = obj.find(".total_pcs").val();
  
    if(parts_price>0 && total_pcs>0){
        
        var total_cost = parseFloat(parts_price * total_pcs); 
    }

    obj.find('.total_cost').val(total_cost.toFixed(2));
    total_cost_value();
    
}



function total_cost_value(){
  var total_cost_val=0;
  $( ".total_cost" ).each(function(index) {
      var total_cost =$(this).val();
     
      if(total_cost>0){
         total_cost_val+=parseFloat($(this).val());
      }
    });
  total_cost_val=total_cost_val.toFixed(2);
  $('.total_cost_val_hidden').val(total_cost_val);
  $(".total_cost_val").text(total_cost_val);
 
}
function calculate_total_cbm(obj){
   
    var total_cbm=0;
   
    var cbm = obj.find(".cbm").val();
    var total_cases = obj.find(".total_cases").val();
   //alert(cbm);
    if(cbm>0 && total_cases>0){
        
         total_cbm = parseFloat(cbm * total_cases); 
    }

    obj.find('.total_cbm').val(total_cbm.toFixed(4));
    total_cbm_val();
    
}
function total_cbm_val(){
    var total_cbm_val=0;
   
    $( ".total_cbm" ).each(function(index){ 
        
        var total_cbm =$(this).val();
        if(total_cbm>0){
             
            total_cbm_val+=parseFloat($(this).val());
        }
            
    });  
    total_cbm_val=total_cbm_val.toFixed(4);
    $('.total_cbm_val_hidden').val(total_cbm_val);
    $('.total_cbm_val').text(total_cbm_val);
 }