<?php
class Feedetail extends CI_Controller
{
	
    protected $feedetailModel;
    protected $validation;
    protected $user_id;

	public function __construct()
	{
		//ini_set('display_errors',1);
		//error_reporting(E_ALL);
		parent::__construct();
		$this->user_id=$this->session->userdata('user_id');
		$this->userData = $this->session->userdata('login_success');
		$this->user_id=$this->userData[0]->id;
		
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
	
	public function index()
	{

	    $data = [
                'controller'    	=> 'feedetail',
                'title'     		=> 'fee_detail'				
			];
		
		return view('\Modules\Masters\Views\feedetail', $data);
			
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
					 $params =['appfiling_no'=>$filing_no,'fees_type'=>1,'user_id'=>$this->user_id];
					 $response['dtls']=$this->getFeeDetails($schemas,$params);
				 else:
					 $response['messages'] ='something went wrong !';
				 endif;
				 break;
			 case 'app':
				 $query = $this->db->select('filing_no')->get_where($schemas.'.case_detail',['filing_no'=>$filing_no,'user_id'=>$this->user_id]);
					  if($query->num_rows()>0):
						  $response= $query->row_array();
						  $params =['filing_no'=>$filing_no,'fees_type'=>1,'user_id'=>$this->user_id];
						  $response['dtls']=$this->getFeeDetails($schemas,$params);
						  else:
							  $response['messages'] ='something went wrong !';
						  endif;
				 break;
			 default:
		 endswitch;
		$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
		echo json_encode($response);

	}
	public function getFeeDetails($schemas,$params)
	{
		return $this->db->select('amount,dd_date,dd_no')->get_where($schemas.'.fee_detail',$params)
			->result_array();
	}

	public function add()
	{
		$response = array();
		$this->form_validation->set_rules([
			['field' => 'amount','label' => 'Amount', 'rules' => 'required|numeric|max_length[65]'],
			['field' => 'dd_no', 'label' => 'Tr. No.', 'rules' => 'required|numeric|max_length[30]'],
			['field' => 'dd_date', 'label' => 'Tr. Date', 'rules' => 'required|valid_date|min_length[10]'],
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
		$fields['amount'] = $this->input->Post('amount');
		$fields['dd_no'] = $this->input->Post('dd_no');
		$fields['dd_date'] = $this->input->Post('dd_date');
		$fields['payment_mode'] = 3;//onlione 3 else anything
		$fields['fees_type'] = 1; //additionalfee 1 else 0
		$fields['dd_bank'] = 107; //bharatkosh
		$fields['user_id'] = $this->user_id; //bharatkosh

			$schemaData=getSingleSchemas($filing_no);
			$schemas=$schemaData['schema_name'];
			$this->db->insert($schemas.'.fee_detail',$fields);
            if ($this->db->affected_rows()>0)
			{
                $response['success'] = true;
                $response['messages'] = 'Fee Added Succfully';//lang("App.insert-success") ;
				$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
				
            } else {
                $response['success'] = false;
                $response['messages'] ='Error Occured'; //lang("App.insert-error") ;
				$response[$this->security->get_csrf_token_name()] = $this->security->get_csrf_hash();
            }

        echo json_encode($response);
	}

	public function edit()
	{
        $response = array();
		
		$fields['filing_no'] = $this->input->Post('filing_no');
$fields['amount'] = $this->input->Post('amount');
$fields['dd_no'] = $this->input->Post('dd_no');
$fields['dd_date'] = $this->input->Post('dd_date');
$fields['appfiling_no'] = $this->input->Post('appfiling_no');


        $this->validation->setRules([
			            'amount' => ['label' => 'Amount', 'rules' => 'required|min_length[30]|max_length[65]'],
            'dd_no' => ['label' => 'Tr. No.', 'rules' => 'required|min_length[30]|max_length[30]'],
            'dd_date' => ['label' => 'Tr. Date', 'rules' => 'required|valid_date|min_length[10]'],
            'appfiling_no' => ['label' => 'Application Filing no', 'rules' => 'permit_empty|min_length[16]|max_length[16]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->feedetailModel->update($fields['filing_no'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = lang("App.update-success");	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = lang("App.update-error");
				
            }
        }
		
        return $this->response->setJSON($response);	
	}
	
	public function remove()
	{
		$response = array();

		$id = $this->input->Post('filing_no');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();

		} else {

			if ($this->feedetailModel->where('filing_no', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("App.delete-success");

			} else {

				$response['success'] = false;
				$response['messages'] = lang("App.delete-error");

			}
		}

        return $this->response->setJSON($response);
	}
		
}	
