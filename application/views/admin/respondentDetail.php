 <?php
 $salt=$this->session->userdata('salt');
 //$res= $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt); 
 ?>
 
 <fieldset id="jurisdiction" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Respondent Details</legend>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Respondent Name:<span class="text-danger">*</span></label>
                 <?= form_input(['name'=>'resName','value'=>$res[0]->resname,'class'=>'form-control','id'=>'resName','placeholder'=>'Res name','maxlength'=>'200','title'=>'res allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>State Name :<span class="text-danger">*</span></label>
              <?php 
              $state= $this->efiling_model->data_list('master_psstatus');
              $state1[]='- Please Select state-';
              foreach ($state as $val)
                  $state1[$val->state_code] = $val->state_name;  
                  echo form_dropdown('stateRes',$state1,$res[0]->res_state,['class'=>'form-control','onchange'=>"showCityRes(this);" ,'id'=>'stateRes']);  ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone Number:</label>
                <?= form_input(['name'=>'resPhone','id'=>"resPhone",'value'=>$resphone,'class'=>'form-control','placeholder'=>'res Phone ','pattern'=>'[0-9]{0,10}','maxlength'=>'10','title'=>'Phone allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Designation:</label>
                <?= form_input(['name'=>'degingnationRes','value'=>$res_degingnation,'class'=>'form-control','id'=>'degingnationRes','placeholder'=>'Designation','maxlength'=>'200','title'=>'Designation only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span></label>
                <?php  $res_dis=$res[0]->res_dis;
                   
                   $city1[]='- Please Select city-';
                   echo form_dropdown('ddistrictres',$city1,$res_dis,['class'=>'form-control','id'=>'ddistrictres']);  ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:<span class="text-danger">*</span></label>
                <?= form_input(['name'=>'resEmail','value'=>$res_email,'class'=>'form-control','id'=>'resEmail','placeholder'=>'Email','maxlength'=>'200','title'=>'Email allowed only alphanumeric']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address:</label>
                <?= form_textarea(['name'=>'resAddress','value'=>$res_address,'id'=>'resAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'Address Of Appellant','maxlength'=>'200','title'=>'Address Of Appellant allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode:</label>
                <?= form_input(['name'=>'respincode','value'=>$res_pin,'class'=>'form-control','id'=>'respincode','placeholder'=>'Pincode Info','maxlength'=>'6','title'=>'Pincode info allowed only numeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                 <?= form_input(['name'=>'resFax','value'=>$res_fax,'class'=>'form-control','id'=>'resFax','placeholder'=>'Pet Fax Info','maxlength'=>'10','title'=>'petFax info allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Mobile Number:</label>
                <?= form_input(['name'=>'resMobile','value'=>$res_mobile,'class'=>'form-control','id'=>'resMobile','placeholder'=>'Mobile Number','pattern'=>'[0-9]{0,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
            </div>
        </div>
    </div>
<input type="button" name="nextsubmit" id="nextsubmit" value="Add Respondent" class="btn btn-primary btn-md" onclick="addMoreRes();">
</fieldset>  
<!------------------------council Name-------------------->
<!---<fieldset id="condetail" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Counsel Details</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Counsel Name :<span class="text-danger">*</span></label>
             <?php
             $res_council_adv=$res[0]->res_council_adv;
             $councilname= $this->efiling_model->data_list('master_advocate');
             $councilname1[]='- Please Select state-';
             foreach ($councilname as $val)
                 $councilname1[$val->adv_code] = $val->adv_name;  
                 echo form_dropdown('councilCodeRes',$councilname1,$res_council_adv,['class'=>'form-control', 'id'=>'councilCodeRes','onchange'=>'showUserRes(this.value)']); 
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span></label>       
               <?php  $res_dis=$res[0]->res_dis; ?>
                <input type="hidden" name="rddistrict" id="rddistrict" class="txt" value="<?php echo  $res_dis; ?>">
                 <?php   $resdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$res_dis);  ?>                               
				<?= form_input(['name'=>'rddistrictname','value'=>$resdis[0]->district_name,'class'=>'form-control','id'=>'rddistrictname','placeholder'=>'ddistrictname','maxlength'=>'100','title'=>'District Name should be Alfa numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Phone Number:</label>
                 <?php  $counsel_phone=$res[0]->counsel_phone; ?>
                <?= form_input(['name'=>'resCounselphone','value'=>$counsel_phone,'class'=>'form-control','id'=>'resCounselphone','placeholder'=>'Counsel Phone','maxlength'=>'10','title'=>'Counsel Phone should be numeric only.']) ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Counsel:</label>
                  <?php  $res_counsel_address=$res[0]->res_counsel_address; ?>
                <?= form_textarea(['name'=>'resCounseladdress','value'=>$res_counsel_address,'class'=>'form-control','id'=>'resCounseladdress','rows' => '2','cols'=>'2','placeholder'=>'Counsel Address','maxlength'=>'200','title'=>' Counsel Add only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode:</label>
                <?php  $res_counsel_pin=$res[0]->res_counsel_pin; ?>
                <?= form_input(['name'=>'resCounselpincode','value'=>$res_counsel_pin,'class'=>'form-control','id'=>'resCounselpincode','placeholder'=>'Counsel Pin','pattern'=>'[0-9]{0,6}','maxlength'=>'6','title'=>'Counsel Pin allowed only numeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:</label>
                <?php  $res_counsel_email=$res[0]->res_counsel_email; ?>
                <?= form_input(['name'=>'resCounselEmail','value'=>$res_counsel_email,'class'=>'form-control','id'=>'resCounselEmail','placeholder'=>'Counsel Email','maxlength'=>'200','title'=>'Counsel Email allowed only alphanumeric']) ?>
            </div>
        </div>
    </div>
    
    
     <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>State Name  :<span class="text-danger">*</span></label>
                 <?php   
              $statecode= $res[0]->res_state; 
               $cstate=  $this->efiling_model->data_list_where('master_psstatus','state_code',$statecode); 
                ?>
                <input type="hidden" name="rdstate"  id="rdstate" class="txt" maxlength="50" value="<?php echo $statecode; ?>">
             <?= form_input(['name'=>'rdstatename','class'=>'form-control','value'=>$cstate[0]->state_name,'id'=>'rdstatename', 'placeholder'=>'State name','maxlength'=>'200','title'=>' Counsel District name should be alphanumeric.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Mobile Number:</label>   
                 <?php  $res_counsel_mob=$res[0]->res_counsel_mob; ?>                                   
				<?= form_input(['name'=>'resCounselMobile','value'=>$res_counsel_mob,'class'=>'form-control', 'id'=>'resCounselMobile', 'placeholder'=>'Mobile No','maxlength'=>'12','title'=>' Counsel Mobile Number should be numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                  <?php  $res_counsel_fax=$res[0]->res_counsel_fax; ?>  
                <?= form_input(['name'=>'resCounselFax','value'=>$res_counsel_fax,'class'=>'form-control','id'=>'resCounselFax','placeholder'=>'Fax No','maxlength'=>'12','title'=>' Counsel Fax No should be numeric only.']) ?>
            </div>
        </div>
    </div>
</fieldset>-->
