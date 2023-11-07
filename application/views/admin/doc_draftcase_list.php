<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 <!--Angualrjs -->
<div class="content" style="padding:0px;"  ng-controller="users" data-ng-init="usersInformation()" ng-app="my_app">
	<div class="row">
		<div class="card checklistSec" style="">
               
			<h3> Draft documents List</h3>
                	 <table id="example" class="table trial-table2 display nowrap border" style="width:100%">
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
                         $this->session->unset_userdata('reffrenceno');
                         $this->session->unset_userdata('type');
                         $i=1;foreach($filedcase as $val){    ?>
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
        			$('.steps').empty().load(base_url+'/filingaction/edit_document_filing');
            	}
			}
        },
        error: function (request, error) {
			$('#loading_modal').fadeOut(200);
        }
    });
}
</script>