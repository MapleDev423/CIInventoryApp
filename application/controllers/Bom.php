<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bom extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('role_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Bom';
		$this->mode='Add';
        $this->load->model('bom_model');
	}
	public function index()
	{

		if(!checkModulePermission(8,1)){
			redirect('dashboard'); die;
		}

		$action=replaceEmpty('action');
		if($action!=''){
			if($this->bom_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->bom_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}
		
		$result=$this->bom_model->getData();
		$data['resultList']=$result;

		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_bom',$data);
	}

	public function addedit($ID='')
	{
		if(!checkModulePermission(8,2)){
			redirect('dashboard'); die;
		}

		$details='';
		if($_POST){
                   // print_r($_POST);die;
			if($this->bom_model->addedit()){
				redirect($this->main_page); die;
			}
		}

		if($ID!=''){
			$details=$this->bom_model->loadDataById($ID);
			//print_r($details); die;
			$this->mode='Edit';
		}

		$this->load->model('products_model');
		$productsList=$this->products_model->getData();
               
		$this->load->model('manufacturer_model');
		$manufacturerList=$this->manufacturer_model->getData(1);

		$this->load->model('parts_model');
		//$partsList=$this->parts_model->getData(1);

		$unitList=$this->common_model->getUnit();

		$data['details']=$details;
		$data['mode']=$this->mode;
		$data['productsList']=$productsList;
        $data['manufacturerList']=$manufacturerList;
        $data['unitList']=$unitList;
        //$data['partsList']=$partsList;

		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_bom',$data);
	}

	
}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */