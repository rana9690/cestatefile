<?php
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepsia");
$salt=$this->session->userdata('iasalt');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$token= $this->efiling_model->getToken();
if($salt==''){
    $salt='';
}
$tab_no='';
$type='';
$totalia='';
$anx='';
$filing_no='';
$ianature='';
$iano=0;
if($salt!=''){
    $basicia= $this->efiling_model->data_list_where('temp_iadetail','salt',$salt);
    $anx=isset($basicia[0]->totalanx)?$basicia[0]->totalanx:'';
    $type=isset($basicia[0]->type)?$basicia[0]->type:'';
    $filing_no=isset($basicia[0]->filing_no)?$basicia[0]->filing_no:'';
    $tab_no=isset($basicia[0]->tab_no)?$basicia[0]->tab_no:'';
    $totalia=isset($basicia[0]->totalia)?$basicia[0]->totalia:'';
    $ianature=isset($basicia[0]->ianature)?$basicia[0]->ianature:'';
    $iano=isset($basicia[0]->totalia)?$basicia[0]->totalia:'';
}
?>

    <form action="<?php echo base_url(); ?>ia_finalreceipt" target="_blank" class="wizard-form steps-basic wizard clearfix" id="finalsubmit" autocomplete="off" method="post" accept-charset="utf-8">

<?= form_fieldset().'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>
<input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
<input type="hidden" name="filing_no" id="filing_no" value="<?php echo $filing_no; ?>">
<input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
<input type="hidden" name="tabno" id="tabno" value="6">
<input type="hidden" name="type" id="type" value="ia">
<input type="hidden" name="submittype" id="submittype" value="finalsave">
<div class="col-md-12" >
  		<FIELDSET> 
        	<legend><b>IA Fee Detail</b></legend>
        	<table datatable="ng" id="examples"  class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Fee Detail</th>
					<th>Amount</th>
                </tr>
                </thead>
               <tbody>
                    <?php
                    $totalis=0;
                    if($salt!=''){
                        $basicia= $this->efiling_model->data_list_where('temp_iadetail','salt',$salt);
                        $ianature=isset($basicia[0]->ianature)?$basicia[0]->ianature:'';
                    }
                    $ianocc=explode(',', $ianature);
                    $i=1;
                    foreach($ianocc as $row) {
                        if($row!=''){
                        $aDetail= $this->efiling_model->data_list_where('moster_ia_nature','nature_code',$row);
                        $totalis+=$aDetail[0]->fee;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($aDetail[0]->nature_name);?></td>
                        <td><?php echo htmlspecialchars($aDetail[0]->fee);?></td>
                    </tr>
                <?php 
                $total=$totalis+$anx*25;
                $i++;} }
                
                $collectoive=0;
                $feesd=$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);
                foreach($feesd as $row){
                    $collectoive+=$row->amount;
                }
                
                
                
                ?>
                
                   <tr>
                        <td><?php echo $i; ?></td>
                        <td>Annexture</td>
                        <td><?php echo $anx*25; ?></td>
                    </tr>
                    
                      <tr>
                        <td></td>
                        <td></td>
                        <td><?php echo $total; ?></td>
                    </tr>
                   
                </tbody>
            </table>
        </FIELDSET>

       		  <input type="hidden" name="totalamount" id="totalamount" value="<?php echo $total; ?>"   class="form-control" readonly>
       		  <input type="hidden" name="remainamount" id="remainamount" value="<?php echo $total; ?>"   class="form-control" readonly>
              <input type="hidden" name="collectamount" id="collectamount" value="<?php echo $collectoive; ?>"   class="form-control" readonly>
        
   
<fieldset>  
<div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px; margin: -20px auto 12px; max-width: 100%;">
    <div class="col-md-4 md-offset-2">Select Type</div>
    <div class="col-md-6 md-offset-2">
        <label for="org" class="form-check-label font-weight-semibold">
            <input type="radio" name="bd" id="bd" value="1" onclick="online(1);"/>Online Payment&nbsp;&nbsp;
        </label>
        <label for="indv" class="form-check-label font-weight-semibold">
            <input type="radio" name="bd" id="on" value="3" onclick="paymentMode(3);" checked="checked">Offline&nbsp;&nbsp;
        </label>
    </div>
</div>   
<div id="payMode_review_petion"></div>  
<div id="payModepay">
<div id="payModepaydddddddd">
<?php 
$html='';

$total=0;
 $html.='<p> <font color="#510812" size="3">Transaction Detail</font></p>
            <table  class="table" style="border: 1px solid black;">
                   <tr>
                      <th>Name</th>
                      <th>Challan/Ref. No</th>
                      <th>Date of Transction</th>
                      <th>Amount in Rs</th>
                     <th>Delete</th>
                  </tr> ';
	        
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
                        <td><input type="button" value="Delete"  class="btn1" onclick="deletePayrpepcp('.$id.')"/></td>
                     </tr>';
	        }
	        $remain=0;

	        $remain= $total-$sum;
	        $html.='</table>
            		<div class="Cell" style="margin-left: 980px;">
                        <p class="custom"><font color="#510812" size="3">Total Rs</font>-&nbsp;&nbsp;<font color="#510812" size="3">'.htmlspecialchars($sum).'</font></p>
                    </div>';
	        echo $html;
	        ?>
</div>      
</fieldset>

<div class="row">
    <div class="offset-md-8 col-md-4">
        <input  type="button" value="Save and Next" class="btn btn-success" onclick="rpepcpSubmitParty();">
		&nbsp;&nbsp;<input type="reset" value="Reset/Clear" class="btn btn-danger">
    </div>
</div>

<?= form_fieldset_close(); ?>
  </div>
<?= form_close();?>
<?php $this->load->view("admin/footer"); ?>
<script>

function rpepcpSubmitParty(){
    var salt = document.getElementById("saltNo").value;
    var radios = document.getElementsByName("bd");
    var submittype = document.getElementById("submittype").value;
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    var totalamount = document.getElementById("totalamount").value;
    var remainamount = document.getElementById("remainamount").value;
    var collectamount = document.getElementById("collectamount").value;
    var filing_no = document.getElementById("filing_no").value;
    var type = document.getElementById("type").value;
  
    if (bd == 3) {
        var dbankname = document.getElementById("ntrp").value;
        if (dbankname == "") {
            alert("Please Enter Bank name");
            document.filing.ntrp.focus();
            return false;
        }
        var ddno = document.getElementById("ntrpno").value;
            var vasks = ddno.toString().length;
            if(Number(vasks) != 13){
               alert("Please Enter 13  Digit Challan No/Ref.No");
               document.ntrpno.focus();
               return false
             }

        if (ddno == "") {
            alert("Please Enter Challan No/Ref.No");
            document.filing.ntrpno.focus();
            return false
        }
        var dddate = document.getElementById("ntrpdate").value;
        if (dddate == "") {
            alert("Please Enter Date of Transction");
            document.filing.ntrpdate.focus();
            return false
        }
        var amountRs = document.getElementById("ntrpamount").value;
        if (amountRs == "") {
            alert("Please Enter Amount ");
            document.filing.ntrpamount.focus();
            return false
        }
    }
   
    var dataa={};
    dataa['dbankname']=dbankname,
    dataa['amountRs']=amountRs,
    dataa['ddno']=ddno,
    dataa['dddate']=dddate,
    dataa['bd']=bd,
    dataa['totalamount']=totalamount,
    dataa['salt']=salt,
    dataa['filing_no']=filing_no,
    dataa['token']='<?php echo $token; ?>',
    dataa['type']=type, 
    dataa['submittype']=submittype, 
    dataa['remainamount']=remainamount,
    dataa['collectamount']=collectamount,
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'iasave',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		setTimeout(function(){
                    window.location.href = base_url+'ia_finalreceipt';
                 }, 250); 
			}else if(resp.error != '0') {
		        $.alert({
                  title: '<i class="fa fa-check-circle text-warning"></i>&nbsp;</b>Error!</b>',
                  content: '<p class="text-danger">'+resp.display+'</p>',
                  animationSpeed: 2000
                });
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
		}
	 }); 
}


