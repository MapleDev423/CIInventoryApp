<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {
    public $MESSAGE;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
         $this->main_table="ffc_employee";
         
    }


   public function getData($is_active='',$role_id='')
    {
        $LOGINID=$this->LOGINID;

        $role_id=(is_numeric($role_id))?md5($role_id):$role_id;

        $this->db->select("*");
        $this->db->from($this->main_table);
        if($is_active==1)$this->db->where("status",1);
        if($role_id!='')$this->db->where("MD5(role_id)",$role_id);
        $this->db->where("is_deleted",0);
        $this->db->order_by('ID','DESC');
        if($role_id=='')$this->db->where("ID !=",$LOGINID);
        if($role_id=='')$this->db->where("ID !=",1);
        $result=$this->db->get()->result();
        //echo $this->db->last_query(); die;
        return $result;
    }

    public function addedit($value='')
    {
    	$postData=$this->input->post();
    	$crr_date=date("Y-m-d H:i:s");
    	$LOGINID=$this->LOGINID;
    	$ID=$ROWID=$this->input->post('ID');
    	//print_r($postData); die;
    	if($this->checkExist()){

    		$insertData=array(  'first_name'=>$postData['first_name'],
                                'last_name'=>$postData['last_name'],
                                'email'=>$postData['email'],
                                'phone_no'=>$postData['phone_no'],
                                'role_id'=>$postData['role_id'],
                                'address'=>$postData['address'],
    							'updation_date'=>$crr_date,
    							'updated_by'=>$LOGINID,
    							);

            if($postData['password']!='')$insertData['password']= md5($postData['password']);
            $dest = $this->config->item('EMPLOYEE_DATA_DIR');
			//var_dump($postData);
			
			var_dump($_FILES['profile_pic']['name']);
            //$uploadResult = uploadImg('profile_pic',$dest);
            $uploadResult = updateImgToBucket('profile_pic',$dest);
			//var_dump("ADDEDIT");

            if($uploadResult!==false){
				//var_dump("HERE");
            	$oldfile_name= (isset($postData['profile_pic']))?$postData['profile_pic']:'';
              	$insertData['profile_pic']=$uploadResult['upload_data']['file_name'];
              //  if($oldfile_name!='')remove_uploaded_file($oldfile_name,$dest);
                if($oldfile_name!=''){
					remove_uploaded_fileFromBucket($oldfile_name,$dest);
				}

              
            }

    		if ($ID!='') {
    			$ID=(is_numeric($ID))?md5($ID):$ID;
    			$this->db->where("MD5(ID)",$ID);
    			$this->db->update($this->main_table,$insertData);
    			setFlashMsg('success_message',$this->MESSAGE['EMPLOYEE_UPDATED'],'alert-success');
    		}else{
    			$insertData['creation_date']=$crr_date;
    			$insertData['created_by']=$LOGINID; //print_r($insertData); die;
    			$this->db->insert($this->main_table,$insertData);
    			$ROWID=$this->db->insert_id();
    			setFlashMsg('success_message',$this->MESSAGE['EMPLOYEE_ADDED'],'alert-success');

    		}

    		$this->db->where("employee_id",$ROWID);
    		$this->db->delete('ffc_employee_rolemodule');

    		$insertEvent=array();

            $this->load->model('role_model');
            $roleDetails=$this->role_model->loadDataById($postData['role_id']);
    		if($roleDetails && count($roleDetails->event_ids)>0){
    			foreach ($roleDetails->event_ids as $module_id => $access_event) {
    				if(count($access_event)){
    					foreach ($access_event as  $event_id) {
    						$insertEvent[]=array('employee_id'=>$ROWID,'module_id'=>$module_id,'event_id'=>$event_id);
    					}
    				}
    			}

    			$this->db->insert_batch("ffc_employee_rolemodule",$insertEvent);

    		}
    		return true;

    	}


    }

    public function checkExist($value='')
    {
    	$email=$this->input->post('email');
    	$ID=$this->input->post('ID');
    	$ID=(is_numeric($ID))?md5($ID):$ID;
    	$this->db->select("count(ID) as total");
    	$this->db->from($this->main_table);
    	$this->db->where("email",$email);
        $this->db->where("is_deleted",0);
    	if($ID)$this->db->where("MD5(ID) !=",$ID);
    	$result=$this->db->get()->row();
    	//echo $this->db->last_query(); die;
    	
    	if($result && $result->total>0){
    		 setFlashMsg('email_exist',$this->MESSAGE['EMPLOYEE_EXIST'],'',1);
    		return false;
    	}
    	return true;
    }


    public function loadDataById($ID='')
    {
    	if($ID!=''){
    		$ID=(is_numeric($ID))?md5($ID):$ID;
	    	$this->db->select("E.*,R.title as role_name");
	    	$this->db->from($this->main_table." E ");
            $this->db->join("ffc_rolemaster R","R.ID=E.role_id","LEFT");
	    	$this->db->where("E.is_deleted",0);
	    	$this->db->where("MD5(E.ID)",$ID);
	    	$result=$this->db->get()->row();
            //echo $this->db->last_query(); die;
	    	return $result;
    	}    	
    }

    public function singleAction($value='')
    {
    	$action=replaceEmpty('action');
    	$ID=replaceEmpty('ID');
    	$callbackurl=replaceEmpty('callbackurl');
    	if($action!='' && $ID>0){
    		if($action=='deactive'){
    			$updateData=array('status'=>0);
    			setFlashMsg('success_message',$this->MESSAGE['EMPLOYEE_DEACTIVE_STATUS'],'alert-info');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['EMPLOYEE_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['EMPLOYEE_DELETE'],'alert-danger');
	    	$updateData=array('is_deleted'=>1);
	    }

	    	$this->db->where("ID",$ID);
	    	$this->db->update($this->main_table,$updateData);
	    	return true;
    	}
    	
    }

    public function bulkAction($value='')
    {
    	$postData=$this->input->post(); 
    	$ids=$postData['item_ids']; //print_r($ids); die;
    	if($ids && count($ids)>0){
    		$updateData=array('is_deleted'=>1);
    		$this->db->where_in("ID",$ids);
	    	$this->db->update($this->main_table,$updateData);
	    	setFlashMsg('success_message',$this->MESSAGE['EMPLOYEE_DELETE_BULK'],'alert-danger');
	    	return true;
    	}
    }



    public function changePassword($id='')
	{
            $currentPassword = md5($this->input->post('oldpwd'));
            $newPassword = md5($this->input->post('newpwd'));

            $userData = $this->db->select('*')->from("ffc_employee")->where(array('ID'=>$id))->get()->row();
            $Oldpassword = $userData->password;
            if($Oldpassword == $currentPassword)
            {
                    $updateArray = array( 'password'=>$newPassword);
                    $this->db->where('ID',$id);
                    $successData = $this->db->update('ffc_employee',$updateArray);

                    setFlashMsg('success_message',$this->MESSAGE['PASSWORD_SUCCESS_MESSAGE'],'alert-success');

                    return true;
            }
            else{

                    setFlashMsg('success_message',$this->MESSAGE['PASSWORD_ERROR_MESSAGE'],'alert-danger');

                    return false;
            }
	}

    public function getEmployeeDataById($id='')
	{
		$this->db->select("*");
		$this->db->from('ffc_employee');
		$this->db->where('ID',$id);
		$result = $this->db->get()->row();
		return $result;
	}
       public function updateEmployeeProfile($id='',$oldfile_name='')
	{	
		$postData = $this->input->post();
                
		$first_name = $postData['first_name'];
		$last_name = $postData['last_name'];
                $phone_no = $postData['phone_no'];
		$address = $postData['address'];
		$file_name = $_FILES['profile_pic']['name'];

		$updation_date = date('Y-m-d H:i:s');

		if($id!=''){

			$updateData= array('first_name'=>$first_name,'last_name'=>$last_name,'phone_no'=>$phone_no,'address'=>$address,'updation_date'=>$updation_date);
				
				if($file_name!=''){
						
						$dest = $this->config->item('EMPLOYEE_DATA_DIR');
						$resultData = uploadImg('profile_pic',$dest);
                                                if($resultData!==false){
                                                  $updateData['profile_pic']=$resultData['upload_data']['file_name'];
                                                    if($oldfile_name!='')
                                                    remove_uploaded_file($oldfile_name,$dest);
                                                  
                                                }
						
				}
				//print_r($updateData);die;
				$this->db->where('ID',$id);
				$this->db->update('ffc_employee',$updateData);
				//echo $this->db->last_query();die;
                                $row = $this->employee_model->getEmployeeDataById($id);
                                $login_data=(object)array('id'=>$row->ID,'role_id'=>$row->role_id,'name'=>$first_name.' '.$last_name,'profile_pic'=>$row->profile_pic);
                                setSession("login_data",$login_data);
		
				setFlashMsg('success_message',$this->MESSAGE['PROFILE_UPDATE'],'alert-success');
		
		}
		return true;
	}


    public function updateAllEmployeeRole($role_id='')
    {
        $this->load->model('role_model');
        $roleDetails=$this->role_model->loadDataById($role_id);

        $employeList=$this->getData(1,$role_id);
        //echo '<pre>'; print_r($roleDetails); 
        //print_r($employeList); die;
         if($employeList && count($employeList)>0){
            foreach ($employeList as $empDetails) {
                $EID=$empDetails->ID;
                $this->db->where("employee_id",$EID);
                $this->db->delete('ffc_employee_rolemodule');
                $insertEvent=array();
                if($roleDetails && count($roleDetails->modules)>0){
                    foreach ($roleDetails->modules as  $event_val) {
                        $module_id=$event_val->module_id;
                        $event_id=$event_val->event_id;
                        $insertEvent[]=array('employee_id'=>$EID,'module_id'=>$module_id,'event_id'=>$event_id);
                    }
                    //print_r($insertEvent);
                $this->db->insert_batch("ffc_employee_rolemodule",$insertEvent);

                }
            }
        }
       // die;
    }
	
}