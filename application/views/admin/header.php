<?php
	if(!$this->session->userdata('login_success')) {
		redirect(base_url(), 'refresh');
		exit();	
	}
	$userdata=$this->session->userdata('login_success');
	$fname=$userdata[0]->fname;
	$lname=$userdata[0]->lname;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link id="Link1" rel="shortcut icon" href="<?= base_url('asset/APTEL_files/');?>cestat.png">
    <title>e-filing</title>
    <link href="<?=base_url('asset/admin_css_final/styles.css')?>" rel="stylesheet">
    <link href="<?=base_url('asset/admin_css_final/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('asset/admin_css_final/bootstrap_limitless.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/jquery-confirm.css');?>" rel="stylesheet">
    <link href="<?=base_url('asset/admin_css_final/layout.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('asset/admin_css_final/components.min.css')?>" rel="stylesheet">
    <link href="<?=base_url('asset/admin_css_final/colors.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/fontawesome.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/bootstrap.min.css');?>" rel="stylesheet">   
    <link href="<?= base_url('asset/APTEL_files/custom.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/admin_css_final/customs.css'); ?>" rel="stylesheet">   
    <link href="<?= base_url('asset/APTEL_files/custom.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/style3.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/admin_css_final/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('asset/admin_css_final/buttons.dataTables.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('asset/admin_css_final/jquery.dataTables.min.css'); ?>" rel="stylesheet">
    <script src="<?=base_url('asset/admin_js_final/jquery.min.js')?>"></script>
    <script>
       $('.loading').show();
       </script>
</head>


<body>
<div class="loading">Loading&#8230;</div>
    <div class="container-fluid top no-display-on-mobile"> </div>
    <section class="logo flag-bg">
        <div class="mainheader">
            <div class="header_inner">
                <a href="#"><img src="<?= base_url('asset/APTEL_files/');?>cestat.png" class="logo_left"></a>
                <span class="site_name">Customs Excise And Service Tax<br />Appellate Tribunal (CESTAT)</span>
                <div class="right_logo">
                    <img src="<?= base_url('asset/APTEL_files/');?>logo_sb.png">
                    <img src="<?= base_url('asset/APTEL_files/');?>logo_di.png">
                </div>
            </div>
        </div>
    </section>

    <header id="main-menu-container" class="">
        <nav class="navbar navbar-inverse main-menu navbar-inverse-bg" id="skip">
            <div class="nav_menu">
                <div class="navbar-header">
                    <span class="mtopname">Welcome, <?= strtoupper($fname.' '.$lname); ?></span>
                    <button class="navbar-toggle" type="button" data-toggle="collapse"
                        data-target=".js-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden-sm hidden-md hidden-lg logo_on_mobile" href="#">
                        <img src="<?= base_url('asset/APTEL_files/emb.png');?>" class="img-responsive"
                            style="width:110px;height:auto;"></a>
                </div>
                <div class="collapse navbar-collapse js-navbar-collapse" id="Divmenu">
                    <ul class="nav navbar-nav inner-nav d-menu">
                        <li class="hassubmenu"><a href="">Welcome, <?= strtoupper($fname.' '.$lname); ?></a>
                            <ul>
                                <li><a href="<?php echo base_url(); ?>myprofile">My Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>editprofile">Edit Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>change_password"
                                        data-value="change_password">Change&nbsp;Password</a></li>
                                <li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>

					<ul class="nav navbar-nav inner-nav m-menu"> 
                                <li><a href="<?php echo base_url(); ?>myprofile">My Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>editprofile">Edit Profile</a></li>
                                <li><a href="<?php echo base_url(); ?>change_password"
                                        data-value="change_password">Change&nbsp;Password</a></li>
                                <li><a href="<?php echo base_url(); ?>logout">Logout</a></li> 
                    </ul>

                </div>
            </div>
        </nav>
    </header>

    <!-- <header style="background: #ddd">
		<div class="upper">
			<div class="inner">
				<img style="height: 60px;" src="<?= base_url('asset/APTEL_files/');?>cestat.png" class="logo_left">

		  <strong style="font-size:30px; font-family: Georgia, Times New Roman, Times, serif; text-align:right;color:#aa0808;"><?=$this->config->item('site_name')?></strong>
				<div class="right_logo">
					<img src="<?= base_url('asset/APTEL_files/logo_di.png');?>" class="text-right">
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
					 <li><a href="<?php echo base_url(); ?>logout">Logout</a></li> 
				</ul>
			</nav>
		</div>
	</header> -->