<?php
$this->load->view("admin/header"); 
$this->load->view("admin/sidebar"); 
$token1= $this->efiling_model->getToken();
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script> 
<div id="rightbar"> 
<?php  $this->load->view("admin/stepsrefile"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>
<div class="content" style="padding-top:0px;">
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'ia_details','autocomplete'=>'off']) ?>
                <div class="content clearfix">
                    <?php $salt=$this->session->userdata('refiling_no'); ?>
					<input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
					 <?php 
					    $iano=array();
                        $st=$this->efiling_model->data_list_where('ia_detail','filing_no', $salt);
                        $totalNoIA=count($st);
                        foreach($st as $val){
                            $iano[]=$val->ia_nature;
                        }
                        ?>  
                        <input type="hidden"  id="tabno" name="tabno" value="<?php echo '5'; ?>">
    					<input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
                        <?= form_fieldset('IA Details').
                        '';
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
                                  	<label class="control-label" for="totalNoIA"><span class="custom"><font color="red">*</font></span>Total No. of IAs:</label>
                                  	<div class="input-group mb-3 mb-md-0">
                                  	 <?= form_input(['name'=>'totalNoIA','value'=>$totalNoIA,'id'=>'totalNoIA', 'class'=>'form-control','placeholder'=>'Total No IA','pattern'=>'[0-9]{1,2}','maxlength'=>'2','required'=>'true','title'=>'Total No IA should be numeric only.']) ?>
                                  	</div>
                                </div>
                            </div>         
                      	   <table class="table">
                              <thead>
                                <tr style="background-color: #e3c7c7;">
                                <th scope="col">S. No.</th>
                                  <th scope="col"></th>
                                  <th scope="col">IA Nature </th>
                                  <th scope="col">Fees</th>
                                </tr>
                              </thead>
                              <tbody>
                               <?php 
                                $arrayc=array('34','20','19','52','17','18','23','14','15','28','29','31','36','10','39','40','21','41','42','43','45','48','49','50','51','35','22','27','6','53','54','55','56','57','58','59','60');
                                $stated= $this->efiling_model->ia_data_listall('moster_ia_nature',$arrayc,'nature_code','nature_code');
                                $i=1;
                                $j=0;
                                foreach($stated as $row){   
                                    $val='';
                                 //   print_r($iano);die;
                                    if(is_array($iano)){
                                        if(in_array($row->nature_code, $iano)){
                                            $val="checked";
                                        }
                                    }
                                   if(in_array($row->nature_code, $iano)){
                                ?>
                                <tr>
                                     <td><?php echo $i;?></td>
                                      <td><input type="checkbox" name="natureCode" value ="<?php echo htmlspecialchars($row->nature_code); ?>" onclick="openTextBox(this);" <?php echo $val; ?>></td>
                                      
                                      <td><?php echo htmlspecialchars($row->nature_name);?></td>
                                      <td><?php echo htmlspecialchars($row->fee);?></td>
                                </tr>
                          		 <?php $i++;$j++; 
                                   }
                                }?>
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

<?php 

$refiling= $this->session->userdata('refiling_no');
$rowd= $this->efiling_model->data_list_where('table_defecttabopen','filing_no',$refiling);
if(!empty($rowd) && is_array($rowd)){
    $numbers=json_decode($rowd[0]->tabvals);
    sort($numbers);
    $arrlength=count($numbers);
    $vals=array();
    for($x=0;$x<$arrlength;$x++){
        $vals[]=  $numbers[$x] ;
    }
    
    $num='5';
    $i=1;
    $valrr='';
    foreach($vals as $key=>$val){
        if($val > $num){
            if($valrr==''){
                $valrr= $val;
            }
        }
        $i++;
    }
    if($valrr==1){
        $urlv="basicdetails-mod";
    }
    if($valrr==2){
        $urlv="applicant-mod";
    }
    if($valrr==3){
          $urlv="respondentRefile";
    }
    if($valrr==4){
         $urlv="counselrefile";
    }
    if($valrr==5){
          $urlv="ia_detailrefile";
    }
      
    if($valrr==6){
      $urlv="editother_fee";
    }
    if($valrr==7){
          $urlv="documentuploadedit";
    }
    if($valrr==8){
        $urlv="paymentmodeedit";
    }
}
?>


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
	        url: base_url+'editiasubmit',
	        data: dataa,
	        cache: false,
			beforeSend: function(){
				$('#iasubmit').prop('disabled',true).val("Under proccess....");
			},
	        success: function (resp) {
	        	if(resp.data=='success') {
	        		setTimeout(function(){
                        window.location.href = base_url+'<?php echo $urlv;?>';
                     }, 250);
				}else if(resp.error != '0') {
					$.alert(resp.display);
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