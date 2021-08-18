$(document).on('change','#cbm_area_type',function(){
    $('.area_type').html($(this).val());
    $('.cbm').attr('placeholder',$(this).val());
    $('.total_area_type').html("Total "+$(this).val());
    $('.total_cbm').attr('placeholder',"Total "+$(this).val());
});

$(document).on('click', '#addNew', function(event) {
          
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

$(document).on('click', '#saveinvoice', function(event) {
    if(checkrequied()>0){
          return false;
        }else{  
          $("#piform").submit();
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

    /*if($("#invoiceid" ).val()==''){
        $("#invoiceid").addClass('error_field');
          validate_error++;
    }

    if($("#porderid" ).val()==''){
        $(".select2-container").addClass('error_field');
          validate_error++;
    }
    
    if($("#pi_date" ).val()==''){
        $("#pi_date").addClass('error_field');
          validate_error++;
    }
    
    if($("#manufacturer_id" ).val()==''){
        $("#manufacturer_id").addClass('error_field');
          validate_error++;
    }
    */

    return validate_error;
}

$(document).on('change','.required',function(){
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


$(document).on('change','.porderid',function(){
    var porderid =$(this).val();
    //$(".select2-container").removeClass('error_field');
    getPartsByPorder(porderid);
   
    
});

function getPartsByPorder(porderid){
   
     $(".parts_id option").remove();
     $(".parts_id").append("<option value=''>Select Parts</option>");
     //alert(porderid);
     if(porderid>0){
         
          $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByPorder",
            data:{porderid:porderid},
            success: function(response){ //alert(response);
                var resultData = JSON.parse(response);
                var porders = resultData;
                //getPartsAddnew();
                var m_id=porders.manufacturer_id;
                getPartsByManufacturer(m_id);
                var plan_id=porders.planningsheet_id;
                var mfg=porders.mfg;
                var shipping_date=porders.shipping_date;
                var cbm_area_type=porders.cbm_area_type;

                //$("#manufacturer_id option").remove();
                //$("#manufacturer_id").append("<option value='"+m_id+"'>"+mfg+"</option>");
                $("#manufacturer_id" ).val(m_id);
                $("#planningsheet_id" ).val(plan_id);
                $("#shipping_date" ).val(dateFormat(new Date(shipping_date)));
                $('#shipping_date').datepicker('setDate', new Date(shipping_date));
                $("#cbm_area_type" ).val(cbm_area_type);
                $(".area_type" ).html(cbm_area_type);
                $('.total_area_type').html("Total "+cbm_area_type);
                $('.total_cbm').attr('placeholder',"Total "+cbm_area_type);

                 $('#addCont').html("<tr></tr>");
                
                getPartsByPOrderss(porderid);
              }
         });
     }
     else{
                //$("#manufacturer_id option").remove();
                //$("#manufacturer_id").append("<option value=''>Select Manufacturer</option>");
                $("#manufacturer_id" ).val('');
                $("#shipping_date" ).val(dateFormat());
                $('#shipping_date').datepicker('setDate', dateFormat());
                $("#cbm_area_type" ).val("CBM");
                $(".area_type" ).html("CBM");
                $('.total_area_type').html("Total CBM");
                $('.total_cbm').attr('placeholder',"Total CBM");

                $('#addContClone').html("<tr></tr>");
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
            url: AJAX_URL+"getPOPartsAddnew",
            data:{porderid:0},
            success: function(response){ 
                $('#addCont').html("");
                $('#addCont').html(response);
            }
         }); 
}

function getPartstotals(){
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPOPartstotals",
            data:{porderid:0},
            success: function(response){ 
                $('#addContTotals').html("");
                $('#addContTotals').html(response);
            }
         }); 
}

function getPartsByPOrderss(porderid){       
    
     if(porderid>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByPOrderss",
            data:{porderid:porderid},
            success: function(response){ 
               function show_popup(){
                $('#addContClone').html(response); 
                getPartsByPordertotals(porderid);
                };
                window.setTimeout( show_popup, 300 );  //1000 -> 1 minute
               }
         }); 
     }
   
}
function getPartsByPordertotals(porderid){
     if(porderid>0){
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByPordertotals",
            data:{porderid:porderid},
            success: function(response){ 
                $('#addContTotals').html("");
                $('#addContTotals').html(response);
                var total_deposit_per = $('#total_deposit_per').val();
                total_deposit_value($(".total_cost_val").html(),total_deposit_per);
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
$(document).on('keyup','.total_cases',function(){
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
    //var total_cbm= total_pcsval= 0;
    var cs_pack = obj.find(".currentstock").val();
    var total_cbm = obj.find(".total_cases").val();
  
    if(cs_pack>0 && total_cbm>0){
       var total_pcsval = parseFloat(cs_pack * total_cbm);
    }

    obj.find('.total_pcs').val(total_pcsval);
    calculate_total_cost(obj);
}
 
function calculate_total_cost(obj){
    var total_cost=0;
    var parts_price = obj.find(".parts_price").val();
    var total_pcs = obj.find(".total_pcs").val();
  
    if(parts_price>0 && total_pcs>0){
        total_cost = parseFloat(parts_price * total_pcs); 
    }

    obj.find('.total_cost').val(total_cost.toFixed(2));
    total_cost_value();
	total_qtys();
}

function total_qtys(){
	var cases=0;
	var pcs=0;
  $( ".total_cases" ).each(function(index) {
      var total_cases =$(this).val();
     
      if(total_cases>0){
         cases+=parseInt($(this).val());
      }
    });
	$( ".total_pcs" ).each(function(index) {
      var total_pcs =$(this).val();
     
      if(total_pcs>0){
         pcs+=parseInt($(this).val());
      }
    });
	
  $('.total_cases_val_hidden').val(cases);
  $(".total_cases_val").text(cases);
  $('.total_pcs_val_hidden').val(pcs);
  $(".total_pcs_val").text(pcs);
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

    var total_deposit_per = $('#total_deposit_per').val();
    total_deposit_value(total_cost_val,total_deposit_per);
}




$(document).on("keyup","#total_deposit_per",function(){
    var total_cost_val = $('#total_cost_val').val();
    var total_deposit_per = $('#total_deposit_per').val();
    total_deposit_value(total_cost_val,total_deposit_per);
});

$(document).on('blur','#total_deposit_per',function(){
var total_deposit_per = $('#total_deposit_per').val();
	total_deposit_per = parseFloat(total_deposit_per).toFixed(2);
	$(".total_deposit_per_hidden").val(total_deposit_per);
	$(".total_deposit_per").text(total_deposit_per);
});


$(document).on("keyup","#total_deposit_val",function(){
    var total_cost_val = $('#total_cost_val').val();
    var total_deposit_val=$(this).val();
    var total_deposit_per = $('#total_deposit_per').val();
    if(total_deposit_val>0) {
    total_deposit_per =((total_deposit_val * 100) / total_cost_val).toFixed(2);
    }
    $(".total_deposit_per_hidden").val(total_deposit_per);
    $(".total_deposit_per").text(total_deposit_per);
});

function total_deposit_value(total_cost_val,total_deposit_per){
    $(".deposit_details").css("display","");
    var total_deposit_val=$('#total_deposit_val').val();
    if(total_deposit_per>0) {
    total_deposit_val = ((total_cost_val * total_deposit_per) / 100).toFixed(2);
    }

$('.total_deposit_per_hidden').val(total_deposit_per);
$(".total_deposit_per").text(total_deposit_per);
$('.total_deposit_val_hidden').val(total_deposit_val);
$(".total_deposit_val").text(total_deposit_val);
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
 
 $(document).on('click', '#saveperforma', function(event) {
    if(checkrequied()>0){
          return false;
        }else{
            if(confirm("Are you sure want to generate proforma invoice? If yes then no changes will be done after the generation of Proforma Invoice.")){
            $("#piform").submit();
         }
         else{
             return false;
         }
        }
});

/*
function checkrequiedval() {
    var validate_error=0;

    if($("#pi_date" ).val()==''){
        $("#pi_date").addClass('error_field')
          validate_error++;
    }

    if($("#invoiceid" ).val()==''){
        $("#invoiceid").addClass('error_field');
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