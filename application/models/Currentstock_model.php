<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currentstock_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_goodreceipt";
    }
    
    
    public function getData($is_active='')
    {
    	$this->db->select("P.name as name,P.description,M.name as manufact");
		$this->db->select("GRP.manufacturer,GRP.parts_id,GRP.part_colors,sum(GRP.total_receipted) as total_receipted");
		$this->db->from("ffc_goodreceipt GR");
		
		$this->db->join("ffc_goodreceipt_parts GRP","GRP.goodreceipt_id=GR.ID","LEFT");
		$this->db->join("ffc_parts P","P.ID=GRP.parts_id","LEFT");
		$this->db->join("ffc_manufacturer M","M.ID=P.manufacturer","LEFT");
    	
		$this->db->where("GR.gr_status",1);
		$this->db->where("GR.is_deleted",0);
		if($is_active==1)$this->db->where("GR.status",1);
		$this->db->order_by('GRP.parts_id','DESC');
        $this->db->group_by("GRP.parts_id");
		$result=$this->db->get()->result();
		foreach($result as $value)
		{	
		$this->db->select("sum(issuestock) as issuestock");
		$this->db->from("ffc_stockissue_parts");
		$this->db->where("manufacturer_id",$value->manufacturer);
		$this->db->where("parts_id",$value->parts_id);
        $value->issuestock=$this->db->get()->row()->issuestock;
		}
		//print_r($result);
         //die;
    	return $result;

    }
	
	
	public function getData_popup($part_id,$is_active='')
    { 
		$this->db->select("M.name as manufact,GRP.*");
		$this->db->select("GRP.parts_id,sum(GRP.total_receipted) as total_receipted");
		$this->db->from("ffc_goodreceipt GR");
		
		$this->db->join("ffc_goodreceipt_parts GRP","GRP.goodreceipt_id=GR.ID","LEFT");
		$this->db->where("GRP.parts_id",$part_id);
		
		$this->db->join("ffc_parts P","P.ID=GRP.parts_id","LEFT");
		$this->db->join("ffc_manufacturer M","M.ID=GRP.manufacturer","LEFT");
		
		$this->db->where("GR.gr_status",1);
		$this->db->where("GR.is_deleted",0);
		if($is_active==1)$this->db->where("GR.status",1);
    	$this->db->order_by('GRP.part_colors');
        $this->db->group_by("GRP.parts_id,GRP.part_colors");
    	
		$result=$this->db->get()->result();
		//echo $this->db->last_query(); die;
		
		foreach ($result as $key => $value) { 
		$this->db->select("sum(issuestock) as issuestock");
		$this->db->from("ffc_stockissue_parts SIP");
		$this->db->where("SIP.manufacturer_id",$value->manufacturer);
		$this->db->where("SIP.parts_id",$value->parts_id);
		$this->db->where("SIP.part_colors",$value->part_colors);
        $value->issuestock=$this->db->get()->row()->issuestock;
	
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
		
		//print_r($result);die;
    	return $result;
    }
	
	 public function getDataCurrentStock($is_active=''){
    	$postData=$this->input->post(); 
		@$from_date=($postData['from_date'])?date('Y-m-d',strtotime($postData['from_date'])):'';
		@$to_date=$postData['to_date']?date('Y-m-d',strtotime($postData['to_date'])):'';
		@$manufacturer_id=$postData['manufacturer_id']?$postData['manufacturer_id']:'';
		@$parts_id=$postData['parts_id']?$postData['parts_id']:'';
		
		$this->db->select("P.name as name,P.description,M.name as manufact");
		$this->db->select("GRP.manufacturer,GRP.parts_id,GRP.part_colors,sum(GRP.total_receipted) as total_receipted");
		$this->db->from("ffc_goodreceipt GR");
		$this->db->join("ffc_goodreceipt_parts GRP","GRP.goodreceipt_id=GR.ID","LEFT");
		$this->db->join("ffc_parts P","P.ID=GRP.parts_id","LEFT");
		$this->db->join("ffc_manufacturer M","M.ID=P.manufacturer","LEFT");
		
		if($manufacturer_id!='')$this->db->where("GRP.manufacturer",$manufacturer_id);
		if($is_active==1)$this->db->where("GR.status",1);
		if($from_date!='')$this->db->where("GR.receipt_date>=",$from_date);
		if($to_date!='')$this->db->where("GR.receipt_date<=",$to_date);
		if($parts_id!='')$this->db->where("GRP.parts_id",$parts_id);
		
		$this->db->where("GR.gr_status",1);
		$this->db->where("GR.is_deleted",0);
		$this->db->order_by('GRP.parts_id,GRP.part_colors','DESC');
		$this->db->group_by("GRP.manufacturer,GRP.parts_id,GRP.part_colors");
		$result=$this->db->get()->result();
		//echo $this->db->last_query();
		//echo "<pre>";print_r($result);die;
		foreach($result as $value){	
		$this->db->select("sum(issuestock) as issuestock");
		$this->db->from("ffc_stockissue_parts");
		if($is_active==1)$this->db->where("status",1);
		$this->db->where("manufacturer_id",$value->manufacturer);
		$this->db->where("parts_id",$value->parts_id);
		$this->db->where("part_colors",$value->part_colors);
        $value->issuestock=$this->db->get()->row()->issuestock;
		}
    	return $result;

    }

	
	 public function getDataStockBilling($is_active=''){ 
		$postData=$this->input->post(); 
		@$from_date=($postData['from_date'])?date('m/d/Y',strtotime($postData['from_date'])):'';
		@$to_date=$postData['to_date']?date('m/d/Y',strtotime($postData['to_date'])):'';
		@$manufacturer_id=$postData['manufacturer_id']?$postData['manufacturer_id']:'';
		@$parts_id=$postData['parts_id']?$postData['parts_id']:'';
		
        $this->db->select("P.ID as part_id,P.name,P.description,M.name as manufact,I.pi_date,IP.*");
		$this->db->from("ffc_invoice I");
		
		$this->db->join("ffc_invoice_parts IP","IP.pi_id=I.ID","LEFT");
		$this->db->join("ffc_parts P","P.ID=IP.parts_id","LEFT");
		$this->db->join("ffc_manufacturer M","M.ID=I.manufacturer_id","LEFT");
    	
		$this->db->where("I.is_deleted",0);
		if($is_active==1)$this->db->where("I.status",1);
		if($from_date!='')$this->db->where("I.pi_date>=",$from_date);
		if($to_date!='')$this->db->where("I.pi_date<=",$to_date);
		if($manufacturer_id!='')$this->db->where("I.manufacturer_id",$manufacturer_id);
		if($parts_id!='')$this->db->where("IP.parts_id",$parts_id);
		$this->db->order_by('IP.ID,IP.parts_id,IP.part_colors');
		$result=$this->db->get()->result();
		//print_r($result);
         //die;
    	return $result;
    }
	
	public function getManufacturer()
    {
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
		
		$this->db->select("P.ID as parts_id,P.name");
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