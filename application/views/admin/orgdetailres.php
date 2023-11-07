 <script>
$(document).ready(function() {
	showUserAppRes();
	showUserOrg();
});
</script>
 <?php
  $salt=$this->session->userdata('salt');
  //$res= $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt); 

 ?>
 
 
 <fieldset id="jurisdiction" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Organisation Details</legend>   
                                    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Name:<span class="text-danger">*</span></label>
                 <?php
                 $orgname= $this->efiling_model->data_list('master_org');
                 $orgname1[]='- Please Select Org-';
                 foreach ($orgname as $val)
                     $orgname1[$val->org_id] = $val->orgdisp_name; 
                     echo form_dropdown('resName',$orgname1,$res[0]->resname,['class'=>'form-control','onchange'=>"showUserAppRes(this.value)",'id'=>'resName']); 
                ?>
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
                     echo form_dropdown('stateRes',$state1,$res[0]->res_state,['class'=>'form-control','onchange'=>"",'id'=>'stateRes','value'=>'']); 
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone Number:</label>
                   <?php  $resphone=$res[0]->res_phone; ?>
                <?= form_input(['name'=>'resPhone','value'=>$resphone,'id'=>"resPhone",'onkeypress'=>'return isNumberKey(event)','class'=>'form-control','placeholder'=>'','pattern'=>'[0-9]{0,15}','maxlength'=>'15','title'=>'Phone allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Designation:</label>
                <?php  $res_degingnation=$res[0]->res_degingnation; ?>
                <?= form_input(['name'=>'degingnationRes','value'=>$res_degingnation,'class'=>'form-control','id'=>'degingnationRes','placeholder'=>'','maxlength'=>'200','title'=>'Designation only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span></label>
                <?php  $res_dis=$res[0]->res_dis; ?>
                <input type="hidden" name="ddistrictres" id="ddistrictres" class="txt" value="<?php echo  $res_dis; ?>">
                 <?php   $resdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$res_dis);  ?>
                <?= form_input(['name'=>'ddistrictname','value'=>$resdis[0]->district_name,'class'=>'form-control','id'=>'ddistrictname','placeholder'=>'','pattern'=>'[A-Za-z0-9 ]{0,200}','maxlength'=>'200','title'=>'District allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:<span class="text-danger">*</span></label>
                   <?php  $res_email=$res[0]->res_email; ?>
                <?= form_input(['name'=>'resEmail','value'=>$res_email,'class'=>'form-control','id'=>'resEmail','placeholder'=>'','pattern'=>'[.-@A-Za-z0-9]{1,200}','maxlength'=>'200','title'=>'Email allowed only alphanumeric']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address:</label>
                 <?php  $res_address=$res[0]->res_address; ?>
                <?= form_textarea(['name'=>'resAddress','value'=>$res_address,'id'=>'resAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'Address Of Appellant allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode</label>
                  <?php  $res_pin=$res[0]->res_pin; ?>
                <?= form_input(['name'=>'respincode','value'=>$res_pin,'class'=>'form-control','id'=>'respincode','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)','pattern'=>'[0-9]{0,6}','maxlength'=>'6','title'=>'Pincode info allowed only numeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                <?php  $res_fax=$res[0]->res_fax; ?>
                 <?= form_input(['name'=>'resFax','value'=>$res_fax,'class'=>'form-control','id'=>'resFax','placeholder'=>'', 'onkeypress'=>'return isNumberKey(event)','pattern'=>'[0-9 ]{0,12}','maxlength'=>'12','title'=>'petFax info allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Mobile<span class="text-danger">*</span></label>
                  <?php  $res_mobile=$res[0]->res_mobile; ?>
                <?= form_input(['name'=>'resMobile','value'=>$res_mobile,'class'=>'form-control','id'=>'resMobile','onkeypress'=>'return isNumberKey(event)','placeholder'=>'','pattern'=>'[0-9]{0,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
            </div>
        </div>
    </div>
</fieldset>  
<!------------------------council Name-------------------->
<!--<fieldset id="condetail" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Counsel Details</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Counsel Name :<span class="text-danger">*</span></label>
                <?php  
                $res_council_adv=$res[0]->res_council_adv;
             $councilname= $this->efiling_model->data_list('master_advocate');
             $councilname1[]='- Please Select state-';
             foreach ($councilname as $val)
                 $councilname1[$val->adv_code] = $val->adv_name. '(' . $val->adv_reg . ')'; 
                 echo form_dropdown('councilCodeRes',$councilname1,$res_council_adv,['class'=>'form-control','onchange'=>'showUserOrg(this.value)', 'id'=>'councilCodeRes']); 
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span> </label>  
                <?php  $res_dis=$res[0]->res_dis; ?>
                <?php  $resdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$res_dis);  ?>   
                <input type="hidden" name="rddistrict" readonly="" id="rddistrict" class="txt" maxlength="50" value="<?php echo $res_dis; ?>">                              
				<?= form_input(['name'=>'rddistrictname','value'=>$resdis[0]->district_name,'class'=>'form-control','id'=>'rddistrictname','placeholder'=>'','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'100','title'=>'District Name should be Alfa numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Phone Number:</label>
                <?php  $counsel_phone=$res[0]->counsel_phone; ?>
                <?= form_input(['name'=>'resCounselphone','value'=>$counsel_phone,'class'=>'form-control','id'=>'resCounselphone','placeholder'=>'','pattern'=>'[0-9]{0,15}$','maxlength'=>'15','title'=>'Counsel Phone should be numeric only.']) ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Counsel:</label>
                   <?php  $res_counsel_address=$res[0]->res_counsel_address; ?>
                <?= form_textarea(['name'=>'resCounseladdress','value'=>$res_counsel_address,'class'=>'form-control','id'=>'resCounseladdress','rows' => '2','cols'=>'2','placeholder'=>'','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>' Counsel Add only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode:</label>
                <?php  $res_counsel_pin=$res[0]->res_counsel_pin; ?>
                <?= form_input(['name'=>'resCounselpincode','value'=>$res_counsel_pin,'class'=>'form-control','id'=>'resCounselpincode','placeholder'=>'','pattern'=>'[0-9]{0,6}$','maxlength'=>'7','title'=>'Counsel Pin allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:</label>
                <?php  $res_counsel_email=$res[0]->res_counsel_email; ?>
                <?= form_input(['name'=>'resCounselEmail','value'=>$res_counsel_email,'class'=>'form-control','id'=>'resCounselEmail','placeholder'=>'','pattern'=>'[.-@A-Za-z0-9]{4,200}','maxlength'=>'200','title'=>'Counsel Email allowed only alphanumeric']) ?>
            </div>
        </div>
    </div>
   
     <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>State Name  : <span class="text-danger">*</span></label>
              <?php   
              $statecode= $res[0]->res_state; 
               $cstate=  $this->efiling_model->data_list_where('master_psstatus','state_code',$statecode); 
                ?>
                <input type="hidden" name="rdstate" readonly="" id="rdstate" class="txt" maxlength="50" value="<?php echo  $statecode;?>">
             <?= form_input(['name'=>'rdstatename','value'=>$cstate[0]->state_name,'class'=>'form-control','id'=>'rdstatename', 'placeholder'=>'','maxlength'=>'200','title'=>' Counsel state name should be alphanumeric.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Mobile Number:</label>    
                 <?php  $res_counsel_mob=$res[0]->res_counsel_mob; ?>                                
				<?= form_input(['name'=>'resCounselMobile','value'=>$res_counsel_mob,'class'=>'form-control', 'id'=>'resCounselMobile', 'placeholder'=>'','pattern'=>'[0-9]{10,10}$','maxlength'=>'10','title'=>' Counsel Mobile Number should be numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                 <?php  $res_counsel_fax=$res[0]->res_counsel_fax; ?>  
                <?= form_input(['name'=>'resCounselFax','value'=>$res_counsel_fax,'class'=>'form-control','id'=>'resCounselFax','placeholder'=>'','maxlength'=>'11','title'=>' Counsel Fax No should be numeric only.']) ?>
            </div>
        </div>
    </div>
</fieldset>--------->
<input type="button" name="nextsubmit" id="nextsubmit" value="Add Respondent" class="btn btn-primary btn-md" onclick="addMoreRes();">