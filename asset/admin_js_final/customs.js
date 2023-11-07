/*$(document).ready(function(){
	$('.nav-link').click(function() { 
	    $('.nav-link').closest('li').removeClass("active");   
	    $(this).closest('li').addClass("active");  
	    var content = $(this).data('value');
	    if(content!=''){
	    	if(content=='caveat'){
	    		$('.steps').empty().load(base_url+'/mystart/'+content);
	    	}else if(content=='review_petition_filing'){
	    		$('.steps').empty().load(base_url+'/filingaction/'+content);
	    	}else if(content=='edit_contempt_petition_filing'){
	    		$('.steps').empty().load(base_url+'/filingaction/'+content);
	    	}else if(content=='edit_execution_petition_filing'){
	    		$('.steps').empty().load(base_url+'/filingaction/'+content);
	    	}else if(content=='edit_ia_details_filing'){
	    		$('.steps').empty().load(base_url+'/filingaction/'+content);
	    	}else if(content=='edit_document_filing'){
	    		$('.steps').empty().load(base_url+'/filingaction/'+content);
	    	}
	    	if(content!='caveat'){
	    		$('.steps').empty().load(base_url+'/efiling/'+content);
	    	}
	    }
	});
});*/

function submitForm()
{
	with(document.frm)
	{
		action = window.location.pathname;

		submit();
	}
}
function finalsubmitEdit(){
	var saltmain = document.getElementById("salt").value;
	var radios = document.getElementsByName("orgres");
	var token= document.getElementById("token").value;
	var bd = 0;
	for (var i = 0; i < radios.length; i++) {
		if (radios[i].checked) {
			var bd = radios[i].value;
		}
	}
	if (bd == 3) {
		var dbankname = document.getElementById("ntrp").value;
		if (dbankname == "") {
			alert("Please Enter Bank name");
			document.filing.ntrp.focus();
			return false;
		}
		var ddno = document.getElementById("ntrpno").value;
		var vasks = ddno.toString().length;
		if(Number(vasks) != 13){
			alert("Please Enter 13  Digit Challan No/Ref.No");
			document.filing.ntrpno.focus();
			return false
		}
		if (ddno == "") {
			alert("Please Enter Challan No/Ref.No");
			document.filing.ntrpno.focus();
			return false
		}
		var dddate = document.getElementById("ntrpdate").value;
		if (dddate == "") {
			alert("Please Enter Date of Transction");
			document.filing.ntrpdate.focus();
			return false
		}
		var amountRs = document.getElementById("ntrpamount").value;
		if (amountRs == "") {
			alert("Please Enter Amount ");
			document.filing.ntrpamount.focus();
			return false
		}
	}
	var dataa={};
	dataa['dbankname']=dbankname,
		dataa['amountRs']=amountRs,
		dataa['ddno']=ddno,
		dataa['dddate']=dddate,
		dataa['bd']=bd,
		dataa['sql']=saltmain,
		dataa['token']=token,
		$.ajax({
			type: "POST",
			url: base_url+'efilingfinalsubmitEdit',
			data: dataa,
			cache: false,
			beforeSend: function(){
				$('#finalsave').prop('disabled',true).val("Under proccess....");
			},
			success: function (resp) {
				var resp = JSON.parse(resp);
				if(resp.data=='success') {
					setTimeout(function(){
						window.location.href = base_url+'refilesuccess';
					}, 250);
				}
				else if(resp.error != '0') {
					$.alert(resp.display);
				}
			},
			error: function(){
				$.alert("Surver busy,try later.");
			},
			complete: function(){
				$('#finalsave').prop('disabled',false).val("Submit");
			}
		});
}
function finalsubmit(){
       var total_amount_amount = document.getElementById("total_amount_amount").value;
     
       var idorg = document.getElementById('org1').value;
       var idorg1=document.getElementById('orgres1').value;
       var bench = document.getElementById("bench").value;
       var subBench = document.getElementById("sub_bench").value;
       var caseType = document.getElementById("caseType").value;
       var saltmain = document.getElementById("saltmain").value;
       var radios = document.getElementsByName("orgres");
       var token= document.getElementById("token").value;
       var bd = 0;
       for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                var bd = radios[i].value;
            }
        }
   		if (bd == 3) {
            var dbankname = document.getElementById("ntrp").value;
			var total = document.getElementById("total").value;
			var collectamount = document.getElementById("collectamount").value;
			var ddno = document.getElementById("ntrpno").value;
			var dddate = document.getElementById("ntrpdate").value;
			var amountRs = document.getElementById("ntrpamount").value;
			if(total>collectamount) {
				if (dbankname == "") {
					alert("Please Enter Bank name");
					document.filing.ntrp.focus();
					return false;
				}

				var vasks = ddno.toString().length;
				/*if (Number(vasks) < ) {
					alert("Please Enter 13  Digit Challan No/Ref.No");
					document.filing.ntrpno.focus();
					return false
				}*/
				if (ddno == "") {
					alert("Please Enter Challan No/Ref.No");
					document.filing.ntrpno.focus();
					return false
				}

				if (dddate == "") {
					alert("Please Enter Date of Transction");
					document.filing.ntrpdate.focus();
					return false
				}

				if (amountRs == "") {
					alert("Please Enter Amount ");
					document.filing.ntrpamount.focus();
					return false
				}
			}
   		}
   		var iawaver = document.getElementById("wia").value;
   		var amountRs = document.getElementById("ntrpamount").value;

   		var valamount=Number(amountRs)+Number(collectamount);

   		if(iawaver!='3'){
       		if(valamount<total){
    	        alert("Amount should be equal to total amount ! ");
                return false
       		}
		}
		var iaFee1=0;
		if(document.getElementById(iaFee1) != null) {
			var iaFee1 = document.getElementById("iaFee1").value;
		}
		var otherFee2 = document.getElementById("otherFee2").value;
		var validateamount=Number(iaFee1)+Number(otherFee2);
		if(iawaver=='3'){
       		if(valamount<validateamount){
    	        alert("Amount should be equal to total amount ! ");
                return false
       		}
		}

      
       var dataa={};
       dataa['total_amount_amount']=total_amount_amount, 
       dataa['bench']=bench;
       dataa['subBench']=subBench,
       dataa['type']=caseType,
       dataa['typefiled']=idorg,
       dataa['typefiledres']=idorg1,
       dataa['dbankname']=dbankname,
       dataa['amountRs']=amountRs,
       dataa['ddno']=ddno,
       dataa['dddate']=dddate,
       dataa['bd']=bd,
       dataa['sql']=saltmain,
       dataa['token']=token,
       $.ajax({
	        type: "POST",
	        url: base_url+'efilingfinalsubmit',
	        data: dataa,
	        cache: false,
			beforeSend: function(){
				$('#finalsave').prop('disabled',true).val("Under proccess....");
			},
	        success: function (resp) {
	        	var resp = JSON.parse(resp);
	        	if(resp.data=='success') {
	        		 $('#mainDiv1').hide();
	        		 $('#secondDiv').html(resp.display);
				}
				else if(resp.error != '0') {
					$.alert(resp.error);
				}
	        },
	        error: function(){
				$.alert("Surver busy,try later.");
			},
			complete: function(){
				$('#finalsave').prop('disabled',false).val("Submit");
			}
		 }); 	 
}


$(document).ready(function(){
	 $(".datepicker" ).datepicker({ 
		 dateFormat: "dd-mm-yy",
		 maxDate: 'now'});
	}); 


/*$(document).ready(function(){
	$('.btn-breadcrumb > a').click(function(e){
		e.preventDefault();		
		$('#loading_modal').modal('show');
		var click_event=$.trim($(this).attr('id')), click_event_text=$.trim($(this).text()),
	
		programe_name='', page_load_url='',click_id_number='';

		click_event_text=click_event_text.toLowerCase(), programe_name=click_event_text.replace(' ','_'), 
		page_load_url =base_url+'/loadpage/'+programe_name, click_id_number=parseInt(click_event.slice(-1));

		$('#'+click_event).removeClass('btn-danger btn-warning btn-info').addClass('btn-warning');
		
		for(var i=1; i<click_id_number; i++) {
			$('#step_'+i).removeClass('btn-danger btn-warning btn-info').addClass('btn-success');
		}
		for(var j=(click_id_number+1); j<=8; j++) {
			$('#step_'+j).removeClass('btn-success btn-warning btn-info').addClass('btn-danger');
		}

		$('#rightbar').empty().load(page_load_url);

		$.ajax({
				type: 'post',
				url: base_url+'list_data',
				data: {"table_name": programe_name},
				dataType: 'html',
				success: function(get_list) {
					$('#'+programe_name+'_list').empty().html(get_list);
				},
				error: function(){
					alert('Server error,try later');
				},
				complete: function(){
					$('#'+programe_name+'_table').DataTable();
				}

		});
		
		setTimeout(function() {
		  $('#loading_modal').modal('hide');
		}, 500);
	});

});
*/


	$('#state').change(function(e){
	  	e.preventDefault();
	  	var state_id=$.trim($(this).val());
	  	if(state_id !='') {
	  		$.ajax({
	  			url: base_url+'getDistrict',
	  			type: 'post',
	  			data: {"state_id":state_id},
	  			dataType: 'json',
	  			beforeSend: function(){
	  				$('#district').find(":selected").text("Feaching Districts.....");
	  			},
	  			success: function(resp){
	  				if(resp.error=='0'){
	  					$('#district').removeAttr('disabled').empty();
	  					$('#district').html('<option value="">-----Select District Name-----</option>');
	  					$.each(resp.data, function(index, itemData) {
	  						var option='<option value="'+itemData.district_id+'">'+itemData.district_name+'</option>';
	  						$('#district').append(option);
						});
	  				}
	  				else {
	  					$('#district').find(":selected").text("-----Select District Name-----");
	  					alert(resp.error);
	  				}
	  			},
	  			error: function(){
	  				alert('Server error, try later.');
	  			}

	  		});
	  	}
	  	else {
	  		alert("Please select valid state name.");
	  		$('#district').attr('disabled',true).empty();
	  		$('#district').html('<option value="">-----Select District Name-----</option>');
	  		return false;
	  	}
  	});







