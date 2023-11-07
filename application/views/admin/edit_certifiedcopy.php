
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
            <?= form_fieldset('<small class="fa fa-upload"></small>&nbsp;&nbsp; Cetified Copy '); ?>
                <div class="date-div text-success">Date & Time : &nbsp;<small><?php echo date('D M d, Y H:i:s'); ?>&nbsp;IST</small></div>
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
                    <div class="col-sm-6 div-padd" id="dfdfdfdfdfdfdfdf">
                          <div><label for="email"><span class="custom"><span><font color="red"></font></span>Additional Party: </span></label></div>
                          <div id="additionalparty"></div> 
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
                                    foreach ($org as $row) { ?>
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
                <div style="display:none" id="matter">
                     <div class="row">
                          <div class="col-lg-6" >
                				 <div><label for="name"><span class="custom"><font color="red">*</font></span>Matter</label></div>
                				 <div>
                					<select name="matterId" class="form-control" id="matterId" onchange="opendiv();">
                						<option value="" selected="selected">Select Matter</option>
                						<option value="1">Apply of Certified Copy of Order/Judgment</option>
                						<option value="2">Apply of Certified Copy of Appeal Book</option>
                					</select>
                				</div>
                		  </div>
                		  <div class="col-lg-6">
    						<div style="margin-top: 30px;">
    							<label for="name"><span class="custom"></span></label>
        						<button type="button" onclick="addMore();" class="btn btn-success">Add More</button>
    						</div>
    					  </div> 
    				</div> 
    				
    				<input type="hidden" name="cnt" id="cnt" value="1">
					<!-----Section One-------->
					<div id="orderId" style="display: none">
					<div id="error_div"></div>
					    <div class="col-lg-12">
        					<div class="row" >
        						<div class="col-lg-3">
        							<div><label for="dtoforder"><span class="custom"><font color="red">*</font>Date Of Order:</span></label></div>
        							<div><input  type="text"  name="dtoforder[]"  id="dtoforder0" class="form-control form-control datepicker" maxlength="12" value=""  onkeypress="return isNumberKey(event)" autocomplete="off"/></div>
        						</div>
        						<div class="col-lg-3">
        							<div><label for="nopage"><span class="custom"><font color="red">*</font>No  Of Pages:</span></label></div>
        							<div><input type="text" name="nopage[]" id="nopage0" class="form-control" maxlength="4" value="" onkeyup="calculate();"  onkeypress="return isNumberKey(event)" /></div>
        						</div>
        						<div class="col-lg-3">
        							<div><label for="noset"><span class="custom"><font color="red">*</font>No.Of set:</span></label></div>
        							<div><input type="text" name="noset[]" id="noset0" class="form-control" maxlength="4" value="" onkeyup="calculate();"  onkeypress="return isNumberKey(event)" /></div>
        						</div>
        						<div class="col-lg-3">
        							<div><label for="total_amount"><span class="custom"><font color="red">*</font>Total:</span></label></div>
        							<div></div><input type="text" name="total_amount[]" id="total0" class="form-control"  maxlength="4" value="" onkeypress="return isNumberKey(event)"  onkeypress="return isNumberKey(event)" readonly />
        						</div>
        					</div>	
        					<div id="product"></div>
        					<div class="row" >
        						<div class="col-lg-3"></div>
        						<div class="col-lg-3"></div>
        						<div class="col-lg-3"></div>
        						<div class="col-lg-3">
        							<input type="text" name="total_amount[]" id="total_amount" class="form-control" maxlength="4" value="" readonly />
        						</div>
    						</div>
					   	</div>
    				</div>
					<!-----Section One ENd-------->
					<!-----Section Two-------->		
			 		<div  id="appealBook" style="display: none">
			 		    <div class="col-lg-12">
			 	           <div class="row">
        						<div class="col-lg-3">
        							<div><label for="dtoforder2"><span class="custom"><font color="red">*</font>Starting No of Page:</span></label></div>
        							<div><input type="text"  name="nopage2[]" id="nopage20" maxlength="12" value="" class="form-control"    onkeypress="return isNumberKey(event)"  autocomplete="off"/></div>
        						</div>
        						<div class="col-lg-3">
        							<div><label for="nopages2"><span class="custom"><font color="red">*</font>Ending Page:</span></label></div>
        							<div><input type="text" name="end_nopage2[]" id="end_nopage20" class="form-control" maxlength="4" value="" onblur="calculate1();" onkeypress="return isNumberKey(event)" /></div>
        						</div>
        						<div class="col-lg-3">
        							<div><label for="noset2"><span class="custom"><font color="red">*</font>Total Page:</span></label></div>
        							<div><input type="text" name="total_page2[]" id="total_page20" class="form-control" maxlength="4" value="" onkeyup="calculate1();"  onkeypress="return isNumberKey(event)"/></div>
        						</div>
        						<div class="col-lg-3">
        							<div><label for="total_amount2"><span class="custom"><font color="red">*</font>No. of sets:</span></label></div>
        							<div><input type="text" name="noset2[]" id="noset20" class="form-control"	maxlength="4" value=""   onkeyup="calculate1();" onkeypress="return isNumberKey(event)" /></div>
        						</div>
        						<div><input type="hidden" name="total_amount2[]" id="total20" class="form-control"	maxlength="4" value=""   onkeyup="calculate1();" onkeypress="return isNumberKey(event)" /></div>	
        					</div>				
    						<div  id="product2"></div>
        					<div class="row" >
        						<div class="col-lg-3"></div>
        						<div class="col-lg-3"></div>
        						<div class="col-lg-3"></div>
        						<div class="col-lg-3">
        							<input type="hidden" name="totalamount[]" id="totalamount2" class="form-control" maxlength="4" value="" readonly />
    							    <input type="text" name="total_amount[]" id="total_amount2" class="form-control" maxlength="4" value="" readonly />
        						</div>
    						</div>
					   </div> 	
					</div>
					<!-----Section two-------->
					<div class="col-sm-12" id="filingaction11" style="display: none"></div>
					<input type="hidden" name="amountadd" id="amountadd" value="">
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
       		<div class="col-sm-12 div-padd" id="maPayMode" style="display: none"></div> 
       		<div class="col-sm-12 div-padd" id="add_amount_list" ></div> 
            <div class="col-lg-12" id="savebutton" style="display: none">
				<div align="right" style="float:right;padding: 12px">
					<input type="button" name="nextsubmit" id="nextsubmit" value="Submit" onclick="next();" class="btn btn-info">
				</div>
			</div>	
        </div> 
        
        <div class="col-sm-12 div-padd" id="certifiedpdf"></div> 
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
function opendiv(){
	var matterId=document.getElementById("matterId").value; 
	if(matterId==1){
		document.getElementById("orderId").style.display ='block';
		document.getElementById("maPay").style.display ='block';
		document.getElementById("appealBook").style.display ='none';
	}if(matterId==2){
		document.getElementById("maPay").style.display ='block';
		document.getElementById("appealBook").style.display ='block';
		document.getElementById("orderId").style.display ='none';
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
					if(retrn.data!=''){
						document.getElementById("filing_no").value=retrn.data;
						$('#detailsparty').html(retrn.display);
						$('.party_radio_div').removeClass('d-none');
					}
					else if(retrn.error!=''){
						$.alert(retrn.error);
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

function diary(){
	 var radio =  $('input:radio[name=appAnddef]:checked').val();
	 if(radio=='1'){		      
		 $("#myDIV").show();
		 $("#myDIV1").hide();  	
	  	 document.getElementById("case_no").value='';
	  	 document.getElementById("case_type").value='';
	 } 
	 if(radio=='2'){		        	
		  $("#myDIV" ).hide();
		  $("#myDIV1" ).show();  	 
		  document.getElementById("dfr_no").value='';
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
            $("#additionalparty").html(districtdata);
            $("#matter").show();
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




function addMore() {
	var matterId=document.getElementById("matterId").value
	var cnt1=document.getElementById("cnt").value;
    var dataa={};
    dataa['cc']=matterId,
    dataa['cnt']=cnt1,
	 $.ajax({
         type: "POST",
         url:  base_url+"addCetifiedCopy",
         data: dataa,
         cache: false,
         success: function(districtdata) {
        	if(matterId==1){
     			$("#product").append(districtdata);
     		}
     		if(matterId==2){
     			$("#product2").append(districtdata);
     		}
     		document.getElementById("cnt").value=parseInt(cnt1) + parseInt(1);
         }
     });				
}

// calculate fields count Section1 
function calculate(){ 
    for(var i = 0; i <= 5; i++){
	 	var val1 = document.getElementById('nopage'+i).value;
	 	var val2 = document.getElementById('noset'+i).value; 
	 	var totalamount=parseInt(val1)*parseInt(val2) * parseInt(25);
	 	if(Number.isNaN(totalamount)){
			document.getElementById('total'+i).value=0
	 	}else{
	 		document.getElementById('total'+i).value=totalamount
    	}
		totalcalculate(i);
    } 
}
// Total count Section 1 
function totalcalculate(j){
	 var total=0;
	  for(var i = 0; i <= j; i++){
  	 	total +=parseInt(document.getElementById('total'+i).value);
  	 	if(Number.isNaN(total)){
  		 	document.getElementById('total_amount').value=0; 
  	 	}else{
  	 		document.getElementById('total_amount').value=total; 
      	}
      }
}

// calculate fields count Section2
function calculate1(){ 
    for(var i = 0; i <= 5; i++){
	 	var val1 = document.getElementById('nopage2'+i).value;
	 	var val2 = document.getElementById('end_nopage2'+i).value; 
	 	var val3 = document.getElementById('noset2'+i).value; 
	 	if(document.getElementById('nopage2'+i).value >  document.getElementById('end_nopage2'+i).value){
    	 	alert("End page should  greater than start page number.");
    	 	return false;
    	} 
	 	var totalamount= parseInt(val2) -  parseInt(val1)+1;
	 	if(Number.isNaN(totalamount)){
			document.getElementById('total_page2'+i).value=0
	 	}else{
	 		document.getElementById('total_page2'+i).value=totalamount;
    	}
		var totalamount_amount=parseInt(totalamount) * parseInt(val3);
	 	if(Number.isNaN(totalamount_amount)){
			document.getElementById('total2'+i).value=0
	 	}else{
	 		document.getElementById('total2'+i).value=totalamount_amount * 25;
    	}
		totalcalculate1(i);
    } 
}
// Total count Section2 
function totalcalculate1(j){
	 var total=0;
	  for(var i = 0; i <= j; i++){
  	 	total +=parseInt(document.getElementById('total2'+i).value);
  		 document.getElementById('total_amount2').value=total; 
      }
}

function paymentMode() {
	var texts =document.getElementsByName("nopage0");
	var matterId =document.getElementById("matterId").value;
	//for validate all fields  	  
	if(matterId==1){
		var nopage =document.getElementById("nopage0").value;
	    var noset =document.getElementById("noset0").value;
	    var total_amount =document.getElementById("total0").value;
	    if(noset =='' || total_amount==''|| nopage==''){
	    	 document.getElementById("nopage0").style.borderColor = "red";
	    	 document.getElementById("noset0").style.borderColor = "red";
	    	 document.getElementById("total0").style.borderColor = "red";
	    	 document.getElementById("dtoforder0").style.borderColor = "red";
	    	 document.getElementById("error_div").innerHTML = '<span style="color:red">Please fill required fields.</span>';
	    	 return false;
		}
	}
	if(matterId==2){
		var nopage2 =document.getElementById("nopage20").value;
	    var end_nopage2 =document.getElementById("end_nopage20").value;
	    var total_page2 =document.getElementById("total_page20").value;
	    var noset2 =document.getElementById("noset20").value;
	    if(nopage2 =='' || end_nopage2==''|| total_page2=='' ||  noset2==''){
	    	 document.getElementById("nopage20").style.borderColor = "red";
	    	 document.getElementById("end_nopage20").style.borderColor = "red";
	    	 document.getElementById("total_page20").style.borderColor = "red";
	    	 document.getElementById("noset20").style.borderColor = "red";
	    	 document.getElementById("error_div").innerHTML = '<span style="color:red">Please fill required .</span>';
	    	 return false;
		}
	}
	//var texts=parseInt(document.getElementById("nopage").value);
	   var sum = "";
		 for( var i = 0; i < texts.length; i ++ ) {
		     var n = texts[i].value;
		     sum = sum + n;
	    }
		var radios = document.getElementsByName("bd");
		var bd=0;	
		for(var i = 0; i < radios.length; i++){
		    if(radios[i].checked) {
		    	var bd=radios[i].value;
			}
		}
		var dataa={};
        dataa['app']=bd;
        dataa['cc']='cetified';
		$.ajax({
				type: 'post',
				url: base_url+'filingaction/certifiedpostalOrder',
				data: dataa,
				success: function(retrn){
					if(retrn){
						$("#maPayMode").show();
						$("#savebutton").show();
						$("#maPayMode").html(retrn);
					}
				}
			
		});
}


function addMoreAmount(){
     var salt=document.getElementById("filing_no").value;
     var radios = document.getElementsByName("bd");
     var bd=0;	
     for(var i = 0; i < radios.length; i++){
	    if(radios[i].checked){
	    	var bd=radios[i].value;	
		}
      }
      var dbankname=document.getElementById("ntrp").value;
      if(dbankname==""){
    	  alert("Please Enter Bank name");
    	  document.filing.ntrp.focus();
    	  return false;
       }
      var ddno=document.getElementById("ntrpno").value;
      if(ddno==""){
    	  alert("Please Enter Challan No/Ref.No");
    	  document.filing.ntrpno.focus();
    	  return false
      }		  
      var dddate=document.getElementById("ntrpdate").value;
      if(dddate==""){
    	  alert("Please Enter Date of Transction");
    	  document.filing.ntrpdate.focus();
    	  return false
      } 
      var amountRs=document.getElementById("ntrpamount").value;
      if(amountRs==""){
    	   alert("Please Enter Amount ");
    		document.filing.ntrpamount.focus();
    		return false
      }
      var dataa={};
      dataa['dbankname']=dbankname;
      dataa['amountRs']=amountRs;
      dataa['ddno']=ddno;
      dataa['dddate']=dddate;
      dataa['bd']=bd;
      dataa['salt']=salt;
	  $.ajax({
		type: 'post',
		url: base_url+'filingaction/addMoredd_for_cartify',
		data: dataa,
		success: function(retrn){
			if(retrn){
				$("#add_amount_list").show();
				$("#add_amount_list").html(retrn);
		    	document.getElementById("ntrpno").value="";
		    	document.getElementById("ntrpdate").value="";
		    	document.getElementById("ntrpamount").value="";
		    	document.getElementById('amountadd').value=1;
			}
		}
	 });
}


function deletePay(e) {
	var x = confirm("Are you sure you want to delete?");
	if(x==false){
        return false;
	}
     var payid = e;
     var radios = document.getElementsByName("bd");
     var bd = 0;
     for (var i = 0; i < radios.length; i++) {
         if (radios[i].checked) {
             var bd = radios[i].value;
         }
     }
 	var salt = document.getElementById("saltNo").value;
 	var dataa={};
    dataa['payid']=payid;
    dataa['salt']=salt;
    dataa['bd']=bd;
	  $.ajax({
		type: 'post',
		url: base_url+'filingaction/addMoredd_for_cartify',
		data: dataa,
		success: function(retrn){
			if(retrn){
				$("#addmoreaddpay").show();
				$("#addmoreaddpay").html(retrn);
				document.getElementById(payid).style.display = 'none';
		    	document.getElementById("ntrpno").value="";
		    	document.getElementById("ntrpdate").value="";
		    	document.getElementById("ntrpamount").value="";
		    	document.getElementById('amountadd').value=1;
			}
		}
	 });
}


function next() {
	var patyAddId="";
    var count1=0;
	var selected = [];
	var partyType =  $('input:radio[name=userType]:checked').val();
	var filingNo =document.getElementById('filing_no').value;	
	var cnt =document.getElementById('cnt').value;
    if(partyType!='3'){	
    	if($('input[name="additionla_partyy"]:checked').length < 1){
            alert("Please check party type");
            return false;
    	 }
    }
	var meta_type=document.getElementById('matterId').value; 
	if(meta_type==''){
		 alert("Please Select matter.!");
         return false;
	}
	var payment_mode =  $('input:radio[name=bd]:checked').val();// Bank Draft for 1   Postal Order for 2    Online Payment //for 2	
	// matter 1

	if(meta_type=='1'){
    	var dtoforder=document.getElementsByName('dtoforder[]');
    	var orderdate='';
    	var nopage=document.getElementsByName('nopage[]');
    	var no_page='';
    	var noset=document.getElementsByName('noset[]');
    	var no_set='';
    	var total_amount=document.getElementsByName('total_amount[]');
    	var totalamount='';	
        for (var i = 0; i < dtoforder.length; i++) {
        	orderdate = orderdate + dtoforder[i].value + '|';
        	no_page = no_page + nopage[i].value + '|';
        	no_set = no_set + noset[i].value + '|'
        	totalamount=totalamount + total_amount[i].value + '|';
        	  if (dtoforder[i].value == '') {
                  alert("Enter Order Date.!");
                  return false;
              }
        	  if (nopage[i].value == '') {
                  alert("Enter Order page no.!");
                  return false;
              }
        	  if (noset[i].value == '') {
                  alert("Enter Order page no.!");
                  return false;
              }
        	  if (total_amount[i].value == '') {
                  alert("Enter Order page no.!");
                  return false;
              }  
        }
        if (typeof payment_mode == 'undefined') {
    		alert("Payment Mode.");
    		return false;
    	};
    	var payAmount=document.getElementById('payAmount').value;	
        var total=document.getElementById('payAmount').value;
        var amountadd=document.getElementById('amountadd').value;
        var total_amount=document.getElementById('total_amount').value;	 
    		if(amountadd==''){
    			if(payment_mode==3){
    				var payAmount= document.getElementById('payAmount').value;
    				var ntrp =document.getElementById('ntrp').value;
    				var ntrpno =document.getElementById('ntrpno').value;
    				var ntrpamount =document.getElementById('ntrpamount').value;
    				var ntrpdate =document.getElementById('ntrpdate').value
    				if(payAmount==''){
    	    			 alert("Enter  Amount Collective.!");
    	                 return false;
    				}
    				if(document.getElementById('ntrp').value==''){
    	    			 alert("Enter ntrp.!");
    	                 return false;
    				}
    				if(document.getElementById('ntrpno').value==''){
    	    			 alert("Enter ntrp No.!");
    	                 return false;
    				}
    				if(document.getElementById('ntrpamount').value==''){
    	    			 alert("Enter ntrp Amount.!");
    	                 return false;
    				}
    				if(ntrpamount != payAmount){
    	    			 alert("Amount in Rs. should be  equal to Amount Collective .!");
    	                 return false;
    				}
    				if(total_amount > total){
    			    	alert("Enter Amount Collective  is equal or greater than total amount.!");
    		            return false;
    				}
    			}
    		}
    		if(amountadd!=''){	
    		    var deposit=document.getElementById('diposit_amount').value;
    		    if(deposit < total){
    		    	  alert("Enter deposit amount is equal or greater than total amount.!");
    	              return false;
    	    	}
    		}
    		var dataa={};
    	    dataa['patyAddId']=partyType,
    	    dataa['filingNo']=filingNo,
    	    dataa['matterId']=meta_type,
    	    dataa['bd']=payment_mode,
    	    dataa['ntrp']=ntrp,
    	    dataa['ntrpdate']=ntrpdate,
    	    dataa['ntrpno']=ntrpno,
    	    dataa['ntrpamount']=ntrpamount,
    	    dataa['orderdate']=orderdate,
    	    dataa['no_page']=no_page,
    	    dataa['no_set']=no_set,
    	    dataa['total_amount']= totalamount,
    	    dataa['cnt']=cnt,
    	    dataa['total']=total_amount,
    	    dataa['payAmount']=total2,
            $.ajax({
        		type: 'post',
        		url: base_url+'filingaction/copycertifiedCopysave',
        		data: dataa,
        		success: function(retrn){
        			var resp = JSON.parse(retrn);
        			if(resp.data=='error'){
        				alert(resp.massage);
						return false;
        			}else{
        				$("#document_filing_div_id").hide();
    					$("#certifiedpdf").html(resp.value);
                	}
        		}
        	 });
    	}
		// matters 2
		if(meta_type==2){
			var nopage2=document.getElementsByName('nopage2[]');
    		var nopage='';
    		var end_nopage2=document.getElementsByName('end_nopage2[]');
    		var end_nopage='';
    		var total_page2=document.getElementsByName('total_page2[]');
    		var total_page='';
    		var noset2=document.getElementsByName('noset2[]');
    		var noset='';	
    	    for (var i = 0; i < nopage2.length; i++) {
    	    	nopage = nopage + nopage2[i].value + '|';
    	    	end_nopage = end_nopage + end_nopage2[i].value + '|';
    	    	total_page = total_page + total_page2[i].value + '|';
    	    	noset=noset + noset2[i].value + '|';
    	    	  if (nopage2[i].value == '') {
                      alert("Enter No Of Page.!");
                      return false;
                  }
    	    	  if (end_nopage2[i].value == '') {
                      alert("Enter Ending no of page.!");
                      return false;
                  }
    	    	  if (total_page2[i].value == '') {
                      alert("Enter total no page.!");
                      return false;
                  }
    	    	  if (noset2[i].value == '') {
                      alert("Enter no of set .!");
                      return false;
                  }  
            }
            
    	    if (typeof payment_mode == 'undefined') {
    			alert("Payment Mode.");
    			return false;
    		};	
    	    var total2=document.getElementById('payAmount').value;
    		var amountadd=document.getElementById('amountadd').value;
    		var total_amount=document.getElementById('total_amount2').value;	
    		if(amountadd==''){
				if(payment_mode==3){
					var payAmount= document.getElementById('payAmount').value;
					var ntrp =document.getElementById('ntrp').value;
					var ntrpno =document.getElementById('ntrpno').value;
					var ntrpamount =document.getElementById('ntrpamount').value;
					var ntrpdate =document.getElementById('ntrpdate').value;
					if(payAmount==''){
		    			 alert("Enter  Amount Collective.!");
		                 return false;
					}
					if(document.getElementById('ntrp').value==''){
		    			 alert("Enter ntrp.!");
		                 return false;
					}
					if(document.getElementById('ntrpno').value==''){
		    			 alert("Enter ntrp No.!");
		                 return false;
					}
					if(document.getElementById('ntrpamount').value==''){
		    			 alert("Enter ntrp Amount.!");
		                 return false;
					}
					if(ntrpamount != payAmount){
		    			 alert("Amount in Rs. should be  equal to Amount Collective .!");
		                 return false;
					}
					if(total_amount > total2){
				    	alert("Enter Amount Collective  is equal or greater than total amount.!");
			            return false;
					}
				}
    		}
    		if(amountadd!=''){	
	            var diposit_amount1=document.getElementById('diposit_amount').value;
	    	    if(diposit_amount1 < total2){
	    	    	  alert("Enter deposit amount is equal or greater than total amount.!");
	                  return false;
	        	}
    		}
    		var dataa={};
    	    dataa['patyAddId']=partyType,
    	    dataa['filingNo']=filingNo,
    	    dataa['matterId']=meta_type,
    	    dataa['bd']=payment_mode,
    	    dataa['ntrp']=ntrp,
    	    dataa['ntrpdate']=ntrpdate,
    	    dataa['ntrpno']=ntrpno,
    	    dataa['ntrpamount']=ntrpamount,   
    	    dataa['nopage2']=nopage,
    	    dataa['end_nopage2']=end_nopage,
    	    dataa['total_page2']=total_page,
    	    dataa['noset2']=noset,
    	    dataa['cnt']=cnt,
    	    dataa['total']=total_amount,
    	    dataa['payAmount']=total2,
    	    $.ajax({
    			type: 'post',
    			url: base_url+'filingaction/copycertifiedCopysave',
    			data: dataa,
    			success: function(retrn){
    				var resp = JSON.parse(retrn);
        			if(resp.data=='error'){
        				alert(resp.massage);
						return false;
        			}else{
        				$("#document_filing_div_id").hide();
    					$("#certifiedpdf").html(resp.value);
                	}
    			}
    		 });
		 }
	}

$(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
  });
  
</script>