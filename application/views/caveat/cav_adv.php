<?php
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepscaveat");
$salt=$this->session->userdata('cavsalt');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$token= $this->efiling_model->getToken();
if($salt==''){ $salt=''; }
$caveat_address='';
$caveat_pin='';
$caveat_phone='';
$caveat_mobile='';
$caveat_phone='';
$prayer='';
$caveat_district='';
$caveat_state='';
$caveat_name='';
$caveat_email='';
$statename='';
$districtname='';
$statename='';

$cname='';
if($salt!=''){
   $cavd= $this->efiling_model->data_list_where('temp_caveat','salt',$salt);
   if(!empty($cavd) && is_array($cavd)){
       $caveat_address=$cavd[0]->caveat_address;
       $caveat_pin=$cavd[0]->caveat_pin;
       $caveat_phone=$cavd[0]->caveat_phone;
       $caveat_mobile=$cavd[0]->caveat_mobile;
       $caveat_phone=$cavd[0]->caveat_phone;
       $prayer=$cavd[0]->prayer;
       $caveat_district=isset($cavd[0]->caveat_district)?$cavd[0]->caveat_district:165;
       if($caveat_district!=''){
           $districtname=$this->efiling_model->getColumn('master_psdist','district_name','district_code',$caveat_district);
       }
       $caveat_name=$cavd[0]->caveat_name;
       if($caveat_name!='' && is_numeric($caveat_name)){
           $cname=$this->efiling_model->getColumn('master_org','org_name','org_id',$caveat_name);
           $caveat_email=$cavd[0]->caveat_email;
       }
   }
}


?>
 <style>
.autosuggest {
    list-style: none;
    margin: 0;
    padding: 0;
    position: absolute;
    left: 15px;
    top: 65px;
    z-index: 1;
    background: #fff;
    width: 94%;
    box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    max-height: 280px;
}
.autosuggest li {
    padding: 8px 10px;
    font-size: 13px;
    color: #26c0d9;
    cursor: pointer;
}
.autosuggest li:hover {
    background: #f5f5f5;
}

</style>
<div id="filing">
 <?php
echo form_fieldset('<small class="fa fa-user text-danger"></small>&nbsp;&nbsp;Caveator Details').'
        <input type="hidden" name="token" value="'.$token.'" id="token">
	    <input type="hidden" name="saltNo" id="saltNo" value="'.$salt.'">
	    <input type="hidden" name="tabno" id="tabno" value="2">

         <div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px;  max-width: 100%;">
                <div class="col-md-4"> <label class="text-danger">Select Mode</label> </div>
                <div class="col-md-6 md-offset-2">
                    <label for="org" class="form-check-label font-weight-semibold">
                        <input type="radio" name="org" value="1" checked="checked" id="bd1" onclick="orgshow();"> Organization&nbsp;&nbsp;
                    </label>
                    <label for="indv" class="form-check-label font-weight-semibold">
                        <input type="radio" name="org" value="2" id="po1" onclick="orgshow();">Individual&nbsp;&nbsp;
                    </label>
                    <label for="inp" class="form-check-label font-weight-semibold"> </label>
                </div>
         </div>
        <div class="row form-group">

         <div class="col-md-4" id="org">
            <label>Organization<span class="text-danger">*</span></label>
             <input type="hidden" name="caveatorid" value="" id="caveatorid" class="txt">
            <input type="text" name="select_org_res" value="'.$cname.'" id=select_org_res  class="form-control" onkeypress="serchrecordvalapp(this.value);">
    		<ul class="autosuggest" id="regnum_autofill">      		
    		</ul>
        </div>


         <div class="col-md-4" id="ind" style="display:none">'.
             form_label('Select Organization <sup class="fa fa-star text-danger"></sup>','organization');
             $rs=$this->admin_model->_get_data('master_org');
             $data_array=[''=>'Select Organization'];
             foreach ($rs as $org_row) $data_array[$org_row->org_id]=$org_row->orgdisp_name;
             echo form_input(['name'=>'select_org_res','id'=>'select_org_res','class'=>'form-control','required'=>'true']).
         '</div>
           <div class="col-md-4">'.
            form_label('<small class="fa fa-mobile"></small>&nbsp;&nbspMobile No<sup class="fa fa-star text-danger"></sup>','caveat_mobile').
            form_input(['name'=>'mob','id'=>'mob','class'=>'form-control','value'=>$caveat_mobile,'title'=>'Allowed 10 digit numeric only','pattern'=>'[0-9]{0,10}','maxlength'=>'10','placeholder'=>'Mobile No.']).
          '</div>
          <div class="col-md-4">'.
            form_label('<small class="fa fa-location-arrow"></small>&nbsp;&nbsp;Address <sup class="fa fa-star text-danger"></sup>','caveat_address').
            form_textarea(['name'=>'addressTparty','id'=>'addressTparty','rows'=>'2','cols'=>'10','value'=>$caveat_address,'class'=>'form-control','required'=>'true','placeholder'=>'Enter address','pattern'=>'[-\/&_.A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'Allowed alpha numeric (./&,-_) only']).
          '</div>'.

     '</div>'.

     '<div class="row form-group">                               
         <div class="col-md-4">'.
             form_label('Select State <sup class="fa fa-star text-danger"></sup>','caveat_state');
             $rs=$this->admin_model->_get_data('master_psstatus');
             $data_array=[''=>'Select State'];
             foreach ($rs as $state_row) $data_array[$state_row->state_code]=$state_row->state_name;
             echo form_dropdown('dstate',$data_array,$caveat_state,['class'=>'form-control','id'=>'dstate','required'=>'true','onchange'=>'get_district(this)']).
         '</div>
         <div class="col-md-4">'.
            form_label('Select District <sup class="fa fa-star text-danger"></sup>','caveat_district').
            form_dropdown('ddistrict',[''=>'Kindly select state first'],'',['class'=>'form-control','id'=>'ddistrict','required'=>'true','disabled'=>'true','id'=>'district']).
          '</div>
          <div class="col-md-4">'.
            form_label('Pincode','caveat_pin').
            form_input(['name'=>'pin','id'=>'pin','class'=>'form-control','pattern'=>'[0-9]{6,6}','value'=>$caveat_pin,'maxlength'=>'6','placeholder'=>'Pincode']).
          '</div>'.

     '</div>'.

     '<div class="row form-group">
     
         <div class="col-md-4">'.
             form_label('<small class="fa fa-envelope"></small>&nbsp;&nbspEmail Id<sup class="fa fa-star text-danger"></sup>','caveat_email').
             form_input(['name'=>'email','id'=>'email','type'=>'email','class'=>'form-control','value'=>$caveat_email,'placeholder'=>'Email Id']).
         '</div>
          <div class="col-md-4">'.
            form_label('<small class="fa fa-phone"></small>&nbsp;&nbspPhone No','caveat_phone').
            form_input(['name'=>'phone','id'=>'phone','class'=>'form-control','placeholder'=>'Phone No.','value'=>$caveat_phone,'pattern'=>'[0-9 ]{0,20}','maxlength'=>'10','title'=>'Allowed number and space only']).
          '</div>'.

     '</div>'.

     '<div class="row form-group">'.

          '<div class="col-md-12">'.
            form_label('<small class="fa fa-user"></small>&nbsp;&nbspPrayer','prayer').
            form_input(['name'=>'Prayer','id'=>'Prayer','class'=>'form-control','title'=>'Enter valid prayer','value'=>$prayer,'pattern'=>'[-\/_.A-Za-z0-9 ]{0,200}','maxlength'=>'200','placeholder'=>'Enter prayer']).
          '</div>'.

     '</div>
            <div class="row">
            <div class="offset-md-8 col-md-4">
            <input  type="button" value="Save and Next" class="btn btn-success" onclick="caveatorsave();">
            &nbsp;&nbsp;<input type="reset" value="Reset/Clear" class="btn btn-danger">
            </div>
            </div>';
echo form_fieldset_close(); 

?>
</div>
<?php $this->load->view("admin/footer"); ?>
<script>
function caveatorsave(){
     var idorg='';
	 var checkboxes = document.getElementsByName('org');
     for (var i = 0; i < checkboxes.length; i++) {
         if (checkboxes[i].checked) {
             idorg = checkboxes[i].value;
         }
    }
    var caveatorid = document.getElementById('caveatorid').value;  
    var select_org_res = document.getElementById('select_org_res').value; 
    var addressTparty= document.getElementById('addressTparty').value;    
    var dstate = document.getElementById('dstate').value;
    var district = document.getElementById('district').value;   
    var pin = document.getElementById('pin').value;  
    var email = document.getElementById('email').value;  
    var phone = document.getElementById('phone').value;  
    var mob = document.getElementById('mob').value;  
    var Prayer = document.getElementById('Prayer').value;   
    var tabno= document.getElementById('tabno').value;      
 
    if(email == "") {
        alert("Please Enter email");
        document.filing.email.focus();
        return false
    }
 
    if(addressTparty == "") {
        alert("Please Enter address");
        document.filing.addressTparty.focus();
        return false
    }
    
     if(select_org_res == "") {
        alert("Please Enter Caveator name");
        document.filing.select_org_res.focus();
        return false
    }

    if(dstate == "") {
        alert("Please Enter State");
        document.filing.dstate.focus();
        return false
    }
    var dataa = {};
    dataa['select_org_res'] = select_org_res;
    dataa['addressTparty'] = addressTparty;
    dataa['dstate']=dstate;
    dataa['district']=district;
    dataa['pin']=pin;
    dataa['email']=email;
    dataa['phone']=phone;
    dataa['mob']=mob;
    dataa['Prayer']=Prayer;  
    dataa['partyType']=idorg; 
    dataa['type']='caveate';   
    dataa['tab_no']=tabno; 
    dataa['caveatorid']=caveatorid;   
    dataa['token'] = '<?php echo $token; ?>';
     $.ajax({
         type: "POST",
         url: base_url+"caveatorsave",
         data: dataa,
         cache: false,
         success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
		      setTimeout(function(){
                    window.location.href = base_url+'cav_applent';
               }, 250);  
			}
			else if(resp.error != '0') {
				$.alert(resp.massage);
			}
         },
         error: function (request, error) {
			$('#loading_modal').fadeOut(200);
         }
     }); 
}



function serchrecordvalapp(val){
	$.ajax({
		type: 'post',
		url: base_url+'getApplantName',
		data: {key:val},
		dataType: 'html',
		cache: false,
		beforeSend: function(){
		 	//$('#loading_modal').modal();
		},
		success: function(retn){
		    $('#regnum_autofill').show();
			$('#regnum_autofill').html(retn);
		 	
		},
		error: function(){
			$.alert('Error : server busy, try later');
		},
		complete: function(){
			document.getElementById("loading_modal").style.display = 'none';
			$('#loading_modal').modal('hide');
		}
	});	
}


function showUserApp(id) {
	$.ajax({
		type: 'post',
		url: base_url+'getOrgfurther',
		data: {'org_id': id},
		dataType: 'json',
		cache: false,
		success: function(retrn){
			$('textarea[name=addressTparty]').val(retrn[0].org_address);
			$('select[name=dstate] > option').each(function(){
				if($(this).val()==$.trim(retrn[0].state)) {
						$(this).attr('selected',true);
				}
				else 	$(this).attr('selected',false);
			});
			var mobile_no=retrn[0].mobile_no;
			if(retrn[0].mobile_no=='0'){
				var mobile_no='';
			}
			$('input[name=caveatname]').val(retrn[0].orgdisp_name);
            $('select[name=ddistrict]').empty().removeAttr('disabled',false).append('<option value="'+retrn[0].district+'">'+retrn[0].district_name+'"<option>');
			$('input[name=pin]').val(retrn[0].pin);
			$('input[name=email]').val(retrn[0].email);
			$('input[name=mob]').val(mobile_no);
			$('input[name=select_org_res]').val(retrn[0].orgdisp_name);
			$('input[name=caveatorid]').val(retrn[0].org_id);
			
		},
		error: function(){
			$.alert('Server busy, try later');
		},
		complete: function(){
			$('#regnum_autofill').hide();
			//$('#loading_modal').modal('hide');
		}
	});
}

</script>
	