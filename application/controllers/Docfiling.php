<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Docfiling extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Admin_model','admin_model');
        $this->load->model('Efiling_model','efiling_model');
		$this->userData = $this->session->userdata('login_success');
		$userLoginid = $this->userData[0]->loginid;
		if(empty($userLoginid)){
			redirect(base_url(),'refresh');
		}
		
    }
    
    function  doc_basic_detail(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        $user_id=$userdata[0]->id;
        if($user_id){
            $data['datacomm']= $this->efiling_model->data_commission_where($salt,$user_id);
            $this->load->view('docfiling/doc_basic_detail',$data);
        }
    }
    function doc_partydetail(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        if($salt==''){
            redirect(base_url());
        }
        $user_id=$userdata[0]->id;
        if($user_id){
            $data['datacomm']= $this->efiling_model->data_commission_where($salt,$user_id);
            $data['natureorders']=getIssAuthDesignations([]);
            $data['commisions']=getIss_auth_masters([]);
            $data['impugnesArray']=getImpugnedType([]);
            $this->load->view('docfiling/doc_partydetail',$data);
        }
    }
    function ia_detail_ia(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        if($salt==''){
            redirect(base_url(),'refresh');
        }
        $user_id=$userdata[0]->id;
        if($user_id){
            $data['datacomm']= $this->efiling_model->data_commission_where($salt,$user_id);
            $this->load->view('docfiling/ia_detail_ia',$data);
        }
    }
    
    function doc_upload_doc(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        if($salt==''){
            redirect(base_url());
        }
        $user_id=$userdata[0]->id;
        if($user_id){
            $data['datacomm']= $this->efiling_model->data_commission_where($salt,$user_id);
            $this->load->view('docfiling/doc_upload_doc',$data);
        }
    }
    function doc_checklist(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        $user_id=$userdata[0]->id;
        if($salt==''){
            redirect(base_url(),'refresh');
        }
        if($user_id){
            $data['checklist']= $this->efiling_model->data_list_where('master_checklist','status','1');
            $this->load->view('docfiling/doc_checklist',$data);
        }
    }
    function doc_finalprivew(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        $user_id=$userdata[0]->id;
        if($salt==''){
            redirect(base_url(),'refresh');
        }
        if($user_id){
            $data['datacomm']= $this->efiling_model->data_commission_where($salt,$user_id);
            $this->load->view('docfiling/doc_finalprivew',$data);
        }
    }
    function doc_payment(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        $user_id=$userdata[0]->id;
        if($salt==''){
            redirect(base_url(),'refresh');
        }
        if($user_id){
            $data['datacomm']= $this->efiling_model->data_commission_where($salt,$user_id);
            $this->load->view('docfiling/doc_payment',$data);
        }
    }
    
    function ia_finalreceipt(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        $user_id=$userdata[0]->id;
        if($salt==''){
            redirect(base_url(),'refresh');
        }
        if($user_id){
            $this->load->view('docfiling/ia_finalreceipt');
        }
    }
    
    function doc_councel(){
        $userdata=$this->session->userdata('login_success');
        $salt=$this->session->userdata('docsalt');
        if($salt==''){
            redirect(base_url(),'refresh');
        }
        $user_id=$userdata[0]->id;
        if($user_id){
            $this->load->view('docfiling/doc_councel');
        }
    }
    


    function saveDocbasic(){
        //ini_set("display_errors",1);
        //error_reporting(E_ALL);
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $token=$this->input->post('token');
        $tabno=$this->input->post('tabno');
        $filing_no=$this->input->post('filing_no');
        $saltval='';
        $type=$this->input->post('iatype');
        $cudate=date('Y-m-d');
        $subtoken=$this->session->userdata('submittoken');
        $this->form_validation->set_rules('iatype','Please select type','trim|required|min_length[1]|max_length[3]|htmlspecialchars|regex_match[/^[a-z,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
  /*       $this->form_validation->set_rules('toalannexure','Please toal annexure','trim|required|min_length[1]|max_length[3]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
        } */
        $this->form_validation->set_rules('filing_no','enter valid filing no','trim|required|min_length[16]|max_length[16]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
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
            $salt=$user_id.$verify_salt.date('Y');
            $this->session->set_userdata('docsalt',$salt);
        }
        if($subtoken==$token){
            $postdata=array(
                'salt'=>$salt,
                'filing_no'=>$filing_no,
                'tab_no'=>$tabno,
                'entry_date'=>$cudate,
                'user_id'=>$user_id,
                'type'=>$type,
                'bench'=>$this->input->post('bench'),
				'appfiling_no'=>($this->input->post('appfiling_no'))?$this->input->post('appfiling_no'):null,
                'appmainfiling_no'=>($this->input->post('appmainfiling_no'))?$this->input->post('appmainfiling_no'):null,
            );
            $st=$this->efiling_model->insert_query('temp_docdetail', $postdata);
            if($st){
                $massage="Successfully Submit.";
                echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
            }
        }else{
            $massage="User not valid.";
            echo json_encode(['data'=>'error','value'=>'','massage'=>$massage,'error'=>'1']);
        }
    }
    
    
    function docpartysave(){
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $token=$this->input->post('token');
        $salt=$this->session->userdata('docsalt');
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
        $this->form_validation->set_rules('filing_no','enter valid filing no','trim|required|min_length[16]|max_length[16]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        
        $this->form_validation->set_rules('docidval','enter valid doc value','trim|required|min_length[0]|max_length[2]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        
       
        $this->form_validation->set_rules('doctype','enter valid doc type','trim|required|min_length[0]|max_length[3]');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
        }
        
        if($this->input->post('doctype')!='va' && $this->input->post('doctype')!='oth'){ 
            $this->form_validation->set_rules('toalannexure','Please toal annexure','trim|required|min_length[1]|max_length[3]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
            }
        }

        if($subtoken==$token){
            $array=array(
                'tab_no'=>$this->input->post('tab_no'),
                'filing_no'=>$this->input->post('filing_no'),
                'entry_date'=>$cudate,
                'user_id'=>$user_id,
                'type'=>$this->input->post('type'),
                'partyType'=>$this->input->post('partyType'),
                'partys'=>$this->input->post('partyids'),
                'docids'=>$this->input->post('docidval'),
                'doctype'=>$this->input->post('doctype'),
                'totalanx'=>$this->input->post('toalannexure'),
                'matter'=>$this->input->post('matter'),
            );           
            $where=array('salt'=>$salt);
            $st = $this->efiling_model->update_data_where('temp_docdetail',$where,$array);
            if($st){
                $massage="Successfully Submit.";
                echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
            }
        }else{
            $massage="User not valid.";
            echo json_encode(['data'=>'error','value'=>'','massage'=>$massage,'error'=>'1']);
        }
    }
    

    
    function doc_save_nextDoc(){
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $token=htmlentities($_REQUEST['token']);
        $tabno=htmlentities($_REQUEST['tabno']);
        $untak=htmlentities($_REQUEST['untak']);
        if($untak=='0'){
            echo json_encode(['data'=>'error','error'=>'Please Check undertaking  !']);die;
        }
        $salt=$this->session->userdata('docsalt');
        $cudate=date('Y-m-d');
        $subtoken=$this->session->userdata('submittoken');
        if($subtoken==$token){
            $sts=$this->efiling_model->data_list_where('temp_docdetail','salt', $salt);
            $doctype=isset($sts[0]->doctype)?$sts[0]->doctype:'';
            $docvalidation=0;
            $st=$this->efiling_model->data_list_where('temp_documents_upload','salt', $salt);
            if(!empty($st)){
                foreach($st as $dval){
                    $stvadv=$dval->document_type;
                    if($stvadv!='Vakalatnama'){
                        if($stvadv=='Proof_of_Service'){
                            $docvalidation='1';
                        }
                    }
                }
            }else{
                //echo json_encode(['data'=>'error','error'=>'Please select  mandatory documents !']);die;
            }
            if($doctype='va'){
                if($docvalidation==0){
                   // echo json_encode(['data'=>'error','error'=>'Please select Proof of Service it is mandatory !']);die;
                }
            }
            $array=array(
                'tab_no'=>$tabno,
                'undertaking'=>$untak,
            );
            $where=array('salt'=>$salt);
            $st = $this->efiling_model->update_data_where('temp_docdetail',$where,$array);
            if($st){
                $massage="Successfully Submit.";
                echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
            }
        }else{
            $massage="User not valid.";
            echo json_encode(['data'=>'error','value'=>'','massage'=>$massage,'error'=>'1']);
        }
    }
    
    
    
    
    function docadvsave(){
        $msg='';
        date_default_timezone_set('Asia/Calcutta');
        $post_array=$this->input->post();
        $salt= $this->session->userdata('docsalt');
        $token=$_REQUEST['token'];
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $subtoken=$this->session->userdata('submittoken');
        if($subtoken!=$token){
            echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);die;
        }
    
        
        
        $query_params=array(
            'tab_no'=>$_REQUEST['tabno']
        );
        $data_app=$this->efiling_model->update_data('temp_docdetail', $query_params,'salt', $salt);
        if($data_app){
            echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
        } else{
            echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);
        }
    }
    
    
    function chk_listdataDoc(){
        if($this->session->userdata('login_success') && $this->input->post()) {
            $salt=$this->session->userdata('docsalt');
            $userdata=$this->session->userdata('login_success');
            $user_id=$userdata[0]->id;
            $token=htmlentities($this->input->post('token'));
            $type=htmlentities($this->input->post('type'));
            $subtoken=$this->session->userdata('submittoken');
            $tabno=htmlentities($this->input->post('tabno'));
            if($subtoken==$token){
                $wcond=['salt'=>$salt,'user_id'=>$user_id];
                $exest_clist=$this->db->where($wcond)->get('checklist_temp');
                if($exest_clist->num_rows() > 0) {
                    $this->db->where($wcond)->delete('checklist_temp');
                }
                for($i=1; $i<=9; $i++){
                    $data=[
                        'user_id'=>$user_id,
                        'salt'=>$salt,
                        'serial_no'=>$i,
                        'action'=>htmlentities($this->input->post('check'.$i)),
                        'values'=>'0',
                        'type'=>$type,//htmlentities($this->input->post('value'.$i))
                    ];
                    $db=$this->db->insert('checklist_temp',$data);
                }
                $array=array(
                    'tab_no'=>$tabno,
                );
                $where=array('salt'=>$salt);
                $st = $this->efiling_model->update_data_where('temp_docdetail',$where,$array);
                if($db) echo json_encode(['data'=>'success','error'=>'0']);
                else 	echo json_encode(['data'=>'Qyery error, try again','error'=>'1']);
            }
        }
        else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
    }
    
    
    
    
    
    function docfpsave(){

        $salt=$this->session->userdata('docsalt');
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $token=htmlentities($this->input->post('token'));
        $type=htmlentities($this->input->post('type'));
        $iatotalfee=htmlentities($this->input->post('totalfee'));
        $subtoken=$this->session->userdata('submittoken');
     
        if($subtoken==$token){
            if($salt!=''){
                $basicia= $this->efiling_model->data_list_where('temp_docdetail','salt',$salt);
                $anx=isset($basicia[0]->totalanx)?$basicia[0]->totalanx:0;
                $doctype=isset($basicia[0]->doctype)?$basicia[0]->doctype:'';
                if($doctype=='va'){
                    $anx=1;
                } 
                $toalfee=$anx*25;
                if($toalfee!=$iatotalfee){
                    //echo json_encode(['data'=>'error','display'=>'Amount is not valid !','error'=>'1']);die;
                }
            }
            $tabno=$this->input->post('tabno');
            $datatab=array(
                'tab_no'    =>$tabno,
                'doctotal_fee'=>$iatotalfee,
            );
            $st1=$this->efiling_model->update_data('temp_docdetail', $datatab,'salt', $salt);
            echo json_encode(['data'=>'success','display'=>'','error'=>'0']);die;
        }else{
            echo json_encode(['data'=>'error','display'=>'Request not valid','error'=>'1']);die;
        }
    }
    
    
    function chekva(){
            $party_ids='';
            $valcheck='';
            $pid = $_REQUEST['party_id'];
            $filing_no = $_REQUEST['filing_no'];
            $partyType = $_REQUEST['partyType'];
            if ($partyType == '2') {
                $flags = 'R';
            } else if ($partyType == '1') {
                $flags = 'P';
            }
            if($partyType=='1'){
                $valcheck= "yes";
            }
            if($partyType!='1'){
                $array=array('party_flag'=>$partyType,'filing_no'=>$filing_no);
                $qu_caveat_detail_data = $this->efiling_model->data_list_mulwhere('vakalatnama_detail',$array);
                $party_ids = '';
                if (!empty($qu_caveat_detail_data)) {
                    foreach ($qu_caveat_detail_data as $key => $value) {
                        $party_ids .= $value->add_party_code . ',';
                    }
                }
                $array=array('party_flag'=>$flags,'filing_no'=>$filing_no);
                $advocate_data = $this->efiling_model->data_list_mulwhere('additional_advocate',$array);
                if (!empty($advocate_data)) {
                    foreach ($advocate_data as $key => $value) {
                        $party_ids .= $value->party_code . ',';
                    }
                }
            
                if (!empty($party_ids)) {
                    $party_id = explode(',',$party_ids);
                    if (!empty($party_id)) {
                        $sr = 1;
                        if (is_array($party_id)){
                            foreach ($party_id as $value) {
                                if(is_numeric($value)){
                                    if($value==$pid){
                                        $valcheck= "yes";
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($valcheck=='yes'){
                echo json_encode(['data'=>'success','display'=>$valcheck,'error'=>'0']);die;
            }else{
                echo json_encode(['data'=>'error','display'=>'no','error'=>'1']);die;
            }
      }
      
      function iadetail($iafiling){
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          if($user_id){
              $arr=array('ref_filing_no'=>$iafiling,'submit_type'=>'ia');
              $data['iadetail']= $this->efiling_model->data_list_where('ia_detail','ia_filing_no', $iafiling);
              $data['docs']= $this->efiling_model->data_list_mulwhere('efile_documents_upload',$arr);
              $this->load->view('ia/iadetails',$data);
          }
      }
      
      
      function addCouncelDoc(){
          $advName='';
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          $salt=$this->session->userdata('docsalt');
          $subtoken=$this->session->userdata('submittoken');
          $token=isset($_REQUEST['token'])?$_REQUEST['token']:'';
          $id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
          $partyType=isset($_REQUEST['partyType'])?$_REQUEST['partyType']:'';
          $advType=isset($_REQUEST['advType'])?$_REQUEST['advType']:'';
          $councilCode=isset($_REQUEST['councilCode'])?$_REQUEST['councilCode']:'';
          $edittype=isset($_REQUEST['action'])?$_REQUEST['action']:'';
          $advType=isset($_REQUEST['advType'])?$_REQUEST['advType']:'';
          $this->form_validation->set_rules('cdstate','Please select state','trim|required|min_length[1]|max_length[4]|htmlspecialchars|regex_match[/^[0-9]+$/]');
          if($this->form_validation->run() == FALSE){
              echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>'1']);die;
          }
          $this->form_validation->set_rules('cddistrict','Please select district','trim|required|min_length[1]|max_length[3]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
          if($this->form_validation->run() == FALSE){
              echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>'1']); die;
          }
          
          $this->form_validation->set_rules('counselPin','Enter Pin number','trim|required|min_length[6]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
          if($this->form_validation->run() == FALSE){
              echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>'1']); die;
          }
          $this->form_validation->set_rules('counselMobile','Enter mobile number.','trim|required|min_length[10]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
          if($this->form_validation->run() == FALSE){
              echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>'1']); die;
          }
          
          $this->form_validation->set_rules('counselMobile','Enter mobile number.','trim|required|min_length[10]|htmlspecialchars|regex_match[/^[0-9,]+$/]');
          if($this->form_validation->run() == FALSE){
              echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>'1']); die;
          }
          
          $this->form_validation->set_rules('counselEmail','Enter email address.','trim|required|min_length[1]|max_length[50]|htmlspecialchars');
          if($this->form_validation->run() == FALSE){
              echo json_encode(['data'=>'error','value'=>validation_errors(),'massage'=>validation_errors(),'error'=>'1']); die;
          }
          
          
          if($salt!=''){
              $hscquery = $this->efiling_model->data_list_where('temp_docdetail','salt',$salt);
              $petadvName = $hscquery[0]->council_code;
          }
          
          if($advType=='1'){
              if(is_numeric($councilCode)){
                  $hscquery = $this->efiling_model->data_list_where('master_advocate','adv_code',$councilCode);
                  $advName = $hscquery[0]->adv_name;
              }
          }
          if($advType=='2'){
              if(is_numeric($councilCode)){
                  $hscquery = $this->efiling_model->data_list_where('efiling_users','id',$councilCode);
                  $advName = $hscquery[0]->fname.' '.$hscquery[0]->lname;
              }
          }

          if($token==$subtoken){
              if($edittype=='add'){
                  $array = array(
                      'salt'=>$salt,
                      'adv_name'=>$advName,
                      'counsel_add'=>$_REQUEST['counselAdd'],
                      'counsel_pin'=>$_REQUEST['counselPin'],
                      'counsel_mobile'=>$_REQUEST['counselMobile'],
                      'counsel_email'=>$_REQUEST['counselEmail'],
                      'council_code'=>$councilCode,
                      'counsel_fax'=>$_REQUEST['counselFax'],
                      'counsel_phone'=>$_REQUEST['counselPhone'],
                      'user_id'=>$user_id,
                      'adv_district'=>$_REQUEST['cddistrict'],
                      'adv_state'=>$_REQUEST['cdstate'],
                      'entry_time'=>date('Y-m-d'),
                      'advType'=>$advType,
                  );
                  $st = $this->efiling_model->insert_query('aptel_temp_add_advocate',$array);
                  $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
                  $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt);
                  if($st){
                      echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
                  }
              }
          }
      }
      
      
      
      function deleteAdvocatDoc(){
          $msg='';
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          $salt= $this->session->userdata('docsalt');
          $subtoken=$this->session->userdata('submittoken');
          $token=$_REQUEST['token'];
          $id=$_REQUEST['id'];
          if($token==$subtoken){
              $delete= $this->efiling_model->delete_event('aptel_temp_add_advocate', 'id', $id);
              if($delete){
                  $msg="Record successfully  deleted !";
                  $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
                  $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt);
                  echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
              }
          }else{
              $msg="Something went wrong";
              echo json_encode(['data'=>'','display'=>'','error'=>'1','massage'=>$msg]);die;
          }  
      }
        
      
      function getAdvocatelist($advocatelist,$salt){
          $html='';
          $html.='
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
	        <thead>
    	        <tr>
        	        <th>Sr. No. </th>
        	        <th>Name</th>
        	        <th>Registration No.</th>
                    <th>Address</th>
        	        <th>Mobile</th>
        	        <th>Email</th>
        	        <th>Delete</th>
    	        </tr>
	        </thead>
	        <tbody>';
          $html.='</tbody>';
         $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
          if(!empty($advocatelist)){
              $i=1;
              foreach($advocatelist as $val){
                  $counselmobile='';
                  $counselemail='';
                  $counseladd=$val->council_code;
                  $advType=$val->advType;
                  if($advType=='1'){
                      if (is_numeric($val->council_code)) {
                          $orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
                          $adv_name=$val->adv_name;
                          $adv_reg=$orgname[0]->adv_reg;
                          $address=$val->counsel_add;
                          $pin_code=$val->counsel_pin;
                          $counselmobile=$val->counsel_mobile;
                          $counselemail=$val->counsel_email;
                          $id=$val->id;
                          if($val->adv_state!=''){
                              $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$val->adv_state);
                              $statename= $st2[0]->state_name;
                          }
                          if($val->adv_district!=''){
                              $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$val->adv_district);
                              $ddistrictname= $st1[0]->district_name;
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
                          if($orgname[0]->state!=''){
                              $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$orgname[0]->state);
                              $statename= $st2[0]->state_name;
                          }
                          if($orgname[0]->district!=''){
                              $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$orgname[0]->district);
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
                        <td><center><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1" onclick="deletePartyadv('.$id.')"></center></td>
        	        </tr>';
                  $i++;
              }
          }
          return $html;
      }





    function documentFilingSave()
    {
        //ini_set("display_errors",1);
        //error_reporting(E_ALL);

        $salt= $this->session->userdata('docsalt');
        $docrow = $this->db->get_where('temp_docdetail',['salt'=>$salt])->row_array();
        $filing_no=$docrow['filing_no'];
        $user_id=$docrow['user_id'];
        $bench=$docrow['bench'];
        $matter= $docrow['matter'];
        $entry_date= $docrow['bench'];
        $party_type= $docrow['party_type'];
        if(empty($docrow))
        {
            echo json_encode(['data'=>'error','value'=>'Rwquest not valid','massage'=>validation_errors(),'error'=>'1']); die;
        }
        $benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
        $schemas=$benchData['schema_name'];


        $st=$this->efiling_model->data_list_where('temp_documents_upload','salt',$salt);
        $this->db->trans_start();
        $filCounter=$this->db->select('filing_no')->get_where($schemas.'.document_counter',['year'=>date('Y')])->row_array();


        $fil_no=$filCounter['filing_no']+1;


        //comment for testing
        if(!empty($st)){
            foreach($st as $vals){
                $file_url=$vals->file_url;
                $doc_name=$vals->doc_name;
                $no_of_pages=$vals->no_of_pages;
                $data12=array(
                    'filing_no'=>$filing_no,
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
                    'submit_type'=>$vals->submit_type,
                    'docid'=>$vals->docid,
                    'doc_name'=>$vals->doc_name,
					'ref_filing_no'=>$fil_no.'/'.date('Y'),
					'addedfrom'=>'docufile',
					'addeddate'=>date('Y-m-d'),
					'addedby'=>$user_id,
                );
                $st=$this->efiling_model->insert_query('efile_documents_upload',$data12);

                $advDetail= $this->db->get_where('aptel_temp_add_advocate',['salt'=>$salt])->row_array();
                $advcode=0;
                if(!empty($advDetail)):
                $advcode= $advDetail['council_code'];
                    endif;
                $filed_by=0;
                if($vals->document_filed_by=='appellants'):$filed_by= 1; $ownername=2;  endif;
                if($vals->document_filed_by=='respondent'):$filed_by= 2;  $ownername=3; endif;
                $cestatDoc[]=[
                    'filing_no'=>$filing_no,
                    'document_type'=>$vals->document_type,
                    'filing_date'=>date('Y-m-d'),
                    'remarks'=>$matter,
                    'entry_date'=>date('Y-m-d'),
                    'user_id'=>$user_id,
                    'filed_by'=>$filed_by,
                    'pet_res_type'=>$party_type,
                    'adv_code'=>$advcode,
                    'document_counter'=>$no_of_pages,
                    'doc_name'=>$vals->document_type,
                    'doc_url'=>$file_url,
                    'ownername'=>$ownername,
                    'file_name'=>$doc_name,
					'ref_filing_no'=>$fil_no.'/'.date('Y'),
					'addedfrom'=>'docufile',
					'addeddate'=>date('Y-m-d'),
					'addedby'=>$user_id,
                ];
                //$this->db->insert_batch($schemas.'.document_filing',$cestatDoc);
               // echo $this->db->last_query();
            }
        }else{
            echo json_encode(['data'=>'error','display'=>'You have not upload any document please upload document .','error'=>'0']);die;
        }
        $this->db->where(['year'=>date('Y')])->update($schemas.'.document_counter',['filing_no'=>$fil_no]);
        $this->db->trans_complete();


        $data['msg']="Successfully submited";
        $data['doc_filing']=$fil_no.'/'.date('Y');
        $data['filingNo']=$filing_no;
        $data['doc_type']='';
        $this ->session->set_userdata('docdetail',$data);
        //$this->efiling_model->delete_event('temp_documents_upload','salt',$salt);
        //$this->efiling_model->delete_event('aptel_temp_add_advocate','salt',$salt);
        //$this->efiling_model->delete_event('temp_docdetail','salt',$salt);
        //$this->efiling_model->delete_event('aptel_temp_payment','salt',$salt);


        echo json_encode(['data'=>'success','display'=>'','msg'=>'']);die;




    }

      function ma_action(){
          ini_set('display_errors',1);
          error_reporting(E_ALL);
          $userdata=$this->session->userdata('login_success');
          $userid=$userdata[0]->id;
          $curYear = date('Y');
          $curMonth = date('m');
          $curDay = date('d');
          $curdate = date('Y-m-d');
          $salt= $this->session->userdata('docsalt');
         /* $this->form_validation->set_rules('dbankname', 'Enter valid Bank Name', 'trim|required|max_length[40]');
          $this->form_validation->set_rules('ddno', 'Enter valid NTRP Number.', 'trim|required|numeric|max_length[13]');
          $this->form_validation->set_rules('dddate', 'Enter valid transaction date', 'trim|required|max_length[15]');
          $this->form_validation->set_rules('totalamount', 'Enter valid amount.', 'trim|required|numeric|max_length[5]');
          $this->form_validation->set_rules('amountRs', 'Enter valid amount.', 'trim|required|numeric|max_length[5]');
          $this->form_validation->set_rules('bd', 'Enter valid payment Type', 'trim|required|numeric|max_length[3]');
          $this->form_validation->set_rules('filing_no', 'Enter valid filing no.', 'trim|required|numeric|max_length[16]');
          if($this->form_validation->run() == false){
              echo json_encode(['data'=>'error','msg'=>validation_errors(),'display'=>validation_errors(),'error'=>1]);die;
          }else{*/
          if(true){
              if($userid){
                  $docrow = $this->efiling_model->data_list_where('temp_docdetail','salt',$salt);
                  if(empty($docrow)){
                      echo json_encode(['data'=>'error','value'=>'Rwquest not valid','massage'=>validation_errors(),'error'=>'1']); die;
                  }



                  $dbankname =$this->input->post('dbankname');
                  $collectamount =$this->input->post('collectamount');
                  $amountRs = $this->input->post('amountRs');
                  $ddno = $this->input->post('ddno');
                  $dddate = $this->input->post('dddate');
                  $d_date = explode('/', $dddate);
                  $dd_date = $d_date[2] . '-' . $d_date[1] . '-' . $d_date[0];
                  $bd =$this->input->post('bd');
                  $total_feeeee = $this->input->post('totalamount');
                  $curdate = "$curYear-$curMonth-$curDay";

                  $ptype = $this->input->post('type');
                  $filingNo = $docrow[0]->filing_no;
                  $addparty = $docrow[0]->partys;
                  $totalanx=$docrow[0]->totalanx;
                  $pid =$docrow[0]->docids;
                  $doctype = $docrow[0]->doctype;
                  $advType = $docrow[0]->advType;
                  $partyType = $docrow[0]->partyType;
                  $undertaking = $docrow[0]->undertaking;
                  $matter =  $docrow[0]->matter;
                  $party_flag = 'P';
                  if($partyType =='2') {
                      $party_flag = 'R';
                  }
                  if($doctype=='va'){
                      $totalanx=1;
                  }
                  $valfee=$totalanx*25;
                  $totalfees=(int)$collectamount+(int)$amountRs;
                  if($totalfees < $valfee){
                      $msg="Amount shound be equal to total amount. ";
                      echo json_encode(['data'=>'error','display'=>$msg,'error'=>'1','massage'=>$msg]);die;
                  }
                  //MA filing code
                  $maFilingNo =$this->getMAFilingno($doctype,$curYear);
                  if ($doctype == 'ma' && $maFilingNo!=0) {
                      $reffFilingNo=$maFilingNo;
                      $data=array(
                          'filing_no'=>$filingNo,
                          'main_party'=>$party_flag,
                          'additional_party'=>$addparty,
                          'doc'=>$pid,
                          'total_no_annexure'=>$totalanx,
                          'ma_filing_no'=>$reffFilingNo,
                          'dt_of_filing'=>$curdate,
                          'user_id'=>$userid,
                          'doc_type'=>$doctype,
                          'matter'=>$matter,
                          'entry_date'=>$curdate,
                          //'total_fee'=>$total_feeeee,
                          'undertaking'=>$undertaking,
                      );
                      $sqlpet2 = $this->efiling_model->insert_query('ma_detail',$data);
                      if($sqlpet2){
                          $where=array('year'=>$curYear);
                          $data=array('ma_filing'=>$maFilingNo);
                          $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data);
                      }
                  }

                  //vakalatnam filing code 
                   $vaFilingNo =$this->getFilingno($doctype,$curYear);
                   if ($doctype == 'va' && $vaFilingNo!='') {
                      $reffFilingNo=$vaFilingNo;
              
                      //additional advocate insert
                      $valpart=explode(',', $addparty);
                      foreach($valpart as $cad){
                           if($cad!=''){
                              $stadv=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
                              if(!empty($stadv)){
                                  $i=1;
                                  foreach($stadv as $stadv){
                                      if($i==1){
                                          $councilCode= $stadv->council_code;
                                          $cadd = $stadv->counsel_add;
                                          $cpin =  $stadv->counsel_pin;
                                          $cmob =  $stadv->counsel_mobile;
                                          $cemail =  $stadv->counsel_email;
                                          $cfax =$stadv->counsel_fax;
                                          $counselpho =  $stadv->counsel_phone;
                                          $state = $stadv->adv_state;
                                          $dist = $stadv->adv_district;
                                      }
                                      $sqlAdditionalAdv=array(
                                          'filing_no'=>$filingNo,
                                          'party_flag'=>$party_flag,
                                          'adv_code'=>$stadv->council_code,
                                          'adv_address'=>$stadv->counsel_add,
                                          'adv_email'=>$stadv->counsel_email,
                                          'adv_fax_no'=>$stadv->counsel_fax,
                                          'adv_mob_no'=>$stadv->counsel_mobile,
                                          'adv_phone_no'=>$stadv->counsel_phone,
                                          'district'=>$stadv->adv_district,
                                          'state'=>$stadv->adv_state,
                                          'advType'=>$stadv->advType,
                                          'pin_code'=>$stadv->counsel_pin,
                                          'user_id'=>$userid,
                                          'party_code'=>$cad,
                                          'entry_date'=>date('Y-d-m'),
                                      );
                                      $st=$this->efiling_model->insert_query('additional_advocate',$sqlAdditionalAdv);
                                  $i++;}
                              }
                          }
                      } 

                      $sql = array(
                          'filing_no'=>$filingNo,
                          'party_flag'=>$party_flag,
                          'adv_code'=>$councilCode,
                          'adv_mob_no'=>$cmob,
                          'adv_phone_no'=>$counselpho,
                          'adv_fax_no'=>$cfax,
                          'adv_email'=>$cemail,
                          'adv_address'=>$cadd,
                          'user_id'=>$userid,
                          'pin_code'=>$cpin,
                          'add_party_code'=>$addparty,
                          'district'=>$dist,
                          'state'=>$state,
                          'vakalatnama_no'=>$reffFilingNo,
                          'entry_date'=>$curdate,
                          'dt_of_filing'=>$curdate,
                          'doc_type'=>$doctype,
                          'matter'=>$matter,
                          'entry_date'=>$curdate,
                          //'total_fee'=>$total_feeeee,
                          'doc_id'=>$pid,
                          'undertaking'=>$undertaking,
                      );
                      $sqlpet2 = $this->efiling_model->insert_query('vakalatnama_detail',$sql);
                      $where=array('year'=>$curYear);
                      $data=array('vakalatnama_filing'=>$vaFilingNo);
                      $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data);
                  }
                  //IA Document Upload
                  $st=$this->efiling_model->data_list_where('temp_documents_upload','salt',$salt);
                  if(!empty($st)){
                      foreach($st as $vals){
                          $data12=array(
                              'filing_no'=>$filingNo,
                              'user_id'=>$userid,
                              'valumeno'=>$vals->valumeno,
                              'document_filed_by'=>$vals->document_filed_by,
                              'document_type'=>$vals->document_type,
                              'no_of_pages'=>$vals->no_of_pages,
                              'file_url'=>$vals->file_url,
                              'display'=>$vals->display,
                              'update_on'=>$vals->update_on,
                              'matter'=>$vals->matter,
                              'doc_type'=>$vals->doc_type,
                              'ref_filing_no'=>$reffFilingNo,
                              'submit_type'=>$vals->submit_type,
                              'docid'=>$vals->docid,
                              'doc_name'=>$vals->doc_name,
                          );
                          $st=$this->efiling_model->insert_query('efile_documents_upload',$data12);
                      }
                  }
                  
                  if($amountRs!=''){
                      $data=array(
                          'other_fee'=>$amountRs,
                          'filing_no'=>$filingNo,
                          'dt_of_filing'=>$curdate,
                          'fee_amount'=>$total_feeeee,
                          'amount'=>$amountRs,
                          'payment_mode'=>$bd,
                          'branch_name'=>$dbankname,
                          'dd_no'=>$ddno,
                          'dd_date'=>$dd_date,
                          'other_document'=>$pid,
                          'reff_filing_no'=> $reffFilingNo,
                          'total_no_annexure'=>$totalanx,
                          'fee_type'=>$doctype,
                          'user_id'=>$userid,
                          'entry_date'=>$curdate,
                      );
                      $sqlpet2 = $this->efiling_model->insert_query('aptel_account_details',$data);
                  }
                  
                  
                  $doc_aptel_temp_payment =$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
                  if(!empty($doc_aptel_temp_payment)) {
                      foreach ($doc_aptel_temp_payment as  $value) {
                          $amountRs = $value->other_fee;
                          $filingNo = $filingNo;
                          $curdate = date('Y-m-d');
                          $total_feeeee = $value->total_fee;
                          $amountRs = $value->amount;
                          $bd = $value->payment_mode;
                          $dbankname = $value->branch_name;
                          $ddno = $value->dd_no;
                          $dd_date = $value->dd_date;
                          $data=array(
                              'other_fee'=>$amountRs,
                              'filing_no'=>$filingNo,
                              'dt_of_filing'=>$curdate,
                              'fee_amount'=>$total_feeeee,
                              'amount'=>$amountRs,
                              'payment_mode'=>$bd,
                              'branch_name'=>$dbankname,
                              'dd_no'=>$ddno,
                              'dd_date'=>$dd_date,
                              'other_document'=>$pid,
                              'reff_filing_no'=> $reffFilingNo,
                              'total_no_annexure'=>$totalanx,
                              'fee_type'=>$doctype,
                              'user_id'=>$userid,
                              'entry_date'=>$curdate,
                          );
                          $sqlpet2 = $this->efiling_model->insert_query('aptel_account_details',$data);
                      }
                      $this->efiling_model->delete_event('aptel_temp_payment','salt',$filingNo);
                  }
                  $data['msg']="Successfully submited";
                  $data['doc_filing']=$reffFilingNo;
                  $data['filingNo']=$filingNo;
                  $data['doc_type']=$doctype;
                  $this ->session->set_userdata('docdetail',$data);
                  $this->efiling_model->delete_event('temp_documents_upload','salt',$salt);
                  $this->efiling_model->delete_event('aptel_temp_add_advocate','salt',$salt);
                  $this->efiling_model->delete_event('temp_docdetail','salt',$salt);
                  $this->efiling_model->delete_event('aptel_temp_payment','salt',$salt);
                  echo json_encode(['data'=>'success','display'=>'','msg'=>'']);die;
              }else{
                  $msg='Request not valid!';
                  echo json_encode(['data'=>'error','display'=>$msg,'error'=>'1','massage'=>$msg]);die;
              }
          }
      }
      
      
      function  othdocsave(){
          $userdata=$this->session->userdata('login_success');
          $userid=$userdata[0]->id;
          $curYear = date('Y');
          $curMonth = date('m');
          $curDay = date('d');
          $curdate = date('Y-m-d');
          $salt= $this->session->userdata('docsalt');
          $this->form_validation->set_rules('filing_no', 'Enter valid filing no.', 'trim|required|numeric|max_length[16]');
          if($this->form_validation->run() == false){
              echo json_encode(['data'=>'error','msg'=>validation_errors(),'display'=>'','error'=>validation_errors()]);die;
          }else{
              if($userid){
                  $docrow = $this->efiling_model->data_list_where('temp_docdetail','salt',$salt);
                  if(empty($docrow)){
                      echo json_encode(['data'=>'error','value'=>'Rwquest not valid','massage'=>validation_errors(),'error'=>'1']); die;
                  }
                  $matter = $this->input->post('matter');
                  $total_feeeee = $this->input->post('doctotal_fee');
                  $curdate = "$curYear-$curMonth-$curDay";
                  $filingNo = $docrow[0]->filing_no;
                  $ptype = $_REQUEST['type'];
                  $addparty = $docrow[0]->partys;
                  $totalanx='0';
                  $pid =$docrow[0]->docids;
                  $doctype = $docrow[0]->doctype;
                  $partyType = $docrow[0]->partyType;
                  $undertaking = $docrow[0]->undertaking;
                  $party_flag = 'P';
                  if($partyType =='2') {
                      $party_flag = 'R';
                  }
                  $valfee=0;
                  $totalfees=0;
                  //MA filing code
                  $maFilingNo =$this->getDocFilingno($doctype,$curYear);
                  if ($doctype == 'oth' && $maFilingNo!=0) {
                      $reffFilingNo=$maFilingNo;
                      $data=array(
                          'filing_no'=>$filingNo,
                          'main_party'=>$party_flag,
                          'additional_party'=>$addparty,
                          'doc'=>$pid,
                          'total_no_annexure'=>$totalanx,
                          'ma_filing_no'=>$reffFilingNo,
                          'dt_of_filing'=>$curdate,
                          'user_id'=>$userid,
                          'doc_type'=>$doctype,
                          'matter'=>$matter,
                          'entry_date'=>$curdate,
                          'total_fee'=>$total_feeeee,
                          'undertaking'=>$undertaking,
                      );
                      $sqlpet2 = $this->efiling_model->insert_query('ma_detail',$data);
                      if($sqlpet2){
                          $where=array('year'=>$curYear);
                          $data=array('ma_filing'=>$maFilingNo);
                          $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data);
                      }
                  }
                  
                  //IA Document Upload
                  $st=$this->efiling_model->data_list_where('temp_documents_upload','salt',$salt);
                  if(!empty($st)){
                      foreach($st as $vals){
                          $data12=array(
                              'filing_no'=>$filingNo,
                              'user_id'=>$userid,
                              'valumeno'=>$vals->valumeno,
                              'document_filed_by'=>$vals->document_filed_by,
                              'document_type'=>$vals->document_type,
                              'no_of_pages'=>$vals->no_of_pages,
                              'file_url'=>$vals->file_url,
                              'display'=>$vals->display,
                              'update_on'=>$vals->update_on,
                              'matter'=>$vals->matter,
                              'doc_type'=>$vals->doc_type,
                              'ref_filing_no'=>$reffFilingNo,
                              'submit_type'=>$vals->submit_type,
                              'docid'=>$vals->docid,
                              'doc_name'=>$vals->doc_name,
                          );
                          $st=$this->efiling_model->insert_query('efile_documents_upload',$data12);
                      }
                  }
                  $data['msg']="Successfully submited";
                  $data['doc_filing']=$reffFilingNo;
                  $data['filingNo']=$filingNo;
                  $data['doc_type']=$doctype;
                  $this ->session->set_userdata('docdetail',$data);
                  echo json_encode(['data'=>'success','display'=>'','msg'=>'']);die;
              }else{
                  $msg='Request not valid!';
                  echo json_encode(['data'=>'error','display'=>$msg,'error'=>'1','massage'=>$msg]);die;
              }
          }
      }
      
      
      
      //Other va upload
      function getFilingno($doctype,$curYear){
          $vaFilingNo=0;
          if ($doctype == 'va') {
              $year_ins = $this->efiling_model->data_list_where('ia_initialization','year',$curYear);
              $va_filing_no = $year_ins[0]->vakalatnama_filing;
              if ($va_filing_no == 0) {
                  $vaFilingNo = 1;
              }
              if ($va_filing_no != 0) {
                  $vaFilingNo = (int)$va_filing_no + 1;
              }
          }
          return $vaFilingNo;
      }

      
      
     
      //Other MA upload
      function getMAFilingno($doctype,$curYear){
          $maFilingNo=0;
          if ($doctype == 'ma') {
              $year_ins = $this->efiling_model->data_list_where('ia_initialization','year',$curYear);
              $ma_filing_no = $year_ins[0]->ma_filing;
              if ($ma_filing_no =='0') {
                  $maFilingNo = 1;
              }
              if ($ma_filing_no != 0) {
                  $maFilingNo = (int)$ma_filing_no + 1;
              }
          }
          return $maFilingNo;
      }
     
      
      //Other document upload
      function getDocFilingno($doctype,$curYear){
          $maFilingNo=0;
          if ($doctype == 'oth') {
              $year_ins = $this->efiling_model->data_list_where('ia_initialization','year',$curYear);
              $ma_filing_no = $year_ins[0]->doc_filing;
              if ($ma_filing_no =='0') {
                  $maFilingNo = 1;
              }
              if ($ma_filing_no != 0) {
                  $maFilingNo = (int)$ma_filing_no + 1;
              }
          }
          return $maFilingNo;
      }
      
      
      function doc_finalreceipt(){
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          if($user_id){
              $this->load->view('docfiling/doc_finalreceipt');
          }
      }
      
      
      
      function docfiledcase(){
          $this->load->library('encryption');
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          if($user_id){
              $data['result']=  $this->db
                        ->select('edoc.*')
                        ->select("CASE WHEN length(cd.case_no)=15 then CONCAT(ct.short_name,'/',LTRIM(substring(cd.case_no,5,7),'0'),'/',RIGHT(cd.case_no,4)) END AS caseno")
                        ->from('efile_documents_upload as edoc')
                        ->join('case_detail as cd','cd.filing_no=edoc.filing_no','Left')
                        ->join('case_type_master as ct','ct.case_type_code=cd.case_type','Left')
                        ->where(['edoc.ref_filing_no is not null'=>null,'edoc.user_id'=>$user_id])
                        ->get();
              $data['user_id']=$user_id;
              $this->load->view("docfiling/doc_case_filed_case",$data);
          }
      }
      
      function docdetail($docid){
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          if($user_id){
              $data['docs']=  $this->efiling_model->data_list_where('ma_detail','ma_id',$docid);
              $this->load->view("docfiling/docdetail",$data);
          }
      }
      
      
      
      function va_detail($docid){
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          if($user_id){
              $data['va']=  $this->efiling_model->data_list_where('vakalatnama_detail','id',$docid);
              $this->load->view("docfiling/va_detail",$data);
          }
      }
      
      
      
      function va_case_list(){
          $userdata=$this->session->userdata('login_success');
          $user_id=$userdata[0]->id;
          if($user_id){
              $data['va']=  $this->efiling_model->data_list_where('vakalatnama_detail','user_id',$user_id);
              $this->load->view("docfiling/va_case_list",$data);
          }
      }



    function getAdvForDocs()
    {

        $key=strtolower($this->input->post('key'));
        $saltNo=$this->input->post('saltNo');
        //$tempData=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$saltNo);
        $tempData=$this->db->select('bench')->get_where('temp_docdetail',['salt'=>$saltNo])->row_array();
        $bench= $tempData['bench'];
        $benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
        $schemas=$benchData['schema_name'];

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

    function getAdvDetailForDocs(){
        $q =$this->input->Post('q');
        $saltNo =$this->input->Post('saltNo');

        $tempData=$this->db->select('bench')->get_where('temp_docdetail',['salt'=>$saltNo])->row_array();
        $bench= $tempData['bench'];
        $benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
        $schemas=$benchData['schema_name'];


        if($q!=0){
            $output = array();
            $data=$this->efiling_model->data_list_where($schemas.'.advocate_master','adv_code',$q);
            //echo $this->db->last_query();
            foreach($data as $row){
                $add= $row->address;
                $adv_name= $row->adv_name;
                $adv_code= $row->adv_code;
                $mob=$row->adv_mobile;
                $mail=$row->email;
                $ph=$row->adv_phone;
                $pin=$row->pincode;
                $fax=$row->adv_fax;
                $stateCode=$row->state_code;
                $distcode=$row->adv_dist;
                $st=$this->efiling_model->data_list_where('master_psstatus','state_code',$stateCode);
                $statename=$st[0]->state_name;
                if($distcode!=""){
                    $stdit=$this->efiling_model->getDistrictlist($stateCode,$distcode);
                    $distname=$stdit[0]->district_name;
                }
                $users_arr[] =array("address"=>$add,
                    "adv_name"=>$adv_name,
                    "adv_code"=>$adv_code,
                    "mob"=>$mob,"mail"=>$mail,"ph"=>$ph,"pin"=>$pin,"fax"=>$fax,"stcode"=>$stateCode,"stname"=>$statename,"dcode"=>$distcode,"dname"=>$distname);
            }
            echo json_encode($users_arr);
        }
    }
      
      
      
 
    
}