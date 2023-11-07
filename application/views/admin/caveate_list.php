<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
        
        if($this->input->post()) {
                $year=$this->input->post('year');
        }else   $year=date('Y');
?>

<div class="content" style="padding-top:12px;">
	<div class="row">
		<div class="card" style="width: 100%; padding: 12px 12px;border-top: 0px;margin-top: 0px; border-top-right-radius: 0px;border-top-left-radius: 0px;">
            <?php 
                echo form_fieldset('<small class="fa fa-list"></small>&nbsp;&nbsp;CAVEAT LIST','caveate_list').
                        '
                        <div class="table-bordered" style="margin-bottom:15px;padding: 12px;">
                            <div class="col-md-12 h2 text-danger"><i class="fa fa-filter"></i>&nbsp;Select Year :';

                                $year_array=[''=>'-----Select year-----'];
                                $current_year=date('Y');
                                for($i=$current_year; $i >= ($current_year-10); $i--)
                                    $year_array[$i]=$i;
                                echo form_dropdown('year',$year_array,'',['class'=>'form-control text-success','style'=>'margin-left:15px; display: inline-block;width: 200px;']).
                                    form_button(['content'=>'&nbsp;','value'=>'false','class'=>'fa fa-search btn btn-warning btn-lg','onClick'=>'javascript: search_ia(this);']).

                            ''?></div>
                        </div>

                         <div class="table-responsive">
                <table datatable="ng" id="examples" class="table table-striped table-bordered" cellspacing="0"  width="100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Caveat No</th>
                            <th>Caveat Year</th>
                            <th>Caveat Name</th>
                            <th>Caveatee Name</th>
                            <th>Case No</th>
                            <th>Case Year</th>
                            <th>Decision Date</th>
                            <th>Caveate Date</th>                                 
                            <th>Commission Nname</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php 
                      $i=1;
                      
                     foreach($caveate as $cav){ 
                         $caveat_name=$cav->caveat_name;
                         if($cav->caveat_name!='' && is_numeric($cav->caveat_name)){
                             $caname= $this->efiling_model->data_list_where('master_org','org_id',$cav->caveat_name);
                             $caveat_name=$caname[0]->org_name;
                         }
                         $caveatee_name=$cav->caveatee_name;
                         if($cav->caveatee_name!='' && is_numeric($cav->caveatee_name)){
                             $cavd= $this->efiling_model->data_list_where('master_org','org_id',$cav->caveatee_name);
                             $caveatee_name=$cavd[0]->org_name;
                         }
                         $commission_name=$cav->commission;
                         if($cav->commission!='' && is_numeric($cav->commission)){
                             $comm= $this->efiling_model->data_list_where('master_commission','id',$cav->commission);
                             $commission_name=$comm[0]->full_name;
                         }
                         ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><a href="<?php echo base_url(); ?>caveatedetail/<?php echo $cav->caveat_filing_no; ?>"><?php echo substr($cav->caveat_filing_no,7,4); ?></a></td>
                            <td> <?php echo substr($cav->caveat_filing_no,11,4); ?></td>
                            <td><?php echo $caveat_name; ?> </td>
                            <td><?php echo $caveatee_name; ?> </td>
                            <td><?php echo $cav->case_no; ?> </td>
                            <td><?php echo $cav->case_year; ?> </td>
                            <td><?php echo date('d/m/Y',strtotime($cav->decision_date)); ?> </td>
                            <td><?php echo date('d/m/Y',strtotime($cav->caveat_filing_date)); ?> </td>
                            <td><?php echo $commission_name; ?> </td>
                            <td> <a target="_blank" href="caveat_receipt/<?php echo base64_encode($cav->caveat_filing_no); ?>"><b><?php echo "Print Recipt "; ?></b></a>
                            </td>
                        </tr>
                        <?php $i++;} ?>
                    </tbody>
                </table>
            </div>
    
        </div>
	</div>
</div>
 <?php $this->load->view("admin/footer"); ?>
<script type="text/javascript">
function search_ia(id) {
event.preventDefault();
var selected_year=$('select[name=year]').val(), page_url='';
    page_url=base_url+'loadpage/ia_list';
	$.ajax({
		type: 'post',
		url: page_url,
		dataType: 'html',
		data: {'year': selected_year},
		cache: false,
		beforeSend: function(){				
			$(id).attr('disabled',true);
		},
		success: function(ia_data){
			$('#rightbar').empty().html(ia_data);
			$('#ia_list_table').DataTable();
		},
		error: function(){
			$.alert('Server busy,try later.');
		},
		complete: function(){				
			$(id).removeAttr('disabled');
		}
});
}


    $.(document).ready(function(){
        $('#ia_list_table').DataTable();
    });
</script>