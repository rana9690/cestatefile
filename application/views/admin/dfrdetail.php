<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); ?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');
$userdata=$this->session->userdata('login_success');
$user_id=$userdata[0]->id;
$userrole=$userdata[0]->role;
?>
<style>
	.card {
		margin-bottom: initial;
	}
	#accordion .card .card-header{
		background-color: #778899;
		color: white;
		padding: initial;
	}
	.card-body {
		padding: 0.25rem;
	}

	.responstable {
		margin: 0.5em 0;
		width: 100%;
		overflow: hidden;
		background: #FFF;
		color: #024457;
		border-radius: 10px;
		border: 1px solid #31708f;
	}

	.responstable tr {
		border: 1px solid #D9E4E6;
	}

	.responstable tr:nth-child(odd) {
		background-color: #EAF3F3;
	}

	.responstable th {
		display: none;
		border: 1px solid #FFF;
		background-color: #31708f;
		color: #FFF;
		padding: 0.5em;
	}

	.responstable th:first-child {
		display: table-cell;
		text-align: center;
	}

	.responstable th:nth-child(2) {
		display: table-cell;
	}

	.responstable th:nth-child(2) span {
		display: none;
	}

	.responstable th:nth-child(2):after {
		content: attr(data-th);
	}

	@media ( min-width : 480px) {
		.responstable th:nth-child(2) span {
			display: block;
		}
		.responstable th:nth-child(2):after {
			display: none;
		}
	}

	.responstable td {
		display: block;
		word-wrap: break-word;
		max-width: 7em;
	}

	.responstable td:first-child {
		display: table-cell;
		text-align: left;
		border-right: 1px solid #D9E4E6;
	}

	@media ( min-width : 480px) {
		.responstable td {
			border: 1px solid #D9E4E6;
		}
	}

	.responstable th, .responstable td {
		margin: .5em 1em;
	}

	@media ( min-width : 480px) {
		.responstable th, .responstable td {
			display: table-cell;
			padding: 0.3em;
		}
	}

	.error {
		color: red;
		display: none;
	}

	.radio2 {
		position: relative;
		right: -20px;
		cursor: pointer;
	}

	.radio1 {
		cursor: pointer;
	}

	.activ {
		background: #281A1A;
	}

	.btnTbl {
		width: 100%;
	}

	.btnTbl td {
		text-align: center;
	}




</style>
<script>
	/*function openWindowWithPostRequest(winURL,params) {
		var winName='DMS VIES';
		var h=600;
		var w=800;
		var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;


		var windowoption='resizable=yes,height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',location=0,menubar=0,scrollbars=1';
		//var params = { 'param1' : '1','param2' :'2'};
		var form = document.createElement("form");
		form.setAttribute("method", "post");
		form.setAttribute("action", winURL);
		form.setAttribute("target",winName);
		for (var i in params) {
			if (params.hasOwnProperty(i)) {
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = i;
				input.value = params[i];
				form.appendChild(input);
			}
		}
		document.body.appendChild(form);
		window.open('', winName,windowoption);
		form.target = winName;
		form.submit();
		document.body.removeChild(form);
	}*/
</script>





<?php
$filing_no='';
if(!empty($filedcase)){
	foreach($filedcase as $rowd){
		$casetype=$rowd->case_type;
		$filing_no=$rowd->filing_no;
		$petName=$rowd->pet_name.$this->efiling_model->fn_addition_party($filing_no,'1');
		$resName=$rowd->res_name.$this->efiling_model->fn_addition_party($filing_no,'2');
		$case_type_detail =$this->efiling_model->data_list_where('master_case_type','case_type_code',$casetype);
		$case_type_name='';
		if($case_type_detail!=''){
			$case_type_name= isset($case_type_detail[0]->short_name)?$case_type_detail[0]->short_name:'';
		}

		$bcode =$rowd->bench;
		$ben =$this->efiling_model->data_list_where('master_benches','bench_code',$bcode);
		$bench_name =isset($ben[0]->name)?$ben[0]->name:'';

		$bcode =$rowd->bench;
		//$hscquery11 =$this->efiling_model->data_list_where('master_psstatus','state_code',$sub_ben);
		$sub_name = isset($hscquery11[0]->state_name)?$hscquery11[0]->state_name:'';



		$pet_sub_section =$rowd->pet_sub_section;
		$subsec =$this->efiling_model->data_list_where('master_under_section','section_code',$pet_sub_section);
		$subsec = isset($subsec[0]->section_name)?$subsec[0]->section_name:'';



		$act = $rowd->pet_section;
		$hscqueryact11 =$this->efiling_model->data_list_where('master_energy_act','act_code',$act);
		$act = isset($hscqueryact11[0]->act_short_name)?$hscqueryact11[0]->act_short_name:'';

	}
}?>
<div class="content">
<div id="accordion">
	<div class="card">
		<div class="card-header" id="headingOne">
			<h5 class="mb-0 text-center">
				<a  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					CASE PREVIEW
				</a>
			</h5>
		</div>

		<div id="collapseOne" class="collapse " aria-labelledby="headingOne" >
			<div class="card-body">
				<table class="responstable" width="100%" cellpadding="0"	cellspacing="0" align="center" border="1px">
					<tbody>

					<tr>
						<td><strong>Location</strong></td>
						<td><?php echo $bench_name; ?></td>
						<td><strong>Case Type</strong></td>
						<td colspan="2"><?php echo $case_type_name; ?></td>
					</tr>
					<tr>
						<td><strong>Case Title</strong></td>
						<td><?php echo $petName ?> Vs. <?php echo $resName ?></td>
					</tr>
					<tr>
					</tr>

					<tr style="text-align: center; background: #024457;">
						<th colspan="5">
							<p style="text-align: center;">Act & Sections</p>
						</th>
					</tr>
					<tr>
						<td align="left" colspan="1"><?php echo $act; ?></td>
						<td align="left" colspan="2"><strong><?php echo $subsec; ?></strong></td>
						<td align="left" colspan="2"><strong>1&2</strong></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header" id="headingTwo">
			<h5 class="mb-0">
				<a  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					Impugned Order	Details
				</a>
			</h5>
		</div>
		<div id="collapseTwo" class="collapse " aria-labelledby="headingTwo"> <!--data-parent="#accordion"-->
			<div class="card-body">
				<table class="responstable" width="100%" cellpadding="0"	cellspacing="0" align="center" border="1px">

					<tr style="text-align: center; background: #024457;">
						<th>Sr.No</th>
						<th>Commission</th>
						<th>Impugn No.</th>
						<th>Decision Date</th>
						<th>Communicaion Date</th>
					</tr>
					<?php $comm =$this->efiling_model->data_list_where('case_detail_impugned','filing_no',$filing_no);

					if(!empty($comm)){
						$i=1;
						foreach($comm as $comval){
							$commid =$comval->iss_org;

							?>
							<tr style="text-align: center;"	>
								<td  width="30px"><?php echo $i; ?></td>
								<td  width="300px"><strong><?php echo $commisions[$comval->iss_org]; ?></strong></td>
								<td  width="50px"><strong><?=$comval->impugn_no?></strong></td>
								<td  width="50px"><strong><?php echo date('d/m/Y',strtotime($comval->impugn_date)); ?></strong></td>
								<td  width="50px"><strong><?php echo date('d/m/Y',strtotime($comval->comm_date)); ?></strong></td>
							</tr>
							<?php $i++;  }
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header" id="headingThree">
			<h5 class="mb-0">
				<a  data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
					APPELLANT'S LIST
				</a>
			</h5>
		</div>
		<div id="collapseThree" class="collapse " aria-labelledby="headingThree">
			<div class="card-body">
				<table id="table" class="responstable" width="100%" cellpadding="0"	cellspacing="0" border="1px">
					<thead>
					<tr>
						<th class="footable-filtering footable-sortable"	data-breakpoints="xs" data-sort-initial="descending">S. No.</th>
						<th class="footable-filtering footable-sortable">Applellant name</th>
						<th data-breakpoints="xs">Applellant address</th>
						<th data-breakpoints="xs sm">State</th>
						<th data-breakpoints="xs sm md">District</th>
						<th data-breakpoints="xs sm md">Pincode</th>
						<th data-breakpoints="xs sm md">Mobile Number</th>
						<th data-breakpoints="xs sm md">E-mail Id</th>
					</tr>
					</thead>
					<tbody>

					<?php $cdv=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
					if(!empty($cdv)){
						$i=1;
						$statename='';
						$ddistrictname='';
						foreach($cdv as $cdvr){
							if($cdvr->pet_state!=''){
								$st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$cdvr->pet_state);
								$statename= $st2[0]->state_name;
							}
							if($cdvr->pet_district!=''){
								$st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$cdvr->pet_district);
								$ddistrictname= $st1[0]->district_name;
							}
							?>

							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $cdvr->pet_name;?></td>
								<td><?php echo $cdvr->pet_address; ?></td>
								<td><?php echo $statename; ?></td>
								<td><?php echo $ddistrictname;?> </td>
								<td><?php echo $cdvr->pet_pin;?></td>
								<td><?php echo $cdvr->pet_mobile;?></td>
								<td><?php echo $cdvr->pet_email;?></td>
							</tr>
						<?php  }
					}else{ echo "Record not found!";}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="card">
		<div class="card-header" id="headingFour">
			<h5 class="mb-0">
				<a  data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
					RESPONDENT'S	LIST
				</a>
			</h5>
		</div>
		<div id="collapseFour" class="collapse " aria-labelledby="headingFour">
			<div class="card-body">
				<table id="table" class="responstable" width="100%" cellpadding="0" cellspacing="0" border="1px">
					<thead style="background-color: #167F92;">
					<tr>
						<th class="footable-filtering footable-sortable" data-breakpoints="xs" data-sort-initial="descending">S. No.</th>
						<th class="footable-filtering footable-sortable">Respondent name</th>
						<th data-breakpoints="xs">Respondent address</th>
						<th data-breakpoints="xs sm">State</th>
						<th data-breakpoints="xs sm md">District</th>
						<th data-breakpoints="xs sm md">Pincode</th>
						<th data-breakpoints="xs sm md">Mobile Number</th>
						<th data-breakpoints="xs sm md">E-mail Id</th>
					</tr>
					</thead>
					<tbody>
					<?php $cdvr=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
					if(!empty($cdvr)){
						$i=1;
						$statename='';
						$ddistrictname='';
						foreach($cdvr as $cdvr){
							if($cdvr->res_state!=''){
								$st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$cdvr->res_state);
								$statename= $st2[0]->state_name;
							}
							if($cdvr->res_district!=''){
								$st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$cdvr->res_district);
								$ddistrictname= $st1[0]->district_name;
							}
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $cdvr->res_name;?></td>
								<td><?php echo $cdvr->res_address; ?></td>
								<td><?php echo $statename; ?></td>
								<td><?php echo $ddistrictname;?> </td>
								<td><?php echo $cdvr->res_pin;?></td>
								<td><?php echo $cdvr->res_mobile;?></td>
								<td><?php echo $cdvr->res_email;?></td>
							</tr>
						<?php  }
					}
					else{ echo "Record not found!";}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>



	<div class="card">
		<div class="card-header" id="headingFive">
			<h5 class="mb-0">
				<a  data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
					UPLOADED DOCUMENT'S LIST
				</a>
			</h5>
		</div>
		<div id="collapseFive" class="collapse " aria-labelledby="headingFive">
			<div class="card-body">
				<table id="table" class="responstable" width="100%" cellpadding="0"	cellspacing="0" border="1px">
					<thead>
					<tr>
						<th class="footable-filtering footable-sortable"	data-breakpoints="xs" data-sort-initial="descending">S. No.</th>
						<th class="footable-filtering footable-sortable">Document Filed	By</th>
						<th data-breakpoints="xs sm">Sub Document Type</th>
						<th data-breakpoints="xs">No. of Pages</th>
						<th data-breakpoints="xs sm md">Document Name</th>
						<th data-breakpoints="xs sm md">View Document</th>
					</tr>
					</thead>
					<tbody>
					<?php
						if($documents->num_rows()>0){
							$i=1;
							foreach($documents->result() as $doc){
								$filepath = $user_id.'@'.$doc->file_url;
								$filepathencrypt = $this->encryption->encrypt($filepath);
								$val='';
								if($doc->valumeno!=''){
									$val='&nbsp;&nbsp;&nbsp;&nbsp<span style="color:red;">(Vol-'.$doc->valumeno.')';
								}
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $doc->document_filed_by; ?></td>
									<td><?php echo $doc->document_type; ?><?php echo $val; ?></td>
									<td><?php echo $doc->no_of_pages; ?></td>
									<td><?php echo $doc->doc_name;; ?></td>
									<td><a href="<?=base_url('openfiles')?>" class="pageredirect" data-id="<?=$filepathencrypt?>">View</a>
										</td>
								</tr>
								<?php
								$i++;  }
						}else{
							echo "Record not found";
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<!--<td>
		<script type="text/javascript">
			var values= new Array("value1", "value2", "value3")
			var keys= new Array("a","b","c")
			var data={
				'filing_no':'',
				'csrf_token':'',
				'noback':true,
			};
		</script>

		<a class="btn btn-info pageredirect"  data-id="<?/*=$search*/?>" onclick="javascript:openWindowWithPostRequest('',data)"
			>VIEW DOCUMENTS</a></td>-->

	<div class="card">
		<div class="card-header" id="headingSix">
			<h5 class="mb-0">
				<a  data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
					ORDERS/JUDGEMENTS
				</a>
			</h5>
		</div>
		<div id="collapseSix" class="collapse " aria-labelledby="headingSix">
			<div class="card-body">
				<table id="table" class="responstable" width="100%" cellpadding="0"	cellspacing="0" border="1px">
					<thead>

					<tr>
						<th class="footable-filtering footable-sortable"	data-breakpoints="xs" data-sort-initial="descending">Sr. No.</th>
						<th data-breakpoints="xs sm">Order Type</th>
						<th class="footable-filtering footable-sortable">Order Date</th>
						<th data-breakpoints="xs">Judge Name</th>
						<th data-breakpoints="xs">Order File</th>

					</tr>
					</thead>
					<tbody>
					<?php
					if($orderdetails->num_rows()==0):
						echo '<tr><td colspan="5" align="center">Record not found</td></tr>';
					endif;

					if($orderdetails->num_rows()>0){
						$orderTypeArray=oredertype();
						$i=1;
						foreach($orderdetails->result_array() as $doc){
							 $user_id=$this->session->userdata('login_success')[0]->id;
							 $filepath=$user_id.'@'.$doc['path'];
							$filepathencrypt = $this->encryption->encrypt($filepath);
							$judgcodedb=$doc['judge_code'];
							if( strpos($doc['judge_code'], ',') !== false )
							{
								$judgesCodeArray=explode(',',$judgcodedb);
								foreach($judgesCodeArray as $judgesCode)
								{
									$judgeNames=$judgeArray[$judgesCode].'<br>';
								}
							}
							else
							{
								$judgeNames=$judgeArray[$judgcodedb].'<br>';
							}

							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?=$orderTypeArray[$doc['order_type']]; ?></td>
								<td><?php echo $doc['date_of_order']; ?></td>
								<td><?=$judgeNames?></td>

								<td><a href="<?=base_url('openfiles')?>" class="pageredirect" data-id="<?=$filepathencrypt?>">View</a>

									<?php// echo anchor('blog/comments', 'Click Here','target="_blank"');?>
								</td>
							</tr>
							<?php
							$i++;  }
					} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header" id="headingSeven">
			<h5 class="mb-0">
				<a  data-toggle="collapse" data-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
					ADVOCATE'S LIST
				</a>
			</h5>
		</div>
		<div id="collapseSeven" class="collapse " aria-labelledby="headingSeven" >
			<div class="card-body">
				<table class="responstable" width="100%" border="1px">
					<thead>
					<tr>
						<th class="footable-filtering footable-sortable"data-breakpoints="xs" data-sort-initial="descending">S.No.</th>
						<th class="footable-filtering footable-sortable">Advocate	Name</th>
						<th data-breakpoints="xs sm md">Advocate Email</th>
						<th data-breakpoints="xs sm md">Advocate Mobile</th>
					</tr>
					</thead>
					<tbody>
					<?php 	if(!empty($filedcase)){
						foreach($filedcase as $rowd){
							if($rowd->pet_adv!=''){
								$st1 = $this->efiling_model->data_list_where('master_advocate','adv_code',$rowd->pet_adv);
								$advocate= $st1[0]->adv_name;
							}
							?>
							<tr>
								<td>1</td>
								<td><?php echo $advocate; ?></td>
								<td><?php echo $rowd->pet_counsel_email; ?></td>
								<td><?php echo $rowd->pet_counsel_mobile; ?></td>
							</tr>

						<?php } }
					$stQ = $this->efiling_model->data_list_where('additional_advocate','filing_no',$filing_no);
					//	echo "<pre>";	print_r($stQ );die;
					if(!empty($stQ)){
						$i=2;
						foreach($stQ as $adv){
							if($adv->adv_code!=''){
								$st1 = $this->efiling_model->data_list_where('master_advocate','adv_code',$adv->adv_code);
								$advocate= $st1[0]->adv_name;
							}
							?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $advocate; ?></td>
								<td><?php echo $adv->adv_email; ?></td>
								<td><?php echo $adv->adv_mob_no; ?></td>
							</tr>
							<?php  $i++; }
					} ?>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

</div>



<?php $this->load->view("admin/footer"); ?>
<script>
	$( function() {
		$(".collapse").addClass("show");
	} );
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
 