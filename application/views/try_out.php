  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Informasi Try Out</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Beranda</a></li>
              <li class="breadcrumb-item active">Informasi Pages</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
              <p>
                <b>Panduan Mengerjakan :</b><br>
                1. Pilih menu "Kerjakan Sekarang"<br>
                2. Pada kolom token, masukan token yang anda dapatkan melalui Email<br>
                3. Jika token anda benar, halaman proses pengerjaan Try Out akan ditampilkan<br>
                <b>Cara mendapatkan token :</b><br>
                1. Kirim permintaan dengan memilih menu "Dapatkan Token"<br>
                2. Cek email anda lakukan pembayaran sesuai dengan nominal yang tertera, Jika tidak masuk di menu Inbox(kotak masuk) silahkan cek di menu Spam<br>
                3. Upload bukti pembayaran dengan memilih menu "Konfirmasi Pembayaran"<br>
                4. Jika pembayaran telah diverifikasi Sistem, akan ada notifikasi email untuk informasi token anda<br>
              </p>
              <?= $token['info'] ?>
              <a href="javascript: void(0)" data-href="<?= $token['href'] ?>" data-title="<?= $token['title'] ?>" class="btn btn-primary btn-block form-load" ><?= $token['label'] ?></a>
            </div>
            <div class="card-body">
              <?php
                $time_limit = 0;
                $total_soal = 0;
                foreach ($rows as $key => $value) {
                  $time_limit += $value->exam_limit;
                  $total_soal += $value->number_of_questions;
                }
              ?>
              <div class="rowX">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="bg-info-gradient border-warning input-group-text">Batas Waktu Pengerjaan</span>
                  </div>
                  <p class="form-control border-warning text-right"><?= $time_limit ?></p>
                  <div class="input-group-prepend">
                    <span class="bg-info-gradient border-warning input-group-text">Menit</span>
                  </div>
                  <div class="input-group-prepend">
                    <span class="bg-info-gradient border-warning input-group-text">Total Soal</span>
                  </div>
                  <p class="form-control border-warning text-right"><?= $total_soal ?></p>
                  <div class="input-group-prepend">
                    <span class="bg-info-gradient border-warning input-group-text">Soal</span>
                  </div>
                  <div class="input-group-prepend">
                    <span class="bg-primary border-warning input-group-text"><a id="tryOut" href="javascript: void(0)" onclick="tryOut()" data-href="<?= base_url('ujian/proses') ?>" data-title="Try Out CAT CPNS" >Kerjakan Sekarang</a></span>
                  </div>
                </div>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kategori Soal</th>
                    <th>Penilaian</th>
                    <th>Jumlah Soal</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  foreach ($rows as $key => $value) {
                    $value->no = ($key+1);
                    $value->penilaian = ($value->true_question=='same'? 'Jika benar poin 5 jika salah poin 0' : 'Setiap jawaban mempunyai poin yang berbeda antara 0-5' );
                    
                    echo "
                      <tr>
                        <td>{$value->no}</td>
                        <td>{$value->title}</td>
                        <td>{$value->penilaian}</td>
                        <td>{$value->number_of_questions}</td>
                      </tr>
                    ";
                  }
                ?>
                
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kategori Soal</th>
                    <th>Penilaian</th>
                    <th>Jumlah Soal</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  function copy_token(){
    /* Get the text field */
    let copyText = document.getElementById("token");
    copyText.select();
    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    alert("Copied the text: " + copyText.value);
  }
  function tryOut() {
    let token = prompt("Please enter your token", "");
    if ( token ) {
      if ( $('#token').val()==token ) {
        loadTryOut( token );
        
        /* triger on modal close */
        $("#myModal").on('hidden.bs.modal', function(){
          loadTryOut( token );
        });
        
      } else {
        alert( 'Maaf token anda salah' )
      }

    } else {
      alert( 'Maaf token tidak boleh kosong' )
    }
  }

  function loadTryOut( token )
  {
    let data = $( '#tryOut' ).data();
    $.get( data.href+`/${token}`, function( d ){
      $( '#myModal .modal-title' ).html( data.title );
      $( '#myModal .modal-body' ).html( d );
      $( '#myModal .modal-dialog' ).addClass( 'modal-lg' );
      $( '#myModal' ).modal( 'show' );
    },'html');
  }
</script>