<?php 
 $salt=$this->session->userdata('salt');
 $app= $filedcase;
 ?>
<?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'res_respndent','autocomplete'=>'off']) ?>
       <?= form_fieldset('Additopnal Party Details').'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>

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
                <?= form_textarea(['name'=>'pet_address','value'=>$asddress,'id'=>'pet_address','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'Address','maxlength'=>'400','title'=>'Address Of Appellant allowed only alphanumeric ']) ?>
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

<?= form_fieldset_close(); ?>
<?= form_close();?>