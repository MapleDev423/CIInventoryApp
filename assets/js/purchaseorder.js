$(document).on('change','#cbm_area_type',function(){
    $('.area_type').html($(this).val());
    $('.cbm').attr('placeholder',$(this).val());
    $('.total_area_type').html("Total "+$(this).val());
    $('.total_cbm').attr('placeholder',"Total "+$(this).val());
});

$(document).on('click', '#addNew', function(event) {
        
    var trNew = $(".sResult:last").clone(); 
            var trLast = $('#addCont').find("tr:last");
             trLast.after(trNew);
           $('#addCont .sResult:last').find(".addIcon").html('');
           $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
           var parts_id=$(".sResult:last").find('.parts_id').val();
           var pID=$(".sResult:last").find('.pID').val();
                
    $(".sResult:last").find('input').val('');
    $(".sResult:last").find('select').val('');    
    $(".sResult:last").find('input').val('');
    $('.sResult:last').find('.parts_id').val('');
    $('.sResult:last').find(".parts_img").html("");
    $('.sResult:last').find(".edit_row").html("");
    $('#addCont .sResult:last').find('.parts_id').val('');
    $('.sResult:last').find('.pID').val('0');
     
    $('.sResult:last').find('.parts_id').removeClass("parts_"+pID+"");
    $('.sResult:last').find('.parts_price').removeClass("price_"+pID+"");
    $('.sResult:last').find(".currentstock").removeClass("cspk_"+pID+"");
    $('.sResult:last').find(".currentstock").removeClass("cspk_"+pID+"");
    $('.sResult:last').find(".moq").removeClass("moq_"+pID+"");
    $('.sResult:last').find(".cbm").removeClass("cbm_"+pID+"");
    $('.sResult:last').find(".total_cases").removeClass("cases_"+pID+"");
    $('.sResult:last').find(".total_pcs").removeClass("pcs_"+pID+"");
    $('.sResult:last').find(".total_cost").removeClass("tcost_"+pID+"");
    $('.sResult:last').find(".total_cbm").removeClass("tcbm_"+pID+"");    
});

  
    

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
            var pID=$(".sResult:last").find('.pID').val();
           
    $(".sResult:last").find('input').val('');
    $(".sResult:last").find('select').val('');    
    $(".sResult:last").find('input').val('');
    $('.sResult:last').find('.parts_id').val('');
    $('.sResult:last').find(".parts_img").html("");
    $('.sResult:last').find(".edit_row").html("");
    $('#addCont .sResult:last').find('.parts_id').val('');
    $('.sResult:last').find('.pID').val('0');
            
    $('.sResult:last').find('.parts_id').removeClass("parts_"+pID+"");
    $('.sResult:last').find('.parts_price').removeClass("price_"+pID+"");
    $('.sResult:last').find(".currentstock").removeClass("cspk_"+pID+"");
    $('.sResult:last').find(".currentstock").removeClass("cspk_"+pID+"");
    $('.sResult:last').find(".moq").removeClass("moq_"+pID+"");
    $('.sResult:last').find(".cbm").removeClass("cbm_"+pID+"");
    $('.sResult:last').find(".total_cases").removeClass("cases_"+pID+"");
    $('.sResult:last').find(".total_pcs").removeClass("pcs_"+pID+"");
    $('.sResult:last').find(".total_cost").removeClass("tcost_"+pID+"");
    $('.sResult:last').find(".total_cbm").removeClass("tcbm_"+pID+"");         
            
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
    var parts_id =obj.find('.parts_id').val();
    var pID =obj.find('.pID').val();
    
    if(parts_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"editsheetparts",
            data:{parts_id:parts_id,colid:pID},
             success: function(data){ //alert(data);
    
                $(".bs-example-modal-lg2").html(data);
  
            }
         }); 
     }
  
});

$(document).on('change','.parts_id',function(){
    var parts_id =$(this).val();
    var obj = $(this).parent().parent();
    if(parts_id>0){
    var pID=obj.find("#pID").val();
    obj.find("#pID").val(parts_id);
    
    if(pID>0){
    obj.find('.parts_id').removeClass("parts_"+pID+"");
    obj.find(".parts_price").removeClass("price_"+pID+"");
    obj.find(".currentstock").removeClass("cspk_"+pID+"");
    obj.find(".moq").removeClass("moq_"+pID+"");
    obj.find(".cbm").removeClass("cbm_"+pID+"");
    obj.find(".total_cases").removeClass("cases_"+pID+"");
    obj.find(".total_pcs").removeClass("pcs_"+pID+"");
    obj.find(".total_cost").removeClass("tcost_"+pID+"");
    obj.find(".total_cbm").removeClass("tcbm_"+pID+""); 
    }
    
    obj.find('.parts_id').addClass("parts_"+parts_id+"");
    obj.find(".parts_price").addClass("price_"+parts_id+"");
    obj.find(".currentstock").addClass("cspk_"+parts_id+"");
    obj.find(".moq").addClass("moq_"+parts_id+"");
    obj.find(".cbm").addClass("cbm_"+parts_id+"");
    obj.find(".total_cases").addClass("cases_"+parts_id+"");
    obj.find(".total_pcs").addClass("pcs_"+parts_id+"");
    obj.find(".total_cost").addClass("tcost_"+parts_id+"");
    obj.find(".total_cbm").addClass("tcbm_"+parts_id+"");    
        
        
    obj.find(".edit_parts").html('<a data-toggle="modal" data-target=".bs-example-modal-lg2" href="" data-toggle="modal" data-target="#myModal" class="edit_row"><i class="fa fa-pencil-square icon edit " aria-hidden="true"></i></a>');
    }
    else{
        obj.find(".edit_parts").html('')
    }
        getPartsColorByPartsId(obj,parts_id);
    
    calculate_total_cost(obj);
    
    
});




