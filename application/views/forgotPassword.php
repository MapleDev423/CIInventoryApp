
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= $this->config->item('COMP_DIR') ?>bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $this->config->item('COMP_DIR') ?>font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= $this->config->item('COMP_DIR') ?>Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $this->config->item('CSS_DIR') ?>AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= $this->config->item('ASSETS_DIR') ?>plugins/iCheck/square/blue.css">

  <link rel="stylesheet" href="<?= $this->config->item('CSS_DIR') ?>style.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><b>Forgot Password</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
   

    <?= form_open_multipart('', 'class="myform" id="myform"'); ?>
      <?= getFlashMsg('success_message'); ?>
      <div class="form-group has-feedback">
        <div class="input-group col-sm-12">
          <input type="email" id="email" name="email" class="form-control email required" placeholder="Enter Email Address" value="<?= getFieldVal('email') ?>">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              <span class="error"><?php if(form_error("email")){echo "<br/>".form_error("email")."<br/>"; } ?></span>
        </div>
        
      </div>
     
      <div class="row">
        <div class="col-sm-12">
        <!-- /.col -->
            <div class="col-sm-3 col-sm-offset-3">
              <input type="submit" class="btn btn-primary" name="submit" value="Submit" >
            </div>
             <div class="col-sm-6">
                 <a href="<?= base_url() ?>" class="btn btn-danger">Back</a>
            </div>
        </div>
        <!-- /.col -->
      </div>
    <?= form_close() ?>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= $this->config->item('COMP_DIR') ?>jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= $this->config->item('COMP_DIR') ?>bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= $this->config->item('ASSETS_DIR') ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?= $this->config->item('JS_DIR') ?>jquery.validate.min.js"></script>
<script src="<?= $this->config->item('JS_DIR') ?>common.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });

validate_form();

</script>
</body>
</html>
