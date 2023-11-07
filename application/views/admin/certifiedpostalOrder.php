<?php
$bd=htmlspecialchars($_REQUEST['app']);
if($bd==2)
    $name="Post Office Details";
    if($bd==1)
        $name="Bank Details";
        if($bd==3)
            $name="Online Payment";
            ?>
<script type="text/javascript" language="javascript">
   function isNumberKey(evt)
   {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 &&(charCode < 48 || charCode > 57))
       return false;
    
    return true;
   }
</script>
<fieldset>
   <legend class="customlavel2"><?php echo $name;?></legend>
   <div class="col-lg-4">
   		<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Amount Collective  </span></label></div>
   		<div><input type="text" name="payAmount" id="payAmount" class="form-control" onblur="feeCalculation()" value="" onkeypress="return onKeyValidate(event,alpha);" /></div>
   </div>
   <div class="col-sm-4"></div>
   <div class="col-sm-4" id="feeCalculation"  style="display: none"></div>
   <?php if($bd==3){?>
   <div class="row">
       <div class="col-lg-4 ">
          <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Name </span></label></div>
          <div><input type="text" name="ntrp" id="ntrp" class="form-control" value="NTRP" onkeypress="return onKeyValidate(event,alpha);" /></div>
       </div> 
       <div class="col-lg-4 "> 
          <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Date of Transction</span></label></div>
          <div><input type="text" name="ntrpdate" id="ntrpdate"   class="form-control datepicker"  value="" readonly /></div>
       </div>
       <div class="col-lg-4 ">
          <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Challan/Ref. Number</span></label></div>
          <div><input type="text" maxlength="13" name="ntrpno" id="ntrpno" class="form-control" value="" onkeypress="return isNumberKey(event)" /></div>
       </div>
    </div> 
    <div class="row">  
       <div class="col-lg-4 ">
          <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Amount in Rs.</span></label></div>
          <div><input type="text" name="ntrpamount" id="ntrpamount" class="form-control" value="" maxlength="16" autocomplete="off" onkeypress="return isNumberKey(event)"/></div>
       </div>
       <div class="col-lg-4 ">
          <div><label for="name"></label></div>
          <div style="margin: 12px;"><input type="button" name="btnSubmit" id="btnSubmit" value="Add Amount" class="btn btn-success" onclick="addMoreAmount()"/></div>
       </div>
   </div>
   
   <?php } ?>
</fieldset>

<script>

$(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'dd/mm/yy' });
  });
  
</script>