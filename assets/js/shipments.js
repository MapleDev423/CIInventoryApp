$(document).on('change', '#pi_id', function(event) {
    var pi_id = $(this).val();

    if(pi_id>0) {
        $.ajax({
            type: "POST",
            url: AJAX_URL + "getPIDetailsByPI_id",
            data: {ID: pi_id},
            success: function (response) { //alert(response);
                var resultData = JSON.parse(response);
                var es_date= dateFormat(new Date(resultData.details['shipping_date']));
                var confirmation_no= resultData.details['confirmation_no'];
                var total_cost_val= resultData.details['total_cost_val'];
                var deposit_balance= resultData.details['total_deposit_val'];

                $('#estimated_shipping_date').val(es_date);
                $('#confirmation_no').val(confirmation_no);
                $('#deposit_balance').val(deposit_balance);

                var due_balance= (total_cost_val-deposit_balance).toFixed(2);
                $('#due_balance').val(due_balance);
            }
        });
    }else{
        $('#estimated_shipping_date').val('');
        $('#confirmation_no').val('');
        $('#deposit_balance').val('0.00');
        $('#due_balance').val('0.00');
    }
});

$(document).on('click', '#saveShipment, #generateShipment', function(event) {
    if(checkrequied()>0){
          return false;
        }else{
        if(this.id=='generateShipment' && !confirm("Are you sure you want to approve the Shipment?")){
            return false;
        }
          $("#shform").submit();
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

function dateFormat(date=''){
    var d = (date!='')?date:new Date();
    var curr_date = ("0" + (d.getDate())).slice(-2);
    var curr_month = ("0" + (d.getMonth()+1)).slice(-2);
    var curr_year = d.getFullYear();
    var newFormat=curr_month+'/'+curr_date+'/'+curr_year;
    return newFormat;
}