$(document).on('click','.remove-row',function(){
  if(confirm("Are you sure want to remove?")){
    var ql_id=$(this).attr('rel');
    $(this).parent().parent().remove();
    //$('#addCont').html('<tr></tr>');
  }
 var obj = $(this).parent().parent();
 calculate_total_cost(obj);
 calculate_total_cbm(obj);
  
});

$(document).on('click','.remove-row-clone',function(){
  if(confirm("Are you sure want to removes?")){
    $(this).parent().parent().find('input').val('');
    $(this).parent().parent().find('select').val('');
    $(this).parent().parent().find('.parts_img').html('');
    $(this).parent().parent().find('input').val('');
    $(this).parent().parent().find('.parts_id').val('');
    $(this).parent().parent().find(".edit_row").html("");
    $(this).parent().parent().find('.parts_id').val('');
    $(this).parent().parent().parent().append('<tr></tr>'); 
    $(this).parent().parent().hide(); 
    
  }
 var obj = $(this).parent().parent();
 calculate_total_cost(obj);
 calculate_total_cbm(obj);
  
});

/*
$(document).on('change','.parts_id',function(){
    if($(this).val()==''){
      $(this).addClass('error_field');
    }else{
      $(this).removeClass('error_field');
    }
  });
*/

$(document).on('submit', '.myform', function(event) {
    if(checkrequied()>0){
          return false;
        }else{  
          $("#poform").submit();
        }
});

function checkrequied() {
    var validate_error=0;

    $('.required').each(function( index ) {
        if($( this ).val()=='' || $( this ).val()<=0){
            $(this).addClass('error_field');
            validate_error++;
        }
    });

    /*
    if($("#po_date" ).val()==''){
        $("#po_date").addClass('error_field');
          validate_error++;
    }
    
    if($("#intentedyear" ).val()==''){
        $("#intentedyear").addClass('error_field')
          validate_error++;
    }if($("#season" ).val()==''){
        $("#season").addClass('error_field')
          validate_error++;
    }
    
    if($("#manufacturer_id" ).val()==''){
        $("#manufacturer_id").addClass('error_field');
          validate_error++;
    }
    */
    return validate_error;
}

$(document).on('input','.required',function(){
    if($(this).val()==''){
        $(this).addClass('error_field');
    }else{
        setTimeout(function() {
        //$(this).removeClass('error_field');
        $('.required').each(function( index ) {
            if($( this ).val()!=''){
                $(this).removeClass('error_field');
            }
        });
        }, 1000);
    }
});

$(document).on('change','.planningsheet_id',function(){ 
    var planningsheet_id =$(this).val();
    getPartsByPlanning(planningsheet_id);
});

var defaultManufacturer=$("#manufacturer_id" ).html();

function getPartsByPlanning(planningsheet_id){
     $(".parts_id option").remove();
     $(".parts_id").append("<option value=''>Select Parts</option>");

     if(planningsheet_id>0){
          $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByPlanning",
            data:{planningsheet_id:planningsheet_id},
            success: function(response){ //alert(response);
                var resultData = JSON.parse(response);
                var planningsheet = resultData;
                var m_id=planningsheet.manufacturer_id;
				getPartsByManufacturer(m_id);
                var mfg=planningsheet.mfg;
                $("#manufacturer_id" ).val(m_id);
                $("#intentedyear" ).val(planningsheet.iyear);
                $("#season" ).val(planningsheet.season);
                $("#shipping_date" ).val(dateFormat(new Date(planningsheet.shipping_date)));
                $('#shipping_date').datepicker('setDate', new Date(planningsheet.shipping_date));
                $("#cbm_area_type" ).val(planningsheet.cbm_area_type);
                $(".area_type" ).html(planningsheet.cbm_area_type);
                $('.total_area_type').html("Total "+planningsheet.cbm_area_type);
                $('.total_cbm').attr('placeholder',"Total "+planningsheet.cbm_area_type);

                getPartsByPlannings(planningsheet_id);
                $("#manufacturer_id option").remove();
                $('#manufacturer_id').append('<option value="'+m_id+'">'+mfg+'</option>');
                $('#manufacturer_id').attr('readonly','readonly'); 
            }
         }); 
        
     }
     else{
                $("#manufacturer_id").attr("readonly",false);
                $("#manufacturer_id").html(defaultManufacturer);
                $("#intentedyear" ).val("");
                $("#shipping_date" ).val(dateFormat());
                $('#shipping_date').datepicker('setDate', dateFormat());
                $("#cbm_area_type" ).val("CBM");
                $(".area_type" ).html("CBM");
                 $('.total_area_type').html("Total CBM");
                 $('.total_cbm').attr('placeholder',"Total CBM");

                $('#addCont').html("<tr></tr>");
                getPartsAddnew();
                getPartstotals();
     }
   
}

