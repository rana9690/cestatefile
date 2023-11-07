<?php defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model
{
	protected $userData;
	protected $user_id;
	protected $role;
	protected $org_name;

	public function __construct()
	{
		parent::__construct();
		if(!empty($this->session->userdata('login_success')))
		{
			$this->userData=$this->session->userdata('login_success');
			$this->user_id=$this->userData[0]->id;
			$this->org_name=$this->userData[0]->org_name;
			$this->role=$this->userData[0]->role;
		}
	}

	public function getRoleBasedParams()
	{
		$org_code=(int)$this->org_name;
		switch($this->role):
			case 2: //nodel
				$params=['cd.user_id'=>$this->user_id];
				$cdparams=["cd.status<>'W'"=>null,"(cd.pet_org_id=$org_code or cd.res_org_id=$org_code or cd.user_id=$this->user_id )"=>null,"cd.user_id >10000"=>null];
				$cdregparams=["cd.status<>'W'"=>null,"(cd.pet_org_id=$org_code or cd.res_org_id=$org_code or cd.user_id=$this->user_id )"=>null,"cd.user_id >10000"=>null];
				$appparams=["app.status<>'W'"=>null,"(cd.pet_org_id=$org_code or cd.res_org_id=$org_code or app.user_id=$this->user_id )"=>null,'app.user_id >10000'=>null];
				$codparams=["cod.status<>'W'"=>null,"(cd.pet_org_id=$org_code or cd.res_org_id=$org_code or cod.user_id=$this->user_id )"=>null,'cod.user_id >10000'=>null];
				break;
			case 3: //ar
				$params=['cd.user_id'=>$this->user_id];
				$zonedata=$this->db->select('zone')->get_where('org_name_master',['org_code'=>$org_code])->row_array();
				$cdparams=["cd.status<>'W'"=>null,'cd.pet_representative'=>$zonedata['zone'],"cd.user_id >10000 or cd.user_id=$this->user_id"=>null];
				$cdregparams=["cd.status<>'W'"=>null,'cd.pet_representative'=>$zonedata['zone'],"cd.user_id >10000 or cd.user_id=$this->user_id"=>null];
				$appparams=["app.status<>'W'"=>null,'cd.pet_representative'=>$zonedata['zone'],"app.user_id >10000 or app.user_id=$this->user_id"=>null];
				$codparams=["cod.status<>'W'"=>null,'cd.pet_representative'=>$zonedata['zone'],"cod.user_id >10000 or cod.user_id=$this->user_id"=>null];
				break;

			default: //0,1
				$params=['cd.user_id'=>$this->user_id];
				$cdparams=["cd.status<>'W'"=>null,'cd.user_id'=>$this->user_id];
				$cdregparams=["cd.status<>'W'"=>null,"(cd.user_id =$this->user_id or cd.filing_no in (select mp.map_filing_no as filing_no from case_detail_maping as mp where mp.map_user_id=$this->user_id) )"=>null];
				$appparams=["app.status<>'W'"=>null,'app.user_id'=>$this->user_id];
				$codparams=["cod.status<>'W'"=>null,'cod.user_id'=>$this->user_id];
		endswitch;
		return [
			'params'=>$params,
			'cdparams'=>$cdparams,
			'cdregparams'=>$cdregparams,
			'appparams'=>$appparams,
			'codparams'=>$codparams,
		];

	}
	
	
	public function getRoleBasedParamsForDocuments()
	{
		$org_code=(int)$this->org_name;
		switch($this->role):
			case 2: //nodel
				$params=["cd.user_id in(select id from efiling_users where org_name=$org_code)"=>null];
				break;
			case 3: //ar
				$params=[];
				break;
			default: //0,1
				$params=["(cd.user_id =$this->user_id or cd.filing_no in (select mp.map_filing_no as filing_no from case_detail_maping as mp where mp.map_user_id=$this->user_id) )"=>null];

		endswitch;
		return [
			'params'=>$params,
		];

	}
}
