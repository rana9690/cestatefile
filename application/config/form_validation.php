<?php
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 12/29/2022
 * Time: 9:23 AM
 */

$config = array(
    'basicDetails' => array(
        array(
            'field' => 'fieldset',
            'label' => 'fieldset',
            'rules' => 'required|numeric|max_length[3]',
            'errors' => array(
                //'required' => 'The %s is already taken.',
                'required' => 'Something went wrong.',
                'alpha' => 'Something went wrong.',
                'max_length' => 'Something went wrong.',
            ),
        ),
        array(
            'field' => 'saltNo',
            'label' => 'saltNo',
            'rules' => 'required|numeric|max_length[16]',
            'errors' =>array(
                'required' => 'Something went wrong.',
                'alpha' => 'Something went wrong.',
                'max_length' => 'Something went wrong.',
            ),
        ),
        array(
            'field' => 'bench',
            'label' => 'Choose valid Bench',
            'rules' => 'required|numeric|max_length[6]'
        ),
        array(
            'field' => 'subBench',
            'label' => 'Choose valid sub_bench',
            'rules' => 'required|numeric|max_length[8]'
        ),
        array(
            'field' => 'act',
            'label' => 'act',
            'rules' => 'required|numeric|max_length[3]'
        ),
        array(
            'field' => 'caseType',
            'label' => 'caseType',
            'rules' => 'trim|required|numeric|max_length[2]'
        ),
        array(
            'field' => 'totalNoAnnexure',
            'label' => 'totalNoAnnexure',
            'rules' => 'required|numeric|max_length[3]'
        ),
    ),

    'basicChecklist' => array(
        array(
            'field' => 'fieldset',
            'label' => 'fieldset',
            'rules' => 'required|numeric|max_length[3]',
            'errors' =>array(
                //'required' => 'The %s is already taken.',
                'required' => 'Something went wrong.',
                'alpha' => 'Something went wrong.',
                'max_length' => 'Something went wrong.',
            ),
        ),
        array(
            'field' => 'saltNo',
            'label' => 'saltNo',
            'rules' => 'required|numeric|max_length[16]',
            'errors' => array(
                'required' => 'Something went wrong.',
                'alpha' => 'Something went wrong.',
                'max_length' => 'Something went wrong.',
            ),
        ),
        array(
            'field' => 'ass_org',
            'label' => 'ass_org',
            'rules' => 'required|numeric|max_length[8]'
        ),
        array(
            'field' => 'add_comm',
            'label' => 'Is the order appealed against',
            'rules' => 'required|numeric|max_length[8]'
        ),
        array(
            'field' => 'adj_org',
            'label' => 'Address of the adjudicating authority ',
            'rules' => 'required|numeric|max_length[3]'
        ),
        array(
            'field' => 'adj_desig',
            'label' => 'Designation of the adjudicating',
            'rules' => 'required|numeric|max_length[2]'
        ),
        array(
            'field' => 'ass_desig',
            'label' => 'The designation and address',
            'rules' => 'required|numeric|max_length[3]'
        ),
        array(
            'field' => 'app_quest',
            'label' => 'Whether the decision or order',
            'rules' => 'numeric|max_length[3]'
        ), array(
            'field' => 'applic_dispensed',
            'label' => 'Whether duty or penalty',
            'rules' => 'numeric|max_length[3]'
        ), array(
            'field' => 'ce_duty',
            'label' => 'Does the order appealed against',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'st_duty',
            'label' => 'Does the order appealed against also involve any Service Tax ',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'cu_pri_imp1',
            'label' => 'Subject matter of Dispute in order of Priority1 import',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'cu_pri_imp2',
            'label' => 'Subject matter of Dispute in order of Priority2 import',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'cu_pri_exp1',
            'label' => 'Subject matter of Dispute in order of Priority1 export',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'cu_pri_exp2',
            'label' => 'Subject matter of Dispute in order of Priority2 export',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'cu_pri_gen1',
            'label' => 'Subject matter of Dispute in order of Priority1 general',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'cu_pri_gen2',
            'label' => 'Subject matter of Dispute in order of Priority2 general',
            'rules' => 'numeric|max_length[3]'
        )
    ),
    'basicDescription' => array(
        array(
            'field' => 'fieldset',
            'label' => 'fieldset',
            'rules' => 'required|numeric|max_length[3]',
            'errors' => array(
                //'required' => 'The %s is already taken.',
                'required' => 'Something went wrong.',
                'alpha' => 'Something went wrong.',
                'max_length' => 'Something went wrong.',
            ),
        ),
        array(
            'field' => 'saltNo',
            'label' => 'saltNo',
            'rules' => 'required|numeric|max_length[16]',
            'errors' => array(
                'required' => 'Something went wrong.',
                'alpha' => 'Something went wrong.',
                'max_length' => 'Something went wrong.',
            ),
        ),
        array(
            'field' => 'goods',
            'label' => 'goods',
            'rules' => 'max_length[255]'
        ),
        array(
            'field' => 'classification',
            'label' => 'classification',
            'rules' => 'numeric|max_length[3]'
        ),
        array(
            'field' => 'dispute_st_dt',
            'label' => 'dispute_st_dt',
            'rules' => 'required|valid_date|check_equal_less_date'
        ),
        array(
            'field' => 'dispute_en_dt',
            'label' => 'dispute_en_dt',
            'rules' => 'required|valid_date|check_equal_less_date|check_greater_then_firstDate[dispute_st_dt]'
        ),
        array(
            'field' => 'duty_tax_ord',
            'label' => 'duty_tax_ord',
            'rules' => 'max_length[35]'
        ),
        array(
            'field' => 'duty_tax_pd',
            'label' => 'duty_tax_pd',
            'rules' => 'numeric|max_length[35]'
        ), array(
            'field' => 'pay_mode_duty',
            'label' => 'pay_mode_duty',
            'rules' => 'numeric|max_length[3]'
        ), array(
            'field' => 'penalty_ord',
            'label' => 'penalty_ord',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'penalty_pd',
            'label' => 'penalty_pd',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'pay_mode_penalty',
            'label' => 'pay_mode_penalty',
            'rules' => 'numeric|max_length[3]'
        ),array(
            'field' => 'refund_ord',
            'label' => 'refund_ord',
            'rules' => 'max_length[35]'
        ),array(
            'field' => 'refund_pd',
            'label' => 'refund_pd',
            'rules' => 'max_length[35]'
        ),array(
            'field' => 'fine_int_ord',
            'label' => 'fine_int_ord',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'fine_int_pd',
            'label' => 'fine_int_pd',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'inter_ord',
            'label' => 'inter_ord',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'inter_pd',
            'label' => 'inter_pd',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'rp_ord',
            'label' => 'rp_ord',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'rp_pd',
            'label' => 'rp_pd',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'mkt_value',
            'label' => 'mkt_value',
            'rules' => 'numeric|max_length[35]'
        ),array(
            'field' => 'total_amount',
            'label' => 'total_amount',
            'rules' => 'numeric|max_length[35]'
        ),
    ),
	
	
	'requireDocument' => array(
        array(
            'field' => 'userfile',
            'label' => '',
            'rules' => 'callback_mimeType|callback_double_dot|callback_isValidPDF',
        ),
        array(
            'field' => 'filename',
            'label' => '',
            'rules' => 'trim|max_length[100]',
        ),        
    ),

    'addmoredd' => array(
        array(
            'field' => 'bd',
            'label' => 'bd',
            'rules' => 'required|numeric|max_length[1]',
            'errors' =>array(
                'required' => 'Something went wrong.',
                'numeric' => 'Something went wrong.',
                'max_length' => 'Something went wrong.',
            ),
        ),
        array(
            'field' => 'ddno',
            'label' => 'ddno',
            'rules' => 'required|numeric|max_length[13]|is_unique[aptel_temp_payment.dd_no]',
            'errors' => array(
                'required' => 'Please enter Challan/Ref. Number.',
                'max_length' => 'Challan/Ref. Number max length 13.',
                'is_unique' => 'Provide unique Challan/Ref. Number.',
            ),
        ),
        array(
            'field' => 'dddate',
            'label' => 'dddate',
            'rules' => 'required|valid_date',
            'errors' => array(
                'required' => 'Date of Transction required.',
                'valid_date' => 'Required valid Date of Transction .',
            ),
        ),
        array(
            'field' => 'amountRs',
            'label' => 'amountRs',
            'rules' => 'required|numeric',
            'errors' => array(
                'required' => 'Fee amount required.',
                'numeric' => 'Fee amount numeric only.',
            ),
        ),

        ),
		
		
		/*add party*/
		'addMorePet' => array(
        array(
            'field' => 'salt',
            'label' => 'salt',
            'rules' => 'required|numeric|max_length[50]'
        ),array(
            'field' => 'resName',
            'label' => 'name',
            'rules' => 'required|max_length[100]'
        ),
        array(
            'field' => 'resAddress',
            'label' => 'Address',
            'rules' => 'alpha_numeric_spaces|max_length[100]'
        ),
        array(
            'field' => 'respincode',
            'label' => 'pincode',
            'rules' => 'numeric|exact_length[6]'
        ),
        array(
            'field' => 'resState',
            'label' => 'State',
            'rules' => 'numeric|max_length[6]'
        ),
        array(
            'field' => 'resDis',
            'label' => 'District',
            'rules' => 'numeric|max_length[6]'
        ),
        array(
            'field' => 'resMobile',
            'label' => 'Mobile',
            'rules' => 'numeric|exact_length[10]'
        ),
        array(
            'field' => 'resPhone',
            'label' => 'Phone',
            'rules' => 'numeric|max_length[15]'
        ),
        array(
            'field' => 'resFax',
            'label' => 'Fax',
            'rules' => 'numeric|max_length[15]'
        ),
        array(
            'field' => 'pan_code',
            'label' => 'Pancard',
            'rules' => 'pan_hash'
        ),
        array(
            'field' => 'totalNoRespondent',
            'label' => 'total No of Respondent',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'resEmail',
            'label' => 'email',
            'rules' => 'valid_email'
        ),

    ),
    'addMoreRes' => array(
        array(
            'field' => 'salt',
            'label' => 'salt',
            'rules' => 'required|numeric|max_length[50]'
        ),array(
            'field' => 'resName',
            'label' => 'name',
            'rules' => 'required|max_length[100]'
        ),
        array(
            'field' => 'resAddress',
            'label' => 'Address',
            'rules' => 'alpha_numeric_spaces|max_length[100]'
        ),
        array(
            'field' => 'respincode',
            'label' => 'pincode',
            'rules' => 'numeric|exact_length[6]'
        ),
        array(
            'field' => 'resState',
            'label' => 'State',
            'rules' => 'numeric|max_length[6]'
        ),
        array(
            'field' => 'resDis',
            'label' => 'District',
            'rules' => 'numeric|max_length[6]'
        ),
        array(
            'field' => 'resMobile',
            'label' => 'Mobile',
            'rules' => 'numeric|exact_length[10]'
        ),
        array(
            'field' => 'resPhone',
            'label' => 'Phone',
            'rules' => 'numeric|max_length[15]'
        ),
        array(
            'field' => 'resFax',
            'label' => 'Fax',
            'rules' => 'numeric|max_length[15]'
        ),
        array(
            'field' => 'pan_code',
            'label' => 'Pancard',
            'rules' => 'pan_hash'
        ),
        array(
            'field' => 'totalNoRespondent',
            'label' => 'total No of Respondent',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'resEmail',
            'label' => 'email',
            'rules' => 'valid_email'
        ),

    ),

    'editMoreRes' => array(
        array(
            'field' => 'id',
            'label' => 'salt',
            'rules' => 'required|numeric|max_length[50]'
        ),array(
            'field' => 'resName',
            'label' => 'name',
            'rules' => 'required|max_length[100]'
        ),
        array(
            'field' => 'resAddress',
            'label' => 'Address',
            'rules' => 'alpha_numeric_spaces|max_length[100]'
        ),
        array(
            'field' => 'respincode',
            'label' => 'pincode',
            'rules' => 'numeric|exact_length[6]'
        ),
        array(
            'field' => 'stateRes',
            'label' => 'State',
            'rules' => 'numeric|max_length[6]'
        ),
        array(
            'field' => 'ddistrictres',
            'label' => 'District',
            'rules' => 'numeric|max_length[6]'
        ),array(
            'field' => 'ddistrictname',
            'label' => 'District',
            'rules' => 'numeric|max_length[6]'
        ),
        array(
            'field' => 'resMobile',
            'label' => 'Mobile',
            'rules' => 'numeric|exact_length[10]'
        ),
        array(
            'field' => 'resPhone',
            'label' => 'Phone',
            'rules' => 'numeric|max_length[15]'
        ),
        array(
            'field' => 'resFax',
            'label' => 'Fax',
            'rules' => 'numeric|max_length[15]'
        ),
        array(
            'field' => 'pan_code',
            'label' => 'Pancard',
            'rules' => 'pan_hash'
        ),

        array(
            'field' => 'resEmail',
            'label' => 'email',
            'rules' => 'valid_email'
        ),
        array(
            'field' => 'edittype',
            'label' => 'type',
            'rules' => 'in_list[addparty,mainparty]'
        ),

    ),
	'forgaetpass' =>[
	           ['field'=>'loginid', 'label'=>'loginid','rules'=>'trim|required'],
	            ['field'=>'email', 'label'=>'email','rules'=>'trim|required'],
	            ['field'=>'skey_pass', 'label'=>'captcha','rules'=>'trim|required']
	        ],

);