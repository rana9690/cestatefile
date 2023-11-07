<?php

$refiling= $this->session->userdata('refiling_no');
$pagename= basename($_SERVER['PHP_SELF']);
$disabeltab0='';
$checklisttab='btn btn-dark';
if($pagename=='checklist')
{
    $checklisttab="btn btn-primary";
}

$disabeltab1='disabled';


$disabeltab2='disabled';
$applicanttab='btn btn-dark';
if($pagename=='applicant-mod'){
    $basicdetailstab="btn btn-dark";
    $applicanttab="btn btn-warning";
}

$disabeltab3='disabled';
$respondenttab='btn btn-dark';
if($pagename=='respondentRefile'){
    $basicdetailstab="btn btn-dark";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-warning";
}


$disabeltab4='disabled';
$counseltab='btn btn-dark';
if($pagename=='counselrefile'){
    $basicdetailstab="btn btn-dark";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-warning";
}
$basicdetailstab='btn btn-dark';
if($pagename=='basicdetails-mod'){
	 $applicanttab="btn btn-primary";
	 $respondenttab="btn btn-primary";
	 $counseltab="btn btn-primary";
    $basicdetailstab="btn btn-warning";
}

$disabeltab5='disabled';
$ia_detailtab='btn btn-dark';
if($pagename=='ia_detailrefile'){
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-warning";

}


$disabeltab6='disabled';
$other_feetab='btn btn-dark';
if($pagename=='editother_fee'){
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-primary";
    $other_feetab="btn btn-warning";
}


$disabeltab7='disabled';
$document_upload='btn btn-dark';
if($pagename=='documentuploadedit'){
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-primary";
    $other_feetab="btn btn-primary";
    $document_upload="btn btn-warning";
}

$disabeltab8='disabled';
$payment_mode='btn btn-dark';
if($pagename=='paymentmodeedit'){
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-primary";
    $other_feetab="btn btn-primary";
    $document_upload="btn btn-primary";
    $payment_mode="btn btn-warning";
}

//$class="disableClick";
$class="";
    ?>
    <style>
.disableClick{
    pointer-events: none;
}
</style>
<div class="row m-0">
<div class="btn-group btn-breadcrumb breadcrumb-default steps-btn">
<?php 
$rowd= $this->efiling_model->data_list_where('table_defecttabopen','filing_no',$refiling);

    if(!empty($rowd) && is_array($rowd)){
        $numbers=explode(',',$rowd[0]->tabvals);
        $numbers = array_diff($numbers, [0]);
        sort($numbers);
        $arrlength=count($numbers);
        $vals=array();
      for($x=0;$x<$arrlength;$x++){
          $vals[]=  $numbers[$x] ;
        }

        foreach($vals as $aval){

            
        
        if($aval==1){?>
        <a href="<?php echo base_url(); ?>applicant-mod" class="<?php echo $applicanttab; ?> visible-lg-block visible-md-block <?php echo $disabeltab1; ?>"     id="step_1">Edit Applicant</a>
          <?php }
          
          if($aval==2){?>
        <a href="<?php echo base_url(); ?>respondentRefile" class="<?php echo $respondenttab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab2; ?>"  id="step_2" >Edit Respondent</a>
         <?php }
         
         if($aval==3){?>
        <a href="<?php echo base_url(); ?>counselrefile" class="<?php echo $counseltab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab3; ?>"  id="step_3" >Edit Counsel/ Representative </a>
          <?php }
		  if($aval==4){?>
        <a href="<?php echo base_url(); ?>basicdetails-mod" class="<?php echo $basicdetailstab; ?> visible-lg-block visible-md-block <?php echo $disabeltab4; ?>" id="step_4"><?=$this->lang->line('editBasicDetail')?></a>
        <?php }
          
         /* if($aval==5){?>
        <a href="<?php echo base_url(); ?>ia_detailrefile" class="<?php echo $ia_detailtab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab5; ?>"  id="step_5" >IA Details</a>
          <?php }
          
          if($aval==6){?>
        <a href="<?php echo base_url(); ?>editother_fee" class="<?php echo $other_feetab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab6; ?>"  id="step_6" >Other Fee</a>
          <?php }*/
          
          if($aval==7){?>
        <a href="<?php echo base_url(); ?>documentuploadedit" class="<?php echo $document_upload; ?> visible-lg-block visible-md-block  <?php echo $disabeltab7; ?>"  id="step_7" >Document Upload</a>
          <?php }
          
          if($aval==8){

          ?>
        <a href="<?php echo base_url(); ?>paymentmodeedit" class="<?php echo $payment_mode; ?> visible-lg-block visible-md-block  <?php echo $disabeltab8; ?>"  id="step_8" >Payment Detail</a>
    <?php }
    
        }
    } ?>
</div> 