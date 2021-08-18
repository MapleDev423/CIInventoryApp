<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodsreceiptreport_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_goodreceipt";
    }
    
    
    public function getData()
    {		
		$postData=$this->input->post();
		$from_date=$postData['from_date']?date('m/d/Y',strtotime($postData['from_date'])):'';
		$to_date=$postData['to_date']?date('m/d/Y',strtotime($postData['to_date'])):'';
		$manufacturer_id=$postData['manufacturer_id'];
		$parts_id=$postData['parts_id'];
		
			$this->db->select("GR.*,GRP.*,P.name as part_name, M.name as manufacturer");
			//$this->db->select("SUM(total_received) as total_received,SUM(total_pending) as total_pending,SUM(total_receipted) as total_receipted");
			$this->db->from($this->main_table." GR");
            $this->db->where("GR.is_deleted",0);
		if($from_date!='')$this->db->where("GR.receipt_date>=",$from_date);
		if($to_date!='')$this->db->where("GR.receipt_date<=",$to_date);
			$this->db->join("ffc_goodreceipt_parts GRP","GRP.goodreceipt_id=GR.ID","LEFT");
		if($manufacturer_id!='')$this->db->where("GRP.manufacturer",$manufacturer_id);
		if($parts_id!='')$this->db->where("GRP.parts_id",$parts_id);
            $this->db->join("ffc_parts P","P.ID=GRP.parts_id","LEFT");
			$this->db->join("ffc_invoice I","I.ID=GRP.pi_id","LEFT");
			$this->db->join("ffc_manufacturer M","M.ID=I.manufacturer_id","LEFT");
			//$this->db->group_by('GR.receipt_date,GRP.manufacturer,GRP.parts_id,GRP.part_colors');
			$result=$this->db->get()->result();
            
            foreach ($result as $key => $value) { 

                    $partColorsList=$this->parts_model->getPartscolorByPartsId($value->parts_id);
                     if($all_records==1){
                            $value->partColorsList=$partColorsList['colorList'];
                        }
                        $this->db->select("image");
                        $this->db->from("ffc_parts_color");
                        $this->db->where("parts_id",$value->parts_id);
                        $this->db->where("color_code",$value->part_colors);
                        $partimage=$this->db->get()->row();
                      
                        if($partimage && $partimage->image!=''){
                            $value->part_img=$this->config->item('PARTS_DATA_DISP').'colors/'.$value->parts_id.'/'.$partimage->image;
                        }else{
                            $value->part_img=$this->config->item('PARTS_DATA_DISP').'not-available.jpg';
						}
                        
                }
           // print_r($result); die;
	    	return $result;   	
    }

public function getManufacturer()
    {
    	//$this->db->select("GRP.manufacturer as ID,M.name");
		//$this->db->join("ffc_manufacturer M","M.ID=GRP.manufacturer","LEFT");
		//$this->db->from("ffc_goodreceipt_parts GRP");
		//$this->db->group_by("GRP.manufacturer");
    	//$this->db->order_by('M.name','asc');
		
		$this->db->select("M.ID,M.name");
		$this->db->from("ffc_manufacturer M");
		$this->db->where("M.is_deleted","0");
		$this->db->order_by('M.name','asc');
    	$result=$this->db->get()->result();
    	return $result;
    }
 
 public function getPartsnameByManufacturer()
    {
        $partsList=array();
        $postData=$this->input->post();
    	$manufacturer_id=(isset($postData['manufacturer_id']))?$postData['manufacturer_id']:'';
		
		//$this->db->select("GRP.parts_id,P.name");
		//$this->db->from("ffc_goodreceipt_parts GRP");
		//if($manufacturer_id!=''){$this->db->where("GRP.manufacturer",$manufacturer_id);}
		//$this->db->join("ffc_parts P","P.ID=GRP.parts_id","LEFT");
		
		//$this->db->group_by("GRP.parts_id");
		//$this->db->order_by('P.name','asc');
		
		$this->db->select("P.ID,P.name");
		$this->db->from("ffc_parts P");
		if($manufacturer_id!=''){$this->db->where("FIND_IN_SET (".$manufacturer_id.",P.manufacturer) ");}
		$this->db->where("P.is_deleted","0");
		$this->db->order_by('P.name','asc');
		$result=$this->db->get()->result();
		//print_r($result); die;
		return $result;
	}		
  
 
}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */