<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.dbox {
    position: relative;
    background: rgb(231, 227, 210);
    background: -moz-linear-gradient(0deg, rgba(231, 227, 210, 1) 0%, rgba(241, 239, 227, 1) 100%);
    background: -webkit-linear-gradient(0deg, rgba(231, 227, 210, 1) 0%, rgba(241, 239, 227, 1) 100%);
    background: linear-gradient(0deg, rgba(231, 227, 210, 1) 0%, rgba(241, 239, 227, 1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e7e3d2", endColorstr="#f1efe3", GradientType=1);
    border-radius: 4px;
    text-align: center;
    margin: 20px 0 0;
    border: 1px solid #c1bdad;
    box-shadow: 3px 5px 8px rgba(0, 0, 0, 0.15);
}

.dbox__icon {
    position: absolute;
    transform: translateY(-50%) translateX(-50%);
    left: 50%;
}

.dbox__icon:before {
    width: 75px;
    height: 75px;
    position: absolute;
    background: #fda299;
    background: rgba(253, 162, 153, 0.34);
    content: '';
    border-radius: 50%;
    left: -17px;
    top: -17px;
    z-index: -2;
}

.dbox__icon:after {
    width: 60px;
    height: 60px;
    position: absolute;
    background: #f79489;
    background: rgba(247, 148, 137, 0.91);
    content: '';
    border-radius: 50%;
    left: -10px;
    top: -10px;
    z-index: -1;
}

.dbox__icon>i {
    background: #ff5444;
    border-radius: 50%;
    line-height: 40px;
    color: #FFF;
    width: 40px;
    height: 40px;
    font-size: 22px;
}

.dbox__body {
    padding: 0px 20px 0px 20px;
}

.dbox__count {
    display: block;
}

.dbox__count a {
    font-size: 30px;
    color: #26a69a !important;
    font-weight: bold !important;
    text-shadow: 1px 1px 1px #fff;
}

.dbox__title {
    font-size: 13px;
    color: #263238;
    font-weight: bold;
    text-transform: uppercase;
    text-shadow: 1px 1px 1px #fff;
}

.dbox__action {
    transform: translateY(-50%) translateX(-50%);
    position: absolute;
    left: 50%;
}

.dbox__action__btn {
    border: none;
    background: #FFF;
    border-radius: 19px;
    padding: 7px 16px;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 11px;
    letter-spacing: .5px;
    color: #003e85;
    box-shadow: 0 3px 5px #d4d4d4;
}


.dbox--color-2 {
    background: rgb(252, 190, 27);
    background: -moz-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: -webkit-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: linear-gradient(to bottom, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#fcbe1b', endColorstr='#f85648', GradientType=0);
}

.dbox--color-2 .dbox__icon:after {
    background: #fee036;
    background: rgba(254, 224, 54, 0.81);
}

.dbox--color-2 .dbox__icon:before {
    background: #fee036;
    background: rgba(254, 224, 54, 0.64);
}

.dbox--color-2 .dbox__icon>i {
    background: #fb9f28;
}

.dbox--color-3 {
    background: rgb(183, 71, 247);
    background: -moz-linear-gradient(top, rgba(183, 71, 247, 1) 0%, rgba(108, 83, 220, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(183, 71, 247, 1) 0%, rgba(108, 83, 220, 1) 100%);
    background: linear-gradient(to bottom, rgba(183, 71, 247, 1) 0%, rgba(108, 83, 220, 1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b747f7', endColorstr='#6c53dc', GradientType=0);
}

.dbox--color-3 .dbox__icon:after {
    background: #b446f5;
    background: rgba(180, 70, 245, 0.76);
}

.dbox--color-3 .dbox__icon:before {
    background: #e284ff;
    background: rgba(226, 132, 255, 0.66);
}

.dbox--color-3 .dbox__icon>i {
    background: #8150e4;
}

.dbox_row {
    overflow: hidden;
}

.col-6 {
    width: 50%;
    float: left;
}

.col-12 {
    width: 100%;
}

.col-6 a,
.col-12 a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

.dbox_label {
    color: #263238;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10px;
    text-shadow: 1px 1px 1px #fff;
}

.card {
    width: 100%;
    padding: 0px 12px;
    border-top: 0px;
    margin: 0px auto 40px auto;
    border-top-right-radius: 0px;
    border-top-left-radius: 0px;
    box-shadow: none;
    border: none;
}

.infobox {
    list-style: none;
    padding: 0;
    text-align: center;
    width: 100%;
    margin: 0;
}

.infobox li {
    position: relative;
    padding-bottom: 6px;
}

.infobox li a,
.infobox li span {
    color: #bf3139;
    display: inline-block;
    text-align: right;
    font-size: 13px;
    font-weight: bold;
    position: absolute;
    right: 0;
    top: 0;
}

.infobox li div {
    display: inline-block;
}

.infobox li div a {
    display: inline-block;
    text-align: left;
    position: relative;
}

.divider {
    border-top: 1px solid #c1bdad;
    border-bottom: 1px solid #fff;
    margin-top: 10px;
}

.panel {
    margin: 0 auto;
    height: 150px;
    position: relative;
    -webkit-perspective: 600px;
    -moz-perspective: 600px;
    box-shadow: none;
}

.panel .front,
.panel .back {
    text-align: center;
}

.panel .front {
    height: inherit;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 900;
    text-align: center;
    -webkit-transform: rotateX(0deg) rotateY(0deg);
    -moz-transform: rotateX(0deg) rotateY(0deg);
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -webkit-transition: all .4s ease-in-out;
    -moz-transition: all .4s ease-in-out;
    -ms-transition: all .4s ease-in-out;
    -o-transition: all .4s ease-in-out;
    transition: all .4s ease-in-out;
}

.panel .back {
    height: inherit;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1000;
    -webkit-transform: rotateY(-180deg);
    -moz-transform: rotateY(-180deg);
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -webkit-transition: all .4s ease-in-out;
    -moz-transition: all .4s ease-in-out;
    -ms-transition: all .4s ease-in-out;
    -o-transition: all .4s ease-in-out;
    transition: all .4s ease-in-out;
}

.panel.flip .front {
    z-index: 900;
    -webkit-transform: rotateY(180deg);
    -moz-transform: rotateY(180deg);
}

.panel.flip .back {
    z-index: 1000;
    -webkit-transform: rotateX(0deg) rotateY(0deg);
    -moz-transform: rotateX(0deg) rotateY(0deg);
}

.box1 {
    background: linear-gradient(145deg, rgb(247 240 234) 20%, rgb(207 221 250) 80%) !important;
    border-left: 3px solid #cc7722 !important;
    width: 100%;
    height: 100%;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}

.box2 {
    background: linear-gradient(145deg, rgb(207 221 250) 20%, rgb(247 240 234) 80%) !important;
    border-right: 3px solid #cc7722 !important;
    width: 100%;
    height: 100%;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    padding-bottom: 5px;
}

.box1 i.fa {
    font-size: 3rem;
}

.back-inner {
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin-top: 15px;
}

.back-inner .fa-check {
    font-size: 2rem;
    color: green;
}

.back-inner .fa-times {
    font-size: 2rem;
    color: red;
}

.back-inner h4 {
    margin-top: 10px;
    margin-bottom: 4px;
    font-size: 12px;
    font-weight: bold;
}

.back-inner span {
    font-size: 22px;
}

.box2 a.knowmore {
    text-align: right;
    display: block;
    color: #c72;
    bottom: 12px;
    position: absolute;
    right: 20px;
}
.box1 span {
    font-size: 30px;
}
.box1 h3 {
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
}
</style>
<div class="content" style="padding-top:0px;">
    <div class="row">
        <div class="card">
            <div class="row m-0">
                <div class="col-md-3 mb-4">
                    <div class="hover panel">
                        <div class="front">
                            <div class="box1">
                                <div><i class="fa fa-user-tie"></i></div>
                                <h3>Advocate</h3>
                                <span>19563</span>
                            </div>
                        </div>
                        <div class="back">
                            <div class="box2">
                                <div class="back-inner">
                                    <div>
                                        <h4 class="text-success">VARIFIED</h4>
                                        <span><?php echo count($adv_varified);?></span>
                                    </div>
                                    <div>
                                        <h4 class="text-danger">NOT VARIFIED</h4>
                                        <span>456</span>
                                    </div>
                                </div>
                                <a class="knowmore" href="<?php echo base_url(); ?>advocate_list">Know More <i
                                        class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-md-3 mb-4">
                    <div class="hover panel">
                        <div class="front">
                            <div class="box1">
                                <div><i class="fa fa-users"></i></div>
                                <h3>Registered User</h3>
                                <span>175</span>
                            </div>
                        </div>
                        <div class="back">
                            <div class="box2">
                                <div class="back-inner">
                                    <div>
                                        <h4 class="text-success">VARIFIED</h4>
                                        <span><?php echo count($euser_varified);?></span>
                                    </div>
                                    <div>
                                        <h4 class="text-danger">NOT VARIFIED</h4>
                                        <span><?php echo count($euser_nonvarified);?></span>
                                    </div>
                                </div>
                                <a class="knowmore" href="<?php echo base_url(); ?>euser_list" data-value="euser_list">Know More <i
                                        class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="hover panel">
                        <div class="front">
                            <div class="box1">
                                <div><i class="fa fa-building"></i></div>
                                <h3>Organization</h3>
                                <span>1186</span>
                            </div>
                        </div>
                        <div class="back">
                            <div class="box2">
                                <div class="back-inner">
                                    <div>
                                        <h4 class="text-success">VARIFIED</h4>
                                        <span><?php echo count($org_varified);?></span>
                                    </div>
                                    <div>
                                        <h4 class="text-danger">NOT VARIFIED</h4>
                                        <span><?php echo count($org_nonvarified);?></span>
                                    </div>
                                </div>
                                <a class="knowmore" href="<?php echo base_url(); ?>org_list" data-value="org_list">Know More <i
                                        class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="hover panel">
                        <div class="front">
                            <div class="box1">
                                <div><i class="fa fa-list"></i></div>
                                <h3>Detail</h3>
                                <span class="size_14">Know More</span>
                            </div>
                        </div>
                        <div class="back">
                            <div class="box2">
                                <div class="back-inner">
                                <ul class="infobox">
                                <a href="<?php echo base_url();?>checkslists">Check List detail</a><br>
                                <a href="<?php echo base_url();?>doc_master">Document Master</a><br>
                                <a href="<?php echo base_url();?>docfiling_master">Document Filing Master</a><br>
                            </ul>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div> 



            
        </div>
    </div>
</div>
<?php $this->load->view("admin/footer"); ?>
<script>
$('.nav-link').click(function() {
    var content = $(this).data('value');
    if (content != '') {
        $('.steps').empty().load(base_url + '/efiling/' + content);
    }
});

$(document).ready(function() {
    // set up hover panels
    // although this can be done without JavaScript, we've attached these events
    // because it causes the hover to be triggered when the element is tapped on a touch device
    $('.hover').hover(function() {
        $(this).addClass('flip');
    }, function() {
        $(this).removeClass('flip');
    });
});
</script>