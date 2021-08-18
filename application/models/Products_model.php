<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {
    public $MESSAGE,$old_db;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_products";

        $this->server_db = $this->load->database('old_db', TRUE);

        $this->is_server=false; 

    }


    public function getData()
    {
        $LOGINID=$this->LOGINID;

        $old_db_query= "SELECT p.id AS id, p.sid AS sid, p.product_id AS product_id, p.name AS name, p.price AS price, p.photo_1st_filename AS pfn, p.photo_1st_fullpath AS image, m.name AS mfgname, mfi.itemno AS itemno, mi.itemcolor AS itemcolor, p.is_active AS active, p.discontinued AS discontinued FROM products p JOIN mfgitems_products mip ON mip.product_id = p.id JOIN mfg_items mi ON mi.id = mip.mfgitem_id JOIN mfg_item mfi ON mi.itemno = mfi.id JOIN mfg m ON m.id = mfi.mfg "; 

        $local_query= "SELECT * FROM ffc_products ";

        $sql_query=($this->is_server)?$old_db_query:$local_query;

    	if(($this->is_server))$result=$this->server_db->query($sql_query)->result();
        else $result=$this->db->query($sql_query)->result();
        //print_r($result); die;
    	return $result;
    }


    public function addedit(){
        $postData=$this->input->post();
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;
        $ID=$ROWID=$this->input->post('ID');
        $name=$postData['name'];
        $product_id=$postData['product_id'];

        $insertData=array('name'=>$name,
            'product_id'=>$product_id,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0
        );

        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);
            $this->db->last_query();
            setFlashMsg('success_message',$this->MESSAGE['PRODUCTS_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            //$this->db->insert($this->main_table,$insertData);
           // $ROWID=$this->db->insert_id();

            setFlashMsg('success_message',$this->MESSAGE['PRODUCTS_ADDED'],'alert-success');
        }

        return true;
    }


    public function loadDataById($id='')
    {
        if($id!=''){
            $id=(is_numeric($id))?md5($id):$id;
            if($this->is_server){
                $old_db_query= "SELECT p.id AS id, p.sid AS sid, p.product_id AS product_id, p.name AS NAME, p.price AS price, p.photo_1st_filename AS pfn, p.photo_1st_fullpath AS image, m.name AS mfgname, mfi.itemno AS itemno, mi.itemcolor AS itemcolor, p.is_active AS active, p.discontinued AS discontinued FROM products p JOIN mfgitems_products mip ON mip.product_id = p.id JOIN mfg_items mi ON mi.id = mip.mfgitem_id JOIN mfg_item mfi ON mi.itemno = mfi.id JOIN mfg m ON m.id = mfi.mfg 
                    WHERE MD5(p.id) = ".$id;
                 $result=$this->server_db->query($old_db_query)->row();
            }else{
                $this->db->select("*");
                $this->db->from($this->main_table);
                $this->db->where("is_deleted",0);
                $this->db->where("MD5(ID)",$id);
                $result=$this->db->get()->row();

            }
            //echo "<pre>";print_r($result);die;
            return $result;
        }
    }
    public function getBomByProduct($id='')
    {
        $this->load->model('parts_model');
        $id=(is_numeric($id))?md5($id):$id;
        if($id!=''){
            
            $productDetails=$this->loadDataById($id);
            
            $this->db->select("B.*");
            $this->db->from("ffc_bom B ");
            $this->db->where("MD5(B.product_id)",$id);
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
            $productDetails->bomList = $result;
            //print_r($productDetails);die;
            return $productDetails;
        }
    }
    
}