<?php
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepscaveat");
$salt=$this->session->userdata('cavsalt');
$this->session->unset_userdata('cavedetail');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$token= $this->efiling_model->getToken();
if($salt==''){
    $salt='';
}
$filing_no='';
if($salt!=''){
    $basicia= $this->efiling_model->data_list_where('temp_caveat','salt',$salt);
}

?>
<div id="rightbar"> 
	<form action="#" id="frmCounsel" autocomplete="off">    
        <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
	    <input type="hidden" name="filing_no" id="filing_no" value="<?php echo $filing_no; ?>">
	    <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
	    <input type="hidden" name="tabno" id="tabno" value="3">
	    <input type="hidden" name="subtype" id="subtype" value="caveate">

        <?= form_fieldset('Commission/Regulators order details').
            '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'.
            '<div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
            ?>
             <input type="hidden" name="saltNo" id="saltNo" value="">
            <div class="row" id="filing">
                <div class="col-md-4">
                    <div class="form-group required">
                    <?php 
                       echo form_label('Commission <sup class="fa fa-star text-danger"></sup>','commission');
                        $rs=$this->admin_model->_get_data('master_commission');
                        $comm_data_array=[''=>'Choose Commission'];
                        foreach ($rs as $comm_row) $comm_data_array[$comm_row->id]=$comm_row->full_name;
                        echo form_dropdown('commission',$comm_data_array,'',['id'=>'commission','class'=>'form-control','required'=>'true']);
                    ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group required">
                    <?php 
                       echo form_label('Case Type <sup class="fa fa-star text-danger"></sup>','nature_of_order');
                        $rs=$this->admin_model->_get_data('master_case_type');
                        $data_array=[''=>'Choose Case Type'];
                        foreach ($rs as $comm_row) $data_array[$comm_row->case_type_code]=$comm_row->short_name;
                        echo form_dropdown('case_type',$data_array,'',['id'=>'case_type','class'=>'form-control','required'=>'true']);
                    ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <?=     form_label('Petition Number <sup class="fa fa-star text-danger"></sup>','case_no').
                            form_input(['name'=>'case_no','id'=>'case_no','class'=>'form-control alert-danger','placeholder'=>'Case Number (numeric only)','onkeypress'=>'return isNumberKey(event)','required'=>'true','title'=>'Case number must be numeric only','pattern'=>'[0-9]{1,12}']);
                    ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group required">                                    
                    <?php   echo form_label('Petition Year <sup class="fa fa-star text-danger"></sup>','case_year');
                         $data_array=[''=>'Choose Case Year'];
                         $curryear=date('Y');
                         for ($i = $curryear; $i > 2000 ; $i--) 
                             $data_array[$i]=$i;
                         echo form_dropdown('case_year',$data_array,'',['id'=>'case_year','class'=>'form-control','required'=>'true']);
                    ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group required">
                    <?= form_label('Date of Impugned Order  <sup class="fa fa-star text-danger"></sup>','decision_date').
                        form_input(['name'=>'decision_date','id'=>'decision_date','class'=>'form-control alert-danger datepicker','value'=>'','readonly'=>'true', 'onClick'=>"get_date(this);",'style'=>'max-width: 160px;','required'=>'true']).'<span class="fa fa-calendar-alt text-danger" style="position: absolute; top:0; margin: 38px 136px; font-size: 20px; opacity: 0.4;"></a>'; 
                    ?>
                    </div>
                </div>

            </div>	
             <div class="row">
                <div class="offset-md-8 col-md-4">
                    <input type="button" value="Save and Next" class="btn btn-success" onclick="caveatebasicsubmit();">
    				&nbsp;&nbsp;<input type="reset" value="Reset/Clear" class="btn btn-danger">
                </div>
            </div>
		</fieldset> 
 </form>
</div>  

<?php $this->load->view("admin/footer"); ?>
<script>
function caveatebasicsubmit() {
    var commission = document.getElementById('commission').value; 
    var case_type = document.getElementById('case_type').value; 
    var case_no= document.getElementById('case_no').value;    
    var case_year = document.getElementById('case_year').value;
    var decision_date = document.getElementById('decision_date').value;  
    var typec = document.getElementById('subtype').value;  
    if(commission == "") {
        alert("Please Enter Commission");
        document.filing.commission.focus();
        return false
    }
    
    if(case_type == "") {
        alert("Please Enter Case Type");
        document.filing.case_type.focus();
        return false
    }
    
    if(case_no == "") {
        alert("Please Enter case no");
        document.filing.case_no.focus();
        return false
    }
    
     if(decision_date == "") {
        alert("Please Enter decision date");
        document.filing.decision_date.focus();
        return false
    }
    var dataa = {};
    dataa['commission'] = commission;
    dataa['case_type'] = case_type;
    dataa['case_no'] = case_no;
    dataa['case_year']=case_year;
    dataa['decision_date']=decision_date;
    dataa['subtype']=typec;
    dataa['token'] = '<?php echo $token; ?>';
     $.ajax({
         type: "POST",
         url: base_url+"cavdetailsave",
         data: dataa,
         cache: false,
         success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
		      setTimeout(function(){
                    window.location.href = base_url+'cav_adv';
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


</script>