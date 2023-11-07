<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Efiling_model extends MY_Model {

    function user() {
        parent::Model();

    }
    
    function get_single_table($table){
        $this->db->where('status', '1');
        $query = $this->db->get($table);
        $data = $query->result();
        return $data;
    }
    

   
    function  ia_data_list($table,$array,$col,$order){
        $this->db->where_not_in($col,$array) ;
        $this->db->from($table);
        $this->db->order_by($order,'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    
    
    function  ia_dataIN_list($table,$array,$col,$order){
        $this->db->where_in($col,$array) ;
        $this->db->from($table);
        $this->db->order_by($order,'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    

    function data_list($table){
        $this->db->from($table);
        $query = $this->db->get();
        // echo $str = $this->db->last_query();
        return $query->result();
    }
    
    
    
    function getColumn($table,$requestcolumn,$col,$id){
        $this->db->select($requestcolumn);
        $this->db->from($table);
        $this->db->where($col,$id);
        return $this->db->get()->row()->$requestcolumn;
    }
    
    
    
    function data_list_mulwhere($table,$array){
        $this->db->where($array);
        $this->db->from($table);
        $query = $this->db->get();
        // echo $str = $this->db->last_query();
        return $query->result();
    }

    function data_list_rpepcp($table,$col,$id){
        $this->db->from($table);
        $ages=array(5,6,7,6);
        $this->db->where_in('case_type',$ages);
        $this->db->where($col,$id);
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
    
    
    
    
    function data_list_where($table,$col,$id){
        $data=$this->db->select('*')
        ->get_where($table,[$col=>$id])
        ->result();
        return $data;
    }
    
    function data_list_commission($table,$where_cond){        
        $data=$this->db->select('*')->get_where($table,$where_cond);
        if($data->num_rows()>0) return $data->result();
        else return false;
    }

    function data_commission_whereCC($salt,$userID){
        $query="select a.case_no,a.case_year,a.comm_date,a.decision_date,a.modified_date,b.org_name as full_name,c.case_type_name,
        d.full_name as nature_name from aptel_temp_commision a,iss_auth_master b,case_type_master c,master_nature_of_order d
        where d.nature_code=CAST(a.nature_of_order AS INTEGER) and c.case_type_code=CAST(a.lower_court_type AS INTEGER) 
        and b.org_code=CAST(a.commission AS INTEGER) and a.salt='$salt' and a.created_user='$userID';";
        $data=$this->db->query($query);
       // echo $this->db->last_query();
        if($data->num_rows()>0) return $data->result();
        else return false;
    }
     function data_commission_where($salt,$userID){
        $query="select a.case_no,a.case_year,a.comm_date,a.decision_date,a.modified_date,b.org_name as full_name,C.desg_name as case_type_name,
        d.full_name as nature_name from aptel_temp_commision a,iss_auth_master b,iss_desig_master c,master_nature_of_order d
        where d.nature_code = CAST ( A.lower_court_type AS INTEGER ) 	AND 	C.desg_code = CAST ( A.nature_of_order AS INTEGER ) 	AND
		b.org_code = CAST (a.commission AS INTEGER) and a.salt='$salt' and a.created_user='$userID';";
        $data=$this->db->query($query);
       // echo $this->db->last_query();
        if($data->num_rows()>0) return $data->result();
        else return false;
    }
    

    
    
    function getCaseType(){
        //$this->db->where('flag', '1');
        $array=array('7','2');
       // $this->db->where_not_in('case_type_code',$array) ;
        $this->db->from('case_type_master');
        $this->db->order_by('case_type_code','ASC');
        $query = $this->db->get();
        return $query->result();
      //  echo $this->db->last_query();
    }
    
    
    function getCaseTypeia(){
       // $this->db->where('flag', '1');
        $array=array('1','5','6','7','4');
        $this->db->where_in('case_type_code',$array) ;
        $this->db->from('master_case_type');
        $this->db->order_by('case_type_code','ASC');
        $query = $this->db->get();
        return $query->result();
        //  echo $str = $this->db->last_query();
    }
    
    
    function feedetailia(){
        $array=array('11','9');
        $this->db->where_in('doc_code',$array) ;
        $this->db->from('master_fee_detail');
        $this->db->order_by('doc_code','ASC');
        $query = $this->db->get();
        return $query->result();
        //  echo $str = $this->db->last_query();
    }
    
    function getia($table,$col,$ids){
        $this->db->where_in($col,$ids) ;
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result();
        //  echo $str = $this->db->last_query();
    }
    
    
    
    
    
    function getCaseTyperpcpep(){
        $this->db->where('flag', '1');
        $array=array('4','1');
        $this->db->where_in('case_type_code',$array) ;
        $this->db->from('master_case_type');
        $this->db->order_by('case_type_code','ASC');
        $query = $this->db->get();
        return $query->result();
        //  echo $str = $this->db->last_query();
    }
    
    
    function getDistrictlist($stateCode,$distcode){
        $this->db->from('master_psdist');
        $this->db->where(array('state_code'=>$stateCode,'district_code'=>$distcode));
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
    
    
    function select_in($table,$arr){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($arr);
        $query = $this->db->get();
        $data = $query->result();
      //  echo $str = $this->db->last_query();die;
        return $data;
    }
    
    
    function select_inparty($table,$arr){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($arr);
        $this->db->order_by('partysrno','ASC');
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
    
    
    
    function update_data_where($table, $where, $data){
        $this->db->where($where);
        $query = $this->db->update($table, $data);
      //  echo $str = $this->db->last_query();die;
        return $query;
    }
    

    
    
    function geRecorappeal($table,$userid){
        $this->db->from($table);
        $this->db->where(array('case_type'=>'1','filed_user_id'=>$userid));
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
    

    function gerpepcp($table,$userid){
        $this->db->from($table);
        $ages=array(5,6,7,6);
        $this->db->where_in('case_type',$ages);
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }

    function getdistric($table,$col){
        $this->db->from($table);
        $this->db->where('state_id', $col);
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
    
    
    function insert_query($table, $data){
        $query = $this->db->insert($table, $data);
        return $query;
    }
    
    function edit_data($table,$col, $id){
        $query = $this->db->get_where($table, array($col=>$id));
        $data = $query->row();
        return $data;
    }
    
    function update_data($table, $data, $idname, $id){
        $this->db->where($idname, $id);
        $query = $this->db->update($table, $data);
        return $query;
    }
    
    function delete_event($table, $col, $id){
        $this->db->where($col, $id);
        $delqu = $this->db->delete($table);
        return $delqu;
        
    }
    
    function geIA($table,$ia,$year){
        $query=$this->db->query("select * from $table where ia_no='$ia' and SUBSTR(ia_filing_no,12,4)='$year'");
        return $query->result();
    }
    
    
    
    function createSlug($slug) {
        $lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
        $spacesDuplicateHypens = '/[\-\s]+/';
        $slug = preg_replace($lettersNumbersSpacesHyphens, '', $slug);
        $slug = preg_replace($spacesDuplicateHypens, '-', $slug);
        $slug = trim($slug, '-');
        return mb_strtolower($slug, 'UTF-8');
    }
    
    
    function undersection(){
        $html='';
        $state=$_REQUEST['state_id'];
        $case_typed = $_REQUEST['case_typed'];
        if($state==''){
            echo "<option>Select Under Section</option>";
        }else{
            $this->db->where('act_code',$state);
            $this->db->from('master_under_section');
            $query = $this->db->get();
            $val= $query->result();
            foreach($val as $row){
                $html.='<option value="'.$row->section_code.'">'.$row->section_name.'</option>';
            }
            echo $html;die;
          }
     }
  
     
     
     
     
     
     


    function findrecord($vl){
         $vals='';
         $case_type='1';
         if($vl['type']=='1'){
             $fno=$vl['filing_no'];
             $year=$vl['dfr_year'];
             $vals=$this->recordfing('aptel_case_detail',$fno,$year,$case_type);
         }
         if($vl['type']=='2'){
             $cno=$vl['case_no'];
             $year=$vl['year'];
             $case_type=$vl['case_type'];
             $vals=$this->caserecordfing('aptel_case_detail',$cno,$year,$case_type);
         }
         return $vals;
     }
    
      function getpartyname($table,$col, $id,$pid){
         $query_str="select * from additional_party where filing_no='$id' and  party_id IN($pid)";
         $query=$this->db->query($query_str);
         return $query->result();
     }
     
     function getadditionalPartydetail($table,$filing_no,$party_flag,$isd){
         $query_str="select * from additional_party where filing_no='$filing_no' and party_flag='$party_flag'";
         $query=$this->db->query($query_str);
         return $query->result();
     }

    function fn_addition_party($filing_no,$flag_type) {
         $pet_others = '';
         $sqlpet ="select party_flag from additional_party where filing_no='$filing_no' and party_flag='$flag_type'";
         $query=$this->db->query($sqlpet);
         $data = $query->result();
         $totalpet =count($data)+1;
         if ($totalpet == 1) {
             $pet_others =  " ";
         }
         if ($totalpet == 2) {
             $pet_others =  " & Anr.";
         }
         if ($totalpet > 2) {
             $pet_others =  " & Ors.";
         }
         return $pet_others;
     }
     
     
     
     function fn_addition_partyr($filing_no,$flag_type) {
         $pet_others = '';
         $sqlpet ="select party_flag from additional_party where filing_no='$filing_no' and party_flag='$flag_type'";
         $query=$this->db->query($sqlpet);
         $data = $query->result();
         $totalpet =count($data)+1;
         if ($totalpet == 1) {
             $pet_others =  " ";
         }
         if ($totalpet == 2) {
             $pet_others =  " & Anr.";
         }
         if ($totalpet > 2) {
             $pet_others =  " & Ors.";
         }
         return $pet_others;
     }
     
     
     function  scrutiny(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id; 
         if($user_id){
             $query_str="select ap.filing_no from aptel_case_detail as ap left join scrutiny as s on s.filing_no=ap.filing_no where ap.filed_user_id='$user_id' AND s.defects ='Y'";
             $query=$this->db->query($query_str);
             return $query->result();
         }
     }
     
     
     function  scrutiny_list(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $query_str="select * from aptel_case_detail as ap left join scrutiny as s on s.filing_no=ap.filing_no where ap.filed_user_id='$user_id' AND  s.defects IS NULL";
             $query=$this->db->query($query_str);
             return $query->result();
         }
     }
     
     function defective_list(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
            $query_str="select * from aptel_case_detail as ap left join scrutiny as s on s.filing_no=ap.filing_no where ap.filed_user_id='$user_id' AND s.objection_status='Y'";
             $query=$this->db->query($query_str);
             return $query->result();
         }
     }
	 
	 function defectiveCaselist(array $params)
	 {
       
	   $query= $this->db->select("ac.*,s.*")
        ->from('aptel_case_detail as ac')
        ->join('case_detail as cd','ac.filing_no=cd.filing_no')
        ->join('scrutiny as s','s.filing_no=ac.filing_no')
        ->where($params)
        ->get();
		return $query->result();         
     }
     
     
     function registerdcases_list(){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         if($user_id){
             $query_str="select * from aptel_case_detail where (case_no!='' OR case_no is NOT null)  AND filed_user_id='$user_id'";
             $query=$this->db->query($query_str);
             return $query->result();
         }
     }
     
     
     

     
     
     
     
     function createdfr($filing_no){

         return  LTRIM(substr($filing_no,7,5),'0').'/'.substr($filing_no,-4);

     }
  function defectivelistdfr($filing_no){
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        if($user_id){
             $query_str="select * from aptel_case_detail as ap left join scrutiny as s on s.filing_no=ap.filing_no where
                ap.filed_user_id='$user_id' AND s.filing_no='$filing_no' AND s.objection_status='Y'";
            $query=$this->db->query($query_str);
            return $query->result();
        }
    }     
     
     function createcaseno($dfr){
         $query_str="select acd.res_name,acd.case_no,mct.short_name from aptel_case_detail as acd LEFT JOIN master_case_type mct ON acd.case_type=mct.case_type_code  where acd.filing_no= '$dfr'";
         $query=$this->db->query($query_str);
         $valsc=$query->result();
         $res_name= $valsc[0]->res_name;
         $case_no= $valsc[0]->case_no;
         $case_tye= $valsc[0]->short_name;
         //Case No
         $valc='';
         if($case_no!=''){
             $valc= substr($case_no,-8);
             $ac=substr_replace($valc ,"",-4);
             $bc= substr($valc, -4);
             $valc=$case_tye . -$ac.'/'.$bc;
         }
         return $valc;
     }


     public function getData($post_data=NULL,$col=NULL,$id=NULL){
        $table=$post_data['db_table'];
        $ctype=$post_data['ctype'];
        if(strtolower($ctype)=='all') {
            $data=$this->db->select('to_char(update_on, \'dd-mm-YYYY HH24:MI:SS\') as update_on,salt,pet_name,bench,sub_bench,tab_no,(select name from master_benches where bench_code=bench) as name,(select state_name from master_psstatus where state_code=CAST(sub_bench AS INTEGER)) as state_name')
            ->order_by('update_on','desc')
            ->get_where($table,[$col=>$id]);
        }
        else if(strtolower($ctype) == 'ia'){
            //SELECT * FROM "rpepcp_reffrence_table" WHERE "case_type" = 'IA' AND "user_id" = '59'
            $data=$this->db->select('to_char(update_on, \'dd-mm-YYYY HH24:MI:SS\') as update_on,salt,pet_name,bench,sub_bench,tab_no,(select name from master_benches where bench_code=bench) as name,(select state_name from master_psstatus where state_code=CAST(sub_bench AS INTEGER)) as state_name')
            ->where($col,$id)
            ->where_in('l_case_type',explode(",",$ctype))
            ->order_by('update_on','desc')
            ->get($table);
        }
        else{
            $data=$this->db->select('\'\' as update_on,salt,pet_name,bench,sub_bench,tab_no,(select name from master_benches where bench_code=bench) as name,(select state_name from master_psstatus where state_code=CAST(sub_bench AS INTEGER)) as state_name')
            ->where($col,$id)
            ->where_in('l_case_type',explode(",",$ctype))
            ->get($table);
        }
        //exit($this->db->last_query());
        if($data->num_rows()>0) {
            foreach($data->result() as $data_val) :;
                $pet_name=$data_val->pet_name;
                $salt=$data_val->salt;
                $name=$data_val->name;
                $state_name=$data_val->state_name;
                $tab_no=$data_val->tab_no;
                $update_on=$data_val->update_on;
                if(is_numeric($pet_name)){
                    $org_name=$this->db->select('org_name')->get_where('master_org',['org_id'=>(int)$pet_name])->row()->org_name;
                    $pet_name=$org_name;
                }
                $final_data[]=['pet_name'=>$pet_name,'salt'=>$salt,'name'=>$name,'state_name'=>$state_name,'tab_no'=>$tab_no,'update_on'=>$update_on];
            endforeach;
            return @$final_data;
        }
        else return false;
     }

     function list_uploaded_docs($table, $wcond){
		 
		 
        $rs=$this->db->select('document_filed_by, document_type, no_of_pages, file_url,doc_name, id,doc_type, update_on,matter,valumeno')
                     ->where($wcond)
                     ->order_by('document_filed_by ASC, update_on ASC')
                     ->get($table);
					 
					 

        if($rs->num_rows() > 0) return $rs->result();
        else false;
     }
     
     function getToken(){ 
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $token=rand(1000,9999);
         $md_dbc = hash('sha256',$token.'@'.$user_id);
         $this->session->set_userdata('submittoken',$md_dbc);;
         return $md_dbc;
     }
     
     function getCaseDetailsCaseNo($cno,$year,$case_type){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $caseYear =  $year;
         $caseNo =  $cno;
         $case_type1 = $case_type;
         $detail = "DFR No Detail";
         $diaryYear1 = $caseYear;
         $clen = strlen($case_type1);
         $clength = 3 - $clen;
         for ($c = 0; $c < $clength; $c++){
             $case_type1 = "0" . $case_type1;
             $clen = strlen($caseNo);
             $clength = 7 - $clen;
             for ($c = 0; $c < $clength; $c++){
                 $caseNo = "0" . $caseNo;
                 if ($caseNo == 000000){
                     $caseNo = '';
                     $chr = 4;// this for first hard code digit of filing no
                     $c_no = $chr . $case_type1 . $caseNo . $caseYear;
                     $query_str="SELECT * FROM aptel_case_detail  where case_no ='$c_no' AND user_id='$user_id'";
                     $query=$this->db->query($query_str);
                     return $data = $query->result();
                 }
             }
         }
     }

    function getCaseByCaseNo(array $params) //16/12/2022 rana
    {
        $c_no= $params['case_no'];
        $schemas=$params['schemas'];
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;


                    $query_str="SELECT * FROM aptel_case_detail  where case_no ='$c_no' AND user_id='$user_id'";
                    $query=$this->db->query($query_str);
                    return $data = $query->result();



    }
     
     function getCaseDetailsDfr($fno,$year){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $detail = "Case No Details";
         $diaryYear1 = $year;
         $bench = 100;
         $subBench = 1;
         $subBenchCode = htmlspecialchars(str_pad($subBench, 2, '0', STR_PAD_LEFT));
         $len = strlen($fno);
         $length = 6 - $len;
         for ($i = 0; $i < $length; $i++) {
             $diaryNo = "0" . $fno;
         }
         $filing_no_old = $bench . $subBenchCode . $diaryNo . $diaryYear1;
         $filing_no_old = $diaryNo . $diaryYear1;  // change ravi kumar dubey
         $query_str="SELECT * FROM aptel_case_detail  where filing_no like '%$filing_no_old' AND user_id='$user_id'";
         $query=$this->db->query($query_str);
         return $data = $query->result();
     }
    /*modify by rana 16/12/2022*/
    function getCaseDetailsByDfr(array $params){

        $filing_no_old=$params['filing_no'];
        $userdata=$this->session->userdata('login_success');
        $user_id=$userdata[0]->id;
        $query_str="SELECT * FROM aptel_case_detail   where filing_no like '%$filing_no_old' AND user_id='$user_id'";
        $query=$this->db->query($query_str);
        return $data = $query->result();
    }
     
     
     function getCaseDetailsCaseNodoc($cno,$year,$case_type){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $caseYear =  $year;
         $caseNo =  $cno;
         $case_type1 = $case_type;
         $detail = "DFR No Detail";
         $diaryYear1 = $caseYear;
         $clen = strlen($case_type1);
         $clength = 3 - $clen;
         for ($c = 0; $c < $clength; $c++){
             $case_type1 = "0" . $case_type1;
             $clen = strlen($caseNo);
             $clength = 7 - $clen;
             for ($c = 0; $c < $clength; $c++){
                 $caseNo = "0" . $caseNo;
                 if ($caseNo == 000000){
                     $caseNo = '';
                     $chr = 4;// this for first hard code digit of filing no
                     $c_no = $chr . $case_type1 . $caseNo . $caseYear;
                     $query_str="SELECT * FROM aptel_case_detail  where case_no ='$c_no'";
                     $query=$this->db->query($query_str);
                     return $data = $query->result();
                 }
             }
         }
     }
     
     
     
     function getCaseDetailsDfrdoc($fno,$year){
         $userdata=$this->session->userdata('login_success');
         $user_id=$userdata[0]->id;
         $detail = "Case No Details";
         $diaryYear1 = $year;
         $bench = 100;
         $subBench = 1;
         $subBenchCode = htmlspecialchars(str_pad($subBench, 2, '0', STR_PAD_LEFT));
         $len = strlen($fno);
         $length = 6 - $len;
         for ($i = 0; $i < $length; $i++) {
             $diaryNo = "0" . $fno;
         }
         $filing_no_old = $bench . $subBenchCode . $diaryNo . $diaryYear1;
         $filing_no_old = $diaryNo . $diaryYear1;  // change ravi kumar dubey
         $query_str="SELECT * FROM aptel_case_detail  where filing_no like '%$filing_no_old' ";
         $query=$this->db->query($query_str);
         return $data = $query->result();
     }
     
     
  
     
     
     function  getDFRformate($val){
         $filing_No = substr($val, 5, 6);
         $filing_No = ltrim($filing_No, 0);
         $filingYear = substr($val, 11, 4);
         return  $this->lang->line('dfrno')."/".LTRIM(substr($val,7,5),'0')."/".substr($val,-4);
     }
     
     function  getCASEformate($val){
		 if(is_numeric($val)):
         $filing_No = substr($val, 5, 6);
         $filing_No = ltrim($filing_No, 0);
         $filingYear = substr($val, 11, 4);
         if($filingYear!=''){
            return  "APP/$filing_No/$filingYear";
         }
		 endif;
         return '';
     }

     function getPartydetail($filing_no,$party_flag){
         $this->db->from('additional_party');
         $this->db->where(array('filing_no'=>$filing_no,'party_flag'=>$party_flag));
         $this->db->order_by('partysrno','ASC');
         $query = $this->db->get();
         $data = $query->result();
         return $data;
     }
	/*fee calulate on 3/1/2023*/ 
	function feeCalculate(array $params)
    {
		if(trim($this->session->userdata('login_success')[0]->user_type)=='company'):
			return ['success'=>true,'feeAmount'=>0];
		endif;
        $salt=$params['salt'];
        /*fee calculation for appeal*/
        if(array_key_exists('caseType',$params)):

             $partyType=($params['partyType'])?$params['partyType']:2;

            /*appelant base fee*/
            switch($partyType):
                case 1: //department
                    return ['success'=>true,'feeAmount'=>0];
                    break;
                default: //public

                $caseType=$params['caseType'];
                $tempFeeData=getTempChekListData(['salt'=>$salt]);
                if(empty($tempFeeData)):
                    return ['error'=>true];
                else:
                    $orderArray['duty_tax_ord'] = $duty_tax_ord =$tempFeeData['duty_tax_ord'];
                    $orderArray['penalty_ord']= $penalty_ord =$tempFeeData['penalty_ord'];
                    $inter_ord =$tempFeeData['inter_ord'];
                    $refund_ord =$tempFeeData['refund_ord'];
                    /*
                     *  Appeal fee...
                     * 	if the amount(duty+panelty+Interest) is in between 1 to 5 lakhs fees is 1000/-..
                     *  if the amount(duty+panelty+Interest) is in between 5 to 50 lakhs fees is 5000/-..
                     *	if the amount(duty+panelty+Interest) is greater than 50 lakhs fees is 10000/-..
                     *
                     * if case type antidumping(4) then fees is 15000/-..
                     * */
                    $final_price= $duty_tax_ord+$penalty_ord+$inter_ord;
                    switch($caseType):
                        case 4:
                            $total_fee_price=15000;
                            break;
                        default:
                            if($final_price >=0 && $final_price <=500000 ){ $total_fee_price=1000;} //0-5lakh
                            if($final_price >500000 && $final_price <=5000000 ){ $total_fee_price=5000;} //5lakh - 50lakhs
                            if($final_price >5000000){ $total_fee_price=10000;} //50lakh above
                    endswitch;

                    /*
                     *
                     * if impugned oredr 1 ten 10%
                     * if impugned oredr 2 ten 7.5%
                     * another case it was 0%
                     *
                     * when duty and penalty exist then  caluculate on duty
                     * incase penalty not exist then duty
                     * incase duty not exist then panelty
                     * */
                    $biggest =max($orderArray);
                    /*$impugnedType=$params['impugnedType'];
                    switch($impugnedType):
                        case 1:	$precentage=10;break;
                        case 2: $precentage=7.5;	break;
                        default: $precentage=0;
                    endswitch;
                    $precentageAmount =$precentage/100*$biggest;
                    $finalAmount =$total_fee_price+$precentageAmount;*/

                    return ['success'=>true,'feeAmount'=>$total_fee_price];
                    endif;

            endswitch;
        endif;

        /*fee calculation for application*/
        if(array_key_exists('applicationType',$params)):
            $partyType=($params['partyType'])?$params['partyType']:2;
            /*appelant base fee*/
            switch($partyType):
                case 1: //department
                    return ['success'=>true,'feeAmount'=>0];
                    break;
                default: //public

                    if($params['applicationType']==6)://cross application then fees zero
                        return ['success'=>true,'feeAmount'=>0];
                    else:
                        return ['success'=>true,'feeAmount'=>500];
                        endif;
            endswitch;
        endif;



    }
	/*
	 * cestat code
	 */
public function getAppDetails(array $params,$schemas)
{
    $sth=$this->db->get_where($schemas.'.case_detail',$params);
    if($sth->num_rows()>0):
        return $sth->result();
    endif;
}


public function getApplDetails(array $params,$schemas)
{
    $sth=$this->db->select("cd.*,ap.*,cd.status as mainstatus,ap.status as appstatus")
        ->from($schemas.".app_detail as ap")
    ->join($schemas.".case_detail as cd","cd.filing_no=ap.filing_no",'left')
    ->where($params)
    ->get();
	//echo $this->db->last_query();die;
    if($sth->num_rows()>0):
        return $sth->result();
    endif;
}
public function getCodDetails(array $params,$schemas)
{
    $sth=$this->db->select("cd.*,ap.*,cd.status as mainstatus,ap.status as appstatus")
        ->from($schemas.".app_cod as ap")
        ->join($schemas.".case_detail as cd","cd.filing_no=ap.filing_no",'left')
        ->where($params)
        ->get();
    if($sth->num_rows()>0):
        return $sth->result();
    endif;
}
public function getAdditionalParty(array $params,$schemas)
{
    $pet_others = '';
    $data=$this->db->get_where($schemas.'.additional_party_detail',$params)->result();

    $totalpet =count($data)+1;
    if ($totalpet == 1) {
        $pet_others =  " ";
    }
    if ($totalpet == 2) {
        $pet_others =  " & Anr.";
    }
    if ($totalpet > 2) {
        $pet_others =  " & Ors.";
    }
    return $pet_others;
}
public	function getAdditionalPartySting($filing_no,$party_flag)
{
    $pet_others = '';
    $this->db->from('additional_party_detail');
    $this->db->where(array('filing_no'=>$filing_no,'party_flag'=>$party_flag));
    $this->db->order_by('party_serial_no','ASC');
    $query = $this->db->get();
    $data = $query->result();

    $totalpet =count($data)+1;
    if ($totalpet == 1) {
        $pet_others =  " ";
    }
    if ($totalpet == 2) {
        $pet_others =  " & Anr.";
    }
    if ($totalpet > 2) {
        $pet_others =  " & Ors.";
    }
    return $pet_others;
}
public function insertApplication(array $params,$schemas)
{
    if(array_key_exists('appmainfiling_no',$params))
        $this->db->insert($schemas.'.app_cod',$params);else
    $this->db->insert($schemas.'.app_detail',$params);
    return ($this->db->affected_rows()>0);
}
public function insertAddtionalAppl(array $params,$schemas)
{
    $this->db->insert($schemas.'.additional_party_detail',$params);
    return ($this->db->affected_rows()>0);
}
public function insertAdvocateAdditional(array $params,$schemas)
{
    $this->db->insert_batch($schemas.'.advocate_additional',$params);
    return ($this->db->affected_rows()>0);
}
public function insertFees(array $params,$schemas)
{
    $this->db->insert_batch($schemas . '.fee_detail', $params);
    return ($this->db->affected_rows() > 0);
}


public function getAppFiledList(array $params,$fields="*")
    {
        return $this->db->select($fields)->from('case_detail as cd')
            ->join('scrutiny as sc','sc.filing_no=cd.filing_no')
            ->where($params)
            ->get();
    }
    public function getApplFiledList(array $params,$fields="*")
    {
        return $this->db->select($fields)->from('app_detail as app')
            ->join('scrutiny_app as sc','sc.filing_no=app.appfiling_no')
            ->join('case_detail as cd','cd.filing_no=app.filing_no','Left')
            ->where($params)
            ->get();
    }
    public function getCodFiledList(array $params,$fields="*")
    {
        return $this->db->select($fields)->from('app_cod as cod')
            ->join('scrutiny_app as sc','sc.filing_no=cod.appfiling_no')
            ->join('case_detail as cd','cd.filing_no=cod.filing_no','Left')
            ->where($params)
            ->get();
    }

    /*draft list*/
    public function getDrafAppList(array $params,$fields="*")
    {
        return $this->db->select($fields)->from('aptel_temp_appellant as cd')
            ->where($params)
            ->get();
    }
    public function getDratApplList(array $params,$fields="*")
    {
        return $this->db->select($fields)->from('rpepcp_reffrence_table as cd')
            ->where($params)
            ->get();
    }
    public function getDraftCodFList(array $params,$fields="*")
    {
        return $this->db->select($fields)->from('rpepcp_reffrence_table as cd')
            ->where($params)
            ->get();
    }



public function getAppWithAptel(array $params)
{
    return $this->db->select("cd.*,ac.*")
        ->from('case_detail as cd')
        ->join('aptel_case_detail as ac','ac.filing_no=cd.filing_no')
        ->where($params)
        ->get();

}
public function getImpugnedWithAptel(array $params)
{
    return $this->db->from('case_detail_impugned as cd')
        //->join('additional_commision as ac','ac.filing_no=cd.filing_no')
        ->where($params)
        ->get();
}

public function getAddPartydetail($filing_no,$party_flag){
        $this->db->from('additional_party_detail');
        $this->db->where(array('filing_no'=>$filing_no,'party_flag'=>$party_flag));
        $this->db->order_by('party_serial_no','ASC');
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }



public function getoncedoc($table,$params){
	$this->db->select('*');
        $this->db->from($table);
        $this->db->where($params);     
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
      
    function muldeleteevent($table, $array){
        $this->db->where($array);
        $delqu = $this->db->delete($table);
        return $delqu;
    }
	
public function getAppealDetails(array $params)
{
	$schemas='delhi';
	
	$this->db->select("*");
    $this->db->from($schemas.'.case_detail as cd ');
    $this->db->join('case_detail_impugned as ci','ci.filing_no=cd.filing_no','LEFT');
	$this->db->join('aptel_case_detail as ac','ac.filing_no=cd.filing_no','LEFT');
	$this->db->where($params);
	$sth=$this->db->get();
    if($sth->num_rows()>0):
        return $sth->result_array();
    endif;
}

}
?>