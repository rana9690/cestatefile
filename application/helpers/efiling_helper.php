<?php
//error_reporting(-1);
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 12/15/2022
 * Time: 9:30 AM
 */
/*15000 fees in antidumping z*/
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Calcutta');

function getSchemasNames($schemasId)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('initilization',['schemaid'=>$schemasId])->row();

}

function getTempAppellant(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $tempData=$ci->db->get_where('aptel_temp_appellant',$params)->row_array();
}

function getAdvocates($schemas,$params=array())
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('master_advocate',$params)->result_array();
}
function getAdvocatesObjects($schemas,$params=array())
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where($schemas.'.advocate_master',$params)->result();
}
function getActArray(array $params,$short)
{
    $ci=& get_instance();
    $ci->load->database();
    $result1[null]='SELECT';
    $ttt=$ci->db->get_where('master_energy_act',$params)->result_array();;
    foreach ($ttt as $val)
        $result1[$val['act_code']] = $val[$short];
    return  $result1;
}
function getStatesArray(array $params,$short)
{
    $ci=& get_instance();
    $ci->load->database();
    $result1[null]='SELECT';
    $ttt=$ci->db->get_where('master_psstatus',$params)->result_array();;
    foreach ($ttt as $val)
        $result1[$val['state_code']] = $val[$short];
    return  $result1;
}
function getCaseTypesArray(array $params,$short)
{
    $result1[null]='SELECT';
    $ttt=getCaseTypes($params);
    foreach ($ttt as $val)
        $result1[$val['case_type_code']] = $val[$short];
    return  $result1;

}
function getCaseTypes(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('case_type_master',$params)->result_array();
}
function getBenchesArray(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    $result1[null]='SELECT';
    $ttt=$ci->db->get_where('master_benches',$params)->result_array();
    foreach ($ttt as $val)
        $result1[$val['bench_code']] = $val['name'];
    return  $result1;
}

