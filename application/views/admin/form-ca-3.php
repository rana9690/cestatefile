

	

	<link rel="stylesheet" href="../includes/style.css" type="text/css">

<style>
.disabled{
	opacity:1;
	color:black;
}
</style>
<?php
$issues=getIssueMasterArray([]);
$paymentDuties=getPaymentModeDutyArray([]);
$paymentPenalties=getPaymentModePenaltyArray([]);
$paymentModePenalties=getPaymentModePenaltyArray([]);
/*
// Code for current date ends here

if($y == "add")
{
	$slyear= $curYear;
}*/
?>

<body>
<p>

<?php

//echo $casedtl['case_type'];

if ($case_type==1)
{
	
$type='CUSTOMS';
//$qry3 = "select filing_no from check_list_customs where filing_no = '$filing_no'";
$qry3 = " FORM  NO . C.A - 3 ";
$qry4 = " Form of Appeal to the Appellate Tribunal under sub-section(1) of section 129A of Customs Act, 1962. ";
}

if ($case_type==2)
{
	//echo "hello";
$type='EXCISE';
//$qry3 = "select filing_no from check_list_excise where filing_no = '$filing_no'";
$qry3 = " FORM  NO . E.A - 3 ";
$qry4 = " Form of Appeal to the Appellate Tribunal under sub-section(1) of section 35B of the Act, ";
}

if ($case_type==3)
{
$type='SERVICE TAX';
//$qry3 = "select filing_no from check_list_stax where filing_no = '$filing_no'";
$qry3 = " FORM  NO . S.T - 5 ";
$qry4 = " Form of Appeal to the Appellate Tribunal under sub-section(1) of section 86 of Finance Act, 1994. ";
}
if ($case_type==4)
{
$type='ANTI DUMPING';
//$qry3 = "select filing_no from check_list_stax where filing_no = '$filing_no'";
$qry3 = "";
$qry4 = "";
}

?>
  <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><?php print "$qry3" ?></b></font></div><br>
     <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><?php print "$qry4"; ?></font></div>
	
 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
      <span class="error">
      
      </span></font></div>
  


  <form name="frm" method="post" action="checksave" >
	

  <!-- Important -->
 
  
<!-- Important -->
 
  
<!-- hiding  starts -->  
  
  <!--
  <!-- hiding ends-->

<br>
      <p align="center"><b><font face="COMIC SANS MS" size="2">IN THE CUSTOMS, EXCISE AND SERVICE TAX APPELLATE TRIBUNAL</font></b>  

      <p align="center"><b><font face="COMIC SANS MS" size="2"></font></b><br>
<font face="COMIC SANS MS" size="2"><span class="error">APPEAL NO     :   <?php print "type"; ?>       /        __________________________       /        <?php print "curYear"; ?></span></font>

      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="type" readonly="readonly" tabindex="1" value="<?php print "type"; ?>">
<br>

  

<?php

if($pet_type==1)
{

?>

<br>
<br>

  <font face="COMIC SANS MS" size="2"><span class="error"></span>.............................<?=$pet_name; ?>.......................Appellant </font><br><br><br>

  <font face="COMIC SANS MS" size="2"><span class="error"></span>.............................<?=$res_name?>.......................Respondent </font>
  
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pet_name" readonly="readonly" tabindex="1" value="<?=$pet_name?>"><br>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pet_address" readonly="readonly" tabindex="1" value="<?=$pet_address?>"><br>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pet_address1" readonly="readonly" tabindex="1" value="<?=$pet_address1?>"><br>

  
  
<?php
}
else
{
?>
 <font face="COMIC SANS MS" size="2"><span class="error"></span></font>
 	     <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pet_name" readonly="readonly" tabindex="1" value="<?=$pet_name?>"><br>
		<?php $pet_type=0; ?>
	   
   
<?php
}
?>




<?php

if ($pet_type==1)
{
?>

<font face="COMIC SANS MS" size="2"><span class="error"></span></font>
   
  
<?php
}
?>


<?php

if($res_type==1)
{
?>

  <font face="COMIC SANS MS" size="2"><span class="error"></span>.............................<?=$pet_name?>.......................Appellant </font><br><br><br>

  <font face="COMIC SANS MS" size="2"><span class="error"></span>.............................<?=$res_name?>.......................Respondent </font>



 <font face="COMIC SANS MS" size="2"><span class="error"></span></font> <input style="width:200px" id="1" type="hidden" maxlength="1000" name="res_name" readonly="readonly" tabindex="1" value="<?php print $casedtl['res_name']; ?>"><br>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="res_address" readonly="readonly" tabindex="1" value="<?=$res_address; ?>">
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="res_address1" readonly="readonly" tabindex="1" value="<?=$res_address1?>"><br>
      
     <?php
}
else
{
?>
  <font face="COMIC SANS MS" size="2"><span class="error"></span></font>
             <input style="width:200px" id="1" type="hidden" maxlength="1000" name="res_name" readonly="readonly" tabindex="1" value="<?php print $casedtl['res_name']; ?>"><br>
  
<?php
}
?>


<?php
if ($case_type==1)
{
?>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">   Location Code</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"> IE Code </font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"> PAN or UID Code</font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?=$loc_code; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?=$iec_code?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?=$pan_code?></font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">E-mail Address</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">Phone No.</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">Fax No.</font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pet_email']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pet_mobile']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['fax_no']; ?></font></td>
<tr>
</table>

<br><br><br><br>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="loc_c" value="<?php print $casedtl['loc_code']; ?>">

<font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
    <input style="width:200px" id="1" type="hidden" maxlength="1000" name="iec_code" value="<?php print $casedtl['iec_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pan_code" value="<?php print $casedtl['pan_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="email_add" value="<?php print $casedtl['pet_email']; ?>">
     
<font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="ph_no" value="<?php print $casedtl['pet_mobile']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="fax_no" value="<?php print $casedtl['fax_no']; ?>">
      
<?php
}
?>

<?php

if ($case_type==2)
{
?>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">   Assessee Code</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"> Location Code </font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"> PAN or UID Code</font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['ass_code']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['loc_code']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pan_code']; ?></font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">E-mail Address</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">Phone No.</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">Fax No.</font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pet_email']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pet_mobile']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['fax_no']; ?></font></td>
<tr>
</table>


<font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="ass_code" value="<?php print $casedtl['ass_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="loc_code" value="<?php print $casedtl['loc_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pan_code" value="<?php print $casedtl['pan_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="email_add" value="<?php print $casedtl['pet_email']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="ph_no" value="<?php print $casedtl['pet_mobile']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
     
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="fax_no" value="<?php print $casedtl['fax_no']; ?>">
     

<?php
}
?>

<?php

if ($case_type==3)
{
?>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">   Assessee Code</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"> Premises Code </font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"> PAN or UID Code</font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['ass_code']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pre_code']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pan_code']; ?></font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">E-mail Address</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">Phone No.</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2">Fax No.</font></td>
<tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pet_email']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['pet_mobile']; ?></font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print $casedtl['fax_no']; ?></font></td>
<tr>
</table>

<font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="ass_code" value="<?php print $casedtl['ass_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pre_code" value="<?php print $casedtl['pre_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="pan_code" value="<?php print $casedtl['pan_code']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="email_add" value="<?php print $casedtl['pet_email']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="ph_no" value="<?php print $casedtl['pet_mobile']; ?>">
     <font face="COMIC SANS MS" size="2"><span class="error"></span><span class="error"></span></font>
     
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="fax_no" value="<?php print $casedtl['fax_no']; ?>">
     
<?php
}
?>


<br><br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" align="left" size="2">  2 . The designation and address of the authority passing the order appealed against.</font>
</td></tr><tr><td align="center" width="30%"><br>



<?=$isddesg_name?>

</td>
</tr>
</table>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<br>
<font face="COMIC SANS MS" size="2">  3 . Number and Date the order appealed against. </font>
<br><br></td></tr>
<tr><td align="center" width="30%">
<font face="COMIC SANS MS" align="left" size="2"> <b> <?=$impugn_no; ?> </b> </font>
<br><br>
<font face="COMIC SANS MS" align="left" size="2">Dated: <b> <?=$impugn_date; ?> </b> </font>
<br><br>
</td>
</tr>
</table>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<br>
<font face="COMIC SANS MS" align="left" size="2">  4. Date of Communication of Copy of the Order appealed against.  </font>
<br><br></td></tr><tr><td align="center" width="30%">
<font face="COMIC SANS MS" align="left" size="2"> <b> <?=$comm_date; ?> </b> </font>
<br><br>
</td>
</tr>
</table>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<br>
<font face="COMIC SANS MS" align="left" size="2"> 5.  State/Union Territory and the Commissioneate in which the order/decision of assessment/penalty/fine was made  </font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<?=$org_name?>


</td>
</tr>
</table>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<br>
<font face="COMIC SANS MS" align="left" size="2"> 6.  Is the order appealed against relates to more than one Commissionerate.?  </font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<?=$add_comm?>


</td>
</tr>
</table>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span>The designation and address of the authority passing the order appealed against </font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<?=$assdesg_name?>


</td>
</tr>
</table>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<br>
<font face="COMIC SANS MS" align="left" size="2"> 7.Designation and  Address of the adjudicating authority in cases where the order appealed against is an order of the Commissioner (Appeals) </font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<?=$adj_org?>



<?=$adj_desig_name?>
</td>
</tr>
</table>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" align="left" size="2"> 8 . Whether the decision or order appealed against involves any question having a relation to the rate of duty of excise or to the value of goods for purposes of assessment.</font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<?=$app_quest?>



</td>
</tr>
</table>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" align="left" size="2"> 9 . Description and classification of goods.</font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<font face="COMIC SANS MS" align="left" size="2"><b><?php print set_value('goods'); ?></b></font><br>
<input style="width:200px" id="1" type="hidden" maxlength="100" name="goods" value="<?php print set_value('goods'); ?>"><br>
 <?=form_dropdown('classification',$issues,set_value('classification',(isset($classification))?$classification:''),
                                ['class'=>'form-control w-250 disabled','id'=>'classification','disabled'=>true]);?>
    

</td>
</tr>
</table>

<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" align="left" size="2"> 10 .  Period of Dispute .</font>
</td></tr>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr><td align="center" width="30%">From</td><td align="center" width="30%">To</td></tr>
<tr><td align="center" width="30%"><br>
<input  title="From Date" type="hidden" maxlength="10" name="dispute_st_dt" size="10" value="<?php print set_value('dispute_st_dt'); ?>" onfocus="inputFocus(this)" onblur="inputBlur(this)">
<font face="COMIC SANS MS" align="left" size="2"><b><?php print set_value('dispute_st_dt'); ?></b></font><br>(dd/mm/yyyy)	</td>  
 <td align="center" width="30%"><br>   
          <input title="From Date" type="hidden" maxlength="10" name="dispute_en_dt" size="10" value="<?php print set_value('dispute_en_dt'); ?>" onfocus="inputFocus(this)" onblur="inputBlur(this)"><font face="COMIC SANS MS" align="left" size="2"><b><?php print set_value('dispute_en_dt'); ?></b></font><br>(dd/mm/yyyy)	
</td></tr>
</table> 


</td>
</tr>
</table>

<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="50%"><font face="COMIC SANS MS" align="left" size="2"> Duty Ordered</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php echo set_value('duty_tax_ord'); ?> </font></td>
</tr><tr>
<td align="center" width="50%"><font face="COMIC SANS MS" align="left" size="2"> Refund Ordered</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('refund_ord'); ?> </font></td>
</tr><tr>
</tr><tr>
<td align="center" width="50%"><font face="COMIC SANS MS" align="left" size="2"> Fine Ordered</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('fine_int_ord'); ?> </font></td>
</tr><tr>
</tr><tr>
<td align="center" width="50%"><font face="COMIC SANS MS" align="left" size="2"> Penalty Ordered</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('penalty_ord'); ?> </font></td>
</tr><tr>
</tr><tr>
<td align="center" width="50%"><font face="COMIC SANS MS" align="left" size="2"> Interest Ordered</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('inter_ord'); ?> </font></td>
</tr><tr>
</tr><tr>
<td align="center" width="50%"><font face="COMIC SANS MS" align="left" size="2"> Redumption Fine Ordered</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('rp_ord'); ?> </font></td>
</tr><tr>
</tr><tr>
<td align="center" width="50%"><font face="COMIC SANS MS" align="left" size="2"> Market Value of Seized Goods</font></td>
<td align="center" width="30%"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('mkt_value'); ?> </font></td>
</tr><tr>
</tr>
</table>




