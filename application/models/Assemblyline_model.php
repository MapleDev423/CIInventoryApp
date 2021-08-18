<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assemblyline_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_assemblyline";
    }

    public function getData($is_active='')
    {
    	$this->db->select("AL.*");
    	$this->db->from($this->main_table." AL");
    	if($is_active==1)$this->db->where("AL.status",1);
    	$this->db->where("AL.is_deleted",0);
    	$this->db->order_by('AL.ID','DESC');
        $this->db->group_by("AL.ID");
    	$result=$this->db->get()->result();
         //print_r($result);
         //die;
    	return $result;
    }

    public function addedit($value='')
    {
    	$postData=$this->input->post();
    	$crr_date=date("Y-m-d H:i:s");
    	$LOGINID=$this->LOGINID;
    	$ID=$ROWID=$this->input->post('ID');
    
    	//print_r($postData); die;
    	$title=$postData['title'];
        $note=$postData['note'];
                              
        $insertData=array(); 
        if($title && count($title)>0){
        foreach ($title as $key=>$value) {
        if($value!=''){  
		$insertData[]=array('title'=>$value,
                        'note'=>$note[$key],
                        'updated_by'=>$LOGINID,
                        'updation_date'=>$crr_date,
						'creation_date'=>$crr_date,
						'created_by'=>$LOGINID
                        );		
				}
			}
		}			
     //echo "<pre>";print_r($insertData);die;
	 
	   if($ID!=''){
          	$ID=(is_numeric($ID))?md5($ID):$ID;
			$insertData=array('title'=>$value,
                        'note'=>$note[$key],
                        'updated_by'=>$LOGINID,
                        'updation_date'=>$crr_date,
                        );
						
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);
    		}else{
    			//echo "<pre>";print_r($insertData);die;
    			if(count($insertData)>0)$this->db->insert_batch($this->main_table,$insertData);
    			$ROWID=$this->db->insert_id();
    			setFlashMsg('success_message',$this->MESSAGE['ASSEMBLYLINE_ADDED'],'alert-success');
    		}
    		return true;
}
 

    public function loadDataById($ID='',$only_parts_details=0)
    {
    	if($ID!=''){
    		$ID=(is_numeric($ID))?md5($ID):$ID;
	    	$this->db->select("*");
	    	$this->db->from($this->main_table);
	    	$this->db->where("is_deleted",0);
	    	$this->db->where("MD5(ID)",$ID);
	    	$result=$this->db->get()->row();
           
            //print_r($result); die;
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
    			setFlashMsg('success_message',$this->MESSAGE['ASSEMBLYLINE_DEACTIVE_STATUS'],'alert-info');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['ASSEMBLYLINE_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['ASSEMBLYLINE_DELETE'],'alert-danger');
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
    		//$updateData=array('is_deleted'=>1);
    		$this->db->where_in("ID",$ids);
	    	$this->db->delete($this->main_table);
	    	setFlashMsg('success_message',$this->MESSAGE['ASSEMBLYLINE_DELETE_BULK'],'alert-danger');
	    	return true;
    	}
    }

	
	
	
}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */