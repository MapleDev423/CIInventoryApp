<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockledger_report extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model('parts_model'); 
		$this->load->model('stockledgerreport_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Stock Ledger Report';
		$this->mode='Add';               
	}


	public function index()
	{
		if(!checkModulePermission(21,2)){
			redirect('dashboard'); die;
		}
			
		$details='';
		$details=$this->stockledgerreport_model->getData();
		//print_r($details);
		$manufacturer_detail=$this->stockledgerreport_model->getManufacturer();
		//$part_details=$this->stockledgerreport_model->getPartsnameByManufacturer();
		
		$data['manufacturer']=$manufacturer_detail;
		//$data['part_details']=$part_details;
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('report_stockledger',$data);
	}
	

	
	
	
}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */