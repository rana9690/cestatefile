<?php
$issues=getIssueMasterArray([]);
$paymentDuties=getPaymentModeDutyArray([]);
$paymentPenalties=getPaymentModePenaltyArray([]);
$paymentModePenalties=getPaymentModePenaltyArray([]);
?>

<script>
$(document).on('click', '#otherfeesub', function() {

    var csrf_token = document.getElementById("csrf_token").value;
    if ($("#page_acty").val() == '1') {
        if ($.isNumeric($("#refund_ord").val())) disid = 'document';
        else var disid = 'payment';
        if ($.isNumeric($("#refund_ord").val())) url = 'document.php';
        else url = 'paymentDetail.php';
    } else {
        disid = 'document';
        url = 'document.php';
    }
    $.ajax({
        cache: false,
        type: 'POST',
        url: url,
        data: $('#otherfees').find('select,textarea,input').serialize() + '&' + $.param({
            'csrf_token': csrf_token
        })
    }).done(function(data) {
        $('#' + disid).html(data);
    });
    $('#jurisdiction,#appDetail,#resDetail,#impugnDetail,#otherfees').hide();
    $('#document,#documentView,#payment,#accountView').hide();
    if ($("#page_acty").val() == '1') {
        if ($.isNumeric($("#refund_ord").val())) $('#document,#documentView').show();
        else $('#payment,#accountView').show();
    } else {
        $('#document,#documentView').show();
    }

});

$(document).on("keyup", "#duty_tax_ord", function() {
    $("#duty_tax_pd").val($('#duty_tax_ord').val());
});
$(document).on("keyup", "#penalty_ord", function() {
    $("#penalty_pd").val($('#penalty_ord').val());
});
$(document).on("keyup", "#refund_ord", function() {
    $("#refund_pd").val($('#refund_ord').val());
});
$(document).on("keyup", "#fine_int_ord", function() {
    $("#fine_int_pd").val($('#fine_int_ord').val());
});
$(document).on("keyup", "#inter_ord", function() {
    $("#inter_pd").val($('#inter_ord').val());
});
$(document).on("keyup", "#rp_ord", function() {
    $("#rp_pd").val($('#rp_ord').val());
});
</script>

<div class="row">
    <div class="col-md-12">
        <table class="table table-responsive-sm">
            <tr>
                <td class="text-left font-weight-bold"> Description and classification of goods</td>
                <td class="text-left" colspan="2">
                    <input type="hidden" name="page_acty" id="page_acty" value="<?php echo $apply_by ?>">
                    <textarea class="form-control w-250" name="goods"
                        style="resize: none;"><?php echo $goods; ?></textarea>
                </td>
                <td class="text-left">
                    <?=form_dropdown('classification',$issues,set_value('classification',(isset($classification))?$classification:''),
                                ['class'=>'form-control w-250','id'=>'classification']);?>
                </td>
                <td class="text-left font-weight-bold" colspan="2"></td>



            </tr>
            <tr>
                <td class="text-left font-weight-bold">
                    <span class="error">*</span> Period of Dispute :
                </td>
                <td class="text-left">
                    <?= form_input(['name'=>'dispute_st_dt','value'=>set_value('dispute_st_dt',(isset($dispute_st_dt))?date('d-m-Y',strtotime($dispute_st_dt)):''),
                                'class'=>'form-control w-100 datepicker','id'=>'dispute_st_dt','maxlength'=>'10','title'=>'', 'placeholder'=>'From Date']) ?>
                    (dd/mm/yyyy)
                </td>
                <td class="text-left">
                    <?= form_input(['name'=>'dispute_en_dt','value'=>set_value('dispute_en_dt',(isset($dispute_en_dt))?date('d-m-Y',strtotime($dispute_en_dt)):''),
                                'class'=>'form-control w-100 datepicker','id'=>'dispute_en_dt','maxlength'=>'10','title'=>'', 'placeholder'=>'To Date']) ?>
                    (dd/mm/yyyy)
                </td>
                <td class="text-left" colspan="4"></td>

            </tr>


            <tr>

                <td class="text-left font-weight-bold"> Amount of Duty, if any, demanded for the period mentioned in
                    item</td>
                <td class="text-left">
                    <input id="duty_tax_ord" type="text" onkeypress="return isNumberKey(event)"
                        class="form-control w-100" maxlength="35" name="duty_tax_ord"
                        value="<?php echo $duty_tax_ord; ?>">ORDERED
                </td>
                <!--<input  id="1" type="text" maxlength="35" name="duty_tax_ord" value="0">-->
                <td class="text-left">
                    <input id="duty_tax_pd" type="text" class="form-control w-100"
                        onkeypress="return isNumberKey(event)" maxlength="35" name="duty_tax_pd"
                        value="<?php echo $duty_tax_pd; ?>">PAID
                    <!--<input  id="1" type="text" maxlength="35" name="duty_tax_pd" value="0">-->
                </td>

                <td class="text-left font-weight-bold"> Mode of pre-deposited Duty Amount paid :</td>
                <td class="text-left" colspan="2">
                    <?=form_dropdown('pay_mode_duty',$paymentDuties,set_value('pay_mode_duty',(isset($pay_mode_duty))?$pay_mode_duty:''),
                                ['class'=>'form-control w-250','id'=>'pay_mode_duty']);?>
                </td>
            </tr>

            <tr>

                <td class="text-left font-weight-bold"> Amount of Penalty Imposed</td>
                <td class="text-left">
                    <input id="penalty_ord" type="text" class="not_clear form-control w-100"
                        onkeypress="return isNumberKey(event)" maxlength="35" name="penalty_ord"
                        value="<?php echo htmlspecialchars(htmlentities($penalty_ord)); ?>">ORDERED
                </td>
                <!--<input  id="1" type="text" maxlength="35" name="penalty_ord" value="0">-->


                <td class="text-left">
                    <input id="penalty_pd" type="text" class="not_clear form-control w-100"
                        onkeypress="return isNumberKey(event)" maxlength="35" name="penalty_pd"
                        value="<?php echo htmlspecialchars(htmlentities($penalty_pd)); ?>">PAID
                    <!--<input  id="1" type="text" maxlength="35" name="penalty_pd" value="0">-->
                </td>


                <td class="text-left font-weight-bold"> Mode of of pre-deposited Penalty Amount paid : </td>
                <td class="text-left" colspan="2">
                    <?=form_dropdown('pay_mode_penalty',$paymentDuties,set_value('pay_mode_penalty',(isset($pay_mode_penalty))?$pay_mode_penalty:''),
                                ['class'=>'form-control w-250','maxlength'=>'35','id'=>'pay_mode_penalty']);?>
                </td>
            </tr>
            <tr>

                <td class="text-left font-weight-bold">
                    Amount of Refund, if any, demanded for the period mentioned in item</font>
                </td>
                <td class="text-left">

                    <?= form_input(['name'=>'refund_ord','value'=>set_value('refund_ord',(isset($refund_ord))?$refund_ord:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'refund_ord','maxlength'=>'35','title'=>'']) ?>

                    ORDERED</td>



                <td class="text-left">

                    <?= form_input(['name'=>'refund_pd','value'=>set_value('refund_pd',(isset($refund_pd))?$refund_pd:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'refund_pd','maxlength'=>'35','title'=>'']) ?>

                    PAID

                </td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left">&nbsp;</td>



            </tr>
            <tr>
                <td class="text-left font-weight-bold"> Amount of fine Imposed</td>
                <td class="text-left">

                    <?= form_input(['name'=>'fine_int_ord','value'=>set_value('fine_int_ord',(isset($fine_int_ord))?$fine_int_ord:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'fine_int_ord','maxlength'=>'35','title'=>'']) ?>

                    ORDERED</td>


                <td class="text-left">
                    <?= form_input(['name'=>'fine_int_pd','value'=>set_value('fine_int_pd',(isset($fine_int_pd))?$fine_int_pd:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'fine_int_pd','maxlength'=>'35','title'=>'']) ?>

                    PAID

                </td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
            </tr>


            <tr>
                <td class="text-left font-weight-bold">
                    Amount of Intersest Imposed</font>
                </td>
                <td class="text-left">
                    <?= form_input(['name'=>'inter_ord','value'=>set_value('inter_ord',(isset($inter_ord))?$inter_ord:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'inter_ord','maxlength'=>'35','title'=>'']) ?>

                    ORDERED
                </td>
                <td class="text-left">
                    <?= form_input(['name'=>'inter_pd','value'=>set_value('inter_pd',(isset($inter_pd))?$inter_pd:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'inter_pd','maxlength'=>'35','title'=>'']) ?>
                    PAID
                </td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left">&nbsp;</td>

            </tr>
            <tr>
                <td class="text-left font-weight-bold">
                    Amount of Redemption Fine Imposed</font>
                </td>
                <td class="text-left">
                    <?= form_input(['name'=>'rp_ord','value'=>set_value('rp_ord',(isset($rp_ord))?$rp_ord:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'rp_ord','maxlength'=>'35','title'=>'']) ?>
                    ORDERED
                </td>
                <td class="text-left">
                    <?= form_input(['name'=>'rp_pd','value'=>set_value('rp_pd',(isset($rp_pd))?$rp_pd:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'rp_pd','maxlength'=>'35','title'=>'']) ?>
                    PAID
                </td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
            </tr>

            <tr>
                <td class="text-left font-weight-bold">
                    Market value of Seized Goods</td>
                <td class="text-left">
                    <?= form_input(['name'=>'mkt_value','value'=>set_value('mkt_value',(isset($mkt_value))?$mkt_value:''),'onkeypress'=>"return isNumberKey(event)",'class'=>'form-control w-100','id'=>'mkt_value','maxlength'=>'35','title'=>'']) ?>
                    ORDERED
                </td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
                <td class="text-left">&nbsp;</td>
            </tr>
        </table>
    </div>
</div>