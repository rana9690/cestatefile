<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$userdata=$this->session->userdata('login_success');
$checkcpass=$userdata[0]->is_password;
?>
<div class="page-content" style=""> <!-- Close in footer bar-->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md" style="">
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle"><i class="icon-arrow-left8"></i></a> 
				<a href="#" class="sidebar-mobile-expand"> 
				<span class="leftmicon"><i class="fa fa-bars"></i></span> 
				<span class="leftmicon"><i class="fa fa-long-arrow-alt-left"></i></span>
					<!-- <i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i> -->
				</a>
			</div> 

			<div class="sidebar-content">
				<div class="sidebar-user" >
					<div class="card-body">
						<div class="media">
							<div class="mr-1">
								<ul class="navbar-nav">
                    				<li class="nav-item">
                    					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    						<i class="icon-paragraph-justify3"></i>
                    					</a>
                    				</li>
                    			</ul>
							</div>

							<?php $userdata=$this->session->userdata('login_success');  ?>
							<div class="media-body">
								<div class="media-title font-weight-semibold"><?php echo $userdata[0]->fname; ?></div>
								<div class="font-size-xs opacity-50">
									<i class="icon-pin font-size-sm"></i> &nbsp;<?php echo $userdata[0]->country; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-sidebar-mobile">

			<?php if($checkcpass==0){ }else{
				$this->load->view("admin/navigation");
				?>

						 	<?php } ?>
				</div>
			</div>
 		</div>

 		<?php
 		$salt= $this->session->userdata('salt');
 		$saltcc=$this->session->userdata('rpepcpsalt');
 		$salt=isset($salt)?$salt:$saltcc;
 		?>
 		<div class="content-wrapper">
 		<!-- Close in footer bar-->
			<div class="page-header page-header-light">
				<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
					<div class="d-flex">
						<div class="breadcrumb">
							<a href="" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
							<span class="breadcrumb-item active">Dashboard</span>
						</div>
						<!-- <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a> -->
					</div>
					<div class="header-elements d-none">
						<div class="breadcrumb justify-content-center">
							<div class="breadcrumb-elements-item dropdown p-0">

								<?php
								$restrictArray=array(
									'loginSuccess',
									'dashboard',
									'checklist',
									'review_petition_filing',
									'doc_basic_detail',
									'filedcase_list',
									'draft_list',
									'rpepcp_filed_list',
									'rpepcp_draftcase_list',
								);
								if(!in_array($this->uri->segment(1),$restrictArray)):
								?>
                                	<input type="text" class="form-control text-success" name="droft_no" id="droft_no"  value="REFF-<?php echo $salt; ?>" style="border: 0 none;float:right;font-weight:600;" readonly />
							<?php endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>