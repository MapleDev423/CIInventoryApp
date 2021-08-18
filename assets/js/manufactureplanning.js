$(document).on('change','.product_id',function(){
    var product_id =$(this).val();
    var obj = $(this).parent().parent();
  
    getBom(product_id,obj);
    
});

function getBom(product_id,obj){       
     if(product_id>0){
        $(".bom_id").html('');
		clearData();
		$(".bom_id").append("<option value=''>Select Bom Name</option>");
        
		$.ajax({
            type: "POST",
            url: AJAX_URL+"getBomByProduct",
            data:{product_id:product_id},
            success: function(response){ 
                var resultData = JSON.parse(response);
                var partDetails = resultData['bomList'];
                var reslen=0;
               
                var i=0;

                if(partDetails!=null){
                    reslen= partDetails.length;
                if(reslen>0){
					
                    for(i=0;i<reslen;i++){
                        $(".bom_id").append("<option value='"+partDetails[i].ID+"'>"+partDetails[i].title+"</option>");
					}
                }
				}
            }
         }); 
     }
   
}

$(document).on('change','.bom_id',function(){
	var bom_id =$(this).val();
	
	if(bom_id>0){
        clearData(); 
        $.ajax({
            type: "POST",
            url: AJAX_URL+"bom_modalformanufactureplanning",
            data:{bom_id:bom_id},
            success: function(response){ 
                var total_cost=0;
				var resultData = JSON.parse(response);
                var partDetails = resultData.parts;
                var reslen=0;
               
                var i=0;

                if(partDetails!=null){
                    reslen= partDetails.length; 
                if(reslen>0){
					
            for(i=0;i<reslen;i++){
			if(partDetails[i].parts_price==''){partDetails[i].parts_price=0;}	
			if(partDetails[i].quantity==''){partDetails[i].quantity=0;}	
			
			var cost=(parseFloat(partDetails[i].parts_price*partDetails[i].quantity)).toFixed(2);
			total_cost=(parseFloat(total_cost)+parseFloat(cost)).toFixed(2);
			
			var trNew = $(".sResult:last").clone();
			$(".sResult:first").hide();
            var trLast = $('#addCont').find("tr:last")
            trLast.after(trNew);
			$(".sResult:last").find(".manufacturer_name").val(partDetails[i].manufacturer_name);
			$(".sResult:last").find(".part_name").val(partDetails[i].part_name);
			$(".sResult:last").find(".part_colors").val(partDetails[i].part_colors);
			$(".sResult:last").find(".parts_img").html('<img src="'+partDetails[i].partColors_imgpath+'"+ alt="Parts image" style="height:150px;weight:150px;">');
			$(".sResult:last").find(".unit_title").val(partDetails[i].unit_title);
			$(".sResult:last").find(".quantity").val(partDetails[i].quantity);
			$(".sResult:last").find(".price").val(partDetails[i].parts_price);
			$(".sResult:last").find(".cost").val(cost);
			}
			
			$(".totalcost_span").html(total_cost);
			$(".totalcost").val(total_cost);
		}
		}
            }
         }); 
     }
   
});

function clearData(){
	$(".sResult:first").show();
	var trNew = $(".sResult:first").clone();
	$('#addCont').html('');
	$('#addCont').html(trNew);
	$(".totalcost_span").html('0.00');
	$(".totalcost").val('');
}

function checkrequied() {
    var validate_error=0;

    $('.required').each(function( index ) {
        if($( this ).val()=='' || $( this ).val()<=0){
            $(this).addClass('error_field');
            validate_error++;
        }
    });

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