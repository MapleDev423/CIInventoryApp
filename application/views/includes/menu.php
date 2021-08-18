  <header class="main-header">
    <!-- Logo -->
    <a href="<?= $BASE_URL ?>dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">FFC</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?= $this->config->item('WEBSITE_NAME'); ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">                 
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= $this->config->item('EMPLOYEE_DATA_DISP') ?><?= (isset($LOGIN_DATA->profile_pic) && $LOGIN_DATA->profile_pic!='')?$LOGIN_DATA->profile_pic:'no_pic.jpg';?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= (isset($LOGIN_DATA->name) && $LOGIN_DATA->name!='')?$LOGIN_DATA->name:'User Name';?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= $this->config->item('EMPLOYEE_DATA_DISP') ?><?= (isset($LOGIN_DATA->profile_pic) && $LOGIN_DATA->profile_pic!='')?$LOGIN_DATA->profile_pic:'no_pic.jpg';?>" class="img-circle" alt="User Image">

                <p>
                  <a href="<?= $BASE_URL ?>employee/myprofile" class="text-white"><?= (isset($LOGIN_DATA->name) && $LOGIN_DATA->name!='')?$LOGIN_DATA->name:'User Name';?></a>
                </p>
              </li>
              
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= $BASE_URL ?>employee/changepassword" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?= $BASE_URL ?>logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <?php
        $url1=$this->uri->segment(1);
        $url2=$this->uri->segment(2);

        $curr_url=($url2!='')?$url1.'/'.$url2:$url1;
      ?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      <li class="header"></li>
        <?php if(count($MODULE_LIST)>0){ //print_r($MODULE_LIST); die;
            $haveChild='';
          foreach ($MODULE_LIST as  $value) {
            if($value->childlist && count($value->childlist)>0){ ?>
            <?php   $childarray= array(); 
                    $child= array();
                    $childview=array();
                    $i=0;
                    foreach($value->childlist as $key => $values){
                        $childarray[]=$values->url;
                        $child[]=$values->url.'/addedit';
                        $childview[]=$values->url.'/view';
                        $i++;
                        if(checkModulePermission($values->ID)){$haveChild='yes';}
                    }
                   if($haveChild!=''){
            ?>
              <li class="treeview <?php if(in_array($curr_url,$childarray) || in_array($curr_url,$child) || in_array($curr_url,$childview)){ echo 'menu-open' ;}?>">
              <a href="#">
                <i class="fa fa-edit"></i> <span><?= $value->title ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              
                <ul class="treeview-menu" style="<?php if(in_array($curr_url,$childarray) || in_array($curr_url,$child) || in_array($curr_url,$childview)){ echo 'display:block;' ;}?>""> 
                    <?php foreach ($value->childlist as $key => $value) { 
                        if(checkModulePermission($value->ID)){
                        ?>
                     <li class="<?= ($curr_url==$value->url || $curr_url==$value->url.'/addedit' || $curr_url==$value->url.'/view')?'active':'' ?>" ><a href="<?= $BASE_URL ?><?= $value->url ?>"><i class="fa fa-circle-o"></i> <?= $value->title ?></a></li>
                    <?php } }?>
                </ul>
              </li>


            <?php } }
          else{
          if(checkModulePermission($value->ID)){
           ?>
            <li class="<?= ($curr_url==$value->url || $curr_url==$value->url.'/addedit')?'active':'' ?>"><a href="<?= $BASE_URL ?><?= $value->url ?>">
                <i class="<?= $value->icon ?>"></i> <span><?= $value->title ?></span>
              </a>
            </li>
            
        <?php  }
            }
          }
        } ?>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>