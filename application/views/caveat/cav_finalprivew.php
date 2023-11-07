<?php
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepscaveat");
$salt=$this->session->userdata('cavsalt');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$token= $this->efiling_model->getToken();
if($salt!=''){
    $cavd= $this->efiling_model->data_list_where('temp_caveat','salt',$salt);
}

$commfull_name='';
if($cavd[0]->commission!=''){
    $comm_row=$this->efiling_model->data_list_where('master_commission','id',$cavd[0]->commission);
    $commfull_name =$comm_row[0]->full_name;
}
$casetype='';
if($cavd[0]->case_type!=''){
    $ct=$this->efiling_model->data_list_where('master_case_type','case_type_code',$cavd[0]->case_type);
    $casetype =$ct[0]->short_name;
}


?>
<div class="content" style="padding-top:0px;">
<div class="card"  id="dvContainer" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px;  border-top-left-radius: 0px;">
    <form action="<?php echo base_url(); ?>/iaaction" target="_blank" class="wizard-form steps-basic wizard clearfix" id="finalsubmit" autocomplete="off" method="post" accept-charset="utf-8">
       <div class="content clearfix" id="mainDiv1">
        <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
	    <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
	    <input type="hidden" name="tabno" id="tabno" value="7">
	    <input type="hidden" name="type" id="type" value="cave">


		<FIELDSET>
            <LEGEND><b>Basic Detail</b></legend>
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
                <tbody>
                    <tr>
                        <td width="16%">Commission</td>
                        <td width="16%"><?php echo $commfull_name; ?></td>
                        <td width="16%">Case Type</td>
                        <td width="16%"><?php echo $casetype; ?></td>
                        <td width="16%">Petition Number</td>
                        <td width="16%"><?php echo $cavd[0]->case_no; ?></td>
                    </tr>
    
                    <tr>
                        <td>Petition Year</td>
                        <td><?php echo $cavd[0]->case_year; ?></td>
                        <td>Date of Impugned Order </td>
                        <td><?php echo $cavd[0]->decision_date; ?></td>
                        <td>Prayer</td>
                        <td><?php echo $cavd[0]->prayer; ?></td>
                    </tr>
                </tbody>
            </table>
	   </fieldset>
	    <?php 
	    $caveateename='';
	    if($cavd[0]->caveat_name!='' && is_numeric($cavd[0]->caveat_name)){
	        $caveateva=$this->efiling_model->data_list_where('master_org','org_id',$cavd[0]->caveat_name);
	        $caveateename =$caveateva[0]->org_name;
	    }
	    
	    
	    $caveateestate='';
	    if($cavd[0]->caveat_state!='' && is_numeric($cavd[0]->caveat_state)){
	        $caveatestateva=$this->efiling_model->data_list_where('master_psstatus','id',$cavd[0]->caveat_state);
	        $caveateestate =$caveatestateva[0]->state_name;
	    }
	    
	    
	    
	    $caveateedisterict='';
	    if($cavd[0]->caveat_district!='' && is_numeric($cavd[0]->caveat_district)){
	        $caveatevadi=$this->efiling_model->data_list_where('master_psdist','id',$cavd[0]->caveat_district);
	        $caveateedisterict =$caveatevadi[0]->district_name;
	    }
	    
	    
	    ?>
	   
	   <FIELDSET>
            <LEGEND><b>Caveator Details</b></legend>
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
                <tbody>
                    <tr>
                        <td width="16%">Organization</td>
                        <td width="16%"><?php echo $caveateename; ?></td>
                        <td width="16%">Mobile No</td>
                        <td width="16%"><?php echo $cavd[0]->caveat_mobile; ?></td>
                        <td width="16%">Address </td>
                        <td width="16%"><?php echo $cavd[0]->caveat_address; ?></td>
                    </tr>

                    <tr>
                        <td>State</td>
                        <td><?php echo $caveateestate; ?></td>
                        <td>District </td>
                        <td><?php echo $caveateedisterict; ?></td>
                        <td>Pincode</td>
                        <td><?php echo $cavd[0]->caveat_pin; ?></td>
                    </tr>
                     <tr>
                        <td>Email Id</td>
                        <td><?php echo $cavd[0]->caveat_email; ?></td>
                        <td>Phone No</td>
                        <td><?php echo $cavd[0]->caveat_phone; ?></td>

                    </tr>
                </tbody>
            </table>
	   </fieldset>
	  <?php
	    $cavetrov='';
	    if($cavd[0]->caveatee_name!='' && is_numeric($cavd[0]->caveatee_name)){
	        $cv=$this->efiling_model->data_list_where('master_org','org_id',$cavd[0]->caveatee_name);
	        $cavetrov =$cv[0]->org_name;
	    }
	    $cstate='';
	    if($cavd[0]->caveatee_state!='' && is_numeric($cavd[0]->caveatee_state)){
	        $cs=$this->efiling_model->data_list_where('master_psstatus','id',$cavd[0]->caveatee_state);
	        $cstate =$cs[0]->state_name;
	    }

	    $csdis='';
	    if($cavd[0]->caveatee_district!='' && is_numeric($cavd[0]->caveatee_district)){
	        $cd=$this->efiling_model->data_list_where('master_psdist','id',$cavd[0]->caveatee_district);
	        $csdis =$cd[0]->district_name;
	    }
	    ?>
	      <FIELDSET>
            <LEGEND><b> Caveatee Details</b></legend>
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
                <tbody>
                    <tr>
                        <td width="16%">Organization</td>
                        <td width="16%"><?php echo $cavetrov; ?></td>
                        <td width="16%">Mobile No</td>
                        <td width="16%"><?php echo $cavd[0]->caveatee_mobile; ?></td>
                        <td width="16%">Address </td>
                        <td width="16%"><?php echo $cavd[0]->caveatee_address; ?></td>
                    </tr>
    
                    <tr>
                        <td>State</td>
                        <td><?php echo $cstate; ?></td>
                        <td>District </td>
                        <td><?php echo $csdis; ?></td>
                        <td>Pincode</td>
                        <td><?php echo $cavd[0]->caveatee_pin; ?></td>
                    </tr>
                    
                    
                     <tr>
                        <td>Email Id</td>
                        <td><?php echo $cavd[0]->caveatee_email; ?></td>
                        <td>Phone No</td>
                        <td><?php echo $cavd[0]->caveatee_phone; ?></td>
 
                    </tr>
                    
                </tbody>
            </table>
	   </fieldset>
	   
	   
	   
	   <FIELDSET>
            <LEGEND><b>Advocate Details</b></legend>
     <?php  
           $html='';
           $html.='
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
	        <thead>
    	        <tr>
        	        <th>Sr. No. </th>
        	        <th>Name</th>
        	        <th>Registration No.</th>
                    <th>Address</th>
        	        <th>Mobile</th>
        	        <th>Email</th>
    	        </tr>
	        </thead>
	        <tbody>';
           $html.='</tbody>';
           $vals=$this->efiling_model->data_list_where('temp_caveat','salt',$salt);
           if($vals[0]->council_code){
               $counseladd=$vals[0]->council_code;
               if($vals[0]->advType=='1'){
                   if (is_numeric($vals[0]->council_code)) {
                       $orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
                       $adv_name=$orgname[0]->adv_name;
                       $adv_reg=$orgname[0]->adv_reg;
                       $adv_mobile=$orgname[0]->adv_mobile;
                       $email=$orgname[0]->email;
                       $address=$orgname[0]->address;
                       $pin_code=$orgname[0]->adv_pin;
                       if($vals[0]->adv_state!=''){
                           $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->adv_state);
                           $statename= $st2[0]->state_name;
                       }
                       if($vals[0]->adv_district!=''){
                           $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->adv_district);
                           $ddistrictname= $st1[0]->district_name;
                       }
                   }
               }
               
               if($vals[0]->advType=='2'){
                   if (is_numeric($vals[0]->pet_council_adv)) {
                       $orgname=$this->efiling_model->data_list_where('efiling_users','id',$counseladd);
                       $adv_name=$orgname[0]->fname.' '.$orgname[0]->lname;
                       $adv_reg=$orgname[0]->id_number.' <span style="color:red">'.$orgname[0]->idptype.'</span>';
                       $adv_mobile=$orgname[0]->mobilenumber;
                       $email=$orgname[0]->email;
                       $address=$orgname[0]->address;
                       $pin_code=$orgname[0]->pincode;
                       
                       if($vals[0]->pet_state!=''){
                           $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
                           $statename= $st2[0]->state_name;
                       }
                       if($vals[0]->pet_dist!=''){
                           $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
                           $ddistrictname= $st1[0]->district_name;
                       }
                   }
               }
               $type="'main'";
               $html.='
                <tr style="color:green">
                    <td>1</td>
        	        <td>'.$adv_name.'</td>
        	        <td>'.$adv_reg.'</td>
                    <td>'.$address.' '.$ddistrictname.' ('.$statename.')  '.$pin_code.'</td>
        	        <td>'.$adv_mobile.'</td>
        	        <td>'.$email.'</td>
                </tr>';
           }
           $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
           if(!empty($advocatelist)){
               $i=2;
               foreach($advocatelist as $val){
                   $counselmobile='';
                   $counselemail='';
                   $counseladd=$val->council_code;
                   $advType=$val->advType;
                   if($advType=='1'){
                       if (is_numeric($val->council_code)) {
                           $orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
                           $adv_name=$val->adv_name;
                           $adv_reg=$orgname[0]->adv_reg;
                           $address=$val->counsel_add;
                           $pin_code=$val->counsel_pin;
                           $counselmobile=$val->counsel_mobile;
                           $counselemail=$val->counsel_email;
                           $id=$val->id;
                           if($val->adv_state!=''){
                               $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$val->adv_state);
                               $statename= $st2[0]->state_name;
                           }
                           if($val->adv_district!=''){
                               $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$val->adv_district);
                               $ddistrictname= $st1[0]->district_name;
                           }
                       }
                   }
                   if($advType=='2'){
                       if (is_numeric($val->council_code)) {
                           $orgname=$this->efiling_model->data_list_where('efiling_users','id',$counseladd);
                           $adv_name=$orgname[0]->fname.' '.$orgname[0]->lname;
                           $adv_reg=$orgname[0]->id_number.' <span style="color:red">'.$orgname[0]->idptype.'</span>';
                           $counselmobile=isset($orgname[0]->mobilenumber)?$orgname[0]->mobilenumber:'';
                           $counselemail=isset($orgname[0]->email)?$orgname[0]->email:'';
                           $address=$orgname[0]->address;
                           $pin_code=$orgname[0]->pincode;
                           $id=$val->id;
                           if($orgname[0]->state!=''){
                               $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$orgname[0]->state);
                               $statename= $st2[0]->state_name;
                           }
                           if($orgname[0]->district!=''){
                               $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$orgname[0]->district);
                               $ddistrictname= $st1[0]->district_name;
                           }
                       }
                   }
                   $type="'add'";
                   $html.='<tr>
            	        <td>'.$i.'</td>
            	        <td>'.$adv_name.'</td>
            	        <td>'.$adv_reg.'</td>
                        <td>'.$address.' '.$ddistrictname.' ('.$statename.')  '.$pin_code.'</td>
            	        <td>'.$counselmobile.'</td>
            	        <td>'.$counselemail.'</td>
        	        </tr>';
                   $i++;
               }
           }
           echo  $html;
	         ?>
	         </table>
	         </FIELDSET>

	   
	   
	   
	   

 		<FIELDSET>
            <LEGEND><b class="fa fa-upload">&nbsp;&nbsp;Uploaded Documents Details :</b></legend>
            <table id="example" class="display" cellspacing="0" border="1" width="100%">
                <thead>                    
                    <tr>
                        <th style="width:15%">Party Type</th>                    
                        <th style="width:60%">Document Type</th>                    
                        <th style="width:5%">No of Pages</th>                    
                        <th style="width:15%">Last Update</th>                   
                        <th style="width:5%">View</th>
                    </tr>
                </thead>
                <tbody>
                <?php
            
                $warr=array('salt'=>$salt,'user_id'=>$userid,'display'=>'Y','submit_type'=>'cave');
                $docData =$this->efiling_model->list_uploaded_docs('temp_documents_upload',$warr);
                
                if(@$docData) {
                    foreach ($docData as $docs) {
                        $document_filed_by = $docs->document_filed_by;
                        $document_type = $docs->document_type;
                        $no_of_pages = $docs->no_of_pages;
                        $file_id = $docs->id;
                        $update_on = $docs->update_on;
                        
                        echo'<tr>
                                <td>'.$document_filed_by.'</td>
                                <td>'.$document_type.'</td>
                                <td>'.$no_of_pages.'</td>
                                <td>'.date('d-m-Y H:i:s', strtotime($update_on)).'</td>
                                <td id="updDocId"><a href="javascript:void();" tagId="'.$file_id.'"><i class="fa fa-eye"></i></a></td>
                        </tr>';
                    }
                }
                else echo'<tr><td colspan=5 class="text-danger text-center h3">No document uploaded!</td></tr>';
                ?>
                </tbody>
            </table>
        </fieldset>

	</div>
	<?= form_close();?>    
 </div>
