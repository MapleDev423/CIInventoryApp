$(document).on('click', '#addNew', function(event) {
        
    var trNew = $(".sResult:last").clone(); 
            var trLast = $('#addCont').find("tr:last");
             trLast.after(trNew);
           $('#addCont .sResult:last').find(".addIcon").html('');
           $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
			$(".sResult:last").find(".parts_id option").remove();
			$(".sResult:last").find(".parts_id").append("<option value=''>Select Part</option>");
			$(".sResult:last").find(".partsColorList option").remove();
			$(".sResult:last").find(".partsColorList").append("<option value=''>Select Part Color</option>");
    
			$('.sResult:last').find('.issuestock').attr("readonly", "readonly"); 
			clearData($(".sResult:last"));
});
    

$(document).on('click','.add_row',function(){
    var rows =$('.rows').val(); 
     
  if(rows>0){
       if(confirm("Are you sure want to add "+rows+" rows?")){
        for(i=0;i<rows;i++){ 
            var trNew = $(".sResult:last").clone();
            var trLast = $('#addCont').find("tr:last")
            trLast.after(trNew);
            $('#addCont .sResult:last').find(".addIcon").html('');
            $('#addCont  .sResult:last').find(".addIcon").html('<i class="fa fa-minus-circle icon-remove remove-row fa-2x mrg-4" aria-hidden="true"></i>');  
            $(".sResult:last").find(".parts_id option").remove();
			$(".sResult:last").find(".parts_id").append("<option value=''>Select Part</option>");
			$(".sResult:last").find(".partsColorList option").remove();
			$(".sResult:last").find(".partsColorList").append("<option value=''>Select Part Color</option>");
    
			$('.sResult:last').find('.issuestock').attr("readonly", "readonly");   
			clearData($(".sResult:last"));
       }
       $('.rows').val('');
    }
  }
  else{
      alert("Please enter no. of rows as you want to add.")
      return false;
  }
  
});

function clearData(obj){
	obj.find(".parts_img").html("");
	obj.find(".currentstock").val("0");
	obj.find(".issuestock").val("");
}

$(document).on('click','.remove-row',function(){
  if(confirm("Are you sure want to remove?")){
    var ql_id=$(this).attr('rel');
    $(this).parent().parent().remove();
   }
 var obj = $(this).parent().parent();
 calculate_total();
  
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
    return validate_error;
}



$(document).on('change','.manufacturer_id',function(){
    var manufacturer_id =$(this).val();
    var obj = $(this).parent().parent();
  
    getPartsByManufacturer(manufacturer_id,obj);
    
});

function getPartsByManufacturer(m_id,obj){       
   //alert(obj.attr('class'));
     obj.find(".parts_id option").remove();
	 obj.find(".parts_id").append("<option value=''>Select Part</option>");
		
	obj.find(".partsColorList option").remove();
	obj.find(".partsColorList").append("<option value=''>Select Part Color</option>");

	clearData(obj);
     if(m_id>0){
         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartsnameByManufacturer",
            data:{manufacturer_id:m_id},
            success: function(response){ //alert(response);
                var resultData = JSON.parse(response);
                var partDetails = resultData;
                var reslen=0;
               
                var i=0;

                if(partDetails!=null){
                    reslen= partDetails.length;
                if(reslen>0){

                    for(i=0;i<reslen;i++){ 
					if(partDetails[i].pending!=0){
                        obj.find(".parts_id").append("<option value='"+partDetails[i].parts_id+"'>"+partDetails[i].name+"</option>");
                    }
					}
                }
				}
            }
         }); 
     }
   
}

$(document).on('change','.parts_id',function(){
	var p_id=$(this).val();
	var obj = $(this).parent().parent();
	var m_id= obj.find(".manufacturer_id").val();
   //alert(obj.attr('class'));
     obj.find(".partsColorList option").remove();
     obj.find(".partsColorList").append("<option value=''>Select Part Color</option>");
	clearData(obj);
     if(p_id>0){
		var colorValues = [];
				$("select.partsColorList option:selected").each(function(index){
					colorValues.push($('.manufacturer_id:eq('+index +')').val()+$('.parts_id:eq('+index +')').val()+$(this).val());
				});
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartscolorByPartsIdforissue",
            data:{manufacturer_id:m_id,parts_id:p_id},
            success: function(response){ //alert(response);
               var resultData = JSON.parse(response);
               var partsColorList = resultData; 
               var reslen=0;
               var i=0;
				if(partsColorList!=null){
                reslen= partsColorList.length;
                if(reslen>0){
					for(i=0;i<reslen;i++){ 
					
					var color=partsColorList[i].part_colors;
					if(jQuery.inArray(m_id+p_id+color, colorValues)== -1 && partsColorList[i].pending!=0)
					{
						// not found it
					    obj.find(".partsColorList").append("<option value='"+color+"'>"+color+"</option>");
					}	
					}
                } 
            }
			}
         }); 
     }
   
});


$(document).on('change','.partsColorList',function(){
    var part_colors =$(this).val();
    var obj = $(this).parent().parent();
	var m_id= obj.find(".manufacturer_id").val();
	var parts_id =obj.find('.parts_id').val();
	if(part_colors!=''){
	obj.find('.issuestock').removeAttr("readonly"); 
	clearData(obj);
    //alert(parts_id);
    getPartsColorImg(obj,parts_id,part_colors);
	getPartsDetails(obj,m_id,parts_id,part_colors);
	checkDuplicatePartsColorList(obj,m_id,parts_id,part_colors);
	}else{
	clearData(obj);
	obj.find('.issuestock').attr("readonly", "readonly"); 
	}
});

function getPartsColorImg(obj,p_id,pcolor){       
    // alert(obj.attr('class'));

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

function checkDuplicatePartsColorList(obj,c_m_id,c_parts_id,c_part_colors){
	$(".sResult").each(function(index){	
	var m_id=$(this).find("select.manufacturer_id option:selected").val();	
	var p_id=$(this).find("select.parts_id option:selected").val();
	//var color=tr.find("select.partsColorList option:selected").val();	
	if(m_id+p_id==c_m_id+c_parts_id){
		if($(this).find("select.partsColorList option:selected").val()!=c_part_colors){
		$(this).find("select.partsColorList option[value='"+c_part_colors+"']").remove();
		}	
	}
	});

	}


function getPartsDetails(obj,m_id,p_id,pcolor){
	if(p_id>0 && pcolor!=''){         
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getPartDetailsForStockIssue",
            data:{manufacturer_id:m_id,parts_id:p_id,part_colors:pcolor},
            success: function(response){ //alert(response);
                var partDetails = JSON.parse(response); 
                obj.find('.currentstock').val(partDetails.total_receipted);
				if(partDetails.issuestock!=0){
				var currentstock=parseFloat(partDetails.total_receipted)-parseFloat(partDetails.issuestock);	
				 obj.find('.currentstock').val(currentstock);	
				}
				calculate_total();
			}
         }); 
     }	 
}



$(document).on('blur','.issuestock',function(){
    var obj = $(this).parent().parent();
	var issuestock=$(this).val();
    var currentstock=obj.find('.currentstock').val();
    if(issuestock==''){issuestock=0;}
    if(parseFloat(issuestock)<=parseFloat(currentstock)){ 
    calculate_total();
    obj.find('.issuestock').removeClass('error_field');
    }else{
        $(this).val('');
        alert("Current Stock is "+currentstock+". Issue Stock is Greater than Current Stock");
        obj.find('.issuestock').addClass('error_field');
        
    }
});


function calculate_total(){
	var total_currentstock=0;	
	var total_issuestock=0;
	$(".sResult").each(function(){	
		total_currentstock+=parseFloat($(this).find(".currentstock").val()?$(this).find(".currentstock").val():0);	
		total_issuestock+=parseFloat($(this).find(".issuestock").val()?$(this).find(".issuestock").val():0);
	});
	$(".total_currentstock").html(total_currentstock.toFixed(2));	
	$(".total_issuestock").html(total_issuestock.toFixed(2));
	
	$(".total_currentstock_hidden").val(total_currentstock.toFixed(2));	
	$(".total_issuestock_hidden").val(total_issuestock.toFixed(2));
}