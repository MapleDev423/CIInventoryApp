<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function getTotalRecords($value='')
	{

		/* ================ GET TOTAL MANUFCTURER ============*/
		$this->db->select("count(ID) as total");
    	$this->db->from("ffc_manufacturer");
        $this->db->where("is_deleted",0);
        $this->db->where("status",1);
        $result=$this->db->get()->row();
        $total_manufacturer=$result->total;

		/* ================ GET TOTAL PARTS ============*/
		$this->db->select("count(ID) as total");
    	$this->db->from("ffc_parts");
        $this->db->where("is_deleted",0);
        $this->db->where("status",1);
        $result=$this->db->get()->row();
        $total_parts=$result->total;

        /* ================ GET TOTAL PRODUCTS ============*/
		$this->db->select("count(ID) as total");
    	$this->db->from("ffc_products");
        $this->db->where("is_deleted",0);
        //$this->db->where("status",1);
        $result=$this->db->get()->row();
        $total_products=$result->total;

        /* ================ GET TOTAL BOMS ============*/
		$this->db->select("count(ID) as total");
    	$this->db->from("ffc_bom");
        $this->db->where("is_deleted",0);
        $this->db->where("status",1);
        $result=$this->db->get()->row();
        $total_bom=$result->total;


        $data=array('total_manufacturer'=>$total_manufacturer,'total_parts'=>$total_parts,'total_products'=>$total_products,'total_bom'=>$total_bom);
        //print_r($data); die;
        return $data;

	}

}

/* End of file Dashboard_model.php */
/* Location: ./application/models/Dashboard_model.php */