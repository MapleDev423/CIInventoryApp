<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parts extends MY_Controller {
    public $mode;
	public function __construct()
	{
            parent::__construct();        
            $this->main_page=base_url('/'.strtolower(get_class($this)));
            $this->heading='Parts';
            $this->load->model('parts_model');
            $this->mode='Add';
	}
	public function index()
	{   
        if(!checkModulePermission(5,1)){
            redirect('dashboard'); die;
        }

        $action=replaceEmpty('action');
        if($action!=''){
                if($this->parts_model->singleAction()){
                        redirect($this->main_page); die;
                }
        }elseif ($_POST && isset($_POST['bulk_action'])) {
                if($this->parts_model->bulkAction()){
                        redirect($this->main_page); die;
                }
        }

        $result=$this->parts_model->getData();
        
        $manufacturer_detail=$this->manufacturer_model->getData(1);
        $data['resultList']=$result;
        $data['manufacturer']=$manufacturer_detail;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
        $this->layout('manage_parts',$data);
	}

    public function addedit($ID='')
	{  
           if(!checkModulePermission(5,2)){
                redirect('dashboard'); die;
            } 
            $details='';
            if($_POST){
                if($this->parts_model->addedit()){
                        redirect($this->main_page); die;
                }
            }

            if($ID!=''){                   
                $details=$this->parts_model->loadDataById($ID);
                $this->mode='Edit';
                if($details->other_part_type==1){
                    $partsTypeDetails=$this->parts_model->partTypeDetails($details->part_type);
                    $details->part_type_title=$partsTypeDetails->title;
                    $details->part_type_other_id=$details->part_type;
                }
                
            }
            
            //print_r($details); die;
            $this->load->model('manufacturer_model');
            $manufacturer_detail=$this->manufacturer_model->getData(1);
            $colorList=$this->common_model->getColor();
            if($details && $details->other_part_type==1){
                $partsTypeList=$this->parts_model->getPartsType($details->part_type);
            }else{
                $partsTypeList=$this->parts_model->getPartsType();
            }
            
            if($ID!='')
			{
				$data['historical']= $this->parts_model->gethistorical($details->ID);
				$data['future']= $this->parts_model->getfuture($details->ID,16000);	
			}
            
            /*
			if($details->ID!='')
			{
				$data['historical']= $this->parts_model->gethistorical($details->ID);
				$data['future']= $this->parts_model->getfuture($details->ID,16000);	
			}
            */
			$data['testid'] = $ID;
            $data['manufacturer_detail']=$manufacturer_detail;
            $data['mode']=$this->mode;
            $data['colorList']=$colorList;
            $data['partsTypeList']=$partsTypeList;
            $data['details']=$details;
			
            $data['main_page']=$this->main_page;
            $data['heading']=$this->heading;
            $this->layout('addedit_parts',$data);
	}
	
	

	
}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */