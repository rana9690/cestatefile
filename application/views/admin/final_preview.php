<?php $this->load->view("admin/header"); ?>
<?php $this->load->view("admin/sidebar"); 
$salt=$this->session->userdata('salt'); 
$userdata=$this->session->userdata('login_success');
?>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?=base_url('asset/admin_js_final/customs.js')?>"></script>
<style>
.srchWrap {
    margin-left: 194px;
    position: relative;
    float: right;
    width: 100%;
    margin-right: 10px;
}

.srchWrap input {
    padding-left: 35px;
    font-size: 16px;
}

.srchWrap i {
    position: absolute;
    left: 12px;
    top: 14px;
}

/* .card.checklistSec { 
    margin: 0 21px; 
}
.checklistSec fieldset {
    padding-top: 0;
}
.checklistSec fieldset:first-child legend:first-child {
    padding: 14px 12px 10px 12px;
} */
</style>
<div id="rightbar">
    <?php  include 'steps.php';?>
    <?php defined('BASEPATH') OR exit('No direct script access allowed'); error_reporting(0); ?>

    <div class="content" style="padding:0px; position: relative;">
        <input type="button" value="Print" id="btnPrint" class="print-btn btn btn-sm btn-danger" onclick="printPage();">
        <div class="row">
            <div class="card checklistSec" id="dvContainer" style="">
                <form action="<?php echo base_url(); ?>/pay_page" target="_blank"
                    class="wizard-form steps-basic wizard clearfix" id="finalsubmit" autocomplete="off" method="post"
                    accept-charset="utf-8">
                    <div class="content clearfix" id="mainDiv1">
                        <?= form_fieldset().
                        '<div class="date-div text-success d-none">'.date('D M d, Y H:i:s').'&nbsp;IST</small></div>'; ?>
                        <?php 
                       
                        $org=$this->session->userdata('org');
                        $orgres='1';
                        ?>
                        <input type="hidden" id="saltNo" name="saltNo" value="<?php echo $salt; ?>">
                        <?php

                        $token=rand(1000,9999);
                        $md_db = hash('sha256',$token);
                        $token1=$md_db;
                       $this->session->set_userdata('submittoken',$token1);
                        $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
                        $bench=$st[0]->bench;
                        $subbench=$st[0]->sub_bench;
                        $caseType=$st[0]->l_case_type;
                       $schemasData=getSchemasNames($bench);
                       $schemas=$schemasData->schema_name;
                        ?>
                        <input type="hidden" name="org" value="<?php echo $org; ?>" id="org">
                        <input type="hidden" name="orgres" value="<?php echo $orgres; ?>" id="orgres">
                        <input type="hidden" name="token" value="<?php echo $token1; ?>" id="token">
                        <input type="hidden" name="bench" value="<?php echo $bench; ?>" id="bench">
                        <input type="hidden" name="sub_bench" value="<?php echo $subbench; ?>" id="sub_bench">
                        <input type="hidden" name="caseType" value="<?php echo $caseType; ?>" id="caseType">
                        <?php 
                          
                            $UiD=(int)$this->session->userdata('login_success')[0]->id;
                            $where_cond=[
                                'salt'          =>  $salt,
                                'created_user'  =>  $UiD
                            ];
                            $dataArray= $this->efiling_model->data_commission_where($salt,$UiD);
							//echo $this->db->last_query();

                            $val= $this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
                            foreach($val as $row) {
                               
                            $bcode = $row->bench;
                            $ben =$this->efiling_model->data_list_where('master_benches','bench_code',$bcode);
                            $bench_name =isset($ben[0]->name)?$ben[0]->name:'';
                      
                         
                            $sub_ben = $row->sub_bench;
                            $hscquery11 =$this->efiling_model->data_list_where('master_psstatus','state_code',$sub_ben);
                            $sub_name = isset($hscquery11[0]->state_name)?$hscquery11[0]->state_name:'';
                        
                            $act = $row->act;
                            $hscqueryact11 =$this->efiling_model->data_list_where('master_energy_act','act_code',$act);
                            $act = isset($hscqueryact11[0]->act_short_name)?$hscqueryact11[0]->act_short_name:'';

                    
                            $petsection = $row->petsection;

                            $hscquerysub11 =$this->efiling_model->data_list_where('master_under_section','section_code',$petsection);
                            $subsection_name = $hscquerysub11[0]->section_name;
                          
                    
                            $petno = $row->no_of_pet;
                            $resno = $row->no_of_res;
                            $iano = $row->no_of_ia;
                            $petid = $row->pet_name;
                            
                         
                            if (is_numeric($petid)) {
                                $storg11 = getOrg_name_master(['org_id'=>$petid]);//$this->efiling_model->data_list_where('master_org','org_id',$petid);
                                $pet_name = $storg11[0]['org_name'];
                            } else {
                                $pet_name = $row->pet_name;
                            }
                            $pet_degingnation = $row->pet_degingnation;
                            $pet_address = $row->pet_address;
                            $pet_pin = $row->pincode;
                            $pet_mob = $row->petmobile;
                            $petphone = $row->petphone;
                            $pet_email = $row->pet_email;
                            $pet_fax = $row->pet_fax;
                            $stcode = $row->pet_state;
                            $l_case_no = $row->l_case_no;
                            $l_case_year = $row->l_case_year;
                            $lower_case_type = $row->lower_case_type;
                    
                            $commission = $row->commission;
                            $nature_of_order = $row->nature_of_order;
                            $decision_date = $row->l_date;
                            $comm_date = $row->comm_date;
                            $case_type = $row->l_case_type;
                            
                            //$arr=array('flag'=>'1','case_type_code'=>$case_type);
                            //$case_type_detail=$this->efiling_model->select_in('master_case_type',$arr);
                           // $case_type_name='';
                            //if($case_type_detail!=''){
                            //    $case_type_name= isset($case_type_detail[0]->short_name)?$case_type_detail[0]->short_name:'';
                           // }
                                $case_type_name=getCaseTypes(['case_type_code'=>$case_type])[0]['case_type_name'];


                            $hscqueryst1 = $this->efiling_model->data_list_where('master_psstatus','state_code',$stcode); 
                            $state_name = $hscqueryst1[0]->state_name;
                          
                    
                    
                            $discode = $row->pet_dist;
                            
                            $dis_name = '';
                            $arr=array('state_code'=>$stcode,'district_code'=>$discode);
                            $hscquerydis=$this->efiling_model->select_in('master_psdist',$arr);
                            $dis_name= $hscquerydis[0]->district_name;
                            if($dis_name==''){
                                $dis_name='';
                            }
                           
                            $resid = $row->resname;
                            if ($resid != "") {
                                if (is_numeric($resid)) {
                                    $storg1 = getOrg_name_master(['org_code'=>$resid]);//$this->efiling_model->data_list_where('master_org','org_id',$resid);
                                    $res_name = $storg1[0]['org_name'];
                                } else {
                                     $res_name = $row->resname;
                                }
                            }
                            
                      
                            $res_degingnation = $row->res_degingnation;
                            $res_address = $row->res_address;
                            $res_pin = $row->pincode;
                            $res_mob = $row->res_mobile;
                            $resphone = $row->res_phone;
                            $res_email = $row->res_email;
                            $res_fax = $row->res_fax;
                            $stcode2 = $row->res_state;
                           
                           
                            $hscqueryst2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$stcode2);
                            $state_name2 = $hscqueryst2[0]->state_name;
                            if($state_name2==''){
                                 $state_name2 = '';
                            }
                           
                            $dis_name2='';
                            $discode2 = $row->res_dis;
                            if ($discode2 != "" ) {
                                $sqldis2 =$this->efiling_model->data_list_where('master_psdist','district_code',$discode2);
                                 $dis_name2 = $sqldis2[0]->district_name;
                                if($dis_name2==''){
                                   $dis_name2 = '';
                                }
                            }
                          
                            $pet_council_adv = $row->pet_council_adv;
                    
                           
                            //$adv = $this->efiling_model->data_list_where('master_advocate','adv_code',$pet_council_adv);
                            $adv=getAdvocates($schemas,['adv_code'=>$counseladd]);
                            $adv_name_pet = $adv[0]['adv_name'];
                            if(empty($adv_name_pet)){
                                $dis_name2 = '';
                            }
                            $res_council_adv = $row->res_council_adv;
                            if($res_council_adv!=''){     
                                $adv1 =getAdvocates($schemas,['adv_code'=>$res_council_adv]);//$this->efiling_model->data_list_where('master_advocate','adv_code',$res_council_adv);
                                $adv_name_res = $adv1[0]['adv_name'];
                                if(empty($adv_name_res)){
                                 $dis_name2 = '';
                                } 
                            }
                            $counsel_add = $row->counsel_add;
                            $ia_nature = $row->ia_nature;
                           
                        }
               
                        ?>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <legend><b>Basic Detail</b>
                                        <div class="date-div text-success">
                                            <?=$this->lang->line('referenceno')?> :
                                            <?=$salt?></div>
                                    </legend>

                                    <table id="example" class="table display" cellspacing="0" border="1" width="100%">
                                        <tbody>
                                            <tr class="bg-dark">
                                                <td width="16%">Bench</td>
                                                <td width="16%"><?php echo $bench_name; ?></td>
                                                <td width="16%"></td>
                                                <td width="16%"></td>
                                                <td width="16%">Case Type</td>
                                                <td width="16%"><?php echo $case_type_name; ?></td>
                                            </tr>

                                            <tr>
                                                <td>Act</td>
                                                <td><?php echo $act; ?></td>
                                                <td>Under Section</td>
                                                <td><?php echo $subsection_name; ?></td>
                                                <?php if(trim($userdata[0]->user_type)!='company'){?>
                                                <td></td>
                                                <td></td>
                                                <?php }else{ echo '<td colspan="2"></td>';}?>
                                            </tr>
                                            <tr>
                                                <td>Total No of Respondent(s)</td>
                                                <td><?php echo $resno; ?></td>
                                                <td> <?php  if($this->config->item('ia_privilege')==true):?>Total No. of
                                                    IAs <?php endif;?></td>
                                                <td><?php echo $iano; ?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                    </table>
                                    <h4 class="text-warning"><b><?=$this->lang->line('commisionerateHeading')?></b></h4>
                                    <table id="example" class="table display" cellspacing="0" border="1" width="100%">
                                        <tr class="bg-dark">
                                            <th><?=$this->lang->line('commissionLabel')?></th>
                                            <th><?=$this->lang->line('natureOrder')?></th>
                                            <th><?=$this->lang->line('impugnedType')?></th>
                                            <th><?=$this->lang->line('impugnedOrderNo');?></th>
                                            <!--th>Case Year</th-->
                                            <th>Decision Date</th>
                                            <th>Communication Date</th>
                                        </tr>
                                        <?php
                                                        //echo'<pre>'; print_r($dataArray); echo'</pre>';
                                                        foreach(@$dataArray as $cdata) :;
                                                        $comsdd=date('d-m-Y',strtotime($cdata->comm_date));
                                                        if($comsdd=='01-01-1970'){
                                                            $comsdd='';
                                                        }
                                                            echo '<tr>
                                                                    <td>'.$cdata->full_name.'</td>
                                                                    <td>'.$cdata->case_type_name.'</td>
                                                                    <td>'.$cdata->nature_name.'</td>
                                                                    <td>'.$cdata->case_no.'</td>
                                                                    <!--td>'.$cdata->case_year.'</td-->
                                                                    <td>'.date('d-m-Y',strtotime($cdata->decision_date)).'</td>
                                                                    <td>'.$comsdd.'</td>
                                                                </tr>';
                                                        endforeach;
                                                        ?>
                                        </tbody>
                                    </table>
                                </fieldset>


                                <?php 
                                                        echo form_fieldset('Appellant(s)  Details',['style'=>'']).
                                                        '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 21px 6px;"></i>'; ?>

                                <div class="d-block text-center text-warning">
                                    <div class="table-responsive text-secondary" id="add_petitioner_list">
                                        <span class="fa fa-spinner fa-spin fa-3x" style="display:none"></span>
                                        <table id="example" class="table display" cellspacing="0" border="1"
                                            width="100%">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <th>Sr. No. </th>
                                                    <th>Appellant Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                                $salt=$this->session->userdata('salt');
                                                                
                                                                $vals=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);

                                                                if(empty($vals)){
                                                                    $vals=$this->efiling_model->data_list_where('aptel_case_detail','filing_no',$filing_no);
                                                                }


                                                                if(@$vals[0]->pet_name!=''){
                                                                    $petName=$vals[0]->pet_name;
                                                                    if (is_numeric($vals[0]->pet_name)) {

                                                                        $orgname=getOrg_name_master(['org_code'=>$vals[0]->pet_name]);//$this->efiling_model->data_list_where('master_org','org_id',$vals[0]->pet_name);
                                                                        $petName=$orgname[0]['org_name'];
                                                                    }
                                                                    
                                                                    if($vals[0]->pet_state!=''){
                                                                        $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
                                                                        $statename= $st2[0]->state_name;
                                                                    }
                                                                    if($vals[0]->pet_dist!=''){
                                                                        $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
                                                                        $ddistrictname= $st1[0]->district_name;
                                                                    }
                                                                    
                                                                    ?>
                                                <tr style="color:green">
                                                    <td>1</td>
                                                    <td><?php echo $petName; ?>(A-1)</td>
                                                    <td><?php echo isset($vals[0]->petmobile)?$vals[0]->petmobile:'' ?>
                                                    </td>
                                                    <td><?php echo $vals[0]->pet_email ?></td>
                                                    <td><?php echo $vals[0]->pet_address ?>&nbsp;<?php echo $ddistrictname ?>
                                                        &nbsp;<?php echo $statename; ?>&nbsp;<?php echo $vals[0]->pincode ?>
                                                    </td>
                                                </tr>
                                                <?php } 
                                                                        $additionalparty=$this->efiling_model->data_list_where('aptel_temp_additional_party','salt',$salt); 
                                                                        if(empty($additionalparty)){
                                                                            $additionalparty=$this->efiling_model->data_list_where('additional_party','filing_no',$filing_no);
                                                                        }
                                                                        $i=2;
                                                                        if(!empty($additionalparty)){
                                                                            foreach($additionalparty as $val){
                                                                                $petName=$val->pet_name;
                                                                                if (is_numeric($val->pet_name)) {
                                                                                    $orgname=getOrg_name_master(['org_code'=>$val->pet_name]); //$this->efiling_model->data_list_where('master_org','org_id',$val->pet_name);
                                                                                    $petName=$orgname[0]['org_name'];
                                                                                }
                                                                            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $petName; ?>(A-<?php echo $i; ?>)</td>
                                                    <td><?php echo $val->pet_mobile ?></td>
                                                    <td><?php echo $val->pet_email ?></td>
                                                    <td><?php echo $val->pet_address ?></td>

                                                </tr>
                                                <?php 
                                                                        $i++; }
                                                                    }else{
                                                                        $val= "<span style='color:Red'>Reccord Not found";
                                                                    }
                                                                        ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <?php  echo form_fieldset_close(); ?>
                                <?php 
                                                            if($pet_type!=1){
                                                            ?>
                                <fieldset>
                                    <legend><b>Counsel/ Representative Details</b></legend>
                                    <?php   $html='';
                           $html.='

                            <table id="example" class="table display" cellspacing="0" border="1" width="100%">
                	        <thead>
                    	        <tr class="bg-dark">
                        	        <th>Sr. No. </th>
                        	        <th>Advocate name</th>
                        	        <th>Registraction</th>
                                    <th>Address</th>
                        	        <th>Mobile</th>
                        	        <th>Email</th>
                                    
                    	        </tr>
                	        </thead>
                	        <tbody>';

                           $vals=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
                           $advType=$vals[0]->advType;

                           if($vals[0]->pet_council_adv){
                               $counseladd=$vals[0]->pet_council_adv;
                               if($vals[0]->advType=='1'){
                                     if (is_numeric($vals[0]->pet_council_adv)) {

                                           //$orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
                                           $orgname=getAdvocates($schemas,['adv_code'=>$counseladd]);

                                           $adv_name=$orgname[0]['adv_name'];
                                           $adv_reg=$orgname[0]['adv_reg'];
                                           $adv_mobile=$orgname[0]['adv_mobile'];
                                           $email=$orgname[0]['email'];
                                           $address=$orgname[0]['address'];
                                           $pin_code=$orgname[0]['adv_pin'];
                                           
                                           if($vals[0]->pet_state!=''){
                                               $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
                                               $statename= $st2[0]->state_name;
                                           }
                                           if($vals[0]->pet_dist!=''){
                                               $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
                                               $ddistrictname= $st1[0]->district_name;
                                           }
                                      }
                               }
                               
                               if($vals[0]->advType=='2'){
                                   if (is_numeric($vals[0]->pet_council_adv)) {
                                       $orgname=$this->efiling_model->data_list_where('efiling_users','id',$counseladd);
                                       $adv_name=$orgname[0]->fname.' '.$orgname[0]->lname;
                                       $adv_reg=$orgname[0]->id_number.' <span style="color:red">'.$orgname[0]->idptype.'</span>';
                                       $adv_mobile=$orgname[0]->mobilenumber;
                                       $email=$orgname[0]->email;
                                       $address=$orgname[0]->address;
                                       $pin_code=$orgname[0]->pincode;
                                       
                                       if($vals[0]->pet_state!=''){
                                           $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
                                           $statename= $st2[0]->state_name;
                                       }
                                       if($vals[0]->pet_dist!=''){
                                           $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
                                           $ddistrictname= $st1[0]->district_name;
                                       }
                                   }
                               }
                               $type="'main'";
                               $html.='
                                <tr style="color:green">
                                    <td>1</td>
                        	        <td>'.$adv_name.'</td>
                        	        <td>'.$adv_reg.'</td>
                                    <td>'.$address.' '.$ddistrictname.' ('.$statename.')  '.$pin_code.'</td>
                        	        <td>'.$adv_mobile.'</td>
                        	        <td>'.$email.'</td>
                        	        
                                </tr>';
                           }
                           $advocatelist=$this->efiling_model->data_list_where('aptel_temp_add_advocate','salt',$salt);
                
                           if(!empty($advocatelist)){
                               $i=2;
                               foreach($advocatelist as $val){
                                   $counseladd=$val->council_code;
                                   $advType=$val->advType;
                                   if($advType=='1'){
                                       if (is_numeric($val->council_code)) {
                                           //$orgname=$this->efiling_model->data_list_where('master_advocate','adv_code',$counseladd);
                                           $orgname=getAdvocates($schemas,['adv_code'=>$counseladd]);
                                           $adv_name=$val->adv_name;
                                           $adv_reg=$orgname[0]['adv_reg'];
                                           $address=$val->counsel_add;
                                           $pin_code=$val->counsel_pin;
                                           $counselmobile=$val->counsel_mobile;
                                           $counselemail=$val->counsel_email;
                                           $id=$val->id;
                                           if($val->adv_state!=''){
                                               $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$val->adv_state);
                                               $statename= $st2[0]->state_name;
                                           }
                                           if($val->adv_district!=''){
                                               $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$val->adv_district);
                                               $ddistrictname= $st1[0]->district_name;
                                           }
                                       }
                                   }
                                   
                                 
                                   
                                   
                                   if($advType=='2'){
                                       if (is_numeric($val->council_code)) {
                                           $orgname=$this->efiling_model->data_list_where('efiling_users','id',$counseladd);
                                           $adv_name=$orgname[0]->fname.' '.$orgname[0]->lname;
                                           $adv_reg=$orgname[0]->id_number.' <span style="color:red">'.$orgname[0]->idptype.'</span>';
                                           $counselmobile=$orgname[0]->mobilenumber;
                                           $counselemail=$orgname[0]->email;
                                           $address=$orgname[0]->address;
                                           $pin_code=$orgname[0]->pincode;
                                           $id=$val->id;
                                           if($vals[0]->pet_state!=''){
                                               $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->pet_state);
                                               $statename= $st2[0]->state_name;
                                           }
                                           if($vals[0]->pet_dist!=''){
                                               $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->pet_dist);
                                               $ddistrictname= $st1[0]->district_name;
                                           }
                                       }
                                   }
                                   
                                   $type="'add'";
                                   $html.='<tr>
                            	        <td>'.$i.'</td>
                            	        <td>'.$adv_name.'</td>
                            	        <td>'.$adv_reg.'</td>
                                        <td>'.$address.' '.$ddistrictname.' ('.$statename.')  '.$pin_code.'</td>
                            	        <td>'.$counselmobile.'</td>
                            	        <td>'.$counselemail.'</td>
                        	        </tr>';
                                   $i++;
                               }
                           }
                                    $html.='</tbody></table>';
                           echo $html;
                	         ?>
                                    </table>
                                    <?php  echo form_fieldset_close(); }?>



                                    <?php 
                                                            echo form_fieldset('Respondent(s) Details',['style'=>'']).
                                                            '<i class="icon-plus-circle2 text-danger d-none" style="position: absolute;padding: 21px 6px;"></i>'; ?>

                                    <div class="d-block text-center text-warning">
                                        <div class="table-responsive text-secondary" id="add_petitioner_list">
                                            <span class="fa fa-spinner fa-spin fa-3x" style="display:none"></span>
                                            <table id="example" class="table display" cellspacing="0" border="1"
                                                width="100%">
                                                <thead>
                                                    <tr class="bg-dark">
                                                        <th>Sr. No. </th>
                                                        <th>Respondent Name</th>
                                                        <th>Mobile</th>
                                                        <th>Email</th>
                                                        <th>Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $salt=$this->session->userdata('salt'); 
                                                    $vals=$this->efiling_model->data_list_where('aptel_temp_appellant','salt',$salt);
                                                    if(@$vals[0]->resname!=''){
                                                    $petName=$vals[0]->resname;
                                                    if (is_numeric($vals[0]->resname)) {
                                                        $orgname=getOrg_name_master(['org_code'=>$vals[0]->resname]);//$this->efiling_model->data_list_where('master_org','org_id',$vals[0]->resname);
                                                            $petName=$orgname[0]->org_name;
                                                        }
                                                        
                                                        if($vals[0]->res_state!=''){
                                                            $st2 = $this->efiling_model->data_list_where('master_psstatus','state_code',$vals[0]->res_state);
                                                            $statename= $st2[0]->state_name;
                                                        }
                                                        if($vals[0]->res_dis!=''){
                                                            $st1 = $this->efiling_model->data_list_where('master_psdist','district_code',$vals[0]->res_dis);
                                                            $ddistrictname= $st1[0]->district_name;
                                                        }
                                                        
                                                    ?>
                                                    <tr style="color:green">
                                                        <td>1</td>
                                                        <td><?php echo $petName; ?>(R-1)</td>

                                                        <td> <?php echo $vals[0]->res_mobile ?></td>
                                                        <td><?php echo $vals[0]->res_email ?></td>
                                                        <td><?php echo $vals[0]->res_address; ?>
                                                            &nbsp;<?php echo $ddistrictname; ?>
                                                            &nbsp;<?php echo $statename; ?>&nbsp;<?php echo $vals[0]->res_pin; ?>
                                                        </td>
                                                    </tr>
                                                    <?php } 
                                                    $additionalresparty=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt',$salt);
                                                    $i=2;
                                                    if(!empty($additionalresparty)){
                                                        foreach($additionalresparty as $val){
                                                            $resName=$val->res_name;
                                                            if (is_numeric($val->res_name)) {
                                                                $orgname=getOrg_name_master(['org_code'=>$val->res_name]);//$this->efiling_model->data_list_where('master_org','org_id',$val->res_name);
                                                                $resName=$orgname[0]['org_name'];
                                                            }
                                                            ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $resName; ?>(R-<?php echo $i; ?>)</td>

                                                        <td><?php echo $val->res_mobile; ?></td>
                                                        <td><?php echo $val->res_email; ?></td>
                                                        <td><?php echo $val->res_address; ?></td>
                                                    </tr>
                                                    <?php 
                                                            $i++; }
                                                        }else{
                                                            $val= "<span style='color:Red'>Reccord Not found";
                                                        }
                                                     ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php  echo form_fieldset_close();?>




                                    <?php
                            
                            $ia_nature1 = explode(',', $ia_nature);
                            if ($ia_nature != '' && !empty($ia_nature1)) {
                                ?>
                                    <fieldset>
                                        <legend><b>IA Details</b></legend>

                                        <table id="example" class="table display" cellspacing="0" border="1"
                                            width="100%">
                                            <tbody>

                                                <tr>
                                                    <td width="80%">IA Nature Name</td>

                                                    <td width="20%">Fees</td>
                                                </tr>
                                                <?php
                                        $fee='';
                                        $ia_nature1 = explode(',', $ia_nature);
                                        $len = sizeof($ia_nature1)-1;
                                      
                                        
                                        for ($i = 0; $i < $len; $i++) {
                                            if($ia_nature1[$i]!=''){
                                                if (is_numeric($ia_nature1[$i])) {
                                                    $aDetail = $this->efiling_model->data_list_where('moster_ia_nature','nature_code',$ia_nature1[$i]);
                                                }
                                             $ia_nature_name = $aDetail[0]->nature_name;
                                                if ($ia_nature != "") {
                                                    $fee = '1000';
                                                }
                                            }
                                            ?>
                                                <tr>

                                                    <td width="20%"><?php echo $ia_nature_name; ?></td>
                                                    <td width="80%"><?php echo $fee; ?></td>

                                                </tr>
                                                <?php   
                                        }?>
                                            </tbody>
                                        </table>
                                    </fieldset>

                                    <?php  }  ?>


                                    <fieldset>
                                        <legend><b class="">Uploaded Documents Details :</b>
                                        </legend>
                                        <table id="example" class="table display" cellspacing="0" border="1"
                                            width="100%">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <th>Party Type</th>
                                                    <th>Document Type</th>
                                                    <th>No of Pages</th>
                                                    <th>Last Update</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                
                                    $warr=array('salt'=>$salt,'user_id'=>$UiD,'display'=>'Y');
                                    $docData =$this->efiling_model->list_uploaded_docs('temp_documents_upload',$warr);
                                    
                                    if(@$docData) {
                                        foreach ($docData as $docs) {
                                            $document_filed_by = $docs->document_filed_by;
                                            $document_type = $docs->document_type;
                                            $no_of_pages = $docs->no_of_pages;
                                            $file_id = $docs->id;
                                            $update_on = $docs->update_on;
                                            
                                            echo'<tr>
                                                    <td>'.$document_filed_by.'</td>
                                                    <td>'.$document_type.'</td>
                                                    <td>'.$no_of_pages.'</td>
                                                    <td>'.date('d-m-Y H:i:s', strtotime($update_on)).'</td>
                                                    <td id="updDocId"><a href="javascript:void();" tagId="'.$file_id.'"><i class="fa fa-eye"></i></a></td>
                                            </tr>';
                                        }
                                    }
                                    else echo'<tr><td colspan=5 class="text-danger text-center h3">No document uploaded!</td></tr>';
                                    ?>
                                            </tbody>
                                        </table>
                                    </fieldset>


                                    <fieldset>
                                        <legend><b>Fee Details</b></legend>
                                        <table id="example" class="table display" cellspacing="0" border="1"
                                            width="100%">
                                            <tbody>
                                                <?php 
                                    
                                    $salt=$this->session->userdata('salt');
                                    $token=rand(1000,9999);
                                    $md_db = hash('sha256',$token);
                                    $token1=$md_db;
                                    $this->session->set_userdata('tokenno',$token1);
                                    
                                    $st=$this->efiling_model->data_list_where('aptel_temp_appellant','salt', $salt);
                                    
                                    $noofimpugned=$st[0]->no_of_impugned;
                                    $ia=$st[0]->no_of_ia;
                                    $norespondent=$st[0]->no_of_res;
                                    $fee=$this->session->userdata('efilingFeeData');
                                    
                                    
                                    $iaFee1= @$fee['iaFee1'];
                                    $otherFee2=@$fee['otherFee2'];
                                    
                                    
                                    $act = $st[0]->act;
                                    $hscqueryact11 =$this->efiling_model->data_list_where('master_energy_act','act_code',$act);
                                    $fee = isset($hscqueryact11[0]->fee)?$hscqueryact11[0]->fee:'';
                                    
                                    
                                    $st=$this->efiling_model->data_list_where('aptel_temp_additional_res','salt', $salt);
                                    $rescount=count($st)+1;
                                    $resamoubnt=0;
                                    if($rescount>4){
                                        $resamoubnt=($rescount-4)*$fee;
                                    }
                                    //$appealFee= $fee*$noofimpugned+$resamoubnt;
                                    $total=@$appealFee+$iaFee1+$otherFee2;
                                    ?>
                                                <tr>
                                                    <td width="16%" colspan="4"><b>Appeal Fee </b></td>
                                                    <td width="16%" colspan="1">RS. <?php echo @$appealFee; ?></td>
                                                </tr>
                                                <?php if($this->config->item('ia_privilege')==true):?>
                                                <tr>
                                                    <td width="16%" colspan="4"><b>Total IA Fee </b></td>
                                                    <td width="16%" colspan="1">RS. <?php echo @$iaFee1; ?></td>
                                                </tr>
                                                <?php endif;?>
                                                <tr>
                                                    <td width="16%" colspan="4"><b>Total Other Fee </b></td>
                                                    <td width="16%" colspan="1">RS. <?php echo @$otherFee2; ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="16%" colspan="4"><b>Total Payble Amount </b></td>
                                                    <td width="16%" colspan="1">RS. <?php echo @$total; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="total_amount_amount" id="total_amount_amount"
                                            value="<?php echo $total; ?>">
                                        <?= form_fieldset_close(); ?>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <?php if($total==0):

                                        echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                            form_button(['content' => 'Final Submit','value'=>'false','onclick'=>'javascript:finaldiarysubmit()','class'=>'btn btn-success hidePrint','id'=>'finalsave','style'=>'padding-left:24px;']).
                                            '<i class="icon-trash-alt d-none" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>';


                                        else:

                        			echo '<i class="icon-file-plus" style="position: absolute; margin: 9px 4px; z-index: 9; color: white;"></i>'.
                                        form_submit(['value'=>'Save & Next','class'=>'btn btn-success','id'=>'finalsave','style'=>'padding-left:24px;']).
                                         '<i class="icon-trash-alt" style="position: absolute; z-index: 9; margin: 10px 4px; color:white;"></i>'.
                        			     form_reset(['value'=>'Reset/Clear','class'=>'btn btn-danger','style'=>'padding-left: 24px;']);
                                        //  .form_button(['id'=>'','value'=>'false','content'=>'&nbsp;Next','class'=>'icon-arrow-right8 btn btn-primary']);
                                	 endif;?>
                                            </div>
                                        </div>
                            </div>
                            <div class="content clearfix" id="secondDiv">
                            </div>
                            <?= form_close();?>
                        </div>
                    </div>
            </div>

            <div class="modal fade bd-example-modal-lg" id="getCodeModal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="margin-top: 190px;">
                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div id="viewsss">
                        </div>

                    </div>
                </div>
            </div>

            <!-- Display Uploaded file PDF -->
            <div class="modal fade" id="updPdf" role="dialog">
                <div class="modal-dialog modal-dialog-centered" style="min-width: 90%; margin-top: 190px;">
                    <div class="modal-content">
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <iframe style="width: 100%; height: 560px" id="frameID" src=""></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            $('#updDocId > a').click(function(e) {
                e.preventDefault();
                var href = base_url + 'openfiledraft/' + $(this).attr('tagId');
                console.log(href);
                $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");
                $('#updPdf').modal('show');
            });
            /*$('#updDocId > a').click(function(e){
                e.preventDefault();
                var updId='', href='';
                updId=$(this).attr('tagId');
                $.ajax({
                    type: 'post',
                    url: base_url+'uploaded_docs_display',
                    data: {docId: updId},
                    dataType: 'json',
                    success: function(rtn){
                        debugger;
                        if(rtn.error == '0'){
                            href=base_url+rtn.data;   
                            $('#frameID').attr("src", href + "#view=VFit" + "&toolbar=0" + "&navpanes=0");   
                        }
                        else $.alert(rtn.error);
                    }
                });
                $('#updPdf').modal('show');
            });*/

            function printPage() {
                change("testdiv", "true");
                window.print();
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


            /* $('#finalsubmit').submit(function(e){
            	e.preventDefault();
            	   var salt = document.getElementById("saltNo").value;
                   var bench = document.getElementById("bench").value;
                   var subBench = document.getElementById("sub_bench").value;
                   var caseType = document.getElementById("caseType").value;
                   var matter = document.getElementById("caseType").value; //document.getElementById("matter").value;
                   var total_amount_amount = document.getElementById("total_amount_amount").value;
                   var idorg = document.getElementById('org').value;
                   var idorg1=document.getElementById('orgres').value;
                   var dataa={};
                   dataa['total_amount_amount']=total_amount_amount,
                   dataa['sql']=salt,
                   dataa['bench']=bench;
                   dataa['subBench']=subBench,
                   dataa['type']=caseType,
                   dataa['matt']=matter,
                   dataa['typefiled']=idorg,
                   dataa['typefiledres']=idorg1,
                   $.ajax({
            	        type: "POST",
            	        url: base_url+'efilingfinalsubmit',
            	        data: dataa,
            	        cache: false,
            			beforeSend: function(){
            				$('#finalsave').prop('disabled',true).val("Under proccess....");
            			},
            	        success: function (resp) {
            	        	var resp = JSON.parse(resp);
            	        	if(resp.data=='success') {
            	        		$('#mainDiv1').hide();
            	        		$('#secondDiv').html(resp.display);
            				}
            				else if(resp.error != '0') {
            					$.alert(resp.error);
            				}
            	        },
            	        error: function(){
            				$.alert("Surver busy,try later.");
            			},
            			complete: function(){
            				$('#finalsave').prop('disabled',false).val("Submit");
            			}
            		 }); 
            		 
            }); */
            </script>

            <script type="text/javascript">
            function printPage() {
                var divContents = $("#dvContainer").html();
                var printWindow = window.open('', '', 'height=400,width=800');
                var mycss =
                    '<style>.table{width: 100%;max-width: 100%;margin-bottom: 20px; border-collapse: collapse;} fieldset{padding: 0px;border: none;border-radius: 6px;margin: 0;display: block;background: #fff;padding-top: 40px;padding-bottom: 22px;overflow: hidden;position: relative;} legend{width: 98%;display: inline-block;border: none;color: #ffffff;font-size: 18px;font-weight: bold;font-style: normal;font-family: inherit;background: #1d3460;padding: 8px 14px;border-radius: 10px 10px 0 0;margin-bottom: 0;position: absolute;left: 0;top: 0;} .date-div {float: right;position: relative;z-index: 9;border-radius: 6px;border: none;margin-top: 0 !important;margin-bottom: 0 !important;background: #fff;font-family: none;font-style: inherit;font-size: 12px;padding: 3px 10px;display: inline-block;width: auto;color: #444 !important;margin-right: 8px;} .d-none{display:none;} .row{margin-right: -15px;margin-left: -15px;padding: 0 15px;} .col-md-12 {width: 100%;} content {position: relative;width: auto;padding: 0;}.bg-dark{background-color: #324148!important;} .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{padding: 8px;line-height: 1.42857143;vertical-align: top;} [class*=bg-]:not(.bg-transparent):not(.bg-light):not(.bg-white):not(.btn-outline):not(body) {color: #fff;} h4 {font-size:18px;}.text-warning {color: #ff7043!important;}.hidePrint{display:none;}</style>';
                printWindow.document.write(mycss + divContents);
                printWindow.document.close();
                printWindow.print();
            }

            function finaldiarysubmit() {
                $.ajax({
                    type: "POST",
                    url: base_url + 'efilingfinalsubmit',
                    data: $('form').serialize() + '&sql=' + parseInt($("#saltNo").val()) +
                        '&typefiled=' + $("#org").val() + '&typefiledres=' + $("#orgres").val() +
                        '&type=' + $("#caseType").val(),
                    cache: false,
                    beforeSend: function() {
                        $('#finalsave').prop('disabled', true).val("Under proccess....");
                    },
                    success: function(resp) {
                        var resp = JSON.parse(resp);
                        if (resp.data == 'success') {
                            $('.breadcrumb-default').empty();
                            $("#btnPrint").hide();
                            $('form').html(resp.display);
                        } else if (resp.error != '0') {
                            $.alert(resp.error);
                        }
                    },
                    error: function() {
                        $.alert("Surver busy,try later.");
                    },
                    complete: function() {
                        $('#finalsave').prop('disabled', false).val("Final Submit");
                    }
                });
            }
            </script>

            <?php $this->load->view("admin/footer"); ?>