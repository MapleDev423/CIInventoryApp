<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assemblyline extends MY_Controller {
    public $mode;
	public function __construct()
	{
            parent::__construct();        
            $this->main_page=base_url('/'.strtolower(get_class($this)));
            $this->heading='Assembly line';
            $this->load->model('assemblyline_model');
            $this->mode='Add';
	}
	public function index()
	{   
        if(!checkModulePermission(23,1)){
            redirect('dashboard'); die;
        }

        $action=replaceEmpty('action');
        if($action!=''){
                if($this->assemblyline_model->singleAction()){
                        redirect($this->main_page); die;
                }
        }elseif ($_POST && isset($_POST['bulk_action'])) {
                if($this->assemblyline_model->bulkAction()){
                        redirect($this->main_page); die;
                }
        }
		
        $result=$this->assemblyline_model->getData();
        $data['resultList']=$result;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
        $this->layout('manage_assemblyline',$data);
	}

        public function addedit($ID='')
	{  
           if(!checkModulePermission(23,2)){
                redirect('dashboard'); die;
            } 
            $details='';
            if($_POST){
                if($this->assemblyline_model->addedit()){
                        redirect($this->main_page); die;
                }
            }

            if($ID!=''){                  
                $details=$this->assemblyline_model->loadDataById($ID);
                $this->mode='Edit';
            }
            $data['mode']=$this->mode;
			$data['details']=$details; 
            $data['main_page']=$this->main_page;
            $data['heading']=$this->heading;
            $this->layout('addedit_assemblyline',$data);
	}

	
}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */