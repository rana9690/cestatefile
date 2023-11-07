
<?php 
$paper1=$_REQUEST['paper1'];
$totalA=$_REQUEST['totalA'];
$bd=$_REQUEST['app'];
if($bd==2){
	$name="Post Office Details";
}if($bd==1){
	$name="Bank Details";
}
if($bd==3){
    $name="Transaction Details";
}
$type_filing = $_REQUEST['type'];
$type_function= '';
if ($_REQUEST['type'] == 'contempt') {
	$type_function = '_contempt';
} else if ($_REQUEST['type'] == 'execution') {
	$type_function = '_execution';
} else if ($_REQUEST['type'] == 'review') {
	$type_function = '_review';
}
?>

	<?php 
	$total=$totalA*25;
	           if($paper1=='va'){ ?>
        		<div class="col-sm-12">
            		<div class="row">
            			<div><label for="name">Total Vakalatnama Fee</label></div>
            			<div style="color: red;"><b><?php   echo $total =  '25';?></b></div>
            		</div>
        		</div>
				<?php }
		      if($paper1=='ma'){?>
				<div class="col-sm-12">
    				<div class="row">
    					<div><label for="name">Total Document Fee</label></div>
    					<div style="color: red;"><b><?php echo $total;?></b></div>
    				</div>
				</div>
				<?php }
			  if($paper1=='IA'){ ?>
				<div class="col-sm-12">
    				<div class="row">
    					<div class="col-lg-4">
    						<div><label for="name">Total Document Fee</label></div>
    						<div style="color: red;"><b><?php echo $total;?></b></div>
    					</div>
    					<div class="col-lg-4">
    						<div><label for="name">IA Fee</label></div>
    						<div style="color: red;"><b><?php echo '1000';?></b></div>
    					</div>
    					<div class="col-lg-4">
    						<div><label for="name">Total Fee</label></div>
    						<div style="color: red;"><b><?php echo $total = $total+1000;?></b></div>
    					</div>
					</div>
				</div>
				<?php }
		      if($bd==3){  ?>
	   <div class="row">
                <div class="col-lg-4">
                    <div><label for="name"><span class="custom"><span><font color="red">*</font></span><?php echo ucfirst($_REQUEST['type']); ?> Fee</span></label></div>
                    <div><input type="text" name="ntrp" id="ntrp" class="form-control" value="NTRP" onkeypress="return onKeyValidate(event,alpha);" /></div>
                    <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Date of Transction</span></label></div>
                    <div><input type="text" name="ntrpdate" id="ntrpdate"  placeholder="02/02/1989" autocomplete="off" class="form-control alert-danger datepicker" readonly="true" onclick="get_date(this);"  value="" /></div>
                </div>
                <div class="col-lg-4">
                    <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Challan/Ref. Number</span></label></div>
                    <div><input type="text" maxlength="13" name="ntrpno" id="ntrpno" class="form-control" value="" onkeypress="return isNumberKey(event)" /></div>
                </div>
                <div class="col-lg-4">
                    <div><label for="name"><span class="custom"><span><font color="red">*</font></span>Amount in Rs.</span></label></div>
                    <div><input type="text" name="ntrpamount" id="ntrpamount" class="form-control" value="" maxlength="7" autocomplete="off" onkeypress="return isNumberKey(event)"/></div>
                    <div><br><p></p></div>
                    <?php if($paper1!=""){?>
        			<div><input type="button" name="btnSubmit" id="btnSubmit" value="Save" class="btn btn-info" onclick="maAction<?php echo $type_function; ?>();"/></div>
        			<?php }else {?>
        			<div><input type="button" name="btnSubmit" id="btnSubmit" value="Save" class="btn btn-info" onclick="filingAction<?php echo $type_function; ?>();"/></div>
        		   <?php } ?>
                </div>
            </div>      
    	<?php  } ?>
		<input type="hidden" id="total_feeee" name='total_feeee' value="<?php echo $total; ?>" ?>

<div class="row ">
           <div class="col-md-4">
       		 <input type="button" name="btnSubmit" id="btnSubmit" value="Add Amount" class="btn btn-success btn-lg float-left" onclick="addMoreAmountrpepcp()"/>
            </div>
        </div> 
		<div id="add_amount_list">
		</div>

<script>
$(document).ready(function(){
	 $(".datepicker" ).datepicker({ 
		 dateFormat: "dd-mm-yy",
	});
	}); 
</script>



