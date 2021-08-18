function validate_form(fid='') {
	$(function() {
  	var form_id=(fid!='')?fid:'myform';
	  $("#"+form_id).validate({
	    ignore: "",
	    highlight: function (element) {
	        $(element).closest('.form-control').addClass('has-error');
	    },
	    unhighlight: function (element) {
	        $(element).closest('.form-control').removeClass('has-error');
	    },
	    errorPlacement: function (error, element) {
	        if (element.parent('.input-group').length) {
	            error.insertAfter(element.parent());
	        } else {
	            error.insertAfter(element);
	        }
	    },
	    submitHandler: function(form) {
	      form.submit();
	    }
	  });
	});
}

function dataTable(t_id='') {
	$(function() {
	var table_id=(t_id!='')?t_id:'mytable';
	$('#'+table_id).DataTable({
      'paging'      : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'aoColumnDefs': [{
        "orderable": false,
        'bSortable': false,
        'aTargets': ['nosort']
       }]

    });
});
}

$(function() {    
	$("#checkAll").click(function(){
	    $('input.checkboxitem').not(this).prop('checked', this.checked);
	});
	$("input.checkboxitem").click(function(){
	    $('#checkAll').prop('checked', false);
	});
});

function deleterecord(argument) {
	var total=$("#tableForm").find('.checkboxitem:checked').length;
	if(total==0){
	    alert('Please select at least on record.');
	}
	else{
		if (confirm("Are you sure want to delete these records?")) {
			$("#tableForm").submit();
		}
		
	}
	
}

function singleAction(action,actionField,actionFieldValue,actionUrl,actionCallBack,actionMessage)
{

    if(action !='' && actionFieldValue!='' && actionUrl !=''){

        switch(action){
            case 'active' 		: message = "Are you sure want to activate this record?";break;
            case 'deactive' 	: message = "Are you sure want to deactivate this record?";break;
            case 'delete' 	: message = "Are you sure want to delete this record?";break;
            default			: message = "Do you want to perform this action?";break;
        }

        if(typeof(actionMessage)==='undefined' || actionMessage==''){ actionMessage = message; }
		else{ actionMessage=base64_decode(actionMessage);}
		
        if(typeof(actionCallBack)==='undefined') actionCallBack = document.location.href;
        
		 actionCallBack=(actionCallBack.replace('&','%'));
		 
            actionUrl = base64_decode(actionUrl)+'?action='+action+'&'+actionField+'='+actionFieldValue;
			var urlR=actionUrl+"&callbackurl="+actionCallBack;
		if(confirm(actionMessage)){
			document.location.href=urlR;
		}	
		
    }
}


$(document).on('keypress', '.digits', function(e) {
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		 return false;
	}
});


$(document).on('keypress', '.numbers', function(e) {
	if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
		 return false;
	}
	else{
		if(e.which== 46){
			var value=$(this).val();
			var count = value.split(".").length - 1;
			
			if (count>0) {
				return false;
			}
		}
		
	}
});


function password_strength(password,password_length) {
	$returnVal = true;
	//alert(password);
	var regEx =  /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])/;
	if ( strlen(password) < password_length ) {
		$returnVal = false;
	}
	else if (! password.match(regEx) ) {
		$returnVal = false;
	}
	return $returnVal;
}
$(function() {
	setTimeout(function(){ $("#alert_meg").hide(500) },10000);
});

function ValidateImage(oInput) {

    var _validFileExtensions = [ ".png", ".jpg", ".jpeg",".gif"]; 
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        var size=oInput.files[0].size;
          if(size>20718650){
          alert("PLEASE SELECT IMAGE LESS THAN 20Mb ....THANK YOU.");
           oInput.value = "";
            return false;
          }
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
               /* alert("Sorry, " + sFileName + " is invalid, allowed extensions are only : " + _validFileExtensions.join(", "));*/
               alert("Please upload only png, jpg, jpeg, gif format files.")
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

$(function() {
$(".alert-dismissible").fadeTo(4000, 500).slideUp(500, function(){
    $(".alert-dismissible").alert('close');
});
});