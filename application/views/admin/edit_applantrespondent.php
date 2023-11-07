<?php 
 $salt=$this->session->userdata('salt');
 $app= $filedcase;
 ?>
<?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'res_respndent','autocomplete'=>'off']) ?>
       <?= form_fieldset('Appellant').'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>
<legend class="customlavelsub">Organisation Details</legend>
     <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Org Name<span class="text-danger">*</span></label>
                 <?php
                 $pet_name=$app[0]->pet_id;
                 $orgname= $this->efiling_model->data_list('master_org');
                 $orgname1[]='- Please Select state-';
                 foreach ($orgname as $val)
                     $orgname1[$val->org_id] = $val->orgdisp_name; 
                     echo form_dropdown('select_org_app',$orgname1,$pet_name,['class'=>'form-control','onchange'=>"apple_org_details(this.value)",'id'=>'select_org_app','required'=>'true']); 
                ?>
            </div>
        </div>
    </div>        
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pet Name<span class="text-danger">*</span></label>
                 <?=  form_input(['name'=>'pet_name','class'=>'form-control','value'=>$pet_Email,'id'=>'pet_name','placeholder'=>'pet name']) ; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>State Name <span class="text-danger">*</span></label>
                <?php 
                $petstatenamev=$app[0]->pet_state;
                $petstatenamev=  $this->efiling_model->data_list_where('master_psstatus','state_code',$petstatenamev);
                ?>
                <input type="hidden" name="dstate" value="<?php echo $petstatenamev[0]->state_code; ?>" id="dstate" class="txt">
                <?= form_input(['name'=>'pet_state','value'=>$petstatenamev[0]->state_name,'class'=>'form-control','id'=>'pet_state','placeholder'=>'pet state name','required'=>'true','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'State allowed only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone Number:</label>
                <?php  $petphone=$app[0]->petphone; ?>
                <?= form_input(['name'=>'pet_phone','id'=>"pet_phone",'value'=>$petphone,'class'=>'form-control','placeholder'=>'Pet Phone ','maxlength'=>'200', 'pattern'=>'[0-9]{0,10}', 'title'=>'Phone allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Designation:</label>
    	         <?php  $pet_degingnation=$app[0]->pet_degingnation; ?>
                <?= form_input(['name'=>'pet_degingnation','value'=>$pet_degingnation,'class'=>'form-control','id'=>'pet_degingnation','placeholder'=>'Designation','maxlength'=>'200','title'=>'Designation only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span></label>
                <input type="hidden" name="ddistrict" value="<?php  echo $app[0]->pet_dist; ?>" id="ddistrict" class="txt">
    	        <?php   $petdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$app[0]->pet_dist);  ?>
                <?= form_input(['name'=>'pet_district','value'=>$petdis[0]->district_name,'class'=>'form-control','id'=>'pet_district','placeholder'=>'District','required'=>'true','pattern'=>'[A-Za-z0-9 ]{0,200}', 'maxlength'=>'200','title'=>'District allowed only alphanumeric ']) ?>
            </div>
        </div>
           
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:</label>
                 <?php  $pet_Email=$app[0]->pet_email; ?>
                <?= form_input(['name'=>'pet_email','class'=>'form-control','value'=>$pet_Email,'id'=>'pet_email','placeholder'=>'Email']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address:</label>
                 <?php  $asddress=$app[0]->pet_address; ?>
                <?= form_textarea(['name'=>'pet_address','value'=>$asddress,'id'=>'pet_address','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'Address ','maxlength'=>'400','title'=>'Address Of Appellant allowed only alphanumeric ']) ?>
            </div>
        </div>
       
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode</label>
                    <?php  $pincode=$app[0]->pincode; ?>
                    <?= form_input(['name'=>'pet_pin','value'=>$pincode,'class'=>'form-control','id'=>'pet_pin','placeholder'=>'Pincode Info','pattern'=>'[0-9 ]{0,6}','maxlength'=>'200','title'=>'Pincode info allowed only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                 <?php  $pet_fax=$app[0]->pet_fax; ?>
                 <?= form_input(['name'=>'pet_fax','value'=>$pet_fax,'class'=>'form-control','id'=>'pet_fax','placeholder'=>'Pet Fax Info','maxlength'=>'200','title'=>'petFax info allowed only alphanumeric ']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pet Mobile</label>
                <?php  $petmobile=$app[0]->petmobile; ?>
                <?= form_input(['name'=>'pet_mobile','value'=>$petmobile,'class'=>'form-control','id'=>'pet_mobile','placeholder'=>'Mobile Number','pattern'=>'[0-9]{10,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
            </div>
        </div>
    </div>
<!------------------------council Name-------------------->
<legend class="customlavelsub">Counsel Details</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label><span class="text-danger">*</span>Name :</label>
             <?php
             $pet_council_adv=$app[0]->pet_council_adv; 
             $councilname= $this->efiling_model->data_list('master_advocate');
             $councilname1[]='- Please Select state-';
             foreach ($councilname as $val)
                 $councilname1[$val->adv_code] = $val->adv_name; 
                 echo form_dropdown('pet_adv',$councilname1,$pet_council_adv,['class'=>'form-control','onchange'=>'showUserOrg(this.value)', 'id'=>'pet_adv','required'=>'true','required'=>'true']); 
                ?>
            </div>
        </div>
       <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode:</label>
                    <?php  $counsel_pin= $app[0]->counsel_pin; ?>
                <?= form_input(['name'=>'pet_counsel_pin','value'=>$counsel_pin,'class'=>'form-control','id'=>'pet_counsel_pin','placeholder'=>'Counsel Pin','maxlength'=>'200','title'=>'Counsel Pin allowed only alphanumeric ']) ?>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:</label>
                <?php  $counsel_email= $app[0]->counsel_email; ?>
                <?= form_input(['name'=>'pet_counsel_email','value'=>$counsel_email,'class'=>'form-control','id'=>'pet_counsel_email','placeholder'=>'Counsel Email','maxlength'=>'200','title'=>'Counsel Email allowed only alphanumeric ']) ?>
            </div>
        </div>
        
      
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Counsel:</label>
                <?php  $counsel_add= $app[0]->counsel_add; ?>
                <?= form_textarea(['name'=>'pet_counsel_address','value'=>$counsel_add, 'class'=>'form-control','id'=>'pet_counsel_address','rows' => '2','cols'=>'2','placeholder'=>'Counsel Address','maxlength'=>'200','title'=>' Counsel Add only alphanumeric ']) ?>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group required">
                <label>Mobile Number:</label>
                 <?php  $counsel_mobile= $app[0]->counsel_mobile; ?>                                
				<?= form_input(['name'=>'pet_counsel_mobile','value'=>$counsel_mobile,'class'=>'form-control', 'id'=>'pet_counsel_mobile', 'placeholder'=>'Mobile No','pattern'=>'[0-9]{1,12}','maxlength'=>'200','title'=>' Counsel Mobile Number should be numeric only.']) ?>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                 <?php  $counsel_fax= $app[0]->counsel_fax; ?>       
                <?= form_input(['name'=>'pet_counsel_fax','value'=>$counsel_fax,'class'=>'form-control','id'=>'pet_counsel_fax','placeholder'=>'Fax No','pattern'=>'[0-9]{1,12}','maxlength'=>'200','title'=>' Counsel Fax No should be numeric only.']) ?>
            </div>
        </div>
    </div>
     <div class="row">
         <div class="col-md-4">
            <div class="form-group required">
                <label>Phone Number:</label>
                 <?php  $counsel_phone= $app[0]->counsel_phone; ?>
                <?= form_input(['name'=>'pet_counsel_phone','value'=>$counsel_phone,'class'=>'form-control','id'=>'pet_counsel_phone','placeholder'=>'Counsel Phone','pattern'=>'[0-9]{1,12}','maxlength'=>'10','title'=>'Counsel Phone should be numeric only.']) ?>
            </div>
        </div>
    </div>
<?= form_fieldset_close(); ?>
<?= form_fieldset('Respondant').'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>
 <legend class="customlavelsub">Organisation Details</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Respondent Name:<span class="text-danger">*</span></label>
                 <?php
                 $orgname= $this->efiling_model->data_list('master_org');
                 $orgname1[]='- Please Select Org-';
                 foreach ($orgname as $val)
                     $orgname1[$val->org_id] = $val->orgdisp_name; 
                     echo form_dropdown('resName',$orgname1,'',['class'=>'form-control','onchange'=>"showUserAppRes(this.value)",'id'=>'resName','required'=>'true']); 
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
                     echo form_dropdown('stateRes',$state1,'',['class'=>'form-control','onchange'=>"",'id'=>'stateRes','required'=>'true']); 
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone Number:</label>
                <?= form_input(['name'=>'resPhone','id'=>"resPhone",'class'=>'form-control','placeholder'=>'Res Phone ','pattern'=>'[0-9 ]{0,6}','maxlength'=>'10','title'=>'Phone allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Designation:</label>
                <?= form_input(['name'=>'degingnationRes','class'=>'form-control','id'=>'degingnationRes','placeholder'=>'Designation','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'Designation only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span></label>
                <input type="hidden" name="ddistrictres" id="ddistrictres" class="txt" value="">
                <?= form_input(['name'=>'resdistrictname','class'=>'form-control','id'=>'resdistrictname','placeholder'=>'District','required'=>'true','pattern'=>'[A-Za-z0-9 ]{0,200}','maxlength'=>'200','title'=>'District allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:</label>
                <?= form_input(['name'=>'resEmail','class'=>'form-control','id'=>'resEmail','placeholder'=>'Email','pattern'=>'[.-@A-Za-z0-9]{1,200}','maxlength'=>'200','title'=>'Email allowed only alphanumeric']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Appellant:</label>
                <?= form_textarea(['name'=>'resAddress','id'=>'resAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'Address','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'Address Of Appellant allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode</label>
                <?= form_input(['name'=>'respincode','class'=>'form-control','id'=>'respincode','placeholder'=>'Pincode Info','pattern'=>'[0-9]{0,6}','maxlength'=>'6','title'=>'Pincode info allowed only numeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                 <?= form_input(['name'=>'resFax','class'=>'form-control','id'=>'resFax','placeholder'=>'Pet Fax Info','pattern'=>'[0-9 ]{0,12}','maxlength'=>'12','title'=>'petFax info allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Res mobile</label>
                <?= form_input(['name'=>'resMobile','class'=>'form-control','id'=>'resMobile','placeholder'=>'Mobile Number','pattern'=>'[0-9]{10,10}','maxlength'=>'12','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
            </div>
        </div>
    </div>
<!------------------------council Name-------------------->
 <legend class="customlavelsub">Counsel Details</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Counsel Name :<span class="text-danger">*</span></label>
             <?php
             $councilname= $this->efiling_model->data_list('master_advocate');
             $councilname1[]='- Please Select state-';
             foreach ($councilname as $val)
                 $councilname1[$val->adv_code] = $val->adv_name. '(' . $val->adv_reg . ')'; 
                 echo form_dropdown('councilCodeRes',$councilname1,NULL,['class'=>'form-control','onchange'=>'showUserOrg(this.value)', 'id'=>'councilCodeRes','required'=>'true','required'=>'true']); 
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span> </label>   
                <input type="hidden" name="rddistrict" readonly="" id="rddistrict" class="txt" maxlength="50" value="">                              
				<?= form_input(['name'=>'rddistrictname','class'=>'form-control','id'=>'rddistrictname','placeholder'=>'rddistrictname','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'100','title'=>'District Name should be Alfa numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Phone Number:</label>
                <?= form_input(['name'=>'resCounselphone','class'=>'form-control','id'=>'resCounselphone','placeholder'=>'Counsel Phone','pattern'=>'[0-9]{10,10}$','maxlength'=>'10','title'=>'Counsel Phone should be numeric only.']) ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Counsel:</label>
                <?= form_textarea(['name'=>'resCounseladdress','class'=>'form-control','id'=>'resCounseladdress','rows' => '2','cols'=>'2','placeholder'=>'Counsel Address','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>' Counsel Add only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode:</label>
                <?= form_input(['name'=>'resCounselpincode','class'=>'form-control','id'=>'resCounselpincode','placeholder'=>'Counsel Pin','pattern'=>'[0-9]{0,6}$','maxlength'=>'7','title'=>'Counsel Pin allowed only alphanumeric']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:</label>
                <?= form_input(['name'=>'resCounselEmail','class'=>'form-control','id'=>'resCounselEmail','placeholder'=>'Counsel Email','pattern'=>'[.-@A-Za-z0-9]{4,200}','maxlength'=>'200','title'=>'Counsel Email allowed only alphanumeric']) ?>
            </div>
        </div>
    </div>
   
     <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>State Name  : <span class="text-danger">*</span></label>
                <input type="hidden" name="rdstate" readonly="" id="rdstate" class="txt" maxlength="50" value="">
             <?= form_input(['name'=>'rdstatename','class'=>'form-control','id'=>'rdstatename', 'placeholder'=>'State name','pattern'=>'[A-Za-z0-9]{1,200}','maxlength'=>'200','title'=>' Counsel state name should be alphanumeric.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Mobile Number:</label>                                    
				<?= form_input(['name'=>'resCounselMobile','class'=>'form-control', 'id'=>'resCounselMobile', 'placeholder'=>'Mobile No','pattern'=>'[0-9]{10,10}$','maxlength'=>'10','title'=>' Counsel Mobile Number should be numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                <?= form_input(['name'=>'resCounselFax','class'=>'form-control','id'=>'resCounselFax','placeholder'=>'Fax No','pattern'=>'[0-9]{0,11}$','maxlength'=>'11','title'=>' Counsel Fax No should be numeric only.']) ?>
            </div>
        </div>
    </div>
<?= form_fieldset_close(); ?>
<?= form_close();?>