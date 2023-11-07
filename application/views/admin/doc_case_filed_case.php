<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');  
if($this->input->post()) {
    $year=$this->input->post('year');
}else{
    $year=date('Y');
}
?>
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
                                <th>MF No.</th>
                                <th>Case No.</th>
                                <th>Document Name.</th>
                                <th>Filed By.</th>
                                <th>Filing Date.</th>
                                <th>Matter</th>
                                <th>View Reciept</th>
                                <th>Hard Copy Submit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                                                $i=1;
                                                                foreach($ma as $maval){
                                                                    $doc=$maval->doc;
                                                                    $hscquery =  $this->efiling_model->data_list_where('master_document','did',$doc);
                                                                    $natureName = $hscquery[0]->d_name;
                                                                    $doc_type =$maval->doc_type;
                                                                    $date = DateTime::createFromFormat("Y-m-d", $maval->dt_of_filing);
                                                                    $year= $date->format("Y");
                                                                    $filing_no= $maval->filing_no;
                                                                    if($filing_no!=''){
                                                                        $filing_No = substr($filing_no, 5, 6);
                                                                        $filing_No = ltrim($filing_No, 0);
                                                                        $filingYear = substr($filing_no, 11, 4);
                                                                        $val= "DFR/$filing_No/$filingYear";
                                                                    }
                                                                    $addparty=$maval->additional_party;
                                                                    $main_party=$maval->main_party;
                                                                    $ptype=2;
                                                                    if($main_party=='P'){
                                                                        $ptype=1;
                                                                    }
                                                                    $mainparty='';
                                                                    $partyid = explode(",", $addparty);
                                                                    $pid = rtrim($addparty, ',');
                                                                    $len = sizeof($partyid);
                                                                    for ($k = 0; $k < $len; $k++) {
                                                                        if ($partyid[$k] == 1) {
                                                                            $sql = $this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
                                                                            foreach ($sql as $row) {
                                                                                $flass_type = 'A-';
                                                                                if ($ptype == 2) {
                                                                                    $flass_type = 'R-';
                                                                                }
                                                                                if ($ptype == 2) {
                                                                                    $mainparty = $row->res_name.'('.$flass_type.'1)';
                                                                                }
                                                                                if ($ptype == 1) {
                                                                                    $mainparty = $row->pet_name.'('.$flass_type.'1)';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    
                                                                    if($addparty!='TP'){
                                                                        $sqladd1 = $this->db->query("select * from additional_party where  party_id IN($pid) order by partysrno");
                                                                        $sql_party11 = $sqladd1->result();
                                                                        $pet_name11 = '';
                                                                        foreach ($sql_party11 as $row) {
                                                                            $id = $row->party_id;
                                                                            $flass_type = 'A-';
                                                                            if ($ptype == 2) {
                                                                                $flass_type = 'R-';
                                                                            }
                                                                            $pet_name11 .= $row->pet_name.'('.$flass_type.$row->partysrno.'), ';
                                                                        }
                                                                    }
                                                                    
                                                                    
                                                                ?>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><a
                                        href="<?php echo base_url(); ?>docdetail/<?php echo $maval->ma_id; ?>"><?php echo $maval->ma_filing_no; ?>/<?php echo $year; ?></a>
                                </td>
                                <td><?php echo $val; ?></td>
                                <td><?php echo $natureName; ?></td>
                                <td><?php if($mainparty !='') { $mainparty = $mainparty.','; } echo $mainparty.$pet_name11; ?>
                                </td>
                                <td><?php echo date('d/m/Y',strtotime($maval->dt_of_filing)); ?></td>
                                <td><?php echo $maval->matter; ?></td>
                                <td><a target="_blank"
                                        href="maprint/<?php echo $maval->filing_no; ?>/<?php echo $maval->ma_filing_no; ?>/<?php echo $doc_type; ?>">View
                                        Receipt</a></td>
                                <td>Yes/No</td>
                            </tr>
                            <?php $i++; } ?>
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
$.(document).ready(function() {
    $('#ia_list_table').DataTable();
});
</script>