function get_date(id) {
$('#add_btn_commission').removeAttr('disabled');
$(id).datepicker({
	autoclose: true,
	immediateUpdates: true,
	format: 'dd-mm-yyyy',
	startView: 0,
	todayHighlight: true,
	startDate: '-2W',
	endDate: '+4W'
});
}



function get_date1(id) {
$(id).datepicker({
	autoclose: true,
	immediateUpdates: true,
	dateFormat: 'dd/mm/yy',
	startView: 0,
	todayHighlight: true,
	startDate: '-2W',
	endDate: '+4W'
});
}







function view_caveat_recipt(filing_no,activeA) {
event.preventDefault();
$(activeA).removeClass('text-danger').addClass('text-success');
$('#caveat_filing_table').find('button.fa-print').attr('disabled',true);
$.ajax({
	type: 'post',
	url: base_url+'caveat_recipt',
	data: {'filing_no':filing_no},
	dataType: 'html',
	cache: false,
	success: function(retrn){
		$('#caveatRecipt').modal();
		$('#caveatRecipt').find('.container_inner').html(retrn);
	},
	error: function(){
		$.alert('Server busy, try later');
	},
	complete: function(){
		$('#caveat_filing_table').find('button.fa-print').removeAttr('disabled');
	}
});
}

function printRecipt(){
var divtoPrint=document.getElementById("printable-div");
newWin=window.open("");
newWin.document.write(divtoPrint.outerHTML);
newWin.print();
newWin.close();
}

function get_district(id) {
	event.preventDefault();
	var state_id=$.trim($(id).val());
	if(state_id !='') {
		$.ajax({
			url: base_url+'getDistrict',
			type: 'post',
			data: {"state_code":state_id},
			dataType: 'json',
			beforeSend: function(){
				$('#district').find(":selected").text("Feaching Districts.....");
			},
			success: function(resp){
				if(resp.error=='0'){
					$('#district').removeAttr('disabled').empty();
					$('#district').html('<option value="">-----Select District Name-----</option>');
					$.each(resp.data, function(index, itemData) {
						var option='<option value="'+itemData.district_code+'">'+itemData.district_name+'</option>';
						$('#district').append(option);
				});
				}
				else {
					$('#district').find(":selected").text("-----Select District Name-----");
					alert(resp.error);
				}
			},
			error: function(){
				alert('Server error, try later.');
			}

		});
	}
	else {
		alert("Please select valid state name.");
		$('#district').attr('disabled',true).empty();
		$('#district').html('<option value="">-----Select District Name-----</option>');
		return false;
	}
}

function addCaveatDetails(){
event.preventDefault();

$.ajax({
		url: base_url+'addNewCaveat',
			type: 'post',
			data: $("#addCaveat").serialize(),
			dataType: 'json',
		beforeSend: function(){
			/*$('#loading_modal').modal('show'), */$('#caveat_submit_btn').val(' Under proccess.....').attr('disabled',true);
		},
		success: function(retrn){

			if(retrn.data=='success') {
				if(retrn.ia_number !='0') {
					$.confirm({
				        animationSpeed: 2000,
				        title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Congrates</b>',
				        content: '<p class="text-success">Caveat successfully inserted for forther action,<br>Kindly notedown Caveat Diary No. <u class="text-danger">'+retrn.ia_number+'</u></p>',
					});
					$("#addCaveat").trigger("reset");
					$('#caveat').trigger("click");

				} else {
					$.alert({
						title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Congrates</b>',
						content: '<p class="text-success">Caveat successfully saved.</p>',
						animationSpeed: 2000
					});
					$("#addCaveat").find('input,select,textarea').attr('disabled',true);
					$('#fee_div').removeClass('d-none').find('input').removeAttr('disabled').attr('required',true);
				}
			}else {
				$.alert({
					title: '<i class="fa fa-exclamation text-danger"></i>&nbsp;</b>Error</b>',
					content: '<p class="text-danger">'+retrn.error+'</p>',
					animationSpeed: 200

				});
			}
		},
		error: function(){
			$.alert('Server busy,try later');
		},
		complete: function(){
			/*$('#loading_modal, .modal-backdrop').modal('hide').addClass('d-none'), */$('#caveat_submit_btn').val(' Save').removeAttr('disabled');
		}
});
}

function get_org_data(id) {
event.preventDefault();
var org_id='', org_text='';
org_id=$(id).val(), org_text=$('select[name=organization] option:selected').text();
$('input[name=caveat_name]').val(org_text);
$.ajax({
	type: 'post',
	url: base_url+'getOrgfurther',
	data: {'org_id': org_id},
	dataType: 'json',
	cache: false,
	success: function(retrn){
		$('textarea[name=caveat_address]').val(retrn[0].org_address);
		$('select[name=caveat_state] > option').each(function(){
			if($(this).val()==$.trim(retrn[0].state)) {
					$(this).attr('selected',true);
			}
			else 	$(this).attr('selected',false);
		});
		$('select[name=caveat_district]').empty().removeAttr('disabled',false).append('<option value="'+retrn[0].district+'">'+retrn[0].district_name);				
		$('input[name=caveat_pin]').val(retrn[0].pin);
		$('input[name=caveat_email]').val(retrn[0].email);
		$('input[name=caveat_mobile]').val(retrn[0].mobile_no);
	},
	error: function(){
		$.alert('Server busy, try later');
	}
});
}

function get_adv_data(id) {
	event.preventDefault();
	var adv_code='';
	adv_code=$(id).val();
	$.ajax({
		type: 'post',
		url: base_url+'list_data',
		data: {'adv_code': adv_code,'table_name':'master_advocate'},
		dataType: 'json',
		cache: false,
		success: function(data2){
			  showCity(data2[0].state_code, data2[0].district_code);
              $("#counselAdd").val(data2[0].address);
              $("#counselMobile").val(data2[0].adv_mobile);
              $("#counselEmail").val(data2[0].email);
              $("#counselPhone").val(data2[0].adv_phone);
              $("#counselPin").val(data2[0].adv_pin);
              $("#counselFax").val(data2[0].adv_fax);
              $("#dstate").val(data2[0].state_code);
              $("#dstatename").val(data2[0].state_name);
              $("#ddistrict").val(data2[0].district_code);
              $("#ddistrictname").val(data2[0].district_name);
		},
		error: function(){
			$.alert('Server busy, try later');
		}
	});
}


function trans_date(id){
$.alert('Choose date.');
$(id).datepicker({
	autoclose: true,
	immediateUpdates: true,
	format: 'yyyy-mm-dd',
	startView: 0,
	todayHighlight: true,
	startDate: '-1W',
	endDate: 'today'
});

}

function active_payment_div(divName,id){
$('#bdd, #po, #olp').removeAttr('checked');
$('#online_payment_div, #postal_order_div, #bankdd_div').addClass('d-none').find('input').attr('disabled',true);

$(id).attr('checked', true);
$('#'+divName).removeClass('d-none').find('input').removeAttr('disabled');
}

function show_hide(id) {
var id_text=$.trim($(id).text());
if(id_text=='Add Caveat'){
	$('#caveat-form-div').removeClass('d-none');
	$(id).html('&nbsp;&nbsp;Hide Caveat Form').removeClass('fa-eye').addClass('fa-eye-slash');
}
else {
	$('#caveat-form-div').addClass('d-none');
	$(id).html('&nbsp;&nbsp;Add Caveat').removeClass('fa-eye-slash').addClass('fa-eye');
}
}

function search_ia(id) {
event.preventDefault();
var selected_year=$('select[name=year]').val(), page_url='';
    page_url=base_url+'loadpage/ia_list';

$.ajax({
		type: 'post',
		url: page_url,
		dataType: 'html',
		data: {'year': selected_year},
		cache: false,
		beforeSend: function(){				
			$(id).attr('disabled',true);
		},
		success: function(ia_data){
			$('#rightbar').empty().html(ia_data);
			$('#ia_list_table').DataTable();
		},
		error: function(){
			$.alert('Server busy,try later.');
		},
		complete: function(){				
			$(id).removeAttr('disabled');
		}
});
}



function paper_updoad(mp_value){
	if(mp_value!=''){
		$('.file-upload').removeClass('disabled');
		$('input[name=upd_paper]').attr('disabled',false).click();
	}
	else {
		$.alert('Select valid paper master');
		return false;
	}
}

function choose_mpfile(){
	event.preventDefault();
	var requ_doc_type=$.trim($('select[name=paper_master]').val()), rdt_text=$('select[name=paper_master]').find("option:selected").text(), 
    	token=Math.random().toString(36).slice(2), token_hash=HASH(token+'upddoc');

	var salt = document.getElementById("saltNo").value;
	if(salt==''){
        var salt = Math.ceil(Math.random() * 100000);
        document.getElementById("saltNo").value = salt;
    }
    if(requ_doc_type != '' && requ_doc_type != 'undefined') {
        formdata = new FormData();
        if($('input[name=upd_paper]').prop('files').length > 0) {
            file =$('input[name=upd_paper]').prop('files')[0], name = $.trim(file.name), name=name.toLowerCase(), size = file.size, type = $.trim(file.type), type=type.toLowerCase();
            var dots = name.match(/\./g).length, extarray=name.split('.'), ext=extarray[1].toLowerCase();            
            if(file != undefined && name.match(/\.(pdf)$/) && type == "application/pdf") {        
                if(dots > 1){  
                    $.alert('More than one dot (.) not allowed in uploding file!');
                    $('#req_doc').val(''); return false;
                }
                else if (size > 1999990) {  
                    $.alert('Please select file size less than 2000 KB.');
                    $('#req_doc').val(''); return false;
                }
                else {
                	$('input[name=upd_paper]').attr('disabled',true), $('.file_name_span').removeClass('hide').html(file.name); 
                    formdata.append("choose_file", file), 
                    formdata.append("reqdoctype", requ_doc_type),
                    formdata.append("token", token),
                    formdata.append("filing_no", $('input[name=filing_no]').val()),
                    formdata.append("filing_year", $('select[name=filing_year]').val()),
                    formdata.append("user_type",$('input[name=userType]:checked').val());
                    formdata.append("salt",salt);
                    $.ajax({
                        type:'post',
                        url: base_url+'docupd_paper/'+token_hash,
                        data: formdata,
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                        beforeSend: function(){
                        	$('#loading_modal').modal(), $('.ia_fee_div, .pmode, .ia_nature_div, #vakalatnama_fieldset').addClass('d-none'),
                        	$('select[name=ia_nature_name], select[name=council_name]').attr('disabled',true), 
                        	$('.tannexure').removeClass('d-none').find('input[name=annexure]').prop('disabled',false);
                        },
                        success: function(response){
                            if(response.data=='success') {
                            	var first_two_char=requ_doc_type.substring(0,2).toLowerCase();
                                $.alert({
									title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Congrates</b>',
									content: '<p class="text-success">ID Proof document uploaded successfully.</p>',
									animationSpeed: 2000
								});
                                $('select[name=paper_master] option:selected').prop('disabled',true).addClass('text-success');
                                $('.file-upload').addClass('disabled');
                                $('input[name=upd_paper]').prop('disabled',true);
                                $('.pmode').removeClass('d-none');
                                $('input[name=payment_mode], .upd-save').prop('disabled',false);

                                $('select[name=paper_master] > option').each(function(){
									if($(this).val().substring(0,2).toLowerCase()!=first_two_char)
										$(this).prop('disabled',true).addClass('text-danger');
								});

                                if(first_two_char=='ia') {
                                	$('.ia_fee_div, .ia_nature_div').removeClass('d-none'),
                                	$('select[name=ia_nature_name]').removeAttr('disabled',false);
                                }
                                else if(first_two_char=='va') {
                                	$('#vakalatnama_fieldset').removeClass('d-none'),
                                	$('select[name=council_name]').prop('disabled',false),
                                	$('.tannexure').addClass('d-none').find('input[name=annexure]').prop('disabled',true);
                                }

                            }else if(response.error !='0') {
                                $.alert(response.error);
                            }
                        },
                        error: function(xhr,status){
                            $.alert('Server busy, try later');
                        },
                        complete: function(){	                        	
							$('#loading_modal, .modal-backdrop').removeClass('show').addClass('d-none');
							$('body').removeAttr('style class');
                        }
            
                    });
                }

            }else {
                $.alert("Please Choose Valid Document");
                $('input[name=upd_paper]').prop('disabled',true);
                $('.file-upload').addClass('disabled');
                $('select[name=paper_master]').val(''); return false;
            }
        }
    }else {
        $.alert("Please select document type for upload!");
        $('#idproof').val(''); return false;
    }
}


function upd_master_paper(){
	event.preventDefault();
	if($('input[name=payment_mode]:checked').length == 0) {
		$.alert('Kindly choose payment option first.');
		return false;
	}
	else {
		var url=base_url+'upd_master_paper';
		$.ajax({
			 	type: 'post',
			 	url: url,
			 	data: $('#addMasterPaper').serialize(),
			 	dataType: 'json',
			 	beforeSend: function(){
			 		$('#loading_modal').modal('show'), $('.upd-save').val(' Under proccess.....').attr('disabled',true);
			 	},
			 	success: function(retrn){
			 		if(retrn.data=='success'){
			 			$.alert({
							title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Congrates</b>',
							content: '<p class="text-success">Document with details successfully saved.</p>',
							animationSpeed: 2000
						});
			 			$('#addMasterPaper').trigger('reset');
			 			$('#document_filing').trigger("click");
			 		}
			 		else {
			 			$.alert({
							title: '<i class="fa fa-exclamation-triangle text-danger"></i>&nbsp;</b>Warning</b>',
							content: '<p class="text-danger">'+retrn.error+'</p>',
							animationSpeed: 2000
						});
			 		}
			 	},
				error: function(){
					$.alert('Server busy, try later'), $('#loading_modal .modal-backdrop').removeClass('show').addClass('d-none');
					$('body').removeAttr('style class');
					$('.upd-save').val(' Save').removeAttr('disabled');
				},
				complete: function() {
					$('#loading_modal, .modal-backdrop').removeClass('show').addClass('d-none');
					$('body').removeAttr('style class');
					$('.upd-save').val(' Save').removeAttr('disabled');
				}
		})
	}
}



