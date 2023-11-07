<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("globalstyle"); ?>
<?php $this->load->view("admin/sidebar"); ?>

 <!--Angualrjs -->
<div class="content" style="padding:0px;"  ng-controller="users" data-ng-init="usersInformation()" ng-app="my_app">
<div class="row">

		<div class="card checklistSec" style="">
             
			<h3>Suggested Case List</h3>
              	 <table id="example" class="table trial-table2 display nowrap border" style="width:100%">
                        <thead>
                            <tr >
                                <th>Sr.No</th>
                                <th><?=$this->lang->line('dfrno')?></th>
                                <th>Case No.</th>
                                <th>Date of Filing</th>
                                <th>Case Type</th>
                                <th>Party</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php


                         if($filedcase->num_rows()>0){
                          $i=1;
                          foreach($filedcase->result() as $val){?>

                             

                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?=displayDiaryNo($val->filing_no)?></td>
                                <td><?=displayAppNoTest(['caseType'=>$caseTypeShort[$val->case_type],'caseNo'=>$val->case_no])?></td>
                                <td><?php echo $val->dt_of_filing; ?></td>
                                <td><?=$caseTypeFull[$val->case_type]?></td>
                                <td><?php echo $val->pet_name.$this->efiling_model->fn_addition_party($val->filing_no,1); ?><span style="color:red"> <br>VS <br></span><?php echo $val->res_name.$this->efiling_model->fn_addition_party($val->filing_no,2); ?></td>



                                <td><a href="javascript:void(0)" onclick="linkCase('app','<?=$val->filing_no?>')" class="btn1 btn btn-xs btn-warning">ADD</a>
									</td>
                         <?php $i++; } } ?>
                        </tbody>
                    </table>
              </div>
        </div>

</div>  

 
 
<?php $this->load->view("suggested/suggestedCaseModel"); ?>
 <?php $this->load->view("admin/footer"); ?>
 <?php $this->load->view("globalscript"); ?>
 <script src="<?= base_url("asset/admin_js_final/suggestedCaseModel.js") ;?>" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip'
            /*buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]*/
        } );
    } );
    </script>