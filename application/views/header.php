<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="Link1" rel="shortcut icon" href="<?= base_url('asset/APTEL_files/');?>cestat.png">
    <title>CESTAT</title>

    <link href="<?= base_url('asset/APTEL_files/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/fontawesome.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/owl.carousel.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/owl.theme.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/jquery-confirm.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/custom.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/style3.css');?>" rel="stylesheet">
    <link href="<?= base_url('asset/APTEL_files/lightslider.css');?>" rel="stylesheet"> 

    <style>
    @font-face {
        font-family: 'dotsfont';
        src: url("<?=base_url()?>/asset/dotsfont-master/dist/dotsfont.eot");
        src: url('<?=base_url()?>/asset/dotsfont-master/dist/dotsfont.eot?#iefix') format('embedded-opentype'),
            url('<?=base_url()?>/asset/dotsfont-master/dist/dotsfont.woff') format('woff'),
            url('<?=base_url()?>/asset/dotsfont-master/dist/dotsfont.ttf') format('truetype'),
            url('<?=base_url()?>/asset/dotsfont-master/dist/dotsfont.svg#dotsfont') format('svg');
    }

    .mycustom {
        font-family: 'dotsfont';
    }
    </style>
</head>

<body class="bg_home">
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
                    <ul class="nav navbar-nav">
                        <li><a href="<?= base_url();?>"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="<?= base_url('asset/Guidelines-for-e-filing-of-Appeals.pdf');?>" target="_blank"><i
                                    class="fa fa-file"></i>&nbsp;Guidelines</a></li>
                    </ul>

                    <!-- <div class="social_menu">
                      <a href="#"><i class="fa fa-facebook"></i></a>
                      <a href="#"><i class="fa fa-twitter"></i></a>
                      <a href="#"><i class="fa fa-linkedin"></i></a>
                  </div> -->
                </div>
            </div>
        </nav>
    </header>