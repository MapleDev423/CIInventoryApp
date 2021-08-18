<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {
	public $mode;
	public function __construct()
	{
        parent::__construct();
        $this->load->model('employee_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Employee';
		$this->mode='Add';
	}
	public function index()
	{
		if(!checkModulePermission(4,1)){
			redirect('dashboard'); die;
		}

		$action=replaceEmpty('action');
		if($action!=''){
			if($this->employee_model->singleAction()){
				redirect($this->main_page); die;
			}
		}elseif ($_POST && isset($_POST['bulk_action'])) {
			if($this->employee_model->bulkAction()){
				redirect($this->main_page); die;
			}
		}
		
		$result=$this->employee_model->getData();
		$data['resultList']=$result;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('manage_employee',$data);
	}

	public function addedit($ID='')
	{
		if(!checkModulePermission(4,2)){
			redirect('dashboard'); die;
		}

		$details='';
		if($_POST){
			if($this->employee_model->addedit()){
				redirect($this->main_page); die;
			}
		}

		if($ID!=''){
			$details=$this->employee_model->loadDataById($ID);
			//print_r($details); die;
			$this->mode='Edit';
		}

		$this->load->model('role_model');
		$roleList=$this->role_model->getData(1);

		$data['details']=$details;
		$data['mode']=$this->mode;
		$data['roleList']=$roleList;
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;
		$this->layout('addedit_employee',$data);
	}

	public function changepassword()
	{
		
		$id= $this->LOGINID;

			//print_r($userDetail);die;
			if($_POST){

			$this->form_validation->set_message('min_length','New password must be minimum 6 characters long ');
			$this->form_validation->set_rules('oldpwd','Current password','required');
			$this->form_validation->set_rules('newpwd','New password','trim|required|matches[confirmnewpwd]|min_length[6]');
			$this->form_validation->set_rules('confirmnewpwd','Confirm new password','trim|required');
			$this->form_validation->set_message('required', '%s field is required.');
				if($this->form_validation->run() == TRUE)
				{
					if($this->employee_model->loadDataById($id)){
						
							if($this->employee_model->changePassword($id)){
								redirect('employee/changepassword');
							}
							else{
								redirect('employee/changepassword');
							}
							
					}				
					
				}
			}

		$data['main_page']=$this->main_page;
		$data['heading']='Change Password';
		$this->layout('changepassword',$data);
	
    }
    public function myprofile()
	{
            $id= $this->LOGINID;
            $employee_detail = $this->employee_model->loadDataById($id);
            $oldfile_name = $employee_detail->profile_pic;
           // print_r($employee_detail);die;
            if($_POST){
                //print_r($_POST);die;
                $result= $this->employee_model->updateEmployeeProfile($id,$oldfile_name);
		 redirect('employee/myprofile');				
            }
            $data['employee_detail']=$employee_detail;       
            $data['main_page']= base_url('dashboard');
            $data['heading']="Profile";
            $this->layout('myprofile',$data);
	}
}

/* End of file Employee.php */
/* Location: ./application/controllers/Employee.php */