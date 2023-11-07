<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Refile extends CI_Controller 
{
	protected $userData;
	protected $filing_no;
	protected $schemas;
	protected $user_id;
    public function __construct()
	{
       
        parent::__construct();		
		
        $this->load->model('Admin_model','admin_model');
        $this->load->model('Efiling_model','efiling_model');

		$this->userData = $this->session->userdata('login_success');
		$this->user_id = $this->userData[0]->id;
		
		
        $this->filing_no= $this->session->userdata('refiling_no');
		//echo '<pre>';	print_r($_SESSION);die;
		if(strlen($this->session->userdata('refiling_no'))!='16')
		{
			//redirect(base_url());
		}
        if(is_numeric($this->filing_no))
        {
            $schemaData=getSingleSchemas($this->filing_no);
            $this->schemas=$schemaData['schema_name'];
        }

		$userLoginid = $this->userData[0]->loginid;
		if(empty($userLoginid)){
			redirect(base_url());
		}
				/*	$_REQUEST= array_map('strip_tags', $_REQUEST);
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
    
    
    function editbasicdetail($filing_no){
        
        $rowd= $this->efiling_model->data_list_where('table_defecttabopen','filing_no',$filing_no);
        //$this->session->set_userdata('refiling_no',$filing_no);
        if(!empty($rowd) && is_array($rowd)){
            $numbers=explode(',',$rowd[0]->tabvals);
			$this->session->set_userdata('refiling_last_tab',end($numbers));
            $numbers = array_diff($numbers, [0]);
            sort($numbers);
            $arrlength=count($numbers);
            $aval=array();
            for($x=0;$x<$arrlength;$x++){
                $aval[]=  $numbers[$x] ;
            }
			//echo $aval[0];die;
			//$this->session->set_userdata('refiling_no',$filing_no);
			if($aval[0]==1){
                $this->applicantedit();
            }else if($aval[0]==2){
                $this->respondentRefile();
            }else if($aval[0]==3){
                $this->counselrefile();
            }else if($aval[0]==4)
			{
				$this->basicDetailEditView();    
            }else if($aval[0]==5){
                $this->ia_detailrefile();
            }else if($aval[0]==6){
                $this->editother_fee();
            }else if($aval[0]==7){
                $this->documentuploadedit();
            }else if($aval[0]==8){
                $this->paymentmodeedit();
            }
        }
    }
    
    function basedetailsedit(){
        $userdata=$this->session->userdata('login_success');
        $refiling_no=$this->session->userdata('refiling_no');
        $tofilingno=$this->input->post('salt');
        if($refiling_no!=$tofilingno){
            echo json_encode(['data'=>'error','error'=>'This is not valid request!']);die;
        }
        $user_id=$userdata[0]->id;
        date_default_timezone_set('Asia/Calcutta');
        $token=$this->input->post('token'); 
        $subtoken=$this->session->userdata('submittoken');
        $act=$this->input->post('act');
        $this->form_validation->set_rules('bench', 'Choose valid Bench', 'trim|required|numeric|max_length[8]');
        $this->form_validation->set_rules('subBench', 'Choose valid sub_bench', 'trim|required|numeric|max_length[8]');
        $this->form_validation->set_rules('act', 'Choose valid Case No', 'trim|required|numeric|max_length[3]');
        $this->form_validation->set_rules('caseType', 'Choose valid case Type', 'trim|required|numeric|max_length[2]');
        $this->form_validation->set_rules('totalNoAnnexure', 'Choose valid total No Annexure', 'trim|required|numeric|max_length[3]');
        if($this->form_validation->run() == TRUE) {
            if($token==$subtoken){
                $postdata=array(
                    'bench'=>$this->input->post('bench'),
                    'sub_bench'=>$this->input->post('subBench'),
                    'case_type'=>$this->input->post('caseType'),
                    'no_of_pet'=>$this->input->post('totalNoAnnexure'),
                    'pet_sub_section'=>$this->input->post('petSubSection1'),
                    'pet_section'=>$act,
                    'act'=>$act,
                    'user_id'=>$user_id,
                    'no_of_impugned'=>$this->input->post('totalNoImpugned'),
                );
                $st=$this->efiling_model->update_data('aptel_case_detail', $postdata,'filing_no', $refiling_no);
                if($st){
                    echo json_encode(['data'=>'success','error'=>'0','db_salt'=>$refiling_no]);
                }
            }else{
                echo json_encode(['data'=>'error','error'=>'This is not valid request!']);die;
            }
        }else{
            echo json_encode(['data'=>'error','error'=>strip_tags(validation_errors())]);
        }
    }
    
	
public function basicDetailEditView()
{
		$filing_no =$this->filing_no; 
		$data['salt']=$filing_no;
		$data['casedetail'] = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$this->filing_no);
		$data['datacomm']= $this->efiling_model->data_commission_where($this->filing_no,$this->user_id);
		$data['natureorders']=getIssAuthDesignations([]);
		$data['commisions']=getIss_auth_masters([]);
		$data['impugnesArray']=getImpugnedType([]);
		$temp_chek_list=getChekListData(['filing_no'=>$this->filing_no]);
		if(!empty($temp_chek_list)):
		$data=array_merge($data,$temp_chek_list);
		endif;
		$data['requiredDocuAction']='upload_docs_modify';
		$data['requiredDocuments']=$this->db->query("SELECT	msdoc.docname,	msdoc.ID,concat ( REPLACE ( msdoc.docname, ' ', '_' ), '-', msdoc.ID ) AS docnameunder,
				(select file_url  from efile_documents_upload where filing_no='".$filing_no."' and docid=msdoc.id limit 1)  FROM master_document_efile AS msdoc WHERE msdoc.doctype = 'appRequire' ORDER BY	msdoc.priority")->result_array();	

		$this->load->view("refile/edit_basicdetail",$data);
}
    
public function applicantedit()
{
		$filing_no=$this->filing_no;
		$data['schemas']=$this->schemas;
		$data['casedetail'] = $this->efiling_model->data_list_where('case_detail','filing_no',$filing_no);
		$this->load->view("refile/applicant_edit",$data);

}
    
    
    
    function getcommeditrefile(){
       // print_r($_SESSION);

        $userdata=$this->session->userdata('login_success');
        $subtoken=$this->session->userdata('submittoken');
        $token=$this->input->post('token');
        $user_id=$userdata[0]->id;
        $id=$this->input->post('id');
        /*if($subtoken==$token){
            $data= $this->efiling_model->edit_data('additional_commision','id',$id);
            $date=array(
                'case_no' => $data->case_no,
                'decision_date' =>date('d-m-Y',strtotime($data->decision_date)),
                'case_year' =>$data->case_year,
                'commission' =>$data->commission,
                'created_user' =>$data->created_user,
                'modified_date' =>$data->modified_date,
                'created_date' =>$data->created_date,
                'modified_user' =>$data->modified_user,
                'nature_of_order' =>$data->nature_of_order,
                'lower_court_type' =>$data->case_type,
                'comm_date' =>date('d-m-Y',strtotime($data->comm_date)),
                'id'=> $data->id
            );
            echo json_encode($date);
        }else{
            echo "Request not valid!";die;
        }*/
        $refiling= $this->session->userdata('refiling_no');
        if($refiling!='')
        {
            $schemaData=getSingleSchemas($refiling);
            $schemas=$schemaData['schema_name'];

            $sth=$this->db->get_where($schemas.'.case_detail_impugned',['filing_no'=>$refiling]);

            if($sth->num_rows()>0)
            {
                $data= $sth->row();

                $date=array(
                    'case_no' =>$data->impugn_no,
                    'decision_date' =>date('d-m-Y',strtotime($data->impugn_date)),
                    'case_year' =>1990,
                    'commission' =>$data->impugn_type,
                    'created_user' =>0,
                    'modified_date' =>null,
                   'created_date' =>null,
                    'modified_user' =>0,
                    'nature_of_order' =>$data->iss_desig,
                    'lower_court_type' =>$data->impugn_type,
                    'comm_date' =>date('d-m-Y',strtotime($data->comm_date)),
                    'id'=> $id
                );
                echo json_encode($date);
            }

        }

    }
    
    
    function editSubmitcommrefile(){
        $userdata=$this->session->userdata('login_success');
        $subtoken=$this->session->userdata('submittoken');
        $token=$this->input->post('token');
        $user_id=$userdata[0]->id;
        $id=$this->input->post('id');
        $comDate=$this->input->post('comDate');
        $ddate=$this->input->post('ddate');
        
        $this->form_validation->set_rules('commission','Please enter commission','trim|required|min_length[1]|max_length[4]|numeric');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'Please enter commission','display'=>validation_errors(),'error'=>'1']);die;
        }
        $this->form_validation->set_rules('natureOrder','Please enter nature order','trim|required|min_length[1]|max_length[4]|numeric');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'Please enter nature order','display'=>validation_errors(),'error'=>'1']);die;
        }
        $this->form_validation->set_rules('case_type','Please enter case type','trim|required|min_length[1]|max_length[4]|numeric');
        if($this->form_validation->run() == FALSE){
            echo json_encode(['data'=>'error','value'=>'Please enter case type','display'=>validation_errors(),'error'=>'1']);die;
        }
        $this->form_validation->set_rules('case_no','Please enter case no','trim|required|min_length[1]|max_length[4]|numeric');
        if($this->form_validation->run() == FALSE){
            //echo json_encode(['data'=>'error','value'=>'Please enter case no','display'=>validation_errors(),'error'=>'1']);die;
        }
        $this->form_validation->set_rules('year','Please enter case year','trim|required|min_length[1]|max_length[4]|numeric');
        if($this->form_validation->run() == FALSE){
           // echo json_encode(['data'=>'error','value'=>'Please enter case year','display'=>validation_errors(),'error'=>'1']);die;
        }
        $schemaData=getSingleSchemas($this->filing_no);

        $schemas=$schemaData['schema_name'];
        
       // if($token==$subtoken){
            $array=array(
                'impugn_no'=>$this->input->post('case_no'),
                'impugn_date'=>date('Y-m-d',strtotime($ddate)),
                'comm_date'=>date('Y-m-d',strtotime($comDate)),
                'iss_org'=>$this->input->post('commission'),
                'iss_desig'=>$this->input->post('natureOrder'),
                'impugn_type'=>$this->input->post('case_type'),
               //'case_year'=>$this->input->post('year'),
            );
            //$where=array('id'=>$id);
            $where=array('filing_no'=>$this->filing_no);
        $this->db->update($where,$array);
        $this->db->where($where);
        $this->db->update($schemas.'.case_detail_impugned', $array);
       //echo $this->db->last_query();

           // $st = $this->efiling_model->update_data_where('case_detail_impugned',$where,$array);
            //$st = $this->efiling_model->update_data_where('additional_commision',$where,$array);
            $where_cond=[
                'filing_no'=>$this->filing_no,

            ];

            $data=$this->efiling_model->data_list_commission('case_detail_impugned',$where_cond);
            $natureorders=getIssAuthDesignations([]);
            $commisions=getIss_auth_masters([]);
            $impugnesArray=getImpugnedType([]);
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
                        <th>Impugn Date</th>
                        <th>Edit</th>

        	        </tr>
    	        </thead>
    	        <tbody>';
            if(!empty($data)){
                $i=1;
                foreach($data as $val){
                    $nature_of_order=$val->iss_desig;
                    $commission=$val->iss_org;
                    $casetype=$val->impugn_type;
                    if (is_numeric($nature_of_order)) {
                       // $naturname=$this->efiling_model->data_list_where('master_nature_of_order','nature_code',$nature_of_order);
                        $natshort_name=$natureorders[$nature_of_order];//$naturname[0]->short_name;
                    }
                    if (is_numeric($commission)) {
                       // $comm=$this->efiling_model->data_list_where('master_commission','id',$commission);
                        $commname=$commisions[$commission];//$comm[0]->short_name;
                    }
                    
                    if (is_numeric($casetype)) {
                        //$caseT=$this->efiling_model->data_list_where('master_case_type','case_type_code',$casetype);
                        $casetype=$impugnesArray[$casetype];//$caseT[0]->short_name;
                    }
                    
                    $html.='<tr id="tr'.$val->id.'>">
            	        <td>'.$i.'</td>
            	        <td>'.$commname.'</td>
            	        <td>'.$natshort_name.'</td>
            	        <td>'.$casetype.'</td>
            	        <td>'.$val->impugn_no.'</td>

                        <td>'.date('d-m-Y',strtotime($val->impugn_date)).'</td>
                        <td><input type="button" value="Edit" class="btn1"  data-toggle="modal" data-target="#exampleModal" onclick="editcomm('.$val->id.')">

            	        </td><td>
            	        </td>
        	        </tr>';
                    $i++;
                }
            }
            $html.='</tbody>
    	        </table>';
            echo json_encode(['result'=>$html,'rows'=>($i-1),'success'=>'Record update successfully!','data'=>'success']);

       // }
        
    }
    

    
    
    function addmorecommitionrefile(){

        $salt=$this->input->post('salt');
        $schemaData=getSingleSchemas($this->filing_no);

        $schemas=$schemaData['schema_name'];
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        if($user_id){
            $created_date=date('Y-m-d');
            $created_user=$user_id;
            $modified_date=date('Y-m-d');
            $modified_user=$user_id;
            $commdate=$this->input->post('comDate');
            $ddate=$this->input->post('ddate'); 
            $commdate=date('Y-m-d',strtotime($commdate));
            $decision_date=date('Y-m-d',strtotime($ddate));
                $postdata=array(
                    'filing_no'=>$salt,
                    'iss_org'=>$this->input->post('commission'),
                    'iss_desig'=>$this->input->post('natureOrder'),
                    'impugn_type'=>$this->input->post('case_type_lower'),
                    'impugn_no'=>$this->input->post('caseNo'),
                    'impugn_date'=>$decision_date,
                    //'created_date'=>$created_date,
                    //'created_user'=>$created_user,
                  //  'modified_date'=>$modified_date,
                    //'modified_user'=>$modified_user,
                   // 'comm_date'=>$commdate,
                  //  'addedby'=>$user_id,
                   // 'addeddate'=>date('Y-m-d'),
                   // 'addedfrom'=>'refile',
                    //'paymentstatus'=>'0',
                );

            }
            $where_cond=['filing_no'=>$salt];
             $sth=$this->db->get_where($schemas.'.case_detail_impugned',$where_cond);
        if($sth->num_rows()==0) {
            $st = $this->efiling_model->insert_query($schemas . '.case_detail_impugned', $postdata);
        }


            $data=$this->efiling_model->data_list_commission('case_detail_impugned',$where_cond);

            $html='';
            $html.='
                <div class="row inner-card" id="product">
                <h4 class="text-danger form-head" style="">Last add impugned details</h4>
                <table id="example" class="table display" cellspacing="0" border="1" width="100%">
    	        <thead>
        	        <tr class="bg-dark">
            	        <th>Sr. No. </th>
            	        <th>'.$this->lang->line('commissionLabel').'</th>
                        <th>'.$this->lang->line('natureOrder').'</th>
                        <th>'.$this->lang->line('impugnedType').'</th>
                        <th>'.$this->lang->line('impugnedOrderNo').'</th>
                        <th>Impugn Date</th>
                        <th>Edit</th>

        	        </tr>
    	        </thead>
    	        <tbody>';
            if(!empty($data)){
                $natureorders=getIssAuthDesignations([]);
                $commisions=getIss_auth_masters([]);
                $impugnesArray=getImpugnedType([]);
                $i=1;

                foreach($data as $val){
                    $nature_of_order=$val->iss_desig;
                    $commission=$val->iss_org;
                    $casetype=$val->impugn_type;
                    if (is_numeric($nature_of_order)) {
                        //$naturname=$this->efiling_model->data_list_where('master_nature_of_order','nature_code',$nature_of_order);
                        $natshort_name=$natureorders[$nature_of_order];//$naturname[0]->short_name;
                    }
                    if (is_numeric($commission)) {
                        //$comm=$this->efiling_model->data_list_where('master_commission','id',$commission);
                        $commname=$commisions[$commission];
                    }
                    if (is_numeric($casetype)) {
                       // $caseT=$this->efiling_model->data_list_where('case_type_master','case_type_code',$casetype);
                        $casetype=$impugnesArray[$casetype];//$caseT[0]->case_type_name;
                    }
                    $decision_date= date('d-m-Y',strtotime($val->impugn_date));
                    $html.='<tr id="tr'.$val->id.'>">
            	        <td>'.$i.'</td>
            	        <td>'.$commname.'</td>
            	        <td>'.$natshort_name.'</td>
            	        <td>'.$casetype.'</td>
            	        <td>'.$val->impugn_no.'</td>

                        <td>'.date('d-m-Y',strtotime($decision_date)).'</td>
                        <td><input type="button" value="Edit" class="btn1 btn btn-xs btn-warning"  data-toggle="modal" data-target="#exampleModal" onclick="editcomm('.$val->id.')">

            	        </td>
        	        </tr>';
                    $i++;
                }
            }
            $html.='</tbody>
    	        </table></div>';
            echo json_encode(['data'=>$html,'rows'=>($i-1)]);
        }
        
        

        function getApplantRefile(){
            $userdata=$this->session->userdata('login_success');
            $user_id=$userdata[0]->id;
            $refiling_no=$this->session->userdata('refiling_no');
            $tofilingno=$this->input->post('salt');
            if($refiling_no!=$tofilingno){
                echo json_encode(['data'=>'error','error'=>'This is not valid request!']);die;
            }
            $subtoken=$this->session->userdata('submittoken');
            $token=$this->input->post('token'); 
            $id=$this->input->post('id'); 
            $type=$this->input->post('type');  
            $stateid='';
            $disid='';
            if($subtoken==$token){
                if($type=='add'){
                    //$data= $this->efiling_model->edit_data($this->schemas.'.additional_party_detail','party_serial_no',$id);
                    $data=$this->db->get_where($this->schemas.'.additional_party_detail',['filing_no'=>$this->filing_no,'party_serial_no'=>$id,'party_flag'=>'P'])->row();

                    $date=array(
                        'pet_name' =>$data->name,
                        'pet_degingnation' => '',
                        'pet_address' =>$data->address,
                        'pin_code' =>$data->pin_code,
                        'pet_state' =>$data->pet_state,
                        'pet_dis' =>$data->pet_dist,
                        'pet_mobile' =>$data->pet_mobile,
                        'pet_phone' =>'',
                        'pet_email' =>$data->pet_email,
                        'pet_fax' =>'',
                        'party_id' =>$data->party_id,
                        'id'=>$id,
                        'action'=> 'edit',
                        'type'=> 'addparty',
                        'stateid' =>$data->pet_state,
                        'disid' =>$data->pet_dist,
                    );
                    echo json_encode($date);

                }
                if($type=='main'){
                    $data= $this->efiling_model->edit_data('case_detail','filing_no',$tofilingno);

                    $stateid=$data->pet_state;
                    $disid= $data->pet_district;
                    $date=array(
                        'pet_name' =>$data->pet_name,
                        'pet_degingnation' => $data->pet_degingnation,
                        'pet_address' =>$data->pet_address,
                        'pin_code' =>$data->pet_pin,
                        'pet_state' =>$data->pet_state,
                        'pet_dis' =>$data->pet_district,
                        'pet_mobile' =>$data->pet_mobile,
                        'pet_phone' =>$data->pet_phone,
                        'pet_email' =>$data->pet_email,
                        'pet_fax' =>$data->pet_fax,
                        'party_id' =>$data->pet_id,
                        'id'=> $data->salt,
                        'action'=> 'edit',
                        'state'=> $data->pet_state,
                        'dist'=> $data->pet_district,
                        'dist'=> $data->pet_type,
                        'type'=> 'mainparty',
                        'stateid' =>$data->pet_state,
                        'disid' =>$data->pet_district,
                    );
                    echo json_encode($date);
                }
            }else{
                echo "Request not valid!";die;
            }
        }
        
        
        
        
        function addMoreAppellantRefile(){
			//ini_set('display_errors',1);
           // error_reporting(E_ALL);
            date_default_timezone_set('Asia/Calcutta');
            $post_array=$this->input->post();
            $token=$this->session->userdata('tokenno');
            $userdata=$this->session->userdata('login_success');
            $user_id=$userdata[0]->id;
            $salt=$this->input->post('salt');
            $tokenno=$this->input->post('token');
            if($tokenno==$token){
                echo json_encode(['data'=>'error','error'=>'This is not valid request!']);die;
            }
            $refiling_no=$this->session->userdata('refiling_no');
            $tofilingno=$this->input->post('salt');
            if($refiling_no!=$tofilingno){
                echo json_encode(['data'=>'error','error'=>'This is not valid request!']);die;
            }

            $schemasid=substr($salt,5,1).substr($salt,0,5);
            $schemasData=getSchemasNames($schemasid);
            $schemas=$schemasData->schema_name;

            $query=$this->db->query("Select pet_name from $schemas.case_detail where filing_no='$salt'");
            $partno= $query->result();
            $valpetname=$partno[0]->pet_name;
            $petname =$this->input->post('patname'); 
            if(is_numeric($petname)){
                $hscquery = $this->efiling_model->data_list_where('org_name_master','org_code',$petname);
                $petname = $hscquery[0]->org_name;
            }
            if($valpetname!=''){
                $query=$this->db->query("Select max(party_serial_no :: INTEGER) as partysrno from $schemas.additional_party_detail where filing_no='$salt'");
                $partno= $query->result();
                if($partno[0]->partysrno ==""){
                    $partcount=2;
                }else{
                    $partcount=$partno[0]->partysrno+1;
                }
                $partyid='';
                $org=$this->input->post('org'); 
                if($org==1){

                      $partyid= $this->input->post('patname');
                }
                if($org==2){

					$partyid= $this->input->post('orgid'); 
                }
                $query_params = array(
                    'filing_no' =>$this->input->post('salt'),
                    //'pet_name' =>$petname,
                    'name' =>$petname,
                    //'pet_degingnation' => $this->input->post('petdeg'),
                    //'pet_address' =>$this->input->post('petAdv'),
                    'address' =>$this->input->post('petAdv'),
                    'pin_code' =>$this->input->post('pin'),
                    'pet_state' =>$this->input->post('dstate'),
                    'pet_dis' =>$this->input->post('ddistrict'),
                    'pet_mobile' => $this->input->post('petMob'),
                    //'pet_phone' => $this->input->post('petph'),
                    'pet_email' =>$this->input->post('petemail'),
                    //'pet_fax' =>$this->input->post('petfax'),
                    //'party_code'=>$partyid,
                   // 'partyreff'=>$partyid,
                    //'partysrno'=>$partcount,
                    'party_serial_no'=>$partcount,
                    'user_id'=>$user_id,
                    //'partyType'=>$this->input->post('org'),
                    'party_flag'=>'P',
                    //'addebby'=>$user_id,
                    //'addeddate'=>date('Y-m-d'),
                    'entry_date'=>date('Y-m-d'),
                    //'addedfrom'=>'refile',
                    //'paymentstatus'=>'0'
                );
                $st=$this->efiling_model->insert_query($schemas.'.additional_party_detail',$query_params);
                $additionalparty=$this->efiling_model->data_list_where($schemas.'.additional_party_detail','filing_no',$salt);
                $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
                if($st){
                    echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0']);
                }
            }else{
                
                $petname = $this->input->post('patname');
                if(is_numeric($petname)){
                    $hscquery = $this->efiling_model->data_list_where('org_name_master','org_code',$petname);
                    $petname = $hscquery[0]->org_name;
                }
                $org=$this->input->post('org');
                $this->session->set_userdata('org',$org);
                $query_params=array(
                    'pet_name'=>$petname,
                    'pet_address'=>$this->input->post('petAdv'),
                    //'pincode'=>$this->input->post('pin'),
                    'pet_pincode'=>$this->input->post('pin'),
                    //'petmobile'=>$this->input->post('petMob'),
                    'pet_mobile'=>$this->input->post('petMob'),
                    //'petphone'=>$this->input->post('petph'),
                    'pet_phone'=>$this->input->post('petph'),
                    'pet_email'=>$this->input->post('petemail'),
                    'pet_fax'=>$this->input->post('petfax'), 
                    //'counsel_add'=>$this->input->post('cadd'),
                   // 'counsel_pin'=>$this->input->post('cpin'),
                   // 'counsel_mobile'=>$this->input->post('cmob'),
                    //'counsel_email'=>$this->input->post('cemail'),
                    //'counsel_fax'=>$this->input->post('cfax'),
                    //'pet_degingnation'=>$this->input->post('petdeg'),
                    //'counsel_phone'=>$this->input->post('counselpho'),
                    'pet_state'=>$this->input->post('dstate'),
                    //'pet_dist'=>$this->input->post('ddistrict'),
                    'pet_district'=>$this->input->post('ddistrict'),
                    //'pet_council_adv'=>$this->input->post('councilCode'),
                    //'pet_id'=>$this->input->post('orgid'),
                    'pet_org_id'=>$this->input->post('orgid'),
                    'pet_type'=>$org,
                );
                $data_app=$this->efiling_model->update_data($schemas.'.case_detail', $query_params,'filing_no', $salt);
                $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt);
                $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
                if($data_app){
                    echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0','4 last_query'=>$this->db->last_query()]);
                }
            }
        }

        
        function editSubmitApplentRefile(){
            $userdata=$this->session->userdata('login_success');
            $salt=$this->session->userdata('refiling_no');
            $subtoken=$this->session->userdata('submittoken');
            $token=$this->input->post('token');
            $user_id=$userdata[0]->id;
            $id=$this->input->post('id');
            $petname =$this->input->post('petName'); 
            if(is_numeric($petname)){
                $hscquery = $this->efiling_model->data_list_where('org_name_master','org_code',$petname);
                $petname = $hscquery[0]->org_name;
            }

            
            $this->form_validation->set_rules('petName','Please enter Name','trim|required|min_length[1]|max_length[100]');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'Please enter Name','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            
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
            
            $this->form_validation->set_rules('orgid','Please enter valid id','trim|required|min_length[1]|max_length[4]|numeric');
            if($this->form_validation->run() == FALSE){
                //echo json_encode(['data'=>'error','value'=>'Please enter applicant','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            
            
            $edittype=$this->input->post('edittype');
            if($token==$subtoken){
                if($edittype=='addparty'){
                    $array = array(
                        'name' =>$petname,
                        //'pet_degingnation'=>$this->input->post('degingnation'),
                        'address'=>$this->input->post('petAddress'),
                        'pin_code'=>$this->input->post('pincode'),
                        'pet_state'=>$this->input->post('dstate'),
                        'pet_dis'=>$this->input->post('ddistrict'),
                        'pet_mobile'=>$this->input->post('petmobile'),
                        //'pet_phone'=>$this->input->post('petPhone'),
                        'pet_email'=>$this->input->post('petEmail'),
                        //'pet_fax'=>$this->input->post('petFax'),
                        'party_flag'=>'P',
                        'user_id'=>$user_id,
                        //'addebby'=>$user_id,
                        //'addeddate'=>date('Y-m-d'),
                        //'addedfrom'=>'refile',
                        //'paymentstatus'=>'0'
                    );
                    $where=array('filing_no'=>$this->filing_no,'party_serial_no'=>$id);
                    $st = $this->efiling_model->update_data_where($this->schemas.'.additional_party_detail',$where,$array);
                    $array=array('filing_no'=>$salt,'party_serial_no'=>$id,'party_flag'=>'P');
                    $additionalparty=$this->efiling_model->data_list_mulwhere($this->schemas.'.additional_party_detail',$array);
                    $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
                    if($st){
                        echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0','4 last_query'=>'']);
                    }
                }
                if($edittype=='mainparty'){
                    $array = array(
                        'pet_name'=>$petname,
                        //'pet_degingnation'=>$this->input->post('degingnation'),
                        'pet_address'=>$this->input->post('petAddress'),
                        'pet_pincode'=>$this->input->post('pincode'),
                        'pet_state'=>$this->input->post('dstate'),
                        'pet_district'=>$this->input->post('ddistrict'),
                        'pet_mobile'=>$this->input->post('petmobile'),
                        'pet_phone'=>$this->input->post('petPhone'),
                        'pet_email'=>$this->input->post('petEmail'),
                        'pet_fax'=>$this->input->post('petFax'),
                        //'pet_id'=>$this->input->post('petName'),
                    );
                    $where=array('filing_no'=>$salt);
                    $st = $this->efiling_model->update_data_where($this->schemas.'.case_detail',$where,$array);
                    $array=array('filing_no'=>$salt,'party_flag'=>'P');
                    $additionalparty=$this->efiling_model->data_list_mulwhere($this->schemas.'.additional_party_detail',$array);
                    $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
                    if($st){
                        echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0']);
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

        	        <th>Mobile</th>
        	        <th>Email</th>
                    <th>Edit</th>
        	        <th>Delete</th>
    	        </tr>
	        </thead>
	        <tbody>';
            
            $html.='</tbody>
	        </table>';
            $vals=$this->efiling_model->data_list_where('case_detail','filing_no',$salt);
            if($vals[0]->pet_name){
                $petName=$vals[0]->pet_name;
                if (is_numeric($vals[0]->pet_name)) {
                    $orgname=$this->efiling_model->data_list_where('org_name_master','org_code',$vals[0]->pet_name);
                    $petName=$orgname[0]->org_name;
                }
                $type="'main'";
                $html.='<tr style="color:green">
                           <td> 1</td>
                	        <td>'.$petName.'(A-1)</td>

                	        <td>'.$vals[0]->pet_mobile.'</td>
                	        <td>'.$vals[0]->pet_email.'</td>
                	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editPartyrefile('.$vals[0]->filing_no.','.$appleant.','.$type.')"></td>
                            <td></td>
                        </tr>';
            }
            if(!empty($additionalparty)){
                $i=2;
                foreach($additionalparty as $val){
                    $app="'appleant'";
                    $petName=$val->name;
                    if (is_numeric($val->name)) {
                        $orgname=$this->efiling_model->data_list_where('org_name_master','org_code',$val->pet_name);
                        $petName=$orgname[0]->org_name;
                    }
                    
                    $type="'add'";
                    $html.='<tr>
            	        <td>'.$i.'</td>
            	        <td>'.$petName.'(A-'.$i.')</td>

            	        <td>'.$val->pet_mobile.'</td>
            	        <td>'.$val->pet_email.'</td>
            	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"  data-toggle="modal" data-target="#exampleModal" onclick="editPartyrefile('.$val->party_serial_no.','.$appleant.','.$type.')"></td>
                        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deletePartyrefile('.$val->party_serial_no.','.$appleant.')"></td>
            	        </td>
        	        </tr>';
                    $i++;
                }
            }
            return $html;
        }

        function deletePartyRefile(){
            $salt=$this->input->post('salt');
            $id=$this->input->post('id');
            $schemasid=substr($salt,5,1).substr($salt,0,5);
            $schemasData=getSchemasNames($schemasid);
            $schemas=$schemasData->schema_name;
            $params=['filing_no'=>$salt,'party_serial_no'=>$id];
            $params['party_flag']='P';
            if($this->input->post('party')=='res'){
                $params['party_flag']='R';
            }
            $this->db->where($params);
            $this->db->delete($schemas.'.additional_party_detail');


            $userdata=$this->session->userdata('login_success');
            $data=$_REQUEST;
            $data['schemas']=$schemas;
            $user_id=$userdata[0]->id;
            if($user_id){
                $this->load->view("admin/deletePartyRefile",$data);
            }
        }
        
        function saveNextRefile(){
            if($this->session->userdata('login_success') && $this->input->post()) {
                $post=$this->input->post();
                $table_name=$this->input->post('table_name');
                $user_id=$this->input->post('user_id'); 
                $salt=$this->input->post('salt');
                $tab_no=$this->input->post('tab_no');
                $no_of_app=$this->input->post('no_of_app');
                $partytype=$this->input->post('partyType'); 
                $rs=$this->db->where(['filing_no'=>$salt,'user_id'=>$user_id])
                ->set(['no_of_app'=>$no_of_app,'user_id'=>$partytype])
                ->update($table_name);
				if($this->input->post('tab_no')==$this->session->userdata('refiling_last_tab')):
                    $this->setScrutinyPending($salt);
                endif;
                if($rs) 	echo json_encode(['data'=>'success','error'=>'0']);
                else 		echo json_encode(['data'=>'Query error found!','error'=>'1']);
            }
            else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
        }

        function respondentRefile(){
            $filing_no=$this->session->userdata('refiling_no');
            $userdata=$this->session->userdata('login_success');
            $user_id=$userdata[0]->id;
            if($user_id){
                $this->session->set_userdata('refiling_no',$filing_no);
                $data['casedetail'] = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
                $data['schemas']=$this->schemas;
                $this->load->view("refile/respondentRefile",$data);
            }
        }
        
        
        
        
        function addMoreResrefile(){
            $filing_no=$this->session->userdata('refiling_no');
            date_default_timezone_set('Asia/Calcutta');
            $post_array=$this->input->post();
            $userdata=$this->session->userdata('login_success');
            $user_id=$userdata[0]->id;
            $salt=$this->input->post('salt'); 
            $token=$this->input->post('token'); 
            $tokenno=$this->session->userdata('submittoken');
            if($tokenno!=$token){
                echo json_encode(['data'=>'errror','display'=>'This is not valid request.','error'=>'1']);die;
            }
            $petname =$this->input->post('resName'); 
            if(is_numeric($petname)){
                $hscquery = $this->efiling_model->data_list_where('org_name_master','org_code',$petname);
                $petname = $hscquery[0]->org_name;
            }
            $query=$this->db->query("select res_name from case_detail where filing_no='$salt'");
            $partno= $query->result();
            $pval=$partno[0]->res_name;
            if($pval!=''){
                $query=$this->db->query("Select max(party_serial_no :: INTEGER) as partysrno from $this->schemas.additional_party_detail where filing_no='$salt'");
                $partno= $query->result();
                if($partno[0]->partysrno ==""){
                    $partcount=2;
                }else{
                    $partcount=$partno[0]->partysrno+1;
                }
                $partyid='';
                $org=$this->input->post('org'); 
                if($org=='1'){
                    $partyid=$this->input->post('orgid'); 
                }
                if($org=='2'){
                    $partyid=$this->input->post('resName'); 
                }
                $query_params = array(
                    'filing_no' =>$salt,
                    'name' =>$petname,
                    //'pet_degingnation' => $this->input->post('resdeg'),
                    'address' => $this->input->post('resAddress'),
                    'pin_code' => $this->input->post('respincode'),
                    'pet_state' => $this->input->post('resState'),
                    'pet_dis' => $this->input->post('resDis'),
                    'pet_mobile' => $this->input->post('resMobile'),
                    //'pet_phone' => $this->input->post('resPhone'),
                    'pet_email' => $this->input->post('resEmail'),
                    //'pet_fax' => $this->input->post('resFax'),
                    'party_serial_no'=>$partcount,
                    'party_flag'=>'R',
                    'user_id'=>$user_id,
                    //'partyType'=> $this->input->post('org'),
                    //'party_code'=>$partyid,
                    //'partyreff'=>$partyid,
                    //'addebby'=>$user_id,
                   // 'addeddate'=>date('Y-m-d'),
                    //'addedfrom'=>'refile',
                    //'paymentstatus'=>'0',
                    'entry_date'=>date('Y-m-d'),
                );
                $st=$this->efiling_model->insert_query($this->schemas.'.additional_party_detail',$query_params);
                
                $array=array('filing_no'=>$salt,'party_flag'=>'R');
                $additionalresparty=$this->efiling_model->data_list_mulwhere($this->schemas.'.additional_party_detail',$array);
                
                $htmlrespondentparty=$this->htmaladditionalrespondentparty($additionalresparty,$salt);
                if($st){
                    echo json_encode(['data'=>'success','display'=>$htmlrespondentparty,'error'=>'0']);
                }
            }else{
                $orgres=$this->input->post('orgres');
                $this->session->set_userdata('orgres',$orgres);
                $query_params = array(
                    'res_name' =>$this->input->post('resName'),
                    'res_degingnation' =>$this->input->post('resdeg'),
                    'res_address' =>$this->input->post('resAddress'),
                    'res_pin' =>$this->input->post('respincode'), 
                    'res_state' =>$this->input->post('resState'),
                    'res_district' =>$this->input->post('resDis'),
                    'res_mobile' =>$this->input->post('resMobile'),
                    'res_phone' =>$this->input->post('resPhone'),
                    'res_email' =>$this->input->post('resEmail'),
                    'res_fax' =>$this->input->post('resFax'),
                    'user_id'=>$user_id,
                    'res_id'=>$this->input->post('orgid'),
                );
                $st=$this->efiling_model->update_data($this->schemas.'case_detail', $query_params,'filing_no', $salt);
                $array=array('filing_no'=>$salt,'party_flag'=>'R');
                $additionalresparty=$this->efiling_model->data_list_mulwhere($this->schemas.'.additional_party_detail',$array);
                
                $htmlrespondentparty=$this->htmaladditionalrespondentparty($additionalresparty,$salt);
                if($st){
                    echo json_encode(['data'=>'success','display'=>$htmlrespondentparty,'error'=>'0']);
                }
            }
        }
        
        
        
   
        
        
        
        
        function getRespondentrefile(){
            //ini_set('display_errors',1);
            //error_reporting(E_ALL);
            $userdata=$this->session->userdata('login_success');
            $subtoken=$this->session->userdata('submittoken');
            $token=$this->input->post('token'); 
            $user_id=$userdata[0]->id;
            $id=$this->input->post('id');
            $type=$this->input->post('type'); 
            if($subtoken==$token){
                if($type=='add'){
                    //$data= $this->efiling_model->edit_data('additional_party','party_serial_no',$id);
                       $data=$this->db->get_where($this->schemas.'.additional_party_detail',['filing_no'=>$this->filing_no,'party_flag'=>'R','party_serial_no'=>$id])->row();
                    $date=array(
                        'pet_name' =>$data->name,
                        'pet_degingnation' => '',
                        'pet_address' =>$data->address,
                        'pin_code' =>$data->pin_code,
                        'pet_state' =>$data->pet_state,
                        'pet_dis' =>$data->pet_dis,
                        'state'=> $data->pet_state,
                        'dist'=> $data->pet_dis,
                        'pet_mobile' =>$data->pet_mobile,
                        'pet_phone' =>$data->pet_phone,
                        'pet_email' =>$data->pet_email,
                        'pet_fax' =>$data->pet_fax,
                        'id'=> $data->party_serial_no,
                        'action'=> 'edit',
                        'type'=> 'addparty',
                    );
                    echo json_encode($date);
                }
                if($type=='main'){
                    $data= $this->efiling_model->edit_data('case_detail','filing_no',$this->filing_no);

                    $date=array(
                        'pet_name' =>$data->res_name,
                        'pet_degingnation' => '',
                        'pet_address' =>$data->res_address,
                        'pin_code' =>$data->res_pincode,
                        'pet_state' =>$data->res_state,
                        'pet_dis' =>$data->res_district,
                        'pet_mobile' =>$data->res_mobile,
                        'pet_phone' =>$data->res_phone,
                        'pet_email' =>$data->res_email,
                        'pet_fax' =>$data->res_fax,
                        'party_id' =>$data->res_org_type,
                        'id'=> $data->filing_no,
                        'action'=> 'edit',
                        'state'=> $data->res_state,
                        'dist'=> $data->res_district,
                        'res_type'=> $data->res_type,
                        'type'=> 'mainparty',
                    );
                    echo json_encode($date);
                }
            }else{
                echo "Request not valid!";die;
            }
        }
        
  
        function editSubmitRespondentrefile(){
            //ini_set('display_errors',1);
            //error_reporting(E_ALL);
            $salt=$this->session->userdata('refiling_no');
            $userdata=$this->session->userdata('login_success');
            $subtoken=$this->session->userdata('submittoken');
            $token=$this->input->post('token');
            $user_id=$userdata[0]->id;
            $id=$this->input->post('id');
            $resname = $this->input->post('resName');
            if(is_numeric($resname)){
                $hscquery = $this->efiling_model->data_list_where('org_name_master','org_code',$resname);
                $resname = $hscquery[0]->org_name;
            }

            $this->form_validation->set_rules('resMobile','Please enter mobile number','trim|required|min_length[1]|max_length[10]|numeric');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'Please enter mobile number','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            $this->form_validation->set_rules('stateRes','Please enter state','trim|required|min_length[1]|max_length[4]|numeric');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'Please enter state','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            $this->form_validation->set_rules('ddistrictname','Please enter district','trim|required|min_length[1]|max_length[4]|numeric');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'Please enter district','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            $this->form_validation->set_rules('resEmail','Please enter email','trim|valid_email|required|min_length[1]|max_length[50]');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'Please enter email','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            $this->form_validation->set_rules('resPhone','Please enter phone','trim|max_length[12]|numeric');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'Please enter phone','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            $this->form_validation->set_rules('resFax','Please enter fax','trim|max_length[12]|numeric');
            if($this->form_validation->run() == FALSE){
                echo json_encode(['data'=>'error','value'=>'Please enter fax','display'=>validation_errors(),'error'=>'1']);die;
            }
            
            $edittype= $this->input->post('edittype');
            if($token==$subtoken){
                if($edittype=='addparty'){
                    $array = array(
                        'name' =>$resname,
                        //'pet_degingnation' =>$this->input->post('degingnationRes'),
                        'address' =>$this->input->post('resAddress'),
                        'pin_code' =>$this->input->post('respincode'),
                        'pet_state' =>$this->input->post('stateRes'),
                        'pet_dis' =>$this->input->post('ddistrictres'),
                        'pet_mobile' =>$this->input->post('resMobile'),
                        'pet_phone' =>$this->input->post('resPhone'),
                        'pet_email' =>$this->input->post('resEmail'),
                        'pet_fax' =>$this->input->post('resFax'),
                        'user_id'=>$user_id,
                    );
                    $where=array('filing_no'=>$this->filing_no,'party_flag'=>'R','party_serial_no'=>$id);
                    $st = $this->efiling_model->update_data_where($this->schemas.'.additional_party_detail',$where,$array);
                    
                    $array=array('filing_no'=>$salt,'party_flag'=>'R');
                    $additionalparty=$this->efiling_model->data_list_mulwhere($this->schemas.'.additional_party_detail',$array);

                    $htmladditonalparty=$this->htmaladditionalrespondentparty($additionalparty,$salt);
                    if($st){
                        echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0']);
                    }
                }
                
                if($edittype=='mainparty'){
                    $array = array(
                        'res_name' =>$resname,
                        //'res_degingnation' =>$this->input->post('degingnationRes'),
                        'res_address' =>$this->input->post('resAddress'),
                        'res_pincode' =>$this->input->post('respincode'),
                        'res_state' =>$this->input->post('stateRes'),
                        'res_district' =>$this->input->post('ddistrictname'),
                        'res_mobile' =>$this->input->post('resMobile'),
                        'res_phone' =>$this->input->post('resPhone'),
                        'res_email' =>$this->input->post('resEmail'),
                        'res_fax' =>$this->input->post('resFax'),
                       // 'res_org_type'=>$this->input->post('resName'),
                        'user_id'=>$user_id,
                    );
                    $where=array('filing_no'=>$salt);
                    $st = $this->efiling_model->update_data_where($this->schemas.'.case_detail',$where,$array);
                    
                    $array=array('filing_no'=>$salt,'party_flag'=>'R');
                    $additionalparty=$this->efiling_model->data_list_mulwhere($this->schemas.'.additional_party_detail',$array);
                    $htmladditonalparty=$this->htmaladditionalrespondentparty($additionalparty,$salt);
                    if($st){
                        echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0']);
                    }
                }
            }
        }
        
        
        
        function htmaladditionalrespondentparty($additionalresparty,$salt){
            $appleant="'res'";
            $type="'add'";
            $html='';
            $html.='
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
    	        <thead>
        	           <th>Sr. No.</th>
                        <th>Respondent Name</th>

                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Edit</th>
                        <th>Delete</th>
    	        </thead>
	        <tbody>';
            $vals=$this->efiling_model->data_list_where('case_detail','filing_no',$salt);
            if($vals[0]->res_name!=''){
                $petName=$vals[0]->res_name;

                $type="'main'";
                $html.='<tr style="color:green">
                          <td>1</td>
                	        <td>'.$petName.'(R-1)</td>

                	        <td>'.$vals[0]->res_mobile.'</td>
                	        <td>'.$vals[0]->res_email.'</td>
                	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal"
                            data-target="#exampleModal"  onclick="editPartyrefile('.$vals[0]->filing_no.','.$appleant.','.$type.')"></td>
                            <td></td>
                        </tr>';
            }
            $html.='</tbody>
	        </table>';
            if(!empty($additionalresparty)){
                $i=2;
                foreach($additionalresparty as $val){
                    $resName=$val->name;

                    $html.='<tr>
            	        <td>'.$i.'</td>
            	        <td>'.$resName.'(R-'.$i.')</td>

            	        <td>'.$val->pet_mobile.'</td>
            	        <td>'.$val->pet_email.'</td>
            	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editPartyrefile('.$val->party_serial_no.','.$appleant.','.$type.')"></td>
                        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deletePartyrefile('.$val->party_serial_no.','.$appleant.')"></td>
            	        </td>
                    </tr>';
                    $i++;
                }
            }
            return $html;
        }
        
    
      function deleteParty()
      {

          $userdata=$this->session->userdata('login_success');
          $data=$_REQUEST;
          $user_id=$userdata[0]->id;
          if($user_id){
              $this->load->view("admin/deletePartyrRfile",$data);
          }
     }
     
     function respondentSubmitrefile(){
         date_default_timezone_set('Asia/Calcutta');
         $token=$this->session->userdata('tokenno');
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $salt=$this->input->post('salt');
         $token=$this->input->post('token');
         $tokenno=$this->session->userdata('submittoken');
         if($tokenno!=$token){
             echo json_encode(['data'=>'error','display'=>'User not valid !','error'=>'0']);
         }
         $filing_no=$this->session->userdata('refiling_no');
         if($filing_no!=$salt){
             echo json_encode(['data'=>'error','display'=>'User not valid !','error'=>'0']);
         }
         $query_params = array(
             'user_id'=>$user_id,
             'no_of_res'=>$this->input->post('totalNoRespondent'),
         );
         $st=$this->efiling_model->update_data('aptel_case_detail', $query_params,'filing_no', $salt);
         if($st){
			 if($this->input->post('tabno')==$this->session->userdata('refiling_last_tab')):
                 $this->setScrutinyPending($salt);
             endif;
             echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
         }
         else {
             echo json_encode(['data'=>'','display'=>'','error'=>'Query error in line no '.__LINE__]);
         }
         
     }
     
     
     function counselrefile(){
         $filing_no=$this->session->userdata('refiling_no');
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $this->session->set_userdata('refiling_no',$filing_no);
             $data['casedetail'] = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
             $this->load->view("refile/counselrefile",$data);
         }
     }

     function deleteAdvocaterefile(){
         $msg='';
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $salt=$this->session->userdata('refiling_no');
         $subtoken=$this->session->userdata('submittoken');
         $token=$this->input->post('token');
         $id=$this->input->post('id');
         if($token==$subtoken){
             $delete= $this->efiling_model->delete_event('additional_advocate', 'id', $id);
             if($delete){
                 $msg="Record successfully  deleted !";
                 $advocatelist=$this->efiling_model->data_list_where('additional_advocate','filing_no',$salt);
                 $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt);
                 echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
             }
         }else{
             $msg="Something went wrong";
             echo json_encode(['data'=>'','display'=>'','error'=>'1','massage'=>$msg]);die;
         }
     }
     
     
     
     
     
     
     
     
     
     
     
     function addCouncelrefile(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $salt=$this->session->userdata('refiling_no');
         $subtoken=$this->session->userdata('submittoken');
         $token=$this->input->post('token');
         $id=$this->input->post('id'); 
         $partyType=$this->input->post('partyType'); 
         $advType=$this->input->post('advType');
         if($advType=='1'){
             $councilCode= $this->input->post('councilCode');
             if(is_numeric($councilCode)){
                 $hscquery = $this->efiling_model->data_list_where('master_advocate','adv_code',$councilCode);
                 $advName = $hscquery[0]->adv_name;
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
         if($token==$subtoken){
             //Add Advocate List
             if($edittype=='add'  && $partyType!='add'){
                 $array = array(
                     'filing_no'=>$salt,
                     'adv_address'=>$this->input->post('counselAdd'),
                     'pin_code'=>$this->input->post('counselPin'),
                     'adv_mob_no'=>$this->input->post('counselMobile'),
                     'adv_email'=> $this->input->post('counselEmail'),
                     'adv_code'=>$councilCode,
                     'adv_fax_no'=>$this->input->post('counselFax'),
                     'adv_phone_no'=>$this->input->post('counselPhone'),
                     'user_id'=>$user_id,
                     'district'=>$this->input->post('cddistrict'), 
                     'state'=>$this->input->post('cdstate'),
                     'entry_date'=>date('Y-m-d'),
                     'advType'=>$advType,
                     'party_flag'=>'P',
                 );
                 $st = $this->efiling_model->insert_query('additional_advocate',$array);
                 $advocatelist=$this->efiling_model->data_list_where('additional_advocate','filing_no',$salt);
                 $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt);
                 if($st){
                     echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
                 }
             }
             //Edit Advocate List
             if($edittype=='edit' ){
                 if($partyType=='add'){
                     $id=$this->input->post('id');
                     $advid=$this->input->post('councilCode'); 
                     if($advType=='1'){
                         $councilCode= $this->input->post('councilCode'); 
                         if(is_numeric($councilCode)){
                             $hscquery = $this->efiling_model->data_list_where('master_advocate','adv_code',$councilCode);
                             $advName = $hscquery[0]->adv_name;
                         }
                     }
                     if($advType=='2'){
                         $councilCode= $this->input->post('councilCode'); 
                         if(is_numeric($councilCode)){
                             $hscquery = $this->efiling_model->data_list_where('efiling_users','id',$councilCode);
                             $advName = $hscquery[0]->fname.' '.$hscquery[0]->lname;
                         }
                     }
                     $array = array(
                         'adv_address'=>$this->input->post('counselAdd'),
                         'pin_code'=>$this->input->post('counselPin'), 
                         'adv_mob_no'=>$this->input->post('counselMobile'),
                         'adv_email'=>$this->input->post('counselEmail'),
                         'adv_code'=>$this->input->post('councilCode'),
                         'adv_fax_no'=>$this->input->post('counselFax'),
                         'adv_phone_no'=>$this->input->post('counselPhone'),
                         'user_id'=>$user_id,
                         'district'=>$this->input->post('cddistrict'), 
                         'state'=>$this->input->post('cdstate'),
                         'entry_date'=>date('Y-m-d'),
                         'advType'=>$advType,
                     );
                     $where=array('id'=>$id);
                     $st = $this->efiling_model->update_data_where('additional_advocate',$where,$array);
                     $advocatelist=$this->efiling_model->data_list_where('additional_advocate','filing_no',$salt);
                     $getAdvocatelist=$this->getAdvocatelist($advocatelist,$salt);
                     if($st){
                         echo json_encode(['data'=>'success','display'=>$getAdvocatelist,'error'=>'0']);die;
                     }
                 }
             }
         }else{
             echo json_encode(['data'=>'error','display'=>"Request not valid",'error'=>'1']);die;
         }
     }
     
     
     function getAdvDetailEditrefile(){
             $array=array();
             $userdata=$this->session->userdata('login_success');
             $salt=$this->session->userdata('refiling_no');
             $subtoken=$this->session->userdata('submittoken');
             $token=$this->input->post('token');
             $user_id=$userdata[0]->id;
             $id=$this->input->post('id');
             if($token==$subtoken){
                 $type=$this->input->post('type');
                 $advType=$this->input->post('advType');
                 if($type=='add'){
                     $st = $this->efiling_model->data_list_where('additional_advocate','id',$id);
                     if(!empty($st)){
                         $advName='';
                         if($advType==1){
                             if(is_numeric($st[0]->adv_code)){
                                 $hscquery = $this->efiling_model->data_list_where('master_advocate','adv_code',$st[0]->adv_code);
                                 $advName = $hscquery[0]->adv_name;
                             }
                         }
                         if($advType==2){
                             if(is_numeric($st[0]->adv_code)){
                                 $hscquery = $this->efiling_model->data_list_where('efiling_users','id',$st[0]->adv_code);
                                 $advName = $hscquery[0]->fname.' '.$hscquery[0]->lname;
                             }
                         }
                         
                         
                         if($st[0]->state!=''){
                             $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$st[0]->state);
                             $statename= $st2[0]->state_name;
                         }
                         if($st[0]->district!=''){
                             $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$st[0]->district);
                             $ddistrictname= $st1[0]->district_name;
                         }
                         $array = array(
                             'id'=>$st[0]->id,
                             'adv_name'=>$advName,
                             'counsel_add'=>$st[0]->adv_address,
                             'counsel_pin'=>$st[0]->pin_code,
                             'counsel_mobile'=>$st[0]->adv_mob_no,
                             'counsel_email'=>$st[0]->adv_email,
                             'council_code'=>$st[0]->adv_code,
                             'counsel_fax'=>$st[0]->adv_fax_no,
                             'counsel_phone'=>$st[0]->adv_phone_no,
                             'adv_district'=>$st[0]->district,
                             'adv_state'=>$st[0]->state,
                             'ddistrictname'=>$ddistrictname,
                             'statename'=>$statename,
                             'action'=>'edit',
                             'advType'=>$advType,
                         );
                         $data=json_encode($array);
                         $msg="Something went wrong";
                         echo json_encode(['data'=>'','display'=>$data,'error'=>'1','massage'=>$msg]);die;
                     }
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
         $main='';
         $html.='</tbody>';
         $vals=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$salt);
         $counseladd=$vals[0]->pet_adv;
         if($counseladd!=''){
             if($counseladd!=''){
                 if (is_numeric($vals[0]->pet_adv)) {
                     $orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
                     if(!empty($orgname)){
                         foreach($orgname as $appp){
                             $main='22';
                             $adv_name=$appp->adv_name;
                             $adv_reg=$appp->adv_reg;
                             $adv_mobile=$appp->adv_mobile;
                             $email=$appp->email;
                             $address=$appp->address;
                             $pin_code=$appp->adv_pin;
                             if($appp->state_code!=''){
                                 $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$appp->state_code);
                                 $statename= $st2[0]->state_name;
                             }
                             if($appp->adv_dist!=''){
                                 $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$appp->adv_dist);
                                 $ddistrictname= $st1[0]->district_name;
                             }
                         }
                     }
                 }
             }
             
             if($main==''){
                 if (is_numeric($vals[0]->pet_adv)) {
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
                    <td></td>
                </tr>';
         }
         
         $advocatelist=$this->efiling_model->data_list_where('additional_advocate','filing_no',$salt);
         if(!empty($advocatelist)){
             $i=2;
             foreach($advocatelist as $val){
                 $counseladd=$val->adv_code;
                 $advType=$val->advType;
                 if($advType=='1'){
                     if (is_numeric($val->adv_code)) {
                         $orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
                         foreach($orgname as $vak){
                             $adv_name=$vak->adv_name;
                             $adv_reg=$vak->adv_reg;
                             $address=$vak->address;
                             $pin_code=$vak->adv_pin;
                             $counselmobile=$vak->adv_mobile;
                             $counselemail=$vak->email;
                             $id=$val->id;
                             if($vak->state_code!=''){
                                 $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vak->state_code);
                                 $statename= $st2[0]->state_name;
                             }
                             if($vak->adv_dist!=''){
                                 $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vak->adv_dist);
                                 $ddistrictname= $st1[0]->district_name;
                             }
                         }
                     }
                 }
                 if($advType=='2'){
                     if (is_numeric($val->adv_code)) {
                         $orgname=$this->efiling_model->data_list_where('efiling_users','id',$counseladd);
                         $adv_name=$orgname[0]->fname.' '.$orgname[0]->lname;
                         $adv_reg=$orgname[0]->id_number.' <span style="color:red">'.$orgname[0]->idptype.'</span>';
                         $counselmobile=$orgname[0]->mobilenumber;
                         $counselemail=$orgname[0]->email;
                         $address=$orgname[0]->address;
                         $pin_code=$orgname[0]->pincode;
                         $id=$val->id;
                         if($val->state!=''){
                             $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$val->state);
                             $statename= $st2[0]->state_name;
                         }
                         if($val->district!=''){
                             $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$val->district);
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
                        <td><center><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-warning" onclick="deletePartyadv('.$id.')"></center></td>
        	        </tr>';
                 $i++;
             }
         }
         return  $html;
     }
     
     
     function orgshowresrefile(){
         $msg='';
         date_default_timezone_set('Asia/Calcutta');
         $post_array=$this->input->post();
         $token=$_REQUEST['token'];
         $salt=$_REQUEST['salt'];
         $this->session->set_userdata('salt',$salt);
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $subtoken=$this->session->userdata('submittoken');
         if($subtoken==$token){
             $msg='You are not valid';
         }
         $query_params=array(
             'user_id'=>$user_id,
         );
         $data_app=$this->efiling_model->update_data('aptel_temp_appellant', $query_params,'salt', $salt);
         if($data_app){
			  if($this->input->post('tabno')==$this->session->userdata('refiling_last_tab')):
                 $this->setScrutinyPending($salt);
             endif;
             echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
         } else{
             echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);
         }
     }
     
     function ia_detailrefile(){
         $filing_no=$this->session->userdata('refiling_no');
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $this->session->set_userdata('refiling_no',$filing_no);
             $data['casedetail'] = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
             $this->load->view("refile/ia_detailrefile",$data);
         }
     }
     
     
     function editiasubmit(){
         $filing_no=$this->session->userdata('refiling_no');
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $defective= $this->efiling_model->defectivelistdfr($filing_no);
         if(!empty($defective) && is_array($defective)){
             $array=array('filing_no'=>$filing_no,'ia_nature'=>'22');
             $valsd=$this->efiling_model->data_list_mulwhere('ia_detail',$array);
             if(is_array($valsd) && empty($valsd)){
                 if($defective[0]->defects=='Y'){
                     $date1= date('d-m-Y',strtotime($defective[0]->notification_date));
                     $date2 = strtotime($date1);
                     $duedateaa = strtotime("+28 day", $date2);
                     $duwdateval= date('Y-m-d', $duedateaa);
                     $currentdate=date('Y-m-d');
                     if($duwdateval<$currentdate){
                         echo json_encode(['data'=>'error','error'=>'1','display'=>'Please file condonation of delay !']);die;
                     }else{
                         echo json_encode(['data'=>'success','display'=>'success','error'=>'0']);die;
                     }
                 }else{
                     echo json_encode(['data'=>'success','display'=>'success','error'=>'0']);die;
                 }
             }else{
                 echo json_encode(['data'=>'success','display'=>'success','error'=>'0']);die;
             }
         }else{
             echo json_encode(['data'=>'error','display'=>'This Filing number is not registerd !','error'=>'1']);die;
         }
     }
     
     
     
     
     
     function editother_fee(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $data[]='';
             $this->load->view("refile/editother_fee",$data);
         }
     }
     
     function otherFeesaveedit(){
         $filing_no=$this->session->userdata('refiling_no');
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
         } else{
             echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);
         }
     }
     
     
     function documentuploadedit(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $data[]='';
             $this->load->view("refile/documentuploadedit",$data);
         }
     }
     
     
     function viewUpdListEdit(){
         $filing_no=$this->session->userdata('refiling_no');
         if($this->session->userdata('login_success') && $this->input->post('saltId') > 0){

             $user_id=(int)$this->session->userdata('login_success')[0]->id;
             $type=$this->input->post('type');
             $warr=array('filing_no'=>$filing_no,'user_id'=>$user_id,'display'=>'Y','submit_type'=>$type);
             $docData =$this->efiling_model->list_uploaded_docs('efile_documents_upload',$warr);

             if($docData)
                 echo json_encode(['data'=>@$docData,'error'=>'0']);
                 else echo json_encode(['data'=>'Data not found.','error'=>'1']);
         }
         else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
     }
     
     
     
     function viewUpdListEditOld(){

         $filing_no=$this->session->userdata('refiling_no');
         if($this->session->userdata('login_success') && $this->input->post('saltId') > 0){
             $salt=$this->input->post('saltId');
             $user_id=(int)$this->session->userdata('login_success')[0]->id;
             $type=$this->input->post('type');
             $warr=array('filing_no'=>$filing_no,'user_id'=>$user_id,'display'=>'Y','submit_type'=>$type);
             $docData =$this->efiling_model->list_uploaded_docs('efile_documents_upload_old',$warr);
             if($docData)
                 echo json_encode(['data'=>@$docData,'error'=>'0']);
                 else echo json_encode(['data'=>'Data not found.','error'=>'1']);
         }
         else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
     }
     
     
     
     
     
     public function uploaded_docs_displayEdit($id){
         error_reporting(0);
         $this->db->select('file_url');
         $this->db->from("efile_documents_upload as od");
         $this->db->where(['id'=>$id,'user_id'=>$this->userData[0]->id]);
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
     
     public function uploaded_docs_displayEditold($id){
         error_reporting(0);
         $this->db->select('file_url');
         $this->db->from("efile_documents_upload_old as od");
         $this->db->where(['id'=>$id,'user_id'=>$this->userData[0]->id]);
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
     
     
     
     
     
     
    public function uploaded_docs_deleteEdit(){
         
         if($this->session->userdata('login_success') && (int)$this->input->post('docId') > 0){
             $id=(int)$this->input->post('docId');
             $url=$this->db->where('id',$id)
             ->get('efile_documents_upload')
             ->row_array();
             //->file_url;
             $sth = $this->db->insert('efile_documents_upload_old',$url);
             /*if(file_exists($url)){
                 if(unlink($url)) {

                     $this -> db -> where('id', $id);
                     $this -> db -> delete('efile_documents_upload');
                     $msg ='Record Deleted successfully';
                 }
                 echo json_encode(['data'=>'Success','error'=>'0','msg'=>$msg]);
             }else{*/
             if($this->db->affected_rows()>0){
                 $this -> db -> where('id', $id);
                 $this -> db -> delete('efile_documents_upload');
                 $msg ='Record Deleted successfully';
                 echo json_encode(['data'=>'Success','error'=>'0','msg'=>$msg]);
             }
         }
         else echo json_encode(['data'=>'Error!','error'=>'1','msg'=>'error']);
     }
     
     
     function doc_save_nextedit(){
         $msg='';
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $filing_no=$this->session->userdata('refiling_no');
         $post_array=$this->input->post();
         $token=$this->input->post('token');
         $subtoken=$this->session->userdata('submittoken');
         if($subtoken!=$token){
             echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);
         }
         $query_params=array(
             'addedfrom'=>'refile',
             'addeddate'=>date('Y-m-d'),
             'addedby'=>$user_id,
         );
         $data_app=$this->efiling_model->update_data('efile_documents_upload', $query_params,'filing_no', $filing_no);
         if($data_app){
			  if($this->input->post('tabno')==$this->session->userdata('refiling_last_tab')):
                 $this->setScrutinyPending($filing_no);
             endif;
             echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
         } else{
             echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);
         }
     }
     
     
     function paymentmodeedit(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $data[]='';
             $filingdata=$this->db->select('case_type,pet_type')->get_where($this->schemas.'.case_detail',['filing_no'=>$this->filing_no])->row_array();
             $checkListdata=$this->db->get_where($this->schemas.'.check_list_customs',['filing_no'=>$this->filing_no])->row_array();
             switch($filingdata['pet_type']):
                 case 2://mean public
                     $pet_type=1;$res_type=2;
                     break;
                 default: //mean department
                     $pet_type=2;$res_type=1;
             endswitch;

             //$tempImpugnedData=getTempImpugned(['filing_no'=>$this->filing_no]);
             //if(!empty($tempImpugnedData)):
                 $feeData=$this->efiling_model->feeCalculate(['caseType'=>$filingdata['case_type'],
                     'partyType'=>$pet_type,'tempFeeData'=>$checkListdata
                 ]);

                 if(array_key_exists('success',$feeData)):
                     $data['appealFee']= $feeData['feeAmount'];
                 else:
                     $data['appealFee']= 0;
                 endif;
             //endif;

             $this->load->view("refile/paymentmodeedit",$data);
         }
     }
     
     
     function payfeedetailsaveedit(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $filing_no=$this->session->userdata('refiling_no');
         $token=$this->input->post('token');
         $totalFee=$this->input->post('totalFee');
         $otherFee=$this->input->post('otherFee');
         $subtoken=$this->session->userdata('submittoken');
         if($subtoken!=$token){
             echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);die;
         }
         if($user_id){
             if($totalFee==0 && $otherFee==0){
                 $successreff= rand(15,$filing_no);
                 $ip = $_SERVER['REMOTE_ADDR'];
                 $reff=array(
                     'filing_no'=>$filing_no,
                     'entry_date'=>date('Y-m-d'),
                     'user_id'=>$user_id,
                     'status'=>'1',
                     'ip'=>$ip,
                     'totalfee'=>$totalFee,
                     'refilerefference'=>rand(15,$successreff),
                     'paymentstatus'=>'success',
                 );
                 $refilearray=array(
                     'filing_no'=>$filing_no,
                     'reff'=>$successreff,
                     'reffdate'=>date('Y-m-d'),
                     'paystatus'=>'success',
                 );
                 $this->session->set_userdata('refiledetail',$refilearray);
                 $st=$this->efiling_model->insert_query('refiledetail',$reff); 
                 if($st){
                     $postdata=array(
                         'is_refile'=>'1',
                         'flag'=>'1',
                         'refile_date'=>date('Y-m-d'),
                         'refile_by'=>$user_id,
                         'refile_ip'=>$ip,
                     );
                     $st=$this->efiling_model->update_data('aptel_case_detail', $postdata,'filing_no', $filing_no);
                     echo json_encode(['data'=>'success','display'=>'success','error'=>'0']);die;
                 }
             }
             echo json_encode(['data'=>'success','display'=>'','error'=>'0']);die;
         } else{
             echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);die;
         }
     }
     
     
     function paypageedit(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $data['schemas']=$this->schemas;
             $filingdata=$this->db->select('case_type,pet_type')->get_where($this->schemas.'.case_detail',['filing_no'=>$this->filing_no])->row_array();
             $checkListdata=$this->db->get_where($this->schemas.'.check_list_customs',['filing_no'=>$this->filing_no])->row_array();
             switch($filingdata['pet_type']):
                 case 2://mean public
                     $pet_type=1;$res_type=2;
                     break;
                 default: //mean department
                     $pet_type=2;$res_type=1;
             endswitch;

             //$tempImpugnedData=getTempImpugned(['filing_no'=>$this->filing_no]);
             //if(!empty($tempImpugnedData)):
             $feeData=$this->efiling_model->feeCalculate(['caseType'=>$filingdata['case_type'],
                 'partyType'=>$pet_type,'tempFeeData'=>$checkListdata
             ]);

             if(array_key_exists('success',$feeData)):
                 $data['appealFee']= $feeData['feeAmount'];
             else:
                 $data['appealFee']= 0;
             endif;
             //endif;
             $this->load->view("refile/paypageedit",$data);
         }
     }
     
     
     
     function postalorderfinaledit(){
         $app['app']=htmlentities($_REQUEST['app']);
         $this->load->view('refile/postalorderfinaledit',$app);
     }
     
     
     function efilingfinalsubmitEdit(){

         $filing_no=$this->session->userdata('refiling_no');
         $paymentstatus='';
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $this->form_validation->set_rules('sql','Filing number not valid','trim|required|min_length[1]|max_length[16]|numeric');
         if($this->form_validation->run() == FALSE){
             echo json_encode(['data'=>'error','value'=>'Filing number not valid','display'=>validation_errors(),'error'=>'1']);die;
         }
         $this->form_validation->set_rules('bd','Please enter payment mode','trim|required|min_length[1]|max_length[1]|numeric');
         if($this->form_validation->run() == FALSE){
             echo json_encode(['data'=>'error','value'=>'Please enter payment mode','display'=>validation_errors(),'error'=>'1']);die;
         }
         
         $this->form_validation->set_rules('ddno','Please enter NTRP number','trim|required|min_length[1]|max_length[13]|is_unique[aptel_account_details.dd_no]');
         if($this->form_validation->run() == FALSE){
             echo json_encode(['data'=>'error','value'=>'Please enter NTRP number','display'=>validation_errors(),'error'=>'1']);die;
         }
         
         $this->form_validation->set_rules('amountRs','Please enter Amount Rs','trim|required|min_length[1]|max_length[7]|numeric');
         if($this->form_validation->run() == FALSE){
             echo json_encode(['data'=>'error','value'=>'Please enter Amount Rs','display'=>validation_errors(),'error'=>'1']);die;
         }
         $salt= $this->input->post('sql');
         $this->db->trans_start();
         $countcomm=0;
         $commFee=0;
         /*$query="select * from additional_commision where  filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
         $data=$this->db->query($query);
         if($data->num_rows()>0) {
             $countcomm= count($data->result());
             $commFee=$countcomm*100000;
         }
         */
         $appFee=0;
         /*$queryApp="select * from additional_party where party_flag='1' AND filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
         $data=$this->db->query($queryApp);
         if($data->num_rows()>0) {
             $countapp= count($data->result());
             if($countapp>5){
                 $appFee=$countapp*5000;
             }
         }
         */
         $otherFee2=0;
         $resFee=0;
        /* $queryRes="select * from additional_party where party_flag='2' AND filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
         $data=$this->db->query($queryRes);
         if($data->num_rows()>0) {
             $countres= count($data->result());
             if($countres>5){
                 $resFee=$countres*5000;
             }
         }*/


         $filingdata=$this->db->select('case_type,pet_type')->get_where($this->schemas.'.case_detail',['filing_no'=>$this->filing_no])->row_array();
         $checkListdata=$this->db->get_where($this->schemas.'.check_list_customs',['filing_no'=>$this->filing_no])->row_array();
         switch($filingdata['pet_type']):
             case 2://mean public
                 $pet_type=1;$res_type=2;
                 break;
             default: //mean department
                 $pet_type=2;$res_type=1;
         endswitch;

         //$tempImpugnedData=getTempImpugned(['filing_no'=>$this->filing_no]);
         //if(!empty($tempImpugnedData)):
         $feeData=$this->efiling_model->feeCalculate(['caseType'=>$filingdata['case_type'],
             'partyType'=>$pet_type,'tempFeeData'=>$checkListdata
         ]);


         if(array_key_exists('success',$feeData)):
             $data['appealFee']= $feeData['feeAmount'];
         else:
             $data['appealFee']= 0;
         endif;
         //endif;


         //$appealFee= $commFee+$appFee+$resFee;
         $appealFee= $data['appealFee'];

         /*allready paid*/
         $partialpay=0;
         $partialquery = $this->db->select_sum("amount")
             ->from($this->schemas.".fee_detail")
             ->where(['filing_no'=>$this->filing_no])
             ->get();
         if($partialquery->num_rows()>0){ $partialpay=$partialquery->row_array()['amount']; }

         $total=@$appealFee+$otherFee2-$partialpay;
         if($total > $this->input->post('amountRs')){
             echo json_encode(['data'=>'error','value'=>'amount should be equal to total amount!','display'=>'amount should be equal to total amount!','error'=>'1']);die;
         }




         if($this->input->post('sql')!=''){
             $account=array(
                 'filing_no'=>$this->input->post('sql'),
                 'todays_date'=>date('Y-m-d'),
                 'tot_amount'=>$total,
                 'payment_mode'=>$this->input->post('bd'),
                 'dd_no'=>$this->input->post('ddno'),
                 'dd_date'=>$this->input->post('dddate'),
                 'dd_bank'=>null,
                 'amount'=>$this->input->post('amountRs'),
                 'fees_type'=>1,
                 'user_id'=>$user_id,
                 'display'=>false,
             );
             $st=$this->efiling_model->insert_query($this->schemas.'.fee_detail',$account); //New Offline payment code
             if($st){
                $paymentstatus='success'; 
             }
             $successreff= rand(15,$this->input->post('sql'));
             $ip = $_SERVER['REMOTE_ADDR'];
             $reff=array(
                 'filing_no'=>$this->input->post('sql'),
                 'entry_date'=>date('Y-m-d'),
                 'user_id'=>$user_id,
                 'status'=>'1',
                 'ip'=>$ip,
                 'totalfee'=>$total,
                 'refilerefference'=>rand(15,$this->input->post('sql')),
                 'paymentstatus'=>$paymentstatus,
             );
             $refilearray=array(
                 'filing_no'=>$this->input->post('sql'),
                 'reff'=>$successreff,
                 'reffdate'=>date('Y-m-d'),
                 'paystatus'=>$paymentstatus,
             );
             $this->session->set_userdata('refiledetail',$refilearray);
             $st=$this->efiling_model->insert_query('refiledetail',$reff); 
             if($st){
                 $postdata=array(
                     'addedfrom'=>'',
                 );
                // $st=$this->efiling_model->update_data('additional_party', $postdata,'filing_no', $this->input->post('sql'));
             }
             
             if($st){
                 $postdata=array(
                     'is_refile'=>'1',
                     'flag'=>'1',
                     'refile_date'=>date('Y-m-d'),
                     'refile_by'=>$user_id,
                     'refile_ip'=>$ip,
                 );
                 $st=$this->efiling_model->update_data('aptel_case_detail', $postdata,'filing_no', $this->input->post('sql'));
                 echo json_encode(['data'=>'success','display'=>$successreff,'error'=>'0']);
             }
             $this->db->trans_complete();
             
             
         }else{
             echo json_encode(['data'=>'error','value'=>'filing number not valid','display'=>'filing number not valid','error'=>'1']);die;
         }
     }
     
     
     
     function refilesuccess(){
        
             $data[]='';
             $this->load->view("refile/refilesuccess",$data);
         
     }
     
     
    
     
     function refilereceipt($filingno){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $data['filingno']=$filingno;
             $this->load->view("refile/refilereceipt",$data);
         }
     }
  
     
     




    public function editBasicDetails(){


        $salt=$this->input->post('saltNo');
        $caseType=$this->input->post('caseType');
        $sectionFiledset=$this->input->post('fieldset');

        //$schemasid=substr($salt,5,1).substr($salt,0,5);
       // $schemasData=getSchemasNames($schemasid);
        $schemas=$this->schemas;


        switch($sectionFiledset):
            case 111:
			
					$token=$this->input->post('token');
					$subtoken=$this->session->userdata('submittoken');
					$act=$this->input->post('act');
				   // $this->form_validation->set_rules('bench', 'Choose valid Bench', 'trim|required|numeric|max_length[8]');
					//$this->form_validation->set_rules('subBench', 'Choose valid sub_bench', 'trim|required|numeric|max_length[8]');
					$this->form_validation->set_rules('act', 'Choose valid Case No', 'trim|required|numeric|max_length[3]');
					$this->form_validation->set_rules('caseType', 'Choose valid case Type', 'trim|required|numeric|max_length[2]');
					//$this->form_validation->set_rules('totalNoAnnexure', 'Choose valid total No Annexure', 'trim|required|numeric|max_length[3]');
					if($this->form_validation->run() == TRUE) {
						if($token==$subtoken){
							$postdata=array(
								'case_type'=>$this->input->post('caseType'),
								'pet_sub_section'=>$this->input->post('petSubSection1'),
								'pet_section'=>$act,
								'act'=>$act,
							);
							$st=$this->efiling_model->update_data('aptel_case_detail', $postdata,'filing_no', $this->filing_no);

								if($this->db->affected_rows() > 0){
									echo json_encode(['success'=>'true',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
								
							}
						}else{
							echo json_encode(['data'=>'error','error'=>'This is not valid request!']);die;
						}
					}else{
						echo json_encode(['data'=>'error','error'=>strip_tags(validation_errors())]);
					}																		

                break;
            case 112:
                
                if($this->form_validation->run('basicChecklist') == FALSE)
                {

                    echo json_encode(['error'=>validation_errors(),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
                }

                $temp_cheklist=[
						'ass_org'=> ($this->input->post('ass_org')!='')?$this->input->post('ass_org'):0,
						'add_comm'=> ($this->input->post('add_comm')!='')?$this->input->post('add_comm'):null,
						'adj_org'=> ($this->input->post('adj_org')!='')?$this->input->post('adj_org'):0,
						'adj_desig'=> ($this->input->post('adj_desig')!='')?$this->input->post('adj_desig'):0,
						'ass_desig'=> ($this->input->post('ass_desig')!='')?$this->input->post('ass_desig'):0,
						'app_quest'=> ($this->input->post('app_quest')!='')?$this->input->post('app_quest'):null,
						'applic_dispensed'=> ($this->input->post('applic_dispensed')!='')?$this->input->post('applic_dispensed'):0,
						'ce_duty'=> ($this->input->post('ce_duty')!='')?$this->input->post('ce_duty'):0,
						'st_duty'=> ($this->input->post('st_duty')!='')?$this->input->post('st_duty'):0,
						'cu_pri_imp1'=> ($this->input->post('cu_pri_imp1')!='')?$this->input->post('cu_pri_imp1'):0,
						'cu_pri_imp2'=> ($this->input->post('cu_pri_imp2')!='')?$this->input->post('cu_pri_imp2'):0,
						'cu_pri_exp1'=> ($this->input->post('cu_pri_exp1')!='')?$this->input->post('cu_pri_exp1'):0,
						'cu_pri_exp2'=> ($this->input->post('cu_pri_exp2')!='')?$this->input->post('cu_pri_exp2'):0,
						'cu_pri_gen1'=> ($this->input->post('cu_pri_gen1')!='')?$this->input->post('cu_pri_gen1'):0,
						'cu_pri_gen2'=> ($this->input->post('cu_pri_gen2')!='')?$this->input->post('cu_pri_gen2'):0,
						'cea_code'=> ($this->input->post('ass_code')!='')?$this->input->post('ass_code'):null,
						'sta_code'=> ($this->input->post('sta_code')!='')?$this->input->post('sta_code'):null,
						'oio_count'=> ($this->input->post('oio_count')!='')?$this->input->post('oio_count'):null,
						'iec_code'=>$this->input->post('iec_code'),
						'loc_c'=>$this->input->post('loc_code'),
						
					];
					if($this->input->post('pan_code')!=''){
							$temp_cheklist['pan_code']=decodePan($this->input->post('pan_code'));
						}


                $query=$this->db->get_where($schemas.'.check_list_customs',['filing_no'=>$salt]);

                if($query->num_rows()>0):
                    $this->db->where(['filing_no'=>$salt])->update($schemas.'.check_list_customs',$temp_cheklist);
                else:
                    $this->db->insert($schemas.'.check_list_customs',array_merge(['filing_no'=>$salt],$temp_cheklist));
                endif;

                if($this->db->affected_rows() > 0){
                    echo json_encode(['success'=>'true',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
                }else{
                    echo json_encode(['error'=>'Something went wrong !',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
                }


                break;
            case 113:

                if($this->form_validation->run('basicDescription') == FALSE)
                {
                    echo json_encode(['error'=>validation_errors(),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
                }
				$temp_cheklist=[
						'goods'=>($this->input->post('goods')!='')?$this->input->post('goods'):null,
						'classification'=>($this->input->post('classification')!='')?$this->input->post('classification'):null,
						'dispute_st_dt'=>($this->input->post('dispute_st_dt')!='')?date('Y-m-d',strtotime($this->input->post('dispute_st_dt'))):null,
						'dispute_en_dt'=>($this->input->post('dispute_en_dt')!='')?date('Y-m-d',strtotime($this->input->post('dispute_en_dt'))):null,
						'duty_tax_ord'=>($this->input->post('duty_tax_ord')!='')?$this->input->post('duty_tax_ord'):0,
						'duty_tax_pd'=>($this->input->post('duty_tax_pd')!='')?$this->input->post('duty_tax_pd'):0,
						'refund_ord'=>($this->input->post('refund_ord')!='')?$this->input->post('refund_ord'):0,
						'refund_pd'=>($this->input->post('refund_pd')!='')?$this->input->post('refund_pd'):0,
						'fine_int_ord'=>($this->input->post('fine_int_ord')!='')?$this->input->post('fine_int_ord'):0,
						'fine_int_pd'=>($this->input->post('fine_int_pd')!='')?$this->input->post('fine_int_pd'):0,
						'penalty_ord'=>($this->input->post('penalty_ord')!='')?$this->input->post('penalty_ord'):0,
						'penalty_pd'=>($this->input->post('penalty_pd')!='')?$this->input->post('penalty_pd'):0,
						'mkt_value'=>($this->input->post('mkt_value')!='')?$this->input->post('mkt_value'):0,
						'inter_ord'=>($this->input->post('inter_ord')!='')?$this->input->post('inter_ord'):0,
						'inter_pd'=>($this->input->post('inter_pd')!='')?$this->input->post('inter_pd'):0,
						'rp_ord'=>($this->input->post('rp_ord')!='')?$this->input->post('rp_ord'):0,
						'rp_pd'=>($this->input->post('rp_pd')!='')?$this->input->post('rp_pd'):0,
						'pay_mode_duty'=>($this->input->post('pay_mode_duty')!='')?$this->input->post('pay_mode_duty'):0,
						'pay_mode_penalty'=>($this->input->post('pay_mode_penalty')!='')?$this->input->post('pay_mode_penalty'):0,
						'case_type'=>($this->input->post('caseType')!='')?$this->input->post('caseType'):0,
						'iec_code'=>$this->input->post('iec_code'),
						'loc_c'=>$this->input->post('loc_code'),
					];
					if($this->input->post('pan_code')!=''){
							$temp_cheklist['pan_code']=decodePan($this->input->post('pan_code'));
						}
               
                $query=$this->db->get_where($schemas.'.check_list_customs',['filing_no'=>$salt,'case_type'=>$caseType]);

                if($query->num_rows()>0):
                    $this->db->where(['filing_no'=>$salt,'case_type'=>$caseType])->update($schemas.'.check_list_customs',$temp_cheklist);
                else:
                    $this->db->insert($schemas.'.check_list_customs',array_merge(['filing_no'=>$salt,'case_type'=>$caseType],$temp_cheklist));
                endif;
                if($this->db->affected_rows() > 0){
                    echo json_encode(['success'=>'true',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
                }else{
                    echo json_encode(['error'=>'Something went wrong !',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
                }
				break;
				default:
						$params=['filing_no'=>$salt,"docid in (select id from master_document_efile where doctype='appRequire')"=>null];
						$getRequiredDoc= $this->db->get_where('efile_documents_upload',$params)->result_array();
						
						
						//chek required doc
						$docRequire =$this->db->select("id")->get_where('master_document_efile',['doctype' =>'appRequire']);
						
						if(count($getRequiredDoc)< $docRequire->num_rows()):
						echo json_encode(['error'=>'Please Upload All Documents First','a'=>$this->db->last_query(),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
						else:	
							  if($this->input->post('tabno')==$this->session->userdata('refiling_last_tab')):
							$this->setScrutinyPending($salt);
						endif;							
						echo json_encode(['success'=>'true',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
						endif;
						

        endswitch;
    }
	
	
	
	public function upload_docs_modify()
	{	
	
		if($this->form_validation->run('requireDocument') == FALSE)
		{
			echo json_encode(['error'=>strip_tags(validation_errors()),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
		}				 
		list($docmentTagName,$docmentTagId)=explode("-",$this->input->post('filename'));
					
				  $fl_path=UPLOADPATH.'/';
				  $schemas=$this->input->post('bench').'/';
				  $step1=$fl_path.$schemas;
				  $salt=$this->input->post('salt');
				  $step2=$step1.$salt.'/appellants/A1/';	
				  if(!is_dir($step2)) {
					  mkdir($step2, 0777, true);
				  }
				  $docname=$_FILES['userfile']['name'];
				  $array=explode('.',$_FILES['userfile']['name']);
				  $config['upload_path']   		= $step2;
				  $config['allowed_types'] 		= 'pdf';
				  $config['max_size']      		= '199999';
				  $config['overwrite']	   		= TRUE;
				  $config['file_ext']	= 'pdf';
				  $config['file_ext_tolower']	= TRUE;
				  $config['file_name']=$docmentTagName;
	
				  $this->load->library('upload', $config);
				  if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
						  echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']); 
				  else 	{
					 $final_doc_url=$this->upload->data('file_name');
					$pages=$this->countPages($step2.$final_doc_url);
						$data=array(
							'filing_no' 		=>$salt, 
							'user_id' 					=>$this->user_id, 
							'document_filed_by' 	=>'appellants',
							'no_of_pages'           =>$pages,
							'file_url' 				=>$step2.$final_doc_url,							
						    'document_type' 			=>$config['file_name'],
						    'doc_name'              =>$docname,
							'docid'=>$docmentTagId,'submit_type'=>'APPR',
							 'update_on'=>date('Y-m-d h:i:s'),'addedfrom'=>'refile','addeddate'=>date('Y-m-d'),'addedby'=>$this->user_id,
						);
					$sth = $this->db->get_where("efile_documents_upload",['filing_no'=>"$salt",'docid'=>$docmentTagId]);
					
					if($sth->num_rows() >0):
						$this->db->where(['filing_no'=>"$salt",'docid'=>$docmentTagId])->update('efile_documents_upload',$data);						
						else:
						$this->db->insert('efile_documents_upload',$data);
						endif;
						//echo $this->db->last_query();
						
					  	echo json_encode(['data'=>'success','error' => '0','file_name'=>base64_encode($step2.$final_doc_url)]);die;
				  }
				
			
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
	
	function countPages($path) {
		  
		    $pdftext = file_get_contents($path);
		    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
		    return $num;
		}
	function setScrutinyPending($filing_no)
    {
        //if($this->input->post('tab_no')==$this->session->userdata('refiling_last_tab')):
        $this->db->where(['filing_no'=>$filing_no])->update('scrutiny',['objection_status'=>null]);
        //endif;
		 $ip = $_SERVER['REMOTE_ADDR'];
		 $reff=array(
                     'filing_no'=>$filing_no,
                     'entry_date'=>date('Y-m-d'),
                     'user_id'=>$this->user_id,
                     'status'=>'1',
                     'ip'=>$ip,
                     'totalfee'=>0,
                     'refilerefference'=>'',
                     'paymentstatus'=>'success',
                 );                 
                 $st=$this->efiling_model->insert_query('refiledetail',$reff);
				 $postdata=array(
                         'is_refile'=>'1',
                         'flag'=>'1',
                         'refile_date'=>date('Y-m-d'),
                         'refile_by'=>$this->user_id,
                         'refile_ip'=>$ip,
                     );
                     $st=$this->efiling_model->update_data('aptel_case_detail', $postdata,'filing_no', $filing_no);
		
    }
		
		
     
     
     
     
}
    
?>