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
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'ia_details','autocomplete'=>'off']) ?>
                <div class="content clearfix">
                 <?php $salt=$this->session->userdata('salt'); ?>
					<input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
					 <?php 
                        $token=rand(1000,9999);
                        $md_db = hash('sha256',$token);
                        $token1=$md_db;
                        $this->session->set_userdata('tokenno',$token1);
                        $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
                        $ia=$st[0]->no_of_ia;
                        $norespondent=$st[0]->no_of_res;
                        $ianature=$st[0]->ia_nature;
                        $iano=explode(',', $ianature);
                        ?>  
                        <input type="hidden"  id="tabno" name="tabno" value="<?php echo '5'; ?>">
    					<input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
    					<input type="hidden" name="totalNoRespondent" value="<?php echo $norespondent; ?>" id="totalNoRespondent">
                        <?= form_fieldset($this->lang->line('iaTab')).
                        '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'.
                        '<div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
                        ?>
                        <div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px; max-width: 100%;">
                            <div class="col-md-4">
                                <label class="text-danger">Select Mode</label>
                            </div>
                            <div class="col-md-6 md-offset-2">
                                <label for="org" class="form-check-label font-weight-semibold">
                                    <?= form_radio(['name'=>'appAnddef','value'=>'1','id'=>'app','checked'=>'checked']); ?>Applicant&nbsp;&nbsp;
                                </label>
                             <!--   <label for="indv" class="form-check-label font-weight-semibold">
                                    <?= form_radio(['name'=>'appAnddef','value'=>'2','id'=>'def']); ?>Respondent&nbsp;&nbsp;
                                </label>--->
 
                            </div>
                        </div>
                      	<div class="row">                      	
                          	<div class="form-card">
                                  <div class="form-group">
                                  	<label class="control-label" for="totalNoIA"><span class="custom"><font color="red">*</font></span><?=$this->lang->line('noIa')?>:</label>
                                  	<div class="input-group mb-3 mb-md-0">
                                  	<?php  $totalNoIA=$st[0]->no_of_ia; ?>
                                  	 <?= form_input(['name'=>'totalNoIA','value'=>$totalNoIA,'id'=>'totalNoIA', 'class'=>'form-control','placeholder'=>$this->lang->line('noIa'),'pattern'=>'[0-9]{1,2}','maxlength'=>'2','required'=>'true','title'=>$this->lang->line('noIa').'should be numeric only.']) ?>
                                  	</div>
                                </div>
                            </div>         
                      	   <table class="table">
                              <thead>
                                <tr style="background-color: #e3c7c7;">
                                <th scope="col">S. No.</th>
                                  <th scope="col"></th>
                                  <th scope="col">IA Nature</th>
                                  <th scope="col">Fees</th>
                                </tr>
                              </thead>
                              <tbody>
                               <?php 
                                $array=array('34','20','19','52','17','18','23','14','15','28','29','31','36','10','39','40','21','41','42','43','45','48','49','50','51','35','22','27','6','53','54','55','56','57','58','59','60');
                                $state= $this->efiling_model->ia_data_list('moster_ia_nature',$array,'nature_code','nature_code');
                                $i=1;
                                //print_r($iano);die;
                                $j=0;
                            //  echo "<pre>";  print_r($iano);
                         //     echo "<pre>";  print_r($state);
                                foreach($state as $row){   
                                    $val='';
                                    if(is_array($iano)){
                                        if(in_array($row->nature_code, $iano)){
                                            $val="checked";
                                        }
                                    }

                                ?>
                                <tr>
                                     <td><?php echo $i;?></td>
                                      <td><input type="checkbox" name="natureCode" value ="<?php echo htmlspecialchars($row->nature_code); ?>" onclick="openTextBox(this);" <?php echo $val; ?>></td>
                                      
                                      <td><?php echo htmlspecialchars($row->nature_name);?></td>
                                      <td><?php echo htmlspecialchars($row->fee);?></td>
                                </tr>
                          		 <?php $i++;$j++; }?>
                              </tbody>
                              
                              <div class="col-sm-12 div-padd" id="matterId" style="display: none">
                                  <div><label for="name"><span class="custom"><font color="red"></font></span>Matter </label></div>
                            	  <div><textarea rows="4" cols="110" name="matter" id="matter" class="txtblock"></textarea></div>
                            	  <input type="hidden" value="" name="filingOn"> 
                              </div>
                            </table>
                      	</div>

                        <div class="row">
                            <div class="offset-md-8 col-md-4">
                            	<?php
                    			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                    form_submit(['value'=>'Save & Next','class'=>'btn btn-success','id'=>'iasubmit','style'=>'padding-left:24px;']).
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
$('#ia_details').submit(function(e){
	e.preventDefault();
    var salt = document.getElementById("saltNo").value;
    var filedBy = document.getElementsByName("appAnddef");
    var token = document.getElementById("token").value;

    var caseval = "";
    for (var i = 0; i < filedBy.length; i++) {
        if (filedBy[i].checked) {
            var caseval = filedBy[i].value;
        }
    }
    if (caseval == "") {
        alert("Please Select Filed by IA");
        document.filing.appAnddef.focus();
        return false
    }
    var iaNature = "";
    var count = 0;
    var checkboxes = document.getElementsByName('natureCode');
    var selected = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            iaNature = iaNature + checkboxes[i].value + ',';
            count++;
        }
    }
    var res = document.getElementById("totalNoRespondent").value;
    var ia = document.getElementById("totalNoIA").value;
    if (count < ia) {
        var msg = "Checked IA's should not be less than total no of IA's";
        alert(msg);
        return false;
    }
    if (count > ia) {
        var msg = "You cannot check IA's more than total no of IA's.";
        alert(msg);
        return false;
    }
    var tabno= document.getElementById("tabno").value;


	
	var dataa = {};
	dataa['filed'] =caseval,
	dataa['natuer'] =iaNature,
	dataa['salt'] =salt,
	dataa['token'] = token,
	dataa['tabno']=tabno,
	dataa['totalNoIA']=ia;
		$.ajax({
		    dataType: 'json',
	        type: "POST",
	        url: base_url+'iasubmit',
	        data: dataa,
	        cache: false,
			beforeSend: function(){
				$('#iasubmit').prop('disabled',true).val("Under proccess....");
			},
	        success: function (resp) {
	        	if(resp.data=='success') {
	        		setTimeout(function(){
                        <?php if(OTHER_FEE==true):?>
                        window.location.href = base_url+'other_fee';
                        <?php else:?>
                        window.location.href = base_url+'document_upload';
                        <?php endif;?>


                     }, 250);
                 
	        	    document.getElementById("loading_modal").style.display = 'none';
	        	    $('#step_4').removeClass('btn-danger btn-warning btn-info').addClass('btn-success');
	        	    $('#step_5').removeClass('btn-danger btn-warning btn-info').addClass('btn-warning');
				}
				else if(resp.error != '0') {
					$.alert(resp.error);
				}
	        },
	        error: function(){
				$.alert("Surver busy,try later.");
			},
			complete: function(){
				$('#iasubmit').prop('disabled',false).val("Submit");
			}
		 }); 
});
</script>
<?php $this->load->view("admin/footer"); ?>