/*progress bar*/


//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){

	var form = document.querySelector('form');
	var triggerButton = document.querySelector('button');
	// Form is invalid!
	if (!form.checkValidity()) {
		// Create the temporary button, click and remove it
		var tmpSubmit = document.createElement('button')
		form.appendChild(tmpSubmit)
		tmpSubmit.click()
		form.removeChild(tmpSubmit);

	} else {

		if (animating) return false;
		animating = true;
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		//show the next fieldset
		var data = new FormData(form);
		data.append('fieldset', current_fs.attr("id"));

		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),//base_url +'save-basic-details',
			data: data,//$("#"+current_fs.attr("id")).serialize(),
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function () {
			},
			success: function (response) {

				var resp = JSON.parse(response);
				$("input[name='"+_CSRF_NAME_+"']").val(resp.csrf_token);

				if (resp.error) {

					animating = false;
					$.alert(resp.error);
				} else {

					if(current_fs.attr("id")=='114'){
						setTimeout(function(){
							window.location.href = base_url+$("#progressbarmini").attr('data-target');
						}, 250);
					}

					//activate next step on progressbar using the index of next_fs
					$("#progressbarmini li").eq($("fieldset").index(next_fs)).addClass("active");
					next_fs.show();
					//hide the current fieldset with style
					current_fs.animate({opacity: 0}, {
						step: function (now, mx) {
							//as the opacity of current_fs reduces to 0 - stored in "now"
							//1. scale current_fs down to 80%
							scale = 1 - (1 - now) * 0.2;
							//2. bring next_fs from the right(50%)
							left = (now * 50) + "%";
							//3. increase opacity of next_fs to 1 as it moves in
							opacity = 1 - now;
							current_fs.css({
								'transform': 'scale(' + scale + ')',
								//'position': 'absolute'
							});
							next_fs.css({'left': left, 'opacity': opacity});
						},
						duration: 800,
						complete: function () {
							current_fs.hide();
							animating = false;
						},
						//this comes from the custom easing plugin
						easing: 'easeInOutBack'
					});
				}
			},
			error: function () { //$('#loading_modal').modal('hide');
				$.alert("Server busy,try later.");
			},
			complete: function () {
				//alert('4');
			}
		});
	}
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;

	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();

	//de-activate current step on progressbar

	$("#progressbarmini li").eq($("fieldset").index(current_fs)).removeClass("active");

	//show the previous fieldset
	previous_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		},
		duration: 800,
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});


/*autocomp off*/
	$('form ,select, input,textarea,email,number').attr('autocomplete','__away');
$(document).on('keyup', '#pan_code', function () {
	var str=$(this).val();
	//var mask='#';
	//var n =2;
	$("input[name='pan_code']").val('');
	var regex = /[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/;
	
	if(str.length==10){
		//console.log($(this).val());
		//var masked= ('' + str).slice(0, -n)
			//	.replace(/./g, mask)
			//+ ('' + str).slice(-n);
		if(!regex.test($(this).val())){
			$("input[name='pan_code']").val('');
			$('#' + this.id).val('');

			alert("invalid PAN no");

		}else {
				
				var iv = 'a1a2a3a4a5a6a7a8b1b2b3b4b5b6b7b8';
				var key = 'c1c2c3c4c5c6c7c8d1d2d3d4d5d6d7d8c1c2c3c4c5c6c7c8d1d2d3d4d5d6d7d8'; 
				var keyBytes = CryptoJS.enc.Hex.parse(key);
				var ivBytes = CryptoJS.enc.Hex.parse(iv);
				var pancard = CryptoJS.AES.encrypt(str, keyBytes, {
					iv: ivBytes,
					padding: CryptoJS.pad.ZeroPadding
				}).ciphertext.toString(CryptoJS.enc.Base64);
			$("input[name='pan_code']").val(pancard);
			//$('#' + this.id).val(masked);
		}
	}
});