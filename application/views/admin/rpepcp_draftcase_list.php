<?php $this->load->view("admin/header"); ?>
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
			<h3>Draft Applications List</h3>
              	 <table id="example" class="table trial-table2 display nowrap border" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Reference No.</th>
                                <th><?=$this->lang->line('dfrno')?>.</th>
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
                         
                         if(is_array(@$filedcase)){
                         $i=1;foreach($filedcase as $val){    ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $val->salt;; ?></td>
                                <td><?=displayDiaryNo($val->filing_no)?></td>
                                <td><?php echo $val->entry_date; ?></td>
                                <td><?php echo $val->case_type; ?></td>
                                <td><?php echo $val->status; ?></td>  
                                <td><button class="dbox__action__btn btn btn-xs btn-warning" style=""><a href="rpepcpefiling/<?php echo $val->salt;?>/<?=$val->tab_no;?>" class="text-white"><i class="fa fa-edit"></i> Edit-Final</a></button></td>
                         <?php $i++;} } ?>   
                        </tbody>
                    </table>
              </div>
        </div>
	</div> 
</div>	   
<?php $this->load->view("admin/footer"); ?>                 
    <script>
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
                	if(type=='review'){
            			$('.steps').empty().load(base_url+'/filingaction/review_petition_filing');
                	}
                	if(type=='contempt'){
                		$('.steps').empty().load(base_url+'/filingaction/edit_contempt_petition_filing');
                    }
                	if(type=='execution'){
                		$('.steps').empty().load(base_url+'/filingaction/edit_execution_petition_filing');
                    }
    			}
            },
            error: function (request, error) {
				$('#loading_modal').fadeOut(200);
            }
        });
    }
    </script>
