<?php 
class Siswa extends MY_Controller{
    /**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
        parent::__construct();
		
		if( !$this->session->userdata('root') ){
			redirect(base_url('admin@ics'));
        }

		
        $this->load->model('M_users');
    }

    public function mendaftar()
    {
        $data['rows'] = $this->M_users->mendaftar();
		$this->render_pages( 'siswa/mendaftar', $data );
    }

    public function terdaftar()
    {
        $data['rows'] = $this->M_users->terdaftar();
		$this->render_pages( 'siswa/terdaftar', $data );
    }

    public function konfirmasi()
    {
		if ( $this->uri->segment(3) ) {
			# code...
			$this->load->helper('rupiah_helper');
			$row_user_configs = $this->M_users->mendaftar( $this->uri->segment(3) )[0];

			$data['action']   		= base_url();		
			$data['data_action']  	= base_url() .'siswa/konfirmasi_store/' .$row_user_configs->exam_user_config_id;		
			
			$controlBtnKOnfirmasi = NULL;
			if ( $this->uri->segment(4) ) {
				$controlBtnKOnfirmasi = 'hide';
			}
			$html= "
				<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<span class='input-group-text'>Sudah melakukan pembayaran sebesar</span>
						</div>
						<span class='form-control text-right'>Rp. ".rupiah($row_user_configs->total_payment)."</span>
						<div class='input-group-prepend'>
							<span class='input-group-text text-info'>(tidak kurang tidak lebih)</span>
						</div>
					</div>
					<div class='form-group'>
						<label>Bank transfer ke :</label>
						<span class='form-control'>{$row_user_configs->bank_transfer}</span>
					</div>
					<div class='form-group'>
						<label>Bukti pembayaran :</label>
						<img class='img-fluid mx-auto d-block' src='".base_url("../src/proof_payments/{$row_user_configs->proof_payment}")."' alt='Bukti Pembayaran'>
					</div>
					<input type='hidden' name='total_payment' value='{$row_user_configs->total_payment}'>
					<button type='submit' class='btn btn-primary btn-block {$controlBtnKOnfirmasi}'>Konfirmasi Pembayaran</button>
				</form>
			";
			echo $html;
		} else {
			# code...
			$data['rows'] = $this->M_users->konfirmasi();
			$this->render_pages( 'siswa/konfirmasi', $data );
		}
		
	}
	
	public function konfirmasi_store()
	{
		$this->M_users->post = $this->input->post();
		$this->M_users->post['token'] = (int) date('ymd').substr($this->input->post('total_payment'), -3);
		if ( $this->M_users->konfirmasi_store($this->uri->segment(3)) ) {
			$this->msg= [
				'stats'=> 1,
				'msg'=> 'Pembayaran berhasil dikonfirmasi',
			];
		} else {
			$this->msg= [
				'stats'=> 0,
				'msg'=> 'Pembayaran gagal dikonfirmasi',
			];
		}
		echo json_encode( $this->msg );

	}
}