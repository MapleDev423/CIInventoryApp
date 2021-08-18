<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//var_dump("124234234");

	}
	public function index()
	{
		//var_dump("124234234");
		$this->load->model('dashboard_model');
		$data=$this->dashboard_model->getTotalRecords();
		$this->layout('dashboard',$data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */