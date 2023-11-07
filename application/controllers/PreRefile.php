<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class PreRefile extends CI_Controller
{
	protected $userData;
	protected $filing_no;
	protected $schemas;
	protected $user_id;
		public function __construct() 
		{
			parent::__construct();
			$this->load->model('Admin_model','admin_model');
			$this->load->model('Efiling_model','efiling_model');
			$this->userData = $this->session->userdata('login_success');
			$this->user_id = $this->userData[0]->id;
			$userLoginid = $this->userData[0]->loginid;
			if(empty($userLoginid)){
				redirect(base_url());
			}
					
		}
    
		public function checkConIa($csrf=null)
		{				 
				 $filing_no=$this->input->post('filing_no');
				 $this->session->set_userdata('refiling_no',$filing_no);
				 $token=$this->input->post('token');
				 $token=hash('sha512',trim($this->input->post('token')).'iaval');
				 if($csrf!=$token){
					 echo json_encode(['data'=>'error','error'=>'1','display'=>'Request is not valid !']);die;
				 }else{
					 $defective= $this->efiling_model->defectivelistdfr($filing_no);
					 if(!empty($defective) && is_array($defective)){
						 
						 $array=array('filing_no'=>$filing_no,'ia_nature'=>'22');
						 $valsd=$this->efiling_model->data_list_mulwhere('ia_detail',$array);
						 if(is_array($valsd) && !empty($valsd)){
							 echo json_encode(['data'=>'success','btnval'=>'1','error'=>'0','display'=>'You have already file Condonation of delay Please  Refiling','error'=>'0']);die;
						 }
						 
						 if($defective[0]->objection_status=='Y'){
							 $defetctopens=$this->db->from('table_defecttabopen')->where(['filing_no'=>$filing_no])->get()->row_array();
							 $pendingdefect=0;
							 if(!empty($defetctopens)){
								
							 $pendingdefect=$defetctopens['tabvals'];
							 }
							 
							 $date1= date('d-m-Y',strtotime($defective[0]->notification_date));
							 $date2 = strtotime($date1);
							 $duedateaa = strtotime("+3 week", $date2);
							 $duedateaa7 = strtotime("+3 week", $date2);
							 $duwdateval= date('Y-m-d', $duedateaa);
							 $currentdate=date('Y-m-d');
							 if($duwdateval<$currentdate){
								 //echo json_encode(['data'=>'success','btnval'=>'0','error'=>'0','display'=>'Please file IA for Condonation of delay in Refiling.']);die;
							 }
							 if($duedateaa7<$currentdate){
								 //echo json_encode(['data'=>'success','btnval'=>'1','error'=>'0','display'=>'Please file request latter for Condonation of delay','error'=>'0']);die;
							 }
							 if($pendingdefect!='0' && is_array(explode(",",$pendingdefect))){
							echo json_encode(['data'=>'success','btnval'=>'0','error'=>'0','display'=>'Please Modify Details','error'=>'0']);die;	 
							 }
							 
							 echo json_encode(['data'=>'success','btnval'=>'1','error'=>'0','display'=>'Are you want to  refile ?.']);die;
						 }else{
							 echo json_encode(['data'=>'error','error'=>'1','display'=>'Case is not defective please varify case.']);die;
						 }
					 }else{
						 echo json_encode(['data'=>'error','error'=>'1','display'=>'Case is not found our recoard !.']);die;
					 }
				 }
		}	
		public function pendingdefect($filingno)
		{
		 $data['filingno']=$filingno;
		 $this->load->view("refile/pendingdefect",$data);
		}
     
     
     
     
}
    
?>