
 <thead>
        <tr>
            <th>Sr. No. </th>
            <th>Appellant Name</th>
            <th>Designation</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead> 
<?php
$id=$_REQUEST['id'];
$party=$_REQUEST['party'];
$salt=$_REQUEST['salt'];
if($party=='appleant'){
    $appleant="appleant";
    $type="add";
    $vals=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$salt);
    if($vals[0]->pet_name!=''){
        $petName=$vals[0]->pet_name;
        if (is_numeric($vals[0]->pet_name)) {
            $orgname=$this->efiling_model->data_list_where('master_org','org_id',$vals[0]->pet_name);
            $petName=$orgname[0]->org_name;
        }
        $type="main";
        ?>
        <tr style="color:green">
            <td><?php echo 1; ?></td>
            <td><?php echo $petName; ?>(R-1)</td>
            <td><?php echo $vals[0]->pet_degingnation ?></td>
            <td> <?php echo $vals[0]->pet_mobile ?></td>
            <td><?php echo $vals[0]->pet_email ?></td>
            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"
            onclick="editPartyrefile('<?php echo $vals[0]->filing_no; ?>','<?php echo $appleant; ?>','<?php echo $type; ?>')"></td>
            <td></td>
        </tr>
      <?php 
    }
    $st=$this->efiling_model->delete_event('additional_party', 'party_id', $id);
    $feesd=$this->efiling_model->data_list_where('additional_party','filing_no',$salt);
    $i=2;
    foreach ($feesd as $row){
        $id=$row->id;
        $petName=$row->pet_name;
        if (is_numeric($row->pet_name)) {
            $orgname=$this->efiling_model->data_list_where('master_org','org_id',$row->pet_name);
            $petName=$orgname[0]->org_name;
        }
        $appleant="appleant";
        $type="add";
        ?>
       	        
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $petName; ?>(A-<?php echo $i; ?>)</td>
            <td><?php echo $row->pet_degingnation; ?></td>
            <td><?php echo $row->pet_mobile; ?></td>
            <td><?php echo $row->pet_email; ?></td>
            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editPartyrefile('<?php echo $row->party_id; ?>','<?php echo $appleant; ?>','<?php echo $type; ?>')"></td>
            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deletePartyrefile('<?php echo $row->party_id; ?>','<?php echo $appleant; ?>')"></td>
        </tr>
    <?php
    $i++;
    }
}




















if($party=='res'){
    
    $vals=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$salt);
     if($vals[0]->res_name!=''){
         $petName=$vals[0]->res_name;
         if (is_numeric($vals[0]->res_name)) {
             $orgname=$this->efiling_model->data_list_where('master_org','org_id',$vals[0]->res_name);
            $petName=$orgname[0]->org_name;
        }
        $appleant="res";
        $type="main";
        ?>                       
     	<tr style="color:green">
          <td><?php echo 1; ?></td>
            <td><?php echo $petName; ?>(R-1)</td>
            <td><?php echo $vals[0]->res_degingnation ?></td>
            <td> <?php echo $vals[0]->res_mobile ?></td>
            <td><?php echo $vals[0]->res_email ?></td>
            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal"
            data-target="#exampleModal"  onclick="editPartyrefile('<?php echo $vals[0]->filing_no; ?>','<?php echo $appleant; ?>','<?php echo $type; ?>')"></td>
    		<td></td>
        </tr>
      <?php } 
      $st=$this->efiling_model->delete_event('additional_party', 'party_id', $id);
      $appleant="res";
      $type="add";
      $feesd=$this->efiling_model->data_list_where('additional_party','filing_no',$salt);
      $i=2;
      foreach ($feesd as $row){
          $resName=$row->pet_name;
          if (is_numeric($row->pet_name)) {
              $orgname=$this->efiling_model->data_list_where('master_org','org_id',$row->pet_name);
              $resName=$orgname[0]->orgdisp_name;
          }
          $id=$row->id;
          $type="main";
          ?>
        <tr>
             <td><?php echo $i;?></td>
            <td><?php echo  $resName;?>(R-<?php echo $i;?>)</td>
            <td><?php echo $row->pet_degingnation;?></td>
            <td><?php echo $row->pet_mobile;?></td>
            <td><?php echo $row->pet_email;?></td>
            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Edit" class="btn1 btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal"  onclick="editPartyrefile('<?php echo $row->party_id; ?>','<?php echo $appleant; ?>','<?php echo $type; ?>')"></td>
            <td><input type="button" name="nextsubmit" id="nextsubmit" value="Delete" class="btn1 btn btn-xs btn-danger" onclick="deletePartyrefile('<?php echo $row->party_id; ?>','<?php echo $appleant; ?>')"></td>
        </tr>
        <?php
        $i++;
    }
}
?>