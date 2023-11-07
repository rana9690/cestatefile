<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 <!--Angualrjs -->
<div class="content" style="padding-top:0px;margin-top: 32px;"  ng-controller="users" data-ng-init="usersInformation()" ng-app="my_app">
	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
			<h6> IA Draft Cases List</h6>
        	 <table id="example" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Reference No.</th>
                        <th>DFR.No.</th>
                        <th>Date of Filing</th>
                        <th>Case Type</th>
                        <th>Status</th>  
                        <th>Action</th>           
                    </tr>
                </thead>
                <tbody>
                 <?php 
                 $this->session->unset_userdata('iareffrenceno');
                 $this->session->unset_userdata('type');
                 $i=1;foreach($iadraftcase as $val){    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $val->salt;; ?></td>
                        <td><?php echo $val->filing_no; ?></td>
                        <td><?php echo $val->entry_date; ?></td>
                        <td><?php echo $val->case_type; ?></td>
                        <td><?php echo $val->status; ?></td>  
                        <td><button class="dbox__action__btn" style="border: 0px; border-radius: 29px;"><a href="javascript: void(0);" onclick="droftrefiling('<?php echo $val->salt; ?>','<?php echo $val->case_type; ?>');">Edit-Final</a></button></td>                     						
                 <?php $i++;} ?>   
                </tbody>
            </table>
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

function droftrefiling(val,type){
    var dataa={};
    dataa['reffrenceno']=val;
    dataa['type']=type;
	$.ajax({
        type: "POST",
        url: base_url+"rpepcppage",
        data: dataa,
        cache: false,
        success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
            	if(type=='IA'){
        			$('.steps').empty().load(base_url+'/filingaction/edit_ia_details_filing');
            	}
			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}
</script>