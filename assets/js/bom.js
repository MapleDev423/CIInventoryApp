$(document).on('click', '#addNew', function(event) {
  var manufacturer=$(".sResult:first").find('.manufacturer').val();
  var parts_id=$(".sResult:first").find('.parts_id').val();
  var part_colors=$(".sResult:first").find('.part_colors').val();
  var unit_id=$(".sResult:first").find('.unit_id').val();
  var quantity=$(".sResult:first").find('.quantity').val();

  if(manufacturer!='' && part_colors!='' && quantity!=''){
    $(".sResult:first").clone().prependTo('div#addCont');
    $('#addCont .sResult:first').find(".addIcon").html('');
    $('#addCont  .sResult:first').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
    var manufacturer=$(".sResult:first").find('.manufacturer').val();
    var part_colors=$(".sResult:first").find('.part_colors').val();
    $(".sResult:first").find('input').val('');
    $(".sResult:first").find('select').val('');
    $(".sResult:first").find('.getPartsColorImg').html("");

    $('#addCont .sResult:first').find('.manufacturer').val(manufacturer);
    
    $(".sResult:first").find('input').val('');
    $('.sResult:first').find('.part_colors').val(''); 
    $('#addCont .sResult:first').find('.part_colors').val(part_colors);

    $('#addCont .sResult:first').find('.parts_id').val(parts_id);
    $('#addCont .sResult:first').find('.unit_id').val(unit_id);

    calculateCost();

  }else{


    if(manufacturer==''){
      $(".sResult:first").find('.manufacturer').addClass('error_field');
    }else{$(".sResult:first").find('.manufacturer').removeClass('error_field');}

    if(parts_id==''){
      $(".sResult:first").find('.parts_id').addClass('error_field');
    }else {
      $(".sResult:first").find('.parts_id').removeClass('error_field');
    }

    if(part_colors==''){
      $(".sResult:first").find('.part_colors').addClass('error_field');
    }else{$(".sResult:first").find('.part_colors').removeClass('error_field');}

    if(unit_id==''){
      $(".sResult:first").find('.unit_id').addClass('error_field');
    }else {
      $(".sResult:first").find('.unit_id').removeClass('error_field');
    }


    if(quantity==''){
      $(".sResult:first").find('.quantity').addClass('error_field');
    }else {
      $(".sResult:first").find('.quantity').removeClass('error_field');
    }


  }
  
});
$(document).on('change','.manufacturer',function(){
    if($(this).val()==''){
      $(this).addClass('error_field');
    }else{
      $(this).removeClass('error_field');
    }
  });
$(document).on('change','.parts_id',function(){
    if($(this).val()==''){
      $(this).addClass('error_field');
    }else{
      $(this).removeClass('error_field');
    }
    calculateCost();
  });
$(document).on('change','.part_colors',function(){
    if($(this).val()==''){
      $(this).addClass('error_field');
    }else{
      $(this).removeClass('error_field');
    }
  });
$(document).on('change','.unit_id',function(){
    if($(this).val()==''){
      $(this).addClass('error_field');
    }else{
      $(this).removeClass('error_field');
    }
  });
$(document).on('input','.quantity',function(){
  
    if($(this).val()>0){
      $(this).removeClass('error_field');
    }else{
      $(this).addClass('error_field');
    }
    calculateCost();
});
$(document).on('click','.remove-row',function(){
  if(confirm("Are you sure want to remove?")){
    var ql_id=$(this).attr('rel');
    $(this).parent().parent().remove(); 
  }
  calculateCost();
  
});

    $(document).on('change','.manufacturer',function(){
        var manufacturer_id =$(this).val();
         var obj = $(this).parent().parent();
         getPartsByManufacturer(obj,manufacturer_id);

    });
    function getPartsByManufacturer(obj,m_id){       
    // alert(obj.attr('class'));
     obj.find(".partsList option").remove();
     obj.find(".partsList").append("<option value=''>Select Parts</option>");
     obj.find(".partsColorList option").remove();
     obj.find(".partsColorList").append("<option value=''>Select Parts Color</option>");
     obj.find(".getPartsColorImg").html("");
     if(m_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsByManufacturer",
            data:{manufacturer_id:m_id},
            success: function(response){
                var resultData = JSON.parse(response);
                var partsList = resultData;
                var partslen=0;
                var i=0;

                if(partsList!=null){
                    partslen= partsList.length;

                }
                if(partslen>0){

                    for(i=0;i<partslen;i++){ //alert(i);
                        obj.find(".partsList").append("<option value='"+partsList[i].ID+"'>"+partsList[i].name+"</option>");
                    }
                }

            }
         }); 
     }
}

$(document).on('change','.parts_id',function(){
    var parts_id =$(this).val();
    var obj = $(this).parent().parent();
    //alert(parts_id);
    getPartsColorByPartsId(obj,parts_id);
});

function getPartsColorByPartsId(obj,p_id){       
    // alert(obj.attr('class'));
     obj.find(".partsColorList option").remove();
     obj.find(".partsColorList").append("<option value=''>Select Parts Color</option>");
     obj.find(".getPartsColorImg").html("");
     obj.find(".parts_price").val(0);
     if(p_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsColorByPartsId",
            data:{parts_id:p_id},
            success: function(response){
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
            }
         }); 
     }
}

$(document).on('change','.part_colors',function(){
    var part_colors =$(this).val();
    var obj = $(this).parent().parent().parent();
    //alert(parts_id);
    var parts_id =obj.find('.parts_id').val();
    getPartsColorImg(obj,parts_id,part_colors);
});

function getPartsColorImg(obj,p_id,pcolor){       
    // alert(obj.attr('class'));
     obj.find(".getPartsColorImg").html("");
     if(p_id>0 && pcolor!=''){         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsColorImg",
            data:{parts_id:p_id,parts_color:pcolor},
            success: function(response){
                var partsColorImg = JSON.parse(response);
                obj.find(".getPartsColorImg").html('<img src="'+partsColorImg.image_fullpath+'" alt="Parts Color Image" style="height: 30px; width: 40px;">');
            }
         }); 
     }
}


$(document).on('submit', '.myform', function(event) {
  if(!checkValiadte()){
    return false;
  }
});

$(document).on('click', '.submit', function(event) {
  if(!checkValiadte()){
    return false;
  }
});

function checkValiadte() {
  var validate=true;
    $( ".manufacturer" ).each(function(index) {
      var obj=$( this ).parent().parent();
      var manufacturer_id =$(this).val();
      //alert(manufacturer_id+'|'+index);
      if(manufacturer_id>0 && index>0){
        var part_colors= obj.find('.part_colors').val();
        var quantity= obj.find('.quantity').val();
        var parts_id= obj.find('.parts_id').val();
        var unit_id= obj.find('.unit_id').val();
        if(quantity==''){
          validate=false;
          obj.find('.quantity').addClass('error_field');
        }
        if(parts_id==''){
          validate=false;
          obj.find('.parts_id').addClass('error_field');
        }
        if(part_colors==''){
          validate=false;
          obj.find('.part_colors').addClass('error_field');
        }
        if(unit_id==''){
          validate=false;
          obj.find('.unit_id').addClass('error_field');
        }


         //alert(part_colors+'|'+quantity);

      }
    });
    return validate;
}




function calculateCost() {
  var total_cost=0;
  $( ".manufacturer" ).each(function(index) {
      var obj=$( this ).parent().parent();
      var manufacturer_id =$(this).val();
      //alert(manufacturer_id+'|'+index);
      var parts_price= parseFloat(obj.find('.parts_price').val());
      var quantity= parseFloat(obj.find('.quantity').val());
      if(manufacturer_id>0  && parts_price>0 && quantity>0){
        parts_price=(parts_price>0)?parts_price:0;
        quantity=(quantity>0)?quantity:0;
        
        total_cost  = parseFloat(parseFloat(total_cost) + parseFloat(parts_price*quantity));

      }
    });
  total_cost=total_cost.toFixed(2);
  $(".total_cost").text(total_cost);
  //alert(total_cost);
}
