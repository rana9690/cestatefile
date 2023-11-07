<?php

$this->load->library('form_validation');
$this->load->view("admin/header"); 
$this->load->view("admin/sidebar"); 
$this->load->view("admin/stepsrpepcp"); 
$salt=$this->session->userdata('rpepcpsalt');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$checkcpass=$userdata[0]->is_password;
$token= $this->efiling_model->getToken();
if($salt==''){
    $salt='';
}
$orderd=date('d-m-Y');
$tab_no='';
$type='';
$iano='';
$anx=1;
$filing_no='';
if($salt!=''){
    $basicrp= $this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$salt);
    $iano=isset($basicrp[0]->totalNoia)?$basicrp[0]->totalNoia:'';
    $anx=isset($basicrp[0]->totalNoAnnexure)?$basicrp[0]->totalNoAnnexure:'';
    $type=isset($basicrp[0]->type)?$basicrp[0]->type:'';
    $order_date=isset($basicrp[0]->order_date)?$basicrp[0]->order_date:'';
    if($order_date!=''){
        $orderd=date('d-m-Y',strtotime($order_date));
    }
    $filing_no=isset($basicrp[0]->filing_no)?$basicrp[0]->filing_no:'';
    $tab_no=isset($basicrp[0]->tab_no)?$basicrp[0]->tab_no:'';
}

?>

<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">

            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','name'=>'valscc','id'=>'valscc','autocomplete'=>'off']) ?>
            <input type="hidden" id="csrf_token" name="<?=$this->security->get_csrf_token_name()?>"
                value="<?=$this->security->get_csrf_hash();?>" />
            <?= form_fieldset('Search Here ').'<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>'; ?>
            <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
            <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
            <input type="hidden" name="tabno" id="tabno" value="1">
            <div class="col-md-12">
                <!--div class="alert alert-primary" role="alert" style="border-color: transparent;">
                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                For COD filing search case by Application diary No./Application No  .
            </div-->
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="bench"><span class="custom">
                                    <font color="red">*</font>
                                </span><?=$this->lang->line('searchBy')?></label>
                            <div class="input-group mb-3 mb-md-0">
                                                <?php
                                            $appAnddef=(set_value('appAnddef'))?set_value('appAnddef'):1;
                                            $appa=[
                                                1=>$this->lang->line('dfrno'),
                                                2=>$this->lang->line('caseno'),
                                            3=>'Application Diary No',
                                            4=>'Application No',
                                            ];
                                            echo form_dropdown('appAnddef',$appa,set_value('appAnddef',(isset($appAnddef))?$appAnddef:''),
                                                ['class'=>'form-control','onchange'=>'serchDFR()','id'=>'appAnddef','required'=>'true']);

                                            ?>
 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label" for="bench"><span class="custom">
                                    <font color="red">*</font>
                                </span>Principal / Circuit Bench </label>
                            <div class="input-group mb-3 mb-md-0">
                                                    <?php
                                                $bench= $this->db->get('master_benches')->result();
                                                //   echo "<pre>";   print_r($bench);die;
                                                $bench1=[''=>'-Please Select bench-'];
                                                $benchval=isset($basic[0]->bench)?$basic[0]->bench:'';

                                                foreach ($bench as $val)
                                                    $bench1[$val->bench_code] = $val->name;
                                                echo form_dropdown('bench',$bench1,set_value('bench',(isset($benchval))?$benchval:''),['class'=>'form-control','id'=>'bench','required'=>'true']);
                                                ?>
                            </div>
                        </div>
                    </div>


                </div>

                <?php


                                            if($appAnddef==1 || $appAnddef==3):?>
                <div class="row" id="myDIV">
                    <div class="col-md-3">
                        <?php 
    			  		$dfr_no=($this->input->post('dfr_no'))?$this->input->post('dfr_no'):'';
    			  		$dfryear=($this->input->post('dfryear'))?$this->input->post('dfryear'):'';
    			  		?>
                        <div class="form-group required">
                            <label for="name"><span class="custom">
                                    <font color="red">*</font>
                                </span><?=$this->lang->line('dfrno')?> </label>
                            <?= form_input(['name'=>'dfr_no','class'=>'form-control','id'=>'dfr_no','value'=>$dfr_no,'onkeypress'=>'return isNumberKey(event)','placeholder'=>'Enter Diary No.','pattern'=>'[0-9]{1,8}','maxlength'=>'8','title'=>'Diary No. should be numeric only.','required'=>'true']) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-card">
                            <div class="form-group">
                                <label class="control-label" for="caseYear"><span class="custom">
                                        <font color="red">*</font>
                                    </span>Diary Year:</label>
                                <div class="input-group mb-3 mb-md-0">
                                    <?php
                             $year1=array();
                             $year = $dfryear;
                             $curryear=date('Y');
                              $year1=[''=>'- Select Year -'];
                              for ($i = $curryear; $i > 2000 ; $i--) {
                                  $year1[$i]=$i;
                              }
                              echo form_dropdown('dfryear',$year1,$year,['class'=>'form-control','id'=>'dfryear','required'=>'true']); 
                             ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div style="margin-top: 25px;">
                            <input type="submit" name="nextsubmit" value="SEARCH" class="btn btn-success"
                                id="nextsubmit" onclick="serchDFR();">
                        </div>
                    </div>
                </div>
                                                    <?php
                                                endif;
                                                if($appAnddef==2 || $appAnddef==4):
                                                $casetype=($this->input->post('case_type'))?$this->input->post('case_type'):'';
                                                $caseno=($this->input->post('case_no'))?$this->input->post('case_no'):'';
                                                $caseyear=($this->input->post('year'))?$this->input->post('year'):'';
                                                ?>
                <div class="row" id="myDIV1">
                    <div class="col-md-3">
                        <div class="form-card">
                            <div class="form-group">
                                <label class="control-label" for="case_type_lower"><span class="custom">
                                        <font color="red">*</font>
                                    </span>Case Type:</label>
                                <div class="input-group mb-3 mb-md-0">
                                    <?php
                              $lowercasetype= getCaseTypes([]);//$this->efiling_model->getCaseTyperpcpep();
                              $lowercasetype1=[''=>'- Select Case Type -'];
                              foreach ($lowercasetype as $val)
                                  $lowercasetype1[$val['case_type_code']] = $val['case_type_name'];
                                  echo form_dropdown('case_type',$lowercasetype1,$casetype,['class'=>'form-control','id'=>'case_type','required'=>'true']);
                                 ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($appAnddef==4):?>
                    <div class="col-md-3">
                        <div class="form-card">
                            <div class="form-group">
                                <label class="control-label" for="case_type_lower"><span class="custom">
                                        <font color="red">*</font>
                                    </span>Case Type:</label>
                                <div class="input-group mb-3 mb-md-0">
                                    <?php
                                     $apptypes=[''=>'-Please Select '];
                                     foreach (getApplicationTypes([]) as $val)
                                         $apptypes[$val['code']] = $val['name'];
                                     echo form_dropdown('app_case_type',$apptypes,set_value('app_case_type'),['class'=>'form-control','id'=>'app_case_type','required'=>'true']);
                                     ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>

                    <div class="col-md-3">
                        <div class="form-group required">
                            <label for="name"><span class="custom">
                                    <font color="red">*</font>
                                </span>Case No: </label>
                            <?= form_input(['name'=>'case_no','class'=>'form-control','id'=>'case_no','value'=>$caseno,'onkeypress'=>'return isNumberKey(event)','placeholder'=>'Enter Case No.','pattern'=>'[0-9]{1,8}','maxlength'=>'8','title'=>'Case should be numeric only.']) ?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-card">
                            <div class="form-group">
                                <label class="control-label" for="caseYear"><span class="custom">
                                        <font color="red">*</font>
                                    </span>Case Year:</label>
                                <div class="input-group mb-3 mb-md-0">
                                    <?php
                             $curryear=date('Y');

                              $year1=[''=>'- Select Year -'];
                              for ($i = $curryear; $i > 2000 ; $i--) {
                                  $year1[$i]=$i;
                              }
                              echo form_dropdown('year',$year1,$caseyear,['class'=>'form-control','id'=>'year','required'=>'true']);
                             ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group required" style="margin-top: 25px;">
                            <input type="submit" name="nextsubmit" value="SEARCH" class="btn btn-success"
                                id="nextsubmit" onclick="serchDFR();">
                        </div>
                    </div>
                </div>
                <?php endif;?>






                <?= form_fieldset_close();   
      if(@$dfr_no!='' || @$caseno!='' ){

$this->form_validation->set_rules('bench', 'Choose valid Bench', 'numeric|max_length[8]|in_list[136507,124438,109120,119315,133568,107079,104044,129525]');
		  if($this->form_validation->run() == FALSE)
					{

						//redirect(base_url('review_petition_filing'),'refresh');die;
					}
          $schemasData=getSchemasNames($this->input->post('bench'));


      ?>

<div class="row m-0">
            <div class="card w-100 mt-5 inner-card">
                <fieldset id="" style="display: block">
                    <legend class="customlavelsub">Case Detail</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="visually-hidden" for="inputEmail">
                                <font color="red">*</font><span
                                    style="color:red"><?=$this->lang->line('applicationType')?>.</span>
                            </label>
                            <?php   $apptypes=[''=>'-Please Select '];
                            foreach (getApplicationTypes([]) as $val)
                                $apptypes[$val['code']] = $val['name'];
                        unset($apptypes[6]);
                    if($appAnddef==3|| $appAnddef==4)$apptypes=[1=>'COD'];
                            echo form_dropdown('rpepcptype',$apptypes,set_value('rpepcptype',(isset($type))?$type:''),['class'=>'form-control','id'=>'rpepcptype']);
                            ?>

                        </div>
                    </div>
                    <div style="margin-top:20px">
                        <?php

    		$flag='';
    		if($appAnddef!=''){
        		if($appAnddef=='1'){
        		    $fno=$this->input->post('dfr_no');
        		    $year=$this->input->post('dfryear');

                    $filing_no= generateFilingNo([
                        'state_code'=>$schemasData->state_code,
                        'district_code'=>$schemasData->district_code,
                        'complex_code'=>$schemasData->complex_code,
                        'filing_no'=>$fno,
                        'year'=>$year,
                    ]);
        		    //$data=$this->efiling_model->getCaseDetailsByDfr(['filing_no'=>$filing_no,'schemas'=>$schemasData->schema_name]);
                    $data=$this->efiling_model->getAppDetails(['filing_no'=>$filing_no],$schemasData->schema_name);

        		    if(empty($data)){
        		        $flag='1';
        		        echo '<center style="color:red">Record not Found !</center>';
        		    }
        		}
        		if($appAnddef=='2'){
        		    $cno=$this->input->post('case_no');
        		    $year=$this->input->post('year');
        		    $case_type=$this->input->post('case_type');

                    $case_no= generateCaseNo([
                        'caseType'=>$case_type,
                        'caseNo'=>$cno,
                        'caseYear'=>$year,
                    ]);
        		   // $data=$this->efiling_model->getCaseByCaseNo(['case_no'=>$case_no,'schemas'=>$schemasdata->schema_name]);
                    $data=$this->efiling_model->getAppDetails(['case_no'=>$case_no],$schemasData->schema_name);
                    if(empty($data)){
        		        $flag='1';
        		        echo '<center style="color:red">Record not Found !</center>';
        		    }
        		}

                if($appAnddef=='3'){
                    $fno=$this->input->post('dfr_no');
                    $year=$this->input->post('dfryear');

                    $filing_no= generateFilingNo([
                        'state_code'=>$schemasData->state_code,
                        'district_code'=>$schemasData->district_code,
                        'complex_code'=>$schemasData->complex_code,
                        'filing_no'=>$fno,
                        'year'=>$year,
                    ]);
                    //$data=$this->efiling_model->getCaseDetailsByDfr(['filing_no'=>$filing_no,'schemas'=>$schemasData->schema_name]);
                    $data=$this->efiling_model->getApplDetails(['ap.appfiling_no'=>$filing_no],$schemasData->schema_name);

                    if(empty($data)){
                        $flag='1';
                        echo '<center style="color:red">Record not Found !</center>';
                    }
                }

                if($appAnddef=='4'){
                    $cno=$this->input->post('case_no');
                    $year=$this->input->post('year');
                    $case_type=$this->input->post('case_type');
                    $appcase_type=$this->input->post('app_case_type');

                    $case_no= generateApplCaseNo([
                        'caseType'=>$case_type,
                        'appCaseType'=>$appcase_type,
                        'caseNo'=>$cno,
                        'caseYear'=>$year,
                    ]);
                    // $data=$this->efiling_model->getCaseByCaseNo(['case_no'=>$case_no,'schemas'=>$schemasdata->schema_name]);
                    $data=$this->efiling_model->getApplDetails(['ap.appno'=>$case_no],$schemasData->schema_name);
                    if(empty($data)){
                        $flag='1';
                        echo '<center style="color:red">Record not Found !</center>';
                    }
                }


    		}else{
    		    $flag='1';
    		    echo '<center style="color:red">Please select Type !</center>';
    		}

    		if(!empty($data)){
    		?>
                    </div>
                    <div class="row mx-2">
                        <table class="table" border="1px">
                            <thead>
                                <tr class="bg-dark">
                                    <th>S.No.</th>
                                    <th><?=$this->lang->line('dfrno')?>.</th>
                                    <th>Case No.</th>
                                    <th>Party Detail</th>
                                    <th>Case Status</th>
                                    <!-- <th>Action</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                  $res='';
                  $pet='';
                  $i=1;
                  $status='';

                  foreach($data as $val){


                        //print_r($val);
                        $status= $val->status;
                        $filing_no=$val->filing_no;
                        @$appfiling_no=$val->appfiling_no;
                        $dfrno=$this->efiling_model->getDFRformate($val->filing_no);
                        $case_no=displayAppNoTest(['caseType'=>'C','caseNo'=>$val->case_no]);;//$this->efiling_model->getCASEformate($val->case_no);
                        $pet= $val->pet_name.$this->efiling_model->getAdditionalParty(['filing_no'=>$val->filing_no,'party_flag'=>'P'],$schemasData->schema_name);
                        $res= $val->res_name.$this->efiling_model->getAdditionalParty(['filing_no'=>$val->filing_no,'party_flag'=>'R'],$schemasData->schema_name);
                    }
                  if($appfiling_no):echo '<input type="hidden" name="appfiling_no" id="appfiling_no" value="'.$appfiling_no.'">';endif;
                    ?>
                                <tr>
                                    <input type="hidden" name="filing_no" id="filing_no"
                                        value="<?php echo $filing_no; ?>">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $dfrno; ?></td>
                                    <td><?php echo $case_no; ?></td>
                                    <td><?php echo $pet; ?><span style="color:red"> <b>&nbsp;Vs</b></span>
                                        &nbsp;<?php echo $res; ?>
                                    </td>
                                    <td><?php  if($status=='D'){ echo "Disposal"; }else{ echo "Pending"; } ?></td>
                                    <!-- <td><input type="radio" id="huey" name="drone" value="huey" checked></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row" style="margin-top:50px; display:none;">
                        <div class="col-auto">
                            <label class="visually-hidden" for="inputEmail">
                                <font color="red">*</font>Date of Order Challenged in this Petition:
                            </label>
                            <input type="text" class="form-control datepicker" name="orderdate"
                                value="<?php echo $orderd; ?>" id="orderdate" placeholder="" readonly>
                        </div>
                        <div class="col-auto">
                            <label class="visually-hidden" for="inputPassword">
                                <font color="red">*</font>Total No. of Annexure
                            </label>
                            <input type="text" class="form-control" id="toalannexure" name="toalannexure"
                                value="<?php echo $anx; ?>" placeholder="Annexure"
                                onkeypress="return isNumberKey(event);" maxlength="3">
                        </div>

                        <?php if($this->config->item('ia_privilege')==true):?>
                        <div class="col-auto">
                            <label class="visually-hidden" for="inputPassword">
                                <font color="red">*</font>Total No. of IA
                            </label>
                            <input type="text" class="form-control" id="totalnoIa" name="totalnoIa"
                                value="<?php echo $iano; ?>" placeholder="Total no. IA"
                                onkeypress="return isNumberKey(event);" maxlength="2">
                        </div>
                        <?php endif;?>
                    </div>

                    <div class="row" style="margin-top:50px;display:none;">
                        <div class="col-auto">
                            <label class="visually-hidden" for="inputPassword">
                                <font color="red">*</font>Subject Matter
                            </label>
                            <textarea id="subject" class="form-control" name="subject" rows="4" cols="50">1</textarea>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 text-right">
                            <input type="button" value="Save and Next" class="btn btn-success"
                                onclick="rpepcpSubmitBasic();">
                            <input type="reset" value="Reset/Clear" class="btn btn-warning">
                        </div>
                    </div>
                    <?php } ?>
                </fieldset>
                </div>
                        </div>
                <?php } ?>
                <?= form_fieldset_close(); ?>
                <?= form_close();?>
                        </div>
                <?php $this->load->view("admin/footer"); ?>


                <script>
                function rpepcpSubmitBasic() {
                    var salt = $("#saltNo").val();
                    var tabno = document.getElementById("tabno").value;
                    var token = document.getElementById("token").value;
                    var filing_no = document.getElementById("filing_no").value;
                    var rpepcptype = document.getElementById("rpepcptype").value;
                    var orderdate = document.getElementById("orderdate").value;
                    var toalannexure = document.getElementById("toalannexure").value;

                    var subject = document.getElementById("subject").value;
                    var bench = document.getElementById("bench").value;
                    if (rpepcptype == '') {
                        alert("Please select Application Type !");
                        return false;
                    }
                    if (orderdate == '') {
                        alert("Please select orderdate !");
                        return false;
                    }
                    if (toalannexure == '') {
                        alert("Please fill total number of annexure !");
                        return false;
                    }
                    var totalnoIa = 0;
                    <?php if($this->config->item('ia_privilege')==true):?>
                    var totalnoIa = document.getElementById("totalnoIa").value;
                    if (totalnoIa == '') {
                        alert("Please fill total no of IA !");
                        return false;
                    }
                    <?php endif;?>

                    if (subject == '') {
                        alert("Please Enter Subject !");
                        return false;
                    }
                    if (bench == '') {
                        alert("Please Select bench !");
                        return false;
                    }

                    var dataa = {};
                    dataa['salt'] = salt,
                        dataa['tab_no'] = tabno,
                        dataa['token'] = token,
                        dataa['filing_no'] = filing_no,
                        dataa['rpepcptype'] = rpepcptype,
                        dataa['orderdate'] = orderdate,
                        dataa['toalannexure'] = toalannexure,
                        dataa['totalnoIa'] = totalnoIa,
                        dataa['user_id'] = '<?= $userid ?>',
                        dataa['subject'] = subject,
                        dataa['bench'] = bench;
                    if (document.getElementById("appfiling_no") != null) {
                        var appfiling_no = document.getElementById("appfiling_no").value;
                        dataa['appfiling_no'] = appfiling_no;
                    }

                    $.ajax({
                        type: "POST",
                        url: base_url + 'saveNextRPEPCbasic',
                        data: dataa,
                        cache: false,
                        beforeSend: function() {
                            $('#petitioner_save').prop('disabled', true).val("Under proccess....");
                        },
                        success: function(resp) {
                            var resp = JSON.parse(resp);
                            if (resp.data == 'success') {
                                setTimeout(function() {
                                    window.location.href = base_url + 'petitionparty';
                                }, 250);
                            } else if (resp.error != '0') {
                                $.alert(resp.error);
                            }
                        },
                        error: function() {
                            $.alert("Surver busy,try later.");
                        },
                        complete: function() {
                            $('#petitioner_save').prop('disabled', false).val("Submit");
                        }
                    });
                }


                $(function() {
                    $(".datepicker").datepicker({
                        maxDate: new Date()
                    });
                });

                function serchDFR() {
                    with(document.valscc) {
                        action = '';
                        submit();
                        return true;
                    }
                }


                function isNumberKey(evt) {
                    var charCode = (evt.which) ? evt.which : event.keyCode
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                        return false;
                    return true;
                }
                </script>