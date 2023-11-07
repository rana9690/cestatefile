<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>

<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script>
<?php
$token= $this->efiling_model->getToken();
    error_reporting(0);
    $saltmain= $_REQUEST['saltNo'];
    if($saltmain==''){
        header(base_url());
    }
//ini_set('display_errors', 1);
	//	    ini_set('display_startup_errors', 1);
		//    error_reporting(E_ALL);
?>
<style>
    .srchWrap {
        margin-left: 194px;
        position: relative;
        float: right;
        width: 100%;
        margin-right: 10px;
    }

    .srchWrap input {
        padding-left: 35px;
        font-size: 16px;
    }

    .srchWrap input:focus {
        border: 1px solid #2196f3 !important;
    }

    .srchWrap i {
        position: absolute;
        left: 12px;
        top: 14px;
    }

    .error {
        color: red;
    }

    .table>tbody>tr>td {
        vertical-align: top;
        word-wrap: break-word;
        word-break: break-word;
    }

    .inputpw {
        -webkit-text-security: disc;
    }

    .upperinput {
        text-transform: uppercase;
    }
</style>

	<script>
	function submitForm(){
		with(document.frmPay){
			action="http://training.pfms.gov.in/bharatkosh/bkepay";
			submit();
			return true;
		}
	}


	</script>

<!--<body onload="paymentMode1();">-->

<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">


	        		
			<div id="secondDiv"></div>

			<div id="mainDiv1">
			<form name="frmPay" method="post" >
			 <input type="hidden" name="saltmain" id="saltmain" value="<?php echo  $saltmain; ?>">
  			 <input type="hidden" name="org1" id="org1" value="<?php echo  $_REQUEST['org']; ?>">
             <input type="hidden" name="orgres1" id="orgres1" value="<?php echo  $_REQUEST['orgres']; ?>">
             <input type="hidden" name="token" id="token" value="<?php echo  $token; ?>">
             <input type="hidden" name="bench" id="bench" value="<?php echo  $_REQUEST['bench']; ?>">
             <input type="hidden" name="sub_bench" id="sub_bench" value="<?php echo  $_REQUEST['sub_bench']; ?>">
             <input type="hidden" name="caseType" id="caseType" value="<?php echo  $_REQUEST['caseType']; ?>">
             
            

                        <?php 
                        $salt=$this->session->userdata('salt'); 
                        $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
                        $ianature=$st[0]->ia_nature;
						$iawa='0';
						if($this->config->item('ia_privilege')==true):
                        $valia=explode(',', $ianature);
                        
                        if(in_array('3', $valia)){
                            $iawa='3';
                        }
						endif;

                        
                        $noofimpugned=$st[0]->no_of_impugned;
                        $ia=$st[0]->no_of_ia;
                        $norespondent=$st[0]->no_of_res;
                        $fee=$this->session->userdata('efilingFeeData'); 
                        
                       
                        $iaFee1= @$fee['iaFee1'];
                        $otherFee2=@$fee['otherFee2'];
                        
                        
                        $act = $st[0]->act;
                        $hscqueryact11 =$this->efiling_model->data_list_where('master_energy_act','act_code',$act);
                        $fee = isset($hscqueryact11[0]->fee)?$hscqueryact11[0]->fee:'';
                        
                        
                        $st=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt', $salt);
                        $rescount=count($st)+1;
                        $resamoubnt=0;
                        if($rescount>4){
                            $resamoubnt=($rescount-4)*$fee;
                        }
                        //$appealFee= $fee*$noofimpugned+$resamoubnt;
                        $total=@$appealFee+$iaFee1+$otherFee2;
                        
                        ?>
                       <input type="hidden" name="wia" id="wia" value="<?php echo  $iawa; ?>">
			 <FIELDSET>
                 <LEGEND><b>Amount Details</b></legend>

                    <div class="row">
                            <div class="col-md-3">
                                <div class="form-group required">
                                    <label>Appeal Fee<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'totalFee3','id'=>'totalFee3','class'=>'form-control','readonly'=>'true','value'=>$appealFee]) ?>
                                </div>
                            </div>
								  <?php if($this->config->item('ia_privilege')==true):?>
                            <div class="col-md-3">
                                <div class="form-group required">
                                    <label>IA Fee<span class="text-danger">*</span></label>
                                    <?= form_input(['name'=>'iaFee1','id'=>'iaFee1','class'=>'form-control','readonly'=>'true','value'=>$iaFee1]) ?>
                                </div>
                            </div>
								  <?php endif;?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Other Fee</label>
                                    <?= form_input(['name'=>'otherFee2','id'=>'otherFee2','class'=>'form-control','readonly'=>'true','value'=>$otherFee2]) ?>
                                </div>
                            </div>          
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Total Fee</label>
                                    <?= form_input(['name'=>'total','id'=>'total','class'=>'form-control','readonly'=>'true','value'=>$total]) ?>
                                </div>
                            </div>


                            
                        </div> 

                <!--xml create-->
				<?php 
				$salt=rand('0000','9999');
                 //Write code to fetch the all value to pass in the variable   	 
                $email='';
                
                $departmentcode='010';						//Fixed
                $merchantBatchCode=$salt;		//SaltID
                $OrderCode=$salt;	//SaltID
                //$merchantBatchCode='9007641209609303';		//SaltID
                //$OrderCode='9007641209609303';				//SaltID
                
                $orderbactachAmount='1';
                $InstallationId='10070';					//Fixed
                $description='APTEL RECEIPT(COURT FEE)';		//Fixed
                $cartdetailAmount='1';
                
                $OrderContent='326';						//Fixed
                $PaymentTypeId='51';						//Fixed
                $PAOCode='013455';							//Fixed
                $DDOCode='213459';	
                //Fixed
                $ShopperEmailAddress='dubey.ravi7@gmail.com';
                $shipaddfirst='Ravi Kumar';
                $shipaddlast='dubey';
                $shipaddress1='Police line sidhi';
                $shippincode='486661';
                $shipcity='Sidhi';
                $shipstateregion='New Delhi';
                $shipstate='Delhi';
                $shipcountry='INDIA';
                $shipmobileno='9958663113';
                
                $billaddfirst='ravi ';
                $billaddlast='Police line sidhi';
                $billaddress1='Police line sidhi';
                $billpincode='110092';
                $billcity='Delhi';
                $billstateregion='Delhi';
                $billstate='New Delhi';
                $billcountry='INDIA';
                $billmobileno='9958663113';
                $strbharatxml="<BharatKoshPayment DepartmentCode='$departmentcode' Version='1.0'><Submit><OrderBatch TotalAmount='$orderbactachAmount' Transactions='1' merchantBatchCode='$merchantBatchCode'><Order InstallationId='$InstallationId' OrderCode='$salt'><CartDetails><Description/><Amount CurrencyCode='INR' exponent='0' value='$cartdetailAmount' /><OrderContent>$OrderContent</OrderContent><PaymentTypeId>$PaymentTypeId</PaymentTypeId><PAOCode>$PAOCode</PAOCode><DDOCode>$DDOCode</DDOCode></CartDetails><PaymentMethodMask><Include Code='Online'/></PaymentMethodMask><Shopper><ShopperEmailAddress>$ShopperEmailAddress</ShopperEmailAddress></Shopper><ShippingAddress><Address><FirstName>$shipaddfirst</FirstName><LastName>$shipaddlast</LastName><Address1>$shipaddress1</Address1><Address2/><PostalCode>$shippincode</PostalCode><City>$shipcity</City><StateRegion>$shipstateregion</StateRegion><State>$shipstate</State><CountryCode>$shipcountry</CountryCode><MobileNumber>$shipmobileno</MobileNumber></Address></ShippingAddress><BillingAddress><Address><FirstName>$billaddfirst</FirstName><LastName>$billaddlast</LastName><Address1>$billaddress1</Address1><Address2/><PostalCode>$billpincode</PostalCode><City>$billcity</City><StateRegion>$billstateregion</StateRegion><State>$billstate</State><CountryCode>$billcountry</CountryCode><MobileNumber>$billmobileno</MobileNumber></Address></BillingAddress><StatementNarrative/></Order></OrderBatch></Submit></BharatKoshPayment>";  
                $url = 'localhost:8090/signXml';
                //open connection
                $ch = curl_init();
                //$fields_string = http_build_query($strbharatxml);
                //$fields_string =http_build_query($post_array);
                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                //curl_setopt($ch,CURLOPT_POST, count($fields_string));
                curl_setopt($ch,CURLOPT_POST, 1);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $strbharatxml);
                curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: text/plain'));
                ?>          
                <input type="hidden" value="<?php $result = curl_exec($ch); ?>"  name="bharrkkosh" id="bharrkkosh"/>        
                <input type="hidden" name="total_amount_amount" id="total_amount_amount" value="<?php echo $_REQUEST['total_amount_amount']; ?>">
       		
	                <div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px;  max-width: 100%;">
                        <div class="col-md-4">
                            <label class="text-danger">Payment Mode</label>
                        </div>
                        <div class="col-md-6 md-offset-2">
                            <!--label for="org" class="form-check-label font-weight-semibold">
                                <input type="radio" name="orgres" value="1" checked="checked" id="bd1" onclick="paymentMode1();"> Online&nbsp;&nbsp;
                            </label-->
                            <label for="indv" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'orgres','id'=>'partial' ,'value'=>'3' ,'onclick'=>'paymentMode1();','checked'=>'checked']); ?>
                                Offline Payment&nbsp;&nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="row" id="buttonpay" style="display: none;">
                        <div class="offset-md-8 col-md-4">
                		<input type="submit"  name="go" id="gobtn" value="Pay Online"  onClick="javascript:submitForm();" class="btn btn-success" id="nextsubmit">
						<input type="reset" value="Reset/Clear" class="btn btn-danger">
                        </div>
                    </div> 
                    <div class="row" id="payMode"></div> 
                     <div class="row inner-card" id="paydetail">
                  <?php  $html=""; $html.='
                 <table  class="table display table-center"><thead>
                      <th colspan="5" class="text-center font-weight-bold">Transaction Detail</th>
                  <tr class="bg-dark">
                      <th>Name</th>
                      <th>Challan/Ref. No</th>
                      <th>Date of Transction</th>
                      <th>Amount in Rs.</th>
                      <th>Delete</th>
                  </tr> </thead><tbody>';
                $salt=$this->session->userdata('salt'); 
            		$sum=0;
            		$feesd=$this->efiling_model->data_list_where('aptel_temp_payment','salt',$salt);

            		foreach($feesd as $row){
                    	$id=$row->id;
                    	$sum=$sum+$row->amount;
                    	$html.='
                       <tr id="id'.$id.'">
                        <td>'.$row->branch_name.'</td>
                        <td>'.$row->dd_no.'</td>
                        <td>'.$row->dd_date.'</td>   
                        <td>'.$row->amount.'</td>
                        <td><input type="button" value="Delete"  class="btn1 btn btn-xs btn-danger" onclick="deletePay('.$id.')"/></td>
                     </tr>';
            		}
                    $html.='</tbody><tfoot> <tr><th colspan="5" class="font-weight-bold text-center">Total Rs. '.$sum.'<input type="hidden" name="collectamount" id="collectamount" value="'.$sum.'">
                    </th></tr></tfoot></table>
            		';
                    echo $html;
                    ?>
                     </div>
                 <?= form_fieldset_close(); ?>
            </form>
            </div>

				 
                        


			<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>
				<div class="navbar-collapse collapse" id="navbar-footer"> </div>
			</div>
		</div> <!-- page-content -->
	</div> <!-- content-wrapper -->











	<!---- Loading Modal ------------->
    <div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" id="loading_modal">
        <div class="modal-dialog modal-sm" style="margin-top: 190px; text-align: center;">
            <div class="modal-content" style="width: 90px; height: 90px; padding: 15px 25px;">
                <span class="fa fa-spinner fa-spin fa-3x"></span>
                <p class="text-danger" style="margin: 12px -12px;">Loading.....</p>
            </div>
        </div>
    </div>
	
	
     <div class="modal fade bd-example-modal-lg" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" style="margin-top: 190px; text-align: center;">
            <!-- Modal content-->
                <div class="modal-content">
                 <form action="certifiedsave.php" method="post">
                      <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div id="viewsss">
                      </div>
                  </form>
              </div>
         </div>
    </div>



    <?php $this->load->view("admin/footer"); ?>
