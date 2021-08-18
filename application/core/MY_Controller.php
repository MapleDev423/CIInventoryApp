<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $login_data,$LOGINID,$premissionModule;
	public function __construct()
	{
		parent::__construct();
		$SES_PREFIX=$this->config->item('SESSION_PREFIX'); 
		$this->login_data=$this->session->userdata($SES_PREFIX.'login_data');
		if(empty($this->login_data)){
			redirect('/');
		}

		$this->LOGINID=$this->login_data->id;
		$this->common_model->setSiteConfig();
		$this->premissionModule=$this->common_model->modulePermission();
		
	}
	public function layout($page='',$data='')
	{
		
		$login_data = $this->login_data;
		$data['ASSETS_DIR']= $this->config->item('ASSETS_DIR');
		$data['CSS_DIR']= $this->config->item('CSS_DIR');
		$data['JS_DIR']= $this->config->item('JS_DIR');
		$data['IMG_DIR']= $this->config->item('IMG_DIR');
		$data['ASSEST_DIR']= $this->config->item('ASSETS_DIR');
		$data['COMP_DIR']= $this->config->item('COMP_DIR');
		$data['BASE_URL']= base_url();
		$data['LOGIN_DATA']= $login_data;
		$data['MODULE_LIST']=$this->common_model->getModules();
		$data['MODULE_PERMISSION']=$this->premissionModule;
		//print_r($data); die;
		$data['header_start']=$this->load->view('includes/header_start',$data,TRUE);

		$data['header_end']=$this->load->view('includes/header_end',$data,TRUE);
		
 		$data['menu']=$this->load->view('includes/menu',$data,TRUE);

 		$data['footer_start']=$this->load->view('includes/footer_start',$data,TRUE);

		$data['footer_end']=$this->load->view('includes/footer_end','',TRUE);


		$this->load->view($page,$data);



	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */