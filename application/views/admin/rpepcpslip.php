
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
    <script>
        function change(id, newClass) {
            identity = document.getElementById(id);
            identity.className = newClass;

        }

        function printPage() {
            change("testdiv", "true");
            window.print();
        }
    </script>
</head>

<body style="font-size:16px; font-family: 'Times New Roman', Times, serif">

<?php
error_reporting(0);

$curYear = date('Y');
$curMonth = date('m');
$curDay = date('d');
$dateprint="$curDay/$curMonth/$curYear";
$curdate="$curYear-$curMonth-$curDay";
$filedby='';
$ia=$ia;
$year=$year;
$filing_no=$filing_no;
$iano=isset($_REQUEST['iano'])?$_REQUEST['iano']:$ia;

	$iano=rtrim($iano,",");
	$iaNo1=explode(',',$iano);
	$iaYear=isset($_REQUEST['year'])?$_REQUEST['year']:$year;
	$filingNo = '';
    for($i=0;$i<sizeof($iaNo1)-1;$i++){
		if($iaNo1[0]!=""){
		    $sqlia=$this->efiling_model->geIA('ia_detail',$iaNo1[$i],$iaYear);
		    foreach ($sqlia as $row){
    			 $filingNo=$row->filing_no;
    			 $filedby=$row->filed_by;
    		}
	    }
	}

    $filingNo = isset($_REQUEST['filing_no'])?$_REQUEST['filing_no']:$filing_no;
    $sql22= $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filingNo);
    foreach ($sql22 as $row){
 	 $petName=$row->pet_name;
	 $resName=$row->res_name;
 	 $case_no=$row->case_no;
	 $case_type=$row->case_type;
 	 $resName=$row->res_name;
     $order_date=$row->order_date;
	 $fDate=$row->dt_of_filing;
 	 $ref_filing_no=$row->ref_filing_no;
 	 $pet_adv=$row->pet_adv;
	 if($case_no!=""){
		$case_numaa = substr($case_no,4,7);
		$case_num1aa=ltrim($case_numaa,0);
		$case_year1aa = substr($case_no,11,4);
	}if($case_type!=""){
	    $stQ =$this->efiling_model->data_list_where('master_case_type','case_type_code',$case_type);
	    $case_type_short_name=$stQ[0]->short_name;
	}if($filedby==1){
			$filedbyName=$petName;
	}if($filedby==2){
			$filedbyName=$resName;
	}
 }

?>
<div id="testdiv" class="pr-hide">
<a target="_blank" href="<?php echo base_url(); ?>rpepcp_pay_slip/<?php echo $filingNo; ?>/<?php echo base64_encode($iano); ?>/<?php echo $year; ?>"> <font color="red" size="1"><img src="<?php echo base_url();?>asset/images/print.gif"  height="22" width="22" class="no-print" border='0'/></font></a>
</div>
<div style="position: relative;">
    <p style="text-align:center; font-family: Arial, Helvetica, sans-serif; font-size: 20px; margin: 0; line-height: 2.6;">
    <u><b>RECEIPT</b></u></p>
    <p style="text-align:center; font-size: 24px; margin: 0;"><u>APPELLATE TRIBUNAL FOR ELECTRICITY</u></p>
    <p style="text-align:center; margin: 0;">Core- 4, 7th Floor Scope Complex Lodhi Road New Delhi-110003</p>
    <div style="overflow: hidden;">
        <div style="float: left; width: 50%;">
            <p>
                <?php
                if ($case_no != "") {
                    $case_numaa = substr($case_no, 4, 7);
                    $case_num1aa = ltrim($case_numaa, 0);
                    $case_year1aa = substr($case_no, 11, 4);
                    echo $case_type_short_name . '/' . $case_num1aa . '/' . $case_year1aa;
                }else {
                    $filing_No = substr($filingNo, 5, 6);
                    $filing_No = ltrim($filing_No, 0);
                    $filingYear = substr($filingNo, 11, 4);
                    echo "DFR. No. :- DFR/$filing_No/$filingYear";
				}
				$sql22_ref=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$ref_filing_no);
				$ref_case_no =  $sql22_ref[0]->case_no;
				if ($ref_case_no != "") {
                    $Case_qqqq = 'Case ';
                    $case_numaa = substr($ref_case_no, 4, 7);
                    $dfr_case_no = ltrim($case_numaa, 0);
                    $dfr_case_no_year = substr($ref_case_no, 11, 4);
                   $ref_dfr_case =  'APL/' . $dfr_case_no . '/' . $dfr_case_no_year;
                } else {
                    $Case_qqqq = 'DFR ';
                    $filing_No_ref = substr($ref_filing_no, 5, 6);
                    $dfr_case_no = ltrim($filing_No_ref, 0);
                    $dfr_case_no_year = substr($ref_filing_no, 11, 4);
					$ref_dfr_case =  "DFR/$dfr_case_no/$dfr_case_no_year";
				}
                ?></p>
        </div>
        <div style="float: right; width: 50%; text-align: right;">
            <p>DATE OF FILING : <?php echo date('d/m/Y',strtotime($fDate)); ?></p>
        </div>
    </div>

    <p style="margin: 0;">CASE TYPE:- <?php echo $case_type_short_name.' in '. $ref_dfr_case;  ?></p>
    <p><b>Appellant Name :- <?php echo $petName; ?></b></p>
    <p><b>Respondent Name :- <?php echo $resName; ?></b></p>
    <?php
    $iano =base64_decode($iano);
    $ia_requestt = rtrim($iano,', ');
    ?>
      <table border="1" cellpadding="3" style="width:100%;border-collapse:collapse">
            <tbody>
            <tr>
				<td rowspan="100" style="text-align:center;width: 15%"><b>APTEL Order/Judgment Details</b></td>
				<td rowspan="100" style="text-align:center;width: 15%"><b>Appellate Tribunal for Electricity</b></td>
                <td><?php echo  $Case_qqqq; ?> No.</td>
                <td><?php echo  $Case_qqqq; ?> Year</td>
                <td>Date of Order</td>
            </tr>
            <tr>
                <td><?php  echo $dfr_case_no; ?></td>
                <td><?php echo $dfr_case_no_year; ?></td>
                <td><?php echo $order_date; ?></td>
				</tr>
            </tbody>
        </table>
    <table border="0" style="width:100%;">
<tr>
<td style="width:100%;" valign="top">
<?php 
$date_fing = date('Y-m-d');
$arr=array('filing_no' =>$filingNo,'dt_of_filing' =>$fDate);
$data_stnameaccount_detailse =$this->efiling_model->select_in('aptel_account_details',$arr);

$total_feee = 0;
if(!empty($data_stnameaccount_detailse)) { 
    foreach ($data_stnameaccount_detailse as $key => $value) {
       $total_feee =  $total_feee +  $value->amount;
if($total_feee=='' || $value->amount==''){  $total_feee =$total_feee+ $value->fee_amount;}
    }
 }
?>
<p><b>Total no of IA :-  <?php 
	if($ia_requestt!='') {
		$ias =  explode(',',$ia_requestt);
		echo count($ias);
	} else {
		echo 'NA';
	}
?></b></p>				
<p><b>Amount Received :- RS. <?php echo $total_feee; ?></b></p>
</td>
    <tr>
    	<td style="width:100%;" valign="top"><p>&nbsp</p>  </td>
        <td valign="top" style="text-align: center;"> <p>COUNTER&nbsp;ASSISTANT</p> 
<img src="<?php echo base_url(); ?>asset/images/stamp.jpg" style="width:100px;"></td>
    </tr>
    </table>
    <img src="<?php echo base_url(); ?>asset/images/bg.jpg" style="position:absolute; left:0; right:0; top:0; bottom:0; margin:auto; z-index: -1;">
</div>
</body>
</html>
