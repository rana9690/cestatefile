<?php
error_reporting(0);
$this->load->library('form_validation');
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepsdoc");
$salt=$this->session->userdata('docsalt');
if($salt!=''){
    $salt=$this->session->unset_userdata('docsalt');
}
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$checkcpass=$userdata[0]->is_password;
$token= $this->efiling_model->getToken();
$anx='';
?>

<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">

            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','name'=>'rpepcpbascidetail','id'=>'rpepcpbascidetail','autocomplete'=>'off']) ?>
            <input type="hidden" id="csrf_token" name="<?=$this->security->get_csrf_token_name()?>"
                value="<?=$this->security->get_csrf_hash();?>" />
            <?= form_fieldset('Search').'<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>'; ?>
            <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
            <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
            <input type="hidden" name="tabno" id="tabno" value="1">
            <input type="hidden" name="iatype" id="iatype" value="doc">
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
                                                                        5=>'COD Diary No',
                                                                        6=>'COD No',
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


                                                        if($appAnddef==1 || $appAnddef==3  || $appAnddef==5):?>
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
                                                                if($appAnddef==2 || $appAnddef==4||$appAnddef==6):
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
                                </span>Case NO: </label>
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

                                                                        //redirect(base_url('doc_basic_detail'),'refresh');die;
                                                                    }
                                                        $schemasData1 = $schemasData=getSchemasNames($this->input->post('bench'));
                                                        
                                                    ?>

<div class="row m-0">
            <div class="card w-100 mt-5 inner-card">
                <fieldset id="" style="display: block">
                    <legend class="customlavelsub">Case Details</legend>
                    <div style="margin-top:20px">
                                                                            <?php  
                                                                    $case_type='';
                                                                    $vals='';
                                                                    $data=array();
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


                                                                        $data=$this->efiling_model->getAppDetails(['filing_no'=>$filing_no],$schemasData->schema_name);


                                                                        if(empty($data)){
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
                                                                        
                                                                        $data=$this->efiling_model->getAppDetails(['case_no'=>$case_no],$schemasData1->schema_name);
                                                                        if(empty($data)){
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


                                                                if($appAnddef=='5'){
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
                                                                    $data=$this->efiling_model->getCodDetails(['ap.appfiling_no'=>$filing_no],$schemasData->schema_name);

                                                                    if(empty($data)){
                                                                        $flag='1';
                                                                        echo '<center style="color:red">Record not Found !</center>';
                                                                    }
                                                                }

                                                                if($appAnddef=='6'){
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
                                                                    $data=$this->efiling_model->getCodDetails(['ap.appno'=>$case_no],$schemasData->schema_name);
                                                                    if(empty($data)){
                                                                        $flag='1';
                                                                        echo '<center style="color:red">Record not Found !</center>';
                                                                    }
                                                                }
                                                                ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
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
                                                                        <?php $i=1;
                                                        if(!empty($data) && is_array($data)){
                                                        foreach($data as $val){




                                                            $dfrno=$this->efiling_model->getDFRformate($val->filing_no);
                                                            $case_no=$this->efiling_model->getCASEformate($val->case_no);
                                                            $pet= $val->pet_name.$this->efiling_model->fn_addition_party($val->filing_no,'1');
                                                            $res= $val->res_name.$this->efiling_model->fn_addition_partyr($val->filing_no,'2');
                                                            if($appAnddef=='3' ||$appAnddef=='4')
                                                            {
                                                                echo '<input type="hidden" name="appfiling_no" id="appfiling_no" value="'.$val->appfiling_no.'">';
                                                            }
                                                            if($appAnddef=='5' ||$appAnddef=='6')
                                                            {
                                                                echo '<input type="hidden" name="appfiling_no" id="appfiling_no" value="'.$val->appfiling_no.'">';
                                                                echo '<input type="hidden" name="appmainfiling_no" id="appmainfiling_no" value="'.$val->appmainfiling_no.'">';
                                                            }
                                                            ?>
                                <tr>
                                    <input type="hidden" name="filing_no" id="filing_no"
                                        value="<?php echo $val->filing_no; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $dfrno; ?></td>
                                    <td><?php echo $case_no; ?></td>
                                    <td><?php echo $pet; ?> <span style="color:red"><b>&nbsp;Vs</b></span>
                                        &nbsp;<?php echo $res; ?>
                                    </td>
                                    <td><?php  if($val->status=='D'){ echo "Disposal"; }else{ echo "Pending"; } ?></td>
                                    <!-- <td><input type="radio" id="huey" name="drone" value="huey" checked></td> -->
                                </tr>
                                                                            <?php $i++;}
                                                            }?>
                            </tbody>
                        </table>
                                                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <input type="button" value="Save and Next" class="btn btn-success"
                                onclick="docSubmitBasic();">
                            <input type="reset" value="Reset/Clear" class="btn btn-warning">
                        </div>
                    </div>
                </fieldset>
                                                        </div>
                                                        </div>
                <?php } ?>
                <?= form_fieldset_close(); ?>
                <?= form_close();?>

                                                        </div>
                                                        </div>
                                                        </div>
                <?php $this->load->view("admin/footer"); ?>


                <script>
                function docSubmitBasic() {

                    var form = document.querySelector('form');
                    var triggerButton = document.querySelector('button');
                    // Form is invalid!
                    if (!form.checkValidity()) {
                        // Create the temporary button, click and remove it
                        var tmpSubmit = document.createElement('button')
                        form.appendChild(tmpSubmit)
                        tmpSubmit.click()
                        form.removeChild(tmpSubmit)
                    } else {


                        var salt = $("#saltNo").val();
                        var tabno = document.getElementById("tabno").value;
                        var token = document.getElementById("token").value;
                        var filing_no = document.getElementById("filing_no").value;
                        var type = document.getElementById("iatype").value;
                        /*  var toalannexure= document.getElementById("toalannexure").value;
                         if(toalannexure==''){
                         alert("Please fill total number of annexure !");
                         return false;
                         } */
                        var dataa = {};
                        dataa['salt'] = salt,
                            dataa['tab_no'] = tabno,
                            dataa['token'] = token,
                            dataa['filing_no'] = filing_no,
                            dataa['type'] = type,
                            //dataa['toalannexure']=toalannexure,
                            dataa['user_id'] = '<?= $userid ?>';
                        if (document.getElementById("appfiling_no") != null) {
                            var appfiling_no = document.getElementById("appfiling_no").value;
                            dataa['appfiling_no'] = appfiling_no;
                        }
                        if (document.getElementById("appmainfiling_no") != null) {
                            var appmainfiling_no = document.getElementById("appmainfiling_no").value;
                            dataa['appmainfiling_no'] = appmainfiling_no;
                        }
                        $.ajax({
                            type: "POST",
                            url: base_url + 'saveDocbasic',
                            data: $(form).serialize(),
                            cache: false,
                            beforeSend: function() {
                                $('#petitioner_save').prop('disabled', true).val("Under proccess....");
                            },
                            success: function(resp) {
                                var resp = JSON.parse(resp);
                                if (resp.data == 'success') {
                                    setTimeout(function() {
                                        window.location.href = base_url + 'doc_partydetail';
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
                }

                function diary() {
                    with(document.rpepcpbascidetail) {
                        action = base_url + "doc_basic_detail";
                        submit();
                        document.frm.submit11.disabled = true;
                        document.frm.submit11.value = 'Please Wait...';
                        return true;
                    }
                }

                $(function() {
                    $(".datepicker").datepicker({
                        maxDate: new Date()
                    });
                });

                function serchDFR() {
                    with(document.rpepcpbascidetail) {
                        action = base_url + "doc_basic_detail";
                        submit();
                        document.frm.submit11.disabled = true;
                        document.frm.submit11.value = 'Please Wait...';
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