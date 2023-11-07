<?php 
$this->load->view("admin/header"); 
$this->load->view("admin/sidebar");
$token= $this->efiling_model->getToken();
?>


<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">
        <?= form_fieldset('Add Check List (Master Check List) ').
'<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 9px 6px;"></i>';
?>
<div class="col-md-12">
            <div>
                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal">
                    Add Checklist
                </button>
</div>

            <table id="example" class="display nowrap trial-table2 border table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Check List Name</th>
                        <th>Status.</th>
                        <th>User.</th>
                        <th>Date of Entry</th>
                        <th>Action one</th>
                        <th>Action two</th>
                        <th>Action three</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                         if(is_array(@$checklist)){
                          $i=1;
                          foreach($checklist as $val){  
                              $status=$val->status;
                              $id=$val->id;
                              $userid=$val->userid;
                              $c_name=$val->c_name;
                              $short_name =$val->shortname;
                              ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><a href="<?php echo base_url();?>dfrdetail/<?php echo $val->id; ?>" data-toggle="modal"
                                data-target="#exampleModalCenter" onclick="viewdetails('<?php echo $val->id; ?>');">
                                <label
                                    title="<?php echo $short_name; ?>"><?php echo substr($short_name,0,50); ?></label>
                            </a></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $userid; ?></td>
                        <td><?php echo $val->entry_time; ?></td>
                        <td><?php echo $val->action_one; ?></td>
                        <td><?php echo $val->action_two; ?></td>
                        <td><?php echo $val->action_three; ?></td>
                        <td>
                            
                            <a href="javascript:void(0)" class="btn btn-xs btn-warning" title="Edit" onclick="deletecheck('<?php echo $id; ?>');"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger" title="Delete"
                                onclick="deletecheck('<?php echo $id; ?>');"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title" id="exampleModalLabel">Add Checklist</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Checklist Name</label>
                    <input type="text" class="form-control" id="c_name" name="c_name" placeholder="Please Enter name"
                        required>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Short Name</label>
                    <input type="text" class="form-control" id="short_name" name="short_name"
                        placeholder="Please short name" required>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput1">Action One</label>
                    <input type="text" class="form-control" id="action_one" name="action_one"
                        placeholder="Please action one" required>
                </div>


                <div class="form-group">
                    <label for="exampleFormControlSelect1">Type</label>
                    <select class="form-control" id="typecheck" name="typecheck" required>
                        <option value="apl">APL</option>
                        <option value="ia">IA</option>
                        <option value="epepcp">RPEPCP</option>
                        <option value="cav">Caveate</option>
                        <option value="cert">Certified Copy</option>
                        <option value="doc">Document</option>
                    </select>
                </div>



                <div class="form-group">
                    <label for="exampleFormControlSelect1">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="1">Active</option>
                        <option value="0">Un-Active</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitcmaster();">Save changes</button>
            </div>
        </div>
    </div>
</div>

 
<script>
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});


function submitcmaster() {
    var c_name = document.getElementById("c_name").value;
    var shortname = document.getElementById("short_name").value;
    var status = document.getElementById("status").value;
    var token = '<?php echo $token; ?>';
    var action_one = document.getElementById("action_one").value;
    var typecheck = document.getElementById("typecheck").value;
    var dataa = {};
    dataa['status'] = status,
        dataa['shortname'] = shortname,
        dataa['c_name'] = c_name,
        dataa['token'] = token,
        dataa['action_one'] = action_one,
        dataa['typecheck'] = typecheck,

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: base_url + 'addchecklist',
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



function deletecheck(e) {
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
            url: base_url + 'deletecheck',
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