<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchaseorder_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_purchaseorder";
        $this->load->model('manufacturer_model');
    }

    public function getData()
    {
        $this->db->select("P.*, M.name as manufact");
        $this->db->from($this->main_table." P ");
        $this->db->where("P.is_deleted",0);
        $this->db->join("ffc_manufacturer M","M.ID=P.manufacturer_id","LEFT");
        $this->db->order_by('P.po_date','DESC');
        $result=$this->db->get()->result();
        //echo $this->db->last_query(); die;
        return $result;

    }

    public function getPOrder()
    {
        $this->db->select("P.*, M.name as manufact");
        $this->db->from($this->main_table." P ");
        $this->db->where("P.is_pi",0);
        $this->db->where("P.is_deleted",0);
        $this->db->join("ffc_manufacturer M","M.ID=P.manufacturer_id","LEFT");
        $this->db->order_by('P.po_date','DESC');
        $result=$this->db->get()->result();
        //echo $this->db->last_query(); die;
        return $result;

    }
    public function getPOrderS()
    {
        $this->db->select("P.*, M.name as manufact");
        $this->db->from($this->main_table." P ");
        $this->db->where("P.is_deleted",0);
        $this->db->join("ffc_manufacturer M","M.ID=P.manufacturer_id","LEFT");
        $this->db->order_by('P.ID','DESC');
        $result=$this->db->get()->result();
        //echo $this->db->last_query(); die;
        return $result;

    }

    public function addedit($value='')
    {
        $postData=$this->input->post();
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;
        $ID=$ROWID=$this->input->post('ID');
        //print_r($postData); die;
        $porderid=$postData['porderid'];
        $manufacturer_id=$postData['manufacturer_id'];
        $planningsheet_id=$postData['planningsheet_id'];
        $po_date=date("Y-m-d",strtotime($postData['po_date']));
        $shipping_date=date("Y-m-d",strtotime($postData['shipping_date']));
        $total_cost_val=$postData['total_cost_val'];
        $total_cbm_val=$postData['total_cbm_val'];
        $iyear=$postData['iyear'];
        $idyear = substr($iyear, -2);
        $season=$postData['season'];
        $cbm_area_type=$postData['cbm_area_type'];

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

        $insertData=array('porderid'=>$porderid,
            'planningsheet_id'=>$planningsheet_id,
            'season'=>$season,
            'iyear'=>$iyear,
            'manufacturer_id'=>$manufacturer_id,
            'po_date'=>$po_date,
            'shipping_date'=>$shipping_date,
            'total_cost_val'=>$total_cost_val,
            'total_cbm_val'=>$total_cbm_val,
            'cbm_area_type'=>$cbm_area_type,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0,
        );


        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);

            $mfg=$this->manufacturer_model->loadDataById($postData['manufacturer_id']);

            $porderids='PO-'.$mfg->sname.'-'.$season.$idyear.'-'.$ROWID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table, array('porderid'=>$porderids));

            $this->db->where("ID",$planningsheet_id);
            $this->db->update('ffc_planningsheets', array('is_po'=>1));

            $this->db->where('MD5(po_id)',$ID);
            $this->db->delete('ffc_purchaseorder_parts');

            setFlashMsg('success_message',$this->MESSAGE['PURCHASE_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();

            $mfg=$this->manufacturer_model->loadDataById($postData['manufacturer_id']);

            $porderids='PO-'.$mfg->sname.'-'.$season.$idyear.'-'.$ROWID;

            $this->db->where("ID",$ROWID);
            $this->db->update($this->main_table, array('porderid'=>$porderids));

            $this->db->where("ID",$planningsheet_id);
            $this->db->update('ffc_planningsheets', array('is_po'=>1));

            setFlashMsg('success_message',$this->MESSAGE['PURCHASE_ADDED'],'alert-success');

        }
        $resultPlanningsheetsParts=array();
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) {
                // if($pid>0 && $part_colors[$key]!='' && $cbm[$key]>0 && $total_cases[$key]>0 && $total_pcs[$key]>0){
                if($pid>0){
                    $resultPlanningsheetsParts[]= array('po_id'=>$ROWID,
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
        if(count($resultPlanningsheetsParts)>0)$this->db->insert_batch('ffc_purchaseorder_parts',$resultPlanningsheetsParts);
        // echo $this->db->last_query(); die;
        return true;

    }

    public function PI_Submit()
    {
        $postData=$this->input->post();
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;
        $ID=$ROWID=$this->input->post('ID');
        //print_r($postData); die;
        $porderid=$postData['porderid'];
        $manufacturer_id=$postData['manufacturer_id'];
        $planningsheet_id=$postData['planningsheet_id'];
        $iyear=$postData['iyear'];
        $idyear = substr($iyear, -2);
        $season=$postData['season'];
        $po_date=date("Y-m-d",strtotime($postData['po_date']));
        $shipping_date=date("Y-m-d",strtotime($postData['shipping_date']));
        $total_cost_val=$postData['total_cost_val'];
        $total_cbm_val=$postData['total_cbm_val'];
        $cbm_area_type=$postData['cbm_area_type'];

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

        $insertData=array('porderid'=>$porderid,
            'planningsheet_id'=>$planningsheet_id,
            'season'=>$season,
            'iyear'=>$iyear,
            'manufacturer_id'=>$manufacturer_id,
            'po_date'=>$po_date,
            'shipping_date'=>$shipping_date,
            'total_cost_val'=>$total_cost_val,
            'total_cbm_val'=>$total_cbm_val,
            'cbm_area_type'=>$cbm_area_type,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0,
        );

        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);

            $mfg=$this->manufacturer_model->loadDataById($postData['manufacturer_id']);

            $porderids='PO-'.$mfg->sname.'-'.$season.$idyear.'-'.$ROWID;
            //die;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table, array('porderid'=>$porderids));

            $this->db->where("ID",$planningsheet_id);
            $this->db->update('ffc_planningsheets', array('is_po'=>1));

            $this->db->where('MD5(po_id)',$ID);
            $this->db->delete('ffc_purchaseorder_parts');

            setFlashMsg('success_message',$this->MESSAGE['PURCHASE_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();

            $mfg=$this->manufacturer_model->loadDataById($postData['manufacturer_id']);

            $porderids='PO-'.$mfg->sname.'-'.$season.$idyear.'-'.$ROWID;


            $this->db->where("ID",$ROWID);
            $this->db->update($this->main_table, array('porderid'=>$porderids));

            $this->db->where("ID",$planningsheet_id);
            $this->db->update('ffc_planningsheets', array('is_po'=>1));

            setFlashMsg('success_message',$this->MESSAGE['PURCHASE_ADDED'],'alert-success');

        }
        $resultPlanningsheetsParts=array();
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) {
                // if($pid>0 && $part_colors[$key]!='' && $cbm[$key]>0 && $total_cases[$key]>0 && $total_pcs[$key]>0){
                if($pid>0){
                    $resultPlanningsheetsParts[]= array('po_id'=>$ROWID,
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
        if(count($resultPlanningsheetsParts)>0)$this->db->insert_batch('ffc_purchaseorder_parts',$resultPlanningsheetsParts);
        // echo $this->db->last_query(); die;
        $this->session->set_userdata('PROWID', $ROWID);
        $ROWID=(is_numeric($ROWID))?md5($ROWID):$ROWID;
        return $ROWID;

    }



    public function generatepo($value='')
    {
        $postData=$this->input->post();
        $crr_date=date("Y-m-d H:i:s");
        $LOGINID=$this->LOGINID;
        if($this->input->post('ID') !=''){
            $ID=$ROWID=$this->input->post('ID');
        }
        else{
            $ID=$ROWID=$_SESSION['PPPROWID'];
        }
        //print_r($postData); die;
        $porderid=rand();
        $manufacturer_id=$postData['manufacturer_id'];
        $po_date=date("Y-m-d");
        $shipping_date=date("Y-m-d",strtotime($postData['shipping_date']));
        $total_cost_val=$postData['total_cost_val'];
        $total_cbm_val=$postData['total_cbm_val'];
        $iyear=$postData['iyear'];
        $idyear = substr($iyear, -2);
        $season=$postData['season'];
        $cbm_area_type=$postData['cbm_area_type'];

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

        $insertData=array('porderid'=>$porderid,
            'planningsheet_id'=>$ID,
            'season'=>$season,
            'iyear'=>$iyear,
            'manufacturer_id'=>$manufacturer_id,
            'po_date'=>$po_date,
            'shipping_date'=>$shipping_date,
            'total_cost_val'=>$total_cost_val,
            'total_cbm_val'=>$total_cbm_val,
            'cbm_area_type'=>$cbm_area_type,
            'updated_by'=>$LOGINID,
            'updation_date'=>$crr_date,
            'is_deleted'=>0,
        );



        $insertData['creation_date']=$crr_date;
        $insertData['created_by']=$LOGINID;
        $this->db->insert($this->main_table,$insertData);
        $ROWID=$this->db->insert_id();

        $this->session->unset_userdata('PPPROWID');
        $mfg=$this->manufacturer_model->loadDataById($postData['manufacturer_id']);

        $porderids='PO-'.$mfg->sname.'-'.$season.$idyear.'-'.$ROWID;

        $this->db->where("ID",$ROWID);
        $this->db->update($this->main_table, array('porderid'=>$porderids));

        $this->db->where("ID",$ID);
        $this->db->update('ffc_planningsheets', array('is_po'=>1));


        setFlashMsg('success_message',$this->MESSAGE['PURCHASE_ADDED'],'alert-success');


        $resultPlanningsheetsParts=array();
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) {
                // if($pid>0 && $part_colors[$key]!='' && $cbm[$key]>0 && $total_cases[$key]>0 && $total_pcs[$key]>0){
                if($pid>0){
                    $resultPlanningsheetsParts[]= array('po_id'=>$ROWID,
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
        if(count($resultPlanningsheetsParts)>0)$this->db->insert_batch('ffc_purchaseorder_parts',$resultPlanningsheetsParts);


        // echo $this->db->last_query(); die;
        return $ROWID;

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
            setFlashMsg('email_exist',$this->MESSAGE['PURCHASE_EXIST'],'',1);
            return false;
        }
        return true;
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
            $this->db->from("ffc_purchaseorder_parts PP");
            $this->db->where("MD5(po_id)",$ID);
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

    public function loadPODataById($ID='',$all_records=1)
    {
        $this->load->model('parts_model');
        if($ID!=''){
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->select("P.*");
            $this->db->from($this->main_table." P");
            $this->db->where("P.is_deleted",0);
            $this->db->where("MD5(P.ID)",$ID);
            $result=$this->db->get()->row();

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
                setFlashMsg('success_message',$this->MESSAGE['PURCHASE_DEACTIVE_STATUS'],'alert-info');
            }
            else if($action=='active'){
                $updateData=array('status'=>1);
                setFlashMsg('success_message',$this->MESSAGE['PURCHASE_ACTIVE_STATUS'],'alert-success');
            }
            else if($action=='delete'){
                setFlashMsg('success_message',$this->MESSAGE['PURCHASE_DELETE'],'alert-danger');
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


            for($i=0; $i<count($ids); $i++){
                $this->db->select("P.*");
                $this->db->from($this->main_table." P");
                $this->db->where("P.ID",$ids[$i]);
                $result=$this->db->get()->row();

                $this->db->where("ID",$result->planningsheet_id);
                $this->db->update('ffc_planningsheets', array('is_po'=>0));
            }


            setFlashMsg('success_message',$this->MESSAGE['PURCHASE_DELETE_BULK'],'alert-danger');
            return true;
        }
    }

    public function deletepi($value='')
    {

        $ID=$value; //print_r($ids); die;

        if($ID!=''){

            $this->db->select("P.porderid,P.planningsheet_id");
            $this->db->from("ffc_invoice P");
            $this->db->where("MD5(P.ID)",$ID);
            $result=$this->db->get()->row();

            $this->db->where("ID",$result->porderid);
            $this->db->update($this->main_table, array('is_pi'=>0));

            //$this->db->where("ID",$result->planningsheet_id);
            //$this->db->update('ffc_planningsheets', array('is_pi'=>0));

            $this->db->where("MD5(ID)",$ID);
            $this->db->delete('ffc_invoice');

            $this->db->where('MD5(pi_id)',$ID);
            $this->db->delete('ffc_invoice_parts');

        }

        return true;

    }


}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */