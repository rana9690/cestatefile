<?php
if($_REQUEST['party_flag']!='3'){
    $filing_no=$_REQUEST['filing_no'];
?>

<?php 
    $st =$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);

    $filing_no = htmlspecialchars($st->filing_no);
            $petName = isset($st[0]->pet_name)?$st[0]->pet_name:'';
            $resName = isset($st[0]->res_name)?$st[0]->res_name:'';
            $fDate = isset($st[0]->dt_of_filing)?$st[0]->dt_of_filing:'';
            ?>

<div class="">
     <div class="col-sm-6">
                <div><label for="order_date"><span class="custom"><font color="red">*</font>Order Date Challange in this Petition :</span></label></div>
                <input type="text" name="order_date" value="09/09/2020" id="order_date" class="form-control alert-danger datepicker" readonly="true" onclick="get_date1(this);" style="max-width: 160px;" required="true">
            </div>
    <table datatable="ng" id="examples"
           class="table table-striped table-bordered" cellspacing="0"
           width="100%">
        <tbody>
        <?php
        $st =$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
        foreach($st as $row) {
            $filing_no = htmlspecialchars($row->filing_no);
            $petName = $row->pet_name;
             $resName = $row->res_name;
            $fDate = $row->dt_of_filing;
            $dateOfFiling = explode("-", $fDate);
            $statu = $row->status;
            if ($statu == 'P')
                $statusName = 'Pending';
            if ($statu == 'D')
                $statusName = 'Disposal';
        } ?>
<tr>
<td>
    <?php
    if ($_REQUEST['party_flag'] == 1) {
        echo $petName.' (A-1)';
    }
    if ($_REQUEST['party_flag'] == 2) {
        echo $resName. '(R-1)';
    } 
    
    $reffrenceno= $this->session->userdata('reffrenceno');
    if($reffrenceno!=''){
        $refdetail= $this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$reffrenceno); 
        $partyids=explode(',',$refdetail[0]->party_ids);
        if($partyids[0]=='1'){
            $vals='checked';
        }
        $OtherFeeCode=explode(',',$refdetail[0]->otherFeeCode);
        
        $totalNoAnnexure=$refdetail[0]->totalNoAnnexure;
        $matter=$refdetail[0]->matter;
    }
    
    ?>
    <input type="checkbox" name="patyAddId_review_pe" id="patyAddId_review_pe"   value="1" <?php echo $vals; ?>>
</td>
</tr>
        <?php 
        $noOfParty = 0;
        $addParty = $this->efilingaction_model->getPartydetail($_REQUEST['filing_no'],$_REQUEST['party_flag']);
        $i = 2;
        foreach ($addParty as $row) {
            $partyName = $row->pet_name;
            $id = $row->party_id;
            $flag = $row->party_flag;
            $partysrno= $row->partysrno;

            echo " <tr>";
            ?>
            <td><?php echo $partyName;
                if ($flag == 1) {
                    echo '(A-' . $partysrno . ')';
                }
                if ($flag == 2) {
                    echo '(R-' . $partysrno . ')';
                } ?>&nbsp;&nbsp; &nbsp; <input type="checkbox" name="patyAddId_review_pe" id="patyAddId_review_pe"
                                               value="<?php echo $id; ?>"></td>
            <?php
            echo " <tr>";
            $noOfParty++;
        }
        ?>
        </tbody>
    </table>
</div>




<fieldset id="condetail" style="display: block; margin-top:12px;border: 2px solid #4cb060;"> <legend class="customlavelsub">Counsel Details</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label><span class="text-danger">*</span>Counsel Name :</label>
             <?php
             $pet_council_adv=$app[0]->pet_council_adv; 
             $councilname= $this->efiling_model->data_list('master_advocate');
             $councilname1[]='- Please Select state-';
             foreach ($councilname as $val)
                 $councilname1[$val->adv_code] = $val->adv_name; 
                 echo form_dropdown('councilCode',$councilname1,$pet_council_adv,['class'=>'form-control','onchange'=>'showUserOrg(this.value)', 'id'=>'councilCode','required'=>'true','required'=>'true']); 
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label><span class="text-danger">*</span>District</label>   
                 <?php
                 $c_pet_district=  $this->efiling_model->data_list('master_advocate','adv_code',$pet_council_adv); 
                 $cdisrName= $c_pet_district[0]->adv_dist; 
                 $cpetdis=  $this->efiling_model->data_list_where('master_psdist','district_code',$cdisrName); 
                 
                 ?>
                <input type="hidden" name="cddistrict" readonly="" id="cddistrict" class="txt" maxlength="50" value="<?php echo $c_pet_district[0]->adv_dist; ?>">                                 
				<?= form_input(['name'=>'ddistrictname','value'=>$cpetdis[0]->district_name,'class'=>'form-control','id'=>'ddistrictname','placeholder'=>'ddistrictname','maxlength'=>'100','required'=>'true', 'title'=>'District Name should be Alfa numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Phone Number:</label>
                 <?php  $counsel_phone= $app[0]->counsel_phone; ?>
                <?= form_input(['name'=>'counselPhone','value'=>$counsel_phone,'class'=>'form-control','id'=>'counselPhone','placeholder'=>'Counsel Phone','pattern'=>'[0-9]{1,12}','maxlength'=>'10','title'=>'Counsel Phone should be numeric only.']) ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>Address Of Counsel:</label>
                <?php  $counsel_add= $app[0]->counsel_add; ?>
                <?= form_textarea(['name'=>'counselAdd','value'=>$counsel_add, 'class'=>'form-control','id'=>'counselAdd','rows' => '2','cols'=>'2','placeholder'=>'Counsel Address','maxlength'=>'200','title'=>' Counsel Add only alphanumeric ']) ?>
            </div>
        </div>
    
        <div class="col-md-4">
            <div class="form-group required">
                <label>Pincode:</label>
                    <?php  $counsel_pin= $app[0]->counsel_pin; ?>
                <?= form_input(['name'=>'counselPin','value'=>$counsel_pin,'class'=>'form-control','id'=>'counselPin','placeholder'=>'Counsel Pin','maxlength'=>'200','title'=>'Counsel Pin allowed only alphanumeric ']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Email ID:</label>
                <?php  $counsel_email= $app[0]->counsel_email; ?>
                <?= form_input(['name'=>'counselEmail','value'=>$counsel_email,'class'=>'form-control','id'=>'counselEmail','placeholder'=>'Counsel Email','maxlength'=>'200','title'=>'Counsel Email allowed only alphanumeric ']) ?>
            </div>
        </div>
    </div>
    
    
     <div class="row">
        <div class="col-md-4">
            <div class="form-group required">
                <label>State Name  :</label>
               <?php   $c_pet_state=  $this->efiling_model->data_list('master_advocate','adv_code',$pet_council_adv); 
               $statecode= $c_pet_state[0]->state_code; 
               $cstate=  $this->efiling_model->data_list_where('master_psstatus','state_code',$statecode);
               
               ?>
                <input type="hidden" name="cdstate" readonly="" id="cdstate" class="txt" maxlength="50" value="<?php echo $cstate[0]->code?>">
             <?= form_input(['name'=>'dstatename','value'=> $cstate[0]->state_name,'class'=>'form-control','id'=>'dstatename', 'placeholder'=>'State name','maxlength'=>'200','title'=>' Counsel District name should be alphanumeric.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Mobile Number:</label>
                 <?php  $counsel_mobile= $app[0]->counsel_mobile; ?>                                
				<?= form_input(['name'=>'counselMobile','value'=>$counsel_mobile,'class'=>'form-control', 'id'=>'counselMobile', 'placeholder'=>'Mobile No','pattern'=>'[0-9]{1,12}','maxlength'=>'200','title'=>' Counsel Mobile Number should be numeric only.']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group required">
                <label>Fax No:</label>
                 <?php  $counsel_fax= $app[0]->counsel_fax; ?>       
                <?= form_input(['name'=>'counselFax','value'=>$counsel_fax,'class'=>'form-control','id'=>'counselFax','placeholder'=>'Fax No','pattern'=>'[0-9]{1,12}','maxlength'=>'200','title'=>' Counsel Fax No should be numeric only.']) ?>
            </div>
        </div>
    </div>
</fieldset>


<fieldset id="annId_<?php echo $_REQUEST['type']; ?>" style="display: block">
    <legend class="customlavelsub">Annexure Fee Details</legend>
    <div class="table-responsive">
        <table datatable="ng" id="examples"
               class="table table-striped table-bordered" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th></th>
                <th>Unique Id</th>
                <th>Fee Document Name</th>
                <th>Fee</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $aDetail = $this->efiling_model->data_list('master_fee_detail');
            $fgfg = 1;
            $i = 0;
            foreach($aDetail as $row) {
                $val='Checked';
              /*   if($OtherFeeCode[$i]==$row->doc_code){
                    $val='Checked';
                } */
                ?>
                <tr>
                    <td> <?php echo $fgfg; ?></td>
                    <td><input type="checkbox" name="otherFeeCode" value="<?php echo $row->doc_code; ?>" <?php echo $val;?> disabled></td>
                    <td><?php echo htmlspecialchars($row->doc_code); ?> </td>
                    <td> <?php echo htmlspecialchars($row->doc_name); ?></td>
                    <td> <?php echo htmlspecialchars($row->doc_fee); ?></td>
                </tr>
                <?php $fgfg++;
                $i++;
            } ?>
            </tbody>
        </table>
    </div>

    <div class="col-sm-12 div-padd">
        <div class="col-sm-6 div-padd">
            <div><label for="phone"><span class="custom"><font color="red">*</font>Total No Of Annexure:</span></label>
            </div>
            <div id="phone">
            <input type="text" name="totalNoAnnexure" id="totalNoAnnexure" class="form-control" maxlength="3"  value="<?php echo $totalNoAnnexure; ?>" onkeypress="return isNumberKey(event)"/></div>
        </div>

        <div class="col-sm-6 div-padd">
            <div><label for="name"><span class="custom"><font color="red">*</font></span>Matter </label></div>
            <div><textarea rows="4" cols="50" name="matter" id="matter" class="form-control"><?php echo $matter; ?></textarea></div>
            <input type="hidden" value="<?php echo $_REQUEST['filing_no']; ?>" name="filingOn">
        </div>

      <div class="col-sm-12 div-padd">
            <br>
            <?php
            $type_filing = $_REQUEST['type'];
            $type_function= '';
            if ($_REQUEST['type'] == 'contempt') {
                $type_function = 'parity_contempt()';
            } else if ($_REQUEST['type'] == 'execution') {
                $type_function = 'parity_execution()';
            } else if ($_REQUEST['type'] == 'review') {
                $type_function = 'parity()';
            }
            ?>
            <div style="float:right"><input type="button" name="nextsubmit" id="nextsubmit" value="Save & Next" class="btn btn-info " onclick="<?php echo $type_function; ?>"/></div>
        </div>
    </div>
</fieldset>
<?php }else if($_REQUEST['party_flag']=='3'){  ?>
    <div  class="col-md-12" id="annId_review">

 <div class="col-sm-6">
                <div><label for="order_date"><span class="custom"><font color="red">*</font>Order Date Challange in this Petition :</span></label></div>
                <input type="text" name="order_date" value="09/09/2020" id="order_date" class="form-control alert-danger datepicker" readonly="true" onclick="get_date(this);" style="max-width: 160px;" required="true">
            </div>


    	 <fieldset  style="padding-right: 0px;"><legend class="customlavelsub">Third Party Details</legend>
              <div class="row">
                	<div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Select Organization :</label>
                            <select name="select_org_app1" class="form-control" id="select_org_app1" onchange="apple_org_details_ia1(this.value)">
                                <option value="">Select Org Name</option>
                                <?php 
                                $hscquerytttt = $this->efiling_model->data_list('master_org');
                                foreach ($hscquerytttt as $row) {
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row->org_id); ?>"><?php echo htmlspecialchars($row->orgdisp_name); ?></option>
                                    <?php }  ?>
                            </select>
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
                           <input type="text" name="pincode1" value="<?php echo htmlspecialchars( $pinCode);?>" id="pincode1" class="form-control" onkeypress="return isNumberKey(event)"maxlength="6" />
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
                           <input type="text" name="petPhone1" id="petPhone1" class="form-control" maxlength="11"  value="<?php echo htmlspecialchars( $petPhone); ?>" onkeypress="return isNumberKey(event)"/>
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
           </fieldset>
        </div>
        <div class="col-md-12" id="condetail">
	        <fieldset style="padding-right: 0px;"><legend class="customlavelsub">Council Details</legend>
	            <div class="row">  	
	               <?php
                        $adv_master_advocate =$this->efiling_model->data_list_where('master_advocate','adv_code',$pet_adv_id);                                   
                        
                        foreach ($adv_master_advocate as $row) {
                            $stateCode = $row->state_code;
                            $distcode = $row->adv_dist;
                        }
                        $st_master_psstatus =$this->efiling_model->data_list_where('master_psstatus','state_code',$stateCode); 
                        $statename = $st_master_psstatus[0]->state_name;
                        if ($distcode != "") {
                            $dat=array('state_code'=>$stateCode,'district_code'=>district_code);
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
                                    }
                                    ?>
                                    <option <?php echo $selected; ?>value="<?php echo htmlspecialchars($row->adv_code); ?>"><?php echo htmlspecialchars($row->adv_name . '(' . $row->adv_reg . ')'); ?></option>
                                    <?php }  ?>
                            </select>
                        </div>
        			</div>
        			<div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Address Of Counsel: </label>
                            <textarea name="counselAdd" readonly id="counselAdd" class="form-control"   cols="25"><?php echo htmlspecialchars($pet_cou_addm); ?></textarea>
                        </div>
        			</div>
        			<div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>State Name : </label>
                            <input type="text" name="dstatename" readonly id="dstatename" class="form-control" maxlength="50"  value="<?php echo htmlspecialchars($statename); ?>"/>
                            <input type="hidden" name="cdstate" readonly id="cdstate" class="txt"  maxlength="50" value="<?php echo htmlspecialchars($dstate); ?>"/>
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
                           <input type="text" name="counselPin" readonly  value="<?php echo htmlspecialchars($pet_cou_pinm); ?>"  id="counselPin" class="form-control"  onkeypress="return isNumberKey(event)" maxlength="6"/>
                        </div>
        			</div>	
        			  <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Fax No: </label>
                            <input type="text" name="counselFax" readonly id="counselFax"  class="form-control" value="<?php echo $pet_cou_faxm; ?>" maxlength="11"  onkeypress="return isNumberKey(event)"/>
                        </div>
        			</div>
				</div>
				<div class="row"> 
	               <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Mobile Number : </label>
                            <input type="text" readonly name="counselMobile"   id="counselMobile" class="form-control" maxlength="10"   value="<?php echo htmlspecialchars($pet_cou_mobm); ?>" onkeypress="return isNumberKey(event)"/>
                        </div>
        			</div>
        			 <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Phone Number : </label>
                            <input type="text" readonly name="counselPhone" id="counselPhone" class="form-control" maxlength="11" value="<?php echo htmlspecialchars($pet_cou_phnm); ?>"  onkeypress="return isNumberKey(event)"/>
                        </div>
        			</div> 	 
        			 <div class="col-md-4">
                		<div class="form-group required">
                    		<label><span class="custom"><font color="red">*</font></span>Email ID : </label>
                            <input type="text" readonly name="counselEmail" id="counselEmail" class="form-control" value="<?php echo htmlspecialchars($pet_cou_emailm); ?>"/>
                        </div>
        			</div>	
				</div>
		
		 	
     
      <div class="col-md-12">
	       <div class="row">  
                <div class="col-lg-4">
                   <label for="phone"><span class="custom"><font color="red">*</font>Total No Of Annexure:</span></label>
                   <input type="text" name="totalNoAnnexure" id="totalNoAnnexure" class="form-control" maxlength="3"  value="" onkeypress="return isNumberKey(event)"/>
                </div>
        
                <div class="col-lg-4">
                    <label for="name"><span class="custom"><font color="red">*</font></span>Matter </label>
                    <textarea rows="4" cols="50" name="matter" id="matter" class="form-control"></textarea>
                    <input type="hidden" value="<?php echo $_REQUEST['filing_no']; ?>" name="filingOn">
                </div>                         
    		</div>
       </div>  
       
       <div class="col-sm-12 div-padd">
        <br>
        <?php
        $type_filing = $_REQUEST['type'];
        $type_function= '';
        if ($_REQUEST['type'] == 'contempt') {
            $type_function = 'parity_contempt()';
        } else if ($_REQUEST['type'] == 'execution') {
            $type_function = 'parity_execution()';
        } else if ($_REQUEST['type'] == 'review') {
            $type_function = 'parity()';
        }
        ?>
        <div style="float:right" ><input type="button" name="nextsubmit" id="nextsubmit" value="Save & Next" class="btn btn-info" onclick="<?php echo $type_function; ?>"/></div>
    </div>
     </div>
     </fieldset>
<?php  } ?>
  
  
  <script>
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
	  
  </script>