<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content" style="padding-top:0px;">
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
            
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'addMasterPaper','autocomplete'=>'off','onsubmit'=>'return upd_master_paper();']) ?>
            <input type="hidden" id="csrf_token" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash();?>" />
            <div class="content clearfix">

                    <?= form_fieldset('<small class="fa fa-upload"></small>&nbsp;&nbsp;Upload Documents').
                        '<div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>'.

                    '<div class="row">
                        <div class="col-md-3">'.
                            form_label('<small class="fa fa-search"></small>&nbsp;&nbsp;Diary No.','filing_no',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']).
                            form_input(['name'=>'filing_no','class'=>'form-control alert-danger','min'=>'1','max'=>'999999','type'=>'number','style'=>'width: 200px;','onkeydown'=>'if(this.value.length > 5) { $.alert(\'Diary no should be less than 6 digit\'); this.value=\'\'; return false; }','placeholder'=>'Diary No.','onchange'=>'filing_year.disabled=false;']).
                        '</div>
                        <div class="col-md-3">'.
                            form_label('<small class="fa fa-calendar-alt"></small>&nbsp;&nbsp;Select Year','filing_year',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']);
                            $year_array=[''=>'-----select Year-----'];
                            for($i=date('Y'); $i>=(date('Y')-15); $i--) $year_array[$i]=$i;
                            echo form_dropdown('filing_year',@$year_array,null,['class'=>'form-control','style'=>'width: 200px;','disabled'=>'true','onchange'=>'validate_diary(this.value,filing_no.value)']).
                        '</div>
                    </div>
                    <div class="row party_radio_div d-none" style="margin-top: 15px;border-top:1px solid #ddd;padding-top:8px;">
                        <div class="col-md-4">'.
                        form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Applicant','applicant',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']).
                        form_radio(['name'=>'userType','class'=>'form-control','id'=>'applicant','value'=>'1','onclick'=>'additional_party(this)','style'=>'position: absolute; top: 0; margin: 8px -50px;']).
                        '</div>
                        <div class="col-md-4">'.
                        form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Respondant','respondant',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']).
                        form_radio(['name'=>'userType','class'=>'form-control','id'=>'respondant','value'=>'2','onclick'=>'additional_party(this)','style'=>'position: absolute; top: 0; margin: 8px -28px;']).
                        '</div>
                        <div class="col-md-4">'.
                        form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Third Party','third_party',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']).
                        form_radio(['name'=>'userType','class'=>'form-control','id'=>'third_party','value'=>'3','onclick'=>'additional_party(this)','style'=>'position: absolute; top: 0; margin: 8px -38px;']).
                        '</div>
                    </div>
                    <div class="row additional_party_table d-none" style="margin-top: 20px;">
                        <div class="col-md-12 table-responsive">
                            <span class="btn btn-warning btn-sm disabled" style="margin-bottom: 12px;"><i class="fa fa-users"></i>&nbsp;&nbsp;Additional Party(s)&nbsp;&nbsp;<i class="fa fa-arrow-down"></i></span>
                            <table class="table table-sm table-bordered table-striped w-100">
                                <thead>
                                    <tr class="font-weight-bold">
                                        <th>#</th>
                                        <th>PARTY NAME</th>
                                        <th>VAKALATNAMA (YES/NO)</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">'.
                            form_fieldset('<small class="fa fa-upload"></small>&nbsp;&nbsp;Paper Details',['style'=>'margin-top: 16px;','id'=>'paper_details_fieldset','class'=>'d-none']).
                            '<div class="row">
                                <div class="col-md-4">'.
                                    form_label('<small class="fa fa-text"></small>&nbsp;&nbsp;Paper Master&nbsp;<sup class="fa fa-star text-danger"></sup>','paper_master',['class'=>'text-success font-weight-bold']);
                                    $paper_master_array=[''=>'-----Choose paper type-----'];
                                    $paper_master_rs=$this->admin_model->_get_data('master_document');

                                    foreach($paper_master_rs as $data) :;
                                        $paper_master_array[$data->pay.' '.$data->did]=$data->d_name;
                                    endforeach;
                                    echo form_dropdown('paper_master',$paper_master_array,null,['class'=>'form-control','onchange'=>'paper_updoad(this.value);','required'=>'true']).
                                '</div>
                                <div class="col-md-4 coloffset-md-8">
                                    <label class="file-upload btn btn-primary disabled" style="position: absolute;margin-top: 27px;">Browse for file .....'.
                                        form_upload(['name'=>'upd_paper','class'=>'d-none','title'=>'Upload your paper master, file should be pdf format only','accept'=>'application/pdf',"disabled"=>"true",'onchange'=>'choose_mpfile()']).
                                    '</label>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;">
                                <div class="col-md-12">'.
                                    form_label('<small class="fa fa-pencil-alt"></small>&nbsp;&nbsp;Matter','matter',['class'=>'text-success font-weight-bold']).
                                    form_textarea(['name'=>'matter','rows'=>'2','cols'=>'20','class'=>'form-control','placeholder'=>'Enter matter']).
                                '</div>
                                <div class="col-md-6 tannexure">'.
                                    form_label('<small class="fa fa-pencil-alt"></small>&nbsp;&nbsp;Total No of Annexure&nbsp;<sup class="fa fa-star text-danger"></sup>','annexure',['class'=>'text-success font-weight-bold']).
                                    form_input(['name'=>'annexure','class'=>'form-control','type'=>'number','title'=>'Enter number only.','required'=>'true']).
                                '</div>
                                <div class="col-md-6 ia_nature_div d-none">'.
                                    form_label('<small class="fa fa-text"></small>&nbsp;&nbsp;IA Nature Name&nbsp;<sup class="fa fa-star text-danger"></sup>','ia_nature_name',['class'=>'text-success font-weight-bold']);
                                    $paper_master_array=[''=>'-----Choose IA Nature Name-----'];
                                    $paper_master_rs=$this->admin_model->_get_data('master_document_with_IAO');
                                    
                                    foreach($paper_master_rs as $data) :;
                                        $paper_master_array[$data->did]=$data->d_name;
                                    endforeach;
                                    echo form_dropdown('ia_nature_name',$paper_master_array,null,['class'=>'form-control','required'=>'true','disabled'=>'true']).
                                '</div>
                            </div>';

                        echo form_fieldset('<small class="fa fa-user text-danger"></small>&nbsp;&nbsp;Counsel Detail',['id'=>'vakalatnama_fieldset','class'=>'d-none','style'=>'margin:15px 0px;']).
                             '<div class="row form-group">

                                 <div class="col-md-4">'.
                                     form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Counsel Name&nbsp;&nbsp;<sup class="fa fa-star text-danger"></sup>','council_name');
                                     $rs=$this->admin_model->_get_data('master_advocate');
                                     $data_array=[''=>'Select Caunsel'];
                                     foreach ($rs as $org_row) $data_array[$org_row->adv_code]=$org_row->adv_name;
                                     echo form_dropdown('council_name',$data_array,'',['class'=>'form-control','onchange'=>'get_adv_data(this);','disabled'=>'true','required'=>'true']).
                                 '</div>
                                  <div class="col-md-8">'.
                                    form_label('<small class="fa fa-location-arrow"></small>&nbsp;&nbsp;Counsel Address','council_address').
                                    form_textarea(['name'=>'council_address','class'=>'form-control','pattern'=>'[-\/&_.A-Za-z0-9 ]{4,200}','maxlength'=>'150','placeholder'=>'Counsel Address','rows'=>'1','cols'=>'20','disabled'=>'true']).
                                  '</div>
                             </div>

                             <div class="row form-group">

                                  <div class="col-md-4">'.
                                    form_label('<mall class="fa fa-envelope"></small>&nbsp;&nbsp;Counsel Email Id','council_email').
                                    form_input(['name'=>'council_email','type'=>'email','title'=>'Enter valid email id','class'=>'form-control','placeholder'=>'Counsel email id','disabled'=>'true']).
                                  '</div>

                                  <div class="col-md-4">'.
                                    form_label('<mall class="fa fa-phone"></small>&nbsp;&nbsp;Counsel Phone No','council_phone').
                                    form_input(['name'=>'council_phone','title'=>'Enter valid counsel phone no. (Number & space only)','class'=>'form-control','placeholder'=>'Counsel phone no','pattern'=>'[0-9 ]{0,20}','maxlength'=>'20','disabled'=>'true']).
                                  '</div>

                                  <div class="col-md-4">'.
                                    form_label('<mall class="fa fa-mobile"></small>&nbsp;&nbsp;Counsel Mobile No<sup class="fa fa-star text-danger">','council_mobile').
                                    form_input(['name'=>'council_mobile','title'=>'Enter valid mobile no (10 digit only)','class'=>'form-control','placeholder'=>'Enter 10 digit mobile no.','pattern'=>'[0-9]{10,10}','maxlength'=>'10','required'=>'true','disabled'=>'true']).
                                  '</div>'.

                             '</div>';
                             
                        echo form_fieldset_close();

                        echo'<div class="row form-group pmode d-none" style="border: 1px solid #ddd; margin: 15px 12px 0px 0px; border-radius: 6px; spadding: 12px;">
                                    <div class="col-md-12">'.
                                        form_label('Payment Mode','payment_mode',['class'=>'text-danger font-weight-bold']).
                                    '</div>
                                    <div class="col-md-2">'.
                                        form_label('Bank Draft','bdd',['class'=>'text-info font-weight-bold']).
                                        form_radio(['name'=>'payment_mode','id'=>'bdd','class'=>'form-control','style'=>'display: inline-block; position: absolute; margin: 5px 0px 0px 13px; left: 0;','disabled'=>'true','onClick'=>'active_payment_div(\'bankdd_div\',this);','value'=>'1']).
                                    '</div>
                                    <div class="col-md-2">'.
                                        form_label('Postal Order','po',['class'=>'text-info font-weight-bold']).
                                        form_radio(['name'=>'payment_mode','id'=>'po','class'=>'form-control','style'=>'display: inline-block; position: absolute; margin: 5px 0px 0px 25px; left: 0;','disabled'=>'true','onClick'=>'active_payment_div(\'postal_order_div\',this);','value'=>'2']).
                                    '</div>
                                    <div class="col-md-2">'.
                                        form_label('Online Payment','olp',['class'=>'text-info font-weight-bold']).
                                        form_radio(['name'=>'payment_mode','id'=>'olp','class'=>'form-control','style'=>'display: inline-block; position: absolute; margin: 5px 0px 0px 50px; left: 0;','disabled'=>'true','onClick'=>'active_payment_div(\'online_payment_div\',this);','value'=>'3']).
                                    '</div>'.

                                    form_fieldset('<small class="fa fa-rupee-sign text-info"></small>&nbsp;&nbsp;Bank Detail',['class'=>'text-success d-none','id'=>'bankdd_div','style'=>'margin:15px 12px;']).

                                        '<div class="row form-group">
                                            <div class="col-md-4">
                                                <span class="text-warning font-weight-bold">Total Document Fee : <b class="text-info">&nbsp;&nbsp;25</b></span>
                                            </div>
                                            <div class="col-md-4 d-none ia_fee_div">
                                                <span class="text-warning font-weight-bold">IA Fee : <b class="text-info">&nbsp;&nbsp;1000</b></span>
                                            </div>
                                            <div class="col-md-4 d-none ia_fee_div">
                                                <span class="text-warning font-weight-bold">Total Fee : <b class="text-info">&nbsp;&nbsp;1025</b></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('Bank Branch Name&nbsp;<sup class="fa fa-star text-danger"></sup>','branch_name').
                                                form_input(['name'=>'branch_name','required'=>'true','disabled'=>'true','class'=>'form-control','pattern'=>'[-\/.,&a-zA-Z0-9 ]{2,150}','maxlength'=>'150','title'=>'Allowed alpha numeric and (-/.,&) only','placeholder'=>'Bank branch detail']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('DD Number&nbsp;<sup class="fa fa-star text-danger"></sup>','dd_no').
                                                form_input(['name'=>'dd_no','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{4,50}','maxlength'=>'50','title'=>'Allowed only numeric','placeholder'=>'Bank DD number','disabled'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Amount in Rs.&nbsp;<sup class="fa fa-star text-danger"></sup>','ia_fee').
                                                form_input(['name'=>'ia_fee','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{1,5}','maxlength'=>'5','title'=>'Allowed only numeric','placeholder'=>'DD amount','disabled'=>'true']).
                                            '</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('DD Date&nbsp;<sup class="fa fa-star text-danger"></sup>','dd_date').
                                                form_input(['name'=>'dd_date','value'=>date('Y-m-d', strtotime('-7 day')),'required'=>'true','class'=>'form-control','readonly'=>'true','onClick'=>'trans_date(this);','style'=>'max-width: 160px;','disabled'=>'true','required'=>'true']).'<span class="fa fa-calendar-alt text-danger" style="position: absolute; top:0; margin: 38px 136px; font-size: 20px; opacity: 0.4;"></a>'.
                                            '</div>
                                        </div>'.
                                    form_fieldset_close().

                                    form_fieldset('<small class="fa fa-rupee-sign text-info"></small>&nbsp;&nbsp;Post Office Detail',['class'=>'text-success d-none','id'=>'postal_order_div','style'=>'margin:15px 12px;']).

                                        '<div class="row form-group">
                                            <div class="col-md-4">
                                                <span class="text-warning font-weight-bold">Total Document Fee : <b class="text-info">&nbsp;&nbsp;25</b></span>
                                            </div>
                                            <div class="col-md-4 d-none ia_fee_div">
                                                <span class="text-warning font-weight-bold">IA Fee : <b class="text-info">&nbsp;&nbsp;1000</b></span>
                                            </div>
                                            <div class="col-md-4 d-none ia_fee_div">
                                                <span class="text-warning font-weight-bold">Total Fee : <b class="text-info">&nbsp;&nbsp;1025</b></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('Post Office Name&nbsp;<sup class="fa fa-star text-danger"></sup>','branch_name').
                                                form_input(['name'=>'branch_name','required'=>'true','class'=>'form-control','pattern'=>'[-\/.,&a-zA-Z0-9 ]{2,150}','maxlength'=>'150','title'=>'Allowed alpha numeric and (-/.,&) only','placeholder'=>'Post office name','disabled'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Amount in Rs.&nbsp;<sup class="fa fa-star text-danger"></sup>','ia_fee').
                                                form_input(['name'=>'ia_fee','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{1,5}','maxlength'=>'5','title'=>'Allowed only numeric','placeholder'=>'Post office amount','disabled'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('IPO Date&nbsp;<sup class="fa fa-star text-danger"></sup>','dd_date').
                                                form_input(['name'=>'dd_date','value'=>date('Y-m-d', strtotime('-7 day')),'required'=>'true','class'=>'form-control','readonly'=>'true','onClick'=>'trans_date(this);','style'=>'max-width: 160px;','disabled'=>'true','required'=>'true']).'<span class="fa fa-calendar-alt text-danger" style="position: absolute; top:0; margin: 38px 136px; font-size: 20px; opacity: 0.4;"></a>'.
                                            '</div>
                                        </div>'.
                                    form_fieldset_close().

                                    form_fieldset('<small class="fa fa-rupee-sign text-info"></small>&nbsp;&nbsp;Online Payment',['class'=>'text-success d-none','id'=>'online_payment_div','style'=>'margin:15px 12px;']).

                                        '<div class="row form-group">
                                            <div class="col-md-4">
                                                <span class="text-warning font-weight-bold">Total Document Fee : <b class="text-info">&nbsp;&nbsp;25</b></span>
                                            </div>
                                            <div class="col-md-4 d-none ia_fee_div">
                                                <span class="text-warning font-weight-bold">IA Fee : <b class="text-info">&nbsp;&nbsp;1000</b></span>
                                            </div>
                                            <div class="col-md-4 d-none ia_fee_div">
                                                <span class="text-warning font-weight-bold">Total Fee : <b class="text-info">&nbsp;&nbsp;1025</b></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('Name&nbsp;<sup class="fa fa-star text-danger"></sup>','branch_name').
                                                form_input(['name'=>'branch_name','required'=>'true','class'=>'form-control','pattern'=>'[-\/.,&a-zA-Z0-9 ]{2,150}','maxlength'=>'150','title'=>'Allowed alpha numeric and (-/.,&) only','placeholder'=>'Bank name','value'=>'NTRP','disabled'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Challan/Ref. Number&nbsp;<sup class="fa fa-star text-danger"></sup>','dd_no').
                                                form_input(['name'=>'dd_no','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{4,50}','maxlength'=>'50','title'=>'Allowed only numeric','placeholder'=>'Challan/Ref number','disabled'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Amount in Rs.&nbsp;<sup class="fa fa-star text-danger"></sup>','ia_fee').
                                                form_input(['name'=>'ia_fee','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{1,5}','maxlength'=>'5','title'=>'Allowed only numeric','placeholder'=>'Amount','disabled'=>'true']).
                                            '</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('Challan/Ref. Number&nbsp;<sup class="fa fa-star text-danger"></sup>','dd_date').
                                                form_input(['name'=>'dd_date','value'=>date('Y-m-d', strtotime('-7 day')),'required'=>'true','class'=>'form-control','readonly'=>'true','onClick'=>'trans_date(this);','style'=>'max-width: 160px;','disabled'=>'true','required'=>'true']).'<span class="fa fa-calendar-alt text-danger" style="position: absolute; top:0; margin: 38px 136px; font-size: 20px; opacity: 0.4;"></a>'.
                                            '</div>
                                        </div>'.
                                    form_fieldset_close().
                            '</div>'.

                            form_fieldset_close().
                        '</div>
                    </div>

                    <div class="row" style="margin: 15px 0px;">
                        <div class="offset-md-8 col-md-4">
                            <i class="fa fa-save" style="position: absolute; color: #fff; z-index: 1; margin: 13px 0px 0px 122px;"></i>'.
                            form_submit(['value'=>'Save','class'=>'btn btn-success btn-lg btn-block upd-save','disabled'=>'true']).
                        '</div>
                    </div>'.

                    form_fieldset_close(); ?>
                </div>
            <?= form_close(); ?>
        </div>
	</div>
    <!-- <div class="row">
        <div class="card w-100" style="padding: 0px 12px;">
            <?php 
                echo form_fieldset('ADDED Documents',['style'=>'margin-top:12px;border: 2px solid #4cb060;']).
                 '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 21px 6px;"></i>';

                echo'<div class="d-block text-center text-warning">
                        <div class="table-responsive text-secondary" id="caveat_filing_list">
                            <span class="fa fa-spinner fa-spin fa-3x"></span>
                        </div>
                    </div>';
                echo form_fieldset_close();
            ?>
        </div>
    </div> -->
</div>