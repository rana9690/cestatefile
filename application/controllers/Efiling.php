

<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Efiling extends MY_Controller {
		 public function __construct() {
			
	        parent::__construct();
	        $this->load->model('Admin_model','admin_model');
	        $this->load->model('Efiling_model','efiling_model');	

	    }

	
	    function dashboard(){
			if($this->userData[0]->is_password==0){
				redirect(base_url('change_password'));
				exit;
			}
			$params=$cdparams=$appparams=$codparams=$cdregparams=[];
		$getparams=$this->efiling_model->getRoleBasedParams();
		extract($getparams);
		
				$data['appDraft']= $this->efiling_model->getDrafAppList($params,'count(salt)as count')->row_array()['count'];
		$data['applDraft']= $this->efiling_model->getDratApplList(array_merge(["cd.type not in ('1','6')"=>null],$params),'count(salt)as count')->row_array()['count'];
		$data['codDraft']= $this->efiling_model->getDraftCodFList(array_merge(["cd.type"=>'1'],$params),'count(salt)as count')->row_array()['count'];

		$data['apeeal']= $this->efiling_model->getAppFiledList($cdparams,'count(cd.filing_no)as count')->row_array()['count'];
		$data['appl']= $this->efiling_model->getApplFiledList($appparams,'count(app.appfiling_no)as count')->row_array()['count'];
		$data['cod']= $this->efiling_model->getCodFiledList($codparams,'count(cod.appfiling_no)as count')->row_array()['count'];

		$data['appDef']= $this->efiling_model->getAppFiledList(array_merge(['sc.objection_status'=>'Y'],$cdparams),'count(cd.filing_no)as count')->row_array()['count'];
		$data['applDef']= $this->efiling_model->getApplFiledList(array_merge(['sc.objection_status'=>'Y'],$appparams),'count(app.appfiling_no)as count')->row_array()['count'];
		$data['codDef']= $this->efiling_model->getCodFiledList(array_merge(['sc.objection_status'=>'Y'],$codparams),'count(cod.appfiling_no)as count')->row_array()['count'];

		$data['appScrutiny']= $this->efiling_model->getAppFiledList(array_merge(['sc.objection_status'=>null],$cdparams),'count(cd.filing_no)as count')->row_array()['count'];
		$data['applScrutiny']= $this->efiling_model->getApplFiledList(array_merge(['sc.objection_status'=>null],$appparams),'count(app.appfiling_no)as count')->row_array()['count'];
		$data['codScrutiny']= $this->efiling_model->getCodFiledList(array_merge(['sc.objection_status'=>null],$codparams),'count(cod.appfiling_no)as count')->row_array()['count'];

		$data['appRegis']= $this->efiling_model->getAppFiledList(array_merge(['length(cd.case_no)>10'=>null],$cdregparams),'count(cd.filing_no)as count')->row_array()['count'];
		$data['applRegis']= $this->efiling_model->getApplFiledList(array_merge(['length(app.appno)>10'=>null],$appparams),'count(app.appfiling_no)as count')->row_array()['count'];
		$data['codRegis']= $this->efiling_model->getCodFiledList(array_merge(['length(cod.appno)>10'=>null],$codparams),'count(cod.appfiling_no)as count')->row_array()['count'];



    	        $this->load->view("admin/dashboardview",$data);
	        
	    }
	    

	    function undersection(){
			$data['dtls']=getUnderSection($this->input->post());//$this->efiling_model->undersection($this->input->post());
			$data[$this->security->get_csrf_token_name()]=$this->security->get_csrf_hash();
			echo json_encode($data);

	    }
        
	    function document_upload_epcprpia(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	           $this->load->view('admin/document_upload_epcprpia');
	        }
	    }
	    
	    
	   function addmorecommition(){
	       $salt=$this->session->userdata('salt');
	       $userdata=$this->session->userdata('login_success');
	       $user_id=$userdata[0]->id;
	       //$this->session->set_userdata('salt',$salt);
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
	                'salt'=>$salt,
	                'commission'=>$this->input->post('commission'),
	                'nature_of_order'=>$this->input->post('natureOrder'),
	                'lower_court_type'=>$this->input->post('case_type_lower'),
	                'case_no'=>$this->input->post('caseNo'),
	                'case_year'=>$this->input->post('caseYear'),
	                'decision_date'=>$decision_date,
	                'created_date'=>$created_date,
	                'created_user'=>$created_user,
	                'modified_date'=>$modified_date,
	                'modified_user'=>$modified_user,
	                'comm_date'=>$commdate,
	            );

				$where_cond=[
							'created_user'=>$user_id,
							'commission'=>$this->input->post('commission'),
							'nature_of_order'=>$this->input->post('natureOrder'),
							'lower_court_type'=>$this->input->post('case_type_lower'),
							'case_no'=>$this->input->post('caseNo'),
							'case_year'=>$this->input->post('caseYear'),
							'decision_date'=>$decision_date,
							'comm_date'=>$commdate
				];
				
	            $data=$this->efiling_model->data_list_commission('aptel_temp_commision',$where_cond);
				if(!$data) {
	            	$st=$this->efiling_model->insert_query('aptel_temp_commision',$postdata);			
				} 
				if((int)$salt==0) $salt='0';
				$where_cond=[
						'created_user'=>$user_id,
						'salt'=>$salt
				];
				$data=$this->efiling_model->data_list_commission('aptel_temp_commision',$where_cond);	
				
	            $html='';
	            
	            $html.='
 				<h4 class="text-danger form-head" style="">Last add impugned details</h4>
                <table id="example" class="table display" cellspacing="0" border="1" width="100%">
    	        <thead>
        	        <tr class="bg-dark">
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
                        <td>'.date('d-m-Y',strtotime($decision_date)).'</td>
                        <td><input type="button" value="Edit" class="btn1 btn btn-xs btn-warning"  data-toggle="modal" data-target="#exampleModal" onclick="editcomm('.$val->id.')">
            	        <td><input type="button" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deletecomm('.$val->id.')">

            	        </td>
        	        </tr>';
	                    $i++;
	                }
	            }
	            $html.='</tbody>
    	        </table>';
	            //echo   $html;
				echo json_encode(['data'=>$html,'rows'=>($i-1),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
	        }
	    }


	    
	    
	    function deleteComm(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $id=$this->input->post('id');
	        $salt=$this->input->post('salt');
	           if($user_id){
	               $pay= $this->efiling_model->delete_event('aptel_temp_commision', 'id', $id);
	               if($pay){
	                   $data=$this->efiling_model->data_list_commission('aptel_temp_commision',['created_user'=>$user_id,'salt'=>$salt]);
    	            $html='';   
    	            $html.='<h4 class="text-danger form-head" style="">Last add impugned details</h4>
                    <table id="example" class="table display" cellspacing="0" border="1" width="100%">
        	        <thead>
            	        <tr class="bg-dark">
                	        <th>Sr.No.</th>
                	        <th>Commission</th>
                	        <th>Nature of order</th>
                	        <th>Court case type</th>
                	        <th>Case no</th>
                	        <th>Case Year</th>
                            <th>Decision Date</th>
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
    	                    if (is_numeric($nature_of_order)) {
    	                        $naturname=$this->efiling_model->data_list_where('master_nature_of_order','nature_code',$nature_of_order);
    	                        $natshort_name=$naturname[0]->short_name;
    	                    }          
    	                    if (is_numeric($commission)) {
    	                        $comm=getIss_auth_master(['org_code'=>$commission]);//$this->efiling_model->data_list_where('master_commission','id',$commission);
    	                        $commname=$comm[0]['org_name'];
    	                    }
    	                    
    	                    if (is_numeric($casetype)) {
    	                        $caseT=getCaseTypes(['case_type_code'=>$casetype]);//$this->efiling_model->data_list_where('master_case_type','case_type_code',$casetype);
    	                        $casetype=$caseT[0]['short_name'];
    	                    }
    	                    
    	                    $html.='<tr>
                	        <td>'.$i.'</td>
                	        <td>'.$commname.'</td>
                	        <td>'.$natshort_name.'</td>
                	        <td>'.$casetype.'</td>
                	        <td>'.$val->case_no.'</td>
                            <td>'.$val->case_year.'</td>
                            <td>'.date('d-m-Y',strtotime($val->decision_date)).'</td>
                	        <td><input type="button" value="Delete" class="btn1" onclick="deletecomm('.$val->id.')">

                	        </td>
            	        </tr>';
    	                    $i++;
    	                }
    	            }
    	            $html.='</tbody>
    	        </table>';
	            echo   $html;
	            }
	        }
	    }
	    
	    function orgdetail(){
	        $this->load->view('admin/orgdetail');
	    }
	    
	    function appellantDetail(){
	        $this->load->view('admin/appellantDetail');
	    }
	    
	    function orgNdetail(){
	        $users_arr=array();
            $q = $_REQUEST['q'];
            if ($q != 0) {
                $output = array();
                $data=$this->efiling_model->data_list_where('master_org','org_id',$q);
                foreach($data as $row){
                    $add = $row->org_address;
                    $org_name = $row->org_name;
                    $mob = $row->mobile_no;
                    $mail = $row->email;
                    $ph = $row->phone_no;
                    $pin = $row->pin;
                    $fax = $row->fax;
                    $stateCode = $row->state;
                    $distcode = $row->district;
                    $orgdesg = $row->org_desg;
                    $state=$this->efiling_model->data_list_where('master_psstatus','state_code',$stateCode);
                    $statename = $state[0]->state_name;
          
                    $distname = '';
                    if ($distcode != "") {
                        $stdit=$this->efiling_model->data_list_where('master_psdist','district_code',$distcode);
                        $distname = $stdit[0]->district_name;
                    }
                    if ($distname != '') {
                        $distname = $distname;
                    }
                    if ($mob == '0') {
                        $mob = '';
                    }
                    if ($fax == '0') {
                        $fax = '';
                    }
                    if ($ph == '0') {
                        $ph = '';
                    }
                    $users_arr[] = array("orgid"=>$q,'org_name'=>$org_name,"address" => $add, "mob" => $mob, "mail" => $mail, "ph" => $ph, "pin" => $pin, "fax" => $fax, "stcode" => $stateCode, "stname" => $statename, "dcode" => $distcode, "dname" => $distname, "desg" => $orgdesg);
                }
                echo json_encode($users_arr);
            }
	    }
	    
	    
	    function getAdvDetail(){
	        $q =$this->input->post('q');
	       // $saltNo =$this->input->Post('saltNo');

			//$tempData=$this->db->select('bench')->get_where('aptel_temp_appellant',['salt'=>$saltNo])->row_array();
			///$bench= $tempData['bench'];
			////$benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
			//$schemas=$benchData['schema_name'];


	        if($q!=0){
	            $output = array();
	            //$data=$this->efiling_model->data_list_where($schemas.'.advocate_master','adv_code',$q);
				$this->db->select("adv.*,state.state_name,district.district_name");
				$this->db->from('master_advocate as adv');
				$this->db->join('master_psstatus as state','adv.state_code=state.state_code','left');
				$this->db->join('master_psdist as district','adv.state_code=state.state_code','left');
				$this->db->where(['adv_code'=>$q]);
				$this->db->limit(1);
	            $data=$this->db->get()->result();
				//echo $this->db->last_query();
	            foreach($data as $row){
	                $add= $row->address;
	                $adv_name= $row->adv_name;
	                $adv_code= $row->adv_code;
	                $mob=$row->adv_mobile;
	                $mail=$row->email;
	                $ph=$row->adv_phone;
	                $pin=$row->adv_pin;
	                $fax=$row->adv_fax;
	                $stateCode=$row->state_code;
	                $distcode=$row->adv_dist;
					 $distname=$row->district_name;
					 $statename=$row->state_name;
	               
	                $users_arr[] =array("address"=>$add,
	                    "adv_name"=>$adv_name,
	                    "adv_code"=>$adv_code,
	                    "mob"=>$mob,"mail"=>$mail,"ph"=>$ph,"pin"=>$pin,"fax"=>$fax,"stcode"=>$stateCode,"stname"=>$statename,"dcode"=>$distcode,"dname"=>$distname);
	            }
	            echo json_encode($users_arr);
	        }
	    }

		function getAdvDetailrpcp(){
			$q =$this->input->Post('q');
			$saltNo =$this->input->Post('saltNo');

			$tempData=$this->db->select('bench')->get_where('rpepcp_reffrence_table',['salt'=>$saltNo])->row_array();
			$bench= $tempData['bench'];
			$benchData=$this->db->select('schema_name')->get_where('initilization',['schemaid'=>$bench])->row_array();
			$schemas=$benchData['schema_name'];


			if($q!=0){
				$output = array();
				$data=$this->efiling_model->data_list_where($schemas.'.advocate_master','adv_code',$q);
				foreach($data as $row){
					$add= $row->address;
					$adv_name= $row->adv_name;
					$adv_code= $row->adv_code;
					$mob=$row->adv_mobile;
					$mail=$row->email;
					$ph=$row->adv_phone;
					$pin=$row->adv_pin;
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
	    function  district(){
	        $state=$this->input->post('state_id');
	        $st=$this->efiling_model->data_list_where('master_psdist','state_code',$state);
	        $val='';
	        if(!empty($st)){
                foreach($st as $row){
                    $val.='<option value="'.$row->district_code.'">'.$row->district_name.'</option>';
                }
            }

			echo json_encode(['dtls'=>$val,$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
	    }
	    
	    
	    function  districtselected(){
	        $state=$this->input->post('stateid');
	        $districtid=$this->input->post('districtid');
	        $st=$this->efiling_model->data_list_where('master_psdist','state_code',$state);
	        $val='';
	       
	        if(!empty($st)){
	            foreach($st as $row){
	                $selected='';
	                if($districtid==$row->district_code){
	                    $selected="selected";
	                }
	                $val.='<option value="'.$row->district_code.'" '.$selected.'>'.$row->district_name.'</option>';
	            }
	        }
	       // echo  $val;
			echo json_encode(['dtls'=>$val,$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
	    }
	    
	    
	    function orgdetailres(){
	        $this->load->view('admin/orgdetailres');
	    }
	    
	    function respondentDetail(){
	        $this->load->view('admin/respondentDetail');
	    }
	    
	    function postalOrder(){
	        $app['app']=$_REQUEST['app'];
	        $this->load->view('admin/postalOrder',$app);
	    }
	    

		function orgshow(){

		}
	    
	    function base_details(){   	
			//ini_set('display_errors',1);
			//error_reporting(E_ALL);		
			//echo'<pre>'; print_r($this->input->post()); exit();
	        date_default_timezone_set('Asia/Calcutta');
	        $post_array=$this->input->post();
	        $token=$_REQUEST['token'];
	        $act=isset($_REQUEST['act'])?$_REQUEST['act']:'';
			
	        $saltval=$this->session->userdata('salt');
	        $userdata=$this->session->userdata('login_success');  
	        $user_id=$userdata[0]->id;

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
	            $this->session->set_userdata('salt',$salt);
	        }
			else $salt=$saltval;

	        //$token=$this->session->userdata('tokenno');
	        $return ='';
	        //if($tokenno==$token){
	           // $return['msg']='You are not valid';
	       // } 

	        $this->form_validation->set_rules('bench', 'Choose valid Bench', 'trim|required|numeric|max_length[8]');
	        $this->form_validation->set_rules('subBench', 'Choose valid sub_bench', 'trim|required|numeric|max_length[8]');
	        $this->form_validation->set_rules('act', 'Choose valid Case No', 'trim|required|numeric|max_length[3]');
	        $this->form_validation->set_rules('caseType', 'Choose valid case Type', 'trim|required|numeric|max_length[2]');
	        $this->form_validation->set_rules('totalNoAnnexure', 'Choose valid total No Annexure', 'trim|required|numeric|max_length[3]');
	        //$this->form_validation->set_rules('petSubSection1', 'Choose valid  Total No IA', 'trim|required|numeric|max_length[2]');
	        if($this->form_validation->run() == TRUE) {
	            $postdata=array(
	                'salt'=>$salt,
	                'bench'=>$this->input->post('bench'),
	                'sub_bench'=>$this->input->post('subBench'),
	                'l_case_no'=>$this->input->post('caseNo'),
	                'l_case_year'=>$this->input->post('caseYear'),
	                'l_case_type'=>$this->input->post('caseType'),
	                'l_date'=>$this->input->post('ddate111'),
	                'no_of_pet'=>$this->input->post('totalNoAnnexure'),      
	                'comm_date'=>$this->input->post('comDate'),
	                'commission'=>$this->input->post('comm'),
	                'nature_of_order'=>$this->input->post('order'),
	                'lower_case_type'=>$this->input->post('oth'),
	                'petsubsection'=>$this->input->post('petSubSection1'),
	                'petsection'=>$this->input->post('petSec'),
	                'tab_no'=>$this->input->post('tabno'),
	                'act'=>$act,
 	                'user_id'=>$this->user_id,
                    'no_of_impugned'=>$this->input->post('totalNoImpugned'),
	            );

				//$commission_array=$post_array['commission_array'];
				$commission_array['salt']=$salt;
				$commission_array['created_user']=$user_id;
				$commission_array['modified_user']=$user_id;
				$commission_array['modified_date']=date('Y-m-d');
				$commission_array['created_date']=date('Y-m-d');

				//echo  $salt.'***<pre>'; print_r($commission_array); exit();

				$fnd=$this->db->where('salt',$salt)->get('aptel_temp_appellant');
	            if($fnd->num_rows() > 0){
	                $st=$this->efiling_model->update_data('aptel_temp_appellant', $postdata,'salt', $salt);
	            }else{
	                $st=$this->efiling_model->insert_query('aptel_temp_appellant',$postdata);
	            }
				if(!empty($post_array['commission_array']) && is_array($post_array['commission_array'])) {	
					$this->efiling_model->insert_query('aptel_temp_commision', $commission_array);			
					//$this->efiling_model->update_data_where('aptel_temp_commision', ['salt'=>'0','created_user'=>$user_id] ,['salt'=>$salt]);
				}							
				$this->efiling_model->update_data_where('aptel_temp_commision', ['salt'=>'0','created_user'=>$user_id] ,['salt'=>$salt]);

	            if($st){
	                echo json_encode(['data'=>'success','error'=>'0','db_salt'=>$salt]);
	            }
	        }else{
	            echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        }
	    }
        
	    
		function orgshowres(){
		    //ini_set('display_errors', 1);
		    //ini_set('display_startup_errors', 1);
		    //error_reporting(E_ALL);
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
				'tab_no'=>$_REQUEST['tabno']
			);
			$data_app=$this->efiling_model->update_data('aptel_temp_appellant', $query_params,'salt', $salt);
			if($data_app){
				echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
			} else{
				echo json_encode(['data'=>'error','error'=>'DB Error found in line no '.__LINE__]);
			}
		}
	    
	    public function save_next(){
			if($this->input->post()) {
				$post=$this->input->post();
				$table_name=$post['table_name'];
				$user_id=$post['user_id'];
				$salt=$post['salt'];
				$tab_no=$post['tab_no'];
				$no_of_app=$post['no_of_app'];
				$partytype=$post['partyType'];
				
				$rs=$this->db->where(['salt'=>$salt,'user_id'=>$user_id])
				->set(['tab_no'=>$tab_no,'no_of_app'=>$no_of_app,'filed_by'=>$partytype])
			    ->update($table_name);
				//echo $this->db->last_query();
				if($rs) 	echo json_encode(['data'=>'success','error'=>'0']);
				else 		echo json_encode(['data'=>'Query error found!','error'=>'1']);
			}
			else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
		}	    
	    
	    
	  function addMoreAppellant(){
		  //ini_set('display_errors',1);
		  //error_reporting(E_ALL);
		
	        date_default_timezone_set('Asia/Calcutta');
	        $post_array=$this->input->post();
	        $token=$this->session->userdata('tokenno');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $salt=$this->input->post('salt');
	        $token=$this->input->post('token');

	        $query=$this->db->query("Select pet_name from aptel_temp_appellant where salt='$salt'");
	        $partno= $query->result();
	        $valpetname=$partno[0]->pet_name;
	        
	        $petname = htmlspecialchars($_REQUEST['patname']);
	        if(is_numeric($petname)){
	            $hscquery = $this->efiling_model->data_list_where('master_org','org_id',$petname);
	            $petname = $hscquery[0]->orgdisp_name;
	        }
	        
   
	        if($valpetname!=''){
	            $query=$this->db->query("Select max(partysrno :: INTEGER) as partysrno from aptel_temp_additional_party where salt='$salt'");
	            $partno= $query->result();
	            if($partno[0]->partysrno ==""){
	                $partcount=2;
	            }else{
	                $partcount=$partno[0]->partysrno+1;
	            }
	            $partyid='';
	            if($this->input->post('org')=='1'){
	               $partyid= $this->input->post('orgid');
	            }
	            if($this->input->post('org')=='2'){
	                $partyid= $this->input->post('patname');
	            }
    	        $query_params = array(
    	            'salt' => $this->input->post('salt'),
    	            'pet_name' =>$petname,
    	            'pet_degingnation' => $this->input->post('petdeg'),
    	            'pet_address' =>$this->input->post('petAdv'),
    	            'pin_code' =>$this->input->post('pin'),
    	            'pet_state' =>$this->input->post('dstate'),
    	            'pet_dis' =>$this->input->post('ddistrict'),
    	            'pet_mobile' => $this->input->post('petMob'),
    	            'pet_phone' => $this->input->post('petph'),
    	            'pet_email' =>$this->input->post('petemail'),
    	            'pet_fax' => $this->input->post('petfax'),
    	            'counsel_add' => $this->input->post('cadd'),
    	            'counsel_pin' => $this->input->post('cpin'),
    	            'counsel_mobile' => $this->input->post('cmob'),
    	            'counsel_phone' => $this->input->post('counselpho'),
    	            'counsel_email' => $this->input->post('cemail'),
    	            'counsel_fax' =>$this->input->post('cfax'),
    	            'council_code' => $this->input->post('councilCode'),
    	            'party_id'=>$partyid,
    	            'partysrno'=>$partcount,
    	            'user_id'=>$user_id,
    	            'partyType'=>$this->input->post('org'),
				
    	        );
				
    	        $st=$this->efiling_model->insert_query('aptel_temp_additional_party',$query_params);
    	        $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt);
    	        $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
    	        if($st){
    	            echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0','3 last_query'=>$this->db->last_query()]);
    	        }  
	        }else{

 				$petname = $this->input->post('patname');
	            if(is_numeric($petname)){
	                $hscquery = getOrg_name_master(['org_code'=>$petname]);//$this->efiling_model->data_list_where('master_org','org_id',$petname);
	                $petname = $hscquery[0]->orgdisp_name;
	            }

	            
	            $org=$this->input->post('org');
	            $this->session->set_userdata('org',$org);
	            $query_params=array(
	                'pet_name'=>$petname,
	                'pet_address'=>$this->input->post('petAdv'),
	                'pincode'=>$this->input->post('pin'),
	                'petmobile'=>$this->input->post('petMob'),
	                'petphone'=>$this->input->post('petph'),
	                'pet_email'=>$this->input->post('petemail'),
	                'pet_fax'=>$this->input->post('petfax'),
	                'counsel_add'=>$this->input->post('cadd'),
	                'counsel_pin'=>$this->input->post('cpin'),
	                'counsel_mobile'=>$this->input->post('cmob'),
	                'counsel_email'=>$this->input->post('cemail'),
	                'counsel_fax'=>$this->input->post('cfax'),
	                'pet_degingnation'=>$this->input->post('petdeg'),
	                'counsel_phone'=>$this->input->post('counselpho'),
	                'pet_state'=>$this->input->post('dstate'),
	                'pet_dist'=>$this->input->post('ddistrict'),
	                'pet_council_adv'=>$this->input->post('councilCode'),
	                'pet_id'=>($this->input->post('orgid'))?$this->input->post('orgid'):0,
	                'pet_type'=>$org,
	            );
	            
	            $data_app=$this->efiling_model->update_data('aptel_temp_appellant', $query_params,'salt', $salt);
                $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt);
	            $htmladditonalparty=$this->htmaladditionalparty($additionalparty,$salt);
	            if($data_app){
	                echo json_encode(['data'=>'success','display'=>$htmladditonalparty,'error'=>'0',
						$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
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
	        $vals=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	        if($vals[0]->pet_name){
	            $petName=$vals[0]->pet_name;
	            if (is_numeric($vals[0]->pet_name)) {
	                $orgname=$this->efiling_model->data_list_where('master_org','org_id',$vals[0]->pet_name);
	                $petName=$orgname[0]->org_name;
	            }
	            $type="'main'";
	            $html.='<tr style="color:green">
                           <td> 1</td>
                	        <td>'.$petName.'(A-1)</td>
                	       
                	        <td>'. $vals[0]->petmobile.'</td>
                	        <td>'.$vals[0]->pet_email.'</td>
                	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editParty('.$vals[0]->salt.','.$appleant.','.$type.')"></td>
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
    	        $html.='<tr>
            	        <td>'.$i.'</td>
            	        <td>'.$petName.'(A-'.$i.')</td>
            	        
            	        <td>'.$val->pet_mobile.'</td>
            	        <td>'.$val->pet_email.'</td>
            	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning"  data-toggle="modal" data-target="#exampleModal" onclick="editParty('.$val->id.','.$appleant.','.$type.')"></td>
                        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deleteParty('.$val->id.','.$appleant.')"></td>
            	        </td>
        	        </tr>';
    	        $i++;
    	        }
             } 
       
	        return $html;
	    }	    
	    
	    function respondentSubmit(){
	        date_default_timezone_set('Asia/Calcutta');
	        $post_array=$this->input->post();
	        $token=$this->session->userdata('tokenno');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $salt=$_REQUEST['salt'];
	        
			$query_params = array(
				'user_id'=>$user_id,
				'no_of_res'=>@$_REQUEST['totalNoRespondent'],
				'tab_no'=>$_REQUEST['tabno'],
			);
			$st=$this->efiling_model->update_data('aptel_temp_appellant', $query_params,'salt', $salt);
			if($st){
				echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
			}
			else {
				echo json_encode(['data'=>'','display'=>'','error'=>'Query error in line no '.__LINE__]);
			}

	    }	    

	  function addMoreRes(){
		 
	        date_default_timezone_set('Asia/Calcutta');
	        $post_array=$this->input->post();
	        $token=$this->session->userdata('tokenno');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $salt=$this->input->post('salt');
	       
	        $petname = $this->input->post('resName');
	        if(is_numeric($petname)){
	            $hscquery =getOrg_name_master(['org_code'=>$petname]);// $this->efiling_model->data_list_where('master_org','org_id',$petname);
	            $petname = $hscquery[0]->orgdisp_name;
	        }
	        $query=$this->db->query("select resname from aptel_temp_appellant where salt='$salt'");
	        $partno= $query->result();
	        $pval=$partno[0]->resname;
	        if($pval!=''){
    	        $query=$this->db->query("Select max(partysrno :: INTEGER) as partysrno from aptel_temp_additional_res where salt='$salt'");
    	        $partno= $query->result();
    	        if($partno[0]->partysrno ==""){
    	            $partcount=2;
    	        }else{
    	            $partcount=$partno[0]->partysrno+1;
    	        }
    	        
    	        $partyid='';
    	        if($this->input->post('org')=='1'){
    	            $partyid= $this->input->post('orgid');
    	        }
    	        if($this->input->post('org')=='2'){
    	            $partyid= $this->input->post('resName');
    	        }
	            $query_params = array(
	                'salt' => $this->input->post('salt'),
	                'res_name' =>$petname,
	                'res_degingnation' => $this->input->post('resdeg'),
	                'res_address' => $this->input->post('resAddress'),
	                'res_code' =>$this->input->post('respincode'),
	                'res_state' =>$this->input->post('resState'),
	                'res_dis' =>$this->input->post('resDis'),
	                'res_mobile' => $this->input->post('resMobile'),
	                'res_phone' => $this->input->post('resPhone'),
	                'res_email' =>$this->input->post('resEmail'),
	                'res_fax' =>$this->input->post('resFax'),
	                'partysrno'=>$partcount,
	                'party_id'=>$partyid,
	                'partysrno'=>$partcount,
	                'user_id'=>$user_id,
	                'partyType'=>$this->input->post('org'),				
					
	            );
	            $st=$this->efiling_model->insert_query('aptel_temp_additional_res',$query_params);
	            $additionalresparty=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt',$salt);
	            $htmlrespondentparty=$this->htmaladditionalrespondentparty($additionalresparty,$salt);
	            if($st){
	                echo json_encode(['data'=>'success','display'=>$htmlrespondentparty,'error'=>'0']);
	            }
	        }else{
	            $orgres=$this->input->post('orgres');
	            $this->session->set_userdata('orgres',$orgres);
	            $query_params = array(
	                'salt' => $this->input->post('salt'),
	                'resname' =>$this->input->post('resName'),
	                'res_degingnation' => $this->input->post('resdeg'),
	                'res_address' => $this->input->post('resAddress'),
	                'res_pin' =>$this->input->post('respincode'),
	                'res_state' =>$this->input->post('resState'),
	                'res_dis' =>$this->input->post('resDis'),
	                'res_mobile' => $this->input->post('resMobile'),
	                'res_phone' => $this->input->post('resPhone'),
	                'res_email' =>$this->input->post('resEmail'),
	                'res_fax' => $this->input->post('resFax'),
	                'user_id'=>$user_id,
	                'tab_no'=>$this->input->post('tabno'),
	            );
	            $st=$this->efiling_model->update_data('aptel_temp_appellant', $query_params,'salt', $salt);
                    $additionalresparty=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt',$salt);
	            $htmlrespondentparty=$this->htmaladditionalrespondentparty($additionalresparty,$salt);
	            if($st){
	                echo json_encode(['data'=>'success','display'=>$htmlrespondentparty,'error'=>'0',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
	            }
	        }
	  }
	   

	    
	    function htmaladditionalrespondentparty($additionalresparty,$salt){
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
                	        
                	        <td>'.$vals[0]->res_mobile.'</td>
                	        <td>'.$vals[0]->res_email.'</td>
                	        <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editParty(0,'.$type.','.$type.')"></td>
                            <td></td>
                        </tr>';
                  }
               $html.='</tbody>
	        </table>';
               
               if(!empty($additionalresparty)){
                   $i=2;
                   foreach($additionalresparty as $val){
                       $appleant="'res'";
                       $type="'add'";
                       $resName=$val->res_name;
                       if (is_numeric($val->res_name)) {
                           $orgname=$this->efiling_model->data_list_where('master_org','org_id',$val->res_name);
                           $resName=$orgname[0]->orgdisp_name;
                       }
                       $html.='<tr>
            	        <td>'.$i.'</td>
            	        <td>'.$resName.'(R-'.$i.')</td>
            	        
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

	    
	    function iasubmit(){
	        date_default_timezone_set('Asia/Calcutta');
	        $post_array=$this->input->post();
	        $token=$this->session->userdata('tokenno');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $salt=$_REQUEST['salt'];
	        $token=$_REQUEST['token'];
	        if($tokenno==$token){
	            $return['msg']='You are not valid';
	        }
	        $this->form_validation->set_rules('filed', 'Choose valid filed ', 'trim|required|numeric|max_length[200]');
	       // $this->form_validation->set_rules('natuer', 'Choose valid  natuer','trim|alpha_numeric|min_length[8]');
	        $data=array(
	            'filed_by'=>$_REQUEST['filed'],
	            'ia_nature'=>$_REQUEST['natuer'],
	            'tab_no'=>$_REQUEST['tabno'],
                'no_of_ia'=>$_REQUEST['totalNoIA'],
	        );
	        if($this->form_validation->run() == TRUE) {
	            $st=$this->efiling_model->update_data('aptel_temp_appellant', $data,'salt', $salt);
    	        if($st){
    	            echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
    	        }
    	    }else{
    	        echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
    	    }
	    }
	    
	    
	    function otherFeesave(){
			 //ini_set('display_errors', 1);
		    //ini_set('display_startup_errors', 1);
		    //error_reporting(E_ALL);
	        date_default_timezone_set('Asia/Calcutta');
	        $post_array=$this->input->post();
	        $tokenno=$this->session->userdata('tokenno');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $salt=$_REQUEST['salt'];
	        $token=$_REQUEST['token'];
	        if($tokenno==$token){
	            $return['msg']='You are not valid';
	        } 
	        $login_details=$this->input->post();
	        if(!$login_details) {
	            exit('Permision denay!');
	        }else {
	        $ia=$_REQUEST['ia'];
	        $nature=$_REQUEST['nature'];
	        $act=$_REQUEST['act'];
	        $ann=$_REQUEST['ann'];
	        $lower=$_REQUEST['cnt'];
	        $noOfRes=$_REQUEST['resexp'];
	        $fee=$_REQUEST['fee']; 
	        $otherFee=0;
	        $feecode=explode(",",$fee);
	        $len=sizeof($feecode);
	        $msg='';
	        if($len!="") {
	            for($i=0;$i<$len;$i++){
	                if($feecode[$i]!=''){
    	                if(!preg_match('/^[0-9]*$/',$feecode[$i])){
    	                    $msg= "<font color='red' size='4'>Error: You did not enter numbers only. Please enter only numbers11111.</font></center>";
    	                }else {
    	                    $feesd=$this->efiling_model->data_list_where('master_fee_detail','doc_code',$feecode[$i]);
    	                    $totalfee=$feesd[0]->doc_fee;
    	                }if($feecode[$i]==11){
    	                    $otherFee=$otherFee+($totalfee*$ann);
    	                }else {
    	                    $otherFee=$otherFee+$totalfee;
    	                }
	                }
	            }
	        }
	        $totalFee=0;
	        $iaFee=0;
	        if($act==3){
	            $totalFee=50000;
	        }else {
	            $totalFee=100000;
	        }
	        if($noOfRes>4){
	            $totalRes=$noOfRes-4;
	            $total=10000*$totalRes;
	            $totalFee=$totalFee+$total;
	        }
	        if($ia!=0){
	            //$iaFee=$ia*1000;
	        }
	        if($otherFee!="") {
	            $total=$iaFee+$totalFee+$otherFee;
	        }else {
	            $total=$iaFee+$totalFee;
	        }
	        if($lower!=""){
	            $totalFee=$totalFee+$lower*100000;
	            $total=$total+$lower*100000;
	        }
	        $datatab=array('tab_no'=>$_REQUEST['tabno']);
	        
	        $st1=$this->efiling_model->update_data('aptel_temp_appellant', $datatab,'salt', $salt);
	        
	        $feesdata=array(
	            'totalFee3' =>$totalFee,
	            'iaFee1'    => $iaFee,
	            'otherFee2' =>$otherFee,
	            'total'     => $total,
	        );
	        $this->session->set_userdata('efilingFeeData',$feesdata);
	        }
	       echo json_encode(['data'=>'success','display'=>'','error'=>'0']);
	    }
	    function  payment_mode(){
	        $this->load->view('admin/payment_mode');
	    }
	    
	    function douploada(){
	        date_default_timezone_set('Asia/Calcutta');
	        $post_array=$this->input->post();
	        $token=$this->session->userdata('tokenno');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $salt=$_REQUEST['salt'];
	        $tokenno=$_REQUEST['token'];
	        if($token!=$token){
	            $msg='You are not valid';
	        }else{
	           $valid_extensions = array('pdf');//array('JPEG','jpeg','jpg','JPG','png','PNG'); // valid extensions
	           $doctype='freshdfr';
	           $schemas='delhi';
	           $Url=base_url();
	           $path = './upload_doc/efiling/'.$schemas.'/';
	           if (!file_exists($path)) {
    	            mkdir($path, 0777, true);
    	           }
	         
			  for($i=0;$i<=count($_FILES['files']['name']);$i++){ 
			   if(!empty($_FILES['files']['name'][$i])){
			   
	            $img = $_FILES['files']['name'][$i];
				$tmp = $_FILES['files']['tmp_name'][$i];
	            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
				$count = explode(".", $img);   
	                $final_image = rand(1000,1000000).$img;
	                if(in_array($ext, $valid_extensions)) {
	                    $save_path = $path.strtolower($final_image);
	                    if(move_uploaded_file($tmp,$save_path)) {
	                        $path11 = './upload_doc/efiling/'.$schemas.'/';
	                        $save_path = $path11.strtolower($final_image);
	                        $flag = 'Y';
	                        $data=array(
	                            'salt'=>$_REQUEST['salt'],
	                            'doc_url'=>$save_path,
	                            'file_type'=>$doctype,
	                            'type'=>$doctype,
	                            'fileName'=>$img,
	                            'user_id'=>$user_id,
	                        );
	                        
	                        $datatab=array('tab_no'=>$_REQUEST['tabno']);
	                        $st1=$this->efiling_model->update_data('aptel_temp_appellant', $datatab,'salt', $salt);
	                        
	                        
	                        $st=$this->efiling_model->insert_query('temp_document',$data);
	                        $msg='Successfully upload';
	                        if($st){
	                            //echo json_encode(['data'=>'success','msg'=>$msg,'display'=>'','error'=>'0']);
								$msg='Successfully upload';
	                        } 
	                    }else{
	                        $msg=  'Something Error. Please try again.';
	                        //echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                    }
	                }else{
	                    $msg= 'invalid Document. Only upload PDF file.';
	                    echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                }
	            }
			  }
			  ##vakalatnama files
			  for($j=0;$j<=count($_FILES['v_files']['name']);$j++){ 
			   if(!empty($_FILES['v_files']['name'][$j])){
	            $img = $_FILES['v_files']['name'][$j];
	            $tmp = $_FILES['v_files']['tmp_name'][$j];
	            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
	            $count = explode(".", $img);   
	                $final_image = rand(1000,1000000).$img;
	                if(in_array($ext, $valid_extensions)) {
	                    $save_path = $path.strtolower($final_image);
	                    if(move_uploaded_file($tmp,$save_path)) {
	                        $path11 = './upload_doc/efiling/'.$schemas.'/';
	                        $save_path = $path11.strtolower($final_image);
	                        $flag = 'Y';
	                        $data=array(
	                            'salt'=>$_REQUEST['salt'],
	                            'doc_url'=>$save_path,
	                            'file_type'=>$doctype,
	                            'type'=>$doctype,
	                            'fileName'=>$img,
	                            'user_id'=>$user_id,
	                        );
	                        
	                        $datatab=array('tab_no'=>$_REQUEST['tabno']);
	                        $st1=$this->efiling_model->update_data('aptel_temp_appellant', $datatab,'salt', $salt);
	                        
	                        
	                        $st=$this->efiling_model->insert_query('temp_document',$data);
	                        $msg='Successfully upload';
	                        if($st){
	                            //echo json_encode(['data'=>'success','msg'=>$msg,'display'=>'','error'=>'0']);
								$msg='Successfully upload';
	                        } 
	                    }else{
	                        $msg=  'Something Error. Please try again.';
	                        //echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                    }
	                }else{
	                    $msg= 'invalid Document. Only upload PDF file.';
	                    echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                }
	            }
			  }
			  ###end for vakalatnama files
			  ##Online Payment Receipt files
			  for($k=0;$k<=count($_FILES['r_files']['name']);$k++){ 
			   if(!empty($_FILES['r_files']['name'][$k])){
	            $img = $_FILES['r_files']['name'][$k];
	            $tmp = $_FILES['r_files']['tmp_name'][$k];
	            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
	            $count = explode(".", $img);   
	                $final_image = rand(1000,1000000).$img;
	                if(in_array($ext, $valid_extensions)) {
	                    $save_path = $path.strtolower($final_image);
	                    if(move_uploaded_file($tmp,$save_path)) {
	                        $path11 = './upload_doc/efiling/'.$schemas.'/';
	                        $save_path = $path11.strtolower($final_image);
	                        $flag = 'Y';
	                        $data=array(
	                            'salt'=>$_REQUEST['salt'],
	                            'doc_url'=>$save_path,
	                            'file_type'=>$doctype,
	                            'type'=>$doctype,
	                            'fileName'=>$img,
	                            'user_id'=>$user_id,
	                        );
	                        
	                        $datatab=array('tab_no'=>$_REQUEST['tabno']);
	                        $st1=$this->efiling_model->update_data('aptel_temp_appellant', $datatab,'salt', $salt);
	                        
	                        
	                        $st=$this->efiling_model->insert_query('temp_document',$data);
	                        $msg='Successfully upload';
	                        if($st){
	                            //echo json_encode(['data'=>'success','msg'=>$msg,'display'=>'','error'=>'0']);
								$msg='Successfully upload';
	                        } 
	                    }else{
	                        $msg=  'Something Error. Please try again.';
	                        //echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                    }
	                }else{
	                    $msg= 'invalid Document. Only upload PDF file.';
	                    echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                }
	            }
			  }
			  ###end Online Payment Receipt files
			  ###for other file
			  if(!empty($_FILES['o_file']['name'])){
			   
	            $img = $_FILES['o_file']['name'];
				$tmp = $_FILES['o_file']['tmp_name'];
	            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
				$count = explode(".", $img);   
	                $final_image = rand(1000,1000000).$img;
	                if(in_array($ext, $valid_extensions)) {
	                    $save_path = $path.strtolower($final_image);
	                    if(move_uploaded_file($tmp,$save_path)) {
	                        $path11 = './upload_doc/efiling/'.$schemas.'/';
	                        $save_path = $path11.strtolower($final_image);
	                        $flag = 'Y';
	                        $data=array(
	                            'salt'=>$_REQUEST['salt'],
	                            'doc_url'=>$save_path,
	                            'file_type'=>$doctype,
	                            'fileName'=>$img,
	                            'user_id'=>$user_id,
	                        );
	                        
	                        $datatab=array('tab_no'=>$_REQUEST['tabno']);
	                        $st1=$this->efiling_model->update_data('aptel_temp_appellant', $datatab,'salt', $salt);
	                        
	                        
	                        $st=$this->efiling_model->insert_query('temp_document',$data);
	                        $msg='Successfully upload';
	                        if($st){
	                            //echo json_encode(['data'=>'success','msg'=>$msg,'display'=>'','error'=>'0']);
								$msg='Successfully upload';
	                        } 
	                    }else{
	                        $msg=  'Something Error. Please try again.';
	                        //echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                    }
	                }else{
	                    $msg= 'invalid Document. Only upload PDF file.';
	                    echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
	                }
	            }
			  ###end for other file
			 /*  echo $st;
			  echo $msg;
			  exit; */
			  if($st){
				  		
						// $this->db->where('salt', @$_REQUEST['salt']);
						// $this->db->update('aptel_temp_appellant', ['tab_no'=>'7']);
						$msg='Successfully upload';
						echo json_encode(['data'=>'success','msg'=>$msg,'display'=>'','error'=>'0']);
					} 
				else{
					$msg=  'Something Error. Please try again.';
					echo json_encode(['data'=>'','msg'=>$msg,'display'=>'','error'=>$msg]);
				}
			  
			  
			  
	        }
	    }

		public function doc_save_next() {
			if($this->input->post()){
				$salt=$this->input->post('salt');
				$token=$this->input->post('token');
				$tabno=(int)$this->input->post('tabno');
				$ut=$this->input->post('untak');
				$st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
				$advytpe=$st[0]->advType;
				
				if($ut=='0'){
				    echo json_encode(['data'=>'Please check confirmation','error'=>'1']);die;
				}
				/*$subdoc=$this->efiling_model->data_list_where('temp_documents_upload','salt',$salt);
				foreach($subdoc as $subdocval){
				    if($subdocval->docid!=0){
				        $subdocvalue[]=$subdocval->docid;
				    }
				}
				if($advytpe==2){
				    $subdocvalue[]=6;
				}
				$doctype=$this->efiling_model->data_list_where('master_document_efile','doctype','app');
				foreach($doctype as $doc){
				    $doctypearr[]=$doc->id;
				}

				$result=array_diff($doctypearr,$subdocvalue);
				$result=[];
				if($advytpe=='1'){
			        if(!empty($result)){
				        echo json_encode(['data'=>'Please upload all mandatory document','error'=>'1']);die;
				    }
				}
				
				if($advytpe=='2'){
		            if(!empty($result)){
		                echo json_encode(['data'=>'Please upload all mandatory document','error'=>'1']);die;
		            }
				}*/
				
				$datatab=array('tab_no'=>$tabno,'is_undertaking'=>$ut);
	            $st1=$this->efiling_model->update_data('aptel_temp_appellant', $datatab,'salt', $salt);
				if($st1)  	echo json_encode(['data'=>'success','error'=>'0']);
				else  		echo json_encode(['data'=>'Query error found in line no '.__LINE__,'error'=>'1']);
			}
			else echo json_encode(['data'=>'Invalid request found.','error'=>'1']);
		}

		
		
		
		
		
		public function upload_docs()
		{	

			if($this->form_validation->run('requireDocument') == FALSE)
			{
				echo json_encode(['error'=>strip_tags(validation_errors()),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
			}	
	
					list($docmentTagName,$docmentTagId)=explode("-",$this->input->post('filename'));
					
				  $fl_path=UPLOADPATH.'/';
				  $schemas=$this->input->post('bench').'/';//'delhi/';
				  $step1=$fl_path.$schemas;
				  if(!is_dir($step1)) {
					  mkdir($step1, 0777, true);
					  chmod($step1,0777);
				  }
				  $salt=(int)$this->input->post('salt');
				  $step2=$step1.$salt.'/appellants/A1/';	
				  if(!is_dir($step2)) {
					  mkdir($step2, 0777, true);
					 // chmod($step1,0777);
					  chmod($step1.$salt,0777);
					  chmod($step1.$salt.'/appellants',0777);
					  chmod($step1.$salt.'/appellants/A1',0777);
					
				  }
				//chmod($step2,0777);
				  $docname=$_FILES['userfile']['name'];
				  $array=explode('.',$_FILES['userfile']['name']);
				  $config['upload_path']   		= $step2;
				  $config['allowed_types'] 		= 'pdf';
				  $config['max_size']      		= '15728640';
				  $config['overwrite']	   		= TRUE;
				  $config['file_ext']	= 'pdf';
				  $config['file_ext_tolower']	= TRUE;
				  $config['file_name']=$docmentTagName; 

				  $this->load->library('upload', $config);
				  if(!$this->upload->do_upload('userfile')){
						  echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']); 
				  }else 	{
					$final_doc_url=$this->upload->data('file_name');
					$pages=$this->countPages($step2.$final_doc_url);
						$data=array(
							'salt' 					=>$salt, 
							'user_id' 					=>$this->user_id, 
							'document_filed_by' 	=>'appellants',
							'no_of_pages'           =>$pages,
							'file_url' 				=>$step2.$final_doc_url,							
						    'document_type' 			=>$config['file_name'],
						    'doc_name'              =>$docname,
							'docid'=>$docmentTagId,
							'submit_type'=>'APPR',
							'doc_type'=>'application/pdf',
						);
					$sth = $this->db->get_where("temp_documents_upload",['salt'=>$salt,'docid'=>$docmentTagId]);
					
					if($sth->num_rows() >0):
						$this->db->where(['salt'=>$salt,'docid'=>$docmentTagId])->update('temp_documents_upload',$data);						
						else:
						$this->db->insert('temp_documents_upload',$data);
						endif;
						//echo $this->db->last_query();
						
					  	echo json_encode(['data'=>'success','error' => '0','file_name'=>base64_encode($step2.$final_doc_url)]);die;
				  }
				
			
		}
		
		
		public function upd_required_docs($csrf=NULL)
		{
			error_reporting(0);
			$token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $matter=$_REQUEST['matter'];
			if($_FILES && $token==$csrf && (int)$this->input->post('salt') > 0) {
				$config=[
							['field'=>'party_type', 'label'=>'Please select valid document filed by','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_]+$/]'],
							['field'=>'req_dtype', 'label'=>'Please select valid document type','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_\/)(\ ]+$/]'],
							['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[200]|callback_mimeType|callback_double_dot|callback_isValidPDF']
						];
	
				$this->form_validation->set_rules($config);		
				if($this->form_validation->run()==FALSE) {			
					  $returnData=['data'=>'','error' => strip_tags(validation_errors())];
					  echo json_encode($returnData); die(); 
	
				 } 
					
				  $fl_path=UPLOADPATH.'/';
				  $schemas=$this->input->post('bench').'/';//'delhi/';
				  $step1=$fl_path.$schemas;

				  $salt=(int)$this->input->post('salt');
				  $step2=$step1.$salt.'/';
				  $typeval=$this->input->post('type');
				  $submittype=$this->input->post('submittype');
				  $docvalid=$this->input->post('docvalid');
				  $pty=$this->input->post('party_type');
				  $step3=$step2.$pty.'/';

				  $rqd_flnm=strtr($this->input->post('req_dtype'),['/'=>'_',' '=>'_']);

				  if(!is_dir($step1)) {
					  mkdir($step1, 0777, true);
					  chmod($step1,0777);
					 
				  }

				  if(!is_dir($step2)) {
					  mkdir($step2, 0777, true);
					  chmod($step2,0777);
				  }

				  if(!is_dir($step3)) {
					  mkdir($step3, 0777, true);
					  chmod($step3,0777);
				  }
				  
				  $valume='';
				  if($docvalid==2){
				      $valume='1';
				  }
				  $array=array('docid'=>$docvalid,'salt'=>$salt);
				  $valexit=$this->efiling_model->data_list_mulwhere('temp_documents_upload',$array);
				  if(!empty($valexit)){
				      foreach($valexit as $fv){
				          if($docvalid==2){
				              $valume='1';
    				          if($fv->valumeno!=''){
    				              $valume = (int)$fv->valumeno+1;
    				          }
				          }
				      }
				  }
				  $docname=$_FILES['userfile']['name'];
				  $array=explode('.',$_FILES['userfile']['name']);
				  $config['upload_path']   		= $step3;
				  $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
				  $config['max_size']      		= '20000000';
				  $config['overwrite']	   		= TRUE;
				   $config['file_ext']	= 'pdf';
				  $config['file_ext_tolower']	= TRUE;
				  $config['file_name']=$rqd_flnm.'_'.date('dmYHis').'.'.strtolower(end($array));
	
				  $this->load->library('upload', $config);
				  if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
						  echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']); 
				  else 	{
					$final_doc_url=$step3.$config['file_name'];
					$pages=$this->countPages($final_doc_url);
						$data=array(
							'salt' 					=>$salt, 
							'user_id' 				=>$user_id, 
							'document_filed_by' 	=>$pty,
						    'matter' 	            =>$matter,
						    'no_of_pages'           =>$pages,
							'document_type' 		=>$rqd_flnm,
							'file_url' 				=>$final_doc_url,
						    'doc_type' 				=>$typeval,
						    'submit_type'           =>$submittype,
						    'docid'                 =>$docvalid,
						    'doc_name'              =>$docname,
						    'valumeno'              =>$valume,
						);

						$st=$this->efiling_model->insert_query('temp_documents_upload',$data);
					  	echo json_encode(['data'=>'success','error' => '0','file_name'=>$final_doc_url]);die;
				  }
				
			}
			else 
				echo json_encode(['data'=>'Invalid request foud, try with valid details','error' => '1','file_name'=>'']);die;
		}
	    
		
		function countPages($path) {
		   // ini_set('display_errors', 1);
		   // ini_set('display_startup_errors', 1);
		   // error_reporting(E_ALL);
		    
		    $pdftext = file_get_contents($path);
		    $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
		    return $num;
		}



		public function validateFeeAmount(array $params)
		{
			$salt=$params['salt'];
			$amountRs=$params['amountRs'];
			$tempdata = $this->efiling_model->getDrafAppList(['cd.salt'=>$salt])->row_array();
			$caseType = $tempdata['l_case_type'];
			$pet_type = $tempdata['pet_type'];
			$totalFee = $this->efiling_model->feeCalculate(['salt'=>$salt,'partyType'=>$pet_type,'caseType'=>$caseType]);
			$totalfees=intval($totalFee['feeAmount']);
			$totalQty=0;
			$colect  =$this->db->select("sum(amount::numeric)as collect")->get_where('aptel_temp_payment',['salt'=>$salt])->row_array();
			if($colect):
				$totalQty=intval($colect['collect']);
			endif;
			if(intval($totalfees)< intval($totalQty)+intval($amountRs)):
				return false;
			endif;
		}
		
	    function addMoredd(){
//ini_set('display_errors',1);
		//	error_reporting(E_ALL);


	        $payid=$this->input->post('payid');
	        if($payid!=''){  
	            $st=$this->efiling_model->delete_event('aptel_temp_payment', 'id', $payid);
	        }else{
				if($this->form_validation->run('addmoredd') == FALSE)
				{
					echo json_encode(['error'=>validation_errors(),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
				}


    	        $salt=$this->input->post('salt');
    	        $dbankname=$this->input->post('dbankname');
    	        $amountRs=$this->input->post('amountRs');
    	        $totalam=$this->input->post('totalam');
    	        $ddno=$this->input->post('ddno');
    	        $ddate=$this->input->post('dddate');
    	        $bd=$this->input->post('bd');

				if($this->validateFeeAmount(['salt'=>$salt,'amountRs'=>$amountRs])===false):
					echo json_encode(['error'=>'amount is greater than allready added amount',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
				endif;

					$query_params=array(
        	            'salt'=>$salt,
        	            'payment_mode'=>$bd,
        	            'branch_name'=>$dbankname,
        	            'dd_no'=>$ddno,
        	            'dd_date'=>$ddate,
        	            'amount'=>$amountRs,
        	            'total_fee'=>$totalam,
        	            
        	        );
    	          $st=$this->efiling_model->insert_query('aptel_temp_payment',$query_params);

	        }
	        $bd=$this->input->post('bd');
	     if($bd==3){
	            $bankname="Name";
	            $dd="challan/Ref. No";
	            $date="Date of Transction";
	            $amount="Aomunt in Rs.";
	        }
	        $html='';

            $html.='
            <table  class="table table-responsive-sm table-bordered"><thead>
                  <tr><th colspan="5" class="font-weight-bold text-center">Transaction Detail</th></tr>
                  <tr>
                      <th>'.$bankname.'</th>
                      <th>'.$dd.'</th>
                      <th>'.$date.'</th>
                      <th>'.$amount.'</th>
                      <th>Delete</th>
                  </tr></thead><tbody> ';

            		$sum=0;
            		$feesd=$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
            		foreach($feesd as $row){
                    	$id=$row->id;
                    	$sum=$sum+$row->amount;
                    $html.='<tr id="id'.$id.'">
                        <td>'.$row->branch_name.'</td>
                        <td>'.$row->dd_no.'</td>
                        <td>'.$row->dd_date.'</td>
                        <td>'.$row->amount.'</td>
                        <td><input type="button" value="Delete"  class="btn1" onclick="deletePay('.$id.')"/></td>
                     </tr>';
            		}
                    $html.='</tbody><tfoot><tr><th colspan="5" class="font-weight-bold text-center">Total Rs.'.$sum.'
 <input type="hidden" name="collectamount" id="collectamount" value="'.$sum.'">
 </th></tr></tfoot></table>';

            	
            		echo json_encode(['data'=>'success','value'=>'','display'=>$html,'error'=>'0']);
	    }
	    
	    function payfeedetailsave(){
	        $salt=  htmlspecialchars($_REQUEST['salt']);
	        $totalFee = $_REQUEST['totalFee'];
	        $iaFee = $_REQUEST['iaFee'];
	        $otherFee = $_REQUEST['otherFee']; 
	        $tabno= $_REQUEST['tabno']; 
	        $data = array (
                'salt'=>$salt,
                'total_fee'=>$totalFee,
                'ia_fee'=>$iaFee,
                'other_fee'=>$otherFee,
	        ); 
	        
	        $datatab=array(
	            'tab_no'=>$tabno,
	        );
	        $stss=$this->efiling_model->update_data('aptel_temp_appellant', $datatab,'salt', $salt);
	        
	        $st= $this->session->set_userdata('efiling_amount',$data); 
	        if($salt!=''){
	           echo json_encode(['data'=>'success','value'=>'','display'=>'','error'=>'0']);
	        }else{
	            echo json_encode(['data'=>'','value'=>'','display'=>'','error'=>'Some thing error ']);
	        }
	    }
	    
	    function feeCalculation(){
	        $noOfRes=htmlspecialchars($_REQUEST['resexp']);
	        $salt=htmlspecialchars($_REQUEST['salt']);
	        $total=htmlspecialchars($_REQUEST['total']);
	        
	        $this->form_validation->set_rules('resexp', 'Choose value numeric', 'trim|required|numeric|max_length[200]');
	        $this->form_validation->set_rules('total', 'total value is numeric', 'trim|required|numeric|max_length[200]');
	        if($this->form_validation->run() == TRUE) { 
	           $total1=0;
	           if($noOfRes!=""){
    	            $feesd=$this->efiling_model->data_list_where('master_fee_detail','doc_code',$feecode[$i]);
    	            $data=array(
    	                'amount_collective'=>$noOfRes,
    	            ); 
    	            $st=$this->efiling_model->update_data('aptel_temp_appellant', $data,'salt', $salt);
    	            $feesd=$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
    	            if(!empty($feesd)){
        	            foreach($feesd as $row){
        	                $amount=$row->amount;
        	                $sum=$sum+$amount;
        	            } 
    	            }
    	            if($sum!=""){
    	                $tot=$total-$noOfRes;
    	                $total1=$tot-$sum;
    	            }else{
    	                $total1=$total-$noOfRes;
    	            }
    	        }
    	        echo json_encode(['data'=>'success','value'=>$total1,'display'=>'','error'=>'0']);
	        }else{
	            echo json_encode(['data'=>'','error'=>strip_tags(validation_errors())]);
	        }
	    }
	    
	    
	    function efilingfinalsubmit()
		{
			
			//ini_set('display_errors', 1);
		  // error_reporting(E_ALL);
			
	        $tokenval=$this->session->userdata('submittoken');
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $salt=htmlspecialchars($_REQUEST['sql']);



			/*if amount final submit*/
			if($this->input->post('ddno')!=''&&
				$this->input->post('dddate')!=''&&
				$this->input->post('dbankname')!=''&&
				$this->input->post('amountRs')!=''
			) {
				if ($this->form_validation->run('addmoredd') == FALSE) {
					echo json_encode(['error' => validation_errors(), $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
					die;
				}
			}

			if($this->validateFeeAmount(['salt'=>$salt,'amountRs'=>$this->input->post('amountRs')])===false):
				echo json_encode(['error'=>'amount is greater than allready added amount',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
			endif;




	        $this->form_validation->set_rules('sql','Request not valid','trim|required|min_length[1]|max_length[50]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
	        }

			$bench=$this->input->post('bench');
			$subBench=$this->input->post('subBench');
	        /*
	        $this->form_validation->set_rules('bench','Please enter bench number','trim|required|min_length[1]|max_length[3]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
	        }

	        $this->form_validation->set_rules('subBench','Please enter bench number','trim|required|min_length[1]|max_length[3]|numeric');
	        if($this->form_validation->run() == FALSE){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
	        }*/


	        $idorg=$_REQUEST['typefiled'];
	        $typefiledres=$_REQUEST['typefiledres'];
			$this->db->trans_start();
	        if(true){
	        //if($tokenval==$_REQUEST['token']){

				$tempAppelant =getTempAppellant(['salt'=>$salt]);
				$schemasData=getSchemasNames($tempAppelant['bench']);
				$schemasid=$tempAppelant['bench'];
				$schemas= $schemasData->schema_name;

	           //if($bench!="" and $subBench!="") {
	           // $benchCode= htmlspecialchars(str_pad($bench,3,'0',STR_PAD_LEFT));
	           // $subBenchCode= htmlspecialchars(str_pad($subBench,2,'0',STR_PAD_LEFT));
	            $curYear = date('Y');
	            $curMonth = date('m');
	            $curDay = date('d');
	            $curdate="$curYear-$curMonth-$curDay";
				$filCounter=$this->db->select('filing_no')->get_where($schemas.'.year_initialization',['year'=>$curYear])->row_array();
				$fil_no=$filCounter['filing_no']+1;
	           /* $st=$this->efiling_model->data_list_where($schemas.'.year_initialization','year',$curYear);
	            $filing_no1=$st[0]->filing_no;
	            if($filing_no1 ==0){
	                $filing_no ='000001';
	                $fil_no =1;
	            }
	            if($filing_no1 !=0){
	                $fil_no =(int)$filing_no1+1;
	                $filing_no = (int)$filing_no1+1;
	                $len = strlen($filing_no);
	                $length =6-$len;
	                for($i=0;$i<$length;$i++){
	                    $filing_no = "0".$filing_no;
	                }
	            }
	            $filing_no=$benchCode.$subBenchCode.$filing_no.$curYear;*/
				$filing_gen_params=[
					'state_code'=>$schemasData->state_code,
					'district_code'=>$schemasData->district_code,
					'complex_code'=>$schemasData->complex_code,
					'filing_no'=>$fil_no,
					'year'=>$curYear
				];
				$filing_no=generateFilingNo($filing_gen_params);

				$row=$this->db->get_where('aptel_temp_appellant',['salt'=>$salt])->row();
				$zone=0;
				if($row->pet_id>0 && is_numeric($row->pet_id)):
						$zonedata=$this->db->select('zone')->get_where('org_name_master',['org_code'=>$row->pet_id])->row_array();
				if(!empty($zonedata)): $zone=$zonedata['zone'];endif;
				endif;
				if($row->res_id>0 && is_numeric($row->res_id)):
						$zonedata=$this->db->select('zone')->get_where('org_name_master',['org_code'=>$row->res_id])->row_array();
					if(!empty($zonedata)): $zone=$zonedata['zone'];endif;
				endif;
	                $l_case_no=$row->l_case_no;
	                $l_case_year=$row->l_case_year;
	                $lower_case_type=$row->lower_case_type;
	                $commission=$row->commission;
	                $nature_of_order=$row->nature_of_order;
	                $decision_date=isset($row->l_date)?$row->l_date:'';
	                $comm_date=$row->comm_date;
	                $bench=$row->bench;
	                $sub_bench=$row->sub_bench;
					$pet_type=$row->pet_type;



	            $l_case_no1=explode('|',$l_case_no);
	            $len=sizeof($l_case_no1)-1;
	            for($iii=0;$iii<$len;$iii++){
	                $l_case_year1=explode('|',$l_case_year);
	                $lower_case_type1=explode('|',$lower_case_type);
	                $commission1=explode('|',$commission);
	                $nature_of_order1=explode('|',$nature_of_order);
	                $decision_date1=explode('|',$decision_date);
	                $decdate=$decision_date1[$iii];
	                $decdate1=explode('-',$decdate);
	                $decdate2=$decdate1[2].'-'.$decdate1[1].'-'.$decdate1[0];
	                $comm_date1=explode('|',$comm_date);
	                $comdate=isset($comm_date1[$iii])?$comm_date1[$iii]:'';
                    $comdate1='';
                    $comdate2='';
                    if($comdate!=''){
    	                $comdate1=explode('-',$comdate);
    	                $comdate2=$comdate1[2].'-'.$comdate1[1].'-'.$comdate1[0];
                    }
	                $data=array(
    	                    'filing_no'=>$filing_no,
    	                    'dt_of_filing'=>$curdate,
    	                    'bench'=>$bench,
    	                    'sub_bench'=>$sub_bench,
    	                    'case_type'=>$lower_case_type1[$iii],
    	                    'case_no'=>$l_case_no1[$iii],
    	                    'case_year'=>$l_case_year1[$iii],
    	                    'decision_date'=>$decdate2,
    	                    'commission'=>$commission1[$iii],
    	                    'nature_of_order'=>$nature_of_order1[$iii],
	                  );  
	                  $st=$this->efiling_model->insert_query('lower_court_detail',$data);
	            }
	            
	            $caseType=$_REQUEST['type'];
	            $res_type=1;
	            $status='P';
	            //$pet_type=1;
	            $advCode=0;  
	           // $sql_temp=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	            $pet_name='';
	           //foreach($sql_temp as $row){
					$pet_name=$row->pet_name;
	                if($idorg==1){
	                    $orgid=$row->pet_name;   
	                    $pet_name=$row->pet_name;
	                    if (is_numeric($row->pet_name)) {
    	                    $storg =getOrg_name_master(['org_code'=>$orgid]);//$this->efiling_model->data_list_where('master_org','org_id',$orgid);  
    	                    $pet_name=$storg[0]->org_name;
	                    }
	                }
	                if($idorg==2){
	                    $pet_name=$row->pet_name;
	                }
	                if($row->pet_council_adv==""){
	                    $advCode=$advCode;
	                }else {
	                    $advCode=$row->pet_council_adv;
	                }
	                if($typefiledres==1){
	                    $orgid1=$row->resname;
	                    $resname=$row->resname;
	                    if (is_numeric($row->resname)) {
    	                    $storg1 =getOrg_name_master(['org_code'=>$orgid]);//$this->efiling_model->data_list_where('master_org','org_id',$orgid1);  
    	                    $resname=$storg1[0]->org_name;
	                    }
	                }
	                if( $typefiledres==2){
	                    $resname=$row->resname;
	                }
	                if($row->res_council_adv==""){
	                    $resadv=$advCode;
	                }else{
	                    $resadv=$row->res_council_adv;
	                }
	                if($row->res_dis=="") {
	                    $dis='999';
	                }else{
	                    $dis=$row->res_dis;
	                }
	                $iaNature=$row->ia_nature;
	                $filed_by=$row->filed_by;

	            
				
				
	            //Document Filing
				$this->db->query("insert into efile_documents_upload(filing_no,user_id,valumeno,document_filed_by,document_type,no_of_pages,file_url,display,update_on,matter,doc_type,submit_type,docid,doc_name)
select '$filing_no' as filing_no,user_id,valumeno,document_filed_by,document_type,no_of_pages,replace(file_url,'$salt','$filing_no'),display,update_on,matter,doc_type,submit_type,docid,doc_name from temp_documents_upload where salt='$salt'");
	        rename(UPLOADPATH.'/'.$schemasid.'/'.$salt,UPLOADPATH.'/'.$schemasid.'/'.$filing_no); 
				/*
	            $st=$this->efiling_model->data_list_where('temp_documents_upload','salt',$salt);				   
	            if(!empty($st)){
	                foreach($st as $vals){
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
	                    );
	                    $st=$this->efiling_model->insert_query('efile_documents_upload',$data12);
	                }
	            }else{
	                echo json_encode(['data'=>'error','display'=>'You have not upload any document please upload document .','error'=>'0']);die;
	            }*/

				$sql_detail=array(
					'filing_no'=>$filing_no,
					'case_type'=>$caseType,
					'dt_of_filing'=>$curdate,
					'pet_type'=>$pet_type,
					'pet_name'=>$pet_name,
					'pet_adv'=>$advCode,
					'pet_address'=>$row->pet_address,
					'pet_state'=>$row->pet_state,
					'pet_district'=>$row->pet_dist,
					'pet_pin'=>$row->pincode,
					'pet_mobile'=>$row->petmobile,
					'pet_phone'=>$row->petphone,
					'pet_email'=>$row->pet_email,
					'pet_section'=>$row->act,
					'pet_sub_section'=>$row->petsection,
					'pet_fax'=>$row->pet_fax,
					'pet_counsel_address'=>$row->counsel_add,
					'pet_counsel_pin'=>$row->counsel_pin,
					'pet_counsel_mobile'=>$row->counsel_mobile,
					'pet_counsel_phone'=>$row->counsel_phone,
					'pet_counsel_email'=>$row->counsel_email,
					'pet_counsel_fax'=>$row->counsel_fax,
					'limitation'=>isset($row->limit_app)?$row->limit_app:'',
					'facts'=>isset($row->facts)?$row->facts:'',
					'facts_issue'=>isset($row->facts_issue)?$row->facts_issue:'',
					'question_low'=>isset($row->question_low)?$row->question_low:'',
					'ground_raised'=>isset($row->grounds_raised)?$row->grounds_raised:'',
					'matters'=>isset($row->matters)?$row->matters:'',
					'relief'=>isset($row->relief)?$row->relief:'',
					'interim_application'=>isset($row->interim_application)?$row->interim_application:'',
					'appeal'=>isset($row->appeal)?$row->appeal:'',
					'res_type'=>$res_type,
					'res_name'=>$resname,
					'res_adv'=>'0',
					'res_address'=>$row->res_address,
					'res_state'=>$row->res_state,
					'res_district'=>$dis,
					'res_pin'=>$row->res_pin,
					'res_email'=>$row->res_email,
					'res_mobile'=>$row->res_mobile,
					'res_phone'=>$row->res_phone,
					'res_fax'=>$row->res_fax,
					'res_counsel_address'=>$row->res_counsel_address,
					'res_counsel_pin'=>$row->res_counsel_pin,
					'res_counsel_mobile'=>$row->res_counsel_mob,
					'res_counsel_phone'=>$row->res_counsel_phone,
					'res_counsel_email'=>$row->res_counsel_email,
					'res_counsel_fax'=>$row->res_counsel_fax,
					'status'=>$status,
					'salt'=>$row->salt,
					'bench'=>$row->bench,
					'sub_bench'=>$row->sub_bench,
					'no_of_pet'=>$row->no_of_pet,
					'no_of_res'=>$row->no_of_res,
					'pet_degingnation'=>$row->pet_degingnation,
					'res_degingnation'=>$row->res_degingnation,
					'user_id'=>$row->user_id,
					'filed_user_id'=>$row->user_id,
					'no_of_impugned'=>$row->no_of_impugned,
					'pet_id'=>$row->pet_id,
					'res_id'=>$row->res_id,
				);
	            $this->efiling_model->insert_query('aptel_case_detail',$sql_detail);
				//echo $this->db->last_query();

				switch($pet_type):
					case 2://mean public
						$pet_type=1;$res_type=2;
						$pet_org_type=5;$res_org_type=1;
						break;
					default: //mean department
						$pet_type=2;$res_type=1;
						$pet_org_type=1;$res_org_type=5;
				endswitch;

				$case_details_efiles_uses=[
					'filing_no'=>$filing_no,
					'case_type'=>$caseType,
					'dt_of_filing'=>$curdate,
					'pet_type'=>$pet_type,
					'pet_org_type'=>$pet_org_type,
					'pet_name'=>$pet_name,
					'pet_adv'=>$advCode,//$row->pet_council_adv
					'pet_address'=>htmlspecialchars($row->pet_address),
					'pet_state1'=>$row->pet_state,
					'pet_district1'=>$row->pet_dist,
					'pet_pincode'=>$row->pincode,
					'pet_mobile'=>$row->petmobile,
					'pet_phone'=>$row->petphone,
					'pet_email'=>$row->pet_email,
					'pet_fax'=>$row->pet_fax,
					'res_type'=>$res_type,
					'res_org_type'=>$res_org_type,
					'res_name'=>$resname,
					'res_adv'=>'0',
					'res_address'=>htmlspecialchars($row->res_address),
					'res_state1'=>$row->res_state,
					'res_district1'=>$row->res_dis,
					'res_pincode'=>$row->res_pin,
					'res_email'=>$row->res_email,
					'res_mobile'=>$row->res_mobile,
					'res_phone'=>$row->res_phone,
					'res_fax'=>$row->res_fax,
					'status'=>$status,
					'user_id'=>$row->user_id,
					'ass_code'=>$row->ass_code,
					'pre_code'=>$row->pre_code,
					'iec_code'=>$row->iec_code,
					'loc_code'=>$row->loc_code,
					'locc_code'=>$row->locc_code,
					'pan_code'=>$row->pan_code,
					'created_at'=>date('Y-m-d H:i:s'),
					'pet_org_id'=>($row->pet_id>0 && is_numeric($row->pet_id))?$row->pet_id:0,
					'res_org_id'=>($row->res_id>0 && is_numeric($row->res_id))?$row->res_id:0,
					'pet_representative'=>$zone,
					
				];

				$this->db->insert($schemas.'.case_detail',$case_details_efiles_uses);

	            $data=array(
	                'filing_no'=>$fil_no,
	            );
	            $st=$this->efiling_model->update_data($schemas.'.year_initialization', $data,'year', $curYear);
	           
	            //additional applant   insert   
	            $additionalpet =$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt); 
	            if(!empty($additionalpet)){
					$partySerialCounter=2;
    	            foreach($additionalpet as $row){
                      $tempValueadd=array(
                        'filing_no'=>$filing_no,
             		     'party_flag'=>'1',
             		     'pet_name'=>$row->pet_name,
                         'pet_degingnation'=>$row->pet_degingnation,
             		     'pet_address'=>$row->pet_address,
                         'pin_code'=>$row->pin_code,
             		     'pet_state'=>$row->pet_state,
                         'pet_dis'=>$row->pet_dis,
             		     'pet_mobile'=>$row->pet_mobile,
                         'pet_phone'=>$row->pet_phone,
             		     'pet_email'=>$row->pet_email,
                         'pet_fax'=>$row->pet_fax,
		                 'partysrno'=>$row->partysrno,
                         'partyType'=>$row->partyType,
                         'partyreff'=>$row->party_id,
                         'user_id'=>$user_id,
                         'entry_date'=>date('Y-m-d'),
                 		);                      
                      $this->efiling_model->insert_query('additional_party',$tempValueadd);
						/*for cis use addtional party */
						$this->db->insert($schemas.'.additional_party_detail',[
							'filing_no'=>$filing_no,'party_serial_no'=>$partySerialCounter,'name'=>$row->res_name,'address'=>$row->res_address,
							'user_id'=>$user_id,'entry_date'=>date('Y-m-d'),'display'=>true,'party_flag'=>'P'
						]);
						$partySerialCounter++;
    	            }
	            }
	            
	          //additional advocate insert

	            $stadv=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt); 
	            if(!empty($stadv)){
	                foreach($stadv as $stadv){
    	                $sqlAdditionalAdv=array(
    	                    'filing_no'=>$filing_no,
    	                    'party_flag'=>'P',
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
    	                    'user_id'=>$user_id,
    	                    'entry_date'=>date('Y-d-m'),
    	                );
	                }
	                $this->efiling_model->insert_query('additional_advocate',$sqlAdditionalAdv);
					/*for cis use addtional advocate */
	                $this->db->insert($schemas.'.advocate_additional',['filing_no'=>$filing_no,'party_serial_no'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'user_id'=>$user_id,'party_flag'=>'P','adv_code'=>$stadv->council_code]);
					//log_message('info',$this->db->last_query());
	            }
	            
	            
	            
	            //additional respondent  insert   
	            $res =$this->efiling_model->data_list_where('aptel_temp_additional_res','salt',$salt); 
	            if(!empty($res)){
					$partySerialCounter=2;
    	            foreach ($res as  $row){
                     $resdata=array(
                        'filing_no'=>$filing_no,
                    	'party_flag'=>'2',
                    	'pet_name'=>$row->res_name,
                    	'pet_degingnation'=>$row->res_degingnation,
                        'pet_address'=>$row->res_address,
                    	'pin_code'=>$row->res_code,
                        'pet_state'=>$row->res_state,
                    	'pet_dis'=>$row->res_dis,
                        'pet_mobile'=>$row->res_mobile,
                    	'pet_phone'=>$row->res_phone,
                        'pet_email'=>$row->res_email,
                    	'pet_fax'=>$row->res_fax,
			            'partysrno'=>$row->partysrno,
                        'partyType'=>$row->partyType,
                        'partyreff'=>$row->party_id,
                        'user_id'=>$user_id,
                        'entry_date'=>date('Y-m-d'),
	                 );
                     $st=$this->efiling_model->insert_query('additional_party',$resdata);
						/*for cis use addtional party */
						$this->db->insert($schemas.'.additional_party_detail',[
							'filing_no'=>$filing_no,'party_serial_no'=>$partySerialCounter,'name'=>$row->res_name,'address'=>$row->res_address,
							'user_id'=>$user_id,'entry_date'=>date('Y-m-d'),'display'=>true,'party_flag'=>'R'
						]);
						$partySerialCounter++;
    	            }   
	            }
	            
	            

	            //Commision  inserted   
	            $commis=$this->efiling_model->data_list_where('aptel_temp_commision','salt',$salt); 
	            if(!empty($commis)){
    	            foreach($commis as $row){
	                $commition=array(
	                    'filing_no'=>$filing_no,
	                    'case_no'=>$row->case_no,
	                    'decision_date'=>$row->decision_date,
	                    'commission'=>$row->commission,
	                    'case_year'=>$row->case_year,
	                    'comm_date'=>$row->comm_date,
	                    'case_type'=>$row->lower_court_type,
	                    'nature_of_order'=>$row->nature_of_order,
	                    'created_user'=>$user_id,
	                    'created_date'=>date('Y-m-d'),
	                    'modified_date'=>date('Y-m-d'),
	                    'modified_user'=>$user_id,
                      );
	                  $this->efiling_model->insert_query('additional_commision',$commition);
						/*case details impugned */
						$this->db->insert($schemas.'.case_detail_impugned',[
							'impugn_type'=>$row->lower_court_type,'impugn_no'=>$row->case_no,
							'filing_no'=>$filing_no,'impugn_date'=>$row->decision_date,
							'comm_date'=>$row->comm_date,'iss_org'=>$row->commission,'iss_desig'=>$row->nature_of_order
						]);

    	            } 
	            }
	            

	            
	            
	            //Fee Calculation
				if($this->input->post('ddno')!=''&&
				$this->input->post('dddate')!=''&&
				$this->input->post('dbankname')!=''&&
				$this->input->post('amountRs')!=''
				) {
					$account = array(
						'salt' => $salt,
						'createdate' => $curdate,
						'total_fee' => $this->input->post('total_amount_amount'),
						'payment_mode' => $this->input->post('bd'),
						'branch_name' => $this->input->post('dbankname'),
						'dd_no' => $this->input->post('ddno'),
						'dd_date' => $this->input->post('dddate'),
						'amount' => $this->input->post('amountRs'),
					);
					$st = $this->efiling_model->insert_query('aptel_temp_payment', $account); //New Offline payment code
				}

                $iaFee1='';
                $otherFee2='';
                $total='';
	            $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
	            
	            $sql_tempss=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt); 
	            $act = $sql_tempss[0]->act;
	            $hscqueryact11 =$this->efiling_model->data_list_where('master_energy_act','act_code',$act);

	            $fee = isset($hscqueryact11[0]->fee)?$hscqueryact11[0]->fee:'';
	            

	            if(!empty($st)){
    	            $noofimpugned=$st[0]->no_of_impugned;
    	            $ia=$st[0]->no_of_ia;
    	            $norespondent=$st[0]->no_of_res;
    	            $fee=$this->session->userdata('efilingFeeData');
    	            $iaFee1= @$fee['iaFee1'];
    	            $otherFee2=@$fee['otherFee2'];
    	            $st=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt', $salt);
    	            $rescount=count($st)+1;
    	            $resamoubnt=0;
    	            if($rescount>4){
    	                $resamoubnt=($rescount-4)*$fee;
    	            }
    	            $appealFee= (int)$fee*$noofimpugned+$resamoubnt;
    	            $total=@$appealFee+$iaFee1+$otherFee2;
	            }
	            
	            $recamount=0;
	            $pay=$this->efiling_model->data_list_where('aptel_temp_payment','salt', $salt);
	            foreach($pay as $payval){
                    $account=array(
                        'filing_no'=>$filing_no,
                        'dt_of_filing'=>$curdate,
                        'fee_amount'=>$total,
                        'payment_mode'=>$payval->payment_mode,
                        'branch_name'=>$payval->branch_name,
                        'dd_no'=>$payval->dd_no,
                        'dd_date'=>$payval->dd_date,
                        'amount'=>$payval->amount,
                        'salt'=>$payval->salt,
                        'ia_fee'=>$iaFee1,
                        'other_fee'=>$otherFee2,
                        'other_document'=>'',
                        'fee_type'=>'OF',
                        'user_id'=>$user_id,
                        'entry_date'=>date('Y-m-d'),
                    );
                    $recamount +=$payval->amount;
                    $st=$this->efiling_model->insert_query('aptel_account_details',$account); //New Offline payment code

					/*cis fee details*/
					$this->db->insert($schemas.'.fee_detail',[
						'filing_no'=>$filing_no,'payment_mode'=>$payval->payment_mode,'dd_no'=>$payval->dd_no,'dd_bank'=>107,
						'dd_date'=>$payval->dd_date,'amount'=>$payval->amount,'user_id'=>$user_id,'todays_date'=>$curdate,
						'display'=>true
					]);
	            }
$creatquery="insert into $schemas.check_list_customs (filing_no,ass_org,adj_org,adj_desig,app_quest,goods,dispute_st_dt,dispute_en_dt,duty_tax_ord,duty_tax_pd,refund_ord,refund_pd,fine_int_ord,fine_int_pd,penalty_ord,penalty_pd,mkt_value,applic_dispensed,heard,bench_type,reliefs,check_list_confirm,ass_desig,inter_ord,inter_pd,rp_ord,rp_pd,loc_c,iec_code,pan_code,email_add,ph_no,fax_no,add_comm,ce_duty,st_duty,cu_pri_imp1,cu_pri_imp2,cu_pri_exp1,cu_pri_exp2,cu_pri_gen1,cu_pri_gen2,cea_code,sta_code,oio_count,classification,pay_mode_duty,pay_mode_penalty,case_type) select
'$filing_no',ass_org,adj_org,adj_desig,app_quest::boolean,goods,dispute_st_dt,dispute_en_dt,duty_tax_ord,duty_tax_pd,refund_ord,refund_pd,fine_int_ord,fine_int_pd,penalty_ord,penalty_pd,mkt_value,applic_dispensed::boolean,heard,bench_type,reliefs,check_list_confirm,ass_desig,inter_ord,inter_pd,rp_ord,rp_pd,loc_c,iec_code,pan_code,email_add,ph_no,fax_no,add_comm,ce_duty,st_duty,cu_pri_imp1,cu_pri_imp2,cu_pri_exp1,cu_pri_exp2,cu_pri_gen1,cu_pri_gen2,cea_code,sta_code,oio_count,classification,pay_mode_duty,pay_mode_penalty,".$caseType."
from temp_check_list where salt='$salt'";
				$this->db->query($creatquery);
	            
	            $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
	            if($this->config->item('ia_privilege')==true):
				$ianature=$st[0]->ia_nature;
	            $valia=explode(',', $ianature);
	            $iawa='0';
	            if(in_array('3', $valia)){
	                $iawa='3';
	            }
	            if($iawa!='3'){
    	            if($total>=$recamount){
    	                echo json_encode(['data'=>'error','display'=>'Amount is not correct ','error'=>'0']);die;
    	            }
	            }
				endif;
	            $iafee=$iaFee1;
	            $html='';
                $printIAno='';
              //  $delete= $this->efiling_model-> delete_event('ia_detail', 'ia_filing_no', '100012022');
				//echo "ddd";die;
	            //if($iafee > 0 && $iafee!=0) {  //for removal ia
 	                $feecode=explode(",",$iaNature);

				   /***** ia implement *******/
					/**
					 *
					 * ia implement
					 *
					 *
					 *  ia implement
					 *
					 *
					 */
				   if($this->config->item('ia_privilege')==true):
	                if($feecode[0]!=""){
	                    $len=sizeof($feecode)-1;
	                    for($k=0;$k<$len;$k++){
	                        $ia_nature=$feecode[$k];
	                        if($ia_nature==12){
	                            $matter=htmlspecialchars($_REQUEST['matt']);
	                        }else{
	                            $matter="";
	                        }
							$curYear=date('Y');
	                        $year_ins=$this->efiling_model->data_list_where('ia_initialization','year',$curYear);
	                        $ia_filing_no=$year_ins[0]->ia_filing;
							
	                        if($ia_filing_no ==0){
	                            $iaFilingNo=1;
	                            $filno ='000001';
	                        }
							
	                        if($ia_filing_no!='' || $ia_filing_no!=0){
	                            $iaFilingNo =(int)$ia_filing_no+1;
	                            $ia_filing_no=(int)$ia_filing_no+1;
	                            $length =6-strlen($ia_filing_no);
	                            for($i=0;$i<$length;$i++){
	                                $ia_filing_no= "0".$ia_filing_no;
	                            }
	                        }
	                        $iaFiling_no1=$benchCode.$subBenchCode.$ia_filing_no.$curYear;
	                      //  $printIAno=0;
	                        if (is_numeric($ia_nature)) {
	                           $datatta =$this->efiling_model->data_list_where('moster_ia_nature','nature_code',$ia_nature);
	                        }
	                        $datatta_name = $datatta[0]->nature_name;
	                        $printIAno=$printIAno."IA/".$iaFilingNo."/".$curYear." ( " .$datatta_name .")<br>";
	                        $ia=array(
	                            'ia_no'=>$iaFilingNo,
	                            'filing_no'=>$filing_no,
	                            'filed_by'=>$filed_by,
	                            'entry_date'=>$curdate,
	                            'display'=>'Y',
	                            'ia_filing_no'=>$iaFiling_no1,
	                            'ia_nature'=>$ia_nature,
	                            'status'=>$status,
	                            'matter'=>$matter,
	                        );
	                        $st=$this->efiling_model->insert_query('ia_detail',$ia); 
	                        $data=array(
	                            'ia_filing'=>$iaFilingNo,
	                        );
	                        $st=$this->efiling_model->update_data('ia_initialization', $data,'year', $curYear);
	                    }
	                }
					   endif;
				   /***** ia implement close *******/



					if($filing_no!=''){
						$val= substr($filing_no,-8);
						$a=substr_replace($val ,"",-3);
						$b= substr($val, -4);
						$valfilingno='- '. LTRIM(substr($filing_no,7,5),'0').'/'.substr($filing_no,-4);
					}
				
	       //filingPrintSlip.php
	      $html.='<fieldset>
                   <legend>Diary Number :</legend>
	                  <td colspan="1">
                         <div>
                                <a href="javascript: void(0);" style="" class="print-btn2 btn btn-sm btn-danger" onclick="return popitup('."'$filing_no'".');">
                	       <b>Print</b>
                			</a>
						</div>
					</td>

                <div class="col-md-12 text-center text-dark"><h4>Case is successfully registered With Diary No :<span class="text-danger">'.$valfilingno.'</span></br>';
				 if($this->config->item('ia_privilege')==true):
				   if($iafee > 0 && $iafee!=0){
                            $html.="IA Number :";
                             $html.= "<br>";
                            $html.=$printIAno;
                        }
					 endif;
                    
                        $html.='</h4>
               	 </div>
			</fieldset>';

	            //}   //for removal ia

	            $st=$this->efiling_model->insert_query($schemas.'.scrutiny',['filing_no'=>$filing_no]);


	        
    	        /*if($filing_no!=""){
    	           $delete= $this->efiling_model-> delete_event('temp_documents_upload', 'salt', $salt);
    	           $delete= $this->efiling_model-> delete_event('aptel_temp_appellant', 'salt', $salt);
    	           $pay= $this->efiling_model-> delete_event('aptel_temp_payment', 'salt', $salt);
    	           $pet= $this->efiling_model-> delete_event('aptel_temp_additional_party', 'salt', $salt);
    	           $res= $this->efiling_model-> delete_event('aptel_temp_additional_res', 'salt', $salt);
    	           $res= $this->efiling_model-> delete_event('aptel_temp_add_advocate', 'salt', $salt);
    	           $res= $this->efiling_model-> delete_event('aptel_temp_commision', 'salt', $salt);
                   $this->session->unset_userdata('salt');
                   $this->session->unset_userdata('saltNo');
    	        }*/

				$this->db->trans_complete();

              echo json_encode(['data'=>'success','display'=>$html,'error'=>'0']);
	        //}
	        }else{
	            echo json_encode(['data'=>'error','display'=>$html,'error'=>'Request not valid']);
	        }
	    }






































	    
	   
	    function draft_list(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $this->session->unset_userdata('filingnosession');
	            $data['draft']= $this->efiling_model->data_list_where('aptel_temp_appellant','user_id',$user_id);
	            $this->load->view("admin/draft_list",$data);
	        }
	    }
	    
	    
	    function filedcase_list(){
	       $params=$cdparams=$appparams=$codparams=$cdregparams=[];
		$getparams=$this->efiling_model->getRoleBasedParams();
		extract($getparams);
	            $data['filedcase']= $this->efiling_model->getAppFiledList($cdparams);

	            $data['caseTypeShort']= getCaseTypesArray([],'short_name');
	            $data['caseTypeFull']= getCaseTypesArray([],'case_type_name');
	            $this->load->view("admin/filedcase_list",$data);
	    }
		
				
		function pending_scrutiny_app(){

			$params=$cdparams=$appparams=$codparams=$cdregparams=[];
		$getparams=$this->efiling_model->getRoleBasedParams();
		extract($getparams);
	            $data['filedcase']= $this->efiling_model->getAppFiledList(array_merge(['sc.objection_status'=>null],$cdparams));
	            $data['caseTypeShort']= getCaseTypesArray([],'short_name');
	            $data['caseTypeFull']= getCaseTypesArray([],'case_type_name');
	            $this->load->view("admin/filedcase_list",$data);
	    }
		function registerd_app(){
		$params=$cdparams=$appparams=$codparams=$cdregparams=[];
		$getparams=$this->efiling_model->getRoleBasedParams();
		extract($getparams);
	            $data['filedcase']= $this->efiling_model->getAppFiledList(array_merge(['length(cd.case_no)>10'=>null],$cdregparams));
	            $data['caseTypeShort']= getCaseTypesArray([],'short_name');
	            $data['caseTypeFull']= getCaseTypesArray([],'case_type_name');
	            $this->load->view("admin/filedcase_list",$data);
	    }

	    
	    function caveate_list(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){ 
	            $data['caveate']= $this->efiling_model->data_list_where('caveat_detail','filed_user_id',$user_id);
	            $this->load->view("admin/caveate_list",$data);
	        }
	    }
	    
	    public function rpepcp_filed_list()
		{
			$params=$cdparams=$appparams=$codparams=$cdregparams=[];
		$getparams=$this->efiling_model->getRoleBasedParams();
		extract($getparams);
	        $data['rpepcp']= $this->efiling_model->getApplFiledList($appparams);
            $this->load->view("admin/rpepcp_filed_list",$data);

	    }
		 public function rpepcp_registercase()
		{
			$params=$cdparams=$appparams=$codparams=$cdregparams=[];
		$getparams=$this->efiling_model->getRoleBasedParams();
		extract($getparams);
	        $data['rpepcp']= $this->efiling_model->getApplFiledList(array_merge(['length(app.appno)=15'=>null],$appparams));
            $this->load->view("admin/rpepcp_filed_list",$data);

	    }
	    
	    public function rpepcp_draftcase_list(){

	        $data['filedcase']= $this->efiling_model->data_list_where('rpepcp_reffrence_table','user_id',$this->user_id);

			$this->load->view("admin/rpepcp_draftcase_list",$data);

	    }
	    
	    function rpepcppage(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id!=''){
	            $salt=$_REQUEST['reffrenceno'];
	            $type=$_REQUEST['type'];
	            $this->session->set_userdata('reffrenceno',$salt);
	            $this->session->set_userdata('type',$type);
	            echo json_encode(['data'=>'success','display'=>$html,'error'=>'0']);
	        }else{
	            echo json_encode(['data'=>'success','display'=>$html,'error'=>'User Not Valid']);
	        }
	    }
	    

	    
	    function doc_draftcase_list(){
	        $userdata=$this->session->userdata('login_success');
	        $filingno=$_REQUEST['filingno'];
	        $user_id=$userdata[0]->id;
	        $array=array('case_type'=>'DOC','user_id'=>$user_id);
	        $data['filedcase']= $this->efiling_model->select_in('rpepcp_reffrence_table',$array);
	        if($user_id){
	            $this->load->view("admin/doc_draftcase_list",$data);
	        }
	    }
	    
	    
	    /*revenue*/
	    function ia_filed_case(){
	        $userdata=$this->session->userdata('login_success');
	        $filingno=$_REQUEST['filingno'];
	        $user_id=$userdata[0]->id;
	       // $array=array('case_type'=>'IA','user_id'=>$user_id);
	       // $data['filedcase']= $this->efiling_model->select_in('rpepcp_reffrence_table',$array);
	        if($user_id){
	            $this->load->view("admin/ia_filed_case");
	        }
	    }
	    
	    function ia_draftcase_list(){
	        $userdata=$this->session->userdata('login_success');
	        $filingno=$_REQUEST['filingno'];
	        $user_id=$userdata[0]->id;
	        $array=array('user_id'=>$user_id);
	        $data['iadraftcase']= $this->efiling_model->select_in('temp_iadetail',$array);
	        if($user_id){
	            $this->load->view("admin/ia_draftcase_list",$data);
	        }	
	    }
	    
	    
	  

	   function deleteParty(){
	        $userdata=$this->session->userdata('login_success');
	        $data=$_REQUEST;
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $this->load->view("admin/deleteParty",$data);
	        }
	    }

          function org(){
    	    $q = $_GET['q'];
    	    //$q=1;
    	    if ($q != 0) {
    	        $output = array();
    	        $sql1 = $this->efiling_model->data_list_where('master_org','org_id',$q);
    	        foreach ($sql1 as $row) {
    	            $add = $row->org_address;
    	            $org_name = $row->org_name;
    	            $mob = $row->mobile_no;
    	            $mail = $row->email;
    	            $ph = $row->phone_no;
    	            $pin = $row->pin;
    	            $fax = $row->fax;
    	            $stateCode = $row->state;
    	            $distcode = $row->district;
    	            $orgdesg = $row->org_desg;
    	            $st = $this->efiling_model->data_list_where('master_psstatus','state_code',$stateCode);
    	            $statename = $st[0]->state_name;
    	            $distname = '';
    	            if ($distcode != "") {
    	                $stdit = $this->efiling_model->data_list_where('master_psdist','district_code',$distcode);
    	                $distname = $stdit[0]->district_name;
    	            }
    	            if ($distname != '') {
    	                $distname = $distname;
    	            }
    	            if ($mob == '0') {
    	                $mob = '';
    	            }
    	            if ($fax == '0') {
    	                $fax = '';
    	            }
    	            if ($ph == '0') {
    	                $ph = '';
    	            }
    	            $users_arr[] = array("org_name"=>$org_name,"address" => $add, "mob" => $mob, "mail" => $mail, "ph" => $ph, "pin" => $pin, "fax" => $fax, "stcode" => $stateCode, "stname" => $statename, "dcode" => $distcode, "dname" => $distname, "desg" => $orgdesg);   
    	        }
    	        echo json_encode($users_arr);
    	    }
	    }
	    
	   
	    function caveatee(){     
	        $userdata=$this->session->userdata('login_success');
	        $data=$_REQUEST;
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $salt = htmlspecialchars($_REQUEST['salt']);
	            if ($salt != "") {
	                if (!preg_match('/^[0-9]*$/', $salt)) {
	                    $msg= "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	            }
	            if (strlen($salt) > 10) {
	                $msg= "Please enter only 10 Digit numbers.";
	            }
	            $commission = htmlspecialchars($_REQUEST['com']);
	            if ($commission != "") {
	                if (!preg_match('/^[0-9]*$/', $commission)) {
	                    $msg= "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($commission) > 4) {
	                    $msg= "Error: Please Enter commission  lass Than 3 Digit";
	                }
	            }
	            
	            $natureOrder = htmlspecialchars($_REQUEST['noforder']);
	            if ($natureOrder != "") {
	                if (!preg_match('/^[0-9]*$/', $natureOrder)) {
	                    $msg= "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($commission) > 4) {
	                    $msg= "Error: Please Enter Nature lass Than 3 Digit.";
	                }
	            }
	            $caseNo = htmlspecialchars($_REQUEST['cno']);
	            
	            $cyear = htmlspecialchars($_REQUEST['cyear']);
	            if ($cyear != "") {
	                
	                if (!preg_match('/^[0-9]*$/', $cyear)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                    
	                }
	            }
	            if (strlen($cyear) < 4 || strlen($cyear) > 4) {
	                $msg=  "Error: Please enter only Year .";
	                
	            }
	            $decision = htmlspecialchars($_REQUEST['ddate']);
                    $val=explode('/', $decision);
	            if (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $decision)) {
	                $msg=  'Your Desision date entry does not match the DD/MM/YYYY required format.';
	            } else {
	                $decision = $val[2].'-'.$val[1].'-'.$val[0];
	            }
	            $cname = htmlspecialchars($_REQUEST['cname']);
	            if (strlen($cname) > 255) {
	                $msg=  "Error: Name is too long/ Correct Name.";
	            }
	            $cadd = htmlspecialchars($_REQUEST['cadd']);
	            if (strlen($cadd) > 490) {
	                $msg=  "Error: Address is too long/Correct Address.";
	            }
	            $cstate = htmlspecialchars($_REQUEST['cstate']);
	            if ($cstate != "") {
	                if (!preg_match('/^[0-9]*$/', $cstate)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($cstate) > 3) {
	                    $msg=  "Error: Please enter only 3 Digit State Code .";
	                }
	            }
	            $cdis = htmlspecialchars($_REQUEST['cdis']);
	            if ($cdis != "") {
	                if (!preg_match('/^[0-9]*$/', $cdis)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($cdis) > 3) {
	                    $msg=  "Error: Please enter only 3 Digit District Code .";
	                }
	            }
	            $pinNo = htmlspecialchars($_REQUEST['pinNo']);
	            if ($pinNo != "") {
	                if (!preg_match('/^[0-9]*$/', $pinNo)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($pinNo) < 6 || strlen($pinNo) > 6) {
	                    $msg=  "Error: Please enter 6 digit Pin number .";
	                }
	            }
	            $email = htmlspecialchars($_REQUEST['email']);
	            if ($email != "") {
	                if (!stristr($email, "@") OR !stristr($email, ".")) {
	                    $msg= "Your email address is not correct .";
	                }
	            }
	            $phone = htmlspecialchars($_REQUEST['phone']);
	            if ($phone != "") {
	                if (!preg_match('/^[0-9]*$/', $phone)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($phone) < 11 || strlen($phone) > 11) {
	                    $msg=  "Error: Please enter 11 digit Phone number.";
	                }
	            }
	            $mob = htmlspecialchars($_REQUEST['mob']);
	            if ($mob != "") {
	                if (!preg_match('/^[0-9]*$/', $$mob)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($mob) < 10 || strlen($mob) > 10) {
	                    $msg=  "Error: Please enter 10 digit Mobile number .";
	                }
	            } 
	            $prayer = htmlspecialchars($_REQUEST['prayer']);
	            $advCode = htmlspecialchars($_REQUEST['advCode']);
	            if ($advCode == 'Select Counsel Name') {
	                $advCode = "";
	            }
	            if ($advCode != 'Select Counsel Name' and strlen($advCode) > 8) {
	                $msg=  "Error: Please enter 3 digit Counsel Code .";
	            }
	            $councilAdd = htmlspecialchars($_REQUEST['councilAdd']);
	            if (strlen($councilAdd) > 490) {
	                $msg=  "Error: Address is too long/Correct Address.";
	            }
	            $councilemail = htmlspecialchars($_REQUEST['councilemail']);
	            if ($councilemail != "") {
	                if (!stristr($councilemail, "@") OR !stristr($councilemail, ".")) {
	                    $msg="Your email address is not correct.";
	                }
	            }
	            $councilphone = htmlspecialchars($_REQUEST['councilphone']);
	            if ($councilphone != "") {
	                if (!preg_match('/^[0-9]*$/', $councilphone)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	            }
	            $councilmob = htmlspecialchars($_REQUEST['councilmob']);
	            if ($councilmob != "") {
	                if (!preg_match('/^[0-9]*$/', $councilmob)) {
	                    $msg=  "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($councilmob) < 10 || strlen($councilmob) > 10) {
	                    $msg=  "Error: Please enter 10 digit Mobile number .";
	                }
	            }
	            if($cdis == '') {
	                $cdis = '999';
	            }
	            if($msg==''){
	            $query_params = array(
	                'salt' => $salt,
	                'caveat_name' => $cname,
	                'caveat_address' => $cadd,
	                'caveat_state' => $cstate,
	                'caveat_district' => $cdis,
	                'caveat_pin' => $pinNo,
	                'caveat_email' => $email,
	                'caveat_phone' => $phone,
	                'caveat_mobile' => $mob,
	                'prayer' => $prayer,
	                'commission' => $commission,
	                'nature_of_order' => $natureOrder,
	                'case_no' => $caseNo,
	                'case_year' => $cyear,
	                'decision_date' => $decision,
	                'council_name' => $advCode,
	                'council_address' => $councilAdd,
	                'council_email' => $councilemail,
	                'council_phone' => $councilphone,
	                'council_mobile' => $councilmob
	            );
	            $this->session->set_userdata('cavsalt',$salt);
	            $st=$this->efiling_model->insert_query('temp_caveat',$query_params);
	                echo json_encode(['data'=>'success','display'=>'','error'=>'User Not Valid']);
	            }else{
	                echo json_encode(['data'=>'','display'=>$msg,'error'=>'User Not Valid']);
	            }
	        }
	    }
	    
	   function caveatSubmit(){
	        $msg_err='';
	        $curdate=date('Y-m-d');
	        $userdata=$this->session->userdata('login_success');
	        $data=$_REQUEST;
	        $user_id=$userdata[0]->id;
	        if($user_id && $_REQUEST["dbankname"]!=''){
	            $curYear=date('Y');
	            if ($_REQUEST['bd'] == '3') {
	                $ddno = $_REQUEST["ddno"];
	                $amountRs = $_REQUEST["amountRs"];
	                $dddate = $_REQUEST["dddate"];
	                $dbankname = $_REQUEST["dbankname"];
	            }
	            $bname = $dbankname;
	            $ddno = $ddno;
	            $ddate = $dddate;
	            $fee_amount = $amountRs;
	            $payMode = $_REQUEST['bd'];  
	            
	            $amountRs =$_REQUEST['amountRs'];
	            $token_hash = $_REQUEST['token_hash'];

	            $token=hash('sha512',$_REQUEST['token'].$_REQUEST['amountRs']);

	            if ($token!=$token_hash) {
	                $msg_err= "Request is not valid please contact admin";
	            }
	            
	            $bd = htmlspecialchars($_REQUEST['bd']);
	            if (!preg_match('/^[0-9]*$/', $bd)) {
	                $msg_err= "Please Enter party type Only numeric number";
	            }
	            
	            $bd = htmlspecialchars($_REQUEST['bd']);
	            if (!preg_match('/^[0-9]*$/', $bd)) {
	                $msg_err= "Please Enter party type Only numeric number";
	            }
	            
	            
	            $salt = htmlspecialchars($_REQUEST['saltVal']);
	            if (!preg_match('/^[0-9]*$/', $salt)) {
	                $msg_err= "Please Enter Case No Only numeric number";
	            }
	            if (strlen($salt) > 10) {
	                $msg_err="Please enter only 10 Digit numbers.";
	            }
	            $Namecav = htmlspecialchars($_REQUEST['Namecav']);
	            if (strlen($Namecav) > 255) {
	                $msg_err= "Error: Name is too long/ Correct Name.";
	            }
	            $addresscav = htmlspecialchars($_REQUEST['addresscav']);
	            if (strlen($addresscav) > 490) {
	                $msg_err="Error: Address is too long/Correct Address.";
	            }
	            
	            if (!preg_match('/^[0-9]*$/', $_REQUEST['ddno'])) {
	                $msg_err="Error: You did not enter numbers only. Please enter only 13 digit number.";
	            }
	            
	            if (strlen($_REQUEST['ddno'])!=13) {
	                $msg_err="Error: You did not enter numbers only. Please enter only 13 digit number.";
	            }
	            
	            $dstate = htmlspecialchars($_REQUEST['dstate']);
	            if ($dstate != "") {
	                if (!preg_match('/^[0-9]*$/', $dstate)) {
	                    $msg_err= "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($dstate) > 3) {
	                    $msg_err="Error: Please enter only 3 Digit State Code .";
	                }
	            }
	            $ddistrict = htmlspecialchars($_REQUEST['ddistrict']);
	            if ($ddistrict != "") {
	                if (!preg_match('/^[0-9]*$/', $ddistrict)) {
	                    $msg_err="Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($ddistrict) > 3) {
	                    $msg_err="Error: Please enter only 3 Digit District Code .";
	                }
	            }
	            $pincav = htmlspecialchars($_REQUEST['pincav']);
	            if ($pincav != "") {
	                if (!preg_match('/^[0-9]*$/', $pincav)) {
	                    $msg_err="Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($pincav) < 6 || strlen($pincav) > 6) {
	                    $msg_err="Error: Please enter 6 digit Pin number .";
	                }
	            }
	            $emailcav = htmlspecialchars($_REQUEST['emailcav']);
	            if ($emailcav != "") {
	                if (!stristr($emailcav, "@") OR !stristr($emailcav, ".")) {
	                    $msg_err=  "Your email address is not correct";
	                }
	            }      
	            $phonecav = htmlspecialchars($_REQUEST['phonecav']);
	            if ($phonecav != "") {
	                if (!preg_match('/^[0-9]*$/', $phonecav)) {
	                    $msg_err="Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($phonecav) < 11 || strlen($phonecav) > 11) {
	                    $msg_err="Error: Please enter 11 digit Phone number .";
	                }
	            }	            
	            $mobcav = htmlspecialchars($_REQUEST['mobcav']);
	            if ($mobcav != "") {
	                if (!preg_match('/^[0-9]*$/', $mobcav)) {
	                    $msg_err= "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	                if (strlen($mobcav) < 10 || strlen($mobcav) > 10) {
	                    $msg_err= "Error: Please enter 10 digit Mobile number.";
	                }
	            }
	            
	            $org = htmlspecialchars($_REQUEST['select_org_app']);
	            if ($mobcav != "") {
	                if (!preg_match('/^[0-9]*$/', $org)) {
	                    $msg_err= "Error: You did not enter numbers only. Please enter only numbers.";
	                }
	            }
	            
	       
	            if($msg_err==''){
	                
	                $row = $this->efiling_model->data_list_where('temp_caveat','salt',$salt);
	                $comm = $row[0]->commission;
	                $order = $row[0]->nature_of_order;
	                $benchCode = htmlspecialchars(str_pad($comm, 3, '0', STR_PAD_RIGHT));
	                $subBenchCode = htmlspecialchars(str_pad($order, 2, '0', STR_PAD_LEFT));
	                $year_ins = $this->efiling_model->data_list_where('chamber_initialization','year',$curYear);
	                $iaFiling = $year_ins[0]->caveat_filing;
	                $ia_filing_no = $iaFiling;
	                if ($ia_filing_no == '0') {
	                    $iaFilingNo = 1;
	                    $filno = $ia_filingNo = '000001';
	                }
	                if ($ia_filing_no != '0') {
	                    $iaFilingNo = $iaFiling + 1;
	                    $filno = $ia_filing_no = (int)$ia_filing_no + 1;
	                    $len = strlen($ia_filing_no);
	                    $length = 6 - $len;
	                    for ($i = 0; $i < $length; $i++) {
	                        $filno = "0" . $filno;
	                    }
	                }
	                
	                $caveat_filing_no = $benchCode . $subBenchCode . $filno . $curYear;
	                $aray=array(
	                    'caveat_filing_no'=>$caveat_filing_no,
    	                'caveat_name'=>$row[0]->caveat_name,
    	                'caveat_address'=>$row[0]->caveat_address,
    	                'caveat_state'=>$row[0]->caveat_state,
    	                'caveat_district'=>$row[0]->caveat_district,
    	                'caveat_pin'=>$row[0]->caveat_pin,
    	                'caveat_email'=>$row[0]->caveat_email,
    	                'caveat_phone'=>$row[0]->caveat_phone,
    	                'caveat_mobile'=>$row[0]->caveat_mobile,
    	                'prayer'=>$row[0]->prayer,
    	                'commission'=>$row[0]->commission,
    	                'nature_of_order'=>$row[0]->nature_of_order,
    	                'case_no'=>$row[0]->case_no,
    	                'case_year'=>$row[0]->case_year,
    	                'decision_date'=>$row[0]->decision_date,
    	                'council_name'=>$row[0]->council_name,
    	                'council_address'=>$row[0]->council_address,
    	                'council_email'=>$row[0]->council_email,
    	                'council_phone'=>$row[0]->council_phone,
    	                'council_mobile'=>$row[0]->council_mobile,
	             );	               
	            $this->efiling_model->insert_query('caveat_detail',$aray);
	             
	            $order1 = 0;
	            $cavete_update = "update additional_commision set filing_no = '" . $caveat_filing_no . "'  where filing_no = '" . $salt . "'";
	            $this->db->query($cavete_update,false);
	            $query_params = array(
	                'caveat_filing_no' => $caveat_filing_no,
	                'caveatee_name' => $Namecav,
	                'caveatee_address' => $addresscav,
	                'caveatee_state' => $dstate,
	                'caveatee_district' => $ddistrict,
	                'caveatee_pin' => $pincav,
	                'caveatee_email' => $emailcav,
	                'caveatee_phone' => $phonecav,
	                'caveatee_mobile' => $mobcav,
	                'caveat_filing_date' => $curdate,
	                'case_type' => $order,
	                'nature_of_order' => $order1,
	                'filed_user_id' => $user_id,
	            );
	            $where=array(
	                'caveat_filing_no'=>$caveat_filing_no,
	            );
	            $this->efiling_model->update_data_where('caveat_detail',$where,$query_params);
	            
                $row = $this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
	            foreach($row as $val){
	                $aray=array(
	                    'filing_no'=>$caveat_filing_no,
	                    'dt_of_filing'=>$curdate,
	                    'fee_amount'=>$val->amount,
	                    'payment_mode'=>$val->payment_mode,
	                    'branch_name'=>$val->branch_name,
	                    'dd_no'=>$val->dd_no,
	                    'dd_date'=>$val->dd_date,
	                    'ia_fee'=>'',
	                );
	                $this->efiling_model->insert_query('aptel_account_details',$aray);
	            }
                $account = "insert into aptel_account_details(filing_no,dt_of_filing,fee_amount,payment_mode,branch_name,dd_no,dd_date,ia_fee)values('$caveat_filing_no','$curdate','$fee_amount','$payMode','$bname','$ddno','$ddate','$fee_amount')";
                $this->db->query($account,false);
                $sql1=$this->efiling_model->delete_event('temp_caveat','salt',$salt);
                $where=array('year'=>$curYear,  );
                $data=array('caveat_filing'=>$iaFilingNo);
                $resupeate = $this->efiling_model->update_data_where('chamber_initialization',$where,$data); 
                $this->session->unset_userdata('cavsalt');
	            $caveat_filing_no1=$caveat_filing_no;
                $caveat_filing_no=base64_encode($caveat_filing_no);
                $caveat_filing_no="'$caveat_filing_no'";
                $msg = "Caveat Filed Successfully";
                $html='<fieldset>
                        <div>
                            <a href="javascript:void(0);"  data-toggle="modal" onclick="return popitup('.$caveat_filing_no.')"><b>Print Recipt </b></a>
                        </div>
                        <legend class="customlavel2">Caveat Filed Successfully</legend>
                        <label><span class="custom"><font color="#0000FF" size="5">Caveate Diary  No :--'.$caveat_filing_no1.'</font></span></label>
                       </fieldset>';
                    echo json_encode(['data'=>'success','display'=>$html,'error'=>'User Not Valid']);
    	        }else{
    	            echo json_encode(['data'=>'error','display'=>$msg_err,'error'=>'User Not Valid']);
    	        }  
	        }else{
	           echo "Request Not valid";
	        }
	    }

	    
	  function caveat_receipt($filig_no){
	        $data['filing_no']=base64_decode($filig_no);
	        $filing_no=base64_decode($filig_no);
	        $this->load->library('ciqrcode');
	        $filing_No = substr($filing_no, 5, 6);
	        $filing_No = ltrim($filing_no, 0);
	        $filingYear = substr($filing_no, 11, 4);
	        $val= "CAVE/$filing_No/$filingYear";
	        $url= "https://cis.aptel.gov.in/";
	        $row4441=$this->efiling_model->data_list_where('caveat_detail','caveat_filing_no',$filing_no);
	        foreach ($row4441 as $row444) {
	            $dt_of_filing= $row444->caveat_filing_date;
	            $caveat_name = $row444->caveat_name;
	            if($caveat_name!=''){
	                $caveat_name=$this->efiling_model->getColumn('master_org','org_name','org_id',$caveat_name);
	            }
	            $caveatee_name = $row444->caveatee_name;
	            if($caveatee_name!=''){
	                $caveatee_name=$this->efiling_model->getColumn('master_org','org_name','org_id',$caveatee_name);
	            }
	            $case_no = $row444->case_no;
	            $case_year = $row444->case_year;
	            $decision_date = $row444->decision_date;
	            $commission = $row444->commission;
	            $sql22_aptel_account_details = $this->efiling_model->data_list_where('aptel_account_details','filing_no',$filing_no);
	            foreach($sql22_aptel_account_details as  $row_aptel_acco) {
	                $fee_amount+= $row_aptel_acco->fee_amount;
	            }
	        }
	        $params['data'] = "$val , Filing Date $dt_of_filing  $url";
	        $params['level'] = 'H';
	        $params['size'] = 10;
	        //  $path= FCPATH.'qrcodeimg/'.$filing_no.'.png';
	        $params['savename'] = FCPATH.'qrcodeci/'.$filing_no.'.png';
	        $path = './qrcodeci/';
	        if (!file_exists($path)) {
	            mkdir($path, 0777, true);
	        }
	        $this->ciqrcode->generate($params);
	        $data['image']= $filing_no.'.png';
	        $this->load->view("admin/caveat_receipt",$data);
	    }

 	 function filing_ajax(){
	        if ($_REQUEST['action'] == 'check_caveat_data') {
	            $val = explode("-", $_REQUEST['decision_date']);
	            $dataa = $val[2] . '-' . $val[1] . '-' . $val[0];
	            $case_no = $_REQUEST['case_no'];
	            $case_year = $_REQUEST['case_year'];
	            $commission = $_REQUEST['commission'];
	            $qu_caveat_detail = "select caveat_name,caveat_filing_no,  commission, nature_of_order, case_no, case_year, decision_date, council_name,caveat_filing_date from caveat_detail  where case_no = '$case_no' and case_year = '$case_year' and decision_date = '$dataa' and commission = '$commission' ";
    
  $query=$this->db->query($qu_caveat_detail);
	            $data = $query->result();
	            if (!empty($data) && is_array($data)) {
	                foreach ($data as $val_dataa) {
	                    $caveat_no = ltrim(substr($val_dataa->caveat_filing_no, 5, 6), 0);
	                    $caveat_date = $val_dataa->caveat_filing_date;
	                    $caveat_counsil = $val_dataa->council_name;
	                    $caveat_name = $val_dataa->caveat_name;
	                    $qu_master_advocate = "SELECT adv_name FROM public.master_advocate where adv_code ='$caveat_counsil'";
	                    $query=$this->db->query($qu_master_advocate);
	                    $data = $query->result();
	                    $adv_name = $data[0]->adv_name;
	                    echo " <b>Caveat No : </b> $caveat_no <br> <b> Date of Caveat Filing : </b> $caveat_date <br> <b> Filed By : </b> $adv_name <br> <b> Caveator Name : </b> $caveat_name<br><br>";
	                }
	            } else {
	                echo 'Not Data Found';
	            }
	        }
	    }


         function addMoreddrpepcp(){
	        $payid=$_REQUEST['payid'];
	        if($payid!=''){
	            $st=$this->efiling_model->delete_event('aptel_temp_payment', 'id', $payid);
	        }else{
	            $this->form_validation->set_rules('bd','Payment mode not valid','trim|required|numeric|min_length[1]|max_length[1]');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	            }
	            $this->form_validation->set_rules('ddno','Please enter NTRP number ','trim|required|min_length[1]|max_length[13]|is_unique[aptel_temp_payment.dd_no]');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']);die;
	            }
	            $this->form_validation->set_rules('dddate','Please Enter Date','trim|required');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	            }
	            $this->form_validation->set_rules('amountRs','Please amount','trim|required');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	            }  
	            
	            $this->form_validation->set_rules('dbankname','Please Enter bank name','trim|required');
	            if($this->form_validation->run() == FALSE){
	                echo json_encode(['data'=>'error','value'=>'','massage'=>validation_errors(),'error'=>'1']); die;
	            }  
	            
    	        $salt=htmlspecialchars($_REQUEST['salt']);
    	        $dbankname=htmlspecialchars($_REQUEST['dbankname']);
    	        $amountRs=htmlspecialchars($_REQUEST['amountRs']);
    	        $totalamount=htmlspecialchars($_REQUEST['totalamount']);
    	        $remainamount=htmlspecialchars($_REQUEST['remainamount']);
    	        $filing_no=htmlspecialchars($_REQUEST['filing_no']);
    	        $type=htmlspecialchars($_REQUEST['type']);
    	        $bd=$_REQUEST['bd'];
    	        $ddno=htmlspecialchars($_REQUEST['ddno']);
    	        $ddate=htmlspecialchars($_REQUEST['dddate']);
    	        $dateOfFiling=explode("/",$ddate);
    	        $ddate=@$dateOfFiling[2].'-'.@$dateOfFiling[1].'-'.@$dateOfFiling[0];
    	        $bd=htmlspecialchars($_REQUEST['bd']);
    	        if($bd==3){
    	            $ddno=htmlspecialchars($_REQUEST['ddno']);
    	        }
    	        $cdate=date('Y-m-d');
    	        if($payid =='') {
    	            $query_params=array(
    	                'salt'=>$salt,
    	                'payment_mode'=>$bd,
    	                'branch_name'=>$dbankname,
    	                'dd_no'=>$ddno,
    	                'dd_date'=>$ddate,
    	                'amount'=>$amountRs,
    	                'ia_fee'=>$amountRs,
    	                'total_fee'=>$totalamount,
    	                'fee_type'=>$type,
    	                'total_fee'=>$totalamount,
    	                'createdate'=>$cdate,
    	            );
    	            $st=$this->efiling_model->insert_query('aptel_temp_payment',$query_params);
    	        }
    	        $bd=$_REQUEST['bd'];
    	        if($bd==3){
    	            $bankname="Name";
    	            $dd="Challan/Ref. No";
    	            $date="Date of Transction";
    	            $amount="Amount in Rs.";
    	        }
    	        $html='';
    	        if($row->dd_no != 'undefined') { $vals= htmlspecialchars($row->dd_no); }
    	        $html.='<p> <font color="#510812" size="3">Transaction Details</font></p>
                <table  class="table">
                      <tr>
                          <th>'.$bankname.'</th>
                          <th>'.htmlspecialchars($dd).'</th>
                          <th>'.htmlspecialchars($date).'</th>
                          <th>'.htmlspecialchars($amount).'</th>
                          <th>Delete</th>
                      </tr> ';
	        }
    	        $sum=0;
    	        $feesd=$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
    	        foreach($feesd as $row){
    	            $id=$row->id;
    	            $sum=$sum+$row->amount;
    	            $html.='<tr>
                            <td>'.$row->branch_name.'</td>
                            <td>'.$row->dd_no.'</td>
                            <td>'.date('d/m/Y',strtotime($row->dd_date)).'</td>
                            <td>'.$row->amount.'</td>
                            <td><input type="button" value="Delete"  class="btn1" onclick="deletePayrpepcp('.$id.')"/></td>
                         </tr>';
    	        }
    	        $remain='';
    	        if($payid =='') {
    	           $remain= $totalamount-$sum;
    	        }else{
    	            $remain= $totalamount-$sum;
    	        }
    	        $html.='</table>
                		<div class="Cell" style="margin-left: 980px;">
                            <p><font color="#510812" size="3">Total Rs</font></p>
                            <p class="custom"><font color="#510812" size="3">'.htmlspecialchars($sum).'</font></p>
                        </div>';
    	        echo json_encode(['data'=>'success','value'=>'','paid'=>$sum,'remain'=>$remain,'display'=>$html,'error'=>'0']);
	        
	    }

	    
	    
	    function addMoreddcaveat(){
	        $errormsg='';
	        $salt=htmlspecialchars($_REQUEST['salt']);
	        $dbankname=htmlspecialchars($_REQUEST['dbankname']);
	        $amountRs=htmlspecialchars($_REQUEST['amountRs']);
	        $totalamount=htmlspecialchars($_REQUEST['totalamount']);
	        $remainamount=htmlspecialchars($_REQUEST['remainamount']);
	        $payid=$_REQUEST['payid'];
	        if($payid!=''){
	            $token_hash=$_REQUEST['token_hash'];
	            $token_val=hash('sha512',trim($payid).'upddoc');
	            if($token_hash==$token_val){
	                $st=$this->efiling_model->delete_event('aptel_temp_payment', 'id', $payid);
	            }else{
	                $errormsg= "Request not valid.";
	            }
	        }
	        if($salt==''){
	            echo "Request not valid";die;
	        }
	        if($amountRs<=0 && $payid==''){
	            $errormsg= "Please Enter valid amount";
	        }
	        if(strlen($amountRs)>15 && $payid==''){
	            $errormsg= "Error: Please enter only 15 Digit Rs.";
	        }
	        $bd=$_REQUEST['bd'];
	        $ddno=htmlspecialchars($_REQUEST['ddno']);
	        if($ddno!="" and $bd=='3'){
	            if(!preg_match('/^[0-9]*$/',$ddno)){
	                $errormsg= "Error: You did not enter numbers only. Please enter only numbers.";
	            }
	            if(strlen($ddno)>13){
	                $errormsg="Error: Please enter only 13 Digit DD No .";
	            }
	        }
	        $ddate=htmlspecialchars($_REQUEST['dddate']);
	        $bd=htmlspecialchars($_REQUEST['bd']);
	        if(!preg_match('/^[0-9]*$/',$bd)){
	            $errormsg= "Error: You did not enter numbers only. Please enter only numbers.";
	        }
	        if(strlen($bd)>2){
	            $errormsg= "Please enter only 2 Digit numbers.";
	        }
	        if($bd==3){
	            $ddno=htmlspecialchars($_REQUEST['ddno']);
	        }
	        if($errormsg==''){
	            if($payid==''){
    	            $query_params=array(
    	                'salt'=>$salt,
    	                'payment_mode'=>$bd,
    	                'branch_name'=>$dbankname,
    	                'dd_no'=>$ddno,
    	                'dd_date'=>$ddate,
    	                'amount'=>$amountRs
    	            );
    	            $st=$this->efiling_model->insert_query('aptel_temp_payment',$query_params);
	            }
	            $bd=$_REQUEST['bd'];
	            if($bd==3){
	                $bankname="Name";
	                $dd="challan/Ref. No";
	                $date="Date of Transction";
	                $amount="Aomunt in Rs.";
	            }
	            $html='';
	            if($row->dd_no != 'undefined') { $vals= htmlspecialchars($row->dd_no); }
	            $html.='<p> <font color="#510812" size="3">Transaction Detail</font></p>
                <table  class="table" style="border: 1px solid black;">
                  <tr>
                      <th>'.$bankname.'</th>
                      <th>'.htmlspecialchars($dd).'</th>
                      <th>'.htmlspecialchars($date).'</th>
                      <th>'.htmlspecialchars($amount).'</th>
                      <th>Delete</th>
                  </tr> ';
	            $remain='';
	            $sum=0;
	            $feesd=$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
	            foreach($feesd as $row){
	                $id=$row->id;
	                $sum=$sum+$row->amount;
	                $html.='<tr>
                        <td>'.$row->branch_name.'</td>
                        <td>'.$row->dd_no.'</td>
                        <td>'.$row->dd_date.'</td>
                        <td>'.$row->amount.'</td>
                        <td><input type="button" value="Delete"  class="btn1" onclick="deletePaycaveate('.$id.')"/></td>
                     </tr>';
	            }
	            $remain= $totalamount-$sum;
	            $html.='</table>
            		<div class="Cell">
                        <p class="custom"><font color="#510812" size="3">Total Rs</font>-&nbsp;&nbsp;&nbsp;<font color="#510812" size="3">'.htmlspecialchars($sum).'</font></p>
                    </div>';
	            echo json_encode(['data'=>'success','value'=>'','paid'=>$sum,'remain'=>$remain,'display'=>$html,'error'=>'0']);
	        }else{
	            echo json_encode(['data'=>'error','value'=>'','display'=>$errormsg,'error'=>'0']);
	        }
	    }

       function myprofile(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=(int)$userdata[0]->id;
	        if($user_id){
	            $feesd['userDetail']=$this->efiling_model->data_list_where('efiling_users','id',$user_id);
	            $this->load->view('admin/myprofile',$feesd);
	        }
	    }
	    
	    
	    function edit_cetified(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=(int)$userdata[0]->id;
	        if($user_id){
	            $this->load->view("admin/edit_certifiedcopy",$data);
	        }
	    }
	    
	    
	    function cetified_list(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=(int)$userdata[0]->id;
	        if($user_id){
	            $this->load->view("admin/cetifiedCopyList",$data);
	        }
	    }
		
		
		  function pay_page(){
		      
			  $salt=$this->session->userdata('salt');
			  $temp_applant=getTempAppellant(['salt'=>$salt]);
			  $tempImpugnedData=getTempImpugned(['salt'=>$salt]);
			  if(!empty($tempImpugnedData)):
				  $feeData=$this->efiling_model->feeCalculate(['salt'=>$salt,'impugnedType'=>$tempImpugnedData['lower_court_type'],'caseType'=>$temp_applant['l_case_type']]);

				  if(array_key_exists('success',$feeData)):
					  $data['appealFee']= $feeData['feeAmount'];
				  else:
					  $data['appealFee']= 0;
				  endif;
			  endif;
	           $this->load->view("admin/pay_page",$data);
	          
	    }
	    
	    function paysuccess_page(){
	        $salt='96635'; 
	        $aaaa=htmlspecialchars($_POST['BharatkoshResponse']);
	        $url = 'localhost:8086/verifyXml';
	        //url-ify the data for the POST
	        //echo $strbharatxml=$response;
	        $strbharatxml=$aaaa;
	        $ch = curl_init();
	        $fields_string = http_build_query($strbharatxml);
	        $fields_string =http_build_query($post_array);
	        //set the url, number of POST vars, POST data
	        curl_setopt($ch,CURLOPT_URL, $url);
	        //curl_setopt($ch, CURLOPT_HEADER, false);
	        
	        //curl_setopt($ch,CURLOPT_POST, count($fields_string));
	        curl_setopt($ch,CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        //curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	        curl_setopt($ch,CURLOPT_POSTFIELDS, $strbharatxml);
	        
	        //curl_setopt($ch, CURLOPT_HTTPGET, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	            'Content-Type: application/json',
	            'Accept: application/json'
	        ));
	        $character = json_decode(curl_exec($ch));

	        $ordercodefinalvalue= $character->orderCode;
	        $signaturefinalvalue= $character->signatureValidation;
	        $statusfinalvalue= $character->status;
	        $transactionfinalvalue= $character->refId;
	        $trandatefinalvalue= $character->bankTransacstionDate;
	        $totalamountinalvalue= $character->totalAmount;
	        curl_close($ch);
	        
	        if($statusfinalvalue=='SUCCESS'){ 
	            $data['filing_no']=$filing_no;
	            $data['status']=$statusfinalvalue;
	            $data['refId']=$transactionfinalvalue;
	            $data['bankTransacstionDate']=$trandatefinalvalue;
	            $data['totalAmount']=$totalamountinalvalue;
	            $this->load->view("admin/paysuccess_page_pending",$data);
	        }
	        
	        if($statusfinalvalue=='PENDING'){
	            $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
	            $bench=$st[0]->bench;
	            $subBench=$st[0]->sub_bench;
	            $caseType=$st[0]->l_case_type;

	            $userdata=$this->session->userdata('login_success');
	            $user_id=$userdata[0]->id;
	            $salt=htmlspecialchars($salt);
	            
	            $idorg=$_REQUEST['typefiled'];
	            $typefiledres=$_REQUEST['typefiledres'];
	            
	            if($bench!="" and $subBench!="") {
	                $benchCode= htmlspecialchars(str_pad($bench,3,'0',STR_PAD_LEFT));
	                $subBenchCode= htmlspecialchars(str_pad($subBench,2,'0',STR_PAD_LEFT));
	                $curYear = date('Y');
	                $curMonth = date('m');
	                $curDay = date('d');
	                $curdate="$curYear-$curMonth-$curDay";
	                $st=$this->efiling_model->data_list_where('year_initialization','year',$curYear);
	                $filing_no1=$st[0]->filing_no;
	                if($filing_no1 ==0){
	                    $filing_no ='000001';
	                    $fil_no =1;
	                }
	                if($filing_no1 !='0'){
	                    $fil_no =(int)$filing_no1+1;
	                    $filing_no = (int)$filing_no1+1;
	                    $len = strlen($filing_no);
	                    $length =6-$len;
	                    for($i=0;$i<$length;$i++){
	                        $filing_no = "0".$filing_no;
	                    }
	                }
	                $filing_no=$benchCode.$subBenchCode.$filing_no.$curYear;
	                
	                $sql_temp1=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	                foreach ($sql_temp1 as $row){
	                    $l_case_no=$row->l_case_no;
	                    $l_case_year=$row->l_case_year;
	                    $lower_case_type=$row->lower_case_type;
	                    $commission=$row->commission;
	                    $nature_of_order=$row->nature_of_order;
	                    $decision_date=isset($row->l_date)?$row->l_date:'';
	                    $comm_date=$row->comm_date;
	                    $bench=$row->bench;
	                    $sub_bench=$row->sub_bench;
	                }
	                error_reporting(0);
	                $l_case_no1=explode('|',$l_case_no);
	                $len=sizeof($l_case_no1)-1;
	                for($iii=0;$iii<$len;$iii++){
	                    $l_case_year1=explode('|',$l_case_year);
	                    $lower_case_type1=explode('|',$lower_case_type);
	                    $commission1=explode('|',$commission);
	                    $nature_of_order1=explode('|',$nature_of_order);
	                    $decision_date1=explode('|',$decision_date);
	                    $decdate=$decision_date1[$iii];
	                    $decdate1=explode('-',$decdate);
	                    $decdate2=$decdate1[2].'-'.$decdate1[1].'-'.$decdate1[0];
	                    $comm_date1=explode('|',$comm_date);
	                    $comdate=$comm_date1[$iii];
	                    $comdate1=explode('-',$comdate);
	                    $comdate2=$comdate1[2].'-'.$comdate1[1].'-'.$comdate1[0];
	                    $data=array(
	                        'filing_no'=>$filing_no,
	                        'dt_of_filing'=>$curdate,
	                        'bench'=>$bench,
	                        'sub_bench'=>$sub_bench,
	                        'case_type'=>$lower_case_type1[$iii],
	                        'case_no'=>$l_case_no1[$iii],
	                        'case_year'=>$l_case_year1[$iii],
	                        'decision_date'=>$decdate2,
	                        'commission'=>$commission1[$iii],
	                        'nature_of_order'=>$nature_of_order1[$iii],
	                    );
	                    $st=$this->efiling_model->insert_query('lower_court_detail',$data);
	                }
	                
	                $caseType=$caseType;
	                $res_type=1;
	                $status='P';
	                $pet_type=1;
	                $advCode=0;
	                $sql_temp=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
	                $pet_name='';
	                foreach($sql_temp as $row){
	                    if($idorg==1){
	                        $orgid=$row->pet_name;
	                        $pet_name=$row->pet_name;
	                        if (is_numeric($row->pet_name)) {
	                            $storg =$this->efiling_model->data_list_where('master_org','org_id',$orgid);
	                            $pet_name=$storg[0]->org_name;
	                        }
	                    }
	                    if($idorg==2){
	                        $pet_name=$row->pet_name;
	                    }
	                    if($row->pet_council_adv==""){
	                        $advCode=$advCode;
	                    }else {
	                        $advCode=$row->pet_council_adv;
	                    }
	                    if($typefiledres==1){
	                        $orgid1=$row->resname;
	                        $resname=$row->resname;
	                        if (is_numeric($row->resname)) {
	                            $storg1 =$this->efiling_model->data_list_where('master_org','org_id',$orgid1);
	                            $resname=$storg1[0]->org_name;
	                        }
	                    }
	                    if( $typefiledres==2){
	                        $resname=$row->resname;
	                    }
	                    if($row->res_council_adv==""){
	                        $resadv=$advCode;
	                    }else{
	                        $resadv=$row->res_council_adv;
	                    }
	                    if($row->res_dis=="") {
	                        $dis='999';
	                    }else{
	                        $dis=$row->res_dis;
	                    }
	                    $iaNature=$row->ia_nature;
	                    $filed_by=$row->filed_by;
	                }
	                $sql_detail=array(
	                    'filing_no'=>$filing_no,
	                    'case_type'=>$caseType,
	                    'dt_of_filing'=>$curdate,
	                    'pet_type'=>$pet_type,
	                    'pet_name'=>$pet_name,
	                    'pet_adv'=>$advCode,
	                    'pet_address'=>$row->pet_address,
	                    'pet_state'=>$row->pet_state,
	                    'pet_district'=>$row->pet_dist,
	                    'pet_pin'=>$row->pincode,
	                    'pet_mobile'=>$row->petmobile,
	                    'pet_phone'=>$row->petphone,
	                    'pet_email'=>$row->pet_email,
	                    'pet_section'=>$row->petsection,
	                    'pet_sub_section'=>$row->petsubsection,
	                    'pet_fax'=>$row->pet_fax,
	                    'pet_counsel_address'=>$row->counsel_add,
	                    'pet_counsel_pin'=>$row->counsel_pin,
	                    'pet_counsel_mobile'=>$row->counsel_mobile,
	                    'pet_counsel_phone'=>$row->counsel_phone,
	                    'pet_counsel_email'=>$row->counsel_email,
	                    'pet_counsel_fax'=>$row->counsel_fax,
	                    'limitation'=>isset($row->limit_app)?$row->limit_app:'',
	                    'facts'=>isset($row->facts)?$row->facts:'',
	                    'facts_issue'=>isset($row->facts_issue)?$row->facts_issue:'',
	                    'question_low'=>isset($row->question_low)?$row->question_low:'',
	                    'ground_raised'=>isset($row->grounds_raised)?$row->grounds_raised:'',
	                    'matters'=>isset($row->matters)?$row->matters:'',
	                    'relief'=>isset($row->relief)?$row->relief:'',
	                    'interim_application'=>isset($row->interim_application)?$row->interim_application:'',
	                    'appeal'=>isset($row->appeal)?$row->appeal:'',
	                    'res_type'=>$res_type,
	                    'res_name'=>$resname,
	                    'res_adv'=>$resadv,
	                    'res_address'=>$row->res_address,
	                    'res_state'=>$row->res_state,
	                    'res_district'=>$dis,
	                    'res_pin'=>$row->res_pin,
	                    'res_email'=>$row->res_email,
	                    'res_mobile'=>$row->res_mobile,
	                    'res_phone'=>$row->res_phone,
	                    'res_fax'=>$row->res_fax,
	                    'res_counsel_address'=>$row->res_counsel_address,
	                    'res_counsel_pin'=>$row->res_counsel_pin,
	                    'res_counsel_mobile'=>$row->res_counsel_mob,
	                    'res_counsel_phone'=>$row->res_counsel_phone,
	                    'res_counsel_email'=>$row->res_counsel_email,
	                    'res_counsel_fax'=>$row->res_counsel_fax,
	                    'status'=>$status,
	                    'salt'=>$row->salt,
	                    'bench'=>$row->bench,
	                    'sub_bench'=>$row->sub_bench,
	                    'no_of_pet'=>$row->no_of_pet,
	                    'no_of_res'=>$row->no_of_res,
	                    'pet_degingnation'=>$row->pet_degingnation,
	                    'res_degingnation'=>$row->res_degingnation,
	                    'user_id'=>$row->user_id,
	                    'filed_user_id'=>$row->user_id,
	                    'no_of_impugned'=>$row->no_of_impugned,
	                    'act'=>$row->act,
	                ) ;
	                
	                
	                $st=$this->efiling_model->insert_query('aptel_case_detail',$sql_detail);
	                $data=array(
	                    'filing_no'=>$fil_no,
	                );
	                $st=$this->efiling_model->update_data('year_initialization', $data,'year', $curYear);
	                //echo "<pre>";print_r($sql_detail);die;
	                $additionalpet =$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt);
	                
	                foreach($additionalpet as $row){
	                    $tempValueadd=array(
	                        'filing_no'=>$filing_no,
	                        'party_flag'=>'1',
	                        'pet_name'=>$row->pet_name,
	                        'pet_degingnation'=>$row->pet_degingnation,
	                        'pet_address'=>$row->pet_address,
	                        'pin_code'=>$row->pin_code,
	                        'pet_state'=>$row->pet_state,
	                        'pet_dis'=>$row->pet_dis,
	                        'pet_mobile'=>$row->pet_mobile,
	                        'pet_phone'=>$row->pet_phone,
	                        'pet_email'=>$row->pet_email,
	                        'pet_fax'=>$row->pet_fax,
	                        'partysrno'=>$row->partysrno,
	                    );
	                    $st=$this->efiling_model->insert_query('additional_party',$tempValueadd);
	                    $conusel_code=$row->council_code;
	                    if($conusel_code!='Select Council Name' and $conusel_code!=""){
	                        $sqlAdditionalAdv=array(
	                            'filing_no'=>$filing_no,
	                            'party_flag'=>'P',
	                            'adv_code'=>$conusel_code,
	                            'adv_mob_no'=>$row->counsel_mobile,
	                            'adv_phone_no'=>$row->counsel_phone,
	                            'adv_fax_no'=>$row->counsel_fax,
	                            'adv_email'=>$row->counsel_email,
	                            'adv_address'=>$row->counsel_add,
	                            'user_id'=>$user_id,
	                            'pin_code'=>$row->counsel_pin,
	                        );
	                        $st=$this->efiling_model->insert_query('additional_advocate',$sqlAdditionalAdv);
	                    }
	                }
	                $res =$this->efiling_model->data_list_where('aptel_temp_additional_res','salt',$salt);
	                foreach ($res as  $row){
	                    $resdata=array(
	                        'filing_no'=>$filing_no,
	                        'party_flag'=>'2',
	                        'pet_name'=>$row->res_name,
	                        'pet_degingnation'=>$row->res_degingnation,
	                        'pet_address'=>$row->res_address,
	                        'pin_code'=>$row->res_code,
	                        'pet_state'=>$row->res_state,
	                        'pet_dis'=>$row->res_dis,
	                        'pet_mobile'=>$row->res_mobile,
	                        'pet_phone'=>$row->res_phone,
	                        'pet_email'=>$row->res_email,
	                        'pet_fax'=>$row->res_fax,
	                        'partysrno'=>$row->partysrno,
	                    );
	                    $st=$this->efiling_model->insert_query('additional_party',$resdata);
	                    $conusel_code=$row->counsel_code;
	                    if($conusel_code!='Select Council Name' and $conusel_code!=""){
	                        $sqlAdditionalAdv1=array(
	                            'filing_no'=>$filing_no,
	                            'party_flag'=>'R',
	                            'adv_code'=>$conusel_code,
	                            'adv_mob_no'=>$row->counsel_mobile,
	                            'adv_phone_no'=>$row->counsel_phone,
	                            'adv_fax_no'=>$row->counsel_fax,
	                            'adv_email'=>$row->counsel_email,
	                            'adv_address'=>$row->counsel_add,
	                            'user_id'=>$user_id,
	                            'pin_code'=>$row->counsel_pin);
	                        $st=$this->efiling_model->insert_query('additional_advocate',$sqlAdditionalAdv1);
	                    }
	                }
	                
	                $hscquery=$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
	                $iafee=0;
	                foreach($hscquery as $row){
	                    $iafee=$row->ia_fee;
	                    $account=array(
	                        'filing_no'=>$filing_no,
	                        'dt_of_filing'=>$curdate,
	                        'fee_amount'=>$row->total_fee,
	                        'payment_mode'=>$row->payment_mode,
	                        'branch_name'=>$row->branch_name,
	                        'dd_no'=>$row->dd_no,
	                        'dd_date'=>$row->dd_date,
	                        'amount'=>$row->amount,
	                        'salt'=>$row->salt,
	                        'ia_fee'=>$row->ia_fee,
	                        'other_fee'=>$row->other_fee,
	                        'other_document'=>$row->other_document,
	                    );
	                    $st=$this->efiling_model->insert_query('aptel_account_details',$account);
	                }
	                
	                $st=$this->efiling_model->data_list_where('temp_document','salt',$salt);
	                if(!empty($st)){
	                    $data12=array(
	                        'filing_no'=>$filing_no,
	                        'user_id'=>$user_id,
	                        'type'=>'efile',
	                        'file_type'=>'efiling',
	                        'fileName'=>$st[0]->fileName,
	                        'doc_url'=>$st[0]->doc_url,
	                    );
	                    $st=$this->efiling_model->insert_query('document_filing',$data12);
	                }
	                
	                if($iafee > 0 && $iafee!=0) {
	                    $feecode=explode(",",$iaNature);
	                    if($feecode[0]!=""){
	                        $len=sizeof($feecode)-1;
	                        $printIAno='';
	                        for($k=0;$k<$len;$k++){
	                            $ia_nature=$feecode[$k];
	                            if($ia_nature==12){
	                                $matter=htmlspecialchars($_REQUEST['matt']);
	                            }else{
	                                $matter="";
	                            }
	                            $year_ins=$this->efiling_model->data_list_where('ia_initialization','year',$curYear);
	                            $ia_filing_no=$year_ins[0]->ia_filing;
	                            if($ia_filing_no =='0'){
	                                $iaFilingNo=1;
	                                $filno ='000001';
	                            }
	                            if($ia_filing_no!='0'){
	                                $iaFilingNo =(int)$ia_filing_no+1;
	                                $ia_filing_no=(int)$ia_filing_no+1;
	                                $length =6-strlen($ia_filing_no);
	                                for($i=0;$i<$length;$i++){
	                                    $ia_filing_no= "0".$ia_filing_no;
	                                }
	                            }
	                            $iaFiling_no1=$benchCode.$subBenchCode.$ia_filing_no.$curYear;
	                            //  $printIAno=0;
	                            if (is_numeric($ia_nature)) {
	                                $datatta =$this->efiling_model->data_list_where('moster_ia_nature','nature_code',$ia_nature);
	                            }
	                            $datatta_name = $datatta[0]->nature_name;
	                            $printIAno=$printIAno."IA/".$iaFilingNo."/".$curYear." ( " .$datatta_name .")<br>";
	                            $ia=array(
	                                'ia_no'=>$iaFilingNo,
	                                'filing_no'=>$filing_no,
	                                'filed_by'=>$filed_by,
	                                'entry_date'=>$curdate,
	                                'display'=>'Y',
	                                'ia_filing_no'=>$iaFiling_no1,
	                                'ia_nature'=>$ia_nature,
	                                'status'=>$status,
	                                'matter'=>$matter,
	                            );
	                            $st=$this->efiling_model->insert_query('ia_detail',$ia);
	                            $data=array(
	                                'ia_filing'=>$iaFilingNo,
	                            );
	                            $st=$this->efiling_model->update_data('ia_initialization', $data,'year', $curYear);
	                        }
	                    } 
	                }
	                $dat=array('filing_no'=>$filing_no);
	                $st=$this->efiling_model->insert_query('scrutiny',$dat);
	                $this->session->unset_userdata('salt');
	                if($filing_no!=""){
	                  //  $delete= $this->efiling_model-> delete_event('aptel_temp_appellant', 'salt', $salt);
	                   // $pay= $this->efiling_model-> delete_event('aptel_temp_payment', 'salt', $salt);
	                   // $pet= $this->efiling_model-> delete_event('aptel_temp_additional_party', 'salt', $salt);
	                   // $res= $this->efiling_model-> delete_event('aptel_temp_additional_res', 'salt', $salt);
	                }
	     //           echo json_encode(['data'=>'success','display'=>$html,'error'=>'0']);
	            }
	        }
	        $data['filing_no']=isset($filing_no)?$filing_no:$salt;
	        $data['status']=$statusfinalvalue;
	        $data['refId']=$transactionfinalvalue;
	        $data['bankTransacstionDate']=$trandatefinalvalue;
	        $data['totalAmount']=$totalamountinalvalue;
if($statusfinalvalue!='CANCELED'){
	   
	      /*  $curl_handle=curl_init();
	        curl_setopt($curl_handle,CURLOPT_URL,'https://164.100.129.32/Bharatkosh/getstatus?OrderId=21313&PurposeId=2313213');
	        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
	        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
	        $buffer = curl_exec($curl_handle);
	        curl_close($curl_handle);
	        if (empty($buffer)){
	            print "Nothing returned from url.<p>";
	        }else{
	            print $buffer;
	        }  */

	        $this->load->view("admin/paysuccess_page",$data);
            }else{
                $this->load->view("admin/paysuccess_page_pending",$data);
            }
	    }
	    

	    function master_dash(){
			//ini_set('display_errors', 1);		    
		    //error_reporting(E_ALL);
	        $data['adv_varified']= $this->efiling_model->data_list_where('master_advocate','status','1');  
	        $data['org_varified']= getOrg_name_master(['display'=>true]);//$this->efiling_model->data_list_where('master_org','status','1');
	        $data['org_nonvarified']= getOrg_name_master(['display'=>false]); //$this->efiling_model->data_list_where('master_org','status','1');
	        $data['euser_varified']= $this->efiling_model->data_list_where('efiling_users','verified','1');
	        $data['euser_nonvarified']= $this->efiling_model->data_list_where('efiling_users','verified','0');
	        $this->load->view("admin/master_dash",$data);
	    }
	    
	    function advocate_list(){
	        $data['adv']= $this->efiling_model->data_list('master_advocate');
	        $this->load->view("admin/advocate_list",$data);
	    }
	    
	       
	    
	    
	    function org_list(){
	         $data['org']= getOrg_name_master(['display'=>true]);//$this->efiling_model->data_list('master_org');
	         $this->load->view("admin/org_list",$data);
	    }
	    
	    
	    function org_view(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $adv_id=$_REQUEST['org_id'];
	        if($user_id){
	            $st=$this->efiling_model->data_list_where('org_name_master','org_code', $adv_id);
	            $status='';
	            if($val->status=='1'){ $status= "Active"; $color='btn-success'; $action= "Varified"; }else{ $status=  "Non Active";$color='btn-primary';$action= "Not Varified";  }
	            $html='<div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Organization Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->org_name.'</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Organization Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->org_address.'</p>
                                            </div>
                                        </div>          
                                       <div class="row">
                                            <div class="col-md-6">
                                                <label> Short Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->short_org_name.'</p>
                                            </div>
                                        </div>              
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label> Mobile</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->mobile_no.'</p>
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
                                                <label>Status</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$status.'</p>
                                            </div>
                                        </div>                                               
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Full Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->orgdisp_name.'</p>
                                            </div>
                                        </div>          
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Organization desg</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>'.$st[0]->org_desg.'</p>
                                            </div>
                                        </div>           
                            </div>';
	            echo json_encode(['data'=>'success','value'=>$html,'massage'=>$massage,'error'=>'1']);
	        }else{
	            $massage="User not valid  .";
	            echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'1']);
	        } 
	    }
	    
	    function org_varified(){
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
	        $status=htmlentities($_REQUEST['status']);
	        $remark=htmlentities($_REQUEST['remark']);
	        $adv_id=htmlentities($_REQUEST['adv_id']);
	        if($user_id){
	            $data=array(
	                'remark'=>$remark,
	                'status'=>$status,
	            );
	            $massage="Successfully Verified.";
	            $st=$this->efiling_model->update_data('master_org', $data,'org_id', $adv_id);
	            echo json_encode(['data'=>'success','value'=>'','massage'=>$massage,'error'=>'0']);
	        }else{
	            $massage="User not valid.";
	            echo json_encode(['data'=>'error','value'=>'','massage'=>$massage,'error'=>'1']);
	        }
	    }

       function change_password(){
		   
	       $userdata=$this->session->userdata('login_success');
	       $user_id=$userdata[0]->id;
	       $data=[];
	       if($user_id!=''){
	           $data['user_detail']=$this->efiling_model->data_list_where('efiling_users','id', $user_id);
	           $this->load->view("admin/changepass",$data);
	       }
	    }
	    
	    function  changepassword(){
	        $massage='';
	        $data='';
	        
	        $oldpassword =htmlentities($_REQUEST['oldpass']);
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id; 
	        $dataval=$this->efiling_model->data_list_where('efiling_users','id', $user_id);
	        if($dataval[0]->password!=$oldpassword){
	            echo json_encode(['data'=>'error','value'=>'','massage'=>'old password not match','error'=>'1']);die;
	        }	       
	        $token =htmlentities($_REQUEST['passval']);
	        $sestoken=$this->session->userdata('passval');
	        
	        $pass= $_REQUEST['password'];
	        $errors = array();
	        /*   if (strlen($pass) < 5 || strlen($pass) > 16) {
	            $massage = "Password should be min 8 characters and max 16 characters";
	        }
	        if (!preg_match("/\d/", $pass)) {
	            $massage = "Password should contain at least one digit";
	        }
	        if (!preg_match("/[A-Z]/", $pass)) {
	            $massage= "Password should contain at least one Capital Letter";
	        }
	        if (!preg_match("/[a-z]/", $pass)) {
	            $massage = "Password should contain at least one small Letter";
	        }
	        if (!preg_match("/\W/", $pass)) {
	            $massage= "Password should contain at least one special character";
	        }
	        if (preg_match("/\s/", $pass)) {
	            $massage = "Password should not contain any white space";
	        } */
	        if($massage!=''){
	            echo json_encode(['data'=>$data,'value'=>'','massage'=>$massage,'error'=>$error]); die;
	        }
	        if($token == $sestoken){
	            $new_pass = htmlentities($_REQUEST['password']);
	            $conpass =   htmlentities($_REQUEST['conpass']);
	            if ($new_pass != $conpass) {
	               $massage="Password not match please try again";
	               $error='1';
	               $data='error';
	            }else{
	                $data=array(
	                    'password'=>$conpass,
	                    'is_password'=>1
	                );
	                $st=$this->efiling_model->update_data('efiling_users', $data,'id', $user_id);
	                $massage="Successfully Password Changed.";
	                $error='0';
	                $data='success';
	                $this->session->unset_userdata('passval');
	                $this->session->unset_userdata('login_success');
	            }
	            echo json_encode(['data'=>$data,'value'=>'','massage'=>$massage,'error'=>$error]);
	        }else{
	           echo json_encode(['data'=>$data,'value'=>'','massage'=>$massage,'error'=>$error]);
	        }
	    }


	    function postalorderfinal(){
	        $app['app']=htmlentities($_REQUEST['app']);
	            $this->load->view('admin/postalorderfinal',$app);
	    }
	    
           function folder($location,$filing_no){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id; 
	       // if($user_id!=''){
	            $dataval=$this->efiling_model->data_list_where('document_filing','filing_no', $filing_no);
	            if(!empty($dataval)){
	                $file=$dataval[0]->doc_url;
	                $hash_file=hash('sha256',$file);
	            }else{
	                exit("Request not valid");
	            }
    	        if (file_exists($file) && $hash_file==$location){
    	            header('Content-Type: '.get_mime_by_extension($file));
    	            readfile($file);
    	        }
	       // }else{
	        //    echo "Request not valid";
	        //}
	    }
	    
	    
	    
	    function folderuser($location,$id){
		
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $file='';
	        if($user_id!=''){
	            $dataval=$this->efiling_model->data_list_where('efiling_users','id', $id);
	            if(!empty($dataval)){
	                $file=$dataval[0]->idproof_upd;
	                $hash_file=hash('sha256',$file);
					header('Content-Type: '.get_mime_by_extension($file));
					echo file_get_contents($file);
	            }
	            if (file_exists($file) && $hash_file==$location){
	               // header('Content-Type: '.get_mime_by_extension($file));
	                //readfile($file);
					
	            }
	        }else{
	            echo "Request not valid";
	        }
	    }
	    
	    
	    function refile_case(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id!=''){
	            $data['refile']= $this->efiling_model->scrutiny_list();
	            $this->load->view("admin/refile_case",$data);
	        }
	    }
	    
	    
	    function defectlatter($filing_no){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        $data['filing_no']=$filing_no;
	        if($user_id!=''){
	            $this->load->view("admin/defectletter_action",$data);
	        }else{
	            echo json_encode(['data'=>'success','display'=>'','error'=>'User Not Valid']);
	        }
	    }
		
		
		function defective_list(){
	      $params=$cdparams=$appparams=$codparams=$cdregparams=[];
		$getparams=$this->efiling_model->getRoleBasedParams();
		extract($getparams);
	        
	            $data['defect']= $this->efiling_model->defectiveCaselist($cdparams);

	           // $data['defect']= $this->efiling_model->getAppFiledList(['sc.objection_status'=>'Y','cd.user_id'=>$user_id]);

	            $this->load->view("admin/defective_list",$data);
	        
	    }
	    function scrutiny_list(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['scrutiny']= $this->efiling_model->scrutiny_list();
	            $this->load->view("admin/scrutiny_list",$data);
	        }
	    }
	    function registerd_cases(){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
	        if($user_id){
	            $data['regcase']= $this->efiling_model->registerdcases_list();
	            $this->load->view("admin/registerd_cases",$data);
	        }
	    }
	    
	   function dfrdetail($filing_no){
			$this->load->library('encryption');
	        $ciparams =$this->efiling_model->getRoleBasedParamsForDocuments();
			extract($ciparams);
			$params['cd.filing_no']=$filing_no;
			$data['documents']=$this->db->get_where('efile_documents_upload as cd',$params);
	        
				$data['commisions']=getIss_auth_masters([]);
	            $data['filedcase']= $this->efiling_model->getAppWithAptel(['cd.filing_no'=>$filing_no])->result();
				//data_list_where('aptel_case_detail','filing_no',$filing_no);
				$data['judgeArray']=getJudgeMaster();
			$data['orderdetails']=$this->db->order_by('date_of_order desc')->get_where('order_details',['filing_no'=>$filing_no,'deleted_at is null'=>null]);
	            $this->load->view("admin/dfrdetail",$data);
	        
	    }
	    
	public function comman_count(){
		
		
		if($this->input->post()){
	        $userdata=$this->session->userdata('login_success');
	        $user_id=$userdata[0]->id;
			$rs=$this->efiling_model->getData($this->input->post(),'user_id',$user_id);
			if($rs) {
				echo json_encode(['data'=>$rs,'error'=>'0']);
			}
			else {			
				echo json_encode(['data'=>'','error'=>'Data not found!']);
			}
		}
		else {			
			echo json_encode(['data'=>'','error'=>'Invalid request found!']);
		}
	}
	

	

	public function uploaded_docs_display(){
		if($this->session->userdata('login_success') && (int)$this->input->post('docId') > 0){
			$id=(int)$this->input->post('docId');
			$url=$this->db->select('file_url')
			              ->where('id',$id)
						  ->get('temp_documents_upload')
						  ->row()
						  ->file_url;

			echo json_encode(['data'=>@$url,'error'=>'0']);
		}
		else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
	}


	
	public function uploaded_docs_displayforia(){
	    if($this->session->userdata('login_success') && (int)$this->input->post('docId') > 0){
	        $id=(int)$this->input->post('docId');
	        $url=$this->db->select('file_url')
	        ->where('id',$id)
	        ->get('efile_documents_upload')
	        ->row()
	        ->file_url;
	        
	        echo json_encode(['data'=>@$url,'error'=>'0']);
	    }
	    else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
	}
	
	
	
	
	public function updDoc_list(){
		if($this->session->userdata('login_success') && (int)$this->input->post('saltId') > 0){
			$salt=$this->input->post('saltId');
			$user_id=(int)$this->session->userdata('login_success')[0]->id;
			$type=$this->input->post('type');
			$warr=array('salt'=>$salt,'user_id'=>$user_id,'display'=>'Y','submit_type'=>$type);
            $docData =$this->efiling_model->list_uploaded_docs('temp_documents_upload',$warr);
			
			if($docData)
				echo json_encode(['data'=>@$docData,'error'=>'0']);
			else echo json_encode(['data'=>'Data not found.','error'=>'1']);
		}
		else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
	}


	
	
	
	
	
	public function checkList_validate(){
	
		if($this->input->post()) {
			
			$saltval=$this->session->userdata('salt');
			$userdata=$this->session->userdata('login_success');  
			$user_id=$userdata[0]->id; 

			if(!isset($saltval) && $saltval==''){
				 $sthquery=$this->db->select('salt')
									->where(['user_id'=>$user_id,'year'=>date('Y')])
									->get('salt_tbl');
									
									if($sthquery->num_rows()>0):
									$verify_salt=$sthquery->row()->salt;
									else:
									$verify_salt=0;
									endif;
									
				$verify_salt=(int)$verify_salt;
				if($verify_salt == 0) {
					$verify_salt=$verify_salt + 1;
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
				$this->session->set_userdata('salt',$salt);
			}
			else $salt=$saltval;
			$this->db->insert('aptel_temp_appellant',['salt'=>$salt,'user_id'=>$user_id,'tab_no'=>1]);
			
			/*$wcond=['salt'=>$salt,'user_id'=>$user_id];
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
				    'values'=>'0',    //htmlentities($this->input->post('value'.$i))
				];
				$db=$this->db->insert('checklist_temp',$data);
			}*/
			
			//if($db) 
				echo json_encode(['data'=>'success','error'=>'0']);
			//else 	echo json_encode(['data'=>'Qyery error, try again','error'=>'1']);
		}
		//else echo json_encode(['data'=>'Permission deny!','error'=>'1']);
	}
	
	
	public function uploaded_docs_delete(){
	    if($this->session->userdata('login_success') && (int)$this->input->post('docId') > 0){
	        $id=(int)$this->input->post('docId');
	        $url=$this->db->select('file_url')
	        ->where('id',$id)
	        ->get('temp_documents_upload')
	        ->row()
	        ->file_url;
	        if(unlink($url)) {
	            $this -> db -> where('id', $id);
	            $this -> db -> delete('temp_documents_upload');
	            $msg ='Record Deleted successfully';
	        }
	        echo json_encode(['data'=>'Success','error'=>'0','msg'=>$msg]);
	    }
	    else echo json_encode(['data'=>'Error!','error'=>'1','msg'=>'error']);
	}
	
	
	
	
	public function upd_required_cav($csrf=NULL) {
	    $token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	    $userdata=$this->session->userdata('login_success');
	    $user_id=$userdata[0]->id;
	    $matter=$_REQUEST['matter'];
	    if($_FILES && $token==$csrf && (int)$this->input->post('salt') > 0) {
	        $config=[
	            ['field'=>'party_type', 'label'=>'Please select valid document filed by','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_]+$/]'],
	            ['field'=>'req_dtype', 'label'=>'Please select valid document type','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_\/)(\ ]+$/]'],
	            ['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[200]|callback_mimeType|callback_double_dot|callback_isValidPDF']
	        ];
	        
	        $this->form_validation->set_rules($config);
	        if($this->form_validation->run()==FALSE) {
	            $returnData=['data'=>'','error' => strip_tags(validation_errors())];
	            echo json_encode($returnData); exit();
	            
	        } else {
	            
	            $fl_path='./upload_doc/efiling/';
	            $schemas='delhi/';
	            $step1=$fl_path.$schemas;
	            
	            $salt=(int)$this->input->post('salt');
	            $step2=$step1.$salt.'/';
	            $typeval=$this->input->post('type');
	            $submittype=$this->input->post('submittype');
	            $docvalid=$this->input->post('docvalid');
	            $pty=$this->input->post('party_type');
	            $step3=$step2.$pty.'/';
	            
	            $rqd_flnm=strtr($this->input->post('req_dtype'),['/'=>'_',' '=>'_']);
	            
	            if(!is_dir($step1)) {
	                mkdir($step1, 0777, true);
	            }
	            
	            if(!is_dir($step2)) {
	                mkdir($step2, 0777, true);
	            }
	            
	            if(!is_dir($step3)) {
	                mkdir($step3, 0777, true);
	            }
	            
	            $valume='';
/* 	            $valexit=$this->efiling_model->data_list_where('temp_documents_upload','docid',$docvalid);
	            if(!empty($valexit)){
	                foreach($valexit as $fv){
	                    if($fv->valumeno!=''){
	                        $valume = (int)$fv->valumeno+1;
	                    }
	                }
	            } */
	            $docname=$_FILES['userfile']['name'];
	            $array=explode('.',$_FILES['userfile']['name']);
	            $config['upload_path']   		= $step3;
	            $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
	            $config['max_size']      		= '20000000';
	            $config['overwrite']	   		= TRUE;
	            $config['file_ext_tolower']	= TRUE;
	            $config['file_name']=$rqd_flnm.'_'.date('dmYHis').'.'.strtolower(end($array));
	            
	            $this->load->library('upload', $config);
	            if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
	                echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']);
	                else 	{
	                    $final_doc_url=$step3.$config['file_name'];
	                    $pages=$this->countPages($final_doc_url);
	                    $data=array(
	                        'salt' 					=>$salt,
	                        'user_id' 				=>$user_id,
	                        'document_filed_by' 	=>$pty,
	                        'matter' 	            =>$matter,
	                        'no_of_pages'           =>$pages,
	                        'document_type' 		=>$rqd_flnm,
	                        'file_url' 				=>$final_doc_url,
	                        'doc_type' 				=>$typeval,
	                        'submit_type'           =>$submittype,
	                        'docid'                 =>$docvalid,
	                        'doc_name'              =>$docname,
	                        'valumeno'              =>$valume,
	                    );
	                    
	                    $st=$this->efiling_model->insert_query('temp_documents_upload',$data);
	                    echo json_encode(['data'=>'success','error' => '0','file_name'=>$final_doc_url]);
	                }
	        }
	    }
	    else
	        echo json_encode(['data'=>'Invalid request foud, try with valid details','error' => '1','file_name'=>'']);
	}
	
	
	
	
	
	public function upd_required_cert($csrf=NULL) {
	    $token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	    $userdata=$this->session->userdata('login_success');
	    $user_id=$userdata[0]->id;
	    $matter=$_REQUEST['matter'];
	    if($_FILES && $token==$csrf && (int)$this->input->post('salt') > 0) {
	        $config=[
	            ['field'=>'party_type', 'label'=>'Please select valid document filed by','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_]+$/]'],
	            ['field'=>'req_dtype', 'label'=>'Please select valid document type','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_\/)(\ ]+$/]'],
	            ['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[200]|callback_mimeType']
	        ];
	        
	        $this->form_validation->set_rules($config);
	        if($this->form_validation->run()==FALSE) {
	            $returnData=['data'=>'','error' => strip_tags(validation_errors())];
	            echo json_encode($returnData); exit();
	            
	        } else {
	            
	            $fl_path='./upload_doc/efiling/';
	            $schemas='delhi/';
	            $step1=$fl_path.$schemas;
	            
	            $salt=(int)$this->input->post('salt');
	            $step2=$step1.$salt.'/';
	            $typeval=$this->input->post('type');
	            $submittype=$this->input->post('submittype');
	            $docvalid=$this->input->post('docvalid');
	            $pty=$this->input->post('party_type');
	            $step3=$step2.$pty.'/';
	            
	            $rqd_flnm=strtr($this->input->post('req_dtype'),['/'=>'_',' '=>'_']);
	            
	            if(!is_dir($step1)) {
	                mkdir($step1, 0777, true);
	            }
	            
	            if(!is_dir($step2)) {
	                mkdir($step2, 0777, true);
	            }
	            
	            if(!is_dir($step3)) {
	                mkdir($step3, 0777, true);
	            }
	            
	            $valume=' ';
	        /*     $valexit=$this->efiling_model->data_list_where('temp_documents_upload','docid',$docvalid);
	            if(!empty($valexit)){
	                foreach($valexit as $fv){
	                    if($fv->valumeno!=''){
	                        $valume = (int)$fv->valumeno+1;
	                    }
	                }
	            } */
	            $docname=$_FILES['userfile']['name'];
	            $array=explode('.',$_FILES['userfile']['name']);
	            $config['upload_path']   		= $step3;
	            $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
	            $config['max_size']      		= '20000000';
	            $config['overwrite']	   		= TRUE;
	            $config['file_ext_tolower']	= TRUE;
	            $config['file_name']=$rqd_flnm.'_'.date('dmYHis').'.'.strtolower(end($array));
	            
	            $this->load->library('upload', $config);
	            if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
	                echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']);
	                else 	{
	                    $final_doc_url=$step3.$config['file_name'];
	                    $pages=$this->countPages($final_doc_url);
	                    $data=array(
	                        'salt' 					=>$salt,
	                        'user_id' 				=>$user_id,
	                        'document_filed_by' 	=>$pty,
	                        'matter' 	            =>$matter,
	                        'no_of_pages'           =>$pages,
	                        'document_type' 		=>$rqd_flnm,
	                        'file_url' 				=>$final_doc_url,
	                        'doc_type' 				=>$typeval,
	                        'submit_type'           =>$submittype,
	                        'docid'                 =>$docvalid,
	                        'doc_name'              =>$docname,
	                        'valumeno'              =>$valume,
	                    );
	                    
	                    $st=$this->efiling_model->insert_query('temp_documents_upload',$data);
	                    echo json_encode(['data'=>'success','error' => '0','file_name'=>$final_doc_url]);
	                }
	        }
	    }
	    else
	        echo json_encode(['data'=>'Invalid request foud, try with valid details','error' => '1','file_name'=>'']);
	}
	
	
	
	
	public function upd_required_rpepcp($csrf=NULL) {
	    $token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	    $userdata=$this->session->userdata('login_success');
	    $user_id=$userdata[0]->id;
	    $matter=$_REQUEST['matter'];
	    if($_FILES && $token==$csrf && (int)$this->input->post('salt') > 0) {
	        $config=[
	            ['field'=>'party_type', 'label'=>'Please select valid document filed by','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_]+$/]'],
	            ['field'=>'req_dtype', 'label'=>'Please select valid document type','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_\/)(\ ]+$/]'],
	            ['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[200]|callback_mimeType|callback_double_dot|callback_isValidPDF']
	        ];
	        
	        $this->form_validation->set_rules($config);
	        if($this->form_validation->run()==FALSE) {
	            $returnData=['data'=>'','error' => strip_tags(validation_errors())];
	            echo json_encode($returnData); exit();
	            
	        } else {
	            
	            $fl_path=UPLOADPATH.'/efiling/';
	            $schemas='delhi/';
	            $step1=$fl_path.$schemas;
	            
	            $salt=(int)$this->input->post('salt');
	            $step2=$step1.$salt.'/';
	            $typeval=$this->input->post('type');
	            $submittype=$this->input->post('submittype');
	            $docvalid=$this->input->post('docvalid');
	            $pty=$this->input->post('party_type');
	            $step3=$step2.$pty.'/';
	            $rqd_flnm=strtr($this->input->post('req_dtype'),['/'=>'_',' '=>'_']);
	            if(!is_dir($step1)) {
	                mkdir($step1, 0777, true);
					chmod($step1,0777);
	            }
	            if(!is_dir($step2)) {
	                mkdir($step2, 0777, true);
					chmod($step2,0777);
	            }
	            if(!is_dir($step3)) {
	                mkdir($step3, 0777, true);
					chmod($step3,0777);
	            }
	            $valume='';
	            if($docvalid==10){
	                $valume='1';
	            }
	            $array=array('docid'=>$docvalid,'salt'=>$salt);
	            $valexit=$this->efiling_model->data_list_mulwhere('temp_documents_upload',$array);
	            if(!empty($valexit)){
	                foreach($valexit as $fv){
	                    if($docvalid==10){
	                        $valume='1';
	                        if($fv->valumeno!=''){
	                            $valume = (int)$fv->valumeno+1;
	                        }
	                    }
	                }
	            }
	            
	            $docname=$_FILES['userfile']['name'];
	            $array=explode('.',$_FILES['userfile']['name']);
	            $config['upload_path']   		= $step3;
	            $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
	            $config['max_size']      		= '15728640';
	            $config['overwrite']	   		= TRUE;
	            $config['file_ext_tolower']	= TRUE;
	            $config['file_name']=$rqd_flnm.'_'.date('dmYHis').'.'.strtolower(end($array));
	            $this->load->library('upload', $config);
	            if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
	                echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']);
	                else 	{
	                    $final_doc_url=$step3.$config['file_name'];
	                    $pages=$this->countPages($final_doc_url);
	                    $data=array(
	                        'salt' 					=>$salt,
	                        'user_id' 				=>$user_id,
	                        'document_filed_by' 	=>$pty,
	                        'matter' 	            =>$matter,
	                        'no_of_pages'           =>$pages,
	                        'document_type' 		=>$rqd_flnm,
	                        'file_url' 				=>$final_doc_url,
	                        'doc_type' 				=>$typeval,
	                        'submit_type'           =>$submittype,
	                        'docid'                 =>$docvalid,
	                        'doc_name'              =>$docname,
	                        'valumeno'              =>$valume,
	                    );
	                    
	                    $st=$this->efiling_model->insert_query('temp_documents_upload',$data);
	                    echo json_encode(['data'=>'success','error' => '0','file_name'=>$final_doc_url]);
	                }
	        }
	    }
	    else
	        echo json_encode(['data'=>'Invalid request foud, try with valid details','error' => '1','file_name'=>'']);
	}
	

	public function upd_required_ia($csrf=NULL) {
	    $token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	    $userdata=$this->session->userdata('login_success');
	    $user_id=$userdata[0]->id;
	    $matter=$_REQUEST['matter'];
	    if($_FILES && $token==$csrf && (int)$this->input->post('salt') > 0) {
	        $config=[
	            ['field'=>'party_type', 'label'=>'Please select valid document filed by','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_]+$/]'],
	            ['field'=>'req_dtype', 'label'=>'Please select valid document type','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_\/)(\ ]+$/]'],
	            ['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[200]|callback_mimeType']
	        ];
	        
	        $this->form_validation->set_rules($config);
	        if($this->form_validation->run()==FALSE) {
	            $returnData=['data'=>'','error' => strip_tags(validation_errors())];
	            echo json_encode($returnData); exit();
	            
	        } else {
	            
	            $fl_path='./upload_doc/efiling/';
	            $schemas='delhi/';
	            $step1=$fl_path.$schemas;
	            
	            $salt=(int)$this->input->post('salt');
	            $step2=$step1.$salt.'/';
	            $typeval=$this->input->post('type');
	            $submittype=$this->input->post('submittype');
	            $docvalid=$this->input->post('docvalid');
	            $pty=$this->input->post('party_type');
	            $step3=$step2.$pty.'/';
	            $rqd_flnm=strtr($this->input->post('req_dtype'),['/'=>'_',' '=>'_']);
	            if(!is_dir($step1)) {
	                mkdir($step1, 0777, true);
	            }
	            if(!is_dir($step2)) {
	                mkdir($step2, 0777, true);
	            }
	            if(!is_dir($step3)) {
	                mkdir($step3, 0777, true);
	            }
	            $valume='';
	            /* if($docvalid==10){
	                $valume='1';
	            }
	            $array=array('docid'=>$docvalid,'salt'=>$salt);
	            $valexit=$this->efiling_model->data_list_mulwhere('temp_documents_upload',$array);
	            if(!empty($valexit)){
	                foreach($valexit as $fv){
	                    if($docvalid==10){
	                        $valume='1';
	                        if($fv->valumeno!=''){
	                            $valume = (int)$fv->valumeno+1;
	                        }
	                    }
	                }
	            } */
	            
	            $docname=$_FILES['userfile']['name'];
	            $array=explode('.',$_FILES['userfile']['name']);
	            $config['upload_path']   		= $step3;
	            $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
	            $config['max_size']      		= '20000000';
	            $config['overwrite']	   		= TRUE;
	            $config['file_ext_tolower']	= TRUE;
	            $config['file_name']=$rqd_flnm.'_'.date('dmYHis').'.'.strtolower(end($array));
	            $this->load->library('upload', $config);
	            if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
	                echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']);
	                else 	{
	                    $final_doc_url=$step3.$config['file_name'];
	                    $pages=$this->countPages($final_doc_url);
	                    $data=array(
	                        'salt' 					=>$salt,
	                        'user_id' 				=>$user_id,
	                        'document_filed_by' 	=>$pty,
	                        'matter' 	            =>$matter,
	                        'no_of_pages'           =>$pages,
	                        'document_type' 		=>$rqd_flnm,
	                        'file_url' 				=>$final_doc_url,
	                        'doc_type' 				=>$typeval,
	                        'submit_type'           =>$submittype,
	                        'docid'                 =>$docvalid,
	                        'doc_name'              =>$docname,
	                        'valumeno'              =>$valume,
	                    );
	                    
	                    $st=$this->efiling_model->insert_query('temp_documents_upload',$data);
	                    echo json_encode(['data'=>'success','error' => '0','file_name'=>$final_doc_url]);
	                }
	        }
	    }
	    else
	        echo json_encode(['data'=>'Invalid request foud, try with valid details','error' => '1','file_name'=>'']);
	}
	
	
	
	function docfiling_required_docs($csrf=NULL){
	    $token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	    $userdata=$this->session->userdata('login_success');
	    $user_id=$userdata[0]->id;
	    $matter=$_REQUEST['matter'];
	    if($_FILES && $token==$csrf && (int)$this->input->post('salt') > 0) {
	        $config=[
	            ['field'=>'party_type', 'label'=>'Please select valid document filed by','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_]+$/]'],
	            ['field'=>'req_dtype', 'label'=>'Please select valid document type','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_\/)(\ ]+$/]'],
	            ['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[200]|callback_mimeType|callback_double_dot|callback_isValidPDF']
	        ];
	        
	        $this->form_validation->set_rules($config);
	        if($this->form_validation->run()==FALSE) {
	            $returnData=['data'=>'','error' => strip_tags(validation_errors())];
	            echo json_encode($returnData); exit();
	            
	        } else {
	            
	            $fl_path=UPLOADPATH.'/efiling/';
	            $schemas='delhi/';
	            $step1=$fl_path.$schemas;
	            
	            $salt=(int)$this->input->post('salt');
	            $step2=$step1.$salt.'/';
	            $typeval=$this->input->post('type');
	            $submittype=$this->input->post('submittype');
	            $docvalid=$this->input->post('docvalid');
	            $pty=$this->input->post('party_type');
	            $step3=$step2.$pty.'/';
	            $rqd_flnm=strtr($this->input->post('req_dtype'),['/'=>'_',' '=>'_']);
	            if(!is_dir( $step1)) {
	                mkdir($step1, 0777, true);
	            }
	            if(!is_dir($step2)) {
	                mkdir($step2, 0777, true);
	            }
	            if(!is_dir($step3)) {
	                mkdir($step3, 0777, true);
	            }
	            $valume='';
	            $docname=$_FILES['userfile']['name'];
	            $array=explode('.',$_FILES['userfile']['name']);
	            $config['upload_path']   		= $step3;
	            $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
	            $config['max_size']      		= '20000000';
	            $config['overwrite']	   		= TRUE;
	            $config['file_ext_tolower']	= TRUE;
	            $config['file_name']=$rqd_flnm.'_'.date('dmYHis').'.'.strtolower(end($array));
	            $this->load->library('upload', $config);
	            if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
	                echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']);
	                else 	{
	                    $final_doc_url=$step3.$config['file_name'];
	                    $pages=$this->countPages($final_doc_url);
	                    $data=array(
	                        'salt' 					=>$salt,
	                        'user_id' 				=>$user_id,
	                        'document_filed_by' 	=>$pty,
	                        'matter' 	            =>$matter,
	                        'no_of_pages'           =>$pages,
	                        'document_type' 		=>$rqd_flnm,
	                        'file_url' 				=>$final_doc_url,
	                        'doc_type' 				=>$typeval,
	                        'submit_type'           =>$submittype,
	                        'docid'                 =>$docvalid,
	                        'doc_name'              =>$docname,
	                        'valumeno'              =>$valume,
	                    );
	                    
	                    $st=$this->efiling_model->insert_query('temp_documents_upload',$data);
	                    echo json_encode(['data'=>'success','error' => '0','file_name'=>$final_doc_url]);
	                }
	        }
	    }
	    else
	        echo json_encode(['data'=>'Invalid request foud, try with valid details','error' => '1','file_name'=>'']);
	}


		/*basic details*/
		public function saveBasicDetails()
		{
				
			$saltval=$this->session->userdata('salt');
			$salt=$this->input->post('saltNo');
			$sectionFiledset=$this->input->post('fieldset');
			switch($sectionFiledset):
				case 111:
					if($this->form_validation->run('basicDetails')==FALSE)
					{
						echo json_encode(['error'=>validation_errors(),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
					}
					if($this->db->get_where('aptel_temp_commision',['salt'=>$salt])->num_rows()==0)
					{
						echo json_encode(['error'=>'Please Add commission First !',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);die;
					}

					$postdata=array(
						'salt'=>$salt,
						'bench'=>$this->input->post('bench'),
						'sub_bench'=>$this->input->post('subBench'),
						'l_case_no'=>$this->input->post('caseNo'),
						'l_case_year'=>$this->input->post('caseYear'),
						'l_case_type'=>$this->input->post('caseType'),
						'l_date'=>$this->input->post('ddate111'),
						'no_of_pet'=>$this->input->post('totalNoAnnexure'),
						'comm_date'=>$this->input->post('comDate'),
						'commission'=>$this->input->post('comm'),
						'nature_of_order'=>$this->input->post('order'),
						'lower_case_type'=>$this->input->post('oth'),
						'petsubsection'=>$this->input->post('petSubSection1'),
						'petsection'=>$this->input->post('petSection'),
						'tab_no'=>$this->input->post('tabno'),
						'act'=>$this->input->post('act'),
						'user_id'=>"$this->user_id",
						'no_of_impugned'=>$this->input->post('totalNoImpugned'),
						'ass_code'=>$this->input->post('ass_code'),
						'pre_code'=>$this->input->post('pre_code'),
						'iec_code'=>$this->input->post('iec_code'),
						'loc_code'=>$this->input->post('loc_code'),
						'locc_code'=>$this->input->post('locc_code'),
						);
						if($this->input->post('pan_code')!=''){
							$postdata['pan_code']=decodePan($this->input->post('pan_code'));
						}
						

					if($this->db->where('salt',$salt)->get('aptel_temp_appellant')->num_rows() > 0){
						$this->db->where(['salt'=>$salt])->update('aptel_temp_appellant',$postdata);
					}else{
						$this->db->insert('aptel_temp_appellant',$postdata);
					}
					

					if($this->db->affected_rows() > 0){
						echo json_encode(['success'=>'true',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
					}else{
						echo json_encode(['error'=>'Something went wrong !',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
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
					$query=$this->db->get_where('temp_check_list',['salt'=>$salt]);

					if($query->num_rows()>0):
					$this->db->where(['salt'=>$salt])->update('temp_check_list',$temp_cheklist);
					else:
					$this->db->insert('temp_check_list',array_merge(['salt'=>$salt],$temp_cheklist));
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
					
						'iec_code'=>$this->input->post('iec_code'),
						'loc_c'=>$this->input->post('loc_code'),
					];
					if($this->input->post('pan_code')!=''){
							$temp_cheklist['pan_code']=decodePan($this->input->post('pan_code'));
						}
					
					$query=$this->db->get_where('temp_check_list',['salt'=>$salt]);
					if($query->num_rows()>0):
						$this->db->where(['salt'=>$salt])->update('temp_check_list',$temp_cheklist);
					else:
						$this->db->insert('temp_check_list',array_merge(['salt'=>$salt],$temp_cheklist));
					endif;
					if($this->db->affected_rows() > 0){
						echo json_encode(['success'=>'true',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
					}else{
						echo json_encode(['error'=>'Something went wrong !',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
					}
					break;
										
					default:
						$params=['salt'=>$salt,"docid in (select id from master_document_efile where doctype='appRequire')"=>null];
						$getRequiredDoc= $this->db->get_where('temp_documents_upload',$params)->result_array();
						//echo $this->db->last_query();
						
						//chek required doc
						$docRequire =$this->db->select("id")->get_where('master_document_efile',['doctype' =>'appRequire']);
						
						if(count($getRequiredDoc)< $docRequire->num_rows()):
						echo json_encode(['error'=>'Please Upload All Documents First','a'=>$this->db->last_query(),$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
						else:					
						echo json_encode(['success'=>'true',$this->security->get_csrf_token_name()=>$this->security->get_csrf_hash()]);
						endif;

				endswitch;

		}
		
		
		function required_docsedit($csrf=NULL){
			
			//ini_set('display_errors',1);
//error_reporting(E_ALL);
	    $token=hash('sha512',trim($_REQUEST['token']).'upddoc');
	    $userdata=$this->session->userdata('login_success');
	    $user_id=$userdata[0]->id;
	    $matter=$_REQUEST['matter'];
	    $filing_no=$this->session->userdata('refiling_no');
	    if($_FILES && $token==$csrf && $this->input->post('salt') > 0) {
	        $config=[
	            ['field'=>'party_type', 'label'=>'Please select valid document filed by','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_]+$/]'],
	            ['field'=>'req_dtype', 'label'=>'Please select valid document type','rules'=>'trim|max_length[100]|regex_match[/^[A-Za-z_\/)(\ ]+$/]'],
	            ['field'=>'userfile', 'label'=>'','rules'=>'trim|max_length[5000]|callback_mimeType']
	        ];
	        $this->form_validation->set_rules($config);
	        if($this->form_validation->run()==FALSE) {
	            $returnData=['data'=>'','error' => strip_tags(validation_errors())];
	            echo json_encode($returnData); exit();
	        } else {
	            
	            $fl_path=UPLOADPATH;
				$salt=$this->input->post('salt');
	            $schemas=$this->getSaltDocLocation($salt).'/';
				$date=date('d-m-Y');

				$step_3=$fl_path.'/'.$schemas;
				if(!is_dir($step_3)) {
					mkdir($step_3, 0777, true);
					chmod($step_3,0777);
					//  /cestat_documents/107079
				}

				$step1=$step_3.'/'.$date;

	            $step2=$step1.'/'.$salt.'/';
	            $typeval=$this->input->post('type');
	            $submittype=$this->input->post('submittype');
	            $docvalid=$this->input->post('docvalid');
	            $pty=$this->input->post('party_type');
	            $step3=$step2.$pty.'/';
	            $rqd_flnm=strtr($this->input->post('req_dtype'),['/'=>'_',' '=>'_']);
	           if(!is_dir($step1)) {
	                mkdir($step1, 0777, true);
					chmod($step1,0777);
				   //  /cestat_documents/107079/2023-01-01
	            }
	            if(!is_dir($step2)) {
	                mkdir($step2, 0777, true);
					chmod($step2,0777);
					//  /cestat_documents/107079/2023-01-01/0707900000012023/
	            }
	            if(!is_dir($step3)) {
	                mkdir($step3, 0777, true);
					chmod($step3,0777);
					//  /cestat_documents/107079/2023-01-01/0707900000012023/appelants
	            }
	            $valume='';
	            $docname=$_FILES['userfile']['name'];
	            $array=explode('.',$_FILES['userfile']['name']);
	            $config['upload_path']   		= $step3;
	            $config['allowed_types'] 		= 'jpg|jpeg|gif|png|pdf';
	            $config['max_size']      		= '20000000';
	            $config['overwrite']	   		= TRUE;
	            $config['file_ext_tolower']	= TRUE;
	            $config['file_name']=$rqd_flnm.'_'.date('dmYHis').'.'.strtolower(end($array));
	            $this->load->library('upload', $config);
	            
	           /* $array=array('docid'=>$docvalid,'filing_no'=>$filing_no);
				$docquery=$this->db->get_where('efile_documents_upload',$array);
				if($docquery->num_rows()>0){
					$docval=$docquery->result();

					$this->db->query("insert into efile_documents_upload_old select * from efile_documents_upload where docid=? and filing_no=? and user_id=?",[$docvalid,$filing_no,$this->user_id]);

					$this->efiling_model->muldeleteevent('efile_documents_upload',$array);
	            }*/
	            if(!$this->upload->do_upload('userfile') && $this->upload->data('file_name'))
	                echo json_encode(['data'=>'','error' => strip_tags($this->upload->display_errors()),'file_name'=>'']);
	                else 	{
	                    $final_doc_url=$step3.$config['file_name'];
	                    $pages=$this->countPages($final_doc_url);
	                    $data=array(
	                        'filing_no' 			=>$filing_no,
	                        'user_id' 				=>$user_id,
	                        'document_filed_by' 	=>$pty,
	                        'matter' 	            =>$matter,
	                        'no_of_pages'           =>$pages,
	                        'document_type' 		=>$rqd_flnm,
	                        'file_url' 				=>$final_doc_url,
	                        'doc_type' 				=>$typeval,
	                        'submit_type'           =>$submittype,
	                        'docid'                 =>$docvalid,
	                        'doc_name'              =>$docname,
	                        'valumeno'              =>$valume,
	                    );
	                    $st=$this->efiling_model->insert_query('efile_documents_upload',$data);
	                    echo json_encode(['data'=>'success','error' => '0','file_name'=>$final_doc_url]);
	                }
	        }
	    }
	    else
	        echo json_encode(['data'=>'Invalid request foud, try with valid details','error' => '1','file_name'=>'']);
	}
	
	

}//**********END Main function ************/