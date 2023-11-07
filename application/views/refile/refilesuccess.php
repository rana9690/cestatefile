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
					<img src="<?= base_url('asset/APTEL_files/logo_header.png');?>" class="text-center">
					<img src="<?= base_url('asset/APTEL_files/logo_di.png');?>" class="text-right" style="height:44px;">
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
			<?php 
                              $detail=$this->session->userdata('refiledetail');
                              
                              $filingno=$detail['filing_no'];
                              $redate=$detail['reffdate'];
                              $reff=$detail['reff'];
                              $paystatus=$detail['paystatus'];
                              ?>
			<div class="container">
				<div id="mainDiv1">
		 			<div class="col-md-4">
                        <label class="text-danger">Refile Detail </label>
                    </div>
                    <div id="testdiv" class="pr-hide">
                    	<a target="_blank" href="<?php echo base_url(); ?>refilereceipt/<?php echo $filingno; ?>"> <font color="red" size="1"><img src="<?php echo base_url();?>asset/images/print.gif"  
                    	height="22" width="62px" class="no-print" border='0' style="margin-left: 1000px;"/></font></a>
                    </div>
	                <div class="row">
                        <div class="col-md-6 md-offset-2">
                            <table class="table" style="width:1000px">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Filing No</th>
                                  <th scope="col">Refile Date</th>
                                  <th scope="col">Payment Status</th>
                                  <th scope="col">Refference number</th>
                                </tr>
                              </thead>
                              <tbody>
                              
                                <tr>
                                  <th scope="row">1</th>
                                  <td><?php echo $filingno; ?></td>
                                  <td><?php echo $redate; ?></td>
                                  <td><?php echo $paystatus; ?></td>
                                  <td><?php echo $reff; ?></td>
                                </tr> 
                              </tbody>
                            </table>
                        </div>
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
</body>

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
