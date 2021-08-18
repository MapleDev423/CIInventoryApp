<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public $MESSAGE;
	public function __construct()
    {
		parent::__construct();
		$this->MESSAGE= $this->config->item('MESSAGE');
		$this->common_model->setSiteConfig();
	}
	public function checkLogin($value='')
	{
		
		$postedArr = $this->input->post(); //print_r($postedArr); die;
		$username = trim($postedArr['email']);
		$password = trim($postedArr['pwd']);
		$remember_me = (isset($postedArr['rememberme']))?trim($postedArr['rememberme']):'';
		
		if($username != '' || $username != null){
			
			$this ->db->select('*');
			$this->db->from('ffc_employee');
			$this->db->where('is_deleted',0);
			$this->db->where("(email ='".$username."' OR username='".$username."')");
//			$this->db->where('password',md5($password));
			$this->db->where('password',"123");

			$row= $this->db->get()->row();

			if(count(array($row))>0){
				
				if($row->status == '1') {				
					$login_data=(object)array('id'=>$row->ID,'role_id'=>$row->role_id,'name'=>$row->first_name.' '.$row->last_name,'profile_pic'=>$row->profile_pic);
					//	print_r($login_data); die;
					setSession("login_data",$login_data);
				
					if(!empty($remember_me) && $remember_me == 1)
					{ 
					  $expire = $this->config->item('remember_me_duration');
					  $cookie = array(
					    'name'   => 'remember_me',
					    'value'  => serialize(array('email'=>$row->email,'password'=>$password)),
					    'expire' =>$expire  // Two weeks
					    
					);

				
					set_cookie($cookie);
					}
					else{

						delete_cookie('remember_me');
					}

					return true;
					redirect(base_url('/dashboard')); die;
				}
				else{

					setFlashMsg('success_message',$this->MESSAGE['NOTACTIVE_USER'],'alert-success');
					return false;
				}
				
			}
			else{

				setFlashMsg('success_message',$this->MESSAGE['WRONG_USER'],'alert-danger');
				return false;
			}
			
		}
	}
public function forgotPassword($value='')
{
	$email = $this->input->post('email');
	$userData = $this->db->get_where('ffc_employee', array('email' => $email))->row();
	//print_r($userData);die;

	
    if(!empty($userData))
		{

			$email_template = getTemplateData(1);
			
			$url = base_url('login/resetPassword?link='.base64_encode(md5($userData->ID).'|'.time()));
			$mail_body = str_replace('[URL]',$url,$email_template->mail_body);
			//print_r($mail_body);die;

			if($userData->status == '1')
			{
				$from = 'singh.monika0216@gmail.com';
				$to = $email;
				$subject=$email_template->subject;
				$message= $mail_body;	
			
				send_mail('',$to,$subject,$message);
				
				setFlashMsg('success_message',$this->MESSAGE['PASSWORD_RESET_MESSAGE'],'alert-success');
				
				redirect(base_url('login'));
							
			}
			else
			{
				setFlashMsg('success_message',$this->MESSAGE['DEACTIVATE_MESSAGE'],'alert-danger');
				redirect(base_url('login/forgotPassword'));
			}
	}
	else
	{
		setFlashMsg('success_message',$this->MESSAGE['EMAIL_NOT_EXIT'],'alert-danger');
			redirect(base_url('login/forgotPassword'));
	}
			

}
 public function resetPassword($id='')
    {
    	
        $newpassword=$this->input->post('newpassword');
        $confirmpassword=$this->input->post('confirmpassword');
        $newpassword=md5($newpassword);
        $newpwd = array('password'=>$newpassword);
        $this->db->where(array('MD5(ID)'=>$id));
        $this->db->update('ffc_employee',$newpwd);
        //echo $this->db->last_query();die;

        setFlashMsg('success_message',$this->MESSAGE['PASSWORD_SUCCESS_MESSAGE'],'alert-success');
        return true;

    }
  public function loadDataById($id='')
	{
		if($id!=''){
			$id=(is_numeric($id))?md5($id):$id;
			$this ->db->select('*');
			$this->db->from('ffc_employee');
			$this->db->where(array('MD5(ID)'=>$id));
			$result= $this->db->get()->row();
			//print_r($result);die;
			return $result;
		}
		
	}
	public function updateUserPassword($id='')
    {
    	if($id!=''){

	    	$id=(is_numeric($id))?md5($id):$id;
	        $password=$this->input->post('password');
	        $updateData = array('password'=>md5($password),'invitation_status'=>1);
	        $this->db->where(array('MD5(id)'=>$id));
	        $this->db->update('ffc_employee',$updateData);

	        $this ->db->select('*');
			$this->db->from('ffc_employee');
			$this->db->where('is_deleted',0);
			$this->db->where('MD5(ID)',$id);
			$row= $this->db->get()->row();

			if(count($row)>0){
				
					if($row->status == '1') {
					
					$newData=array('id'=>$row->ID,'user_type'=>$row->user_type,'username'=>$row->username);
							
					$this->session->set_userdata("login_data",$newData);
					redirect('admin');
				
				}
				else{

					setFlashMsg('success_message',$this->MESSAGE['NOTACTIVE_USER'],'alert-success');

					
					redirect(base_url('login'));
				}
			}
			

	        setFlashMsg('success_message',$this->MESSAGE['INVITATION_ACCEPT_SUCCESS_MESSAGE'],'alert-success');
    	}
    	
        return true;

    }

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */