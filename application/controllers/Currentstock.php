<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currentstock extends MY_Controller {

public function __construct()
	{
            parent::__construct();        
            $this->main_page=base_url('/'.strtolower(get_class($this)));
            $this->heading='Current Stock Report';
			$this->load->model('currentstock_model');
            $this->mode='View';
	}
	public function index()
	{   
        if(!checkModulePermission(19,2)){
            redirect('dashboard'); die;
        }
		
        $result=$this->currentstock_model->getData();
       
		$data['resultList']=$result;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
        $this->layout('report_currentstock',$data);
	}
	
	public function current_stock_report()
	{  

	if(!checkModulePermission(19,2)){
            redirect('dashboard'); die;
        }
		
        $result=$this->currentstock_model->getDataCurrentStock(); 
		$manufacturer_detail=$this->currentstock_model->getManufacturer();
	
		$data['manufacturer']=$manufacturer_detail;
		$data['resultList']=$result;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
		$this->layout('report_current_stock',$data);
	}
	
	public function csv_for_current_stock_report(){
		if(!checkModulePermission(19,2)){
            redirect('dashboard'); die;
        }
		
		$result=$this->currentstock_model->getDataCurrentStock();
		$today=date('Y-m-d');
		$grand_total_cost='0.00';
		
		$filename ="Stock-billing-report(".$today.").xls";
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: attachment; filename=exportfile.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$contents="S.No.\t Item Number \t Item Name\t Manufacturer \t Color \t Current Stock \n";

		$i=1;
		foreach($result as $data){
			$pi_date=$data->pi_date;
			$name=$data->name;
			$description=($data->description!='')?$data->description:"N/A";
			$manufact=$data->manufact;
			$part_colors=$data->part_colors;
			
			$total_cost=($data->issuestock!='')?number_format((float)($data->total_receipted-$data->issuestock), 2, '.', ''):$data->total_receipted;
			$grand_total_cost+=$total_cost;		
			
			$contents.=$i."\t".$name."\t".$description."\t".$manufact."\t".$part_colors."\t".$total_cost."\n";
			$i++;
		}
		echo $contents.="\t Total \t\t\t\t".$grand_total_cost."\n";
		exit;
			
	}
	
	
	public function stock_billing_report(){   
        if(!checkModulePermission(20,2)){
            redirect('dashboard'); die;
        }
		
        $result=$this->currentstock_model->getDataStockBilling();
		$manufacturer_detail=$this->currentstock_model->getManufacturer();
	
		$data['manufacturer']=$manufacturer_detail;
		$data['resultList']=$result;
        $data['main_page']=$this->main_page;
        $data['heading']="Stock billing report";
		$this->layout('report_stock_billing',$data);
	}
	
	public function csv_for_stock_billing_report(){
		 if(!checkModulePermission(20,2)){
            redirect('dashboard'); die;
        }
		
		$result=$this->currentstock_model->getDataStockBilling();
		$today=date('Y-m-d');
		$grand_total_cases='0.00';
		$grand_total_cost='0.00';
			
		$filename ="Stock-billing-report(".$today.").xls";
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: attachment; filename=exportfile.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$contents="S.No.\t Date \t Item Number \tItem Name\t Manufacturer \t Color \t Total Quantity \t Total Cost \n";

		$i=1;
		foreach($result as $data){
			$pi_date=$data->pi_date;
			$name=$data->name;
			$description=($data->description!='')?$data->description:"N/A";
			$manufact=$data->manufact;
			$part_colors=$data->part_colors;
			$total_cases=$data->total_cases;
			$total_cost=$data->total_cost;
			$grand_total_cases+=$data->total_cases;
			$grand_total_cost+=$data->total_cost;		
			
			$contents.=$i."\t".$pi_date."\t".$name."\t".$description."\t".$manufact."\t".$part_colors."\t".$total_cases."\t".$total_cost."\n";
			$i++;
		}
		echo $contents.="\t Total \t\t\t\t\t".$grand_total_cases."\t".$grand_total_cost."\n";
		exit;
			
	}
	
	
	
}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */