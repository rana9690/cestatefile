<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
    <div class="content" style="padding:0px;">
    <div class="row">
    <div class="card checklistSec" style="">
    <h3>Pending  Defects </h3>
    <table  class="table trial-table2 display nowrap border" style="width:100%">

                              <thead>
                                <tr>
                                  <th scope="col">S.NO</th>
                                  <th scope="col">Re-defect Date</th>
                                  <th scope="col">Defect Type</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php                                 
                                $state= $this->efiling_model->data_list_where('objection_details','filing_no',$filingno);
								//echo $this->db->last_query();

                                $i=1;
                                $subobjname11='';
                                foreach($state as $row1){
                                   // if($row1->status!='YES' || $row1->status=='OTH'){
                                    $objection_code=$row1->objection_code;
                                    $obj= $this->efiling_model->data_list_where('objection_master','objection_code',$objection_code);
                                    $subobjname11=$obj[0]->objection_type;
                                    /*$string = str_replace(' ', '', $row1->comments);
                                    $val= strlen($string);
                                    if ($val>3) {
                                        $subobjname11=$row1->comments;
                                    }*/
                                ?>
                                <tr>
                                      <td><?php echo htmlspecialchars($i);?></td>
                                      <td><?php echo htmlspecialchars(date('d/m/Y',strtotime($row1->obj_date)));  ?></td>
                                      <td><?php echo $subobjname11;?></td>
                                </tr>
                          		 <?php $i++;  //}
                                }
                          		 ?>
                              </tbody>
                            </table>

        </div>
	</div>
</div>	
<?php $this->load->view("admin/footer"); ?>