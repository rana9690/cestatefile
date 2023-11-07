<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<div class="content" style="padding:0px;">
    <div class="row">
        <div class="card checklistSec" style="">
            <?php 
                echo form_fieldset('Document Detail','ia_list'); ?>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="ia_list_table" style="width: 100%;">
                        <thead>
                            <tr class="bg-dark">
                                <th>Sr. No</th>
                                <th>Document Filing No.</th>
                                <th>Case No.</th>
                                <th>Document Name.</th>
                                <th>Filed By.</th>
                                <th>No. of Pages</th>
                                <th>Filing Date.</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        if($result->num_rows()>0){
                            $i=1;
                            foreach($result->result_array() as $row){
                                $filepath=$user_id.'@'.$row['file_url'];
                                $filepathencrypt = $this->encryption->encrypt($filepath);

                             ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?=$row['ref_filing_no']?></td>
                                <td><?=$row['caseno']?></td>
                                <td><?=$row['document_type']?></td>
                                <td><?=$row['document_filed_by']?></td>
                                <td><?=$row['no_of_pages']?></td>
                                <td><?=$row['update_on']?></td>
                                <td><a href="<?=base_url('openfiles')?>" class="pageredirect" data-id="<?=$filepathencrypt?>">View</a>
                                </td>

                            </tr>
                            <?php $i++; }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php  echo form_fieldset_close(); ?>
        </div>
    </div>
</div>
<?php $this->load->view("admin/footer"); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#ia_list_table').DataTable();
});
$(document).on('click', '.pageredirect', function (e) {
    e.preventDefault();
    //$.post(this.href, { filing_no: $(this).attr('data-id'),_CSRF_NAME_: "2pm" } );

    $.redirect(this.href,
        {
            filepath:$(this).attr('data-id'),
            csrf_token: $('meta[name=csrf_token]').attr('content'),

        },
        "POST",'_blank',null,true);

});
</script>