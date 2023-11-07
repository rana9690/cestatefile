<?php
 $userdata=$this->session->userdata('login_success');

$user_id=$userdata[0]->id;
$salt= $this->session->userdata('salt');

$refiling= $this->session->userdata('refiling');
$pagename= basename($_SERVER['PHP_SELF']);

$disabeltab0='disabled';
$checklisttab='btn btn-dark';
if($pagename=='checklist'){
    $disabeltab0='';
    $checklisttab="btn btn-primary";
}

$disabeltab1='disabled';
$basicdetailstab='btn btn-dark';


$disabeltab2='disabled';
$applicanttab='btn btn-dark';
if($pagename=='applicant'){
    $disabeltab0='';
    $disabeltab1='';   
    $checklisttab="btn btn-primary";
   // $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-warning";
}

$disabeltab3='disabled';
$respondenttab='btn btn-dark';
if($pagename=='respondent'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';   
    $checklisttab="btn btn-primary";
    //$basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-warning";
}


$disabeltab4='disabled';
$counseltab='btn btn-dark';
if($pagename=='counsel'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';   
    $checklisttab="btn btn-primary";
    //$basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-warning";
}
if($pagename=='basic_details'){
    $disabeltab0='';
    $disabeltab1='';
	$disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $checklisttab="btn btn-primary";
	$applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
	$counseltab="btn btn-primary";
    $basicdetailstab="btn btn-warning";
}

$disabeltab5='disabled';
$ia_detailtab='btn btn-dark';
if($pagename=='ia_detail'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $checklisttab="btn btn-primary";
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-warning";
    
}


$disabeltab6='disabled';
$other_feetab='btn btn-dark';
if($pagename=='other_fee'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $checklisttab="btn btn-primary";
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-primary";
    $other_feetab="btn btn-warning";
}


$disabeltab7='disabled';
$document_upload='btn btn-dark';
if($pagename=='document_upload'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $checklisttab="btn btn-primary";
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
if($pagename=='payment_mode'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $disabeltab8='';
    $checklisttab="btn btn-primary";
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-primary";
    $other_feetab="btn btn-primary";
    $document_upload="btn btn-primary";
    $payment_mode="btn btn-warning";
}



$disabeltab9='disabled';
$final_previewtab='btn btn-dark';
if($pagename=='final_preview'){
    $disabeltab0='';
    $disabeltab1='';
    $disabeltab2='';
    $disabeltab3='';
    $disabeltab4='';
    $disabeltab5='';
    $disabeltab6='';
    $disabeltab7='';
    $disabeltab8='';
    $disabeltab9='';
    $checklisttab="btn btn-primary";
    $basicdetailstab="btn btn-primary";
    $applicanttab="btn btn-primary";
    $respondenttab="btn btn-primary";
    $counseltab="btn btn-primary";
    $ia_detailtab="btn btn-primary";
    $other_feetab="btn btn-primary";
    $document_upload="btn btn-primary";
    $payment_mode="btn btn-primary";
    $final_previewtab='btn btn-warning';
}




//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if($refiling!='refile'){

    ?>
<div class="row m-0">
    <div class="btn-group btn-breadcrumb breadcrumb-default steps-btn">
        <a href="<?php echo base_url(); ?>checklist"
            class="<?php echo $checklisttab; ?> visible-lg-block visible-md-block" <?php echo $disabeltab0; ?>
            id="step_0">Instructions</a>

        <a href="<?php echo base_url(); ?>applicant"
            class="<?php echo $applicanttab; ?> visible-lg-block visible-md-block <?php echo $disabeltab1; ?>"
            id="step_1">Appellants</a>
        <a href="<?php echo base_url(); ?>respondent"
            class="<?php echo $respondenttab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab2; ?>"
            id="step_2">Respondents</a>
        <?php if($pet_type!=1){?>
        <a href="<?php echo base_url(); ?>counsel"
            class="<?php echo $counseltab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab3; ?>"
            id="step_3">Counsel/ Representative </a>
        <?php }?>
        <a href="<?php echo base_url(); ?>basic_details"
            class="<?php echo $basicdetailstab; ?> visible-lg-block visible-md-block <?php echo $disabeltab4; ?>"
            id="step_4">Appeal Memo</a>
        <?php if($this->config->item('ia_privilege')==true):?>
        <a href="<?php echo base_url(); ?>ia_detail"
            class="<?php echo $ia_detailtab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab5; ?>"
            id="step_5">IA Details</a>
        <?php endif;?>

        <a href="<?php echo base_url(); ?>document_upload"
            class="<?php echo $document_upload; ?> visible-lg-block visible-md-block  <?php echo $disabeltab7; ?>"
            id="step_7">Document Upload</a>
        <?php if($pet_type!=1){?>
        <a href="<?php echo base_url(); ?>payment_mode"
            class="<?php echo $payment_mode; ?> visible-lg-block visible-md-block <?php echo $disabeltab8; ?>"
            id="step_8">Fee Details</a>
        <?php } ?>
        <a href="<?php echo base_url(); ?>final_preview"
            class="<?php echo $final_previewtab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab9; ?>"
            id="step_9">Final Preview</a>
    </div>
</div>
<?php }

if($refiling=='refile'){
    $pagename= basename($_SERVER['PHP_SELF']);
    
    $disabeltab0='disabled';
    $checklisttab='btn btn-primary';
    if($pagename=='checklist'){
        $disabeltab0='';
        $checklisttab="btn btn-primary";
    }
    
    
    
    $disabeltab2='disabled';
    $applicanttab='btn btn-dark';
    if($pagename=='applicant'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $checklisttab="btn btn-primary";
        $basicdetailstab="";
        $applicanttab="btn btn-warning";
    }
    
    $disabeltab3='disabled';
    $respondenttab='btn btn-dark';
    if($pagename=='respondent'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $disabeltab3='';
        $checklisttab="btn btn-primary";
        $basicdetailstab="btn btn-primary";
        $applicanttab="btn btn-primary";
        $respondenttab="btn btn-warning";
    }
    
    
    $disabeltab4='disabled';
    $counseltab='btn btn-dark';
    if($pagename=='counsel'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $disabeltab3='';
        $disabeltab4='';
        $checklisttab="btn btn-primary";
        $basicdetailstab="";
        $applicanttab="btn btn-primary";
        $respondenttab="btn btn-primary";
        $counseltab="btn btn-warning";
    }
    
	
	$disabeltab1='disabled';
    $basicdetailstab='btn btn-dark';
    if($pagename=='basic_details'){
        $disabeltab0='';
        $disabeltab1='';
        $checklisttab="btn btn-primary";
		$applicanttab="btn btn-primary";
        $respondenttab="btn btn-primary";
        $counseltab="btn btn-primary";
        $basicdetailstab="btn btn-warning";
    }
    
    $disabeltab5='disabled';
    $ia_detailtab='btn btn-dark';
    if($pagename=='ia_detail'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $disabeltab3='';
        $disabeltab4='';
        $disabeltab5='';
        $checklisttab="btn btn-primary";
        $basicdetailstab="btn btn-primary";
        $applicanttab="btn btn-primary";
        $respondenttab="btn btn-primary";
        $counseltab="btn btn-primary";
        $ia_detailtab="btn btn-warning";
        
    }
    
    
    $disabeltab6='disabled';
    $other_feetab='btn btn-dark';
    if($pagename=='other_fee'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $disabeltab3='';
        $disabeltab4='';
        $disabeltab5='';
        $disabeltab6='';
        $checklisttab="btn btn-primary";
        $basicdetailstab="btn btn-primary";
        $applicanttab="btn btn-primary";
        $respondenttab="btn btn-primary";
        $counseltab="btn btn-primary";
        $ia_detailtab="btn btn-primary";
        $other_feetab="btn btn-warning";
    }
    
    
    $disabeltab7='disabled';
    $document_upload='btn btn-dark';
    if($pagename=='document_upload'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $disabeltab3='';
        $disabeltab4='';
        $disabeltab5='';
        $disabeltab6='';
        $disabeltab7='';
        $checklisttab="btn btn-primary";
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
    if($pagename=='payment_mode'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $disabeltab3='';
        $disabeltab4='';
        $disabeltab5='';
        $disabeltab6='';
        $disabeltab7='';
        $disabeltab8='';
        $checklisttab="btn btn-primary";
        $basicdetailstab="btn btn-primary";
        $applicanttab="btn btn-primary";
        $respondenttab="btn btn-primary";
        $counseltab="btn btn-primary";
        $ia_detailtab="btn btn-primary";
        $other_feetab="btn btn-primary";
        $document_upload="btn btn-primary";
        $payment_mode="btn btn-warning";
    }
    
    
    
    $disabeltab9='disabled';
    $final_previewtab='btn btn-dark';
    if($pagename=='final_preview'){
        $disabeltab0='';
        $disabeltab1='';
        $disabeltab2='';
        $disabeltab3='';
        $disabeltab4='';
        $disabeltab5='';
        $disabeltab6='';
        $disabeltab7='';
        $disabeltab8='';
        $disabeltab9='';
        $checklisttab="btn btn-primary";
        $basicdetailstab="btn btn-primary";
        $applicanttab="btn btn-primary";
        $respondenttab="btn btn-primary";
        $counseltab="btn btn-primary";
        $ia_detailtab="btn btn-primary";
        $other_feetab="btn btn-primary";
        $document_upload="btn btn-primary";
        $payment_mode="btn btn-primary";
        $final_previewtab='btn btn-warning';
    }
    
    
    ?>
<div class="row">
    <div class="btn-group btn-breadcrumb breadcrumb-default">
        <a href="javascript:void(0)" class="<?php echo $checklisttab; ?> visible-lg-block visible-md-block <?php echo $disabeltab0; ?>" id="step_0"
            disabled>Instructions</a>

        <a href="<?php echo base_url(); ?>applicant"
            class="<?php echo $applicanttab; ?> visible-lg-block visible-md-block <?php echo $disabeltab2; ?>">Applicant</a>
        <a href="<?php echo base_url(); ?>respondent"
            class="<?php echo $respondenttab; ?> visible-lg-block visible-md-block <?php echo $disabeltab3; ?> ">Respondent</a>
        <?php if($pet_type!=1){?>
        <a href="<?php echo base_url(); ?>counsel"
            class="<?php echo $counseltab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab4; ?>">Counsel/ Representative </a>
        <?php }?>

        <a href="<?php echo base_url(); ?>basic_details"
            class="<?php echo $basicdetailstab; ?> visible-lg-block visible-md-block <?php echo $disabeltab5; ?>">Appeal Memo</a>

        <?php if(IA_PRIVILEGE==true):?>
        <a href="<?php echo base_url(); ?>ia_detail"
            class="<?php echo $ia_detailtab; ?> visible-lg-block visible-md-block <?php echo $disabeltab6; ?>"><?=$this->lang->line('iaTab')?></a>
        <?php endif;?>

        <a href="<?php echo base_url(); ?>document_upload"
            class="<?php echo $document_upload; ?> visible-lg-block visible-md-block  <?php echo $disabeltab7; ?>">Document Upload</a>
        <?php if($pet_type!=1){?>
        <a href="<?php echo base_url(); ?>payment_mode"
            class="<?php echo $payment_mode; ?> visible-lg-block visible-md-block <?php echo $disabeltab8; ?>">Payment Mode</a>
        <?php }?>
        <a href="<?php echo base_url(); ?>final_preview"
            class="<?php echo $final_previewtab; ?> visible-lg-block visible-md-block  <?php echo $disabeltab8; ?>">Final Preview</a>
    </div>
</div>
<?php } ?>