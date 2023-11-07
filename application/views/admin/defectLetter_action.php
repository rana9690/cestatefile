<?php
header("Cache-Control: private");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Cache-Control=proxy-revalidate");
date_default_timezone_set("Asia/Kolkata");


$defectfinaldate='';
if ($filing_no) {
    $val=$this->efiling_model->data_list_where('defect_letter','filing_no',$filing_no);
    if(!empty($val)){
        $filingNo = $val[0]->filing_no;
        $defect = $val[0]->defect_name;
        $registrar = $val[0]->reg_name;
        $defectfinaldate = $val[0]->final_date;
        $flag = $val[0]->flag;
    }else{
       echo "Record not Found";
    }
}



$dateprint = date('d/m/Y',strtotime($defectfinaldate));

if ($flag == 'CL' or $flag == "") {
    echo "<center><b>";
    echo "<br><br><br>";
    echo "Final Defect Letter Not Created............";
    echo "</center></b>";
} else {

    $sqlcnt=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filingNo);
    $sttotal =count($sqlcnt);


    $casedetail=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filingNo);
    if(!empty($casedetail)){
        $petName = $casedetail[0]->pet_name;
        $case_no = $casedetail[0]->case_no;
        $caseType = $casedetail[0]->case_type;
        $resName = $casedetail[0]->res_name;
        $fDate = $casedetail[0]->dt_of_filing;
        $pet_adv = $casedetail[0]->pet_adv;
        if ($case_no != "") {
            $case_numaa = substr($case_no, 4, 7);
            $case_num1aa = ltrim($case_numaa, 0);
            $case_year1aa = substr($case_no, 11, 4);
        }
        if ($caseType == 1) {
            $matt = "Appellant";
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Defect Letter</title>
        <style>
            html {
                background: #ccc;
            }
            body {
                width: 700px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #929292;
                background: #fff;
            }
            td {
                padding: 0 10px;
                text-align: left;
            }
            ol {
                margin-left: 20px;
                padding: 15px;
                line-height: 1.4;
            }
            ol li {
                padding-left: 10px;
            }
            @media print {
                html {
                    background: #fff;
                }
                body {
                    width: 100%;
                    padding: 0;
                    border: 0px solid #929292;
                }
            }
        </style>

        <script language="javascript">
            function change(id, newClass){
                identity=document.getElementById(id);
                identity.className=newClass;
            }
            function printPage() {
                change("testdiv","true");
                window.print();
            }
        </script>
    </head>
    <body style="font-size:16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">
    <div style="padding-left: 30px;">
        <div  id="testdiv" ><a href="javascript:printPage();">   Print </a>
        </div>
        <table style="width:100%; border:0;">
            <tr>
                <td style="width:20%;"><img src="emb.png" width="50"></td>
                <td style="width:80%; text-align:right;">
                    <div style="text-align:center; display:inline-block; font-size: 14px; font-weight:bold;font-family: Arial, Helvetica, sans-serif;">
                        APPELLATE TRIBUNAL FOR ELECTRICITY<br>
                        Core 4,7th Floor,SCOPE Builiding,Lodhi Road,<br>
                        New Delhi-110003<br>
                        Phone:011-2436480, Fax : 011-24368479<br>
                        email: registrar-aptel@nic.in / dyrege-aptel@nic.in<br>
                        <span style="font-weight: normal; line-height: 1.6;">Dated : <?php echo $dateprint; ?></span>
                    </div>
                </td>
            </tr>
        </table>

        <p style="text-align: right;"></p>
        <p>To:<br><br>
            <?php
            $sqladv=$this->efiling_model->data_list_where('master_advocate','adv_code',$pet_adv);
            if(!empty($sqladv)) {
                $stcode = $sqladv[0]->state_code;
                $gender = $sqladv[0]->adv_sex;
                if ($gender == 'M') {
                    echo "Mr. " . $sqladv[0]->adv_name . ',';
                }
                if ($gender == 'F') {
                    echo "Ms. " . $sqladv[0]->adv_name . ',';
                }

                echo "<br>";
                echo $sqladv[0]->address . ',';
                echo "<br>";
                
                $sqlstate=$this->efiling_model->data_list_where('master_psstatus','state_code',$stcode);
                echo "<b><u>";
                echo $stateName = $sqlstate[0]->state_name;
                echo '-';
                echo $sqladv[0]->adv_pin;
                echo "</u></b>";
            }
            ?>
        </p>
        <p style="text-align:center;">(<b><u>Defects in Filing</u></b>)</p>
        <div style="text-align:center;">
            <?php  
            $sqlcase=$this->efiling_model->data_list_where('master_case_type','case_type_code',$caseType);
            $caseTypeName = $sqlcase[0]->case_type_name;
            if ($case_num1aa != "" and $case_year1aa != "") {
                $case_nonn = "			No. $case_num1aa of $case_year1aa ";
            }
            if ($case_num1aa == "" and $case_year1aa == "") {
                $case_nonn = "			No. _______ of $diaryYear";
            }
            ?>
            <table style="width:80%; display: inline-block; line-height: 1.4;" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>Ref:</td>
                    <td colspan="3">Appeal No. <?php echo $case_nonn; ?> under DFR No. <?php echo $diaryNo; ?>   of <?php echo $diaryYear; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>  <?php echo $petName; ?></td>
                    <td>...</td>
                    <td>Appellants</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align:center;">Vs.</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <u><?php echo $resName; ?></u>
                    </td>
                    <td>...</td>
                    <td><u>Respondents</u></td>
                </tr>
            </table>
        </div>
        <?php
        $sqldis=$this->efiling_model->data_list_where('defect_letter','filing_no',$filingNo);
        if(!empty($sqldis)){
            $dname = $sqldis[0]->defect_name;
            $footer = $sqldis[0]->defect_footer;
            $reg = $sqldis[0]->reg_name;
        }
        ?>
        <p>Sir/Madam,</p>
        <div style="text-indent:40px;"><?php echo $dname; ?></div>
        <ol>
            <?php
            $ii = 1;            
        //    $st = $db->prepare("select * from objection_details where filing_no='$filingNo' and status<>'YES' order by objection_code");
            $query=$this->db->query("select * from objection_details where filing_no='$filingNo' and status<>'YES' order by objection_code");
            $sqldis= $query->result();         
            if(!empty($sqldis)){
                $objectionCode = htmlspecialchars($sqldis[0]->objection_code);
                $status = htmlspecialchars($sqldis[0]->status);
                $statuscount = strlen($status);
                if ($statuscount == '6') {
                    $objName = htmlspecialchars($sqldis[0]->comments);
                } else {
                    $stcom1=$this->efiling_model->data_list_where('master_objection','id',$objectionCode);
                    $objName = $stcom1[0]->sub_sub_obj_name;
                }
                if ($objName != "") {
                ?>
                    <li>   <?php echo html_entity_decode(html_entity_decode($objName)); ?></li>
                    <?php
                    $objName = "";
                    $ii++;
                }
            }
            ?>
        </ol>
        <div style="text-indent:40px;"><?php echo $footer; ?></div>
        <p>&nbsp;</p>
        <p style="text-align:right;"><b>(<?php echo $reg; ?>)</b><br>Registrar / Dy. Registrar</p>
    </div>
    </body>

    </html>
<?php  }?>
