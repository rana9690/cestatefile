<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Steps extends CI_Controller {
	    function __construct() {
	        parent::__construct();
			
	        $this->load->model('Admin_model','admin_model');
	        $this->load->model('Efiling_model','efiling_model');
	        
			//ini_set('display_errors',1);
	        //error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
	        date_default_timezone_set('Asia/Calcutta');


			$this->userData = $this->session->userdata('login_success');
			$userLoginid = $this->userData[0]->loginid;
			if(empty($userLoginid)){
				redirect(base_url(),'refresh');
			}
			
			/*$_REQUEST= array_map('strip_tags', $_REQUEST);
$_POST= array_map('strip_tags', $_POST);
$_GET= array_map('strip_tags', $_GET);
foreach($_REQUEST as $key =>$value){
	$_REQUEST[$key] =preg_replace('/[^a-zA-Z0-9\/ -]/', '', $value);
}
foreach($_POST as $key =>$value){
	$_POST[$key] =preg_replace('/[^a-zA-Z0-9\/ -]/', '', $value);
}
foreach($_GET as $key =>$value){
	$_GET[$key] =preg_replace('/[^a-zA-Z0-9\/ -]/', '', $value);
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
			endforeach;*/
	    }
	    
	    
	    function draftrefiling($salt,$tab){
			
	        $userdata=$this->session->userdata('login_success');
	        $this->session->set_userdata('refiling','refile');


	            $this->session->set_userdata('salt',$salt);
	            if($tab=='0'){
	                $this->checklist();
	            }
	            if($tab=='1'){
					$this->applicant();
	            }
	            if($tab=='2'){
	                $this->respondent();
	            }
	            if($tab=='3'){
	                $this->counsel();
	            }
	            if($tab=='4'){
	                $this->basic_details();
	            }
	            if($tab=='5'){
	                $this->ia_detail();
	            }
	            if($tab=='6'){
	                $this->other_fee();
	            }
	            if($tab=='7'){
	                $this->document_upload();
	            }
	            if($tab=='8'){
					
	                $this->payment_mode();
					
	            }
	            if($tab=='9'){
	                $this->final_preview();
	            }
	    }

	    function basic_details(){
			//ini_set('display_errors', 1);
		    //error_reporting(E_ALL);
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $user_id=$userdata[0]->id;
			$data= $this->db->get_where('aptel_temp_appellant',['salt'=>$salt,'user_id'=>$user_id])->row_array();	
		
				
	       
    		    $data['datacomm']= $this->efiling_model->data_commission_where($salt,$user_id);
				
				$data['natureorders']=getIssAuthDesignations([]);
				$data['commisions']=getIss_auth_masters([]);
				$data['impugnesArray']=getImpugnedType([]);
				
				$temp_chek_list=getTempChekListData(['salt'=>$salt]);
				if(!empty($temp_chek_list)):
					$data=array_merge($data,$temp_chek_list);
					endif;
				$data['requiredDocuAction']='upload_docs';	
				$data['requiredDocuments']=$this->db->query("SELECT	msdoc.docname,	msdoc.ID,concat ( REPLACE ( msdoc.docname, ' ', '_' ), '-', msdoc.ID ) AS docnameunder,
				(select file_url  from temp_documents_upload where salt='".$salt."' and docid=msdoc.id limit 1)  FROM master_document_efile AS msdoc WHERE msdoc.doctype = 'appRequire' ORDER BY	msdoc.priority")->result_array();	
					
    	        $this->load->view('admin/basic_details',$data);
				
				
	        
	    }
	    
	    function checklist(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $this->session->unset_userdata('refiling');
	        $this->session->unset_userdata('salt');
	        if($user_id){
	            $data['checklist']= $this->db->order_by('id')->get_where('master_checklist',['status'=>'1','typecheck'=>'apl'])->result();//$this->efiling_model->data_list_where('master_checklist','status','1');
	            $this->load->view("admin/checkList_first",$data);
	        }
	    }
	    
	    function applicant(){
			
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
				$data['pet_type']=2;
	            $data['regcase']= $this->efiling_model->registerdcases_list();
	            $this->load->view("admin/applicant",$data);
	        }
	    }
	    
	    function respondent(){
			
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
				$salt=$this->session->userdata('salt');
				$data= $this->db->get_where('aptel_temp_appellant',['salt'=>$salt,'user_id'=>$user_id])->row_array();	
				
	            $data['regcase']= $this->efiling_model->registerdcases_list();
				
	            $this->load->view("admin/respondent",$data);
	        }
	    }
	    
	    function counsel(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
				$salt=$this->session->userdata('salt');
				$data= $this->db->get_where('aptel_temp_appellant',['salt'=>$salt,'user_id'=>$user_id])->row_array();
	            $data['regcase']= $this->efiling_model->registerdcases_list();
	            $this->load->view("admin/counsel",$data);
	        }
	    }
	    
	    function ia_detail(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['regcase']= $this->efiling_model->registerdcases_list();
	            $this->load->view("admin/ia_detail",$data);
	        }
	    }

	    
	    function other_fee(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['regcase']= $this->efiling_model->registerdcases_list();
	            $this->load->view("admin/other_fee",$data);
	        }
	    }
	    function document_upload(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
				$salt=$this->session->userdata('salt');
				$data= $this->db->get_where('aptel_temp_appellant',['salt'=>$salt,'user_id'=>$user_id])->row_array();
	            $data['regcase']= $this->efiling_model->registerdcases_list();
	            $this->load->view("admin/document_upload",$data);
	        }
	    }
	    function payment_mode(){
			
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['regcase']= $this->efiling_model->registerdcases_list();
				$salt=$this->session->userdata('salt');
				$temp_applant=getTempAppellant(['salt'=>$salt]);
				$tempImpugnedData=getTempImpugned(['salt'=>$salt]);
				if(!empty($tempImpugnedData)):
					$feeData=$this->efiling_model->feeCalculate(['salt'=>$salt,'partyType'=>$temp_applant['pet_type'],'impugnedType'=>$tempImpugnedData['lower_court_type'],
						'caseType'=>$temp_applant['l_case_type'],
						'partyType'=>$temp_applant['filed_by'],
					]);

					if(array_key_exists('success',$feeData)):
						$data['appealFee']= $feeData['feeAmount'];
						else:
							$data['appealFee']= 0;
							endif;
					endif;
					
	            $this->load->view("admin/payment_mode",$data);
	        }
	    }
	    function final_preview(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
				$salt=$this->session->userdata('salt');
				$data= $this->db->get_where('aptel_temp_appellant',['salt'=>$salt,'user_id'=>$user_id])->row_array();
	            $data['regcase']= $this->efiling_model->registerdcases_list();
				$salt=$this->session->userdata('salt');
				$temp_applant=getTempAppellant(['salt'=>$salt]);
				$tempImpugnedData=getTempImpugned(['salt'=>$salt]);
				if(!empty($tempImpugnedData)):
					$feeData=$this->efiling_model->feeCalculate([
						'salt'=>$salt,
						'impugnedType'=>$tempImpugnedData['lower_court_type'],
						'caseType'=>$temp_applant['l_case_type'],
						'partyType'=>$temp_applant['filed_by'],
					]);

					if(array_key_exists('success',$feeData)):
						$data['appealFee']= $feeData['feeAmount'];
					else:
						$data['appealFee']= 0;
					endif;
				endif;
	            $this->load->view("admin/final_preview",$data);
	        }
	    }
	    
	    
	    function getcommedit(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];
	        if($subtoken==$token){
	            $data= $this->efiling_model->edit_data('aptel_temp_commision','id',$id);
    	             $date=array(
    	                'salt' =>$data->salt,
    	                 'case_no' => $data->case_no,
    	                 'decision_date' =>date('d-m-Y',strtotime($data->decision_date)),
    	                 'case_year' =>$data->case_year,
    	                 'commission' =>$data->commission,
    	                 'created_user' =>$data->created_user,
    	                 'modified_date' =>$data->modified_date,
    	                 'created_date' =>$data->created_date,
    	                 'modified_user' =>$data->modified_user,
    	                 'nature_of_order' =>$data->nature_of_order,
    	                 'lower_court_type' =>$data->lower_court_type,
    	                 'comm_date' =>date('d-m-Y',strtotime($data->comm_date)),
    	                 'id'=> $data->id
    	            );
    	             echo json_encode($date);
	        }else{
	            echo "Request not valid!";die;
	        }
	    }
	    


	    function editSubmitcomm(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];
			
			$this->form_validation->set_rules('id','Please enter valid id','trim|required|min_length[1]|max_length[10]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter valid id','display'=>validation_errors(),'error'=>'1']);die;
	        }

	        $this->form_validation->set_rules('case_no','Please enter case no','trim|required|min_length[1]|max_length[25]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter case no','display'=>validation_errors(),'error'=>'1']);die;
	        }
	        
	       
	        
	        $this->form_validation->set_rules('commission','Please enter commission','trim|required|min_length[1]|max_length[4]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter commission','display'=>validation_errors(),'error'=>'1']);die;
	        }
	        
	        $this->form_validation->set_rules('natureOrder','Please enter nature order','trim|required|min_length[1]|max_length[4]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter nature order','display'=>validation_errors(),'error'=>'1']);die;
	        }
	        
	        $decision = htmlspecialchars($_REQUEST['ddate']);
	        if (!preg_match("/[0-9]{2}\-[0-9]{2}\-[0-9]{4}/", $decision)) {
	            $msg=  'Your Desision date entry does not match the DD-MM-YYYY required format.';
	            echo json_encode(['data'=>'error','value'=>$msg,'display'=>$msg,'error'=>'1']);die;
	        }
	        
	        $comDate = htmlspecialchars($_REQUEST['comDate']);
	        if (!preg_match("/[0-9]{2}\-[0-9]{2}\-[0-9]{4}/", $comDate)) {
	            $msg=  'Your Desision date entry does not match the DD-MM-YYYY required format.';
	            echo json_encode(['data'=>'error','value'=>$msg,'display'=>$msg,'error'=>'1']);die;
	        } 
			
	        if($token==$subtoken){
	            $array=array(
	                'case_no'=>$this->input->post('case_no'),
	                'decision_date'=>date('Y-m-d',strtotime($_REQUEST['ddate'])),
	                'comm_date'=>date('Y-m-d',strtotime($_REQUEST['comDate'])),
	                'commission'=>$_REQUEST['commission'],
	                'nature_of_order'=>$_REQUEST['natureOrder'],
	                'lower_court_type'=>$_REQUEST['case_type'],
	                'case_year'=>$_REQUEST['year'],
	            );
	            $where=array('id'=>$id);
	            $st = $this->efiling_model->update_data_where('aptel_temp_commision',$where,$array);
	            
	            if((int)$salt==0) $salt='0';
	            $where_cond=[
	                'created_user'=>$user_id,
	                'salt'=>$salt
	            ];
	            
	            $data=$this->efiling_model->data_list_commission('aptel_temp_commision',$where_cond);
	            $html='';
	            $html.='
                <table id="example" class="display" cellspacing="0" border="1" width="100%">
    	        <thead>
        	        <tr>
            	        <th>Sr. No. </th>
            	       <th>'.$this->lang->line('commissionLabel').'</th>
						<th>'.$this->lang->line('natureOrder').'</th>
						<th>'.$this->lang->line('impugnedType').'</th>
						<th>'.$this->lang->line('impugnedOrderNo').'</th>
						<!--th>Case Year</th-->
                        <th>Decision Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
        	        </tr>
    	        </thead>
    	        <tbody>';
	            if(!empty($data)){
	                $i=1;
	                foreach($data as $val){
	                    $nature_of_order=$val->nature_of_order;
	                    $commission=$val->commission;
	                    $casetype=$val->lower_court_type;
	                    //if (is_numeric($nature_of_order)) {
	                        //$naturname= $this->efiling_model->data_list_where('master_nature_of_order','nature_code',$nature_of_order);
	                        $natshort_name=getIssAuthDesignations([])[$nature_of_order];//$naturname[0]->short_name;
	                    //}
	                    //if (is_numeric($commission)) {
	                        //$comm=$this->efiling_model->data_list_where('master_commission','id',$commission);
	                        $commname=getIss_auth_masters([])[$commission];//$comm[0]->short_name;
	                    //}
	                    
	                  //  if (is_numeric($casetype)) {
	                        //$caseT=$this->efiling_model->data_list_where('master_case_type','case_type_code',$casetype);
	                        $casetype=getImpugnedType()[$casetype];//$caseT[0]->short_name;
	                    //}
	                    
	                    $html.='<tr id="tr'.$val->id.'>">
            	        <td>'.$i.'</td>
            	        <td>'.$commname.'</td>
            	        <td>'.$natshort_name.'</td>
            	        <td>'.$casetype.'</td>
            	        <td>'.$val->case_no.'</td>
                        <!--td>'.$val->case_year.'</td-->
                        <td>'.date('d-m-Y',strtotime($val->decision_date)).'</td>
                        <td><input type="button" value="Edit" class="btn1"  data-toggle="modal" data-target="#exampleModal" onclick="editcomm('.$val->id.')">
            	        <td><input type="button" value="Delete" class="btn1" onclick="deletecomm('.$val->id.')">
            	        </td><td>
            	        </td>
        	        </tr>';
	                    $i++;
	                }
	            }
	            $html.='</tbody>
    	        </table>';
	            echo json_encode(['result'=>$html,'rows'=>($i-1),'success'=>'Record update successfully!','data'=>'success']);
	        }

	    }


	    
	    
	    
	    function getApplant(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];
	        $type=$_REQUEST['type'];
	        $stateid='';
	        $disid='';
	        if($subtoken==$token){
	            if($type=='add'){
    	            $data= $this->efiling_model->edit_data('aptel_temp_additional_party','id',$id);
    	            $st = $this->efiling_model->data_list_where('master_psstatus','state_code',$data->pet_state);
    	            $stateid=$data->pet_state;
    	            $statename = $st[0]->state_name;
    	            $distname = '';
    	            if ($data->pet_state!= "") {
    	                $stdit = $this->efiling_model->data_list_where('master_psdist','district_code',$data->pet_dis);
    	                $distname = $stdit[0]->district_name;
    	                $disid= $data->pet_dis;
    	            }
    	            $date=array(
    	                'pet_name' =>$data->pet_name,
    	                'pet_degingnation' => $data->pet_degingnation,
    	                'pet_address' =>$data->pet_address,
    	                'pin_code' =>$data->pin_code,
    	                'pet_state' =>$statename,
    	                'pet_dis' =>$distname,
    	                'pet_mobile' =>$data->pet_mobile,
    	                'pet_phone' =>$data->pet_phone,
    	                'pet_email' =>$data->pet_email,
    	                'pet_fax' =>$data->pet_fax,
    	                'party_id' =>$data->party_id,
    	                'id'=> $data->id,
    	                'action'=> 'edit',
    	                'type'=> 'addparty',
    	                'stateid' =>$stateid,
    	                'disid' =>$disid,
    	            );
    	            echo json_encode($date);
	            }
	            if($type=='main'){
	                $data= $this->efiling_model->edit_data('aptel_temp_appellant','salt',$salt);
	                $st = $this->efiling_model->data_list_where('master_psstatus','state_code',$data->pet_state);
	                $statename = $st[0]->state_name;
	                $distname = '';
	                if ($data->pet_state!= "") {
	                    $stdit = $this->efiling_model->data_list_where('master_psdist','district_code',$data->pet_dist);
	                    $distname = $stdit[0]->district_name;
	                }	 
	                
	                $stateid=$data->pet_state;
	                $disid= $data->pet_dist;
	                
	                // pet_name,pet_fax,pet_state,pet_address,pet_degingnation,pet_dist,pet_email,pet_id,pet_type      
	                $date=array(
	                    'pet_name' =>$data->pet_name,
	                    'pet_degingnation' => $data->pet_degingnation,
	                    'pet_address' =>$data->pet_address,
	                    'pin_code' =>$data->pincode,
	                    'pet_state' =>$statename,
	                    'pet_dis' =>$distname,
	                    'pet_mobile' =>$data->petmobile,
	                    'pet_phone' =>$data->petphone,
	                    'pet_email' =>$data->pet_email,
	                    'pet_fax' =>$data->pet_fax,
	                    'party_id' =>$data->pet_id,
	                    'id'=> $data->salt,
	                    'action'=> 'edit',
	                    'state'=> $data->pet_state,
	                    'dist'=> $data->pet_dist,	 
	                    'dist'=> $data->pet_type,	 
	                    'type'=> 'mainparty',
	                    'stateid' =>$stateid,
	                    'disid' =>$disid,
	                );
	                echo json_encode($date);
	            }
	        }else{
	            echo "Request not valid!";die;
	        }
	    }
	    
	
	    function editSubmitApplent(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$this->input->post('token');
	        $user_id=$userdata[0]->id;
	        $id=$this->input->post('id');
	        $petname = $this->input->post('petName');
	        if(is_numeric($petname)){
	            $hscquery = $this->efiling_model->data_list_where('master_org','org_id',$petname);
	            $petname = $hscquery[0]->orgdisp_name;
	        }
	        $edittype=$this->input->post('edittype');
			
			$this->form_validation->set_rules('petmobile','Please enter mobile number','trim|required|min_length[1]|max_length[10]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter mobile number','display'=>validation_errors(),'error'=>'1']);die;
	        }
	        
	        $this->form_validation->set_rules('dstate','Please enter state','trim|required|min_length[1]|max_length[4]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter state','display'=>validation_errors(),'error'=>'1']);die;
	        }
	        
	        $this->form_validation->set_rules('ddistrict','Please enter district','trim|required|min_length[1]|max_length[4]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter district','display'=>validation_errors(),'error'=>'1']);die;
	        }
	       
	        
	        $this->form_validation->set_rules('petEmail','Please enter email address','trim|required|valid_email|min_length[1]|max_length[50]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter email address','display'=>validation_errors(),'error'=>'1']);die;
	        }
	        
	        $this->form_validation->set_rules('id','Please enter valid id','trim|required|min_length[1]|max_length[20]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'Please enter valid id','display'=>validation_errors(),'error'=>'1']);die;
	        }
			
	        if($token==$subtoken){
	            if($edittype=='addparty'){
    	            $array = array(
    	                'pet_name' =>$petname,
    	                'pet_degingnation' =>'',
    	                'pet_address' => $this->input->post('petAddress'),
    	                'pin_code' =>$this->input->post('pincode'),
    	                'pet_state' =>$this->input->post('dstate'),
    	                'pet_dis' =>$this->input->post('ddistrict'),
    	                'pet_mobile' => $this->input->post('petmobile'),
    	                'pet_phone' => $this->input->post('petPhone'),
    	                'pet_email' =>$this->input->post('petEmail'),
    	                'pet_fax' => $this->input->post('petFax'),
    	                'party_id'=>$this->input->post('petName'),
    	                'user_id'=>$user_id,
    	            );
    	            $where=array('id'=>$id);
    	            $st = $this->efiling_model->update_data_where('aptel_temp_additional_party',$where,$array);
    	            $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt);
    	            $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
    	            if($st){
    	                echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0','4 last_query'=>$this->db->last_query()]);
    	            }
	            }
	            if($edittype=='mainparty'){
	                $array = array(
	                    'pet_name' =>$petname,
	                    'pet_degingnation' =>'',
	                    'pet_address' => $this->input->post('petAddress'),
	                    'pincode' =>$this->input->post('pincode'),
	                    'pet_state' =>$this->input->post('dstate'),
	                    'pet_dist' =>$this->input->post('ddistrict'),
	                    'petmobile' => $this->input->post('petmobile'),
	                    'petphone' => $this->input->post('petPhone'),
	                    'pet_email' =>$this->input->post('petEmail'),
	                    'pet_fax' => $this->input->post('petFax'),
	                    'pet_id'=>$this->input->post('petName'),
	                );
	                $where=array('salt'=>$salt);
	                $st = $this->efiling_model->update_data_where('aptel_temp_appellant',$where,$array);
	                $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt);
	                $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
	                if($st){
	                    echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0','4 last_query'=>$this->db->last_query()]);
	                }
	            }
	        }
	    }
	    
	    function htmaladditionalparty($additionalparty,$salt){
	        $html='';  
	        $appleant="'appleant'";
	        $html.='
                <table id="example" class="display" cellspacing="0" border="1" width="100%">
    	        <thead>
        	        <tr>
            	        <th>Sr. No. </th>
            	        <th>Appellant Name</th>
            	        <th>Designation</th>
            	        <th>Mobile</th>
            	        <th>Email</th>
                        <th>Edit</th>
            	        <th>Delete</th>
        	        </tr>
    	        </thead>
    	        <tbody>';
	           
    	        $html.='</tbody>
        	        </table>';
    	        $vals=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
    	        if($vals[0]->pet_name){
    	            $petName=$vals[0]->pet_name;
    	            if (is_numeric($vals[0]->pet_name)) {
    	                $orgname=$this->efiling_model->data_list_where('master_org','org_id',$vals[0]->pet_name);
    	                $petName=$orgname[0]->org_name;
    	            }
    	            $type="'main'";
    	            $html.='
                    <tr style="color:green">
                      <td> 1</td>
            	        <td>'.$petName.'(A-1)</td>
            	        <td>'. $vals[0]->pet_degingnation.'</td>
            	        <td>'. $vals[0]->petmobile.'</td>
            	        <td>'.$vals[0]->pet_email.'</td>
            	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"  data-toggle="modal" data-target="#exampleModal" onclick="editParty('.$vals[0]->salt.','.$appleant.','.$type.')"></td>
                        <td></td>
                    </tr>'; 
    	        }
    	        if(!empty($additionalparty)){
    	            $i=2;
    	            foreach($additionalparty as $val){
    	                $app="'appleant'";
    	                $petName=$val->pet_name;
    	                if (is_numeric($val->pet_name)) {
    	                    $orgname=$this->efiling_model->data_list_where('master_org','org_id',$val->pet_name);
    	                    $petName=$orgname[0]->org_name;
    	                }
    	                
    	                $type="'add'";
    	                $html.=
    	                '<tr>
                	        <td>'.$i.'</td>
                	        <td>'.$petName.'(A-'.$i.')</td>
                	        <td>'.$val->pet_degingnation.'</td>
                	        <td>'.$val->pet_mobile.'</td>
                	        <td>'.$val->pet_email.'</td>
                	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editParty('.$val->id.','.$appleant.','.$type.')"></td>
                            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deleteParty('.$val->id.','.$appleant.')"></td>
                	        </td>
                          </tr>';
    	                $i++;
    	            }
    	        }
    	        return $html;
	    }	 
	    
	    
	    
	    
	    
	    function getRespondent(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];
	        $type=$_REQUEST['type'];
	        if($subtoken==$token){
	            if($type=='add'){
	                $data= $this->efiling_model->edit_data('aptel_temp_additional_res','id',$id);
	                $st = $this->efiling_model->data_list_where('master_psstatus','state_code',$data->res_state);
	                $statename = $st[0]->state_name;
	                $distname = '';
	                if ($data->res_state!= "") {
	                    $stdit = $this->efiling_model->data_list_where('master_psdist','district_code',$data->res_dis);
	                    $distname = $stdit[0]->district_name;
	                }
	                $date=array(
	                    'pet_name' =>$data->res_name,
	                    'pet_degingnation' => $data->res_degingnation,
	                    'pet_address' =>$data->res_address,
	                    'pin_code' =>$data->res_code,
	                    'pet_state' =>$statename,
	                    'pet_dis' =>$distname,
	                    'state'=> $data->res_state,
	                    'dist'=> $data->res_dis,
	                    'pet_mobile' =>$data->res_mobile,
	                    'pet_phone' =>$data->res_phone,
	                    'pet_email' =>$data->res_email,
	                    'pet_fax' =>$data->res_fax,
	                    'party_id' =>$data->party_id,
	                    'id'=> $data->id,
	                    'action'=> 'edit',
	                    'type'=> 'addparty',
	                );
	                echo json_encode($date);
	            }
	            if($type=='main'){
	                $data= $this->efiling_model->edit_data('aptel_temp_appellant','salt',$salt);
	                $st = $this->efiling_model->data_list_where('master_psstatus','state_code',$data->res_state);
	                $statename = $st[0]->state_name;
	                $distname = '';
	                if ($data->res_state!= "") {
	                    $stdit = $this->efiling_model->data_list_where('master_psdist','district_code',$data->res_dis);
	                    $distname = $stdit[0]->district_name;
	                }
	                $date=array(
	                    'pet_name' =>$data->resname,
	                    'pet_degingnation' => $data->res_degingnation,
	                    'pet_address' =>$data->res_address,
	                    'pin_code' =>$data->res_pin,
	                    'pet_state' =>$statename,
	                    'pet_dis' =>$distname,
	                    'pet_mobile' =>$data->res_mobile,
	                    'pet_phone' =>$data->res_phone,
	                    'pet_email' =>$data->res_email,
	                    'pet_fax' =>$data->res_fax,
	                    'party_id' =>$data->party_id,
	                    'id'=> $data->salt,
	                    'action'=> 'edit',
	                    'state'=> $data->res_state,
	                    'dist'=> $data->res_dis,
	                    'res_type'=> $data->res_type,
	                    'type'=> 'mainparty',
	                );
	                echo json_encode($date);
	            }
	        }else{
	            echo "Request not valid!";die;
	        }
	    }
	    
	    

	    function editSubmitRespondent(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];
	        $resname = htmlspecialchars($_REQUEST['resName']);
	        if(is_numeric($resname)){
	            $hscquery = $this->efiling_model->data_list_where('master_org','org_id',$resname);
	            $resname = $hscquery[0]->orgdisp_name;
	        }
	        $edittype=$_REQUEST['edittype'];
	        if($token==$subtoken){
				
				
				$this->form_validation->set_rules('resName','Please enter respondent','trim|required|min_length[1]|max_length[250]');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'Please enter respondent','display'=>validation_errors(),'error'=>'1']);die;
	            }
	            
	            $this->form_validation->set_rules('resMobile','Please enter mobile number','trim|required|min_length[1]|max_length[10]|numeric');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'Please enter mobile number','display'=>validation_errors(),'error'=>'1']);die;
	            }
	            
	            $this->form_validation->set_rules('stateRes','Please enter state','trim|required|min_length[1]|max_length[4]|numeric');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'Please enter state','display'=>validation_errors(),'error'=>'1']);die;
	            }
	            
	            $this->form_validation->set_rules('ddistrictres','Please enter district','trim|required|min_length[1]|max_length[4]|numeric');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'Please enter district','display'=>validation_errors(),'error'=>'1']);die;
	            }
	            
	            
	            
	            $this->form_validation->set_rules('resEmail','Please enter email','trim|valid_email|required|min_length[1]|max_length[50]');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'Please enter email','display'=>validation_errors(),'error'=>'1']);die;
	            }

                $this->form_validation->set_rules('id','Please enter name','trim|required|min_length[1]|max_length[50]');
                if($this->form_validation->run() == FALSE){
                    echo json_encode(['data'=>'error','value'=>'Please enter name','display'=>validation_errors(),'error'=>'1']);die;
                }
				
	            if($edittype=='addparty'){
	                $array = array(
	                    'res_name' =>$resname,
	                    'res_degingnation' => $_REQUEST['degingnationRes'],
	                    'res_address' => $_REQUEST['resAddress'],
	                    'res_code' =>$_REQUEST['respincode'],
	                    'res_state' =>$_REQUEST['stateRes'],
	                    'res_dis' =>$_REQUEST['ddistrictres'],
	                    'res_mobile' => $_REQUEST['resMobile'],
	                    'res_phone' => $_REQUEST['resPhone'],
	                    'res_email' =>$_REQUEST['resEmail'],
	                    'res_fax' => $_REQUEST['resFax'],
	                    'party_id'=>$_REQUEST['resName'],
	                    'user_id'=>$user_id,
	                );
	                $where=array('id'=>$id);
	                $st = $this->efiling_model->update_data_where('aptel_temp_additional_res',$where,$array);
	                $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt',$salt);
	                $htmladditonalparty=$this->htmaladditionalrespondentparty($additionalparty,$salt);
	                if($st){
	                    echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0','4 last_query'=>$this->db->last_query()]);
	                }
	            }
	            
	            if($edittype=='mainparty'){
	                $array = array(
	                    'resname' =>$resname,
	                    'res_degingnation' => $_REQUEST['degingnationRes'],
	                    'res_address' => $_REQUEST['resAddress'],
	                    'res_pin' =>$_REQUEST['respincode'],
	                    'res_state' =>$_REQUEST['stateRes'],
	                    'res_dis' =>$_REQUEST['ddistrictres'],
	                    'res_mobile' => $_REQUEST['resMobile'],
	                    'res_phone' => $_REQUEST['resPhone'],
	                    'res_email' =>$_REQUEST['resEmail'],
	                    'res_fax' => $_REQUEST['resFax'],
	                    'res_id'=>$_REQUEST['resName'],
	                    'user_id'=>$user_id,
	                );
	                $where=array('salt'=>$salt);
	                $st = $this->efiling_model->update_data_where('aptel_temp_appellant',$where,$array);
	                $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt',$salt);
	                $htmladditonalparty=$this->htmaladditionalrespondentparty($additionalparty,$salt);
	                if($st){
	                    echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0','4 last_query'=>$this->db->last_query()]);
	                }
	            }
	        }
	    }
	    
	    
	    function htmaladditionalrespondentparty($additionalresparty,$salt){
	        $html='';
	        $appleant="'res'";
	        $html.='
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
	        <thead>
    	           <th>Sr. No.</th>
                    <th>Respondent Name</th>
                    <th>Designation</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Edit</th>
                    <th>Delete</th>
	        </thead>
	         <tbody>';
	        $vals=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	        if($vals[0]->resname!=''){
	            $petName=$vals[0]->resname;
	            if (is_numeric($vals[0]->resname)) {
	                $orgname=$this->efiling_model->data_list_where('master_org','org_id',$vals[0]->resname);
	                $petName=$orgname[0]->org_name;
	            }
	            $type="'main'";
	            $html.='<tr style="color:green">
                          <td>1</td>
                	        <td>'.$petName.'(R-1)</td>
                	        <td>'.$vals[0]->pet_degingnation.'</td>
                	        <td>'.$vals[0]->res_mobile.'</td>
                	        <td>'.$vals[0]->res_email.'</td>
                	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editParty('.$val->id.','.$appleant.','.$type.')"></td>
                            <td></td>
                        </tr>';
	        }
	        $html.='</tbody>
	        </table>';
	        if(!empty($additionalresparty)){
	            $i=2;
	            foreach($additionalresparty as $val){
	                $type="'add'";
	                $resName=$val->res_name;
	                if (is_numeric($val->res_name)) {
	                    $orgname=$this->efiling_model->data_list_where('master_org','org_id',$val->res_name);
	                    $resName=$orgname[0]->orgdisp_name;
	                }
	                $html.='<tr>
            	        <td>'.$i.'</td>
            	        <td>'.$resName.'(R-'.$i.')</td>
            	        <td>'.$val->res_degingnation.'</td>
            	        <td>'.$val->res_mobile.'</td>
            	        <td>'.$val->res_email.'</td>
            	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editParty('.$val->id.','.$appleant.','.$type.')"></td>
                        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deleteParty('.$val->id.','.$appleant.')"></td>
            	        </td>
                    </tr>';
	                $i++;
	            }
	        }
	        return $html;
	    }
	    
	    function addCouncel(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        //$subtoken=$this->session->userdata('submittoken');
	        //$token=$this->input->post('token');
	        $user_id=$userdata[0]->id;
	        $id=$this->input->post('id');
	        $partyType=$this->input->post('partyType');
	        $advType=$this->input->post('advType');
	        $petadvName='';
	        
	        if($salt!=''){
	            $hscquery = $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	            $petadvName = $hscquery[0]->pet_council_adv;
				$bench=$hscquery[0]->bench;

	        }

			//$benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
			//$schemas=$benchData['schema_name'];


	        if($advType=='1'){
    	        $councilCode=$this->input->post('councilCode');
    	        if(is_numeric($councilCode)){
    	            //$hscquery = $this->db->get_where($schemas.'.advocate_master',['adv_code'=>$councilCode])->row_array();
    	            $hscquery = $this->db->get_where('master_advocate',['adv_code'=>$councilCode])->row_array();

					//change
    	            //$hscquery = $this->efiling_model->data_list_where($schemas.'.advocate_master','adv_code',$councilCode);


    	            $advName = $hscquery['adv_name'];
    	        }
	        }
	        if($advType=='2'){
	            $councilCode= $this->input->post('councilCode');
	            if(is_numeric($councilCode)){
	                $hscquery = $this->efiling_model->data_list_where('efiling_users','id',$councilCode);
	                $advName = $hscquery[0]->fname.' '.$hscquery[0]->lname;
	            }
	        }
	        
	        
	        $edittype=$this->input->post('action');
	        $advType=$this->input->post('advType');
	        

	         //Add Advocate Main   
	            if($edittype=='add' && $petadvName==''){
    	            $this->form_validation->set_rules('counselMobile', 'Choose council mobile', 'trim|required|numeric|max_length[200]');
    	            if($this->form_validation->run() == TRUE) {
    	                $query_params=array(
    	                    'counsel_add'=>$this->input->post('counselAdd'),
    	                    'counsel_pin'=>$this->input->post('counselPin'),
    	                    'counsel_mobile'=>$this->input->post('counselMobile'),
    	                    'counsel_email'=>$this->input->post('counselEmail'),
    	                    'pet_council_adv'=>$councilCode,
    	                    'counsel_fax'=>$this->input->post('counselFax'),
    	                    'counsel_phone'=>$this->input->post('counselPhone'),
    	                    'advType'=>$advType,
    	                );

    	                $data_app=$this->efiling_model->update_data('aptel_temp_appellant', $query_params,'salt', $salt);
    	                $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
    	                $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt,$schemas);
    	                if($data_app){
    	                    echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']); die;
    	                } else{
    	                    echo json_encode(['data'=>'','error'=>'1','massage'=>'DB Error found in line no '.__LINE__]); die;
    	                }
    	            }else{
    	                echo json_encode(['data'=>'','error'=>'1','massage'=>strip_tags(validation_errors())]); die;
    	            }
	            }

	          //Add Advocate List  
	            if($edittype=='add' && $petadvName!='' && $partyType!='add'){
	                $array = array(
	                    'salt'=>$salt,
	                    'adv_name'=>$advName,
	                    'counsel_add'=>$this->input->post('counselAdd'),
	                    'counsel_pin'=>$this->input->post('counselPin'),
	                    'counsel_mobile'=>$this->input->post('counselMobile'),
	                    'counsel_email'=>$this->input->post('counselEmail'),
	                    'council_code'=>$councilCode,
	                    'counsel_fax'=>$this->input->post('counselFax'),
	                    'counsel_phone'=>$this->input->post('counselPhone'),
	                    'user_id'=>$user_id,
	                    'adv_district'=>$this->input->post('cddistrict'),
	                    'adv_state'=>$this->input->post('cdstate'),
	                    'entry_time'=>date('Y-m-d'),
	                    'advType'=>$advType,
	                    'patitiontype'=>'app',
	                );
	                $st = $this->efiling_model->insert_query('aptel_temp_add_advocate',$array);
	                $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
	                $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt,$schemas);
	                if($st){
	                    echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
	                }
	            }
	           // ini_set('display_errors', 1);
	            //ini_set('display_startup_errors', 1);
	            //error_reporting(E_ALL);

	          //Edit Advocate List  
	            if($edittype=='edit' ){
	                if($partyType=='main'){
                        $id=$_REQUEST['id'];
                        $advid=$_REQUEST['councilCode'];
                        if(is_numeric($councilCode)){
                            $hscquery = $this->efiling_model->data_list_where('master_advocate','adv_code',$advid);
                            $advName = $hscquery[0]->adv_name;
                        }
                        $query_params=array(
                            'counsel_add'=>$_REQUEST['counselAdd'],
                            'counsel_pin'=>$_REQUEST['counselPin'],
                            'counsel_mobile'=>$_REQUEST['counselMobile'],
                            'counsel_email'=>$_REQUEST['counselEmail'],
                            'pet_council_adv'=>$councilCode,
                            'counsel_fax'=>$_REQUEST['counselFax'],
                            'counsel_phone'=>$_REQUEST['counselPhone'],
                            'advType'=>$advType,
                        );
                        $data_app=$this->efiling_model->update_data('aptel_temp_appellant', $query_params,'salt', $id);
    	                $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
    	               // $this->db->last_query();
    	                $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt,$schemas);
    	                if($data_app){
    	                    echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
    	                }
	                }
	                
	              
	                if($partyType=='add'){
	                    $id=$_REQUEST['id'];
	                    $advid=$_REQUEST['councilCode'];
	                    
	                    if($salt!=''){
	                        $hscquery = $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	                        $petadvName = $hscquery[0]->pet_council_adv;
	                    }
	                    if($advType=='1'){
	                        $councilCode= htmlspecialchars($_REQUEST['councilCode']);
	                        if(is_numeric($councilCode)){
	                            $hscquery = $this->efiling_model->data_list_where('master_advocate','adv_code',$councilCode);
	                            $advName = $hscquery[0]->adv_name;
	                        }
	                    }
	                    if($advType=='2'){
	                        $councilCode= htmlspecialchars($_REQUEST['councilCode']);
	                        if(is_numeric($councilCode)){
	                            $hscquery = $this->efiling_model->data_list_where('efiling_users','id',$councilCode);
	                            $advName = $hscquery[0]->fname.' '.$hscquery[0]->lname;
	                        }
	                    }
	                    
	                   
	                    $array = array(
	                        'adv_name'=>$advName,
	                        'counsel_add'=>$_REQUEST['counselAdd'],
	                        'counsel_pin'=>$_REQUEST['counselPin'],
	                        'counsel_mobile'=>$_REQUEST['counselMobile'],
	                        'counsel_email'=>$_REQUEST['counselEmail'],
	                        'council_code'=>$_REQUEST['councilCode'],
	                        'counsel_fax'=>$_REQUEST['counselFax'],
	                        'counsel_phone'=>$_REQUEST['counselPhone'],
	                        'user_id'=>$user_id,
	                        'adv_district'=>$_REQUEST['cddistrict'],
	                        'adv_state'=>$_REQUEST['cdstate'],
	                        'entry_time'=>date('Y-m-d'),
	                        'advType'=>$advType,
	                        'patitiontype'=>'app',
	                    );
	                    $where=array('id'=>$id);
	                    $st = $this->efiling_model->update_data_where('aptel_temp_add_advocate',$where,$array);
	                    $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
	                    // $this->db->last_query();
	                    $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt,$schemas);
	                    if($st){
	                        echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
	                    }
	                }
	                
	            }

	    }
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    function deleteAdvocate(){
	        $msg='';
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];


			$saltNo=$this->input->post('salt');
			$tempData=$this->db->select('bench')->get_where('aptel_temp_appellant',['salt'=>$saltNo])->row_array();
			$bench= $tempData['bench'];
			$benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
			$schemas=$benchData['schema_name'];


	        if($token==$subtoken){
	           $delete= $this->efiling_model->delete_event('aptel_temp_add_advocate', 'id', $id);
	           if($delete){
	                $msg="Record successfully  deleted !";
	                $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
    	            $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt,$schemas);
    	            echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
    	        }
	        }else{
	            $msg="Something went wrong";
	            echo json_encode(['data'=>'','display'=>'','error'=>'1','massage'=>$msg]);die;
	        }
	    }
	    
	    
	    function getAdvDetailEdit(){
	        $array=array();
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];
	        if($token==$subtoken){
    	        $type=$_REQUEST['type'];
    	        $advType=$_REQUEST['advType'];
    	           if($type=='main'){
    	            $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$id);
    	            $advc=$st[0]->pet_council_adv;
    	            if (is_numeric($advc)) {
    	                $salt=$st[0]->salt;
    	                if($advType=='1'){
        	                $orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$advc);
        	                $adv_name=$orgname[0]->adv_name;
        	                $adv_fax=$orgname[0]->adv_reg;
        	                $adv_mobile=$orgname[0]->adv_mobile;
        	                $email=$orgname[0]->email;
        	                $adv_phone=$orgname[0]->adv_phone;
        	                $state_code=$orgname[0]->state_code;
        	                $adv_pin=$orgname[0]->adv_pin;
        	                $adv_dist=$orgname[0]->adv_dist;
        	                $address=$orgname[0]->address;
        	                $adv_fax=$orgname[0]->adv_fax;
        	                $adv_code=$orgname[0]->adv_code;
        	                if($orgname[0]->state_code!=''){
        	                    $st3 = $this->efiling_model->data_list_where('master_psstatus','state_code',$orgname[0]->state_code);
        	                    $statename= $st3[0]->state_name;
        	                }
        	                if($orgname[0]->adv_dist!=''){
        	                    $st2 = $this->efiling_model->data_list_where('master_psdist','district_code',$orgname[0]->adv_dist);
        	                    $ddistrictname= $st2[0]->district_name;
        	                }
    	                }
    	                if($advType=='2'){
    	                    $orgname=$this->efiling_model->data_list_where('efiling_users','id',$advc);
    	                    $adv_name=$orgname[0]->fname.''.$orgname[0]->lname;
    	                    $adv_fax=$orgname[0]->adv_reg;
    	                    $adv_mobile=$orgname[0]->mobilenumber;
    	                    $email=$orgname[0]->email;
    	                    $adv_phone='';
    	                    $state_code=$orgname[0]->state;
    	                    $adv_pin=$orgname[0]->pincode;
    	                    $adv_dist=$orgname[0]->district;
    	                    $address=$orgname[0]->address;
    	                    $adv_fax='';
    	                    $adv_code=$orgname[0]->id;
    	                    if($state_code!=''){
    	                        $st3 = $this->efiling_model->data_list_where('master_psstatus','state_code',$state_code);
    	                        $statename= $st3[0]->state_name;
    	                    }
    	                    if($adv_dist!=''){
    	                        $st2 = $this->efiling_model->data_list_where('master_psdist','district_code',$adv_dist);
    	                        $ddistrictname= $st2[0]->district_name;
    	                    }
    	                }
    	            }
    	            $array = array(
    	                'salt'=>$salt,
    	                'id'=> $salt,
    	                'adv_name'=>$adv_name,
    	                'counsel_add'=>$address,
    	                'counsel_pin'=>$adv_pin,
    	                'counsel_mobile'=>$adv_mobile,
    	                'counsel_email'=>$email,
    	                'council_code'=>$adv_code,
    	                'counsel_fax'=>$adv_fax,
    	                'counsel_phone'=>$adv_phone,
    	                'adv_district'=>$adv_dist,
    	                'adv_state'=>$state_code,
    	                'ddistrictname'=>$ddistrictname,
    	                'statename'=>$statename, 
    	                'action'=>'edit',
    	                'advType'=>$advType,
    	            );
    	            $data=json_encode($array);
    	            $msg="Something went wrong";
    	            echo json_encode(['data'=>'','display'=>$data,'error'=>'1','massage'=>$msg]);die;
    	        }
    	        
    	        
    	        

    	        if($type=='add'){
    	            $st = $this->efiling_model->data_list_where('aptel_temp_add_advocate','id',$id);
    	            if($st[0]->adv_state!=''){
    	                $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$st[0]->adv_state);
    	                $statename= $st2[0]->state_name;
    	            }
    	            if($st[0]->adv_district!=''){
    	                $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$st[0]->adv_district);
    	                $ddistrictname= $st1[0]->district_name;
    	            }

    	            $array = array(
    	                'salt'=>$salt,
    	                'id'=>$st[0]->id,
    	                'adv_name'=>$st[0]->adv_name,
    	                'counsel_add'=>$st[0]->counsel_add,
    	                'counsel_pin'=>$st[0]->counsel_pin,
    	                'counsel_mobile'=>$st[0]->counsel_mobile,
    	                'counsel_email'=>$st[0]->counsel_email,
    	                'council_code'=>$st[0]->council_code,
    	                'counsel_fax'=>$st[0]->counsel_fax,
    	                'counsel_phone'=>$st[0]->counsel_phone,
    	                'adv_district'=>$st[0]->adv_district,
    	                'adv_state'=>$st[0]->adv_state,
    	                'ddistrictname'=>$ddistrictname,
    	                'statename'=>$statename, 
    	                'action'=>'edit',
    	                'advType'=>$advType,
    	            );
    	            $data=json_encode($array);
    	            $msg="Something went wrong";
    	            echo json_encode(['data'=>'','display'=>$data,'error'=>'1','massage'=>$msg]);die;
    	        }
    	        
	        }else{
	            $msg="Something went wrong";
	            echo json_encode(['data'=>'','display'=>'','error'=>'1','massage'=>$msg]);die;
	        }
	    }
	   
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    function getAdvocatelist($advocatelist,$salt,$schemas){
	       // ini_set('display_errors', 1);
	      //  ini_set('display_startup_errors', 1);
	        //error_reporting(E_ALL);
	        $html='';
	        $html.='
            <table id="example" class="table display" cellspacing="0" border="1" width="100%">
	        <thead>
    	        <tr class="bg-dark">
        	        <th>Sr. No. </th>
        	        <th>Name</th>
        	        <th>Registration No.</th>
                    <th>Address</th>
        	        <th>Mobile</th>
        	        <th>Email</th>
                    <th>Edit</th>
        	        <th>Delete</th>
    	        </tr>
	        </thead>
	        <tbody>';
	        $html.='</tbody>';
	        $vals=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	        $advType=$vals[0]->advType;
	        if($vals[0]->pet_council_adv){
	            $counseladd=$vals[0]->pet_council_adv;
	            if($vals[0]->advType=='1'){
	                if (is_numeric($vals[0]->pet_council_adv)) {
	                    //$orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
	                   // $orgname=$this->db->get_where($schemas.'.advocate_master',['adv_code'=>$counseladd])->result();
	                    $orgname=$this->db->get_where('master_advocate',['adv_code'=>$counseladd])->result();
	                    $adv_name=$orgname[0]->adv_name;
	                    $adv_reg=$orgname[0]->adv_reg;
	                    $adv_mobile=$orgname[0]->adv_mobile;
	                    $email=$orgname[0]->email;
	                    $address=$orgname[0]->address;
	                    $pin_code=$orgname[0]->pincode;
	                    //$pin_code=$orgname[0]->adv_pin;

	                    if($vals[0]->pet_state!=''){
	                        $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
	                        $statename= $st2[0]->state_name;
	                    }
	                    if($vals[0]->pet_dist!=''){
	                        $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
	                        $ddistrictname= $st1[0]->district_name;
	                    }
	                }
	            }
	            
	            if($vals[0]->advType=='2'){
	                if (is_numeric($vals[0]->pet_council_adv)) {
	                    $orgname=$this->efiling_model->data_list_where('efiling_users','id',$counseladd);
	                    $adv_name=$orgname[0]->fname.' '.$orgname[0]->lname;
	                    $adv_reg=$orgname[0]->id_number.' <span style="color:red">'.$orgname[0]->idptype.'</span>';
	                    $adv_mobile=$orgname[0]->mobilenumber;
	                    $email=$orgname[0]->email;
	                    $address=$orgname[0]->address;
	                    $pin_code=$orgname[0]->pincode;
	                    
	                    if($vals[0]->pet_state!=''){
	                        $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
	                        $statename= $st2[0]->state_name;
	                    }
	                    if($vals[0]->pet_dist!=''){
	                        $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
	                        $ddistrictname= $st1[0]->district_name;
	                    }
	                }
	            }
	            $type="'main'";
	            $html.='
                <tr style="color:green">
                    <td>1</td>
        	        <td>'.$adv_name.'</td>
        	        <td>'.$adv_reg.'</td>
                    <td>'.$address.' '.$ddistrictname.' ('.$statename.')  '.$pin_code.'</td>
        	        <td>'.$adv_mobile.'</td>
        	        <td>'.$email.'</td>
        	        <td><center><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editPartyAdv('.$vals[0]->salt.','.$type.','.$advType.')"></center></td>
                    <td></td>
                </tr>';
	        }
	      //  $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
	        
	        if(!empty($advocatelist)){
	            $i=2;
	            foreach($advocatelist as $val){
	                
	                $counselmobile='';
	                $counselemail='';
	                $counseladd=$val->council_code;
	                $advType=$val->advType;
	                if($advType=='1'){
	                    if (is_numeric($val->council_code)) {
	                        $orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
							//$orgname=$this->db->get_where($schemas.'.advocate_master',['adv_code'=>$counseladd])->result();
	                        $adv_name=$val->adv_name;
	                        $adv_reg=$orgname[0]->adv_reg;
	                        $address=$val->counsel_add;
	                        $pin_code=$val->counsel_pin;
	                        $counselmobile=$val->counsel_mobile;
	                        $counselemail=$val->counsel_email;
	                        $id=$val->id;
	                        if($val->adv_state!=''){
	                            $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$val->adv_state);
	                            $statename= (!empty($st2))?$st2[0]->state_name:'';
	                        }
	                        if($val->adv_district!=''){
	                            $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$val->adv_district);
	                            $ddistrictname= (!empty($st1))?$st1[0]->district_name:'';
	                        }
	                    }
	                }
	                
	                
	                
	                
	                if($advType=='2'){
	                    if (is_numeric($val->council_code)) {
	                        $orgname=$this->efiling_model->data_list_where('efiling_users','id',$counseladd);
	                        $adv_name=$orgname[0]->fname.' '.$orgname[0]->lname;
	                        $adv_reg=$orgname[0]->id_number.' <span style="color:red">'.$orgname[0]->idptype.'</span>';
	                        $counselmobile=isset($orgname[0]->mobilenumber)?$orgname[0]->mobilenumber:'';
	                        $counselemail=isset($orgname[0]->email)?$orgname[0]->email:'';
	                        $address=$orgname[0]->address;
	                        $pin_code=$orgname[0]->pincode;
	                        $id=$val->id;
	                        if($vals[0]->pet_state!=''){
	                            $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
	                            $statename= $st2[0]->state_name;
	                        }
	                        if($vals[0]->pet_dist!=''){
	                            $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
	                            $ddistrictname= $st1[0]->district_name;
	                        }
	                    }
	                }
	                
	                $type="'add'";
	                $html.='<tr>
            	        <td>'.$i.'</td>
            	        <td>'.$adv_name.'</td>
            	        <td>'.$adv_reg.'</td>
                        <td>'.$address.' '.$ddistrictname.' ('.$statename.')  '.$pin_code.'</td>
            	        <td>'.$counselmobile.'</td>
            	        <td>'.$counselemail.'</td>
            	        <td><center><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"  data-toggle="modal" data-target="#exampleModal" onclick="editPartyAdv('.$id.','.$type.','.$advType.')"></center></td>
                        <td><center><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deletePartyadv('.$id.')"></center></td>
        	        </tr>';
	                $i++;
	            }
	        }
	        return $html;
	    }	
	    
	    
	    
	   
	    
	    function getAdvDetailinperson(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $type=$_REQUEST['type'];
	        if($token==$subtoken){
	            $st = $this->efiling_model->data_list_where('efiling_users','id',$user_id);
	            if($st[0]->state!=''){
	                $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$st[0]->state);
	                $statename= $st2[0]->state_name;
	            }
	            if($st[0]->district!=''){
	                $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$st[0]->district);
	                $ddistrictname= $st1[0]->district_name;
	            }
    	        $array = array(
    	            'salt'=>$salt,
    	            'id'=>$st[0]->id,
    	            'adv_name'=>$st[0]->id,
    	            'counsel_add'=>$st[0]->address,
    	            'counsel_pin'=>$st[0]->pincode,
    	            'counsel_mobile'=>$st[0]->mobilenumber,
    	            'counsel_email'=>$st[0]->email,
    	            'council_code'=>'',
    	            'counsel_fax'=>'',
    	            'counsel_phone'=>'',
    	            'adv_district'=>$st[0]->district,
    	            'adv_state'=>$st[0]->state,
    	            'ddistrictname'=>$ddistrictname,
    	            'statename'=>$statename,
    	        );
    	        $data=json_encode($array);
    	        $msg="success";
    	        echo json_encode(['data'=>'success','display'=>$data,'error'=>'1','massage'=>$msg]);die;
	        }
	    }
	    
	    
	    function getAdvinpers(){
	        $userdata=$this->session->userdata('login_success');
	        $salt=$this->session->userdata('salt');
	        $subtoken=$this->session->userdata('submittoken');
	        $token=$_REQUEST['token'];
	        $user_id=$userdata[0]->id;
	        $id=$_REQUEST['id'];
	        if($token==$subtoken){
	            $st = $this->efiling_model->data_list_where('efiling_users','id',$id);
	            if($st[0]->state!=''){
	                $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$st[0]->state);
	                $statename= $st2[0]->state_name;
	            }
	            if($st[0]->district!=''){
	                $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$st[0]->district);
	                $ddistrictname= $st1[0]->district_name;
	            }
	            $array = array(
	                'salt'=>$salt,
	                'id'=>$st[0]->id,
	                'adv_name'=>$st[0]->id,
	                'counsel_add'=>$st[0]->address,
	                'counsel_pin'=>$st[0]->pincode,
	                'counsel_mobile'=>$st[0]->mobilenumber,
	                'counsel_email'=>$st[0]->email,
	                'council_code'=>'',
	                'counsel_fax'=>'',
	                'counsel_phone'=>'',
	                'adv_district'=>$st[0]->district,
	                'adv_state'=>$st[0]->state,
	                'ddistrictname'=>$ddistrictname,
	                'statename'=>$statename,
	            );
	            $data=json_encode($array);
	            $msg="success";
	            echo json_encode(['data'=>'success','display'=>$data,'error'=>'1','massage'=>$msg]);die;
	        }
	    }
	    
	    
	    
	    
	    
	    function getApplantName(){
	        $key=$this->input->post('key');
	        $rs=$this->admin_model->getAppRecord($this->input->post());
	        $html='';
	        foreach($rs as $vals){
	            $html.='<li value="'.$vals->adv_code.'" onclick="showUserApp('.$vals->org_id.')">'.$vals->org_name.'</li>';
	        }
	       echo json_encode(['dtls'=>$html,$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
	    }
	    
	    
	    function getApplantNameEdit(){
	        $key=$this->input->post();
	        $rs=$this->admin_model->getAppRecord($this->input->post());
	        $html='';
	        foreach($rs as $vals){
	            $html.='<li value="'.$vals->adv_code.'" onclick="showUserAppedit('.$vals->org_id.')">'.$vals->org_name.'</li>';
	        }
	        echo $html;die;
	    }
	    
	    
	    
	    function getRespondentName(){
	        $key=$this->input->post();
	        $rs=$this->admin_model->getAppRecord($this->input->post());
	        $html='';
	        foreach($rs as $vals){
	            $html.='<li value="'.$vals->adv_code.'" onclick="showUserAppRes('.$vals->org_id.')">'.$vals->org_name.'</li>';
	        }

			echo json_encode(['dtls'=>$html,$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
	    }
	    
	    
	    function getRespondentNameEdit(){
	        $key=$this->input->post();
	        $rs=$this->admin_model->getAppRecord($this->input->post());
	        $html='';
	        foreach($rs as $vals){
	            $html.='<li value="'.$vals->adv_code.'" onclick="showUserAppResEdit('.$vals->org_id.')">'.$vals->org_name.'</li>';
	        }
	        echo $html;die;
	    }
	    
	    
	    
	    function getAdv()
		{

			$key=strtolower($this->input->post('key'));
			$saltNo=$this->input->post('saltNo');
			//$tempData=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$saltNo);
			//$tempData=$this->db->select('bench')->get_where('aptel_temp_appellant',['salt'=>$saltNo])->row_array();
			//$bench= $tempData['bench'];
			//$benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
			//$schemas=$benchData['schema_name'];

			$this->db->select('adv_code,adv_name');
			//$this->db->from($schemas.'.advocate_master');
			$this->db->from('master_advocate');
			$this->db->like('LOWER(adv_name)',$key,'after');
			$this->db->limit(20);
			$rs = $this->db->get()->result();

	        $html='';
	        foreach($rs as $vals)
			{
	            //$html.='<li value="'.$vals->adv_code.'" onclick="showUserOrg('.$vals->adv_code.','.$schemas.')">'.$vals->adv_name.'</li>';
	            $html.='<li value="'.$vals->adv_code.'" onclick="showUserOrg('.$vals->adv_code.')" >'.$vals->adv_name.'</li>';

	        }
	        echo $html;die;
	    }
		function getAdvrp()
		{
			$key=strtolower($this->input->post('key'));
			$saltNo=$this->input->post('saltNo');
			//$tempData=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$saltNo);
			$tempData=$this->db->select('bench')->get_where('rpepcp_reffrence_table',['salt'=>$saltNo])->row_array();
			$bench= $tempData['bench'];
			$benchData=getSchemasNames($tempData['bench']);
			 $schemas=$benchData->schema_name;

			$this->db->select('adv_code,adv_name');
			$this->db->from($schemas.'.advocate_master');
			$this->db->like('LOWER(adv_name)',$key,'after');
			$rs = $this->db->get()->result();

			$html='';
			foreach($rs as $vals)
			{
				//$html.='<li value="'.$vals->adv_code.'" onclick="showUserOrg('.$vals->adv_code.','.$schemas.')">'.$vals->adv_name.'</li>';
				$html.='<li value="'.$vals->adv_code.'" onclick="showUserOrg('.$vals->adv_code.')" >'.$vals->adv_name.'</li>';

			}
			echo $html;die;
		}
	    
		public function openfiles(){
			$this->load->library('encryption');
			$currentUserId= $this->userData[0]->id;
			$filepath=$this->input->post('filepath');
			$encryp = $this->encryption->decrypt($filepath);
			list($request_user_id,$path)=explode('@',$encryp);
			if($request_user_id !==$currentUserId){
				die;
			}
			header("Content-Type:".get_mime_by_extension($path));
			echo readfile($path);
			
		}
		public function openfile($id){
			error_reporting(0);
			//$params=['id'=>$id,'user_id'=>$this->userData[0]->id];
			$currentUserId= $this->userData[0]->id;
			$params=['id'=>$id,
				"(user_id=$currentUserId or od.filing_no in (select mp.map_filing_no as filing_no from case_detail_maping as mp where mp.map_user_id=$currentUserId) )"=>null,
			];
			if(in_array($this->userData[0]->role,array(2,3))){
				$params=['id'=>$id];
			}
			$this->db->select('file_url');
			$this->db->from("efile_documents_upload as od");
			$this->db->where($params);
			//echo $builder->getCompiledSelect();die;
			$sth =$this->db->get();
			if($sth->num_rows()>0):
				$filedata= $sth->row_array();
				//$path=ORDER_UPLOAD_PATH;
				$path=$filedata['file_url'];
				header('Content-Type:application/pdf');
				echo file_get_contents($path);
			endif;
		}


public function openfiledraft($id){
	
	//echo '<pre>';
	//ini_set('display_errors',1);
	//error_reporting(E_ALL);
	$this->db->select('file_url');
	$this->db->from("temp_documents_upload as od");
	$this->db->where(['id'=>$id,'user_id'=>$this->userData[0]->id]);
	
	$sth =$this->db->get();
	//echo $this->db->last_query();die;
	if($sth->num_rows()>0):
		$filedata= $sth->row_array();
		//$path=ORDER_UPLOAD_PATH;
		$path=$filedata['file_url'];			
		header('Content-Type:application/pdf');
		echo file_get_contents($path);
		
	endif;
}
public function openfilebyPath($path)
{
	$path=base64_decode($path);
	header('Content-Type:application/pdf');
	echo file_get_contents($path);
}
	    
public function formCa3($filing_no)
{
	//ini_set('display_errors',1);
	//error_reporting(E_ALL);
	$schemasDetails= getSingleSchemas($filing_no);
	$schemas=$schemasDetails['schema_name'];
	//print_r($schemasDetails);
	$this->db->select('cd.*,ci.*,isd.desg_name as isddesg_name');
	$this->db->select("case when chk.add_comm ='1' then 'YES' else 'NO' end  as add_comm ,case when chk.app_quest ='1' then 'YES' else 'NO' end  as app_quest");
	$this->db->select("org.org_name,adj_org.org_name as adj_org,ass_desig.desg_name as assdesg_name,adj_desig.desg_name as adj_desig_name");
	$this->db->from($schemas.'.case_detail as cd');
	$this->db->join($schemas.'.case_detail_impugned as ci','ci.filing_no=cd.filing_no','Left');
	$this->db->join($schemas.'.check_list_customs as chk','chk.filing_no=cd.filing_no','Left');
	$this->db->join('iss_desig_master as isd','ci.iss_desig=isd.desg_code','Left');
	$this->db->join('org_name_master as org','org.org_code=chk.ass_org','Left');
	$this->db->join('ass_desig_master as ass_desig','ass_desig.desg_code=chk.ass_desig','Left');
	$this->db->join('org_name_master as adj_org','adj_org.org_code=chk.adj_org','Left');
	$this->db->join('adj_desig_master as adj_desig','adj_desig.desg_code=chk.adj_desig','Left');
	$this->db->join('issue_master as issue_master','issue_master.issue_no=chk.adj_desig','Left');
	$this->db->where(['cd.filing_no'=>$filing_no]);
	$query = $this->db->get();
	$data= $query->row_array();
	//$data= $this->db->get_where('case_detail',['filing_no'=>$filing_no])->row_array();
	//$caseDetailImpugned = $this->db->get_where('case_detail_impugned',['filing_no'=>$filing_no])->row_array();
	//$data['caseDetailImpugned'] = $caseDetailImpugned;
	echo $this->db->last_query();
	//$designationsArray=getIssAuthDesignations(['desg_code'=>$caseDetailImpugned['iss_desig']]);
	//$data['designationsArray']=$designationsArray;
	
	//print_r($designationsArray);
	
	$this->load->view("admin/form-ca-3",$data);

}	    
	    
	    
	    
	    



}//**********END Main function ************/