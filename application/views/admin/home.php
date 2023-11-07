<div class="row justify-content-center mt-0">
    <div class="col-12">
        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
 
            <div class="row">
                <div class="col-md-12 mx-0">
                <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'msform','autocomplete'=>'off']) ?>
   							<div class="col-lg-12">
       							<div class="row">
       							   <div class="col-lg-4">
                                        <div class="form-card">
                                            <div class="form-group">
                                              	<label class="control-label" for="bench"><span class="custom"><font color="red">*</font></span>Principal / Circit  Bench  </label>
                                              <div class="input-group mb-3 mb-md-0">
                                                   <?php
                                                   $data_array=[' '=>'Select Bench',
                                                       '100'=>'Delhi(Principal Bench)',
                                                       '101'=>'Chennai(Circuit Bench)',
                                                       '103'=>'Mumbai(Circuit Bench)',
                                                       '102'=>'Mumbai(Circuit Bench)'];
                                                        echo form_dropdown('bench',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                                     
                                              </div>
                                            </div>
                                        </div> 
                                        <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="act"><span class="custom"><font color="red">*</font></span>Act</label>
                                              <div class="input-group mb-3 mb-md-0">
                                                 <?php
                                                        $data_array=[' '=>'Select act Name','1'=>'The Electricity Act,2003','2'=>'Petroleum Act,1934'];
                                                        echo form_dropdown('act',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                              </div>
                                            </div>
                                        </div>   
                                         <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="totalNoRespondent"><span class="custom"><font color="red">*</font></span>Total No Of Respondent:</label>
                                              <div class="input-group mb-3 mb-md-0">
                                              <?= form_input(['name'=>'totalNoRespondent','class'=>'form-control','placeholder'=>'Total No Respondent','pattern'=>'[0-9]{6,8}','maxlength'=>'8','title'=>'Total No Respondent should be numeric only.']) ?>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <div class="col-lg-4">  
                                         <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="subBench"><span class="custom"><font color="red">*</font></span>Jurisdiction:</label>
                                              <div class="input-group mb-3 mb-md-0">
                                                   <?php
                                                        $data_array=[' '=>'Select Name','15'=>'Chhattisgarh','16'=>'Jharkhand'];
                                                        echo form_dropdown('subBench',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                              </div>
                                            </div>
                                        </div>
                                       	<div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="petSection"><span class="custom"><font color="red">*</font></span>Under Section:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                     <?php
                                                        $data_array=[' '=>'Select Under Section','1'=>'111','2'=>'121'];
                                                        echo form_dropdown('petSection',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                              	</div>
                                            </div>
                                        </div>
                                        <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="totalNoIA"><span class="custom"><font color="red">*</font></span>Total No Of IA:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                  <input type="text" name="totalNoIA" id="totalNoIA" class="form-control" maxlength="3" value="" onkeypress="return isNumberKey(event)">
                                              	 <?= form_input(['name'=>'totalNoIA','class'=>'form-control','placeholder'=>'Total No IA','pattern'=>'[0-9]{6,8}','maxlength'=>'8','title'=>'Total No IA should be numeric only.']) ?>
                                              	</div>
                                            </div>
                                        </div>
                                     </div>

                                    <div class="col-lg-4">
                                        <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="caseType"><span class="custom"><font color="red">*</font></span>APTEL Case Type:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                        <?php
                                                        $data_array=['1'=>'Appeal(APL)','2'=>'Original Special  Petition(OSP)','4'=>'Original Petition(OP)'];
                                                        echo form_dropdown('caseType',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                              	</div>
                                            </div>
                                        </div>
                                        
                                         <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="petSubSection1"><span class="custom"><font color="red">*</font></span>Under sub-section :</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                  <?php
                                                        $data_array=['1'=>'1 &amp; 2'];
                                                        echo form_dropdown('petSubSection1',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                              	</div>
                                            </div>
                                        </div>
                                        
                                         <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="totalNoAnnexure"><span class="custom"><font color="red">*</font></span>Total No Of Annexure:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                              	 <?= form_input(['name'=>'totalNoAnnexure','class'=>'form-control','placeholder'=>'Total No Annexure','pattern'=>'[0-9]{6,8}','maxlength'=>'10','title'=>'Total No Annexure should be alpha numeric only.']) ?>
                                              	</div>
                                            </div>
                                        </div>
                                    </div>
               					</div>               					
       						</div>
       						<h6 style="color:#2196F3;">Appropriate Commission/Adjudication Officers</h6>
   							<div class="col-lg-12">
   								<div class="row">
   							  		 <div class="col-lg-4">
   							   			 <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="commission"><span class="custom"><font color="red">*</font></span>Commission:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                          <?php
                                                        $data_array=['11'=>'Haryana Electricity Regulatory Commission','12'=>'Himachal Pradesh Electricity Regulatory Commission'];
                                                        echo form_dropdown('commission[]',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                              	</div>
                                              </div>
                                         </div>
                                         
                                          <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="caseNo"><span class="custom"><font color="red">*</font></span>Case No:</label>
                                              	<div class="input-group mb-3 mb-md-0">	
                                              	<?= form_input(['name'=>'caseNo[]','id'=>"caseNo",'class'=>'form-control','placeholder'=>'caseNo','pattern'=>'[0-9]{6,8}','maxlength'=>'8','title'=>'caseNo should be numeric only.']) ?>
                                              	</div>
                                              </div>
                                         </div>
                                          <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="comDate"><span class="custom"><font color="red">*</font></span>Communication Date:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                 	<?= form_input(['name'=>'comDate[]','id'=>"comDate",'class'=>'form-control','placeholder'=>'Communication Date','pattern'=>'[0-9]{6,8}','maxlength'=>'8','title'=>'Communication Date Date.']) ?>
                                              	</div>
                                              </div>
                                         </div>
   							   		  </div>
   							   		  
   							   		   <div class="col-lg-4">
   							   			 <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="natureOrder"><span class="custom"><font color="red">*</font></span>Nature of Order:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                        <?php
                                                        $data_array=['5'=>'Tariff Appeals','11'=>'Trading Margin'];
                                                        echo form_dropdown('natureOrder[]',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                                     
                                              	</div>
                                              </div>
                                         </div>
                                         
                                          <div class="form-card">
                                              <div class="form-group">
                                                  	<label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Case Year:</label>
                                                  	<div class="input-group mb-3 mb-md-0">
                                                     <?php
                                                        $data_array=['2000'=>'2000','2001'=>'2001'];
                                                        echo form_dropdown('caseYear[]',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                                  	</div>
                                              </div>
                                         </div>
                                          <div class="form-card">
                                              <div class="form-group">
                                                 <label class="control-label" for="caseYear"><span class="custom"><font color="red"></font></span></label>
                                                  <div class="input-group mb-3 mb-md-0">
                                                  	<button type="button" class="btn btn-info" onclick="fn_check_caveat();">Check Caveat</button>
                                                  </div>
                                              </div>
                                         </div>
   							   		  </div>
   							   		  
   							   		 <div class="col-lg-4">
   							   			 <div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="case_type_lower"><span class="custom"><font color="red">*</font></span>Lower Court Case Type:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                  <?php
                                                        $data_array=['9'=>'R.P','11'=>'R.P'];
                                                        echo form_dropdown('case_type_lower',$data_array,'',['class'=>'form-control','required'=>'true']); 
                                                     ?>
                                              	</div>
                                              </div>
                                         </div>
                                         
                                          <div class="form-card">
                                              <div class="form-group">
                                                  	<label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Decision Date:</label>
                                                  	<div class="input-group mb-3 mb-md-0">
                                                     	<input type="text" value="20/05/2020" name="ddate[]" id="ddate" class="form-control datepicker_fixed_filling hasDatepicker" readonly="readonly" maxlength="10">
                                                  	</div>
                                              </div>
                                         </div>
   							   		  </div>
   							   		  
							   		     <div>
                                        <button type="button" class="btn btn-info" onclick="addMore();">Add More</button>
                                    </div>
   							   	 </div>
   							   	 
   							   	  <div class="row" id="product">
                                    <input type="hidden" name="cnt" id="cnt" value="">
                                </div>
   							   	
   							 </div>
   							 
                    	<input type="button" name="next" class="next action-button btn btn-success float-right"  onclick="filing_next();" value="Next Step" />
                	</fieldset>

                </div>
            </div>
        </div>
    </div>
</div>


