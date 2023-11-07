<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notice extends CI_Controller
{

    public function __construct()
    {
        //ini_set('display_errors',1);
       //error_reporting(E_ALL);
        parent::__construct();
		
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
    function getSingleSchemas($params)
    {

        return $this->db->select("*")->from('initilization')->where($params)->get()->row_array();

    }
    public function defectNotices($schemas,array $params)
    {


        $this->db->select("c.pet_name,c.res_name,c.dt_of_filing,c.pet_email,c.res_email,c.pet_address1,c.res_address1");
        $this->db->select("ci.impugn_no,ci.impugn_date");
        $this->db->select("petadv.adv_name as pet_adv_name,petadv.address as pet_adv_add,petadv.email as pet_adv_email");
        $this->db->select("resadv.adv_name as res_adv_name,resadv.address as res_adv_add,resadv.email as res_adv_email");
        //$builder->select("(select to_char(DATE (c.dt_of_filing)::date, 'DD/MM/YYYY')as dt_of_filing");
        $this->db->from($schemas.".case_detail as c");
        $this->db->join($schemas.'.case_detail_impugned as ci','ci.filing_no=c.filing_no');
        $this->db->join($schemas.'.advocate_master as petadv','petadv.adv_code=c.pet_adv','Left');
        $this->db->join($schemas.'.advocate_master as resadv','resadv.adv_code=c.res_adv','Left');
        $this->db->where($params);
        $result=$this->db->get();
        if($result->num_rows()>0):
            return $result->row_array();
        endif;
    }
    public function defectNotice($filing_no,$orderType=null)
    {

        $schemaId=ltrim(substr($filing_no,0,2),'0');
        $schemaData=$this->getSingleSchemas(['state_code'=>$schemaId]);
		
        $siteAddress=$schemaData['address'];
        $schemas=$schemaData['schema_name'];
        switch($orderType):
            case 'reminder':
                break;
            default:
                $params=['c.filing_no'=>$filing_no];
                $data=$this->defectNotices($schemas,$params);


                endswitch;
        if(!empty($data)):
            $DOH_appl='';
            $res_full_name='';
            $res_full_address ='';
            //dd($data);
            extract($data);
        $diary=ltrim(substr($filing_no,6,6),'0').'/'.substr($filing_no,-4);
        $today= date("d/m/y");
            $WEBSITE_URL_DISPLAY=WEBSITE_URL_DISPLAY;
            $APP_SITENAME=APP_SITENAME;


            // Objections code and name starts
            $cou = 1;
            $st = "select o.objection_code,m.objection_type from $schemas.case_detail c,$schemas.objection_details o,objection_master m where m.objection_code = o.objection_code and c.filing_no = o.filing_no and c.filing_no = '$filing_no' ";
            $sth= $this->db->query($st);
            $objectionString="<table width='100%'>";
            foreach($sth->result_array() as $row)

            {
                $o_code	= $row['objection_code'];
                $o_type = $row['objection_type'];

                $objectionString.="<tr><td width='2%' valign='top'><font size='2'><b>$cou</b></font></td><td width='98%'><font size='2'>$o_type</font></td></tr>";


                $cou = $cou + 1;
            }
            $objectionString.="<tr><td colspan='2'><br></td></tr></table>";
            echo $text = <<<TEXT
                <font size='2'><table width='100%'><tr><td width='50%'>
        <b><font size='2'></b><br><b>Website : $WEBSITE_URL_DISPLAY</b></font></td>
        <td align='right' width='50%'>
       <b><font size='2'>REGISTERED / AD</b><br><b></b></font></td></tr>
        </table>

        <table width='100%'>
        <tr><td align='center'>
        <b><font size='2'> $APP_SITENAME </b><br><b> $siteAddress </b><br><b><u>DIARY NUMBER - $diary</u></b></font></td></tr>
        </table>

        <table width='100%'>
         <tr><td align='right'>

       <font size='2'>Dated: <b> $today </b></font></td></tr>
        </table>

        In the Matter Of:

        <table width='100%'>
        <tr><td width = '35%'></td><td align='center' width='35%'><b><font size='2'>$pet_name<br>$pet_email<br></font></b></td>
			  <td align='right' width='30%'><font size='2'>(Appellant)</font></td></tr>
        </table>

        <table width='100%'>
        <tr><td width = '35%'></td><td align='center' width='35%'><font size='2'><b>VS</b></font></td><td width='30%'></td></tr>
        </table>

        <table width='100%'>
        <tr><td width = '35%'></td><td align='center' width='35%'><b><font size='2'>$res_name<br> $res_email <br></font></b></td><td align='right' width='30%'><font size='2'>(Respondent)</font></td></tr>
        </table>

        <br>

        Appeal against &nbsp;&nbsp;&nbsp;OIO/OIA : &nbsp;&nbsp; <b> $impugn_no </b>	&nbsp;&nbsp;&nbsp;  Dated: <b>$impugn_date</b><br>

        To,

        <br><br><table width='100%'>
         <tr><td width = '35%'></td><td width='35%'><font size='4'><b>$pet_name </b><br>$pet_address1 </font></td><td width='30%'></td></tr>
        </table>

        <br><br>Whereas you have filed an Appeal/Application/Stay/Misc/ROA/ROM/COD/Cross Objection in the matter noted above in this Tribunal on <b>$dt_of_filing</b><br><br>
        <b><u>And Whereas on scrutiny following defect(s) have/has been noted :</b></u><br><br>

        $objectionString



        The matter has been listed before the Honble Registrar, CESTAT on <b>$DOH_appl</b> at 11:00 A.M. You are directed to either to remove the defects before the mentioned date and time, or to appear either in person or through authorized representative of the said date.<br>
        <br><br>

        <table width='100%'>
        <tr><td><font size='2'>Copy To:</font></td>
			  <td align='right'><b><font size='2'><br>Assistant Registrar</b><br>Central Registry</font></td></tr>
        </table>

    1. <u>Respondent</u><br>
        <table width='100%'>
        <tr><td width = '35%'></td><td width = '35%'><font size='4'><b>$res_name $res_full_name</b><br>$res_address1 $res_full_address</font></td><td width = '30%'></td></tr>
        </table><br>

    2. <u>Advocate(s) / Consultant(s)</u>: <br>
        <table width='100%'>
        <tr><td width = '35%'></td><td width = '35%'><font size='4'><b>$pet_adv_name</b><br>$pet_adv_add  <br>$pet_adv_email</font></td>
			  <td width = '30%'></td></tr>
        </table><br><br>

        <table width='100%'>
        <tr><td width = '35%'></td><td width = '35%'><font size='4'><b>$res_adv_name</b><br>$res_adv_add  <br>$res_adv_email</font></td>
			  <td width = '30%'></td></tr>
        </table>
        <table width='100%'>
        4.<u>O/o Authorised Representative;CESTAT,Delhi(CDR) <br>
        </table>
        </font>

TEXT;

            endif;
    }




}
