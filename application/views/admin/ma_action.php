<?php
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$curYear = date('Y');
$curMonth = date('m');
$curDay = date('d');
$curdate = "$curYear-$curMonth-$curDay";
$filingNo = $_REQUEST['filingNo'];
$ptype = $_REQUEST['type'];
$addparty = $_REQUEST['addparty'];
//$addparty = implode(',', $addparty);
if($addparty==''){
    $addparty='TP';
}
$totalA = $_REQUEST['totalA'];
$dbankname = $_REQUEST['dbankname'];
$amountRs = $_REQUEST['amountRs'];
$ddno = $_REQUEST['ddno'];
$matter = $_REQUEST['matter'];
$dddate = $_REQUEST['dddate'];
$d_date = explode('-', $dddate);
$dd_date = $d_date[2] . '-' . $d_date[1] . '-' . $d_date[0];
$bd = $_REQUEST['bd'];
$pid = $_REQUEST['pid'];
$paper2 = $_REQUEST['paper2'];
$iaCode = $_REQUEST['iaCode'];
$total_feeeee = $_REQUEST['total_feeeee'];
$status='df';
//if third party select than
if($ptype==3){
       $data=array(
            'filing_no'=>$filingNo,
            'select_org_app'=>$_REQUEST['select_org_app'],
            'petname'=>$_REQUEST['petName'],
            'dstate'=>$_REQUEST['dstate'],
            'petmobile'=>$_REQUEST['petmobile'],
            'degingnation'=>$_REQUEST['degingnation'],
            'ddistrict'=>$_REQUEST['ddistrict'],
            'petphone'=>$_REQUEST['petPhone'],
            'petaddress'=>$_REQUEST['petAddress'],
            'pincode'=> $_REQUEST['pincode'],
            'petemail'=>$_REQUEST['petEmail'],
            'petfax'=>$_REQUEST['petFax'],
            'created_date'=>$curdate,
            'status'=>$status
         );
   $sqlpet2 = $this->efiling_model->insert_query('certified_copy_thirdparty',$data);
}




if($_REQUEST['collection_ammount'] != 'undefined') { 
    $doc_aptel_temp_payment =$this->efiling_model->data_list_where('aptel_temp_payment','salt',$filingNo);
    if(!empty($doc_aptel_temp_payment)) {
        foreach ($doc_aptel_temp_payment as $key => $value) {
            $amountRs = $value->other_fee;
            $filingNo = $filingNo;
            $curdate = date('Y-m-d');
            $total_feeeee = $value->total_fee;
            $bd = $value->payment_mode;
            $dbankname = $value->branch_name;
            $ddno = $value->dd_no;
            $dd_date = $value->dd_date;
            $data=array(
                'other_fee'=>$amountRs,
                'filing_no'=>$filingNo,
                'dt_of_filing'=>$curdate,
                'fee_amount'=>$total_feeeee,
                'payment_mode'=>$bd,
                'branch_name'=>$dbankname,
                'dd_no'=>$ddno,
                'dd_date'=>$dd_date,
            );
            $sqlpet2 = $this->efiling_model->insert_query('aptel_account_details',$data);
        }
        $this->efiling_model->delete_event('aptel_temp_payment','salt',$filingNo);
    }
}

if ($paper2 == 'ma') {
    $year_ins = $this->efiling_model->data_list_where('ia_initialization','year',$curYear);
    $ma_filing_no = $year_ins[0]->ma_filing;
    if ($ma_filing_no == '0') {
        $maFilingNo = 1;
    }
    if ($ma_filing_no != '0') {
        $maFilingNo = (int)$ma_filing_no + 1;
    }
}

if ($paper2 == 'ma' || $paper2 == 'IA') {
    $data=array(
        'other_fee'=>$amountRs,
        'filing_no'=>$filingNo,
        'dt_of_filing'=>$curdate,
        'fee_amount'=>$total_feeeee,
        'payment_mode'=>$bd,
        'branch_name'=>$dbankname,
        'dd_no'=>$ddno,
        'dd_date'=>$dd_date,
        'other_document'=>$pid,
        'ma_filing_no'=> $maFilingNo,
        'total_no_annexure'=>$totalA
        
    );
    $sqlpet2 = $this->efiling_model->insert_query('aptel_account_details',$data);
}

if ($paper2 == 'ma') {
    $name = 'MF';
    $data=array(
        'filing_no'=>$filingNo,
        'main_party'=>$ptype,
        'additional_party'=>$addparty,
        'doc'=>$pid,
        'total_no_annexure'=>$totalA,
        'ma_filing_no'=>$maFilingNo,
        'dt_of_filing'=>$curdate, 
    );
    $sqlpet2 = $this->efiling_model->insert_query('ma_detail',$data);
    
    $where=array('year'=>$curYear);
    $data=array('ma_filing'=>$maFilingNo);
    $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data);
}

