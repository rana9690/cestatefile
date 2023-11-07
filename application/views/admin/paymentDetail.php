
<fieldset><legend class="customlavelsub">Payment Details</legend>

 
 <?php 

$ia=$_REQUEST['natuer'];
 $anx=$_REQUEST['anx'];


$is_nature=$_REQUEST['iaNature'];
$patyAddId=$_REQUEST['patyAddId'];

$iaFee='';
$val=explode(',', $is_nature);

foreach($val as $vals){
    if($vals!=''){
        $sql =$this->efiling_model->data_list_where('moster_ia_nature','nature_code',$vals);
        $iaFee+=$iaFee+$sql[0]->fee;
    }
}

if($anx!=0){
    $anxfee=$anx*25;
}
$total=$iaFee +$anxfee;

$ia='';
if(in_array('3',$val,true)){
    $ia='3';
}

$reffrenceno= $this->session->userdata('reffrenceno');
$sql =$this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$reffrenceno);
if(empty($sql)){
    $userdata=$this->session->userdata('login_success');
    $user_id=$userdata[0]->id;
    $data=array(
        'salt'=>$_REQUEST['refsalt'],
        'anx'=>$_REQUEST['anx'],
        'totalNoAnnexure'=>$_REQUEST['totalNoAnnexure'],
        'iaNature'=>$_REQUEST['iaNature'],
        'partyType'=>$_REQUEST['partyType'],
        'party_ids'=>$_REQUEST['patyAddId'],
        'entry_date'=>date('Y-m-d'),
        'case_type'=>'IA',
        'filing_no'=>$_REQUEST['filing_no'],
        'user_id'=>$user_id,
    );
    $st=$this->efiling_model->insert_query('rpepcp_reffrence_table',$data);
}else{
    $user_id=$userdata[0]->id;
    $data=array(
        'salt'=>$_REQUEST['refsalt'],
        'anx'=>$_REQUEST['anx'],
        'totalNoAnnexure'=>$_REQUEST['totalNoAnnexure'],
        'iaNature'=>$_REQUEST['iaNature'],
        'partyType'=>$_REQUEST['partyType'],
        'party_ids'=>$_REQUEST['patyAddId'],
        'entry_date'=>date('Y-m-d'),
        'case_type'=>'IA',
        'filing_no'=>$_REQUEST['filing_no'],
        'user_id'=>$user_id,
    );
    
    $st=$this->efiling_model->update_data('rpepcp_reffrence_table',$data,'salt',$_REQUEST['refsalt']);
}




?>
<input type="hidden" name="ia_nature" id="ia_nature" value="<?php echo $is_nature; ?>">
<input type="hidden" name="patyAddId" id="patyAddId" value="<?php echo $patyAddId; ?>">
<input type="hidden" name="iaval" value="<?php echo $ia; ?>" id="iaval">

<div class="col-lg-12 ">
    <div class="row">
          <div class="col-lg-4 ">
          		<div><label for="phone"><span class="custom">IA Fee:</span></label></div>
            	<div id="phone"><font color="red" size="4"><b><?php echo htmlspecialchars($iaFee);?></b></font></div>
         		<input type="hidden" name="pay" id="pay" value="<?php echo htmlspecialchars($iaFee); ?>">
         </div>
         <?php if($anx!=0){ ?>
          <div class="col-lg-4 ">
          		<div><label for="phone"><span class="custom">Annexure Fee:</span></label></div>
            	<div id="phone"><font color="red" size="4"><b><?php echo htmlspecialchars($anxfee);?></b></font></div>
           </div>
        <?php } ?>
        <div class="col-lg-4 ">
        		<div><label for="phone"><span class="custom">Total Fee:</span></label></div>
            	<div id="phone"><font color="red" size="4"><b><?php echo htmlspecialchars($total);?></b></font></div>
        </div>
    </div>  
</div>
 <div class="col-lg-12 ">
  	<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Payment Mode</span></label></div>
    <div>
        <label for="name"><span class="custom">
        Online Payment<input type = "radio"name = "bd" id = "po" value = "3" onclick="paymentMod_ia_details(3);"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </span>
        </label>
    </div>
  </div>



<div class="row">
    <div class="col-lg-4 ">
    		<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Total Amount </span></label></div>
    		<div><input type="text" name="totalamount" id="totalamount" class="form-control" value="<?php echo htmlspecialchars($total);?>" onkeypress="return onKeyValidate(event,alpha);" readonly></div>
    </div>		
    <div class="col-lg-4 ">		
    		<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Remaining Amount</span></label></div>
    		<div><input type="text" name="remainamount" id="remainamount"   class="form-control datepicker"  value="<?php echo htmlspecialchars($total);?>" readonly></div>
    </div>
    <div class="col-lg-4 ">		
    		<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Paid Amount</span></label></div>
    		<div><input type="text" name="collectamount" id="collectamount"   class="form-control datepicker"  value="<?php echo '0';?>" readonly></div>
    </div>
</div>

<div class="col-lg-12 "  id="payMode_ia_details"  style="display: none"></div>
<div class="col-lg-12 "  id="addmoreadd"  style="display: none"></div>
<div class="col-lg-12 "  id="addmoreaddpay"  style="display: none"></div>
<div class="col-lg-12 "  id="add_amount_list" ></div>



 </fieldset>