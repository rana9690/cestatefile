<?php 

$bd=htmlspecialchars($app);
if($bd==2)
    $name="Post Office Details";
if($bd==1)
	$name="Bank Details";
if($bd==3)
	$name="Online Payment";	
?>

<script>
$(document).ready(function(){
	 $(".datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
	}); 
</script>
	
<?php if($bd==3){?>
<div class="col-md-12">
		<div class="row">
            <div class="col-lg-3">
                <div>
                	<label for="name"><span class="custom"><span><font color="red">*</font></span>Payment Method </span></label>
                    <?php

                    ?>
                    <?=form_dropdown('ntrp',['NTRP'=>'Bharat Kosh (NTRP)','dd'=>'Demand Draft'],'NTRP',['class'=>'form-control','id'=>'ntrp']);?>
                </div>
             </div>   
             
             <div class="col-lg-3">
                <div>
                	<label for="name"><span class="custom"><span><font color="red">*</font></span>Date of Transction</span></label>
                    <?= form_input(['name'=>'ntrpdate','class'=>'form-control datepicker','id'=>'ntrpdate','placeholder'=>'ntrpdate','maxlength'=>'200','title'=>'Designation only alphanumeric','readonly'=>'1']) ?>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div>	
                	<label for="name"><span class="custom"><span><font color="red">*</font></span>Challan/Ref. Number</span></label>
                    <?= form_input(['name'=>'ntrpno','class'=>'form-control','id'=>'ntrpno','placeholder'=>'ntrp no','pattern'=>'[0-9]{1,13}','onkeypress'=>'return  isNumberKey(event)','maxlength'=>'13','title'=>'Designation only alphanumeric']) ?>
                </div>
            </div>
            
             <div class="col-lg-3">
                <div>
                	<label for="name"><span class="custom"><span><font color="red">*</font></span>Amount in Rs.</span></label>
               	    <?= form_input(['name'=>'ntrpamount','class'=>'form-control','id'=>'ntrpamount','onkeypress'=>'return isNumberKey(event)','placeholder'=>'ntrp amount','pattern'=>'[0-9]{1,7}','onKeyValidate'=>'isNumberKey(event,alpha);','maxlength'=>'7','title'=>'Designation only alphanumeric']) ?>
                </div>
            </div>
        </div>
         <div class="row" style="margin-top:40px;">




       		 <input type="button" name="btnSubmit" id="btnSubmit" value="Add Amount" class="btn1 btn btn-xs btn-warning" style="margin-left:24px;" onclick="addMoreAmount()" />

               <input type="button" name="btnSubmit" id="btnSubmit" value="Final Submit" class="btn btn-primary" style="margin-left:24px;"onclick="finalsubmit()">


        </div>
    </div>


<?php } ?>



