<?php 
$paper1=$_REQUEST['paper1'];
$totalA=$_REQUEST['totalA'];
$bd=$_REQUEST['app'];
if($bd==2)
	$name="Post Office Details";
if($bd==1)
	$name="Bank Details";

$type_filing = $_REQUEST['type'];
$type_function= '';
if ($_REQUEST['type'] == 'contempt') {
	$type_function = '_contempt';
} else if ($_REQUEST['type'] == 'execution') {
	$type_function = '_execution';
} else if ($_REQUEST['type'] == 'review') {
	$type_function = '_review';
}
$total=$totalA*25;
if($paper1=='va'){
?>
    <div class="col-sm-12 ">
    	<div><label for="name">Total Vakalatnama Fee</label></div>
    	<div style="color: red;"><b><?php   echo $total =  '25';?></b></div>
    </div>
<?php }if($paper1=='ma'){?>
     <div class="col-sm-12 ">
	    <div><label for="name">Total Document Fee</label></div>
		<div style="color: red;"><b><?php echo $total;?></b></div>
	</div>
<?php }if($paper1=='IA'){?>
	<div class="col-sm-12 ">
	   <div class="row">
		    <div class="col-lg-4 ">
			    <div><label for="name">Total Document Fee</label></div>
				<div style="color: red;"><b><?php echo $total;?></b></div>
			</div>
			<div class="col-lg-4 ">
				<div><label for="name">IA Fee</label></div>
				<div style="color: red;"><b><?php echo '1000';?></b></div>
			</div>
			<div class="col-lg-4 ">
				<div><label for="name">Total Fee</label></div>
				<div style="color: red;"><b><?php echo $total = $total+1000;?></b></div>
			</div>
	   </div>
   </div>	   
<?php }if($bd==3) {?>

  <div class="col-sm-12">
	   <div class="row">
           <div class="col-lg-4">
                <div><label for="totalamount"><span class="custom"><span><font color="red">*</font></span>Total Amount </span></label></div>
                <div><input type="text" name="totalamount" id="totalamount" class="form-control" value="<?php echo $total; ?>" readonly></div>
          </div>
          <div class="col-lg-4 ">      
                <div><label for="remainamount"><span class="custom"><span><font color="red">*</font></span>Remain Amount</span></label></div>
                <div><input type="text" name="remainamount" id="remainamount"   class="form-control datepicker"  value="" readonly></div>
          </div>
        
          <div class="col-lg-4 ">
               <div><label for="collectamount"><span class="custom"><span><font color="red">*</font></span>Paid Amount</span></label></div>
               <div><input type="text" maxlength="20" name="collectamount" id="collectamount" class="form-control" value="" readonly></div>
          </div>
       </div>
   </div>
   
   
   
   <div class="col-sm-12 ">
	   <div class="row">
           <div class="col-lg-4 ">
                <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Name </span></label></div>
                <div><input type="text" name="ntrp" id="ntrp" class="form-control" value="NTRP" onkeypress="return onKeyValidate(event,alpha);" /></div>
          </div>
          <div class="col-lg-4 ">      
                <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Date of Transction</span></label></div>
                <div><input type="text" name="ntrpdate" id="ntrpdate"   onclick="get_date(this);"  class="form-control datepicker"  value="" readonly></div>
          </div>
        
          <div class="col-lg-4 ">
               <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Challan/Ref. Number</span></label></div>
               <div><input type="text" maxlength="13" name="ntrpno" id="ntrpno" class="form-control" value="" onkeypress="return isNumberKey(event)" /></div>
          </div>
       </div>
   </div> 
       <div class="col-sm-12 ">
		  <div class="row">  
                <div class="col-lg-4 ">
                    <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Amount in Rs.</span></label></div>
                    <div><input type="text" name="ntrpamount" id="ntrpamount" class="form-control" value="" maxlength="6" autocomplete="off" onkeypress="return isNumberKey(event)"/></div>
                </div>
                
                 <div class="col-lg-4 " style="margin-top:27px">
                    <div class="col-sm-12 " ><input type="button" name="btnSubmit_add_more" id="btnSubmit_add_more" value="Add More Payment" class="btn btn-info" onclick="addMoreAmountrpepcp()"/></div>
                </div>
                
          </div> 
       </div>     
<div class="row">
    <div class="col-lg-4 ">
        <div class="form-check">
     	 	<input class="form-check-input" type="checkbox" value="" name="undert" id="undert">
      	 	<label class="form-check-label" for="undert">Under Taking </label>
        </div>
    </div>    
</div>

    <?php  } ?>
    <div >


	<?php if($paper1!=""){?>
		<div><input type="button" name="btnSubmit" id="btnSubmit" value="Final Save" class="btn btn-info" onclick="maAction<?php echo $type_function; ?>();"/></div>
	<?php }else {?>
		<div><input type="button" name="btnSubmit" id="btnSubmit" value="Save" class="btn btn-info" onclick="filingAction<?php echo $type_function; ?>();"/></div>
	<?php }?>
	<input type="hidden" id="total_feeee" name='total_feeee' value="<?php echo $total; ?>" ?>
   </div>





