$('#shipment_id').on("selected", function(e) {
    var shipment_id = e.val;
    if (shipment_id > 0) {
        $.ajax({
            type: "POST",
            url: AJAX_URL + "getShipmentDetails",
            data: {ID: shipment_id },
            success: function (response) {
                getInvoiceDetails(response);
            }
        });

    }
});

function getInvoiceDetails(proforma_invoice_id){
    if(proforma_invoice_id>0){
        $.ajax({
            type: "POST",
            url: AJAX_URL+"getProformaInvoice",
            data:{ID: proforma_invoice_id},
            success: function(response){	//alert(response);
                $(".Print_page").css('display','');
                $('#load_goodreceipt_footer').show();
                $('#load_goodreceipt').append(response);
                $('#print_goodreceipt').append(response);
                calculate_total_pcs();
                calculate_currentstock();
                calculate_total_pending();
                calculate_total_receipted_pcs();
            }
        });

    }
    else{
        $('#load_goodreceipt').html("");
        $('#print_goodreceipt').html("");
        $(".Print_page").css('display','none');
    }
    $("#shipment_id").removeClass('error_field');
}

$('#shipment_id').on("removed", function(e) {
    var shipment_id = e.val;
    if (shipment_id > 0) {
        $.ajax({
            type: "POST",
            url: AJAX_URL + "getShipmentDetails",
            data: {ID: shipment_id },
            success: function (response) {
                $('.sResult'+response).remove();
                calculate_total_pcs();
                calculate_currentstock();
                calculate_total_pending();
                calculate_total_receipted_pcs();
            }
        });

    }
});

/*
$('.proforma_invoice_id').on("selected", function(e) {
   var proforma_invoice_id =e.val;
   if(proforma_invoice_id>0){
      $.ajax({
            type: "POST",
            url: AJAX_URL+"getProformaInvoice",
            data:{ID: proforma_invoice_id},
            success: function(response){	//alert(response);
                $(".Print_page").css('display','');
				$('#load_goodreceipt_footer').show();
                $('#load_goodreceipt').append(response); 
                $('#print_goodreceipt').append(response); 
                calculate_total_pcs();
                calculate_currentstock();
                calculate_total_pending();
                calculate_total_receipted_pcs();
            }
         });
        
   }
    else{
       $('#load_goodreceipt').html("");
       $('#print_goodreceipt').html("");
        $(".Print_page").css('display','none');
    } 
	$("#proforma_invoice_id").removeClass('error_field');
});


  $('.proforma_invoice_id').on("removed", function(e) {
    $('.sResult'+e.val).remove();
	calculate_total_pcs();
	calculate_currentstock();
	calculate_total_pending();
	calculate_total_receipted_pcs();
  });
*/


$(document).on('click', '#savegr,#approvegr', function(event) {
 var edit=$('.edit').val();
 var id=$(this).attr('id');
    if(checkrequied(id)>0){
          return false;
        }else{	
		if(this.id=='approvegr' && !confirm("Are you sure you want to approve the Goods Receipt?")){
		return false;
        }
		if(edit!=''){$("#grform").attr('action', 'edit');}	
		$("#grform").submit();
		}
});

function checkrequied(id) {
    var validate_error= 0;
    $('.required').each(function (index) {
        if ($(this).val() == '' || $(this).val() <= 0) {
            $(this).addClass('error_field');
            validate_error++;
        }
    });

    if ($('#proforma_invoice_id').val() != '' && $('#receipt_date').val() != '' && id=='approvegr'){
            if($('.total_receipt_val_hidden').val() <= 0){
            alert('Please Receive at least one  CS Pack');
            validate_error++;
        }
    }
    return validate_error;
}

$(document).on('change','.required',function(){
    $('.select2-container').removeClass('required');        // for select2
    $('.select2-input').removeClass('required');            // for select2

    if($(this).val()==''){
        $(this).addClass('error_field');
    }else{
        setTimeout(function() {
            //$(this).removeClass('error_field');
            $('.required').each(function(index) {
                if($( this ).val()!=''){
                    $(this).removeClass('error_field');
                }
            });
        }, 1000);
    }
});

/*
function checkrequied(id) {
    var validate_error=0;
 
    if($("#proforma_invoice_id" ).val()==''){
        $("#proforma_invoice_id").addClass('error_field');
          validate_error++;
    }
   
    if($("#receipt_date" ).val()==''){
        $("#receipt_date").addClass('error_field');
          validate_error++;
    }
    
	if($("#proforma_invoice_id" ).val()!='' && $("#receipt_date" ).val()!='' && id=='approvegr'){
		if($(".total_receipt_val_hidden" ).val()=='0'){
		alert("Please Receive at least one  CS Pack");
		validate_error++;
		}
	}
    return validate_error;
}
 */


$(document).on('blur','.total_receipt',function(){ 
    var obj = $(this).parent().parent();
	var pi_id=obj.find('.pi_id').val();
    var total_receipted=obj.find('.total_receipted').val(); 
    var total_receipt=$(this).val();
    var edit=$('.edit').val();
	
	var currentstock=obj.find('.currentstock').val();
    if(total_receipted!='0'){currentstock=currentstock-total_receipted;} 
    if(total_receipt==''){total_receipt=0;}
   
    if(parseFloat(total_receipt)<=parseFloat(currentstock)){ 
    obj.find('.total_receipt').removeClass('error_field');
    }else{
        if(edit!=''){
			var previous_total_receipt=obj.find('.previous_total_receipt').val();
			$(this).val(previous_total_receipt);
			
			if(total_receipted==0){
				alert("CS Pack is "+currentstock+". Receipt CS Pack is Greater than CS Pack");
			}else{
				alert("Pending CS Pack is "+currentstock+". Receipt CS Pack is Greater than Pending CS Pack");	
			
			}
		}else{
			$(this).val('');
			alert("Pending CS Pack is "+currentstock+". Receipt CS Pack is Greater than Pending CS Pack");
			obj.find('.total_receipt').addClass('error_field');
		}
    }
	calculate_pending(obj,edit);
    calculate_total_pending();
    calculate_total_receipt();
	if(edit==''){
	calculate_sub_total_received(pi_id);
	}
});

