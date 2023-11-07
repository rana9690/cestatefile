<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Mystart extends CI_Controller {	
		protected $throttles;	
		protected $captcha_data;
		function __construct() {
			
			parent::__construct();
			
			$this->session->unset_userdata('salt');
			$this->session->unset_userdata('rpepcpsalt');
			$this->session->unset_userdata('refiling');
			$this->load->helper(array('form','url','html','security'));
			
           	 	$this->load->model('Admin_model','admin_model');
           	 	$this->load->model('Efiling_model','efiling_model');       
               		date_default_timezone_set('Asia/Calcutta');
               		$this->log_file_name='./logfile/log.txt'; 
	        	$config = array(
	            	'img_path'      => 'asset/captcha_images/',
	            	'img_url'       => base_url().'asset/captcha_images/',
	            	'font_path'     => FCPATH.'asset/fonts/texb.ttf',
	            	'img_width'     => 150,
	            	'img_height'    => 37,
	            	'word_length'   => 6,
	            	'font_size'     => 18,
        		    'pool'          => '0123456789',
	            	'captcha_case_sensitive' => TRUE,
	            	'colors' => array(
				        'background' => array(79, 255, 255),
				        'border' => array(79, 255, 255),
				        'text' => array(0, 0, 0),
				        'grid' => array(79, 255, 255)
				  )
	       		 );
	        	//$captcha = create_captcha($config);
				
				$permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$wordString=substr(str_shuffle($permitted_chars), 0, 6);
				$captcha=['word'=>$wordString,'image'=>'<label class="form-control" style="background-color:#ffffff;">'.$wordString.'</label>','time'=>''];
	        	$this->captcha_data=$captcha;
				$this->throttles=new Throttle();
				
		}

		

		public function index() {
			if(@$this->session->userdata('login_success')) {
				return redirect(base_url('loginSuccess'), 'refresh');
				die;
			}

			$registerdcases=$this->db->select("count(filing_no)as totalefilied,count(case when date_part('month',created_at)=(select date_part('month',(select CURRENT_TIMESTAMP))) then 1 else null end )as totalthismonth")->get_where('case_detail',["user_id > 10000"=>null])->row_array();
			$registerdusers=$this->db->select("count(id) as registreduser,count(case when user_type='advocate' then 1 else null end )as registredadvocate")->get_where('efiling_users',["verified"=>"1",'role!=1'=>null])->row_array();

			$this->session->unset_userdata('skey_session');
			$this->session->set_userdata('skey_session',$this->captcha_data['word']);
			$state_array['states']=$this->admin_model->getStates();
			$this->load->view('header');
			$this->load->view('index',['captcha_data'=>$this->captcha_data,'registerdcases'=>$registerdcases,'registerdusers'=>$registerdusers]);
			$this->load->view('modals',$state_array);
			$this->load->view('footer');
		}
		
		function  logout(){
			/*if(@$userdata=$this->session->userdata('login_success')) {
				$user_id=$userdata[0]->id;
				$this->delete_session_user_id($user_id);
			}
	        $this->session->unset_userdata('login_success');*/
			$this->session->sess_destroy(session_id());
	        //$this->index();
	        redirect(base_url());
		}

	

    public function confirm_login($admin_user=NULL) {
		
		$this->form_validation->set_rules('eid','Enter valid login id','trim|required|max_length[50]');
		$this->form_validation->set_rules('pass','Enter valid password','trim|required');
		$this->form_validation->set_rules('skey','Captcha required','required');

		if($this->form_validation->run() === false) {
			echo json_encode(['login_type'=>'failed','message'=>strip_tags(validation_errors()),'captcha'=>$this->captcha_data['image']]);
			die;
		}

        $login_details=$this->input->post();
		$passwd=$login_details['pass'];
		$uid=$login_details['eid'];
		$session_key=$this->session->userdata('skey_session');
           $salt=$this->input->post('skey');//isset($login_details['skey'])?$login_details['skey']:'';
            if($salt==''){
                echo "Please Enter Valid captacha !";die;
            }

			//$this->session->unset_userdata('skey_session');

	        if($salt == $session_key) {


				$throttlechek=$this->throttles->throttleCheck($uid, 4, 240);
				if($throttlechek['status']===false):
					$this->session->set_userdata('skey_session',$this->captcha_data['word']);
					echo json_encode(['login_type'=>'failed','message'=>$throttlechek['message'],'captcha'=>$this->captcha_data['image']]);
					die;
				endif;

	                	$return_data=$this->admin_model->verify_user($passwd,$uid,$session_key);

	                	if($return_data != false) {
							$this->delete_session_user_id($return_data[0]->id);
	                        $this->_make_logfile_true($uid, date('d-m-Y H:i:s'));
	                        $this->session->set_userdata('login_success',$return_data);
							$this->session->set_userdata('user_id',$return_data[0]->id);
	                        $data=['login_type'=>'success', 'captcha'=>''];
							$this->throttles->throttle_cleanup(1,$uid);
							 session_regenerate_id(true);
	                        echo json_encode($data); exit;

	                    } else { 
	                    	$this->_make_logfile_false($uid, '');
							$this->throttles->throttle($uid, 4, 240);
	                    	//echo json_encode(['login_type'=>'failed','captcha'=>$data['captcha_data']['image']]);
							$this->session->set_userdata('skey_session',$this->captcha_data['word']);
							echo json_encode(['login_type'=>'failed','message'=>$throttlechek['message'],'captcha'=>$this->captcha_data['image']]);
	                    	exit; 
	                    }

	        }else {
	        	$this->_make_logfile_false($uid, '');
				$this->session->set_userdata('skey_session',$this->captcha_data['word']);
	        	echo json_encode(['login_type'=>'woring skey','captcha'=>$this->captcha_data['image']]);
	        	exit;
	        	}

    }

    public function get_districts() {
    	if($this->input->post()) {
    		$retn=$this->admin_model->getDistricts($this->input->post());
    		echo json_encode(['data'=>$retn,'error'=>'0']);
    	}
    	else echo json_encode(['data'=>'','error'=>'Invalid request.']);
    	exit();
    }

    public function verify_mandatory() {
        if($this->input->post('mobilenumber')!='' && strlen($this->input->post('mobilenumber'))<'10'){
            echo json_encode(array('data'=>'','error'=>'mobile number is not valid.'));die;
        }
    	if($this->input->post()) {
    		$retn=$this->admin_model->verifyUnique($this->input->post());
    		echo json_encode(['data'=>$retn,'error'=>'0']);
    	}
    	else echo json_encode(['data'=>'','error'=>'Invalid request.']);
    	exit();    	
    }

    public function fetch_advocate_data() {
    	if($this->input->post()){
    	    $adv_reg=$this->input->post('enrolment_number');
    	    if($adv_reg!=''){
			     $this->form_validation->set_rules('enrolment_number', 'Enter valid name/mobile number.', 'trim|regex_match[/^[a-zA-Z0-9\/\-_]+$/]|max_length[50]|is_unique[efiling_users.enrolment_number]');
    	    }
			if($this->form_validation->run() == TRUE) {
				$data['adv_reg']=$this->input->post('enrolment_number');
	    		$data=$this->admin_model->get_advocate_details($data);
	    		if($data)				{ $data['error']='0'; echo json_encode($data); }
	    		elseif($data==false) 	echo json_encode(['error'=>'<strong class="text-primary">Error</strong> : sorry enrolment number or Mobile Number does not match please Add Advocate.']);
			}
			else 	echo json_encode(['error'=>"<strong class='text-success'>Congrates</strong>: you are already exists.\n\rKindly login or forgot password."]);
    	}
    }


    public function fetch_org_data() {
    	if($this->input->post()){
    		$data=$this->admin_model->get_org_details();
    		echo json_encode($data);
    	}
    }

    public function fetch_org_further_data(){
        $this->form_validation->set_rules('Org_id', 'Enter valid organization id', 'trim|integer|max_length[5]');
        if($this->form_validation->run() == FALSE) {
            echo json_encode(array('data'=>'','error'=>strip_tags(validation_errors())));die;   
        }
    	if($this->input->post()) {
    		$data=$this->admin_model->get_org_fdetails($this->input->post());
    		echo json_encode($data);
    	}
    }

    /*public function send_OTP() {
      
    	if($this->input->post('mobilenumber')) {
	    	$randamOTP=rand(9999, 1000);
	    	$randamOTP='1234';
	    	$otpSessTime=date('d-m-Y H:i:s', strtotime('+15 minutes'));
	    	$this->session->set_userdata('sess_motp',array('otp'=>$randamOTP,'validTime'=>$otpSessTime));
	    	/*$url='Your One Time Password (OTP) for Commercial Court mobile verification is : '.$randamOTP.', which is valid for 15 minutes. DO NOT SHARE THIS WITH ANYONE - Commercial Court Telangana State';
	    	$url='http://scourtapp.nic.in/emom_sms.php?mobile='.$this->input->post('mobilenumber').'&message='.urlencode($url);
	    	$return =file_get_contents($url);*/
	    	/* echo json_encode(array('data'=>'success','error'=>$otpSessTime));
	    }
	    else if($this->input->post('email')) {
	    	//$randamOTP=rand(9999, 1000);
	    	$randamOTP='1234';
	    	$otpSessTime=date('d-m-Y H:i:s', strtotime('+15 minutes'));
	    	$this->session->set_userdata('sess_eotp',array('otp'=>$randamOTP,'validTime'=>$otpSessTime));	    	
	    	echo json_encode(array('data'=>'success','error'=>$otpSessTime));
	    }
	    else echo json_encode(array('data'=>'','error'=>'Invalid request.'));

    }*/
	
	
    public function send_OTP() 
	{
    	if($this->input->post('mobilenumber')) {
    	    $this->form_validation->set_rules('mobilenumber','Enter mobile number.','trim|required|numeric|min_length[10]|max_length[10]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
    	    if($this->form_validation->run() == FALSE){
    	        echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>'1']); die;
    	    }
    	    
    	    $mobile=$this->input->post('mobilenumber');
			$randamOTP=rand(9999, 1000);
    	   // $randamOTP='1234';
    	    $otpcal=$this->efiling_model->data_list_where('otp_handllar','mobile',$mobile);
    	    $comccc=count($otpcal);
    	    if($comccc < 5){
        	    $data=array(
        	        'mobile'=>$mobile,
        	        'opt'=>$randamOTP,
        	        'timeotp'=>time(),
        	        'dateotp'=>date('Y-m-d'),
        	    );
        	   
        	    $this->efiling_model->insert_query('otp_handllar',$data);
				sendsms('E- verification code for your mobile is '.$randamOTP.'.OTP is valid for 15 minutes.CESTAT',$mobile,'1407168257528701296');
    	    }else{
    	        $nowv=time();
    	        $otpcal=$this->db->order_by('timeotp desc')->limit(1)->get_where('otp_handllar',['mobile'=>$mobile])->result();
    	        if($nowv > ($otpcal[0]->timeotp + 15 * 60)){
    	            $this->efiling_model->delete_event('otp_handllar', 'mobile', $mobile); 
    	            $data=array(
    	                'mobile'=>$mobile,
    	                'opt'=>$randamOTP,
    	                'timeotp'=>time(),
    	                'dateotp'=>date('Y-m-d'),
    	            );
    	            $this->efiling_model->insert_query('otp_handllar',$data);
					
    	        }else{
    	            echo json_encode(array('data'=>'error','error'=>'Please try after 15 minutes'));die;
    	        }
    	    }
    	    

    	 //   $delete= $this->efiling_model->delete_event('aptel_temp_add_advocate', 'id', $id);
	    	//$randamOTP=rand(9999, 1000);
	    	
	    	$otpSessTime=date('d-m-Y H:i:s', strtotime('+15 minutes'));
	    	$this->session->set_userdata('sess_motp',array('otp'=>$randamOTP,'validTime'=>$otpSessTime));
	    	/*$url='Your One Time Password (OTP) for Commercial Court mobile verification is : '.$randamOTP.', which is valid for 15 minutes. DO NOT SHARE THIS WITH ANYONE - Commercial Court Telangana State';
	    	$url='http://scourtapp.nic.in/emom_sms.php?mobile='.$this->input->post('mobilenumber').'&message='.urlencode($url);
	    	$return =file_get_contents($url);*/
			
			
			
			

	    	$massage='';
	    	//$url='https://scourtapp.nic.in/sendOTP.php?mobile='.$this->input->post('mobilenumber').'&message='.$massage.'&otp='.$randamOTP.'';
	    	 //$url='http://scourtapp.nic.in/emom_sms.php?mobile='.$this->input->post('mobilenumber').'&message='.urlencode($url);
	    	 // $url='http://scourtapp.nic.in/emom_sms.php?mobile=9958663113&message='.urlencode($url);
	    	// echo $url;die;
	        //	 $return =file_get_contents($url); 
	    	 $valcaptcha=$this->captcha();
	    	 echo json_encode(array('data'=>'success','error'=>$otpSessTime,'returntoken'=>$valcaptcha));
	    }else if($this->input->post('email')) {
	        $this->form_validation->set_rules('email', 'Enter valid email id', 'trim|required|valid_email|max_length[250]');
	        if($this->form_validation->run() == FALSE) {
	            echo json_encode(array('data'=>'error','error'=>strip_tags(validation_errors())));die;
	        }
	    	$randamOTP=rand(9999, 1000);
	    	//$randamOTP='1234';
	    	
	    	
	    	$emailval=$this->input->post('email');
	    	//$randamOTP='1234';
	    	$otpcal=$this->efiling_model->data_list_where('otp_handllar','email',$emailval);
	    	$comccc=count($otpcal);
	    	if($comccc < 5){
	    	    $data=array(
	    	        'email'=>$emailval,
	    	        'opt'=>$randamOTP,
	    	        'timeotp'=>time(),
	    	        'dateotp'=>date('Y-m-d'),
	    	    );
	    	    $this->efiling_model->insert_query('otp_handllar',$data);
				send_mail($emailval,'E- verification code','E- verification code for your email is '.$randamOTP.'.OTP is valid for 15 minutes.CESTAT');
	    	}else{
	    	    $nowv=time();
	    	    $otpcal=$this->db->order_by('timeotp desc')->limit(1)->get_where('otp_handllar',['email'=>$emailval])->result();
	    	    if($nowv > ($otpcal[0]->timeotp + 15 * 60)){
	    	        $this->efiling_model->delete_event('otp_handllar', 'email', $emailval);
	    	        $data=array(
	    	            'email'=>$emailval,
	    	            'opt'=>$randamOTP,
	    	            'timeotp'=>time(),
	    	            'dateotp'=>date('Y-m-d'),
	    	        );
	    	        $this->efiling_model->insert_query('otp_handllar',$data);
	    	    }else{
	    	        echo json_encode(array('data'=>'error','error'=>'Please try after 15 minutes'));die;
	    	    }
	    	}
	    	
	    	
	    	
	    	$otpSessTime=date('d-m-Y H:i:s', strtotime('+15 minutes'));
	    	$this->session->set_userdata('sess_eotp',array('otp'=>$randamOTP,'validTime'=>$otpSessTime));	    	
	    	$valcaptcha=$this->captcha();
	    	echo json_encode(array('data'=>'success','error'=>$otpSessTime,'returntoken'=>$valcaptcha));
	    	
	    }
	    else echo json_encode(array('data'=>'','error'=>'Invalid request.'));

    }

   public function otp_verify() {
        $varyotpcaptcha=$this->session->userdata('varyotpcaptcha');
    
        $captchav=$this->input->post('captchav');
        
        $this->form_validation->set_rules('captchav','Please enter valid captcha.','trim|required|min_length[1]|max_length[10]');
	$this->form_validation->set_rules('post_otp','Please enter valid OPT.','trim|required|min_length[1]|max_length[10]|numeric');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>strip_tags(validation_errors())]); die;
        }
        
        
       
       

        if($this->input->post()) {
            if($varyotpcaptcha==$captchav){
                
                $msg='';
            		$entered_otp=$this->input->post('post_otp');
            		$otp_type=$this->input->post('otp_type');
        
            		$sess_array=$this->session->userdata('sess_eotp');
            		if($otp_type == 'mobileOtp')
            		$sess_array=$this->session->userdata('sess_motp');
            		

            		if($otp_type == 'emailOtp'){
            		    $sess_array=$this->session->userdata('sess_eotp');
            		    $this->session->set_userdata('enteremailotp',$entered_otp);
            		}
            		
            		$sess_otp=$sess_array['otp'];
            		$sess_time=$sess_array['validTime'];
            		
            		$getMotphas=$this->input->post('getMotphas');
            		
            		$token=hash('sha512',$sess_otp.'upddoc');
            		
            		if($getMotphas!=$token){
            		    $msg="OTP does not match, try with valid OTP";
            		}

            		if($otp_type == 'mobileOtp'){
            		    $sess_array=$this->session->userdata('sess_motp');
            		    $this->session->set_userdata('entermobileotp',$entered_otp);
            		}  
         
            		
            		if($sess_otp != $entered_otp) {
            			$msg="OTP does not match, try with valid OTP";
            		}
            		
            		if(strtotime($sess_time) < strtotime(date('d-m-Y H:i:s'))) {
            			$msg="OTP has been expired.";
            		}

            		if($msg == '') {
            		    $this->session->unset_userdata('varyotpcaptcha');
            		//	$this->session->sess_destroy();
            		    echo json_encode(array('data'=>'success','error'=>'0','token'=>$token));die;
            		}
            		else {
            		    echo json_encode(array('data'=>'','error'=>$msg,'token'=>$token));die;
            		}
            }else{
                $msg="Captcha not valid";
                echo json_encode(array('data'=>'','error'=>$msg,));
            }
    	}
    	else echo json_encode(array('data'=>'','error'=>'0','token'=>$token));
    }
   
    public function upload_idproof_doc($csrf=NULL) {
        error_reporting(0);
    	$token=hash('sha512',trim($_REQUEST['token']).'upddoc');
    	if($_FILES && $token==$csrf) {
    		$config=[
						['field'=>'reqdoctype', 'label'=>'Please select valid ID Proof Type','rules'=>'trim|max_length[10]|regex_match[/^[A-Za-z_]+$/]'],
						['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[200]|callback_mimeType|callback_double_dot|callback_isValidPDF']
					];

			$this->form_validation->set_rules($config);		
			if($this->form_validation->run()==FALSE) {			
			  	$returnData=['data'=>'','error' => strip_tags(validation_errors())];
			  	echo json_encode($returnData); exit(); 

			 } else {

			  $array=explode('.',$_FILES['userfile']['name']);
			  $config['upload_path']   		= UPLOADPATH.'/users_idproof/';
			  $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
			  $config['max_size']      		= '199999';
			  $config['overwrite']	   		= false;
			  $config['file_ext_tolower']	= TRUE;
		      $config['file_name']=$this->input->post('userMobile').'_'.$this->input->post('reqdoctype').'.'.strtolower(end($array));
			
		      $this->load->library('upload', $config);
			  if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
				  
			  		echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors())]);
			  else 	{
				  $uploadfile= $this->upload->data('file_name');
			  	$this->session->set_userdata('upld_doc_sess',['idproof_upd'=>UPLOADPATH.'/users_idproof/'.$uploadfile,'idp_dtype'=>$this->input->post('reqdoctype')]);
			  	echo json_encode(['data'=>'success','error' => '0','file_name'=>UPLOADPATH.'/users_idproof/'.$uploadfile]);
			  }
    		}
    	}
    }
	
	/*public function add_users() {		

		date_default_timezone_set('Asia/Calcutta');
		$post_array=$this->input->post();
		$uploded_doc_array=$this->session->userdata('upld_doc_sess');
		//print_r($post_array);

		if(!empty($post_array) && trim($uploded_doc_array['idp_dtype']) == trim($post_array['idoctype'])) { // for email : regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email|is_unique[registerd_users.email]

			$this->form_validation->set_rules('user_type', 'Choose valid user type', 'trim|required|alpha|max_length[20]');
			$this->form_validation->set_rules('enrolment_number', 'Enter valid enrolment number.', 'trim|regex_match[/^[a-zA-Z0-9\/\-_]+$/]|max_length[50]|is_unique[efiling_users.enrolment_number]');
			$this->form_validation->set_rules('org_name', 'Enter valid organization name', 'trim|regex_match[/^[a-zA-Z0-9\/\-_ ]+$/]|max_length[250]');
			$this->form_validation->set_rules('fname', 'Enter valid first name', 'trim|regex_match[/^[a-zA-Z0-9\/\-_ ]+$/]|max_length[150]');
			$this->form_validation->set_rules('lname', 'Enter valid last name', 'trim|regex_match[/^[a-zA-Z0-9\/\-_ ]+$/]|max_length[150]');
			$this->form_validation->set_rules('gender', 'Choose valid gender', 'trim|alpha|max_length[10]');
			$this->form_validation->set_rules('address', 'Enter valid address', 'trim|required|callback_validAddressCheck|max_length[1000]');
			$this->form_validation->set_rules('country', 'Choose valid Country', 'trim|required|alpha|max_length[255]');
			$this->form_validation->set_rules('state', 'Choose valid state name', 'trim|required|integer');
			$this->form_validation->set_rules('district', 'Choose valid district/city', 'trim|required|integer');
			$this->form_validation->set_rules('pincode', 'Enter valid pincode', 'trim|required|numeric|max_length[8]');			
			$this->form_validation->set_rules('loginid', 'Enter valid loginid', 'trim|required|regex_match[/^[a-zA-Z0-9\/\-_]+$/]|max_length[32]|is_unique[efiling_users.loginid]');			
			$this->form_validation->set_rules('mobilenumber', 'Enter valid mobile number', 'trim|required|numeric|exact_length[10]|is_unique[efiling_users.mobilenumber]');			
			$this->form_validation->set_rules('email', 'Enter valid email id', 'trim|required|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email|is_unique[efiling_users.email]');		
			$this->form_validation->set_rules('id_number', 'Enter valid document numbers', 'trim|required|regex_match[/^[a-zA-Z0-9\/\-_]+$/]|max_length[50]');		

			if($this->form_validation->run() == TRUE) {
				unset($post_array['idoctype']);
				$post_array['idptype']=trim($uploded_doc_array['idp_dtype']);
				$post_array['idproof_upd']='/asset/users_idproof/'.trim($uploded_doc_array['idproof_upd']);

				$retn=$this->admin_model->insert_newuser($post_array);
				if(strlen($retn) == 8) {
					$loginid=$this->input->post('loginid');
					$url='Hi, '.$loginid.' your password is : '.$retn;
			    	//$url='http://scourtapp.nic.in/emom_sms.php?mobile='.$this->input->post('mobilenumber').'&message='.urlencode($url);
			    	//$url='http://scourtapp.nic.in/emom_sms.php?mobile=7503569149&message='.urlencode($url);
			    	//$return =file_get_contents($url);	
					echo json_encode(['data'=>'success','error'=>'0']);
				}
				elseif($retn==false) 		echo json_encode(['data'=>'','error'=>$this->db->last_query()]);
				else 						echo json_encode(['data'=>'','error'=>$retn]);

			}else 		echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);

		}else  			echo json_encode(['data'=>'','error'=>'Invalid request.']);

	} */
	
	public function add_users() {	
//ini_set("display_errors",1);	
	//error_reporting(E_ALL);
		date_default_timezone_set('Asia/Calcutta');
		$post_array=$this->input->post();
		$uploded_doc_array=$this->session->userdata('upld_doc_sess');
		//print_r($post_array);
		$sess_arrayemail=$this->session->userdata('sess_eotp');// email otp validation
		$enterdemailotp=$this->session->userdata('enteremailotp');		
		$sess_arraymobile=$this->session->userdata('sess_motp');// mobile otp validation
		$enterdmobileotp=$this->session->userdata('entermobileotp');
		if($sess_arrayemail['otp'] != $enterdemailotp){
		    echo json_encode(['data'=>'','error'=>'Please Entered  Email otp not valid.']);die;
		}		
		if($sess_arraymobile['otp'] != $enterdmobileotp){
		    echo json_encode(['data'=>'','error'=>'Please Entered mobile otp not valid.']);die;
		}		
		//if(!empty($post_array)) { // for email : regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email|is_unique[registerd_users.email]
			$this->form_validation->set_rules('user_type', 'Choose valid user type', 'trim|required|alpha|max_length[20]');
			//$this->form_validation->set_rules('enrolment_number', 'Enter valid enrolment number.', 'trim|regex_match[/^[a-zA-Z0-9\/\-_]+$/]|max_length[50]|is_unique[efiling_users.enrolment_number]');
			$this->form_validation->set_rules('org_name', 'Enter valid organization name', 'trim|regex_match[/^[a-zA-Z0-9\/\-_ ]+$/]|max_length[250]');
			$this->form_validation->set_rules('fname', 'Enter valid first name', 'trim|regex_match[/^[a-zA-Z0-9\/\-._ ]+$/]|max_length[150]');
			$this->form_validation->set_rules('lname', 'Enter valid last name', 'trim|regex_match[/^[a-zA-Z0-9\/\-._ ]+$/]|max_length[150]');
			$this->form_validation->set_rules('gender', 'Choose valid gender', 'trim|alpha|max_length[10]');
			$this->form_validation->set_rules('address', 'Enter valid address', 'trim|required|max_length[1000]');
			$this->form_validation->set_rules('country', 'Choose valid Country', 'trim|required|alpha|max_length[255]');
			$this->form_validation->set_rules('state', 'Choose valid state name', 'trim|required|integer');
			$this->form_validation->set_rules('district', 'Choose valid district/city', 'trim|required|integer');
			$this->form_validation->set_rules('pincode', 'Enter valid pincode', 'trim|required|numeric|max_length[8]');			
			$this->form_validation->set_rules('loginid', 'Enter valid loginid', 'trim|required|regex_match[/^[a-zA-Z0-9\/\-_]+$/]|max_length[32]|is_unique[efiling_users.loginid]');			
			$this->form_validation->set_rules('mobilenumber', 'Enter valid mobile number', 'trim|required|numeric|exact_length[10]|is_unique_user_type[efiling_users.mobilenumber]');			
			$this->form_validation->set_rules('email', 'Enter valid email id', 'trim|required|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email|is_unique_user_type[efiling_users.email]');		
			//$this->form_validation->set_rules('id_number', 'Enter valid document numbers', 'trim|required|max_length[50]');		
			$salt=$post_array['skey_pass_new'];
			
			$session_key=$this->session->userdata('skey_session');
			$this->session->unset_userdata('skey_session');
			//if($salt == $session_key) {
    			if($this->form_validation->run() == TRUE) {
    			
					
					unset($post_array['idoctype']);
    				unset($post_array['skey_pass_new']);
    				unset($post_array['skey']);
    				unset($post_array['mobileOtpcaptcha']);
    				unset($post_array['emailOtpcaptcha']);
    				unset($post_array['idnumverval']);
    				
    				//$post_array['idptype']=trim($uploded_doc_array['idp_dtype']);
    				//$post_array['idproof_upd']='/asset/users_idproof/'.trim($uploded_doc_array['idproof_upd']);
    				$post_array['idptype']=' ';
    			    $post_array['idproof_upd']=' ';
    			    $post_array['id_number']='0000';
    				$retn=$this->admin_model->insert_newuser($post_array);
    				$email=$post_array['email'];
    				$data=$this->db->select('id')
    				->get_where('efiling_users',['email'=>$email])
    				->result();
    				$val=$data[0]->id;
    				if(strlen($retn) == 8) {
    					//=$this->input->post('loginid');
    				//	$url='Hi, '.$loginid.' your password is : '.$retn;
    			    	//$url='http://scourtapp.nic.in/emom_sms.php?mobile='.$this->input->post('mobilenumber').'&message='.urlencode($url);
    			    	//$url='http://scourtapp.nic.in/emom_sms.php?mobile=7503569149&message='.urlencode($url);
    			    	//$return =file_get_contents($url);	
    				    echo json_encode(['data'=>'success','error'=>'0','ins'=>base64_encode($val)]);
    				}
    				elseif($retn==false) 		echo json_encode(['data'=>'','error'=>$this->db->last_query()]);
    				else 						echo json_encode(['data'=>'','error'=>$retn]);
    			}else { 
    			    echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
    			}
			
			/*}else{
			    echo json_encode(['data'=>'','error'=>'Invalid request.']);
			}*/
		/*}else{
		    echo json_encode(['data'=>'','error'=>'Invalid request.']);
		}*/
	}
	
	function cryptoJsAesDecrypt($passphrase, $jsonString){
	    $jsondata = json_decode($jsonString, true);
	    $salt = hex2bin($jsondata["s"]);
	    $ct = base64_decode($jsondata["ct"]);
	    $iv  = hex2bin($jsondata["iv"]);
	    $concatedPassphrase = $passphrase.$salt;
	    $md5 = array();
	    $md5[0] = md5($concatedPassphrase, true);
	    $result = $md5[0];
	    for ($i = 1; $i < 3; $i++) {
	        $md5[$i] = md5($md5[$i - 1].$concatedPassphrase, true);
	        $result .= $md5[$i];
	    }
	    $key = substr($result, 0, 32);
	    $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
	    return json_decode($data, true);
	}
