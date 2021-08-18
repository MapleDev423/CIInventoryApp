<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Products';
		$this->load->model('products_model');
	}
	public function index()
	{
		if(!checkModulePermission(7,1)){
                  redirect('dashboard'); die;
                }
        
		$result=$this->products_model->getData();
		$data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_products',$data);
	}
        public function product_boms($id='')
        {  
            if(!checkModulePermission(5,1)){
                     redirect('dashboard'); die;
                }
        
		$result=$this->products_model->getBomByProduct($id);
               // print_r($result);die;
		$data['bomList']=$result->bomList;
		$data['main_page']=$this->main_page;
		$data['heading']=$result->name;
		$this->layout('product_boms',$data);
        }

    public function addedit($ID='')
    {
        if(!checkModulePermission(7,2)){
            redirect('dashboard'); die;
        }

        $details='';
        if($_POST){
            if($this->products_model->addedit()){
                redirect($this->main_page); die;
            }
        }

        if($ID!=''){
            $details=$this->products_model->loadDataById($ID);
            //print_r($details); die;
            $this->mode='Edit';
        }

        $data['details']=$details;
        $data['mode']=$this->mode;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
        $this->layout('addedit_products',$data);
    }



}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */