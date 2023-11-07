

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Efiling Invoice</title>
    <style>
        .modal-content {
            background-color: #f8e6d8;
        }
        .receipt-box {
            position: relative;
            box-shadow: 0 0 10px #00000012;
            padding: 10px;
            margin-top: 10px;
            border-radius: 10px;
            background: #edf0f8;
        }
    </style>
</head>
<body style="font-size:16px; font-family: 'Times New Roman', Times, serif">

    <div class="col-md-12">



<form name="form2" method="post" action="">

    <div id="btnPrint" class="pr-hide">
        <a  target="_blank" href="<?php echo base_url(); ?>payslip/<?php echo $filing_no; ?>">
		 <font color="red" size="1">
             <img src="<?php echo base_url(); ?>asset/images/print.gif" class="no-print" border='0'/></font></a>
    </div>
    <div class="receipt-box">

        <?php
       // echo $filing_no;die;

        $curYear = date('Y');
        $curMonth = date('m');
        $curDay = date('d');
        $dateprint = "$curDay/$curMonth/$curYear";
        $curdate = "$curYear-$curMonth-$curDay";
        
        $filingNo = isset($_REQUEST['filingno'])?$_REQUEST['filingno']:$filing_no;

        $fno=$filingNo;
        //$filingNo='100010022882017';
        $iaYear = isset($_REQUEST['year'])?$_REQUEST['year']:'';
        $sql22 = $this->db->get_where('aptel_case_detail',['filing_no'=>$filingNo]);
        $row=$sql22->row();

            $bench=getSchemasNames($row->bench);

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
                $stQ = getCaseTypes(['case_type_code'=>$case_type]);//$this->efiling_model->data_list_where('master_case_type','case_type_code',$case_type);
                $case_type_short_name = $stQ[0]['short_name'];
            }
            ?>


                <p style="text-align:center; font-family: Arial, Helvetica, sans-serif; font-size: 20px; margin: 0; line-height: 2.6;">
                    <u><b>RECEIPT</b></u>
                </p>
                <p style="text-align:center; font-size: 24px; margin: 0; margin-bottom: 25px;"><u><?=$this->config->item('site_name')?></u></p>
                <p style="text-align:center; margin: 0 0 40px 0;"><?=$bench->address?></p>



        <div style="overflow: hidden;">
            <div style="float: left; width: 50%;">
                <p class="text-danger">
                    <?php
                    $filing_No = substr($filingNo, 6, 6);
                    $filing_No = ltrim($filing_No, 0);
                    $filingYear = substr($filingNo,-4);
                    echo "DIARY NO/$filing_No/$filingYear";
                    ?>
                </p>


                    <p>
                        Case Type:-<?php echo $case_type_short_name; ?>


                    <p>
                        Appellant Name:-  <?php echo $petName; ?> <?php echo $this->efiling_model->fn_addition_party($fno,'1');?>
                    </p>


                    <p>
                        Respondent Name:- <?php   echo $resName;  ?> <?php echo $this->efiling_model->fn_addition_partyr($fno,'2');?>
                    </p>
            </div>

                <div style="float: right; width: 50%; text-align: right;">
                    <p class="text-danger"> Date: <?php echo $dateprint; ?></p>
                    
                    <img src="<?php echo base_url(); ?>qrcode/<?php echo $image; ?>" height="100px"></img>
                </div>




                <table class="table" style="width:100%; font-size: 12px;border: 5px;" cellpadding="0" cellspacing="0">
                    <tr><td colspan="4" align="center" style="padding-bottom: 10px"><font color="#510812" size="3"><b>Impugned order Details</b></font></td> </tr>
                    <tr>
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left; padding: 10px 0;"><?=$this->lang->line('commissionLabel')?></th>
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"><?=$this->lang->line('impugnedType')?></th>
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"> <?=$this->lang->line('impugnedOrderNo')?></th>
                        <!--th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;">Case Year</th-->
                        <th style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: left;"> Date of Order</th>
                    </tr>
                    <?php
                   // if($case_type == 1 || $case_type == 5  || $case_type == 4 || $case_type == 6) {
                        $case = $this->efiling_model->data_list_where('additional_commision','filing_no',$filingNo);
                        foreach ($case as $row) {
                        $case_year = $row->case_year;
                        $case_no = $row->case_no;
                        $decision_date = $row->decision_date;
                        $commission = $row->commission;
                        $nature_of_order = $row->nature_of_order;
                        if ($commission == '0' OR $commission == 'NULL') {
                            $commission = '-';
                        }
                        $case_type= $row->case_type;
                        if ($commission > '0') {

                            $case_t = getIss_auth_master(['org_code'=>$commission]);//$this->efiling_model->data_list_where('master_commission','id',$commission);
                            $commission_name = $case_t[0]['org_name'];
                        }
                        
                        if ($case_type != "") {
                            $stQ = getCaseTypes(['case_type_code'=>$case_type]);
                            //$this->efiling_model->data_list_where('master_case_type','case_type_code',$case_type);
                            $case_type_short_name = $stQ[0]['short_name'];
                        }
                        
                        $decision_date1 = explode("-", $decision_date);
                        ?>
                        <tr>
                            <td style="padding: 10px 0;"><?php echo htmlspecialchars($commission_name); ?></td>
                             <td style="padding: 10px 0;"><?php echo htmlspecialchars($case_type_short_name); ?></td>
                            <td style="padding: 10px 0;"><?php echo htmlspecialchars($case_no); ?></td>
                            
                            <td style="padding: 10px 0;"><?php echo htmlspecialchars($decision_date1[2] . "/" . $decision_date1[1] . "/" . $decision_date1[0]); ?></td>
                        </tr>
                        <?php
                    }
                /*} else {?>
                     <tr> 
                        <td style="padding: 10px 0;">- </td>
                        <td style="padding: 10px 0;">- </td>
                        <td style="padding: 10px 0;">- </td>
                        <td style="padding: 10px 0;">- </td>
                     </tr>
               <?php  }*/
                       /*check ia previlages*/
                    if($this->config->item('ia_privilege')==true) {
                        $sqlia = $this->efiling_model->data_list_where('ia_detail', 'filing_no', $filingNo);
                        $total = count($sqlia);
                    }?>
                </table>

            <?php /*check ia previlages*/
            if($this->config->item('ia_privilege')==true) {  ?>
            <div class="row ">
                <div class="col-sm-6"><b>No. of IA :-  <?php echo htmlspecialchars($total); ?> </b></div>
            </div>
                <?php }?>
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
                <div class="col-sm-6"><b>Amount Received:- <?php echo htmlspecialchars($resum); ?> </b></div>
            </div>
            <?php if($this->config->item('caviat_privilege')==true):?>
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
                            <td  align="left"><font color="#510812" size="3"><?php echo "-"; ?> </font> </td>
                            <td  align="left"><font color="#510812" size="3"><?php echo "-"; ?></font></td>
                            <td  align="left"><font color="#510812" size="3"><?php echo "-"; ?></font></td>
                            <td  align="left"><font color="#510812" size="3"><?php echo "-"; ?></font></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
                <?php endif;?>


      </div>
      </div>

        <img src="<?php echo base_url();?>asset/images/bg.jpg" style="position:absolute; left:0; right:0; top:0; bottom:0; margin:auto; z-index: -1;">
</form>
<div class="text-center mt-4 mb-2" style="font-size: 9px;">Computer Generated Reciept No Need of Signature*******<br><br>
 <?php echo date("l jS \of F Y h:i:s A"); ?></div>
</body>

</html>
