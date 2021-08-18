<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {

	public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_rolemaster";
    }

    public function getData($is_active='')
    {
    	$this->db->select("*");
    	$this->db->from($this->main_table);
    	if($is_active==1)$this->db->where("status",1);
    	$this->db->where("is_deleted",0);
    	$this->db->where("ID!=",1);
        if($this->LOGINID!=1)$this->db->where("ID !=",1);
    	$this->db->order_by('ID','DESC');
    	$result=$this->db->get()->result();
        if($result){
            foreach ($result as $key => $value) {
               $can_delete=$this->checkDelete($value->ID);
               $value->can_delete=$can_delete;
            }
        }
        //print_r($result); die;
    	return $result;
    }
    
    public function checkDelete($ID='')
    {
        $this->db->select("*");
        $this->db->from("ffc_employee");
        $this->db->where("is_deleted",0);
        $this->db->where('role_id',$ID);
        $result2=$this->db->get()->result();
        $can_delete=($result2 && count($result2)>0)?0:1;
        return $can_delete;
    }
    public function addedit($value='')
    {
    	$postData=$this->input->post();
    	$crr_date=date("Y-m-d H:i:s");
    	$LOGINID=$this->LOGINID;
    	$ID=$ROWID=$this->input->post('ID');
    	//print_r($postData); die;
    	$event_ids=(isset($postData['event_ids']))?$postData['event_ids']:'';
    	if($this->checkExist()){

    		$insertData=array('title'=>$postData['title'],
    							'updation_date'=>$crr_date,
    							'updated_by'=>$LOGINID,
    							);

    		if ($ID!='') {
    			$ID=(is_numeric($ID))?md5($ID):$ID;
    			$this->db->where("MD5(ID)",$ID);
    			$this->db->update($this->main_table,$insertData);
    			setFlashMsg('success_message',$this->MESSAGE['ROLE_UPDATED'],'alert-success');
                $this->load->model('employee_model');
                
    		}else{
    			$insertData['creation_date']=$crr_date;
    			$insertData['created_by']=$LOGINID;
    			$this->db->insert($this->main_table,$insertData);
    			$ROWID=$this->db->insert_id();
    			setFlashMsg('success_message',$this->MESSAGE['ROLE_ADDED'],'alert-success');

    		}

    		$this->db->where("role_id",$ROWID);
    		$this->db->delete('ffc_rolemaster_href');

    		$insertEvent=array();

    		if(is_array($event_ids) && count($event_ids)>0){
    			foreach ($event_ids as $module_id => $access_event) {
    				if(count($access_event)){
    					foreach ($access_event as  $event_id) {
    						$insertEvent[]=array('role_id'=>$ROWID,'module_id'=>$module_id,'event_id'=>$event_id);
    					}
    				}
    			}

    		$this->db->insert_batch("ffc_rolemaster_href",$insertEvent);
            if ($ID!='')$this->employee_model->updateAllEmployeeRole($ID);
    		}
    		return true;

    	}


    }

    public function checkExist($value='')
    {
    	$title=$this->input->post('title');
    	$ID=$this->input->post('ID');
    	$ID=(is_numeric($ID))?md5($ID):$ID;
    	$this->db->select("count(ID) as total");
    	$this->db->from($this->main_table);
    	$this->db->where("title",$title);
    	if($ID)$this->db->where("MD5(ID) !=",$ID);
    	$result=$this->db->get()->row();
    	//echo $this->db->last_query(); die;
    	
    	if($result && $result->total>1){
    		 setFlashMsg('title_exist',$this->MESSAGE['ROLE_EXIST'],'',1);
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
	    		foreach ($result2 as  $value) {
	    			$event_ids[$value->module_id][]=$value->event_id;
	    		}
	    	}
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
    			setFlashMsg('success_message',$this->MESSAGE['ROLE_DEACTIVE_STATUS'],'alert-info');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['ROLE_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['ROLE_DELETE'],'alert-danger');
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
                $rows=$this->db->affected_rows();
                if($rows>0){
                    setFlashMsg('success_message',$this->MESSAGE['ROLE_DELETE_BULK'],'alert-danger');
                }
                else{
                    setFlashMsg('success_message',"You can't able to delete the selected role, because this role is assigned to employees, so please first change the employees role then you will able to delete the selected role.",'alert-success');
                }
	    	
	    	return true;
    	}
    }
}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */