<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['uri_protocol']	= 'REQUEST_URI';

$CI =& get_instance();
$CI->load->helper('url');

$config['remember_me_duration'] = (24*60*60);
$config['reset_url_duration'] = (24*60*60);

$config['SESSION_PREFIX'] = 'FFC_';

//===============SITE CONFIG DATA========

$config['WEBSITE_NAME'] = '';
$config['WEBSITE_LOGO'] = '';
$config['SMTPEMAIL_HOST'] = '';
$config['SMTPEMAIL_PORT'] = '';
$config['SMTPEMAIL_EMAIL'] = '';
$config['SMTPEMAIL_PASS'] = '';
$config['PAGINATION'] = '';



/*=============== DIRECTORY===============*/
$config['ASSETS_DIR'] = base_url('assets/');
$config['CSS_DIR'] = base_url('assets/css/');
$config['JS_DIR'] = base_url('assets/js/');
$config['ASSETS_IMG_DIR'] = base_url('assets/img/');
$config['COMP_DIR'] = base_url('assets/components/');


$config['DATA_DIR'] = base_url('data/');
$config['IMG_DIR'] = base_url('images/');

$config['ROOT_DATA_DIR']='data/';
$config['SITE_DATA_DIR']=$config['ROOT_DATA_DIR'].'website/';
$config['SITE_DATA_DISP']=$config['DATA_DIR'].'website/';

$config['EMPLOYEE_DATA_DIR']=$config['ROOT_DATA_DIR'].'employee/';
$config['EMPLOYEE_DATA_DISP']=$config['DATA_DIR'].'employee/';

$config['PARTS_DATA_DIR']=$config['ROOT_DATA_DIR'].'parts/';
$config['PARTS_DATA_DISP']=$config['DATA_DIR'].'parts/';




// Module Event Array
$config['ACTION_EVENT']=array(1=>'View',2=>'Add',3=>'Edit',4=>'Change Status',5=>'Delete',6=>'Bulk Change Status',7=>'Bulk Delete',8=>'Upload',9=>'Download',10=>'Module Permission');

$config['MODULE_PERMISSION']=array();

/*==================SpaceAPI=================*/
$config['BUCKETNAME'] = 'newinventory';
$config['REGION'] = 'fra1';
$config['HOST'] = 'digitaloceanspaces.com';
$config['ACCESSKEY'] = '2O3A7WX7J4GUKXKBO2II';
$config['SECRETKEY'] = 'lc1pJeqqiksTRHG7FaHjlGBCpUV7TMU8H06/9aufYbU';