<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockledgerreport_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_stockledger";
    }
    
    
    public function getData($all_records='')
    {		
		$postData=$this->input->post();
		@$from_date=($postData['from_date'])?date('m/d/Y',strtotime($postData['from_date'])):'';
		@$to_date=$postData['to_date']?date('m/d/Y',strtotime($postData['to_date'])):'';
		@$manufacturer_id=$postData['manufacturer_id']?$postData['manufacturer_id']:'';
		@$parts_id=$postData['parts_id']?$postData['parts_id']:'';
		@$process=$postData['process']?$postData['process']:'';
		
		$this->db->select("I.invoiceid,CONCAT(E.first_name,' ',E.last_name) as employee_name");
		$this->db->select("SL.*,P.name as part_name, M.name as manufacturer");
		$this->db->from($this->main_table." SL");
		if($from_date!='')$this->db->where("SL.ledger_date>=",$from_date);
		if($to_date!='')$this->db->where("SL.ledger_date<=",$to_date);
		if($manufacturer_id!='')$this->db->where("SL.manufacturer",$manufacturer_id);
		if($parts_id!='')$this->db->where("SL.parts_id",$parts_id);
		if($process!='')$this->db->where("SL.process",$process);
		$this->db->join("ffc_invoice I","I.ID=SL.pi_id","LEFT");
		$this->db->join("ffc_employee E","E.ID=SL.employee_id","LEFT");
        $this->db->join("ffc_parts P","P.ID=SL.parts_id","LEFT");
		$this->db->join("ffc_manufacturer M","M.ID=SL.manufacturer","LEFT");
		$this->db->order_by('SL.ID','DESC');
		$result=$this->db->get()->result();
		//echo $this->db->last_query();die;
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
          //print_r($result); die;
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