<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockissue extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('stockissue_model');
		//$this->load->model('manufacturer_model');
		$this->load->model('employee_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Stock Issue';
		$this->mode='Add';               
	}


	public function index()
	{

		if(!checkModulePermission(12,1)){
			redirect('dashboard'); die;
		}

		$action=replaceEmpty('action');
		if($action!=''){
			if($this->stockissue_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->stockissue_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}
		
		$result=$this->stockissue_model->getData();
		$data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_stockissue',$data);
	}

	public function addedit($ID='')
	{
		if(!checkModulePermission(12,2)){
			redirect('dashboard'); die;
		}

		$details='';
		if($_POST){
            //print_r($_POST);die;
			if($this->stockissue_model->addedit()){
				redirect($this->main_page); die;
			}
		}
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->stockissue_model->loadDataById($ID);
			//print_r($details); die;
			$this->mode='Edit';
		}
               
		$manufacturer_detail=$this->stockissue_model->getManufacturer();
		$employee_detail=$this->employee_model->getData($is_active='1',$role_id='');
		$data['manufacturer']=$manufacturer_detail;
		$data['employee_detail']=$employee_detail;
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_stockissue',$data);
	}

	
		public function view($ID='')
	{
		if(!checkModulePermission(12,2)){
			redirect('dashboard'); die;
		}

		$details='';
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->stockissue_model->loadDataById($ID);
			//print_r($details); die;
			$this->mode='Edit';
		}
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']='View Stock Issue';
		$this->layout('view_stockissue',$data);
	}
	
}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */