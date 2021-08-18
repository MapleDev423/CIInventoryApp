<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parts_model extends CI_Model {
    public $MESSAGE,$main_table;
    public function __construct()
    {
        parent::__construct();
        $this->MESSAGE= $this->config->item('MESSAGE');
        $this->main_table="ffc_parts";
    }

    public function getData($is_active='')
    {
    	$this->db->select("P.*, GROUP_CONCAT(PC.color_code) as color_codes");
    	$this->db->from($this->main_table." P");
    	if($is_active==1)$this->db->where("status",1);
    	$this->db->where("P.is_deleted",0);
        $this->db->join("ffc_parts_color PC","PC.parts_id=P.ID","LEFT");
    	$this->db->order_by('ID','DESC');
        $this->db->group_by("P.ID");
    	$result=$this->db->get()->result();
        
        if(!empty($result)){
            foreach($result as $res){
                $manufacturer=($res && isset($res->manufacturer))?explode(',',$res->manufacturer):'';
                $manufact='';
                for($i=0; $i<count($manufacturer); $i++){
                    $this->load->model('manufacturer_model');
                    $details=$this->manufacturer_model->loadDataById($manufacturer[$i]);
                    if(!empty($details)){
                        if(isset($details->name) && $details->name!=''){
                            $manufact .=$details->name;
                            if($i<count($manufacturer)-1){

                                $manufact .=' , ';
                            }
                        }
                    }
                }
                $res->manufact=$manufact;
            }
        }
         //print_r($result);
         //die;
    	return $result;
    }
	public function gethistorical($ID)
	{
		//$ID =2; 
		//665f644e43731ff9db3d341da5c827e1

			$query   = $this->db->query("SELECT 	i.pi_date as order_date,
											i.invoiceid as invoiceid, 
											MAX(ip.parts_price) as price,
											max(s.freight) as freight,
											SUM(ip.total_pcs) as qty,
											((SUM(ip.total_cost) * .09) + 245) as taxes,
											FORMAT((SUM(ip.total_cost) + ((max(s.freight) + (SUM(ip.total_cost)*.09) + 245)*(SUM(ip.total_cbm)/MAX(i.total_cbm_val))))/SUM(ip.total_pcs),2) as effprice

									FROM ffc_shipments s
									JOIN ffc_invoice i on s.pi_id = i.ID
									JOIN ffc_invoice_parts ip ON ip.pi_id = i.ID
									JOIN ffc_parts p on p.ID =  ip.parts_id
									WHERE ip.parts_id = $ID
									GROUP BY ip.pi_id
									ORDER BY i.pi_date ASC
								");

			if ($query->num_rows()) 
				return $query->result();
		
			
	}
	
	public function getfuture($ID,$freight)
	{
			$query   = $this->db->query("SELECT 	i.pi_date as order_date,
										i.invoiceid as invoiceid,
										MAX(ip.parts_price) as price,
										$freight as freight,
										SUM(ip.total_pcs) as qty,
										((SUM(ip.total_cost) * .09) + 245) as taxes,
										FORMAT(((SUM(ip.total_cost) + ($freight + (SUM(ip.total_cost)*.09) + 245)*(SUM(ip.total_cbm)/MAX(i.total_cbm_val))))/SUM(ip.total_pcs),2) as effprice

								FROM ffc_invoice i 
								JOIN ffc_invoice_parts ip ON ip.pi_id = i.ID
								JOIN ffc_parts p on p.ID =  ip.parts_id
								WHERE ip.parts_id = $ID AND
										i.ID NOT IN (SELECT pi_id FROM ffc_shipments)
								GROUP BY ip.pi_id
								ORDER BY i.pi_date ASC");
		if ($query->num_rows()) 
				return $query->result();
				
	}
	
	
	
    public function addedit($value='')
    {
    	$postData=$this->input->post();
    	$crr_date=date("Y-m-d H:i:s");
    	$LOGINID=$this->LOGINID;
    	$ID=$ROWID=$this->input->post('ID');
        //print_r($_FILES);
    	//print_r($postData); die;
    	$name=$postData['name'];
        $part_type=$postData['part_type'];
        $part_type_title=$postData['part_type_title'];
        $price=$postData['price'];
        $case_pack=$postData['case_pack'];
        $cbm=$postData['cbm'];
        $MOQ=$postData['MOQ'];
        $initial_stock=$postData['initial_stock'];
        $current_stock=$postData['current_stock'];
        $description=$postData['description'];
        $manufacturer_arr=$postData['manufacturer'];

        $color_codes=$postData['color_codes'];
        $color_image=$postData['color_image'];
        $randon_token=$postData['randon_token'];
        $color_codes_multi=(isset($postData['color_codes_multi']))?$postData['color_codes_multi']:'';
        //print_r($color_codes); print_r($randon_token); print_r($color_codes_multi); die;
        $manufacturer = implode(',', $manufacturer_arr);
        $other_part_type=0;
        if($part_type==10000){
            $part_type_new=$this->addeditPartType($part_type_title);
            $other_part_type=1;
            if(!$part_type_new){
                setFlashMsg('part_type_title_exist',"Part Type title is already exists",'',1);
                return false; die;
            }
            $part_type=$part_type_new;
        }
         
                       
                        
        $insertData=array('name'=>$name,
                        'part_type'=>$part_type,
                        'other_part_type'=>$other_part_type,
                        'price'=>$price,
                        'case_pack'=>$case_pack,
                        'cbm'=>$cbm,
                        'MOQ'=>$MOQ,
                        'initial_stock'=>$initial_stock,
                        'current_stock'=>$current_stock,
                        'description'=>$description,
                        'manufacturer'=>$manufacturer,
                        'updated_by'=>$LOGINID,
                        'updation_date'=>$crr_date,
                        );
       // print_r($insertData); die;
        $dest = $this->config->item('PARTS_DATA_DIR');
//        $resultData = uploadImg('parts_image',$dest);
        $resultData = updateImgToBucket('parts_image',$dest);

        if($resultData!==false){
            $oldfile_name= $postData['parts_image'];
            $insertData['parts_image']=$resultData['upload_data']['file_name'];
            if($oldfile_name!=''){
                remove_uploaded_fileFromBucket($oldfile_name,$dest); 
            }
        }


               
    		if ($ID!='') {
    			$ID=(is_numeric($ID))?md5($ID):$ID;
    			$this->db->where("MD5(ID)",$ID);
    			$this->db->update($this->main_table,$insertData);
                        
                        /*Update planning sheets data ****/
                        $this->db->select("PP.*");
                        $this->db->from("ffc_planningsheets PP");
                        $this->db->join("ffc_planningsheets_parts P","P.planningsheets_id=PP.ID","LEFT");
                        $this->db->where("PP.is_deleted",0);
                        $this->db->where("MD5(P.parts_id)",$ID);
                        $this->db->group_by("P.planningsheets_id");
                                                
                        $planningsheets=$this->db->get()->result();
                        
                        foreach ($planningsheets as $sheets) {
                            if($sheets->is_pi==0){
                                $this->db->select("PP.*");
                                $this->db->from("ffc_planningsheets_parts PP");
                                $this->db->where("PP.planningsheets_id",$sheets->ID);
                                $this->db->where("MD5(PP.parts_id)",$ID);
                                $ps_parts=$this->db->get()->result();

                                foreach($ps_parts as $value){
                                    $total_cases=$value->total_cases;
                                    $total_pcs= $total_cases * $case_pack;
                                    $total_cost= $total_pcs * $price;
                                    $total_cbm= $cbm * $total_cases;
                                    $pData=array(
                                        'parts_price'=>$price,
                                        'parts_moq'=>$MOQ,
                                        'currentstock'=>$case_pack,
                                        'cbm'=>round($cbm,2),
                                        'total_cases'=>$total_cases,
                                        'total_pcs'=>round($total_pcs,2),
                                        'total_cost'=>round($total_cost,2),
                                        'total_cbm'=>round($total_cbm,2)
                                    );

                                    $this->db->where(array("ID"=>$value->ID,"planningsheets_id"=>$sheets->ID));
                                    $this->db->update('ffc_planningsheets_parts',$pData);
                                }

                                $PID=$sheets->ID;

                                $this->db->select("SUM(total_cost) as total_cost_val , SUM(total_cbm) as total_cbm_val");
                                $this->db->from("ffc_planningsheets_parts PP");
                                $this->db->where("planningsheets_id",$PID);
                                $total_vals=$this->db->get()->row();
                                $this->db->where("ID",$PID);
                                $this->db->update('ffc_planningsheets',array('total_cost_val'=>$total_vals->total_cost_val, 'total_cbm_val'=>$total_vals->total_cbm_val));
                            }
                        }
                        
                       
                       // Update Purchase Order elements
                       $this->db->select("PP.*");
                        $this->db->from("ffc_purchaseorder PP");
                        $this->db->join("ffc_purchaseorder_parts P","P.po_id=PP.ID","LEFT");
                        $this->db->where("PP.is_deleted",0);
                        $this->db->where("MD5(P.parts_id)",$ID);
                        $this->db->group_by("P.po_id");
                                                
                        $porders=$this->db->get()->result();
                        
                        foreach ($porders as $pord) {
                            if($pord->is_final==0 ){
                                $this->db->select("PP.*");
                                $this->db->from("ffc_purchaseorder_parts PP");
                                $this->db->where("PP.po_id",$pord->ID);
                                $this->db->where("MD5(PP.parts_id)",$ID);
                                $ps_parts=$this->db->get()->result();

                                foreach($ps_parts as $value){
                                    $total_cases=$value->total_cases;
                                    $total_pcs= $total_cases * $case_pack;
                                    $total_cost= $total_pcs * $price;
                                    $total_cbm= $cbm * $total_cases;
                                    $pData=array(
                                        'parts_price'=>$price,
                                        'parts_moq'=>$MOQ,
                                        'currentstock'=>$case_pack,
                                        'cbm'=>round($cbm,2),
                                        'total_cases'=>$total_cases,
                                        'total_pcs'=>round($total_pcs,2),
                                        'total_cost'=>round($total_cost,2),
                                        'total_cbm'=>round($total_cbm,2)
                                    );

                                    $this->db->where(array("ID"=>$value->ID,"po_id"=>$pord->ID));
                                    $this->db->update('ffc_purchaseorder_parts',$pData);
                                }

                                $PID=$pord->ID;

                                $this->db->select("SUM(total_cost) as total_cost_val , SUM(total_cbm) as total_cbm_val");
                                $this->db->from("ffc_purchaseorder_parts PP");
                                $this->db->where("po_id",$PID);
                                $total_vals=$this->db->get()->row();
                                $this->db->where("ID",$PID);
                                $this->db->update('ffc_purchaseorder',array('total_cost_val'=>$total_vals->total_cost_val, 'total_cbm_val'=>$total_vals->total_cbm_val));
                            }
                        }
                       
                        
                        // Update Proforma Invoice elements
                       $this->db->select("PP.*");
                        $this->db->from("ffc_invoice PP");
                        $this->db->join("ffc_invoice_parts P","P.pi_id=PP.ID","LEFT");
                        $this->db->where("PP.is_deleted",0);
                        $this->db->where("MD5(P.parts_id)",$ID);
                        $this->db->group_by("P.pi_id");
                                                
                        $pinvoices=$this->db->get()->result();
                        
                        foreach ($pinvoices as $invoices) {
                            if($invoices->is_final==0 ){
                                $this->db->select("PP.*");
                                $this->db->from("ffc_invoice_parts PP");
                                $this->db->where("PP.pi_id",$invoices->ID);
                                $this->db->where("MD5(PP.parts_id)",$ID);
                                $pi_parts=$this->db->get()->result();

                                foreach($pi_parts as $value){
                                    $total_cases=$value->total_cases;
                                    $total_pcs= $total_cases * $case_pack;
                                    $total_cost= $total_pcs * $price;
                                    $total_cbm= $cbm * $total_cases;
                                    $pData=array(
                                        'parts_price'=>$price,
                                        'parts_moq'=>$MOQ,
                                        'currentstock'=>$case_pack,
                                        'cbm'=>round($cbm,2),
                                        'total_cases'=>$total_cases,
                                        'total_pcs'=>round($total_pcs,2),
                                        'total_cost'=>round($total_cost,2),
                                        'total_cbm'=>round($total_cbm,2)
                                    );

                                    $this->db->where(array("ID"=>$value->ID,"pi_id"=>$invoices->ID));
                                    $this->db->update('ffc_invoice_parts',$pData);
                                }

                                $PID=$invoices->ID;

                                $this->db->select("SUM(total_cost) as total_cost_val , SUM(total_cbm) as total_cbm_val");
                                $this->db->from("ffc_invoice_parts PP");
                                $this->db->where("pi_id",$PID);
                                $total_vals=$this->db->get()->row();
                                $this->db->where("ID",$PID);
                                $this->db->update('ffc_invoice',array('total_cost_val'=>$total_vals->total_cost_val, 'total_cbm_val'=>$total_vals->total_cbm_val));
                            }
                        }
                        
                        
                        
                        
    			setFlashMsg('success_message',$this->MESSAGE['PARTS_UPDATED'],'alert-success');
    		}else{
    			$insertData['creation_date']=$crr_date;
    			$insertData['created_by']=$LOGINID;
    			$this->db->insert($this->main_table,$insertData);
    			$ROWID=$this->db->insert_id();
    			setFlashMsg('success_message',$this->MESSAGE['PARTS_ADDED'],'alert-success');

    		}
                //die;

            $this->db->where("parts_id",$ROWID);
            $this->db->delete('ffc_parts_color');

            $colorList=$this->common_model->getColor(1);
            //print_r($colorList); die;
            if ($ID!='') {
            if($color_codes && count($color_codes)>0){                 
                foreach ($color_codes as $key=>$color_code){
                    if($color_code!="" && isset($color_codes_multi[$randon_token[$key]]) && $color_codes_multi[$randon_token[$key]]!=''){ 
                        $is_multiple=0; //print_r($randon_token); print_r($color_codes_multi); die;
                        if($color_code==1000 && isset($color_codes_multi[$randon_token[$key]])){
                            $color_code=$color_codes_multi[$randon_token[$key]];
                            $color_code_Arr=explode(',', $color_code);
                            if($color_code_Arr){
                                foreach ($color_code_Arr as $value) {
                                    if($value!='' && !in_array($value, $colorList)){
                                        $this->db->insert('ffc_colors',array('color_code'=>$value,'name'=>$value));
                                    }
                                }
                            }
                            $is_multiple=1;
                        }
                        $image='';
                       
                        if($_FILES['color_image'] && isset($_FILES['color_image']['name'][$key]) &&  $_FILES['color_image']['name'][$key]!=''){
                            
                              $dest_color = $this->config->item('PARTS_DATA_DIR')."colors/".$ROWID.'/'; 

                              $image_upload=time().'_'.$_FILES['color_image']['name'][$key];
                            $target_file = $dest_color.$image_upload;
                            if (!is_dir($dest_color)){
                                mkdir($dest_color, 0777, TRUE);
                            }

                            if(move_uploaded_file($_FILES['color_image']['tmp_name'][$key],$target_file)){
                                //get the image size
                                $path_parts = pathinfo($target_file);
                                $extension=$path_parts['extension'];
                                $size = getimagesize($target_file);

                                //determine dimensions
                                 $width = $size[0];
                                 $height = $size[1];
                                
                                 if($width>=600 && $height>=600){
                                //determine what the file extension of the source
                                //image is
                                switch($extension)
                                {

                                        //its a gif
                                        case 'gif': case 'GIF':
                                                //create a gif from the source
                                                $sourceImage = imagecreatefromgif($target_file);
                                                break;
                                        case 'jpg': case 'JPG': case 'jpeg':
                                                //create a jpg from the source
                                                $sourceImage = imagecreatefromjpeg($target_file);
                                                break;
                                        case 'png': case 'PNG':
                                                //create a png from the source
                                                $sourceImage = imagecreatefrompng($target_file);
                                                break;

                                }

                                
                                // define new width / height
                                $percentage = 20;
 
                                // define new width / height
                                $newWidth = $width / 100 * $percentage;
                                $newHeight = $height / 100 * $percentage;

                                // create a new image
                                $destinationImage = imagecreatetruecolor($newWidth, $newHeight);

                                // copy resampled
                                imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                                $dest=$dest_color.$image_upload;
                                imagejpeg($destinationImage,$dest,100);
                                 }
                                 else{
                                    $destinationImage=$target_file; 
                                 }
                                if ($extension == "jpg" || $extension == "jpeg"){
                                    $this->correctImageOrientation($destinationImage);
                                }
                                $image = $image_upload;
                            }

                        }
                        else{
                            $image=$color_image[$key];
                        } //echo '<br>'.$key.'<br>'; 
                         
                        $colorArr[]= array('parts_id' =>$ROWID , 'color_code'=>$color_code,'is_multiple'=>$is_multiple,'image'=>$image);
                    }

                    
                }
            }
    }
    else{
        if($color_codes && count($color_codes)>0){                 
                foreach ($color_codes as $key=>$color_code){
                    if($color_code!="" ){ 
                        $is_multiple=0; //print_r($randon_token); print_r($color_codes_multi); die;
                        if($color_code==1000 && isset($color_codes_multi[$randon_token[$key]])){
                            $color_code=$color_codes_multi[$randon_token[$key]];
                            $color_code_Arr=explode(',', $color_code);
                            if($color_code_Arr){
                                foreach ($color_code_Arr as $value) {
                                    if($value!='' && !in_array($value, $colorList)){
                                        $this->db->insert('ffc_colors',array('color_code'=>$value,'name'=>$value));
                                    }
                                }
                            }
                            $is_multiple=1;
                        }
                        $image='';
                       
                        if($_FILES['color_image'] && isset($_FILES['color_image']['name'][$key]) &&  $_FILES['color_image']['name'][$key]!=''){
                            
                              $dest_color = $this->config->item('PARTS_DATA_DIR')."colors/".$ROWID.'/'; 

                              $image_upload=time().'_'.$_FILES['color_image']['name'][$key];
                            $target_file = $dest_color.$image_upload;
                            if (!is_dir($dest_color)){
                                mkdir($dest_color, 0777, TRUE);
                            }

                            if(move_uploaded_file($_FILES['color_image']['tmp_name'][$key],$target_file)){
                               $path_parts = pathinfo($target_file);
                                $extension=$path_parts['extension'];
                                $size = getimagesize($target_file);

                                //determine dimensions
                                 $width = $size[0];
                                 $height = $size[1];
                                
                                 if($width>=600 && $height>=600){
                                //determine what the file extension of the source
                                //image is
                                switch($extension)
                                {

                                        //its a gif
                                        case 'gif': case 'GIF':
                                                //create a gif from the source
                                                $sourceImage = imagecreatefromgif($target_file);
                                                break;
                                        case 'jpg': case 'JPG': case 'jpeg':
                                                //create a jpg from the source
                                                $sourceImage = imagecreatefromjpeg($target_file);
                                                break;
                                        case 'png': case 'PNG':
                                                //create a png from the source
                                                $sourceImage = imagecreatefrompng($target_file);
                                                break;

                                }

                                
                                // define new width / height
                                $percentage = 20;
 
                                // define new width / height
                                $newWidth = $width / 100 * $percentage;
                                $newHeight = $height / 100 * $percentage;

                                // create a new image
                                $destinationImage = imagecreatetruecolor($newWidth, $newHeight);

                                // copy resampled
                                imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                                $dest=$dest_color.$image_upload;
                                imagejpeg($destinationImage,$dest,100);
                                 }
                                 else{
                                    $destinationImage=$target_file; 
                                 }
                                if ($extension == "jpg" || $extension == "jpeg"){
                                    $this->correctImageOrientation($destinationImage);
                                }
                                $image = $image_upload;
                            }

                        }
                        else{
                            $image=$color_image[$key];
                        } //echo '<br>'.$key.'<br>'; 
                         
                        $colorArr[]= array('parts_id' =>$ROWID , 'color_code'=>$color_code,'is_multiple'=>$is_multiple,'image'=>$image);
                    }

                    
                }
            }
    }
           // print_r($colorArr); die;
            if($colorArr)$this->db->insert_batch('ffc_parts_color',$colorArr);
            //print_r($_FILES); die;
           // print_r($colorArr); die;
    		return true;

   


    }
    
	
	
	
    function correctImageOrientation($filename) {

  if (function_exists('exif_read_data')) {
    $exif = exif_read_data($filename);
    if($exif && isset($exif['Orientation'])) {
      $orientation = $exif['Orientation'];
      if($orientation != 1){
        $img = imagecreatefromjpeg($filename);
        $deg = 0;
        switch ($orientation) {
          case 3:
            $deg = 180;
            break;
          case 6:
            $deg = 270;
            break;
          case 8:
            $deg = 90;
            break;
        }
        if ($deg) {
          $img = imagerotate($img, $deg, 0);       
        }
        // then rewrite the rotated image back to the disk as $filename
        imagejpeg($img, $filename, 95);
      } // if there is some rotation necessary
    } // if have the exif orientation info
  } // if function exists     
}
    
     public function savepartdetails($value='')
    {
    	$postData=$this->input->post();
    	$crr_date=date("Y-m-d H:i:s");
    	$LOGINID=$this->LOGINID;
    	$ID=$ROWID=$this->input->post('ID');
        //print_r($_FILES);
    	//print_r($postData); die;
    	$name=$postData['name'];
        $part_type=$postData['part_type'];
        $part_type_title=$postData['part_type_title'];
        $part_type_other_id=$postData['part_type_other_id'];
        $price=$postData['price'];
        $case_pack=$postData['case_pack'];
        $cbm=$postData['cbm'];
        $MOQ=$postData['MOQ'];
        $initial_stock=$postData['initial_stock'];
        $current_stock=$postData['current_stock'];
        $description=$postData['description'];
        $manufacturer_arr=$postData['manufacturer'];

        $color_codes=$postData['color_codes'];
        $color_image=$postData['color_image'];
        $randon_token=$postData['randon_token'];
        $color_codes_multi=(isset($postData['color_codes_multi']))?$postData['color_codes_multi']:'';
        //print_r($color_codes); print_r($randon_token); print_r($color_codes_multi); die;
        $manufacturer = implode(',', $manufacturer_arr);
        $other_part_type=0;
        if($part_type==10000){
            $part_type_new=$this->addeditPartType($part_type_title);
            $other_part_type=1;
            if(!$part_type_new){
                setFlashMsg('part_type_title_exist',"Part Type title is already exists",'',1);
                return false; die;
            }
            $part_type=$part_type_new;
        }
        
        $insertData=array('name'=>$name,
                        'part_type'=>$part_type,
                        'other_part_type'=>$other_part_type,
                        'price'=>$price,
                        'case_pack'=>$case_pack,
                        'cbm'=>$cbm,
                        'MOQ'=>$MOQ,
                        'initial_stock'=>$initial_stock,
                        'current_stock'=>$current_stock,
                        'description'=>$description,
                        'manufacturer'=>$manufacturer,
                        'updated_by'=>$LOGINID,
                        'updation_date'=>$crr_date,
                        );
       // print_r($insertData); die;
        $dest = $this->config->item('PARTS_DATA_DIR');
        $resultData = uploadImg('parts_image',$dest);
        if($resultData!==false){
            $oldfile_name= $postData['parts_image'];
            $insertData['parts_image']=$resultData['upload_data']['file_name'];
           if($oldfile_name!='')remove_uploaded_file($oldfile_name,$dest); 
        }


               
        if ($ID!='') 
        {
            $ID=(is_numeric($ID))?md5($ID):$ID;
            $this->db->where("MD5(ID)",$ID);
            $this->db->update($this->main_table,$insertData);
                    
                    
                    
            /*Update planning sheets data ****/
            $this->db->select("PP.*");
            $this->db->from("ffc_planningsheets PP");
            $this->db->join("ffc_planningsheets_parts P","P.planningsheets_id=PP.ID","LEFT");
            $this->db->where("PP.is_deleted",0);
            $this->db->where("MD5(P.parts_id)",$ID);
            $this->db->group_by("P.planningsheets_id");
                                    
            $planningsheets=$this->db->get()->result();
            
            foreach ($planningsheets as $sheets) {
                if($sheets->is_pi==0){
                    $this->db->select("PP.*");
                    $this->db->from("ffc_planningsheets_parts PP");
                    $this->db->where("PP.planningsheets_id",$sheets->ID);
                    $this->db->where("MD5(PP.parts_id)",$ID);
                    $ps_parts=$this->db->get()->result();

                    foreach($ps_parts as $value){
                        $total_cases=$value->total_cases;
                        $total_pcs= $total_cases * $case_pack;
                        $total_cost= $total_pcs * $price;
                        $total_cbm= $cbm * $total_cases;
                        $pData=array(
                            'parts_price'=>$price,
                            'parts_moq'=>$MOQ,
                            'currentstock'=>$case_pack,
                            'cbm'=>round($cbm,2),
                            'total_cases'=>$total_cases,
                            'total_pcs'=>round($total_pcs,2),
                            'total_cost'=>round($total_cost,2),
                            'total_cbm'=>round($total_cbm,2)
                        );

                        $this->db->where(array("ID"=>$value->ID,"planningsheets_id"=>$sheets->ID));
                        $this->db->update('ffc_planningsheets_parts',$pData);
                    }

                    $PID=$sheets->ID;

                    $this->db->select("SUM(total_cost) as total_cost_val , SUM(total_cbm) as total_cbm_val");
                    $this->db->from("ffc_planningsheets_parts PP");
                    $this->db->where("planningsheets_id",$PID);
                    $total_vals=$this->db->get()->row();
                    $this->db->where("ID",$PID);
                    $this->db->update('ffc_planningsheets',array('total_cost_val'=>$total_vals->total_cost_val, 'total_cbm_val'=>$total_vals->total_cbm_val));
                }
            }
            
            
            // Update Purchase Order elements
            $this->db->select("PP.*");
            $this->db->from("ffc_purchaseorder PP");
            $this->db->join("ffc_purchaseorder_parts P","P.po_id=PP.ID","LEFT");
            $this->db->where("PP.is_deleted",0);
            $this->db->where("MD5(P.parts_id)",$ID);
            $this->db->group_by("P.po_id");
                                    
            $porders=$this->db->get()->result();
            
            foreach ($porders as $pord) {
                if($pord->is_final==0 ){
                    $this->db->select("PP.*");
                    $this->db->from("ffc_purchaseorder_parts PP");
                    $this->db->where("PP.po_id",$pord->ID);
                    $this->db->where("MD5(PP.parts_id)",$ID);
                    $ps_parts=$this->db->get()->result();

                    foreach($ps_parts as $value){
                        $total_cases=$value->total_cases;
                        $total_pcs= $total_cases * $case_pack;
                        $total_cost= $total_pcs * $price;
                        $total_cbm= $cbm * $total_cases;
                        $pData=array(
                            'parts_price'=>$price,
                            'parts_moq'=>$MOQ,
                            'currentstock'=>$case_pack,
                            'cbm'=>round($cbm,2),
                            'total_cases'=>$total_cases,
                            'total_pcs'=>round($total_pcs,2),
                            'total_cost'=>round($total_cost,2),
                            'total_cbm'=>round($total_cbm,2)
                        );

                        $this->db->where(array("ID"=>$value->ID,"po_id"=>$pord->ID));
                        $this->db->update('ffc_purchaseorder_parts',$pData);
                    }

                    $PID=$pord->ID;

                    $this->db->select("SUM(total_cost) as total_cost_val , SUM(total_cbm) as total_cbm_val");
                    $this->db->from("ffc_purchaseorder_parts PP");
                    $this->db->where("po_id",$PID);
                    $total_vals=$this->db->get()->row();
                    $this->db->where("ID",$PID);
                    $this->db->update('ffc_purchaseorder',array('total_cost_val'=>$total_vals->total_cost_val, 'total_cbm_val'=>$total_vals->total_cbm_val));
                }
            }
            
            
            // Update Proforma Invoice elements
            $this->db->select("PP.*");
            $this->db->from("ffc_invoice PP");
            $this->db->join("ffc_invoice_parts P","P.pi_id=PP.ID","LEFT");
            $this->db->where("PP.is_deleted",0);
            $this->db->where("MD5(P.parts_id)",$ID);
            $this->db->group_by("P.pi_id");
                                    
            $pinvoices=$this->db->get()->result();
            
            foreach ($pinvoices as $invoices) {
                if($invoices->is_final==0 ){
                    $this->db->select("PP.*");
                    $this->db->from("ffc_invoice_parts PP");
                    $this->db->where("PP.pi_id",$invoices->ID);
                    $this->db->where("MD5(PP.parts_id)",$ID);
                    $pi_parts=$this->db->get()->result();

                    foreach($pi_parts as $value){
                        $total_cases=$value->total_cases;
                        $total_pcs= $total_cases * $case_pack;
                        $total_cost= $total_pcs * $price;
                        $total_cbm= $cbm * $total_cases;
                        $pData=array(
                            'parts_price'=>$price,
                            'parts_moq'=>$MOQ,
                            'currentstock'=>$case_pack,
                            'cbm'=>round($cbm,2),
                            'total_cases'=>$total_cases,
                            'total_pcs'=>round($total_pcs,2),
                            'total_cost'=>round($total_cost,2),
                            'total_cbm'=>round($total_cbm,2)
                        );

                        $this->db->where(array("ID"=>$value->ID,"pi_id"=>$invoices->ID));
                        $this->db->update('ffc_invoice_parts',$pData);
                    }

                    $PID=$invoices->ID;

                    $this->db->select("SUM(total_cost) as total_cost_val , SUM(total_cbm) as total_cbm_val");
                    $this->db->from("ffc_invoice_parts PP");
                    $this->db->where("pi_id",$PID);
                    $total_vals=$this->db->get()->row();
                    $this->db->where("ID",$PID);
                    $this->db->update('ffc_invoice',array('total_cost_val'=>$total_vals->total_cost_val, 'total_cbm_val'=>$total_vals->total_cbm_val));
                }
            }

            setFlashMsg('success_message',$this->MESSAGE['PARTS_UPDATED'],'alert-success');
        }else{
            $insertData['creation_date']=$crr_date;
            $insertData['created_by']=$LOGINID;
            $this->db->insert($this->main_table,$insertData);
            $ROWID=$this->db->insert_id();
            setFlashMsg('success_message',$this->MESSAGE['PARTS_ADDED'],'alert-success');
        }
        return true;

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
    		 setFlashMsg('email_exist',$this->MESSAGE['PARTS_EXIST'],'',1);
    		return false;
    	}
    	return true;
    }


    public function loadDataById($ID='',$only_parts_details=0)
    {
    	if($ID!=''){
    		$ID=(is_numeric($ID))?md5($ID):$ID;
	    	$this->db->select("*");
	    	$this->db->from($this->main_table);
	    	$this->db->where("is_deleted",0);
	    	$this->db->where("MD5(ID)",$ID);
	    	$result=$this->db->get()->row();
            if($only_parts_details==0){
                $this->db->select("ID,color_code,image,is_multiple");
                $this->db->from("ffc_parts_color");
                $this->db->where("MD5(parts_id)",$ID);
                $result2=$this->db->get()->result();
                
                $result->color_codes_list=$result2;
            }
            
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
    			setFlashMsg('success_message',$this->MESSAGE['PARTS_DEACTIVE_STATUS'],'alert-info');
    		}
	    else if($action=='active'){
	    	$updateData=array('status'=>1);
	    	setFlashMsg('success_message',$this->MESSAGE['PARTS_ACTIVE_STATUS'],'alert-success');
	    }
	    else if($action=='delete'){
	    	setFlashMsg('success_message',$this->MESSAGE['PARTS_DELETE'],'alert-danger');
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
	    	setFlashMsg('success_message',$this->MESSAGE['PARTS_DELETE_BULK'],'alert-danger');
	    	return true;
    	}
    }
    public function getPartsByManufacturer($m_id_val='')
    {
        $partsList=array();
        $postData=$this->input->post();
    	$manufacturer_id=(isset($postData['manufacturer_id']))?$postData['manufacturer_id']:'';
        $manufacturer_id=($m_id_val>0)?$m_id_val:$manufacturer_id;
        if($manufacturer_id){
            $this->db->select("*");
            $this->db->from("ffc_parts tp");
            $this->db->where("tp.is_deleted",0);
            $this->db->where("tp.status",1);
             $this->db->where("FIND_IN_SET (".$manufacturer_id.",tp.manufacturer) ");
             $this->db->order_by("tp.name",'asc');
            $partsList=$this->db->get()->result();
            //echo $this->db->last_query(); die;
        }
        
        
        return $partsList;
        
    }
	
	  public function getPartsnameByManufacturer($m_id_val='')
    {
        $partsList=array();
        $postData=$this->input->post();
    	$manufacturer_id=(isset($postData['manufacturer_id']))?$postData['manufacturer_id']:'';
        $manufacturer_id=($m_id_val>0)?$m_id_val:$manufacturer_id;
        if($manufacturer_id){
            $this->db->select("tp.ID,tp.name");
            $this->db->from("ffc_parts tp");
            $this->db->where("tp.is_deleted",0);
            $this->db->where("tp.status",1);
             $this->db->where("FIND_IN_SET (".$manufacturer_id.",tp.manufacturer) ");
             $this->db->order_by("tp.name",'asc');
            $partsList=$this->db->get()->result();
            //echo $this->db->last_query(); die;
        }
        
        
        return $partsList;
        
    }
	
	
	
    public function getPartsType($ID='')
    {
        $this->db->select("*");
        $this->db->from("ffc_parts_type");
        $this->db->where("status",1);
        //if($ID>0)$this->db->where("ID !=",$ID);
        $result=$this->db->get()->result();
        return $result; 
    }

    public function getPartscolorByPartsId($idval='')
    {
        $partsColorList=$result_array=array();
        $postData=$this->input->post();
        $parts_id=(isset($postData['parts_id']))?$postData['parts_id']:'';
        $parts_id=($idval>0)?$idval:$parts_id;
        if($parts_id){
            $this->db->select("*");
            $this->db->from("ffc_parts_color");
            $this->db->where("parts_id",$parts_id);
            $this->db->order_by("color_code",'asc');
            $partsColorList=$this->db->get()->result();
        }
          $partDetails=$this->loadDataById($parts_id,1);
        $result=array('colorList'=>$partsColorList,'partDetails'=>$partDetails);
        //echo $this->db->last_query(); die;
        //print_r($partsColorList);
        return $result;
        //return (object)$result_array;
        
    }

    public function getPartsColorImg($parts_idval='',$parts_color_val='')
    {
         $postData=$this->input->post();
        $parts_id=(isset($postData['parts_id']))?$postData['parts_id']:'';
        $parts_id=($parts_idval>0)?$parts_idval:$parts_id;

        $parts_color=(isset($postData['parts_color']))?$postData['parts_color']:'';
        $parts_color=($parts_color_val!="")?$parts_color_val:$parts_color;

        $this->db->select("*");
        $this->db->from("ffc_parts_color");
        $this->db->where("parts_id",$parts_id);
        $this->db->where("color_code",$parts_color);
        $result=$this->db->get()->row();
        //echo $this->db->last_query(); die;
        if($result && $result->image!=''){
            $result->image_fullpath=$this->config->item('PARTS_DATA_DISP').'colors/'.$parts_id.'/'.$result->image;
        }else{
            $result->image_fullpath=$this->config->item('PARTS_DATA_DISP').'not-available.jpg';
        }
        
        //print_r($result); die;
        return $result; 
    }

    public function addeditPartType($title_val='',$ID='')
    {
        $postData=$this->input->post();
        $title=(isset($postData['title']))?$postData['title']:'';
        $title=($title_val!="")?$title_val:$title;
        $LOGINID=$this->LOGINID;
        $crr_date=date("Y-m-d H:i:s");
        $insertData=array('title'=>$title,'updation_date'=>$crr_date,'updated_by'=>$LOGINID);

        $this->db->select("*");
        $this->db->from("ffc_parts_type");
        if($ID>0)$this->db->where("ID !=",$ID);
        $this->db->where("title",$title);
        $result=$this->db->get()->result();
        //print_r($result);
        //echo $this->db->last_query(); die;
        if($result && count($result)>0){ return false;}
        else{
            if($ID>0){
                $this->db->where("ID",$ID);
                $this->db->update('ffc_parts_type',$insertData);
            }else{
                $insertData['creation_date']=$crr_date;
                $insertData['created_by']=$LOGINID;
                $this->db->insert('ffc_parts_type',$insertData);
                $ID=$this->db->insert_id();
            }
            return $ID;
        }
        

    }

    public function partTypeDetails($ID='')
    {
        $this->db->select("*");
        $this->db->from("ffc_parts_type");
        if($ID>0)$this->db->where("ID",$ID);
        $result=$this->db->get()->row();
        return $result;
    }

}

/* End of file Role_model.php */
/* Location: ./application/models/Role_model.php */