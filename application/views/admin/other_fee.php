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
<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>
<div class="content" style="padding-top:0px;">
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'other_fee','autocomplete'=>'off']) ?>
                <div class="content clearfix">
                    <?= form_fieldset('Other Fee Details').
                        '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'.
                        '<div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
                        ?>
                      	<div class="row">
                      	 <?php $salt=$this->session->userdata('salt'); ?>
                      	 <input type="hidden"  id="tabno" name="tabno" value="<?php echo '6'; ?>">
					<input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
					           <?php 
                        $token=rand(1000,9999);
                        $md_db = hash('sha256',$token);
                        $token1=$md_db;
                        $this->session->set_userdata('tokenno',$token1);
                        
                        $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
                        $ia=$st[0]->no_of_ia;
                        $tia=$st[0]->no_of_pet;
                        $norespondent=$st[0]->no_of_res;
                        $act=$st[0]->act;
                        $nature=$st[0]->ia_nature;
                        $commission=$st[0]->commission; 
                        $com=explode('|', $commission);
                        $commcount=count($com)-2;
                        ?>
    					<input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
    					<input type="hidden" name="totalNoIA" value="<?php echo $ia; ?>" id="totalNoIA">
    					<input type="hidden" name="totalNoRespondent" value="<?php echo $norespondent; ?>" id="totalNoRespondent">
    					<input type="hidden" name="totalNoAnnexure" value="<?php echo $tia; ?>" id="totalNoAnnexure">
    					
    					<input type="hidden" name="act" value="<?php echo $act; ?>" id="act">
						<input type="hidden" name="natureCode" value="<?php echo $nature; ?>" id="natureCode">
    					<input type="hidden" name="cnt" value="<?php echo $commcount; ?>" id="cnt">
                      	   <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col"></th>
                                  <th scope="col">S.NO</th>
                                  <th scope="col">Fee Document Name</th>
                                  <th scope="col">Fees</th>
                                </tr>
                              </thead>
                              <tbody>
                               <?php 
                                $state= $this->efiling_model->data_list('master_fee_detail');
                                $i=1;
                                foreach($state as $row){
                                ?>
                                <tr>
                                     <td><input type="checkbox"
                                    <?php if($this->config->item('ia_privilege')==true):?>onclick="openTextBox()" <?php endif;?> name ="otherFeeCode"  value ="<?php echo htmlspecialchars($row->doc_code); ?>"
                                    <?php if($this->config->item('ia_privilege')==true):?>checked="checked" <?php endif;?>
                                              ></td>
											  <td><?php echo htmlspecialchars($i);?></td>
                                      <td><?php echo htmlspecialchars($row->doc_name);?></td>
                                      <td><?php echo htmlspecialchars($row->doc_fee);?></td>
                                </tr>
                          		 <?php $i++; }?>
                              </tbody>
                            </table>
                      	</div>

                        <div class="row">
                            <div class="offset-md-8 col-md-4">
                            	<?php
                    			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                    form_submit(['value'=>'Save & Next','class'=>'btn btn-success','id'=>'other_feesave','style'=>'padding-left:24px;']).
                                     '<i class="icon-trash-alt" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>'.
                    			     form_reset(['value'=>'Reset/Clear','class'=>'btn btn-danger','style'=>'padding-left: 24px;']);
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
<script>


$('#other_fee').submit(function(e){
	e.preventDefault();
    var act = document.getElementById("act").value;
    var salt = document.getElementById("saltNo").value;
    var token = document.getElementById("token").value;
    var iaNature =  document.getElementById('natureCode').value;
/*     var count = 0;
    var checkboxes = document.getElementById('natureCode').value;
    var selected = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            iaNature = iaNature + checkboxes[i].value + ',';
            count++;
        }
    } */
    var totalNoAnnexure1 = document.getElementById("totalNoAnnexure").value;
    var checkboxes1 = document.getElementsByName('otherFeeCode');
    var otherFee = "";
    var count1 = 0;
    var selected = [];
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
            otherFee = otherFee + checkboxes1[i].value + ',';
            count1++;
        }
    }
    /*if (count1 == 0 && totalNoAnnexure1 != 0) {
        alert("Please Select Enclosure /Annexure Court fee");
        document.filing.otherFeeCode.focus();
        return false;
    }*/
    var res = document.getElementById("totalNoRespondent").value;
    var ia = document.getElementById("totalNoIA").value;
    var totallower = document.getElementById("cnt").value;
    var tabno= document.getElementById("tabno").value;
    var dataa = {};
	dataa['salt'] =salt;
	dataa['ia'] =ia; 
	dataa['nature'] =iaNature; 
	dataa['token'] =token;
	dataa['act'] =act; 
	dataa['ann'] =totalNoAnnexure1; 
	dataa['cnt'] =totallower;
	dataa['token']=token;
	dataa['resexp']=res;
	dataa['fee']=otherFee;
	dataa['tabno']=tabno;
	$.ajax({
        type: "POST",
        url: base_url+'otherFeesave',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#other_feesave').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {

        		setTimeout(function(){
                    window.location.href = base_url+'document_upload';
                 }, 250);
                     
        	    document.getElementById("loading_modal").style.display = 'none';
        	    $('#step_5').removeClass('btn-danger btn-warning btn-info').addClass('btn-success');
        	    $('#step_6').removeClass('btn-danger btn-warning btn-info').addClass('btn-warning');;
			}
			else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
			$('#other_feesave').prop('disabled',false).val("Submit");
		}
	 }); 

});
</script>
<?php $this->load->view("admin/footer"); ?>