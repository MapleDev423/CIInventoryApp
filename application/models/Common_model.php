<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
	public $MESSAGE;
	public function getwebsiteconfig($value='')
	{
		$this ->db->select('*');
		$this->db->from('ffc_websitesetting');
		$this->db->where('ID',1);
		$result=$this->db->get()->row();
		return $result;
	}
	public function update_websiteconfig($value='')
	{
		$this->MESSAGE= $this->config->item('MESSAGE');
		
		$postData=$this->input->post();

		$updateData=array('website_name'=>$postData['website_name'],
						  'pagination'=>$postData['pagination'],
						  'smtpmail_host'=>$postData['smtpmail_host'],
						  'smtpmail_port'=>$postData['smtpmail_port'],
						  'smtpmail_mail'=>$postData['smtpmail_mail'],
						  'smtpmail_password'=>$postData['smtpmail_password'],
						  'updation_date'=>date("Y-m-d H:i:s"),
						  'updated_by'=>$this->LOGINID,
						  );
		//print_r($updateData); die;
		$this->db->where('ID',1);
		$this->db->update('ffc_websitesetting',$updateData);

		setFlashMsg('success_message',$this->MESSAGE['SITECONFIG_UPDATE'],'alert-success');
		$result=$this->setSiteConfig();
		return true;
	}

	public function setSiteConfig($value='')
	{
		$result=$this->getwebsiteconfig();
		//print_r($result);
		$this->config->set_item('WEBSITE_NAME',$result->website_name);

		$this->config->set_item('SMTPEMAIL_HOST',$result->smtpmail_host);
		$this->config->set_item('SMTPEMAIL_PORT',$result->smtpmail_port);
		$this->config->set_item('SMTPEMAIL_EMAIL',$result->smtpmail_mail);
		$this->config->set_item('SMTPEMAIL_PASS',$result->smtpmail_password);

		

	}
	public function getModules($value='')
	{
		$this ->db->select('*');
		$this->db->from('ffc_modules');
		$this->db->where('status',1);
		$this->db->where('parent_id',0);
		$this->db->order_by('position','ASC');
		$result=$this->db->get()->result();
		if ($result) {
			foreach ($result as $key => $value) {
				$this ->db->select('*');
				$this->db->from('ffc_modules');
				$this->db->where('status',1);
				$this->db->where('parent_id',$value->ID);
				$this->db->order_by('position','ASC');
				$result2=$this->db->get()->result();
				$value->childlist=$result2;
			}			
		}
		return $result;
	}

	public function modulePermission($value='')
	{
		$premissionModule=array();
		$LOGINID=$this->LOGINID;
		$this ->db->select('*');
		$this->db->from('ffc_employee_rolemodule');
		$this->db->where('employee_id',$LOGINID);
		$result=$this->db->get()->result();
		if($result){
			foreach ($result as  $value) {
				$premissionModule[$value->module_id][]=$value->event_id;
			}
		}
		$this->config->set_item('MODULE_PERMISSION',$premissionModule);
		//print_r($premissionModule); die;
		return $premissionModule;
	}
	public function getColor($only_name=0)
	{
		$this ->db->select('*');
		$this->db->from('ffc_colors');
		$this->db->where('status',1);
		$this->db->order_by('name',"ASC");
		$result=$this->db->get()->result();
		if($only_name==1){ $result1=array();
			foreach ($result as $key => $value) {
				$result1[]=$value->name;
			}
			$result=array();
			$result=$result1;
		}
		return $result;
	}

	public function getUnit()
	{
		$this ->db->select('*');
		$this->db->from('ffc_unit');
		$this->db->where('status',1);
		$result=$this->db->get()->result();
		return $result;
	}

}

/* End of file Common_model.php */
/* Location: ./application/models/Common_model.php */