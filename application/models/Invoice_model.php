<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_invoice";
        $this->load->model('manufacturer_model');
        $this->load->model('purchaseorder_model');
    }

    public function getData()
    {
        $this->db->select("P.*, PO.porderid, M.name as manufact");
        $this->db->from("ffc_invoice P");
        $this->db->where("P.is_deleted",0);
		//$this->db->where("P.is_gr_complete",0); //comment for view all
        $this->db->join("ffc_purchaseorder PO","PO.ID=P.porderid","LEFT");
		//$this->db->join("ffc_planningsheets PS","PO.ID=PS.planningsheet_id","LEFT");
        $this->db->join("ffc_manufacturer M","M.ID=P.manufacturer_id","LEFT");
        $this->db->order_by('P.shipping_date','DESC');
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
        $invoiceid=$postData['invoiceid'];
        $porderid=$postData['porderid'];
        $manufacturer_id=$postData['manufacturer_id'];
        $planningsheet_id=$postData['planningsheet_id'];
        $pi_date=date("Y-m-d",strtotime($postData['pi_date']));
        $shipping_date=date("Y-m-d",strtotime($postData['shipping_date']));
		$total_cases_val=$postData["total_cases_val"];
		$total_pcs_val=$postData["total_pcs_val"];
        $total_cost_val=$postData['total_cost_val'];
        $total_cbm_val=$postData['total_cbm_val'];
        $cbm_area_type=$postData['cbm_area_type'];
        $confirmation_no=$postData['confirmation_no'];
        $total_deposit_per=$postData['total_deposit_per'];
        $total_deposit_val=$postData['total_deposit_val'];

        $parts_id=$postData['parts_id'];
        $part_colors=$postData['part_colors'];
        $parts_price=$postData['parts_price'];
        $currentstock=$postData['currentstock'];
        $cbm=$postData['cbm'];
        $moq=$postData['moq'];
        $total_cases=$postData['total_cases'];
        $total_pcs=$postData['total_pcs'];
        $total_cost=$postData['total_cost'];
        $total_cbm=$postData['total_cbm'];

        $insertData=array(
            'invoiceid'=>$invoiceid,
            'porderid'=>$porderid,
            'planningsheet_id'=>$planningsheet_id,
            'manufacturer_id'=>$manufacturer_id,
            'pi_date'=>$pi_date,
            'shipping_date'=>$shipping_date,
			'total_cases_val'=>$total_cases_val,
			'total_pcs_val'=>$total_pcs_val,
            'total_cost_val'=>$total_cost_val,
            'total_cbm_val'=>$total_cbm_val,
            'cbm_area_type'=>$cbm_area_type,
            'confirmation_no'=>$confirmation_no,
            'total_deposit_per'=>$total_deposit_per,
            'total_deposit_val'=>$total_deposit_val,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0
        );

        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);


            $this->db->where("ID",$porderid);
            $this->db->update('ffc_purchaseorder', array('is_pi'=>1));

            //$this->db->where("ID",$planningsheet_id);
            //$this->db->update('ffc_planningsheets', array('is_pi'=>1));

            $this->db->where('MD5(pi_id)',$ID);
            $this->db->delete('ffc_invoice_parts');

            setFlashMsg('success_message',$this->MESSAGE['INVOICE_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();

            $this->db->where("ID",$porderid);
            $this->db->update('ffc_purchaseorder', array('is_pi'=>1));

            //$this->db->where("ID",$planningsheet_id);
            //$this->db->update('ffc_planningsheets', array('is_pi'=>1));

            setFlashMsg('success_message',$this->MESSAGE['INVOICE_ADDED'],'alert-success');

        }
        $resultPlanningsheetsParts=array();
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) {
                // if($pid>0 && $part_colors[$key]!='' && $cbm[$key]>0 && $total_cases[$key]>0 && $total_pcs[$key]>0){
                if($pid>0){
                    $resultPlanningsheetsParts[]= array('pi_id'=>$ROWID,
                        'parts_id'=>$pid,
                        'part_colors'=>$part_colors[$key],
                        'parts_price'=>$parts_price[$key],
                        'currentstock'=>$currentstock[$key],
                        'cbm'=>$cbm[$key],
                        'parts_moq'=>$moq[$key],
                        'total_cases'=>$total_cases[$key],
                        'total_pcs'=>$total_pcs[$key],
                        'total_cost'=>$total_cost[$key],
                        'total_cbm'=>$total_cbm[$key]);

                }
            }
        }
        //print_r($resultPlanningsheetsParts); die;
        if(count($resultPlanningsheetsParts)>0)$this->db->insert_batch('ffc_invoice_parts',$resultPlanningsheetsParts);
        // echo $this->db->last_query(); die;
        return true;

    }


    public function generateperforma($value='')
    {
        $postData=$this->input->post();
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;
        $ID=$ROWID=$this->input->post('ID');
        //print_r($postData); die;
        $invoiceid=$postData['invoiceid'];
        $porderid=$postData['porderid'];
        $manufacturer_id=$postData['manufacturer_id'];
        $planningsheet_id=$postData['planningsheet_id'];
        $pi_date=date("Y-m-d",strtotime($postData['pi_date']));
        $shipping_date=date("Y-m-d",strtotime($postData['shipping_date']));
		$total_cases_val=$postData["total_cases_val"];
		$total_pcs_val=$postData["total_pcs_val"];
        $total_cost_val=$postData['total_cost_val'];
        $total_cbm_val=$postData['total_cbm_val'];
        $cbm_area_type=$postData['cbm_area_type'];
        $confirmation_no=$postData['confirmation_no'];
        $total_deposit_per=$postData['total_deposit_per'];
        $total_deposit_val=$postData['total_deposit_val'];

        $parts_id=$postData['parts_id'];
        $part_colors=$postData['part_colors'];
        $parts_price=$postData['parts_price'];
        $currentstock=$postData['currentstock'];
        $cbm=$postData['cbm'];
        $moq=$postData['moq'];
        $total_cases=$postData['total_cases'];
        $total_pcs=$postData['total_pcs'];
        $total_cost=$postData['total_cost'];
        $total_cbm=$postData['total_cbm'];

        $insertData=array(
            'invoiceid'=>$invoiceid,
            'porderid'=>$porderid,
            'planningsheet_id'=>$planningsheet_id,
            'manufacturer_id'=>$manufacturer_id,
            'pi_date'=>$pi_date,
            'shipping_date'=>$shipping_date,
			'total_cases_val'=>$total_cases_val,
			'total_pcs_val'=>$total_pcs_val,
            'total_cost_val'=>$total_cost_val,
            'total_cbm_val'=>$total_cbm_val,
            'cbm_area_type'=>$cbm_area_type,
            'confirmation_no'=>$confirmation_no,
            'total_deposit_per'=>$total_deposit_per,
            'total_deposit_val'=>$total_deposit_val,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0,
            'is_final'=>1
        );


        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);


            $this->db->where("ID",$porderid);
            $this->db->update('ffc_purchaseorder', array('is_pi'=>1,'is_final'=>1));

            $this->db->where("ID",$planningsheet_id);
            $this->db->update('ffc_planningsheets', array('is_pi'=>1));

            $this->db->where('MD5(pi_id)',$ID);
            $this->db->delete('ffc_invoice_parts');

            setFlashMsg('success_message',$this->MESSAGE['INVOICE_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();

            $this->db->where("ID",$porderid);
            $this->db->update('ffc_purchaseorder', array('is_pi'=>1,'is_final'=>1));

            $this->db->where("ID",$planningsheet_id);
            $this->db->update('ffc_planningsheets', array('is_pi'=>1));

            setFlashMsg('success_message',$this->MESSAGE['INVOICE_GENERATE'],'alert-success');

        }
        $resultPlanningsheetsParts=array();
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) {
                // if($pid>0 && $part_colors[$key]!='' && $cbm[$key]>0 && $total_cases[$key]>0 && $total_pcs[$key]>0){
                if($pid>0){
                    $resultPlanningsheetsParts[]= array('pi_id'=>$ROWID,
                        'parts_id'=>$pid,
                        'part_colors'=>$part_colors[$key],
                        'parts_price'=>$parts_price[$key],
                        'currentstock'=>$currentstock[$key],
                        'cbm'=>$cbm[$key],
                        'parts_moq'=>$moq[$key],
                        'total_cases'=>$total_cases[$key],
                        'total_pcs'=>$total_pcs[$key],
                        'total_cost'=>$total_cost[$key],
                        'total_cbm'=>$total_cbm[$key]);

                }
            }
        }
        //print_r($resultPlanningsheetsParts); die;
        if(count($resultPlanningsheetsParts)>0)$this->db->insert_batch('ffc_invoice_parts',$resultPlanningsheetsParts);
        // echo $this->db->last_query(); die;
        return true;

    }


    public function generatepi($value='')
    {
        $postData=$this->input->post();
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;
        if($this->input->post('ID') !=''){
            $ID=$ROWID=$this->input->post('ID');
        }
        else{
            $ID=$ROWID=$_SESSION['PROWID'];
        }
        //print_r($postData); die;
        //$porderid=rand();
        $planningsheet_id=$postData['planningsheet_id'];
        $manufacturer_id=$postData['manufacturer_id'];
        $pi_date=$crr_date;
        $shipping_date=date("Y-m-d",strtotime($postData['shipping_date']));
		$total_cases_val=$postData['total_cases_val'];
		$total_pcs_val=$postData['total_pcs_val'];
        $total_cost_val=$postData['total_cost_val'];
        $total_cbm_val=$postData['total_cbm_val'];
        $cbm_area_type=$postData['cbm_area_type'];
        $confirmation_no=$postData['confirmation_no'];
        $total_deposit_per=$postData['total_deposit_per'];
        $total_deposit_val=$postData['total_deposit_val'];

        $parts_id=$postData['parts_id'];
        $part_colors=$postData['part_colors'];
        $parts_price=$postData['parts_price'];
        $currentstock=$postData['currentstock'];
        $cbm=$postData['cbm'];
        $moq=$postData['moq'];
        $total_cases=$postData['total_cases'];
        $total_pcs=$postData['total_pcs'];
        $total_cost=$postData['total_cost'];
        $total_cbm=$postData['total_cbm'];

        $insertData=array('porderid'=>$ID,
            'planningsheet_id'=>$planningsheet_id,
            'manufacturer_id'=>$manufacturer_id,
            'pi_date'=>$pi_date,
            'shipping_date'=>$shipping_date,
			'total_cases_val'=>$total_cases_val,
			'total_pcs_val'=>$total_pcs_val,
            'total_cost_val'=>$total_cost_val,
            'total_cbm_val'=>$total_cbm_val,
            'cbm_area_type'=>$cbm_area_type,
            'confirmation_no'=>$confirmation_no,
            'total_deposit_per'=>$total_deposit_per,
            'total_deposit_val'=>$total_deposit_val,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>1
        );



        $insertData['creation_date']=$crr_date;
        $insertData['created_by']=$LOGINID;
        $this->db->insert($this->main_table,$insertData);
        $ROWID=$this->db->insert_id();

        $this->db->where("ID",$ID);
        $this->db->update('ffc_purchaseorder', array('is_pi'=>0));

        //$this->db->where("ID",$planningsheet_id);
        //$this->db->update('ffc_planningsheets', array('is_pi'=>0));


        setFlashMsg('success_message',$this->MESSAGE['INVOICE_ADDED'],'alert-success');


        $resultPlanningsheetsParts=array();
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) {
                // if($pid>0 && $part_colors[$key]!='' && $cbm[$key]>0 && $total_cases[$key]>0 && $total_pcs[$key]>0){
                if($pid>0){
                    $resultPlanningsheetsParts[]= array('pi_id'=>$ROWID,
                        'parts_id'=>$pid,
                        'part_colors'=>$part_colors[$key],
                        'parts_price'=>$parts_price[$key],
                        'currentstock'=>$currentstock[$key],
                        'cbm'=>$cbm[$key],
                        'parts_moq'=>$moq[$key],
                        'total_cases'=>$total_cases[$key],
                        'total_pcs'=>$total_pcs[$key],
                        'total_cost'=>$total_cost[$key],
                        'total_cbm'=>$total_cbm[$key]);

                }
            }
        }
        //print_r($resultPlanningsheetsParts); die;
        if(count($resultPlanningsheetsParts)>0)$this->db->insert_batch('ffc_invoice_parts',$resultPlanningsheetsParts);
        // echo $this->db->last_query(); die;
        $this->session->unset_userdata('PROWID');
        return $ROWID;

    }




    public function loadDataById($ID='',$all_records=1)
    {
        $this->load->model('parts_model');
        if($ID!=''){
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->select("P.*");
            $this->db->from($this->main_table." P");
            //$this->db->where("P.is_deleted",0);
            $this->db->where("MD5(P.ID)",$ID);
            $result=$this->db->get()->row();

            $this->db->select("PP.*,P.name as part_name");
            $this->db->from("ffc_invoice_parts PP");
            $this->db->where("MD5(pi_id)",$ID);
            $this->db->join("ffc_parts P","P.ID=PP.parts_id","LEFT");
            $result2=$this->db->get()->result();

            foreach ($result2 as $key => $value) {

                $partColorsList=$this->parts_model->getPartscolorByPartsId($value->parts_id);
                if($all_records==1){
                    $value->partColorsList=$partColorsList['colorList'];
                }
                $this->db->select("*");
                $this->db->from("ffc_parts_color");
                $this->db->where("parts_id",$value->parts_id);
                $this->db->where("color_code",$value->part_colors);
                $partimage=$this->db->get()->row();
                //echo $this->db->last_query(); die;
                if($partimage && $partimage->image!=''){
                    $value->part_img=$this->config->item('PARTS_DATA_DISP').'colors/'.$value->parts_id.'/'.$partimage->image;
                }else{
                    $value->part_img=$this->config->item('PARTS_DATA_DISP').'not-available.jpg';
                }

            }


            $result->parts=$result2;



            //print_r($result); die;
            return $result;
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
                $this->db->select("P.*");
                $this->db->from($this->main_table." P");
                $this->db->where("P.ID",$ids[$i]);
                $result=$this->db->get()->row();

                $this->db->where("ID",$result->porderid);
                $this->db->update('ffc_purchaseorder', array('is_pi'=>0,'is_final'=>0));

                $this->db->where("ID",$result->planningsheet_id);
                $this->db->update('ffc_planningsheets', array('is_pi'=>0));
            }


            setFlashMsg('success_message',$this->MESSAGE['INVOICE_DELETE_BULK'],'alert-danger');
            return true;
        }
    }
}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */