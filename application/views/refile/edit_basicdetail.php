<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php

$refiling= $this->session->userdata('refiling_no');
$rowd= $this->efiling_model->data_list_where('table_defecttabopen','filing_no',$refiling);
if(!empty($rowd) && is_array($rowd)){
    $numbers=explode(',',$rowd[0]->tabvals);
    $numbers = array_diff($numbers, [0]);
    //$numbers=json_decode($rowd[0]->tabvals);
    sort($numbers);
    $arrlength=count($numbers);
    $vals=array();
    for($x=0;$x<$arrlength;$x++){
        $vals[]=  $numbers[$x] ;
    }

    $num='4';
    $i=1;
    $valrr='';
    foreach($vals as $key=>$val){
        if($val > $num){
            if($valrr==''){
                $valrr= $val;
            }
        }
        $i++;
    }
	
    
    if($valrr==1){
        $urlv="applicant-mod";
    }
    if($valrr==2){
        $urlv="respondentRefile";
    }
    if($valrr==3){
        $urlv="counselrefile";
    }
	if($valrr==4){
        $urlv="basicdetails-mod";
    }
    if($valrr==5){
        $urlv="ia_detailrefile";
    }

    if($valrr==6){
        $urlv="editother_fee";
    }
    if($valrr==7){
        $urlv="documentuploadedit";
    }
    if($valrr==8){
        $urlv="paymentmodeedit";
    }
}
?>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script> 
<style>
.srchWrap {
    margin-left: 194px;
    position: relative;
    float: right;
    width: 100%;
    margin-right: 10px;
}
.srchWrap input {
    padding-left: 35px;
    font-size: 16px;
}
.srchWrap input:focus {
    border: 1px solid #2196f3 !important;
}
.srchWrap i {
    position: absolute;
    left: 12px;
    top: 14px;
}
.error {
    color: red;
}
</style>

<?php  
    $this->load->view("admin/stepsrefile");
    
    $userdata=$this->session->userdata('login_success');
    $user_id=$userdata[0]->id;
    $salt= $this->session->userdata('refiling_no');
    $token= $this->efiling_model->getToken();
    $basic= $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$salt);
    $impuned=0;
    if((int)$salt > 0) :;
        $datacomm=$this->efiling_model->data_list_commission('additional_commision',['created_user'=>$user_id,'filing_no'=>$salt]);
        if(!empty($datacomm) && is_array($datacomm)) $impuned=count($datacomm);
    endif;
?>
<div class="content" style="padding:0px">
    <div class="row">
        <div class="card checklistSec">
            <div class="col-md-12 mx-0">
                <?= form_open('edit-basic-details',['class'=>'wizard-form steps-basic wizard clearfix','id'=>'basicform','autocomplete'=>'off']) ?>

                <ul id="progressbarmini" data-target="<?=$urlv?>">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                <div class="content clearfix">
                <?= form_fieldset("<i class='icon-plus-circle2 text-danger d-none'></i> Page 1 <div class='date-div text-success'>Date & Time : &nbsp;<small>".date('D M d, Y H:i:s')."&nbsp;IST</small></div>",['id'=>'111']).
                '<div class="date-div text-success d-none">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
                ?>

					<div class="col-lg-12">
						<div class="row">
                                    <input type="hidden"  id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
                                    <input type="hidden"  id="tabno" name="tabno" value="<?php echo '1'; ?>">
                                    <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
       							   <div class="col-lg-4">
                                        <div class="form-card">
                                            <div class="form-group">
                                              	<label class="control-label" for="bench"><span class="custom"><font color="red">*</font></span>Principal / Circuit  Bench  </label>
                                             <div class="input-group mb-3 mb-md-0">
                                                   <?php
                                                   $bench= $this->db->get('master_benches')->result();
                                             //   echo "<pre>";   print_r($bench);die;
                                                   $bench1=[''=>'-Please Select bench-'];
                                                   $benchval=isset($basic[0]->bench)?$basic[0]->bench:'';
                                                   if($benchval==''){
                                                       $benchval='100';
                                                   }
                                                   foreach ($bench as $val)
                                                       $bench1[$val->bench_code] = $val->name;
                                                       echo form_dropdown('bench',$bench1,$benchval,['class'=>'form-control','id'=>'bench','required'=>'true','disabled'=>true]);
                                                 ?>
                                              </div>
                                            </div>
                                        </div> 
                                        <div class="form-card">
                                            <div class="form-group">
                                              	  <label class="control-label" for="act"><span class="custom"><font color="red">*</font></span>Act</label>
                                                  <div class="input-group mb-3 mb-md-0">
                                                     <?php

                                                     $ac=isset($basic[0]->pet_section)?$basic[0]->pet_section:'';
                                                          $act1= $this->efiling_model->data_list('master_energy_act','act_short_name','act_code');
                                                          $act=[''=>'-Please Select Act-'];
                                                          foreach ($act1 as $val)
                                                              $act[$val->act_code] = $val->act_short_name;  
                                                              echo form_dropdown('act',$act,$ac,['class'=>'form-control','id'=>'act','onchange'=>'getUnderSection(this)','required'=>'true']);
                                                       ?>
                                                  </div>
                                            </div>
											
                                             <!--div class="form-card">
                                                <div class="form-group">
                                                  	<label class="control-label" for="totalNoAnnexure"><span class="custom"><font color="red">*</font></span>Total No. of Annexures:</label>
                                                  	<div class="input-group mb-3 mb-md-0">
                                                  	<?php $totalNoAnnexureval=isset($basic[0]->no_of_pet)?$basic[0]->no_of_pet:''; ?>
                                                  	 <? //= form_input(['name'=>'totalNoAnnexure','value'=>$totalNoAnnexureval,'class'=>'form-control','onkeypress'=>'return isNumberKey(event)','id'=>'totalNoAnnexure','placeholder'=>'Total No Annexure','pattern'=>'[0-9]{1,3}','maxlength'=>'3','required'=>'true','title'=>'Total No Annexure should be  numeric only.']) ?>
                                                  	</div>
                                                </div>
                                             </div-->
                                        </div>   
                                    </div>
                                    
                                     <div class="col-lg-4">  
                                         <!--div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="subBench"><span class="custom"><font color="red">*</font></span>Jurisdiction:</label>
                                              <div class="input-group mb-3 mb-md-0">
                                               <?php
                                               /*$jurisdiction= $this->efiling_model->data_list('master_psstatus');
                                               $jurisdiction1=[''=>'-Please Select Jurisdiction-']; 
                                               $subBenchval=isset($basic[0]->sub_bench)?$basic[0]->sub_bench:'';
                                               if($subBenchval==''){
                                                   $subBenchval='1';
                                               }
                                               foreach ($jurisdiction as $val)
                                                   $jurisdiction1[$val->state_code] = $val->state_name;  
                                                   echo form_dropdown('subBench',$jurisdiction1,$subBenchval,['class'=>'form-control','id'=>'subBench','required'=>'true']); 
                                                 */?>
                                              </div>
                                            </div>
                                        </div-->
										<div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="caseType"><span class="custom"><font color="red">*</font></span>Case Type:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                        <?php
                                                        $caseType=isset($basic[0]->case_type)?$basic[0]->case_type:''; //refile variable
                                                        
                                                        $caseTypeval=isset($basic[0]->l_case_type)?$basic[0]->l_case_type:$caseType;
                                                        $CaseType= $this->efiling_model->getCaseType();
                                                        $casetype1=[''=>'-Please Select Case Type-'];
                                                        foreach ($CaseType as $val)
                                                            $casetype1[$val->case_type_code] = $val->case_type_name.' - '.$val->short_name;  
                                                            echo form_dropdown('caseType',$casetype1,$caseTypeval,['class'=>'form-control','id'=>'caseType','required'=>'true']); 
                                                     ?>
                                              	</div>
                                            </div>
                                        </div>
										<div class="form-card">
                                              <div class="form-group">
                                              	<label class="control-label" for="petSection"><span class="custom"><font color="red">*</font></span>
												<?=$this->lang->line('section')?>:</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                     <?php
                                                     $pet_section=isset($basic[0]->pet_sub_section)?$basic[0]->pet_sub_section:'';
                                                     $petsectionval=isset($basic[0]->petsection)?$basic[0]->petsection:$pet_section;
                                                     echo form_dropdown('petSection','-Select Under Section-',$petsectionval,['class'=>'form-control','id'=>'petSection','required'=>'true']); 
                                                     ?>
                                              	</div>
                                            </div>
											
                                        </div>
                                       	
                                     </div>
                                    <div class="col-lg-4">
                                        
                                        
                                         <div class="form-card" style="display:none;">
                                              <div class="form-group">
                                              	<label class="control-label" for="petSubSection1"><font color="red">*</font>Under Sub-section :</label>
                                              	<div class="input-group mb-3 mb-md-0">
                                                  <?php
                                                  $petsubsectionval=isset($basic[0]->petsubsection)?$basic[0]->petsubsection:'';
                                                  $sub_pet_section=isset($basic[0]->sub_pet_section)?$basic[0]->sub_pet_section:'';
                                                  if($petsubsectionval=='' && $sub_pet_section!=''){
                                                      $petsubsectionval= $sub_pet_section;
                                                  }
                                                        $data_array=['1'=>'1 &amp; 2'];
                                                        echo form_dropdown('petSubSection1',$data_array,$petsubsectionval,['class'=>'form-control','id'=>'petSubSection1']); 
                                                     ?>
                                              	</div>
                                            </div>
                                        </div>  
                                    </div>
               					</div>               					
       						</div>
							
							
							
<div class="col-md-12 applicant-border-styles ">
	<div class="row">                            
			<div class="col-md-4 hidecode23" style="display:<?php if($case_type=='2' || $case_type=='3'): echo 'block';else: echo 'none'; endif;?>">
				<div class="form-group required">
					<label>Asseesse Code:</label>

					<?= form_input(['name'=>'ass_code','value'=>$ass_code,'class'=>'form-control', 'id'=>'ass_code','placeholder'=>'','maxlength'=>'20']) ?>
				</div>
			</div>								   
			<div  class="col-md-4 hidecode1" style="display:<?php if($case_type=='1'): echo 'block';else: echo 'none'; endif;?>">
				<div class="form-group required">
					<label>Location Code:</label>

					<?= form_input(['name'=>'loc_code','value'=>$loc_code,'class'=>'form-control','id'=>'loc_code','placeholder'=>'','maxlength'=>'20']) ?>
				</div>
			</div>
			<div  class="col-md-4 hidecode1" style="display:<?php if($case_type=='1'): echo 'block';else: echo 'none'; endif;?>">
				<div class="form-group required">
					<label>IE Code:</label>

					<?= form_input(['name'=>'iec_code','value'=>$iec_code,'class'=>'form-control','id'=>'iec_code','placeholder'=>'','maxlength'=>'20']) ?>
				</div>
			</div>
		
			<div  class="col-md-4 hidecode3" style="display:<?php if($case_type=='3'): echo 'block';else: echo 'none'; endif;?>">
				<div class="form-group required">
					<label>Premises Code:</label>

					<?= form_input(['name'=>'pre_code','value'=>$pre_code,'class'=>'form-control','id'=>'pre_code','placeholder'=>'','maxlength'=>'20']) ?>
				</div>
			</div>
		
			<div  class="col-md-4 hidecode2" style="display:<?php if($case_type=='2'): echo 'block';else: echo 'none'; endif;?>">
				<div class="form-group required">
					<label>Location Code:</label>

					<?= form_input(['name'=>'locc_code','value'=>$locc_code,'class'=>'form-control','id'=>'locc_code','placeholder'=>'','maxlength'=>'20']) ?>
				</div>
			</div>
	   
			<div class="col-md-4 hidecode4" style="display:  <?php if($case_type!='4' && $case_type!=''): echo 'none';else: echo 'none'; endif;?>">
				<div class="form-group required">
					<label>PAN No. :</label>
					<?= form_input(['type'=>'hidden','name'=>'pan_code','class'=>'panEnc','value'=>set_value('pan_code')]) ?>
					<?= form_input(['class'=>'form-control upperinput inputpw','id'=>'pan_code','maxlength'=>10,'title'=>'']) ?>
				</div>
			</div>
		
	</div>
</div>
       						
       						
       					<?php 
       					
       					$petsubsectionval=isset($basic[0]->petsubsection)?$basic[0]->petsubsection:''; 
       					$comm =$this->efiling_model->data_list_where('additional_commision','filing_no',$salt);
       					$count=count($comm);
       					?>
       						
       						
       						<hr />
       						<div class="col-lg-12">
                                <h3 class="text-danger form-head ml-3"><?=$this->lang->line('commisionerateHeading')?></h3>
                                    <div class="row" style="display: none;">
                                        <div class="col-lg-4">
                                            <div class="form-card">
                                                <div class="form-group">
                                                        <label class="control-label" for="totalNoRespondent"><span class="custom"><font color="red">*</font></span>Total No. of Orders to be challenged :</label>
                                                    <div class="input-group mb-3 mb-md-0">
                                                        <?php   $no_of_impugned=$count; ?>
                                                        <?= form_input(['name'=>'totalNoImpugned','class'=>'form-control','id'=>'totalNoImpugned','value'=>(int)$no_of_impugned,'onkeypress'=>'return isNumberKey(event)' ,'placeholder'=>'Total No Impugned','pattern'=>'[0-9]{1,2}','maxlength'=>'1','title'=>'Total No Impugned should be numeric only.','type'=>'number','min'=>0]) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                
                                    <?php 
                                    $basiccomm='';
                                    $filing_no= $this->session->userdata('filingnosession');
                                    if($filing_no!=''){
                                        $basiccomm=  $this->efiling_model->data_list_where('lower_court_detail','filing_no',$filing_no);
                                    }                             
                                    ?>      
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-card">
                                                <div class="form-group">
                                                    <label class="control-label" for="commission"><span class="custom"><font color="red">*</font><?=$this->lang->line('commissionLabel')?>:</label>
                                                    <div class="input-group mb-3 mb-md-0">
                                                            <?php
															
                                                            $commissionval=isset($basic[0]->commission)?$basic[0]->commission:'';
                                                            $commission=isset($basiccomm[0]->commission)?$basiccomm[0]->commission:'';
                                                            if($commissionval=='' && $commission!=''){
                                                                $commissionval=isset($commission)?$commission:'';
                                                            }
                                                            $comval=explode('|', $commissionval);
															
                                                          
                                                            
                                                                echo form_dropdown('commission',$commisions,$comval[0],['class'=>'form-control','id'=>'commission']); 
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!--div class="form-card">
                                                <div class="form-group">
                                                    <label class="control-label" for="caseNo"><span class="custom"><font color="red">*</font>Petition Number:</label>
                                                    <div class="input-group mb-3 mb-md-0">
                                                    <?php   
                                                    /*$l_case_noval=isset($basic[0]->l_case_no)?$basic[0]->l_case_no:'';  
                                                    $case_no= $l_case_noval=isset($basiccomm[0]->case_no)?$basiccomm[0]->case_no:'';
                                                    if($l_case_noval=='' && $case_no!=''){
                                                        $l_case_noval=isset($case_no)?$case_no:'';
                                                    }
                                                    $l_case_noval=explode('|', $l_case_noval);
													*/
													?>	
                                                    <?//= form_input(['name'=>'caseNo','id'=>"caseNo",'value'=>$l_case_noval[0],'class'=>'form-control','placeholder'=>'case no','onkeypress'=>'return isNumberKey(event)','maxlength'=>'100','title'=>'caseNo should be numeric only.']) ?>
                                        
                                                    </div>
                                                </div>
                                            </div-->
											  <div class="form-card">
                                                <div class="form-group">
                                                        <label class="control-label" for="caseYear"><span class="custom"></span><font color="red">*</font>Date of Impugned Order:</label>
                                                        <div class="input-group mb-3 mb-md-0">
                                                        <?php                                                 
                                                        $l_datev=isset($basic[0]->l_date)?$basic[0]->l_date:''; 
                                                        $decision_date=isset($basiccomm[0]->decision_date)?$basiccomm[0]->decision_date:''; 
                                                        if($l_datev=='' && $decision_date!=''){
                                                            $l_datev=isset($decision_date)?$decision_date:''; 
                                                        }
                                                        $l_datev=explode('|', $l_datev); ?>
                                                        <?= form_input(['name'=>'ddate','value'=>$l_datev[0],'id'=>"ddate",'class'=>'form-control datepicker','placeholder'=>'Decision Date','title'=>'Communication Date Date.']) ?>  	
                                                        </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="form-card">
                                                <div class="form-group">
                                                    <label class="control-label" for="natureOrder"><span class="custom"><font color="red">*</font><?=$this->lang->line('natureOrder')?>:</label>
                                                    <div class="input-group mb-3 mb-md-0">
                                                            <?php
                                                            $nature_of_orderv=isset($basic[0]->nature_of_order)?$basic[0]->nature_of_order:'';  
                                                            $nature_of_order=isset($basiccomm[0]->nature_of_order)?$basiccomm[0]->nature_of_order:'';
                                                            if($nature_of_orderv=='' && $nature_of_order!=''){
                                                                $nature_of_orderv=isset($nature_of_order)?$nature_of_order:'';
                                                            }
                                                            $nature_of_orderv=explode('|', $nature_of_orderv);
                                                            
                                                                echo form_dropdown('natureOrder',$natureorders,$nature_of_orderv[0],['class'=>'form-control','id'=>'natureOrder']); 
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!--div class="form-card">
                                                <div class="form-group">
                                                        <label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font>Petition Year:</label>
                                                        <div class="input-group mb-3 mb-md-0">
                                                        <?php
                                                       /* $yearv=isset($basic[0]->l_case_year)?$basic[0]->l_case_year:''; 
                                                        $case_year=isset($basiccomm[0]->case_year)?$basiccomm[0]->case_year:'';
                                                        if($yearv=='' && $case_year!=''){
                                                            $yearv=isset($case_year)?$case_year:'';
                                                        }
                                                        $cyear=date('Y');
                                                        $yearv=explode('|', $yearv);
                                                        $year = $yearv[0];
                                                        if($year==''){ 
                                                            $year='2020';
                                                        }
                                                        $year1=[''=>'- Select Year -'];
                                                        for ($i = $cyear; $i > 2000; $i--) {
                                                            $year1[$i]=$i;
                                                        }
                                                        echo form_dropdown('caseYear',$year1,$year,['class'=>'form-control','id'=>'caseYear']); 
                                                        */?>
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
                                            </div-->
											<div class="form-card">
											
                                                <div class="form-group">
                                                    <label class="control-label" for="comDate"><?=$this->lang->line('commdate')?> :</label>
                                                    <div class="input-group mb-3 mb-md-0">
                                                    <?php   
                                                    $comm_dateval=isset($basic[0]->comm_date)?$basic[0]->comm_date:''; 
                                                    $communication_date=isset($basiccomm[0]->communication_date)?$basiccomm[0]->communication_date:'';
                                                    if($comm_dateval=='' && $communication_date!=''){
                                                        $comm_dateval=$communication_date;
                                                    }
                                                    $comd=explode('|', $comm_dateval);?>
                                                    <?= form_input(['name'=>'comDate','id'=>"comDate",'value'=>$comd[0],'class'=>'form-control datepicker','placeholder'=>'Communication Date','readonly'=>true,'title'=>'Communication Date Date.']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-4">
                                            <div class="form-card">
                                                <div class="form-group">
                                                    <label class="control-label" for="case_type_lower"><span class="custom"><font color="red">*</font><?=$this->lang->line('impugnedType')?>:</label>
                                                    <div class="input-group mb-3 mb-md-0">
                                                    <?php
                                                    $lower_case_typev=isset($basic[0]->lower_case_type)?$basic[0]->lower_case_type:'';  
                                                    $case_type=isset($basiccomm[0]->case_type)?$basiccomm[0]->case_type:'';
                                                    if($lower_case_typev=='' && $case_type!=''){
                                                        $lower_case_typev=isset($case_type)?$case_type:'';
                                                    }
                                                    $lower_case_typev=explode('|', $lower_case_typev);
                                                    $arrat=array('display'=>'TRUE', 'flag'=>'2' );
                                                    $lowercasetype= $this->efiling_model->data_list_mulwhere('master_case_type',$arrat);
                                                    $lowercasetype1=[''=>'- Select Case Type -'];
                                                    foreach ($lowercasetype as $val)
                                                        $lowercasetype1[$val->case_type_code] = $val->short_name;  
                                                        echo form_dropdown('case_type_lower',$impugnesArray,$lower_case_typev[0],['class'=>'form-control','id'=>'case_type_lower']);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>   
                                          
                                            
                                            <div class="form-card" id="anyOtherLower" style="display: none">
                                                <div class="form-group">
                                                    <label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Other Matter:</label>
                                                    <div><input type="text" name="anyOtherMatter" class="form-control" placeholder='Other matter' id="anyOtherMatter"></div>
                                                </div>
                                        </div>
                                            
                                    </div>
                                    <div>
                                    </div>
                                </div>
   						
                                <input type="hidden" name="cnt" id="cnt" value="<?php echo $impuned; ?>">
                                <fieldset id="testdiv_cavetor_details" style="display: none">
                                    <legend class="customlavelsub">Caveator Details</legend>
                                    <div class="col-sm-12 div-padd">
                                        <div class="col-sm-12 div-padd" id="caveator_details_data">
                                        </div>
                                    </div>                                
                                </fieldset>

                                <button type="button" class="btn btn-primary btn-cntr px-4" onclick="addMorerefile();">Add</button>

                                <div class="row inner-card" id="product">
                                
                                    <?php
                                
                                    $html='';
                                    $html.='
                                        <h3 class="text-danger form-head ml-3">Last add impugned details</h3>
                                        <table id="example" class="table display table-center" cellspacing="0" border="1" width="100%">
                                        <thead>
                                            <tr class="bg-dark">
                                                <th>Sr.No.</th>
                                                <th>'.$this->lang->line('commissionLabel').'</th>
                                                <th>'.$this->lang->line('natureOrder').'</th>
                                                <th>'.$this->lang->line('impugnedType').'</th>
                                                <th>'.$this->lang->line('impugnedOrderNo').'</th>
                                                <th>Impugn Date</th>
                                                <th>Edit</th>

                                            </tr>
                                        </thead>
                                        <tbody>';
                                    $comm =$this->efiling_model->data_list_where('case_detail_impugned','filing_no',$salt);
                                    
                                    if(!empty($comm)){
                                        $i=1;
                                        foreach($comm as $val){

                                            $nature_of_order=$val->iss_desig;
                                            $commission=$val->iss_org;
                                            $casetype=$val->impugn_type;
                                            if (is_numeric($nature_of_order)) {
                                               // $naturname=$this->efiling_model->data_list_where('master_nature_of_order','nature_code',$nature_of_order);
                                                //$natshort_name=$naturname[0]->short_name;
												$natshort_name=$natureorders[$nature_of_order];
                                            }
                                            if (is_numeric($commission)) {
                                             //   $comm=$this->efiling_model->data_list_where('master_commission','id',$commission);
                                                //$commname=$comm[0]->short_name;
												$commname=$commisions[$commission];
                                            }

                                            if (is_numeric($casetype)) {
                                            //    $caseT=$this->efiling_model->data_list_where('master_case_type','case_type_code',$casetype);
                                                //$casetype=$caseT[0]->short_name;
												$casetype=$impugnesArray[$casetype];
                                            }
                                            
                                            $html.='<tr id="tr'.$val->id.'>">
                                                    <td>'.$i.'</td>
                                                    <td>'.$commname.'</td>
                                                    <td>'.$natshort_name.'</td>
                                                    <td>'.$casetype.'</td>
                                                    <td>'.$val->impugn_no.'</td>
                                                   
                                                    <td>'.date('d-m-Y',strtotime($val->impugn_date)).'</td>
                                                    <td><input type="button" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editcomm('.$val->id.')">


                                                    </td>
                                                </tr>';
                                            $i++;
                                        }
                                        $html.='</tbody>
                                            </table>';
                                        echo $html;
                                    }
                                    ?>
                                </div>
   							</div>
                            
                            <!--div class="row">
                                <div class="offset-md-8 col-md-4">
                                    <?php
                                    /*if($salt =='') {
                                        echo form_submit(['value'=>'Save and Next','class'=>'btn btn-success','id'=>'nextsubmit','disabled'=>'disabled']);
                                    }
                                    elseif($salt) {		
                                        echo form_submit(['value'=>'Save and Next','class'=>'btn btn-success','id'=>'nextsubmit']);
                                    }

                                    echo  form_reset(['value'=>'Reset/Clear','class'=>'btn btn-danger']);*/
                                    ?>

                                </div>
                            </div-->
                    <input type="button" name="next" class="next btn btn-rt btn-success " value="Save & Next" />
                	    	<?= form_fieldset_close(); ?>


                    <?=form_fieldset("<i class='icon-plus-circle2 text-danger'></i> Page 2 ",['id'=>'112'])?>

                    <?php $this->load->view("admin/checkListCestat"); ?>
                    <input type="button" name="next" class="next btn-rt btn btn-success" value="Save & Next" />
                    <input type="button" name="previous" class="previous btn btn-warning btn-rt" value="Previous" />

                    <?= form_fieldset_close(); ?>

                    <?=form_fieldset("<i class='icon-plus-circle2 text-danger'></i> Page 3",['id'=>'113'])?>
                    <?php $this->load->view("admin/otherFeeDetail"); ?>

                    <!-- <input type="button" name="previous" class="previous action-button" value="Previous" />
                     <a href="" class="submit action-button" target="_top">Submit</a>-->
                    <input type="button" name="next" class="next btn-rt btn btn-success" value="Save & Next" />
                    <input type="button" name="previous" class="previous btn btn-warning btn-rt" value="Previous" />
                    <?= form_fieldset_close(); ?>
					
					
					 <?=form_fieldset("<i class='icon-plus-circle2 text-danger'></i> Page 4",['id'=>'114'])?>
                    <?php $this->load->view("admin/document_appealmemo"); ?>

                       <!-- <input type="button" name="previous" class="previous action-button" value="Previous" />
                        <a href="" class="submit action-button" target="_top">Submit</a>-->
                    <input type="button" name="next" class="next btn-rt btn btn-success" value="Save & Next" />
                    <input type="button" name="previous" class="previous btn btn-warning btn-rt" value="Previous" />
                    <?= form_fieldset_close(); ?>


 			
 					 <?= form_close();?>
                </div>
            </div>
       </div>
</div>	

























	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      	<div class="modal-dialog model-lg" role="document"  style="margin-top: 190px;">
        	<div class="modal-content">
              <div class="modal-header bg-warning">

                <h5 class="modal-title" id="exampleModalLabel">Edit <?=$this->lang->line('editCommisionerateHeading')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <input type="hidden" name="comm_id" id="comm_id" value="">
          	  <div class="modal-body">
            	<div class="col-lg-12">
                    <h4 class="text-danger form-head" style=""><?=$this->lang->line('editCommisionerateHeading')?></h4>
                    <?php 
                    $basiccomm='';
                    $filing_no= $this->session->userdata('filingnosession');
                    if($filing_no!=''){
                        $basiccomm=  $this->efiling_model->data_list_where('lower_court_detail','filing_no',$filing_no);
                    }                             
                     ?>      
        			<div class="row">
                        <div class="col-lg-4">
                            <div class="form-card">
                                <div class="form-group">
                                    <label class="control-label" for="commission"><span class="custom"><font color="red">*</font><?=$this->lang->line('commissionLabel')?>:</label>
                                    <div class="input-group mb-3 mb-md-0">
                                            <?php
                                            $commissionval=isset($basic[0]->commission)?$basic[0]->commission:'';
                                            $commission=isset($basiccomm[0]->commission)?$basiccomm[0]->commission:'';
                                            if($commissionval=='' && $commission!=''){
                                                $commissionval=isset($commission)?$commission:'';
                                            }
                                            $comval=explode('|', $commissionval);
                                          
                                                echo form_dropdown('edit_commission',$commisions,$comval[0],['class'=>'form-control','id'=>'edit_commission']); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-card">
                                <div class="form-group">
                                    <label class="control-label" for="caseNo"><span class="custom"><?=$this->lang->line('impugnedOrderNo')?>:</label>
                                    <div class="input-group mb-3 mb-md-0">
                                    <?php   
                                    $l_case_noval=isset($basic[0]->l_case_no)?$basic[0]->l_case_no:'';  
                                    $case_no= $l_case_noval=isset($basiccomm[0]->case_no)?$basiccomm[0]->case_no:'';
                                    if($l_case_noval=='' && $case_no!=''){
                                        $l_case_noval=isset($case_no)?$case_no:'';
                                    }
                                    $l_case_noval=explode('|', $l_case_noval);?>	
                                    <?= form_input(['name'=>'edit_caseNo','id'=>"edit_caseNo",'value'=>$l_case_noval[0],'class'=>'form-control','placeholder'=>'case no','onkeypress'=>'return isNumberKey(event)','maxlength'=>'100','title'=>'caseNo should be numeric only.']) ?>
                        
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    
                        <div class="col-lg-4">
                            <div class="form-card">
                                <div class="form-group">
                                    <label class="control-label" for="natureOrder"><span class="custom"><?=$this->lang->line('natureOrder')?>:</label>
                                    <div class="input-group mb-3 mb-md-0">
                                            <?php
                                            $nature_of_orderv=isset($basic[0]->nature_of_order)?$basic[0]->nature_of_order:'';  
                                            $nature_of_order=isset($basiccomm[0]->nature_of_order)?$basiccomm[0]->nature_of_order:'';
                                            if($nature_of_orderv=='' && $nature_of_order!=''){
                                                $nature_of_orderv=isset($nature_of_order)?$nature_of_order:'';
                                            }

                                                echo form_dropdown('edit_natureOrder',$natureorders,$nature_of_orderv[0],['class'=>'form-control','id'=>'edit_natureOrder']);
                                        ?>
                                    </div>
                                </div>
                            </div>
							<div class="form-card">
                                <div class="form-group">
                                        <label class="control-label" for="caseYear"><span class="custom"></span>Date of Impugned Order:</label>
                                        <div class="input-group mb-3 mb-md-0">
                                        <?php                                                 
                                        $l_datev=isset($basic[0]->l_date)?$basic[0]->l_date:''; 
                                        $decision_date=isset($basiccomm[0]->decision_date)?$basiccomm[0]->decision_date:''; 
                                        if($l_datev=='' && $decision_date!=''){
                                            $l_datev=isset($decision_date)?$decision_date:''; 
                                        }
                                        $l_datev=explode('|', $l_datev); ?>
                                        <?= form_input(['name'=>'edit_ddate','value'=>$l_datev[0],'id'=>"edit_ddate",'class'=>'form-control datepicker','placeholder'=>'Decision Date','title'=>'Communication Date Date.']) ?>  	
                                        </div>
                                </div>
                            </div>
                            
                            <!--div class="form-card">
                                <div class="form-group">
                                        <label class="control-label" for="caseYear"><span class="custom">Petition Year:</label>
                                        <div class="input-group mb-3 mb-md-0">
                                        <?php
                                       /* $yearv=isset($basic[0]->l_case_year)?$basic[0]->l_case_year:'';
                                        $case_year=isset($basiccomm[0]->case_year)?$basiccomm[0]->case_year:'';
                                        if($yearv=='' && $case_year!=''){
                                            $yearv=isset($case_year)?$case_year:'';
                                        }
                                        $cyear=date('Y');
                                        $yearv=explode('|', $yearv);
                                        $year = $yearv[0];
                                        if($year==''){ 
                                            $year='2020';
                                        }
                                        $year1=[''=>'- Select Year -'];
                                        for ($i = $cyear; $i >= 2000; $i--) {
                                            $year1[$i]=$i;
                                        }
                                        echo form_dropdown('edit_caseYear',$year1,$year,['class'=>'form-control','id'=>'edit_caseYear']); 
                                        */?>
                                        </div>
                                </div>
                            </div-->
                        </div>
    
                        <div class="col-lg-4">
                            <div class="form-card">
                                <div class="form-group">
                                    <label class="control-label" for="case_type_lower"><span class="custom"><?=$this->lang->line('impugnedType')?>:</label>
                                    <div class="input-group mb-3 mb-md-0">
                                    <?php
                                    $lower_case_typev=isset($basic[0]->lower_case_type)?$basic[0]->lower_case_type:'';  
                                    $case_type=isset($basiccomm[0]->case_type)?$basiccomm[0]->case_type:'';
                                    if($lower_case_typev=='' && $case_type!=''){
                                        $lower_case_typev=isset($case_type)?$case_type:'';
                                    }





                                        echo form_dropdown('edit_case_type_lower',$impugnesArray,$lower_case_typev[0],['class'=>'form-control','id'=>'edit_case_type_lower','onchange'=>'otherMatter()']);
                                        ?>
                                    </div>
                                </div>
                            </div>  
							<div class="form-card">
                                <div class="form-group">
                                    <label class="control-label" for="comDate"><?=$this->lang->line('commdate')?>:</label>
                                    <div class="input-group mb-3 mb-md-0">
                                    <?php   
                                    $comm_dateval=isset($basic[0]->comm_date)?$basic[0]->comm_date:''; 
                                    $communication_date=isset($basiccomm[0]->communication_date)?$basiccomm[0]->communication_date:'';
                                    if($comm_dateval=='' && $communication_date!=''){
                                        $comm_dateval=$communication_date;
                                    }
                                    $comd=explode('|', $comm_dateval);?>
                                    <?= form_input(['name'=>'edit_comDate','id'=>"edit_comDate",'value'=>$comd[0],'class'=>'form-control datepicker','placeholder'=>'Communication Date','readonly'=>true,'title'=>'Communication Date Date.']) ?>
                                    </div>
                                </div>
                            </div>							
                            
                                
                            <div class="form-card" id="anyOtherLower" style="display: none">
                                <div class="form-group">
                                    <label class="control-label" for="caseYear"><span class="custom"><font color="red">*</font></span>Other Matter:</label>
                                    <div><input type="text" name="anyOtherMatter" class="form-control" placeholder='Other matter' id="anyOtherMatter"></div>
                                </div>
                        	</div>   
                    	</div>
        			</div>
          		</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editSubmit();">Save changes</button>
              </div>
        </div>
      </div>
    </div>
 </div> 

 
 
 
 
<script>
function editSubmit(){
	var id=$('#comm_id').val();
	var case_no=$('#edit_caseNo').val();
	var ddate=$('#edit_ddate').val();
	var comDate=$('#edit_comDate').val();
	var commission=$('#edit_commission').val();
	var natureOrder=$('#edit_natureOrder').val();
	var case_type=$('#edit_case_type_lower').val();
	var year=$('#edit_caseYear').val();
	var dataa={};
    dataa['id']=id;
    dataa['case_no']=case_no;
    dataa['ddate']=ddate;
    dataa['comDate']=comDate;
    dataa['commission']=commission;
    dataa['natureOrder']=natureOrder;
    dataa['case_type']=case_type;
    dataa['year']=year;
    dataa['token']='<?php echo $token; ?>';
	$.ajax({
        type: "POST",
        url: base_url+"editSubmitcommrefile",
        data: dataa,
        cache: false,
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
        		$('#product').html(resp.result);
        		$.alert({
					title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Done</b>',
					content: '<p class="text-success">Record update successfully.</p>',
					animationSpeed: 2000
				});
				$('#exampleModal').delay(1000).modal('hide');
				
			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}




function editcomm(id){
	var dataa={};
    dataa['id']=id;
    dataa['token']='<?php echo $token; ?>';
	$.ajax({
        type: "POST",
        url: base_url+"getcommeditrefile",
        data: dataa,
        cache: false,
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp) {
        		$('#comm_id').val(resp.id);
        		$('#edit_caseNo').val(resp.case_no);
        		$('#edit_ddate').val(resp.decision_date);
        		$('#edit_comDate').val(resp.comm_date);
        		$("#edit_commission option[value='"+resp.commission+"']").attr("selected","selected");
        		$("#edit_natureOrder option[value='"+resp.nature_of_order+"']").attr("selected","selected");
        		$("#edit_case_type_lower option[value='"+resp.lower_court_type+"']").attr("selected","selected");
            	$("#edit_caseYear option[value='"+resp.case_year+"']").attr("selected","selected");
			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}



function otherMatter() {
    var otherMatterLower = document.getElementById("case_type_lower").value;
    if (otherMatterLower == 17) {
        document.getElementById("anyOtherLower").style.display = 'block';
        document.getElementById("show").style.display = 'none';
    } else {
        document.getElementById("anyOtherLower").style.display = 'none';
        document.getElementById("show").style.display = 'inline-block';
    }
}


$('#basicform').submit(function(e){
	    e.preventDefault();
        $('.srchWrap').removeClass('d-none');
        var token= document.getElementById("token").value;
        var saltval= document.getElementById("saltNo").value;
        var tabno=document.getElementById("tabno").value;
        var bench = document.getElementById("bench").value;
        var subBench = document.getElementById("subBench").value;
        var caseType = document.getElementById("caseType").value;
        var totalNoAnnexure = document.getElementById("totalNoAnnexure").value;
        var totalNoImpugned = document.getElementById("totalNoImpugned").value;
        var petSection = document.getElementById("petSection").value;
        var petSubSection1 = document.getElementById("petSubSection1").value;
        var act = document.getElementById("act").value;
        if (subBench == "" || subBench == 'Select Name') {
            alert("Please Select Sub Bench!");
            document.filing.subBench.focus();
            return false;
        }
        if (act == "") {
            alert("Select ACT");
            document.filing.act.focus();
            return false;
        }
        if(caseType == ""){
            alert(" Please select valid caseType");
            return false;
        }
        if (petSection == "") {
            alert("Select Under section");
            document.filing.petSection.focus();
            return false;
        }
        var cnt1 = Number(document.getElementById("cnt").value)+1;
        var totalNoImpugned = document.getElementById("totalNoImpugned").value; 
        if(totalNoImpugned=='' || totalNoImpugned==0){
            alert("Please Enter Total No. Orders to be Challenged");
            return false;
        }
        var  cnt =document.getElementById("cnt").value;
        if(cnt=='0'){
        	alert("Please Add commission ");
            return false;
        }
        var dataa = {};
        dataa['bench'] =bench;
        dataa['subBench'] =subBench;
        dataa['token'] =token;
        dataa['act'] =act;
        dataa['petSubSection1'] =petSubSection1;
        dataa['caseType'] =caseType; 
        dataa['totalNoAnnexure'] =totalNoAnnexure;
        dataa['petSec'] =petSection; 
        dataa['totalNoImpugned']=totalNoImpugned;
        dataa['salt']=saltval;
        $.ajax({
            type: "POST",
            url: base_url+'base_details_edit',
            data: dataa,
            cache: false,
            beforeSend: function(){
                $('#nextsubmit').prop('disabled',true).val("Under proccess....");
            },
            success: function (resp) {
                var resp = JSON.parse(resp);
                if(resp.data=='success') {          
            		setTimeout(function(){
                        window.location.href = base_url+'<?php echo $urlv; ?>';
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
                $('#nextsubmit').prop('disabled',false).val("Save & Next");
            }
        }); 
});





/*
$(document).ready(function() {
	 var act_id = $("#act").val();
	    var case_typed = $("#caseType").val();
	    act_iddd = act_id;
	    casyy_type = case_typed;
	    var dataa = {};
	    dataa['state_id'] = act_id;
	    dataa['case_typed'] = case_typed;
	    if (act_id.length > 0) {
	        $.ajax({
	            type: "POST",
	            url: base_url+'undersection',
	            data: dataa,
	            cache: false,
	            success: function (petSection) {
	                $("#petSection").html(petSection);
	                $("#petSection").val("")
	                if (casyy_type == '1' && act_iddd == '1') {
	                    $("#petSection").val("1");
	                } else if (casyy_type == '1' && act_iddd == '3') {
	                    $("#petSection").val("5");
	                } else if (casyy_type == '1' && act_iddd == '2') {
	                    $("#petSection").val("3");
	                } else if ((casyy_type == '2' || casyy_type == '4') && act_iddd == '1') {
	                    $("#petSection").val("2");
	                } else if ((casyy_type == '2' || casyy_type == '4') && act_iddd == '3') {
	                    $("#petSection").val("6");
	                } else if ((casyy_type == '2' || casyy_type == '4') && act_iddd == '2') {
	                    $("#petSection").val("4");
	                }

	            }
	        });
	    }
});
*/

function isNumberKey(evt){ 
    var act_id = $("#case_type_lower").val();
	if(act_id!=17){
       var charCode = (evt.which) ? evt.which : event.keyCode
       if (charCode > 31 && (charCode < 48 || charCode > 57)){
         return false;
       }else{
   		 return true;
       }
	}
}


function isNumberKey1(evt){ 
	var cnt =document.getElementById("cnt").value;
	var i;
	for (i = 0; i < cnt; i++) {
     var otherMatterLower = document.getElementById("case_type_lower"+i).value;
    	if(otherMatterLower!=17){
           var charCode = (evt.which) ? evt.which : event.keyCode
           if (charCode > 31 && (charCode < 48 || charCode > 57)){
             return false;
           }else{
       		 return true;
           }
    	}
	}
}
 

function otherMatter1() {
	var cnt =document.getElementById("cnt").value;
	var i;
	for (i = 0; i < cnt; i++) {
     var otherMatterLower = document.getElementById("case_type_lower"+i).value;
        if (otherMatterLower == 17) {
            document.getElementById("anyOtherLower"+i).style.display = 'block';
            $("#caseNo"+i).removeClass("allownumericwithoutdecimal");
        } else {
            document.getElementById("anyOtherLower"+i).style.display = 'none';
            $("#caseNo"+i).addClass("allownumericwithoutdecimal");
        }
        
	}
}

function fn_check_caveat() {
    $("#testdiv_cavetor_details").hide();
    $("#caveator_details_data").empty();
    var commission = $("#commission").val();
    var case_no = $("#caseNo").val();
    var case_year = $("#caseYear").val();
    var decision_date = $("#ddate").val();


    if (commission == '') {
        alert('select Comission ');
        return false;
    }
    if (case_no == '') {
        alert('Enter Case No');
        return false;
    }
    if (case_year == '') {
        alert('Select Year');
        return false;
    }
    if (decision_date == '') {
        alert('Enetr Decision date');
        return false;
    }
    var data = {};
    data['action'] = 'check_caveat_data';
    data['case_no'] = case_no;
    data['case_year'] = case_year;
    data['decision_date'] = decision_date;
    data['commission'] = commission;
    $.ajax({
        type: "POST",
        url: base_url+"filing_ajax",
        data: data,
        dataType: "html",
        success: function (data) {
            $("#testdiv_cavetor_details").show();
            $("#caveator_details_data").html(data);
        },
        error: function (request, error) {
            console.log("Something error.");
        }
    });
}

function isNumberKey(evt){ 
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
      return false;
    }else{
		 return true;
    }
}


function deletecomm(id){
    var salt = document.getElementById("saltNo").value;
   	var cnt1 = Number(document.getElementById("cnt").value);
    var dataa = {}, tImp='';
	dataa['id'] =id,
	dataa['salt'] =salt,
	$.ajax({
        type: "POST",
        url: base_url+'deleteCommref',
        data: dataa,
        cache: false,
		beforeSend: function(){
			$('#deletesubmit').prop('enabled',true).val("Under proccess....");
		},
        success: function (resp) {
                var we= cnt1 - 1
			    document.getElementById("cnt").value = we;
        		$('#product').html(resp);
                tImp=Number($('#totalNoImpugned').val()) - Number('1');
               // $('#totalNoImpugned').val(tImp);
                //$('#totalNoImpugned').hide(tImp);
        },
        error: function(){
			$.alert("Surver busy,try later.");
		},

	 }); 
}


function addMorerefile() {
	var commission='', natureOrder='', case_type_lower='', caseNo='',ddate='';
	commission=$('#commission option:selected').val();
	natureOrder=$('#natureOrder option:selected').val();
	case_type_lower=$('#case_type_lower option:selected').val();
	caseNo=$('#caseNo').val();
	ddate=$('#ddate').val();
  	var salt = document.getElementById("saltNo").value;
  	const cnt1 = Number(document.getElementById("cnt").value) + Number('1');
  	//var totalNoImpugned = document.getElementById("totalNoImpugned").value;
  	/*if(totalNoImpugned=='' || totalNoImpugned==0){
    	alert("Please Enter Impugned");
		$('#totalNoImpugned').focus();
    	return false;
   }*/
   if(commission=='' || natureOrder=='' || case_type_lower=='' || caseNo=='' || ddate==''){
	   $.alert("Kindly provide all mandatory(*) details!");
	   return false;
   }
   var commission = document.getElementById("commission").value;
   var natureOrder = document.getElementById("natureOrder").value;
   var case_type_lower = document.getElementById("case_type_lower").value;
   //var caseNo =document.getElementById("caseNo").value;
  // var caseYear = document.getElementById("caseYear").value;
   var ddate = document.getElementById("ddate").value;
   var comDate = document.getElementById("comDate").value;
  /* var val=totalNoImpugned;

   if(cnt1 > val || val==0){
    	alert("Commission should not greater-than Impugned");
    	return false;
   }*/
    var dataa = {};
    dataa['cnt'] = cnt1;
    dataa['salt'] = salt;
    dataa['commission'] = commission;
    dataa['natureOrder']=natureOrder;
    dataa['case_type_lower']=case_type_lower;
   // dataa['caseNo']=caseNo;
   // dataa['caseYear']=caseYear;
    dataa['ddate']=ddate;
    dataa['comDate']=comDate;
    $.ajax({
        type: "POST",
        url: base_url+'addmorecommitionrefile',
        data: dataa,
        cache: false,
		dataType: 'json',
        success: function (jsonData) {
			petSection=jsonData.data;
			rows=jsonData.rows;
			
            $("#product").html(petSection);
			document.getElementById("commission").value="";
			document.getElementById("natureOrder").value="";
			document.getElementById("case_type_lower").value="";
			document.getElementById("caseNo").value="";
			document.getElementById("ddate").value="";
			document.getElementById("comDate").value="";
			document.getElementById("caseYear").value="";
			$.alert("Impugned order detail Saved.");
			$('#nextsubmit').removeAttr('disabled');
			document.getElementById("cnt").value = rows;				
		//	document.getElementById("totalNoImpugned").value = Number(rows);				
			//document.getElementById("totalNoImpugned").value = Number(rows);
        }
    });
}

</script>
<?php $this->load->view("admin/footer"); ?>
