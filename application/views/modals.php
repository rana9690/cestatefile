<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.autosuggest {
    list-style: none;
    margin: 0;
    padding: 0;
    position: absolute;
    left: 15px;
    top: 57px;
    z-index: 1;
    background: #fff;
    width: 94%;
    box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.2);
    overflow-y: auto;
    max-height: 280px;
}

.autosuggest li {
    padding: 8px 10px;
    font-size: 13px;
    color: #26c0d9;
    cursor: pointer;
}

.autosuggest li:hover {
    background: #f5f5f5;
}

#captcha_data img {
    width: 103px;
    height: 34px;
}

.carousel-inner>.item>a>img,
.carousel-inner>.item>img,
.img-responsive,
.thumbnail a>img,
.thumbnail>img {
    width: 100%;
}
</style>


<!-- Disclaimer -->
<div class="modal fade modal_ngt" id="disclaimer" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disclaimer</h4>
                <button type="button" class="close notagree">&times;</button>
            </div>
            <div class="modal-body">

                <h4><b>Want to Continue with <?=$this->config->item('site_name')?>
                    <!--a href="javascript" target="new_1" class="fa fa-eye text-danger">&nbsp;&nbsp;Disclaimer</a-->
</b></h4>
                <div class="container_inner">
                    <p>I have read the contents of the site and the instructions given thereof as regards registration
                        and e-filing of
                        appeal/documents before the CESTAT and agree with the same. I hereby declare that the
                        information given in
                        the appeal/documents are true and correct to the best of my knowledge. I hereby acknowledge and
                        certify that the
                        attachments/enclosures/appendix made along with the appeal/application are true and correct and
                        are valid as per the original documents.
                        I further certify that I have personally or through my counsel/advocate completed the
                        appeal/application and have e-filed the same.
                        I understand that any misrepresentation, falsification or suppression of information in the
                        appeal /application or any document used for
                        registration shall be a valid ground for rejection of the appeal/application apart from any
                        other penalty for perjury.</p>
                </div>
                <div class="heading" style="margin-top: 12px; border-radius: 8px;">
                    <?= form_input(['id'=>'lurole','disabled'=>'true','type'=>'hidden']).
                  form_label('Click to Agree','agree',['class'=>'form-control btn btn-primary mt-2','style'=>'']).
                  form_checkbox(['id'=>'agree','checked'=>false,'style'=>'position: absolute; display:none;margin: -29px 18px;']);
              ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Login -->
<div class="modal fade modal_ngt" id="loginModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-unlock"></i>&nbsp;&nbsp;e-Filing Login</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container_inner">
                    <div class="responseMsg hide">
                        <div class="alert alert-danger btn-xs" id='responseMsg'></div>
                        <i class="fas fa-times-circle" style="position: absolute; top: 20px;"></i>
                    </div>
                    <?php 
              echo form_open(false,['id'=>'userLogin', 'autocomplete'=>'off']).
                    '<div class="form-group mbottom-none">'.
                    form_label('&nbsp;&nbsp;User Name','username',['class'=>'fa fa-user','style'=>'font-size: 18px;color:#840f0f;']).
                      form_input(['id'=>'loginId','placeholder'=>'Username', 'class'=>'form_field','pattern'=>'[A-Za-z0-9_]{6,50}','required'=>'true']).
                    '</div>
                    <div class="form-group mbottom-none">'.
                      form_label('&nbsp;&nbsp;Password','pwd',['class'=>'fa fa-lock','style'=>'font-size: 18px;color:#840f0f;']).
                      form_password(['id'=>'pwd', 'class'=>'form_field','required'=>'true']).
                      '<div class="btn_viewPass" style="position: absolute; margin: 4px 0px 0px -27px; font-size: 20px; display: inline-block;"><i class="fa fa-eye"></i></div>
                    </div>
                    <div class="form-group">
                      <div id="captcha_data" style="display: inline-block">'.
                            $captcha_data["image"].
                      '</div>
                        <a href="javascript:void(0);" id="refresh" style="position: absolute; margin: 5px 8px 0px; font-size: 22px; display: inline-block;"><i class="fa fa-sync-alt"></i>
                        </a>                         
                      <div style="display: inline-block; margin-left: 60px; float: right; width: 244px;">'.
                          form_input(['id'=>'skey','placeholder'=>'Enter Captcha','class'=>'form_field','required'=>'true','maxlength'=>'6']).
                      '</div>
                    </div>
                    <div class="form-group">'.
                      form_submit(['class'=>'btn btn-success btn-lg btn-block','value'=>'Login','id'=>'login-btn','disabled'=>'true']).
                    '</div>
                    <div class="row no-margin">
                      <div class="col-6 no-gutter">
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#indvModal">New user? Signup</a>
                      </div>
                      <div class="col-6 no-gutter text-right">
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#forgotpassModal">Forgot password?</a>
                      </div>
                    </div>'.
                    form_close();
        ?>
                </div>
            </div>
        </div>
    </div>
