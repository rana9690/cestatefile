<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Masters extends CI_Controller {
	    function __construct() {
	        parent::__construct();
	        $this->load->model('Admin_model','admin_model');
	        $this->load->model('Efiling_model','efiling_model');
	        error_reporting(0);
	        date_default_timezone_set('Asia/Calcutta');


			$this->userData = $this->session->userdata('login_success');
			$userLoginid = $this->userData[0]->loginid;
			if(empty($userLoginid)){
				redirect(base_url(),'refresh');
			}
			
			$_REQUEST= array_map('strip_tags', $_REQUEST);
$_POST= array_map('strip_tags', $_POST);
$_GET= array_map('strip_tags', $_GET);
foreach($_REQUEST as $key =>$value){
	$_REQUEST[$key] =preg_replace('/[^a-zA-Z0-9\/ -_@.]/', '', $value);
}
foreach($_POST as $key =>$value){
	$_POST[$key] =preg_replace('/[^a-zA-Z0-9\/ -_@.]/', '', $value);
}
foreach($_GET as $key =>$value){
	$_GET[$key] =preg_replace('/[^a-zA-Z0-9\/ -_@.]/', '', $value);
}



		
		
			$uri_request=$_SERVER['REQUEST_URI'];
		$url_array=explode('?',$uri_request);
		$parameters=@$url_array[1];
		$parameters_array=explode('&',$parameters);
		$spcl_char=['<'=>'','>'=>'','/\/'=>'','\\'=>'','('=>'',')'=>'','!'=>'','^'=>'',"'"=>''];
		for($i=0; $i < count($parameters_array); $i++) :;
		$getPara_array=explode("=",$parameters_array[$i]);
		$paraName=@$getPara_array[0];
		$getPvalue=@$getPara_array[1];
		$_REQUEST[$paraName]=htmlspecialchars($getPvalue);
		endfor;
		foreach($_REQUEST as $key=>$val):;
		if(is_array($val)){
		    foreach($val as $key1=>$val1):;
		    if(is_array($val1)){
		        foreach($val1 as $key2=>$val2):;
		        if(is_array($val2)) {
		            $innerData[$key1][$key2]=$val2;
		        }
		        else    $innerData[$key1][$key2]=htmlspecialchars(strtr($val2, $spcl_char));
		        endforeach;
		    }
		    else $innerData[$key1]=htmlspecialchars(strtr($val1, $spcl_char));
		    endforeach;
		    $_REQUEST[$key]=$innerData;
		}
		else $_REQUEST[$key]=htmlspecialchars(strtr($val, $spcl_char));
		endforeach;
	    }


	    function checkslists(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['checklist']=$this->efiling_model->data_list_where('master_checklist','status','1');
	            $this->load->view("admin/checks_lists",$data);
	        }
	    }

	    function addchecklist(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $this->form_validation->set_rules('status', 'Choose status', 'trim|required|numeric|max_length[2]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        } 
	        $this->form_validation->set_rules('shortname', 'Please Enter short name', 'trim|required|max_length[500]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        } 
	        $this->form_validation->set_rules('c_name', 'Please Enter check list name', 'trim|required|max_length[500]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        } 
	        $this->form_validation->set_rules('action_one', 'Please Enter action one', 'trim|required|alpha|max_length[5]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        } 
	        $this->form_validation->set_rules('typecheck', 'Please Enter action two', 'trim|required|alpha|max_length[10]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        } 
	
	        if($this->form_validation->run() == TRUE) {
	            if($subtoken==$token){
    	            $postdata=array(
    	                'status'=>$this->input->post('status'),
    	                'shortname'=>$this->input->post('shortname'),
    	                'c_name'=>$this->input->post('c_name'),
    	                'entry_time'=>date('Y-m-d'),
    	                'userid'=>$user_id,
    	                'action_one'=>$this->input->post('action_one'),
    	                'typecheck'=>$this->input->post('typecheck'),
    	            );
    	            $st=$this->efiling_model->insert_query('master_checklist',$postdata);
    	            if($st){
    	                echo json_encode(['data'=>'success','value'=>'1','massage'=>'Check List added..','error'=>'0']); die;
    	            }
	            }
	        }else{
	            echo json_encode(['data'=>'error','value'=>'','massage'=>'Request not valid','error'=>'1']); die;
	        }
	    }

	    
	    function deletecheck(){
	       $id=$_REQUEST['id'];
	       $token=$_REQUEST['token'];
	       $subtoken=$this->session->userdata('submittoken');
	       if($id!='' && ($subtoken==$token)){
	           $st=$this->efiling_model->delete_event('master_checklist', 'id', $id);
	           if($st){
	               echo json_encode(['data'=>'success','value'=>'1','massage'=>'Check List Deleted..','error'=>'0']); die;
	           }
	       }else{
	           echo json_encode(['data'=>'error','value'=>'','massage'=>'Request not valid','error'=>'1']); die;
	       }
	    }

	    function doc_master(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['mdocs']=$this->efiling_model->data_list_where('master_document_efile','status','1');
	            $this->load->view("admin/master_lists",$data);
	        }
	    }
	    
	    
	    function docfiling_master(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['mdocs']=$this->efiling_model->data_list_where('master_document','status','1');
	            $this->load->view("admin/docfiling_master",$data);
	        }
	    }
	    
	    
	    
	    
	    function  adddocmaster(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $this->form_validation->set_rules('status', 'Choose status', 'trim|required|numeric|max_length[2]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        $this->form_validation->set_rules('d_name', 'Please Enter document name', 'trim|required|max_length[500]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        $this->form_validation->set_rules('d_type', 'Please Enter document type Name', 'trim|required|max_length[500]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        if($this->form_validation->run() == TRUE) {
	            if($subtoken==$token){
	                $postdata=array(
	                    'status'=>$this->input->post('status'),
	                    'docname'=>$this->input->post('d_name'),
	                    'doctype'=>$this->input->post('d_type'),
	                    'entry_date'=>date('Y-m-d'),
	                    'userid'=>$user_id,
	                );
	                $st=$this->efiling_model->insert_query('master_document_efile',$postdata);
	                if($st){
	                    echo json_encode(['data'=>'success','value'=>'1','massage'=>'Check List added..','error'=>'0']); die;
	                }
	            }
	        }else{
	            echo json_encode(['data'=>'error','value'=>'','massage'=>'Request not valid','error'=>'1']); die;
	        }
	    }
	    
	    
	    
	    function adddocfilingmaster(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$this->input->post('token');
	        $did=$this->input->post('docid');
	        $this->form_validation->set_rules('status', 'Choose status', 'trim|required|numeric|max_length[2]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        $this->form_validation->set_rules('d_name', 'Please Enter document name', 'trim|required|max_length[500]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        $this->form_validation->set_rules('d_type', 'Please Enter document type Name', 'trim|required|max_length[500]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        
	    /*     $this->form_validation->set_rules('d_fee', 'Please Enter fee', 'numeric|trim|required|max_length[3]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        } */
	        
	        $this->form_validation->set_rules('d_day', 'Please Enter day', 'numeric|trim|required|max_length[3]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        
	        $this->form_validation->set_rules('display', 'Please Check display', 'trim|required|max_length[1]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        if($this->form_validation->run() == TRUE) {
	            if($subtoken==$token){
	                if($this->input->post('action')!='edit'){
    	                $postdata=array(
    	                    'status'=>$this->input->post('status'),
    	                    'd_name'=>$this->input->post('d_name'),
    	                    'pay'=>$this->input->post('d_type'),
    	                  //  'fee'=>$this->input->post('d_fee'),
    	                    'delay_day'=>$this->input->post('d_day'),
    	                    'entry_date'=>date('Y-m-d'),
    	                    'userid'=>$user_id,
    	                    'display'=>$this->input->post('display'),
    	                );
    	                $st=$this->efiling_model->insert_query('master_document',$postdata);
    	                if($st){
    	                    echo json_encode(['data'=>'success','value'=>'1','massage'=>'Check List added..','error'=>'0']); die;
    	                }
	                }else{
	                    $data=array(
	                        'status'=>$this->input->post('status'),
	                        'd_name'=>$this->input->post('d_name'),
	                        'pay'=>$this->input->post('d_type'),
	                     //   'fee'=>$this->input->post('d_fee'),
	                        'delay_day'=>$this->input->post('d_day'),
	                        'entry_date'=>date('Y-m-d'),
	                        'userid'=>$user_id,
	                        'display'=>$this->input->post('display'),
	                    );
	                    $where=array('did'=>$did);
	                    $resupeate = $this->efiling_model->update_data_where('master_document',$where,$data);
	                  //  echo $str = $this->db->last_query();die;
	                    if($resupeate){
	                        echo json_encode(['data'=>'success','value'=>'1','massage'=>'Update sucessfully ..','error'=>'0']); die;
	                    }
	                }
	            }
	        }else{
	            echo json_encode(['data'=>'error','value'=>'','massage'=>'Request not valid','error'=>'1']); die;
	        }
	    }
	    
	    function deletedocmaster(){
	        $id=$_REQUEST['id'];
	        $token=$_REQUEST['token'];
	        $subtoken=$this->session->userdata('submittoken');
	        if($id!='' && ($subtoken==$token)){
	            $st=$this->efiling_model->delete_event('master_document_efile', 'id', $id);
	            if($st){
	                echo json_encode(['data'=>'success','value'=>'1','massage'=>'Check List Deleted..','error'=>'0']); die;
	            }
	        }else{
	            echo json_encode(['data'=>'error','value'=>'','massage'=>'Request not valid','error'=>'1']); die;
	        }
	    }
	    
	    
	    function deletedocfilingmaster(){
	        $id=$_REQUEST['id'];
	        $token=$_REQUEST['token'];
	        $subtoken=$this->session->userdata('submittoken');
	        if($id!='' && ($subtoken==$token)){
	            $st=$this->efiling_model->delete_event('master_document', 'did', $id);
	            if($st){
	                echo json_encode(['data'=>'success','value'=>'1','massage'=>'Check List Deleted..','error'=>'0']); die;
	            }
	        }else{
	            echo json_encode(['data'=>'error','value'=>'','massage'=>'Request not valid','error'=>'1']); die;
	        }
	    }
	    
	    
	    function edit_docs(){
	        $id=$_REQUEST['id'];
	        $token=$_REQUEST['token'];
	        $subtoken=$this->session->userdata('submittoken');
	        if($id!='' && ($subtoken==$token)){
	            $data=$this->efiling_model->data_list_where('master_document','did',$id);
	            if(!empty($data)){
	                echo json_encode(['data'=>'success','value'=>$data,'error'=>'0']); die;
	            }
	        }else{
	            echo json_encode(['data'=>'error','value'=>'','massage'=>'Request not valid','error'=>'1']); die;
	        }
	    }
	    
	    
}//**********END Main function ************/