function calculate_pending(obj,edit){
    var total_receipted=obj.find('.total_receipted').val(); 
    var total_receipt=obj.find('.total_receipt').val();
    if(total_receipt==''){total_receipt=0;}
    var currentstock=obj.find('.currentstock').val(); 
	//if(edit!=''){
	//  var total_pending=total_pending=parseFloat(currentstock)-(parseFloat(total_receipt));	
	//}else{
    var total_pending=total_pending=parseFloat(currentstock)-(parseFloat(total_receipt)+parseFloat(total_receipted));
	//}
    obj.find('.total_pending').val(total_pending);
  return;
}

function calculate_currentstock(){
    var currentstock_val=0;
   
    $( ".currentstock" ).each(function(index){ 
        var currentstock =$(this).val();
        if(currentstock>0){
         currentstock_val+=parseFloat($(this).val());
        }
            
    });  
    currentstock_val=currentstock_val.toFixed(2); 
    $('.total_currentstock_val_hidden').val(currentstock_val);
    $('.total_currentstock_val').text(currentstock_val);
 }
 
 function calculate_total_pcs(){
    var total_pcs_val=0;
   
    $( ".total_pcs" ).each(function(index){ 
        var total_pcs =$(this).val();
        if(total_pcs>0){
         total_pcs_val+=parseFloat($(this).val());
        }
            
    });  
    total_pcs_val=total_pcs_val.toFixed(2); 
    $('.total_pcs_val_hidden').val(total_pcs_val);
    $('.total_pcs_val').text(total_pcs_val);
 }
 
function calculate_total_receipt(obj){ 
   var total_receipt_val=0;
    $( ".total_receipt" ).each(function(index){ 
        var total_receipt =$(this).val();
        
        if(total_receipt>0){
            total_receipt_val+=parseFloat($(this).val());
        } 
    });  
    total_receipt_val=total_receipt_val.toFixed(2);
    $('.total_receipt_val_hidden').val(total_receipt_val);
    $('.total_receipt_val').text(total_receipt_val);
    return; 
}
function calculate_total_pending(){
    var total_pending_val=0;
   
    $( ".total_pending" ).each(function(index){ 
        var total_pending =$(this).val();
        if(total_pending>0){
         total_pending_val+=parseFloat($(this).val());
        }
            
    });  
    total_pending_val=total_pending_val.toFixed(2); 
    $('.total_pending_val_hidden').val(total_pending_val);
    $('.total_pending_val').text(total_pending_val);
 }

function calculate_total_receipted_pcs(){
     var total_receipted_val=0;
   	$( ".total_receipted" ).each(function(index){ 
        var total_receipted =$(this).val();
        if(total_receipted>0){
        total_receipted_val+=parseFloat($(this).val());
        }
            
    });  
    total_receipted_val=total_receipted_val.toFixed(2); 
	if(total_receipted_val>0){
		$('.receipted_td').removeClass('no-print');
		$('.receipted_td').show();
		}else{
			$('.receipted_td').addClass('no-print');
			$('.receipted_td').hide();
		}
    $('.total_receipted_val_hidden').val(total_receipted_val);
    $('.total_receipted_val').text(total_receipted_val);
    
} 

function calculate_sub_total_received(pi_id){
	var currentstock=0;   
	var total_receipted=0;
	var total_pending=0;
	 
	var sub_total_currentstock_val=0;
	var sub_total_pending_val=0;
	var sub_total_received_val=0;
	var sub_total_receiving_val=0;

    $( ".total_receipt"+pi_id).each(function(index){ 
        var total_receipt =$(this).val(); 
        if(total_receipt>0){
			currentstock=$('.currentstock'+pi_id+'_'+index).val();   
			total_receipted=$('.total_receipted'+pi_id+'_'+index).val();
			total_pending=$('.total_pending'+pi_id+'_'+index).val();
			
			sub_total_currentstock_val+=parseFloat(currentstock);
			sub_total_received_val+=parseFloat(total_receipted);
			sub_total_pending_val+=parseFloat(total_pending);
			
			sub_total_receiving_val+=parseFloat(total_receipt);
        } 
    });  
	
			
    sub_total_currentstock_val=sub_total_currentstock_val.toFixed(2);
	sub_total_pending_val=sub_total_pending_val.toFixed(2);
	sub_total_received_val=sub_total_received_val.toFixed(2);
	sub_total_receiving_val=sub_total_receiving_val.toFixed(2);

	$('.sub_total_currentstock'+pi_id).val(sub_total_currentstock_val);
	$('.sub_total_pending'+pi_id).val(sub_total_pending_val);
	$('.sub_total_received'+pi_id).val(sub_total_received_val);
	$('.sub_total_receiving'+pi_id).val(sub_total_receiving_val);

	if(sub_total_receiving_val>0){$('.sub_pi_id'+pi_id).val($('.span_sub_pi_id'+pi_id).html());}
	else{$('.sub_pi_id'+pi_id).val('0');}
	return;
}