function getApplicationTypesArray(array $params)
{
    $result1[null]='SELECT';
    $ttt=getApplicationTypes($params);
    foreach ($ttt as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}
function getApplicationTypes(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('master_application_type',$params)->result_array();
}
function getIss_auth_master(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('iss_auth_master',$params)->result_array();
}
function getIss_auth_masters(array $params)
{   $result1[null]='SELECT';
    $ci=& get_instance();
    $ci->load->database();
    $result= $ci->db->get_where('iss_auth_master',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['org_code']] = $val['org_name'];
    return  $result1;
}
function getIssAuthDesignations(array $params)
{
    $result1[null]='SELECT';
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("desg_name,desg_code")->get_where('iss_desig_master',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['desg_code']] = $val['desg_name'];
    return  $result1;
}

function getOrg_name_master(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('org_name_master',$params)->result_array();
}
function generateFilingNo(array $params)
{
    return str_pad($params['state_code'],2,'0',STR_PAD_LEFT)
    .str_pad($params['district_code'],3,'0',STR_PAD_LEFT)
    .$params['complex_code']
    .str_pad($params['filing_no'],6,'0',STR_PAD_LEFT)
    .$params['year'];
}

function generateCaseNo(array $params)
{
    return '4'.str_pad($params['caseType'],3,'0',STR_PAD_LEFT)
    .str_pad($params['caseNo'],7,'0',STR_PAD_LEFT)
    .$params['caseYear'];
}
function generateApplCaseNo(array $params)
{
    return '4'.str_pad($params['caseType'],1,'0',STR_PAD_LEFT).str_pad($params['appCaseType'],2,'0',STR_PAD_LEFT)
    .str_pad($params['caseNo'],7,'0',STR_PAD_LEFT)
    .$params['caseYear'];
}
function getStates(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('master_psstatus',$params)->result();
}

function getImpugnedType(){
    return [
        ''=>'SELECT',
        1=>'ORDER IN APPEAL',
        2=>'ORDER IN ORIGINAL',
        3=>'REVIEW ORDER',
        4=>'REVISION ORDER',
        5=>'NOTIFICATION ORDER',
        6=>'STAY ORDER IN OIO/OIA',
    ];
}
function displayDiaryNo($filing_no)
{
	return  LTRIM(substr($filing_no,7,5),'0').'/'.substr($filing_no,-4);
}
function displayAppNo(array $params)
{
    if($params['caseNo']):
    return $params['caseType'].'/'
    .LTRIM(substr($params['caseNo'],7,'0')).'/'
    .substr($params['caseYear']-4);
        endif;
}
function displayAppNoTest(array $params)
{
	
	
    if($params['caseNo']):
    return $params['caseType'].'/'
    .LTRIM(substr($params['caseNo'],6,5),'0').'/'
    .substr($params['caseNo'],-4);
        endif;
}


function getOrgAssMastersArray(array $params)
{
    $result1[null]='SELECT';
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("org_name as name,org_code as code")->get_where('org_ass_master',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}
function getOrgAdjMastersArray(array $params)
{
    $result1[null]='SELECT';
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("org_name as name,org_code as code")->get_where('org_adj_master',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}
function getAdjDesgMastersArray(array $params)
{
    $result1[null]='SELECT';
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("desg_name as name,desg_code as code")->get_where('adj_desig_master',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}
function getAssDesgMastersArray(array $params)
{
    $result1[null]='SELECT';
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("desg_name as name,desg_code as code")->get_where('ass_desig_master',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}
function getSelectYesNoArray($params=array())
{
    return [
         ''=>'SELECT',
        1=>'YES',
        0=>'NO',
    ];
}
function getSubMatterPriorityArray(array $params)
{

    $result1=[];
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("priority as name,code")->get_where('sub_matter_pri',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}
function getIssueMasterArray(array $params)
{
    $result1=[0=>'SELECT'];
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("issue_name as name,issue_no as code")->get_where('issue_master',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}
function getPaymentModeDutyArray($params=array())
{
    return [
        ''=>'SELECT',
        1=>'Paid through cash/ e-payment',
        2=>'Paid out of Cenvat account',
        3=>'GAR-7',
        4=>'ITC',
        5=>'Appropriated by competent authority',

    ];
}
function getPaymentModePenaltyArray($params=array())
{
    return [
        ''=>'SELECT',
        1=>'By Cash',
        2=>'Challan',
        3=>'Reversal Entry',
    ];
}
function getYesNoArray($params=array())
{
    return [
        1=>'YES',
        0=>'NO',
    ];
}
function getUnderSection(array $params)
{
    $result1=[];
    $ci=& get_instance();
    $ci->load->database();
    $result=$ci->db->select("section_name as name,section_code as code")->get_where('master_under_section',$params)->result_array();
    foreach ($result as $val)
        $result1[$val['code']] = $val['name'];
    return  $result1;
}

function getTempAppelant(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('aptel_temp_appelant',$params)->row_array();

}
function getTempImpugned(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('aptel_temp_commision',$params)->row_array();

}
function getTempChekListData(array $params)
{
    $ci=& get_instance();
    $ci->load->database();
    return $ci->db->get_where('temp_check_list',$params)->row_array();

}
function getChekListData(array $params)
{

    $ci=& get_instance();
    $ci->load->database();
    $schemasid=substr($params['filing_no'],5,1).substr($params['filing_no'],0,5);
    $schemasData=getSchemasNames($schemasid);
    $schemas=$schemasData->schema_name;
    return $ci->db->get_where($schemas.'.check_list_customs',$params)->row_array();

}

function getSingleSchemas($filing_no)
{
    $ci=& get_instance();
    $ci->load->database();
     $schemaid=substr($filing_no,5,1).substr($filing_no,0,5);
     // return  $ci->db->get_where('initilization',['schemaid'=>$schemaId])->row_array();
    return $ci->db->get_where('initilization',['schemaid'=>$schemaid])->row_array();

}


function oredertype(){
    return ['O'=>'Daily Order','M'=>'Misc Order','F'=>'Final Order','I'=>'Misc Order 2','N'=>'Misc Order 3','J'=>'Misc Order 4'];
}

function getJudgeMaster($params=[],$order_by=null)
{
    $ci=& get_instance();
    $ci->load->database();
    $ci->db->select("jm.judge_code,concat(dm.desg_name,' ',jm.judge_name) as judge_name");
    $ci->db->from("judge_master as jm");
    $ci->db->join("desg_master as dm","dm.desg_code=jm.judge_desg_code",'Left');
    $ci->db->where($params);
    $query =$ci->db->get();
    return array_column($query->result_array(),'judge_name','judge_code');
}
function encodeOpenSsl($pancode)
{

    $ivBytes = '1212121212121212';
    $keyBytes = '1212121212121212';
    $message = openssl_encrypt($pancode, 'AES-128-CBC', $keyBytes, OPENSSL_RAW_DATA, $ivBytes);
    return base64_encode($message);
}
function decodeOpenSsl($pancode)
{
    $ivBytes = '1212121212121212';
    $keyBytes = '1212121212121212';
    $ctBytes = base64_decode($pancode);
    return openssl_decrypt($ctBytes, "AES-128-CBC", $keyBytes, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $ivBytes);
}
function decodePan($pancode)
{
	$ivBytes = hex2bin(IVVAL);
	$keyBytes = hex2bin(KEYVAL);
	$ctBytes = base64_decode($pancode);
	$decrypt = openssl_decrypt($ctBytes, "aes-256-cbc", $keyBytes, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $ivBytes);
	return strtoupper($decrypt);

}

function nextSteps()
{
	return [
		1=>"applicant-mod",
		2=>"respondentRefile",
		3=>"counselrefile",
		4=>"basicdetails-mod",
		5=>"ia_detailrefile",
		6=>"editother_fee",
		7=>"documentuploadedit",
		8=>"paymentmodeedit",
	];
}


function sendsms($msg,$mnumber,$dlttemp)
{
		//$msg='E- verification code for your mobile is 1234.OTP is valid for 15 minutes.CESTAT';
	 // $adv_mobile='7532993576';
      $uname  = urlencode("cuesat.otp");
      $pin    = urlencode("M5%oT0&aP8");
      //$mnumber= $adv_mobile;
      $send   = urlencode("CUESAT");	  
	  $dltid=urlencode('1001392643717389249');
	  //$dlttemp=urlencode('1407168257528701296');
	  $URL='https://164.100.14.211/failsafe/MLink?username='.$uname.'&pin='.$pin.'&message='.$msg.'&mnumber='.$mnumber.'&signature='.$send.'&dlt_entity_id='.$dltid.'&dlt_template_id='.$dlttemp;

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$URL);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	  curl_setopt($ch, CURLOPT_VERBOSE,true);
		$curl_output = curl_exec($ch); 
      //echo $curl_output =htmlentities(htmlspecialchars($curl_output));
}



function send_mail($to_add,$subject,$msg){
	//$this->load->library('PHPMailer');
date_default_timezone_set('Asia/Calcutta');
$d = date("Y-m-d");
//require_once('class.phpmailer.php');
$mail = new PHPMailer();
$mail->Body = $msg;
$mail->IsHTML(true);
$mail->IsSMTP(); // telling the class to use SMTP
//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
//$mail->SMTPDebug  = 0;   // 1 = errors and messages    // 2 = messages only
//$mail->Host       = "<HostName>"; // sets the SMTP server
//$mail->Port       = "25";                    // set the SMTP port for the GMAIL server
//$mail->SMTPAuth = false;
//$mail->SMTPAuth = true;
//$mail->SMTPSecure = "tls";
//$mail->Username = "<UserName>";
//$mail->Password = "<Password>";
//$mail->CharSet = 'UTF-8';
//$mail->SetFrom($from_add, "eGreetings"); 
//mail->AddReplyTo($from_add, "eGreetings");
$mail->Subject    = $subject;
$mail->AddAddress($to_add);



	if(!$mail->Send()) {
	 // error_log("Mailer Error: " . $mail->ErrorInfo);
					return 0;

	} else {
					return 1;
	}

}