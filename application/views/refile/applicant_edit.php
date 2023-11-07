<?php
$this->load->view("admin/header"); 
$this->load->view("admin/sidebar");
$token= $this->efiling_model->getToken();
 defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script> 
<?php      $this->load->view("admin/stepsrefile"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>

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
                <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'petitioner_detail','autocomplete'=>'off']) ?>
    	<div class="content clearfix">
        <?php 
        $userdata=$this->session->userdata('login_success');
    	$user_id=$userdata[0]->id;
        $salt=$this->session->userdata('refiling_no'); 
        $ptype2='';
        $app= $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$salt);
        if(!empty($app)){
             $ptype1='';
             $ptype= $app[0]->pet_type;
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
            <?= form_fieldset('Appellants <div class="date-div text-success date">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>').
            '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>'.
            '<div class="date-div text-success date d-none">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
            ?>

            <div class="row alert alert-warning" style="">
                <div class="col-md-12">
                    <label class="text-dark mr-2"><b>Select Mode :</b></label>


                    <label for="org" class="form-check-label font-weight-semibold">
                        <?= form_radio(['name'=>'org','id'=>"bd1" ,'value'=>'1','onclick'=>'orgshow();','checked'=>@$ptype1]); ?>
                        Department&nbsp;&nbsp;
                    </label>
                    <label for="indv" class="form-check-label font-weight-semibold">
                        <?= form_radio(['name'=>'org','id'=>'po1' ,'value'=>'2' ,'onclick'=>'orgshow();','checked'=>$ptype2]); ?>
                        Assesse&nbsp;&nbsp;
                    </label>
                    <label for="inp" class="form-check-label font-weight-semibold">
                    </label>
                </div>
            </div>
            <?php 
            $no_of_app= isset($app[0]->no_of_app)?$app[0]->no_of_app:''; 
            $noapplant= isset($app[0]->noapplent)?$app[0]->noapplent:''; 
            $appname=isset($app[0]->pet_name)?$app[0]->pet_name:''; 
            if($no_of_app=='' && $noapplant){
                $no_of_app=$noapplant;
            }
            
            $array=array('filing_no'=>$salt,'party_flag'=>'1');
            $additionalparty=$this->efiling_model->data_list_mulwhere('additional_party',$array);
            $val=0;
            if($appname!=''){
                $val='1';
            }
            $count= count($additionalparty)+$val;
            ?>
            <input type="hidden"  id="tabno"  name="tabno" value="<?php echo '2'; ?>">
			<input type="hidden" id="saltNo"  name="saltNo" value="<?php echo $salt; ?>">
			<input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
			<input type="hidden" name="count"  id="count" value="<?php echo isset($count)?$count:'0'; ?>">
			<input type="hidden" name="action" id="action" value="add">
			<input type="hidden" name="petstatename" value="" id="petstatename" class="txt">
            <!------------------------Organisation Name-------------------->                  
            	 <div class="row">
                    <div class="col-md-4">
                         <div class="form-card">
                              <div class="form-group">
                              	<label class="control-label" for="totalNoAppellants"><span class="custom"><font color="red">*</font></span>No. of Applicant(s):</label>
                              <div class="input-group mb-3 mb-md-0">
                              <?= form_input(['name'=>'totalNoAppellants','class'=>'form-control','onkeypress'=>'return isNumberKey(event)','id'=>'totalNoAppellants','value'=>$count,'placeholder'=>'Total No Appellants','pattern'=>'[0-9]{1,2}','maxlength'=>'2','title'=>'Total No Appellants should be numeric only.']) ?>
                              </div>
                            </div>
                        </div>
                	</div>
                </div>
            
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group required">
                            <label>Name<span class="text-danger">*</span></label>
                            <input type="hidden" name="orgid" value="" id="orgid" class="txt">
                            <input type="text" name="petName" value="" id=petName  class="form-control" onkeypress="serchrecordvalapp(this.value);">
                    		<ul class="autosuggest" id="regnum_autofill">
                        		
                    		</ul>
                            <div class="col-md-9" id="recordadv"></div>
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group required">
                            <label>State Name :<span class="text-danger">*</span></label>
                           <?php 
                          $petstatenamev=$app[0]->pet_state;
                          $petstatenamev=  $this->efiling_model->data_list_where('master_psstatus','state_code',$petstatenamev);
                          $state= $this->efiling_model->data_list('master_psstatus');
                          $state1[]='- Please Select state-';
                          foreach ($state as $val)
                              $state1[$val->state_code] = $val->state_name;  
                              echo form_dropdown('dstate',$state1,'',['class'=>'form-control','onchange'=>"showCity(this);" ,'id'=>'dstate']);  ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Phone Number:</label>
                            <?php  $petphone='';//$app[0]->petphone; ?>
                            <?= form_input(['name'=>'petPhone','id'=>"petPhone",'onkeypress'=>'return isNumberKey(event)','value'=>$petphone,'class'=>'form-control','placeholder'=>' ','maxlength'=>'10', 'pattern'=>'[0-9]{0,10}', 'title'=>'Phone allowed only numeric']) ?>
                        </div>
                    </div>
            	</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group required">
                            <label>Designation:</label>               
                	        <?php  $pet_degingnation='';//$app[0]->pet_degingnation; ?>
                            <?= form_input(['name'=>'degingnation','value'=>$pet_degingnation,'class'=>'form-control','id'=>'degingnation','placeholder'=>'','maxlength'=>'200','title'=>'Designation only alphanumeric ']) ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group required">
                            <input type="hidden" name="petdistrictname" value="<?php  echo $app[0]->pet_dist; ?>" id="petdistrictname" class="txt">
                            <label>District:<span class="text-danger">*</span></label>                    
                	        <?php   $petdis= '';// $this->efiling_model->data_list_where('master_psdist','district_code',$app[0]->pet_dist);
                               $city1[]='- Please Select city-';
                               echo form_dropdown('ddistrict',$city1,$petdis,['class'=>'form-control','id'=>'ddistrict']);  ?>
                        </div>
                    </div>
             
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><span class="custom"><font color="red">*</font></span>Email ID:</label>
                             <?php  $pet_Email=='';//$app[0]->pet_email; ?>
                            <?= form_input(['name'=>'petEmail','class'=>'form-control','value'=>$pet_Email,'id'=>'petEmail','placeholder'=>'']) ?>
                        </div>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group required">
                            <label>Address:</label>
                             <?php  $asddress=='';//$app[0]->pet_address; ?>
                            <?= form_textarea(['name'=>'petAddress','value'=>$asddress,'id'=>'petAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'','maxlength'=>'400','title'=>'Address Of Appellant allowed only alphanumeric ']) ?>
                        </div>
                    </div>
                   
                    <div class="col-md-4">
                        <div class="form-group required">
                            <label>Pincode</label>
                                <?php  $pincode=='';//$app[0]->pincode; ?>
                                <?= form_input(['name'=>'pincode','value'=>$pincode,'class'=>'form-control', 'onkeypress'=>'return isNumberKey(event)','id'=>'pincode','placeholder'=>'','pattern'=>'[0-9 ]{0,6}','maxlength'=>'200','title'=>'Pincode info allowed only alphanumeric ']) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group required">
                            <label>Fax No:</label>
                             <?php  $pet_fax=='';//$app[0]->pet_fax; ?>
                             <?= form_input(['name'=>'petFax','value'=>$pet_fax,'class'=>'form-control', 'onkeypress'=>'return isNumberKey(event)', 'id'=>'petFax','placeholder'=>'','maxlength'=>'200','title'=>'petFax info allowed only alphanumeric ']) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group required">
                            <label><font color="red">*</font></span>Mobile</label>
                            <?php  $petmobile=='';//$app[0]->petmobile; ?>
                            <?= form_input(['name'=>'petmobile','value'=>$petmobile,'class'=>'form-control', 'onkeypress'=>'return isNumberKey(event)','id'=>'petmobile','placeholder'=>'','pattern'=>'[0-9]{10,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
                        </div>
                    </div>
                </div>
                <input type="button" id="nextsubmit" value="Add Appellant" class="btn btn-primary btn-cntr" onclick="addMoreAppRefile();">
        </fieldset>  
			
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
        <div class="row m-0">
            <div class="card w-100 mt-5 inner-card">
                <?php
                echo form_fieldset('Added Appellants List').
                    '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 21px 6px;"></i>'; ?>


                <div class="d-block text-center text-warning mx-3">
                            <div class="table-responsive text-secondary" id="add_petitioner_list">
                                <span class="fa fa-spinner fa-spin fa-3x" style="display:none"></span>
                                <table id="addmorerecordapp" class="table display" border="1" width="100%">
                                    <thead>
                                        <tr class="bg-dark">
                                            <th>Sr. No. </th>
                                            <th>Appellant Name</th>
                                            
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php

                                    $salt=$this->session->userdata('refiling_no'); 

                                    $vals=$this->efiling_model->data_list_where($schemas.'.case_detail','filing_no',$salt);
                                    if(@$vals[0]->pet_name!=''){
                                        $petName=$vals[0]->pet_name;
                                        if (is_numeric($vals[0]->pet_name)) {
                                            $orgname=$this->efiling_model->data_list_where('org_name_master','org_code',$vals[0]->pet_name);
                                            $petName=$orgname[0]->org_name;
                                        }
                                    ?>
                                        <tr style="color:green">
                                            <td>1</td>
                                            <td><?php echo $petName; ?>(A-1)</td>
                                            
                                            <td><?php echo isset($vals[0]->pet_mobile)?$vals[0]->pet_mobile:'' ?></td>
                                            <td><?php echo $vals[0]->pet_email ?></td>
                                            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"   data-toggle="modal" data-target="#exampleModal"  onclick="editPartyrefile('<?php echo $vals[0]->filing_no; ?>','appleant','main')"></td>
                                            <td></td>
                                        </tr>
                                    <?php } 
                                    
                                    $array=array('filing_no'=>$salt,'party_flag'=>'P');
                                    $additionalparty=$this->efiling_model->data_list_mulwhere($schemas.'.additional_party_detail',$array);


                                    $i=2;
                                    if(!empty($additionalparty)){
                                        foreach($additionalparty as $val){


                                        ?>
                                        <tr>
                                        <td><?php echo $i; ?></td>
                                            <td><?php echo $val->name; ?>(A-<?php echo $i; ?>)</td>

                                            <td> <?php echo $val->pet_mobile ?></td>
                                            <td><?php echo $val->pet_email ?></td>
                                            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"   data-toggle="modal" data-target="#exampleModal"  onclick="editPartyrefile('<?php echo $val->party_serial_no; ?>','appleant','add')"></td>
                                            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger"   onclick="deletePartyrefile('<?php echo $val->party_serial_no; ?>','appleant')"></td>
                                        </tr>
                                        <?php 
                                        $i++;
                                        }
                                    }else{
                                        $val= "<span style='color:Red'>Reccord Not found";
                                    }
                                         ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                <?php  echo form_fieldset_close();
                ?>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-8 col-md-4 text-right" id="add">
            	<?php
        		echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>';
                if((int)$salt > 0)
                    echo form_submit(['value'=>'Save & Next','class'=>'btn btn-success btnSave','id'=>'petitioner_save','style'=>'padding-left:24px;']).'<i class="icon-trash-alt" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>';
                else 
                    echo form_submit(['value'=>'Save & Next','class'=>'btn btn-success btnSave','id'=>'petitioner_save','style'=>'padding-left:24px;','disabled'=>'disabled']).'<i class="icon-trash-alt" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>';
        
        		echo form_reset(['value'=>'Reset/Clear','class'=>'btn btn-danger','style'=>'padding-left: 24px;']);
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














<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog model-lg" role="document" style="margin-top: 190px;">
    <div class="modal-content" style="width: 1050px; margin-left: -194px;">
      <div class="modal-header bg-warning">
        <h4 class="modal-title" id="exampleModalLabel">Edit Appellant </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearbox();">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	 <fieldset id="jurisdiction" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Appellant Details</legend>
	        <input type="hidden" name="id" id="id" value="">
	        <input type="hidden" name="edittype" id="edittype" value="">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Name<span class="text-danger">*</span></label>
                        <input type="hidden" name="editorgid" value="" id="editorgid" class="txt">
                        <input type="text" name="edit_petName" value="" id=edit_petName  class="form-control" onkeypress="serchrecordvalappedit(this.value);">
                		<ul class="autosuggest" id="regnum_autofillEdit">
                		</ul>
                    </div>
                </div>
                
                
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>State Name :<span class="text-danger">*</span></label>
                        <input type="hidden" name="petstatename" value="" id="edit_petstatename" class="txt">
                           <?php 
                        $petstatenamev=$app[0]->pet_state;
                        $petstatenamev=  $this->efiling_model->data_list_where('master_psstatus','state_code',$petstatenamev);
                        ?>
                      <?php 
                      $state= $this->efiling_model->data_list('master_psstatus');
                      $state1[]='- Please Select state-';
                      foreach ($state as $val)
                          $state1[$val->state_code] = $val->state_name;  
                          echo form_dropdown('dstate',$state1,$app[0]->pet_state,['class'=>'form-control','onchange'=>"showCityedit(this);" ,'id'=>'edit_dstate']);  ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone Number:</label>
                        <?php  $petphone=$app[0]->petphone; ?>
                        <?= form_input(['name'=>'petPhone','id'=>"edit_petPhone",'value'=>$petphone,'class'=>'form-control','placeholder'=>'Pet Phone ','maxlength'=>'11', 'pattern'=>'[0-9]{0,10}', 'title'=>'Phone allowed only numeric']) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--div class="col-md-4">
                    <div class="form-group required">
                        <label>Designation:</label>
            	       <?php  //$pet_degingnation=$app[0]->pet_degingnation; ?>
                        <?php// form_input(['name'=>'degingnation','value'=>$pet_degingnation,'class'=>'form-control','id'=>'edit_degingnation','placeholder'=>'Designation','maxlength'=>'200','title'=>'Designation only alphanumeric ']) ?>
                    </div>
                </div-->
                
                
                <div class="col-md-4">
                    <input type="hidden" name="petdistrictname" value="" id="edit_petdistrictname" class="txt">
                    <div class="form-group required">
                        <label>District:<span class="text-danger">*</span></label>             
            	        <?php   $petdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$app[0]->pet_dist);  ?>
                           <?php  
                           $city1[]='- Please Select city-';
                           echo form_dropdown('ddistrict',$city1,$petdis,['class'=>'form-control','id'=>'edit_ddistrict']);  ?>
                    </div>
                </div>
        
   
                   
                <div class="col-md-4">
                    <div class="form-group">
                        <label><span class="custom"><font color="red">*</font></span>Email ID:</label>
                        <?php  $pet_Email=$app[0]->pet_email; ?>
                        <?= form_input(['name'=>'petEmail','class'=>'form-control','value'=>$pet_Email,'id'=>'edit_petEmail','placeholder'=>'Email']) ?>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Address:</label>
                         <?php  $asddress=$app[0]->pet_address; ?>
                        <?= form_textarea(['name'=>'petAddress','value'=>$asddress,'id'=>'edit_petAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'Address ','maxlength'=>'400','title'=>'Address Of Appellant allowed only alphanumeric ']) ?>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Pincode</label>
                            <?php  $pincode=$app[0]->pincode; ?>
                            <?= form_input(['name'=>'pincode','value'=>$pincode,'class'=>'form-control','id'=>'edit_pincode','placeholder'=>'Pincode Info','pattern'=>'[0-9 ]{0,6}','maxlength'=>'200','title'=>'Pincode info allowed only alphanumeric ']) ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group required">
                        <label>Fax No:</label>
                         <?php  $pet_fax=$app[0]->pet_fax; ?>
                         <?= form_input(['name'=>'petFax','value'=>$pet_fax,'class'=>'form-control','id'=>'edit_petFax','placeholder'=>'Pet Fax Info','maxlength'=>'200','title'=>'petFax info allowed only alphanumeric ']) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group required">
                        <label><font color="red">*</font></span>Mobile</label>
                        <?php  $petmobile=$app[0]->petmobile; ?>
                        <?= form_input(['name'=>'petmobile','value'=>$petmobile,'class'=>'form-control','id'=>'edit_petmobile','placeholder'=>'Mobile Number','pattern'=>'[0-9]{10,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
                    </div>
                </div>
            </div>
        </fieldset>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearbox();">Close</button>
        <button type="button" class="btn btn-primary" onclick="editappsubmitRefile();">Save changes</button>
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
    
    $num='1';
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
function editappsubmitRefile(){
	var id=$('#id').val();
	var petName=$('#edit_petName').val();
	var petstatename=$('#edit_petstatename').val();
	var petPhone=$('#edit_petPhone').val();
	var degingnation=$('#edit_degingnation').val();
	var petdistrictname=$('#edit_petdistrictname').val();
	var petEmail=$('#edit_petEmail').val();
	var petAddress=$('#edit_petAddress').val();
	var pincode=$('#edit_pincode').val();
	var petFax=$('#edit_petFax').val();
	var petmobile=$('#edit_petmobile').val();
	var ddistrict=$('#edit_ddistrict').val();
	var dstate=$('#edit_dstate').val();
	var edittype=$('#edittype').val();
	
	var dataa={};
    dataa['id']=id;
    dataa['petName']=petName;
    dataa['petstatename']=petstatename;
    dataa['petPhone']=petPhone;
    dataa['degingnation']=degingnation;
    dataa['petdistrictname']=petdistrictname;
    dataa['petEmail']=petEmail;
    dataa['petAddress']=petAddress;
    dataa['pincode']=pincode;
    dataa['petFax']=petFax;
    dataa['petmobile']=petmobile; 
    dataa['ddistrict']=ddistrict;
    dataa['dstate']=dstate;  
    dataa['token']='<?php echo $token; ?>';
    dataa['edittype']=edittype;
	$.ajax({
        type: "POST",
        url: base_url+"editSubmitApplentRefile",
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
        },
        complete: function (request, error) {
			$('#exampleModal').model(hide);
        }
    });
}



function editPartyrefile(id,app,type){
	var dataa={};
	var saltNo=$('#saltNo').val();
    dataa['id']=id;
    dataa['app']=app;
    dataa['type']=type;
    dataa['token']='<?php echo $token; ?>';
    dataa['salt']=saltNo;
	$.ajax({
        type: "POST",
        url: base_url+"getApplantRefile",
        data: dataa,
        cache: false,
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp) {	
        		var stateid= resp.stateid;
           	    var districtid= resp.disid;
        		$("#edit_dstate option[value='"+resp.stateid+"']").attr("selected","selected");
        		$("#edit_ddistrict option[value='"+resp.disid+"']").attr("selected","selected");
        		$('#edit_petName').val(resp.pet_name);
        		$('#edit_degingnation').val(resp.pet_degingnation);
        		$('#edit_petdistrictname').val(resp.pet_dis);
        		$('#edit_petEmail').val(resp.pet_email);
        		$('#edit_petFax').val(resp.pet_fax);
        		$('#edit_petmobile').val(resp.pet_mobile);
            	$('#edit_pincode').val(resp.pet_name);
            	$('#edit_petPhone').val(resp.pet_phone);
            	$('#edit_petstatename').val(resp.pet_state);
            	$('#edit_pincode').val(resp.pin_code);
            	$('#action').val(resp.action);
            	$('#id').val(resp.id);
            	$('#editorgid').val(resp.party_id);
            	$('#edit_petAddress').val(resp.pet_address);
            	$('#edittype').val(resp.type);
            	showCityselectededit(stateid,districtid);
			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}

function showCityedit(sel) {
    var state_id = sel.options[sel.selectedIndex].value;
    if (state_id.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url+"district",
            data: "state_id=" + state_id,
            cache: false,
            success: function (response) {
				result = JSON.parse(response);
                //$("input[name='"+_CSRF_NAME_+"']").val(result.csrf_token);
                var List = result.dtls;
				
                $("#edit_ddistrict").html(List);
            }
        });
    }
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
			var List = result.dtls;
            $("#edit_ddistrict").html(List);
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




$('#petitioner_detail').submit(function(e){ 
	e.preventDefault();
	var salt = $("#saltNo").val();
    var tabno = document.getElementById("tabno").value;
    var totalNoAppellants = Number(document.getElementById("totalNoAppellants").value);
    var count = Number(document.getElementById("count").value);
    if(count=='0'){
       alert("Please add applicant !");
       return false;
    }
    var val=totalNoAppellants;
    var org='';
    var checkboxes = document.getElementsByName('org');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            org = checkboxes[i].value;
        }
    } 
    var dataa = {};
	dataa['no_of_app']=totalNoAppellants;
	dataa['salt'] = salt,
	dataa['tab_no']=tabno,
	dataa['user_id']='<?= $user_id ?>',
	dataa['table_name']='aptel_case_detail';
	dataa['partyType']=org;
	$.ajax({
        type: "POST",
        url: base_url+'saveNextRefile',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#petitioner_save').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	var resp = JSON.parse(resp);
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
			$.alert("Surver busy,try later.");
		},
		complete: function(){
			$('#petitioner_save').prop('disabled',false).val("Submit");
		}
	 }); 
});

function showUserApp(str) {
    var dataa = {};
    dataa['q'] = str;
    $.ajax({
        type: "POST",
        url: base_url+'orgde',
        data: dataa,
        cache: false,
        success: function (petSection) {
            $('#regnum_autofill').hide();
        	 var data1 = petSection;
             var data2 = JSON.parse(data1);
             if (str != 0) {
            	 var stateid= data2[0].stcode;
            	 var districtid= data2[0].dcode;
            	 $("#dstate option[value='"+data2[0].stcode+"']").attr("selected","selected");
            	 $("#ddistrict option[value='"+data2[0].dcode+"']").attr("selected","selected");
            	 document.getElementById("petName").value = data2[0].org_name;
            	 document.getElementById("orgid").value = data2[0].orgid; 
            	 document.getElementById("petstatename").value = data2[0].stname;
                 document.getElementById("petdistrictname").value = data2[0].dname;
                 document.getElementById("petAddress").value = data2[0].address;
                 document.getElementById("petmobile").value = data2[0].mob;
                 document.getElementById("petEmail").value = data2[0].mail;
                 document.getElementById("petPhone").value = data2[0].ph;
                 document.getElementById("pincode").value = data2[0].pin;
                 document.getElementById("petFax").value = data2[0].fax;
                 document.getElementById("dstate").value = data2[0].stcode;
                 document.getElementById("ddistrict").value = data2[0].dcode;
                 document.getElementById("degingnation").value = data2[0].desg;
                 //$("#edit_dstate").val(response.state);
                // showCityselected(stateid,districtid);
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
            $("#ddistrict").html(districtdata);
        }
    });
}




function showUserAppedit(str) {
    var dataa = {};
    dataa['q'] = str;
    $.ajax({
        type: "POST",
        url: base_url+'orgde',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
             //console.log(data1);
            $('#regnum_autofillEdit').hide();
             var data2 = JSON.parse(data1);
             if (str != 0) {  
                 document.getElementById("edit_petName").value = data2[0].org_name;
                 document.getElementById("editorgid").value = data2[0].orgid;
                 document.getElementById("edit_petAddress").value = data2[0].address;
                 document.getElementById("edit_petmobile").value = data2[0].mob;
                 document.getElementById("edit_petEmail").value = data2[0].mail;
                 document.getElementById("edit_petPhone").value = data2[0].ph;
                 document.getElementById("edit_pincode").value = data2[0].pin;
                 document.getElementById("edit_petFax").value = data2[0].fax;
                 document.getElementById("edit_dstate").value = data2[0].stcode;
                 document.getElementById("edit_petstatename").value = data2[0].stname;
                 document.getElementById("edit_ddistrict").value = data2[0].dcode;
                 document.getElementById("edit_petdistrictname").value = data2[0].dname;
                 document.getElementById("edit_degingnation").value = data2[0].desg;
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


function showUser(str) {
	var dataa = {};
	dataa['q'] = str;
    if (str == '0') {
        document.getElementById("counselAdd").value = "";
        document.getElementById("counselMobile").value = "";
        document.getElementById("counselEmail").value = "";
        document.getElementById("counselPhone").value = "";
        document.getElementById("counselPin").value = "";
        document.getElementById("counselFax").value = "";
        document.getElementById("cdstate").value = "";
        document.getElementById("dstatename").value = "";
        document.getElementById("cddistrict").value = "";
        document.getElementById("ddistrictname").value = "";
    }
    $.ajax({
        type: "POST",
        url: base_url+'getAdvDetail',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
             console.log(data1);
             var data2 = JSON.parse(data1);
             if (str != 0) {
                document.getElementById("counselAdd").value = data2[0].address;
                document.getElementById("counselMobile").value = data2[0].mob;
                document.getElementById("counselEmail").value = data2[0].mail;
                document.getElementById("counselPhone").value = data2[0].ph;
                document.getElementById("counselPin").value = data2[0].pin;
                document.getElementById("counselFax").value = data2[0].fax;
                document.getElementById("cdstate").value = data2[0].stcode;
                document.getElementById("dstatename").value = data2[0].stname;
                document.getElementById("cddistrict").value = data2[0].dcode;
                document.getElementById("ddistrictname").value = data2[0].dname;
             }
        }
    });
}

$(document).on('click','.remove',function() {
    $.ajax({
        url : base_url+'/filing/'+$(this).attr("data-target"),
        type : 'POST',data : {"id":+this.id},
        beforeSend: function(){ $("body").addClass("loading");},
        success : function(response) {     },
        complete: function(){$("body").removeClass("loading");}
    });
    $(this).closest('tr').remove();
});

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
        url: base_url+'deletePartyRefile',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#deletesubmit').prop('enabled',true).val("Under proccess....");
		},
        success: function (resp) {
            var val  =count-1;
    		$('#addmorerecordapp').html(resp);
		    $('#count').val(val);
		    $('#totalNoAppellants').val(val);
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
			$('#nextsubmit').prop('enabled',false).val("Add More Appellant");
		}
	 }); 
}   


function showCity(sel) {
    var state_id = sel.options[sel.selectedIndex].value;
    if (state_id.length > 0) {
        $.ajax({
            type: "POST",
            url: base_url+"district",
            data: "state_id=" + state_id,
            cache: false,
            success: function (districtdata) {
                $("#ddistrict").html(districtdata);
            }
        });
    }
}

$(document).ready(function() {
    $(document).on("click","#regnum_autofill li",function() {
      //  alert($(this).attr('value'));
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
		success: function(response){
			result = JSON.parse(response);
			list=result.dtls;
		    $('#regnum_autofill').show();
			$('#regnum_autofill').html(list);
		 	
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
		url: base_url+'getApplantNameEdit',
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

function addMoreAppRefile() {
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
	if(petmobile.length!='10'){
		alert("Please enter correct mobile number !");
		return false;
	}
    var count = document.getElementById("count").value;
    var totalNoAppellants = Number(document.getElementById("totalNoAppellants").value); 
    if(totalNoAppellants==''){
    	alert("Please Enter total No Appellants");
    	return false;
    }
    var val=totalNoAppellants;
    if(count >= val){
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
        alert("Please Enter Org / Appellant Name ");
        document.filing.petName.focus();
        return false;
    }
    if(petmobile==''){
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
    var org='';
    var checkboxes = document.getElementsByName('org');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            org = checkboxes[i].value;
        }
    }
	if(org=='1'){
		if(orgid==''){
			alert("Please select Appllant !");
        	document.filing.orgid.focus();
        	return false;
		}
	}
    var dataa = {};
	dataa['patname'] =petName,
	dataa['petAdv'] =petAddress,
	dataa['pin'] =pincode,
	dataa['petMob'] = petmobile,
	dataa['petph'] =  petPhone,
	dataa['petemail'] =petEmail,
	dataa['petfax'] =  petFax,
	dataa['cadd'] = counselAdd,
	dataa['cpin'] =  counselPin,
	dataa['cmob'] = counselMobile,
	dataa['cemail'] =  counselEmail,
	dataa['cfax'] = counselFax,
	dataa['salt'] = salt,
	dataa['petdeg'] = degingnation,
	dataa['counselpho'] = counselPhone,
	dataa['dstate'] = dstate,
	dataa['ddistrict'] = ddistrict,
	dataa['councilCode'] =  councilCode,
	dataa['totalNoAppellants']=totalNoAppellants;
	dataa['tabno']=tabno;
	dataa['org']=org;
	dataa['orgid']=orgid;
	dataa['token']='<?php echo $token; ?>';
	$.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreAppellantRefile',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#nextsubmit').prop('enabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
				var val=Number(count)+1;
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
					animationSpeed: 0
				}); 
				$('.btnSave').removeAttr('disabled');           		
			}
			else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
			$('#nextsubmit').prop('enabled',false).val("Add More Appellant");
		}
	 }); 
}






function validateEmail(email) {
var re =/^[a-z_A-Z\-0-9\.\*\#\$\!\~\%\^\&\-\+\?\|]+@+[a-zA-Z\-0-9]+(.com)$/;  
return re.test(email); 
}

</script>
<?php $this->load->view("admin/footer"); ?>