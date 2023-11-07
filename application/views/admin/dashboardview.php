<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); 
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;?>
<style>


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

.dbox.bg_alt {
    background: rgb(209, 228, 226);
    background: -moz-linear-gradient(0deg, rgba(209, 228, 226, 1) 0%, rgba(238, 255, 253, 1) 100%);
    background: -webkit-linear-gradient(0deg, rgba(209, 228, 226, 1) 0%, rgba(238, 255, 253, 1) 100%);
    background: linear-gradient(0deg, rgba(209, 228, 226, 1) 0%, rgba(238, 255, 253, 1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#d1e4e2", endColorstr="#eefffd", GradientType=1);
    border: 1px solid #b7c5c3;
}

.dbox.dbox_inline {
    width: 33%;
    display: inline-block;
    margin-right: 15px;
}

.dbox__icon {
    position: absolute;
    transform: translateY(-50%) translateX(-50%);
    left: 50%;
    display: none;
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
    font-size: 20px;
    color: #8e4d46;
    font-weight: bold;
    padding: 6px 0;
    margin-bottom: 8px;
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
    transform: translateY(-140%) translateX(-50%);
    position: absolute;
    left: 50%;
}

.dbox__action__btn {
    border: none;
    background: #FFF;
    border-radius: 19px;
    padding: 0px 8px;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 11px;
    letter-spacing: .5px;
    color: #003e85;
    box-shadow: 0 3px 5px #d4d4d4;
}

.dbox__action__btn .nav-link {
    padding: 0.4rem 1.25rem;
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

.infobox {
    list-style: none;
    padding: 0;
    text-align: left;
    width: 100%;
    margin: 10px auto 10px;
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
    margin-top: -8px;
    margin-bottom: -2px;
}

.usericon {
    display: inline-block;
    border-radius: 50%;
    border: 1px solid #c1bdad;
    font-size: 40px;
    width: 90px;
    height: 90px;
    position: relative;
    margin-top: 29px;
    background: rgba(255, 255, 255, 0.50);
}

.usericon i {
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
}

.username {
    padding-bottom: 15px;
    padding-top: 5px;
    font-weight: bold;
    color: #263238;
    text-shadow: 1px 1px 1px #fff;
    font-size: 14px;
}
</style>
<?php
        $userdata=$this->session->userdata('login_success');
        $userName=strtoupper(@$userdata[0]->fname.' '.@$userdata[0]->lname);



?>
<div class="content" style="padding-top:0px;">
    <div class="row">
        <div class="card">
            <div class="row dashboard-cards">
                <div class="col-md-4 mb-4">
                    <div class="card o-hidden">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-file"></i>
                            </div>
                            <div class="label">Draft Cases
                                <span><b class="n-ppost"><?=$appDraft+$applDraft+$codDraft?>
                                <div class="n-ppost-name">
                                        <div class="card-footer bt-none text-warning clearfix small z-1">
                                            <span><?=$this->lang->line('aplFiling')?>
                                                <a href="<?php echo base_url(); ?>draft_list">
                                                <i class="badge text-bg-warning"><?=$appDraft?></i>
                                                    </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> <?=$this->lang->line('applFiling')?>
                                                <a href="<?php echo base_url(); ?>rpepcp_draftcase_list">
                                                <i class="badge text-bg-warning"><?=$applDraft?></i>
                                                    </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> <?=$this->lang->line('codFiling')?>
                                                <a href="<?php echo base_url(); ?>rpepcp_draftcase_list">
                                                    <i class="badge text-bg-warning"><?=$codDraft?></i>
                                                </a></span>
                                        </div>
                                        <!--div class="card-footer bt-none clearfix small z-1">
                                            <span> Documents Filing <i class="badge text-bg-warning">4</i></span>
                                        </div-->
                                    </div>
                                </b>
                                </span>
                            </div>
                        </div>
                        <a class="card-footer clearfix small z-1" href="#">
                            <span> <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card o-hidden">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-list"></i>
                            </div>
                            <div class="label">Cases Filed
                                <span><b class="n-ppost"><?=$apeeal+$appl+$cod?>
                                <div class="n-ppost-name">
                                        <div class="card-footer bt-none text-warning clearfix small z-1">
                                            <span> <?=$this->lang->line('aplFiling')?>
                                                <a href="<?php echo base_url('filedcase_list'); ?>">
                                                    <i class="badge text-bg-warning"><?=$apeeal?></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span><?=$this->lang->line('applFiling')?>
                                                <a href="<?=base_url('rpepcp_filed_list')?>">
                                                <i class="badge text-bg-warning"><?=$appl?></i>
                                            </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> <?=$this->lang->line('codFiling')?>
                                                <a href="#">
                                                <i class="badge text-bg-warning"><?=$cod?></i>
                                            </a>
                                            </span>
                                        </div>
                                        <!--div class="card-footer bt-none clearfix small z-1">
                                            <span> Documents Filing <i class="badge text-bg-warning">0</i></span>
                                        </div-->
                                    </div>
                                </b>
                            </span>
                            </div>
                        </div>
                        <a class="card-footer clearfix small z-1" href="#">
                            <span> <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card o-hidden">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-exclamation-circle"></i>
                            </div>
                            <div class="label">Defective Cases
                                <span><b class="n-ppost"><?=$appDef+$applDef+$codDef?>
                                <div class="n-ppost-name">
                                        <div class="card-footer bt-none text-warning clearfix small z-1">
                                            <span> <?=$this->lang->line('aplFiling')?>
                                                <a href="<?=base_url('defective_list')?>">
                                                <i class="badge text-bg-warning"><?=$appDef?></i>
                                            </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span>

                                                <?=$this->lang->line('applFiling')?><i class="badge text-bg-warning"><?=$applDef?></i>

                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> <?=$this->lang->line('codFiling')?>

                                                <i class="badge text-bg-warning"><?=$codDef?></i></span>
                                        </div>
                                    </div>
                                </b>
                            </span>
                            </div>
                        </div>
                        <a class="card-footer clearfix small z-1" href="#">
                            <span> <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card o-hidden">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-filter"></i>
                            </div>
                            <div class="label">Under Scrutiny
                                <span><b class="n-ppost"><?=$appScrutiny+$applScrutiny+$codScrutiny?>
                                <div class="n-ppost-name">
                                        <div class="card-footer bt-none text-warning clearfix small z-1">
                                            <span> <?=$this->lang->line('aplFiling')?>
                                                <a href="<?php echo base_url('pending_scrutiny_app'); ?>">
                                                <i class="badge text-bg-warning"> <?=$appScrutiny?></i>
                                            </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> <?=$this->lang->line('apllFiling')?> <i class="badge text-bg-warning">

                                                    <?=$applScrutiny?>
                                                </i></span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> <?=$this->lang->line('codFiling')?>  <i class="badge text-bg-warning">
                                                    <?=$codScrutiny?>
                                                </i></span>
                                        </div>
                                    </div>
                                </b>
                            </span>
                            </div>
                        </div>
                        <a class="card-footer clearfix small z-1" href="#">
                            <span> <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card o-hidden">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-gavel"></i>
                            </div>
                            <div class="label">Registered Cases
                                <span><b class="n-ppost"><?=$appRegis+$applRegis+$codRegis?>
                                <div class="n-ppost-name">
                                        <div class="card-footer bt-none text-warning clearfix small z-1">
                                            <span> Appeal
                                                <a href="<?php echo base_url('registerd_case'); ?>">
                                                <i class="badge text-bg-warning"><?=$appRegis?></i>
                                            </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> Applications
                                                <a href="<?php echo base_url('rpepcp_registercase'); ?>">
                                                <i class="badge text-bg-warning"><?=$applRegis?></i>
                                            </a>
                                            </span>
                                        </div>
                                        <div class="card-footer bt-none clearfix small z-1">
                                            <span> COD Applications <i class="badge text-bg-warning"><?=$codRegis?></i></span>
                                        </div>
                                    </div>
                                </b>
                            </span>
                            </div>
                        </div>
                        <a class="card-footer clearfix small z-1" href="#">
                            <span> <i class="fa fa-angle-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- <div class="row">
        <div class="card w-100" style="padding: 0px 12px;">
            <?php 
                echo form_fieldset('Case Status ',['style'=>'margin-top:12px;border: 2px solid #4cb060;']).
                 '<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 21px 6px;"></i>';

                echo'<div class="d-block text-center text-warning">
                        <div class="table-responsive text-secondary" id="add_petitioner_list">
                            <span class="fa fa-spinner fa-spin fa-3x"></span>
                        </div>
                    </div>';
                echo form_fieldset_close();
            ?>
        </div>
    </div> -->
    <script>
    $('.loading').hide();
    $('.nav-link').click(function() {
        var content = $(this).data('value');
        if (content != '') {
            $('.steps').empty().load(base_url + '/efiling/' + content);
        }
    });
    </script>
</div>
<?php $this->load->view("admin/footer"); ?>
<?php $this->load->view("admin/dashboard-modals"); ?>