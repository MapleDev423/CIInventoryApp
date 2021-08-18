<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planningsheets extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('planningsheets_model');
        $this->load->model('parts_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Planning Sheets';
		$this->mode='Add';               
	}


	public function index()
	{

		if(!checkModulePermission(15,1)){
			redirect('dashboard'); die;
		}

		$action=replaceEmpty('action');
		if($action!=''){
			if($this->planningsheets_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->planningsheets_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}
		
		$result=$this->planningsheets_model->getData();
               // print_r($result);die;
		$data['resultList']=array();;
                $data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_planningsheets',$data);
	}

	public function addedit($ID='')
	{
		if(!checkModulePermission(15,2)){
			redirect('dashboard'); die;
		}

		$details='';
		if($_POST){
                    //print_r($_POST);die;
			if($this->planningsheets_model->addedit()){
				redirect($this->main_page); die;
			}
		}
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->planningsheets_model->loadDataById($ID);
			//print_r($details); die;
                        $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
                        $data['partsList']=$partsList;
			$this->mode='Edit';
		}
                $this->load->model('manufacturer_model');
                $manufacturer_detail=$this->manufacturer_model->getData(1);
		$season=$this->planningsheets_model->getseason();
                $data['manufacturer']=$manufacturer_detail;
		$data['order_no_new']=date("mdY").'-'.rand(10000,99999);
		$data['details']=$details;
                $data['season']=$season;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_planningsheets',$data);
	}
        
        public function view($ID=''){
            if(!checkModulePermission(15,2)){
			redirect('dashboard'); die;
		}

		
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->planningsheets_model->loadDataById($ID);
			//print_r($details); die;
                        $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
                        $data['partsList']=$partsList;
			$this->mode='Edit';
		}
                $this->load->model('manufacturer_model');
                $manufacturer_detail=$this->manufacturer_model->getData(1);
		$season=$this->planningsheets_model->getseason();
                $data['manufacturer']=$manufacturer_detail;
		$data['details']=$details;
                $data['season']=$season;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('view_planningsheets',$data);
        }
        
        public function PO_Submit()
	{
		
		if($_POST){
                    
			if($this->planningsheets_model->PO_Submit()){
				echo 1;
			}
		}
		
	}
        
        public function deletepo($ID,$PID)
	{
		
		//if($_POST){
                    
			if($this->planningsheets_model->deletepo($ID)){
				redirect($this->main_page.'/addedit/'.$PID); die;
			}
		//}
		
	}

}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */