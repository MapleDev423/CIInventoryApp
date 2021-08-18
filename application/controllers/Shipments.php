<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipments extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoice_model');
        $this->load->model('shipments_model');
        $this->main_page=base_url('/'.strtolower(get_class($this)));
        $this->heading='Shipments';
        $this->mode='Add';
    }


    public function index()
    {
        if(!checkModulePermission(24,1)){
            redirect('dashboard'); die;
        }

        $action=replaceEmpty('action');
        if($action!=''){
            if($this->shipments_model->singleAction()){
                redirect($this->main_page); die;
            }
        }elseif ($_POST && isset($_POST['bulk_action'])) {
            if($this->shipments_model->bulkAction()){
                redirect($this->main_page); die;
            }
        }

        $result=$this->shipments_model->getData();
        $data['resultList']=array();;
        $data['resultList']=$result;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
        $this->layout('manage_shipments',$data);
    }

    public function addedit($ID='')
    {
        if(!checkModulePermission(24,2)){
            redirect('dashboard'); die;
        }

        $details='';
        if($_POST){
            //print_r($_POST);die;
            if($this->shipments_model->addedit()){
                redirect($this->main_page); die;
            }
        }

        if($ID!=''){
            $details=$this->shipments_model->loadDataById($ID);
            $this->mode='Edit';
        }

        $proformaDetails=$this->shipments_model->get_ProformaInvoiceID();

        $data['proformaDetails']=$proformaDetails;
        $data['details']=$details;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
        $data['mode']=$this->mode;

        //print_r($data);die;
        $this->layout('addedit_shipments',$data);
    }

    public function view($ID='')
    {
        if(!checkModulePermission(24,1)){
            redirect('dashboard'); die;
        }

        $details=$this->shipments_model->loadDataById($ID);
        $this->mode='View';

        $data['details']=$details;
        $data['main_page']=$this->main_page;
        $data['heading']=$this->heading;
        $data['mode']=$this->mode;
        $this->layout('view_shipments',$data);
    }

    function generate_shipments(){
        if($_POST){
            if($this->shipments_model->generate_shipments()){
                redirect($this->main_page); die;
            }
        }
    }

}

/* End of file Purchaseorder.php */
/* Location: ./application/controllers/Purchaseorder.php */