</div>






<!-- Modal Forgot Password -->
<div class="modal fade modal_ngt" id="forgotpassModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Forgot Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container_inner">
                    <?= form_open(false,['id'=>'forgetForm','autocomplete'=>'off']) ?>
                    <div class="row">
                        <div class="col-md-12">
                            <?= form_input(['name'=>'loginid','class'=>'form-control','placeholder'=>'Enter Username/Login ID','required'=>'true']) ?>
                        </div>
                        <div class="col-md-12 col-xs-12" style="margin-top: 15px;">
                            <?= form_input(['name'=>'email','type'=>'email','class'=>'form-control','placeholder'=>'Enter Your Registered Email- ID','required'=>'true']) ?>
                        </div>

                        <div class="col-md-12 col-xs-12" style="margin-top: 15px;">
                            <div id="captcha_data_pass" style="display: inline-block">
                                <?php echo $captcha_data["image"] ?>
                            </div>
                            <a href="javascript:void(0);" id="refreshcaptacha" class="refreshIcon"><i
                                    class="fa fa-sync-alt"></i>
                            </a>
                            <div
                                style="display: inline-block;margin-top:-20px;margin-left: 60px; float: right; width: 244px;">
                                '.
                                <?php echo form_input(['id'=>'skey_pass','name'=>'skey_pass','placeholder'=>'Enter Captcha','class'=>'form_field','required'=>'true','maxlength'=>'6']);?>
                            </div>
                        </div>

                        <div class="col-md-12 col-xs-12" style="margin-top: 15px;">
                            <?= form_submit(["class"=>"btn btn-2 btn-lg btn-block", "value"=>"Recover Password?",'id'=>'recover_pass']); ?>
                        </div>
                    </div>
                    <?= form_close(); ?>

                    <!--<div class="row" style="margin: 10px 0px 0px 0px;"> 
              <div class="col-md-12 text-right">
                <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#loginModal" class="btn-block"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to Login</a>
              </div>
            </div>-->

                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal Registration Form -->
<style>
#enrolment_number {
    display: inline-block;
}
</style>
<div class="modal fade modal_ngt" id="indvModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">e - filing User Registration</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="height: 520px;">

                <div class="container_inner" id="stepone_user">

                    <?php echo 
                  form_open(false,['autocomplete'=>'off','id'=>'regForm']).
                    '<div class="row top-sec">
                      <div class="col-md-4 form-group">'.
                        form_label('User Type','usertype',['class'=>'text-info','style'=>'']);
                        $typeofUser=[''=>'-----Select User Type-----','individual'=>'Individual','advocate'=>'Advocate','company'=>'Department'];
                        echo form_dropdown('user_type',$typeofUser,NULL,['class'=>'form-control','id'=>'user_type','required'=>'true']).
                      '</div>
                      <div class="col-md-8 form-group">
                        <div class="adv_div hide">
                            <div class="col-md-12">'.
                              form_label('Name/Register Number','barid',['class'=>'','style'=>'']).
                              form_input(['name'=>'enrolment_number','id'=>'_number','class'=>'form-control','pattern'=>'[0-9a-zA-Z\/-]{4,50}','disabled'=>'true','placeholder'=>'Name/Registerd Number','onkeypress'=>"serchrecordval(this.value);"]).
                            '
                            <ul class="autosuggest" id="regnum_autofill">
                            </ul>
                            </div>
                            <div class="col-md-12" id="recordadv"></div>
                        </div>

                        <div class="company_div hide">
                          <div class="col-md-6">'.
                            form_label('Department Name','org_name',['class'=>'','style'=>'']).
                            form_dropdown('org_name',NULL,NULL,['id'=>'org_name','class'=>'form-control','disabled'=>'true']).
                          '</div>
                          <div class="col-md-6" style="display:none;">'.
                            form_label('Short Name','short_org_name',['class'=>'','style'=>'']).
                            form_input(['name'=>'short_org_name','class'=>'form-control','disabled'=>'true','placeholder'=>'Short Name']).
                          '</div>
                          <div class="col-md-6 mtop-12" style="display:none;">'.
                            form_label('Administrator Name','org_admin',['class'=>'','style'=>'']).
                            form_input(['name'=>'org_admin','class'=>'form-control','disabled'=>'true','placeholder'=>'Administrator Name','pattern'=>'[-.A-Za-z0-9 ]{2,250}','required'=>'true']).
                          '</div>
                          <div class="col-md-6">'.
                            form_label('Designation','org_desg',['class'=>'','style'=>'']).
                            form_input(['name'=>'org_desg','class'=>'form-control','disabled'=>'true','placeholder'=>'Designation']).
                          '</div>
                        </div>
                      </div>
                    </div>

                    <div class="row mtop-12 selfName">
                      <div class="col-md-4">'.
                        form_label('First Name','fname',['class'=>'text-primary','style'=>'']).
                        form_input(['name'=>'fname','class'=>'form-control','required'=>'true','maxlength'=>'100','pattern'=>'[-.A-Za-z0-9 ]{2,50}','placeholder'=>'First Name']).
                      '</div>
                      <div class="col-md-4">'.
                      form_label('Last Name','lname',['class'=>'text-primary','style'=>'']).
                      form_input(['name'=>'lname','class'=>'form-control','maxlength'=>'100','pattern'=>'[-,.A-Za-z0-9 ]{0,150}','placeholder'=>'Last Name']).
                      '</div>
                      <div class="col-md-4">'.
                      form_label('Gender','gender',['class'=>'text-primary','style'=>'']);

                      $gender=[''=>'-----Select Gender-----','male'=>'Male','female'=>'Female','other'=>'Other'];
                        echo form_dropdown('gender',$gender,NULL,['class'=>'form-control','required'=>'true','id'=>'gender']).
                      '</div>
                    </div>

                    <div class="row mtop-12">
                      <div class="col-md-12">'.
                      form_label('Address','address',['class'=>'text-primary','style'=>'']).
                      form_textarea(['name'=>'address','class'=>'form-control','maxlength'=>'1000','pattern'=>'[-,\/&.A-Za-z0-9 ]{6,1000}','placeholder'=>'Address','required'=>'true','rows'=>'2','cols'=>'6']).
                      '</div>
                    </div>  
                      <div class="row mtop-12">
                      <div class="col-md-4">'.
                      form_label('Country Name','country',['class'=>'text-primary','style'=>'']);

                      $country=['india'=>'India'];
                        // if(@$countrys) :;
                        //   foreach($countrys as $value) :;
                        //       $country[@$value->country_code]=@$value->country_name;
                        //   endforeach;
                        // endif;
                        echo form_dropdown('country',@$country,'india',['class'=>'form-control','required'=>'true','id'=>'country']).
                      '</div>
                       <div class="col-md-4">'.
                        form_label('State Name','state',['class'=>'text-primary','style'=>'']);                          
                        $state=[''=>'-----Select State-----'];
                        if(@$states) :;
                          foreach($states as $value) :;
                              $state[@$value->state_code]=@$value->state_name;
                          endforeach;
                        endif;
                        echo form_dropdown('state',$state,NULL,['class'=>'form-control','required'=>'true','id'=>'state']).
                      '</div>
                      <div class="col-md-4">'.
                      form_label('District Name','district',['class'=>'text-primary','style'=>'']);
                        $district=[''=>'-----Select District Name-----'];
                        echo form_dropdown('district',$district,NULL,['class'=>'form-control','required'=>'true','id'=>'district','disabled'=>'true']).
                      '</div>
                    </div>
                    
                    <div class="row mtop-12">
                      <div class="col-md-4">'.
                      form_label('Pincode','pincode',['class'=>'text-primary','style'=>'']).
                      form_input(['name'=>'pincode','class'=>'form-control','required'=>'true','maxlength'=>'8','pattern'=>'[-.A-Za-z0-9 ]{6,15}','placeholder'=>'pincode']).
                      '</div>
                      <div class="col-md-8">'.
                      form_label('Login Id','loginid',['class'=>'text-primary','style'=>'']).
                      form_input(['id'=>'loginid','name'=>'loginid','class'=>'form-control','required'=>'true','maxlength'=>'100','pattern'=>'[-_A-Za-z0-9]{8,32}','placeholder'=>'Login Id should be 5 to 32 char(s)', 'title'=>'Login Id allowed only alpha numeric, underscore, dash & min. char(s) 8']).
                        '<span class="text-danger lallowNot hide"><i class="fa fa-times-circle"></i>&nbsp;User Id Already Existed.</span>
                      </div>
                    </div>
                    
                    <div class="row mtop-12">
                      <div class="col-md-4">'.
                      form_label('Mobile Number','mobilenumber',['class'=>'text-primary','style'=>'']).
                      form_input(['id'=>'mobilenumber','name'=>'mobilenumber','class'=>'form-control','required'=>'true','maxlength'=>'10','pattern'=>'[0-9]{10,10}','placeholder'=>'Mobile No.']).
                        '<span class="text-danger mallowNot hide"><i class="fa fa-times-circle"></i>&nbsp;Mobile Number Already Existed.</span>
                        <span class="btn btn-warning motp hide otpBtn"><i class="fa fa-mobile"></i>&nbsp;Send OTP</span>
                      </div>
                      <div class="col-md-8">
                      <div class="mobilecaptcha hide mbot-12">
                      <span class="text-success motp_msg hide block-inline">-</span>
                      <div id="captcha_data_pass_newmobile" style="display: inline-block">'.
                              '</div>
                                <a href="javascript:void(0);" id="mobileOtpcaptcharef" style="position: absolute; margin:25px 4px 0px; font-size: 18px; display: inline-block;"><i class="fa fa-sync-alt"></i>
                                </a>                         
                              <div style="display: inline-block;margin-left: 30px;">'.
                              form_input(['id'=>'mobileOtpcaptcha','name'=>'mobileOtpcaptcha','placeholder'=>'Enter Captcha', 'class'=>'form-control','required'=>'true','maxlength'=>'6']).
                         
                          '</div>
                          <input type="button" value="Submit"  class="btn btn-primary" onclick="verify_otp(1)">
                      </div>
                     </div>
                      <div class="col-md-4">'.
                      form_label('E-mail ID','email',['class'=>'text-primary','style'=>'']).
                      form_input(['id'=>'email','name'=>'email','class'=>'form-control','required'=>'true','maxlength'=>'100','placeholder'=>'', 'title'=>'']).
                        '<span class="text-danger eallowNot hide"><i class="fa fa-times-circle"></i>&nbsp;E-mail Id Already Existed.</span>
                        <span class="btn btn-warning eotp hide otpBtn"><i class="fa fa-envelope"></i>&nbsp;Send OTP</span>
                      </div>
                      <div class="col-md-8">
                      <div class=" emailcaptcha hide">
                      <span class="text-success eotp_msg hide block-inline">-</span>
                      <div id="captcha_data_pass_newemail" style="display: inline-block">'.
                              '</div>
                                <a href="javascript:void(0);" id="emailOtpcaptcharef" style="position: absolute; margin: 25px 4px 0px; font-size: 18px; display: inline-block;"><i class="fa fa-sync-alt"></i>
                                </a>                         
                              <div style="display: inline-block;margin-left: 30px;">'.
                              form_input(['id'=>'emailOtpcaptcha','name'=>'emailOtpcaptcha','placeholder'=>'Enter Captcha',  'class'=>'form_field','required'=>'true','maxlength'=>'6']).
                          '</div>
                          <input type="button" value="Submit"  class="btn btn-primary" onclick="verify_otp(2)">
                        </div>
                       </div>
                      </div> 
					
					 <div class="row mtop-12"> 
                   <div class="col-md-12 col-xs-12" style="margin-top: 15px;">
                      <div id="captcha_data_pass_new" style="display: inline-block">'.
                       $captcha_data["image"].
                      '</div>
                        <a href="javascript:void(0);" id="refreshcaptachanew" style="position: absolute; margin: 5px 5px 0px 0px; font-size: 22px; display: inline-block;"><i class="fa fa-sync-alt"></i>
                        </a>                         
                      <div style="display: inline-block;margin-left: 30px; width: 200px;">'.
                        form_input(['id'=>'skey_pass_new','name'=>'skey_pass_new','placeholder'=>'Enter Captcha','class'=>'form_field','required'=>'true','maxlength'=>'6']).
                      '</div>
                    </div>
                  </div>

                    <div class="row mtop-12">
                      <div class="col-md-4">'.
                           form_button(['content'=>'Back','value'=>'true','class'=>'btn greybg btn-block','data-dismiss'=>'modal']).
                        '</div>
                          <div class="col-md-4">'.
                           form_reset(['value'=>'Reset','class'=>'btn btn-2 btn-block']).
                        '</div>
                          <div class="col-md-4">'.
                           form_submit(['value'=>'Submit','class'=>'btn btn-primary btn-block','id'=>'regButton','disabled'=>'true']).
                        '</div>
                      </div>'.
                  form_close();

            ?>
                </div>

                <div class="container_inner" style="display:none;" id="document">
                    <?php echo 
         		 form_open(false,['autocomplete'=>'off','id'=>'regFormFinal']).
               '.<div class="row mtop-12">
	                <input type="hidden" value="" id="id_reff" name="id_reff">
                      <div class="col-md-3">'.
                      form_label('ID Proof','idproof',['class'=>'text-primary','style'=>'']).
                      form_dropdown('idptype',[''=>'Choose Document','PAN'=>'PAN Card','VOTER'=>'Voter Card','Cert_Reg'=>'Certificate of Registration','officeid'=>'office ID Card(In case of Department only)' ],'',['class'=>'form-control','required'=>'true','id'=>'idptype','disabled'=>'true']).
                      '</div>
                      <div class="col-md-6">'.
                      form_label('File','idproof',['class'=>'text-primary','style'=>'']).
                        '<div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">'.
                          form_upload(['id'=>'idproof','class'=>'custom-file-input','title'=>'Upload your ID Proof, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg',"disabled"=>"true"]).
                        '</div>                        
                        <div class="text-danger" style="float: right; margin: 2px 0px 8px 0px; border: 1px solid #c7c7c7; padding: 0px 8px; border-radius: 5px; background: #fff; font-size: 12px;">File type should be pdf/images only</div>
                      </div>
                      <div class="col-md-3">'.
                      form_label('Document Number','idproof',['class'=>'text-primary','style'=>'']).
                      form_input(['id'=>'id_number', 'name'=>'id_number','class'=>'form-control mycustom','required'=>'true','pattern'=>'[a-zA-Z0-9 ]{4,50}','maxlength'=>'50','disabled'=>'true']).
                     '</div>
                     <div class="col-md-12  mtop-12 text-right">'.
                      form_button(['content'=>'Cancel','value'=>'true','class'=>'btn btn-2 mr-1']).form_submit(['value'=>'Submit','class'=>'btn btn-primary','id'=>'regButtonfinal','disabled'=>'true']).
                        '</div> 
                     

                    </div>'; 
                    form_close();
                    ?>
                </div>
                <!--- DISPLAY UPLOADED ID PROOF ------>
                <div class="row" style="padding: 12px;min-height:600px;display:none;" id="idDisplay">
                    <iframe src="" frameborder="0" style="height:580px;width:100%" id="iframDisplay"></iframe>
                </div>
                <!-------End Document upload--------->


            </div>
        </div>
    </div>
</div>





<script>
/*************** For Advocate ***************/
function serchrecord(adv_code) {
    var adv_barid = adv_code;
    adv_code = {};
    adv_code['enrolment_number'] = adv_barid;
    if (adv_barid != '') {
        $.ajax({
            type: 'post',
            url: base_url + 'getAdvDetails',
            data: adv_code,
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                $('#loading_modal').modal(), $('.motp, .eotp, .motp_msg, .eotp_msg').addClass('hide');
            },
            success: function(retn) {

                if (retn.error == '0') {
                    if ($.trim(retn[0].adv_sex).toLowerCase() == 'm')
                        gender = 'male';

                    $('textarea[name="address"]').val(retn[0].address).attr('readonly', true);
                    $('#gender').val(gender).attr('selected', true).attr('readonly', true);
                    $('#state > option').each(function() {
                        if ($(this).val() == $.trim(retn[0].state_code)) {
                            $(this).attr('selected', true);
                            $('#state').attr('readonly', true);
                        } else $(this).attr('selected', false);
                    });

                    var country = 'india';

                    $('input[name="enrolment_number"]').val(retn[0].adv_reg).attr('readonly', true);


                    $('#country').empty().removeAttr('disabled', false).attr('readonly', true).append(
                        '<option value="india">' + country);



                    $('#district').empty().removeAttr('disabled', false).attr('readonly', true).append(
                        '<option value="' + retn[0].adv_dist + '">' + retn[0].district_name);

                    //$('#state').trigger("change");
                    var full_name = retn[0].adv_name;
                    const [first, rest] = full_name.split(/\s+(.*)/);
                    $('input[name="fname"]').val(first).attr('readonly', true);
                    $('input[name="lname"]').val(rest);
                    $('input[name="pincode"]').val(retn[0].adv_pin).attr('readonly', true);

                    var mobile = $.trim(retn[0].adv_mobile),
                        emailId = $.trim(retn[0].email);
                    /*mobile=$.trim(retn[0].adv_mobile).substring(0,6)+'XXXX',emailId=$.trim(retn[0].email),emailid_len=emailId.indexOf('@'),
                        final_email=emailId.substring(0,(emailid_len-4))+'XXXX'+emailId.substring(emailid_len);*/

                    $.alert({
                        title: '<div class="fa fa-exclamation text-danger"></div>&nbsp;Information',
                        content: "<p class='alert alert-success'>Dear user kindly verify all details.</p>",
                        animationSpeed: 2000
                    });

                    $('.motp, .eotp').removeClass("hide");
                    $('input[name="mobilenumber"]').val(mobile),
                        $('input[name="email"]').val(emailId);
                } else {
                    var error = '';
                    error = retn.error;
                    $('#enrolment_number').focus();
                    $('#add_adv').show();
                    $.alert({
                        title: '<div class="fa fa-exclamation text-danger"></div>&nbsp;Error',
                        content: "<p class='alert alert-danger'>" + error + "</p>",
                        animationSpeed: 2000
                    });
                }
            },
            error: function() {
                $.alert('Error : server busy, try later');
            },
            complete: function() {
                $('#regnum_autofill').hide();
                $('#loading_modal').modal('hide');
            }
        });
    } else {
        $.alert('Enter valid enrolment number.');
        $(this).val("").focus();
        return false;
    }
}

function serchrecordval(val) {
    $.ajax({
        type: 'post',
        url: base_url + 'getAdvSelect',
        data: {
            key: val
        },
        dataType: 'html',
        cache: false,
        beforeSend: function() {
            $('#loading_modal').modal(), $('.motp, .eotp, .motp_msg, .eotp_msg').addClass('hide');
        },
        success: function(retn) {
            $('#regnum_autofill').html(retn);
        },
        error: function() {
            $.alert('Error : server busy, try later');
        },
        complete: function() {
            $('#loading_modal').modal('hide');
        }
    });
}
</script>

<!---- Loading Modal ------------->
<div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1"
    id="loading_modal">
    <div class="modal-dialog modal-sm" style="margin: 25% 50%; text-align: center;">
        <div class="modal-content" style="width: 90px; height: 90px; padding: 15px 25px;">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
            <p class="text-danger" style="margin: 12px -12px;">Loading.....</p>
        </div>
    </div>
</div>

