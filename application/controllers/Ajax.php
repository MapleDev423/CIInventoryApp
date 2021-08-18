<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {
	public function __construct()
        {
            parent::__construct();
            $this->load->model('parts_model');
            
	}
    public function getPartsByManufacturer() 
    {
        $this->load->model('parts_model');
        $data = $this->parts_model->getPartsByManufacturer(); 

        echo json_encode($data);  
    }
	
	public function getPartsnameByManufacturer() 
    {
        $this->load->model('stockissue_model');
        $data = $this->stockissue_model->getPartsnameByManufacturer(); 
        echo json_encode($data);  
    }
	
	public function getPartsnameByManufacturer_for_goodreceiptreport() 
    {
        $this->load->model('goodsreceiptreport_model');
        $data = $this->goodsreceiptreport_model->getPartsnameByManufacturer(); 
        echo json_encode($data);  
    }
	
	public function getPartsnameByManufacturer_for_issuereport() 
    {
        $this->load->model('stockissue_report_model');
        $data = $this->stockissue_report_model->getPartsname(); 
        echo json_encode($data);  
    }
	
	public function getPartsnameByManufacturer_for_stockledgerreport() 
    {
        $this->load->model('stockledgerreport_model');
        $data = $this->stockledgerreport_model->getPartsnameByManufacturer(); 
        echo json_encode($data);  
    }
	
    /* purchase order ajax functions */
    public function getPartsByPlanning() 
    {
        $this->load->model('planningsheets_model');
        $ID = $this->input->post('planningsheet_id');
        $data = $this->planningsheets_model->loadPlanningDataById($ID); 
        $mfg=$this->manufacturer_model->loadDataById($data->manufacturer_id);
        $data->mfg=$mfg->name;
        echo json_encode($data);  
    }
    
    public function getPartsByPlannings() 
    {
        $this->load->model('planningsheets_model');
        $ID = $this->input->post('planningsheet_id');
        $details = $this->planningsheets_model->loadDataById($ID);
        $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
        $data['partsList']=$partsList;
        $data['details']=$details;
        $this->load->view('planningsheet_parts',$data);
        //echo json_encode($data);  
    }
    
    public function getPartsAddnew() 
    {
        
        $this->load->view('planningsheet_AddNew',$data);
    }
    
    public function getPartstotals() 
    {
        
        $this->load->view('planningsheet_totalsdef',$data);
    }
    
    public function getPartsByPlanningtotals() 
    {
        $this->load->model('planningsheets_model');
        $ID = $this->input->post('planningsheet_id');
        $details = $this->planningsheets_model->loadDataById($ID);
        $data['details']=$details;
        $this->load->view('planningsheet_totals',$data);
        //echo json_encode($data);  
    }
    /* Performa invoice ajax function */
    public function getPartsByPorder() 
    {
        $this->load->model('purchaseorder_model');
        $ID = $this->input->post('porderid');
        $data = $this->purchaseorder_model->loadPODataById($ID); 
        $mfg=$this->manufacturer_model->loadDataById($data->manufacturer_id);
        $data->mfg=$mfg->name;
        echo json_encode($data);  
    }
    
    public function getPartsByPOrderss() 
    {
        $this->load->model('purchaseorder_model');
        $ID = $this->input->post('porderid');
        $details = $this->purchaseorder_model->loadDataById($ID);
        $partsList = $this->parts_model->getPartsByManufacturer($details->manufacturer_id);
		$this->load->model('manufacturer_model');
		$manufacturer_detail=$this->manufacturer_model->getData(1);
		$data['manufacturer']=$manufacturer_detail;
        $data['partsList']=$partsList;
        $data['details']=$details;
        $this->load->view('planningsheet_parts',$data);
        //echo json_encode($data);  
    }
    
    public function getPOPartsAddnew() 
    {
        
        $this->load->view('planningsheet_AddNew',$data);
    }
    
    public function getPOPartstotals() 
    {
        
        $this->load->view('planningsheet_totalsdef',$data);
    }
    
    public function getPartsByPordertotals() 
    {
        $this->load->model('purchaseorder_model');
        $ID = $this->input->post('porderid');
        $details = $this->purchaseorder_model->loadDataById($ID);
        $data['details']=$details;
        $this->load->view('planningsheet_totals',$data);
        //echo json_encode($data);  
    }
    
    
    /* common functions  */
    
    public function getcolors()
    {
        $color_list=$this->common_model->getColor();
        echo json_encode($color_list); die;
    }

    public function getPartscolorByPartsId()
    {
        $this->load->model('parts_model');
        $partscolor_list=$this->parts_model->getPartscolorByPartsId();
        echo json_encode($partscolor_list); die;
    }
	
	public function getPartscolorByPartsIdforissue()
    {
        $this->load->model('Stockissue_model');
        $partscolor_list=$this->Stockissue_model->getPartscolorByPartsId();
        echo json_encode($partscolor_list); die;
    }
	
	
    public function getPartsColorImg($value='')
    {
        $this->load->model('parts_model');
        $partscolorimg=$this->parts_model->getPartsColorImg();
        echo json_encode($partscolorimg); die;
    }
	
	public function getPartDetailsForStockIssue($value='')
    {
        $this->load->model('stockissue_model');
        $partdetails=$this->stockissue_model->getPartStockForIssue();
        echo json_encode($partdetails); die;
    }
	
    public function bom_modal() 
        {
           $this->load->model('bom_model');
           $bom_id = $this->input->post('bom_id');
           $resultList=$this->bom_model->loadDataById($bom_id);
           
            $data['resultList'] =$resultList;
            $data['title'] = "Add Timesheet Details";
            $this->load->view('bom_modal',$data);

        }
        
        public function editsheetparts()
	{  
            
            $details='';
            $CID = $this->input->post('colid');
            $ID = $this->input->post('parts_id');
            if($ID!=''){                   
                $details=$this->parts_model->loadDataById($ID);
                $this->mode='Edit';
                if($details->other_part_type==1){
                    $partsTypeDetails=$this->parts_model->partTypeDetails($details->part_type);
                    $details->part_type_title=$partsTypeDetails->title;
                    $details->part_type_other_id=$details->part_type;
                }
                
            
            
            //print_r($details); die;
            $this->load->model('manufacturer_model');
            $manufacturer_detail=$this->manufacturer_model->getData(1);
            $colorList=$this->common_model->getColor();
            if($details && $details->other_part_type==1){
                $partsTypeList=$this->parts_model->getPartsType($details->part_type);
            }else{
                $partsTypeList=$this->parts_model->getPartsType();
            }



            $data['manufacturer_detail']=$manufacturer_detail;
            $data['mode']=$this->mode;
            $data['colorList']=$colorList;
            $data['partsTypeList']=$partsTypeList;
            $data['details']=$details;
            $data['main_page']=$this->main_page;
            $data['heading']=$this->heading;
            $data['CID']=$CID;
            $data['ITEM']=$details->name;
            $this->load->view('addedit_sheetparts',$data);
            }
	}
        
        public function savepartdetails()
	{  
           // print_r($this->input->post());
            //print_r($_FILES);
            
            if($_POST){
                if($this->parts_model->savepartdetails()){
                        echo json_encode($this->input->post()); die;
                }
               
            }
        }

    public function getPIDetailsByPI_id(){
        $this->load->model('goodreceipt_model');
        $ID= $this->input->post('ID');
        $details=$this->goodreceipt_model->loadDataByIdd($ID);
        $data['details']=$details;
        $data['pi_no']=$ID;
        echo json_encode($data);
        die;
    }

    public function getShipmentDetails(){
        $ID= $this->input->post('ID');
        $this->load->model('shipments_model');
        $details=$this->shipments_model->loadDataById($ID);
        echo $details->pi_id; die;
    }

    public function getProformaInvoice(){
				
			$this->load->model('goodreceipt_model');  
			$this->load->model('parts_model');
			$this->load->model('manufacturer_model');
			$this->load->model('planningsheets_model');
			$ID= $this->input->post('ID');
			
			$details=$this->goodreceipt_model->loadDataByIdd($ID);
			
			$data['order_no_new']=date("mdY").'-'.rand(10000,99999);
			$data['details']=$details;
			$data['pi_no']=$ID;				
			$this->load->view('goodreceipt',$data);
            return; 
        }
		
	  public function openPartStockDetails()
	{  
			$part_id = $this->input->post('part_id');
			$name = $this->input->post('name');
			$manufact = $this->input->post('manufact');
              
			$this->load->model('currentstock_model');
			$result=$this->currentstock_model->getData_popup($part_id);       
			$data['resultList']=$result;
			$data['heading']="Current Stock for ".$name;
			$data['name']=$name;
			$data['manufact']=$manufact;
			//print_r($data);
			$this->load->view('current_stock_details',$data);
	
	}		
    

	public function getBomByProduct(){
		$product_id = $this->input->post('product_id');
		$this->load->model('products_model');
		$bomList=$this->products_model->getBomByProduct($product_id);
        //print_r($result);die;
		echo json_encode($bomList); die;
	}
	
	 public function bom_modalformanufactureplanning() 
        {
           $this->load->model('bom_model');
           $bom_id = $this->input->post('bom_id');
           $resultList=$this->bom_model->loadDataById($bom_id);
          //print_r($result);die;
			echo json_encode($resultList); die;

        }
	
	
    
}