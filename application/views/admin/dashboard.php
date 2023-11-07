<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
	if(!$this->session->userdata('login_success')) {	  	
		$this->session->sess_destroy();            	
    	return redirect(base_url(), 'refresh');
    	exit();
	  } 
?>
	
<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>

<div class="steps">		
</div>
<script>
function logout(){
		$.ajax({
	        type: "POST",
	        url: base_url+'efiling/logout',
	        data: '',
	        cache: false,
	        success: function (resp) {
	        	var resp = JSON.parse(resp);
	        	if(resp.data=='success') {
	        	 	location.reload(true);
				}
	        },
	        error: function (request, error) {
				$('#loading_modal').fadeOut(200);
	        }
	    });
}
</script>