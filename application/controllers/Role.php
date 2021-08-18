<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {
	public $main_page,$mode;
	public function __construct()
	{
		parent::__construct();
		$this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Role';
		$this->load->model('role_model');
		$this->mode='Add';
	}

	public function index()
	{

		if(!checkModulePermission(3,1)){
			redirect('dashboard'); die;
		}
		$action=replaceEmpty('action');
		if($action!=''){
			if($this->role_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->role_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}

		$result=$this->role_model->getData();
		$data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_role',$data);
	}

	public function addedit($ID='')
	{
		if(!checkModulePermission(3,2)){
			redirect('dashboard'); die;
		}

		$details='';
		if($_POST){
			if($this->role_model->addedit()){
				redirect($this->main_page); die;
			}
		}

		if($ID!=''){
			$details=$this->role_model->loadDataById($ID);
			//print_r($details); die;
			$this->mode='Edit';
		}

		$data['details']=$details;
		$data['mode']=$this->mode;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_role',$data);
	}

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */