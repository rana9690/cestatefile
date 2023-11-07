<?php 
	   $filingNo='';
	    $end_nopage='';
	    $total_page='';
	    $orderdate='';
	    $no_page='';
	    $no_set='';
	    $totalamount='';
	    $last_inserted_id='';
	    $partyType=$_REQUEST['partyType'];
		$patyAddId=isset($_REQUEST['patyAddId'])?$_REQUEST['patyAddId']:'0';
	    $patyAddId=implode(',', $patyAddId);
	    $filingNo=$_REQUEST['filingNo'];  
	    $meta_type=$_REQUEST['matterId'];
	    $payment_mode=$_REQUEST['bd'];
	    $orderdate=$_REQUEST['dtoforder'];
	    $no_page=$_REQUEST['nopage'];
	    $no_set=$_REQUEST['noset'];
	    $totalamount=$_REQUEST['total_amount'];
	    $cnt=$_REQUEST['cnt'];
	    $total=$_REQUEST['total'];
	    //save_certify_copy
	    $id = mt_rand(100000,999999); 
	    $date=date('Y-m-d');
	    $year=date('Y');
	    $userdata=$this->session->userdata('login_success');
	    $user=$user_id;
	    $ip=$_SERVER['HTTP_HOST'];
	    $certify_number='';
	    //matter second
	    $nopage=$_REQUEST['nopage'];
	    $end_nopage=$_REQUEST['end_nopage'];
	    $total_page=$_REQUEST['total_page'];
	    $noset=$_REQUEST['noset'];
	    $payAmount=$_REQUEST['payAmount'];
	    $case_initialization = $this->efiling_model->data_list_where('ia_initialization','year',$year);
	    $certified_no =  $case_initialization[0]->certified_copy; 
	    $certified_no  = $certified_no+1;    
	    // update initilization
	    if($certified_no!=''){
	        $where=array('year'=>$year );
	        $data=array('certified_copy'=>$certified_no);
	        $resupeate = $this->efiling_model->update_data_where('ia_initialization',$where,$data); 
	    }
	    $data=array(
	        'filling_no'=>$filingNo,
	        'party_type'=>$partyType,
	        'party_ids'=>$patyAddId,
	        'meta_type'=>$meta_type,
	        'payment_mode'=>$payment_mode,
	        'created_by'=>$user,
	        'created_on'=>$date,
	        'ip'=>$ip,
	        'year'=>$year,
	        'certify_number'=>$certified_no,
	        
	    );
	    $sqlpet2 = $this->efiling_model->insert_query('certified_copy',$data);
	    $last_inserted_id =$this->db->insert_id();
     	 //Matters data insert 
     	 if($meta_type==1){
             $orderdate=$orderdate;
             $no_page=$no_page;
             $no_set=$no_set;
             $totalamount=$totalamount;
     	 }
     	//if third party select than
 	 if($partyType==3){ 
 	     $data=array(
 	         'certify_id'=>$last_inserted_id,
 	         'select_org_app'=>$_REQUEST['select_org_app'],
 	         'petname'=>$_REQUEST['petName'],
 	         'dstate'=>$_REQUEST['dstate'],
 	         'petmobile'=>$_REQUEST['petmobile'],
 	         'degingnation'=>$_REQUEST['degingnation'],
 	         'ddistrict'=>$_REQUEST['ddistrict'],
 	         'petphone'=>$_REQUEST['petPhone'],
 	         'petaddress'=>$_REQUEST['petAddress'],
 	         'pincode'=>$_REQUEST['pincode'],
 	         'petemail'=>$_REQUEST['petEmail'],
 	         'petfax'=>$_REQUEST['petFax'],
 	         'councilcode'=>$_REQUEST['councilCode'],
 	         'ddistrictname'=>$_REQUEST['ddistrictname'],
 	         'counselphone'=>$_REQUEST['counselPhone'],
 	         'counselAdd'=>$_REQUEST['counselAdd'],
 	         'counselpin'=>$_REQUEST['counselPin'],
 	         'counselemail'=>$_REQUEST['counselEmail'],
 	         'dstatename'=>$_REQUEST['dstatename'],
 	         'counselmobile'=>$_REQUEST['counselMobile'],
 	         'counselfax'=>$_REQUEST['counselFax'],
 	         'created_date'=> $date,
 	     );
 	     $sqlpet2 = $this->efiling_model->insert_query('certified_copy_thirdparty',$data);
 	 }

     if($meta_type==1){
        for($i=0;$i<$cnt;$i++){
            $data=array(
                'filling_no'=>$filingNo,
                'meta_type'=>$meta_type,
                'order_date'=>$orderdate[$i],
                'no_page'=>$no_page[$i],
                'no_set'=>$no_set[$i],
                'total'=>$totalamount[$i],
                'created_by'=>$user,
                'created_on'=>$date,
                'ip'=>$ip,
                'certify_copy_id'=>$last_inserted_id,
            );
            $sqlpet2 = $this->efiling_model->insert_query('certified_copy_matters',$data);
            $last_inserted_id2 ='';
        } 
     }
  

     //matter second
     if($meta_type==2){
         $nopage= $_REQUEST['nopage2'];
         $end_nopage= $_REQUEST['end_nopage2'];
         $total_page= $_REQUEST['total_page2'];
         $noset= $_REQUEST['noset2'];
         $no_page=$nopage;
         $end_nopage=$end_nopage;
         $total_page=$total_page;
         $no_set=$noset;
         for($i=0;$i<$cnt;$i++){
             $data=array(
                 'filling_no'=>$filingNo,
                 'meta_type'=>$meta_type,
                 'no_page'=>$no_page[$i],
                 'no_set'=>$no_set[$i],
                 'created_by'=>$user,
                 'created_on'=>$date,
                 'ip'=>$ip,
                 'certify_copy_id'=>$last_inserted_id,
                 'end_nopage'=>$end_nopage[$i],
                 'total_no_page'=>$total_page[$i],
             );
             $sqlpet2 = $this->efiling_model->insert_query('certified_copy_matters',$data);
             $last_inserted_id2 ='';
         }
     }
     //Online Payment
     if($_REQUEST['bd']==3){
         $bd=$_REQUEST['bd'];
         $dbankname=$_REQUEST['ntrp'];
         $dddate=$_REQUEST['ntrpdate'];
         $ddno=$_REQUEST['ntrpno'];
         $amountRs=$_REQUEST['ntrpamount'];
     }
     // Insert data in temprary table 
     if($dbankname!='' && $date!=''){
         $date=date('Y-m-d');
         $data=array(
             'salt'=>$filingNo,
             'payment_mode'=>$bd,
             'branch_name'=>$dbankname,
             'dd_no'=>$ddno,
             'dd_date'=>$ddate,
             'amount'=>$amountRs,
             'createdate'=>$date,
         );
         $sqlpet2 = $this->efiling_model->insert_query('aptel_temp_payment',$data);
     }

    if($payment_mode!=''){
        $getpayment_data=$this->db->query("SELECT salt,total_fee,payment_mode, branch_name,dd_no,dd_date, amount,ia_fee, other_fee FROM aptel_temp_payment WHERE salt ='$filingNo'");
        $sql_party11 = $getpayment_data->result();
        foreach($sql_party11 as $row_payment){
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
        $delete_data=$this->efiling_model->delete_event('aptel_temp_payment','salt',$filingNo);
    }

$val='<fieldset id ="" style="display: block"><legend class="customlavelsub">Payment Receipt.</legend>
        <div class="col-sm-4 div-padd">
    		<label for="name"><span class="custom"></span>
    		<a target="_blank" href="'.base_url().'certifyreceipt/'.base64_encode($certified_no).'/'.base64_encode($filingNo).'">Receipt</a>
        </div>
</fieldset>';
echo json_encode(['data'=>'success','value'=>$val,'error'=>'1']); die;
?>

