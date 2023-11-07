<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends CI_Controller {
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
		endforeach;
	    }
	    
	    function case_filing_steps(){
	        $this->load->view('admin/case_filing_steps',$data);
	    }
	    
	    
}