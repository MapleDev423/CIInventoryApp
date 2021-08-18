<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goodreceipt_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_goodreceipt";
    }
    
    
    public function getData()
    {
    	$this->db->select("GR.ID, GR.receipt_date, GR.goodreceipt_invoiceid, GR.shipment_ids, GR.total_currentstock_val, GR.total_received_val, GR.total_pending_val, GR.total_receipted_val, GR.gr_status, GR.status");
		$this->db->from($this->main_table." GR ");
        $this->db->where("GR.is_deleted",0);
		$this->db->order_by('GR.ID','DESC');
    	$result=$this->db->get()->result();
		foreach($result as $value){
            $shipment_ids=explode(',',$value->shipment_ids);
            $this->db->select("SH.shipment_id");
            $this->db->from("ffc_shipments SH");
            $this->db->where_in("SH.ID",$shipment_ids);
            $result2=$this->db->get()->result();
            foreach($result2 as $value2){$shipment_id[]=$value2->shipment_id;}
            $value->shipment_id=implode(', ',$shipment_id);
            $shipment_id=NULL;
		}

        return $result;

    }

    public function get_shipmentDetails(){
        $this->db->select("SH.ID,SH.shipment_id");
        $this->db->from("ffc_shipments SH");
        $this->db->where("SH.is_final",1);
        $this->db->where("SH.is_gr_complete",0);
        $this->db->where("SH.is_deleted",0);
        $result=$this->db->get()->result();

        return $result;
    }


    public function add($value='')
    {
		$postData=$this->input->post();
		$savegr=$postData['savegr'];
    	$crr_date=date("Y-m-d H:i:s");
    	$LOGINID=$this->LOGINID;
    	$ID=$ROWID=$this->input->post('ID');
    	$shipment_ids=implode(',',array_filter($postData['shipment_id']));
    	$proforma_invoice_id=implode(',',array_filter($postData['sub_pi_id']));
        $receipt_date=date("Y-m-d",strtotime($postData['receipt_date']));
		$id_date=strtoupper(date("dMy",strtotime($receipt_date)));
		
    	$total_currentstock_val=array_sum($postData['sub_total_currentstock']);
		$total_received_val=array_sum($postData['sub_total_received']);
        $total_pending_val=array_sum($postData['sub_total_pending']);
        $total_receipt_val=array_sum($postData['sub_total_receiving']);
        
		$sub_pi_id=$postData['sub_pi_id'];
		$sub_alltotal_currentstock=$postData['sub_alltotal_currentstock'];
		$sub_alltotal_received=$postData['sub_alltotal_received'];
		$sub_total_currentstock=$postData['sub_total_currentstock'];
		$sub_total_received=$postData['sub_total_received'];
		$sub_total_receiving=$postData['sub_total_receiving'];
		
		$pi_id=$postData['pi_id'];
		$pi_parts_id=$postData['pi_parts_id'];
		$manufacturer=$postData['manufacturer']; 
		$parts_id=$postData['parts_id'];
        $part_colors=$postData['part_colors'];
        $currentstock=$postData['currentstock'];
		$total_receipted=$postData['total_receipted'];
		$total_pending=$postData['total_pending'];
        $total_receipt=$postData['total_receipt'];
     
        $insertData=array(  'shipment_ids'=>$shipment_ids,
                            'pi_ids'=>$proforma_invoice_id,
							'receipt_date'=>$receipt_date,
                            'total_currentstock_val'=>$total_currentstock_val,
							'total_received_val'=>$total_received_val,
                            'total_pending_val'=>$total_pending_val,
                            'total_receipted_val'=>$total_receipt_val,
                            'updated_by'=>$LOGINID,
                            'updation_date'=>$crr_date,
                            'is_deleted'=>0,
                        );

            //print_r($insertData); die;
        
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
			$this->db->insert($this->main_table,$insertData);
			$ROWID=$this->db->insert_id();  
            
			// for  goodreceipt_invoiceid//SHP-31JUL18-1
            $goodreceipt_invoiceid='SHP-'.$id_date.'-'.$ROWID;
            $this->db->where("ID",$ROWID);
            $this->db->update($this->main_table, array('goodreceipt_invoiceid'=>$goodreceipt_invoiceid));
            //end//
			
			// for all current stock received completed and Good Receipt approve//
			if($sub_pi_id && count($sub_pi_id)>0 && $savegr=='approvegr'){
				foreach ($sub_pi_id as $key=>$s_pid) {	
				if($sub_alltotal_currentstock[$key]==($sub_alltotal_received[$key]+$sub_total_receiving[$key])){
					$this->db->where("ID",$s_pid);
					$this->db->update('ffc_invoice', array('is_gr_complete'=>1));

                    $this->db->where("pi_id",$s_pid);
                    $this->db->where_in("ID", $postData['shipment_id']);
                    $this->db->update('ffc_shipments', array('is_gr_complete'=>1));
				}
				}
			}

			//end //

            setFlashMsg('success_message',$this->MESSAGE['GOODRECEIPT_ADDED'],'alert-success');

       
        $resultGoodreceiptParts=array(); 
		//$resultstockledger=array();
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) { 
                if($pid>0 ){ 						//&& $total_receipt[$key]>0
                
				  $resultGoodreceiptParts[]= array('goodreceipt_id'=>$ROWID,
                                             'pi_id'=>$pi_id[$key],
                                             'pi_parts_id'=>$pi_parts_id[$key],
											 'manufacturer' => $manufacturer[$key],
                                             'parts_id'=>$pid,
                                             'part_colors'=>$part_colors[$key],
                                             'currentstock'=>$currentstock[$key],
											 'total_received'=>$total_receipted[$key],
                                             'total_pending'=>$total_pending[$key],
                                             'total_receipted'=>$total_receipt[$key]);
									
                }
            }
        }        
        //print_r($resultGoodreceiptParts); die;
       if(count($resultGoodreceiptParts)>0)$this->db->insert_batch('ffc_goodreceipt_parts',$resultGoodreceiptParts);
     if($savegr=='approvegr'){
		$postData['ID'] =$ROWID;
		$postData['goodreceipt_invoiceid']=$goodreceipt_invoiceid;
		$this->gr_approve($postData);
		}
	   //echo $this->db->last_query(); die;
        return true;

    }
    
    public function edit($value=''){
		$postData=$this->input->post();
		$LOGINID=$this->LOGINID;
		$crr_date=date("Y-m-d H:i:s");
		$ROWID=$postData['ID'];
		$savegr=$postData['savegr'];
		
		$total_pending_val=$postData['total_pending_val'];
        $total_receipt_val=$postData['total_receipt_val']; 
		
		$grp_id=$postData['grp_id'];
		$pi_id=array_unique($postData['pi_id']);
		$total_pending=$postData['total_pending'];
        $total_receipt=$postData['total_receipt']; 
		
		$updateData=array(  
                            'total_pending_val'=>$total_pending_val,
                            'total_receipted_val'=>$total_receipt_val,
                            'updated_by'=>$LOGINID,
                            'updation_date'=>$crr_date,
                        );
		//print_r($updateData); die;
		$this->db->where("ID",$ROWID);
		$this->db->update($this->main_table,$updateData);
		//echo $this->db->last_query(); die;
		
        $resultGoodreceiptParts=array(); 
		if($grp_id && count($grp_id)>0){
            foreach ($grp_id as $key=>$grp_id) { 
                if($grp_id>0){ 							// && $total_receipt[$key]>0
                
				$resultGoodreceiptParts[]= array(
											'ID'=>$grp_id,
                                            'total_pending'=>$total_pending[$key],
                                            'total_receipted'=>$total_receipt[$key]);
			
				}
			}    
		}
		
       //print_r($resultGoodreceiptParts); die;
      if(count($resultGoodreceiptParts)>0)$this->db->update_batch('ffc_goodreceipt_parts',$resultGoodreceiptParts,'ID');
	   setFlashMsg('success_message',$this->MESSAGE['GOODRECEIPT_UPDATED'],'alert-success');
		//echo $this->db->last_query(); die;

		// for Good Receipt approve//
		if($savegr=='approvegr'){
			// for all current stock received completed//
			
			$this->db->select("GR.pi_ids");
			$this->db->from("ffc_goodreceipt GR");
			$this->db->where("GR.ID",$ROWID);
			$pi_ids=$this->db->get()->row()->pi_ids;
			$pi_ids=explode(',',$pi_ids);
			
			$this->db->select("GRP.pi_id,SUM(GRP.total_receipted) as total_receipted");
			$this->db->from("ffc_goodreceipt_parts GRP");
			$this->db->where_in("GRP.pi_id",$pi_ids);
			//$this->db->order_by('GRP.ID','DESC');
			$this->db->Group_by('GRP.pi_id');
			$result=$this->db->get()->result();
			
			foreach ($result as $value) {	
			$this->db->select("SUM(IP.total_cases) as total_cases");
			$this->db->from("ffc_invoice_parts IP");
			$this->db->where("IP.pi_id",$value->pi_id);
			$total_cases=$this->db->get()->row()->total_cases;
			
			if($value->total_receipted==$total_cases){
				$this->db->where("ID",$value->pi_id);
				$this->db->update('ffc_invoice', array('is_gr_complete'=>1));

				$shipment_ids=explode(',',$postData['shipment_id']);
                $this->db->where_in("ID", $shipment_ids);
				$this->db->where("pi_id",$value->pi_id);
                $this->db->update('ffc_shipments', array('is_gr_complete'=>1));
			}
			}
		//end //	
		
			$this->gr_approve($postData);
		}
		//end //
		
		return true;
	}	
 
	public function gr_approve($postData){
		
		$ROWID=$postData['ID'];
		$goodreceipt_invoiceid=$postData['goodreceipt_invoiceid'];
		$receipt_date=date("Y-m-d",strtotime($postData['receipt_date']));
		$manufacturer=$postData['manufacturer']; 
		$parts_id=$postData['parts_id'];
        $part_colors=$postData['part_colors'];
        $total_receipt=$postData['total_receipt'];
		$pi_id=$postData['pi_id'];
		
		$resultstockledger=array();
		if($parts_id && count($parts_id)>0){
        foreach ($parts_id as $key=>$parts_id) { 
        if($parts_id>0 && $total_receipt[$key]>0){ 
		
			$this->db->select("current_stock");
			$this->db->from("ffc_stockledger SI");
			$this->db->where("SI.manufacturer",$manufacturer[$key]);
			$this->db->where("SI.parts_id",$parts_id);
			$this->db->where("SI.part_colors",$part_colors[$key]);
			$this->db->order_by('ID','desc')->limit(1);
			$result=$this->db->get()->row();
			//print_r($result);die;
			$sl_current_stock=$result?$result->current_stock:0;
			//echo $this->db->last_query(); die;	
			
			$resultstockledger[]= array('goodreceipt_id'=>$ROWID,
												'reference_no'=>$goodreceipt_invoiceid,
												'ledger_date' => $receipt_date,
												'manufacturer' => $manufacturer[$key],
												'parts_id'=>$parts_id,
												'part_colors'=>$part_colors[$key],
												'effected_stock'=>$total_receipt[$key],
												'current_stock'=>$total_receipt[$key]+$sl_current_stock,
												'process'=>'Goods Receipt',
												'pi_id'=>$pi_id[$key],
										);
                }
		}
		}		
	//echo "<pre>";print_r($resultstockledger); die;
	if(count($resultstockledger)>0)$this->db->insert_batch('ffc_stockledger',$resultstockledger);	
	
	$this->db->where("ID",$ROWID);
	$this->db->update($this->main_table, array('gr_status'=>1));
	
	setFlashMsg('success_message',$this->MESSAGE['GOODRECEIPT_APPOVED'],'alert-warning');
	
	return true;
	}
 
 
 
       public function loadDataByIdd($ID='',$all_records=1)
    {
        $this->load->model('parts_model');
    	if($ID!=''){
    		$ID=(is_numeric($ID))?md5($ID):$ID;
	    	$this->db->select("P.*");
	    	$this->db->from("ffc_invoice P");
                //$this->db->where("P.is_deleted",0);
	    	$this->db->where("MD5(P.ID)",$ID);
	    	$result=$this->db->get()->row();
            //echo $this->db->last_query(); die;
			
            $this->db->select("PP.*,P.name as part_name,M.ID as manufacturer_id,M.name as manufacturer_name");
            $this->db->from("ffc_invoice_parts PP");
            $this->db->where("MD5(pi_id)",$ID);
            $this->db->join("ffc_parts P","P.ID=PP.parts_id","LEFT");
			$this->db->join("ffc_invoice I","I.ID=PP.pi_id","LEFT");
			$this->db->join("ffc_manufacturer M","M.ID=I.manufacturer_id","LEFT");
            $result2=$this->db->get()->result();
             
            foreach ($result2 as $key => $value) { 

                     $partColorsList=$this->parts_model->getPartscolorByPartsId($value->parts_id);
                     if($all_records==1){
                            $value->partColorsList=$partColorsList['colorList'];
                        }
                        $this->db->select("SUM(GP.total_receipted) as total_receipted");
                        $this->db->from("ffc_goodreceipt_parts GP");
						
                        $this->db->group_by("pi_parts_id");
                        $this->db->where("pi_parts_id",$value->ID);
                        $this->db->where("md5(pi_id)",$ID);
                        $gp=$this->db->get()->row();
                        //print_r($gp); die;
                        $value->total_receipted=($gp)?$gp->total_receipted:'0.00';
                        
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
           // $result->season=$result1;    
            $result->parts=$result2;
         // print_r($result); die;
	    	return $result;
    	}    	
    }
    
    
     public function loadDataById($ID='',$all_records=1)
    {
       if($ID!=''){
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->select("GR.*,");
			$this->db->from($this->main_table." GR");
            $this->db->where("GR.is_deleted",0);
            $this->db->where("MD5(GR.ID)",$ID);
			$this->db->join("ffc_goodreceipt_parts GRP","GRP.goodreceipt_id=GR.ID","LEFT");
            $result=$this->db->get()->row();
            $shipment_ids=explode(',',$result->shipment_ids);
            $this->db->select("SH.shipment_id");
            $this->db->from("ffc_shipments SH");
            $this->db->where_in("SH.ID",$shipment_ids);
            //$query=$this->db->query("SELECT shipment_id FROM ffc_shipments WHERE ID IN (".$result->pi_ids.")");
			$result2=$this->db->get()->result();
            foreach($result2 as $value2){$shipment_id[]=$value2->shipment_id;}
			$result->shipment_id=implode(', ',$shipment_id);
            $shipment_id=NULL;
			

			$this->db->select("GRP.*,P.name as part_name,M.ID as manufacturer_id,M.name as manufacturer_name");
            $this->db->from("ffc_goodreceipt_parts GRP");
            $this->db->where("MD5(goodreceipt_id)",$ID);
			
            $this->db->join("ffc_parts P","P.ID=GRP.parts_id","LEFT");
			$this->db->join("ffc_manufacturer M","M.ID=GRP.manufacturer","LEFT");
			
            $result2=$this->db->get()->result();

            foreach ($result2 as $key => $value) { 

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
            $result->parts=$result2;
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
    			setFlashMsg('success_message',$this->MESSAGE['GOODRECEIPT_DEACTIVE_STATUS'],'alert-info');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['GOODRECEIPT_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['GOODRECEIPT_DELETE'],'alert-danger');

            // for all current stock received incompleted //
            $this->db->select("GR.pi_ids,GR.shipment_ids");
            $this->db->from($this->main_table." GR");
            $this->db->where("GR.ID",$ID);
            $result=$this->db->get()->row();
            $shipment_ids= explode(',',$result->shipment_ids);
            $pi_ids= explode(',',$result->pi_ids);

            $this->db->where_in("ID",$pi_ids);
            $this->db->update('ffc_invoice', array('is_gr_complete'=>0));

            $this->db->where_in("ID", $shipment_ids);
            $this->db->update('ffc_shipments', array('is_gr_complete'=>0));

            //end //

	    	$updateData=array('is_deleted'=>1);
	    }

	    	$this->db->where("ID",$ID);
	    	$this->db->update($this->main_table,$updateData);
			$this->db->where("goodreceipt_id",$ID);
			$this->db->delete('ffc_goodreceipt_parts');
			$this->db->where("goodreceipt_id",$ID);
			$this->db->delete('ffc_stockledger');

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
                        $this->db->select("GR.shipment_ids,GR.pi_ids");
                        $this->db->from($this->main_table." GR");
                        $this->db->where("GR.ID",$ids[$i]);
                        $result=$this->db->get()->row();
                        $shipment_ids= explode(',',$result->shipment_ids);
                        $pi_ids= explode(',',$result->pi_ids);

					// for all current stock received incompleted //
					$this->db->where_in("ID",$pi_ids);
					$this->db->update('ffc_invoice', array('is_gr_complete'=>0));
					//end //

                    // for shipment not received
                    //$this->db->where_in("pi_id",$result->pi_ids);
                    $this->db->where_in("ID", $shipment_ids);
                    $this->db->update('ffc_shipments', array('is_gr_complete'=>0));
                    //end

                        $this->db->where("goodreceipt_id",$ids[$i]);
                        $this->db->delete('ffc_goodreceipt_parts');
						$this->db->where("goodreceipt_id",$ids[$i]);
						$this->db->delete('ffc_stockledger');
                        
                }

	    	setFlashMsg('success_message',$this->MESSAGE['GOODRECEIPT_DELETE_BULK'],'alert-danger');
	    	return true;
    	}
    }
    

}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */