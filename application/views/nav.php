<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>
    <table>
      <tr style="border-bottom: 1px solid #ddd;">
        <td id="tglSekarang" colspan="4"></td>
      </tr>
      <tr>
        <td>Jam </td>
        <td id="jam"></td>
        <td id="menit"></td>
        <td id="detik"></td>
      </tr>
    </table>

    <!-- Right navbar links -->
    <div class="navbar-nav ml-auto">
      <?php
        if( $this->session->userdata('user') )
        {
          echo '<a href="'.base_url('auth/logout').'" class="btn btn-default mr-3">Profil</a>';
          echo '<a href="'.base_url('auth/logout').'" class="btn btn-default">Logout</a>';
        }
      ?>
      
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
        <i class="fa fa-th-large"></i>
      </a>
    
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url() ?>" class="brand-link">
      <img src="<?php echo base_url()?>/themes/adminlte/adminlte.io/themes/dev/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Try Out CAT CPNS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php
            foreach ($pages as $key => $value) {
              $active = NULL;
              if ( $this->uri->segment(1)=='pages' && $this->uri->segment(2)==$value->slug ) {
                $active = 'active';
              }else {
                if ( empty($this->uri->segment(1)) ) {
                  # code...
                }
              }
              echo '
                <li class="nav-item ">
                  <a href="'.base_url('pages/'.$value->slug).'" class="nav-link '.( $active ).'">
                    <i class="nav-icon fa fa-bookmark-o"></i>
                    <p>
                      '.$value->title.'
                    </p>
                  </a>
                </li>
              ';
            }
          ?>
          <?php
            if( $this->session->userdata('user') )
            {
              echo '
                <li class="nav-item ">
                  <a href="'.base_url('ujian').'" class="nav-link">
                    <i class="nav-icon fa fa-sign-out"></i>
                    <p>
                      Try Out
                    </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="'.base_url().'" class="nav-link">
                    <i class="nav-icon fa fa-sign-out"></i>
                    <p>
                      Hasil Try Out
                    </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a href="'.base_url('auth/logout').'" class="nav-link">
                    <i class="nav-icon fa fa-sign-out"></i>
                    <p>
                      Logout
                    </p>
                  </a>
                </li>
              ';
            } else {
              echo '
                <li class="nav-item ">
                  <a href="'.base_url('auth').'" class="nav-link">
                    <i class="nav-icon fa fa-sign-in"></i>
                    <p>
                      Login
                    </p>
                  </a>
                </li>
              ';
            }
          ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>