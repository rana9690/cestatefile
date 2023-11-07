$(document).on('click','.remove',function() {
	
        $.ajax({
            url : base_url+$(this).attr("data-target"),
            type : 'POST',data : {"id":+$(this).attr("data-id")},
           // beforeSend: function(){ $("body").addClass("loading");},
            success : function(response) {     },
            //complete: function(){$("body").removeClass("loading");}
        });
        $(this).closest('tr').remove();
    });

function maAction() {
    var filingOn = document.getElementById("filing_no").value;
    var partyType1 = $('input[name=userType]:checked').val();
    var total_feeeee = $('#total_feeee').val();
    var collection_ammount = $('#collection_ammount').val();
    var matter = $('#matter').val();
    var checkboxes1 = document.getElementsByName('additionla_partyy');
    var patyAddId = "";
    var count1 = 0;
    var selected = [];
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
        	patyAddId = patyAddId + checkboxes1[i].value + ',';
            count1++;
        }
    }
    if(partyType1!='3'){ 
        if (patyAddId == null) {
            alert('pleae select Additional Party');
            return false;
        } 
    }   

  
    if(partyType1=='3'){ 
    	var select_org_app = document.getElementById('select_org_app1').value;
    	if(select_org_app==''){
    		alert("Select Organization.");
    		return false;
        }
        var petName = document.getElementById('petName1').value;
        var dstate = document.getElementById('dstate1').value;
        var petmobile = document.getElementById('petmobile1').value;
        var degingnation = document.getElementById('degingnation1').value;
        var ddistrict = document.getElementById('ddistrict1').value;
        var petPhone = document.getElementById('petPhone1').value;
        var petAddress = document.getElementById('petAddress1').value;
        var pincode = document.getElementById('pincode1').value;
        var petEmail	 = document.getElementById('petEmail1').value;
        var petFax = document.getElementById('petFax1').value;
     }
     var paper1 = document.getElementById("paper_master").value;
     var ar1 = paper1.split(" ");
     var paper2 = ar1[0];
     var pid = ar1[1];
     if (paper2 == 'ma') {
        var totalNoAnnexure = document.getElementById("totalNoAnnexure").value;
        if(totalNoAnnexure=='0' || totalNoAnnexure==''){
        	  alert("Please Enter Annexure should greater than zero!");
              document.totalNoAnnexure.focus();
              return false;
        }
     }

     if (paper2 == 'va'){
        var state = document.getElementById("dstate").value;
        var dist = document.getElementById("ddistrict").value;
        var counselAdd = document.getElementById("counselAdd").value;
        var counselPin = document.getElementById("counselPin").value;
        var counselMobile = document.getElementById("counselMobile").value;
        var counselPhone = document.getElementById("counselPhone").value;
        var counselEmail = document.getElementById("counselEmail").value;
        var counselFax = document.getElementById("counselFax").value;
        var councilCode = document.getElementById("councilCode").value;
        if (councilCode == "" || councilCode == 'Select Council Name') {
            alert("Please Select Council Name!");
            document.councilCode.focus();
            return false;
        }
        if (state == "" || state == 'Select State Name') {
            alert("Please Select State!");
            document.dstate.focus();
            return false;
        }
        if (dist == "" || dist == 'Select District Name') {
            alert("Please Select District !");
            document.ddistrict.focus();
            return false;
        }
    }
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }

    if (bd == 3) {
        var ddno = $("#ntrpno").val();
        var amountRs = $("#ntrpamount").val();
        var dddate = $("#ntrpdate").val();
        var dbankname = $("#ntrp").val();
        if (dbankname == "") {
            alert("Please Enter Bank name");
            document.ntrp.focus();
            return false;
        }
        if (ddno == "") {
            alert("Please Enter Challan No/Ref.No");
            document.ntrpno.focus();
            return false
        }
        if (dddate == "") {
            alert("Please Enter Date of Transction");
            document.ntrpdate.focus();
            return false
        }
        if (amountRs == "") {
            alert("Please Enter Amount ");
            document.ntrpamount.focus();
            return false
        }

    var collectamount = $("#collectamount").val();
    if(collectamount==''){
     	var collectamount=0;
    }
    var totalamount = $("#totalamount").val();
    var val= parseInt(collectamount)+parseInt(amountRs);
    if(totalamount > val){
	   alert("Total amount and paid amount should be equal ");
       return false
     }

    }

    var select_org_app = document.getElementsByName('select_org_app').value;
	if(select_org_app==''){
		alert("Select Organization.");
		return false;
    }
    if ( paper2 == 'ma') {
    	var dataa={};
            dataa['matter']=matter, 
            dataa['collection_ammount']=collection_ammount,
            dataa['total_feeeee']=total_feeeee, 
            dataa['filingNo']=filingOn,
            dataa['type']=partyType1,
            dataa['select_org_app']=select_org_app,
            dataa['petName']=petName, 
            dataa['dstate']=dstate,
        	dataa['petmobile']=petmobile,
        	dataa['degingnation']=degingnation,
        	dataa['ddistrict']=ddistrict,
        	dataa['petPhone']=petPhone,
        	dataa['petAddress']=petAddress,
        	dataa['pincode']=pincode,
        	dataa['petEmail']=petEmail,
        	dataa['petFax']=petFax,
        	dataa['addparty']=patyAddId,
        	dataa['totalA']=totalNoAnnexure ,
        	dataa['dbankname']=dbankname,
            dataa['amountRs']=amountRs,
            dataa['ddno']=ddno,
            dataa['dddate']=dddate,
            dataa['bd']=bd,
            dataa['pid']=pid,
            dataa['paper2']=paper2,
        	$.ajax({
        		dataType: 'json',
        		type: 'post',
        		url: base_url+'ma_action',
        		data: dataa,
        		success: function(retrn){		
        			if(retrn.data='success'){
        				$("#document_filing_div_id").empty();
        			    $("#annId").empty();
        			    $("#document_filing_div_id_text_print").html(retrn.display);
        			}
        			if(retrn.data='error'){
        				$("#document_filing_div_id_text_print").html(retrn.error);
        			}
        		},
        		error: function(){
        			$.alert('Server busy, try later.');
        		},
        	});
    }
    if (paper2 == 'va') {
    	var dataa={};
            dataa['matter']=matter ,
        	dataa['collection_ammount']=collection_ammount ,
            dataa['total_feeeee']=total_feeeee,
            dataa['filingNo']=filingOn , 
            dataa['type']=partyType1 ,
            dataa['select_org_app']=select_org_app, 
            dataa['petName']=petName,  
            dataa['dstate']=dstate ,
        	dataa['petmobile']=petmobile, 
        	dataa['degingnation']=degingnation , 
        	dataa['ddistrict']=ddistrict ,
        	dataa['petPhone']=petPhone , 
        	dataa['petAddress']=petAddress , 
        	dataa['pincode']=pincode , 
        	dataa['petEmail']=petEmail , 
        	dataa['petFax']= petFax , 
        	dataa['addparty']=patyAddId,
            dataa['dbankname']= dbankname , 
            dataa['amountRs']= amountRs, 
            dataa['ddno']=ddno ,
            dataa['dddate']= dddate ,
            dataa['bd']= bd ,
            dataa['pid']= pid ,
            dataa['paper2']= paper2, 
            dataa['cadd']= counselAdd, 
            dataa['cpin']=counselPin, 
            dataa['cmob']=counselMobile,
            dataa['cemail']= counselEmail,
            dataa['cfax']=counselFax,
            dataa['counselpho']= counselPhone,
            dataa['st']= state,
            dataa['dist']= dist,
            dataa['councilCode']= councilCode,   
        	$.ajax({
        		dataType: 'json',
        		type: 'post',
        		url: base_url+'ma_action',
        		data: dataa,
        		success: function(retrn){
        			if(retrn.data='success'){
        				$("#document_filing_div_id").empty();
        			    $("#annId").empty();
        			    $("#document_filing_div_id_text_print").html(retrn.display);
        			}
        			if(retrn.data='error'){
        				$("#document_filing_div_id_text_print").html(retrn.error);
        			}
        		},
        		error: function(){
        			$.alert('Server busy, try later.');
        		},
        		complete: function(){
        			  document.getElementById("payMode").style.display = 'block';					
        		}
        	});
    } 

}

/*function deletePayrpepcp(e) {
    var payid = e;
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    var salt = document.getElementById("saltNo").value;
    var totalamount = document.getElementById("totalamount").value;
    var remainamount = document.getElementById("remainamount").value;
    var filing_no = document.getElementById("filing_no").value;
    var dataa={};
    dataa['payid']=payid,
    dataa['salt']=salt,
    dataa['bd']=bd,
    dataa['totalamount']=totalamount,
    dataa['remainamount']=remainamount,
   dataa['filing_no']=filing_no,
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreddrpepcp',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		$('#add_amount_list').html(resp.display);
        		$('#remainamount').val(resp.remain);
        		$('#collectamount').val(resp.paid);
			}else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
		}
	 });
    document.getElementById("addmoreaddpay").style.display = 'block';
    document.getElementById("addmoreadd").style.display = 'none';
}
*/


function addMoreAmountrpepcp(){
	    var salt = document.getElementById("saltNo").value;
	    var radios = document.getElementsByName("bd");
	    var bd = 0;
	    for (var i = 0; i < radios.length; i++) {
	        if (radios[i].checked) {
	            var bd = radios[i].value;
	        }
	    }
	    var totalamount = document.getElementById("totalamount").value;
	    var remainamount = document.getElementById("remainamount").value;
	    var filing_no = document.getElementById("filing_no").value;
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
                   document.ntrpno.focus();
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
	    dataa['totalamount']=totalamount,
	    dataa['salt']=salt,
            dataa['filing_no']=filing_no,
	    $.ajax({
		    dataType: 'json',
	        type: "POST",
	        url: base_url+'addMoreddrpepcp',
	        data: dataa,
	        cache: false,
			beforeSend: function(){
				//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
			},
	        success: function (resp) {
	        	if(resp.data=='success') {
	        		$('#add_amount_list').html(resp.display);
	        		$('#remainamount').val(resp.remain);
	        		$('#collectamount').val(resp.paid);
				}else if(resp.error != '0') {
					$.alert(resp.error);
				}
	        },
	        error: function(){
				$.alert("Surver busy,try later.");
			},
			complete: function(){
			}
		 }); 
	    if (bd == 3) {
	        document.getElementById("ntrpno").value = "";
	        document.getElementById("ntrpdate").value = "";
	        document.getElementById("ntrpamount").value = "";
	    }
     }




function openTextBox(gid) {
    // var checkboxes = document.getElementsByName('natureCode');
    // var iaNature1 = "";
    // for (var i = 0; i < checkboxes.length; i++) {
    //     if (checkboxes[i].checked) {
    //         var iaNature1 = checkboxes[i].value;
    //     }
    // }
    // if (iaNature1 == 12) {
    //     document.getElementById("matterId").style.display = 'block';
    // }
	var tIAs=$('#totalNoIA').val();
	if(tIAs == '') {
		$.alert("Kindly enter total no of IA's first");
		$('#totalNoIA').focus();
		$(gid).prop('checked',false);
		return false;
	}
	
	var i=0;
	$('input[type=checkbox]').each(function () {
		if($(this).is(':checked')) {
			i++;
		}
	});
	if(i > tIAs) {
		$.alert("You cannot check IA's more than total no of IA's.");
		$(gid).prop('checked',false);
		return false;
	}
}


function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function addMoreRes() {
    var salt = document.getElementById("saltNo").value;
    var orgid = document.getElementById("resorgid").value;
    var resName = document.getElementById("resName").value;
    var degingnationRes = document.getElementById("degingnationRes").value;
    var resAddress = document.getElementById("resAddress").value;
    var resState = document.getElementById("stateRes").value;
    var resDis = document.getElementById("ddistrictname").value;

    var respincode = document.getElementById("respincode").value;
    var resMobile = document.getElementById("resMobile").value;
    var resPhone = document.getElementById("resPhone").value;
    var resEmail = document.getElementById("resEmail").value;
    var resFax = document.getElementById("resFax").value;
    var count = document.getElementById("count").value;
    var tabno= document.getElementById("tabno").value;
    var totalNoRespondent = Number(document.getElementById("totalNoRespondent").value);
    if(totalNoRespondent==''){
    	alert("Please Enter total No Respondent");
		$('#totalNoRespondent').focus();
    	return false;
    }
    
    
    if(resMobile.length!='10'){
	    alert("Please enter correct mobile number !");
    	return false;
	}
    
    
    if(count >= totalNoRespondent){
    	alert("Respondent should not greater-than total No. Respondents");
    	return false;
    }
    if(resMobile == ''){
    	$.alert("Respondent mobile no is mandatory/required");
		$("#resMobile").focus();
    	return false;
    }

	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
    if(resEmail == '' || !emailReg.test(resEmail)){
    	alert("kindly enter valid email id.");
		$("#resEmail").focus();
    	return false;
    }  
    if (resName == "") {
        alert("Please Enter Respondent Name!");
        document.filing.resName.focus();
        return false;
    }
    if (resState == "" || resState == 'Select State Name') {
        alert("Please Select State!");
        document.filing.stateRes.focus();
        return false;
    }
    var org='';
    var checkboxes = document.getElementsByName('orgres');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            org = checkboxes[i].value;
        }
    }
    
    if(org=='1'){
		if(orgid==''){
			alert("Please select respondent !");
        	document.filing.orgid.focus();
        	return false;
		}
	}
	    
    var dataa = {};
	dataa['resName']=resName,
	dataa['resAddress']=resAddress,
	dataa['respincode']= respincode,
	dataa['resState']= resState,
	dataa['resDis']=resDis,
	dataa['resMobile']= resMobile,
	dataa['resPhone']= resPhone,
	dataa['resEmail']=resEmail,
	dataa['resFax']= resFax,
	dataa['salt']= salt,
	dataa['totalNoRespondent']= totalNoRespondent,
	dataa['tabno']= tabno,
    dataa['resdeg']= degingnationRes,
    dataa['org']=org;
	dataa['orgid']=orgid;
    /*26/12/2022*/
    //if($('#loc_code').length) { dataa['loc_code']=$("#loc_code").val();}
    //if($('#locc_code').length) { dataa['locc_code']=$("#locc_code").val();}
   // if($('#iec_code').length) {dataa['iec_code']=$("#iec_code").val();}
   // if($('#pre_code').length) {dataa['pre_code']=$("#pre_code").val();}
   // if($('#ass_code').length) {dataa['ass_code']=$("#ass_code").val();}
  
	//if($("input[name='pan_code']").length ) {dataa['pan_code']=$("input[name='pan_code']").val();}
    dataa[_CSRF_NAME_]=$("input[name='"+_CSRF_NAME_+"']").val();
	$.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreRes',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#nextsubmit').prop('enabled',true).val("Under proccess....");
		},
        success: function (resp) {
            $("input[name='"+_CSRF_NAME_+"']").val(resp.csrf_token);
        	if(resp.data=='success') {
        		var val=parseInt(count)+1;
        		$('#addmorerecordapp').html(resp.display);
        		$('#count').val(val);
				$("#resName").val("");
				$("#degingnationRes").val("");
				$("#resAddress").val("");
				$("#stateRes").val("");
				$("#ddistrictres").val("");
				$("#respincode").val("");
				$("#resMobile").val("");
				$("#resPhone").val("");
				$("#resEmail").val("");
				$("#resFax").val("");				
				$.alert({
					title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Success</b>',
					content: '<p class="text-success">Respondent&#39;s added successfully.</p>',
					animationSpeed: 2000
				}); 
			}
			else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
			$('#nextsubmit').prop('enabled',false).val("Add More Respondent");
		}
	 }); 
}   


   
   
function underSection(sel) {
    var act_id = sel.options[sel.selectedIndex].value;
    var case_typed = $("#caseType").val();
    act_iddd = act_id;
    casyy_type = case_typed;
    var dataa = {};
    dataa['state_id'] = act_id;
    dataa['case_typed'] = case_typed;
    if (act_id.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url+'undersection',
            data: dataa,
            cache: false,
            success: function (petSection) {
                $("#petSection").html(petSection);
              //  $("#petSection").val("")
                if (casyy_type == '1' && act_iddd == '1') {
                    $("#petSection").val("1");
                } else if (casyy_type == '1' && act_iddd == '3') {
                    $("#petSection").val("5");
                } else if (casyy_type == '1' && act_iddd == '2') {
                    $("#petSection").val("3");
                } else if ((casyy_type == '2' || casyy_type == '4') && act_iddd == '1') {
                    $("#petSection").val("2");
                } else if ((casyy_type == '2' || casyy_type == '4') && act_iddd == '3') {
                    $("#petSection").val("6");
                } else if ((casyy_type == '2' || casyy_type == '4') && act_iddd == '2') {
                    $("#petSection").val("4");
                }

            }
        });
    }
}



	function addMore() {

		var commission='', natureOrder='', case_type_lower='', caseNo='',ddate='';
		commission=$('#commission option:selected').val();
		natureOrder=$('#natureOrder option:selected').val();
		case_type_lower=$('#case_type_lower option:selected').val();
		caseNo=$('#caseNo').val();
		ddate=$('#ddate').val();
	  	var salt = Number(document.getElementById("saltNo").value);
	  	const cnt1 = Number(document.getElementById("cnt").value) + Number('1');
	  	var totalNoImpugned = document.getElementById("totalNoImpugned").value; 
	  	if(totalNoImpugned=='' || totalNoImpugned==0){
	    	alert("Please Enter Impugned");
			$('#totalNoImpugned').focus();
	    	return false;
	   }
	   if(commission=='' || natureOrder=='' || case_type_lower=='' || caseNo=='' || ddate==''){
		   $.alert("Kindly provide all mandatory(*) details!");
		   return false;
	   }
	   var commission = document.getElementById("commission").value;
	   var natureOrder = document.getElementById("natureOrder").value;
	   var case_type_lower = document.getElementById("case_type_lower").value;
	   var caseNo =document.getElementById("caseNo").value;
	   var caseYear = document.getElementById("caseYear").value;
	   var ddate = document.getElementById("ddate").value;
	   var comDate = document.getElementById("comDate").value;
	   var val=totalNoImpugned;

	   if(cnt1 > val || val==0){
	    	alert("Commission should not greater-than Impugned");
	    	return false;
	   }
	    var dataa = {};
	    dataa['cnt'] = cnt1;
	    dataa['salt'] = salt;
	    dataa['commission'] = commission;
        dataa['natureOrder']=natureOrder;
        dataa['case_type_lower']=case_type_lower;
        dataa['caseNo']=caseNo;
        dataa['caseYear']=caseYear;
        dataa['ddate']=ddate;
        dataa['comDate']=comDate;
        dataa[_CSRF_NAME_] = $("input[name='"+_CSRF_NAME_+"']").val();
	    $.ajax({
	        type: "POST",
	        url: base_url+'addmorecommition',
	        data: dataa,
	        cache: false,
			dataType: 'json',
	        success: function (jsonData) {
				petSection=jsonData.data;
				rows=jsonData.rows;
                $("input[name='"+_CSRF_NAME_+"']").val(jsonData.csrf_token);
				
	            $("#product").html(petSection);
				document.getElementById("commission").value="";
				document.getElementById("natureOrder").value="";
				document.getElementById("case_type_lower").value="";
				document.getElementById("caseNo").value="";
				document.getElementById("ddate").value="";
				document.getElementById("comDate").value="";
				document.getElementById("caseYear").value="";
				$.alert("Impugned order detail Saved.");
				$('#nextsubmit').removeAttr('disabled');
				document.getElementById("cnt").value = rows;				
			//	document.getElementById("totalNoImpugned").value = Number(rows);				
				//document.getElementById("totalNoImpugned").value = Number(rows);
	        }
	    });
	}





	function addMoreApp() {
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
            var salt = document.getElementById("saltNo").value;
            var orgid = document.getElementById("orgid").value;
            var petName = document.getElementById("petName").value;
            var degingnation = document.getElementById("degingnation").value;
            var petAddress = document.getElementById("petAddress").value;
            var dstate = document.getElementById("dstate").value;
            var ddistrict = document.getElementById("ddistrict").value;
            var pincode = document.getElementById("pincode").value;
            var petmobile = document.getElementById("petmobile").value;
            var petPhone = document.getElementById("petPhone").value;
            var petEmail = document.getElementById("petEmail").value;
            var petFax = document.getElementById("petFax").value;

            var counselAdd = '';
            var counselPin = '';
            var counselMobile = '';
            var counselPhone = '';
            var counselEmail = '';
            var counselFax = '';
            var councilCode = '';

            if (petmobile.length != '10') {
                alert("Please enter correct mobile number !");
                return false;
            }

            var count = document.getElementById("count").value;
            var totalNoAppellants = Number(document.getElementById("totalNoAppellants").value);
            if (totalNoAppellants == '') {
                alert("Please Enter total No Appellants");
                return false;
            }
            var val = totalNoAppellants;
            if (count >= val) {
                alert("Applicant should not greater-than total No. of Applicants");
                return false;
            }

            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if (petEmail == "" || !emailReg.test(petEmail)) {
                alert("Please enter valid  email!");
                $('#petEmail').focus();
                return false;
            }


            if (petName == "") {
                alert("Please Enter Department / Appellant Name ");
                document.filing.petName.focus();
                return false;
            }
            if (petmobile == '') {
                alert("Appellants Mobile No is required");
                $('#petmobile').focus();
                return false;
            }
            if (dstate == "" || dstate == 'Select State Name') {
                alert("Please Select State!");
                document.filing.dstate.focus();
                return false;
            }
            if (ddistrict == "" || ddistrict == 'Select District Name') {
                alert("Please Select District !");
                document.filing.ddistrict.focus();
                return false;
            }


            var tabno = document.getElementById("tabno").value;
            var totalNoAppellants = Number(document.getElementById("totalNoAppellants").value);
            var org = '';
            var checkboxes = document.getElementsByName('org');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    org = checkboxes[i].value;
                }
            }


            if (org == '1') {
                if (orgid == '') {
                    alert("Please select Appllant !");
                    document.filing.orgid.focus();
                    return false;
                }
            }
            var dataa = {};
            dataa['patname'] = petName,
                dataa['petAdv'] = petAddress,
                dataa['pin'] = pincode,
                dataa['petMob'] = petmobile,
                dataa['petph'] = petPhone,
                dataa['petemail'] = petEmail,
                dataa['petfax'] = petFax,
                dataa['cadd'] = counselAdd,
                dataa['cpin'] = counselPin,
                dataa['cmob'] = counselMobile,
                dataa['cemail'] = counselEmail,
                dataa['cfax'] = counselFax,
                dataa['salt'] = salt,
                dataa['petdeg'] = degingnation,
                dataa['counselpho'] = counselPhone,
                dataa['dstate'] = dstate,
                dataa['ddistrict'] = ddistrict,
                dataa['councilCode'] = councilCode,
                dataa['totalNoAppellants'] = totalNoAppellants;
            dataa['tabno'] = tabno;
            dataa['org'] = org;
            dataa['orgid'] = orgid;
            dataa[_CSRF_NAME_] = $("input[name='" + _CSRF_NAME_ + "']").val();
            /*26/12/2022*/
            // if($('#loc_code').length) { dataa['loc_code']=$("#loc_code").val();}
            // if($('#locc_code').length) { dataa['locc_code']=$("#locc_code").val();}
            //if($('#iec_code').length) {dataa['iec_code']=$("#iec_code").val();}
            // if($('#pre_code').length) {dataa['pre_code']=$("#pre_code").val();}
            // if($('#ass_code').length) {dataa['ass_code']=$("#ass_code").val();}
            // if($("input[name='pan_code']").length ) {dataa['pan_code']=$("input[name='pan_code']").val();}


            $.ajax({
                dataType: 'json',
                type: "POST",
                url: base_url + 'addMoreAppellant',
                data: dataa,
                cache: false,
                beforeSend: function () {
                    $('#nextsubmit').prop('enabled', true).val("Under proccess....");
                },
                success: function (resp) {
                    $("input[name='" + _CSRF_NAME_ + "']").val(resp.csrf_token);
                    if (resp.data == 'success') {
                        var val = Number(count) + 1;
                        $('#addmorerecordapp').html(resp.display);
                        $('#count').val(val);
                        document.getElementById("petName").value = "";
                        document.getElementById("degingnation").value = "";
                        document.getElementById("petAddress").value = "";
                        document.getElementById("dstate").value = "Select State Name";
                        document.getElementById("ddistrict").value = "Select District Name";
                        document.getElementById("pincode").value = "";
                        document.getElementById("petmobile").value = "";
                        document.getElementById("petPhone").value = "";
                        document.getElementById("petEmail").value = "";
                        document.getElementById("petFax").value = "";
                        $.alert({
                            title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Success</b>',
                            content: '<p class="text-success">Appellant&#39;s added successfully.</p>',
                            animationSpeed: 2000
                        });
                        $('.btnSave').removeAttr('disabled');
                    }
                    else if (resp.error != '0') {
                        $.alert(resp.error);
                    }
                },
                error: function () {
                    $.alert("Server busy,try later.");
                },
                complete: function () {
                    $('#nextsubmit').prop('enabled', false).val("Add More Appellant");
                }
            });
        }
	}

	


	





