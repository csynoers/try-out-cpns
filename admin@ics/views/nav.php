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
      <a href="javascript: void(0)" data-href="<?php echo base_url() ?>user/edit" data-title="Edit Informasi Profil" class="btn btn-default mr-2 form-edit">Profil</a>
      <a href="<?php echo base_url('../auth/logout'); ?>" class="btn btn-default">Logout</a>
      
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
        <i class="fa fa-th-large"></i>
      </a>
    
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
      <img src="<?php echo base_url()?>../themes/adminlte/adminlte.io/themes/dev/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
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
          <li class="nav-item ">
            <a href="<?= base_url() ?>" class="nav-link <?php echo ($this->uri->segment(1)=='dashboard') ? 'active' : null ; ?>">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="<?php echo base_url('pages') ?>" class="nav-link <?php echo ($this->uri->segment(1)=='pages') ? 'active' : null ; ?>">
              <i class="nav-icon fa fa-book"></i>
              <p>
                Pages
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="<?php echo base_url('kategori/soal') ?>" class="nav-link <?php echo ($this->uri->segment(1)=='kategori') ? 'active' : null ; ?>">
              <i class="nav-icon fa fa-clipboard"></i>
              <p>
                Kategori Soal
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="<?php echo base_url('soal/index') ?>" class="nav-link <?php echo ($this->uri->segment(1)=='soal') ? 'active' : null ; ?>">
              <i class="nav-icon fa fa-clipboard"></i>
              <p>
                Soal
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'siswa') ? 'menu-open' : null ; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Siswa
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" >
                <a href="<?php echo base_url('siswa/mendaftar') ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'mendaftar') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Siswa Mendaftar</p>
                </a>
              </li>
              <li class="nav-item" >
                <a href="<?php echo base_url('siswa/terdaftar') ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'terdaftar') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Siswa Terdaftar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('siswa/konfirmasi')?>" class="nav-link <?php echo ($this->uri->segment(2) == 'data-pelajaran') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Konfirmasi Pembayaran</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php echo ($this->uri->segment(1) == 'hasil') ? 'menu-open' : null ; ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-calendar-check-o"></i>
              <p>
                Hasil Try Out
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" >
                <a href="<?php echo base_url('hasil/index') ?>" class="nav-link <?php echo ($this->uri->segment(2) == 'index') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Semua Hasil Try Out</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('hasil/lulus')?>" class="nav-link <?php echo ($this->uri->segment(2) == 'lulus') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Lulus Try Out</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url('hasil/tidak-lulus')?>" class="nav-link <?php echo ($this->uri->segment(2) == 'tidak-lulus') ? 'active' : null ; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Tidak Lulus Try Out</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item ">
            <a href="<?php echo base_url('ujian/konfigurasi') ?>" class="nav-link <?php echo ($this->uri->segment(2)=='konfigurasi') ? 'active' : null ; ?>">
              <i class="nav-icon fa fa-gears"></i>
              <p>
                Konfigurasi Ujian
              </p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="<?php echo base_url('bank') ?>" class="nav-link <?php echo ($this->uri->segment(1)=='bank') ? 'active' : null ; ?>">
              <i class="nav-icon fa fa-credit-card"></i>
              <p>
                Bank Transfer
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>