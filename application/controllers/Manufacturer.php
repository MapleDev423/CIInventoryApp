<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer extends MY_Controller {

	public function __construct()
	{
            parent::__construct();
            $this->main_page=base_url('/'.strtolower(get_class($this)));
            $this->heading='Manufacturer';
            $this->load->model('manufacturer_model');
	}
	public function index()
	{
		if(!checkModulePermission(6,1)){
			redirect('dashboard'); die;
		}

            $action=replaceEmpty('action');
            if($action!=''){
                    if($this->manufacturer_model->singleAction()){
                            redirect($this->main_page); die;
                    }
            }elseif ($_POST && isset($_POST['bulk_action'])) {
                    if($this->manufacturer_model->bulkAction()){
                            redirect($this->main_page); die;
                    }
            }

            $result=$this->manufacturer_model->getData();
            $data['resultList']=$result;
            $data['main_page']=$this->main_page;
            $data['heading']=$this->heading;
            $this->layout('manage_manufacturer',$data);
	}

	public function addedit($ID='')
	{  
		if(!checkModulePermission(6,2)){
			redirect('dashboard'); die;
		}

            $details='';
		if($_POST){
			if($this->manufacturer_model->addedit()){
				redirect($this->main_page); die;
			}
		}

		if($ID!=''){
			$details=$this->manufacturer_model->loadDataById($ID);
			//print_r($details); die;
		}

		$data['details']=$details;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_manufacturer',$data);
	}

	
}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */