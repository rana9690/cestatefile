<?php $this->load->view("admin/header"); 
$this->load->view("admin/sidebar");
$token= $this->efiling_model->getToken(); ?>

<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script>

<?php      $this->load->view("admin/stepsrefile"); ?>


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
    <div class="content" style="padding:0px">
        <div class="row">
            <div class="card checklistSec" style="">
            
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'res_respndent','autocomplete'=>'off']) ?>
                <div class="content clearfix">
                      <?php $salt=$this->session->userdata('refiling_no'); ?>
					<input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
					   <?php 
                        $res= $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$salt);
                        if(!empty($res)){
                            $ptype= $res[0]->res_type;
                            $ptype1='';
                        
                            if($ptype==''){
                                $ptype1='checked';
                            }
                            if($ptype=='1'){
                                $ptype1='checked';
                            }
                            $ptype2='';
                            if($ptype=='2'){
                                $ptype2='checked';
                            }
                        }
                        ?>
                        <?= form_fieldset('Add Respondent').
                        '';
                        ?>
                    <div class="row alert alert-warning" style="">
                        <div class="col-md-12">
                                <label class="text-dark mr-2">Select Mode</label>

                                <label for="org" class="form-check-label font-weight-semibold">
                                    <?= form_radio(['name'=>'orgres','id'=>"bd1" ,'value'=>'1','onclick'=>'orgshowres();','checked'=>@$ptype1]); ?> Organization&nbsp;&nbsp;
                                </label>
                                <label for="indv" class="form-check-label font-weight-semibold">
                                    <?= form_radio(['name'=>'orgres','id'=>'po1' ,'value'=>'2' ,'onclick'=>'orgshowres();','checked'=>$ptype2]); ?> Individual&nbsp;&nbsp;
                                </label>
                                <label for="inp" class="form-check-label font-weight-semibold">
                                </label>
                            </div>
                        </div>
			            <?php   
			            $array=array('filing_no'=>$salt,'party_flag'=>'2');
			            $additionalparty=$this->efiling_model->data_list_mulwhere('additional_party',$array);
			            $resname=isset($res[0]->res_name)?$res[0]->res_name:''; 
			            $val=0;
			            if($resname!=''){
			                $val='1';
			            }
			            $count= count($additionalparty)+$val;
                        ?>
                         <input type="hidden"  id="tabno" name="tabno" value="<?php echo '3'; ?>">
                         <input type="hidden" name="count" id="count" value="<?php echo isset($count)?$count:'1'?>">
                        <div class="row">
                            <div class="col-md-4"> 
                          		<div class="form-card">
                                    <div class="form-group">
                                      	<label class="control-label" for="totalNoRespondent"><span class="custom"><font color="red">*</font></span>Total No. of Respondents:</label>
                                      	<div class="input-group mb-3 mb-md-0">
                                      	<?= form_input(['name'=>'totalNoRespondent','class'=>'form-control','id'=>'totalNoRespondent','onkeypress'=>'return isNumberKey(event)','value'=>$count,'placeholder'=>'','pattern'=>'[0-9]{1,2}','maxlength'=>'2','title'=>'Total No Respondent should be numeric only.']) ?>
                                      	</div>
                                	</div>
                            	</div>
                          	</div>
                         </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                <label>Name:<span class="text-danger">*</span></label>
                                <input type="hidden" name="resorgid" value="" id="resorgid" class="txt">
                                <input type="text" name="resName" value="" id=resName  class="form-control" onkeypress="serchrecordvalapp(this.value);">
                        		<ul class="autosuggest" id="regnum_autofill">
                        		</ul>
                        		  </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>State Name:<span class="text-danger">*</span></label>
                                    <input type="hidden" name="resstatename" value="" id="resstatename" class="txt">
                                     <?php
                                     $state= $this->efiling_model->data_list('master_psstatus');
                                     $state1[]='- Please Select state-';
                                     foreach ($state as $val)
                                         $state1[$val->state_code] = $val->state_name; 
                                         echo form_dropdown('stateRes',$state1,$res[0]->res_state,['class'=>'form-control','onchange'=>"",'onchange'=>"showCityval(this);" ,'id'=>'stateRes','value'=>'']); 
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number:</label>
                                       <?php  $resphone='';//$res[0]->res_phone; ?>
                                    <?= form_input(['name'=>'resPhone','value'=>$resphone,'id'=>"resPhone",'onkeypress'=>'return isNumberKey(event)','class'=>'form-control','placeholder'=>'','pattern'=>'[0-9]{0,15}','maxlength'=>'10','title'=>'Phone allowed only numeric']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
              
                            
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <input type="hidden" name="ddistrictres" value="<?php  echo $res[0]->pet_dist; ?>" id="ddistrictres" class="txt">
                                    <label>District:<span class="text-danger">*</span></label>                    
                        	        <?php   $petdis= '';// $this->efiling_model->data_list_where('master_psdist','district_code',$app[0]->pet_dist);
                                       $city1[]='- Please Select city-';
                                       echo form_dropdown('ddistrictname',$city1,$petdis,['class'=>'form-control','id'=>'ddistrictname']);  ?>
                                </div>
                            </div>
                                    
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email ID:<span class="text-danger">*</span></label>
                                       <?php  $res_email='';//$res[0]->res_email; ?>
                                    <?= form_input(['name'=>'resEmail','value'=>$res_email,'class'=>'form-control','id'=>'resEmail','placeholder'=>'','pattern'=>'[.-@A-Za-z0-9]{1,200}','maxlength'=>'200','title'=>'Email allowed only alphanumeric']) ?>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Address:</label>
                                     <?php  $res_address='';//$res[0]->res_address; ?>
                                    <?= form_textarea(['name'=>'resAddress','value'=>$res_address,'id'=>'resAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'Address Of Appellant allowed only alphanumeric']) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Pincode</label>
                                      <?php  $res_pin='';//$res[0]->res_pin; ?>
                                    <?= form_input(['name'=>'respincode','value'=>$res_pin,'class'=>'form-control','id'=>'respincode','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)','pattern'=>'[0-9]{0,6}','maxlength'=>'6','title'=>'Pincode info allowed only numeric']) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Fax No:</label>
                                    <?php  $res_fax='';//$res[0]->res_fax; ?>
                                     <?= form_input(['name'=>'resFax','value'=>$res_fax,'class'=>'form-control','id'=>'resFax','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)','pattern'=>'[0-9 ]{0,12}','maxlength'=>'12','title'=>'petFax info allowed only numeric']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Mobile<span class="text-danger">*</span></label>
                                      <?php  $res_mobile='';//$res[0]->res_mobile; ?>
                                    <?= form_input(['name'=>'resMobile','value'=>$res_mobile,'class'=>'form-control','id'=>'resMobile','onkeypress'=>'return isNumberKey(event)','placeholder'=>'','pattern'=>'[0-9]{0,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
                                </div>
                            </div>
                        </div>
                        <input type="button" name="nextsubmit" id="nextsubmit" value="Add Respondent"
                               class="btn btn-primary btn-cntr" onclick="addMoreResRefile();">
                       <?php  echo form_fieldset_close();?>

                    <div class="row m-0">
                    <div class="card w-100 mt-5 inner-card">
                        <?php
                        echo form_fieldset('ADDED RESPONDENT(S) LIST').
                            '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 21px 6px;"></i>'; ?>


                                    <div class="d-block text-center text-warning mx-3">
                                            <div class="table-responsive text-secondary" id="add_petitioner_list">
                                                <span class="fa fa-spinner fa-spin fa-3x" style="display:none"></span>
                                                <table id="addmorerecordapp" class="table display" cellspacing="0" border="1" width="100%">
                                                    <thead>
                                                        <tr class="bg-dark">
                                                            <th>Sr.No.</th>
                                                            <th>Respondent Name</th>
                                                           
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $vals=$this->efiling_model->data_list_where('case_detail','filing_no',$salt);
                                                     if(@$vals[0]->res_name!=''){
                                                        $petName=$vals[0]->res_name;

                                                    ?>
                                                    <tr style="color:green">
                                                        <td>1</td>
                                                            <td><?php echo $petName; ?>(R-1)</td>
                                                           
                                                            <td> <?php echo $vals[0]->res_mobile ?></td>
                                                            <td><?php echo $vals[0]->res_email ?></td>
                                                            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"   data-toggle="modal" data-target="#exampleModal"
                                                            	onclick="editPartyrefile('<?php echo $vals[0]->filing_no; ?>','res','main')"></td>
                                                            <td></td>
                                                        </tr>
                                                    <?php } 
                                                    $array=array('filing_no'=>$salt,'party_flag'=>'R');
                                                    $additionalresparty=$this->efiling_model->data_list_mulwhere($schemas.'.additional_party_detail',$array);
                                                    //print_r($additionalresparty);
                                                    $i=2;
                                                    if(!empty($additionalresparty)){
                                                        foreach($additionalresparty as $val){
                                                            $resName=$val->name;

                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $resName; ?>(R-<?php echo $i; ?>)</td>
                                                               
                                                                <td> <?php echo $val->pet_mobile ?></td>
                                                                <td><?php echo $val->pet_email ?></td>
                                                                <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"   data-toggle="modal" data-target="#exampleModal"  onclick="editPartyrefile('<?php echo $val->party_serial_no; ?>','res','add')"></td>
                                                                <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger"   onclick="deletePartyrefile('<?php echo $val->party_serial_no; ?>','res','add')"></td>
                                                            </tr>
                                                            <?php 
                                                            $i++; }
                                                        }else{
                                                            $val= "<span style='color:Red'>Reccord Not found";
                                                        }
                                                     ?> 
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                        </fieldset>
                               
                            </div>
                            </div>

                        <div class="row">
                            <div class="offset-md-8 col-md-4 text-right">
                            	<?php
                    			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                    form_submit(['value'=>'Save & Next','class'=>'btn btn-success ','id'=>'ressub','style'=>'padding-left:24px;']).
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
	



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-top: 190px;">
    <div class="modal-content" style="width: 1050px; margin-left: -194px;">
        <div class="modal-header bg-warning">
            <h4 class="modal-title" id="exampleModalLabel">Edit Respondent </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearbox();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <fieldset id="jurisdiction" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Edit Respondent Details</legend>                             
            <div class="row">
           		 <input type="hidden" name="id" id="id" value="">
	       		 <input type="hidden" name="edittype" id="edittype" value="">
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Name:<span class="text-danger">*</span></label>      
                        <input type="hidden" name="editresorgid" value="" id="editresorgid" class="txt">
                        <input type="text" name="edit_resName" value="" id=edit_resName  class="form-control" onkeypress="serchrecordvalappedit(this.value);">
                		<ul class="autosuggest" id="regnum_autofillEdit">
                		</ul>	
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>State Name:<span class="text-danger">*</span></label>
                        <input type="hidden" name="resstatename" value="" id="edit_resstatename" class="txt">
                         <?php
                         $state= $this->efiling_model->data_list('master_psstatus');
                         $state1[]='- Please Select state-';
                         foreach ($state as $val)
                             $state1[$val->state_code] = $val->state_name; 
                             echo form_dropdown('stateRes',$state1,$res[0]->res_state,['class'=>'form-control','onchange'=>"",'onchange'=>"showCityvaledit(this);",'id'=>'edit_stateRes','value'=>'']); 
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone Number:</label>
                           <?php  $resphone=$res[0]->res_phone; ?>
                        <?= form_input(['name'=>'resPhone','value'=>$resphone,'id'=>"edit_resPhone",'class'=>'form-control','placeholder'=>' ','pattern'=>'[0-9]{0,15}','maxlength'=>'15','title'=>'Phone allowed only numeric']) ?>
                    </div>
                </div>
            </div>
            <div class="row">
               
                
                <div class="col-md-4">
                    <div class="form-group required">
                        <input type="hidden" name="edit_ddistrictres" value="<?php  echo $res[0]->pet_dist; ?>" id="edit_ddistrictres" class="txt">
                        <label>District:<span class="text-danger">*</span></label>                    
            	        <?php   $petdis= '';// $this->efiling_model->data_list_where('master_psdist','district_code',$app[0]->pet_dist);
                           $city1[]='- Please Select city-';
                           echo form_dropdown('edit_ddistrictname',$city1,$petdis,['class'=>'form-control','id'=>'edit_ddistrictname']);  ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email ID:<span class="text-danger">*</span></label>
                           <?php  $res_email=$res[0]->res_email; ?>
                        <?= form_input(['name'=>'resEmail','value'=>$res_email,'class'=>'form-control','id'=>'edit_resEmail','placeholder'=>'','pattern'=>'[.-@A-Za-z0-9]{1,200}','maxlength'=>'200','title'=>'Email allowed only alphanumeric']) ?>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Address:</label>
                         <?php  $res_address=$res[0]->res_address; ?>
                        <?= form_textarea(['name'=>'resAddress','value'=>$res_address,'id'=>'edit_resAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>' ','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'Address Of Appellant allowed only alphanumeric']) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Pincode</label>
                          <?php  $res_pin=$res[0]->res_pin; ?>
                        <?= form_input(['name'=>'respincode','value'=>$res_pin,'class'=>'form-control','id'=>'edit_respincode','placeholder'=>'','pattern'=>'[0-9]{0,6}','maxlength'=>'6','title'=>'Pincode info allowed only numeric']) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Fax No:</label>
                        <?php  $res_fax=$res[0]->res_fax; ?>
                         <?= form_input(['name'=>'resFax','value'=>$res_fax,'class'=>'form-control','id'=>'edit_resFax','placeholder'=>'','pattern'=>'[0-9 ]{0,12}','maxlength'=>'12','title'=>'petFax info allowed only numeric']) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Mobile<span class="text-danger">*</span></label>
                          <?php  $res_mobile=$res[0]->res_mobile; ?>
                        <?= form_input(['name'=>'resMobile','value'=>$res_mobile,'class'=>'form-control','id'=>'edit_resMobile','placeholder'=>'Mobile Number','pattern'=>'[0-9]{0,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
                    </div>
                </div>
            </div>
        </fieldset>  
	 </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearbox();">Close</button>
        <button type="button" class="btn btn-primary" onclick="editressubmitrefile();">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php 

$refiling= $this->session->userdata('refiling_no');
$rowd= $this->efiling_model->data_list_where('table_defecttabopen','filing_no',$refiling);
if(!empty($rowd) && is_array($rowd)){
	 $numbers=explode(',',$rowd[0]->tabvals);
            $numbers = array_diff($numbers, [0]);
    //$numbers=json_decode($rowd[0]->tabvals);
    sort($numbers);
    $arrlength=count($numbers);
    $vals=array();
    for($x=0;$x<$arrlength;$x++){
        $vals[]=  $numbers[$x] ;
    }
    
    $num='2';
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
        $urlv="applicant-mod";
    }
    if($valrr==2){
          $urlv="respondentRefile";
    }
    if($valrr==3){
         $urlv="counselrefile";
    }
	if($valrr==4){
        $urlv="basicdetails-mod";
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
function editressubmitrefile(){
	var id=$('#id').val();
	var resName=$('#edit_resName').val();
	var resPhone=$('#edit_resPhone').val();
	var degingnationRes='';//$('#edit_degingnationRes').val();
	var resEmail=$('#edit_resEmail').val();
	var resAddress=$('#edit_resAddress').val();
	var respincode=$('#edit_respincode').val();
	var resFax=$('#edit_resFax').val();
	var resMobile=$('#edit_resMobile').val();
	var edittype=$('#edittype').val();	
	if(resMobile==''){
		$.alert({
			title: '<i class="fa fa-check-circle text-danger"></i>&nbsp;</b>Error</b>',
			content: '<p class="text-danger">Please Enter mobile number.</p>',
			animationSpeed: 0
		});
		return fasle;
	}
	if(resEmail==''){
		$.alert({
			title: '<i class="fa fa-check-circle text-danger"></i>&nbsp;</b>Error</b>',
			content: '<p class="text-danger">Please Enter email Address.</p>',
			animationSpeed: 0
		});
		return fasle;
	}
	var ddistrictname=$('#edit_ddistrictname').val();
	var ddistrictres=$('#edit_ddistrictres').val();
	var resstatename=$('#edit_resstatename').val();
	var stateRes=$('#edit_stateRes').val();
	var dataa={};
    dataa['id']=id;
    dataa['resName']=resName;
    dataa['resstatename']=resstatename;
    dataa['resPhone']=resPhone;
    dataa['degingnationRes']=degingnationRes;
    dataa['ddistrictres']=ddistrictres;
    dataa['resEmail']=resEmail;
    dataa['resAddress']=resAddress;
    dataa['respincode']=respincode;
    dataa['resFax']=resFax;
    dataa['resMobile']=resMobile;
    dataa['ddistrictname']=ddistrictname;
    dataa['stateRes']=stateRes;
    dataa['token']='<?php echo $token; ?>';
    dataa['edittype']=edittype;
	$.ajax({
        type: "POST",
        url: base_url+"editSubmitRespondentrefile",
        data: dataa,
        cache: false,
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
        		$('#addmorerecordapp').html(resp.display);
        		$.alert({
					title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Done</b>',
					content: '<p class="text-success">Record update successfully.</p>',
					animationSpeed: 0
				});
				$('#exampleModal').delay(1000).modal('hide');
			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}





function editPartyrefile(id,app,type){
	var dataa={};
    dataa['id']=id;
    dataa['app']=app;
    dataa['type']=type;
    dataa['token']='<?php echo $token; ?>';
	$.ajax({
        type: "POST",
        url: base_url+"getRespondentrefile",
        data: dataa,
        cache: false,
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp) {
        		var stateid=resp.state;
                var districtid=resp.dist;

        		$("#edit_stateRes option[value='"+resp.state+"']").attr("selected","selected");
        		$('#editresorgid').val(resp.party_id);
        		$('#edit_resName').val(resp.pet_name);
        		//$('#edit_degingnationRes').val(resp.pet_degingnation);
        		$('#edit_ddistrictname').val(resp.pet_dis);
        		$('#edit_resEmail').val(resp.pet_email);
        		$('#edit_resFax').val(resp.pet_fax);
        		$('#edit_resMobile').val(resp.pet_mobile);
            	$('#edit_respincode').val(resp.pet_name);
            	$('#edit_resPhone').val(resp.pet_phone);
            	$('#edit_respincode').val(resp.pin_code);
            	$('#action').val(resp.action);
            	$('#id').val(resp.id);
            	$('#edit_resAddress').val(resp.pet_address);
            	$('#edittype').val(resp.type);
            	$('#edit_resstatename').val(resp.state);
            	$('#edit_ddistrictres').val(resp.dist);
            	showCityselectededit(stateid,districtid);

			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}



function showUserAppResEditrefile(str) {
    var dataa = {};
    dataa['q'] = str;
    $.ajax({
        type: "POST",
        url: base_url+'orgderefile',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
             console.log(data1);
             var data2 = JSON.parse(data1);
             if (str != 0) {
                 document.getElementById("editresorgid").value = data2[0].orgid;
                 document.getElementById("edit_resName").value = data2[0].org_name;
                 document.getElementById("edit_resAddress").value = data2[0].address;
                 document.getElementById("edit_resMobile").value = data2[0].mob;
                 document.getElementById("edit_resEmail").value = data2[0].mail;
                 document.getElementById("edit_resPhone").value = data2[0].ph;
                 document.getElementById("edit_respincode").value = data2[0].pin;
                 document.getElementById("edit_resFax").value = data2[0].fax;
                 document.getElementById("edit_stateRes").value = data2[0].stcode;
                 document.getElementById("edit_ddistrictres").value = data2[0].dcode;
                 document.getElementById("edit_ddistrictname").value = data2[0].dname;
                 //document.getElementById("edit_degingnationRes").value = data2[0].desg;
                 document.getElementById("edit_resstatename").value = data2[0].stname;
             }
        },
        error: function(){
			$.alert('Error : server busy, try later');
		},
		complete: function(){
			document.getElementById("loading_modal").style.display = 'none';
			$('#loading_modal').modal('hide');
			$('#regnum_autofillEdit').hide();
		}
    });
}





function clearbox(){
	$('#edit_petName').val();
	$("#edit_degingnation").empty();
	$("#edit_petdistrictname").empty();
	$("#edit_petEmail").empty();
	$("#edit_petFax").empty();
	$("#edit_petmobile").empty();
	$("#edit_pincode").empty();
	$("#edit_petPhone").empty();
	$("#edit_petstatename").empty();
	$("#edit_pincode").empty();
	$("#action").empty();
	$("#id").empty();
	$("#edit_petAddress").empty();
	$("#edittype").empty();
}












$('#res_respndent').submit(function(e){
	e.preventDefault();
    var orgres='';
    var checkboxes = document.getElementsByName('orgres');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
        	orgres = checkboxes[i].value;
        }
    }
    var salt = document.getElementById("saltNo").value;
    var totalNoRespondent = Number(document.getElementById("totalNoRespondent").value);
    var tabno= document.getElementById("tabno").value;
    var count= document.getElementById("count").value;
    if(count=='0'){
       alert("Please add respondent !");
       return false;
    }
    var dataa = {};
    dataa['salt']=  salt;
    dataa['totalNoRespondent'] =totalNoRespondent;
    dataa['tabno']=tabno;
    dataa['token']='<?php echo $token; ?>';
		$.ajax({
		    dataType: 'json',
	        type: "POST",
	        url: base_url+'respondentSubmitrefile',
	        data: dataa,
	        cache: false,
			beforeSend: function(){
				$('#ressub').prop('disabled',true).val("Under proccess....");
			},
	        success: function (resp) {
	        	if(resp.data=='success') {
	        		setTimeout(function(){
	                    window.location.href = base_url+'<?php echo $urlv; ?>';
	                 }, 250);
				}
				else if(resp.error != '0') {
					$.alert(resp.error);
				}
	        },
	        error: function(){
				$.alert("Server busy,try later.");
			},
			complete: function(){
				$('#ressub').prop('disabled',false).val("Submit");
			}
		});
});






function orgshowres() {
    var checkboxes = document.getElementsByName('orgres');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            idorg = checkboxes[i].value;
        }
    }
}


function showUserAppRes(str) {
    var dataa = {};
    dataa['q'] = str;
    $.ajax({
        type: "POST",
        url: base_url+'orgde',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
            $('#regnum_autofill').hide();
             var data2 = JSON.parse(data1);
             if (str != 0) {
            	 var stateid=data2[0].stcode;
                 var districtid=data2[0].dcode;
                 $("#ddistrictname option[value='"+data2[0].dcode+"']").attr("selected","selected");
                 document.getElementById("resName").value = data2[0].org_name;
            	 document.getElementById("resorgid").value = data2[0].orgid;
                 document.getElementById("resAddress").value = data2[0].address;
                 document.getElementById("resMobile").value = data2[0].mob;
                 document.getElementById("resEmail").value = data2[0].mail;
                 document.getElementById("resPhone").value = data2[0].ph;
                 document.getElementById("respincode").value = data2[0].pin;
                 document.getElementById("resFax").value = data2[0].fax;
                 document.getElementById("stateRes").value = data2[0].stcode;
                 document.getElementById("ddistrictres").value = data2[0].dcode;
                // document.getElementById("ddistrictname").value = data2[0].dname;
                // document.getElementById("degingnationRes").value = data2[0].desg;
                 document.getElementById("resstatename").value = data2[0].stname;
                 showCityselected(stateid,districtid);
             }
        },
        error: function(){
			$.alert('Error : server busy, try later');
		},
		complete: function(){
			$('#regnum_autofill').hide();
			//$('#loading_modal').modal('hide');
		}
    });
}

function showCityselected(sid,did) {
    var dataa = {};
    dataa['stateid'] = sid;
    dataa['districtid'] = did;
    $.ajax({
        type: "POST",
        url: base_url+"districtselected",
        data: dataa,
        cache: false,
        success: function (districtdata) {
            result = JSON.parse(districtdata);
            //$("input[name='"+_CSRF_NAME_+"']").val(result.csrf_token);
            var List = result.dtls;
            $("#ddistrictname").html(List);
           // $("#ddistrictname").html(districtdata);
        }
    });
}


function showCityselectededit(sid,did) {
    var dataa = {};
    dataa['stateid'] = sid;
    dataa['districtid'] = did;
    $.ajax({
        type: "POST",
        url: base_url+"districtselected",
        data: dataa,
        cache: false,
        success: function (response) {
			result = JSON.parse(response);
			list=result.dtls;
            $("#edit_ddistrictname").html(list);
        }
    });
}





function deletePartyrefile(e, ee) {
    var count = document.getElementById("count").value;
    var partyid = e;
    var party = ee;
    var salt = document.getElementById("saltNo").value;
    var dataa = {};
	dataa['id'] =partyid,
	dataa['party'] =party,
	dataa['salt'] =salt,
	$.ajax({
        type: "POST",
        url: base_url+'deletePartyrefile',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#deletesubmit').prop('enabled',true).val("Under proccess....");
		},
        success: function (resp) {
            if(count!=''){
        	   var val=Number(count)-1;
        	   $('#count').val(val);
            }
    		$('#addmorerecordapp').html(resp);
        },
        error: function(){
			$.alert("Server busy,try later.");
		},
		complete: function(){
			$('#nextsubmit').prop('enabled',false).val("Add More respondent");
		}
	 });
}

function showCityRes(sel) {
    var state_id = sel.options[sel.selectedIndex].value;
    if (state_id.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url+"district",
            data: "state_id=" + state_id,
            cache: false,
            success: function (districtdata) {
                $("#ddistrictres").html(districtdata);
            }
        });
    }
}



function showCityval(sel) {
    var state_id = sel.options[sel.selectedIndex].value;
    if (state_id.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url+"district",
            data: "state_id=" + state_id,
            cache: false,
            success: function (response) {
                //$("#ddistrictname").html(districtdata);
                result = JSON.parse(response);
                //$("input[name='"+_CSRF_NAME_+"']").val(result.csrf_token);
                var List = result.dtls;
                $("#ddistrictname").html(List);
            }
        });
    }
}

function showCityvaledit(sel) {
    var state_id = sel.options[sel.selectedIndex].value;
    if (state_id.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url+"district",
            data: "state_id=" + state_id,
            cache: false,
            success: function (response) {
                result = JSON.parse(response);
                var List = result.dtls;
                $("#edit_ddistrictname").html(List);
            }
        });
    }
}

