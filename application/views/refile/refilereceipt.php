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
$curYear = date('Y');
$curMonth = date('m');
$curDay = date('d');
$dateprint="$curDay/$curMonth/$curYear";
$curdate="$curYear-$curMonth-$curDay";
$filingNo = $filingno;
$filedby='';
	$case_no='';
	$sql22="select * from aptel_case_detail where filing_no='$filingNo'";
	$query=$this->db->query($sql22);
	$data = $query->result();
	foreach ($data as $row){
     	$petName=$row->pet_name;
    	$resName=$row->res_name;
     	$case_no=$row->case_no;
    	$case_type=$row->case_type;
     	$resName=$row->res_name;
     	$fDate=$row->dt_of_filing;
     	$pet_adv=$row->pet_adv;
    	if($case_no!=""){
    		$case_numaa = substr($case_no,4,7);
    		$case_num1aa=ltrim($case_numaa,0);
    		$case_year1aa = substr($case_no,11,4);
    	}
    	if($case_type!=""){
    			$stQ = "select short_name from master_case_type where case_type_code ='$case_type'";
    			$query=$this->db->query($stQ);
	            $data = $query->result();
	            $case_type_short_name=$data[0]->short_name;
    	}if($filedby==1){
    			$filedbyName=$petName;
    	}if($filedby==2){
    			$filedbyName=$resName;
    	}
 }
?>
<div style="position: relative;">
    <p style="text-align:center; font-family: Arial, Helvetica, sans-serif; font-size: 20px; margin: 0; line-height: 2.6;">
    <u><b>RECEIPT</b></u></p>
    <p style="text-align:center; font-size: 24px; margin: 0;"><u><?=APP_SITENAME?></u></p>
    <p style="text-align:center; margin: 0; display: none;">Core- 4, 7th Floor Scope Complex Lodhi Road New Delhi-110003</p>
    <div style="overflow: hidden;">
        <div style="float: left; width: 50%;">
            <p>
                <?php
                if ($case_no != "") {
                    $case_numaa = substr($case_no, 4, 7);
                    $case_num1aa = ltrim($case_numaa, 0);
                    $case_year1aa = substr($case_no, 11, 4);
                    echo $case_type_short_name . '/' . $case_num1aa . '/' . $case_year1aa;
                } else {
                    $filing_No = substr($filingNo, 6, 6);
                    $filing_No = ltrim($filing_No, 0);
                    $filingYear = substr($filingNo, -4);
                    echo "DIARY. No. :- $filing_No/$filingYear";
                }
                ?>
            </p>
            <p style="margin: 0;">CASE TYPE:- <?php echo $case_type_short_name; ?></p>
            <p><b>Appellant Name :- <?php echo $petName.$this->efiling_model->fn_addition_party($filingNo,'1'); ?></b></p>
            <p><b>Respondent Name :- <?php echo $resName.$this->efiling_model->fn_addition_party($filingNo,'2');; ?></b></p>
        </div>
        <div style="float: right; width: 50%; text-align: right;">
            <p>DATE OF FILING : <?php echo $dateprint; ?></p>
           
        </div>
    </div>
   
    <table border="1" cellpadding="3" style="width:100%; border-collapse: collapse;">
       <tr>
    	   <th>Sr. No</th>
    	   <th>Date</th>
    	   <th>Reference  No.</th>
    	   <th>Payment Status</th>
    	   <th>Amount</th>
	   </tr>
	   <?php 
	    $sqlia="select * from refiledetail where filing_no='$filingNo'";
	    $query=$this->db->query($sqlia);
	    $data = $query->result();
	    $totalfee=0;
	    foreach ($data as $row){
	        $totalfee=$row->totalfee;
		    $date=$row->entry_date;
		    $refilerefference=$row->refilerefference;
		    $paymentstatus=$row->paymentstatus;
		} ?>
		 <tr>
    		 <td><center><?php echo 1; ?></center></td>
    		 <td><center><?php echo date('d/m/Y',strtotime($date)); ?></center></td>
    		 <td><center><?php echo $refilerefference;?></center></td>
    		 <td><center><?php echo $paymentstatus ;?></center></td>
    		 <td><center><?php echo $totalfee ;?></center></td>
		 </tr>
    </table>
    <table border="0" style="width:100%;">
        <tr>
    	   <td style="width:100%;" valign="top">
                <p><b>Amount Received :- RS. <?php echo $totalfee; ?></b></p>
    	   </td>
    </table>
    <img src="<?php echo base_url(); ?>asset/images/bg.jpg" style="position:absolute; left:0; right:0; top:0; bottom:0; margin:auto; z-index: -1;">
</div>
</body>
</html>
