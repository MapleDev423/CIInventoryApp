<?php
	use Aws\S3\S3Client;


	$CI =& get_instance();
	$tbl_prefix="hps_";


	function tblprefix($table=""){
		global $CI,$tbl_prefix;
		if($table!=""){ 
			return "hps_".$table;
		}
		return "";
	}
	function setSession($variable='',$values=''){
		global $CI;
		$PREFIX=$CI->config->item('SESSION_PREFIX');
		if($variable!="" && $values!=""){
			$CI->session->set_userdata($PREFIX.$variable, $values);
		}
		else if(is_array($variable) && count($variable)>0){
			foreach($variable as $key=>$dataval){
				if($key!="" ){
					$CI->session->set_userdata($PREFIX.$key,$dataval);
				}
			}
		}
	}
	function getSession($varialbe=''){
		global $CI;
		if($varialbe!=''){
			$PREFIX=$CI->config->item('SESSION_PREFIX');
			if($CI->session->has_userdata($PREFIX.$varialbe)){		
				return $CI->session->userdata($PREFIX.$varialbe);
			}
			else{ 
				return FALSE;
			}
		}else{
			return FALSE;
		}
		
	}
	function unset_Session($varialbe=''){
		global $CI;
		if($varialbe!=''){
			$PREFIX=$CI->config->item('SESSION_PREFIX');
			$CI->session->unset_userdata($PREFIX.$varialbe);
		}
		
	}
	function setSession_user($variable='',$values=''){
		global $CI;
		$PREFIX=$CI->config->item('SESSION_PREFIX_USER');
		if($variable!="" && $values!=""){
			$CI->session->set_userdata($PREFIX.$variable, $values);
		}
		else if(is_array($variable) && count($variable)>0){
			foreach($variable as $key=>$dataval){
				if($key!="" ){
					$CI->session->set_userdata($PREFIX.$key,$dataval);
				}
			}
		}
	}
	function getSession_user($varialbe=''){
		global $CI;
		if($varialbe!=''){
			$PREFIX=$CI->config->item('SESSION_PREFIX_USER');
			if($CI->session->has_userdata($PREFIX.$varialbe)){		
				return $CI->session->userdata($PREFIX.$varialbe);
			}
			else{ 
				return FALSE;
			}
		}else{
			return FALSE;
		}
		
	}

	function unset_Session_user($varialbe=''){
		global $CI;
		if($varialbe!=''){
			$PREFIX=$CI->config->item('SESSION_PREFIX_USER');
			$CI->session->unset_userdata($PREFIX.$varialbe);
		}
		
	}
	function setFlashMsg($variable='',$values='',$class='',$only_text=0)
	{
		global $CI;
		$message="";
		if($variable!="" && $values!=""){
			if($class=="text-success"){
			$message='<div id="" class="col-xs-12 p-8 text-center text-success">'.$values.'</div>';
			}
			else if($class=="text-danger"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center text-danger">'.$values.'</div>';
			}
			else if($class=="text-warning"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center text-warning">'.$values.'</div>';
			}
			else if($class=="text-info"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center text-info">'.$values.'</div>';
			}
			else if($class=="text-black"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center text-black">'.$values.'</div>';
			}
			else if($class=="text-white"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center text-white">'.$values.'</div>';
			}
			else if($class=="alert-success"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center alert alert-success alert-dismissible">'.$values.'</div>';
			}
			else if($class=="alert-danger"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center alert alert-danger alert-dismissible">'.$values.'</div>';
			}
			else if($class=="alert-warning"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center alert alert-warning alert-dismissible">'.$values.'</div>';
			}
			else if($class=="alert-info"){
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center alert alert-info  alert-dismissible">'.$values.'</div>';
			}
			else if($only_text==1){
				$message=$values;
			}
			else{
				$message='<div id="alert_meg" class="col-xs-12 p-8 text-center '. $class.'">'.$values.'</div>';
			}
			$CI->session->set_flashdata($variable, $message);
		}
		
		
	}



	function getFlashMsg($variable='')
	{
		global $CI;
		if($variable!=""){
			if($CI->session->flashdata(trim($variable))){
				echo $CI->session->flashdata(trim($variable));
			}
		}
	}


	function full_url()
	{
	    global $CI;
	    $url = $CI->config->site_url($CI->uri->uri_string());
	    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}


	function replaceEmpty($variable='',$default='')
	{
		global $CI;
		$val='';
		if($variable!=''){
			if(isset($_REQUEST[$variable])){
				if(!is_array($_REQUEST[$variable])){
					$val=trim($_REQUEST[$variable]);
					$val=htmlentities($val);
				}
				else{
					$valArr=$_REQUEST[$variable];
					if(count($valArr)>0){
						foreach($valArr as $key=>$valArr1){
							if(!is_array($valArr1)){
								$val[$key]=htmlentities(trim($valArr1));
							}
							$val[$key]=$valArr1;
						}
					}
				}
			}
			else{
				$val=$default;
			}
		}
		return $val;
		
	}

	function singleAction($action='active',$action_id_field='',$action_id_field_val='',$message=''){
		global $CI;
		 $url = $CI->config->site_url($CI->uri->uri_string());
		 $callBackUrl=full_url();
		 $action_id_field=($action_id_field=='')?'ID':$action_id_field;
		$actionVal="'".$action."','$action_id_field','$action_id_field_val','".base64_encode($url)."','".base64_encode($callBackUrl)."','".base64_encode($message)."'";
		return $actionVal;

	}

	function sortDataUrl($field_name=''){
		global $CI;
		if($field_name!=""){
			
			$sort_field=replaceEmpty('sortBy','');
			$sort_on=replaceEmpty('sortOn','');
			$page=replaceEmpty('page',''); 
			$url=full_url();

			$class_Arr=array('<i class="fa fa-sort icon-sort" aria-hidden="true"></i>','<i class="fa fa-sort-asc icon-sort" aria-hidden="true"></i>','<i class="fa fa-sort-desc icon-sort" aria-hidden="true"></i>');
			$class="";
			if(strpos($url,'&page='.$page)!==FALSE){
				$url= str_replace('&page='.$page,'',$url);
			}else if(strpos($url,'?page='.$page)!==FALSE){
				$url= str_replace('page='.$page,'',$url);
			}
			$field_name_new=my_crypt($field_name);
			if($sort_field!="" && $sort_on!=""){

				if($sort_field==my_crypt($field_name)){
					$rep_sortOn=$sort_on;
					$sortOn=my_crypt((my_crypt($sort_on,'d')=="ASC")?"DESC":"ASC");

					$rep_link= 'sortBy='.$sort_field.'&sortOn='.$rep_sortOn;
					if(strpos($url,'?'.$rep_link)){
						$url= str_replace('?'.$rep_link,'',$url);
					}
					elseif(strpos($url,'&'.$rep_link)){
						$url= str_replace('&'.$rep_link,'',$url);
					}

					$link= 'sortBy='.$field_name_new.'&sortOn='.$sortOn;
					$url=(strpos($url,'?')!==FALSE)?$url.'&'.$link:$url.'?'.$link;
					$class=(my_crypt($sort_on,'d')=="ASC")?$class_Arr[1]:$class_Arr[2];
				}else{
					$rep_sortOn=$sort_on;
					$rep_link= 'sortBy='.$sort_field.'&sortOn='.$rep_sortOn;
					if(strpos($url,'?'.$rep_link)){
						$url= str_replace('?'.$rep_link,'',$url);
					}
					elseif(strpos($url,'&'.$rep_link)){
						$url= str_replace('&'.$rep_link,'',$url);
					}
					$sortOn=my_crypt("ASC");
					$link= 'sortBy='.$field_name_new.'&sortOn='.$sortOn;
					$url=(strpos($url,'?')!==FALSE)?$url.'&'.$link:$url.'?'.$link;
					$class=$class_Arr[0];
				}
			}else{
				$sortOn=my_crypt("ASC");
				$link= 'sortBy='.$field_name_new.'&sortOn='.$sortOn;
				$url=(strpos($url,'?')!==FALSE)?$url.'&'.$link:$url.'?'.$link;
				$class=$class_Arr[0];
			}

			

			
			return (object)array('url'=>$url,'class'=>$class);

		}
	}

	function my_crypt( $string, $action = 'e' ) {
	    // you may change these values to your own
	    $secret_key = '[r@"g=T.(P3%_&RfLEVu6}';
	    $secret_iv = '>G2-0hH0=&NF7%h&A0Htnu790YwgJwsSkyLerQxsl"Vu~?!O05wDQTyVv;h<@M"}r(VEj';
	 
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = hash( 'sha512', $secret_key );
	    $iv = substr( hash( 'sha512', $secret_iv ), 0, 16 );
	 
	    if( $action == 'e' ) {
	        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
	    }
	    else if( $action == 'd' ){
	        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	    }
	 
	    return $output;
	}

	function uploadAllFile($fileName='',$dest='')
	{
	    global $CI;

	        $config['upload_path']          =  $dest;
	        $config['allowed_types'] = '*';
		    //$config['allowed_types']        = 'gif|jpg|png|ico';
		    //$config['encrypt_name'] = TRUE;
		    $new_name = time().'_'.$_FILES[$fileName]['name'];
	        $config['file_name'] = $new_name;
		    $CI->load->library('upload', $config);
		    if (!is_dir( $config['upload_path'])) {
		        mkdir( $config['upload_path'], 0777, TRUE);
		    }
		    if ($CI->upload->do_upload($fileName))
		    {
		      $data = array('upload_data' => $CI->upload->data());
		        return  $data ;
		    }
		    else{ //echo "Here".$CI->upload->display_errors(); die;
		        return  false;
		    }
		        
	}
	//https://newinventory.fra1.digitaloceanspaces.com/data/employee/profile2.jpg
	function updateImgToBucket($imgName='',$dest=''){
	    global $CI;

		/**SpaceConfig */
		$bucketName = $CI->config->item('BUCKETNAME');
		$region = $CI->config->item('REGION');
		$host = $CI->config->item('HOST');
		$accessKey = $CI->config->item('ACCESSKEY');
		$secretKey = $CI->config->item('SECRETKEY');

		$s3Client = new S3Client([
			"version" => "latest",
			"region" => "us-east-1",
			"endpoint" => "https://$region.$host",
			"credentials" => ["key" => $accessKey, "secret" => $secretKey],
			"ua_append" => "SociallyDev-Spaces-API/2",
		]);
		/** */
		if($_FILES[$imgName]['name'] != ''){
			$new_name = $dest.time().'_'.$_FILES[$imgName]['name'];
			$target_file = $_FILES[$imgName]['tmp_name'];
			//$path_parts = pathinfo($new_name);
			//$extension = $path_parts['extension'];
			$extension = pathinfo($_FILES[$imgName]['name'], PATHINFO_EXTENSION);

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
				//$dest = $dest.$new_name;
				imagejpeg($destinationImage,$target_file,100);
			}
			else{
				$destinationImage=$target_file; 
			}
			if ($extension == "jpg" || $extension == "jpeg"){
				correctImageOrientation($destinationImage);
			}



			$s3Client->putObject(
				[
					'Bucket' => $bucketName,
					'Key' => $new_name,
	//				'SourceFile' => $_FILES[$imgName]['tmp_name'],
					'SourceFile' => $target_file,
					'ACL' => 'public-read'
				]
			);
			return array('upload_data' => array(
				'file_name' => "$new_name",
				)
			);
		}else{
			return false;
		}
	}
	function uploadImg($imgName='',$dest='')
	{
	    global $CI;

		$config['upload_path'] =  $dest;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|ico';
		//$config['encrypt_name'] = TRUE;
		$new_name = time().'_'.$_FILES[$imgName]['name'];
		$config['file_name'] = $new_name;
		$CI->load->library('upload', $config);
		if (!is_dir( $config['upload_path'])) {
			mkdir( $config['upload_path'], 0777, TRUE);
		}
		if ($CI->upload->do_upload($imgName))
		{           
			$target_file=$dest.$new_name;
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
				$dest = $dest.$new_name;
				imagejpeg($destinationImage,$dest,100);
			}
			else{
				$destinationImage=$target_file; 
			}
			if ($extension == "jpg" || $extension == "jpeg"){
				correctImageOrientation($destinationImage);
			}
			$data = array('upload_data' => $CI->upload->data());
			return  $data;
		}
		else{
			return  false;
		}
		        
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


function uploadResizeImg($imgName='',$dest='',$tumb_path='',$thumb_size=array())
{
	global $CI;
	$config['upload_path'] = $dest;//print_r($thumb_size); die;
	$config['allowed_types'] = 'gif|jpg|png';
	$new_name = time().'_'.$_FILES[$imgName]['name'];
	$config['file_name'] = $new_name;
	$config['overwrite'] = false;
	if (!is_dir( $config['upload_path'])) {
			mkdir( $config['upload_path'], 0777, TRUE);
	}
	if (!is_dir($tumb_path)) {
			mkdir($tumb_path, 0777, TRUE);
	}

		$CI->load->library('upload', $config);
		if ( $CI->upload->do_upload($imgName))
		{
		$data =  $CI->upload->data(); //print_r($data); die;
			$dataVal = array('upload_data' => $data);
			$fileExt=pathinfo($data['file_name'],PATHINFO_EXTENSION);
			$fileName=pathinfo($data['file_name'],PATHINFO_FILENAME);
		if(count($thumb_size)>0){
			$CI->load->library('image_lib');
			foreach($thumb_size as $valsize){ 
				$config1['image_library'] = 'gd2';
				$config1['source_image'] = $data['full_path'];
				$config1['new_image'] = $tumb_path;		
				$config1['create_thumb'] = TRUE;
				$config1['thumb_marker'] = '_'.$valsize[0].'X'.$valsize[1];	
				$config1['width']         = $valsize[0];
				$config1['height']       = $valsize[1];
				//print_r($config1);
				
				$CI->image_lib->initialize($config1);
				if ( ! $CI->image_lib->resize())
				{
						echo $CI->image_lib->display_errors();
				}
				$dataVal['thumbImage'][]=$fileName.$config1['thumb_marker'].'.'.$fileExt;
				
			}
			$CI->image_lib->clear();
		}
		//print_r($dataVal); die;
		return $dataVal;
		}
		return false;      
}
function generateSlag($text='')
{
	global $CI;
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	$text = preg_replace('~[^-\w]+~', '', $text);
	$text = trim($text, '-');
	$text = preg_replace('~-+~', '-', $text);
	$text = strtolower($text);
	return $text;
}
function send_mail($from='',$to='',$subject='',$message='',$from_name='',$cc='',$files=''){
	global $CI;
	
	if($to!='' && $message!=''){
		$from=($from!="")?$from:$CI->config->item('SMTPEMAIL_EMAIL');;
		$from_name=($from_name!="")?$from_name:$CI->config->item('WEBSITE_NAME');
		$subject=($subject!="")?$subject:"";

		$config['mailtype'] = 'html';
		$config['protocol'] = 'mail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'utf-8';
		$config['smtp_port'] = $CI->config->item('SMTPEMAIL_PORT');
		$config['smtp_user'] = $CI->config->item('SMTPEMAIL_EMAIL');
		$config['smtp_pass'] = $CI->config->item('SMTPEMAIL_PASS');
		//print_r($config); die;
		$CI->email->initialize($config);			
		$CI->email->set_newline("\r\n");
		$CI->email->from($from,$from_name); // change it to yours
		$CI->email->to($to);

		if(is_array($cc) && count($cc)>0){
			foreach($cc as $ccmail){ if($ccmail!='' && filter_var($ccmail, FILTER_VALIDATE_EMAIL)){
					$CI->email->cc($ccmail);
				}
			}
		}
		elseif($cc!='' && filter_var($cc, FILTER_VALIDATE_EMAIL)){
			$CI->email->cc($cc);
		}


		$CI->email->subject($subject);
		$CI->email->message($message);

		if(is_array($files) && count($files)>0){
			foreach($files as $filesPath){ if($filesPath!='' && file_exists($filesPath)){
					$CI->email->attach($filesPath);
				}
			}
		}
		elseif($files!=''){
			$CI->email->attach($files);
		}

		//$files="http://skyweblab.com/codeigniter-setup/assets/a/images/macbook.png";

		if($CI->email->send())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
function dirToArray($dir) { 

	$result = array(); 

	$cdir = scandir($dir); 
	foreach ($cdir as $key => $value) 
	{ 
		if (!in_array($value,array(".",".."))) 
		{ 
			if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
			{ 
			$result['directory'][$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
			} 
			else 
			{ 
			$result['files'][] = $value; 
			} 
		} 
	} 
	
	return $result; 
}

function getfileSize($path='')
{
	$size='';
	if (file_exists($path)){
		$size= filesize($path);
		if($size>0){
			if($size>1000000000){
				$size=(float)($size/1000000000).' GB ';
			}
			else if($size>1000000){
				$size=number_format((float)($size/1000000),3). ' MB ';
			}
			else if($size>1024){
				$size=number_format((float)($size/1024),2). ' KB ';
			}
			else{
				$size =$size.' Bytes';
			}
		}
	}
	return $size;
}


function getFieldVal($varialble='',$details='',$val=0)
{
	if($varialble!="" && $details && $val!=1){
		$varible_val=(isset($details->$varialble))?$details->$varialble:'';
		return set_value($varialble, $varible_val);
	}
	else if($varialble!="" && $details!="" && $val==1){ 
		return set_value($varialble,$details);
	}
	else if($varialble!=""){
		return set_value($varialble);
	}
}

function countrows($sql='')
{
	global $CI,$tbl_prefix;
	if($sql!=""){
		$query = $CI->db->query($sql);
		return $query->num_rows();
	}else{
		return 0;
	}
	
}
function pagination(  $url = '',$total=0,$page=0)
{        
	global $CI;
	$per_page=$CI->config->item('ADMIN_PAGE_SIZE');
	//echo $url.'|'.$totalRecord.'|'.$pagin_record.'|'.full_url(); die;
	if(strpos(full_url(),'?')!==FALSE){
		$urlArr=explode('?',full_url());
		if(strpos($urlArr[1],'&page='.$page)!==FALSE){
			$url_string=str_replace('&page='.$page, '', $urlArr[1]); 
		}
		else if(strpos($urlArr[1],'page='.$page)!==FALSE){
				$url_string=str_replace('page='.$page, '', $urlArr[1]);
		}
		else{
			$url_string=$urlArr[1];
		}
		$url_string=($url_string=="")?"":$url_string."&";
		$url = $url.'?'.$url_string;
		//$url=$url."?".$urlArr[1];
	}else{
		$url = $url.'?';
	}
	//echo $url; die;
	$adjacents = "2"; 

	$page = ($page == 0 ? 1 : $page);  
	$start = ($page - 1) * $per_page;								
	
	$prev = $page - 1;							
	$next = $page + 1;
	$lastpage = ceil($total/$per_page);
	$lpm1 = $lastpage - 1;
	
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class='pagination'>";
				//$pagination .= "<li class='details'>Page $page of $lastpage</li>";
		if($page!=1){
			$pagination.= "<li><a href='{$url}page=1'>First</a></li>";
			$pagination.= "<li><a href='{$url}page=".($page-1)."'>Privious</a></li>";
		}
		if ($lastpage < 7 + ($adjacents * 2))
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
				else{
					
					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
				}
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='active'><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
				}
				$pagination.= "<li class='dot'>...</li>";
				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
				$pagination.= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='active' ><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
				}
				$pagination.= "<li class='dot'>..</li>";
				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
			}
			else
			{
				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
				$pagination.= "<li class='dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='active' ><a class='current'>$counter</a></li>";
					else
						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
				}
			}
		}
		
		if ($page < $counter - 1){ 
			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
			$pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
		}else{
			//$pagination.= "<li class='active' ><a class='current'>Next</a></li>";
			//$pagination.= "<li class='active' ><a class='current'>Last</a></li>";
		}
		$pagination.= "</ul>\n";		
	}


	return $pagination;
} 
function paginationAdmin($url='',$totalRecord=0)
{
    global $CI;
    
    $CI->load->library('pagination');
    $pagin_record=$CI->config->item('ADMIN_PAGE_SIZE');
    //echo $url.'|'.$totalRecord.'|'.$pagin_record.'|'.full_url(); die;
    if(strpos(full_url(),'?')!=FALSE){
		$urlArr=explode('?',full_url());
		$config['query_string_segment'] = $urlArr[1].'&page';
		//$url=$url."?".$urlArr[1];
    }else{
    	$config['query_string_segment'] = 'page';
    }
    $paginationLink="";
    $config['uri_segment'] = 3;
    $config['num_links'] = 2;
    $config['base_url'] = $url;
    $config['total_rows'] = $totalRecord;
    $config['per_page'] = $pagin_record;
    
    $config['enable_query_strings']=true;
    $config['page_query_string']=true;
	$config['use_page_numbers'] = TRUE;
    $config['reuse_query_string'] = false;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    
    $config['cur_tag_open'] = '<li  class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $CI->pagination->initialize($config);
    $paginationLink=$CI->pagination->create_links();
    
    return $paginationLink;
}

function paginationFront($url='',$totalRecord=0){
    global $CI;

    $CI->load->library('pagination');

    
    $paginationLink="";
    $config['base_url'] = $CI->config->item('base_url').$url;
    $config['total_rows'] = $totalRecord;
    $config['per_page'] = $CI->config->item('WEBSITE_PAGE_SIZE');
    //$config['enable_query_strings']=true;
    //$config['page_query_string']=true;
    //$config['reuse_query_string'] = TRUE;
    $config['use_page_numbers'] = TRUE;
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';

    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';

    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';

    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li  class="active"><a href="javascript:void()">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $CI->pagination->initialize($config);
    $paginationLink=$CI->pagination->create_links();

    return $paginationLink;
}


function checkModulePermission($module_id=0,$event_id='')
{

	global $CI;
	$login_data=getSession('login_data');
	//print_r($login_data); die;
	$MODULE_PERMISSION=$CI->config->item('MODULE_PERMISSION');
	//print_r($MODULE_PERMISSION); //die;
	if($module_id>0 && $event_id>0){
		if(is_array($MODULE_PERMISSION) && isset($MODULE_PERMISSION[$module_id]) && in_array($event_id,$MODULE_PERMISSION[$module_id])){
			//echo 1; die;
			return true;
		}else if($login_data->id==1){
			return true;
		}
		
	}
	else if($module_id>0 && $event_id==''){
		if(is_array($MODULE_PERMISSION) && isset($MODULE_PERMISSION[$module_id])){
			return true;
		}
		
	}
	return false;
}

function dateFormate($date='',$formte="Y-m-d")
{
	$date_time=strtotime($date);
	return date($formte,$date_time);
}

function timeFormate($date_time='',$formte="H:i:s")
{
	$time=strtotime(date('Y-m-d').' '.$date_time);
	return date($formte,$time);
}

function getTimeInterval( $start = '00:00',$end = '23:59', $intervalTime = 30 ) {

	$output = '';
	$interval='+'.$intervalTime.' minutes';
	$current = strtotime( $start );
	$end = strtotime( $end );

	while( $current <= $end ) {
		$time = date( 'H:i', $current );
		$output []=date( 'h:i A', $current );
		$current = strtotime( $interval, $current );
	}

	return $output;
}
function timeFrm($time='H:i'){
	return date( 'H.i', strtotime( $time ));
}
function getTemplateData($id='')
{		
	global $CI;

			$CI->db->select("*");
			$CI->db->from('ffc_email_template');
			$CI->db->where('id',$id);
			$result = $CI->db->get()->row();
			return $result;
}
function remove_uploaded_file($oldfile_name='',$dest='')
{		
	$paths = $dest.$oldfile_name;
	if($oldfile_name!="" && file_exists($paths)){
			@unlink($paths);
	}
	return true;
}
function remove_uploaded_fileFromBucket($oldfile_name='',$dest='')
{
	global $CI;

	/**SpaceConfig */
	$bucketName = $CI->config->item('BUCKETNAME');
	$region = $CI->config->item('REGION');
	$host = $CI->config->item('HOST');
	$accessKey = $CI->config->item('ACCESSKEY');
	$secretKey = $CI->config->item('SECRETKEY');

	$s3Client = new S3Client([
		"version" => "latest",
		"region" => "us-east-1",
		"endpoint" => "https://$region.$host",
		"credentials" => ["key" => $accessKey, "secret" => $secretKey],
		"ua_append" => "SociallyDev-Spaces-API/2",
	]);		
	$result = $s3Client->deleteObject(array(
		'Bucket' => $bucketName,
		'Key'    => $oldfile_name
	));

}
function limit($string, $max, $end_char = '…')
{
	if(strlen($string) <= $max) return $string;
	return substr($string, 0, $max) . $end_char;
}


?>