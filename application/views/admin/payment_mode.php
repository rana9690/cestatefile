<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script> 
<style>
.srchWrap {
    margin-left: 194px;
    position: relative;
    float: right;
    width: 100%;
    margin-right: 10px;
}
.srchWrap input {
    padding-left: 35px;
    font-size: 16px;
}
.srchWrap input:focus {
    border: 1px solid #2196f3 !important;
}
.srchWrap i {
    position: absolute;
    left: 12px;
    top: 14px;
}
</style>
<div id="rightbar"> 
<?php  include 'steps.php';?>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(); ?>
<div class="content" style="padding:0px;">
<script>
 paymentMode();
</script>
	<div class="row">
		<div class="card checklistSec" style="">
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'payment_mode','autocomplete'=>'off']) ?>
                <div class="content clearfix">
                    <?= form_fieldset('Fee Details <div class="date-div text-success">'.$this->lang->line('referenceno').' :'.$salt.'</div>').
                        '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>'
                        ;
                        ?>
                     <input type="hidden"  id="tabno" name="tabno" value="<?php echo '8'; ?>">
                     <?php $salt=$this->session->userdata('salt'); ?>
					 <input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
					    <?php 
                        $token=rand(1000,9999);
                        $md_db = hash('sha256',$token);
                        $token1=$md_db;
                        $this->session->set_userdata('tokenno',$token1);
                        
                        $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
                        
                        $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
                        
                        $noofimpugned=$st[0]->no_of_impugned;
                        $ia=$st[0]->no_of_ia;
                        $norespondent=$st[0]->no_of_res;
                        $fee=$this->session->userdata('efilingFeeData');
                        
                        
                        $iaFee1= @$fee['iaFee1'];
                        $otherFee2=@$fee['otherFee2'];
                        
                        
                        $act = $st[0]->act;
                        $hscqueryact11 =$this->efiling_model->data_list_where('master_energy_act','act_code',$act);
                        $fee = isset($hscqueryact11[0]->fee)?$hscqueryact11[0]->fee:'';
                        
                        
                        $st=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt', $salt);
                        $rescount=count($st)+1;
                        $resamoubnt=0;
                        if($rescount>4){
                            $resamoubnt=($rescount-4)*$fee;
                        }
                        //$appealFee= $fee*$noofimpugned+$resamoubnt;
                        $total=@$appealFee+$iaFee1+$otherFee2;
                        
                        ?>
				        <input type="hidden" name="iaval" value="<?php echo $ia; ?>" id="iaval">
    					<input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
		                <input type="hidden" name="totalNoIA" value="<?php echo $norespondent; ?>" id="totalNoIA">
   			
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group required">
                                    <label>Appeal Fee<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'totalFee3','id'=>'totalFee3','class'=>'form-control','readonly'=>'true','value'=>$appealFee]) ?>
                                </div>
                            </div>
                           <?php if($this->config->item('ia_privilege')==true):?>
                            <div class="col-md-3" >
                                <div class="form-group required">
                                    <label>IA Fee<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'iaFee1','id'=>'iaFee1','class'=>'form-control','readonly'=>'true','value'=>$iaFee1]) ?>
                                </div>
                            </div>
                            <?php endif;?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Other Fee</label>
                                    <?= form_input(['name'=>'otherFee2','id'=>'otherFee2','class'=>'form-control','readonly'=>'true','value'=>$otherFee2]) ?>
                                </div>
                            </div>          
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Total Fee</label>
                                    <?= form_input(['name'=>'total','id'=>'total','class'=>'form-control','readonly'=>'true','value'=>$total]) ?>
                                </div>
                            </div>
                        </div>

                     
                        </fieldset>                       

		  <div class="row">
                            <div class="col-md-12 text-right my-2">
                            	<?php
                    			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                    form_submit(['value'=>'Save & Next','class'=>'btn btn-success','id'=>'feedetailsubmit','style'=>'padding-left:24px;']).
                                     '<i class="icon-trash-alt" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>'.
                    			     form_reset(['value'=>'Reset/Clear','class'=>'btn btn-warning','style'=>'padding-left: 24px;']);
                                    //  .form_button(['id'=>'','value'=>'false','content'=>'&nbsp;Next','class'=>'icon-arrow-right8 btn btn-primary']);
                            	?>
                            </div>
                        </div>
                    <?= form_fieldset_close(); ?>
                </div>
            <?= form_close();?>
        </div>
	</div>
    </div>
    
</div>	

<script>

function feeCalculation() {
    var exp = document.getElementById("payAmount").value;
    var total = document.getElementById("total").value;
    var totalNoIA1 = document.getElementById("totalNoIA").value;
    var salt = document.getElementById("saltNo").value;
    var iafee = totalNoIA1 * 1000;
    var dataa={};
    dataa['resexp']=exp,
    dataa['salt']=salt,
    dataa['total']=total,
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'feeCalculation',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		$('#feeCalculation').show();
        		$('#left_amountd_fee').val(resp.value);
        		
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
	 
    document.getElementById("feeCalculation").style.display = 'block';
}


$('#payment_mode').submit(function(e){
	e.preventDefault();
	var token = document.getElementById("token").value;
	var tabno = document.getElementById("tabno").value;
    var salt = document.getElementById("saltNo").value;
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    var totalFee3 = document.getElementById("totalFee3").value;
    var iaFee1=0;
    if(document.getElementById(iaFee1) != null) {
        var iaFee1 = document.getElementById("iaFee1").value;
    }
    var otherFee2 = document.getElementById("otherFee2").value;
    var tabno= document.getElementById("tabno").value;
    var dataa = {};
	dataa['salt'] =salt,
	dataa['totalFee'] = totalFee3,
	dataa['iaFee'] =  iaFee1,
	dataa['otherFee'] =  otherFee2,
	dataa['tabno']=tabno;
	$.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'payfeedetailsave',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {

    		   setTimeout(function(){
                    window.location.href = base_url+'final_preview';
                 }, 250);
         
         
        	    document.getElementById("loading_modal").style.display = 'none';
        	    $('#step_7').removeClass('btn-danger btn-warning btn-info').addClass('btn-success');
        	    $('#step_8').removeClass('btn-danger btn-warning btn-info').addClass('btn-warning');
			}
			else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
			$('#feedetailsubmit').prop('disabled',false).val("Submit");
		}
	 }); 
});


function paymentMode(sel) {
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    if (bd > 0) {
         $.ajax({
            type: "POST",
            url: base_url+"postalOrder",
            data: "app=" + bd,
            cache: false,
            success: function (data) {
            	$('#payMode').html(data);
            }
        });
    }
}

function isNumberKey(evt){ 
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
      return false;
    }else{
		 return true;
    }
}

</script>
<?php $this->load->view("admin/footer"); ?>