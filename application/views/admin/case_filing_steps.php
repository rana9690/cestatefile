<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script> 
<style>
.srchWrap {
    margin-left: 194px;
    position: relative;
    float: right;
    width: 100%;
    margin-right: 10px;
}
.srchWrap input {
    padding-left: 35px;
    font-size: 16px;
}
.srchWrap input:focus {
    border: 1px solid #2196f3 !important;
}
.srchWrap i {
    position: absolute;
    left: 12px;
    top: 14px;
}
</style>
<?php
$salt= $this->session->userdata('salt');
// echo '<pre>';
// echo'---'.$this->session->userdata('efiling_amount')['salt'];
$filingnosession= $this->session->userdata('filingnosession');
$detail= $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
$tab= isset($detail[0]->tab_no)?$detail[0]->tab_no:''; ?>


<div id="rightbar"> 
	<?php 
	$salt=$this->session->userdata('salt'); 
	if($salt==''){
		$this->load->view('admin/checkList_first');
		//$this->load->view('admin/basic_details.php');
		//$this->load->view('admin/document_upload.php');
	}else{
    	$detail= $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
    	if(empty($detail)){
    	    $this->load->view('admin/basic_details');
			
    	}
    	switch($detail[0]->tab_no) {
	    case '1':
	        $this->load->view('admin/basic_details.php');
	        break;
	    case '2':
	        $this->load->view('admin/applicant.php');
			
	        break;
	    case '3':
	        $this->load->view('admin/respondent.php');
	        break;
	    case '4':
	        $this->load->view('admin/ia_detail.php');
	        break;
	    case '5':
	        $this->load->view('admin/other_fee.php');
	        break;
	    case '6':
	        $this->load->view('admin/document_upload.php');
	        break;
	    case '7':
	        $this->load->view('admin/payment_mode.php');
	        break;
	    default:    
	}
}
?> 
</div>
 <?php $this->load->view("admin/footer"); ?>
 