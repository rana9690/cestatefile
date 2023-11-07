<?php
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepscaveat");
$salt=$this->session->userdata('cavsalt');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$token= $this->efiling_model->getToken();
if($salt==''){  $salt='';}
$cname='';
$caveatee_address='';
$caveatee_pin='';
$caveatee_mobile='';
$caveatee_phone='';
$caveatee_district='';
$districtname='';
$caveatee_state='';
$partyTypecaveatee='';
$caveatee_name='';
$caveatee_email='';
if($salt!=''){
    $cavd= $this->efiling_model->data_list_where('temp_caveat','salt',$salt);
    if(@$cavd[0]->caveatee_name!=''){
        $caveatee_address=$cavd[0]->caveatee_address;
        $caveatee_pin=$cavd[0]->caveatee_pin;
        $caveatee_mobile=$cavd[0]->caveatee_mobile;
        $caveatee_phone=$cavd[0]->caveatee_phone;
        $caveatee_district=$cavd[0]->caveatee_district;
        $districtname=$this->efiling_model->getColumn('master_psdist','district_name','district_code',$caveatee_district);
        $caveatee_state=$cavd[0]->caveatee_state;
        $partyTypecaveatee=$cavd[0]->partyTypecaveatee;
        $caveatee_name=isset($cavd[0]->caveatee_name)?$cavd[0]->caveatee_name:0;
        if($caveatee_name!='' && is_numeric($caveatee_name)){
            $cname=$this->efiling_model->getColumn('master_org','org_name','org_id',$caveatee_name);
            $caveatee_email=$cavd[0]->caveatee_email;
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
<?php  echo form_fieldset('<small class="fa fa-user text-danger"></small>&nbsp;&nbsp;Caveatee Details'); ?>

<input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
<input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
<input type="hidden" name="tabno" id="tabno" value="3">
	    
<div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px;  max-width: 100%;">
    <div class="col-md-4"> <label class="text-danger">Select Mode</label> </div>
    <div class="col-md-6 md-offset-2">
        <label for="org" class="form-check-label font-weight-semibold">
            <input type="radio" name="org1" value="1" checked="checked" id="bd1" onclick="orgshow1();"> Organization&nbsp;&nbsp;
        </label>
        <label for="indv" class="form-check-label font-weight-semibold">
            <input type="radio" name="org1" value="2" id="po1" onclick="orgshow1();">Individual&nbsp;&nbsp;
        </label>
        <label for="inp" class="form-check-label font-weight-semibold"> </label>
    </div>
</div>

<?php $cavsalt=$this->session->userdata('cavsalt'); 
//  $this->session->unset_userdata('cavsalt');
?>
<input type="hidden" id="saltVal" name="saltVal" value="">
<div class="row">

    <div class="col-md-4">
        <label for="council_email"><mall class="fa fa-envelope">&nbsp;&nbsp;<font color="red">*</font>Select Organization</mall></label>
          <input type="hidden" name="caveateeid" value="" id="caveateeid" class="txt">
          <input type="text" name="select_org_app" value="<?php echo $cname; ?>" id=select_org_app  class="form-control" onkeypress="serchrecordvalapp(this.value);">
		  <ul class="autosuggest" id="regnum_autofill">      		
		  </ul>
    </div>

     <div class="col-md-4">
        <label for="name"><span class="custom"><font color="red">*</font>State :</span></label>
        <select name="dstate1" class="form-control" id="dstate1" onchange="showCity(this.value);">
           <option selected="selected">Select State Name</option>
           <?php   $hscquery = $this->efiling_model->data_list('master_psstatus');
           foreach ($hscquery as $row) {
            ?>
            <option value="<?php echo htmlspecialchars($row->state_code); ?>"><?php echo htmlspecialchars($row->state_name); ?></option>
            <?php } ?>
        </select>
    </div>   
    
      <div class="col-md-4">
        <label for="name"><span class="custom"><font color="red">*</font>District</span></label>
        <select name="ddistrict1" class="form-control" id="ddistrict1">
            <option selected="selected">Select District Name</option>
        </select>
    </div>  
    
</div>
<div class="row">
    <div class="col-md-4">
        <label for="name"><span class="custom"><font color="red">*</font>Address :</span></label>
        <textarea name="addresscav" id="addresscav" class="form-control" cols="25"><?php echo $caveatee_address; ?></textarea>
    </div>
    <div class="col-md-4">
        <label for="name">Pin No:</label>
        <input type="text" class="form-control" name="pincav" id="pincav" value="<?php echo $caveatee_pin; ?>" maxlength="6" onkeypress="return isNumberKey(event)">
    </div>
    <div class="col-md-4">
        <label for="name"><span class="custom"><font color="red">*</font>Mobile No:</label>
        <input type="text" class="form-control" placeholder="Mobile" name="mobcav" maxlength="10" id="mobcav" value="<?php echo $caveatee_mobile; ?>" onkeypress="return isNumberKey(event)">
    </div>
 </div>

<div class="row">

    
    <div class="col-md-4">
        <label for="name">Phone No:</span></label>
        <input type="text" class="form-control" maxlength="10" name="phonecav" id="phonecav" value="<?php echo $caveatee_phone; ?>" onkeypress="return isNumberKey(event)">
    </div>
    
    <div class="col-md-4">
        <label for="name"><font color="red">*</font>Email Id:</label>
        <input type="text" class="form-control" name="emailcav" id="emailcav" value="<?php echo $caveatee_email; ?>">
    </div>
</div>
<div class="row">
	<div class="offset-md-8 col-md-4">
    <input  type="button" value="Save and Next" class="btn btn-success" onclick="caveateesave();">
    &nbsp;&nbsp;<input type="reset" value="Reset/Clear" class="btn btn-danger">
   </div>
<?php echo form_fieldset_close(); ?>
</div>
<?php $this->load->view("admin/footer"); ?>
<script>
function caveateesave(){
     var idorg='';
	 var checkboxes = document.getElementsByName('org1');
     for (var i = 0; i < checkboxes.length; i++) {
         if (checkboxes[i].checked) {
             idorg = checkboxes[i].value;
         }
    }
    var caveatorid = document.getElementById('caveateeid').value;  
    var select_org_res = document.getElementById('select_org_app').value; 
    var addressTparty= document.getElementById('addresscav').value;    
    var dstate = document.getElementById('dstate1').value;
    var district = document.getElementById('ddistrict1').value;   
    var pin = document.getElementById('pincav').value;  
    var email = document.getElementById('emailcav').value;  
    var phone = document.getElementById('phonecav').value;  
    var mob = document.getElementById('mobcav').value;  
    var tabno= document.getElementById('tabno').value;      

    if(email == "") {
        alert("Please Enter email");
        document.filing.emailcav.focus();
        return false
    }
    if(addressTparty == "") {
        alert("Please Enter address");
        document.filing.addresscav.focus();
        return false
    }
     if(select_org_res == "") {
        alert("Please Enter Caveator name");
        document.filing.select_org_app.focus();
        return false
    }
    if(dstate == "") {
        alert("Please Enter State");
        document.filing.dstate1.focus();
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
    dataa['partyType']=idorg; 
    dataa['type']='caveate';   
    dataa['tab_no']=tabno; 
    dataa['caveatorid']=caveatorid;   
    dataa['token'] = '<?php echo $token; ?>';
     $.ajax({
         type: "POST",
         url: base_url+"caveateesave",
         data: dataa,
         cache: false,
         success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
		      setTimeout(function(){
                    window.location.href = base_url+'cav_advocate';
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


function showUserApp(str) {
    if (str == "") {
        $("#Namecav").val('');
        $("#addresscav").val('');
        $("#mobcav").val('');
        $("#emailcav").val('');
        $("#phonecav").val('');
        $("#pincav").val('');
        $("#dstate").val('');
        $("#ddistrict").val('');
    }
    var dataa = {};
	dataa['q'] = str;
    $.ajax({
        type: "POST",
        url: base_url+'org',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
             console.log(data1);
             var data2 = JSON.parse(data1);
             if (str != 0) {
                 showCity(data2[0].stcode, data2[0].dcode);
                 $("#select_org_app").val(data2[0].org_name);
                 $("#caveateeid").val(data2[0].orgid);
                 $("#addresscav").val(data2[0].address);
                 $("#mobcav").val(data2[0].mob);
                 $("#emailcav").val(data2[0].mail);
                 $("#phonecav").val(data2[0].ph);
                 $("#pincav").val(data2[0].pin);
                   $('select[name=dstate1] > option').each(function(){
     				if($(this).val()==$.trim(data2[0].stcode)) {
     						$(this).attr('selected',true);
     				}
     				else 	$(this).attr('selected',false);
     			});
                 $('select[name=ddistrict1]').empty().removeAttr('disabled',false).append('<option value="'+data2[0].dcode+'">'+data2[0].dname+'"<option>');
             }
        },
		complete: function(){
			$('#regnum_autofill').hide();
			//$('#loading_modal').modal('hide');
		},
		error: function(){
			$.alert('Error : server busy, try later');
		},
    });
}
function showCity(state_id, city_id) {
	var dataa = {};
	dataa['state_id'] = state_id;
    $.ajax({
    	 type: "POST",
    	url: base_url+'district',
        data: dataa,
        cache: false,
        success: function (districtdata) {
            $("#ddistrict1").html(districtdata);
            $("#ddistrict1").val(city_id);
        }
    });
}
</script>
	