<?php
$userdata=$this->session->userdata('login_success');
$user_id=$userdata[0]->id;
$salt= $this->session->userdata('certsalt');
$class='';
if($salt!=''){
    $class="disableClick";
}
//$basic= $this->efiling_model->data_list_where('certifiedtemp','salt',$salt);
$pagename= basename($_SERVER['PHP_SELF']);


$disabeltab1='';
$tab1='btn btn-warning';

$disabeltab2='';
$tab2='btn btn-warning';

$disabeltab3='';
$tab3='btn btn-warning';

$disabeltab4='';
$tab4='btn btn-warning';

$disabeltab5='';
$tab5='btn btn-warning';

$disabeltab6='';
$tab6='btn btn-warning';

$disabeltab7='';
$tab7='btn btn-warning';

/* $disabeltab7='disabled';
$iarecepttab='btn btn-danger';
if($pagename=='ia_finalreceipt'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $iabasicdetailtab="btn btn-success";
    $iapartytab="btn btn-success";
    $iadetailtab="btn btn-success";
    $iadocumenttab="btn btn-success";
    $iachecklisttab="btn btn-success";
    $iafinaptab="btn btn-success";
    $iapaymenttab="btn btn-success";
    $iarecepttab="btn btn-warning";
} */
?>
<style>
.disableClick{
    pointer-events: none;
}
</style>




<div class="btn-group btn-breadcrumb breadcrumb-default">
    <a href="<?php echo base_url(); ?>certbasicdetail" class="<?php echo $tab1; ?> <?php echo $class; ?> visible-lg-block visible-md-block" <?php echo $disabeltab1; ?>>Case Detail</a>
    <a href="<?php echo base_url(); ?>certpartydetail" class="<?php echo $tab2; ?> visible-lg-block visible-md-block " <?php echo $disabeltab2; ?>>Party Details</a>
      <a href="<?php echo base_url(); ?>matter" class="<?php echo $tab3; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab3; ?>>Matter</a>
    <a href="<?php echo base_url(); ?>certuploaddoc" class="<?php echo $tab4; ?> visible-lg-block visible-md-block" <?php echo $disabeltab4; ?>>Upload Documents</a>
    <a href="<?php echo base_url(); ?>certpf" class="<?php echo $tab5; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab5; ?>>Final Preview</a>
    <a href="<?php echo base_url(); ?>certpayment"    class="<?php echo $tab6; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab6; ?>>Payment </a>
    <a href="<?php echo base_url(); ?>certreceipt" class="<?php echo $tab7; ?> visible-lg-block visible-md-block "  <?php echo $disabeltab7; ?>>Receipt</a>
    
</div> 
