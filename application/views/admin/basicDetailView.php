<div class="col-lg-12 p-0">
	<div class="row">	
		<div class="col-lg-4">
			<div class="form-card">
				<div class="form-group">
				<label class="control-label" for="caseType"><span class="custom"><font color="red">*</font></span> Case Type:</label>
					<div class="input-group mb-3 mb-md-0">
					<?php
					$CaseType= $this->efiling_model->getCaseType();
					foreach ($CaseType as $val)
					$casetype1[$val->case_type_code] = $val->case_type_name.' - '.$val->short_name;
					echo form_dropdown('caseType',$casetype1,$case_type,['class'=>'form-control','id'=>'caseType','required'=>'true']);
					?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-card">
				<div class="form-group">
					<label class="control-label" for="act"><span class="custom"><font color="red">*</font></span>Act</label>
					<div class="input-group mb-3 mb-md-0">
						<?php
						
						$act1= $this->efiling_model->data_list('master_energy_act','act_short_name','act_code');
						$act=[''=>'-Please Select Act-'];
						foreach ($act1 as $val)
							$act[$val->act_code] = $val->act_short_name;
						echo form_dropdown('act',$act,$pet_section,['class'=>'form-control','id'=>'act','required'=>true,'required'=>'true']);
						?>
					</div>
				</div>			 
			</div>
		</div>
		<div class="col-lg-4">
			<input type="hidden" name="subBench" value="7">
				<div class="form-card">
					  <div class="form-group">
						<label class="control-label" for="petSection"><span class="custom"><font color="red">*</font></span>Section:</label>
						<div class="input-group mb-3 mb-md-0">
							 <?php
							 
							 $petsectionval=isset($basic[0]->petsection)?$basic[0]->petsection:$pet_sub_section;
							 echo form_dropdown('petSection','-Select Under Section-',$petsectionval,['class'=>'form-control','id'=>'petSection','required'=>'true']);
							 ?>
						</div>
					</div>
				</div>
		 </div>
	</div>
</div>


		
		 
		<div class="col-lg-12">
			   <h4 class="text-warning" ><?=$this->lang->line('commisionerateHeading')?></h4>
			<div class="row">
				<?php
				$html='				
					<table id="example" class="display table table-bordered" cellspacing="0" border="1" width="100%">
					<thead>
						<tr class="bg-dark">
							
							<th>'.$this->lang->line('commissionLabel').'</th>
							<th>'.$this->lang->line('natureOrder').'</th>
							<th>'.$this->lang->line('impugnedType').'</th>
							<th>'.$this->lang->line('impugnedOrderNo').'</th>                                                
							<th>Decision Date</th>                                                
						</tr>
					</thead>
					<tbody>';			
							$natshort_name=$natureorders[$iss_desig];					
							$commname=$commisions[$iss_org];					 
							$casetype=getImpugnedType()[$impugn_type];	
						$html.='<tr >								
								<td>'.$commname.'</td>
								<td>'.$natshort_name.'</td>
								<td>'.$casetype.'</td>
								<td>'.$impugn_no.'</td>							   
								<td>'.date('d-m-Y',strtotime($impugn_date)).'</td>
								</tr>'; 
								$html.='</tbody>
						</table>';
					echo $html;			  
				?>				
			</div>
		</div>
