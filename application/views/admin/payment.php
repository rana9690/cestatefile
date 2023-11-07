<?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>

<div class="content" style="padding-top:0px;">
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">

            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'app_bdetails','autocomplete'=>'off']) ?>
                <div class="content clearfix">
                    <?= form_fieldset('Payment').
                        '<i class="fa fa-rupee-sign text-danger" style="position: absolute;margin: -56px 0px 0px 8px;"></i>'.
                        '<div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
                    ?>
                        <div class="row">
                            <!-- <div class="col-md-4">
                                <div class="form-check mb-3">
                                    <label class="form-check-label font-weight-semibold">
                                        <input type="checkbox" class="form-check-input">
                                        Any prior registration process is incomplete
                                    </label>
                                </div>
                            </div> -->
                            <div class="col-md-4">
                                <div class="form-group required d-none">
                                    <label>Jurisdiction of Dispute<span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Jurisdiction of Dispute<span class="text-danger">*</span></label>
                                    <?php
                                    	$data_array=[''=>'Choose Jurisdiction of Dispute'];
                                    	echo form_dropdown('jur_dispute',$data_array,'',['class'=>'form-control','id'=>'jur_dispute','required'=>'true']); 
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Commercial Court Location<span class="text-danger">*</span></label>
                                    <?php
                                    	$data_array=[''=>'Choose Commercial Court Location'];
                                    	echo form_dropdown('cc_location',$data_array,'',['class'=>'form-control','id'=>'cc_location','required'=>'true']); 
                                    ?>			                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Case Type/Nature<span class="text-danger">*</span></label>
                                    <?php
                                    	$data_array=[''=>'Choose Case Type/Nature'];
                                    	echo form_dropdown('case_type',$data_array,'',['class'=>'form-control','id'=>'case_type','required'=>'true']); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group required">
                                    <label>Short Cause Title<span class="text-danger">*</span></label>
                                    <?= form_textarea(['name'=>'sc_title','class'=>'form-control','cols'=>'4','rows'=>'2','required'=>'true','placeholder'=>'Enter Short Case Title']) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group required">
                                    <label>Short description of case<span class="text-danger">*</span></label>
                                    <?= form_textarea(['name'=>'sc_description','class'=>'form-control','cols'=>'4','rows'=>'2','required'=>'true','placeholder'=>'Enter Short description of Case']) ?>
                                    <p class="text-danger text-right">( max 500 characters )</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">			                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <?= form_input(['name'=>'remark','class'=>'form-control','placeholder'=>'Enter remark if any.']) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Suit Amount (Rs.)</label>			                                    
                                    <?= form_input(['name'=>'suit_amount','class'=>'form-control','placeholder'=>'Enter Suit Amount']) ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Section of Law Add Process Fee (Rs.)<span class="text-danger">*</span></label>
                                    <?php
                                    	$data_array=[''=>'Choose section of law process fee'];
                                    	echo form_dropdown('law_pfee',$data_array,'',['class'=>'form-control','id'=>'case_type','required'=>'true']); 
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                    <label>Fee Amount (Rs.)</label>
                                    <?= form_input(['name'=>'fee_amount','class'=>'form-control','required'=>'true','disabled'=>'true','value'=>'0','type'=>'number']) ?>
                                </div>
                            </div>
                            <div class="offset-md-4 col-md-4" style="margin-top: 28px;">
                            	<?php
                    			echo form_submit(['value'=>'Save and Next','class'=>'btn btn-success','disabled'=>'true','id'=>'slevel1']).
                    			     form_reset(['value'=>'Reset/Clear','class'=>'btn btn-danger']);
                            	?>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
	</div>
</div>	