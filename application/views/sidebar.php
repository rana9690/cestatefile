<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md" style="z-index:0">
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle"><i class="icon-arrow-left8"></i></a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>

			<div class="sidebar-content">
				<div class="sidebar-user" >
					<div class="card-body">
						<div class="media">
							<div class="mr-3">
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
							<div class="ml-3 align-self-center">
								<a href="#" class="text-white"><i class="icon-cog3"></i></a>
							</div>
						</div>
					</div>
				</div>

				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">
						<li class="nav-item"><a href="javascript: void(0);" data-value="dashboard"  class="nav-link active"><i class="icon-home4"></i><span>Dashboard</span></a></li>
					<?php  if($this->config->item('caviat_privilege')==true):?>
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Caveat</span></a>
							<ul class="nav nav-group-sub left-bar-links" data-submenu-title="Layouts">
								<li class="nav-item"><a href="javascript: void(0);"  data-value="caveat" class="nav-link active" id="caveat">Caveat Filing</a></li>
								<li class="nav-item"><a href="javascript: void(0);" data-value="ia_list" class="nav-link" id="ia_list">IA List</a></li>
							</ul>
						</li>
						<?php endif;?>
						
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Filing </span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Layouts">    							
        						<li class="nav-item nav-item-submenu">
        							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Original  Filing </span></a>
        							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
        								<li class="nav-item"><a href="javascript: void(0);" data-value="case_filing_steps"  class="nav-link active">Fresh Filing(New Appeal)</a></li>
        								<li class="nav-item"><a href="javascript: void(0);" data-value="filedcase_list"  class="nav-link active">Filed Cases</a></li>
        								<li class="nav-item"><a href="javascript: void(0);" data-value="draft_list"  class="nav-link active">Draft Cases</a></li>
        							</ul>
        						</li>
        						
        						<li class="nav-item nav-item-submenu">
        							<a href="#" class="nav-link"><i class="icon-copy"></i> <span><?=$this->lang->line('applFilingMenu')?> </span></a>
        							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
        							    <li class="nav-item"><a href="javascript: void(0);" data-value="review_petition_filing"  class="nav-link active"><?=$this->lang->line('applFilingMenu');?></a></li>
										<!--li class="nav-item"><a href="javascript: void(0);" data-value="edit_contempt_petition_filing"  class="nav-link active">Contempt Petition</a></li>
										<li class="nav-item"><a href="javascript: void(0);" data-value="edit_execution_petition_filing" class="nav-link active">Execution Petition</a></li--> 
        								<li class="nav-item"><a href="javascript: void(0);" data-value="rpepcp_filed_list"  class="nav-link active">Filed Cases</a></li>
										<li class="nav-item"><a href="javascript: void(0);" data-value="rpepcp_draftcase_list"  class="nav-link active">Draft Cases</a></li>
        							</ul>
        						</li>
        						
								<li class="nav-item nav-item-submenu">
        							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Document Filing </span></a>
        							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
        							     <li class="nav-item"><a href="javascript: void(0);" data-value="edit_document_filing" class="nav-link active">Document Filing  </a></li>
        								<li class="nav-item"><a href="javascript: void(0);" data-value="doc_case_filed_case"  class="nav-link active">Filed Cases</a></li>
										<li class="nav-item"><a href="javascript: void(0);" data-value="doc_draftcase_list"  class="nav-link active">Draft Cases</a></li>
        							</ul>
        						</li>
        						<?php  if($this->config->item('ia_privilege')==true):?>
        						<li class="nav-item nav-item-submenu">
        							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>IA Filing </span></a>
        							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
        							     <li class="nav-item"><a href="javascript: void(0);" data-value="edit_ia_details_filing" class="nav-link active">IA Filing</a></li>
        								<li class="nav-item"><a href="javascript: void(0);" data-value="ia_filed_case"  class="nav-link active">Filed Cases</a></li>
										<li class="nav-item"><a href="javascript: void(0);" data-value="ia_draftcase_list"  class="nav-link active">Draft Cases</a></li>
        							</ul>
        						</li>
								<?php endif;?>
							</ul>
						</li>
						
						<!-- <li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Other</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								
							<li class="nav-item"><a href="javascript: void(0);" data-value="document_upload_epcprpia" class="nav-link active">Document upload  </a></li>
							</ul>
						</li> -->
						
							
						<!--li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Fee Detail</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							    <li class="nav-item"><a href="javascript: void(0);" data-value="edit_cetified" class="nav-link active">Cetified Copy</a></li>
								<li class="nav-item"><a href="javascript: void(0);" data-value="cetified_list"  class="nav-link active">Cetified Copy List</a></li>
								<li class="nav-item"><a href="javascript: void(0);" data-value="process_fee"  class="nav-link active">Process Fee</a></li>
							</ul>
						</li-->
						
						
					
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Master</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							    <li class="nav-item"><a href="javascript: void(0);" data-value="master_dash" class="nav-link active">Master Dashboard</a></li>
								<!-- <li class="nav-item"><a href="javascript: void(0);" data-value="change_password"  class="nav-link active">Change Password</a></li>
								<li class="nav-item"><a href="javascript: void(0);" data-value="logout"  class="nav-link active">Logout</a></li> -->
							</ul>
						</li>	
						
						
				        <li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>My Account</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
							    <li class="nav-item"><a href="javascript: void(0);" data-value="myprofile" class="nav-link active">My Profile</a></li>
							    <li class="nav-item"><a href="<?php echo base_url(); ?>editprofile"  class="nav-link active">Edit Profile</a></li>
								<li class="nav-item"><a href="javascript: void(0);" data-value="change_password"  class="nav-link active">Change Password</a></li>
								<li class="nav-item"><a href="javascript: void(0);" data-value="logout"  class="nav-link active">Logout</a></li>
							</ul>
						</li>	
						

						</ul>
				</div>
			</div>	
 		</div>
 		
 		