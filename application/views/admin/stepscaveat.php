<?php
$userdata=$this->session->userdata('login_success');
$user_id=$userdata[0]->id;
$salt= $this->session->userdata('cavsalt');
$basic= $this->efiling_model->data_list_where('temp_caveat','salt',$salt);
$pagename= basename($_SERVER['PHP_SELF']);
$class='';
if($salt!=''){
    $class="disableClick";
}

$disabeltab0='disabled';
$cavbasicdetailtab='btn btn-warning';
if($pagename=='cav_basicdetail'){
    $disabeltab0='disabled';
    $cavbasicdetailtab="btn btn-danger";
}


$disabeltab1='disabled';
$cavadvtab="btn btn-danger";
if($pagename=='cav_adv'){
    $disabeltab0='';
    $disabeltab1='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab="btn btn-warning";
}




$disabeltab2='disabled';
$cavapplenttab="btn btn-danger";
if($pagename=='cav_applent'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab='btn btn-success';
    $cavapplenttab="btn btn-warning";
}


$disabeltab3='disabled';
$cavadvocate="btn btn-danger";
if($pagename=='cav_advocate'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab='btn btn-success';
    $cavapplenttab="btn btn-success";
    $cavadvocate="btn btn-warning";
}



$disabeltab4='disabled';
$cavuploaddoctab="btn btn-danger";
if($pagename=='cav_upload_doc'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab='btn btn-success';
    $cavapplenttab="btn btn-success";
    $cavadvocate="btn btn-success";
    $cavuploaddoctab="btn btn-warning";
}



$disabeltab5='disabled';
$cavchecklisttab="btn btn-danger";
if($pagename=='cav_checklist'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab='btn btn-success';
    $cavapplenttab="btn btn-success";
    $cavadvocate="btn btn-success";
    $cavuploaddoctab="btn btn-success";
    $cavchecklisttab="btn btn-warning";
}


$disabeltab6='disabled';
$cavfinalprivewtab="btn btn-danger";
if($pagename=='cav_finalprivew'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab='btn btn-success';
    $cavapplenttab="btn btn-success";
    $cavadvocate="btn btn-success";
    $cavuploaddoctab="btn btn-success";
    $cavchecklisttab="btn btn-success";
    $cavfinalprivewtab="btn btn-warning";
}



$disabeltab7='disabled';
$cavpaymenttab="btn btn-danger";
if($pagename=='cav_payment'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab='btn btn-success';
    $cavapplenttab="btn btn-success";
    $cavadvocate="btn btn-success";
    $cavuploaddoctab="btn btn-success";
    $cavchecklisttab="btn btn-success";
    $cavfinalprivewtab="btn btn-success";
    $cavpaymenttab="btn btn-warning";
}



$disabeltab8='disabled';
$receapttab="btn btn-danger";
if($pagename=='cav_receipt'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $disabeltab8='';
    $cavbasicdetailtab='btn btn-success';
    $cavadvtab='btn btn-success';
    $cavapplenttab="btn btn-success";
    $cavadvocate="btn btn-success";
    $cavuploaddoctab="btn btn-success";
    $cavchecklisttab="btn btn-success";
    $cavfinalprivewtab="btn btn-success";
    $cavpaymenttab="btn btn-success";
    $receapttab="btn btn-warning";
}


?>

<style>
.disableClick{
    pointer-events: none;
}
</style>

<div class="btn-group btn-breadcrumb breadcrumb-default">
    <a href="<?php echo base_url(); ?>cav_basicdetail" class="<?php echo $cavbasicdetailtab; ?> visible-lg-block visible-md-block" <?php echo $disabeltab0; ?>>Basic Details</a>
    <a href="<?php echo base_url(); ?>cav_adv" class="<?php echo $cavadvtab; ?> visible-lg-block visible-md-block " <?php echo $disabeltab1; ?>>Caveator Details</a>
    <a href="<?php echo base_url(); ?>cav_applent" class="<?php echo $cavapplenttab; ?> visible-lg-block visible-md-block" <?php echo $disabeltab2; ?>>Caveatee Details </a> 
    <a href="<?php echo base_url(); ?>cav_advocate" class="<?php echo $cavadvocate; ?> visible-lg-block visible-md-block" <?php echo $disabeltab3; ?>>Caveator Advocate</a>
    <a href="<?php echo base_url(); ?>cav_upload_doc" class="<?php echo $cavuploaddoctab; ?> visible-lg-block visible-md-block "    <?php echo $disabeltab4; ?>>Upload Documents</a>
    <a href="<?php echo base_url(); ?>cav_checklist" class="<?php echo $cavchecklisttab; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab5; ?>>Checklist</a>
    <a href="<?php echo base_url(); ?>cav_finalprivew" class="<?php echo $cavfinalprivewtab; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab6; ?>>Final Preview</a>
    <a href="<?php echo base_url(); ?>cav_payment"    class="<?php echo $cavpaymenttab; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab7; ?>>Payment</a>
     <a href="<?php echo base_url(); ?>cav_receipt"    class="<?php echo $receapttab; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab8; ?>>Receipt</a>
</div> 


