<?php
$this->load->view("admin/header");
$this->load->view("admin/sidebar");
$this->load->view("admin/stepscaveat");
$salt=$this->session->userdata('cavsalt');
$userdata=$this->session->userdata('login_success');
$userid=$userdata[0]->id;
$token= $this->efiling_model->getToken();
$iaFilingNo='';
$msg='';
$basicia=$this->session->userdata('cavedetail');
if(!empty($basicia)){
    $iaFilingNo=isset($basicia['iaFilingNo'])?$basicia['iaFilingNo']:'';
    $msg=isset($basicia['msg'])?$basicia['msg']:'';
}

?>
<div id="rightbar"> 
	<form action="#" id="frmCounsel" autocomplete="off">    
        <div class="content" style="padding-top:0px;">
    	  <div>
                <fieldset>
                     <div>
                        <a target="_blank" href="<?php echo base_url(); ?>caveat_receipt/<?php echo base64_encode($iaFilingNo); ?>"   onclick="return popitup('caveat_receipt.php?filing_no=<?php echo base64_encode($iaFilingNo); ?>')"><b><?php echo "Print Recipt "; ?></b></a>
                     </div>
                    <legend class="customlavel2"><?php echo htmlspecialchars($msg); ?></legend>
                    <label><span class="custom"><font color="#0000FF" size="5">Caveate Diary  No :--<?php echo htmlspecialchars($iaFilingNo); ?></font></span></label>
                </fieldset>
            </div>
        </div>
     </form>
</div>  
<?php $this->load->view("admin/footer"); ?>
<script>
function iasubmit() {
    var salt = document.getElementById('saltNo').value; 
    var totalNoIA = document.getElementById('totalNoIA').value; 
    var tabno= document.getElementById('tabno').value;    
    var filingno = document.getElementById('filing_no').value;
    var type = document.getElementById('type').value;  
    var totalNoIA = $("#totalNoIA").val();
    if (totalNoIA == "") {
        alert("Please Enter Total No IA");
        document.filing.totalNoIA.focus();
        return false
    }
    var iaNature = "";
    var count = 0;
    var checkboxes = document.getElementsByName('natureCode');
    var selected = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            iaNature = iaNature + checkboxes[i].value + ',';
            count++;
        }
    }
    var ia = document.getElementById("totalNoIA").value;
    var dataa = {};
    dataa['salt'] = salt;
    dataa['filing_no'] = filingno;
    dataa['type'] = type;
    dataa['iaNature']=iaNature;
    dataa['totalia']=ia;
    dataa['tabno']=tabno;
    dataa['token'] = '<?php echo $token; ?>';
     $.ajax({
         type: "POST",
         url: base_url+"/iadetailsave",
         data: dataa,
         cache: false,
         success: function (resp) {
        	var resp = JSON.parse(resp);
        	if(resp.data=='success') {
		       setTimeout(function(){
                    window.location.href = base_url+'ia_upload_doc';
               }, 250); 
			}
			else if(resp.error != '0') {
				$.alert(resp.error);
			}
         },
         error: function (request, error) {
			$('#loading_modal').fadeOut(200);
         }
     }); 
} 

function openTextBox() {
    var checkboxes = document.getElementsByName('natureCode');
    var iaNature1 = "";
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            var iaNature1 = checkboxes[i].value;
        }
    }
    if (iaNature1 == 12) {
        document.getElementById("matterId").style.display = 'block';
    }else{
    	document.getElementById("matterId").style.display = 'none';
    }
}

</script>