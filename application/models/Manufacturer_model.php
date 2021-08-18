<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacturer_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_manufacturer";
    }

    public function getData($is_active='')
    {
    	$this->db->select("*");
    	$this->db->from($this->main_table);
    	if($is_active==1)$this->db->where("status",1);
    	$this->db->where("is_deleted",0);
    	$this->db->order_by('ID','DESC');
    	$result=$this->db->get()->result();
    	return $result;
    }

    public function addedit($value='')
    {
    	$postData=$this->input->post();
    	$crr_date=date("Y-m-d H:i:s");
    	$LOGINID=$this->LOGINID;
    	$ID=$ROWID=$this->input->post('ID');
    	//print_r($postData); die;
    	$name=$postData['name'];
        $sname=$postData['sname'];
        $email=$postData['email'];
        $representative=$postData['representative'];
        $owner=$postData['owner'];
        $notes=$postData['notes'];
        $account_number=$postData['account_number'];
        $bank_name=$postData['bank_name'];
        $bank_address=$postData['bank_address'];
        $swift=$postData['swift'];
        $telex=$postData['telex'];
        $address=$postData['address'];
        $postal_code=$postData['postal_code'];

    	if(true){

    		$insertData=array(
    		    'name'=>$name,
                'sname'=>$sname,
                'email'=>$email,
                'representative'=>$representative,
                'owner'=>$owner,
                'notes'=>$notes,
                'account_number'=>$account_number,
                'bank_name'=>$bank_name,
                'bank_address'=>$bank_address,
                'swift'=>$swift,
                'telex'=>$telex,
                'address'=>$address,
                'postal_code'=>$postal_code,
                'updated_by'=>$LOGINID,
                'updation_date'=>$crr_date,
                );

    		if ($ID!='') {
    			$ID=(is_numeric($ID))?md5($ID):$ID;
    			$this->db->where("MD5(ID)",$ID);
    			$this->db->update($this->main_table,$insertData);
    			setFlashMsg('success_message',$this->MESSAGE['MANUFACTURER_UPDATED'],'alert-success');
    		}else{
    			$insertData['creation_date']=$crr_date;
    			$insertData['created_by']=$LOGINID;
    			$this->db->insert($this->main_table,$insertData);
    			$ROWID=$this->db->insert_id();
    			setFlashMsg('success_message',$this->MESSAGE['MANUFACTURER_ADDED'],'alert-success');

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
    		 setFlashMsg('email_exist',$this->MESSAGE['MANUFACTURER_EXIST'],'',1);
    		return false;
    	}
    	return true;
    }


    public function loadDataById($ID='')
    {
    	if($ID!=''){
    		$ID=(is_numeric($ID))?md5($ID):$ID;
	    	$this->db->select("*");
	    	$this->db->from($this->main_table);
	    	$this->db->where("is_deleted",0);
	    	$this->db->where("MD5(ID)",$ID);
	    	$result=$this->db->get()->row();

	    	$this->db->select("*");
	    	$this->db->from("ffc_rolemaster_href");
	    	$this->db->where("MD5(role_id)",$ID);
	    	$result2=$this->db->get()->result();
	    	$event_ids=array();
	    	if($result2){
	    		foreach ($result2 as $value) 
				{
	    			$event_ids[$value->module_id][]=$value->event_id;
	    		}
	    	}
			if(!$result)
				$result = new StdClass;
	    	$result->modules=$result2;
	    	$result->event_ids=$event_ids;
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
    			setFlashMsg('success_message',$this->MESSAGE['MANUFACTURER_DEACTIVE_STATUS'],'alert-danger');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['MANUFACTURER_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['MANUFACTURER_DELETE'],'alert-danger');
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
	    	setFlashMsg('success_message',$this->MESSAGE['MANUFACTURER_DELETE_BULK'],'alert-danger');
	    	return true;
    	}
    }
}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */