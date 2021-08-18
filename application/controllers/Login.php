<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct($value='')
	{
		parent::__construct();
		$this->load->model('login_model');
		$this->load->helper('cookie');
	}
	public function index()
	{
		$data['credential']='';
		if(get_cookie('remember_me')!='')
                    {
                            $data['credential'] =(object) unserialize(get_cookie('remember_me'));
                            //print_r($data['credential']);die;
                    }
		if($_POST){
			if($this->login_model->checkLogin()){
				redirect(base_url('/dashboard')); die;
			}
		}

		if(getSession('login_data')){
			redirect(base_url('/dashboard')); die;
		}

		$this->load->view('index',$data);
	}
    public function forgotPassword()
     { 
		if($_POST){

			$this->login_model->forgotPassword();	
		}	
     	
   	    $data["title"] = 'Forgot Password';
   	    $this->load->view('forgotPassword',$data);
   }
    public function resetPassword()
    {
    	
        $header['bodyClass'] = 'single-bg';
        $header['pageTitle'] = 'Reset Password';
        $expire = $this->config->item('reset_url_duration');
        if(isset($_GET['link'])){
          $linkurl = $_GET['link'];
        }
        else if(isset($_POST['link'])){
           $linkurl = $_POST['link'];
        }
        
        $data['myurl'] = '';
        
	    $link = base64_decode($linkurl);
	    $link = str_replace("|",",",$link);
	    $linkarr = explode(",",$link);
       //print_r($linkarr);die;
	    $id = $linkarr[0];
	    $time = $linkarr[1]+$expire;

	    $presenttime = time();

	   if($presenttime>$time){

	   		echo "Your session has been expired.";die;
	   }

       if($_POST)
            {
                $this->form_validation->set_rules('newpassword','New password', 'trim|required|matches[confirmpassword]|min_length[6]');
                $this->form_validation->set_rules('confirmpassword',' confirm password', 'required|trim');
                
                if($this->form_validation->run()== TRUE)
                {
                   
                	$this->login_model->resetPassword($id);
                    redirect(base_url('login'));
                }
            }
           $data['myurl'] = $linkurl;
           $data["title"] = 'Reset Password';
          
          $this->load->view('resetPassword',$data);
        
    }
	public function logout()
	{	
	
		unset_Session("login_data");
		$this->session->sess_destroy();
		redirect('/');
	}
}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */