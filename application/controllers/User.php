<?php

	class User extends My_Controller 
	{
	    public function __construct() 
		{
	        parent::__construct();
	        $this->load->model('Admin_model','admin_model');
	        $this->load->model('Efiling_model','efiling_model');	
			
	    }
		
		private function checkUSerAccess()
		{
			switch($this->userData[0]->role):
			case 1:
				//do nothing it is admin
			break;
			case 2:		
					//do nothing it is nodel			
			break;
			default:
				redirect(base_url());die;
			endswitch;
		}
		
	    public function euser_list()
		{
			$this->db->from('efiling_users');
			switch($this->userData[0]->role):
			case 1:
			break;
			case 2:
				$this->db->where(['org_name'=>$this->userData[0]->org_name,'role'=>0]);
			break;
			default:
				redirect(base_url());die;
			endswitch;
			$query=$this->db->get();
			$users= $query->result();
			$data['users']= $users;
			$this->load->view("admin/euser_list",$data);
	        
	    }
	    public function editprofile()
		{
	        $userdata=$this->session->userdata('login_success');

	        $user_id=isset($userdata[0]->id)?$userdata[0]->id:'';
	        $data=array();

	            $data['users']= $this->efiling_model->data_list_where('efiling_users','id',$user_id);
	            $data['states']=$this->admin_model->getStates();

	                $this->form_validation->set_rules('fname', 'Enter first Name', 'trim|required|max_length[100]|regex_match[/^[a-z,]+$/]');
	                $this->form_validation->set_rules('lname', 'Enter last Name', 'trim|required|max_length[100]|regex_match[/^[a-z,]+$/]');
	                $this->form_validation->set_rules('mobilenumber', 'Enter mobile number.', 'trim|required|numeric|max_length[10]|regex_match[/^[0-9,]+$/]');
	                $this->form_validation->set_rules('address', 'Enter valid address', 'trim|required|max_length[200]');
	                $this->form_validation->set_rules('email', 'Enter Email.', 'trim|required|max_length[150]');
	                $this->form_validation->set_rules('pincode', 'Enter valid amount.', 'trim|required|numeric|max_length[6]|regex_match[/^[0-9,]+$/]');
	                $this->form_validation->set_rules('country', 'Enter valid country.', 'trim|required|max_length[5]|regex_match[/^[a-z,]+$/]');
	                $this->form_validation->set_rules('statename', 'Enter valid state', 'trim|required|numeric|max_length[3]|regex_match[/^[0-9,]+$/]');
	                $this->form_validation->set_rules('district', 'Enter valid district.', 'trim|required|numeric|max_length[3]|regex_match[/^[0-9,]+$/]');
	                if($this->form_validation->run() == false){
	                    $data['data']='error';
	                    $data['errors']=validation_errors();
	                    $this->load->view("admin/editprofile",$data);
	                }else{
	                    $array=array(
	                        'fname'=>htmlentities($_REQUEST['fname']),
	                        'lname'=>htmlentities($_REQUEST['lname']),
	                        'mobilenumber'=>htmlentities($_REQUEST['mobilenumber']),
	                        'address'=>htmlentities($_REQUEST['address']),
	                        'email'=>htmlentities($_REQUEST['email']),
	                        'pincode'=>htmlentities($_REQUEST['pincode']),
	                        'country'=>htmlentities($_REQUEST['country']),
	                        'state'=>htmlentities($_REQUEST['statename']),
	                        'district'=>htmlentities($_REQUEST['district']),
	                    );
	                    $where=array('id'=>$user_id);
	                    $this->efiling_model->update_data_where('efiling_users',$where,$array);
	                    $data['users']= $this->efiling_model->data_list_where('efiling_users','id',$user_id);
	                    $data['msg']='Record successfully updated';
	                    $this->load->view("admin/editprofile",$data);
	                }


	    }
		
		
		public function user_view()
		{
	    $this->checkUSerAccess();    
	        $adv_id=$this->input->post('adv_id');
	       
	            $st=$this->db->get_where('efiling_users',['id'=>$adv_id])->result();
	            $status='';
	            if($st[0]->verified==1){ $status= "Active"; $color='btn-success'; $action= "Varified"; }
				else{ $status=  "Non Active";$color='btn-primary';$action= "Not Varified";  }    
	            $html='<div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane  show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>User Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->loginid.'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->fname.''.$st[0]->lname.'</p>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-md-6">
                                                <label>User Type</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->user_type.'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->email.'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->mobilenumber.'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$status.'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->address.'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Enrolment</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->enrolment_number.'</p>
                                            </div>
                                        </div>   
                            </div>';
	            echo json_encode(['data'=>'success','value'=>$html,'massage'=>'','error'=>'1']);
	       
	    }
		
	public function user_varified()
	{
		$this->checkUSerAccess();  
			
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $this->form_validation->set_rules('status','status not valid','trim|required|numeric|min_length[1]|max_length[5]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        $this->form_validation->set_rules('adv_id','advocate id not valid','trim|required|min_length[1]|max_length[5]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
	        }
	        $this->form_validation->set_rules('remark','please enter remark','trim|required|htmlspecialchars');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }   
	        $status=$this->input->post('status');
	        $remark=$this->input->post('remark');
	        $adv_id=$this->input->post('adv_id');
	        $val= $this->efiling_model->data_list_where('efiling_users','id', $adv_id);
			
	        $advcode=0;
	     
			$mobile=$val[0]->mobilenumber;	            
			$loginid=$val[0]->loginid;	            
	            if($val[0]->enrolment_number!='' && $val[0]->user_type=='advocate'){ 
	                $mobile=$val[0]->mobilenumber;
	                $val=$this->efiling_model->data_list_where('master_advocate','adv_mobile', $mobile);
	                if(!empty($val)){
	                    $advcode=$val[0]->adv_code;
	                }else{
	                    $massage="User mobile number not registerd  .";
	                    echo json_encode(['data'=>'error','value'=>'','massage'=>$massage,'error'=>'1']);
	                }
	            }
				
				switch($status):
				case 1:
					if($val[0]->verified!=1){					
					sendsms('This is system generated SMS alert from CESTAT.Your Account has been successfully activated. Login to efiling portal of CESTAT with username '.$loginid.' and password as entered by you. In case, you forgot the password, then click on forgot password link.CESTAT',$mobile,'1407168439498673294');
					}
				break;
				case 2:
				
				break;
				default:
				
				endswitch;
				
				 $data=array(
	                'remark'=>$remark,
	                'verified'=>$status,
	                'adv_code'=>$advcode,
	                'role'=>(int)$this->input->post('role'),
					'dupdate_date'=>date('Y-m-d H:i:s'),
	            );
				
	            $massage="Successfully Verified.";
	            $st=$this->efiling_model->update_data('efiling_users', $data,'id', $adv_id);
	            echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);die;
	        
	}
	
	
	public function adv_varified(){
		$this->checkUSerAccess();  
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $this->form_validation->set_rules('status','status not valid','trim|required|min_length[1]|max_length[5]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        }
	        $this->form_validation->set_rules('adv_id','advocate id not valid','trim|required|min_length[1]|max_length[5]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
	        }
	        $this->form_validation->set_rules('remark','please enter remark','trim|required|htmlspecialchars');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	        } 
	        $status=$_REQUEST['status'];
	        $remark=$_REQUEST['remark'];
	        $adv_id=$_REQUEST['adv_id'];
	        if($user_id){         
	            $data=array(
	                'remark'=>$remark,
	                'status'=>$status,
	            );
	            $massage="Successfully Verified.";
	            $st=$this->efiling_model->update_data('master_advocate', $data,'id', $adv_id);
	            echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
	        }else{
	            $massage="User not valid  .";
	            echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'1']);
	        }  
	    }
	    
	    
	}
	