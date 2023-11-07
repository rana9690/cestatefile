<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Certified extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Admin_model','admin_model');
        $this->load->model('Efiling_model','efiling_model');
		$this->userData = $this->session->userdata('login_success');
		$userLoginid = $this->userData[0]->loginid;
		if(empty($userLoginid)){
			redirect(base_url(),'refresh');
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
    
    
    function certbasicdetail(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('certsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data[]='';
            $this->load->view('certified/certbasicdetail',$data);
        }
    }
    
    function certpartydetail(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('certsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data[]='';
            $this->load->view('certified/certpartydetail',$data);
        }
    }
    
    function certuploaddoc(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('certsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data[]='';
            $this->load->view('certified/certuploaddoc',$data);
        }
    }
    function certpf(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('certsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data[]='';
            $this->load->view('certified/certpf',$data);
        }
    }
    
    
    
    function certpayment(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('certsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data[]='';
            $this->load->view('certified/certpayment',$data);
        }
    }
    function certreceipt(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('certsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data[]='';
            $this->load->view('certified/certreceipt',$data);
        }
    }
    
    
    function matter(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('certsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data[]='';
            $this->load->view('certified/matter',$data);
        }
    }
    
    
    function saveCertbasic(){
        $saltval='';
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $cudate=date('Y-m-d');
        $subtoken=$this->session->userdata('submittoken');
        $token=htmlentities($_REQUEST['token']);
        $this->form_validation->set_rules('tab_no','Please select date ','trim|required|min_length[1]|max_length[1]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $salt='';
        if($saltval==''){
            $verify_salt=$this->db->select('salt')
            ->where(['user_id'=>$user_id,'year'=>date('Y')])
            ->get('salt_tbl')
            ->row()
            ->salt;
            $verify_salt=(int)$verify_salt;
            if($verify_salt == 0) {
                $data=['salt'=>1,'year'=>date('Y'),'user_id'=>$user_id];
                $this->db->insert('salt_tbl',$data);
            }
            elseif($verify_salt > 0) {
                $verify_salt=$verify_salt + 1;
                $data=['salt'=>$verify_salt];
                $wcond=['year'=>date('Y'),'user_id'=>$user_id];
                $this->db->set($data)->where($wcond)->update('salt_tbl');
            }
            $salt=$verify_salt.date('Y');
            $this->session->set_userdata('certsalt',$salt);
        }
        if($subtoken==$token){
            $postdata=array(
                'salt'=>$salt,
                'tabno'=>$_REQUEST['tab_no'],
                'filing_no'=>$_REQUEST['filing_no'],
                'user_id'=>$user_id,
            );
            $st=$this->efiling_model->insert_query('certifiedtemp', $postdata);
            if($st){
                $massage="Successfully Submit.";
                echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
            }
        }else{
            $massage="User not valid.";
            echo json_encode(['data'=>'error','value'=>$massage,'massage'=>$massage,'error'=>'1']);
        }
    }

    
    function certpartysave(){
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $token=htmlentities($_REQUEST['token']);
        $tabno=htmlentities($_REQUEST['tab_no']);
        $filing_no=htmlentities($_REQUEST['filing_no']);
        $salt=$this->session->userdata('certsalt');
        $type=htmlentities($_REQUEST['type']);
        $partyType=htmlentities($_REQUEST['partyType']);
        $iapartys=htmlentities($_REQUEST['partyids']);
        $cudate=date('Y-m-d');
        $subtoken=$this->session->userdata('submittoken');
        $this->form_validation->set_rules('partyType','Please select type','trim|required|min_length[1]|max_length[2]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $this->form_validation->set_rules('tab_no','Please enter tab number','trim|required|min_length[1]|max_length[3]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
        }
        $this->form_validation->set_rules('filing_no','enter valid filing no','trim|required|min_length[15]|max_length[15]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        if($subtoken==$token){
            $array=array(
                'tabno'=>$tabno,
                'entry_date'=>$cudate,
                'user_id'=>$user_id,
                'type'=>$type,
                'partyType'=>$partyType,
                'partyids'=>$iapartys,
            );
            $where=array('salt'=>$salt);
            $st = $this->efiling_model->update_data_where('certifiedtemp',$where,$array);
            if($st){
                $massage="Successfully Submit.";
                echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
            }
        }else{
            $massage="User not valid.";
            echo json_encode(['data'=>'error','value'=>'','massage'=>$massage,'error'=>'1']);
        }
    }
    
    
    function doc_save_nextcert(){
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $token=htmlentities($_REQUEST['token']);
        $tabno=htmlentities($_REQUEST['tabno']);
        $untak=htmlentities($_REQUEST['untak']);
        $salt=$this->session->userdata('cavsalt');
        $cudate=date('Y-m-d');
        $subtoken=$this->session->userdata('submittoken');
        if($subtoken==$token){
            $array=array(
                'tabno'=>$tabno,
                'undertaking'=>$untak,
            );
            $where=array('salt'=>$salt);
            $st = $this->efiling_model->update_data_where('certifiedtemp',$where,$array);
            if($st){
                $massage="Successfully Submit.";
                echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
            }
        }else{
            $massage="User not valid.";
            echo json_encode(['data'=>'error','value'=>'','massage'=>$massage,'error'=>'1']);
        }
    }

    function certfpsave(){
        $salt=$this->session->userdata('certsalt');
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $token=htmlentities($this->input->post('token'));
        $type=htmlentities($this->input->post('type'));
        $subtoken=$this->session->userdata('submittoken');
        if($subtoken==$token){
            $tabno=$_REQUEST['tabno'];
            $datatab=array(
                'tabno'   =>$tabno,
            );
            $st1=$this->efiling_model->update_data('certifiedtemp', $datatab,'salt', $salt);
            echo json_encode(['data'=>'success','display'=>'','error'=>'0']);die;
        }else{
            echo json_encode(['data'=>'error','display'=>'Request not valid','error'=>'1']);die;
        }
    }

    function copycertifiedCopysave(){
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $this->form_validation->set_rules('patyAddId','please enter party type','trim|required|numeric|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $this->form_validation->set_rules('filingNo',' filing no not valid','trim|required|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $this->form_validation->set_rules('matterId','please enter matter id','trim|required|htmlspecialchars');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }

        $this->form_validation->set_rules('total_page2','please enter number of page','trim|required|htmlspecialchars');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $this->form_validation->set_rules('no_set','please enter number of set.','trim|required|htmlspecialchars');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $this->form_validation->set_rules('total','please enter total amount','trim|required|htmlspecialchars');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $salt=$this->session->userdata('certsalt');
        if($user_id){
            $array=array(
                'filling_no'=>$this->input->post('filingNo'),
                'meta_type'=>$this->input->post('matterId'),
                'no_page'=>$this->input->post('total_page2'),
                'no_set'=>$this->input->post('no_set'),
                'total'=>$this->input->post('total'),
                'total_no_page'=>$this->input->post('total_page2'),
                'end_nopage'=>$this->input->post('end_nopage2'),
                'order_date'=>$this->input->post('orderdate'),
                'created_by'=>$user_id,
                'created_on'=>date('Y-d-m'),
                'salt'=>$salt,
          );
          $val= $this->efiling_model->insert_query('temp_certified_copy_matters',$array);
          if($val){
             echo json_encode(['data'=>'success','value'=>'done','massage'=>'success','error'=>'0']); die;
          }else{
              echo json_encode(['data'=>'error','value'=>'','massage'=>'Not valid request','error'=>'1']); die;
          }
        }
    }
    
    
    function deletecopycertified(){
        $token=htmlentities($_REQUEST['token']);
        $id=htmlentities($_REQUEST['id']);
        $subtoken=$this->session->userdata('submittoken');
        if($subtoken==$token){
            $sql1=$this->efiling_model->delete_event('temp_certified_copy_matters','id',$id);
            if($sql1){
                echo json_encode(['data'=>'success','value'=>'done','massage'=>'success','error'=>'0']); die;
            }else{
                echo json_encode(['data'=>'error','value'=>'','massage'=>'Not valid request','error'=>'1']); die;
            }
        }
        echo json_encode(['data'=>'error','value'=>'','massage'=>'Not valid request','error'=>'1']); die;
    }
    
    function savematter(){
        $token=htmlentities($_REQUEST['token']);
        $filing_no=htmlentities($_REQUEST['filing_no']);
        $salt=$this->session->userdata('certsalt');
        $tabno=htmlentities($_REQUEST['tabno']);
        $type=htmlentities($_REQUEST['type']);
        $subtoken=$this->session->userdata('submittoken');
        if($subtoken==$token){
            $tabno=$_REQUEST['tabno'];
            $datatab=array(
                'tabno'   =>$tabno,
                'filing_no'   =>$filing_no,
            );
            $sql1=$this->efiling_model->update_data('certifiedtemp', $datatab,'salt', $salt);
            if($sql1){
                echo json_encode(['data'=>'success','value'=>'done','massage'=>'success','error'=>'0']); die;
            }else{
                echo json_encode(['data'=>'error','value'=>'','massage'=>'Not valid request','error'=>'1']); die;
            }
        }
        echo json_encode(['data'=>'error','value'=>'','massage'=>'Not valid request','error'=>'1']); die;
    }
    
    
    function  certfinalsave(){
            $last_inserted_id='';
            $userdata=$this->session->userdata('login_success');
            $user_id=$userdata[0]->id;
            $id = mt_rand(100000,999999);
            $date=date('Y-m-d');
            $year=date('Y');
            $salt=$this->session->userdata('certsalt');
            $ip=$_SERVER['HTTP_HOST'];
            $payAmount= $this->input->post('amountRs');  
            $total=$this->input->post('totalamount');  
            $collectamountsss=$this->input->post('collectamount');  
            
            $valtoal=(int)$collectamountsss+(int)$payAmount;
            if($valtoal<$total){
                echo json_encode(['data'=>'error','value'=>'','massage'=>'Please Enter valid amount','error'=>'1']); die;
            }
            
            $case_initialization = $this->efiling_model->data_list_where('ia_initialization','year',$year);
            $certified_no =  $case_initialization[0]->certified_copy;
            $certified_no  = $certified_no+1;
            $payment_mode='3';
            $tcert = $this->efiling_model->data_list_where('certifiedtemp','salt',$salt);
            $filingNo=$tcert[0]->filing_no;
            $tmatter = $this->efiling_model->data_list_where('temp_certified_copy_matters','salt',$salt);
            if(!empty($tcert) && is_array($tcert)){
                foreach($tcert as $cerrow){
                    $data=array(
                        'filling_no'=>$cerrow->filing_no,
                        'party_type'=>$cerrow->partyType,
                        'party_ids'=>$cerrow->partyids,
                        'payment_mode'=>$payment_mode,
                        'created_by'=>$user_id,
                        'created_on'=>date('Y-m-d'),
                        'ip'=>$ip,
                        'year'=>$year,
                        'certify_number'=>$certified_no,
                    );
                }
                $sqlpet2 = $this->efiling_model->insert_query('certified_copy',$data);
                $last_inserted_id =$this->db->insert_id();
            }else{
                echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>'Not valid request','error'=>'1']); die;
            }

            //Matters data insert
            $tmtr = $this->efiling_model->data_list_where('temp_certified_copy_matters','salt',$salt);
            if(!empty($tmtr) && is_array($tmtr)){
                foreach($tmtr as $mrow){
                    $data=array(
                        'filling_no'=>$mrow->filling_no,
                        'meta_type'=>$mrow->meta_type,
                        'order_date'=>$mrow->order_date,
                        'no_page'=>$mrow->no_page,
                        'no_set'=>$mrow->no_set,
                        'total'=>$mrow->total,
                        'created_by'=>$user_id,
                        'created_on'=>$date,
                        'ip'=>$ip,
                        'certify_copy_id'=>$last_inserted_id,
                        'end_nopage'=>$mrow->end_nopage,
                        'total_no_page'=>$mrow->total_no_page,
                    );
                    $sqlpet2 = $this->efiling_model->insert_query('certified_copy_matters',$data);
                    $last_inserted_id2 ='';
                }
            }else{
                echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>'Not valid request','error'=>'1']); die;
            }
      
            //Online Payment
            $bd= $this->input->post('bd');  
            $dbankname= $this->input->post('dbankname');
            $ddate= $this->input->post('dddate');
            $ddno= $this->input->post('ddno');
            $amountRs= $this->input->post('amountRs');
            // Insert data in temprary table
            if($dbankname!='' && $ddate!=''){
                $date=date('Y-m-d');
                $data=array(
                    'salt'=>$salt,
                    'payment_mode'=>$bd,
                    'branch_name'=>$dbankname,
                    'dd_no'=>$ddno,
                    'dd_date'=>$ddate,
                    'amount'=>$amountRs,
                    'createdate'=>$date,
                );
                $sqlpet2 = $this->efiling_model->insert_query('aptel_temp_payment',$data);
            }else{
                echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>'Not valid request','error'=>'1']); die;
            }
            
            //IA Document Upload
            $st=$this->efiling_model->data_list_where('temp_documents_upload','salt',$salt);
            if(!empty($st)){
                foreach($st as $vals){
                    $data12=array(
                        'filing_no'=>$last_inserted_id,
                        'user_id'=>$user_id,
                        'valumeno'=>$vals->valumeno,
                        'document_filed_by'=>$vals->document_filed_by,
                        'document_type'=>$vals->document_type,
                        'no_of_pages'=>$vals->no_of_pages,
                        'file_url'=>$vals->file_url,
                        'display'=>$vals->display,
                        'update_on'=>$vals->update_on,
                        'matter'=>$vals->matter,
                        'doc_type'=>$vals->doc_type,
                        'ref_filing_no'=>$last_inserted_id,
                        'submit_type'=>$vals->submit_type,
                        'docid'=>$vals->docid,
                        'doc_name'=>$vals->doc_name,
                    );
                    $st=$this->efiling_model->insert_query('efile_documents_upload',$data12);
                }
            }

            if($payment_mode!=''){
                $amt = $this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
                if(!empty($amt) && is_array($amt)){
                    foreach($amt as $row_payment){
                        $data=array(
                            'filing_no'=>$row_payment->salt,
                            'fee_amount'=>$payAmount,
                            'payment_mode'=>$row_payment->payment_mode,
                            'branch_name'=>$row_payment->branch_name,
                            'dd_no'=>$row_payment->dd_no,
                            'dd_date'=>$row_payment->dd_date,
                            'amount'=>$row_payment->amount,
                            'ia_fee'=>$row_payment->ia_fee,
                            'other_fee'=>$row_payment->other_fee,
                            'certify_id'=>$last_inserted_id,
                            'certify_matter_id'=>$last_inserted_id2,
                        );
                        $sqlpet2 = $this->efiling_model->insert_query('aptel_certify_account_details',$data);
                    }
                    if($certified_no!=''){
                        $where=array('year'=>$year );
                        $data=array('certified_copy'=>$certified_no);
                        $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data);
                    }
                    $data['msg']="Successfully submited";
                    $data['certified_no']=$certified_no;
                    $data['filingNo']=$filingNo;
                    $this ->session->set_userdata('certdetail',$data);
                    $delete_data=$this->efiling_model->delete_event('aptel_temp_payment','salt',$salt);
                    $delete_data=$this->efiling_model->delete_event('certifiedtemp','salt',$salt);
                    $delete_data=$this->efiling_model->delete_event('temp_certified_copy_matters','salt',$salt);
                    $delete_data=$this->efiling_model->delete_event('temp_documents_upload','salt',$salt);
                     $this->session->unset_userdata('cavsalt');
                    echo json_encode(['data'=>'success','value'=>validation_errors(),'massage'=>'success','error'=>'0']); die;
                }
            }else{
                echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>'Not valid request','error'=>'1']); die;
            }
    }
    
 
}