<?php
$selected_radio1=$_REQUEST['type'];
$filingNo=$_REQUEST['faling_no'];
if($filingNo!="" and $selected_radio1!=""){
$st=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filingNo);
foreach ($st as $row) {
 	 $filing_no = htmlspecialchars($row->filing_no);
 	 $petName=$row->pet_name;
 	 $resName=$row->res_name;
 	 $fDate=$row->dt_of_filing;
	 $partyType=$row->pet_type;
	 $degingnation=$row->pet_degingnation;
	 $petAddress=$row->pet_address;
	 $pet_adv_id=$row->pet_adv;
	 $petAddress=$row->pet_address;
	 $pstate=$row->pet_state;
	 $petpincode=$row->pet_pin;
	 $petmob=$row->pet_mobile;
	 $petPhone=$row->pet_phone;
	 $petmail=$row->pet_email;
	 $petfax=$row->pet_fax;
	 $pet_adv=$row->pet_adv;
	 
	 $dateOfFiling=explode("-",$fDate);
 	 $statu=$row->status;
 	 if($statu=='P'){
     		$statusName='Pending';
 	 }if($statu=='D'){
     			$statusName='Disposal';
 	 }
}

?>
<style>
    .btn-info {
        margin: 5px 0;
    }
    .ia_details_table td, .ia_details_table th {
        padding: 0px 8px;
    }
    .ia_details_table th {
        background: #171717;
        color: #fff;
        padding: 5px 8px;
    }
</style>
 <div class="col-sm-12 div-padd">
    <table class="ia_details_table" border="1" width="100%">
   		<?php if($selected_radio1==1){?>
   		<td><?php echo  $petName; echo ('(A-1)');?>&nbsp;&nbsp; &nbsp;  <input type="checkbox" name="patyAddId" value="<?php echo $partyType;?>"> </td>
   		<?php } if($selected_radio1==2){?>
  		<td><?php echo  $resName; echo ('(R-1)');?>&nbsp;&nbsp; &nbsp;  <input type="checkbox" name="patyAddId" value="<?php echo $partyType;?>"> </td>
   		<?php } 
       $noOfParty=0;
       $j=2;
       $where =array('filing_no'=>$filingNo,'party_flag'=>$selected_radio1);
       $addParty =  $this->efiling_model->select_in('additional_party',$where);
       foreach ($addParty as $row){
     		 $partyName=$row->pet_name;
     		 $id=$row->party_id;
     		 $flag=$row->party_flag;
     		  if($noOfParty>2){
     		 	$noOfParty=0;
     		 }  if($noOfParty==0){
     		 	echo" <tr>";
     		 } if($noOfParty<=2){
     		?>
     		<td><?php echo $partyName; if($flag==1){echo '(A-'.$j++.')';} if($flag==2){echo '(R-'.$j++.')';}?>&nbsp;&nbsp; &nbsp;  <input type="checkbox" name="patyAddId" value="<?php echo $id;?>"> </td>
     		<?php 
     		 }
     		 if($noOfParty==2){
     		 	echo" <tr>";
     		 }
     		  $noOfParty++;
     		  $j++;
     }
     ?>
     </tr>
</table>
</div>
<?php } if($selected_radio1==3){?>
         <div  class="col-md-12" id="annId_review">
        	<fieldset  style="padding-right: 0px;"><legend class="customlavelsub">Third Party Details</legend>
            <div class="row alert alert-warning" style="padding: 8px 0px 0px; font-weight: 600;font-size: 18px; margin: -20px auto 12px; max-width: 100%;">
                <div class="col-md-4">
                    <label class="text-danger">Select Mode</label>
                </div>
                <div class="col-md-6 md-offset-2">
                    <label for="org" class="form-check-label font-weight-semibold">
                        <?= form_radio(['name'=>'org','id'=>"bd1" ,'value'=>'1','onclick'=>'orgshow();','checked'=>'1']); ?>
                        Organization&nbsp;&nbsp;
                    </label>
                    <label for="indv" class="form-check-label font-weight-semibold">
                        <?= form_radio(['name'=>'org','id'=>'po1' ,'value'=>'2' ,'onclick'=>'orgshow();','checked'=>'']); ?>
                        Individual&nbsp;&nbsp;
                    </label>
                    <label for="inp" class="form-check-label font-weight-semibold">
                    <?php //echo  $salt=htmlspecialchars($_REQUEST['salt']); ?>
                    </label>
                </div>
            </div>
        	<div class="row">
        		<div class="col-md-4"  id="org" >
        			<div class="form-group required">
        				<label><span class="custom"><font color="red">*</font></span>Select Organization :</label>
        				<select name="select_org_app1" class="form-control" id="select_org_app1" onchange="apple_org_details_ia1(this.value)">
        						<option value="">Select Org Name</option>
                                <?php $hscquerytttt = $this->efiling_model->data_list('master_org');
                                foreach ($hscquerytttt as $row) { ?>
                                <option value="<?php echo htmlspecialchars($row->org_id); ?>"><?php echo htmlspecialchars($row->orgdisp_name); ?></option>
                                <?php }  ?>
                        </select>
                    </div>
        		</div>
        		<div class="col-md-4" id="ind" style="display:none">
        		   <div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span>Select Organization:</label>
                       <input type="text" name="select_org_app1" id="select_org_app1" class="form-control" />
                    </div>
        		</div>
        		
        		<div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span>Party Name:</label>
                       <input type="text" name="petName1" id="petName1" class="form-control" />
                    </div>
        		</div>
        	    <div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span>Designation: </label>
                       <input type="text" name="degingnation1" value="<?php echo htmlspecialchars( $degingnation);?>" id="degingnation1" class="form-control" />
                    </div>
        		</div>
        	</div>       		
           <div class="row">  	
        	    <div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span> Address Of Appeliant: </label>
                       <textarea name="petAddress1" id="petAddress1" class="form-control" cols="25"><?php echo htmlspecialchars( $petAddress);?></textarea>
                    </div>
        		</div>	
        		 <div class="col-md-4">
            		<div class="form-group required">
                	   <label><span class="custom"><font color="red">*</font></span>State Name : </label>
                       <select name="dstate1" class="form-control" id="dstate1" onchange="showCity(this);">
                    		<option selected="selected">Select State Name</option>
                    		<?php	$hscquery = $this->efiling_model->data_list('master_psstatus');
                    	       foreach ($hscquery as $row ){ ?>
                    			<option value="<?php echo htmlspecialchars($row->state_code);?>"><?php echo htmlspecialchars($row->state_name);?></option>
                     		<?php } ?>
                	   </select>
                    </div>
        		</div>
        		  <div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span> District: </label>
                        <select name="ddistrict1" class="form-control" id="ddistrict1">
                        	<option selected="selected">Select District Name</option>
                    	</select>
                    </div>
        		</div>
           </div>
            	       
           <div class="row">  	
        	    <div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span> Pincode: </label>
                       <input type="text" name="pincode1" value="<?php echo htmlspecialchars( isset($pinCode)?$pinCode:'');?>" id="pincode1" class="form-control" onkeypress="return isNumberKey(event)"maxlength="6" />
                    </div>
        		</div>
        		<div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span> Mobile Number: </label>
                       <input type="text" name="petmobile1" id="petmobile1" class="form-control"  onkeypress="return isNumberKey(event)"maxlength="10" value=""/>
                    </div>
        		</div>
        		<div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span>Phone Number: </label>
                       <input type="text" name="petPhone1" id="petPhone1" class="form-control" maxlength="11"  value="<?php echo htmlspecialchars( isset($petPhone)?$petPhone:''); ?>" onkeypress="return isNumberKey(event)"/>
                    </div>
        		</div>
           </div>		   
           <div class="row">  	
        	    <div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span>Email ID: </label>
                       <input type="text" name="petEmail1" id="petEmail1" class="form-control" value="" />
                    </div>
        		</div>
        		
        		 <div class="col-md-4">
            		<div class="form-group required">
                		<label><span class="custom"><font color="red">*</font></span>Fax No: </label>
                       <input type="text" name="petFax1" id="petFax1" class="form-control" value="" maxlength="11"  onkeypress="return isNumberKey(event)"/>
                    </div>
        		</div>
           </div>
     
        
        <div class="col-md-12" id="condetail">
	      <legend class="customlavelsub">Council Details</legend>
	            <div class="row">  	
	               <?php
                        $adv_master_advocate =$this->efiling_model->data_list_where('master_advocate','adv_code',$pet_adv_id);                                   
                        foreach ($adv_master_advocate as $row) {
                            $stateCode = $row->state_code;
                            $distcode = $row->adv_dist;
                        }
                        $st_master_psstatus =$this->efiling_model->data_list_where('master_psstatus','state_code',$stateCode); 
                        $statename = $st_master_psstatus[0]->state_name;
                        $statename = $st_master_psstatus[0]->state_name;
                        if ($distcode != "") {
                            $dat=array('state_code'=>$stateCode,'district_code'=>$distcode);
                            $stdit_master_psdist =$this->efiling_model->select_in('master_psdist',$dat); 
                            $distname = $stdit_master_psdist[0]->district_name;
              
                        }
                    ?>
        		    <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Counsel Name: </label>
                           <select name="councilCode" class="form-control" id="councilCode" onchange="showUserOrg(this.value)">
                                <option value="">Select Council Name</option>
                                <?php
                                $adv = $this->efiling_model->data_list('master_advocate'); 
                                foreach($adv as $row) {
                                    $selected = '';
                                    if ($pet_adv_id == $row->adv_code) {
                                        $selected = 'selected';
                                    }?>
                                    <option <?php echo $selected; ?>value="<?php echo htmlspecialchars($row->adv_code); ?>"><?php echo htmlspecialchars($row->adv_name . '(' . $row->adv_reg . ')'); ?></option>
                                    <?php }  ?>
                            </select>
                        </div>
        			</div>
        			<div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Address Of Counsel: </label>
                            <textarea name="counselAdd" readonly id="counselAdd" class="form-control"   cols="25"><?php echo htmlspecialchars(isset($pet_cou_addm)?$pet_cou_addm:''); ?></textarea>
                        </div>
        			</div>
        			<div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>State Name : </label>
                            <input type="text" name="dstatename" readonly id="dstatename" class="form-control" maxlength="50"  value="<?php echo htmlspecialchars($statename); ?>"/>
                            <input type="hidden" name="cdstate" readonly id="cdstate" class="txt"  maxlength="50" value="<?php echo htmlspecialchars(isset($dstate)?$dstate:''); ?>"/>
                        </div>
        			</div>
	            </div>
	            <div class="row"> 
	               <div class="col-md-4">
                		<div class="form-group required">
							<input type="hidden" name="cddistrict" id="cddistrict" value=""> 
                    		<label><span class="custom"><font color="red">*</font></span>District : </label>
                            <input type="text" name="ddistrictname"  id="ddistrictname" class="form-control" maxlength="50" value="<?php echo htmlspecialchars($distname); ?>" readonly>
                        </div>
        			</div>
        			 <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Pincode : </label>
                           <input type="text" name="counselPin" readonly  value="<?php echo htmlspecialchars(isset($pet_cou_pinm)?$pet_cou_pinm:''); ?>"  id="counselPin" class="form-control"  onkeypress="return isNumberKey(event)" maxlength="6"/>
                        </div>
        			</div>	
        			  <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Fax No: </label>
                            <input type="text" name="counselFax" readonly id="counselFax"  class="form-control" value="<?php echo isset($pet_cou_faxm)?$pet_cou_faxm:''; ?>" maxlength="11"  onkeypress="return isNumberKey(event)"/>
                        </div>
        			</div>
				</div>
				<div class="row"> 
	               <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Mobile Number : </label>
                            <input type="text" readonly name="counselMobile"   id="counselMobile" class="form-control" maxlength="10"   value="<?php echo htmlspecialchars(isset($pet_cou_mobm)?$pet_cou_mobm:''); ?>" onkeypress="return isNumberKey(event)"/>
                        </div>
        			</div>
        			 <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Phone Number : </label>
                            <input type="text" readonly name="counselPhone" id="counselPhone" class="form-control" maxlength="11" value="<?php echo htmlspecialchars(isset($pet_cou_phnm)?$pet_cou_phnm:''); ?>"  onkeypress="return isNumberKey(event)"/>
                        </div>
        			</div> 	 
        			 <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Email ID : </label>
                            <input type="text" readonly name="counselEmail" id="counselEmail" class="form-control" value="<?php echo htmlspecialchars(isset($pet_cou_emailm)?$pet_cou_emailm:''); ?>"/>
                        </div>
        			</div>	
				</div>
				<div style="float:right">
           			<input type="button" name="nextsubmit" id="nextsubmit" value="Add More Counsel" class="btn1" onclick="addMoreCouncel();">
      			</div>
      			<div id="advlisting"></div>
    		</fieldset>
     	</div>
   
<?php  } ?>