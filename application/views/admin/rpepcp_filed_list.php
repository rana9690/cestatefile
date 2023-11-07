<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("globalstyle"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<style>
    .inner-ftr {
        position: fixed;
        bottom: 0;
        right: 0;
    }
</style>
 <!--Angualrjs -->
<div class="content" style="padding:0px;"  ng-controller="users" data-ng-init="usersInformation()" ng-app="my_app">
	<div class="row">
		<div class="card checklistSec" style="">
			<h3>Filed Applications List</h3>
              	 <table id="example" class="table trial-table2 display nowrap border" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th><?=$this->lang->line('dfrno')?></th>
                                <th>Date of Filing</th>
                                <th>Case Type</th>
                                <th>Party</th>
                                <th>Status</th> 
								<th></th>           
                            </tr>
                        </thead>
                        <tbody>
                         <?php
                         $case_types=getApplicationTypesArray([]);

                         if($rpepcp->num_rows()){
                             $i=1;foreach($rpepcp->result() as $val){
                             $case_type = $val->case_type;
                             $case_type_name='';
                             /*if ($val->case_type == '5') {
                                 $case_type_name = 'Execution Petition(EP)';
                             } if ($val->case_type == '6') {
                                 $case_type_name = 'Review Petition(RP)';
                             }  if ($val->case_type == '7') {
                                 $case_type_name = 'Contempt  Petition(CP)';
                             }*/
                             $status='Filed';
                             if($val->status=='P'){
                                 $status='Pending';
                             }
							 if($val->appno!=''){
                                     $status= "<span style='color:Green'><b>Registerd</b></span>";
                                 }
								  if($val->status=='D'){
                                 $status='Disposed';
                             }
                             /*if ($val->case_type != '1') {
                                 $filing_No = substr($val->filing_no, 5, 6);
                                 $filing_No = ltrim($filing_No, 0);
                                 $filingYear = substr($val->filing_no, 11, 4);
                                 $vas= "DFR/$filing_No/$filingYear";*/
                             ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><a href="<?php echo base_url();?>dfrdetailrpepcp/<?php echo $val->appfiling_no; ?>" ><?=displayDiaryNo($val->appfiling_no)?></a></td>
                                <td><?php echo date('d/m/Y',strtotime($val->dt_of_filing)); ?></td>
                                <td><?=$case_types[$val->app_type]?></td>
                                <td><?php echo $val->pet_name.$this->efiling_model->fn_addition_party($val->filing_no,1); ?><span style="color:red"> VS <br></span><?php echo $val->res_name.$this->efiling_model->fn_addition_party($val->filing_no,2);; ?></td>
                                <td><?php echo $status; ?></td>      
								<td>
                                    <a href="javascript:void(0)" onClick="saveFeeMore('appl','<?=$val->appfiling_no?>')">Additional Payment</a>
                                   </td>								
                         <?php $i++;//}
                         }  }?>   
                        </tbody>
                    </table>
        </div>
	</div>
</div>
</div>	
<?php $this->load->view("admin/additionalFeeModel"); ?>
<?php $this->load->view("admin/footer"); ?>   
<?php $this->load->view("globalscript"); ?>
<script src="<?= base_url("asset/admin_js_final/additionalFeeModel.js") ;?>" type="text/javascript"></script>                                                          
<script>
    $('.nav-link').click(function() { 
        var content = $(this).data('value');
        if(content!=''){
        	$('.steps').empty().load(base_url+'/efiling/'+content);
        }
    });
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    });
    function EditModal(val){
    	  $.ajax({
              type: "POST",
              url: base_url+"filingaction/editapplant_respondent",
              data: "filingno=" + val,
              cache: false,
              success: function (data) {
            	  $("#detailccopy").html(data);
            	  $("#getCodeModal").modal("show");   
              }
          });
    }
    </script>
