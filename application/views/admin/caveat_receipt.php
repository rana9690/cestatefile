<?php
$userdata=$this->session->userdata('login_success');

$user_id=$userdata[0]->id;
if ($user_id != '' and $user_id != '') {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Receipt</title>
        <script>
            function change(id, newClass) {
                identity = document.getElementById(id);
                identity.className = newClass;

            }

            function printPage() {
                change("testdiv", "true");
                window.print();
            }
        </script>
    </head>
    <body style="font-size:16px; font-family: 'Times New Roman', Times, serif">
    <div id="testdiv" class="pr-hide"><a href="javascript:printPage();">
            <font color="red" size="1"><img src="<?php echo base_url(); ?>asset/images/print.gif" class="no-print" border='0'/></font></a>
    </div>
    <?php
    $curYear = date('Y');
    $curMonth = date('m');
    $curDay = date('d');
    $dateprint = "$curDay/$curMonth/$curYear";
    $curdate = "$curYear-$curMonth-$curDay";
    $filingNo = $filing_no;
    $row4441=$this->efiling_model->data_list_where('caveat_detail','caveat_filing_no',$filingNo);
    foreach ($row4441 as $row444) {
            //echo $filing_no=$row['filing_no'];
            $caveat_name = $row444->caveat_name;
            if($caveat_name!=''){
                $caveat_name=$this->efiling_model->getColumn('master_org','org_name','org_id',$caveat_name);
            }
            
            $caveatee_name = $row444->caveatee_name;
            if($caveatee_name!=''){
                $caveatee_name=$this->efiling_model->getColumn('master_org','org_name','org_id',$caveatee_name);
            }
            
            $case_no = $row444->case_no;
            $case_year = $row444->case_year;
            $decision_date = $row444->decision_date;
            $commission = $row444->commission;
            $sql22_aptel_account_details = $this->efiling_model->data_list_where('aptel_account_details','filing_no',$filingNo);
            foreach($sql22_aptel_account_details as  $row_aptel_acco) {
                $fee_amount+= $row_aptel_acco->fee_amount;
            }
        }
        
 
    ?>
    <div style="position: relative;">
        <p style="text-align:center; font-family: Arial, Helvetica, sans-serif; font-size: 20px; margin: 0; line-height: 2.6;">
            <u><b>RECEIPT</b></u></p>
        <p style="text-align:center; font-size: 24px; margin: 0;"><u>APPELLATE TRIBUNAL FOR ELECTRICITY</u></p>
        <p style="text-align:center; margin: 0;">Core- 4, 7th Floor Scope Complex Lodhi Road New Delhi-110003</p>

        <div style="overflow: hidden;">
            <div style="float: left; width: 50%;">
                <p>
                    <?php
                    $filing_No = substr($filingNo, 5, 6);
                    $filing_No = ltrim($filing_No, 0);
                    $filingYear = substr($filingNo, 11, 4);
                    echo "Caveat No. :- CAVEAT/$filing_No/$filingYear";

                    ?></p>
                    <p style="margin: 0;">CASE TYPE:- <?php echo 'Caveat'; ?></p>
        <p><b><?php echo $caveat_name; ?></b> <span style="float: right; margin-right: 31%;"> ...Caveator</span>
        </p>
        <p><b><?php echo $caveatee_name; ?></b> <span style="float: right; margin-right: 31%;"> ...Expected Appellant</span>
        </p>
            </div>
            <div style="float: right; width: 50%; text-align: right;">
                <p>DATE OF FILING : <?php echo $dateprint; ?></p>
                 <img src="<?php echo base_url(); ?>qrcodeci/<?php echo $image; ?>" height="100px"></img>
            </div>
        </div>

        
        <?php

        ?>
        <table border="1" cellpadding="3" style="width:100%;border-collapse:collapse">
            <tbody>
            <tr>
                <td rowspan="100" style="text-align:center"><b>Impugned order Details</b></td>
                <td>Commission Name</td>
                <td>Case No.</td>
                <td>Case Year</td>
                <td>Date of Order</td>
            </tr>
            <tr>
                <td><?php
                    $commision_anme = '';
                    $hscquery = $this->efiling_model->data_list_where('master_commission','id',$commission);
                    foreach ($hscquery as $row) {
                        $commision_anme = $row->short_name;
                    }
                    echo $commision_anme; ?></td>
                <td><?php echo $case_no; ?></td>
                <td><?php echo $case_year; ?></td>
                <td><?php echo date('d/m/Y',strtotime($decision_date)); ?></td>
            </tr>

            <?php

            $additional_commision = $this->efiling_model->data_list_where('additional_commision','filing_no',$filingNo);
            $total_additional_commision = count($additional_commision);
            if ($total_additional_commision > 0) {
                $sql22_caveat_detail =$this->efiling_model->data_list_where('additional_commision','filing_no',$filingNo);
                foreach ($sql22_caveat_detail as $row444) {
                        $caveat_name = $row444->caveat_name;
                        $caveatee_name = $row444->caveatee_name;
                        $case_no = $row444->case_no;
                        $case_year = $row444->case_year;
                        $decision_date = $row444->decision_date;
                        $commission = $row444->commission;
                        ?>
                        <tr>
                            <td><?php
                                $commision_anme = '';
                                $hscquery =$this->efiling_model->data_list_where('master_commission','id',$commission);
                                foreach ($hscquery as $row) {
                                    $commision_anme = $row->short_name;
                                }
                                echo $commision_anme; ?></td>
                            <td><?php echo $case_no; ?></td>
                            <td><?php echo $case_year; ?></td>
                            <td><?php echo $decision_date; ?></td>
                        </tr>
                        <?php
                    }
       
            } ?>

            </tbody>
        </table>

        <table border="0" style="width:100%;">
            <tr>
                <td style="width:100%" valign="top">
                    <p><b>&nbsp;</b></p>
                    <p><b>Amount Received :- <?php echo $fee_amount; ?></b></p>
                </td>
            </tr>
        </table>
        <img src="<?php echo base_url(); ?>asset/images/bg.jpg" style="position:absolute; left:0; right:0; top:0; bottom:0; margin:auto; z-index: -1;">
    </div>
    </body>
    </html>
<?php } ?>