<script>
paymentMode_review_petion('3');
</script>

<fieldset style="padding-right: 0px;">
    <legend class="customlavelsub">Payment Details</legend>
    <?php
    $type_function = '';
    if ($_REQUEST['type_exec'] == 'contempt') {
        $court_fee = 5000;
        $processfee = 2000;
        $type_function = 'contempt';
    } else if ($_REQUEST['type_exec'] == 'execution') {
        $type_function = 'execution';
        $court_fee = 5000;
        $processfee = 2000;
    } else if ($_REQUEST['type_exec'] == 'review') {
        $type_function = 'review_petion';
        $court_fee = 30000;
        $processfee = 2000;
    }
    $fee = $_REQUEST['fee'];
    $totalann = $_REQUEST['ann'];
    $nature = explode(",", $fee);
    $totalIA = $_REQUEST['ia'];
    $exe = $_REQUEST['exe'];
    $len = count($nature) - 1;
    $annFee=0;

   for ($i = 0; $i < $len; $i++) {
        if ($nature[$i] == 11) {
            $atotal = $totalann * 25;
        } if ($nature[$i] == 7) {  
            $annFee = $annFee + 25;
        }
    }

    if ($totalIA != "") {
        $totalIA = $totalIA * 1000;
    }
    $atotal1 = $atotal + $annFee;
    $anxtotal = $totalIA + $atotal1;
    $total = $anxtotal + $court_fee + $processfee;
   $order_date=$_REQUEST['order_date'];

   $reffrenceno=$_REQUEST['salt'];
    $ial=$_REQUEST['iaNature'];
    $val=explode(',', $ial);
    $ia='';
    if(in_array('3',$val,true)){
        $ia='3';
    }

    ?>
    <input type="hidden" name="courtfee" id="courtfee_iddd" value="<?php echo $processfee + $court_fee; ?>"/>
    <input type="hidden" name="iafee" id="iafee_iddd" value="<?php echo $totalIA; ?>"/>
    <input type="hidden" name="tttotal_feee_amount" id="tttotal_feee_amount_iddd" value="<?php echo $total; ?>"/>
    <input type="hidden" name="order_date" id="order_date" value="<?php echo $order_date; ?>"/>

    <input type="hidden" name="iaval" value="<?php echo $ia; ?>" id="iaval">
    <input type="hidden" name="profee" value="<?php echo $processfee; ?>" id="profee">
    <input type="hidden" name="anxfee" value="<?php echo $anxtotal; ?>" id="anxfee">
    <div class="row">
        <div class="col-lg-3">
            <div><label for="name"><span class="custom"><span><font color="red"></font></span>Court Fee</span></label>
            </div>
            <div><font color="red"><b><?php echo $court_fee; ?></b></font></div>
        </div>
        <div class="col-lg-3">
            <div><label for="name"><span class="custom"><span><font color="red"></font></span>Process Fee</span></label>
            </div>
            <div><font color="red"><b><?php echo $processfee; ?></b></font></div>
        </div>
        <div class="col-lg-3">
            <div><label for="name"><span class="custom"><span><font color="red"></font></span>Annexure/Other Fee/IA Fee</span></label>
            </div>
            <div><font color="red"><b><?php echo $anxtotal; ?></b></font></div>
        </div>
        <div class="col-lg-3">
            <div><label for="name"><span class="custom"><span><font color="red"></font></span>Total Fee</span></label>
            </div>
            <div><font color="red"><b><?php echo $total; ?></b></font></div>
        </div>
    </div>
    
  <div class="row">
    <div class="col-sm-12 div-padd">
        <div><label for="name"><span class="custom"><span><font color="red">*</font></span>ransaction Details</span></label></div>
            <div>
            	<label for="name"><span class="custom">
                    <?php
                    $type_function = '';
                    if ($_REQUEST['type_exec'] == 'contempt') {
                        $type_function = 'contempt';
                    } else if ($_REQUEST['type_exec'] == 'execution') {
                        $type_function = 'execution';
                    } else if ($_REQUEST['type_exec'] == 'review') {
                        $type_function = 'review_petion';
                    }
                    ?>
                 <!--   Bank Draft<input type="radio" name="bd" id="bd" value="1" onclick="paymentMode_<?php echo $type_function; ?>(1);"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Postal Order<input type="radio" name="bd" id="po" value="2" onclick="paymentMode_<?php echo $type_function; ?>(2);"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->  
                    Online Payment<input type="radio" name="bd" id="on" value="3" onclick="paymentMode_<?php echo $type_function; ?>(3);" checked="checked">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
    		    </label>
            </div>
    </div>

  <fieldset style="padding-right: 0px;"><legend class="customlavel2">Payment Detail</legend>

     <div class="row ">
       <div class="col-md-4">
          <label for="name"><span class="custom"><span><font color="red"></font></span>Total Amount</span></label>
   		  <input type="text" name="totalamount" id="totalamount" value="<?php echo $total; ?>"   class="form-control" readonly>
        </div>
        <div class="col-md-4">
          <label for="name"><span class="custom"><span><font color="red"></font></span>Remaining Amount</span></label>
   		  <input type="text" name="remainamount" id="remainamount" value="<?php echo $total; ?>"   class="form-control" readonly>
        </div>
           <div class="col-md-4">
          <label for="name"><span class="custom"><span><font color="red"></font></span>Collected Amount</span></label>
   		  <input type="text" name="collectamount" id="collectamount" value=""   class="form-control" readonly>
        </div>
    </div>

    <div class="col-sm-12 div-padd" id="payMode_<?php echo $type_function; ?>" style="display: none"></div>
    <div class="col-sm-12 div-padd" id="addmoreadd_<?php echo $type_function; ?>" style="display: none"></div>
    <div class="col-sm-12 div-padd" id="addmoreaddpay_<?php echo $type_function; ?>" style="display: none"></div>
</fieldset>