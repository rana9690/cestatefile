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
<?php   $this->load->view("admin/stepsrefile"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(); ?>
<div class="content" style="padding-top:0px;">
<script>
 paymentMode();
</script>
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'payment_mode','autocomplete'=>'off']) ?>
                <div class="content clearfix">
                    <?= form_fieldset('Fee Details').
                        '';
                        ?>
                     <input type="hidden"  id="tabno" name="tabno" value="<?php echo '8'; ?>">
                     <?php $salt=$this->session->userdata('salt'); ?>
					 <input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
					    <?php 
					    $token1= $this->efiling_model->getToken();
					    $norespondent=0;
					    $countcomm=0;
					    $commFee=0;
                        $query="select * from additional_commision where  filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
                        $data=$this->db->query($query);
                        if($data->num_rows()>0) {
                            $countcomm= count($data->result());
                            $commFee=$countcomm*100000;
                        }
                        
                        
                        $appFee=0;
                        $queryApp="select * from additional_party where party_flag='1' AND filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
                        $data=$this->db->query($queryApp);
                        if($data->num_rows()>0) {
                            $countapp= count($data->result());
                            if($countapp>5){
                                $appFee=$countapp*5000;
                            }
                        }
                        
                        $countorg='0';
                        $queryRes1="select count(filing_no) from additional_party where party_flag='2' AND  addedfrom IS NULL AND filing_no='$salt' and paymentstatus='0' ";
                        $data1=$this->db->query($queryRes1);
                        if($data1->num_rows()>0) {
                            $val= $data1->result();
                            $countorg=$val[0]->count+1;
                        }

                        $otherFee2=0;
                        $resFee=0;
                        $exclusiveamount=10000;
                        $queryRes="select * from additional_party where party_flag='2' AND filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
                        $data=$this->db->query($queryRes);
                        if($data->num_rows()>0) {
                            $countres= count($data->result());
                            $total=$countres+$countorg;
                            if($total < 4){
                                $resFee=0;
                            }
                            if($total>4){
                                $resFee=($total-$countres-4)*10000;
                            }
                            if($total==4){
                                $resFee=0;
                            }
                        }  //20000 per
                        

                        //$appealFee= $commFee;
                        $total=@$appealFee+$otherFee2+$resFee;
                        
                        ?>
    					<input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
		                <input type="hidden" name="totalNoIA" value="<?php echo $norespondent; ?>" id="totalNoIA">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group required">
                                    <label>Appeal Fee<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'totalFee3','id'=>'totalFee3','class'=>'form-control','readonly'=>'true','value'=>$appealFee]) ?>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Other Respondent Fee</label>
                                    <?= form_input(['name'=>'otherFee2','id'=>'otherFee2','class'=>'form-control','readonly'=>'true','value'=>$resFee]) ?>
                                </div>
                            </div>          
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Total Fee</label>
                                    <?= form_input(['name'=>'total','id'=>'total','class'=>'form-control','readonly'=>'true','value'=>$total]) ?>
                                </div>
                            </div>
                        </div>
		  				<div class="row">
                            <div class="offset-md-8 col-md-4">
                            	<?php
                    			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                    form_submit(['value'=>'Save & Next','class'=>'btn btn-success','id'=>'feedetailsubmit','style'=>'padding-left:24px;']).
                                     '<i class="icon-trash-alt" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>'.
                    			     form_reset(['value'=>'Reset/Clear','class'=>'btn btn-danger','style'=>'padding-left: 24px;']);
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
$('#payment_mode').submit(function(e){
	e.preventDefault();
	var token = document.getElementById("token").value;
    var salt = document.getElementById("saltNo").value;
    var totalFee3 = document.getElementById("totalFee3").value;
    var otherFee2 = document.getElementById("otherFee2").value;
    var dataa = {};
	dataa['salt'] =salt,
	dataa['totalFee'] = totalFee3,
	dataa['otherFee'] =  otherFee2,
	dataa['token'] =  '<?php echo $token1; ?>',
	$.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'payfeedetailsaveedit',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success' && resp.display=='') {
    		   setTimeout(function(){
                    window.location.href = base_url+'paypageedit';
                 }, 250);
			}else if(resp.data=='success' && resp.display=='success'){
				 setTimeout(function(){
	                    window.location.href = base_url+'refilesuccess';
	             }, 250);
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