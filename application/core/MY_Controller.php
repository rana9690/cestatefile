<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
	protected $userData;
	//protected $use;
	protected $user_id;
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		$this->userData = $this->session->userdata('login_success');
		if(empty($this->userData[0]->loginid)){
			redirect(base_url(),'refresh');
			die;
		}
		
		$this->user_id=$this->userData[0]->id;
	}

	//********* Check file mime type ***********//
	public function mimeType() {
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
		return true;
		//$this->form_validation->set_message('isValidPDF', 'Not a valid file!');
		// Grab the file name off the top of the $params
		// after we split it.
		/* $params = explode(',', $params);
         $name   = array_shift($params);
         $request = service('request');
         if (! ($files = $request->getFileMultiple($name))) {
             $files = [$request->getFile($name)];
         }*/
		/*$file= $_FILES['userfile']['tmp_name'];
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

		return true;*/
	}
	public function getSaltDocLocation($filing_no)
	{
		return substr($filing_no,5,1).substr($filing_no,0,5);
	}



}
