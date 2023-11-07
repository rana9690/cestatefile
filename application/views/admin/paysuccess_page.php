<?php print_r($data);die; ?>

<html>
<head><title>Efiling Invoice</title></head>
<body class="b1" id="testdiv" style="font-family: Arial; font-size: 14px;">
<form name="form2" method="post" action="">
    <div id="btnPrint" class="pr-hide"><a  target="_blank" href="<?php echo base_url(); ?>payslip/<?php echo $_REQUEST['filingno']; ?>">
     <?php if($filing_no==''){?>
		 <font color="red" size="1"><img src="<?php echo base_url(); ?>asset/images/pdf.png" class="no-print" border='0' height='22' width='22'></font>
    <?php } ?>
    </a>
    </div>
    <div class="container margin-top-30 defect-pattern">
        <?php


        $curYear = date('Y');
        $curMonth = date('m');
        $curDay = date('d');
        $dateprint = "$curDay/$curMonth/$curYear";
        $curdate = "$curYear-$curMonth-$curDay";
        $filingNo = $filing_no;
        //$filingNo='100010022882017';
        $iaYear = $_REQUEST['year'];
        $sql22 = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filingNo);
        foreach($sql22 as $row) {
            $petName = $row->pet_name;
            $resName = $row->res_name;
            $case_no = $row->case_no;
            $case_type = $row->case_type;
            $resName = $row->res_name;
            $fDate = $row->dt_of_filing;
            $pet_adv = $row->pet_adv;
            $soft_copy = $row->soft_copy;
            if ($case_no != "") {
                $case_numaa = substr($case_no, 4, 7);
                $case_num1aa = ltrim($case_numaa, 0);
                $case_year1aa = substr($case_no, 11, 4);
            }
            if ($case_type != "") {
                $stQ = $this->efiling_model->data_list_where('master_case_type','case_type_code',$case_type);
                $case_type_short_name = $stQ[0]->short_name;
            }
            ?>
            <div class="row ">
                <div class="col-sm-12 fl-center"> <b><center><u>RECEIPT</u>  <center></b></div>
                <div class="col-sm-12 fl-center"><b><center><u>APPELLATE TRIBUNAL FOR ELECTRICITY</u> <center> </b> </div>
                <div class="col-sm-12"><center>Core 4,7th Floor,SCOPE Builiding,Lodhi Road,New Delhi-110003</center></div>
            </div>
            <div class="row " style="margin-top: 15px;">
                <div class="col-sm-6">
                    <?php
                    $filing_No = substr($filingNo, 5, 6);
                    $filing_No = ltrim($filing_No, 0);
                    $filingYear = substr($filingNo, 11, 4);
                    echo "DFR/$filing_No/$filingYear";
                    ?>
                </div>
                <div class="col-sm-6" style="float: right;">
                    <center> Date: <?php echo $dateprint; ?></center>
                </div>
            </div>
                <div class="row ">
                    <div class="col-sm-6">
                        Case Type:-<?php echo $case_type_short_name; ?>
                    </div>
                </div>
            <div class="row ">
                <div class="col-sm-6">
                    Appellant Name:-  <?php echo $petName; ?>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-6">
                    Transaction Id:- <?php   echo $refId;  ?>
                </div>
            </div>
            
              <div class="row ">
                <div class="col-sm-6">
                    Bank Transaction Id:- <?php   echo $resName;  ?>
                </div>
            </div>
        
            
            <div class="row ">
                <div class="col-sm-6">
                   Payment Date:- <?php   echo $bankTransacstionDate;  ?>
                </div>
            </div>
            
            <div class="row" style="margin-bottom: 10px;margin-top: 20px;">
                <table class="table" style="width:100%; font-size: 12px;" cellpadding="0" cellspacing="0">
                    <tr><td colspan="4" align="center" style="padding-bottom: 10px"><font color="#510812" size="3"><b>Impugned order Details</b></font></td> </tr>
                    <tr>
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left; padding: 10px 0;"> Commission Name</th>
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"> Case No</th>
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;">Case Year</th>
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"> Date of Order</th>
                    </tr>
                    <?php
                    if($case_type == 1) {
                        $case = $this->efiling_model->data_list_where('lower_court_detail','filing_no',$filingNo);
                        foreach ($case as $row) {
                        $case_year = $row->case_year;
                        $case_no = $row->case_no;
                        $decision_date = $row->decision_date;
                        $commission = $row->commission;
                        $nature_of_order = $row->nature_of_order;
                        if ($commission == '0' OR $commission == 'NULL') {
                            $commission = '-';
                        }
                        if ($commission > '0') {
                            $case_t = $this->efiling_model->data_list_where('master_commission','id',$commission);
                            $commission_name = $case_t[0]->full_name;
                        }
                        $decision_date1 = explode("-", $decision_date);
                        ?>
                        <tr>
                            <td style="padding: 10px 0;"><?php echo htmlspecialchars($commission_name); ?></td>
                            <td style="padding: 10px 0;"><?php echo htmlspecialchars($case_no); ?></td>
                            <td style="padding: 10px 0;"><?php echo htmlspecialchars($case_year); ?> </td>
                            <td style="padding: 10px 0;"><?php echo htmlspecialchars($decision_date1[2] . "/" . $decision_date1[1] . "/" . $decision_date1[0]); ?></td>
                        </tr>
                        <?php
                    }
                } else {?>
                     <tr> 
                        <td style="padding: 10px 0;">NA </td>
                        <td style="padding: 10px 0;">NA </td>
                        <td style="padding: 10px 0;">NA </td>
                        <td style="padding: 10px 0;">NA </td>
                     </tr>
               <?php  }
               $sqlia = $this->efiling_model->data_list_where('ia_detail','filing_no',$filingNo);
               $total = count($sqlia); ?>
                </table>
            </div>
            <div class="row ">
                <div class="col-sm-6"><b>No. of IA :-  <?php echo htmlspecialchars($total); ?> </b></div>
            </div>
            <?php
            $sum = 0;
            $resum = 0;
            $lessrs = 0;
            $case_t = $this->efiling_model->data_list_where('aptel_account_details','filing_no',$filingNo);
            foreach ($case_t as $row) {
                $fee_amount = $row->fee_amount;
                $amount = $row->amount;
                $court_fee = $row->court_fee;
                $ia_fee = $row->ia_fee;
                $other_fee = $row->other_fee;
                $sum = $fee_amount + $ia_fee + $other_fee;
                $resum = $resum + $amount;
                if ($sum > 0) {
                    $lessrs = $sum - $resum;
                }
            }
            ?>
            <br>
            <div class="row " style="margin-bottom: 10px;margin-top: 20px;">
                <div class="col-sm-6"><b>Amount Received:- <?php echo htmlspecialchars($totalAmount); ?> </b></div>
            </div>
            <div class="row ">
                <table class="table" style="width:100%; font-size: 12px;" cellpadding="0" cellspacing="0">
                    <tr><td colspan="4" align="center" style="padding-bottom: 10px"><font color="#510812" size="3"><b>Caveat Details </b></font> </td></tr>
                    <tr>
                        <td  align="left" style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left; padding: 10px 0"><font color="#510812">Caveater No</font></td>
                        <td align="left" style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"><font color="#510812">Caveator Name : </font></td>
                        <td  align="left" style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"><font color="#510812">Filed By :</font></td>
                        <td  align="left" style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"><font color="#510812">Date of Caveat Filing</font></td>
                    </tr>
                    <?php
                    $qu_lower_court =$this->efiling_model->data_list_where('lower_court_detail','filing_no',$filingNo);  
                  //  "select filing_no,case_no,case_year,decision_date,commission from lower_court_detail where filing_no  = ?";
                    $qu_caveat_detail_data = array();
                    if (!empty($qu_lower_court) && is_array($qu_lower_court)) {
                        foreach ($qu_lower_court as $val_l_court) {
                            $where =array(
                                'case_no' =>$val_l_court->case_no,
                                'case_year' =>$val_l_court->case_year,
                                'decision_date'=>$val_l_court->decision_date,
                                'commission'=>$val_l_court->commission,
                            );
                            $qu_caveat_detail = $this->efiling_model->data_list_mulwhere('caveat_detail',$where); 
                            $qu_caveat_detail_data[] = $qu_caveat_detail;
                        }
                    }

                    if (!empty($qu_caveat_detail_data) && is_array($qu_caveat_detail_data)) {
                        foreach ($qu_caveat_detail_data as $val_data) {
                            //  print_r($val_data);
                            if (!empty($val_data) && is_array($val_data)) {
                                foreach ($val_data as $val_dataa) {
                                    $caveat_no = ltrim(substr($val_dataa->caveat_filing_no, 5, 6), 0);
                                    $caveat_date = $val_dataa->caveat_filing_date;
                                    $caveat_counsil = $val_dataa->council_name;
                                    $caveat_name = $val_dataa->caveat_name;
                                    $qu_master_advocate = $this->efiling_model->data_list_where('master_advocate','adv_code',$caveat_counsil);
                                    $adv_name = $qu_master_advocate[0]->adv_name;
                                    ?>
                                    <tr>
                                        <td align="left"><font color="#510812"   size="3"><?php echo $caveat_no; ?> </font></td>
                                        <td align="left"><font color="#510812"   size="3"><?php echo $caveat_name; ?></font> </td>
                                        <td align="left"><font color="#510812"   size="3"><?php echo $adv_name; ?></font></td>
                                        <td  align="left"><font color="#510812"  size="3"><?php   echo  date('d/m/Y', strtotime($caveat_date));  ?></font>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    } else { ?>
                        <tr>
                            <td  align="left"><font color="#510812" size="3"><?php echo "N.A"; ?> </font> </td>
                            <td  align="left"><font color="#510812" size="3"><?php echo "N.A"; ?></font></td>
                            <td  align="left"><font color="#510812" size="3"><?php echo "N.A"; ?></font></td>
                            <td  align="left"><font color="#510812" size="3"><?php echo "N.A"; ?></font></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <table class="table" width="100%">
                <tr> <td colspan="6" align="right"> <b>COUNTER ASSISTANT </b> </td> </tr>
                <tr><td colspan="8" align="right"><br><img src="<?php echo base_url();?>asset/images/stamp.jpg" style="width:100px;"></td>
                </tr>
            </table>
            <?php } ?>
        <div class="pagebreak">
        </div>
        <img src="<?php echo base_url();?>asset/images/bg.jpg" style="position:absolute; left:0; right:0; top:0; bottom:0; margin:auto; z-index: -1;">
</form>
</body>
</html>

<script>




</script>