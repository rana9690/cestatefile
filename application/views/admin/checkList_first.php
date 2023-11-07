<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); 
$token= $this->efiling_model->getToken();?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
</style>
<div id="rightbar">
    <?php  include 'steps.php';
?>
    <?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>
    <div class="content" style="padding:0px;">
        <div class="row">
            <div class="card checklistSec" style="">
                <?= form_open(false,['class'=>'wizard-form steps-basic wizard clearfix','id'=>'chkList','autocomplete'=>'off']) ?>
                <input type="hidden" value="" id="allCheck" readonly />
                <input type="hidden" id="tabno" name="tabno" value="<?php echo '1'; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>" id="token">
                <div class="content clearfix">
                    <?= form_fieldset('Instructions/Guidelines <div class="date-div text-success">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>').
                        '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>'.
                        '<div class="date-div text-success d-none">Date & Time : &nbsp;<small>'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>';
                        ?>

                    <object data="<?=base_url()?>asset/Guidelines-for-e-filing-of-Appeals.pdf" type="application/pdf"
                        width="100%" height="500px">
                        <p>Unable to display PDF file. <a
                                href="<?=base_url()?>asset/Guidelines-for-e-filing-of-Appeals.pdf">Download</a> instead.
                        </p>
                    </object>
                    <div class="row">
                        <table class="table">
                            <!--thead>
                                <tr>
                                <th scope="col" style="width:2%;">S.No.</th>                                  
                                  <th scope="col" style="width:50%;">Checklist</th>
                                  <th scope="col" style="width:18%;">Action</th>
                                </tr>
                              </thead-->
                            <tbody>

                                <?php $count=count($checklist);
                                /*$i=1; foreach($checklist as $val){ ?>
                                <tr>
                                    <td><?php echo $i; ?>.</td>
                                    <td><?php echo $val->c_name; ?></td>
                                    <td>
                                        <input type="hidden" maxlength="200" name="value<?php echo $i; ?>"
                                            value="<?php echo $val->id; ?>" class="form-control">
                                        <!--input type="radio" name="check<?php //echo $i; ?>" value="<?php //echo $val->action_one; ?>">&nbsp;<?php //echo ucfirst($val->action_one); ?>&nbsp;&nbsp;&nbsp;&nbsp;
										-->
                                </tr>
                                <?php $i++; } */?>
                                <tr>
                                    <td align="right"><input type="hidden" maxlength="200" name="value<?php echo $i; ?>"
                                            value="<?php echo $val->id; ?>" class="form-control">
                                        <input type="checkbox" name="check1"
                                            value="Yes">&nbsp;<?php //echo ucfirst($val->action_one); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    </td>
                                    <td colspan="2">

                                        <b>I have read the instructions and undertake that I am filing the
                                            Appeal/Application/Cross Objection/Documents as per CESTAT
                                            (Procedure) Rules, 1982 and adhering to other instructions issued from
                                            time to time.</b>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="offset-md-8 col-md-4 text-right">
                            <?php
                    			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                    form_submit(['value'=>'Save & Next','class'=>'btn btn-success','id'=>'chkBtn','style'=>'padding-left:24px;','disabled'=>'disabled']);
                                    //  .form_button(['id'=>'','value'=>'false','content'=>'&nbsp;Next','class'=>'icon-arrow-right8 btn btn-primary']);
                            	?>
                        </div>
                    </div>
                    <?= form_fieldset_close(); ?>
                </div>
                <?= form_close();?>
            </div>
        </div>
    </div>
    <script>
    $('#loading_modal').fadeOut(200);
    $("input[type='checkbox']").click(function(e) {
        var noyes = 0;
        $('input:checkbox').each(function() {
            var $this = $(this);
            if ($(this).prop('checked') && ($(this).val() == 'Yes' || $(this).val() == 'NA')) {
                noyes++;
            }
        });
        if (noyes == 1) {
            $('#allCheck').val(noyes);
            $('#chkBtn').removeAttr('disabled', false);
        } else {
            $('#chkBtn').attr('disabled', true);
        }
    });

    $('#chkList').submit(function(e) {
        e.preventDefault();
        var allCheck = $('#allCheck').val();
        if (allCheck == '1') {
            $.ajax({
                type: 'post',
                url: base_url + 'chk_listdata',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(rtn) {
                    if (rtn.error == '0') {
                        // $('#step_0').removeClass('btn-danger btn-warning btn-info').addClass('btn-success');
                        setTimeout(function() {
                            window.location.href = base_url + 'applicant';
                        }, 250);
                    } else if (rtn.error == '1') {
                        $.alert(rtn.error);
                    }
                },
                error: function() {
                    $.alert("Server busy, try later!");
                }
            });
        } else {
            $('#allCheck').val('0');
            $('#chkBtn').attr('disabled', true);
            return false;
        }

    });
    </script>
</div>
<?php $this->load->view("admin/footer"); ?>