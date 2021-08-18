<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipments_model extends CI_Model
{
    public $MESSAGE, $main_table;

    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE = $this->config->item('MESSAGE');
        $this->main_table = "ffc_shipments";
    }


    public function getData()
    {
        $this->db->select("SH.ID, SH.shipment_id, SH.shipping_date, SH.shipping_company, SH.shipping_company_rn, SH.estimated_shipping_date, SH.due_balance, SH.is_final, SH.status,I.invoiceid");
        $this->db->from($this->main_table . " SH ");
        $this->db->join("ffc_invoice I","I.ID=SH.pi_id","LEFT");
        $this->db->where("SH.is_deleted", 0);
		//$this->db->where("I.is_sh_complete",0);
		//$this->db->where("SH.is_gr_complete",0);
        $this->db->order_by('SH.estimated_arrival_date', 'DESC');
        $result = $this->db->get()->result();
        return $result;

    }

    public function get_ProformaInvoiceID()
    {
        $this->db->select("I.ID, I.invoiceid");
        $this->db->from("ffc_invoice I");
        $this->db->where("I.is_final", 1);
        $this->db->where("I.is_sh_complete", 0);
        $this->db->where("I.is_deleted", 0);
		$this->db->order_by('I.invoiceid', 'DESC');
        $result = $this->db->get()->result();

        return $result;

    }

    public function addedit($value='')
    {
        $postData=$this->input->post();  //print_r($postData); die;
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;
        $generateShipment=$postData['generateShipment'];

        $ID=$ROWID=$this->input->post('ID');
        $shipment_id=$postData['shipment_id'];
        $shipping_date=date("Y-m-d",strtotime($postData['shipping_date']));
        $pi_id=$postData['pi_id'];
        $estimated_shipping_date=date("Y-m-d",strtotime($postData['estimated_shipping_date']));
        $confirmation_no=$postData['confirmation_no'];
        $deposit_balance=$postData['deposit_balance'];
        $due_balance=$postData['due_balance'];
        $container_size=$postData['container_size'];
        $shipping_company=$postData['shipping_company'];
        $shipping_company_rn=$postData['shipping_company_rn'];
        $bill_lading_number=$postData['bill_lading_number'];
        $loading_place=$postData['loading_place'];
        $shipping_vessel=$postData['shipping_vessel'];
        $estimated_arrival_date=date("Y-m-d",strtotime($postData['estimated_arrival_date']));
        $container_number=$postData['container_number'];
		$freight=$postData['freight'];
		$is_festive=$postData['is_festive'];

        $insertData=array(
            'shipment_id'=>$shipment_id,
            'shipping_date'=>$shipping_date,
            'pi_id'=>$pi_id,
            'estimated_shipping_date'=>$estimated_shipping_date,
            'confirmation_no'=>$confirmation_no,
            'deposit_balance'=>$deposit_balance,
            'due_balance'=>$due_balance,
            'container_size'=>$container_size,
            'shipping_company'=>$shipping_company,
            'shipping_company_rn'=>$shipping_company_rn,
            'bill_lading_number'=>$bill_lading_number,
            'loading_place'=>$loading_place,
            'shipping_vessel'=>$shipping_vessel,
            'estimated_arrival_date'=>$estimated_arrival_date,
            'container_number'=>$container_number,
			'freight'=>$freight,
			'is_festive'=>$is_festive,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0
        );

        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);

            $this->db->where("ID",$pi_id);
            $this->db->update('ffc_invoice', array('is_sh_complete'=>1));

            setFlashMsg('success_message',$this->MESSAGE['SHIPMENT_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();

            $this->db->where("ID",$pi_id);
            $this->db->update('ffc_invoice', array('is_sh_complete'=>1));

            setFlashMsg('success_message',$this->MESSAGE['SHIPMENT_ADDED'],'alert-success');
        }
        //echo $this->db->last_query(); die;
        if($generateShipment!=''){
            $this->generate_shipments($ROWID);
        }
        return true;

    }

    public function generate_shipments($ID=''){
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;

        $insertData=array('is_final'=>1,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0
        );
        $this->db->where("ID",$ID);
        $this->db->update($this->main_table,  $insertData);
        //echo $this->db->last_query(); die;
        return true;
    }

    public function loadDataById($ID='')
    {
        if($ID!=''){
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->select("SH.*,I.invoiceid");
            $this->db->from($this->main_table." SH");
            //$this->db->where("SH.is_deleted",0);
			//$this->db->where("I.is_sh_complete",0);
			//$this->db->where("SH.is_gr_complete",0);
            $this->db->where("MD5(SH.ID)",$ID);
            $this->db->join("ffc_invoice I","I.ID=SH.pi_id","LEFT");
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
                setFlashMsg('success_message',$this->MESSAGE['SHIPMENT_DEACTIVE_STATUS'],'alert-info');
            }
            else if($action=='active'){
                $updateData=array('status'=>1);
                setFlashMsg('success_message',$this->MESSAGE['SHIPMENT_ACTIVE_STATUS'],'alert-success');
            }
            else if($action=='delete'){
                setFlashMsg('success_message',$this->MESSAGE['SHIPMENT_DELETE'],'alert-danger');
                $updateData=array('is_deleted'=>1);

                // for update shipment not generate //
                $this->db->where("ID",$pi_id);
                $this->db->update('ffc_invoice', array('is_sh_complete'=>0));
                //end //
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


            for($i=0; $i<count($ids); $i++){
                $this->db->select("SH.*");
                $this->db->from($this->main_table." SH");
                $this->db->where("SH.ID",$ids[$i]);
                $result=$this->db->get()->row();

                // for update shipment not generate //
                $this->db->where_in("ID",$result->pi_id);
                $this->db->update('ffc_invoice', array('is_sh_complete'=>0));
                //end //
            }

            setFlashMsg('success_message',$this->MESSAGE['SHIPMENT_DELETE_BULK'],'alert-danger');
            return true;
        }
    }


}

/* End of file Shipments_model.php */
/* Location: ./application/models/Shipments_model.php */