<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"> Duty Paid</font></td>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"> Fine Paid</font></td>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"> Penalty Paid</font></td>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"> Interest </font></td>
<tr>


<tr>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('duty_tax_pd'); ?> </font></td>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('fine_int_pd'); ?> </font></td>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('penalty_pd'); ?> </font></td>
<td align="center"><font face="COMIC SANS MS" align="left" size="2"><?php print set_value('inter_pd'); ?> </font></td>
<tr>
</table>

<br>



<input style="width:200px" id="1" type="hidden" maxlength="1000" name="imp_no" readonly="readonly" tabindex="1" value="<?php print set_value('impugn_no'); ?>">

<input style="width:200px" id="1" type="hidden" maxlength="15" name="imp_date" readonly="readonly" tabindex="1" value="<?php print set_value('impugn_date'); ?>">



<input style="width:200px"  id="1" type="hidden" maxlength="1000" name="comm_date" readonly="readonly" tabindex="1" value="<?php print $impugn['comm_date']; ?>">
      <input id="1" type="hidden" maxlength="35" name="duty_tax_ord" value="<?php print set_value('duty_tax_ord'); ?>">
      <input id="1" type="hidden" maxlength="35" name="duty_tax_pd" value="<?php print set_value('duty_tax_pd'); ?>">
      <input id="1" type="hidden" maxlength="35" name="refund_ord" value="<?php print set_value('refund_ord'); ?>">
      <input id="1" type="hidden" maxlength="35" name="refund_pd" value="<?php print set_value('refund_pd'); ?>">
      <input id="1" type="hidden" maxlength="35" name="fine_int_ord" value="<?php print set_value('fine_int_ord'); ?>">
      <input id="1" type="hidden" maxlength="35" name="fine_int_pd" value="<?php print set_value('fine_int_pd'); ?>">
      <input id="1" type="hidden" maxlength="35" name="penalty_ord" value="<?php print set_value('penalty_ord'); ?>">
      <input id="1" type="hidden" maxlength="35" name="penalty_pd" value="<?php print set_value('penalty_pd'); ?>">
      <input id="1" type="hidden" maxlength="35" name="inter_ord" value="<?php print set_value('inter_ord'); ?>">
      <input id="1" type="hidden" maxlength="35" name="inter_pd" value="<?php print set_value('inter_pd'); ?>">
      <input id="1" type="hidden" maxlength="35" name="rp_ord" value="<?php print set_value('rp_ord'); ?>">
      <input id="1" type="hidden" maxlength="35" name="rp_pd" value="<?php print set_value('rp_pd'); ?>">
      <input id="1" type="hidden" maxlength="35" name="mkt_value" value="<?php print set_value('mkt_value'); ?>">
	 
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" Arial, Helvetica" size="2"><span class="error">*</span>Whether duty or penalty is deposited; if not, whether any application for dispensing with such deposit has been made</font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<!--<select name="applic_dispensed"  onChange="SubmitForm1();" onClick="return validate2();">-->

<select style="width:200px" name="applic_dispensed">

<!--<option value="">Select</option>-->

<!--<option value="Y">Yes</option>
<option value="N">No</option>
-->


<!-- changed on 07/June/2011-->
<option value="Y" <?php if(set_value('applic_dispensed')=="Y"){?> selected <?php }?> >Yes </option>
<option value="N" <?php if(set_value('applic_dispensed')=="N"){?> selected <?php }?> >No </option>
<!-- -->

</select>

</td>
</tr>
</table>
<?php

if ($case_type==2 or $case_type==3)
{
?>


<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" Arial, Helvetica" size="2"><span class="error">*</span>Does the order appealed against also involve any Customs Duty demand and related penalty,so far the appellant is concerned.?</font>
<br><br></td></tr><tr><td align="center" width="30%"><br>

<select style="width:200px" name="cu_duty">




<!-- changed on 07/June/2011-->
<option value="Y" <?php if(set_value('cu_duty')=='Y'){?> selected <?php }?>>Yes</option>
<option value="N" <?php if(set_value('cu_duty')=='N'){?> selected <?php }?>>No</option>
<!-- -->

</select>
</td>
</tr>
</table>


<?php
}
?>

<?php

if ($case_type==1 or $case_type==3)
{
?>

<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" Arial, Helvetica" size="2"><span class="error">*</span>Does the order appealed against also involve any Central Excise duty demand and relates fine or penalty,so far the appellant is concerned.?</font>
<br><br></td></tr><tr><td align="center" width="30%"><br>

<select style="width:200px" name="ce_duty">


<!-- changed on 07/June/2011-->
<option value="Y" <?php if(set_value('ce_duty')=='Y'){?> selected <?php }?>>Yes</option>
<option value="N" <?php if(set_value('ce_duty')=='N'){?> selected <?php }?>>No</option>
<!-- -->

</select>
</td>
</tr>
</table>
<?php
}
?>

<?php

if ($case_type==1 or $case_type==2)
{
?>

<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" Arial, Helvetica" size="2"><span class="error">*</span>Does the order appealed against also involve any Service Tax demand and related penalty,so far the appellant is concerned.?</font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<select style="width:200px" name="st_duty">




<!-- changed on 07/June/2011-->
<option value="Y" <?php if(set_value('st_duty')=='Y'){?> selected <?php }?>>Yes</option>
<option value="N" <?php if(set_value('st_duty')=='N'){?> selected <?php }?>>No</option>
<!-- -->

</select>
</td>
</tr>
</table>

<?php
}
?>
<br>
<?php
if ($case_type==2)
{
?>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">

<font face="COMIC SANS MS" size="2"><span class="error"></span> Subject matter of Dispute in order of Priority </font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<select name="ce_pri1"   style="width:200px">
<option value="">Priority 1</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=2 order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $ce_pri1)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
<select name="ce_pri2"   style="width:200px">
<option value="">Priority 2</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=2 order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $ce_pri2)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
</td>
</tr>
</table>

<?php
}
?>

<?php

if ($case_type==3)
{
?>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span> Subject matter of Dispute in order of Priority </font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<select name="st_pri1"   style="width:200px">
<option value="0">Priority 1</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=3 order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $st_pri1)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
<select name="st_pri2"   style="width:200px">
<option value="0">Priority 2</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=3 order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $st_pri2)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
</td>
</tr>
</table>

<?php
}
?>
<?php
if ($casedtl['case_type']==1)
{
?>



<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span> Subject matter of Dispute in order of Priority </font>
<br><br></td></tr><tr><td align="center" width="30%"><br>
<b>IMPORT</b>
<select name="cu_pri_imp1"   style="width:200px">
<option value="0">Priority 1</option>
<?php
/*echo $st = "select * from sub_matter_pri where case_type=1 and class='IMPORT' order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $cu_pri_imp1)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
<select name="cu_pri_imp2"   style="width:200px">
<option value="0">Priority 2</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=1 and class='IMPORT' order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $cu_pri_imp2)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>

<br>
<font face="COMIC SANS MS" size="2"><span class="error"></span></font>

<b>EXPORT</b>
<select name="cu_pri_exp1"   style="width:200px">
<option value="0">Priority 1</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=1 and class='EXPORT' order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $cu_pri_exp1)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
<select name="cu_pri_exp2"   style="width:200px">
<option value="0">Priority 2</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=1 and class='EXPORT' order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $cu_pri_exp2)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>


<br>
<font face="COMIC SANS MS" size="2"><span class="error"></span></font>

<b>GENERAL</b>
<select name="cu_pri_gen1"   style="width:200px">
<option value="0">Priority 1</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=1 and class='GENERAL' order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $cu_pri_gen1)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
<select name="cu_pri_gen2"   style="width:200px">
<option value="0">Priority 2</option>
<?php
/*$st = "select * from sub_matter_pri where case_type=1 and class='GENERAL' order by code asc";
foreach($db->query($st) as $row)
{
	 $c_type = htmlspecialchars(htmlentities($row['code']));
         $name = ucwords($row['priority']);             
         $name = ucwords(strtolower($name));
	 if($c_type == $cu_pri_gen2)
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code']))." selected>".htmlspecialchars(htmlentities($name))." </option>";
	 }
	 else
	 {
    print "<option value=".htmlspecialchars(htmlentities($row['code'])).">".htmlspecialchars(htmlentities($name))."  </option>";
	 }
}*/
 ?>
</select>
</td>
</tr>
</table>


<?php
}
?>
<?php
if ($casedtl['case_type']==1 or $casedtl['case_type']==3)
{
?>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span> Central Excise Assessee Code :</font>
<br></td></tr><tr><td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><?php print set_value('cea_code'); ?></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="cea_code" value="<?php print set_value('cea_code'); ?>">

</td>
</tr>
</table>
 
<?php

}
?>

<?php

if ($case_type==1 or $case_type==2)
{
?>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span> Service Tax Assessee Code :</font>
<br></td></tr><tr><td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><?php print set_value('sta_code'); ?></font>
<input style="width:200px" id="1" type="hidden" maxlength="1000" name="sta_code" value="<?php print set_value('sta_code'); ?>"><br>
</td>
</tr>
</table> 
<?php
}
?>
<?php
if ($case_type==3 or $case_type==2)
{
?>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span> Importer Exporter Code :</font>
<br></td></tr><tr><td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><?php print set_value('ie_code'); ?></font>
      <input style="width:200px" id="1" type="hidden" maxlength="1000" name="ie_code" value="<?php print set_value('ie_code'); ?>" ><br>
</td>
</tr>
</table>
<?php
		}	  
?>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span> If the appeal is against an O-I-O of Comm(appeals),the No.of O-I-O covered by the said O-I-A :</font>
<br></td></tr><tr><td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><?php print set_value('oio_count'); ?></font>
    <input style="width:200px" id="1" type="hidden" maxlength="1000" name="oio_count" value="<?php print set_value('oio_count'); ?>"><br>
</td>
</tr>
</table>



<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS"  Arial, Helvetica" size="2"><span class="error">*</span>Whether the appellant wishes to be heard in person?</font>
<br></td></tr><tr><td align="center" width="30%">
<select style="width:200px" name="heard">
<!--<option value="">Select</option>-->
<option value="Y" <?php if(set_value('heard')=="1"){?> selected <?php }?>>Yes</option>
<option value="N" <?php if(set_value('heard')=="0"){?> selected <?php }?>>No</option>
</select>
    </td>
</tr>
</table>

<br>

<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error">*</span>Amount of pre-deposited Duty paid mode : </font>
<br></td></tr><tr><td align="center" width="30%">

<select style="width:250px" name="payment_mode_duty"   style="width:200px">

<option value="1" <?php if(set_value('payment_mode_duty')=="1"){?> selected <?php }?>>Paid through cash/ e-payment</option>
<option value="2" <?php if(set_value('payment_mode_duty')=="2"){?> selected <?php }?>>Paid out of Cenvat account</option>


</select>
    </td>
</tr>
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error">*</span>Amount of pre-deposited Penalty paid mode : </font>
<br></td></tr><tr><td align="center" width="30%">
<select style="width:250px" name="payment_mode_penalty"   style="width:200px">
<option value="1" <?php if(set_value('payment_mode_penalty')=="1"){?> selected <?php }?>>Paid through cash/ e-payment</option>
<option value="2" <?php if(set_value('payment_mode_penalty')=="2"){?> selected <?php }?>>Paid out of Cenvat account</option>
</select>
    </td>
</tr>

</table>
<br>
<table width="80%" cellspace="5" border=0 class="tbl">
<tr>
<td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><span class="error"></span> Reliefs claimed in appeal</font>
<br></td></tr><tr><td align="center" width="30%">
<font face="COMIC SANS MS" size="2"><?php print set_value('reliefs'); ?></font>
      <input style="width:200px" id="2" type="hidden" maxlength="50" name="reliefs" value="<?php print set_value('reliefs'); ?>">
      
    </td>
</tr>
</table>
<br>
<?php /*}
}*/
 ?>
<!--======================if have objection ==========================-->



<p align="center"><a href="javascript:doit()"><font color='red'>Print</font></a></p>

<!--============================objecttion list =============-->
  
<?php /*
}
}
}*/
?>
</table>

