<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manufacture_planning_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_stockissue";
    }
    
    
    public function getData()
    {
		$this->db->select("SI.*,CONCAT(E.first_name,' ',E.last_name) as employee_name");
		$this->db->from($this->main_table." SI ");
        $this->db->where("SI.is_deleted",0);
		$this->db->join("ffc_employee E","E.ID=SI.employee_id","LEFT");
		$this->db->order_by('SI.ID','DESC');
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
    	$issue_date=$postData['issue_date'];
        $employee_id=$postData['employee_id'];
		$total_issuestock=array_sum($postData['issuestock']);
		foreach($postData['issuestock'] as $key=>$value){
			if($value!=0 && $value!=''){
			$total_currentstock+=$postData['currentstock'][$key];
			}
		}
		$total_pendingstock=$total_currentstock-$total_issuestock;
		$manufacturer_id=$postData['manufacturer_id'];
		$parts_id=$postData['parts_id'];
        $part_colors=$postData['part_colors'];
        $currentstock=$postData['currentstock'];
		$issuestock=$postData['issuestock'];
       
        $insertData=array(	'issue_date'=>$issue_date,
							'employee_id'=>$employee_id,
							'total_currentstock'=>$total_currentstock,
							'total_pendingstock'=>$total_pendingstock,
							'total_issuestock'=>$total_issuestock,
							'updated_by'=>$LOGINID,
							'updation_date'=>$crr_date,
							'is_deleted'=>0,
						);

        if ($ID!='') {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);
            
            setFlashMsg('success_message',$this->MESSAGE['MANUFACTUREPLANNING_UPDATED'],'alert-success');

        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();  
            
            $stockissue_id='SI-'.strtoupper(date("dMy",strtotime($issue_date))).'-'.$ROWID;
            $this->db->where("ID",$ROWID);
            $this->db->update($this->main_table, array('stockissue_id'=>$stockissue_id));
            
            setFlashMsg('success_message',$this->MESSAGE['MANUFACTUREPLANNING_ADDED'],'alert-success');

        }
        $resultStockissueparts=array();
		$resultGoodreceiptParts=array(); 
        if($parts_id && count($parts_id)>0){
            foreach ($parts_id as $key=>$pid) {
                if($pid>0 && $issuestock[$key]>0 && $issuestock[$key]!='' ){ 
					
				$this->db->select("current_stock");
				$this->db->from("ffc_stockledger SI");
				$this->db->where("SI.manufacturer",$manufacturer_id[$key]);
				$this->db->where("SI.parts_id",$pid);
				$this->db->where("SI.part_colors",$part_colors[$key]);
				$this->db->order_by('ID','desc')->limit(1);
				$sl_current_stock=$this->db->get()->row()->current_stock;
				
				    $resultStockissueparts[]= array('si_id'=>$ROWID,
                                             'parts_id'=>$pid,
                                             'part_colors'=>$part_colors[$key],
                                             'manufacturer_id'=>$manufacturer_id[$key],
                                             'currentstock'=>$currentstock[$key],
											'pendingstock'=>$currentstock[$key]-$issuestock[$key],
                                             'issuestock'=>$issuestock[$key]);
                    
					
					$resultstockledger[]= array('si_id'=>$ROWID,
												'reference_no'=>$stockissue_id,
												'employee_id'=>$employee_id,
												'ledger_date' => $issue_date,
												'manufacturer' => $manufacturer_id[$key],
												'parts_id'=>$pid,
												'part_colors'=>$part_colors[$key],
												'effected_stock'=>$issuestock[$key],
												'current_stock'=>$sl_current_stock-$issuestock[$key],
												'process'=>'Stock Issue');
				}
            }
        }        
        //print_r($resultstockledger); die;
        if(count($resultStockissueparts)>0)$this->db->insert_batch('ffc_stockissue_parts',$resultStockissueparts);
		if(count($resultstockledger)>0)$this->db->insert_batch('ffc_stockledger',$resultstockledger);
       // echo $this->db->last_query(); die;
        return true;

    }

     public function loadDataById($ID='',$all_records=1)
    {
    	if($ID!=''){
        $ID=(is_numeric($ID))?md5($ID):$ID;
		$this->db->select("SI.*,CONCAT(E.first_name,' ',E.last_name) as employee_name");
		$this->db->join("ffc_employee E","E.ID=SI.employee_id","LEFT");
		$this->db->from($this->main_table." SI ");
        $this->db->where("MD5(SI.ID)",$ID);
		$this->db->where("SI.is_deleted",0);
		$this->db->order_by('SI.ID','DESC');
    	$result=$this->db->get()->row();
        //echo $this->db->last_query(); die;
		//print_r($result); die;
		$this->db->select("SIP.*,M.name as manufacturer_name,P.name as part_name");
		$this->db->join("ffc_manufacturer M","M.ID=SIP.manufacturer_id","LEFT");
		$this->db->join("ffc_parts P","P.ID=SIP.parts_id","LEFT");
		$this->db->from("ffc_stockissue_parts SIP");
		$this->db->where("MD5(si_id)",$ID);
        $this->db->order_by('SIP.ID','ASC');
    	$result->parts=$this->db->get()->result();
        //print_r($result); die;
		
		 foreach ($result->parts as $key => $value) { 

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
		
		
		
		
	    return $result;
    	}    	
    }
 
 
 public function getManufacturer()
    {
    	$this->db->select("SIP.manufacturer_id as ID,M.name");
		$this->db->join("ffc_manufacturer M","M.ID=SIP.manufacturer_id","LEFT");
		$this->db->from("ffc_stockissue_parts SIP");
		$this->db->group_by("SIP.manufacturer_id");
    	$this->db->order_by('M.name','asc');
    	$result=$this->db->get()->result();
    	return $result;
    }
 
 public function getPartsnameByManufacturer($m_id_val='')
    {
        $partsList=array();
        $postData=$this->input->post();
    	$manufacturer_id=(isset($postData['manufacturer_id']))?$postData['manufacturer_id']:'';
       $manufacturer_id=($m_id_val>0)?$m_id_val:$manufacturer_id;
        if($manufacturer_id){
            $this->db->select("SIP.parts_id,P.name");
			$this->db->where("SIP.manufacturer_id",$manufacturer_id);
			$this->db->join("ffc_parts P","P.ID=SIP.parts_id","LEFT");
            $this->db->from("ffc_stockissue_parts SIP");
			$this->db->group_by("SIP.parts_id");
			$this->db->order_by('P.name','asc');
			$partsList=$this->db->get()->result();
            
		foreach($partsList as $value){
			$this->db->select("SUM(GRP.total_receipted) as total_receipted");
			$this->db->from("ffc_goodreceipt_parts GRP");
			$this->db->where("GRP.parts_id",$value->parts_id);
			$this->db->where("GRP.manufacturer",$manufacturer_id);
			$total_receipted=$this->db->get()->row()->total_receipted;
			
			$this->db->select("SUM(SIP.issuestock) as issuestock");
			$this->db->from("ffc_stockissue_parts SIP");
			$this->db->where("SIP.parts_id",$value->parts_id);
			$this->db->where("SIP.manufacturer_id",$manufacturer_id);
			$issuestock=$this->db->get()->row()->issuestock;	
			$value->pending=$total_receipted-$issuestock;
			}		
		//echo $this->db->last_query(); die;	
		//print_r($partsList);die;	
	
		return $partsList;
        }
	}
  
   public function getPartscolorByPartsId($midval='',$idval='')
    {
        $partsColorList=$result_array=array();
        $postData=$this->input->post();
		$parts_id=(isset($postData['parts_id']))?$postData['parts_id']:'';
        $parts_id=($idval>0)?$idval:$parts_id;
        $manufacturer_id=(isset($postData['manufacturer_id']))?$postData['manufacturer_id']:'';
		$manufacturer_id=($midval>0)?$midval:$manufacturer_id;
		
		if($parts_id){
            $this->db->select("SIP.part_colors");
            $this->db->from("ffc_stockissue_parts SIP");
            $this->db->where("SIP.manufacturer_id",$manufacturer_id);
			$this->db->where("SIP.parts_id",$parts_id);
			$this->db->group_by("SIP.part_colors");
            $this->db->order_by("SIP.part_colors",'asc');
			$resultData=$this->db->get()->result();
			
			foreach($resultData as $value){
			$this->db->select("SUM(GRP.total_receipted) as total_receipted");
			$this->db->from("ffc_goodreceipt_parts GRP");
			$this->db->where("GRP.part_colors",$value->part_colors);
			$this->db->where("GRP.parts_id",$parts_id);
			$this->db->where("GRP.manufacturer",$manufacturer_id);
			$total_receipted=$this->db->get()->row()->total_receipted;
			
			$this->db->select("SUM(SIP.issuestock) as issuestock");
			$this->db->from("ffc_stockissue_parts SIP");
			$this->db->where("SIP.part_colors",$value->part_colors);
			$this->db->where("SIP.parts_id",$parts_id);
			$this->db->where("SIP.manufacturer_id",$manufacturer_id);
			$issuestock=$this->db->get()->row()->issuestock;	
			$value->pending=$total_receipted-$issuestock;
			}	
        }
        //print_r($resultData);die;
        return $resultData;
    }

  function getPartStockForIssue($midval='',$parts_idval='',$parts_color_val='')
	{ 
		$postData=$this->input->post(); 
        $parts_id=(isset($postData['parts_id']))?$postData['parts_id']:'';
        $parts_id=($parts_idval>0)?$parts_idval:$parts_id;

        $part_colors=(isset($postData['part_colors']))?$postData['part_colors']:'';
        $part_colors=($parts_color_val!="")?$parts_color_val:$part_colors;
		
		$manufacturer_id=(isset($postData['manufacturer_id']))?$postData['manufacturer_id']:'';
		$manufacturer_id=($midval>0)?$midval:$manufacturer_id;
		
        $this->db->select("sum(GRP.total_receipted) as total_receipted");
		$this->db->from("ffc_goodreceipt_parts GRP");
		$this->db->where("manufacturer",$manufacturer_id);
        $this->db->where("parts_id",$parts_id);
        $this->db->where("part_colors",$part_colors);
        $result=$this->db->get()->row();
		
		$this->db->select("sum(SIP.issuestock) as issuestock");
		$this->db->from("ffc_stockissue_parts SIP");
		$this->db->where("SIP.manufacturer_id",$manufacturer_id);
		$this->db->where("SIP.parts_id",$parts_id);
        $this->db->where("SIP.part_colors",$part_colors);
		$result2=$this->db->get()->row();
		$result->issuestock=($result2->issuestock)?$result2->issuestock:0;
		return $result;
	}
  
  
  function get_assemblyline(){
		$this->db->select("AL.*");
		$this->db->from("ffc_assemblyline AL");
		$this->db->where("AL.is_deleted",'0');  
		$result=$this->db->get()->result();
		//print_r($result); die;
		return $result;
  }
  
    public function singleAction($value='')
    {
    	$action=replaceEmpty('action');
    	$ID=replaceEmpty('ID');
    	$callbackurl=replaceEmpty('callbackurl');
    	if($action!='' && $ID>0){
    		if($action=='deactive'){
    			$updateData=array('status'=>0);
    			setFlashMsg('success_message',$this->MESSAGE['MANUFACTUREPLANNING_DEACTIVE_STATUS'],'alert-info');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['MANUFACTUREPLANNING_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['MANUFACTUREPLANNING_DELETE'],'alert-danger');
	    	$updateData=array('is_deleted'=>1);
	    }

	    	$this->db->where("ID",$ID);
	    	$this->db->update($this->main_table,$updateData);
			$this->db->where_in("si_id",$ID);
            $this->db->delete('ffc_stockissue_parts');
			$this->db->where_in("si_id",$ID);
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
            
			$this->db->where_in("si_id",$ids);
            $this->db->delete('ffc_stockissue_parts');
            $this->db->where_in("si_id",$ids);
            $this->db->delete('ffc_stockledger');
			
	    	setFlashMsg('success_message',$this->MESSAGE['MANUFACTUREPLANNING_DELETE_BULK'],'alert-danger');
	    	return true;
    	}
    }
    




}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */