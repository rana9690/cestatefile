<?php

$this->load->view("admin/header");
$this->load->view("admin/sidebar");
defined('BASEPATH') OR exit('No direct script access allowed');
$token= $this->efiling_model->getToken();
?>
 <!--Angualrjs -->
<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">
			   <h3>Defective Cases  List </h3>
              	 <table id="example" class="table trial-table2 display nowrap border" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr. No</th>
                                <th><?=$this->lang->line('dfrno')?>.</th>
                                <th>Date of Filing</th>
                                <th>Case Type</th>
                                <th>Case Title</th>
                                <th>Status</th>
                                <th>Date of Upload</th>
                                <th style="width: 68px;">Due Date</th>
                                <!--th>View Latter</th-->
                                <th>Pending Defects</th>
                                <th>Re-file</th>         
                            </tr>
                        </thead>
                        <tbody>
                         <?php

                         if(is_array(@$defect)){
                          $i=1;
                          foreach($defect as $val){
                                 $case_type_name='';
                                 if ($val->case_type == '1') {
                                     $case_type_name = 'Appeal(APL)';
                                 }
                                 $status='';
                                 if($val->status=='P'){
                                     $status='Pending';
                                 }
                                 $vasl=$this->efiling_model->data_list_where('scrutiny','filing_no',$val->filing_no);
                                 $val2="Under Scrutiny";
                                 if(!empty($vasl)){
                                     if($vasl[0]->objection_status=='Y'){
                                         $val2= "<span style='color:red'><b>Defective</b></span>";
                                     }
                                 }
                                 
                                 if($val->case_no!=''){
                                     $val2= "<span style='color:Green'><b>Registerd</b></span>";
                                 }
                                 $dfr=$this->efiling_model->createdfr($val->filing_no);
                                 $case=$this->efiling_model->createcaseno($val->filing_no);

                                 if($vasl[0]->objection_status=='Y'){
                                     $duwdateval='-';
                                     $links='-----';
                                     $uploaddate='-';
                                     $disablesbtn='disabled';
                                     $st2 = $this->efiling_model->data_list_where('aptel_uploadeddefectlatter','filing_no',$val->filing_no);

                                     if(!empty($st2) && is_array($st2)){
                                         $date1= date('d-m-Y',strtotime($val->notification_date));
                                         $date2 = strtotime($date1);
                                         $duedateaa = strtotime("+3 week", $date2);
                                         $duwdateval= date('d-m-Y', $duedateaa);
                                         $uploaddate= date('d-m-Y',strtotime($val->notification_date));
                                         $valcccc='<i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i>';
                                         $vasl1=$this->efiling_model->data_list_where('aptel_uploadeddefectlatter','filing_no',$val->filing_no);

                                         $file_name=  $vasl1[0]->file_name;
                                         $docid= $vasl1[0]->id;
                                          $links='<a  href="javascript:void(0)" onclick="pdfviewdfect('.$docid.');">'.$valcccc.'</a>';

                                      /* if (!(file_exists($file_name))){
                                             $links='<a target="_blank" href="http://164.100.59.182/E_cis/../'.$file_name.'">'. $valcccc.'ee</a>';
                                         }else{
                                             $links='<a target="_blank" href="order_view/'.base64_encode($file_name).'">'.$valcccc.'aaa</a>';
                                         }*/
										 if($file_name==''){
											 $links='<a target="_blank" href="'.CISURL.'defect-notice/'.$val->filing_no.'">Defect Notice</a>';
										 }
                                         $disablesbtn='';
                                     }

                                   //  if($val->flag=='1'){
                                         //$disablesbtn='disabled';
                                    // }
                                     //if($val->flag=='2'){
                                         $disablesbtn='';
                                   //  }

                                     
                                     $label="View Re-defect";
					
                                     if($val->flag=='0' ||  $val->flag=='1'){
                                         $disablesbtn1='disabled-link';
                                         $label="---";
                                     }
                                     
                                     
                                     //if($val->flag!='3'){
                                     ?>
                      
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $dfr; ?></td>
                                <td><?php echo date('d-m-Y',strtotime($val->dt_of_filing)); ?></td>
                                <td><?php echo $case_type_name; ?></td>
                                <td><?php echo $val->pet_name; ?> <?php echo $this->efiling_model->fn_addition_party($val->filing_no,'1');?><span style="color:red"> VS <br></span><?php echo $val->res_name; ?> <?php echo $this->efiling_model->fn_addition_party($val->filing_no,'2');?></td>
                                <td><?php echo $val2; ?></td> 
                                <td><?php echo $uploaddate; ?></td> 
                                <td><span style="color:red"><?php echo $duwdateval; ?></span></td> 
                                <!--td><?php //echo $links;  ?></td--> 
								<?php /*?>
                                <td><a href="<?php echo base_url(); ?>pendingdefect/<?php echo $val->filing_no; ?>" 
                                 class="<?php echo $disablesbtn1; ?>"><?php echo $label; ?></td> 
								 <?php */?>
                                 <td><a href="<?php echo base_url(); ?>pendingdefect/<?php echo $val->filing_no; ?>" >Defects</td>
                                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" onclick="checkConIa('<?php echo $val->filing_no; ?>')" 
                                <?php echo $disablesbtn; ?>>Re-File</button></td> 
                         	</tr>
                         <?php $i++;  //}  
                                 }
                            } 
                         } ?>  
                        </tbody>
                    </table>
              </div>
        </div>
	</div> 
	
	
	<!-- Display Uploaded file PDF -->
<div class="modal fade" id="updPdf" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="frame">                   
                <iframe style="width: 100%; height: 560px" id="frameID" src=""></iframe>
            </div>
        </div>
    </div>
</div>


	<style>
.disabled-link {
  pointer-events: none;
}
</style>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document" style="margin-top: 190px;">
    <div class="modal-content">
      <div class="modal-header bg-warning" style="text-align: center;">
        <h5 class="modal-title "  id="exampleModalLabel">Confirm</h5>
        <input type="hidden" id="btnval" name="btnval" value="">
        <input type="hidden" id="filing_noval" name="filing_noval" value="">
        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-primary" role="alert" >
        	<p id="massage"></p>
        </div>
      </div>
      <div class="modal-footer" id='btnsuc'>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="btncon" onclick="redirectpage();">Yes</button>
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
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );


function pdfviewdfect(val){
    var docid = val;
    var token=Math.random().toString(36).slice(2); 
    var token_hash=HASH(token+'docidval');
    var data = {};
    data['token'] = token;
    data['docid'] = docid;
    $.ajax({
    	type: "POST",
        url: base_url+'defectshowpdf/'+token_hash,
        data: data,
        cache: false,
        success: function(resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
 				href=resp.value;   
                $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
			}else if(resp.error == '1') {
				$.alert(resp.display);
			}
        },
     });
      $('#updPdf').modal('show');
}


function  checkConIa(val){
    var filing_no = val;
    $('#filing_noval').val(val);
    var token=Math.random().toString(36).slice(2); 
    var token_hash=HASH(token+'iaval');
    var data = {};
    data['token'] = token;
    data['filing_no'] = filing_no;
    $.ajax({
    	type: "POST",
        url: base_url+'checkConIa/'+token_hash,
        data: data,
        cache: false,
        success: function(resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
        		$('#btnval').val(resp.btnval)
 				$('#massage').html(resp.display)
				$('#btnsuc').html('<input type="hidden" value="'+filing_no+'" id="fiil"><button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>'+
        '<button type="button" class="btn btn-primary" id="btncon" onclick="redirectpage();">Yes</button>');
				
				
			}else if(resp.error == '1') {
				$.alert(resp.display);
			}
        },
     });
}


function redirectpage(){
	var btnva= $('#btnval').val();
	if(btnva==0){
    	 setTimeout(function(){
            window.location.href = base_url+'edit_basic_detail/'+$('#fiil').val();
         }, 250);   
	}
	
	if(btnva==1){
		setTimeout(function(){
            window.location.href = base_url+'doc_basic_detail';
        }, 250);   
	}
}



</script>
