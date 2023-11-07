<?php
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepsdoc");
$salt=$this->session->userdata('docsalt');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$token= $this->efiling_model->getToken();
$vals=$this->session->userdata('docdetail');
if(empty($vals)){
    echo "<span style='color:red'>Request not valid!</span>";die;
}

if(!empty($vals) && is_array($vals)){
    $doc_filing=$vals['doc_filing'];
    $filing_no=$vals['filingNo'];
    $doc_type=$vals['doc_type'];
}


$curYear=date('Y');
?>
<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec">
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','name'=>'rpepcpbascidetail','id'=>'rpepcpbascidetail','autocomplete'=>'off']) ?>
            <?= form_fieldset('Complete').'<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>'; ?>
            <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
            <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
            <input type="hidden" name="tabno" id="tabno" value="1">
            <div class="col-md-12">
                <div class="row">
                    <td colspan="1">
                        <font size="2"><a
                                href="maprint/<?php echo $filing_no; ?>/<?php echo $doc_filing; ?>/<?php echo $doc_type; ?>"><b>
                                    <font size="4"><?php //echo "Print"; ?></font>
                                </b></a></font>
                    </td>
                    <br class="center">
                    <div class="col-md-12 text-center text-dark">
                    <h4>Document saved successfully with diary no :
                        <?php

                echo  $doc_filing;
                echo "<br>";
             ?></h4>
             </div>
                </div>
                <?= form_fieldset_close(); ?>

                <?= form_close();?>
            </div>
        </div>
    </div>
    <?php $this->load->view("admin/footer"); ?>