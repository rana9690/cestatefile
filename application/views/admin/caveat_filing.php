<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php 
//echo $this->session->unset_userdata('cavsalt');
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script>
$(document).ready(function(){
	 $(".datepicker" ).datepicker({ 
		 dateFormat: "dd/mm/yy",
		 maxDate: 'now'});
	}); 
</script>
<div class="content" style="padding-top:0px;">
    <div class="row" >
        <div class="col-md-12 text-right">
            <a href="javascript: void(0);" onClick="show_hide(this)" class="fa fa-eye btn btn-warning btn-lg">&nbsp;&nbsp;Add Caveat</a>
        </div>
    </div>
    <div id="caldetail"></div>
	<div class="row d-none" id="caveat-form-div">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
            
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'addCaveat','autocomplete'=>'off','onsubmit'=>'return addCaveatDetails();']) ?>
                <div class="content clearfix">

                    <?= form_fieldset('File Caveat').
                        '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'.
                        '<div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
                        ?>
                         <input type="hidden" name="saltNo" id="saltNo" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">
                                <?php 
                                   echo form_label('Commission <sup class="fa fa-star text-danger"></sup>','commission');
                                    $rs=$this->admin_model->_get_data('master_commission');
                                    $comm_data_array=[''=>'Choose Commission'];
                                    foreach ($rs as $comm_row) $comm_data_array[$comm_row->id]=$comm_row->full_name;
                                    echo form_dropdown('commission',$comm_data_array,'',['id'=>'commission1','class'=>'form-control','required'=>'true']);
                                ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                <?php 
                                   echo form_label('Case Type <sup class="fa fa-star text-danger"></sup>','nature_of_order');
                                    $rs=$this->admin_model->_get_data('master_case_type');
                                    $data_array=[''=>'Choose Case Type'];
                                    foreach ($rs as $comm_row) $data_array[$comm_row->case_type_code]=$comm_row->short_name;
                                    echo form_dropdown('nature_of_order',$data_array,'',['id'=>'caseTypeold','class'=>'form-control','required'=>'true']);
                                ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <?=     form_label('Case Number <sup class="fa fa-star text-danger"></sup>','case_no').
                                        form_input(['name'=>'case_no','id'=>'caseNo','class'=>'form-control alert-danger','placeholder'=>'Case Number (numeric only)','onkeypress'=>'return isNumberKey(event)','required'=>'true','title'=>'Case number must be numeric only','pattern'=>'[0-9]{1,12}']);
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group required">                                    
                                <?php   echo form_label('Case Year <sup class="fa fa-star text-danger"></sup>','case_year');
                                     $data_array=[''=>'Choose Case Year'];
                                     for($i=2011; $i<= date('Y'); $i++) $data_array[$i]=$i;
                                     echo form_dropdown('case_year',$data_array,'',['id'=>'year','class'=>'form-control','required'=>'true']);
                                ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required">
                                <?= form_label('Decision Date  <sup class="fa fa-star text-danger"></sup>','decision_date').
                                    form_input(['name'=>'decision_date','id'=>'decisionDate','class'=>'form-control alert-danger datepicker','value'=>date('d/m/Y'),'readonly'=>'true', 'onClick'=>"get_date(this);",'style'=>'max-width: 160px;','required'=>'true']).'<span class="fa fa-calendar-alt text-danger" style="position: absolute; top:0; margin: 38px 136px; font-size: 20px; opacity: 0.4;"></a>'; 
                                ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                <?=     form_label('&nbsp;','').
                                        form_button(['content'=>'<i class="icon-plus-circle2"></i>&nbsp;&nbsp;Add More','value'=>'false','class'=>'btn btn-success btn-block','onclick'=>'add_more_commision_details();','id'=>'add_btn_commission','disabled'=>true]); 
                                ?>
                                </div>
                            </div>

                        </div>

                        <div id="new_commission_added" class="row d-none">
                            <div class="col-md-12 table-responsive" style="margin: 16px auto;">
                                <p class="text-danger font-weight-bold"></p>
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Commission</th>
                                            <th>Case Type</th>
                                            <th>Case No</th>
                                            <th>Case Year</th>
                                            <th>Decision Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add_comm"></tbody>
                                </table> 
                            </div>                           
                        </div>
					<div id="caveator">
                        <?php
                            echo form_fieldset('<small class="fa fa-user text-danger"></small>&nbsp;&nbsp;Caveator Details').
                                 '
                                  <div class="col-md-6 md-offset-2">
                                        <label for="org" class="form-check-label font-weight-semibold">
                                            <input type="radio" name="org" value="1" checked="checked" id="bd1" onclick="orgshow();">
                                            Organization&nbsp;&nbsp;
                                        </label>
                                        <label for="indv" class="form-check-label font-weight-semibold">
                                            <input type="radio" name="org" value="2" id="po1" onclick="orgshow();">
                                            Individual&nbsp;&nbsp;
                                        </label>
                                        <label for="inp" class="form-check-label font-weight-semibold"></label>
                                    </div>

				<div class="row form-group">
                                     <div class="col-md-4" id="org">'.
                                         form_label('Select Organization <sup class="fa fa-star text-danger"></sup>','organization');
                                         $rs=$this->admin_model->_get_data('master_org');
                                         $data_array=[''=>'Select Organization'];
                                         foreach ($rs as $org_row) $data_array[$org_row->org_id]=$org_row->orgdisp_name;
                                         echo form_dropdown('select_org_res',$data_array,'',['id'=>'select_org_res','class'=>'form-control mdb-select md-form','required'=>'true','onchange'=>'get_org_data(this)','searchable'=>'Search here..']).
                                     '</div>


                                     <div class="col-md-4" id="ind" style="display:none">'.
                                         form_label('Select Organization <sup class="fa fa-star text-danger"></sup>','organization');
                                         $rs=$this->admin_model->_get_data('master_org');
                                         $data_array=[''=>'Select Organization'];
                                         foreach ($rs as $org_row) $data_array[$org_row->org_id]=$org_row->orgdisp_name;
                                         echo form_input(['name'=>'select_org_res','id'=>'select_org_res','class'=>'form-control','required'=>'true']).
                                     '</div>

                                      <div class="col-md-4">'.
                                        form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Name of Caveator <sup class="fa fa-star text-danger"></sup>','caveat_name').
                                        form_input(['name'=>'caveatname','id'=>'caveatname','class'=>'form-control alert-danger','required'=>'true','pattern'=>'[-\/_.A-Za-z0-9 ]{4,200}','maxlength'=>'150','placeholder'=>'Caveator name']).
                                      '</div>
                                      <div class="col-md-4">'.
                                        form_label('<small class="fa fa-location-arrow"></small>&nbsp;&nbsp;Address <sup class="fa fa-star text-danger"></sup>','caveat_address').
                                        form_textarea(['name'=>'addressTparty','id'=>'addressTparty','rows'=>'2','cols'=>'10','class'=>'form-control','required'=>'true','placeholder'=>'Enter address','pattern'=>'[-\/&_.A-Za-z0-9 ]{4,200}','maxlength'=>'200','title'=>'Allowed alpha numeric (./&,-_) only']).
                                      '</div>'.

                                 '</div>'.

                                 '<div class="row form-group">                               
                                     <div class="col-md-4">'.
                                         form_label('Select State <sup class="fa fa-star text-danger"></sup>','caveat_state');
                                         $rs=$this->admin_model->_get_data('master_psstatus');
                                         $data_array=[''=>'Select State'];
                                         foreach ($rs as $state_row) $data_array[$state_row->state_code]=$state_row->state_name;
                                         echo form_dropdown('dstate',$data_array,'',['class'=>'form-control','id'=>'dstate','required'=>'true','onchange'=>'get_district(this)']).
                                     '</div>
                                     <div class="col-md-4">'.
                                        form_label('Select District <sup class="fa fa-star text-danger"></sup>','caveat_district').
                                        form_dropdown('ddistrict',[''=>'Kindly select state first'],'',['class'=>'form-control','id'=>'ddistrict','required'=>'true','disabled'=>'true','id'=>'district']).
                                      '</div>
                                      <div class="col-md-4">'.
                                        form_label('Pincode','caveat_pin').
                                        form_input(['name'=>'pin','id'=>'pin','class'=>'form-control','pattern'=>'[0-9]{6,6}','maxlength'=>'6','placeholder'=>'Pincode']).
                                      '</div>'.

                                 '</div>'.

                                 '<div class="row form-group">
                                 
                                     <div class="col-md-4">'.
                                         form_label('<small class="fa fa-envelope"></small>&nbsp;&nbspEmail Id','caveat_email').
                                         form_input(['name'=>'email','id'=>'email','type'=>'email','class'=>'form-control','placeholder'=>'Email Id']).
                                     '</div>
                                      <div class="col-md-4">'.
                                        form_label('<small class="fa fa-phone"></small>&nbsp;&nbspPhone No','caveat_phone').
                                        form_input(['name'=>'phone','id'=>'phone','class'=>'form-control','placeholder'=>'Phone No.','pattern'=>'[0-9 ]{0,20}','maxlength'=>'20','title'=>'Allowed number and space only']).
                                      '</div>
                                      <div class="col-md-4">'.
                                        form_label('<small class="fa fa-mobile"></small>&nbsp;&nbspMobile No','caveat_mobile').
                                        form_input(['name'=>'mob','id'=>'mob','class'=>'form-control','title'=>'Allowed 10 digit numeric only','pattern'=>'[0-9]{0,10}','maxlength'=>'10','placeholder'=>'Mobile No.']).
                                      '</div>'.

                                 '</div>'.

                                 '<div class="row form-group">'.

                                      '<div class="col-md-12">'.
                                        form_label('<small class="fa fa-user"></small>&nbsp;&nbspPrayer','prayer').
                                        form_input(['name'=>'Prayer','id'=>'Prayer','class'=>'form-control','title'=>'Enter valid prayer','pattern'=>'[-\/_.A-Za-z0-9 ]{0,200}','maxlength'=>'200','placeholder'=>'Enter prayer']).
                                      '</div>'.

                                 '</div>';

                            echo form_fieldset_close(); 

                            echo form_fieldset('<small class="fa fa-user text-danger"></small>&nbsp;&nbsp;Counsel Detail').
                                 '<div class="row form-group">

                                     <div class="col-md-4">'.
                                         form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Counsel Name','council_name');
                                         $rs=$this->admin_model->_get_data('master_advocate');
                                         $data_array=[''=>'Select Caunsel'];
                                         foreach ($rs as $org_row) $data_array[$org_row->adv_code]=$org_row->adv_name;
                                         echo form_dropdown('advCode',$data_array,'',['id'=>'advCode','class'=>'form-control','onchange'=>'get_adv_data(this);']).
                                     '</div>
                                      <div class="col-md-8">'.
                                        form_label('<small class="fa fa-location-arrow"></small>&nbsp;&nbsp;Counsel Address','council_address').
                                        form_textarea(['name'=>'councilAdd','id'=>'councilAdd','class'=>'form-control','pattern'=>'[-\/&_.A-Za-z0-9 ]{4,200}','maxlength'=>'150','placeholder'=>'Counsel Address','rows'=>'1','cols'=>'20']).
                                      '</div>
                                 </div>

                                 <div class="row form-group">

                                      <div class="col-md-4">'.
                                        form_label('<mall class="fa fa-envelope"></small>&nbsp;&nbsp;Counsel Email Id','council_email').
                                        form_input(['name'=>'council_email','id'=>'councilemail','type'=>'email','title'=>'Enter valid email id','class'=>'form-control','placeholder'=>'Counsel email id']).
                                      '</div>

                                      <div class="col-md-4">'.
                                        form_label('<mall class="fa fa-phone"></small>&nbsp;&nbsp;Counsel Phone No','council_phone').
                                        form_input(['name'=>'councilphone','id'=>'councilphone','title'=>'Enter valid counsel phone no. (Number & space only)','class'=>'form-control','placeholder'=>'Counsel phone no','pattern'=>'[0-9 ]{0,20}','maxlength'=>'20']).
                                      '</div>

                                      <div class="col-md-4">'.
                                        form_label('<mall class="fa fa-mobile"></small>&nbsp;&nbsp;Counsel Mobile No<sup class="fa fa-star text-danger">','council_mobile').
                                        form_input(['name'=>'councilmob','id'=>'councilmob','title'=>'Enter valid mobile no (10 digit only)','class'=>'form-control','placeholder'=>'Enter 10 digit mobile no.','pattern'=>'[0-9]{10,10}','maxlength'=>'10','required'=>'true']).
                                      '</div>'.

                                 '</div>

<input style="margin-top: 27px;" type="button" name="btnSubmit" id="btnSubmit" value="Save &amp; Next" class="btn1" onclick="excution()">
';
                                 
                            echo form_fieldset_close();
                            ?>
                            </div>
                            <div id="caveatee" style="display:none">
                            
                <?php  echo form_fieldset('<small class="fa fa-user text-danger"></small>&nbsp;&nbsp;Caveatee Details'); ?>

                                  <div class="col-md-6 md-offset-2">
                                        <label for="org" class="form-check-label font-weight-semibold">
                                            <input type="radio" name="org1" value="1" checked="checked" id="bd1" onclick="orgshow1();">
                                            Organization&nbsp;&nbsp;
                                        </label>
                                        <label for="indv" class="form-check-label font-weight-semibold">
                                            <input type="radio" name="org1" value="2" id="po1" onclick="orgshow1();">
                                            Individual&nbsp;&nbsp;
                                        </label>
                                        <label for="inp" class="form-check-label font-weight-semibold"></label>
                                    </div>

                           <div class="row" id='caveateeorg'>
                                <div class="col-md-4">
                                    <label for="council_email"><mall class="fa fa-envelope">&nbsp;&nbsp;Select Organization</mall></label>
                                     <select name="select_org_app" class="form-control" id="select_org_app" onchange="apple_org_details(this.value)">
                                           <option value="">Select Org Name</option>
                                          <?php
                                          $hscquerytttt =$this->efiling_model->data_list('master_org');
                                          foreach ($hscquerytttt as $row ) {
                                          ?>
                                          <option value="<?php echo htmlspecialchars($row->org_id); ?>"><?php echo htmlspecialchars($row->orgdisp_name); ?></option>
                                          <?php } ?>
                                     </select>
                                </div>
                            </div>
                            
                            
                            <div class="row" id='caveateeind' style="display:none">
                                <div class="col-md-4">
                                    <label for="council_email"><mall class="fa fa-envelope">&nbsp;&nbsp;Select Organization</mall></label>
                                     <input type="text" class="form-control" name="select_org_app" id="select_org_app" value="">
                                </div>
                            </div>

                            <?php $cavsalt=$this->session->userdata('cavsalt'); 
                            //  $this->session->unset_userdata('cavsalt');
                            ?>
                            <input type="hidden" id="saltVal" name="saltVal" value="">
                           <div class="row">
                                <div class="col-md-4">
                                    <label for="name"><span class="custom"><font color="red">*</font>Name of Caveatee</span></label>
                                    <input type="text" class="form-control" name="Namecav" id="Namecav" value="" onkeypress="return onKeyValidate(event,alpha);">
                                </div>
                                 <div class="col-md-4">
                                    <label for="name"><span class="custom"><font color="red">*</font>State :</span></label>
                                    <select name="dstate1" class="form-control" id="dstate1" onchange="showCity(this.value);">
                                       <option selected="selected">Select State Name</option>
                                       <?php   $hscquery = $this->efiling_model->data_list('master_psstatus');
                                       foreach ($hscquery as $row) {
                                        ?>
                                        <option value="<?php echo htmlspecialchars($row->state_code); ?>"><?php echo htmlspecialchars($row->state_name); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>     
                                <div class="col-md-4">
                                    <label for="name"><span class="custom"><font color="red">*</font>Phone No:</span></label>
                                    <input type="text" class="form-control" maxlength="11" name="phonecav" id="phonecav" value="" onkeypress="return isNumberKey(event)">
                                </div>
                           </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name"><span class="custom"><font color="red">*</font>Address :</span></label>
                                    <textarea name="addresscav" id="addresscav" class="form-control" cols="25"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Pin No:</label>
                                    <input type="text" class="form-control" name="pincav" id="pincav" value="" maxlength="6" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Mobile No:</label>
                                    <input type="text" class="form-control" placeholder="9896400000" name="mobcav" maxlength="10" id="mobcav" value="" onkeypress="return isNumberKey(event)">
                                </div>
                             </div>

                            <div class="row">
                              <div class="col-md-4">
                                    <label for="name"><span class="custom"><font color="red">*</font>District</span></label>
                                    <select name="ddistrict1" class="form-control" id="ddistrict1">
                                        <option selected="selected">Select District Name</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Email Id:</label>
                                    <input type="text" class="form-control" name="emailcav" id="emailcav" value="">
                                </div>
                           </div>
                             <br>
                            <legend class="customlavelsub">Document  Details</legend>
                            <div class="col-md-12">
                                <div class="row">
                                       <div class="col-md-3">
                                         <label class="control-label" for="fullappeal"><span class="custom"><font color="red">*</font></span>Caveat:</label>
                                       </div>
                                        <div class="col-md-6">
                                             <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                             <?=form_upload(['id'=>'fIlingDoc','name'=>'files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                             </div>
                                       </div>
                                 </div> 

                                  <div class="row">
                                       <div class="col-md-3">
                                         <label class="control-label" for="v_files"><span class="custom"><font color="red">*</font></span>Vakalatnama:</label>
                                       </div>
                                        <div class="col-md-6">
                                             <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                             <?=form_upload(['id'=>'v_files','name'=>'v_files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                             </div>
                                       </div>
                                 </div>
                                 
                                 <div class="row">
                                       <div class="col-md-3">
                                         <label class="control-label" for="r_files"><span class="custom"><font color="red">*</font></span>Online Payment Receipt:</label>
                                       </div>
                                        <div class="col-md-6">
                                             <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                             <?=form_upload(['id'=>'r_files','name'=>'r_files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                             </div>
                                       </div>
                                 </div>
                                 
                                 
                                  <div class="row">
                                       <div class="col-md-3">
                                         <label class="control-label" for="totalNoRespondent"><span class="custom"><font color="red">*</font></span>Add More:</label>
                                       </div>
                                       <div class="col-md-3">
                                         <div class="input-group mb-3 mb-md-0">
                                         	<input type="text" name="docname" value="" id="docname" class="form-control" placeholder="Document name"  maxlength="250" title="Docuemnt Name required.">
                                      	 </div>
                                       </div>
                                        <div class="col-md-3">
                                             <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                             <?=form_upload(['id'=>'fIlingDoc','name'=>'files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                             </div>
                                       </div>
                                 </div>
                                 
                                  

                             </div>
                   </div>
               </fieldset>
                </div>            
                            
                 
                       <?php      echo form_fieldset('<small class="fa fa-rupee-sign text-info"></small>&nbsp;&nbsp;Counsel Fee Detail',['class'=>'text-success d-none','id'=>'fee_div']).
                                '<div class="row form-group">'.
                                     '<div class="col-md-12">'.
                                        form_label('Total Fee&nbsp;&nbsp;&nbsp;&nbsp;','fee_amount',['class'=>"text-success font-weight-bold"]).
                                        '<div class="fa fa-rupee-sign text-danger font-weight-bold">&nbsp;3025&nbsp;&nbsp;'.
                                            form_input(['name'=>'fee_amount','class'=>'form-control','placeholder'=>'Amount','style'=>'display:inline-block;max-width:110px;','disabled'=>'true','pattern'=>'[0-9]{1,5}','maxlength'=>'5']).
                                        '</div>'.
                                    '</div>
                                </div>

                                <div class="row form-group" style="border: 1px solid #ddd; margin: auto 12px 0px 0px; border-radius: 6px; spadding: 12px;">
                                 
                                    <div class="col-md-2">'.
                                        form_label('Online Payment','olp',['class'=>'text-info font-weight-bold']).
                                        form_radio(['name'=>'bd','id'=>'olp','class'=>'form-control','style'=>'display: inline-block; position: absolute; margin: 5px 0px 0px 50px; left: 0;','disabled'=>'true','onClick'=>'active_payment_div(\'online_payment_div\',this);','value'=>'3']).
                                    '</div>'.

                                

                                    form_fieldset('<small class="fa fa-rupee-sign text-info"></small>&nbsp;&nbsp;Online Payment',['class'=>'text-success d-none','id'=>'online_payment_div','style'=>'margin:15px 12px;']).

                                        '
                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('Total Amount&nbsp;<sup class="fa fa-star text-danger"></sup>','totalamount').
                                                form_input(['name'=>'totalamount','id'=>'totalamount','required'=>'true','class'=>'form-control','pattern'=>'[-\/.,&a-zA-Z0-9 ]{2,150}','maxlength'=>'150','title'=>'Allowed alpha numeric and (-/.,&) only','placeholder'=>'Bank name','value'=>'3025','readonly'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Remain Amount&nbsp;<sup class="fa fa-star text-danger"></sup>','remainamount').
                                                form_input(['name'=>'remainamount','id'=>'remainamount','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{4,50}','maxlength'=>'50','value'=>'3025','title'=>'Allowed only numeric','placeholder'=>'Challan/Ref number','readonly'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Paid Amount.&nbsp;<sup class="fa fa-star text-danger"></sup>','collectamount').
                                                form_input(['name'=>'collectamount','id'=>'collectamount','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{1,5}','maxlength'=>'5','value'=>'','title'=>'Allowed only numeric','placeholder'=>'Amount','readonly'=>'true']).
                                            '</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('Name&nbsp;<sup class="fa fa-star text-danger"></sup>','branch_name').
                                                form_input(['name'=>'ntrp','id'=>'ntrp','required'=>'true','class'=>'form-control','pattern'=>'[-\/.,&a-zA-Z0-9 ]{2,150}','maxlength'=>'150','title'=>'Allowed alpha numeric and (-/.,&) only','placeholder'=>'Bank name','value'=>'NTRP','disabled'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Challan/Ref. Number&nbsp;<sup class="fa fa-star text-danger"></sup>','dd_no').
                                                form_input(['name'=>'ntrpno','id'=>'ntrpno','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{0,13}','onkeypress'=>'return isNumberKey(event)','maxlength'=>'13','title'=>'Allowed only numeric','placeholder'=>'Challan/Ref number','disabled'=>'true']).
                                            '</div>
                                            <div class="col-md-4">'.
                                                form_label('Amount in Rs.&nbsp;<sup class="fa fa-star text-danger"></sup>','ia_fee').
                                                form_input(['name'=>'ntrpamount','id'=>'ntrpamount','required'=>'true','class'=>'form-control','pattern'=>'[0-9 ]{1,5}','maxlength'=>'5','title'=>'Allowed only numeric','placeholder'=>'Amount','disabled'=>'true']).
                                            '</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">'.
                                                form_label('Challan/Date&nbsp;<sup class="fa fa-star text-danger"></sup>','dd_date').
                                                form_input(['name'=>'ntrpdate','id'=>'ntrpdate','required'=>'true','class'=>'form-control','readonly'=>'true','onClick'=>'trans_date(this);','style'=>'max-width: 160px;','disabled'=>'true']).'<span class="fa fa-calendar-alt text-danger" style="position: absolute; top:0; margin: 38px 136px; font-size: 20px; opacity: 0.4;"></a>'.
                                            '</div>

                                            <div class="col-md-4">
                                              <input type="button" name="btnSubmit" id="btnSubmit" value="Add Amount" class="btn btn-success btn-lg float-left" onclick="addMoreAmount()"/>
                                            </div>

                                        </div>

                                         <div class="table-responsive text-secondary" id="add_amount_list">
                                        </div>'.
                                    form_fieldset_close().
                            '</div><input type="button" name="btnSubmit" id="btnSubmit" value="Save" class="btn btn-success" onclick="caveatee();">';

                            echo form_fieldset_close(); 
                        ?>           
               
                    <?= form_fieldset_close(); ?>
                </div>
            <?= form_close();?>
        </div>
	</div>

    <div class="row">
        <div class="card w-100" style="padding: 0px 12px;">
            <?php 
                echo form_fieldset('ADDED CAVEATE\'S LIST',['style'=>'margin-top:12px;border: 2px solid #4cb060;']);?>
                 <i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 21px 6px;"></i>
                    <div class="d-block text-center text-warning">
                        <div class="table-responsive text-secondary" id="caveat_filing_list">
                             <table  id="table" cellspacing="0"  width="100%">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Caveat No</th>
                                            <th>Caveat Name</th>
                                            <th>Caveatee Name</th>
                                            <th>Case No</th>
                                            <th>Case Year</th>
                                            <th>Decision Date</th>
                                            <th>Commission Nname</th>
                                            <th>Receipt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  <?php    
                           
                                  $master_caveat_list = array();
                                  $userdata=$this->session->userdata('login_success');
                                  
                                  if(!empty($userdata)){
                                      $user_id=$userdata[0]->id;
                                  $sql22_caveat_detail =  $this->efiling_model->data_list_where('caveat_detail','filed_user_id',$user_id);
                                  $i=1;
                                  foreach ($sql22_caveat_detail as $row444 ) {
                                    $commission = $row444->commission;
                                    $hscquery = $this->efiling_model->data_list_where('master_commission','id',$row444->commission);
                                    $commision_anme =  $hscquery[0]->short_name;
                                    $caveat_no = $row444->caveat_filing_no;
                                    
                                    $filing_No = substr($caveat_no, 5, 6);
                                    $filingYear = substr($caveat_no, 11, 4);
      
                                    $caveat_no= 'CAVEAT/'.$filing_No.'/'.$filingYear;
                                    
                                    $commission_name = $commision_anme;
                                    $caveat_no_secu = base64_encode($row444->caveat_filing_no);?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $caveat_no; ?></td>
                                    <td><?php echo $row444->caveat_name; ?></td>
                                    <td><?php echo $row444->caveatee_name; ?></td>
                                    <td><?php echo $row444->case_no; ?></td>
                                    <td><?php echo $row444->case_year; ?></td>
                                    <td><?php echo $row444->decision_date; ?></td>
                                    <td><?php echo $commision_anme; ?></td>
                                    <td> <a href="javascript:void(0);"  data-toggle="modal" onclick="return popitup('<?php echo $caveat_no_secu ?>')"><b>Print Recipt </b></a>
                                    </td>
                                </tr>                                  
                   			<?php  $i++; } 
                                  } ?>  
                        </div>
                    </div>
              <?php   echo form_fieldset_close(); ?>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                        <div class="modal-content">
                         <form action="certifiedsave.php" method="post">
                              <div class="modal-header" style="background-color: cadetblue;">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div id="viewsss">
                              </div>
                          </form>
                      </div>
                 </div>
            </div> 
            
<!-- Caveat Recipt Modal -->
<div class="modal fade modal_ngt" id="caveatRecipt" role="dialog">
  <div class="modal-dialog modal-dialog-centered" style="min-width: 1200px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="fa fa-print print-div" onclick="printRecipt();">&nbsp;</button>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="container_inner" id="printable-div">            
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("admin/footer"); ?>
<script>

function deletePaycaveate(e) {
    var payid = e;
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    var token_hash=HASH(payid+'upddoc');
    var salt = document.getElementById("saltNo").value;
    var dataa={};
    dataa['payid']=payid,
    dataa['salt']=salt,
    dataa['token_hash']=token_hash,
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreddcaveat',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		$('#add_amount_list').html(resp.display);
        		$('#remainamount').val(resp.remain);
        		$('#collectamount').val(resp.paid);
			}else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
		}
	 });

}



function addMoreAmount() {
    var salt = document.getElementById("saltNo").value;
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    if (bd == 3) {
        var dbankname = document.getElementById("ntrp").value;
        if (dbankname == "") {
            alert("Please Enter Bank name");
            document.filing.ntrp.focus();
            return false;
        }
        var ddno = document.getElementById("ntrpno").value;
        if (ddno == "") {
            alert("Please Enter Challan No/Ref.No");
            document.filing.ntrpno.focus();
            return false
        }
        var dddate = document.getElementById("ntrpdate").value;
        if (dddate == "") {
            alert("Please Enter Date of Transction");
            document.filing.ntrpdate.focus();
            return false
        }
        var amountRs = document.getElementById("ntrpamount").value;
        if (amountRs == "" || amountRs<=0) {
            alert("Please Enter Amount ");
            document.filing.ntrpamount.focus();
            return false
        }
        var vasks = ddno.toString().length;
	      if(Number(vasks) != 13){
	         alert("Please Enter 13  Digit Challan No/Ref.No");
	         document.ntrpno.focus();
	         return false
	       }
    }
    var remainamount = document.getElementById("remainamount").value;
    var totalamount = document.getElementById("totalamount").value;
    var dataa={};
    dataa['dbankname']=dbankname,
    dataa['amountRs']=amountRs,
    dataa['ddno']=ddno,
    dataa['dddate']=dddate,
    dataa['bd']=bd,
    dataa['salt']=salt,
    dataa['totalamount']=totalamount,
    dataa['remainamount']=remainamount,
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreddcaveat',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		$('#remainamount').val(resp.remain);
        		$('#collectamount').val(resp.paid);
        		$('#add_amount_list').html(resp.display);
			}else if(resp.error == '0') {
				$.alert(resp.display);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
		}
	 }); 

    if (bd == 3) {
        document.getElementById("ntrpno").value = "";
        document.getElementById("ntrpdate").value = "";
        document.getElementById("ntrpamount").value = "";
    }

}

function excution() {
	var salt = document.getElementById("saltNo").value;
	if(salt==''){
        var salt = Math.ceil(Math.random() * 100000);
        document.getElementById("saltNo").value = salt;
    }
    var commission = document.getElementById("commission1").value;
    if (commission == "") {
        alert("Please Select Commission");
        document.commission1.focus();
        return false;
    }
    var natureOrder = document.getElementById("caseTypeold").value;
    if (natureOrder == "") {
        alert("Please Select Case Type");
        document.caseTypeold.focus();
        return false;
    }
    var caseNo = document.getElementById("caseNo").value;
    if (caseNo == "") {
        alert("Please Enter Case No");
        document.caseNo.focus();
        return false;
    }
    var caseYear = document.getElementById("year").value;
    if (caseYear == "") {
        alert("Please Enter Case Year");
        document.year.focus();
        return false;
    }
    var ddate = document.getElementById("decisionDate").value;
    if (ddate == "") {
        alert("Please Enter Decision Date (YYYY-MM-DD)!");
        document.decisionDate.focus();
        return false;
    }
    var namecav = document.getElementById("caveatname").value;
    var raddress = document.getElementById("addressTparty").value;
    var dstate = document.getElementById("dstate").value;

    if (dstate == 'Select State Name') {
        alert("Please Select State Name !");
        document.dstate.focus();
        return false;
    }
    var ddistrict = document.getElementById("district").value;
    if (ddistrict == 'Select District Name') {
        alert("Please Select District Name !");
        document.ddistrict.focus();
        return false;
    }
    if (ddistrict == '') {
        alert("Please Select District Name !");
        document.ddistrict.focus();
        return false;
    }
    var pinNo = document.getElementById("pin").value;
    var email = document.getElementById("email").value;
    var phone = document.getElementById("phone").value;
    var mob = document.getElementById("mob").value;
    var prayer = document.getElementById("Prayer").value;
    var ddecision11 = ddate.split("/");
    var decision=ddecision11[2]+"-"+ddecision11[1]+"-"+ddecision11[0]; 

    var advCode= document.getElementById("advCode").value;
    var councilAdd= document.getElementById("councilAdd").value;
    var councilemail= document.getElementById("councilemail").value;
    var councilphone= document.getElementById("councilphone").value;
    var councilmob= document.getElementById("councilmob").value;
    
    var dataa = {};
    dataa['salt'] = salt,
    dataa['com'] =  commission,
    dataa['noforder'] =  natureOrder,
    dataa['cno'] =  caseNo,
    dataa['cyear'] =  caseYear,
    dataa['ddate'] =  ddate,
    dataa['cname'] =  namecav,
    dataa['cadd'] =  raddress,
    dataa['cstate'] =  dstate,
    dataa['cdis'] = ddistrict,
    dataa['pinNo'] =  pinNo,
    dataa['email'] =  email,
    dataa['phone'] =  phone,
    dataa['mob'] = mob,
    dataa['prayer'] =  prayer,

    dataa['advCode'] =  advCode,
    dataa['councilAdd'] =  councilAdd,
    dataa['councilemail'] =  councilemail,
    dataa['councilphone'] =  councilphone,
    dataa['councilmob'] =  councilmob,    
    $.ajax({
        type: "POST",
        url: base_url+'caveatee',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
             console.log(data1);
             var data2 = JSON.parse(data1);
             if(data2.data=='success'){
             	document.getElementById("caveator").style.display = 'none';
             	$('#fee_div').removeClass('d-none').find('input').removeAttr('disabled').attr('required',true);
             	document.getElementById("saltVal").value=salt; 
             	document.getElementById("caveatee").style.display = 'block';           
             }else{
                 alert(data2.display);
               return false;
             }
        }
    });

}



function caveatee() {
	  var select_org_app = document.getElementById("select_org_app").value;
	  var Namecav = document.getElementById("Namecav").value;
	  if (Namecav == "") {
	      alert("Please Enter The Name !");
	      document.Namecav.focus();
	      return false;
	  }
	  var dstate = document.getElementById("dstate1").value;
	  if (dstate == 'Select State Name') {
	      alert("Please Select State Name !");
	      document.dstate.focus();
	      return false;
	  }
	  var phonecav = document.getElementById("phonecav").value;
	  var addresscav = document.getElementById("addresscav").value;
	  var pincav = document.getElementById("pincav").value;
	  var mobcav = document.getElementById("mobcav").value;
	  var ddistrict = document.getElementById("ddistrict1").value;
	  if (ddistrict == 'Select District Name') {
	      alert("Please Select District Name !");
	      document.ddistrict.focus();
	      return false;
	  }
	  var emailcav = document.getElementById("emailcav").value; 

	  var radios = document.getElementsByName("bd");
	  
	  var saltVal = document.getElementById("saltVal").value;
	  var bd = 0;
	  for (var i = 0; i < radios.length; i++) {
	      if (radios[i].checked) {
	          var bd = radios[i].value;
	      }
	  }

	 

      
	  if(bd==''){
		  alert("Please select payment mode");
	      return false;
	  }
		if (bd == 3) {
		    var ddno = $("#ntrpno").val();
		    var amountRs = $("#ntrpamount").val();
		    var dddate = $("#ntrpdate").val();
		    var dbankname = $("#ntrp").val();
		    if (dbankname == "") {
		        alert("Please Enter Bank name");
		        document.ntrp.focus();
		        return false;
		    }
		    if (ddno == "") {
		        alert("Please Enter Challan No/Ref.No");
		        document.ntrpno.focus();
		        return false
		    }
		    if (dddate == "") {
		        alert("Please Enter Date of Transction");
		        document.ntrpdate.focus();
		        return false
		    }
		    if (amountRs == "") {
		        alert("Please Enter Amount ");
		        document.ntrpamount.focus();
		        return false
		    }


            var collectamount= $("#collectamount").val();
		    if(collectamount==''){
		    	 var collectamount=0;
			}
		    var totalamount= parseInt($("#totalamount").val());
		    var proanx=parseInt(amountRs)+parseInt(collectamount);
		    if(totalamount>proanx  && totalamount<=0){
		       alert("Please Enter amount greather than total amount ");
		       document.ntrpno.focus();
		       return false
		    }


		   var vasks = ddno.toString().length;
	       if(Number(vasks) != 13){
         		alert("Please Enter 13  Digit Challan No/Ref.No");
        		 document.ntrpno.focus();
         		return false
       		}
		}

	  var token=Math.random().toString(36).slice(2); 
	  var token_hash=HASH(token+amountRs);

	  var dataa = {};
	  dataa['select_org_app'] =select_org_app,
	  dataa['Namecav'] =Namecav,
	  dataa['dstate'] =dstate,
	  dataa['phonecav'] =phonecav,
	  dataa['addresscav'] =addresscav,
	  dataa['pincav'] =pincav,
	  dataa['mobcav'] =mobcav,
	  dataa['ddistrict'] =ddistrict,
	  dataa['emailcav'] =emailcav,
	  dataa['ddno'] = ddno,
	  dataa['amountRs'] =  amountRs,
	  dataa['dddate'] =  dddate,
	  dataa['dbankname'] =  dbankname,
	  dataa['saltVal'] =  saltVal,
	  dataa['bd'] =  bd,
	  dataa['token_hash'] =  token_hash,
	  dataa['token'] =  token,
	  
	  $.ajax({
	      type: "POST",
	      url: base_url+'caveatSubmit',
	      data: dataa,
	      cache: false,
	      success: function (petSection) {
	      	   var data1 = petSection;
	           var data2 = JSON.parse(data1);
	           if(data2.data=='success'){
	        	   $('#caldetail').html(data2.display);
	        	   $("#caveat-form-div").css("display", "none");
	           }else{
	        	   $.alert(data2.display);
	           }
	      }
	  });
	}






function apple_org_details(str) {
    if (str == "") {
        $("#Namecav").val('');
        $("#addresscav").val('');
        $("#mobcav").val('');
        $("#emailcav").val('');
        $("#phonecav").val('');
        $("#pincav").val('');
        $("#dstate").val('');
        $("#ddistrict").val('');
    }
    var dataa = {};
	dataa['q'] = str;
    $.ajax({
        type: "POST",
        url: base_url+'org',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
             console.log(data1);
             var data2 = JSON.parse(data1);
             if (str != 0) {
                 showCity(data2[0].stcode, data2[0].dcode);
                 $("#Namecav").val(data2[0].org_name);
                 $("#addresscav").val(data2[0].address);
                 $("#mobcav").val(data2[0].mob);
                 $("#emailcav").val(data2[0].mail);
                 $("#phonecav").val(data2[0].ph);
                 $("#pincav").val(data2[0].pin);
                   $('select[name=dstate1] > option').each(function(){
     				if($(this).val()==$.trim(data2[0].stcode)) {
     						$(this).attr('selected',true);
     				}
     				else 	$(this).attr('selected',false);
     			});
                 $('select[name=ddistrict1]').empty().removeAttr('disabled',false).append('<option value="'+data2[0].dcode+'">'+data2[0].dname+'"<option>');
             }
        }
    });
}

function showCity(state_id, city_id) {
	var dataa = {};
	dataa['state_id'] = state_id;
    $.ajax({
    	 type: "POST",
    	url: base_url+'district',
        data: dataa,
        cache: false,
        success: function (districtdata) {
            $("#ddistrict1").html(districtdata);
            $("#ddistrict1").val(city_id);
        }
    });
}


function showCityRes(state_id, city_id) {
	var dataa = {};
	dataa['state_id'] = state_id;
    $.ajax({
    	 type: "POST",
    	url: base_url+'district',
        data: dataa,
        cache: false,
        success: function (districtdata) {
            $("#ddistrict").html(districtdata);
            $("#ddistrict").val(city_id);
        }
    });
}



function showUser(str) {
    if (str == '') {
        document.getElementById("cavCouncilpin").value = "";
        document.getElementById("cavCouncilmob").value = "";
        document.getElementById("cavCounciladdress").value = "";
        document.getElementById("cavCouncilemail").value = "";
    }
   var dataa = {};
   dataa['q'] = str;
   $.ajax({
    	 type: "POST",
    	url: base_url+'getAdvDetail',
        data: dataa,
        cache: false,
        success: function (districtdata) {
            var data2 = JSON.parse(districtdata);
            document.getElementById("cavCounciladdress").value = data2[0].address;
            document.getElementById("cavCouncilmob").value = data2[0].mob;
            document.getElementById("cavCouncilemail").value = data2[0].mail;
            document.getElementById("cavCouncilpin").value = data2[0].pin;
        }
    });
}

function get_org_data(id) {
	event.preventDefault();
	var org_id='', org_text='';
	org_id=$(id).val(), org_text=$('select[name=organization] option:selected').text();
	;
	$.ajax({
		type: 'post',
		url: base_url+'getOrgfurther',
		data: {'org_id': org_id},
		dataType: 'json',
		cache: false,
		success: function(retrn){
			$('textarea[name=addressTparty]').val(retrn[0].org_address);
			$('select[name=dstate] > option').each(function(){
				if($(this).val()==$.trim(retrn[0].state)) {
						$(this).attr('selected',true);
				}
				else 	$(this).attr('selected',false);
			});

			
			$('input[name=caveatname]').val(retrn[0].orgdisp_name);
                        $('select[name=ddistrict]').empty().removeAttr('disabled',false).append('<option value="'+retrn[0].district+'">'+retrn[0].district_name+'"<option>');
				
			$('input[name=pin]').val(retrn[0].pin);
			$('input[name=email]').val(retrn[0].email);
			$('input[name=mob]').val(retrn[0].mobile_no);
		},
		error: function(){
			$.alert('Server busy, try later');
		}
	});
	}

	function get_adv_data(id) {
		event.preventDefault();
		var adv_code='';
		adv_code=$(id).val();
		
		$.ajax({
			type: 'post',
			url: base_url+'list_data',
			data: {'adv_code': adv_code,'table_name':'master_advocate'},
			dataType: 'json',
			cache: false,
			success: function(retrn){
				$('textarea[name=councilAdd]').val(retrn[0].address);
				$('input[name=council_email]').val(retrn[0].email);
				$('input[name=councilphone]').val(retrn[0].adv_phone);
				$('input[name=councilmob]').val(retrn[0].adv_mobile);
			},
			error: function(){
				$.alert('Server busy, try later');
			}
		});
	}
    function popitup(filingno) {
   	 var dataa={};
        dataa['filing_no']=filingno,
         $.ajax({
             type: "POST",
             url: base_url+"/efiling/caveat_receipt",
             data: dataa,
             cache: false,
             success: function (resp) {
           	  $("#getCodeModal").modal("show");
            	  document.getElementById("viewsss").innerHTML = resp; 
             },
             error: function (request, error) {
 				$('#loading_modal').fadeOut(200);
             }
         }); 
   	  
   }


  function orgshow() {
        var checkboxes = document.getElementsByName('org');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                idorg = checkboxes[i].value;
            }
        }
        if (idorg == 1) {
            document.getElementById("org").style.display = 'block';
            document.getElementById("ind").style.display = 'none';
        }
        if (idorg == 2) {
            document.getElementById("ind").style.display = 'block';
            document.getElementById("org").style.display = 'none';
            
            document.getElementById("select_org_res").value = '';
            document.getElementById("caveatname").value = '';
            document.getElementById("addressTparty").value = '';
            document.getElementById("dstate").value = '';
            document.getElementById("district").value = '';
            document.getElementById("email").value = '';
            document.getElementById("phone").value = '';
            document.getElementById("mob").value = '';
            document.getElementById("Prayer").value = '';
            document.getElementById("pin").value = '';
            
        }
    }


    function orgshow1() {
        var checkboxes = document.getElementsByName('org1');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                idorg = checkboxes[i].value;
            }
        }
        if (idorg == 1) {
            document.getElementById("caveateeorg").style.display = 'block';
            document.getElementById("caveateeind").style.display = 'none';
        }
        if (idorg == 2) {
            document.getElementById("caveateeind").style.display = 'block';
            document.getElementById("caveateeorg").style.display = 'none';
            document.getElementById("Namecav").value = '';
             var dropDown = document.getElementById("dstate1");
            dropDown.selectedIndex = 0;
            document.getElementById("phonecav").value = '';
            document.getElementById("addresscav").value = '';
            document.getElementById("pincav").value = '';
            document.getElementById("mobcav").value = '';
            document.getElementById("ddistrict1").value = '';
            document.getElementById("emailcav").value = '';
        }
    }


  function isNumberKey(evt){ 
        var act_id = $("#caseTypeold").val();
    	if(act_id!=17){
           var charCode = (evt.which) ? evt.which : event.keyCode
           if (charCode > 31 && (charCode < 48 || charCode > 57)){
             return false;
           }else{
       		 return true;
           }
    	}
    }




</script>