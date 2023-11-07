  <?php 
    $salt=$this->session->userdata('salt');
    //$app= $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
 ?>
 <fieldset id="jurisdiction" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Appellant Details</legend>
   
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Appellant Name:<span class="text-danger">*</span></label>
                 <?= form_input(['name'=>'petName','value'=> $pet_name=$app[0]->pet_name,'class'=>'form-control','id'=>'petName','placeholder'=>'petName name','maxlength'=>'200','title'=>'State allowed only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>State Name :<span class="text-danger">*</span></label>
                   <?php 
                $petstatenamev=$app[0]->pet_state;
                $petstatenamev=  $this->efiling_model->data_list_where('master_psstatus','state_code',$petstatenamev);
                ?>
              <?php 
              $state= $this->efiling_model->data_list('master_psstatus');
              $state1[]='- Please Select state-';
              foreach ($state as $val)
                  $state1[$val->state_code] = $val->state_name;  
                  echo form_dropdown('dstate',$state1,$app[0]->pet_state,['class'=>'form-control','onchange'=>"showCity(this);" ,'id'=>'dstate']);  ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Phone Number:</label>
                <?php  $petphone=$app[0]->petphone; ?>
                <?= form_input(['name'=>'petPhone','value'=>$petphone,'id'=>"petPhone",'class'=>'form-control','placeholder'=>'Pet Phone ','pattern'=>'[0-9]{0,12}','maxlength'=>'12','title'=>'Phone allowed only numeric ']) ?>
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
                    
    	        <?php   $petdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$app[0]->pet_dist);  ?>
    	        
                   <?php  
                   $city1[]='- Please Select city-';
                   echo form_dropdown('ddistrict',$city1,$petdis,['class'=>'form-control','id'=>'ddistrict']);  ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label><span class="custom"><font color="red">*</font></span>Email ID:</label>
                    <?php  $pet_Email=$app[0]->pet_email; ?>
                <?= form_input(['name'=>'petEmail','value'=>$pet_Email,'class'=>'form-control','id'=>'petEmail','placeholder'=>'Email','type'=>'email']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Appellant:</label>
                <?php  $asddress=$app[0]->pet_address; ?>
                <?= form_textarea(['name'=>'petAddress','value'=>$asddress,'id'=>'petAddress','class'=>'form-control','rows' => '2','cols'=>'2','placeholder'=>'Address Of Appellant','maxlength'=>'200','title'=>'Address Of Appellant allowed only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode:</label>
                  <?php  $pincode=$app[0]->pincode; ?>
                <?= form_input(['name'=>'pincode','value'=>$pincode,'class'=>'form-control','id'=>'pincode','placeholder'=>'Pincode Info','pattern'=>'[0-9]{0,6}','maxlength'=>'6','title'=>'Pincode info allowed only numeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                  <?php  $pet_fax=$app[0]->pet_fax; ?>
                 <?= form_input(['name'=>'petFax','value'=>$pet_fax,'class'=>'form-control','id'=>'petFax','placeholder'=>'Pet Fax Info','maxlength'=>'12','title'=>'petFax info allowed only numeric ']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label><font color="red">*</font></span>Mobile Number:</label>
                <?php  $petmobile=$app[0]->petmobile; ?>
                <?= form_input(['name'=>'petmobile','value'=>$petmobile,'class'=>'form-control','id'=>'petmobile','placeholder'=>'Mobile Number','pattern'=>'[0-9]{10,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
            </div>
        </div>
    </div>
</fieldset>  
    <input type="button" name="nextsubmit" id="nextsubmit" value="Add Appellant" class="btn btn-primary btn-sm" onclick="addMoreApp();">
</fieldset>
