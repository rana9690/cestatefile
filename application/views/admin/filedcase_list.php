<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("globalstyle"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Angualrjs -->

<style>
    .inner-ftr {
        position: fixed;
        bottom: 0;
        right: 0;
    }
</style>

<div class="content" style="padding:0px;" ng-controller="users" data-ng-init="usersInformation()" ng-app="my_app">

    <div class="row">
        <div class="card checklistSec" style=""> 
                <h3>Filed Case List</h3>
                <table id="example" class="table trial-table2 display nowrap border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th><?=$this->lang->line('dfrno')?></th>
                            <th>Case No.</th>
                            <th>Date of Filing</th>
                            <th>Case Type</th>
                            <th>Party</th>
                            <th>Status</th>
                            <th>Filing Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                         if($filedcase->num_rows()>0){
                          $i=1;
                          foreach($filedcase->result() as $val){

                             
                             $status='';
                             if($val->status=='P'){
                                 $status='Pending';
                             }
  
                         //if ($val->case_type == '1' || $val->case_type == '4' || $val->case_type == '6') {
                                // $vasl=$this->efiling_model->data_list_where('scrutiny','filing_no',$val->filing_no);
                                 //$path=$this->efiling_model->data_list_where('document_filing','filing_no',$val->filing_no);
                                 $path1='';
                                 /*if(!empty($path)){
                                     $path1=$path[0]->doc_url;
                                 }*/
                                 $val2="Under Scrutiny";

                                     if($val->objection_status=='Y'){
                                        // $val2="<span style='color:green'>Cure Defect</span>";
                                         $val2= "<span style='color:red'><b>Defective</b></span>";
                                     }

                                 
                                 if($val->case_no!=''){
                                     $val2= "<span style='color:Green'><b>Registerd</b></span>";
                                 }
                                 //$dfr=$this->efiling_model->createdfr($val->filing_no);
                                 //$case=$this->efiling_model->createcaseno($val->filing_no);
                             ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><a
                                    href="<?php echo base_url();?>dfrdetail/<?php echo $val->filing_no; ?>"><?=displayDiaryNo($val->filing_no)?></a>
                            </td>
                            <td><?=displayAppNoTest(['caseType'=>$caseTypeShort[$val->case_type],'caseNo'=>$val->case_no])?>
                            </td>
                            <td><?php echo $val->dt_of_filing; ?></td>
                            <td><?=$caseTypeFull[$val->case_type]?></td>
                            <td><?php echo $val->pet_name.$this->efiling_model->fn_addition_party($val->filing_no,1); ?><span
                                    style="color:red"> VS
                                    <br></span><?php echo $val->res_name.$this->efiling_model->fn_addition_party($val->filing_no,2); ?>
                            </td>
                            <td><?php echo $val2; ?></td>


                            <td>
                                <a href="javascript:void(0)"
                                    onclick="return popitup('<?php echo $val->filing_no; ?>');">View Reciept</a>
                                <br>
                                <a href="javascript:void(0)"
                                    onClick="saveFeeMore('app','<?=$val->filing_no?>')">Additional Payment</a>
                                <!--a href="<?php //echo base_url(); ?>folder/<?php //echo hash('sha256',$path1).'/'.$val->filing_no; ?>" target="_blank">View-->
                            </td>
                            <?php $i++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>  
<div class="modal fade bd-example-modal-lg" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"   aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top: 190px;">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="certifiedsave.php" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="viewsss">
                </div>
            </form>
        </div>
    </div>
</div>


<?php $this->load->view("admin/additionalFeeModel"); ?>
<?php $this->load->view("admin/footer"); ?>
<?php $this->load->view("globalscript"); ?>
<script src="<?= base_url("asset/admin_js_final/additionalFeeModel.js") ;?>" type="text/javascript"></script>
<script>
function viewdetails(id) {
    var dataa = {};
    dataa['adv_id'] = id;
    $.ajax({
        type: "POST",
        url: base_url + "dfr_detail",
        data: dataa,
        cache: false,
        success: function(resp) {
            var resp = JSON.parse(resp);
            if (resp.data == 'success') {
                $('#record').html(resp.value);
            }
        },
        error: function(request, error) {
            $('#loading_modal').fadeOut(200);
        }
    });
}



$('.nav-link').click(function() {
    var content = $(this).data('value');
    if (content != '') {
        $('.steps').empty().load(base_url + '/efiling/' + content);
    }
});
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip'
        /*buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]*/
    });
});


function EditModal(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/editapplant_respondent",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailccopy").html(data);
            $("#getCodeModal").modal("show");
        }
    });
}



function additionla_party(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/edit_additonalparty",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailAPcopy").html(data);
            $("#getAPModal").modal("show");
        }
    });
}

function additionla_advocate(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/additionla_advocate",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailAAcopy").html(data);
            $("#getAAModal").modal("show");
        }
    });
}


function document_filing(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/edit_document_filing",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailDFcopy").html(data);
            $("#getDFModal").modal("show");
        }
    });
}

function ia_details_filing(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/edit_ia_details_filing",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailIAcopy").html(data);
            $("#getIAModal").modal("show");
        }
    });
}



function review_petition_filing(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/review_petition_filing",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailRPcopy").html(data);
            $("#getRPModal").modal("show");
        }
    });
}


function execution_petition_filing(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/edit_execution_petition_filing",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailEPcopy").html(data);
            $("#getEPModal").modal("show");
        }
    });
}

function contempt_petition_filing(val) {
    $.ajax({
        type: "POST",
        url: base_url + "filingaction/edit_contempt_petition_filing",
        data: "filingno=" + val,
        cache: false,
        success: function(data) {
            $("#detailCPcopy").html(data);
            $("#getCPModal").modal("show");
        }
    });
}

function popitup(filingno) {
    var dataa = {};
    dataa['filingno'] = filingno,
        $.ajax({
            type: "POST",
            url: base_url + "/filingaction/filingPrintSlip",
            data: dataa,
            cache: false,
            success: function(resp) {
                $("#getCodeModal").modal("show");
                document.getElementById("viewsss").innerHTML = resp;
            },
            error: function(request, error) {
                $('#loading_modal').fadeOut(200);
            }
        });

}
</script>