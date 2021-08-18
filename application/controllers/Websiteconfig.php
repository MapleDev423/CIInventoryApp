<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Websiteconfig extends MY_Controller {
	public $main_page;
	public function __construct()
	{
		parent::__construct();
		$this->main_page=base_url('/'.strtolower(get_class($this)));
		$this->heading='Site Setting';
	}
	
	public function index()
	{
		if(!checkModulePermission(2,1)){
			redirect('dashboard'); die;
		}
		
		$data['main_page']=$this->main_page;
		$data['heading']=$this->heading;

		if($_POST){
			$this->common_model->update_websiteconfig();
			redirect($this->main_page);
		}

		$result=$this->common_model->getwebsiteconfig();
		$data['details']=$result;
		$this->layout('websiteconfig',$data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */