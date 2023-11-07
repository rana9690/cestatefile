<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="middle_wrapper wrapbanner">
    <div class="col-left div-padd">
        <ul id="lightSlider">
            <li>
                <div class="slidebg" style="background-image: url(<?= base_url('asset/APTEL_files/slide1.jpg');?>);">
                </div> 
            </li>
            <li>
                <div class="slidebg" style="background-image: url(<?= base_url('asset/APTEL_files/slide2.jpg');?>);">
                </div> 
            </li>
            <li>
                <div class="slidebg" style="background-image: url(<?= base_url('asset/APTEL_files/banner2.jpg');?>);">
                </div> 
            </li>
        </ul> 
    </div>
    <div class="col-right">
        <div class="header">
            <div class="title">User Login</div>
        </div>
        <div class="container_inner form_wrapper">
            <div class="responseMsg hide">
                <div class="alert alert-danger btn-xs" id='responseMsg'></div>
                <i class="fas fa-times-circle" style="position: absolute; top: 20px;"></i>
            </div>
            <?php 
              echo form_open(false,['id'=>'userLogin', 'autocomplete'=>'off']).
                    '<div class="form-group mbottom-none">'.
                    form_label('&nbsp;&nbsp;User Name','username',['class'=>'fa fa-user','style'=>'']).
                      form_input(['id'=>'loginId','placeholder'=>'Username',  'maxlength'=>'50','class'=>'form_field','required'=>'true']).
                    '</div>
                    <div class="form-group mbottom-none">'.
                      form_label('&nbsp;&nbsp;Password','pwd',['class'=>'fa fa-lock','style'=>'']).
                      form_password(['id'=>'pwd', 'class'=>'form_field ','placeholder'=>'Password','required'=>'true']).
                      '<div class="btn_viewPass" style="position: absolute; margin: 4px 0px 0px -27px; font-size: 20px; display: inline-block;"><i class="fa fa-eye"></i></div>
                    </div>
                    <div class="form-group imgcaptcha">
                      <div id="captcha_data" style="display: inline-block">'.
                            $captcha_data["image"].
                      '</div>
                        <a href="javascript:void(0);" id="refresh" style="position: absolute; margin: 5px 5px 0px; font-size: 19px; display: inline-block;"><i class="fa fa-sync-alt"></i>
                        </a>
                      <div style="display: inline-block; float: right; width: 116px;">'.
                          form_input(['id'=>'skey','placeholder'=>'Enter Captcha','class'=>'form_field','required'=>'true','maxlength'=>'6']).
                      '</div>
                    </div>
                    <div class="form-group">'.
                      form_submit(['class'=>'btn btn-2 btn-lg btn-block','value'=>'Login','id'=>'login-btn','disabled'=>'true']).
                    '</div>
                    <div class="row no-margin">
                      <div class="col-md-6 no-gutter">
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#indvModal" style="white-space:nowrap;">New user? Signup</a>
                      </div>
                      <div class="col-md-6 no-gutter text-right">
                        <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#forgotpassModal">Forgot password?</a>
                      </div>
                    </div>'.
                    form_close();
        ?>
        </div>
    </div>



</div>
</div>


<div class="content_sec1">
    <h1 class="headingWithLine"><span>About Us</span></h1>
    <p>The Customs Excise and Service Tax Appellate Tribunal (CESTAT) was constituted originally as Customs, Excise &
        Gold (Control) Appellate Tribunal (CEGAT) on October 11, 1982 under section 129 of the Customs Act, 1962. It was
        renamed CESTAT on 14 May 2003. Although it has been created under the Customs Act, it is mandated to decide
        appeals under the following four Acts. However, tribunal may, in its discretion, refuse to admit an appeal in
        respect of an order where the amount of fine or penalty determined by such order, does not exceeds Two Lakhs
        rupees.</p>
</div>


<div class="section no-border-bottom overlay-black" style="background-image: url(asset/APTEL_files/bg-facts.jpg)">
    <div class="content_sec1">
        <div class="row counter-row">
            <div class="counter color-alt">
                <i class="fa fa-user"></i>
                <p><span class="counted-before"><?=$registerdusers['registreduser']?></span></p>
                <h6>Total<br>Registered Users</h6>
            </div>

            <div class="counter color-alt">
                <i class="fa fa-gavel"></i>
                <p><span class="counted-before"><?=$registerdusers['registredadvocate']?>
                    </span></p>
                <h6>Total<br>Advocate Registered</h6>
            </div>

            <div class="counter color-alt">
                <i class="fa fa-book"></i>
                <p><span class="counted-before"><?=$registerdcases['totalefilied']?>
                    </span></p>
                <h6>Total<br>E-filed Appeals</h6>
            </div>

            <div class="counter color-alt">
                <i class="fa fa-file"></i>
                <p><span class="counted-before"><?=$registerdcases['totalthismonth']?>
                    </span></p>
                <h6>Current<br>Month Appeals</h6>
            </div>
        </div>

    </div>
</div>

<!--================= slider and Chairman message section end ===================== -->