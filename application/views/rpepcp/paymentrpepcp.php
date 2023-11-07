<?php 
$name='';
$bd=$_REQUEST['app'];
if($bd==2){
	$name="Post Office Details";
}if($bd==1){
	$name="Bank Details";
}
if($bd==3){
    $name="Transaction Details";
}
if($bd==3){  ?>

<div class="row">
     <div class="col-lg-3 mb-3">
        <div><label for="name"><span class="custom"><span><font color="red">*</font></span> Fee</span></label></div>
        <div><input type="text" name="ntrp" id="ntrp" class="form-control" value="NTRP" onkeypress="return onKeyValidate(event,alpha);" /></div> 
    </div>
    <div class="col-lg-3 mb-3"> 
        <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Date of Transction</span></label></div>
        <div><input type="text" name="ntrpdate" id="ntrpdate"  placeholder="" autocomplete="off" class="form-control alert-danger datepicker" readonly="true"   value="" /></div>
    </div>
    <div class="col-lg-3 mb-3">
        <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Challan/Ref. Number</span></label></div>
        <div><input type="text" maxlength="13" name="ntrpno" id="ntrpno" class="form-control" value="" onkeypress="return isNumberKey(event)" /></div>
    </div>
    <div class="col-lg-3 mb-3">
        <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Amount in Rs.</span></label></div>
        <div><input type="text" name="ntrpamount" id="ntrpamount" class="form-control" value="" maxlength="7" autocomplete="off" onkeypress="return isNumberKey(event)"/></div>
    </div>
</div>      
<?php  } ?>
<br>
<div class="row">
   <div class="col-md-12 text-center">
	 <input type="button" name="btnSubmit" id="btnSubmit" value="Add Amount" class="btn btn-success" onclick="addMoreAmountrpepcp()"/>
    </div>
</div> 
<div id="add_amount_list">
</div>




