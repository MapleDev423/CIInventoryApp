<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaseorder extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('purchaseorder_model');
        $this->load->model('planningsheets_model');
        $this->load->model('parts_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Purchase Order';
		$this->mode='Add';
	}


	public function index()
	{

		if(!checkModulePermission(10,1)){
			redirect('dashboard'); die;
		}

		$action=replaceEmpty('action');
		if($action!=''){
			if($this->purchaseorder_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->purchaseorder_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}

		$result=$this->purchaseorder_model->getData();
               // print_r($result);die;
		$data['resultList']=array();;
                $data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_purchaseorder',$data);
	}

	public function addedit($ID='')
	{
		if(!checkModulePermission(10,2)){
			redirect('dashboard'); die;
		}

		$details='';
		if($_POST){
                    //print_r($_POST);die;
			if($this->purchaseorder_model->addedit()){
				redirect($this->main_page); die;
			}
		}
		$this->load->model('parts_model');
		if($ID!=''){
			$details=$this->purchaseorder_model->loadDataById($ID);
			//print_r($details); die;
                        $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
                        if($details->planningsheet_id>0){
                        $plannings=$this->planningsheets_model->getPlanningsS(1);
                        }
                        else{
                            $plannings=$this->planningsheets_model->getPlannings(1);
                        }
                        $data['plannings']=$plannings;
                        $data['partsList']=$partsList;
			$this->mode='Edit';

		}
                else{
                        $plannings=$this->planningsheets_model->getPlannings(1);
                        $data['plannings']=$plannings;
                }
                $this->load->model('manufacturer_model');
                $manufacturer_detail=$this->manufacturer_model->getData(1);
                $data['manufacturer']=$manufacturer_detail;
                $season=$this->planningsheets_model->getseason();
		$data['order_no_new']=date("mdY").'-'.rand(10000,99999);
		$data['details']=$details;
                $data['season']=$season;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_purchaseorder',$data);
	}

        public function view($ID='')
	{
		if(!checkModulePermission(10,2)){
			redirect('dashboard'); die;
		}


                $this->load->model('parts_model');

                $details=$this->purchaseorder_model->loadDataById($ID);
                //print_r($details); die;
                $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
                $plannings=$this->planningsheets_model->getPlanningsS(1);
                $data['plannings']=$plannings;
                $data['partsList']=$partsList;
                $this->mode='Edit';


                $this->load->model('manufacturer_model');
                $manufacturer_detail=$this->manufacturer_model->getData(1);
                $data['manufacturer']=$manufacturer_detail;
		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('view_purchaseorder',$data);
	}

         public function generatepo()
	{
		if($_POST){
                    //print_r($_POST);die;
			$rowid=$this->purchaseorder_model->generatepo();
				redirect($this->main_page.'/addedit/'.md5($rowid)); die;

		}
	}

        public function PI_Submit(){
		if($_POST){
                   //print_r($_POST); die;
			if($this->purchaseorder_model->PI_Submit()){
				echo $this->purchaseorder_model->PI_Submit();
				die;
			}
		}

	}

        public function deletepi($ID, $PID)
	{

		//if($_POST){

			if($this->purchaseorder_model->deletepi($ID)){
				redirect($this->main_page.'/addedit/'.$PID); die;
			}
		//}

	}

       public function generate_excel_file($ID='') {
         $this->load->model('parts_model');
		if($ID!=''){
			$details=$this->purchaseorder_model->loadDataById($ID);
			//print_r($details); die;
                        $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
                        if($details->planningsheet_id>0){
                        $plannings=$this->planningsheets_model->getPlanningsS(1);
                        }
                        else{
                            $plannings=$this->planningsheets_model->getPlannings(1);
                        }
                        $data['plannings']=$plannings;
                        $data['partsList']=$partsList;
			$this->mode='Edit';

		}
                else{
                        $plannings=$this->planningsheets_model->getPlannings(1);
                        $data['plannings']=$plannings;
                }

                $this->load->model('manufacturer_model');
                $manufacturer_detail=$this->manufacturer_model->getData(1);
                $data['manufacturer']=$manufacturer_detail;
               // $season=$this->planningsheets_model->getseason();
		$data['order_no_new']=date("mdY").'-'.rand(10000,99999);
		$data['details']=$details;
                //$data['season']=$season;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->load->view('spreadsheet_po',$data);
		return;
    }
}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */