<?php 
$token= $this->efiling_model->getToken();
    error_reporting(0);
    $saltmain= $_REQUEST['saltNo'];
    if($saltmain==''){
        header(base_url());
    }
    $userdata=$this->session->userdata('login_success');
    $fname=$userdata[0]->fname;
    $lname=$userdata[0]->lname;
    $token= $this->efiling_model->getToken();
    $salt=$this->session->userdata('salt'); 
?>
<!DOCTYPE html>
<html >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>e_filing pay</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet">
	<link href="<?=base_url('asset/admin_css_final/styles.css')?>" rel="stylesheet">
	<link href="<?=base_url('asset/admin_css_final/bootstrap.min.css')?>" rel="stylesheet">
	<link href="<?=base_url('asset/admin_css_final/bootstrap_limitless.min.css')?>" rel="stylesheet">
	<link href="<?= base_url('asset/APTEL_files/jquery-confirm.css');?>" rel="stylesheet">	
	<link href="<?=base_url('asset/admin_css_final/layout.min.css')?>" rel="stylesheet">
	<link href="<?=base_url('asset/admin_css_final/components.min.css')?>" rel="stylesheet">
	<link href="<?=base_url('asset/admin_css_final/colors.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/fontawesome.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('asset/admin_css_final/customs.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('asset/admin_css_final/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('asset/admin_css_final/buttons.dataTables.min.css'); ?>" rel="stylesheet">
	<link href="<?= base_url('asset/admin_css_final/jquery.dataTables.min.css'); ?>" rel="stylesheet">	
	<script>
	function submitForm(){
		with(document.frmPay){
			action="http://training.pfms.gov.in/bharatkosh/bkepay";
			submit();
			return true;
		}
	}
	</script>
	<style>
	.content-wrapper {
    overflow: hidden;
        }
	</style>
</head>	
<body onload="paymentMode1();">
	<header style="background: #fff">
		<div class="upper">
			<div class="inner">
                <img style="height: 60px;" src="<?= base_url('asset/APTEL_files/');?>cestat.png" class="logo_left">
                <strong style="font-size:30px; font-family: Georgia, Times New Roman, Times, serif; text-align:right;color:#aa0808;"><?=$this->config->item('site_name')?></strong>
				<div class="right_logo">
					<!-- <img src="<?// base_url('asset/APTEL_files/logo_header.png');?>" class="text-center"> -->
					<img src="<?// base_url('asset/APTEL_files/logo_header2.png');?>" class="text-right" style="height:44px;">
				</div>
			</div>
		</div>
		<div class="lower">
			<nav>
				<ul class="lt">
					<li><a href="">Home</a></li>
				</ul>
				<ul class="rt">
				
					<li class="hassubmenu"><a href="">Welcome, <?= strtoupper($fname.' '.$lname); ?></a>
						<ul>
							<li><a href="<?php echo base_url(); ?>myprofile">My Profile</a></li>
							<li><a href="<?php echo base_url(); ?>editprofile">Edit Profile</a></li>
							<li><a href="<?php echo base_url(); ?>change_password" data-value="change_password">Change&nbsp;Password</a></li>
							<li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
						</ul>
					</li>
					<!-- <li><a href="<?php echo base_url(); ?>logout">Logout</a></li> -->
				</ul>
			</nav>
		</div>
	  </header>
	
	  <div class="page-content" style="margin-top: 110px;"> <!-- Close in footer bar-->

 		<div class="content-wrapper"> <!-- Close in footer bar-->
			<div class="page-header page-header-light">
				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="<?php echo base_url(); ?>loginSuccess" class="breadcrumb-item"><i class="icon-home2 mr-2"></i>Back</a>
							<span class="breadcrumb-item active">Dashboard</span>
						</div>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">
							<div class="breadcrumb-elements-item dropdown p-0">
								  <div style="margin-left: 80px;" class="srchWrap">
                    					<input type="test" class="form-control" name="droft_no" id="droft_no"  value="" readonly>
                   				</div> 
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="container">
	       <div id="secondDiv"></div>
			<div id="mainDiv1">
			<form name="frmPay" method="post" >
             <input type="hidden" name="token" id="token" value="<?php echo  $token; ?>">  
             <input type="hidden" name="salt" id="salt" value="<?php echo  $salt; ?>">  
            <?php
            $token1= $this->efiling_model->getToken();
            $norespondent=0;
            $countcomm=0;
            $commFee=0;
            $query="select * from additional_commision where  filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
            $data=$this->db->query($query);
            if($data->num_rows()>0) {
                $countcomm= count($data->result());
                $commFee=$countcomm*100000;
            }
            
            
            $appFee=0;
            $queryApp="select * from additional_party where party_flag='1' AND filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
            $data=$this->db->query($queryApp);
            if($data->num_rows()>0) {
                $countapp= count($data->result());
                if($countapp>5){
                    $appFee=$countapp*5000;
                }
            }
            
            $countorg='0';
            $queryRes1="select count(filing_no) from additional_party where party_flag='2' AND  addedfrom IS NULL AND filing_no='$salt' and paymentstatus='0' ";
            $data1=$this->db->query($queryRes1);
            if($data1->num_rows()>0) {
                $val= $data1->result();
                $countorg=$val[0]->count+1;
            }
            //6
            
            $otherFee2=0;
            $resFee=0;
            $exclusiveamount=10000;
            $queryRes="select * from additional_party where party_flag='2' AND filing_no='$salt' and addedfrom='refile' and paymentstatus='0' ";
            $data=$this->db->query($queryRes);
            if($data->num_rows()>0) {
                $countres= count($data->result());
                $total=$countres+$countorg;
                if($total < 4){
                    $resFee=0;
                }
                if($total>4){
                    $resFee=($total-4)*10000;
                }
                if($total==4){
                    $resFee=0;
                }
            }  //20000 per//2
            //$appealFee= $commFee;
            $total=@$appealFee+$otherFee2+$resFee;
            
                        ?>

                    <table class="table" id="example">
                      <thead>
                         <tr style="background-color: #ebdada">
                          <th scope="col">S.NO</th>
                          <th scope="col">Court Fee</th>
                          <th scope="col">Total Fees</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td><?php echo $appealFee;?></td>
                          <td><?php echo $total;?></td>
                        </tr>
                      </tbody>
                    </table>
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
                $fields_string = http_build_query($strbharatxml);
                $fields_string =http_build_query($post_array);
                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                //curl_setopt($ch,CURLOPT_POST, count($fields_string));
                curl_setopt($ch,CURLOPT_POST, 1);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $strbharatxml);
                curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: text/plain'));
                ?>    
                <input type="hidden" value="<?php echo $totalfee; ?>"  name="collectamount" id="collectamount"/>   
                <input type="hidden" value="<?php echo $totalfee; ?>"  name="total" id="total"/>   
                <input type="hidden" value="<?php $result = curl_exec($ch); ?>"  name="bharrkkosh" id="bharrkkosh"/>        
                <input type="hidden" name="total_amount_amount" id="total_amount_amount" value="<?php echo $totalfee; ?>">
       		
	                <div class="row alert alert-warning" style="display: none;">
                        <div class="col-md-4">
                            <label class="text-danger">Select Mode</label>
                        </div>
                        <div class="col-md-6 md-offset-2">
                            <label for="org" class="form-check-label font-weight-semibold">
                                <input type="radio" name="orgres" value="1" checked="checked" id="bd1" onclick="paymentMode1();"> Online&nbsp;&nbsp;
                            </label>
                            <label for="indv" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'orgres','id'=>'partial' ,'value'=>'3' ,'onclick'=>'paymentMode1();','checked'=>'checked']); ?>
                                Offline Payment&nbsp;&nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="row" id="buttonpay" style="display: none;">
                        <div class="offset-md-8 col-md-4" style="margin-left: 81.33333%;">
                		<input type="submit"  name="go" id="gobtn" value="Pay Online"  onClick="javascript:submitForm();" class="btn btn-success" id="nextsubmit">
						<input type="reset" value="Reset/Clear" class="btn btn-danger">
                        </div>
                    </div>

                <div class="row" id="">
                    <?php  $html=""; $html.='
                 <table  class="table"><thead>
                      <th colspan="5" class="text-center font-weight-bold">Transaction Detail</th>
                  <tr>
                      <th>Name</th>
                      <th>Challan/Ref. No</th>
                      <th>Date of Transction</th>
                      <th>Amount in Rs.</th>

                  </tr> </thead><tbody>';
                    $salt=$this->session->userdata('salt');
                    $sum=0;
                    $feesd=$this->efiling_model->data_list_where($schemas.'.fee_detail','filing_no',$salt);

                    foreach($feesd as $row){

                        $id=$row->id;
                        $sum=$sum+$row->amount;
                        $html.='
                       <tr id="id'.$id.'">
                        <td>'.$row->branch_name.'</td>
                        <td>'.$row->dd_no.'</td>
                        <td>'.$row->dd_date.'</td>
                        <td>'.$row->amount.'</td>

                     </tr>';
                    }
                    if($total>$sum){
                        $sum = $total-$sum;
                    }
                    $html.='</tbody><tfoot> <tr><th colspan="5" class="font-weight-bold text-center">Total Rs. '.$sum.'<input type="hidden" name="collectamount" id="collectamount" value="'.$sum.'">
                    </th></tr></tfoot></table>
            		';
                    echo $html;
                    ?>
                </div>

                     <div class="row" id="payMode"></div> 
                     <div class="row" id="paydetail">
                     </div>




            </div>
			</form>	
			 		<?= form_fieldset_close(); ?>
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
		</div> 
	</div> 
	<!---- Loading Modal ------------->
        	<div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" id="loading_modal">
        	    <div class="modal-dialog modal-sm" style="margin: 25% 50%; text-align: center;">
        	        <div class="modal-content" style="width: 90px; height: 90px; padding: 15px 25px;">
        	            <span class="fa fa-spinner fa-spin fa-3x"></span>
        	            <p class="text-danger" style="margin: 12px -12px;">Loading.....</p>
        	        </div>
        	    </div>
        	</div>
	
	
		  <div class="modal fade bd-example-modal-lg" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                    <div class="modal-content">
                     <form action="certifiedsave.php" method="post">
                          <div class="modal-header" style="background-color: cadetblue;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div id="viewsss">
                          </div>
                      </form>
                  </div>
             </div>
         </div>  
</body>
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
    }
    if (bd == 3) {
    	document.getElementById("buttonpay").style.display = 'none';
         $.ajax({
            type: "POST",
            url: base_url+"postalorderfinaledit",
            data: "app=" + bd,
            cache: false,
            success: function (data) {
            	document.getElementById("payMode").style.display = 'block';
            	$('#payMode').html(data);
            }
        });
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
<script src="<?=base_url('asset/admin_js_final/jquery.min.js')?>"></script>
<script src="<?= base_url('asset/admin_js_final/jquery.dataTables.min.js'); ?>"></script> 
<script src="<?= base_url('asset/admin_js_final/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?=base_url('asset/admin_js_final/bootstrap.bundle.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/blockui.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/d3.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/d3_tooltip.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/switchery.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/bootstrap_multiselect.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/moment.min.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/daterangepicker.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/app.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/dashboard.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/jquery-ui.js')?>"></script>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script>
<script src="<?= base_url('asset/APTEL_files/jquery-confirm.js');?>"></script>
<script src="<?=base_url('asset/admin_js_final/efiling.js')?>"></script>
<script src="<?= base_url('asset/APTEL_files/hash.js'); ?>"></script>
<script type="text/javascript">
	var base_url='', salt='';
	base_url ='<?php echo base_url(); ?>';
    salt='<?php echo hash("sha512",strtotime(date("d-m-Y i:H:s"))); ?>';
</script>

</html>
