<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content" style="padding-top:0px;">
	<div class="row">
	<?php 
	   $reffrenceno= $this->session->userdata('reffrenceno');
            $refdetail= $this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$reffrenceno);
            $val= substr($refdetail[0]->filing_no,5);
            $a=substr_replace($val ,"",-4);
            $b= substr($val, -4);
            $val= $a.'/'.$b;
            if(!empty($refdetail) && $refdetail[0]->case_type=='contempt'){
                $partytype=$refdetail[0]->partyType;
                ?>
         
         <script>
$(document).ready(function() {
	diary();
	serchDFR();
	load_app_respodent_contempt_petition('<?php echo $refdetail[0]->partyType ?>');
});
</script>
<?php } ?>

	<input type="hidden" name="saltNo" id="saltNo" value="<?php echo $refdetail[0]->salt; ?>">
                		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">            
                            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'addMasterPaper','autocomplete'=>'off','onsubmit'=>'return upd_master_paper();']) ?>
                                <div class="content clearfix" id="document_filing_div_id">
                                    <?= form_fieldset('<small class="fa fa-upload"></small>&nbsp;&nbsp; Documents Filing '); ?>
                                        <div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group required">
                                                    <label for="name"><span class="custom"><font color="red">*</font></span>DFR No </label>
                                                    <input type="radio" name="appAnddef" onclick="diary();" id="app" value="1" checked="checked">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group required">
                                                    <label for="name"><span class="custom"><font color="red">*</font></span>Case No </label>
                                                    <input type="radio" name="appAnddef" onclick="diary();" id="def" value="2" >
                                                </div>
                                            </div>
                                        </div>
                                        
                                   <div class="row" id="myDIV">
                                        <div class="col-md-3">
                                           <?=  form_label('<small class="fa fa-search"></small>&nbsp;&nbsp;Diary No.','filing_no',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']);?>
                                           <?=  form_input(['name'=>'filing_no','id'=>'filing_no','class'=>'form-control alert-danger','min'=>'1','max'=>'999999','type'=>'number','style'=>'width: 200px;','onkeydown'=>'if(this.value.length > 5) { $.alert(\'Diary no should be less than 6 digit\'); this.value=\'\'; return false; }','placeholder'=>'Diary No.','onchange'=>'filing_year.disabled=false;']);?>
                                        </div>
                                        <div class="col-md-3">
                                           <?= form_label('<small class="fa fa-calendar-alt"></small>&nbsp;&nbsp;Select Year','filing_year',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']);
                                            $year_array=[''=>'-----select Year-----'];
                                            for($i=date('Y'); $i>=(date('Y')-15); $i--) $year_array[$i]=$i;
                                             echo form_dropdown('filing_year',@$year_array,null,['class'=>'form-control','id'=>'filing_year','style'=>'width: 200px;','disabled'=>'true']);?>
                                        </div>

  				<div class="col-md-3">
                                 <div class=" col-md-3" style="margin-top: 29px;">
                        			<input type="submit" name="nextsubmit" value="SEARCH" class="btn btn-success" id="nextsubmit" onclick="validate_diary();">
                                </div>
            			     </div> 	


                                    </div>
                
                               <div class="row" id="myDIV1" style="display: none;">
                        		  <div class="col-md-3">
                                        <div class="form-card">
                                          <div class="form-group">
                                          	<label class="control-label" for="case_type_lower"><span class="custom"><font color="red">*</font></span>Case Type:</label>
                                          	<div class="input-group mb-3 mb-md-0">
                                              <?php
                                              
                                              $query=$this->db->query("select * from master_case_type where case_type_code in ('1','6','7','4')");
                                              $state= $query->result();
                      
                                              
                                              $lowercasetype=$state;
                                              $lowercasetype1=[''=>'- Select Case Type -'];
                                              foreach ($lowercasetype as $val)
                                                  $lowercasetype1[$val->case_type_code] = $val->short_name;  
                                                  echo form_dropdown('case_type',$lowercasetype1,'',['class'=>'form-control','id'=>'case_type','required'=>'true']); 
                                                 ?>
                                          	</div>
                                          </div>
                                     </div>
                                  </div>
                               	  <div class="col-md-3">
                                     <div class="form-group required">
                                         <label for="name"><span class="custom"><font color="red">*</font></span>Case NO: </label> 
                                           <?= form_input(['name'=>'case_no','class'=>'form-control','id'=>'case_no','value'=>'','onkeypress'=>'return isNumberKey(event)','placeholder'=>'Enter Case No.','pattern'=>'[0-9]{1,8}','maxlength'=>'8','title'=>'Case should be numeric only.']) ?>
                                     </div>
                    			  </div>
                    			  <div class="col-md-3">
                                     <div class="form-card">
                                          <div class="form-group">
                                              	<label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Case Year:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                 <?php
                                                 $yearv=$basic[0]->l_case_year;  $yearv=explode('|', $yearv);
                                                 $year = $yearv[0];
                                                 if($year==''){ $year='2020';}
                                                  $year1=[''=>'- Select Year -'];
                                                  for ($i = 2000; $i <= 2050; $i++) {
                                                      $year1[$i]=$i;
                                                  }
                                                  echo form_dropdown('filing_year1',$year1,$year,['class'=>'form-control','id'=>'filing_year1','required'=>'true']); 
                                                 ?>
                                              	</div>
                                          </div>
                                     </div>
                    			  </div>

  <div class="col-md-3">
                             <div class=" col-md-3" style="margin-top: 29px;">
                    			<input type="submit" name="nextsubmit" value="SEARCH" class="btn btn-success" id="nextsubmit" onclick="validate_diary();">
                             </div>
        			      </div> 

                    		</div>
                		<div id="detailsparty">
                		</div>	
            
                        <div class="row party_radio_div d-none" style="margin-top: 15px;border-top:1px solid #ddd;padding-top:8px;">
                            <div class="col-md-4">
                           <?=  form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Applicant','applicant',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']);?>
                           <?=  form_radio(['name'=>'userType','class'=>'form-control','id'=>'applicant','value'=>'1','onclick'=>"showparty('1')",'style'=>'position: absolute; top: 0; margin: 8px -50px;']);?>
                            </div>
                            <div class="col-md-4">
                           <?=   form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Respondant','respondant',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']);?>
                           <?=  form_radio(['name'=>'userType','class'=>'form-control','id'=>'respondant','value'=>'2','onclick'=>"showparty('2')",'style'=>'position: absolute; top: 0; margin: 8px -28px;']);?>
                            </div>
                            <div class="col-md-4">
                            <?=  form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Third Party','third_party',['style'=>'font-size: 18px;font-weight:600;','class'=>'text-success']);?>
                            <?=  form_radio(['name'=>'userType','class'=>'form-control','id'=>'third_party','value'=>'3','onclick'=>"showparty('3')",'style'=>'position: absolute; top: 0; margin: 8px -38px;']);?>
                            </div>
                             <div class="col-sm-12 div-padd" id="dfdfdfdfdfdfdfdf">
                                <div><label for="email"><span class="custom"><span><font color="red"></font></span>Additional Party: </span></label></div>
                           
                                 <div id="additionalparty"></div>
                           
                            <!--  <select onchange="fn_check_valaltanama(this.value)" name="additionla_partyy"
                                    class="select_box" id="additionla_partyy" multiple>
                                    <option value=""> Select Party</option>
                                </select>-->    
                                <div id="div_check_valaltanama"> </div>
                            </div>                    
                        </div>
            
                        <div class="row">  
                             <div class="col-lg-12">  
                                <div id="div_check_valaltanama_ia"> </div>
                                <div class="col-sm-12 div-padd" id="addparty" style="display:none"></div>
                             </div>
                        </div> 
                                    
             <!--third party added start-->
                        <div id="thirdparty_ididid" class="row" style="display:none">
            		 		<fieldset id ="jurisdictionrrrrrr" style="display: block;    width: 101%;">
            				<legend class="customlavelsub">Third Party Details</legend>
            		   		   <div class="col-sm-12 div-padd" id="defView"  style="display: none"></div>
            		   		   <div class="row">
                				   <div class="col-sm-4">
                            	 		<div><label for="name"><span class="custom"><font color="red">*</font></span>Select Organization :</label></div>
                                        <div>
                                            <select name="select_org_app1" class="form-control" id="select_org_app1" onchange="apple_org_details_ia1(this.value)">
                                                <option value="">Select Org Name</option>
                                                <?php
                                                $hscquerytttt =$this->db->query("select * from master_org order by orgdisp_name asc ");
                                                $org= $hscquerytttt->result();
                                                foreach ($org as $row) {
                                                    ?>
                                                    <option value="<?php echo htmlspecialchars($row->org_id); ?>"><?php echo htmlspecialchars($row->orgdisp_name); ?></option>
                                                    <?php }  ?>
                                            </select>
                                        </div>
                        	       </div>
                    	      </div>
                    	      <div class="row">
                                      <div class="col-lg-4">
                                         <div><label for="name"><span class="custom"><font color="red">*</font></span>Party Name:</label></div>
                                         <div><input type="text" name="petName1" id="petName1" class="form-control" /></div>
                                       </div>
                                       <div class="col-lg-4">
                                         <div><label for="exampleInputName2"><span class="custom">Designation:</span></label> </div>  
                                         <div><input type="text" name="degingnation1" value="<?php echo htmlspecialchars( $degingnation);?>" id="degingnation1" class="form-control" /></div>
                                       </div>
                                       <div class="col-lg-4">
                                         <div><label for="exampleInputName2"><span class="custom"> Address Of Appeliant:</span></label></div>
                                     	 <div id="collegeTypeId"></div><textarea name="petAddress1" id="petAddress1" class="form-control" cols="25"><?php echo htmlspecialchars( $petAddress);?></textarea>
                                       </div>
                               </div>
            
                                <div class="row">
                                        <div class="col-lg-4">
                                           <div><label for="name"><span class="custom"><span><font color="red">*</font></span>State Name :</span></label></div>
                                           <div>
                                        		<select name="dstate1" class="form-control" id="dstate1" onchange="showCity(this);">
                                        		<option selected="selected">Select State Name</option>
                                        		<?php
                                        		$hscquery = $this->db->query("select state_name,state_code from master_psstatus"); 
                                        		$vl=$hscquery->result();
                                        		foreach ($vl as $row){ ?>
                                        			<option value="<?php echo htmlspecialchars($row->state_code);?>"><?php echo htmlspecialchars($row->state_name);?></option>
                                         		<?php } ?>
                                        		</select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">   
                                          	<div><label for="ddistrict"><span class="custom"><span><font color="red">*</font></span>District:</span></label></div>
                                            <div>
                                                <select name="ddistrict1" class="form-control" id="ddistrict1">
                                                <option selected="selected">Select District Name</option>
                                            	</select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">   
                                        	<div><label for="pincode"><span class="custom">Pincode:</span></label></div>
                                        	<div><input type="text" name="pincode1" value="<?php echo htmlspecialchars( isset($pinCode)?$pinCode:'');?>" id="pincode1" class="form-control" onkeypress="return isNumberKey(event)"maxlength="6" /></div>  
                                        </div>
                                 </div>
            
                                  <div class="row"> 
                                      <div class="col-lg-4">    
                                        <div><label for="mobile"><span class="custom"><span><font color="red"></font></span>Mobile Number: </span></label></div>
                                        <div><input type="text" name="petmobile1" id="petmobile1" class="form-control"  onkeypress="return isNumberKey(event)"maxlength="10" value=""/></div> 
                                      </div> 
                                      <div class="col-lg-4">  
                                        <div><label for="phone"><span class="custom">Phone Number:</span></label></div>
                                        <div id="phone"><input type="text" name="petPhone1" id="petPhone1" class="form-control" maxlength="11"  value="<?php echo htmlspecialchars( isset($petPhone)?$petPhone:''); ?>" onkeypress="return isNumberKey(event)"/></div>
                                      </div> 
                                      <div class="col-lg-4"> 
                                        <div> <label for="email"><span class="custom"><span><font color="red"></font></span>Email ID:</span></label></div>
                                    	<div><input type="text" name="petEmail1" id="petEmail1" class="form-control" value="" /></div>
                                      </div>
                                      <div class="col-lg-4"> 	
                                    	<div> <label for="email"><span class="custom"><span><font color="red"></font></span>Fax No:</span></label></div>
                                    	<div><input type="text" name="petFax1" id="petFax1" class="form-control" value="" maxlength="11"  onkeypress="return isNumberKey(event)"/></div>
                                      </div>
                                  </div>   
                          </fieldset>
                      </div>    
                     <!--third party added end-->
                     
                     
                    <div class="row additional_party_table d-none" style="margin-top: 20px;">
                        <div class="col-md-12 table-responsive">
                            <span class="btn btn-warning btn-sm disabled" style="margin-bottom: 12px;"><i class="fa fa-users"></i>&nbsp;&nbsp;Additional Party(s)&nbsp;&nbsp;<i class="fa fa-arrow-down"></i></span>
                            <table class="table table-sm table-bordered table-striped w-100">
                                    <thead>
                                        <tr class="font-weight-bold">
                                            <th>#</th>
                                            <th>PARTY NAME</th>
                                            <th>VAKALATNAMA (YES/NO)</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                      
               
                
                
                    <div class="row">
                        <div class="col-md-12">
                           <?=  form_fieldset('<small class="fa fa-upload"></small>&nbsp;&nbsp;Paper Details',['style'=>'margin-top: 16px;','id'=>'paper_details_fieldset','class'=>'d-none']); ?>
                               <div class="row">
                                <div class="col-md-4">
                                     <?=   form_label('<small class="fa fa-text"></small>&nbsp;&nbsp;Paper Master&nbsp;<sup class="fa fa-star text-danger"></sup>','paper_master',['class'=>'text-success font-weight-bold']);
                                    $paper_master_array=[''=>'-----Choose paper type-----'];
                                    $paper_master_rs= $this->db->query("select * from master_document where did NOT IN ('17','18','19','20','21','22')");
                                    $paper_master_rs= $paper_master_rs->result();
                                    foreach($paper_master_rs as $data) :;
                                        $paper_master_array[$data->pay.' '.$data->did]=$data->d_name;
                                    endforeach;
                                    echo form_dropdown('paper_master',$paper_master_array,null,['class'=>'form-control','id'=>'paper_master','onchange'=>'paperDetails(this.value);','required'=>'true']);?>
                                </div>
                            </div>  
                          
                            <div class="row">
                                <div class="col-lg-4" style="display: none" id="maID1">
                                    <div><label for="phone"><span class="custom"> <font color="red">*</font>Total No Of Annexure : </span></label></div>
                                    <div id="phone"><input type="text" name="totalNoAnnexure"  id="totalNoAnnexure" class="form-control" maxlength="3" value=" "  onkeyup="paperDetails1();";  onkeypress="return isNumberKey(event)" /></div>
                                </div>
                           </div>
                           
                            <div class="row" style="margin-top:15px;">
                                <div class="col-md-12">
                                      <?=  form_label('<small class="fa fa-pencil-alt"></small>&nbsp;&nbsp;Matter','matter',['class'=>'text-success font-weight-bold']);?>
                                      <?= form_textarea(['name'=>'matter','id'=>'matter','rows'=>'2','cols'=>'20','class'=>'form-control','placeholder'=>'Enter matter']);?>
                                </div>
                            </div>

                          <div class="col-sm-12 div-padd" style="display: none" id="vakalatnama">
                             <div class="row form-group">
                                 <div class="col-md-4">
                                 <?=   form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;Counsel Name&nbsp;&nbsp;<sup class="fa fa-star text-danger"></sup>','council_name');
                                     $rs=$this->admin_model->_get_data('master_advocate');
                                     $data_array=[''=>'Select Caunsel'];
                                     foreach ($rs as $org_row) $data_array[$org_row->adv_code]=$org_row->adv_name;
                                     echo form_dropdown('councilCode',$data_array,'',['class'=>'form-control','id'=>'councilCode','onchange'=>'get_adv_data(this);','required'=>'true']);?>
                                 </div>
                                 <div class="col-md-4">
                                 <?=   form_label('<small class="fa fa-user"></small>&nbsp;&nbsp;State&nbsp;&nbsp;<sup class="fa fa-star text-danger"></sup>','Council State');
                                     $rs=$this->admin_model->_get_data('master_psstatus');
                                     $data_array=[''=>'Select state'];
                                     foreach ($rs as $org_row) $data_array[$org_row->state_code]=$org_row->state_name;
                                     echo form_dropdown('dstate',$data_array,'',['class'=>'form-control','id'=>'dstate','onchange'=>'get_adv_data(this);','disabled'=>'true','required'=>'true']);?>
                                 </div>
                                 <div class="col-md-4">
                                   <?=  form_label('<mall class="fa fa-mobile"></small>&nbsp;&nbsp;Counsel Mobile No<sup class="fa fa-star text-danger">','council_mobile');?>
                                   <?=  form_input(['name'=>'counselMobile','id'=>'counselMobile','title'=>'Enter valid mobile no (10 digit only)','class'=>'form-control','placeholder'=>'Enter 10 digit mobile no.','pattern'=>'[0-9]{10,10}','maxlength'=>'10','required'=>'true','disabled'=>'true']);?>
                                 </div>
                             </div>
                             <div class="row form-group">
                                  <div class="col-md-4">
                                   <?=  form_label('<mall class="fa fa-envelope"></small>&nbsp;&nbsp;Counsel Email Id','council_email');?>
                                   <?=  form_input(['name'=>'counselEmail','id'=>'counselEmail','type'=>'email','title'=>'Enter valid email id','class'=>'form-control','placeholder'=>'Counsel email id','disabled'=>'true']);?>
                                  </div>
                                  <div class="col-md-4">
                                   <?=  form_label('<mall class="fa fa-phone"></small>&nbsp;&nbsp;Counsel Phone No','council_phone');?>
                                   <?=  form_input(['name'=>'counselPhone','id'=>'counselPhone','title'=>'Enter valid counsel phone no. (Number & space only)','class'=>'form-control','placeholder'=>'Counsel phone no','pattern'=>'[0-9 ]{0,20}','maxlength'=>'20','disabled'=>'true']);?>
                                  </div>
                                  
                                   <div class="col-md-4">
                                  <?=   form_label('<small class="fa fa-location-arrow"></small>&nbsp;&nbsp;Counsel Address','council_address');?>
                                  <?=   form_textarea(['name'=>'counselAdd','id'=>'counselAdd','class'=>'form-control','pattern'=>'[-\/&_.A-Za-z0-9 ]{4,200}','maxlength'=>'150','placeholder'=>'Counsel Address','rows'=>'1','cols'=>'20','disabled'=>'true']);?>
                                  </div>
                             </div>
                             <div class="row form-group">
                                  <div class="col-md-4">
                                   <?=  form_label('<mall class="fa fa-envelope"></small>&nbsp;&nbsp;Counsel Pin','counselPin');?>
                                   <?=  form_input(['name'=>'counselPin','type'=>'email','id'=>'counselPin','title'=>'Enter valid email id','class'=>'form-control','placeholder'=>'Counsel Pin','disabled'=>'true']);?>
                                  </div>
                                  
                                  <div class="col-md-4">
                                  <input type="hidden" name="ddistrict" id="ddistrict">
                                   <?=  form_label('<mall class="fa fa-phone"></small>&nbsp;&nbsp;District','ddistrict');?>
                                   <?=  form_input(['name'=>'ddistrictname','id'=>'ddistrictname','class'=>'form-control','maxlength'=>'20','disabled'=>'true']);?>
                                  </div>
                                  
                                   <div class="col-md-4">
                                  <?=   form_label('<small class="fa fa-location-arrow"></small>&nbsp;&nbsp;Counsel Fax','counselFax');?>
                                  <?=   form_input(['name'=>'counselFax','class'=>'form-control','id'=>'counselFax','disabled'=>'true']);?>
                                  </div>
                             </div>
                             
                             <input type="button" name="nextsubmit" id="nextsubmit" value="Add More Counsel" class="btn1" onclick="addMoreAppdoc();">
                             <div id="advlisting"></div>
                          </div>   

                           <div  class="row">  
                                <div  id="iaNatuer" class="col-lg-12"  style="display: none">
                                    <div  class="row">  
                                     	<div class="col-md-4">
                                            <div><label for="phone"><span class="custom"><font color="red">*</font>Total No Of Annexure:</span></label> </div>
                                            <div id="phone"><input type="text" name="totalNoAnnexure1"  id="totalNoAnnexure1" onkeyup="paperDetails1();"; class="form-control" maxlength="3" value=" " onkeypress="return isNumberKey(event)" /></div>
                                    	</div>
                                        <div class="col-md-4">
                                        <?=  form_label('<small class="fa fa-text"></small>&nbsp;&nbsp;IA Nature Name&nbsp;<sup class="fa fa-star text-danger"></sup>','ia_nature_name',['class'=>'text-success font-weight-bold']);
                                            $paper_master_array=[''=>'-----Choose IA Nature Name-----'];
                                            $paper_master_rs=$this->admin_model->_get_data('master_document_with_IAO');
                                            foreach($paper_master_rs as $data) :;
                                                $paper_master_array[$data->did]=$data->d_name;
                                            endforeach;
                                            echo form_dropdown('ia_nature_name',$paper_master_array,null,['class'=>'form-control','required'=>'true']);?> 
                                        </div>
                                     </div>
                                 </div>
                           </div>
             
                    </div>
                </div>
                
                 <div class="col-md-12" id="documentUpload" style="display: none">
                      <?=  form_fieldset('<small class="fa fa-upload"></small>&nbsp;&nbsp;Document upload',['style'=>'margin-top: 16px;']); ?>  
                    	 <div class="row">		
                              <div class="col-md-12">
                                    <div class="row">
                                           <div class="col-md-3">
                                             <label class="control-label" for="fullappeal"><span class="custom"><font color="red">*</font></span>Compleate PDF Formate:</label>
                                           </div>
                                            <div class="col-md-6">
                                                 <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                 <?=form_upload(['id'=>'fIlingDoc','name'=>'files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                 </div>
                                           </div>
                                     </div> 
                                      <div class="row" id="wordformate">
                                           <div class="col-md-3">
                                             <label class="control-label" for="ia_files"><span class="custom"><font color="red">*</font></span>Word Formate:</label>
                                           </div>
                                            <div class="col-md-6">
                                                 <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                 <?=form_upload(['id'=>'ia_files','name'=>'ia_files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                 </div>
                                           </div>
                                     </div>
                                     <div class="row" id="recept" style="display: none">
                                           <div class="col-md-3">
                                             <label class="control-label" for="r_files"><span class="custom"><font color="red">*</font></span>Online Payment Receipt:</label>
                                           </div>
                                            <div class="col-md-6">
                                                 <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                 <?=form_upload(['id'=>'r_files','name'=>'r_files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                 </div>
                                           </div>
                                     </div>
                                 </div>
                         	</div>
                      <?= form_close(); ?>
                    	
                    	 
                     </div> 
                     <div class="col-sm-12 div-padd" style="display: none" id="maPay">
                    	   <?=  form_fieldset('<small class="fa fa-upload"></small>&nbsp;&nbsp;Payment Mode',['style'=>'margin-top: 16px;']); ?>   
                                <div class="col-sm-6 div-padd">
                                    <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Payment Mode</span></label></div>
                                    <div>
                                        <label for="name">
                                        	<span class="custom">
                                                Online Payment<input type="radio" name="bd" id="partial" value="3" onclick="paymentMode(3);" />
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>               
                           <div class="col-sm-12 div-padd" id="payMode" style="display: none">
                           </div> 
                            <div class="col-sm-12 div-padd" id="add_amount_list" >
                           </div> 
                           
                           
                              <div class="col-sm-6 div-padd" style="margin-left:800px;display: none" id="other"><div>
                             	<input type="button" name="btnSubmit" id="btnSubmit"  value="Save" class="btn btn-info"  onclick="maActionOth();" /></div>
                            </div> 
                        <?= form_fieldset_close(); ?> 
                        
                        
          <?= form_fieldset_close(); ?>
        </div>         
        <div id="document_filing_div_id_text_print">
        </div>
	</div>
	
	                      
                         
</div>
  <?= form_close(); ?>

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
                
 <?php $this->load->view("admin/footer"); ?>                
<script>
function maActionOth() {
    var filingOn = document.getElementById("filing_no").value;
    var radios1 = document.getElementsByName("userType");
    var partyType1 = 0;
    for (var i = 0; i < radios1.length; i++) {
        if (radios1[i].checked) {
            partyType1 = radios1[i].value;
        }
    }
   if(partyType1==''){
 	alert("Please select Type ");
        document.additionla_partyy.focus();
        return false;
    }

    var partyType1 = $('input[name=userType]:checked').val();
    console.log(partyType1);
    var checkboxes1 = document.getElementsByName('additionla_partyy');
    var patyAddId = "";
    var count1 = 0;
    var selected = [];
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
        	patyAddId = patyAddId + checkboxes1[i].value + ',';
            count1++;
        }
    }
    if(partyType1!='3'){
        if(patyAddId==''){
       	     alert("Please additional party");
            document.additionla_partyy.focus();
            return false;
        }
    }
    var matter = $("#matter").val();
    if(partyType1=='3'){ 
    	var select_org_app = document.getElementById('select_org_app1').value;
    	if(select_org_app==''){
    		alert("Select Organization.");
    		return false;
        }
        var petName = document.getElementById('petName1').value;
        var dstate = document.getElementById('dstate1').value;
        var petmobile = document.getElementById('petmobile1').value;
        var degingnation = document.getElementById('degingnation1').value;
        var ddistrict = document.getElementById('ddistrict1').value;
        var petPhone = document.getElementById('petPhone1').value;
        var petAddress = document.getElementById('petAddress1').value;
        var pincode = document.getElementById('pincode1').value;
        var petEmail	 = document.getElementById('petEmail1').value;
        var petFax = document.getElementById('petFax1').value;
   }
   if (patyAddId == null) {
        alert('pleae select Additional Party');
   } else {
        var paper1 = document.getElementById("paper_master").value;
        var ar1 = paper1.split(" ");
        var paper2 = ar1[0];
        var pid = ar1[1];
        var matter_descri = $("#matter").val();
      	var dataa={};
		dataa['matter']=matter_descri, 
		dataa['filingNo']=filingOn,
		dataa['type']=partyType1,
		dataa['select_org_app']=select_org_app,  
		dataa['petName']=petName,  
		dataa['dstate']=dstate, 
		dataa['petmobile']=petmobile, 
 		dataa['degingnation']=degingnation, 
  		dataa['ddistrict']=ddistrict,
 		dataa['petPhone']=petPhone,
  		dataa['petAddress']=petAddress,
  		dataa['pincode']=pincode, 
 		dataa['petEmail']=petEmail, 
 		dataa['petFax']=petFax,
 		dataa['addparty']=patyAddId,
		dataa['paper2']=paper2,
		dataa['pid']=pid,
        $.ajax({
        	dataType: 'json',
    		type: 'post',
    		url: base_url+'ma_action',
    		data: dataa,
    		success: function(retrn){
    			if(retrn.data='success'){
    				$("#document_filing_div_id").empty();
    			    $("#annId").empty();
    			    $("#document_filing_div_id_text_print").html(retrn.display);
    			}
    			if(retrn.data='error'){
    				$("#document_filing_div_id_text_print").html(retrn.error);
    			}
    		},
    		error: function(){
    			$.alert('Server busy, try later.');
    		},
    		complete: function(){
    			  document.getElementById("payMode").style.display = 'block';					
    		}
    	});
    }
}


function popitup(matter,ptype,addparty,mano,type,filingno,fee,doc,year){
     var dataa={};
     dataa['matter']=matter,
     dataa['ptype']=ptype,
     dataa['addparty']=addparty,
     dataa['mano']=mano,
     dataa['type']=type,
     dataa['filingno']=filingno,
     dataa['fee']=fee,
     dataa['doc']=doc,
     dataa['year']=year,
     $.ajax({
          type: "POST",
          url: base_url+"/filingaction/maprint",
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

function paymentMode(value) {
    var paper1 = $("#paper_master").val();
    var ar1 = paper1.split(" ");
    var paper2 = ar1[0];
    var pid = ar1[1];
    if (ar1[0] == 'ma') {
        var totalNoAnnexure = $("#totalNoAnnexure").val();
        if (totalNoAnnexure == "") {
            alert("Please Enter Total No Annexure");
            document.filing.totalNoAnnexure.focus();
            return false;
        }
    }
    if (ar1[0] == 'IA') {
        var totalNoAnnexure = $("#totalNoAnnexure1").val();
        if (totalNoAnnexure == "") {
            alert("Please Enter Total No Annexure");
            document.filing.totalNoAnnexure1.focus();
            return false;
        }
    }

	var dataa={};
    dataa['app']=value;
    dataa['paper1']=paper2;
    dataa['totalA']=totalNoAnnexure;
    dataa['pid']=pid;
	$.ajax({
    		type: 'post',
    		url: base_url+'filingaction/postalOrderOthrer',
    		data: dataa,
    		success: function(retrn){
    			if(retrn){
    				document.getElementById("payMode").innerHTML = retrn;
    			}
    			
    		},
    		error: function(){
    			$.alert('Server busy, try later.');
    		},
    		complete: function(){
    			  document.getElementById("payMode").style.display = 'block';					
    		}
    });
}




function validate_diary() {
	var salt = document.getElementById("saltNo").value;
	if(salt==''){
        var salt = Math.ceil(Math.random() * 100000);
        document.getElementById("saltNo").value = salt;
        }
	var bd = $('input[name=appAnddef]:checked').val();
	var filing_no= document.getElementById("filing_no").value;
	var year=document.getElementById("filing_year").value; 
	if(bd=='1'){
    	  if(filing_no==''){
    		alert("Please Enter Filing number");
    		return false;
    	  }
    	  if(year==''){
    		alert("Please select Year");
    		return false;
    	   }
	}

	var case_type=document.getElementById("case_type").value;
	var case_no=document.getElementById("case_no").value; 
	if(year==''){
	 var year=document.getElementById("filing_year1").value;
	}

       if(bd=='2'){
    	   if(case_no==''){
    		alert("Please Enter case number");
    		return false;
    	   }
    	  if(case_type==''){
    		alert("Please select case type");
    		return false;
    	   }
	}


	if(year){
	var dataa={};
        dataa['type']=bd;
        dataa['case_no']=case_no;
        dataa['year']=year;
        dataa['case_type']=case_type;
        dataa['filing_no']=filing_no;
        dataa['dfr_year']=year;
		$.ajax({
				type: 'post',
				url: base_url+'filingaction/findrecord',
				data: dataa,
				dataType: 'json',
				beforeSend: function(){
					$('#loading_modal').modal(), $('.party_radio_div').addClass('d-none'), 
					$('.additional_party_table').addClass('d-none').find('tbody').empty();
					//$('#paper_details_fieldset').addClass('d-none');
					$('#applicant, #respondant, #third_party').prop('checked',false);
					$('.ia_fee_div, .pmode, .ia_nature_div').addClass('d-none');
					$('input[name=payment_mode]').prop('checked',false);
					$('#paper_details_fieldset').removeClass('d-none');
					$('select[name=ia_nature_name]').attr('disabled',true);
				},
				success: function(retrn){
					if(retrn.data){
						document.getElementById("filing_no").value=retrn.data;
						$('#detailsparty').html(retrn.display);
						$('.party_radio_div').removeClass('d-none');
					}
					else if(retrn.error=='Record Not Found'){
						$.alert('Record not found, kindly enter valid details');
						$('input[name="filing_no"]').val("");
						$('select[name="filing_year"]').val("").attr('disabled',true);
					}
					else $.alert(retrn.data);
				},
				error: function(){
					$.alert('Server busy, try later.');
					$('#loading_modal, .modal-backdrop').removeClass('show').addClass('d-none');
					$('body').removeAttr('style class');
				},
				complete: function(){
					$('#loading_modal, .modal-backdrop').removeClass('show').addClass('d-none');
					$('body').removeAttr('style class');					
				}
		});
	}else {
		$.alert('Diary no & year are mandatory.');
	}
}


function additional_party(pf_id) {
	var party_flag=''; party_flag=$(pf_id).val(); $('#applicant, #respondant, #third_party').removeAttr('checked');
		$(pf_id).attr('checked',true);

	if(party_flag != ''){
		var filing_no='';
		    filing_no=$('input[name=filing_no]').val(), filing_year=$('select[name=filing_year] option:selected').val();

		$.ajax({
				type: "post",
				url: base_url+"docupd_addvparty",
				data: {'filing_no': filing_no, 'filing_year': filing_year,'party_flag': party_flag},
				cache: false,
				dataType: 'json',
				beforeSend: function(){
					$('#loading_modal').modal(), $('.additional_party_table').addClass('d-none').find('tbody').empty();
				},
				success: function(retrn){
					if(retrn.error=='0'){
						var count=1;
						$('.additional_party_table').removeClass('d-none');
						$.each(retrn.data,function(index,itemData){
							var vkltn='YES';
							if(itemData.vakalatnama_no==null || itemData.vakalatnama_no=='' || itemData.vakalatnama_no=='null')
								var vkltn='NO';
							$('.additional_party_table').find('tbody').append('<tr><td>'+count+'</td><td>'+itemData.pet_name+'</td><td>'+vkltn+'</td>');
							count++;
						});
					}
					else {
						$.alert(retrn.error);
					}
				},
				error: function(){
					$.alert('Server busy, try later.');
					$('#loading_modal, .modal-backdrop').removeClass('show').addClass('d-none');
					$('body').removeAttr('style class');
				},
				complete: function(){
					$('#loading_modal, .modal-backdrop').removeClass('show').addClass('d-none');
					$('body').removeAttr('style class');
					$('#paper_details_fieldset').removeClass('d-none');					
				}
		});
	}
}


function diary(){
	 var radio =  $('input:radio[name=appAnddef]:checked').val();
	 if(radio=='1'){		      
		 $("#myDIV").show();
		 $("#myDIV1").hide();  	
	  	 document.getElementById("case_no").value='';
	  	// document.getElementById("year").value='';
	  	 document.getElementById("case_type").value='';
	 } 
	 if(radio=='2'){		        	
		  $("#myDIV" ).hide();
		  $("#myDIV1" ).show();  	 
		  document.getElementById("dfr_no").value='';
		//  document.getElementById("dfryear").value='';
	} 
}



function showparty(radio_selected, filing_no) {
	$("#thirdparty_ididid").hide();
	$("#dfdfdfdfdfdfdfdf").show();
	if(radio_selected=='3'){
		$("#thirdparty_ididid").show();
    	 $("#dfdfdfdfdfdfdfdf").hide();
	}
    var faling_no = $("#filing_no").val();
    $.ajax({
        type: "POST",
        url: base_url+"dropdown_party_details",
        data: {'radio_selected': radio_selected, 'faling_no': faling_no},
        cache: false,
        success: function(districtdata) {
            console.log(districtdata);
            $("#additionalparty").html(districtdata);
        }
    });
}


function apple_org_details_ia1(str){
    if (str == "") {
        $("#petName1").val('');
        $("#petAddress1").val('');
        $("#petmobile1").val('');
        $("#petEmail1").val('');
        $("#petPhone1").val('');
        $("#pincode1").val('');
        $("#petFax1").val('');
        $("#dstate1").val('');
        $("#petstatename1").val('');
        $("#ddistrict1").val('');
        $("#petdistrictname1").val('');
        $("#degingnation1").val('');
        document.getElementById("petdistrictname1").value = "";
        document.getElementById("degingnation1").value = "";
        document.getElementById("petName1").value = "";
        document.getElementById("petAddress1").value = "";
        document.getElementById("petmobile1").value = "";
        document.getElementById("petEmail1").value = "";
        document.getElementById("petPhone1").value = "";
        document.getElementById("pincode1").value = "";
        document.getElementById("petFax1").value = "";
        document.getElementById("dstate1").value = "";
        document.getElementById("petstatename1").value = "";
        document.getElementById("ddistrict1").value = "";
        document.getElementById("dcode1").value = "";
    }
       var dataa={};
       dataa['q']=str,
        $.ajax({
            type: "POST",
            url: base_url+'org',
            data: dataa,
            cache: false,
            success: function (petSection) {
          	  var data1 = petSection;
             console.log(data1);
             var data2 = JSON.parse(data1);
                if (str != 0) {
                    showCity1(data2[0].stcode, data2[0].dcode);
                    $("#petName1").val(data2[0].org_name);
                    $("#petAddress1").val(data2[0].address);
                    $("#petmobile1").val(data2[0].mob);
                    $("#petEmail1").val(data2[0].mail);
                    $("#petPhone1").val(data2[0].ph);
                    $("#pincode1").val(data2[0].pin);
                    $("#petFax1").val(data2[0].fax);
                    $("#dstate1").val(data2[0].stcode);
                    $("#petstatename1").val(data2[0].stname);
                    $("#ddistrict1").val(data2[0].dcode);
                    $("#petdistrictname1").val(data2[0].dname);
                    $("#degingnation1").val(data2[0].desg); 
                } 
            },
            error: function (request, error) {
				$('#loading_modal').fadeOut(200);
            }
        });   
}


function showCity1(state_id, city_id) {
  if (state_id.length > 0) {
      $.ajax({
          type: "POST",
          url:  base_url+"district",
          data: "state_id=" + state_id,
          cache: false,
          success: function(districtdata) {
              $("#ddistrict1").html(districtdata);
              $("#ddistrict1").val(city_id);
          }
      });
  }
}


function showCity(state_id, city_id) {
	  if (state_id.length > 0) {
	      $.ajax({
	          type: "POST",
	          url:  base_url+"district",
	          data: "state_id=" + state_id,
	          cache: false,
	          success: function(districtdata) {
	              $("#ddistrict1").html(districtdata);
	              $("#ddistrict1").val(city_id);
	          }
	      });
	  }
	}
	



function fn_check_valaltanama(str_str) {

    var checkboxes1 = document.getElementsByName('additionla_partyy');
    var party_id = [];
    var count1 = 0;
    var selected = [];
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
        	party_id = party_id + checkboxes1[i].value + ',';
            count1++;
        }
    }
    
    var filing_no = $("#filing_no").val();
    var partyType = $('input[name=appAnddef1]:checked').val();
    var data = {};
    data['action'] = "check_valaltanama";
    data['party_id'] = party_id;
    data['filing_no'] = filing_no;
    data['partyType'] = partyType;
    $.ajax({
        type: "POST",
        url: base_url+"/filingaction/check_valaltanama",
        data: data,
        dataType: "html",
        success: function(data) {
            $("#div_check_valaltanama_ia").html(data);
           
        },
        error: function(request, error) {
            $("#div_check_valaltanama_ia").html(data);
        }
    });
}


function paperDetails1(){
	  var paper = document.getElementById("paper_master").value;
	   var totalNoAnnexure = $("#totalNoAnnexure").val();
       if (totalNoAnnexure == "") {
           alert("Please Enter Total No Annexure");
           document.filing.totalNoAnnexure1.focus();
           return false;
       }
       alert(totalNoAnnexure);
	    var ar = paper.split(" ");
	    if (ar[0] == 'ma') {
		    if(totalNoAnnexure==0){
    	        $("#maPay").hide();
    	        $("#recept").show();
    	    	$("#other").show();
    	        return false;
		    }else{
		    	$("#maPay").show();
		    	$("#other").hide();
		    	return true;
			}
	    }
}


function paperDetails() {
    var paper = document.getElementById("paper_master").value;
    var ar = paper.split(" ");
    if (ar[0] == 'ma') {
        document.getElementById("maID1").style.display = 'block';
        document.getElementById("maPay").style.display = 'block';
        document.getElementById("payMode").style.display = 'none';
        document.getElementById("vakalatnama").style.display = 'none';
        document.getElementById("other").style.display = 'none';
        $("#documentUpload").show();
        $("#recept").show();
    }

    if (ar[0] == 'va') {
        document.getElementById("maID1").style.display = 'none';
        document.getElementById("vakalatnama").style.display = 'block';
        document.getElementById("maPay").style.display = 'block';
        document.getElementById("payMode").style.display = 'none';
        document.getElementById("other").style.display = 'none';
        $("#documentUpload").show();
        $("#recept").show();
    }
    if (ar[0] == 'oth') {
        document.getElementById("other").style.display = 'block';
        document.getElementById("maID1").style.display = 'none';
        document.getElementById("vakalatnama").style.display = 'none';
        document.getElementById("maPay").style.display = 'none';
        document.getElementById("payMode").style.display = 'none';
        $("#documentUpload").show();
        $("#recept").hide();
        $("#wordformate").hide();
    }
    if(paper=='oth 24' || paper=='oth 25'){
    	 $("#documentUpload").show();
    	 $("#recept").show();
    }

}



function addMoreAppdoc() {
    var salt = $("#filing_no").val();
    var bd = $('input[name=userType]:checked').val();
    var partyN = new Array();
    var x = document.getElementById("additionla_partyy");
    var j = 0;
    for (var i = 0; i < x.length; i++) {
        if (x[i].checked) {
        	 partyN[j] = party_id + x[i].value + ',';
        	  j++;
        }
    }

    var checkboxes1 = document.getElementsByName('additionla_partyy');
    var partyN = new Array();
    var j = 0;
    var count1 = 0;
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
         partyN[j] =checkboxes1[i].value;
         j++;
        }
    } 
    if(partyN.length==0){
         alert("Please Cheack party name !");
        document.additionla_partyy.focus();
        return false;
    }

    var counselAdd = $("#counselAdd").val();
    var counselMobile = $("#counselMobile").val();
    var counselEmail = $("#counselEmail").val();
    var counselPhone = $("#counselPhone").val();
    var counselPin = $("#counselPin").val();
    var counselFax = $("#counselFax").val();
    var state = $("#dstate").val();
    var dist = $("#ddistrict").val();
    var councilCode = $("#councilCode").val();
    if (councilCode == "" || councilCode == 'Select Council Name') {
        alert("Please Select Council Name!");
        document.filing.councilCode.focus();
        return false;
    }
    if (state == "" || state == 'Select State Name') {
        alert("Please Select State!");
        document.filing.dstate.focus();
        return false;
    }
     var data = {};
     data['cadd'] =counselAdd,
     data['cpin'] =counselPin,
	 data['cmob'] =counselMobile,
	 data['cemail'] =counselEmail,
	 data['cfax'] = counselFax,
	 data['salt'] =salt,
	 data['counselpho'] =counselPhone,
	 data['st'] =state,
	 data['dist'] =dist,
	 data['councilCode'] =councilCode,
	 data['bd'] =bd,
	 data['pcode'] =partyN,
	 $.ajax({
        type: "POST",
        url: base_url+"/filingaction/additionalAdvocate_action_new",
        data: data,
        dataType: "html",
        success: function(data) {
            $("#advlisting").html(data);
            document.getElementById("advlisting").style.display = 'block';
            document.getElementById("partyName").value = "Select Party Name";
            document.getElementById("dstate").value = "Select State Name";
            document.getElementById("ddistrict").value = "Select District Name";
            document.getElementById("counselAdd").value = "";
            document.getElementById("counselPin").value = "";
            document.getElementById("counselMobile").value = "";
            document.getElementById("counselPhone").value = "";
            document.getElementById("counselEmail").value = "";
            document.getElementById("counselFax").value = "";
            document.getElementById("councilCode").value = "Select Council Name";
            document.getElementById("ddistrictname").value = "";
            document.getElementById("dstatename").value = "";  
        },
        error: function(request, error) {
            $("#div_check_valaltanama_ia").html(data);
        }
    });
}

function deletePay(e, s) {
    var payid = e;
    var salt = $("#filing_no").val();
    var bd = $('input[name=userType]:checked').val();
    var data = {};
    data['salt'] =salt,
    data['ptype'] =bd,
	data['payid'] =payid,
    $.ajax({
        type: "POST",
        url: base_url+"/filingaction/delete_additional_advocate",
        data: data,
        dataType: "html",
        success: function(data) {
            $("#advlisting").html(data);
        },
        error: function(request, error) {
            $("#div_check_valaltanama_ia").html(data);
        }
    });
}



</script>