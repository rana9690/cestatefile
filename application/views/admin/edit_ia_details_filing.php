<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php
$salt=$this->session->userdata('salt');
$app= $filedcase;
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
    if(!empty($refdetail) && $refdetail[0]->case_type=='IA'){
        $partytype=$refdetail[0]->partyType;
        $iaNature=$refdetail[0]->iaNature;
        $anx=$refdetail[0]->anx;
        $party_ids=$refdetail[0]->party_ids;
?>       
<script>
$(document).ready(function() {
	diary();
	serchDFR();
	showparty_ia_details('<?php echo $partytype; ?>');
});
</script>
<?php } ?>
		<input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
	    <input type="hidden" name="saltNo" id="saltNo" value="">
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
    		<div class="row" id="myDIV">		         
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
                	     <input type="submit" name="nextsubmit" value="Save and Next" class="btn btn-success" id="nextsubmit" onclick="serchDFR();">
                      </div>
    			  </div>
             </div>
             
    		 <div class="row" id="myDIV1"  style="display: none;">
        		  <div class="col-md-3">
                        <div class="form-card">
                          <div class="form-group">
                          	<label class="control-label" for="case_type_lower"><span class="custom"><font color="red">*</font></span>Case Type:</label>
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
                                 $yearv='2020';
                                 $year = $yearv;
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
                        <input type="submit" name="nextsubmit" value="Save and Next" class="btn btn-success" id="nextsubmit" onclick="serchDFR();">
                     </div>
    			  </div>
    		</div>	
    		<div id="party">
    		</div>	
      <?= form_fieldset_close(); ?>
          <div style="display:none" id="divstype">
    		  	<input type="hidden" id="filing_no" name="filing_no" value="<?php echo $refdetail[0]->filing_no; ?>">           
                    <div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px; margin: -20px auto 12px; max-width: 100%;">
                        <div class="col-md-4">
                            <label class="text-danger">Select Type</label>
                        </div>
                        <div class="col-md-6 md-offset-2">
                            <label for="org" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'showparty_ia_details(1)','value'=>'1','checked'=>('1' == $partytype) ? TRUE : FALSE,'id'=>'pet']); ?>Applicant&nbsp;&nbsp;
                            </label>
                            <label for="indv" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'showparty_ia_details(2)','value'=>'2','checked'=>('2' == $partytype) ? TRUE : FALSE,'id'=>'res']); ?>Respondent&nbsp;&nbsp;
                            </label>
                            <label for="inp" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'showparty_ia_details(3)','value'=>'3','checked'=>('3' == $partytype) ? TRUE : FALSE,'id'=>'tParty']); ?> Third Party
                            </label>
                        </div>
                    </div>  
                    
                
             <div id="showpayment" style="display:none">
                   <div id="addparty1"></div>
                    <div class="row"> 
             			<div class="col-lg-12" >
                            <div id="additionalparty" class="row"></div>                                         
                         </div> 
                      </div>
                    <fieldset id="iaNature" style="display:block"> <legend class="customlavelsub">IA Nature</legend>                 
                      <input type="hidden" name="filing_no" id="filing_no">
                            <div class="row">  
                             <!--<div class="col-lg-12">  
                                    <div id="div_check_valaltanama_ia"> </div>
                                    <div class="col-sm-12 div-padd" id="addparty" style="display:none"></div>
                                 </div>--->
                                <div class="col-lg-4">	
                                    <label for="name"><span class="custom">Total No Of  Annexure:</span></label>
                                    <input type="text" name="totalNoAnnexure" id="totalNoAnnexure"  class="form-control" maxlength="3" value="<?php echo $anx ;?>" onkeypress="return isNumberKey(event)" />
                                </div>
                            </div> <br>
                            <div class="row">     
                                <table class="table" border="1" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Check </th>
                                            <th>IA Nature Name</th>
                                            <th> Fees</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php
                              //  $array=array('34','20','19','52','17','18','23','14','15','28','29','31','36','10','39','40','21','41','42','43','45','48','49','50','51','35','22','27','6','53','54','55','56','57','58','59','60');
                                  $aDetail= $this->efiling_model->data_list('moster_ia_nature');
                                $ffgf = 1;
                                $iaNature=explode(',', $iaNature);
                                foreach ($aDetail as $row ) {
                                    $ls='';
                                    if(in_array($row->nature_code,$iaNature)){
                                       $ls='checked';
                                    }
                                    ?>
                                        <tr>
                                            <td><?php echo $ffgf; ?></td>
                                            <td><input type="checkbox" name="natureCode"   onclick="openTextBox()"  value="<?php echo htmlspecialchars($row->nature_code); ?>" <?php echo $ls; ?>/></td>                                          
                                            <td> <?php echo htmlspecialchars($row->nature_name); ?></td>
                                            <td> <?php echo htmlspecialchars($row->fee); ?></td>
                                        </tr>
                                        <?php $ffgf++;   } ?>
                                    </tbody>
                                </table>
					      </div>				
                          <div class="col-sm-12 div-padd" id="matterId" style="display: none">
                                <div><label for="name"><span class="custom"> <font color="red"></font> </span>Matter </label></div>
                                <div><textarea rows="4" cols="110" name="matter" id="matter"  class="txtblock"></textarea></div>
                             
                          </div>
                          <div class="col-sm-12 div-padd" id="otherfees" style="display: none"></div>
                          <div id="payNext" style="margin-left:900px;padding:10px;display:block">
                        	<input type="button" name="nextsubmit" id="nextsubmit" value="Next Pay" class="btn btn-info " onclick="fee()" />
                        	<div class="col-sm-12 div-padd" id="action_ia_details" style="display:none"></div>
               			 </div>	 
                    </fieldset>
                    </div> 
                    <div id="action_ia_details">
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
     </div>
<?= form_close();?>
 <?php $this->load->view("admin/footer"); ?>
<script>
function deletePay(e) {
    var payid = e;
    var salt = $("#filing_no").val();
    var bd = $('input[name=userType]:checked').val();
    var data = {};
    data['salt'] =salt,
    data['ptype'] =bd,
	data['payid'] =payid,
    $.ajax({
        type: "POST",
        url: base_url+"/filingaction/delete_advocate",
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


function addMoreCouncel(){
	    var salt = $("#filing_no").val();
	    var bd = $('input[name=userType]:checked').val();
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
		 $.ajax({
	        type: "POST",
	        url: base_url+"/filingaction/addMorecouncel",
	        data: data,
	        dataType: "html",
	        success: function(data) {
	            $("#advlisting").html(data);
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
	    var type='IA';
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
            	    $('#showpayment').show();
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
	
	 function actionfile() {
        var iaNature = "";
        var count = 0;
        var checkboxes = $("#dddate").val();
        var patyAddId =$("#patyAddId").val();
        var iaNature = $("#ia_nature").val();
        var amount_total = $("#subtital_amount").val();
        var filingNo = $("#filing_no").val();
        var party = $('input[name=appAnddef1]:checked').val();
        var bd = $('input[name=bd]:checked').val();
        var matt= $("#matter").val();
        if (bd == 3) {
            var ddno = $("#ntrpno").val();
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
             var iaval = document.getElementById("iaval").value;
             var val= parseInt(collectamount)+parseInt(amountRs);
             if(iaval!='3'){
                if(totalamount > val){
        		   alert("Total amount and paid amount should be equal ");
                    return false
                 }
             }    
        }
        if (party == 3) {
            var petName = $("#petName").val();
            var degingnation = $("#degingnation").val();
            var dstate = $("#dstate").val();
            var ddistrict = $("#ddistrict").val();
            var petAddress = $("#petAddress").val();
            var petmobile = $("#petmobile").val();
            var petPhone = $("#petPhone").val();
            var petEmail = $("#petEmail").val();
            var petFax = $("#petFax").val();
            var pincode = $("#pincode").val();
        }
        var saltNo= $("#saltNo").val(); 
        var dataa={};
		dataa['amount_total']=amount_total;
		dataa['ia_nature']=iaNature;
		dataa['fNo']=filingNo;
		dataa['party']=party;
		dataa['bname']=dbankname;
		dataa['dno']=ddno;
		dataa['ddate']=dddate;
		dataa['amount']=amountRs;
		dataa['bd']=bd;
		dataa['partyadd']=patyAddId;
		dataa['saltNo']=saltNo;
		dataa['matt']=matt;
		$.ajax({
            type: "POST",
            url: base_url+"/filingaction/ia_action",
            data: dataa,
            dataType: "html",
            success: function(data) {
              	var data = JSON.parse(data);
            	if(data.data=='success'){
	                $("#showpayment").hide();
		          	$("#action_ia_details").show();
		          	document.getElementById("action_ia_details").innerHTML =data.display;
            	}
            	if(data.data=='error'){
    	              alert(data.msg);
            	}

            },
            error: function(request, error) {
               alert("Try again ");
            }
        });										 
    }

	function fee() {
        var filing_no = $("#filing_no").val();
    	var salt = document.getElementById("saltNo").value;
    	if(salt==''){
            var salt = Math.ceil(Math.random() * 100000);
            document.getElementById("saltNo").value = salt;
        }
        var caseval = $('input[name=appAnddef1]:checked').val();
        if (caseval == "") {
            alert("Please Check Party Type Filed By IA")
            document.appAnddef1.focus();
            return false;
        }
        var partyType1 = $('input[name=partyType]:checked').val();     
        if(partyType1=='undefined'){
               alert("Please Select Type");
               return false;
        }
        var count = 0;
        var iaNature='';
        var checkboxes = document.getElementsByName('natureCode');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                iaNature = iaNature + checkboxes[i].value + ',';
                count++;
            }
        }
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
      			

        if (iaNature == "") {
            alert("Please Check IA Nature");
            document.natureCode.focus();
            return false;
        }
        var totalNoAnnexure = document.getElementById("totalNoAnnexure").value;
        if (totalNoAnnexure == "") {
            alert("Please Check total No Annexure");
            document.totalNoAnnexure.focus();
            return false;
        }
        var data = {};
        data['filed'] = caseval;
        data['natuer'] = count;
        data['anx'] = totalNoAnnexure;
        data['iaNature']=iaNature;
        data['patyAddId']=patyAddId;
        data['partyType']=partyType1;
        data['filing_no']=filing_no;
        data['refsalt']=salt; 
        data['filing_no'] = filing_no;
        $.ajax({
            type: "POST",
            url: base_url+"/filingaction/paymentDetail",
            data: data,
            dataType: "html",
            success: function(data) {
                document.getElementById("showpayment").innerHTML =data;
             //   document.getElementById("otherfees").style.display = 'block';
                $("#showpayment").hide();
                $("#documentUpload").show();
                document.getElementById("iaNature").style.display = 'none';
                document.getElementById("payNext").style.display = 'none';
            },
            error: function (request, error) {
  				$('#loading_modal').fadeOut(200);
              }
        });
	 }

	function paymentMod_ia_details(value) {
        var data = {};
        data['app'] = value;
    	$.ajax({
            type: "POST",
            url: base_url+"/filingaction/postalOrderia",
            data: data,
            dataType: "html",
            success: function(data) {
            	document.getElementById("payMode_ia_details").innerHTML = data;
            	document.getElementById("payMode_ia_details").style.display = 'block';
    	        //document.getElementById("payMode_ia_details").style.display = 'block';  	
            },
            error: function(request, error) {
                $("#div_check_valaltanama_ia").html(data);
            }
    	});
	 }
	    
	 
	function fn_check_valaltanama_ia(str_str) {
       var party_id = $("#additionla_partyy").val();
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
    
    function showparty_ia_details(caseval) {
        var filingNo = $("#filing_no").val();	
        if(caseval == '3'){ 
        var dataa={};
		dataa['type']=caseval,
		dataa['faling_no']=filingNo,
            $.ajax({
                type: "POST",
                url: base_url+"/filingaction/addparty_ia_details",
                data: dataa,
                cache: false,
                success: function(districtdata) {
                    document.getElementById("addparty1").innerHTML = districtdata;
                    $("#showpayment").show();
                    document.getElementById("addparty1").style.display = 'block';
                    document.getElementById("additionalparty").style.display = 'none';
                    $("#additionla_partyy").html('');
                }
            });
        }
		if(caseval != '3') { 
			var dataa={};
			dataa['radio_selected']=caseval,
			dataa['faling_no']=filingNo,
	        $.ajax({
	            type: "POST",
	            url: base_url+"/filingaction/dropdown_party_details",
	            data: dataa,
	            cache: false,
	            success: function(districtdata) {
	                document.getElementById("additionalparty").style.display = 'block';
	                $("#showpayment").show();
	                $("#additionalparty").html(districtdata);
	                document.getElementById("addparty1").style.display = 'none';
	            }
	        });
    	}
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

 function showUserOrg(str) {
	var dataa = {};
	dataa['q'] = str;
    if (str == '0') {
        document.getElementById("counselAdd").value = "";
        document.getElementById("counselMobile").value = "";
        document.getElementById("counselEmail").value = "";
        document.getElementById("counselPhone").value = "";
        document.getElementById("counselPin").value = "";
        document.getElementById("counselFax").value = "";
        document.getElementById("cdstate").value = "";
        document.getElementById("dstatename").value = "";
        document.getElementById("cddistrict").value = "";
        document.getElementById("ddistrictname").value = "";
    }
    $.ajax({
        type: "POST",
        url: base_url+'getAdvDetail',
        data: dataa,
        cache: false,
        success: function (petSection) {
        	 var data1 = petSection;
             console.log(data1);
             var data2 = JSON.parse(data1);
             if (str != 0) {
                document.getElementById("counselAdd").value = data2[0].address;
                document.getElementById("counselMobile").value = data2[0].mob;
                document.getElementById("counselEmail").value = data2[0].mail;
                document.getElementById("counselPhone").value = data2[0].ph;
                document.getElementById("counselPin").value = data2[0].pin;
                document.getElementById("counselFax").value = data2[0].fax;
                document.getElementById("cdstate").value = data2[0].stcode;
                document.getElementById("dstatename").value = data2[0].stname;
                document.getElementById("cddistrict").value = data2[0].dcode;
                document.getElementById("ddistrictname").value = data2[0].dname;
             }
        }
    });
}


 function orgshow() {
     var checkboxes = document.getElementsByName('org');
     for (var i = 0; i < checkboxes.length; i++) {
         if (checkboxes[i].checked) {
             idorg = checkboxes[i].value;
         }
     }
     if (idorg == 1) {
         document.getElementById("org").style.display = 'block';
         document.getElementById("ind").style.display = 'none';
     }
     if (idorg == 2) {
         document.getElementById("ind").style.display = 'block';
         document.getElementById("org").style.display = 'none';
         document.getElementById("petName1").value = '';
         document.getElementById("degingnation1").value = '';
         document.getElementById("petAddress1").value = '';
         document.getElementById("dstate1").value = 'Select State';
         document.getElementById("ddistrict1").value = 'Select District';
         document.getElementById("pincode1").value = '';
         document.getElementById("petmobile1").value = '';
         document.getElementById("petPhone1").value = '';
         document.getElementById("petEmail1").value = '';
         document.getElementById("petFax1").value = '';
     }
 }
	
</script>