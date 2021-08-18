<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacture_planning extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('manufacture_planning_model');
		//$this->load->model('manufacturer_model');
		$this->load->model('products_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Manufacture Planning';
		$this->mode='Add';               
	}


	public function index()
	{

		if(!checkModulePermission(12,1)){
			redirect('dashboard'); die;
		}

		$action=replaceEmpty('action');
		if($action!=''){
			if($this->manufacture_planning_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->manufacture_planning_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}
		
		$result=$this->manufacture_planning_model->getData();
		$data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_manufactureplanning',$data);
	}

	public function addedit($ID='')
	{
		//if(!checkModulePermission(12,2)){
		//	redirect('dashboard'); die;
		//}

		$details='';
		if($_POST){
            //print_r($_POST);die;
			if($this->manufacture_planning_model->addedit()){
				redirect($this->main_page); die;
			}
		}
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->manufacture_planning_model->loadDataById($ID);
			//print_r($details); die;
			$this->mode='Edit';
		}
        	$product_detail=$this->products_model->getData(); 
		$assemblyline_detail=$this->manufacture_planning_model->get_assemblyline();
		$manufacturer_detail=$this->manufacture_planning_model->getManufacturer();
		$data['manufacturer']=$manufacturer_detail;
		$data['product_detail']=$product_detail;
		$data['assemblyline_detail']=$assemblyline_detail;
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_manufactureplanning',$data);
	}

	
		public function view($ID='')
	{
		if(!checkModulePermission(12,2)){
			redirect('dashboard'); die;
		}

		$details='';
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->manufacture_planning_model->loadDataById($ID);
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