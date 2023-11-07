
<style>
    .btn-info {
        margin: 5px 0;
    }
    #actintable td, #actintable th {
        padding: 0px 8px;
    }
    #actintable th {
        background: #171717;
        color: #fff;
        padding: 5px 8px;
    }
</style>
<table id="advdetails_dfgdgdf" class="display" cellspacing="0" border="1" width="100%">
    <thead>
    <tr>
        <th>Sr. No.</th>
        <th>Advcate name</th>
        <th>Main Party</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Delete</th>
    </tr>
    </thead>
    <?php

    $new_filing_no = $salt;
    if (isset($_REQUEST['filing_no']) && $_REQUEST['filing_no'] != '') {
        $new_filing_no = $_REQUEST['filing_no'];
    }

    $new_pflag = $pflag;
    if (isset($_REQUEST['party_flag']) && $_REQUEST['party_flag'] != '') {
        $new_pflag = $_REQUEST['party_flag'];
        if ($new_pflag == '2') {
            $new_pflag = 'R';
        } else if ($new_pflag == '1') {
            $new_pflag = 'P';
        }
    }
    if($new_pflag == 'P') {
        $stha20_aptel_case_detail = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$new_filing_no);
        $pet_adv_code = $stha20_aptel_case_detail[0]->pet_adv;
        $stha20 = $this->efiling_model->data_list_where('master_advocate','adv_code',$pet_adv_code);
        ?>
        <tr>
            <td><?php echo '1'; ?></td>
            <td><?php echo htmlspecialchars($stha20[0]->adv_name); ?></td>
            <td><?php echo 'A1'; ?></td>
            <td><?php echo htmlspecialchars($stha20[0]->adv_mobile); ?></td>
            <td><?php echo htmlspecialchars($stha20[0]->email); ?></td>
            <td></td>
        </tr>
        <?php

    }

    if($new_pflag == 'R') {
        $stha20_aptel_case_detail =$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$new_filing_no);
        $pet_adv_code = $stha20_aptel_case_detail[0]->res_adv;
        $stha20 =$this->efiling_model->data_list_where('master_advocate','adv_code',$pet_adv_code);
        ?>
        <tr>
            <td><?php echo '1'; ?></td>
            <td><?php echo htmlspecialchars($stha20[0]->adv_name); ?></td>
            <td><?php echo 'R1'; ?></td>
            <td><?php echo htmlspecialchars($stha20[0]->adv_mobile); ?></td>
            <td><?php echo htmlspecialchars($stha20[0]->email); ?></td>
            <td></td>
        </tr>
        <?php

    }

    $arr_adv_name_pet = array();
   
    $val=array('filing_no'=>$new_filing_no,'party_code'=>'1','party_flag'=>$new_pflag);
    $row_advocate =$this->efiling_model->data_list_mulwhere('additional_advocate', $val);
    $pet_adv_nameadd_adv = '';
    $ii11 = '2';
    foreach ($row_advocate as $sqladd1_advocate) {
        $party_flag = $sqladd1_advocate->party_flag;
        $advId = $sqladd1_advocate->id;
        $psno = $sqladd1_advocate->party_code;
        $sthadd_adv = $this->efiling_model->data_list_where('master_advocate','adv_code',$sqladd1_advocate->adv_code);
        $pet_adv_nameadd_adv122 = $sthadd_adv[0]->adv_name;
        $temp_ara_pet = array();
        $temp_ara_pet['concil_name'] = $pet_adv_nameadd_adv122;
        if ($party_flag == 'P')
            $mainParty = 'A1';
        if ($party_flag == 'R')
            $mainParty = 'R1';
            $advv= $sqladd1_advocate->adv_code;
            $adv = $this->efiling_model->data_list_where('master_advocate','adv_code',$advv);
            $adv_name1 = $adv;
       //  echo "<pre>";  print_r($adv_name1);
   ?>

        <tr>
            <td><?php echo $ii11; ?></td>
            <td><?php echo htmlspecialchars($pet_adv_nameadd_adv122); ?></td>
            <td><?php echo $mainParty; ?></td>
            <td><?php echo htmlspecialchars($adv_name1[0]->adv_mobile); ?></td>
            <td><?php echo htmlspecialchars($adv_name1[0]->email); ?></td>
            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class=".btn-info"
                       onclick="deletePay('<?php echo $advId; ?>','<?php echo $psno; ?>')"/>
        </tr>


    <?php

        $ii11++;
    }

    ?>


    <?php 
  //  echo "select party_id,partysrno from additional_party where filing_no='$new_filing_no' order by partysrno ASC ";
    $partysi_party = "select party_id,partysrno from additional_party where filing_no='$new_filing_no' order by CAST(partysrno AS decimal) ASC ";
    $query=$this->db->query($partysi_party);
    $data = $query->result();
    $ii = $ii11;  
    foreach ($data as $row_party) {
        $party_id = $row_party->party_id;
        $partysrno = $row_party->partysrno;
        $hscquery = "SELECT id,adv_code,party_flag,adv_mob_no,adv_email,party_code as partysrno  FROM additional_advocate  WHERE party_code='$party_id' and   party_flag='$new_pflag' and filing_no='$new_filing_no'";
        $query=$this->db->query($hscquery);
        $data = $query->result();
        foreach ($data as $row) {
            $advId = $row->id;
            $acode = $row->adv_code;
            $party_flag = $row->party_flag;
            $psno = $row->partysrno;
            if ($party_flag == 'P')
                $mainParty = 'A -' . $partysrno;
            if ($party_flag == 'R')
                $mainParty = 'R -' . $partysrno;

                $adv_name = $this->efiling_model->data_list_where('master_advocate','adv_code',$acode);
            ?>
            <tr>
                <td><?php echo $ii; ?></td>
                <td><?php echo htmlspecialchars($adv_name[0]->adv_name); ?></td>
                <td><?php echo htmlspecialchars($mainParty); ?></td>
                <td><?php echo htmlspecialchars($row->adv_mob_no); ?></td>
                <td><?php echo htmlspecialchars($adv_name[0]->email); ?></td>
                <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class=".btn-info"
                           onclick="deletePay('<?php echo $advId; ?>','<?php echo $psno; ?>')"/>
            </tr>
            <?php
            $ii++;
        }
    }
    ?>







