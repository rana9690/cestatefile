<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$userdata=$this->session->userdata('login_success');
$user_id=$userdata[0]->id;
$salt= $this->session->userdata('docsalt');
$basic= $this->efiling_model->data_list_where('temp_iadetail','salt',$salt);
$pagename= basename($_SERVER['PHP_SELF']);

$disabeltab0='disabled';
$iabasicdetailtab='btn btn-dark';
if($pagename=='idoc_basic_detail'){
    $disabeltab0='';
    $iabasicdetailtab="btn btn-warning";
}

$disabeltab1='disabled';
$iapartytab='btn btn-dark';
if($pagename=='doc_partydetail'){
    $disabeltab1='';
    $iabasicdetailtab="btn btn-primary";
    $iapartytab="btn btn-warning";
}



$disabeltab3='disabled';
$iadocumenttab='btn btn-dark';
if($pagename=='doc_upload_doc'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab3='';
    $iabasicdetailtab="btn btn-primary";
    $iapartytab="btn btn-primary";
    $iadetailtab="btn btn-primary";
    $iadocumenttab="btn btn-warning";
}
$disabeltab8='disabled';
$iaadvocatetab='btn btn-dark';
//$disabeltab4='disabled';
$iachecklisttab='btn btn-dark';
if($pagename=='doc_checklist'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab3='';
    $disabeltab4='disabled';
    $iabasicdetailtab="btn btn-primary";
    $iapartytab="btn btn-primary";
    $iadocumenttab="btn btn-primary";
    $iaadvocatetab="btn btn-primary";
    $iachecklisttab="btn btn-warning";
}


$disabeltab5='disabled';
$iafinaptab='btn btn-dark';
if($pagename=='doc_finalprivew'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $iabasicdetailtab="btn btn-primary";
    $iapartytab="btn btn-primary";
    $iadocumenttab="btn btn-primary";
    $iachecklisttab="btn btn-primary";
    $iaadvocatetab="btn btn-primary";
    $iafinaptab="btn btn-warning";
}


$disabeltab6='disabled';
$iapaymenttab='btn btn-dark';
if($pagename=='doc_payment'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $iabasicdetailtab="btn btn-primary";
    $iapartytab="btn btn-primary";
    $iadocumenttab="btn btn-primary";
    $iachecklisttab="btn btn-primary";
    $iafinaptab="btn btn-primary";
    $iapaymenttab="btn btn-warning";
    $iaadvocatetab="btn btn-primary";
}

$disabeltab7='disabled';
$iarecepttab='btn btn-dark';
if($pagename=='doc_finalreceipt'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $iabasicdetailtab="btn btn-primary";
    $iapartytab="btn btn-primary";
    $iadocumenttab="btn btn-primary";
    $iachecklisttab="btn btn-primary";
    $iafinaptab="btn btn-primary";
    $iapaymenttab="btn btn-primary";
    $iaadvocatetab="btn btn-primary";
    $iarecepttab="btn btn-warning";
}

 
if($pagename=='doc_councel'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $disabeltab8='';
    $iabasicdetailtab="btn btn-primary";
    $iapartytab="btn btn-primary";
    $iadocumenttab="btn btn-primary";
    $iachecklisttab="btn btn-dark";
    $iafinaptab="btn btn-dark";
    $iapaymenttab="btn btn-dark";
    $iaadvocatetab="btn btn-warning";
}




$class='';
if($salt!=''){
    $class="disableClick";
}

$class='';
if($salt!=''){
    $class="disableClick";
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
        <a href="<?php echo base_url(); ?>doc_basic_detail"
            class="<?php echo $iabasicdetailtab; ?> <?php echo $class; ?> visible-lg-block visible-md-block"
            <?php echo $disabeltab0; ?>>Basis Details</a>
        <a href="<?php echo base_url(); ?>doc_partydetail"
            class="<?php echo $iapartytab; ?> visible-lg-block visible-md-block " <?php echo $disabeltab1; ?>>Party
            Details</a>
        <a href="<?php echo base_url(); ?>doc_upload_doc"
            class="<?php echo $iadocumenttab; ?> visible-lg-block visible-md-block " <?php echo $disabeltab3; ?>>Upload
            Documents</a>
        <a href="<?php echo base_url(); ?>doc_councel"
            class="<?php echo $iaadvocatetab; ?> visible-lg-block visible-md-block "
            <?php echo $disabeltab8; ?>>Advocate Detail</a>

        <a href="<?php echo base_url(); ?>doc_finalprivew"
            class="<?php echo $iafinaptab; ?> visible-lg-block visible-md-block " <?php echo $disabeltab5; ?>>Final
            Preview </a>

        <a href="<?php echo base_url(); ?>doc_finalreceipt"
            class="<?php echo $iarecepttab; ?> visible-lg-block visible-md-block" <?php echo $disabeltab7; ?>>Receipt
        </a>

    </div>
</div>