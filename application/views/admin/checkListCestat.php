<?php
$assOrgs=getOrgAssMastersArray([]);
$adjOrgs=getOrgAdjMastersArray([]);
$adjDesgs=getAdjDesgMastersArray([]);
$assDesgs=getAssDesgMastersArray([]);
$selectYesNoArray=getSelectYesNoArray();
$yesNoArray=getYesNoArray();

?>

<script>
$(function() {
    $(document).on('click', '#check_listsub', function() {
        $('#form').parsley().validate();
        if ($('#form').parsley().isValid()) {
            var csrf_token = document.getElementById("csrf_token").value;
            $.ajax({
                type: 'POST',
                url: 'otherFeeDetail.php',
                data: $('#checklist').find('select,textarea,input').serialize() + '&' + $
                    .param({
                        'csrf_token': csrf_token
                    })
            }).done(function(data) {
                $('#otherfees').html(data);
            });
            $('#jurisdiction,#appDetail,#resDetail,#impugnDetail,#checklist').hide();
            $('#otherfeedetails,#otherfees').show();
        }
    });
});
</script>

<div class="row">
    <div class="col-md-12">

        <table class="table table-responsive-sm table-indent">
            <tr>
                <td valign="top" align="left">
                    <span class="font-weight-bold">1.</span> State/Union Territory and the Commissioneate in which the
                    order/decision of assessment/penalty/fine was made
                </td>
                <td valign="top" align="left">
                    <?=form_dropdown('ass_org',$assOrgs,set_value('ass_org',(isset($ass_org))?$ass_org:''),
           ['class'=>'form-control w-250','id'=>'ass_org']);?>
                </td>
            </tr>
            <tr>
                <td valign="top" align="left">
                    <span class="font-weight-bold">2.</span> Is the order appealed against relates to more than one
                    Commissionerate.?
                </td>
                <td valign="top" align="left">
                    <?=form_dropdown('add_comm',$selectYesNoArray,set_value('add_comm',(isset($add_comm))?$add_comm:''),
            ['class'=>'form-control w-250','id'=>'add_comm']);?>
                </td>
            </tr>

            <tr>

                <td valign="top" align="left"><span class="font-weight-bold">3.</span> Address of the adjudicating
                    authority in
                    cases where the order
                    appealed against is an order of the Commissioner
                    (Appeals)</td>
                <td valign="top" align="left">
                    <?=form_dropdown('adj_org',$adjOrgs,set_value('adj_org',(isset($adj_org))?$adj_org:''),
            ['class'=>'form-control w-250','id'=>'adj_org']);?>
                </td>
            </tr>

            <tr>

                <td valign="top" align="left"><span class="font-weight-bold">4.</span> Designation of the adjudicating
                    authority
                    in cases where the
                    order appealed against is an order of the Commissioner (Appeals)</td>
                <td valign="top" align="left">
                    <?=form_dropdown('adj_desig',$adjDesgs,set_value('adj_desig',(isset($adj_desig))?$adj_desig:''),
            ['class'=>'form-control w-250','id'=>'adj_desig']);?>
                </td>
            </tr>

            <tr>

                <td valign="top" align="left">
                    <font face="Verdana" size="2"><span class="font-weight-bold">5.</span><span class="error"></span>
                        The
                        designation and address of the authority passing the order appealed against </font>
                </td>
                <td valign="top" align="left">
                    <?=form_dropdown('ass_desig',$assDesgs,set_value('ass_desig',(isset($ass_desig))?$ass_desig:''),
            ['class'=>'form-control w-250','id'=>'ass_desig']);?>
                </td>
            </tr>

            <tr>

                <td valign="top" align="left">
                    <font face="Verdana" size="2"><span class="font-weight-bold">6.</span><span class="error"></span>
                        Whether
                        the decision or order appealed against involves any question having a relation to the rate of
                        duty of
                        excise or to the value of goods for purposes of assessment.</font>
                </td>
                <td valign="top" align="left">
                    <?=form_dropdown('app_quest',$yesNoArray,set_value('app_quest',(isset($app_quest))?$app_quest:''),['class'=>'form-control w-250','id'=>'app_quest']);?>
                </td>
            </tr>




            <!-------additional -->

            <tr>
                <td align="left">
                    <font face="Verdana, Arial, Helvetica" size="2"><span class="font-weight-bold">7.</span><span
                            class="error">*</span> Whether duty or penalty is deposited; if not, whether any application
                        for
                        dispensing with such deposit has been made</font>
                </td>
                <td align="left">
                    <?=form_dropdown('applic_dispensed',$yesNoArray,set_value('applic_dispensed',(isset($applic_dispensed))?$applic_dispensed:''),
            ['class'=>'form-control w-250','id'=>'applic_dispensed']);?>
            </tr>

            <?php
$case_type=1;
if($case_type==2 or $case_type==3)
{
    ?>


            <tr>

                <td align="left">
                    <font face="Verdana, Arial, Helvetica" size="2"><span class="font-weight-bold">8.</span><span
                            class="error">*</span> Does the order appealed against also involve any Customs Duty demand
                        and
                        related penalty,so far the appellant is concerned.?</font>
                </td>
                <td align="left">
                    <?=form_dropdown('cu_duty',$yesNoArray,set_value('cu_duty',(isset($cu_duty))?$cu_duty:''),
                ['class'=>'form-control w-250','id'=>'cu_duty']);?>
                </td>
            </tr>

            <?php
}
?>
            <?php
if ($case_type==1 or $case_type==3)
{
    ?>
            <tr>

                <td align="left">
                    <font face="Verdana, Arial, Helvetica" size="2"><span class="font-weight-bold">9.</span><span
                            class="error">*</span> Does the order appealed against also involve any Central Excise duty
                        demand
                        and relates fine or penalty,so far the appellant is concerned.?</font>
                </td>
                <td align="left">
                    <?=form_dropdown('ce_duty',$yesNoArray,set_value('ce_duty',(isset($ce_duty))?$ce_duty:''),
                ['class'=>'form-control w-250','id'=>'ce_duty']);?>
                </td>
            </tr>
            <?php
} ?>

            <?php

if ($case_type==1 or $case_type==2)
{
    ?>


            <tr>

                <td align="left">
                    <font face="Verdana, Arial, Helvetica" size="2"><span class="font-weight-bold">10.</span><span
                            class="error">*</span>Does the order appealed against also involve any Service Tax demand
                        and
                        related penalty,so far the appellant is concerned.?</font>
                </td>
                <td align="left">
                    <?=form_dropdown('st_duty',$yesNoArray,set_value('st_duty',(isset($st_duty))?$st_duty:''),
                ['class'=>'form-control w-250','id'=>'st_duty']);?>
                </td>
            </tr>

            <?php
}
?>




            <?php

if ($case_type==2)
{

    $casePriority=getSubMatterPriorityArray(['case_type'=>$case_type]);

    $casePriority1=array_merge([0=>'Priority 1'],$casePriority);
    $casePriority2=array_merge([0=>'Priority 2'],$casePriority);
    ?>

            <tr>

                <td valign="top" align="left" width="500">
                    <font face="Verdana" size="2"><span class="font-weight-bold">11.</span><span class="error"></span>
                        Subject
                        matter of Dispute in order of Priority </font>
                </td>
                <td valign="top" align="left" width="200" colspan="0">
                    <?=form_dropdown('ce_pri1',$casePriority1,set_value('ce_pri1',(isset($ce_pri1))?$ce_pri1:''),
                ['class'=>'form-control w-250 mb-3','id'=>'ce_pri1']);?>
                    <?=form_dropdown('ce_pri2',$casePriority2,set_value('ce_pri2',(isset($ce_pri2))?$ce_pri2:''),
                ['class'=>'form-control w-250','id'=>'ce_pri2']);?>

                </td>
            </tr>

            <?php
}
?>



            <?php

if ($case_type==3)
{
    $casePriority=getSubMatterPriorityArray(['case_type'=>"$case_type"]);
    $casePriority1=array_merge([0=>'Priority 1'],$casePriority);
    $casePriority2=array_merge([0=>'Priority 2'],$casePriority);
    ?>

            <tr>

                <td valign="top" align="left" width="500">
                    <font face="Verdana" size="2"><span class="font-weight-bold">10.</span><span class="error"></span>
                        Subject
                        matter of Dispute in order of Priority </font>
                </td>
                <td valign="top" align="left" width="200" colspan="0">
                    <?=form_dropdown('st_pri1',$casePriority1,set_value('st_pri1',(isset($st_pri1))?$st_pri1:''),
                ['class'=>'form-control w-250 mb-3','id'=>'st_pri1']);?>
                    <?=form_dropdown('st_pri2',$casePriority2,set_value('st_pri2',(isset($st_pri2))?$st_pri2:''),
                ['class'=>'form-control w-250','id'=>'st_pri2']);?>
                </td>
            </tr>

            <?php
}
?>
            <?php

if ($case_type==1)
{
    $casePriority=getSubMatterPriorityArray(['case_type'=>"$case_type",'class'=>'IMPORT']);

    $casePriority1=array_merge([0=>'Priority 1'],$casePriority);
    $casePriority2=array_merge([0=>'Priority 2'],$casePriority);
    ?>

            <tr>

                <td valign="top" align="left" width="500">
                    <font face="Verdana" size="2"><span class="font-weight-bold">11.</span><span class="error"></span>
                        Subject
                        matter of Dispute in order of Priority </font>
                </td>
                <td valign="top" align="left" width="200" colspan="0">
                    <b class="ml-4">IMPORT</b>
                    <?=form_dropdown('cu_pri_imp1',$casePriority1,set_value('cu_pri_imp1',(isset($cu_pri_imp1))?$cu_pri_imp1:''),
                ['class'=>'form-control w-250 mb-3','id'=>'cu_pri_imp1']);?>
                    <?=form_dropdown('cu_pri_imp2',$casePriority2,set_value('cu_pri_imp2',(isset($cu_pri_imp2))?$cu_pri_imp2:''),
                ['class'=>'form-control w-250','id'=>'cu_pri_imp2']);?>

                </td>
            </tr>

            <tr>

                <td valign="top" align="left" width="500"><span class="font-weight-bold">12.</span>
                    <font face="Verdana" size="2"><span class="error"></span></font>
                </td>
                <td valign="top" align="left" width="200" colspan="0">
                    <b class="ml-4">EXPORT</b>
                    <?php
            $casePriority=getSubMatterPriorityArray(['case_type'=>"$case_type",'class'=>'EXPORT']);
            $casePriority1=array_merge([0=>'Priority 1'],$casePriority);
            $casePriority2=array_merge([0=>'Priority 2'],$casePriority);
            ?>
                    <?=form_dropdown('cu_pri_exp1',$casePriority1,set_value('cu_pri_exp1',(isset($cu_pri_exp1))?$cu_pri_exp1:''),
                ['class'=>'form-control w-250 mb-3','id'=>'cu_pri_exp1']);?>
                    <?=form_dropdown('cu_pri_exp2',$casePriority2,set_value('cu_pri_exp2',(isset($cu_pri_exp2))?$cu_pri_exp2:''),
                ['class'=>'form-control w-250','id'=>'cu_pri_exp1']);?>

                </td>
            </tr>


            <tr>

                <td valign="top" align="left" width="500"><span class="font-weight-bold">13.</span>
                    <font face="Verdana" size="2"><span class="error"></span></font>
                </td>
                <td valign="top" align="left" width="200" colspan="0">
                    <b class="ml-4">GENERAL</b>
                    <?php
            $casePriority=getSubMatterPriorityArray(['case_type'=>"$case_type",'class'=>'GENERAL']);
            $casePriority1=array_merge([0=>'Priority 1'],$casePriority);
            $casePriority2=array_merge([0=>'Priority 2'],$casePriority);
            ?>
                    <?=form_dropdown('cu_pri_gen1',$casePriority1,set_value('cu_pri_gen1',(isset($cu_pri_gen1))?$cu_pri_gen1:''),
                ['class'=>'form-control w-250 mb-3','id'=>'cu_pri_gen1']);?>
                    <?=form_dropdown('cu_pri_gen2',$casePriority2,set_value('cu_pri_gen2',(isset($cu_pri_gen2))?$cu_pri_gen2:''),
                ['class'=>'form-control w-250','id'=>'cu_pri_gen2']);?>
                </td>
            </tr>
            <?php

}
?>

        </table>
    </div>
</div>