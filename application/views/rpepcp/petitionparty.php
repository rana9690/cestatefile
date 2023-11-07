<?php $this->load->view("admin/header"); 
$this->load->view("admin/sidebar"); 

$this->load->view("admin/stepsrpepcp"); 
$salt=$this->session->userdata('rpepcpsalt');
$token= $this->efiling_model->getToken();
$partytype='';
$filingno='';
$tab_no='';
$type='';
$partyType='';
$party_ids='';
if($salt!=''){
    $basicrp= $this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$salt);
    $iano=isset($basicrp[0]->totalNoia)?$basicrp[0]->totalNoia:'';
    $anx=isset($basicrp[0]->totalNoAnnexure)?$basicrp[0]->totalNoAnnexure:'';
    $type=isset($basicrp[0]->type)?$basicrp[0]->type:'';
    $order_date=isset($basicrp[0]->order_date)?$basicrp[0]->order_date:'';
    if($order_date!=''){
        $orderd=date('d-m-Y',strtotime($order_date));
    }
    $filingno=isset($basicrp[0]->filing_no)?$basicrp[0]->filing_no:'';
    $tab_no=isset($basicrp[0]->tab_no)?$basicrp[0]->tab_no:'';
    $type=isset($basicrp[0]->type)?$basicrp[0]->type:'';
    $partyType=isset($basicrp[0]->partyType)?$basicrp[0]->partyType:'';
    $party_ids=isset($basicrp[0]->party_ids)?$basicrp[0]->party_ids:'';
}
$partyType=isset($_REQUEST['partyType'])?$_REQUEST['partyType']:$partyType;
if($partyType=='1'){
    $partytype='1';
}
if($partyType=='2'){
    $partytype='2';
}
if($partyType=='3'){
    $partytype='3';
}
if($salt!=''){
?>


<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script>
<?php } ?>
<?php if($type!=6):?>