<script>    
function paymentMode1() {
    var radios = document.getElementsByName("orgres");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    if (bd == 1) {
    	document.getElementById('buttonpay').style.display = 'block';
        document.getElementById("payMode").style.display = 'none';
      //  document.getElementById("listamount").style.display = 'none';
    }
   
    if (bd == 3) {
    	document.getElementById("buttonpay").style.display = 'none';
    //	document.getElementById("listamount").style.display = 'block';
         $.ajax({
            type: "POST",
            url: base_url+"postalorderfinal",
            data: "app=" + bd,
            cache: false,
            success: function (data) {
            	document.getElementById("payMode").style.display = 'block';
            	$('#payMode').html(data);
            }
        });
         
    }
}
$(document).ready(function() {
    paymentMode1();
});

function deletePay(e) {
    var payid = e;
    var radios = document.getElementsByName("orgres");
    var bd = 0;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            var bd = radios[i].value;
        }
    }
    var salt = document.getElementById("saltmain").value;
    var dataa={};
    dataa['payid']=payid,
    dataa['salt']=salt,
    dataa['bd']=bd,
    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoredd',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#loading_modal').modal();
		},
        success: function (resp) {
        	if(resp.data=='success') {
				$('#id'+e).hide();
				setTimeout(function () { location.reload(1); }, 100);
			}
        },
        error: function(){
			$.alert("Server busy,try later.");
		},
		complete: function(){
		}
	 });
    document.getElementById("addmoreaddpay").style.display = 'block';
    document.getElementById("addmoreadd").style.display = 'none';
}


function addMoreAmount() {

    	var saltmain = document.getElementById("saltmain").value;
    	var radios = document.getElementsByName("orgres");

    	var bd = 0;
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                var bd = radios[i].value;
            }
        }
       if (bd == 3) {
        var dbankname = document.getElementById("ntrp").value;
        if (dbankname == "") {
            alert("Please Enter Bank name");
            document.filing.ntrp.focus();
            return false;
        }
           var dddate = document.getElementById("ntrpdate").value;

           if (dddate == "") {
               alert("Please Enter Date of Transction");
               document.filing.ntrpdate.focus();
               return false
           }
        var ddno = document.getElementById("ntrpno").value;
		var vasks = ddno.toString().length;
        /*if(Number(vasks) < 7){
          			alert("Please Enter atleast 8 Digit Challan No/Ref.No");
                    document.filing.ntrpno.focus();
                    return false
        }*/
        if (ddno == "") {
            alert("Please Enter Challan No/Ref.No");
            document.filing.ntrpno.focus();
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
    dataa['salt']=saltmain,

    $.ajax({
	    dataType: 'json',
        type: "POST",
        url: base_url+'addMoredd',
        data: dataa,
        cache: false,
		beforeSend: function(){
			//$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
		},
        success: function (resp) {
        	if(resp.data=='success') {
        	   $("#paydetail").html(resp.display);
        		 $.alert({
					title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Success</b>',
					content: '<p class="text-success">Amount added successfully.</p>',
					animationSpeed: 2000
				 });
			}else if(resp.error != '0') {
				$.alert(resp.error);
			}
        },
        error: function(){
			$.alert("Server busy,try later.");
		},
		complete: function(){
		}
	 }); 
    if (bd == 1) {
        document.getElementById("dbankname").value = "";
        document.getElementById("ddno").value = "";
        document.getElementById("dddate").value = "";
        document.getElementById("amountRs").value = "";
    }
    if (bd == 3) {
        document.getElementById("ntrpno").value = "";
        document.getElementById("ntrpdate").value = "";
        document.getElementById("ntrpamount").value = "";
    }
}




function popitup(filingno) {

 	 var dataa={};
      dataa['filingno']=filingno,
       $.ajax({
           type: "POST",
           url: base_url+"/filingaction/filingPrintSlip",
           data: dataa,
           cache: false,
           success: function (resp) {
         	  $("#getCodeModal").modal("show");
          	  document.getElementById("viewsss").innerHTML = resp; 
           },
           error: function (request, error) {
				$('#loading_modal').fadeOut(200);
           }
       }); 
 	  
 }
 

</script>


<script type="text/javascript">
	var base_url='', salt='';
	base_url ='<?php echo base_url(); ?>';
    salt='<?php echo hash("sha512",strtotime(date("d-m-Y i:H:s"))); ?>';
</script>

</html>