function showCityvaledit(sel) {
    var state_id = sel.options[sel.selectedIndex].value;
    if (state_id.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url+"district",
            data: "state_id=" + state_id,
            cache: false,
            success: function (response) {
                result = JSON.parse(response);
                var List = result.dtls;
                $("#edit_ddistrictname").html(List);
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


function serchrecordvalapp(val){
    var data={};
    data['key'] = val;
    data[_CSRF_NAME_]=$("input[name='"+_CSRF_NAME_+"']").val();
	$.ajax({
		type: 'post',
		url: base_url+'getRespondentName',
		data:data,
		dataType: 'html',
		cache: false,
		beforeSend: function(){
		 	//$('#loading_modal').modal();
		},
		success: function(response){
            result = JSON.parse(response);
            $("input[name='"+_CSRF_NAME_+"']").val(result.csrf_token);
            var List = result.dtls;
            $('#regnum_autofill').show();
            $('#regnum_autofill').html(List);


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


function serchrecordvalappedit(val){
	$.ajax({
		type: 'post',
		url: base_url+'getRespondentNameEdit',
		data: {key:val},
		dataType: 'html',
		cache: false,
		beforeSend: function(){
		 	//$('#loading_modal').modal();
		},
		success: function(retn){
		    $('#regnum_autofillEdit').show();
			$('#regnum_autofillEdit').html(retn);

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



function addMoreResRefile() {
    var salt = document.getElementById("saltNo").value;
    var orgid = document.getElementById("resorgid").value;
    var resName = document.getElementById("resName").value;
    var degingnationRes = '';//document.getElementById("degingnationRes").value;
    var resAddress = document.getElementById("resAddress").value;
    var resState = document.getElementById("stateRes").value;
    var resDis = document.getElementById("ddistrictres").value;
    var respincode = document.getElementById("respincode").value;
    var resMobile = document.getElementById("resMobile").value;
    var resPhone = document.getElementById("resPhone").value;
    var resEmail = document.getElementById("resEmail").value;
    var resFax = document.getElementById("resFax").value;
    var count = document.getElementById("count").value;
    var tabno= document.getElementById("tabno").value;
    var totalNoRespondent = Number(document.getElementById("totalNoRespondent").value);
    var token= '<?php echo $token; ?>';
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
    dataa['org']=org,
	dataa['orgid']=orgid,
	dataa['token']=token,

	$.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreResrefile',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#nextsubmit').prop('enabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		var val=parseInt(count)+1;
        		$('#addmorerecordapp').html(resp.display);
        		$('#count').val(val);
				$("#resName").val("");
				//$("#degingnationRes").val("");
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
					animationSpeed: 0
				}); 
			}
			else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Server busy,try later.");
		},
		complete: function(){
			$('#nextsubmit').prop('enabled',false).val("Add More Respondent");
		}
	 }); 
}   
</script>
<?php $this->load->view("admin/footer"); ?>