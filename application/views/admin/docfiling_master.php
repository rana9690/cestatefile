<?php 
$this->load->view("admin/header"); 
$this->load->view("admin/sidebar");
$token= $this->efiling_model->getToken();
?>


<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style=""> 
<?= form_fieldset('Master Document').
'<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>'.
'   ';
?>

        <div class="col-md-12">
                <div>
                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal">
                        Add Master Document
                    </button>
</div>
                <table id="example" class="display nowrap trial-table2 border table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Doc Type</th>
                            <th>Doc Name</th>
                            <th>Delay Day.</th>
                            <th>Status.</th>
                            <th>Display.</th>
                            <th>Date of Entry</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         if(is_array(@$mdocs)){
                          $i=1;
                          foreach($mdocs as $val){  
                              $status=$val->status;
                              $statusval='Active';
                              if($status=='0'){
                                  $statusval='Un Active';
                              }
                              
                              $displaystatus=$val->display;
                              $display='Yes';
                              if($displaystatus==0){
                                  $display='No';
                              }
                              
                              $did=$val->did;
                              $userid=$val->userid;
                              $docname=$val->d_name;
                              $doctype=$val->pay;
                              ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $doctype; ?></td>
                            <td><a href="<?php echo base_url();?>docdetail/<?php echo $val->did; ?>" data-toggle="modal"
                                    data-target="#exampleModalCenter"
                                    onclick="viewdetails('<?php echo $val->did; ?>');">
                                    <label title="<?php echo $docname; ?>"><?php echo $docname; ?></label>
                                </a>
                            </td>
                            <td><?php echo $val->delay_day; ?></td>
                            <td><?php echo $statusval; ?></td>
                            <td><?php echo $display; ?></td>
                            <td><?php echo $val->entry_date; ?></td>
                            <td>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal" class="btn btn-xs btn-warning" title="Edit"
                                    onclick="editdocval('<?php echo $did; ?>');"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" class="btn btn-xs btn-danger" title="Delete"
                                    onclick="deletecheckdocfiling('<?php echo $did; ?>');"><i class="fa fa-trash"></i></a>
                                
                            </td>
                        </tr>
                        <?php $i++; } 
                         } ?>
                    </tbody>
                </table>
            </div>
            
<?= form_fieldset_close(); ?>
        </div>
    </div>
</div>









<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top:190px;">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title" id="exampleModalLabel">Add Document</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="docid" id="docid" value="">
                <input type="hidden" name="action" id="action" value="add">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Document Name</label>
                    <input type="text" class="form-control" id="d_name" name="d_name" placeholder="Please Enter name"
                        required>
                </div>


                <!--<div class="form-group">
            <label for="exampleFormControlInput1">Document Fee</label>
            <input type="text" class="form-control" id="d_fee" name="d_fee" placeholder="Please Enter Fee"  onkeypress="return validateNumber(event)" required >
          </div>--->


                <div class="form-group">
                    <label for="exampleFormControlInput1">Delay Day</label>
                    <input type="text" class="form-control" id="d_day" name="d_day" placeholder="Please Enter Day"
                        onkeypress="return validateNumber(event)" required>
                </div>


                <div class="form-group">
                    <label for="exampleFormControlSelect1">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="1">Active</option>
                        <option value="0">Un-Active</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Document Type</label>
                    <select class="form-control" id="d_type" name="d_type" required>
                        <option value="IA">IA</option>
                        <option value="ma">MA</option>
                        <option value="va">VA</option>
                        <option value="oth">Other</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="exampleFormControlSelect1">Display</label>
                    <select class="form-control" id="display" name="display" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitcmaster();" id="submitval">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>

 
<script>
function validateNumber(e) {
    const pattern = /^[0-9]$/;
    return pattern.test(e.key)
}

$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});


function submitcmaster() {
    var d_name = document.getElementById("d_name").value;
    var status = document.getElementById("status").value;
    var d_type = document.getElementById("d_type").value;
    //  var d_fee = document.getElementById("d_fee").value;
    var d_day = document.getElementById("d_day").value;
    var display = document.getElementById("display").value;
    var docid = '';
    var action = document.getElementById("action").value;
    if (action == 'edit') {
        var docid = document.getElementById("docid").value;
    }
    var token = '<?php echo $token; ?>';
    var dataa = {};
    dataa['status'] = status,
        dataa['d_name'] = d_name,
        dataa['d_type'] = d_type,
        //    dataa['d_fee']=d_fee,
        dataa['d_day'] = d_day,
        dataa['token'] = token,
        dataa['action'] = action,
        dataa['docid'] = docid,
        dataa['display'] = display,

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: base_url + 'adddocfilingmaster',
            data: dataa,
            cache: false,
            beforeSend: function() {
                //$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
            },
            success: function(resp) {
                if (resp.data == 'success') {
                    $.alert({
                        title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Congrates</b>',
                        content: '<p class="text-success">Check list added successfully.</p>',
                        animationSpeed: 2000
                    });
                    setTimeout(function() {
                        location.reload()
                    }, 3000);
                } else if (resp.error != '0') {
                    $.alert(resp.massage);
                }
            },
            error: function() {
                $.alert("Surver busy,try later.");
            },
            complete: function() {}
        });
}



function editdocval(e) {
    var token = '<?php echo $token; ?>';
    var x = confirm("Are you sure you want to varified?");
    var dataa = {};
    dataa['id'] = e,
        dataa['token'] = token
    if (x) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: base_url + 'edit_docs',
            data: dataa,
            cache: false,
            beforeSend: function() {
                // $('#submitval').prop('disabled',true).val("Under proccess....");
            },
            success: function(resp) {
                if (resp.data == 'success') {
                    var id = resp.value[0].did;
                    document.getElementById("docid").value = id;
                    document.getElementById("action").value = 'edit';
                    document.getElementById("d_name").value = resp.value[0].d_name;
                    document.getElementById("status").value = resp.value[0].status;
                    document.getElementById("d_type").value = resp.value[0].pay;
                    //    document.getElementById("d_fee").value=resp.value[0].fee;
                    document.getElementById("d_day").value = resp.value[0].delay_day;
                    document.getElementById("display").value = resp.value[0].display;
                } else if (resp.error != '0') {
                    $.alert(resp.massage);
                }
            },
            error: function() {
                $.alert("Surver busy,try later.");
            },
            complete: function() {}
        });
    }
}


function deletecheckdocfiling(e) {
    var token = '<?php echo $token; ?>';
    var x = confirm("Are you sure you want to varified?");
    var dataa = {};
    dataa['id'] = e,
        dataa['token'] = token
    if (x) {
        $.ajax({
            dataType: 'json',
            dataType: 'json',
            type: "POST",
            url: base_url + 'deletedocfilingmaster',
            data: dataa,
            cache: false,
            beforeSend: function() {
                //$('#feedetailsubmit').prop('disabled',true).val("Under proccess....");
            },
            success: function(resp) {
                if (resp.data == 'success') {
                    $.alert({
                        title: '<i class="fa fa-check-circle text-success"></i>&nbsp;</b>Congrates</b>',
                        content: '<p class="text-success">Check list deleted successfully.</p>',
                        animationSpeed: 2000
                    });
                    setTimeout(function() {
                        location.reload()
                    }, 3000);
                } else if (resp.error != '0') {
                    $.alert(resp.massage);
                }
            },
            error: function() {
                $.alert("Surver busy,try later.");
            },
            complete: function() {}
        });
    }
}
</script>
<?php $this->load->view("admin/footer"); ?>