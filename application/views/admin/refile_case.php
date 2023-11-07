<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 <!--Angualrjs -->
<div class="content" style="padding-top:0px;margin-top: 32px;"  ng-controller="users" data-ng-init="usersInformation()" ng-app="my_app">
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
              <div class="container">
			<h6> Difective Case List</h6>
                	 <table id="example" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Reference No.</th>
                                <th>DFR.No.</th>
                                <th>Date of Filing</th>
                                <th>Case Type</th>
                                <th>Status</th> 
                                <th>Defect Latter</th> 
                                <th>Action</th>           
                            </tr>
                        </thead>
                        <tbody>
                         <?php 
                         if(is_array(@$refile)){
                         $i=1;foreach($refile as $val){    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val->salt;; ?></td>
                                <td><?php echo $val->filing_no; ?></td>
                                <td><?php echo $val->dt_of_filing; ?></td>
                                <td><?php echo $val->case_type; ?></td>
                                <td><?php echo $val->status; ?></td>  
                                <td><a  target="_blank" href="<?php echo base_url(); ?>/defectlatter/<?php echo $val->filing_no; ?>" onclick="refilingcase('<?php echo $val->filing_no; ?>','<?php echo $val->case_type; ?>');">View</a></td>
                                <td><button class="dbox__action__btn" style="border: 0px; border-radius: 29px;"><a href="javascript: void(0);" onclick="refilingcase('<?php echo $val->filing_no; ?>','<?php echo $val->case_type; ?>');">Re-File</a></button></td>    
                            </tr>                       						
                         <?php $i++;} } ?>   
                        </tbody>
                    </table>
              </div>
        </div>
	</div>
</div>   
 <?php $this->load->view("admin/footer"); ?>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

function refilingcase(val,tab){
    var dataa={};
    dataa['filing_no']=val;
	$.ajax({
        type: "POST",
        url: base_url+"requestrefiling",
        data: dataa,
        cache: false,
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
        		$('.steps').empty().load(base_url+'/efiling/case_filing_steps1');
			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}
</script>