<?php

$addparty = $_REQUEST['partuid'];
$pid = rtrim($addparty, ',');
$filingNo = $_REQUEST['fno'];
$partyid = explode(",", $addparty);
$type = $_REQUEST['type'];
$mainparty = array();

$totalNoAnnexure=$_REQUEST['totalNoAnnexure'];
$matter=$_REQUEST['matter'];
$i = 0;
$ii = 0;
$j = 0;
$jj = 0;
$inserttype='RP';
$date=date('d/m/Y');
 if($type==3){
    $status='1';
    $_SESSION['patyAddId']=$_REQUEST;
    $data=array(
        'select_org_app'=>$_REQUEST['select_org_app'],
        'petname'=>$_REQUEST['petName'],
        'dstate'=>$_REQUEST['dstate'],
        'petmobile'=>$_REQUEST['petmobile'],
        'degingnation'=>$_REQUEST['degingnation'],
        'ddistrict'=>$_REQUEST['ddistrict'],
        'petphone'=>$_REQUEST['petPhone'],
        'petaddress'=>$_REQUEST['petAddress'],
        'pincode'=>$_REQUEST['pincode'],
        'petemail'=>$_REQUEST['petEmail'],
        'petfax'=>$_REQUEST['petFax'],
        'councilcode'=>$_REQUEST['councilCode1'],
        'ddistrictname'=>$_REQUEST['ddistrictname1'],
        'counselAdd'=>$_REQUEST['counselAdd1'],
        'counselpin'=>$_REQUEST['counselPin1'],
        'counselemail'=>$_REQUEST['counselEmail1'],
        'dstatename'=>$_REQUEST['dstatename1'],
        'counselmobile'=>$_REQUEST['counselMobile1'],
        'counselfax'=>$_REQUEST['counselFax1'],
        'created_date'=>$date,
        'type'=>$inserttype,
        'filing_no'=>$filingNo,
        'status'=>$status,
    );
    $st=$this->efiling_model->insert_query('certified_copy_thirdparty',$data);
 }


 
 
 $reffrenceno= $this->session->userdata('reffrenceno');
 $sql =$this->efiling_model->data_list_where('rpepcp_reffrence_table','salt',$reffrenceno);
 if(empty($sql)){
     $userdata=$this->session->userdata('login_success');
     $user_id=$userdata[0]->id;
     $data=array(
         'salt'=>$_REQUEST['refsalt'],
         'filing_no'=>$_REQUEST['fno'],
         'totalNoAnnexure'=>$_REQUEST['totalNoAnnexure'],
         'matter'=>$_REQUEST['matter'],
         'partyType'=>$_REQUEST['type'],
         'party_ids'=>$_REQUEST['partuid'],
         'case_type'=>$_REQUEST['type_type'],
         'otherFeeCode'=>$_REQUEST['otherFee'],
         'councilcode'=>$_REQUEST['councilCode1'],
         'ddistrictname'=>$_REQUEST['ddistrictname1'],
         'counselAdd'=>$_REQUEST['counselAdd1'],
         'counselpin'=>$_REQUEST['counselPin1'],
         'counselemail'=>$_REQUEST['counselEmail1'],
         'dstatename'=>$_REQUEST['dstatename1'],
         'counselmobile'=>$_REQUEST['counselMobile1'],
         'counselfax'=>$_REQUEST['counselFax1'],
         'entry_date'=>date('Y-m-d'),
         'user_id'=>$user_id,
     );
     $st=$this->efiling_model->insert_query('rpepcp_reffrence_table',$data);
 }

 
 
    if($type!='3'){
        if($partyid[0]==""){
            echo "please Select party type";die;
        }
        if ($partyid[0] != "" ) {   
            if ($type == 2) {
                $nameparty = 'Applicant';
                $flag = 1;
            }if ($type == 1) {
                $nameparty = 'Respondent';
                $flag = 2;
            }
    ?>

















 <fieldset>
        <legend class="customlavelsub">Set Priority For Party</legend>

            <div class="table-responsive" id="va1">
                <table datatable="ng" id="examples"
                       class="table table-striped table-bordered" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Applicant Name</th>
                        <th>Priority No</th>
                    </tr>
                    </thead>
                    <tbody>


                <?php
                  $len = sizeof($partyid);
                  $len = $len - 1;
                  for ($k = 0; $k < $len; $k++) {
                    if ($partyid[$k] == 1) {
                        $sql = "select * from aptel_case_detail where filing_no='$filingNo'";
                        $query=$this->db->query($sql);
                        $data = $query->result();
                        foreach ($data as $row) {
                            if($type == 2) {
                                $mainparty = $row->res_name;
                                $partflagres = 999;
                                $j++;
                                $jj++;
                            }
                            if ($type == 1) {
                                $partflagpet = 999;
                                $mainparty = $row->pet_name;
                                $j++;
                                $jj++;

                            }
                            if ($type == 3) {
                                $partflagpet = 999;
                                $mainparty = $row->pet_name;
                                $j++;
                                $jj++;
                            }
                        }

                        ?>
                        <tr>
                        <td><input type="checkbox" name="patyAddIdmain"  value="<?php echo '1'; ?>" checked="checked"></td>
                            <td><?php echo $mainparty; ?></td>
                            <td><input type="text" size='3' value="" name="numbermian" onkeyup="valcheck();"></td>
                        </tr>
                        <?php
                    }
                }

                 $sqladd1 = "select * from additional_party where filing_no='$filingNo' and  party_id IN($pid)";
                 $query=$this->db->query($sqladd1);
                 $data = $query->result();
                 foreach ($data as $row) {
                    $id = $row->party_id;
                    $pet_name11 = $row->pet_name;
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddIdmain" value="<?php echo $id; ?>" checked="checked"></td>
                        <td><?php echo htmlspecialchars($pet_name11); ?></td>
                        <td><input type="text" size='3' value="" name="numbermian" onkeyup="valcheck();"></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        <div class="col-sm-12 div-padd">
            <div class="table-responsive" id="va2">

                <table datatable="ng" id="examples"
                       class="table table-striped table-bordered" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php if (type != 1) {
                                echo 'Respondent';
                            }; ?> Name</th>
                        <th>Priority No</th>
                    </tr>
                    </thead>
                    <tbody>


                <?php
                if ($partflagpet != 999) {

                    $sql = "select * from aptel_case_detail where filing_no='$filingNo'";
                    $query=$this->db->query($sql);
                    $data = $query->result();
                    foreach ($data as $row) {
                        if ($type != 2) {
                            $mainparty1 = $row->res_name;
                        }
                        if ($type != 1) {
                            $mainparty1 = $row->pet_name; 
                        }
                    }
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo '1P'; ?>" checked="checked"></td>
                        <td><?php echo htmlspecialchars($mainparty1); ?></td>
                        <td><input type="text" size='3' value="" name="number1" onkeyup="valcheck1();"></td>
                    </tr>
                    <?php
                }
                $sqladd1 = "select * from additional_party where filing_no='$filingNo' and party_flag='$flag'";
                $query=$this->db->query($sqladd1);
                $data = $query->result();
                foreach ($data as $row) {
                    $id = $row->party_id;
                    $pet_name11 = $row->pet_name;
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo $id; ?>" checked="checked"></td>
                        <td><?php echo htmlspecialchars($pet_name11); ?></td>
                        <td><input type="text" size='3' value="" name="number1" onkeyup="valcheck1();"></td>
                    </tr>

                    <?php
                }
                if ($partflagres != 999) {
                    $sql = "select * from aptel_case_detail where filing_no='$filingNo'";
                    $query=$this->db->query($sql);
                    $data = $query->result();
                    foreach ($data as $row) {
                        $mainpartyres1 = $row->res_name;
                    }
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo '1R'; ?>" checked="checked"></td>
                        <td><?php echo htmlspecialchars($mainpartyres1); ?></td>
                        <td><input type="text" size='3' value="" name="number1" onkeyup="valcheck1();"></td>
                    </tr>
                    <?php
                }
                if ($type == 1)
                    $flag1 = 1;
                if ($type == 2)
                    $flag1 = 2;

                $sqladd111 = "select * from additional_party where filing_no='$filingNo' and party_flag='$flag1' and  party_id NOT IN($pid)";
                $query=$this->db->query($sqladd111);
                $data = $query->result();
                foreach ($data as $row) {
                    $id = $row->party_id;
                    $pet_name11 = $row->pet_name;
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo $id; ?>" checked="checked"></td>
                        <td><?php echo htmlspecialchars($pet_name11); ?></td>
                        <td><input type="text" size='3' value="" name="number1" onkeyup="valcheck1();"></td>
                    </tr>

                    <?php

                }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </fieldset>
    
    










    <fieldset id="iaNature" style="display:block"><legend class="customlavelsub">IA Nature</legend>
        <div class="table-responsive">
 <div class="col-sm-3 div-padd">
                <div><label for="phone"><span class="custom"><font color="red">*</font>Total No Of IA:</span></label></div>
                <div id="phone"><input type="text" name="totalNoIA" id="totalNoIA" class="form-control" maxlength="1"   size="20" value="" onkeypress="return isNumberKey(event)"/></div>
            </div>

            <table datatable="ng" id="examples"
                   class="table table-striped table-bordered" cellspacing="0"
                   width="100%">
                <thead>
                <tr><th>#</th>
                  
                    <th>IA Nature Nam</th>
                    <th>Fees</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $array=array('34','20','19','52','17','18','23','14','15','28','29','31','36','10','39','40','21','41','42','43','45','48','49','50','51','35','22','27','6','53','54','55','56','57','58','59','60');
                $aDetail= $this->efiling_model->ia_data_list('moster_ia_nature',$array,'nature_code','nature_code');
           //     $aDetail=$this->efiling_model->data_list('moster_ia_nature');
                foreach($aDetail as $row) {
                    ?>
                    <tr>
                        <td><input type = "checkbox" name = "natureCode" value ="<?php echo htmlspecialchars($row->nature_code); ?>"/></td>
                       
                        <td><?php echo htmlspecialchars($row->nature_name);?></td>
                        <td><?php echo htmlspecialchars($row->fee);?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>

        <div class="col-sm-12 div-padd">
           
            <div class="col-sm-6 div-padd" style="display:block;float:right">
                <?php
                $type_function= '';
                if ($_REQUEST['type_type'] == 'contempt') {
                    $type_function = 'payment_contempt()';
                } else if ($_REQUEST['type_type'] == 'execution') {
                    $type_function = 'payment_execution()';
                } else if ($_REQUEST['type_type'] == 'review') {
                    $type_function = 'payment()';
                }
                ?>
                <div id="payNext"  style="display:block;float:right">  <input type="button" name="nextsubmit" id="nextsubmit" value="Save & Next"  class="btn btn-info" onclick="<?php echo $type_function; ?>"/></div>

            </div></div>
    </fieldset>
<?php }
    }
if($type=='3'){?>
    <fieldset>
        <legend class="customlavelsub">Set Priority For Party</legend>


<input type="hidden" size='3' value="<?php echo $totalNoAnnexure; ?>" name="totalNoAnnexure" id="totalNoAnnexure">
<input type="hidden" size='3' value="<?php echo $matter; ?>" name="matter" id="matter">

            <div class="table-responsive">
                <table datatable="ng" id="examples"
                       class="table table-striped table-bordered" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Applicant Name</th>
                        <th>Priority No</th>
                    </tr>
                    </thead>
                    <tbody>
               		 <?php 
               		 $sql =$this->efiling_model->data_list_where('certified_copy_thirdparty','filing_no',$filingNo);
               		 foreach ($sql as $row) {
                        if ($type == 3) {
                            $partflagpet = 999;
                            $mainparty = $row->petname;
                        } 
                    ?>
                        <tr>
                        <td><input type="checkbox" name="patyAddIdmain"  value="<?php echo '1'; ?>"></td>
                            <td><?php echo $mainparty; ?></td>
                            <td><input type="text" size='3' value="" name="numbermian"></td>
                        </tr>
                        <?php
                    }
                     ?>
                    </tbody>
                </table>
            </div>

        <div class="col-sm-12 div-padd">

            <div class="table-responsive">
                <table datatable="ng" id="examples"  class="table table-striped table-bordered" cellspacing="0"  width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php  echo 'Respondent'; ?> Name</th>
                        <th>Priority No</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $sql = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filingNo);
                    foreach ($sql as $row) {
                        if ($type != 2) {
                            $mainparty1 = $row->res_name;
                        }
                        if ($type != 1) {
                            $mainparty1 = $row->pet_name;
                        }
                    }
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo '1P'; ?>"></td>
                        <td><?php echo htmlspecialchars($mainparty1); ?></td>
                        <td><input type="text" size='3' value="" name="number1"></td>
                    </tr>
                <?php
                $sqladd1 = $this->efiling_model->data_list_where('additional_party','filing_no',$filingNo);
                foreach ($sqladd1 as $row) {
                    $id = $row->party_id;
                    $pet_name11 = $row->pet_name;
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo $id; ?>"></td>
                        <td><?php echo htmlspecialchars($pet_name11); ?></td>
                        <td><input type="text" size='3' value="" name="number1"></td>
                    </tr>
                    <?php }
                if ($partflagres != 999) {
                    $sql = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filingNo);
                    foreach ($sql as $row) {
                        $mainpartyres1 = $row->res_name;
                    }
                    ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo '1R'; ?>"></td>
                        <td><?php echo htmlspecialchars($mainpartyres1); ?></td>
                        <td>
                        <input type="text" size='3' value="" name="number1"></td>
                    </tr>
                    <?php
                }
                if ($type == 1)
                    $flag1 = 1;
                if ($type == 2)
                    $flag1 = 2;
                $arr=array('filing_no'=>$filingNo,'party_flag'=>$flag1);
                $stdit = $this->efiling_model->select_in('additional_party',$arr);  
                foreach ($stdit as $row) {
                    $id = $row->party_id;
                    $pet_name11 = $row->pet_name; ?>
                    <tr>
                        <td><input type="checkbox" name="patyAddId1" value="<?php echo $id; ?>"></td>
                        <td><?php echo htmlspecialchars($pet_name11); ?></td>
                        <td><input type="text" size='3' value="" name="number1"></td>
                    </tr>
                    <?php   }  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </fieldset>

    <fieldset id="iaNature" style="display:block"><legend class="customlavelsub">IA Nature</legend>
        <div class="table-responsive">
             <div class="col-sm-6 div-padd">
                <div><label for="phone"><span class="custom"><font color="red">*</font>Total No Of IA:</span></label></div>
                <div id="phone"><input type="text" name="totalNoIA" id="totalNoIA" class="form-control" maxlength="1"   value="" onkeypress="return isNumberKey(event)"/></div>
            </div>


            <table datatable="ng" id="examples"  class="table table-striped table-bordered" cellspacing="0"  width="100%">
                <thead>
                <tr><th>#</th>
                  
                    <th>IA Nature Nam</th>
                    <th>Fees</th>
                </tr>
                </thead>
                <tbody>
                <?php  
                $array=array('34','20','19','52','17','18','23','14','15','28','29','31','36','10','39','40','21','41','42','43','45','48','49','50','51','35','22','27','6','53','54','55','56','57','58','59','60');
                $aDetail= $this->efiling_model->ia_data_list('moster_ia_nature',$array,'nature_code','nature_code');
              
                foreach($aDetail as $row) {
               ?>
                    <tr>
                        <td><input type = "checkbox" name = "natureCode" value ="<?php echo htmlspecialchars($row->nature_code); ?>"/></td>
                      
                        <td><?php echo htmlspecialchars($row->nature_name);?></td>
                        <td><?php echo htmlspecialchars($row->fee);?></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>

        <div class="col-sm-12 div-padd">
           
            <div class="col-sm-6 div-padd" style="display:block;float:right">
                <?php
                $type_function= '';
                if ($_REQUEST['type_type'] == 'contempt') {
                    $type_function = 'payment_contempt()';
                } else if ($_REQUEST['type_type'] == 'execution') {
                    $type_function = 'payment_execution()';
                } else if ($_REQUEST['type_type'] == 'review') {
                    $type_function = 'payment()';
                }
                ?>
                <div id="payNext"  >  
                	<input type="button" name="nextsubmit" id="nextsubmit" value="Save & Next"  class="btn btn-info" onclick="<?php echo $type_function; ?>"/>
                </div>
            </div></div>
    </fieldset>
    <script>
$(document).ready(function(){
	 $(".datepicker" ).datepicker({ 
		 dateFormat: "dd-mm-yy",
	});
	}); 
</script>
<?php } ?>