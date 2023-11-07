<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content" style="padding-top:0px;">
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
            
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'app_bdetails','autocomplete'=>'off']) ?>
                <div class="content clearfix">

                    <?= form_fieldset('Add Petitioner').
                        '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'.
                        '<div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
                        ?>

                        <div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px; margin: -20px auto 12px; max-width: 100%;">
                            <div class="col-md-4">
                                <label class="text-danger">Select Mode</label>
                            </div>
                            <div class="col-md-6 md-offset-2">
                                <label for="org" class="form-check-label font-weight-semibold">
                                    <?= form_radio(['name'=>'smode','value'=>'organization','checked'=>TRUE,'id'=>'org']); ?>
                                    Organization&nbsp;&nbsp;
                                </label>
                                <label for="indv" class="form-check-label font-weight-semibold">
                                    <?= form_radio(['name'=>'smode','value'=>'Individual','id'=>'indv']); ?>
                                    Individual&nbsp;&nbsp;
                                </label>
                                <label for="inp" class="form-check-label font-weight-semibold">
                                    <?= form_radio(['name'=>'smode','value'=>'in-persion','id'=>'inp']); ?>
                                    In-Persion
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Organization/Company Name<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'orgname','class'=>'form-control','placeholder'=>'Organization/Company Name','required'=>'true','pattern'=>'[A-Za-z0-9,_.\-/ ]{4,200}','maxlength'=>'200','title'=>'Company name allowed only alphanumeric and (,_.-/)']) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Address 1<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'address1','class'=>'form-control','placeholder'=>'Address line no. 1','required'=>'true','pattern'=>'[A-Za-z0-9,_.\-/ ]{4,200}','maxlength'=>'200','title'=>'Address 1 allowed only alphanumeric and (,_.-/)']) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <?= form_input(['name'=>'address2','class'=>'form-control','placeholder'=>'Address line no. 2','pattern'=>'[A-Za-z0-9,_.\-/ ]{4,200}','maxlength'=>'200','title'=>'Address 2 allowed only alphanumeric and (,_.-/)']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Address 3</label>
                                    <?= form_input(['name'=>'address3','class'=>'form-control','placeholder'=>'Address line no. 3','pattern'=>'[A-Za-z0-9,_.\-/ ]{4,200}','maxlength'=>'200','title'=>'Address 3 allowed only alphanumeric and (,_.-/)']) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Authorized Person of Organization<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'aut_org','class'=>'form-control','placeholder'=>'Authorized Person','required'=>'true','pattern'=>'[A-Za-z0-9,_.\-/ ]{4,200}','maxlength'=>'200','title'=>'Authorized Person allowed only alphanumeric and (,_.-/)']) ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Company Info<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'comp_info','class'=>'form-control','placeholder'=>'Company Info','required'=>'true','pattern'=>'[A-Za-z0-9,_.\-/ ]{4,200}','maxlength'=>'200','title'=>'Company info allowed only alphanumeric and (,_.-/)']) ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Nationality/Situated In<span class="text-danger">*</span></label>
                                    <?php
                                        $data_array=[''=>'Choose Nationality/Situated In'];
                                        echo form_dropdown('nationality',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>State<span class="text-danger">*</span></label>
                                    <?php
                                    	                            
                                        $state=[''=>'-----Select State-----'];
                                        if(!empty(@$states)) :;
                                            foreach($states as $value) :;
                                                $state[$value->state_id]=$value->state_name;
                                            endforeach;
                                        endif;
                                        echo form_dropdown('state',$state,NULL,['class'=>'form-control','required'=>'true','id'=>'state']) 
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>City/District</label>
                                    <?php
                                        $district=[''=>'-----Select District Name-----'];
                                        echo form_dropdown('city',$district,NULL,['class'=>'form-control','required'=>'true','id'=>'district','disabled'=>'true']); 
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Pin-Code</label>
                                    <?= form_input(['name'=>'pincode','class'=>'form-control','placeholder'=>'Pincode','pattern'=>'[0-9]{6,8}','maxlength'=>'8','title'=>'Pincode should be numeric only.']) ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>PAN Number of Authorized Person</label>
                                    <?= form_input(['name'=>'pan_number','class'=>'form-control','placeholder'=>'PAN Number','pattern'=>'[A-Za-z0-9]{10,10}','maxlength'=>'10','title'=>'PAN number should be alpha numeric only.']) ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Mobile Number of Authorized Person</label>
                                    <?= form_input(['name'=>'mobile_number','class'=>'form-control','placeholder'=>'Mobile Number','pattern'=>'[0-9]{10,10}','maxlength'=>'10','title'=>'Mobile number should be numeric and 10 digit only.']) ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>E-Mail Id of Authorized Person</label>
                                    <?= form_input(['name'=>'mobile_number','class'=>'form-control','placeholder'=>'E-Mail Id','pattern'=>'[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$','maxlength'=>'100','title'=>'Enter valid E-Mail id.']) ?>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group required">
                                    <label>Gender</label>                                    
                                    <?php
                                        $gender=[''=>'-----Select Gender-----','male'=>'Male','female'=>'Female','other'=>'Other'];
                                        echo form_dropdown('gender',$gender,NULL,['class'=>'form-control','required'=>'true','required'=>'true']); 
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group required">
                                    <label>Age</label>
                                    <?= form_input(['name'=>'age','class'=>'form-control','placeholder'=>'Age','pattern'=>'[0-9]{1,2}$','maxlength'=>'2','title'=>'Age should be numeric only.']) ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Occupation</label>
                                    <?= form_input(['name'=>'occupation','class'=>'form-control','placeholder'=>'Occupation','pattern'=>'[A-za-z0-9 ]{0,150}$','maxlength'=>'150','title'=>'Age should be numeric only.']) ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="offset-md-8 col-md-4">
                            	<?php
                    			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                    form_submit(['value'=>'Save','class'=>'btn btn-success','id'=>'slevel2','disabled'=>'trues','style'=>'padding-left:24px;']).
                                     '<i class="icon-trash-alt" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>'.
                    			     form_reset(['value'=>'Reset/Clear','class'=>'btn btn-danger','style'=>'padding-left: 24px;']).
                                     form_button(['id'=>'','value'=>'false','content'=>'&nbsp;Next','class'=>'icon-arrow-right8 btn btn-primary']);
                            	?>
                            </div>
                        </div>
                    <?= form_fieldset_close(); ?>
                </div>
            <?= form_close();?>
        </div>
	</div>
    <div class="row">
        <div class="card w-100" style="padding: 0px 12px;">
            <?php 
                echo form_fieldset('ADDED PETITIONER\'S LIST',['style'=>'margin-top:12px;border: 2px solid #4cb060;']).
                 '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 21px 6px;"></i>';

                echo'<div class="d-block text-center text-warning">
                        <div class="table-responsive text-secondary" id="add_petitioner_list">
                            <span class="fa fa-spinner fa-spin fa-3x"></span>
                        </div>
                    </div>';
                echo form_fieldset_close();
            ?>
        </div>
    </div>
</div>	