<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">
            <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','name'=>'rpepcpparty','id'=>'rpepcpparty','autocomplete'=>'off']) ?>

            <?= form_fieldset('Applicant <div class="date-div text-success date">'.$this->lang->line('referenceno').' :'.$salt.'</div>'); ?>


            <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
            <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
            <input type="hidden" name="filingno" id="filingno" value="<?php echo $filingno; ?>">
            <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
            <input type="hidden" name="tabno" id="tabno" value="<?php echo '2'; ?>">
            <div class="col-md-12">
                <div id="divstype">
                    <div class="row alert alert-warning" style="">
                        <div class="col-md-12">
                            <label class="text-dark mr-2"><b>Select Party Type:</b></label>
                            <label for="org" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'load_app_respodent(1)','value'=>'1','checked'=>('1' == $partytype) ? TRUE : FALSE,'id'=>'pet']); ?>Applicant&nbsp;&nbsp;
                            </label>
                            <label for="indv" class="form-check-label font-weight-semibold">
                                <?= form_radio(['name'=>'partyType','onclick'=>'load_app_respodent(2)','value'=>'2','checked'=>('2' == $partytype) ? TRUE : FALSE,'id'=>'res']); ?>Respondent&nbsp;&nbsp;
                            </label>
                            <!--  <label for="inp" class="form-check-label font-weight-semibold">
                            <?= form_radio(['name'=>'partyType','onclick'=>'load_app_respodent(3)','value'=>'3','checked'=>('3' == $partytype) ? TRUE : FALSE,'id'=>'tParty']); ?> Third Party
                        </label> -->
                        </div>
                    </div>





                    <div class="row">
                        <div class="col-md-12">
                            <?php
                    if($partytype!=''){
                        $filing_no = isset($_REQUEST['filingno'])?$_REQUEST['filingno']:$filingno;
                    if($partyType!='3'){
                        $st =$this->efiling_model->data_list_where('case_detail','filing_no',$filingno);
                        $filing_no = htmlspecialchars($st[0]->filing_no);
                        $petName = isset($st[0]->pet_name)?$st[0]->pet_name:'';
                        $resName = isset($st[0]->res_name)?$st[0]->res_name:'';
                        $fDate = isset($st[0]->dt_of_filing)?$st[0]->dt_of_filing:'';
                        ?>
                            <div class="">
                                <table datatable="ng" id="examples" class="table table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <tbody>
                                        <?php
                            $st =$this->efiling_model->data_list_where('case_detail','filing_no',$filing_no);
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
                        
                    
                        if ($partyType == 1) {
                            $partyTypeCesatat='P';
                            echo $petName.' (A-1)';
                        }
                        if ($partyType == 2) {
                            $partyTypeCesatat='R';
                            echo $resName. '(R-1)';
                        } 
                        $partyids=array();
                        $vals='';
                        if($salt!=''){
                            $refdetail= $this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$salt); 
                           if(isset($refdetail[0]->party_ids)):
						   $partyids=explode(',',$refdetail[0]->party_ids);
                            if($partyids[0]=='1'){
                                $vals='checked';
                            }
							endif;
                        }
                        ?>
                                                <input type="checkbox" name="patyAddId_review_pe"
                                                    id="patyAddId_review_pe" value="1" <?php echo $vals; ?>>
                                            </td>
                                        </tr>
                                        <?php 
                                $noOfParty = 0;
                                $addParty = $this->efiling_model->getAddPartydetail($filing_no,$partyTypeCesatat);

                                $i = 2;
                                foreach ($addParty as $row) {
                                    $vals='';
                                    $partyName = $row->name;
                                    //$id = $row->party_id;
                                    $flag = $row->party_flag;
                                    $partysrno= $row->party_serial_no;
                                    if(in_array($partysrno, $partyids)){
                                        $vals="checked";
                                    }
                                    ?>
                                        <tr>
                                            <td><?php echo $partyName;
                                        if ($flag == 'P') {
                                            echo '(A-' . $partysrno . ')';
                                        }
                                        if ($flag == 'R') {
                                            echo '(R-' . $partysrno . ')';
                                        } ?>
                                                <input type="checkbox" name="patyAddId_review_pe"
                                                    id="patyAddId_review_pe" value="<?php echo $partysrno; ?>"
                                                    <?php echo $vals; ?>>
                                            </td>
                                            <?php
                                    echo " <tr>";
                                    $noOfParty++;
                                 }  
                                }
                             }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <input type="button" value="Save and Next" class="btn btn-success"
                            onclick="rpepcpSubmitParty();">
                        &nbsp;&nbsp;<input type="reset" value="Reset/Clear" class="btn btn-warning">
                    </div>
                </div>

                <?= form_fieldset_close(); ?>
            </div>
            <?= form_close();?>
        </div>
    </div>

    <?php else:  //appeal memo start?>
    <div class="content" style="padding:0px;">
        <div class="row">
            <div class="card checklistSec" style="">
                <?= form_open('view-basic-details',['class'=>'wizard-form steps-basic wizard clearfix','id'=>'basicform','autocomplete'=>'off']) ?>
                <input type="hidden" name="saltNo" id="saltNo" value="<?php echo $salt; ?>">
                <ul id="progressbarmini" data-target="petitionPriority">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                </ul>
                <?= form_fieldset("<i class='icon-plus-circle2 text-danger d-none'></i> Page 1 <div class='date-div text-success date'>".$this->lang->line('referenceno')." :".$salt."</div>",['id'=>'112']);?>
                <?php $this->load->view("admin/basicDetailView"); ?>
                <br>
                <input type="button" name="next" class="next btn-rt btn btn-success mr-3" value="Save & Next" />
                <?= form_fieldset_close(); ?>

                <?=form_fieldset("<i class='icon-plus-circle2 text-danger d-none'></i> Page 2 <div class='date-div text-success date'>".$this->lang->line('referenceno')." :".$salt."</div>",['id'=>'113'])?>

                <?php $this->load->view("admin/checkListCestat"); ?>
                <input type="button" name="next" class="next btn-rt btn btn-success" value="Save & Next" />
                <input type="button" name="previous" class="previous btn-rt btn btn-warning" value="Previous" />
                <?= form_fieldset_close(); ?>

                <?=form_fieldset("<i class='icon-plus-circle2 text-danger d-none'></i> Page 3 <div class='date-div text-success date'>".$this->lang->line('referenceno')." :".$salt."</div> ",['id'=>'114'])?>


                <?php $this->load->view("admin/otherFeeDetail"); ?>
                <input type="button" name="next" class="next btn-rt btn btn-success" value="Save & Next" />
                <input type="button" name="previous" class="previous btn-rt btn btn-warning" value="Previous" />
                <?= form_fieldset_close(); ?>


                <?= form_close();?>
            </div>
        </div>
    </div>

    <?php endif;?>

    <?php $this->load->view("admin/footer"); ?>
    <script>
    $(document).ready(function() {
        $("#basicform").find('input:text,select, textarea').attr('disabled', 'disabled');
    });

    function load_app_respodent() {
        with(document.rpepcpparty) {
            action = base_url + "petitionparty";
            submit();
            document.frm.submit11.disabled = true;
            document.frm.submit11.value = 'Please Wait...';
            return true;
        }
    }

    function rpepcpSubmitParty() {
        var token = document.getElementById('token').value;
        var salt = document.getElementById('saltNo').value;
        var filingno = document.getElementById('filingno').value;
        var checkboxes1 = document.getElementsByName('patyAddId_review_pe');
        var type = document.getElementById('type').value;
        var tabno = document.getElementById('tabno').value;
        var patyAddId = "";
        for (var i = 0; i < checkboxes1.length; i++) {
            if (checkboxes1[i].checked) {
                patyAddId = patyAddId + checkboxes1[i].value + ',';
            }
        }
        if (patyAddId == '') {
            alert("Please check atleast one party !");
            return false;
        }

        var checkboxes = document.getElementsByName('partyType');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                idorg = checkboxes[i].value;
            }
        }

        if (idorg == '') {
            alert("Please check atleast party type !");
            return false;
        }

        var dataa = {};
        dataa['salt'] = salt,
            dataa['filingno'] = filingno,
            dataa['token'] = token,
            dataa['patyAddId'] = patyAddId,
            dataa['type'] = type,
            dataa['tabno'] = tabno,
            dataa['partyType'] = idorg,

            $.ajax({
                type: "POST",
                url: base_url + "/petitionpartySubmit",
                data: dataa,
                cache: false,
                success: function(resp) {
                    var resp = JSON.parse(resp);
                    if (resp.data == 'success') {
                        setTimeout(function() {
                            window.location.href = base_url + 'petitionPriority';
                        }, 250);
                    } else if (resp.error != '0') {
                        $.alert(resp.error);
                    }
                },
                error: function(request, error) {
                    $('#loading_modal').fadeOut(200);
                }
            });
    }
    </script>