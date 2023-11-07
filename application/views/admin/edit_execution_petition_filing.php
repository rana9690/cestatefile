
<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>

<?php
$salt=$this->session->userdata('salt');
$app= isset($filedcase)?$filedcase:'';
?>
<?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'res_respndent','autocomplete'=>'off']) ?>
       <?= form_fieldset('Search DFR ').'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>
        <?php 
            $salt= $this->session->userdata('salt');
            $token=rand(1000,9999);
            $md_db = hash('sha256',$token);
            $token1=$md_db;
            $this->session->set_userdata('tokenno',$token1);
            $reffrenceno= $this->session->userdata('reffrenceno');
            $refdetail= $this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$reffrenceno);
            $val= substr($refdetail[0]->filing_no,5);
            $a=substr_replace($val ,"",-4);
            $b= substr($val, -4);
            $val= $a.'/'.$b;
            if(!empty($refdetail) && $refdetail[0]->case_type=='execution'){
                $partytype=$refdetail[0]->partyType;
                ?>
         
         <script>
$(document).ready(function() {
	diary();
	serchDFR();
	load_app_respodent('<?php echo $refdetail[0]->partyType ?>');
});
</script>
<?php } ?>
		<input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
	    <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $refdetail[0]->salt; ?>">
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
    		<div class="row" id="myDIV" >		         
    			  <div class="col-md-3">
                         <div class="form-group required">
                        	<label for="name"><span class="custom"><font color="red">*</font></span>DFR NO: </label> 
                        	  <?= form_input(['name'=>'dfr_no','class'=>'form-control','id'=>'dfr_no','value'=>$a,'onkeypress'=>'return isNumberKey(event)','placeholder'=>'Enter DFR NO.','pattern'=>'[0-9]{1,8}','maxlength'=>'8','title'=>'DFR No. should be numeric only.','required'=>'true']) ?>
                         </div>
                  </div>
                  
                   <div class="col-md-3">
                         <div class="form-card">
                              <div class="form-group">
                                  	<label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Case Year:</label>
                                  	<div class="input-group mb-3 mb-md-0">
                                     <?php
                                     $yearv='2020';
                                     $year = $yearv;
                                     if($year==''){ $year='2020';}
                                      $year1=[''=>'- Select Year -'];
                                      for ($i = 2000; $i <= 2050; $i++) {
                                          $year1[$i]=$i;
                                      }
                                      echo form_dropdown('dfryear',$year1,$year,['class'=>'form-control','id'=>'dfryear','required'=>'true']); 
                                     ?>
                                  	</div>
                              </div>
                         </div>
                  </div>
                  
                   <div class="col-md-3">
                         <div class=" col-md-3" style="margin-top: 29px;">
                			<input type="submit" name="nextsubmit" value="SEARCH" class="btn btn-success" id="nextsubmit" onclick="serchDFR();">
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
                              $lowercasetype= $this->efiling_model->data_list_where('master_case_type','case_type_code','1');
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
                                          echo form_dropdown('year',$year1,$year,['class'=>'form-control','id'=>'year','required'=>'true']); 
                                         ?>
                                      	</div>
                                  </div>
                             </div>
    			  </div>
    			  
    			   <div class="col-md-3">
                     <div class="form-group required" style="margin-top: 29px;">
                        <input type="submit" name="nextsubmit" value="SEARCH" class="btn btn-success" id="nextsubmit" onclick="serchDFR();">
                     </div>
    			  </div>
    		</div>	
		<div id="party">
    		</div>	
      <?= form_fieldset_close(); ?>
          <div style="display:none" id="divstype">
            <?= form_fieldset('Execution Petition ').'<i class="icon-plus-circle2 text-danger" style="position: absolute;padding: 9px 6px;"></i>'; ?>
    		  	<input type="hidden" id="filing_no" name="filing_no" value="<?php echo $refdetail[0]->filing_no; ?>">           
                    <div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px; margin: -20px auto 12px; max-width: 100%;">
                        <div class="col-md-4">
                            <label class="text-danger">Select Type</label>
                        </div>
                        <div class="col-md-6 md-offset-2">
                            <label for="org" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'load_app_respodent(1)','value'=>'1','checked'=>('1' == $partytype) ? TRUE : FALSE,'id'=>'pet']); ?>Applicant&nbsp;&nbsp;
                            </label>
                            <label for="indv" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'load_app_respodent(2)','value'=>'2','checked'=>('2' == $partytype) ? TRUE : FALSE,'id'=>'res']); ?>Respondent&nbsp;&nbsp;
                            </label>
                            <label for="inp" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'load_app_respodent(3)','value'=>'3','checked'=>('3' == $partytype) ? TRUE : FALSE,'id'=>'tParty']); ?> Third Party
                            </label>
                        </div>
                    </div>              
                    <div class="row">
                        <div class="col-md-12" id="main_div_main_reviw_petition">
                            <div class="form-group required" id="displaytype">
                            </div>
                            <div class="col-sm-12 div-padd" id="partyparityshow" style="display: none">
                            </div>                       
                        </div>
                        
                        <div class="col-md-12" id="documentUpload" style="display: none">
                        	 <div class="row">		
                                  <div class="col-md-12">
                                        <div class="row">
                                               <div class="col-md-3">
                                                 <label class="control-label" for="fullappeal"><span class="custom"><font color="red">*</font></span>Execution Petition (Includeing Annexure Per Hard Copy Submitted):</label>
                                               </div>
                                                <div class="col-md-6">
                                                     <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                     <?=form_upload(['id'=>'fIlingDoc','name'=>'files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                     </div>
                                               </div>
                                         </div> 
                                          <div class="row">
                                               <div class="col-md-3">
                                                 <label class="control-label" for="ia_files"><span class="custom"><font color="red">*</font></span>Execution Petition With IA in Word Formate:</label>
                                               </div>
                                                <div class="col-md-6">
                                                     <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                     <?=form_upload(['id'=>'ia_files','name'=>'ia_files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                     </div>
                                               </div>
                                         </div>
                                          <div class="row">
                                               <div class="col-md-3">
                                                 <label class="control-label" for="v_files"><span class="custom"><font color="red">*</font></span>Vakalatnama:</label>
                                               </div>
                                                <div class="col-md-6">
                                                     <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                     <?=form_upload(['id'=>'v_files','name'=>'v_files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                     </div>
                                               </div>
                                         </div>
                                         <div class="row">
                                               <div class="col-md-3">
                                                 <label class="control-label" for="r_files"><span class="custom"><font color="red">*</font></span>Online Payment Receipt:</label>
                                               </div>
                                                <div class="col-md-6">
                                                     <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                     <?=form_upload(['id'=>'r_files','name'=>'r_files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                     </div>
                                               </div>
                                         </div>
                                          <div class="row">
                                               <div class="col-md-3">
                                                 <label class="control-label" for="totalNoRespondent"><span class="custom"><font color="red">*</font></span>Add More:</label>
                                               </div>
                                               <div class="col-md-3">
                                                 <div class="input-group mb-3 mb-md-0">
                                                 	<input type="text" name="docname" value="" id="docname" class="form-control" placeholder="Document name"  maxlength="250" title="Docuemnt Name required.">
                                              	 </div>
                                               </div>
                                                <div class="col-md-3">
                                                     <div class="custom-file" style="border: 1px solid #e5bf88; padding: 5px 8px; border-radius: 6px; background: #eee; margin: auto 0px;">
                                                     <?=form_upload(['id'=>'fIlingDoc','name'=>'files','class'=>'files','title'=>'Upload your Document, file should be jpeg,jpg,gif,pdf & bmp format only','placeholder'=>'choose profile image','aria-describedby'=>'idproof01','accept'=>'application/pdf, image/gif, image/jpeg, image/png, image/jpg' ]); ?>
                                                     </div>
                                               </div>
                                         </div>
                                     </div>
                                  <div class="col-md-3" style="margin-top: 25px;float:right">
                                  	<input  type="button" name="btnSubmit" id="btnSubmit" value="Save & Next" class="btn btn-info" onclick="uploade();">
                                  </div>
                             </div>
                        </div>  
                    
                        
                        <div class="col-md-12" id="payment_reviw_petition" style="display: none">                   
                        </div>
                        
                        <div class="col-md-12" id="finalview" style="display: none">                    
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
		<?= form_fieldset_close(); ?>
     </div>
	<?= form_close();?>
	 <?php $this->load->view("admin/footer"); ?>
<script>

function uploade(){
	$('#loading_modal').fadeIn(200);
	var salt = document.getElementById("saltNo").value;
	if(salt==''){
        var salt = Math.ceil(Math.random() * 100000);
        document.getElementById("saltNo").value = salt;
    }
 	var file_data =  $('#fIlingDoc')[0].files[0];  
    var salt= document.getElementById("saltNo").value;
    var token= document.getElementById("token").value;
    var type='EP';
    var form_data = new FormData();                 	
	form_data.append('file', file_data);
	form_data.append('salt', salt);
	form_data.append('token', token);
	form_data.append('type', type);
	$.ajax({
            type: "POST",
            url: base_url+"/filingaction/documentUpload",
            data: form_data,
            dataType: 'text', 
            cache: false,
            contentType: false,
            processData: false,
            success: function (resp) {
            	var resp = JSON.parse(resp);
            	if(resp.data=='success') {
            	    document.getElementById("loading_modal").style.display = 'none';
            	    $('#payment_reviw_petition').show();
            	    $('#documentUpload').hide();
            	    
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

function filingAction_execution() {
    var filingOn = $("#filing_no").val();
var order_date = $("#order_date").val();



    var tttotal_feee_amount = $("#tttotal_feee_amount_iddd").val();
    var partyType1 = $('input[name=partyType]:checked').val();
    var checkboxes1 = document.getElementsByName('patyAddIdmain');
    var parit = document.getElementsByName("numbermian");
    var patyAddId = "";
    var count1 = 0;
    var p = "";
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
            patyAddId = patyAddId + checkboxes1[i].value + ',';
        }
        if (parit[count1].value != "") {
            p = p + parit[count1].value + ',';
        }
        count1++;
    }
    var checkboxesres = document.getElementsByName('patyAddId1');
    var parit1 = document.getElementsByName("number1");
    var patyAddIdres = "";
    var count11 = 0;
    var pp = "";
    for (var i = 0; i < checkboxesres.length; i++) {
        if (checkboxesres[i].checked) {
            patyAddIdres = patyAddIdres + checkboxesres[i].value + ',';
        }
        if (parit1[count11].value != "") {
            pp = pp + parit1[count11].value + ',';
        }
        count11++;
    }
    var bd = $('input[name=bd]:checked').val();
    if (bd == 3) {
        var ddno = $("#ntrpno").val();
                 var vasks = ddno.toString().length;
                if(Number(vasks) != 13){
                   alert("Please Enter 13  Digit Challan No/Ref.No");
                   document.ntrpno.focus();
                   return false
                 }


        var amountRs = $("#ntrpamount").val();
        var dddate = $("#ntrpdate").val();
        var dbankname = $("#ntrp").val();
        if (dbankname == "") {
            alert("Please Enter Bank name");
            document.filing.ntrp.focus();
            return false;
        }
        if (ddno == "") {
            alert("Please Enter Challan No/Ref.No");
            document.filing.ntrpno.focus();
            return false
        }
        if (dddate == "") {
            alert("Please Enter Date of Transction");
            document.filing.ntrpdate.focus();
            return false
        }
        if (amountRs == "") {
            alert("Please Enter Amount ");
            document.filing.ntrpamount.focus();
            return false
        }

            var collectamount = $("#collectamount").val();
            if(collectamount==''){
            	var collectamount=0;
                }
            var remainamount = $("#remainamount").val();
            var totalamount = $("#totalamount").val();
            var profee = $("#profee").val();
            var anxfee = $("#anxfee").val();
            var proanx=parseInt(anxfee)+parseInt(profee);
            var iaval = document.getElementById("iaval").value;
            var val= parseInt(collectamount)+parseInt(amountRs);
            if(iaval=='3'){
            	if(proanx  > val){
                    alert("Please Enter Amount Greater than or equl "+proanx);
                    document.ntrpamount.focus();
                    return false
                }
            }
 if(iaval!='3'){
          if(totalamount > val){
       		alert("Total amount and paid amount should be equal ");
                return false
          }
}

    }
    var matter = document.getElementById("matter").value;
    var iaNature = "";
    var checkboxes = document.getElementsByName('natureCode');
    var selected = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            iaNature = iaNature + checkboxes[i].value + ',';
        }
    }
var saltNo = $("#saltNo").val();
    var dataa={};
    dataa['tttotal_feee_amount']= tttotal_feee_amount,
    dataa['filingNo']=filingOn,
    dataa['type']=partyType1,
    dataa['addparty']= patyAddId,
    dataa['matter']= matter,
    dataa['dbankname']=dbankname,
    dataa['amountRs']=amountRs,
    dataa['ddno']= ddno,
    dataa['dddate']=dddate,
    dataa['bd']= bd,
    dataa['iaNature']= iaNature,
    dataa['p']=p,
    dataa['casetype']= '6',
    dataa['res']=patyAddIdres,
    dataa['pp']= pp,
    dataa['order_date']= order_date,
   dataa['saltNo']=saltNo,
     $.ajax({
         type: "POST",
         url: base_url+"/filingaction/execution_action",
         data: dataa,
         cache: false,
         success: function (resp) {
        	 document.getElementById("main_div_main_reviw_petition").innerHTML = resp;
             $("#payment_reviw_petition").hide();
             $("#payment_reviw_petition").empty();
             document.getElementById("main_div_main_reviw_petition").style.display = 'block';
         },
         error: function (request, error) {
				$('#loading_modal').fadeOut(200);
         }
     }); 
}


function paymentMode_execution(values) {
	 var dataa={};
    dataa['app']=values;
    dataa['type']='execution';
     $.ajax({
         type: "POST",
         url: base_url+"/filingaction/postalOrderOthrer_rpcpep",
         data: dataa,
         cache: false,
         success: function (resp) {
             document.getElementById("payMode_execution").innerHTML = resp;
             document.getElementById("payMode_execution").style.display = 'block'; 
         },
         error: function (request, error) {
				$('#loading_modal').fadeOut(200);
         }
     }); 
}


    function popitup(filingno,ianumbt,year) {
    	 var dataa={};
        dataa['filing_no']=filingno,
        dataa['iano']=ianumbt,
        dataa['year']=year,
         $.ajax({
             type: "POST",
             url: base_url+"/filingaction/iaprint_rp_cp_ep",
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


    function serchDFR(){
    	var partyType1 = $('input[name=appAnddef]:checked').val();
    	var case_type = $("select[name='case_type']").val();
    	var year = $("select[name='year']").val();
    	var dfryear = $("select[name='dfryear']").val();	
    	var dfr=$("#dfr_no").val();
    	var case_no=$("#case_no").val();

    	if(partyType1=='2'){
        	if(case_type==''){
        		alert("Please Select Type.");
        		return false;
        	}
        	if(year==''){
        		alert("Please Select year.");
        		return false;
        	}
        	if(case_no==''){
        		alert("Please Enter case_no.");
        		return false;
        	}
    	}
    	if(partyType1=='1'){
        	if(dfr==''){
        		alert("Please Enter DFR NO.");
        		return false;
        	}
        	if(dfryear==''){
        		alert("Please Enter year.");
        		return false;
        	}
    	}
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
            	if(data2.data){
            		$('#divstype').show()
            		$('#party').html(data2.display)
          		document.getElementById("filing_no").value=data2.data;
        	}else if(data2.error != '0') {
    			$.alert(data2.error);
    		}
              },
            
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


    function load_app_respodent(value) {
        var filing_no = $("#filing_no").val();
        var dataa={};
        dataa['party_flag']=value;
        dataa['filing_no']=filing_no;
        dataa['type']='execution';
         $.ajax({
             type: "POST",
             url: base_url+"/filingaction/load_app_respodent",
             data: dataa,
             cache: false,
             success: function (resp) {
             	//	$('.steps').empty().load(base_url+'/efiling/case_filing_steps');
             	$('#displaytype').html(resp);
             },
             error: function (request, error) {
    				$('#loading_modal').fadeOut(200);
             }
         });  
     }



function parity_execution(){
	var salt = document.getElementById("saltNo").value;
	if(salt==''){
        var salt = Math.ceil(Math.random() * 100000);
        document.getElementById("saltNo").value = salt;
    }
    $("#droft_no").val(salt);
    var filing_no = $("#filing_no").val();
    var totalNoAnnexure = $("#totalNoAnnexure").val();
    var matter = $("#matter").val();
    var checkboxes1 = document.getElementsByName('patyAddId_review_pe'); 
    var patyAddId = "";
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
            patyAddId = patyAddId + checkboxes1[i].value + ',';
        }
    }
    var partyType1 = $('input[name=partyType]:checked').val();
    if(partyType1!='3'){        
       if(patyAddId==''){
           alert("Please slect party");
           return false;
       }
    }  
    if(partyType1!='3'){  
        if(patyAddId==''){
            alert("Select Party Type");
            return false;
        }
    }


    var checkboxes1 = document.getElementsByName('otherFeeCode');
    var otherFee = "";
    var count1 = 0;
    var selected = [];
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
            otherFee = otherFee + checkboxes1[i].value + ',';
            count1++;
        }
    }



  



    var councilCode1= document.getElementById('councilCode').value;
    if(councilCode1==''){
		alert("Select council Code.");
		return false;
    }
    var ddistrictname1= document.getElementById('ddistrictname').value;
    var counselPhone1= document.getElementById('counselPhone').value;
    var counselAdd1= document.getElementById('counselAdd').value;
    var counselPin1= document.getElementById('counselPin').value;
    var counselEmail1= document.getElementById('counselEmail').value;
    var dstatename1= document.getElementById('dstatename').value;
    var counselMobile1= document.getElementById('counselMobile').value;
    var counselFax1= document.getElementById('counselFax').value;
    var patyAddId=patyAddId;

    
    if(partyType1!='3'){
    	 var dataa={};
         dataa['partuid']=patyAddId;
         dataa['fno']=filing_no;
         dataa['type']=partyType1;
         dataa['type_type']='execution';
         dataa['totalNoAnnexure']=totalNoAnnexure;
         dataa['matter']=matter;     
         dataa['refsalt']=salt;  
         dataa['otherFee']=otherFee;
         dataa['councilCode1']= councilCode1,
		 dataa['ddistrictname1']= ddistrictname1,
		 dataa['counselAdd1']=counselAdd1,
		 dataa['counselPin1']= counselPin1,
		 dataa['counselEmail1']= counselEmail1,
	          dataa['dstatename1']= dstatename1,
		 dataa['counselMobile1']= counselMobile1,
		 dataa['counselFax1']= counselFax1,
		 dataa['patyAddId']= patyAddId,
          $.ajax({
              type: "POST",
              url: base_url+"/filingaction/execution_party_parity",
              data: dataa,
              cache: false,
              success: function (resp) {
            	  document.getElementById("displaytype").style.display = 'none';
            	  document.getElementById("partyparityshow").innerHTML = resp;
            	  $("#payment_reviw_petition").hide();
                //  $("#documentUpload").show();
                  
                  $("#partyparityshow").show();
              },
              error: function (request, error) {
  				$('#loading_modal').fadeOut(200);
              }
          }); 
    }
}


function payment_execution() {
    var filingOn = $("#filing_no").val();
    var order_date = $("#order_date").val();
    var totalNoAnnexure1 = $("#totalNoAnnexure").val();
    var totalNoIA = $("#totalNoIA").val();
    var iaNature = "";
    var checkboxes1 = document.getElementsByName('otherFeeCode');
    var otherFee = "";
    var count1 = 0;
    var selected = [];
    for (var i = 0; i < checkboxes1.length; i++) {
        if (checkboxes1[i].checked) {
            otherFee = otherFee + checkboxes1[i].value + ',';
            count1++;
        }
    }
    var partyType1 = $('input[name=partyType]:checked').val();
    if(partyType1!='3'){
        if (count1 == 0 && totalNoAnnexure1 != 0) {
            alert("Please Select Enclosure /Annexure Court fee");
            document.filing.otherFeeCode.focus();
            return false;
        }
    }
    if (totalNoIA == "") {
        alert("Please Enter Total No IA");
        document.filing.totalNoIA.focus();
        return false
    }

        var salt = document.getElementById("saltNo").value;
        var iaNature = "";
var count = 0;
        var checkboxes = document.getElementsByName('natureCode');
        var selected = [];
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                iaNature = iaNature + checkboxes[i].value + ',';
count++;
            }
        }


  var ia = document.getElementById("totalNoIA").value;
    if (count < ia) {
        var msg = "You should be enter total no of IA -> " + ia + " so you cannot less then -> " + ia + " IA nature"
        alert(msg);
        return false;
    }


    var dataa={};
    dataa['ia']=totalNoIA;
    dataa['ann']=totalNoAnnexure1;
    dataa['fee']=otherFee;
    dataa['type_exec']='execution';
    dataa['exe']='5';
    dataa['order_date']=order_date;
    dataa['salt']=salt;
    dataa['iaNature']=iaNature;
     $.ajax({
         type: "POST",
         url: base_url+"/filingaction/reviewpayment",
         data: dataa,
         cache: false,
         success: function (resp) {
        	 // document.getElementById("payment").innerHTML = this.responseText;
             $("#main_div_main_reviw_petition").hide();
             $("#payment_reviw_petition").html(resp);
             //$("#payment_reviw_petition").show();
             $("#payment_reviw_petition").hide();
             $("#documentUpload").show();
         },
         error: function (request, error) {
				$('#loading_modal').fadeOut(200);
         }
     }); 
}


function valcheck(){
    	  var values = [];
    	  $('#va1 input:text').each(
    	    function() {
    	      if (values.indexOf(this.value) >= 0) {
    	        $(this).css("border-color", "red");
    	        $(this).val('');
    	      } else {
    	        $(this).css("border-color", ""); //clears since last check
    	        values.push(this.value);
    	      }
    	    }
    	  );

    	}

function valcheck1(){
	  var values = [];
	  $('#va2 input:text').each(
	    function() {
	      if (values.indexOf(this.value) >= 0) {
	        $(this).css("border-color", "red");
	        $(this).val('');
	      } else {
	        $(this).css("border-color", ""); //clears since last check
	        values.push(this.value);
	      }
	    }
	  );

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
    dataa['q']=str;
     $.ajax({
         type: "POST",
         url: base_url+"/filingaction/org",
         data: dataa,
         cache: false,
         success: function (resp) {
             var data2 = JSON.parse(resp);
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
            url: base_url+"/filingaction/districtrp",
            data: "state_id=" + state_id,
            cache: false,
            success: function(districtdata) {
                $("#ddistrict1").html(districtdata);
                $("#ddistrict1").val(city_id);
            }
        });
    }
}

function showUser_ia1(str) {
	var dataa={};
    dataa['q']=str;
     $.ajax({
         type: "POST",
         url: base_url+"/filingaction/getAdvDetailrp",
         data: dataa,
         cache: false,
         success: function (resp) {
        	 var data2 = JSON.parse(resp);
             $("#counselAdd1").val(data2[0].address);
             $("#counselMobile1").val(data2[0].mob);
             $("#counselEmail1").val(data2[0].mail);
             $("#counselPhone1").val(data2[0].ph);
             $("#counselPin1").val(data2[0].pin);
             $("#counselFax1").val(data2[0].fax);
             $("#dstatename1").val(data2[0].stname);
             $("#ddistrictname1").val(data2[0].dname);
         },
         error: function (request, error) {
				$('#loading_modal').fadeOut(200);
         }
     });  
}

</script>