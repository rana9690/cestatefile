 <?php 
    $salt=$this->session->userdata('salt');
    //$app= $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
 ?>
 <fieldset id="jurisdiction" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Organisation Details</legend>
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
                     echo form_dropdown('petName',$orgname1,$pet_name,['class'=>'form-control','onchange'=>"showUserApp(this.value)",'id'=>'petName']); 
                ?>
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
                <?= form_input(['name'=>'petstatename','value'=>$petstatenamev[0]->state_name,'class'=>'form-control','id'=>'petstatename','placeholder'=>'pet state name','pattern'=>'[A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'State allowed only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone Number:</label>
                <?php  $petphone=$app[0]->petphone; ?>
                <?= form_input(['name'=>'petPhone','id'=>"petPhone",'value'=>$petphone,'class'=>'form-control','placeholder'=>'Pet Phone ','maxlength'=>'200', 'pattern'=>'[0-9]{0,10}', 'title'=>'Phone allowed only numeric']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Designation:</label>
               
    	           <?php  $pet_degingnation=$app[0]->pet_degingnation; ?>
                <?= form_input(['name'=>'degingnation','value'=>$pet_degingnation,'class'=>'form-control','id'=>'degingnation','placeholder'=>'Designation','maxlength'=>'200','title'=>'Designation only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>District:<span class="text-danger">*</span></label>
                <input type="hidden" name="ddistrict" value="<?php  echo $app[0]->pet_dist; ?>" id="ddistrict" class="txt">
    	        <?php   $petdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$app[0]->pet_dist);  ?>
                <?= form_input(['name'=>'petdistrictname','value'=>$petdis[0]->district_name,'class'=>'form-control','id'=>'petdistrictname','placeholder'=>'District','pattern'=>'[A-Za-z0-9 ]{0,200}', 'maxlength'=>'200','title'=>'District allowed only alphanumeric ']) ?>
            </div>
        </div>
           
        <div class="col-md-4">
            <div class="form-group">
                <label><span class="custom"><font color="red">*</font></span>Email ID:</label>
                 <?php  $pet_Email=$app[0]->pet_email; ?>
                <?= form_input(['name'=>'petEmail','class'=>'form-control','value'=>$pet_Email,'id'=>'petEmail','placeholder'=>'Email']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Appellant:</label>
                 <?php  $asddress=$app[0]->pet_address; ?>
                <?= form_textarea(['name'=>'petAddress','value'=>$asddress,'id'=>'petAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'Address Of Appellant','maxlength'=>'400','title'=>'Address Of Appellant allowed only alphanumeric ']) ?>
            </div>
        </div>
       
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode</label>
                    <?php  $pincode=$app[0]->pincode; ?>
                    <?= form_input(['name'=>'pincode','value'=>$pincode,'class'=>'form-control','id'=>'pincode','placeholder'=>'Pincode Info','pattern'=>'[0-9 ]{0,6}','maxlength'=>'200','title'=>'Pincode info allowed only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                 <?php  $pet_fax=$app[0]->pet_fax; ?>
                 <?= form_input(['name'=>'petFax','value'=>$pet_fax,'class'=>'form-control','id'=>'petFax','placeholder'=>'Pet Fax Info','maxlength'=>'200','title'=>'petFax info allowed only alphanumeric ']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label><font color="red">*</font></span>Pet Mobile</label>
                <?php  $petmobile=$app[0]->petmobile; ?>
                <?= form_input(['name'=>'petmobile','value'=>$petmobile,'class'=>'form-control','id'=>'petmobile','placeholder'=>'Mobile Number','pattern'=>'[0-9]{10,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
            </div>
        </div>
    </div>
</fieldset>  

<input type="button" id="nextsubmit" value="Add Appellant" class="btn btn-primary" onclick="addMoreApp();">