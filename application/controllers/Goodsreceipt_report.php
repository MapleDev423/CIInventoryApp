<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodsreceipt_report extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model('parts_model'); 
		$this->load->model('goodsreceiptreport_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Goods Receipt Report';
		$this->mode='Add';               
	}


	public function index()
	{
		if(!checkModulePermission(20,2)){
			redirect('dashboard'); die;
		}
			
		$details='';
		$details=$this->goodsreceiptreport_model->getData();
		//print_r($details);
		$manufacturer_detail=$this->goodsreceiptreport_model->getManufacturer();
		$part_details=$this->goodsreceiptreport_model->getPartsnameByManufacturer();
		
		$data['manufacturer']=$manufacturer_detail;
		$data['part_details']=$part_details;
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('report_goodsreceipt',$data);
	}
	

	
	
	
}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */