<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('invoice_model');
        $this->load->model('purchaseorder_model');
        $this->load->model('planningsheets_model');
        $this->load->model('parts_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Proforma Invoice';
		$this->mode='Add';               
	}


	public function index()
	{

		if(!checkModulePermission(16,1)){
			redirect('dashboard'); die;
		}

		$action=replaceEmpty('action');
		if($action!=''){
			if($this->invoice_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->invoice_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}
		
		$result=$this->invoice_model->getData();
               // print_r($result);die;
		$data['resultList']=array();
                $data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_invoice',$data);
	}

	public function addedit($ID='')
	{
		if(!checkModulePermission(16,2)){
			redirect('dashboard'); die;
		}

		$details='';
		if($_POST){
                    //print_r($_POST);die;
			if($this->invoice_model->addedit()){
				redirect($this->main_page); die;
			}
		}
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->invoice_model->loadDataById($ID);
			//print_r($details); die;
                        $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
                        if($details->porderid>0){
                            $plannings=$this->purchaseorder_model->getPOrderS(1);
                        }
                        else{
                            $plannings=$this->purchaseorder_model->getPOrder(1);
                        }
                        
                        $data['porders']=$plannings;
                        $data['partsList']=$partsList;
			$this->mode='Edit';
                        
		}
                else{
                        $plannings=$this->purchaseorder_model->getPOrder(1);
                        $data['porders']=$plannings;
                }
                $this->load->model('manufacturer_model');
                $manufacturer_detail=$this->manufacturer_model->getData(1);
                $data['manufacturer']=$manufacturer_detail;
                
		//$data['order_no_new']=date("mdY").'-'.rand(10000,99999);
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_invoice',$data);
	}
        
         public function generatepi()
	{
             //print_r($_POST);die;
		if($_POST){
                    //print_r($_POST);die;
			$rowid=$this->invoice_model->generatepi();
				redirect($this->main_page.'/addedit/'.md5($rowid)); die;
			
		}
	}
        
         public function generateperforma()
	{
		if($_POST){
                    //print_r($_POST);die;
			$rowid=$this->invoice_model->generateperforma();
				redirect($this->main_page); die;
			
		}
	}
        
        public function view($ID='')
	{
		if(!checkModulePermission(16,2)){
			redirect('dashboard'); die;
		}

		
                $this->load->model('parts_model');

                $details=$this->invoice_model->loadDataById($ID);
                //print_r($details); die;
                $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
                $plannings=$this->purchaseorder_model->getPOrderS(1);
                $data['porders']=$plannings;
                $data['partsList']=$partsList;
                $this->mode='Edit';
                        
		
                $this->load->model('manufacturer_model');
                $manufacturer_detail=$this->manufacturer_model->getData(1);
                $data['manufacturer']=$manufacturer_detail;
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('view_invoice',$data);
	}
        
       

}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */