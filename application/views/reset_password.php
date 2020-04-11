
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Try Out CAT CPNS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="themes/adminlte/maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="themes/adminlte/code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="themes/adminlte/adminlte.io/themes/dev/adminlte/dist/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/iCheck/square/blue.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .login-page {
      /* background: url("<?php echo base_url() ?>src/bg/bg.jpg"); */
      background-repeat: no-repeat;
      background-size: cover;
    }
    .card {
      /* background-color: #ffffff9e !important; */
    }
    .card-body {
      /* background-color: #fff0 !important; */
    }
  </style>
</head>
<body class="hold-transition login-pageXXX" >
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url() ?>"><b>Try Out</b> CAT CPNS</a>
  </div>
  <!-- /.login-logo -->
  <div class="cardXXX">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Reset Password</p>
      <?php
        if ( ! empty($this->session->flashdata('msg')) ) {
          # code...
          echo '
            <div class="alert alert-warning alert-dismissible">
                <h5><i class="icon fa fa-warning"></i> Alert!</h5>
                '.$this->session->flashdata('msg').'
            </div>
          ';
        }
      ?>
      <form action="<?php echo base_url('process-reset-password'); ?>" method="post">
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Masukan password baru" required="">
          <div class="input-group-append">
              <span class="fa fa-user input-group-text"></span>
          </div>
        </div>
        <input type="hidden" name="token" value="<?= $token ?>" required="">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Kirim</button>
      </form>
      <div class="social-auth-links text-center mb-3">
        <p>-- Atau --</p>
        <p class="mb-0">
          Sudah punya akun ? <a href="<?= base_url('auth') ?>" class="text-center">Masuk</a>
        </p>
        <p class="mb-0">
          Belum punya akun ? <a href="<?= base_url('auth/register') ?>" class="text-center">Daftar baru</a>
        </p>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<script src="themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/iCheck/icheck.min.js"></script>
</body>
</html>
