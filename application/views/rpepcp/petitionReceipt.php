<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepsrpepcp");
$token= $this->efiling_model->getToken();
$partytype='';
$filingno='';
$tab_no='';
$type='';

$vals=$this->session->userdata('rpepcpdetail');
if(empty($vals)){
	redirect(base_url(),'refresh');
}
if(!empty($vals) && is_array($vals)){
    $newfiling_no=$vals['filing_no'];
    $printIAno=0;
    $iaFilingNossssss=$vals['iaFilingNossssss'];
    $curYear=$vals['curYear'];
    $valfilingno='';
    if($newfiling_no!=''){
        $val= substr($newfiling_no,-8);

        $a=substr_replace($val ,"",-4);
        $b= substr($newfiling_no, -4);
        $valfilingno='Diary No. : <span class="text-danger">'.  ltrim(substr($newfiling_no, 6, 6),'0').'/'.$b.'</span>';
    }
}
?>
<div id="rightbar">
    <form action="#" id="frmCounsel" autocomplete="off">
        <div class="content" style="padding:0px;">
        <div class="row">
        <div class="card checklistSec">
            <fieldset id="iaNature" style="display:block">
                <div class="table-responsive">
                    <div><a href="void:javascript(0);" style="" class="print-btn2 btn btn-sm btn-danger" data-toggle="modal"
                            onclick="return popitup('<?php echo $newfiling_no; ?>','<?php echo $iaFilingNossssss; ?> ','<?php echo $curYear; ?>')"><b><?php echo "Reciept"; ?></b></a>
                    </div>
                    <fieldset>
                        <legend><?php echo strtoupper($type); ?> Diary Number :</legend>
                        <div class="col-md-12 text-center text-dark">
                            <h4>
                                Case is successfully registered With <?php echo strtoupper($type); ?>
                                <?php echo $valfilingno. "</br>";
                                   // echo $printIAno;
                                    ?>
                            </h4>
                        </div>
                    </fieldset>
                </div>
            </fieldset>
</div>
</div>
        </div>
    </form>
</div>


<div class="modal fade bd-example-modal-lg" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top: 190px;">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="certifiedsave.php" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div id="viewsss" class="px-3">
                </div>
            </form>
        </div>
    </div>
</div>


<?php $this->load->view("admin/footer"); ?>

<script>
function popitup(filingno, ianumbt, year) {
    var dataa = {};
    dataa['filing_no'] = filingno,
        dataa['iano'] = ianumbt,
        dataa['year'] = year,
        $.ajax({
            type: "POST",
            url: base_url + "/filingaction/iaprint_rp_cp_ep",
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