<div class="row">
    <div class="offset-md-8 col-md-4" style="margin-left: 80.66667%;">
        <input  type="button" value="Save and Next" class="btn btn-success" onclick="iafpsubmit();">
		&nbsp;&nbsp;<input type="reset" value="Reset/Clear" class="btn btn-danger">
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

<!-- Display Uploaded file PDF -->
<div class="modal fade" id="updPdf" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="frame">                   
                <iframe style="width: 100%; height: 560px" id="frameID" src=""></iframe>
            </div>
        </div>
    </div>
</div>        
<script>
$('#updDocId > a').click(function(e){
    e.preventDefault();
    var updId='', href='';
    updId=$(this).attr('tagId');
    $.ajax({
        type: 'post',
        url: base_url+'uploaded_docs_display',
        data: {docId: updId},
        dataType: 'json',
        success: function(rtn){
            debugger;
            if(rtn.error == '0'){
                href=base_url+rtn.data;   
                $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");   
            }
            else $.alert(rtn.error);
        }
    });
    $('#updPdf').modal('show');
});


function printPage() {
    change("testdiv", "true");
    window.print();
}


function iafpsubmit(){
    var salt = document.getElementById("saltNo").value;
    var token = document.getElementById("token").value;
    var tabno= document.getElementById("tabno").value;
    var type= document.getElementById("type").value;
    var dataa = {};
	dataa['salt']  =salt;
	dataa['token'] =token;
	dataa['tabno'] =tabno;
	dataa['type'] =type;
	$.ajax({
        type: "POST",
        url: base_url+'cavefpsave',
        data: dataa,
        cache: false,
        beforeSend: function(){
        	$('#other_feesave').prop('disabled',true).val("Under proccess....");
        },
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
         	   setTimeout(function(){
                    window.location.href = base_url+'cav_payment';
                 }, 250); 
        	}
        	else if(resp.error != '0') {
        		$.alert(resp.error);
        	}
        },
        error: function(){
        	$.alert("Surver busy,try later.");
        },
        complete: function(){
        	$('#other_feesave').prop('disabled',false).val("Submit");
        }
    }); 
}

function printPage(){
    var divContents = $("#dvContainer").html();
    var printWindow = window.open('', '', 'height=400,width=800');

    printWindow.document.write(divContents);

    printWindow.document.close();
    printWindow.print();
}
</script>
<?php $this->load->view("admin/footer"); ?>