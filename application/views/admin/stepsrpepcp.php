<?php
$userdata=$this->session->userdata('login_success');
$user_id=$userdata[0]->id;
$salt= $this->session->userdata('rpepcpsalt');
$class='';
if($salt!=''){
    $class="disableClick";
}
$basic= $this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$salt);
 $type=$basic[0]->type;
$pagename= basename($_SERVER['PHP_SELF']);
$disabeltab0='disabled';
$basicdetailtab='btn btn-dark';
if($pagename=='review_petition_filing' || $pagename=='cross_filing'){
    $disabeltab0='disabled';
    $basicdetailtab="btn btn-primary";
}

$disabeltab1='disabled';
$rptab='btn btn-dark';
if($pagename=='petitionparty'){
    $disabeltab0='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-warning";
}

$disabeltab2='disabled';
$Prioritytab='btn btn-dark';
if($pagename=='petitionPriority'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-warning";
}


$disabeltab3='disabled';
$petitionadvtab='btn btn-dark';
if($pagename=='petitionadv'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-warning";
}

$disabeltab4='disabled';
$petitionIatab='btn btn-dark';
if($pagename=='petitionIa'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-primary";
    $petitionIatab="btn btn-warning";
}


$disabeltab5='disabled';
$petitionDoctab='btn btn-dark';
if($pagename=='petitionDoc'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-primary";
    $petitionIatab="btn btn-primary";
    $petitionDoctab="btn btn-warning";
}


$disabeltab6='disabled';
$petitionChecktab='btn btn-dark';
if($pagename=='petitionCheck'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-primary";
    $petitionIatab="btn btn-primary";
    $petitionDoctab="btn btn-primary";
    $petitionChecktab="btn btn-warning";
}



$disabeltab7='disabled';
$petitionCfeetab='btn btn-dark';
if($pagename=='petitionCfee'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-primary";
    $petitionIatab="btn btn-primary";
    $petitionDoctab="btn btn-primary";
    $petitionChecktab="btn btn-primary";
    $petitionCfeetab="btn btn-warning";
}



$disabeltab8='disabled';
$petitionFPtab='btn btn-dark';
if($pagename=='petitionFP'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-primary";
    $petitionIatab="btn btn-primary";
    $petitionDoctab="btn btn-primary";
    $petitionChecktab="btn btn-primary";
    $petitionCfeetab="btn btn-primary";
    $petitionFPtab="btn btn-warning";
}



$disabeltab9='disabled';
$petitionPaytab='btn btn-dark';
if($pagename=='petitionPay'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $disabeltab8='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-primary";
    $petitionIatab="btn btn-primary";
    $petitionDoctab="btn btn-primary";
    $petitionChecktab="btn btn-primary";
    $petitionCfeetab="btn btn-primary";
    $petitionFPtab="btn btn-primary";
    $petitionPaytab="btn btn-warning";
}


$disabeltab10='disabled';
$petitionReceipttab='btn btn-dark';
if($pagename=='petitionReceipt'){
    $disabeltab0='disabled="disabled"';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $disabeltab8='';
    $disabeltab9='';
    $basicdetailtab="btn btn-primary";
    $rptab="btn btn-primary";
    $Prioritytab="btn btn-primary";
    $petitionadvtab="btn btn-primary";
    $petitionIatab="btn btn-primary";
    $petitionDoctab="btn btn-primary";
    $petitionChecktab="btn btn-primary";
    $petitionCfeetab="btn btn-primary";
    $petitionFPtab="btn btn-primary";
    $petitionPaytab="btn btn-primary";
    $petitionReceipttab="btn btn-warning";
}





?>
<style>
.steps-btn a.btn.btn-dark {
    color: #fff;
    pointer-events: none;
}
.steps-btn a.btn.btn-warning {
    opacity: 1;
}.steps-btn a.btn.btn-primary {
    opacity: 1;
}
</style>
<div class="row m-0">
    <div class="btn-group btn-breadcrumb breadcrumb-default steps-btn">
        <a href="<?php echo base_url(); ?><?php if(isset($type)==6 ||$pagename=='cross_filing')echo'cross_filing'; else echo'review_petition_filing';?> "
            class="<?php echo $basicdetailtab; ?> <?php echo $class; ?> visible-lg-block visible-md-block"
            <?php echo $disabeltab0; ?>>Basis Details</a>

        <a href="<?php echo base_url(); ?>petitionparty"
            class="<?php echo $rptab; ?> visible-lg-block visible-md-block " <?php echo $disabeltab1; ?>>

            <?php if($type!=6): echo $this->lang->line('applicationFilingPet');else: echo 'Appeal Memo'; endif;?></a>
        <a href="<?php echo base_url(); ?>petitionPriority"
            class="<?php echo $Prioritytab; ?> visible-lg-block visible-md-block" <?php echo $disabeltab2; ?>>Set
            Priority</a>
        <a href="<?php echo base_url(); ?>petitionadv"
            class="<?php echo $petitionadvtab; ?> visible-lg-block visible-md-block "
            <?php echo $disabeltab3; ?>>Advocate</a>
        <?php if($this->config->item('ia_privilege')==true):?>
        <a href="<?php echo base_url(); ?>petitionIa"
            class="<?php echo $petitionIatab; ?> visible-lg-block visible-md-block " <?php echo $disabeltab4; ?>>IA
            Details</a>
        <?php endif;?>
        <a href="<?php echo base_url(); ?>petitionDoc"
            class="<?php echo $petitionDoctab; ?> visible-lg-block visible-md-block " <?php echo $disabeltab5; ?>>Upload
            Document</a>
        <!--a href="<?php //echo base_url(); ?>petitionCheck" class="<?php //echo $petitionChecktab; ?> visible-lg-block visible-md-block "  <?php //echo $disabeltab6; ?>>Check list</a-->
        <?php /*?>
        <a href="<?php echo base_url(); ?>petitionCfee"
            class="<?php echo $petitionCfeetab; ?> visible-lg-block visible-md-block" <?php echo $disabeltab7; ?>>Court
            Fee</a>
        <?php */?>
        <a href="<?php echo base_url(); ?>petitionFP"
            class="<?php echo $petitionFPtab; ?> visible-lg-block visible-md-block" <?php echo $disabeltab8; ?>>Final
            Preview </a>
        <a href="<?php echo base_url(); ?>petitionPay"
            class="<?php echo $petitionPaytab; ?> visible-lg-block visible-md-block"
            <?php echo $disabeltab9; ?>>Payment</a>
        <a href="<?php echo base_url(); ?>petitionReceipt"
            class="<?php echo $petitionReceipttab; ?> visible-lg-block visible-md-block "
            <?php echo $disabeltab10; ?>>Receipt</a>
    </div>
</div>