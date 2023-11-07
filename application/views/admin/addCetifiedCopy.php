<?php 
$cnt=$_REQUEST['cnt'];
if($cnt==""){
	$cnt=1;
}
$matterId=$_REQUEST['cc'];

if($matterId==1){ ?>
<script>
$(function(){
    $(".datepicker").datepicker({maxDate: new Date()});
});
</script>
    <div class="col-lg-12">
         <div class="row">
          	<div class="col-lg-3">
          	 	<div><label for="phone"><span class="custom"><font color="red">*</font>Date Of Order:</span></label></div>
            	<div><input type="text" name="dtoforder[]" id="dtoforder<?php echo $cnt; ?>" class="form-control datepicker" maxlength="12"  onkeypress="return isNumberKey(event)" autocomplete="off"/></div>
             </div>
         	 <div class="col-lg-3">
          	 	<div><label for="phone"><span class="custom"><font color="red">*</font>No Of Pages:</span></label></div>
            	<div><input type="text" name="nopage[]" id="nopage<?php echo $cnt; ?>" class="form-control" maxlength="4"    value="" onkeyup="calculate();"  onkeypress="return isNumberKey(event)"/></div>
             </div>
             <div class="col-lg-3">
           		<div><label for="phone"><span class="custom"><font color="red">*</font>No. Of set:</span></label></div>
            	<div><input type="text" name="noset[]" id="noset<?php echo $cnt; ?>" class="form-control" maxlength="4"    value="" onkeyup="calculate();"  onkeypress="return isNumberKey(event)" readnly/></div>
             </div>
             <div class="col-lg-3">
           		<div><label for="phone"><span class="custom"><font color="red">*</font>total:</span></label></div>
            	<div><input type="text" name="total_amount[]" id="total<?php echo $cnt; ?>" class="form-control"  maxlength="4"    onkeypress="return isNumberKey(event)"  value="" readnly/></div>
             </div>
         </div>
    </div>
    <br>
<?php }
if($matterId==2){?>
	<div class="col-lg-12">
	  	<div class="row">
             <div class="col-lg-3">
           		<div><label for="dtoforder2<?php echo $cnt; ?>"><span class="custom"><font color="red">*</font>Starting No of Page:</span></label></div>
            	<div><input type="text" name="nopage2[]" id="nopage2<?php echo $cnt; ?>" maxlength="12"  class="form-control"  value=""   onkeypress="return isNumberKey(event)"  autocomplete="off"/></div>
             </div>
         	 <div class="col-lg-3">
           		<div><label for="nopage2<?php echo $cnt; ?>"><span class="custom"><font color="red">*</font>Ending Page:</span></label></div>
            	<div><input type="text" name="end_nopage2[]" id="end_nopage2<?php echo $cnt; ?>" class="form-control" maxlength="4"   value="" onblur="calculate1();"  onkeypress="return isNumberKey(event)" onkeypress="return isNumberKey(event)"/></div>
             </div>
             <div class="col-lg-3">
           		<div><label for="noset2<?php echo $cnt; ?>"><span class="custom"><font color="red">*</font>Total Page:</span></label></div>
            	<div><input type="text" name="total_page2[]" id="total_page2<?php echo $cnt; ?>" class="form-control" maxlength="4"   value="" onkeyup="calculate1();"  onkeypress="return isNumberKey(event)" onkeypress="return isNumberKey(event)" readnly/></div>
             </div>
              <div class="col-lg-3">
           		<div><label for="total2<?php echo $cnt; ?>"><span class="custom"><font color="red">*</font>No. of sets:</span></label></div>
            	<div><input type="text" name="noset2[]" id="noset2<?php echo $cnt; ?>" class="form-control" maxlength="4"   onkeyup="calculate1();"  onkeypress="return isNumberKey(event)"  value=""  readnly/></div>
             </div>      
             <div>
        		<input type="hidden" name="total_amount2[]" id="total2<?php echo $cnt; ?>" class="form-control"	maxlength="4" value=""   onkeyup="calculate1();" onkeypress="return isNumberKey(event)" />
        	</div>
    	</div>	
	</div>
	<br>
<?php } ?>