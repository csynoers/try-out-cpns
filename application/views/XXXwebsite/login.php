
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Try Out CAT CPNS | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>themes/adminlte/maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>themes/adminlte/adminlte.io/themes/dev/adminlte/dist/css/adminlte.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>themes/adminlte/adminlte.io/themes/dev/adminlte/plugins/iCheck/square/blue.css">
    <style>
      .login-page {
        /* background: url("<?php echo base_url() ?>src/bg/bg.jpg"); */
        background-repeat: no-repeat;
        background-size: cover;
      }
      .card {
        background-color: #ffffff9e !important;
      }
      .card-body {
        background-color: #fff0 !important;
      }
    </style>
  </head>

  <body class="hold-transition login-page" >
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo base_url() ?>"><b>Try Out</b> CAT CPNS</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in Try Out</p>
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
          <form action="<?php echo base_url('auth/process'); ?>" method="post">
            <div class="input-group mb-3">
              <input name="username" type="text" class="form-control" placeholder="NIK / Username" required="" autocomplete="off">
              <div class="input-group-append">
                  <span class="fa fa-user input-group-text"></span>
              </div>
            </div>
            <div class="input-group mb-3">
              <input name="password" type="password" class="form-control" placeholder="Masukan password" required="" autocomplete="off">
              <div class="input-group-append">
                  <span class="fa fa-lock input-group-text"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="checkbox icheck">
                  <label class="">
                    <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> Ingatkan Saya
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <div class="social-auth-links text-center mb-3">
            <p>- Atau -</p>
            <p class="mb-1">
              <a href="#">Saya lupa password</a>
            </p>
            <p class="mb-0">
              Belum punya akun ? <a href="register.html" class="text-center">Daftar baru</a>
            </p>
          </div>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
  </body>
</html>