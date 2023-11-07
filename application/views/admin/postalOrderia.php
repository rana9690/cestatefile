<?php 
 $bd=$_REQUEST['app'];
 if($bd==2){
	$name="Post Office Details";
 }
	if($bd==1){
		$name="Bank Details";
	}if($bd==3){
		$name="Online Payment";
	}

?>

<?php if($bd==3){?>



<div class="row">
    <div class="col-lg-4 ">
    		<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Name </span></label></div>
    		<div><input type="text" name="ntrp" id="ntrp" class="form-control" value="NTRP" onkeypress="return onKeyValidate(event,alpha);" readonly></div>
    		<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Date of Transction</span></label></div>
    		<div><input type="text" name="ntrpdate" id="ntrpdate"  placeholder="02/02/1989"   class="form-control datepicker" onclick="get_date(this);"   value="" ></div>
    </div>
    <div class="col-lg-4 ">
    	<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Challan/Ref. Number</span></label></div>
    	<div><input type="text" maxlength="13" name="ntrpno" id="ntrpno" class="form-control"  value="" onkeypress="return isNumberKey(event)" /></div>
    	<div style="margin-top:27px">
    	<input type="button" name="btnSubmit" id="btnSubmit"  value="Add Amount" class="btn btn-success"  onclick="addMoreAmountrpepcp()"/></div>
    </div>
    <div class="col-lg-4 ">
    	<div><label for="name"><span class="custom"><span><font color="red">*</font></span>Amount in Rs.</span></label></div>
    	<div><input type="text" name="ntrpamount" id="ntrpamount" class="form-control" value="" size="6" autocomplete="off" onkeypress="return isNumberKey(event)"/></div>
    	<div style="margin-top:27px"><input type="button" name="btnSubmit" id="btnSubmit" value="Save & Next" class="btn btn-success" onclick="actionfile();"/></div>
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

<script>
$(document).ready(function(){
	 $(".datepicker" ).datepicker({ 
		 dateFormat: "dd-mm-yy",
	});
	}); 
</script>