paymentMode(3);
function paymode(){
	with(document.rpepcpparty){
	action = base_url+"petitionparty";
	submit();
    	document.frm.submit11.disabled = true;  
     	document.frm.submit11.value = 'Please Wait...';  
     	return true;
	}
}



function addMoreAmountrpepcp(){
    var salt = document.getElementById("saltNo").value;
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    var totalamount = document.getElementById("totalamount").value;
    var remainamount = document.getElementById("remainamount").value;
    var filing_no = document.getElementById("filing_no").value;
    var type = document.getElementById("type").value;
    
    if (bd == 3) {
        var dbankname = document.getElementById("ntrp").value;
        if (dbankname == "") {
            alert("Please Enter Bank name");
            document.filing.ntrp.focus();
            return false;
        }
        var ddno = document.getElementById("ntrpno").value;
            var vasks = ddno.toString().length;
            if(Number(vasks) != 13){
               alert("Please Enter 13  Digit Challan No/Ref.No");
               document.ntrpno.focus();
               return false
             }

        if (ddno == "") {
            alert("Please Enter Challan No/Ref.No");
            document.filing.ntrpno.focus();
            return false
        }
        var dddate = document.getElementById("ntrpdate").value;
        if (dddate == "") {
            alert("Please Enter Date of Transction");
            document.filing.ntrpdate.focus();
            return false
        }
        var amountRs = document.getElementById("ntrpamount").value;
        if (amountRs == "") {
            alert("Please Enter Amount ");
            document.filing.ntrpamount.focus();
            return false
        }
    }
    var dataa={};
    dataa['dbankname']=dbankname,
    dataa['amountRs']=amountRs,
    dataa['ddno']=ddno,
    dataa['dddate']=dddate,
    dataa['bd']=bd,
    dataa['totalamount']=totalamount,
    dataa['salt']=salt,
    dataa['filing_no']=filing_no,
    dataa['token']='<?php echo $token; ?>',
    dataa['type']=type, 
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreddrpepcp',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		$('#payModepay').html(resp.display);
        		$('#remainamount').val(resp.remain);
        		$('#collectamount').val(resp.paid);
				$('#ntrpno').val('');
				$('#ntrpamount').val('');
				$('#ntrpdate').val('');
        		
			}else if(resp.error != '0') {
				$.alert(resp.massage);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
		}
	 }); 
 }
     
     
function paymentMode(values) {
	 var dataa={};
     dataa['app']=values;
     dataa['type']='review';
      $.ajax({
          type: "POST",
          url: base_url+"rpcpeppayment",
          data: dataa,
          cache: false,
          success: function (resp) {
        	  document.getElementById("payMode_review_petion").innerHTML = resp;
              document.getElementById("payMode_review_petion").style.display = 'block';
          },
          error: function (request, error) {
			$('#loading_modal').fadeOut(200);
          }
      }); 
}


function deletePayrpepcp(e) {
    var payid = e;
    var radios = document.getElementsByName("bd");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    var salt = document.getElementById("saltNo").value;
    var totalamount = document.getElementById("totalamount").value;
    var remainamount = document.getElementById("remainamount").value;
    var filing_no = document.getElementById("filing_no").value;
    var dataa={};
    dataa['payid']=payid,
    dataa['salt']=salt,
    dataa['bd']=bd,
    dataa['totalamount']=totalamount,
    dataa['remainamount']=remainamount,
   dataa['filing_no']=filing_no,
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoreddrpepcp',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        		setTimeout(function(){
                    window.location.href = base_url+'ia_payment';
                 }, 250); 
			}else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},
		complete: function(){
		}
	 });
}
</script>   