function dateFormat(date=''){
    var d = (date!='')?date:new Date();
    var curr_date = ("0" + (d.getDate())).slice(-2);
    var curr_month = ("0" + (d.getMonth()+1)).slice(-2);
    var curr_year = d.getFullYear();
    var newFormat=curr_month+'/'+curr_date+'/'+curr_year;
    return newFormat;
}

function getPartsAddnew(){
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsAddnew",
            data:{planningsheet_id:0},
            success: function(response){ 
                $('#addCont').html("");
                $('#addCont').html(response);
            }
         }); 
}

function getPartstotals(){
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartstotals",
            data:{planningsheet_id:0},
            success: function(response){ 
                $('#addContTotals').html("");
                $('#addContTotals').html(response);
            }
         }); 
}

function getPartsByPlannings(planningsheet_id){       
    
     if(planningsheet_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByPlannings",
            data:{planningsheet_id:planningsheet_id},
            success: function(response){
                //$('#addCont').html("");
                $('#addCont').html(response);
                //$('#addCont').remove();
                getPartsByPlanningtotals(planningsheet_id);
            }
         }); 
     }
   
}
function getPartsByPlanningtotals(planningsheet_id){       
    
     if(planningsheet_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByPlanningtotals",
            data:{planningsheet_id:planningsheet_id},
            success: function(response){ 
                $('#addContTotals').html("");
                $('#addContTotals').html(response);
            }
         }); 
     }
   
}


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


function getPartsColorByPartsId(obj,p_id){       
   //alert(obj.attr('class'));
     obj.find(".partsColorList option").remove();
     obj.find(".partsColorList").append("<option value=''>Select Parts Color</option>");
     obj.find(".parts_price").val('');
     obj.find(".currentstock").val('');
     obj.find(".cbm").val('');
     obj.find(".moq").val('');
     obj.find(".total_cases").val('');
     obj.find(".total_pcs").val('');
     obj.find(".total_cbm").val('');
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
    var total_cbm= total_pcsval= 0;
    var cs_pack = obj.find(".currentstock").val();
    var total_cbm = obj.find(".total_cases").val();
  
    if(cs_pack>0 && total_cbm>0){
        total_pcsval = parseFloat(cs_pack * total_cbm);
    }

    obj.find('.total_pcs').val(total_pcsval);
    calculate_total_cost(obj);

}
 
function calculate_total_cost(obj){
    var total_cost=0;
    var parts_price = obj.find(".parts_price").val();
    var total_pcs = obj.find(".total_pcs").val();
  
    if(parts_price>0 && total_pcs>0){
        
        var total_cost = parseFloat(parts_price * total_pcs); 
    }

    obj.find('.total_cost').val(total_cost.toFixed(4));
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
 
 $(document).on('click', '#generatepi', function(event) {
    if(checkrequied()>0){
          return false;
        }else{
            if(confirm("Are you sure want to create proforma invoice?")){
                $.post(PS_ACTION, $("form#poform").serialize(), function(data){});
            $("#poform").submit();
            } else{
                return false;
            }
        }
});

/*
function checkrequiedval() {
    var validate_error=0;
    if($("#po_date" ).val()==''){
        $("#po_date").addClass('error_field')
          validate_error++;
    }

    if($("#intentedyear" ).val()==''){
        $("#intentedyear").addClass('error_field')
          validate_error++;
    }if($("#season" ).val()==''){
        $("#season").addClass('error_field')
          validate_error++;
    }
    if($("#manufacturer_id" ).val()==''){
        $("#manufacturer_id").addClass('error_field')
          validate_error++;
    }
    $( ".parts_id" ).each(function( index ) {
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
    $( ".parts_price" ).each(function( index ) {
       if($( this ).val()==''){
          $(this).addClass('error_field')
          validate_error++;
        }
    });
    
    $( ".currentstock" ).each(function( index ) {
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
    });
    
    return validate_error;
}
*/
    
function generate_excel_file(){
    if(checkrequied()>0){
        return false;
    }else {
        var form = $("form#poform").serialize();
        $.post(PS_ACTION, form, function (data) {
            if (redirect_url != '') {
                window.location.href = excel_url + data;
                setTimeout(function () {
                    window.location.href = redirect_url + data;
                }, 1000);
            } else {
                window.location.href = excel_url + ID;
            }
        });
    }
    }