if ($paper2 == 'va') {
    $name = 'Vakalatnama';
    $year_ins = $this->efiling_model->data_list_where('ia_initialization','year',$curYear);
    $va_filing_no = $year_ins[0]->ma_filing;
    if ($va_filing_no == '0') {
        $vaFilingNo = 1;
    }
    if ($va_filing_no != '0') {
        $vaFilingNo = (int)$va_filing_no + 1;
    }
    $cadd = htmlspecialchars($_REQUEST['cadd']);
    $cpin = htmlspecialchars($_REQUEST['cpin']);
    $cmob = htmlspecialchars($_REQUEST['cmob']);
    $cemail = htmlspecialchars($_REQUEST['cemail']);
    $cfax = htmlspecialchars($_REQUEST['cfax']);
    $counselpho = htmlspecialchars($_REQUEST['counselpho']);
    $state = htmlspecialchars($_REQUEST['st']);
    $dist = htmlspecialchars($_REQUEST['dist']);
    $councilCode = htmlspecialchars($_REQUEST['councilCode']);
    $party_flag = 'P';
    if($ptype =='2') {
        $party_flag = 'R';
    }
    $sql_advocate = array(
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
        'party_code'=>$addparty, 
        'state'=>$state, 
        'district'=>$dist
    ); 
    $sqlpet2 = $this->efiling_model->insert_query('additional_advocate',$sql_advocate);
    
        $sql = array(
            'filing_no'=>$filingNo,
            'party_flag'=>$ptype,
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
            'vakalatnama_no'=>$vaFilingNo,
            'entry_date'=>$curdate,
          );
        $sqlpet2 = $this->efiling_model->insert_query('vakalatnama_detail',$sql);
            
        $sql = array(
            'other_fee'=>$amountRs,
            'filing_no'=>$filingNo,
            'dt_of_filing'=>$curdate,
            'fee_amount'=>$total_feeeee,
            'payment_mode'=>$bd,
            'branch_name'=>$dbankname,
            'dd_no'=>$ddno,
            'dd_date'=>$dd_date,
            'other_document'=>$pid,
            'vakalatnama_no'=>$vaFilingNo,
        );
        $sqlpet2 = $this->efiling_model->insert_query('aptel_account_details',$sql);

        $where=array('year'=>$curYear);
        $data=array('ma_filing'=>$vaFilingNo);
        $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data);
}


if ($paper2 == 'oth') {
    $name = 'Other Document';
    $year_ins = $this->efiling_model->data_list_where('ia_initialization','year',$curYear);
    $doc_filing_no = $year_ins[0]->ma_filing;
    if ($doc_filing_no == '0') {
        $docFilingNo = 1;
    }
    if ($doc_filing_no != '0') {
        $docFilingNo = (int)$doc_filing_no + 1;
    }

    $sql = array(
        'filing_no'=>$filingNo,
        'doc_date'=>$curdate,
        'doc_filing_no'=>$docFilingNo,
        'main_party'=>$ptype,
        'add_party_code'=>$addparty,
        'doc_id'=>$pid, 
    );
    $sqlpet2 = $this->efiling_model->insert_query('document_filing',$sql);
    
    $where=array('year'=>$curYear);
    $data=array('ma_filing'=>$docFilingNo);
    $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data);
}
?>
<fieldset>
    <legend style="color: red;font-size:15px;"><?php echo $name; ?> Number :</legend>
    <div class="col-md-12">
    		<font color="#0000FF" size="5">
        	<?php if ($paper2 == 'ma') {   ?>
                <td colspan="1">
                    <font size="2">
                    	 <a href="javascript:void(0);" style="color: #3F33FF"  onclick="return popitup('<?php echo $matter; ?>','<?php echo $ptype; ?>','<?php echo $addparty; ?>','<?php echo $maFilingNo; ?>','<?php echo "ma"; ?>','<?php echo $filingNo; ?>','<?php echo $amountRs; ?>','<?php echo $pid; ?>','<?php echo $curYear; ?>')"><b>
                   		 <font size="4"><?php echo "Print"; ?></font></b></a>
                    </font>
                </td>
                <br>
                <?php echo $name; ?> is successfully registered:
                <?php
                echo "<br>";
                echo 'MF' . '/' . $maFilingNo . '/' . $curYear;
                echo "<br>";
            } if ($paper2 == 'IA') { ?>
       		 <td colspan="1">
           		 <font size="2">
           		 	<a href="javascript:void(0);" style="color: #3F33FF"   onclick="return popitup('<?php echo $matter; ?>','<?php echo $ptype; ?>','<?php echo $addparty; ?>','<?php echo $iaFilingNo; ?>','<?php echo "ia"; ?>','<?php echo $filingNo; ?>','<?php echo $amountRs; ?>','<?php echo $iaCode; ?>','<?php echo $curYear; ?>')"><b>
           		 	<font size="4"><?php echo "Print"; ?></font></b>
           		 	</a>
           		 </font>
       		 </td>
            <br>
            <?php
            echo 'IA' . '/' . $iaFilingNo . '/' . $curYear;
             } if ($paper2 == 'va') { ?>
            	<td colspan="1">
                	<font size="2">
                		<a href="javascript:void(0);"  style="color: #3F33FF" onclick="return popitup('<?php echo $matter; ?>','<?php echo $ptype; ?>','<?php echo $addparty; ?>','<?php echo $vaFilingNo; ?>','<?php echo "va"; ?>','<?php echo $filingNo; ?>','<?php echo $amountRs; ?>','<?php echo $pid; ?>','<?php echo $curYear; ?>')"><b>
                		<font  size="4"><?php echo "Print"; ?></font></b>
                		</a>
                	</font>
            	</td>
                <?php
                echo 'VA' . '/' . $vaFilingNo . '/' . $curYear;
            } if ($paper2 == 'oth') { ?>
                <td colspan="1"><font size="2">
                    <a href="javascript:void(0);"   style="color: #3F33FF"  onclick="return popitup('<?php echo $matter; ?>','<?php echo $ptype; ?>','<?php echo $addparty; ?>','<?php echo $docFilingNo; ?>','<?php echo "doc"; ?>','<?php echo $filingNo; ?>','<?php echo $pid; ?>','<?php echo $curYear; ?>')"><b>
                    <font  size="4"><?php echo "Print"; ?></font></b></a>
                    </font>
                </td>
                 <?php echo 'DOC' . '/' . $docFilingNo . '/' . $curYear;  } ?>
    		</font>
    </div>
</fieldset>