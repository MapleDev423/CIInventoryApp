<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bom_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_bom";
    }

    public function getData()
    {
    	$this->db->select("B.*,P.name AS product_name, P.product_id as product_id_val");
    	$this->db->from($this->main_table." B ");
    	//$this->db->where("status",1);
        $this->db->join("ffc_products P","P.id=B.product_id","LEFT");
    	$this->db->where("B.is_deleted",0);
    	$this->db->order_by('B.ID','DESC');
    	$result=$this->db->get()->result();
        //echo $this->db->last_query(); die;
        if($result){
            foreach ($result as $key => $value) {
                $this->db->select("COUNT(BP.ID) as total_parts, SUM(P.price*BP.quantity) as total_cost");
                $this->db->from("ffc_bom_parts BP");
                $this->db->join("ffc_parts P","P.ID=BP.parts_id");                 
                $this->db->where("BP.bom_id",$value->ID);
                $this->db->group_by("BP.bom_id");
                $result2=$this->db->get()->row();
                $total_parts=( $result2 && $result2->total_parts>0)?$result2->total_parts:0;
                $total_cost=( $result2 && $result2->total_cost>0)?$result2->total_cost:'0.00';
                $value->total_parts=$total_parts;
                $value->total_cost=$total_cost;
            }
        }
        //print_r($result); die;
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
        $product_id=$postData['product_id'];
        $note=$postData['note'];

        $manufacturer_id=$postData['manufacturer_id']; 
        $part_colors=$postData['part_colors'];
        $quantity=$postData['quantity'];
        $parts_id=$postData['parts_id'];
        $unit_id=$postData['unit_id'];

        $insertData=array('title'=>$title,
                        'product_id'=>$product_id,
                        'note'=>$note,
                        'updated_by'=>$LOGINID,
                        'updation_date'=>$crr_date,
                        );

               
        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);
            
            $this->db->where('MD5(bom_id)',$ID);
            $this->db->delete('ffc_bom_parts');                     
            setFlashMsg('success_message',$this->MESSAGE['BOM_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();           
            setFlashMsg('success_message',$this->MESSAGE['BOM_ADDED'],'alert-success');

        }
        $resultBomParts=array();
        if($manufacturer_id && count($manufacturer_id)>0){
            foreach ($manufacturer_id as $key=>$mid) {
                if($mid>0 && $part_colors[$key]!='' && $unit_id[$key]!='' && $quantity[$key]>0){ 
                    $resultBomParts[]= array('bom_id'=>$ROWID,
                                             'manufacturer_id'=>$mid,
                                             'parts_id'=>$parts_id[$key],
                                             'part_colors'=>$part_colors[$key],
                                             'unit_id'=>$unit_id[$key],
                                             'quantity'=>$quantity[$key]);
                    
                }
            }
        }        
        //print_r($resultBomParts); die;
        if(count($resultBomParts)>0)$this->db->insert_batch('ffc_bom_parts',$resultBomParts);
       // echo $this->db->last_query(); die;
        return true;

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
    		 setFlashMsg('email_exist',$this->MESSAGE['BOM_EXIST'],'',1);
    		return false;
    	}
    	return true;
    }


    public function loadDataById($ID='',$all_records=1)
    {
        $this->load->model('parts_model');
    	if($ID!=''){
    		$ID=(is_numeric($ID))?md5($ID):$ID;
	    	$this->db->select("B.*,P.name as product_name");
	    	$this->db->from($this->main_table." B");
            $this->db->join("ffc_products P","P.ID=B.product_id","LEFT");
	    	$this->db->where("B.is_deleted",0);
	    	$this->db->where("MD5(B.ID)",$ID);
	    	$result=$this->db->get()->row();

            $this->db->select("BP.*,M.name as manufacturer_name, P.name as part_name,,P.price as parts_price,U.title as unit_title ");
            $this->db->from("ffc_bom_parts BP");
            $this->db->where("MD5(bom_id)",$ID);
            $this->db->join("ffc_manufacturer M","M.ID=BP.manufacturer_id","LEFT");
            $this->db->join("ffc_parts P","P.ID=BP.parts_id","LEFT");
            $this->db->join("ffc_unit U","U.ID=BP.unit_id","LEFT");
            $result2=$this->db->get()->result();
            $total_cost=0;
            if($result2){
                foreach ($result2 as $key => $value) { 

                     $partsColorDetails=$this->parts_model->getPartsColorImg($value->parts_id,$value->part_colors);
                     $partColorsList=$this->parts_model->getPartscolorByPartsId($value->parts_id);
                     if($all_records==1){
                            $partsList=$this->parts_model->getPartsByManufacturer($value->manufacturer_id);
                            $value->partsList=$partsList;
                            $value->partColorsList=$partColorsList['colorList'];
                        }
                        
                        $cost=($partColorsList['partDetails'] && $partColorsList['partDetails']->price>0)?$partColorsList['partDetails']->price:0;
                        $quantity=(float)$value->quantity;
                        $toal_cost=(float)$cost*$quantity;
                        $total_cost += (float)$cost*$quantity;
                       
                        

                    $value->part_cost=$toal_cost;
                    $value->price=$cost;
                    $value->partColors_imgpath=$partsColorDetails->image_fullpath;
                }
            }

            $result->parts=$result2;
            $result->total_cost=number_format((float)$total_cost, 2, '.', '');
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
    			setFlashMsg('success_message',$this->MESSAGE['BOM_DEACTIVE_STATUS'],'alert-info');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['BOM_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['BOM_DELETE'],'alert-danger');
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
	    	setFlashMsg('success_message',$this->MESSAGE['BOM_DELETE_BULK'],'alert-danger');
	    	return true;
    	}
    }
}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */