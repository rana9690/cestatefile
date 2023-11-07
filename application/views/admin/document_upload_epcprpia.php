<?php
$salt=$this->session->userdata('salt');
$app= $filedcase;
?>
<?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'res_respndent','autocomplete'=>'off']) ?>
       <?= form_fieldset('Search DFR ').'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>
        <div class="col-md-12" >
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
    		<div class="row" id="myDIV" style="display: none;">		         
    			  <div class="col-md-3">
                         <div class="form-group required">
                        	<label for="name"><span class="custom"><font color="red">*</font></span>DFR NO: </label> 
                        	  <?= form_input(['name'=>'dfr_no','class'=>'form-control','id'=>'dfr_no','value'=>'','onkeypress'=>'return isNumberKey(event)','placeholder'=>'Enter DFR NO.','pattern'=>'[0-9]{1,8}','maxlength'=>'8','title'=>'DFR No. should be numeric only.','required'=>'true']) ?>
                         </div>
                  </div>
                  
                   <div class="col-md-3">
                         <div class="form-card">
                              <div class="form-group">
                                  	<label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Case Year:</label>
                                  	<div class="input-group mb-3 mb-md-0">
                                     <?php
                                     $yearv=$basic[0]->l_case_year;  $yearv=explode('|', $yearv);
                                     $year = $yearv;
                                     if($year==''){ $year='2020';}
                                      $year1=[''=>'- Select Year -'];
                                      for ($i = 2000; $i <= 2050; $i++) {
                                          $year1[$i]=$i;
                                      }
                                      echo form_dropdown('dfryear',$year1,$year[0],['class'=>'form-control','id'=>'dfryear','required'=>'true']); 
                                     ?>
                                  	</div>
                              </div>
                         </div>
                  </div>
                  
                   <div class="col-md-3">
                         <div class=" col-md-3" style="margin-top: 29px;">
                			<input type="submit" name="nextsubmit" value="Save and Next" class="btn btn-success" id="nextsubmit" onclick="serchDFR();">
                        </div>
    			  </div>
             </div>
             
    		 <div class="row" id="myDIV1" style="">
        		  <div class="col-md-3">
                        <div class="form-card">
                          <div class="form-group">
                          	<label class="control-label" for="case_type_lower"><span class="custom"><font color="red">*</font></span>Lower Court Case Type:</label>
                          	<div class="input-group mb-3 mb-md-0">
                              <?php
                              $lowercasetype= $this->efiling_model->data_list('master_case_type');
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
                                         $year = $yearv;
                                         if($year==''){ $year='2020';}
                                          $year1=[''=>'- Select Year -'];
                                          for ($i = 2000; $i <= 2050; $i++) {
                                              $year1[$i]=$i;
                                          }
                                          echo form_dropdown('year',$year1,$year[0],['class'=>'form-control','id'=>'year','required'=>'true']); 
                                         ?>
                                      	</div>
                                  </div>
                             </div>
    			  </div>
    			  
    			   <div class="col-md-3">
                     <div class="form-group required" style="margin-top: 29px;">
                        <input type="submit" name="nextsubmit" value="Save and Next" class="btn btn-success" id="nextsubmit" onclick="serchDFR();">
                     </div>
    			  </div>
    		</div>		
      		<?= form_fieldset_close(); ?>
          		<div style="display:none" id="divstype">
           		 <?= form_fieldset('Document Upload').'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>
    		  	     <input type="hidden" id="filing_no" name="filing_no" value="">           
                        <div class="row">		         
            			  <div class="col-md-3">
                             <div class="form-group required">
                            	<label for="name"><span class="custom"><font color="red">*</font></span>DFR NO: </label> 
                            	  <?= form_input(['name'=>'dfr_no','class'=>'form-control','id'=>'dfr_no','value'=>'','onkeypress'=>'return isNumberKey(event)','placeholder'=>'Enter DFR NO.','pattern'=>'[0-9]{1,8}','maxlength'=>'8','title'=>'DFR No. should be numeric only.','required'=>'true']) ?>
                             </div>
                          </div>
                          
                           <div class="col-md-3">
                             <div class="form-card">
                                  <div class="form-group">
                                      	<label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Type:</label>
                                      	<div class="input-group mb-3 mb-md-0">
                                            <select name="type" class="form-control" id="type" required="true">
                                                <option value="" selected="selected">- Type -</option>
                                                <option value="RP">RP</option>
                                                <option value="CP">CP</option>
                                                <option value="EP">EP</option>
                                                <option value="IA">IA</option>
                                                <option value="Other">Other</option>
                                            </select>
                                      	</div>
                                  </div>
                             </div>
                          </div>
                          
                          <div class="col-md-3">'.
                              <?=  form_label('&nbsp;&nbsp;File','idproof',['class'=>'fa fa-upload text-danger','style'=>'font-size: 18px;']);?>
                                <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                               <?=form_upload(['id'=>'fIlingDoc','name'=>'files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                               </div>
                              </div>
                              
                    </div>                     
			<?= form_fieldset_close(); ?>
     </div>
	<?= form_close();?>
<script>
function serchDFR(){
	var partyType1 = $('input[name=appAnddef]:checked').val();
	var case_type = $("select[name='case_type']").val();
	var year = $("select[name='year']").val();
	var dfryear = $("select[name='dfryear']").val();	
	var dfr=$("#dfr_no").val();
	var case_no=$("#case_no").val();
	var dataa={};
    dataa['type']=partyType1;
    dataa['case_no']=case_no;
    dataa['year']=year;
    dataa['case_type']=case_type;
    dataa['filing_no']=dfr;
    dataa['dfr_year']=dfryear;       
      $.ajax({
          type: "POST",
          url: base_url+"/filingaction/findrecord",
          data: dataa,
          cache: false,
          success: function (resp) {
        	var data2 = JSON.parse(resp);
        	if(data2.data=='success'){
            	$('#divstype').show()
          		document.getElementById("filing_no").value=data2.filing;
        	}
        	else if(resp.error != '0') {
				$.alert(resp.error);
			}
          },
          error: function (request, error) {
				$('#loading_modal').fadeOut(200);
          }
      });  
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function diary(){
	 var radio =  $('input:radio[name=appAnddef]:checked').val();
	 if(radio=='1'){		      
		 $("#myDIV").show();
		 $("#myDIV1").hide();  	
	  	 document.getElementById("case_no").value='';
	  	 document.getElementById("year").value='';
	  	 document.getElementById("case_type").value='';
	 } 
	 if(radio=='2'){		        	
		  $("#myDIV" ).hide();
		  $("#myDIV1" ).show();  	 
		  document.getElementById("dfr_no").value='';
		  document.getElementById("dfryear").value='';
	} 
}
</script>