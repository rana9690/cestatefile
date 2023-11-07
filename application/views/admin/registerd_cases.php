<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 <!--Angualrjs -->
<div class="content" style="padding-top:0px;margin-top: 32px;"  ng-controller="users" data-ng-init="usersInformation()" ng-app="my_app">

	<div class="row">
		<div class="card" style="width: 100%; padding: 0px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px; border-top-left-radius: 0px;">
              <div class="container">
			<h6>Filed Case List</h6>
              	 <table id="example" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>DFR.No.</th>
                                <th>Case No.</th>
                                <th>Date of Filing</th>
                                <th>Case Type</th>
                                <th>Party</th>
                                <th>Status</th>
                                <th>Document</th>           
                            </tr>
                        </thead>
                        <tbody>
                         <?php

                         if(is_array(@$regcase)){
                          $i=1;
                          foreach($regcase as $val){ 
                             $case_type_name='';
                             if ($val->case_type == '1') {
                                 $case_type_name = 'Appeal(APL)';
                             }
                             
                             $status='';
                             if($val->status=='P'){
                                 $status='Pending';
                             }
  
                             if ($val->case_type == '1') {
                                 $vasl=$this->efiling_model->data_list_where('scrutiny','filing_no',$val->filing_no);
                                 $path=$this->efiling_model->data_list_where('document_filing','filing_no',$val->filing_no);
                                 $path1='';
                                 if(!empty($path)){
                                     $path1=$path[0]->doc_url;
                                 }
                                 $val2="Under Scrutiny";
                                 if(!empty($vasl)){
                                     if($vasl[0]->defects=='Y'){
                                        // $val2="<span style='color:green'>Cure Defect</span>";
                                         $val2= "<span style='color:red'><b>Defective</b></span>";
                                     }
                                 }
                                 
                                 if($val->case_no!=''){
                                     $val2= "<span style='color:Green'><b>Registerd</b></span>";
                                 }
                                 
                                 $dfr=$this->efiling_model->createdfr($val->filing_no);
                                 $case=$this->efiling_model->createcaseno($val->filing_no);
                                 
                             ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $dfr; ?></td>
                                <td><?php echo $case; ?></td>
                                <td><?php echo $val->dt_of_filing; ?></td>
                                <td><?php echo $case_type_name; ?></td>
                                <td><?php echo $val->pet_name; ?><span style="color:red"> VS <br></span><?php echo $val->res_name; ?></td>
                                <td><?php echo $val2; ?></td> 
                                <td><a href="<?php echo base_url(); ?>folder/<?php echo hash('sha256',$path1).'/'.$val->filing_no; ?>" target="_blank">View</td>                      						
                         <?php $i++;} } } ?>   
                        </tbody>
                    </table>
              </div>
        </div>
	</div>
</div>                           
</div>	
 <?php $this->load->view("admin/footer"); ?>
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
    } );


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



    function additionla_party(val){
      	  $.ajax({
              type: "POST",
              url: base_url+"filingaction/edit_additonalparty",
              data: "filingno=" + val,
              cache: false,
              success: function (data) {
            	  $("#detailAPcopy").html(data);
            	  $("#getAPModal").modal("show");   
              }
          });
    }

    function additionla_advocate(val){
    	  $.ajax({
            type: "POST",
            url: base_url+"filingaction/additionla_advocate",
            data: "filingno=" + val,
            cache: false,
            success: function (data) {
          	  $("#detailAAcopy").html(data);
          	  $("#getAAModal").modal("show");   
            }
        });
  }
    
    
    function document_filing(val){
    	  $.ajax({
            type: "POST",
            url: base_url+"filingaction/edit_document_filing",
            data: "filingno=" + val,
            cache: false,
            success: function (data) {
          	  $("#detailDFcopy").html(data);
          	  $("#getDFModal").modal("show");   
            }
        });
     }

    function ia_details_filing(val){
  	  $.ajax({
          type: "POST",
          url: base_url+"filingaction/edit_ia_details_filing",
          data: "filingno=" + val,
          cache: false,
          success: function (data) {
        	  $("#detailIAcopy").html(data);
        	  $("#getIAModal").modal("show");   
          }
      });
   }


    
    function review_petition_filing(val){
  	  $.ajax({
          type: "POST",
          url: base_url+"filingaction/review_petition_filing",
          data: "filingno=" + val,
          cache: false,
          success: function (data) {
        	  $("#detailRPcopy").html(data);
        	  $("#getRPModal").modal("show");   
          }
      });
   }


    function execution_petition_filing(val){
    	  $.ajax({
            type: "POST",
            url: base_url+"filingaction/edit_execution_petition_filing",
            data: "filingno=" + val,
            cache: false,
            success: function (data) {
          	  $("#detailEPcopy").html(data);
          	  $("#getEPModal").modal("show");   
            }
        });
     }

    function contempt_petition_filing(val){
  	  $.ajax({
          type: "POST",
          url: base_url+"filingaction/edit_contempt_petition_filing",
          data: "filingno=" + val,
          cache: false,
          success: function (data) {
        	  $("#detailCPcopy").html(data);
        	  $("#getCPModal").modal("show");   
          }
      });
   }
    </script>