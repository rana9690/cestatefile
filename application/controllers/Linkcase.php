<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Linkcase extends MY_Controller {
	public function __construct(){
	        parent::__construct();
	        $this->load->model('Admin_model','admin_model');
	        $this->load->model('Efiling_model','efiling_model');
	}
	public function suggestedCases(){
		//echo '<pre>';
		//print_r($_SESSION);die;
		$appparams=[
			'length(cd.case_no)'=>15,
			'cd.res_mobile'=>$this->userData[0]->mobilenumber,
			'cd.res_email'=>$this->userData[0]->email,
			"cd.filing_no not in (select mp.map_filing_no as filing_no from case_detail_maping as mp where mp.map_user_id=$this->user_id)"=>null,
		];
		$data['filedcase']= $this->efiling_model->getAppFiledList($appparams);
		//echo $this->db->last_query();die;
		$data['caseTypeShort']= getCaseTypesArray([],'short_name');
		$data['caseTypeFull']= getCaseTypesArray([],'case_type_name');
		$this->load->view("suggested/suggestedCaseList",$data);
	}
	public function getOne()
	{
		$response = array();
		$this->form_validation->set_rules('filing_no', 'filing No', 'required|numeric|min_length[16]|max_length[16]');
		$this->form_validation->set_rules('type', 'type', 'required|alpha|in_list[app,appl]');
		if($this->form_validation->run() == false) {
			$response['messages'] = strip_tags(validation_errors());//Show Error in Input Form
			$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			echo json_encode($response);die;
		}
		$filing_no = $this->input->Post('filing_no');
		$type = $this->input->Post('type');

		$schemaData=getSingleSchemas($filing_no);
		$schemas=$schemaData['schema_name'];

		switch($type):
			case 'appl':
				$query= $this->db->select('filing_no,appfiling_no')->get_where($schemas.'.app_detail',['appfiling_no'=>$filing_no,'user_id'=>$this->user_id]);
				if($query->num_rows()>0):
					$response= $query->row_array();
					$params =['appfiling_no'=>$filing_no,'fees_type'=>1];
					$response['dtls']=$this->getFeeDetails($schemas,$params);
				else:
					$response['messages'] ='something went wrong !';
				endif;
				break;
			case 'app':
				$query = $this->db->select('filing_no')->get_where($schemas.'.case_detail',['filing_no'=>$filing_no]);
				if($query->num_rows()>0):
					$response= $query->row_array();
					$params =['filing_no'=>$filing_no,'fees_type'=>1,'user_id'=>$this->user_id];
					$response['dtls']=[];
				else:
					$response['messages'] ='something went wrong !';
				endif;
				break;
			default:
		endswitch;
		$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
		echo json_encode($response);

	}
	public function validateCode()
	{
		$response = array();
		$this->form_validation->set_rules([
			['field' => 'securitycode','rules' => 'required|numeric|min_length[4]|max_length[6]'],
			['field' => 'filing_no', 'label' => 'Filing no', 'rules' => 'required|min_length[16]|max_length[16]'],
			['field' => 'type', 'label' => 'Type', 'rules' => 'required|alpha|in_list[app,appl]'],
		]);

		if($this->form_validation->run()== FALSE) {
			$response['success'] = false;
			$response['messages'] = strip_tags(validation_errors());//Show Error in Input Form
			$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			echo json_encode($response);die;
		}

		$filing_no = $this->input->Post('filing_no');
		$type = $this->input->Post('type');

		if($type=='appl'):
			$this->form_validation->set_rules('appfiling_no', 'App Filing no', 'required|min_length[16]|max_length[16]');
			if($this->form_validation->run() == false):
				$response['success'] = false;
				$response['messages'] = strip_tags(validation_errors());//Show Error in Input Form
				$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
				echo json_encode($response);die;
			endif;
		endif;

		switch($type):
			case 'appl':
				$fields['appfiling_no'] = $this->input->Post('appfiling_no');
				$fields['filing_no'] = $this->input->Post('filing_no');
				break;
			case 'app':
				$fields['filing_no'] = $this->input->Post('filing_no');
				break;
			default:
		endswitch;

		$fields['mobile'] = $this->userData[0]->mobilenumber;
		$fields['email'] = $this->userData[0]->email;
		$fields['token'] = $this->input->post('securitycode');

		//$schemaData=getSingleSchemas($filing_no);
		//$schemas=$schemaData['schema_name'];

		//check wheather token blocked using rate limit


		$throttles = $this->db->select('count(*) as numrows')->where(['type'=>$fields['filing_no'],'user_id'=>$this->user_id])->get('throttles_tokenlinkedcase')->row_array();
		$attempts=5;
		if($throttles['numrows'] >$attempts){
			$response['success'] = false;
			$response['messages'] ='Too many attempts token has blocked !';
			$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			echo json_encode($response);
			die;
		}
		//rate limit insert for token
		$this->db->insert('throttles_tokenlinkedcase',['type'=>$fields['filing_no'],'user_id'=>$this->user_id,'ip'=>$this->input->ip_address()]);
		//check wheather token is releated that user
		$sth = $this->db->order_by('time desc')->limit(1)->get_where('token_linkedcase',['token'=>$fields['token']]);
		if($sth->num_rows()==0){
			$response['success'] = false;
			$response['messages'] ='Invalid Token! please use valid token '; //lang("App.insert-error") ;
			$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			echo json_encode($response);
			die;
		}


		$tokendata=$sth->row_array();
		if($tokendata['deleted_at']!='')
		{
			$response['success'] = false;
			$response['messages'] ='Token allready used'; //lang("App.insert-error") ;
			$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
			echo json_encode($response);
			die;
		}

		//map this user to that case

		$this->db->insert('case_detail_maping',['map_filing_no'=>$fields['filing_no'],'map_user_id'=>$this->user_id]);
		//update token
		$this->db->where(['time'=>$tokendata['time'],'token'=>$tokendata['token']])
			->update('token_linkedcase',['deleted_at'=>date('Y-m-d h:i:s')]);
		$this->db->where(['type'=>$fields['filing_no'],'user_id'=>$this->user_id])->delete('throttles_tokenlinkedcase');

		$response['success'] = true;
		$response['messages'] = 'Case added successfully';//lang("App.insert-success") ;
		$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
		echo json_encode($response);
	}
	    



	
	

}