function decodePan($pancode)
{
	$ivBytes = hex2bin(IVVAL);
	$keyBytes = hex2bin(KEYVAL);
	$ctBytes = base64_decode($pancode);
	$decrypt = openssl_decrypt($ctBytes, "aes-256-cbc", $keyBytes, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $ivBytes);
	return strtoupper($decrypt);
}
	function regFormFinal($csrf=NULL){
		//ini_set('display_errors',1);
		//error_reporting(E_ALL);
	    date_default_timezone_set('Asia/Calcutta');
		$this->config->load('form_validation');
		
		$this->form_validation->set_rules('idoctype', 'id type', 'required');
		$this->form_validation->set_rules('idnumverval', 'id number', 'required');
		$this->form_validation->set_rules('token', 'token', 'required');
					if($this->form_validation->run() == false) {

						echo json_encode(['error'=>validation_errors()]);die;
					}
					
					
	    $post_array=$this->input->post();
	    $uploded_doc_array=$this->session->userdata('upld_doc_sess');
	    $token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	    $csrf=$_REQUEST['token_hash'];
	    //$id_number=base64_decode($_REQUEST['id_number']);
	    $idoctype=$_REQUEST['idoctype'];
		
		  $encrypted_string=$this->input->post('idnumverval');
	 
	    $encrypted = $encrypted_string;
	    $key = "123456";
	     $decrypted = $this->decodePan($encrypted);
		 if($decrypted==''){
			 echo json_encode(['error'=>'id number error']);die;
		 }
		
	    if($token==$csrf) {
    	    if(!empty($post_array) && trim($uploded_doc_array['idp_dtype']) == trim($post_array['idoctype'])) { // for email : regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email|is_unique[registerd_users.email]
    	       
			//$this->form_validation->set_data(['id_number'=>$id_number]);
				/*if($idoctype=='VOTER'):
					$this->form_validation->set_rules('id_number', 'id_number', 'trim|required|valid_voterID');
					if($this->form_validation->run() == false) {

						echo json_encode(['error'=>validation_errors()]);die;
					}
					endif;

				if($idoctype=='AADHAR'):
					$this->form_validation->set_rules('id_number', 'id_number', 'trim|required|valid_adhar');
					if($this->form_validation->run() == false) {

						echo json_encode(['error'=>validation_errors()]);die;
					}
					endif;

				if($idoctype=='PAN'):
					$this->form_validation->set_rules('id_number', 'id_number', 'trim|required|valid_pan');
					if($this->form_validation->run() == false) {

						echo json_encode(['error'=>validation_errors()]);die;
					}
					endif;*/


			   //$this->form_validation->set_rules('id_number', 'Enter valid document numbers', 'trim|required');
    	      //  if($this->form_validation->run() == TRUE) {
    	            unset($post_array['idoctype']);
    	            $post_array['idptype']=trim($uploded_doc_array['idp_dtype']);
    	            $post_array['idproof_upd']=trim($uploded_doc_array['idproof_upd']);
    	           // $post_array['id_number']=$id_number;
					$post_array['id_number']=$decrypted;
    	            $retn=$this->admin_model->update_newuser($post_array);
    	            if($retn==true) {
    	                $this->input->post('loginid');
    	              //  $url='Hi, '.$loginid.' your password is : '.'test123';
    	            //    $url='http://scourtapp.nic.in/emom_sms.php?mobile='.$this->input->post('mobilenumber').'&message='.urlencode($url);
    	             //   $url='http://scourtapp.nic.in/emom_sms.php?mobile=7503569149&message='.urlencode($url);
    	              //  $return =file_get_contents($url);
					  
					  
					  $lasid=base64_decode($post_array['id_reff']);
					$data = $this->db->select('mobilenumber')->get_where('efiling_users',['id'=>$lasid])->row_array();
					if($data['mobilenumber']!=''){
						
						$mm=  $data['mobilenumber'];
						//sendsms('Thanks for registering with CESTAT. You have been successfully registered with efiling portal of CESTAT website. Your Username is test123  and password as entered by you. You can access the efiling portal https://efiling.cestat.gov.in after activation of your account by the nodal officer/admin.CESTAT',$mm,'1407168439454691256');
					sendsms('Thanks for registering with CESTAT. You have been successfully registered with efiling portal of CESTAT website. Your Username is as entered by you and password is test123. You can access the efiling portal https://efiling.cestat.gov.in after activation of your account by the nodal officer/admin.CESTAT',$mm,'1407168561895600891');
					}
					  
					  
    	                echo json_encode(['data'=>'success','error'=>'0']);
    	            }
    	            elseif($retn==false) 		echo json_encode(['data'=>'','error'=>'db error']);
    	            else 						echo json_encode(['data'=>'','error'=>$retn]);
    	            
    	       // }else 		echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
    	        
    	    }else{
    	        echo json_encode(['data'=>'','error'=>'Invalid request.']);
    	    }
	    }else{
	        echo json_encode(['data'=>'','error'=>'Invalid request.']);
	    }
	}
	
	

	public function user_dashboard() {
		if(@$this->session->userdata('login_success')[0]->role == '1'){
			return redirect(base_url('loginSuccess/admin'), 'refresh');
		}else {
			$data['slide_bar']=$this->load->view('admin/sidebar','',true);
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard',$data);
			$this->load->view('admin/footer');
		}
	}

	public function admin_dashboard($level=NULL) {
		
		if($level=='admin' && trim($this->session->userdata('login_success')[0]->role) == '1') {
			if($this->_verify_session('admin')) {
				$data['slide_bar']=$this->load->view('admin/sidebar','',true);
				$this->load->view('admin/header');
				$this->load->view('admin/dashboard',$data);
				$this->load->view('admin/footer');
			}
		}else $this->kill_sess();
	}

	public function load_page_jquery($page_name=NULL) {
		if($this->session->userdata('login_success')) {
			if($page_name=='check_list' || $page_name==NULL) $page_name='checkList_first';
			//if($page_name==NULL) $page_name='basic_details';
			$this->load->view('admin/'.$page_name);
		}
		else $this->kill_sess();
	}

	public function fetch_existing_data(){
	    if($this->session->userdata('login_success') && $this->input->post()) {
	        switch($this->input->post("table_name")){
	            case 'add_petitioner' : echo $this->admin_model->get_add_petitioner(); break;
	            case 'add_respondent' : echo $this->admin_model->get_add_respondent(); break;
	            case 'caveat_filing'  : echo $this->admin_model->get_caveat_filing(); break;
	            case 'master_advocate' : echo json_encode($this->admin_model->get_master_advocate($this->input->post())); break;
	        }
	    }
	    else $this->kill_sess();
	}
	
	public function insert_upd_master_paper() {
	    if($this->input->post() && $this->session->userdata('login_success')) {
	        $rs=$this->admin_model->insert_ma_ia_vakalatnama_mpapers($this->input->post());
	        if($rs=='success'){
	            $this->session->unset_userdata('upd_file_sess');
	            echo json_encode(['data'=>'success','error'=>'0']);
	        }
	        else echo json_encode(['data'=>'','error'=>$rs]);
	        exit();
	    }
	    else $this->kill_sess();
	}

	


	public function upload_required_documents($csrf) {
		$post_array=$this->input->post();
		$ses_csrf=hash('SHA512',$post_array['token'].'upddoc');
		if($this->_verify_session() && $post_array && $ses_csrf==$csrf) {
		  	
		  	
            $this->form_validation->set_rules('choose_file', '', 'callback_pdf_check');
			if($this->form_validation->run() == FALSE) {
				echo json_encode(['return_type'=>'','error'=>strip_tags(validation_errors())]); exit(); 
			}
			$config['upload_path']   = './applicant_required_docs/';
			$config['allowed_types'] = 'pdf';
			$config['max_size']      = '1999990';
			$config['overwrite']	 = false;
			$config['file_name']	 = $post_array['mobile'].'_'.$post_array['reqdoctype'].'.pdf';

			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('choose_file') && $this->upload->data('file_name')) {
				$returnData['profile']=['return_type'=>'','error' => strip_tags($this->upload->display_errors())];
				exit();
			}
			else { echo json_encode(['return_type'=>'success','error'=>'']); exit(); }
		}
		else { echo json_encode(['return_type'=>'','error'=>'Permision denay!']); exit(); }
	}

    public function checkDateFormat($date) {
       if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date) ) {
          list($year , $month , $day) = explode('-',$date);
          return checkdate($month , $day , $year);
       } else {
          return false;
       }
    }

    public function validAddressCheck($address) {
	    if (preg_match('/^[a-zA-Z0-9 \/.&,-]+$/',$address) || empty($address)){
	         return TRUE;
	    } else {
	         $this->form_validation->set_message('validAddressCheck', 'Only Address Allowed space, comma, dot, dash, numbers and alphabets.'); return FALSE;
	    }
	}

	public function numeric_dash ($num) {
    	return ( ! preg_match("/^([0-9-\s])+$/D", $num)) ? FALSE : TRUE;
  	}

    private function _make_logfile_true($user_id,$login_dttm) {

            $logdata='';
            if(!filesize($this->log_file_name)) {
                $logdata='Date & Time         | User IP    | Status    | Stm | User Id '.";\r\n";
            }   $logdata.=$login_dttm.' | '.$this->input->ip_address().' | Success   | 000 |'.$user_id.";\r\n";

            if(!write_file($this->log_file_name, $logdata, 'a'))
                 return false;
            else return true;

    }

    private function _make_logfile_false($user_id=NULL, $login_dttm=NULL) {
        
            $logdata='';
            $login_dttm=date('d-m-Y H:i:s');
            if(!filesize($this->log_file_name)) {
                $logdata='Date & Time         | User IP    | Status    | Stm | User Id '.";\r\n";
            }   $logdata.=$login_dttm.' | '.$this->input->ip_address().' | Unsuccess | 000 |'.$user_id.";\r\n";

            if(!write_file($this->log_file_name, $logdata, 'a'))
                 return false;
            else return true;

    }

	public function check_duplicate(){
		   $vpost_array=$this->input->post();
		   $email=strtolower(@$vpost_array['email1']);

			if($email) {
				unset($vpost_array['email1']);
				$remove = array("(" => "", ")" => "", "select" => "", "sleep"=> "");
				$email_new =strtr($email, $remove);
				$vpost_array=['email1' => $email_new];
				if($email != $email_new) { echo 'error'; die; }
			}

		$this->form_validation->set_rules('email1', 'Enter valid email id', 'trim|max_length[50]|regex_match[/^[A-Z0-9a-z._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,6}$/]');
		$this->form_validation->set_rules('phoneM', 'Enter valid Mobile No.', 'trim|numeric|min_length[10]|max_length[10]');
		$this->form_validation->set_rules('user_id', 'Enter valid user id', 'trim|alpha_numeric|min_length[8]');

		if ($this->form_validation->run() == TRUE) {
		   $rs=$this->db->get_where('usertbl',$vpost_array);
           if($rs->num_rows() == 1) echo'failed';
           else echo'success';
       }else echo 'error'; 
	}


	public function restore_password(){
		//ini_set('display_errors',1);
		//error_reporting(E_ALL);
		//$this->form_validation->set_rules('loginid', '', 'trim|required');
		//$this->form_validation->set_rules('email', '', 'trim|required|valid_email');
			//$this->form_validation->set_rules('skey_pass', 'captcha.', 'trim|required');
			
			if($this->form_validation->run('forgaetpass') == FALSE)
				{
					
					$rtn_data=['data'=>'validation-error','error'=>validation_errors()];
		
			echo json_encode($rtn_data); die;
					
			}
		$post_array=$this->input->post();
		$salt=$post_array['skey_pass'];
		$data['captcha_data']=$this->captcha_data;
		$session_key=$this->session->userdata('skey_session');
		$this->session->unset_userdata('skey_session');
		$this->session->set_userdata('skey_session',$data['captcha_data']['word']);
		if($salt!==$session_key) {
			$rtn_data=['data'=>'Token error','error'=>'Please Enter Valid captacha !'];
			echo json_encode($rtn_data);die;
		}
		
		$loginid=$post_array['loginid'];
        $email=$post_array['email'];
        $rs=$this->db->select('mobilenumber')
        ->get_where('efiling_users',['email'=>$email,'loginid'=>$loginid]);
		
		if($rs->num_rows()==0){
			 $rtn_data=['error'=>'Either user ID /Email-Address in not correct !'];
			 echo json_encode($rtn_data);die;
		}
        
		
				$updpass=$this->admin_model->forgot_pass($post_array);
				switch($updpass){
					case 'db-error'	: $rtn_data=['data'=>$updpass,'error'=>'Error in update query.']; 	break;
					case 'not-found': $rtn_data=['data'=>$updpass,'error'=>'Kindly provide valid details.'];	break;
					default:
							//****** Send mail here ************//
							/*$from_email = "donotreply@nic.in"; 
					        $to_email = $post_array['Email1'];    
					        $this->email->from($from_email, 'RES Support'); 
					        $this->email->to($to_email);
					        //$this->email->cc('singhpooja@nic.in');
					        $this->email->subject('Forgot/Recover Password'); 
					        $this->email->message('Dear User'."\r\n".'Your temporary password generated is : '.$updpass."\r\n".'You are advised to change the password after first login for security reasons.'."\r\n".'This is auto-generated e-mail from ices.nic.in. Kindly do not  reply.'."\r\n\r\n".'Thanks/ Regards,'."\r\n".'RES support team'); 
					         if($this->email->send()) echo'success'; 
					         else echo'error-send';*/
					        $npwd=$updpass["new_password"];
					        $umobile=$updpass["user_mobile"];
					        $url='Hi, '.$post_array['loginid'].' your password has been recoverd, kindly login with this password : '.$npwd.' , PLEASE DO NOT SHARE THIS WITH ANYONE - APTEL e-filing division (NIC)';
	    					$url='http://scourtapp.nic.in/emom_sms.php?mobile='.$umobile.'&message='.urlencode($url);
	    					//$return =file_get_contents($url);
							
							
							 sendsms('This is system generated SMS alert from CESTAT.Your new password is '.$npwd.'. You can access the e filing portal of CESTAT with username and password.CESTAT',$umobile,'1407168439487382291');
							
					        $rtn_data=['data'=>'success','error'=>'0','password'=>$npwd];
					break;
				}
			echo json_encode($rtn_data);
	}

	private function _verify_session($utype=NULL) {
         	if($this->session->userdata('login_success')==''){
        		$this->session->sess_destroy();            	
        		return redirect(base_url(), 'refresh');
        		exit();
        	}else if($this->session->userdata('login_success')){
           		 return true;
       		 }else {               	
		     $this->session->sess_destroy();            	
		     return redirect(base_url(), 'refresh');
		     exit();
		}
	}

	public function kill_sess() {
		$this->session->sess_destroy();            	
    		return redirect(base_url(), 'refresh');
    		exit();
	}

	public function pdf_check($str) {

		$allowed_mime_type_arr = array('application/pdf');
        $mime = get_mime_by_extension($_FILES['choose_file']['name']);

        if($_FILES['choose_file']['name'] !='') {
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('pdf_check', 'Please select only pdf file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('pdf_check', 'Please choose a file to upload.'.$_FILES['choose_file']['name']);
            return false;
        }
	}

	public function captch_refresh() { /***** Captcha Refresh **** */
	
		$data['captcha_data']=$this->captcha_data;			
		$this->session->unset_userdata('skey_session');
		$this->session->set_userdata('skey_session',$data['captcha_data']['word']);
		echo $data['captcha_data']['image'];

		exit();
	}

	

	public function alphanum_underscore ($num) {
    	return ( ! preg_match("/^([a-zA-Z0-9_\s])+$/D", $num)) ? FALSE : TRUE;
  	}


  	function caveat(){
  	    $data['captcha_data']=$this->captcha_data;
  	    $this->session->unset_userdata('skey_session');
  	    $this->session->set_userdata('skey_session',$data['captcha_data']['word']);
  	    $this->load->view('admin/caveat_filing',$data);
  	}
	//********* Check file mime type ***********//
    public function mimeType($str) { 
        
        $allowed_mime_type_arr = array('image/jpeg','image/gif','image/png','application/pdf');
        $mime = get_mime_by_extension($_FILES['userfile']['name']);
        if(isset($_FILES['userfile']['name']) && $_FILES['userfile']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('mimeType', 'Accept only pdf,jpg,gif and png file are allowed.');
                return false;
            }
        }else{
            return true;
        }
	}

	
	public function verify_filing_no() {
	    if($this->input->post()) {
	        $retn=$this->admin_model->verify_filingno($this->input->post());
	        echo json_encode(['data'=>$retn,'error'=>'0']);
	    }
	    else echo json_encode(['data'=>'','error'=>'Invalid request.']);
	    exit();
	}
	
	public function dupd_get_addvparty(){
	    if($this->input->post()) {
	        $data_array=$this->admin_model->fetch_addvparty($this->input->post());
	        if($data_array==false) 	echo json_encode(['data'=>'','error'=>'Additional party not exists.']);
	        else  					echo json_encode(['data'=>$data_array,'error'=>'0']);
	        
	        exit();
	    }
	    else $this->kill_sess();
	}
	
	
	public function mster_paper_upload($csrf=NULL){
	    $post_array=$this->input->post();
	    //print_r($post_array); print_r($_FILES); die;
	    $ses_csrf=hash('SHA512',$post_array['token'].'upddoc');
	    if($this->_verify_session() && $post_array && $ses_csrf==$csrf) {
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        
	        $this->form_validation->set_rules('choose_file', '', 'callback_pdf_check');
	        $this->form_validation->set_rules('reqdoctype', 'Kindly select valid master page', 'trim|required|regex_match[/^[a-zA-Z0-9 ]+$/]|max_length[20]');
	        $this->form_validation->set_rules('filing_no', 'Enter valid diary_no', 'trim|required|numeric|max_length[6]');
	        $this->form_validation->set_rules('filing_year', 'Kindly select valid diary year', 'trim|required|numeric|exact_length[4]');
	        $this->form_validation->set_rules('user_type', 'Kindly select valid user type', 'trim|required|numeric|exact_length[1]');
	        
	        if($this->form_validation->run() == FALSE) {
	            echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]); exit();
	        }
	        $config['upload_path']   = './asset/master_papers/';
	        $config['allowed_types'] = 'pdf';
	        $config['max_size']      = '1999990';
	        $config['overwrite']	 = TRUE;
	        $config['file_name']	 = $post_array['user_type'].'_'.$post_array['filing_no'].$post_array['filing_year'].'_'.str_replace(' ', '_', $post_array['reqdoctype']).'_'.date('dmY').'.pdf';
	        
	        $this->load->library('upload', $config);
	        if(!$this->upload->do_upload('choose_file') && $this->upload->data('file_name')) {
	            echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors())]);
	            exit();
	        }
	        else {
	            $upd_data_array=[
	                'file_name'=>$config['file_name'],
	                'filing_no'=>$post_array['filing_no'].$post_array['filing_year'],
	                'user_type'=>$post_array['user_type'],
	                'doc_type'=>$post_array['reqdoctype']
	            ];
	            
	            if(!$this->session->userdata('upd_file_sess')){
	                $this->session->set_userdata('upd_file_sess',$upd_data_array);
	             
	            }else {
	                $data=array(
	                    'salt'=>$_REQUEST['salt'],
	                    'file_name'=>$config['file_name'],
	                    'filing_no'=>$post_array['filing_no'].$post_array['filing_year'],
	                    'user_type'=>$post_array['user_type'],
	                    'doc_type'=>$post_array['reqdoctype'],
	                    'case_type'=>'DOC',
	                    'user_id'=>$user_id,
	                );
	                $st=$this->efiling_model->insert_query('rpepcp_reffrence_table',$data);
	                    $last_session_array=$this->session->userdata('upd_file_sess');
	                    $this->session->unset_userdata('upd_file_sess');
	                    $final_array=array_merge_recursive($last_session_array,$upd_data_array);
	                    $this->session->set_userdata('upd_file_sess',$final_array);
	                }
	                echo json_encode(['data'=>'success','error'=>'0']); exit();
	        }
	    }
	    else { echo json_encode(['data'=>'','error'=>'Permision denay!']); exit(); }
	}
	
	public function add_commission() {
	    if($this->input->post() && $this->session->userdata('login_success')) {
	        echo $this->admin_model->insert_commission($this->input->post());
	    }else return redirect(base_url('close'), 'refresh');
	}
	
	public function insert_caveat(){
	    $post_array=$this->input->post();
	    if($post_array && $this->session->userdata('login_success')) {
	        //echo'</pre>'; print_r($this->session->userdata('caveat_salt')); die;
	        
	        if(@(int)$post_array['fee_amount'] > 0 && @(int)$post_array['payment_mode'] > 0 && $this->session->userdata('caveat_salt')) {
	            $this->form_validation->set_rules('fee_amount', 'Enter valid total amount', 'trim|required|numeric|max_length[5]');
	            $this->form_validation->set_rules('payment_mode', 'Choose valid payment mode', 'trim|required|numeric|exact_length[1]');
	            $this->form_validation->set_rules('dd_no', 'Enter valid dd_no.', 'trim|numeric|max_length[20]');
	            $this->form_validation->set_rules('ia_fee', 'Enter valid amount.', 'trim|required|numeric|max_length[10]');
	         //   $this->form_validation->set_rules('dd_date', 'Choose valid date', 'trim|required|callback_checkDateFormat|exact_length[10]');
	            $this->form_validation->set_rules('branch_name', 'Enter valid branch name', 'trim|required|callback_validAddressCheck|max_length[200]');
	            
	            if($this->form_validation->run() == TRUE) {
	                $rs=$this->admin_model->insert_caveat_final($post_array);
	                if($rs!=false) 	echo json_encode(['data'=>'success','error'=>'0','ia_number'=>$rs]);
	                else 			echo json_encode(['data'=>'','error'=>'Error in line no. '.__LINE__,'ia_number'=>'0']);
	            }
	            else echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        }
	        
	        else if($this->session->userdata('skey_session')==$post_array['salt']) {
	          //  $this->form_validation->set_rules('commission', 'Choose valid commission', 'trim|required|numeric|max_length[20]');
	           // $this->form_validation->set_rules('nature_of_order', 'Choose valid case type', 'trim|required|numeric|max_length[20]');
	           // $this->form_validation->set_rules('case_no', 'Enter valid case no.', 'trim|required|numeric|max_length[20]');
	          //  $this->form_validation->set_rules('case_year', 'Enter valid case year', 'trim|required|numeric|exact_length[4]');
	         //   $this->form_validation->set_rules('decision_date', 'Choose valid decision date', 'trim|required|callback_checkDateFormat|exact_length[10]');
	          //  $this->form_validation->set_rules('organization', 'Choose valid organization', 'trim|required|numeric|max_length[20]');
	           // $this->form_validation->set_rules('caveat_name', 'Enter valid caveat name', 'trim|required|callback_validAddressCheck|max_length[200]');
	           // $this->form_validation->set_rules('council_name', 'Choose valid council name', 'trim|numeric|max_length[20]');
	           // $this->form_validation->set_rules('prayer', 'Enter valid prayer', 'trim|callback_validAddressCheck|max_length[200]');
	           // $this->form_validation->set_rules('mobile_no', 'Enter valid mobile no.', 'trim|regex_match[/^[0-9]+$/]|exact_length[10]');
	           // $this->form_validation->set_rules('council_mobile', 'Enter valid council mobile no', 'trim|regex_match[/^[0-9 ]+$/]|exact_length[10]');
	            
	           // $this->form_validation->set_rules('caveat_phone', 'Enter valid caveat phone', 'trim|regex_match[/^[0-9 ]+$/]|max_length[20]');
	          //  $this->form_validation->set_rules('council_phone', 'Enter valid counsel phone', 'trim|regex_match[/^[0-9 ]+$/]|max_length[20]');
	           // $this->form_validation->set_rules('commission', 'Choose valid commission', 'trim|required|numeric|max_length[20]');
	           // $this->form_validation->set_rules('caveat_state', 'Choose valid caveat state', 'trim|required|numeric|max_length[20]');
	           // $this->form_validation->set_rules('caveat_district', 'Choose valid caveat district', 'trim|required|numeric|max_length[20]');
	           // $this->form_validation->set_rules('caveat_pin', 'Enter valid caveat pin', 'trim|numeric|exact_length[6]');
	           // $this->form_validation->set_rules('caveat_email', 'Enter valid caveat email', 'trim|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email');
	            $this->form_validation->set_rules('council_email', 'Enter valid council_email', 'trim|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email');
	          //  $this->form_validation->set_rules('caveat_address', 'Enter valid caveat address', 'trim|required|callback_validAddressCheck|max_length[1000]');
	          //  $this->form_validation->set_rules('council_address', 'Enter valid counsel address', 'trim|callback_validAddressCheck|max_length[1000]');
	            
	            if($this->form_validation->run() == TRUE) {
	                $rs=$this->admin_model->insert_caveat($post_array);
	                if($rs==true) echo json_encode(['data'=>'success','error'=>'0','ia_number'=>'0']);
	                else echo json_encode(['data'=>'','error'=>'Error in create caveat,so try later.','ia_number'=>'0']);
	            }
	            else echo json_encode(['data'=>'','error'=>strip_tags(validation_errors()),'ia_number'=>'0']);
	        }
	        else echo json_encode(['data'=>'','error'=>'Enterd captcha does not match','ia_number'=>'0']);
	    }
	    else $this->kill_sess();
	}
	
	
	function add_advocate(){
	    $this->form_validation->set_rules('adv_name', 'Please Enter Advocate name ', 'required');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('adv_reg', 'Please Enter Advocate Registraction number ', 'trim|required|max_length[20]');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('address', 'Please Enter Address ', 'required');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('adv_mobile','Please Enter Advocate mobile ', 'trim|required|numeric|max_length[10]');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('email','Please Enter Email ','trim|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$/]|valid_email');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('adv_sex', 'Please Enter sex ', 'required');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('adv_phone', 'Please Enter phone number  ','trim|required|numeric|max_length[10]');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('adv_fax', 'Please Enter Advocate Fax ','trim|required|numeric|max_length[10]');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('adv_reg_year','Please Enter year','trim|required|numeric|max_length[4]');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    $this->form_validation->set_rules('adv_pin','Please Enter Pin code','trim|required|numeric|max_length[6]');
	    if($this->form_validation->run() == false) {
	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        return false;
	    }
	    if($this->form_validation->run() == True) {
	    $data= (object)$_REQUEST;
	    $msg='';
	        $adv_phone = $data->adv_phone;
	        if($data->adv_phone ==''){
	            $adv_phone = '0';
	        }
	        $adv_fax = $data->adv_fax;
	        if($data->adv_fax ==''){
	            $adv_fax = '0';
	        }
	        $state = isset($data->state_id)?$data->state_id:'';
	        $district =isset($data->district_id)?$data->district_id:''; 
	        $query_params = array(
	            'adv_name' =>$data->adv_name,
	            'adv_reg' =>$data->adv_reg ,
	            'address' => $data->address,
	            'adv_mobile' =>$data->adv_mobile,
	            'email' =>$data->email,
	            'adv_sex' =>$data->adv_sex,
	            'adv_phone' =>$adv_phone,
	            'adv_fax' => $adv_fax,
	            'display' =>'1',
	            'state_code' => '12',
	            'adv_reg_year'=>$data->adv_reg_year,
	            'adv_pin'=>$data->adv_pin,
	            'adv_dist'=>'12',
	            'status'=>'0'
	        );
	        $st=$this->efiling_model->insert_query('master_advocate',$query_params);
	        $msg="Successfully Added Advocate ";
	        echo json_encode(['data'=>'success','massage'=>$msg,'error'=>'0']);
	    }else{
	      echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	    }
	}
	
	
	public function getAdvSelect(){
		
	    $key=$this->input->post();
	    $rs=$this->admin_model->getadvRecord($this->input->post());
	    $html='';
	    foreach($rs as $vals){
	        $html.='<li value="'.$vals->adv_code.'" onclick="serchrecord('.$vals->adv_code.')">'.$vals->adv_name.' ('.$vals->adv_reg.') &nbsp;/ '.$vals->adv_mobile.'</li>';
	    }
	    echo $html;die;
		
	}
	public function delete_session_user_id($id)
    {
       
    $this->db->where('user_id', $id)->delete('ci3_sessions');
           
    }
	public function audittrail()
	{
		
		if($this->session->userdata('login_success')[0]->role!=1){
			return redirect(base_url('loginSuccess'), 'refresh');
		}

		$this->load->view('admin/audittrail');
	}
	
	 // varyotpcaptcha
    function captcha (){
        $config = array(
            'img_path'      => 'asset/captcha_images/',
            'img_url'       => base_url().'asset/captcha_images/',
            'font_path'     => FCPATH.'asset/fonts/texb.ttf',
            'img_width'     => 80,
            'img_height'    => 37,
            'word_length'   => 6,
            'font_size'     => 18,
            'pool'          => '0123456789',
            'captcha_case_sensitive' => TRUE,
            'colors' => array(
                'background' => array(79, 255, 255),
                'border' => array(79, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(79, 255, 255)
            )
        );
        $captcha = create_captcha($config);
        $data= $this->captcha_data;
        $this->session->set_userdata('varyotpcaptcha',$data['word']);		
        return  $data;
    }

  // varyotpcaptcha
    function captchawwww (){
        $config = array(
            'img_path'      => 'asset/captcha_images/',
            'img_url'       => base_url().'asset/captcha_images/',
            'font_path'     => FCPATH.'asset/fonts/texb.ttf',
            'img_width'     => 80,
            'img_height'    => 37,
            'word_length'   => 6,
            'font_size'     => 18,
            'pool'          => '0123456789',
            'captcha_case_sensitive' => TRUE,
            'colors' => array(
                'background' => array(79, 255, 255),
                'border' => array(79, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(79, 255, 255)
            )
        );
        $captcha = create_captcha($config);
        $data= $this->captcha_data;
        $this->session->set_userdata('varyotpcaptcha',$data['word']);
       echo $data['image'];die;
    }
	
	public function double_dot(){


		$str= $_FILES['userfile']['name'];
		$fileData =explode('.',$str);
		if(count($fileData)>2){
			$this->form_validation->set_message('double_dot', 'More than one dot (.) not allowed in uploding file!');
			return false;
		}
		return true;
	}
	public function isValidPDF()
	{
		$this->form_validation->set_message('isValidPDF', 'Not a valid file!');
        // Grab the file name off the top of the $params
        // after we split it.
       /* $params = explode(',', $params);
        $name   = array_shift($params);
        $request = service('request');
        if (! ($files = $request->getFileMultiple($name))) {
            $files = [$request->getFile($name)];
        }*/
		$file= $_FILES['userfile']['tmp_name'];
        //foreach ($files as $file) {
            if ($file === null) {
                return false;
            }
            //if ( !file_exists( $file ) ) return false;

            if ( $f = fopen($file, 'rb') )
            {
                $header1 = fread($f, 3);
                fclose($f);
                // Signature = PDF
                $check1 = strncmp($header1, "\x50\x44\x46", 3)==0 && strlen ($header1)==3;
            }

            if ( $f = fopen($file, 'rb') )
            {
                $header2 = fread($f, 4);
                fclose($f);
                // Signature = %PDF
                $check2 = strncmp($header2, "\x25\x50\x44\x46", 4)==0 && strlen ($header2)==4;
            }

            return ($check1 || $check2) ? true : false;
        //}

        return true;
    }

	
}

?>
